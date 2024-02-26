<?php

use App\Models\DBUsuarios;
use App\Models\IssConfiguracaoGrupoServicoUsuario;

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("dbforms/db_funcoes.php");

$oPost = db_utils::postMemory($_POST);
$oGet  = db_utils::postMemory($_GET);

$oDaoConfiguracaoGrupo    = new cl_issconfiguracaogruposervico();
$oDaoEstruturaValor        = new cl_db_estruturavalor();
$dbUsuariosContass = DBUsuarios::query()
    ->where('id_usuario', db_getsession('DB_id_usuario'))
    ->where('login', 'like', '%.contass')
    ->first();
$IssConfiguracaoGrupoServicoUsuario    = IssConfiguracaoGrupoServicoUsuario::query()->where('id_usuario', db_getsession('DB_id_usuario'))->first();

$db_opcao = 22;
$db_botao = false;

if (isset($oPost->salvar)) {

    $db_opcao = 2;

    db_inicio_transacao();

    $oDaoConfiguracaoGrupo->q136_sequencial      = $oPost->q136_sequencial;
    $oDaoConfiguracaoGrupo->q136_issgruposervico = $oPost->q136_issgruposervico;
    $oDaoConfiguracaoGrupo->q136_exercicio       = $oPost->q136_exercicio;
    $oDaoConfiguracaoGrupo->q136_tipotributacao  = $oPost->q136_tipotributacao;
    $oDaoConfiguracaoGrupo->q136_valor           = $oPost->q136_valor;
    $oDaoConfiguracaoGrupo->q136_valor_reduzido  = $oPost->q136_valor_reduzido;

    if (!empty($oPost->q136_sequencial)) {
        $oDaoConfiguracaoGrupo->alterar($q136_sequencial);
    } else {
        $oDaoConfiguracaoGrupo->incluir(null);
    }

    if ((!empty($oPost->iSequencialEstrutural)) && ($dbUsuariosContass || $IssConfiguracaoGrupoServicoUsuario)) {
        $oDaoEstruturaValor->db121_sequencial    = $oPost->iSequencialEstrutural;
        $oDaoEstruturaValor->db121_descricao    = $oPost->sDescricaoGrupoServico;
        $oDaoEstruturaValor->alterar($iSequencialEstrutural);
    }

    db_fim_transacao();
} elseif (isset($oGet->iCodigoGrupoServico)) {

    $db_opcao = 2;

    $sCampos  = "db_estruturavalor.db121_sequencial as id_estrutural,";
    $sCampos .= "db_estruturavalor.db121_estrutural as codigo_grupo,";
    $sCampos .= "db_estruturavalor.db121_descricao  as descricao_grupo,";
    $sCampos .= "issconfiguracaogruposervico.*";
    $sWhere   = "issgruposervico.q126_sequencial = {$oGet->iCodigoGrupoServico} and q136_exercicio = " . db_getsession('DB_anousu');

    $sSqlConfiguracaoGrupo    = $oDaoConfiguracaoGrupo->sql_query_grupoServico($sCampos, $sWhere);
    $rsConfiguracaoGrupo    = $oDaoConfiguracaoGrupo->sql_record($sSqlConfiguracaoGrupo);

    if ($oDaoConfiguracaoGrupo->numrows > 0) {

        $oConfiguracaoGrupo = db_utils::fieldsMemory($rsConfiguracaoGrupo, 0);

        $iCodigoGrupoServico    = $oConfiguracaoGrupo->codigo_grupo;
        $sDescricaoGrupoServico = $oConfiguracaoGrupo->descricao_grupo;
        $iSequencialEstrutural    = $oConfiguracaoGrupo->id_estrutural;

        $q136_issgruposervico = $oGet->iCodigoGrupoServico;
        $q136_sequencial      = $oConfiguracaoGrupo->q136_sequencial;
        $q136_exercicio       = $oConfiguracaoGrupo->q136_exercicio;
        $q136_tipotributacao  = $oConfiguracaoGrupo->q136_tipotributacao;
        $q136_valor           = $oConfiguracaoGrupo->q136_valor;
        $q136_valor_reduzido  = $oConfiguracaoGrupo->q136_valor_reduzido;
        $q136_localpagamento  = $oConfiguracaoGrupo->q136_localpagamento;

        $db_botao = true;
    }

    if (empty($q136_exercicio)) {
        $q136_exercicio = db_getsession('DB_anousu');
        $q136_issgruposervico = $oGet->iCodigoGrupoServico;
    }
}
?>
<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?php db_app::load("estilos.css, grid.style.css, scripts.js, strings.js, prototype.js"); ?>
</head>

<body class="body-default">
    <div class="container">
        <?php include("forms/db_frmissconfiguracaogruposervico.php"); ?>
    </div>
    <?php
    db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));

    if (isset($oPost->salvar)) {

        if ($oDaoConfiguracaoGrupo->erro_status == "0") {

            $oDaoConfiguracaoGrupo->erro(true, false);
            $db_botao = true;

            echo "<script>document.form1.db_opcao.disabled=false;</script>";

            if ($oDaoConfiguracaoGrupo->erro_campo != "") {

                echo "<script> document.form1." . $oDaoConfiguracaoGrupo->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
                echo "<script> document.form1." . $oDaoConfiguracaoGrupo->erro_campo . ".focus();</script>";
            }
        } else {
            $oDaoConfiguracaoGrupo->erro(true, true);
        }
    }

    if ($db_opcao == 22) {
        echo "<script>document.form1.pesquisar.click();</script>";
    }
    ?>

</body>
<html>
