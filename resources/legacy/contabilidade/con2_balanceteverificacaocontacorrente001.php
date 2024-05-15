<?php

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
include("libs/db_liborcamento.php");
require_once("libs/JSON.php");

$aMeses = array(
    "01" => "Janeiro", "02" => "Fevereiro", "03" => "Março", "04" => "Abril", "05" => "Maio", "06" => "Junho", "07" => "Julho", "08" => "Agosto", "09" => "Setembro", "10" => "Outubro", "11" => "Novembro", "12" => "Dezembro"
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
        <fieldset class="fieldS1"> <legend>Balancete Verificação Conta Corrente</legend>
            <div class="formatdiv" align="left">
                <table style="margin-top: 10px; width: 100%;">
                    <br>
                    <tr>
                        <strong>Mês Referência:&nbsp;</strong>
                        <select name="mes" class="formatselect">
                            <option value="">Selecione...</option>
                            <?php foreach ($aMeses as $key => $value) : ?>
                                <option value="<?= $key ?>" >
                                    <?= $value ?>
                                </option>
                            <?php endforeach; ?>
                        </select><br><br>
                    </tr>
                    <tr>
                        <?
                        db_selinstit('',300,100);
                        ?>
                    </tr>
                    <tr>
                        <td>
                            <label class="bold" id="lbl_estruturais" for="estrut_inicial">Estrutural:</label>
                        </td>
                        <td colspan="3">
                            <?php
                            $Testrut_inicial = 'Informe os estruturais separados por vírgula';
                            db_input('estrut_inicial', '', '', false, '', '', 'style="width: 100%;"')
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <b>Tipo:</b>
                        <td>
                            <?$aTipos = array(2 => "Analítico - Fonte", 1 => "Sintético");
                            db_select('tipoRelatorio',$aTipos,false,1);
                            ?>
                        </td>
                        </td>
                    </tr>
                </table>
            </div>

            <div id="MSC" class="recebe">&nbsp;</div>
        </fieldset>
        <div class="formatdiv" align="center">
            <input type="button" value="Imprimir" onclick="js_emite()">
        </div>
    </div>
</form>
<script>

    function js_emite(){
        var mes     = document.form1.mes.value;
        var selinstit= document.form1.db_selinstit.value;
        var estrut_inicial = document.form1.estrut_inicial.value;
        var tipoRel = document.form1.tipoRelatorio.value;
        var arquivo = "";

        if (!mes) {
            alert("Todos os campos são obrigatórios");
            return false;
        }

        arquivo = 'con2_balanceteverificacaocontacorrente002.php';

        var query = "";
        query += ("mes="+mes+"&selinstit="+selinstit+"&estrut_inicial="+estrut_inicial)+"&tipoRel="+tipoRel;

        jan = window.open(
            arquivo+"?" + query,
            "",
            'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0'
        );
        jan.moveTo(0,0);
    }
</script>
<? db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit")); ?>
</body>
</html>
