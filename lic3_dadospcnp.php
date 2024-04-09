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
           WHEN l03_pctipocompratribunal IN (110,
                                             51,
                                             53,
                                             52,
                                             50) THEN 'Edital'
           WHEN l03_pctipocompratribunal = 101 THEN 'Aviso de Contratação Direta'
           WHEN l03_pctipocompratribunal = 100 THEN 'Ato que autoriza a Contratação Direta'
           WHEN l03_pctipocompratribunal IN (102,
                                             103) THEN '4'
       END AS tipoinstrumentoconvocatorioid,
       l03_descr,
       l20_orcsigiloso,
       CASE
           WHEN l20_mododisputa = 1 THEN 'Aberto'
           WHEN l20_mododisputa = 2 THEN 'Fechado'
           WHEN l20_mododisputa = 3 THEN 'Aberto-Fechado'
           WHEN l20_mododisputa = 4 THEN 'Dispensa Com Disputa'
           WHEN l20_mododisputa = 5 THEN 'Não se aplica'
           WHEN l20_mododisputa = 6 THEN 'Fechado-Aberto'
       END AS l20_mododisputa,
       CASE
           WHEN l20_tipliticacao = 1 THEN 'Menor Preço'
           WHEN l20_tipliticacao = 2 THEN 'Maior desconto'
           WHEN l20_tipliticacao = 4 THEN 'Técnica e preço'
           WHEN l20_tipliticacao = 5 THEN 'Maior lance'
           WHEN l20_tipliticacao = 6 THEN 'Maior retorno econômico'
           WHEN l20_tipliticacao = 7 THEN 'Não se aplica'
       END AS l20_tipliticacao,
       l20_dataaberproposta,
       l20_horaaberturaprop,
       l20_dataencproposta,
       l20_horaencerramentoprop,
       l212_lei,
       l20_justificativapncp,
       l213_numerocontrolepncp
FROM liclicita
LEFT JOIN liccontrolepncp ON l213_licitacao = l20_codigo
LEFT JOIN db_usuarios ON id_usuario = l213_usuario
INNER JOIN cflicita ON l03_codigo = l20_codtipocom
INNER JOIN amparolegal ON l212_codigo = l20_amparolegal
WHERE l20_codigo = $l20_codigo";

$rsResultDados =  db_query($sql);
$oDadosPNCP = db_utils::fieldsMemory($rsResultDados,0);

$dataAbertura = implode('/',array_reverse(explode('-',$oDadosPNCP->l20_dataaberproposta))) . " Hora: ".$oDadosPNCP->l20_horaaberturaprop;
$dataEncerramento = implode('/',array_reverse(explode('-',$oDadosPNCP->l20_dataencproposta))) . " Hora: ".$oDadosPNCP->l20_horaencerramentoprop;

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
<style>
    .background{
        background-color: #FFFFFF;
    }
</style>
<body bgcolor="#cccccc" onload="">
<div style="display: table; float:left; margin-left:10%;">
    <fieldset>
        <legend><b>Dados PNCP</b></legend>
        <table>
            <tr>
                <td>
                    <strong>Tipo de Instrumento Convocatorio:</strong>
                </td>
                <td class="background">
                    <?= $oDadosPNCP->tipoinstrumentoconvocatorioid ?>
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
                    <strong>Id Contratação:</strong>
                </td>
                <td class="background">
                    <?=$oDadosPNCP->l213_numerocontrolepncp?>
                </td>
                <td>
                    <strong>Modo disputa:</strong>
                </td>
                <td class="background">
                    <?= $oDadosPNCP->l20_mododisputa ?>
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
                    <strong>Criterio de Julgamento:</strong>
                </td>
                <td class="background">
                    <?=$oDadosPNCP->l20_tipliticacao?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Orçamento Sigiloso:</strong>
                </td>
                <td class="background">
                    <?= $oDadosPNCP->l20_orcsigiloso == 't' ? 'Sim' : 'Não' ?>
                </td>
                <td>
                    <strong>Data Abertura das Propostas:</strong>
                </td>
                <td class="background">
                    <?=$dataAbertura?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Lei:</strong>
                </td>
                <td style="width: 300px" class="background">
                    <?=$oDadosPNCP->l212_lei?>
                </td>
                <td>
                    <strong>Data Encerramento Proposta:</strong>
                </td>
                <td style="width: 300px" class="background">
                    <?=$dataEncerramento?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Justificativa:</strong>
                </td>
                <td>
                    <?=$oDadosPNCP->l20_justificativapncp?>
                </td>
            </tr>
        </table>
    </fieldset>
</div>
</body>

</html>
