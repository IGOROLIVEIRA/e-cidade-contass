<?php

$sNomeCampo = $_GET['nome_campo'];
$iAnoReferencia = $_GET['ano_usu'];

switch ($sNomeCampo){
	case "PPA":{
		$sNomeArquivo = "PPA{$iAnoReferencia}.pdf";
		break;
	}
	case "LDO":{
		$sNomeArquivo = "LDO{$iAnoReferencia}.pdf";
		break;
	}
	case "LOA":{
		$sNomeArquivo = "LOA{$iAnoReferencia}.pdf";
		break;
	}
	case "ANEXOS_LOA":{
		$sNomeArquivo = "ANEXOS_LOA.pdf";
		break;
	}
	case "OPCAOSEMESTRALIDADE":{
		$sNomeArquivo = "OPCAOSEMESTRALIDADE.pdf";
		break;
	}
	case "DESOPCAOSEMESTRALIDADE":{
		$sNomeArquivo = "DESOPCAOSEMESTRALIDADE.pdf";
		break;
	}

}

//if($sNomeCampo == "PPA"){
//	$sNomeArquivo = "PPA{$iAnoReferencia}.pdf";
//}else{
//	if($sNomeCampo == "LDO"){
//		$sNomeArquivo = "LDO{$iAnoReferencia}.pdf";
//	}else{
//		$sNomeArquivo = "LOA{$iAnoReferencia}.pdf";
//	}
//}

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
