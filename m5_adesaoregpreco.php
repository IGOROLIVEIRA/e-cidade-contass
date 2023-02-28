<html>
<?php
require_once 'libs/db_stdlib.php';
require_once 'libs/db_conecta.php';
require_once 'libs/db_sessoes.php';
require_once 'libs/db_usuariosonline.php';
require_once 'libs/db_utils.php';
require_once 'dbforms/db_funcoes.php';
require_once 'dbforms/db_funcoes.php';
include("classes/db_adesaoregprecos_classe.php");
?>
<?php
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_POST_VARS);

$cladesaoregprecos = new cl_adesaoregprecos();

if (isset($alterar)) {
    $cladesaoregprecos->si06_sequencial  = $e54_adesaoregpreco;
    $cladesaoregprecos->si06_codunidadesubant = $si06_codunidadesubant;
    $cladesaoregprecos->alterar($e54_adesaoregpreco);

    if ($cladesaoregprecos->erro_status == '0') {
        db_msgbox($cladesaoregprecos->erro_msg);
        $sqlerro = true;
    } else {
        db_msgbox("Alteração Realizada com Sucesso !");
        db_redireciona("m5_adesaoregpreco.php");
    }
}
?>

<head>
    <title>Contass Contabilidade Ltda - P&aacute;gina Inicial</title>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <style>
    </style>
</head>

<body bgcolor="#CCCCCC">
    <center>
        <form name='form1' method="post" action="">
            <fieldset style="width: 600px; margin-top: 30px">
                <legend>Adesão de Registro de Preços:</legend>
                <table>
                    <tr>
                        <td>
                            <?=
                            db_ancora("Adesão de Registro Preço:", "js_pesquisaaadesaoregpreco(true)", $db_opcao);
                            ?>
                        </td>
                        <td>
                            <?
                            db_input('e54_adesaoregpreco', 10, "", true, 'text', 3, "onchange='js_pesquisaaadesaoregpreco(false)';");
                            db_input('si06_objetoadesao', 40, "", true, 'text', 3);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Codunidadeanterior:</b>
                        </td>
                        <td>
                            <?
                            db_input('si06_codunidadesubant', 10, "", true, 'text', $db_opcao, "");
                            ?>
                        </td>
                    </tr>
                </table>
                <?
                db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
                ?>
            </fieldset>
            <input name="alterar" type="submit" id="alterar" value="Alterar">
        </form>
    </center>

</body>
<script>
    function js_pesquisaaadesaoregpreco(mostra) {
        if (mostra == true) {
            var sUrl = 'func_adesaoregprecos.php?funcao_js=parent.js_buscaadesaoregpreco|si06_sequencial|si06_objetoadesao|si06_codunidadesubant';
            js_OpenJanelaIframe('', 'db_iframe_adesaoregprecos', sUrl, 'Pesquisar', true, '0');
        } else {
            if (document.form1.e54_adesaoregpreco.value != '') {
                js_OpenJanelaIframe('', 'db_iframe_adesaoregprecos', 'func_adesaoregprecos.php?par=true&pesquisa_chave=' + document.form1.e54_adesaoregpreco.value + '&funcao_js=parent.js_mostraradesao',
                    'Pesquisar', false, '0');
            } else {
                document.getElementById('si06_objetoadesao').value = '';
            }
        }
    }

    /**
     * funcao para carregar adesao de registro de preco escolhida no campo
     * */
    function js_buscaadesaoregpreco(sequencial, objeto, si06_codunidadesubant) {
        console.log(si06_codunidadesubant);
        document.form1.e54_adesaoregpreco.value = sequencial;
        document.form1.si06_objetoadesao.value = objeto;
        document.form1.si06_codunidadesubant.value = si06_codunidadesubant;
        db_iframe_adesaoregprecos.hide();
    }

    function js_mostraradesao(objeto, processo, modalidade, ano, erro) {
        document.form1.si06_objetoadesao.value = objeto;
        if (erro == true) {
            document.form1.si06_objetoadesao.focus();
        }
    }
</script>