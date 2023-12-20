<?php
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2014  DBSeller Servicos de Informatica             
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
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("classes/db_empdiaria_classe.php");

$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = "";
$clempdiaria       = new cl_empdiaria;

switch ($oParam->exec) {

  case "incluiDiaria":
    $e140_dtautorizacao = App\Support\String\DateFormatter::convertDateFormatBRToISO($oParam->e140_dtautorizacao);
    $e140_dtinicial = App\Support\String\DateFormatter::convertDateFormatBRToISO($oParam->e140_dtinicial);
    $e140_dtfinal = App\Support\String\DateFormatter::convertDateFormatBRToISO($oParam->e140_dtfinal);
  
    $clempdiaria->e140_codord                = $oParam->e140_codord;
    $clempdiaria->e140_dtautorizacao         = $e140_dtautorizacao;
    $clempdiaria->e140_matricula             = $oParam->e140_matricula;
    $clempdiaria->e140_cargo                 = $oParam->e140_cargo;
    $clempdiaria->e140_dtinicial             = $e140_dtinicial;
    $clempdiaria->e140_dtfinal               = $e140_dtfinal;
    $clempdiaria->e140_horainicial           = $oParam->e140_horainicial;
    $clempdiaria->e140_horafinal             = $oParam->e140_horafinal;
    $clempdiaria->e140_origem                = $oParam->e140_origem;
    $clempdiaria->e140_destino               = $oParam->e140_destino;
    $clempdiaria->e140_qtddiarias            = $oParam->e140_qtddiarias;
    $clempdiaria->e140_vrldiariauni          = $oParam->e140_vrldiariauni;
    $clempdiaria->e140_qtddiariaspernoite    = $oParam->e140_qtddiariaspernoite;
    $clempdiaria->e140_vrldiariaspernoiteuni = $oParam->e140_vrldiariaspernoiteuni;
    $clempdiaria->e140_qtdhospedagens        = $oParam->e140_qtdhospedagens;
    $clempdiaria->e140_vrlhospedagemuni      = $oParam->e140_vrlhospedagemuni;
    $clempdiaria->e140_transporte            = $oParam->e140_transporte;
    $clempdiaria->e140_vlrtransport          = $oParam->e140_vlrtransport;
    $clempdiaria->e140_objetivo              = $oParam->e140_objetivo;
    $clempdiaria->incluir();
    if ($clempdiaria->erro_status == 1) {
      $oRetorno->status      = 2;
      $oRetorno->message = "Incluido com sucesso!";
    } else {
      $oRetorno->message = $clempdiaria->erro_msg;
    }
    break;

  case 'pesquisaDiaria':
    $rsDiaria = $clempdiaria->sql_record($clempdiaria->sql_query(null,'empdiaria.*, z01_nome',null,'e140_codord = '.$oParam->iCodord));

    $oDaoEmpenho = db_utils::getDao('empempenho');
    $rsEmpempenho = $oDaoEmpenho->sql_record($oDaoEmpenho->sql_query($oParam->iNumemp,'e60_numcgm'));
    $oRetorno->e60_numcgm = db_utils::fieldsMemory($rsEmpempenho, 0)->e60_numcgm;

    $oDaoElementos   = db_utils::getDao('orcelemento');
    $sWhereEmpenho   = " e60_numemp =  {$oParam->iNumemp}";
    $rsDesdobramento = $oDaoElementos->sql_record($oDaoElementos->sql_query_estrut_empenho(null, "substr(o56_elemento,1,9) AS o56_elemento", null, $sWhereEmpenho));
    $oRetorno->sDesdobramento = db_utils::fieldsMemory($rsDesdobramento, 0)->o56_elemento;

    if (pg_num_rows($rsDiaria) > 0) {
      $oRetorno->oDiaria = pg_fetch_object($rsDiaria);
    } else {
      $oRetorno->oDiaria = null;
      $oRetorno->message = 'OP não possui Diária.';
    }
    break;

  default:
    break;
}

echo $oJson->encode($oRetorno);
