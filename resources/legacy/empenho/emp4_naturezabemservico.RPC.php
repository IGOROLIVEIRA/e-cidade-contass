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
require_once("classes/db_naturezabemservico_classe.php");

$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = "";

$iAnoSessao = db_getsession("DB_anousu");
$iInstituicaoSessao = db_getsession("DB_instit");

switch ($oParam->exec) {

    case "verificaNaturezaAutoComplete":
        $sSqlWhere = "e101_codnaturezarendimento::TEXT LIKE '%{$oParam->iChave}%' OR e101_descr ILIKE '%{$oParam->iChave}%'";
      $clnatureza        = new cl_naturezabemservico;
      $sSqlCampos   = " distinct e101_codnaturezarendimento, to_ascii(e101_resumo) as e101_resumo, e101_aliquota";
      $sSqlMonta    = $clnatureza->sql_query(null, $sSqlCampos, "e101_codnaturezarendimento",$sSqlWhere);
      $rsExecutaQueryReduz = $clnatureza->sql_record($sSqlMonta);
      if ($clnatureza->numrows > 0) {
        for($i=0;$i<$clnatureza->numrows;$i++){
          $oDadosConPlano = db_utils::fieldsMemory($rsExecutaQueryReduz, $i);
          $objRenomeado = new stdClass();
          $objRenomeado->campo1 = $oDadosConPlano->e101_codnaturezarendimento;
          $objRenomeado->campo2 = $oDadosConPlano->e101_resumo;
          $objRenomeado->campo3 = $oDadosConPlano->e101_aliquota;
          $oRetorno->oDados[] = $objRenomeado;
        }
          $oRetorno->inputCodigo = $oParam->inputCodigo;
          $oRetorno->inputField  = $oParam->inputField;
          $oRetorno->ulField     = $oParam->ulField;
          $oRetorno->status      = 2;
      }
      break;
}

echo $oJson->encode($oRetorno);
