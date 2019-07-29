<?
//MODULO: licitacao
$clliclicita->rotulo->label();
?>
<form name="form1" method="post" action="" style="margin-left: 40%;margin-top: 4%;">
        <fieldset>
            <legend><b>Dispensa/Inexigibilidade</b></legend>

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

                <tr>
                    <td nowrap title="<?=@$Tl20_dtpubratificacao?>">
                        <strong>Data Publicação Termo Ratificação:</strong>
                    </td>
                    <td>
                        <?//echo $l20_dtpubratificacao;exit;
                        db_inputdata('l20_dtpubratificacao',@$l20_dtpubratificacao_dia,@$l20_dtpubratificacao_mes,@$l20_dtpubratificacao_ano,true,'text',55,"");
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
     <table>
         <tr>
             <td style="width: 50%;">

             </td>
             <td>
                 <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
                 <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
             </td>
         </tr>
     </table>
</form>
<script>
    function js_pesquisa(){
        js_OpenJanelaIframe('top.corpo','db_iframe_publicratificacao','func_liclicita.php?credenciamento=false&funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
    }
    function js_preenchepesquisa(chave){
        db_iframe_publicratificacao.hide();
        <?
        if($db_opcao!=1){
            echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
        }
        ?>
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
     * Função para Busca licitações
     */
    function js_pesquisaLicitacao(mostra){
        if(mostra==true){
            js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_liclicita.php?credenciamento=true&funcao_js=parent.js_mostraliclicita1|l20_codigo|l20_objeto|tipocomtribunal','Pesquisa',true);
        }else{
            if(document.form1.l202_licitacao.value != ''){
                js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_lichomologa.php?func_lichomologa.php?situacao=1&pesquisa_chave='+document.form1.l202_licitacao.value+'&funcao_js=parent.js_mostraliclicita&validafornecedor=1','Pesquisa',false);
            }else{
                document.form1.l20_codigo.value = '';
            }
        }
    }
    function js_mostraliclicita(chave,erro){
        document.form1.pc50_descr.value = chave;
        if(erro==true){
            document.form1.l202_licitacao.focus();
            document.form1.l202_licitacao.value = '';
        }
    }
    /**
     * Função alterada para receber o parametro da numeração da modalidade.
     * Acrescentado o parametro chave3 que recebe o l20_numero vindo da linha 263.
     * Solicitado por danilo@contass e deborah@contass
     */
    function js_mostraliclicita1(chave1,chave2,chave3){
        document.form1.l20_codigo.value = chave1;
        document.form1.l20_objeto.value = chave2;
        document.form1.l20_tipoprocesso.value = chave3;
        db_iframe_liclicita.hide();
    }

</script>
