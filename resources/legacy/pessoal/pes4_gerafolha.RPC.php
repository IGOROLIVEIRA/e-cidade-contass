<?php
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
require_once("classes/db_gerfcom_classe.php");
require_once("classes/db_rhrubricas_classe.php");

$oJson    = new services_json();
$oParam   = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\","",$_POST["json"])));

switch($oParam->exec) {
  case 'quantidadeDeComplementaresDoServidor':
    $rpc = new RPCgerafolha();
    echo $rpc->quantidadeDeComplementaresDoServidor($oParam->regist, $oParam->anousu, $oParam->mesusu);
  break;
  case 'verificarPermissaoDaRubricaNoContexto':
    $rpc = new RPCgerafolha();
    echo $rpc->rubricaPodeSerAdicionada($oParam->regist, $oParam->anousu, $oParam->mesusu, $oParam->rubrica);
  break;
}

class RPCgerafolha {

  function __construct() {
    $this->clrhrubricas = new cl_rhrubricas();
  }

  function quantidadeDeComplementaresDoServidor($regist, $anousu, $mesusu){

    $clgerfcom = new cl_gerfcom();

    $dbWhere = " gerfcom.r48_anousu = $anousu and gerfcom.r48_mesusu = $mesusu and gerfcom.r48_regist = $regist and r48_semest != 0 ";
    $rsGerfcom = $clgerfcom->sql_record($clgerfcom->sql_query_file($anousu, $mesusu, $regist, null, "*", null, $dbWhere));

    return (int) pg_num_rows($rsGerfcom);
  }

  function rubricaPodeSerAdicionada($regist, $anousu, $mesusu, $rubricaCandidata) {

    $iInstituicaoSessao = db_getsession('DB_instit');
    $aRubricasAtivasDoServidor = $this->rubricasAtivasDoServidor($regist, $anousu, $mesusu);

    $aRubricasAtivasNaBaseINSS = $this->rubricasAtivasNaBase('B001', $anousu, $mesusu, $iInstituicaoSessao);
    $aRubricasAtivasNaBaseIRRF = $this->rubricasAtivasNaBase('B004', $anousu, $mesusu, $iInstituicaoSessao);

    $rubricasExistemNaBaseINSS = $this->rubricasEstaoAtivasNaBase($aRubricasAtivasNaBaseINSS, $rubricaCandidata, $aRubricasAtivasDoServidor);
    
    $rubricasExistemNaBaseIRRF = $this->rubricasEstaoAtivasNaBase($aRubricasAtivasNaBaseIRRF, $rubricaCandidata, $aRubricasAtivasDoServidor);

    $oRetorno = new stdClass();
    $oRetorno->rubricasExistemNaBaseINSS = $rubricasExistemNaBaseINSS;
    $oRetorno->rubricasExistemNaBaseIRRF = $rubricasExistemNaBaseIRRF;

    return json_encode($oRetorno);

  }

  function rubricasAtivasDoServidor($regist, $anousu, $mesusu) {

    $clgerfcom = new cl_gerfcom();

    $dbWhere = " gerfcom.r48_anousu = $anousu and gerfcom.r48_mesusu = $mesusu and gerfcom.r48_regist = $regist and r48_semest != 0 ";
    $rsGerfcom = $clgerfcom->sql_record($clgerfcom->sql_query_file($anousu, $mesusu, $regist, null, "*", null, $dbWhere));

    $aRubricasAtivasDoServidor = array();
  
    for($i = 0; $i < pg_num_rows($rsGerfcom); $i++) {
      $sRubrica = db_utils::fieldsMemory($rsGerfcom, $i)->r48_rubric;
      $sInicialDaRubrica = substr($sRubrica, 0, 1);
      if($sInicialDaRubrica === 'R') {
        continue;
      }
      $aRubricasAtivasDoServidor[] = $sRubrica;
    }

    return $aRubricasAtivasDoServidor;
  }

  function rubricasAtivasNaBase($sBase, $iAnofolha, $iMesFolha, $iInstituicao){

    $rsRhRubricas = $this->clrhrubricas->sql_record(
      $this->clrhrubricas->rubricasAtivasNaBase($sBase, $iAnofolha, $iMesFolha, $iInstituicao)
    );

    $aRubricasAtivasNaBase = array();
  
    for($i = 0; $i < pg_num_rows($rsRhRubricas); $i++) {
      $aRubricasAtivasNaBase[] = db_utils::fieldsMemory($rsRhRubricas, $i)->r09_rubric;
    }

    return $aRubricasAtivasNaBase;
  }

  function rubricasEstaoAtivasNaBase($aRubricasAtivasNaBase, $sRubricaCandidata, $aRubricasAtivasDoServidor) {
    foreach($aRubricasAtivasDoServidor as $sRubricaAtivaDoServidor) {
      $rubricaAtivaExisteNaBase = in_array($sRubricaAtivaDoServidor, $aRubricasAtivasNaBase);
      $rubricaCandidataExisteNaBase = in_array($sRubricaCandidata, $aRubricasAtivasNaBase);

      if($rubricaAtivaExisteNaBase && $rubricaCandidataExisteNaBase) {
        return true;
      }
    }
  }

}
