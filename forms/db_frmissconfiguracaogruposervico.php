<?php

use App\Models\DbUsuarios;
use App\Models\IssConfiguracaoGrupoServicoUsuario;

$oDaoConfiguracaoGrupo->rotulo->label();
$dbUsuariosContass = DbUsuarios::query()
    ->where('id_usuario', db_getsession('DB_id_usuario'))
    ->where('login', 'like', '%.contass')
    ->first();
$IssConfiguracaoGrupoServicoUsuario    = IssConfiguracaoGrupoServicoUsuario::query()->where('id_usuario', db_getsession('DB_id_usuario'))->first();

$oRotulo = new rotulocampo();
$oRotulo->label("q126_sequencial");

$aLocalPagamento = array(1 => 'Local de prestação', 2 => 'Sede Prestador', 3 => 'Sede Tomador');
$aTipoTributacao = array(1 => 'Fixo', 2 => 'Variável', 3 => 'Não Incide');

$sDesabilitaBotao = $db_opcao ? null : 'disabled="true"';
?>

<form name="form1" method="post" action="">

    <fieldset style="width:600px;">

        <legend>Manutenção de Grupos de Serviço</legend>

        <table border="0">

            <tr>
                <td nowrap title="<?php echo $Tq136_issgruposervico ?>">
                    <strong>Grupo de serviço:</strong>
                </td>
                <td>
                    <?php db_input('iCodigoGrupoServico', 10, $Iq136_issgruposervico, true, 'text', $db_opcao); ?>
                    <?php db_input('sDescricaoGrupoServico', 50, null, true, 'text', ($dbUsuariosContass || $IssConfiguracaoGrupoServicoUsuario) ? $db_opcao : 22); ?>
                    <?php db_input('iSequencialEstrutural', 10, null, true, 'hidden', 3); ?>
                    <?php db_input('q136_sequencial', 10, null, true, 'hidden', 3); ?>
                    <?php db_input('q136_issgruposervico', 10, null, true, 'hidden', 3); ?>
                </td>
            </tr>

            <tr>
                <td nowrap title="<?php echo $Tq136_exercicio; ?>">
                    <?php echo $Lq136_exercicio; ?>
                </td>
                <td>
                    <?php $q136_exercicio = db_getsession('DB_anousu');
                    db_input('q136_exercicio', 10, $Iq136_exercicio, true, 'text', 22, ""); ?>
                    <input type="hidden" id="exercicio_atual" value="<?php echo db_getsession('DB_anousu'); ?>" />
                </td>
            </tr>

            <tr>
                <td nowrap title="<?php echo $Tq136_tipotributacao; ?>">
                    <?php echo $Lq136_tipotributacao; ?>
                </td>
                <td>
                    <?php db_select('q136_tipotributacao', $aTipoTributacao, true, $db_opcao, "onchange='js_tipoTributacao(this);'"); ?>
                </td>
            </tr>

            <tr>
                <td id="valor" nowrap title="<?php echo $Tq136_valor; ?>">
                    <strong>Valor do índice:</strong>
                </td>
                <td>
                    <?php db_input('q136_valor', 10, $Iq136_valor, true, 'text', $db_opcao, "") ?>
                    <span id="porcentagem" style="display:none;">%</span>
                </td>
            </tr>

            <tr>
                <td nowrap title="<?php echo $Tq136_valor_reduzido; ?>">
                    <strong>Alíquota reduzida:</strong>
                </td>
                <td>
                    <?php db_input('q136_valor_reduzido', 10, $Iq136_valor_reduzido, true, 'text', $db_opcao, "") ?>
                    <span id="porcentagem_reduzido" style="display:none;">%</span>
                </td>
            </tr>

            <tr>
                <td nowrap title="<?php echo $Tq136_localpagamento; ?>">
                    <?php echo $Lq136_localpagamento; ?>
                </td>
                <td>
                    <?php db_select('q136_localpagamento', $aLocalPagamento, true, $db_opcao, ""); ?>
                </td>
            </tr>
        </table>

    </fieldset>

    <input name="salvar" type="submit" id="salvar" value="Salvar" <?php echo $sDesabilitaBotao; ?> />

    <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">

</form>

<script type="text/javascript">
    js_tipoTributacao($('q136_tipotributacao'));
    $('salvar').disabled = true;

    if (!empty($F('iCodigoGrupoServico'))) {
        $('salvar').disabled = false;
    }

    /**
     * Funcao chamada ao alterar tipo de tributacao
     */
    function js_tipoTributacao(oElemento) {

        var sValor = '';

        /**
         * Fixo
         */
        if (oElemento.value == '1') {
            sValor += 'Valor do índice';
            $('porcentagem').style.display = 'none';
            $('q136_valor').readOnly = false;

            $('porcentagem_reduzido').style.display = 'none';
            $('q136_valor_reduzido').readOnly = false;
        }

        /**
         * Variavel
         */
        else if (oElemento.value == '2') {

            sValor += 'Alíquota:';
            $('porcentagem').style.display = '';
            $('q136_valor').readOnly = false;

            $('porcentagem_reduzido').style.display = '';
            $('q136_valor_reduzido').readOnly = false;
        }

        /**
         * Não incide
         */
        else if (oElemento.value == '3') {

            sValor += 'Não Incide';
            $('porcentagem').style.display = 'none';
            $('q136_valor').value = '0';
            $('q136_valor').readOnly = true;

            $('porcentagem_reduzido').style.display = 'none';
            $('q136_valor_reduzido').value = '0';
            $('q136_valor_reduzido').readOnly = true;
        }

        $('valor').innerHTML = '<strong>' + sValor + '</strong>';
    }

    function js_pesquisa() {
        js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_issgruposervico', 'func_issgruposervico.php?funcao_js=parent.js_preenchePesquisa|q126_sequencial|db121_descricao|db121_estrutural', 'Pesquisa', true);
    }

    function js_preenchePesquisa(iCodigoGrupoServico, sDescricao, sEstrutural) {
        $('sDescricaoGrupoServico').value = sDescricao;
        js_divCarregando('Buscando dados do grupo de serviço', 'msgBox');
        db_iframe_issgruposervico.hide(true);
        location.href = 'iss1_issconfiguracaogruposervico002.php?iCodigoGrupoServico=' + iCodigoGrupoServico;
        js_removeObj('msgBox');
    }
</script>
