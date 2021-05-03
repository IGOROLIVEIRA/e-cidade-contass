<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_utils.php");
require_once("dbforms/db_funcoes.php");

$oGet = db_utils::postMemory($_GET);

?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="estilos.css" rel="stylesheet" type="text/css">
	<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
	<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
</head>
<style>
	table{
		margin-top: 8px;
	}

	.checkboxes{
		width: 100%;
	}

	.checkboxes tr > td:first-child{
		width: 30%;
		text-align: center;
	}

	.checkboxes tr > td:last-child{
		padding-left: 10px;
	}

	#confirmar{
		margin-top: 27px;
	}

</style>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<table height="145" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
		<tr>
			<td height="39" align="center" valign="top" colspan="2">
				<table border="0" align="center" cellspacing="0">
					<form name="form1" method="post" action="" >
						<th>Providência a ser realizada nesse contrato.</th>
						<table class="checkboxes">
							<tr>
								<td>
									<input type='checkbox' id='aditamento' name='checkBoxProvidencia' onclick="js_verificaItem(this.id);">
								</td>
								<td>
									<strong>Aditamento</strong>
								</td>
							</tr>
							<tr>
								<td>
									<input type='checkbox' id='finalizar' name='checkBoxProvidencia' onclick="js_verificaItem(this.id);">
								</td>
								<td>
									<strong>Finalizar</strong>
								</td>
							</tr>
						</table>
						<input type="button" onclick="js_submit()" id="confirmar" value="Confirmar"/>
					</form>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
<script>
	
	function js_verificaItem(objeto){

		if(objeto == 'finalizar'){
			document.getElementById('aditamento').checked = false;
		}else{
			document.getElementById('finalizar').checked = false;
		}
		
	}

	function js_submit(){

		if(!document.getElementById('finalizar').checked && !document.getElementById('aditamento').checked){
			alert('Informe uma providência a ser realizada.');
			return false;
		}

		if(document.getElementById('finalizar').checked){
			let oParam = new Object();
			oParam.exec = 'updateProvidencia';
			oParam.acordo = <?= $oGet->codigo?>;

			let oAjax = new Ajax.Request(
				"con4_contratos.RPC.php",
				{
					method: 'POST',
					parameters: 'json='+Object.toJSON(oParam),
					onComplete: js_retorno
				}
			);
		}

		if(document.getElementById('aditamento').checked){
			parent.parent.location.href = 'ac04_aditaoutros.php?acordo=<?=$oGet->codigo?>';
		}

	}

	function js_retorno(oAjax){
		let oResponse = eval("("+oAjax.responseText+")");
		
		if(oResponse.status){
			alert('Providência do acordo Finalizada com sucesso!');
			parent.db_iframe_providencia.hide();
			parent.parent.acordos.location.href = 'func_acordosavencer.php';
		}
	}


</script>