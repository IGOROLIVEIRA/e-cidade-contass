<form id="form1" name="form1" method="post" action="" enctype="multipart/form-data">
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
                                    <td style="display:none;">
                                        <?php
                                            db_input('codigoorcamento', 12, 1, true, 'text', 1, '');
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
        <table border="0" style="width: 80%; align:center;display:none;" id="tableDadosOrcamento">
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
                                        db_input('pc20_hrate', 30, 0, true, 'time', 1, '', '', '', 'width:62%;', null);
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
                        <div style="margin-top:10px;" id='gridItensOrcamento'>
                        </div>
                        <center>
                            <input style="margin-top:10px;" type='button' value="Salvar" onclick="salvar();" />
                        </center>
                    </fieldset>
                <td>
            </tr>
        </table>
    </center>
</form>
<script type="text/javascript">

    const oGridItensOrcamento          = new DBGrid('gridItensOrcamento');
    oGridItensOrcamento.nameInstance = 'oGridProcessoCompra';
    oGridItensOrcamento.setCellWidth( [ '0%','0%','5%', '5%', '20%','20%','10%','10%','10%', '10%', '10%'] );
    oGridItensOrcamento.setHeader( [ '','','Item', 'Código', 'Descrição','Marca','Quantidade','Qtde. Orçada','Porcentagem','Valor Unit.','Valor Total'] );
    oGridItensOrcamento.setCellAlign( [ 'center','center','center', 'center', 'left','left','center','center','center','center','center'] );
    oGridItensOrcamento.setHeight(130);
    oGridItensOrcamento.aHeaders[0].lDisplayed = false;
    oGridItensOrcamento.aHeaders[1].lDisplayed = false;
    oGridItensOrcamento.show($('gridItensOrcamento'));
    
    var criterioAdjudicacao = "";

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

    function getOrigemOrcamento(){

        if(document.getElementById("pc20_codorc").value != ""){
            return "orcamento";
        }

        if(document.getElementById("l20_codigo").value != ""){
            return "licitacao";
        }

        if(document.getElementById("pc80_codproc").value != ""){
            return "processocompra";
        }

        return "";
    }

    function processar() {

        let aSequencialOrigemOrcamento = {
            "orcamento": document.getElementById("pc20_codorc").value,
            "licitacao": document.getElementById("l20_codigo").value,
            "processocompra": document.getElementById("pc80_codproc").value
        }

        let origemOrcamento = getOrigemOrcamento();

        if(origemOrcamento == ""){
            return alert("Nenhum orçamento selecionado! Selecione pelo menos um Orçamento ou Processo.");
        }

        let sequencial = aSequencialOrigemOrcamento[origemOrcamento];

        let oParametros = new Object();
        oParametros.sExecuta = "processar";
        oParametros.origemOrcamento = origemOrcamento;
        oParametros.sequencial = sequencial;

        js_divCarregando('Carregando dados do orçamento...', 'msgBox');

        let oAjax = new Ajax.Request('m4_manutencaoorcamento.RPC.php', {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParametros),
            onComplete: retornoProcessamento

        });

    }

    function retornoProcessamento(oAjax) {

        js_removeObj('msgBox');

        let oRetorno = JSON.parse(oAjax.responseText);

        if(oRetorno.status == 2){
            limparCampos(oGridItensOrcamento);
            return alert(oRetorno.erro.urlDecode());
        }

        document.getElementById("tableDadosOrcamento").style.display = "";
        criterioAdjudicacao = oRetorno.dados[0].criterioadjudicacao;

        if (oRetorno.status == 1) {

            oGridItensOrcamento.clearAll(true);

            document.getElementById('codigoorcamento').value = oRetorno.dados[0].codigoorcamento;
            document.getElementById('pc20_dtate').value = oRetorno.dados[0].dataorcamento;
            document.getElementById('pc20_hrate').value = oRetorno.dados[0].horadoorcamento;
            document.getElementById('pc20_prazoentrega').value = oRetorno.dados[0].prazoentrega;
            document.getElementById('pc20_validadeorcamento').value = oRetorno.dados[0].validade;
            document.getElementById('pc20_cotacaoprevia').value = oRetorno.dados[0].cotacaoprevia;
            document.getElementById('pc20_obs').value =  oRetorno.dados[0].obs;

            oRetorno.dados.each(function (oItem, iItem) {
                let aLinha = [];
                aLinha.push(`<input name="orcamforne[]" type='text' style='text-align: center;width:100%;' value='${oItem.orcamforne}' /> `);
                aLinha.push(`<input name="orcamitem[]" type='text' style='text-align: center;width:100%;' value='${oItem.orcamitem}' /> `);
                aLinha.push(`<input readonly type='text' style='text-align: center;width:100%;border: none;' value='${oItem.item}' /> `);
                aLinha.push(`<input readonly type='text' style='text-align: center;width:100%;border: none;' value='${oItem.codigo}' /> `);
                aLinha.push(`<input readonly type='text' title='${oItem.descricao}' style='text-align: left;width:100%;border: none;' value='${oItem.descricao}' /> `);
                aLinha.push(`<input name="marca[]" type='text' title='${oItem.marca}' style='text-align: left;width:100%;' value='${oItem.marca}' /> `);
                aLinha.push(`<input readonly type='text' style='text-align: center;width:100%;border: none;' value='${oItem.qtddsolicitada}' /> `);
                aLinha.push(`<input name="qtddorcada[]" type='text' style='text-align: center;width:100%;' oninput="js_ValidaCampos(this,4,'Qtde. Orçada','','',event);" value='${oItem.qtddorcada}' /> `);
                aLinha.push(`<input name="porcentagem[]" type='text' oninput="js_ValidaCampos(this,4,'Qtde. Orçada','','',event);" style='text-align: center;width:100%;' value='${oItem.porcentagem}' /> `);
                aLinha.push(`<input name="vlrun[]" type='text' oninput="js_ValidaCampos(this,4,'Qtde. Orçada','','',event);formataValor(event,4);" style='text-align: center;width:100%;' value='${oItem.vlrun}' /> `);
                aLinha.push(`<input name="vlrtotal[]" type='text' style='text-align: center;width:100%;' oninput="js_ValidaCampos(this,4,'Qtde. Orçada','','',event);formataValor(event,2);" value='${oItem.vlrtotal}' /> `);
                oGridItensOrcamento.addRow(aLinha);
            });

            oGridItensOrcamento.renderRows();

            if(oRetorno.dados[0].criterioadjudicacao == "3") oGridItensOrcamento.showColumn(false,9);
            if(oRetorno.dados[0].criterioadjudicacao != "3") oGridItensOrcamento.showColumn(true,9);

        }
    }

    function salvar() {

        let oParametros = new Object();
        oParametros.sExecuta = "salvar";

        oPcOrcam = new Object();
        oPcOrcam.pc20_codorc = document.getElementById('codigoorcamento').value;
        oPcOrcam.pc20_dtate = document.getElementById("pc20_dtate").value;
        oPcOrcam.pc20_hrate = document.getElementById("pc20_hrate").value;
        oPcOrcam.pc20_prazoentrega = document.getElementById("pc20_prazoentrega").value;
        oPcOrcam.pc20_validadeorcamento = document.getElementById("pc20_validadeorcamento").value;
        oPcOrcam.pc20_cotacaoprevia = document.getElementById("pc20_cotacaoprevia").value;
        oPcOrcam.pc20_obs = encodeURIComponent(tagString(document.getElementById("pc20_obs").value));
        oParametros.oPcOrcam = oPcOrcam;

        oParametros.aItens = new Array();

        for(i = 0; i < oGridItensOrcamento.getNumRows(); i++) {
            oItem = new Object();
            oItem.pc23_orcamforne = document.getElementsByName("orcamforne[]")[i].value;
            oItem.pc23_orcamitem = document.getElementsByName("orcamitem[]")[i].value;
            oItem.pc23_obs = document.getElementsByName("marca[]")[i].value;
            oItem.pc23_quant = document.getElementsByName("qtddorcada[]")[i].value;
            oItem.pc23_vlrun = document.getElementsByName("vlrun[]")[i].value;
            oItem.pc23_valor = document.getElementsByName("vlrtotal[]")[i].value;
            if(criterioAdjudicacao == "1"){
                oItem.pc23_perctaxadesctabela = document.getElementsByName("porcentagem[]")[i].value;
            }
            if(criterioAdjudicacao == "2"){
                oItem.pc23_percentualdesconto = document.getElementsByName("porcentagem[]")[i].value;
            }
            oParametros.aItens.push(oItem);
        }

        js_divCarregando('Salvando alterações...', 'msgBox');

        let oAjax = new Ajax.Request('m4_manutencaoorcamento.RPC.php', {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParametros),
            onComplete: retornoSalvar

        });

    }

    function retornoSalvar(oAjax) {

        js_removeObj('msgBox');
        let oRetorno = eval("(" + oAjax.responseText + ")");
        if(oRetorno.status == 1){
           return alert("Alteração efetuada com sucesso.");
        }
        alert(oRetorno.erro.urlDecode());

    }

    function formataValor(e,casasdecimais){
        if(casasdecimais == 4) return e.target.value = e.target.value.replace(/(\.\d{1,4}).*/g, '$1');
        if(casasdecimais == 2) return e.target.value = e.target.value.replace(/(\.\d{1,2}).*/g, '$1');
    }

    function limparCampos(oGrid){
        oGrid.clearAll(true);
        document.getElementById('codigoorcamento').value = "";
        document.getElementById("pc20_dtate").value = "";
        document.getElementById("pc20_hrate").value = "";
        document.getElementById("pc20_prazoentrega").value = "";
        document.getElementById("pc20_validadeorcamento").value = "";
        document.getElementById("pc20_cotacaoprevia").value = "";
        document.getElementById("pc20_obs").value = "";
        document.getElementById("pc20_codorc").value = "";
        document.getElementById("pc80_codproc").value = "";
        document.getElementById("l20_codigo").value = "";
    }

</script>