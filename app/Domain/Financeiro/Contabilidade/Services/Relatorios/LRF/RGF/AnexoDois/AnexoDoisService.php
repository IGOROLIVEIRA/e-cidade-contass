<?php

namespace App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\RGF\AnexoDois;

use App\Domain\Configuracao\Instituicao\Model\DBConfig;
use App\Domain\Financeiro\Contabilidade\Factories\AnexoTresFactory;
use App\Domain\Financeiro\Contabilidade\Factories\TemplateFactory;
use App\Domain\Financeiro\Contabilidade\Relatorios\LRF\RGF\XlsAnexoDois;
use App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\AnexosService;
use App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\RREO\AnexoTres\AnexoTresService;
use DBDate;
use Exception;
use Periodo;

/**
 *
 */
class AnexoDoisService extends AnexosService
{
    protected $colunasVerificacao = [
        'saldo_anterior_acumulado' => 'saldo_anterior_acumulado',
        'saldo_final_acumulado' => 'primeiro_periodo',
    ];

    protected $colunasRp = [
        "inscricao_rp_processado" => "inscricao_rp_processado",
        'saldo_rp_processado' => 'primeiro_periodo',
    ];
    /**
     * Mapeia a ordem de execu��o dos per�odos conforme o per�odo selecionado
     * @var \int[][]
     */
    protected $periodosProcessar = [
        12 => [12],
        13 => [12, 13],
        14 => [14],
        15 => [14, 15],
        16 => [14, 15, 16]
    ];

    /**
     * Mapeia a coluna que o valor ser� atribu�do de acordo com o per�odo executado
     * @var string[]
     */
    protected $colunaSaldoFinalPeriodo = [
        12 => 'primeiro_periodo',
        13 => 'segundo_periodo',
        14 => 'primeiro_periodo',
        15 => 'segundo_periodo',
        16 => 'terceiro_periodo',
    ];

    protected $linhasNaoProcessar = [1, 3, 4, 8, 11, 20, 21, 26, 27, 28, 29, 30, 31, 32, 33];

    protected $totalizarSoma = [
        3 => [5, 6, 7],
        4 => [5, 6],
        8 => [9, 10],
        11 => [12, 13, 14, 15, 16],
    ];

    protected $totalizarSubtracao = [
        21 => [22, 23, 24],
    ];

    protected $sections = [
        'verificacao_1' => [1, 28],
        'verificacao_2' => [34, 40],
    ];

    /**
     * @var integer
     */
    private $instituicaoSessao;

    /**
     * @param $filtros
     * @throws Exception
     */
    public function __construct($filtros)
    {
        $template = TemplateFactory::getTemplate(
            $filtros['codigo_relatorio'],
            $filtros['periodo']
        );

        $this->parser = new XlsAnexoDois($template);

        $this->instituicaoSessao = $filtros['DB_instit'];
        $this->exercicio = $filtros['DB_anousu'];
        $this->emissor = \InstituicaoRepository::getInstituicaoByCodigo($filtros['DB_instit']);
        $this->constructAssinaturas($filtros['DB_instit']);
        $this->constructInstituicoes(DBConfig::whereIn('codigo', $filtros['instituicoes'])->get());
        $this->constructPeriodo($filtros['periodo']);

        $this->constructRelatorio($filtros['codigo_relatorio']);

        $this->processaEnteFederativo();
    }

    public function emitir()
    {
        $this->processar();

        $mesesPeriodo = sprintf(
            '%s - %s',
            DBDate::getMesExtenso($this->periodo->getMesInicial()),
            DBDate::getMesExtenso($this->periodo->getMesFinal())
        );
        $this->parser->setEnteFederativo($this->enteFederativo);
        $this->parser->setEmissor($this->emissor);
        $this->parser->setPeriodo($this->periodo->getDescricao());
        $this->parser->setAnoReferencia($this->exercicio);
        $this->parser->setExercicioAnterior($this->exercicio - 1);
        $this->parser->setMesesPeriodo($mesesPeriodo);
        $this->parser->setNotaExplicativa($this->getNotaExplicativa());
        $this->parser->setNomePrefeito($this->assinatura->assinaturaPrefeito());
        $this->parser->setNomeContador($this->assinatura->assinaturaContador());
        $this->parser->setNomeOrdenador($this->assinatura->assinaturaSecretarioFazenda());

        foreach ($this->linhasOrganizadas as $section => $linhas) {
            $this->parser->addCollection($section, $linhas);
        }

        $filename = $this->parser->gerar();

        return [
            'xls' => $filename,
            'xlsLinkExterno' => ECIDADE_REQUEST_PATH . $filename
        ];
    }

    public function getSimplificado()
    {
        $this->processar();
        return $this->simplificado();
    }

    protected function processar()
    {
        $this->processarPeriodos();
        $this->criaProriedadesValor();

        // subtrai da linha 23 os valores de RP intra or�ament�rio
        $this->linhas[23]->saldo_anterior_acumulado -= $this->linhas[41]->inscricao_rp_processado;
        $periodosProcessar = $this->periodosProcessar[$this->periodo->getCodigo()];
        foreach ($periodosProcessar as $codigoPeriodo) {
            $coluna = $this->colunaSaldoFinalPeriodo[$codigoPeriodo];
            $this->linhas[23]->$coluna -= $this->linhas[41]->$coluna;
        }

        $this->processarRCL();
        $this->totalizar();

        $this->organizaLinhas();
    }

    protected function datasPeriodo($codigo)
    {
        $periodo = new Periodo($codigo);

        return [
            'inicio' => $periodo->getDataInicial($this->exercicio)->getDate(),
            'fim' => $periodo->getDataFinal($this->exercicio)->getDate()
        ];
    }

    /**
     *
     */
    protected function processarPeriodos()
    {
        $periodosProcessar = $this->periodosProcessar[$this->periodo->getCodigo()];

        foreach ($periodosProcessar as $codigoPeriodo) {
            $this->processaBalancete($codigoPeriodo);
            $this->processaRP($codigoPeriodo);

            // s� calcula o saldo do exerc�cio anterior na primeira vez
            if (!in_array($codigoPeriodo, [12, 14])) {
                unset($this->colunasVerificacao['saldo_anterior_acumulado']);
            }

            $this->colunasVerificacao['saldo_final_acumulado'] = $this->colunaSaldoFinalPeriodo[$codigoPeriodo];
            $this->colunasRp['saldo_rp_processado'] = $this->colunaSaldoFinalPeriodo[$codigoPeriodo];

            foreach ($this->linhas as $linha) {
                if (in_array($linha->ordem, $this->linhasNaoProcessar)) {
                    continue;
                }

                if ((int)$linha->origem === self::ORIGEM_VERIFICACAO) {
                    $this->processaBalanceteVerificacao($this->balanceteVerificacao, $linha);
                }

                if ((int)$linha->origem === self::ORIGEM_RP) {
                    $this->somandoRestoPagar($this->restosPagar, $linha, $codigoPeriodo);
                }
            }
        }

        $this->processaValoresManuais($this->linhas);
    }

    /**
     * @param integer $codigoPeriodo
     */
    protected function processaBalancete($codigoPeriodo)
    {
        $datas = $this->datasPeriodo($codigoPeriodo);
        $this->balanceteVerificacao = $this->executarBalanceteVerificacao(
            $this->exercicio,
            $datas['inicio'],
            $datas['fim']
        );
        return $this->balanceteVerificacao;
    }

    /**
     * Busca os dados da RCL do Anexo III da RREO e atribui o valor nas linas;
     * @throws Exception
     */
    private function processarRCL()
    {
        $exercicioAnterior = $this->exercicio - 1;
        $simplificadoExercicioAnterior = $this->getDadosSimplificadoRCL(Periodo::SEGUNDO_SEMESTRE, $exercicioAnterior);
        $this->linhas[27]->saldo_anterior_acumulado = $simplificadoExercicioAnterior[0]->ate_bimestre;
        $this->linhas[28]->saldo_anterior_acumulado = $simplificadoExercicioAnterior[1]->ate_bimestre;

        $periodosProcessar = $this->periodosProcessar[$this->periodo->getCodigo()];
        foreach ($periodosProcessar as $codigoPeriodo) {
            $nomeColuna = $this->colunaSaldoFinalPeriodo[$codigoPeriodo];
            $simplicicadoPeriodo = $this->getDadosSimplificadoRCL($codigoPeriodo, $this->exercicio);
            $this->linhas[27]->{$nomeColuna} = $simplicicadoPeriodo[0]->ate_bimestre;
            $this->linhas[28]->{$nomeColuna} = $simplicicadoPeriodo[1]->ate_bimestre;
        }
    }

    /**
     * Busca o service do Anexo III RCL
     * @param $codigoPeriodo
     * @param $exercicio
     * @return AnexoTresService
     * @throws Exception
     */
    private function getServiceRCL($codigoPeriodo, $exercicio)
    {
        $filtros = [
            'codigo_relatorio' => AnexoTresFactory::getCodigoRelatorio($this->exercicio),
            'periodo' => AnexoTresFactory::transformPeriodo($codigoPeriodo),
            'DB_anousu' => $exercicio,
            'DB_instit' => $this->instituicaoSessao
        ];

        return AnexoTresFactory::getService($this->exercicio, $filtros);
    }

    /**
     * Retorna os dados simplificados da RCL
     * @param $codigoPeriodo
     * @param $exercicio
     * @return array
     * @throws Exception
     */
    protected function getDadosSimplificadoRCL($codigoPeriodo, $exercicio)
    {
        $service = $this->getServiceRCL($codigoPeriodo, $exercicio);
        return $service->processaLinhasSimplificadoCompleto();
    }

    protected function totalizar()
    {
        $this->calcularSoma();
        $this->calcularSubtracao();

        $this->validarDisponibilidadeDeCaixaNegativa();

        $this->somarLinha(20, [21, 25]);
        $this->somarLinha(1, [2, 3, 18, 19]);

        // calcula percentual da RCL
        $this->calcularPercentualLinha($this->linhas[30], $this->linhas[1], $this->linhas[27]);
        $this->calcularPercentualLinha($this->linhas[31], $this->linhas[26], $this->linhas[27]);

        // LIMITE DEFINIDO POR RESOLU��O DO SENADO FEDERAL - 120%
        $this->calculaLinhaLimite($this->linhas[32], $this->linhas[27], 1.2);
        // LIMITE DE ALERTA (inciso III do � 1� do art. 59 da LRF) - 108%
        $this->calculaLinhaLimite($this->linhas[33], $this->linhas[27], 1.08);
    }

    /**
     * Aplica regra da Nota explicativa do relat�rio, onde n�o podemos apresentar negativo o valor de
     * Disponibilidade de Caixa
     */
    protected function validarDisponibilidadeDeCaixaNegativa()
    {
        if ($this->linhas[21]->saldo_anterior_acumulado < 0) {
            $valor = $this->linhas[21]->saldo_anterior_acumulado;
            $this->linhas[21]->saldo_anterior_acumulado = 0;
            $this->linhas[19]->saldo_anterior_acumulado += $valor;
        }

        $colunas = $this->linhas[21]->colunas;
        foreach ($colunas as $dadoColuna) {
            if ($this->linhas[21]->{$dadoColuna->coluna} < 0) {
                $valor = $this->linhas[21]->{$dadoColuna->coluna};
                $this->linhas[21]->{$dadoColuna->coluna} = 0;
                $this->linhas[19]->{$dadoColuna->coluna} += $valor;
            }
        }
    }

    /**
     * Realiza o calculo percentual da RCL
     * @param $linha
     * @param $linhaCalculo
     * @param $linhaRCL
     */
    protected function calcularPercentualLinha($linha, $linhaCalculo, $linhaRCL)
    {
        $valor = $linhaCalculo->saldo_anterior_acumulado;
        if ($valor > 0) {
            $linha->saldo_anterior_acumulado = ($valor / $linhaRCL->saldo_anterior_acumulado) * 100;
        }

        $periodosProcessar = $this->periodosProcessar[$this->periodo->getCodigo()];
        foreach ($periodosProcessar as $codigoPeriodo) {
            $nomeColuna = $this->colunaSaldoFinalPeriodo[$codigoPeriodo];
            $valor = $linhaCalculo->{$nomeColuna};
            if ($valor > 0) {
                $linha->{$nomeColuna} = ($valor / $linhaRCL->{$nomeColuna}) * 100;
            }
        }
    }

    /**
     * @param \stdClass $linha linha alvo
     * @param \stdClass $linhaRCL linha da RCL
     * @param float $percentual valor percentual
     */
    protected function calculaLinhaLimite(\stdClass $linha, \stdClass $linhaRCL, $percentual)
    {
        $linha->saldo_anterior_acumulado = $linhaRCL->saldo_anterior_acumulado * $percentual;
        $periodosProcessar = $this->periodosProcessar[$this->periodo->getCodigo()];
        foreach ($periodosProcessar as $codigoPeriodo) {
            $nomeColuna = $this->colunaSaldoFinalPeriodo[$codigoPeriodo];
            $linha->{$nomeColuna} = $linhaRCL->{$nomeColuna} * $percentual;
        }
    }

    protected function simplificado()
    {
        $coluna = $this->colunaSaldoFinalPeriodo[$this->periodo->getCodigo()];
        $valor = $this->linhas[26]->{$coluna};
        $percentual = $this->linhas[31]->{$coluna};

        $valorLimite = $this->linhas[32]->{$coluna};

        return [
            $this->createStdSimplificado('D�vida consolidada l�quida', $valor, $percentual),
            $this->createStdSimplificado('Limite Definido por Resolu��o do Senado Federal', $valorLimite, 120)
        ];
    }

    protected function createStdSimplificado($label, $valor, $percentual)
    {
        return (object)[
            'nome' => $label,
            'valor' => $valor,
            'percentual' => $percentual
        ];
    }

    private function processaRP($codigoPeriodo)
    {
        $datas = $this->datasPeriodo($codigoPeriodo);
        $inicio = "{$this->exercicio}-01-01";
        $this->restosPagar = $this->executarRestosPagar($this->exercicio, $inicio, $datas['fim']);
        return $this->restosPagar;
    }

    /**
     *
     * @param array $restos
     * @param \stdClass $linha
     * @param $codigoPeriodoProcessando
     */
    protected function somandoRestoPagar(array $restos, \stdClass $linha, $codigoPeriodoProcessando)
    {
        foreach ($restos as $resto) {
            if (!$this->matchResto($resto, $linha)) {
                continue;
            }

            foreach ($linha->colunas as $coluna) {
                if ($coluna->ordem === 1 && $this->periodo->getCodigo() != $codigoPeriodoProcessando) {
                    continue;
                }
                $colunaDespena = array_search($coluna->coluna, $this->colunasRp);
                if (empty($colunaDespena)) {
                    continue;
                }

//                echo "processando coluna: {$coluna->coluna} - $colunaDespena <br>";
                $coluna->valor += $resto->{$colunaDespena};
            }
        }
    }
}
