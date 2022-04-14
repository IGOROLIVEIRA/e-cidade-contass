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
      
            $result = $clquadrosuperavitdeficit->sql_record($clquadrosuperavitdeficit->sql_query("null", " CONCAT('1',substring(c241_fonte::TEXT, 2, 2)) c241_fonte, SUM(c241_valor) c241_valor", null, "c241_anousu = {$anousu} GROUP BY CONCAT('1',substring(c241_fonte::TEXT, 2, 2)) ORDER BY CONCAT('1',substring(c241_fonte::TEXT, 2, 2)) " ));
            // $oRetorno->fonte = $clquadrosuperavitdeficit->sql_query("null","*",null,"c241_anousu = {$anousu}");

            for ($i = 0; $i < pg_num_rows($result); $i++) {
                $oFonte = db_utils::fieldsMemory($result, $i);
                $aFonte[] = $oFonte;
            }
            ksort($aFonte);
            $oRetorno->fonte = $aFonte;
            
            break;

            case "getImportar":
                $aFonte = array();

                $clorctiporec = new cl_orctiporec();
                $sql = "select distinct o15_codtri from orctiporec o1 where o15_codtri != '' and o15_codtri::int >= 100 AND o15_codtri::int <= 299 AND o15_datalimite IS NULL order by o15_codtri";
            
                $recursos = $clorctiporec->sql_record($sql);
                $aRecurso = db_utils::getCollectionByRecord($recursos);

                foreach ($aRecurso as $oFot) :
                    // Tem que condicionar a classe do ano
                    $clbpdcasp71 = new cl_bpdcasp712022();

                    $rsSaldoFontes = db_query($clbpdcasp71->sql_query_saldoInicialContaCorrente(false, $oFot->o15_codtri)) ;

                    $oSaldoFontes = db_utils::fieldsMemory($rsSaldoFontes,0);
        
                    $nHash = "1" . substr($oFot->o15_codtri, 1, 2);
                    $nSaldoFinal = ($oSaldoFontes->saldoanterior + $oSaldoFontes->debito - $oSaldoFontes->credito);
   
                    if (array_key_exists($nHash, $aDadosSuperavitFontes)) {
                        if($iValorNumerico == 2){
                            $aDadosSuperavitFontes[$nHash]->c241_valor += $oSaldoFontes->saldoanterior;
                        }else{
                            $aDadosSuperavitFontes[$nHash]->c241_valor += $nSaldoFinal;
                        }
                    } else {
                        $oDadosSuperavitFonte = new stdClass();
                        $oDadosSuperavitFonte->c241_anousu = $iValorNumerico;
                        $oDadosSuperavitFonte->c241_fonte = "1" . substr($oFot->o15_codtri, 1, 2);
                        if($iValorNumerico == 2){
                            $oDadosSuperavitFonte->c241_valor = $oSaldoFontes->saldoanterior;
                        }else{
                            $oDadosSuperavitFonte->c241_valor = $nSaldoFinal;
                        }

                        $aDadosSuperavitFontes[$nHash] = $oDadosSuperavitFonte;
                    }
                   
                endforeach;
                ksort($aDadosSuperavitFontes);
                $oRetorno->fonte = $aDadosSuperavitFontes;
                
                break;    

        case "getSuplementado":
            $sql = "SELECT
                        concat('1', substring(o58_codigo::TEXT, 2, 2)) fonte,
                        sum(o47_valor) as valor
                    FROM
                        orcsuplemval
                        LEFT JOIN orcdotacao ON o47_coddot = o58_coddot
                        AND o47_anousu = o58_anousu
                        JOIN orcsuplem ON o47_codsup=o46_codsup
                    WHERE
                        o47_anousu = {$anousu}
                        AND o47_valor > 0
                        AND o46_tiposup IN (2026, 1003, 1008, 1024)
                    GROUP BY concat('1', substring(o58_codigo::TEXT, 2, 2))
                    UNION
                    select
                        concat('1', substring(o58_codigo::TEXT, 2, 2)) fonte,
                        sum(o136_valor) as valor
                    from
                        orcsuplemdespesappa
                        LEFT JOIN orcsuplemval ON o47_codsup = o136_orcsuplem
                        LEFT JOIN orcdotacao ON o47_coddot = o58_coddot
                        AND o47_anousu = o58_anousu
                        JOIN orcsuplem ON o47_codsup=o46_codsup
                    WHERE
                        o47_anousu = {$anousu}
                        AND o46_tiposup IN (2026, 1003, 1008, 1024)
                    AND 
                        o136_valor > 0 
                    GROUP BY concat('1', substring(o58_codigo::TEXT, 2, 2))";
            $result = db_query($sql);

            for ($i = 0; $i < pg_num_rows($result); $i++) {
                $oFonte = db_utils::fieldsMemory($result, $i);
                $aFonte[] = $oFonte;
            }
            ksort($aFonte);
            $oRetorno->fonte = $aFonte;
            
            break;
    }
} catch (Exception $eErro) {

    db_fim_transacao(true);
    $oRetorno->erro  = true;
    $oRetorno->message = urlencode($eErro->getMessage());
}
echo $oJson->encode($oRetorno);
