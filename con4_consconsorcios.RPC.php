<?php

require_once("std/db_stdClass.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("libs/db_app.utils.php");

require_once("classes/db_consexecucaoorc_classe.php");

db_postmemory($_POST);

$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\","",$_POST["json"]));

$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$sqlerro           = false;
$oRetorno->iOpcao  = 1;

$iAnoUsu = db_getsession('DB_anousu');

try {

    switch ($oParam->exec) {

        case "getRegistrosAno":

            $clconsexecucaoorc  = new cl_consexecucaoorc;
            $sSqlExecOrc        = getRegistrosAno($oParam->iConsorcio, $oParam->iMes, $iAnoUsu);
            $rsResultExecOrc    = db_query($sSqlExecOrc);
            $oRetorno->aItens   = array();
            $oRetorno->aItens   = db_utils::getCollectionByRecord($rsResultExecOrc);
            $oRetorno->iNumReg  = pg_num_rows($rsResultExecOrc);
            $oRetorno->iMes     = $oParam->iMes;
            $oRetorno->iOpcao   = $oParam->iOpcao;
            
        break;

        case "salvar":

            db_inicio_transacao();

            foreach ($oParam->aItens as $oItem) {

                $rsResultExecOrc = getExecOrc($oItem, true, $iAnoUsu);

                /**
                 * Se existir o agrupamento para o mês só atualiza os valores
                 * Caso contrário, criará um novo registro para o mês
                 */
                if(pg_num_rows($rsResultExecOrc) > 0) {

                    $oConsExerOrc = db_utils::fieldsMemory($rsResultExecOrc, 0);

                    $clconsexecucaoorc  = new cl_consexecucaoorc;
                    $clconsexecucaoorc->c202_sequencial         = $oConsExerOrc->c202_sequencial;
                    $clconsexecucaoorc->c202_valorempenhado     = $oItem->c202_valorempenhado;
                    $clconsexecucaoorc->c202_valorempenhadoanu  = $oItem->c202_valorempenhadoanu;
                    $clconsexecucaoorc->c202_valorliquidado     = $oItem->c202_valorliquidado;
                    $clconsexecucaoorc->c202_valorliquidadoanu  = $oItem->c202_valorliquidadoanu;
                    $clconsexecucaoorc->c202_valorpago          = $oItem->c202_valorpago;
                    $clconsexecucaoorc->c202_valorpagoanu       = $oItem->c202_valorpagoanu;

                    $clconsexecucaoorc->alterar($oConsExerOrc->c202_sequencial);
                    
                    if($clconsexecucaoorc->erro_status == "0") {
                        throw new Exception("Erro ao atualizar função ($oItem->c202_subfuncao) subfunção ($oItem->c202_subfuncao) fonte ($oItem->c202_codfontrecursos) elemento ($oItem->c202_elemento). ".$clconsexecucaoorc->erro_sql, null);
                    }                    

                } else {
                    
                    $retorno = novoExercOrc($oItem, $iAnoUsu);
                    $sqlerro = $retorno->sqlerro;

                    if($sqlerro) {
                        throw new Exception($retorno->sMensagem, null);
                    }

                }

            }

            $oRetorno->sMensagem    = "Registros atualizados com sucesso.";
            $oRetorno->iMes         = $oItem->c202_mescompetencia;

        break;

        case 'salvarNovo':
            
            db_inicio_transacao();

            $rsResultExecOrc = getExecOrc($oParam->oItem, false, $iAnoUsu);

            if(pg_num_rows($rsResultExecOrc) > 0) {
                throw new Exception("Já existe a função, subfunção, fonte de recursos e elemento para o ano.", null);
            } else {

                $retorno = novoExercOrc($oParam->oItem, $iAnoUsu);
                $sqlerro = $retorno->sqlerro;

                if(!$sqlerro) {
                    $oRetorno->sMensagem    = "Dados incluídos com sucesso.";
                    $oRetorno->oItem        = $oParam->oItem;
                    $oRetorno->iMes         = $oParam->oItem->c202_mescompetencia;
                } else {
                    throw new Exception($retorno->sMensagem, null);
                }

            }

        break;

        case 'excluir':

            $oRetorno->aItensExcluidos = array();

            foreach ($oParam->aItens as $oItem) {

                db_inicio_transacao();

                /**
                 * Verifica se não há valores lançados para o agrupamento no antes de excluir
                 */
                if(verificaValoresZerados($oItem, $iAnoUsu)) {
                    
                    $retornoExclusao = excluir($oItem, $iAnoUsu);

                    if($retornoExclusao) {
                        $oRetorno->sMensagem = "Informações removidas com sucesso";
                        array_push($oRetorno->aItensExcluidos, $oItem->iItem);
                    } else {
                        throw new Exception("Erro ao excluir", null);
                    }

                } else {
                    throw new Exception("Não foi possivel excluir, pois há valores lançados para o agrupamento: Função ({$oItem->c202_funcao}), Subfunção ({$oItem->c202_subfuncao}), Fonte ({$oItem->c202_codfontrecursos}) e Elemento ({$oItem->c202_elemento}).", null);
                }

            }

        break;

        case "salvarMesReferencia":

            for($iMes = 1; $iMes <= 12; $iMes++) {
                
                $clconsexecucaoorc  = new cl_consexecucaoorc;
                $sSqlWhere          = " c202_consconsorcios         = {$oParam->c202_consconsorcios} 
                                        and c202_anousu             = {$iAnoUsu} 
                                        and c202_mescompetencia     = {$iMes}";                  
                
                $sSqlExecOrc    = $clconsexecucaoorc->sql_query_file(null, "*", null, $sSqlWhere);
                $rsResult       = db_query($sSqlExecOrc);

                for($i = 0; $i < pg_num_rows($rsResult); $i++) {

                    $clconsexecucaoorc = new cl_consexecucaoorc;
                    $c202_sequencial   = db_utils::fieldsMemory($rsResult, $i)->c202_sequencial;                                       
                    $clconsexecucaoorc->c202_sequencial = db_utils::fieldsMemory($rsResult, $i)->c202_sequencial;
                    $clconsexecucaoorc->c202_mesreferenciasicom = $oParam->aMeses[$iMes];

                    $clconsexecucaoorc->alterar($c202_sequencial);

                    if($clconsexecucaoorc->erro_status == "0") {
                        throw new Exception("Erro ao atualizar registros. ".$clconsexecucaoorc->erro_sql, null);
                    }

                }
                
            }

            $oRetorno->sMensagem    = "Registros atualizados com sucesso.";

        break;

    }

    db_fim_transacao(false);
    $oRetorno->sMensagem = urlencode($oRetorno->sMensagem);
    echo $oJson->encode($oRetorno);

} catch (Exception $e) {
   
    db_fim_transacao(true);
    $oRetorno->sMensagem    = urlencode($e->getMessage());
    $oRetorno->status       = 2;
    echo $oJson->encode($oRetorno);

}

/**
 * Cria novo registro de execução orçamentária
 * @param $oItem
 * @param $iAnoUsu
 */
function novoExercOrc($oItem, $iAnoUsu) {

    $clconsexecucaoorc  = new cl_consexecucaoorc;
    $clconsexecucaoorc->c202_consconsorcios     = $oItem->c202_consconsorcios;
    $clconsexecucaoorc->c202_mescompetencia     = $oItem->c202_mescompetencia;
    $clconsexecucaoorc->c202_mesreferenciasicom = $oItem->c202_mescompetencia;
    $clconsexecucaoorc->c202_funcao             = $oItem->c202_funcao;
    $clconsexecucaoorc->c202_subfuncao          = $oItem->c202_subfuncao;
    $clconsexecucaoorc->c202_elemento           = $oItem->c202_elemento;
    $clconsexecucaoorc->c202_valorempenhado     = '0';
    $clconsexecucaoorc->c202_valorempenhadoanu  = '0';
    $clconsexecucaoorc->c202_valorliquidado     = '0';
    $clconsexecucaoorc->c202_valorliquidadoanu  = '0';
    $clconsexecucaoorc->c202_valorpago          = '0';
    $clconsexecucaoorc->c202_valorpagoanu       = '0';
    $clconsexecucaoorc->c202_codfontrecursos    = $oItem->c202_codfontrecursos;
    $clconsexecucaoorc->c202_anousu             = $iAnoUsu;

    $clconsexecucaoorc->incluir(null);

    $oRetorno->sqlerro=false;

    if($clconsexecucaoorc->erro_status == 0) {
        $oRetorno->sMensagem = "Erro ao criar novo registro.";
        $oRetorno->sMensagem .= $clconsexecucaoorc->erro_sql;
        $oRetorno->sqlerro=true;
    }

    return $oRetorno;

}

/**
 * Exclui execução orçamentária do consórcio
 * @return bool
 */
function excluir($oItem, $iAnoUsu) {

    $rsResult = getExecOrc($oItem, false, $iAnoUsu);
    
    for($i = 0; $i < pg_num_rows($rsResult); $i++) {

        $clconsexecucaoorc  = new cl_consexecucaoorc;
        $c202_sequencial    = db_utils::fieldsMemory($rsResult, $i)->c202_sequencial;
        $clconsexecucaoorc->excluir($c202_sequencial);

        if($clconsexecucaoorc->erro_status == "0") {
            return $clconsexecucaoorc;
        }
    
    }
    
    return true;

}

/**
 * Veririca se os valores lançados para o agrupamento está zerado
 * @param $oItem
 * @param $iAnoUsu
 * @return bool
 */
function verificaValoresZerados($oItem, $iAnoUsu) {
    
    $sCampos            = " sum(c202_valorempenhado)    AS valorempenhado,
                            sum(c202_valorempenhadoanu) AS valorempenhadoanu,
                            sum(c202_valorliquidado)    AS valorliquidado,
                            sum(c202_valorliquidadoanu) AS valorliquidadoanu,
                            sum(c202_valorpago)         AS valorpago,
                            sum(c202_valorpagoanu)      AS valorpagoanu";
    
    $sWhere1            = " c202_consconsorcios = {$oItem->c202_consconsorcios}
                            AND c202_anousu = {$iAnoUsu}
                            AND c202_funcao = {$oItem->c202_funcao}
                            AND c202_subfuncao = {$oItem->c202_subfuncao}
                            AND c202_codfontrecursos = {$oItem->c202_codfontrecursos}
                            AND c202_elemento = {$oItem->c202_elemento}";

    $sWhere2            = " valorempenhado = 0
                            and valorempenhadoanu = 0
                            and valorliquidado = 0
                            and valorliquidadoanu = 0
                            and valorpago = 0
                            and valorpagoanu = 0";
    
    $clconsexecucaoorc  = new cl_consexecucaoorc;
    $sSql1              = $clconsexecucaoorc->sql_query_file(null, $sCampos, null, $sWhere1);
    $sSql2              = "SELECT * FROM ($sSql1) AS x WHERE $sWhere2";

    $rsResultExecOrc    = db_query($sSql2);
    
    if(pg_num_rows($rsResultExecOrc) > 0) {
        return true;
    } else {
        return false;
    }    

}

/**
 * Busca execução orçamentária
 * @param $oItem
 * @param $bMes
 * @param $iAnoUsu
 */
function getExecOrc($oItem, $bMes, $iAnoUsu) {

    $clconsexecucaoorc  = new cl_consexecucaoorc;
    $sSqlWhere          = " c202_consconsorcios         = {$oItem->c202_consconsorcios} 
                            and c202_anousu             = {$iAnoUsu} 
                            and c202_funcao             = {$oItem->c202_funcao}
                            and c202_subfuncao          = {$oItem->c202_subfuncao}
                            and c202_codfontrecursos    = {$oItem->c202_codfontrecursos}
                            and c202_elemento           = {$oItem->c202_elemento}";
    if ($bMes) {
        $sSqlWhere .= " and c202_mescompetencia     = {$oItem->c202_mescompetencia}";
    }                            
    
    $sSqlExecOrc = $clconsexecucaoorc->sql_query_file(null, "*", null, $sSqlWhere);

    return db_query($sSqlExecOrc);

}

/**
 * Busca todos as execuções orçamentárias no ano do consórcio
 * Busca os valores lançados para o mês
 * Agrupa os valores lançados até o mês
 * @param $c202_consconsorcios
 * @param $c202_mescompetencia
 * @param $c202_anousu
 * @return string
 */
function getRegistrosAno($c202_consconsorcios, $c202_mescompetencia, $c202_anousu) {

    $sCampos1 = " *, (SELECT CASE WHEN sum(c202_valorempenhado) IS NULL THEN 0 ELSE sum(c202_valorempenhado) END as c202_valorempenhado
                    FROM consexecucaoorc
                    WHERE c202_mescompetencia = {$c202_mescompetencia}
                        AND c202_funcao = x.c202_funcao
                        AND c202_subfuncao = x.c202_subfuncao
                        AND c202_elemento = x.c202_elemento
                        AND c202_anousu = x.c202_anousu
                        AND c202_codfontrecursos = x.c202_codfontrecursos
                        AND c202_consconsorcios = x.c202_consconsorcios),
                  (SELECT CASE WHEN sum(c202_valorempenhadoanu) IS NULL THEN 0 ELSE sum(c202_valorempenhadoanu) END as c202_valorempenhadoanu
                    FROM consexecucaoorc
                    WHERE c202_mescompetencia = {$c202_mescompetencia}
                        AND c202_funcao = x.c202_funcao
                        AND c202_subfuncao = x.c202_subfuncao
                        AND c202_elemento = x.c202_elemento
                        AND c202_anousu = x.c202_anousu
                        AND c202_codfontrecursos = x.c202_codfontrecursos
                        AND c202_consconsorcios = x.c202_consconsorcios),
                  (SELECT CASE WHEN sum(c202_valorliquidado) IS NULL THEN 0 ELSE sum(c202_valorliquidado) END as c202_valorliquidado
                  FROM consexecucaoorc
                  WHERE c202_mescompetencia = {$c202_mescompetencia}
                      AND c202_funcao = x.c202_funcao
                      AND c202_subfuncao = x.c202_subfuncao
                      AND c202_elemento = x.c202_elemento
                      AND c202_anousu = x.c202_anousu
                      AND c202_codfontrecursos = x.c202_codfontrecursos
                      AND c202_consconsorcios = x.c202_consconsorcios),
                  (SELECT CASE WHEN sum(c202_valorliquidadoanu) IS NULL THEN 0 ELSE sum(c202_valorliquidadoanu) END as c202_valorliquidadoanu
                  FROM consexecucaoorc
                  WHERE c202_mescompetencia = {$c202_mescompetencia}
                      AND c202_funcao = x.c202_funcao
                      AND c202_subfuncao = x.c202_subfuncao
                      AND c202_elemento = x.c202_elemento
                      AND c202_anousu = x.c202_anousu
                      AND c202_codfontrecursos = x.c202_codfontrecursos
                      AND c202_consconsorcios = x.c202_consconsorcios),
                  (SELECT CASE WHEN sum(c202_valorpago) IS NULL THEN 0 ELSE sum(c202_valorpago) END as c202_valorpago
                  FROM consexecucaoorc
                  WHERE c202_mescompetencia = {$c202_mescompetencia}
                      AND c202_funcao = x.c202_funcao
                      AND c202_subfuncao = x.c202_subfuncao
                      AND c202_elemento = x.c202_elemento
                      AND c202_anousu = x.c202_anousu
                      AND c202_codfontrecursos = x.c202_codfontrecursos
                      AND c202_consconsorcios = x.c202_consconsorcios),
                  (SELECT CASE WHEN sum(c202_valorpagoanu) IS NULL THEN 0 ELSE sum(c202_valorpagoanu) END as c202_valorpagoanu
                  FROM consexecucaoorc
                  WHERE c202_mescompetencia = {$c202_mescompetencia}
                      AND c202_funcao = x.c202_funcao
                      AND c202_subfuncao = x.c202_subfuncao
                      AND c202_elemento = x.c202_elemento
                      AND c202_anousu = x.c202_anousu
                      AND c202_codfontrecursos = x.c202_codfontrecursos
                      AND c202_consconsorcios = x.c202_consconsorcios),
                (SELECT CASE WHEN SUM(c202_valorempenhado) IS NULL THEN 0 ELSE SUM(c202_valorempenhado) END AS empenhado_ate_mes
                  FROM consexecucaoorc
                  WHERE c202_mescompetencia <= {$c202_mescompetencia}
                      AND c202_funcao = x.c202_funcao
                      AND c202_subfuncao = x.c202_subfuncao
                      AND c202_elemento = x.c202_elemento
                      AND c202_anousu = x.c202_anousu
                      AND c202_codfontrecursos = x.c202_codfontrecursos
                      AND c202_consconsorcios = x.c202_consconsorcios),
                  (SELECT CASE WHEN SUM(c202_valorempenhadoanu) IS NULL THEN 0 ELSE SUM(c202_valorempenhadoanu) END AS empenhado_anulado_ate_mes
                  FROM consexecucaoorc
                  WHERE c202_mescompetencia <= {$c202_mescompetencia}
                      AND c202_funcao = x.c202_funcao
                      AND c202_subfuncao = x.c202_subfuncao
                      AND c202_elemento = x.c202_elemento
                      AND c202_anousu = x.c202_anousu
                      AND c202_codfontrecursos = x.c202_codfontrecursos
                      AND c202_consconsorcios = x.c202_consconsorcios),
                  (SELECT CASE WHEN SUM(c202_valorliquidado) IS NULL THEN 0 ELSE SUM(c202_valorliquidado) END AS liquidado_ate_mes
                  FROM consexecucaoorc
                  WHERE c202_mescompetencia <= {$c202_mescompetencia}
                      AND c202_funcao = x.c202_funcao
                      AND c202_subfuncao = x.c202_subfuncao
                      AND c202_elemento = x.c202_elemento
                      AND c202_anousu = x.c202_anousu
                      AND c202_codfontrecursos = x.c202_codfontrecursos
                      AND c202_consconsorcios = x.c202_consconsorcios),
                  (SELECT CASE WHEN SUM(c202_valorliquidadoanu) IS NULL THEN 0 ELSE SUM(c202_valorliquidadoanu) END AS liquidado_anulado_ate_mes
                  FROM consexecucaoorc
                  WHERE c202_mescompetencia <= {$c202_mescompetencia}
                      AND c202_funcao = x.c202_funcao
                      AND c202_subfuncao = x.c202_subfuncao
                      AND c202_elemento = x.c202_elemento
                      AND c202_anousu = x.c202_anousu
                      AND c202_codfontrecursos = x.c202_codfontrecursos
                      AND c202_consconsorcios = x.c202_consconsorcios),
                  (SELECT CASE WHEN SUM(c202_valorpago) IS NULL THEN 0 ELSE SUM(c202_valorpago) END AS pago_ate_mes
                  FROM consexecucaoorc
                  WHERE c202_mescompetencia <= {$c202_mescompetencia}
                      AND c202_funcao = x.c202_funcao
                      AND c202_subfuncao = x.c202_subfuncao
                      AND c202_elemento = x.c202_elemento
                      AND c202_anousu = x.c202_anousu
                      AND c202_codfontrecursos = x.c202_codfontrecursos
                      AND c202_consconsorcios = x.c202_consconsorcios),
                  (SELECT CASE WHEN SUM(c202_valorpagoanu) IS NULL THEN 0 ELSE SUM(c202_valorpagoanu) END AS pago_anulado_ate_mes
                  FROM consexecucaoorc
                  WHERE c202_mescompetencia <= {$c202_mescompetencia}
                      AND c202_funcao = x.c202_funcao
                      AND c202_subfuncao = x.c202_subfuncao
                      AND c202_elemento = x.c202_elemento
                      AND c202_anousu = x.c202_anousu
                      AND c202_codfontrecursos = x.c202_codfontrecursos
                      AND c202_consconsorcios = x.c202_consconsorcios)";

    $sCampos2 = " DISTINCT  c202_funcao,
                            c202_subfuncao,
                            c202_elemento,
                            c202_codfontrecursos,
                            c202_anousu,
                            c202_consconsorcios";                     

    $clconsexecucaoorc  = new cl_consexecucaoorc;
    $sWhere             = " c202_consconsorcios = {$c202_consconsorcios} AND c202_anousu = {$c202_anousu} ";
    $sSql               = $clconsexecucaoorc->sql_query_file(null, $sCampos2, null, $sWhere);
    $sSql2              = "SELECT $sCampos1 FROM ($sSql) AS x order by c202_elemento";

    return $sSql2;

}

?>
