<?php
require_once("libs/db_utils.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_acordoposicaoaditamento_classe.php");
include("classes/db_acordoposicao_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$valortotaladitado = 0;
if ($aditamento = true) {
    $sql = "SELECT pc01_codmater,
       pc01_descrmater,
       ac20_sequencial,
       ac20_valorunitario,
       ac20_valortotal,
       ac20_quantidade,
       ac20_valoraditado,
       ac26_acordoposicaotipo,
       ac26_acordoposicaotipo||'-'||ac27_descricao as tipoaditivo,
       ac18_datainicio,
       ac18_datafim,
       ac35_descricaoalteracao,
       ac35_datapublicacao,
       ac35_veiculodivulgacao,
       ac26_sequencial,
       ac20_acordoposicao,
       ac20_pcmater,
       ac20_ordem,
       ac20_quantidadeaditada,
       ac35_dataassinaturatermoaditivo,
       ac20_ordem
FROM acordo
INNER JOIN acordoposicao ON ac26_acordo = ac16_sequencial
INNER JOIN acordovigencia ON ac18_acordoposicao = ac26_sequencial
INNER JOIN acordoitem ON ac20_acordoposicao = ac26_sequencial
INNER JOIN pcmater ON pc01_codmater = ac20_pcmater
INNER JOIN acordoposicaoaditamento ON ac35_acordoposicao = ac26_sequencial
INNER JOIN acordoposicaotipo ON ac27_sequencial = ac26_acordoposicaotipo
WHERE ac26_sequencial = {$ac26_sequencial} order by ac20_ordem";
}
$oResult = db_query($sql);
//die($sql);
$oResult = db_utils::getColectionByRecord($oResult);

$sql = "select ac20_pcmater from acordoitem where ac20_acordoposicao = {$adanterior}";
$itensAditivoAnterior = db_query($sql);
$AditivoAnterior = db_query($sql);
$AditivoAnterior = db_utils::getColectionByRecord($AditivoAnterior);
$tamanho = count($AditivoAnterior);
$tamanho - 1;

$itensContrato;
$itens;



if ($adanterior == 0) {
    $sql = "select * from acordoposicao where ac26_acordo = {$ac16_sequencial} and ac26_acordoposicaotipo = 1";
    $itensContrato = db_query($sql);
    $itensContrato = db_utils::fieldsMemory($itensContrato, 0);
    $sql = "select * from acordoitem where ac20_acordoposicao = {$itensContrato->ac26_sequencial}";
    $itensContrato = db_query($sql);
    $itens = db_query($sql);
    $itens = db_utils::getColectionByRecord($itens);
    $tamanho = count($itens);
    $tamanho - 1;
}

?>

<html>

<head>
    <title>Contass Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?
    db_app::load("scripts.js, strings.js, datagrid.widget.js, windowAux.widget.js");
    db_app::load("dbmessageBoard.widget.js, prototype.js, contratos.classe.js");
    db_app::load("estilos.css, grid.style.css");
    ?>
    <style type="text/css">
        #Aditamento td {
            text-align: center;
        }
    </style>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <center>
        <?php if (isset($ac26_sequencial)) : ?>

            <form action="" method="post" id="form1">

                <fieldset style="width: 95%;">

                    <legend><b>Aditamento</b></legend>

                    <table style='width: 100%; background: #ffffff;' align="center">
                        <tr>
                            <td width="100%">
                                <table width="100%" id="Aditamento">
                                    <tr style="background: #ffffff; height: 20px;">
                                        <th style="height: 25px; font-size:14px; background: #ffffff;">Cód. Aditamento</th>
                                        <th style="height: 25px; font-size:14px; background: #ffffff;">Tipo</th>
                                        <th style="height: 25px; font-size:14px; background: #ffffff;">Data Assinatura</th>
                                        <th style="height: 25px; font-size:14px; background: #ffffff;">Data Publicação</th>
                                        <th style="height: 25px; font-size:14px; background: #ffffff;">Veiculo de Divulgação</th>
                                        <th style="height: 25px; font-size:14px; background: #ffffff;">Descrição da Alteração</th>
                                        <th style="height: 25px; font-size:14px; background: #ffffff;">Vigência</th>
                                    </tr>
                                    <tr style="background: #ffffff; height:20px; ">
                                        <td style=""><?php echo $oResult[0]->ac26_sequencial; ?></td>
                                        <td style=""><?php echo $oResult[0]->tipoaditivo; ?></td>
                                        <td style=""><?php echo date('d/m/Y', strtotime($oResult[0]->ac35_dataassinaturatermoaditivo)); ?></td>
                                        <td style=""><?php echo date('d/m/Y', strtotime($oResult[0]->ac35_datapublicacao)); ?></td>
                                        <td style=""><?php echo $oResult[0]->ac35_veiculodivulgacao; ?></td>
                                        <td style=""><?php echo $oResult[0]->ac35_descricaoalteracao; ?></td>
                                        <td style=""><?php echo date("d/m/Y", strtotime($oResult[0]->ac18_datainicio)) . " á " . date("d/m/Y", strtotime($oResult[0]->ac18_datafim)); ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <br>
                <br>
                <fieldset style="width: 75%; margin-bottom: 10px">
                    <legend><b>Itens do Aditamento</b></legend>
                    <table style='width: 100%; background: #ffffff;' border='0' align="center">
                        <tr style="background: #ffffff; height: 20px;">
                            <th style="height: 25px; font-size:14px; background: #ffffff;">Código Item</th>
                            <th style="height: 25px; font-size:14px; background: #ffffff;">Descrição</th>
                            <th style="height: 25px; font-size:14px; background: #ffffff;">Quantidade</th>
                            <th style="height: 25px; font-size:14px; background: #ffffff;">Valor Unitário</th>
                            <th style="height: 25px; font-size:14px; background: #ffffff;">Valor Total</th>
                            <th style="height: 25px; font-size:14px; background: #ffffff;">Quantidade Aditada</th>
                            <th style="height: 25px; font-size:14px; background: #ffffff;">Valor Aditado</th>
                        </tr>
                        <tr>
                            <?php $iMaterial = ""; ?>
                            <?php $i = 0; ?>
                            <?php foreach ($oResult as $aResult) : ?>
                                <?php if ($aResult->ac20_acordoposicao == $oResult[0]->ac20_acordoposicao) {
                                    if ($iMaterial != $aResult->ac20_pcmater) {
                                        $valortotaladitado += $aResult->ac20_valoraditado;
                                ?>
                                        <?php if ($i != 0) : ?>
                                        <?php endif; ?>
                        <tr>
                            <td colspan="10" style="height:10px; width:100%;">
                                <hr>
                            </td>
                        </tr>


                        <tr style="margin-top:5px; background:  <?php

                                                                $item = false;

                                                                if ($adanterior == 0) {

                                                                    for ($i = 0; $i <= $tamanho; $i++) {

                                                                        $obj = db_utils::fieldsMemory($itensContrato, $i);

                                                                        if (strcmp($obj->ac20_pcmater, $aResult->ac20_pcmater) == 0) {

                                                                            $item = true;
                                                                        }
                                                                    }
                                                                } else {

                                                                    for ($i = 0; $i <= $tamanho; $i++) {

                                                                        $obj = db_utils::fieldsMemory($itensAditivoAnterior, $i);

                                                                        if (strcmp($obj->ac20_pcmater, $aResult->ac20_pcmater) == 0) {

                                                                            $item = true;
                                                                        }
                                                                    }
                                                                }


                                                                ?>
                                                           <?php if ($item == false && $tamanho != 0) {
                                                                echo "#7CFC00";
                                                            } else {
                                                                echo "#e1dede";
                                                            } ?> ; height:10px;">
                            <td align="center"><?php echo $aResult->ac20_pcmater; ?> </td>
                            <td><?php echo $aResult->pc01_descrmater; ?> </td>
                            <td><?php echo $aResult->ac20_quantidade; ?> </td>
                            <td align="center"><?php echo $aResult->ac20_valorunitario; ?> </td>
                            <td align="center"><?php echo $aResult->ac20_valortotal; ?> </td>
                            <td align="center"><?php echo $aResult->ac20_quantidadeaditada; ?> </td>
                            <td align="center"><?php echo $aResult->ac20_valoraditado; ?> </td>
                        </tr>

                        <?php $iMaterial = $aResult->ac20_pcmater; ?>

                    <?php } ?>

                <?php } ?>
                <?php $i++; ?>
            <?php endforeach; ?>

        <?php endif; ?>
        </tr>

                    </table>
                </fieldset>

                <table style='width: 20%; background: #ffffff; margin-right:152px' align="right">
                    <tr style="background: #ffffff; height: 10px;">
                        <td style="height: 25px; font-size:14px; background: #ffffff;"><strong>Valor Total Aditado:</strong></td>
                        <td><? echo "R$" . number_format($valortotaladitado, 2, ',', '.') ?></td>
                    </tr>
                </table>


            </form>

            <div style="margin-left: -20%; <?php if (strcmp($oResult[0]->tipoaditivo, "12-Alteração de Projeto/Especificação") != 0) {
                                                echo "display: none;";
                                            } ?>">
                <fieldset style="width: 20%; margin-bottom: 10px; margin-right:152px">
                    <legend><b>Legenda</b></legend>
                    <table style='width: 100%; ' align="right">
                        <tr>
                            <td style="height: 25px; font-size:14px; background: #7CFC00;"><strong>Itens incluídos</strong></td>
                        </tr>
                    </table>
                </fieldset>
            </div>

</body>

</html>