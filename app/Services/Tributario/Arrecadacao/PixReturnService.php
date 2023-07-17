<?php

namespace App\Services\Tributario\Arrecadacao;

use App\Models\Cadban;
use App\Models\Cfautent;
use App\Models\Disarq;
use App\Models\Disbanco;
use App\Models\Discla;
use App\Models\RecibopagaQrcodePix;
use App\Services\Tributario\Contabilidade\WriteOfAuthenticateBankService;
use BusinessException;
use Exception;
use Illuminate\Database\Capsule\Manager as DB;
use ParameterException;
use Throwable;

class PixReturnService
{
    private Disarq $disarc;
    private Disbanco $disbanco;
    private Discla $discla;
    private Cfautent $cfautent;
    private int $userId;
    private int $institId;
    private \DateTime $time;
    private WriteOfAuthenticateBankService $authenticateBankService;

    private const TERMINAL = '127.0.0.1';

    public function __construct(int $userId, int $institId = 1)
    {
        $this->disarc = new Disarq();
        $this->disbanco = new Disbanco();
        $this->discla = new Discla();
        $this->cfautent = new Cfautent();
        $this->userId = $userId;
        $this->institId = $institId;
    }

    /**
     * @throws Exception
     * @throws Throwable
     */
    public function execute(array $data): void
    {
        $code = $data['endToEndId'];
        $this->time = new \DateTime($data['horario']);
        $recibopagaQrcodePix = RecibopagaQrcodePix::ofCodigoConciliacaoRecebedor($code)->first();

        if (empty($recibopagaQrcodePix)) {
            return;
        }

        $numpre = !empty($recibopagaQrcodePix->k176_numnov) ? $recibopagaQrcodePix->k176_numnov : $recibopagaQrcodePix->k176_numpre;
        $numpar = !empty($recibopagaQrcodePix->k176_numpar) ? $recibopagaQrcodePix->k176_numpar : 0;
        $valor = (float) $data['valor'];

        try {
            db_inicio_transacao();
            $this->includeDisAarq($recibopagaQrcodePix->k176_instituicao_financeira);
            $this->includeDisbanco($numpre, $numpar, $valor);
            $this->executeProcedure();
            $this->createCfautent();
            $this->authenticate();
        } catch (Exception $exception) {
            db_fim_transacao(true);
            throw new Exception('Falha na baixa de banco do PIX: '. $exception->getMessage());
        }
        db_fim_transacao();
    }

    /**
     * @throws Throwable
     */
    private function includeDisAarq(int $bankId): void
    {
        $cadban = Cadban::ofBankId($bankId)->first();
        $this->disarc->k15_codbco = $cadban->k15_codbco;
        $this->disarc->k15_codage = $cadban->k15_codage;
        $this->disarc->arqret = "ARRECADAÇÃO VIA PIX";
        $this->disarc->dtretorno = $this->time->format('Y-m-d');
        $this->disarc->dtarquivo = date('Y-m-d');
        $this->disarc->k00_conta = $cadban->k15_conta;
        $this->disarc->id_usuario = $this->userId;
        $this->disarc->instit = $this->institId;
        $this->disarc->codret = $this->disarc->getNextval();
        $this->disarc->save();
    }

    /**
     * @throws Throwable
     */
    private function includeDisbanco(int $numpre, int $numpar, float $valor): void
    {
        $this->disbanco->k15_codbco = $this->disarc->k15_codbco;
        $this->disbanco->k15_codage = $this->disarc->k15_codage;
        $this->disbanco->codret = $this->disarc->codret;
        $this->disbanco->dtarq = date('Y-m-d');
        $this->disbanco->dtpago = $this->time->format('Y-m-d');
        $this->disbanco->dtcredito = $this->time->format('Y-m-d');
        $this->disbanco->vlrpago = $valor;
        $this->disbanco->vlrjuros = 0;
        $this->disbanco->vlrmulta = 0;
        $this->disbanco->vlracres = 0;
        $this->disbanco->vlrdesco = 0;
        $this->disbanco->vlrtot = $valor;
        $this->disbanco->vlrcalc = $valor;
        $this->disbanco->k00_numpre = $numpre;
        $this->disbanco->k00_numpar = $numpar;
        $this->disbanco->instit = $this->institId;
        $this->disbanco->idret = $this->disbanco->getNextval();
        $this->disbanco->save();
    }

    /**
     * @throws Exception
     */
    private function executeProcedure(): void
    {
        $sql = "
                select fc_putsession('DB_instit','".$this->institId."');
                select fc_putsession('DB_anousu','".date("Y")."');
                select fc_putsession('DB_id_usuario','1');
                select fc_putsession('DB_datausu','".date("Y-m-d")."');
                select fc_putsession('DB_use_pcasp','t');
                select fc_executa_baixa_banco({$this->disarc->codret},'".date("Y-m-d")."') as result
        ";

        $result = DB::connection()
            ->unprepared($sql);

        if (!$result) {
            throw new Exception(str_replace("\n","",substr(pg_last_error(), 0, strpos(pg_last_error(),"CONTEXT"))));
        }
    }

    /**
     * @throws BusinessException
     * @throws ParameterException
     * @throws Exception
     */
    private function authenticate(): void
    {
        $discla = $this->discla->getByCodret($this->disarc->codret);
        $this->authenticateBankService = new WriteOfAuthenticateBankService($discla->codcla, $this->time, $this->userId, self::TERMINAL, $this->institId);
        $this->authenticateBankService->execute();
    }

    private function executeCountability(): void
    {

    }

    private function createCfautent()
    {
        $this->cfautent = Cfautent::firstOrCreate(
            ['k11_ipterm' => self::TERMINAL],
            [
                'k11_id' => $this->cfautent->getNextval(),
                'k11_ident1' => 'p',
                'k11_ident2' => 'd',
                'k11_ident3' => 'D',
                'k11_local' => 'ARRECADACAO VIA PIX',
                'k11_instit' => $this->institId,
                'k11_tipoimp' => '2',
                'k11_tipoimpcheque' => '5'
            ]
        );
    }
}