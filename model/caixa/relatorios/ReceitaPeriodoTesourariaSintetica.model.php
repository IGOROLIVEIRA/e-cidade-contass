<?php

namespace model\caixa\relatorios;

use model\caixa\relatorios\ReceitaPeriodoTesouraria;
use repositories\caixa\relatorios\ReceitaPeriodoTesourariaSinteticaRepositoryLegacy;
use repositories\caixa\relatorios\ReceitaTipoRepositoryLegacy;

require_once 'model/caixa/relatorios/ReceitaPeriodoTesouraria.model.php';
require_once "repositories/caixa/relatorios/ReceitaPeriodoTesourariaSinteticaRepositoryLegacy.php";
require_once "repositories/caixa/relatorios/ReceitaTipoRepositoryLegacy.php";

class ReceitaPeriodoTesourariaSintetica extends ReceitaPeriodoTesouraria
{
    /**
     * @var IReceitaPeriodoTesourariaRepository;
     */
    private $oReceitaPeriodoTesourariaRepository;
    public $aDadosRelatorio = array();
    private $preencherCelula = 0;
    
    public function __construct(
        $sTipo,
        $sTipoReceita,
        $iFormaArrecadacao,
        $sOrdem,
        $dDataInicial,
        $dDataFinal,
        $sDesdobramento,
        $iEmendaParlamentar,
        $iRegularizacaoRepasse,
        $iInstituicao,
        $sReceitas = NULL,
        $sEstrutura = NULL,
        $sContas = NULL,
        $sContribuintes = NULL
    ) {
        $this->oReceitaPeriodoTesourariaRepository = new ReceitaPeriodoTesourariaSinteticaRepositoryLegacy(
            $sTipo,
            $sTipoReceita,
            $iFormaArrecadacao,
            $sOrdem,
            $dDataInicial,
            $dDataFinal,
            $sDesdobramento,
            $iEmendaParlamentar,
            $iRegularizacaoRepasse,
            $iInstituicao,
            $sReceitas,
            $sEstrutura,
            $sContas,
            $sContribuintes
        );
        $this->aDadosRelatorio = $this->pegarDados();
        parent::__construct($sTipoReceita, $dDataInicial, $dDataFinal, $this->oReceitaPeriodoTesourariaRepository->pegarFormatoPagina());
    }

    public function montarTabelaReceitaOrcamentaria()
    {
        parent::montarTabelaReceitaOrcamentaria();

        $this->ln(2);
        $this->AddPage();
        $this->SetTextColor(0, 0, 0);
        $this->SetFillColor(220);
        $this->montarTituloOrcamentario();

        foreach ($this->aDadosRelatorio['O'] as $oReceita) {
            if ($this->gety() > $this->h - 30) {
                $this->addpage();
                $this->montarTituloOrcamentario();
            }
            $this->setfont('arial', '', 7);
            $this->cell(10, 4, $oReceita->codigo, 1, 0, "C", $this->preencherCelula);
            $this->cell(10, 4, $oReceita->reduzido, 1, 0, "C", $this->preencherCelula);
            $this->cell(40, 4, $oReceita->estrutural, 1, 0, "C", $this->preencherCelula);
            $this->cell(100, 4, strtoupper($oReceita->descricao), 1, 0, "L", $this->preencherCelula);
            /*
            if ($sinana == 'S3') {
                $this->cell(15, 4, $c61_reduz, 1, 0, "C", $this->preencherCelula);
                $this->cell(60, 4, $c60_descr, 1, 0, "L", $this->preencherCelula);
            }
            */
            $this->cell(25, 4, db_formatar($oReceita->valor, 'f'), 1, 1, "R", $this->preencherCelula);
            $this->totalOrcamentaria += $oReceita->valor;
        }

        # SE TEM DESDOBRAMENTO

        $this->setfont('arial', 'B', 7);
        $this->cell(160, 4, "TOTAL ...", 1, 0, "L", 0);
        /*    } elseif ($sinana == 'S3') {
      $this->cell(235, 4, "TOTAL ...", 1, 0, "L", 0);
    } */
        $this->cell(25, 4, db_formatar($this->totalOrcamentaria, 'f'), 1, 1, "R", 0);
    }

    public function montarTabelaReceitaExtraOrcamentaria()
    {
        parent::montarTabelaReceitaExtraOrcamentaria();

        $this->ln(2);

        if (!array_key_exists(ReceitaTipoRepositoryLegacy::ORCAMENTARIA, $this->aDadosRelatorio))
            $this->AddPage();

        if (
            $this->gety() > $this->h - 30
            and array_key_exists(ReceitaTipoRepositoryLegacy::ORCAMENTARIA, $this->aDadosRelatorio)
        ) {
            $this->AddPage();
        }

        $this->SetTextColor(0, 0, 0);
        $this->SetFillColor(220);
        $this->montarTituloExtra();
        foreach ($this->aDadosRelatorio['E'] as $oReceita) {
            if ($this->gety() > $this->h - 30) {
                $this->AddPage();
                $this->montarTituloExtra();
            }
            $this->setfont('arial', '', 7);
            $this->cell(10, 4, $oReceita->codigo, 1, 0, "C", $this->preencherCelula);
            $this->cell(10, 4, $oReceita->reduzido, 1, 0, "C", $this->preencherCelula);
            $this->cell(40, 4, $oReceita->estrutural, 1, 0, "C", $this->preencherCelula);
            $this->cell(100, 4, strtoupper($oReceita->descricao), 1, 0, "L", $this->preencherCelula);
            // if ($sinana == 'S3') {
            // $this->cell(15, 4, $c61_reduz, 1, 0, "C", $this->preencherCelula);
            // $this->cell(60, 4, $c60_descr, 1, 0, "L", $this->preencherCelula);
            // }
            $this->cell(25, 4, db_formatar($oReceita->valor, 'f'), 1, 1, "R", $this->preencherCelula);
            $this->totalExtra += $oReceita->valor;
        }
        $this->setfont('arial', 'B', 7);
        $this->cell(160, 4, "TOTAL ...", 1, 0, "L", 0);
        $this->cell(25, 4, db_formatar($this->totalExtra, 'f'), 1, 1, "R", 0);
    }

    public function montarTituloOrcamentario()
    {
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(10, 6, "COD", 1, 0, "C", 1);
        $this->Cell(10, 6, "RED", 1, 0, "C", 1);
        $this->Cell(40, 6, "ESTRUTURAL", 1, 0, "C", 1);
        $this->Cell(100, 6, "RECEITA ORÇAMENTÁRIA", 1, 0, "C", 1);
        // if ($sinana == 'S3') {
        //     $this->Cell(15, 6, "CONTA", 1, 0, "C", 1);
        //     $this->Cell(60, 6, "DESCRIÇÃO CONTA", 1, 0, "C", 1);
        // }
        $this->Cell(25, 6, "VALOR", 1, 1, "C", 1);
        $this->SetFont('Arial', 'B', 9);
    }

    public function montarTituloExtra()
    {
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(10, 6, "COD", 1, 0, "C", 1);
        $this->Cell(10, 6, "RED", 1, 0, "C", 1);
        $this->Cell(40, 6, "ESTRUTURAL", 1, 0, "C", 1);
        $this->Cell(100, 6, "RECEITA EXTRA-ORÇAMENTÁRIA", 1, 0, "C", 1);
        // if ($sinana == 'S3') {
        //    $this->Cell(15, 6, "CONTA", 1, 0, "C", 1);
        //    $this->Cell(60, 6, "DESCRIÇÃO CONTA", 1, 0, "L", 1);
        // }
        $this->Cell(25, 6, "VALOR", 1, 1, "C", 1);
    }

    public function pegarDados()
    {
        return $this->oReceitaPeriodoTesourariaRepository->pegarDados();
    }
}
