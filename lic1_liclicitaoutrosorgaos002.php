<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_liclicitaoutrosorgaos_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clliclicitaoutrosorgaos = new cl_liclicitaoutrosorgaos;
$db_opcao = 22;
$db_botao = false;
$sqlerro  = false;
if(isset($alterar)){
    db_inicio_transacao();
    $db_opcao = 2;
    if($sqlerro==false){

        $result_dtcadcgm = db_query("select z09_datacadastro from historicocgm where z09_numcgm = {$lic211_orgao} and z09_tipo = 1");
        db_fieldsmemory($result_dtcadcgm, 0)->z09_datacadastro;
        $dtsession   = date("Y-m-d",db_getsession("DB_datausu"));

        if($dtsession < $z09_datacadastro){
            db_msgbox("Usuário: A data de cadastro do CGM informado é superior a data do procedimento que está sendo realizado. Corrija a data de cadastro do CGM e tente novamente!");
            $sqlerro = true;
        }

        /**
         * controle de encerramento peri. Patrimonial
         */
        $clcondataconf = new cl_condataconf;
        $resultControle = $clcondataconf->sql_record($clcondataconf->sql_query_file(db_getsession('DB_anousu'),db_getsession('DB_instit'),'c99_datapat'));
        db_fieldsmemory($resultControle,0);

        if($dtsession <= $c99_datapat){
            db_msgbox("O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.");
            $sqlerro = true;
        }
    }

    if($sqlerro==false){
        $clliclicitaoutrosorgaos->alterar($lic211_sequencial);
    }
    db_fim_transacao();
}else if(isset($chavepesquisa)){
   $db_opcao = 2;
   $result = $clliclicitaoutrosorgaos->sql_record($clliclicitaoutrosorgaos->sql_query($chavepesquisa)); 
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
	include("forms/db_frmliclicitaoutrosorgaos.php");
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
  if($clliclicitaoutrosorgaos->erro_status=="0"){
    $clliclicitaoutrosorgaos->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clliclicitaoutrosorgaos->erro_campo!=""){
      echo "<script> document.form1.".$clliclicitaoutrosorgaos->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clliclicitaoutrosorgaos->erro_campo.".focus();</script>";
    }
  }else{
    $clliclicitaoutrosorgaos->erro(true,true);
  }
}
if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","lic211_orgao",true,1,"lic211_orgao",true);
</script>
