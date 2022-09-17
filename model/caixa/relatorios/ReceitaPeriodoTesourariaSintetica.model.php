<?php
namespace model\caixa\relatorios;

use model\caixa\relatorios\ReceitaPeriodoTesouraria;

require_once 'model/caixa/relatorios/ReceitaPeriodoTesouraria.model.php'; 

class ReceitaPeriodoTesourariaSintetica extends ReceitaPeriodoTesouraria
{
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
}