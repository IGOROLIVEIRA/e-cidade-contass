<?php
//MODULO: licitacao
include("dbforms/db_classesgenericas.php");
$clhomologacaoadjudica->rotulo->label();

$cliframe_seleciona = new cl_iframe_seleciona;
$clpcprocitem       = new cl_pcprocitem;
$clrotulo           = new rotulocampo;

$clrotulo->label("l20_codigo");
?>
<form name="form1" method="post" action="">
    <table border="0">
        <tr>
            <td nowrap title="<?=@$Tl202_sequencial?>">
                <?=@$Ll202_sequencial?>
            </td>
            <td>
                <?
                db_input('l202_sequencial',10,$Il202_sequencial,true,'text',3,"")
                ?>
            </td>
        </tr>
        <tr>
            <td nowrap title="<?=@$Tl202_licitacao?>">
                <?
                db_ancora(@$Ll202_licitacao,"js_pesquisal202_licitacao(true);",$db_opcao);
                ?>
            </td>
            <td>
                <?
                db_input('l202_licitacao',10,$Il202_licitacao,true,'text',3," onchange='js_pesquisal202_licitacao(false);'")
                ?>
                <?
                $pc50_descr = $pc50_descr ." ".$l20_numero;
                db_input('pc50_descr',40,$Ipc50_descr,true,'text',3,'')
                ?>
            </td>
        </tr>
        <tr>
            <td nowrap title="<?=@$Tl202_datahomologacao?>">
                <?=@$Ll202_datahomologacao?>
            </td>
            <td>
                <?
                db_inputdata('l202_datahomologacao',@$l202_datahomologacao_dia,@$l202_datahomologacao_mes,@$l202_datahomologacao_ano,true,'text',$db_opcao,"")
                ?>
            </td>
        </tr>
    </table>
    <br>
    <div>
        <?php
        if($db_opcao == "1"){
            echo " <input type='button' value='Incluir' onclick='js_salvarHomologacao();'>";
        }elseif ($db_opcao == "2"){
            echo " <input type='button' value='Alterar' onclick='js_alterarHomologacao();'>";
        }else{
            echo " <input type='button' value='Excluir' onclick='js_excluirHomologacao();'>";
        }
        ?>
        <input type="button" value="Pesquisar" onclick="js_pesquisal202_licitacao(true);">
    </div>
    <br>
    <fieldset>
        <legend><b>Itens</b></legend>
        <div id='cntgriditens'></div>
    </fieldset>
</form>
<script>
    <?php
    /**
     * ValidaFornecedor:
     * Quando for passado por URL o parametro validafornecedor, só irá retornar licitações que possuem fornecedores habilitados.
     * @see ocorrência 2278
     */
    ?>
    function js_showGrid() {
        let opcao = "<?= $db_opcao?>";
        oGridItens = new DBGrid('gridItens');
        oGridItens.nameInstance = 'oGridItens';
        if(opcao != 2){
            oGridItens.setCheckbox(0);
        }
        oGridItens.setCellAlign(new Array("center", "center", "center", 'center', 'center', 'center'));
        oGridItens.setCellWidth(new Array("10%" , "25%"     , '25%'          ,   '15%'    , '15%'        , '15%'            ));
        oGridItens.setHeader(new Array("Código", "Material", "Fornecedores","Unidade", "Qtde Licitada", "Valor Licitado"));
        oGridItens.hasTotalValue = true;
        oGridItens.show($('cntgriditens'));

        var width = $('cntgriditens').scrollWidth - 30;
        $("table" + oGridItens.sName + "header").style.width = width;
        $(oGridItens.sName + "body").style.width = width;
        $("table" + oGridItens.sName + "footer").style.width = width;
    }
    js_pesquisal202_licitacao(true);
    function js_pesquisal202_licitacao(mostra){
        let opcao = "<?= $db_opcao?>";
        var situacao = 0;
        var homologacao = 0;
        if (opcao == 1){
            situacao = 1;
            homologacao = 1;
        }else{
            situacao = 10;
            homologacao = 2;
        }
        if(mostra==true){
            js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_lichomologa.php?situacao='+situacao+
                '&funcao_js=parent.js_mostraliclicita1|l20_codigo|l20_objeto|l20_numero|l202_datahomologacao|l202_sequencial&validafornecedor=1&homologacao='+homologacao,'Pesquisa',true);
        }else{
            if(document.form1.l202_licitacao.value != ''){
                js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_lichomologa.php?situacao='+situacao+
                    '&pesquisa_chave='+document.form1.l202_licitacao.value+'&funcao_js=parent.js_mostraliclicita&validafornecedor=1&homologacao='+homologacao,'Pesquisa',false);
            }else{
                document.form1.l202_licitacao.value = '';
                document.form1.pc50_descr.value = '';
                js_init()
            }

        }
    }
    function js_mostraliclicita(chave,erro){

        document.form1.pc50_descr.value = chave;
        if(erro==true){
            iLicitacao = '';
            document.form1.l202_licitacao.focus();
            document.form1.l202_licitacao.value = '';
        }else{
            iLicitacao = document.form1.l202_licitacao.value;
            js_init()
        }
    }
    /**
     * Função alterada para receber o parametro da numeração da modalidade.
     * Acrescentado o parametro chave3 que recebe o l20_numero vindo da linha 263.
     * Solicitado por danilo@contass e deborah@contass
     */
    function js_mostraliclicita1(chave1,chave2,chave3,chave4,chave5){
        iLicitacao = chave1;
        document.form1.l202_licitacao.value = chave1;
        document.form1.pc50_descr.value = chave2;
        let opcao = "<?= $db_opcao?>";
        if(opcao != 1){
            aData = chave4.split('-');
            let dataHomo =  aData[2]+'/'+aData[1]+'/'+aData[0];
            document.form1.l202_datahomologacao.value = dataHomo;
            document.form1.l202_sequencial.value = chave5;
        }
        db_iframe_liclicita.hide();
        js_init()
    }

    function js_init() {
        js_showGrid();
        js_getItens();
    }

    function js_getItens() {
        oGridItens.clearAll(true);
        var oParam = new Object();
        oParam.iLicitacao   = $F('l202_licitacao');
        oParam.iHomologacao = $F('l202_sequencial');
        oParam.dbopcao      = "<?=$db_opcao?>";
        oParam.exec = "getItens";
        js_divCarregando('Aguarde, pesquisando Itens', 'msgBox');
        var oAjax = new Ajax.Request(
            'lic1_homologacaoadjudica.RPC.php', {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_retornoGetItens
            }
        );
    }

    function js_retornoGetItens(oAjax) {

        js_removeObj('msgBox');
        oGridItens.clearAll(true);
        var aEventsIn  = ["onmouseover"];
        var aEventsOut = ["onmouseout"];
        aDadosHintGrid = new Array();

        var oRetornoitens = JSON.parse(oAjax.responseText);

        var nTotal = new Number(0);

        if (oRetornoitens.status == 1) {

            oRetornoitens.itens.each(function(oLinha, iLinha) {
                    var aLinha = new Array();
                    aLinha[0] = oLinha.pc81_codprocitem;
                    aLinha[1] = oLinha.pc01_descrmater.urlDecode();
                    aLinha[2] = oLinha.z01_nome.urlDecode();
                    aLinha[3] = oLinha.m61_descr;
                    aLinha[4] = oLinha.pc11_quant;
                    aLinha[5] = oLinha.pc23_valor;
                    oGridItens.addRow(aLinha);
                nTotal = nTotal + Number(oLinha.pc23_valor);

                var sTextEvent  = " ";

                if (aLinha[1] !== '') {
                    sTextEvent += "<b>Material: </b>"+aLinha[1];
                } else {
                    sTextEvent += "<b>Nenhum dado à mostrar</b>";
                }

                var oDadosHint           = new Object();
                oDadosHint.idLinha   = `gridItensrowgridItens${iLinha}`;
                oDadosHint.sText     = sTextEvent;
                aDadosHintGrid.push(oDadosHint);
            });
            document.getElementById('gridItenstotalValue').innerText = js_formatar(nTotal, 'f');

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
    }

    function js_salvarHomologacao(){

        var aItens = oGridItens.getSelection("object");
        if (aItens.length == 0) {
            alert('Nenhum item Selecionado');
            return false;
        }

        var oParam = new Object();
        oParam.iLicitacao    = $F('l202_licitacao');
        oParam.dtHomologacao = $F('l202_datahomologacao');
        oParam.iHomologacao  = $F('l202_sequencial');
        oParam.aItens        = new Array();
        oParam.exec = "homologarLicitacao";

        for (var i = 0; i < aItens.length; i++) {

            with (aItens[i]) {
                var oItem        = new Object();
                oItem.codigo     = aCells[0].getValue();
                oParam.aItens.push(oItem);
            }
        }

        js_divCarregando('Aguarde, Homologando Licitacao', 'msgBox');
        var oAjax = new Ajax.Request(
            'lic1_homologacaoadjudica.RPC.php', {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_retornoHomologacao
            }
        );
    }

    function js_retornoHomologacao(oAjax){
        js_removeObj('msgBox');
        var oRetorno = JSON.parse(oAjax.responseText);
        if(oRetorno.status == '1'){
            alert(oRetorno.message.urlDecode());
            oGridItens.clearAll(true);
            document.getElementById('l202_licitacao').value = '';
            document.getElementById('pc50_descr').value = '';
            document.getElementById('l202_datahomologacao').value = '';
        }else{
            alert(oRetorno.message.urlDecode());
        }
    }

    function js_alterarHomologacao(){
        var oParam = new Object();
        oParam.iLicitacao    = $F('l202_licitacao');
        oParam.dtHomologacao = $F('l202_datahomologacao');
        oParam.iHomologacao  = $F('l202_sequencial');
        oParam.exec = "alterarHomologacao";
        js_divCarregando('Aguarde, alterando Homologando', 'msgBox');
        var oAjax = new Ajax.Request(
            'lic1_homologacaoadjudica.RPC.php', {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_retornoAlterarHomologacao
            }
        );
    }

    function js_retornoAlterarHomologacao(oAjax){
        js_removeObj('msgBox');
        var oRetorno = JSON.parse(oAjax.responseText);
        if(oRetorno.status == '1'){
            alert(oRetorno.message.urlDecode());
            oGridItens.clearAll(true);
            document.getElementById('l202_licitacao').value = '';
            document.getElementById('pc50_descr').value = '';
            document.getElementById('l202_datahomologacao').value = '';
            document.getElementById('l202_sequencial').value = '';
        }else{
            alert(oRetorno.message.urlDecode());
        }
    }

    function js_excluirHomologacao(){

        var aItens = oGridItens.getSelection("object");
        if (aItens.length == 0) {
            alert('Nenhum item Selecionado');
            return false;
        }

        var oParam = new Object();
        oParam.iLicitacao    = $F('l202_licitacao');
        oParam.dtAdjudicacao = $F('l202_datahomologacao');
        oParam.iHomologacao  = $F('l202_sequencial');
        oParam.aItens        = new Array();
        oParam.exec = "excluirhomologacao";

        for (var i = 0; i < aItens.length; i++) {

            with (aItens[i]) {
                var oItem        = new Object();
                oItem.codigo     = aCells[0].getValue();
                oParam.aItens.push(oItem);
            }
        }
        js_divCarregando('Aguarde, Excluindo homologacao', 'msgBox');
        var oAjax = new Ajax.Request(
            'lic1_homologacaoadjudica.RPC.php', {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_retornoExcluirHomologacao
            }
        );
    }

    function js_retornoExcluirHomologacao(oAjax){
        js_removeObj('msgBox');
        var oRetorno = JSON.parse(oAjax.responseText);
        if(oRetorno.status == '1'){
            alert(oRetorno.message.urlDecode());
            oGridItens.clearAll(true);
            document.getElementById('l202_licitacao').value = '';
            document.getElementById('pc50_descr').value = '';
            document.getElementById('l202_datahomologacao').value = '';
            document.getElementById('l202_sequencial').value = '';
        }else{
            alert(oRetorno.message.urlDecode());
        }
    }

    function js_somaItens(){
    }

    js_showGrid();
</script>
