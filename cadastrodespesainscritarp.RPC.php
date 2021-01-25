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
include("classes/db_despesasinscritasRP_classe.php");
include("classes/db_disponibilidadecaixa_classe.php");
include("libs/db_libcontabilidade.php");
$instit = db_getsession("DB_instit");
$anousu = db_getsession("DB_anousu");

$cldespesainscritarp = new cl_despesasinscritasRP();
$cldisponibilidadedecaixa = new cl_disponibilidadecaixa();

$ctb = 'ctb20'.$anousu;
$ext = 'ext20'.$anousu;
$caixa = 'caixa11'.$anousu;

$clctb = db_utils::getDao($ctb);
$clcaixa = db_utils::getDao($caixa);
$clext = db_utils::getDao($ext);


$oJson    = new services_json();
$oRetorno = new stdClass();
$oParam   = json_decode(str_replace('\\', '',$_POST["json"]));
$oRetorno->status   = 1;
$oRetorno->erro     = false;
$oRetorno->message  = '';

$perini = $anousu . "-01-01";
$perfim = $anousu . "-12-31";


try{
    switch($oParam->exec) {

        case "getValores":
            $aFonte = array();

            $result = $cldisponibilidadedecaixa->sql_record($cldisponibilidadedecaixa->sql_query("null","*",null,"c224_instit = {$instit} and c224_anousu = {$anousu}"));
            // echo $cldisponibilidadedecaixa->sql_query("null","*",null,"c224_instit = {$instit} and c224_anousu = {$anousu}");
//die($cldisponibilidadedecaixa->sql_query("null","*",null,"c224_instit = {$instit} and c224_anousu = {$anousu}"));
            for ($i = 0; $i < pg_num_rows($result); $i++) {
                $oFonte = db_utils::fieldsMemory($result, $i);
                $aFonte[] = $oFonte;
            }
            $oRetorno->fonte = $aFonte;

            break;

        case "getSicom2019":

            $resultctb20 = $clctb->sql_record($clctb->sql_query(null,"si96_vlsaldofinalfonte,si96_codfontrecursos",null,"si96_mes = 12 and si96_vlsaldofinalfonte != 0 and si96_instit = {$instit}"));
            if(pg_num_rows($resultctb20) == 0){
              echo $oJson->encode(0);exit;
            }
            $vlrdiscaixabruta = array();
            for($i = 0; $i < pg_num_rows($resultctb20); $i++){
                $octb20 = db_utils::fieldsMemory($resultctb20,$i);

                $Hash = $octb20->si96_codfontrecursos;
                $vlsaldofinalfonte = new stdClass();

                if(!$vlrdiscaixabruta[$Hash]){
                    $vlsaldofinalfonte->valor += $octb20->si96_vlsaldofinalfonte;
                    $vlrdiscaixabruta[$Hash] = $vlsaldofinalfonte;
                }else{
                    $vlsaldofinalfonte = $vlrdiscaixabruta[$Hash];
                    $vlsaldofinalfonte->valor += $octb20->si96_vlsaldofinalfonte;
                }
            }

            /**
             * Aqui pego os valor do registro 11 caixa
             */

            $resultcaixa11 = $clcaixa->sql_record($clcaixa->sql_query(null,"si166_codfontecaixa,si166_vlsaldofinalfonte",null,"si166_mes = 12 and si166_vlsaldofinalfonte != 0 and si166_instit = {$instit}"));
            for($i = 0; $i < pg_num_rows($resultcaixa11); $i++){
                $ocaixa11 = db_utils::fieldsMemory($resultctb20, $i);

                $Hash = $ocaixa11->si166_codfontecaixa;

                if(!$vlrdiscaixabruta[$Hash]){
                    $vlsaldofinalfonte->valor += $ocaixa11->si166_vlsaldofinalfonte;
                    $vlrdiscaixabruta[$Hash] = $vlsaldofinalfonte;
                }else{
                    $vlsaldofinalfonte = $vlrdiscaixabruta[$Hash];
                    $vlsaldofinalfonte->valor += $ocaixa11->si166_vlsaldofinalfonte;
                }
            }

//            echo"<pre>";print_r($vlrdiscaixabruta);exit;

            /**
             * aqui irei montar a consulta para chegar ao valor de resto a pagar de exercicios anteriores
             *
             */

            $sSqlRec = "SELECT DISTINCT o15_codtri FROM orctiporec WHERE o15_codtri != '' /*and o15_codtri::int = 146*/ ORDER BY o15_codtri";
            $result = db_query($sSqlRec);

            $recurso = array();
            for ($i = 0; $i < pg_num_rows($result); $i++) {

                $oRecurso = db_utils::fieldsMemory($result, $i);

                $recurso[] = $oRecurso->o15_codtri;
            }
            foreach ($recurso as $fonte) {
                $sql = "SELECT e91_numemp,e91_vlremp,e91_vlranu,e91_vlrliq,e91_vlrpag,o15_codtri,vlranu,vlrliq,vlrpag,
                           vlrpagnproc,vlranuliq,vlranuliqnaoproc
                    FROM
                        (SELECT e91_numemp,e91_anousu,e91_codtipo,e90_descr,o15_descr,o15_codtri,c70_anousu,
                        coalesce(e91_vlremp,0) AS e91_vlremp,
                        coalesce(e91_vlranu,0) AS e91_vlranu,
                        coalesce(e91_vlrliq,0) AS e91_vlrliq,
                        coalesce(e91_vlrpag,0) AS e91_vlrpag,e91_recurso,
                        coalesce(vlranu,0) AS vlranu,
                        coalesce(vlranuliq,0) AS vlranuliq,
                        coalesce(vlranuliqnaoproc,0) AS vlranuliqnaoproc,
                        coalesce(vlrliq,0) AS vlrliq,
                        coalesce(vlrpag,0) AS vlrpag,
                        coalesce(vlrpagnproc,0) AS vlrpagnproc
                          FROM empresto
                          INNER JOIN emprestotipo ON e91_codtipo = e90_codigo
                          INNER JOIN orctiporec ON e91_recurso = o15_codigo
                          LEFT OUTER JOIN
                            (SELECT c75_numemp,c70_anousu,
                              sum(round(CASE WHEN c53_tipo = 11 THEN c70_valor ELSE 0 END,2)) AS vlranu,
                              sum(round(CASE WHEN c71_coddoc = 31 THEN c70_valor ELSE 0 END,2)) AS vlranuliq,
                              sum(round(CASE WHEN c71_coddoc = 32 THEN c70_valor ELSE 0 END,2)) AS vlranuliqnaoproc,
                              sum(round(CASE WHEN c53_tipo = 20 THEN c70_valor ELSE (CASE WHEN c53_tipo = 21 THEN c70_valor*-1 ELSE 0 END) END,2)) AS vlrliq,
                              sum(round(CASE WHEN c71_coddoc = 35 THEN c70_valor ELSE (CASE WHEN c71_coddoc = 36 THEN c70_valor*-1 ELSE 0 END) END,2)) AS vlrpag,
                              sum(round(CASE WHEN c71_coddoc = 37 THEN c70_valor ELSE (CASE WHEN c71_coddoc = 38 THEN c70_valor*-1 ELSE 0 END) END,2)) AS vlrpagnproc
                                FROM conlancamemp
                                INNER JOIN conlancamdoc ON c71_codlan = c75_codlan
                                INNER JOIN conhistdoc ON c53_coddoc = c71_coddoc
                                INNER JOIN conlancam ON c70_codlan = c75_codlan
                                INNER JOIN empempenho ON e60_numemp = c75_numemp
                                WHERE e60_anousu < " . DB_getsession("DB_anousu") . " AND c75_data BETWEEN '$perini' AND '$perfim'
                                AND e60_instit IN (" . db_getsession('DB_instit') . ") GROUP BY c75_numemp,c70_anousu) AS x ON x.c75_numemp = e91_numemp
                                WHERE e91_anousu = " . DB_getsession("DB_anousu") . " ) AS x
                                INNER JOIN empempenho ON e60_numemp = e91_numemp AND e60_instit IN (" . db_getsession('DB_instit') . ")
                                INNER JOIN empelemento ON e64_numemp = e60_numemp
                                INNER JOIN cgm ON z01_numcgm = e60_numcgm
                                INNER JOIN orcdotacao ON o58_coddot = e60_coddot AND o58_anousu = e60_anousu
                                AND o58_instit = e60_instit
                                INNER JOIN orcorgao ON o40_orgao = o58_orgao AND o40_anousu = o58_anousu
                                INNER JOIN orcunidade ON o41_anousu = o58_anousu AND o41_orgao = o58_orgao AND o41_unidade = o58_unidade
                                INNER JOIN orcfuncao ON o52_funcao = orcdotacao.o58_funcao
                                INNER JOIN orcsubfuncao ON o53_subfuncao = orcdotacao.o58_subfuncao
                                INNER JOIN orcprograma ON o54_programa = o58_programa AND o54_anousu = orcdotacao.o58_anousu
                                INNER JOIN orcprojativ ON o55_projativ = o58_projativ AND o55_anousu = orcdotacao.o58_anousu
                                INNER JOIN orcelemento ON o58_codele = o56_codele AND o58_anousu = o56_anousu AND 1=1
                                AND o15_codtri::int4 IN($fonte)
                                AND o15_codtri != ''
                                ORDER BY e91_recurso,e60_anousu,e60_codemp::bigint";

                $resultMovFonte = db_query($sql);
//                db_criatabela($resultMovFonte);

                for ($iContMov = 0; $iContMov < pg_num_rows($resultMovFonte); $iContMov++) {
                    $rsFontes = db_utils::fieldsMemory($resultMovFonte, $iContMov);
                    $aFontes[$rsFontes->o15_codtri][] = $rsFontes;
                }

                foreach ($aFontes as $fontes) {
                    $oVlrTote91Emp = 0;
                    $oVlrTote91Anu = 0;
                    $oVlrTote91Liq = 0;
                    $oVlrTote91Pag = 0;
                    $oVlrTotEmp = 0;
                    $oVlrTotLiq = 0;
                    $oVlrTotAnu = 0;
                    $oVlrTotPag = 0;

                    $vlrTotpagnproc = 0;
                    $vlrTotanuliq = 0;
                    $vlrTotanuliqnaoproc = 0;
                    $vlRspExeAnt = new stdClass();
                    foreach ($fontes as $item) {
                        $oVlrTote91Emp += $item->e91_vlremp;
                        $oVlrTote91Anu += $item->e91_vlranu;
                        $oVlrTote91Liq += $item->e91_vlrliq;
                        $oVlrTote91Pag += $item->e91_vlrpag;
                        $oVlrTotLiq += $item->vlrliq;
                        $oVlrTotAnu += $item->vlranu;
                        $oVlrTotPag += $item->vlrpag;
                        $vlrTotpagnproc += $item->vlrpagnproc;
                        $vlrTotanuliq += $item->vlranuliq;
                        $vlrTotanuliqnaoproc += $item->vlranuliqnaoproc;

                        $totLiq = ($oVlrTote91Liq - $oVlrTote91Pag - $oVlrTotPag - $vlrTotanuliq) + ($oVlrTotLiq - $vlrTotpagnproc);

                        $totNP = $oVlrTote91Emp - $oVlrTote91Anu - $oVlrTote91Liq - $vlrTotanuliqnaoproc - $oVlrTotLiq;

                        $vlRspExeAnt->vlRspExeAnt = $totLiq + $totNP;
                        $vlRspExerciciosAnteriores[$item->o15_codtri] = $vlRspExeAnt;
                    }
                }
            }
//                  echo "<pre>"; echo "totemp91: ".$oVlrTote91Emp;echo"<br>";
//                  echo "totanu91: ".$oVlrTote91Anu;echo"<br>";
//                  echo "totliq91: ".$oVlrTote91Liq;echo"<br>";
//                  echo "totpag91: ".$oVlrTote91Pag;echo"<br>";
//                  echo "totliq: ".$oVlrTotLiq;echo"<br>";
//                  echo "totanu: ".$oVlrTotAnu;echo"<br>";
//                  echo "totpag: ".$oVlrTotPag;echo"<br>";
//                  echo "totpagnproc: ".$vlrTotpagnproc;echo"<br>";
//                  echo "totanuliq: ".$vlrTotanuliq;echo"<br>";
//                  echo "totanuliqnaoproc: ".$vlrTotanuliqnaoproc;echo"<br>";
//                  echo "TotNP: ".$totNP;echo"<br>";
//                  echo "TotLiq: ".$totLiq;echo"<br>";
//                  exit;
            /***
             * busco informações do registro 20 ext com tipo de lançamento 01,02 e 99
             */
            $sSqlext20 = "SELECT si165_codfontrecursos,
                                   round(sum(case when si165_natsaldoatualfonte = 'D' then si165_vlsaldoatualfonte*-1 else si165_vlsaldoatualfonte end),2) AS si165_vlsaldoatualfonte,
                                   si165_natsaldoatualfonte,
                                   c60_tipolancamento
                            FROM ext20".db_getsession("DB_anousu")."
                            JOIN conplanoreduz ON c61_anousu = ".db_getsession("DB_anousu")." AND (c61_reduz = si165_codext OR c61_codtce = si165_codext)
                            JOIN conplano ON c60_codcon = c61_codcon AND c60_anousu = c61_anousu
                            WHERE (si165_instit, si165_mes) = ($instit, 12)
                             AND c60_tipolancamento IN (1, 2, 9999)
                            GROUP BY si165_codfontrecursos, si165_instit, si165_natsaldoatualfonte, c60_tipolancamento
                            ORDER BY si165_codfontrecursos";

            $resultext20 = db_query($sSqlext20);
            $vlrrestorecolherfonte = array();

            for($i = 0; $i < pg_num_rows($resultext20); $i++){
                $oExt20 = db_utils::fieldsMemory($resultext20, $i);

                $Hash = $oExt20->si165_codfontrecursos;
                $vlrrestorecolher = new stdClass();

                if(!$vlrrestorecolherfonte[$Hash]){
                    $vlrrestorecolher->valor += $oExt20->si165_vlsaldoatualfonte;
                    $vlrrestorecolherfonte[$Hash] = $vlrrestorecolher;
                }else{
                    $vlrrestorecolher = $vlrrestorecolherfonte[$Hash];
                    $vlrrestorecolher->valor += $oExt20->si165_vlsaldoatualfonte;
                }
            }
//    echo "<pre>"; print_r($vlrrestorecolherfonte);exit;
            /***
             * busco informações do registro 20 ext com tipo de lançamento 03
             */
            $sSqlext20 = "SELECT si165_codfontrecursos,
                                   round(sum(si165_vlsaldoatualfonte),2) AS si165_vlsaldoatualfonte,
                                   si165_natsaldoatualfonte,
                                   si124_tipolancamento
                            FROM ext20".db_getsession("DB_anousu")."
                            JOIN conplanoreduz ON c61_anousu = ".db_getsession("DB_anousu")." AND (c61_reduz = si165_codext OR c61_codtce = si165_codext)
                            JOIN conplano ON c60_codcon = c61_codcon AND c60_anousu = c61_anousu
                            WHERE (si165_instit, si165_mes) = ($instit, 12)
                             AND si124_tipolancamento IN ('03')
                            GROUP BY si165_codfontrecursos, si165_instit, si165_natsaldoatualfonte, si124_tipolancamento
                            ORDER BY si165_codfontrecursos";
            $resultext20 = db_query($sSqlext20);
            $vlrAtivoFinan = array();

            for($i = 0; $i < pg_num_rows($resultext20); $i++){
                $oExt20 = db_utils::fieldsMemory($resultext20, $i);

                $Hash = $oExt20->si165_codfontrecursos;
                $vlrAtivoFanceiro = new stdClass();

                if(!$vlrAtivoFinan[$Hash]){
                    $vlrAtivoFanceiro->valor += $oExt20->si165_vlsaldoatualfonte;
                    $vlrAtivoFinan[$Hash] = $vlrAtivoFanceiro;
                }else{
                    $vlrAtivoFanceiro = $vlrAtivoFinan[$Hash];
                    $vlrAtivoFanceiro->valor += $oExt20->si165_vlsaldoatualfonte;
                }
            }

            /**
             * Aqui irei calcular o valor de disponiblidade por fonte
             * @calculo
             * Valordiscaixabruta - vlrrpexerciciosanteriores - vlrrestorecolher + vlrregativofinanceiro
             *
             */

            $vlrDisponibilidade = array();
            $retornoSicom = array();


            foreach ($vlrdiscaixabruta as $fonte => $oDados){
                $vlrDisponibilidade[$fonte]->VlrDisponibilidade = $oDados->valor;
                if(!$retornoSicom[$fonte]){
                    $retornoSicom[$fonte]->vlrcaixabruta = $oDados->valor;
                }else{

                }
            }

            foreach ($vlRspExerciciosAnteriores as $fonte => $oDados){
                $vlrDisponibilidade[$fonte]->VlrDisponibilidade -= round($oDados->vlRspExeAnt,2);
                if(!$retornoSicom[$fonte]){
                    $retornoSicom[$fonte]->vlrcaixabruta = 0;
                    $retornoSicom[$fonte]->VlrroexercicioAnteriores = round($oDados->vlRspExeAnt,2);
                }else{
                    $retornoSicom[$fonte]->VlrroexercicioAnteriores = round($oDados->vlRspExeAnt,2);
                }
            }

            foreach ($vlrrestorecolherfonte as $fonte => $oDados){
                $vlrDisponibilidade[$fonte]->VlrDisponibilidade -= $oDados->valor;
                if(!$retornoSicom[$fonte]){
                    $retornoSicom[$fonte]->vlrcaixabruta = 0;
                    $retornoSicom[$fonte]->VlrroexercicioAnteriores = 0;
                    $retornoSicom[$fonte]->vlrrestorecolher = $oDados->valor;
                }else{
                    $retornoSicom[$fonte]->vlrrestorecolher = $oDados->valor;
                }
            }

            foreach ($vlrAtivoFinan as $fonte => $oDados){
                $vlrDisponibilidade[$fonte]->VlrDisponibilidade += $oDados->valor;

                if(!$retornoSicom[$fonte]){
                    $retornoSicom[$fonte]->vlrcaixabruta = 0;
                    $retornoSicom[$fonte]->VlrroexercicioAnteriores = 0;
                    $retornoSicom[$fonte]->vlrrestorecolher = 0;
                    $retornoSicom[$fonte]->vlrAtivoFian = $oDados->valor;
                }else{
                    $retornoSicom[$fonte]->vlrAtivoFian = $oDados->valor;
                }
            }

            foreach ($vlrDisponibilidade as $fonte => $oDados){
                if(!$retornoSicom[$fonte]){
                    $retornoSicom[$fonte]->vlrcaixabruta = 0;
                    $retornoSicom[$fonte]->VlrroexercicioAnteriores = 0;
                    $retornoSicom[$fonte]->vlrrestorecolher = 0;
                    $retornoSicom[$fonte]->vlrAtivoFian = 0;
                    $retornoSicom[$fonte]->vlrDisponibilidade = $oDados->VlrDisponibilidade;
                }else{
                    $retornoSicom[$fonte]->vlrDisponibilidade = $oDados->VlrDisponibilidade;
                }
            }
            $oRetorno->oDados[] = $retornoSicom;
//            echo "<pre>";print_r($retornoSicom);
            break;

      case "getSicom":

        $resultctb20 = $clctb->sql_record($clctb->sql_query(null,"round(si96_vlsaldofinalfonte,2) as si96_vlsaldofinalfonte ,si96_codfontrecursos",null,"si96_mes = 12 and si96_vlsaldofinalfonte != 0 and si96_instit = {$instit}"));
        if(pg_num_rows($resultctb20) == 0){
          echo $oJson->encode(0);exit;
        }
        $vlrdiscaixabruta = array();
        for($i = 0; $i < pg_num_rows($resultctb20); $i++){
          $octb20 = db_utils::fieldsMemory($resultctb20,$i);
          $Hash = $octb20->si96_codfontrecursos;
          $vlsaldofinalfonte = new stdClass();

          if(!$vlrdiscaixabruta[$Hash]){
            $vlsaldofinalfonte->valor += round($octb20->si96_vlsaldofinalfonte,2);
            $vlrdiscaixabruta[$Hash] = $vlsaldofinalfonte;
          }else{
            $vlsaldofinalfonte = $vlrdiscaixabruta[$Hash];
            $vlsaldofinalfonte->valor += round($octb20->si96_vlsaldofinalfonte,2);
          }
        }
        /**
         * Aqui pego os valor do registro 11 caixa
         */

        $resultcaixa11 = $clcaixa->sql_record($clcaixa->sql_query(null,"si166_codfontecaixa, round(si166_vlsaldofinalfonte,2) as si166_vlsaldofinalfonte",null,"si166_mes = 12 and si166_vlsaldofinalfonte != 0 and si166_instit = {$instit}"));
        for($i = 0; $i < pg_num_rows($resultcaixa11); $i++){
          $ocaixa11 = db_utils::fieldsMemory($resultctb20, $i);

          $Hash = $ocaixa11->si166_codfontecaixa;

          if(!$vlrdiscaixabruta[$Hash]){
            $vlsaldofinalfonte->valor += round($ocaixa11->si166_vlsaldofinalfonte,2);
            $vlrdiscaixabruta[$Hash] = $vlsaldofinalfonte;
          }else{
            $vlsaldofinalfonte = $vlrdiscaixabruta[$Hash];
            $vlsaldofinalfonte->valor += round($ocaixa11->si166_vlsaldofinalfonte,2);
          }
        }

        //echo"<pre>";print_r($vlrdiscaixabruta);exit;

        /**
         * aqui irei montar a consulta para chegar ao valor de resto a pagar de exercicios anteriores
         *
         */

        $sSqlRec = "SELECT DISTINCT o15_codtri FROM orctiporec WHERE o15_codtri != '' /*and o15_codtri::int = 146*/ ORDER BY o15_codtri";
        $result = db_query($sSqlRec);

        $recurso = array();
        for ($i = 0; $i < pg_num_rows($result); $i++) {

          $oRecurso = db_utils::fieldsMemory($result, $i);

          $recurso[] = $oRecurso->o15_codtri;
        }
        foreach ($recurso as $fonte) {
          $sql = "SELECT e91_numemp,e91_vlremp,e91_vlranu,e91_vlrliq,e91_vlrpag,o15_codtri,vlranu,vlrliq,vlrpag,
                           vlrpagnproc,vlranuliq,vlranuliqnaoproc
                    FROM
                        (SELECT e91_numemp,e91_anousu,e91_codtipo,e90_descr,o15_descr,o15_codtri,c70_anousu,
                        coalesce(e91_vlremp,0) AS e91_vlremp,
                        coalesce(e91_vlranu,0) AS e91_vlranu,
                        coalesce(e91_vlrliq,0) AS e91_vlrliq,
                        coalesce(e91_vlrpag,0) AS e91_vlrpag,e91_recurso,
                        coalesce(vlranu,0) AS vlranu,
                        coalesce(vlranuliq,0) AS vlranuliq,
                        coalesce(vlranuliqnaoproc,0) AS vlranuliqnaoproc,
                        coalesce(vlrliq,0) AS vlrliq,
                        coalesce(vlrpag,0) AS vlrpag,
                        coalesce(vlrpagnproc,0) AS vlrpagnproc
                          FROM empresto
                          INNER JOIN emprestotipo ON e91_codtipo = e90_codigo
                          INNER JOIN orctiporec ON e91_recurso = o15_codigo
                          LEFT OUTER JOIN
                            (SELECT c75_numemp,c70_anousu,
                              sum(round(CASE WHEN c53_tipo = 11 THEN c70_valor ELSE 0 END,2)) AS vlranu,
                              sum(round(CASE WHEN c71_coddoc = 31 THEN c70_valor ELSE 0 END,2)) AS vlranuliq,
                              sum(round(CASE WHEN c71_coddoc = 32 THEN c70_valor ELSE 0 END,2)) AS vlranuliqnaoproc,
                              sum(round(CASE WHEN c53_tipo = 20 THEN c70_valor ELSE (CASE WHEN c53_tipo = 21 THEN c70_valor*-1 ELSE 0 END) END,2)) AS vlrliq,
                              sum(round(CASE WHEN c71_coddoc = 35 THEN c70_valor ELSE (CASE WHEN c71_coddoc = 36 THEN c70_valor*-1 ELSE 0 END) END,2)) AS vlrpag,
                              sum(round(CASE WHEN c71_coddoc = 37 THEN c70_valor ELSE (CASE WHEN c71_coddoc = 38 THEN c70_valor*-1 ELSE 0 END) END,2)) AS vlrpagnproc
                                FROM conlancamemp
                                INNER JOIN conlancamdoc ON c71_codlan = c75_codlan
                                INNER JOIN conhistdoc ON c53_coddoc = c71_coddoc
                                INNER JOIN conlancam ON c70_codlan = c75_codlan
                                INNER JOIN empempenho ON e60_numemp = c75_numemp
                                WHERE e60_anousu < " . DB_getsession("DB_anousu") . " AND c75_data BETWEEN '$perini' AND '$perfim'
                                AND e60_instit IN (" . db_getsession('DB_instit') . ") GROUP BY c75_numemp,c70_anousu) AS x ON x.c75_numemp = e91_numemp
                                WHERE e91_anousu = " . DB_getsession("DB_anousu") . " ) AS x
                                INNER JOIN empempenho ON e60_numemp = e91_numemp AND e60_instit IN (" . db_getsession('DB_instit') . ")
                                INNER JOIN empelemento ON e64_numemp = e60_numemp
                                INNER JOIN cgm ON z01_numcgm = e60_numcgm
                                INNER JOIN orcdotacao ON o58_coddot = e60_coddot AND o58_anousu = e60_anousu
                                AND o58_instit = e60_instit
                                INNER JOIN orcorgao ON o40_orgao = o58_orgao AND o40_anousu = o58_anousu
                                INNER JOIN orcunidade ON o41_anousu = o58_anousu AND o41_orgao = o58_orgao AND o41_unidade = o58_unidade
                                INNER JOIN orcfuncao ON o52_funcao = orcdotacao.o58_funcao
                                INNER JOIN orcsubfuncao ON o53_subfuncao = orcdotacao.o58_subfuncao
                                INNER JOIN orcprograma ON o54_programa = o58_programa AND o54_anousu = orcdotacao.o58_anousu
                                INNER JOIN orcprojativ ON o55_projativ = o58_projativ AND o55_anousu = orcdotacao.o58_anousu
                                INNER JOIN orcelemento ON o58_codele = o56_codele AND o58_anousu = o56_anousu AND 1=1
                                AND o15_codtri::int4 IN($fonte)
                                AND o15_codtri != ''
                                ORDER BY e91_recurso,e60_anousu,e60_codemp::bigint";
          //echo $sql;exit;
          $resultMovFonte = db_query($sql);
          //db_criatabela($resultMovFonte);

          for ($iContMov = 0; $iContMov < pg_num_rows($resultMovFonte); $iContMov++) {
            $rsFontes = db_utils::fieldsMemory($resultMovFonte, $iContMov);
            $aFontes[$rsFontes->o15_codtri][] = $rsFontes;
          }

          foreach ($aFontes as $fontes) {
            $oVlrTote91Emp = 0;
            $oVlrTote91Anu = 0;
            $oVlrTote91Liq = 0;
            $oVlrTote91Pag = 0;
            $oVlrTotEmp = 0;
            $oVlrTotLiq = 0;
            $oVlrTotAnu = 0;
            $oVlrTotPag = 0;

            $vlrTotpagnproc = 0;
            $vlrTotanuliq = 0;
            $vlrTotanuliqnaoproc = 0;
            $vlRspExeAnt = new stdClass();
            foreach ($fontes as $item) {
              $oVlrTote91Emp += $item->e91_vlremp;
              $oVlrTote91Anu += $item->e91_vlranu;
              $oVlrTote91Liq += $item->e91_vlrliq;
              $oVlrTote91Pag += $item->e91_vlrpag;
              $oVlrTotLiq += $item->vlrliq;
              $oVlrTotAnu += $item->vlranu;
              $oVlrTotPag += $item->vlrpag;
              $vlrTotpagnproc += $item->vlrpagnproc;
              $vlrTotanuliq += $item->vlranuliq;
              $vlrTotanuliqnaoproc += $item->vlranuliqnaoproc;

              $totLiq = ($oVlrTote91Liq - $oVlrTote91Pag - $oVlrTotPag - $vlrTotanuliq) + ($oVlrTotLiq - $vlrTotpagnproc);

              $totNP = $oVlrTote91Emp - $oVlrTote91Anu - $oVlrTote91Liq - $vlrTotanuliqnaoproc - $oVlrTotLiq;

              $vlRspExeAnt->vlRspExeAnt = $totLiq + $totNP;
              $vlRspExerciciosAnteriores[$item->o15_codtri] = $vlRspExeAnt;
            }
          }
        }

        /**
         * Aqui irei calcular o valor de disponiblidade por fonte
         * @calculo
         * Valordiscaixabruta - vlrrpexerciciosanteriores - vlrrestorecolher + vlrregativofinanceiro
         *
         */

        $vlrDisponibilidade = array();
        $retornoSicom = array();


        foreach ($vlrdiscaixabruta as $fonte => $oDados){
          $vlrDisponibilidade[$fonte]->VlrDisponibilidade = round($oDados->valor,2);
          if(!$retornoSicom[$fonte]){
            $retornoSicom[$fonte]->vlrcaixabruta = round($oDados->valor,2);
          }else{

          }
        }

        $aFontesEncerradas = array('148', '149', '150', '151', '152', '248', '249', '250', '251', '252');
        
        foreach ($vlRspExerciciosAnteriores as $fonte => $oDados){

          if(in_array($fonte, $aFontesEncerradas)) {
            $fonte = substr($fonte, 0, 1).'59';
          }

          $vlrDisponibilidade[$fonte]->VlrDisponibilidade -= round($oDados->vlRspExeAnt,2);
          if(!$retornoSicom[$fonte]){
            $retornoSicom[$fonte]->vlrcaixabruta = 0;
            $retornoSicom[$fonte]->VlrroexercicioAnteriores = round($oDados->vlRspExeAnt,2);
          }else{
            $retornoSicom[$fonte]->VlrroexercicioAnteriores += round($oDados->vlRspExeAnt,2);
          }
        }

        foreach ($vlrDisponibilidade as $fonte => $oDados){
          if(!$retornoSicom[$fonte]){
            $retornoSicom[$fonte]->vlrcaixabruta = 0;
            $retornoSicom[$fonte]->VlrroexercicioAnteriores = 0;
            $retornoSicom[$fonte]->vlrrestorecolher = 0;
            $retornoSicom[$fonte]->vlrAtivoFian = 0;
            $retornoSicom[$fonte]->vlrDisponibilidade = $oDados->VlrDisponibilidade;
          }else{
            $retornoSicom[$fonte]->vlrDisponibilidade = $oDados->VlrDisponibilidade;
          }
        }

        $oRetorno->oDados[] = $retornoSicom;
        break;
    }
}catch (Exception $eErro) {

    db_fim_transacao (true);
    $oRetorno->erro  = true;
    $oRetorno->message = urlencode($eErro->getMessage());
}
echo $oJson->encode($oRetorno);

