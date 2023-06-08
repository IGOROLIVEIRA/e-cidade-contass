<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_credenciamentotermo_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clcredenciamentotermo = new cl_credenciamentotermo;
?>
<html>

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
    <link href='estilos.css' rel='stylesheet' type='text/css'>
    <script language='JavaScript' type='text/javascript' src='scripts/scripts.js'></script>
</head>

<body>
    <form name="form2" method="post" action="" class="container">
        <fieldset>
            <legend>Dados para Pesquisa</legend>
            <table width="35%" border="0" align="center" cellspacing="3" class="form-container">
            </table>
        </fieldset>
        <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
        <input name="limpar" type="reset" id="limpar" value="Limpar">
        <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_credenciamentotermo.hide();">
    </form>
    <?
    if (!isset($pesquisa_chave)) {
        if (isset($campos) == false) {
            if (file_exists("funcoes/db_func_credenciamentotermo.php") == true) {
                include("funcoes/db_func_credenciamentotermo.php");
            } else {
                $campos = "credenciamentotermo.*";
            }
        }

        $campos = "l212_sequencial,l20_codigo,l212_numerotermo,l212_anousu,z01_numcgm,z01_nome,l212_dtinicio,l212_dtfim,l212_dtpublicacao,l212_observacao,l20_edital,l20_numero,l20_anousu,pc50_codcom,l03_descr";

        $sql = $clcredenciamentotermo->sql_query(null, $campos, 'l212_numerotermo desc', $Where);
        $repassa = array();
        echo '<div class="container">';
        echo '  <fieldset>';
        echo '    <legend>Resultado da Pesquisa</legend>';
        //die($sql);
        db_lovrot($sql, 15, "()", "", $funcao_js, "", "NoMe", $repassa);
        echo '  </fieldset>';
        echo '</div>';
    } else {
        if ($pesquisa_chave != null && $pesquisa_chave != "") {
            $result = $clcredenciamentotermo->sql_record($clcredenciamentotermo->sql_query($pesquisa_chave));
            if ($clcredenciamentotermo->numrows != 0) {
                db_fieldsmemory($result, 0);
                echo "<script>" . $funcao_js . "('$l212_sequencial',false);</script>";
            } else {
                echo "<script>" . $funcao_js . "('Chave(" . $pesquisa_chave . ") n�o Encontrado',true);</script>";
            }
        } else {
            echo "<script>" . $funcao_js . "('',false);</script>";
        }
    }
    ?>
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