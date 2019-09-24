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
//ini_set('display_errors','on');
$arrayContratos = preg_split("/[\s,]+/", $aContratos);


$oPdf  = new PDF();
$oPdf->Open();
$oPdf->AliasNbPages();
$oPdf->SetTextColor(0,0,0);
$oPdf->SetFillColor(220);
$oPdf->SetAutoPageBreak(false);

$iFonte     = 9;
$iAlt       = 6;

$head4 = "Relatório de Execução Financeira\n";

if( empty($ac16_datainicio) && !empty($ac16_datafim) ){
    $head4 .= "\nPeríodo: até $ac16_datafim";
}else if( !empty($ac16_datainicio) && empty($ac16_datafim) ){
    $head4 .= "\nPeríodo: a partir de $ac16_datainicio";
}else if( !empty($ac16_datainicio) && !empty($ac16_datafim) ){
    $head4 .= "\nPeríodo: de $ac16_datainicio até $ac16_datafim";
}

$oPdf->AddPage('L');

foreach ($arrayContratos as $iContrato){
//    echo "<pre>"; print_r($iContrato);die();
    $oAcordo    = new Acordo($iContrato);
    $oExecucaoFinanceita = new ExecucaoDeContratos();
//    $oExecucaoFinanceita->imprimircabecalho($oPdf,$oAcordo);
    $oPosicoes   = $oAcordo->getPosicoes();
    $iTotalDeRegistros = null;
//        echo "<pre>"; print_r($aPosicoes);die();
    $oPdf->SetFont('Arial','B',10);
    $oPdf->ln();
    $oPdf->cell(55 ,10,"Acordo: ".$oAcordo->getCodigo()                                     ,"TBL" ,0,"L",1,0);
    $oPdf->cell(100,10,"Fornecedor: ".$oAcordo->getContratado()->getNome()                  ,"TB"  ,0,"L",1,0);
    $oPdf->cell(65 ,10,"Valor do Contrato: ".$oAcordo->getValorContrato()                   ,"TB"  ,0,"L",1,0);
    $oPdf->cell(63 ,10,"Vigência: ".$oAcordo->getDataInicial()." á ".$oAcordo->getDataFinal() ,"TBR" ,1,"L",1,0);
    $oPdf->cell(98,10,""                         ,"TBRL",0,"L",1,0);
    $oPdf->cell(96,10,"Movimentação do Empenho"  ,"TBRL",0,"C",1,0);
    $oPdf->cell(89 ,10,"Saldo a Pagar:"          ,"TBRL",1,"C",1,0);
    //linha cabeçalho
    $oPdf->cell(18 ,10,"Empenho"                 ,"TBRL",0,"C",1,0);
    $oPdf->cell(30 ,10,"Data de Emissão"         ,"TBRL",0,"C",1,0);
    $oPdf->cell(39 ,10,"Posição de Emissão"      ,"TBRL",0,"C",1,0);
    $oPdf->cell(11 ,10,"Nº"                      ,"TBRL",0,"C",1,0);
    $oPdf->cell(24 ,10,"Empenhado"               ,"TBRL",0,"C",1,0);
    $oPdf->cell(23 ,10,"Liquidado"               ,"TBRL",0,"C",1,0);
    $oPdf->cell(23 ,10,"Anulado"                 ,"TBRL",0,"C",1,0);
    $oPdf->cell(26 ,10,"Pago"                 ,"TBRL",0,"C",1,0);
    $oPdf->cell(30 ,10,"Liquidado"               ,"TBRL",0,"C",1,0);
    $oPdf->cell(30 ,10,"Não Liquidado"               ,"TBRL",0,"C",1,0);
    $oPdf->cell(29 ,10,"Geral"                 ,"TBRL",1,"C",1,0);

    foreach ($oPosicoes as $aPosicao){
        $aEmpenhos = ExecucaoDeContratos::empenhosDeUmaPosicao($aPosicao->getCodigo(),$ac16_datainicio,$ac16_datafim);
//echo "<pre>"; print_r($aEmpenhos);
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
            }

            $aDescricaoposicao = quebrarTexto($sDescricaoposicao,21);
            $iAlt = $iAlt*(count($aDescricaoposicao));
            $aValoresEmp  = ExecucaoDeContratos::getValoresEmpenho($oEmp->e60_numemp);
            $vlrLiqaPagar =  $aValoresEmp[0]->e60_vlrliq - $aValoresEmp[0]->e60_vlrpag;
            $vlrNaoLiq    = $aValoresEmp[0]->e60_vlremp - $aValoresEmp[0]->e60_vlrliq - $aValoresEmp[0]->e60_vlranu;
            $vlorGeral    = 0;
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
            $oPdf->cell(29,$iAlt,"","TBRL",1,"C",0,0);

            // Verifica se a posição de escrita está próxima ao fim da página.
            if($oPdf->GetY() > 190){
                $oPdf->AddPage('L');
            }

            if($oPdf->GetY() >= 170){
                $oPdf->AddPage('L');
            }
        }
    }
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
//die();
$oPdf->SetFont('Arial','',$iFonte-1);

$oPdf->Output();