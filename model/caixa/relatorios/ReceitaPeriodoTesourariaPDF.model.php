<?php

namespace model\caixa\relatorios;

use PDF;
use repositories\caixa\relatorios\ReceitaTipoRepositoryLegacy;
use repositories\caixa\relatorios\ReceitaOrdemRepositoryLegacy;
use interfaces\caixa\relatorios\IReceitaPeriodoTesourariaRepository;
use repositories\caixa\relatorios\ReceitaTipoReceitaRepositoryLegacy;
use repositories\caixa\relatorios\ReceitaFormaArrecadacaoRepositoryLegacy;

require_once "fpdf151/pdf.php";
require_once "repositories/caixa/relatorios/ReceitaTipoReceitaRepositoryLegacy.php";
require_once "repositories/caixa/relatorios/ReceitaOrdemRepositoryLegacy.php";
require_once "repositories/caixa/relatorios/ReceitaTipoRepositoryLegacy.php";
require_once "repositories/caixa/relatorios/ReceitaFormaArrecadacaoRepositoryLegacy.php";
require_once "interfaces/caixa/relatorios/IReceitaPeriodoTesourariaRepository.php";

class ReceitaPeriodoTesourariaPDF extends PDF
{
    private $totalRecursos = 0;
    /**
     * @var IReceitaPeriodoTesourariaRepository;
     */
    private $oReceitaPeriodoTesourariaRepository;
    private $preencherCelula = 0;

    public function __construct(
        $sTipo,
        $sTipoReceita,
        $iFormaArrecadacao,
        $dDataInicial,
        $dDataFinal,
        $oReceitaPeriodoTesourariaRepository
    ) {
        global $head3, $head4, $head6, $head8;

        $this->sTipo = $sTipo;
        $this->sTipoReceita = $sTipoReceita;
        $this->iFormaArrecadacao = $iFormaArrecadacao;
        $this->dDataInicial = $dDataInicial;
        $this->dDataFinal = $dDataFinal;
        $this->oReceitaPeriodoTesourariaRepository = $oReceitaPeriodoTesourariaRepository;
        $this->pegarDados();
        $this->definirCabecalho();

        $head3 = $this->tituloRelatorio;
        $head4 = $this->tituloTipoReceita;
        $head6 = $this->tituloPeriodo;
        $head8 = $this->tituloFormaArrecadacao;
        parent::__construct($this->oReceitaPeriodoTesourariaRepository->pegarFormatoPagina());
    }

    /**
     * @return void
     */
    public function pegarDados()
    {
        $this->aDadosRelatorio = $this->oReceitaPeriodoTesourariaRepository->pegarDados();
    }

    /**
     * @return void
     */
    public function definirCabecalho()
    {
        $this->tituloRelatorio = "RELATÓRIO DE RECEITAS ARRECADADAS";
        $this->tituloTipoReceita = $this->definirTituloTipoReceita();
        $this->tituloPeriodo = $this->definirTituloPeriodo();
        $this->tituloFormaArrecadacao = $this->definirTituloFormaArrecadacao();
    }

    /**
     * @return void
     */
    public function definirTituloTipoReceita()
    {
        if ($this->sTipoReceita == ReceitaTipoReceitaRepositoryLegacy::TODOS)
            return 'TODAS AS RECEITAS';

        if ($this->sTipoReceita == ReceitaTipoReceitaRepositoryLegacy::ORCAMENTARIA)
            return 'RECEITAS ORÇAMENTÁRIAS';

        if ($this->sTipoReceita == ReceitaTipoReceitaRepositoryLegacy::EXTRA)
            return 'RECEITAS EXTRA-ORÇAMENTÁRIAS';
    }

    /**
     * @return void
     */
    public function definirTituloPeriodo()
    {
        return "Período : " . db_formatar($this->dDataInicial, 'd') . " a " . db_formatar($this->dDataFinal, 'd');
    }

    /**
     * @return void
     */
    public function definirTituloFormaArrecadacao()
    {
        if ($this->iFormaArrecadacao == ReceitaFormaArrecadacaoRepositoryLegacy::TODAS)
            return 'Forma de Arrecadação: Todas';

        if ($this->iFormaArrecadacao == ReceitaFormaArrecadacaoRepositoryLegacy::ARQUIVO_BANCARIO)
            return 'Forma de Arrecadação: Via arquivo bancário';

        if ($this->iFormaArrecadacao == ReceitaFormaArrecadacaoRepositoryLegacy::EXCETO_ARQUIVO_BANCARIO)
            return 'Forma de Arrecadação: Exceto via arquivo bancário e retenções';

        if ($this->iFormaArrecadacao == ReceitaFormaArrecadacaoRepositoryLegacy::RETENCAO)
            return 'Forma de Arrecadação: Via retenções';
    }

    /**
     * @return void
     */
    public function processar()
    {
        $this->Open();
        $this->AliasNbPages();
        if (count($this->aDadosRelatorio) == 0) {
            db_redireciona('db_erros.php?fechar=true&db_erro=Não existem lançamentos para a receita');
        }

        if ($this->sTipo == ReceitaTipoRepositoryLegacy::DIARIO) {
            $this->montarTabelaReceitaDiaria();
            $this->Output();
            return;
        }

        $this->montarTabelaReceitaOrcamentaria();
        $this->montarTabelaReceitaExtraOrcamentaria();
        $this->montarTotalGeral();

        $this->Output();
    }

    /**
     * @return void
     */
    public function montarTabelaReceitaDiaria()
    {
        $this->AddPage();
        $this->montarIniciadoresPDF();
        $totalGeralDiario = 0;
        foreach ($this->aDadosRelatorio as $data => $aReceita) {
            $this->montarTituloDiario();
            $this->corrigirCabecalhoDiario();
            $totalDiario = 0;
            foreach ($aReceita as $oReceita) {
                $this->corrigirCabecalhoDiario();
                $this->montarDadosDiarios($oReceita);
                $this->definirFundoColorido();
                $totalDiario += $oReceita->valor;
                $totalGeralDiario += $oReceita->valor;
            }
            $this->setfont('arial', 'B', 7);
            $this->cell(254, 4, "SubTotal:", 1, 0, "R", 1);
            $this->cell(25, 4, db_formatar($totalDiario, 'f'), 1, 1, "R", 1);
            $this->ln(5);
        }
        $this->cell(254, 4, "Total Geral....:", 1, 0, "R", 1);
        $this->cell(25, 4, db_formatar($totalGeralDiario, 'f'), 1, 1, "R", 1);
        $this->ln(5);
    }

    /**
     * @return void
     */
    public function montarTituloDiario()
    {
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(10, 6, "COD", 1, 0, "C", 1);
        $this->Cell(10, 6, "RED", 1, 0, "C", 1);
        $this->Cell(15, 6, "DATA", 1, 0, "C", 1);
        $this->Cell(15, 6, "GUIA Nº", 1, 0, "C", 1);
        $this->Cell(25, 6, "ESTRUTURAL", 1, 0, "C", 1);
        $this->Cell(15, 6, "FONTE", 1, 0, "C", 1);
        $this->Cell(80, 6, "DESC DA RECEITA", 1, 0, "C", 1);
        $this->Cell(15, 6, "CONTA", 1, 0, "L", 1);
        $this->Cell(69, 6, "DESCRIÇÃO", 1, 0, "L", 1);
        $this->Cell(25, 6, "VALOR", 1, 1, "C", 1);
    }

    /**
     * @param stdClass $oReceita
     * @return void
     */
    public function montarDadosDiarios($oReceita)
    {
        $this->setfont('arial', '', 7);
        $this->cell(10, 4, $oReceita->codigo, 1, 0, "C", $this->preencherCelula);
        $this->cell(10, 4, $oReceita->reduzido, 1, 0, "C", $this->preencherCelula);
        $this->Cell(15, 4, db_formatar($oReceita->data, 'd'), 1, 0, "C", $this->preencherCelula);
        $this->Cell(15, 4, $oReceita->numpre, 1, 0, "C", $this->preencherCelula);
        $this->cell(25, 4, $oReceita->estrutural, 1, 0, "C", $this->preencherCelula);
        $this->Cell(15, 4, $oReceita->fonte, 1, 0, "C", $this->preencherCelula);
        $this->cell(80, 4, strtoupper($oReceita->descricao), 1, 0, "L", $this->preencherCelula);
        $this->cell(15, 4, $oReceita->conta, 1, 0, "C", $this->preencherCelula);
        $this->cell(69, 4, $oReceita->conta_descricao, 1, 0, "L", $this->preencherCelula);
        $this->cell(25, 4, db_formatar($oReceita->valor, 'f'), 1, 1, "R", $this->preencherCelula);
    }

    /**
     * @return void
     */
    public function corrigirCabecalhoDiario()
    {
        if ($this->gety() > $this->h - 30) {
            $this->Addpage();
            $this->montarTituloDiario();
        }
    }

    /**
     * @return void
     */
    public function montarTotalGeral()
    {
        $this->cell($this->PDFiTamanhoDescricaoTotal, 4, "TOTAL GERAL", 1, 0, "L", 0);
        $this->cell(25, 4, db_formatar($this->totalOrcamentaria + $this->totalExtra, 'f'), 1, 1, "R", 0);
        $this->ln(5);
        /*
        $this->cell(110, 4, "DEMONSTRATIVO DO DESDOBRAMENTO DA RECEITA LIVRE", 1, 1, "L", 0);
        $this->setfont('arial', 'B', 7);
        $this->cell(110, 5, db_formatar($this->totalRecursos, 'f'), 1, 1, "R", 0);
        */
    }

    /**
     * @return void
     */
    public function montarTabelaReceitaOrcamentaria()
    {
        $sTitulo = "RECEITA ORÇAMENTÁRIA";
        $this->bHistoricoComCabecalho = FALSE;

        if (!array_key_exists(ReceitaTipoReceitaRepositoryLegacy::ORCAMENTARIA, $this->aDadosRelatorio))
            return;

        $this->AddPage();
        $this->montarIniciadoresPDF();
        $this->definirPropriedadesDeExibicao();
        $this->montarTitulo($sTitulo);

        foreach ($this->aDadosRelatorio['O'] as $tipo => $oReceita) {
            if (is_array($oReceita)) {
                if ($tipo == "CGM") {
                    $this->preencherDadosReceitaContribuinte($sTitulo, $oReceita, 'O');
                    continue;
                }

                if ($tipo == "RECEITA") {
                    $this->preencherDadosAnaliticoReceita($sTitulo, $oReceita, 'O');
                    continue;
                }
                
                if ($tipo == "OPCREDITO") {
                    $this->preencherDadosOperacaoCredito($sTitulo, $oReceita, 'O');
                    continue;
                }
            }

            $this->preencherDadosReceita($sTitulo, $oReceita);
        }

        $this->setfont('arial', 'B', 7);
        $this->cell($this->PDFiTamanhoDescricaoTotal, 4, "TOTAL ...", 1, 0, "L", 0);
        $this->cell(25, 4, db_formatar($this->totalOrcamentaria, 'f'), 1, 1, "R", 0);
    }

    public function preencherDadosOperacaoCredito($sTitulo, $oReceita, $sTipo)
    {
        foreach ($oReceita as $opCredito => $oReceitaOpCredito) {
            $this->ln(2);
            $this->setfont('arial', 'b', 7);
            $this->cell(($this->PDFiTamanhoDescricaoTotal + 25), 6, $opCredito, 1, 1, "L", 1);
            $this->totalOpCredito = 0;
            foreach ($oReceitaOpCredito as $oReceitaFinal) {
                if ($sTipo == "O") {
                    $this->preencherDadosReceita($sTitulo, $oReceitaFinal);
                    continue;
                }
                $this->preencherDadosReceitaExtraOrcamentaria($sTitulo, $oReceitaFinal);
            }
            $this->setfont('arial', 'b', 7);
            $this->cell($this->PDFiTamanhoDescricaoTotal, 4, "TOTAL OPERAÇÃO DE CRÉDITO...", 1, 0, "L", 0);
            $this->cell(25, 4, db_formatar($this->totalOpCredito, 'f'), 1, 1, "R", 0);
            $this->ln(2);
        }
    }

    public function preencherDadosAnaliticoReceita($sTitulo, $oReceita, $sTipo)
    {
        foreach ($oReceita as $codigoReceita => $oReceitaContribuinte) {
            $this->ln(2);
            $this->setfont('arial', 'b', 7);
            $this->cell(260, 6, $codigoReceita, 1, 1, "L", 1);
            $this->totalReceita = 0;
            foreach ($oReceitaContribuinte as $oReceitaFinal) {
                if ($sTipo == "O") {
                    $this->preencherDadosReceita($sTitulo, $oReceitaFinal);
                    continue;
                }
                $this->preencherDadosReceitaExtraOrcamentaria($sTitulo, $oReceitaFinal);
            }
            $this->setfont('arial', 'b', 7);
            $this->cell($this->PDFiTamanhoDescricaoTotal, 4, "TOTAL RECEITA...", 1, 0, "L", 0);
            $this->cell(25, 4, db_formatar($this->totalReceita, 'f'), 1, 1, "R", 0);
            $this->ln(2);
        }
    }

    public function preencherDadosReceitaContribuinte($sTitulo, $oReceita, $sTipo)
    {
        foreach ($oReceita as $cgm => $oReceitaContribuinte) {
            $this->ln(2);
            $this->setfont('arial', 'b', 7);
            $this->cell(($this->PDFiTamanhoDescricaoTotal + 25), 6, $cgm, 1, 1, "L", 1);
            $this->totalCGM = 0;
            foreach ($oReceitaContribuinte as $oReceitaFinal) {
                if ($sTipo == "O") {
                    $this->preencherDadosReceita($sTitulo, $oReceitaFinal);
                    continue;
                }
                $this->preencherDadosReceitaExtraOrcamentaria($sTitulo, $oReceitaFinal);
            }
            $this->setfont('arial', 'b', 7);
            $this->cell($this->PDFiTamanhoDescricaoTotal, 4, "TOTAL CGM...", 1, 0, "L", 0);
            $this->cell(25, 4, db_formatar($this->totalCGM, 'f'), 1, 1, "R", 0);
            $this->ln(2);
        }
    }

    public function preencherDadosReceita($sTitulo, $oReceita)
    {
        $this->definirPropriedadesDeExibicao();
        if ($this->gety() > $this->h - 30) {
            $this->addpage();
            $this->montarTitulo($sTitulo);
        }
        $this->montarDados($oReceita);
        $this->definirFundoColorido();

        $this->totalOrcamentaria += $oReceita->valor;
        $this->totalCGM += $oReceita->valor;
        $this->totalReceita += $oReceita->valor;
        $this->totalOpCredito += $oReceita->valor;
    }

    public function preencherDadosReceitaExtraOrcamentaria($sTitulo, $oReceita)
    {
        $this->definirPropriedadesDeExibicao();
        
        if ($this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO || $this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO_RECEITA) {
            $this->PDFbFinalValor = 1;
        }
        
        if ($this->gety() > $this->h - 30) {
            $this->addpage();
            $this->montarTitulo($sTitulo);
        }
            
        $this->montarDados($oReceita);
        $this->definirFundoColorido();
        $this->totalExtra += $oReceita->valor;
        $this->totalCGM += $oReceita->valor;
        $this->totalReceita += $oReceita->valor;
        $this->totalOpCredito += $oReceita->valor;
    }

    /**
     * @return void
     */
    public function montarTabelaReceitaExtraOrcamentaria()
    {
        $sTitulo = "RECEITA EXTRA-ORÇAMENTÁRIA";
        $this->bHistoricoComCabecalho = FALSE;

        if (!array_key_exists(ReceitaTipoReceitaRepositoryLegacy::EXTRA, $this->aDadosRelatorio))
            return;

        if (!array_key_exists(ReceitaTipoReceitaRepositoryLegacy::ORCAMENTARIA, $this->aDadosRelatorio))
            $this->AddPage();

        if (
            $this->gety() > $this->h - 30
            and array_key_exists(ReceitaTipoReceitaRepositoryLegacy::ORCAMENTARIA, $this->aDadosRelatorio)
        ) {
            $this->AddPage();
        }

        $this->montarIniciadoresPDF();
        $this->definirPropriedadesDeExibicao();
        
        if ($this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO || $this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO_RECEITA)
            $this->PDFbFinalValor = 1;

        $this->montarTitulo($sTitulo);

        foreach ($this->aDadosRelatorio['E'] as $tipo => $oReceita) {
            if (is_array($oReceita)) {
                if ($tipo == "CGM") {
                    $this->preencherDadosReceitaContribuinte($sTitulo, $oReceita, 'E');
                    continue;
                }

                if ($tipo == "RECEITA") {
                    $this->preencherDadosAnaliticoReceita($sTitulo, $oReceita, 'E');
                    continue;
                }
                
                if ($tipo == "OPCREDITO") {
                    $this->preencherDadosOperacaoCredito($sTitulo, $oReceita, 'E');
                    continue;
                }
            }

            $this->preencherDadosReceitaExtraOrcamentaria($sTitulo, $oReceita, 'E');
        }
        $this->setfont('arial', 'B', 7);
        $this->cell($this->PDFiTamanhoDescricaoTotal, 4, "TOTAL ...", 1, 0, "L", 0);
        $this->cell(25, 4, db_formatar($this->totalExtra, 'f'), 1, 1, "R", 0);
    }

    /**
     * @return void
     */
    public function montarIniciadoresPDF()
    {
        $this->ln(2);
        $this->SetTextColor(0, 0, 0);
        $this->SetFillColor(220);
    }

    /**
     * @return void
     */
    public function definirFundoColorido()
    {
        if ($this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO || $this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO_RECEITA) {
            if ($this->preencherCelula == 0) {
                $this->preencherCelula = 1;
                return;
            }
            $this->preencherCelula = 0;
            return;
        }
        return;
    }

    /**
     * @param stdClass $oReceita
     * @return void
     */
    public function montarDados($oReceita)
    {
        $this->setfont('arial', '', 7);

        if ($this->sTipo != ReceitaTipoRepositoryLegacy::ESTRUTURAL) {
            $this->cell(10, 4, $oReceita->codigo, 1, 0, "C", $this->preencherCelula);
            $this->cell(10, 4, $oReceita->reduzido, 1, 0, "C", $this->preencherCelula);
        }

        if ($this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO || $this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO_RECEITA) {
            $this->Cell(15, 4, $oReceita->data, 1, 0, "C", $this->preencherCelula);
            $this->montarCamposNumpreETamanhoEstruturalAnalitico($oReceita);
        }

        $this->cell($this->PDFiTamanhoEstrutural, 4, $oReceita->estrutural, 1, 0, "C", $this->preencherCelula);
        $this->cell($this->PDFiTamanhoTitulo, 4, strtoupper($oReceita->descricao), 1, 0, "L", $this->preencherCelula);

        if ($this->sTipo == ReceitaTipoRepositoryLegacy::CONTA) {
            $this->cell(15, 4, $oReceita->conta, 1, 0, "C", $this->preencherCelula);
            $this->cell(60, 4, substr($oReceita->conta_descricao, 0, 37), 1, 0, "L", $this->preencherCelula);
        }

        $this->cell(25, 4, db_formatar($oReceita->valor, 'f'), 1, $this->PDFbFinalValor, "R", $this->preencherCelula);
        if ($this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO || $this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO_RECEITA) {
            $this->montarCamposHistoricoEContaDescricaoAnalitico($oReceita);
        }
    }

    /**
     * @param stdClass $oReceita
     * @return void
     */
    public function montarCamposNumpreETamanhoEstruturalAnalitico($oReceita)
    {
        if ($oReceita->tipo == "O") {
            $this->Cell(15, 4, $oReceita->numpre, 1, 0, "C", $this->preencherCelula);
            return;
        }

        if ($oReceita->tipo == "E") {
            $this->PDFiTamanhoTitulo += 80;
            $this->PDFiTamanhoEstrutural += 15;
            $this->PDFiTamanhoDescricaoTotal += 80;
            return;
        }
    }

    /**
     * @param stdClass $oReceita
     * @return void
     */
    public function montarCamposHistoricoEContaDescricaoAnalitico($oReceita)
    {
        if ($oReceita->tipo == "O") {
            $this->cell(15, 4, $oReceita->conta, 1, 0, "C", $this->preencherCelula);
            $this->cell(65, 4, substr($oReceita->conta_descricao, 0, 43), 1, 1, "L", $this->preencherCelula);
        }
        if (trim($oReceita->historico) != '' and ($this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO || $this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO_RECEITA)) {
            $this->multicell($this->PDFiHistorico, 4, "{$this->PDFsTituloHistorico}{$oReceita->historico}", 1, "L", $this->preencherCelula);
        }
        if (trim($oReceita->historico) == '' and ($this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO || $this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO_RECEITA) and $oReceita->tipo == "E") {
            $this->multicell($this->PDFiHistorico, 4, "", 1, "L", $this->preencherCelula);
        }
    }

    public function definirPropriedadesDeExibicao()
    {
        $this->PDFiTamanhoEstrutural = 40;
        $this->PDFiTamanhoTitulo = 100;
        $this->PDFbFinalValor = 0;
        $this->PDFiTamanhoDescricaoTotal = 230;
        $this->PDFiTamanhoDescricaoTotal = 230;
        $this->PDFsTituloHistorico = "HISTÓRICO :  ";
        $this->PDFiHistorico = 260;
        if (in_array($this->sTipo, array(ReceitaTipoRepositoryLegacy::ESTRUTURAL, ReceitaTipoRepositoryLegacy::RECEITA))) {
            $this->PDFbFinalValor = 1;
            $this->PDFiTamanhoDescricaoTotal = 160;
            if ($this->sTipo == ReceitaTipoRepositoryLegacy::ESTRUTURAL) {
                $this->PDFiTamanhoDescricaoTotal = 140;
            }
            return;
        }

        if ($this->sTipo == ReceitaTipoRepositoryLegacy::CONTA) {
            $this->PDFbFinalValor = 1;
            $this->PDFiTamanhoDescricaoTotal = 235;
            return;
        }

        if ($this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO || $this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO_RECEITA) {
            if ($this->bHistoricoComCabecalho) {
                $this->PDFsTituloHistorico = "";
                $this->PDFiHistorico = 80;
            }
            $this->PDFiTamanhoDescricaoTotal = 155;
            $this->PDFiTamanhoEstrutural = 25;
            $this->PDFiTamanhoTitulo = 80;
            return;
        }
    }

    public function montarTitulo($sTitulo)
    {
        $bReveterTamanhoEstrutural = false;
        $this->SetFont('Arial', 'B', 9);
        if ($this->sTipo != ReceitaTipoRepositoryLegacy::ESTRUTURAL) {
            $this->Cell(10, 6, "COD", 1, 0, "C", 1);
            $this->Cell(10, 6, "RED", 1, 0, "C", 1);
        }
        if ($this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO || $this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO_RECEITA) {
            $this->Cell(15, 6, "DATA", 1, 0, "C", 1);
            if ($sTitulo == "RECEITA ORÇAMENTÁRIA") {
                $this->Cell(15, 6, "NUMPRE", 1, 0, "C", 1);
            } else {
                $this->PDFiTamanhoTitulo += 80;
                $this->PDFiTamanhoEstrutural += 15;
                $bReveterTamanhoEstrutural = true;
            }
        }
        $this->Cell($this->PDFiTamanhoEstrutural, 6, "ESTRUTURAL", 1, 0, "C", 1);
        $this->Cell($this->PDFiTamanhoTitulo, 6, $sTitulo, 1, 0, "C", 1);
        if ($bReveterTamanhoEstrutural) {
            $this->PDFiTamanhoTitulo -= 80;
            $this->PDFiTamanhoEstrutural -= 15;
        }
        if ($this->sTipo == ReceitaTipoRepositoryLegacy::CONTA) {
            $this->Cell(15, 6, "CONTA", 1, 0, "C", 1);
            $this->Cell(60, 6, "DESCRIÇÃO CONTA", 1, 0, "C", 1);
        }
        
        $this->Cell(25, 6, "VALOR", 1, $this->PDFbFinalValor, "C", 1);

        if (($this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO || $this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO_RECEITA) and $sTitulo == "RECEITA ORÇAMENTÁRIA") {
            $this->Cell(15, 6, "CONTA", 1, 0, "C", 1);
            $this->Cell(65, 6, "DESCRIÇÃO", 1, 1, "C", 1);
        }

        if ($this->bHistoricoComCabecalho and ($this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO || $this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO_RECEITA))
            $this->Cell(80, 6, "HISTÓRICO", 1, 1, "C", 1);
    }
}
