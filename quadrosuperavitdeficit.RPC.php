<?php
//ini_set("display_errors", "on");

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/JSON.php");
require_once("std/db_stdClass.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_sessoes.php");
include("classes/db_orctiporec_classe.php");
include("classes/db_quadrosuperavitdeficit_classe.php");
require_once("repositories/OrcSuplemValRepositoryLegacy.php");
require_once("repositories/TipoSuplementacaoSuperavitDeficitRepositoryLegacy.php");
include("libs/db_libcontabilidade.php");
$instit = db_getsession("DB_instit");
$anousu = db_getsession("DB_anousu");

$clquadrosuperavitdeficit = new cl_quadrosuperavitdeficit();

$oJson    = new services_json();
$oRetorno = new stdClass();
$oParam   = json_decode(str_replace('\\', '', $_POST["json"]));
$oRetorno->status   = 1;
$oRetorno->erro     = false;
$oRetorno->message  = '';

$perini = $anousu . "-01-01";
$perfim = $anousu . "-12-31";


try {
    switch ($oParam->exec) {
        case "getValores":
            $aFonte = array();
            // Condição necessária devido a mudança do modelo de fonte de recursos no TCE-MG em 2023
            if ($anousu <= 2022) {
                $result = $clquadrosuperavitdeficit->sql_record($clquadrosuperavitdeficit->sql_query("null", " CONCAT('1',substring(c241_fonte::TEXT, 2, 2)) c241_fonte, SUM(c241_valor) c241_valor", null, "c241_ano = {$anousu} AND c241_instit = {$instit} GROUP BY CONCAT('1',substring(c241_fonte::TEXT, 2, 2)) ORDER BY CONCAT('1',substring(c241_fonte::TEXT, 2, 2)) " ));
            } else {
                $result = $clquadrosuperavitdeficit->sql_record($clquadrosuperavitdeficit->sql_query("null", " CONCAT('1', substring(c241_fonte::TEXT, 2)) c241_fonte, SUM(c241_valor) c241_valor", null, "c241_ano = {$anousu} AND c241_instit = {$instit} GROUP BY CONCAT('1', substring(c241_fonte::TEXT, 2)) ORDER BY CONCAT('1', substring(c241_fonte::TEXT, 2)) " ));
            }

            for ($i = 0; $i < pg_num_rows($result); $i++) {
                $oFonte = db_utils::fieldsMemory($result, $i);
                $aFonte[] = $oFonte;
                $oRetorno->valor += $oFonte->c241_valor;
            }
            ksort($aFonte);
            $oRetorno->fonte = $aFonte;

            $oOrcSuplemVal = new OrcSuplemValRepositoryLegacy($anousu, $instit);
            $oTipoSuplemenetacaoSuperavitDeficit = new TipoSuplementacaoSuperavitDeficitRepositoryLegacy();
            $oRetorno->suple = $oOrcSuplemVal->pegarArrayValorPelaFonteSuplementadoPorTipoSup($oTipoSuplemenetacaoSuperavitDeficit->pegarTipoSup());
            $array = json_decode(json_encode($oRetorno->suple), true);
            foreach ($array as $arraydados){
                $oRetorno->suplementado += $arraydados['valor'];
            }
            
            break;

            case "getImportar":
                $aFonte = array();
                
                $clorctiporec = new cl_orctiporec();
                $sql = "select DISTINCT o15_codigo, o15_codtri FROM orctiporec where o15_codtri is not null";
            
                $recursos = $clorctiporec->sql_record($sql);
                $aRecurso = db_utils::getCollectionByRecord($recursos);
                $aDadosSuperavitFontes = array();

                foreach ($aRecurso as $oFot) :
                    // Tem que condicionar a classe do ano
                    $clbpdcasp71 = new cl_bpdcasp712022();

                    $rsSaldoFontes = db_query($clbpdcasp71->sql_query_saldoInicialContaCorrente(false, $oFot->o15_codigo));

                    $oSaldoFontes = db_utils::fieldsMemory($rsSaldoFontes, 0);
                    $nHash = "1" . substr(str_pad($oFot->o15_codtri, 3, "0"), 1, 2);
                    $nSaldoFinal = ($oSaldoFontes->saldoanterior + $oSaldoFontes->debito - $oSaldoFontes->credito);

                    if (array_key_exists($nHash, $aDadosSuperavitFontes)) {
                        $aDadosSuperavitFontes[$nHash]->c241_valor += -1 * number_format($oSaldoFontes->saldoanterior, 2, ".", "");
                    } else {
                        $oDadosSuperavitFonte = new stdClass();
                        $oDadosSuperavitFonte->c241_ano = $anousu;
                        $oDadosSuperavitFonte->c241_fonte = $nHash;
                        $oDadosSuperavitFonte->c241_valor = -1 * number_format($oSaldoFontes->saldoanterior, 2, ".", "");
                        $aDadosSuperavitFontes[$nHash] = $oDadosSuperavitFonte;
                    }
                endforeach;
         
                foreach ($aDadosSuperavitFontes as $chave => $oFonte) {
                    $aFonte[(int) $oFonte->c241_fonte] = $oFonte;
                }
                ksort($aFonte);
                $oRetorno->fonte = (array) $aFonte;
                
                break;    

        case "getSuplementado":
            $oOrcSuplemVal = new OrcSuplemValRepositoryLegacy($anousu, $instit);
            $oTipoSuplemenetacaoSuperavitDeficit = new TipoSuplementacaoSuperavitDeficitRepositoryLegacy();
            $oRetorno->fonte = $oOrcSuplemVal->pegarArrayValorPelaFonteSuplementadoPorTipoSup($oTipoSuplemenetacaoSuperavitDeficit->pegarTipoSup());
            break;
    }
} catch (Exception $eErro) {

    db_fim_transacao(true);
    $oRetorno->erro  = true;
    $oRetorno->message = urlencode($eErro->getMessage());
}
echo $oJson->encode($oRetorno);