<?
//MODULO: sicom
$clapostilamento->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("ac16_sequencial");
$clrotulo->label("ac16_resumoobjeto");
?>
<form name="form1" method="post" action="">

        <table border="0">
            <tr>
                <td nowrap title="<?= @$Tsi03_sequencial ?>">
                    <?= @$Lsi03_sequencial ?>
                </td>
                <td nowrap>
                    <?
                    db_input('si03_sequencial', 10, $Isi03_sequencial, true, 'text', 3, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tac16_sequencial?>">
                    <?php db_ancora($Lac16_sequencial, "js_pesquisaac16_sequencial(true);",$db_opcao); ?>
                </td>
                <td nowrap>
                    <?
                    db_input('ac16_sequencial',10,$Iac16_sequencial,true,'text',
                        $db_opcao," onchange='js_pesquisaac16_sequencial(false);'");
                    db_input('ac16_resumoobjeto',40,$Iac16_resumoobjeto,true,'text',3);
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap nowrap title="<?= @$Tsi03_dataassinacontrato ?>">
                    <?= @$Lsi03_dataassinacontrato ?>
                </td>
                <td nowrap>
                    <?
                    db_inputdata('si03_dataassinacontrato', @$si03_dataassinacontrato_dia, @$si03_dataassinacontrato_mes, @$si03_dataassinacontrato_ano, true, 'text', 3, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap nowrap title="<?= @$Tsi03_tipoapostila ?>">
                    <?= @$Lsi03_tipoapostila ?>
                </td>
                <td nowrap>
                    <?
                    $x = array("01" => "Reajuste de preço previsto no contrato", "02" => "Atualizações, compensações ou penalizações", "03" => "Empenho de dotações orçamentárias suplementares");
                    db_select('si03_tipoapostila', $x, true, $db_opcao, "");
                    //db_input('si03_tipoapostila',1,$Isi03_tipoapostila,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap nowrap title="<?= @$Tsi03_dataapostila ?>">
                    <?= @$Lsi03_dataapostila ?>
                </td>
                <td nowrap>
                    <?
                    db_inputdata('si03_dataapostila', @$si03_dataapostila_dia, @$si03_dataapostila_mes, @$si03_dataapostila_ano, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap nowrap title="<?= @$Tsi03_descrapostila ?>">
                    <?= @$Lsi03_descrapostila ?>
                </td>
                <td nowrap>
                    <?
                    db_textarea('si03_descrapostila', 8, 30, $Isi03_descrapostila, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap nowrap title="<?= @$Tsi03_tipoalteracaoapostila ?>">
                    <?= @$Lsi03_tipoalteracaoapostila ?>
                </td>
                <td nowrap>
                    <?
                    $x = array("1" => "Acréscimo de valor", "2" => "Decréscimo de valor", "3" => "Não houve alteração de valor");
                    db_select('si03_tipoalteracaoapostila', $x, true, $db_opcao, "");
                    //db_input('si03_tipoalteracaoapostila',1,$Isi03_tipoalteracaoapostila,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap nowrap title="<?= @$Tsi03_numapostilamento ?>">
                    <?= @$Lsi03_numapostilamento ?>
                </td>
                <td nowrap>
                    <?
                    db_input('si03_numapostilamento', 10, $Isi03_numapostilamento, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap nowrap title="<?= @$Tsi03_valorapostila ?>">
                    <?= @$Lsi03_valorapostila ?>
                </td>
                <td nowrap>
                    <?
                    db_input('si03_valorapostila', 14, $Isi03_valorapostila, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>

            <?
            $si03_instit = db_getsession("DB_instit");
            db_input('si03_instit', 10, $Isi03_instit, true, 'hidden', $db_opcao, "")
            ?>
            <?
            $controle = $db_opcao;
            db_input('controle', 10, $Icontrole, true, 'hidden', $db_opcao, "")
            //db_input('controle',10,$Icontrole,true,'hidden',$db_opcao,"")
            ?>
        </table>
    <input name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>"
           type="submit" id="db_opcao"
           value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?> >
    <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
</form>
<script>

    var opcao = document.form1.controle.value;

    function js_pesquisasi03_licitacao(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_liclicita', 'func_liclicita.php?funcao_js=parent.js_mostraliclicita1|l20_codigo|l20_edital|l20_anousu', 'Pesquisa', true);
        } else {
            if (document.form1.si03_licitacao.value != '') {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_liclicita', 'func_liclicita.php?pesquisa_chave=' + document.form1.si03_licitacao.value + '&funcao_js=parent.js_mostraliclicita', 'Pesquisa', false);
            } else {
                document.form1.l20_codigo.value = '';
            }
        }
    }
    function js_mostraliclicita(chave, erro) {
        document.form1.l20_codigo.value = chave;
        if (erro == true) {
            document.form1.si03_licitacao.focus();
            document.form1.si03_licitacao.value = '';
        }
    }
    function js_mostraliclicita1(chave1, chave2, chave3) {
        document.form1.si03_licitacao.value = chave1;
        document.form1.l20_edital.value = chave2 + '/' + chave3;
        db_iframe_liclicita.hide();
    }
    function js_pesquisa() {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_apostilamento', 'func_apostilamentonovo.php?funcao_js=parent.js_preenchepesquisa|si03_sequencial', 'Pesquisa', true);
    }
    function js_preenchepesquisa(chave) {
        db_iframe_apostilamento.hide();
        <?
        if($db_opcao!=1){
          echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
        }
        ?>
    }

    function js_retornoPesquisa(oAjax) {
        var oRetorno = eval("(" + oAjax.responseText + ")");
        document.form1.si03_dataassinacontrato.value = oRetorno.si172_dataassinatura;
        var aData = document.form1.si03_dataassinacontrato.value.split("/");
        js_setDiaMesAno(document.form1.si03_dataassinacontrato, aData[0], aData[1], aData[2]);
    }

    function js_pesquisaac16_sequencial(lMostrar) {

        if (lMostrar == true) {

            var sUrl = 'func_acordonovo.php?funcao_js=parent.js_mostraacordo1|ac16_sequencial|ac16_resumoobjeto|ac16_dataassinatura&iTipoFiltro=4';
            js_OpenJanelaIframe('top.corpo',
                'db_iframe_acordo',
                sUrl,
                'Pesquisar Acordo',
                true);
        } else {

            if ($('ac16_sequencial').value != '') {

                var sUrl = 'func_acordonovo.php?descricao=true&pesquisa_chave='+$('ac16_sequencial').value+
                    '&funcao_js=parent.js_mostraacordo';

                js_OpenJanelaIframe('top.corpo',
                    'db_iframe_acordo',
                    sUrl,
                    'Pesquisar Acordo',
                    false);
            } else {
                $('ac16_sequencial').value = '';
            }
        }
    }

    /**
     * Retorno da pesquisa acordos
     */
    function js_mostraacordo(chave1,chave2,chave3,erro) {

        if (erro == true) {

            $('ac16_sequencial').value   = '';
            $('ac16_resumoobjeto').value = chave1;
            $('si03_dataassinacontrato').value = '';
            $('ac16_sequencial').focus();
        } else {

            $('ac16_sequencial').value   = chave1;
            $('ac16_resumoobjeto').value = chave2;
            $('si03_dataassinacontrato').value = chave3.substr(8, 2)+'/'+chave3.substr(5, 2)+'/'+chave3.substr(0, 4);
        }
    }

    /**
     * Retorno da pesquisa acordos
     */
    function js_mostraacordo1(chave1,chave2,chave3) {
        $('ac16_sequencial').value    = chave1;
        $('ac16_resumoobjeto').value  = chave2;
        $('si03_dataassinacontrato').value  = chave3.substr(8, 2)+'/'+chave3.substr(5, 2)+'/'+chave3.substr(0, 4);
        db_iframe_acordo.hide();
    }
</script>
