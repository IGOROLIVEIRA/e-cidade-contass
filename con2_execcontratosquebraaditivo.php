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

    // Percorre todas as posi��es de um acordo
    foreach ($aPosicoes as $iKp => $oPosicao) {

        $aEmpenhos = ExecucaoDeContratos::empenhosDeUmaPosicao($oPosicao->getCodigo(),$ac16_datainicio,$ac16_datafim);

        if(empty($aEmpenhos)){
            continue;
        }

        // Gera um array com o c�digo de cada material de cada empenho
        $aMateriais = array_unique(ExecucaoDeContratos::arrayDeMateriais($oExecucaoDeContratos, $aEmpenhos, 3), SORT_REGULAR);

        $aLinhasRenderizadas = array();

        // Percorre cada c�digo de material
        foreach ($aMateriais as $iKm => $oMaterial){

            // Declara��o das vari�veis utilizadas na renderiza��o do PDF
            $iCodItem                 = null;
            $sDescricaoitem           = null;
            $dValorUnitario           = null;
            $sValorUnitario           = null;
            $dValorUnitarioProvisorio = null;
            $sQtdEmpenhada            = null;
            $iQtdEmpenhada            = null;
            $dQtdAnulada              = null;
            $sQtdAnulada              = null;
            $sQtdEmOrdemdeCompra      = null;
            $dVlrOrdemDeCompra        = null;
            $iQtdEmOrdem              = null;
            $iVlrEmOrdem              = null;
            $iQtdEmOrdemAnulado       = null;
            $dQtdOrdemDeCompra        = null;
            $dVlrAgerarOrdem          = null;

            foreach($aEmpenhos as $oEmpenho){

                if(empty($oEmpenho->e61_numemp)){
                    continue;
                }

                $aEmpenho = $oExecucaoDeContratos->consultarItensEmpenho((int)$oEmpenho->e61_numemp);

                foreach($aEmpenho as $oItem){

                    // Barreira contra itens com c�digo de material diferente do c�digo de material atual ($sCodMaterial)
                    if($oItem->codigo_material !== $oMaterial->codigo){
                        continue;
                    }

                    $iQtdEmpenhada += (int)$oItem->quantidade;

                    foreach($oExecucaoDeContratos->itensAnulados(
                        (int)$oEmpenho->e61_numemp,
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
                        (int)$oEmpenho->e61_numemp,
                        (int)$oItem->codigo_material
                    );
                    $iQtdEmOrdem = 0;

                    foreach($dQuantidadeEmOrdemDeCompra as $oOrdem){

                        $iQtdEmOrdem += $oOrdem->quantidade;
                        $iVlrEmOrdem = $oOrdem->valor;
                        $iQtdEmOrdemAnulado += $oOrdem->quantidadeAnulada;
                        $iVlrEmOrdemAnulado = $iQtdEmOrdemAnulado * $oOrdem->valor;
                    };

                    $dQtdOrdemDeCompra += isset($iQtdEmOrdem) ? (double)$iQtdEmOrdem : 0;
                    $dVlrOrdemDeCompra = $iVlrEmOrdem * $dQtdOrdemDeCompra;
                    $dValorUnitarioProvisorio = (double)$oItem->valor_unitario;
                }

                // Bloco que verifica se h� valores unit�rios diferentes para o mesmo item em todos os empenhos
                if(empty($dValorUnitario)){
                    $dValorUnitario = (double)$dValorUnitarioProvisorio;
                } else if((double)$dValorUnitario !== (double)$dValorUnitarioProvisorio){
                    $dValorUnitario = '-';
                }

            }

            // BLOCO DE PR�-RENDERIZA��O
            $dVlrTotalEmpenhado = $dValorUnitario * $iQtdEmpenhada;
            $iCodItem              = $oMaterial->codigo;
            $sDescricaoitem        = $oExecucaoDeContratos->limitarTexto($oMaterial->descricao,68);
            $sQtdContratadaPosicao = $oExecucaoDeContratos->getItensContratoPosicao($oAcordo->getCodigo(), $oMaterial->codigo,$oPosicao->getCodigo())->ac20_quantidade;
            $sValorUnitario        = isset($dValorUnitario) && $dValorUnitario !== '-' ? 'R$'.number_format((double)$dValorUnitario,2,',','.') : '-';
            $sQtdEmpenhada         = empty($iQtdEmpenhada) ? "0" : (string)$iQtdEmpenhada;
            $sQtdAnulada           = empty($dQtdAnulada) ? "0" : (string)$dQtdAnulada;
            $sQtdEmOrdemdeCompra   = empty($dQtdOrdemDeCompra) ? "0" : (string)$dQtdOrdemDeCompra;
            $sVlrEmOrdemdeCompra   = isset($dVlrOrdemDeCompra) && $dVlrOrdemDeCompra !== '-' ? 'R$'.number_format((double)$dVlrOrdemDeCompra,2,',','.') : '-';
            $dVlrAgerarOrdem       = $dVlrTotalEmpenhado - $dVlrOrdemDeCompra;
            $sVlrAgerarOrdem       = isset($dVlrAgerarOrdem) && $dVlrAgerarOrdem !== '-' ? 'R$'.number_format((double)$dVlrAgerarOrdem,2,',','.') : '-';
            $dQtdAempenhar         = $sQtdContratadaPosicao - $iQtdEmpenhada + $dQtdAnulada;
            $sQtdAempenhar         = empty($dQtdAempenhar) ? "0" :(string)$dQtdAempenhar;
            unset($dValorUnitario);
            unset($iQtdEmpenhada);
            unset($dQtdAnulada);
            unset($dQtdOrdemDeCompra);
            unset($dTotalSolicitado);
            unset($dQtdSolicitar);

            /*===========================================================================||
            ||                             RENDERIZA��O NO PDF                           ||
            ||===========================================================================*/

            // Verifica se a posi��o de escrita est� pr�xima ao fim da p�gina.
            if($oPdf->GetY() > 190){
                $oPdf->AddPage('L');
            }

            if($oPdf->GetY() >= 170){
                $oPdf->AddPage('L');
            }

            $iKm === 0 ? $oExecucaoDeContratos->imprimirCabecalhoTabela($oPdf, $iAlt, null, $iFonte, $iQuebra, $oPosicao,null,null,null,null) : null;

            $aLinhasRenderizadas[] = array(
                'coditem'                   => $iCodItem,
                'descricaoitem'             => $sDescricaoitem,
                'qtdcontratada'             => $sQtdContratadaPosicao,
                'valorunitario'             => $sValorUnitario,
                'qtdempenhada'              => $sQtdEmpenhada,
                'qtdanulada'                => $sQtdAnulada,
                'qtdemordemdecompra'        => $sQtdEmOrdemdeCompra,
                'vlremordemdecompra'        => $sVlrEmOrdemdeCompra,
                'qtdagerarordemdecompra'    => $sVlrAgerarOrdem,
                'qtdaempenhar'              => $sQtdAempenhar,
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

            $oPdf->Cell(18  ,$iAlt, $aLinha['coditem'],        'TBR',0,'C',$iCorFundo);
            $oPdf->Cell(83  ,$iAlt, $aLinha['descricaoitem'],  'TBR',0,'C',$iCorFundo);
            $oPdf->Cell(25  ,$iAlt, $aLinha['qtdcontratada'],  'TBR',0,'C',$iCorFundo);
            $oPdf->Cell(18  ,$iAlt, $aLinha['valorunitario'],  'TBR',0,'C',$iCorFundo);
            $oPdf->Cell(25  ,$iAlt, $aLinha['qtdempenhada'],   'TBR',0,'C',$iCorFundo);
            $oPdf->Cell(20  ,$iAlt, $aLinha['qtdanulada'],     'TBR',0,'C',$iCorFundo);
            $oPdf->Cell(20  ,$iAlt, $aLinha['qtdemordemdecompra'],  'TBR',0,'C',$iCorFundo);
            $oPdf->Cell(21  ,$iAlt, $aLinha['vlremordemdecompra'],'TBR',0,'C',$iCorFundo);
            $oPdf->Cell(26  ,$iAlt, $aLinha['qtdagerarordemdecompra'],'TBR',0,'C',$iCorFundo);
            $oPdf->Cell(22  ,$iAlt, $aLinha['qtdaempenhar'],   'TBR',0,'C',$iCorFundo);
            $oPdf->Ln();

            $iNumItens++;

        }

    }

    $oExecucaoDeContratos->imprimeFinalizacao($oPdf,$iFonte,$iAlt,$aMateriais,$comprim=null,$iNumItens);

}