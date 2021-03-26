<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

//MODULO: issqn
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clissnotaavulsaservico->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("q51_sequencial");
if (isset($db_opcaoal)) {
    $db_opcao = 33;
    $db_botao = false;
} else if (isset($opcao) && $opcao == "alterar") {
    $db_botao = true;
    $db_opcao = 2;
} else if (isset($opcao) && $opcao == "excluir") {
    $db_opcao = 3;
    $db_botao = true;
} else {
    $db_opcao = 1;
    $db_botao = true;
    if (isset($novo) || isset($alterar) || isset($excluir) || (isset($incluir) && $sqlerro == false)) {
        $q62_issnotaavulsa = "";
        $q62_qtd = "";
        $q62_discriminacao = "";
        $q62_vlruni = "";
        $q62_aliquota = "";
        $q62_vlrdeducao = "";
        $q62_vlrtotal = "";
        $q62_vlrbasecalc = "";
        $q62_vlrissqn = "";
        $q62_obs = "";
        $q62_vlrirrf = '';
        $q62_vlrinss = '';
        $q62_tiporetirrf = '';
        $q62_tiporetinss = '';
        $q62_deducaoinss = '';
        $q62_qtddepend = '';
    }
}
$SQLTotLinhas  = "select q62_discriminacao";
$SQLTotLinhas .= "  from issnotaavulsaservico ";
$SQLTotLinhas .= " where q62_issnotaavulsa = {$get->q51_sequencial}";
$rsTotLInhas = pg_query($SQLTotLinhas);
$totlinhas = 0;
$hasServico = false;
if (pg_num_rows($rsTotLInhas) > 0) {
    $hasServico = true;
    for ($i = 0; $i < pg_num_rows($rsTotLInhas); $i++) {

        $oLinha = db_utils::fieldsMemory($rsTotLInhas, $i);
        $totlinhas += db_calculaLinhasTexto22($oLinha->q62_discriminacao);

    }

}

$sSqlHasRecibo = "select q52_numnov from issnotaavulsanumpre ";
$sSqlHasRecibo .= "where q52_issnotaavulsa = {$get->q51_sequencial}";

$rsHasRecibo = pg_query($sSqlHasRecibo);
$hasRecibo = false;

if (pg_num_rows($rsHasRecibo) > 0) {
    $hasRecibo = true;
}

$sSqlAnoFolha = "select max(r11_anousu) as r11_anousu from cfpess";
$oAnoFolha = db_utils::fieldsMemory(db_query($sSqlAnoFolha), 0);

$iCodInstit = intval(db_getsession('DB_instit'));
$iCodAnousu = intval($oAnoFolha->r11_anousu);

$sSQLTabelaIRRF = "
SELECT r33_inic, r33_fim, r33_perc, r33_deduzi
FROM inssirf
WHERE r33_instit = {$iCodInstit}
    AND r33_anousu = {$iCodAnousu}
    AND r33_mesusu = (
      SELECT MAX(r33_mesusu)
      FROM inssirf
      WHERE r33_anousu = {$iCodAnousu}
          AND r33_instit = {$iCodInstit}
          AND r33_codtab = '1'
    )
    AND r33_codtab = '1'
ORDER BY r33_anousu DESC,
         r33_mesusu DESC,
         r33_inic ASC";

$sSQLValorDependente = "SELECT r07_valor
FROM pesdiver
WHERE r07_anousu = {$iCodAnousu}
  AND r07_instit = {$iCodInstit}
  AND r07_mesusu = (
      SELECT MAX(r07_mesusu)
      FROM pesdiver
      WHERE r07_anousu = {$iCodAnousu} AND r07_instit = {$iCodInstit}
    )
    AND r07_codigo = 'D901'
ORDER BY r07_anousu DESC,
         r07_mesusu DESC
LIMIT 1";

$aValoresTabela = db_utils::getCollectionByRecord(db_query($sSQLTabelaIRRF));
$oValorDependente = db_utils::fieldsMemory(db_query($sSQLValorDependente), 0);


$aTiposRetencoesIRRF = array(
    'nada' => 'Selecione um tipo',
    'passageiros' => 'IRRF Transporte de Passageiros',
    'material' => 'IRRF Transporte de Material',
    'outros' => 'IRRF Outros'
);

$aTiposRetencoesINSS = array(
    'nada' => 'Selecione um tipo',
    'passageiros' => 'INSS Transporte de Passageiros',
    'material' => 'INSS Transporte de Material',
    'outros' => 'INSS Outros'
);


?>

<style type="text/css">

    .margin-v10 {
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .text-right {
        text-align: right;
    }

    .td-retencao {
        width: 127px;
        font-weight: bold;
    }

    .td-retencao-campos {
        width: 130px;
    }

</style>

<form name="form1" method="post" action="">
    <center>
        <table border="0">
            <tr>
                <td>
                    <fieldset>
                        <legend><b>Serviços</b></legend>
                        <table>
                            <?
                            $q62_issnotaavulsa = $get->q51_sequencial;
                            db_input('q62_issnotaavulsa', 10, $Iq62_issnotaavulsa, true, 'hidden', $db_opcao, " onchange='js_pesquisaq62_issnotaavulsa(false);'");
                            db_input('q62_sequencial', 10, $Iq62_sequencial, true, 'hidden', $db_opcao, "");
                            $q62_qtd = 1;
                            db_input('q62_qtd', 10, $Iq62_qtd, true, 'hidden', $db_opcao, "");
                            ?>
                            <tr>
                                <td nowrap title="Códido do Serviço">
                                    <strong><? db_ancora("Código do Serviço:", "js_pesquisa_servico(true);", $db_opcao); ?></strong>
                                </td>
                                <td colspan='3'>
                                    <?php
                                    $db121_estrutural = isset($db121_estrutural) ? $db121_estrutural : "";
                                    $db121_descricao = isset($db121_descricao) ? $db121_descricao : "";
                                    db_input("db121_estrutural", 10, "text", TRUE, "text", 3);
                                    db_input("q62_issgruposervico", 10, "text", FALSE, "hidden", 3);
                                    db_input("db121_descricao", 44, "text", TRUE, "text", 3);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap title="<?= @$Tq62_discriminacao ?>">
                                    <?= @$Lq62_discriminacao ?>
                                </td>
                                <td colspan='3'>
                                    <?
                                    db_textarea('q62_discriminacao', 2, 57, $Iq62_discriminacao, true, 'text', $db_opcao, "onkeyup=''");

                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap title="<?= @$Tq62_vlruni ?>">
                                    <?= @$Lq62_vlruni ?>
                                </td>
                                <td>
                                    <?
                                    db_input('q62_vlruni', 12, $Iq62_vlruni, true, 'text', $db_opcao, "onblur='js_calcula()'");
                                    ?>
                                </td>
                                <td nowrap title="<?= @$Tq62_vlrtotal ?>">
                                    <?= @$Lq62_vlrtotal ?>
                                </td>
                                <td>
                                    <?
                                    db_input('q62_vlrtotal', 15, $Iq62_vlrtotal, true, 'text', 3, "")
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap title="<?= @$Tq62_vlrdeducao ?>">
                                    &nbsp;
                                    <?php //=@$Lq62_vlrdeducao ?>
                                </td>
                                <td>
                                    &nbsp;
                                    <?php db_input('q62_vlrdeducao', 12, $Iq62_vlrdeducao, true, 'hidden', $db_opcao, "onblur=\"js_calcula();\"") ?>
                                </td>
                                <td nowrap title="<?= @$Tq62_vlrbasecalc ?>">
                                    <?= @$Lq62_vlrbasecalc ?>
                                </td>
                                <td>
                                    <?php db_input('q62_vlrbasecalc', 15, $Iq62_vlrbasecalc, true, 'text', 3, "") ?>
                                </td>
                            </tr>

                            <tr>
                                <td nowrap title="<?= @$Tq62_aliquota ?>">
                                    <b><?= @$Lq62_aliquota ?> <b>ISSQN %</b>
                                </td>
                                <td>
                                    <?php db_input('q62_aliquota', 12, $Iq62_aliquota, true, 'text', $db_opcao, "onblur='js_calcula()'") ?>
                                </td>
                                <td nowrap title="<?= @$Tq62_vlrissqn ?>">
                                    <?= @$Lq62_vlrissqn ?>
                                </td>
                                <td>
                                    <?php db_input('q62_vlrissqn', 15, $Iq62_vlrissqn, true, 'text', 3, "") ?>
                                </td>
                            </tr>

                            <!-- INSS -->
                            <tr>
                                <td colspan="4">
                                    <fieldset class="margin-v10">
                                        <legend>INSS</legend>

                                        <table>
                                            <tr>
                                                <td class="td-retencao" nowrap title="<?= @$Tq62_deducaoinss ?>">
                                                    <?= @$Lq62_deducaoinss ?>
                                                </td>
                                                <td class="td-retencao-campos">
                                                    <?php db_input('q62_deducaoinss', 15, $Iq62_deducaoinss, true, 'text', $db_opcao, "") ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="td-retencao">Tipo de retenção:</td>
                                                <td colspan="3">
                                                    <?php db_select('q62_tiporetinss', $aTiposRetencoesINSS, true, 2, "onchange='js_RetencaoINSS();'"); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="td-retencao" nowrap title="<?= @$Tq62_vlrinss ?>">
                                                    <?= @$Lq62_vlrinss ?>
                                                </td>
                                                <td class="td-retencao-campos" colspan="3">
                                                    <?php db_input('q62_vlrinss', 15, $Iq62_vlrinss, true, 'text', 3, "") ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </fieldset>
                                </td>
                            </tr>

                            <!-- IRRF -->
                            <tr>
                                <td colspan="4">
                                    <fieldset class="margin-v10">
                                        <legend>IRRF</legend>

                                        <table>
                                            <tr>
                                                <td class="td-retencao" nowrap title="<?= @$Tq62_qtddepend ?>">
                                                    <?= @$Lq62_qtddepend ?>
                                                </td>
                                                <td class="td-retencao-campos">
                                                    <?php db_input('q62_qtddepend', 15, $Iq62_qtddepend, true, 'text', $db_opcao, "") ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="td-retencao">Tipo de retenção:</td>
                                                <td colspan="3">
                                                    <?php db_select('q62_tiporetirrf', $aTiposRetencoesIRRF, true, 2, "onchange='js_RetencaoIRRF();'"); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="td-retencao" nowrap title="<?= @$Tq62_vlrirrf ?>">
                                                    <?= @$Lq62_vlrirrf ?>
                                                </td>
                                                <td class="td-retencao-campos" colspan="3">
                                                    <?php db_input('q62_vlrirrf', 15, $Iq62_vlrirrf, true, 'text', 3, "") ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </fieldset>
                                </td>
                            </tr>

                            <tr>
                                <td nowrap title="<?= @$Tq62_obs ?>">
                                    <?= @$Lq62_obs ?>
                                </td>
                                <td colspan='3'>
                                    <?
                                    db_textarea('q62_obs', 0, 57, $Iq62_obs, true, 'text', $db_opcao, "onkeyup='js_controlatextarea(this.name,200);'");
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </td>
            </tr>
            </tr>
            <td colspan="2" align="center">
                <input type='hidden' id='totlinhas' readonly name='totlinhas' value="<?= $totlinhas; ?>">
                <?php
                if($db_opcao == 1 && !$hasServico){
                ?>
                <input type="submit" name="incluir" id="db_opcao" value="Incluir" <?= ($db_botao == false ? "disabled" : "") ?>>
                <?php } ?>

                <?php
                if($db_opcao == 2 || $db_opcao == 22){
                ?>
                <input type="submit" name="alterar" id="db_opcao" value="Alterar" <?= ($db_botao == false ? "disabled" : "") ?>>
                <?php } ?>

                <?php
                if($db_opcao == 3 || $db_opcao == 33){
                ?>
                <input type="submit" name="excluir" id="db_opcao" value="Excluir" <?= ($db_botao == false ? "disabled" : "") ?>>
                <?php } ?>

                <input name="novo" type="button" id="cancelar" value="Novo"
                       onclick="js_cancelar();" <?= ($db_opcao == 1 || isset($db_opcaoal) || $hasServico ? "style='visibility:hidden;'" : "") ?> >
                <input name="recibo" type="submit" <?= ($hasRecibo || !$hasServico ? "disabled" : "") ?> onclick='return js_emiteRecibo(<?= $oPar->q60_notaavulsavlrmin; ?>)'
                       id="recibo" value="Emitir Recibo">
                <input name='notaavulsa' <?= (!$hasServico ? 'style="display:none;"' : '') ?> onclick='return js_verificaNota();' type='submit' id='nota'
                       value='Emitir nota'>
                <?
                $fTotal = 0;
                $sql = "select sum(q62_vlrissqn) as totalissqn,";
                $sql .= "sum(q62_vlruni) as q62_vlrini,";
                $sql .= "sum(q62_vlrdeducao) as q62_vlrdeducao,";
                $sql .= "sum(q62_vlrtotal) as q62_vlrtotal,";
                $sql .= "sum(q62_vlrbasecalc) as q62_vlrbasecalc";
                $sql .= " from issnotaavulsaservico
 									where q62_issnotaavulsa = " . $q62_issnotaavulsa;
                $oTotal = db_utils::fieldsMemory(pg_query($sql), 0);
                $totalissqn = $oTotal->totalissqn;
                //      if (($lGeraNota and $emitenota) or ($oPar->q60_notaavulsavlrmin > $totalissqn )){
                //
                //           echo " <input name='notaavulsa' onclick='return js_verificaNota();' type='submit' id='nota' value='Emitir nota'>";
                //
                //      }

                ?>
            </td>
            </tr>
        </table>
        <table>
            <tr>
                <td valign="top" align="center">
                    <?
                    $chavepri = array("q62_sequencial" => $get->q51_sequencial);
                    $cliframe_alterar_excluir->chavepri = $chavepri;
                    $cliframe_alterar_excluir->sql = $clissnotaavulsaservico->sql_query_file(null, "*", "q62_sequencial"
                        , "q62_issnotaavulsa=" . $get->q51_sequencial);
                    $cliframe_alterar_excluir->campos = "q62_sequencial,q62_issnotaavulsa,q62_qtd,db121_estrutural, q62_discriminacao,q62_vlruni,q62_aliquota,q62_vlrdeducao,q62_vlrtotal,q62_vlrbasecalc,q62_vlrissqn, q62_vlrirrf, q62_vlrinss";
                    $cliframe_alterar_excluir->legenda = "ITENS LANÇADOS";
                    $cliframe_alterar_excluir->iframe_height = "160";
                    $cliframe_alterar_excluir->iframe_width = "700";
                    if ($hasRecibo) {

                        $cliframe_alterar_excluir->opcoes = 4;

                    }
                    $cliframe_alterar_excluir->iframe_alterar_excluir($db_opcao);
                    ?>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <table class='tab' width='100%'>
                        <tr style='text-align:right'>
                            <th rowspan='2'><B>TOTAIS</b></th>
                            <th><b>Deduções</b></th>
                            <th><b>Valor Total</b></th>
                            <th><b>Base Cálculo </b></th>
                            <th><b>valor ISSQN </b></th>
                        </tr>
                        <tr>
                            <td>
                                <?= number_format($oTotal->q62_vlrdeducao, 2, ",", ".") ?>
                            </td>
                            <td>
                                <?= number_format($oTotal->q62_vlrtotal, 2, ",", ".") ?>
                            </td>
                            <td>
                                <?= number_format($oTotal->q62_vlrbasecalc, 2, ",", ".") ?>
                            </td>
                            <td>
                                <input type='' id='vlrrectotal'
                                       readonly style='border:0;background:transparent'
                                       value='<?= number_format($totalissqn, 2, ',', '.'); ?>' name='vlrrectotal'>
                            </td>
                        </tr>
                    </table>
    </center>
</form>
<script type="text/javascript" src="scripts/strings.js"></script>
<script>
    function js_cancelar() {
        var opcao = document.createElement("input");
        opcao.setAttribute("type", "hidden");
        opcao.setAttribute("name", "novo");
        opcao.setAttribute("value", "true");
        document.form1.appendChild(opcao);
        document.form1.submit();
    }
    function js_pesquisaq62_issnotaavulsa(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('CurrentWindow.corpo.iframe_issnotaavulsaservico', 'db_iframe_issnotaavulsa', 'func_issnotaavulsa.php?funcao_js=parent.js_mostraissnotaavulsa1|q51_sequencial|q51_sequencial', 'Pesquisa', true, '0', '1', '775', '390');
        } else {
            if (document.form1.q62_issnotaavulsa.value != '') {
                js_OpenJanelaIframe('CurrentWindow.corpo.iframe_issnotaavulsaservico', 'db_iframe_issnotaavulsa', 'func_issnotaavulsa.php?pesquisa_chave=' + document.form1.q62_issnotaavulsa.value + '&funcao_js=parent.js_mostraissnotaavulsa', 'Pesquisa', false);
            } else {
                document.form1.q51_sequencial.value = '';
            }
        }
    }
    function js_mostraissnotaavulsa(chave, erro) {
        document.form1.q51_sequencial.value = chave;
        if (erro == true) {
            document.form1.q62_issnotaavulsa.focus();
            document.form1.q62_issnotaavulsa.value = '';
        }
    }
    function js_mostraissnotaavulsa1(chave1, chave2) {
        document.form1.q62_issnotaavulsa.value = chave1;
        document.form1.q51_sequencial.value = chave2;
        db_iframe_issnotaavulsa.hide();
    }

    function js_setValorTotal() {

        iQtde = new Number(document.getElementById('q62_qtd').value);
        dVlUni = new Number(document.getElementById('q62_vlruni').value);
        dTotal = (iQtde * dVlUni);
        dTotal = js_round(dTotal, 2);
        document.getElementById('q62_vlrtotal').value = dTotal;
    }

    function js_setValorIssqn() {

        dBaseCalc = new Number(document.getElementById('q62_vlrbasecalc').value);
        dAliquota = new Number(document.getElementById('q62_aliquota').value);
        dTotal = (dBaseCalc * (dAliquota / 100));
        dTotal = js_round(dTotal, 2);
        document.getElementById('q62_vlrissqn').value = dTotal;
    }

    function js_setValorBaseCalculo() {

        dDeducoes = new Number(document.getElementById('q62_vlrdeducao').value);
        dVlTotal = new Number(document.getElementById('q62_vlrtotal').value);
        dTotal = (dVlTotal - dDeducoes);
        dTotal = js_round(dTotal, 2);
        document.getElementById('q62_vlrbasecalc').value = dTotal;
    }
    function js_testaDeducao() {

        dDeducao = new Number(document.getElementById('q62_vlrdeducao').value);
        dVlTotal = new Number(document.getElementById('q62_vlrtotal').value);
        if (dDeducao != 0 && (dDeducao > dVlTotal)) {

            document.getElementById('q62_vlrdeducao').value = '';
            alert('Valor da Deducao nao pode ser maior que o valor total');
            document.getElementById('q62_vlrdeducao').focus();
        }
    }

    function js_calcula() {

        js_setValorTotal();
        js_testaDeducao();
        js_setValorBaseCalculo();
        js_setValorIssqn();

    }
    function js_emiteRecibo(valMin) {

        valNota = $F('vlrrectotal').replace(".", '');
        valNota = valNota.replace(",", '.');
        valNota = new Number(valNota);
        valMin = new Number(valMin);

        if ($F('totlinhas') > 40) {

            alert('Total das linhas da descrição da nota maior que o permitido (40 linhas)');
            return false;

        }
        if (valNota >= valMin) {
            parent.iframe_issnotaavulsa.document.getElementById('db_opcao').disabled = true;
            parent.iframe_issnotaavulsa.document.getElementById('nota').style.display = "";
            parent.iframe_issnotaavulsa.document.getElementById('recibo').disabled = true;

            parent.iframe_issnotaavulsatomador.document.getElementById('db_opcao').disabled = true;
            parent.iframe_issnotaavulsatomador.js_controlaAncora(false);

            return true;
        } else {
            alert('Recibo não pode ser emitido.\nValor do imposto menor que o  valor configurado R$' + valMin);
            return false;
        }

    }
    function js_verificaNota() {

        if ($F('totlinhas') > 40) {

            alert('Total das linhas da descrição da nota maior que o permitido (40 linhas)');
            return false;

        }
    }
    function js_controlatextarea(objt, max) {
        obj = eval('document.form1.' + objt);
        atu = max - obj.value.length;
        if (obj.value.length > max) {
            alert('A mensagem pode ter no máximo ' + max + ' caracteres !');
            obj.value = obj.value.substr(0, max);
            obj.select();
            obj.focus();
        }
    }

    // -------------------

    function calculaValorDePorcentagem(base, percent) {
        return Number((base * percent) / 100).toFixed(2);
    }


    function calculaPorcentagemDeValor(base, valor) {
        return Number(valor * 100 / base).toFixed(2);
    }


    function getValorINSS() {
        return parseFloat(document.getElementById('q62_vlrinss').value);
    }


    function calculoRetencaoINSS(info, percentual) {

        var outrasRetencoes = parseFloat(info.retencoesAntigas.value) || 0;
        var novaRetencao = calculaValorDePorcentagem(info.baseCalculo, percentual);
        var somaAntigaNova = (outrasRetencoes + novaRetencao);

        if (outrasRetencoes > 0) {
            if (somaAntigaNova >= info.limiteINSS) {
                novaRetencao = info.limiteINSS - outrasRetencoes;
            }
        } else if (novaRetencao >= info.limiteINSS) {
            novaRetencao = info.limiteINSS;
        }

        return novaRetencao;

    }


    function getValoresTabelasIRRF() {
        return {
            valorDependente: <?= floatval($oValorDependente->r07_valor) ?>,
            tabelas: <?= json_encode($aValoresTabela) ?>
        };
    }


    function decideDeducaoIRRF(valorBase) {

        valorBase = valorBase < 0 ? 1 : valorBase;
        var jsonValoresIRRF = getValoresTabelasIRRF().tabelas;

        if (!jsonValoresIRRF.length) {
            alert('Impossível realizar cálculo sem tabelas do IRRF.');
            return null;
        }

        return jsonValoresIRRF.filter(function (obj) {

            var valorIni = Number(obj.r33_inic);
            var valorFim = Number(obj.r33_fim);

            return ((valorBase >= valorIni) && (valorBase <= valorFim));

        }).shift();

    }


    function calculoRetencaoIRRF(info) {

        var valoresIRRF = getValoresTabelasIRRF();

        var baseIRRF = info.valorNota - info.baseIRRF - info.valorINSS;
        baseIRRF -= (valoresIRRF.valorDependente * info.qtdDependentes);
        baseIRRF = baseIRRF.toFixed(2);

        var deducaoIRRF = decideDeducaoIRRF(baseIRRF);

        var valorFinal = calculaValorDePorcentagem(baseIRRF, Number(deducaoIRRF.r33_perc));
        valorFinal -= Number(deducaoIRRF.r33_deduzi).toFixed(2);

        console.log(valoresIRRF);
        console.log(info);
        console.log(baseIRRF);
        console.log(deducaoIRRF);

        return valorFinal;

    }

    // -----------

    function js_RetencaoINSS() {

        var select = document.getElementById('q62_tiporetinss');

        var info = {
            limiteINSS: 671.12,
            baseCalculo: parseFloat(document.getElementById('q62_vlrtotal').value),
            retencoesAntigas: document.getElementById('q62_deducaoinss')
        };

        var campos = {
            valorFinal: document.getElementById('q62_vlrinss')
        };

        if (!select.value) {
            campos.valorFinal.value = '';
            return;
        }

        if (isNaN(info.baseCalculo)) {
            alert('Defina um valor para a base de cálculo antes de prosseguir.');
            campos.valorFinal.value = '';
            select.value = 'nada';
            return;
        }

        var retencoes = {
            passageiros: calculoRetencaoINSS.bind(null, info, 2.2),
            material: calculoRetencaoINSS.bind(null, info, 1.1),
            outros: calculoRetencaoINSS.bind(null, info, 11),
            nada: function () {
                return 0;
            },
        };

        if (retencoes[select.value]) {

            var calculo = retencoes[select.value]();
            campos.valorFinal.value = Number(calculo).toFixed(2);

        } else {
            select.value = '';
        }

        js_RetencaoIRRF();
    }


    function js_RetencaoIRRF() {

        var select = document.getElementById('q62_tiporetirrf');

        var retencoes = {
            passageiros: 60,
            material: 10,
            outros: 0
        };

        if (!select.value || (retencoes[select.value] == undefined)) {
            return;
        }

        var info = {};
        info.valorNota = parseFloat(document.getElementById('q62_vlrtotal').value);
        info.baseIRRF = calculaValorDePorcentagem(info.valorNota, retencoes[select.value]);
        info.valorINSS = getValorINSS();
        info.qtdDependentes = parseInt(document.getElementById('q62_qtddepend').value);

        var campos = {
            valorFinal: document.getElementById('q62_vlrirrf')
        };

        if (isNaN(info.valorINSS)) {
            alert('Defina um valor das retenções de INSS');
            campos.valorFinal.value = '';
            select.value = 'nada';
            return;
        }

        if (isNaN(info.qtdDependentes)) {
            alert('Defina o número de dependentes.');
            campos.valorFinal.value = '';
            select.value = 'nada';
            return;
        }

        var valoresIRRF = calculoRetencaoIRRF(info);
        campos.valorFinal.value = Number(valoresIRRF).toFixed(2);

    }

    document.getElementById('q62_deducaoinss').addEventListener('change', js_RetencaoINSS);
    document.getElementById('q62_qtddepend').addEventListener('change', js_RetencaoIRRF);

    /**
     * Pesquisa Serviço
     *
     */
    function js_pesquisa_servico(mostra) {

        if (mostra == true) {
            js_OpenJanelaIframe('', 'db_iframe_issgruposervico', 'func_issgruposervico.php?tipotributacao=2&funcao_js=parent.js_mostraServico1|q126_sequencial|db121_descricao|q136_valor|db121_estrutural', 'Pesquisa', true);
        } else {

            if (document.form1.db121_estrutural.value != '') {
                js_OpenJanelaIframe('', 'db_iframe_issgruposervico', 'func_issgruposervico.php?tipotributacao=2pesquisa_chave=' + document.form1.db121_estrutural.value + '&funcao_js=parent.js_mostraServico', 'Pesquisa', false);
            } else {
                document.form1.db121_descricao.value = '';
            }
        }
    }

    function js_mostraServico(chave, chave2, erro) {

        document.form1.db121_descricao.value = chave;
        document.form1.q62_aliquota.value = chave2;

        if (erro == true) {

            document.form1.db121_estrutural.focus();
            document.form1.db121_estrutural.value = '';
        }
    }

    function js_mostraServico1(chave1, chave2, chave3, chave4) {

        document.form1.db121_estrutural.value = chave4;
        document.form1.db121_descricao.value = chave2;
        document.form1.q62_aliquota.value = chave3;
        document.form1.q62_issgruposervico.value = chave1;
        js_calcula();
        db_iframe_issgruposervico.hide();
    }
</script>
