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
require_once("classes/db_lancamverifaudit_classe.php");

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

        case "buscaQuestoes":

            db_inicio_transacao();

            if ($oParam->iOpcao == 1) {
                $sWhere = "ci03_codproc = {$oParam->iCodProc} AND ci02_instit = {$iInstit} AND ci05_codlan IS NULL";
            } elseif ($oParam->iOpcao == 2) {
                $sWhere = "ci03_codproc = {$oParam->iCodProc} AND ci02_instit = {$iInstit} AND ci05_codlan IS NOT NULL";
            } elseif ($oParam->iOpcao == 3) {
                $sWhere = "ci03_codproc = {$oParam->iCodProc} AND ci02_instit = {$iInstit}";
            }

            $sSqlQuestoes = $clquestaoaudit->sql_questao_processo(null, "*", "ci02_numquestao", $sWhere);
            $rsQuestoes = db_query($sSqlQuestoes);
            
            if(pg_num_rows($rsQuestoes) > 0) {

                for ($iCont = 0; $iCont < pg_num_rows($rsQuestoes); $iCont++ ){

                    $oQuestaoBusca = db_utils::fieldsMemory($rsQuestoes, $iCont);
                    
                    $oQuestao = new stdClass();
                    $oQuestao->ci05_codlan            = $oQuestaoBusca->ci05_codlan;
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

        case "salvaLancamento":

            db_inicio_transacao();

            $cllancamverifaudit = new cl_lancamverifaudit;
            $cllancamverifaudit->ci05_codproc           = $oParam->iCodProc;
            $cllancamverifaudit->ci05_codquestao        = $oParam->iCodQuestao;
            $cllancamverifaudit->ci05_inianalise_dia    = $oParam->dtDataIniDia;
            $cllancamverifaudit->ci05_inianalise_mes    = $oParam->dtDataIniMes;
            $cllancamverifaudit->ci05_inianalise_ano    = $oParam->dtDataIniAno;
            $cllancamverifaudit->ci05_atendquestaudit   = $oParam->bAtendeQuest;
            $cllancamverifaudit->ci05_achados           = $oParam->sAchado;
            $cllancamverifaudit->ci05_instit            = $iInstit;

            $cllancamverifaudit->incluir();

            if ($cllancamverifaudit->erro_status == "0") {
                throw new Exception("Erro ao criar lançamento. \n".$cllancamverifaudit->erro_sql, null);
            }

            $oRetorno->iLinha       = $oParam->iLinha;
            $oRetorno->iCodLan      = $cllancamverifaudit->ci05_codlan;
            $oRetorno->sMensagem    = "Lançamento criado com sucesso!";            

        break;

        case "atualizaLancamento":
            
            db_inicio_transacao();

            $cllancamverifaudit = new cl_lancamverifaudit;
            $sSql = $cllancamverifaudit->sql_query(null, "*", null, "ci05_codproc = {$oParam->iCodLan}");
            $cllancamverifaudit->sql_record($sSql);

            $cllancamverifaudit->ci05_codproc           = $oParam->iCodProc;
            $cllancamverifaudit->ci05_codquestao        = $oParam->iCodQuestao;
            $cllancamverifaudit->ci05_inianalise_dia    = $oParam->dtDataIniDia;
            $cllancamverifaudit->ci05_inianalise_mes    = $oParam->dtDataIniMes;
            $cllancamverifaudit->ci05_inianalise_ano    = $oParam->dtDataIniAno;
            $cllancamverifaudit->ci05_atendquestaudit   = $oParam->bAtendeQuest;
            $cllancamverifaudit->ci05_achados           = $oParam->sAchado;

            $cllancamverifaudit->alterar($oParam->iCodLan);

            if ($cllancamverifaudit->erro_status == "0") {
                throw new Exception("Erro ao alterar o lançamento. \n".$cllancamverifaudit->erro_sql, null);
            }

            $oRetorno->iLinha       = $oParam->iLinha;
            $oRetorno->iCodLan      = $cllancamverifaudit->ci05_codlan;
            $oRetorno->sMensagem    = "Lançamento alterado com sucesso!"; 

        break;

        case "salvaGeral":
            
            db_inicio_transacao();

            foreach ($oParam->questoesEnviar as $oQuestao) {

                $cllancamverifaudit = new cl_lancamverifaudit;

                $iNumLancamentos = 0;

                if (isset($oQuestao->iCodLan) && $oQuestao->iCodLan != "") {
                    
                    $sSql = $cllancamverifaudit->sql_query(null, "*", null, "ci05_codlan = {$oQuestao->iCodLan}");
                    $rsLancam = $cllancamverifaudit->sql_record($sSql);
                    $iNumLancamentos = $cllancamverifaudit->numrows;

                }

                if ($iNumLancamentos > 0) {

                    $cllancamverifaudit->ci05_inianalise_dia    = $oQuestao->dtDataIniDia;
                    $cllancamverifaudit->ci05_inianalise_mes    = $oQuestao->dtDataIniMes;
                    $cllancamverifaudit->ci05_inianalise_ano    = $oQuestao->dtDataIniAno;
                    $cllancamverifaudit->ci05_atendquestaudit   = $oQuestao->bAtendeQuest;
                    $cllancamverifaudit->ci05_achados           = $oQuestao->sAchado;

                    $cllancamverifaudit->alterar($oQuestao->iCodLan);

                    if ($cllancamverifaudit->erro_status == "0") {
                        throw new Exception("Erro ao alterar o lançamento. \n".$cllancamverifaudit->erro_sql, null);
                    }

                } else {

                    $cllancamverifaudit = new cl_lancamverifaudit;
                    $cllancamverifaudit->ci05_codproc           = $oQuestao->iCodProc;
                    $cllancamverifaudit->ci05_codquestao        = $oQuestao->iCodQuestao;
                    $cllancamverifaudit->ci05_inianalise_dia    = $oQuestao->dtDataIniDia;
                    $cllancamverifaudit->ci05_inianalise_mes    = $oQuestao->dtDataIniMes;
                    $cllancamverifaudit->ci05_inianalise_ano    = $oQuestao->dtDataIniAno;
                    $cllancamverifaudit->ci05_atendquestaudit   = $oQuestao->bAtendeQuest;
                    $cllancamverifaudit->ci05_achados           = $oQuestao->sAchado;
                    $cllancamverifaudit->ci05_instit            = $iInstit;

                    $cllancamverifaudit->incluir();

                    if ($cllancamverifaudit->erro_status == "0") {
                        throw new Exception("Erro ao criar lançamento. \n".$cllancamverifaudit->erro_sql, null);
                    }

                }

            }
            
            $oRetorno->sMensagem    = "Lançamentos criados com sucesso!"; 

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
    