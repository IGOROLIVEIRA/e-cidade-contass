<?php
require_once("dbforms/db_funcoes.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
$oGet                = db_utils::postMemory($_GET);
$sqlPNPC = "SELECT 3 AS tipoInstrumentoConvocatorioId,
       pc80_modalidadecontratacao,
       l213_dtlancamento,
       db_usuarios.nome,
       pc80_orcsigiloso,
       5 AS modoDisputaId,
       pc80_criteriojulgamento,
       pcproc.pc80_data as dataAberturaProposta,
       pcproc.pc80_data as dataEncerramentoProposta,
       l212_lei as amparoLegalId
FROM pcproc
INNER JOIN liccontrolepncp ON l213_processodecompras = pc80_codproc
inner join amparolegal on l212_codigo = pc80_amparolegal
inner join db_usuarios on id_usuario = l213_usuario
WHERE pc80_codproc = $iProcesso
";
?>
<html>
<head>
    <title>Contass Consultoria Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#cccccc" onload="">
<center>
    <form name="form1" method="post">
        <div style="display: table;">
            <fieldset>
                <legend><b>Dados PNCP:</b></legend>
                <?
                db_lovrot($sqlPNPC, 15);
                ?>
            </fieldset>
        </div>
    </form>
</center>
</body>
</html>
