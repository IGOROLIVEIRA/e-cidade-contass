<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_contratos_classe.php");
include("classes/db_empcontratos_classe.php");
$clcontratos = new cl_contratos;
$clempcontratos = new cl_empcontratos;

db_postmemory($HTTP_POST_VARS);
   $db_opcao = 33;
$db_botao = false;
if(isset($excluir)){
  $sqlerro=false;
  db_inicio_transacao();
  $clempcontratos->excluir(null,'si173_codcontrato = '.$si172_sequencial);
  if($clempcontratos->erro_status==0){
    $sqlerro=true;
  }
  $erro_msg = $clempcontratos->erro_msg;
  $clcontratos->excluir($si172_sequencial);
  if($clcontratos->erro_status==0){
    $sqlerro=true;
  }
  $erro_msg = $clcontratos->erro_msg;
  db_fim_transacao($sqlerro);
   $db_opcao = 3;
   $db_botao = true;
}else if(isset($chavepesquisa)){
   $db_opcao = 3;
   $db_botao = true;
   $result = $clcontratos->sql_record($clcontratos->sql_query_file($chavepesquisa));
   db_fieldsmemory($result,0);
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
<legend><b>Contratos</b></legend>
  <?
  include("forms/db_frmcontratos.php");
  ?>
</fieldset>
</center>
</body>
</body>
</html>
<?
if(isset($excluir)){
  if($sqlerro==true){
    db_msgbox($erro_msg);
    if($clcontratos->erro_campo!=""){
      echo "<script> document.form1.".$clcontratos->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clcontratos->erro_campo.".focus();</script>";
    };
  }else{
   db_msgbox($erro_msg);
 echo "
  <script>
    function js_db_tranca(){
      parent.location.href='sic1_contratos003.php';
    }\n
    js_db_tranca();
  </script>\n
 ";
  }
}
if(isset($chavepesquisa)){
 echo "
  <script>
      function js_db_libera(){
         parent.document.formaba.empcontratos.disabled=false;
         CurrentWindow.corpo.iframe_empcontratos.location.href='sic1_empcontratos001.php?db_opcaoal=33&si173_codcontrato=".@$si172_sequencial."';
     ";
         if(isset($liberaaba)){
           echo "  parent.mo_camada('empcontratos');";
         }
 echo"}\n
    js_db_libera();
  </script>\n
 ";
}
 if($db_opcao==22||$db_opcao==33){
    echo "<script>document.form1.pesquisar.click();</script>";
 }
?>
