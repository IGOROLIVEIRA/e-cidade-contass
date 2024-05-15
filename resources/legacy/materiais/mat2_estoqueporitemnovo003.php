<?php
require_once ("fpdf151/pdf.php");
require_once ("libs/db_stdlib.php");
require_once ("libs/db_conecta.php");
require_once ("libs/db_sessoes.php");
require_once ("libs/db_utils.php");
require_once ("dbforms/db_funcoes.php");
require_once ("std/db_stdClass.php");
require_once ("classes/materialestoque.model.php");

$oGet = db_utils::postMemory($_GET);

/**
 * Cabeçalho do Relatório
 */
$sInformacaoData = "";
if (!empty($oGet->data_inicial) && !empty($oGet->data_final)) {
    $sInformacaoData = "De {$oGet->data_inicial} até {$oGet->data_final}";
} else if (!empty($oGet->data_inicial) && empty($oGet->data_final)) {
    $sInformacaoData = "Apartir de {$oGet->data_inicial}";
} else if (empty($oGet->data_inicial) && !empty($oGet->data_final)) {
    $sInformacaoData = "Até de {$oGet->data_final}";
}

switch ($oGet->tipoimpressao) {

    case "S": // Sintético
        $sTipoImpressa = "Sintética";
        break;
    case "A": // Analítica
        $sTipoImpressa = "Analítica";
        break;
    case "C": // Conferência
        $sTipoImpressa = "Conferência";
        break;
}

$head3 = "Relatório de Estoque";
$head4 = $sTipoImpressa;
$head5 = $sInformacaoMaterial;
$head6 = $sInformacaoData;
$head7 = "Somente Materiais";

if ($oGet->totalizador == 'sim') {
    $head8 = "Com totalizador";
}

if($oGet->opcao_material = 'A'){
    $head9 = 'Materiais Ativos';
}else{
    $head9 = 'Materiais Inativos';
}


echo "$head3 ;";
echo "$head4 ;";
echo "$head9 ;";
echo "$head5 ;";
echo "$head6 ;";
echo "$head7 ;";
echo "$head8 ;\n";

if($oGet->tipoimpressao == "S"){
    echo "Cod.Material ;";
    echo "Descrição Material ;";
    echo "Almoxarifado ;";
    echo "Quant. Estoq ;";
    echo "Valor em Estoque ;\n";
}elseif ($oGet->tipoimpressao == "A"){
    echo "Cod.Material ;";
    echo "Descrição Material ;";
    echo "Almoxarifado ;";
    echo "Quant. Estoq ;";
    echo "Valor em Estoque ;\n";
    echo "Cod. Lançamento ;";
    echo "Data ;";
    echo "Lote ;";
    echo "Validade ;";
    echo "Fabricante ;";
    echo "Vlr Unitário ;";
    echo "Qtd Entrada ;";
    echo "Quant. Atendida ;";
    echo "Valor ;\n";
}else{
    echo "Cod.Material ;";
    echo "Descrição Material ;";
    echo "Almoxarifado ;";
    echo "Quant. Estoq ;";
    echo "Contagem ;";
    echo "Valor em Estoque ;\n";
}

$aListaWhere         = array();
$aListaWhereSaidas   = array();
$sInformacaoMaterial = "";
$oTotalEstoqueAnalitico = new stdClass();
$oTotalEstoqueSintetico = new stdClass();
/**
 * Verificamos os fitros por departamento
 * V?riaveis do Get s?o strings por isso comparamos o false como string
 */
if (isset($oGet->almoxarifados) && !empty($oGet->almoxarifados)) {

    $sDepartamento = " m70_coddepto in  ($oGet->almoxarifados) ";
    if (isset($oGet->veralmoxarifados) && $oGet->veralmoxarifados == "false") {
        $sDepartamento = " m70_coddepto not in  ($oGet->almoxarifados) ";
    }
    $aListaWhere[] = $sDepartamento ;
}

/**
 * Verificamos os filtros de material
 * V?riaveis do Get s?o strings por isso comparamos o false como string
 */
if (isset($oGet->listamaterial) && !empty($oGet->listamaterial)) {

    $sTipoFiltro = " in ";
    if (isset($oGet->vermaterial) && $oGet->vermaterial == "false") {
        $sTipoFiltro = " not in ";
    }
    $sMaterial = " m70_codmatmater {$sTipoFiltro} ({$oGet->listamaterial}) ";
    $aListaWhere[] = $sMaterial;
}

if (isset($oGet->data_inicial) && !empty($oGet->data_inicial)) {

    $sDataInicial         = implode("-", array_reverse(explode("/", $oGet->data_inicial)));
    $sDatas               = " m71_data >= '{$sDataInicial}' ";
    $aListaWhere[]        = $sDatas;
    $aListaWhereSaidas[]  = $sDatas;
}

if (isset($oGet->data_final) && !empty($oGet->data_final)) {

    $sDataFinal          = implode("-", array_reverse(explode("/", $oGet->data_final)));
    $sDatas              = " m71_data <= '{$sDataFinal}' ";
    $aListaWhere[]       = $sDatas;
    $aListaWhereSaidas[] = $sDatas;
}

/**
 * Verificamos filtro para institui??o
 */
if (isset($oGet->instituicoes) && !empty($oGet->instituicoes)) {
    $aListaWhere[] = " dpartini.instit in ($oGet->instituicoes) ";
}

/**
 * Verificamos se devemos filtar por materiais:
 * Ativos / Inativos
 */
if ($oGet->opcao_material == "A") {

    $aListaWhere[]         = " m60_ativo = 't' ";
    $sInformacaoMaterial  .= "Materiais Ativos";

} else if ($oGet->opcao_material== "I") {

    $aListaWhere[]         = " m60_ativo = 'f' ";
    $sInformacaoMaterial  .= "Materiais Inativos";
}

$aListaWhere[]   = "m71_servico is false";
/**
 * Verificamos a ordem de busca dos filtros
 */
$sOrdem = '';
switch ($oGet->ordem) {

    case 'a':

        $sOrdem = 'm60_descr';
        break;
    case 'c':

        $sOrdem = 'm60_codmater';
        break;
    case 'd':

        $sOrdem = 'm70_coddepto, m60_descr';
        break;
}

if (isset($oGet->quebrapordepartamento) && $oGet->quebrapordepartamento == "S") {
    $sOrdem = "dpartestoque.coddepto, m60_descr";
}

$sWhere       = implode(" and ", $aListaWhere);
$sWhereSaidas = implode(" and ", $aListaWhereSaidas);

if (!empty($sWhereSaidas)) {

    $sWhereSaidas = "and {$sWhereSaidas}";
}

if (isset($oGet->verestoquezerado) && $oGet->verestoquezerado == 'N' ) {

    $sWhere.= " and m71_quant > '0' ";
}
$oDaoMatEstoqueIniMei = db_utils::getDao("matestoqueinimei");

/**
 * criamos uma lista de itens por estoque. conforme filtros acima.
 */
$sCampos          = " distinct dpartestoque.coddepto as codigo_departamento, ";
$sCampos         .= " dpartestoque.descrdepto as descricao_departamento, m71_codmatestoque, m71_codlanc, m71_quant,  ";
$sCampos         .= " m60_codmater, m60_descr, dpartini.coddepto as codigo_almoxarifado,  m77_lote, ";
$sCampos         .= " dpartini.descrdepto as descrisao_almoxarifado, ";
$sCampos         .= " m71_valor, m77_dtvalidade, m76_nome as fabricante, m71_data as data_movimeto";
$sSqlDadosEstoque = $oDaoMatEstoqueIniMei->sql_query_precomedio(null, $sCampos, $sOrdem, $sWhere);

$aTiposMovimentoEntrada = array(1, 3, 12);
$rsDadosEstoque         = $oDaoMatEstoqueIniMei->sql_record($sSqlDadosEstoque);
$aItensEstoque          = array();
$iTotalItensEstoque     = $oDaoMatEstoqueIniMei->numrows;

if ($iTotalItensEstoque > 25000) {

    $sMsgErro  = "Não foi possível gerar o relatório. Muitos registros foram encontrados. <br>";
    $sMsgErro .= "Por favor, refine sua busca. ";
    db_redireciona("db_erros.php?fechar=true&db_erro=$sMsgErro");
}

$oTotalEstoqueAnalitico->iNumeroLancamentos = $iTotalItensEstoque;
$oTotalEstoqueAnalitico->iTotalEntrada      = 0;
$oTotalEstoqueAnalitico->iTotalAtendido     = 0;
$oTotalEstoqueAnalitico->iTotal             = 0;

$oTotalEstoqueSintetico->iNumeroLancamentos = $iTotalItensEstoque;
$oTotalEstoqueSintetico->iTotalEstoque      = 0;
$oTotalEstoqueSintetico->iTotal             = 0;

if ($iTotalItensEstoque > 0) {

    for ($iEstoque = 0; $iEstoque < $iTotalItensEstoque; $iEstoque++) {

        /**
         * Buscamos o valor da entrada, preço médio do material
         */
        $oDadosItemEstoque                    = db_utils::fieldsMemory($rsDadosEstoque, $iEstoque);

        if ($oDadosItemEstoque->m71_valor == 0 || $oDadosItemEstoque->m71_quant == 0) {
            continue;
        }

        $oItemEstoque                         = new stdClass();
        $oItemEstoque->iCodigoDepartamento    = $oDadosItemEstoque->codigo_departamento;
        $oItemEstoque->sDescricaoDepartamento = $oDadosItemEstoque->descricao_departamento;
        $oItemEstoque->iCodigoItem            = $oDadosItemEstoque->m60_codmater;
        $oItemEstoque->sDescricaoItem         = $oDadosItemEstoque->m60_descr;
        $oItemEstoque->iQuantidadeEstoque     = 0;
        $oItemEstoque->iQuantidadeAtendida    = 0;
        $oItemEstoque->nValorEstoque          = 0;
        $oItemEstoque->nPrecoMedio            = $oDadosItemEstoque->m71_valor / $oDadosItemEstoque->m71_quant;
        $oItemEstoque->nValorUnitario         = $oDadosItemEstoque->m71_valor / $oDadosItemEstoque->m71_quant;
        $oItemEstoque->iCodigoAlmoxarifado    = $oDadosItemEstoque->codigo_almoxarifado;
        $oItemEstoque->sDescricaoAlmoxarifado = $oDadosItemEstoque->descrisao_almoxarifado;
        $oItemEstoque->iCodigoEstoque         = $oDadosItemEstoque->m71_codmatestoque;
        $oItemEstoque->sLote                  = $oDadosItemEstoque->m77_lote;
        $oItemEstoque->dtValidade             = $oDadosItemEstoque->m77_dtvalidade;
        $oItemEstoque->sFabricante            = $oDadosItemEstoque->fabricante;
        $oItemEstoque->dtMovimento            = $oDadosItemEstoque->data_movimeto;
        $oItemEstoque->iCodigoMovimento       = 0;
        $oItemEstoque->aMovimentacoes         = array();

        /**
         * Buscamos os Movimentos do material
         */
        $oDaoMatEstoqueIni  = db_utils::getDao('matestoqueini');
        $sCamposSaidaItem   = " coalesce(round(m82_quant, 2),0) as quantidade,   ";
        $sCamposSaidaItem  .= " round(m89_precomedio, 4)        as preco_medio,  ";
        $sCamposSaidaItem  .= " round(m89_valorunitario, 4)     as valorunitario, ";
        $sCamposSaidaItem  .= " m81_tipo, ";
        $sCamposSaidaItem  .= " m80_codigo, ";
        $sCamposSaidaItem  .= " m80_codtipo ";
        $sWhereSaidasItens  = " m82_matestoqueitem   = {$oDadosItemEstoque->m71_codlanc} ";
        $sWhereSaidasItens .= $sWhereSaidas;
        $sWhereSaidasItens .= " and m81_tipo in (1, 2) ";
        $sOrdemSaidasItens  = " m80_data,m80_hora, m80_codigo ";

        $sSqlSaidasItens    = $oDaoMatEstoqueIni->sql_query_movimentacoes(null,
            $sCamposSaidaItem,
            $sOrdemSaidasItens,
            $sWhereSaidasItens);
        $rsSaidasItens     = db_query($sSqlSaidasItens) ;
        $iTotalSaidasItens = pg_num_rows($rsSaidasItens);

        /**
         * Busca o saldo anterio do item, se informado um período inicial
         */
        if (isset($oGet->data_inicial) && !empty($oGet->data_inicial)) {

            $sDataInicial          = implode("-", array_reverse(explode("/", $oGet->data_inicial)));
            $sCamposSaldoAnterior  = " sum(coalesce(case when m81_tipo = 1 then round(m82_quant,2) 														  ";
            $sCamposSaldoAnterior .= "                   when m81_tipo = 2 then round(m82_quant,2) *-1 end, 0)) as saldoinicial ";
            $sWhereSaldoAnterior   = " m82_matestoqueitem   = {$oDadosItemEstoque->m71_codlanc} ";
            $sWhereSaldoAnterior  .= " and m80_data < '{$sDataInicial}'";
            $sSqlSaldoAnterior     = $oDaoMatEstoqueIni->sql_query_movimentacoes(null,
                $sCamposSaldoAnterior,
                null,
                $sWhereSaldoAnterior
            );

            $rsSaldoAnterior                   = $oDaoMatEstoqueIni->sql_record($sSqlSaldoAnterior);
            $nSaldoAnterior                    = db_utils::fieldsMemory($rsSaldoAnterior, 0)->saldoinicial;
            $oItemEstoque->iQuantidadeEstoque  = $nSaldoAnterior;
            unset($rsSaldoAnterior);
            unset($nSaldoAnterior);
            unset($oDaoMatEstoqueIni);
        }

        if ($rsSaidasItens && $iTotalSaidasItens > 0) {

            for ($iSaida = 0; $iSaida < $iTotalSaidasItens; $iSaida++) {

                $oDadosSaidaItem                    = db_utils::fieldsMemory($rsSaidasItens, $iSaida);
                $oItemEstoque->nPrecoMedio          = $oDadosSaidaItem->preco_medio;

                if ($oDadosSaidaItem->m81_tipo == 2) {
                    $oItemEstoque->iQuantidadeAtendida += $oDadosSaidaItem->quantidade;
                } else {

                    if (in_array($oDadosSaidaItem->m80_codtipo, $aTiposMovimentoEntrada)) {
                        $oItemEstoque->iCodigoMovimento = $oDadosSaidaItem->m80_codigo;
                    }
                    $oItemEstoque->iQuantidadeEstoque  += $oDadosSaidaItem->quantidade;
                }

                unset($oDadosSaidaItem);
            }
        }

        $iItensEstoque               = ($oItemEstoque->iQuantidadeEstoque * $oItemEstoque->nPrecoMedio);
        $oItemEstoque->nValorEstoque = round($iItensEstoque, 2);

        $aItensEstoque[]             = $oItemEstoque;
        unset($oDadosItemEstoque);
        unset($rsSaidasItens);
    }

    /**
     * Agrupamos os Itens Sinteticamente
     */
    $aDepartamentos = array();
    $aEstoques      = array();
    foreach ($aItensEstoque as $oItemEstoque) {

        if (!isset($aEstoques[$oItemEstoque->iCodigoEstoque])) {

            $aMovimetacoesEstoque                     = array();
            $oEstoque                                 = new stdClass();
            $oEstoque->iCodigoItem                    = $oItemEstoque->iCodigoItem;
            $oEstoque->sDescricaoItem                 = $oItemEstoque->sDescricaoItem;
            $oEstoque->iCodigoAlmoxarifado            = $oItemEstoque->iCodigoAlmoxarifado;
            $oEstoque->sDescricaoAlmoxarifado         = $oItemEstoque->sDescricaoAlmoxarifado;
            $oEstoque->nQuantidadeEstoque             = 0;
            $oEstoque->nPrecoMedio                    = 0;
            $oEstoque->aMovimentacoesEstoque          = array();
            $aEstoques[$oItemEstoque->iCodigoEstoque] = $oEstoque;
        }
        $nQuatidadeEstoque = $oItemEstoque->iQuantidadeEstoque - $oItemEstoque->iQuantidadeAtendida;

        $aEstoques[$oItemEstoque->iCodigoEstoque]->nQuantidadeEstoque     += $nQuatidadeEstoque;
        $aEstoques[$oItemEstoque->iCodigoEstoque]->nPrecoMedio             = $oItemEstoque->nPrecoMedio;
        $aEstoques[$oItemEstoque->iCodigoEstoque]->aMovimentacoesEstoque[] = $oItemEstoque;

        /**
         * Array dos Departamentos
         */
        if (!isset($aDepartamentos[$oItemEstoque->iCodigoDepartamento][$oItemEstoque->iCodigoItem])) {

            $aMovimetacoesDepartamento             = array();
            $oItem                                 = new stdClass();
            $oItem->iCodigoItem                    = $oItemEstoque->iCodigoItem;
            $oItem->sDescricaoItem                 = $oItemEstoque->sDescricaoItem;
            $oItem->iCodigoAlmoxarifado            = $oItemEstoque->iCodigoAlmoxarifado;
            $oItem->sDescricaoAlmoxarifado         = $oItemEstoque->sDescricaoAlmoxarifado;
            $oItem->nQuantidadeEstoque             = 0;
            $oItem->nPrecoMedio                    = 0;
            $aDepartamentos[$oItemEstoque->iCodigoDepartamento][$oItemEstoque->iCodigoItem] = $oItem;
        }
        $nQuatidadeEstoque = $oItemEstoque->iQuantidadeEstoque - $oItemEstoque->iQuantidadeAtendida;

        $aDepartamentos[$oItemEstoque->iCodigoDepartamento][$oItemEstoque->iCodigoItem]->nQuantidadeEstoque     += $nQuatidadeEstoque;
        $aDepartamentos[$oItemEstoque->iCodigoDepartamento][$oItemEstoque->iCodigoItem]->nPrecoMedio             = $oItemEstoque->nPrecoMedio;
        $aDepartamentos[$oItemEstoque->iCodigoDepartamento][$oItemEstoque->iCodigoItem]->aMovimentacoesDepartamento[] = $oItemEstoque;
    }
} else {
    db_redireciona('db_erros.php?fechar=true&db_erro=Não existem registros cadastrados.');
}

header("Content-type: text/plain");
header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=file.csv");
header("Pragma: no-cache");
readfile( 'file.csv' );

if ($oGet->quebrapordepartamento == "N") {

    switch ($oGet->tipoimpressao) {

        case "S": //Sintetico
            $totEstoque = 0;
            foreach ($aEstoques as $oMovimentos) {
//echo "<pre>"; print_r($oMovimentos);
                if ($oGet->verestoquezerado == "N" && $oMovimentos->nQuantidadeEstoque == 0) {
                    continue;
                }

                $aItens[] = $oMovimentos;

                $oMaterial = new MaterialEstoque($oMovimentos->iCodigoItem);
                $nValorEstoque = $oMaterial->getPrecoMedio() * $oMovimentos->nQuantidadeEstoque;

                $oTotal->vlrEstoque += $nValorEstoque;
                $oTotal->qtdEstoque += $oMovimentos->nQuantidadeEstoque * $oMovimentos->nPrecoMedio;

//                    $iCodigoAlmoxarifado = str_pad($oMovimentos->iCodigoAlmoxarifado, 3, " ", STR_PAD_RIGHT);
//                    $sAlmoxarifado = "{$iCodigoAlmoxarifado} - ";
                $oTotalEstoqueSintetico->iTotalEstoque += $oMovimentos->nQuantidadeEstoque;
                $oTotalEstoqueSintetico->iTotal += $nValorEstoque;
                $nValorEstoque = db_formatar($nValorEstoque, "f");
                $nValortotalestoque = db_formatar($oTotal->vlrEstoque, "f");
                $sDescricaoItem = substr($oMovimentos->sDescricaoItem, 0, 65);

                $oDadosDaLinha = new stdClass();
                $oDadosDaLinha->iCodigoItem = $oMovimentos->iCodigoItem;
                $oDadosDaLinha->sDescricaoItem = $sDescricaoItem;
                $oDadosDaLinha->sAlmoxarifado = $oMovimentos->sDescricaoAlmoxarifado;
                $oDadosDaLinha->nQuantidadeEstoque = $oMovimentos->nQuantidadeEstoque;
                $oDadosDaLinha->nValorEstoque = $nValorEstoque;

                echo "$oMovimentos->iCodigoItem ;";
                echo "$sDescricaoItem ;";
                echo "$oMovimentos->sDescricaoAlmoxarifado ;";
                echo "$oMovimentos->nQuantidadeEstoque ;";
                echo "$nValorEstoque ;\n";

            }

            if ($oGet->totalizador == 'sim') {
                getTotalGeralSinteticocsv($aItens);
            }

            break;
        case "A": //Analitico
            $arraymov = array();
            foreach ($aEstoques as $oMovimentos) {
//echo '<pre>';
//print_r($oMovimentos);

                if ($oGet->verestoquezerado == "N" && $oMovimentos->nQuantidadeEstoque == 0) {
                    continue;
                }

                $iCodigoAlmoxarifado = str_pad($oMovimentos->iCodigoAlmoxarifado, 3, " ", STR_PAD_RIGHT);
                $sAlmoxarifado = "{$iCodigoAlmoxarifado} - $oMovimentos->sDescricaoAlmoxarifado";

                $sDescricaoItem = $oMovimentos->sDescricaoItem;
                $sDescricaoItem = ltrim($sDescricaoItem);

                $oMaterial = new MaterialEstoque($oMovimentos->iCodigoItem);
                $nValorEstoque = db_formatar($oMaterial->getPrecoMedio() * $oMovimentos->nQuantidadeEstoque, "f");

                $oDadosDaLinha = new stdClass();
                $oDadosDaLinha->iCodigoItem = $oMovimentos->iCodigoItem;
                $oDadosDaLinha->sDescricaoItem = $oMovimentos->sDescricaoItem;
                $oDadosDaLinha->sDescricaoAlmoxarifado = $sAlmoxarifado;
                $oDadosDaLinha->nQuantidadeEstoque = $oMovimentos->nQuantidadeEstoque;

                echo "$oMovimentos->iCodigoItem ;";
                echo "$oMovimentos->sDescricaoItem ;";
                echo "$sAlmoxarifado ;";
                echo "$oMovimentos->nQuantidadeEstoque ;";
                echo "$nValorEstoque ;\n";

                foreach ($oMovimentos->aMovimentacoesEstoque as $aMovimentoitem) {
                    $oDadosDaLinha->iCodigoMovimento = $aMovimentoitem->iCodigoMovimento;
                    $oDadosDaLinha->dtMovimento = $aMovimentoitem->dtMovimento;
                    $oDadosDaLinha->sLote = $aMovimentoitem->sLote;
                    $oDadosDaLinha->dtValidade = $aMovimentoitem->dtValidade;
                    $oDadosDaLinha->sFabricante = $aMovimentoitem->sFabricante;
                    $oDadosDaLinha->nValorUnitario = $aMovimentoitem->nValorUnitario;
                    $oDadosDaLinha->iQuantidadeEstoque = $aMovimentoitem->iQuantidadeEstoque;
                    $oDadosDaLinha->iQuantidadeAtendida = $aMovimentoitem->iQuantidadeAtendida;
                    $oDadosDaLinha->nValorEstoque = $aMovimentoitem->nValorEstoque;

                    $dataformatada = formataData($aMovimentoitem->dtValidade);
                    $dataformatadamov = formataData($aMovimentoitem->dtMovimento);

                    echo "$aMovimentoitem->iCodigoMovimento ;";
                    echo "$dataformatadamov ;";
                    echo "$aMovimentoitem->sLote ;";
                    echo "$dataformatada ;";
                    echo "$aMovimentoitem->sFabricante ;";
                    echo db_formatar($aMovimentoitem->nValorUnitario,"f")." ;";
                    echo "$aMovimentoitem->iQuantidadeEstoque ;";
                    echo "$aMovimentoitem->iQuantidadeAtendida ;";
                    echo db_formatar($aMovimentoitem->nValorEstoque,"f")." ;\n";

                }

            }
//die();
            break;

        case "C":

            foreach ($aEstoques as $oMovimentos) {

                if ($oGet->verestoquezerado == "N" && $oMovimentos->nQuantidadeEstoque == 0) {
                    continue;
                }
                $oMaterial = new MaterialEstoque($oMovimentos->iCodigoItem);
                $nValorEstoque = $oMaterial->getPrecoMedio() * $oMovimentos->nQuantidadeEstoque;

                $oTotal->vlrEstoque += $nValorEstoque;

                $iCodigoAlmoxarifado = str_pad($oMovimentos->iCodigoAlmoxarifado, 3, " ", STR_PAD_RIGHT);
                $sAlmoxarifado = "{$iCodigoAlmoxarifado} - $oMovimentos->sDescricaoAlmoxarifado";
                $nValorEstoque = $oMovimentos->nQuantidadeEstoque * $oMovimentos->nPrecoMedio;
                $oTotalEstoqueSintetico->iTotalEstoque += $oMovimentos->nQuantidadeEstoque;
                $oTotalEstoqueSintetico->iTotal += $nValorEstoque;
                $nValorEstoque = db_formatar($nValorEstoque, "f");
                $nValortotalestoque = db_formatar($oTotal->vlrEstoque, "f");
                $sDescricaoItem = substr($oMovimentos->sDescricaoItem, 0, 65);

                $oDadosDaLinha = new stdClass();
                $oDadosDaLinha->iCodigoItem = $oMovimentos->iCodigoItem;
                $oDadosDaLinha->sDescricaoItem = $sDescricaoItem;
                $oDadosDaLinha->sAlmoxarifado = $sAlmoxarifado;
                $oDadosDaLinha->nQuantidadeEstoque = $oMovimentos->nQuantidadeEstoque;
                $oDadosDaLinha->nValorEstoque = $nValorEstoque;

                echo "$oMovimentos->iCodigoItem ;";
                echo "$sDescricaoItem ;";
                echo "$sAlmoxarifado ;";
                echo "$oMovimentos->nQuantidadeEstoque ;";
                echo "________ ;";
                echo "$nValorEstoque ;\n";
            }

            break;
    }
}else{

    switch ($oGet->tipoimpressao) {

        case "S": // Sintético

            foreach ($aDepartamentos as $aDepartamento) {

                $oTotalEstoqueSintetico->iTotalIteracao = 0;
                $oTotalEstoqueSintetico->valorTotal = 0;
                $oTotalEstoqueSintetico->quant             = 0;
                //echo count($aDepartamento);exit;

                foreach ($aDepartamento as $oMovimentos) {

                    getDadosSinteticoQuebracsv($oMovimentos, $oTotalEstoqueSintetico, $oGet);

                }
                $oTotalEstoqueSintetico->iNumero +=  $oTotalEstoqueSintetico->iTotalIteracao;
                if($oTotalEstoqueSintetico->iTotalIteracao != 0){
                    getTotalizadorSinteticoPorDepartcsv($oTotalEstoqueSintetico->iTotalIteracao, $oTotalEstoqueSintetico->quant, $oTotalEstoqueSintetico->valorTotal);
                }
            }
            getTotalizadorSinteticocsv($oTotalEstoqueSintetico);
            break;
        case "A": // Analítica
            $arraymov = array();
            foreach ($aDepartamentos as $aDepartamento) {

                foreach ($aDepartamento as $oMovimentos) {

                    if ($oGet->verestoquezerado == "N" && $oMovimentos->nQuantidadeEstoque == 0) {
                        continue;
                    }

                    $iCodigoAlmoxarifado = str_pad($oMovimentos->iCodigoAlmoxarifado, 3, " ", STR_PAD_RIGHT);
                    $sAlmoxarifado = "{$iCodigoAlmoxarifado} - $oMovimentos->sDescricaoAlmoxarifado";

                    $sDescricaoItem = $oMovimentos->sDescricaoItem;
                    $sDescricaoItem = ltrim($sDescricaoItem);

                    $oMaterial = new MaterialEstoque($oMovimentos->iCodigoItem);
                    $nValorEstoque = db_formatar($oMaterial->getPrecoMedio() * $oMovimentos->nQuantidadeEstoque, "f");

                    $oDadosDaLinha = new stdClass();
                    $oDadosDaLinha->iCodigoItem = $oMovimentos->iCodigoItem;
                    $oDadosDaLinha->sDescricaoItem = $oMovimentos->sDescricaoItem;
                    $oDadosDaLinha->sDescricaoAlmoxarifado = $sAlmoxarifado;
                    $oDadosDaLinha->nQuantidadeEstoque = $oMovimentos->nQuantidadeEstoque;

                    echo "$oMovimentos->iCodigoItem ;";
                    echo "$oMovimentos->sDescricaoItem ;";
                    echo "$sAlmoxarifado ;";
                    echo "$oMovimentos->nQuantidadeEstoque ;";
                    echo "$nValorEstoque ;\n";

                    foreach ($oMovimentos->aMovimentacoesDepartamento as $aMovimentoitem) {
                        $oDadosDaLinha->iCodigoMovimento = $aMovimentoitem->iCodigoMovimento;
                        $oDadosDaLinha->dtMovimento = $aMovimentoitem->dtMovimento;
                        $oDadosDaLinha->sLote = $aMovimentoitem->sLote;
                        $oDadosDaLinha->dtValidade = $aMovimentoitem->dtValidade;
                        $oDadosDaLinha->sFabricante = $aMovimentoitem->sFabricante;
                        $oDadosDaLinha->nValorUnitario = $aMovimentoitem->nValorUnitario;
                        $oDadosDaLinha->iQuantidadeEstoque = $aMovimentoitem->iQuantidadeEstoque;
                        $oDadosDaLinha->iQuantidadeAtendida = $aMovimentoitem->iQuantidadeAtendida;
                        $oDadosDaLinha->nValorEstoque = $aMovimentoitem->nValorEstoque;

                        $dataformatada = formataData($aMovimentoitem->dtValidade);

                        echo "$aMovimentoitem->iCodigoMovimento ;";
                        echo "$aMovimentoitem->dtMovimento ;";
                        echo "$aMovimentoitem->sLote ;";
                        echo "$dataformatada ;";
                        echo "$aMovimentoitem->sFabricante ;";
                        echo db_formatar($aMovimentoitem->nValorUnitario,"f")." ;";
                        echo "$aMovimentoitem->iQuantidadeEstoque ;";
                        echo "$aMovimentoitem->iQuantidadeAtendida ;";
                        echo db_formatar($aMovimentoitem->nValorEstoque,"f")." ;\n";

                    }
                }
            }
            break;
        case "C": // Conferência

            foreach ($aDepartamentos as $aDepartamento) {

                $iContador = 0;
                foreach ($aDepartamento as $oMovimentos) {

                    getDadosSinteticocsv($oMovimentos,$oGet);

                }
            }
            break;
    }
}

function getTotalGeralSinteticocsv($aItens) {

    $oTotal = new stdClass();
    $oTotal->qtdEstoque = 0;
    $oTotal->vlrEstoque = 0;

    foreach ($aItens as $oMovimentos) {

        $oMaterial     = new MaterialEstoque($oMovimentos->iCodigoItem);
        $nValorEstoque = $oMaterial->getPrecoMedio() * $oMovimentos->nQuantidadeEstoque;

        $oTotal->qtdEstoque += $oMovimentos->nQuantidadeEstoque;
        $oTotal->vlrEstoque += $nValorEstoque;

    }
    echo "Total: ;";
    echo " ;";
    echo " ;";
    echo "$oTotal->qtdEstoque ;";
    echo db_formatar($oTotal->vlrEstoque, "f") . ";";
}

function getDadosSinteticoQuebracsv($oMovimentos, $oTotalEstoqueSintetico, $oGet) {

    if ($oGet->verestoquezerado == "N" && $oMovimentos->nQuantidadeEstoque == 0) {
        return false;
    }

    $iCodigoAlmoxarifado = str_pad($oMovimentos->iCodigoAlmoxarifado, 3, " ", STR_PAD_RIGHT);
    $sAlmoxarifado       = "{$iCodigoAlmoxarifado} - $oMovimentos->sDescricaoAlmoxarifado";
    $nValorEstoque       = $oMovimentos->nQuantidadeEstoque * $oMovimentos->nPrecoMedio;

    $oTotalEstoqueSintetico->iTotalEstoque += $oMovimentos->nQuantidadeEstoque;
    $oTotalEstoqueSintetico->iTotal        += $nValorEstoque;

    //ADD dia 06-05-2015
    $oTotalEstoqueSintetico->iTotalIteracao++;
    $oTotalEstoqueSintetico->quant += $oMovimentos->nQuantidadeEstoque;
    $oTotalEstoqueSintetico->valorTotal += $nValorEstoque;
    //******************************************************************

    $nValorEstoque       = $nValorEstoque;
    $sDescricaoItem      = substr($oMovimentos->sDescricaoItem, 0, 65);

    $oMaterial     = new MaterialEstoque($oMovimentos->iCodigoItem);

    //impressao das linhas

    echo $oMovimentos->iCodigoItem." ;";
    echo $sDescricaoItem." ;";
    echo $sAlmoxarifado." ;";
    echo $oMovimentos->nQuantidadeEstoque." ;";
    echo db_formatar($nValorEstoque,"f").";\n";

    return true;
}

function getTotalizadorSinteticoPorDepartcsv($oTotalRegistros,$nEstoque, $valorTotal) {
    echo "Total do departamento:".$oTotalRegistros." ;";
    echo " ;";
    echo " ;";
    echo $nEstoque." ;";
    echo db_formatar($valorTotal,"f").";\n";
}

function getTotalizadorSinteticocsv($oTotalEstoqueSintetico) {

    echo "Total de Registros:".$oTotalEstoqueSintetico->iNumero." ;";
    echo " ;";
    echo " ;";
    echo $oTotalEstoqueSintetico->iTotalEstoque." ;";
    echo db_formatar($oTotalEstoqueSintetico->iTotal,"f").";\n";
}

function getDadosSinteticocsv($oMovimentos, $oGet){

    if ($oGet->verestoquezerado == "N" && $oMovimentos->nQuantidadeEstoque == 0) {
        return false;
    }

    $iCodigoAlmoxarifado = str_pad($oMovimentos->iCodigoAlmoxarifado, 3, " ", STR_PAD_RIGHT);
    $sAlmoxarifado       = "{$iCodigoAlmoxarifado} - $oMovimentos->sDescricaoAlmoxarifado";

    $sDescricaoItem= $oMovimentos->sDescricaoItem;
    $sDescricaoItem= ltrim($sDescricaoItem);

    $oMaterial     = new MaterialEstoque($oMovimentos->iCodigoItem);
    $nValorEstoque = number_format($oMaterial->getPrecoMedio() * $oMovimentos->nQuantidadeEstoque, 2);

    echo $oMovimentos->iCodigoItem." ;";
    echo $sDescricaoItem." ;";
    echo $sAlmoxarifado." ;";
    echo $oMovimentos->nQuantidadeEstoque." ;";
    echo $nValorEstoque." ;\n";

    return true;
}

function getDadoAnaliticocsv($oItens) {

    $nValorUnitario = number_format($oItens->nValorUnitario, 2);
    $nValorEstoque  = number_format($oItens->nValorEstoque, 2);
    $dtMovimento    = formataData($oItens->dtMovimento);
    $dtValidade     = formataData($oItens->dtValidade);

    echo $oItens->iCodigoMovimento." ;";
    echo $dtMovimento             ." ;";
    echo $oItens->sLote           ." ;";
    echo $dtValidade              ." ;";
    echo $oItens->sFabricante     ." ;";
    echo $nValorUnitario          ." ;";
    echo $oItens->iQuantidadeEstoque." ;";
    echo $oItens->iQuantidadeAtendida." ;";
    echo $nValorEstoque.";\n";
}

function formataData($dtData, $sSearch = "-", $sReplace = "/") {

    return implode("/", array_reverse(explode("-", $dtData)));
}


?>
