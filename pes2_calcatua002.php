<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2012  DBselller Servicos de Informatica             
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
include("libs/db_libpessoal.php");
include("classes/db_selecao_classe.php");
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
$clselecao = new cl_selecao();
//db_postmemory($HTTP_SERVER_VARS,2);exit;

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<br><br><br>
<center>
<? 
db_criatermometro('calculo_folha','Concluido...','blue',1,'Efetuando Geracao calc_ativos.txt');
db_criatermometro('calculo_folha1','Concluido...','blue',1,'Efetuando Geracao calc_inativos.txt');
db_criatermometro('calculo_folha2','Concluido...','blue',1,'Efetuando Geracao calc_pens.txt');
?>

</center>
</body>
<?
$where = " ";
if(trim($selecao) != ""){
  $result_selecao = $clselecao->sql_record($clselecao->sql_query_file($selecao," r44_descr, r44_where ",db_getsession("DB_instit")));
  if($clselecao->numrows > 0){
    db_fieldsmemory($result_selecao, 0);
    $where = " and ".$r44_where;
    $head8 = "SELEÇÃO: ".$selecao." - ".$r44_descr;
  }
}

$db_erro = false;

if($banco == 1){
$erro_msg = calcatua_bb($anofolha,$mesfolha,$where);
}else if ($banco == 2){
$erro_msg = calcatua_cef($anofolha,$mesfolha,$where);
}else if ($banco == 3){
    $erro_msg = calcatua_rtm($anofolha,$mesfolha,$where);
}else{
    $erro_msg = calcatua_sprev($anofolha,$mesfolha,$where);
}

if(empty($erro_msg)){
  echo "
  <script>
    parent.js_detectaarquivo('/tmp/calc_ativos.txt','/tmp/calc_inativos.txt','/tmp/calc_pens.txt');
  </script>
  ";
}else{
  echo "
  <script>
    parent.js_erro('$erro_msg');
  </script>
  ";
}
//echo "<BR> antes do fim db_fim_transacao()";
//flush();
db_redireciona("pes2_calcatua001.php");


function calcatua_bb($anofolha,$mesfolha,$where) {
  require_once('model/pessoal/calculoatuarial/bb/CalculoAtuarialBB.model.php');
  $oCalculoAtuarial = new CalculoAtuarialBB();
  $oCalculoAtuarial->processar($anofolha,$mesfolha,$where);
}


function calcatua_cef($anofolha,$mesfolha,$where) {
  require_once('model/pessoal/calculoatuarial/cef/CalculoAtuarialCEF.model.php');
  $oCalculoAtuarial = new CalculoAtuarialCEF();
  $oCalculoAtuarial->processar($anofolha,$mesfolha,$where);
}

function calcatua_rtm($anofolha,$mesfolha,$where) {
  require_once('model/pessoal/calculoatuarial/rtm/CalculoAtuarialRTM.model.php');
  $oCalculoAtuarial = new CalculoAtuarialRTM();
  $oCalculoAtuarial->processar($anofolha,$mesfolha,$where);
}

function calcatua_sprev($anofolha,$mesfolha,$where){
  require_once('model/pessoal/calculoatuarial/sprev/CalculoAtuarialSPREV.model.php');
  $oCalculoAtuarial = new CalculoAtuarialSPREV();
  $oCalculoAtuarial->processar($anofolha,$mesfolha,$where);
}

?>