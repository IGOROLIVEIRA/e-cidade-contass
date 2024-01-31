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
$oParam   = $oJson->decode(str_replace("\\", "", $_POST["json"]));

$oRetorno = new stdClass();
$oRetorno->iStatus = 1;
$oRetorno->sMsg    = "";

    switch ($oParam->exec) {
        case 'consultaMatricula':
            $clrhpessoal    = new cl_rhpessoal;
            $result = $clrhpessoal->sql_record($clrhpessoal->verificaMatriculaECargo($oParam->iNumCgm));
            if ($clrhpessoal->numrows > 0) {
                $result = db_utils::fieldsMemory($result, 0);
                $oRetorno->z01_nome = $result->z01_nome;
                $oRetorno->rh01_regist = $result->rh01_regist;
                $oRetorno->rh37_descr = $result->rh37_descr;
            } else {
                $oRetorno->iStatus = 2;
                $oRetorno->sMsg    = "Registro não encontrado.";
            }
            break;

        default:
            break;
    }

echo $oJson->encode($oRetorno);
