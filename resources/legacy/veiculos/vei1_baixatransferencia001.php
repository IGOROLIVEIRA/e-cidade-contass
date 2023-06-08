<?
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once('libs/db_app.utils.php');
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/JSON.php");
require_once("std/db_stdClass.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
  $db_opcao = 1;
  $departamentos  = db_query("
                      select coddepto, descrdepto
                        from db_depart
                          inner join veiccadcentral on veiccadcentral.ve36_coddepto = db_depart.coddepto
                      where db_depart.instit = ".db_getsession("DB_instit")." order by db_depart.descrdepto
                  ");
  $aDepartamentos = db_utils::getCollectionByRecord($departamentos);
  //echo "<pre>".print_r(db_getsession());die;
?>
<script>
 document.form1.departamento_atual.value = <?php echo db_getsession('DB_coddepto'); ?>
</script>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">

<script type="text/javascript" src="scripts/scripts.js"></script>

<link href="estilos.css" rel="stylesheet" type="text/css">

<style type="text/css">
.container {
  width: 900px;
}
.titulo{
  margin-left: 15px;
}
</style>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="carregaVeiculos(document.form1.departamento_atual.value)">
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<div class="titulo"><h2>Baixa por Transferência<h2></div><hr>
<div class="container">
  <?php
    include("forms/frmveictransferencia.php");
  ?>
</div>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>


