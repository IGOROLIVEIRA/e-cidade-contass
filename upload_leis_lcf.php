<?php

$sNomeCampo = $_GET['nome_campo'];
$iAnoReferencia = $_GET['ano_usu'];

if($sNomeCampo == "LAO"){
	    $sNomeArquivo = "LAO_{$iAnoReferencia[2]}{$iAnoReferencia[3]}.pdf";
}
elseif($sNomeCampo == "LAOP"){
		$sNomeArquivo = "LAOP_{$iAnoReferencia[2]}{$iAnoReferencia[3]}.pdf";
}
elseif($sNomeCampo == "DEC"){
		$sNomeArquivo = "DEC_{$iAnoReferencia[2]}{$iAnoReferencia[3]}.pdf";
}


if (strtolower(end(explode('.', $_FILES["$sNomeCampo"]['name']))) != "pdf") {
	echo "<div style=\"color: red;\">Envie arquivos somente com extens�o .pdf</div>";
}else{
	if (move_uploaded_file($_FILES["$sNomeCampo"]['tmp_name'], "$sNomeArquivo")) {
		echo "<div style=\"color: blue;\">Arquivo enviado com sucesso!</div>";
	} else {
  	echo "<div style=\"color: blue;\">N�o foi poss�vel enviar o arquivo, tente novamente</div>";
	}
}


?>
