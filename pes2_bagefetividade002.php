<?
/*
 *     E-cidade Software Público para Gestão Municipal                
 *  Copyright (C) 2014  DBseller Serviços de Informática             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa é software livre; você pode redistribuí-lo e/ou     
 *  modificá-lo sob os termos da Licença Pública Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versão 2 da      
 *  Licença como (a seu critério) qualquer versão mais nova.          
 *                                                                    
 *  Este programa e distribuído na expectativa de ser útil, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implícita de              
 *  COMERCIALIZAÇÃO ou de ADEQUAÇÃO A QUALQUER PROPÓSITO EM           
 *  PARTICULAR. Consulte a Licença Pública Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Você deve ter recebido uma cópia da Licença Pública Geral GNU     
 *  junto com este programa; se não, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Cópia da licença no diretório licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */

include("fpdf151/pdf.php");
include("libs/db_sql.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$head3 = "EFETIVIDADE REFERENTE A ".$mes." / ".$ano;

/**
 * $tipo > l - Lotação
 *         o - Secretaria
 *         c - Cargo
 */
if($tipo == 'c') {

 $sCampos = " rh37_funcao||' - '|| rh37_descr as imprime ";
 $sOrder  = ' rh37_descr,z01_nome';
 if(isset($cai) && trim($cai) != "" && isset($caf) && trim($caf) != ""){
    // Se for por intervalos e vier lotação inicial e final
    $sWhere     .= " and rh37_funcao between '".$cai."' and '".$caf."' ";
  }else if(isset($cai) && trim($cai) != ""){
    // Se for por intervalos e vier somente lotação inicial
    $sWhere    .= " and rh37_funcao >= '".$cai."' ";
  }else if(isset($caf) && trim($caf) != ""){
    // Se for por intervalos e vier somente lotação final
    $sWhere    .= " and rh37_funcao <= '".$caf."' ";
  }else if(isset($fca) && trim($fca) != ""){
    // Se for por selecionados
    $sWhere  .= " and rh37_funcao in ('".str_replace(",","','",$fca)."') ";
  }
}elseif($tipo == 'l'){

 $sCampos = " r70_estrut||' - '||r70_descr as imprime ";
  $sOrder = ' r70_descr,z01_nome';
  if(isset($lti) && trim($lti) != "" && isset($ltf) && trim($ltf) != ""){
    // Se for por intervalos e vier local inicial e final
    $sWhere    .= " and r70_estrut between '".$lti."' and '".$ltf."' ";
  }else if(isset($lti) && trim($lti) != ""){
    // Se for por intervalos e vier somente local inicial
    $sWhere    .= " and r70_estrut >= '".$lti."' ";
  }else if(isset($ltf) && trim($ltf) != ""){
    // Se for por intervalos e vier somente local final
    $sWhere    .= " and r70_estrut <= '".$ltf."' ";
  }else if(isset($flt) && trim($flt) != ""){
    // Se for por selecionados
    $sWhere  .= " and r70_estrut in ('".str_replace(",","','",$flt)."') ";
  }

}else{
  $sCampos = " o40_orgao||' - '||o40_descr as imprime ";
  $sOrder = ' o40_descr,z01_nome';
  if(isset($ori) && trim($ori) != "" && isset($orf) && trim($orf) != ""){
    // Se for por intervalos e vier órgão inicial e final
    $sWhere    .= " and o40_orgao between ".$ori." and ".$orf;
  }else if(isset($ori) && trim($ori) != ""){
    // Se for por intervalos e vier somente órgão inicial
    $sWhere .= " and o40_orgao >= ".$ori;
  }else if(isset($orf) && trim($orf) != ""){
    // Se for por intervalos e vier somente órgão final
    $sWhere    .= " and o40_orgao <= ".$orf;
  }else if(isset($for) && trim($for) != ""){
    // Se for por selecionados
    $sWhere  .= " and o40_orgao in (".$for.") ";
  }
}

$sSql  = "select rh02_regist,                                       ";
$sSql .= "       z01_nome,                                          ";
$sSql .= "       rh37_descr,                                        ";
$sSql .= "       case rh30_regime                                   ";
$sSql .= "            when 1 then 'Estatutário'                     ";
$sSql .= "            when 2 then 'CLT'                             ";
$sSql .= "            else 'Extra-Quadro'                           ";
$sSql .= "       end as rh30_regime,                                ";
$sSql .= "       r70_estrut,                                        ";
$sSql .= "       o40_orgao,                                         ";
$sSql .= "       o40_descr,                                         ";
$sSql .= "       rh05_seqpes,                                       ";
$sSql .= "       {$sCampos}                                         ";
$sSql .= "from rhpessoalmov                                         ";
$sSql .= "     inner join rhpessoal    on rh01_regist = rh02_regist ";
$sSql .= "     inner join cgm          on rh01_numcgm = z01_numcgm  ";
$sSql .= "     inner join rhlota       on r70_codigo  = rh02_lota   ";
$sSql .= "		                        and r70_instit  = rh02_instit ";
$sSql .= "     inner join rhfuncao     on rh37_funcao = rh01_funcao ";
$sSql .= "                            and rh37_instit = rh02_instit ";
$sSql .= "     left  join rhlotaexe    on rh26_codigo = r70_codigo  ";
$sSql .= "                            and rh26_anousu = $ano        ";
$sSql .= "     left join orcorgao      on o40_orgao   = rh26_orgao  ";
$sSql .= "                            and o40_anousu  = $ano        ";
$sSql .= "														and o40_instit  = rh02_instit ";
$sSql .= "     inner join rhregime     on rh30_codreg = rh02_codreg ";
$sSql .= "		                        and rh30_instit = rh02_instit ";
$sSql .= "     left join rhpesrescisao on rh05_seqpes = rh02_seqpes ";
$sSql .= "where rh02_anousu = $ano                                  ";
$sSql .= "  and rh02_mesusu = $mes                                  ";
$sSql .= "  and rh02_instit = ".db_getsession("DB_instit");
$sSql .= "  {$sWhere}                                               ";
$sSql .= "  and rh05_seqpes is null                                 ";
$sSql .= "  and rh30_vinculo = 'A'                                  ";
$sSql .= "ORDER BY {$sOrder}                                        ";

$result = db_query($sSql);
$xxnum  = pg_numrows($result);
// echo $sSql;
// db_criatabela($result);exit(pg_last_error());
if ($xxnum == 0){
   db_redireciona('db_erros.php?fechar=true&db_erro=Não existem funcionários cadastrados no intervalo para o período de '.$mes.' / '.$ano);
}

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',8);
$troca = 1;
$alt = 9;
$pdf->setleftmargin(5);

$funcao_quebra = "";
$count_quebra = 0;

for($x = 0; $x < pg_numrows($result);$x++){
   db_fieldsmemory($result,$x);
   if ($pdf->gety() > $pdf->h - 33 || $troca != 0 ){
      $pdf->addpage('L');
      $pdf->setfont('arial','b',8);
      if($quebrar == 's') {
        $pdf->cell(288,5,$imprime,1,1,"L",1);
        $funcao_quebra = $imprime;
      }
      $alt = 5;
      $pdf->cell(20,$alt,'MATRIC.','LRT',0,"C",1);
      $pdf->cell(60,$alt,'NOME DO FUNCIONÁRIO','LRT',0,"C",1);
      if ($modelo == 'ocorrencias') {
         $pdf->cell(208,$alt,'OCORRÊNCIAS','LRT',1,"C",1);
      } else {
         $pdf->cell(28,$alt,'EFETIVIDADE','LRT',0,"C",1);
         $pdf->cell(18,$alt,'','LRT',0,"C",1);
         $pdf->cell(18,$alt,'','LRT',0,"C",1);
         $pdf->cell(18,$alt,'','LRT',0,"C",1);
         $pdf->cell(18,$alt,'','LRT',0,"C",1);
         $pdf->cell(18,$alt,'','LRT',0,"C",1);
         $pdf->cell(18,$alt,'','LRT',0,"C",1);
         $pdf->cell(18,$alt,'','LRT',0,"C",1);
         $pdf->cell(18,$alt,'','LRT',0,"C",1);
         $pdf->cell(18,$alt,'','LRT',0,"C",1);
         $pdf->cell(18,$alt,'','LRT',1,"C",1);
         $pdf->setfont('arial','b',6);
         $pdf->cell(20,$alt,'','L',0,"C",1);
         $pdf->cell(60,$alt,'','L',0,"C",1);
         $pdf->cell(28,$alt,'','L',0,"C",1);
         $pdf->cell(18,$alt,'Faltas','L',0,"C",1);
         $pdf->cell(18,$alt,'Ajuda de Custo','L',0,"C",1);
         $pdf->cell(18,$alt,'H.Extra 50%','L',0,"C",1);
         $pdf->cell(18,$alt,'H.Extra 100%','L',0,"C",1);
         $pdf->cell(18,$alt,'Dif.H.Ext.50%','L',0,"C",1);
         $pdf->cell(18,$alt,'Dif.H.Ext.100%','L',0,"C",1);
         $pdf->cell(18,$alt,'Adic.Not.Var.','L',0,"C",1);
         $pdf->cell(18,$alt,'Vale Aliment.','L',0,"C",1);
         $pdf->cell(18,$alt,'Sal.Conserv.','L',0,"C",1);
         $pdf->cell(18,$alt,'Reg.Supl.','LR',1,"C",1);
      }
      $troca = 0;
   }

   if($quebrar == 's' && $imprime != $funcao_quebra) {
      
      $pdf->setfont('arial','b',8);
      $pdf->cell(288,$alt,"TOTAL DE SERVIDORES: {$count_quebra}",1,1,"L",1);
      $pdf->addpage('L');
      $pdf->cell(288,$alt,$imprime,1,1,"L",1);
      $funcao_quebra = $imprime;
      $count_quebra = 0;
      $alt = 5;
      $pdf->cell(20,$alt,'MATRIC.','LRT',0,"C",1);
      $pdf->cell(60,$alt,'NOME DO FUNCIONÁRIO','LRT',0,"C",1);
      if ($modelo == 'ocorrencias') {
         $pdf->cell(208,$alt,'OCORRÊNCIAS','LRT',1,"C",1);
      } else {
         $pdf->cell(28,$alt,'EFETIVIDADE','LRT',0,"C",1);
         $pdf->cell(18,$alt,'','LRT',0,"C",1);
         $pdf->cell(18,$alt,'','LRT',0,"C",1);
         $pdf->cell(18,$alt,'','LRT',0,"C",1);
         $pdf->cell(18,$alt,'','LRT',0,"C",1);
         $pdf->cell(18,$alt,'','LRT',0,"C",1);
         $pdf->cell(18,$alt,'','LRT',0,"C",1);
         $pdf->cell(18,$alt,'','LRT',0,"C",1);
         $pdf->cell(18,$alt,'','LRT',0,"C",1);
         $pdf->cell(18,$alt,'','LRT',0,"C",1);
         $pdf->cell(18,$alt,'','LRT',1,"C",1);
         $pdf->setfont('arial','b',6);
         $pdf->cell(20,$alt,'','L',0,"C",1);
         $pdf->cell(60,$alt,'','L',0,"C",1);
         $pdf->cell(28,$alt,'','L',0,"C",1);
         $pdf->cell(18,$alt,'Faltas','L',0,"C",1);
         $pdf->cell(18,$alt,'Ajuda de Custo','L',0,"C",1);
         $pdf->cell(18,$alt,'H.Extra 50%','L',0,"C",1);
         $pdf->cell(18,$alt,'H.Extra 100%','L',0,"C",1);
         $pdf->cell(18,$alt,'Dif.H.Ext.50%','L',0,"C",1);
         $pdf->cell(18,$alt,'Dif.H.Ext.100%','L',0,"C",1);
         $pdf->cell(18,$alt,'Adic.Not.Var.','L',0,"C",1);
         $pdf->cell(18,$alt,'Vale Aliment.','L',0,"C",1);
         $pdf->cell(18,$alt,'Sal.Conserv.','L',0,"C",1);
         $pdf->cell(18,$alt,'Reg.Supl.','LR',1,"C",1);
      }
   }

   $alt = 6;
   $pdf->setfont('arial','',7);
   $pdf->cell(20,$alt,$rh02_regist,'TLR',0,0,"C",0);
   $pdf->cell(60,$alt,$z01_nome,'TLR',0,"L",0);
   if ($modelo == 'ocorrencias') {
      $pdf->cell(208,$alt,'','TLR',1,"L",0);
      $pdf->cell(20,$alt,'','BLR',0,"C",0);
      $pdf->cell(60,$alt,substr($rh37_descr,0,25).'-'.$rh30_regime,'BLR',0,"L",0);
      $pdf->cell(208,$alt,'','TLRB',1,"L",0);
   } else {
      $pdf->cell(28,$alt,'','TLR',0,"L",0);
      $pdf->cell(18,$alt,'','TLR',0,"L",0);
      $pdf->cell(18,$alt,'','TLR',0,"L",0);
      $pdf->cell(18,$alt,'','TLR',0,"L",0);
      $pdf->cell(18,$alt,'','TLR',0,"L",0);
      $pdf->cell(18,$alt,'','TLR',0,"L",0);
      $pdf->cell(18,$alt,'','TLR',0,"L",0);
      $pdf->cell(18,$alt,'','TLR',0,"L",0);
      $pdf->cell(18,$alt,'','TLR',0,"L",0);
      $pdf->cell(18,$alt,'','TLR',0,"L",0);
      $pdf->cell(18,$alt,'','TLR',1,"L",0);

      $alt = 5;
      $pdf->cell(20,$alt,'','BLR',0,"C",0);
      $pdf->cell(60,$alt,substr($rh37_descr,0,25).'-'.$rh30_regime,'BLR',0,"L",0);
      $pdf->cell(28,$alt,'','BLR',0,"L",0);
      $pdf->cell(18,$alt,'','BLR',0,"L",0);
      $pdf->cell(18,$alt,'','BLR',0,"L",0);
      $pdf->cell(18,$alt,'','BLR',0,"L",0);
      $pdf->cell(18,$alt,'','BLR',0,"L",0);
      $pdf->cell(18,$alt,'','BLR',0,"L",0);
      $pdf->cell(18,$alt,'','BLR',0,"L",0);
      $pdf->cell(18,$alt,'','BLR',0,"L",0);
      $pdf->cell(18,$alt,'','BLR',0,"L",0);
      $pdf->cell(18,$alt,'','BLR',0,"L",0);
      $pdf->cell(18,$alt,'','BLR',1,"L",0);
   }
   $count_quebra++;
   $total ++;
}
$pdf->setfont('arial','b',8);
$pdf->cell(190,$alt,'TOTAL DE REGISTROS  : '.$total,"T",0,"C",0);

$pdf->Output();