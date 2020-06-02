<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_pctipocompratribunal_classe.php");
include("classes/db_licobras_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$cllicobraslicitacao = new cl_licobraslicitacao;
$clpctipocompratribunal = new cl_pctipocompratribunal;
$cllicobras = new cl_licobras;
$db_botao = false;
$db_opcao = 33;
if(isset($excluir)){
try {
    db_inicio_transacao();

    $rsLicobras = $cllicobras->sql_record($cllicobras->sql_query(null,"*",null,"obr01_licitacao = $obr07_sequencial"));
    if(pg_num_rows($rsLicobras) > 0){
        throw new Exception("Licitação vinculada a uma obra!");
    }

    $db_opcao = 3;
    $cllicobraslicitacao->excluir($obr07_sequencial);
    db_fim_transacao();
}catch (Exception $eErro){
    db_msgbox($eErro->getMessage());
}
}else if(isset($chavepesquisa)){
   $db_opcao = 3;
   $result = $cllicobraslicitacao->sql_record($cllicobraslicitacao->sql_query($chavepesquisa)); 
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
<style>
    #obr07_objeto{
        width: 510px;
        height: 70px;
    }
    #formulariolicitacao{
        margin-left: 30%;
        margin-top: 5%;
    }
</style>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmlicobraslicitacao.php");
	?>
    </center>
	</td>
  </tr>
</table>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<?
if(isset($excluir)){
  if($cllicobraslicitacao->erro_status=="0"){
    $cllicobraslicitacao->erro(true,false);
  }else{
    $cllicobraslicitacao->erro(true,true);
  }
}
if($db_opcao==33){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","excluir",true,1,"excluir",true);
</script>
