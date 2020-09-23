<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_dividaconsolidada_classe.php");
require_once ("classes/db_cgm_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$cldividaconsolidada = new cl_dividaconsolidada;
$clcgm               = new cl_cgm;
$db_opcao = 22;
$db_botao = false;
$sqlerro==false;
if(isset($alterar)){
  db_inicio_transacao();
  $db_opcao = 2;
  $result_dtcadcgm = db_query("select z09_datacadastro from historicocgm where z09_numcgm = {$z01_numcgm} order by z09_sequencial desc");
  db_fieldsmemory($result_dtcadcgm, 0)->z09_datacadastro;
  $z09_datacadastro = (implode("/",(array_reverse(explode("-",$z09_datacadastro)))));
  if($sqlerro==false){
     if($si167_dtassinatura < $z09_datacadastro){
        db_msgbox("Usuário: A data de cadastro do CGM informado é superior a data do procedimento que está sendo realizado. Corrija a data de cadastro do CGM e tente novamente!");
        $sqlerro = true;
     }
  }
  if($sqlerro==false) {
    $cldividaconsolidada->si167_numcgm = $z01_numcgm;
    $cldividaconsolidada->si167_justificativacancelamento = $si167_justificativacancelamento;
    $cldividaconsolidada->alterar($si167_sequencial);
  }
  db_fim_transacao();
}else if(isset($chavepesquisa)){
   $db_opcao = 2;
   $result = $cldividaconsolidada->sql_record($cldividaconsolidada->sql_query($chavepesquisa)); 
   db_fieldsmemory($result,0);
   $result = $clcgm->sql_record($clcgm->sql_query($si167_numcgm));
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
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmdividaconsolidada.php");
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
if(isset($alterar)){
  if($cldividaconsolidada->erro_status=="0"){
    $cldividaconsolidada->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($cldividaconsolidada->erro_campo!=""){
      echo "<script> document.form1.".$cldividaconsolidada->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cldividaconsolidada->erro_campo.".focus();</script>";
    }
  }else{
    $cldividaconsolidada->erro(true,true);
  }
}
if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","si167_nroleiautorizacao",true,1,"si167_nroleiautorizacao",true);
</script>
