<?php

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);

$iAno = db_getsession('DB_anousu')-1;

/**
 * Procedimento executado para cadastrar as contas banc�rias no sistema, a partir do arquivo CTB do SICOM AM.
 * 1. Busca nas tabelas do CTB os dados das contas banc�rias nos meses dos exerc�cios anteriores ao da sess�o.
 * 2. Realiza o cadastro das contas como � feito em Financeiro->Caixa->Cadastros->Contas->Contas Banc�rias
 * 3. Do ctb10 busco apenas as que n�o tem vinculo com o ctb50 onde o situacaoConta for igual a 'E'. E o ctb20 so pego as de dezembro para pegar o saldo final e implantar
 */

//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
$aDadosSicom = getDadosSicom($iAno);

function getDadosSicom($iAno){

    $sWhere10 = " where si95_instit = " . db_getsession("DB_instit");

    $sSql10 = "select * from (";
    for($i = 2014; $i < db_getsession('DB_anousu'); $i++){
        $sSql10 .= " select * from ctb10{$i} {$sWhere10} and si95_codctb in (4188,18388) ";
        $sSql10 .= $i+1 == db_getsession('DB_anousu') ? " ) as x " : " union ";
    }

    $rCtb10 = db_query($sSql10);
    $aContas = db_utils::getCollectionByRecord($rCtb10);
    $aContasAgrupadas = array();
    foreach($aContas as $oConta){
        if(!validaContaEncerrada($oConta->si95_codctb,db_getsession('DB_anousu'))) {
            $oConta->aSaldos = getSaldoCTB($oConta->si95_codctb, $iAno);
            $aContasAgrupadas[] = $oConta;
        } else {
            continue;
        }

    }

    echo "<pre>";
    print_r($aContasAgrupadas);
    exit;

}

/**
 * Busca a �ltima situa��o da conta e Verifica se a conta est� encerrada retornando true, se n�o, false.
 * @param $iCodCtb
 * @param $iAno
 * @return bool
 *
 */
function validaContaEncerrada($iCodCtb,$iAno){
    $sWhere50 = " where si102_instit = " . db_getsession("DB_instit");

    $sSql50 = "select si102_situacaoconta from (";
    for($i = 2014; $i < $iAno; $i++){
        $sSql50 .= " select *, {$i} as si102_anousu from ctb50{$i} {$sWhere50} and si102_codctb = $iCodCtb ";
        $sSql50 .= $i+1 == $iAno ? " ) as x " : " union ";
    }
    $sSql50 .= " order by si102_datasituacao DESC limit 1 ";

    return db_utils::fieldsMemory(db_query($sSql50),0)->si102_situacaoconta == 'E' ? true : false;

}

function getSaldoCTB($iCodCtb, $iAno){

    require_once("classes/db_ctb20{$iAno}_classe.php");
    $sNomeClasseCTB20 = "cl_ctb20{$iAno}";
    $cCtb20 = new $sNomeClasseCTB20;

    $sSql = $cCtb20->sql_query(NULL,"si96_codfontrecursos, si96_vlsaldofinalfonte", NULL, " si96_codctb = {$iCodCtb} and si96_mes = 11 order by 1 ");
    $rRes = $cCtb20->sql_record($sSql);

    return db_utils::getCollectionByRecord($rRes);
}


echo json_encode("teste");

?>
