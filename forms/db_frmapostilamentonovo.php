<?php

//MODULO: sicom
$clapostilamento->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("ac16_sequencial");
$clrotulo->label("ac16_resumoobjeto");
$viewAlterar = $_GET['viewAlterar'];
unset($_GET['viewAlterar']);
?>
<fieldset style="width: 1000px;  margin-top: 25px; ">
    <legend><b>Dados do acordo</b></legend>
    <form name="form1" method="post" action="">

        <table border="0" style="margin-right: 10px; margin-left: -45%;">
            <tr>
                <td title="<?= @$Tac16_sequencial ?>">
                    <?php
                    $jsExec =  $viewAlterar ? "js_acordosc_apostilamentos(true)" : "js_pesquisaac16_sequencial(true);";
                    db_ancora("Acordo", $jsExec, $db_opcao);
                     ?>
                </td>
                <td>
                    <?
                    db_input(
                        'ac16_sequencial',
                        5,
                        $Iac16_sequencial,
                        true,
                        'text',
                        $db_opcao,
                        " onchange='js_pesquisaac16_sequencial(false);'"
                    );
                    ?>
                    <?
                    db_input('ac16_resumoobjeto', 35, $Iac16_resumoobjeto, true, 'text', 3, "", "", "", "");
                    ?>
                </td>




            </tr>

            <tr>
                <td nowrap>
                    <?= @$Lsi03_tipoapostila ?>
                </td>
                <td>
                    <?
                    $x = array(
                        "00" => "Selecione...",
                        "01" => "Variação do valor contratual ou Repactuação de preços previstos no contrato",
                        "02" => "Atualizações, compensações ou penalizações",
                        "03" => "Empenho de dotações orçamentárias",
                        "04" => "Alterações na razão social do contratado",
                        "05" => "Prorrogação do cronograma de execução (impedimento, paralisação ou suspensão)",
                        "99" => "Outros"
                        );
                    db_select('si03_tipoapostila', $x, true, $db_opcao, "onchange='js_changeTipoApostila(this.value)'");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap nowrap title="<?= @$Tsi03_tipoalteracaoapostila ?>">
                    <b>Tipo da Alteração:</b>
                </td>
                <td>
                    <?
                    $x = array("1" => "Acréscimo de valor", "2" => "Decréscimo de valor", "3" => "Não houve alteração de valor");
                    db_select('si03_tipoalteracaoapostila', $x, true, $db_opcao, "");
                    ?>
                </td>
            </tr>
            <tr id="tr_criterioreajuste" style="display:none;">
                <td>
                    <b>Critério de Reajuste </b>
                </td>
                <td>
                    <?
                    $aCriteriosReajuste = array("1" => "Índice Único", "2" => "Cesta de Índices", "3" => "Índice Específico");
                    db_select('ac26_criterioreajuste', $aCriteriosReajuste, true, $db_opcao, "onchange='js_changeCriterioReajuste(this.value)'");
                    ?>
                </td>
            </tr>
            <tr id="trreajuste" style="display: none;">
                <td>
                    <b>Percentual de Reajuste:</b>
                </td>
                <td>
                    <?
                    db_input('si03_percentualreajuste', 10, 4, true, 'text', $db_opcao, "")
                    ?>
                    <b id="indicereajuste">Índice Reajuste:</b>

                    <?
                    $x = array("0" => "Selecione", "1" => "IPCA", "2" => "INPC", "3" => "INCC", "4" => "IGP-M", "5" => "IGP-DI", "6" => "Outro");
                    db_select('si03_indicereajuste', $x, true, $db_opcao, "onchange='js_indicereajuste()'");
                    ?>
                </td>
            </tr>
            <tr id="tr_descricaoreajuste" style="display: none;">
                <td>
                    <b>Descrição Reajuste:</b>
                </td>
                <td>
                    <?
                    db_textarea('ac26_descricaoreajuste', 3, 58, $Isi03_descricaoindice, true, 'text', $db_opcao, "style='resize: none'", "", "", "300");
                    ?>
                </td>
            </tr>
            <tr id="tr_descricaoindice" style="display: none;">


                <td>
                    <b>Descriçao do Índice:</b>
                </td>
                <td>
                    <?
                    db_textarea('si03_descricaoindice', 3, 58, $Isi03_descricaoindice, true, 'text', $db_opcao, "style='resize: none'", "", "", "300");
                    ?>
                </td>
            </tr>

            <tr>
                <td title="<?= @$Tsi03_numapostilamento ?>">
                    <b>Número da Apostila:</b>
                </td>
                <td>
                    <?
                    db_input('si03_numapostilamento', 2, $Isi03_numapostilamento, true, 'text', $db_opcao, "")
                    ?>

                </td>
            </tr>


            <tr>
                <td title="<?= @$Tsi03_dataapostila ?>">
                    <b>Data de Apostila:</b>
                </td>
                <td>

                    <?
                    db_inputdata('si03_dataapostila', @$si03_dataapostila_dia, @$si03_dataapostila_mes, @$si03_dataapostila_ano, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>

            <tr id="trdatareferencia" style="display: none;">
                <td align="left" title="<?= @$Tsi03_datareferencia ?>">
                    <b>Data de Referência:</b>
                </td>

                <td align="left">
                    <?
                    db_inputdata(
                        'si03_datareferencia',
                        @$si03_datareferencia_dia,
                        @$si03_datareferencia_mes,
                        @$si03_datareferencia_ano,
                        true,
                        'text',
                        $db_opcao
                    );
                    ?>
                </td>
                <td>&nbsp;</td>
            </tr>


            <tr>
                <td nowrap nowrap title="<?= @$Tsi03_descrapostila ?>">
                    <b>Descrição da Alteração:</b>
                </td>
                <td>
                    <?
                    db_textarea('si03_descrapostila', 3, 48, $Isi03_descrapostila, true, 'text', $db_opcao, "style='resize: none'", "", "", "250");
                    ?>
                </td>
            </tr>

            <tr id="justificativa">
                <td nowrap nowrap title="<?= @$Tsi03_justificativa ?>">
                    <b>Justificativa:</b>
                </td>
                <td>
                    <?
                    db_textarea('si03_justificativa', 3, 48, 0, true, 'text', $db_opcao, "style='resize: none'", "", "", "5120");
                    ?>
                </td>
            </tr>


            <?
            $si03_instit = db_getsession("DB_instit");
            db_input('si03_instit', 10, $Isi03_instit, true, 'hidden', $db_opcao, "")
            ?>
            <?
            $controle = $db_opcao;
            db_input('controle', 10, $Icontrole, true, 'hidden', $db_opcao, "")
            ?>

            <tr>

                <!-- tag <td> a seguir ocultada apos solicitacao de adequamento da tela na OC17626 -->

                <td colspan='2'>
                    <fieldset class="" style="display: none;">
                        <legend>Vigência</legend>
                        <table border='0'>
                            <tr>
                                <td><label class="bold">Inicial:</td>
                                <td>
                                    <? db_input('datainicial', 10, 0, true, 'text', 3, "") ?>
                                </td>
                                <td><label class="bold">Final:<label></td>
                                <td>
                                    <? db_input('datafinal', 10, 0, true, 'text', 3, "") ?>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </td>

                <!-- tag <td> a seguir ocultada pois apresenta inconsistencia
                     no valor apresentado, a tag s ficar visivel novamente
                    caso cliente solicite o retorno  -->

                <td colspan='2' style="display: none;">
                    <fieldset class="">
                        <legend>Valores</legend>
                        <table>
                            <tr>
                                <td><label class="bold">Valor Original:</label></td>
                                <td>
                                    <? db_input('valororiginal', 14, 0, true, 'text', 3, "") ?>
                                </td>
                                <td><label class="bold">Valor Atual:</label></td>
                                <td>
                                    <? db_input('valoratual', 14, 0, true, 'text', 3, "") ?>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </td>



            </tr>

            <tr id="edicaoBloco" style="display: none;">
                <td colspan='2'>
                    <fieldset class="">
                        <legend>Edição em bloco</legend>
                        <table>
                            <td>
                                <?php db_ancora("Dotações", "pesquisao_coddot(true);", $db_opcao); ?>

                            </td>
                            <td>
                                <?

                                db_input(
                                    'o58_coddot',
                                    5,
                                    $o58_coddot,
                                    true,
                                    'text',
                                    $db_opcao,
                                    "onchange='pesquisadotacao();'"
                                );
                                ?>
                            </td>
                            <td>
                                <?
                                db_input('o55_descricao', 35, $Io55_descricao, true, 'text', 3, "", "", "", "");
                                ?>
                                <input type='button' id='btnAp?icar' value='Aplicar' onclick="aplicarDotacoes();">
                            </td>
                        </table>

                </td>

            </tr>


        </table>

    </form>
</fieldset>
<table>
    <tr>
        <td>
            <fieldset>
                <legend>Itens</legend>
                <div id='ctnGridItens' style="width: 1000px"></div>
            </fieldset>
        </td>
    </tr>
</table>
<input type='button' disabled id='btnSalvar' value='Salvar' onclick="apostilar();">
<script>
    const viewAlterar = "<?php echo $viewAlterar ?>";
    let RetornoItens = null;
    let si03_sequencial = null;
    let tipoApostilaInicial = null;
    let numApostilaInicial = null;
    let validaDtApostila = true;
    document.getElementById("si03_datareferencia").style.width = "80px"
    document.getElementById("si03_tipoalteracaoapostila").disabled = true;
    sUrlRpc = 'con4_contratoapostilamento.RPC.php';
    let aItensPosicao = new Array();
    oGridItens = new DBGrid('oGridItens');
    oGridItens.nameInstance = 'oGridItens';
    oGridItens.setCheckbox(0);
    oGridItens.setCellAlign(['center', 'left', "right", "right", "right", "right", "center", "right", "center", "center", "center", "center", "center"]);
    oGridItens.setHeader(["Código", "Item", "Quantidade", "Unit. Anterior", "Quantidade", "Valor Unitário", "Valor Total", "Valor Apostilado", "Qt Aditada", "Dotacoes", "Seq"]);
    oGridItens.aHeaders[11].lDisplayed = false;
    oGridItens.aHeaders[10].lDisplayed = false;
    oGridItens.aHeaders[5].lDisplayed = false;
    oGridItens.aHeaders[9].lDisplayed = false;
    oGridItens.setHeight(300);
    oGridItens.show($('ctnGridItens'));


    var opcao = document.form1.controle.value;
    var elemento = "";
    var elemento_dotacao = "";
    var dotacaoIncluida = false;

    function pesquisadotacao() {

        var oParam = new Object();
        oParam.dotacao = $('o58_coddot').value;
        var oAjax = new Ajax.Request(
            "func_dotacao.php", {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: retornoDotacao

            }
        );

    }

    function retornoDotacao(oAjax) {

        var oRetorno = eval("(" + oAjax.responseText + ")");

        if (oRetorno.erro != "") {
            $('o58_coddot').value = "";
            $('o55_descricao').value = "";
            alert("Sem permissão para esta Dotação!");
            return;
        }
        oRetorno.elemento = oRetorno.elemento.substr(0, 7);
        elemento_dotacao = oRetorno.elemento;
        $('o55_descricao').value = oRetorno.descricao.urlDecode();

    }

    function js_pesquisasi03_licitacao(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_liclicita', 'func_liclicita.php?funcao_js=parent.js_mostraliclicita1|l20_codigo|l20_edital|l20_anousu', 'Pesquisa', true);
        } else {
            if (document.form1.si03_licitacao.value != '') {
                js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_liclicita', 'func_liclicita.php?pesquisa_chave=' + document.form1.si03_licitacao.value + '&funcao_js=parent.js_mostraliclicita', 'Pesquisa', false);
            } else {
                document.form1.l20_codigo.value = '';
            }
        }
    }

    function js_mostraliclicita(chave, erro) {
        document.form1.l20_codigo.value = chave;
        if (erro == true) {
            document.form1.si03_licitacao.focus();
            document.form1.si03_licitacao.value = '';
        }
    }

    function js_mostraliclicita1(chave1, chave2, chave3) {
        document.form1.si03_licitacao.value = chave1;
        document.form1.l20_edital.value = chave2 + '/' + chave3;
        db_iframe_liclicita.hide();
    }

    function js_pesquisa() {
        js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_apostilamento', 'func_apostilamentonovo.php?funcao_js=parent.js_preenchepesquisa|si03_sequencial', 'Pesquisa', true);
    }

    function js_preenchepesquisa(chave) {
        db_iframe_apostilamento.hide();
        <?
        if ($db_opcao != 1) {
            echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
        }
        ?>
    }

    function js_retornoPesquisa(oAjax) {
        var oRetorno = eval("(" + oAjax.responseText + ")");
        document.form1.si03_dataassinacontrato.value = oRetorno.si172_dataassinatura;
        var aData = document.form1.si03_dataassinacontrato.value.split("/");
        js_setDiaMesAno(document.form1.si03_dataassinacontrato, aData[0], aData[1], aData[2]);
    }

    function js_pesquisaac16_sequencial(lMostrar) {

        if (lMostrar == true) {

            var sUrl = 'func_acordonovo.php?funcao_js=parent.js_mostraacordo1|ac16_sequencial|ac16_resumoobjeto|ac16_dataassinatura&iTipoFiltro=4';
            js_OpenJanelaIframe('CurrentWindow.corpo',
                'db_iframe_acordo',
                sUrl,
                'Pesquisar Acordo',
                true);
        } else {

            if ($('ac16_sequencial').value != '') {

                var sUrl = 'func_acordonovo.php?descricao=true&pesquisa_chave=' + $('ac16_sequencial').value +
                    '&funcao_js=parent.js_mostraacordo';

                js_OpenJanelaIframe('CurrentWindow.corpo',
                    'db_iframe_acordo',
                    sUrl,
                    'Pesquisar Acordo',
                    false);
            } else {
                $('ac16_sequencial').value = '';
            }
        }
    }

    /**
     * Retorno da pesquisa acordos
     */
    function js_mostraacordo(chave1, chave2, chave3, erro) {

        if (erro == true) {

            $('ac16_sequencial').value = '';
            $('ac16_resumoobjeto').value = chave1;
            $('ac16_sequencial').focus();
        } else {

            $('ac16_sequencial').value = chave1;
            $('ac16_resumoobjeto').value = chave2;
            pesquisarDadosAcordo(chave1);
        }
    }

    /**
     * Retorno da pesquisa acordos
     */
    function js_mostraacordo1(chave1, chave2, chave3) {
        let oParam = {
            exec: 'getleilicitacao',
            licitacao: chave1
        }

        new AjaxRequest(sUrlRpc, oParam, function(oRetorno, lErro) {
                if (oRetorno.lei == 1) {
                    $('justificativa').style.display = '';
                } else {
                    $('justificativa').style.display = 'none';
                }
            }).setMessage("Aguarde, pesquisando acordos.")
            .execute();

        oParam = {
            exec: 'getLeiAndOrigem',
            licitacao: chave1
        }

        new AjaxRequest(sUrlRpc, oParam, function(oRetorno, lErro) {
            
                let aOrigensValidas = ["2","3"];
                let leiLicitacao = oRetorno.lei;
                let tipoOrigem = oRetorno.tipoorigem;
                let si03_tipoapostila = document.getElementById('si03_tipoapostila');

                if (leiLicitacao == 1 && aOrigensValidas.includes(tipoOrigem)) {

                    si03_tipoapostila.options[4].disabled = false;
                    si03_tipoapostila.options[5].disabled = false;
                    si03_tipoapostila.options[6].disabled = false;
                    return;
                } 

                si03_tipoapostila.options[4].disabled = true;
                si03_tipoapostila.options[5].disabled = true;
                si03_tipoapostila.options[6].disabled = true;
                                
        }).setMessage("Aguarde, pesquisando acordos.")
            .execute();
        
            
        $('ac16_sequencial').value = chave1;
        $('ac16_resumoobjeto').value = chave2;

        pesquisarDadosAcordo(chave1);
        db_iframe_acordo.hide();

        validaAcordoDotacoesAnoOrigem(chave1);
    }

    function validaAcordoDotacoesAnoOrigem(codigoAcordo) {
        let anoOrigem = "<?php echo db_getsession('DB_anousu'); ?>";
        let anoDestino = "<?php echo db_getsession('DB_anousu') + 1; ?>";

        let oParametros = {};
        oParametros.anoOrigem = anoOrigem;
        oParametros.anoDestino = anoDestino;
        oParametros.codigoAcordo = codigoAcordo;
        oParametros.somenteConsulta = true;

        new Ajax.Request('ac04_alteradotacoescontratos.RPC.php', {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParametros),
            start_time: new Date().getTime(),
            onComplete: function(oResponse) {
                const oRetorno = eval("(" + oResponse.responseText + ")");
                let timeout = new Date().getTime() - this.start_time;
                if (oRetorno.materiaisSemDotacoes === true) {
                    if (oRetorno.todosItensSemDotacoes === true) {
                        setTimeout(function(){
                            alert(`Todos os itens deste contrato estão sem dotações para o ano ${anoOrigem}. Acessar a rotina Módulo Contratos > Procedimentos - Acordo - Alteração de Dotação e realizar a alteração para prosseguir com o procedimento.`);
                        }, timeout);
                    } else {
                        setTimeout(function(){
                            alert(`Os itens ${oRetorno.itens} estão sem dotações para o ano ${anoOrigem}. Acessar a rotina Módulo Contratos > Procedimentos - Acordo - Alteração de Dotação e realizar a alteração para prosseguir com o procedimento.`);
                        }, timeout);
                    }
                }
            }
        });
    }

    function pesquisarDadosAcordo(iAcordo) {

        if (iAcordo == "") {

            alert('Acordo Não informado!');
            return false;
        }

        var oParam = {
            exec: 'getItens',
            iAcordo: iAcordo
        }

        new AjaxRequest(sUrlRpc, oParam, function(oRetorno, lErro) {

                if (lErro) {
                    return alert(oRetorno.message.urlDecode());
                }

                $('btnSalvar').disabled = false;

                $('valororiginal').value = js_formatar(oRetorno.valores.valororiginal, "f");
                $('valoratual').value = js_formatar(oRetorno.valores.valoratual, "f");

                $('datainicial').value = oRetorno.datainicial;
                $('datafinal').value = oRetorno.datafinal;
                $('si03_numapostilamento').value = oRetorno.seqapostila;

                aItensPosicao = oRetorno.itens;
                preencheItens(aItensPosicao);

            }).setMessage("Aguarde, pesquisando acordos.")
            .execute();

    }

    function preencheItens(aItens) {
        /* Calculo realizado para ajuste do tamanho do label dos itens
         *  conforme a quantidade de itens.
         */
        var sizeLabelItens = 0;
        if (aItens.length < 12) {
            sizeLabelItens = (aItens.length / 2) * 50;
            sizeLabelItens = sizeLabelItens + "px";
            document.getElementById('body-container-oGridItens').style.height = sizeLabelItens;

        } else {
            document.getElementById('body-container-oGridItens').style.height = "340px";

        }


        oGridItens.clearAll(true);

        var aEventsIn = ["onmouseover"];
        var aEventsOut = ["onmouseout"];
        aDadosHintGrid = new Array();
        var objelemento = new Object();
        elementos = [];


        aItens.each(function(oItem, iSeq) {

            var aLinha = new Array();
            var iTipoApostila = $("si03_tipoapostila").value;
            var iTipoAltApostila = $("si03_tipoalteracaoapostila").value;

            aLinha[0] = oItem.codigoitem;
            aLinha[1] = oItem.descricaoitem.urlDecode();
            aLinha[2] = js_formatar(oItem.qtdeanterior, 'f', 2);
            aLinha[3] = js_formatar(oItem.vlunitanterior, 'f', 2);

            var nQuantidade = oItem.quantidade || oItem.qtdeanterior,
                nUnitario = oItem.valorunitario || oItem.vlunitanterior;

            oInputQuantidade = new DBTextField('quantidade' + iSeq, 'quantidade' + iSeq, js_formatar(nQuantidade, 'f', 3));
            oInputQuantidade.addStyle("width", "100%");
            oInputQuantidade.setClassName("text-right");
            oInputQuantidade.setReadOnly(true);

            aLinha[4] = oInputQuantidade.toInnerHtml();

            oInputUnitario = new DBTextField('valorunitario' + iSeq, 'valorunitario' + iSeq, js_formatar(nUnitario, "f", 3));
            oInputUnitario.addStyle("width", "100%");
            oInputUnitario.setClassName("text-right");
            oInputUnitario.setReadOnly(false);
            //oInputUnitario.onChange

            if (iTipoAltApostila != 3) {
                oInputUnitario.addEvent("onFocus", "this.value = js_strToFloat(this.value)");
                oInputUnitario.addEvent("onBlur", "this.value = js_formatar(this.value, 'f', 3)");
                oInputUnitario.addEvent("onInput", "this.value = this.value.replace(/[^0-9\.]/g, ''); calculaValorTotal(" + iSeq + ");CalcularValorApostilado(" + iSeq + ")");
            }

            aLinha[5] = oInputUnitario.toInnerHtml();
            aLinha[6] = js_formatar(nQuantidade * nUnitario, 'f', 2);

            oInputAditado = new DBTextField('valorapostilado' + iSeq, 'valorapostilado' + iSeq, js_formatar(0, 'f', 2));
            oInputAditado.addStyle("width", "100%");
            oInputAditado.setClassName("text-right");
            oInputAditado.setReadOnly(true);
            aLinha[7] = oInputAditado.toInnerHtml();

            oInputQtAditada = new DBTextField('quantiaditada' + iSeq, 'quantiaditada' + iSeq, js_formatar(0, 'f', 2));
            oInputQtAditada.addStyle("width", "100%");
            oInputQtAditada.setClassName("text-right");
            oInputQtAditada.setReadOnly(true);
            aLinha[8] = oInputQtAditada.toInnerHtml();

            var oBotaoDotacao = document.createElement("input");
            oBotaoDotacao.type = "button";
            oBotaoDotacao.id = "dotacoes" + iSeq;
            oBotaoDotacao.value = "Dotações";
            oBotaoDotacao.disabled = false;
            oBotaoDotacao.setAttribute("onclick", "ajusteDotacao(" + iSeq + ", " + oItem.elemento + ")");
            aLinha[9] = oBotaoDotacao.outerHTML;
            aLinha[10] = new String(iSeq);
            elementos[iSeq] = oItem.elemento;
            elemento = oItem.elemento;

            oGridItens.addRow(aLinha, false, false, false);

            var sTextEvent = " ";

            if (aLinha[1] !== '') {
                sTextEvent += "<b>Item: </b>" + aLinha[1];
            } else {
                sTextEvent += "<b>Nenhum dado à mostrar</b>";
            }

            var oDadosHint = new Object();
            oDadosHint.idLinha = `oGridItensrowoGridItens${iSeq}`;
            oDadosHint.sText = sTextEvent;
            aDadosHintGrid.push(oDadosHint);


            if (oItem.dotacoesoriginal == undefined) {

                oItem.dotacoesoriginal = new Array();

                oItem.dotacoes.forEach(function(oDotacaoOriginal) {
                    oItem.dotacoesoriginal.push({
                        dotacao: oDotacaoOriginal.dotacao,
                        quantidade: oDotacaoOriginal.quantidade,
                        valor: oDotacaoOriginal.valor,
                        valororiginal: oDotacaoOriginal.valororiginal
                    });
                });
            }

            salvarInfoDotacoes(iSeq);
        });


        oGridItens.renderRows();

        aDadosHintGrid.each(function(oHint, id) {
            var oDBHint = eval("oDBHint_" + id + " = new DBHint('oDBHint_" + id + "')");
            oDBHint.setText(oHint.sText);
            oDBHint.setShowEvents(aEventsIn);
            oDBHint.setHideEvents(aEventsOut);
            //oDBHint.setPosition('B', 'L');
            oDBHint.setUseMouse(true);
            oDBHint.make($(oHint.idLinha), 2);
        });


        oGridItens.renderRows();
    }

    /**
     * Calcula o valor da coluna Valor Total
     */
    function calculaValorTotal(iLinha) {

        var aLinha = oGridItens.aRows[iLinha],
            nQuantidade = aLinha.aCells[5].getValue().getNumber();
        nUnitario = aLinha.aCells[6].getValue().getNumber();


        aItensPosicao[iLinha].quantidade = nQuantidade;
        aItensPosicao[iLinha].valorunitario = nUnitario;

        aLinha.aCells[7].setContent(js_formatar(nQuantidade * nUnitario, 'f', 2));
        if (aItensPosicao[iLinha].dotacoes.length > 0) {
            aItensPosicao[iLinha].dotacoes[0].valor = js_formatar(nQuantidade * nUnitario, 'f', 2);
            //aItensPosicao[iLinha].dotacoes[0].quantidade = js_round((nUnitario / aItensPosicao[iLinha].valorunitario), 2);
            //atualizarItemDotacao(iLinha, 0, js_formatar(nQuantidade * nUnitario, 'f', 2));
        }


        salvarInfoDotacoes(iLinha);
    }

    /**
     * Calcula o valor apostilado
     */
    function CalcularValorApostilado(iLinha) {

        var aLinha = oGridItens.aRows[iLinha],
            nValorAnterior = aLinha.aCells[4].getValue().getNumber();
        nQuantidade = aLinha.aCells[5].getValue().getNumber(),
            nUnitario = aLinha.aCells[6].getValue().getNumber();

        var valorapostilado = (nQuantidade * nValorAnterior) - (nQuantidade * nUnitario);

        if ((nUnitario == 0) || (nUnitario = undefined)) {
            valorapostilado = 0;
        }

        aLinha.aCells[8].setContent(js_formatar(Math.abs(valorapostilado), 'f', 2));


        salvarInfoDotacoes(iLinha);
    }

    /**
     * Controle das dotacoes do item.
     */
    function ajusteDotacao(iLinha, iElemento) {

        iElementoDotacao = iElemento;

        if ($('wndDotacoesItem')) {
            return false;
        }

        oDadosItem = oGridItens.aRows[iLinha];
        windowDotacaoItem = new windowAux('wndDotacoesItem', 'Dotações Item', 430, 380);

        var sContent = "<div class=\"subcontainer\">";

        sContent += "<fieldset><legend>Adicionar Dotações</legend>";


        sContent += "  <table>";
        sContent += "   <tr>";
        sContent += "     <td>";
        sContent += "     <a href='#' class='dbancora' style='text-decoration: underline;'";
        sContent += "       onclick='pesquisao47_coddot(true);'><b>Dotações:</b></a>";
        sContent += "     </td>";
        sContent += "     <td id='inputdotacao'></td>";
        sContent += "     <td>";
        sContent += "      <b>Saldo Dotações:</b>";
        sContent += "     </td>";
        sContent += "     <td id='inputsaldodotacao'></td>";
        sContent += "   </tr>";
        sContent += "   <tr>";
        sContent += "     <td>";
        sContent += "      <b>Valor:</b>";
        sContent += "     </td>";
        sContent += "     <td id='inputvalordotacao'></td>";
        sContent += "     <td colspan='2'></td>";
        sContent += "    </tr>";
        sContent += "  </table>";
        sContent += "</fieldset>";
        sContent += "  <input type='button' value='Adicionar' id='btnSalvarDotacao'>";;
        sContent += "  <fieldset style=\"margin-top: 5px;\">";
        sContent += "    <div id='cntgridDotacoes'></div>";
        sContent += "  </fieldset>";
        sContent += "</div>";

        windowDotacaoItem.setContent(sContent);
        oMessageBoard = new DBMessageBoard('msgboard1',
            'Adicionar Dotacoes',
            'Dotações Item ' + oDadosItem.aCells[2].getValue() + " (valor: <b>" +
            oDadosItem.aCells[5].getValue() + "</b>)",
            $('windowwndDotacoesItem_content'));

        windowDotacaoItem.setShutDownFunction(function() {
            windowDotacaoItem.destroy();
        });

        $('btnSalvarDotacao').observe("click", function() {
            saveDotacao(iLinha)
        });

        oTxtDotacao = new DBTextField('oTxtDotacao', 'oTxtDotacao', '', 10);
        oTxtDotacao.show($('inputdotacao'));
        //oTxtDotacao.setReadOnly(true);

        oTxtSaldoDotacao = new DBTextField('oTxtSaldoDotacao', 'oTxtSaldoDotacao', '', 10);
        oTxtSaldoDotacao.show($('inputsaldodotacao'));
        oTxtSaldoDotacao.setReadOnly(true);

        oTxtValorDotacao = new DBTextField('oTxtValorDotacao', 'oTxtValorDotacao', '0,00', 10);
        oTxtValorDotacao.setClassName("text-right");
        oTxtValorDotacao.addEvent("onFocus", "this.value = js_strToFloat(this.value)");
        oTxtValorDotacao.addEvent("onBlur", "this.value = js_formatar(this.value, 'f', 2)");
        oTxtValorDotacao.addEvent("onInput", "this.value = this.value.replace(/[^0-9\.]/g, '')");
        oTxtValorDotacao.show($('inputvalordotacao'));

        oMessageBoard.show();
        oGridDotacoes = new DBGrid('gridDotacoes');
        oGridDotacoes.nameInstance = 'oGridDotacoes';

        oGridDotacoes.setCellWidth(['20%', '60%', '20%']);
        oGridDotacoes.setHeader(["Dotações", "Valor", "&nbsp;"]);

        oGridDotacoes.setCellWidth(['20% !important', '60% !important', '20% !important']);

        oGridDotacoes.setCellAlign(["center", "right", "Center"]);
        oGridDotacoes.setHeight(100);
        oGridDotacoes.hasTotalizador = true;

        windowDotacaoItem.show();

        oGridDotacoes.show($('cntgridDotacoes'));
        oGridDotacoes.clearAll(true);
        preencheGridDotacoes(iLinha);
    }

    function preencheGridDotacoes(iLinha) {

        oGridDotacoes.clearAll(true);

        nValorTotal = 0;
        aItensPosicao[iLinha].dotacoes.each(function(oDotacao, iDot) {

            var oValorDotacao = new DBTextField("valordot" + iDot, "valordot" + iDot, js_formatar(oDotacao.valor, "f"));
            oValorDotacao.addStyle("width", "100%");
            oValorDotacao.setClassName("text-right");
            oValorDotacao.addEvent("onFocus", "this.value = js_strToFloat(this.value)");
            oValorDotacao.addEvent("onBlur", "this.value = js_formatar(this.value, 'f', 2)");
            oValorDotacao.addEvent("onInput", "this.value = this.value.replace(/[^0-9\.]/g, '');atualizarItemDotacao(" + iLinha + ", " + iDot + ", this); ");

            var oBotaoRemover = document.createElement("input");
            oBotaoRemover.type = "button";
            oBotaoRemover.id = "btnexcluidotacao" + iDot;
            oBotaoRemover.value = "E";
            oBotaoRemover.setAttribute("onclick", "removerDotacao(" + iLinha + ", " + iDot + ")");

            aLinha = new Array();
            aLinha[0] = "<a href='javascript:;' onclick='mostraSaldo(" + oDotacao.dotacao + ");'>" + oDotacao.dotacao + "</a>";
            aLinha[1] = oValorDotacao.toInnerHtml();
            aLinha[2] = oBotaoRemover.outerHTML;

            oGridDotacoes.addRow(aLinha);

            nValorTotal += oDotacao.valor;
        });

        $('TotalForCol1').innerHTML = js_formatar(nValorTotal, 'f');

        oGridDotacoes.renderRows();
    }

    /**
     * Atualiza a informao das Dotações do item
     */
    function atualizarItemDotacao(iLinha, iDotacao, oValor) {

        if (oValor.value == undefined) {
            aItensPosicao[iLinha].dotacoes[iDotacao].valor = oValor;
            aItensPosicao[iLinha].dotacoes[iDotacao].quantidade = js_round((oValor / aItensPosicao[iLinha].valorunitario), 2);
        } else {
            aItensPosicao[iLinha].dotacoes[iDotacao].valor = oValor.value.getNumber();
            aItensPosicao[iLinha].dotacoes[iDotacao].quantidade = js_round((oValor.value.getNumber() / aItensPosicao[iLinha].valorunitario), 2);

        }


        nValorTotal = 0;
        var nQuantTotal = 0;
        aItensPosicao[iLinha].dotacoes.each(function(oDotacao) {
            nValorTotal += oDotacao.valor;
            nQuantTotal += oDotacao.quantidade;
        });

        if (nQuantTotal > aItensPosicao[iLinha].quantidade) {
            aItensPosicao[iLinha].dotacoes[iDotacao].quantidade -= (nQuantTotal - aItensPosicao[iLinha].quantidade);
        }

        $('TotalForCol1').innerHTML = js_formatar(nValorTotal, 'f');
    }

    /**
     * Remove a Dotacao
     */
    function removerDotacao(iLinha, iDotacao) {
        if (confirm("Remover dotações do item?")) {


            aItensPosicao[iLinha].dotacoes.splice(iDotacao, 1);
            preencheGridDotacoes(iLinha);
        }
    }

    function saveDotacao(iLinha) {

        if (oTxtDotacao.getValue() == "") {


            alert("Campo dotações é de preenchimento obrigatário.");

            js_pesquisao47_coddot(true);
            return false;
        }

        var nValor = js_strToFloat(oTxtValorDotacao.getValue());

        /**
         * Removido validacao de inclusao de dotacao zerada conforme solicitado na OC 3855
         */
        /*if (nValor == 0) {

            alert('Campo Valor  de preenchimento Obrigatório.');
            $('oTxtValorDotacao').focus();
            return false;
        }*/

        var oDotacao = {
            dotacao: oTxtDotacao.getValue(),
            quantidade: 1,
            valor: nValor,
            valororiginal: nValor
        };

        oDotacao.quantidade = js_round((nValor / aItensPosicao[iLinha].valorunitario), 2);
        nValorTotal = nValor;
        var nQuantTotal = 0;
        aItensPosicao[iLinha].dotacoes.each(function(oDotacao) {
            nValorTotal += oDotacao.valor;
            nQuantTotal += oDotacao.quantidade;
        });

        if (nValorTotal > (aItensPosicao[iLinha].quantidade * aItensPosicao[iLinha].valorunitario)) {
            alert("Valor Dotações maior que valor do item.");
            return false;
        }

        if (nQuantTotal > aItensPosicao[iLinha].quantidade) {
            oDotacao.quantidade -= (nQuantTotal - aItensPosicao[iLinha].quantidade);
        }

        var lInserir = true;
        aItensPosicao[iLinha].dotacoes.forEach(function(oDotacaoItem) {

            if (oDotacaoItem.dotacao == oDotacao.dotacao) {
                lInserir = false;

                alert("Dotação já incluida para o item.");
            }
        });

        if (!lInserir) {
            return false;
        }

        aItensPosicao[iLinha].dotacoes.push(oDotacao);
        oTxtDotacao.setValue("");
        oTxtSaldoDotacao.setValue("");
        oTxtValorDotacao.setValue("0,00");
        dotacaoIncluida = true;
        preencheGridDotacoes(iLinha);
    }

    function getSaldoDotacao(iDotacao) {

        var oParam = new Object();
        oParam.exec = "getSaldoDotacao";
        oParam.iDotacao = iDotacao;
        js_divCarregando('Aguarde, pesquisando saldo Dotações', 'msgBox');
        var oAjax = new Ajax.Request(
            "con4_contratos.RPC.php", {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: retornoGetSaldotacao
            }
        );

    }

    function retornoGetSaldotacao(oAjax) {

        js_removeObj('msgBox');
        var oRetorno = eval("(" + oAjax.responseText + ")");
        oTxtSaldoDotacao.setValue(js_formatar(oRetorno.saldofinal, "f"));
    }

    function mostraSaldo(chave) {

        var arq = 'func_saldoorcdotacao.php?o58_coddot=' + chave


        js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_saldos', arq, 'Saldo da dotações', true);

        $('Jandb_iframe_saldos').style.zIndex = '1500000';
    }

    /**
     * calcula os valores da dotações conforme o valor modificado pelo usuario
     */
    function salvarInfoDotacoes(iLinha) {

        var oItem = aItensPosicao[iLinha];

        var nQuantidade = oItem.qtdeanterior || oItem.quantidade,
            nUnitario = oItem.valorunitario || oItem.vlunitanterior,
            nValorTotal = (+nQuantidade) * (+nUnitario),
            nValorTotalItem = nValorTotal,
            nQuantTotalItem = nQuantidade,
            nValorTotalAnterior = 0;

        /**
         * Soma o valor original total
         */
        aItensPosicao[iLinha].dotacoes.each(function(oDotacao) {
            nValorTotalAnterior += +oDotacao.valororiginal;
        });

        aItensPosicao[iLinha].dotacoes.each(function(oDotacao, iDot) {

            var nPercentual = (nValorTotalAnterior == 0) ? 0 : (new Number(oDotacao.valororiginal) * 100) / nValorTotalAnterior;
            var nValorDotacao = js_round((nValorTotalItem * nPercentual) / 100, 2);
            var nQuantDotacao = js_round((nQuantTotalItem * nPercentual) / 100, 2);

            nValorTotal -= nValorDotacao;
            nQuantidade -= nQuantDotacao;
            if (iDot == aItensPosicao[iLinha].dotacoes.length - 1) {

                if (nValorTotal != nValorTotalItem) {
                    nValorDotacao += nValorTotal;
                }
                if (nQuantidade != nQuantTotalItem) {
                    nQuantDotacao += nQuantidade;
                }
            }

            if (nValorDotacao < 0) {
                nValorDotacao = 0;
            }
            if (nQuantDotacao < 0) {
                nQuantDotacao = 0;
            }

            aItensPosicao[iLinha].dotacoes[iDot].valor = js_round(nValorDotacao, 2);
            aItensPosicao[iLinha].dotacoes[iDot].quantidade = js_round(nQuantDotacao, 2);
        });
    }

    function pesquisao_coddot(mostra) {
        query = '';
        apostilamentonovo = true;
        elemento = "";
        query = "elementos=" + elementos + "&" + "apostilamentonovo=" + apostilamentonovo + "&";


        if (mostra == true) {
            js_OpenJanelaIframe('',
                'db_iframe_orcdotacao',
                'func_permorcdotacao.php?' + query + 'funcao_js=parent.mostraorcdotacao1|o58_coddot|o55_descr|o50_estrutdespesa',
                'Pesquisa de Dotações',
                true, 0);

            $('Jandb_iframe_orcdotacao').style.zIndex = '100000000';
        } else {
            js_OpenJanelaIframe('',
                'db_iframe_orcdotacao',
                'func_permorcdotacao.php?' + query + 'pesquisa_chave=' + $('o58_coddot').value +
                '&funcao_js=parent.mostraorcdotacao',
                'Pesquisa de Dotações',
                false
            );
        }
    }

    function pesquisao47_coddot(mostra) {

        query = '';
        if (iElementoDotacao != '') {
            query = "elemento=" + iElementoDotacao + "&";
        }

        if (mostra == true) {
            js_OpenJanelaIframe('',
                'db_iframe_orcdotacao',
                'func_permorcdotacao.php?' + query + 'funcao_js=parent.mostraorcdotacao2|o58_coddot',
                'Pesquisa de Dotações',
                true, 0);

            $('Jandb_iframe_orcdotacao').style.zIndex = '100000000';
        } else {
            js_OpenJanelaIframe('',
                'db_iframe_orcdotacao',
                'func_permorcdotacao.php?' + query + 'pesquisa_chave=' + document.form1.o47_coddot.value +
                '&funcao_js=parent.' + me.sInstance + '.mostraorcdotacao',
                'Pesquisa de Dotações',
                false
            );
        }
    }

    function mostraorcdotacao(chave, erro) {

        if (erro) {
            document.form1.o47_coddot.focus();
            document.form1.o47_coddot.value = '';
        }
        getSaldoDotacao(chave);
    }

    function mostraorcdotacao1(chave1, chave2, chave3) {

        //oTxtDotacao.setValue(chave1);
        $('o58_coddot').value = chave1;
        $('o55_descricao').value = chave2;
        db_iframe_orcdotacao.hide();
        $('Jandb_iframe_orcdotacao').style.zIndex = '0';
        //$('oTxtValorDotacao').focus();
        //alert(chave3.substr(23, 7));
        elemento_dotacao = chave3.substr(23, 7);
        getSaldoDotacao(chave1);
    }

    function mostraorcdotacao2(chave1, chave2) {

        oTxtDotacao.setValue(chave1);
        db_iframe_orcdotacao.hide();
        $('Jandb_iframe_orcdotacao').style.zIndex = '0';
        //$('oTxtValorDotacao').focus();
        getSaldoDotacao(chave1);
    }

    function aplicarDotacoes() {

        if ($('o58_coddot').value == "") {
            return alert('Obrigatório selecionar uma Dotação');
        }


        var oDotacao = {
            dotacao: $('o58_coddot').value,
            quantidade: 0,
            valor: 0,
            valororiginal: 0
        };

        var i = 0;
        var itensSelecionados = false;
        var dotacaoAplicada = false;
        var elementoIncompativel = false;
        var elementosIncompativeis = "";

        oGridItens.getRows().forEach(function(oRow) {

            if (oRow.isSelected) {
                if (aItensPosicao[i].elemento != elemento_dotacao) {
                    elementoIncompativel = true;
                    elementosIncompativeis = elementosIncompativeis + aItensPosicao[i].codigoitem + ",";

                }
                itensSelecionados = true;

                aItensPosicao[i].dotacoes.forEach(function(oDotacaoItem) {

                    if (oDotacaoItem.dotacao == oDotacao.dotacao) {
                        dotacaoAplicada = true;

                    }

                });

            }
            i++;

        });

        elementosIncompativeis = elementosIncompativeis.substring(0, elementosIncompativeis.length - 1);


        if (itensSelecionados == false) {
            return alert('Nenhum item selecionado para aplicar Dotação.');
        }

        if (elementoIncompativel == true) {
            return alert('Usuário: Item(ns) ' + elementosIncompativeis + ' possui(em) elemento(s) divergente da Dotação selecionada');
        }

        if (dotacaoAplicada == true) {
            return alert("Erro! Dotação já incluida para o item.");

        }

        var i = 0;


        oGridItens.getRows().forEach(function(oRow) {

            if (oRow.isSelected) {
                aItensPosicao[i].dotacoes.push(oDotacao);
            }
            i++;

        });

        dotacaoIncluida = true;
        return alert('Dotação aplicada aos itens selecionados');


    }

    function apostilar() {

        var oSelecionados = {};
        var iSelecionados = [];

        /**

         * @todo incluir aqui todas as validaes de campos Obrigatórios para o SICOM contratos
         */
        if ($("si03_tipoapostila").value == "00") {
            return alert("Obrigatório informar o  tipo de Apostila.");
        }

        if ($("si03_numapostilamento").value == "") {
            return alert("Obrigatário informar o  Numero Seq. Apostila.");
        }

        if ($("si03_dataapostila").value == "") {
            return alert("Obrigatário informar a data da Apostila.");
        }

        if ($("si03_descrapostila").value == "") {
            return alert("Obrigatório informar a descrição da Apostila.");
        }

        if ($("si03_dataapostila").value == "") {
            return alert("Obrigatório informar a data da Apostila.");
        }

        if ($("si03_descrapostila").value == "") {
            return alert("Obrigatório informar a descrio da Apostila.");
        }

        if ($("si03_datareferencia").value == "" && document.getElementById("trdatareferencia").style.display != 'none') {
            return alert("Obrigatório informar a data de Referencia.");
        }
        if ($("si03_justificativa").value == "" && document.getElementById("justificativa").style.display != 'none') {
            return alert("Usuário: Este contrato  decorrente de Licitação e está utilizando a lei n 14133/2021, sendo assim,  necessário o preenchimento do campo Justificativa.");
        }
        if ($("si03_tipoapostila").value == "01" && !viewAlterar) {
            if ($("si03_percentualreajuste").value == "") {
                return alert("Obrigatório informar o Percentual de Reajuste.");
            }
            if ($("si03_indicereajuste").value == "0" && $("ac26_criterioreajuste").value == "1") {
                return alert("Obrigatório informar o Indice Reajuste.");
            }
            if ($("si03_indicereajuste").value == "6") {
                if ($("ac26_descricaoreajuste").value == "") {
                    return alert("Obrigatório informar a Descrição do Critério de Reajuste.");
                }
            }
        }

        if($("ac26_criterioreajuste").value != "1"){
            if ($("si03_descricaoindice").value == "") {
                return alert("Obrigatório informar a Descrição do Índice.");
            }
        }

        oGridItens.getRows().forEach(function(oRow) {

            if (oRow.isSelected) {
                oSelecionados[oRow.aCells[9].getValue()] = oRow;
                iSelecionados.push(oRow.aCells[1].getValue());
            }
        });

        if (Object.keys(oSelecionados).length == 0 && !viewAlterar) {
            return alert('Nenhum item selecionado para apostilar.');
        }
        var oApostila = new Object();
        oApostila.dataapostila = $("si03_dataapostila").value;
        oApostila.tipoapostila = $("si03_tipoapostila").value;
        oApostila.descrapostila = $("si03_descrapostila").value;
        oApostila.tipoalteracaoapostila = $("si03_tipoalteracaoapostila").value;
        oApostila.numapostilamento = $("si03_numapostilamento").value;
        oApostila.datareferencia = $("si03_datareferencia").value;
        oApostila.justificativa = $("si03_justificativa").value;
        oApostila.percentualreajuste = $("si03_percentualreajuste").value;
        oApostila.indicereajuste = $("si03_indicereajuste").value;
        oApostila.descricaoindice = decodeURIComponent(encodeURIComponent($("si03_descricaoindice").value.replaceAll('"',"")));
        oApostila.descricaoreajuste = decodeURIComponent(encodeURIComponent($("ac26_descricaoreajuste").value.replaceAll('"',"")));
        oApostila.criterioreajuste = $("ac26_criterioreajuste").value;

        var oParam = {
            exec: "processarApostilamento",
            iAcordo: $("ac16_sequencial").value,
            datainicial: $("datainicial").value,
            datafinal: $("datafinal").value,
            oApostila,
            aItens: [],
            aSelecionados: iSelecionados,
            validaDtApostila
        };

        var lAditar = true;
        aItensPosicao.forEach(function(oItem, iIndice) {

            if (!lAditar) {
                return false;
            }

            var oItemAdicionar = {};
            var valoranterior = (oItem.qtdeanterior * oItem.vlunitanterior);
            var valoratual = (oItem.quantidade * oItem.valorunitario);
            var valorApostiladoReal = valoranterior - valoratual;

            oItemAdicionar.codigo = oItem.codigo;
            oItemAdicionar.codigoitem = oItem.codigoitem;
            oItemAdicionar.resumo = encodeURIComponent(tagString(oItem.resumo || ''));
            oItemAdicionar.codigoelemento = oItem.codigoelemento || '';
            oItemAdicionar.unidade = oItem.unidade || '';
            oItemAdicionar.quantidade = oItem.quantidade;
            oItemAdicionar.valorunitario = oItem.valorunitario;
            oItemAdicionar.valorapostilado = valorApostiladoReal;
            oItemAdicionar.dtexecucaoinicio = oItem.periodoini;
            oItemAdicionar.dtexecucaofim = oItem.periodofim;



            if (oSelecionados[iIndice] != undefined) {
                oItemAdicionar.quantidade = js_strToFloat(oSelecionados[iIndice].aCells[5].getValue());
                oItemAdicionar.valorunitario = js_strToFloat(oSelecionados[iIndice].aCells[6].getValue());
                oItemAdicionar.valor = oItemAdicionar.quantidade * oItemAdicionar.valorunitario;
                var valorApostiladoReal = oItemAdicionar.valor - (oItem.quantidade * oItem.valorunitario);
                oItemAdicionar.valorapostilado = valorApostiladoReal;
                oItemAdicionar.dtexecucaoinicio = oSelecionados[iIndice].aCells[10].getValue();
                oItemAdicionar.dtexecucaofim = oSelecionados[iIndice].aCells[11].getValue();
                oItemAdicionar.tipoalteracaoitem = oSelecionados[iIndice].aCells[14].getValue();


                /**
                 * Validamos o total do item com as dotacoes
                 */
                var nValorDotacao = Number(0);

                oItem.dotacoes.forEach(function(oDotacao) {

                    /**
                     * Removido validacao de inclusao de dotacao zerada conforme solicitado na OC 3855
                     */
                    /*if (oDotacao.valor == 0) {

                        lAditar = false;
                        return alert("Os Valores das Dotações para o item " + oItem.descricaoitem.urlDecode() + " no podem estar zeradas.");
                    }*/
                    nValorDotacao += Number(oDotacao.valor);
                });

                if (lAditar && nValorDotacao.toFixed(2) != oItemAdicionar.valor.toFixed(2)) {

                    lAditar = false;
                    return alert("O valor da soma das Dotações do item " + oItem.descricaoitem.urlDecode() + " deve ser igual ao Valor Total do item.");
                }

                oItemAdicionar.dotacoes = oItem.dotacoes;


            } else {
                oItemAdicionar.dotacoes = oItem.dotacoes;
            }

            oParam.aItens.push(oItemAdicionar);
        });


        if (dotacaoIncluida == false && $("si03_tipoapostila").value == "03" && !viewAlterar) {
            return alert("Usuário:  necessário a inserção de Dotação em no mínimo um item.");
        }

        if (viewAlterar) {
            alteraApostilamento(oApostila, oParam.aItens, iSelecionados);
            return
        }


        if (!lAditar) {
            return false;
        }

        new AjaxRequest(sUrlRpc, oParam, function(oRetorno, lErro) {

                if (lErro) {
                    if (oRetorno.datareferencia) {
                        validaDtApostila = false;
                        document.getElementById("trdatareferencia").style.display = 'contents';
                    }
                    return alert(oRetorno.message.urlDecode());

                }

                alert("Apostilamento realizado com sucesso.");
                js_limparCampos();
                js_pesquisaac16_sequencial(true);
            }).setMessage("Aguarde, apostilando contrato.")
            .execute();
    }

    function js_indicereajuste() {

        if ($("si03_indicereajuste").value == 6) {
            document.getElementById("tr_descricaoreajuste").style.display = '';
            return;
        } 

        document.getElementById("tr_descricaoreajuste").style.display = 'none';
        $("tr_descricaoreajuste").value = "";
        
    }

    function js_changeTipoApostila(iTipo) {
        if (iTipo == "03" && (tipoApostilaInicial == "01" || tipoApostilaInicial == "02")) {
            iTipo = tipoApostilaInicial;

            $('si03_tipoapostila').value = tipoApostilaInicial;
            alert("Não é permitido alterar para este tipo de apostila.");
        }

        if (iTipo == "03") {

            oGridItens.aHeaders[10].lDisplayed = true;
            oGridItens.aHeaders[5].lDisplayed = true;
            document.getElementById("si03_tipoalteracaoapostila").disabled = true;

        } else if (iTipo == "00") {
            document.getElementById("si03_tipoalteracaoapostila").disabled = true;

        } else {
            document.getElementById("si03_tipoalteracaoapostila").disabled = false;
            oGridItens.aHeaders[10].lDisplayed = false;
            oGridItens.aHeaders[5].lDisplayed = false;
        }

        if (iTipo == "01") {
            document.getElementById('trreajuste').style.display = "";
            document.getElementById('tr_criterioreajuste').style.display = "";
        } else {
            document.getElementById('trreajuste').style.display = "none";
            document.getElementById('tr_criterioreajuste').style.display = "none";
            $("si03_percentualreajuste").value = "";
            $("si03_indicereajuste").options[0].selected = true;
        }


        aItensPosicao.forEach(function(oItem, iIndice) {
            if (iTipo == "03") {

                $("si03_tipoalteracaoapostila").value = 3;
                document.getElementById("si03_tipoalteracaoapostila").options[0].disabled = true;
                document.getElementById("si03_tipoalteracaoapostila").options[1].disabled = true;
                document.getElementById("si03_tipoalteracaoapostila").options[2].disabled = false;
                document.getElementById('valorunitario' + iIndice).addClassName('readonly');
                document.getElementById('valorunitario' + iIndice).readOnly = true;
                document.getElementById('edicaoBloco').style.display = "";

                document.getElementById('oGridItensrow' + iIndice + 'cell9').style.display = "";
                document.getElementById('col11').style.display = "";

            }  else if(iTipo == "04" || iTipo == "05" || iTipo == "99"){
                document.getElementById("si03_tipoalteracaoapostila").options[0].disabled = true;
                document.getElementById("si03_tipoalteracaoapostila").options[1].disabled = true;
                document.getElementById("si03_tipoalteracaoapostila").options[2].disabled = false;
                $("si03_tipoalteracaoapostila").value = 3;
                document.getElementById("si03_tipoalteracaoapostila").disabled = true;
                document.getElementById('valorunitario' + iIndice).addClassName('readonly');
                document.getElementById('valorunitario' + iIndice).readOnly = true;
                document.getElementById('oGridItensrow' + iIndice + 'cell9').style.display = "";
                document.getElementById('col11').style.display = "";
            }
            else {
                $("si03_tipoalteracaoapostila").value = 1;
                document.getElementById("si03_tipoalteracaoapostila").options[0].disabled = false;
                document.getElementById("si03_tipoalteracaoapostila").options[1].disabled = false;
                document.getElementById("si03_tipoalteracaoapostila").options[2].disabled = true;

            }

            if (iTipo == "01" || iTipo == "02") {
                document.getElementById('valorunitario' + iIndice).removeClassName('readonly');
                document.getElementById('valorunitario' + iIndice).readOnly = false;
                document.getElementById('edicaoBloco').style.display = "none";

                document.getElementById('oGridItensrow' + iIndice + 'cell9').style.display = "none";
                document.getElementById('col11').style.display = "none";

            }

        });
    }

    function js_limparCampos() {
        $("ac16_sequencial").value = "";
        $("si03_dataapostila").value = "";
        $("si03_tipoapostila").value = "";
        $("si03_descrapostila").value = "";
        $("si03_tipoalteracaoapostila").value = 1;
        $("si03_numapostilamento").value = "";
        $("si03_datareferencia").value = "";
        document.getElementById("trdatareferencia").style.display = 'none';
    }

    if (viewAlterar) {
        js_acordosc_apostilamentos(true);
    } else {
        js_pesquisaac16_sequencial(true);
    }

    function js_acordosc_apostilamentos(lMostrar) {
        if (lMostrar == true) {
            var sUrl = 'func_acordonovo.php?viewalterar=true&funcao_js=parent.js_mostraacordoultimaposicao|ac16_sequencial|ac16_resumoobjeto|ac16_dataassinatura';
            js_OpenJanelaIframe('top.corpo',
                'db_iframe_acordo',
                sUrl,
                'Pesquisar Acordo',
                true);
            return;
        }

        if ($('ac16_sequencial').value != '') {

            var sUrl = 'func_acordonovo.php?viewalterar=true&pesquisa_chave=' + $('ac16_sequencial').value +
                '&funcao_js=parent.js_mostraacordo';

            js_OpenJanelaIframe('top.corpo',
                'db_iframe_acordo',
                sUrl,
                'Pesquisar Acordo',
                false);
            return
        }
        $('ac16_sequencial').value = '';

    }

    function js_mostraacordoultimaposicao(ac16_sequencial,ac16_resumoobjeto,ac16_dataassinatura) {

        var oParam = {
            exec: 'getleilicitacao',
            licitacao: ac16_sequencial
        }

        new AjaxRequest(sUrlRpc, oParam, function(oRetorno, lErro) {
            if (oRetorno.lei == 1) {
                    $('justificativa').style.display = '';
                } else {
                    $('justificativa').style.display = 'none';
                }

            }).setMessage("Aguarde, pesquisando acordos.")
            .execute();
        $('ac16_sequencial').value = ac16_sequencial;
        $('ac16_resumoobjeto').value = ac16_resumoobjeto;

        pesquisarDadosAcordoAlteracao(ac16_sequencial);
        db_iframe_acordo.hide();
    }

    function pesquisarDadosAcordoAlteracao(iAcordo) {

        if (iAcordo == "") {
            alert('Acordo Não informado!');
            return false;
        }
        const oParam = {
            exec: 'getDadosAlteracao',
            iAcordo: iAcordo
        }

        new AjaxRequest(sUrlRpc, oParam, function(oRetorno, lErro) {

                if (lErro) {
                    alert(oRetorno.message.urlDecode());
                    return js_acordosc_apostilamentos(true);
                }

                $('btnSalvar').disabled = false;

                numApostilaInicial = oRetorno.dadosAcordo.ac26_numeroapostilamento;
                $('si03_numapostilamento').value = numApostilaInicial;
                $('si03_tipoalteracaoapostila').value = oRetorno.dadosAcordo.si03_tipoalteracaoapostila;
                tipoApostilaInicial = "0" + oRetorno.dadosAcordo.si03_tipoapostila;
                $('si03_tipoapostila').value = tipoApostilaInicial;
                $('si03_dataapostila').value = oRetorno.dadosAcordo.si03_dataapostila;
                $('si03_descrapostila').value = oRetorno.dadosAcordo.si03_descrapostila;
                $('si03_datareferencia').value = oRetorno.dadosAcordo.si03_datareferencia;
                $('si03_justificativa').value = oRetorno.dadosAcordo.si03_justificativa;
                $('ac26_descricaoreajuste').value = oRetorno.dadosAcordo.ac26_descricaoreajuste;
                $('ac26_criterioreajuste').value = oRetorno.dadosAcordo.ac26_criterioreajuste;
                $("si03_indicereajuste").value = oRetorno.dadosAcordo.si03_indicereajuste;
                si03_sequencial = oRetorno.dadosAcordo.si03_sequencial;
                js_changeTipoApostila(tipoApostilaInicial);
                js_indicereajuste($("si03_indicereajuste").value);
                js_changeCriterioReajuste($("ac26_criterioreajuste").value);

                validaDadosAcordo(oRetorno);

                aItensPosicao = oRetorno.itens;

                preencheItens(aItensPosicao);

                if ( tipoApostilaInicial == "03") {
                    js_changeTipoApostila(tipoApostilaInicial);
                }

            }).setMessage("Aguarde, pesquisando acordos.")
            .execute();
    }

    function validaDadosAcordo(oRetorno) {
        const tipoApostila = $('si03_tipoapostila').value;

        document.getElementById('trreajuste').style.display = "none";
        $("si03_percentualreajuste").value = "";
        $("si03_indicereajuste").options[0].selected = true;
        document.getElementById("si03_tipoalteracaoapostila").disabled = false;

        if (tipoApostila == "01") {
            document.getElementById('trreajuste').style.display = "";
            $("si03_percentualreajuste").value = oRetorno.dadosAcordo.si03_percentualreajuste;
            let si03_indicereajuste = oRetorno.dadosAcordo.si03_indicereajuste;
            $("si03_indicereajuste").options[si03_indicereajuste].selected = true;

        }

        if (tipoApostila == "03") {
            document.getElementById("si03_tipoapostila").disabled = true;
            document.getElementById("si03_tipoalteracaoapostila").disabled = true;

        }
    }

    function alteraApostilamento(oApostila, listaItens, indicesSelecionados) {

        let updateNumApostilamento = $('si03_numapostilamento').value != numApostilaInicial ? true : false;

        const apostilamento = {
            si03_sequencial,
            si03_tipoapostila:  oApostila.tipoapostila,
            si03_tipoalteracaoapostila: oApostila.tipoalteracaoapostila,
            si03_numapostilamento: $('si03_numapostilamento').value,
            si03_dataapostila: oApostila.dataapostila,
            si03_descrapostila: oApostila.descrapostila,
            si03_percentualreajuste: oApostila.percentualreajuste,
            si03_indicereajuste: oApostila.indicereajuste,
            si03_datareferencia: $('si03_datareferencia').value,
            si03_justificativa: $('si03_justificativa').value,
            si03_descricaoreajuste: oApostila.descricaoreajuste,
            si03_descricaoindice: oApostila.descricaoindice,
            si03_criterioreajuste: oApostila.criterioreajuste,
            updateNumApostilamento
        }

        const itens = filtraAcordosSelecionados(listaItens, indicesSelecionados);

        const oParam = {
            exec: 'updateApostilamento',
            apostilamento,
            iAcordo: $('ac16_sequencial').value,
            itens,
            validaDtApostila
        }

        new AjaxRequest(sUrlRpc, oParam, function(oRetorno, lErro) {

            if (lErro) {
                if (oRetorno.datareferencia) {
                    validaDtApostila = false;
                    document.getElementById("trdatareferencia").style.display = 'contents';
                }
                return alert(oRetorno.message.urlDecode());
            }
            alert("Apostilamento alterado com sucesso!");

           return js_acordosc_apostilamentos(true);
        }).setMessage("Processando apostilamento")
        .execute();

    }

    function filtraAcordosSelecionados(listaItens, indicesSelecionados) {
        const itensSelecionados = new Array();
        indicesSelecionados.forEach((indice) => {
            let resultado = listaItens.filter((item)=> {
            return item.codigoitem == indice;
            });
            itensSelecionados.push(resultado[0]);
        });

        return itensSelecionados;
    }

    function js_changeCriterioReajuste(criterioReajuste){
        if(criterioReajuste == "1"){
            document.getElementById('si03_indicereajuste').style.display = "";
            document.getElementById('indicereajuste').style.display = "";
            document.getElementById('tr_descricaoindice').style.display = "none";
            document.getElementById('si03_descricaoindice').value = "";
            return;
        }
        document.getElementById('si03_indicereajuste').style.display = "none";
        document.getElementById('indicereajuste').style.display = "none";
        document.getElementById('tr_descricaoindice').style.display = "";
        document.getElementById('si03_indicereajuste').value = "0";
        document.getElementById('ac26_descricaoreajuste').value = "";
        document.getElementById("tr_descricaoreajuste").style.display = 'none';
    }
</script>
