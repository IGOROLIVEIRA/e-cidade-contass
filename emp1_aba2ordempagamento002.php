<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2012  DBselller Servicos de Informatica
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
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_pagordem_classe.php");
include("classes/db_empempenho_classe.php");

$clmatordem = new cl_matordem;
$clpagordem   = new cl_pagordem;
$clempempenho = new cl_empempenho;
$clrotulo = new rotulocampo;

$clempempenho->rotulo->label();
$clmatordem->rotulo->label();
$clrotulo->label("e60_codemp");
$clrotulo->label("e60_numemp");
$clrotulo->label("e50_codord");

$clpagordem->rotulo->label("e60_codemp");
$clpagordem->rotulo->label("e60_numemp");
$clpagordem->rotulo->label("e50_codord");


db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS['QUERY_STRING'], $aFiltros);

if (isset($aFiltros['empenho']) && !empty($aFiltros['empenho'])) {
    $empenho = $aFiltros['empenho'];
}

?>

<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#cccccc" onload="pesquisaOrdemPagamento(document.form1.empenho.value)">
<br><br>
<?php
    require_once("forms/db_frmordempagamento.php");
?>

<script type="text/javascript" src="scripts/prototype.js"></script>
<script type="text/javascript" src="scripts/strings.js"></script>
<script>
    function pesquisaOrdemPagamento(empenho) {
        $('e60_codemp').value = empenho;
    }

</script>
</body>
</html>
