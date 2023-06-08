<?
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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_utils.php");
require_once("classes/db_arquivoretornodados_classe.php");

db_postmemory($HTTP_POST_VARS);
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<form name="form1"  method="post" action="" enctype="multipart/form-data" class="container">

    <center>

        <fieldset>
            <legend><b>Arquivo Retorno eSocial</b></legend>

            <table>
                <tr>
                  <td>
                    <b>Arquivo :</b>
                  </td>
                  <td>
                    <input type="file" id="arquivo" name="arquivo" />
                  </td>
                </tr>
           </table>

        </fieldset>

        <table>
            <tr>
                <td colspan="2" align = "center">
                    <input name="enviar" type="button" value="Importar" onclick="js_processar();" />
                    <input name="pesquisar" type="button" id="pesquisar" value="Mostrar Importados" onclick="js_pesquisa();">
                </td>
            </tr>
        </table>

    </center>
</form>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
    var sUrlRPC = 'pes4_arquivoretorno.RPC.php';
    var oParam  = new Object();

    function js_processar() {
        js_divCarregando('Aguarde, processando...', 'msgbox');
        js_importarArquivo();
    }

    function js_processarArquivo() {
        oParam.sMethod = 'processar';
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
            $('arquivo').value = '';
            js_pesquisa();
        }
    }

    async function js_importarArquivo() {

        oParam.sMethod = 'importar';
        var arquivo = document.getElementById('arquivo');
        var formData = new FormData();
        var file = arquivo.files[0];
        oParam.sFile = file.name;
        formData.append('arquivo', file, file.name);
        formData.append('json', Object.toJSON(oParam));
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'pes4_arquivoretorno.RPC.php', true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                var oRetorno = eval("("+xhr.responseText+")");
                if ( oRetorno.iStatus == 2 ) {
                    alert(oRetorno.sMsg.urlDecode());
                    js_removeObj('msgbox');
                } else {
                    js_processarArquivo();
                }
            } else {
                alert('Erro ao importar arquivo.');
                js_removeObj('msgbox');
            }
        };
        xhr.send(formData);
    }

    function js_pesquisa() {
      js_OpenJanelaIframe('top.corpo','iframe_arquivo_retorno','func_arquivoretorno.php','Pesquisa',true);
    }
</script>