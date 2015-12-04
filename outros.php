<?
include("fpdf151/pdf.php");
include("libs/db_sql.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
//db_postmemory($HTTP_SERVER_VARS,2);exit;

$ano = 2006;
$mes = 6;


$head2 = "PERIODO : ".$mes." / ".$ano;
$head3 = "RELACAO DE CARGOS EM COMISSAO/FG";


$sql = "

select * from 
(
select rh01_regist,rh01_admiss,z01_nome,rh37_descr, rh27_descr as rh04_descr, r70_descr, 
       case when rh30_regime = 3 or r14_rubric between '0113' and '0119' 
			      then 'CARCOS EM COMISSAO'
			      else case when r14_rubric between '0223' and '0230' 
							        then 'FUNCAO GRATIFICADA'
								 else 'NADA'
								 end
					  end as tipo,
						r14_rubric
from rhpessoal
     inner join cgm           on rhpessoal.rh01_numcgm = cgm.z01_numcgm
     inner join rhpessoalmov  on rhpessoal.rh01_regist = rhpessoalmov.rh02_regist
		                         and rh02_anousu = $ano
														 and rh02_mesusu = $mes
														 and rh02_instit = ".db_getsession('DB_instit')."
     left  join rhpesrescisao on rhpessoalmov.rh02_seqpes = rhpesrescisao.rh05_seqpes
     left  join rhpesbanco    on rhpessoalmov.rh02_seqpes = rhpesbanco.rh44_seqpes
     inner join rhlota        on rhlota.r70_codigo        = rhpessoalmov.rh02_lota
		                         and r70_instit               = rh02_instit
     inner join rhregime      on rhpessoalmov.rh02_codreg = rhregime.rh30_codreg
		                         and rh30_instit = rh02_instit
     inner join rhfuncao      on rhpessoal.rh01_funcao = rhfuncao.rh37_funcao
		                         and rh37_instit = rh02_instit
     left  join rhpespadrao   on rhpessoalmov.rh02_seqpes = rhpespadrao.rh03_seqpes 
     left  join padroes       on rhpespadrao.rh03_anousu = padroes.r02_anousu
                             and rhpespadrao.rh03_mesusu = padroes.r02_mesusu
														 and r02_instit = rh02_instit
			                       and rhpespadrao.rh03_regime = padroes.r02_regime
			                       and rhpespadrao.rh03_padrao = padroes.r02_codigo
		 left join rhpescargo     on rh20_seqpes = rh02_seqpes
		 left join rhcargo        on rh20_cargo  = rh04_codigo
		                         and rh04_instit = rh02_instit
		 left join gerfsal        on r14_anousu  = rh02_anousu
		                         and r14_mesusu  = rh02_mesusu
														 and r14_regist  = rh02_regist
														 and r14_instit  = rh02_instit
	                           and (    r14_rubric between '0113' and '0119'
	                                 or r14_rubric between '0223' and '0230')
		 left join rhrubricas     on rh27_rubric = r14_rubric
		                         and rh27_instit = rh02_instit


where rh02_anousu = $ano
  and rh02_mesusu = $mes
  and rh05_recis is null
order by r70_estrut,rh01_regist
) as x
where tipo <> 'NADA'
order by tipo,z01_nome
"; 

//echo $sql;exit;
$result = pg_exec($sql);
$xxnum = pg_numrows($result);
if($xxnum == 0){
  db_redireciona('db_erros.php?fechar=true&db_erro=Não nenhum registro encontrado no período de '.$mes.' / '.$ano);
}

$pdf = new PDF(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
$total = 0;
$pdf->setfont('arial','b',8);
$troca = 1;
$total = 0;
$alt = 4;
$xsec = '';
$pdf->setfillcolor(235);
for($x = 0; $x < pg_numrows($result);$x++){
   db_fieldsmemory($result,$x);
   if($xsec != $tipo){
	 //echo "<br> xsec --> $xsec   tipo --> $tipo ";
 //    $pdf->addpage("L");
 //    $pdf->setfont('arial','b',8);
 //    $pdf->cell(15,$alt,$tipo,0,1,"L",0);
     $troca = 1;
     $xsec = $tipo;
		 if($x != 0 ){
       $pdf->setfont('arial','b',8);
       $pdf->cell(0,$alt,'TOTAL DE FUNCIONARIOS  :  '.$total,"T",1,"L",0);
       $total = 0;
		 }
   }
   if ($pdf->gety() > $pdf->h - 30 || $troca != 0 ){
      $pdf->addpage("L");
      $pdf->setfont('arial','b',8);
      $pdf->cell(15,$alt,'MATRIC',1,0,"C",1);
      $pdf->cell(70,$alt,'NOME',1,0,"C",1);
      $pdf->cell(15,$alt,'ADMISSAO',1,0,"C",1);
      $pdf->cell(60,$alt,'CARGO',1,0,"C",1);
      $pdf->cell(60,$alt,'FUNCAO',1,0,"C",1);
      $pdf->cell(60,$alt,'LOTACAO',1,1,"C",1);
			$pdf->ln(3);
      $pdf->cell(15,$alt,$tipo,0,1,"L",0);
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
   $pdf->cell(70,$alt,$z01_nome,0,0,"L",$pre);
   $pdf->cell(15,$alt,db_formatar($rh01_admiss,'d'),0,0,"L",$pre);
   $pdf->cell(60,$alt,$rh37_descr,0,0,"L",$pre);
   $pdf->cell(60,$alt,$rh04_descr,0,0,"L",$pre);
   $pdf->cell(60,$alt,$r70_descr,0,1,"L",$pre);
   $total++;
}
$pdf->setfont('arial','b',8);
$pdf->cell(0,$alt,'TOTAL DE FUNCIONARIOS  :  '.$total,"T",0,"L",0);
$pdf->Output();
?>
