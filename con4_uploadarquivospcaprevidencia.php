<?php
/**
 *
 * @author I
 * @revision $Author: robson
 */
require("libs/db_stdlib.php");
require("libs/db_utils.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

//db_postmemory($HTTP_POST_VARS);

$sNomeCampo   = key($_FILES);
$extensao = strtolower(end(explode('.', $_FILES["$sNomeCampo"]['name'])));
$diaMes = "";
if(db_getsession("DB_anousu") > 2020){
    $diaMes = "31_12_";
    if($sNomeCampo == "RAH"){
        $diaMes = "31_07_";
    }
}
$sNomeArquivo = $sNomeCampo."_{$diaMes}".db_getsession("DB_anousu").".".$extensao;


if ($extensao != "pdf" && $extensao != "xls" && $extensao != "xlsx") {
	echo "<div style=\"color: red;\">Envie arquivos somente com extensão .pdf ou .xls ou .xlsx</div>";
}else{
	if (file_exists($sNomeCampo."_{$diaMes}".db_getsession("DB_anousu").".pdf")) {
		unlink($sNomeCampo."_{$diaMes}".db_getsession("DB_anousu").".pdf");
	}
	if (file_exists($sNomeCampo."_{$diaMes}".db_getsession("DB_anousu").".xls")) {
		unlink($sNomeCampo."_{$diaMes}".db_getsession("DB_anousu").".xls");
	}
	if (file_exists($sNomeCampo."_{$diaMes}".db_getsession("DB_anousu").".xlsx")) {
		unlink($sNomeCampo."_{$diaMes}".db_getsession("DB_anousu").".xlsx");
	}
	if (move_uploaded_file($_FILES["$sNomeCampo"]['tmp_name'], "$sNomeArquivo")) {
		echo "<div style=\"color: blue;\">Arquivo enviado com sucesso!</div>";
	} else {
  	echo "<div style=\"color: blue;\">Não foi possível enviar o arquivo, tente novamente</div>";
	}
}


?>
