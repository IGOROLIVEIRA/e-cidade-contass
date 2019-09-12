<?php

require_once("con2_execucaodecontratosaux.php");

function execucaoDeContratosQuebraPorEmpenho($aMateriais,$iFonte,$iAlt,$iAcordo,$oPdf,$iQuebra,$ac16_datainicio = null,$ac16_datafim = null){

  $oExecucaoDeContratos = new ExecucaoDeContratos();

  $oAcordo = new Acordo($iAcordo);
  $aEmpenhamentos = $oAcordo->getAutorizacoesEntreDatas($ac16_datainicio,$ac16_datafim);

  $aLicitacoesVinculadas = $oAcordo->getLicitacoes();

  $iQtdAnulada = 0;
  $iNumItens = 0;

  // Imprime o cabeçalho na primeira página
  $oExecucaoDeContratos->imprimirCabecalhoAcordos($oPdf, $iAlt, $iFonte, $oAcordo, $aLicitacoesVinculadas);

  foreach($aEmpenhamentos as $iJ => $oEmpenhamento){

    if(empty($oEmpenhamento->empenho)){
      continue;
    }

    $aEmpenho = $oExecucaoDeContratos->consultarItensEmpenho((int)$oEmpenhamento->codigoempenho);
    $iNumItens += count($aEmpenho);

    foreach($aEmpenho as $iK => $oItem){
      $dQuantidadeEmOrdemDeCompra = null;
      $iQtdEmpenhada = (int)$oItem->quantidade;

      foreach($oExecucaoDeContratos->itensAnulados(
          (int)$oEmpenhamento->codigoempenho,
          (int)$oItem->codigo_material
        ) as $oAnulado){
          $iQtdAnulada += (int)$oAnulado->quantidade;
      }

      if(empty($oItem->codigo_material)){
        continue;
      }

      $dQuantidadeEmOrdemDeCompra = ExecucaoDeContratos::quantidadeTotalEmOrdensDeCompra(
        (int)$oEmpenhamento->codigoempenho,
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
      $iQtdaGerarOC     = $sQtdEmpenhada - $dQuantidadeEmOrdemDeCompra[0]->quantidade;
      $sQtdContratada   = $oExecucaoDeContratos->getItensContrato($oAcordo->getCodigo(),$oItem->codigo_material);
      $sQtdEmpAcordo    = $oExecucaoDeContratos->getQtdEmpenhada($oItem->codigo_material,$oAcordo->getCodigo());

      $sQtdAempenhar    = $sQtdContratada - $sQtdEmpAcordo[0]->qtdempenhada;
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
      $oExecucaoDeContratos->imprimirCabecalhoTabela($oPdf, $iAlt, $oEmpenhamento, $iFonte, $iQuebra,null,null,$oItem->elemento,$oItem->o58_coddot);

    }

    // Imprime item no PDF
    if($oPdf->GetY() >= 190){
      $oPdf->AddPage('L');
    }
    $oPdf->SetFont('Arial','',$iFonte-1);

      $oPdf->Cell(18 ,$iAlt,$oItem->codigo_material,'TBR',0,'C','');
      $oPdf->Cell(83 ,$iAlt,$oExecucaoDeContratos->limitarTexto($oItem->descricao_material,44),'TBR',0,'C','');
      $oPdf->Cell(25 ,$iAlt,$oExecucaoDeContratos->getItensContrato($oAcordo->getCodigo(),$oItem->codigo_material),'TBR',0,'C','');
      $oPdf->Cell(18 ,$iAlt,$sValorUnitario,'TBR',0,'C','');
      $oPdf->Cell(25 ,$iAlt,$sQtdEmpenhada,'TBR',0,'C','');
      $oPdf->Cell(20 ,$iAlt,$sQtdAnulada,'TBR',0,'C','');
      $oPdf->Cell(20 ,$iAlt,$dQuantidadeEmOrdemDeCompra[0]->quantidade == null ? '0' : $dQuantidadeEmOrdemDeCompra[0]->quantidade,'TBR',0,'C','');
      $oPdf->Cell(21 ,$iAlt,'R$'.number_format($dQuantidadeEmOrdemDeCompra[0]->valor,2,',','.'),'TBR',0,'C','');
      $oPdf->Cell(26 ,$iAlt,$iQtdaGerarOC,'TBR',0,'C','');
      $oPdf->Cell(22 ,$iAlt,$sQtdAempenhar,'TBR',0,'C','');
    $oPdf->Ln();

  }

  }

  $oExecucaoDeContratos->imprimeFinalizacao($oPdf,$iFonte,$iAlt,$aMateriais,$comprim=null,$iNumItens);
}