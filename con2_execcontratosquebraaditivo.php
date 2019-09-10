<?php

require_once("con2_execucaodecontratosaux.php");

function execucaoDeContratosQuebraPorAditivo($aMateriais,$iFonte,$iAlt,$iAcordo,$oPdf,$iQuebra,$ac16_datainicio = null,$ac16_datafim = null){

    $oAcordo    = new Acordo($iAcordo);
    $oExecucaoDeContratos = new ExecucaoDeContratos();
    $aPosicoes   = $oAcordo->getPosicoes();

    $iTotalDeRegistros = null;

    if(empty($aPosicoes) || count($aPosicoes) < 2){
        db_redireciona("db_erros.php?fechar=true&db_erro=Nenhum registro encontrado!");
    }

    $aLicitacoesVinculadas = $oAcordo->getLicitacoes();
    $iQtdAnulada  = 0;
    $iNumItens    = 0;

    $oExecucaoDeContratos->imprimirCabecalhoAcordos($oPdf, $iAlt, $iFonte, $oAcordo, $aLicitacoesVinculadas);

    // Percorre todas as posições de um acordo
    foreach ($aPosicoes as $iKp => $oPosicao) {
        $aInformacoesacordo = null;
        $aInformacoesacordo = $oExecucaoDeContratos->getInformacoesAcordo($oAcordo->getCodigo(),$oPosicao->getCodigo(),$ac16_datainicio,$ac16_datafim);

        $aLinhasRenderizadas = array();

        // Percorre cada código de material
        foreach ($aInformacoesacordo as $iKm => $oMaterial){
            $valorageraroc = 0;
            $valorageraroc = $oMaterial->quantidadeempenhada - $oMaterial->qtdemoc;

            $vlraempenhar  = 0;
            $vlraempenhar  = $oMaterial->qtdcontratada - $oMaterial->quantidadeempenhada;
            $sDescricaoitem   = $oExecucaoDeContratos->limitarTexto($oMaterial->pc01_descrmater,45);

            $aLinhasRenderizadas[] = array(
                'coditem'         => $oMaterial->pc01_codmater,
                'descricaoitem'   => $sDescricaoitem,
                'qrdcontratada'   => $oMaterial->qtdcontratada,
                'valorunitario'   => $oMaterial->valorunitario,
                'qtdempenhada'    => (int)$oMaterial->quantidadeempenhada == null ? '0' :(int)$oMaterial->quantidadeempenhada,
                'qtdanulada'      => $oMaterial->qtdanulado,
                'qtdemoc'         => $oMaterial->qtdemoc,
                'valoremoc'       => $oMaterial->vlremoc,
                'valorageraroc'   => $valorageraroc,
                'aempenhar'       => $vlraempenhar,
            );

            /*===========================================================================||
            ||                             RENDERIZAÇÃO NO PDF                           ||
            ||===========================================================================*/

            // Verifica se a posição de escrita está próxima ao fim da página.
            if($oPdf->GetY() > 190){
                $oPdf->AddPage('L');
            }

            if($oPdf->GetY() >= 170){
                $oPdf->AddPage('L');
            }

            $iKm === 0 ? $oExecucaoDeContratos->imprimirCabecalhoTabela($oPdf, $iAlt, null, $iFonte, $iQuebra, $oPosicao) : null;

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

            $oPdf->Cell(18  ,$iAlt, $aLinha['coditem'],'TBR',0,'C','');
            $oPdf->Cell(83  ,$iAlt, $aLinha['descricaoitem'],'TBR',0,'C','');
            $oPdf->Cell(25  ,$iAlt, $aLinha['qrdcontratada'],'TBR',0,'C','');
            $oPdf->Cell(18  ,$iAlt, 'R$ '.$aLinha['valorunitario'],'TBR',0,'C','');
            $oPdf->Cell(25  ,$iAlt, $aLinha['qtdempenhada'],'TBR',0,'C','');
            $oPdf->Cell(20  ,$iAlt, $aLinha['qtdanulada'],'TBR',0,'C','');
            $oPdf->Cell(20  ,$iAlt, $aLinha['qtdemoc'],'TBR',0,'C','');
            $oPdf->Cell(21  ,$iAlt, 'R$ '.$aLinha['valoremoc'],'TBR',0,'C','');
            $oPdf->Cell(26  ,$iAlt, 'R$ '.$aLinha['valorageraroc'],'TBR',0,'C','');
            $oPdf->Cell(22  ,$iAlt, $aLinha['aempenhar'],'TBR',0,'C','');
            $oPdf->Ln();

            $iNumItens++;

        }

    }

    $oExecucaoDeContratos->imprimeFinalizacao($oPdf,$iFonte,$iAlt,$aMateriais,$comprim=null,$iNumItens);

}