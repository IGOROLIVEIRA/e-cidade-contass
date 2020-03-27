<?php
/**
 *
 * @author Victor Felipe
 */

require("libs/db_stdlib.php");
require("libs/db_utils.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

$clrotulo = new rotulocampo;
$clrotulo->label("o124_descricao");
$clrotulo->label("o124_sequencial");
$clrotulo->label("o15_descr");
$clrotulo->label("o15_codigo");
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbmessageBoard.widget.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<style>
    #tbl_referencia {
        width: 100%;
    }

</style>
<body bgcolor="#cccccc" style="margin-top: 25px;">
<center>


    <form name="form1" method="post" action="">
        <div style="display: table">
            <fieldset>
                <legend>
                    <b>Editais</b>
                </legend>
                <table style='empty-cells: show; border-collapse: collapse;'>
                    <tr>
                        <td colspan="4">
                            <fieldset>
                                <table id="tbl_referencia">
                                    <tr>
                                        <td>
                                            <b>Dia Referência:</b>
											<? db_inputdata('diaReferencia', '', '', '', true, 'text', 1, ""); ?>
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">Dados Mensais</td>
                        <td>Arquivos Gerados</td>
                    </tr>
                    <tr>
                        <td style="border: 2px groove white;" valign="top">
                            <input type="checkbox" value="IdentificacaoRemessa" id="IdenficacaoRemessa"/>
                            <label for="IdenficacaoRemessa">IDE - Identificação da Remessa</label><br>
                            <input type="checkbox" value="ResumoAberturaLicitacao" id="Ralic"/>
                            <label for="Ralic">RALIC - Resumo de Abertura da Licitação</label><br>
                            <input type="checkbox" value="ResumoDispensaInexigibilidade" id="Redispi"/>
                            <label for="Redispi">REDISPI - Resumo da Dispensa ou Inexigibilidade</label><br>
                        </td>
                        <td style="border: 2px groove white;" valign="top">


                        </td>

                        <td style="border: 2px groove white;" valign="top">
                            <div id='retorno'
                                 style="width: 200px; height: 250px; overflow: scroll;">
                            </div>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <div style="text-align: center;">
                <input type="button" id="btnMarcarTodos" value="Marcar Todos" onclick="js_marcaTodos();"/>
                <input type="button" id="btnLimparTodos" value="Limpar Todos" onclick="js_limpa();"/>
                <input type="button" id="btnProcessar" value="Processar"
                       onclick="js_processar();"/>
            </div>
        </div>
    </form>

</center>
</body>
</html>
<? db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit")); ?>
<script type="text/javascript">

    function js_processar() {

        var aArquivosSelecionados = new Array();
        var aArquivos = $$("input[type='checkbox']");
        var iDiaReferencia = $("diaReferencia").value;

        if (!iDiaReferencia) {
            alert('Informe o dia de Referência');
            return false;
        }

        /*
		 * iterando sobre o array de arquivos com uma função anônima para pegar os arquivos selecionados pelo usuário
		 */
        aArquivos.each(function (oElemento, iIndice) {

            if (oElemento.checked) {
                aArquivosSelecionados.push(oElemento.value);
            }
        });
        if (aArquivosSelecionados.length == 0) {

            alert("Nenhum arquivo foi selecionado para ser gerado");
            return false;
        }
        js_divCarregando('Aguarde, processando arquivos', 'msgBox');
        var oParam = new Object();
        oParam.exec = "processarEditais";
        oParam.arquivos = aArquivosSelecionados;
        oParam.diaReferencia = iDiaReferencia;
        var oAjax = new Ajax.Request("con4_processarpad.RPC.php",
            {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_retornoProcessamento
            }
        );

    }

    function js_retornoProcessamento(oAjax) {

        js_removeObj('msgBox');
        // $('debug').innerHTML = oAjax.responseText;
        var oRetorno = eval("(" + oAjax.responseText + ")");
        if (oRetorno.status == 1) {
            if(oRetorno.erro){
                $('retorno').innerHTML = '';
                alert(oRetorno.erro.urlDecode());
            }else{
                alert("Processo concluído com sucesso!");
                var sRetorno = "<b>Arquivos Gerados:</b><br>";
                for (var i = 0; i < oRetorno.itens.length; i++) {

                    with (oRetorno.itens[i]) {

                        sRetorno += "<a  href='db_download.php?arquivo=" + caminho + "'>" + nome + "</a><br>";
                    }
                }

                $('retorno').innerHTML = sRetorno;
            }
        } else {

            $('retorno').innerHTML = '';
            alert("Houve um erro no processamento!" + oRetorno.message.urlDecode());
            return false;
        }
    }

    function js_marcaTodos() {

        var aCheckboxes = $$('input[type=checkbox]');
        aCheckboxes.each(function (oCheckbox) {
            oCheckbox.checked = true;
        });
    }

    function js_limpa() {

        var aCheckboxes = $$('input[type=checkbox]');
        aCheckboxes.each(function (oCheckbox) {
            oCheckbox.checked = false;
        });
    }

</script>
<div id='debug'>
</div>
