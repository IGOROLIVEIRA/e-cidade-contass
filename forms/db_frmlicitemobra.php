<?
//MODULO: Obras
$cllicitemobra->rotulo->label();
?>
<style>
    #obr06_descricaotabela{
        width: 858px;
        height: 29px;
    }
    #l20_objeto,#pc80_resumo{
        width: 543px;
    }
</style>
<form name="form1" method="post" action="">
    <fieldset style="margin-top: 60px; width: 500px">
        <legend>Cadastro de itens obra</legend>
        <table border="0">
            <tr>
                <td>
                    <?
                    db_ancora("Sequencial da Licitação:","js_pesquisa_liclicita(true)",$db_opcao);
                    ?>
                </td>
                <td>
                    <?
                    db_input('l20_codigo',11,$Il20_codigo,true,'text',$db_opcao,"onchange=js_pesquisa_liclicita(false)");
                    db_input('l20_objeto',40,$Il20_objeto,true,'text',3,"");
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?
                    db_ancora("Processo de Compras:","js_pesquisa_pcproc(true)",$db_opcao);
                    ?>
                </td>
                <td>
                    <?
                    db_input('pc80_codproc',11,$Ipc80_codproc,true,'text',$db_opcao,"onchange=js_pesquisa_pcproc(false)");
                    db_input('pc80_resumo',40,$Ipc80_resumo,true,'text',3,"");
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input name="Processar" type="submit" id="db_opcao" value="Processar" style="width: 100px; margin-left: 43%;margin-top: 7px; margin-bottom: 5px">
                </td>
            </tr>
        </table>

        <table style="border-top: 2px solid #808080; margin-top: 5px;">
            <tr><td></td></tr>
            <tr>
                <td nowrap title="<?=@$Tobr06_tabela?>">
                    <?=@$Lobr06_tabela?>
                </td>
                <td>
                    <?
                    $aTab = array("0"=>"Selecione",
                        "1" => "1 - Tabela SINAP",
                        "2" => "2 - Tabela SICRO",
                        "3" => "3 - Outras Tabelas Oficiais",
                        "4" => "4 - Cadastro Próprio" );
                    db_select('obr06_tabela',$aTab,true,$db_opcao," onchange='js_validatabela(this.value)'")
                    ?>
                </td>
                <td nowrap title="<?=@$Tobr06_versaotabela?>">
                    <?=@$Lobr06_versaotabela?>
                    <?
                    db_input('obr06_versaotabela',15,$Iobr06_versaotabela,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tobr06_descricaotabela?>">
                    <?=@$Lobr06_descricaotabela?>
                </td>
                <td colspan="3">
                    <?
                    db_textarea('obr06_descricaotabela',0,0,$Iobr06_descricaotabela,true,'text',$db_opcao,"","","",'250')
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tobr06_dtregistro?>">
                    <?=@$Lobr06_dtregistro?>
                </td>
                <td>
                    <?
                    db_inputdata('obr06_dtregistro',@$obr06_dtregistro_dia,@$obr06_dtregistro_mes,@$obr06_dtregistro_ano,true,'text',$db_opcao,"")
                    ?>
                </td>
                <td nowrap title="<?=@$Tobr06_dtcadastro?>">
                    <?=@$Lobr06_dtcadastro?>

                    <?
                    if(!isset($obr06_dtcadastro)) {
                        $obr06_dtcadastro_dia=date('d',db_getsession("DB_datausu"));
                        $obr06_dtcadastro_mes=date('m',db_getsession("DB_datausu"));
                        $obr06_dtcadastro_ano=date('Y',db_getsession("DB_datausu"));
                    }
                    db_inputdata('obr06_dtcadastro',@$obr06_dtcadastro_dia,@$obr06_dtcadastro_mes,@$obr06_dtcadastro_ano,true,'text',$db_opcao);
                    ?>
                </td>
                <td>
                    <?=@$Lobr06_codigotabela?>
                    <?
                    db_input('obr06_codigotabela',15,$Iobr06_codigotabela,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
        </table>

        <input name="Aplicar" type="button" id="Aplicar" value="Aplicar" style="width: 100px; margin-top: 7px; margin-bottom: 5px" onclick="js_aplicar();">

    </fieldset>
    <fieldset style="width: 100%;">
        <legend>Itens</legend>
        <table>
            <tr class="DBgrid">
                <td class="table_header" style="width: 35px; height:30px;" onclick="marcarTodos();">M</td>
                <td class="table_header" style="width: 87px">Códido do item</td>
                <td class="table_header" style="width: 300px">Descrição do Item</td>
                <td class="table_header" style="width: 178px">Tabela</td>
                <td class="table_header" style="width: 87px"> Versão da Tabela</td>
                <td class="table_header" style="width: 300px">Descrição Tabela</td>
                <td class="table_header" style="width: 150px">Data de Registro</td>
                <td class="table_header" style="width: 150px">Data de Cadastro</td>
                <td class="table_header" style="width: 87px"> Código da Tabela</td>
                <td class="table_header" style="width: 87px">Ação</td>
            </tr>
        </table>
        <?php

        if(!empty($l20_codigo)) {
            $sCampos  = " distinct pc01_codmater,pc01_descrmater,obr06_tabela,obr06_versaotabela,obr06_descricaotabela,obr06_dtregistro,obr06_dtcadastro,obr06_codigotabela,l21_ordem";
            $sOrdem   = "l21_ordem";
            $sWhere   = "l21_codliclicita = {$l20_codigo} ";
            $sSqlItemLicitacao = $cllicitemobra->sql_query_itens_obras_licitacao(null, $sCampos, $sOrdem, $sWhere);
            $sResultitens = $cllicitemobra->sql_record($sSqlItemLicitacao);
            $aItensObras = db_utils::getCollectionByRecord($sResultitens);
            $numrows = $cllicitemobra->numrows;
        }

        if(!empty($pc80_codproc)){
            $sCampos  = " distinct pc01_codmater,pc01_descrmater,obr06_tabela,obr06_versaotabela,obr06_descricaotabela,obr06_dtregistro,obr06_dtcadastro,obr06_codigotabela,pc11_seq";
            $sOrdem   = "pc11_seq";
            $sWhere   = "pc80_codproc = {$pc80_codproc} ";
            $sSqlItemProcessodeCompras = $cllicitemobra->sql_query_itens_obras_processodecompras(null, $sCampos, $sOrdem, $sWhere);
            $sResultitens = $cllicitemobra->sql_record($sSqlItemProcessodeCompras);
            $aItensObras = db_utils::getCollectionByRecord($sResultitens);
            $numrows = $cllicitemobra->numrows;
        }
        ?>
        <div style="overflow:scroll;overflow:auto">
            <table>
                <th class="table_header">
                    <?php foreach ($aItensObras as $key => $aItem):
                        if($aItem->obr06_tabela == ""){
                            $iItem = $aItem->pc01_codmater."0";
                        }else{
                            $iItem = $aItem->pc01_codmater.$aItem->obr06_tabela;
                        }

                        ?>
                        <table class="DBgrid">
                            <th class="table_header" style="width: 35px">
                                <input type="checkbox" class="marca_itens[<?= $iItem ?>]" name="aItonsMarcados" value="<?= $iItem ?>" id="<?= $iItem?>">
                            </th>

                            <td class="linhagrid" style="width: 87px">
                                <?= $aItem->pc01_codmater ?>
                                <input type="hidden" name="" value="<?= $aItem->pc01_codmater ?>" id="<?= $iItem?>">
                            </td>

                            <td class="linhagrid" style="width: 300px">
                                <?= $aItem->pc01_descrmater ?>
                                <input type="hidden" name="" value="<?= $aItem->pc01_descrmater ?>" id="<?= $iItem?>">
                            </td>

                            <td class="linhagrid" style="width: 178px">
                                <select name="tabela" id="<?= 'obr06_tabela_'.$iItem?>">
                                    <option value="0">Selecione</option>
                                    <option value="1">1 - Tabela SINAP</option>
                                    <option value="2">2 - Tabela SICRO</option>
                                    <option value="3">3 - Outras Tabelas Oficiais</option>
                                    <option value="4">4 - Cadastro Próprio</option>
                                </select>
                            </td>

                            <td class="linhagrid" style="width: 87px">
                                <input style="width: 80px" type="text" name="" value="<?= $aItem->obr06_versaotabela ?>" id="<?= 'obr06_versaotabela_'.$iItem?>">
                            </td>

                            <td class="linhagrid" style="width: 300px">
                                <input type="text" name="" value="<?= $aItem->obr06_descricaotabela ?>" id="<?= 'obr06_descricaotabela_'.$iItem?>">
                            </td>

                            <td class="linhagrid" style="width: 150px">
                                <?
                                $obr06_dtregistro = (implode("/",(array_reverse(explode("-",$aItem->obr06_dtregistro)))));
                                ?>
                                <?
                                db_inputdata('obr06_dtregistro_'.$iItem ,null,null,null,true,'text',1,"")
                                ?>
                            </td>

                            <td class="linhagrid" style="width: 150px">
                                <?
                                $obr06_dtcadastro = (implode("/",(array_reverse(explode("-",$aItem->obr06_dtcadastro)))));
                                ?>
                                <?php
                                db_inputdata('obr06_dtcadastro_'.$iItem ,null,null,null,true,'text',1,"")
                                ?>
                            </td>

                            <td class="linhagrid" style="width: 87px">
                                <input style="width: 80px" type="text" name="" value="<?= $aItem->obr06_codigotabela ?>" id="<?= 'obr06_codigotabela_'.$iItem?>">
                            </td>
                            <td class="linhagrid" style="width: 87px">
                                <input type="button" name="" value="Excluir" id="<?= $iItem?>" onclick="excluirLinha(<?=$iItem?>)">
                            </td>
                        </table>
                    <?php
                    endforeach;
                    ?>
                </th>

            </table>
        </div>
        <?
        if($numrows <= 0){
            echo "<div>Nenhum Item Encontrado !</div>";
        }
        ?>

        <br>
        <div>
            <input id="Salvar" type="button" value="Salvar" name="Salvar" onclick="js_salvarItens()">
            <input id="db_opcao" type="button" value="Excluir" name="excluir" onclick="js_excluirItensObra()">
        </div>
    </fieldset>
</form>
<script>

    function js_dataFormat(strData,formato){

        if(formato=='b'){
            aData = strData.split('/');
            return  aData[2]+'-'+aData[1]+'-'+aData[0];
        }else{
            aData = strData.split('-');
            return  aData[2]+'/'+aData[1]+'/'+aData[0];
        }
    }

    function js_pesquisa(){
        js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_licitemobra.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
    }
    function js_preenchepesquisa(chave){
        db_iframe_liclicita.hide();
        <?
        if($db_opcao!=1){
            echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
        }
        ?>
    }
    js_carregar_tabela();
    /**
     * funcao para retornar licitacao
     */
    function js_pesquisa_liclicita(mostra) {

        if (mostra == true) {

            js_OpenJanelaIframe('top.corpo',
                'db_iframe_liclicita',
                'func_liclicita.php?situacao=10&funcao_js=parent.js_preencheLicitacao|l20_codigo|l20_objeto',
                'Pesquisa Licitações', true);
        } else {

            if (document.form1.l20_codigo.value != '') {

                js_OpenJanelaIframe('top.corpo',
                    'db_iframe_liclicita',
                    'func_liclicita.php?situacao=10&pesquisa_chave=' +
                    document.form1.l20_codigo.value + '&funcao_js=parent.js_preencheLicitacao2',
                    'Pesquisa', false);
            } else {
                document.form1.l20_codigo.value = '';
            }
        }
    }

    /**
     * funcao para preencher licitacao  da ancora
     */
    function js_preencheLicitacao(codigo,objeto)
    {
        document.form1.l20_codigo.value = codigo;
        document.form1.l20_objeto.value = objeto;
        document.form1.pc80_codproc.value = '';
        document.form1.pc80_resumo.value = '';
        db_iframe_liclicita.hide();
    }

    function js_preencheLicitacao2(objeto,erro) {
        document.form1.l20_objeto.value = objeto;
        document.form1.pc80_codproc.value = '';
        document.form1.pc80_resumo.value = '';

        if(erro==true){
            alert("Nenhuma licitação encontrada.");
            document.form1.l20_objeto.value = "";
        }
    }

    function js_carregar() {
        let db_opcao = <?=$db_opcao?>;
        if(db_opcao != 1){
            js_pesquisa_codmater(false);
        }
    }


    /**
     * funcao para retornar processo de compra
     */
    function js_pesquisa_pcproc(mostra){
        if(mostra==true){
            js_OpenJanelaIframe('top.corpo','db_iframe_pcproc','func_pcproc.php?funcao_js=parent.js_mostrapcproc|pc80_codproc|pc80_resumo','Pesquisa',true);
        }else{
            if(document.form1.pc80_codproc.value != ''){
                js_OpenJanelaIframe('top.corpo','db_iframe_pcproc','func_pcproc.php?pesquisa_chave='+document.form1.pc80_codproc.value+'&itemobras=true&funcao_js=parent.js_mostrapcproc1','Pesquisa',false);
            }
        }
    }

    /**
     * funcao para carregar processo de compra
     */
    function js_mostrapcproc(chave,chave2){
        document.form1.pc80_codproc.value = chave;
        document.form1.pc80_resumo.value = chave2;
        db_iframe_pcproc.hide();

    }
    function js_mostrapcproc1(chave1,chave2,erro){
        document.form1.pc80_codproc.value = chave1;
        document.form1.pc80_resumo.value = chave2;
        document.form1.l20_codigo.value = '';
        document.form1.l20_objeto.value = '';
        if(erro==true){
            document.form1.pc80_codproc.focus();
            document.form1.pc80_codproc.value = '';
            document.form1.l20_codigo.value = '';
            document.form1.l20_objeto.value = '';
        }
    }

    /**
     * Retorna todos os itens
     */

    function aItens() {
        var itensNum = document.getElementsByName("aItonsMarcados");

        return Array.prototype.map.call(itensNum, function (item) {
            return item;
        });
    }

    /**
     * Marca todos os itens
     */
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

    function js_carregar_tabela() {
        let licitacao = document.form1.l20_codigo.value;
        let processodecompras = document.form1.pc80_codproc.value;
        try {
            BuscarItensAjax({
                exec: 'getItensObra',
                l20_codigo: licitacao,
                pc80_codproc: processodecompras
            }, preenchercampos);
        } catch(e) {
            alert(e.toString());
        }
        return false;
    }

    function BuscarItensAjax(params, onComplete) {
        js_divCarregando('Aguarde Buscando Informações', 'div_aguarde');
        var request = new Ajax.Request('obr1_obras.RPC.php', {
            method:'post',
            parameters:'json=' + JSON.stringify(params),
            onComplete: function(oRetornoitems) {
                js_removeObj('div_aguarde');
                onComplete(oRetornoitems);
            }
        });
    }

    function preenchercampos(oRetornoitems) {
        var oRetornoitens = JSON.parse(oRetornoitems.responseText);

        oRetornoitens.itens.forEach(function (item, x) {
            let tabela = item.obr06_tabela;
            if(item.obr06_tabela == ""){
                tabela = 0;
            }else{
                tabela = item.obr06_tabela;
            }
            document.getElementById('obr06_tabela_'+item.pc01_codmater+tabela).value = tabela;
            if(item.obr06_dtregistro != ""){
                document.getElementById('obr06_dtregistro_'+item.pc01_codmater+tabela).value = js_dataFormat(item.obr06_dtregistro,'u');
                document.getElementById('obr06_dtcadastro_'+item.pc01_codmater+tabela).value = js_dataFormat(item.obr06_dtcadastro,'u');
            }
        });
    }

    /**
     * Botão Aplicar
     */

    function js_aplicar() {

        let tabela          = document.getElementById('obr06_tabela').value;
        let versaotabela    = document.getElementById('obr06_versaotabela').value;
        let descricaotabela = document.getElementById('obr06_descricaotabela').value;
        let dtregistro      = document.getElementById('obr06_dtregistro').value;
        let dtcadastro      = document.getElementById('obr06_dtcadastro').value;
        let codigodatabela  = document.getElementById('obr06_codigotabela').value;
        // console.log(aItens());
        aItens().forEach(function (item) {
            // console.log(item.id);
            if(item.checked === true){
                document.getElementById('obr06_tabela_'+item.id).value = tabela;
                document.getElementById('obr06_versaotabela_'+item.id).value = versaotabela;
                document.getElementById('obr06_descricaotabela_'+item.id).value = descricaotabela;
                document.getElementById('obr06_dtregistro_'+item.id).value = dtregistro;
                document.getElementById('obr06_dtcadastro_'+item.id).value = dtcadastro;
                document.getElementById('obr06_codigotabela_'+item.id).value = codigodatabela;
            }
        })

    }

    /**
     * Retorna itens marcados
     */

    function getItensMarcados() {
        return aItens().filter(function (item) {
            return item.checked;
        });
    }

    /**
     * Salvar Itens
     */

    function js_salvarItens() {
        let itens = getItensMarcados();

        if (itens.length < 1) {
            alert('Selecione pelo menos um item da lista.');
            return false;
        }

        var itensEnviar = [];

        try {
            itens.forEach(function (item) {
                let coditem = item.id;

                var novoItem = {
                    obr06_pcmater:            coditem,
                    obr06_tabela:             document.getElementById('obr06_tabela_'+coditem).value,
                    obr06_descricaotabela:    document.getElementById('obr06_descricaotabela_'+coditem).value,
                    obr06_codigotabela:       document.getElementById('obr06_codigotabela_'+coditem).value,
                    obr06_versaotabela:       document.getElementById('obr06_versaotabela_'+coditem).value,
                    obr06_dtregistro:         document.getElementById('obr06_dtregistro_'+coditem).value,
                    obr06_dtcadastro:         document.getElementById('obr06_dtcadastro_'+coditem).value,
                };
                itensEnviar.push(novoItem);
            });
            salvarItemAjax({
                exec: 'SalvarItemObra',
                itens: itensEnviar,
            }, retornoAjax);
        } catch(e) {
            alert(e.toString());
        }
        return false;
    }

     function salvarItemAjax(params, onComplete) {
         js_divCarregando('Aguarde salvando', 'div_aguarde');
         var request = new Ajax.Request('obr1_obras.RPC.php', {
             method:'post',
             parameters:'json=' + JSON.stringify(params),
             onComplete: function(res) {
                 js_removeObj('div_aguarde');
                 onComplete(res);
             }
         });
     }

     function retornoAjax(res) {
         var response = JSON.parse(res.responseText);
         if (response.status != 1) {
             alert(response.message);
         }else{
             alert("Item salvo com sucesso!")
         }
     }

    function js_validatabela(value){

        if(value != 3){
            document.getElementById('obr06_descricaotabela').style.backgroundColor = '#E6E4F1'
        }else{
            document.getElementById('obr06_descricaotabela').style.backgroundColor = '#FFFFFF'

        }
    }

    /**
     * Excluir Itens
     */

    function js_excluirItensObra(){
        let itens = getItensMarcados();

        if (itens.length < 1) {
            alert('Selecione pelo menos um item da lista.');
            return false;
        }

        var itensEnviar = [];

        try {
            itens.forEach(function (item) {
                let coditem = item.id;

                var novoItem = {
                    obr06_pcmater:            coditem,
                    obr06_tabela:             document.getElementById('obr06_tabela_'+coditem).value,
                };
                itensEnviar.push(novoItem);
            });
            excluirItemAjax({
                exec: 'ExcluirItemObra',
                itens: itensEnviar,
            }, retornoexclusaoAjax);
        } catch(e) {
            alert(e.toString());
        }
        return false;
    }

    function excluirItemAjax(params, onComplete) {
        js_divCarregando('Aguarde Excluindo', 'div_aguarde');
        var request = new Ajax.Request('obr1_obras.RPC.php', {
            method:'post',
            parameters:'json=' + JSON.stringify(params),
            onComplete: function(res) {
                js_removeObj('div_aguarde');
                onComplete(res);
            }
        });
    }

    function retornoexclusaoAjax(res) {
        var response = JSON.parse(res.responseText);
        if (response.status != 1) {
            alert(response.message);
        }else{
            js_carregar_tabela();
            alert("Item Excluido com sucesso!")
        }
    }

    function excluirLinha(codigo) {
        var itensEnviar = [];

        try {
            var novoItem = {
                obr06_pcmater:            codigo,
                obr06_tabela:             document.getElementById('obr06_tabela_'+codigo).value,
            };
            itensEnviar.push(novoItem);
            excluirlinhaAjax({
                exec: 'ExcluirItemObra',
                itens: itensEnviar,
            }, retornoexclusaolinhaAjax);
        } catch(e) {
            alert(e.toString());
        }
        return false;
    }

    function excluirlinhaAjax(params, onComplete) {
        js_divCarregando('Aguarde Excluindo', 'div_aguarde');
        var request = new Ajax.Request('obr1_obras.RPC.php', {
            method:'post',
            parameters:'json=' + JSON.stringify(params),
            onComplete: function(res) {
                js_removeObj('div_aguarde');
                onComplete(res);
            }
        });
    }

    function retornoexclusaolinhaAjax(res) {
        var response = JSON.parse(res.responseText);
        if (response.status != 1) {
            alert(response.message);
        }else{
            js_carregar_tabela();
            alert("Item Excluido com sucesso!")
        }
    }

</script>
