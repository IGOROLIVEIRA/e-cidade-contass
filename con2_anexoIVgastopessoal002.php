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

db_inicio_transacao();
$sWhereDespesa      = " o58_instit in({$instits})";
$rsBalanceteDespesa = db_dotacaosaldo( 8,2,2, true, $sWhereDespesa,
    $anousu,
    $dtini,
    $datafin);
if (pg_num_rows($rsBalanceteDespesa) == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Nenhum registro encontrado, verifique as datas e tente novamente');
}

$sWhereReceita      = "o70_instit in ({$instits})";
$rsBalanceteReceita = db_receitasaldo( 3, 1, 3, true,
    $sWhereReceita, $anousu,
    $dtini,
    $datafin );


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
            $aDespesas = getSaldoDespesa(null,"o58_elemento, o56_descr,sum(liquidado) as liquidado",null,"o58_elemento like '331%' and o58_instit = {$oInstit->getCodigo()} group by 1,2");
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
                    $aSaldoEstrut1 = getSaldoDespesa(null,"o58_elemento, o56_descr,sum(liquidado) as liquidado",null,"o58_elemento like '3319001%' and o58_instit = {$oInstit->getCodigo()} group by 1,2");
                    $aSaldoEstrut2 = getSaldoDespesa(null,"o58_elemento, o56_descr,sum(liquidado) as liquidado",null,"o58_elemento like '3319003%' and o58_instit = {$oInstit->getCodigo()} group by 1,2");
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
                    $aSaldoEstrut1 = getSaldoDespesa(null,"o58_elemento, o56_descr,sum(liquidado) as liquidado",null,"o58_elemento like '3319001%' and o58_instit = {$oInstit->getCodigo()} group by 1,2");
                    $aSaldoEstrut2 = getSaldoDespesa(null,"o58_elemento, o56_descr,sum(liquidado) as liquidado",null,"o58_elemento like '3319003%' and o58_instit = {$oInstit->getCodigo()} group by 1,2");
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
            <td class="s14">
                <?php
                $fTotalDespesaPessoal = $fTotalDespesas - ($fSaldoIntaivosPensionistasProprio + $fSaldoSentencasJudAnt + $fSaldoAposentadoriaPensoesTesouro);
                echo db_formatar($fTotalDespesaPessoal,"f");
                ?>
            </td>

        </tr>
        <tr style='height:20px;'>
            <td class="s5">II) RECEITA</td>
            <td class="s6"></td>

        </tr>
        <tr style='height:20px;'>
            <td class="s13">Receita Corrente do Município</td>
            <td class="s14"><?php $fRCL = getRCL($oDataFim,$instits); echo db_formatar($fRCL,"f");  ?></td>
            <td class="s10"></td>
        </tr>
        <tr style='height:20px;'>
            <td class="s7">(-) Receita Corrente Intraorçamentária</td>
            <td class="s9">
                <?php
                $aDadosRCI = getSaldoReceita(null,"sum(saldo_arrecadado) as saldo_arrecadado",null,"o57_fonte like '47%'");
                $fRCI = count($aDadosRCI) > 0 ? $aDadosRCI[0]->saldo_arrecadado : 0;
                echo db_formatar($fRCI, "f");

                ?></td>
            <td class="s10"></td>
        </tr>
        <tr style='height:20px;'>
            <td class="s7 softmerge">
                <div class="softmerge-inner" style="width: 417px; left: -1px;">(-) Contribuição do Servidor Ativo Civil
                    para Regime Próprio
                </div>
            </td>
            <td class="s9">
                <?php
                $aDadosCSACRPPS = getSaldoReceita(null,"sum(saldo_arrecadado) as saldo_arrecadado",null,"o57_fonte like '412102907%'");
                $fCSACRPPS = count($aDadosCSACRPPS) > 0 ? $aDadosCSACRPPS[0]->saldo_arrecadado : 0;
                echo db_formatar($fCSACRPPS,"f");
                ?>
            </td>
            <td class="s10"></td>
        </tr>
        <tr style='height:20px;'>
            <td class="s7 softmerge">
                <div class="softmerge-inner" style="width: 417px; left: -1px;">(-) Contribuição do Servidor Inativo
                    Civil para o Regime Próprio
                </div>
            </td>
            <td class="s9">
                <?php
                $aDadosCSICRPPS = getSaldoReceita(null,"sum(saldo_arrecadado) as saldo_arrecadado",null,"o57_fonte like '412102909%'");
                $fCSICRPPS = count($aDadosCSICRPPS) > 0 ? $aDadosCSICRPPS[0]->saldo_arrecadado : 0;
                echo db_formatar($fCSICRPPS,"f");

                ?>
            </td>
            <td class="s10"></td>
        </tr>
        <tr style='height:20px;'>
            <td class="s7 softmerge">
                <div class="softmerge-inner" style="width: 417px; left: -1px;">(-) Contribuição do Pensionista Civil
                    para o Regime Próprio
                </div>
            </td>
            <td class="s9">
                <?php
                $aDadosCPRPPS = getSaldoReceita(null,"sum(saldo_arrecadado) as saldo_arrecadado",null,"o57_fonte like '412102911%'");
                $fCPRPPS = count($aDadosCPRPPS) > 0 ? $aDadosCPRPPS[0]->saldo_arrecadado : 0;
                echo db_formatar($fCPRPPS,"f");
                ?>
            </td>
            <td class="s10"></td>
        </tr>
        <tr style='height:20px;'>
            <td class="s7 softmerge">
                <div class="softmerge-inner" style="width: 417px; left: -1px;">(-) Rec.Rec.Contrib.Servidor Ativo Civil
                    oriunda do Pagto.Sent.JudiciaIs
                </div>
            </td>
            <td class="s9">
                <?php
                $aDadosRRCSACOPSJ = getSaldoReceita(null,"sum(saldo_arrecadado) as saldo_arrecadado",null,"o57_fonte like '412102917%'");
                $fRRCSACOPSJ = count($aDadosRRCSACOPSJ) > 0 ? $aDadosRRCSACOPSJ[0]->saldo_arrecadado : 0;
                echo db_formatar($fRRCSACOPSJ,"f");
                ?>
            </td>

        </tr>
        <tr style='height:20px;'>
            <td class="s7 softmerge">
                <div class="softmerge-inner" style="width: 417px; left: -1px;">(-) Rec.Rec.Contrib.Servidor Inativo
                    Civil oriunda do Pagto.Sent.Judiciais
                </div>
            </td>
            <td class="s9">
                <?php
                $aDadosRRCSICOPSJ = getSaldoReceita(null,"sum(saldo_arrecadado) as saldo_arrecadado",null,"o57_fonte like '412102918%'");
                $fRRCSICOPSJ = count($aDadosRRCSICOPSJ) > 0 ? $aDadosRRCSICOPSJ[0]->saldo_arrecadado : 0;
                echo db_formatar($fRRCSICOPSJ,"f");
                ?>
            </td>

        </tr>
        <tr style='height:20px;'>
            <td class="s7 softmerge">
                <div class="softmerge-inner" style="width: 417px; left: -1px;">(-) Rec.de Rec.da Contrib.Pensionista sob
                    Pagto.Sent.Judiciais
                </div>
            </td>
            <td class="s9">
                <?php
                $aDadosRRCPPSJ = getSaldoReceita(null,"sum(saldo_arrecadado) as saldo_arrecadado",null,"o57_fonte like '412102919%'");
                $fRRCPPSJ = count($aDadosRRCPPSJ) > 0 ? $aDadosRRCPPSJ->saldo_arrecadado : 0;
                echo db_formatar($fRRCPPSJ,"f");
                ?>
            </td>

        </tr>
        <tr style='height:20px;'>
            <td class="s7">(-) Comp.Financ.entre o RGPS e os RPPS</td>
            <td class="s9">
                <?php
                $aDadosCFRP = getSaldoReceita(null,"sum(saldo_arrecadado) as saldo_arrecadado",null,"o57_fonte like '4192210%'");
                $fCFRP = count($aDadosCFRP) > 0 ? $aDadosCFRP[0]->saldo_arrecadado : 0;
                echo db_formatar($fCFRP,"f");
                ?>
            </td>

        </tr>
        <tr style='height:20px;'>
            <td class="s7">(-) Deduções das Receitas (exceto FUNDEB)</td>
            <td class="s8"></td>

        </tr>
        <?php
        $fTotalDeducoes = 0;
        $aDadoDeducao = getSaldoReceita(null,"o57_fonte,o57_descr,saldo_arrecadado",null,"o57_fonte like '492%'");
        foreach($aDadoDeducao as $oDeducao){
        ?>
        <tr style='height:20px;'>
            <td class="s7"><?php echo db_formatar($oDeducao->o57_fonte,"receita")." - ".$oDeducao->o57_descr; ?></td>
            <td class="s9">
                <?php
                $fTotalDeducoes += $oDeducao->saldo_arrecadado;
                echo db_formatar($oDeducao->saldo_arrecadado,"f");
                ?>
            </td>

        </tr>
        <?php }

        $aDadoDeducao = getSaldoReceita(null,"o57_fonte,o57_descr,saldo_arrecadado",null,"o57_fonte like '499%'");
        foreach($aDadoDeducao as $oDeducao){


        ?>
        <tr style='height:20px;'>
            <td class="s7"><?php echo db_formatar($oDeducao->o57_fonte,"receita")." - ".$oDeducao->o57_descr; ?></td>
            <td class="s9">
                <?php
                $fTotalDeducoes += $oDeducao->saldo_arrecadado;
                echo db_formatar($oDeducao->saldo_arrecadado,"f");
                ?>
            </td>

        </tr>
        <?php }?>
        <tr style='height:20px;'>
            <td class="s15">RECEITA CORRENTE LÍQUIDA = BASE DE CÁLCULO</td>
            <td class="s16">
                <?php
                $fRCLBase = $fRCL-(array_sum(array($fRCI,$fCSACRPPS,$fCSICRPPS,$fCPRPPS,$fRRCSACOPSJ,$fRRCSICOPSJ,$fRRCPPSJ,$fCFRP,$fTotalDeducoes)));
                echo db_formatar($fRCLBase,"f");
                ?>
            </td>
            <td class="s17"></td>
        </tr>
        <tr style='height:20px;'>
            <td class="s11">III) PERCENTUAIS MONETÁRIOS DE APLICAÇÃO</td>
            <td class="s4"></td>
            <td class="s18"></td>
        </tr>
        <tr style='height:20px;'>
            <td class="s19">Aplicação no Exercício</td>
            <td class="s20"><?php echo db_formatar(($fTotalDespesaPessoal/$fRCLBase)*100,"f"); ?>%</td>
            <td class="s21"><?php echo db_formatar($fTotalDespesaPessoal,"f") ?></td>
        </tr>
        <tr style='height:20px;'>
            <td class="s22">Permitido pela Lei Complementar 101/00</td>
            <td class="s23">60,00%</td>
            <td class="s24"><?php echo db_formatar($fRCLBase*0.6,"f") ?></td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>

<?php

db_query("drop table if exists work_dotacao");
db_query("drop table if exists work_receita");

db_fim_transacao();

?>