<?
include("libs/db_sql.php");
include("fpdf151/pdf3.php");
//db_postmemory($HTTP_SERVER_VARS,2);exit;
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
if ( $lista == '' ) {
   db_redireciona('db_erros.php?fechar=true&db_erro=Lista não encontrada!');
   exit; 
}

$head1 = 'Secretaria de Financas';
$pdf = new PDF3(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 

$pdf->SetAutoPageBreak(true,0); 

$pdf->AddPage();
$pdf->SetFont('Arial','',13);

$db02_espaca=1;
$db02_inicia=30;

$pdf->MultiCell(0,4+$db02_espaca,"Atenciosamente.","0","J",0,$db02_inicia+0);
$pdf->MultiCell(0,4+$db02_espaca,"Estou testando para ver se realmente quando um paragrafo tiver mais de uma linha o pdf vai realmente colocar o inicio do paragrafo com tantos centimetros foram solicitados e quando for apenas uma palavra por exemplo vamos ver se vai funcionar, nesse caso agora eu nao faco nem ideia quantas linhas vao ter esse paragrafo.","0","J",0,$db02_inicia+0);
$pdf->MultiCell(0,4+$db02_espaca,"Joao da Silva.","0","J",0,$db02_inicia+0);

$pdf->Output();

