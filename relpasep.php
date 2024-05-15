<?
include("fpdf151/pdf.php");
include("libs/db_sql.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
//db_postmemory($HTTP_SERVER_VARS,2);exit;

$ano = 2006;
$mes = 7;
$local = 104;

$head2 = "PERÍODO : ".$mes." / ".$ano;
$head3 = "FUNCIONÁRIOS QUE NÃO RECEBERA PASEP NA FOLHA";
//$head5 = "POR ORGAO E POR RECURSO";


$sql = "
select rh01_regist, z01_nome, z01_cgccpf,rh16_pis,r47_valor
from pontocom
     left join gerfcom on r47_anousu = r48_anousu and r47_mesusu = r48_mesusu and r47_regist= r48_regist and r47_rubric = r48_rubric
     inner join rhpessoal on rh01_regist = r47_regist
     inner join cgm on rh01_numcgm = z01_numcgm
     left join rhpesdoc on  rh01_regist = rh16_regist
where r47_anousu = 2006 and  r47_mesusu = 7 and r47_rubric = '0665' and r48_regist is null and r47_valor > 0
order by z01_nome
		    
";

$result   = pg_exec($sql);

$num = pg_numrows($result);

if($num == 0){
  db_redireciona('db_erros.php?fechar=true&db_erro=Não nenhum registro encontrado no período de '.$mes.' / '.$ano);
}

$pdf = new PDF(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
$total = 0;
$pdf->setfont('arial','b',8);

////// pasep por orgao

$troca = 1;
$tot_prov = 0;
$tot_desc = 0;
$total = 0;
$alt = 4;
$xsec = 0;
$pdf->setfillcolor(235);
for($x = 0; $x < $num;$x++){
   db_fieldsmemory($result,$x);
   if ($pdf->gety() > $pdf->h - 30 || $troca != 0 ){
      $pdf->addpage();
      $pdf->setfont('arial','b',8);
      $pdf->cell(15,$alt,'MATRIC',1,0,"C",1);
      $pdf->cell(80,$alt,'NOME DO FUNCIONÁRIO',1,0,"C",1);
      $pdf->cell(25,$alt,'CPF',1,0,"C",1);
      $pdf->cell(25,$alt,'PIS/PASEP',1,0,"C",1);
      $pdf->cell(25,$alt,'VALOR',1,1,"C",1);
      $troca = 0;
      $pre = 1;
   }
   if($pre == 1){
     $pre = 0;
   }else{
     $pre = 1;
   } 
   $pdf->setfont('arial','',7);
   $pdf->cell(15,$alt,$rh01_regist,0,0,"C",$pre);
   $pdf->cell(80,$alt,$z01_nome,0,0,"L",$pre);
   $pdf->cell(25,$alt,db_formatar($z01_cgccpf,'cpf'),0,0,"L",$pre);
   $pdf->cell(25,$alt,$rh16_pis,0,0,"L",$pre);
   $pdf->cell(25,$alt,db_formatar($r47_valor,'f'),0,1,"R",$pre);
   $total += 1;
   $tot_prov += $r47_valor;
}
$pdf->setfont('arial','b',8);
$pdf->cell(145,$alt,'TOTAL DE FUNCIONÁRIOS  : '.$total,"T",0,"L",0);
$pdf->cell(25,$alt,db_formatar($tot_prov,'f'),"T",1,"R",0);



$pdf->Output();
?>
