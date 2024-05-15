<?php
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2014  DBselller Servicos de Informatica             
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

require_once ("std/db_stdClass.php");
require_once ("libs/db_stdlib.php");
require_once ("libs/db_conecta.php");
require_once ("libs/db_sessoes.php");
require_once ("libs/db_utils.php");
require_once ("libs/db_app.utils.php");
require_once ("libs/db_usuariosonline.php");
require_once ("libs/JSON.php");
require_once ("dbforms/db_funcoes.php");

db_postmemory($_POST);

$oJson              = new services_json();
$oParam             = $oJson->decode(str_replace("\\","",$_POST["json"]));

$oRetorno           = new stdClass();
$oRetorno->dados    = new stdClass();
$oRetorno->status   = 1;

try {
  switch ($oParam->exec) {

    case "buscaProcessosApensado":

      /**
       * Efetua a busca dos processos apensados ao processo principal
       */
      $mProcessos = buscaProcessosApensados($oParam->processo);

      $oRetorno->status = 2;
      if ($mProcessos) {

        $oRetorno->dados = $mProcessos;
        $oRetorno->status = 1;
      }
      break;
    case "apensandoProcessos":

      /**
       * Verifica se o processo a apensar está arquivado. Um processo arquivado não pode ser apensado.
       */
      $sCampos = "p58_codproc";
      $sOrdem  = "p58_codproc";
      $sWhere  = "p68_codproc is not null and (p58_codproc = $oParam->apesado OR p58_codproc = {$oParam->principal}) ";

      $oDaoProcessoArquivado = new cl_protprocesso();
      $sSql = $oDaoProcessoArquivado->sql_query_arqproc(null, $sCampos, $sOrdem, $sWhere);
      $rsProcessoArquivado = $oDaoProcessoArquivado->sql_record($sSql);

      if ($oDaoProcessoArquivado->numrows > 1) {
        throw new Exception("Ambos Processos ({$oParam->principal} e {$oParam->apesado}) estão arquivados." .
          " Para apensá-los, ao menos um deve estar desarquivado.");
      }

      /**
       * Verifica se ocorrerá loop de processos
       * Ex.:
       * A -> B
       * B -> C
       * C -> A
       *
       */
      $oRet = $oDaoProcessoArquivado->getPrincipal($oParam->principal);

      if($oRet->p30_procprincipal == $oParam->apesado){
        throw new Exception("Não é possível apensar o processo ({$oParam->principal} ao {$oParam->apesado})." .
            " Existe um vínculo entre eles através de outros apensamentos, o que configuraria um loop de processos.");
      }

      /**
       * Inclui um processo apensado a um processo principal
       */
      $oDaoProcessoApensado = db_utils::getDao("processosapensados");
      $oDaoProcessoApensado->p30_procprincipal = $oParam->principal;
      $oDaoProcessoApensado->p30_procapensado = $oParam->apesado;
      $oDaoProcessoApensado->p30_sequencial = null;
      $oDaoProcessoApensado->incluir(null);

      $oRetorno->status = 2;
      $oRetorno->message = urlencode($oDaoProcessoApensado->erro_msg);
      if ($oDaoProcessoApensado->erro_status != 0) {

        $mProcessos = buscaProcessosApensados($oParam->principal);
        if ($mProcessos) {

          $oRetorno->dados = $mProcessos;
          $oRetorno->status = 1;
          $oRetorno->message = urlencode("Processo Apensado com sucesso.");
        }
      }

      break;

    case "desvinculaApensado":

      $sWhere = "     p30_procprincipal = {$oParam->principal}";
      $sWhere .= " and p30_procapensado  = {$oParam->apesado}";

      $oDaoProcessoApensado = db_utils::getDao("processosapensados");
      $oDaoProcessoApensado->excluir(null, $sWhere);

      $oRetorno->status = 2;
      $oRetorno->message = urlencode($oDaoProcessoApensado->erro_msg);
      if ($oDaoProcessoApensado->erro_status != 0) {

        $oRetorno->status = 1;
        $oRetorno->message = urlencode("Processo Desvinculado com sucesso.");
      }

      $mProcessos = buscaProcessosApensados($oParam->principal);
      if ($mProcessos) {
        $oRetorno->dados = $mProcessos;
      }
      break;
  }
} catch (Exception $e) {
  $oRetorno->status  = 2;
  $oRetorno->message = urlencode($e->getMessage());
}

/**
 * Efetua a busca dos processos apensados ao processo principal
 * @param integer $iProcesso
 * @return boolean/object Se a busca resultar em falha retorna false, se não retorna um objeto com os dados
 */
function buscaProcessosApensados ($iProcesso) {
  
  $sCampos = " distinct p30_procprincipal,
               p30_procapensado,
               principal.p58_requer,
               principal.p58_numero AS protocologeral,
               principal.p58_ano as anoprotocologeral,
               apensado.p58_numero AS protocologeralapensado,
               apensado.p58_ano as anoprotocologeralapensado";
  $sWhere  = " p30_procprincipal = {$iProcesso}";
   
  $oDaoProcessoApensado = db_utils::getDao("processosapensados");
  $sSqlProcessoApensado = $oDaoProcessoApensado->sql_query_processo_principal(null, $sCampos, null, $sWhere);
  $rsProcessoApensado   = $oDaoProcessoApensado->sql_record($sSqlProcessoApensado);

  if ($oDaoProcessoApensado->numrows > 0) {
  
    return db_utils::getCollectionByRecord($rsProcessoApensado, false, false, true);
  }
  
  return false;
  
}


echo $oJson->encode($oRetorno);