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
                <b>Documentos DCASP Isolado</b>
            </legend>
            <table style='empty-cells: show; border-collapse: collapse;'>

                <tr>
                    <td colspan="3">
                        <div id='dadospca'>

                            <fieldset>
                                <legend>
                                    <b>Enviar Arquivos</b>
                                </legend>


                                <table id="isolado">

                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Notas explicativas às demonstrações contábeis:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="isolado" type="file" name="NE"/>
                                                <div id="NE" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','NE','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>
                                    <?php
                                    $oInstit = new Instituicao(db_getsession('DB_instit'));
//                                    echo Instituicao::TIPO_INSTIT_PREFEITURA;
//                                    echo $oInstit->getTipoInstit();
                                    if ($oInstit->getTipoInstit() == 5) { ?>
                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Demonstrativo de Resultado da Avaliação Atuarial:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="isolado" type="file" name="DRAA"/>
                                                <div id="DRAA" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','DRAA','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>
                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Nota Técnica Atuarial Plano Financeiro:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="isolado" type="file" name="NTA_PLANO_FINANCEIRO"/>
                                                <div id="NTA_PLANO_FINANCEIRO" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','NTA_PLANO_FINANCEIRO','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>
                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Nota Técnica Atuarial Plano Previdenciário:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="isolado" type="file" name="NTA_PLANO_PREVIDENCIARIO"/>
                                                <div id="NTA_PLANO_PREVIDENCIARIO" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','NTA_PLANO_PREVIDENCIARIO','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>
                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Fluxo Atuarial Atual Plano Financeiro:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="isolado" type="file" name="FAA_PLANO_FINANCEIRO"/>
                                                <div id="FAA_PLANO_FINANCEIRO" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','FAA_PLANO_FINANCEIRO','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>
                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Fluxo Atuarial Atual Plano Previdenciário:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="isolado" type="file" name="FAA_PLANO_PREVIDENCIARIO"/>
                                                <div id="FAA_PLANO_PREVIDENCIARIO" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','FAA_PLANO_PREVIDENCIARIO','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>
                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Fluxo Atuarial Futura Plano Previdenciário:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="isolado" type="file" name="FAF_PLANO_PREVIDENCIARIO"/>
                                                <div id="FAF_PLANO_PREVIDENCIARIO" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','FAF_PLANO_PREVIDENCIARIO','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>
                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Base cadastral utilizada na avaliação atuarial:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="isolado" type="file" name="BASE_CADAS_AVA_ATUARIAL"/>
                                                <div id="BASE_CADAS_AVA_ATUARIAL" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','BASE_CADAS_AVA_ATUARIAL','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>
                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Relatório da Avaliação Atuarial Plano Financeiro:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="isolado" type="file" name="RELA_AVA_ATUA_PLANO_FINANCEIRO"/>
                                                <div id="RELA_AVA_ATUA_PLANO_FINANCEIRO" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','RELA_AVA_ATUA_PLANO_FINANCEIRO','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>
                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Relatório da Avaliação Atuarial Plano Previdenciário:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="isolado" type="file" name="RELA_AVA_ATUA_PLANO_PREVIDENCIARIO"/>
                                                <div id="RELA_AVA_ATUA_PLANO_PREVIDENCIARIO" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','RELA_AVA_ATUA_PLANO_PREVIDENCIARIO','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>
                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Demonstrativo de Viabilidade do Plano de Custeio:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="isolado" type="file" name="DVP_CUSTEIO"/>
                                                <div id="DVP_CUSTEIO" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','DVP_CUSTEIO','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>
                                    <?php } ?>
                                </table>
                            </fieldset>

                        </div>
                    </td>

                    <td colspan=3>


                        <fieldset>
                            <legend>
                                <b>Arquivos Gerados</b>
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
            <input type="button" id="btnProcessar" value="Processar"
                   onclick="js_processar();"/>
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
        var tipoGeracao = 'ISOLADO';
        var aArquivos = $$(".isolado");

//    var aArquivos             = $$("input[type='file']");

        aArquivos.each(function (oElemento, iIndice) {
            aArquivosSelecionados.push(oElemento.name);
        });

        //
        js_divCarregando('Aguarde, processando arquivos', 'msgBox');
        var oParam = new Object();
        oParam.exec = "processarPCA";
        oParam.arquivos = aArquivosSelecionados;
        oParam.tipoGeracao = tipoGeracao;
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
        //$('debug').innerHTML = oAjax.responseText;
        var oRetorno = eval("(" + oAjax.responseText + ")");
        if (oRetorno.status == 1) {

            alert("Processo concluído com sucesso!");
            var sRetorno = "<br>";
            for (var i = 0; i < oRetorno.itens.length; i++) {

                with (oRetorno.itens[i]) {

                    sRetorno += "<a  href='db_download.php?arquivo=" + caminho + "'>" + nome + "</a><br>";
                }
            }

            $('retorno').innerHTML = sRetorno;
        } else {

            $('retorno').innerHTML = '';
            //alert("Ouve um erro no processamento!");
            alert(oRetorno.message.urlDecode());
            return false;
        }
    }

    function tipoGeracao() {
        var select = document.getElementById('TipoGeracao');
        var value = select.options[select.selectedIndex].value;
        console.log(value);
        if (value == 'CONSOLIDADO') {
            document.getElementById("isolado").style.display = "none";
            document.getElementById("consolidado").style.display = "inline";
        } else {
            document.getElementById("isolado").style.display = "inline";
            document.getElementById("consolidado").style.display = "none";
        }
    }

    document.getElementById("isolado").style.display = "inline";

</script>
<div id='debug'>
</div>
