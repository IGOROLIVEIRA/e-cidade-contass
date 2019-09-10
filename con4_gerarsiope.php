<?php
//echo "<pre>"; ini_set("display_errors",true);
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");

$aBimestres = array(
    "1" => "1º BIMESTRE", "2" => "2º BIMESTRE", "3" => "3º BIMESTRE", "4" => "4º BIMESTRE", "5" => "5º BIMESTRE", "6" => "6º BIMESTRE"
);

?>

<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/micoxUpload.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbmessageBoard.widget.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <style>
        div .formatdiv{
            margin-top: 5px;
            margin-bottom: 10px;
            padding-left: 5px;
        }
        .container {
            width: auto;
        }
        .formatselect {
            width: 200px;
            height: 18px;
        }
        .fieldS1 {
            position:relative;
            float: left;
        }
        .fieldS2 {
            position: relative;
            float: left;
            height: 115px;
        }
        #file {
            width: 200px !important;
        }
    </style>
</head>
<body bgcolor="#cccccc" style="margin-top: 25px;">
<form id='form1' name="form1" method="post" action="" enctype="multipart/form-data">
    <div class="center container">
        <fieldset class="fieldS1"> <legend>SIOPE</legend>
            <div class="formatdiv" align="left">
                <strong>Bimestre de Referência:&nbsp;</strong>
                <select name="bimestre" class="formatselect">
<!--                    <option value="">Selecione...</option>-->
                    <?php foreach ($aBimestres as $key => $value) : ?>
                        <option value="<?= $key ?>" >
                            <?= $value ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div id="siope" class="recebe">&nbsp;</div>
        </fieldset>
        <fieldset id="arquivo" class="fieldS2" style="display: none">
        </fieldset>
        <div class="formatdiv" align="center">
            <input type="button" value="Processar" onclick="gerarSiope()">
        </div>
    </div>
</form>
<script>
    function novoAjax(params, onComplete) {

        var request = new Ajax.Request('con4_siope.RPC.php', {
            method:'post',
            parameters:'json='+Object.toJSON(params),
            onComplete: onComplete
        });

    }
    function gerarSiope() {

        var iBimestre     = document.form1.bimestre.value;

        if (!iBimestre) {
            alert("Selecione o bimestre");
            return false;
        }

        js_divCarregando('Aguarde', 'div_aguarde');
        var params = {
            exec: 'gerarSiope',
            bimestre: iBimestre,
        };

        novoAjax(params, function(e) {
            var oRetorno = JSON.parse(e.responseText);
            if (oRetorno.status == 1) {
                js_removeObj('div_aguarde');
                alert("Processo concluído com sucesso!");
                var sArquivo = document.getElementById('arquivo');
                var sLink = "<legend>Arquivos Gerados</legend>";
                console.log(oRetorno.result);
                // sLink += "<br><a href='db_download.php?arquivo="+oRetorno.caminho+"'>"+oRetorno.nome+"</a>";
                // sLink += "<br><a href='db_download.php?arquivo="+oRetorno.caminhoZip+"'>"+oRetorno.nomeZip+"</a>";
                sArquivo.innerHTML = sLink;
                sArquivo.style.display = "inline-block";
            } else {
                js_removeObj('div_aguarde');
                alert(oRetorno.message);
            }
        });

    }
</script>
<? db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit")); ?>
</body>
</html>
