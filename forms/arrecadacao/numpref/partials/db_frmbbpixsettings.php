<style>
    #apiSettings1 {
        width: 100%;
    }
</style>

<?php

use App\Models\ConfiguracaoPixBancoDoBrasil;
use App\Models\InstituicaoFinanceiraApiPix;

$configuracaoPixBb = new ConfiguracaoPixBancoDoBrasil();
$configuracaoPixBb->legacyLabel->label();
if (!isset($k03_instituicao_financeira)) {
    $k03_instituicao_financeira = null;
}
$style = ((int)$k03_instituicao_financeira) === InstituicaoFinanceiraApiPix::BANCO_DO_BRASIL
    ?: "style='display: none'";
?>
<table id="apiSettings1" <?= $style ?>>
    <tr>
        <th style="width: 50%;"></th>
        <th style="width: 50%"></th>
    </tr>
    <tr>
        <td title="<?=$Tk177_ambiente?>">
            <?=$Lk177_ambiente?>
        </td>
        <td>
            <?php
            db_select(
                'k177_ambiente',
                ConfiguracaoPixBancoDoBrasil::ENVIRONMENTS,
                true,
                $db_opcao
            );
            ?>
        </td>
    </tr>
    <tr>
        <td title="<?= $Tk177_url_api ?>">
            <?= $Lk177_url_api ?>
        </td>
        <td>
            <?php
            db_input(
                'k177_url_api',
                '',
                $Ik177_url_api,
                true,
                'text',
                $db_opcao,
                " style='width: 100%'",
                '',
                '',
                '',
                ''
            );
            ?>
        </td>
    </tr>
    <tr>
        <td title="<?= $Tk177_url_oauth ?>">
            <?= $Lk177_url_oauth ?>
        </td>
        <td>
            <?php
            db_input(
                'k177_url_oauth',
                '',
                $Ik177_url_oauth,
                true,
                'text',
                $db_opcao,
                " style='width: 100%'",
                '',
                '',
                '',
                ''
            );
            ?>
        </td>
    </tr>
    <tr>
        <td title="<?= $Tk177_develop_application_key ?>">
            <?= $Lk177_develop_application_key ?>
        </td>
        <td>
            <?php
            db_input(
                'k177_develop_application_key',
                '',
                $Ik177_develop_application_key,
                true,
                'text',
                $db_opcao,
                " style='width: 100%'",
                '',
                '',
                '',
                ''
            );
            ?>
        </td>
    </tr>
    <tr>
        <td title="<?= $Tk177_client_id ?>">
            <?= $Lk177_client_id ?>
        </td>
        <td>
            <?php
            db_input(
                'k177_client_id',
                '',
                $Ik177_client_id,
                true,
                'text',
                $db_opcao,
                " style='width: 100%'",
                '',
                '',
                '',
                ''
            );
            ?>
        </td>
    </tr>
    <tr>
        <td title="<?= $Tk177_client_secret ?>">
            <?= $Lk177_client_secret ?>
        </td>
        <td>
            <?php
            db_input(
                'k177_client_secret',
                '',
                $Ik177_client_secret,
                true,
                'text',
                $db_opcao,
                " style='width: 100%'",
                '',
                '',
                '',
                ''
            );
            ?>
        </td>
    </tr>
    <tr>
        <td title="<?= $Tk177_numero_convenio ?>">
            <?= $Lk177_numero_convenio ?>
        </td>
        <td>
            <?php
            db_input(
                'k177_numero_convenio',
                '',
                $Ik177_numero_convenio,
                true,
                'text',
                $db_opcao,
                " style='width: 100%'",
                '',
                '',
                '',
                ''
            );
            ?>
        </td>
    </tr>
    <tr>
        <td title="<?= $Tk177_chave_pix ?>">
            <?= $Lk177_chave_pix ?>
        </td>
        <td>
            <?php
            db_input(
                'k177_chave_pix',
                '',
                $Ik177_chave_pix,
                true,
                'text',
                $db_opcao,
                " style='width: 100%'",
                '',
                '',
                '',
                ''
            );
            ?>
        </td>
    </tr>
</table>
<script type="text/javascript">
    function validaCamposBB() {
        return [
            {field: 'k177_url_api', label: 'URL Api'},
            {field: 'k177_url_oauth', label: ' URL OAuth'},
            {field: 'k177_develop_application_key', label: 'Develop Application Key'},
            {field: 'k177_client_id', label: ' Client ID'},
            {field: 'k177_client_secret', label: 'Client Secret'},
            {field: 'k177_numero_convenio', label: 'Número convênio'},
            {field: 'k177_chave_pix', label: 'Chave PIX'}
        ].every(({field, label}) => {
            const element = document.getElementById(field);
            if (element.value.trim() === '') {
                alert(_M(MENSAGENS + "campo_nao_informado", {sCampo: label}));
                element.focus();
                return false;
            }
            return true;
        });
    }
</script>
