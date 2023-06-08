<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_liclicita_classe.php");
include("classes/db_liclicitem_classe.php");

db_postmemory($HTTP_GET_VARS);
db_postmemory($HTTP_POST_VARS);

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

$clliclicitem = new cl_liclicitem;
$clliclicita  = new cl_liclicita;

$clliclicita->rotulo->label("pc80_codproc");
$clliclicita->rotulo->label("l20_numero");
$clliclicita->rotulo->label("l20_edital");
$clrotulo = new rotulocampo;
$clrotulo->label("l03_descr");

$sWhereContratos = " and 1 = 1 ";
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <table height="100%" border="0" align="center" cellspacing="0" bgcolor="#CCCCCC">
        <tr>
            <td height="63" align="center" valign="top">
                <table width="35%" border="0" align="center" cellspacing="0">
                    <form name="form2" method="post" action="">
                        <tr>
                            <td width="4%" align="right" nowrap title="<?= $Tpc80_codproc ?>">
                                <?= $Lpc80_codproc ?>
                            </td>
                            <td width="96%" align="left" nowrap>
                                <?
                                db_input("pc80_codproc", 10, $Ipc80_codproc, true, "text", 4, "", "chave_pc80_codproc");
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" align="center">
                                <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
                                <input name="limpar" type="reset" id="limpar" value="Limpar">
                                <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_liclicita.hide();">
                            </td>
                        </tr>
                    </form>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" valign="top">
                <?
                if (isset($chave_pc80_codproc) && (trim($chave_pc80_codproc) != "")) {
                    $sql = "SELECT DISTINCT pc80_codproc,
                    pc80_resumo,
                    l213_numerocontrolepncp
                    FROM pcproc
                    INNER JOIN pcprocitem ON pc81_codproc = pc80_codproc
                    INNER JOIN liccontrolepncp ON l213_processodecompras = pc80_codproc
                    WHERE pc80_codproc = $chave_pc80_codproc and l213_instit=" . db_getsession('DB_instit');
                } else {
                    $sql = "SELECT DISTINCT pc80_codproc,
                    pc80_resumo,
                    l213_numerocontrolepncp
                    FROM pcproc
                    INNER JOIN pcprocitem ON pc81_codproc = pc80_codproc
                    INNER JOIN liccontrolepncp ON l213_processodecompras = pc80_codproc
                    WHERE l213_instit=" . db_getsession('DB_instit') . " order by pc80_codproc desc";
                }
                //die($sql);
                db_lovrot($sql, 15, "()", "", $funcao_js);
                ?>
            </td>
        </tr>
    </table>
</body>

</html>
<?
if (!isset($pesquisa_chave)) {
?>
    <script>
    </script>
<?
}
?>