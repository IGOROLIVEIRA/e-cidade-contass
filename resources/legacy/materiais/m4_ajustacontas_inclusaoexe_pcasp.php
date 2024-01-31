<html>
<?php
require_once 'libs/db_stdlib.php';
require_once 'libs/db_conecta.php';
require_once 'libs/db_sessoes.php';
require_once 'libs/db_usuariosonline.php';
require_once 'libs/db_utils.php';
require_once 'dbforms/db_funcoes.php';
?>
<head>
    <title>Contass Contabilidade Ltda - Pagina Inicial</title>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <style>
    </style>
</head>

<body bgcolor="#CCCCCC">
<center>
    <form name='form1' method="post" action="">
        <fieldset style="width: 600px; margin-top: 30px">
            <legend>Ajuste das Contas do PCASP:</legend>
            <table align="left">
                <tr>
                    <td>
                        <strong>Tipo de Ajuste:</strong>
                    </td>
                    <td>
                        <select multiple="multiple" style="width: 180%" id="tipo">
                        <?php
                        $aTipos = array(
                            "0" => "Selecione",
                            "1" => "Contas e Reduzidos PCASP",
                            "2" => "Vinculo PCASP com o Conta Corrente",
                            "3" => "Vinculo PCASP com as Contas Bancárias"
                        );
                        foreach ($aTipos as $valor => $tipo) {
                            echo "<option value=\"$valor\">$tipo</option>";
                        }
                        ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><strong>Ano Origem:</strong></td>
                    <td>
                        <?php db_input('ano_origem', 10, true, 'text', 1, ""); ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Ano Destino:</strong></td>
                    <td>
                        <?php db_input('ano_destino', 10, true, 'text', 1, ""); ?>
                    </td>
                </tr>
            </table>
            <?
            db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
            ?>
        </fieldset>
        <input type="button" style="margin-top: 15px;" name="ajustar" id="ajustar" value="Ajustar"
               onclick="js_ajustaContasPCASP()">
    </form>
</center>
</body>

<script>


    function js_ajustaContasPCASP() {

        if (document.getElementById('tipo').value == 0) {

            return alert("Usuário: selecione o tipo para ajustar.")
        }

        const idCampo = {
            1: 'conplano',
            2: 'conplanocontacorrente',
            3: 'conplanoconta'
        };

        const selectElement = document.getElementById('tipo');

        const selectedValues = [];

        for (let i = 0; i < selectElement.options.length; i++) {
            if (selectElement.options[i].selected || selectElement.options[i].getAttribute('selected')) {
                selectedValues.push(idCampo[selectElement.options[i].value]);
            }
        }
        let anoOrigem = $F('ano_origem')
        let anoDestino = $F('ano_destino')

        let oParametros = {};
        oParametros.tipo = selectedValues;
        oParametros.anoOrigem = anoOrigem;
        oParametros.anoDestino = anoDestino;
        let oAjax = new Ajax.Request('m4_ajustacontas_inclusaoexe_pcasp.RPC.php', {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParametros),
            onComplete: js_retornoAlteraObservacao

        });
    }

    function js_retornoAlteraObservacao(oAjax) {

        let oRetorno = eval("(" + oAjax.responseText + ")");
        if (oRetorno.status == 1) {
            return alert("Ajuste(s) Efetuado(s)");
        }
        alert(erro);

    }

</script>