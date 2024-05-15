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

$tipo_totalizacao = null;
if($lotacao == 'r'){
  $tipo_totalizacao = 'RECURSO';
}else if($lotacao == 's'){
  $tipo_totalizacao = 'LOTACAO';
}else{
  $tipo_totalizacao = 'NENHUM';
}

$head2 = "PAGAMENTO DA FOLHA EM CONTA CORRENTE";
$head4 = "DATA :  ".db_formatar(date('Y-m-d',db_getsession("DB_datausu")),'d');
$head5 = "TOTALIZADO POR: $tipo_totalizacao";
//$lotacao = 's';

if($lotacao == 's'){
 $ordem = "r70_estrut , r38_banco, r38_agenc, r38_nome ";
}else if($lotacao == 'r'){
  $ordem = "codigo, r38_banco, r38_agenc, r38_nome ";
}else{
 $ordem = "r38_banco, r38_agenc, r38_nome asc";
}

$where = '';

if($matricula != 0){
  $where = " where r38_regist in ($matricula)";
}

$sql = "SELECT r38_banco,
  db90_descr,
  r38_agenc,
  r70_estrut,
  r70_descr,
  r38_regist,
  r38_numcgm,
  r38_conta,
  r38_nome,
  r38_liq,
  z01_cgccpf,
  a1.o15_codigo AS codigo
  FROM folha
  INNER JOIN cgm ON r38_numcgm = z01_numcgm
  INNER JOIN rhlota ON to_number(r38_lotac,'9999') = r70_codigo
  AND r70_instit = ".db_getsession("DB_instit")."
  LEFT JOIN
  (SELECT DISTINCT rh25_codigo,
                rh25_projativ,
                rh25_recurso
  FROM rhlotavinc
  WHERE rh25_anousu = 2023 ) AS rhlotavinc ON rh25_codigo = r70_codigo
  LEFT JOIN orctiporec a1 ON a1.o15_codigo = rh25_recurso
  LEFT  JOIN db_bancos ON r38_banco = db90_codban $where
  ORDER BY $ordem
";

$result = pg_exec($sql);
$xxnum = pg_numrows($result);
if($xxnum == 0){
  db_redireciona('db_erros.php?fechar=true&db_erro=Nenhum registro encontrado no periodo de '.$mes.' / '.$ano);
}

if($lotacao == 'r'){
  $pdf = new PDF("L"); 
}else{
  $pdf = new PDF(); 
}

$pdf->Open(); 
$pdf->AliasNbPages(); 
$total = 0;
$pdf->setfont('arial','b',8);
$troca     = 1;
$total     = 0;
$alt       = 6;
$xlota     = 0;
$tot_banco = 0;
$tot_age   = 0;
$tot_lota  = 0;
$tot_func  = 0;
$ref = 0;

$pdf->setfillcolor(235);
$array = array();
$array_ordenado = array();
$array_agencia = array();
$lista = array();

$w = 0;
$t = 0;
$j = 0;
$agencia = null;
$listagem = null;

for($x = 0; $x < pg_numrows($result); $x++){
  db_fieldsmemory($result, $x);
  
  if($codigo != $old){
    $w = 0;
  }
  
  $array[$codigo][$w]['codigo_banco'] = $r38_banco;
  $array[$codigo][$w]['banco'] = $db90_descr;
  $array[$codigo][$w]['conta'] = $r38_conta; 
  $array[$codigo][$w]['agencia'] = $r38_agenc; 
  $array[$codigo][$w]['matricula'] = $r38_regist;
  $array[$codigo][$w]['cgm'] = $r38_numcgm;
  $array[$codigo][$w]['cpf'] = $z01_cgccpf;
  $array[$codigo][$w]['nome'] = $r38_nome;
  $array[$codigo][$w]['liquido'] = $r38_liq;

  if(empty($codigo)){
    $codigo = 'RECISAO';
  }
  
  $array[$codigo][$w]['codigo'] = $codigo;
  
  $w++;
  $old = $codigo;
}

for($x = 0; $x < pg_numrows($result);$x++){
    db_fieldsmemory($result,$x);
      if($lotacao == 's') {
          if ($xlota != $r38_banco . $r38_agenc . $r70_estrut) {
              $troca = 1;
              $xlota = $r38_banco . $r38_agenc . $r70_estrut;
              $pdf->cell(155, $alt, '', 'T', 0, "C", 0);
              $pdf->cell(15, $alt, 'TOTAL DO BANCO', 'T', 0, "R", 0);
              $pdf->cell(20, $alt, db_formatar($tot_age, 'f'), 'T', 1, "R", 0);
              $pdf->cell(155, $alt, '', 0, 0, "C", 0);
              $pdf->cell(15, $alt, 'TOTAL DE FUNC.', 0, 0, "R", 0);
              $pdf->cell(20, $alt, $tot_func, 0, 1, "R", 0);
              $tot_age = 0;
              $tot_func = 0;
          }
      }else{
          if ($xlota != $r38_banco . $r38_agenc && $tot_age > 0) {
              $troca = 1;
              $xlota = $r38_banco . $r38_agenc;
              $pdf->cell(155, $alt, '', 'T', 0, "C", 0);
              $pdf->cell(15, $alt, 'TOTAL', 'T', 0, "R", 0);
              $pdf->cell(20, $alt, db_formatar($tot_age, 'f'), 'T', 1, "R", 0);
              $pdf->cell(155, $alt, '', 0, 0, "C", 0);
              $pdf->cell(15, $alt, 'TOTAL DE FUNC.', 0, 0, "R", 0);
              $pdf->cell(20, $alt, $tot_func, 0, 1, "R", 0);
              $tot_age = 0;
              $tot_func = 0;
          }
      }
    if ($pdf->gety() > $pdf->h - 30 || $troca != 0 ){
        $pdf->addpage();
        $pdf->setfont('arial','b',10);
      if($lotacao == 's'){
          $pdf->cell(15,$alt,$r70_estrut,0,0,"R",0);
          $pdf->cell(75,$alt,$r70_descr,0,1,"L",0);
      }

        if($lotacao != 'r'){
          $pdf->cell(15,$alt,'BANCO',0,0,"R",0);
          $pdf->cell(15,$alt,$r38_banco,0,0,"C",0);
          $pdf->cell(75,$alt,$db90_descr,0,1,"L",0);
          $pdf->cell(15,$alt,'AGENCIA',0,0,"R",0);
          $pdf->cell(15,$alt,$r38_agenc,0,1,"C",0);

          $pdf->cell(20,$alt,'CONTA',1,0,"L",1);
          $pdf->cell(23,$alt,'MATRICULA',1,0,"L",1);
          $pdf->cell(15,$alt,'CGM',1,0,"L",1);
          $pdf->cell(25,$alt,'CPF',1,0,"L",1);
          $pdf->cell(65,$alt,'NOME',1,0,"L",1);
          $pdf->cell(20,$alt,'LIQUIDO',1,0,"R",1);
          $pdf->cell(25,$alt,'RECURSO',1,1,"R",1);
        }

        $troca = 0;
        $pre = 1;
    }
    if($pre == 1){
      $pre = 0;
    }else{
      $pre = 1;
    }
    
    if($lotacao != 'r'){
      $pdf->setfont('arial','',7);
      $pdf->cell(20,$alt,$r38_conta,0,0,"L",$pre);
      $pdf->cell(23,$alt,$r38_regist,0,0,"L",$pre);
      $pdf->cell(15,$alt,$r38_numcgm,0,0,"L",$pre);
      $pdf->cell(25,$alt,db_formatar($z01_cgccpf,'cpf'),0,0,"L",$pre);
      $pdf->cell(65,$alt,$r38_nome,0,0,"L",$pre);
      $pdf->cell(20,$alt,db_formatar($r38_liq,'f'),0,0,"L",$pre);
      $pdf->cell(25,$alt,$codigo,0,1,"L",$pre);
      $tot_banco += $r38_liq;
      $tot_age   += $r38_liq;
      $tot_lota  += $r38_liq;
      $tot_func  += 1;
    }else{
      if(!in_array($codigo, $listagem)){
        //colunas
        $pdf->cell(25,$alt,'CONTA',1,0,"L",1);
        $pdf->cell(20,$alt,'AGENCIA',1,0,"L",1);
        $pdf->cell(40,$alt,'BANCO',1,0,"L",1);
        $pdf->cell(25,$alt,'MATRICULA',1,0,"L",1);
        $pdf->cell(15,$alt,'CGM',1,0,"L",1);
        $pdf->cell(30,$alt,'CPF',1,0,"L",1);
        $pdf->cell(55,$alt,'NOME',1,0,"L",1);
        $pdf->cell(25,$alt,'LIQUIDO',1,0,"R",1);
        $pdf->cell(25,$alt,'RECURSO',1,1,"R",1);

        //linhas
        for($i = 0; $i < sizeof($array[$codigo]); $i++){
          $pre = 0;
          $pdf->setfont('arial','',7);
          $pdf->cell(25,$alt, $array[$codigo][$i]['conta'],0,0,"L",$pre);
          $pdf->cell(20,$alt, $array[$codigo][$i]['agencia'],0,0,"L",$pre);
          $pdf->cell(40,$alt, $array[$codigo][$i]['codigo_banco'] . " - " . $array[$codigo][$i]['banco'],0,0,"L",$pre);
          $pdf->cell(25,$alt,$array[$codigo][$i]['matricula'],0,0,"L",$pre);
          $pdf->cell(15,$alt,$array[$codigo][$i]['cgm'],0,0,"L",$pre);
          $pdf->cell(30,$alt,db_formatar($array[$codigo][$i]['cpf'],'cpf'),0,0,"L",$pre);
          $pdf->cell(55,$alt,$array[$codigo][$i]['nome'],0,0,"L",$pre);
          $pdf->cell(25,$alt,db_formatar($array[$codigo][$i]['liquido'],'f'),0,0,"L",$pre);
          $pdf->cell(25,$alt,$array[$codigo][$i]['codigo'],0,1,"L",$pre);
              
          $tot_banco += $array[$codigo][$i]['liquido'];
          $tot_age   += $array[$codigo][$i]['liquido'];
          $tot_lota  += $array[$codigo][$i]['liquido'];
          $tot_func  += 1;
          $listagem[] = $codigo;
        }
      }
    }
  }

if($tot_age > 0){
  $pdf->cell(155,$alt,'','T',0,"C",0);
  $pdf->cell(15,$alt,'TOTAL DO BANCO ','T',0,"R",0);
  $pdf->cell(20,$alt,db_formatar($tot_age,'f'),'T',1,"R",0);
  $pdf->cell(155,$alt,'',0,0,"C",0);
  $pdf->cell(15,$alt,'TOTAL DE FUNC.',0,0,"R",0);
  $pdf->cell(20,$alt,$tot_func,0,1,"R",0);
}

//$pdf->setfont('arial','b',10);
//$pdf->cell(0,$alt,'TOTAL DE REGISTROS '.$total,"T",1,"R",0);
$pdf->Output();
?>