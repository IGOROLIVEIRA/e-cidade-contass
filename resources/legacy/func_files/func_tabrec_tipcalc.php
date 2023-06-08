<?php

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("libs/db_utils.php");
include("dbforms/db_funcoes.php");
include("classes/db_tabrec_classe.php");

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

$oPost = db_utils::postMemory($_POST);
$oGet = db_utils::postMemory($_GET);

$cltabrec = new cl_tabrec;
$cltabrec->rotulo->label("k02_codigo");
$cltabrec->rotulo->label("k02_descr");

?>
<html lang="">
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
                        <td width="4%" align="right" nowrap title="<?= $Tk02_codigo ?>">
                            <?= $Lk02_codigo ?>
                        </td>
                        <td width="96%" align="left" nowrap>
                            <?php
                            db_input("k02_codigo", 4, $Ik02_codigo, true, "text", 4, "", "chave_k02_codigo");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="4%" align="right" nowrap title="<?= $Tk02_descr ?>">
                            <?= $Lk02_descr ?>
                        </td>
                        <td width="96%" align="left" nowrap>
                            <?php
                            db_input("k02_descr", 15, $Ik02_descr, true, "text", 4, "", "chave_k02_descr");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="4%" align="right" nowrap>
                            <b>Listar:</b>
                        </td>
                        <td width="96%" align="left" nowrap>
                            <?php
                            global $listar;
                            $tipo = array("t" => "Todas...", "s" => "Sem ligação com Orçamento/Plano de Contas");
                            db_select("listar", $tipo, true, "text", "onchange='document.form2.submit()';");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
                            <input name="limpar" type="reset" id="limpar" value="Limpar">
                            <input name="Fechar" type="button" id="fechar" value="Fechar"
                                   onClick="parent.db_iframe_tabrec.hide();">
                        </td>
                    </tr>
                </form>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" valign="top">
            <?php

            $sAnd = "";
            $sWhere = " exists (select 1 from tipcalc inner join tipcalcexe on q81_codigo = q83_tipcalc and q83_anousu = ".db_getsession('DB_anousu')." where q81_tipo in (3,4) and k02_codigo = q81_recexe) ";

            if (isset($k02_tabrectipo) && (trim($k02_tabrectipo) != "")) {
                $sWhere = " and k02_tabrectipo in({$k02_tabrectipo}) ";
            }

            if (trim($sWhere) != '') {
                $sAnd = " and ";
            }

            if (!isset($pesquisa_chave)) {

                if (isset($campos) == false) {
                    $campos = "tabrec.*";
                }

                if (isset($chave_k02_codigo) && (trim($chave_k02_codigo) != "")) {
                    if (isset($listar) && $listar == "s") {
                        $sql = $cltabrec->sql_query_semorcplan("", $campos, "k02_codigo", $sWhere . $sAnd . " k02_codigo = $chave_k02_codigo");
                    } else {
                        $sql = $cltabrec->sql_query_cadastrar("", $campos, "k02_codigo", $sWhere . $sAnd . " k02_codigo = $chave_k02_codigo");
                    }
                } else if (isset($chave_k02_descr) && (trim($chave_k02_descr) != "")) {
                    if (isset($listar) && $listar == "s") {
                        $sql = $cltabrec->sql_query_semorcplan("", $campos, "k02_drecei", $sWhere . $sAnd . " upper(k02_drecei) like '$chave_k02_descr%' ");
                    } else {
                        $sql = $cltabrec->sql_query_cadastrar("", $campos, "k02_drecei", $sWhere . $sAnd . " upper(k02_drecei) like '$chave_k02_descr%' ");
                    }
                } else {
                    if (isset($listar) && $listar == "s") {
                        $sql = $cltabrec->sql_query_semorcplan("", $campos, "k02_codigo", $sWhere);
                    } else {
                        $sql = $cltabrec->sql_query_cadastrar("", $campos, "k02_codigo", $sWhere);
                    }
                }

                $repassar["listar"] = @$listar;

                db_lovrot($sql, 15, "()", "", $funcao_js, "", "NoMe", $repassar, false);

            } else {

                if (isset($pesquisa_chave) && $pesquisa_chave != "") {

                    if (isset($listar) && $listar == "s") {
                        $result = $cltabrec->sql_record($cltabrec->sql_query_semorcplan(null, "*", null, $sWhere . $sAnd . " k02_codigo = $pesquisa_chave"));
                    } else {
                        $result = $cltabrec->sql_record($cltabrec->sql_query_cadastrar(null, "*", null, $sWhere . $sAnd . " k02_codigo = $pesquisa_chave"));
                    }

                    if ($cltabrec->numrows != 0) {
                        db_fieldsmemory($result, 0);

                        if (isset($k02_tabrectipo) && (trim($k02_tabrectipo) != "")) {
                            echo "<script>" . $funcao_js . "('$k02_descr',false);</script>";
                        } else {
                            echo "<script>" . $funcao_js . "('$k02_drecei',false);</script>";
                        }

                    } else {
                        echo "<script>" . $funcao_js . "('Chave(" . $pesquisa_chave . ") não Encontrado',true);</script>";
                    }

                }

            }
            ?>
        </td>
    </tr>
</table>
</body>
</html>
<?php
if (!isset($pesquisa_chave)) {
    ?>
    <script>
        document.form2.chave_k02_codigo.focus();
        document.form2.chave_k02_codigo.select();
    </script>
    <?php
}
?>
