<?
//MODULO: licitacao
$clliclicita->rotulo->label();

?>
<form name="form1" method="post" action="" style="margin-left: 20%;margin-top: 2%;" onsubmit="return js_IHomologacao(this);">
    <fieldset style="width: 62.5%">
        <legend>
            <b>Dispensa/Inexigibilidade</b>
        </legend>

        <table>
            <tr>
                <td>
                    <?
                    db_ancora("Licitação:","js_pesquisaLicitacao(true);",$db_opcao);
                    ?>
                </td>
                <td>
                    <?
                    db_input('l20_codigo',10,$Il20_codigo,true,'text',$db_opcao," onchange='js_pesquisaLicitacao(false);'")
                    ?>
                    <?
                    db_input('l20_objeto',40,$Il20_objeto,true,'text',3,'')
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Tipo de Processo:</strong>
                </td>
                <td>
                    <?
                    $al20_tipoprocesso = array("0"=>"","101"=>"Dispensa","100"=>"Inexigibilidade","102"=>"Inexigibilidade por credenciamento/chamada pública","103"=>"Dispensa por chamada publica");
                    db_select("l20_tipoprocesso",$al20_tipoprocesso,true,3,"","","");
                    ?>
                </td>
            </tr>

            <tr id="trdtlimitecredenciamento" style="display: none">
                <td>
                    <strong>Data Final do Credenciamento:</strong>
                </td>
                <td>
                    <?
                    db_inputdata("l20_dtlimitecredenciamento",$l20_dtlimitecredenciamento,true,$db_opcao,"style=width: 100%;","","");
                    ?>
                </td>
            </tr>

            <tr>
                <td nowrap title="<?=@$Tl20_dtpubratificacao?>">
                    <strong>Data Publicação Termo Ratificação:</strong>
                </td>
                <td>
                    <?
                    db_inputdata('l20_dtpubratificacao',$l20_dtpubratificacao,true,$db_opcao,"","","");
                    ?>
                </td>
            </tr>

            <tr>
                <td nowrap title="<?=@$Tl20_veicdivulgacao?>">
                    <strong>Veiculo de Divulgação:</strong>
                </td>
                <td>
                    <?
                    db_textarea('l20_veicdivulgacao',0,53,$Il20_veicdivulgacao,true,'text',$db_opcao,"onkeyup='limitaTextarea(this);'","","#ffffff");
                    ?>
                </td>
            </tr>

<!--            <tr>-->
<!--                <td nowrap title="--><?//=@$Tl20_justificativa?><!--">-->
<!--                    <strong>Justificativa:</strong>-->
<!--                </td>-->
<!--                <td>-->
<!--                    --><?//
//                    db_textarea('l20_justificativa',0,53,$Il20_justificativa,true,'text',$db_opcao,"onkeyup='limitaTextarea(this);'","","#ffffff");
//                    ?>
<!--                </td>-->
<!--            </tr>-->
<!---->
<!--            <tr>-->
<!--                <td nowrap title="--><?//=@$Tl20_razao?><!--">-->
<!--                    <strong>Razão:</strong>-->
<!--                </td>-->
<!--                <td>-->
<!--                    --><?//
//                    db_textarea('l20_razao',0,53,$Il20_razao,true,'text',$db_opcao,"onkeyup='limitaTextarea(this);'","","#ffffff");
//                    ?>
<!--                </td>-->
<!--            </tr>-->
        </table>
    </fieldset>
    <?php

    if(!empty($l20_codigo)) {

        $sCampos  = "DISTINCT pc81_codprocitem,pc11_seq,pc11_codigo,pc11_quant,pc11_vlrun,m61_descr,pc01_codmater,pc01_descrmater,pc11_resum";
        $sOrdem   = "pc11_seq";
        $sWhere   = "liclicitem.l21_codliclicita = {$l20_codigo} ";
//        var_dump($l20_tipoprocesso);
        if($l20_tipoprocesso != "103" && $l20_tipoprocesso != "102"){
            $sWhere  .= "and pc24_pontuacao = 1";
        }
        $sSqlItemLicitacao = $clhomologacaoadjudica->sql_query_itens(null, $sCampos, $sOrdem, $sWhere);
//        die($sSqlItemLicitacao);
        $sResultitens = $clhomologacaoadjudica->sql_record($sSqlItemLicitacao);
        $aItensLicitacao = db_utils::getCollectionByRecord($sResultitens);
        $numrows = $clhomologacaoadjudica->numrows;
    }

    if($numrows > 0){
    ?>
    <table style="width: 65%;">
        <tr class="DBgrid">
            <td class="table_header" style="width: 33px; height:30px;" onclick="marcarTodos();">M</td>
            <td class="table_header" style="width: 40px">Ordem</td>
            <td class="table_header" style="width: 50px">Item</td>
            <td class="table_header" style="width: 235px">Descrição Item</td>
            <td class="table_header" style="width: 50px">Unidade</td>
            <td class="table_header" style="width: 72px">Valor Unitário</td>
            <td class="table_header" style="width: 125px">Quantidade Licitada</td>
        </tr>
    </table>

    <div style="overflow:scroll;height:30%;width:65%;">
        <table>
            <th class="table_header">
                <?php foreach ($aItensLicitacao as $key => $aItem):
                    $iItem = $aItem->pc81_codprocitem;

                    ?>
                    <table class="DBgrid">
                        <th class="table_header" style="width: 32px">
                            <input type="checkbox" class="marca_itens[<?= $iItem ?>]" name="aItonsMarcados" value="<?= $iItem ?>" id="<?= $iItem?>">
                        </th>

                        <td class="linhagrid" style="width: 44px">
                            <?= $aItem->pc11_seq ?>
                            <input type="hidden" name="" value="<?= $aItem->pc11_seq ?>" id="<?= $iItem?>">
                        </td>

                        <td class="linhagrid" style="width: 52px">
                            <?= $aItem->pc81_codprocitem ?>
                            <input type="hidden" name="" value="<?= $aItem->pc81_codprocitem ?>" id="<?= $iItem?>">
                        </td>

                        <td class="linhagrid" style="width: 260px">
                            <?= $aItem->pc01_descrmater ?>
                            <input type="hidden" name="" value="<?= $aItem->pc01_descrmater ?>" id="<?= $iItem?>">
                        </td>

                        <td class="linhagrid" style="width: 55px">
                            <?= $aItem->m61_descr ?>
                            <input type="hidden" name="" value="<?= $aItem->m61_descr ?>" id="<?= $iItem?>">
                        </td>

                        <td class="linhagrid" style="width: 80px">
                            <?= $aItem->pc11_vlrun ?>
                            <input type="hidden" name="" value="<?= $aItem->pc11_vlrun ?>" id="<?= $iItem?>">
                        </td>

                        <td class="linhagrid" style="width: 120px">
                            <?= $aItem->pc11_quant ?>
                            <input type="hidden" name="" value="<?= $aItem->pc11_quant ?>" id="<?= $iItem?>">
                        </td>

                    </table>
                <?php
                endforeach;
                ?>
            </th>
        </table>
        <?php
        }
        ?>
    </div>
    <div style="margin-left: 25%;">
        <?php if($db_opcao == 11 || $db_opcao == 1):?>
            <input name="Incluir" type="submit" id="incluir" value="Incluir">
        <?php elseif ($db_opcao == 22 || $db_opcao == 2):?>
            <input name="Alterar" type="button" id="excluir" value="Alterar" onclick="js_AHomologacao()">
        <?php else :?>
            <input name="Excluir" type="button" id="excluir" value="Excluir" onclick="js_EHomologacao()" >
        <?php endif;?>
        <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa(<?= $db_opcao == 1 ? false : true ?>);" >
    </div>
</form>

<script>
    js_verificatipoproc();

    function js_pesquisa(ratificacao=false){
        if(ratificacao) {
            js_OpenJanelaIframe('top.corpo','db_iframe_publicratificacao','func_liclicita.php?credenciamento=true&situacao=10&ratificacao=true&funcao_js=parent.js_preenchepesquisa|l20_codigo|tipocomtribunal','Pesquisa',true);
        }else {
            js_OpenJanelaIframe('top.corpo','db_iframe_publicratificacao','func_liclicita.php?credenciamento=true&situacao=1&ratificacao=false&funcao_js=parent.js_preenchepesquisa|l20_codigo|tipocomtribunal','Pesquisa',true);
        }
    }

    function js_preenchepesquisa(chave,tipocompratribunal){
        db_iframe_publicratificacao.hide();
        let db_opcao = <?= $db_opcao?>;
        if(db_opcao === 33 || db_opcao === 3){
            window.location.href = "lic1_publicratificacao003.php?chavepesquisa="+chave+"&l20_tipoprocesso="+tipocompratribunal;
        }else if(db_opcao === 22 || db_opcao === 2){
            window.location.href = "lic1_publicratificacao002.php?chavepesquisa="+chave+"&l20_tipoprocesso="+tipocompratribunal;
        }
    }

    /**
     * Funcao para mostrar campo data final quando for chamada publica e credenciamento
     *
     */

    function js_verificatipoproc() {
        let tipoproc = document.getElementById('l20_tipoprocesso').value;

        if(tipoproc === '102' || tipoproc === '103'){
            document.getElementById('trdtlimitecredenciamento').style.display = "";
        }
    }

    /**
     * Função para limitar texaarea*
     *
     */
    function limitaTextarea(valor){
        var qnt = valor.value;
        quantidade = 80;
        total = qnt.length;

        if(total <= quantidade) {
            resto = quantidade- total;
            document.getElementById('contador').innerHTML = resto;
        } else {
            document.getElementById(valor.name).value = qnt.substr(0, quantidade);
            alert("Olá. Para atender  as normas do TCE MG / SICOM, este campo é  limitado. * LIMITE ALCANÇADO * !");
        }
    }

    /***
     * Função para Busca licitações e Carregar itens
     *
     */
    function js_pesquisaLicitacao(mostra){
        let opcao = <?=$db_opcao?>;
        if(mostra==true){
            if(opcao == 1){
                js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_liclicita.php?credenciamento=true&situacao=1&funcao_js=parent.js_mostraliclicita1|l20_codigo|l20_objeto|tipocomtribunal','Pesquisa',true);
            }else{
                js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_liclicita.php?credenciamento=true&funcao_js=parent.js_mostraliclicita1|l20_codigo|l20_objeto|tipocomtribunal','Pesquisa',true);
            }
        }else{
            if(document.form1.l20_codigo.value != ''){
                if(opcao == 1){
                    js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_liclicita.php?credenciamento=true&situacao=1&pesquisa_chave='+document.form1.l20_codigo.value+'&tipoproc=true&funcao_js=parent.js_mostraliclicita','Pesquisa',false);
                }else{
                    js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_liclicita.php?credenciamento=true&pesquisa_chave='+document.form1.l20_codigo.value+'&tipoproc=true&funcao_js=parent.js_mostraliclicita','Pesquisa',false);
                }
            }else{
                document.form1.l20_codigo.value = '';
            }
        }
    }
    function js_mostraliclicita(chave,erro, chave2){
        document.form1.l20_objeto.value = chave;
        if(erro==true){
            document.form1.l20_codigo.focus();
            document.form1.l20_codigo.value = '';
        }else{
            window.location.href = "lic1_publicratificacao001.php?l20_codigo="+document.form1.l20_codigo.value+"&l20_objeto="+chave+"&l20_tipoprocesso="+chave2;
        }

    }

    function js_mostraliclicita1(chave1,chave2,chave3){
        window.location.href = "lic1_publicratificacao001.php?l20_codigo="+chave1+"&l20_objeto="+chave2+"&l20_tipoprocesso="+chave3;
        db_iframe_liclicita.hide();
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

    function FormataStringData(data) {
        //js_FormatarStringData
        //Funcao para retornar data no formato dd/mm/yyyy
        //para deve ser do tipo yyyy-mm-dd

        var ano  = data.split("-")[0];
        var mes  = data.split("-")[1];
        var dia  = data.split("-")[2];

        return ("0"+dia).slice(-2) + '/' + ("0"+mes).slice(-2) + '/' + ano;
        // Utilizo o .slice(-2) para garantir o formato com 2 digitos.
    }
    /**
     * Marca todos os itens
     *
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

    /**
     * Retorna itens marcados
     */

    function getItensMarcados() {
        return aItens().filter(function (item) {
            return item.checked;
        });
    }

    /**
     *Salva os itens do homologados
     *
     */

    function js_IHomologacao() {
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
                    l205_item            :coditem,
                };
                itensEnviar.push(novoItem);
            });
            salvarCredAjax({
                exec :'salvarHomo',
                licitacao                  : document.getElementById('l20_codigo').value,
                l20_tipoprocesso           : document.getElementById('l20_tipoprocesso').value,
                l20_dtpubratificacao       : document.getElementById('l20_dtpubratificacao').value,
                l20_dtlimitecredenciamento : document.getElementById('l20_dtlimitecredenciamento').value,
                l20_veicdivulgacao         : document.getElementById('l20_veicdivulgacao').value,
                // l20_justificativa          : document.getElementById('l20_justificativa').value,
                // l20_razao                  : document.getElementById('l20_razao').value,
                itens                      : itensEnviar,
            }, retornoAjax);
        } catch(e) {
            alert(e.toString());
        }
        return false;
    }

    function salvarCredAjax(params, onComplete) {
        js_divCarregando('Aguarde salvando', 'div_aguarde');
        var request = new Ajax.Request('lic1_credenciamento.RPC.php', {
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
            alert(response.message.urlDecode());
        } else if (response.erro == false) {
            alert('Salvo com sucesso!');
            window.location.href = "lic1_publicratificacao001.php";
        }
    }

    /**
     * Alterar Homologação
     *
     */
    function js_AHomologacao() {
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
                    l205_item            :coditem,
                };
                itensEnviar.push(novoItem);
            });
            aHomoAjax({
                exec :'alterarHomo',
                licitacao                  : document.getElementById('l20_codigo').value,
                l20_tipoprocesso           : document.getElementById('l20_tipoprocesso').value,
                l20_dtpubratificacao       : document.getElementById('l20_dtpubratificacao').value,
                l20_dtlimitecredenciamento : document.getElementById('l20_dtlimitecredenciamento').value,
                l20_veicdivulgacao         : document.getElementById('l20_veicdivulgacao').value,
                // l20_justificativa          : document.getElementById('l20_justificativa').value,
                // l20_razao                  : document.getElementById('l20_razao').value,
                itens                      : itensEnviar,
            }, oRetornoAjax);
        } catch(e) {
            alert(e.toString());
        }
        return false;
    }

    function aHomoAjax(params, onComplete) {
        js_divCarregando('Aguarde salvando', 'div_aguarde');
        var request = new Ajax.Request('lic1_credenciamento.RPC.php', {
            method:'post',
            parameters:'json=' + JSON.stringify(params),
            onComplete: function(res) {
                js_removeObj('div_aguarde');
                onComplete(res);
            }
        });
    }

    function oRetornoAjax(res) {
        var response = JSON.parse(res.responseText);
        if (response.status != 1) {
            alert(urlDecode(response.message));
        } else if (response.erro == false) {
            alert('Salvo com sucesso!');
            window.location.href = "lic1_publicratificacao001.php";
        }
    }

    /**
     * Função para buscar itens para homologação
     */
    function BuscarItens() {

        try {
            carregarItens({
                exec: 'getItensHomo',
                licitacao: document.getElementById('l20_codigo').value,
            }, oretornoitens);
        } catch(e) {
            alert(e.toString());
        }
        return false;
    }

    function carregarItens(params, onComplete) {
        js_divCarregando('Aguarde salvando', 'div_aguarde');
        var request = new Ajax.Request('lic1_credenciamento.RPC.php', {
            method:'post',
            parameters:'json=' + JSON.stringify(params),
            onComplete: function(res) {
                js_removeObj('div_aguarde');
                onComplete(res);
            }
        });
    }

    function oretornoitens(res) {
        var oRetornoitens = JSON.parse(res.responseText);
        oRetornoitens.itens.forEach(function (item, x) {
            document.getElementById(item.l203_item).checked = true;
        });

        if(oRetornoitens.dtpublicacao === ""){
            document.getElementById('l20_dtpubratificacao').value = "";
        }else{
            document.getElementById('l20_dtpubratificacao').value = FormataStringData(oRetornoitens.dtpublicacao);
        }

        if(oRetornoitens.dtlimitecredenciamento === ""){
            document.getElementById('l20_dtlimitecredenciamento').value = "";
        }else{
            document.getElementById('l20_dtlimitecredenciamento').value = FormataStringData(oRetornoitens.dtlimitecredenciamento);
        }
    }

    /**
     * Excluir Homologação
     *
     */
    function js_EHomologacao() {
        try {
            excluirhomologacao({
                exec: 'excluirHomo',
                licitacao: document.getElementById('l20_codigo').value,
            }, oretornoexclusao);
        } catch(e) {
            alert(e.toString());
        }
        return false;
    }

    function excluirhomologacao(params, onComplete) {
        js_divCarregando('Aguarde salvando', 'div_aguarde');
        var request = new Ajax.Request('lic1_credenciamento.RPC.php', {
            method:'post',
            parameters:'json=' + JSON.stringify(params),
            onComplete: function(res) {
                js_removeObj('div_aguarde');
                onComplete(res);
            }
        });
    }

    function oretornoexclusao(res) {
        var oRetornoitens = JSON.parse(res.responseText);
        if (oRetornoitens.status != 1) {
            alert(oRetornoitens);
        } else if (oRetornoitens.erro == false) {
            alert('Homologação excluida com sucesso !');
            window.location.href = "lic1_publicratificacao003.php";
        }
    }
</script>
