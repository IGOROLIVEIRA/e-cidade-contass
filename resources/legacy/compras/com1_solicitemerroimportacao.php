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
	$aOrdem = explode("-", $_SESSION["sOrdem"]);
	$aCodmaterial = explode("-", $_SESSION["sCodmaterial"]);
	$aReduzido = explode("-", $_SESSION["sReduzido"]);
	$aControlaQuantidade = explode("-", $_SESSION["sControlaQuantidade"]);
	$aQuantidade = explode("-", $_SESSION["sQuantidade"]);
	$aCodunidade = explode("-", $_SESSION["sCodUnidade"]);

	unset($_SESSION['sOrdem']);
	unset($_SESSION['sCodmaterial']);
	unset($_SESSION['sReduzido']);
	unset($_SESSION['sControlaQuantidade']);
	unset($_SESSION['sQuantidade']);
	unset($_SESSION['sCodUnidade']);

	?>

	<fieldset style="width: 80%; margin-left: auto;margin-right: auto; margin-left: auto;margin-right: auto;">
		<legend>Itens Processados</legend>

		<table border="1" class="table" style="border: 0px solid black; ">
			<tr>
				<td style="border: 0px solid ;  background:#eeeff2;">Ordem</td>
				<td style="border: 0px solid ; background:#eeeff2;">Cod Material</td>
				<td style="border: 0px solid ;  background:#eeeff2;">Reduzido do Desdobramento</td>
				<td style="border: 0px solid ;  background:#eeeff2;">Controlado por Quantidade</td>
				<td style="border: 0px solid ;  background:#eeeff2;">Quantidade</td>
				<td style="border: 0px solid ;  background:#eeeff2;">Cod Unidade</td>

			</tr>
			<?php
			$anousu = db_getsession("DB_anousu");
			for ($i = 0; $i < count($aCodmaterial); $i++) {

				echo "<tr>";
				if (is_numeric($aOrdem[$i])) {
					echo "<td style='text-align:center;'>";
					echo "<input  style='text-align:center; width:90%; border:none;' readonly='' type='text' name='ordem[]' value='" . $aOrdem[$i] . "'>";
					echo "</td>";
				} else {
					echo "<td style='text-align:center; background-color:#f09999;'>";
					echo "<input title='Campo ordem permite somente números' style='text-align:center; width:90%; border:none; background-color:#f09999;' readonly='' type='text' name='ordem[]' value='" . $aOrdem[$i] . "'>";
					echo "</td>";
				}

				if (is_numeric($aCodmaterial[$i])) {
					$sSQL = "select * from pcmater where pc01_codmater = {$aCodmaterial[$i]} ;";
					$rsPcmater       = db_query($sSQL);
					if (pg_numrows($rsPcmater) == 0) {
						echo "<td style='text-align:center; '>";
						echo "<input title='Campo material não encontrado' style='text-align:center; width:90%; border:none; background-color:#f09999;' readonly='' type='text' name='codmaterial[]' value='" . $aCodmaterial[$i] . "'>";
						echo "</td>";
					} else {
						echo "<td style='text-align:center;'>";
						echo "<input  style='text-align:center; width:90%; border:none;' readonly='' type='text' name='codmaterial[]' value='" . $aCodmaterial[$i] . "'>";
						echo "</td>";
					}
				} else {
					echo "<td style='text-align:center; background-color:#f09999;'>";
					echo "<input title='Campo cod. material permite somente números inteiros' style='text-align:center; width:90%; border:none; background-color:#f09999;' readonly='' type='text' name='codmaterial[]' value='" . $aCodmaterial[$i] . "'>";
					echo "</td>";
				}

				if (is_numeric($aReduzido[$i])) {
					$sSQL = "select * from orcelemento where o56_codele = {$aReduzido[$i]} and o56_anousu = $anousu ;";
					$rsOrcelemento       = db_query($sSQL);
					if (pg_numrows($rsOrcelemento) == 0) {
						echo "<td style='text-align:center; '>";
						echo "<input title='Campo reduzido não encontrado' style='text-align:center; width:90%; border:none; background-color:#f09999;' readonly='' type='text' name='reduzido[]' value='" . $aReduzido[$i] . "'>";
						echo "</td>";
					} else {
						echo "<td style='text-align:center;'>";
						echo "<input  style='text-align:center; width:90%; border:none;' readonly='' type='text' name='reduzido[]' value='" . $aReduzido[$i] . "'>";
						echo "</td>";
					}
				} else {
					echo "<td style='text-align:center; background-color:#f09999;'>";
					echo "<input title='Campo cod. reduzido permite somente números inteiros' style='text-align:center; width:90%; border:none; background-color:#f09999;' readonly='' type='text' name='reduzido[]' value='" . $aReduzido[$i] . "'>";
					echo "</td>";
				}


				if ($aControlaQuantidade[$i] == "") {
					echo "<td style='text-align:center; background-color:#f09999;'>";
					echo "<input title='Campo controlado por quantidade não informado' style='text-align:center; width:90%; border:none; background-color:#f09999;' readonly='' type='text' name='controladoquantidade[]' value='" . ($aControlaQuantidade[$i]) . "'>";
					echo "</td>";
				} else if (mb_strtolower($aControlaQuantidade[$i]) != "sim" && mb_strtolower($aControlaQuantidade[$i]) != "não" && mb_strtolower($aControlaQuantidade[$i]) != "nao") {

					echo "<td style='text-align:center; background-color:#f09999;'>";
					echo "<input title='Campo Controlado por quantidade permite somente Sim ou Não' style='text-align:center; width:90%; border:none; background-color:#f09999;' readonly='' type='text' name='controladoquantidade[]' value='" . $aControlaQuantidade[$i] . "'>";
					echo "</td>";
				} else if (mb_strtolower($aControlaQuantidade[$i]) == "não" || mb_strtolower($aControlaQuantidade[$i]) == "nao") {
					$sSQL = "select * from pcmater where pc01_codmater = {$aCodmaterial[$i]} and pc01_servico = true;";
					$rsPcmater       = db_query($sSQL);
					if (pg_numrows($rsPcmater) == 0) {
						echo "<td style='text-align:center; background-color:#f09999;'>";
						echo "<input title='Campo controlado por quantidade com valor não, é válido apenas em itens do tipo serviço/material permanente' style='text-align:center; width:90%; border:none; background-color:#f09999;' readonly='' type='text' name='controladoquantidade[]' value='" . $aControlaQuantidade[$i] . "'>";
						echo "</td>";
					} else {
						echo "<td style='text-align:center;'>";
						echo "<input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='taxa[]' value='" . $aControlaQuantidade[$i] . "'>";
						echo "</td>";
					}
				} else {
					echo "<td style='text-align:center;'>";
					echo "<input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='taxa[]' value='" . $aControlaQuantidade[$i] . "'>";
					echo "</td>";
				}

				if (is_numeric($aQuantidade[$i])) {
					if ((mb_strtolower($aControlaQuantidade[$i]) == "não" || mb_strtolower($aControlaQuantidade[$i]) == "nao") && $aQuantidade[$i] > 1) {

						echo "<td style='text-align:center; background-color:#f09999;'>";
						echo "<input title='Campo quantidade não pode ser maior que 1 quando o item for controlado por quantidade' style='text-align:center; width:90%; border:none; background-color:#f09999;' readonly='' type='text' name='quantidade[]' value='" . $aQuantidade[$i] . "'>";
						echo "</td>";
					} else {
						echo "<td style='text-align:center;'>";
						echo "<input  style='text-align:center; width:90%; border:none;' readonly='' type='text' name='quantidade[]' value='" . $aQuantidade[$i] . "'>";
						echo "</td>";
					}
				}

				if (is_numeric($aCodunidade[$i])) {
					$sSQL = "select * from matunid where m61_codmatunid = {$aCodunidade[$i]} ;";
					$rsMatunid      = db_query($sSQL);
					if (pg_numrows($rsMatunid) == 0) {
						echo "<td style='text-align:center; '>";
						echo "<input title='Campo unidade não encontrado' style='text-align:center; width:90%; border:none; background-color:#f09999;' readonly='' type='text' name='codunidade[]' value='" . $aCodunidade[$i] . "'>";
						echo "</td>";
					} else {
						echo "<td style='text-align:center;'>";
						echo "<input  style='text-align:center; width:90%; border:none;' readonly='' type='text' name='codunidade[]' value='" . $aCodunidade[$i] . "'>";
						echo "</td>";
					}
				} else {
					echo "<td style='text-align:center; background-color:#f09999;'>";
					echo "<input title='Campo unidade permite somente números inteiros' style='text-align:center; width:90%; border:none; background-color:#f09999;' readonly='' type='text' name='codunidade[]' value='" . $aCodunidade[$i] . "'>";
					echo "</td>";
				}
			}

			?>

	</fieldset>

	</table>
</body>

</html>