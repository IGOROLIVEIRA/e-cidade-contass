<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_empautoriza_classe.php");
require_once("classes/db_pcproc_classe.php");
require_once("classes/db_pcprocliberado_classe.php");

include("libs/JSON.php");

$oJson    = new services_json();
$oParam   = $oJson->decode(str_replace("\\","",$_POST["json"]));

$oRetorno = new stdClass();
$oRetorno->status  = 1;
$oRetorno->aItens  = array();

switch ($oParam->exec) {

    /*
     * Pesquisa Autorizaчуo de Empenho para a liberacao
     */

    case "pesquisaAutorizacao":

        $oAutorizacao   = new cl_empautoriza();
        $sWhere         = " e54_anousu = ".db_getsession("DB_anousu");
        $sWhere         .= " AND e54_instit = ".db_getsession("DB_instit");
        $sWhere         .= " AND e61_numemp IS NULL";
        $sWhere         .= " AND e94_numemp IS NULL";
        $sCampos        = "e54_autori, e54_emiss, z01_nome, e54_valor, e54_resumo, e232_sequencial";
        $sOrdem         = " e54_emiss DESC ";

        if (isset($oParam->codautini) && $oParam->codautini != null) {

            if (isset($oParam->codautfim) && $oParam->codautfim != null) {
                $sStr = " AND e54_autori BETWEEN $oParam->codautini AND $oParam->codautfim ";
            } else {
                $sStr = " AND e54_autori = $oParam->codautini ";
            }
            $sWhere .= "$sStr";

        }

        if (isset($oParam->numcgm) && $oParam->numcgm != null) {
            $sWhere .= " AND e54_numcgm = $oParam->numcgm";
        }

        if (isset($oParam->dtemissini) && $oParam->dtemissini != null) {

            if (!empty($oParam->dtemissini)) {
                $dtDataIni = explode("/", $oParam->dtemissini);
                $dtDataIni = $dtDataIni[2]."-".$dtDataIni[1]."-".$dtDataIni[0];
            }

            if (!empty($oParam->dtemissfim)) {
                $dtDataFim = explode("/", $oParam->dtemissfim);
                $dtDataFim = $dtDataFim[2]."-".$dtDataFim[1]."-".$dtDataFim[0];
            }

            if (isset($oParam->dtemissfim) && $oParam->dtemissfim != null) {
                $sWhere .= " AND e54_emiss BETWEEN '$dtDataIni' AND '$dtDataFim'";
            } else {
                $sWhere .= " AND e54_emiss = '$dtDataIni'";
            }

        }

        $sSqlAutorizacao  = $oAutorizacao->sql_query_autorizacao_liberada(null, $sCampos, $sOrdem, $sWhere);
        $rsSqlAutorizacao = $oAutorizacao->sql_record($sSqlAutorizacao);
        $oRetorno->aItens = db_utils::getCollectionByRecord($rsSqlAutorizacao, true, false, true);

        break;

    /*
     * Processa Autorizaчуo de Empenhos selecionados para a liberaчуo
     */

    case "processaAutorizacaoLiberadas":

        $oEmpAutorizLiberado = new cl_empautorizliberado();
        try {

            db_inicio_transacao();
            $oEmpAutorizLiberado->liberarAutorizacao($oParam->aAutorizacoes);
            db_fim_transacao(false);
        } catch (Exception $eErro) {

            db_fim_transacao(true);
            $oRetorno->status = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }

        break;

    /*
     * Pesquisa processo de compra para a liberaчуo
     */

    case "pesquisaProcessoCompra":

        $oProcComp = new cl_pcproc();

        $sCampos = "DISTINCT pc80_codproc, pc80_data, descrdepto, si01_datacotacao, pc80_resumo, e233_sequencial";
        $sWhere = "(e55_sequen IS NULL OR (e55_sequen IS NOT NULL AND e54_anulad IS NOT NULL))";
        $sWhere .= "AND pc10_instit = ".db_getsession("DB_instit");
        $sWhere .= "AND pc10_solicitacaotipo IN(1, 2)";
        $sWhere .= "AND pc80_situacao = 2";
        $sWhere .= "AND NOT EXISTS (SELECT 1
                                        FROM acordopcprocitem
                                        INNER JOIN acordoitem ON ac23_acordoitem = ac20_sequencial
                                        INNER JOIN acordoposicao ON ac20_acordoposicao = ac26_sequencial
                                        INNER JOIN acordo ON ac26_acordo = ac16_sequencial
                                    WHERE ac23_pcprocitem = pc81_codprocitem AND (ac16_acordosituacao NOT IN (2, 3)))";
        $sWhere .= "AND NOT EXISTS (SELECT 1
                                                FROM liclicitem
                                                INNER JOIN pcprocitem ON pc81_codprocitem = l21_codpcprocitem
                                                WHERE pc81_codproc = pc80_codproc)";
        $sWhere .= "AND empautoriza.e54_autori IS NULL ";
        $sWhere .= "AND pc80_codproc IN (SELECT si01_processocompra FROM precoreferencia)";
        $sWhere .= "AND date_part('YEAR', pc80_data) = ".db_getsession("DB_anousu");
        $sOrdem = "pc80_data DESC";

        if (isset($oParam->codprocini) && $oParam->codprocini != null) {

            if (isset($oParam->codprocfim) && $oParam->codprocfim != null) {
                $sStr = " AND pc80_codproc BETWEEN $oParam->codprocini AND $oParam->codprocfim ";
            } else {
                $sStr = " AND pc80_codproc = $oParam->codprocini ";
            }
            $sWhere .= "$sStr";

        }

        if (isset($oParam->dtemissini) && $oParam->dtemissini != null) {

            if (!empty($oParam->dtemissini)) {
                $dtDataIni = explode("/", $oParam->dtemissini);
                $dtDataIni = $dtDataIni[2]."-".$dtDataIni[1]."-".$dtDataIni[0];
            }

            if (!empty($oParam->dtemissfim)) {
                $dtDataFim = explode("/", $oParam->dtemissfim);
                $dtDataFim = $dtDataFim[2]."-".$dtDataFim[1]."-".$dtDataFim[0];
            }

            if (isset($oParam->dtemissfim) && $oParam->dtemissfim != null) {
                $sWhere .= " AND pc80_data BETWEEN '$dtDataIni' AND '$dtDataFim'";
            } else {
                $sWhere .= " AND pc80_data = '$dtDataIni'";
            }

        }

        $sSubSqlProcCompra  = $oProcComp->sql_query_aut(null, "*", $sOrdem, $sWhere);
        $sSqlProcCompra     = "SELECT $sCampos
                                    FROM ($sSubSqlProcCompra) as x 
                                        LEFT JOIN precoreferencia ON precoreferencia.si01_processocompra = pc80_codproc
                                        LEFT JOIN pcprocliberado ON pc80_codproc = pcprocliberado.e233_codproc 
                                        LEFT JOIN empautitempcprocitem ON e73_pcprocitem = pc81_codprocitem 
                                    WHERE e73_autori IS NULL";
        $rsProcCompra = $oProcComp->sql_record($sSqlProcCompra);
        $oRetorno->aItens = db_utils::getCollectionByRecord($rsProcCompra, true, false, true);

        break;

    case "processaProcessoCompraLiberados":

        $oProcCompLiberado = new cl_pcprocliberado();
        try {

            db_inicio_transacao();
            $oProcCompLiberado->liberarProcessoCompra($oParam->aProcCompras);
            db_fim_transacao(false);
        } catch (Exception $eErro) {

            db_fim_transacao(true);
            $oRetorno->status = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }

        break;
}
echo $oJson->encode($oRetorno);
?>