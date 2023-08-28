<?php

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");

db_postmemory($HTTP_POST_VARS);
?>
<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <link href="estilos.css" rel="stylesheet" type="text/css">

    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbmessageBoard.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/micoxUpload.js"></script>

</head>
<body>
    <center>
    <form name="form1" method="post" action="" enctype="multipart/form-data">
            <fieldset style="margin-top: 50px; width: 800px;">
                <legend><strong>Importar Julgamento</strong></legend>
                    <table align="left" border='0'>
                        <tr>
                            <td align="left" nowrap title="<?= $Tl20_codigo ?>">
                                <b>
                                    <?php
                                    db_ancora('Licitação :', "js_pesquisa_liclicita(true);", 1);
                                    ?>
                                </b>
                            </td>
                            <td>
                                <?php
                                    db_input("l20_codigo", 8, $Il20_codigo, true, "text", 1, "onchange='js_pesquisa_liclicita(false);'","","#FFF","width:80px");
                                ?>
                                <b>
                                    Modalidade:
                                </b>
                                <?php
                                db_input("l03_descr", 8, $Il03_descr, true, "text", 3,"","","","width: 300px;");
                                ?>
                                <b>
                                    N°:
                                </b>
                                <?php
                                db_input("l20_numero", 8, $Il20_numero, true, "text", 3,"","","","width: 100px;");
                                ?>
                            </td>

                            <td align="left" nowrap title="<?= $Tl20_codigo ?>">


                            </td>
                            <td align="left" nowrap>

                            </td>
                        </tr>
                        <tr>
                            <td >
                                <strong>Objeto: </strong>

                            </td>
                            <td colspan="2">
                                <?php
                                    $pc67_motivo = "";
                                    db_textarea("l20_objeto",10,100,"",true,"text",3,"","","#DEB887","");
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <input disabled="true" name="btn_processar" id="btn_processar" type="button" value="Processar" onclick="js_processa_julgamento()">
                            </td>
                        </tr>
                    </table>
            </fieldset>
        </form>
    </center>

    <script>
        function js_pesquisa_liclicita(mostra) {
            if (mostra == true) {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_liclicita', 'func_liclicita.php?funcao_js=parent.js_mostraliclicita1|l20_codigo', 'Pesquisa', true);
            } else {
                if (document.form1.l20_codigo.value != '') {
                    js_OpenJanelaIframe('top.corpo', 'db_iframe_liclicita', 'func_liclicita.php?pesquisa_chave=' + document.form1.l20_codigo.value + '&funcao_js=parent.js_mostraliclicita', 'Pesquisa', false);
                } else {
                    document.form1.l20_codigo.value = '';
                }
            }
        }

        function js_mostraliclicita(_, erro) {
            if (erro == true) {
                document.form1.l20_codigo.value = '';
                document.form1.l20_codigo.focus();
                return;
            }
            codigo = document.form1.l20_codigo.value;
            js_divCarregando('carregando.', 'msgbox');
            js_busca_dados_liclicita(codigo,"BuscarDados","js_retornobuscarlicitacao");
        }

        function js_mostraliclicita1(chave1) {
            db_iframe_liclicita.hide();
            js_divCarregando('carregando.', 'msgbox');
            js_busca_dados_liclicita(chave1,"BuscarDados","js_retornobuscarlicitacao");
        }

        function js_processa_julgamento() {
            codigo = document.form1.l20_codigo.value;
            js_divCarregando('carregando. Esse processo por demorar alguns minutos', 'msgbox');
            js_busca_dados_liclicita(codigo,"ProcessaJulgamento","js_retornoimportarjulgamento");
        }

        function js_busca_dados_liclicita(codigo, opcao, funcaoRetorno) {
            var sUrl = 'lic1_importajulgamento.RPC.php';
            var oParam = new Object();
            oParam.codigo = codigo;
            oParam.exec = opcao;
            const parametros = {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: window[funcaoRetorno]
            };

            var oAjax = new Ajax.Request(sUrl, parametros);
        }

        function js_retornobuscarlicitacao(oAjax) {
            js_removeObj('msgbox');
            let oRetorno = eval("(" + oAjax.responseText + ")");

            const numero = oRetorno.message.numero;
            if (oRetorno.message.situacao != 0) {
                return alert(`
                O processo ${numero} deve estar com a situação "Em Andamento" para poder ser importado
                `)
            }

            document.form1.l20_codigo.value = oRetorno.message.id;
            document.form1.l03_descr.value = oRetorno.message.modalidade;
            document.form1.l20_objeto.value = oRetorno.message.objeto;
            document.form1.l20_numero.value = oRetorno.message.numero;
            document.form1.btn_processar.disabled = false;
        }

        function js_retornoimportarjulgamento(oAjax) {
            js_removeObj('msgbox');

            let oRetorno = eval("(" + oAjax.responseText + ")");

            alert(oRetorno.message);
            document.form1.l20_codigo.value = "";
            document.form1.l03_descr.value = "";
            document.form1.l20_objeto.value = "";
            document.form1.l20_numero.value = "";
            document.form1.btn_processar.disabled = true;
        }
    </script>
</body>