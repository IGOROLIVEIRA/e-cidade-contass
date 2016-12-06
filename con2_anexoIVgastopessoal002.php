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

require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
include_once "libs/db_sessoes.php";
include_once "libs/db_usuariosonline.php";
include("vendor/mpdf/mpdf/mpdf.php");
include("libs/db_liborcamento.php");
include("libs/db_libcontabilidade.php");
include("libs/db_sql.php");
require_once("classes/db_consexecucaoorc_classe.php");

db_postmemory($HTTP_POST_VARS);
$oPeriodo = new Periodo($o116_periodo);

$oDataFim = new DBDate("{$anousu}-{$oPeriodo->getMesInicial()}-{$oPeriodo->getDiaFinal()}");
$oDataIni = new DBDate("{$anousu}-{$oPeriodo->getMesInicial()}-{$oPeriodo->getDiaFinal()}");

$iMes = $oDataIni->getMes() != 12 ? ($oDataIni->getMes()-11)+12 : $oDataIni->getMes();//Calcula o mes separado por causa do meses que possuem 31 dias, exceto para o mês de dezembro
$oDataIni->modificarIntervalo("-11 month");//Faço isso apenas para saber o ano
$oDataIni = new DBDate($oDataIni->getAno()."-".$iMes."-".$oPeriodo->getPeriodoByMes($iMes)->getDiaInicial());//Aqui pego o primeiro dia do mes para montar a nova data de inicio
$dtini = $oDataIni->getDate();
$dtfim = $oDataFim->getDate();
$instits = str_replace('-', ', ', $db_selinstit);
$aInstits = explode(",",$instits);

if(count($aInstits) > 1){
  $oInstit = new Instituicao();
  $oInstit = $oInstit->getDadosPrefeitura();
} else {
  foreach ($aInstits as $iInstit) {
    $oInstit = new Instituicao($iInstit);
  }
}
db_inicio_transacao();
$sWhereDespesa      = " o58_instit in({$instits})";
//Aqui passo o(s) exercicio(s) e a funcao faz o sql para cada exercicio
criaWorkDotacao($sWhereDespesa,array_keys(DBDate::getMesesNoIntervalo($oDataIni,$oDataFim)), $dtini, $dtfim);

$sWhereReceita      = "o70_instit in ({$instits})";
//Aqui passo o(s) exercicio(s) e a funcao faz o sql para cada exercicio
criarWorkReceita($sWhereReceita, array_keys(DBDate::getMesesNoIntervalo($oDataIni,$oDataFim)), $dtini, $dtfim);


/**
 * mPDF
 * @param string $mode              | padrão: BLANK
 * @param mixed $format             | padrão: A4
 * @param float $default_font_size  | padrão: 0
 * @param string $default_font      | padrão: ''
 * @param float $margin_left        | padrão: 15
 * @param float $margin_right       | padrão: 15
 * @param float $margin_top         | padrão: 16
 * @param float $margin_bottom      | padrão: 16
 * @param float $margin_header      | padrão: 9
 * @param float $margin_footer      | padrão: 9
 *
 * Nenhum dos parâmetros é obrigatório
 */

$mPDF = new mpdf('', '', 0, '', 15, 15, 23.5, 15, 5, 11);


$header = <<<HEADER
<header>
  <table style="width:100%;text-align:center;font-family:sans-serif;border-bottom:1px solid #000;padding-bottom:6px;">
    <tr>
      <th>{$oInstit->getDescricao()}</th>
    </tr>
    <tr>
      <th>ANEXO IV</th>
    </tr>
    <tr>
      <td style="text-align:right;font-size:10px;font-style:oblique;">Período: De {$oDataIni->getDate("d/m/Y")} a {$oDataFim->getDate("d/m/Y")}</td>
    </tr>
  </table>
</header>
HEADER;

$footer = <<<FOOTER
<div style='border-top:1px solid #000;width:100%;text-align:right;font-family:sans-serif;font-size:10px;height:10px;'>
  {PAGENO}
</div>
FOOTER;


$mPDF->WriteHTML(file_get_contents('estilos/tab_relatorio.css'), 1);
$mPDF->setHTMLHeader(utf8_encode($header), 'O', true);
$mPDF->setHTMLFooter(utf8_encode($footer), 'O', true);

ob_start();

?>

<html>
<head>
<style type="text/css">
.ritz .waffle a { color : inherit; }
.ritz .waffle .s1 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 0px 3px 0px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s2 { background-color : #ffffff; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 0px 3px 0px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s4 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 0px 3px 0px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s3 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 0px 3px 0px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s10 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 0px 3px 0px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s6 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 0px 3px 0px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s7 { background-color : #ffffff; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 0px 3px 0px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s8 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 0px 3px 0px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s5 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 0px 3px 0px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s0 { background-color : #d8d8d8; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 0px 3px 0px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s9 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 0px 3px 0px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
.column-headers-background { background-color: #d8d8d8; }
</style>
</head>
<body>
  <div class="ritz grid-container" dir="ltr">
    <table class="waffle" cellspacing="0" cellpadding="0">
      <tbody>
      <tr>
        <th id="1606692746C0" style="width:463px" class="bdtop column-headers-background">&nbsp;</th>
        <th id="1606692746C1" style="width:92px" class="bdtop column-headers-background">&nbsp;</th>
        <th id="1606692746C2" style="width:106px" class="bdtop column-headers-background">&nbsp;</th>
      </tr>
      <tr style='height:19px;'>
        <td class="s0 bdleft" colspan="3">ANEXO IV</td>
      </tr>
      <tr style='height:19px;'>
        <td class="s0 bdleft" colspan="3">Demonstrativo dos Gastos com Pessoal</td>
      </tr>
      <tr style='height:19px;'>
        <td class="s0 bdleft" colspan="3">Incluída a Remuneração dos Agentes Políticos</td>
      </tr>
      <tr style='height:19px;'>
        <td class="s0 bdleft" colspan="3">(Face ao Disposto pela Lei Complementar nº101, de 04/05/2000)</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s1 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:19px;'>
        <td class="s2" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:19px;'>
        <td class="s1 bdleft" colspan="3">I) DESPESA</td>
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
        <tr style='height:19px;'>
          <td class="s3 bdleft" colspan="2">I-<?= $i++; ?>) DESPESA - <?php echo $oInstit->getDescricao(); ?></td>
          <td class="s4"></td>
        </tr>
  
        <tr style='height:19px;'>
          <td class="s3 bdleft" colspan="2">3.1.00.00.00 - PESSOAL E ENCARGOS SOCIAIS</td>
          <td class="s4"></td>
        </tr>
  
        <?php
        $fTotalLiquidado = 0;
        $aDespesas = getSaldoDespesa(null,"o58_elemento, o56_descr,sum(liquidado) as liquidado",null,"o58_elemento like '331%' and o58_instit = {$oInstit->getCodigo()} group by 1,2");
        foreach($aDespesas as $oDespesa){
          $fTotalLiquidado += $oDespesa->liquidado;
          if($oDespesa->o58_elemento == '3317170000000'){
            $oDespesa->liquidado = getConsolidacaoConsorcios($oDataIni,$oDataFim) == 0 ? $oDespesa->liquidado : getConsolidacaoConsorcios($oDataIni,$oDataFim);
          }
          ?>
          <tr style='height:19px;'>
            <td class="s3 bdleft" colspan="2">
              <?php echo db_formatar($oDespesa->o58_elemento,"elemento") ." - ". $oDespesa->o56_descr; ?>
            </td>
            <td class="s5">
              <?php echo db_formatar($oDespesa->liquidado,"f"); ?>
            </td>
          </tr>
        <?php } ?>
        <tr style='height:19px;'>
          <td class="s2 bdleft bdtop" colspan="2">SUB-TOTAL</td>
          <td class="s6 bdtop">
            <?php echo db_formatar($fTotalLiquidado,"f"); $fTotalDespesas += $fTotalLiquidado; ?>
          </td>
        </tr>
      <?php } ?>

      <tr style='height:19px;'>
        <td class="s3 bdleft" colspan="2">TOTAL DAS DESPESAS COM PESSOAL NO MUNICÍPIO</td>
        <td class="s5"><?= db_formatar($fTotalDespesas,"f") ?></td>
      </tr>

      <tr style='height:19px;'>
        <td class="s3 bdleft" colspan="2">(-) Inativos e Pensionistas com Fonte de Custeio Própria</td>
        <td class="s5">
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

      <tr style='height:19px;'>
        <td class="s3 bdleft" colspan="2">(-) Sentenças Judiciais Anteriores</td>
        <td class="s5">
          <?php
          /**
           * @todo Edição manual
           */
          $fSaldoSentencasJudAnt = 0;
          echo db_formatar($fSaldoSentencasJudAnt,"f");
          ?>
        </td>
      </tr>

      <tr style='height:19px;'>
        <td class="s2 bdleft" colspan="2">(-) Aposentadorias e Pensões Custeadas c/Rec.Fonte Tesouro</td>
        <td class="s6">
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

      <tr style='height:19px;'>
        <td class="s7 bdleft" colspan="2">TOTAL DAS DESPESAS COM PESSOAL = BASE DE CÁLCULO </td>
        <td class="s8">
          <?php
          $fTotalDespesaPessoal = $fTotalDespesas - ($fSaldoIntaivosPensionistasProprio + $fSaldoSentencasJudAnt + $fSaldoAposentadoriaPensoesTesouro);
          echo db_formatar($fTotalDespesaPessoal,"f");
          ?>
        </td>
      </tr>

      <tr style='height:19px;'>
        <td class="s1 bdleft" colspan="3">II) RECEITA</td>
      </tr>

      <tr style='height:19px;'>
        <td class="s7 bdleft" colspan="2">Receita Corrente do Município</td>
        <td class="s8">
          <?php $fRCL = getRCL($oDataFim,$instits); echo db_formatar($fRCL,"f"); ?>
        </td>
      </tr>

      <tr style='height:19px;'>
        <td class="s3 bdleft" colspan="2">(-) Receita Corrente Intraorçamentária</td>
        <td class="s5">
          <?php
          $aDadosRCI = getSaldoReceita(null,"sum(saldo_arrecadado) as saldo_arrecadado",null,"o57_fonte like '47%'");
          $fRCI = count($aDadosRCI) > 0 ? $aDadosRCI[0]->saldo_arrecadado : 0;
          echo db_formatar($fRCI, "f");
          ?>
        </td>
      </tr>

      <tr style='height:19px;'>
        <td class="s3 bdleft" colspan="2">(-) Contribuição do Servidor Ativo Civil para Regime Próprio</td>
        <td class="s5">
          <?php
          $aDadosCSACRPPS = getSaldoReceita(null,"sum(saldo_arrecadado) as saldo_arrecadado",null,"o57_fonte like '412102907%'");
          $fCSACRPPS = count($aDadosCSACRPPS) > 0 ? $aDadosCSACRPPS[0]->saldo_arrecadado : 0;
          echo db_formatar($fCSACRPPS,"f");
          ?>
        </td>
      </tr>

      <tr style='height:19px;'>
        <td class="s3 bdleft" colspan="2">(-) Contribuição do Servidor Inativo Civil para o Regime Próprio </td>
        <td class="s5">
          <?php
          $aDadosCSICRPPS = getSaldoReceita(null,"sum(saldo_arrecadado) as saldo_arrecadado",null,"o57_fonte like '412102909%'");
          $fCSICRPPS = count($aDadosCSICRPPS) > 0 ? $aDadosCSICRPPS[0]->saldo_arrecadado : 0;
          echo db_formatar($fCSICRPPS,"f");
          ?>
        </td>
      </tr>

      <tr style='height:19px;'>
        <td class="s3 bdleft" colspan="2">(-) Contribuição do Pensionista Civil para o Regime Próprio</td>
        <td class="s5">
          <?php
          $aDadosCPRPPS = getSaldoReceita(null,"sum(saldo_arrecadado) as saldo_arrecadado",null,"o57_fonte like '412102911%'");
          $fCPRPPS = count($aDadosCPRPPS) > 0 ? $aDadosCPRPPS[0]->saldo_arrecadado : 0;
          echo db_formatar($fCPRPPS,"f");
          ?>
        </td>
      </tr>

      <tr style='height:19px;'>
        <td class="s3 bdleft" colspan="2">(-) Rec.Rec.Contrib.Servidor Ativo Civil oriunda do Pagto.Sent.JudiciaIs</td>
        <td class="s5">
          <?php
          $aDadosRRCSACOPSJ = getSaldoReceita(null,"sum(saldo_arrecadado) as saldo_arrecadado",null,"o57_fonte like '412102917%'");
          $fRRCSACOPSJ = count($aDadosRRCSACOPSJ) > 0 ? $aDadosRRCSACOPSJ[0]->saldo_arrecadado : 0;
          echo db_formatar($fRRCSACOPSJ,"f");
          ?>
        </td>
      </tr>

      <tr style='height:19px;'>
        <td class="s3 bdleft" colspan="2">(-) Rec.Rec.Contrib.Servidor Inativo Civil oriunda do Pagto.Sent.Judiciais</td>
        <td class="s5">
          <?php
          $aDadosRRCSICOPSJ = getSaldoReceita(null,"sum(saldo_arrecadado) as saldo_arrecadado",null,"o57_fonte like '412102918%'");
          $fRRCSICOPSJ = count($aDadosRRCSICOPSJ) > 0 ? $aDadosRRCSICOPSJ[0]->saldo_arrecadado : 0;
          echo db_formatar($fRRCSICOPSJ,"f");
          ?>
        </td>
      </tr>

      <tr style='height:19px;'>
        <td class="s3 bdleft" colspan="2">(-) Rec.de Rec.da Contrib.Pensionista sob Pagto.Sent.Judiciais</td>
        <td class="s5">
          <?php
          $aDadosRRCPPSJ = getSaldoReceita(null,"sum(saldo_arrecadado) as saldo_arrecadado",null,"o57_fonte like '412102919%'");
          $fRRCPPSJ = count($aDadosRRCPPSJ) > 0 ? $aDadosRRCPPSJ->saldo_arrecadado : 0;
          echo db_formatar($fRRCPPSJ,"f");
          ?>
        </td>
      </tr>

      <tr style='height:19px;'>
        <td class="s3 bdleft" colspan="2">(-) Comp.Financ.entre o RGPS e os RPPS</td>
        <td class="s5">
          <?php
          $aDadosCFRP = getSaldoReceita(null,"sum(saldo_arrecadado) as saldo_arrecadado",null,"o57_fonte like '4192210%'");
          $fCFRP = count($aDadosCFRP) > 0 ? $aDadosCFRP[0]->saldo_arrecadado : 0;
          echo db_formatar($fCFRP,"f");
          ?>
        </td>
      </tr>
      <?php
      $fTotalDeducoes = 0;
      $aDadoDeducao = getSaldoReceita(null,"o57_fonte,o57_descr,saldo_arrecadado",null,"o57_fonte like '492%'");
      foreach($aDadoDeducao as $oDeducao){
        ?>
        <tr style='height:19px;'>
          <td class="s3 bdleft" colspan="2">
            <?php echo db_formatar($oDespesa->o57_fonte,"receita")." - ".$oDespesa->o57_descr; ?>
          </td>
          <td class="s5">
            <?php
            $fTotalDeducoes += $oDespesa->saldo_arrecadado;
            echo db_formatar($oDespesa->saldo_arrecadado,"f");
            ?>
          </td>
        </tr>
      <?php }

      $aDadoDeducao = getSaldoReceita(null,"o57_fonte,o57_descr,saldo_arrecadado",null,"o57_fonte like '499%'");
      foreach($aDadoDeducao as $oDeducao){ ?>
        <tr style='height:19px;'>
          <td class="s3 bdleft" colspan="2">
            <?php echo db_formatar($oDespesa->o57_fonte,"receita")." - ".$oDespesa->o57_descr; ?>
          </td>
          <td class="s5">
            <?php
            $fTotalDeducoes += $oDespesa->saldo_arrecadado;
            echo db_formatar($oDespesa->saldo_arrecadado,"f");
            ?>
          </td>
        </tr>
      <?php } ?>

      <tr style='height:20px;'>
        <td class="s7 bdleft" colspan="2">RECEITA CORRENTE LÍQUIDA = BASE DE CÁLCULO</td>
        <td class="s8">
          <?php
          $fRCLBase = $fRCL-(array_sum(array($fRCI,$fCSACRPPS,$fCSICRPPS,$fCPRPPS,$fRRCSACOPSJ,$fRRCSICOPSJ,$fRRCPPSJ,$fCFRP,$fTotalDeducoes)));
          echo db_formatar($fRCLBase,"f");
          ?>
        </td>
      </tr>

      <tr style='height:19px;'>
        <td class="s9 bdleft" colspan="3">III) PERCENTUAIS MONETÁRIOS DE APLICAÇÃO</td>
      </tr>


      <tr style='height:19px;'>
        <td class="s1 bdleft">Aplicação no Exercício </td>
        <td class="s10"><?php echo db_formatar(($fTotalDespesaPessoal/$fRCLBase)*100,"f"); ?>%</td>
        <td class="s10"><?php echo db_formatar($fTotalDespesaPessoal,"f") ?></td>
      </tr>

      <tr style='height:20px;'>
        <td class="s9 bdleft">Permitido pela Lei Complementar 101/00</td>
        <td class="s6">60.00%</td>
        <td class="s6"><?php echo db_formatar($fRCLBase*0.6,"f") ?></td>
      </tr>
      </tbody>
    </table>
  </div>
</body>
</html>

<?php

$html = ob_get_contents();
ob_end_clean();

$mPDF->WriteHTML(utf8_encode($html));
$mPDF->Output();

/* ---- */

db_query("drop table if exists work_dotacao");
db_query("drop table if exists work_receita");

db_fim_transacao();

/**
 * Busca os valores informados na consolidação de consórcios (Contabilidade->Procedimentos->Consolidação de Consórcios)
 * @param DBDate $oDataIni
 * @param DBDate $oDataFim
 * @return int
 * @throws ParameterException
 */
function getConsolidacaoConsorcios(DBDate $oDataIni, DBDate $oDataFim){
  $oConsexecucaoorc = new cl_consexecucaoorc();
  $aPeriodo = DBDate::getMesesNoIntervalo($oDataIni,$oDataFim);
  $fTotal = 0;
  foreach($aPeriodo as $ano => $mes){
    $sSql = $oConsexecucaoorc->sql_query_file(null,"sum(coalesce(c202_valorliquidado,0)) as c202_valorliquidado",null,"c202_anousu = ".$ano." and c202_mescompetencia in (".implode(',',array_keys($mes)).")");
    $fTotal += db_utils::fieldsMemory(db_query($sSql), 0)->c202_valorliquidado;

  }

  return $fTotal;
}

?>