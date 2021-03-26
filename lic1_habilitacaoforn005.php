<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_habilitacaoforn_classe.php");
include("classes/db_habilitacaosocios_classe.php");
$clhabilitacaoforn = new cl_habilitacaoforn;
$clhabilitacaosocios = new cl_habilitacaosocios;
db_postmemory($HTTP_POST_VARS);

echo "<script> parent.document.formaba.db_habsocios.disabled=true; </script>";

$db_opcao = 2;
$db_botao = true;
if(isset($incluir)){
  $sqlerro=false;
  db_inicio_transacao();
  $clhabilitacaoforn->incluir($l206_sequencial);
  if($clhabilitacaoforn->erro_status==0){
    $sqlerro=true;
  }
  $erro_msg = $clhabilitacaoforn->erro_msg;
  db_fim_transacao($sqlerro);
   $l206_sequencial= $clhabilitacaoforn->l206_sequencial;
   $db_opcao = 1;
   $db_botao = true;
}
if(isset($alterar)){
  $sqlerro=false;
  db_inicio_transacao();
  $clhabilitacaoforn->alterar($l206_sequencial);
  if($clhabilitacaoforn->erro_status==0){
    $sqlerro=true;
  }
  $erro_msg = $clhabilitacaoforn->erro_msg;
  db_fim_transacao($sqlerro);
   $db_opcao = 2;
   $db_botao = true;
}
if(isset($excluir)){
  $sqlerro=false;
  db_inicio_transacao();
  $clhabilitacaosocios->excluir('',"l207_habilitacao = $l206_sequencial");

  if($clhabilitacaosocios->erro_status==0){
    $sqlerro=true;
  }
  $erro_msg = $clhabilitacaosocios->erro_msg;
  $clhabilitacaoforn->excluir($l206_sequencial);
  if($clhabilitacaoforn->erro_status==0){
    $sqlerro=true;
  }
  $erro_msg = $clhabilitacaoforn->erro_msg;
  db_fim_transacao($sqlerro);
   $db_opcao = 2;
   $db_botao = true;
}
else if(isset($chavepesquisa)){
   $db_opcao = 2;
   $db_botao = true;
   $result = $clhabilitacaoforn->sql_record($clhabilitacaoforn->sql_query($chavepesquisa));
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
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
	<?
	include("forms/db_frmhabilitacaoforn.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?
if(isset($incluir)){
  if($sqlerro==true){
    db_msgbox($erro_msg);
    if($clhabilitacaoforn->erro_campo!=""){
      echo "<script> document.form1.".$clhabilitacaoforn->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clhabilitacaoforn->erro_campo.".focus();</script>";
    };
  }else{
   db_msgbox($erro_msg);
   //db_redireciona("lic1_habilitacaoforn005.php?liberaaba=true&chavepesquisa=$l206_sequencial");
   echo "
  <script>
      function js_db_libera(){
         parent.document.formaba.db_habsocios.disabled=false;
         CurrentWindow.corpo.iframe_db_habsocios.location.href='lic1_habilitacaosocios001.php?l207_habilitacao=".@$l206_sequencial."';
       ";
           echo "  parent.mo_camada('db_habsocios');";
 echo"}\n
    js_db_libera();
  </script>\n
 ";
  }
}
if(isset($alterar)){
  if($sqlerro==true){
    db_msgbox($erro_msg);
    if($clhabilitacaoforn->erro_campo!=""){
      echo "<script> document.form1.".$clhabilitacaoforn->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clhabilitacaoforn->erro_campo.".focus();</script>";

    };
  }else{
   db_msgbox($erro_msg);
   echo "
  <script>
      function js_db_libera(){
         parent.document.formaba.db_habsocios.disabled=false;
         CurrentWindow.corpo.iframe_db_habsocios.location.href='lic1_habilitacaosocios001.php?l207_habilitacao=".@$l206_sequencial."';
       ";
           echo "  parent.mo_camada('db_habsocios');";
 echo"}\n
    js_db_libera();
  </script>\n
 ";
  }
}
if(isset($excluir)){
  if($sqlerro==true){
    db_msgbox($erro_msg);
    if($clhabilitacaoforn->erro_campo!=""){
      echo "<script> document.form1.".$clhabilitacaoforn->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clhabilitacaoforn->erro_campo.".focus();</script>";
    };
  }else{
   db_msgbox($erro_msg);
 echo "
  <script>
    function js_db_tranca(){
      parent.location.href='lic1_habilitacaoforn003.php';
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
         parent.document.formaba.db_habsocios.disabled=false;
         CurrentWindow.corpo.iframe_db_habsocios.location.href='lic1_habilitacaosocios001.php?l207_habilitacao=".@$l206_sequencial."';
       ";
         if(isset($liberaaba)){
           echo "  parent.mo_camada('db_habsocios');";
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
