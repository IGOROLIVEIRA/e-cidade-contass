<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
include("classes/db_parametrosrelatoriosiconf_classe.php");
db_postmemory($HTTP_POST_VARS);

$clparametrosrelatorio = new cl_parametrosrelatoriosiconf;
$anousu = db_getsession("DB_anousu");
$db_opcao = 1;

if (isset($incluir)) {
    db_inicio_transacao();
    $clparametrosrelatorio->c222_recimpostostranseduc = $c222_recimpostostranseduc;
    $clparametrosrelatorio->c222_transfundeb60 = $c222_transfundeb60;
    $clparametrosrelatorio->c222_transfundeb40 = $c222_transfundeb40;
    $clparametrosrelatorio->c222_recdestinadoeduc = $c222_recdestinadoeduc;
    $clparametrosrelatorio->c222_recimpostostranssaude = $c222_recimpostostranssaude;
    $clparametrosrelatorio->c222_recdestinadosaude = $c222_recdestinadosaude;
    $clparametrosrelatorio->c222_recdestinadoassist = $c222_recdestinadoassist;
    $clparametrosrelatorio->c222_recdestinadorppspp = $c222_recdestinadorppspp;
    $clparametrosrelatorio->c222_recdestinadorppspf = $c222_recdestinadorppspf;
    $clparametrosrelatorio->c222_recopcreditoexsaudeeduc = $c222_recopcreditoexsaudeeduc;
    $clparametrosrelatorio->c222_recavaliacaodebens = $c222_recavaliacaodebens;
    $clparametrosrelatorio->c222_recordinarios = $c222_recordinarios;
    $clparametrosrelatorio->c222_outrosrecnaovinculados = $c222_outrosrecnaovinculados;
    $clparametrosrelatorio->c222_outrasdestinacoes = $c222_outrasdestinacoes;
    $clparametrosrelatorio->c222_anousu = $anousu;
    $clparametrosrelatorio->incluir();

    if ($clparametrosrelatorio->erro_status == 0) {
        $sqlerro = true;
    }

    if ($clparametrosrelatorio->erro_status == "0") {

        $clparametrosrelatorio->erro(true, false);
        $db_botao = true;
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if ($clparametrosrelatorio->erro_campo != "") {
            echo "<script> document.form1." . $clparametrosrelatorio->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1." . $clparametrosrelatorio->erro_campo . ".focus();</script>";
        }
    }

    db_fim_transacao($sqlerro);
    db_msgbox($clparametrosrelatorio->erro_msg);
}

$result = $clparametrosrelatorio->sql_record($clparametrosrelatorio->sql_query_file(null,"*",null,"c222_anousu={$anousu}"));

if($result > 0){
    db_fieldsmemory($result);
    $db_opcao = 2;
}

if(isset($alterar)){

    db_inicio_transacao();

    $clparametrosrelatorio->alterar();

    if ($clparametrosrelatorio->erro_status == 0) {
        $sqlerro = true;
    }

    db_fim_transacao();
    db_msgbox($clparametrosrelatorio->erro_msg);
    header("Refresh: 0");
}

?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?
    db_app::load("estilos.css,grid.style.css");
    db_app::load("scripts.js");
    ?>
    <style>
        tr.linhas:HOVER {background-color: #999999}
    </style>
</head>
<body>
<form name="form1" method="post" action="" >
    <table  border=0  width="100%">
        <tr>
            <td class="table_header" id="tddescri" style="width: 35%">
                <strong>
                    INSUFICIÊNCIA FINANCEIRA VERIFICADA NO CONSÓRCIO PÚBLICO
                </strong>
            </td>
            <td class="table_header" id="tdvalor" style="width: 20px">
                <strong>
                    VALOR
                </strong>
            </td>
            <td style="width: 59%">
            </td>
        </tr>
        <tr style="display: none">
            <td>
                <strong>Sequencial</strong>
            </td>
            <td>
                <?
                db_input('c222_sequencial', 10, $c222_sequencial, true, 'text', 3, "");
                ?>
            </td>
        </tr>
        <tr style="">
            <td>
                <strong>Exercicio do Relatorio</strong>
            </td>
            <td>
                <?
                db_input('c222_anousu', 10, $c222_anousu, true, 'text', 3, "");
                ?>
            </td>
        </tr>
        <tr class="linhas">
            <td>
                <strong>Receitas de Impostos e de Transferência de Impostos - Educação:</strong>
            </td>
            <td>
                <?
                db_input('c222_recimpostostranseduc', 10, $c222_recimpostostranseduc, true, 'text', 1, "onkeyup=js_ValidaCampos(this,4,'valor','t','f',event);");
                ?>
            </td>
        </tr>
        <tr class="linhas">
            <td>
                <strong>Transferências do FUNDEB 60%</strong>
            </td>
            <td>
                <?
                db_input('c222_transfundeb60', 10, $c222_transfundeb60, true, 'text', 1, "onkeyup=js_ValidaCampos(this,4,'valor','t','f',event);");
                ?>
            </td>
        </tr>
        <tr class="linhas">
            <td>
                <strong>Transferências do FUNDEB 40%</strong>
            </td>
            <td>
                <?
                db_input('c222_transfundeb40', 10, $c222_transfundeb40, true, 'int', 1, "onkeyup=js_ValidaCampos(this,4,'valor','t','f',event);");
                ?>
            </td>
        </tr>
        <tr class="linhas">
            <td>
                <strong>Outros Recursos Destinados à Educação</strong>
            </td>
            <td>
                <?
                db_input('c222_recdestinadoeduc', 10, $c222_recdestinadoeduc, true, 'int', 1, "onkeyup=js_ValidaCampos(this,4,'valor','t','f',event);");
                ?>
            </td>
        </tr>
        <tr class="linhas">
            <td>
                <strong>Receitas de Impostos e de Transferência de Impostos - Saúde</strong>
            </td>
            <td>
                <?
                db_input('c222_recimpostostranssaude', 10, $c222_recimpostostranssaude, true, 'int', 1, "onkeyup=js_ValidaCampos(this,4,'valor','t','f',event);");
                ?>
            </td>
        </tr>
        <tr class="linhas">
            <td>
                <strong>Outros Recursos Destinados à Saúde</strong>
            </td>
            <td>
                <?
                db_input('c222_recdestinadosaude', 10, $c222_recdestinadosaude, true, 'int', 1, "onkeyup=js_ValidaCampos(this,4,'valor','t','f',event);");
                ?>
            </td>
        </tr>
        <tr class="linhas">
            <td>
                <strong>Recursos Destinados à Assistência Social</strong>
            </td>
            <td>
                <?
                db_input('c222_recdestinadoassist', 10, $c222_recdestinadoassist, true, 'int', 1, "onkeyup=js_ValidaCampos(this,4,'valor','t','f',event);");
                ?>
            </td>
        </tr>
        <tr class="linhas">
            <td>
                <strong>Recursos Destinados ao RPPS - Plano Previdenciário</strong>
            </td>
            <td>
                <?
                db_input('c222_recdestinadorppspp', 10, $c222_recdestinadorppspp, true, 'int', 1, "onkeyup=js_ValidaCampos(this,4,'valor','t','f',event);");
                ?>
            </td>
        </tr>
        <tr class="linhas">
            <td>
                <strong>Recursos Destinados ao RPPS - Plano Financeiro</strong>
            </td>
            <td>
                <?
                db_input('c222_recdestinadorppspf', 10, $c222_recdestinadorppspf, true, 'int', 1, "onkeyup=js_ValidaCampos(this,4,'valor','t','f',event);");
                ?>
            </td>
        </tr>
        <tr class="linhas">
            <td>
                <strong>Recursos de Operações de Crédito (exceto destinados à Educação e à Saúde)</strong>
            </td>
            <td>
                <?
                db_input('c222_recopcreditoexsaudeeduc', 10, $c222_recopcreditoexsaudeeduc, true, 'int', 1, "onkeyup=js_ValidaCampos(this,4,'valor','t','f',event);");
                ?>
            </td>
        </tr>
        <tr class="linhas">
            <td>
                <strong>Recursos de Alienação de Bens/Ativos</strong>
            </td>
            <td>
                <?
                db_input('c222_recavaliacaodebens', 10, $c222_recavaliacaodebens, true, 'int', 1, "onkeyup=js_ValidaCampos(this,4,'valor','t','f',event);");
                ?>
            </td>
        </tr>
        <tr class="linhas">
            <td>
                <strong>Recursos Ordinários</strong>
            </td>
            <td>
                <?
                db_input('c222_recordinarios', 10, $c222_recordinarios, true, 'int', 1, "onkeyup=js_ValidaCampos(this,4,'valor','t','f',event);");
                ?>
            </td>
        </tr>
        <tr class="linhas">
            <td>
                <strong>Recursos de Alienação de Bens/Ativos</strong>
            </td>
            <td>
                <?
                db_input('c222_outrosrecnaovinculados', 10, $c222_outrosrecnaovinculados, true, 'int', 1, "onkeyup=js_ValidaCampos(this,4,'valor','t','f',event);");
                ?>
            </td>
        </tr>
        <tr class="linhas">
            <td>
                <strong>Outras Destinações Vinculadas de Recursos</strong>
            </td>
            <td>
                <?
                db_input('c222_outrasdestinacoes', 10, $c222_outrasdestinacoes, true, 'int', 1, "onkeyup=js_ValidaCampos(this,4,'valor','t','f',event);");
                ?>
            </td>
        </tr>
    </table>
    <table border="0">
        <tr>
            <td style="width: 80%"></td>
            <td>
                <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>">
            </td>
        </tr>
    </table>
</form>
</body>
<script>
    //js_preenchercampos();
    //function js_preenchercampos() {
    // document.getElementById('c222_recimpostostranseduc').value = "<?// print $c222_recimpostostranseduc?>//";
    //}
</script>
</html>