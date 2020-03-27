<?php
/**
 *
 * @author I
 * @revision $Author: robson
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
                <b>Gerar PCA - Prestação de Contas Anual</b>
            </legend>
            <table style='empty-cells: show; border-collapse: collapse;'>
                <?php
                $oInstit = new Instituicao(db_getsession('DB_instit'));
                if ($oInstit->getTipoInstit() == Instituicao::TIPO_INSTIT_PREFEITURA) {
                    ?>
                    <tr>
                        <td colspan="4">
                            <fieldset>
                                <table>
                                    <tr>
                                        <td>Tipo da Geração:</td>
                                        <td>
                                            <select id="TipoGeracao" class="TipoGeracao" onchange="tipoGeracao()">
                                                <option value="CONSOLIDADO">CONSOLIDADO</option>
                                                <option value="ISOLADO">ISOLADO</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="3">
                        <div id='dadospca'>

                            <fieldset>
                                <legend>
                                    <b>Enviar Arquivos</b>
                                </legend>
                                <table id="consolidado">

                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Relatório de controle interno:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="consolidado" type="file" name="RCI"/>
                                                <div id="RCI" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','RCI','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>

                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Parecer elaborado pelo Conselho do FUNDEB:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="consolidado" type="file" name="PARECER_FUNDEB"/>
                                                <div id="PARECER_FUNDEB" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','PARECER_FUNDEB','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>

                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Notas explicativas às demonstrações contábeis:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="consolidado" type="file" name="NE"/>
                                                <div id="NE" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','NE','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>

                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Receita base de cálculo para aplicação MDE:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="consolidado" type="file" name="REC_MDE"/>
                                                <div id="REC_MDE" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','REC_MDE','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>

                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Demonstrativo dos gastos MDE:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="consolidado" type="file" name="GASTO_MDE"/>
                                                <div id="GASTO_MDE" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','GASTO_MDE','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>

                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Receita base de cálculo para aplicação ASPS:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="consolidado" type="file" name="REC_ASPS"/>
                                                <div id="REC_ASPS" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','REC_ASPS','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>

                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Demonstrativo dos gastos ASPS:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="consolidado" type="file" name="GASTO_ASPS"/>
                                                <div id="GASTO_ASPS" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','GASTO_ASPS','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>

                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Demonstrativo da aplicação do resíduo:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="consolidado" type="file" name="RES_ASPS"/>
                                                <div id="RES_ASPS" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','RES_ASPS','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>

                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Demonstrativo da despesa com pessoal:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="consolidado" type="file" name="DESP_PESSOAL"/>
                                                <div id="DESP_PESSOAL" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','DESP_PESSOAL','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>

                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Demonstrativo da aplicação dos recursos do Fundeb:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="consolidado" type="file" name="RECURSO_FUNDEB"/>
                                                <div id="RECURSO_FUNDEB" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','RECURSO_FUNDEB','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>

                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Certidão inventário Tesouraria:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="consolidado" type="file" name="CERTIDAO_TESOURARIA"/>
                                                <div id="CERTIDAO_TESOURARIA" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','CERTIDAO_TESOURARIA','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>

                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Certidão inventário Almoxarifado:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="consolidado" type="file" name="CERTIDAO_ALMOXARIFADO"/>
                                                <div id="CERTIDAO_ALMOXARIFADO" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','CERTIDAO_ALMOXARIFADO','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>

                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Certidão inventário Bens Patrimoniais:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="consolidado" type="file"
                                                       name="CERTIDAO_BENS_PATRIMONIAIS"/>
                                                <div id="CERTIDAO_BENS_PATRIMONIAIS" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','CERTIDAO_BENS_PATRIMONIAIS','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>

                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Certidão inventário do Passivo:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="consolidado" type="file" name="CERTIDAO_PASSIVO"/>
                                                <div id="CERTIDAO_PASSIVO" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','CERTIDAO_PASSIVO','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>

                                    <tr>
                                        <form name="form1" id='form1' method="post" action=""
                                              enctype="multipart/form-data">
                                            <td>
                                                Certidão inventário Atos Potenciais:
                                                <div>&nbsp;</div>
                                            </td>
                                            <td>
                                                <input class="consolidado" type="file" name="CERTIDAO_ATOS_POTENCIAIS"/>
                                                <div id="CERTIDAO_ATOS_POTENCIAIS" class="recebe">&nbsp;</div>
                                            </td>
                                            <td>
                                                <input type="button" value="Enviar"
                                                       onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','CERTIDAO_ATOS_POTENCIAIS','Carregando...','Erro ao carregar')"/>
                                                <div>&nbsp;</div>
                                            </td>
                                        </form>
                                    </tr>

                                </table>

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

        var select = document.getElementById('TipoGeracao');
        var tipoGeracao = select.options[select.selectedIndex].value;

        if (tipoGeracao == 'CONSOLIDADO') {
            var aArquivos = $$(".consolidado");
        } else {
            var aArquivos = $$(".isolado");
        }
//    var aArquivos             = $$("input[type='file']");
        /*
         * iterando sobre o array de arquivos com uma função anônima para pegar os arquivos selecionados pelo usuário
         */
        aArquivos.each(function (oElemento, iIndice) {

            aArquivosSelecionados.push(oElemento.name);

        });

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

    document.getElementById("isolado").style.display = "none";
    document.getElementById("consolidado").style.display = "inline";

</script>
<div id='debug'>
</div>
