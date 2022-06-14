<?php

require_once("libs/db_stdlib.php");
require_once("libs/db_stdlibwebseller.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("dbforms/db_funcoes.php");
require_once("std/db_stdClass.php");

$clrotulo = new rotulocampo;
$clrotulo->label("ac16_sequencial");
$clrotulo->label("ac16_resumoobjeto");

$oGet = db_utils::postMemory($_GET);

$oDepartamento = new DBDepartamento(db_getsession("DB_coddepto"));
$iDepartamento = $oDepartamento->getCodigo();
$sDepartamento = $oDepartamento->getNomeDepartamento();

?>

<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?php
    // Includes padrão
    db_app::load("scripts.js, prototype.js, strings.js, datagrid.widget.js, webseller.js");
    db_app::load("estilos.css, grid.style.css");
    ?>
</head>

<script>
    function js_geraRelatorio() {

        var imprimir = document.getElementById("tipoImprimir").value;
        var sequencial = document.getElementById("ac16_sequencial").value;

        if (imprimir == 1) {
            jan = window.open('aco2_extratodecontrato002.php?&sequencial=' + sequencial,
                'width=' + (screen.availWidth - 5) + ', height=' + (screen.availHeight - 40) + ', scrollbars=1, location=0');
            jan.moveTo(0, 0);
            return true;
        }

        if (imprimir == 2) {
            jan = window.open('aco2_extratodecontrato003.php?&sequencial=' + sequencial,
                'width=' + (screen.availWidth - 5) + ', height=' + (screen.availHeight - 40) + ', scrollbars=1, location=0');
            jan.moveTo(0, 0);
            return true;
        }
    }
</script>

<body bgcolor="#cccccc" style='margin-top: 30px'>
    <center>
        <div id='divContainer' style="width: 500px;">
            <form name="form1" method="post" action="">
                <fieldset>
                    <legend>Extrato de Contrato (Novo)</legend>
                    <table>
                        <tr>
                            <td nowrap title="<?php echo $Tac16_sequencial; ?>" width="130" id='ctnAnconra'>
                                <?php db_ancora($Lac16_sequencial, "js_acordo(true);", 1); ?>
                            </td>
                            <td nowrap="nowrap" colspan="2">
                                <?php
                                db_input('ac16_sequencial', 10, $Iac16_sequencial, true, 'text', 1, "onchange='js_acordo(false);'");
                                db_input('ac16_resumoobjeto', 40, $Iac16_resumoobjeto, true, 'text', 3);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <b>
                                    Imprimir:
                                </b>
                            </td>
                            <td align="left" nowrap>
                                <?
                                $aValores = array(

                                    1 => 'PDF',
                                    2 => 'WORD',
                                );
                                db_select('tipoImprimir', $aValores, true, $db_opcao, "");
                                ?>

                            </td>

                        </tr>
                    </table>
                </fieldset>
                <br>
                <input type='submit' value='Gerar Relatório' onclick="js_geraRelatorio();">
            </form>
        </div>
    </center>
    <?
    if (!isset($oGet->iContrato)) {
        db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
    } ?>

</body>

</html>
<script type="text/javascript">
    var sRPC = "aco4_acordo.RPC.php";
    var oGet = js_urlToObject();

    function js_acordo(mostra) {

        if (mostra == true) {
            js_OpenJanelaIframe('', 'db_iframe_acordo',
                'func_acordo.php?lDepartamento=1&funcao_js=parent.js_mostraAcordo1|ac16_sequencial|ac16_resumoobjeto',
                'Pesquisa', true, 0);
        } else {
            if ($F('ac16_sequencial').trim() != '') {
                js_OpenJanelaIframe('', 'db_iframe_depart',
                    'func_acordo.php?lDepartamento=1&pesquisa_chave=' + $F('ac16_sequencial') + '&funcao_js=parent.js_mostraAcordo' +
                    '&descricao=true',
                    'Pesquisa', false, 0);
            } else {
                $('ac16_resumoobjeto').value = '';
            }
        }
    }

    function js_mostraAcordo(chave, erro) {

        $('ac16_resumoobjeto').value = erro
        if (erro == true) {

            $('ac16_sequencial').focus();
            $('ac16_sequencial').value = '';
        }
    }

    function js_mostraAcordo1(chave1, chave2) {
        $('ac16_sequencial').value = chave1;
        $('ac16_resumoobjeto').value = chave2;
        db_iframe_acordo.hide();
    }
</script>