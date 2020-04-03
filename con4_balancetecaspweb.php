<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");

$aBimestres = array(
    "01"  => "Janeiro",
    "02"  => "Fevereiro",
    "03"  => "Março",
    "04"  => "Abril",
    "05"  => "Maio",
    "06"  => "Junho",
    "07"  => "Julho",
    "08"  => "Agosto",
    "09"  => "Setembro",
    "10" => "Outubro",
    "11" => "Novembro",
    "12" => "Dezembro"
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
    <div class="center container" style="display: table">
        <fieldset>
            <legend>
                <b>Caspweb</b>
            </legend>
            <table style='empty-cells: show; border-collapse: collapse;'>
                <tr>
                    <td colspan="4">
                        <fieldset>
                            <table>
                                <tr>
                                    <td>
                                        <strong>Mês de Referência:&nbsp;</strong>
                                        <select name="iMes" class="formatselect">
                                            <option value="">Selecione...</option>
                                            <?php foreach ($aBimestres as $key => $value) : ?>
                                                <option value="<?= $key ?>" >
                                                    <?= $value ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">Item</td>
                    <td>Arquivos Gerados</td>
                </tr>
                <tr>
                    <td style="border: 2px groove white; padding-right: 100px;" valign="top">
                        <input type="checkbox" value="mapaAprop" id="mapaAprop" />
                        <label for="mapaAprop">Mapa de Apropriação da Câmara Municipal (32)</label><br>
                        <input type="checkbox" value="mapaRsp" id="mapaRsp" />
                        <label for="mapaRsp">Mapa de Restos a Pagar da Câmara Municipal (33)</label><br>
                    </td>
                    <td style="border: 2px groove white;" valign="top">
                    </td>
                    <td style="border: 2px groove white;" valign="top">
                        <div id='arquivo' style="width: 200px; height: 250px; overflow: scroll;">
                        </div>
                    </td>
                </tr>
            </table>
        </fieldset>
        <div style="text-align: center;">
            <input type="button" id="btnMarcarTodos" value="Marcar Todos" onclick="js_marcaTodos();" />
            <input type="button" id="btnLimparTodos" value="Limpar Todos" onclick="js_limpa();"/>
            <input type="button" id="btnProcessar" value="Processar"
                   onclick="js_gerarCaspweb();" />
        </div>
    </div>

</form>
<script>
    function novoAjax(params, onComplete) {

        var request = new Ajax.Request('con4_caspweb.RPC.php', {
            method:'post',
            parameters:'json='+Object.toJSON(params),
            onComplete: onComplete
        });

    }
    function js_gerarCaspweb() {

        var aArquivosSelecionados   = new Array();
        var iMes                    = document.form1.iMes.value;
        var aArquivos               = $$("input[type='checkbox']");

        aArquivos.each(function (oArquivo, iIndice) {

            if (oArquivo.checked) {
                aArquivosSelecionados.push(oArquivo.value);
            }
        });
        if (aArquivosSelecionados.length == 0) {

            alert("Nenhum arquivo foi selecionado para ser gerado");
            return false;
        }

        if (!iMes) {
            alert("Selecione o mês");
            return false;
        }

        js_divCarregando('Aguarde', 'div_aguarde');
        var params = {
            exec: 'gerarCaspweb',
            iMes: iMes,
            arquivos: aArquivosSelecionados
        };

        novoAjax(params, function(e) {
            var oRetorno = JSON.parse(e.responseText);
            if (oRetorno.status == 1) {
                js_removeObj('div_aguarde');
                alert("Processo concluído com sucesso!");
                var sArquivo = document.getElementById('arquivo');
                var sLink = "";
                for (const [i, arquivo] of Object.entries(oRetorno.arquivos)) {
                    sLink += "<br><a href='db_download.php?arquivo="+arquivo.nome+"'>"+arquivo.nome+"</a>";
                }
                sLink += "<br><a href='db_download.php?arquivo="+oRetorno.caminhoZip+"'>"+oRetorno.nomeZip+"</a>";
                sArquivo.innerHTML = sLink;
                sArquivo.style.display = "inline-block";
            } else {
                js_removeObj('div_aguarde');
                alert(oRetorno.message);
            }
        });

    }

    function js_marcaTodos() {

        var aCheckboxes = $$('input[type=checkbox]');
        aCheckboxes.each(function(oCheckbox) {
            oCheckbox.checked = true;
        });
    }

    function js_limpa() {

        var aCheckboxes = $$('input[type=checkbox]');
        aCheckboxes.each(function (oCheckbox) {
            oCheckbox.checked = false;
        });
    }
</script>
<? db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit")); ?>
</body>
</html>
