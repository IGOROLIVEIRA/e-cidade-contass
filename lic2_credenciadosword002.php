<?php
require("libs/db_stdlib.php");
require("libs/db_conecta.php");

/* Consulta para informações da licitação. */
$rsLicitacao = db_query("
select
	l20_edital,
	l20_numero,
	l03_descr,
	l20_dtpubratificacao,
	l20_objeto
from
	liclicita
inner join cflicita on
	l20_codtipocom = l03_codigo
where
	l20_codigo = $l20_codigo;");

$liclicita = db_utils::fieldsMemory($rsLicitacao, 0);

$rsItensCredenciados = db_query("
select
	*
from
	liclicitem
inner join pcprocitem on
	pc81_codprocitem = l21_codpcprocitem
inner join pcorcamitemproc on
	pc31_pcprocitem = pc81_codprocitem
inner join itemprecoreferencia on
	si02_itemproccompra = pc31_orcamitem
inner join credenciamento on
	l205_item = l21_codpcprocitem
inner join cgm on
	l205_fornecedor = z01_numcgm
inner join solicitempcmater on
	pc16_solicitem = pc81_solicitem
inner join solicitem on 
	pc11_codigo = pc16_solicitem
inner join pcmater on
	pc16_codmater = pc01_codmater
inner join matunid on
	si02_codunidadeitem = m61_codmatunid
where
	l21_codliclicita = $l20_codigo
order by
	pc11_seq,l205_fornecedor;
");

$liclicita->l20_dtpubratificacao = implode('/', array_reverse(explode('-', $liclicita->l20_dtpubratificacao)));

echo <<<HTML
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/html">
    <head>
        <title>Credenciados</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <style>
        td{
            text-align: center;
            text-transform:uppercase;
            font-size:11px;
        }
    </style>
    </head>

    <body>
        <h2 style="text-align: center">Credenciados</h2>
        <br>
        <div>
            <strong>Processo: </strong>{$liclicita->l20_edital}
        </div>
        <div>
            <strong>Modalidade: </strong>$liclicita->l20_numero - $liclicita->l03_descr
        </div>
        <div>
            <strong>Data de Ratificação: </strong>$liclicita->l20_dtpubratificacao
        </div>
        <div>
            <strong>Objeto: </strong>$liclicita->l20_objeto
        </div>
    <br>
    <br>
    <br>
  
HTML;

$fornecedor = 0;
$total = 0;

for ($i = 0; $i < pg_numrows($rsItensCredenciados); $i++) {
    $item = db_utils::fieldsMemory($rsItensCredenciados, $i);

    if ($fornecedor != $item->l205_fornecedor) {
        $descricaofornecedor = $item->z01_nome . " - CNPJ: " . $item->z01_cgccpf . " - Data do Credenciamento: " . implode('/', array_reverse(explode('-', $item->l205_datacred)));
        echo " <div style='font-size:11px;font-weight: bold;'>
         $descricaofornecedor</div> ";
        echo '
        <div>
        <table border="1">
        <tr style="background-color: #CDC9C9;" >
                <th style="text-align:center"><strong>Item</strong></th>
                <th style="text-align:center;width:400px;"><strong>Descrição</strong></th>
                <th style="text-align:center"><strong>Unidade</strong></th>
                <th style="text-align:center"><strong>Quantidade</strong></th>
                <th style="text-align:center"><strong>Valor Unitário</strong></th>
                <th style="text-align:center"><strong>Valor Total</strong></th>
        </tr>';
        $fornecedor = $item->l205_fornecedor;
        $total = 0;
    }

    echo "<tr>";
    echo "<td>" . $item->pc11_seq . "</td>";
    echo "<td>" . substr($item->pc01_descrmater, 0, 62) . "</td>";
    echo "<td style='text-align:left'>" . $item->m61_descr . "</td>";
    echo "<td>" . $item->si02_qtditem . "</td>";
    echo "<td>" . 'R$ ' . number_format($item->si02_vlprecoreferencia, 2, ',', '.') . "</td>";
    echo "<td>" . 'R$ ' . number_format($item->si02_vltotalprecoreferencia, 2, ',', '.') . "</td>";
    echo "</tr>";


    $proximofornecedor = db_utils::fieldsMemory($rsItensCredenciados, $i + 1)->l205_fornecedor;
    $total += $item->si02_vltotalprecoreferencia;

    if ($proximofornecedor != $item->l205_fornecedor) {
        $total = 'R$ ' . number_format($total, 2, ',', '.');
        echo "<td style='border:none;' colspan='2' align='left' > Total: $total </td>";
        echo '</table> </div>';
        echo "<br><br><br>";
    }
}


header("Content-type: application/vnd.ms-word; charset=UTF-8");
header("Content-Disposition: attachment; Filename=credenciamento.doc");
