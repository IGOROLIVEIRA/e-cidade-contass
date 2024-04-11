<?
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
require("libs/JSON.php");
require("libs/db_utils.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

$oJson   = new services_JSON();
$oParam  = $oJson->decode(str_replace("\\", "", $_POST["sJson"]));
$sMensagem = "";

if ($oParam->exec == 'getSaltesConvenio') {

   $oDaoSaltes = db_utils::getDao("saltes");

   $sqlSaltesConvenio = $oDaoSaltes->sql_query_convenio_conta(null, "c206_sequencial, c206_objetoconvenio", "", "$where k13_conta={$oParam->iCodigoSaltes} and c61_instit = " . db_getsession("DB_instit"));

   $rsSaltes = $oDaoSaltes->sql_record($sqlSaltesConvenio);

   if ($oDaoSaltes->numrows > 0) {

      $oSaltesConv = db_utils::fieldsMemory($rsSaltes, 0);
      $aSaltesConv      = array("c206_sequencial" => $oSaltesConv->c206_sequencial, "c206_objetoconvenio" => utf8_encode($oSaltesConv->c206_objetoconvenio), "lValidacao" => true, "sMensagem" => $sMensagem);
   } else {

      $sMensagem = "Usuário: para realizar a arrecadação da receita, vincule o convênio a respectiva conta bancária.";
      $aSaltesConv = array("c206_sequencial" => "", "c206_objetoconvenio" => "", "lValidacao" => false, "sMensagem" => $sMensagem); //Garantimos que ira ter uma string valida para retorno

   }
   echo $oJson->encode($aSaltesConv);
}

//operao de credito

if ($oParam->exec == 'getSaltesOP') {
   $oDaoSaltes = db_utils::getDao("db_operacaodecredito");
   $sqlSaltesOP = $oDaoSaltes->sql_query(null, "op01_sequencial, op01_numerocontratoopc, op01_dataassinaturacop", "", "$where op01_sequencial={$oParam->idb83_codigoopcredito}");
   $rsSaltes = $oDaoSaltes->sql_record($sqlSaltesOP);

   if ($oDaoSaltes->numrows > 0) {

      $oSaltesOP = db_utils::fieldsMemory($rsSaltes, 0);

      $aSaltesOP     = array("op01_sequencial" => $oSaltesOP->op01_sequencial, "op01_numerocontratoopc" => $oSaltesOP->op01_numerocontratoopc, "op01_dataassinaturacop" => $oSaltesOP->op01_dataassinaturacop, "lValidacao" => true, "sMensagem" => $sMensagem);
   } else {

      $sMensagem = "";
      $aSaltesOP = array("op01_sequencial" => "", "op01_numerocontratoopc" => "", "op01_dataassinaturacop" => "", "lValidacao" => false, "sMensagem" => $sMensagem); //Garantimos que ira ter uma string valida para retorno

   }

   echo $oJson->encode($aSaltesOP);
}
