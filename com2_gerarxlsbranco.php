<?php
//require_once('OLEwriter.php');
//require_once('BIFFwriter.php');
require_once("Worksheet.php");
require_once("Workbook.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_libsys.php");
require_once("std/db_stdClass.php");
require_once("classes/db_pcorcam_classe.php");

$oGet = db_utils::postMemory($_GET);
$clpcorcam = new cl_pcorcam();

function HeaderingExcel($filename) {
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=$filename" );
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
    header("Pragma: public");
}

// HTTP headers
HeaderingExcel('test.xls');

// Creating a workbook
$workbook = new Workbook("-");

// Creating the first worksheet
$worksheet1 =& $workbook->add_worksheet('Planilha1');

// Format for the headings
$formatot =& $workbook->add_format();
$formatot->set_size(14);
$formatot->set_align('center');
$formatot->set_color('Gray');
$formatot->set_pattern();
$formatot->set_fg_color('gray');
$formatot->set_bold();
$formatot->set_border(1);

//$worksheet1->set_column(0, 8,10,0,'');
$worksheet1->set_row(0, 20);
$worksheet1->merge_cells(0, 0,0,7);
$worksheet1->write_string(0, 0,'Orçamento de Processo de Compra Nº do Processo de Compra',$formatot);
$worksheet1->set_row(1,15);

$formatot =& $workbook->add_format();
$formatot->set_size(12);
$formatot->set_pattern();
$formatot->set_fg_color('white');
$formatot->set_bold();
$formatot->set_border(1);

$worksheet1->set_column(0,0,10);
$worksheet1->set_column(1,1,10);
$worksheet1->set_column(2,2,50);
$worksheet1->set_column(3,3,20);
$worksheet1->set_column(4,4,10);
$worksheet1->set_column(5,5,20);
$worksheet1->set_column(6,6,20);
$worksheet1->set_column(7,7,10);

//orcamento
$worksheet1->merge_cells(1, 0,1,2);
$worksheet1->write_string(1, 0,'Código do Orçamento:',$formatot);
$worksheet1->merge_cells(1, 3,1,7);
$worksheet1->write_string(1, 3,'',$formatot);
$worksheet1->write_string(1, 7,'',$formatot);
$worksheet1->write_string(2, 3,'',$formatot);
$worksheet1->write_string(2, 7,'',$formatot);
$worksheet1->write_string(3, 3,'',$formatot);
$worksheet1->write_string(3, 7,'',$formatot);
$worksheet1->write_string(4, 3,'',$formatot);
$worksheet1->write_string(4, 7,'',$formatot);

$worksheet1->merge_cells(2, 0,2,2);
$worksheet1->write_string(2, 0,'Código do Orçamento do Fornecedor:',$formatot);
$worksheet1->merge_cells(2, 3,2,7);

$worksheet1->merge_cells(3, 0,3,2);
$worksheet1->write_string(3, 0,'CPF / CNPJ:',$formatot);
$worksheet1->merge_cells(3, 3,3,7);

$worksheet1->merge_cells(4, 0,4,2);
$worksheet1->write_string(4, 0,'Nome / Razão Social:',$formatot);
$worksheet1->merge_cells(4, 3,4,7);

$formatotCabecalho =& $workbook->add_format();
$formatotCabecalho->set_size(12);
$formatotCabecalho->set_pattern();
$formatotCabecalho->set_fg_color('silver');
$formatotCabecalho->set_align('center');
$formatotCabecalho->set_border(1);

$worksheet1->write_string(5, 0,'Cód. Item',$formatotCabecalho);
$worksheet1->write_string(5, 1,'Seq. Item',$formatotCabecalho);
$worksheet1->write_string(5, 2,'Serviço / Material',$formatotCabecalho);
$worksheet1->write_string(5, 3,'UN',$formatotCabecalho);
$worksheet1->write_string(5, 4,'Qtde',$formatotCabecalho);
$worksheet1->write_string(5, 5,'Valor Unit.',$formatotCabecalho);
$worksheet1->write_string(5, 6,'Valor Total',$formatotCabecalho);
$worksheet1->write_string(5, 7,'Marca',$formatotCabecalho);

//itens orcamento
$result_itens = $clpcorcam->sql_record($clpcorcam->sql_query_pcorcam_itemsol(null,"pc22_codorc,pc01_codmater,pc11_seq,pc01_descrmater,m61_abrev,pc11_quant",null,"pc20_codorc = $pc22_codorc"));
$numrows_itens = $clpcorcam->numrows;

$formatoitem =& $workbook->add_format();
$formatoitem->set_size(11);
$formatoitem->set_border(1);

for ($i = 0; $i < $numrows_itens; $i ++){
    db_fieldsmemory($result_itens, $i);
    $row = $i + 6;

    //somando 7 pois a linha 6 e o titulo da tabela sendo a linha 1 o primeiro item
    $rowformula = $i + 7;

    //fazendo a formula para multiplicacao
    $quantidade = "E".$rowformula;
    $vlrUnitario= "F".$rowformula;
    $formula = '=('.$quantidade.'*'.$vlrUnitario.')';
    $worksheet1->write_string($row, 0,$pc01_codmater,$formatoitem);
    $worksheet1->write_string($row, 1,$pc11_seq,$formatoitem);
    $worksheet1->write_string($row, 2,$pc01_descrmater,$formatoitem);
    $worksheet1->write_string($row, 3,$m61_abrev,$formatoitem);
    $worksheet1->write_string($row, 4,$pc11_quant,$formatoitem);
    $worksheet1->write_number($row, 5,'',$formatoitem);
    $worksheet1->write_formula($row, 6,$formula,$formatoitem);
    $worksheet1->write_string($row, 7,'',$formatoitem);

}
$workbook->close();
?> 