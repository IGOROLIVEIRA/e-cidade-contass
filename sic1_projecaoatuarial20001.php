<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_projecaoatuarial20_classe.php");
include("classes/db_projecaoatuarial10_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clprojecaoatuarial20 = new cl_projecaoatuarial20;
$clprojecaoatuarial10 = new cl_projecaoatuarial10;
$db_opcao = 22;
$db_botao = false;
if(isset($alterar) || isset($excluir) || isset($incluir)){
  $sqlerro = false;
  /*
$clprojecaoatuarial20->si169_sequencial = $si169_sequencial;
$clprojecaoatuarial20->si169_exercicio = $si169_exercicio;
$clprojecaoatuarial20->si169_vlreceitaprevidenciaria = $si169_vlreceitaprevidenciaria;
$clprojecaoatuarial20->si169_vldespesaprevidenciaria = $si169_vldespesaprevidenciaria;
$clprojecaoatuarial20->si169_dtcadastro = $si169_dtcadastro;
$clprojecaoatuarial20->si169_instit = $si169_instit;
  */
}
if(isset($incluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clprojecaoatuarial20->incluir($si169_sequencial);
    $erro_msg = $clprojecaoatuarial20->erro_msg;
    if($clprojecaoatuarial20->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($alterar)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clprojecaoatuarial20->alterar($si169_sequencial);
    $erro_msg = $clprojecaoatuarial20->erro_msg;
    if($clprojecaoatuarial20->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($excluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clprojecaoatuarial20->excluir($si169_sequencial);
    $erro_msg = $clprojecaoatuarial20->erro_msg;
    if($clprojecaoatuarial20->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($opcao)){
   $result = $clprojecaoatuarial20->sql_record($clprojecaoatuarial20->sql_query($si169_sequencial));
   if($result!=false && $clprojecaoatuarial20->numrows>0){
     db_fieldsmemory($result,0);
   }
}
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
<center>
<fieldset   style="margin-left:40px; margin-top: 20px;">
<legend><b>Projecao</legend>
  <?
  include("forms/db_frmprojecaoatuarial20.php");
  ?>
</fieldset>
</center>
</body>
</html>
<?
if(isset($alterar) || isset($excluir) || isset($incluir)){
    db_msgbox($erro_msg);
    if($clprojecaoatuarial20->erro_campo!=""){
        echo "<script> document.form1.".$clprojecaoatuarial20->erro_campo.".style.backgroundColor='#99A9AE';</script>";
        echo "<script> document.form1.".$clprojecaoatuarial20->erro_campo.".focus();</script>";
    }
}
?>
