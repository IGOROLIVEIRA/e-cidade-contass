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
      
            $result = $clquadrosuperavitdeficit->sql_record($clquadrosuperavitdeficit->sql_query("null", " CONCAT('1',substring(c241_fonte::TEXT, 2, 2)) c241_fonte, SUM(c241_valor) c241_valor", null, "c241_ano = {$anousu} GROUP BY CONCAT('1',substring(c241_fonte::TEXT, 2, 2)) ORDER BY CONCAT('1',substring(c241_fonte::TEXT, 2, 2)) " ));
            // $oRetorno->fonte = $clquadrosuperavitdeficit->sql_query("null","*",null,"c241_ano = {$anousu}");

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
                $sql = "select DISTINCT o15_codigo, o15_codtri FROM orctiporec where o15_codtri is not null";
            
                $recursos = $clorctiporec->sql_record($sql);
                $aRecurso = db_utils::getCollectionByRecord($recursos);
                $aDadosSuperavitFontes = array();

                foreach ($aRecurso as $oFot) :
                    // Tem que condicionar a classe do ano
                    $clbpdcasp71 = new cl_bpdcasp712022();

                    $rsSaldoFontes = db_query($clbpdcasp71->sql_query_saldoInicialContaCorrente(true, $oFot->o15_codigo));

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



function sql_query_saldoInicialContaCorrente ($iInstit=false,$iFonte=null, $sIntituicoes, $iAno=null){

    $sSqlReduzSuperavit = "select c61_reduz from conplano inner join conplanoreduz on c60_codcon=c61_codcon and c61_anousu=c60_anousu 
                         where substr(c60_estrut,1,5)='82111' and c60_anousu=" . $iAno ." and c61_anousu=" . $iAno;
    $sWhere =  " AND conhistdoc.c53_tipo not in (1000) ";

    if($iAno==2016){
        $iAno = 2017;
        $sSqlReduzSuperavit = "select c61_reduz from conplano inner join conplanoreduz on c60_codcon=c61_codcon and c61_anousu=c60_anousu 
                         where substr(c60_estrut,1,5)='82910' and c60_anousu=2017 and c61_anousu=2017";
        $sWhere =  " AND conhistdoc.c53_tipo in (2023) ";
    }

    if($iInstit==false){
        $sSqlReduzSuperavit = $sSqlReduzSuperavit." and c61_instit in (".$sIntituicoes.")";
    }

    $sSqlSaldos = " SELECT saldoanterior , debito , credito
                                    FROM
                                      (select coalesce((SELECT SUM(saldoanterior) AS saldoanterior FROM
                                                (SELECT CASE WHEN c29_debito > 0 THEN c29_debito WHEN c29_credito > 0 THEN -1 * c29_credito ELSE 0 END AS saldoanterior
                                                 FROM contacorrente
                                                 INNER JOIN contacorrentedetalhe ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                                                 INNER JOIN contacorrentesaldo ON contacorrentesaldo.c29_contacorrentedetalhe = contacorrentedetalhe.c19_sequencial
                                                 AND contacorrentesaldo.c29_mesusu = 0 and contacorrentesaldo.c29_anousu = c19_conplanoreduzanousu
                                                 WHERE c19_reduz IN ( $sSqlReduzSuperavit )
                                                   AND c19_conplanoreduzanousu = " . $iAno . "
                                                   AND c17_sequencial = 103
                                                   AND c19_orctiporec = {$iFonte}) as x),0) saldoanterior) AS saldoanteriores,

                                        (select coalesce((SELECT sum(c69_valor) as credito
                                         FROM conlancamval
                                         INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                         AND conlancam.c70_anousu = conlancamval.c69_anousu
                                         INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                         INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                         INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                         INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                         INNER JOIN contacorrente ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                                         WHERE c28_tipo = 'C'
                                           AND DATE_PART('YEAR',c69_data) = " . $iAno . "
                                           AND c17_sequencial = 103
                                           AND c19_reduz IN (  $sSqlReduzSuperavit  )
                                           AND c19_conplanoreduzanousu = " . $iAno . "
                                           AND c19_orctiporec = {$iFonte}
                                          ".$sWhere."
                                         GROUP BY c28_tipo),0) as credito) AS creditos,

                                        (select coalesce((SELECT sum(c69_valor) as debito
                                         FROM conlancamval
                                         INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                         AND conlancam.c70_anousu = conlancamval.c69_anousu
                                         INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                         INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                         INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                         INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                         INNER JOIN contacorrente  ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                                         WHERE c28_tipo = 'D'
                                           AND DATE_PART('YEAR',c69_data) = " . $iAno . "
                                           AND c17_sequencial = 103
                                           AND c19_reduz IN ( $sSqlReduzSuperavit )
                                           AND c19_conplanoreduzanousu = " . $iAno . "
                                           AND c19_orctiporec = {$iFonte} 
                                           ".$sWhere."                                              
                                         GROUP BY c28_tipo),0) as debito) AS debitos";

    return $sSqlSaldos;


}
