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
require_once("dbforms/db_funcoes.php");
require_once("std/db_stdClass.php");
require_once("libs/JSON.php");

$oJson        = JSON::create();
$oParametros  = $oJson->parse(str_replace("\\","",$_POST["json"]));

$oRetorno           = new stdClass();
$oRetorno->status   = "1";
$oRetorno->erro     = false;
$oRetorno->mensagem = "";

/**
 * Caminho das mensagens do programa
 */

try {

  db_inicio_transacao();
  switch ( $oParametros->exec ) {
    
    case 'processar':
      
      foreach ($oParametros->formularios as $formulario) {
        
        $formulario    = \ECidade\Configuracao\Formulario\Repository\Formulario::getById((int)$formulario);
        $processamento = new \ECidade\Configuracao\Formulario\Processamento\Carga($formulario);
        // echo "<pre>";
        // var_dump(get_included_files());
        // die;
        $processamento->executar();

      }
      $oRetorno->mensagem = "Carga dos Formulários processadas com sucesso.";
      break;

    case 'remover':
      
      foreach ($oParametros->formularios as $formulario) {
        
        $formulario    = \ECidade\Configuracao\Formulario\Repository\Formulario::getById((int)$formulario);
        $processamento = new \ECidade\Configuracao\Formulario\Processamento\RemoveCarga($formulario);
        $processamento->executar();

      }
      $oRetorno->mensagem = "Carga dos Formulários removidas com sucesso.";
      break;
  }
  db_fim_transacao(false);
  
} catch ( Exception $eErro ) {

  $oRetorno->status   = 2;
  $oRetorno->erro     = true;
  $oRetorno->mensagem = $eErro->getMessage();
  db_fim_transacao(true);
}


echo $oJson->stringify($oRetorno);