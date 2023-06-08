<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_dadoscomplementareslrf_classe.php");
include("dbforms/db_classesgenericas.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$aux         			  = new cl_arquivo_auxiliar;
$cldadoscomplementareslrf = new cl_dadoscomplementareslrf;

$db_botao = true;

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<?php
      db_app::load("scripts.js, strings.js, prototype.js, estilos.css");
    ?>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<center>
<fieldset   style="margin-left:40px; margin-top: 20px;">
<legend><b>Dados Complementares LRF</b></legend>
  <?
  include("forms/db_frmdadoscomplementareslrf.php");
  ?>
</fieldset>
</center>

</body>
</html>
<script>
//js_tabulacaoforms("form1","si170_vlsaldoatualconcgarantia",true,1,"si170_vlsaldoatualconcgarantia",true);
</script>
<?
if(isset($incluir)){
  if($cldadoscomplementareslrf->erro_status=="0"){
    $cldadoscomplementareslrf->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($cldadoscomplementareslrf->erro_campo!=""){
      echo "<script> document.form1.".$cldadoscomplementareslrf->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cldadoscomplementareslrf->erro_campo.".focus();</script>";
    }
  }else{
    $cldadoscomplementareslrf->erro(true,true);
  }
}
?>
