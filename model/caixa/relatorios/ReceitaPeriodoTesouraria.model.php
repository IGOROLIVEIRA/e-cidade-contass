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
    private $totalRecursos = 0;

    public function __construct($sTipoReceita, $dDataInicial, $dDataFinal, $sFormatoPagina)
    {
        global $head3, $head4, $head5, $head6;

        $this->sTipoReceita = $sTipoReceita;
        $this->dDataInicial = $dDataInicial;
        $this->dDataFinal = $dDataFinal;
        $this->definirCabecalho();

        $head3 = $this->tituloRelatorio;
        $head4 = $this->tituloTipoReceita;
        $head6 = $this->tituloPeriodo;
        parent::__construct($sFormatoPagina);
    }

    public function definirCabecalho()
    {
        $this->tituloRelatorio = "RELATÓRIO DE RECEITAS ARRECADADAS";
        $this->tituloTipoReceita = $this->definirTituloTipoReceita();
        $this->tituloPeriodo = $this->definirTituloPeriodo();
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

    public function montarTabelaReceitaOrcamentaria()
    {
        if (!array_key_exists(ReceitaTipoRepositoryLegacy::ORCAMENTARIA, $this->aDadosRelatorio))
            return;
    }

    public function montarTabelaReceitaExtraOrcamentaria()
    {
        if (!array_key_exists(ReceitaTipoRepositoryLegacy::EXTRA, $this->aDadosRelatorio))
            return;
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
