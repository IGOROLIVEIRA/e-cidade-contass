<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_saldotransfctb_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clsaldotransfctb = new cl_saldotransfctb;
$db_opcao = 22;
$db_botao = false;
if(isset($alterar)){
  
	$sqlerro = false;
	db_inicio_transacao();
  	$db_opcao = 2;
  	$clsaldotransfctb->alterar($si202_seq);
  
	$sWhere = " si202_codctb = {$si202_codctb} 
				and si202_codfontrecursos = {$si202_codfontrecursos} 
				and si202_anousu = ".db_getsession('DB_anousu')." 
				and si202_instit = ".db_getsession('DB_instit');
	$sSqlVerifica = $clsaldotransfctb->sql_query(null, "*", null, $sWhere);
	$rsVerifica = db_query($sSqlVerifica);
	
	if (pg_num_rows($rsVerifica) > 1) {

		$clsaldotransfctb->erro_msg = "Já existe saldo cadastrado para o Código CTB e Fonte!";
		$clsaldotransfctb->erro_status = "0";
		$sqlerro = true;

	}

  	db_fim_transacao($sqlerro);

}else if(isset($chavepesquisa)){
   $db_opcao = 2;
   $result = $clsaldotransfctb->sql_record($clsaldotransfctb->sql_query($chavepesquisa)); 
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
<table border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table width="590" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmsaldotransfctb.php");
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
  if($clsaldotransfctb->erro_status=="0"){
    $clsaldotransfctb->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clsaldotransfctb->erro_campo!=""){
      echo "<script> document.form1.".$clsaldotransfctb->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clsaldotransfctb->erro_campo.".focus();</script>";
    }
  }else{
    $clsaldotransfctb->erro(true,true);
  }
}
if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","si202_codfontrecursos",true,1,"si202_codfontrecursos",true);
</script>
