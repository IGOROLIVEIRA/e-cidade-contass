<?php

require_once("model/relatorios/Relatorio.php");


/**
 * Arquivo responsável pela consulta SQL.
 * Como esta consulta é compartilhada, é melhor estar separado
 */
require_once("mat2_relatoriosaidasmateriasdepto003.php");

header("Content-type: text/plain");
header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=file.csv");
header("Pragma: no-cache");
readfile( 'file.csv' );

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
echo "Lançamento ;";
echo "Data ;";
echo "Preço Medio ;";
echo "Quant. ;";
echo "Valor Total ;\n";

$aResultadoBusca = array();

try {

    $rsSaidas = db_query($sSqlSaidas);
    $iNumRows = pg_num_rows($rsSaidas);

    if ($iNumRows == 0) {
        throw new Exception("Não existem dados para esta busca", 1);
    }

    $aResultadoBusca = db_utils::getCollectionByRecord($rsSaidas);

} catch (Exception $e) {
    db_redireciona('db_erros.php?fechar=true&db_erro='. $e->getMessage());
}


$aDepartamentos = array();

foreach ($aResultadoBusca as $key => $oItem) {

    $iOrigem   = $oItem->m70_coddepto;
    $iDestino  = $oItem->m40_depto;

    if (!isset($aDepartamentos[$iOrigem])) {

        $oOrigem = new stdClass();
        $oOrigem->titulo = substr($iOrigem . " - " . $oItem->descrdepto, 0, 25);
        $oOrigem->destinos = array();

        $aDepartamentos[$iOrigem] = $oOrigem;

    }


    if ($oItem->m83_coddepto != "") {
        $iDestino = $oItem->m83_coddepto;
    }


    if (!isset($aDepartamentos[$iOrigem]->destinos[$iDestino])) {

        $oDestino = new stdClass();
        $oDestino->materiais  = array();
        $oDestino->valorTotal = 0;
        $oDestino->qtdTotal   = 0;
        $oDestino->titulo     = "";

        if ($iDestino != "") {

            $sSqlDeptoDestino = "SELECT descrdepto FROM db_depart WHERE coddepto = {$iDestino}";
            $rsDeptoDestino   = db_query($sSqlDeptoDestino);

            $oDestino->titulo = "{$iDestino} - " . db_utils::fieldsMemory($rsDeptoDestino, 0)->descrdepto;

        }

        $aDepartamentos[$iOrigem]->destinos[$iDestino] = $oDestino;

    }


    $oMaterial = new stdClass();
    $oMaterial->codigo    = $oItem->m70_codmatmater;
    $oMaterial->descricao = $oItem->m60_descr;
    $oMaterial->unidade   = $oItem->m61_abrev;

    $iLancamento = $oItem->m41_codmatrequi;

    if ($oItem->m41_codmatrequi == "") {
        $iLancamento = $oItem->m80_codigo;
    }

    $oMaterial->lancamento  = substr($oItem->m81_descr,0,30 ) . "({$iLancamento})";
    $oMaterial->data        = db_formatar($oItem->m80_data, 'd');
    $oMaterial->precoMedio  = number_format($oItem->precomedio, 2);
    $oMaterial->quantidade  = $oItem->qtde;
    $oMaterial->valorTotal  = db_formatar($oItem->m89_valorfinanceiro, 'f');


    $aDepartamentos[$iOrigem]
        ->destinos[$iDestino]
        ->qtdTotal += $oItem->qtde;


    $aDepartamentos[$iOrigem]
        ->destinos[$iDestino]
        ->valorTotal += $oItem->m89_valorfinanceiro;


    $aDepartamentos[$iOrigem]
        ->destinos[$iDestino]
        ->materiais[] = $oMaterial;

}
foreach($aDepartamentos as $iOrigem => $oOrigem){
    echo "Departamento Origem: $oOrigem->titulo \n"; //departamento origem

    foreach ($oOrigem->destinos as $iDestino => $oDestino){

        echo "Departamento Destino: $oDestino->titulo \n"; //departamento destino

        foreach ($oDestino->materiais as $iMaterial){

            echo "$iMaterial->codigo ;";
            echo "$iMaterial->descricao ;";
            echo "$iMaterial->unidade ;";
            echo "$iMaterial->lancamento ;";
            echo "$iMaterial->data ;";
            echo "$iMaterial->precoMedio ;";
            echo "$iMaterial->quantidade ;";
            echo "$iMaterial->valorTotal ;\n";
        }

        echo "TOTAL: ;";
        echo " ;";
        echo " ;";
        echo " ;";
        echo " ;";
        echo " ;";
        echo "$oDestino->qtdTotal ;";
        echo "$oDestino->valorTotal ;\n";
    }
}

?>
