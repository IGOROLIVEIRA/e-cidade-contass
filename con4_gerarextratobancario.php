<?php
/**
 *
 * @author I
 * @revision $Author: dbrobson $
 * @version $Revision: 1.10 $
 */
require("libs/db_stdlib.php");
require("libs/db_utils.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

$clrotulo = new rotulocampo;
$clrotulo->label("o124_descricao");
$clrotulo->label("o124_sequencial");
$clrotulo->label("o15_descr");
$clrotulo->label("o15_codigo");
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript"
            src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript"
            src="scripts/strings.js"></script>
    <script language="JavaScript" type="text/javascript"
            src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript"
            src="scripts/widgets/dbmessageBoard.widget.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#cccccc" style="margin-top: 25px;">
<center>


    <form name="form1" method="post" action="">
        <div style="display: table">
            <fieldset>
                <legend>
                    <b>Gerar Extrato Bancário</b>
                </legend>
                <table style='empty-cells: show; border-collapse: collapse;'>
                    <tr>
                        <td colspan="4">
                            <fieldset>
                                <table>
                                    <tr>
                                        <td>Ano Referência: </td>
                                        <td>
                                            <input type="text" size="5" readonly disabled value="<?php echo db_getsession("DB_anousu") ?>" id="AnoReferencia" />
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td>Arquivos Gerados</td>
                    </tr>
                    <tr>
                        <td style="border: 2px groove white;" valign="top">
                            <div id='retorno'
                                 style="width: 200px; height: 250px; overflow: scroll;">
                            </div>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <div style="text-align: center;">
                <input type="button" id="btnProcessar" value="Processar"
                       onclick="js_processar();" />
            </div>
        </div>
    </form>

</center>
</body>
</html>
<? db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit")); ?>
<script type="text/javascript">
    function js_processar() {
        js_divCarregando('Aguarde, processando arquivos','msgBox');
        var oParam           = new Object();
        oParam.exec          = "processarExtratoBancario";
        var oAjax = new Ajax.Request("con4_processarpad.RPC.php",
            {
                method:'post',
                parameters:'json='+Object.toJSON(oParam),
                onComplete:js_retornoProcessamento
            }
        );

    }

    function js_retornoProcessamento(oAjax) {

        js_removeObj('msgBox');
        $('debug').innerHTML = oAjax.responseText;
        var oRetorno = eval("("+oAjax.responseText+")");
        if (oRetorno.status == 1) {

            alert("Processo concluído com sucesso!");
            var sRetorno = "<b>Arquivos Gerados:</b><br>";
            for (var i = 0; i < oRetorno.itens.length; i++) {

                with (oRetorno.itens[i]) {

                    sRetorno += "<a target='_blank' href='db_download.php?arquivo="+caminho+"'>"+nome+"</a><br>";
                }
            }

            $('retorno').innerHTML = sRetorno;
        } else {

            $('retorno').innerHTML = '';
            alert("Houve um erro no processamento!" + oRetorno.message.urlDecode());
            //alert(oRetorno.message.urlDecode());
            return false;
        }
    }
</script>
<div id='debug'>
</div>
