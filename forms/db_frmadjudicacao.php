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
            <td nowrap title="<?=@$Tl202_dataadjudicacao?>">
                <?=@$Ll202_dataadjudicacao?>
            </td>
            <td>
                <?
                db_inputdata('l202_dataadjudicacao',@$l202_dataadjudicacao_dia,@$l202_dataadjudicacao_mes,@$l202_dataadjudicacao_ano,true,'text',$db_opcao,"")
                ?>
            </td>
        </tr>
    </table>
    <br>
    <div>
        <?php
        if($db_opcao == "1"){
            echo " <input type='button' value='Incluir' onclick='js_salvarAdjudicacao();'>";
        }elseif ($db_opcao == "2"){
            echo " <input type='button' value='Alterar' onclick='js_alterarAdjudicacao();'>";
        }else{
            echo " <input type='button' value='Excluir' onclick='js_excluirAdjudicacao();'>";
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
        oGridItens = new DBGrid('gridItens');
        oGridItens.nameInstance = 'oGridItens';
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
        var adjudicacao = 0;
        if (opcao == 1){
            situacao = 1;
            adjudicacao = 1;
        }else{
            situacao = 10;
            adjudicacao = 2;
        }
        if(mostra==true){
            js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_licadjudica.php?situacao='+situacao+
                '&funcao_js=parent.js_mostraliclicita1|l20_codigo|l20_objeto|l20_numero|l202_dataadjudicacao&validafornecedor=1&adjudicacao='+adjudicacao,'Pesquisa',true);
        }else{
            if(document.form1.l202_licitacao.value != ''){
                js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_licadjudica.php?situacao='+situacao+
                    '&pesquisa_chave='+document.form1.l202_licitacao.value+'&funcao_js=parent.js_mostraliclicita&validafornecedor=1&adjudicacao='+adjudicacao,'Pesquisa',false);
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
    function js_mostraliclicita1(chave1,chave2,chave3,chave4){
        iLicitacao = chave1;
        document.form1.l202_licitacao.value = chave1;
        document.form1.pc50_descr.value = chave2;
        let opcao = "<?= $db_opcao?>";
        if(opcao != 1){
            aData = chave4.split('-');
            let dataAdju =  aData[2]+'/'+aData[1]+'/'+aData[0];
            document.form1.l202_dataadjudicacao.value = dataAdju;
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
        oParam.iLicitacao = $F('l202_licitacao');
        oParam.exec = "getItensAdjudicacao";
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
                oDBHint.make($(oHint.idLinha),1);
            });
        }
    }

    function js_pesquisa(homologacao=false){
        if(!homologacao){
            js_OpenJanelaIframe('top.corpo','db_iframe_homologacaoadjudica','func_homologacaoadjudica.php?validadispensa=true&situacao=1&funcao_js=parent.js_preenchepesquisa|l202_sequencial','Pesquisa',true);
        }else{
            js_OpenJanelaIframe('top.corpo','db_iframe_homologacaoadjudica','func_homologacaoadjudica.php?validadispensa=true&situacao=10&funcao_js=parent.js_preenchepesquisa|l202_sequencial','Pesquisa',true);
        }
    }

    function js_preenchepesquisa(chave){
        db_iframe_homologacaoadjudica.hide();
        <?
        if($db_opcao!=1){
            echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
        }
        ?>
    }

    function js_salvarAdjudicacao(){

        var oParam = new Object();
        oParam.iLicitacao    = $F('l202_licitacao');
        oParam.dtAdjudicacao = $F('l202_dataadjudicacao');
        oParam.exec = "adjudicarLicitacao";
        js_divCarregando('Aguarde, Adjudicando Licitacao', 'msgBox');
        var oAjax = new Ajax.Request(
            'lic1_homologacaoadjudica.RPC.php', {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_retornoAdjudicacao
            }
        );
    }

    function js_retornoAdjudicacao(oAjax){
        js_removeObj('msgBox');
        var oRetorno = JSON.parse(oAjax.responseText);
        if(oRetorno.status == '1'){
            alert(oRetorno.message.urlDecode());
            oGridItens.clearAll(true);
            document.getElementById('l202_licitacao').value = '';
            document.getElementById('pc50_descr').value = '';
            document.getElementById('l202_dataadjudicacao').value = '';
        }else{
            alert(oRetorno.message.urlDecode());
        }
    }

    function js_alterarAdjudicacao(){
        var oParam = new Object();
        oParam.iLicitacao = $F('l202_licitacao');
        oParam.dtAdjudicacao = $F('l202_dataadjudicacao');
        oParam.exec = "alteraradjudicarLicitacao";
        js_divCarregando('Aguarde, Adjudicando Licitacao', 'msgBox');
        var oAjax = new Ajax.Request(
            'lic1_homologacaoadjudica.RPC.php', {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_retornoAlterarAdjudicacao
            }
        );
    }

    function js_retornoAlterarAdjudicacao(oAjax){
        js_removeObj('msgBox');
        var oRetorno = JSON.parse(oAjax.responseText);
        if(oRetorno.status == '1'){
            alert(oRetorno.message.urlDecode());
            oGridItens.clearAll(true);
            document.getElementById('l202_licitacao').value = '';
            document.getElementById('pc50_descr').value = '';
            document.getElementById('l202_dataadjudicacao').value = '';
        }else{
            alert(oRetorno.message.urlDecode());
        }
    }

    function js_excluirAdjudicacao(){
        var oParam = new Object();
        oParam.iLicitacao = $F('l202_licitacao');
        oParam.dtAdjudicacao = $F('l202_dataadjudicacao');
        oParam.exec = "excluiradjudicarLicitacao";
        js_divCarregando('Aguarde, Adjudicando Licitacao', 'msgBox');
        var oAjax = new Ajax.Request(
            'lic1_homologacaoadjudica.RPC.php', {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_retornoExcluirAdjudicacao
            }
        );
    }

    function js_retornoExcluirAdjudicacao(oAjax){
        js_removeObj('msgBox');
        var oRetorno = JSON.parse(oAjax.responseText);
        if(oRetorno.status == '1'){
            alert(oRetorno.message.urlDecode());
            oGridItens.clearAll(true);
            document.getElementById('l202_licitacao').value = '';
            document.getElementById('pc50_descr').value = '';
            document.getElementById('l202_dataadjudicacao').value = '';
        }else{
            alert(oRetorno.message.urlDecode());
        }
    }
    js_showGrid();
</script>
