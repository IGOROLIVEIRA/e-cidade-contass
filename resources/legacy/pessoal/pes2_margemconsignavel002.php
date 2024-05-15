<?
include("fpdf151/pdf.php");
include("libs/db_sql.php");

$clrotulo = new rotulocampo;
$clrotulo->label('r14_rubric');
$clrotulo->label('z01_nome');
$clrotulo->label('r01_regist');
$clrotulo->label('r14_quant');
$clrotulo->label('r14_valor');

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
// db_postmemory($HTTP_SERVER_VARS,2);exit;

$ponto = 's';

if($ponto == 's'){
  $arquivo = 'gerfsal';
  $sigla   = 'r14_';
  $head5   = 'PONTO : SALÁRIO';
}elseif($ponto == 'c'){
  $arquivo = 'gerfcom';
  $sigla   = 'r48_';
  $head5   = 'PONTO : COMPLEMENTAR';
}elseif($ponto == 'a'){
  $arquivo = 'gerfadi';
  $sigla   = 'r22_';
  $head5   = 'PONTO : ADIANTAMENTO';
}elseif($ponto == 'r'){
  $arquivo = 'gerfres';
  $sigla   = 'r20_';
  $head5   = 'PONTO : RESCISÃO';
}elseif($ponto == 'd'){
  $arquivo = 'gerfs13';
  $sigla   = 'r35_';
  $head5   = 'PONTO : 13o. SALÁRIO';
}

$wherepes = '';

if(isset($select) && $select != ''){
  $result_sel = db_query("select r44_where , r44_descr from selecao where r44_selec = {$select} and r44_instit = ". db_getsession("DB_instit"));
  if(pg_numrows($result_sel) > 0){
    db_fieldsmemory($result_sel, 0, 1);
    $wherepes .= " and ".$r44_where;
    $head8 = $r44_descr;
    $erroajuda = " ou seleção informada é inválida";
  }
}

// echo "<br><br><br>  selecao --> $select <br><br>";

$where_margem = '';

if($tipo_margem == 's'){
  $where_margem =  ' and (remuneracao - desc_obrigatorios) - comprometido <= 0  ' ;
}elseif($tipo_margem == 'c'){
  $where_margem =  ' and (remuneracao - desc_obrigatorios) - comprometido > 0  ' ;
}

if ( trim ( $aMatriculas ) != "" ) {
    $where_margem .= "  and regist in ({$aMatriculas}) \n";
}

if($ordem ==  'n'){
  $xordem = ' order by regist '; 
}else{
  $xordem = ' order by z01_nome '; 
}
$head2 = "RELATÓRIO DE MARGEM CONSIGNÁVEL";
$head4 = "PERÍODO : ".$mes." / ".$ano;
$head6 = "PERCENTUAL CONSIGNÁVEL : $perc %";


$sql = "
        select * 
        from
        ( 
        select 
               ".$sigla."regist as regist,
       	       z01_nome,z01_cgccpf,
               round(sum(case when ".$sigla."rubric in (select r09_rubric 
	                                      from basesr 
					      where r09_base = '$base1' 
					        and r09_anousu = ".db_anofolha()."
						and r09_mesusu = ".db_mesfolha()."
					      ) then ".$sigla."valor else 0 end),2) as remuneracao,
               round(sum(case when ".$sigla."rubric in (select r09_rubric 
	                                      from basesr 
					      where r09_base = '$base2' 
					        and r09_anousu = ".db_anofolha()."
						and r09_mesusu = ".db_mesfolha()."
					      ) then ".$sigla."valor else 0 end),2) as desc_obrigatorios,
               round(sum(case when ".$sigla."rubric in (select r09_rubric 
	                                      from basesr 
					      where r09_base = '$base3' 
					        and r09_anousu = ".db_anofolha()."
						and r09_mesusu = ".db_mesfolha()."
					      ) then ".$sigla."valor else 0 end),2) as comprometido
      	from ".$arquivo." 
             inner join rhpessoalmov on ".$sigla."regist = rh02_regist 
                                    and rh02_anousu = ".$sigla."anousu 
                     		    and rh02_mesusu = ".$sigla."mesusu
				    and rh02_instit = ".$sigla."instit
            left join rhpesbanco on rh02_seqpes = rh44_seqpes
	     inner join rhpessoal   on  rh01_regist = rh02_regist											
             inner join cgm on z01_numcgm = rh01_numcgm 
       	where ".$sigla."anousu = $ano 
       	  and ".$sigla."mesusu = $mes
          $wherepes
  	  and ".$sigla."instit = ".db_getsession("DB_instit")."
	group by ".$sigla."regist, z01_nome, z01_cgccpf
        $xordem 
        ) as x
        where 1 = 1 $where_margem
       ";
 //echo $sql ; exit;

$result = db_query($sql);
//db_criatabela($result);exit;
$xxnum = pg_numrows($result);
if ($xxnum == 0){
   //db_msgbox('Não existem Cálculo no período de '.$mes.' / '.$ano);
   db_redireciona('db_erros.php?fechar=true&db_erro=Não existem Cálculo no período de '.$mes.' / '.$ano);

}


$pdf = new PDF(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',8);

$troca   = 1;
$alt     = 4;
$xvalor  = 0;
$xquant  = 0;
$total   = 0;
$quebra  = '';
$t_quant = 0;
$t_valor = 0;
$t_func  = 0;
for($x = 0; $x < pg_numrows($result);$x++){
   db_fieldsmemory($result,$x);
   /*  usar se um dia fizermos quebras
   
   if($quebra != $rh25_recurso && $ordem == 'r'){
     $pdf->setfont('arial','b',8);
     if($x != 0){
       $pdf->cell($tot_espaco,$alt,'TOTAL  :  '.$t_func.'  FUNCIONÁRIOS','T',0,"L",0);
       $pdf->cell(15,$alt,db_formatar($t_quant,'f'),'T',0,"R",0);
       $pdf->cell(25,$alt,db_formatar($t_valor,'f'),'T',1,"R",0);
     }
     $quebra = $rh25_recurso;
     $pdf->ln(3);
     $pdf->cell(20,$alt,'RECURSO : ', 0,0,"L",0);
     $pdf->cell(10,$alt,$rh25_recurso,0,0,"R",0);
     $pdf->cell(60,$alt,$o15_descr,   0,1,"L",0);
     $t_quant = 0;
     $t_valor = 0;
     $t_func  = 0;

   }*/
   
   if ($pdf->gety() > $pdf->h - 30 || $troca != 0 ){
        $pdf->addpage();
        $pdf->setfont('arial','b',8);
        $pdf->cell(15,$alt,'MATRIC.',1,0,"C",1);
        $pdf->cell(60,$alt,'NOME',1,0,"C",1);
        $pdf->cell(19,$alt,'CPF',1,0,"C",1);
        $pdf->cell(20,$alt,'REMUNER.',1,0,"C",1);
        $pdf->cell(22,$alt,'DESC.OBRIG.',1,0,"C",1);
        $pdf->cell(20,$alt,'DISPONÍVEL',1,0,"C",1);
        $pdf->cell(19,$alt,'COMPRO.',1,0,"C",1);
        $pdf->cell(18,$alt,'MARGEM',1,1,"C",1);
      $troca = 0;
      $pre = 1;
   }
   if($pre == 1)
     $pre = 0;
   else
     $pre = 1;
   $pdf->setfont('arial','',7);
   $pdf->cell(15,$alt,$regist,0,0,"C",$pre);
   $pdf->cell(60,$alt,$z01_nome,0,0,"L",$pre);
   $pdf->cell(19,$alt,db_formatar($z01_cgccpf,'cpf'),0,0,"C",$pre);
   $pdf->cell(20,$alt,db_formatar($remuneracao,'f'),0,0,"R",$pre);
   $pdf->cell(22,$alt,db_formatar($desc_obrigatorios,'f'),0,0,"R",$pre);
   $disponivel = ($remuneracao - $desc_obrigatorios)/100*$perc;
   $pdf->cell(20,$alt,db_formatar($disponivel,'f'),0,0,"R",$pre);
   $pdf->cell(19,$alt,db_formatar($comprometido,'f'),0,0,"R",$pre);
   $pdf->cell(18,$alt,db_formatar($disponivel - $comprometido,'f'),0,1,"R",$pre);
   $t_valor += $valor;
   $t_quant += $quant;
   $t_func  += 1;
   $xvalor  += $valor;
   $xquant  += $quant;
   $total   += 1;
}
$pdf->setfont('arial','b',8);
$pdf->cell($tot_espaco,$alt,'TOTAL  :  '.$total.'  FUNCIONÁRIOS',"T",0,"C",0);
//$pdf->cell(15,$alt,db_formatar($xquant,'f'),"T",0,"R",0);
//$pdf->cell(25,$alt,db_formatar($xvalor,'f'),"T",1,"R",0);

$pdf->Output();

?>
