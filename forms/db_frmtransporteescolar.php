<?
//MODULO: veiculos
$cltransporteescolar->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("ve01_codigo");
?>
<form name="form1" method="post" action="">
    <center>
        <table border="0">
            <tr>
                <td nowrap title="<?= @$Tv200_sequencial ?>">
                    <?= @$Lv200_sequencial ?>
                </td>
                <td>
                    <?
                    db_input('v200_sequencial', 10, $Iv200_sequencial, true, 'text', 3, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="Campo: v200_anousu">
                    <strong>Ano: </strong>
                </td>
                <td>
                    <?
                    /*
                     * Ocorrência 1012
                     * Mostrar no input o ano da sessão.
                     */
                    if ($v200_anousu == ''){
                        $v200_anousu = db_getsession('DB_anousu');
                    }
                    ?>
                    <input type="text" name="v200_anousu" id="v200_anousu" autocomplete="off" style="background-color:#DEB887;" readonly="" maxlength="4" size="10" title="Campo:v200_anousu " tabindex="0" value="<?php echo $v200_anousu; ?>"/>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Tv200_veiculo ?>">
                    <?
                    db_ancora(@$Lv200_veiculo, "js_pesquisav200_veiculo(true);", $db_opcao);
                    ?>
                </td>
                <td>
                    <?
                    db_input('v200_veiculo', 10, $Iv200_veiculo, true, 'text', $db_opcao, " onchange='js_pesquisav200_veiculo(false);'")
                    ?>
                    <?
                    db_input('ve01_placa', 10, $Ive01_codigo, true, 'text', 3, '')
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Tv200_escola ?>">
                    <?= @$Lv200_escola ?>
                </td>
                <td>
                    <?
                    db_textarea('v200_escola', 2, 50, $Iv200_escola, true, 'text', $db_opcao);
                    //db_input('v200_escola', 50, $Iv200_escola, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Tv200_localidade ?>">
                    <?= @$Lv200_localidade ?>
                </td>
                <td>
                    <?
                    db_textarea('v200_localidade', 2, 50, $Iv200_localidade, true, 'text', $db_opcao);
                    //db_input('v200_localidade', 50, $Iv200_localidade, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Tv200_numpassageiros ?>">
                    <?= @$Lv200_numpassageiros ?>
                </td>
                <td>
                    <?
                    db_input('v200_numpassageiros', 10, $Iv200_numpassageiros, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Tv200_turno ?>">
                    <?= @$Lv200_turno ?>
                </td>
                <td>
                    <?
                    $Iv200_turno = array("01" => "Manh&atilde;", "02" => "Tarde", "03" => "Noite", "04" => "Manh&atilde; e Tarde", "05" => "Manh&atilde; e Noite", "06" => "Tarde e Noite", "07" => "Manh&atilde;, Tarde e Noite");
                    db_select("v200_turno", $Iv200_turno, true, 1, "style='width:153'");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Tv200_periodo ?>">
                    <?= @$Lv200_periodo ?>
                </td>
                <td>
                    <?
                    $Iv200_periodo = array("01" => "Janeiro", "02" => "Fevereiro", "03" => "Mar&ccedil;o", "04" => "Abril", "05" => "Maio", "06" => "Junho", "07" => "Julho", "08" => "Agosto", "09" => "Setembro", "10" => "Outubro", "11" => "Novembro", "12" => "Dezembro");
                    db_select("v200_periodo", $Iv200_periodo, true, 1, "style='width:153'");
                    //db_input('v200_periodo',10,$Iv200_periodo,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Tv200_distancia ?>">
                    <?= @$Lv200_distancia ?>
                </td>
                <td>
                    <?
                    db_input('v200_distancia', 10, $Iv200_distancia, true, 'text', $db_opcao, "")
                    ?>
                    <!-- <input id="calcular" type="button" onclick="js_calcular();" value="Calcular" name="calcular" <? if ($db_opcao == 3 || $db_opcao == 33) { ?> disabled="disabled" <? } ?> tabindex="9">-->
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Tv200_diasrodados ?>">
                    <b>Qtd. de <?= @$Lv200_diasrodados ?></b>
                </td>
                <td>
                    <?
                    db_input('v200_diasrodados', 10, $Iv200_diasrodados, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
        </table>
    </center>
    <input name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>"
           type="submit" id="db_opcao"
           value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?> >
    <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
</form>
<script>
    function js_pesquisav200_veiculo(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_veiculos', 'func_veiculosalt.php?funcao_js=parent.js_mostraveiculos1|ve01_codigo|ve01_placa', 'Pesquisa', true);
        } else {
            if (document.form1.v200_veiculo.value != '') {
                js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_veiculos', 'func_veiculosalt.php?pesquisa_chave=' + document.form1.v200_veiculo.value + '&funcao_js=parent.js_mostraveiculos', 'Pesquisa', false);
            } else {
                document.form1.ve01_codigo.value = '';
            }
        }
    }
    function js_mostraveiculos(chave, erro) {
        document.form1.ve01_codigo.value = chave;
        if (erro == true) {
            document.form1.v200_veiculo.focus();
            document.form1.v200_veiculo.value = '';
        }
    }
    function js_mostraveiculos1(chave1, chave2) {
        document.form1.v200_veiculo.value = chave1;
        document.form1.ve01_placa.value = chave2;
        db_iframe_veiculos.hide();
    }
    function js_pesquisa() {
        js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_transporteescolar', 'func_transporteescolar.php?funcao_js=parent.js_preenchepesquisa|v200_sequencial', 'Pesquisa', true);
    }
    function js_preenchepesquisa(chave) {
        db_iframe_transporteescolar.hide();
        <?
        if($db_opcao!=1){
          echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
        }
        ?>
    }
    function js_calcular() {

        var oParam = new Object();
        oParam.sMetodo = 'getDistancia';

        oParam.iCodigo = document.getElementById("v200_veiculo").value;
        oParam.dtini = document.getElementById("dtini").value;
        oParam.dtfim = document.getElementById("dtfim").value;

        if (oParam.dtini != "" && oParam.dtfim != "") {

            //js_divCarregando('Obtendo distancia percorrida pelo veiculo', 'msgBox');

            var sRPC = 'vei1_transporteescolar.RPC.php';
            var oAjax = new Ajax.Request(sRPC,
                {
                    method: 'post',
                    parameters: 'json=' + JSON.stringify(oParam),

                    onComplete: function (oAjax) {

                        js_removeObj('msgBox');
                        var oRetorno = JSON.parse(oAjax.responseText);
                        console.log(oRetorno);

                        if (oRetorno.lErro) {
                            alert(oRetorno.sMensagem.urlDecode());
                            return;
                        }

                        //oCampoDocumentoCara.setValue(oRetorno.sDocumentoCara);
                        //oCampoCgmCara.setValue(oRetorno.sNomeCara);

                    }
                });

        } else {
            alert("Campo periodo e obrigatorio");
        }
    }
</script>
