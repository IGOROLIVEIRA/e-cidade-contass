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
        <table>
          <tr>
            <th style="width: 500px;" align="center">Data da Avaliação: <? db_inputdata("dtavaliacao",null,null,null,true,'text',1,"");?> <input type="button" value="aplicar a todos" name="aplicar" onclick="js_aplicar()"></th>
          </tr>
        </table>
        <br>
        <table class="DBGrid">
        <tr>
            <th class="table_header" style="width: 120px;">Exercicio</th>
            <th class="table_header" style="width: 120px;">Receita</th>
            <th class="table_header" style="width: 120px;">Despesa</th>
            <th class="table_header" style="width: 150px;">Data</th>
        </tr>
        </table>
    </table>

    <? for ($ano = $anousu10 + 1; $ano <= $projecaoaturialano; $ano++):?>
        <table class="DBGrid">
            <tr>
                <td class="linhagrid" style="width: 120px;">
                    <?= $ano ?>
                    <input type="hidden" style="width: 120px;" name="exercicio[<?= $ano ?>]" value="" id="">
                </td>

                <td class="linhagrid" style="width: 120px;">
                    <input type="text" style="width: 120px;" name="receita[<?=$ano?>]" value="" maxlength="14" oninput="js_validaValores(this);">
                </td>

                <td class="linhagrid" style="width: 120px;">
                    <input type="text" style="width: 120px;" name="despesa[<?=$ano?>]" value="" maxlength="14" oninput="js_validaValores(this);">
                </td>

                <td class="linhagrid" style="width: 150px;">
                      <?
                      db_inputdata("data_$ano",null,null,null,true,'text',1,"");
                      ?>
                </td>
            </tr>

        </table>
    <?endfor;?>
    <center>
        <input type="hidden" id="anousu10" value="<?= $anousu10 ?>">

        <input type="submit" value="Salvar" name="salvar">
    </center>
</form>
<script>

    function js_validaValores(obj) {

        if( js_countOccurs(obj.value, '.') > 1 ) {
            obj.value = js_strToFloat(obj.value);
        }

        if( js_countOccurs(obj.value, ',') > 0 ) {
            obj.value = obj.value.replace(',', '.');
        }

    }

    function js_aplicar(){
      let data = document.form1.dtavaliacao.value;
      if(data !== "") {
        let anousu = Number(document.form1.anousu10.value)+1;
        let anousufim = Number(anousu) + 74;
        for (cont = anousu; cont < anousufim; cont++) {
          document.form1['data_' + cont ].value = data;
        }
      }else{
        alert('campo data da avaliação vazio');
      }
    }

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
            document.form1['receita[' + item.si169_exercicio + ']'].value  = item.si169_vlreceitaprevidenciaria == 0 ? '' : item.si169_vlreceitaprevidenciaria;
            document.form1['despesa[' + item.si169_exercicio + ']'].value  = item.si169_vldespesaprevidenciaria == 0 ? '' : item.si169_vldespesaprevidenciaria;
            item.si169_data = item.si169_data.substr(0, 10).split('-').reverse().join('/');
            document.form1['data_' + item.si169_exercicio  ].value  = item.si169_data;
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
