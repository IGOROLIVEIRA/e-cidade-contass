<?
//MODULO: Controle Interno
$clmatrizachadosaudit->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label('ci02_questao');
$clrotulo->label('ci02_numquestao');
$clrotulo->label('ci05_achados');

if (isset($ci03_numproc) && $ci03_numproc != '' && isset($ci03_anoproc) && $ci03_anoproc != '') {
    $ci03_numproc = $ci03_numproc.'/'.$ci03_anoproc;
}

?>

<fieldset>
    <legend>
        <b>Matriz de Achados</b>
    </legend>
    <table>
        <tr><th>Selecione a questão de auditoria no quadro abaixo e em seguida preencha os campos em branco.</th></tr>
        <tr>
            <td><? db_lovrot($sSqlQuestoes,15,"()","","js_buscaQuestao|ci02_numquestao", "", "NoMe"); ?></td>
        </tr> 
    </table>
    <form name="form1" method="post" action="">  
        <table border="0"> 
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <input name="ci03_codproc" value="<?= $ci03_codproc ?>" type="hidden" >
            <input name="ci06_codlan" id="ci06_codlan" value="<?= $ci06_codlan ?>" type="hidden" >
            <tr>
                <td align="right" nowrap title="Processo">
                    <b>Processo:</b>
                </td>
                <td style="width: 80px;"> 
                    <? db_input('ci03_numproc',11,$Ici03_numproc,true,'text',3,"") ?>
                </td>
                <td align="right" nowrap title="<?=@$Tci06_seq?>" style="width: 80px;">
                    <?=@$Lci06_seq?>
                </td>
                <td style="width: 80px;"> 
                    <? db_input('ci06_seq',11,$Ici06_seq,true,'text',3,"") ?>
                </td>
                <td nowrap title="<?=@$Tci02_numquestao?>" align="right" style="width: 80px;">
                    <?=@$Lci02_numquestao?>
                </td>
                <td style="width: 80px;" align="right"> 
                    <? db_input('ci06_numquestao',11,$Ici02_numquestao,true,'text',3,"") ?>
                </td>
            </tr>    
            <tr>
                
            </tr>    
            <tr>
                
            </tr>   
            <tr>
                <td nowrap title="<?=@$Tci02_questao?>" align="right">
                    <?=@$Lci02_questao?>
                </td>
                <td colspan="5"> 
                    <? db_textarea("ci02_questao",3,75, "", true, "text", 3, "", "", "",500); ?>
                </td>
            </tr>    
            <tr>
                <td nowrap title="<?=@$Tci05_achados?>" align="right">
                    <b>Descrição do Achado:</b>
                </td>
                <td colspan="5"> 
                    <? db_textarea("ci05_achados",3,75, "", true, "text", 3, "", "", "",500); ?>
                </td>
            </tr>    
            <tr>
                <td nowrap title="<?=@$Tci06_situencont?>" align="right">
                    <?=@$Lci06_situencont?>
                </td>
                <td colspan="5"> 
                    <? db_textarea("ci06_situencont",3,75, "", true, "text", $db_opcao, "", "", "",500); ?>
                </td>
            </tr>   
            <tr>
                <td nowrap title="<?=@$Tci06_objetos?>" align="right">
                    <?=@$Lci06_objetos?>
                </td>
                <td colspan="5"> 
                    <? db_textarea("ci06_objetos",3,75, "", true, "text", $db_opcao, "", "", "",500); ?>
                </td>
            </tr> 
            <tr>
                <td nowrap title="<?=@$Tci06_criterio?>" align="right">
                    <?=@$Lci06_criterio?>
                </td>
                <td colspan="5"> 
                    <? db_textarea("ci06_criterio",3,75, "", true, "text", $db_opcao, "", "", "",500); ?>
                </td>
            </tr>  
            <tr>
                <td nowrap title="<?=@$Tci06_evidencia?>" align="right">
                    <?=@$Lci06_evidencia?>
                </td>
                <td colspan="5"> 
                    <? db_textarea("ci06_evidencia",3,75, "", true, "text", $db_opcao, "", "", "",500); ?>
                </td>
            </tr>   
            <tr>
                <td nowrap title="<?=@$Tci06_causa?>" align="right">
                    <?=@$Lci06_causa?>
                </td>
                <td colspan="5"> 
                    <? db_textarea("ci06_causa",3,75, "", true, "text", $db_opcao, "", "", "",500); ?>
                </td>
            </tr>  
            <tr>
                <td nowrap title="<?=@$Tci06_efeito?>" align="right">
                    <?=@$Lci06_efeito?>
                </td>
                <td colspan="5"> 
                    <? db_textarea("ci06_efeito",3,75, "", true, "text", $db_opcao, "", "", "",500); ?>
                </td>
            </tr>  
            <tr>
                <td nowrap title="<?=@$Tci06_recomendacoes?>" align="right">
                    <?=@$Lci06_recomendacoes?>
                </td>
                <td colspan="5"> 
                    <? db_textarea("ci06_recomendacoes",3,75, "", true, "text", $db_opcao, "", "", "",500); ?>
                </td>
            </tr>   
            <tr>
                <td>&nbsp;</td>
            </tr>
        </table>
        <input name="incluir" type="submit" id="btnSubmit" value="Salvar" <?=($db_botao==false?"disabled":"")?>>
        <input name="pesquisar" id="pesquisar" type="button" value="Pesquisar" onclick="js_pesquisa()">
    </form>
</fieldset>

<script>

    const sRPC = 'cin4_matrizachadosaudit.RPC.php';

    var bStatus = <?= isset($ci06_seq) ? false : true ?>
    
    js_habilitaCampos(bStatus);

    function js_habilitaCampos(bStatus) {

        document.form1.ci06_situencont.disabled     = bStatus;
        document.form1.ci06_objetos.disabled        = bStatus;
        document.form1.ci06_criterio.disabled       = bStatus;
        document.form1.ci06_evidencia.disabled      = bStatus;
        document.form1.ci06_causa.disabled          = bStatus;
        document.form1.ci06_efeito.disabled         = bStatus;
        document.form1.ci06_recomendacoes.disabled  = bStatus;
        document.form1.btnSubmit.disabled           = bStatus;

    }

    function js_buscaQuestao(iNumQuestao) {
    
        try{

            js_divCarregando("Aguarde...", "msgBox");

            var oParametro        = new Object();
            oParametro.exec       = 'buscaQuestoes';
            oParametro.iNumQuest  = iNumQuestao;
            oParametro.iCodProc   = document.form1.ci03_codproc.value;

            new Ajax.Request(sRPC,
                            {
                                method: 'post',
                                parameters: 'json='+Object.toJSON(oParametro),
                                onComplete: js_completaBuscaQuestao
                            });

        } catch (e) {
            alert(e.toString());
        }

    }

    function js_completaBuscaQuestao (oAjax) {

        js_removeObj('msgBox');
        var oRetorno = eval("("+oAjax.responseText+")");

        if (oRetorno.status == 1) {    

            document.getElementById("ci06_codlan").setAttribute('value', oRetorno.questaoMatriz.ci05_codlan);

            document.form1.ci06_seq.value           = oRetorno.questaoMatriz.ci06_seq;
            document.form1.ci06_numquestao.value    = oRetorno.questaoMatriz.ci02_numquestao;
            document.form1.ci02_questao.value       = oRetorno.questaoMatriz.ci02_questao.urlDecode();
            document.form1.ci05_achados.value       = oRetorno.questaoMatriz.ci05_achados.urlDecode();
            document.form1.ci06_situencont.value    = oRetorno.questaoMatriz.ci06_situencont.urlDecode();
            document.form1.ci06_objetos.value       = oRetorno.questaoMatriz.ci06_objetos.urlDecode();
            document.form1.ci06_criterio.value      = oRetorno.questaoMatriz.ci06_criterio.urlDecode();
            document.form1.ci06_evidencia.value     = oRetorno.questaoMatriz.ci06_evidencia.urlDecode();
            document.form1.ci06_causa.value         = oRetorno.questaoMatriz.ci06_causa.urlDecode();
            document.form1.ci06_efeito.value        = oRetorno.questaoMatriz.ci06_efeito.urlDecode();
            document.form1.ci06_recomendacoes.value = oRetorno.questaoMatriz.ci06_recomendacoes.urlDecode();

            if (oRetorno.questaoMatriz.ci06_seq != '') {
                
                document.form1.btnSubmit.name = 'alterar';
                document.form1.btnSubmit.value = 'Alterar';

            } else {
                
                document.form1.btnSubmit.name = 'incluir';
                document.form1.btnSubmit.value = 'Salvar';

            }

            js_habilitaCampos(false);            

        }
    }   

    function js_pesquisa() {
        document.location.href = 'cin4_matrizachadosaudit.php';
    }


</script>