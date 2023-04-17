<?php
/**
 *
 * @author I
 * @revision $Author: dbrobson $
 * @version $Revision: 1.10 $
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

    <form name="form1" method="post" action="" enctype='multipart/form-data'>
        <div style="display: table">
            <fieldset>
                <legend>
                    <b>Gerar SICOM - Legislaçao de carater financeiro</b>
                </legend>
                <table style='empty-cells: show; border-collapse: collapse;'>
                    <tr>
                        <td colspan="4">
                            <fieldset>
                                <table>
                                    <tr>
                                        <td>Mês Referência: </td>
                                        <td>
                                            <select id="MesReferencia" class="MesReferencia" >
                                                <option value="00">SELECIONE</option>
                                                <option value="01">Janeiro</option>
                                                <option value="02">Fevereiro</option>
                                                <option value="03">Março</option>
                                                <option value="04">Abril</option>
                                                <option value="05">Maio</option>
                                                <option value="06">Junho</option>
                                                <option value="07">Julho</option>
                                                <option value="08">Agosto</option>
                                                <option value="09">Setembro</option>
                                                <option value="10">Outubro</option>
                                                <option value="11">Novembro</option>
                                                <option value="12">Dezembro</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">

                        </td>
                    </tr>
                    <tr>
                        <td>Selecionar Arquivos de Leis</td>
                        <td>Arquivo Gerado</td>
                    </tr>
                    <tr>
                        <td>
                            <div id='dadosppa'>
                                <form name="form1" id='form1' method="post" action="" enctype="multipart/form-data">

                                        <table>
                                            <tr>
                                                <td>
                                                    Lei LAO:
                                                    <div>&nbsp;</div>
                                                </td>
                                                <td>
                                                    <input type="file" name="LAO" />
                                                    <div id="recebe_up_lao" class="recebe">&nbsp;</div>
                                                </td>
                                                <td>
                                                    <input type="button" value="Enviar" onclick="micoxUpload(this.form,'upload_leis_lcf.php?nome_campo=LAO&ano_usu=<?=db_getsession("DB_anousu") ?>','recebe_up_lao','Carregando...','Erro ao carregar')" />
                                                    <div>&nbsp;</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Lei LAOP:
                                                    <div>&nbsp;</div>
                                                </td>
                                                <td>
                                                    <input type="file" name="LAOP" />
                                                    <div id="recebe_up_laop" class="recebe">&nbsp;</div>

                                                </td>
                                                <td>
                                                    <input type="button" value="Enviar" onclick="micoxUpload(this.form,'upload_leis_lcf.php?nome_campo=LAOP&ano_usu=<?=db_getsession("DB_anousu") ?>','recebe_up_laop','Carregando...','Erro ao carregar')" />
                                                    <div>&nbsp;</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top">
                                                    <input type="checkbox" value="DEC" id="DEC" />
                                                    <label for="DEC">Decretos</label><br>

                                                </td>
                                            </tr>
                                        </table>

                                </form>
                            </div>
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
                <input type="button" id="btnProcessar" value="Processar"
                       onclick="js_processar();" />
            </div>
        </div>
    </form>

</center>
</body>
</html>
<? db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit")); ?>
<script type="text/javascript">
    function js_processar() {

        var aArquivosSelecionados = new Array();
        var aArquivos             = $$("input[type='checkbox']");
        var iMesReferencia        = $("MesReferencia");

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

        if (iMesReferencia.value == 0) {

            alert("Selecione um Mês Referência para geração do(s) arquivo(s)!");
            return false;
        }

        js_divCarregando('Aguarde, processando arquivos','msgBox');
        var oParam           = new Object();
        oParam.exec          = "processarLCF";
        oParam.arquivos      = aArquivosSelecionados;
        oParam.mesReferencia = iMesReferencia.value;
        var oAjax = new Ajax.Request("con4_processarpad.RPC.php",
            {
                method:'post',
                parameters:'json='+Object.toJSON(oParam),
                onComplete:js_retornoProcessamento
            }
        );

    }

    function js_retornoProcessamento(oAjax) {

        js_removeObj('msgBox');
        $('debug').innerHTML = oAjax.responseText;
        var oRetorno = eval("("+oAjax.responseText+")");
        if (oRetorno.status == 1) {

            alert("Processo concluído com sucesso!");
            var sRetorno = "<b>Arquivos Gerados:</b><br>";
            for (var i = 0; i < oRetorno.itens.length; i++) {

                with (oRetorno.itens[i]) {

                    sRetorno += "<a target='_blank' href='db_download.php?arquivo="+caminho+"'>"+nome+"</a><br>";
                }
            }

            $('retorno').innerHTML = sRetorno;
        }else if (oRetorno.status == 3){
            alert("Não há decretos a serem gerados no período informado!");
            var sRetorno = "<b>Arquivos Gerados:</b><br>";
            for (var i = 0; i < oRetorno.itens.length; i++) {

                with (oRetorno.itens[i]) {

                    sRetorno += "<a  href='db_download.php?arquivo="+caminho+"'>"+nome+"</a><br>";
                }
            }

            $('retorno').innerHTML = sRetorno;
        } 
        else {

            $('retorno').innerHTML = '';
            alert("Houve um erro no processamento!" + oRetorno.message.urlDecode());
            //alert(oRetorno.message.urlDecode());
            return false;
        }
    }



</script>
<div id='debug'>
</div>
