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
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/JSON.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_utils.php");
require_once("classes/db_empautitem_classe.php");
require_once("classes/db_pcmater_classe.php");
require_once("classes/db_pcmaterele_classe.php");
require_once("classes/db_orcparametro_classe.php");
require_once("classes/db_orcelemento_classe.php");
require_once("classes/db_matunid_classe.php");
require_once("classes/db_solicitemunid_classe.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_pctabelaitem_classe.php");

db_postmemory($HTTP_POST_VARS);

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

//solicitemunid
$clsolicitemunid     = new cl_solicitemunid;
$clmatunid           = new cl_matunid;

$clempautitem = new cl_empautitem;
$clpcmater = new cl_pcmater;
$clpcmaterele = new cl_pcmaterele;
$clorcparametro = new cl_orcparametro;
$clorcelemento = new cl_orcelemento;
$db_opcao = 1;
$db_botao = true;

$result_elemento = db_query("SELECT DISTINCT pc07_codele,
                                             o56_descr,
                                             z01_numcgm
                             FROM liclicitem
                             LEFT JOIN pcprocitem ON liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem
                             LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
                             LEFT JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
                             LEFT JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
                             LEFT JOIN db_depart ON db_depart.coddepto = solicita.pc10_depto
                             LEFT JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
                             LEFT JOIN cflicita ON cflicita.l03_codigo = liclicita.l20_codtipocom
                             LEFT JOIN pctipocompra ON pctipocompra.pc50_codcom = cflicita.l03_codcom
                             LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
                             LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
                             LEFT JOIN pcorcamitemlic ON l21_codigo = pc26_liclicitem
                             LEFT JOIN pcorcamval ON pc26_orcamitem = pc23_orcamitem
                             LEFT JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
                             LEFT JOIN cgm ON z01_numcgm = pc21_numcgm
                             LEFT JOIN pcorcamjulg ON pcorcamval.pc23_orcamitem = pcorcamjulg.pc24_orcamitem
                             AND pcorcamval.pc23_orcamforne = pcorcamjulg.pc24_orcamforne
                             LEFT JOIN db_usuarios ON pcproc.pc80_usuario = db_usuarios.id_usuario
                             LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
                             LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
                             LEFT JOIN pcmaterele ON pcmaterele.pc07_codmater = pcmater.pc01_codmater
                             LEFT JOIN orcelemento ON orcelemento.o56_codele = pcmaterele.pc07_codele
                             AND orcelemento.o56_anousu = 2021
                             WHERE l20_codigo =
                                     (SELECT e54_codlicitacao
                                      FROM empautoriza
                                      WHERE e54_autori = $e55_autori )
                                 AND pc24_pontuacao = 1");

$result = $clempautitem->sql_record($clempautitem->sql_query($e55_autori, $e55_sequen));

db_fieldsmemory($result, 0);

?>
<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
            <center>
                <? include("forms/db_frmcredenciamentoitem.php"); ?>
            </center>
        </td>
    </tr>
</table>
</body>

</html>
