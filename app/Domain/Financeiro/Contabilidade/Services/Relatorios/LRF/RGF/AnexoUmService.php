<?php

namespace App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\RGF;

use App\Domain\Configuracao\Instituicao\Model\DBConfig;
use App\Domain\Financeiro\Contabilidade\Factories\AnexoTresFactory;
use App\Domain\Financeiro\Contabilidade\Relatorios\LRF\RGF\XlsAnexoUm;
use App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\AnexosExecucaoMensalService;
use App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\RREO\AnexoTres\AnexoTresService;
use Exception;

abstract class AnexoUmService extends AnexosExecucaoMensalService
{
    /**
     * @var XlsAnexoUm
     */
    protected $parser;

    protected $colunaMesDespesa = [
        'mes_1' => 'liquidado',
        'mes_2' => 'liquidado',
        'mes_3' => 'liquidado',
        'mes_4' => 'liquidado',
        'mes_5' => 'liquidado',
        'mes_6' => 'liquidado',
        'mes_7' => 'liquidado',
        'mes_8' => 'liquidado',
        'mes_9' => 'liquidado',
        'mes_10' => 'liquidado',
        'mes_11' => 'liquidado',
        'mes_12' => 'liquidado',
    ];

    protected $colunaMesReceita = [
        'mes_1' => 'arrecadado_periodo',
        'mes_2' => 'arrecadado_periodo',
        'mes_3' => 'arrecadado_periodo',
        'mes_4' => 'arrecadado_periodo',
        'mes_5' => 'arrecadado_periodo',
        'mes_6' => 'arrecadado_periodo',
        'mes_7' => 'arrecadado_periodo',
        'mes_8' => 'arrecadado_periodo',
        'mes_9' => 'arrecadado_periodo',
        'mes_10' => 'arrecadado_periodo',
        'mes_11' => 'arrecadado_periodo',
        'mes_12' => 'arrecadado_periodo',
    ];

    /**
     * Mapa das linhas que totaliza outras linhas
     * @var \int[][]
     */
    protected $totalizar = [];
    /**
     * Mapa das linhas que v�o para o anexo simplificado
     * Esse array � indexado pela ordem da linha e seu valor � a descri��o.
     * @example
     * [
     *  29 => 'nome da coluna no simplificado'
     * ]
     * @var array
     */
    protected $linhasSimplificado = [];

    protected $linhasOrganizadas = [];

    /**
     * @param $filtros
     * @throws Exception
     */
    public function __construct($filtros)
    {
        $this->exercicio = $filtros['DB_anousu'];
        $this->emissor = \InstituicaoRepository::getInstituicaoByCodigo($filtros['DB_instit']);
        $this->constructAssinaturas($filtros['DB_instit']);
        $this->constructInstituicoes(DBConfig::whereIn('codigo', $filtros['instituicoes'])->get());
        $this->constructPeriodo($filtros['periodo']);
        $this->getMesesProcessar();
        $this->constructRelatorio($filtros['codigo_relatorio']);

        $this->processaEnteFederativo();
    }

    public function emitir()
    {
        $this->processar();

        foreach ($this->linhasOrganizadas as $section => $linhas) {
            $this->parser->addCollection($section, $linhas);
        }

        $mesesProcessar = $this->getMesesProcessar();

        foreach ($mesesProcessar as $mesProcessar) {
            $mes = "{$mesProcessar->nome_abreviado}/{$mesProcessar->ano}";
            $this->parser->setVariavel($mesProcessar->coluna, $mes);
        }

        $mes1 = $mesesProcessar[0];
        $mes12 = $mesesProcessar[11];

        $mesesPeriodo = sprintf(
            '%s - %s',
            "{$mes1->nome}/{$mes1->ano}",
            "{$mes12->nome}/{$mes12->ano}"
        );
        $this->parser->setVariavel('exercicio', $this->exercicio);
        $this->parser->setEnteFederativo($this->enteFederativo);
        $this->parser->setEmissor($this->emissor);
        $this->parser->setPeriodo($this->periodo->getDescricao());
        $this->parser->setAnoReferencia($this->exercicio);
        $this->parser->setMesesPeriodo($mesesPeriodo);
        $this->parser->setNotaExplicativa($this->getNotaExplicativa());
        $this->parser->setNomePrefeito($this->assinatura->assinaturaPrefeito());
        $this->parser->setNomeContador($this->assinatura->assinaturaContador());
        $this->parser->setNomeOrdenador($this->assinatura->assinaturaSecretarioFazenda());

        $filename = $this->parser->gerar();

        return [
            'xls' => $filename,
            'xlsLinkExterno' => ECIDADE_REQUEST_PATH . $filename
        ];
    }

    public function processar()
    {
        $this->processarPeriodo();
        $this->processarMensal();
        $this->criaProriedadesValor();
        $this->totalizarLinhas();
        $this->processarLinhasRCL();
        $this->organizaLinhas();
    }

    /**
     * Essa fun��o � para calcular as colunas que s�o do per�odo selecionado
     * @return
     */
    abstract protected function processarPeriodo();

    abstract protected function processarMensal();

    abstract protected function processarLinhasRCL();

    private function totalizarLinhas()
    {
        $this->calcularTotalUltimos12Meses();
        $this->calcularLinhasTotalizadorasMensais();
        $this->totalizaColunaRPNaoProcessado();
        $this->posTotalizarLinhas();
    }

    /**
     * Encapsular lista de fun��es de c�lculos das linhas que ser� executada ap�s somar
     * Exemplo as subtra��es das linhas
     * @return mixed
     */
    abstract protected function posTotalizarLinhas();

    protected function calculaLinhaSubtracao($a, $b, $c)
    {
        $linhaA = $this->linhas[$a];
        $linhaB = $this->linhas[$b];
        $linhaC = $this->linhas[$c];
        $mesesProcessar = $this->getMesesProcessar();
        foreach ($mesesProcessar as $mes) {
            $linhaA->{$mes->coluna} = $linhaB->{$mes->coluna} - $linhaC->{$mes->coluna};
        }
        $linhaA->total_meses = $linhaB->total_meses - $linhaC->total_meses;
        $rpNaoProcessadoLinhaC = $linhaC->inscricao_menos_anulacao_rp_nao_processado;
        $rpNaoProcessadoLinhaB = $linhaB->inscricao_menos_anulacao_rp_nao_processado;
        $linhaA->inscricao_menos_anulacao_rp_nao_processado = $rpNaoProcessadoLinhaB - $rpNaoProcessadoLinhaC;
    }

    /**
     * @return void
     */
    private function totalizaColunaRPNaoProcessado()
    {
        // realiza a soma das linhas
        foreach ($this->totalizar as $linha => $somar) {
            $linhaTotalizar = $this->linhas[$linha];
            foreach ($somar as $idLinhaSoma) {
                $somar = $this->linhas[$idLinhaSoma]->inscricao_menos_anulacao_rp_nao_processado;
                $linhaTotalizar->inscricao_menos_anulacao_rp_nao_processado += $somar;
            }
        }
    }

    /**
     * Calcula o valor percentual da linha em cima do valor da RCL
     * @param \stdClass $linha linha do relat�rio
     * @param float $valorRCL
     * @return void
     */
    protected function calculaPercentualRCL($linha, $valorRCL)
    {
        $linha->percentual = round((($linha->total_meses * 100) / $valorRCL), 2);
    }

    /**
     * @return AnexoTresService
     * @throws Exception
     */
    protected function getServiceRCL()
    {
        $filtros = [
            'codigo_relatorio' => AnexoTresFactory::getCodigoRelatorio($this->exercicio),
            'periodo' => AnexoTresFactory::transformPeriodo($this->periodo->getCodigo()),
            'DB_anousu' => $this->exercicio,
            'DB_instit' => $this->emissor->getCodigo()
        ];

        return AnexoTresFactory::getService($this->exercicio, $filtros);
    }

    abstract public function processaLinhasSimplificado();

    /**
     * Processa a coluna de RP.
     */
    protected function processaRP()
    {
        $restos = $this->buscaDadosRP();
        foreach ($this->linhas as $linha) {
            if (in_array($linha->ordem, $this->linhasNaoProcessar)) {
                continue;
            }
            $this->processaRestoPagar($restos, $linha);
        }
    }

    protected function buscaDadosRP()
    {
        $exercicio = $this->exercicio;
        if (in_array($this->periodo->getCodigo(), [13, 16, 28])) {
            $exercicio++;
        }
        $dataInicio = "{$exercicio}-01-01";
        $dataFim = sprintf('%s-%s-%s', $exercicio, $this->dataFim->getMes(), $this->dataFim->getDia());
        return $this->executarRestosPagar($exercicio, $dataInicio, $dataFim);
    }
}
