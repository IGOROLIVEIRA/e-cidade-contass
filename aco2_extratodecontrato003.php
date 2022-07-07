<?php

//ini_set('display_errors', 'on');

require_once("fpdf151/pdf.php");
require_once("libs/db_utils.php");

require_once("classes/db_acordo_classe.php");
require_once("model/Acordo.model.php");
require_once("model/AcordoItem.model.php");
require_once("model/AcordoPosicao.model.php");
require_once("model/MaterialCompras.model.php");
require_once("model/CgmFactory.model.php");

$clacordo            = new cl_acordo;
$clacordoposicao     = new cl_acordoposicao;
$clacordoitem        = new cl_acordoitem;

$sSql = db_query("select distinct ac16_sequencial, ac16_numero||'/'||ac16_anousu numcontrato,descrdepto,ac16_dataassinatura,z01_nome,ac16_valor,ac16_datainicio,ac16_datafim,ac16_objeto from acordo inner join db_depart on coddepto = ac16_coddepto inner join cgm on z01_numcgm = ac16_contratado inner join acordoposicao on ac26_acordo = ac16_sequencial and ac26_acordoposicaotipo = 1 where ac16_sequencial = " . $sequencial);

if (pg_numrows($sSql) == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Nenhum registro encontrado.');
}

$oDados = db_utils::fieldsMemory($sSql, 0, true);

echo <<<HTML
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/html">
    <head>
        <title>Extrato de Contrato (Novo)</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <style>
        #info{
            font-weight: bold;
        }
        .topo{
            background-color: #CDC9C9;
        }
        td{
            text-align: center;
            text-transform:uppercase;
            font-size:11px;
        }
    </style>
    </head>

    <body>
        <h2 style="text-align: center">Extrato de Contrato</h2>
        <br>
        <div>
            <strong>Nº Contrato: </strong>{$oDados->numcontrato}
        </div>
        <div>
            <strong>Departamento: </strong>{$oDados->descrdepto}
        </div>
        <div>
            <strong>Data de Assinatura: </strong>{$oDados->ac16_dataassinatura}
        </div>
        <div>
            <strong>Contratado: </strong>{$oDados->z01_nome}
        </div>
        <div>
            <strong>Vigência: </strong>{$oDados->ac16_datainicio} até {$oDados->ac16_datafim}
        </div>
        <div>
            <strong>Valor do Contrato: </strong>R$ {$oDados->ac16_valor}
        </div>
        <div>
            <strong>Objeto: </strong>{$oDados->ac16_objeto}
        </div>
    <br>
    <br>
    <br>
    <div>
        <center>
        <table border="1">
            <tr class="topo">
                <th style="text-align:center"><strong>Ordem</strong></th>
                <th style="text-align:center"><strong>Item</strong></th>
                <th style="text-align:center"><strong>Descrição</strong></th>
                <th style="text-align:center"><strong>Unidade</strong></th>
                <th style="text-align:center"><strong>Quantidade</strong></th>
                <th style="text-align:center"><strong>Valor Unitário</strong></th>
                <th style="text-align:center"><strong>Valor Total</strong></th>
            </tr>
HTML;

$sSqlItens = db_query("select ac20_ordem,ac20_pcmater,pc01_descrmater,m61_descr,ac20_quantidade,ac20_valorunitario,ac20_valortotal from acordoitem inner join  acordoposicao on ac26_sequencial = ac20_acordoposicao and ac26_acordoposicaotipo = 1 inner join acordo on ac16_sequencial = ac26_acordo inner join pcmater on pc01_codmater = ac20_pcmater inner join matunid ON m61_codmatunid = ac20_matunid where ac16_sequencial = " . $sequencial . " order by ac20_ordem");

for ($i=0;$i<pg_numrows($sSqlItens);$i++) {

    $oDadosItens = db_utils::fieldsMemory($sSqlItens, $i);

    echo"<tr>";
    echo"<td>".$oDadosItens->ac20_ordem."</td>";
    echo"<td>".$oDadosItens->ac20_pcmater."</td>";
    echo"<td style='text-align:left'>".$oDadosItens->pc01_descrmater."</td>";
    echo"<td>".$oDadosItens->m61_descr."</td>";
    echo"<td>".$oDadosItens->ac20_quantidade."</td>";
    echo"<td>".$oDadosItens->ac20_valorunitario."</td>";
    echo"<td>".$oDadosItens->ac20_valortotal."</td>";

}

echo <<<HTML
        </table>
        </center>
    </div>
    </body>
    </html>
HTML;

header("Content-type: application/vnd.ms-word; charset=UTF-8");
header("Content-Disposition: attachment; Filename=extratodecontrato.doc");
