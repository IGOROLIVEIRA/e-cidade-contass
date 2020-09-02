<?php

require_once("con2_execucaodecontratosaux.php");

function execucaoDeContratosQuebraPorEmpenho($aMateriais,$iFonte,$iAlt,$iAcordo,$oPdf,$iQuebra,$ac16_datainicio = null,$ac16_datafim = null){

    $oExecucaoDeContratos = new ExecucaoDeContratos();
    $oAcordo = new Acordo($iAcordo);
    $oPosicoes = $oAcordo->getPosicoes();
    $aLicitacoesVinculadas = $oAcordo->getLicitacoes();
    $iNumItens = 0;

// Imprime o cabeçalho na primeira página
    $oExecucaoDeContratos->imprimirCabecalhoAcordos($oPdf, $iAlt, $iFonte, $oAcordo, $aLicitacoesVinculadas);
    foreach ($oPosicoes as $iP => $oPosicao){

        $aEmpenhamentosPosicao = $oAcordo->getAutorizacoesEntreDatas($ac16_datainicio,$ac16_datafim,$oPosicao->getCodigo());
        $sQtdAempenhar = 0;

        foreach ($aEmpenhamentosPosicao as $iE => $oEmp){
            $iQtdAnulada = 0;
            $iQtdEmOrdem = 0;
            $iVlrEmOrdem = 0;
            $iVlrEmOrdemReal = 0;
            $iQtdEmOrdemAnulado = 0;
            $iVlrEmOrdemAnulado = 0;
            $iVlrGerarOC = 0;
            $aItensEmpenho = $oExecucaoDeContratos->consultarItensEmpenho((int)$oEmp->codigoempenho);
            foreach ($aItensEmpenho as $iI => $oItem) {
                $iNumItens += count($oEmp->codigoempenho);

                //Bloco de pre-renderizacao
                $sQtdContratadaPosicao = $oExecucaoDeContratos->getItensContratoPosicao($oAcordo->getCodigo(), $oItem->codigo_material,$oPosicao->getCodigo())->ac20_quantidade;
                $sVlrUnitarioPosicao   = $oExecucaoDeContratos->getItensContratoPosicao($oAcordo->getCodigo(), $oItem->codigo_material,$oPosicao->getCodigo())->ac20_valorunitario;
                $sQtdEmpenhada =+ $oItem->quantidade;


                //Itens Anulados
                foreach($oExecucaoDeContratos->itensAnulados((int)$oEmp->codigoempenho,(int)$oItem->codigo_material) as $oAnulado){
                    $iQtdAnulada = (int)$oAnulado->quantidade;
                }
                $sQtdAnulada      = empty($iQtdAnulada)?"0":(string)$iQtdAnulada;

                foreach($oExecucaoDeContratos->quantidadeTotalEmOrdensDeCompra((int)$oEmp->codigoempenho,(int)$oItem->codigo_material) as $oOrdem){
                    $iQtdEmOrdem += $oOrdem->quantidade - $oOrdem->quantidadeAnulada;

                    if($oOrdem->quantidadeAnulada > 0){
                        $iQtdEmOrdemAnulado += $oOrdem->quantidadeAnulada;
                        $iVlrEmOrdemAnulado = $oOrdem->quantidadeAnulada * $oOrdem->valor;
                        $iVlrEmOrdem = $oOrdem->valor - $iVlrEmOrdemAnulado;

                    }else{
                        $iVlrEmOrdem = $oOrdem->valor;
                    }
                    $iVlrGerarOC = $oOrdem->valor - $iVlrEmOrdem - $iVlrEmOrdemAnulado;
                };

                $sQtdEmOrdem      = empty($iQtdEmOrdem)?"0":(string)$iQtdEmOrdem;
                $sQtdEmpenhada = $sQtdEmpenhada - $iQtdAnulada;
                $sQtdAempenhar = $sQtdContratadaPosicao - $sQtdEmpenhada;

                $sQtdEmpenhada      = empty($sQtdEmpenhada)?"0":(string)$sQtdEmpenhada;

                // Verifica se a posição de escrita está próxima do fim da página.
                if ($oPdf->GetY() > 190) {
                    $oPdf->AddPage('L');
                }

                //Verifica se é o primeiro item do empenho
                if ($iI === 0) {

                    if ($oPdf->GetY() >= 170) {
                        $oPdf->AddPage('L');
                    }
                    $oExecucaoDeContratos->imprimirCabecalhoTabela($oPdf, $iAlt, $oEmp, $iFonte, $iQuebra, null, null, $oItem->elemento, $oItem->o58_coddot,$oItem->e60_vlremp);

                }

                // Imprime item no PDF
                if ($oPdf->GetY() >= 190) {
                    $oPdf->AddPage('L');
                }
                $oPdf->SetFont('Arial', '', $iFonte - 1);

                $oPdf->Cell(18, $iAlt, $oItem->codigo_material, 'TBRL', 0, 'C', '');
                $oPdf->Cell(83, $iAlt, $oExecucaoDeContratos->limitarTexto($oItem->descricao_material, 44), 'TBR', 0, 'C', '');
                $oPdf->Cell(25, $iAlt, $sQtdContratadaPosicao, 'TBR', 0, 'C', '');
                $oPdf->Cell(18 ,$iAlt,'R$ '.number_format($sVlrUnitarioPosicao,2,',','.'),'TBR',0,'C','');
                $oPdf->Cell(25 ,$iAlt,$sQtdEmpenhada,'TBR',0,'C','');
                $oPdf->Cell(20 ,$iAlt,$sQtdAnulada,'TBR',0,'C','');
                $oPdf->Cell(20 ,$iAlt,$sQtdEmOrdem,'TBR',0,'C','');
                $oPdf->Cell(21 ,$iAlt,'R$ '.number_format($iVlrEmOrdem,2,',','.'),'TBR',0,'C','');
                $oPdf->Cell(26 ,$iAlt,'R$ '.number_format($iVlrGerarOC,2,',','.'),'TBR',0,'C','');
                $oPdf->Cell(22 ,$iAlt,empty($sQtdAempenhar)?"0":(string)$sQtdAempenhar,'TBR',0,'C','');
                $oPdf->Ln();
            }
//        exit;
        }
    }
    $oExecucaoDeContratos->imprimeFinalizacao($oPdf,$iFonte,$iAlt,$aMateriais,$comprim=null,$iNumItens);
}