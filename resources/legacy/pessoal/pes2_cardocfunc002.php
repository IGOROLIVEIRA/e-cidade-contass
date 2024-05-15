<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */

include("fpdf151/pdf.php");
include("libs/db_sql.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
//db_postmemory($HTTP_SERVER_VARS,2);exit;

$head1 = "RELATÓRIO DE CADASTRO";
$head3 = "PERÍODO : ".$mes." / ".$ano;

$xwhere = '';
if($demit == 'n'){
  $xwhere = " and rh05_recis is null";
}

if($regime != 0){
  $res_reg = pg_query('select * from rhregime where rh30_instit = '.db_getsession("DB_instit").' and rh30_codreg = '.$regime) ;
  db_fieldsmemory($res_reg,0);
  $head7 = 'REGIME : '.$rh30_descr.'('.$rh30_regime.', '.$rh30_vinculo.')' ;
  $xwhere .= ' and rh30_codreg = '.$regime;
}

if($ordem == 'n'){
  $head5 = 'ORDEM : NUMERICA';
  $xordem = ' rh01_regist';
}else{
  $head5 = 'ORDEM : ALFABETICA';
  $xordem = ' z01_nome';
}

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
if (isset($sOrder)) {
  # code...
}
$sql = "
select rh01_regist,
       z01_nome,
       rh30_regime,
       z01_ident,
       z01_cgccpf,
       rh16_pis,
       rh01_admiss,
       rh01_progres,
       rh37_funcao,
       rh37_descr,
       rh37_cbo,
       {$sCampos}
from rhpessoal
     inner join cgm on rh01_numcgm = z01_numcgm
     inner join rhpessoalmov on rh02_anousu = $ano
                            and rh02_mesusu = $mes
                            and rh02_regist = rh01_regist
	                    and rh02_instit = ".db_getsession("DB_instit")." 
     inner join rhregime on rh02_codreg = rh30_codreg
		        and rh02_instit = rh30_instit 
     inner join rhfuncao on rh01_funcao = rh37_funcao
		        and rh02_instit = rh37_instit 
     inner join rhpesdoc on rh16_regist = rh01_regist
     left  join rhpesrescisao on rh02_seqpes = rh05_seqpes
     left  join rhlota on rhlota.r70_codigo = rhpessoalmov.rh02_lota 
       and rhlota.r70_instit = rhpessoalmov.rh02_instit
     left  join rhlotaexe on rh26_codigo = r70_codigo                  
       and rh26_anousu = rh02_anousu                 
     left  join orcorgao on o40_orgao = rh26_orgao                  
       and o40_anousu = rhpessoalmov.rh02_anousu    
       and o40_instit = rhpessoalmov.rh02_instit    
where 1 = 1 
$xwhere 
{$sWhere}
ORDER BY {$sOrder},$xordem
       ";
//echo $sql ; exit;

//db_criatabela($result);exit;
//$xxnum = pg_numrows($result);




$result = pg_exec($sql);
$xxnum = pg_numrows($result);
if ($xxnum == 0){
   db_redireciona('db_erros.php?fechar=true&db_erro=Não existem funcionarios no periodo: '.$mes.' / '.$ano);

}

$pdf = new PDF(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
$func   = 0;
$func_c = 0;
$tot_c  = 0;
$total  = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',8);
$troca = 1;
$alt = 4;
$funcao_quebra = "";
$count_quebra = 0;

for($x = 0; $x < pg_numrows($result);$x++){
   db_fieldsmemory($result,$x);
   if ($pdf->gety() > $pdf->h - 30 || $troca != 0 ){
     if($cargo == 's'){
      $pdf->addpage('L');
     }else{
      $pdf->addpage('');
     }
      $pdf->setfont('arial','b',8);
      if($quebrar == 's') {
        $pdf->cell(190,$alt,$imprime,1,1,"L",1);
        $funcao_quebra = $imprime;
      }
      $pdf->cell(15,$alt,'MATRÍC.',1,0,"C",1);
      $pdf->cell(60,$alt,'NOME',1,0,"C",1);
      $pdf->cell(10,$alt,'REG.',1,0,"C",1);
      $pdf->cell(20,$alt,'IDENTIDADE',1,0,"C",1);
      $pdf->cell(25,$alt,'CPF',1,0,"C",1);
      $pdf->cell(20,$alt,'PIS',1,0,"C",1);
      $pdf->cell(20,$alt,'ADMISSAO',1,0,"C",1);
     if($cargo == 's'){
      $pdf->cell(20,$alt,'NOMEACAO',1,0,"C",1);
      $pdf->cell(60,$alt,'CARGO',1,0,"C",1);
      $pdf->cell(20,$alt,'CBO',1,1,"C",1);
     }else{
      $pdf->setfont('arial','b',8);
      $pdf->cell(20,$alt,'NOMEACAO',1,1,"C",1);
     }
      $troca = 0;
      $pre = 1;
   }
   if($pre == 1)
      $pre = 0;
   else
      $pre = 1;

    if($quebrar == 's' && $imprime != $funcao_quebra) {
      
      $pdf->setfont('arial','b',8);
      $pdf->cell(190,$alt,"TOTAL DE SERVIDORES: {$count_quebra}",1,1,"L",1);
      if($cargo == 's'){
        $pdf->addpage('L');
      }else{
        $pdf->addpage('');
      }
      $pdf->cell(190,$alt,$imprime,1,1,"L",1);
      $funcao_quebra = $imprime;
      $count_quebra = 0;

      $pdf->setfont('arial','b',8);
      $pdf->cell(15,$alt,'MATRÍC.',1,0,"C",1);
      $pdf->cell(60,$alt,'NOME',1,0,"C",1);
      $pdf->cell(10,$alt,'REG.',1,0,"C",1);
      $pdf->cell(20,$alt,'IDENTIDADE',1,0,"C",1);
      $pdf->cell(25,$alt,'CPF',1,0,"C",1);
      $pdf->cell(20,$alt,'PIS',1,0,"C",1);
      $pdf->cell(20,$alt,'ADMISSAO',1,0,"C",1);
      if($cargo == 's'){
        $pdf->cell(20,$alt,'NOMEACAO',1,0,"C",1);
        $pdf->cell(60,$alt,'CARGO',1,0,"C",1);
        $pdf->cell(20,$alt,'CBO',1,1,"C",1);
      }else{
        $pdf->setfont('arial','b',8);
        $pdf->cell(20,$alt,'NOMEACAO',1,1,"C",1);
      }
    }
   $pdf->setfont('arial','',7);
   $pdf->cell(15,$alt,$rh01_regist,0,0,"C",$pre);
   $pdf->cell(60,$alt,$z01_nome,0,0,"L",$pre);
   $pdf->cell(10,$alt,$rh30_regime,0,0,"L",$pre);
   $pdf->cell(20,$alt,$z01_ident,0,0,"L",$pre);
   $pdf->cell(25,$alt,$z01_cgccpf,0,0,"L",$pre);
   $pdf->cell(20,$alt,$rh16_pis,0,0,"L",$pre);
   $pdf->cell(20,$alt,db_formatar($rh01_admiss,'d'),0,0,"L",$pre);
   if($cargo == 's'){
      $pdf->cell(20,$alt,db_formatar($rh01_progres,'d'),0,0,"L",$pre);
      $pdf->cell(60,$alt,$rh37_descr,0,0,"L",$pre);
      $pdf->cell(20,$alt,$rh37_cbo,0,1,"L",$pre);
   }else{
      $pdf->cell(20,$alt,db_formatar($rh01_progres,'d'),0,1,"L",$pre);
   }
   $func   += 1;
   $count_quebra++;
}

$pdf->ln(3);
$pdf->cell(115,$alt,'Total da Geral  :  '.$func.'  FUNCIONARIOS',0,0,"L",0);

$pdf->Output();
   
?>