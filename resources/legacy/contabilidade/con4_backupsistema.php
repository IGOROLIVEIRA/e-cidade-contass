<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
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
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
</table>
    <center>
			<table style="margin-top: 40px;">
			  <tr>
			   <td>
			    <input type="button" name="gera_backup" value="Gerar Backup" onclick="js_processar();"/>
     	</td>
     	</tr>
     	<tr>
     	<td>
     <div id='retorno'
                  style="width: 100px; height: 100px;">
     </div>
     </td>
     </tr>
    </table>
    </center>
	</td>
  </tr>
</table>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
function js_processar(){
js_divCarregando('Aguarde, processando arquivos','msgBox');
var oAjax = new Ajax.Request("func_backupsistema.php",
        {
      method:'post',
      onComplete:js_retornoProcessamento
        }
);
}
function js_retornoProcessamento(oAjax) {

	 js_removeObj('msgBox');
	  var caminho = eval("("+oAjax.responseText+")");
	  
		  alert("Processo concluído com sucesso!" );
	            
	    var sRetorno = "<a  href='db_download.php?arquivo="+caminho+"'>Backup</a><br>";
	 
	    $('retorno').innerHTML = sRetorno;
	} 

</script>