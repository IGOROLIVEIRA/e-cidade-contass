<?
require_once("model/relatorios/Relatorio.php");
require_once("std/DBDate.php");
include("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_app.utils.php");
include("classes/db_emppresta_classe.php");
include("classes/db_empprestaitem_classe.php");
include("classes/db_empdescontonota_classe.php");
include("fpdf151/assinatura.php");

$clempdescontonota = new cl_empdescontonota;
$clemppresta = new cl_emppresta;
$clempprestaitem = new cl_empprestaitem;
$classinatura = new cl_assinatura;
$oGet = db_utils::postMemory($_GET);

function mascaraCPF($sCPF)
{
    $sRegex    = "/(\d{3})(\d{3})(\d{3})(\d{2})/";
    $sReplace  = '$1.$2.$3-$4';

    $sReplaced = preg_replace($sRegex, $sReplace, $sCPF);

    return $sReplaced;
}

// máscara para CNPJ
function mascaraCNPJ($sCNPJ)
{

    $sRegex    = "/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/";
    $sReplace  = '$1.$2.$3/$4-$5';

    $sReplaced = preg_replace($sRegex, $sReplace, $sCNPJ);

    return $sReplaced;
}

$valortotal = 0;

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
if (isset($e60_codemp)) {
    $codemp = split("/", $e60_codemp);
    if (count($codemp) == 1) {
        $ano = db_getsession("DB_anousu");
    } else {
        $ano = $codemp[1];
    }
    $codemp = $codemp[0];

    $sSql = $clemppresta->sql_query_empenhos(
        null,
        'distinct(e45_numemp)',
        "e45_numemp",
        "e60_codemp = '$codemp' and
   e60_instit = " . db_getsession("DB_instit") . " and e60_anousu = " . $ano
    );
}

if (isset($codemp) && isset($e60_numemp)) {
    $sSql = $clemppresta->sql_query_empenhos(
        null,
        'distinct(e45_numemp)',
        "e45_numemp",
        "e60_codemp = '$codemp' and e60_numemp = $e60_numemp and
   e60_instit = " . db_getsession("DB_instit")
    );
    //  $sSql = $clemppresta->sql_query(null, 'e45_sequencial,e45_numemp,e45_data,e45_obs,e45_tipo,e45_acerta,
    //    e45_conferido,z01_nome,e44_descr,
    //    e60_codemp,
    //    e60_anousu,
    //    e60_vlremp,
    //    e60_vlranu,
    //    e60_vlrliq,
    //    e60_coddot,
    //    fc_estruturaldotacao(e60_anousu,e60_coddot) as dl_estrutural', "e45_sequencial desc",
    //    " e60_codemp = $codemp and e60_anousu = $ano and e60_instit = " . db_getsession("DB_instit"));


} else if (isset($e60_numemp)) {
    $sSql = $clemppresta->sql_query_empenhos(
        null,
        'distinct(e45_numemp)',
        "e45_numemp",
        "e45_numemp = $e60_numemp and e60_instit = " . db_getsession("DB_instit")
    );
    //  $sSql = $clemppresta->sql_query(null, 'e45_sequencial,e45_numemp,e60_anousu,e45_data,e45_obs,e45_tipo,e45_acerta,
    //    e45_conferido,z01_nome,e44_descr,
    //    e60_codemp, e60_vlremp, e60_vlranu, e60_vlrliq, e60_coddot,
    //    fc_estruturaldotacao(e60_anousu,e60_coddot) as dl_estrutural', "e45_sequencial desc",
    //    "e45_numemp = $e60_numemp and e60_instit = " . db_getsession("DB_instit"));

}
$filtro = '';

if (isset($oGet->listaFornecedores) && $oGet->listaFornecedores != '') {
    $lista = '';
    $listaFornecedores = explode(',', $oGet->listaFornecedores);
    $virgula = '';
    foreach ($listaFornecedores as $fornecedor) {
        $lista .= $virgula . "'$fornecedor'";
        $virgula = ',';
    }
    $filtro .= " z01_numcgm in ($lista) ";
    $filtro .= " and ";
}

if (isset($oGet->dataInicio) && isset($oGet->dataFim)) {
    if ($oGet->dataInicio != '' && $oGet->dataFim != '') {
        $filtro .= " e60_emiss between '{$oGet->dataInicio}' and '{$oGet->dataFim}' ";
        $filtro .= " and ";
    }
}

if ($filtro != '') {
    $sSql = $clemppresta->sql_query_empenhos(
        null,
        'distinct(e45_numemp)',
        'e45_numemp',
        "$filtro e60_instit = " . db_getsession("DB_instit")
    );
}


// print_r($sSql);die();
$rsSql = db_query($sSql);
// db_criatabela($rsSql);die();

$mPDF  = new Relatorio('', 'A4-L'); //RELATORIO LANDSCAPE, PARA PORTRAIT, DEIXE SOMENTE A4


$head1 = "PLANILHA DE PRESTAÇÃO DE CONTAS";

if (pg_num_rows($rsSql) == 0) {
    db_redireciona("db_erros.php?fechar=true&db_erro=Não foram encontrados registros.");
} else {
    for ($contador = 0; $contador < pg_num_rows($rsSql); $contador++) {
        db_fieldsmemory($rsSql, $contador);

        $sSqlItens = $clemppresta->sql_query_empenhos(
            null,
            'distinct e45_sequencial,e45_numemp,e60_anousu,e45_data,e45_obs,e45_tipo,e45_acerta,
            e45_conferido,z01_nome,e44_descr,
            e60_codemp, e60_vlremp, e60_vlranu, e60_vlrliq, e60_coddot,
            fc_estruturaldotacao(e60_anousu,e60_coddot) as dl_estrutural, e46_valor',
            "e45_sequencial desc",
            "e45_numemp = $e45_numemp and e60_instit = " . db_getsession("DB_instit")
        );

        $rsResult = db_query($sSqlItens);
        // db_criatabela($rsResult);

        // for($contItens = 0; $contItens < pg_num_rows($rsResult);$contItens++){

        $rsResultado = db_utils::fieldsMemory($rsResult, 0);


        $mPDF->addPage();
        $head6 = "DATA : " . date("d/m/Y", db_getsession('DB_datausu'));
        $head5 = "";
        $head3 = "EMPENHO: $rsResultado->e60_codemp/$rsResultado->e60_anousu";
        $head4 = "SEQUENCIAL: $rsResultado->e45_numemp";

        $mPDF->addInfo($head1, 1);
        $mPDF->addInfo($head5, 5);
        $mPDF->addInfo($head6, 6);
        $mPDF->addInfo($head3, 3);
        $mPDF->addInfo($head4, 4);

        ob_start();


?>
        <!DOCTYPE html>
        <html>

        <head>
            <title>Relatório</title>
            <link rel="stylesheet" type="text/css" href="estilos/relatorios/padrao.style.css">
        </head>

        <body>
            <div class="content">
                <?php

                $e60_numemp = $rsResultado->e45_numemp;

                $sql1 = "SELECT DISTINCT k13_conta,
            k13_descr,
            k12_codord
            FROM coremp p
            INNER JOIN corrente r ON r.k12_id = p.k12_id
            AND r.k12_data = p.k12_data
            AND r.k12_autent = p.k12_autent
            INNER JOIN saltes ON k13_conta = k12_conta
            WHERE k12_empen = $rsResultado->e45_numemp";

                $result1 = pg_query($sql1);
                db_fieldsmemory($result1, 0);
                ?>
                <table id="table" style=" width:100%; border-collapse: collapse; font-size:12px;">
                    <tr>
                        <td>
                            <b>Número do empenho</b>: <?php echo $rsResultado->e60_codemp . '/' . $rsResultado->e60_anousu; ?>
                        </td>
                        <td>
                            <b>Nome</b>: <?php echo $rsResultado->z01_nome; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Sequencial do empenho</b>: <?php echo $e60_numemp; ?>
                        </td>
                        <td>
                            <b>Dotação</b>: <?php echo $rsResultado->e60_coddot . " - " . $rsResultado->dl_estrutural ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Data</b>: <?php echo db_formatar($rsResultado->e45_data, 'd'); ?>
                        </td>
                        <td>
                            <b>Descrição do evento</b>: <?php echo $rsResultado->e44_descr; ?>
                        </td>
                    </tr>

                    <tr>
                        <td><b>Acerto da prestação de
                                contas</b>: <?php echo db_formatar($rsResultado->e45_acerta, 'd') ?></td>
                        <td><b>Conferido</b>: <?php echo db_formatar($rsResultado->e45_conferido, 'd'); ?></td>
                    </tr>
                    <tr>
                        <td><b>Conta</b>: <?php echo $k13_conta . ' - ' . $k13_descr ?></td>
                        <td><b>Observação</b>: <?php echo $rsResultado->e45_obs; ?></td>
                    </tr>
                    <tr>
                        <td><b>Ordem de pagamento</b>: <?php echo $k12_codord; ?></td>
                    </tr>
                    <tr>
                    </tr>
                </table>
                <br>
                <table cellspacing="0" width="100%">

                    <?

                    $sWhere = '';

                    $sWhere .= " e46_numemp=$e60_numemp";
                    $result_itens = $clempprestaitem->sql_record($clempprestaitem->sql_query(
                        null,
                        '*',
                        'e46_nota',
                        "$sWhere "
                    ));
                    db_fieldsmemory($result_itens);
                    $result_itens = db_utils::getColectionByRecord($result_itens);

                    $nota = "";
                    $totalNota = 0;

                    ?>

                    <?php
                    foreach ($result_itens as $item) : ?>
                        <?php
                        if ($nota != $item->e46_nota) :

                        ?>
                            <?php

                            $filtro = '';

                            if ($nota != '') {
                                $filtro = " and e999_nota = '$nota' ";
                            }

                            $rsNota = $clempdescontonota->sql_record($clempdescontonota->sql_query(
                                null,
                                "*",
                                null,
                                "e999_empenho in ($e60_numemp) $filtro "
                            ));

                            $rsNota = db_utils::fieldsMemory($rsNota);

                            ?>
                            <?php if ($nota != "") :
                                if ($totalNota + $rsNota->e999_valor <= $rsResultado->e60_vlremp) {
                                    $totalNota += $rsNota->e999_valor;
                                    $totalNota -= $rsNota->e999_desconto;
                                }

                            ?>
                                <tr>
                                    <td colspan="9" style="font-size:14px" align="right">
                                        <br>
                                        <b>Total da
                                            Nota: </b> <?php echo "R$" . db_formatar($rsNota->e999_valor, 'f'); ?>
                                        <b>Desconto: </b> <?php echo "R$" . db_formatar($rsNota->e999_desconto, 'f'); ?>
                                        <b>Valor
                                            Líquido: </b> <?php echo "R$" . db_formatar($rsNota->e999_valor - $rsNota->e999_desconto, 'f'); ?>
                                        <hr>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php $nota = $item->e46_nota;

                            ?>
                            <tr>
                            <tr>
                                <td colspan="5"><b>Nota Fiscal: </b><?php echo $nota; ?></td>
                            </tr>
                            </tr>
                            <tr style="background: #ebebeb; padding:2px; border:1px solid black;">

                                <th style="padding:2px; margin:0px; border:0.01em solid black;" rowspan="2">Item
                                </th>
                                <th style="padding:2px; margin:0px; border:0.01em solid black;" rowspan="2">
                                    Descrição do Ítem
                                </th>
                                <th style="padding:2px; margin:0px; border:0.01em solid black;" rowspan="2">
                                    Fornecedor
                                </th>
                                <th style="padding:2px; margin:0px; border:0.01em solid black;" rowspan="2">
                                    CPF/CNPJ
                                </th>
                                <th style="padding:2px; margin:0px; border:0.01em solid black;" rowspan="2">
                                    Descrição da <br>Prestação de Contas
                                </th>
                                <th style="padding:2px; margin:0px; border:0.01em solid black;" rowspan="2">Quant.
                                </th>
                                <th style="padding:2px; margin:0px; border:0.01em solid black;" colspan="3">Valor
                                </th>
                            </tr>
                            <tr style="background: #ebebeb; padding:2px; border:1px solid black;">
                                <th style="padding:2px; margin:0px; border:0.01em solid black;">Unit.</th>
                                <th style="padding:2px; margin:0px; border:0.01em solid black;">Desc.</th>
                                <th style="padding:2px; margin:0px; border:0.01em solid black;">Total</th>
                            </tr>
                        <?php
                        endif;

                        ?>
                        <tr>

                            <td style="padding:2px;text-align:center; border:0.005em solid #333;"><?php echo $item->pc01_codmater; ?></td>
                            <td style="padding:2px;text-align:center; border:0.005em solid #333;"><?php echo $item->pc01_descrmater; ?></td>
                            <td style="padding:2px;text-align:center; border:0.005em solid #333;"><?php echo $item->e46_nome; ?></td>
                            <td style="padding:2px;text-align:center; border:0.005em solid #333;"><?php echo !empty($item->e46_cnpj) ? mascaraCNPJ($item->e46_cnpj) : mascaraCPF($item->e46_cpf) ?></td>
                            <td style="padding:2px;text-align:center; border:0.005em solid #333;"><?php echo $item->e46_descr; ?></td>
                            <td style="padding:2px;text-align:center; border:0.005em solid #333;"><?php echo db_formatar($item->e46_quantidade, 'f'); ?></td>
                            <td style="padding:2px;text-align:center; border:0.005em solid #333;"><?php echo db_formatar($item->e46_valorunit, 'f'); ?></td>
                            <td style="padding:2px;text-align:center; border:0.005em solid #333;"><?php echo db_formatar($item->e46_desconto, 'f'); ?></td>
                            <td style="padding:2px;text-align:center; border:0.005em solid #333;"><?php echo db_formatar($item->e46_valor - $item->e46_desconto, 'f') ?></td>

                        </tr>
                    <?php

                        $rsNota = $clempdescontonota->sql_record($clempdescontonota->sql_query(
                            null,
                            "*",
                            null,
                            "e999_empenho in ($e60_numemp) and e999_nota = '$nota'"
                        ));

                        $rsNota = db_utils::fieldsMemory($rsNota);


                    endforeach;
                    if ($totalNota + $rsNota->e999_valor <= $rsResultado->e60_vlremp) {
                        $totalNota += $rsNota->e999_valor;
                        $totalNota -= $rsNota->e999_desconto;
                    }
                    ?>

                    <tr>
                        <td colspan="9" style="font-size:14px" align="right">
                            <br>
                            <b>Total da Nota:</b> <?php echo "R$" . db_formatar($rsNota->e999_valor, 'f'); ?>
                            <b>Desconto:</b> <?php echo "R$" . db_formatar($rsNota->e999_desconto, 'f'); ?>
                            <b>Valor
                                Líquido:</b> <?php echo "R$" . db_formatar($rsNota->e999_valor - $rsNota->e999_desconto, 'f'); ?>
                            <hr>
                        </td>
                    </tr>
                </table>

                <table width="100%">
                    <tr>
                        <td>
                            <br>

                            <!-- <hr> -->
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <b>VALOR TOTAL:</b> <?php echo "R$" . db_formatar($totalNota, 'f'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <b>VALOR EMPENHADO:</b> <?php echo "R$" . db_formatar($rsResultado->e60_vlremp, 'f'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <?php
                            $valor_diferenca = $rsResultado->e60_vlremp - $rsResultado->e60_vlranu - $totalNota;

                            if ($valor_diferenca < 0) {

                                $sLabel = "DESPESA GLOSADA";
                            } else {
                                $sLabel = "ANULAR DE DESPESA";
                            }
                            ?>
                            <b><?php echo $sLabel; ?>:</b> <?php echo "R$" . db_formatar($valor_diferenca, 'f'); ?>
                        </td>
                    </tr>
                    <tr>
                        <?php
                        $aTitulosAssinaturas[] = $classinatura->assinatura(9002, '', '0');
                        $aTitulosAssinaturas[] = $classinatura->assinatura(9002, '', '1');
                        $aTitulosAssinaturas[] = $classinatura->assinatura(9002, '', '2');
                        $aTitulosAssinaturas[] = $classinatura->assinatura(9002, '', '3');
                        $aTitulosAssinaturas[] = $classinatura->assinatura(9002, '', '4');

                        $aTitulosAssinaturas = array_filter($aTitulosAssinaturas, function ($sStr) {
                            return !empty($sStr);
                        });


                        ?>
                        <td width="100%">
                            <br>
                            <br>
                            <br>
                            <table width="100%">
                                <tr>
                                    <td style="width:20%; text-align: center;">
                                        <hr>
                                        <br>
                                        <?php echo $aTitulosAssinaturas[0];
                                        ?>
                                    </td>
                                    <td style="width:20%; text-align: center;">
                                        <hr>
                                        <br>
                                        <?php echo $aTitulosAssinaturas[1]; ?>
                                    </td>
                                    <td style="width:20%; text-align: center;">
                                        <hr>
                                        <br>
                                        <?php echo $aTitulosAssinaturas[2]; ?>
                                    </td>
                                    <td style="width:20%; text-align: center;">
                                        <hr>
                                        <br>
                                        <?php echo $aTitulosAssinaturas[3]; ?>
                                    </td>
                                    <td style="width:20%; text-align: center;">
                                        <hr>
                                        <br>
                                        <?php echo $aTitulosAssinaturas[4]; ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </body>

        </html>

<?php
        $html = ob_get_contents();
        ob_end_clean();
        try {
            $mPDF->WriteHTML(utf8_encode($html));
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }
    // }
}
// die();
$mPDF->Output();

?>
