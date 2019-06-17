<?php

include("libs/db_utils.php");
include("std/DBDate.php");
include("dbforms/db_funcoes.php");
include("libs/db_sql.php");
include("fpdf151/pdf.php");
include("libs/db_libcontabilidade.php");

//ini_set('display_errors', 'On');
//error_reporting(E_ALL);

parse_str($HTTP_SERVER_VARS['QUERY_STRING'], $aFiltros);

$aMeses = array(
    "JANEIRO" => "1", "FEVEREIRO" => "2", "MARÇO" => "3", "ABRIL" => "4", "MAIO" => "5", "JUNHO" => "6",
    "JULHO" => "7", "AGOSTO" => "8", "SETEMBRO" => "9", "OUTUBRO" => "10", "NOVEMBRO" => "11", "DEZEMBRO" => "12"
);

$aTipoValor = array('beginning_balance', 'period_change_deb', 'period_change_cred', 'ending_balance');

$aInstit = str_replace("-",",",$aFiltros['selinstit']);
$iAnoUsu      = date("Y", db_getsession("DB_datausu"));
$iMes         = (!empty($aFiltros['mes']))     ? $aFiltros['mes'] : '';

$sEstrut_inicial = $aFiltros['estrut_inicial'];

$iUltimoDiaMes = date("d", mktime(0,0,0,$iMes+1,0,db_getsession("DB_anousu")));
$sDataInicial = db_getsession("DB_anousu")."-{$iMes}-01";
$sDataFinal   = db_getsession("DB_anousu")."-{$iMes}-{$iUltimoDiaMes}";

$sInstituicao = ($aFiltros['matriz'] == 'd')   ? " r.c61_instit = $iInstit and " : '';
$sTipoInstit  = !empty($sInstituicao)          ? " limit 1 " : '';
$aRegistros   = array();
$iConta       = "";


try {
    if($sEstrut_inicial != '')
        $where = " c61_instit in ({$aInstit}) and c60_estrut like '$sEstrut_inicial%' " ;
    else
        $where = " c61_instit in ({$aInstit}) " ;

    $iAnoUsu = db_getsession("DB_anousu");
    $rsBalancete = db_planocontassaldo_matriz($iAnoUsu,$sDataInicial,$sDataFinal,false,$where);
    $nCC = 0;
    for ($iCont = 0; $iCont < pg_num_rows($rsBalancete); $iCont++) {
        $oBalancete = db_utils::fieldsMemory($rsBalancete, $iCont);

        // retirar as contas sem movimento e com saldo zero
        if($oBalancete->saldo_anterior == 0
            && $oBalancete->saldo_anterior_debito == 0
            && $oBalancete->saldo_anterior_credito == 0
            && $oBalancete->saldo_final == 0) {
            continue;
        }

        $oNovoResgistro                         = new stdClass;
        $oNovoResgistro->estrutural             = $oBalancete->estrutural;
        $oNovoResgistro->c61_reduz              = $oBalancete->c61_reduz != '0' ?  $oBalancete->c61_reduz : '';
        $oNovoResgistro->c60_descr              = substr($oBalancete->c60_descr,0,70);
        $oNovoResgistro->saldo_anterior         = $oBalancete->saldo_anterior;
        $oNovoResgistro->saldo_anterior_debito  = $oBalancete->saldo_anterior_debito;
        $oNovoResgistro->saldo_anterior_credito = $oBalancete->saldo_anterior_credito;
        $oNovoResgistro->saldo_final            = $oBalancete->saldo_final;
        $oNovoResgistro->sinal_anterior         = $oBalancete->sinal_anterior;
        $oNovoResgistro->sinal_final            = $oBalancete->sinal_final;
        $oNovoResgistro->contacorrente          = new stdClass;;

        if($oBalancete->c61_reduz > 0) {
            $sSqlCC = "select c18_contacorrente from conplanocontacorrente where c18_anousu={$iAnoUsu} and c18_codcon = {$oBalancete->c61_codcon}";
            $rsCC = db_query($sSqlCC);
            $nCC = db_utils::fieldsMemory($rsCC, 0)->c18_contacorrente;
            $oNovoResgistro->contacorrente         = getSaldoTotalContaCorrente($iAnoUsu,$oBalancete->c61_reduz,$nCC > 0 ? $nCC : null, $iMes, $oBalancete->c61_instit);
        }
        if($oBalancete->saldo_anterior == 0
            && $oBalancete->saldo_anterior_debito == 0
            && $oBalancete->saldo_anterior_credito == 0
            && $oBalancete->saldo_final == 0
            && $oNovoResgistro->contacorrente->nSaldoInicialMes == 0
            && $oNovoResgistro->contacorrente->debito == 0
            && $oNovoResgistro->contacorrente->credito == 0
            && $oNovoResgistro->contacorrente->saldo_final == 0) {
            continue;
        }
        $aRegistros[] = $oNovoResgistro;
    }

} catch (Exception $e) {
    echo $e->getMessage();
}
$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$head2 = "BALANCETE MSC";
$head3 = "EXERCÍCIO: {$iAnoUsu}";
$head4 = "PERÍODO: ".array_search($iMes, $aMeses);
$head5 = "INSTIUIÇÕES: {$sInstituicoes}";
$alt   = 4;
$pdf->SetAutoPageBreak('on',0);
$pdf->line(2,148.5,208,148.5);
$pdf->setfillcolor(235);
$pdf->addpage();

$pdf->setfont("arial", "B", 6);
$pdf->cell(19,$alt,"ESTRUTURAL","B",0,"C",0);
$pdf->cell(70,$alt,"DESCRIÇÃO","B",0,"L",0);
$pdf->cell(10,$alt,"REDUZ","B",0,"C",0);
$pdf->cell(24,$alt,"SALDO ANTERIOR","B",0,"R",0);
$pdf->cell(22,$alt,"DÉBITOS","B",0,"R",0);
$pdf->cell(22,$alt,"CRÉDITOS","B",0,"R",0);
$pdf->cell(24,$alt,"SALDO FINAL","B",0,"R",0);

$pdf->ln();
$pdf->setfont("arial", "", 6);
//echo "<pre>"; print_r($aRegistros);die();

foreach ($aRegistros as $aRegistro) {

    $pdf->cell(19,$alt,$aRegistro->estrutural,"0",0,"C",0);
    $pdf->cell(70,$alt,$aRegistro->c60_descr,"0",0,"L",0);
    $pdf->cell(10,$alt,$aRegistro->c61_reduz,"0",0,"C",0);
    $pdf->cell(24,$alt,db_formatar($aRegistro->saldo_anterior,'f')."$aRegistro->sinal_anterior","0",0,"R",0);
    $pdf->cell(22,$alt,db_formatar($aRegistro->saldo_anterior_debito,'f'),"0",0,"R",0);
    $pdf->cell(22,$alt,db_formatar($aRegistro->saldo_anterior_credito,'f'),"0",0,"R",0);
    $pdf->cell(24,$alt,db_formatar($aRegistro->saldo_final,'f')."$aRegistro->sinal_final","0",0,"R",0);

    $pdf->ln();
    $diferente = false;
    if(db_formatar($aRegistro->saldo_anterior,'f') != $aRegistro->contacorrente->nSaldoInicialMes
        && db_formatar($aRegistro->saldo_anterior_debito,'f') != $aRegistro->contacorrente->debito
        && db_formatar($aRegistro->saldo_anterior_credito,'f') != $aRegistro->contacorrente->credito
        && db_formatar($aRegistro->saldo_final,'f') != $aRegistro->contacorrente->saldo_final)
        $diferente = true;
    if($aRegistro->contacorrente->cc > 0) {
        $pdf->cell(19,$alt,"","0",0,"C",1);
        $pdf->cell(70,$alt,($diferente==true)?"S A L D O   CC ":"SALDO CC ",($diferente==true)?"B":"0",0,"R",1);
        $pdf->cell(10, $alt, $aRegistro->contacorrente->cc, "0", 0, "C", 1);
        $pdf->cell(24, $alt, $aRegistro->contacorrente->nSaldoInicialMes.$aRegistro->contacorrente->sinal_ant, "0", 0, "R", 1);
        $pdf->cell(22, $alt, $aRegistro->contacorrente->debito, "0", 0, "R", 1);
        $pdf->cell(22, $alt, $aRegistro->contacorrente->credito, "0", 0, "R", 1);
        $pdf->cell(24, $alt, $aRegistro->contacorrente->saldo_final.$aRegistro->contacorrente->sinal_final, "0", 0, "R", 1);
        $pdf->ln();

    }

    if ($pdf->gety() > ($pdf->h - 20)) {
        $pdf->addpage();
    }

}

if ($pdf->gety() > ($pdf->h - 20)) {
    $pdf->addpage();
}

$pdf->Output();

?>
