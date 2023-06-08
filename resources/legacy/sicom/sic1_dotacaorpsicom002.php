<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_dotacaorpsicom_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$cldotacaorpsicom = new cl_dotacaorpsicom;
$db_opcao = 22;
$db_botao = false;
if(isset($alterar)){
  
    db_inicio_transacao();
    $db_opcao = 2;

    $sSqlVerifica = $cldotacaorpsicom->sql_query_file(null, "*", null, "si177_numemp = {$si177_numemp} and si177_sequencial != {$si177_sequencial}");
    $rsVerifica = db_query($sSqlVerifica);
  
    if (pg_num_rows($rsVerifica) > 0) {
     
        $cldotacaorpsicom->erro_msg = "Já existe registro para o empenho selecionado.";
        $cldotacaorpsicom->erro_status = 0;

    } else {
    
        $cldotacaorpsicom->alterar($si177_sequencial);
        db_fim_transacao();

    }
}else if(isset($chavepesquisa)){
   $db_opcao = 2;
   $result = $cldotacaorpsicom->sql_record($cldotacaorpsicom->sql_query($chavepesquisa)); 
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
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmdotacaorpsicom.php");
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
  if($cldotacaorpsicom->erro_status=="0"){
    $cldotacaorpsicom->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($cldotacaorpsicom->erro_campo!=""){
      echo "<script> document.form1.".$cldotacaorpsicom->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cldotacaorpsicom->erro_campo.".focus();</script>";
    }
  }else{
    $cldotacaorpsicom->erro(true,true);
  }
}
if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","si177_numemp",true,1,"si177_numemp",true);
</script>
