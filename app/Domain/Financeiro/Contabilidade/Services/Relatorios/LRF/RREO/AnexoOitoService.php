<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

namespace App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\RREO;

use App\Domain\Configuracao\Instituicao\Model\DBConfig;
use App\Domain\Financeiro\Contabilidade\Factories\TemplateFactory;
use App\Domain\Financeiro\Contabilidade\Relatorios\LRF\RREO\XlsAnexoOito;
use App\Domain\Financeiro\Contabilidade\Services\BalanceteDespesaService;
use App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\AnexosService;
use Carbon\Carbon;
use DBDate;
use Illuminate\Support\Facades\DB;

class AnexoOitoService extends AnexosService
{
    protected $colunasReceita = [
        'previsao_atualizada' => 'prev_atual',
        'arrecadado_acumulado' => 'rec_atebim',
    ];

    protected $colunasDespesa = [
        '' => 'rpnp_sem_dc', // valor manual, por isso n�o tem mapeamento
        'a_liquidar' => 'rp_nproc',
        'liquidado_acumulado' => 'liq_atebim',
        'pago_acumulado' => 'desppag',
        'empenhado_liquido_acumulado' => 'emp_atebim',
        'total_creditos' => 'dot_atual',
    ];


    /**
     * Mapeia as se��es do relat�rio no excell
     * @var \int[][]
     */
    protected $sections = [
        'recieta_1' => [1, 15],  // 1 - RECEITA DE IMPOSTOS
        'recieta_2' => [19, 29], // 6 - RECEITAS RECEBIDAS DO FUNDEB
        'total_superavit' => [30, 32], // 7 - RESULTADO L�QUIDO DAS TRANSFER�NCIAS DO FUNDEB
        'despesa_1' => [34, 43], // 10 - PROFISSIONAIS DA EDUCA��O B�SICA
        'despesa_2' => [45, 50], // 13 - Total das Despesas do FUNDEB com Profissionais da Educa��o B�sica
        'manuais' => [55, 57], // 23 - Total das Despesas custeadas com Super�vit do FUNDEB
        'despesa_4' => [58, 61], // 24 - EDUCA��O INFANTIL
        'rp_1' => [70, 73], // 34 - RESTOS A PAGAR DE DESPESAS COM MDE
        'receita_3' => [74, 83], // 35 - RECEITA DE TRANSFER�NCIAS DO FNDE
        'despesa_5' => [85, 91], // 41 - EDUCA��O INFANTIL
        'despesa_6' => [93, 101], // 47 - TOTAL GERAL DAS DESPESAS COM EDUCA��O
        'balver_1' => [102, 108], // 47 - TOTAL GERAL DAS DESPESAS COM EDUCA��O
    ];

    protected $linhasOrganizadas = [];

    protected $linhasNaoProcessar = [70, 71, 72, 73, 103, 104, 105, 106, 107, 108, 110, 111, 112, 113, 114, 115];

    /**
     * @var XlsAnexoOito
     */
    protected $parser;

    public function __construct($filtros)
    {
        $this->exercicio = $filtros['DB_anousu'];

        $this->emissor = \InstituicaoRepository::getInstituicaoByCodigo($filtros['DB_instit']);
        $template = TemplateFactory::getTemplate($filtros['codigo_relatorio'], $filtros['periodo']);

        $this->constructAssinaturas($filtros['DB_instit']);
        $this->constructInstituicoes(DBConfig::all());
        $this->constructPeriodo($filtros['periodo']);
        $this->constructRelatorio($filtros['codigo_relatorio']);
        $this->processaEnteFederativo();

        $this->parser = new XlsAnexoOito($template);
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

        $this->parser->setVariavel('valor_manual_linha_30', $this->linhas[66]->valor);
        $filename = $this->parser->gerar();

        return [
            'xls' => $filename,
            'xlsLinkExterno' => ECIDADE_REQUEST_PATH . $filename
        ];
    }


    public function processar()
    {
        $this->processaLinhas($this->linhas);
        $this->processarRPsMDE();
        $this->criaProriedadesValor();
        $this->calculosManuais();
        $this->organizaLinhas();
    }

    /**
     * Calculo acumulado do RP
     */
    protected function processarRPsMDE()
    {
        $dataInicio = "$this->exercicio-01-01";
        $dataFim = $this->dataFim->getDate();
        $restosPagar = $this->executarRestosPagar($this->exercicio, $dataInicio, $dataFim);
        $linhasCalcular = range(71, 73);
        foreach ($this->linhas as $linha) {
            if (in_array($linha->ordem, $linhasCalcular) && (int)$linha->origem === self::ORIGEM_RP) {
                $this->processaRestoPagar($restosPagar, $linha);
            }
        }
    }

    private function calculosManuais()
    {
        // cria propriedade valor na raiz da linha.
        $this->linhas[30]->valor = $this->linhas[30]->saldo_anterior_acumulado;
        $this->processamentosManuaisLinhasIndicadores();
        $this->processaLinhasControleDisponabilidadeFinanceira();
    }

    private function processaLinhasControleDisponabilidadeFinanceira()
    {
        // atualiza os valores da linha 48
        $this->linhas[102]->valor_fundeb = $this->linhas[102]->colunas[0]->valor;
        $this->linhas[102]->valor_salario_educacao = $this->linhas[109]->colunas[0]->valor;

        // como a configura��o do quadro � a mesma, mudando apenas o recurso da coluna, eu peguei a configura��o apenas
        // de uma linha para cada lado da coluna.
        $valoresFundeb = $this->buscarValoresDisponibilidadeFinanceira(103);
        $valoresSalarioEducacao = $this->buscarValoresDisponibilidadeFinanceira(110);

        // documentos a contabilizar em cada linha
        $documentosLinha52 = [121, 130, 140, 141, 142, 143, 160, 163, 150, 153];
        $documentosLinha53 = [120, 161, 151, 162, 152, 131, 140, 141, 142, 143];

        // Valores movimentados a D�BITO nas contas EXCETO os valores constantes na linha 52
        $this->linhas[103]->valor_fundeb = 0; // linha 48 - coluna fundeb
        $this->linhas[106]->valor_fundeb = 0; // linha 52 - coluna fundeb
        $this->linhas[103]->valor_salario_educacao = 0; // linha 48 - coluna sal�rio educa��o
        $this->linhas[106]->valor_salario_educacao = 0; // linha 52 - coluna sal�rio educa��o

        // Valores movimentados a CR�DITO nas contas EXCETO os valores constantes na linha 53
        $this->linhas[104]->valor_fundeb = 0; // linha 50 - coluna fundeb
        $this->linhas[107]->valor_fundeb = 0; // linha 53 - coluna fundeb
        $this->linhas[104]->valor_salario_educacao = 0; // linha 50 - coluna sal�rio educa��o
        $this->linhas[107]->valor_salario_educacao = 0; // linha 53 - coluna sal�rio educa��o


        foreach ($valoresFundeb as $valorFundeb) {
            if (in_array($valorFundeb->codigo_documento, $documentosLinha52)) {
                $this->linhas[106]->valor_fundeb += $valorFundeb->debito;
            } else {
                $this->linhas[103]->valor_fundeb += $valorFundeb->debito;
            }

            if (in_array($valorFundeb->codigo_documento, $documentosLinha53)) {
                $this->linhas[107]->valor_fundeb += $valorFundeb->credito;
            } else {
                $this->linhas[104]->valor_fundeb += $valorFundeb->credito;
            }
        }


        foreach ($valoresSalarioEducacao as $valorEducacao) {
            if (in_array($valorEducacao->codigo_documento, $documentosLinha52)) {
                $this->linhas[106]->valor_salario_educacao += $valorEducacao->debito;
            } else {
                $this->linhas[103]->valor_salario_educacao += $valorEducacao->debito;
            }

            if (in_array($valorEducacao->codigo_documento, $documentosLinha53)) {
                $this->linhas[107]->valor_salario_educacao += $valorEducacao->credito;
            } else {
                $this->linhas[104]->valor_salario_educacao += $valorEducacao->credito;
            }
        }


        // soma o valor manual
        $this->linhas[105]->valor_fundeb = 0;
        $this->linhas[105]->valor_salario_educacao = 0;
        $linhasFundeb = range(102, 107);
        $linhasSalarioEducacao = range(109, 114);

        foreach ($linhasFundeb as $index => $ordem) {
            $linhaFundeb = $this->linhas[$ordem];
            $linhaFundeb->valor_fundeb += $linhaFundeb->colunas[0]->valoManual;

            // pega a linha equivalente da coluna sal�rio educa��o
            $ordemLinhaSalarioEducacao = $linhasSalarioEducacao[$index];
            $linhaSalarioEducacao = $this->linhas[$ordemLinhaSalarioEducacao];
            $linhaFundeb->valor_salario_educacao += $linhaSalarioEducacao->colunas[0]->valoManual;
        }
    }

    /**
     * Calcular as linhas:
     * 23 - Total das Despesas custeadas com Super�vit do FUNDEB
     *  23.1 - Total das Despesas custeadas com FUNDEB - Impostos e Transfer�ncias de Impostos
     *  23.2 - Total das Despesas custeadas com FUNDEB - Complementa��o da Uni�o (VAAF + VAAT)
     */
    private function processamentosManuaisLinhasIndicadores()
    {
        /**
         *
         * Para linha: 23.1
         * Coluna:
         *  - VALOR DE SUPER�VIT PERMITIDO NO EXERC�CIO ANTERIOR
         *    Somar linhas: (L6.1.1 + L6.1.2)
         *  - VALOR N�O APLICADO NO EXERC�CIO ANTERIOR
         *    Somar linhas: (L6.1.1 + L6.1.2) - L14
         *  - VALOR DE SUPER�VIT APLICADO AT� O PRIMEIRO QUADRIMESTRE
         *    Somar linhas: (L6.1.1 + L6.1.2) do exercicio atual mais tem que executar o balancete do 1� quadrimestre
         *  - VALOR APLICADO AT� O PRIMEIRO QUADRIMESTRE QUE INTEGRAR� O LIMITE CONSTITUCIONAL
         *
         *  - VALOR APLICADO AP�S O PRIMEIRO QUADRIMESTRE
         *
         *  Para linha: 23.2
         *  - VALOR DE SUPER�VIT PERMITIDO NO EXERC�CIO ANTERIOR
         *    Somar linhas: (L6.2.1 + L6.2.2 + L6.3.1 + L6.3.2)
         *  - VALOR N�O APLICADO NO EXERC�CIO ANTERIOR
         *    Somar linhas: (L6.2.1 + L6.2.2 + L6.3.1 + L6.3.2) - (L15 + L16)
         *  - VALOR DE SUPER�VIT APLICADO AT� O PRIMEIRO QUADRIMESTRE
         *  - VALOR APLICADO AT� O PRIMEIRO QUADRIMESTRE QUE INTEGRAR� O LIMITE CONSTITUCIONAL
         *  - VALOR APLICADO AP�S O PRIMEIRO QUADRIMESTRE
         */

        $this->zeraPropriedadesLinhas([55, 56, 57]);

        $ordensLinhas = [21, 22, 24, 25, 27, 28, 46, 47, 48];
        $novasLinhas = $this->buscarLinhasPorOrdem($ordensLinhas);

        foreach ($novasLinhas as $linha) {
            if ((int)$linha->origem === self::ORIGEM_RECEITA) {
                $this->processaReceita($this->getBalanceteReceitaExercicioAnterior(), $linha);
            }
            if ((int)$linha->origem === self::ORIGEM_DESPESA) {
                $this->processaDespesa($this->getBalanceteDespesaExercicioAnterior(), $linha);
            }
        }

        $this->calculaLinha23dot1ExercicioAnterior($novasLinhas);
        $this->calculaLinha23dot2ExercicioAnterior($novasLinhas);

        // separa os estruturais das linhas para usar como filtro e otimizar a execu��o do balancete
        $estruturaisReceita = $this->filtrarContasConfiguracaoLinha($novasLinhas, self::ORIGEM_RECEITA);
        $estruturaisDespesa = $this->filtrarContasConfiguracaoLinha($novasLinhas, self::ORIGEM_DESPESA);

        if ($this->periodo->getCodigo() > 6) {
            $this->processar1Quadrimestre(
                $this->buscarLinhasPorOrdem($ordensLinhas),
                $estruturaisReceita,
                $estruturaisDespesa
            );
        }

        $this->processaLinha23ColunaT();
        if ($this->periodo->getCodigo() > 7) {
            $this->processaLinha23ColunaU(
                $this->buscarLinhasPorOrdem($ordensLinhas),
                $estruturaisReceita,
                $estruturaisDespesa
            );
        }

        // calcular valores manuais
        foreach ($this->linhas[56]->colunas as $coluna) {
            $this->linhas[56]->{$coluna->coluna} += $coluna->valoManual;
        }
        foreach ($this->linhas[57]->colunas as $coluna) {
            $this->linhas[57]->{$coluna->coluna} += $coluna->valoManual;
        }
    }


    private function zeraPropriedadesLinhas($ordemLinhas)
    {
        foreach ($ordemLinhas as $ordem) {
            $linha = $this->linhas[$ordem];
            foreach ($linha->colunas as $coluna) {
                $nomeColuna = $coluna->coluna;
                $linha->{$nomeColuna} = 0;
            }
        }
    }

    /**
     * Calcula a linha:
     * 56 - 23.1- Total das Despesas custeadas com FUNDEB - Impostos e Transfer�ncias de Impostos
     * calcula as colunas:
     *  - VALOR DE SUPER�VIT PERMITIDO NO EXERC�CIO ANTERIOR
     *    Somar linhas: (L6.1.1 + L6.1.2)  ordens: 21 e 22
     *  - VALOR N�O APLICADO NO EXERC�CIO ANTERIOR
     *    Somar linhas: (L6.1.1 + L6.1.2) - L14 ordem: 46
     * @param array $linhasDadosExecAnt linhas com valores do exerc�cio anterior
     */
    private function calculaLinha23dot1ExercicioAnterior(array $linhasDadosExecAnt)
    {
        $valorColuna1 = $linhasDadosExecAnt[21]->colunas[1]->valor;
        $valorColuna1 += $linhasDadosExecAnt[22]->colunas[1]->valor;

        $ordemColuna = 0;
        if ($this->periodo->getCodigo() == 11) {
            $ordemColuna = 1;
        }
        $valorColuna2 = $valorColuna1 - $linhasDadosExecAnt[46]->colunas[$ordemColuna]->valor;

        $this->linhas[56]->vlr_superavit_ex_ant = ($valorColuna1 * 10) / 100;
        $this->linhas[56]->vlr_naplic_ex_ant = $valorColuna2;
    }

    /**
     * Calcula a linha:
     *  57 - 23.2- Total das Despesas custeadas com FUNDEB - Complementa��o da Uni�o (VAAF + VAAT)
     * calcula as colunas:
     *  - VALOR DE SUPER�VIT PERMITIDO NO EXERC�CIO ANTERIOR
     *    Somar linhas: (L6.2.1 + L6.2.2 + L6.3.1 + L6.3.2)  ordens: 24, 25, 27 e 28
     *  - VALOR N�O APLICADO NO EXERC�CIO ANTERIOR
     *    Somar linhas: (L6.2.1 + L6.2.2 + L6.3.1 + L6.3.2) - (L15 + L16) orderns 47 e 48
     *
     * @param array $linhasDadosExecAnt
     */
    private function calculaLinha23dot2ExercicioAnterior(array $linhasDadosExecAnt)
    {
        $valorColuna1 = $linhasDadosExecAnt[24]->colunas[1]->valor;
        $valorColuna1 += $linhasDadosExecAnt[25]->colunas[1]->valor;
        $valorColuna1 += $linhasDadosExecAnt[27]->colunas[1]->valor;
        $valorColuna1 += $linhasDadosExecAnt[28]->colunas[1]->valor;

        $ordemColuna = 0;
        if ($this->periodo->getCodigo() == 11) {
            $ordemColuna = 1;
        }

        $somaLinha15e16 = $linhasDadosExecAnt[47]->colunas[$ordemColuna]->valor;
        $somaLinha15e16 += $linhasDadosExecAnt[48]->colunas[$ordemColuna]->valor;
        $valorColuna2 = $valorColuna1 - $somaLinha15e16;
        $this->linhas[57]->vlr_superavit_ex_ant = ($valorColuna1 * 10) / 100;
        $this->linhas[57]->vlr_naplic_ex_ant = $valorColuna2;
    }

    /**
     * Busca executa os balancetes necess�rios para calcular o 1� quadrimestre
     *
     * @param array $novasLinhas
     * @param $estruturaisReceita
     * @param $estruturaisDespesa
     */
    private function processar1Quadrimestre(array $novasLinhas, $estruturaisReceita, $estruturaisDespesa)
    {
        $estimativasReceita = [];
        if (!empty($estruturaisReceita)) {
            $estimativasReceita = $this->processar1QuadrimestreReceita($estruturaisReceita);
        }

        $estimativasDespesa = [];
        if (!empty($estruturaisDespesa)) {
            $estimativasDespesa = $this->processar1QuadrimestreDespesa($estruturaisDespesa);
        }

        foreach ($novasLinhas as $linha) {
            if ((int)$linha->origem === self::ORIGEM_RECEITA) {
                $this->processaReceita($estimativasReceita, $linha);
            }
            if ((int)$linha->origem === self::ORIGEM_DESPESA) {
                $this->processaDespesa($estimativasDespesa, $linha);
            }
        }

        $this->calculaColunasPrimerioQuadrimestre($novasLinhas);
    }

    /**
     * Retorna todas contas a filtrar
     * @param array $novasLinhas
     * @param integer $origem
     * @return array
     */
    private function filtrarContasConfiguracaoLinha(array $novasLinhas, $origem)
    {
        $contas = [];
        foreach ($novasLinhas as $novaLinha) {
            if ((int)$novaLinha->origem !== $origem) {
                continue;
            }
            if (is_null($novaLinha->configuracao)) {
                continue;
            }
            $contas = array_merge($contas, $novaLinha->configuracao->contas);
        }

        return array_unique($contas);
    }

    private function processar1QuadrimestreReceita(array $filtroReceita)
    {
        $instituicoes = $this->listaInstituicoes->implode(',');
        $listaEstruturais = implode("', '", $filtroReceita);
        $where = [
            "o70_anousu = {$this->exercicio}",
            " instituicao in ($instituicoes)",
            " natureza in ('{$listaEstruturais}')",
            " (previsao_adicional_acumulado != 0 or valor_a_arrecadar != 0 or arrecadado_acumulado != 0)"
        ];
        $dataInicio = "{$this->exercicio}-01-01";
        $dataFim = "{$this->exercicio}-04-30";
        $sql = $this->sqlBalanceteReceita($where, $dataInicio, $dataFim);
        return DB::select($sql);
    }

    private function processar1QuadrimestreDespesa(array $filtroDespesa)
    {
        $service = new BalanceteDespesaService();
        $sql = $service->setAno($this->exercicio)
            ->setFiltrarInstituicoes($this->listaInstituicoes)
            ->setFiltroDataInicio(Carbon::createFromFormat('Y-m-d', "{$this->exercicio}-01-01"))
            ->setFiltroDataFinal(Carbon::createFromFormat('Y-m-d', "{$this->exercicio}-04-30"))
            ->filtrarEstruturais($filtroDespesa)
            ->sqlPrincipal();

        return $service->execute($sql);
    }

    /**
     *  Coluna: > VALOR DE SUPER�VIT APLICADO AT� O PRIMEIRO QUADRIMESTRE
     *
     * Calcula o valor das linhas:
     * 23.1 - Total das Despesas custeadas com FUNDEB - Impostos e Transfer�ncias de Impostos
     * 23.2 - Total das Despesas custeadas com FUNDEB - Complementa��o da Uni�o (VAAF + VAAT)
     *
     * onde 23.1 � a linha de ordem  56
     * onde 23.2 � a linha de ordem  57
     *
     * @param array $novasLinhas
     */
    private function calculaColunasPrimerioQuadrimestre(array $novasLinhas)
    {
        $valorLinha56 = $novasLinhas[21]->colunas[1]->valor;
        $valorLinha56 += $novasLinhas[22]->colunas[1]->valor;

        // calcula as linhas que tem que subtrair de acordo com o per�odo emitido
        $valorLinha15e16 = $novasLinhas[47]->colunas[0]->valor + $novasLinhas[48]->colunas[0]->valor;
        $valorLinha14 = $novasLinhas[46]->colunas[0]->valor;
        if ($this->periodo->getCodigo() == 11) {
            $valorLinha14 = $novasLinhas[46]->colunas[1]->valor;
            $valorLinha15e16 = $novasLinhas[47]->colunas[1]->valor + $novasLinhas[48]->colunas[1]->valor;
        }
        $valorLinha56 -= $valorLinha14;

        $this->linhas[56]->superavit_aplic_1quadr = $valorLinha56;

        $valorLinha57 = $novasLinhas[24]->colunas[1]->valor;
        $valorLinha57 += $novasLinhas[25]->colunas[1]->valor;
        $valorLinha57 += $novasLinhas[27]->colunas[1]->valor;
        $valorLinha57 += $novasLinhas[28]->colunas[1]->valor;

        $valorLinha57 -= $valorLinha15e16;
        $this->linhas[57]->superavit_aplic_1quadr = $valorLinha57;
    }

    /**
     * Coluna: > VALOR APLICADO AT� O PRIMEIRO QUADRIMESTRE QUE INTEGRAR� O LIMITE CONSTITUCIONAL
     *
     * Calcula o valor das linhas:
     * 23.1 - Total das Despesas custeadas com FUNDEB - Impostos e Transfer�ncias de Impostos
     * 23.2 - Total das Despesas custeadas com FUNDEB - Complementa��o da Uni�o (VAAF + VAAT)
     *
     * onde 23.1 � a linha de ordem  56
     * onde 23.2 � a linha de ordem  57
     */
    private function processaLinha23ColunaT()
    {
        // define como padr�o valor da coluna (q)
        $this->linhas[56]->aplic_1q_limite_constitucional = $this->linhas[56]->vlr_superavit_ex_ant;
        $this->linhas[57]->aplic_1q_limite_constitucional = $this->linhas[57]->vlr_superavit_ex_ant;

        // se (q) - (r) > 0 = (r)
        if (($this->linhas[56]->vlr_superavit_ex_ant - $this->linhas[56]->vlr_naplic_ex_ant) > 0) {
            $this->linhas[56]->aplic_1q_limite_constitucional = $this->linhas[56]->vlr_naplic_ex_ant;
        }
        if (($this->linhas[57]->vlr_superavit_ex_ant - $this->linhas[57]->vlr_naplic_ex_ant) > 0) {
            $this->linhas[57]->aplic_1q_limite_constitucional = $this->linhas[57]->vlr_naplic_ex_ant;
        }
    }

    /**
     * Coluna: > VALOR APLICADO AP�S O PRIMEIRO QUADRIMESTRE
     *
     * @param $novasLinhas
     * @param $filtroReceita
     * @param $filtroDespesa
     */
    private function processaLinha23ColunaU($novasLinhas, $filtroReceita, $filtroDespesa)
    {
        $estimativasReceita = [];
        if (!empty($filtroReceita)) {
            $estimativasReceita = $this->buscarEstimativaReceitaApos1Quadrimestre($filtroReceita);
        }

        $estimativasDespesa = [];
        if (!empty($filtroDespesa)) {
            $estimativasDespesa = $this->buscarEstimativaDespesaApos1Quadrimestre($filtroDespesa);
        }

        foreach ($novasLinhas as $linha) {
            if ((int)$linha->origem === self::ORIGEM_RECEITA) {
                $this->processaReceita($estimativasReceita, $linha);
            }
            if ((int)$linha->origem === self::ORIGEM_DESPESA) {
                $this->processaDespesa($estimativasDespesa, $linha);
            }
        }

        // valores da coluna S
        $l23dot1ColunaS = $this->linhas[56]->superavit_aplic_1quadr;
        $l23dot2ColunaS = $this->linhas[57]->superavit_aplic_1quadr;

        // Calculo do valor acumulado at� o per�odo da coluna U
        $valorAcumulado23dot1 = $novasLinhas[21]->colunas[1]->valor += $novasLinhas[22]->colunas[1]->valor;

        // calcula as linhas que tem que subtrair de acordo com o per�odo emitido
        $valorLinha14 = $novasLinhas[46]->colunas[0]->valor;
        $valorLinha15e16 = $novasLinhas[47]->colunas[0]->valor + $novasLinhas[48]->colunas[0]->valor;
        if ($this->periodo->getCodigo() == 11) {
            $valorLinha14 = $novasLinhas[46]->colunas[1]->valor;
            $valorLinha15e16 = $novasLinhas[47]->colunas[1]->valor + $novasLinhas[48]->colunas[1]->valor;
        }

        $valorAcumulado23dot1 -= $valorLinha14;

        $valorAcumulado23dot2 = $novasLinhas[24]->colunas[1]->valor;
        $valorAcumulado23dot2 += $novasLinhas[25]->colunas[1]->valor;
        $valorAcumulado23dot2 += $novasLinhas[27]->colunas[1]->valor;
        $valorAcumulado23dot2 += $novasLinhas[28]->colunas[1]->valor;
        $valorAcumulado23dot2 -= $valorLinha15e16;

        // O valor apresentado na coluna U deve ser o valor total acumulado at� o per�odo - o valor j� calculado para
        // coluna S (at� o primeiro quadrimestre)
        $this->linhas[56]->aplic_apos_1q = $valorAcumulado23dot1 - $l23dot1ColunaS;
        $this->linhas[57]->aplic_apos_1q = $valorAcumulado23dot2 - $l23dot2ColunaS;
    }

    private function buscarEstimativaReceitaApos1Quadrimestre($filtroReceita)
    {
        $instituicoes = $this->listaInstituicoes->implode(',');
        $listaEstruturais = implode("', '", $filtroReceita);
        $where = [
            "o70_anousu = {$this->exercicio}",
            " instituicao in ($instituicoes)",
            " natureza in ('{$listaEstruturais}')",
            " (previsao_adicional_acumulado != 0 or valor_a_arrecadar != 0 or arrecadado_acumulado != 0)"
        ];
        $dataInicio = "{$this->exercicio}-01-01";
        $dataFim = $this->periodo->getDataFinal($this->exercicio)->getDate();
        $sql = $this->sqlBalanceteReceita($where, $dataInicio, $dataFim);
        return DB::select($sql);
    }

    private function buscarEstimativaDespesaApos1Quadrimestre($filtroDespesa)
    {
        $dataFim = $this->periodo->getDataFinal($this->exercicio)->getDate();
        $service = new BalanceteDespesaService();
        $sql = $service->setAno($this->exercicio)
            ->setFiltrarInstituicoes($this->listaInstituicoes)
            ->setFiltroDataInicio(Carbon::createFromFormat('Y-m-d', "{$this->exercicio}-01-01"))
            ->setFiltroDataFinal(Carbon::createFromFormat('Y-m-d', $dataFim))
            ->filtrarEstruturais($filtroDespesa)
            ->sqlPrincipal();

        return $service->execute($sql);
    }

    /**
     * SQL extra�do do Raz�o por Conta.
     * Usado para filtrar os valores das contas do plano de contas de acordo com os filtros da linha
     * Possibilitando filtrar os valores do quadro:
     *  - CONTROLE DA DISPONIBILIDADE FINANCEIRA E CONCILIA��O BANC�RIA
     * @param array $filtros
     * @return string
     */
    protected function buscaValoresBalanceteVerificacaoPorDocumento(array $filtros)
    {
        $where = implode(' and ', $filtros);
        return "
        SELECT x.c61_reduz AS reduzido,
               coalesce(sum(CASE WHEN tipo = 'C' THEN c70_valor END), 0) AS credito,
               coalesce(sum(CASE WHEN tipo = 'D' THEN c70_valor END), 0) AS debito,
               x.c60_descr AS descricao_conta,
               x.c60_estrut AS estrutural,
               x.c53_coddoc AS codigo_documento,
               x.c53_descr AS descricao_documento
        FROM
          (SELECT c61_reduz,
                  c69_debito,
                  c69_credito,
                  c69_codlan,
                  c70_data,
                  c70_valor,
                  c60_descr,
                  c60_estrut,
                  c53_coddoc,
                  c53_descr,
                  CASE
                      WHEN conlancamval.c69_credito = conplanoreduz.c61_reduz THEN 'C'
                      ELSE 'D'
                  END AS tipo
           FROM conplano
           INNER JOIN conplanoreduz ON conplanoreduz.c61_codcon = conplano.c60_codcon
           AND conplanoreduz.c61_anousu = conplano.c60_anousu
           INNER JOIN conlancamval ON conlancamval.c69_credito = conplanoreduz.c61_reduz
           OR conlancamval.c69_debito = conplanoreduz.c61_reduz
           INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
           INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
           INNER JOIN conhistdoc ON conhistdoc.c53_coddoc = conlancamdoc.c71_coddoc
           JOIN orcamento.orctiporec ON orctiporec.o15_codigo = c61_codigo
           WHERE {$where}
           ORDER BY c70_data,
                    c61_reduz) AS x
        GROUP BY x.c60_descr,
                 x.c60_estrut,
                 x.c53_coddoc,
                 x.c53_descr,
                 x.c61_reduz
        ORDER BY x.c61_reduz
        ";
    }

    private function buscarValoresDisponibilidadeFinanceira($ordemLinha)
    {
        $linha = $this->linhas[$ordemLinha];
        $fontesRecursos = $linha->configuracao->fonteRecurso->valores;

        // foi pensado em pegar apenas de um estrutural configurado
        $estruturalAteNivel = $linha->configuracao->contasConformeConfiguracao[0]->estruturalAteNivel;

        $dataInicio = "$this->exercicio-01-01";
        $dataFim = $this->periodo->getDataFinal($this->exercicio)->getDate();

        $instituicoes = $this->listaInstituicoes->implode(',');
        $where = [
            "c61_instit in ({$instituicoes})",
            "conplanoreduz.c61_anousu = $this->exercicio",
            "conplano.c60_anousu = $this->exercicio",
            "conlancamval.c69_data BETWEEN '{$dataInicio}' AND '$dataFim'",
            "c60_estrut like '$estruturalAteNivel%'",
        ];

        if (!empty($fontesRecursos)) {
            $where[] = "o15_recurso in ('" . implode("', '", $fontesRecursos) . "')";
        }

        return DB::select($this->buscaValoresBalanceteVerificacaoPorDocumento($where));
    }

    public function processaLinhasSimplificado()
    {
        $this->processar();
        // as linhas descrita no nome da fun��o � a ordem das linhas
        $this->calculaLinha69Simplificado();
        $this->calculaLinha51Simplificado();
        $this->calculaLinha52Simplificado();
        $this->calculaLinha53Simplificado();

        return $this->linhasSimplificado();
    }

    /**
     * 3- TOTAL DA RECEITA RESULTANTE DE IMPOSTOS (1 + 2)
     */
    private function calculaLinha16Simplificado()
    {
        $somar = [2, 3, 4, 5, 8, 9, 10, 11, 12, 13, 14, 15];
        $linha16 = $this->linhas[16];
        foreach ($somar as $linha) {
            $linha16->rec_atebim += $this->linhas[$linha]->rec_atebim;
        }
    }

    /**
     * 33- APLICA��O EM MDE SOBRE A RECEITA RESULTANTE DE IMPOSTOS
     */
    private function calculaLinha69Simplificado()
    {
        $this->calculaLinha16Simplificado();
        $this->calculaLinha68Simplificado();

        $this->linhas[69]->valor_aplicado = $this->linhas[68]->valor;
        $this->linhas[69]->percentual = 25;

        $this->linhas[69]->percentual_aplicado = 0;
        if ($this->linhas[16]->rec_atebim > 0) {
            $this->linhas[69]->percentual_aplicado = ($this->linhas[68]->valor / $this->linhas[16]->rec_atebim) * 100;
        }
    }

    /**
     * 26- TOTAL DAS DESPESAS COM A��ES T�PICAS DE MDE (24 + 25)
     */
    private function calculaLinha62Simplificado()
    {
        $somar = [59, 60, 61];
        $linha62 = $this->linhas[62];
        foreach ($somar as $linha) {
            $linha62->emp_atebim += $this->linhas[$linha]->emp_atebim;
            $linha62->liq_atebim += $this->linhas[$linha]->liq_atebim;
        }
    }

    /**
     * 32- TOTAL DAS DESPESAS PARA FINS DE LIMITE  (27 - (28 + 29 + 30 + 31))
     */
    private function calculaLinha68Simplificado()
    {
        // 27- TOTAL DAS DESPESAS DE MDE CUSTEADAS COM RECURSOS DE IMPOSTOS (FUNDEB E RECEITA DE IMPOSTOS)
        // = (L14(d ou e) + L26(d ou e) + L23.1
        $this->calculaLinha63Simplificado();
        //28 (-) RESULTADO L�QUIDO DAS TRANSFER�NCIAS DO FUNDEB = (L7)
        $this->calculaLinha64Simplificado();
        //29 (-) RESTOS A PAGAR N�O PROCESSADOS INSCRITOS NO EXERC�CIO SEM DISPONIBILIDADE FINANCEIRA DE RECURSOS ...
        $this->calculaLinha65Simplificado();

        //30 (-) RESTOS A PAGAR N�O PROCESSADOS INSCRITOS NO EXERC�CIO SEM DISPONIBILIDADE FINANCEIRA DE RECURSOS ...
        //$this->linhas[66]->valor_manual_linha_30;
        //31 (-) CANCELAMENTO, NO EXERC�CIO, DE RESTOS A PAGAR INSCRITOS COM DISPONIBILIDADE FINANCEIRA DE RECURSOS...
        $this->calculaLinha67Simplificado();
        $valor = $this->linhas[64]->valor + $this->linhas[65]->valor + $this->linhas[66]->valor;
        $valor += $this->linhas[67]->valor;

        $this->linhas[68]->valor = $this->linhas[63]->valor - $valor;
    }

    /**
     * 27 - TOTAL DAS DESPESAS DE MDE CUSTEADAS COM RECURSOS DE IMPOSTOS (FUNDEB E RECEITA DE IMPOSTOS)
     * = (L14(d ou e) + L26(d ou e) + L23.1
     *  imprimir a coluna (e) quando impresso do 1� ao 5� Bimestre ao imprimir o 6� usar a coluna (d)
     */
    private function calculaLinha63Simplificado()
    {
        $linha63 = $this->linhas[63];
        $this->calculaLinha62Simplificado();

        $linha46 = $this->linhas[46]; // � a linha 14 do relatorio
        $linha62 = $this->linhas[62]; // � a linha 26 do relatorio

        $valorLinha14 = $linha46->liq_atebim;
        $valorlinha26 = $linha62->liq_atebim;
        if ($this->isSextoBimestre()) {
            $valorLinha14 = $linha46->emp_atebim;
            $valorlinha26 = $linha62->emp_atebim;
        }

        $linha63->valor += $valorLinha14 + $valorlinha26 + $this->linhas[56]->aplic_1q_limite_constitucional;
        $linha63->valor += $this->linhas[57]->aplic_1q_limite_constitucional;
    }

    /**
     * 28 (-) RESULTADO L�QUIDO DAS TRANSFER�NCIAS DO FUNDEB = (L7)
     */
    private function calculaLinha64Simplificado()
    {
        // 4- TOTAL DESTINADO AO FUNDEB - 20% DE ((2.1.1) + (2.2) + (2.3) + (2.4) + (2.5))
        $this->calculaLinha17Simplificado();
        // linha 7                    = L6.1.1                        - L4
        $this->linhas[29]->rec_atebim = $this->linhas[21]->rec_atebim - $this->linhas[17]->rec_atebim;
        $this->linhas[64]->valor = $this->linhas[29]->rec_atebim;
    }

    /**
     * 4- TOTAL DESTINADO AO FUNDEB - 20% DE ((2.1.1) + (2.2) + (2.3) + (2.4) + (2.5))
     */
    private function calculaLinha17Simplificado()
    {
        $somar = [8, 10, 11, 12, 13];
        $linha17 = $this->linhas[17];
        foreach ($somar as $linha) {
            $linha17->rec_atebim += $this->linhas[$linha]->rec_atebim;
        }
        $linha17->rec_atebim *= 0.2;
    }

    /**
     * 29 (-) RESTOS A PAGAR N�O PROCESSADOS INSCRITOS NO EXERC�CIO SEM DISPONIBILIDADE FINANCEIRA DE RECURSOS DO
     * FUNDEB IMPOSTOS4 = (L14h)
     */
    private function calculaLinha65Simplificado()
    {
        // linha 14
        $this->linhas[65]->valor = $this->linhas[46]->rpnp_sem_dc;
    }

    /**
     *  31 (-) CANCELAMENTO, NO EXERC�CIO, DE RESTOS A PAGAR INSCRITOS COM DISPONIBILIDADE FINANCEIRA DE RECURSOS DE
     * IMPOSTOS VINCULADOS AO ENSINO = (L34.1(ac) + L34.2(ac))
     */
    private function calculaLinha67Simplificado()
    {
        $this->linhas[67]->valor = $this->linhas[71]->total_anulacoes + $this->linhas[72]->total_anulacoes;
    }

    /**
     * 19 - M�nimo de 70% do FUNDEB na Remunera��o dos Profissionais da Educa��o B�sica
     */
    private function calculaLinha51Simplificado()
    {
        $this->calculaLinha19Simplificado();
        $fundeb = $this->linhas[19]->rec_atebim;

        $valor = $this->linhas[45]->liq_atebim;
        if ($this->isSextoBimestre()) {
            $valor = $this->linhas[45]->emp_atebim;
        }

        $valorAposDeducoes = $valor - $this->linhas[45]->rpnp_sem_dc;

        $this->linhas[51]->valor_aplicado = $valorAposDeducoes;
        $this->linhas[51]->percentual = 70;
        $this->linhas[51]->percentual_aplicado = 0;
        if (!empty($fundeb)) {
            $this->linhas[51]->percentual_aplicado = ($valorAposDeducoes / $fundeb) * 100;
        }
    }

    /**
     * 6- RECEITAS RECEBIDAS DO FUNDEB
     */
    private function calculaLinha19Simplificado()
    {
        $linha19 = $this->linhas[19];
        $somar = [21, 22, 24, 25, 27, 28];
        foreach ($somar as $linha) {
            $linha19->prev_atual += $this->linhas[$linha]->prev_atual;
            $linha19->rec_atebim += $this->linhas[$linha]->rec_atebim;
        }
    }

    /**
     *  20 - Percentual de 50% da Complementa��o da Uni�o ao FUNDEB (VAAT) na Educa��o Infantil
     */
    private function calculaLinha52Simplificado()
    {
        $this->calculaLinha26Simplificado();
        $vaat = $this->linhas[26]->rec_atebim;
        $valor = $this->linhas[49]->liq_atebim;
        if ($this->isSextoBimestre()) {
            $valor = $this->linhas[49]->emp_atebim;
        }
        $valorAposDeducoes = $valor - $this->linhas[49]->rpnp_sem_dc;

        $this->linhas[52]->valor_aplicado = $valorAposDeducoes;
        $this->linhas[52]->percentual = 50;
        $this->linhas[52]->percentual_aplicado = 0;
        if (!empty($vaat)) {
            $this->linhas[52]->percentual_aplicado = ($valorAposDeducoes / $vaat) * 100;
        }
    }

    /**
     * 6.3- FUNDEB - Complementa��o da Uni�o - VAAT
     */
    private function calculaLinha26Simplificado()
    {
        $linha26 = $this->linhas[26];
        $somar = [27, 28];
        foreach ($somar as $linha) {
            $linha26->prev_atual += $this->linhas[$linha]->prev_atual;
            $linha26->rec_atebim += $this->linhas[$linha]->rec_atebim;
        }
    }

    /**
     *  21- M�nimo de 15% da Complementa��o da Uni�o ao FUNDEB - VAAT em Despesas de Capital
     */
    private function calculaLinha53Simplificado()
    {
        $vaat = $this->linhas[26]->rec_atebim;
        $valor = $this->linhas[50]->liq_atebim;
        if ($this->isSextoBimestre()) {
            $valor = $this->linhas[50]->emp_atebim;
        }
        $valorAposDeducoes = $valor - $this->linhas[50]->rpnp_sem_dc;

        $this->linhas[53]->valor_aplicado = $valorAposDeducoes;
        $this->linhas[53]->percentual = 15;
        $this->linhas[53]->percentual_aplicado = 0;
        if (!empty($vaat)) {
            $this->linhas[53]->percentual_aplicado = ($valorAposDeducoes / $vaat) * 100;
        }
    }

    private function linhasSimplificado()
    {
        $linhas = [];

        $descricoes = [
            69 => 'M�nimo Anual de 25% das Receitas de Impostos na Manuten��o e Desenvolvimento do Ensino',
            51 => 'M�nimo Anual de 70% do FUNDEB na Remunera��o dos Profissionais da Educa��o B�sica',
            52 => 'Percentual de 50% da Complementa��o da Uni�o ao FUNDEB (VAAT) na Educa��o Infantil',
            53 => 'M�nimo de 15% da Complementa��o da Uni�o ao FUNDEB (VAAT) em Despesas de Capital'
        ];

        foreach ($descricoes as $index => $descricao) {
            $linha = $this->linhas[$index];
            $linhas[] = $this->createObjetoSimplificado(
                $descricao,
                $linha->valor_aplicado,
                $linha->percentual,
                round($linha->percentual_aplicado, 2)
            );
        }
        return $linhas;
    }

    /**
     * Cria um objeto simplificado para mapear os valores do quadro simplificado
     * @param string $descricao
     * @param mixed $valor
     * @param int $nivel
     * @param boolean $totaliza
     * @return object
     */
    protected function createObjetoSimplificado($descricao, $valorAplicado, $percentual, $percentualAplicado)
    {
        return (object)[
            'descricao' => $descricao,
            'valorAplicado' => $valorAplicado,
            'percentual' => $percentual,
            'percentualAplicado' => $percentualAplicado,
        ];
    }
}
