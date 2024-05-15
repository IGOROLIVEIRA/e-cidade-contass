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
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_app.utils.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_orcdotacao_classe.php");
include("libs/JSON.php");

$clorcdotacao = new cl_orcdotacao();

$oJson    = new services_json();
$oParam   = $oJson->decode(str_replace("\\","",$_POST["json"]));

$oRetorno = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = "";

try {
  
	switch ($oParam->exec) {

		case "getDotacao":
            
            $rsDotacao  = $clorcdotacao->sql_record($clorcdotacao->sql_query(db_getsession("DB_anousu"), $oParam->iCodDot));

            if ($clorcdotacao->numrows == 0) {
                throw new Exception("Nenhuma dotaηγo encontrada.");
            }

            if ($clorcdotacao->numrows > 0) {
            
                $oDotacao   = db_utils::fieldsMemory($rsDotacao, 0);
                
                $oDotacao->o40_descr = urlencode($oDotacao->o40_descr);
                $oDotacao->o41_descr = urlencode($oDotacao->o41_descr);
                $oDotacao->o55_descr = urlencode($oDotacao->o55_descr);
                $oDotacao->o15_descr = urlencode($oDotacao->o15_descr);
                $oDotacao->o54_descr = urlencode($oDotacao->o54_descr);
                $oDotacao->o52_descr = urlencode($oDotacao->o52_descr);
                $oDotacao->o53_descr = urlencode($oDotacao->o53_descr);
			    
                $oRetorno->oDotacao = $oDotacao;
                
            }
				 
			break;
		 			 
	}
  
} catch (Exception $eErro){
  
  $oRetorno->status = 2;
  $oRetorno->message = urlencode($eErro->getMessage());
  
} 

echo $oJson->encode($oRetorno);

?>