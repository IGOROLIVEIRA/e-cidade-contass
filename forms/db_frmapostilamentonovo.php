<?
//MODULO: sicom
$clapostilamento->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("ac16_sequencial");
$clrotulo->label("ac16_resumoobjeto");
?>
<fieldset style="width: 60%; margin-left:10px; margin-top: 25px;">
    <legend><b>Apostilamento</b></legend>
    <form name="form1" method="post" action="">

        <table border="0" style="margin-right: 10px">
            <tr>
                <td title="<?= @$Tac16_sequencial ?>">
                    <?php db_ancora($Lac16_sequencial, "js_pesquisaac16_sequencial(true);", $db_opcao); ?>
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
                    db_input('ac16_resumoobjeto', 40, $Iac16_resumoobjeto, true, 'text', 3);
                    ?>
                </td>

                <td title="<?= @$Tsi03_dataassinacontrato ?>">
                    <?= @$Lsi03_dataassinacontrato ?>
                    <?
                    db_inputdata('si03_dataassinacontrato', @$si03_dataassinacontrato_dia, @$si03_dataassinacontrato_mes, @$si03_dataassinacontrato_ano, true, 'text', 3, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td title="<?= @$Tsi03_numapostilamento ?>">
                    <?= @$Lsi03_numapostilamento ?>
                </td>
                <td>
                    <?
                    db_input('si03_numapostilamento', 2, $Isi03_numapostilamento, true, 'text', $db_opcao, "")
                    ?>

                    <?= @$Lsi03_dataapostila ?>

                    <?
                    db_inputdata('si03_dataapostila', @$si03_dataapostila_dia, @$si03_dataapostila_mes, @$si03_dataapostila_ano, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap>
                    <?= @$Lsi03_tipoapostila ?>
                </td>
                <td>
                    <?
                    $x = array("01" => "Reajuste de preço previsto no contrato", "02" => "Atualizações, compensações ou penalizações", "03" => "Empenho de dotações orçamentárias suplementares");
                    db_select('si03_tipoapostila', $x, true, $db_opcao, "onchange='js_changeTipoApostila(this.value)'");
                    //db_input('si03_tipoapostila',1,$Isi03_tipoapostila,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>

            <tr>
                <td nowrap nowrap title="<?= @$Tsi03_descrapostila ?>">
                    <?= @$Lsi03_descrapostila ?>
                </td>
                <td>
                    <?
                    db_textarea('si03_descrapostila', 4, 40, $Isi03_descrapostila, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap nowrap title="<?= @$Tsi03_tipoalteracaoapostila ?>">
                    <?= @$Lsi03_tipoalteracaoapostila ?>
                </td>
                <td>
                    <?
                    $x = array("1" => "Acréscimo de valor", "2" => "Decréscimo de valor", "3" => "Não houve alteração de valor");
                    db_select('si03_tipoalteracaoapostila', $x, true, $db_opcao, "");
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
            //db_input('controle',10,$Icontrole,true,'hidden',$db_opcao,"")
            ?>
            <tr>
                <td colspan='2'>
                    <fieldset class="separator">
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
            </tr>

            <tr>
                <td colspan='2'>
                    <fieldset class="separator">
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
    sUrlRpc = 'con4_contratoapostilamento.RPC.php';
    aItensPosicao = new Array();
    oGridItens = new DBGrid('oGridItens');
    oGridItens.nameInstance = 'oGridItens';
    oGridItens.setCheckbox(0);
    oGridItens.setCellAlign(['center', 'left', "right", "right", "right", "right", "center", "right", "center", "center", "center", "center", "center"]);
    oGridItens.setCellWidth(["3%", "25%", "8%", "8%"]);
    oGridItens.setHeader(["Cód", "Item", "Qtde Anterior", "Vl Unit Anterior", "Quantidade", "Vl Unitário", "Vl Total", "Vl Apostilado", "Qt Aditada", "Dotações", "Seq"]);
    oGridItens.aHeaders[11].lDisplayed = false;
    oGridItens.aHeaders[9].lDisplayed = false;
    oGridItens.setHeight(300);
    oGridItens.show($('ctnGridItens'));

    var opcao = document.form1.controle.value;

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
            $('si03_dataassinacontrato').value = '';
            $('ac16_sequencial').focus();
        } else {

            $('ac16_sequencial').value = chave1;
            $('ac16_resumoobjeto').value = chave2;
            $('si03_dataassinacontrato').value = chave3.substr(8, 2) + '/' + chave3.substr(5, 2) + '/' + chave3.substr(0, 4);
            pesquisarDadosAcordo(chave1);
        }
    }

    /**
     * Retorno da pesquisa acordos
     */
    function js_mostraacordo1(chave1, chave2, chave3) {
        $('ac16_sequencial').value = chave1;
        $('ac16_resumoobjeto').value = chave2;

        $('si03_dataassinacontrato').value = chave3.substr(8, 2) + '/' + chave3.substr(5, 2) + '/' + chave3.substr(0, 4);
        pesquisarDadosAcordo(chave1);
        db_iframe_acordo.hide();
    }

    function pesquisarDadosAcordo(iAcordo) {

        if (iAcordo == "") {

            alert('Acordo não informado!');
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

                /*aItensPosicao.each(function (oItem, iLinha) {
                    me.salvarInfoDotacoes(iLinha);
                });*/

            }).setMessage("Aguarde, pesquisando acordos.")
            .execute();
    }

    function preencheItens(aItens) {

        oGridItens.clearAll(true);

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

            oGridItens.addRow(aLinha, false, false, false);

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
        sContent += "<fieldset><legend>Adicionar Dotação</legend>";
        sContent += "  <table>";
        sContent += "   <tr>";
        sContent += "     <td>";
        sContent += "     <a href='#' class='dbancora' style='text-decoration: underline;'";
        sContent += "       onclick='pesquisao47_coddot(true);'><b>Dotação:</b></a>";
        sContent += "     </td>";
        sContent += "     <td id='inputdotacao'></td>";
        sContent += "     <td>";
        sContent += "      <b>Saldo Dotação:</b>";
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
        oTxtDotacao.setReadOnly(true);

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
        oGridDotacoes.setHeader(["Dotação", "Valor", "&nbsp;"]);
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
     * Atualiza a informação das dotações do item
     */
    function atualizarItemDotacao(iLinha, iDotacao, oValor) {

        aItensPosicao[iLinha].dotacoes[iDotacao].valor = oValor.value.getNumber();
        aItensPosicao[iLinha].dotacoes[iDotacao].quantidade = js_round((oValor.value.getNumber() / aItensPosicao[iLinha].valorunitario), 2);

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

        if (confirm("Remover dotação do item?")) {

            aItensPosicao[iLinha].dotacoes.splice(iDotacao, 1);
            preencheGridDotacoes(iLinha);
        }
    }

    function saveDotacao(iLinha) {

        if (oTxtDotacao.getValue() == "") {

            alert("Campo dotação é de preenchimento obrigatório.");
            js_pesquisao47_coddot(true);
            return false;
        }

        var nValor = js_strToFloat(oTxtValorDotacao.getValue());

        /**
         * Removido validacao de inclusao de dotacao zerada conforme solicitado na OC 3855
         */
        /*if (nValor == 0) {

            alert('Campo Valor é de preenchimento obrigatório.');
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
        js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_saldos', arq, 'Saldo da dotação', true);
        $('Jandb_iframe_saldos').style.zIndex = '1500000';
    }

    /**
     * calcula os valores da dotação conforme o valor modificado pelo usuario
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

    function pesquisao47_coddot(mostra) {

        query = '';
        if (iElementoDotacao != '') {
            query = "elemento=" + iElementoDotacao + "&";
        }

        if (mostra == true) {
            js_OpenJanelaIframe('',
                'db_iframe_orcdotacao',
                'func_permorcdotacao.php?' + query + 'funcao_js=parent.mostraorcdotacao1|o58_coddot',
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

    function mostraorcdotacao1(chave1) {

        oTxtDotacao.setValue(chave1);
        db_iframe_orcdotacao.hide();
        $('Jandb_iframe_orcdotacao').style.zIndex = '0';
        $('oTxtValorDotacao').focus();
        getSaldoDotacao(chave1);
    }

    function apostilar() {

        var oSelecionados = {};
        var iSelecionados = [];

        /**
         * @todo incluir aqui todas as validações de campos obrigatórios para o SICOM contratos
         */

        if ($("si03_numapostilamento").value == "") {
            return alert("Obrigatório informar o  Numero Seq. Apostila.");
        }

        if ($("si03_dataapostila").value == "") {
            return alert("Obrigatório informar a data da Apostila.");
        }

        if ($("si03_descrapostila").value == "") {
            return alert("Obrigatório informar a descrição da Apostila.");
        }

        oGridItens.getRows().forEach(function(oRow) {

            if (oRow.isSelected) {
                oSelecionados[oRow.aCells[9].getValue()] = oRow;
                iSelecionados.push(oRow.aCells[1].getValue());
            }
        });

        if (Object.keys(oSelecionados).length == 0) {
            return alert('Nenhum item selecionado para apostilar.');
        }
        var oApostila = new Object();
        oApostila.dataapostila = $("si03_dataapostila").value;
        oApostila.tipoapostila = $("si03_tipoapostila").value;
        oApostila.descrapostila = encodeURIComponent(tagString($("si03_descrapostila").value));
        oApostila.tipoalteracaoapostila = $("si03_tipoalteracaoapostila").value;
        oApostila.numapostilamento = $("si03_numapostilamento").value;

        var oParam = {
            exec: "processarApostilamento",
            iAcordo: $("ac16_sequencial").value,
            datainicial: $("datainicial").value,
            datafinal: $("datafinal").value,
            oApostila,
            aItens: [],
            aSelecionados: iSelecionados
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
                        return alert("Os Valores das dotações para o item " + oItem.descricaoitem.urlDecode() + " não podem estar zeradas.");
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

        if (!lAditar) {
            return false;
        }

        new AjaxRequest(sUrlRpc, JSON.stringify(oParam), function(oRetorno, lErro) {

                if (lErro) {
                    return alert(oRetorno.message.urlDecode());
                }

                alert("Apostilamento realizado com sucesso.");
                js_limparCampos();
                js_pesquisaac16_sequencial(true);
            }).setMessage("Aguarde, apostilando contrato.")
            .execute();
    }

    function js_changeTipoApostila(iTipo) {
        aItensPosicao.forEach(function(oItem, iIndice) {

            if (iTipo == "03") {
                $("si03_tipoalteracaoapostila").value = 3;
                document.getElementById("si03_tipoalteracaoapostila").options[0].disabled = true;
                document.getElementById("si03_tipoalteracaoapostila").options[1].disabled = true;
                document.getElementById("si03_tipoalteracaoapostila").options[2].disabled = false;
                document.getElementById('valorunitario' + iIndice).addClassName('readonly');
                document.getElementById('valorunitario' + iIndice).readOnly = true;
            } else {
                $("si03_tipoalteracaoapostila").value = 1;
                document.getElementById("si03_tipoalteracaoapostila").options[0].disabled = false;
                document.getElementById("si03_tipoalteracaoapostila").options[1].disabled = false;
                document.getElementById("si03_tipoalteracaoapostila").options[2].disabled = true;
            }

            if (iTipo == "01" || iTipo == "02") {
                document.getElementById('valorunitario' + iIndice).removeClassName('readonly');
                document.getElementById('valorunitario' + iIndice).readOnly = false;
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
    }
    js_changeTipoApostila();
    js_pesquisaac16_sequencial(true);
</script>
