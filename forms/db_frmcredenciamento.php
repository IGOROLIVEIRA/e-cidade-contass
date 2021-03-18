<?php
//MODULO: licitacao
include("dbforms/db_classesgenericas.php");
$clcredenciamento->rotulo->label();
$cliframe_seleciona = new cl_iframe_seleciona;
?>

<form name="form1" method="post" action="" style="margin-top: 2%;margin-left: 15%;" onsubmit="return js_ICredenciamento(this);">
    <fieldset style="width: 809px; margin-bottom: 5px;">
        <legend>
            <strong>Dados</strong>
        </legend>
        <table>
            <tr>
                <td nowrap title="<?=@$Tl205_fornecedor?>">
                    <?=@$Ll205_fornecedor?>
                </td>
                <td>
                    <?
                    $sWhere  = "l206_licitacao=".@$l20_codigo;
                    $result_forn = $clhabilitacaoforn->sql_record($clhabilitacaoforn->sql_query(null,"l206_fornecedor,z01_nome","",$sWhere));
                    db_selectrecord("l205_fornecedor",$result_forn,true,$db_opcao,"","","","","BuscarCredenciamento(this.value)");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tl205_datacred?>">
                    <?=@$Ll205_datacred?>
                </td>
                <td>
                    <?
                    db_inputdata('l205_datacred',@$l205_datacred_dia,@$l205_datacred_mes,@$l205_datacred_ano,true,'text',1,"")
                    ?>

                    <input name="Aplicar" type="button" id="Aplicar" value="Aplicar" onclick="aplicarDataCred();" >
                </td>
            </tr>

            <tr>
                <td>
                    <input name="l205_itens[]" type="hidden" id="l205_itens" value="">
                    <input name="pc20_codorc" type="hidden" id="pc20_codorc" value="<? echo $pc20_codorc ?>">
                    <input name="l205_licitacao" type="hidden" id="l205_licitacao" value="<? echo $l20_codigo ?>">
                </td>
            </tr>
        </table>
    </fieldset>
    <?php

    if(!empty($l20_codigo)) {

        $sCampos  = " distinct l21_ordem, l21_codigo, pc81_codprocitem, pc11_seq, pc11_codigo, pc11_quant, si02_vlprecoreferencia, ";
        $sCampos .= " m61_descr, pc01_codmater, pc01_descrmater, pc11_resum, pc23_obs";
        $sOrdem   = "l21_ordem";
        $sWhere   = "l21_codliclicita = {$l20_codigo} ";
        $sSqlItemLicitacao = $clliclicitem->sql_query_inf(null, $sCampos, $sOrdem, $sWhere);
        $sResultitens = $clliclicitem->sql_record($sSqlItemLicitacao);
        $aItensLicitacao = db_utils::getCollectionByRecord($sResultitens);
        $numrows = $clliclicitem->numrows;
        if ($numrows > 0) {
            $sWhere   = "l21_codliclicita = {$l20_codigo} and l205_fornecedor = {$l205_fornecedor} and l205_licitacao = {$l20_codigo}";
            $sql     = $clcredenciamento->itensCredenciados(null, $sCampos, $sOrdem, $sWhere);
            $result  = $clcredenciamento->sql_record($sql);
            $numrows = $clcredenciamento->numrows;
        }
    }
    ?>

    <table>
        <tr class="DBgrid">
            <td class="table_header" style="width: 35px; height:30px;" onclick="marcarTodos();">M</td>
            <td class="table_header" style="width: 44px">Ordem</td>
            <td class="table_header" style="width: 52px">Item</td>
            <td class="table_header" style="width: 259px">Descrição Item</td>
            <td class="table_header" style="width: 55px">Unidade</td>
            <td class="table_header" style="width: 80px">Valor Unitário</td>
            <td class="table_header" style="width: 120px">Quantidade Licitação</td>
            <td class="table_header" style="width: 142px">Data do Credenciamento</td>
        </tr>
    </table>

    <div style="overflow:scroll;height:60%;width:75%;overflow:auto">
        <table>
            <th class="table_header">
                <?php foreach ($aItensLicitacao as $key => $aItem):
                    $iItem = $aItem->pc81_codprocitem;

                    ?>
                    <table class="DBgrid">
                        <th class="table_header" style="width: 33px">
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
                            <?= $aItem->si02_vlprecoreferencia ?>
                            <input type="hidden" name="" value="<?= $aItem->si02_vlprecoreferencia ?>" id="<?= $iItem?>">
                        </td>

                        <td class="linhagrid" style="width: 120px">
                            <?= $aItem->pc11_quant ?>
                            <input type="hidden" name="" value="<?= $aItem->pc11_quant ?>" id="<?= $iItem?>">
                        </td>

                        <th class="linhagrid" style="width: 134px">
                            <?php
                            db_inputdata('l205_datacreditem'.$iItem ,null,null,null,true,'text',1,"") ?>
                        </th>
                    </table>
                <?php
                endforeach;
                ?>
            </th>

        </table>
    </div>
    <div style="width: 46%; padding-left: 28%; padding-top: 5px;">
        <input id="Salvar" type="submit" value="Salvar" name="Salvar" onclick="">
        <input id="db_opcao" type="button" value="Excluir" name="excluir" onclick="excluirCred()">
        <input id="Julgar" type="button" name="Julgar" value="Julgar" onclick="julgarLic()" disabled>
    </div>
</form>
<script>

    BuscarCredenciamento(document.getElementById('l205_fornecedor').value);
    getCredenciamento();
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

    /**
     * Botão Aplicar
     */

    function aplicarDataCred() {
        aItens().forEach(function (item) {
            if(item.checked === true){

                let dtCredenciamento = document.getElementById('l205_datacred').value;
                let dtCreditem = document.getElementById('l205_datacreditem'+item.id).value;

                if(dtCreditem === ''){
                    document.getElementById('l205_datacreditem'+item.id).value = dtCredenciamento;
                }

            }
        })
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
     * Retorna itens marcados
     */

    function getItensMarcados() {
        return aItens().filter(function (item) {
            return item.checked;
        });
    }

    /*inclur credenciamento*/

    function js_ICredenciamento(fORM) {
        let itens = getItensMarcados();

        if (itens.length < 1) {
            alert('Selecione pelo menos um item da lista.');
            return false;
        }

        var itensEnviar = [];

        try {
            itens.forEach(function (item) {
                let coditem = item.id;
                let sequencial = document.getElementById("l205_fornecedor").selectedIndex;

                var novoItem = {
                    sequenciaforne:        sequencial,
                    l205_fornecedor:       document.getElementById('l205_fornecedor').value,
                    l205_datacred:         document.getElementById('l205_datacred').value,
                    l205_item:             coditem,
                    l205_licitacao:        <? echo $l20_codigo?>,
                    l205_datacreditem:     document.getElementById('l205_datacreditem'+coditem).value
                };
                itensEnviar.push(novoItem);
            });
            salvarCredAjax({
                exec: 'SalvarCred',
                itens: itensEnviar,
                licitacao:<?= $l20_codigo?>
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
            alert('Credenciamento salvo com sucesso !');
            document.getElementById("l205_fornecedor").selectedIndex = response.sequecialforne + 1;
            document.getElementById("l205_fornecedordescr").selectedIndex = response.sequecialforne + 1;

            BuscarCredenciamento(document.getElementById("l205_fornecedor").value);
            getCredenciamento()
        }
        atualizaAbaFornecedor();
    }

    /*buscar credenciamento*/

    function BuscarCredenciamento(fornecedor) {

        try {
            BuscarCredAjax({
                exec: 'getCredforne',
                forne: fornecedor,
                licitacao: <?= $l20_codigo?>
            }, preenchercampos);
        } catch(e) {
            alert(e.toString());
        }
        return false;
    }

    function BuscarCredAjax(params, onComplete) {
        js_divCarregando('Aguarde Buscando Informações', 'div_aguarde');
        var request = new Ajax.Request('lic1_credenciamento.RPC.php', {
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
        let fornecedor = document.getElementById('l205_fornecedor').value;
        let itens = getItensMarcados();
        document.getElementById('l205_datacred').value = "";
        itens.forEach(function (item, x) {
            document.getElementById(item.id).checked = false;
            document.getElementById('l205_datacreditem'+item.id).value = "";
        });

        oRetornoitens.itens.forEach(function (item, x) {
            let datecred = new Date();
            document.getElementById('l205_datacred').value = FormataStringData(item.l205_datacred);
            document.getElementById(item.l205_item).checked = true;
            document.getElementById('l205_datacreditem'+item.l205_item).value = FormataStringData(item.l205_datacreditem);
        });
    }

    /*excluir credenciamento*/

    function excluirCred() {
        let fornecedor = document.getElementById('l205_fornecedor').value;
        try {
            excluirCredAjax({
                exec: 'excluirCred',
                forne: fornecedor,
                licitacao: <?= $l20_codigo?>
            }, retornoexcluirAjax);
        } catch(e) {
            alert(e.toString());
        }
        atualizaAbaFornecedor();
        return false;
    }

    function excluirCredAjax(params, onComplete) {
        js_divCarregando('Aguarde excluindo credenciamento', 'div_aguarde');
        var request = new Ajax.Request('lic1_credenciamento.RPC.php', {
            method:'post',
            parameters:'json=' + JSON.stringify(params),
            onComplete: function(oRetornoitems) {
                js_removeObj('div_aguarde');
                onComplete(oRetornoitems);
            }
        });
    }

    function retornoexcluirAjax(res) {
        var response = JSON.parse(res.responseText);
        if (response.status != 1) {
            alert(response.erro);
        } else if (response.erro == false) {
            alert('Credenciamento excluido com sucesso !');
            location.reload();
        }
    }

    /*julgar licitacao*/

    function julgarLic() {
        let fornecedor = document.getElementById('l205_fornecedor').value;
        try {
            julgarLicAjax({
                exec: 'julgarLic',
                licitacao: <?php echo $l20_codigo?>,
            }, oRetJulgamento);
        } catch(e) {
            alert(e.toString());
        }
        return false;
    }

    function julgarLicAjax(params, onComplete) {
        js_divCarregando('Aguarde julgando Licitação', 'div_aguarde');
        var request = new Ajax.Request('lic1_credenciamento.RPC.php', {
            method:'post',
            parameters:'json=' + JSON.stringify(params),
            onComplete: function(oRetornoitems) {
                js_removeObj('div_aguarde');
                onComplete(oRetornoitems);
            }
        });
    }

    function oRetJulgamento(res) {
        var response = JSON.parse(res.responseText);
        if (response.status != 1) {
            alert(response.erro);
        } else if (response.erro == false) {
            alert('Licitação julgada com sucesso !');
            location.reload();
        }
    }

    /**
     * faço uma consulta para verificar se existe intens credenciados em caso possitivo bloqueio
     * @returns {boolean}
     */
    function getCredenciamento() {
        try {
            verificaCred({
                exec: 'getCredenciamento',
                licitacao: <?php echo $l20_codigo?>,
            }, oValidabtnJulgar);
        } catch(e) {
            alert(e.toString());
        }
        return false;
    }

    function verificaCred(params, onComplete) {
        // js_divCarregando('Aguarde julgando Licitação', 'div_aguarde');
        var request = new Ajax.Request('lic1_credenciamento.RPC.php', {
            method:'post',
            parameters:'json=' + JSON.stringify(params),
            onComplete: function(oRetornoitems) {
                // js_removeObj('div_aguarde');
                onComplete(oRetornoitems);
            }
        });
    }

    function oValidabtnJulgar(res) {
        var oRetornoitens = JSON.parse(res.responseText);
        let qtditens = oRetornoitens.itens.length;

      if(qtditens > 0){
        document.getElementById('Julgar').disabled = false;
        oRetornoitens.itens.forEach(function (itens, x){
          if(itens.l20_licsituacao === '1' || itens.l20_licsituacao === '10'){
            document.getElementById('Julgar').disabled = true;
          }
        });
      }
    }

    function atualizaAbaFornecedor(){
        top.corpo.iframe_db_forn.location.href='lic1_fornec002.php?chavepesquisa=<?= $l20_codigo?>';
    }
</script>
