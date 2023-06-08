<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_habilitacaosocios_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clhabilitacaosocios = new cl_habilitacaosocios;
$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){
  db_inicio_transacao();
  $clhabilitacaosocios->incluir($l207_sequencial);
  db_fim_transacao();

}
if(isset($alterar)){
  db_inicio_transacao();
  $db_opcao = 2;
  $clhabilitacaosocios->alterar($l207_sequencial);
  db_fim_transacao();
}
if(isset($excluir)){
  db_inicio_transacao();
  $db_opcao = 3;
  $clhabilitacaosocios->excluir($l207_sequencial);
  db_fim_transacao();

}else if(isset($chavepesquisa)){
   $db_opcao = 2;
   $result = $clhabilitacaosocios->sql_record($clhabilitacaosocios->sql_query($chavepesquisa));
   db_fieldsmemory($result,0);
   $db_botao = true;
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
	include("forms/db_frmhabilitacaosocios.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<script>
js_tabulacaoforms("form1","l207_socio",true,1,"l207_socio",true);
</script>
<?
if(isset($incluir)){
  if($clhabilitacaosocios->erro_status=="0"){
    $clhabilitacaosocios->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clhabilitacaosocios->erro_campo!=""){
      echo "<script> document.form1.".$clhabilitacaosocios->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clhabilitacaosocios->erro_campo.".focus();</script>";
    }
  }else{
      echo "
  <script>
      function js_db_libera(){
         parent.document.formaba.db_habsocios.disabled=false;
         CurrentWindow.corpo.iframe_db_habsocios.location.href='lic1_habilitacaosocios001.php?l207_habilitacao=".@$l206_sequencial."';
       ";

           echo "  parent.mo_camada('db_hab');";

 echo"}\n
    js_db_libera();
  </script>\n
 ";
  }
}
?>
