<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_licobrasmedicao_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$cllicobrasmedicao = new cl_licobrasmedicao;
$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){
  db_inicio_transacao();
  $cllicobrasmedicao->obr03_seqobra            = $obr03_seqobra;
  $cllicobrasmedicao->obr03_dtlancamento       = $obr03_dtlancamento;
  $cllicobrasmedicao->obr03_nummedicao         = $obr03_nummedicao;
  $cllicobrasmedicao->obr03_tipomedicao        = $obr03_tipomedicao;
  $cllicobrasmedicao->obr03_dtiniciomedicao    = $obr03_dtiniciomedicao;
  $cllicobrasmedicao->obr03_outrostiposmedicao = $obr03_outrostiposmedicao;
  $cllicobrasmedicao->obr03_descmedicao        = $obr03_descmedicao;
  $cllicobrasmedicao->obr03_dtfimmedicao       = $obr03_dtfimmedicao;
  $cllicobrasmedicao->obr03_dtentregamedicao   = $obr03_dtentregamedicao;
  $cllicobrasmedicao->obr03_vlrmedicao         = $obr03_vlrmedicao;
  $cllicobrasmedicao->obr03_instit             = db_getsession('DB_instit');
  $cllicobrasmedicao->incluir();
  db_fim_transacao();
  db_redireciona("obr1_licobrasmedicao002.php?&chavepesquisa=$obr03_sequencial");
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
<script>
js_tabulacaoforms("form1","obr03_seqobra",true,1,"obr03_seqobra",true);
</script>
<?
if(isset($incluir)){
  if($cllicobrasmedicao->erro_status=="0"){
    $cllicobrasmedicao->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($cllicobrasmedicao->erro_campo!=""){
      echo "<script> document.form1.".$cllicobrasmedicao->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cllicobrasmedicao->erro_campo.".focus();</script>";
    }
  }else{
    $cllicobrasmedicao->erro(true,true);
  }
}
?>
