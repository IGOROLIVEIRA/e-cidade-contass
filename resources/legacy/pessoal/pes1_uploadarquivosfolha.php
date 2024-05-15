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
$sNomeArquivo = $sNomeCampo.".csv";
if (strtolower(end(explode('.', $_FILES["$sNomeCampo"]['name']))) != "csv") {
	echo "<div style=\"color: red;\">Envie arquivos somente com extensão .csv</div>";
}elseif($_FILES["$sNomeCampo"]['name'] == "TABELA_IRRF.csv" || $_FILES["$sNomeCampo"]['name'] == "TABELA_INSS.csv"){
	if (move_uploaded_file($_FILES["$sNomeCampo"]['tmp_name'], "tmp/".$_FILES['tabela']['name'])) {
		echo "<div style=\"color: blue;\">Arquivo enviado com sucesso!</div>";
	} else {
  	echo "<div style=\"color: blue;\">Não foi possível enviar o arquivo, tente novamente</div>";
	}
}else{
	echo "<div style=\"color: red;\">Nome do arquivo inválido envie TABELA_IRRF ou TABELA_INSS</div>";
}

?>
