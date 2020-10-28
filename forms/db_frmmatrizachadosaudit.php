<?
//MODULO: Controle Interno
$clmatrizachadosaudit->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label('ci02_questao');
$clrotulo->label('ci02_numquestao');
$clrotulo->label('ci05_achados');

?>

<fieldset>
    <legend>
        <b>Matriz de Achados</b>
    </legend>
    <table>
        <tr>
            <td><? db_lovrot($sSqlQuestoes,15,"()","","js_buscaQuestao|ci02_numquestao", "", "NoMe", array('teste'=>'teste')); ?></td>
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
            <input name="ci06_codproc" value="<?= $ci06_codproc ?>" type="hidden" >
            <input name="ci06_codquestao" id="ci06_codquestao" value="<?= $ci06_codquestao ?>" type="hidden">
            <tr>
                <td align="left" nowrap title="<?=@$Tci06_seq?>">
                    <?=@$Lci06_seq?>
                </td>
                <td> 
                    <? db_input('ci06_seq',11,$Ici06_seq,true,'text',3,"") ?>
                </td>
            </tr>    
            <tr>
                <td nowrap title="<?=@$Tci02_numquestao?>">
                    <?=@$Lci02_numquestao?>
                </td>
                <td> 
                    <? db_input('ci06_numquestao',11,$Ici02_numquestao,true,'text',3,"") ?>
                </td>
            </tr>   
            <tr>
                <td nowrap title="<?=@$Tci02_questao?>">
                    <?=@$Lci02_questao?>
                </td>
                <td> 
                    <? db_textarea("ci02_questao",3,100, "", true, "text", 3, "", "", "",500); ?>
                </td>
            </tr>    
            <tr>
                <td nowrap title="<?=@$Tci05_achados?>">
                    <b>Descrição do Achado:</b>
                </td>
                <td> 
                    <? db_textarea("ci05_achados",3,100, "", true, "text", 3, "", "", "",500); ?>
                </td>
            </tr>    
            <tr>
                <td nowrap title="<?=@$Tci06_situencont?>">
                    <?=@$Lci06_situencont?>
                </td>
                <td> 
                    <? db_textarea("ci06_situencont",3,100, "", true, "text", $db_opcao, "", "", "",500); ?>
                </td>
            </tr>   
            <tr>
                <td nowrap title="<?=@$Tci06_objetos?>">
                    <?=@$Lci06_objetos?>
                </td>
                <td> 
                    <? db_textarea("ci06_objetos",3,100, "", true, "text", $db_opcao, "", "", "",500); ?>
                </td>
            </tr> 
            <tr>
                <td nowrap title="<?=@$Tci06_criterio?>">
                    <?=@$Lci06_criterio?>
                </td>
                <td> 
                    <? db_textarea("ci06_criterio",3,100, "", true, "text", $db_opcao, "", "", "",500); ?>
                </td>
            </tr>  
            <tr>
                <td nowrap title="<?=@$Tci06_evidencia?>">
                    <?=@$Lci06_evidencia?>
                </td>
                <td> 
                    <? db_textarea("ci06_evidencia",3,100, "", true, "text", $db_opcao, "", "", "",500); ?>
                </td>
            </tr>   
            <tr>
                <td nowrap title="<?=@$Tci06_causa?>">
                    <?=@$Lci06_causa?>
                </td>
                <td> 
                    <? db_textarea("ci06_causa",3,100, "", true, "text", $db_opcao, "", "", "",500); ?>
                </td>
            </tr>  
            <tr>
                <td nowrap title="<?=@$Tci06_efeito?>">
                    <?=@$Lci06_efeito?>
                </td>
                <td> 
                    <? db_textarea("ci06_efeito",3,100, "", true, "text", $db_opcao, "", "", "",500); ?>
                </td>
            </tr>  
            <tr>
                <td nowrap title="<?=@$Tci06_recomendacoes?>">
                    <?=@$Lci06_recomendacoes?>
                </td>
                <td> 
                    <? db_textarea("ci06_recomendacoes",3,100, "", true, "text", $db_opcao, "", "", "",500); ?>
                </td>
            </tr>   
            <tr>
                <td>&nbsp;</td>
            </tr>
        </table>
        <input name="incluir" type="submit" id="btnSubmit" value="Salvar" <?=($db_botao==false?"disabled":"")?>>
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
            oParametro.iCodProc   = document.form1.ci06_codproc.value;

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
            
            document.getElementById("ci06_codquestao").setAttribute('value', oRetorno.questaoMatriz.ci02_codquestao);

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


</script>