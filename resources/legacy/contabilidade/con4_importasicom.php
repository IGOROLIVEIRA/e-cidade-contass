<?php
/**
 *
 * @author I
 * @revision $Author: marcelo
 */
require("libs/db_stdlib.php");
require("libs/db_utils.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript"
            src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript"
            src="scripts/strings.js"></script>
    <script language="JavaScript" type="text/javascript"
            src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript"
            src="scripts/widgets/dbmessageBoard.widget.js"></script>
    <script language="JavaScript" type="text/javascript"
            src="scripts/micoxUpload.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#cccccc" style="margin-top: 25px;">
<center>


    <div style="display: table">
        <fieldset>
            <legend>
                <b>Importar - Sicom mensal</b>
            </legend>
            <table style='empty-cells: show; border-collapse: collapse;'>

                <tr>
                    <td colspan="3">
                        <div id='dadospca'>

                            <fieldset>
                                <legend>
                                    <b>Enviar Arquivo</b>
                                </legend>
                                <table>

                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Arquivo Sicom:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="file" name="SICOM"/>

                                                <div id="SICOM" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivossicom.php','SICOM','Carregando...','Erro ao carregar')"/>

                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>


                                </table>
                            </fieldset>

                        </div>
                    </td>

                    <td colspan=3>


                        <fieldset>
                            <legend>
                                <b>Arquivos Importados</b>
                            </legend>
                            <div id='retorno'
                                 style="width: 200px; height: 282px; overflow: scroll;">
                            </div>
                        </fieldset>

                    </td>
                </tr>
            </table>
        </fieldset>
        <div style="text-align: center;">
            <input type="button" id="btnProcessar" value="Importar"
                   onclick="js_processar();"/>
            <input type="button" id="btnProcessar" value="Criar CTB Fonte"
                   onclick="js_importarsicom();"/>
        </div>
    </div>


</center>
</body>
</html>
<? db_menu(db_getsession("DB_id_usuario"),
    db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit")); ?>
<script type="text/javascript">
    function js_processar() {

        var aArquivosSelecionados = new Array();
        var aArquivos = $$("input[type='file']");
        /*
         * iterando sobre o array de arquivos com uma função anônima para pegar os arquivos selecionados pelo usuário
         */
        aArquivos.each(function (oElemento, iIndice) {

            aArquivosSelecionados.push(oElemento.name);

        });

        js_divCarregando('Aguarde, processando arquivos', 'msgBox');
        var oParam = new Object();
        oParam.arquivos = aArquivosSelecionados;
        oParam.exec = 'importaSicom';
        var oAjax = new Ajax.Request("con4_importarsicom.RPC.php",
            {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_retornoProcessamento
            }
        );

    }

    function js_retornoProcessamento(oAjax) {
        js_removeObj('msgBox');

        //$('debug').innerHTML = oAjax.responseText;
        var oRetorno = eval("(" + oAjax.responseText + ")");

        if (oRetorno.status == 1) {

            alert("Processo concluído com sucesso!");
            var sRetorno = "<b>Arquivos Gerados:</b><br>";
            for (var i = 0; i < oRetorno.itens.length; i++) {

                with (oRetorno.itens[i]) {

                    sRetorno += oRetorno.itens[i] + "</a><br>";
                }
            }

            $('retorno').innerHTML = sRetorno;
        } else {
            $('retorno').innerHTML = '';
            alert(oRetorno.message.urlDecode());
            return false;
        }
    }

    function js_importarsicom() {
        var oParam = new Object();
        oParam.exec = 'importarCTBFONTE';
        if (confirm("A geração do CTB SALDO Por Fonte ira aparagar todos os valores já lançados anteriormente. Tem certeza que deseja executar agora?")) {
            js_divCarregando('Aguarde, importando saldo das contas do arquivo CTB', 'msgBox');
            var oAjax = new Ajax.Request("con1_importarctbfonte.RPC.php",
                {
                    method: 'post',
                    parameters: 'json=' + Object.toJSON(oParam),
                    onComplete: js_importarsicomRetorno
                }
            );
        }

    }

    function js_importarsicomRetorno(oAjax) {
        js_removeObj('msgBox');

        var oRetorno = eval("("+oAjax.responseText+")");

        if(oRetorno.status == 2){
            alert(oRetorno.message.urlDecode());
        }else{
            alert("Processo concluído com sucesso!");
        }
        var sContaReduz = "<hr>";

        for (var c = 0; c < oRetorno.naoCadastradas.length; c++) {
            sContaReduz += "<h3>"+oRetorno.naoCadastradas[c]+"</h3><br>";
        }

        $('debug').innerHTML = sContaReduz;
    }

</script>
<div id='debug'>
</div>
