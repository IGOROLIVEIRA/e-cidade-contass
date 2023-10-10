<?php

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
include("classes/db_db_usuarios_classe.php");

require_once("libs/PHPExcel/Classes/PHPExcel.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$clpcmater = new cl_pcmater;
$cldb_usuarios = new cl_db_usuarios;
$objPHPExcel = new PHPExcel;

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
            'argb' => '00f703',
        ),
        'endcolor' => array(
            'argb' => 'FFFFFFFF',
        ),
    ),
    'font' => array(
        'size' => 10,
        'bold' => true,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
);

$styleItens = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => 'FF000000'),
        ),
    ),
    'font' => array(
        'size' => 10,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    ),
);

//Inicio
$sheet = $objPHPExcel->getActiveSheet();
$sheet->getStyle('A1:H1')->applyFromArray($styleTitulo);

if($grupo == "geral"){

    //itens
    $sheet->setCellValue('A1', 'Material');
    $sheet->setCellValue('B1', mb_convert_encoding('Descrição do Material','UTF-8'));
    $sheet->setCellValue('C1', 'Complemento');
    $sheet->setCellValue('D1', 'Subgrupo');
    $sheet->setCellValue('E1', mb_convert_encoding('Descrição do Subgrupo','UTF-8'));
    $sheet->setCellValue('F1', 'Elemento');
    $sheet->setCellValue('G1', mb_convert_encoding('Descrição','UTF-8'));
    $sheet->setCellValue('H1', 'Cod Usuario');

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(17);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(50);

}

if($grupo == "sub_grupo"){
    //itens
    $sheet->setCellValue('A1', 'Material');
    $sheet->setCellValue('B1', mb_convert_encoding('Descrição do Material','UTF-8'));
    $sheet->setCellValue('C1', 'Elemento');
    $sheet->setCellValue('D1', mb_convert_encoding('Descrição','UTF-8'));

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(70);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
}

function montagemOrderBy($grupo,$ordem)
{
  $orderBy = "";
  if($grupo == "geral"){
    $orderBy = $ordem == "a" ? "pc01_descrmater,pc01_codmater" : "pc01_codmater";
    return $orderBy;	
  }
  
  if($grupo == "sub_grupo"){
    $orderBy = $ordem == "a" ? "pc04_descrsubgrupo,pc01_descrmater" : "pc04_codsubgrupo,pc01_codmater";
    return $orderBy;	
  }
  
  if($grupo == "elemento"){
    $orderBy = $ordem == "a" ? "o56_descr,pc01_descrmater" : "o56_codele,pc01_codmater";
    return $orderBy;	
  }
}

function montagemWhere($elemento)
{
    $where = "pc01_ativo='f' and pc01_conversao is false and o56_anousu = ".db_getsession("DB_anousu");
    $where.= $elemento != "" ? " and o56_elemento = '$elemento'" : "";
    return $where;
}

$orderBy = montagemOrderBy($grupo,$ordem);
$where = montagemWhere($elemento);

$rsPcmater = $clpcmater->sql_record($clpcmater->sql_query_grupo("","*",$orderBy,$where));
$subgrupoAtual = "";
$total = 0;
$sheet->getStyle('A2:H1000')->applyFromArray($styleItens);

for ($i = 0; $i < $clpcmater->numrows; $i++) {

    if($grupo == "geral"){

        $numrow = $i + 2;
        $item = db_utils::fieldsMemory($rsPcmater,$i);
        $sheet->setCellValue('A'.$numrow, $item->pc01_codmater);
        $sheet->setCellValue('B'.$numrow, mb_convert_encoding($item->pc01_descrmater,'UTF-8') );
        $sheet->setCellValue('C'.$numrow, mb_convert_encoding($item->pc01_complmater,'UTF-8'));
        $sheet->setCellValue('D'.$numrow, $item->pc04_codsubgrupo);
        $sheet->setCellValue('E'.$numrow, mb_convert_encoding($item->pc04_descrsubgrupo,'UTF-8'));
        $sheet->setCellValue('F'.$numrow, $item->o56_elemento);
        $sheet->setCellValue('G'.$numrow, mb_convert_encoding($item->o56_descr,'UTF-8'));
        $rsUsuario = $cldb_usuarios->sql_record($cldb_usuarios->sql_query_file($item->pc01_id_usuario,"nome"));
        $usuario = db_utils::fieldsMemory($rsUsuario,0);
        $sheet->setCellValue('H'.$numrow, $usuario->nome,'UTF-8');
    }

    if($grupo == "sub_grupo"){
        $numrow = $i + 2;
        $item = db_utils::fieldsMemory($rsPcmater,$i);
        if($item->pc04_codsubgrupo != $subgrupoAtual){
            $objPHPExcel->getActiveSheet()->getStyle('B'.$numrow)->getFont()->setBold(true);
            $txt = "$item->pc03_descrgrupo =>  $item->pc04_descrsubgrupo";
            $sheet->setCellValue('B'.$numrow, mb_convert_encoding($txt,'UTF-8'));
            $subgrupoAtual = $item->pc04_codsubgrupo;
            $numrow++;
        } 
        $sheet->setCellValue('A'.$numrow, $item->pc01_codmater);
        $sheet->setCellValue('B'.$numrow, mb_convert_encoding($item->pc01_descrmater,'UTF-8') );
        $sheet->setCellValue('C'.$numrow, $item->o56_elemento,'UTF-8');
        $sheet->setCellValue('D'.$numrow, mb_convert_encoding($item->o56_descr,'UTF-8'));
        $total++;
    }


}

$nomefile = "Itens" . db_getsession('DB_instit') . ".xlsx";
header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=$nomefile");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
header("Pragma: public");
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

?>