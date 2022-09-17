<?php

namespace model\caixa\relatorios;

use PDF;
use interfaces\caixa\relatorios\IReceitaPeriodoTesourariaRepository;

require_once "fpdf151/pdf.php";
require_once "interfaces/caixa/relatorios/IReceitaPeriodoTesourariaRepository.php";

class ReceitaPeriodoTesouraria extends PDF
{
    private $aDadosRelatorio = array();

    /**
     * @var IReceitaPeriodoTesourariaRepository
     */
    private $oRelatorioReceitaPeriodoTesouraria;

    public function __construct($RelatorioReceitaPeriodoTesourariaLegacy)
    {
        global $head3, $head4, $head5;
        $this->oRelatorioReceitaPeriodoTesourariaLegacy = $RelatorioReceitaPeriodoTesourariaLegacy;
        $this->pegarDadosRelatorio();

        parent::__construct($this->oRelatorioReceitaPeriodoTesourariaLegacy->pegarFormatoPagina());

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
