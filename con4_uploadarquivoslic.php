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
//$sNomeArquivo = $sNomeCampo . ".zip";
system("rm tmp/" . $_FILES['PROC']['name']);
if (
    strtolower(end(explode('.', $_FILES["$sNomeCampo"]['name']))) != "txt"
    && strtolower(end(explode('.', $_FILES["$sNomeCampo"]['name']))) != "csv"
    && strtolower(end(explode('.', $_FILES["$sNomeCampo"]['name']))) != "imp"
) {
    echo "<div style=\"color: red;\">Envie arquivos somente com extensões .txt .csv .imp</div>";
} else {
    if (move_uploaded_file($_FILES["$sNomeCampo"]['tmp_name'], "tmp/" . $_FILES['PROC']['name'])) {
        echo "<div style=\"color: blue;\">Arquivo enviado com sucesso!</div>";
    } else {
        echo "<div style=\"color: blue;\">Não foi possível enviar o arquivo, tente novamente</div>";
    }
}
