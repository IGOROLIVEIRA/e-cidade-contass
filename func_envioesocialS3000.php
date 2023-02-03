<?php

/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_esocialenvio_classe.php");
require_once("classes/db_esocialrecibo_classe.php");
include("dbforms/db_classesgenericas.php");
$clcaracter         = new cl_caracter;
$cliframe_seleciona = new cl_iframe_seleciona;
$clcaracter->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("rh213_protocolo");

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

                    //if (isset($situacao) && !empty($situacao)) {
                    $dbwhere .= " and rh213_situacao = 2";
                    //}

                    $sql = $clesocialenvio->sql_query(null, $campos, "rh213_sequencial desc", "{$dbwhere}");
                    //db_lovrot($sql, 15, "()", "", "");
                    db_lovrot($sql, 20, "()", "", $funcao_js, "", "NoMe", array(), false);
                    // $cliframe_seleciona->chaves  = "rh213_sequencial";
                    // $cliframe_seleciona->campos  = $campos;
                    // $cliframe_seleciona->legenda       = "Dados";
                    // $cliframe_seleciona->sql     = $sql;
                    // //$cliframe_seleciona->sql_marca = $sqlmarca;
                    // $cliframe_seleciona->iframe_height ="600";
                    // $cliframe_seleciona->iframe_width  ="800";
                    // //$cliframe_seleciona->dbscript      = "";
                    // $cliframe_seleciona->iframe_nome ="dados";
                    // $cliframe_seleciona->marcador      = true;
                    // $cliframe_seleciona->iframe_seleciona(1);
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

        let result = confirm('Atenção: Confirmar envio das informações do mês ' + parent.parent.bstatus.document.getElementById('dtatual').innerHTML.substr(3, 7) + ' para o eSocial?');

        if (!result) {
            return false;
        }


        const table = document.getElementById("TabDbLov");
        const checkboxes = table.querySelectorAll(".checkbox");


        let selectedRowsData = [];

        for (let i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                let rowData = {};
                rowData[i] = checkboxes[i].parentNode.nextSibling.textContent;
                selectedRowsData.push(rowData);
            }
        }
        console.log(selectedRowsData);
        return selectedRowsData;



        // if ($F('anofolha').length < 4 || parseInt($("mesfolha").value) < 1 || parseInt($("mesfolha").value) > 12) {

        //     alert("Início Validade inválido.");
        //     return false;
        // }

        // if ($("cboEmpregador").value == '') {

        //     alert("Selecione um empregador");
        //     return false;
        // }

        // if ($("tpAmb").value == '') {

        //     alert("Selecione um Ambiente de envio");
        //     return false;
        // }

        // let sSelectedFase = getRadioOption();
        // let aArquivosSelecionados = new Array();
        // let aArquivos = $$(`#${sSelectedFase} :input[type='checkbox']`);
        // aArquivos.each(function(oElemento, iIndice) {

        //     if (oElemento.checked) {
        //         aArquivosSelecionados.push(oElemento.value.toUpperCase());
        //     }
        // });
        // if (aArquivosSelecionados.length == 0) {

        //     alert("Nenhum arquivo foi selecionado para ser gerado");
        //     return false;
        // }

        js_divCarregando('Aguarde, processando arquivos', 'msgBox');
        var oParam = new Object();
        oParam.exec = "transmitir";
        oParam.arquivos = aArquivosSelecionados;
        oParam.empregador = $("cboEmpregador").value;
        oParam.iAnoValidade = $("anofolha").value;
        oParam.iMesValidade = $("mesfolha").value;
        oParam.tpAmb = $("tpAmb").value;
        oParam.modo = $("modo").value;
        oParam.dtalteracao = $("dt_alteracao").value;
        oParam.indapuracao = $("indapuracao").value;
        oParam.tppgto = $("tppgto").value;
        oParam.tpevento = $("tpevento").value;
        var oAjax = new Ajax.Request("eso4_esocialapi.RPC.php", {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParam),
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