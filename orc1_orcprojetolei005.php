<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_orcprojetolei_classe.php");
include("dbforms/db_funcoes.php");
include('classes/db_orcleialtorcamentaria_classe.php');
include('classes/db_orcalteracaopercloa_classe.php');
include("classes/db_orcsuplemtipo_classe.php");
include("classes/db_orcsuplem_classe.php");
$clorcsuplemtipo = new cl_orcsuplemtipo;
$clorcsuplem     = new cl_orcsuplem;
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clorcprojetolei = new cl_orcprojetolei;
$clorcleialtorcamentaria = new cl_orcleialtorcamentaria;
$clorcalteracaopercloa   = new cl_orcalteracaopercloa;
$db_opcao = 22;
$db_botao = true;
if(isset($alterar)){

  db_inicio_transacao();
  $db_opcao = 2;
  $clorcprojetolei->alterar($o138_sequencial);

  db_fim_transacao();
}else if(isset($chavepesquisa)){
   $db_opcao = 2;
   $result = $clorcprojetolei->sql_record($clorcprojetolei->sql_query($chavepesquisa));
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
	include("forms/db_frmorcprojetolei.php");
	?>
    </center>
    </td>
  </tr>
</table>
</body>
</html>
<?
if(isset($alterar)){
  if($clorcprojetolei->erro_status=="0"){
    $clorcprojetolei->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clorcprojetolei->erro_campo!=""){
      echo "<script> document.form1.".$clorcprojetolei->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clorcprojetolei->erro_campo.".focus();</script>";
    }
  }else{
    db_msgbox($clorcprojetolei->erro_msg);
    //db_redireciona("orc1_orcleialtorcamentaria001.php?o200_orcprojetolei=".$o138_sequencial." ");
  }

}
if (isset($chavepesquisa)) {
	echo "
      <script>
             parent.document.formaba.db_leialtorc.disabled=false;
             top.corpo.iframe_db_leialtorc.location.href='orc1_orcleialtorcamentaria001.php?o200_orcprojetolei=".@$o138_sequencial."';
      </script>
     ";
}
if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","o138_numerolei",true,1,"o138_numerolei",true);
</script>
