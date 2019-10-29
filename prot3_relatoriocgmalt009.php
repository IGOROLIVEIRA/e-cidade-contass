<?php
require_once("fpdf151/pdf.php");
require_once("libs/db_utils.php");
require_once("model/CgmFactory.model.php");
require_once("classes/db_cgmalt_classe.php");


db_postmemory($HTTP_GET_VARS);

$arrayCgmsAlt = preg_split("/[\s,]+/", $aCgmsAlt);



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
foreach ($arrayCgmsAlt as $cgm){

    $oDaoCgm      = db_utils::getDao('cgmalt');
    $sSqlBuscaCGMALT = $oDaoCgm->sql_cgmaltcgm($cgm, "*", null, "");
//    die($sSqlBuscaCGMALT);
    $rsBuscaCGMALT   = $oDaoCgm->sql_record($sSqlBuscaCGMALT);

    for ($iCont = 0; $iCont < pg_num_rows($rsBuscaCGMALT); $iCont++) {
        $oRegistroCgmAlt = db_utils::fieldsMemory($rsBuscaCGMALT, $iCont);
    }

    $oPdf->AddPage('P');
    $oPdf->SetFont('Arial','B',15);
    $oPdf->ln();
    $oPdf->ln();
    $oPdf->cell(190,$iAlt,"Cadastro Geral do Municipio - CGM",0,1,"C",0,0);
    $oPdf->ln();
    $oPdf->cell(190,$iAlt,"Detalhamento do Fornecedor",0,1,"C",0,0);
    $oPdf->ln();
    $oPdf->SetFont('Arial','B',10);
    $oPdf->cell(190,$iAlt,"Dados Cadastro","TBRL",1,"D",1,0);
    $oPdf->SetFont('Arial','',10);

    $oPdf->cell(45,$iAlt,"Nome/Razão Social:",0,0,"D",0,0);
    $oPdf->cell(145,$iAlt,$oRegistroCgmAlt->z05_nome,0,1,"D",0,0);
    $oPdf->cell(45,$iAlt,"Nome Fantasia:",0,0,"D",0,0);
    $oPdf->cell(145,$iAlt,$oRegistroCgmAlt->z05_nomefanta,0,1,"D",0,0);
    $oPdf->cell(45,$iAlt,"CPF/CNPJ:",0,0,"D",0,0);
    $oPdf->cell(145,$iAlt,$oRegistroCgmAlt->z05_cgccpf,0,1,"D",0,0);
//    $oPdf->cell(45,$iAlt,"Obs:",0,0,"D",0,0);
//    $oPdf->cell(145,$iAlt,$oRegistroCgmAlt->z05_obs,0,1,"D",0,0);

    $oPdf->SetFont('Arial','B',10);
    $oPdf->ln();
    $oPdf->ln();
    $oPdf->cell(190,$iAlt,"Detalhamento do Cadastro","TBRL",1,"D",1,0);
    $oPdf->SetFont('Arial','',10);
    $oPdf->cell(45,$iAlt,"Endereço Principal:",0,0,"D",0,0);
    $oPdf->cell(45,$iAlt,$oRegistroCgmAlt->z05_ender,0,1,"D",0,0);
    $oPdf->cell(45,$iAlt,"Logradouro:",0,0,"D",0,0);
    $oPdf->cell(45,$iAlt,"",0,1,"D",0,0);
    $oPdf->cell(45,$iAlt,"Bairro:",0,0,"D",0,0);
    $oPdf->cell(45,$iAlt,$oRegistroCgmAlt->z05_bairro,0,1,"D",0,0);
    $oPdf->cell(45,$iAlt,"Complemento:",0,0,"D",0,0);
    $oPdf->cell(45,$iAlt,$oRegistroCgmAlt->z01_compl,0,1,"D",0,0);
    $oPdf->cell(45,$iAlt,"Municipio:",0,0,"D",0,0);
    $oPdf->cell(45,$iAlt,$oRegistroCgmAlt->z05_munic,0,1,"D",0,0);
    $oPdf->cell(45,$iAlt,"UF:",0,0,"D",0,0);
    $oPdf->cell(45,$iAlt,$oRegistroCgmAlt->z05_uf,0,1,"D",0,0);
    $oPdf->cell(45,$iAlt,"Telefone:",0,0,"D",0,0);
    $oPdf->cell(45,$iAlt,$oRegistroCgmAlt->z05_telef,0,1,"D",0,0);
    $oPdf->cell(45,$iAlt,"Celular:",0,0,"D",0,0);
    $oPdf->cell(45,$iAlt,$oRegistroCgmAlt->z05_telcel,0,1,"D",0,0);
    $oPdf->cell(45,$iAlt,"Fax:",0,0,"D",0,0);
    $oPdf->cell(45,$iAlt,$oRegistroCgmAlt->z05_fax,0,1,"D",0,0);
    $oPdf->cell(45,$iAlt,"e-mail:",0,0,"D",0,0);
    $oPdf->cell(45,$iAlt,$oRegistroCgmAlt->z05_email,0,1,"D",0,0);
    $oPdf->cell(45,$iAlt,"Caixa Postal:",0,0,"D",0,0);
    $oPdf->cell(45,$iAlt,"",0,1,"D",0,0);

    $oPdf->SetFont('Arial','B',15);

    $aDescricaoposicao = quebrarTexto($oRegistroCgmAlt->z05_obs,60);
    $iAlts = $iAlt*(count($aDescricaoposicao));

    $oPdf->ln();
    $oPdf->ln();
    $oPdf->cell(190,$iAlt,"Justificativa de Alteração","TBRL",1,"D",1,0);
    $oPdf->SetFont('Arial','',10);
    multiCell($oPdf, $aDescricaoposicao, 5, $iAlts, 145);
    $data = implode("/",(array_reverse(explode("-",$oRegistroCgmAlt->z05_data_alt))));
    $oPdf->cell(45,$iAlts,$data,"TBRL",0,"C",0,0);

}

function multiCell($oPdf,$aTexto,$iTamFixo,$iTam,$iTamCampo) {
    $pos_x = $oPdf->x;
    $pos_y = $oPdf->y;
    $oPdf->cell($iTamCampo, $iTam, "", 1, 0, "D", 0);
    $oPdf->x = $pos_x;
    $oPdf->y = $pos_y;
    foreach ($aTexto as $sTexto) {
        $sTexto=ltrim($sTexto);
        $oPdf->cell($iTamCampo, $iTamFixo, $sTexto, 0, 1, 'D', 0);
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
$oPdf->Output();