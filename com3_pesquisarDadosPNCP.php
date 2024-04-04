<?php
require_once("dbforms/db_funcoes.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
$oGet                = db_utils::postMemory($_GET);

$sqlPNCP = "SELECT 3 AS tipoInstrumentoConvocatorioId,
                       pc80_modalidadecontratacao,
                       l213_dtlancamento,
                       db_usuarios.nome,
                       pc80_orcsigiloso,
                       5 AS mododisputaid,
                       pc80_criteriojulgamento,
                       pcproc.pc80_data,
                       l212_lei
                FROM pcproc
                left JOIN liccontrolepncp ON l213_processodecompras = pc80_codproc
                left join amparolegal on l212_codigo = pc80_amparolegal
                left join db_usuarios on id_usuario = l213_usuario
                WHERE pc80_codproc = $iProcesso
";
$rsResultDados =  db_query($sqlPNCP);

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
                <table style="border: 1px solid black">
                    <tr>
                        <td>
                            <strong>Tipo de Instrumento Convocatorio:</strong>
                        </td>
                        <td>
                            teste
                        </td>
                        <td>
                            <strong>Usuário:</strong>
                        </td>
                        <td>
                            mario junior
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Modalidade de Contratação:</strong>
                        </td>
                        <td>
                            teste2
                        </td>
                        <td>
                            <strong>Modo disputa:</strong>
                        </td>
                        <td>
                            mododisputateste
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Data de lançamento:</strong>
                        </td>
                        <td>
                            teste3
                        </td>
                        <td>
                            <strong>Critério de Julgamento:</strong>
                        </td>
                        <td>
                            criterio de julgamento
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Orçamento Sigiloso:</strong>
                        </td>
                        <td>
                            orcamento testeorcamento testeorcamento testeorcamento teste
                        </td>
                        <td>
                            <strong>Data:</strong>
                        </td>
                        <td>
                            data do processo
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Lei:</strong>
                        </td>
                        <td>
                            l212_lei
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
    </form>
</center>
</body>
</html>
