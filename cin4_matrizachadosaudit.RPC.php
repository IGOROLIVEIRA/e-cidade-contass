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
require_once("classes/db_questaoaudit_classe.php");

$clquestaoaudit     = new cl_questaoaudit;

include("libs/JSON.php");

$oJson    = new services_json();
$oParam   = $oJson->decode(str_replace("\\","",$_POST["json"]));

$oRetorno = new stdClass();
$oRetorno->status  = 1;
$sqlerro           = false;

$iInstit = db_getsession('DB_instit');

try {

    switch ($oParam->exec) {

        case "buscaQuestoes":

            db_inicio_transacao();

            $sWhere     = " ci02_numquestao = {$oParam->iNumQuest} AND ci03_codproc = {$oParam->iCodProc} AND ci03_instit = {$iInstit}";
            $sCampos    = " ci05_codlan, ci02_numquestao, ci02_questao, ci03_codproc, ci05_achados, matrizachadosaudit.*";
            $sSql       = $clquestaoaudit->sql_questao_matriz(null, $sCampos, null, $sWhere);
            $rsResult = $clquestaoaudit->sql_record($sSql);

            if (pg_num_rows($rsResult) > 0) {

                $oQuestMat = db_utils::fieldsMemory($rsResult, 0);

                $oQuestaoMatriz = new stdClass();

                $oQuestaoMatriz->ci06_seq           = $oQuestMat->ci06_seq;
                $oQuestaoMatriz->ci05_codlan        = $oQuestMat->ci05_codlan;
                $oQuestaoMatriz->ci02_numquestao    = $oQuestMat->ci02_numquestao;
                $oQuestaoMatriz->ci02_questao       = urlencode($oQuestMat->ci02_questao);
                $oQuestaoMatriz->ci05_achados       = urlencode($oQuestMat->ci05_achados);
                $oQuestaoMatriz->ci06_situencont    = urlencode($oQuestMat->ci06_situencont);
                $oQuestaoMatriz->ci06_objetos       = urlencode($oQuestMat->ci06_objetos);
                $oQuestaoMatriz->ci06_criterio      = urlencode($oQuestMat->ci06_criterio);
                $oQuestaoMatriz->ci06_evidencia     = urlencode($oQuestMat->ci06_evidencia);
                $oQuestaoMatriz->ci06_causa         = urlencode($oQuestMat->ci06_causa);
                $oQuestaoMatriz->ci06_efeito        = urlencode($oQuestMat->ci06_efeito);
                $oQuestaoMatriz->ci06_recomendacoes = urlencode($oQuestMat->ci06_recomendacoes);

                $oRetorno->questaoMatriz = $oQuestaoMatriz;

            }

        break;

    }

    db_fim_transacao($sqlerro);
    $oRetorno->sMensagem = urlencode($oRetorno->sMensagem);
    echo $oJson->encode($oRetorno);


} catch (Exception $e) {

    db_fim_transacao($sqlerro);
    $oRetorno->sMensagem    = urlencode($e->getMessage());
    $oRetorno->status       = 2;
    echo $oJson->encode($oRetorno);

}
    