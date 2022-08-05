<?php

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_utils.php");
require_once ("libs/JSON.php");

db_postmemory($HTTP_SERVER_VARS);

$oPost   = db_utils::postMemory($_POST);
$oGet    = db_utils::postMemory($_GET);
$oJson   = new services_json();
$oParam  = $oJson->decode(str_replace("\\","",$_GET["oProcesso"]));

$oProcesso = new stdClass();
$oProcesso->lProcessoSistema = $oParam->lProcessoSistema ;
$oProcesso->iProcesso        = $oParam->iProcesso        ;
$oProcesso->sTitular         = $oParam->sTitular         ;
$oProcesso->dDataProcesso    = implode("-", array_reverse(explode("/",$oParam->dDataProcesso)));

db_putsession("oDadosProcesso", $oProcesso);
?>
<html lang="">
  <head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="estilos.css" rel="stylesheet" type="text/css">
  </head>
  <body class="body-default">
    <div class="container">
     <form name="form1">
      <fieldset>
        <legend>Selecione a procedência para cada receita</legend>
        <table>

  	     <tr>
  	       <td>
              <br>
  	         <iframe name="iframe" id="iframe"
  	                 marginwidth="0"
  	                 marginheight="0"
  	                 frameborder="0"
  	                 src="itb1_inscrdivida003.php?chave_origem=<?=$k00_tipo_or?>&tipoparc=<?=$tipoparc?>&datavenc=<?=$datavenc?>" width="850" height="300"></iframe>
  	       </td>
  	     </tr>

         <tr>
  	       <td width="100%" align="center" valign="top">
              <div id='process' style='visibility:visible'><strong><blink>Processando...</blink></strong></div>
  	       </td>
  	     </tr>

       </table>
    </fieldset>

	  <input disabled name="gerar" type="button" id="gerar" value="Gerar Dados" onClick="js_verificar()" />

    </form>
   </div>
  </body>
</html>
<script type="text/javascript">
function js_verificar(){

    let cont = 0;
    let pass = 'f';
  for (let i = 0; i < iframe.document.form1.length; i++) {

    if (iframe.document.form1.elements[i].type === "select-one") {

      if (iframe.document.form1.elements[i].value !== 0) {

	      cont++;
        pass = 't';
      }
    }
  }
  if (pass === 't') {

    iframe.document.form1.procreg.value = 't';
    iframe.document.form1.submit();
    document.getElementById('process').style.visibility='visible';
  }
}
</script>
