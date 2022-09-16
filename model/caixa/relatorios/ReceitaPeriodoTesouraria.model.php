<?php

namespace model\caixa\relatorios;

use PDF;
use interfaces\caixa\relatorios\IReceitaPeriodoTesourariaRepository;

require_once "fpdf151/pdf.php";
require_once "interfaces/caixa/relatorios/IReceitaPeriodoTesourariaRepository.php";

class ReceitaPeriodoTesouraria extends PDF
{
    private $sTipo;

    /**
     * @var array
     */
    private $aTipoLanscape = array("S1", "S2");

    private $aDadosRelatorio = array();

    /**
     * @var IReceitaPeriodoTesourariaRepository
     */
    private $oRelatorioReceitaPeriodoTesouraria;

    /**
     * Construtor do Relatório 
     */
    public function __construct($RelatorioReceitaPeriodoTesourariaLegacy)
    {
        global $head3, $head4, $head5;
        $this->oRelatorioReceitaPeriodoTesourariaLegacy = $RelatorioReceitaPeriodoTesourariaLegacy;
        $this->pegarDadosRelatorio();

        parent::__construct($this->oRelatorioReceitaPeriodoTesourariaLegacy->pegarTipoConstrutor());

        $this->Open();
        $this->AliasNbPages();
    }

    public function processar()
    {
        $this->Output();
    }

    public function pegarDadosRelatorio()
    {
        return $this->oRelatorioReceitaPeriodoTesourariaLegacy->pegarDados();
        // $this->aDadosRelatorios = array(); // Pegar o retorio do banco;
    }
}
