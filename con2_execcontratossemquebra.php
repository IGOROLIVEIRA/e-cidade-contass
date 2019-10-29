<?php

require_once("con2_execucaodecontratosaux.php");

function execucaoDeContratosSemQuebra($iFonte,$iAlt,$iAcordo,$oPdf,$iQuebra,$dInicio = null,$dFim = null){

    $oAcordo = new Acordo($iAcordo);
    $oExecucaoDeContratos = new ExecucaoDeContratos();
    $aLicitacoesVinculadas = $oAcordo->getLicitacoes();

    $aInformacoesacordo = null;
    $aInformacoesacordo = $oExecucaoDeContratos->getInformacoesAcordo($oAcordo->getCodigo(),$oAcordo->getUltimaPosicao()->getCodigo(),$dInicio,$dFim);

    $aLinhasRenderizadas      = array();

    if( empty($aInformacoesacordo) ){
        db_redireciona("db_erros.php?fechar=true&db_erro=Nenhum registro encontrado!");
    }

    foreach ($aInformacoesacordo as $iK => $oAcordoiten) {
        $valorageraroc = 0;
        $valorageraroc = $oAcordoiten->quantidadeempenhada - $oAcordoiten->qtdemoc;

        $vlraempenhar  = 0;
        $vlraempenhar  = $oAcordoiten->qtdcontratada - $oAcordoiten->quantidadeempenhada;
        $sDescricaoitem   = $oExecucaoDeContratos->limitarTexto($oAcordoiten->pc01_descrmater,45);

        $aLinhasRenderizadas[] = array(
            'coditem'         => $oAcordoiten->pc01_codmater,
            'descricaoitem'   => $sDescricaoitem,
            'qrdcontratada'   => $oAcordoiten->qtdcontratada,
            'valorunitario'   => $oAcordoiten->valorunitario,
            'qtdempenhada'    => (int)$oAcordoiten->quantidadeempenhada,
            'qtdanulada'      => $oAcordoiten->qtdanulado,
            'qtdemoc'         => $oAcordoiten->qtdemoc,
            'valoremoc'       => $oAcordoiten->vlremoc,
            'valorageraroc'   => $valorageraroc,
            'aempenhar'       => $vlraempenhar,
        );


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

    }

// Ordena
    usort($aLinhasRenderizadas, 'ExecucaoDeContratos::cmp');

    foreach ($aLinhasRenderizadas as $iK => $aLinha){

        // Imprime item no PDF
        if($oPdf->GetY() >= 190){
            $oPdf->AddPage('L');
        }
        $oPdf->SetFont('Arial','',$iFonte-1);

        $oPdf->Cell(18  ,$iAlt, $aLinha['coditem'],1,0,'C','');
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

    }

    $iNumItens = count($aInformacoesacordo);
    $oExecucaoDeContratos->imprimeFinalizacao($oPdf,$iFonte,$iAlt,$aInformacoesacordo,$comprim=null,$iNumItens);

}