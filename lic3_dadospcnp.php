<?php
require_once("dbforms/db_funcoes.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");

$oDaoRotulo    = new rotulocampo;
$oGet          = db_utils::postMemory($_GET);

$sql = "SELECT l20_codigo,
               l213_dtlancamento,
               nome,
               CASE
                   WHEN l03_pctipocompratribunal IN (110,51,53,52,50) THEN 1
                   WHEN l03_pctipocompratribunal = 101 THEN 2
                   WHEN l03_pctipocompratribunal = 100 THEN 3
                   WHEN l03_pctipocompratribunal IN (102,103) THEN 4
               END AS tipoInstrumentoConvocatorioId,
               l03_descr,
               l20_orcsigiloso,
               l20_mododisputa,
               l20_tipliticacao,
               l20_dataaberproposta,
               l20_horaaberturaprop,
               l20_dataencproposta,
               l20_horaencerramentoprop,
               l212_lei,
               l20_justificativapncp
        FROM liclicita
        LEFT JOIN liccontrolepncp ON l213_licitacao = l20_codigo
        LEFT JOIN db_usuarios ON id_usuario = l213_usuario
        inner join cflicita on l03_codigo = l20_codtipocom
        inner join amparolegal on l212_codigo = l20_amparolegal
        WHERE l20_codigo = $l20_codigo";
?>
<html>

<head>
    <title>Contass Consultoria Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <link href="estilos/tab.style.css" rel="stylesheet" type="text/css">

</head>

<body bgcolor="#cccccc" onload="">
<div style="display: table; float:left; margin-left:10%;">
    <fieldset>
        <legend><b>Dados PNCP</b></legend>

        <?
        db_lovrot($sql, 15, "()", "", $sFuncaoJS);
        ?>
    </fieldset>
</div>
</body>

</html>
