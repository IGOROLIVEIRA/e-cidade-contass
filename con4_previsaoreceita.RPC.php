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

require_once("classes/db_prevconvenioreceita_classe.php");

db_postmemory($_POST);

$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\","",$_POST["json"]));

$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$sqlerro           = false;

$iAnoUsu = db_getsession('DB_anousu');
$iInstit = db_getsession('DB_instit');

try {

    switch ($oParam->exec) {

        case "buscaConvenios":

            $sSql = "   SELECT  o70_codrec,
                                c206_sequencial,
                                c206_nroconvenio,
                                c229_convenio,
                                c206_objetoconvenio,
                                c206_dataassinatura,
                                sum(c229_vlprevisto) AS c229_vlprevisto,
                                sum(valor_arrecadado) as valor_arrecadado
                        FROM 
                            (SELECT  o70_codrec,
                                    c206_sequencial,
                                    c206_nroconvenio,
                                    c229_convenio,
                                    c206_objetoconvenio,
                                    c206_dataassinatura,
                                    sum(c229_vlprevisto) AS c229_vlprevisto,
                                    0 AS valor_arrecadado
                            FROM prevconvenioreceita
                                LEFT JOIN orcreceita ON c229_anousu = o70_anousu AND c229_fonte = o70_codrec 
                                LEFT JOIN convconvenios ON c206_sequencial = c229_convenio
                            WHERE o70_codigo IN ('122','123','124','142')
                                AND o70_anousu = {$iAnoUsu}
                                AND o70_instit = {$iInstit}
                                AND o70_valor > 0
                                AND o70_codrec = {$oParam->iCodRec}                    
                            GROUP BY 1,2,3,4,5
                            UNION
                            SELECT *
                            FROM
                                (SELECT o70_codrec,
                                    c206_sequencial,
                                    c206_nroconvenio,
                                    c229_convenio,
                                    c206_objetoconvenio,
                                    c206_dataassinatura,
                                    0 AS c229_vlprevisto,
                                    round(sum(CASE WHEN c71_coddoc = 100 THEN c70_valor ELSE c70_valor * -1 END),2) AS valor_arrecadado
                                FROM orcreceita 
                                    LEFT JOIN conlancamrec ON c74_anousu = o70_anousu AND c74_codrec = o70_codrec
                                    INNER JOIN conlancam ON c70_codlan = c74_codlan
                                    LEFT JOIN conlancamdoc ON c74_codlan = c71_codlan
                                    LEFT JOIN conlancamcorrente ON c86_conlancam = c74_codlan
                                    LEFT JOIN corplacaixa ON (k82_id,k82_data,k82_autent) = (c86_id,c86_data,c86_autent)
                                    LEFT JOIN placaixarec ON k81_seqpla = k82_seqpla
                                    LEFT JOIN convconvenios ON c206_sequencial = k81_convenio
                                    LEFT JOIN prevconvenioreceita ON c229_anousu = o70_anousu AND c229_fonte = o70_codrec AND c229_convenio = c206_sequencial
                                WHERE o70_codigo IN ('122','123','124','142')
                                    AND o70_anousu = {$iAnoUsu}
                                    AND o70_instit = {$iInstit}
                                    AND o70_valor > 0
                                    AND o70_codrec = {$oParam->iCodRec}
                                    AND c206_sequencial IS NOT NULL
                                GROUP BY 1,2,3,4,5,6) AS x
                            WHERE valor_arrecadado > 0) AS xx GROUP BY 1,2,3,4,5,6 ";
            
            $result = db_query($sSql);            
            
            $oRetorno->vlPrevistoTotal = 0;

            if(pg_num_rows($result) > 0) {
                
                for ($i = 0; $i < pg_num_rows($result); $i++) {

                    $oConvenio = db_utils::fieldsMemory($result, $i);

                    $oConv = new stdClass();
                    $oConv->o70_codrec          = $oConvenio->o70_codrec;
                    $oConv->c206_sequencial     = $oConvenio->c206_sequencial;
                    $oConv->c206_nroconvenio    = $oConvenio->c206_nroconvenio;
                    $oConv->c206_objetoconvenio = urlencode($oConvenio->c206_objetoconvenio);
                    $oConv->c206_dataassinatura = $oConvenio->c206_dataassinatura;
                    $oConv->c229_vlprevisto     = $oConvenio->c229_vlprevisto;
                    $oConv->valor_arrecadado    = $oConvenio->valor_arrecadado;

                    $oRetorno->aItens[] = $oConv;

                    $oRetorno->vlPrevistoTotal += $oConvenio->c229_vlprevisto;

                }
            }

        break;

        case "salvaNovo":

            db_inicio_transacao();

            $clprevconvenioreceita = new cl_prevconvenioreceita;
            $sWhere         = "c229_fonte = {$oParam->iFonte} and c229_convenio = {$oParam->iConvenio} and c229_anousu = {$iAnoUsu}";
            $sSqlVerifica   = $clprevconvenioreceita->sql_query_file("", "", "*", null, $sWhere);
            $rsVerifica     = db_query($sSqlVerifica); 
            
            if (pg_num_rows($rsVerifica) > 0) {
                throw new Exception("Convênio já associado a esta receita!");
            }

            $clprevconvenioreceita = new cl_prevconvenioreceita;
            $clprevconvenioreceita->c229_fonte      = $oParam->iFonte;
            $clprevconvenioreceita->c229_convenio   = $oParam->iConvenio;
            $clprevconvenioreceita->c229_anousu     = $iAnoUsu;
            $clprevconvenioreceita->c229_vlprevisto = '0';
                
            $clprevconvenioreceita->incluir();

            if ($clprevconvenioreceita->erro_status == 0) {
                throw new Exception("Erro ao criar associação de convênio à previsão de receita . ".$clprevconvenioreceita->erro_sql, null);
            }
            
            $sCamposBusca = " c206_sequencial, c206_nroconvenio, c206_objetoconvenio, c206_dataassinatura ";
            $sSqlBuscaConv  = $clprevconvenioreceita->sql_query(null, null, $sCamposBusca, null, $sWhere);
            $rsBuscaConv    = db_query($sSqlBuscaConv);
            
            $oConv = db_utils::fieldsMemory($rsBuscaConv, 0);
            
            $oRetorno->o70_codrec          = $oParam->iFonte;
            $oRetorno->c206_sequencial     = $oConv->c206_sequencial;
            $oRetorno->c206_nroconvenio    = $oConv->c206_nroconvenio;
            $oRetorno->c206_objetoconvenio = urlencode($oConv->c206_objetoconvenio);
            $oRetorno->c206_dataassinatura = $oConv->c206_dataassinatura;
            $oRetorno->c229_vlprevisto     = 0;
            $oRetorno->valor_arrecadado    = 0;

        break;

        case "salvaGeral":

            db_inicio_transacao();

            $fValorPrevTotal = 0;

            foreach ($oParam->aItens as $aItem) {
                
                //Verifica se os valores previstos ultrapassam o valor previsto
                $fValorPrevTotal += $aItem->c229_vlprevisto;

                if ($fValorPrevTotal > $oParam->fValorPrevAno) {
                    throw new Exception("Valor previsto para os convênios superior ao valor previsto no ano", null);
                }

                $clprevconvenioreceita = new cl_prevconvenioreceita;
                $sWhere       = "c229_fonte = {$aItem->c229_fonte} and c229_convenio = {$aItem->c229_convenio} and c229_anousu = {$iAnoUsu}";
                $sSqlVerifica = $clprevconvenioreceita->sql_query_file(null, null, "*", null, $sWhere);
                $rsVerifica   = db_query($sSqlVerifica);

                if (pg_num_rows($rsVerifica) > 0) {
                    
                    $clprevconvenioreceita->c229_vlprevisto = $aItem->c229_vlprevisto;
                    $clprevconvenioreceita->alterar($aItem->c229_fonte, $aItem->c229_convenio, $iAnoUsu);

                    if ($clprevconvenioreceita->erro_status == 0) {
                        throw new Exception("[1] Erro ao criar associação de convênio à previsão de receita . ".$clprevconvenioreceita->erro_sql, null);
                    }


                } else {
                    
                    $clprevconvenioreceita = new cl_prevconvenioreceita;
                    $clprevconvenioreceita->c229_fonte      = $aItem->c229_fonte;
                    $clprevconvenioreceita->c229_convenio   = $aItem->c229_convenio;
                    $clprevconvenioreceita->c229_anousu     = $iAnoUsu;
                    $clprevconvenioreceita->c229_vlprevisto = $aItem->c229_vlprevisto;
                        
                    $clprevconvenioreceita->incluir();

                    if ($clprevconvenioreceita->erro_status == 0) {
                        throw new Exception("[2] Erro ao criar associação de convênio à previsão de receita . ".$clprevconvenioreceita->erro_sql, null);
                    }

                }
                
            }
            
            $oRetorno->fValorPrevTotal = $fValorPrevTotal;
            $oRetorno->sMensagem = "Registros criados com sucesso.";
            
        break;

        case "exclui": 

            db_inicio_transacao();

            foreach ($oParam->aItens as $oItem) {

                $clprevconvenioreceita = new cl_prevconvenioreceita;
                $clprevconvenioreceita->excluir($oItem->c229_convenio, $oItem->c229_fonte, $iAnoUsu);

                if ($clprevconvenioreceita->erro_status == 0) {
                    throw new Exception("Erro ao excluir associação de convênio à previsão de receita . ".$clprevconvenioreceita->erro_sql, null);
                }
            
            }

            $oRetorno->sMensagem = "Registros excluídos com sucesso.";            

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