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
require_once("classes/db_pagordemreinf_classe.php");

$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = "";

switch ($oParam->method) {

    case "incluiRetencaoImposto":
      $clpagordemreinf        = new cl_pagordemreinf;
      if(count($oParam->aEstabelecimentos) > 0){
        $clpagordemreinf->e102_codord = $oParam->iCodOrdem;
        foreach($oParam->aEstabelecimentos as $estabelecimento){
          $clpagordemreinf->e102_numcgm = $estabelecimento->e102_numcgm;
          $clpagordemreinf->e102_vlrbruto = $estabelecimento->e102_vlrbruto;
          $clpagordemreinf->e102_vlrbase = $estabelecimento->e102_vlrbase;
          $clpagordemreinf->e102_vlrir = $estabelecimento->e102_vlrir;
          $clpagordemreinf->sql_record($clpagordemreinf->sql_query($oParam->iCodOrdem, $estabelecimento->e102_numcgm));
          if($clpagordemreinf->numrows == 0){
            $clpagordemreinf->incluir();
          }else if($clpagordemreinf->numrows == 1){
            $clpagordemreinf->alterar($oParam->iCodOrdem,$estabelecimento->e102_numcgm);
          }
        }
      }
      if ($clpagordemreinf->erro_status == 1) {
          $oRetorno->status      = 2;
          $oRetorno->message = "Incluido com sucesso!";
      }else{
        $oRetorno->message = $clpagordemreinf->erro_msg;
      }
      break;

    case "verificaEstabelecimentos" :
      $clpagordemreinf        = new cl_pagordemreinf;
      $oRetorno->aEstabelecimentos = pg_fetch_all($clpagordemreinf->sql_record($clpagordemreinf->sql_query_nome($oParam->iCodOrdem,null,"pagordemreinf.*, z01_nome")));
      $oRetorno->status      = 2;
      $oRetorno->message = "OK";
      break;
}

echo $oJson->encode($oRetorno);
