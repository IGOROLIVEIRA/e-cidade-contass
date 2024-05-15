<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_veiccaddestino_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clveiccaddestino = new cl_veiccaddestino;
$clveiccaddestino->rotulo->label("ve75_sequencial");
$clveiccaddestino->rotulo->label("ve75_destino");
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
            <tr>
                <td width="4%" align="right" nowrap title="<?= $Tve75_sequencial ?>">
                    <?= $Lve75_sequencial ?>
                </td>
                <td width="96%" align="left" nowrap>
                    <?
                    db_input("ve75_sequencial", 10, $Ive75_sequencial, true, "text", 4, "", "chave_ve75_sequencial");
                    ?>
                </td>
            </tr>
            <tr>
                <td width="4%" align="right" nowrap title="<?= $Tve75_destino ?>">
                    <?= $Lve75_destino ?>
                </td>
                <td width="96%" align="left" nowrap>
                    <?
                    db_input('ve75_destino', 30, $Ive75_destino, true, 'text', $db_opcao, "", "chave_ve75_destino");
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
    <input name="limpar" type="reset" id="limpar" value="Limpar">
    <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_veiccaddestino.hide();">
</form>
<?
if (!isset($pesquisa_chave)) {
    if (isset($campos) == false) {
        if (file_exists("funcoes/db_func_veiccaddestino.php") == true) {
            include("funcoes/db_func_veiccaddestino.php");
        } else {
            $campos = "veiccaddestino.*";
        }
    }
    if (isset($chave_ve75_sequencial) && (trim($chave_ve75_sequencial) != "")) {
        $sql = $clveiccaddestino->sql_query($chave_ve75_sequencial, $campos, "ve75_sequencial");
    } else if (isset($chave_ve75_destino) && (trim($chave_ve75_destino) != "")) {
        $sql = $clveiccaddestino->sql_query("", $campos, "ve75_destino", " ve75_destino like '$chave_ve75_destino%' ");
    } else {
        $sql = $clveiccaddestino->sql_query("", $campos, "ve75_sequencial");
    }
    $repassa = array();
    if (isset($chave_ve75_destino)) {
        $repassa = array("chave_ve75_sequencial" => $chave_ve75_sequencial, "chave_ve75_destino" => $chave_ve75_destino);
    }

    if (isset($enviadescr)) {
        $clveiccaddestino->sql_record($sql);
        if ($clveiccaddestino->numrows > 0) {
            echo '<div class="container">';
            echo '  <fieldset>';
            echo '    <legend>Resultado da Pesquisa</legend>';
            db_lovrot($sql, 15, "()", "", $funcao_js, "", "NoMe", $repassa,false);
            echo '  </fieldset>';
            echo '</div>';
        } else {
            $zero = true;
        }
    } else {
        echo '<div class="container">';
        echo '  <fieldset>';
        echo '    <legend>Resultado da Pesquisa</legend>';
        db_lovrot($sql, 15, "()", "", $funcao_js, "", "NoMe", $repassa);
        echo '  </fieldset>';
        echo '</div>';
    }
} else {
    if ($pesquisa_chave != null && $pesquisa_chave != "") {
        $result = $clveiccaddestino->sql_record($clveiccaddestino->sql_query($pesquisa_chave));
        if ($clveiccaddestino->numrows != 0) {
            db_fieldsmemory($result, 0);
            echo "<script>" . $funcao_js . "('$ve75_sequencial','$ve75_destino',false);</script>";
        } else {
            echo "<script>" . $funcao_js . "('Chave(" . $pesquisa_chave . ") não Encontrado',true);</script>";
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
<script>

    <?
// CADASTRO DE DESTINO
// Quando o usuário for incluir um DESTINO, aparecerá a func_veiccaddestino.php para caso ele queira pegar dados de um destino já criado
if(isset($zero)){
  echo "parent.document.form1.ve75_destino.value = document.form2.chave_ve75_destino.value;";
  echo "parent.db_iframe_veiccaddestino.hide();";
}
?>

    js_tabulacaoforms("form2", "chave_ve75_destino", true, 1, "chave_ve75_destino", true);
</script>