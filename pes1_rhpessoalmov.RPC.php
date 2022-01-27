<?php
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2013  DBselller Servicos de Informatica             
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
require_once("libs/JSON.php");
require_once("dbforms/db_funcoes.php");

$oJson    = new services_json();
$oParam   = $oJson->decode(str_replace("\\","",$_POST["json"]));

$oRetorno = new stdClass();
$oRetorno->iStatus = 1;
$oRetorno->sMsg    = "";

try {

    switch ($oParam->sMethod) {
        case 'consultaLotacaoRecurso':
            $oRetorno->lShow = false;
            $oDaoRhlotavinc = db_utils::getDao('rhlotavinc');
            $rsRhlotavinc = $oDaoRhlotavinc->sql_record($oDaoRhlotavinc->sql_query_file(null, "rh25_recurso", null, "rh25_codigo = {$oParam->iLotacao} AND rh25_anousu = ".db_getsession("DB_anousu")));
            if (in_array(db_utils::fieldsMemory($rsRhlotavinc, 0)->rh25_recurso, array('118','1118','218','166', '266','119','1119','219','167', '267', '101')) ) {
                $oRetorno->lShow = true;
            }
            break;
        
        default:
            break;
    }

} catch ( Exception $eException ) {
    $oRetorno->iStatus = 2;
    $oRetorno->sMsg    = urlencode(str_replace("\\n","\n",$eException->getMessage()));
}

echo $oJson->encode($oRetorno);

?>