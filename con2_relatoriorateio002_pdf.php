<?php

require_once("model/relatorios/Relatorio.php");

$mPDF = new Relatorio('', 'A4-L');

foreach ($oInfoRelatorio->aHeader as $key => $value) {
    $mPDF->addInfo($value, $key);
}

$sSql  = "SELECT db21_codigomunicipoestado,cgc FROM db_config where codigo = ".db_getsession("DB_instit");
$rsInst = db_query($sSql);
$sInstCgc  = str_pad(db_utils::fieldsMemory($rsInst, 0)->cgc, 5, "0", STR_PAD_LEFT);
//Cimva
$aCgcExecaoRelFinanceiro = $arrayName = array('21466841000169');

//$aCgcExecaoRelFinanceiro = $arrayName = array('');

//db_criatabela($rsInst);exit;

$aTotal = array(
    'empenhado' => array(
        'no_mes'    => 0,
        'ate_o_mes' => 0
    ),
    'emp_anualdo' => array(
        'no_mes'    => 0,
        'ate_o_mes' => 0
    ),
    'liquidado' => array(
        'no_mes'    => 0,
        'ate_o_mes' => 0
    ),
    'liq_anulado' => array(
        'no_mes'    => 0,
        'ate_o_mes' => 0
    ),
    'pago' => array(
        'no_mes'    => 0,
        'ate_o_mes' => 0
    ),
    'pago_anulado' => array(
        'no_mes'    => 0,
        'ate_o_mes' => 0
    )
);


ob_start();
?>

<!DOCTYPE html>

<html>
<head>
    <style type="text/css">
        .ritz .waffle a { color: inherit; }
        .ritz .waffle .s0 { border-bottom: 1px SOLID #000000; border-right: 1px SOLID #000000; background-color: #ffffff; text-align: center; font-weight: bold; color: #000000; font-family: 'Arial'; font-size: 10pt; vertical-align: bottom; white-space: nowrap; padding: 2px 3px 2px 3px; }
        .ritz .waffle .s5 { border-bottom: 1px SOLID #000000; border-right: 1px SOLID #000000; background-color: #ffffff; text-align: right; font-weight: bold; color: #000000; font-family: 'Arial'; font-size: 10pt; vertical-align: bottom; white-space: nowrap; padding: 2px 3px 2px 3px; }
        .ritz .waffle .s2 { border-left: none; border-right: none; background-color: #ffffff; text-align: center; font-weight: bold; color: #000000; font-family: 'Arial'; font-size: 10pt; vertical-align: bottom; white-space: nowrap; padding: 2px 3px 2px 3px; }
        .ritz .waffle .s1 { border-right: none; background-color: #ffffff; text-align: center; font-weight: bold; color: #000000; font-family: 'Arial'; font-size: 10pt; vertical-align: bottom; white-space: nowrap; padding: 2px 3px 2px 3px; }
        .ritz .waffle .s3 { border-left: none; background-color: #ffffff; text-align: center; font-weight: bold; color: #000000; font-family: 'Arial'; font-size: 10pt; vertical-align: bottom; white-space: nowrap; padding: 2px 3px 2px 3px; }
        .ritz .waffle .s4 { border-bottom: 1px SOLID #000000; border-right: 1px SOLID #000000; text-align: right; color: #000000; font-family: 'Arial'; font-size: 10pt; vertical-align: bottom; white-space: nowrap; padding: 2px 3px 2px 3px; }

        .ritz .waffle .borda1 {
            border-bottom: 1px SOLID #000000;
        }
        .ritz .waffle .borda2 {
            border-right: 1px SOLID #000000;
            border-bottom: 1px SOLID #000000;
        }
        .ritz .waffle .borda3 {
            border-left: 1px SOLID #000000;
        }

        .ritz .waffle .bg_1 {
            background-color: #f3f3f3;
        }
        .fstb {
            font-size: 6px;
        }
    </style>

    <title>Relatório de Rateio - <?= date("d-m-Y H:i:s") ?></title>
</head>

<body>
<div class="ritz grid-container" dir="ltr">
    <table class="waffle" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th class="borda1" style="width:70px">&nbsp;</th>
            <th class="borda1" style="width:78px">&nbsp;</th>
            <th class="borda1" style="width:66px">&nbsp;</th>
            <th class="borda1" style="width:91px">&nbsp;</th>
            <th class="borda1" style="width:42px">&nbsp;</th>
            <th class="borda1" style="width:100px">&nbsp;</th>
            <th class="borda1" style="width:100px">&nbsp;</th>
            <th class="borda1" style="width:100px">&nbsp;</th>
            <th class="borda1" style="width:100px">&nbsp;</th>
            <th class="borda1" style="width:100px">&nbsp;</th>
            <th class="borda1" style="width:100px">&nbsp;</th>
            <th class="borda1" style="width:100px">&nbsp;</th>
            <th class="borda1" style="width:100px">&nbsp;</th>
            <th class="borda1" style="width:100px">&nbsp;</th>
            <th class="borda1" style="width:100px">&nbsp;</th>
            <th class="borda1" style="width:100px">&nbsp;</th>
            <th class="borda1" style="width:100px">&nbsp;</th>
        </tr>
        </thead>

        <tbody>
        <tr style='height:20px;'>
            <td class="s0 borda3" colspan="5">Classifica&ccedil;&atilde;o</td>
            <td class="s0" colspan="2">Empenhado</td>
            <td class="s0" colspan="2">Emp. Anualdo</td>
            <td class="s0" colspan="2">Liquidado</td>
            <td class="s0" colspan="2">Liq. Anulado</td>
            <td class="s0" colspan="2">Pago</td>
            <td class="s0" colspan="2">Pago Anulado</td>
        </tr>

        <tr style='height:20px;'>
            <td class="s1 borda2 borda3">Fun&ccedil;&atilde;o</td>
            <td class="s2 borda2">SubFun&ccedil;&atilde;o</td>
            <td class="s2 borda2">Elemento</td>
            <td class="s3 borda2">SubElemento</td>
            <td class="s0">Fonte</td>
            <td class="s0">No M&ecirc;s</td>
            <td class="s0">At&eacute; o M&ecirc;s</td>
            <td class="s0">No M&ecirc;s</td>
            <td class="s0">At&eacute; o M&ecirc;s</td>
            <td class="s0">No M&ecirc;s</td>
            <td class="s0">At&eacute; o M&ecirc;s</td>
            <td class="s0">No M&ecirc;s</td>
            <td class="s0">At&eacute; o M&ecirc;s</td>
            <td class="s0">No M&ecirc;s</td>
            <td class="s0">At&eacute; o M&ecirc;s</td>
            <td class="s0">No M&ecirc;s</td>
            <td class="s0">At&eacute; o M&ecirc;s</td>
        </tr>


        <?php foreach ($oInfoRelatorio->aDados as $key => $oRegistro):

            $aTotal['empenhado']['no_mes']        += $oRegistro->empenhomes;
            $aTotal['empenhado']['ate_o_mes']     += $oRegistro->empenhoatemes;
            $aTotal['emp_anualdo']['no_mes']      += $oRegistro->anuladomes;
            $aTotal['emp_anualdo']['ate_o_mes']   += $oRegistro->anuladoatemes;
            $aTotal['liquidado']['no_mes']        += $oRegistro->liquidadomes;
            $aTotal['liquidado']['ate_o_mes']     += $oRegistro->liquidadoatemes;
            $aTotal['liq_anulado']['no_mes']      += $oRegistro->liquidadoanualdomes;
            $aTotal['liq_anulado']['ate_o_mes']   += $oRegistro->liquidadoanualdoatemes;
            $aTotal['pago']['no_mes']             += $oRegistro->pagomes;
            $aTotal['pago']['ate_o_mes']          += $oRegistro->pagoatemes;
            $aTotal['pago_anulado']['no_mes']     += $oRegistro->pagoanuladomes;
            $aTotal['pago_anulado']['ate_o_mes']  += $oRegistro->pagoanuladoatemes;

            ?>

            <tr style='height:20px;' class="bg_<?= ($key % 2) == 0 ?>">
                <td class="s4 borda3"><?= $oRegistro->funcao ?></td>
                <td class="s4"><?= $oRegistro->subfuncao ?></td>
                <td class="s4"><?= $oRegistro->c217_natureza ?></td>
                <td class="s4"><?= $oRegistro->c217_subelemento ?></td>
                <td class="s4"><?= $oRegistro->c217_fonte ?></td>
                <td class="s4"><?= db_formatar($oRegistro->empenhomes, 'f') ?></td>
                <td class="s4"><?= db_formatar($oRegistro->empenhoatemes, 'f') ?></td>
                <td class="s4"><?= db_formatar($oRegistro->anuladomes, 'f') ?></td>
                <td class="s4"><?= db_formatar($oRegistro->anuladoatemes, 'f') ?></td>
                <td class="s4"><?= db_formatar($oRegistro->liquidadomes, 'f') ?></td>
                <td class="s4"><?= db_formatar($oRegistro->liquidadoatemes, 'f') ?></td>
                <td class="s4"><?= db_formatar($oRegistro->liquidadoanualdomes, 'f') ?></td>
                <td class="s4"><?= db_formatar($oRegistro->liquidadoanualdoatemes, 'f') ?></td>
                <td class="s4"><?= db_formatar($oRegistro->pagomes, 'f') ?></td>
                <td class="s4"><?= db_formatar($oRegistro->pagoatemes, 'f') ?></td>
                <td class="s4"><?= db_formatar($oRegistro->pagoanuladomes, 'f') ?></td>
                <td class="s4"><?= db_formatar($oRegistro->pagoanuladoatemes, 'f') ?></td>
            </tr>

        <?php endforeach ?>


        <tr style='height:20px;'>
            <td class="s5 borda3" colspan="5">TOTAL</td>
            <td class="s5"><?= db_formatar($aTotal['empenhado']['no_mes'], 'f') ?></td>
            <td class="s5"><?= db_formatar($aTotal['empenhado']['ate_o_mes'], 'f') ?></td>
            <td class="s5"><?= db_formatar($aTotal['emp_anualdo']['no_mes'], 'f') ?></td>
            <td class="s5"><?= db_formatar($aTotal['emp_anualdo']['ate_o_mes'], 'f') ?></td>
            <td class="s5"><?= db_formatar($aTotal['liquidado']['no_mes'], 'f') ?></td>
            <td class="s5"><?= db_formatar($aTotal['liquidado']['ate_o_mes'], 'f') ?></td>
            <td class="s5"><?= db_formatar($aTotal['liq_anulado']['no_mes'], 'f') ?></td>
            <td class="s5"><?= db_formatar($aTotal['liq_anulado']['ate_o_mes'], 'f') ?></td>
            <td class="s5"><?= db_formatar($aTotal['pago']['no_mes'], 'f') ?></td>
            <td class="s5"><?= db_formatar($aTotal['pago']['ate_o_mes'], 'f') ?></td>
            <td class="s5"><?= db_formatar($aTotal['pago_anulado']['no_mes'], 'f') ?></td>
            <td class="s5"><?= db_formatar($aTotal['pago_anulado']['ate_o_mes'], 'f') ?></td>
        </tr>


        </tbody>
    </table>
</div>
<?php if(!in_array($sInstCgc, $aCgcExecaoRelFinanceiro)) {?>
<div class="ritz grid-container" dir="ltr">

    <table class="waffle" cellspacing="0" cellpadding="0" >
        <thead>
        <tr>
            <th class="borda1" style="width:70px">&nbsp;</th>
            <th class="borda1" style="width:78px">&nbsp;</th>
            <th class="borda1" style="width:66px">&nbsp;</th>
            <th class="borda1" style="width:91px">&nbsp;</th>
            <th class="borda1" style="width:42px">&nbsp;</th>
            <th class="borda1" style="width:100px">&nbsp;</th>
        </tr>
        </thead>

        <tbody>
        <tr style='height:20px;'>
            <td class="s0 fstb borda2 borda3" colspan="6">Resumo Financeiro</td>
        </tr>
        <tr style='height:20px;'>
            <td class="s0 fstb borda2 borda3" colspan="3">Entradas</td>
            <td class="s0 fstb" colspan="3">Saídas</td>
        </tr>

        <tr style='height:20px;'>
            <td class="s1 fstb borda2 borda3">Classifica&ccedil;&atilde;o</td>
            <td class="s2 fstb borda2">Saldo Incial</td>
            <td class="s2 fstb borda2">Receitas At&eacute; o M&ecirc;s</td>
            <td class="s3 fstb borda2">Despesas At&eacute; o M&ecirc;s</td>
            <td class="s0 fstb">RPs At&eacute; o M&ecirc;s</td>
            <td class="s0 fstb">Saldo</td>
        </tr>


        <?php foreach ($oInfoRelatorio->aDadosFinanceiros as $key => $oRegistro):

            $aTotal['saldoinicial']['saldoinicial']     += $oRegistro->saldoinicial;
            $aTotal['receitasatemes']['receitasatemes'] += $oRegistro->receitasatemes;
            $aTotal['despesasatemes']['despesasatemes'] += $oRegistro->despesasatemes;
            $aTotal['rps']['rps']                       += $oRegistro->rps;
            $aTotal['saldo']['salo_no_mes']             += $oRegistro->saldo;


            ?>

            <tr style='height:20px;' class="bg_<?= ($key % 2) == 0 ?>">

                <td class="s4 fstb borda2 borda3" style='text-align: left'><?= $oRegistro->classificacao ?></td>
                <td class="s4 fstb "><?= db_formatar($oRegistro->saldoinicial, 'f') ?></td>
                <td class="s4 fstb"><?= db_formatar($oRegistro->receitasatemes, 'f') ?></td>
                <td class="s4 fstb"><?= db_formatar($oRegistro->despesasatemes, 'f') ?></td>
                <td class="s4 fstb"><?= db_formatar($oRegistro->rps, 'f') ?></td>
                <td class="s4 fstb"><?= db_formatar($oRegistro->saldo, 'f') ?></td>

            </tr>

        <?php endforeach ?>


        <tr style='height:20px;'>
            <td class="s5 fstb borda2 borda3" >Saldo Total</td>
            <td class="s5 fstb"><?= db_formatar($aTotal['saldoinicial']['saldoinicial'], 'f') ?></td>
            <td class="s5 fstb"><?= db_formatar($aTotal['receitasatemes']['receitasatemes'], 'f') ?></td>
            <td class="s5 fstb"><?= db_formatar($aTotal['despesasatemes']['despesasatemes'], 'f') ?></td>
            <td class="s5 fstb"><?= db_formatar($aTotal['rps']['rps'], 'f') ?></td>
            <td class="s5 fstb"><?= db_formatar($aTotal['saldo']['salo_no_mes'], 'f') ?></td>
        </tr>


        </tbody>
    </table>
</div>
<?php } ?>
</body>
</html>

<?php

$html = ob_get_contents();

ob_end_clean();

try {

    $mPDF->WriteHTML(utf8_encode($html));
    $mPDF->Output();

} catch (Exception $e) {

    print_r($e->getMessage());

}

?>
