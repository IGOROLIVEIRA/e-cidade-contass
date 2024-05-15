<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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

require_once("libs/db_utils.php");
require_once("fpdf151/pdf.php");
//include_once("std/DBDate.php");

try {

    $oGet                  = db_utils::postMemory($_GET);
    $iInstituicao          = db_getsession('DB_instit');
    $aCodigosAlmoxarifados = array();
    $aCodigosMateriais     = array();
    $oPeriodoInicial       = null;
    $lMaterialImpresso     = false;
    $iAlmoxarifadoAnterior = null;
    $totalizador           = $oGet->totalizador;

    if (!empty($oGet->periodoInicial)) {
        $oPeriodoInicial = new DBDate($oGet->periodoInicial);
    }

    /**
     * Periodo final, caso nao informado pega data atual
     */
    if (!empty($oGet->periodoFinal)) {
        $oPeriodoFinal = new DBDate($oGet->periodoFinal);
    } else {
        $oPeriodoFinal = new DBDate(date('Y-m-d', db_getsession('DB_datausu')));
    }

    $head2 = "Controle de estoque";

    if (!empty($oGet->periodoInicial)) {
        $head4 = "Período: " . $oPeriodoInicial->getDate(DBdate::DATA_PTBR) . ' a ' . $oPeriodoFinal->getDate(DBdate::DATA_PTBR);
    } else {
        $head4 = "Período final: " . $oPeriodoFinal->getDate(DBdate::DATA_PTBR);
    }

    /**
     * Periodo final, caso nao informado pega data atual
     */
    if (!empty($oGet->periodoFinal)) {
        $oPeriodoFinal = new DBDate($oGet->periodoFinal);
    } else {
        $oPeriodoFinal = new DBDate(date('Y-m-d', db_getsession('DB_datausu')));
    }

    $lQuebraPorAlmoxarifado   = $oGet->quebraPorAlmoxarifado == 1;
    $somenteItensComMovimento = $oGet->somenteItensComMovimento == 1;
    $sOrdem                   = $oGet->ordem;
    $sTipoImpressao           = $oGet->tipoImpressao;
    $sdeMaterial              = $oGet->sdeMaterial;
    $sateMaterial             = $oGet->sateMaterial;


    if (!empty($oGet->sAlmoxarifados)) {
        $aCodigosAlmoxarifados = explode(',', $oGet->sAlmoxarifados);
    }

    if (!empty($oGet->sMateriais)) {
        $aCodigosMateriais = explode(',', $oGet->sMateriais);
    }


    $head5 = 'Quebra por almoxarifado: ' . ($lQuebraPorAlmoxarifado ? 'Sim' : 'Não');
    $head6 = 'Somente itens com movimento: ' . ($somenteItensComMovimento ? 'Sim' : 'Não');
    $head7 = 'Ordem: ' . $sOrdem;
    $head8 = 'Tipo de impressão: ' . $oGet->tipoImpressao;
    if ($totalizador == 'sim') {
        $head9 = 'Totalizador: Sim';
    } else {
        $head9 = 'Totalizador: Não';
    }

    echo $head2." ;";
    echo $head4." ;";
    echo $head5." ;";
    echo $head6." ;";
    echo $head7." ;";
    echo $head8." ;";
    echo $head9." ;\n";

    if($oGet->tipoImpressao == "conferencia"){
        if($oGet->quebraPorAlmoxarifado == 1){
        echo "Almoxarifado ;\n";
        }
        echo "Material ;";
        echo "Almoxarifado ;";
        echo "Quantidade ;";
        echo "Contagem ;";
        echo "Valor final ;\n";
    }else{

        echo "Código ;";
        echo "Descrição ;";
        echo "Quantidade Anterior ;";
        echo "Valor Anterior ;";
        echo "Quantidade Entradas ;";
        echo "Valor Entradas ;";
        echo "Quantidade Saidas ;";
        echo "Valor Saidas ;";
        echo "Quantidade Saldo ;";
        echo "Valor Saldo ;\n";
    }

    /**
     * Pesquisa almoxarifado
     * - nenhum almoxarifado inforamdo
     *   - caso for informado algum material, pesquisa almoxarifado destes itens
     *   - caso não for inforamdo nenhum material, pesquisa todos os almoxarifados para instituicao atual
     */
    if (empty($aCodigosAlmoxarifados)) {

        /**
         * Nenhum material informado, pesquisa todas os almoxarifados da instituicao atual
         */
        if (empty($aCodigosMateriais) && empty($sdeMaterial) && empty($sateMaterial)) {

            $oDaoMatestoque    = new cl_matestoque();
            $sSqlAlmoxarifados = $oDaoMatestoque->sql_query_almoxarifado('distinct m70_coddepto', null, "db_depart.instit = $iInstituicao");
            $rsAlmoxarifados   = $oDaoMatestoque->sql_record($sSqlAlmoxarifados);

            if ($oDaoMatestoque->erro_status == '0') {
                throw new Exception(_M('patrimonial.material.mat2_controleestoque002.nenhum_almoxarifado_encontrado'));
            }

            foreach (db_utils::getCollectionByRecord($rsAlmoxarifados) as $oDadosAlmoxarifado) {
                $aCodigosAlmoxarifados[] = $oDadosAlmoxarifado->m70_coddepto;
            }
        }

        /**
         * Material informado, pesquisa os almoxarifados destes
         */
        if (!empty($aCodigosMateriais) || (!empty($sdeMaterial) && !empty($sateMaterial))) {

            $oDaoMatestoque = new cl_matestoque();

            if (!empty($sdeMaterial) && !empty($sateMaterial)) {
                $sWhereAlmoxarifados = "m70_codmatmater >= $sdeMaterial AND m70_codmatmater <= $sateMaterial";
            } else {
                $sWhereAlmoxarifados = 'm70_codmatmater in(' . implode(',', $aCodigosMateriais) . ')';
            }

            $sSqlAlmoxarifados = $oDaoMatestoque->sql_query_almoxarifado('distinct m70_coddepto', null, $sWhereAlmoxarifados);
            $rsAlmoxarifados   = $oDaoMatestoque->sql_record($sSqlAlmoxarifados);

            if ($oDaoMatestoque->erro_status == '0') {
                throw new Exception(_M('patrimonial.material.mat2_controleestoque002.nenhum_almoxarifado_encontrado_pelo_item'));
            }

            foreach (db_utils::getCollectionByRecord($rsAlmoxarifados) as $oDadosAlmoxarifado) {
                $aCodigosAlmoxarifados[] = $oDadosAlmoxarifado->m70_coddepto;
            }
        }

    }

    /**
     * Nenhum material informado
     * - busca todos os materias de cada almoxarifado
     */
    if (empty($aCodigosMateriais) && empty($sdeMaterial) && empty($sateMaterial)) {

        $oDaoMatestoque = new cl_matestoque();
        $sWhereItens    = 'm70_coddepto in(' . implode(',', $aCodigosAlmoxarifados) . ')';
        if (!empty($oGet->ativos) && $oGet->ativos != 'i') {
            $sWhereItens .= " and (SELECT m60_ativo FROM matmater WHERE m60_codmater = m70_codmatmater) = '{$oGet->ativos}' ";
        }
        $sSqlItens = $oDaoMatestoque->sql_query_almoxarifado('m70_codmatmater', null, $sWhereItens);
        $rsItens   = $oDaoMatestoque->sql_record($sSqlItens);

        if ($oDaoMatestoque->erro_status == '0') {
            throw new Exception(_M('patrimonial.material.mat2_controleestoque002.nenhum_item_encontrado'));
        }

        foreach (db_utils::getCollectionByRecord($rsItens) as $oDadosItem) {
            $aCodigosMateriais[] = $oDadosItem->m70_codmatmater;
        }
    }
    if (!empty($aCodigosMateriais) || (!empty($sdeMaterial) && !empty($sateMaterial))) {

        $oDaoMatestoque = new cl_matestoque();

        if (!empty($sdeMaterial) && !empty($sateMaterial)) {
            $sWhereItens = "m70_codmatmater >= $sdeMaterial AND m70_codmatmater <= $sateMaterial";
        } else {
            $sWhereItens = 'm70_codmatmater in(' . implode(',', $aCodigosMateriais) . ')';
        }

        if (!empty($oGet->ativos) && $oGet->ativos != 'i') {
            $sWhereItens .= " and (SELECT m60_ativo FROM matmater WHERE m60_codmater = m70_codmatmater) = '{$oGet->ativos}' ";
        }
        $sSqlItens = $oDaoMatestoque->sql_query_almoxarifado('m70_codmatmater', null, $sWhereItens);
        $rsItens   = $oDaoMatestoque->sql_record($sSqlItens);
        if ($oDaoMatestoque->erro_status == '0') {
            throw new Exception(_M('patrimonial.material.mat2_controleestoque002.nenhum_item_encontrado'));
        }

        foreach (db_utils::getCollectionByRecord($rsItens) as $oDadosItem) {
            $aCodigosMateriais[] = $oDadosItem->m70_codmatmater;
        }
    }

    $oControleEstoque = new ControleEstoque();
    $oControleEstoque->setPeriodo($oPeriodoInicial, $oPeriodoFinal);

    foreach ($aCodigosAlmoxarifados as $iAlmoxarifado) {
        $oControleEstoque->adicionarAlmoxarifado(new Almoxarifado($iAlmoxarifado));
    }

    foreach ($aCodigosMateriais as $iMaterial) {
        $oControleEstoque->adicionarItem(new Item($iMaterial));
    }

    $aMovimentacoes = $oControleEstoque->getMovimentacaoEstoqueSintetica();

    $aDadosMovimentacoes    = array();
    $aOrdenacaoCodigo       = array();
    $aOrdenacaoNome         = array();
    $aOrdenacaoAlmoxarifado = array();

    foreach ($aMovimentacoes as $oMovimentacao) {

        $aDadosMovimentacoes[]    = $oMovimentacao;
        $aOrdenacaoCodigo[]       = $oMovimentacao->getItem()->getCodigo();
        $aOrdenacaoNome[]         = $oMovimentacao->getItem()->getNome();
        $aOrdenacaoAlmoxarifado[] = $oMovimentacao->getAlmoxarifado()->getCodigo();
    }

    /**
     * Ordena de acordo com filtro
     */
    switch ($sOrdem) {

        case 'alfabetica':
            array_multisort($aOrdenacaoNome, SORT_STRING, $aOrdenacaoCodigo, SORT_ASC, $aDadosMovimentacoes);
            break;

        case 'codigo':
            array_multisort($aOrdenacaoCodigo, SORT_ASC, $aOrdenacaoNome, SORT_STRING, $aDadosMovimentacoes);
            break;

        default:
        case 'almoxarifado':
            array_multisort($aOrdenacaoAlmoxarifado, SORT_ASC, $aOrdenacaoNome, SORT_ASC, $aDadosMovimentacoes);
            break;
    }

    /**
     * Nao quebra por almoxarifado
     * - soma itens
     * - quanto tipo de impressao for sintetico
     */
    if (!$lQuebraPorAlmoxarifado && $tipoImpressao == 'sintetico') {

        /**
         * Zera array de movimentacoes para adicionar as movimentacoes somadas
         */
        ///$aDadosMovimentacoes = array();

        /**
         * Agrupa movimentacoes por material para somalos
         */
        $aMovimentacoesPorMaterial = array();

        /**
         * Agrupa movimentacoes pelo codigo do material
         */
        foreach ($aDadosMovimentacoes as $oMovimentacao) {
            $aMovimentacoesPorMaterial[$oMovimentacao->getItem()->getCodigo()][] = $oMovimentacao;
        }

        /**
         * Percorre as movimentacoes de cada material e soma adicionanando no array de movimentacoes, $aDadosMovimentacoes
         */
        foreach ($aMovimentacoesPorMaterial as $iMaterial => $aDadosMovimentacoesPorMaterial) {

            $nValorAnterior      = 0;
            $nQuantidadeAnterior = 0;
            $nQuantidadeEntrada  = 0;
            $nQuantidadeSaida    = 0;
            $nValorEntrada       = 0;
            $nValorSaida         = 0;

            foreach ($aDadosMovimentacoesPorMaterial as $oMovimentacaoPorMaterial) {

                $nValorAnterior += $oMovimentacaoPorMaterial->getValorAnterior();
                $nQuantidadeAnterior += $oMovimentacaoPorMaterial->getQuantidadeAnterior();
                $nQuantidadeEntrada += $oMovimentacaoPorMaterial->getQuantidadeEntrada();
                $nQuantidadeSaida += $oMovimentacaoPorMaterial->getQuantidadeSaida();
                $nValorEntrada += $oMovimentacaoPorMaterial->getValorEntrada();
                $nValorSaida += $oMovimentacaoPorMaterial->getValorSaida();
            }

            $oMovimentacaoPorMaterial->setValorAnterior($nValorAnterior);
            $oMovimentacaoPorMaterial->setValorSaida($nValorSaida);
            $oMovimentacaoPorMaterial->setValorEntrada($nValorEntrada);
            $oMovimentacaoPorMaterial->setQuantidadeAnterior($nQuantidadeAnterior);
            $oMovimentacaoPorMaterial->setQuantidadeEntrada($nQuantidadeEntrada);
            $oMovimentacaoPorMaterial->setQuantidadeSaida($nQuantidadeSaida);

            $aDadosMovimentacoes[] = $oMovimentacaoPorMaterial;
        }
    }

    if (empty($aDadosMovimentacoes)) {
        throw new Exception(_M('patrimonial.material.mat2_controleestoque002.nenhuma_movimentacao_encontrada'));
    }

    $oDados                         = new StdClass();
    $oDados->sPeriodoInicial        = !empty($oPeriodoInicial) ? $oPeriodoInicial->getDate(DBdate::DATA_PTBR) : null;
    $oDados->sPeriodoFinal          = $oPeriodoFinal->getDate(DBdate::DATA_PTBR);
    $oDados->lQuebraPorAlmoxarifado = $lQuebraPorAlmoxarifado;

    $nContador           = count($aDadosMovimentacoes);
    $tQuantidadeAnterior = 0;
    $tValorAnterior      = 0;
    $tQuantidadeEntrada  = 0;
    $tValorEntrada       = 0;
    $tQuantidadeSaida    = 0;
    $tValorSaida         = 0;
    $tValorFinal         = 0;
    $tQuantidadeFinal    = 0;
    header("Content-type: text/plain");
    header("Content-type: application/csv");
    header("Content-Disposition: attachment; filename=file.csv");
    header("Pragma: no-cache");
    readfile( 'file.csv' );
    switch ($oGet->tipoImpressao){
        case "conferencia":
            $arrayalmox = array();
            $iTotalFinal = 0;
            $iTotalQtd = 0;
            foreach ($aDadosMovimentacoes as $oMovimentacao) {

                $nQuantidadeFinal = $oMovimentacao->getQuantidadeAnterior() + $oMovimentacao->getQuantidadeEntrada() - $oMovimentacao->getQuantidadeSaida();
                if ($nQuantidadeFinal == 0) {
                    $nValorFinal = 0;
                } else {
                    $nValorFinal = $oMovimentacao->getValorAnterior() + $oMovimentacao->getValorEntrada() - $oMovimentacao->getValorSaida();
                }
                /**
                 * Nao exibe matareiais sem movimentacao no periodo
                 */
                if ($somenteItensComMovimento && $oMovimentacao->getValorEntrada() <= 0 && $oMovimentacao->getValorSaida() <= 0) {
                    continue;
                }

                $oDadosDaLinha = new stdClass();
                $oDadosDaLinha->iMaterial           = $oMovimentacao->getItem()->getCodigo();
                $oDadosDaLinha->iDescricaomaterial  = $oMovimentacao->getItem()->getNome();
                $oDadosDaLinha->iQuantidade         = $oMovimentacao->getAlmoxarifado()->getNomeDepartamento();
                $oDadosDaLinha->nQuantidadeFinal    = $nQuantidadeFinal;
                $oDadosDaLinha->nValorFinal         = $nValorFinal;
                $almoxarifado                       = $oMovimentacao->getAlmoxarifado()->getCodigo();

                //totais
                $iTotalQtd      += $nQuantidadeFinal;
                $iTotalFinal    += $nValorFinal;

                //almoxarifado
                if($oGet->quebraPorAlmoxarifado == 1) {
                    if (!$arrayalmox[$almoxarifado]) {
                        echo $oMovimentacao->getAlmoxarifado()->getCodigo() . "-" . $oMovimentacao->getAlmoxarifado()->getNomeDepartamento() . ";\n";
                    }
                }
                //dados do relatorio
                echo $oMovimentacao->getItem()->getCodigo()."-".$oMovimentacao->getItem()->getNome()."; ";
                echo $oMovimentacao->getAlmoxarifado()->getCodigo() . "-" . $oMovimentacao->getAlmoxarifado()->getNomeDepartamento()." ;";
                echo $nQuantidadeFinal.";";
                echo " ;";
                echo db_formatar($nValorFinal,"f").";\n";

                $arrayalmox[$almoxarifado] = $almoxarifado;
            }
            //totalizador
            if($totalizador == 'sim') {
                echo "TOTALIZADOR: ;";
                echo " ;";
                echo "$iTotalQtd ;";
                echo " ;";
                echo db_formatar($iTotalFinal,"f")." ;\n";
            }
            break;

        case "sintetico":
            $arrayalmox = array();

            $tot_qtdanterior = 0;
            $tot_vlranterior = 0;
            $tot_qtdentrada  = 0;
            $tot_vlrentrada  = 0;
            $tot_qtdsaida    = 0;
            $tot_vlrsaida    = 0;
            $tot_quantidade  = 0;
            $tot_saldo       = 0;

            foreach ($aDadosMovimentacoes as $oMovimentacao) {

                $oDadosDaLinha = new stdClass();
                $oDadosDaLinha->iMaterial = $oMovimentacao->getItem()->getCodigo();
                $oDadosDaLinha->sMaterial = $oMovimentacao->getItem()->getNome();
                $oDadosDaLinha->iAlmoxarifado = $oMovimentacao->getAlmoxarifado()->getCodigo();
                $oDadosDaLinha->sAlmoxarifado = $oMovimentacao->getAlmoxarifado()->getNomeDepartamento();
                $oDadosDaLinha->nQuantidadeAnterior = $oMovimentacao->getQuantidadeAnterior();
                $oDadosDaLinha->nValorAnterior = $oMovimentacao->getValorAnterior();
                $oDadosDaLinha->nQuantidadeEntrada = $oMovimentacao->getQuantidadeEntrada();
                $oDadosDaLinha->nValorEntrada = $oMovimentacao->getValorEntrada();
                $oDadosDaLinha->nQuantidadeSaida = $oMovimentacao->getQuantidadeSaida();
                $oDadosDaLinha->nValorSaida = $oMovimentacao->getValorSaida();

                $oDadosDaLinha->lImprimirCabecalho = false;

                $nQuantidadeFinal = $oMovimentacao->getQuantidadeAnterior() + $oMovimentacao->getQuantidadeEntrada() - $oMovimentacao->getQuantidadeSaida();
                if ($nQuantidadeFinal == 0) {
                    $nValorFinal = 0;
                } else {
                    $nValorFinal = $oMovimentacao->getValorAnterior() + $oMovimentacao->getValorEntrada() - $oMovimentacao->getValorSaida();
                }
                /**
                 * Nao exibe matareiais sem movimentacao no periodo
                 */
                if ($somenteItensComMovimento && $oMovimentacao->getValorEntrada() <= 0 && $oMovimentacao->getValorSaida() <= 0) {
                    continue;
                }

                $oDadosDaLinha->nValorFinal = $nValorFinal;
                $oDadosDaLinha->nQuantidadeFinal = $nQuantidadeFinal;
                $almoxarifado = $oMovimentacao->getAlmoxarifado()->getCodigo();

                $tot_qtdanterior += $oMovimentacao->getQuantidadeAnterior();
                $tot_vlranterior += $oMovimentacao->getValorAnterior();
                $tot_qtdentrada  += $oMovimentacao->getQuantidadeEntrada();
                $tot_vlrentrada  += $oMovimentacao->getValorEntrada();
                $tot_qtdsaida    += $oMovimentacao->getQuantidadeSaida();
                $tot_vlrsaida    += $oMovimentacao->getValorSaida();
                $tot_quantidade  += $nQuantidadeFinal;
                $tot_saldo       += $nValorFinal;

                //almoxarifado
                if($oGet->quebraPorAlmoxarifado == 1){
                    if(!$arrayalmox[$almoxarifado]) {
                        echo $oMovimentacao->getAlmoxarifado()->getCodigo() . "-" . $oMovimentacao->getAlmoxarifado()->getNomeDepartamento() . ";\n";
                    }
                }

                //dados do relatorio
                echo $oMovimentacao->getItem()->getCodigo()."; ";
                echo $oMovimentacao->getItem()->getNome()."; ";
                echo $oMovimentacao->getQuantidadeAnterior() == null ? 0 ."; " : $oMovimentacao->getQuantidadeAnterior() . "; ";
                echo db_formatar($oMovimentacao->getValorAnterior(),"f") . "; ";
                echo $oMovimentacao->getQuantidadeEntrada() == null ? 0 ."; " : $oMovimentacao->getQuantidadeEntrada() . "; ";
                echo db_formatar($oMovimentacao->getValorEntrada(),"f") . "; ";
                echo $oMovimentacao->getQuantidadeSaida() == null ? 0 ."; " : $oMovimentacao->getQuantidadeSaida() . "; ";
                echo db_formatar($oMovimentacao->getValorSaida(),"f") . "; ";
                echo $nQuantidadeFinal . ";";
                echo db_formatar($nValorFinal,"f") . ";\n";

                $arrayalmox[$almoxarifado] = $almoxarifado;
            }
            if($totalizador == 'sim') {
                echo "TOTALIZADOR: ;";
                echo " ;";
                echo "$tot_qtdanterior ;";
                echo db_formatar($tot_vlranterior,"f")." ;";
                echo "$tot_qtdentrada ;";
                echo db_formatar($tot_vlrentrada,"f")." ;";
                echo "$tot_qtdsaida ;";
                echo db_formatar($tot_vlrsaida,"f")." ;";
                echo "$tot_quantidade ;";
                echo db_formatar($tot_saldo,"f")." ;\n";
            }
            break;
    }
}
catch (Exception $oErro) {

    $sMensagemErro = nl2br($oErro->getMessage());
    db_redireciona('db_erros.php?fechar=true&db_erro=' . urlEncode($sMensagemErro));
}
