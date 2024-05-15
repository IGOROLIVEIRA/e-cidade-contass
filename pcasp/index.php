<html>
	<style>
		#centro{
			margin-top: 50px;
			margin-left: 50px;
			width:300px;
		
		}
		#ano{
			width:50px;
		}
	</style>
	<head>
		<script language="javascript" type="text/javascript">
			function validar() {
				var arquivo = form1.arquivo.value;
				var dbano = form1.dbano.value;
							 
				if (arquivo == "") {
					alert('Selecione o arquivo!');
					form1.arquivo.focus();
					return false;
				}
				if (dbano == "") {
					alert('Digite o ano!');
					form1.dbano.focus();
					return false;
				}
			}
		</script>
	</head>
	<body>
	<div id="centro">
		<fieldset>
			<legend>Vinculação PCASP X PLANO ORÇAMENTÁRIO</legend>
			<form name="form1" method="post" action="pcasp.php" enctype="multipart/form-data">
                <table><br>
	                <tr><td>Arquivo:</td><td><input name="arquivo" size="20" type="file" /></td></tr>				
					
					<tr><td>Ano:</td><td><input id="ano" type="text" name="dbano"></td></tr>
					<tr><td></td><td></td></tr>
					<tr><td></td><td></td></tr>
					<tr><td></td><td></td></tr>
					<tr><td></td><td><input type="submit" onclick="return validar()"></td></tr>
                </table>
			</form>
		</fieldset>
	</div>
	</body>
</html>
