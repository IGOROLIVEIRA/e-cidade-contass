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
require_once("classes/db_tipoquestaoaudit_classe.php");
require_once("classes/db_questaoaudit_classe.php");

$cltipoquestaoaudit = new cl_tipoquestaoaudit;
$clquestaoaudit     = new cl_questaoaudit;

include("libs/JSON.php");

$oJson    = new services_json();
$oParam   = $oJson->decode(str_replace("\\","",$_POST["json"]));

$oRetorno = new stdClass();
$oRetorno->status  = 1;
$sqlerro           = false;
$oRetorno->aItens  = array();

$iInstit = db_getsession('DB_instit');

try {

    switch ($oParam->exec) {

        case "importarQuestao":

            db_inicio_transacao();

            $sSqlQuestoes = $clquestaoaudit->sql_query_file(null, "*", "ci02_codquestao", "ci02_codtipo = {$oParam->iCodTipoOrigem} AND ci02_instit = {$iInstit}");
            $rsQuestoes = db_query($sSqlQuestoes);
            
            if(pg_num_rows($rsQuestoes) > 0) {
            
                for ($iCont = 0; $iCont < pg_num_rows($rsQuestoes); $iCont++) {

                    $oQuestao = db_utils::fieldsMemory($rsQuestoes, $iCont);

                    $clNovaQuestao = new cl_questaoaudit;

                    $clNovaQuestao->ci02_codtipo        = $oParam->iCodTipoDestino;
                    $clNovaQuestao->ci02_numquestao     = $oQuestao->ci02_numquestao;
                    $clNovaQuestao->ci02_questao        = $oQuestao->ci02_questao;
                    $clNovaQuestao->ci02_inforeq        = $oQuestao->ci02_inforeq;
                    $clNovaQuestao->ci02_fonteinfo      = $oQuestao->ci02_fonteinfo;
                    $clNovaQuestao->ci02_procdetal      = $oQuestao->ci02_procdetal;
                    $clNovaQuestao->ci02_objeto         = $oQuestao->ci02_objeto;
                    $clNovaQuestao->ci02_possivachadneg = $oQuestao->ci02_possivachadneg;
                    $clNovaQuestao->ci02_instit         = $oQuestao->ci02_instit;

                    $clNovaQuestao->incluir();

                    if($clNovaQuestao->erro_status == "0") {
                        throw new Exception("Erro ao criar nova questão ".$clNovaQuestao->erro_sql, null);
                    }

                } 
                
            } else {

                throw new Exception("Não há questões cadastradas para o Tipo da Auditoria {$oParam->iCodTipoOrigem}", null);

            }

            $oRetorno->sMensagem = "Questões importadas com sucesso.";
            $oRetorno->iCodTipo = $oParam->iCodTipoDestino;

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
    