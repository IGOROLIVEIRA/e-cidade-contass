<?php

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

$sSql = db_query("select distinct ac16_sequencial, ac16_numero||'/'||ac16_anousu numcontrato,descrdepto,ac16_dataassinatura,z01_nome,ac16_valor,ac16_datainicio,ac16_datafim,ac16_objeto,ac16_vigenciaindeterminada from acordo inner join db_depart on coddepto = ac16_coddepto inner join cgm on z01_numcgm = ac16_contratado inner join acordoposicao on ac26_acordo = ac16_sequencial and ac26_acordoposicaotipo = 1 where ac16_sequencial = " . $sequencial);
$sSqlItens = db_query("select ac20_ordem,ac20_pcmater,pc01_descrmater,m61_descr,ac20_quantidade,ac20_valorunitario,ac20_valortotal from acordoitem inner join  acordoposicao on ac26_sequencial = ac20_acordoposicao and ac26_acordoposicaotipo = 1 inner join acordo on ac16_sequencial = ac26_acordo inner join pcmater on pc01_codmater = ac20_pcmater inner join matunid ON m61_codmatunid = ac20_matunid where ac16_sequencial = " . $sequencial . " order by ac20_ordem");

if (pg_num_rows($sSql) == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Nenhum registro encontrado.');
}
header("Content-type: application/vnd.ms-word; charset=UTF-8");
header("Content-Disposition: attachment; Filename=extratodecontrato.doc");

$oDados = db_utils::fieldsMemory($sSql, 0, true);
$tituloVigencia = $oDados->ac16_vigenciaindeterminada == "t" ? "Vigência Inicial: " : "Período de Vigência: ";
$dataVigencia = $oDados->ac16_vigenciaindeterminada == "t" ? $oDados->ac16_datainicio : $oDados->ac16_datainicio . ' até ' . $oDados->ac16_datafim;
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

            <strong>{$tituloVigencia} </strong>{$dataVigencia}
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

for ($i=0;$i<pg_num_rows($sSqlItens);$i++) {
    $oDadosItens = db_utils::fieldsMemory($sSqlItens, $i);
echo <<<HTML
    <tr>
        <th>{$oDadosItens->ac20_ordem}</th>
        <th>{$oDadosItens->ac20_pcmater}</th>
        <th style='text-align:left'>{$oDadosItens->pc01_descrmater}</th>
        <th>{$oDadosItens->m61_descr}</th>
        <th>{$oDadosItens->ac20_quantidade}</th>
        <th>{$oDadosItens->ac20_valorunitario}</th>
        <th>{$oDadosItens->ac20_valortotal}</th>
    </tr>
HTML;
}
echo <<<HTML
        </table>
        </center>
    </div>
    </body>
    </html>
HTML;

