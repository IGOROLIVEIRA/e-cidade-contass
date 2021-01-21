<?php
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

$oJson    = new services_json();
$oRetorno = new stdClass();

$oParam   = json_decode(str_replace('\\', '',$_POST["json"]));
//echo "<pre>";var_dump($oParam);exit;
$oRetorno->status   = 1;
$oRetorno->erro     = false;
$oRetorno->message  = '';
$cldespesainscritarp = new cl_despesasinscritasRP();
$cldisponibilidadedecaixa = new cl_disponibilidadecaixa();
$anousu = db_getsession("DB_anousu");
$instit = db_getsession("DB_instit");
try{
    switch($oParam->exec) {

        case "getRecurso":
            $clorctiporec = new cl_orctiporec();
            $recursos = $clorctiporec->sql_record($clorctiporec->sql_query_file(null,"o15_codtri,o15_descr",null,""));
            for ($i = 0; $i < $recursos; $i++) {
                $oFonte = db_utils::fieldsMemory($recursos, $i);
                $aFonte[] = $oFonte;
            }
            $oRetorno->fontes = $aFonte;
            break;

        case "salvar":
//            echo "<pre>"; print_r($oParam->itens);exit;
            foreach ($oParam->itens as $oItem) {

                $cldespesainscritarp->c223_codemp          = $oItem->c223_codemp;
                $cldespesainscritarp->c223_credor          = str_replace("'", "",$oItem->c223_credor);
                $cldespesainscritarp->c223_fonte           = $oItem->c223_fonte;
                $cldespesainscritarp->c223_vlrnaoliquidado = $oItem->c223_vlrnaoliquidado;
                $cldespesainscritarp->c223_vlrliquidado    = $oItem->c223_vlrliquidado;
                $cldespesainscritarp->c223_vlrdisRPNP      = $oItem->c223_vlrdisRPNP;
                $cldespesainscritarp->c223_vlrdisRPP       = $oItem->c223_vlrdisRPP;
                $cldespesainscritarp->c223_vlrsemdisRPNP   = $oItem->c223_vlrsemdisRPNP;
                $cldespesainscritarp->c223_vlrsemdisRPP    = $oItem->c223_vlrsemdisRPP;
                $cldespesainscritarp->c223_vlrdisptotal    = $oItem->c223_vlrdisptotal;
                $cldespesainscritarp->c223_vlrutilizado    = $oItem->c223_vlrutilizado;
                //calculo o valor disponivel
                $cldespesainscritarp->c223_vlrdisponivel   = $oItem->c223_vlrdisponivel;
                $cldespesainscritarp->c223_anousu          = db_getsession("DB_anousu");
                $cldespesainscritarp->c223_instit          = db_getsession("DB_instit");

                $result = $cldespesainscritarp->sql_record($cldespesainscritarp->sql_query(null,"c223_sequencial",null,"c223_codemp = {$oItem->c223_codemp} and c223_instit = ".db_getsession("DB_instit")." and c223_anousu = " . db_getsession("DB_anousu") . "."));
                db_fieldsmemory($result,0)->c223_sequencial;
                db_inicio_transacao();

                if ($result == 0) {
                    $cldespesainscritarp->incluir();
                } else {
//                   echo "<pre>"; print_r($cldespesainscritarp);exit;
                    $cldespesainscritarp->c223_sequencial = $c223_sequencial;
                    $cldespesainscritarp->alterar();
                }

                db_fim_transacao();

                if ($cldespesainscritarp->erro_status != 1) {
                    throw new Exception(
                        $cldespesainscritarp->erro_msg,
                        $cldespesainscritarp->erro_status
                    );
                }
                $oRetorno->sucesso = utf8_encode("Informações salvas com sucesso!");

            }
            break;

        case "getItens":

            $aItens      = array();

            if($oParam->fonte == 1){
                $where = null;
                $where .= " c223_anousu = ".db_getsession("DB_anousu");
            }else{
                $where = "c223_fonte = {$oParam->fonte}";
                $where .= " and c223_anousu = ".db_getsession("DB_anosusu");
            }

            $result = $cldespesainscritarp->sql_record($cldespesainscritarp->sql_query_file(null,"*",null,$where));
            //db_criatabela($result);
            for ($iContItens = 0; $iContItens < pg_num_rows($result); $iContItens++) {
                $oItens = db_utils::fieldsMemory($result, $iContItens);
                $aItens[] = $oItens;

                $oRetorno->itens  = $aItens;
            }

            break;

        case 'getUtilizado':

            $aFonts      = array();

            if($oParam->fonte == 1){
                $where = null;
                $where .= " c223_anousu = ".db_getsession("DB_anousu");
            }else{
                $where = "c223_fonte = {$oParam->fonte}";
                $where .= " and c223_anousu = ".db_getsession("DB_anousu");
            }

            $result = $cldespesainscritarp->sql_record($cldespesainscritarp->sql_query_file(null,"c223_fonte,c223_vlrdisrpnp,c223_vlrdisrpp,c223_vlrdisptotal,c223_vlrdisponivel,c223_vlrutilizado",null,$where));

            for ($iContItens = 0; $iContItens < pg_num_rows($result); $iContItens++) {
                $oItens = db_utils::fieldsMemory($result, $iContItens);
                $aItens[$oItens->c223_fonte][] = $oItens;
            }
            /** Calcula total disponivel por fonte */

            foreach ($aItens as $ifonte => $aItensFonte){
                $totalVlrDisrpnp = 0;
                $totalVlrDisrpp = 0;
                $oTotais = new stdClass();
                foreach ($aItensFonte as $oItem){
                    $oTotais->fonte = $oItem->c223_fonte;
                    $totalVlrDisrpnp += $oItem->c223_vlrdisrpnp;
                    $totalVlrDisrpp += $oItem->c223_vlrdisrpp;
                    $oTotais->saldoUtilizado = $totalVlrDisrpnp + $totalVlrDisrpp;
                }
                $oRetorno->fontes[]          = $oTotais;
            }
//            echo "<pre>";print_r($oRetorno);exit;
            break;

        case 'getDisponibilidadetotal':

            if($oParam->fonte == 1){
                $where = null;
            }else{
                $where = " and c224_fonte = {$oParam->fonte}";
            }

            $result = $cldisponibilidadedecaixa->sql_record($cldisponibilidadedecaixa->sql_query(null,"c224_vlrdisponibilidadecaixa,c224_fonte",null,"c224_instit = {$instit} $where and c224_anousu = {$anousu}"));
            //die($cldisponibilidadedecaixa->sql_query(null,"c224_vlrdisponibilidadecaixa,c224_fonte",null,"c224_instit = {$instit} and c224_anousu = {$anousu} $where"));
            for($i=0; $i < pg_num_rows($result); $i++){
                $oDisponibilidade = db_utils::fieldsMemory($result, $i);
                $oRetorno->dispobilidade[] = $oDisponibilidade;
            }

            break;
    }

} catch (Exception $eErro) {

    db_fim_transacao (true);
    $oRetorno->erro  = true;
    $oRetorno->message = urlencode($eErro->getMessage());
}

echo $oJson->encode($oRetorno);
