<?
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
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
include_once("libs/db_sessoes.php");
include_once("libs/db_usuariosonline.php");
include_once("dbforms/db_funcoes.php");
include_once("libs/db_liborcamento.php");
require_once("model/relatorioContabil.model.php");

$oGet       = db_utils::postMemory($_GET);
db_postmemory($HTTP_POST_VARS);

$oRelatorio = new relatorioContabil($oGet->c83_codrel);
$clrotulo   = new rotulocampo;
$clrotulo->label('DBtxt21');
$clrotulo->label('DBtxt22');

?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
    <style>
        #o116_periodo, #emissao {
            width: 100%;
        }
    </style>
</head>
<body leftmargin="0" style="margin: 60px"; marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
<?php //db_menu(); ?>
<form name="form1" method="post" action="" >
    <table align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td class="table_header">
                Anexo V - Dem. da Dis. de Caixa e dos RP
            </td>
        </tr>
        <tr>
            <td>
                <fieldset>
                    <table align="center" border="0">
                        <tr>
                            <td align="center" colspan="2">
                                <? db_selinstit('', 300, 100); ?>
                            </td>
                        </tr>

                    </table>
                </fieldset>
            </td>
        </tr>
        <tr>&nbsp;</tr>
        <tr>
            <td align="center" colspan="2">
                <input  name="emite" id="emite" type="button" value="Imprimir" onclick="js_emite()">
            </td>
        </tr>
    </table>
</form>
</body>
<script>

    function js_emite(sFonte) {

        var oDocument     = document.form1;
        // var iPeriodo      = $('o116_periodo').value;
        var iSelInstit    = oDocument.db_selinstit.value;
        // var sDataIni      = '';
        // var sDataFim      = '';
        var iFormaEmissao = 1;
        if ($('emissao')) {
            var iFormaEmissao = $('emissao').value;
        }
        var sNomeArquivo  = 'con2_relatoriodemodespcaixarp.php';
        var sUrl          = sNomeArquivo+'?db_selinstit='+iSelInstit;

        if (iSelInstit == 0) {

            alert('Você não escolheu nenhuma instituição. Verifique!');
            return false;
        }

        var jan      = window.open(sUrl,
            '',
            'width='+(screen.availWidth-5)+
            ', height='+(screen.availHeight-40)+
            ', scrollbars=1, location=0');
        jan.moveTo(0,0);
    }
</script>
</html>