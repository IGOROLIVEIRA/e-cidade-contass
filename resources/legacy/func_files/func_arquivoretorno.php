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
require_once("classes/db_arquivoretornodados_classe.php");
require_once("classes/db_arquivoretorno_classe.php");

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

$clarquivoretorno = new cl_arquivoretorno();
$clarquivoretornodados = new cl_arquivoretornodados();


$aDataImportacao = array();
$rsDataImportacao = db_query($clarquivoretorno->sql_query_file(null,"DISTINCT rh216_dataimportacao","rh216_dataimportacao desc",""));
for ($iCont = 0; $iCont < pg_num_rows($rsDataImportacao); $iCont++) {
  $oDataImportacao = db_utils::fieldsMemory($rsDataImportacao, $iCont);
  $aDataImportacao[$oDataImportacao->rh216_dataimportacao] = date_format(date_create($oDataImportacao->rh216_dataimportacao), 'd/m/Y H:i:s'); 
}
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
                <b>Mostar Todos:</b>
              </td>
              <td width="96%" align="left" nowrap> 
              <?
                db_select('sOpcaoData',$aDataImportacao,true,4,"");
              ?>
              </td>
            </tr>
            <tr> 
              <td width="4%" align="left" nowrap title="">
                <b>Mostar Todos:</b>
              </td>
              <td width="96%" align="left" nowrap> 
              <?
                $aOpcaoMsg = array("false"=>"Não","true"=>"Sim");
                db_select('sOpcaoMsg',$aOpcaoMsg,true,4,"");
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

      $dbwhere = "rh216_instit = {$iInstit}";
      $campos = "rh217_nome,(substring(rh217_dn,5,4)||'-'||substring(rh217_dn,3,2)||'-'||substring(rh217_dn,1,2))::date as rh217_dn,rh217_cpf,rh217_nis,array_to_string(rh217_msg,'\n') as rh217_msg";

      if ((!isset($sOpcaoMsg)) || (isset($sOpcaoMsg) && $sOpcaoMsg == 'false')) {
        $dbwhere .= " and rh217_msg is not null";
      }

      if (isset($sOpcaoData) && !empty($sOpcaoData)) {
        $dbwhere .= " and rh216_dataimportacao = '{$sOpcaoData}'";
      } else {
        $dbwhere .= " and rh216_dataimportacao = '".key($aDataImportacao)."'";
      }
      
      $sql = $clarquivoretornodados->sql_query(null,$campos,"rh217_sequencial","{$dbwhere}");
      db_lovrot($sql,15,"()","","");

      ?>
      </fieldset>
      <br>
      <input name="relatorio" type="button" id="relatorio" value="Imprimir" onClick="js_emite();">
      <input name="excluir" type="button" id="excluir" value="Excluir Importação" onClick="js_excluir();">
    </td>
  </tr>
</table>
</body>
</html>
<script>
  var sUrlRPC = 'pes4_arquivoretorno.RPC.php';
  var oParam  = new Object();

  function js_emite() {

    var qry = '?todos='+document.form1.sOpcaoMsg.value;
    qry += '&data='+document.form1.sOpcaoData.value;
    jan = window.open('pes2_arquivoretorno002.php'+qry,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
    jan.moveTo(0,0);
  }

  function js_excluir() {

    let data = `${document.form1.sOpcaoData.value.substr(8, 2)}/${document.form1.sOpcaoData.value.substr(5, 2)}/${document.form1.sOpcaoData.value.substr(0, 4)} ${document.form1.sOpcaoData.value.substr(11, 8)}`;
    if (confirm(`Deseja excluir importação do dia ${data} ?`)) {
      js_processaExclusao();
    }
  }

  function js_processaExclusao() {

    js_divCarregando('Aguarde, processando...', 'msgbox');
    oParam.sMethod = 'excluirImportacao';
    oParam.dataImportacao = document.form1.sOpcaoData.value;
    var oAjax   = new Ajax.Request(
        sUrlRPC, 
        {
            method: 'post', 
            parameters: 'json='+Object.toJSON(oParam), 
            onComplete: js_retornoGeracao 
        }
    );
  }

  function js_retornoGeracao(oAjax) {

    var oRetorno = eval("("+oAjax.responseText+")");
    js_removeObj('msgbox');
    alert(oRetorno.sMsg.urlDecode());
    if (oRetorno.iStatus == 1) {
      [...document.getElementById('sOpcaoData').options]
      .filter(obj => obj.value === document.form1.sOpcaoData.value)
      .forEach(obj => obj.remove());
    }
  }
</script>