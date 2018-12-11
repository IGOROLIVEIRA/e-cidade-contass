<?php

require_once("con2_execucaodecontratosaux.php");

function execucaoDeContratosSemQuebra($iFonte,$iAlt,$iAcordo,$oPdf,$iQuebra,$ac16_datainicio = null,$ac16_datafim = null){

  $oAcordo = new Acordo($iAcordo);
  $aEmpenhamentos = $oAcordo->getAutorizacoesEntreDatas($ac16_datainicio,$ac16_datafim);
  $aLicitacoesVinculadas = $oAcordo->getLicitacoes();

  if( empty($aEmpenhamentos) ){
    db_redireciona("db_erros.php?fechar=true&db_erro=Nenhum registro encontrado!");
  }

  $iQtdAnulada = 0;
  $aCodigosDosMateriais = null;
  $aMateriais = null;
  $oExecucaoDeContratos = new ExecucaoDeContratos();
  $aLinhasRenderizadas      = array();

  // Gera um array com o código de cada material de cada empenho
  $aMateriais = array_unique(ExecucaoDeContratos::arrayDeMateriais($oExecucaoDeContratos, $aEmpenhamentos), SORT_REGULAR);

  // Percorre cada código de material
  foreach ($aMateriais as $iK => $oMaterial){

    // Declaração das variáveis utilizadas na renderização do PDF
    $iCodItem                   = null;
    $sDescricaoitem             = null;
    $dValorUnitario             = null;
    $sValorUnitario             = null;
    $dValorUnitarioProvisorio   = null;
    $sQtdEmpenhada              = null;
    $iQtdEmpenhada              = null;
    $dQtdAnulada                = null;
    $sQtdAnulada                = null;
    $sQtdSolicitada             = null;
    $sTotalSolicitado           = null;
    $sQtdSolicitar              = null;
    $dQtdSolicitada             = null;
    $dTotalSolicitado           = null;
    $dQuantidadeEmOrdemDeCompra = null;

    foreach($aEmpenhamentos as $oEmpenhamento){

      if(empty($oEmpenhamento->empenho)){
        continue;
      }

      $aEmpenho = $oExecucaoDeContratos->consultarItensEmpenho((int)$oEmpenhamento->codigoempenho);

      foreach($aEmpenho as $oItem){

        // Barreira contra itens com código de material diferente do código de material atual ($sCodMaterial)
        if($oItem->codigo_material !== $oMaterial->codigo){
          continue;
        }

        $iQtdEmpenhada += (int)$oItem->quantidade;

        foreach($oExecucaoDeContratos->itensAnulados(
          (int)$oEmpenhamento->codigoempenho,
          (int)$oItem->codigo_material
        ) as $oAnulado){
          $iQtdAnulada += (int)$oAnulado->quantidade;
        }

        $dQtdAnulada += isset($iQtdAnulada) ? (double)$iQtdAnulada : 0;
        unset($iQtdAnulada);

        if(empty($oItem->codigo_material)){
          continue;
        }

        $dQuantidadeEmOrdemDeCompra = ExecucaoDeContratos::quantidadeTotalEmOrdensDeCompra(
          (int)$oEmpenhamento->codigoempenho,
          (int)$oItem->codigo_material
        );
        $dQtdSolicitada += isset($dQuantidadeEmOrdemDeCompra) ? (double)$dQuantidadeEmOrdemDeCompra : 0;
        $dValorUnitarioProvisorio = (double)$oItem->valor_unitario;

      }

      // Bloco que verifica se há valores unitários diferentes para o mesmo item em todos os empenhos
      if(empty($dValorUnitario)){
        $dValorUnitario = (double)$dValorUnitarioProvisorio;
      } else if((double)$dValorUnitario !== (double)$dValorUnitarioProvisorio){
        $dValorUnitario = '-';
      }
    }

    // BLOCO DE PRÉ-RENDERIZAÇÃO
    $iCodItem         = $oMaterial->codigo;
    $sDescricaoitem   = $oExecucaoDeContratos->limitarTexto($oMaterial->descricao,68);
    $sValorUnitario   = isset($dValorUnitario) && $dValorUnitario !== '-' ? 'R$'.number_format((double)$dValorUnitario,2,',','.') : '-';
    $sQtdEmpenhada    = empty($iQtdEmpenhada) ? "0" : (string)$iQtdEmpenhada;
    $sQtdAnulada      = empty($dQtdAnulada) ? "0" : (string)$dQtdAnulada;
    $sQtdSolicitada   = empty($dQtdSolicitada) ? "0" : (string)$dQtdSolicitada;

    $dTotalSolicitado = $dValorUnitario * $dQtdSolicitada;
    $sTotalSolicitado = empty($dTotalSolicitado)?"0":(string)$dTotalSolicitado;
    $sTotalSolicitado = 'R$'.number_format($sTotalSolicitado,2,',','.');

    $dQtdSolicitar    = (double)$sQtdEmpenhada - (double)$sQtdSolicitada - (double)$sQtdAnulada;
    $sQtdSolicitar    = empty($dQtdSolicitar)?"0":(string)$dQtdSolicitar;

    unset($dValorUnitario);
    unset($iQtdEmpenhada);
    unset($dQtdAnulada);
    unset($dQtdSolicitada);
    unset($dTotalSolicitado);
    unset($dQtdSolicitar);

    /*===========================================================================||
    ||                             RENDERIZAÇÃO NO PDF                           ||
    ||===========================================================================*/

    // Verifica se a posição de escrita está próxima do fim da página.
    if($oPdf->GetY() > 190){
      $oPdf->AddPage('L');
    }

    //Verifica se é a primeira iteração para os materiais
    if($iK === 0){

      $oExecucaoDeContratos->imprimirCabecalhoAcordos($oPdf, $iAlt, $iFonte, $oAcordo, $aLicitacoesVinculadas);

      if($oPdf->GetY() >= 170){
        $oPdf->AddPage('L');
      }
      $oExecucaoDeContratos->imprimirCabecalhoTabela($oPdf, $iAlt, null, $iFonte, $iQuebra);

    }

    $aLinhasRenderizadas[] = array(
      'coditem'         => $iCodItem,
      'descricaoitem'   => $sDescricaoitem,
      'valorunitario'   => $sValorUnitario,
      'qtdempenhada'    => $sQtdEmpenhada,
      'qtdanulada'      => $sQtdAnulada,
      'qtdsolicitada'   => $sQtdSolicitada,
      'totalsolicitado' => $sTotalSolicitado,
      'qtdsolicitar'    => $sQtdSolicitar,
    );

  }

// Ordena
  usort($aLinhasRenderizadas, 'ExecucaoDeContratos::cmp');

  foreach ($aLinhasRenderizadas as $iK => $aLinha){

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

    $oPdf->Cell(18  ,$iAlt, $aLinha['coditem'],'TBR',0,'C',$iCorFundo);
    $oPdf->Cell(124 ,$iAlt, $aLinha['descricaoitem'],'TBR',0,'C',$iCorFundo);
    $oPdf->Cell(22  ,$iAlt, $aLinha['valorunitario'],'TBR',0,'C',$iCorFundo);
    $oPdf->Cell(25  ,$iAlt, $aLinha['qtdempenhada'],'TBR',0,'C',$iCorFundo);
    $oPdf->Cell(20  ,$iAlt, $aLinha['qtdanulada'],'TBR',0,'C',$iCorFundo);
    $oPdf->Cell(24  ,$iAlt, $aLinha['qtdsolicitada'],'TBR',0,'C',$iCorFundo);
    $oPdf->Cell(25  ,$iAlt, $aLinha['totalsolicitado'],'TBR',0,'C',$iCorFundo);
    $oPdf->Cell(22  ,$iAlt, $aLinha['qtdsolicitar'],'TBR',0,'C',$iCorFundo);
    $oPdf->Ln();

  }

  $iNumItens = count($aMateriais);
  $oExecucaoDeContratos->imprimeFinalizacao($oPdf,$iFonte,$iAlt,$aMateriais,$comprim=null,$iNumItens);

}