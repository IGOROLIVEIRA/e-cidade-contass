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

require("libs/db_stdlib.php");
require("libs/db_utils.php");
require("std/db_stdClass.php");
require("libs/db_conecta.php");
require("libs/db_sessoes.php");
require ("libs/JSON.php");
require_once("model/pessoal/VerificacaoFolha.model.php");

$oJson             = new services_json();
$oParam            = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\","",$_POST["json"])));
$oRetorno          = new stdClass;
$oRetorno->status  = 1;
$oRetorno->message = "";

switch($oParam->exec) {
  case "verificaFolha":
      $aTipoFolha = array(1,4,5,8);
      $aMatriculasValorNegativo = array();
      $aMatriculasRubrica = array();
      $oVerificacaoFolha = new VerificacaoFolha();
      foreach ($aTipoFolha as $iTipoFolha) {
          $aMatriculasValorNegativo = array_merge($aMatriculasValorNegativo, $oVerificacaoFolha->verificaValorNegativo(null, $iTipoFolha));
          $aMatriculasRubrica = array_merge($aMatriculasRubrica, $oVerificacaoFolha->verificaServidoresRubricaR928(null, $iTipoFolha));
      }
      if (count($aMatriculasValorNegativo) > 0) {
          $oRetorno->status  = 2;
          $oRetorno->aMatriculasValorNegativo = array_unique($aMatriculasValorNegativo);
      }
      if (count($aMatriculasRubrica) > 0) {
          $oRetorno->status  = 2;
          $oRetorno->aMatriculasRubrica = array_unique($aMatriculasRubrica);
      }
  break;
  default:
  break;
}

echo $oJson->encode($oRetorno);
?>