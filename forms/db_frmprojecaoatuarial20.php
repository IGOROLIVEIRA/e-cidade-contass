<?
//MODULO: sicom
require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
require_once "libs/db_sessoes.php";
require_once "libs/db_usuariosonline.php";
require_once "dbforms/db_funcoes.php";
require_once("libs/db_app.utils.php");
require_once("dbforms/db_funcoes.php");
$anousu = db_getsession("DB_anousu");
$anousuanterior = $anousu - 1;
$sql = "select * from projecaoatuarial10 where si168_sequencial = {$codigo} and si168_tipoplano = {$tipoplano}";
$result = db_query($sql);
$anousu10 = $oDados10 = db_utils::fieldsMemory($result, 0)->si168_exercicio;
$anousuprojecao10 = $oDados10 = db_utils::fieldsMemory($result, 0)->si168_exercicio;
$projecaoaturialano = $anousu10 + 74;
?>

<form name="form1" method="post">
    <table>
        <tr>
            <th class="table_header" style="width: 70px;">Exercicio</th>
            <th class="table_header" style="width: 70px;">Receita</th>
            <th class="table_header" style="width: 70px;">Despesa</th>
        </tr>
    </table>

    <? for ($ano = $anousu10 + 1; $ano <= $projecaoaturialano; $ano++):?>
        <table class="DBGrid">
            <tr>
                <td class="linhagrid" style="width: 70px;">
                    <?= $ano ?>
                    <input type="hidden" style="width: 70px;" name="exercicio[<?= $ano ?>]" value="" id="">
                </td>

                <td class="linhagrid" style="width: 70px;">
                    <input type="text" style="width: 70px;" name="receita[<?=$ano?>]" value="0">
                </td>

                <td class="linhagrid" style="width: 70px;">
                    <input type="text" style="width: 70px;" name="despesa[<?=$ano?>]" value="0">
                </td>
            </tr>

        </table>
    <?endfor;?>
    <center>
        <input type="submit" value="Salvar" name="salvar">
    </center>
</form>
<script>
    getdados();
    function getdados() {
        buscaritens({
            exec: 'getItens',
            codigo: <?= $codigo ?>,
            tipoplano: <?= $tipoplano ?>,
            exercicio: <?= $anousuprojecao10 ?>
        }, js_carregaritens);
    }

    function js_carregaritens(oRetorno) {
        let projecao = JSON.parse(oRetorno.responseText);
        projecao.itens.forEach(function (item,key) {
            document.form1['receita[' + item.si169_exercicio + ']'].value  = item.si169_vlreceitaprevidenciaria;
            document.form1['despesa[' + item.si169_exercicio + ']'].value  = item.si169_vldespesaprevidenciaria;
        })
    }

    function buscaritens(params,onComplete) {
        js_divCarregando('Carregando Informações', 'div_aguarde');
        var request = new Ajax.Request('projecaoatuarial.RPC.php', {
            method:'post',
            parameters:'json=' + JSON.stringify(params),
            onComplete: function(res) {
                js_removeObj('div_aguarde');
                onComplete(res);
            }
        });
    }

</script>
