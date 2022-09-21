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

class ReceitaPeriodoTesouraria extends PDF
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
        $this->montarTabelaReceitaOrcamentaria();
        $this->montarTabelaReceitaExtraOrcamentaria();
        $this->montarTotalGeral();
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

    public function montarTabelaReceitaOrcamentaria()
    {
        if (!array_key_exists(ReceitaTipoReceitaRepositoryLegacy::ORCAMENTARIA, $this->aDadosRelatorio))
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
            $this->montarDados($oReceita);
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
        $this->montarTituloExtra();
        foreach ($this->aDadosRelatorio['E'] as $oReceita) {
            if ($this->gety() > $this->h - 30) {
                $this->AddPage();
                $this->montarTituloExtra();
            }
            $this->montarDados($oReceita);
            $this->totalExtra += $oReceita->valor;
        }
        $this->setfont('arial', 'B', 7);
        $this->cell(160, 4, "TOTAL ...", 1, 0, "L", 0);
        $this->cell(25, 4, db_formatar($this->totalExtra, 'f'), 1, 1, "R", 0);
    }

    public function montarDados($oReceita)
    {
        $this->setfont('arial', '', 7);
        if ($this->sTipo != ReceitaTipoRepositoryLegacy::ESTRUTURAL) {
            $this->cell(10, 4, $oReceita->codigo, 1, 0, "C", $this->preencherCelula);
            $this->cell(10, 4, $oReceita->reduzido, 1, 0, "C", $this->preencherCelula);
        }
        $this->cell(40, 4, $oReceita->estrutural, 1, 0, "C", $this->preencherCelula);
        $this->cell(100, 4, strtoupper($oReceita->descricao), 1, 0, "L", $this->preencherCelula);
        /*
            if ($sinana == 'S3') {
                $this->cell(15, 4, $c61_reduz, 1, 0, "C", $this->preencherCelula);
                $this->cell(60, 4, $c60_descr, 1, 0, "L", $this->preencherCelula);
            }
            */
        $this->cell(25, 4, db_formatar($oReceita->valor, 'f'), 1, 1, "R", $this->preencherCelula);
    }

    public function montarTituloOrcamentario()
    {
        $this->SetFont('Arial', 'B', 9);
        if ($this->sTipo != ReceitaTipoRepositoryLegacy::ESTRUTURAL) {
            $this->Cell(10, 6, "COD", 1, 0, "C", 1);
            $this->Cell(10, 6, "RED", 1, 0, "C", 1);
        }
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
        $this->aDadosRelatorio = $this->oReceitaPeriodoTesourariaRepository->pegarDados();
    }
}
