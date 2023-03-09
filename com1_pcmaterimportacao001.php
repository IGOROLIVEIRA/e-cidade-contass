<?
/*
* E-cidade Software Publico para Gestao Municipal
* Copyright (C) 2014 DBselller Servicos de Informatica
* www.dbseller.com.br
* e-cidade@dbseller.com.br
*
* Este programa e software livre; voce pode redistribui-lo e/ou
* modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
* publicada pela Free Software Foundation; tanto a versao 2 da
* Licenca como (a seu criterio) qualquer versao mais nova.
*
* Este programa e distribuido na expectativa de ser util, mas SEM
* QUALQUER GARANTIA; sem mesmo a garantia implicita de
* COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
* PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
* detalhes.
*
* Voce deve ter recebido uma copia da Licenca Publica Geral GNU
* junto com este programa; se nao, escreva para a Free Software
* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
* 02111-1307, USA.
*
* Copia da licenca no diretorio licenca/licenca_en.txt
* licenca/licenca_pt.txt
*/

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("libs/db_utils.php");
include("libs/PHPExcel/Classes/PHPExcel.php");
include("classes/db_pcmater_classe.php");
include("classes/db_pcmaterele_classe.php");
include("classes/db_condataconf_classe.php");

$clcondataconf = new cl_condataconf;
db_postmemory($HTTP_POST_VARS);


?>
<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <style>
        .itens {
            height: 300px;
            width: 90%;
            overflow-y: scroll;
        }
    </style>
</head>
<?
db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
db_app::load("scripts.js, prototype.js, widgets/windowAux.widget.js,strings.js,windowAux.widget.js");
db_app::load("widgets/dbtextField.widget.js, dbViewCadEndereco.classe.js");
db_app::load("dbmessageBoard.widget.js, dbautocomplete.widget.js,dbcomboBox.widget.js, datagrid.widget.js");
db_app::load("estilos.css,grid.style.css");


?>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
        <tr>
            <td bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
        <tr>
            <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
                <center>
                    <?
                    include("forms/db_frmpcmaterimportacao.php");
                    ?>
                </center>
            </td>
        </tr>
    </table>
</body>

</html>
<?
if (isset($incluir) || isset($alterar)) {
    if (isset($alterar)) {
        $erro_msg = str_replace("Inclusao", "Alteracao", $erro_msg);
        $erro_msg = str_replace("EXclusão", "Alteracao", $erro_msg);
    }
    if ($sqlerro == true) {
        $erro_msg = str_replace("\n", "\\n", $erro_msg);
        db_msgbox($erro_msg);
    } else {
    }
}
?>