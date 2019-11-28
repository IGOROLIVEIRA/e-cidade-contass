<?php

$sqlConvAssoc = $clprevconvenioreceita->sql_query("",'','COALESCE(SUM(c229_vlprevisto),0) total_assinado',"","c229_fonte = {$c229_fonte} and c229_anousu = ".db_getsession('DB_anousu'));
db_fieldsmemory($clprevconvenioreceita->sql_record($sqlConvAssoc), 0);

$valor_atribuir = ($fValorPrev - $total_assinado);

if(isset($opcao) && $opcao=="alterar"){
    $db_opcao = 2;
    $clconvconvenios = new cl_convconvenios;
    $rsResult = $clconvconvenios->sql_record("select c206_objetoconvenio from convconvenios where c206_sequencial = $c229_convenio");
    db_fieldsmemory($rsResult, 0);
    $sObjeto = $c206_objetoconvenio;
    $iConvenioTemp = $c229_convenio;
}elseif(isset($opcao) && $opcao=="excluir" || isset($db_opcao) && $db_opcao==3){
    $db_opcao = 3;
    $clconvconvenios = new cl_convconvenios;
    $rsResult = $clconvconvenios->sql_record("select c206_objetoconvenio from convconvenios where c206_sequencial = $c229_convenio");
    db_fieldsmemory($rsResult, 0);
    $sObjeto = $c206_objetoconvenio;
}else{
    $db_opcao = 1;
}

?>
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
                        db_input('sReceita',100,'',true,'text',3,"")
                        ?>
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
                        <?=@$Lc229_vlprevisto?>
                    </td>
                    <td>
                        <?
                        db_input('c229_vlprevisto', 8, $Ic229_vlprevisto, true, 'float', $db_opcao,"");
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
    <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?'Incluir':($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
    <input name="pesquisar" type="submit" id="pesquisar" value="Limpar" onclick="js_limpa();">
    <input name="pesquisar" type="submit" id="pesquisar" value="Fechar" onclick="js_fecha();">
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <table align="center">
        <tr>
            <td valign="center">
                <?
                $chavepri= array("c229_fonte"=>@$c229_fonte,"c229_convenio"=>@$c229_convenio,"c229_vlprevisto"=>@$c229_vlprevisto);
                $cliframe_alterar_excluir->chavepri=$chavepri;
                if (isset($c229_fonte)&&@$c229_fonte!=""){
                    $cliframe_alterar_excluir->sql = $clprevconvenioreceita->sql_query("",'','*',"","c229_fonte = {$c229_fonte} and c229_anousu = ".db_getsession('DB_anousu'));
                }
                $cliframe_alterar_excluir->campos  ="c206_nroconvenio,c206_objetoconvenio,c206_dataassinatura,c229_vlprevisto,c229_convenio";
                $cliframe_alterar_excluir->legenda="CONVÊNIOS ASSOCIADOS";
                $cliframe_alterar_excluir->msg_vazio ="Não foi encontrado nenhum registro.";
                $cliframe_alterar_excluir->textocabec ="darkblue";
                $cliframe_alterar_excluir->textocorpo ="black";
                $cliframe_alterar_excluir->fundocabec ="#aacccc";
                $cliframe_alterar_excluir->fundocorpo ="#ccddcc";
                $cliframe_alterar_excluir->iframe_width ="900";
                $cliframe_alterar_excluir->iframe_height ="300";
                $lib=1;
                if ($db_opcao==3||$db_opcao==33){
                    $lib=4;
                }
                $cliframe_alterar_excluir->opcoes = @$lib;
                $cliframe_alterar_excluir->iframe_alterar_excluir(@$db_opcao);
                db_input('db_opcao',10,'',true,'hidden',3);
                ?>
            </td>
        </tr>
    </table>
</form>
<script>
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
        parent.form1['aFonte[<?= $index ?>][c229_vlprevisto]'].value = js_formatar(<?= $total_assinado ?>, "f");
        parent.form1['aFonte[<?= $index ?>][vlr_conveniosSemAssinatura]'].value = js_formatar(<?= ($fValorPrev - $total_assinado) ?>, "f");
        parent.db_iframe_conconvprevrec.hide();
    }

    parent.$('fechardb_iframe_conconvprevrec').onclick = function () {
        js_fecha();
    }

    function js_limpa() {
        document.form1.c229_convenio.value = '';
        document.form1.sObjeto.value = '';
        document.form1.c229_vlprevisto.value = '';
    }
</script>