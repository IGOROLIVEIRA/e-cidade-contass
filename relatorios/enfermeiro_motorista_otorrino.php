<?
include("fpdf151/pdf.php");
include("classes/db_rhvisavalecad_classe.php");
include("libs/db_sql.php");

$clrhvisavalecad = new cl_rhvisavalecad;
$clrotulo = new rotulocampo;
$clrhvisavalecad->rotulo->label();
$clrotulo->label("z01_nome");

$clgera_sql_folha = new cl_gera_sql_folha;
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
//db_postmemory($HTTP_SERVER_VARS,2);exit;

$ano = 2006;
$mes = 4;


$head2 = "PERÍODO : ".$mes." / ".$ano;
$head3 = "LOTACOES ENTRE 1400 E 1499";
$head4 = "FUNCOES: 156 - MOTORISTA";
$head5 = "                    204 - ENFERMEIRO";
$head6 = "                    220 - OTORRINO";
$head7 = "REGIME: 1 - ESTATUTÁRIO";


$clgera_sql_folha->usar_atv = true;
$clgera_sql_folha->usar_fun = true;
$clgera_sql_folha->usar_lot = true;
$clgera_sql_folha->usar_cgm = true;
$sql = $clgera_sql_folha->gerador_sql("",$ano,$mes,null,null,"rh01_regist,z01_nome,r70_estrut,r70_descr,rh37_funcao,rh37_descr","z01_nome","rh30_regime = 1 and r70_codigo between 1400 and 1499 and rh37_funcao in (204,156,220)");
$result = pg_exec($sql);
$xxnum = pg_numrows($result);
if($xxnum == 0){
  db_redireciona('db_erros.php?fechar=true&db_erro=Não nenhum registro encontrado no período de '.$mes.' / '.$ano);
}

$pdf = new PDF(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',8);
$troca = 1;
$total = 0;
$alt = 4;
for($x = 0; $x < pg_numrows($result);$x++){
   db_fieldsmemory($result,$x);
   if ($pdf->gety() > $pdf->h - 30 || $troca != 0 ){
      $pdf->addpage("L");
      $pdf->setfont('arial','b',8);
      $pdf->cell(15,$alt,'MATRIC',1,0,"C",1);
      $pdf->cell(75,$alt,'NOME',1,0,"C",1);
      $pdf->cell(15,$alt,'LOTACAO',1,0,"C",1);
      $pdf->cell(75,$alt,'DESCRICAO',1,0,"C",1);
      $pdf->cell(15,$alt,'FUNCAO',1,0,"C",1);
      $pdf->cell(75,$alt,'DESCRICAO',1,1,"C",1);
      $troca = 0;
   }
   $pdf->setfont('arial','',7);
   $pdf->cell(15,$alt,$rh01_regist,0,0,"C",0);
   $pdf->cell(75,$alt,$z01_nome,0,0,"L",0);
   $pdf->cell(15,$alt,$r70_estrut,0,0,"C",0);
   $pdf->cell(75,$alt,$r70_descr,0,0,"L",0);
   $pdf->cell(15,$alt,$rh37_funcao,0,0,"C",0);
   $pdf->cell(75,$alt,$rh37_descr,0,1,"L",0);
   $total++;
}
$pdf->setfont('arial','b',8);
$pdf->cell(0,$alt,'TOTAL DE REGISTROS '.$total,"T",0,"R",0);
$pdf->Output();
?>
