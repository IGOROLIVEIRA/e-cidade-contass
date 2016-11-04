<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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

include("fpdf151/pdf.php");
include("libs/db_liborcamento.php");
include("libs/db_libcontabilidade.php");
include("libs/db_sql.php");
include("fpdf151/assinatura.php");

db_postmemory($HTTP_POST_VARS);

$dtini = implode("-", array_reverse(explode("/", $DBtxt21)));
$dtfim = implode("-", array_reverse(explode("/", $DBtxt22)));
$oDataFim = new DBDate($dtfim);
$oDataIni = new DBDate($dtini);

$instits = str_replace('-', ', ', $db_selinstit);
$aInstits = explode(",",$instits);
/*$sWhereDespesa      = " o58_instit in({$instits})";
$rsBalanceteDespesa = db_dotacaosaldo( 8,2,2, true, $sWhereDespesa,
    $anousu,
    $dtini,
    $datafin);
if (pg_num_rows($rsBalanceteDespesa) == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Nenhum registro encontrado, verifique as datas e tente novamente');
}
db_query("drop table if exists anexoivgastopessoaldespesa; create table anexoivgastopessoaldespesa as select * from work_dotacao") or die(pg_last_error());
db_query("drop table if exists work_dotacao");*/

$sWhereReceita      = "o70_instit in ({$instits})";
$rsBalanceteReceita = db_receitasaldo( 3, 1, 3, true,
    $sWhereReceita, $anousu,
    $dtini,
    $datafin );

db_query("drop table if exists anexoivgastopessoalreceita; create table anexoivgastopessoalreceita as select * from work_receita") or die(pg_last_error());
db_query("drop table if exists work_receita");
//db_criatabela(db_query("select * from anexoivgastopessoalreceita"));
//exit;


?>
<html>
<head>

    <style type="text/css">.ritz .waffle a { color: inherit; }.ritz .waffle .s18{border-bottom:1px SOLID #000000;border-right:2px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s15{border-bottom:2px SOLID #000000;background-color:#ffffff;text-align:left;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s6{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#d8d8d8;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s8{border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s20{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#d8d8d8;text-align:right;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s24{border-bottom:2px SOLID #000000;border-right:2px SOLID #000000;background-color:#ffffff;text-align:right;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s9{border-right:1px SOLID #000000;background-color:#ffffff;text-align:right;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s2{border-bottom:2px SOLID #000000;border-right:1px SOLID transparent;background-color:#d8d8d8;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s10{background-color:#ffffff;text-align:left;font-style:italic;color:#000000;font-family:'Calibri',Arial;font-size:8pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s3{border-bottom:2px SOLID #000000;border-right:2px SOLID #000000;background-color:#d8d8d8;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s0{border-bottom:1px SOLID transparent;border-right:2px SOLID #000000;background-color:#d8d8d8;text-align:center;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s11{border-bottom:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s13{border-bottom:1px SOLID #000000;background-color:#ffffff;text-align:left;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s4{border-bottom:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s23{border-bottom:2px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:right;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s12{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:right;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s21{border-bottom:1px SOLID #000000;border-right:2px SOLID #000000;background-color:#d8d8d8;text-align:right;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s14{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:right;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s17{border-bottom:2px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s22{border-bottom:2px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s7{background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s5{border-bottom:1px SOLID #000000;border-right:1px SOLID transparent;background-color:#d8d8d8;text-align:left;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s16{border-bottom:2px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:right;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s1{background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s19{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#d8d8d8;text-align:left;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}</style>
</head>
<body>
<div class="ritz grid-container" dir="ltr">
    <table class="waffle" cellspacing="0" cellpadding="0" style="width: 100%">
        <tbody>
        <tr style='height:20px;'>
            <td class="s0" colspan="2">ANEXO IV</td>

        </tr>
        <tr style='height:20px;'>
            <td class="s0" colspan="2">Demonstrativo dos Gastos com Pessoal</td>

        </tr>
        <tr style='height:20px;'>
            <td class="s0" colspan="2">Incluída a Remuneração dos Agentes Políticos</td>

        </tr>
        <tr style='height:20px;'>
            <td class="s0" colspan="2">(Face ao Disposto pela Lei Complementar nº101, de 04/05/2000)</td>

        </tr>
        <tr style='height:20px;'>
            <td class="s3" colspan="2"></td>


        </tr>
        <tr style='height:20px;'>
            <td class="s4"></td>
            <td class="s4"></td>

        </tr>
        <tr style='height:20px;'>
            <td class="s5">I) DESPESA</td>
            <td class="s6"></td>

        </tr>
        <?php
        /**
         * @todo inicia a despesa por instituição
         * Para cada instit do sql
         */
        $i = 1;
        $fTotalDespesas = 0;
        foreach ($aInstits as $iInstit) {

            $oInstit = new Instituicao($iInstit);

            ?>
            <tr style='height:20px;'>
                <td class="s7"><b>I-<?echo $i; $i++; ?>) DESPESA - <?php echo $oInstit->getDescricao(); ?></b></td>
                <td class="s8"></td>

            </tr>
            <tr style='height:20px;'>
                <td class="s7">3.1.00.00.00 - PESSOAL E ENCARGOS SOCIAIS</td>
                <td class="s8"></td>

            </tr>
            <?php
            $fTotalLiquidado = 0;
            $aDespesas = getSaldoDespesa("331", $oInstit->getCodigo(), 'liquidado');

            foreach($aDespesas as $oDespesa){
                $fTotalLiquidado += $oDespesa->liquidado;
            ?>
            <tr style='height:20px;'>
                <td class="s7 softmerge">
                    <div class="softmerge-inner" style="width: 417px; left: -1px;"><?php echo db_formatar($oDespesa->o58_elemento,"elemento") ." - ". $oDespesa->o56_descr; ?>
                    </div>
                </td>
                <td class="s9"><?php echo db_formatar($oDespesa->liquidado,"f"); ?></td>
                <td class="s10"></td>
            </tr>
            <?php } ?>
            <tr style='height:20px;'>
                <td class="s11">SUB-TOTAL</td>
                <td class="s12"><?php echo db_formatar($fTotalLiquidado,"f"); $fTotalDespesas += $fTotalLiquidado; ?></td>

            </tr>
        <?php } ?>
        <tr style='height:20px;'>
            <td class="s7">TOTAL DAS DESPESAS COM PESSOAL NO MUNICÍPIO</td>
            <td class="s9"><?=db_formatar($fTotalDespesas,"f")?></td>

        </tr>
        <tr style='height:20px;'>
            <td class="s7">(-) Inativos e Pensionistas com Fonte de Custeio Própria</td>
            <td class="s9">
                <?php
                $fSaldoIntaivosPensionistasProprio = 0;
                if($oInstit->getTipoInstit() == Instituicao::TIPO_INSTIT_RPPS) {
                    $aSaldoEstrut1 = getSaldoDespesa("3319001",$oInstit->getCodigo(),"liquidado");
                    $aSaldoEstrut2 = getSaldoDespesa("3319003",$oInstit->getCodigo(),"liquidado");
                    $fSaldoIntaivosPensionistasProprio += $aSaldoEstrut1[0]->liquidado + $aSaldoEstrut2[0]->liquidado;
                }
                echo db_formatar($fSaldoIntaivosPensionistasProprio,"f");
                ?>
            </td>

        </tr>
        <tr style='height:20px;'>
            <td class="s7">(-) Sentenças Judiciais Anteriores</td>
            <td class="s9">
                <?php
                /**
                 * @todo Edição manual
                 */
                $fSaldoSentencasJudAnt = 0;
                echo db_formatar($fSaldoSentencasJudAnt,"f");
                ?>
            </td>

        </tr>
        <tr style='height:20px;'>
            <td class="s11 softmerge">
                <div class="softmerge-inner" style="width: 417px; left: -1px;">(-) Aposentadorias e Pensões Custeadas
                    c/Rec.Fonte Tesouro
                </div>
            </td>
            <td class="s12">
                <?php
                $fSaldoAposentadoriaPensoesTesouro = 0;
                if($oInstit->getTipoInstit() == Instituicao::TIPO_INSTIT_PREFEITURA) {
                    $aSaldoEstrut1 = getSaldoDespesa("3319001",$oInstit->getCodigo(),"liquidado");
                    $aSaldoEstrut2 = getSaldoDespesa("3319003",$oInstit->getCodigo(),"liquidado");
                    $fSaldoAposentadoriaPensoesTesouro += $aSaldoEstrut1[0]->liquidado + $aSaldoEstrut2[0]->liquidado;
                }
                echo db_formatar($fSaldoAposentadoriaPensoesTesouro,"f");
                ?>
            </td>

        </tr>
        <tr style='height:20px;'>
            <td class="s13 softmerge">
                <div class="softmerge-inner" style="width: 417px; left: -1px;">TOTAL DAS DESPESAS COM PESSOAL = BASE DE
                    CÁLCULO
                </div>
            </td>
            <td class="s14"><?php echo db_formatar($fTotalDespesas - ($fSaldoIntaivosPensionistasProprio + $fSaldoSentencasJudAnt + $fSaldoAposentadoriaPensoesTesouro),"f"); ?></td>

        </tr>
        <tr style='height:20px;'>
            <td class="s5">II) RECEITA</td>
            <td class="s6"></td>

        </tr>
        <tr style='height:20px;'>
            <td class="s13">Receita Corrente do Município</td>
            <td class="s14"><?=db_formatar(getRCL($oDataFim),"f")?></td>
            <td class="s10"></td>
        </tr>
        <tr style='height:20px;'>
            <td class="s7">(-) Receita Corrente Intraorçamentária</td>
            <td class="s9"><?php db_formatar(getSaldoReceita("47","saldo_arrecadado"),"f"); ?></td>
            <td class="s10"></td>
        </tr>
        <tr style='height:20px;'>
            <td class="s7 softmerge">
                <div class="softmerge-inner" style="width: 417px; left: -1px;">(-) Contribuição do Servidor Ativo Civil
                    para Regime Próprio
                </div>
            </td>
            <td class="s9">0,00</td>
            <td class="s10"></td>
        </tr>
        <tr style='height:20px;'>
            <td class="s7 softmerge">
                <div class="softmerge-inner" style="width: 417px; left: -1px;">(-) Contribuição do Servidor Inativo
                    Civil para o Regime Próprio
                </div>
            </td>
            <td class="s9">0,00</td>
            <td class="s10"></td>
        </tr>
        <tr style='height:20px;'>
            <td class="s7 softmerge">
                <div class="softmerge-inner" style="width: 417px; left: -1px;">(-) Contribuição do Pensionista Civil
                    para o Regime Próprio
                </div>
            </td>
            <td class="s9">0,00</td>
            <td class="s10"></td>
        </tr>
        <tr style='height:20px;'>
            <td class="s7 softmerge">
                <div class="softmerge-inner" style="width: 417px; left: -1px;">(-) Rec.Rec.Contrib.Servidor Ativo Civil
                    oriunda do Pagto.Sent.JudiciaIs
                </div>
            </td>
            <td class="s9">0,00</td>

        </tr>
        <tr style='height:20px;'>
            <td class="s7 softmerge">
                <div class="softmerge-inner" style="width: 417px; left: -1px;">(-) Rec.Rec.Contrib.Servidor Inativo
                    Civil oriunda do Pagto.Sent.Judiciais
                </div>
            </td>
            <td class="s9">0,00</td>

        </tr>
        <tr style='height:20px;'>
            <td class="s7 softmerge">
                <div class="softmerge-inner" style="width: 417px; left: -1px;">(-) Rec.de Rec.da Contrib.Pensionista sob
                    Pagto.Sent.Judiciais
                </div>
            </td>
            <td class="s9">0,00</td>

        </tr>
        <tr style='height:20px;'>
            <td class="s7">(-) Comp.Financ.entre o RGPS e os RPPS</td>
            <td class="s9">0,00</td>

        </tr>
        <tr style='height:20px;'>
            <td class="s7">(-) Deduções das Receitas (exceto FUNDEB)</td>
            <td class="s8"></td>

        </tr>
        <tr style='height:20px;'>
            <td class="s7">92.1113.05.01 - Restituição ISSQN</td>
            <td class="s9">1.103,13</td>

        </tr>
        <tr style='height:20px;'>
            <td class="s7">92.1722.01.01 - Restituição da Cota Parte do ICMS</td>
            <td class="s9">3.317,89</td>

        </tr>
        <tr style='height:20px;'>
            <td class="s7">92.1922.01.00 - Restituição - Outras Restituições</td>
            <td class="s9">1.439,26</td>

        </tr>
        <tr style='height:20px;'>
            <td class="s7 softmerge">
                <div class="softmerge-inner" style="width: 417px; left: -1px;">99.1722.01.01 - Dedução Transferências
                    Conv. Estado para o SUS
                </div>
            </td>
            <td class="s9">3.807,97</td>

        </tr>
        <tr style='height:20px;'>
            <td class="s7 softmerge">
                <div class="softmerge-inner" style="width: 417px; left: -1px;">99.1762.99.99 - Outras Transferências de
                    Convênios do Estado
                </div>
            </td>
            <td class="s9">3.699,31</td>

        </tr>
        <tr style='height:20px;'>
            <td class="s11">(-) Dedução da Receita para Formação do FUNDEB</td>
            <td class="s12">1.961.205,65</td>

        </tr>
        <tr style='height:20px;'>
            <td class="s15">RECEITA CORRENTE LÍQUIDA = BASE DE CÁLCULO</td>
            <td class="s16">15.917.282,71</td>
            <td class="s17"></td>
        </tr>
        <tr style='height:20px;'>
            <td class="s11">III) PERCENTUAIS MONETÁRIOS DE APLICAÇÃO</td>
            <td class="s4"></td>
            <td class="s18"></td>
        </tr>
        <tr style='height:20px;'>
            <td class="s19">Aplicação no Exercício</td>
            <td class="s20">47,78%</td>
            <td class="s21">7.604.973,01</td>
        </tr>
        <tr style='height:20px;'>
            <td class="s22">Permitido pela Lei Complementar 101/00</td>
            <td class="s23">60,00%</td>
            <td class="s24">9.550.369,63</td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>

<?php

/**
 * Busca o saldo da despesa
 * @param $sEstrut
 * @param $iInstit
 * @param $sCampo [liquidado, empenhado, pago, anulado, ver a tabela anexoivgastopessoaldespesa]
 * @return array|stdClass[]
 */
function getSaldoDespesa($sEstrut, $iInstit,$sCampo = 'liquidado'){
    $sSqlDespesas = "select o58_elemento, o56_descr,sum({$sCampo}) as liquidado from anexoivgastopessoaldespesa inner join orcelemento on o58_codele = o56_codele and o58_anousu = o56_anousu where o58_elemento like '{$sEstrut}%' and o58_instit = {$iInstit} group by 1,2";
    return db_utils::getColectionByRecord(db_query($sSqlDespesas));
}

/**
 * Busca o saldo da receita
 * @param $sEstrut
 * @param string $sCampo
 * @return array|stdClass[]
 */
function getSaldoReceita($sEstrut, $sCampo = 'liquidado'){
    $sSqlDespesas = "select o58_elemento, o56_descr,sum({$sCampo}) as liquidado from anexoivgastopessoalreceita inner join orcelemento on o58_codele = o56_codele and o58_anousu = o56_anousu where o58_elemento like '{$sEstrut}%' group by 1,2";
    return db_utils::getColectionByRecord(db_query($sSqlDespesas));
}

/**
 * Função que retorna a RCL no periodo indicado
 * @param DBDate $oDataFim
 * @return int|number
 * @throws BusinessException
 * @throws ParameterException
 */
function getRCL(DBDate $oDataFim){
    $oPeriodo = new Periodo;
    $oNovaDataFim = clone $oDataFim;
    $oDataFim->modificarIntervalo('-11 month');
    $aPeriodoCalculo = DBDate::getMesesNoIntervalo($oDataFim,$oNovaDataFim);

    $aCalculos = array();

    foreach($aPeriodoCalculo as $ano => $mes){
        $aCalculos[] = calcula_rcl2($ano, $ano. "-" . min(array_keys($aPeriodoCalculo[$ano])) . "-1", $ano."-".max(array_keys($aPeriodoCalculo[$ano]))."-".$oPeriodo->getPeriodoByMes(max(array_keys($aPeriodoCalculo[$ano])))->getDiaFinal(), $instits, true, 81);
    }
    $fSoma = 0;
    foreach($aCalculos as $aCalculo){
        $fSoma += array_sum($aCalculo);
    }
    return $fSoma;
}

?>