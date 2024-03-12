<?php

//MODULO: issqn
use App\Models\Socio;

include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir();
$clsocios->rotulo->label();
$clrotulo = new rotulocampo();
$clrotulo->label("z01_nome");
if (empty($excluir) && empty($alterar) && isset($opcao) && $opcao != "") {
    $result24 = $clsocios->sql_record($clsocios->sql_query($q95_cgmpri, $q95_numcgm, 'z01_nome,q95_perc'));
    db_fieldsmemory($result24, 0);
    $result25 = $clcgm->sql_record($clcgm->sql_query_file($q95_numcgm, 'z01_nome as z01_nome_socio'));
    db_fieldsmemory($result25, 0);
}
if (isset($opcao) && $opcao == "alterar") {
    $db_opcao = 2;
} elseif ((isset($opcao) && $opcao == "excluir") || (isset($db_opcao) && $db_opcao == 3)) {
    $db_opcao = 3;
} else {
    $db_opcao = 1;
}
$sql = $clsocios->sql_query_socios($q95_cgmpri, "", "sum(q95_perc) as somaval ");
$result_testaval = pg_exec($sql);
if (pg_numrows($result_testaval) != 0) {
    db_fieldsmemory($result_testaval, 0);

} else $somaval = 0;
?>
<form name="form1" method="post" action="iss1_socios004.php">
    <table border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td height="140" align="center" valign="top">
                <center>
                    <fieldset style="margin-top: 20px;">
                        <legend><b>Cadastro de Socios</b></legend>

                        <table border="0">
                            <tr>
                                <td nowrap title="<?= @$Tq95_cgmpri ?>">
                                    <?= $Lq95_cgmpri ?>
                                </td>
                                <td>
                                    <?php
                                    db_input('somaval', 20, "", true, 'hidden', 3);
                                    db_input('q95_cgmpri', 6, $Iq95_cgmpri, true, 'text', 3);
                                    ?>
                                    <?php
                                    $z01_nome = stripslashes($z01_nome);
                                    db_input('z01_nome', 40, $Iz01_nome, true, 'text', 3, '');
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap title="<?= @$Tq95_numcgm ?>">
                                    <?php
                                    if ($db_opcao == 2) {
                                        $str_01 = 3;
                                    } else {
                                        $str_01 = $db_opcao;
                                    }
                                    db_ancora(@$Lq95_numcgm, "js_pesquisaq95_numcgm(true);", $str_01);
                                    ?>
                                    <input type='hidden' id='fisico_juridico' style="width: 50px;"/>
                                </td>
                                <td>
                                    <?php
                                    db_input('q95_numcgm', 6, $Iq95_numcgm, true, 'text', $str_01, " onchange='js_pesquisaq95_numcgm(false);'")
                                    ?>
                                    <?php
                                    db_input('z01_nome', 40, $Iz01_nome, true, 'text', 3, '', 'z01_nome_socio');
                                    ?>
                                </td>

                            <tr>
                                <td nowrap title="<?= @$Tq95_tipo ?>">
                                    <?= @$Lq95_tipo ?>
                                </td>
                                <td>
                                    <?php
                                    $aTipo = ['0' => "Selecione...", ...Socio::ASSOCIABLES_WITH_LABEL];
                                    db_select('q95_tipo', $aTipo, true, $db_opcao);
                                    ?>
                                </td>
                            </tr>


                            <tr id='valor_capital' style="display: none;">
                                <td nowrap title="<?= @$Tq95_perc ?>">
                                    <?= @$Lq95_perc ?>
                                </td>
                                <td>
                                    <?php
                                    db_input('q95_perc', 15, $Iq95_perc, true, 'text', $db_opcao, "");
                                    ?>
                                </td>
                            </tr>
                            <?php
                            $sAcaoClick = "";
                            if ($db_opcao == 33 || $db_opcao == 3) {

                                $sAcaoClick = "";
                            } else {
                                $sAcaoClick = " onclick='return js_verificatipo();'";
                            }
                            ?>


                            <tr>
                                <td colspan="2" align="center">
                                    <input
                                        name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>"
                                        type="submit" id="db_opcao"
                                        value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>"
                                        <?= ($db_botao == false ? "disabled" : "") ?> <?= $sAcaoClick ?> >
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </center>
            </td>
        </tr>

        <tr>
            <td colspan="2"> &nbsp;</td>
        </tr>

        <tr>
            <td valign="top">
                <?php
                $chavepri = array("q95_cgmpri" => $q95_cgmpri, "q95_numcgm"=>@$q95_numcgm, "q95_tipo" => @$q95_cgmpri);
                $cliframe_alterar_excluir->chavepri = $chavepri;
                $sWhereSocios = "     q95_cgmpri = $q95_cgmpri ";
                $sCampoQ95Tipo = ' '.Socio::getCaseAssociateLabel(). ' ';

                $cliframe_alterar_excluir->sql = $clsocios->sql_query_socios(null, null, "q95_numcgm,q95_tipo,soc.z01_nome,q95_perc,q95_cgmpri,$sCampoQ95Tipo", null, $sWhereSocios);
                $cliframe_alterar_excluir->campos = "q95_numcgm,z01_nome,q95_perc, tipo ";
                $cliframe_alterar_excluir->legenda = "SÓCIOS CADASTRADOS";
                $cliframe_alterar_excluir->msg_vazio = "Não foi encontrado nenhum registro.";
                $cliframe_alterar_excluir->textocabec = "darkblue";
                $cliframe_alterar_excluir->textocorpo = "black";
                $cliframe_alterar_excluir->fundocabec = "#aacccc";
                $cliframe_alterar_excluir->fundocorpo = "#ccddcc";
                $cliframe_alterar_excluir->formulario = false;
                $cliframe_alterar_excluir->iframe_alterar_excluir($db_opcao);
                ?>
            </td>
        </tr>
        <tr>
            <td align='right'>
                <?php
                $somaval = db_formatar(@$somaval, 'f');
                ?>
                <b>Valor total do capital:
                    <?= @$somaval ?>
                </b>
            </td>
        </tr>
    </table>
</form>
