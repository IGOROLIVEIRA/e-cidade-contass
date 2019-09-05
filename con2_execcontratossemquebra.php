<?php

require_once("con2_execucaodecontratosaux.php");

function execucaoDeContratosSemQuebra($iFonte,$iAlt,$iAcordo,$oPdf,$iQuebra,$ac16_datainicio = null,$ac16_datafim = null){

    $oAcordo = new Acordo($iAcordo);
    $oExecucaoDeContratos = new ExecucaoDeContratos();
    $aLicitacoesVinculadas = $oAcordo->getLicitacoes();
    $aInformacoesacordo = null;
    $aInformacoesacordo = $oExecucaoDeContratos->getInformacoesAcordo($oAcordo->getCodigo());

    $aLinhasRenderizadas      = array();

    if( empty($aInformacoesacordo) ){
        db_redireciona("db_erros.php?fechar=true&db_erro=Nenhum registro encontrado!");
    }

    foreach ($aInformacoesacordo as $iK => $oAcordoiten) {
        $valorageraroc = 0;
        $valorageraroc = $oAcordoiten->quantidadeempenhada - $oAcordoiten->qtdemoc;

        $vlraempenhar  = 0;
        $vlraempenhar  = $oAcordoiten->qtdcontratada - $oAcordoiten->quantidadeempenhada;

        $aLinhasRenderizadas[] = array(
            'coditem'         => $oAcordoiten->pc01_codmater,
            'descricaoitem'   => $oAcordoiten->pc01_descrmater,
            'qrdcontratada'   => $oAcordoiten->qtdcontratada,
            'valorunitario'   => $oAcordoiten->valorunitario,
            'qtdempenhada'    => $oAcordoiten->quantidadeempenhada,
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
        $oPdf->Cell(83  ,$iAlt, $aLinha['descricaoitem'],'TBR',0,'C',$iCorFundo);
        $oPdf->Cell(25  ,$iAlt, $aLinha['qrdcontratada'],'TBR',0,'C',$iCorFundo);
        $oPdf->Cell(18  ,$iAlt, $aLinha['valorunitario'],'TBR',0,'C',$iCorFundo);
        $oPdf->Cell(25  ,$iAlt, $aLinha['qtdempenhada'],'TBR',0,'C',$iCorFundo);
        $oPdf->Cell(20  ,$iAlt, $aLinha['qtdanulada'],'TBR',0,'C',$iCorFundo);
        $oPdf->Cell(20  ,$iAlt, $aLinha['qtdemoc'],'TBR',0,'C',$iCorFundo);
        $oPdf->Cell(21  ,$iAlt, $aLinha['valoremoc'],'TBR',0,'C',$iCorFundo);
        $oPdf->Cell(26  ,$iAlt, $aLinha['valorageraroc'],'TBR',0,'C',$iCorFundo);
        $oPdf->Cell(22  ,$iAlt, $aLinha['aempenhar'],'TBR',0,'C',$iCorFundo);
        $oPdf->Ln();

    }

    $iNumItens = count($aInformacoesacordo);
    $oExecucaoDeContratos->imprimeFinalizacao($oPdf,$iFonte,$iAlt,$aInformacoesacordo,$comprim=null,$iNumItens);

}