<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_habilitacaoforn_classe.php");
include("classes/db_habilitacaosocios_classe.php");
$clhabilitacaoforn = new cl_habilitacaoforn;
  /*
$clhabilitacaosocios = new cl_habilitacaosocios;
  */
db_postmemory($HTTP_POST_VARS);
   $db_opcao = 33;
$db_botao = false;
if(isset($excluir)){
  $sqlerro=false;
  db_inicio_transacao();
  $clhabilitacaosocios->l207_sequencial=$l206_sequencial;
  $clhabilitacaosocios->excluir($l206_sequencial);

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
   $db_opcao = 3;
   $db_botao = true;
}else if(isset($chavepesquisa)){
   $db_opcao = 3;
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
         parent.document.formaba.habilitacaosocios.disabled=false;
         CurrentWindow.corpo.iframe_habilitacaosocios.location.href='lic1_habilitacaosocios001.php?db_opcaoal=33&l207_sequencial=".@$l206_sequencial."';
     ";
         if(isset($liberaaba)){
           echo "  parent.mo_camada('habilitacaosocios');";
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
