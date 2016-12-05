<?php

$sNomeCampo = $_GET['nome_campo'];
$iAnoReferencia = $_GET['ano_usu'];


if($sNomeCampo == "PPA"){
	$sNomeArquivo = "PPA{$iAnoReferencia}.pdf";
}else{
	if($sNomeCampo == "LDO"){
		$sNomeArquivo = "LDO{$iAnoReferencia}.pdf";
	}else{
		$sNomeArquivo = "LOA{$iAnoReferencia}.pdf";
	}
}

if (strtolower(end(explode('.', $_FILES["$sNomeCampo"]['name']))) != "pdf") {
	echo "<div style=\"color: red;\">Envie arquivos somente com extensão .pdf</div>";
}else{
	if (move_uploaded_file($_FILES["$sNomeCampo"]['tmp_name'], "$sNomeArquivo")) {
		echo "<div style=\"color: blue;\">Arquivo enviado com sucesso!</div>";
	} else {
  	echo "<div style=\"color: blue;\">Não foi possível enviar o arquivo, tente novamente</div>";
	}
}


?>
