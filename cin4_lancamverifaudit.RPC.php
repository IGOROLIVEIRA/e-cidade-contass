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


// require_once("std/db_stdClass.php");
// require_once("libs/db_stdlib.php");
// require_once("libs/db_conecta.php");
// require_once("libs/db_sessoes.php");
// require_once("libs/db_utils.php");
// require_once("libs/db_usuariosonline.php");
// require_once("dbforms/db_funcoes.php");
// require_once("libs/JSON.php");
// require_once("libs/db_app.utils.php");


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
$oRetorno->aQuestoes = array();

$iInstit = db_getsession('DB_instit');

try {

    switch ($oParam->exec) {

        case "getQuestoes":

            db_inicio_transacao();

            if ($oParam->iOpcao == 1) {
                $sWhere = "ci03_codproc = {$oParam->iCodProc} AND ci02_instit = {$iInstit} AND ci05_codlan IS NULL";
            } elseif ($oParam->iOpcao == 2) {
                $sWhere = "ci03_codproc = {$oParam->iCodProc} AND ci02_instit = {$iInstit} AND ci05_codlan IS NOT NULL";
            } elseif ($oParam->iOpcao == 3) {
                $sWhere = "ci03_codproc = {$oParam->iCodProc} AND ci02_instit = {$iInstit}";
            }

            $sSqlQuestoes = $clquestaoaudit->sql_questao_processo(null, "*", "ci02_codquestao", $sWhere);
            $rsQuestoes = db_query($sSqlQuestoes);
            
            if(pg_num_rows($rsQuestoes) > 0) {

                for ($iCont = 0; $iCont < pg_num_rows($rsQuestoes); $iCont++ ){

                    $oQuestaoBusca = db_utils::fieldsMemory($rsQuestoes, $iCont);
                    
                    $oQuestao = new stdClass();
                    $oQuestao->ci02_codquestao        = $oQuestaoBusca->ci02_codquestao;
                    $oQuestao->ci02_numquestao        = $oQuestaoBusca->ci02_numquestao;
                    $oQuestao->ci03_codproc           = $oQuestaoBusca->ci03_codproc;
                    $oQuestao->ci02_questao           = urlencode($oQuestaoBusca->ci02_questao);
                    $oQuestao->ci02_inforeq           = urlencode($oQuestaoBusca->ci02_inforeq);
                    $oQuestao->ci02_fonteinfo         = urlencode($oQuestaoBusca->ci02_fonteinfo);
                    $oQuestao->ci02_procdetal         = urlencode($oQuestaoBusca->ci02_procdetal);
                    $oQuestao->ci02_objeto            = urlencode($oQuestaoBusca->ci02_objeto);
                    $oQuestao->ci02_possivachadneg    = urlencode($oQuestaoBusca->ci02_possivachadneg);
                    $oQuestao->ci05_inianalise        = $oQuestaoBusca->ci05_inianalise;
                    $oQuestao->ci05_atendquestaudit   = $oQuestaoBusca->ci05_atendquestaudit;
                    $oQuestao->ci05_achados           = urlencode($oQuestaoBusca->ci05_achados);

                    $oRetorno->aQuestoes[] = $oQuestao;

                }
                
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
    