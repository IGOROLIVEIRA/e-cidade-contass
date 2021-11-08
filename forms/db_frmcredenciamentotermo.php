<?
//MODULO: licitacao
$clcredenciamentotermo->rotulo->label();
?>
<style>
    #l212_observacao {
        width: 580px;
        height: 72px;
    }
    #l212_sequencial, #l212_numerotermo, #l212_numerotermo{
        width: 93px;
    }
    #fornecedores{
        width: 243px;
    }
    #l212_veiculodepublicacao {
        width: 452px;
        height: 18px;
    }
</style>
<form name="form1" method="post" action="">
    <fieldset style="align-items: center; width: 32%; margin-top: 30px; margin-left: 35%">
        <legend>
            Termo de Credenciamento
        </legend>
        <table border="0">
            <tr>
                <td nowrap title="<?=@$Tl212_sequencial?>">
                    <input name="l212_sequencial" type="hidden" value="<?=@$l212_sequencial?>">
                    <?=@$Ll212_sequencial?>
                </td>
                <td>
                    <?
                    db_input('l212_sequencial',19,$Il212_sequencial,true,'text',3,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tl212_licitacao?>">
                    <?
                    db_ancora('Licitação:',"js_pesquisa_liclicita(true)",$db_opcao);
                    ?>
                </td>
                <td>
                    <?
                    db_input('l212_licitacao',10,$Il212_licitacao,true,'text',3,"onchange='js_pesquisa_liclicita(false)'")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tl212_numerotermo?>">
                    <?=@$Ll212_numerotermo?>
                </td>
                <td>
                    <?
                    db_input('l212_numerotermo',19,$Il212_numerotermo,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Ano do Termo:</strong>
                </td>
                <td>
                    <?
                    $iAnoSessao         = db_getsession('DB_anousu');
                    ?>
                    <input type="text" value="<?=$iAnoSessao?>" id="l212_anousu" style="width: 93px; background-color: #DEB887;" readonly>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tl212_fornecedor?>">
                    <?=@$Ll212_fornecedor?>
                </td>
                <td>
                    <?
                    db_select('l212_fornecedor', $aTabFonec, true, $db_opcao, " onchange='js_getItens()' style='width:452;' ");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tl212_dtinicio?>">
                    <?=@$Ll212_dtinicio?>
                </td>
                <td>
                    <?
                    db_inputdata('l212_dtinicio',@$l212_dtinicio_dia,@$l212_dtinicio_mes,@$l212_dtinicio_ano,true,'text',$db_opcao,"")
                    ?>
                    <strong>á</strong>
                    <?
                    db_inputdata('l212_dtfim',@$l212_dtfim_dia,@$l212_dtfim_mes,@$l212_dtfim_ano,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tl212_dtpublicacao?>">
                    <?=@$Ll212_dtpublicacao?>
                </td>
                <td>
                    <?
                    db_inputdata('l212_dtpublicacao',@$l212_dtpublicacao_dia,@$l212_dtpublicacao_mes,@$l212_dtpublicacao_ano,true,'text',3,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tl212_veiculodepublicacao?>">
                    <?=@$Ll212_veiculodepublicacao?>
                </td>
                <td>
                    <?
                    db_input('l212_veiculodepublicacao',19,$Il212_numerotermo,true,'text',3,"")
                    ?>
                </td>
            </tr>
        </table>
        <fieldset>
            <legend>Observação:</legend>
            <table>
                <tr>
                    <td>
                        <?
                        db_textarea('l212_observacao',0,0,$Il212_observacao,true,'text',$db_opcao,"")
                        ?>
                    </td>
                </tr>
            </table>
        </fieldset>
    </fieldset>
    <div style="margin-left: 50%; margin-top: 20px">
        <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
        <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
        <?
        if($db_opcao == "2"):
        ?>
        <input name="relatorio" type="button" id="relatorio" value="Gerar Relatorio" onclick="js_relatorio();" >
        <?endif;?>
    </div>
    <fieldset id="fieldsetitens" style="display: none">
        <legend><b>Itens</b></legend>
        <div id='cntgriditens'></div>
    </fieldset>
</form>
<script>

    function js_showGrid() {
        oGridItens = new DBGrid('gridItens');
        oGridItens.nameInstance = 'oGridItens';
        oGridItens.setCellAlign(new Array("center","center","center", "center", "center"));
        oGridItens.setCellWidth(new Array("5%"    ,"5%"    , "25%"   , '5%'  ,   '10%'));
        oGridItens.setHeader(new Array("Item","Sequencia","Material", "Unidade", "Valor Licitado"));
        oGridItens.hasTotalValue = false;
        oGridItens.show($('cntgriditens'));

        var width = $('cntgriditens').scrollWidth - 30;
        $("table" + oGridItens.sName + "header").style.width = width;
        $(oGridItens.sName + "body").style.width = width;
        $("table" + oGridItens.sName + "footer").style.width = width;
    }

    var db_opcao = <?= $db_opcao?>;

    if(db_opcao != 1){
        mostrarFornecedores();
        js_getItens();
    }

    function js_pesquisa(){
        js_OpenJanelaIframe('top.corpo','db_iframe_credenciamentotermo','func_credenciamentotermo.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
    }
    function js_preenchepesquisa(chave){
        db_iframe_credenciamentotermo.hide();
        <?
        if($db_opcao!=1){
            echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
        }
        ?>
    }

    /**
     * funcao para retornar licitacao
     */
    function js_pesquisa_liclicita(mostra){

        if(mostra==true) {

            js_OpenJanelaIframe('top.corpo',
                'db_iframe_licitacao',
                'func_liclicita.php?situacao=10&credenciamentotermo=true&funcao_js=parent.js_preencheLicitacao|l20_codigo|l20_dtpubratificacao|l20_veicdivulgacao',
                'Pesquisa Licitações', true);
        }
    }
    /**
     * funcao para preencher licitacao  da ancora
     */
    function js_preencheLicitacao(codigo,dtpublica,veicpublica)
    {
        var aDate = dtpublica.split('-');

        document.form1.l212_licitacao.value = codigo;
        document.form1.l212_dtpublicacao.value = aDate[2]+'/'+aDate[1]+'/'+aDate[0];
        document.form1.l212_veiculodepublicacao.value = veicpublica;
        db_iframe_licitacao.hide();
        mostrarFornecedores();
    }

    function mostrarFornecedores() {
        var oParam = new Object();
        oParam.iLicitacao = $F('l212_licitacao');
        oParam.iCodtermo  = $F('l212_sequencial');
        oParam.idbopcao   = <?=$db_opcao?>;
        oParam.exec = "getFornecedores";
        var oAjax = new Ajax.Request(
            'lic_termocredenciamento.RPC.php', {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_retornoGetFornecedores
            }
        );
    }

    function js_retornoGetFornecedores(oAjax) {

        let fornecedores = JSON.parse(oAjax.responseText);

        let select = $('l212_fornecedor');
        let db_opcao = <?= $db_opcao?>;

        if(db_opcao == 1){
            // Cria option "default"
            let defaultOpt = document.createElement('option');
            defaultOpt.textContent = 'Selecione uma opção';
            defaultOpt.value = '0';
            select.append(defaultOpt);
        }

        if(fornecedores.fornecedores.length != 0){
            fornecedores.fornecedores.forEach(function (oFornecedor, seq) {
                let option = document.createElement('option');
                option.value = oFornecedor.z01_numcgm;
                option.text = oFornecedor.z01_nome;
                select.append(option);
            })
        }else{
            top.corpo.db_iframe_credenciamentotermo.location.reload();
        }

        if(db_opcao == 1){
            mostrarNumeroTermo();
        }
        document.getElementById('fieldsetitens').style.display = '';
        js_showGrid();
        js_getItens();
    }

    function mostrarNumeroTermo() {

        var oParam = new Object();
        oParam.exec = "getNumeroTermo";
        var oAjax = new Ajax.Request(
            'lic_termocredenciamento.RPC.php', {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_retornonumerotermo
            }
        );
    }

    function js_retornonumerotermo(oAjax) {

        var oRetornonumerotermo = JSON.parse(oAjax.responseText);
        document.form1.l212_numerotermo.value = oRetornonumerotermo.numerotermo;
    }

    function js_getItens() {
        oGridItens.clearAll(true);
        var oParam = new Object();
        oParam.iLicitacao   = $F('l212_licitacao');
        oParam.iCodtermo    = $F('l212_sequencial');
        oParam.iFornecedor  = $F('l212_fornecedor');
        oParam.exec = "getItensCredenciamento";
        var oAjax = new Ajax.Request(
            'lic_termocredenciamento.RPC.php', {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_retornoGetItens
            }
        );
    }

    function js_retornoGetItens(oAjax) {
        oGridItens.clearAll(true);
        var aEventsIn  = ["onmouseover"];
        var aEventsOut = ["onmouseout"];
        aDadosHintGrid = new Array();

        var oRetornoitens = JSON.parse(oAjax.responseText);

        oRetornoitens.itens.each(function(oLinha, iLinha) {
            var aLinha = new Array();
            aLinha[0] = oLinha.pc01_codmater;
            aLinha[1] = oLinha.pc11_seq;
            aLinha[2] = oLinha.pc01_descrmater.urlDecode();
            aLinha[3] = oLinha.m61_descr;
            aLinha[4] = oLinha.varlortotal;
            oGridItens.addRow(aLinha);

            var sTextEvent  = " ";

            if (aLinha[2] !== '') {
                sTextEvent += "<b>Material: </b>"+aLinha[2];
            } else {
                sTextEvent += "<b>Nenhum dado à mostrar</b>";
            }
            // nTotal = nTotal + Number(oLinha.varlortotal);

            var oDadosHint           = new Object();
            oDadosHint.idLinha   = `gridItensrowgridItens${iLinha}`;
            oDadosHint.sText     = sTextEvent;
            aDadosHintGrid.push(oDadosHint);
        });
        // document.getElementById('gridItenstotalValue').innerText = js_formatar(nTotal, 'f');
        oGridItens.renderRows();

        aDadosHintGrid.each(function(oHint, id) {
            var oDBHint    = eval("oDBHint_"+id+" = new DBHint('oDBHint_"+id+"')");
            oDBHint.setText(oHint.sText);
            oDBHint.setShowEvents(aEventsIn);
            oDBHint.setHideEvents(aEventsOut);
            oDBHint.setPosition('B', 'L');
            oDBHint.setUseMouse(true);
            oDBHint.make($(oHint.idLinha), 2);
        });
    }

    function js_relatorio() {
        let l212_sequencial = $F('l212_sequencial');

        if(l212_sequencial == ''){
            alert('Sequencial do termo nao informado !')
        }else{
            query = 'l212_sequencial='+l212_sequencial;
            window.open('lic1_imprimetermocredenciamento.php?'+query,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
        }
    }

</script>
