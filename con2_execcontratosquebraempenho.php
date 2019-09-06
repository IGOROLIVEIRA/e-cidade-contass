<?php

require_once("con2_execucaodecontratosaux.php");

function execucaoDeContratosQuebraPorEmpenho($aMateriais,$iFonte,$iAlt,$iAcordo,$oPdf,$iQuebra,$ac16_datainicio = null,$ac16_datafim = null){

  $oExecucaoDeContratos = new ExecucaoDeContratos();

  $oAcordo = new Acordo($iAcordo);
  $aEmpenhamentos = $oAcordo->getAutorizacoesEntreDatas($ac16_datainicio,$ac16_datafim);
  $aInformacoesacordo = $oExecucaoDeContratos->getInformacoesAcordo($oAcordo->getCodigo(),$oAcordo->getUltimaPosicao()->getCodigo(),$ac16_datainicio,$ac16_datafim);

  $aLicitacoesVinculadas = $oAcordo->getLicitacoes();

  if(empty($aInformacoesacordo)){
      db_redireciona("db_erros.php?fechar=true&db_erro=Nenhum registro encontrado!");
  }

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
      $sQtdSolicitada   = empty($dQtdSolicitada)?"0":(string)$dQtdSolicitada;

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
      $oExecucaoDeContratos->imprimirCabecalhoTabela($oPdf, $iAlt, $oEmpenhamento, $iFonte, $iQuebra);

    }

    // Define a cor de fundo da linha
    if ($iK % 2 === 0) {

      $iCorFundo    = 0;
      $oPdf->SetFillColor(220);

    } else {

      $iCorFundo    = 1;
      $oPdf->SetFillColor(240);

    }

    // Imprime item no PDF
    if($oPdf->GetY() >= 190){
      $oPdf->AddPage('L');
    }
    $oPdf->SetFont('Arial','',$iFonte-1);

      $oPdf->Cell(18 ,$iAlt,$oItem->codigo_material,'TBR',0,'C',$iCorFundo);
      $oPdf->Cell(124 ,$iAlt,$oExecucaoDeContratos->limitarTexto($oItem->descricao_material,68),'TBR',0,'C',$iCorFundo);
      $oPdf->Cell(22 ,$iAlt,$sValorUnitario,'TBR',0,'C',$iCorFundo);
      $oPdf->Cell(25 ,$iAlt,$sQtdEmpenhada,'TBR',0,'C',$iCorFundo);
      $oPdf->Cell(20 ,$iAlt,$sQtdAnulada,'TBR',0,'C',$iCorFundo);
      $oPdf->Cell(24 ,$iAlt,$sQtdSolicitada,'TBR',0,'C',$iCorFundo);
      $oPdf->Cell(25 ,$iAlt,$sTotalSolicitado,'TBR',0,'C',$iCorFundo);
      $oPdf->Cell(22 ,$iAlt,$sQtdSolicitar,'TBR',0,'C',$iCorFundo);
    $oPdf->Ln();

  }

  }

  $oExecucaoDeContratos->imprimeFinalizacao($oPdf,$iFonte,$iAlt,$aMateriais,$comprim=null,$iNumItens);
}