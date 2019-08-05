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
                    db_select("l20_tipoprocesso",$al20_tipoprocesso,true,$db_opcao,"style=width: 100%;","","");
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
                    db_textarea('l20_veicdivulgacao',0,53,$Il20_veicdivulgacao,true,'text',$db_opcao,"onkeyup='limitaTextarea(this);'");
                    ?>
                </td>
            </tr>

            <tr>
                <td nowrap title="<?=@$Tl20_justificativa?>">
                    <strong>Justificativa:</strong>
                </td>
                <td>
                    <?
                    db_textarea('l20_justificativa',0,53,$Il20_justificativa,true,'text',$db_opcao,"onkeyup='limitaTextarea(this);'");
                    ?>
                </td>
            </tr>

            <tr>
                <td nowrap title="<?=@$Tl20_razao?>">
                    <strong>Razão:</strong>
                </td>
                <td>
                    <?
                    db_textarea('l20_razao',0,53,$Il20_razao,true,'text',$db_opcao,"onkeyup='limitaTextarea(this);'");
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <?php

    if(!empty($l20_codigo)) {

        $sCampos  = "DISTINCT pc81_codprocitem,pc11_seq,pc11_codigo,pc11_quant,pc11_vlrun,m61_descr,pc01_codmater,pc01_descrmater,pc11_resum";
        $sOrdem   = "pc11_seq";
        $sWhere   = "liclicitem.l21_codliclicita = {$l20_codigo} and pc24_pontuacao = 1";
        $sSqlItemLicitacao = $clhomologacaoadjudica->sql_query_itens(null, $sCampos, $sOrdem, $sWhere);
        $sResultitens = $clhomologacaoadjudica->sql_record($sSqlItemLicitacao);
        $aItensLicitacao = db_utils::getCollectionByRecord($sResultitens);
        $numrows = $clhomologacaoadjudica->numrows;
    }

    if($numrows > 0){
    ?>
    <table style="width: 65%;">
        <tr class="DBgrid">
            <td class="table_header" style="width: 35px; height:30px;" onclick="marcarTodos();">M</td>
            <td class="table_header" style="width: 44px">Ordem</td>
            <td class="table_header" style="width: 52px">Item</td>
            <td class="table_header" style="width: 260px">Descrição Item</td>
            <td class="table_header" style="width: 55px">Unidade</td>
            <td class="table_header" style="width: 80px">Valor Unitário</td>
            <td class="table_header" style="width: 120px">Quantidade Licitada</td>
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
        <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
        <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
    </div>
</form>

<script>

    function js_pesquisa(){
        js_OpenJanelaIframe('top.corpo','db_iframe_publicratificacao','func_liclicita.php?credenciamento=false&funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
    }

    function js_preenchepesquisa(chave){
        db_iframe_publicratificacao.hide();

        window.location.href = 'lic1_publicratificacao002.php?chavepesquisa='+chave;
    }

    /**
     * Funcao para mostrar campo data final quando for chamada publica e credenciamento
     *
     */

    function js_verificatipoproc() {
        let tipoproc = document.getElementById('l20_tipoprocesso').value;

        if(tipoproc === 102 || tipoproc === 103){
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
        if(mostra==true){
            js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_liclicita.php?credenciamento=true&funcao_js=parent.js_mostraliclicita1|l20_codigo|l20_objeto|tipocomtribunal','Pesquisa',true);
        }else{
            if(document.form1.l20_codigo.value != ''){
                js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_liclicita.php?credenciamento=true&pesquisa_chave='+document.form1.l20_codigo.value+'&tipoproc=true&funcao_js=parent.js_mostraliclicita','Pesquisa',false);
            }else{
                document.form1.l20_codigo.value = '';
            }
        }
    }
    function js_mostraliclicita(chave,chave2,erro){
        window.location.href = "lic1_publicratificacao001.php?l20_codigo="+document.form1.l20_codigo.value+"&l20_objeto="+chave+"&l20_tipoprocesso="+chave2;
        if(erro==true){
            document.form1.l20_codigo.focus();
            document.form1.l20_codigo.value = '';
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
                exec :'SalvarHomologacao',
                licitacao                  : document.getElementById('l20_codigo').value,
                l20_tipoprocesso           : document.getElementById('l20_tipoprocesso').value,
                l20_dtpubratificacao       : document.getElementById('l20_dtpubratificacao').value,
                l20_dtlimitecredenciamento : document.getElementById('l20_dtlimitecredenciamento').value,
                l20_veicdivulgacao         : document.getElementById('l20_veicdivulgacao').value,
                l20_justificativa          : document.getElementById('l20_justificativa').value,
                l20_razao                  : document.getElementById('l20_razao').value,
                itens                      : itensEnviar,
            }, retornoAjax);
        } catch(e) {
            alert(e.toString());
        }
        return false;
    }

    function salvarCredAjax(params, onComplete) {
        js_divCarregando('Aguarde Salvando', 'div_aguarde');
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
            alert(response.erro);
        } else if (response.erro == false) {
            alert('Salvo Com Sucesso!');
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
        js_divCarregando('Aguarde Salvando', 'div_aguarde');
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
        console.log(oRetornoitens);
        oRetornoitens.itens.forEach(function (item, x) {
            document.getElementById(item.l203_item).checked = true;
        });
        document.getElementById('l20_dtpubratificacao').value = oRetornoitens.dtpublicacao;
    }

</script>
