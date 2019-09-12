<?php

require_once("con2_execucaodecontratosaux.php");

function execucaoDeContratosQuebraPorAditivoEmpenho($aMateriais,$iFonte,$iAlt,$iAcordo,$oPdf,$iQuebra,$ac16_datainicio = null,$ac16_datafim = null){
    $oAcordo    = new Acordo($iAcordo);
    $oExecucaoDeContratos = new ExecucaoDeContratos();
    $aPosicoes   = $oAcordo->getPosicoes();
    $iTotalDeRegistros = null;

    if(empty($aPosicoes) || count($aPosicoes) < 2){
        db_redireciona("db_erros.php?fechar=true&db_erro=Nenhum registro encontrado!");
    }

    $aLicitacoesVinculadas = $oAcordo->getLicitacoes();
    $iQtdAnulada = 0;
    $iNumItens = 0;

    $oExecucaoDeContratos->imprimirCabecalhoAcordos($oPdf, $iAlt, $iFonte, $oAcordo, $aLicitacoesVinculadas);

    // Percorre todas as posições de um acordo
    foreach ($aPosicoes as $iKp => $oPosicao) {

        $lImprimeCabecalhoPosicao = true;
        $aEmpenhosPosicao = ExecucaoDeContratos::empenhosDeUmaPosicao($oPosicao->getCodigo(),$ac16_datainicio,$ac16_datafim);

        foreach($aEmpenhosPosicao as $iJ => $oEmpenhamento){

            if(empty($oEmpenhamento->e61_numemp)){
                continue;
            }

            $aEmpenho = $oExecucaoDeContratos->consultarItensEmpenho((int)$oEmpenhamento->e61_numemp);
            $iNumItens += count($aEmpenho);
            foreach($aEmpenho as $iK => $oItem){
                $iQtdEmpenhada = (int)$oItem->quantidade;

                foreach($oExecucaoDeContratos->itensAnulados(
                    (int)$oEmpenhamento->e61_numemp,
                    (int)$oItem->codigo_material
                ) as $oAnulado){
                    $iQtdAnulada += (int)$oAnulado->quantidade;
                }

                if(empty($oItem->codigo_material)){
                    continue;
                }

                $dQuantidadeEmOrdemDeCompra = ExecucaoDeContratos::quantidadeTotalEmOrdensDeCompra(
                    (int)$oEmpenhamento->e61_numemp,
                    (int)$oItem->codigo_material
                );

                $dQtdSolicitada = isset($dQuantidadeEmOrdemDeCompra) ? (double)$dQuantidadeEmOrdemDeCompra : 0;
                $dTotalSolicitado = $oItem->valor_unitario * $dQtdSolicitada;

                if(isset($oItem->valor_unitario)){
                    $dValorUnitario = (double)$oItem->valor_unitario;
                } else{
                    $dValorUnitario = '-';
                }

                // BLOCO DE PRÉ-RENDERIZAÇÃO
                $sValorUnitario   = $dValorUnitario === '-' ? $dValorUnitario : 'R$'.number_format((double)$dValorUnitario,2,',','.');
                $sQtdEmpenhada    = empty($iQtdEmpenhada)?"0":(string)$iQtdEmpenhada;
                $sQtdAnulada      = empty($iQtdAnulada)?"0":(string)$iQtdAnulada;
                $sQtdSolicitada   = empty($dQtdSolicitada)?"0":(string)$dQtdSolicitada;
                $aOrdemCompra     = $oExecucaoDeContratos->getQtdOrdemdecompra($oEmpenhamento->e61_numemp,$oItem->codigo_material);
                $sQtdContratada   = $oExecucaoDeContratos->getItensContrato($oAcordo->getCodigo(),$oItem->codigo_material);
                $sQtdEmpAcordo    = $oExecucaoDeContratos->getQtdEmpenhada($oItem->codigo_material,$oAcordo->getCodigo());

                $sQtdAempenhar    = $sQtdContratada - $sQtdEmpAcordo[0]->qtdempenhada;
                $sVlrAgerarOC     = $oItem->valor_total - $aOrdemCompra[0]->m52_valor;

                $sTotalSolicitado = empty($dTotalSolicitado)?"0":(string)$dTotalSolicitado;
                $sTotalSolicitado = 'R$'.number_format($sTotalSolicitado,2,',','.');

                $dQtdSolicitar    = (double)$sQtdEmpenhada - (double)$sQtdSolicitada - (double)$sQtdAnulada;
                $sQtdSolicitar    = empty($dQtdSolicitar)?"0":(string)$dQtdSolicitar;

                unset($iQtdAnulada);

                // Verifica se a posição de escrita está próxima do fim da página.
                if($oPdf->GetY() > 190){
                    $oPdf->AddPage('L');
                }

                //Verifica se é o primeiro item do empenho
                if($iK === 0){

                    if($oPdf->GetY() >= 170){
                        $oPdf->AddPage('L');
                    }
                    if($lImprimeCabecalhoPosicao){
                        $oExecucaoDeContratos->imprimirCabecalhoTabela4($oPdf, $iAlt, null, $iFonte, $oPosicao,1, $iKp);
                        $lImprimeCabecalhoPosicao = false;
                    }
                    $oExecucaoDeContratos->imprimirCabecalhoTabela4($oPdf, $iAlt, $oEmpenhamento, $iFonte, $oPosicao,2);
                }

                //Imprime item no PDF
                if($oPdf->GetY() >= 190){
                    $oPdf->AddPage('L');
                }

                $oPdf->SetFont('Arial','',$iFonte-1);
                $oPdf->Cell(18 ,$iAlt,$oItem->codigo_material,'TBR',0,'C','');
                $oPdf->Cell(83 ,$iAlt,$oExecucaoDeContratos->limitarTexto($oItem->descricao_material,45),'TBR',0,'C','');
                $oPdf->Cell(25 ,$iAlt,$sQtdContratada,'TBR',0,'C','');
                $oPdf->Cell(18 ,$iAlt,$sValorUnitario,'TBR',0,'C','');
                $oPdf->Cell(25 ,$iAlt,$sQtdEmpenhada,'TBR',0,'C','');
                $oPdf->Cell(20 ,$iAlt,$sQtdAnulada,'TBR',0,'C','');
                $oPdf->Cell(20 ,$iAlt,$aOrdemCompra[0]->m52_quant == null ? '0' : $aOrdemCompra[0]->m52_quant,'TBR',0,'C','');
                $oPdf->Cell(21 ,$iAlt,'R$'.number_format($aOrdemCompra[0]->m52_valor,2,',','.'),'TBR',0,'C','');
                $oPdf->Cell(26 ,$iAlt,'R$'.number_format($sVlrAgerarOC,2,',','.'),'TBR',0,'C','');
                $oPdf->Cell(22 ,$iAlt,$sQtdAempenhar,'TBR',0,'C','');
                $oPdf->Ln();

            }

        }
    }

    $oExecucaoDeContratos->imprimeFinalizacao($oPdf,$iFonte,$iAlt,$aMateriais,$comprim=null,$iNumItens);
}