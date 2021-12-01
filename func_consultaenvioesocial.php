<?php

/**
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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_esocialenvio_classe.php");
require_once("classes/db_esocialrecibo_classe.php");

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

$clesocialenvio = new cl_esocialenvio();
$clesocialrecibo = new cl_esocialrecibo();

$iInstit = db_getsession("DB_instit");
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table height="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
  <tr>
    <td height="63" align="center" valign="top">
      <form name="form1" method="post" action="" >
        <fieldset style="width: 35%">
          <legend>Arquivo Retorno</legend>
          <table width="35%" border="0" align="center" cellspacing="0">
            <tr> 
              <td width="4%" align="left" nowrap title="">
                <b>Situação:</b>
              </td>
              <td width="96%" align="left" nowrap> 
              <?
                $aSituacao = array("1"=>"A ENVIAR","3"=>"PROCESSANDO ENVIO","2"=>"ENVIADO","4"=>"ERRO NO ENVIO");
                db_select('situacao',$aSituacao,true,4,"");
              ?>
              </td>
            </tr>
          </table>
        </fieldset>
        <table width="35%" border="0" align="center" cellspacing="0">
          <tr>
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar" onclick="return js_valida(arguments[0])"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_arquivo_retorno.hide();">
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">
      <fieldset>
        <legend>Resultado da Pesquisa</legend>
      <?php

      $dbwhere = "rh213_empregador = (SELECT numcgm FROM db_config WHERE codigo = {$iInstit})";
      $campos = "rh213_sequencial,rh213_evento,CASE 
      WHEN rh213_situacao = 1 THEN 'A ENVIAR' 
      WHEN rh213_situacao = 3 THEN 'PROCESSANDO ENVIO' 
      WHEN rh213_situacao = 2 THEN 'ENVIADO' 
      WHEN rh213_situacao = 4 THEN 'ERRO NO ENVIO' 
      END AS rh213_situacao,rh215_recibo as dl_recibo,rh215_dataentrega as dl_entrega,
      rh213_dataprocessamento,rh213_msgretorno";

      if (isset($situacao) && !empty($situacao)) {
        $dbwhere .= " and rh213_situacao = {$situacao}";
      }
      
      $sql = $clesocialenvio->sql_query(null,$campos,"rh213_sequencial desc","{$dbwhere}");
      db_lovrot($sql,15,"()","","");
      ?>
      </fieldset>
    </td>
  </tr>
</table>
</body>
</html>
<script>
  var sUrlRPC = 'eso4_esocialapi.RPC.php';
  var oParam  = new Object();
  var consultaTimeOut;

  function js_consultar() {

    oParam.exec = 'consultar';
    var oAjax   = new Ajax.Request(
        sUrlRPC, 
        {
            method: 'post', 
            parameters: 'json='+Object.toJSON(oParam), 
            onComplete: js_retorno
        }
    );
  }

  function js_retorno(oAjax) {

    var oRetorno = eval("("+oAjax.responseText+")");
    if (oRetorno.lUpdate === true) {
      consultaTimeOut = setTimeout("location.reload()", 10000);
    }
  }

  parent.document.getElementById('fechariframe_consulta_envio').addEventListener('click', function() {
    clearTimeout(consultaTimeOut);
  })

  js_consultar();
</script>