<?
//MODULO: contabilidade
include("dbforms/db_classesgenericas.php");
$clconsexecucaoorc->rotulo->label();

$aMesesSelect   = array("1"=>"JANEIRO","2"=>"FEVEREIRO","3"=>"MARÇO","4"=>"ABRIL","5"=>"MAIO","6"=>"JUNHO","7"=>"JULHO","8"=>"AGOSTO","9"=>"SETEMBRO","10"=>"OUTUBRO","11"=>"NOVEMBRO","12"=>"DEZEMBRO");
$aMesesValores  = array(1=>'1',2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'9',10=>'10',11=>'11',12=>'12');

foreach($aMesCompRef as $iIndex => $oMes) {
    $aMesesValores[$oMes->c202_mescompetencia] = $oMes->c202_mesreferenciasicom;
}

?>
<form name="form1" method="post" action="">
<center>
<fieldset style="margin-left: 80px; margin-top: 10px;">
<legend>Mês Referência SICOM</legend>
<table border="0">
    <tr>
        <td nowrap title="<?=@$Tc202_consconsorcios?>">
            <?=@$Lc202_consconsorcios?>
        </td>
        <td> 
            <? db_input('c202_consconsorcios',10,$Ic202_consconsorcios,true,'text',3,"") ?>
        </td>
    </tr>
    <? foreach($aMesesValores as $iIndex => $iMesRef):
        
        $mesCompetencia = "c202_mesreferenciasicom".$iIndex;
        $$mesCompetencia = $iMesRef;  

    ?> 
    
    <tr>
        <td nowrap title="<?= $aMesesSelect[$iIndex] ?>">
            <b><?= $aMesesSelect[$iIndex] ?>: </b>
        </td>
        <td>
            <? db_select($mesCompetencia,$aMesesSelect,true,$db_opcao); ?>
        </td>
    </tr>
    <? endforeach; ?>
  
    <tr>
        <td colspan="2" align="center">
            <input name="<?=($db_opcao==2?"alterar":"")?>" type="button" id="db_opcao" value="Salvar" <?=($db_opcao==3?"disabled":"")?> onclick="js_salvar()" >
        </td>
    </tr>
  </table>

 </fieldset>
  </center>
</form>
<script>
function js_salvar() {

    try {

        oParam       = new Object();
        oParam.exec  = 'salvarMesReferencia';
        oParam.aMeses = [];
        oParam.c202_consconsorcios = document.form1.c202_consconsorcios.value
        
        for (i = 1; i <= 12; i++) {
            
            var elemento = 'c202_mesreferenciasicom'+i;
            oParam.aMeses[i] = document.form1[elemento].value;
            
        }
        
        js_divCarregando('Aguarde', 'div_aguarde');

        var oAjax = new Ajax.Request('con4_consconsorcios.RPC.php', {
            method:'post',
            parameters:'json='+Object.toJSON(oParam),
            onComplete: js_retornoSalvar
        });

    } catch(e) {

        alert(e.toString());

    }

return false;
}

function js_retornoSalvar(oAjax) {
    
    js_removeObj('div_aguarde');

    var oRetorno = eval("("+oAjax.responseText+")");

    if (oRetorno.status == 1) {
        alert(oRetorno.sMensagem.urlDecode());
    } else {
        alert(oRetorno.sMensagem.urlDecode());
    }
}
</script>
