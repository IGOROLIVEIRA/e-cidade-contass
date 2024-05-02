<?php
require_once("dbforms/db_funcoes.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
$oGet                = db_utils::postMemory($_GET);

$sqlPNCP = "SELECT     pc80_modalidadecontratacao,
                       l213_dtlancamento,
                       db_usuarios.nome,
                       pc80_orcsigiloso,
                       case
                           when pc80_criteriojulgamento = 1 then 'Menor preço'
                           when pc80_criteriojulgamento = 2 then 'Maior Desconto'
                           when pc80_criteriojulgamento = 5 then 'Maior Lance'
                           when pc80_criteriojulgamento = 7 then 'Não se Aplica'
                           end as pc80_criteriojulgamento,
                       pcproc.pc80_data,
                       l212_lei,
                       pc80_dispvalor
                FROM pcproc
                left JOIN liccontrolepncp ON l213_processodecompras = pc80_codproc
                left join amparolegal on l212_codigo = pc80_amparolegal
                left join db_usuarios on id_usuario = l213_usuario
                WHERE pc80_codproc = $iProcesso
";
$rsResultDados =  db_query($sqlPNCP);
$oDadosPNCP = db_utils::fieldsMemory($rsResultDados, 0);

if ($oDadosPNCP->pc80_modalidadecontratacao == "9") {
    $modalidade = "INEXIGIBILIDADE";
}

if ($oDadosPNCP->pc80_modalidadecontratacao == "8") {
    $modalidade = "DISPENSA SEM DISPUTA";
}

$pc80_data = implode('/', array_reverse(explode('-', $oDadosPNCP->pc80_data)));

?>
<html>

<head>
    <title>Contass Consultoria Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <style>
        .background {
            background-color: #FFFFFF;
        }
    </style>
</head>

<body bgcolor="#cccccc" onload="">
    <center>
        <form name="form1" method="post">
            <div style="display: table;">
                <fieldset>
                    <legend><b>Dados PNCP:</b></legend>
                    <table>
                        <tr>
                            <td>
                                <strong>Tipo de Instrumento Convocatorio:</strong>
                            </td>
                            <td class="background">
                                <?php if ($oDadosPNCP->pc80_dispvalor == 't') echo 'Ato que autoriza a Contratação Direta'; ?>
                            </td>
                            <td>
                                <strong>Usuário:</strong>
                            </td>
                            <td class="background">
                                <?= $oDadosPNCP->nome ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Modalidade de Contratação:</strong>
                            </td>
                            <td class="background">
                                <?= $modalidade ?>
                            </td>
                            <td>
                                <strong>Modo disputa:</strong>
                            </td>
                            <td class="background">
                                <?= $oDadosPNCP->pc80_dispvalor == 't' ? 'Não se aplica' : ''; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Data de lançamento:</strong>
                            </td>
                            <td class="background">
                                <?= $oDadosPNCP->l213_dtlancamento ?>
                            </td>
                            <td>
                                <strong>Critério de Julgamento:</strong>
                            </td>
                            <td class="background">
                                <?= $oDadosPNCP->pc80_criteriojulgamento ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Orçamento Sigiloso:</strong>
                            </td>
                            <?php if ($oDadosPNCP->pc80_dispvalor == 't') { ?>
                                <td class="background">
                                    <?= $oDadosPNCP->pc80_orcsigiloso == 't' ? 'Sim' : 'Não' ?>
                                </td>
                            <?php } else { ?>
                                <td class="background"></td>
                            <?php } ?>
                            <td>
                                <strong>Data:</strong>
                            </td>
                            <td class="background">
                                <?= $oDadosPNCP->pc80_dispvalor == 't' ? $pc80_data : '' ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Lei:</strong>
                            </td>
                            <td style="width: 300px" class="background">
                                <?= $oDadosPNCP->l212_lei ?>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </div>
        </form>
    </center>
</body>
</html>