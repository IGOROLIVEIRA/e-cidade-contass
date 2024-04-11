<?php

namespace App\Services\Patrimonial\Aditamento;

use App\Domain\Patrimonial\Aditamento\Factory\AditamentoFactory;
use App\Repositories\Patrimonial\AcordoPosicaoRepository;
use App\Services\Contracts\Patrimonial\Aditamento\AditamentoServiceInterface;
use App\Services\Patrimonial\Aditamento\Command\GetUltimaPosicaoCommand;
use App\Services\Patrimonial\Aditamento\Command\UpdateAditamentoCommand;
use App\Services\Patrimonial\Aditamento\Command\ValidaDataAssinaturaCommand;
use App\Services\Patrimonial\Aditamento\Command\VerificaAnulacaoAutorizacaoCommand;
use Exception;
use stdClass;

class AditamentoService implements AditamentoServiceInterface
{
    /**
     * @var AcordoPosicaoRepository
     */
    private AcordoPosicaoRepository $acordoPosicaoRepository;

    public function __construct()
    {
        $this->acordoPosicaoRepository = new AcordoPosicaoRepository();
    }

    /**
     *
     * @param integer $ac16Sequencial
     * @return array
     */
    public function getDadosAditamento(int $ac16Sequencial): array
    {
        $acordoPosicao = $this->acordoPosicaoRepository->getAditamentoUltimaPosicao($ac16Sequencial);

        $lastIdApostila = $this->acordoPosicaoRepository->getUltimoIdApostilmentoByAcordo($ac16Sequencial);
        if (!empty($lastIdApostila) && $lastIdApostila > $acordoPosicao->ac26_sequencial) {
            return [
                'status' => false,
                'message' => 'Existe apostilamento posterior ao último aditivo. Não é possível alterar.'
            ];
        }

        $acordoPosicaoAnterior = GetUltimaPosicaoCommand::execute(
            $this->acordoPosicaoRepository,
            $acordoPosicao,
            $ac16Sequencial
        );

        $temAnulacao = ( new VerificaAnulacaoAutorizacaoCommand())->execute($acordoPosicaoAnterior);
        if ($temAnulacao) {
            return [
                'status' => false,
                'message' => 'Existe anulação na posição anterior.Será necessário criar novo aditivo.'
            ];
        }

        $aditamentoFactory = new AditamentoFactory();
        $aditamento = $aditamentoFactory->createByEloquentModel($acordoPosicao, $acordoPosicaoAnterior);

        $seriealizer = new AditamentoSerializeService($aditamento);

        return ['status'=> true,'aditamento' => $seriealizer->jsonSerialize()];
    }

    public function updateAditamento(stdClass $aditamentoRaw): array
    {
        try {
            $aditamentoFactory = new AditamentoFactory();
            $aditamento = $aditamentoFactory->createByStdLegacy($aditamentoRaw);

            (new ValidaDataAssinaturaCommand())->execute($aditamento);

            $updateCommand = new UpdateAditamentoCommand();
            $result = $updateCommand->execute($aditamento);

            if ($result === false) {
                throw new Exception("Não foi possivel atualizar");
            }

            return ['status' => true];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}
