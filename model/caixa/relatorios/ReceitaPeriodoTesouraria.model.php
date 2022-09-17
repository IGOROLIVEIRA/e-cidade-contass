<?php

namespace model\caixa\relatorios;

use PDF;
use interfaces\caixa\relatorios\IReceitaPeriodoTesourariaRepository;
use repositories\caixa\relatorios\ReceitaTipoRepositoryLegacy;

require_once "fpdf151/pdf.php";
require_once "interfaces/caixa/relatorios/IReceitaPeriodoTesourariaRepository.php";
require_once "repositories/caixa/relatorios/ReceitaTipoRepositoryLegacy.php";

class ReceitaPeriodoTesouraria extends PDF
{
    private $aDadosRelatorio = array();
    private $preencherCelula = 0;
    private $totalOrcamentaria = 0;
    private $totalExtra = 0;
    private $totalRecursos = 0;

    /**
     * @var IReceitaPeriodoTesourariaRepository
     */
    private $oReceitaPeriodoTesourariaRepository;

    public function __construct($sTipoReceita, $oReceitaPeriodoTesourariaLegacy)
    {
        global $head3, $head4, $head5;
        $this->oReceitaPeriodoTesourariaRepository = $oReceitaPeriodoTesourariaLegacy;
        $this->sTipoReceita = $sTipoReceita;
        $this->definirCabecalho();

        $head3 = $this->tituloRelatorio;
        $head4 = $this->tituloTipoReceita;
        parent::__construct($this->oReceitaPeriodoTesourariaRepository->pegarFormatoPagina());
    }

    public function definirCabecalho()
    {
        $this->tituloRelatorio = "RELATÓRIO DE RECEITAS ARRECADADAS";
        $this->tituloTipoReceita = $this->definirTituloTipoReceita();
    }

    public function definirTituloTipoReceita()
    {
        if ($this->sTipoReceita == ReceitaTipoRepositoryLegacy::TODOS)
            return 'TODAS AS RECEITAS';

        if ($this->sTipoReceita == ReceitaTipoRepositoryLegacy::ORCAMENTARIA)
            return 'RECEITAS ORÇAMENTÁRIAS';

        if ($this->sTipoReceita == ReceitaTipoRepositoryLegacy::EXTRA)
            return 'RECEITAS EXTRA-ORÇAMENTÁRIAS';
    }

    public function processar()
    {
        $this->Open();
        $this->AliasNbPages();
        $this->aDadosRelatorio = $this->pegarDados();
        if (count($this->aDadosRelatorio) == 0) {
            db_redireciona('db_erros.php?fechar=true&db_erro=Não existem lançamentos para a receita');
        }
        $this->montarTabelaReceitaOrcamentaria();
        $this->montarTabelaReceitaExtraOrcamentaria();
        $this->montarTotalGeral();
        $this->Output();
    }

    public function pegarDados()
    {
        return $this->oReceitaPeriodoTesourariaRepository->pegarDados();
    }

    public function montarTabelaReceitaOrcamentaria()
    {
        if (!array_key_exists(ReceitaTipoRepositoryLegacy::ORCAMENTARIA, $this->aDadosRelatorio))
            return;

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
        if (!array_key_exists(ReceitaTipoRepositoryLegacy::EXTRA, $this->aDadosRelatorio))
            return;

        $this->ln(2);

        if (!array_key_exists(ReceitaTipoRepositoryLegacy::ORCAMENTARIA, $this->aDadosRelatorio))
            $this->AddPage();

        if ($this->gety() > $this->h - 30 
            AND array_key_exists(ReceitaTipoRepositoryLegacy::ORCAMENTARIA, $this->aDadosRelatorio)
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

    public function montarTotalGeral()
    {
        $this->cell(160, 4, "TOTAL GERAL", 1, 0, "L", 0);
        $this->cell(25, 4, db_formatar($this->totalOrcamentaria + $this->totalExtra, 'f'), 1, 1, "R", 0);
        $this->ln(5);

        $this->cell(110, 4, "DEMONSTRATIVO DO DESDOBRAMENTO DA RECEITA LIVRE", 1, 1, "L", 0);
        /*
        VER COMO FUNCIONA O TOTAL POR RECURSOS
                
          $totalrecursos=0;
          while (list ($key, $valor) = each($valatu)) {
              $totalrecursos += $valor;
          }
      
        reset($valatu);
      
          while (list ($key, $valor) = each($valatu)) {
              $this->cell(70, 5, $key, 0, 0, "L", 0, 0, ".");
              $this->cell(20, 5, db_formatar($valor, 'f'), 0, 0, "R", 0);
              $this->cell(20, 5, db_formatar($valor / $totalrecursos * 100, 'p') . "%", 0, 1, "R", 0);
          }
  
          */
        $this->setfont('arial', 'B', 7);
        $this->cell(110, 5, db_formatar($this->totalRecursos, 'f'), 1, 1, "R", 0);
    }
}
