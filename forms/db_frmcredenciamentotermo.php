<?
//MODULO: licitacao
$clcredenciamentotermo->rotulo->label();
?>
<style>
    #l212_observacao {
        width: 926px;
        height: 126px;
    }
    #l212_sequencial, #l212_numerotermo{
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
    <fieldset style="align-items: center; width: 50%; margin-top: 30px; margin-left: 20%">
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
                    db_input('l212_numerotermo',19,$Il212_numerotermo,true,'text',3,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tl212_fornecedor?>">
                    <?=@$Ll212_fornecedor?>
                </td>
                <td>
                    <?
                    db_select('l212_fornecedor', $aTabFonec, true, $db_opcao, " onchange='' style='width:452;' ");
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
                    db_textarea('l212_veiculodepublicacao',0,0,$Il212_veiculodepublicacao,true,'text',3,"")
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
    </div>
</form>
<script>
    var db_opcao = <?= $db_opcao?>;

    if(db_opcao != 1){
        mostrarFornecedores();
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
                'db_iframe_licobras',
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
        db_iframe_licobras.hide();
        mostrarFornecedores();
    }

    function mostrarFornecedores() {

        let select = $('#l212_fornecedor');
        var db_opcao = <?= $db_opcao?>;

        if(db_opcao !=1){
            // Cria option "default"
            let defaultOpt = document.createElement('option');
            defaultOpt.textContent = 'Selecione uma opção';
            defaultOpt.value = '0';
            select.append(defaultOpt);
        }

        //Busco Elementos de acordo com a tabela
        let params = {
            action: 'getFornecedores',
            l212_licitacao: $('#l212_licitacao').val(),
        };

        $.ajax({
            type: "POST",
            url: "lic_termocredenciamento.RPC.php",
            data: params,
            success: function(data) {

                let fornecedores = JSON.parse(data);

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
            }
        });
        if(db_opcao == 1){
            mostrarNumeroTermo();
        }
    }

    function mostrarNumeroTermo() {

        var oParam = new Object();
        oParam.action = "getNumeroTermo";
        $.ajax({
            type: "POST",
            url: "emp1_empautitemcredenciamentotermo.RPC.php",
            data: oParam,
            success: function(data) {
                let response = JSON.parse(data);
                document.form1.l212_numerotermo.value = response.numerotermo;
            }
        });
    }

</script>
