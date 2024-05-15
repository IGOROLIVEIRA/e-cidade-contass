<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("dbforms/db_classesgenericas.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clrotulo = new rotulocampo;
$clrotulo->label("l20_codigo");
$clrotulo->label("l20_numero");
$clrotulo->label("l03_codigo");
$clrotulo->label("l03_descr");
$clrotulo->label("pc21_numcgm");
$clrotulo->label("ac16_sequencial");
$clrotulo->label("ac16_resumoobjeto");


?>
<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?
    db_app::load("scripts.js, strings.js, datagrid.widget.js, windowAux.widget.js");
    db_app::load("dbmessageBoard.widget.js, prototype.js, contratos.classe.js");
    db_app::load("estilos.css, grid.style.css");
    ?>
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script>
        function js_emite() {

            query = 'ac16_sequencial=' + document.form1.ac16_sequencial.value;
            query += '&situacao=' + document.form1.situacao.value + '&exercicio=' + document.form1.exercicio.value;

            let sFornecedores = '';

            if (document.form1.lQuebraFornecedor.value == 't' && document.form1.fornecedor.options.length) {
                vrg = '';

                for (let count = 0; count < document.form1.fornecedor.options.length; count++) {
                    sFornecedores += vrg + document.form1.fornecedor.options[count].value;
                    vrg = ',';
                }
            }


            query += '&cgms=' + sFornecedores;

            jan = window.open('sys4_geradorteladinamica002.php?' + query, '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
            jan.moveTo(0, 0);
        }
    </script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<style>
    #fornecedor {
        width: 336px;
    }

    #lQuebraFornecedor {
        width: 69px;
    }

    #status {
        width: 200px;
    }
</style>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
    <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
        <tr>
            <td width="360" height="18">&nbsp;</td>
            <td width="263">&nbsp;</td>
            <td width="25">&nbsp;</td>
            <td width="140">&nbsp;</td>
        </tr>
    </table>

    <div style="margin: 2% 29%;">
        <fieldset>
            <legend>Rol de Contratos </legend>
            <table align="center">
                <form name="form1" method="post" action="">
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>

                    <tr>
                        <td nowrap title="<?php echo $Tac16_sequencial; ?>" width="130">
                            <?php db_ancora($Lac16_sequencial, "js_acordo(true);", 1); ?>
                        </td>
                        <td colspan="2">
                            <?php
                            db_input('ac16_sequencial', 10, $Iac16_sequencial, true, 'text', 1, "onchange='js_acordo(false);'");
                            db_input('ac16_resumoobjeto', 40, $Iac16_resumoobjeto, true, 'text', 3);
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <b>Situação:</b>
                        </td>
                        <td>
                            <?php
                            $aSituacao = array(
                                0 => 'Selecione', 1 => 'Ativo', 2 => 'Rescindido', 3 => 'Cancelado', 4 => 'Homologado', 5 => 'Paralisado'
                            );
                            db_select("situacao", $aSituacao, true, 2, " ", "", "", "0", "");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Exercício:</b>
                        </td>
                        <td>
                            <?php
                            db_input("exercicio", 10, $exercicio, true, "text", 1, 'onkeyup="js_validaCaracteres(this);onchange=js_limitaExercicio(this);"');
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <b>Filtrar por fornecedor:</b>
                        </td>
                        <td>
                            <select name="lQuebraFornecedor" id="lQuebraFornecedor" style="width: 94px;">
                                <option value="f" selected>NÃO</option>
                                <option value="t">SIM</option>
                            </select>
                        </td>
                    </tr>

                    <tr id='area_fornecedor' class='tr__cgm'>
                        <td colspan="2">
                            <fieldset>
                                <legend>Fornecedores</legend>
                                <table align="center" border="0">
                                    <tr>
                                        <td>
                                            <?php db_ancora('CGM', "js_pesquisa_fornelicitacao(true);", 1); ?>
                                        </td>
                                        <td>
                                            <?php
                                            db_input('z01_numcgm', 6, '', true, 'text', 4, " onchange='js_pesquisa_fornelicitacao(false);'", "");
                                            db_input('z01_nome', 25, '', true, 'text', 3, "", "");
                                            ?>
                                            <input type="button" value="Lançar" id="btn-lancar-fornecedor" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <select name="fornecedor[]" id="fornecedor" size="5" multiple></select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" colspan="2">
                                            <strong>Dois Cliques sobre o fornecedor o exclui.</strong>
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input name="emite2" id="emite2" type="button" value="Gerar Relatório" onclick="js_emite();">
                        </td>
                    </tr>

                </form>
            </table>
        </fieldset>
    </div>
    <?
    db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
    ?>
</body>

</html>
<script>
    document.getElementsByClassName('tr__cgm')[0].style.display = 'none';

    if (document.getElementById('lQuebraFornecedor').value = 'f') {
        document.getElementById('area_fornecedor').style.display = 'none';
    }

    function js_acordo(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('', 'db_iframe_acordo',
                'func_acordoinstit.php?funcao_js=parent.js_mostraAcordo1|ac16_sequencial|z01_nome',
                'Pesquisa', true);
        } else {
            if ($F('ac16_sequencial').trim() != '') {
                js_OpenJanelaIframe('', 'db_iframe_depart',
                    'func_acordoinstit.php?pesquisa_chave=' + $F('ac16_sequencial') + '&funcao_js=parent.js_mostraAcordo' +
                    '&descricao=true',
                    'Pesquisa', false);
            } else {
                $('ac16_resumoobjeto').value = '';
            }
        }
    }

    function js_mostraAcordo(chave, descricao, erro) {

        $('ac16_resumoobjeto').value = descricao;
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


    function js_pesquisa_fornelicitacao(mostra) {
        if (mostra) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_fornelicitacao', 'func_fornelicitacao.php?&funcao_js=parent.js_mostrafornelicitacao|z01_numcgm|z01_nome', 'Pesquisa', true);
        } else {
            if (document.form1.z01_numcgm.value != '') {
                js_OpenJanelaIframe('', 'db_iframe_fornelicitacao', 'func_fornelicitacao.php?pesquisa_chave=' + document.form1.z01_numcgm.value + '&funcao_js=parent.js_mostrafornelicitacao1', 'Pesquisa', false);
            } else {
                document.form1.z01_numcgm.value = '';
                document.form1.z01_nome.value = '';
            }
        }
    }

    function js_mostrafornelicitacao1(chave, erro) {

        if (erro) {
            document.form1.z01_numcgm.focus();
            document.form1.z01_numcgm.value = '';
            return;
        }

        document.getElementById('z01_nome').value = chave;
    }

    function js_mostrafornelicitacao(chave1, chave2) {
        document.form1.z01_numcgm.value = chave1;
        document.form1.z01_nome.value = chave2;
        db_iframe_fornelicitacao.hide();
    }

    document.getElementById('btn-lancar-fornecedor').addEventListener('click', (e) => {
        addOption(document.form1.z01_numcgm.value, document.form1.z01_nome.value);
    });

    function addOption(codigo, descricao) {

        if (!codigo || !descricao) {
            alert('Fornecedor inválido!');
            limparCampos();
            return;
        }

        let aOptions = document.getElementById("fornecedor");
        let jaTem = Array.prototype.filter.call(aOptions.children, (o) => {
            return o.value == codigo;
        });


        if (jaTem.length > 0) {
            alert("Fornecedor já inserido.");
            limparCampos();
            return;
        }

        let option = document.createElement('option');
        option.value = codigo;
        option.innerHTML = codigo + ' - ' + descricao;
        aOptions.appendChild(option);

        limparCampos();

    }

    document.getElementById('fornecedor').addEventListener('dblclick', (e) => {
        document.getElementById('fornecedor').removeChild(e.target);
    });

    function limparCampos() {
        document.form1.z01_numcgm.value = '';
        document.form1.z01_nome.value = '';
    }

    document.getElementById('lQuebraFornecedor').addEventListener('change', e => {
        let oElemento = document.getElementsByClassName('tr__cgm')[0];

        oElemento.style.display = e.target.value == 't' ? '' : 'none';

        let fornecedor = document.getElementById('fornecedor');
        if (fornecedor.options.length) {
            for (let count = 0; count < fornecedor.options.length; count++) {
                fornecedor.removeChild(fornecedor.childNodes[count]);
            }
        }

    });

    function js_validaCaracteres(objeto) {
        js_ValidaCamposText(objeto, 1);

        if (/[^0-9]/.test(objeto.value)) {
            objeto.value = '';
        }
    }

    function js_limitaExercicio(objeto) {
        if (objeto.value.length > 4) {
            alert('Este campo deve conter apenas 4 caracteres');
            objeto.value = objeto.value.substr(0, 4);
        }
    }
</script>
