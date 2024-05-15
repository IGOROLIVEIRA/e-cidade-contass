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

$clrotulo = new rotulocampo;

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$where = '';
  
$xtipo = 'Todas';
if($ativos != 'i'){
  $xtipo = 'Ativas';
  $where = " and rh27_ativo = '$ativos'";
  if($ativos == 'f'){
    $xtipo = 'Inativas';
  }
}

if($base != ''){
  $where .= " and e990_sequencial = '$base' ";
  $head5 = 'BASE : '.$base.'-'.$descr_base;
}

$head3 = "RELATÓRIO DE RUBRICAS MARCADAS NAS BASES";
$head7 = "TIPO : ".$xtipo;

$sql = "
select rh27_rubric,
       rh27_descr,
       e990_sequencial, e990_descricao
    from rhrubricas
   left join baserubricasesocial on rh27_rubric = e991_rubricas and rh27_instit = e991_instit
   left join rubricasesocial on e990_sequencial = e991_rubricasesocial

where rh27_instit = ".db_getsession("DB_instit")."		 
      $where
order by e990_sequencial, e990_descricao
       ";
// echo $sql ; exit;

$result = pg_exec($sql);
$xxnum = pg_numrows($result);
if ($xxnum == 0){
   db_redireciona('db_erros.php?fechar=true&db_erro=Não existem Códigos cadastrados');

}

$pdf = new PDF(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',8);
$troca = 1;
$alt = 4;
$base_diferente = '';
for($x = 0; $x < pg_numrows($result);$x++){
   db_fieldsmemory($result,$x);
   if ($pdf->gety() > $pdf->h - 30 || $troca != 0 ){
      $pdf->addpage();
      $pdf->setfont('arial','b',10);
      $pdf->cell(20,$alt,'BASE',1,0,"C",1);
      $pdf->cell(60,$alt,'DESCRIÇÃO DA BASE',"TBL",0,"C",1);
      $pdf->cell(30,$alt,'',"RTB",1,"C",1);
      $pdf->setfont('arial','',7);
      $pdf->cell(30,$alt,'',"LTB",0,"C",1);
      $pdf->cell(20,$alt,'RUBRICA',"TBR",0,"C",1);
      $pdf->cell(60,$alt,'DESCRIÇÃO DA RUBRICA',1,1,"C",1);
      $troca = 0;
      $pre = 1;
   }
   if($base_diferente != $e990_sequencial){
     $pre = 0;
     $pdf->cell(30,$alt,'',0,1,"C",0);
     $pdf->setfont('arial','b',10);
     $pdf->cell(20,$alt,$e990_sequencial,0,0,"C",$pre);
     $pdf->cell(60,$alt,(empty($e990_descricao) ? 'Sem Base' : substr($e990_descricao, 0, 51)),0,0,"L",$pre);
     $pdf->cell(30,$alt,'',0,1,"C",$pre);
     $base_diferente = $e990_sequencial;
   }
   if($pre == 1){
     $pre = 0;
   }else{
     $pre = 1;
   }
   $pdf->setfont('arial','',7);
   $pdf->cell(30,$alt,'',0,0,"C",$pre);
   $pdf->cell(20,$alt,$rh27_rubric,0,0,"C",$pre);
   $pdf->cell(60,$alt,$rh27_descr,0,1,"L",$pre);
   $total += 1;
}
$pdf->setfont('arial','b',8);
$pdf->cell(0,$alt,'TOTAL DE REGISTROS :  '.$total,"T",0,"C",0);

$pdf->Output();
     
?>
