<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_licobrasmedicao_classe.php");
include("dbforms/db_funcoes.php");
include("classes/db_licobrasanexo_classe.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$cllicobrasmedicao = new cl_licobrasmedicao;
$cllicobrasanexo = new cl_licobrasanexo;
$db_botao = false;
$db_opcao = 33;
if(isset($excluir)){
  try{
    $result = $cllicobrasanexo->sql_record($cllicobrasanexo->sql_query(null,"*",null,"obr04_licobrasmedicao = $obr03_sequencial"));
    $db_opcao = 3;

    if(pg_num_rows($result) > 0){
      throw new Exception ("Usuário: Exclusão Abortada! Existem fotos anexadas.");
    }else{
      db_inicio_transacao();
      $cllicobrasmedicao->excluir($obr03_sequencial);
      db_fim_transacao();
    }

  }catch (Exception $eErro){
    db_msgbox($eErro->getMessage());
  }

}else if(isset($chavepesquisa)){
   $db_opcao = 3;
   $result = $cllicobrasmedicao->sql_record($cllicobrasmedicao->sql_query($chavepesquisa));
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
  <?php
  db_app::load("scripts.js, prototype.js, widgets/windowAux.widget.js,strings.js");
  db_app::load("widgets/dbtextField.widget.js, dbViewCadEndereco.classe.js");
  db_app::load("dbmessageBoard.widget.js, dbautocomplete.widget.js,dbcomboBox.widget.js, datagrid.widget.js");
  db_app::load("estilos.css,grid.style.css");
  ?>
</head>
<style>
  #obr03_outrostiposmedicao{
    width: 733px;
    height: 50px;
  }

  #obr03_descmedicao{
    width: 733px;
    height: 50px;
  }
  #incluirmedicao{
    margin-top: 14px;
    margin-left: -58px;
    margin-bottom: 20px;
  }
  #obr04_legenda{
    width: 430px;
  }
</style>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0" style="margin-left: 16%; margin-top: 2%;">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
      <center>
	<?
	include("forms/db_frmlicobrasmedicao.php");
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
  if($cllicobrasmedicao->erro_status=="0"){
    $cllicobrasmedicao->erro(true,false);
  }else{
    $cllicobrasmedicao->erro(true,true);
  }
}
if($db_opcao==33){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","excluir",true,1,"excluir",true);
</script>
