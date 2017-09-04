<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_itensregpreco_classe.php");
include("classes/db_adesaoregprecos_classe.php");
include("dbforms/db_funcoes.php");
require_once("libs/db_utils.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$clitensregpreco = new cl_itensregpreco;
$cladesaoregpreco = new cl_adesaoregprecos;
$db_opcao = 1;
$db_botao = true;

if ($opcao == 3) {
    $db_opcao = 3;
}

$sSQLTabela = $clitensregpreco->sql_query_novo(null, "itensregpreco.*,z01_nome, case when si07_codunidade is null then si07_unidade else m61_descr end as m61_descr,pc01_descrmater", null, "si07_sequencialadesao = {$codigoAdesao}");
$rsResultTabela = $clitensregpreco->sql_record($sSQLTabela);

$result = $cladesaoregpreco->sql_record($cladesaoregpreco->sql_query_file($codigoAdesao,"si06_processocompra,si06_processoporlote,si06_descontotabela",null,""));
//db_query("select si06_processoporlote from adesaoregprecos where si06_sequencial = $codigoAdesao");
$iProcessoLote   = db_utils::fieldsmemory($result,0)->si06_processoporlote;//db_criatabela($result);
$iDescontoTabela = db_utils::fieldsmemory($result,0)->si06_descontotabela;
$iProcessoCompra = db_utils::fieldsmemory($result,0)->si06_processocompra;

?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">

  <div>
    <?php include("forms/db_frmitensregpreco.php"); ?>
  </div>

</body>
</html>
<script>
    js_tabulacaoforms("form1", "si07_numerolote", true, 1, "si07_numerolote", true);
</script>
