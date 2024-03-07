<form name="form1" method="post" action="" enctype="multipart/form-data">
    <center>
        <table border="0" style="width: 80%; align:center;">
            <tr>
                <td>
                    <fieldset>
                        <center>
                            <table>
                                <tr>
                                    <td>
                                        <?php db_ancora('Orçamento: ', 'pesquisaOrcamento(true);', 1); ?>
                                    </td>
                                    <td>
                                        <?php
                                            db_input('pc20_codorc', 12, 1, true, 'text', 1, " onChange='pesquisaOrcamento(false);'");
                                        ?>
                                    </td>
                                    <td>
                                        <?php db_ancora('Processo de Compra: ', 'pesquisaProcessoCompra(true);', 1); ?>
                                    </td>
                                    <td>
                                        <?php
                                            db_input('pc80_codproc', 12, 1, true, 'text', 1, " onChange='pesquisaProcessoCompra(false);'");
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            db_ancora('<b>Licitação:</b>', 'pesquisaLicitacao(true);', 1);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            db_input('l20_codigo', 12, '', true, 'text', 1, "onchange='pesquisaLicitacao(false);'");
                                        ?>
                                    </td>
                                </tr>
                            </table>
                            <input style="margin-top:10px;" type='button' value="Processar" onclick="processar();" />
    
                        </center>
                    </fieldset>
                </td>
            </tr>
        </table>
        <table border="0" style="width: 80%; align:center;">
            <tr>
                <td>
                    <fieldset>
                        <table>
                            <tr>
                                <td nowrap title="">
                                    <b>Prazo Limite para Entrega do Orçamento: </b>
                                </td>
                                <td>
                                    <?php
                                        db_inputdata('pc20_dtate', '', '', '', true, 'text', 1);
                                    ?>
                                </td>
                                <td nowrap title="">
                                    <b>Prazo de Entrega do Produto: </b>
                                </td>
                                <td>
                                    <?php
                                        db_input('pc20_prazoentrega', 11, 1, true, 'text', 1, '');
                                    ?>
                                </td>
                                <td>
                                    <b>Cotação Prévia:</b>
                                    <?php
                                    $aCotacaoPrevia = [0 => '', 1 => 'Sim', 2 => 'Não'];
                                    db_select('pc20_cotacaoprevia', $aCotacaoPrevia, true, 1, '', '');
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap title="">
                                    <b>Hora Limite para Entrega do Orçamento: </b>
                                </td>
                                <td>
                                    <?php
                                        db_input('pc20_hrate', 30, 1, true, 'time', 1, '', '', '', 'width:62%;', null);
                                    ?>
                                </td>
                                <td nowrap title="">
                                    <b>Validade do Orçamento: </b>
                                </td>
                                <td>
                                    <?php
                                        db_input('pc20_validadeorcamento', 11, 1, true, 'text', 1, '');
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <fieldset style="margin-top: 20px;">
                                        <legend>
                                            <b>Observação</b>
                                        </legend>
                                        <?php
                                            db_textarea('pc20_obs', 5, 144, 0, true, 'text', 1, '');
                                        ?>
                                    </fieldset>
                                </td>
                            </tr>
                        </table>
                        <div style="margin-top:10px;" id='gridItensOrcamento'></div>

                    </fieldset>
                <td>
            </tr>
        </table>
    </center>
</form>
<script type="text/javascript">

    const oGridItensOrcamento          = new DBGrid('gridItensOrcamento');
    oGridItensOrcamento.nameInstance = 'oGridProcessoCompra';
    oGridItensOrcamento.setCellWidth( [ '5%', '5%', '25%','15%','10%','10%','10%', '10%', '10%'] );
    oGridItensOrcamento.setHeader( [ 'Item', 'Código', 'Descrição','Marca','Quantidade','Qtde. Orçada','Porcentagem','Valor Unit.','Valor Total'] );
    oGridItensOrcamento.setCellAlign( [ 'center', 'center', 'left','left','center','center','center','center','center'] );
    oGridItensOrcamento.setHeight(130);
    //oGridItensOrcamento.aHeaders[0].lDisplayed = false;
    oGridItensOrcamento.show($('gridItensOrcamento'));
    oGridItensOrcamento.renderRows();

    function pesquisaLicitacao(mostra) {

        if (mostra) {
            js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_liclicita',
                'func_liclicita.php?funcao_js=parent.preencheLicitacao|l20_codigo',
                'Pesquisa', true);

            return true;
        }

        if (document.form1.l20_codigo.value != '') {
            js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_liclicita',
                'func_liclicita.php?pesquisa_chave=' + $F('l20_codigo') + '&funcao_js=parent.preencheLicitacao',
                'Pesquisa', false);
            return true;
        }

        document.form1.l20_codigo.value = '';
        return false;

    }

    function preencheLicitacao(codigoLicitacao, erro) {

        if (erro === undefined) {
            document.form1.l20_codigo.value = codigoLicitacao;
            document.form1.pc20_codorc.value = '';
            document.form1.pc80_codproc.value = '';
            db_iframe_liclicita.hide();
            return true;
        }

        if (erro) {
            document.form1.l20_codigo.value = '';
            return false;
        }

    }

    function pesquisaProcessoCompra(mostra) {

        if (mostra) {
            js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_pcproc',
                'func_pcproc.php?funcao_js=parent.preencheProcessoCompra|pc80_codproc',
                'Pesquisa', true);

            return true;
        }

        if (document.form1.pc80_codproc.value != '') {
            js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_pcproc',
                'func_pcproc.php?pesquisa_chave=' + $F('pc80_codproc') + '&funcao_js=parent.preencheProcessoCompra',
                'Pesquisa', false);
            return true;
        }

        document.form1.pc80_codproc.value = '';
        return false;

    }

    function preencheProcessoCompra(codigoProcesso, erro) {

        if (erro === undefined) {
            document.form1.pc80_codproc.value = codigoProcesso;
            document.form1.pc20_codorc.value = '';
            document.form1.l20_codigo.value = '';
            db_iframe_pcproc.hide();
            return true;
        }

        if (erro === "") {
            document.form1.pc80_codproc.value = '';
            return false;
        }

    }

    function pesquisaOrcamento(mostra) {

        if (mostra) {
            js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_pcorcam',
                'func_pcorcam.php?funcao_js=parent.preencheOrcamento|pc20_codorc',
                'Pesquisa', true);

            return true;
        }

        if (document.form1.pc20_codorc.value != '') {
            js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_pcorcam',
                'func_pcorcam.php?pesquisa_chave=' + $F('pc20_codorc') + '&funcao_js=parent.preencheOrcamento',
                'Pesquisa', false);
            return true;
        }

        document.form1.pc20_codorc.value = '';
        return false;

    }

    function preencheOrcamento(codigoOrcamento, erro) {

        if (erro === undefined) {
            document.form1.pc20_codorc.value = codigoOrcamento;
            document.form1.pc80_codproc.value = '';
            document.form1.l20_codigo.value = '';
            db_iframe_pcorcam.hide();
            return true;
        }

        if (erro) {
            document.form1.pc20_codorc.value = '';
            return false;
        }

    }

    function processar() {

        let codigoOrcamento = document.getElementById("pc20_codorc").value;
        let codigoProcessoCompra = document.getElementById("pc80_codproc").value;
        let codigoLicitacao = document.getElementById("l20_codigo").value;

        if (codigoOrcamento == "" && codigoProcessoCompra == "" && codigoLicitacao == "") {          
            return alert("Nenhum orçamento selecionado! Selecione pelo menos um Orçamento ou Processo.");
        }

        let oParametros = new Object();
        oParametros.sequencial = document.getElementById("l20_codigo").value;
        let oAjax = new Ajax.Request('m4_manutencaoorcamento.RPC.php', {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParametros),
            onComplete: retornoProcessamento

        });

    }

    function retornoProcessamento(oAjax) {

        let oRetorno = eval("(" + oAjax.responseText + ")");
        if (oRetorno.status == 1) {
            oGridItensOrcamento.clearAll(true);

            document.getElementById('pc20_dtate').value = oRetorno.dataorcamento;
            document.getElementById('pc20_hrate').value = oRetorno.horadoorcamento;
            document.getElementById('pc20_prazoentrega').value = oRetorno.prazoentrega;
            document.getElementById('pc20_validadeorcamento').value = oRetorno.validade;
            document.getElementById('pc20_cotacaoprevia').value = oRetorno.cotacaoprevia;
            document.getElementById('pc20_obs').value = oRetorno.observacao.urlDecode();

            oRetorno.itens.each(function (oItem, iItem) {
                let aLinha = [];
                aLinha.push(oItem.item);
                aLinha.push(oItem.codigo);
                aLinha.push(oItem.descricao);
                aLinha.push(oItem.marca);
                aLinha.push(oItem.qtddorcada);
                aLinha.push(oItem.qtddsolicitada);
                aLinha.push("TESTE");
                aLinha.push(oItem.vlrun);
                aLinha.push(oItem.vlrtotal);
                oGridItensOrcamento.addRow(aLinha);

            });
            oGridItensOrcamento.renderRows();

        }
    }

</script>