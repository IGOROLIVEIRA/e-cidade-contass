<?
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("std/db_stdClass.php");

$oJson             = new services_json();
$oParam            = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\", "", $_POST["json"])));
$oRetorno          = new stdClass();
$amparo = array();
$sSql = "SELECT pctipocompratribunal.l44_sequencial
      FROM cflicita
      INNER JOIN db_config ON db_config.codigo = cflicita.l03_instit
      INNER JOIN pctipocompra ON pctipocompra.pc50_codcom = cflicita.l03_codcom
      INNER JOIN pctipocompratribunal ON pctipocompratribunal.l44_sequencial = cflicita.l03_pctipocompratribunal
      INNER JOIN cgm ON cgm.z01_numcgm = db_config.numcgm
      INNER JOIN db_tipoinstit ON db_tipoinstit.db21_codtipo = db_config.db21_tipoinstit
      INNER JOIN pctipocompratribunal AS a ON a.l44_sequencial = pctipocompra.pc50_pctipocompratribunal
      WHERE cflicita.l03_codigo = $oParam->codigo ";
$result = db_query($sSql);
$tribunal = pg_result($result, 0, 0);

$oRetorno->tribunal = $tribunal;

$sSql = "select * from amparolegal where l212_codigo in (select l213_amparo from amparocflicita where l213_modalidade = $oParam->codigo)";
$result = db_query($sSql);
if (pg_numrows($result) == 0 && $oParam->codigo == 99) {
      $sSql = "select * from amparolegal";
      $result = db_query($sSql);
      for ($x = 0; $x < pg_numrows($result); $x++) {
            db_fieldsmemory($result, $x);
            $oRetorno->amparo[$l212_codigo] = $l212_lei;
      }
} else {
      for ($x = 0; $x < pg_numrows($result); $x++) {
            db_fieldsmemory($result, $x);
            $oRetorno->amparo[$l212_codigo] = $l212_lei;
      }
}
$oRetorno->numrows = pg_numrows($result);

$anousu = db_getsession("DB_anousu");
$resultNumeracao = db_query("select * from pccflicitapar where l25_anousu = $anousu and l25_codcflicita = $oParam->codigo;");
$resultNumeracao = db_utils::fieldsmemory($resultNumeracao, 0);
$oRetorno->numeracao = $resultNumeracao->l25_numero;
$oRetorno->numeracao = $resultNumeracao->l25_numero == null ? "0" : $resultNumeracao->l25_numero;


echo $oJson->encode($oRetorno);
