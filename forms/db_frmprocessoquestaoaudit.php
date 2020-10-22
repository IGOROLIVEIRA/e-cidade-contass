<?
//MODULO: Controle Interno
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$cltipoquestaoaudit->rotulo->label("ci01_tipoaudit");

if (isset($ci03_codtipoquest) && $ci03_codtipoquest != null) {
    $db_botao = true;
    $db_opcao = 2;
} else {
    $db_opcao = 1;
    $db_botao =true;
} 
?>

<form name="form1" method="post" action="" >
    <center>
        <fieldset class="fildset-principal">
            <legend>
                <b>Questões de Auditoria</b>
            </legend>
            <table border="0">
                <tr>
                    <td align="left">
                        <? db_ancora(@$Lci01_tipoaudit,"js_pesquisaTipoQuestao(true);",1);  ?>
                    </td>
                    <td colspan="2">
                        <?  db_input('ci01_codtipo',10,$Ici01_codtipo,true,'text',1," onchange='js_pesquisaTipoQuestao(false);'");
                            db_input('ci01_tipoaudit',50,$Ic50_descr,true,'text',3); ?>
                    </td>
                </tr>
            </table>
        </fieldset>
    </center>
    <table>
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
    
    <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":""))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":""))?>" <?=($db_botao==false?"disabled":"")?> >
    <? if (isset($ci03_codtipoquest) && $ci03_codtipoquest != null) { ?>
        <input name="excluir" type="submit" value="Excluir">
    <? } ?>

    <table>
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>

    <table>
        <tr>
            <td valign="top"  align="center">  
            <?
                $chavepri= array("ci02_codquestao"=>@$ci02_codquestao);
                $cliframe_alterar_excluir->chavepri=$chavepri;
                $cliframe_alterar_excluir->sql     = $clquestaoaudit->sql_query_file(null,"*","ci02_numquestao","ci02_codtipo = $ci03_codtipoquest and ci02_instit = ".db_getsession('DB_instit'));
                $cliframe_alterar_excluir->campos  ="ci02_numquestao,ci02_questao,ci02_inforeq,ci02_fonteinfo,ci02_procdetal,ci02_objeto,ci02_possivachadneg";
                $cliframe_alterar_excluir->legenda="QUESTÕES ASSOCIADAS";
                $cliframe_alterar_excluir->iframe_height ="320";
                $cliframe_alterar_excluir->iframe_width ="822";
                $cliframe_alterar_excluir->iframe_alterar_excluir(33);
                    ?>
            </td>
        </tr>
    </table>
</form>
<script>
    function js_pesquisaTipoQuestao(lMostra) {

        if (lMostra) {
            js_OpenJanelaIframe('','db_iframe_tipoquestaoaudit','func_tipoquestaoaudit.php?funcao_js=parent.js_mostraTipoQuestao1|ci01_codtipo|ci01_tipoaudit','Pesquisa',true,0);
        } else {
            js_OpenJanelaIframe('','db_iframe_tipoquestaoaudit','func_tipoquestaoaudit.php?pesquisa_chave='+document.form1.ci01_codtipo.value+'&tipo=true&funcao_js=parent.js_mostraTipoQuestao','Pesquisa',false,0);
        }
    }

    function js_mostraTipoQuestao(chave, erro) {

        document.form1.ci01_tipoaudit.value = chave;
        if(erro == true) {
            document.form1.ci01_codtipo.focus();
            document.form1.ci01_tipoaudit = '';
        }

    }

    function js_mostraTipoQuestao1(chave1, chave2) {

        document.form1.ci01_codtipo.value = chave1;
        document.form1.ci01_tipoaudit.value = chave2;
        db_iframe_tipoquestaoaudit.hide();
    
    }
</script>

<? if (isset($ci03_codtipoquest) && $ci03_codtipoquest != null) { ?>
    <script>
        document.form1.ci01_codtipo.value = <?= $ci03_codtipoquest ?>;
        document.getElementById("ci01_codtipo").onchange();
    </script>
<? } ?>    