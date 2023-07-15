<?php

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_esocialenvio_classe.php");
require_once("classes/db_esocialrecibo_classe.php");
include("dbforms/db_classesgenericas.php");
$cliframe_seleciona = new cl_iframe_seleciona;

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

$clesocialenvio = new cl_esocialenvio();
$clesocialrecibo = new cl_esocialrecibo();

$iInstit = db_getsession("DB_instit");
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <table height="100%" border="0" align="center" cellspacing="0" bgcolor="#CCCCCC">
        <tr>
            <td height="63" align="center" valign="top">
                <form name="form1" method="post" action="">
                    <table width="35%" border="0" align="center" cellspacing="0">
                        <tr>
                            <td colspan="2" align="center">
                                <input type="button" id="btnEnviar" value="Enviar para eSocial" onclick="js_processar();" />
                            </td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
        <tr>
            <td align="center" valign="top">
                <fieldset>
                    <legend>Resultado da Pesquisa</legend>
                    <?php

                    $dbwhere = "rh213_empregador = (SELECT numcgm FROM db_config WHERE codigo = {$iInstit})";
                    $campos = "rh213_sequencial,rh213_evento,rh215_recibo,rh215_dataentrega as dl_entrega,
                    rh213_protocolo as dl_protocolo, rh213_dados,rh213_dataprocessamento,rh213_msgretorno";
                    $dbwhere .= " and rh213_situacao = 2";
                    
                    
                    $sql = $clesocialenvio->sql_query(null, $campos, "rh213_sequencial desc", "{$dbwhere}");
                    
                    db_lovrot($sql, 15, "()", "", "","","NoMe",array(), false,array(), true);
                    ?>
                </fieldset>
            </td>
        </tr>
    </table>
</body>

</html>
<script>
    const selectAll = document.getElementById("select-all");
    const checkboxes = document.querySelectorAll(".checkbox");

    selectAll.addEventListener("click", function() {
        for (let i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = selectAll.checked;
        }
    });

    function js_processar() {

        const table = document.getElementById("TabDbLov");
        const checkboxes = table.querySelectorAll(".checkbox");

        let selectedRowsData = [];

        for (let i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                let rowData = {};
                rowData["codigo"] = checkboxes[i].parentNode.nextSibling.textContent.replace(/\s/g, "");
                rowData["evento"] = checkboxes[i].parentNode.nextSibling.nextSibling.nextSibling.textContent.replace(/\s/g, "");
                rowData["recibo"] = checkboxes[i].parentNode.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.textContent.replace(/\s/g, "");
                rowData["entrega"] = checkboxes[i].parentNode.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.textContent.replace(/\s/g, "");
                rowData["protocolo"] = checkboxes[i].parentNode.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.textContent.replace(/\s/g, "");
                selectedRowsData.push(rowData);
            }
        }

        if (selectedRowsData.length == 0) {

            alert("Nenhuma linha foi selecionada");
            return false;
        }

        if (parent.document.getElementById('anofolha').length < 4 || parseInt(parent.document.getElementById("mesfolha").value) < 1 || parseInt(parent.document.getElementById("mesfolha").value) > 12) {

        alert("Início Validade inválido.");
        return false;
        }

        if (parent.document.getElementById("cboEmpregador").value == '') {

        alert("Selecione um empregador");
        return false;
        }

        if (parent.document.getElementById("tpAmb").value == '') {

        alert("Selecione um Ambiente de envio");
        return false;
        }

        js_divCarregando('Aguarde, processando arquivos', 'msgBox');
        var oParam = new Object();
        oParam.exec = "excluir";
        oParam.arquivos = ['S3000'];
        oParam.empregador = parent.document.getElementById('cboEmpregador').value;
        oParam.iAnoValidade = parent.document.getElementById('anofolha').value;
        oParam.iMesValidade = parent.document.getElementById('mesfolha').value;
        oParam.tpAmb = parent.document.getElementById('tpAmb').value;
        oParam.modo = parent.document.getElementById('modo').value;
        oParam.dtalteracao = parent.document.getElementById('dt_alteracao').value;
        oParam.indapuracao = parent.document.getElementById("indapuracao").value;
        oParam.tppgto = parent.document.getElementById('tppgto').value;
        oParam.tpevento = parent.document.getElementById('tpevento').value;
        oParam.transDCTFWeb = parent.document.getElementById('transDCTFWeb').value;
        oParam.evtpgtos = parent.document.getElementById('evtpgtos').value;
        oParam.eventosParaExcluir = selectedRowsData;
        console.log(oParam);
        var oAjax = new Ajax.Request("eso4_esocialapi.RPC.php", {
            method: 'post',
            parameters: 'json=' + JSON.stringify(oParam),
            onComplete: js_retornoProcessamento
        });

    }

    function js_retornoProcessamento(oAjax) {

        js_removeObj('msgBox');
        var oRetorno = eval("(" + oAjax.responseText + ")");
        if (oRetorno.iStatus == 1) {
            alert(oRetorno.sMessage.urlDecode());
        } else {
            alert("Houve um erro no processamento! " + oRetorno.sMessage.urlDecode());
            return false;
        }
    }
</script>