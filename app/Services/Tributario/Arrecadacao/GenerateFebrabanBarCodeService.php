<?php

namespace App\Services\Tributario\Arrecadacao;

use DateTime;
use db_impcarne;
use Exception;
use regraEmissao;
use convenio;

define('DB_BIBLIOT', true);
class GenerateFebrabanBarCodeService
{
    private regraEmissao $regraEmissao;
    private convenio $convenio;

    /**
     * @throws Exception
     */
    public function __construct(
        string $valor,
        string $vlrbar,
        string $numpre,
        int $instit,
        DateTime $date,
        DateTime $dueDate,
        string $ip,
        int $tipoMod = 2,
        int $initialInstallment = null,
        int $endInstallment = null,
        bool $newPdf = true,
        db_impcarne $uniquePdf = null,
        string $numpar = '0',
        int $tercDig = 6,
        int $tipoDebito = null
    )
    {

        $this->regraEmissao = new regraEmissao($tipoDebito, $tipoMod, $instit, $date->format('Y-m-d'), $ip, $newPdf, $uniquePdf, $initialInstallment, $endInstallment);
        $this->convenio = new convenio($this->regraEmissao->getConvenio(), $numpre, $numpar, $valor, $vlrbar, $dueDate->format('Ymd'), $tercDig);
    }

    public function execute(): string
    {
        return $this->convenio->getCodigoBarra();
    }
}
