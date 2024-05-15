<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */
require_once ("libs/db_stdlib.php");
require_once ("libs/db_conecta.php");
require_once ("libs/db_sessoes.php");
require_once ("libs/db_utils.php");
require_once ("std/db_stdClass.php");

/**
 * Arquivo responsável pela consulta SQL.
 * Como esta consulta é compartilhada, é melhor estar separado
 */
require_once("mat2_relatoriosaidasmateriasdepto003.php");

//die($sSqlSaidas);

$rsSaidas = db_query($sSqlSaidas);
//db_criatabela($rsSaidas);die($sSqlSaidas);
header("Content-type: text/plain");
header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=file85.csv");
header("Pragma: no-cache");
readfile( 'file85.csv' );

$head1 = "Relatório de Saída de Material por Departamento";

if (!empty($oParametros->dataini)) {
    $head2 = "Período: " . $oParametros->dataini . ' a ' . $oParametros->datafin;
} else {
    $head2 = "Período final: " . $oParametros->datafin;;
}

$head3 = "LISTAR: TODOS";

echo "$head1 ;";
echo "$head2 ;";
echo "$head3 ;\n";

echo "Material ;";
echo "Descrição do Material ;";
echo "Unidade ;";
echo "Depto Origem ;";
echo "Depto Destino ;";
echo "Lançamento ;";
echo "Data ;";
echo "Preço Médio ;";
echo "Quant. ;";
echo "Valor Total ;\n";
//echo "tipomatestoqueini ;";
//echo "m83_coddepto ;";
//echo "descricaomovimento ;";
//echo "m41_codmatrequi ;";
//echo "precomedio ;";
//echo "valorfinanceiro ;\n";
//echo "m40_depto ;";
$oTot_qtd = 0;
$oTot_oTotal = 0;

for ($iCont = 0; $iCont < pg_num_rows($rsSaidas); $iCont++) {

    $oResult = db_utils::fieldsMemory($rsSaidas, $iCont);

    $iCodigoAlmoxarifado = str_pad($oResult->m80_coddepto, 3, " ", STR_PAD_RIGHT);
    $sAlmoxarifadoorigem       = "{$iCodigoAlmoxarifado} - $oResult->descrdepto";

    $sSqlDeptoDestino = "SELECT descrdepto FROM db_depart WHERE coddepto = {$oResult->m40_depto}";
    $rsDeptoDestino   = db_query($sSqlDeptoDestino);

    $sAlmoxarifadodestino = "{$oResult->m40_depto} - " . db_utils::fieldsMemory($rsDeptoDestino, 0)->descrdepto;

    $data = db_formatar($oResult->m80_data, "d");

    $oDadosDaLinha = new stdClass();
    $oDadosDaLinha->m70_codmatmater         = $oResult->m70_codmatmater;
    $oDadosDaLinha->m60_descr               = $oResult->m60_descr;
    $oDadosDaLinha->m61_abrev               = $oResult->m61_abrev;
    $oDadosDaLinha->sAlmoxarifadoorigem     = $sAlmoxarifadoorigem;
    $oDadosDaLinha->coddepmatestoqueini     = $sAlmoxarifadodestino;
    $oDadosDaLinha->m81_descr               = $oResult->m81_descr;
    $oDadosDaLinha->m80_data                = $data;
    $oDadosDaLinha->precomedio              = $oResult->precomedio;
    $oDadosDaLinha->qtde                    = $oResult->qtde;
    $oDadosDaLinha->m89_valorfinanceiro     = $oResult->m89_valorfinanceiro;

    $tipolancamento = $oResult->m81_descr."(".$oResult->m80_codigo.")";

    echo "$oResult->m70_codmatmater ;";
    echo "$oResult->m60_descr ;";
    echo "$oResult->m61_abrev ;";
    echo "$sAlmoxarifadoorigem ;";
    echo "$sAlmoxarifadodestino ;";
    echo "$tipolancamento ;";
    echo "$data ;";
    echo db_formatar($oResult->precomedio,"f")." ;";
    echo "$oResult->qtde ;";
    echo db_formatar($oResult->m89_valorfinanceiro,"f")." ;\n";

    $oTot_qtd        += $oResult->qtde;
    $oTot_oTotal     += $oResult->m89_valorfinanceiro;
}
    echo "Total: ;";
    echo " ;";
    echo " ;";
    echo " ;";
    echo " ;";
    echo " ;";
    echo " ;";
    echo " ;";
    echo $oTot_qtd." ;";
    echo db_formatar($oTot_oTotal,"f").";";
?>
