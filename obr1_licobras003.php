<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_licobras_classe.php");
include("classes/db_licobrasresponsaveis_classe.php");
include("classes/db_licobrasituacao_classe.php");
include("classes/db_licobrasmedicao_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$cllicobras = new cl_licobras;
$cllicobrasresponsaveis = new cl_licobrasresponsaveis();
$cllicobrasituacao = new cl_licobrasituacao();
$cllicobrasmedicao = new cl_licobrasmedicao();
$db_botao = false;
$db_opcao = 33;
if(isset($excluir)){
  try{

    $result = $cllicobrasresponsaveis->sql_record($cllicobrasresponsaveis->sql_query(null,"*", null, "obr05_seqobra = $obr01_sequencial"));
    $resultSituacao = $cllicobrasituacao->sql_record($cllicobrasituacao->sql_query(null,"*",null,"obr02_seqobra = $obr01_sequencial"));
    $resultMedicao = $cllicobrasmedicao->sql_record($cllicobrasmedicao->sql_query(null,"*",null,"obr03_seqobra = $obr01_sequencial"));
    db_inicio_transacao();
    $db_opcao = 3;
    $valida = false;

    if(pg_num_rows($result) > 0){
      throw new Exception ("Usuário: Exclusão Abortada! Existem responsáveis vinculados a obra.");
      $valida = true;
    }

    if (pg_num_rows($resultSituacao) > 0){
      throw new Exception ("Usuário: Exclusão Abortada! Existe situações lançadas para esta obra.");
      $valida = true;
    }

    if (pg_num_rows($resultMedicao) > 0){
      throw new Exception ("Usuário: Exclusão Abortada! Existe Medições lançadas para esta obra.");
      $valida = true;
    }

    if($valida == false){
      $cllicobras->excluir($obr01_sequencial);
      if($cllicobras->erro_status == 0){
        $erro = $cllicobras->erro_msg;
        db_msgbox($erro);
        $sqlerro = true;
      }
    }

    db_fim_transacao();
  }catch (Exception $eErro){
    db_msgbox($eErro->getMessage());
  }

}else if(isset($chavepesquisa)){
   $db_opcao = 3;
   $result = $cllicobras->sql_record($cllicobras->sql_query($chavepesquisa));
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
  #l20_objeto{
    width: 711px;
    height: 55px;
  }
  #obr01_linkobra{
    width: 617px;
    height: 18px;
  }
  #obr01_numartourrt{
    width: 162px;
  }
  #obr01_tiporegistro{
    width: 40%;
  }
</style>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0" style="margin-left: 16%; margin-top: 2%;">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
      <center>
        <?
        include("forms/db_frmlicobras.php");
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
  if($cllicobras->erro_status=="0"){
    $cllicobras->erro(true,false);
  }else{
    $cllicobras->erro(true,true);
  }
}
if($db_opcao==33){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","excluir",true,1,"excluir",true);
</script>
