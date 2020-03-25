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
require_once("classes/db_empautorizliberado_classe.php");

include("libs/JSON.php");

$oJson    = new services_json();
$oParam   = $oJson->decode(str_replace("\\","",$_POST["json"]));

$oRetorno = new stdClass();
$oRetorno->status  = 1;
$oRetorno->aItens  = array();

switch ($oParam->exec) {

    /*
     * Pesquisa empenhos para a liberacao
     */

    case "pesquisaAutorizacao":

        $oAutorizacao   = new cl_empautoriza();
        $sWhere         = " e54_anousu = ".db_getsession("DB_anousu");
        $sWhere         .= " AND e54_instit = ".db_getsession("DB_instit");
        $sWhere         .= " AND e61_numemp IS NULL";
        $sWhere         .= " AND e94_numemp IS NULL";
        $sCampos        = "e54_autori, e54_emiss, z01_nome, e54_valor, e54_resumo, e232_sequencial, 'f' AS temordemdecompra";
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
     * Processa empenhos selecionados para a liberaчуo
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
}
echo $oJson->encode($oRetorno);
?>