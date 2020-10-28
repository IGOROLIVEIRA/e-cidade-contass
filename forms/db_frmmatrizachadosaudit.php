<?
//MODULO: Controle Interno
$clmatrizachadosaudit->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label('ci02_questao');
$clrotulo->label('ci02_numquestao');
$clrotulo->label('ci05_achados');

?>

<form name="form1">   
    <fieldset>
        <legend>
            <b>Matriz de Achados</b>
        </legend>
        <table>
            <tr>
                <td><? db_lovrot($sSqlQuestoes,15,"()","","teste|ci02_numquestao|ci02_questao", "", "NoMe", array()); ?></td>
            </tr> 
        </table>
        <table border="0">
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <input name="ci03_codproc" value="<?= $ci03_codproc ?>" type="hidden" >
            <tr>
                <td align="left" nowrap title="<?=@$Tci06_seq?>">
                    <input name="ci06_seq" type="hidden" value="<?=@$ci06_seq?>">
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
                    <? db_input('ci02_numquestao',11,$Ici02_numquestao,true,'text',3,"") ?>
                </td>
            </tr>   
            <tr>
                <td nowrap title="<?=@$Tci02_questao?>">
                    <?=@$Lci02_questao?>
                </td>
                <td> 
                    <? db_textarea("ci02_questao",2,80, "", true, "text", 3, "", "", "",500); ?>
                </td>
            </tr>    
            <tr>
                <td nowrap title="<?=@$Tci05_achados?>">
                    <b>Descrição do Achado:</b>
                </td>
                <td> 
                    <? db_textarea("ci05_achados",2,80, "", true, "text", 3, "", "", "",500); ?>
                </td>
            </tr>    
            <tr>
                <td nowrap title="<?=@$Tci06_situencont?>">
                    <?=@$Lci06_situencont?>
                </td>
                <td> 
                    <? db_textarea("ci06_situencont",2,80, "", true, "text", $db_opcao, "", "", "",500); ?>
                </td>
            </tr>   
            <tr>
                <td nowrap title="<?=@$Tci06_objetos?>">
                    <?=@$Lci06_objetos?>
                </td>
                <td> 
                    <? db_textarea("ci06_objetos",2,80, "", true, "text", $db_opcao, "", "", "",500); ?>
                </td>
            </tr> 
            <tr>
                <td nowrap title="<?=@$Tci06_criterio?>">
                    <?=@$Lci06_criterio?>
                </td>
                <td> 
                    <? db_textarea("ci06_criterio",2,80, "", true, "text", $db_opcao, "", "", "",500); ?>
                </td>
            </tr>  
            <tr>
                <td nowrap title="<?=@$Tci06_evidencia?>">
                    <?=@$Lci06_evidencia?>
                </td>
                <td> 
                    <? db_textarea("ci06_evidencia",2,80, "", true, "text", $db_opcao, "", "", "",500); ?>
                </td>
            </tr>   
            <tr>
                <td nowrap title="<?=@$Tci06_causa?>">
                    <?=@$Lci06_causa?>
                </td>
                <td> 
                    <? db_textarea("ci06_causa",2,80, "", true, "text", $db_opcao, "", "", "",500); ?>
                </td>
            </tr>  
            <tr>
                <td nowrap title="<?=@$Tci06_efeito?>">
                    <?=@$Lci06_efeito?>
                </td>
                <td> 
                    <? db_textarea("ci06_efeito",2,80, "", true, "text", $db_opcao, "", "", "",500); ?>
                </td>
            </tr>  
            <tr>
                <td nowrap title="<?=@$Tci06_recomendacoes?>">
                    <?=@$Lci06_recomendacoes?>
                </td>
                <td> 
                    <? db_textarea("ci06_recomendacoes",2,80, "", true, "text", $db_opcao, "", "", "",500); ?>
                </td>
            </tr>   
        </table>
    </fieldset>
</form>
<script>

function teste(iCodProc, ci02_questao) {
    alert(iCodProc+' '+ci02_questao);
}


</script>