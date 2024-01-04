<?php
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once('libs/db_app.utils.php');
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("std/DBTime.php");
require_once("std/DBDate.php");

$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oErro             = new stdClass();
$oRetorno          = new stdClass();
$oRetorno->status  = 1;


switch ($oParam->exec) {

    case 'buscarAparolegal':

        $sql = "SELECT * FROM amparolegal
                        WHERE l212_codigo IN
                                (SELECT l213_amparo
                                 FROM amparocflicita
                                 WHERE l213_modalidade IN
                                         (SELECT DISTINCT l03_codigo
                                          FROM amparocflicita
                                          INNER JOIN cflicita ON cflicita.l03_codigo=l213_modalidade
                                          WHERE l03_pctipocompratribunal= $oParam->modalidade
                                              AND l03_instit = " . db_getsession('DB_instit') . ")) order  by l212_codigo";
        $result_tipo = db_query($sql);

        for ($iCont = 0; $iCont < pg_num_rows($result_tipo); $iCont++) {
            $oAmparolegal = db_utils::fieldsMemory($result_tipo, $iCont);
            $oAmparo = new stdClass();
            $oAmparo->l212_codigo = $oAmparolegal->l212_codigo;
            $oAmparo->l212_lei = urlencode(utf8_decode($oAmparolegal->l212_lei));
            $oRetorno->amparolegal[] = $oAmparo;
        }

        break;
}

echo json_encode($oRetorno);
