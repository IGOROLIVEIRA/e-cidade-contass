<?php 
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");

$oGet = db_utils::postMemory($_GET, false);
//$oGet->t52_bem = explode(",", $oGet->t52_bem);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
</head>
<body>
	<center>
		<fieldset>
			<legend><strong>Imprimir Pesquisa</strong></legend>
        
      <table>
        
       	<tr>
        		
       		<td>
       			<strong>Escolha o que será impresso no relatório:</strong>
       		</td>
        		
       	</tr>
        	
       	<tr>
       	
       		<td>
       			<input class="sOpcoes" type="checkbox" id="dadosMaterial" value="1" checked>
       			<label for="dadosMaterial">Dados Material</label>
       		</td>
        	
       	</tr>
        	
       	<tr>
        	
       		<td>
       			<input class="sOpcoes" type="checkbox" id="dadosImovel" value="1" checked>
       			<label for="dadosImovel">Dados Imóvel</label>
       		</td>
        	
       	</tr>
       	
       	<tr>
       	
       		<td align="center">
       			<input type="button" value="Imprimir" onclick="js_visualizaRelatorio(<?php echo "[".$oGet->t52_bem."]"; ?>,<?php echo $oGet->t93_codtran; ?>);">
       		</td>
       		
       	</tr>
        	
      </table>
    </fieldset>
  </center>
</body>
</html>
<script>

/**
 * Percorremos as opções de impressão e chamamos o fonte responsável pela impressão
 */
function js_visualizaRelatorio(iBem,iCodTransf){

	/**
	 * Montamos a string que passa as variáveis atrevés de GET
	 */
  var sGetUrl = '?t52_bem='+iBem;
  sGetUrl += '&t93_codtran='+iCodTransf;
  if ($('dadosMaterial').checked){
    sGetUrl += '&lDadosMaterial=true';
  }
  if ($('dadosImovel').checked){
    sGetUrl += '&lDadosImovel=true';
  }

  /**
   * Chamamos efetivamente o fonte que monta o pdf do relatório
   */
  var sUrl = 'func_impressaobenstrans002.php' + sGetUrl;
  var sConfiguracao  = 'width='+(screen.availWidth-5)+',height=';
  		sConfiguracao += (screen.availHeight-40)+',scrollbars=1,location=0 ';
  var jan  = window.open(sUrl, '', sConfiguracao);
}
</script>