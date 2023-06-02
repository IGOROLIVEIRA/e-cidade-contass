<?php
require_once("libs/db_utils.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
?>
<!doctype html>
<html>

<head>
	<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta http-equiv="Expires" CONTENT="0">


	<link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body>

	<?php
	$aItensPlanilha = $_SESSION["aItensPlanilha"];
	unset($_SESSION['aItensPlanilha']);

	?>

	<fieldset style="width: 80%; margin-left: auto;margin-right: auto; margin-left: auto;margin-right: auto;">
		<legend>Itens Processados</legend>

		<table border="1" class="table" style="border: 0px solid black; ">
			<tr>
				<td style="border: 0px solid ;  background:#eeeff2;">Cod. Material</td>
				<td style="border: 0px solid ; background:#eeeff2;">Cod. Unidade</td>


			</tr>
			<?php

			for ($i = 0; $i < count($aItensPlanilha); $i++) {

				$sCorCelula = "";

				if ($aItensPlanilha[$i]->errocodmaterial != "") $sCorCelula = "#f09999";


				echo "<tr>";
				echo "<td style='text-align:center;'>";
				echo "<input title='" . $aItensPlanilha[$i]->errocodmaterial . "'  style='text-align:center; width:90%; border:none;  background-color:$sCorCelula;' readonly='' type='text'  value='" . $aItensPlanilha[$i]->codmaterial . "'>";
				echo "</td>";

				$sCorCelula = "";

				if ($aItensPlanilha[$i]->errocodunidade != "") $sCorCelula = "#f09999";

				echo "<td style='text-align:center; '>";
				echo "<input title='" . $aItensPlanilha[$i]->errocodunidade . "' style='text-align:center; width:90%; border:none;  background-color:$sCorCelula;' readonly='' type='text'  value='" . $aItensPlanilha[$i]->codunidade . "'>";
				echo "</td>";
			}

			?>

	</fieldset>

	</table>
</body>

</html>