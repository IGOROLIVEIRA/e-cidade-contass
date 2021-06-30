<?php
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2012  DBselller Servicos de Informatica             
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
$oGet                = db_utils::postMemory($_GET);
$oDaoPcProc          = db_utils::getDao("pcproc");
$sWhereProcesso      = "pc80_codproc ={$oGet->iProcesso}";
$sSqlCriterio = $oDaoPcProc->sql_query_proc_solicita(null, 
                                                            "pc80_criterioadjudicacao",
                                                            "", 
                                                            $sWhereProcesso
                                                            );

$resul = $oDaoPcProc->sql_record($sSqlCriterio);
$valor = db_utils::fieldsMemory($resul, 0);

?>
<html>
  <head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
  </head>
  <body bgcolor="#cccccc" onload="">
    <center>
      <form name="form1" method="post">
        <div style="display: table;">
          <fieldset>
            <legend><b>Critério de Adjudicação</b></legend>
          <table style="border:0,5px solid black;">
            <tr>
              <th style="width:100px;">
                Tipo
              </th>
              <th style="width:450px;">
                Critério de Adjudicação
              </th>
            </tr>
            <tr style="background:#ffffff;">
                <td>
                <? echo $valor->pc80_criterioadjudicacao;?>
                </td>
                <td>
                <?
                  if($valor->pc80_criterioadjudicacao==3)
                     echo "Outros";
                     if($valor->pc80_criterioadjudicacao==1)
                      echo "Desconto sobre tabela de preços praticados no mercado";
                      if($valor->pc80_criterioadjudicacao==2)
                       echo "Menor taxa de administração ou menor percentual de acréscimo sobre tabela;"
                ?>
                </td>
            </tr>
          </table>

          
          </fieldset>
        </div> 
      </form>
    </center>
  </body>
</html>