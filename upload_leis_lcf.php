<?php

$sNomeCampo = $_GET['nome_campo'];
$iAnoReferencia = $_GET['ano_usu'];

if ($sNomeCampo == "LAO") {
    $sNomeArquivo = "LAO_{$iAnoReferencia}.pdf";
} elseif ($sNomeCampo == "LAOP") {
    $sNomeArquivo = "LAOP_{$iAnoReferencia}.pdf";
} elseif ($sNomeCampo == "DEC") {
    $sNomeArquivo = "DEC_{$iAnoReferencia}.pdf";
}

if ($sNomeCampo == "DEC") {
        for ($i = 0; $i < count($_FILES["$sNomeCampo"]['name']); $i++) {
        if (strtolower(end(explode('.', $_FILES["$sNomeCampo"]['name'][$i]))) != "pdf") {
            echo "<div style=\"color: red;\">Envie arquivos somente com extensão .pdf</div>";
        } else {
            $sNovoNome = ($i > 0 ? reset(explode(".",$sNomeArquivo))."_$i": reset(explode(".",$sNomeArquivo)));
            if (move_uploaded_file($_FILES["$sNomeCampo"]['tmp_name'][$i], "$sNovoNome.pdf")) {
                echo "<div style=\"color: blue;\">Arquivo ".$_FILES["$sNomeCampo"]['name'][$i]." enviado com sucesso!</div>";
            } else {
                echo "<div style=\"color: blue;\">Não foi possível enviar o arquivo ".$_FILES["$sNomeCampo"]['name'][$i].", tente novamente</div>";
            }
        }
    }
} else {

    if (strtolower(end(explode('.', $_FILES["$sNomeCampo"]['name']))) != "pdf") {
        echo "<div style=\"color: red;\">Envie arquivos somente com extensão .pdf</div>";
    } else {
        if (move_uploaded_file($_FILES["$sNomeCampo"]['tmp_name'], "$sNomeArquivo")) {
            echo "<div style=\"color: blue;\">Arquivo enviado ".$_FILES["$sNomeCampo"]['name']." com sucesso!</div>";
        } else {
            echo "<div style=\"color: blue;\">Não foi possível enviar o arquivo ".$_FILES["$sNomeCampo"]['name'].", tente novamente</div>";
        }
    }
}


?>
