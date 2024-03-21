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


require_once("dbforms/db_funcoes.php");
require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
include_once "libs/db_sessoes.php";
include_once "libs/db_usuariosonline.php";
include("libs/db_liborcamento.php");
include("libs/db_libcontabilidade.php");
require_once("classes/db_cgm_classe.php");
require_once("classes/db_slip_classe.php");
require_once("classes/db_empresto_classe.php");
require_once("classes/db_empempenho_classe.php");
require_once("classes/db_dadosexercicioanterior_classe.php");
require_once("classes/db_infocomplementaresinstit_classe.php");
include("libs/db_sql.php");

use \Mpdf\Mpdf;
use \Mpdf\MpdfException;

$clselorcdotacao = new cl_selorcdotacao();
$clinfocomplementaresinstit = new cl_infocomplementaresinstit();
$cldadosexecicioanterior = new cl_dadosexercicioanterior();
db_postmemory($HTTP_POST_VARS);

$dtini = implode("-", array_reverse(explode("/", $DBtxt21)));
$dtfim = implode("-", array_reverse(explode("/", $DBtxt22)));

$instits = str_replace('-', ', ', $db_selinstit);
$aInstits = explode(",", $instits);
if (count($aInstits) > 1) {
    $oInstit = new Instituicao();
    $oInstit = $oInstit->getDadosPrefeitura();
} else {
    foreach ($aInstits as $iInstit) {
        $oInstit = new Instituicao($iInstit);
    }
}

db_inicio_transacao();

/**
 * pego todas as instituições;
 */

$rsInstits = $clinfocomplementaresinstit->sql_record($clinfocomplementaresinstit->sql_query(null, "si09_instit, si09_tipoinstit", null, null));

$ainstitunticoes = array();
for ($i = 0; $i < pg_num_rows($rsInstits); $i++) {
    $odadosInstint = db_utils::fieldsMemory($rsInstits, $i);
    $ainstitunticoes[] = $odadosInstint->si09_instit;
}
$iInstituicoes = implode(',', $ainstitunticoes);

$rsTipoinstit = $clinfocomplementaresinstit->sql_record($clinfocomplementaresinstit->sql_query(null, "si09_sequencial, si09_tipoinstit", null, "si09_instit in( {$instits})"));

/**
 * busco o tipo de instituicao
 */
$ainstitunticoes = array();
$aTipoistituicao = array();

for ($i = 0; $i < pg_num_rows($rsTipoinstit); $i++) {
    $odadosInstint = db_utils::fieldsMemory($rsTipoinstit, $i);
    $aTipoistituicao[] = $odadosInstint->si09_tipoinstit;
    $iCont = pg_num_rows($rsTipoinstit);
}

$db_filtro = " o70_instit in({$instits}) ";
$anousu = db_getsession("DB_anousu");

$aFuncoes     = array(12);
$aSubFuncoes = array(122, 272, 271, 361, 365, 366, 367, 843);

if ($anousu >=2022){
    $aReceitasImpostos = array(
        array('1 - FUNDEB - IMPOSTOS E TRANSFERÊNCIAS DE IMPOSTOS', 'title', array('413210101%', '413210501%', '417515001%'), "'118','119','1118','1119','15400007','15400000'"),
        array('1.1 - TRANSFERÊNCIAS DE RECURSOS DO FUNDO DE MANUTENÇÃO E DESENVOLVIMENTO DA EDUCAÇÃO BÁSICA E DE VALORIZAÇÃO DOS PROFISSIONAIS DA EDUCAÇÃO - FUNDEB (NR 1.7.5.1.50.0.1 )', 'text', array('417515001%'), "'118','119','1118','1119','15400007','15400000'"),
        array('1.2 - RENDIMENTOS DE APLICAÇÃO FINANCEIRA (NR 1.3.2.1.01.0.1 + NR 1.3.2.1.05.0.1 )', 'text', array('413210101%', '413210501%'), "'118','119','1118','1119','15400007','15400000'"),
        array('2 - FUNDEB - COMPLEMENTAÇÃO DA UNIÃO - VAAT', 'title', array('413210101%', '413210501%', '417155001%'), "'166','167','1166','1167','15420007','15420000'"),
        array('2.1 - TRANSFERÊNCIAS DE RECURSOS DA COMPLEMENTAÇÃO DA UNIÃO AO FUNDO DE MANUTENÇÃO E DESENVOLVIMENTO DA EDUCAÇÃO BÁSICA E DE VALORIZAÇÃO DOS PROFISSIONAIS DA EDUCAÇÃO - FUNDEB (VAAT) (NR 1.7.1.5.50.0.1)', 'text', array('417155001%'), "'166','167','1166','1167','15420007','15420000'"),
        array('2.2 - RENDIMENTOS DE APLICAÇÃO FINANCEIRA (NR 1.3.2.1.01.0.1 + NR 1.3.2.1.05.0.1 )', 'text', array('413210101%', '413210501%'), "'166','167','1166','1167','15420007','15420000'"),
    );
}else{
    $aReceitasImpostos = array(
        array('1 - FUNDEB - IMPOSTOS E TRANSFERÊNCIAS DE IMPOSTOS', 'title', array('413210011%', '413210051%', '417580111%'), "'118','119'"),
        array('1.1 - TRANSFERÊNCIAS DE RECURSOS DO FUNDO DE MANUTENÇÃO E DESENVOLVIMENTO DA EDUCAÇÃO BÁSICA E DE VALORIZAÇÃO DOS  PROFISSIONAIS DA EDUCAÇÃO  - FUNDEB  (NR 1.7.5.8.01.1.1 )', 'text', array('417580111%'), "'118','119'"),
        array('1.2 - RENDIMENTOS DE APLICAÇÃO FINANCEIRA (NR 1.3.2.1.00.1.1 + NR 1.3.2.1.00.5.1 )', 'text', array('413210011%', '413210051%'), "'118','119'"),
        array('2 - FUNDEB - COMPLEMENTAÇÃO DA UNIÃO - VAAT', 'title', array('413210011%', '413210051%', '417180911%'), "'166','167'"),
        array('2.1 - TRANSFERÊNCIAS DE RECURSOS DA COMPLEMENTAÇÃO DA UNIÃO AO FUNDO DE MANUTENÇÃO E DESENVOLVIMENTO DA EDUCAÇÃO BÁSICA E DE VALORIZAÇÃO DOS PROFISSIONAIS DA EDUCAÇÃO - FUNDEB (VAAT) (NR 1.7.1.8.09.1.1 )', 'text', array('417180911%'), "'166','167'"),
        array('2.2 - RENDIMENTOS DE APLICAÇÃO FINANCEIRA (NR 1.3.2.1.00.1.1 + NR 1.3.2.1.00.5.1 )', 'text', array('413210011%', '413210051%'), "'166','167'"),
    );
}



$oDadosexecicioanterior = $cldadosexecicioanterior->getDadosExercicioAnterior(db_getsession("DB_anousu"), $instits, "*", "");

function getValorNaturezaReceita($aNaturecaReceita, $aFontes, $anoUsu, $dtIni, $dtFim, $instits)
{
    $nReceitaTotal = 0;
    $sWhereReceita      = " o70_instit in ({$instits}) ";
    if($anoUsu > 2022)
        $sWhereReceita      .= " and o70_codigo in ( select o15_codigo from orctiporec where o15_codigo in ({$aFontes}) )";
    else
        $sWhereReceita      .= " and o70_codigo in ( select o15_codigo from orctiporec where o15_codtri in ({$aFontes}) )";
    $rsReceitas = db_receitasaldo(11, 1, 3, true, $sWhereReceita, $anoUsu, $dtIni, $dtFim, false, ' * ', true, 0);
    $aReceitas = db_utils::getColectionByRecord($rsReceitas);
    db_query("drop table if exists work_receita");
    criarWorkReceita($sWhereReceita, array($anoUsu), $dtIni, $dtFim);
    foreach ($aNaturecaReceita as $sNatureza) {
        $aReceitas = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '{$sNatureza}'");
        $nReceita = count($aReceitas) > 0 ? $aReceitas[0]->saldo_arrecadado_acumulado : 0;
        $nReceitaTotal = $nReceitaTotal + $nReceita;
    }

    db_query("drop table if exists work_receita");
    return $nReceitaTotal;
}

function getDevolucaoRecursoFundeb($dtIni, $dtFim, $aInstits)
{
    $clSlip = new cl_slip();
    $nDevolucaoRecursoFundeb = 0;
    $rsSlip = $clSlip->sql_record($clSlip->sql_query_fundeb($dtIni, $dtFim, $aInstits));
    $nDevolucaoRecursoFundeb = db_utils::fieldsMemory($rsSlip, 0)->k17_valor;
    return $nDevolucaoRecursoFundeb;
}


$sWhereDespesa      = " o58_instit in({$instits})";
db_query("drop table if exists work_dotacao");
criaWorkDotacao($sWhereDespesa,array($anousu), $dtini, $dtfim);


function getEmpenhosApagar($aFontes, $dtini, $dtfim, $instits, $tipo) {
        $clempempenho = new cl_empempenho();
        $sSqlOrder    = "";
        $sCampos      = "o15_codtri, sum(e60_vlremp) as vlremp, sum(vlranu) as vlranu,  sum(vlrpag) as vlrpago, sum(vlrliq) as vlrliq ";
        $sSqlWhere    = " o15_codtri in (".implode(",", $aFontes).") group by 1";
        if(db_getsession("DB_anousu") > 2022)
            $sSqlWhere    = " o15_codigo in (".implode(",", $aFontes).") group by 1";
        $aEmpEmpenho  = $clempempenho->getEmpenhosMovimentosPeriodo(db_getsession("DB_anousu"), $dtini, $dtfim, $instits, $sCampos, $sSqlWhere, $sSqlOrder);
        $valorEmpLQDAPagar = 0;
        $valorEmpNaoLQDAPagar = 0;
        foreach($aEmpEmpenho as $oEmp){
            $valorEmpLQDAPagar += ($oEmp->vlrliq - $oEmp->vlrpago);
            $valorEmpNaoLQDAPagar += ($oEmp->vlremp - $oEmp->vlranu - $oEmp->vlrliq);
        }

        //echo "<pre>";print_r($aEmpEmpenho);exit;
        if($tipo == 'lqd'){
            return  $valorEmpLQDAPagar;
        }
        return  $valorEmpNaoLQDAPagar;
}

function getPagamentoFuncao($iFuncao, $aFontes, $dtini, $dtfim, $instits)
{
    $clempempenho = new cl_empempenho();
    $sSqlOrder    = "";
    $sCampos      = "o58_funcao, sum(vlrpag) as vlrpago ";
    $sSqlWhere    = " o58_funcao = {$iFuncao} and o15_codtri in (".implode(",", $aFontes).") group by 1";
    if(db_getsession("DB_anousu") > 2022)
        $sSqlWhere    = " o58_funcao = {$iFuncao} and o15_codigo in (".implode(",", $aFontes).") group by 1";
    $aEmpEmpenho  = $clempempenho->getEmpenhosMovimentosPeriodo(db_getsession("DB_anousu"), $dtini, $dtfim, $instits, $sCampos, $sSqlWhere, $sSqlOrder);
    $valorEmpPago = 0;
    foreach($aEmpEmpenho as $oEmp){
        $valorEmpPago += $oEmp->vlrpago;
    }
    return  $valorEmpPago;
}

function getRestosaPagarComplementacaoCapital($dtini, $dtfim, $instits)
{
        $clempresto = new cl_empresto();
        $sSqlOrder = "";
        $sCampos = " sum(vlrpag) as vlrpag ";
        $sSqlWhere = " substr(o56_elemento,1,3) = '344' and o15_codtri in ('166', '167')";
        if(db_getsession("DB_anousu") > 2022)
            $sSqlWhere = " substr(o56_elemento,1,3) = '344' and o15_codigo in ('166', '167','1166', '1167','15420007', '15420000')";
        $aEmpRestos = $clempresto->getRestosPagarRelAnexoVIII(db_getsession("DB_anousu"), $dtini, $dtfim, $instits,  $sCampos, $sSqlWhere, $sSqlOrder);
        $nRPPagoComplementacao = 0;
        foreach($aEmpRestos as $oEmpResto){
            $nRPPagoComplementacao = $oEmpResto->vlrpag + $oEmpResto->vlrpagnproc;
        }
        return $nRPPagoComplementacao;
}

function getPagamentoComplementacaoCapital($dtini, $dtfim, $instits)
{
    $clempempenho = new cl_empempenho();
    $sSqlOrder    = "";
    $sCampos      = "sum(vlrpag) as vlrpago ";
    $sSqlWhere    = " substr(o56_elemento, 1, 3) = '344' and o15_codtri in ('166', '167')";
    if(db_getsession("DB_anousu") > 2022)
        $sSqlWhere = " substr(o56_elemento, 1, 3) = '344' and o15_codigo in ('166', '167','1166', '1167','15420007', '15420000')";
    $aEmpEmpenho  = $clempempenho->getEmpenhosMovimentosPeriodo(db_getsession("DB_anousu"), $dtini, $dtfim, $instits, $sCampos, $sSqlWhere, $sSqlOrder);
    $valorEmpPago = 0;
    foreach($aEmpEmpenho as $oEmp){
        $valorEmpPago += $oEmp->vlrpago;
    }
    return  $valorEmpPago;
}

function getRestosaPagarComplementacaoInfantil($dtini, $dtfim, $instits)
{
        $clempresto = new cl_empresto();
        $sSqlOrder = "";
        $sCampos = " sum(vlrpag) as vlrpag ";
        $sSqlWhere = " o58_subfuncao = 365 and o15_codtri in ('166', '167')";
        if(db_getsession("DB_anousu") > 2022)
            $sSqlWhere = " o58_subfuncao = 365 and o15_codigo in ('166', '167','1166', '1167','15420007', '15420000')";
        $aEmpRestos = $clempresto->getRestosPagarRelAnexoVIII(db_getsession("DB_anousu"), $dtini, $dtfim, $instits,  $sCampos, $sSqlWhere, $sSqlOrder);
        $nRPPagoComplementacao = 0;
        foreach($aEmpRestos as $oEmpResto){
            $nRPPagoComplementacao = $oEmpResto->vlrpag + $oEmpResto->vlrpagnproc;
        }
        return $nRPPagoComplementacao;
}

function getPagamentoComplementacaoInfantil($dtini, $dtfim, $instits)
{
    $clempempenho = new cl_empempenho();
    $sSqlOrder    = "";
    $sCampos      = "sum(vlrpag) as vlrpago ";
    $sSqlWhere    = " o58_subfuncao = 365 and o15_codtri in ('166', '167')";
    if(db_getsession("DB_anousu") > 2022)
        $sSqlWhere    = " o58_subfuncao = 365 and o15_codigo in ('166', '167','1166', '1167','15420007', '15420000')";
    $aEmpEmpenho  = $clempempenho->getEmpenhosMovimentosPeriodo(db_getsession("DB_anousu"), $dtini, $dtfim, $instits, $sCampos, $sSqlWhere, $sSqlOrder);
    $valorEmpPago = 0;
    foreach($aEmpEmpenho as $oEmp){
        $valorEmpPago += $oEmp->vlrpago;
    }
    return  $valorEmpPago;
}

function getSaldoPlanoContaFonteFundeb($nFonte, $dtIni, $dtFim, $aInstits){
    $where = " c61_instit in ({$aInstits})" ;
    if(db_getsession("DB_anousu") > 2022)
        $where .= " and c61_codigo in ( select o15_codigo from orctiporec where o15_codigo in ($nFonte) ) ";
    else
        $where .= " and c61_codigo in ( select o15_codigo from orctiporec where o15_codtri in ($nFonte) ) ";
    $result = db_planocontassaldo_matriz(db_getsession("DB_anousu"), $dtIni, $dtFim, false, $where, '111');
    $nTotalAnterior = 0;
    for($x = 0; $x < pg_numrows($result); $x++){
        $oPlanoConta = db_utils::fieldsMemory($result, $x);
        if( ( $oPlanoConta->movimento == "S" )
            && ( ( $oPlanoConta->saldo_anterior + $oPlanoConta->saldo_anterior_debito + $oPlanoConta->saldo_anterior_credito) == 0 ) ) {
            continue;
        }
        if(substr($oPlanoConta->estrutural,1,14) == '00000000000000'){
            if($oPlanoConta->sinal_anterior == "C")
                $nTotalAnterior -= $oPlanoConta->saldo_anterior;
            else {
                $nTotalAnterior += $oPlanoConta->saldo_anterior;
            }
        }
    }
    return $nTotalAnterior;
}

function getRestosSemDisponilibidadeFundeb($aFontes, $dtIni, $dtFim, $aInstits) {
    $iSaldoRestosAPagarSemDisponibilidade = 0;

    foreach($aFontes as $sFonte){
        db_inicio_transacao();
        $clEmpResto = new cl_empresto();
        $sSqlOrder = "";
        $sCampos = " o15_codtri, sum(vlrpag) as pagorpp, sum(vlrpagnproc) as pagorpnp ";
        $sSqlWhere = " o15_codtri in ($sFonte) group by 1 ";
        if(db_getsession("DB_anousu") > 2022)
            $sSqlWhere = " o15_codigo in ($sFonte) group by 1 ";
        $aEmpRestos = $clEmpResto->getRestosPagarRelAnexoVIII(db_getsession("DB_anousu"), $dtIni, $dtFim, $aInstits, $sCampos, $sSqlWhere, $sSqlOrder);
        $nValorRpPago = 0;
        foreach($aEmpRestos as $oEmpResto){
            $nValorRpPago += $oEmpResto->pagorpp + $oEmpResto->pagorpnp;
        }
        $nTotalAnterior = getSaldoPlanoContaFonteFundeb($sFonte, $dtIni, $dtFim, $aInstits);
        $nSaldo = 0;
        if($nValorRpPago > $nTotalAnterior){
            $nSaldo = $nValorRpPago - $nTotalAnterior ;
        }
        $iSaldoRestosAPagarSemDisponibilidade += $nSaldo;
        db_query("drop table if exists work_pl");
        db_fim_transacao();
    }
    return  $iSaldoRestosAPagarSemDisponibilidade;
}

function getDespesasCusteadosComSuperavit($aFontes, $dtini, $dtfim, $instits) {
    $clempempenho = new cl_empempenho();
    $sSqlOrder = "";
    $sCampos = " o15_codtri, sum(vlrpag) as vlrpag ";
    $sSqlWhere = " o15_codtri in (".implode(",", $aFontes).") group by 1";
    if(db_getsession("DB_anousu") > 2022)
        $sSqlWhere = " o15_codigo in (".implode(",", $aFontes).") group by 1";
    $dtfim = db_getsession("DB_anousu")."-04-30";
    $aEmpEmpenho = $clempempenho->getDespesasCusteadosComSuperavit(db_getsession("DB_anousu"), $dtini, $dtfim, $instits,  $sCampos, $sSqlWhere, $sSqlOrder);
    $valorEmpPagoSuperavit = 0;
    foreach($aEmpEmpenho as $oEmp){
        $valorEmpPagoSuperavit += $oEmp->vlrpag;
    }
    return  $valorEmpPagoSuperavit;
}

function getDespesasCusteadosComSuperavitPosPrimeiroQuadrimestre($aFontes, $dtini, $dtfim, $instits) {
    $clempempenho = new cl_empempenho();
    $sSqlOrder = "";
    $sCampos = " o15_codtri, sum(vlrpag) as vlrpag ";
    $sSqlWhere = " o15_codtri in (".implode(",", $aFontes).") group by 1";
    if(db_getsession("DB_anousu") > 2022)
        $sSqlWhere = " o15_codigo in (".implode(",", $aFontes).") group by 1";
    $dtini = db_getsession("DB_anousu")."-05-01";
    $aEmpEmpenho = $clempempenho->getDespesasCusteadosComSuperavit(db_getsession("DB_anousu"), $dtini, $dtfim, $instits,  $sCampos, $sSqlWhere, $sSqlOrder);
    $valorEmpPagoSuperavit = 0;
    foreach($aEmpEmpenho as $oEmp){
        $valorEmpPagoSuperavit += $oEmp->vlrpag;
    }
    return  $valorEmpPagoSuperavit;
}

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

try {
$mPDF = new Mpdf([
    'mode' => '',
    'format' => 'A4-L',
    'orientation' => 'L',
    'margin_left' => 15,
    'margin_right' => 15,
    'margin_top' => 20,
    'margin_bottom' => 10,
    'margin_header' => 5,
    'margin_footer' => 11,
]);
$header = " <header>
                <div style=\" height: 120px; font-family:Arial\">
                    <div style=\"width:33%; float:left; padding:5px; font-size:10px;\">
                        <b><i>{$oInstit->getDescricao()}</i></b><br/>
                        <i>{$oInstit->getLogradouro()}, {$oInstit->getNumero()}</i><br/>
                        <i>{$oInstit->getMunicipio()} - {$oInstit->getUf()}</i><br/>
                        <i>{$oInstit->getTelefone()} - CNPJ: " . db_formatar($oInstit->getCNPJ(), "cnpj") . "</i><br/>
                        <i>{$oInstit->getSite()}</i>
                    </div>
                    <div style=\"width:25%; float:right\" class=\"box\">
                        <b>Relatório FUNDEB - Anexo VIII</b><br/>
                        <b>INSTITUIÇÕES:</b> ";
foreach ($aInstits as $iInstit) {
    $oInstituicao = new Instituicao($iInstit);
    $header .= "(" . trim($oInstituicao->getCodigo()) . ") " . $oInstituicao->getDescricao() . " ";
}
$header .= "<br/> <b>PERÍODO:</b> {$DBtxt21} A {$DBtxt22} <br/>
                    </div>
                </div>
            </header>";

$footer = "<footer>
                <div style='border-top:1px solid #000;width:100%;font-family:sans-serif;font-size:10px;height:10px;'>
                    <div style='text-align:left;font-style:italic;width:90%;float:left;'>
                        Financeiro>Contabilidade>Relatórios de Acompanhamento>Fundeb - Anexo VIII
                        Emissor: " . db_getsession("DB_login") . " Exerc: " . db_getsession("DB_anousu") . " Data:" . date("d/m/Y H:i:s", db_getsession("DB_datausu"))  . "
                    <div style='text-align:right;float:right;width:10%;'>
                        {PAGENO}
                    </div>
                </div>
          </footer>";

$mPDF->WriteHTML(file_get_contents('estilos/tab_relatorio.css'), 1);
$mPDF->setHTMLHeader(utf8_encode($header), 'O', true);
$mPDF->setHTMLFooter(utf8_encode($footer), 'O', true);

ob_start();

?>
<html>

<head>
    <style type="text/css">
        .title-relatorio {
            text-align: center;
            padding: 0;
        }

        .ritz .waffle a {
            color: inherit;
        }

        .ritz .waffle .s6 {
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s42 {
            border-right: none;
            border-bottom: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s33 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: top;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s35 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
        }

        .ritz .waffle .s4 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s3 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 8pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s20 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: right;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s9 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: normal;
            overflow: hidden;
            word-wrap: break-word;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s36 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #808080;
            background-color: #cccccc;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s53 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s18 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: top;
            white-space: normal;
            overflow: hidden;
            word-wrap: break-word;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s11 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 8pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s14 {
            border-left: none;
            border-right: none;
            background-color: #cccccc;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s34 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: top;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s50 {
            border-left: none;
            border-right: none;
            border-bottom: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s0 {
            background-color: #ffffff;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 8pt;
            vertical-align: top;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s29 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: normal;
            overflow: hidden;
            word-wrap: break-word;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s52 {
            background-color: #ffffff;
            text-align: center;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s19 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s26 {
            border-bottom: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s45 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: normal;
            overflow: hidden;
            word-wrap: break-word;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s24 {
            border-left: none;
            border-right: none;
            border-bottom: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s30 {
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s8 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 8pt;
            vertical-align: bottom;
            white-space: normal;
            overflow: hidden;
            word-wrap: break-word;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s27 {
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'docs-Calibri', Arial;
            font-size: 8pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s2 {
            border-bottom: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: top;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s38 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: right;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: top;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s37 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #808080;
            background-color: #cccccc;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s23 {
            border-right: none;
            border-bottom: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s28 {
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s10 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: right;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s22 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: right;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s43 {
            border-left: none;
            border-bottom: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s25 {
            border-left: none;
            border-bottom: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s46 {
            border-bottom: 1px SOLID #808080;
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: right;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: top;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s41 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s13 {
            border-right: none;
            background-color: #cccccc;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s31 {
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: right;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s21 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s12 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s40 {
            border-bottom: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s47 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #808080;
            background-color: #cccccc;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s7 {
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: right;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s17 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 8pt;
            vertical-align: top;
            white-space: normal;
            overflow: hidden;
            word-wrap: break-word;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s39 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'docs-Calibri', Arial;
            font-size: 8pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s44 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: middle;
            white-space: normal;
            overflow: hidden;
            word-wrap: break-word;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s15 {
            border-left: none;
            background-color: #cccccc;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s48 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #808080;
            background-color: #cccccc;
            text-align: right;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s32 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 8pt;
            vertical-align: top;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s49 {
            border-right: none;
            border-bottom: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s16 {
            background-color: #cccccc;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s51 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: right;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s1 {
            background-color: #ffffff;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: top;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s5 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 8pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .body-relatorio {
            width: 100%;
            height: 80%;
        }
    </style>
</head>

<body>
    <div class="ritz grid-container" dir="ltr">
        <div class="title-relatorio"><br />
            <strong>Anexo VIII</strong><br />
            <strong>Fundo Manutenção e Desenvolvimento da Educação Básica e de Valorização Dos Profissionais da Educação - FUNDEB</strong><br />
            <strong> (Art. 212 - A DA CR/88, LEIS 9.394/96, 14.113/2020 E IN 05/2012) </strong><br />
        </div>
        <div class="body-relatorio">
            <table class="waffle no-grid" cellspacing="0" cellpadding="0">
                <tr style="height: 20px">
                    <td class="s0" dir="ltr"></td>
                    <td class="s1" dir="ltr"></td>
                    <td class="s1" dir="ltr"></td>
                    <td class="s1" dir="ltr"></td>
                    <td class="s1" dir="ltr"></td>
                    <td class="s1" dir="ltr"></td>
                    <td class="s1" dir="ltr"></td>
                    <td class="s1" dir="ltr"></td>
                    <td class="s1" dir="ltr"></td>
                    <td class="s1" dir="ltr"></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s0" dir="ltr"></td>
                    <td class="s2" dir="ltr">I - RECURSOS</td>
                    <td class="s2" dir="ltr"></td>
                    <td class="s2" dir="ltr"></td>
                    <td class="s2" dir="ltr"></td>
                    <td class="s2" dir="ltr"></td>
                    <td class="s2" dir="ltr"></td>
                    <td class="s2" dir="ltr"></td>
                    <td class="s2" dir="ltr"></td>
                    <td class="s2" dir="ltr"></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s3" dir="ltr"></td>
                    <td class="s4" dir="ltr" colspan="8">NATUREZA DA RECEITA</td>
                    <td class="s4" dir="ltr">VALOR</td>
                </tr>
                <?php
                $nTotalReceitaRecurso = 0;
                foreach ($aReceitasImpostos as $receita) {
                    echo "<tr style='height: 20px'>";
                    echo " <td class='s5' dir='ltr'></td>";
                    if ($receita[1] == 'title') {
                        echo " <td class='s6' dir='ltr' colspan='8'>{$receita[0]}</td>";
                        echo " <td class='s7' dir='ltr'> ";
                    }else{
                        echo " <td class='s9' dir='ltr' colspan='8'>{$receita[0]}</td>";
                        echo " <td class='s10' dir='ltr'> ";
                    }
                    $nReceita = getValorNaturezaReceita($receita[2], $receita[3], $anousu, $dtini, $dtfim, $instits);
                    if ($receita[1] == 'title') {
                        $nTotalReceitaRecurso += $nReceita;
                    }
                    echo db_formatar(abs($nReceita), "f");
                    echo " </td>";
                    echo "</tr>";
                }
                ?>
                <tr style="height: 20px">
                    <td class="s5" dir="ltr"></td>
                    <td class="s21" dir="ltr" colspan="8">3 - TOTAL ( 1 - 2 )</td>
                    <td class="s22" dir="ltr">
                        <?php echo db_formatar($nTotalReceitaRecurso, "f"); ?>
                    </td>
                </tr>
                <tr style="height: 20px">
                    <td class="s5" dir="ltr"></td>
                    <td class="s23 softmerge" dir="ltr">
                        <div class="softmerge-inner" style="width:1019px;left:-1px">4 - DEVOLUÇÃO DE RECURSOS DO FUNDEB, RECEBIDOS EM ATRASO, PARA AS CONTAS DE ORIGEM DOS RECURSOS (CONSULTA 1047710)</div>
                    </td>
                    <td class="s24" dir="ltr"></td>
                    <td class="s24" dir="ltr"></td>
                    <td class="s24" dir="ltr"></td>
                    <td class="s24" dir="ltr"></td>
                    <td class="s24" dir="ltr"></td>
                    <td class="s25" dir="ltr"></td>
                    <td class="s21" dir="ltr"></td>
                    <td class="s22" dir="ltr">
                        <?php
                        $nDevolucaoFundeb = getDevolucaoRecursoFundeb($dtini, $dtfim, $instits);
                        echo db_formatar($nDevolucaoFundeb, "f");
                        ?>
                    </td>
                </tr>

                <tr style="height: 20px">
                    <td class="s5" dir="ltr"></td>
                    <td class="s23 softmerge" dir="ltr">
                        <div class="softmerge-inner" style="width:198px;left:-1px">5 - RECEITA TOTAL (3 - 4)</div>
                    </td>
                    <td class="s25" dir="ltr"></td>
                    <td class="s25" dir="ltr"></td>
                    <td class="s26" dir="ltr"></td>
                    <td class="s26" dir="ltr"></td>
                    <td class="s26" dir="ltr"></td>
                    <td class="s26" dir="ltr"></td>
                    <td class="s21" dir="ltr"></td>
                    <td class="s22" dir="ltr">
                        <?php
                        $nReceitaTotalFundeb = $nTotalReceitaRecurso - $nDevolucaoFundeb;
                            echo db_formatar($nReceitaTotalFundeb, "f");
                        ?>
                    </td>
                </tr>
                <tr style="height: 20px">
                    <td class="s27"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s0" dir="ltr"></td>
                    <td class="s2" dir="ltr" colspan="9">II - APLICAÇÃO DA EDUCAÇÃO BÁSICA</td>
                </tr>
                <tr style="height: 20px">
                    <td class="s3" dir="ltr"></td>
                    <td class="s4" dir="ltr" colspan="5" rowspan="2">FUNÇÃO / SUBFUNÇÃO / PROGRAMA</td>
                    <td class="s29" dir="ltr" colspan="2">DESPESAS CUSTEADAS COM RECURSOS FUNDEB - IMPOSTOS E
                        TRANSFERÊNCIAS DE IMPOSTOS</td>
                    <td class="s29" dir="ltr" colspan="2">DESPESAS CUSTEADAS COM RECURSOS FUNDEB - COMPLEMENTAÇÃO DA
                        UNIÃO - VAAT</td>
                </tr>
                <? if ($anousu > 2022){ ?>
                <tr style="height: 20px">
                    <td class="s3" dir="ltr"></td>
                    <td class="s4" dir="ltr">15400007</td>
                    <td class="s4" dir="ltr">15400000</td>
                    <td class="s4" dir="ltr">15420007</td>
                    <td class="s4" dir="ltr">15420000</td>
                </tr>
                <?} else {?>
                <tr style="height: 20px">
                    <td class="s3" dir="ltr"></td>
                    <td class="s4" dir="ltr">118</td>
                    <td class="s4" dir="ltr">119</td>
                    <td class="s4" dir="ltr">166</td>
                    <td class="s4" dir="ltr">167</td>
                </tr>
                <?}?>
                <?php
                    $pagoFuncao118 = 0;
                    $pagoFuncao119 = 0;
                    $pagoFuncao166 = 0;
                    $pagoFuncao167 = 0;
                    foreach($aFuncoes as $iFuncao){
                        echo "<tr style='height: 20px'>";
                        echo " <td class='s11' dir='ltr'></td>";
                        echo " <td class='s30' dir='ltr' colspan='5'>EDUCAÇÃO</td>";
                        echo " <td class='s31' dir='ltr'></td>";
                        echo " <td class='s31' dir='ltr'></td>";
                        echo " <td class='s31' dir='ltr'></td>";
                        echo " <td class='s31' dir='ltr'></td>";
                        if($anousu > 2022)
                            $aSubFuncoes = getSaldoDespesa(null, "o58_subfuncao, o58_anousu, coalesce(sum(pago),0) as pago ", null, "o58_funcao = {$iFuncao} and o15_codigo in (".implode(",",array("'118','119','166','167','1118','1119','1166','1167','15400007','15400000','15420007','15420000'")).") and o58_instit in ($instits) group by 1,2 order by 1");
                        else
                            $aSubFuncoes = getSaldoDespesa(null, "o58_subfuncao, o58_anousu, coalesce(sum(pago),0) as pago ", null, "o58_funcao = {$iFuncao} and o15_codtri in (".implode(",",array("'118','119','166','167'")).") and o58_instit in ($instits) group by 1,2 order by 1");
                        foreach ($aSubFuncoes as $oSubFuncao) {
                            $sDescrSubfuncao = db_utils::fieldsMemory(db_query("select o53_descr from orcsubfuncao where o53_codtri = '{$oSubFuncao->o58_subfuncao}'"), 0)->o53_descr;

                            echo "<tr style='height: 20px'> ";
                            echo " <td class='s8' dir='ltr'></td>";
                            echo " <td class='s9' dir='ltr' colspan='5'>{$oSubFuncao->o58_subfuncao} - {$sDescrSubfuncao}</td>";
                            if($anousu > 2022){
                                $aSubFuncao118 = getSaldoDespesa(null, "o58_subfuncao, o58_anousu, coalesce(sum(pago),0) as pago ", null, "o58_funcao = {$iFuncao} and o58_subfuncao in ({$oSubFuncao->o58_subfuncao}) and o15_codigo in (".implode(",",array("'118','1118','15400007'")).") and o58_instit in ($instits) group by 1,2 order by 1");
                                $nValorPagoSubFuncao118 = count( $aSubFuncao118) > 0 ? $aSubFuncao118[0]->pago : 0;
                                $pagoFuncao118 += $nValorPagoSubFuncao118;
                                $aSubFuncao119 = getSaldoDespesa(null, "o58_subfuncao, o58_anousu, coalesce(sum(pago),0) as pago ", null, "o58_funcao = {$iFuncao} and o58_subfuncao in ({$oSubFuncao->o58_subfuncao}) and o15_codigo in (".implode(",",array("'119','1119','15400000'")).") and o58_instit in ($instits) group by 1,2 order by 1");
                                $nValorPagoSubFuncao119 = count( $aSubFuncao119) > 0 ? $aSubFuncao119[0]->pago : 0;
                                $pagoFuncao119 += $nValorPagoSubFuncao119;
                                $aSubFuncao166 = getSaldoDespesa(null, "o58_subfuncao, o58_anousu, coalesce(sum(pago),0) as pago ", null, "o58_funcao = {$iFuncao} and o58_subfuncao in ({$oSubFuncao->o58_subfuncao}) and o15_codigo in (".implode(",",array("'166','1166','15420007'")).") and o58_instit in ($instits) group by 1,2 order by 1");
                                $nValorPagoSubFuncao166 = count( $aSubFuncao166) > 0 ? $aSubFuncao166[0]->pago : 0;
                                $pagoFuncao166 += $nValorPagoSubFuncao166;
                                $aSubFuncao167 = getSaldoDespesa(null, "o58_subfuncao, o58_anousu, coalesce(sum(pago),0) as pago ", null, "o58_funcao = {$iFuncao} and o58_subfuncao in ({$oSubFuncao->o58_subfuncao}) and o15_codigo in (".implode(",",array("'167','1167','15420000'")).") and o58_instit in ($instits) group by 1,2 order by 1");
                                $nValorPagoSubFuncao167 = count( $aSubFuncao167) > 0 ? $aSubFuncao167[0]->pago : 0;
                                $pagoFuncao167 += $nValorPagoSubFuncao167;

                            }else{
                                $aSubFuncao118 = getSaldoDespesa(null, "o58_subfuncao, o58_anousu, coalesce(sum(pago),0) as pago ", null, "o58_funcao = {$iFuncao} and o58_subfuncao in ({$oSubFuncao->o58_subfuncao}) and o15_codtri in (".implode(",",array("'118'")).") and o58_instit in ($instits) group by 1,2 order by 1");
                                $nValorPagoSubFuncao118 = count( $aSubFuncao118) > 0 ? $aSubFuncao118[0]->pago : 0;
                                $pagoFuncao118 += $nValorPagoSubFuncao118;
                                $aSubFuncao119 = getSaldoDespesa(null, "o58_subfuncao, o58_anousu, coalesce(sum(pago),0) as pago ", null, "o58_funcao = {$iFuncao} and o58_subfuncao in ({$oSubFuncao->o58_subfuncao}) and o15_codtri in (".implode(",",array("'119'")).") and o58_instit in ($instits) group by 1,2 order by 1");
                                $nValorPagoSubFuncao119 = count( $aSubFuncao119) > 0 ? $aSubFuncao119[0]->pago : 0;
                                $pagoFuncao119 += $nValorPagoSubFuncao119;
                                $aSubFuncao166 = getSaldoDespesa(null, "o58_subfuncao, o58_anousu, coalesce(sum(pago),0) as pago ", null, "o58_funcao = {$iFuncao} and o58_subfuncao in ({$oSubFuncao->o58_subfuncao}) and o15_codtri in (".implode(",",array("'166'")).") and o58_instit in ($instits) group by 1,2 order by 1");
                                $nValorPagoSubFuncao166 = count( $aSubFuncao166) > 0 ? $aSubFuncao166[0]->pago : 0;
                                $pagoFuncao166 += $nValorPagoSubFuncao166;
                                $aSubFuncao167 = getSaldoDespesa(null, "o58_subfuncao, o58_anousu, coalesce(sum(pago),0) as pago ", null, "o58_funcao = {$iFuncao} and o58_subfuncao in ({$oSubFuncao->o58_subfuncao}) and o15_codtri in (".implode(",",array("'167'")).") and o58_instit in ($instits) group by 1,2 order by 1");
                                $nValorPagoSubFuncao167 = count( $aSubFuncao167) > 0 ? $aSubFuncao167[0]->pago : 0;
                                $pagoFuncao167 += $nValorPagoSubFuncao167;

                            }

                            echo " <td class='s10' dir='ltr'>";
                            echo db_formatar($nValorPagoSubFuncao118, "f");
                            echo " </td>";
                            echo " <td class='s10' dir='ltr'>";
                            echo    db_formatar($nValorPagoSubFuncao119, "f");
                            echo " </td>";
                            echo " <td class='s10' dir='ltr'>";
                            echo    db_formatar($nValorPagoSubFuncao166, "f");
                            echo " </td>";
                            echo " <td class='s10' dir='ltr'>";
                            echo    db_formatar($nValorPagoSubFuncao167, "f");
                            echo " </td>";
                            echo "</tr>";

                            $aDespesasProgramas = getSaldoDespesa(null, "o58_programa, o58_anousu, coalesce(sum(pago),0) as pago ", null, "o58_funcao = {$iFuncao} and o58_subfuncao in ({$oSubFuncao->o58_subfuncao}) and o58_instit in ($instits) group by 1,2");
                            foreach ($aDespesasProgramas as $oDespesaPrograma) {
                                $oPrograma = new Programa($oDespesaPrograma->o58_programa, $oDespesaPrograma->o58_anousu);
                                if($anousu > 2022){
                                    $aPrograma118 = getSaldoDespesa(null, "o15_codtri, o58_anousu, coalesce(sum(pago),0) as pago ", null, "o58_funcao = {$iFuncao} and o58_subfuncao in ({$oSubFuncao->o58_subfuncao}) and o58_programa in ({$oDespesaPrograma->o58_programa}) and o15_codigo in (".implode(",",array("'118','1118','15400007'")).") and o58_instit in ($instits) group by 1,2");
                                    $nValorPagoFonte118 = count( $aPrograma118) > 0 ? $aPrograma118[0]->pago : 0;
                                    $aFonte119 = getSaldoDespesa(null, "o15_codtri, o58_anousu, coalesce(sum(pago),0) as pago ", null, "o58_funcao = {$iFuncao} and o58_subfuncao in ({$oSubFuncao->o58_subfuncao}) and o58_programa in ({$oDespesaPrograma->o58_programa}) and o15_codigo in (".implode(",",array("'119','1119','15400000'")).") and o58_instit in ($instits) group by 1,2");
                                    $nValorPagoFonte119 = count( $aFonte119) > 0 ? $aFonte119[0]->pago : 0;
                                    $aFonte166 = getSaldoDespesa(null, "o15_codtri, o58_anousu, coalesce(sum(pago),0) as pago ", null, "o58_funcao = {$iFuncao} and o58_subfuncao in ({$oSubFuncao->o58_subfuncao}) and o58_programa in ({$oDespesaPrograma->o58_programa}) and o15_codigo in (".implode(",",array("'166','1166','15420007'")).") and o58_instit in ($instits) group by 1,2");
                                    $nValorPagoFonte166 = count( $aFonte166) > 0 ? $aFonte166[0]->pago : 0;
                                    $aFonte167 = getSaldoDespesa(null, "o15_codtri, o58_anousu, coalesce(sum(pago),0) as pago ", null, "o58_funcao = {$iFuncao} and o58_subfuncao in ({$oSubFuncao->o58_subfuncao}) and o58_programa in ({$oDespesaPrograma->o58_programa}) and o15_codigo in (".implode(",",array("'167','1167','15420000'")).") and o58_instit in ($instits) group by 1,2");
                                    $nValorPagoFonte167 = count( $aFonte167) > 0 ? $aFonte167[0]->pago : 0;

                                }else{
                                    $aPrograma118 = getSaldoDespesa(null, "o15_codtri, o58_anousu, coalesce(sum(pago),0) as pago ", null, "o58_funcao = {$iFuncao} and o58_subfuncao in ({$oSubFuncao->o58_subfuncao}) and o58_programa in ({$oDespesaPrograma->o58_programa}) and o15_codtri in (".implode(",",array("'118'")).") and o58_instit in ($instits) group by 1,2");
                                    $nValorPagoFonte118 = count( $aPrograma118) > 0 ? $aPrograma118[0]->pago : 0;
                                    $aFonte119 = getSaldoDespesa(null, "o15_codtri, o58_anousu, coalesce(sum(pago),0) as pago ", null, "o58_funcao = {$iFuncao} and o58_subfuncao in ({$oSubFuncao->o58_subfuncao}) and o58_programa in ({$oDespesaPrograma->o58_programa}) and o15_codtri in (".implode(",",array("'119'")).") and o58_instit in ($instits) group by 1,2");
                                    $nValorPagoFonte119 = count( $aFonte119) > 0 ? $aFonte119[0]->pago : 0;
                                    $aFonte166 = getSaldoDespesa(null, "o15_codtri, o58_anousu, coalesce(sum(pago),0) as pago ", null, "o58_funcao = {$iFuncao} and o58_subfuncao in ({$oSubFuncao->o58_subfuncao}) and o58_programa in ({$oDespesaPrograma->o58_programa}) and o15_codtri in (".implode(",",array("'166'")).") and o58_instit in ($instits) group by 1,2");
                                    $nValorPagoFonte166 = count( $aFonte166) > 0 ? $aFonte166[0]->pago : 0;
                                    $aFonte167 = getSaldoDespesa(null, "o15_codtri, o58_anousu, coalesce(sum(pago),0) as pago ", null, "o58_funcao = {$iFuncao} and o58_subfuncao in ({$oSubFuncao->o58_subfuncao}) and o58_programa in ({$oDespesaPrograma->o58_programa}) and o15_codtri in (".implode(",",array("'167'")).") and o58_instit in ($instits) group by 1,2");
                                    $nValorPagoFonte167 = count( $aFonte167) > 0 ? $aFonte167[0]->pago : 0;

                                }

                                echo "<tr style='height: 20px'>";
                                echo " <td class='s8' dir='ltr'></td>";
                                echo " <td class='s9' dir='ltr' colspan='5' style='padding-left: 10px;'> ";
                                echo db_formatar($oPrograma->getCodigoPrograma(), "programa")." ".$oPrograma->getDescricao();
                                echo " </td>";
                                echo " <td class='s10' dir='ltr'>";
                                echo db_formatar($nValorPagoFonte118, "f");
                                echo " </td>";
                                echo " <td class='s10' dir='ltr'>";
                                echo db_formatar($nValorPagoFonte119, "f");
                                echo " </td>";
                                echo " <td class='s10' dir='ltr'>";
                                echo db_formatar($nValorPagoFonte166, "f");
                                echo " </td>";
                                echo " <td class='s10' dir='ltr'>";
                                echo db_formatar($nValorPagoFonte167, "f");
                                echo " </td>";
                                echo "</tr>";
                            }
                        }
                    }
                ?>
                <tr style="height: 20px">
                    <td class="s5" dir="ltr"></td>
                    <td class="s21" dir="ltr" colspan="5" style="border-top: 1px SOLID #000000;">6 - SUBTOTAL VALOR PAGO</td>
                    <td class="s22" dir="ltr" style="border-top: 1px SOLID #000000;" ><?php echo db_formatar($pagoFuncao118, "f"); ?></td>
                    <td class="s22" dir="ltr" style="border-top: 1px SOLID #000000;" ><?php echo db_formatar($pagoFuncao119, "f"); ?></td>
                    <td class="s22" dir="ltr" style="border-top: 1px SOLID #000000;" ><?php echo db_formatar($pagoFuncao166, "f"); ?></td>
                    <td class="s22" dir="ltr" style="border-top: 1px SOLID #000000;" ><?php echo db_formatar($pagoFuncao167, "f"); ?></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s35"></td>
                    <td class="s19" colspan="9"></td>
                </tr>
                <? if ($anousu > 2022){ ?>
                <tr style="height: 20px">
                    <td class="s35"></td>
                    <td class="s36" colspan="5"></td>
                    <td class="s37" dir="ltr" style='border-left: 1px SOLID #000000;'>INSCRITAS NA FONTE 15400007</td>
                    <td class="s37" dir="ltr" style='border-left: 1px SOLID #000000;'>INSCRITAS NA FONTE 15400000</td>
                    <td class="s37" dir="ltr" style='border-left: 1px SOLID #000000;'>INSCRITAS NA FONTE 15420007</td>
                    <td class="s4" dir="ltr"  style='border-left: 1px SOLID #000000;'>INSCRITAS NA FONTE 15420000</td>
                </tr>
                <?} else {?>
                <tr style="height: 20px">
                    <td class="s35"></td>
                    <td class="s36" colspan="5"></td>
                    <td class="s37" dir="ltr" style='border-left: 1px SOLID #000000;'>INSCRITAS NA FONTE 118</td>
                    <td class="s37" dir="ltr" style='border-left: 1px SOLID #000000;'>INSCRITAS NA FONTE 119</td>
                    <td class="s37" dir="ltr" style='border-left: 1px SOLID #000000;'>INSCRITAS NA FONTE 166</td>
                    <td class="s4" dir="ltr"  style='border-left: 1px SOLID #000000;'>INSCRITAS NA FONTE 167</td>
                </tr>
                <?}?>
                <tr style="height: 20px">
                    <td class="s32" dir="ltr"></td>
                    <td class="s33" dir="ltr" colspan="5">7 - RESTOS A PAGAR PROCESSADOS DO EXERCÍCIO</td>
                    <?php
                        $nLiqAPagar118 = 0;
                        $nLiqAPagar119 = 0;
                        $nLiqAPagar166 = 0;
                        $nLiqAPagar167 = 0;
                        $dtfimExercicio = db_getsession("DB_anousu")."-12-31";
                        if($dtfim == $dtfimExercicio){
                            $nLiqAPagar118 = getEmpenhosApagar(array("'118','1118','15400007'"), $dtini, $dtfim, $instits, 'lqd');
                            $nLiqAPagar119 = getEmpenhosApagar(array("'119','1119','15400000'"), $dtini, $dtfim, $instits, 'lqd');
                            $nLiqAPagar166 = getEmpenhosApagar(array("'166','1166','15420007'"), $dtini, $dtfim, $instits, 'lqd');
                            $nLiqAPagar167 = getEmpenhosApagar(array("'167','1167','15420000'"), $dtini, $dtfim, $instits, 'lqd');

                        }
                        echo "<td class='s10' dir='ltr' >";
                        echo db_formatar($nLiqAPagar118, "f");
                        echo "</td>";
                        echo "<td class='s10' dir='ltr'>";
                        echo db_formatar($nLiqAPagar119, "f");
                        echo "</td>";
                        echo "<td class='s10' dir='ltr'>";
                        echo db_formatar($nLiqAPagar166, "f");
                        echo "</td>";
                        echo "<td class='s10' dir='ltr'>";
                        echo db_formatar($nLiqAPagar167, "f");
                        echo "</td>";
                    ?>

                </tr>
                <tr style="height: 20px">
                    <td class="s32" dir="ltr"></td>
                    <td class="s34" dir="ltr" colspan="5">8 - RESTOS A PAGAR NÃO PROCESSADOS DO EXERCÍCIO</td>
                    <?php
                        $nNaoLiqAPagar118 = 0;
                        $nNaoLiqAPagar119 = 0;
                        $nNaoLiqAPagar166 = 0;
                        $nNaoLiqAPagar167 = 0;
                        $dtfimExercicio = db_getsession("DB_anousu")."-12-31";
                        if($dtfim == $dtfimExercicio){
                            $nNaoLiqAPagar118 = getEmpenhosApagar(array("'118','1118','15400007'"), $dtini, $dtfim, $instits, '');
                            $nNaoLiqAPagar119 = getEmpenhosApagar(array("'119','1119','15400000'"), $dtini, $dtfim, $instits, '');
                            $nNaoLiqAPagar166 = getEmpenhosApagar(array("'166','1166','15420007'"), $dtini, $dtfim, $instits, '');
                            $nNaoLiqAPagar167 = getEmpenhosApagar(array("'167','1167','15420000'"), $dtini, $dtfim, $instits, '');

                        }
                        echo "<td class='s38' dir='ltr'>";
                        echo db_formatar($nNaoLiqAPagar118, "f");
                        echo "</td>";
                        echo "<td class='s38' dir='ltr'>";
                        echo db_formatar($nNaoLiqAPagar119, "f");
                        echo "</td>";
                        echo "<td class='s38' dir='ltr'>";
                        echo db_formatar($nNaoLiqAPagar166, "f");
                        echo "</td>";
                        echo "<td class='s38' dir='ltr'>";
                        echo db_formatar($nNaoLiqAPagar167, "f");
                        echo "</td>";
                        $aTotalPago118 = $nLiqAPagar118 + $nNaoLiqAPagar118;
                        $aTotalPago119 = $nLiqAPagar119 + $nNaoLiqAPagar119;
                        $aTotalPago166 = $nLiqAPagar166 + $nNaoLiqAPagar166;
                        $aTotalPago167 = $nLiqAPagar167 + $nNaoLiqAPagar167;
                    ?>
                </tr>
                <tr style="height: 20px">
                    <td class="s5" dir="ltr"></td>
                    <td class="s21" dir="ltr" colspan="5">9 - SUBTOTAL RESTOS A PAGAR (7 + 8)</td>
                    <?php
                        echo "<td class='s22' dir='ltr'>";
                        echo db_formatar($aTotalPago118,"f");
                        echo "</td>";
                        echo "<td class='s22' dir='ltr'>";
                        echo db_formatar($aTotalPago119,"f");
                        echo "</td>";
                        echo "<td class='s22' dir='ltr'>";
                        echo db_formatar($aTotalPago166,"f");
                        echo "</td>";
                        echo "<td class='s22' dir='ltr'>";
                        echo db_formatar($aTotalPago167,"f");
                        echo "</td>";
                    ?>
                </tr>
                <tr style="height: 20px">
                    <td class="s5" dir="ltr"></td>
                    <td class="s21" dir="ltr" colspan="5">10 - TOTAL (6 + 9)</td>
                    <?php
                        echo "<td class='s22' dir='ltr'>";
                        $nTotalPagoItem10Fonte118 = $pagoFuncao118 + $aTotalPago118;
                        echo db_formatar($nTotalPagoItem10Fonte118, "f");
                        echo "</td>";
                        echo "<td class='s22' dir='ltr'>";
                        $nTotalPagoItem10Fonte119 = $pagoFuncao119 + $aTotalPago119;
                        echo db_formatar($nTotalPagoItem10Fonte119, "f");
                        echo "</td>";
                        echo "<td class='s22' dir='ltr'>";
                        $nTotalPagoItem10Fonte166 = $pagoFuncao166 + $aTotalPago166;
                        echo db_formatar($nTotalPagoItem10Fonte166, "f");
                        echo "</td>";
                        echo "<td class='s22' dir='ltr'>";
                        $nTotalPagoItem10Fonte167 = $pagoFuncao167 + $aTotalPago167;
                        echo db_formatar($nTotalPagoItem10Fonte167, "f");
                        echo "</td>";
                    ?>
                </tr>
                <tr style="height: 20px">
                    <td class="s39"></td>
                    <td class="s40"></td>
                    <td class="s40"></td>
                    <td class="s40"></td>
                    <td class="s40"></td>
                    <td class="s40"></td>
                    <td class="s40"></td>
                    <td class="s40"></td>
                    <td class="s40"></td>
                    <td class="s19"></td>
                </tr>
                <? if ($anousu > 2022){ ?>
                <tr style="height: 20px">
                    <td class="s35"></td>
                    <td class="s41" colspan="5"></td>
                    <td class="s42" dir="ltr" style='border-left: 1px SOLID #000000;'>INSCRITOS NA FONTE 15400007 (A)</td>
                    <td class="s43" dir="ltr" style='border-left: 1px SOLID #000000;'>INSCRITOS NA FONTE 15400000 (B)</td>
                    <td class="s44" dir="ltr" style='border-left: 1px SOLID #000000;'>INSCRITOS NA FONTE 15420007 (D)</td>
                    <td class="s44" dir="ltr" style='border-left: 1px SOLID #000000;'>INSCRITOS NA FONTE 15420000 (E)</td>
                </tr>
                <? } else { ?>
                <tr style="height: 20px">
                    <td class="s35"></td>
                    <td class="s41" colspan="5"></td>
                    <td class="s42" dir="ltr" style='border-left: 1px SOLID #000000;'>INSCRITOS NA FONTE 118 (A)</td>
                    <td class="s43" dir="ltr" style='border-left: 1px SOLID #000000;'>INSCRITOS NA FONTE 119 (B)</td>
                    <td class="s44" dir="ltr" style='border-left: 1px SOLID #000000;'>INSCRITOS NA FONTE 166 (D)</td>
                    <td class="s44" dir="ltr" style='border-left: 1px SOLID #000000;'>INSCRITOS NA FONTE 167 (E)</td>
                </tr>
                <? } ?>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s12" dir="ltr" colspan="5">11 - RESTOS A PAGAR INSCRITOS NO EXERCÍCIO SEM DISPONIBILIDADE FINANCEIRA</td>
                    <?php
                        $nRPIncritosSemDesponibilidade119 = 0;
                        $nRPIncritosSemDesponibilidade166 = 0;
                        $nRPIncritosSemDesponibilidade118 = 0;
                        $nRPIncritosSemDesponibilidade167 = 0;
                        $nRPIncritosSemDesponibilidadeTotal = 0;
                        if($dtfim == $dtfimExercicio){

                            $nSaldoFonteAno118 = getSaldoPlanoContaFonte("'118','1118','15400007','119','1119','15400000','166','1166','15420007','167','1167','15420000'", $dtini, $dtfim, $instits);

                            $dtfimExercicio = db_getsession("DB_anousu")."-12-31";
                            $nRPSemDesponibilidade118 = $aTotalPago118 - $nSaldoFonteAno118;
                            $nRPSemDesponibilidade119 = $aTotalPago119 - $nSaldoFonteAno118;
                            $nRPSemDesponibilidade166 = $aTotalPago166 - $nSaldoFonteAno118;
                            $nRPSemDesponibilidade167 = $aTotalPago167 - $nSaldoFonteAno118;

                            $nRPIncritosSemDesponibilidadeTotal = $aTotalPago118 + $aTotalPago119 + $aTotalPago166 + $aTotalPago167 - $nSaldoFonteAno118;

                            if($nRPIncritosSemDesponibilidadeTotal > 0){

                                $nSaldoFonteAno118 = getSaldoPlanoContaFonte("'118','1118','15400007'", $dtini, $dtfim, $instits);
                                $nSaldoFonteAno119 = getSaldoPlanoContaFonte("'119','1119','15400000'", $dtini, $dtfim, $instits);
                                $nSaldoFonteAno166 = getSaldoPlanoContaFonte("'166','1166','15420007'", $dtini, $dtfim, $instits);
                                $nSaldoFonteAno167 = getSaldoPlanoContaFonte("'167','1167','15420000'", $dtini, $dtfim, $instits);

                                $dtfimExercicio = db_getsession("DB_anousu")."-12-31";
                                $nRPSemDesponibilidade118 = $aTotalPago118 - $nSaldoFonteAno118;
                                $nRPSemDesponibilidade119 = $aTotalPago119 - $nSaldoFonteAno119;
                                $nRPSemDesponibilidade166 = $aTotalPago166 - $nSaldoFonteAno166;
                                $nRPSemDesponibilidade167 = $aTotalPago167 - $nSaldoFonteAno167;
                            }

                            if($nRPSemDesponibilidade118 > 0){
                                $nRPIncritosSemDesponibilidade118 = $nRPSemDesponibilidade118;
                            }
                            if($nRPSemDesponibilidade119 > 0){
                                $nRPIncritosSemDesponibilidade119 = $nRPSemDesponibilidade119;
                            }
                            if($nRPSemDesponibilidade166 > 0){
                                $nRPIncritosSemDesponibilidade166 = $nRPSemDesponibilidade166;
                            }
                            if($nRPSemDesponibilidade167 > 0){
                                $nRPIncritosSemDesponibilidade167 = $nRPSemDesponibilidade167;
                            }
                        }
                    ?>
                    <td class="s10" dir="ltr"><?php echo db_formatar($nRPIncritosSemDesponibilidade118,"f"); ?></td>
                    <td class="s10" dir="ltr"><?php echo db_formatar($nRPIncritosSemDesponibilidade119,"f"); ?></td>
                    <td class="s10" dir="ltr"><?php echo db_formatar($nRPIncritosSemDesponibilidade166,"f"); ?></td>
                    <td class="s10" dir="ltr"><?php echo db_formatar($nRPIncritosSemDesponibilidade167,"f"); ?></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s8" dir="ltr"></td>
                    <td class="s45" dir="ltr" colspan="5">12 - RESTOS A PAGAR DE EXERCÍCIOS ANTERIORES SEM DISPONIBILIDADE
                        FINANCEIRA PAGOS NO EXERCÍCIO ATUAL (CONSULTA 932736)</td>
                    <?php

                        $nRPNPAnteriorSemDispFonte118 = getRestosSemDisponilibidadeFundeb(array("'118','119','1118','1119','15400007','15400000'"), $dtini, $dtfim, $instits);
                        $nRPNPAnteriorSemDispFonte119 = 0;//getRestosSemDisponilibidade(array("'15400000'"), $dtini, $dtfim, $instits);
                        $nRPNPAnteriorSemDispFonte166 = getRestosSemDisponilibidadeFundeb(array("'166','1166','15420007'"), $dtini, $dtfim, $instits);
                        $nRPNPAnteriorSemDispFonte167 = getRestosSemDisponilibidadeFundeb(array("'167','1167','15420000'"), $dtini, $dtfim, $instits);

                        echo "<td class='s38' dir='ltr'>";
                        echo db_formatar($nRPNPAnteriorSemDispFonte118,"f");
                        echo "</td>";
                        echo "<td class='s38' dir='ltr'>";
                        echo db_formatar($nRPNPAnteriorSemDispFonte119,"f");
                        echo "</td>";
                        echo "<td class='s38' dir='ltr'>";
                        echo db_formatar($nRPNPAnteriorSemDispFonte166,"f");
                        echo "</td>";
                        echo "<td class='s38' dir='ltr'>";
                        echo db_formatar($nRPNPAnteriorSemDispFonte167,"f");
                        echo "</td>";
                    ?>
                </tr>
                <tr style="height: 20px">
                    <td class="s5" dir="ltr"></td>
                    <td class="s47" dir="ltr" colspan="5">13 - TOTAL (10 - 11 + 12)</td>
                    <?php
                        $nTotalPagoItem13Fonte118 =  ($nTotalPagoItem10Fonte118 - $nRPIncritosSemDesponibilidade118) + ($nRPNPAnteriorSemDispFonte118);
                        $nTotalPagoItem13Fonte119 =  ($nTotalPagoItem10Fonte119 - $nRPIncritosSemDesponibilidade119) + ($nRPNPAnteriorSemDispFonte119);
                        $nTotalPagoItem13Fonte166 =  ($nTotalPagoItem10Fonte166 - $nRPIncritosSemDesponibilidade166) + ($nRPNPAnteriorSemDispFonte166);
                        $nTotalPagoItem13Fonte167 =  ($nTotalPagoItem10Fonte167 - $nRPIncritosSemDesponibilidade167) + ($nRPNPAnteriorSemDispFonte167);

                        echo "<td class='s48' dir='ltr'>";
                        echo db_formatar($nTotalPagoItem13Fonte118,"f");
                        echo "</td>";
                        echo "<td class='s48' dir='ltr'>";
                        echo db_formatar($nTotalPagoItem13Fonte119,"f");
                        echo "</td>";
                        echo "<td class='s48' dir='ltr'>";
                        echo db_formatar($nTotalPagoItem13Fonte166,"f");
                        echo "</td>";
                        echo "<td class='s22' dir='ltr'>";
                        echo db_formatar($nTotalPagoItem13Fonte167,"f");
                        echo "</td>";
                    ?>
                </tr>
                <tr style="height: 20px">
                    <td class="s27"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s27"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                </tr>
                <tr style="height: 20px">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="height: 20px">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="height: 20px">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="height: 20px">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="height: 20px">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s27"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s27"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s27"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                </tr>
            </table>
        </div>
        <div class="body-relatorio">
            <table class="waffle no-grid" cellspacing="0" cellpadding="0" style="padding-top: 50px;">
                <tr style="height: 20px">
                    <td class="s0" dir="ltr"></td>
                    <td class="s2" dir="ltr" colspan="9">III - GASTOS COM PROFISSIONAIS DA EDUCAÇÃO BÁSICA EM EFETIVO EXERCÍCIO</td>
                </tr>
                <tr style="height: 20px">
                    <td class="s3" dir="ltr"></td>
                    <td class="s4" dir="ltr" colspan="7">DESCRIÇÃO</td>
                    <td class="s4" dir="ltr">NO EXERCÍCIO</td>
                    <td class="s4" dir="ltr">PERCENTUAL</td>
                </tr>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s12" dir="ltr" colspan="7">14 - RECEITA TOTAL DO FUNDEB (= 5)</td>
                    <td class="s10" dir="ltr"><?php echo db_formatar($nReceitaTotalFundeb, "f");?></td>
                    <td class="s10" dir="ltr">100%</td>
                </tr>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s19" dir="ltr" colspan="7">15 - VALOR LEGAL MÍNIMO</td>
                    <td class="s20" dir="ltr"><?php echo db_formatar($nReceitaTotalFundeb * 0.70, "f");?></td>
                    <td class="s20" dir="ltr">70%</td>
                </tr>
                <tr style="height: 20px">
                    <td class="s5" dir="ltr"></td>
                    <td class="s21" dir="ltr" colspan="7">16 - VALOR APLICADO NA REMUNERAÇÃO DE PROFISSIONAIS DA
                        EDUCAÇÃO BÁSICA - FONTES <? if ($anousu > 2022) {?>15400007 E 15420007 <? }else{?> 118 E 166 <?}?>(13A + 13D)</td>
                        <?php
                            $nTotalAplicadoRemuProfEducBasica = $nTotalPagoItem13Fonte118 + $nTotalPagoItem13Fonte166;
                            echo "<td class='s22' dir='ltr'>"; echo db_formatar($nTotalAplicadoRemuProfEducBasica,"f"); echo "</td>";
                            echo "<td class='s22' dir='ltr'>"; echo db_formatar(($nTotalAplicadoRemuProfEducBasica / $nReceitaTotalFundeb )*100,"f")."%"; echo "</td>";
                        ?>
                </tr>
                <tr style="height: 20px">
                    <td class="s27"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s0" dir="ltr"></td>
                    <td class="s2" dir="ltr" colspan="9">IV - APURAÇÃO DO VALOR NÃO APLICADO, CONFORME ART. 25, §3º
                        DA LEI 14.113/2020</td>
                </tr>
                <tr style="height: 20px">
                    <td class="s3" dir="ltr"></td>
                    <td class="s4" dir="ltr" colspan="6">DESCRIÇÃO</td>
                    <td class="s4" dir="ltr">VALOR</td>
                    <td class="s49" dir="ltr">PERCENTUAL</td>
                    <td class="s50 softmerge" dir="ltr" style='border-left: 1px SOLID #000000; border-right: 1px SOLID #000000;'>
                        <div class="softmerge-inner" style="width:333px;left:-3px">VALOR MÁXIMO PERMITIDO (10%)</div>
                    </td>
                </tr>
                <tr style="height: 20px">
                    <td class="s5" dir="ltr"></td>
                    <td class="s6" dir="ltr" colspan="6">17 - RECURSOS RECEBIDOS DO FUNDEB NO EXERCÍCIO QUE NÃO FORAM
                        UTILIZADOS</td>
                        <?php
                            if ($anousu >=2022){
                                $nFundebImpostosTransferencias = getValorNaturezaReceita(array('413210101%', '413210501%', '417515001%'), "'118','119','1118','1119','15400007','15400000'", $anousu, $dtini, $dtfim, $instits);
                                $nRestosaPagar = $nTotalPagoItem13Fonte118 + $nTotalPagoItem13Fonte119;
                                $nFundebItem171 = $nFundebImpostosTransferencias - $nDevolucaoFundeb - $nRestosaPagar;

                                $nFundebComplementacao = getValorNaturezaReceita(array('413210101%', '413210501%', '417155001%'), "'166','167','1166','1167','15420007','15420000'", $anousu, $dtini, $dtfim, $instits);
                                $nRestosaPagarFonte166_167 = $nTotalPagoItem13Fonte166 + $nTotalPagoItem13Fonte167;
                                $nFundebItem172 = $nFundebComplementacao - $nRestosaPagarFonte166_167;
                            }else{
                                $nFundebImpostosTransferencias = getValorNaturezaReceita(array('413210011%', '413210051%', '417580111%'), "'118','119'", $anousu, $dtini, $dtfim, $instits);
                                $nRestosaPagar = $nTotalPagoItem13Fonte118 + $nTotalPagoItem13Fonte119;
                                $nFundebItem171 = $nFundebImpostosTransferencias - $nDevolucaoFundeb - $nRestosaPagar;

                                $nFundebComplementacao = getValorNaturezaReceita(array('413210011%', '413210051%', '417180911%'), "'166','167'", $anousu, $dtini, $dtfim, $instits);
                                $nRestosaPagarFonte166_167 = $nTotalPagoItem13Fonte166 + $nTotalPagoItem13Fonte167;
                                $nFundebItem172 = $nFundebComplementacao - $nRestosaPagarFonte166_167;

                            }
                        ?>
                    <td class="s7" dir="ltr"><?php echo db_formatar($nFundebItem171 + $nFundebItem172,"f"); ?></td>
                    <td class="s7" dir="ltr"><?php echo db_formatar((($nFundebItem171 + $nFundebItem172) / $nReceitaTotalFundeb) * 100,"f")."%";?></td>
                    <td class="s7" dir="ltr"><?php echo db_formatar( ($nReceitaTotalFundeb * 0.10),"f") ?></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s12" dir="ltr" colspan="6" >17.1 - FUNDEB - IMPOSTOS E TRANSFERÊNCIAS DE IMPOSTOS (1 - 4 - 13A - 13B)</td>
                    <td class="s10" dir="ltr"><?php echo db_formatar($nFundebItem171,"f"); ?></td>
                    <td class="s10" dir="ltr"><?php echo db_formatar(($nFundebItem171 / $nReceitaTotalFundeb) * 100,"f")."%";?></td>
                    <td class="s6" dir="ltr"></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s19" dir="ltr" colspan="6">17.2 - FUNDEB - COMPLEMENTAÇÃO DA UNIÃO - VAAT (2 - 13D - 13E)
                    </td>
                    <td class="s20" dir="ltr"><?php echo db_formatar($nFundebItem172,"f");?></td>
                    <td class="s20" dir="ltr"><?php echo db_formatar(($nFundebItem172 / $nReceitaTotalFundeb) * 100,"f")."%";?></td>
                    <td class="s6" dir="ltr" style='border-bottom: 1px SOLID #000000;'></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s27"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s0" dir="ltr"></td>
                    <td class="s2" dir="ltr" colspan="9">V - VALOR MÍNIMO LEGAL DA COMPLEMENTAÇÃO DA UNIÃO AO FUNDEB -
                        VAAT EM DESPESA DE CAPITAL</td>
                </tr>
                <tr style="height: 20px">
                    <td class="s3" dir="ltr"></td>
                    <td class="s4" dir="ltr" colspan="6">DESCRIÇÃO</td>
                    <td class="s4" dir="ltr" colspan="2">NO EXERCÍCIO</td>
                    <td class="s4" dir="ltr">PERCENTUAL</td>
                </tr>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s12" dir="ltr" colspan="6">18 - FUNDEB - COMPLEMENTAÇÃO DA UNIÃO - VAAT (= 2)</td>
                    <td class="s10" dir="ltr" colspan="2"><?php echo db_formatar($nFundebComplementacao,"f"); ?></td>
                    <td class="s10" dir="ltr">100%</td>
                </tr>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s12" dir="ltr" colspan="6">19 - VALOR MÍNIMO LEGAL</td>
                    <td class="s10" dir="ltr" colspan="2"><?php echo db_formatar(($nFundebComplementacao * 0.15),"f"); ?></td>
                    <td class="s10" dir="ltr">15%</td>
                </tr>
                <?php
                    $nFundebComplementacaoAplicadoEmpenho = getPagamentoComplementacaoCapital($dtini, $dtfim, $instits);
                    $nFundebComplementacaoAplicadoRestosaPagar = getRestosaPagarComplementacaoCapital($dtini, $dtfim, $instits);
                    $TotalAplicadoItem20 = $nFundebComplementacaoAplicadoEmpenho+$nFundebComplementacaoAplicadoRestosaPagar;
                ?>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s12" dir="ltr" colspan="6">20 - TOTAL APLICADO</td>
                    <td class="s10" dir="ltr" colspan="2"><?php echo db_formatar($TotalAplicadoItem20,"f"); ?></td>
                    <td class="s31" dir="ltr"></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s12" dir="ltr" colspan="6" style="padding-left: 20px;">20.1 - VALOR PAGO</td>
                    <td class="s10" dir="ltr" colspan="2"><?php echo db_formatar($nFundebComplementacaoAplicadoEmpenho,"f"); ?></td>
                    <td class="s31" dir="ltr"></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s12" dir="ltr" colspan="6" style="padding-left: 20px;">20.2 - RESTOS A PAGAR (PROCESSADOS E NÃO PROCESSADOS)</td>
                    <td class="s10" dir="ltr" colspan="2"><?php echo db_formatar($nFundebComplementacaoAplicadoRestosaPagar,"f"); ?></td>
                    <td class="s31" dir="ltr"></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s12" dir="ltr" colspan="6">21 - RESTOS A PAGAR INSCRITOS NO EXERCÍCIO SEM DISPONIBILIDADE
                        FINANCEIRA</td>
                    <td class="s31" dir="ltr" colspan="2"></td>
                    <td class="s31" dir="ltr"></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s45" dir="ltr" colspan="6">22 - RESTOS A PAGAR DE EXERCÍCIOS ANTERIORES SEM DISPONIBILIDADE
                        FINANCEIRA PAGOS NO EXERCÍCIO ATUAL (CONSULTA 932736)</td>
                    <td class="s51" dir="ltr" colspan="2"></td>
                    <td class="s51" dir="ltr"></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s5" dir="ltr"></td>
                    <td class="s21" dir="ltr" colspan="6">23 -TOTAL DE GASTOS COM DESPESA DE CAPITAL (20 - 21 + 22 )</td>
                    <td class="s22" dir="ltr" colspan="2"><?php echo db_formatar($TotalAplicadoItem20,"f"); ?></td>
                    <td class="s22" dir="ltr"><?php echo db_formatar(($TotalAplicadoItem20/$nFundebComplementacao)*100,"f")."%"; ?></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s27"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s52"></td>
                    <td class="s52"></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s0" dir="ltr"></td>
                    <td class="s2" dir="ltr" colspan="9">VI - VALOR MÍNIMO LEGAL DA COMPLEMENTAÇÃO DA UNIÃO AO FUNDEB -
                        VAAT EM EDUCAÇÃO INFANTIL</td>
                </tr>
                <tr style="height: 20px">
                    <td class="s3" dir="ltr"></td>
                    <td class="s4" dir="ltr" colspan="6">DESCRIÇÃO</td>
                    <td class="s4" dir="ltr" colspan="2">NO EXERCÍCIO</td>
                    <td class="s4" dir="ltr">PERCENTUAL</td>
                </tr>
                <?php
                    $nFundebComplementacaoAplicadoEmpenho = getPagamentoComplementacaoInfantil($dtini, $dtfim, $instits);
                    $nFundebComplementacaoAplicadoRestosaPagar = getRestosaPagarComplementacaoInfantil($dtini, $dtfim, $instits);
                    $nTotalAPlicadoItem26 = $nFundebComplementacaoAplicadoEmpenho + $nFundebComplementacaoAplicadoRestosaPagar;
                ?>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s12" dir="ltr" colspan="6">24 - FUNDEB - COMPLEMENTAÇÃO DA UNIÃO - VAAT (= 2)</td>
                    <td class="s10" dir="ltr" colspan="2"><?php echo db_formatar($nFundebComplementacao,"f"); ?></td>
                    <td class="s10" dir="ltr">100%</td>
                </tr>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s12" dir="ltr" colspan="6">25 - VALOR MÍNIMO LEGAL</td>
                    <td class="s10" dir="ltr" colspan="2"><?php echo db_formatar($nFundebComplementacao * 0.5,"f"); ?></td>
                    <td class="s10" dir="ltr">50%</td>
                </tr>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s12" dir="ltr" colspan="6">26 - TOTAL APLICADO</td>
                    <td class="s10" dir="ltr" colspan="2"><?php echo db_formatar($nTotalAPlicadoItem26,"f"); ?></td>
                    <td class="s31" dir="ltr"></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s12" dir="ltr" colspan="6" style="padding-left: 20px;">26.1 - VALOR PAGO</td>
                    <td class="s10" dir="ltr" colspan="2"><?php echo db_formatar($nFundebComplementacaoAplicadoEmpenho,"f"); ?></td>
                    <td class="s31" dir="ltr"></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s12" dir="ltr" colspan="6" style="padding-left: 20px;">26.2 - RESTOS A PAGAR (PROCESSADOS E NÃO PROCESSADOS)</td>
                    <td class="s10" dir="ltr" colspan="2"><?php echo db_formatar($nFundebComplementacaoAplicadoRestosaPagar,"f"); ?></td>
                    <td class="s31" dir="ltr"></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s12" dir="ltr" colspan="6">27 - RESTOS A PAGAR INSCRITOS NO EXERCÍCIO SEM DISPONIBILIDADE
                        FINANCEIRA</td>
                    <td class="s31" dir="ltr" colspan="2"></td>
                    <td class="s31" dir="ltr"></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s45" dir="ltr" colspan="6">28 - RESTOS A PAGAR DE EXERCÍCIOS ANTERIORES SEM DISPONIBILIDADE
                        DE CAIXA PAGOS NO EXERCÍCIO ATUAL (CONSULTA 932736)</td>
                    <td class="s51" dir="ltr" colspan="2"></td>
                    <td class="s51" dir="ltr"></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s5" dir="ltr"></td>
                    <td class="s21" dir="ltr" colspan="6">29 -TOTAL DE GASTOS COM EDUCAÇÃO INFANTIL (26 - 27 + 28 )</td>
                    <td class="s22" dir="ltr" colspan="2"><?php echo db_formatar($nTotalAPlicadoItem26,"f"); ?></td>
                    <td class="s22" dir="ltr"><?php echo db_formatar(($nTotalAPlicadoItem26/$nFundebComplementacao)*100,"f")."%"; ?></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s27"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                    <td class="s28"></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s0" dir="ltr"></td>
                    <td class="s2" dir="ltr" colspan="7">VII - CONTROLE DA UTILIZAÇÃO DE RECURSOS RECEBIDOS EM EXERCÍCIOS
                        ANTERIORES E NÃO UTILIZADOS (SUPERÁVIT)</td>
                    <td class="s40"></td>
                    <td class="s40"></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s3" dir="ltr"></td>
                    <td class="s4" dir="ltr" colspan="6">DESCRIÇÃO</td>
                    <td class="s29" dir="ltr">FUNDEB - IMPOSTOS E TRANSFERÊNCIAS DE IMPOSTOS</td>
                    <td class="s44" dir="ltr">FUNDEB - COMPLEMENTAÇÃO DA UNIÃO - VAAT</td>
                    <td class="s53" dir="ltr">TOTAL</td>
                </tr>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s28" dir="ltr" colspan="5">30 - VALOR DO SUPERÁVIT PERMITIDO NO EXERCICIO ANTERIOR (5% DO
                        VALOR RECEBIDO DE RECEITA)</td>
                    <td class="s12"></td>
                    <td class="s31" dir="ltr"></td>
                    <td class="s31" dir="ltr"></td>
                    <td class="s10" dir="ltr"><?php echo db_formatar($oDadosexecicioanterior->c235_superavit_fundeb_permitido,"f"); ?></td>
                </tr>
                <?php
                    $nValorNaoAplicadoFundebImpostosTransfAnoAnterior = $oDadosexecicioanterior->c235_naoaplicfundebimposttransf;
                    $nValorNaoAplicadoFundebComplementacaoAnoAnterior = $oDadosexecicioanterior->c235_naoaplicfundebcompl;
                ?>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s28" dir="ltr" colspan="5">31 - VALOR NÃO APLICADO NO EXERCÍCIO ANTERIOR</td>
                    <td class="s12"></td>
                    <td class="s10" dir="ltr"><?php echo db_formatar($nValorNaoAplicadoFundebImpostosTransfAnoAnterior,"f"); ?></td>
                    <td class="s10" dir="ltr"><?php echo db_formatar($nValorNaoAplicadoFundebComplementacaoAnoAnterior,"f"); ?></td>
                    <td class="s10" dir="ltr"><?php echo db_formatar($nValorNaoAplicadoFundebImpostosTransfAnoAnterior+$nValorNaoAplicadoFundebComplementacaoAnoAnterior,"f"); ?></td>
                </tr>
                <?php
                        $nValorAPlicadoSuperavit218_219 = getDespesasCusteadosComSuperavit(array("'218','219','25400007','25400000'"), $dtini, $dtfim, $instits);
                        $nValorAPlicadoSuperavit266_267 = getDespesasCusteadosComSuperavit(array("'266','267','25420007','25420007'"), $dtini, $dtfim, $instits);
                ?>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s28" dir="ltr" colspan="5">32 - VALOR DE SUPERÁVIT APLICADO ATÉ O PRIMEIRO QUADRIMESTRE
                    </td>
                    <td class="s12"></td>
                    <td class="s10" dir="ltr"><?php echo db_formatar($nValorAPlicadoSuperavit218_219,"f"); ?></td>
                    <td class="s10" dir="ltr"><?php echo db_formatar($nValorAPlicadoSuperavit266_267,"f"); ?></td>
                    <td class="s10" dir="ltr"><?php echo db_formatar($nValorAPlicadoSuperavit218_219 + $nValorAPlicadoSuperavit266_267,"f"); ?></td>
                </tr>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s28" dir="ltr" colspan="5">33 - VALOR APLICADO ATÉ O PRIMEIRO QUADRIMESTRE QUE INTEGRARÁ O
                        LIMITE CONSTITUCIONAL</td>
                    <td class="s12"></td>
                    <td class="s10" dir="ltr"><?php echo db_formatar($nValorAPlicadoSuperavit218_219,"f"); ?></td>
                    <td class="s31" dir="ltr"></td>
                    <td class="s10" dir="ltr"><?php echo db_formatar($nValorAPlicadoSuperavit218_219,"f"); ?></td>
                </tr>
                <?php
                        $nValorAPlicadoSuperavitPosPrimQuad218_219 = getDespesasCusteadosComSuperavitPosPrimeiroQuadrimestre(array("'218','219','25400007','25400000'"), $dtini, $dtfim, $instits);
                        $nValorAPlicadoSuperavitPosPrimQuad266_267 = getDespesasCusteadosComSuperavitPosPrimeiroQuadrimestre(array("'266','267','25420007','25420007'"), $dtini, $dtfim, $instits);
                     ?>
                <tr style="height: 20px">
                    <td class="s11" dir="ltr"></td>
                    <td class="s40" dir="ltr" colspan="5">34 - VALOR APLICADO APÓS O PRIMEIRO QUADRIMESTRE</td>
                    <td class="s19"></td>
                    <td class="s20" dir="ltr"><?php echo db_formatar($nValorAPlicadoSuperavitPosPrimQuad218_219,"f"); ?></td>
                    <td class="s20" dir="ltr"><?php echo db_formatar($nValorAPlicadoSuperavitPosPrimQuad266_267,"f"); ?></td>
                    <td class="s20" dir="ltr"><?php echo db_formatar($nValorAPlicadoSuperavitPosPrimQuad218_219 + $nValorAPlicadoSuperavitPosPrimQuad266_267,"f"); ?></td>
                </tr>
                <?php
                    $nTotalFundebImpostosTransferenciasAnteriores = $nValorNaoAplicadoFundebImpostosTransfAnoAnterior - ( $nValorAPlicadoSuperavit218_219 + $nValorAPlicadoSuperavitPosPrimQuad218_219);
                    $nTotalFundebComplementoAnteriores = $nValorNaoAplicadoFundebComplementacaoAnoAnterior - ( $nValorAPlicadoSuperavit266_267 + $nValorAPlicadoSuperavitPosPrimQuad266_267);
                ?>
                <tr style="height: 20px">
                    <td class="s5" dir="ltr"></td>
                    <td class="s21" dir="ltr" colspan="6">35 - VALOR NÃO APLICADO (31 - (32 + 34))</td>
                    <td class="s22" dir="ltr"><?php echo db_formatar($nTotalFundebImpostosTransferenciasAnteriores,"f"); ?></td>
                    <td class="s22" dir="ltr"><?php echo db_formatar($nTotalFundebComplementoAnteriores,"f"); ?></td>
                    <td class="s22" dir="ltr"><?php echo db_formatar($nTotalFundebImpostosTransferenciasAnteriores + $nTotalFundebComplementoAnteriores,"f"); ?></td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
<?php

$html = ob_get_contents();
ob_end_clean();
$mPDF->WriteHTML(utf8_encode($html));
$mPDF->Output();
} catch (MpdfException $e) {
    db_redireciona('db_erros.php?fechar=true&db_erro='.$e->getMessage());
}

db_query("drop table if exists work_dotacao");

db_fim_transacao();

?>
