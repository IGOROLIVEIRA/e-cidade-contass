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
require_once("classes/db_infocomplementaresinstit_classe.php");

db_postmemory($HTTP_POST_VARS);
$oPeriodo = new Periodo($o116_periodo);
$clinfocomplementaresinstit = new cl_infocomplementaresinstit();

$oDataFim = new DBDate("{$anousu}-{$oPeriodo->getMesInicial()}-{$oPeriodo->getDiaFinal()}");
$oDataIni = new DBDate("{$anousu}-{$oPeriodo->getMesInicial()}-{$oPeriodo->getDiaFinal()}");

$iMes = $oDataIni->getMes() != 12 ? ($oDataIni->getMes() - 11) + 12 : $oDataIni->getMes() - 11;//Calcula o mes separado por causa do meses que possuem 31 dias
$oDataIni->modificarIntervalo("-11 month");//Faço isso apenas para saber o ano
$oDataIni = new DBDate($oDataIni->getAno() . "-" . $iMes . "-1");//Aqui pego o primeiro dia do mes para montar a nova data de inicio
$dtini = $oDataIni->getDate();
$dtfim = $oDataFim->getDate();
$instits = str_replace('-', ', ', $db_selinstit);
$aInstits = explode(",", $instits);
$soma=0;
if (count($aInstits) > 1) {
    $oInstit = new Instituicao();
    $oInstit = $oInstit->getDadosPrefeitura();
} else {
    foreach ($aInstits as $iInstit) {
        $oInstit = new Instituicao($iInstit);
    }
}
/**
 * pego todas as instituições OC10823;
 */
$rsInstits = $clinfocomplementaresinstit->sql_record($clinfocomplementaresinstit->sql_query(null,"si09_instit,si09_tipoinstit",null,null));

$ainstitunticoes = array();
for($i=0; $i < pg_num_rows($rsInstits); $i++){
    $odadosInstint = db_utils::fieldsMemory($rsInstits,$i);
    $ainstitunticoes[]= $odadosInstint->si09_instit;
}
$iInstituicoes = implode(',',$ainstitunticoes);

$rsTipoinstit = $clinfocomplementaresinstit->sql_record($clinfocomplementaresinstit->sql_query(null,"si09_sequencial,si09_tipoinstit",null,"si09_instit in( {$instits})"));

/**
 * busco o tipo de instituicao
 */
$ainstitunticoes = array();
$aTipoistituicao = array();

for($i=0; $i < pg_num_rows($rsTipoinstit); $i++){
    $odadosInstint = db_utils::fieldsMemory($rsTipoinstit,$i);
    $aTipoistituicao[]= $odadosInstint->si09_tipoinstit;
    $iCont = pg_num_rows($rsTipoinstit);
}

/**
 * Verifico institu para retornar o percentual Permitido pela Lei Complementar
 */
$iVerifica = null;

if($iCont == 1 && in_array("1",$aTipoistituicao)){
    $iVerifica = 1;
} elseif ($iCont >= 1 && !(in_array("1",$aTipoistituicao ))){
    $iVerifica = 2;
}else{
    $iVerifica = 3;
}

db_inicio_transacao();
function getDespesasReceitas($iInstituicoes,$dtini,$dtfim){
    $fTotalarrecadado=0;
    $fCSACRPPS=0;//412102907
    $fCSICRPPS=0;//412102909
    $fCPRPPS=0;//412102911
    $fRRCSACOPSJ=0;//412102917
    $fRRCSICOPSJ=0;//412102918
    $fRRCPPSJ=0;//412102919
    $fCFRP=0;//4192210

    $db_filtro = " o70_instit in({$iInstituicoes}) ";
    $anousu = db_getsession("DB_anousu");
    $anousu_aux = $anousu-1;
    $dtfim_aux  = $anousu_aux.'-12-31';

    // DADOS DA RECEITA NO ANO ANTERIOR
    $oUltimoano = db_receitasaldo(11,1,3,true,$db_filtro,$anousu-1,$dtini,$dtfim_aux,false,' * ',true,0);

    $oUltimoano = db_utils::getColectionByRecord($oUltimoano);
    foreach ($oUltimoano as $oDados) {
        if($oDados->o57_fonte == "410000000000000"){
            $fTotalarrecadado+=$oDados->saldo_arrecadado;
        }
        if($oDados->o57_fonte == "470000000000000"){
            $fTotalarrecadado+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "491000000000000"){
            $fCSACRPPS+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "495000000000000"){
            $fCSICRPPS+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "470000000000000"){
            $fCPRPPS+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "419900300000000"){
            $fRRCSICOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412102919000000"){
            $fRRCPPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "417180800000000"){
            $fCFRP+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "492000000000000"){
            $fCSACRPPS+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "493000000000000"){
            $fCSACRPPS+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "496000000000000"){
            $fCSACRPPS+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "498000000000000"){
            $fCSACRPPS+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "499000000000000"){
            $fCSACRPPS+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412180100000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412180200000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100421000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100422000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100423000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100424000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100431000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100432000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100433000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100434000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100441000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100442000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100443000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100444000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100461000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100462000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100463000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100464000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100471000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100472000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100473000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100474000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100481000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100482000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100483000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100484000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100481000000"){
            $fRRCPPSJ+=$oDados->saldo_arrecadado;
        }

    }
    db_query("drop table if exists work_receita");

    // DADOS DA RECEITA NO ANO ATUAL

    $dtini_aux = $anousu.'-01-01';
    $oAnoatual = db_receitasaldo(11,1,3,true,$db_filtro,$anousu,$dtini_aux,$dtfim,false,' * ',true,0);
    $oAnoatual = db_utils::getColectionByRecord($oAnoatual);
    foreach ($oAnoatual as $oDados) {
        if($oDados->o57_fonte == "410000000000000"){
            $fTotalarrecadado+=$oDados->saldo_arrecadado;
        }
        if($oDados->o57_fonte == "470000000000000"){
            $fTotalarrecadado+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "491000000000000"){
            $fCSACRPPS+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "492000000000000"){
            $fCSACRPPS+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "493000000000000"){
            $fCSACRPPS+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "496000000000000"){
            $fCSACRPPS+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "498000000000000"){
            $fCSACRPPS+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "499000000000000"){
            $fCSACRPPS+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "495000000000000"){
            $fCSICRPPS+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "470000000000000"){
            $fCPRPPS+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412180100000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412180200000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100421000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100422000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100423000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100424000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100431000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100432000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100433000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100434000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100441000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100442000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100443000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100444000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100461000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100462000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100463000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100464000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100471000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100472000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100473000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100474000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100481000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100482000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100483000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100484000000"){
            $fRRCSACOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "419900300000000"){
            $fRRCSICOPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412100481000000"){
            $fRRCPPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412180161000000"){
            $fRRCPPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "412180261000000"){
            $fRRCPPSJ+=$oDados->saldo_arrecadado;
        }

        if($oDados->o57_fonte == "417180800000000"){
            $fCFRP+=$oDados->saldo_arrecadado;
        }

    }
    db_query("drop table if exists work_receita");

    return array(
        'fTotalReceitasArrecadadas' => $fTotalarrecadado,
        'fCSACRPPS' => $fCSACRPPS,
        'fCSICRPPS' => $fCSICRPPS,
        'fCPRPPS' => $fCPRPPS,
        'fRRCSACOPSJ' => $fRRCSACOPSJ,
        'fRRCSICOPSJ' => $fRRCSICOPSJ,
        'fRRCPPSJ' => $fRRCPPSJ,
        'fCFRP' => $fCFRP,
    );
}

$aDespesasReceitas = getDespesasReceitas($iInstituicoes,$dtini,$dtfim);

$fTotalReceitasArrecadadas = $aDespesasReceitas['fTotalReceitasArrecadadas'];
$fCSACRPPS = $aDespesasReceitas['fCSACRPPS'];
$fCSICRPPS = $aDespesasReceitas['fCSICRPPS'];
$fCPRPPS = $aDespesasReceitas['fCPRPPS'];
$fRRCSACOPSJ = $aDespesasReceitas['fRRCSACOPSJ'];
$fRRCSICOPSJ = $aDespesasReceitas['fRRCSICOPSJ'];
$fRRCPPSJ = $aDespesasReceitas['fRRCPPSJ'];
$fCFRP = $aDespesasReceitas['fCFRP'];

$sWhereDespesa = " o58_instit in({$instits})";
//Aqui passo o(s) exercicio(s) e a funcao faz o sql para cada exercicio
criaWorkDotacao($sWhereDespesa, array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $dtini, $dtfim);

$sWhereReceita = "o70_instit in ({$iInstituicoes})";
//Aqui passo o(s) exercicio(s) e a funcao faz o sql para cada exercicio
criarWorkReceita($sWhereReceita, array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $dtini, $dtfim);


/**
 * mPDF
 * @param string $mode | padrão: BLANK
 * @param mixed $format | padrão: A4
 * @param float $default_font_size | padrão: 0
 * @param string $default_font | padrão: ''
 * @param float $margin_left | padrão: 15
 * @param float $margin_right | padrão: 15
 * @param float $margin_top | padrão: 16
 * @param float $margin_bottom | padrão: 16
 * @param float $margin_header | padrão: 9
 * @param float $margin_footer | padrão: 9
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
        .ritz .waffle a { color: inherit; }
        .ritz .waffle .s1 { background-color: #d8d8d8; border-bottom: 1px SOLID #000000; border-right: 1px SOLID #000000; color: #000000; direction: ltr; font-family: 'Calibri', Arial; font-size: 11pt; font-weight: bold; padding: 0px 3px 0px 3px; text-align: left; vertical-align: bottom; white-space: nowrap; }
        .ritz .waffle .s2 {background-color: #ffffff; border-bottom: 1px SOLID #000000; color: #000000; direction: ltr; font-family: 'Calibri', Arial; font-size: 11pt; padding: 0px 3px 0px 3px; text-align: left; vertical-align: bottom; white-space: nowrap; }
        .ritz .waffle .s4 { background-color: #ffffff; border-right: 1px SOLID #000000; color: #000000; direction: ltr; font-family: 'Calibri', Arial; font-size: 11pt; padding: 0px 3px 0px 3px; text-align: left; vertical-align: bottom; white-space: nowrap; }
        .ritz .waffle .s3 { background-color: #ffffff; color: #000000; direction: ltr; font-family: 'Calibri', Arial; font-size: 11pt; padding: 0px 3px 0px 3px; text-align: left; vertical-align: bottom; white-space: nowrap; }
        .ritz .waffle .s10 { background-color: #d8d8d8; border-bottom: 1px SOLID #000000; border-right: 1px SOLID #000000; color: #000000; direction: ltr; font-family: 'Calibri', Arial; font-size: 11pt; font-weight: bold; padding: 0px 3px 0px 3px; text-align: right; vertical-align: bottom; white-space: nowrap; }
        .ritz .waffle .s6 { background-color: #ffffff; border-bottom: 1px SOLID #000000; border-right: 1px SOLID #000000; color: #000000; direction: ltr; font-family: 'Calibri', Arial; font-size: 11pt; padding: 0px 3px 0px 3px; text-align: right; vertical-align: bottom; white-space: nowrap; }
        .ritz .waffle .s7 {background-color: #ffffff; border-bottom: 1px SOLID #000000; color: #000000; direction: ltr; font-family: 'Calibri', Arial; font-size: 11pt; font-weight: bold; padding: 0px 3px 0px 3px; text-align: left; vertical-align: bottom; white-space: nowrap; }
        .ritz .waffle .s8 { background-color: #ffffff; border-bottom: 1px SOLID #000000; border-right: 1px SOLID #000000; color: #000000; direction: ltr; font-family: 'Calibri', Arial; font-size: 11pt; font-weight: bold; padding: 0px 3px 0px 3px; text-align: right; vertical-align: bottom; white-space: nowrap; }
        .ritz .waffle .s5 { background-color: #ffffff; border-right: 1px SOLID #000000; color: #000000; direction: ltr; font-family: 'Calibri', Arial; font-size: 11pt; padding: 0px 3px 0px 3px; text-align: right; vertical-align: bottom; white-space: nowrap; }
        .ritz .waffle .s0 {background-color: #d8d8d8; border-right: 1px SOLID #000000; color: #000000; direction: ltr; font-family: 'Calibri', Arial; font-size: 11pt; font-weight: bold; padding: 0px 3px 0px 3px; text-align: center; vertical-align: bottom; white-space: nowrap; }
        .ritz .waffle .s9 { background-color: #ffffff; border-bottom: 1px SOLID #000000; border-right: 1px SOLID #000000; color: #000000; direction: ltr; font-family: 'Calibri', Arial; font-size: 11pt; padding: 0px 3px 0px 3px; text-align: left; vertical-align: bottom; white-space: nowrap; }
        .column-headers-background { background-color: #d8d8d8; }
    </style>
</head>
<body>
<div class="ritz grid-container" dir="ltr">
    <table class="waffle" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
            <th id="1606692746C0" style="width:463px" class="bdtop bdleft column-headers-background">&nbsp;</th>
            <th id="1606692746C1" style="width:92px" class="bdtop  column-headers-background">&nbsp;</th>
            <th id="1606692746C2" style="width:106px" class="bdtop bdright column-headers-background">&nbsp;</th>
        </tr>
        <tr style='height:19px; border-top: 1px solid black'>
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
        foreach ($aInstits as $iInstit) :

            $oInstit = new Instituicao($iInstit);

            ?>
            <tr style='height:19px;'>
                <td class="s3 bdleft" colspan="2">I-<?= $i++; ?>) DESPESA
                    - <?php echo $oInstit->getDescricao(); ?></td>
                <td class="s4"></td>
            </tr>

            <tr style='height:19px;'>
                <td class="s3 bdleft" colspan="2">3.1.00.00.00 - PESSOAL E ENCARGOS SOCIAIS</td>
                <td class="s4"></td>
            </tr>

            <?php
            $fTotalLiquidado = 0;
            $aDespesas = getSaldoDespesa(null, "o58_elemento, o56_descr,sum(liquidado) as liquidado", null, "o58_elemento like '331%' and o58_instit = {$oInstit->getCodigo()} group by 1,2");
            foreach ($aDespesas as $oDespesa) :

                if ($oDespesa->o58_elemento == '3317170000000') {
                    /**
                     * Solicitado por Wesley@contass em 28/03/2017
                     */
                    //$oDespesa->liquidado = getConsolidacaoConsorcios($oDataIni, $oDataFim) == 0 ? $oDespesa->liquidado : getConsolidacaoConsorcios($oDataIni, $oDataFim);
                    $oDespesa->liquidado = $oDespesa->liquidado;
                }
                $fTotalLiquidado += $oDespesa->liquidado;
                ?>
                <tr style='height:19px;'>
                    <td class="s3 bdleft" colspan="2">

                        <?php echo db_formatar($oDespesa->o58_elemento, "elemento") . " - " . $oDespesa->o56_descr; ?>
                    </td>
                    <td class="s5">
                        <?php echo db_formatar($oDespesa->liquidado, "f"); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr style='height:19px;'>
                <td class="s3 bdleft" colspan="2">3.3.00.00.00 - OUTRAS DESPESAS CORRENTES</td>
                <td class="s4"></td>
            </tr>
            <?php $aDespesas2 = getSaldoDespesa(null, "o58_elemento, o56_descr,sum(liquidado) as liquidado", null, "o58_elemento like '3339034%' and o58_instit = {$oInstit->getCodigo()} group by 1,2");
            foreach ($aDespesas2 as $oDespesa) :
                $fTotalLiquidado += $oDespesa->liquidado;
            ?>

                <tr style='height:19px;'>
                    <td class="s3 bdleft" colspan="2">
                        <?php echo db_formatar($oDespesa->o58_elemento, "elemento") . " - " . $oDespesa->o56_descr; ?>
                    </td>
                    <td class="s5">
                        <?php echo db_formatar($oDespesa->liquidado, "f"); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr style='height:19px;'>
                <td class="s2 bdleft bdtop" colspan="2">SUB-TOTAL</td>
                <td class="s6 bdtop">
                    <?php echo db_formatar($fTotalLiquidado, "f");
                    $fTotalDespesas += $fTotalLiquidado; ?>
                </td>
            </tr>
        <?php endforeach; ?>

        <tr style='height:19px;'>
            <td class="s3 bdleft" colspan="2">TOTAL DAS DESPESAS COM PESSOAL NO MUNICÍPIO</td>
            <td class="s5"><?= db_formatar($fTotalDespesas, "f") ?></td>
        </tr>

        <tr style='height:19px;'>
            <td class="s3 bdleft" colspan="2">(-) Inativos e Pensionistas com Fonte de Custeio Próprio</td>
            <td class="s5">
                <?php
                $fSaldoIntaivosPensionistasProprio = 0;
                foreach ($aInstits as $iInstit) {
                    $oInstit = new Instituicao($iInstit);
                    if ($oInstit->getTipoInstit() == Instituicao::TIPO_INSTIT_RPPS) {
                        $aSaldoEstrut1 = getSaldoDesdobramento("c60_estrut LIKE '331900101%'",array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim,"103, 203", "");
                        $aSaldoEstrut2 = getSaldoDesdobramento("c60_estrut LIKE '331900301%'",array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim,"103, 203", "");
                        $aSaldoEstrut3 = getSaldoDesdobramento("c60_estrut LIKE '331900501%'",array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim,"103, 203", "");
                        $aSaldoEstrut4 = getSaldoDesdobramento("c60_estrut LIKE '331900502%'",array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim,"103, 203", "");
                        $fSaldoIntaivosPensionistasProprio += $aSaldoEstrut1[0]->liquidado + $aSaldoEstrut2[0]->liquidado + $aSaldoEstrut3[0]->liquidado + $aSaldoEstrut4[0]->liquidado;
                    }

                }
                echo db_formatar($fSaldoIntaivosPensionistasProprio, "f");
                ?>
            </td>
        </tr>

        <tr style='height:19px;'>
            <td class="s3 bdleft" colspan="2">(-) Sentenças Judiciais Anteriores</td>
            <td class="s5">
                <?php
                $fSaldoSentencasJudAnt = 0;
                foreach ($aInstits as $iInstit) {
                    $oInstit = new Instituicao($iInstit);
                    $aSaldoEstrut1 = getSaldoDespesaSentenca(null, "e60_numemp, o58_elemento, o56_descr, SUM( CASE WHEN C53_TIPO = 20 THEN ROUND(C70_VALOR,2)::FLOAT8 WHEN C53_TIPO = 21 THEN ROUND(C70_VALOR*-1,2)::FLOAT8 ELSE 0::FLOAT8 END ) AS liquidado", null, "o58_elemento like '3319091%' and o58_instit = {$oInstit->getCodigo()} and e60_datasentenca < '{$dtini}' group by 1,2,3");
                    $aSaldoEstrut2 = getSaldoDespesaSentenca(null, "e60_numemp, o58_elemento, o56_descr, SUM( CASE WHEN C53_TIPO = 20 THEN ROUND(C70_VALOR,2)::FLOAT8 WHEN C53_TIPO = 21 THEN ROUND(C70_VALOR*-1,2)::FLOAT8 ELSE 0::FLOAT8 END ) AS liquidado", null, "o58_elemento like '3319191%' and o58_instit = {$oInstit->getCodigo()} and e60_datasentenca < '{$dtini}' group by 1,2,3");
                    $aSaldoEstrut3 = getSaldoDespesaSentenca(null, "e60_numemp, o58_elemento, o56_descr, SUM( CASE WHEN C53_TIPO = 20 THEN ROUND(C70_VALOR,2)::FLOAT8 WHEN C53_TIPO = 21 THEN ROUND(C70_VALOR*-1,2)::FLOAT8 ELSE 0::FLOAT8 END ) AS liquidado", null, "o58_elemento like '3319691%' and o58_instit = {$oInstit->getCodigo()} and e60_datasentenca < '{$dtini}' group by 1,2,3");
                    $fSaldoSentencasJudAnt += $aSaldoEstrut1[0]->liquidado + $aSaldoEstrut2[0]->liquidado + $aSaldoEstrut3[0]->liquidado;
                }
                echo db_formatar($fSaldoSentencasJudAnt == null ? 0 : $fSaldoSentencasJudAnt, "f");
                ?>
            </td>
        </tr>

        <tr style='height:19px;'>
            <td class="s3 bdleft" colspan="2">(-) Despesa de Exercícios Anteriores</td>
            <td class="s5">
                <?php
                $fSaldoDespesasAnteriores = 0;
                foreach ($aInstits as $iInstit) {
                    $oInstit = new Instituicao($iInstit);
                    $aSaldoEstrut1 = getDespesaExercAnterior($dtini, $oInstit->getCodigo(), "3319092%");
                    $aSaldoEstrut2 = getDespesaExercAnterior($dtini, $oInstit->getCodigo(), "3319192%");
                    $aSaldoEstrut3 = getDespesaExercAnterior($dtini, $oInstit->getCodigo(), "3319692%");
                    $fSaldoDespesasAnteriores += $aSaldoEstrut1[0]->liquidado + $aSaldoEstrut2[0]->liquidado + $aSaldoEstrut3[0]->liquidado;
                }
                echo db_formatar($fSaldoDespesasAnteriores, "f");
                ?>
            </td>
        </tr>

        <tr style='height:19px;'>
            <td class="s3 bdleft" colspan="2">(-) Aposentadorias e Pensões Custeadas c/Rec.Fonte Tesouro</td>
            <td class="s5">
                <?php
                $fSaldoAposentadoriaPensoesTesouro = 0;
                foreach ($aInstits as $iInstit) {
                    $oInstit = new Instituicao($iInstit);
                    if ($oInstit->getTipoInstit() == Instituicao::TIPO_INSTIT_PREFEITURA || $oInstit->getTipoInstit() == Instituicao::TIPO_INSTIT_CAMARA) {
                        $aSaldoEstrut1 = getSaldoDespesa(null, "o58_anousu, o58_elemento, o56_descr,sum(liquidado) as liquidado", null, "o58_elemento like '3319001%' and o58_instit = {$oInstit->getCodigo()} and o58_codigo not in (103, 203) group by 1,2,3");
                        $fSaldo1 = ($aSaldoEstrut1[0]->o58_anousu == substr($dtini, 0, 4) && $aSaldoEstrut1[0]->o58_anousu <= 2018) ? $aSaldoEstrut1[0]->liquidado : 0;
                        $aSaldoEstrut2 = getSaldoDespesa(null, "o58_anousu, o58_elemento, o56_descr,sum(liquidado) as liquidado", null, "o58_elemento like '3319003%' and o58_instit = {$oInstit->getCodigo()} and o58_codigo not in (103, 203) group by 1,2,3");
                        $fSaldo2 = ($aSaldoEstrut2[0]->o58_anousu == substr($dtini, 0, 4) && $aSaldoEstrut2[0]->o58_anousu <= 2018) ? $aSaldoEstrut2[0]->liquidado : 0;
                        $aSaldoEstrut3 = getSaldoDespesa(null, "o58_anousu, o58_elemento, o56_descr,sum(liquidado) as liquidado", null, "o58_elemento like '3319005%' and o58_instit = {$oInstit->getCodigo()} and o58_codigo not in (103, 203) group by 1,2,3");
                        $fSaldo3 = ($aSaldoEstrut3[0]->o58_anousu == substr($dtini, 0, 4) && $aSaldoEstrut3[0]->o58_anousu <= 2018) ? $aSaldoEstrut3[0]->liquidado : 0;
                        $fSaldoAposentadoriaPensoesTesouro += $fSaldo1 + $fSaldo2 + $fSaldo3;
                    }
                }
                echo db_formatar($fSaldoAposentadoriaPensoesTesouro, "f");
                ?>
            </td>
        </tr>

        <tr style='height:19px;'>
            <td class="s3 bdleft" colspan="2">(-) Indenização por demissão de servidores ou empregados</td>
            <td class="s5">
                <?php
                $fSaldoIndenizacaoDemissaoServidores = 0;
                foreach ($aInstits as $iInstit) {
                    $oInstit = new Instituicao($iInstit);
                    $aSaldoEstrut1 = getSaldoDesdobramento("c60_estrut LIKE '331909401%'",array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim,"", "");
                    $aSaldoEstrut2 = getSaldoDesdobramento("c60_estrut LIKE '331909403%'",array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim,"", "");
                    $aSaldoEstrut3 = getSaldoDesdobramento("c60_estrut LIKE '331919401%'",array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim,"", "");
                    $aSaldoEstrut4 = getSaldoDesdobramento("c60_estrut LIKE '331919403%'",array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim,"", "");
                    $aSaldoEstrut5 = getSaldoDesdobramento("c60_estrut LIKE '331969401%'",array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim,"", "");
                    $aSaldoEstrut6 = getSaldoDesdobramento("c60_estrut LIKE '331969403%'",array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim,"", "");
                    $fSaldoIndenizacaoDemissaoServidores += $aSaldoEstrut1[0]->liquidado + $aSaldoEstrut2[0]->liquidado + $aSaldoEstrut3[0]->liquidado + $aSaldoEstrut4[0]->liquidado + $aSaldoEstrut5[0]->liquidado + $aSaldoEstrut6[0]->liquidado;
                }
                echo db_formatar($fSaldoIndenizacaoDemissaoServidores, "f");
                ?>
            </td>
        </tr>
        <tr style='height:19px;'>
            <td class="s2 bdleft" colspan="2">(-) Incentivos a demissão voluntária</td>
            <td class="s6">
                <?php
                $fSaldoIncentivosDemissaoVoluntaria = 0;
                foreach ($aInstits as $iInstit) {
                    $oInstit = new Instituicao($iInstit);
                    $aSaldoEstrut1 = getSaldoDesdobramento("c60_estrut LIKE '331909402%'",array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim,"", "");
                    $aSaldoEstrut2 = getSaldoDesdobramento("c60_estrut LIKE '331919402%'",array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim,"", "");
                    $aSaldoEstrut3 = getSaldoDesdobramento("c60_estrut LIKE '331969402%'",array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim,"", "");
                    $fSaldoIncentivosDemissaoVoluntaria += $aSaldoEstrut1[0]->liquidado + $aSaldoEstrut2[0]->liquidado + $aSaldoEstrut3[0]->liquidado;
                }
                echo db_formatar($fSaldoIncentivosDemissaoVoluntaria, "f");
                ?>
            </td>
        </tr>
        <tr style='height:19px;'>
            <td class="s7 bdleft" colspan="2">TOTAL DAS DESPESAS COM PESSOAL = BASE DE CÁLCULO</td>
            <td class="s8">
                <?php
                $fTotalDespesaPessoal = $fTotalDespesas - ($fSaldoIntaivosPensionistasProprio + $fSaldoSentencasJudAnt + $fSaldoAposentadoriaPensoesTesouro + $fSaldoDespesasAnteriores + $fSaldoIndenizacaoDemissaoServidores + $fSaldoIncentivosDemissaoVoluntaria);
                echo db_formatar($fTotalDespesaPessoal, "f");
                ?>
            </td>
        </tr>

        <tr style='height:19px;'>
            <td class="s1 bdleft" colspan="3">II) RECEITA</td>
        </tr>

        <tr style='height:19px;'>
            <td class="s7 bdleft" colspan="2">Receita Corrente do Município</td>
            <td class="s8">
                <?php
                $fValorManualRCL = getValorManual($codigorelatorio, 1, $oInstit->getCodigo(), $o116_periodo, $iAnousu);
                $fRCL += $fValorManualRCL == NULL ? $fTotalReceitasArrecadadas : $fValorManualRCL;
                echo db_formatar($fTotalReceitasArrecadadas, "f");
                //echo db_formatar($fRCL, "f");
                ?>
            </td>
        </tr>
        <!--
                      <tr style='height:19px;'>
                        <td class="s3 bdleft" colspan="2">(-) Receita Corrente Intraorçamentária</td>
                        <td class="s5">
                          <?php
        //$aDadosRCI = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '47%'");
        $fRCI = 0;//count($aDadosRCI) > 0 ? $aDadosRCI[0]->saldo_arrecadado : 0;
        //echo db_formatar($fRCI, "f");
        ?>
                        </td>
                      </tr>
                    -->
        <tr style='height:19px;'>
            <td class="s3 bdleft" colspan="2">(-) Deduções da Receita Corrente (Exceto FUNDEB)</td>
            <td class="s5">
                <?php

                echo db_formatar(abs($fCSACRPPS), "f");
                ?>
            </td>
        </tr>

        <tr style='height:19px;'>
            <td class="s3 bdleft" colspan="2">(-) Deduções de Receita para formação do FUNDEB</td>
            <td class="s5">
                <?php

                echo db_formatar(abs($fCSICRPPS), "f");
                ?>
            </td>
        </tr>

        <tr style='height:19px;'>
            <td class="s3 bdleft" colspan="2">(-) Receitas Corrente Intraorçamentária</td>
            <td class="s5">
                <?php
                echo db_formatar($fCPRPPS, "f");
                ?>
            </td>
        </tr>

        <tr style='height:19px;'>
            <td class="s3 bdleft" colspan="2">(-) Contribuição dos Servidores para o Sistema Próprio de Previdência
            </td>
            <td class="s5">
                <?php

                echo db_formatar($fRRCSACOPSJ, "f");
                ?>
            </td>
        </tr>

        <tr style='height:19px;'>
            <td class="s3 bdleft" colspan="2">(-) Compensação entre Regimes de Previdência
            </td>
            <td class="s5">
                <?php

                echo db_formatar($fRRCSICOPSJ, "f");
                ?>
            </td>
        </tr>

        <tr style='height:19px;'>
            <td class="s3 bdleft" colspan="2"><b>RECEITA CORRENTE LÍQUIDA</b></td>
            <td class="s5">
                <?php
                $fRecCorrLiq = $fTotalReceitasArrecadadas - abs($fCSACRPPS) - abs($fCSICRPPS) - $fCPRPPS - $fRRCSACOPSJ - $fRRCSICOPSJ;
                echo db_formatar($fRecCorrLiq, "f");
                ?>
            </td>
        </tr>

        <tr style='height:19px;'>
            <td class="s3 bdleft" colspan="2">(-) Transferências Advindas de Emendas Parlamentares (Art. 166, §13 da CF)</td>
            <td class="s5">
                <?php
                
                if ($oDataFim->getAno() >= 2020) {
                    
                    $aSaldoArrecadadoEmenda = getSaldoArrecadadoEmendaParlamentar($dtini, $dtfim, $oInstit->getCodigo());
                    $fCFRP += $aSaldoArrecadadoEmenda[0]->arrecadado_emenda_parlamentar;
                    
                }

                echo db_formatar($fCFRP, "f");
                ?>
            </td>
        </tr>
        <?php
        $fTotalDeducoes = 0;
        $aDadoDeducao = getSaldoReceita(null, "o57_fonte,o57_descr,saldo_arrecadado", null, "o57_fonte like '492%'");
        foreach ($aDadoDeducao as $oDeducao) {
            ?>
            <tr style='height:19px;'>
                <td class="s3 bdleft" colspan="2">
                    <?php echo db_formatar($oDespesa->o57_fonte, "receita") . " - " . $oDespesa->o57_descr; ?>
                </td>
                <td class="s5">
                    <?php
                    $fTotalDeducoes += $oDespesa->saldo_arrecadado;
                    echo db_formatar($oDespesa->saldo_arrecadado, "f");
                    ?>
                </td>
            </tr>
        <?php }

        $aDadoDeducao = getSaldoReceita(null, "o57_fonte,o57_descr,saldo_arrecadado", null, "o57_fonte like '499%'");
        foreach ($aDadoDeducao as $oDeducao) { ?>
            <tr style='height:19px;'>
                <td class="s3 bdleft" colspan="2">
                    <?php echo db_formatar($oDespesa->o57_fonte, "receita") . " - " . $oDespesa->o57_descr; ?>
                </td>
                <td class="s5">
                    <?php
                    $fTotalDeducoes += $oDespesa->saldo_arrecadado;
                    echo db_formatar($oDespesa->saldo_arrecadado, "f");
                    ?>
                </td>
            </tr>
        <?php } ?>

        <tr style='height:20px;'>
            <td class="s7 bdleft" colspan="2">RECEITA CORRENTE LÍQUIDA AJUSTADA = BASE DE CÁLCULO</td>
            <td class="s8">
                <?php
                $fRCLBase = $fRecCorrLiq - $fCFRP;
                echo db_formatar($fRCLBase, "f");
                ?>
            </td>
        </tr>

        <tr style='height:19px;'>
            <td class="s9 bdleft" colspan="3">III) PERCENTUAIS MONETÁRIOS DE APLICAÇÃO</td>
        </tr>


        <tr style='height:19px;'>
            <td class="s1 bdleft">Aplicação no Exercício</td>
            <td class="s10"><?php echo db_formatar(($fTotalDespesaPessoal / $fRCLBase) * 100, "f"); ?>%</td>
            <td class="s10"><?php echo db_formatar($fTotalDespesaPessoal, "f") ?></td>
        </tr>
        <?
        if($iVerifica == 1):
            ?>
            <tr style='height:20px;'>
                <td class="s9 bdleft">Permitido pela Lei Complementar 101/00</td>
                <td class="s6">6%</td>
                <td class="s6"><?php echo db_formatar($fRCLBase * 0.06, "f") ?></td>
            </tr>
        <?
        elseif ($iVerifica == 2 ):
            ?>
            <tr style='height:20px;'>
                <td class="s9 bdleft">Permitido pela Lei Complementar 101/00</td>
                <td class="s6">54%</td>
                <td class="s6"><?php echo db_formatar($fRCLBase * 0.54, "f") ?></td>
            </tr>
        <?
        else:
            ?>
            <tr style='height:20px;'>
                <td class="s9 bdleft">Permitido pela Lei Complementar 101/00</td>
                <td class="s6">60%</td>
                <td class="s6"><?php echo db_formatar($fRCLBase * 0.6, "f") ?></td>
            </tr>
        <?
        endif;
        ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php

$html = ob_get_contents();
ob_end_clean();
//echo $html;

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
function getConsolidacaoConsorcios(DBDate $oDataIni, DBDate $oDataFim)
{
    $oConsexecucaoorc = new cl_consexecucaoorc();
    $aPeriodo = DBDate::getMesesNoIntervalo($oDataIni, $oDataFim);
    $fTotal = 0;
    foreach ($aPeriodo as $ano => $mes) {
        $sSql = $oConsexecucaoorc->sql_query_file(null, "sum(coalesce(c202_valorliquidado,0)) as c202_valorliquidado", null, "c202_anousu = " . $ano . " and c202_mescompetencia in (" . implode(',', array_keys($mes)) . ")");
        $fTotal += db_utils::fieldsMemory(db_query($sSql), 0)->c202_valorliquidado;

    }

    return $fTotal;
}

/**
 * Busca os valores informados manualmente na aba 'parametros' do relatório
 * @param $iCodRelatorio
 * @param $iLinha
 * @param $iInstit
 * @param $iCodPeriodo
 * @param $iAnousu
 * @return array
 */
function getValorManual($iCodRelatorio, $iLinha, $iInstit, $iCodPeriodo, $iAnousu)
{

    $oLinha = new linhaRelatorioContabil($iCodRelatorio, $iLinha, $iInstit);
    $oLinha->setPeriodo($iCodPeriodo);
    $oLinha->setEncode(true);
    $aValores = $oLinha->getValoresColunas(null, null, null, $iAnousu);
    return $aValores[0]->colunas[0]->o117_valor;

}

?>
