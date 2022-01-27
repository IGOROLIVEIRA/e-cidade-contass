<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_libsys.php");
require_once("std/db_stdClass.php");
require_once("classes/db_rhrubricas_classe.php");
require_once("classes/db_basesr_classe.php");
require_once("classes/db_avaliacaoperguntaopcao_classe.php");

include("libs/PHPExcel/Classes/PHPExcel.php");
$oGet            = db_utils::postMemory($_GET);
$objPHPExcel = new PHPExcel;
$clrhrubricas = new cl_rhrubricas;
$clbasesr = new cl_basesr;
$clavaliacaoperguntaopcao = new cl_avaliacaoperguntaopcao;

/**
 * matriz de entrada
 */
$what = array(
    'ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û',
    'Ä', 'Ã', 'À', 'Á', 'Â', 'Ê', 'Ë', 'È', 'É', 'Ï', 'Ì', 'Í', 'Ö', 'Õ', 'Ò', 'Ó', 'Ô', 'Ü', 'Ù', 'Ú', 'Û',
    'ñ', 'Ñ', 'ç', 'Ç', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', '°', "°", chr(13), chr(10), "'"
);

/**
 * matriz de saida
 */
$by   = array(
    'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u',
    'A', 'A', 'A', 'A', 'A', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U',
    'n', 'N', 'c', 'C', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', " ", " ", " ", " "
);

$instituicao = db_getsession("DB_instit");

//Inicio
$sheet = $objPHPExcel->getActiveSheet();

$styleTitulo = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => 'FF000000'),
        ),
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
        'rotation' => 90,
        'startcolor' => array(
            'argb' => 'FFA0A0A0',
        ),
        'endcolor' => array(
            'argb' => 'FFFFFFFF',
        ),
    ),
    'font' => array(
        'size' => 12,
        'bold' => true,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
);

$styleTable = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
    ),
    'font' => array(
        'size' => 11,
        'bold' => false,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
);

//Iniciando planilha
$sheet->setCellValue('A1', 'Rubrica');
$sheet->setCellValue('B1', 'Natureza da Rubrica');
$sheet->setCellValue('C1', 'Cod. incidencia tributaria previdencia social');
$sheet->setCellValue('D1', 'Cod. incidencia tributaria irrf');
$sheet->setCellValue('E1', 'Cod. incidencia para o fgts');
$sheet->setCellValue('F1', 'Cod. incidencia Regime Próprio RPPS');
$sheet->setCellValue('G1', 'Teto remuneratorio (art. 37, XI, da CF/1988)');
$sheet->setCellValue('H1', 'Base de Calculo IRRF Mensal');
$sheet->setCellValue('I1', 'Base de Calculo IRRF Ferias');
$sheet->setCellValue('J1', 'Base de Calculo IRRF 13º Salario');
$sheet->setCellValue('K1', 'Base de Calculo RGPS Mensal');
$sheet->setCellValue('L1', 'Base de Calculo RGPS Férias');
$sheet->setCellValue('M1', 'Base de Calculo RGPS 13º Salario');
$sheet->setCellValue('N1', 'Base de Calculo RPPS Mensal');
$sheet->setCellValue('O1', 'Base de Calculo RPPS Férias');
$sheet->setCellValue('P1', 'Base de Calculo RPPS 13º Salario');
$sheet->setCellValue('Q1', 'Base de Calculo FGTS');

//cabeçalho
$sheet->getStyle('A1:Q1')->applyFromArray($styleTitulo);
//Rubricas
if ($ativos == 't') {
    $where = "rh27_ativo = '$ativos'";
}
if ($ativos == 'f') {
    $where = "rh27_ativo = '$ativos'";
}
if ($ativos == 'i') {
    $where = "";
}
$campos = "rh27_rubric,rh27_descr,e991_rubricasesocial as rubricasesocial,rh27_codincidprev as codincidprev,
rh27_codincidirrf as codincidirrf,rh27_codincidfgts as codincidfgts,rh27_codincidregime as codincidregime,rh27_tetoremun";
//. "and rh27_rubric='R903'"
$rsRubricas = $clrhrubricas->sql_record($clrhrubricas->sql_query(null, $instituicao, $campos, "rh27_rubric", $where . "and rh27_instit = $instituicao"));

$numrows_rubricas = $clrhrubricas->numrows;

for ($i = 0; $i < $numrows_rubricas; $i++) {
    db_fieldsmemory($rsRubricas, $i);

    /**BUSCO a Natureza da Rubrica*/
    if ($rubricasesocial != "") {
        $resultNatureza = $clrhrubricas->sql_record($clrhrubricas->sql_query(null, $instituicao, "distinct e990_sequencial||'-'||e990_descricao as e990_descricao", null, "e991_rubricasesocial = '{$rubricasesocial}'"));
        db_fieldsmemory($resultNatureza, 0);
    } else {
        $e990_descricao = "";
    }

    /**Cod. incidência tributária previdência social */
    if ($codincidprev != "") {
        $resultIncidTributaria = $clavaliacaoperguntaopcao->sql_record($clavaliacaoperguntaopcao->sql_query_file(null, "db104_valorresposta||' - '||db104_descricao AS descrrh27_codincidprev", null, "db104_sequencial = $codincidprev"));
        db_fieldsmemory($resultIncidTributaria, 0);
    } else {
        $descrrh27_codincidprev = '';
    }
    /**Cod. incidência tributária irrf */
    if ($codincidirrf != "") {
        $resultCodIncRRF = $clavaliacaoperguntaopcao->sql_record($clavaliacaoperguntaopcao->sql_query_file(null, "db104_valorresposta||' - '||db104_descricao AS descrh27_codincidirrf", null, "db104_sequencial = $codincidirrf"));
        db_fieldsmemory($resultCodIncRRF, 0);
    } else {
        $descrh27_codincidirrf = "";
    }

    /**Cod. incidência para o fgts */
    if ($codincidfgts != "") {
        $resultCodIncidFGTS = $clavaliacaoperguntaopcao->sql_record($clavaliacaoperguntaopcao->sql_query_file(null, "db104_descricao AS descrh27_codincidfgts", null, "db104_sequencial = $codincidfgts"));
        db_fieldsmemory($resultCodIncidFGTS, 0);
    } else {
        $descrh27_codincidfgts = "";
    }
    /**Cod. incidência Regime Próprio RPPS/regime militar */
    if ($codincidregime != "") {
        $resultCodincidRegime = $clavaliacaoperguntaopcao->sql_record($clavaliacaoperguntaopcao->sql_query_file(null, "db104_descricao AS descrh27_codincidregime", null, "db104_sequencial = $codincidregime"));
        db_fieldsmemory($resultCodincidRegime, 0);
    } else {
        $descrh27_codincidregime = "";
    }

    /**Base de Calculo IRRF Mensal */
    if ($base02 != "") {
        $rsbase02 = $clbasesr->sql_record($clbasesr->sql_query($ano, $mes, $base02, $rh27_rubric, $instituicao, "*"));
        $numrows_base02 = $clbasesr->numrows;
        if ($numrows_base02 == 0) {
            $respBase02 = "Nao";
        } else {
            $respBase02 = "Sim";
        }
    } else {
        $respBase02 = "Nao";
    }

    /** Base de Calculo IRRF Ferias */
    if ($base03 != "") {
        $rsbase03 = $clbasesr->sql_record($clbasesr->sql_query($ano, $mes, $base03, $rh27_rubric, $instituicao, "*"));
        $numrows_base03 = $clbasesr->numrows;
        if ($numrows_base03 == 0) {
            $respBase03 = "Nao";
        } else {
            $respBase03 = "Sim";
        }
    } else {
        $respBase03 = "Nao";
    }

    /** Base de Cálculo IRRF 13º Salário */
    if ($base04 != "") {
        $rsbase04 = $clbasesr->sql_record($clbasesr->sql_query($ano, $mes, $base04, $rh27_rubric, $instituicao, "*"));
        $numrows_base04 = $clbasesr->numrows;
        if ($numrows_base04 == 0) {
            $respBase04 = "Nao";
        } else {
            $respBase04 = "Sim";
        }
    } else {
        $respBase04 = "Nao";
    }

    /** Base de Cálculo RGPS Mensal */
    if ($base05 != "") {
        $rsbase05 = $clbasesr->sql_record($clbasesr->sql_query($ano, $mes, $base05, $rh27_rubric, $instituicao, "*"));
        $numrows_base05 = $clbasesr->numrows;
        if ($numrows_base05 == 0) {
            $respBase05 = "Nao";
        } else {
            $respBase05 = "Sim";
        }
    } else {
        $respBase05 = "Nao";
    }

    /** Base de Cálculo RGPS Férias */
    if ($base06 != "") {
        $rsbase06 = $clbasesr->sql_record($clbasesr->sql_query($ano, $mes, $base06, $rh27_rubric, $instituicao, "*"));
        $numrows_base06 = $clbasesr->numrows;
        if ($numrows_base06 == 0) {
            $respBase06 = "Nao";
        } else {
            $respBase06 = "Sim";
        }
    } else {
        $respBase06 = "Nao";
    }

    /** Base de Cálculo RGPS 13º Salário */
    if ($base07 != "") {
        $rsbase07 = $clbasesr->sql_record($clbasesr->sql_query($ano, $mes, $base07, $rh27_rubric, $instituicao, "*"));
        $numrows_base07 = $clbasesr->numrows;
        if ($numrows_base07 == 0) {
            $respBase07 = "Nao";
        } else {
            $respBase07 = "Sim";
        }
    } else {
        $respBase07 = "Nao";
    }

    /** Base de Cálculo RPPS Mensal */
    if ($base08 != "") {
        $rsbase08 = $clbasesr->sql_record($clbasesr->sql_query($ano, $mes, $base08, $rh27_rubric, $instituicao, "*"));
        $numrows_base08 = $clbasesr->numrows;
        if ($numrows_base08 == 0) {
            $respBase08 = "Nao";
        } else {
            $respBase08 = "Sim";
        }
    } else {
        $respBase08 = "Nao";
    }

    /** Base de Cálculo RPPS Férias */
    if ($base09 != "") {
        $rsbase09 = $clbasesr->sql_record($clbasesr->sql_query($ano, $mes, $base09, $rh27_rubric, $instituicao, "*"));
        $numrows_base09 = $clbasesr->numrows;
        if ($numrows_base09 == 0) {
            $respBase09 = "Nao";
        } else {
            $respBase09 = "Sim";
        }
    } else {
        $respBase09 = "Nao";
    }

    /**Base de Cálculo RPPS 13º Salário */
    if ($base010 != "") {
        $rsbase010 = $clbasesr->sql_record($clbasesr->sql_query($ano, $mes, $base010, $rh27_rubric, $instituicao, "*"));
        $numrows_base010 = $clbasesr->numrows;
        if ($numrows_base010 == 0) {
            $respBase010 = "Nao";
        } else {
            $respBase010 = "Sim";
        }
    } else {
        $respBase010 = "Nao";
    }

    /** Base de Cálculo FGTS */
    if ($base011 != "") {
        $rsbase011 = $clbasesr->sql_record($clbasesr->sql_query($ano, $mes, $base011, $rh27_rubric, $instituicao, "*"));
        $numrows_base011 = $clbasesr->numrows;
        if ($numrows_base011 == 0) {
            $respbase011 = "Nao";
        } else {
            $respbase011 = "Sim";
        }
    } else {
        $respBase011 = "Nao";
    }

    $numrow = $i + 2;
    $collA = 'A' . $numrow;
    $collB = 'B' . $numrow;
    $collC = 'C' . $numrow;
    $collD = 'D' . $numrow;
    $collE = 'E' . $numrow;
    $collF = 'F' . $numrow;
    $collG = 'G' . $numrow;
    $collH = 'H' . $numrow;
    $collI = 'I' . $numrow;
    $collJ = 'J' . $numrow;
    $collK = 'K' . $numrow;
    $collL = 'L' . $numrow;
    $collM = 'M' . $numrow;
    $collN = 'N' . $numrow;
    $collO = 'O' . $numrow;
    $collP = 'P' . $numrow;
    $collQ = 'Q' . $numrow;

    $rubrica = $rh27_rubric . '-' . $rh27_descr;
    if ($rh27_tetoremun == "t") {
        $rh27_tetoremun = "Sim";
    } else {
        $rh27_tetoremun = "Nao";
    }
    $sheet->setCellValue($collA, $rubrica);
    $sheet->setCellValue($collB, iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $e990_descricao)));
    $sheet->setCellValue($collC, iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $descrrh27_codincidprev)));
    $sheet->setCellValue($collD, iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $descrh27_codincidirrf)));
    $sheet->setCellValue($collE, iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $descrh27_codincidfgts)));
    $sheet->setCellValue($collF, iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $descrh27_codincidregime)));
    $sheet->setCellValue($collG, iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $rh27_tetoremun)));
    $sheet->setCellValue($collH, $respBase02);
    $sheet->setCellValue($collI, $respBase03);
    $sheet->setCellValue($collJ, $respBase04);
    $sheet->setCellValue($collK, $respBase05);
    $sheet->setCellValue($collL, $respBase06);
    $sheet->setCellValue($collM, $respBase07);
    $sheet->setCellValue($collN, $respBase08);
    $sheet->setCellValue($collO, $respBase09);
    $sheet->setCellValue($collP, $respBase010);
    $sheet->setCellValue($collQ, $respBase011);

    $sheet->getStyle($collA . ':' . $collQ)->applyFromArray($styleTable);
}

$nomefile = "plarubicas." . "xlsx";

header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=$nomefile");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
header("Pragma: public");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
