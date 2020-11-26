<?php

$sCampos        = "COALESCE(SUM(c229_vlprevisto),0) total_assinado";
$sWhere         = "c229_fonte = {$c229_fonte} and c229_anousu = ".db_getsession('DB_anousu');
$sqlConvAssoc   = $clprevconvenioreceita->sql_query("",'',$sCampos,"",$sWhere);

db_fieldsmemory($clprevconvenioreceita->sql_record($sqlConvAssoc), 0);

$valor_atribuir = ($fValorPrevAno - $total_assinado);

?>
<style type="text/css">
.linhagrid.center {
    text-align: center;
}
.linhagrid input[type='text'] {
    width: 100%;
}
.normal:hover {
    background-color: #eee;
}
.DBGrid {
    width: 100%;
    border: 1px solid #888;
    margin: 20px 0;
}
</style>
<form name="form1" method="post" action="" >
    <fieldset style="width: 600px;">
        <legend><b>Associação de Convênio à Previsão da Receita</b></legend>
        <center>
            <table border="0">
                <tr>
                    <td nowrap title="<?=@$Tc229_fonte?>">
                        <?=@$Lc229_fonte?>
                    </td>
                    <td colspan="2">
                        <?
                        db_input('c229_fonte',0,$Ic229_fonte,true,'hidden',3,"");
                        db_input('fonte',0,'',true,'hidden',3,"");
                        db_input('total_assinado',0,'',true,'hidden',3,"");
                        db_input('fValorPrevAno',0,'',true,'hidden',3,"");
                        db_input('sReceita',100,'',true,'text',3,"")
                        ?>
                        <input name="iNumItensGrid" type="hidden" id="iNumItensGrid" value="0">
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?=@$Tc229_convenio?>">
                        <?
                        db_ancora($Lc229_convenio, "js_pesquisaConvenio(true);", $db_opcao);
                        ?>
                    </td>
                    <td>
                        <?
                        db_input('iConvenioTemp',0,'',true,'hidden',3,"");
                        db_input('c229_convenio', 8, $Tc229_convenio, true, 'text', $db_opcao, "onchange='js_pesquisaConvenio(false);'");
                        ?>
                    </td>
                    <td>
                        <?
                        db_input('sObjeto',90,'',true,'text',3,"");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?=@$Tc229_vlprevisto?>">
                        <b>Saldo a Atribuir:</b>
                    </td>
                    <td>
                        <?
                        db_input('valor_atribuir', 8, 'Valor a Atribuir', true, 'float', 3, "");
                        ?>
                    </td>
                </tr>
            </table>
        </center>
    </fieldset>
    <table>
        <tr>
            <input name="incluir" type="button" id="db_opcao" value="Incluir" onclick="js_inclui();" >
            <input name="pesquisar" type="button" id="limpar" value="Limpar" onclick="js_limpa();">
            <input name="pesquisar" type="button" id="pesquisar" value="Fechar" onclick="js_fecha();">
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>    

    <fieldset style="width: 820px;">
        <legend align="center"><b>CONVÊNIOS ASSOCIADOS</b></legend>
        <table class="DBGrid" id="gridConv">
            <tr>
                <th class="table_header" style="width: 33px; cursor: pointer;" onclick="marcarTodos(<?= $iFonte ?>);" id="marcarTodos">M</th>
                <th class="table_header" style="width: 70px;">Código do Convênio</th>
                <th class="table_header" style="width: 70px;">Número do Convênio</th>
                <th class="table_header" style="width: 240px;">Objeto</th>
                <th class="table_header" style="width: 100px;">Data da Assinatura</th>
                <th class="table_header" style="width: 110px;">Valor Previsto</th>
                <th class="table_header" style="width: 100px;">Valor Arrecadado</th>
            </tr>
        </table>
    </fieldset>

    <table>
        <tr>
            <input name="salvarGeral" type="button" id="salvarGeral" value="Salvar" onclick="js_salvaGeral();" >
            <input name="exclui" type="button" id="exclui" value="Excluir" onclick="js_exclui();">
        </tr>
    </table>
    
</form>
<script>

    document.form1.valor_atribuir.value = js_formatar(document.form1.valor_atribuir.value, 'f');

    const sRPC = 'con4_previsaoreceita.RPC.php';
    
    buscaConvenios(<?= $c229_fonte ?>);

    function buscaConvenios(iCodRec) {
        
        var oParam        = new Object();
        oParam.exec       = 'buscaConvenios';
        oParam.iCodRec    = iCodRec;

        js_divCarregando('Aguarde, buscando registros', 'div_aguarde');

        var oAjax = new Ajax.Request(sRPC, {
            method:'post',
            parameters:'json='+Object.toJSON(oParam),
            onComplete: js_retornoBuscaConvenios
        });

    }

    function js_retornoBuscaConvenios(oAjax) {

        js_removeObj('div_aguarde');
        var oRetorno  = eval("("+oAjax.responseText+")");
        var iMes      = oRetorno.iMes;

        if (oRetorno.status == 1) {

            document.form1.iNumItensGrid.value = oRetorno.aItens.length;
            
            oRetorno.aItens.each(function(oConvenio, iLinha) {

                js_adicionaLinha(oConvenio, iLinha);

            });
        }

    }

    function js_inclui() {

        if (document.form1.c229_convenio.value == '') {
            alert('Informe o Convênio');
            return false;
        }

        var iNumItensGrid = parseInt(document.form1.iNumItensGrid.value);
        var bContinua = true;

        for (i = 0; i <= iNumItensGrid-1; i++) {

            if (document.form1.c229_convenio.value == document.form1['aItensConv['+i+'][c229_convenio]'].getAttribute('value')) {

                alert("Convênio já associado a esta receita!");
                bContinua = false;
                return false;
                
            }

        }

        if (bContinua) {

            try {

                var oParam = new Object();

                oParam.exec      = 'salvaNovo';
                oParam.iFonte    = document.form1.c229_fonte.value;
                oParam.iConvenio = document.form1.c229_convenio.value;

                js_divCarregando('Aguarde', 'div_aguarde');

                var oAjax = new Ajax.Request(sRPC, {
                    method: 'post',
                    parameters: 'json='+Object.toJSON(oParam),
                    onComplete: js_retornoInclui
                });

            } catch(e) {
                alert(e.toString());
            }
        
        }

    }

    function js_retornoInclui(oAjax) {

        js_removeObj('div_aguarde');
        var oRetorno = eval("("+oAjax.responseText+")");

        if (oRetorno.status == 1) {

            var iNumItensGrid = parseInt(document.form1.iNumItensGrid.value);
            js_adicionaLinha(oRetorno, iNumItensGrid);
            document.form1.iNumItensGrid.value = iNumItensGrid+1;

            document.form1.c229_convenio.value = '';
            document.form1.sObjeto.value = '';
            
        } else {
            alert(oRetorno.sMensagem.urlDecode());
        }
        
    }

    function js_adicionaLinha(oConvenio = null, iLinha = null) {

        var sLinhaTabela = "";

        sLinhaTabela += "<tr id='"+iLinha+"' class='normal'>";
        sLinhaTabela += "   <th class='table_header'>";
        sLinhaTabela += "       <input type='checkbox' class='marca_itens' name='aItensMarcados[]' value='"+iLinha+"' >";
        sLinhaTabela += "       <input type='hidden' name='aItensConv["+iLinha+"][c229_fonte]' value='"+oConvenio.o70_codrec+"' >";
        sLinhaTabela += "       <input type='hidden' name='aItensConv["+iLinha+"][c229_convenio]' value='"+oConvenio.c206_sequencial+"' >";
        sLinhaTabela += "       <input type='hidden' name='aItensConv["+iLinha+"][bArrecadado]' value='"+oConvenio.bArrecadado+"' >";
        sLinhaTabela += "   </th>";
        sLinhaTabela += "   <td class='linhagrid'>"+oConvenio.c206_sequencial+"</td>";
        sLinhaTabela += "   <td class='linhagrid'>"+oConvenio.c206_nroconvenio+"</td>";
        sLinhaTabela += "   <td class='linhagrid'>"+oConvenio.c206_objetoconvenio.urlDecode()+"</td>";
        sLinhaTabela += "   <td class='linhagrid'>"+js_formatar(oConvenio.c206_dataassinatura, 'd')+"</td>";
        sLinhaTabela += "   <td class='linhagrid'>";
        sLinhaTabela += "       <input type='text' name='aItensConv["+iLinha+"][c229_vlprevisto]' value='"+js_formatar(oConvenio.c229_vlprevisto, 'f')+"' style='width: 70px;' >";
        sLinhaTabela += "   </td>";
        sLinhaTabela += "   <td class='linhagrid'>";
        sLinhaTabela += "       <input type='text' name='aItensConv["+iLinha+"][valor_arrecadado]' value='"+js_formatar(oConvenio.valor_arrecadado, 'f')+"' style='width: 70px; background: #DEB887;' readonly='true' >";
        sLinhaTabela += "   </td>";
        sLinhaTabela += "</tr>";

        document.getElementById("gridConv").innerHTML += sLinhaTabela;

    }

    function js_limpaTabela(){

        var j = 0;

        for (var i = parseInt(document.form1.iNumItensGrid.value)-1; i >= 0; i--) {
        
            j = i;
            while(document.getElementById(j) == null) {
                j++;
            }
            js_excluiLinha(j);

        }

        document.form1.iNumItensGrid.value = 0;

    }

    function js_excluiLinha(id){

        try {

            linha = document.getElementById(id);
            linha.parentNode.parentNode.removeChild(linha.parentNode);

        }catch (e) {}  

        document.form1.iNumItensGrid.value = parseInt(document.form1.iNumItensGrid.value)-1;

    }

    function js_salvaGeral() {

        var iNumItensGrid = parseInt(document.form1.iNumItensGrid.value);

        if (iNumItensGrid < 1) {

            alert('Adicione um convênio.');
            return false;

        }

        var aItensEnviar = [];

        try {

            for (i = 0; i <= iNumItensGrid-1; i++) {

                var elemento = 'aItensConv['+i+']';

                var valorPrevisto   = document.form1[elemento+'[c229_vlprevisto]'].value;
                valorPrevisto       = isNaN(Number(valorPrevisto)) ? valorPrevisto.replace(/\./g, '').replace(/\,/, '.') : valorPrevisto

                var valorPrevistoAnterior   = document.form1[elemento+'[c229_vlprevisto]'].getAttribute('value');
                valorPrevistoAnterior       = isNaN(Number(valorPrevistoAnterior)) ? valorPrevistoAnterior.replace(/\./g, '').replace(/\,/, '.') : valorPrevistoAnterior
                
                if (valorPrevisto > 0 || valorPrevistoAnterior > 0) {
                    
                    var novoItem = {
                        iItem:              Number(i),
                        c229_fonte:         document.form1[elemento+'[c229_fonte]'].getAttribute('value'),
                        c229_convenio:      document.form1[elemento+'[c229_convenio]'].getAttribute('value'),
                        c229_vlprevisto:    valorPrevisto,
                        c229_arrecadado:    document.form1[elemento+'[bArrecadado]'].getAttribute('value'),
                    }

                    aItensEnviar.push(novoItem);

                }

            }

            var oParam           = new Object();
            oParam.exec          = 'salvaGeral';
            oParam.aItens        = aItensEnviar;
            oParam.fValorPrevAno = document.form1.fValorPrevAno.getAttribute('value');

            js_divCarregando('Aguarde', 'div_aguarde');

            var oAjax = new Ajax.Request(sRPC, {
                method:'post',
                parameters:'json='+Object.toJSON(oParam),
                onComplete: js_retornoSalvaGeral
            });

        } catch (e) {
            alert(e.toString());
        }

    }

    function js_retornoSalvaGeral(oAjax) {

        js_removeObj('div_aguarde');

        var oRetorno = eval("("+oAjax.responseText+")");

        if (oRetorno.status == 1) {

            alert(oRetorno.sMensagem.urlDecode());
            location.reload();

        } else {
            alert(oRetorno.sMensagem.urlDecode());
        }

    }
    
    function aItens() {
      
        var itensNum = document.querySelectorAll('.marca_itens');

        return Array.prototype.map.call(itensNum, function (item) {
            return item;
        });

    }

    function marcarTodos() {

        aItens().forEach(function (item) {

            var check = item.classList.contains('marcado');

            if (check) {
                item.classList.remove('marcado');
            } else {
                item.classList.add('marcado');
            }
            item.checked = !check;

        });

    }

    function getItensMarcados() {

        return aItens().filter(function (item) {
        return item.checked;
        });

    }

    function js_exclui() {

        var itens = getItensMarcados();

        if (itens.length < 1) {

            alert('Selecione pelo menos um item da lista.');
            return;

        }

        itens = itens.map(function (item) {
            return Number(item.value);
        });

        try {

            var aItensExcluir = [];
            var bExclui = true;

            itens.forEach(function (item) {

                var elemento = 'aItensConv[' + item + ']';

                var valor_arrecadado = document.form1[elemento+'[valor_arrecadado]'].getAttribute('value').replace(/\./g, '').replace(/\,/, '.');
                
                if (Number(valor_arrecadado) > 0) {                    
                    alert('Não é possível excluir um convênio associado que possua valor arrecadado.');
                    bExclui = false;
                    return false;
                }

                var novoItem = {
                    iItem:              Number(item),
                    c229_fonte:         document.form1[elemento+'[c229_fonte]'].getAttribute('value'),
                    c229_convenio:      document.form1[elemento+'[c229_convenio]'].getAttribute('value')
                }

                aItensExcluir.push(novoItem);

            });

            if (bExclui) {

                var oParam      = new Object();
                oParam.exec     = 'exclui';
                oParam.aItens   = aItensExcluir;

                js_divCarregando('Aguarde', 'div_aguarde');

                var oAjax = new Ajax.Request(sRPC, {
                    
                    method:'post',
                    parameters:'json='+Object.toJSON(oParam),
                    onComplete: js_retornoExclui

                });

            }

        } catch (e) {
            alert(e.toString());
        }

    }

    function js_retornoExclui(oAjax) {

        js_removeObj('div_aguarde');
        var oRetorno = eval("("+oAjax.responseText+")");

        if (oRetorno.status == 1) {

            alert(oRetorno.sMensagem.urlDecode());
            location.reload();

        } {
            alert(oRetorno.sMensagem.urlDecode());
        }

    }

    function js_pesquisaConvenio(mostra) {
        if(mostra) {
            js_OpenJanelaIframe('', 'db_iframe_convconvenios', 'func_convconvenios.php?funcao_js=parent.js_preenchepesquisa|c206_sequencial|c206_objetoconvenio|c206_tipocadastro&iFonte='+<?= $iFonte ?>, 'Pesquisa', true, '0', '1');
        } else {
            if(document.form1.c229_convenio.value != ''){
                js_OpenJanelaIframe('','db_iframe_convconvenios','func_convconvenios.php?pesquisa_chave='+document.form1.c229_convenio.value+'&funcao_js=parent.js_preenchepesquisa1','Pesquisa',false);
            }else{
                document.form1.c229_convenio.value = "";
            }
        }
    }

    function js_preenchepesquisa(sequencial, objeto, fonte){
        db_iframe_convconvenios.hide();
        document.form1.c229_convenio.value    = sequencial;
        document.form1.sObjeto.value          = objeto;
        document.form1.fonte.value            = fonte;
    }

    function js_preenchepesquisa1(objeto, erro, fonte) {
        document.form1.sObjeto.value = objeto;
        document.form1.fonte.value = fonte;
        if(erro==true){
            document.form1.c229_convenio.focus();
            document.form1.c229_convenio.value = '';
        }
    }

    function js_fecha() {
        parent.db_iframe_conconvprevrec.hide();
    }

    parent.$('fechardb_iframe_conconvprevrec').onclick = function () {
        js_fecha();
    }

    function js_limpa() {
        document.form1.c229_convenio.value = '';
        document.form1.sObjeto.value = '';
    }
</script>