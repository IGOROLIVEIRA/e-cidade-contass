<?php
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_acordoposicaoaditamento_classe.php");
include("classes/db_acordoposicao_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
if ($apostilamento = true) {
    $sql = "SELECT si03_numapostilamento,
       si03_tipoapostila||'-'|| CASE si03_tipoapostila
                                    WHEN 01 THEN 'Variação do valor contratual ou Repactuação de preços previstos no contrato'
                                    WHEN 02 THEN 'Atualizações, compensações ou penalizações'
                                    WHEN 03 THEN 'Empenho de dotações orçamentárias'
                                    WHEN 04 THEN 'Alterações na Razão social do contratado'
                                    WHEN 05 THEN 'Prorrogação do cronograma de execução (impedimento, paralisação ou suspensão)'
                                    When 99 THEN 'Outros'
                                END AS si03_tipoapostila,
                                si03_tipoalteracaoapostila||'-'||CASE si03_tipoalteracaoapostila
                                                                     WHEN 15 THEN 'Acréscimo de valor'
                                                                     WHEN 16 THEN 'Decréscimo de valor'
                                                                     WHEN 17 THEN 'Não houve alteração de valor'
                                                                 END AS si03_tipoalteracaoapostila,
                                                                 si03_descrapostila,
                                                                 si03_valorapostila,
                                                                 si03_dataapostila,
                                                                 si03_tipoalteracaoapostila,
                                                                 pc01_descrmater,
                                                                 ac20_pcmater,
                                                                 ac20_valorunitario,
                                                                 ac20_quantidade,
                                                                 ac26_sequencial,
                                                                 ac20_valortotal, 
                                                                 si03_tipoapostila as tipoapostila
FROM acordo
INNER JOIN acordoposicao ON ac26_acordo = ac16_sequencial
INNER JOIN acordoitem ON ac20_acordoposicao = ac26_sequencial
INNER JOIN pcmater ON pc01_codmater = ac20_pcmater
LEFT JOIN acordoposicaoaditamento ON ac35_acordoposicao = ac26_sequencial
INNER JOIN acordoposicaotipo ON ac27_sequencial = ac26_acordoposicaotipo
INNER JOIN apostilamento ON si03_acordoposicao = ac26_sequencial
WHERE ac26_sequencial = {$ac26_sequencial}";

    //$sqldotacoes = "select ac22_coddot from acordoitemdotacao where ac22_acordoitem in (select ac20_sequencial from acordoitem where ac20_acordoposicao={$ac26_sequencial})";
}

$oResult = db_query($sql);
//die($sql);
$oResult = db_utils::getColectionByRecord($oResult);





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
        #Apostilamento td {
            text-align: center;
        }
    </style>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <center>
        <?php if (isset($ac26_sequencial)) : ?>

            <form action="" method="post" id="form1">

                <fieldset style="width: 95%;">

                    <legend><b>Apostilamento</b></legend>

                    <table style='width: 100%; background: #ffffff;' align="center">
                        <tr>
                            <td width="100%">
                                <table width="100%" id="Apostilamento">
                                    <tr style="background: #ffffff; height: 20px;">
                                        <th style="height: 25px; font-size:14px; background: #ffffff;">Cód. Apostilamento</th>
                                        <th style="height: 25px; font-size:14px; background: #ffffff;">Tipo de Apostila</th>
                                        <th style="height: 25px; font-size:14px; background: #ffffff;">Data Apostila</th>
                                        <th style="height: 25px; font-size:14px; background: #ffffff;">Tipo Alteração Apostila</th>
                                        <th style="height: 25px; font-size:14px; background: #ffffff;">Descrição da Alteração</th>
                                    <tr style="background: #ffffff; height:20px; ">
                                        <td style=""><?php echo $oResult[0]->ac26_sequencial; ?></td>
                                        <td style=""><?php echo $oResult[0]->si03_tipoapostila; ?></td>
                                        <td style=""><?php echo date("d/m/Y", strtotime($oResult[0]->si03_dataapostila)); ?></td>
                                        <td style=""><?php echo $oResult[0]->si03_tipoalteracaoapostila; ?></td>
                                        <td style=""><?php echo $oResult[0]->si03_descrapostila; ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <br>
                <br>
                <fieldset style="width: 75%; margin-bottom: 10px">
                    <legend><b>Itens do Apostilamento</b></legend>
                    <table style='width: 100%; background: #ffffff;' border='0' align="center">
                        <?php if($oResult[0]->tipoapostila!=3){ ?>
                            <tr style="background: #ffffff; height: 20px;">
                                <th style="height: 25px; font-size:14px; background: #ffffff;">Código Item</th>
                                <th style="height: 25px; font-size:14px; background: #ffffff;">Descrição</th>
                                <th style="height: 25px; font-size:14px; background: #ffffff;">Quantidade</th>
                                <th style="height: 25px; font-size:14px; background: #ffffff;">Valor Unitário</th>
                                <th style="height: 25px; font-size:14px; background: #ffffff;">Valor Total</th>
                            </tr>
                        <?php } ?>
                        <tr>
                            <?php $iMaterial = ""; ?>
                            <?php $i = 0; ?>
                            <?php foreach ($oResult as $aResult): ?>
                            <?php if($aResult->ac20_acordoposicao == $oResult[0]->ac20_acordoposicao){
                            if($iMaterial != $aResult->ac20_pcmater){
                            ?>
                            <?php if($i!=0):?>
                            <?php endif; ?>
                        
                        <?php if($oResult[0]->tipoapostila==3){ 
                            $sqlposicaoant = "select max(ac26_sequencial) as ac26_sequencial from acordoposicao  where ac26_acordo=(select ac26_acordo from acordoposicao where ac26_sequencial={$ac26_sequencial}) and ac26_numeroapostilamento < (select ac26_numeroapostilamento from acordoposicao where ac26_sequencial={$ac26_sequencial}) and ac26_numeroaditamento = ''";
                            $rsposicaoant = db_query($sqlposicaoant);
                            $oDadosposicaoant = db_utils::getColectionByRecord($rsposicaoant);

                            $sqldotacoesant = "select ac22_coddot from acordoitemdotacao where ac22_acordoitem = (select ac20_sequencial from acordoitem where ac20_acordoposicao={$oDadosposicaoant[0]->ac26_sequencial} and ac20_pcmater = {$aResult->ac20_pcmater}) order by ac22_coddot";
                            $oResultdotadocoesant = db_query($sqldotacoesant);
                            $oResultdotadocoesant = db_utils::getColectionByRecord($oResultdotadocoesant);
                            
                            $sqldotacoes = "select ac22_coddot from acordoitemdotacao where ac22_acordoitem = (select ac20_sequencial from acordoitem where ac20_acordoposicao={$ac26_sequencial} and ac20_pcmater = {$aResult->ac20_pcmater}) order by ac22_coddot";
                            $oResultdotadocoes = db_query($sqldotacoes);
                            $oResultdotadocoes = db_utils::getColectionByRecord($oResultdotadocoes);
                            
                            
                            $dotacao = array();
                            if(count($oResultdotadocoes)>0){
                                foreach ($oResultdotadocoes as $aResultdotadocoes){
                                    $verifica = 0;
                                    foreach ($oResultdotadocoesant as $aResultdotadocoesant){
                                        if($aResultdotadocoes->ac22_coddot == $aResultdotadocoesant->ac22_coddot){
                                            $verifica = 1;
                                        }
                                    }
                                    if($verifica == 0){
                                        $dotacao[]=$aResultdotadocoes->ac22_coddot;
                                    }
                                } 
                                if(count($dotacao)>0){
                            ?>
                        
                            <tr style="background: #ffffff; height: 20px;">
                                <th style="height: 25px; font-size:14px; background: #ffffff;text-align:left;">Dotação(ões):
                                
                                    <?php
                                    
                                    foreach ($dotacao as $adotacao){
                                        echo " ".$adotacao;
                                    } 
                                    ?>
                                </th>
                            </tr>
                            <tr style="background: #ffffff; height: 20px;">
                                <th style="height: 25px; font-size:14px; background: #ffffff; width: 50%;">Código Item</th>
                                <th style="height: 25px; font-size:14px; background: #ffffff;">Descrição</th>
                            </tr>
                            <?php } ?>
                            <?php } ?>
                            <?php } ?>
                            
                        <?php if($oResult[0]->tipoapostila==3 && count($oResultdotadocoes)>0 && count($dotacao)>0){ ?>
                            <tr>
                            <td colspan="10" style="height:10px; width:100%;"><hr></td>
                        </tr>
                            <tr style="margin-top:5px; background: #e1dede; height:10px;">
                                <td align="center"><?php echo $aResult->ac20_pcmater; ?> </td>
                                <td align="center"><?php echo $aResult->pc01_descrmater; ?> </td>
                            </tr>
                        <?php }else if($oResult[0]->tipoapostila!=3){ ?>
                            <tr>
                            <td colspan="10" style="height:10px; width:100%;"><hr></td>
                        </tr>
                            <tr style="margin-top:5px; background: #e1dede; height:10px;">
                                <td align="center"><?php echo $aResult->ac20_pcmater; ?> </td>
                                <td align="center"><?php echo $aResult->pc01_descrmater; ?> </td>
                                <td align="center"><?php echo $aResult->ac20_quantidade; ?> </td>
                                <td align="center"><?php echo $aResult->ac20_valorunitario; ?> </td>
                                <td align="center"><?php echo $aResult->ac20_valortotal; ?> </td>
                            </tr>
                        <?php } ?>

                        
                        <?php $iMaterial = $aResult->ac20_pcmater; ?>
                        
                        <?php } ?>

                        <?php } ?>
                        <?php $i++; ?>
                        <?php endforeach; ?>

                        
                    </tr>

                    </table>
                </fieldset>
                <table style='width: 20%; background: #ffffff; margin-right:152px' align="right">
                    <?php if ($oResult[0]->tipoapostila != 3) { ?>
                        <tr style="background: #ffffff; height: 10px;">
                            <td style="height: 25px; font-size:14px; background: #ffffff;"><strong>Valor Total Apostilado:</strong></td>
                            <td><? echo "R$" . number_format($aResult->si03_valorapostila, 2, ',', '.') ?></td>
                        </tr>
                    <?php } ?>

                </table>
            </form>
        <?php endif; ?>
</body>

</html>