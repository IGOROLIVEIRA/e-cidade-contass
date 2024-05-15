<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_credenciamento_classe.php");
include("classes/db_habilitacaoforn_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clhomologacaoadjudica  = new cl_homologacaoadjudica;
$clpcorcamforne         = new cl_pcorcamforne;
$clhabilitacaoforn      = new cl_habilitacaoforn();
$clcredenciamento       = new cl_credenciamento;
$clliclicitem           = new cl_liclicitem;
$clcgm                  = new cl_cgm;

$db_opcao = 1;
$db_botao = true;

if(isset($chavepesquisa)) {

    $db_opcao = 3;
    $result = $clcredenciamento->sql_record($clcredenciamento->sql_query('','*','',"l205_fornecedor = $chavepesquisa"));
    db_fieldsmemory($result,0);

    $sCampos  = " distinct l20_codigo";
    $sWhere   = "pc81_codprocitem = {$l205_item} ";
    $result2 = $clcredenciamento->sql_record($clliclicitem->sql_query_inf(null, $sCampos,'',$sWhere));
    db_fieldsmemory($result2,0);
    unset($l205_sequencial);
    $db_botao = true;

}
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>

    <link href="estilos.css" rel="stylesheet" type="text/css">
    <link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<?
include("forms/db_frmcredenciamento.php");
?>

</html>
<script>
    js_tabulacaoforms("form1","l205_fornecedor",true,1,"l205_fornecedor",true);
</script>
