<?php
require_once("fpdf151/pdf.php");
require_once("libs/db_utils.php");
require_once("classes/db_acordo_classe.php");
require_once("model/Acordo.model.php");
require_once("model/AcordoComissao.model.php");
require_once("model/AcordoItem.model.php");
require_once("model/AcordoPosicao.model.php");
require_once("model/AcordoRescisao.model.php");
require_once("model/AcordoMovimentacao.model.php");
require_once("model/AcordoComissaoMembro.model.php");
require_once("model/AcordoGarantia.model.php");
require_once("model/AcordoHomologacao.model.php");
require_once("model/MaterialCompras.model.php");
require_once("model/CgmFactory.model.php");
require_once("con2_execcontratossemquebra.php");
require_once("con2_execcontratosquebraempenho.php");
require_once("con2_execcontratosquebraaditivo.php");
require_once("con2_execcontratosquebraaditivoempenho.php");
require_once("con2_execucaodecontratosaux.php");

db_postmemory($HTTP_GET_VARS);
$oPdf  = new PDF();
$oPdf->Open();
$oPdf->AliasNbPages();
$oPdf->SetTextColor(0,0,0);
$oPdf->SetFillColor(220);
$oPdf->SetAutoPageBreak(false);
$oExecucaoFinanceita = new ExecucaoDeContratos();

$iFonte     = 9;
$iAlt       = 6;

$head4 = "Relatório de Execução Financeira\n";

if( empty($dtVigenciaInicial) && !empty($dtVigenciaFinal) ){
    $head4 .= "\nPeríodo: até $dtVigenciaFinal";
}else if( !empty($dtVigenciaInicial) && empty($dtVigenciaFinal) ){
    $head4 .= "\nPeríodo: a partir de $dtVigenciaInicial";
}else if( !empty($dtVigenciaInicial) && !empty($dtVigenciaFinal) ){
    $head4 .= "\nPeríodo: de $dtVigenciaInicial até $dtVigenciaFinal";
}
$oContratosRelatorio = array();
$sWhere = '';

if($aContratos){
	$sWhere .= ' ac16_sequencial in ('.$aContratos.') ';
}

if($fornecedor){
	$sWhere .= $sWhere ? ' AND ' : ' ';
	$sWhere .= ' ac16_contratado = '.$fornecedor;
}

if($departInclusao){
	$sWhere .= $sWhere ? ' AND ' : ' ';
	$sWhere .= ' ac16_coddepto in ('.$departInclusao.')';
}

if($departResponsavel){
	$sWhere .= $sWhere ? ' AND ' : ' ';
	$sWhere .= ' ac16_deptoresponsavel in ('.$departResponsavel.')';
}

$oContratosRelatorio = ExecucaoDeContratos::getAcordos($sWhere);
foreach ($oContratosRelatorio as $ik => $oCo){
	$arrayContratos[$ik] = $oCo;
}

foreach ($arrayContratos as $iContrato){

    $oPdf->AddPage('L');

    $oAcordo    = new Acordo($iContrato->ac16_sequencial);

    $oPosicoes   = $oAcordo->getPosicoes();
    $iTotalDeRegistros = null;
    $oDataInicial  = $oAcordo->getDataInicialVigenciaOriginal();
    $oDataFinal    = $oAcordo->getVigenciaFinalOriginal();

    $oPdf->SetFont('Arial','B',10);
    $oPdf->ln();
    $oPdf->cell(40 ,10,"Acordo: ".$oAcordo->getNumero()."/".$oAcordo->getAno(),"TBL" ,0,"L",1,0);
    $oPdf->cell(120,10,"Fornecedor: ".$oAcordo->getContratado()->getNome(),"TB"  ,0,"L",1,0);
    $oPdf->cell(65 ,10,"Valor do Contrato: ".'R$'.number_format((double)$oAcordo->getValorContrato(),2,',','.'),"TB"  ,0,"L",1,0);
    $oPdf->cell(58 ,10,"Vigência: ".$oDataInicial->getDate(DBDate::DATA_PTBR)." a ".$oDataFinal->getDate(DBDate::DATA_PTBR) ,"TBR" ,1,"L",1,0);
    $oPdf->cell(98,10,""                         ,"TBRL",0,"L",1,0);
    $oPdf->cell(96,10,"Movimentação do Empenho"  ,"TBRL",0,"C",1,0);
    $oPdf->cell(89 ,10,"Saldo a Pagar"          ,"TBRL",1,"C",1,0);
    //linha cabeçalho
    $oPdf->cell(18 ,10,"Empenho"                 ,"TBRL",0,"C",1,0);
    $oPdf->cell(30 ,10,"Data de Emissão"         ,"TBRL",0,"C",1,0);
    $oPdf->cell(39 ,10,"Posição de Emissão"      ,"TBRL",0,"C",1,0);
    $oPdf->cell(11 ,10,"Nº"                      ,"TBRL",0,"C",1,0);
    $oPdf->cell(24 ,10,"Empenhado"               ,"TBRL",0,"C",1,0);
    $oPdf->cell(23 ,10,"Liquidado"               ,"TBRL",0,"C",1,0);
    $oPdf->cell(23 ,10,"Anulado"                 ,"TBRL",0,"C",1,0);
    $oPdf->cell(26 ,10,"Pago"                    ,"TBRL",0,"C",1,0);
    $oPdf->cell(30 ,10,"Liquidado"               ,"TBRL",0,"C",1,0);
    $oPdf->cell(30 ,10,"Não Liquidado"           ,"TBRL",0,"C",1,0);
    $oPdf->cell(29 ,10,"Geral"                   ,"TBRL",1,"C",1,0);

    $sTotalEmpenhado = 0;
    $sTotalLiquidado = 0;
    $sTotalAnulado = 0;
    $sTotalPago = 0;
    $sTotalLiquidadoNaoPago = 0;
    $sTotalNaoLiquidado = 0;
    $sTotalGeral = 0;
    foreach ($oPosicoes as $aPosicao){
        $aEmpenhos = ExecucaoDeContratos::empenhosDeUmaPosicao($aPosicao->getCodigo(),$dtVigenciaInicial,$dtVigenciaFinal);

        if(empty($aEmpenhos)){
            continue;
        }

        foreach ($aEmpenhos as $oEmp){

            $sDataEmissao = date("d/m/Y", strtotime($oEmp->e60_emiss));
            /**
             * Aqui e tratado o tipo de posição como solicitado na OC
             */
            $iPosicaoemissao = $aPosicao->getTipo();
            $sDescricaoposicao = $aPosicao->getDescricaoTipo();

            $iAlt = 10;

            switch ($iPosicaoemissao) {
                case 1:
                    $sDescricaoposicao = "Contrato";
                    break;
                case 15:
                    $sDescricaoposicao = "Apostilamento";
                    break;
                case 16:
                    $sDescricaoposicao = "Apostilamento";
                    break;
                case 17:
                    $sDescricaoposicao = "Apostilamento";
                    break;
                case 11:
                    $sDescricaoposicao = "Acréscimo e Decréscimo de Itens";
                    break;
                case 9:
                    $sDescricaoposicao = "Acréscimo de Item(ns)";
                    break;
                case 10:
                    $sDescricaoposicao = "Decréscimo de Item(ns)";
                    break;
                case 14:
                    $sDescricaoposicao = "Acréscimo/Decréscimo de item(ns) conjugado";
                    break;
            }

            $aDescricaoposicao = quebrarTexto($sDescricaoposicao,21);
            $iAlt = $iAlt*(count($aDescricaoposicao));

            $aValoresEmp  = ExecucaoDeContratos::getValoresEmpenho($oEmp->e61_numemp);
            $vlrLiqaPagar =  $aValoresEmp[0]->e60_vlrliq - $aValoresEmp[0]->e60_vlrpag;
            $vlrNaoLiq    = $aValoresEmp[0]->e60_vlremp - $aValoresEmp[0]->e60_vlrliq - $aValoresEmp[0]->e60_vlranu;
            $vlorGeral    = $vlrNaoLiq - $vlrLiqaPagar;

            $sTotalEmpenhado        += $aValoresEmp[0]->e60_vlremp;
            $sTotalLiquidado        += $aValoresEmp[0]->e60_vlrliq;
            $sTotalAnulado          += $aValoresEmp[0]->e60_vlranu;
            $sTotalPago             += $aValoresEmp[0]->e60_vlrpag;
            $sTotalLiquidadoNaoPago += $vlrLiqaPagar;
            $sTotalNaoLiquidado     += $vlrNaoLiq;
            $sTotalGeral            += $vlorGeral;

            $oPdf->SetFont('Arial','',10);
            $oPdf->cell(18,$iAlt,$oEmp->e60_codemp."/".$oEmp->e60_anousu,"TBRL",0,"C",0,0);
            $oPdf->cell(30,$iAlt,$sDataEmissao,"TBRL",0,"C",0,0);
            multiCell($oPdf, $aDescricaoposicao, 10, $iAlt, 39);
            $oPdf->cell(11,$iAlt,$aPosicao->getNumeroAditamento() == null ? '-' : $aPosicao->getNumeroAditamento(),"TBRL",0,"C",0,0);
            $oPdf->cell(24,$iAlt,'R$'.number_format((double)$aValoresEmp[0]->e60_vlremp,2,',','.'),"TBRL",0,"C",0,0);
            $oPdf->cell(23,$iAlt,'R$'.number_format((double)$aValoresEmp[0]->e60_vlrliq,2,',','.'),"TBRL",0,"C",0,0);
            $oPdf->cell(23,$iAlt,'R$'.number_format((double)$aValoresEmp[0]->e60_vlranu,2,',','.'),"TBRL",0,"C",0,0);
            $oPdf->cell(26,$iAlt,'R$'.number_format((double)$aValoresEmp[0]->e60_vlrpag,2,',','.'),"TBRL",0,"C",0,0);
            $oPdf->cell(30,$iAlt,'R$'.number_format((double)$vlrLiqaPagar,2,',','.'),"TBRL",0,"C",0,0);
            $oPdf->cell(30,$iAlt,'R$'.number_format((double)$vlrNaoLiq,2,',','.'),"TBRL",0,"C",0,0);
            $oPdf->cell(29,$iAlt,'R$'.number_format((double)$vlorGeral,2,',','.'),"TBRL",1,"C",0,0);

            // Verifica se a posição de escrita está próxima ao fim da página.
            if($oPdf->GetY() > 190){
                $oPdf->AddPage('L');
            }

            if($oPdf->GetY() >= 170){
                $oPdf->AddPage('L');
            }
        }
    }
    $oPdf->SetFont('Arial','B',10);
    $oPdf->cell(98,10,"VALOR TOTAL: ","TBRL",0,"R",1,0);
    $oPdf->cell(24,10,'R$'.number_format((double)$sTotalEmpenhado,2,',','.'),"TBRL",0,"C",1,0);
    $oPdf->cell(23,10,'R$'.number_format((double)$sTotalLiquidado,2,',','.'),"TBRL",0,"C",1,0);
    $oPdf->cell(23,10,'R$'.number_format((double)$sTotalAnulado,2,',','.'),"TBRL",0,"C",1,0);
    $oPdf->cell(26,10,'R$'.number_format((double)$sTotalPago,2,',','.'),"TBRL",0,"C",1,0);
    $oPdf->cell(30,10,'R$'.number_format((double)$sTotalLiquidadoNaoPago,2,',','.'),"TBRL",0,"C",1,0);
    $oPdf->cell(30,10,'R$'.number_format((double)$sTotalNaoLiquidado,2,',','.'),"TBRL",0,"C",1,0);
    $oPdf->cell(29,10,'R$'.number_format((double)abs($sTotalGeral),2,',','.'),"TBRL",1,"C",1,0);

}

function multiCell($oPdf,$aTexto,$iTamFixo,$iTam,$iTamCampo) {
    $pos_x = $oPdf->x;
    $pos_y = $oPdf->y;
    $oPdf->cell($iTamCampo, $iTam, "", 1, 0, 'C', 0);
    $oPdf->x = $pos_x;
    $oPdf->y = $pos_y;
    foreach ($aTexto as $sTexto) {
        $sTexto=ltrim($sTexto);
        $oPdf->cell($iTamCampo, $iTamFixo, $sTexto, 0, 1, 'C', 0);
        $oPdf->x=$pos_x;
    }
    $oPdf->x = $pos_x+$iTamCampo;
    $oPdf->y = $pos_y;
}

function quebrarTexto($texto,$tamanho){

    $aTexto = explode(" ", $texto);
    $string_atual = "";
    foreach ($aTexto as $word) {
        $string_ant = $string_atual;
        $string_atual .= " ".$word;
        if (strlen($string_atual) > $tamanho) {
            $aTextoNovo[] = $string_ant;
            $string_ant   = "";
            $string_atual = $word;
        }
    }
    $aTextoNovo[] = $string_atual;
    return $aTextoNovo;

}
$oPdf->SetFont('Arial','',$iFonte-1);
$oPdf->Output();