<?php

require_once("con2_execucaodecontratosaux.php");
//ini_set('display_errors','on');
function execucaoDeContratosQuebraPorAditivoEmpenho($aMateriais,$iFonte,$iAlt,$iAcordo,$oPdf,$iQuebra,$ac16_datainicio = null,$ac16_datafim = null){

    $oExecucaoDeContratos = new ExecucaoDeContratos();
    $oAcordo = new Acordo($iAcordo);
    $oPosicoes = $oAcordo->getPosicoes();
    $aLicitacoesVinculadas = $oAcordo->getLicitacoes();
    $oExecucaoDeContratos->imprimirCabecalhoAcordos($oPdf, $iAlt, $iFonte, $oAcordo, $aLicitacoesVinculadas);

    $iNumItens = 0;
    $iCodAditivo = null;

    foreach ($oPosicoes as $iP => $oPosicao){

        $aEmpenhamentosPosicao = $oAcordo->getAutorizacoesEntreDatas($ac16_datainicio,$ac16_datafim,$oPosicao->getCodigo());


        foreach ($aEmpenhamentosPosicao as $iE => $oEmp){
            $iQtdAnulada = 0;
            $iQtdEmOrdem = 0;
            $iVlrEmOrdem = 0;
            $iVlrEmOrdemReal = 0;
            $iQtdEmOrdemAnulado = 0;
            $iVlrEmOrdemAnulado = 0;
            $iVlrGerarOC = 0;
            $sQtdAempenhar = 0;
            $aItensEmpenho = $oExecucaoDeContratos->consultarItensEmpenho((int)$oEmp->codigoempenho);
            foreach ($aItensEmpenho as $iI => $oItem) {
                $iNumItens += count($oEmp->codigoempenho);

                //Bloco de pre-renderizacao
                $sQtdContratadaPosicao = $oExecucaoDeContratos->getItensContratoPosicao($oAcordo->getCodigo(), $oItem->codigo_material,$oPosicao->getCodigo())->ac20_quantidade;
                $sVlrUnitarioPosicao   = $oExecucaoDeContratos->getItensContratoPosicao($oAcordo->getCodigo(), $oItem->codigo_material,$oPosicao->getCodigo())->ac20_valorunitario;
                $sQtdEmpenhada = $oItem->quantidade;


                //Itens Anulados
                foreach($oExecucaoDeContratos->itensAnulados((int)$oEmp->codigoempenho,(int)$oItem->codigo_material) as $oAnulado){
                    $iQtdAnulada = (int)$oAnulado->quantidade;
                }
                $sQtdAnulada      = empty($iQtdAnulada)?"0":(string)$iQtdAnulada;

                foreach($oExecucaoDeContratos->quantidadeTotalEmOrdensDeCompra((int)$oEmp->codigoempenho,(int)$oItem->codigo_material) as $oOrdem){

                    $iQtdEmOrdem += $oOrdem->quantidade;
                    $iVlrEmOrdem += $oOrdem->valor;
                    $iQtdEmOrdemAnulado += $oOrdem->quantidadeAnulada;
                    $iVlrEmOrdemAnulado = $iQtdEmOrdemAnulado * $oOrdem->valor;
                };

                $iVlrEmOrdemReal = $iVlrEmOrdem - $iVlrEmOrdemAnulado;
                $iVlrGerarOC = $oEmp->e54_valor - $iVlrEmOrdemReal;
                $sQtdAempenhar = $sQtdContratadaPosicao - $sQtdEmpenhada + $iQtdAnulada;

                // Verifica se a posição de escrita está próxima do fim da página.
                if ($oPdf->GetY() > 190) {
                    $oPdf->AddPage('L');
                }

                //Verifica se é o primeiro item do empenho
                if ($iI === 0) {

                    if ($oPdf->GetY() >= 170) {
                        $oPdf->AddPage('L');
                    }

                    if($iCodAditivo != $oPosicao->getTipo().$oPosicao->getNumeroAditamento()){
                        $iE === 0 ? $oExecucaoDeContratos->imprimirCabecalhoTabela4($oPdf, $iAlt, $oEmp, $iFonte, $iQuebra, $oPosicao, null, $oItem->elemento, $oItem->o58_coddot, $oItem->e60_vlremp) : null;
                    }
                    $oExecucaoDeContratos->imprimirCabecalhoEmp($oPdf, $iAlt, $oEmp, $iFonte, $iQuebra, $oPosicao, null, $oItem->elemento, $oItem->o58_coddot, $oItem->e60_vlremp);

                    $iCodAditivo = $oPosicao->getTipo().$oPosicao->getNumeroAditamento();

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
                $oPdf->Cell(20 ,$iAlt,$iQtdEmOrdem,'TBR',0,'C','');
                $oPdf->Cell(21 ,$iAlt,'R$ '.number_format($iVlrEmOrdemReal,2,',','.'),'TBR',0,'C','');
                $oPdf->Cell(26 ,$iAlt,'R$ '.number_format($iVlrGerarOC,2,',','.'),'TBR',0,'C','');
                $oPdf->Cell(22 ,$iAlt,empty($sQtdAempenhar)?"0":(string)$sQtdAempenhar,'TBR',0,'C','');
                $oPdf->Ln();
            }
        }
    }
    $oExecucaoDeContratos->imprimeFinalizacao($oPdf,$iFonte,$iAlt,$aMateriais,$comprim=null,$iNumItens);
}