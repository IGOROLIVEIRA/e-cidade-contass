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

require_once("dbforms/db_funcoes.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("classes/db_habilitacaoforn_classe.php");

$clhabilitacao = new cl_habilitacaoforn();

$oDaoRotulo    = new rotulocampo;
$clhabilitacao->rotulo->label();

$oGet                = db_utils::postMemory($_GET);

$campos = "cgm.z01_numcgm,cgm.z01_nome,l206_datahab,l206_numcertidaoinss,l206_numcertidaofgts,l206_numcertidaocndt";
$sql = $clhabilitacao->sql_query(null,$campos,"","l206_licitacao = {$oGet->l20_codigo}");

$sFuncaoJS = isset($oGet->funcao_js) ? $oGet->funcao_js : "";

?>
<html>
  <head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <link href="estilos/tab.style.css" rel="stylesheet" type="text/css">
    <style type="text/css">

  .valor {
    background-color: #FFF;
  }
</style>
  </head>
  <body bgcolor="#cccccc" onload="">
        <div style="display: table; float:left; margin-left:10%;">
          <fieldset>
            <legend><b>Fornecedores Habilitados</b></legend>

          <?
           db_lovrot(@$sql, 15, "", "", $sFuncaoJS);
          ?>
          </fieldset>
        </div>
  </body>
</html>