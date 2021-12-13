<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
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
require_once("classes/db_solicita_classe.php");
db_postmemory($HTTP_POST_VARS);

$clsolicita = new cl_solicita;
$clrotulo   = new rotulocampo;
$clsolicita->rotulo->label();
$clrotulo->label("l20_codigo");
$clrotulo->label("l20_numero");

?>

<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>

    <script>
        function js_emite() {

            var codigo = document.form1.l20_codigo.value;
            var separador = document.form1.separador.value;
            var delimitador = document.form1.delimitador.value;

            var sQuery = 'l20_codigo=' + codigo;
            sQuery += '&delimitador=' + delimitador;
            sQuery += '&extenssao=' + separador;

            if (codigo == '' || codigo == null) {

                alert("Selecione uma Licitação.");
                return false;
            }

            jan = window.open('con1_exportaprocessos002.php?' + sQuery, '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
            jan.moveTo(0, 0);
            document.form1.l20_codigo.value = '';

        }
    </script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
    <center>
        <form name="form1" method="post" action="">
            <fieldset style="margin-top: 50px; width: 400px;">

                <table align="center" border='0'>
                    <tr>
                        <td align="right" nowrap title="<?= $Tl20_codigo ?>">
                            <b>
                                <?
                                db_ancora('Licitação :', "js_pesquisa_liclicita(true);", 1);
                                ?>
                            </b>
                        </td>
                        <td align="left" nowrap>
                            <?
                            db_input("l20_codigo", 8, $Il20_codigo, true, "text", 3, "onchange='js_pesquisa_liclicita(false);'");
                            ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <div style="margin-top: 50px; width: 890px;">

                <fieldset style="width: 400px; float:left">
                    <legend><strong>Exportar Itens</strong></legend>
                    <table align="center" border='0'>

                        <tr>
                            <td align="left" nowrap><b>Delimitador de Campos :</b></td>
                            <td align="left" nowrap>
                                <?
                                $aDelimitador = array(
                                    "1" => "ponto-virgula",
                                    "2" => "pipe"
                                );
                                db_select('delimitador', $aDelimitador, true, 1, "");
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" nowrap><b>Extensão do arquivo:</b></td>
                            <td align="left" nowrap>
                                <?
                                $aExtensoes = array(
                                    "1" => "txt",
                                    "2" => "csv",
                                    "3" => "imp"
                                );
                                db_select('extensao', $aExtensoes, true, 1, "");
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <input name="emite2" id="emite2" type="button" value="Processar" onclick="js_emite();">
                            </td>
                        </tr>
                    </table>
                </fieldset>

                <fieldset style="width: 400px; float:right">
                    <legend><strong>Importar Julgamento</strong></legend>
                    <table align="center" border='0'>
                        <tr>
                            <td valign="top">
                                <b>Enviar arquivo: </b>
                            </td>
                            <td valign='top' style="height: 25px;">
                                <?php
                                db_input("uploadfile", 30, 0, true, "file", 1);
                                db_input("namefile", 30, 0, true, "hidden", 1);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" nowrap><b>Delimitador de Campos :</b></td>
                            <td align="left" nowrap>
                                <?
                                $aDelimitador = array(
                                    "1" => "ponto-virgula",
                                    "2" => "pipe"
                                );
                                db_select('delimitador', $aDelimitador, true, 1, "");
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" nowrap><b>Extensão do arquivo:</b></td>
                            <td align="left" nowrap>
                                <?
                                $aExtensoes = array(
                                    "1" => "txt",
                                    "2" => "csv",
                                    "3" => "imp"
                                );
                                db_select('extensao', $aExtensoes, true, 1, "");
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <input name="emite2" id="emite2" type="button" value="Processar" onclick="js_emite();">
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </div>
        </form>
    </center>
</body>

<?
db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
?>

</html>
<script>
    function js_pesquisa_liclicita(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_liclicita', 'func_liclicita.php?funcao_js=parent.js_mostraliclicita1|l20_codigo', 'Pesquisa', true);
        } else {
            if (document.form1.l20_codigo.value != '') {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_liclicita', 'func_liclicita.php?pesquisa_chave=' + document.form1.l20_codigo.value + '&funcao_js=parent.js_mostraliclicita', 'Pesquisa', false);
            } else {
                document.form1.l20_codigo.value = '';
            }
        }
    }

    function js_mostraliclicita(chave, erro) {
        document.form1.l20_codigo.value = chave;
        if (erro == true) {
            document.form1.l20_codigo.value = '';
            document.form1.l20_codigo.focus();
        }
    }

    function js_mostraliclicita1(chave1) {
        document.form1.l20_codigo.value = chave1;
        db_iframe_liclicita.hide();
    }
</script>
