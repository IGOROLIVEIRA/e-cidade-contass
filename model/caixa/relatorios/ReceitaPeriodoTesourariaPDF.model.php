<?php

namespace model\caixa\relatorios;

use PDF;
use repositories\caixa\relatorios\ReceitaTipoReceitaRepositoryLegacy;
use repositories\caixa\relatorios\ReceitaTipoRepositoryLegacy;
use repositories\caixa\relatorios\ReceitaFormaArrecadacaoRepositoryLegacy;
use interfaces\caixa\relatorios\IReceitaPeriodoTesourariaRepository;

require_once "fpdf151/pdf.php";
require_once "repositories/caixa/relatorios/ReceitaTipoReceitaRepositoryLegacy.php";
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

    public function definirCabecalho()
    {
        $this->tituloRelatorio = "RELATÓRIO DE RECEITAS ARRECADADAS";
        $this->tituloTipoReceita = $this->definirTituloTipoReceita();
        $this->tituloPeriodo = $this->definirTituloPeriodo();
        $this->tituloFormaArrecadacao = $this->definirTituloFormaArrecadacao();
    }

    public function definirTituloTipoReceita()
    {
        if ($this->sTipoReceita == ReceitaTipoReceitaRepositoryLegacy::TODOS)
            return 'TODAS AS RECEITAS';

        if ($this->sTipoReceita == ReceitaTipoReceitaRepositoryLegacy::ORCAMENTARIA)
            return 'RECEITAS ORÇAMENTÁRIAS';

        if ($this->sTipoReceita == ReceitaTipoReceitaRepositoryLegacy::EXTRA)
            return 'RECEITAS EXTRA-ORÇAMENTÁRIAS';
    }

    public function definirTituloPeriodo()
    {
        return "Período : " . db_formatar($this->dDataInicial, 'd') . " a " . db_formatar($this->dDataFinal, 'd');
    }

    public function processar()
    {
        $this->Open();
        $this->AliasNbPages();
        if (count($this->aDadosRelatorio) == 0) {
            db_redireciona('db_erros.php?fechar=true&db_erro=Não existem lançamentos para a receita');
        }
        if ($this->sTipo != ReceitaTipoRepositoryLegacy::DIARIO) {
            $this->montarTabelaReceitaOrcamentaria();
            $this->montarTabelaReceitaExtraOrcamentaria();
            $this->montarTotalGeral();
        } else {
            $this->montarTabelaReceitaDiaria();
        }

        $this->Output();
    }

    public function definirTituloFormaArrecadacao()
    {
        if ($this->iFormaArrecadacao == ReceitaFormaArrecadacaoRepositoryLegacy::TODAS)
            return 'Forma de Arrecadação: Todas';

        if ($this->iFormaArrecadacao == ReceitaFormaArrecadacaoRepositoryLegacy::ARQUIVO_BANCARIO)
            return 'Forma de Arrecadação: Via arquivo bancário';

        if ($this->iFormaArrecadacao == ReceitaFormaArrecadacaoRepositoryLegacy::EXCETO_ARQUIVO_BANCARIO)
            return 'Forma de Arrecadação: Exceto via arquivo bancário';
    }

    public function montarTotalGeral()
    {
        $this->cell($this->PDFiTamanhoDescricaoTotal, 4, "TOTAL GERAL", 1, 0, "L", 0);
        $this->cell(25, 4, db_formatar($this->totalOrcamentaria + $this->totalExtra, 'f'), 1, 1, "R", 0);
        $this->ln(5);

        $this->cell(110, 4, "DEMONSTRATIVO DO DESDOBRAMENTO DA RECEITA LIVRE", 1, 1, "L", 0);
        $this->setfont('arial', 'B', 7);
        $this->cell(110, 5, db_formatar($this->totalRecursos, 'f'), 1, 1, "R", 0);
    }

    public function montarTabelaReceitaOrcamentaria()
    {
        $sTitulo = "RECEITA ORÇAMENTÁRIA";
        $this->bHistoricoComCabecalho = FALSE;

        if (!array_key_exists(ReceitaTipoReceitaRepositoryLegacy::ORCAMENTARIA, $this->aDadosRelatorio))
            return;

        $this->ln(2);
        $this->AddPage();
        $this->SetTextColor(0, 0, 0);
        $this->SetFillColor(220);
        $this->montarTitulo($sTitulo);

        foreach ($this->aDadosRelatorio['O'] as $oReceita) {
            if ($this->gety() > $this->h - 30) {
                $this->addpage();
                $this->montarTitulo($sTitulo);
            }
            $this->montarDados($oReceita);
            $this->definirFundoColorido();
            $this->totalOrcamentaria += $oReceita->valor;
        }

        $this->setfont('arial', 'B', 7);
        $this->cell($this->PDFiTamanhoDescricaoTotal, 4, "TOTAL ...", 1, 0, "L", 0);
        $this->cell(25, 4, db_formatar($this->totalOrcamentaria, 'f'), 1, 1, "R", 0);
    }

    public function montarTabelaReceitaExtraOrcamentaria()
    {
        $sTitulo = "RECEITA EXTRA-ORÇAMENTÁRIA";
        $this->bHistoricoComCabecalho = TRUE;

        if (!array_key_exists(ReceitaTipoReceitaRepositoryLegacy::EXTRA, $this->aDadosRelatorio))
            return;

        $this->ln(2);

        if (!array_key_exists(ReceitaTipoReceitaRepositoryLegacy::ORCAMENTARIA, $this->aDadosRelatorio))
            $this->AddPage();

        if (
            $this->gety() > $this->h - 30
            and array_key_exists(ReceitaTipoReceitaRepositoryLegacy::ORCAMENTARIA, $this->aDadosRelatorio)
        ) {
            $this->AddPage();
        }

        $this->SetTextColor(0, 0, 0);
        $this->SetFillColor(220);
        $this->montarTitulo($sTitulo);
        $this->preencherCelula = 0;
        foreach ($this->aDadosRelatorio['E'] as $oReceita) {
            if ($this->gety() > $this->h - 30) {
                $this->AddPage();
                $this->montarTitulo($sTitulo);
            }
            $this->montarDados($oReceita);
            $this->totalExtra += $oReceita->valor;
        }
        $this->setfont('arial', 'B', 7);
        $this->cell($this->PDFiTamanhoDescricaoTotal, 4, "TOTAL ...", 1, 0, "L", 0);
        $this->cell(25, 4, db_formatar($this->totalExtra, 'f'), 1, 1, "R", 0);
    }

    public function definirFundoColorido()
    {
        if ($this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO) {
            if ($this->preencherCelula == 0) {
                $this->preencherCelula = 1;
                return;
            }
            $this->preencherCelula = 0;
            return;
        }
        return;
    }

    public function montarDados($oReceita)
    {
        $this->definirPropriedadesDeExibicao();
        $this->setfont('arial', '', 7);
        if ($this->sTipo != ReceitaTipoRepositoryLegacy::ESTRUTURAL) {
            $this->cell(10, 4, $oReceita->codigo, 1, 0, "C", $this->preencherCelula);
            $this->cell(10, 4, $oReceita->reduzido, 1, 0, "C", $this->preencherCelula);
        }
        if ($this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO) {
            $this->Cell(15, 4, $oReceita->data, 1, 0, "C", $this->preencherCelula);
            if ($oReceita->tipo == "O") {
                $this->Cell(15, 4, $oReceita->numpre, 1, 0, "C", $this->preencherCelula);
            }
            if ($oReceita->tipo == "E") {
                $this->PDFiTamanhoEstrutural += 15;
            }
        }
        $this->cell($this->PDFiTamanhoEstrutural, 4, $oReceita->estrutural, 1, 0, "C", $this->preencherCelula);
        $this->cell($this->PDFiTamanhoTitulo, 4, strtoupper($oReceita->descricao), 1, 0, "L", $this->preencherCelula);
        if ($this->sTipo == ReceitaTipoRepositoryLegacy::CONTA) {
            $this->cell(15, 4, $oReceita->conta, 1, 0, "C", $this->preencherCelula);
            $this->cell(60, 4, substr($oReceita->conta_descricao, 0, 37), 1, 0, "L", $this->preencherCelula);
        }
        $this->cell(25, 4, db_formatar($oReceita->valor, 'f'), 1, $this->PDFbFinalValor, "R", $this->preencherCelula);
        if ($this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO) {
            if ($oReceita->tipo == "O") {
                $this->cell(15, 4, $oReceita->conta, 1, 0, "C", $this->preencherCelula);
                $this->cell(65, 4, $oReceita->conta_descricao, 1, 1, "L", $this->preencherCelula);
            }
            if (trim($oReceita->historico) != '' and $this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO) {
                $this->multicell($this->PDFiHistorico, 4, "{$this->PDFsTituloHistorico}{$oReceita->historico}", 1, "L", $this->preencherCelula);
            }
            if (trim($oReceita->historico) == '' and $this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO and $oReceita->tipo == "E") {
                $this->multicell($this->PDFiHistorico, 4, "", 1, "L", $this->preencherCelula);
            }
        }
    }

    public function definirPropriedadesDeExibicao()
    {
        $this->PDFiTamanhoEstrutural = 40;
        $this->PDFiTamanhoTitulo = 100;
        $this->PDFbFinalValor = 0;
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

        if ($this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO) {
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
        $this->definirPropriedadesDeExibicao();

        $this->SetFont('Arial', 'B', 9);
        if ($this->sTipo != ReceitaTipoRepositoryLegacy::ESTRUTURAL) {
            $this->Cell(10, 6, "COD", 1, 0, "C", 1);
            $this->Cell(10, 6, "RED", 1, 0, "C", 1);
        }
        if ($this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO) {
            $this->Cell(15, 6, "DATA", 1, 0, "C", 1);
            if ($sTitulo == "RECEITA ORÇAMENTÁRIA") {
                $this->Cell(15, 6, "NUMPRE", 1, 0, "C", 1);
            } else {
                $this->PDFiTamanhoEstrutural += 15;
            }
        }
        $this->Cell($this->PDFiTamanhoEstrutural, 6, "ESTRUTURAL", 1, 0, "C", 1);
        $this->Cell($this->PDFiTamanhoTitulo, 6, $sTitulo, 1, 0, "C", 1);
        if ($this->sTipo == ReceitaTipoRepositoryLegacy::CONTA) {
            $this->Cell(15, 6, "CONTA", 1, 0, "C", 1);
            $this->Cell(60, 6, "DESCRIÇÃO CONTA", 1, 0, "C", 1);
        }
        $this->Cell(25, 6, "VALOR", 1, $this->PDFbFinalValor, "C", 1);

        if ($this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO and $sTitulo == "RECEITA ORÇAMENTÁRIA") {
            $this->Cell(15, 6, "CONTA", 1, 0, "C", 1);
            $this->Cell(65, 6, "DESCRIÇÃO", 1, 1, "C", 1);
        }

        if ($this->bHistoricoComCabecalho and $this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO)
            $this->Cell(80, 6, "HISTÓRICO", 1, 1, "C", 1);
    }

    public function montarTabelaReceitaDiaria()
    {
        $this->ln(2);
        $this->AddPage();
        $this->SetTextColor(0, 0, 0);
        $this->SetFillColor(220);
        foreach ($this->aDadosRelatorio as $data => $aReceita) {
            $this->montarTituloDiario();
            if ($this->gety() > $this->h - 30) {
                $this->Addpage();
                $this->montarTituloDiario();
            }
            $totalDiario = 0;
            foreach ($aReceita as $oReceita) {
                if ($this->gety() > $this->h - 30) {
                    $this->Addpage();
                    $this->montarTituloDiario();
                }
                $this->montarDadosDiarios($oReceita);
                $this->definirFundoColorido();
                $totalDiario += $oReceita->valor;
                $this->totalGeralDiario += $oReceita->valor;
            }
            $this->setfont('arial', 'B', 7);
            $this->cell(254, 4, "SubTotal:", 1, 0, "R", 1);
            $this->cell(25, 4, db_formatar($totalDiario, 'f'), 1, 1, "R", 1);
            $this->ln(5);
        }
        $this->cell(254, 4, "Total Geral....:", 1, 0, "R", 1);
        $this->cell(25, 4, db_formatar($this->totalGeralDiario, 'f'), 1, 1, "R", 1);
        $this->ln(5);
    }

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

    public function pegarDados()
    {
        $this->aDadosRelatorio = $this->oReceitaPeriodoTesourariaRepository->pegarDados();
    }
}
