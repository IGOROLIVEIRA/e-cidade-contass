<?php

//ini_set('display_erros','On'); error_reporting(E_ALL);
require_once ('libs/db_conn.php');
require_once ('libs/db_stdlib.php');
require_once ('libs/db_utils.php');
require_once ("libs/db_app.utils.php");
require_once ('libs/db_conecta.php');
require_once ('dbforms/db_funcoes.php');
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
require_once("libs/JSON.php");
require_once ("classes/db_bancoagencia_classe.php");
require_once ("classes/db_contabancaria_classe.php");
require_once ("model/contabilidade/planoconta/ContaPlanoPCASP.model.php");
require_once ("model/contabilidade/planoconta/ContaCorrente.model.php");
require_once ("model/contabilidade/planoconta/SistemaConta.model.php");
require_once("classes/db_conplanoexe_classe.php");


db_app::import("exceptions.*");

db_postmemory($HTTP_POST_VARS);

$oJson = new services_json();
$oRetorno = new stdClass();
$oRetorno->erro = false;
$oRetorno->status = 1;
$oRetorno->message = '';

$oJson             = new services_json();
$oParam            = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\","",$_POST["json"])));

switch ($oParam->exec) {

    case "getContas":

        /**
         *
         *  buscar as contas bancarias do tipo aplicação
         */


        try {
            $clContabancaria = new cl_contabancaria();
            $sqlContabancaria = $clContabancaria->sql_query_copiactb();
            $rsContaBancarias = $clContabancaria->sql_record($sqlContabancaria);
            $aContasBancarias = array();
            for($i=0; $i< pg_num_rows($rsContaBancarias); $i++ ) {
                $oConta = db_utils::fieldsMemory($rsContaBancarias, $i);
                $ctb = getCtbSicom($oConta);
                $oCtbAplic = new stdClass();
                $oCtbAplic->codcon = $oConta->codcon;
                $oCtbAplic->reduz = $oConta->reduz;
                $oCtbAplic->codctb = $ctb->si95_codctb != null ? $ctb->si95_codctb : $oConta->codctb;
                $oCtbAplic->conta = $oConta->conta;
                $oCtbAplic->descricao = $oConta->descricao;
                $oCtbAplic->tpaplicanterior =  $ctb->si95_tipoaplicacao;
                $oCtbAplic->tpaplicnovo = $oConta->tpaplicnovo;
                $oCtbAplic->tipoinstit = $oConta->tipoinstit;
                $oCtbAplic->si95_reduz = $oConta->si95_reduz;

                $aContasBancarias[] = $oCtbAplic;
            }
            $oRetorno->contas = $aContasBancarias;
        }catch (Exception $eErro) {

            $oRetorno->status = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
            db_fim_transacao(true);
        }
        break;

    case "processarAlteracao" :
        try {
            $erro = false;
            db_inicio_transacao();

            $rsCriaTabela = db_query( sql() );

            if(!$rsCriaTabela){
                $erro=true;
                $oRetorno->status = 2;
                $oRetorno->message = urlencode("Erro ao criar tabela  acertactb: " . pg_last_error());
                break;
            }

            $sqldelete = "delete from acertactb;";
            $rsDelete = db_query($sqldelete);

            if(!$rsDelete){
                $erro=true;
                $oRetorno->status = 2;
                $oRetorno->message = urlencode("Erro ao cadastrar  acertactb: " . pg_last_error());
                break;
            }
            foreach ($oParam->contas as $reduz){

                $sql = "insert into acertactb values($reduz->reduz,$reduz->codtceantigo)";
                $rsConta = db_query($sql);

                if(!$rsConta){
                    $erro=true;
                    $oRetorno->status = 2;
                    $oRetorno->message = urlencode("Erro ao inserir na tabela  acertactb: " . pg_last_error());
                    break;
                }

            }
            db_fim_transacao($erro);
        }catch (Exception $eErro) {

            $oRetorno->status = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
            db_fim_transacao(true);
        }
        break;

}
function sql(){
    $sql  = "CREATE TABLE IF NOT EXISTS acertactb ( ";
    $sql .= " si95_reduz int8 NOT NULL default 0, ";
    $sql .= " si95_codtceant int8 NOT NULL default 0, ";
    $sql .= " CONSTRAINT acertactb_sequ_pk PRIMARY KEY (si95_reduz) ); ";
    return $sql;
}
function deleteSicomAnterior($ctbantigo){

    $iInstit = db_getsession('DB_instit');
    $sSql  = "delete from ctb222017 where si98_instit= $iInstit" ;
    $sSql .= " and  si98_codreduzidomov in (select si97_codreduzidomov from ctb212017 where si97_codctb = $ctbantigo) ;";
    $sSql .= "delete from ctb212017 where si97_instit= $iInstit and  si97_codctb = $ctbantigo ;";
    $sSql .= "delete from ctb202017 where si96_instit= $iInstit and  si96_codctb = $ctbantigo ;";
    $sSql .= "delete from ctb502017 where si102_instit= $iInstit and  si102_codctb = $ctbantigo ;";
    $sSql = "delete from ctb102017 where si95_codctb = $ctbantigo and si95_instit= ".$iInstit.";";

    $sSql .= "delete from ctb222016 where si98_instit = ".$iInstit;
    $sSql .= " and  si98_codreduzidomov in (select si97_codreduzidomov from ctb212016 where si97_codctb = $ctbantigo) ;";
    $sSql .= "delete from ctb212016 where si97_instit= $iInstit and  si97_codctb = $ctbantigo ;";
    $sSql .= "delete from ctb202016 where si96_instit= $iInstit and  si96_codctb = $ctbantigo ;";
    $sSql .= "delete from ctb502016 where si102_instit= $iInstit and  si102_codctb = $ctbantigo ;";
    $sSql .= "delete from ctb102016 where si95_codctb = $ctbantigo and si95_instit= ".$iInstit.";";

    $sSql .= "delete from ctb222015 where si98_instit= ".$iInstit;
    $sSql .= " and  si98_codreduzidomov in (select si97_codreduzidomov from ctb212015 where si97_codctb = $ctbantigo) ;";
    $sSql .= "delete from ctb212015 where si97_instit= $iInstit and  si97_codctb = $ctbantigo ;";
    $sSql .= "delete from ctb202015 where si96_instit= $iInstit and  si96_codctb = $ctbantigo ;";
    $sSql .= "delete from ctb502015 where si102_instit= $iInstit and  si102_codctb = $ctbantigo ;";
    $sSql .= "delete from ctb102015 where si95_codctb = $ctbantigo and si95_instit= ".$iInstit.";";


    $sSql .= "delete from ctb222014 where si98_instit= ".$iInstit;
    $sSql .= " and  si98_codreduzidomov in (select si97_codreduzidomov from ctb212014 where si97_codctb = $ctbantigo) ;";
    $sSql .= "delete from ctb212014 where si97_instit= $iInstit and  si97_codctb = $ctbantigo ;";
    $sSql .= "delete from ctb202014 where si96_instit= $iInstit and  si96_codctb = $ctbantigo ;";
    $sSql .= "delete from ctb502014 where si102_instit= $iInstit and  si102_codctb = $ctbantigo ;";
    $sSql .= "delete from ctb102014 where si95_codctb = $ctbantigo and si95_instit= ".$iInstit.";";


    return $sSql;
}
function getCtbSicom($ctbsistema){
    //VERIFICAR EM 2017
    $sSqlVerifica = "SELECT * FROM ctb102017 ";
    $sSqlVerifica .= " WHERE si95_codorgao = '".$ctbsistema->si09_codorgaotce."'";
    $sSqlVerifica .= " AND si95_banco = '".$ctbsistema->c63_banco."'";
    $sSqlVerifica .= " AND si95_agencia = '".$ctbsistema->c63_agencia."'";
    $sSqlVerifica .= " AND si95_digitoverificadoragencia = '".$ctbsistema->c63_dvagencia."'";
    $sSqlVerifica .= " AND si95_contabancaria = '".$ctbsistema->c63_conta."'";
    $sSqlVerifica .= " AND si95_digitoverificadorcontabancaria = '".$ctbsistema->c63_dvconta."'";
    $sSqlVerifica .= " AND si95_tipoconta::int = ".$ctbsistema->tipoconta;
    $sSqlVerifica .= " AND si95_instit = " . db_getsession('DB_instit');

    //VERIFICAR EM 2016
    $sSqlVerifica .= " UNION SELECT * FROM ctb102016 ";
    $sSqlVerifica .= " WHERE si95_codorgao = '".$ctbsistema->si09_codorgaotce."'";
    $sSqlVerifica .= " AND si95_banco = '".$ctbsistema->c63_banco."'";
    $sSqlVerifica .= " AND si95_agencia = '".$ctbsistema->c63_agencia."'";
    $sSqlVerifica .= " AND si95_digitoverificadoragencia = '".$ctbsistema->c63_dvagencia."'";
    $sSqlVerifica .= " AND si95_contabancaria = '".$ctbsistema->c63_conta."'";
    $sSqlVerifica .= " AND si95_digitoverificadorcontabancaria = '".$ctbsistema->c63_dvconta."'";
    $sSqlVerifica .= " AND si95_tipoconta::int = ".$ctbsistema->tipoconta;
    $sSqlVerifica .= " AND si95_instit = " . db_getsession('DB_instit');

    //VERIFICAR EM 2015
    $sSqlVerifica .= " UNION SELECT * FROM ctb102015 ";
    $sSqlVerifica .= " WHERE si95_codorgao = '".$ctbsistema->si09_codorgaotce."'";
    $sSqlVerifica .= " AND si95_banco = '".$ctbsistema->c63_banco."'";
    $sSqlVerifica .= " AND si95_agencia = '".$ctbsistema->c63_agencia."'";
    $sSqlVerifica .= " AND si95_digitoverificadoragencia = '".$ctbsistema->c63_dvagencia."'";
    $sSqlVerifica .= " AND si95_contabancaria = '".$ctbsistema->c63_conta."'";
    $sSqlVerifica .= " AND si95_digitoverificadorcontabancaria = '".$ctbsistema->c63_dvconta."'";
    $sSqlVerifica .= " AND si95_tipoconta::int = ".$ctbsistema->tipoconta;
    $sSqlVerifica .= " AND si95_instit = " . db_getsession('DB_instit');

    //VERIFICAR EM 2014
    $sSqlVerifica .= " UNION SELECT * FROM ctb102014 ";
    $sSqlVerifica .= " WHERE si95_codorgao = '".$ctbsistema->si09_codorgaotce."'";
    $sSqlVerifica .= " AND si95_banco = '".$ctbsistema->c63_banco."'";
    $sSqlVerifica .= " AND si95_agencia = '".$ctbsistema->c63_agencia."'";
    $sSqlVerifica .= " AND si95_digitoverificadoragencia = '".$ctbsistema->c63_dvagencia."'";
    $sSqlVerifica .= " AND si95_contabancaria = '".$ctbsistema->c63_conta."'";
    $sSqlVerifica .= " AND si95_digitoverificadorcontabancaria = '".$ctbsistema->c63_dvconta."'";
    $sSqlVerifica .= " AND si95_tipoconta::int = ".$ctbsistema->tipoconta;
    $sSqlVerifica .= " AND si95_instit = " . db_getsession('DB_instit');

    $rsResultVerifica = db_query($sSqlVerifica);

    return db_utils::fieldsMemory($rsResultVerifica,0);
}

echo $oJson->encode($oRetorno);