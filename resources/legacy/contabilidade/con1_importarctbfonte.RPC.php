<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_libcontabilidade.php");
require_once("libs/db_liborcamento.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_libpostgres.php");
require_once("libs/db_sessoes.php");
require_once("model/padArquivoEscritorXML.model.php");
require_once("model/PadArquivoEscritorCSV.model.php");

$oJson = new services_json();
$oParam = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\", "", $_POST["json"])));

$oRetorno = new stdClass();
$oRetorno->status = 1;
$oRetorno->message = '';
$iAno = db_getsession('DB_anousu')-1;
$iInstituicao = db_getsession("DB_instit");


try{
    switch ($oParam->exec) {

        case 'importarCTBFONTE' :
            $naoCadastradas = array();
            db_inicio_transacao();
            $aDadosSicom = getDadosSicom($iAno);
            $clconctbsaldo = new cl_conctbsaldo;
            $clconctbsaldo->excluir(NULL, "ces02_anousu = " . db_getsession("DB_anousu"));

            if (empty($aDadosSicom)){
                throw new Exception("Não foi localizado nenhuma conta a ser importada!");
            }

            for ($i = 0; $i < count($aDadosSicom) ; $i++ ) {
                if($aDadosSicom[$i]->reduz != 0 || $aDadosSicom[$i]->codcon != 0) {
                    $sAtualizaCodCTB = "UPDATE conplanoreduz SET c61_codtce=" . $aDadosSicom[$i]->si95_codctb . "
                        WHERE c61_anousu=" . db_getsession("DB_anousu") . "  AND c61_reduz=" . $aDadosSicom[$i]->reduz;
                    $rCtb10 = db_query($sAtualizaCodCTB);
                }

                for ($x = 0; $x < count($aDadosSicom[$i]->aSaldos) ; $x++ ) {
            
                    $iFonteNova = $aDadosSicom[$i]->aSaldos[$x]->si96_codfontrecursos;
                    if ($iAno>2022) {
                        $iFonteNova = $aDadosSicom[$i]->aSaldos[$x]->o15_codigo;
                    }
                    $clconctbsaldo = new cl_conctbsaldo;
                    $clconctbsaldo->ces02_codcon = $aDadosSicom[$i]->codcon;
                    $clconctbsaldo->ces02_reduz = $aDadosSicom[$i]->reduz;
                    $clconctbsaldo->ces02_fonte = $iFonteNova;
                    $clconctbsaldo->ces02_valor = $aDadosSicom[$i]->aSaldos[$x]->si96_vlsaldofinalfonte;
                    $clconctbsaldo->ces02_anousu = $iAno + 1;
                    $clconctbsaldo->ces02_inst = $iInstituicao;

                    if($aDadosSicom[$i]->reduz == 0 || $aDadosSicom[$i]->codcon == 0){
                        $naoCadastradas[] = " Sem reduz "
                            .$aDadosSicom[$i]->si95_contabancaria
                            ."-".$aDadosSicom[$i]->si95_digitoverificadorcontabancaria
                            ." ".$aDadosSicom[$i]->si95_desccontabancaria
                            ." CodTCE =".$aDadosSicom[$i]->si95_codctb;
                        continue;
                    }
                    $clconctbsaldo->incluir($ces02_sequencial);
                    if($clconctbsaldo->erro_status == 0){
                        throw new Exception("Erro ao incluir Saldo: ".$clconctbsaldo->erro_msg);
                    }

                }
            }
            db_fim_transacao(false);
            //print_r($naoCadastradas);
            $oRetorno->naoCadastradas = $naoCadastradas;
            break;
        default:
            break;
    }

} catch (Exception $e) {
    $oRetorno->status = 2;
    $oRetorno->message = urlencode(str_replace("\\n", "\n",$e->getMessage()));
}
function getDadosSicom($iAno){
    $sWhere10 = " where si95_instit = " . db_getsession("DB_instit");
    $sCampos  = " si95_sequencial, si95_tiporegistro, si95_codctb, si95_codorgao, lpad(si95_banco,3,0) as si95_banco, si95_agencia, si95_digitoverificadoragencia, ";
    $sCampos .= " si95_contabancaria, si95_digitoverificadorcontabancaria, si95_tipoconta, si95_tipoaplicacao, si95_nroseqaplicacao, ";
    $sCampos .= " si95_desccontabancaria, si95_contaconvenio, si95_nroconvenio::varchar, si95_dataassinaturaconvenio, si95_mes, si95_instit ";

    if (db_getsession('DB_anousu') > 2022) {
        $sCampos  = " si95_sequencial, si95_tiporegistro, si95_codctb, si95_codorgao, lpad(si95_banco,3,0) as si95_banco, si95_agencia, si95_digitoverificadoragencia, ";
        $sCampos .= " si95_contabancaria, si95_digitoverificadorcontabancaria, si95_tipoconta, '' as si95_tipoaplicacao, si95_nroseqaplicacao, ";
        $sCampos .= " si95_desccontabancaria, si95_contaconvenio, si95_nroconvenio::varchar, si95_dataassinaturaconvenio, si95_mes, si95_instit ";
    }
    $sSql10 = "select * from (";
    for($i = 2014; $i < db_getsession('DB_anousu'); $i++){

        $sSql10 .= " select {$sCampos} from ctb10{$i} {$sWhere10}  ";
        $sSql10 .= $i+1 == db_getsession('DB_anousu') ? " ) as x " : " union ";
    }
    $sSql10 .= " order by si95_banco, si95_tipoconta ";
    $rCtb10 = db_query($sSql10);
    $aContas = db_utils::getCollectionByRecord($rCtb10);
    $aContasAgrupadas = array();
    foreach($aContas as $oConta){
        if(!validaContaEncerrada($oConta->si95_codctb,db_getsession('DB_anousu'))) {
            $oConta->aSaldos = getSaldoCTB($oConta->si95_codctb, $iAno);
            $oPlanoContaReduz = getCodConReduz($oConta);
            if($oPlanoContaReduz == null){
                $oConta->codcon = $oPlanoContaReduz->c61_codcon;
                $oConta->reduz  = $oPlanoContaReduz->c61_reduz;
            }else{
                $oConta->codcon = $oPlanoContaReduz->c61_codcon;
                $oConta->reduz  = $oPlanoContaReduz->c61_reduz;
            }

            $aContasAgrupadas[] = $oConta;
        } else {
            continue;
        }

    }
    return $aContasAgrupadas;
}
/**
 * Busca a última situação da conta e Verifica se a conta está encerrada retornando true, se não, false.
 * @param $iCodCtb
 * @param $iAno
 * @return bool
 *
 */
function validaContaEncerrada($iCodCtb,$iAno){
    $sWhere50 = " where si102_instit = " . db_getsession("DB_instit");
    $sCampos2014 = "si102_sequencial, si102_tiporegistro, si102_codorgao, si102_codctb, 'E' as si102_situacaoconta, si102_dataencerramento as si102_datasituacao, si102_mes, si102_instit";
    $sCampos2015 = "si102_sequencial, si102_tiporegistro, si102_codorgao, si102_codctb, si102_situacaoconta, si102_datasituacao, si102_mes, si102_instit";
    $sCampos2016 = "si102_sequencial, si102_tiporegistro, si102_codorgao, si102_codctb, si102_situacaoconta, si102_datasituacao, si102_mes, si102_instit";
    $sSql50 = "select si102_situacaoconta from (";
    for($i = 2014; $i < $iAno; $i++){
        $sCampos = "*";
        if($i == 2014){
            $sCampos = $sCampos2014;
        }
        $sSql50 .= " select {$sCampos}, {$i} as si102_anousu from ctb50{$i} {$sWhere50} and si102_codctb = $iCodCtb ";

        $sSql50 .= $i+1 == $iAno ? " ) as x " : " union ";
    }
    $sSql50 .= " order by si102_datasituacao ";

    return db_utils::fieldsMemory(db_query($sSql50),0)->si102_situacaoconta == 'E' ? true : false;

}

function getSaldoCTB($iCodCtb, $iAno){

    require_once("classes/db_ctb20{$iAno}_classe.php");
    $sNomeClasseCTB20 = "cl_ctb20{$iAno}";
    $cCtb20 = new $sNomeClasseCTB20;

    if ($iAno > 2022) {
        $sSql = $cCtb20->sql_query_fonte8digitos(NULL,"o15_codigo, si96_vlsaldofinalfonte", NULL, " si96_codctb = {$iCodCtb} and si96_mes = 12 order by 1 ");
        $rRes = $cCtb20->sql_record($sSql);
        if(pg_num_rows($rRes) <= 0){
            $sSql = $cCtb20->sql_query_fonte8digitos(NULL,"o15_codigo, si96_vlsaldofinalfonte", NULL, " si96_codctb = {$iCodCtb} and si96_mes = 11 order by 1 ");
            $rRes = $cCtb20->sql_record($sSql);
        }
    } else {
        $sSql = $cCtb20->sql_query(NULL,"si96_codfontrecursos, si96_vlsaldofinalfonte", NULL, " si96_codctb = {$iCodCtb} and si96_mes = 12 order by 1 ");
        $rRes = $cCtb20->sql_record($sSql);
        if(pg_num_rows($rRes) <= 0){
            $sSql = $cCtb20->sql_query(NULL,"si96_codfontrecursos, si96_vlsaldofinalfonte", NULL, " si96_codctb = {$iCodCtb} and si96_mes = 11 order by 1 ");
            $rRes = $cCtb20->sql_record($sSql);
        }
    }

    return db_utils::getCollectionByRecord($rRes);
}
function getCodConReduz($oConta){

    $sSql = "SELECT c61_codcon,c61_reduz
                FROM contabancaria
                INNER JOIN conplanocontabancaria ON c56_contabancaria=db83_sequencial
                INNER JOIN conplano ON c56_codcon=c60_codcon AND c56_anousu=c60_anousu
                INNER JOIN conplanoreduz ON c60_codcon=c61_codcon and c60_anousu=c61_anousu
                INNER JOIN bancoagencia ON db83_bancoagencia=db89_sequencial
                AND c60_anousu=c61_anousu ";
    $sSql .= "WHERE c61_anousu      = ".db_getsession('DB_anousu');
    $sSql .= "  AND c61_instit      = ".db_getsession('DB_instit');
    $sSql .= "  AND lpad(db89_db_bancos,3,0)  ='".$oConta->si95_banco."' ";
    $sSql .= "  AND db89_codagencia ='" .$oConta->si95_agencia."' ";
    $sSql .= "  AND db83_conta      ='".$oConta->si95_contabancaria."' ";
    $sSql .= "  AND db83_dvconta    ='" .$oConta->si95_digitoverificadorcontabancaria."' ";
    $sSql .= "  AND db89_digito     ='".$oConta->si95_digitoverificadoragencia."' ";
    $sSql .= "  AND lpad(db83_tipoconta,2,0)  = '".$oConta->si95_tipoconta."' " ;
    $sSql .= "  limit 1" ;

    $rsBuscaCodCon = db_query($sSql);

    if (pg_numrows($rsBuscaCodCon) == 0) {
        return null;
    }

    return db_utils::fieldsMemory($rsBuscaCodCon, 0);
}
echo $oJson->encode($oRetorno);
