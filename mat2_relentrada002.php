<?
include ("fpdf151/pdf.php");
include ("libs/db_sql.php");
include ("libs/db_utils.php");
include ("classes/db_matestoque_classe.php");
include ("classes/db_matestoqueitem_classe.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$oGet = db_utils::postMemory($_GET,0);

$clmatestoque     = new cl_matestoque;
$clmatestoqueitem = new cl_matestoqueitem;

$sLetra  = 'arial';
$sInfo   = "";
$sOrder  = null;
$sWhere  = "";
$sAnd    = "";
$iInstit = db_getsession('DB_instit');

if ( isset($iInstit) && !empty($iInstit) ) {
  $sWhere .= "{$sAnd} instit = {$iInstit} ";
  $sAnd    = " and ";
}

if ( isset($oGet->codmater) && $oGet->codmater != "" ) {
	$sWhere .= "{$sAnd} m70_codmatmater = {$oGet->codmater} ";
	$sAnd    = " and ";
}

if ( isset($oGet->listatipo) && $oGet->listatipo != "" ) {

	if ( isset ($oGet->vertipo) && $oGet->vertipo == "com" ) {

		$sWhere .= "{$sAnd} m51_numcgm in ({$oGet->listatipo})";
		$sAnd    = " and ";
	} else {

		$sWhere .= "{$sAnd} m51_numcgm not in ($oGet->listatipo)";
		$sAnd    = " and ";
	}
}

if ( isset($oGet->dtInicial) && isset($oGet->dtFinal) ) {

  $dtInicial = implode("-", array_reverse(explode("/", $oGet->dtInicial)));
  $dtFinal   = implode("-", array_reverse(explode("/", $oGet->dtFinal)));
	if ( !empty($dtInicial) && !empty($dtFinal) ) {

	  $sWhere .= "{$sAnd} m71_data between '{$dtInicial}' and '{$dtFinal}' ";
	  $sAnd    = " and ";
	  $sInfo = "De {$oGet->dtInicial} até {$oGet->dtFinal}";
	} else if ( !empty($dtInicial) ) {

	  $sWhere .= "{$sAnd} m71_data >= '{$dtInicial}' ";
	  $sAnd    = " and ";
	  $sInfo   = "Apartir de {$oGet->dtInicial}";
	} else  if ( !empty($dtFinal) ) {

	  $sWhere .= "{$sAnd} m71_data <= '{$dtFinal}' ";
	  $sAnd    = " and ";
	  $info    = "Até {$oGet->dtFinal}";
	}
}

if(isset($oGet->ntFiscal) && $oGet->ntFiscal != ""){
  $sWhere .="{$sAnd} e69_numero = '{$oGet->ntFiscal}' ";
  $sAnd    = " and ";
}

if(isset($oGet->sqNtFiscal) && $oGet->sqNtFiscal != ""){
  $sWhere .="{$sAnd} e69_codnota = '{$oGet->sqNtFiscal}' ";
  $sAnd    = " and ";
}

if(isset($oGet->ordemCompra) && $oGet->ordemCompra != ""){
  $sWhere .="{$sAnd} m51_codordem = {$oGet->ordemCompra} ";
  $sAnd    = " and ";
}


if ( isset($oGet->ordenar) && $oGet->ordenar == 'ordfrn' ) {
	$sOrder = "z01_numcgm";
} else if ( isset($oGet->ordenar) && $oGet->ordenar == 'ordoc' ) {
	$sOrder = "m51_codordem";
} else if ( isset($oGet->ordenar) && $oGet->ordenar == 'ordnt' ) {
  $sOrder = "e69_numero";
} else if ( isset($oGet->ordenar) && $oGet->ordenar == 'orddt' ) {
  $sOrder = "m71_data";
}

$head3 = "RELATÓRIO DE ENTRADA";
$head5 = $sInfo;

$sCampos  = "matmater.m60_codmater, matmater.m60_descr, db_depart.instit,                                             ";
$sCampos .= "empnota.e69_codnota, empnota.e69_numero, empnota.e69_dtnota,                                             ";
$sCampos .= "matordem.m51_numcgm, matordem.m51_codordem, cgm.z01_numcgm, cgm.z01_nome,                                ";
$sCampos .= "matestoqueitem.m71_quant, matestoqueitem.m71_valor, matestoqueitem.m71_data                              ";

$sSqlMatestoque = $clmatestoque->sql_query_ent(null, $sCampos, $sOrder, $sWhere);
// print_r($sSqlMatestoque);die();
$rsMatestoque   = $clmatestoque->sql_record($sSqlMatestoque);

if ($clmatestoque->numrows == 0) {
	db_redireciona('db_erros.php?fechar=true&db_erro=Não existem registros  cadastrados.');
}

$pdf = new PDF();
$pdf->Open();
$pdf->addpage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(false);
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(235);

$aDadosMatEstoque  = array();
$aDadosNumNota     = array();
$aDados            = array();
$lImprime          = true;
$nAlt              = 4;
$nTotalRegistros   = 0;
$nTotalGerlaReg    = 0;
$nTotalGeralQuant  = 0;
$nTotalGeralVlrUnt = 0;
$nTotalGeralVlrTot = 0;

for ( $iInd = 0; $iInd  < $clmatestoque->numrows; $iInd++ ) {

  $oDados = db_utils::fieldsMemory($rsMatestoque,$iInd);

  $oDadosMatEstoque = new stdClass();
  $oDadosMatEstoque->iCodMater      = $oDados->m60_codmater;
  $oDadosMatEstoque->sDescMater     = $oDados->m60_descr;
  $oDadosMatEstoque->iNumero        = $oDados->e69_numero;
  $oDadosMatEstoque->dtData         = $oDados->e69_dtnota;
  $oDadosMatEstoque->iNumCgm        = $oDados->m51_numcgm;
  $oDadosMatEstoque->iCodOrdem      = $oDados->m51_codordem;
  $oDadosMatEstoque->iCodForneced   = $oDados->z01_numcgm;
  $oDadosMatEstoque->sNomeForneced  = $oDados->z01_nome;
  $oDadosMatEstoque->iQuantidade    = $oDados->m71_quant;

  if ( $oDados->m71_valor != 0 ) {
    $oDadosMatEstoque->nValorUnit   = ($oDados->m71_valor/$oDados->m71_quant);
  } else {
  	$oDadosMatEstoque->nValorUnit   = $oDados->m71_valor;
  }

  $oDadosMatEstoque->nVlrTotal      = $oDados->m71_valor;

  // escape para caso de não haver 'agrupar'
  if (!isset($oGet->agrupar)) {
    continue;
  }

  if ( $oGet->agrupar == 'agrpn' ) {

    if ( !isset($aDadosMatEstoque[$oDados->e69_codnota]) ) {

    	$aDadosMatEstoque[$oDados->e69_codnota]['nNumeroNota']     = $oDadosMatEstoque->iNumero;
    	$aDadosMatEstoque[$oDados->e69_codnota]['sNomeFornecedor'] = $oDadosMatEstoque->sNomeForneced;
    	$aDadosMatEstoque[$oDados->e69_codnota]['dtData']          = $oDadosMatEstoque->dtData;
    	$aDadosMatEstoque[$oDados->e69_codnota]['aItens'][]        = $oDadosMatEstoque;
    	$aDadosMatEstoque[$oDados->e69_codnota]['iQuantTotal']     = $oDadosMatEstoque->iQuantidade;
    	$aDadosMatEstoque[$oDados->e69_codnota]['nValorTotalUnit'] = $oDadosMatEstoque->nValorUnit;
    	$aDadosMatEstoque[$oDados->e69_codnota]['nValorSomaTotal'] = $oDadosMatEstoque->nVlrTotal;
    } else {

      $aDadosMatEstoque[$oDados->e69_codnota]['nNumeroNota']     = $oDadosMatEstoque->iNumero;
      $aDadosMatEstoque[$oDados->e69_codnota]['sNomeFornecedor'] = $oDadosMatEstoque->sNomeForneced;
      $aDadosMatEstoque[$oDados->e69_codnota]['dtData']          = $oDadosMatEstoque->dtData;
      $aDadosMatEstoque[$oDados->e69_codnota]['aItens'][]        = $oDadosMatEstoque;
      $aDadosMatEstoque[$oDados->e69_codnota]['iQuantTotal']    += $oDadosMatEstoque->iQuantidade;
      $aDadosMatEstoque[$oDados->e69_codnota]['nValorTotalUnit']+= $oDadosMatEstoque->nValorUnit;
      $aDadosMatEstoque[$oDados->e69_codnota]['nValorSomaTotal']+= $oDadosMatEstoque->nVlrTotal;
    }
  } else if ( $oGet->agrupar == 'agrpoc' ) {

    if ( !isset($aDadosMatEstoque[$oDados->m51_codordem]) ) {

      $aDadosMatEstoque[$oDados->m51_codordem]['nNumeroNota']      = $oDadosMatEstoque->iNumero;
      $aDadosMatEstoque[$oDados->m51_codordem]['sNomeFornecedor']  = $oDadosMatEstoque->sNomeForneced;
      $aDadosMatEstoque[$oDados->m51_codordem]['dtData']           = $oDadosMatEstoque->dtData;
      $aDadosMatEstoque[$oDados->m51_codordem]['aItens'][]         = $oDadosMatEstoque;
      $aDadosMatEstoque[$oDados->m51_codordem]['iQuantTotal']      = $oDadosMatEstoque->iQuantidade;
      $aDadosMatEstoque[$oDados->m51_codordem]['nValorTotalUnit']  = $oDadosMatEstoque->nValorUnit;
      $aDadosMatEstoque[$oDados->m51_codordem]['nValorSomaTotal']  = $oDadosMatEstoque->nVlrTotal;
    } else {

      $aDadosMatEstoque[$oDados->m51_codordem]['nNumeroNota']      = $oDadosMatEstoque->iNumero;
      $aDadosMatEstoque[$oDados->m51_codordem]['sNomeFornecedor']  = $oDadosMatEstoque->sNomeForneced;
      $aDadosMatEstoque[$oDados->m51_codordem]['dtData']           = $oDadosMatEstoque->dtData;
      $aDadosMatEstoque[$oDados->m51_codordem]['aItens'][]         = $oDadosMatEstoque;
      $aDadosMatEstoque[$oDados->m51_codordem]['iQuantTotal']     += $oDadosMatEstoque->iQuantidade;
      $aDadosMatEstoque[$oDados->m51_codordem]['nValorTotalUnit'] += $oDadosMatEstoque->nValorUnit;
      $aDadosMatEstoque[$oDados->m51_codordem]['nValorSomaTotal'] += $oDadosMatEstoque->nVlrTotal;
    }
  } else if ( $oGet->agrupar == 'agrpf' ) {

    if ( !isset($aDadosMatEstoque[$oDados->z01_numcgm]) ) {

      $aDadosMatEstoque[$oDados->z01_numcgm]['nNumeroNota']     = $oDadosMatEstoque->iNumero;
      $aDadosMatEstoque[$oDados->z01_numcgm]['sNomeFornecedor'] = $oDadosMatEstoque->sNomeForneced;
      $aDadosMatEstoque[$oDados->z01_numcgm]['dtData']          = $oDadosMatEstoque->dtData;
      $aDadosMatEstoque[$oDados->z01_numcgm]['aItens'][]        = $oDadosMatEstoque;
      $aDadosMatEstoque[$oDados->z01_numcgm]['iQuantTotal']     = $oDadosMatEstoque->iQuantidade;
      $aDadosMatEstoque[$oDados->z01_numcgm]['nValorTotalUnit'] = $oDadosMatEstoque->nValorUnit;
      $aDadosMatEstoque[$oDados->z01_numcgm]['nValorSomaTotal'] = $oDadosMatEstoque->nVlrTotal;
    } else {

      $aDadosMatEstoque[$oDados->z01_numcgm]['nNumeroNota']     = $oDadosMatEstoque->iNumero;
      $aDadosMatEstoque[$oDados->z01_numcgm]['sNomeFornecedor'] = $oDadosMatEstoque->sNomeForneced;
      $aDadosMatEstoque[$oDados->z01_numcgm]['dtData']          = $oDadosMatEstoque->dtData;
      $aDadosMatEstoque[$oDados->z01_numcgm]['aItens'][]        = $oDadosMatEstoque;
      $aDadosMatEstoque[$oDados->z01_numcgm]['iQuantTotal']    += $oDadosMatEstoque->iQuantidade;
      $aDadosMatEstoque[$oDados->z01_numcgm]['nValorTotalUnit']+= $oDadosMatEstoque->nValorUnit;
      $aDadosMatEstoque[$oDados->z01_numcgm]['nValorSomaTotal']+= $oDadosMatEstoque->nVlrTotal;
    }
  } else if ( $oGet->agrupar == 'agrpm' ) {

    if (!isset($aDadosMatEstoque[$oDados->m60_codmater])) {
      $aDadosMatEstoque[$oDados->m60_codmater] = array();
    }

    $aDadosMatEstoque[$oDados->m60_codmater]['nNumeroNota']     = $oDadosMatEstoque->iNumero;
    $aDadosMatEstoque[$oDados->m60_codmater]['iCodMater']       = $oDadosMatEstoque->iCodMater;
    $aDadosMatEstoque[$oDados->m60_codmater]['sNomeMaterial']   = $oDadosMatEstoque->sDescMater;
    $aDadosMatEstoque[$oDados->m60_codmater]['dtData']          = $oDadosMatEstoque->dtData;
    $aDadosMatEstoque[$oDados->m60_codmater]['aItens'][]        = $oDadosMatEstoque;
    $aDadosMatEstoque[$oDados->m60_codmater]['iQuantTotal']    += $oDadosMatEstoque->iQuantidade;
    $aDadosMatEstoque[$oDados->m60_codmater]['nValorTotalUnit']+= $oDadosMatEstoque->nValorUnit;
    $aDadosMatEstoque[$oDados->m60_codmater]['nValorSomaTotal']+= $oDadosMatEstoque->nVlrTotal;

  }
}
// echo '<pre>'; print_r($aDadosMatEstoque); exit; // aqui
foreach ( $aDadosMatEstoque as $iCodInd => $aDados ) {

  // agrupar por fornecedores
  if ( isset($oGet->agrupar) && $oGet->agrupar == 'agrpf' ) {

    if ( $pdf->gety() > $pdf->h - 30  || $lImprime  ) {

      $lImprime   = false;

      $pdf->SetFont($sLetra,'B',6);
      //$pdf->Cell(15,$nAlt,$aDados['nNumeroNota']                                    ,0,0,"C",0);
      $pdf->Cell(15,$nAlt,"Fornecedor: "                                            ,0,0,"L",0);
      $pdf->Cell(120,$nAlt,$aDados['sNomeFornecedor']                               ,0,1,"L",0);
      //$pdf->Cell(20,$nAlt,"Data: "                                                  ,0,0,"R",0);
      //$pdf->Cell(20,$nAlt,db_formatar($aDados['dtData'],'d')                        ,0,1,"C",0);

      $pdf->SetFont($sLetra,'B',6);
      $pdf->Cell(15,$nAlt,"Número da NF"                                            ,1,0,"C",1);
      $pdf->Cell(15,$nAlt,"Data Nota"                                               ,1,0,"C",1);
      $pdf->Cell(15,$nAlt,"Cod. Item"                                               ,1,0,"C",1);
      $pdf->Cell(80,$nAlt,"Descricao do material"                                   ,1,0,"C",1);
      $pdf->Cell(19,$nAlt,"Ordem de Compra"                                         ,1,0,"C",1);
      $pdf->Cell(15,$nAlt,"Quantidade"                                              ,1,0,"C",1);
      $pdf->Cell(15,$nAlt,"Vlr. Unitário"                                           ,1,0,"C",1);
      $pdf->Cell(18,$nAlt,"Vlr. Total"                                              ,1,1,"C",1);

    }

    foreach ( $aDados['aItens'] as $i => $oDados ) {

      if ( $pdf->gety() > $pdf->h - 30  ) {

        $pdf->AddPage();

        $pdf->SetFont($sLetra,'B',6);
        //$pdf->Cell(15,$nAlt,$aDados['nNumeroNota']                                  ,0,0,"C",0);
        $pdf->Cell(15,$nAlt,"Fornecedor: "                                          ,0,0,"L",0);
        $pdf->Cell(120,$nAlt,$aDados['sNomeFornecedor']                             ,0,1,"L",0);
        //$pdf->Cell(20,$nAlt,"Data: "                                                ,0,0,"R",0);
        //$pdf->Cell(20,$nAlt,db_formatar($aDados['dtData'],'d')                      ,0,1,"C",0);

        $pdf->SetFont($sLetra,'B',6);
        $pdf->Cell(15,$nAlt,"Número da NF"                                          ,1,0,"C",1);
        $pdf->Cell(15,$nAlt,"Data Nota"                                             ,1,0,"C",1);
        $pdf->Cell(15,$nAlt,"Cod. Item"                                             ,1,0,"C",1);
        $pdf->Cell(80,$nAlt,"Descricao do material"                                 ,1,0,"C",1);
        $pdf->Cell(19,$nAlt,"Ordem de Compra"                                       ,1,0,"C",1);
        $pdf->Cell(15,$nAlt,"Quantidade"                                            ,1,0,"C",1);
        $pdf->Cell(15,$nAlt,"Vlr. Unitário"                                         ,1,0,"C",1);
        $pdf->Cell(18,$nAlt,"Vlr. Total"                                            ,1,1,"C",1);

      }

      $pdf->SetFont($sLetra,'',5);
      $pdf->Cell(15,$nAlt,$oDados->iNumero                                        ,1,0,"C",0);
      $pdf->Cell(15,$nAlt,db_formatar($oDados->dtData,'d')                        ,1,0,"C",0);
      $pdf->Cell(15,$nAlt,$oDados->iCodMater                                        ,"TRB",0,"C",0);
      $pdf->Cell(80,$nAlt,substr($oDados->sDescMater,0,60)                          ,1,0,"C",0);
      $pdf->Cell(19,$nAlt,$oDados->iCodOrdem                                        ,1,0,"C",0);
      $pdf->Cell(15,$nAlt,$oDados->iQuantidade                                      ,1,0,"C",0);
      $pdf->Cell(15,$nAlt,db_formatar($oDados->nValorUnit,'f')                      ,1,0,"C",0);
      $pdf->Cell(18,$nAlt,db_formatar($oDados->nVlrTotal,'f')                       ,"TLB",1,"C",0);

      $nTotalRegistros++;
    }

  } else if ( isset($oGet->agrupar) && $oGet->agrupar == 'agrpm' ) {
    // agrupar por material

    if ( $pdf->gety() > $pdf->h - 30  || $lImprime  ) {

      $lImprime   = false;

      $pdf->SetFont($sLetra,'B',6);
      //$pdf->Cell(15,$nAlt,$aDados['nNumeroNota']                                    ,0,0,"C",0);
      $pdf->Cell(15,$nAlt,"MATERIAL: "                                              ,0,0,"L",0);
      $pdf->Cell(120,$nAlt,$aDados['iCodMater'] . ' - ' . $aDados['sNomeMaterial']  ,0,1,"L",0);
      //$pdf->Cell(20,$nAlt,"Data: "                                                  ,0,0,"R",0);
      //$pdf->Cell(20,$nAlt,db_formatar($aDados['dtData'],'d')                        ,0,1,"C",0);

      $pdf->SetFont($sLetra,'B',6);
      $pdf->Cell(15,$nAlt,"Número da NF"                                            ,1,0,"C",1);
      $pdf->Cell(15,$nAlt,"Data Nota"                                               ,1,0,"C",1);
      $pdf->Cell(15,$nAlt,"Cod. Forne."                                             ,1,0,"C",1);
      $pdf->Cell(80,$nAlt,"Fornecedor"                                              ,1,0,"C",1);
      $pdf->Cell(19,$nAlt,"Ordem de Compra"                                         ,1,0,"C",1);
      $pdf->Cell(15,$nAlt,"Quantidade"                                              ,1,0,"C",1);
      $pdf->Cell(15,$nAlt,"Vlr. Unitário"                                           ,1,0,"C",1);
      $pdf->Cell(18,$nAlt,"Vlr. Total"                                              ,1,1,"C",1);

    }

    foreach ( $aDados['aItens'] as $i => $oDados ) {

	    if ( $pdf->gety() > $pdf->h - 30  ) {

	      $pdf->AddPage();

	      $pdf->SetFont($sLetra,'B',6);
	      //$pdf->Cell(15,$nAlt,$aDados['nNumeroNota']                                  ,0,0,"C",0);
	      $pdf->Cell(15,$nAlt,"MATERIAL: "                                          ,0,0,"L",0);
	      $pdf->Cell(120,$nAlt,$aDados['sNomeMaterial']                             ,0,1,"L",0);
	      //$pdf->Cell(20,$nAlt,"Data: "                                                ,0,0,"R",0);
	      //$pdf->Cell(20,$nAlt,db_formatar($aDados['dtData'],'d')                      ,0,1,"C",0);

	      $pdf->SetFont($sLetra,'B',6);
	      $pdf->Cell(15,$nAlt,"Número da NF"                                          ,1,0,"C",1);
        $pdf->Cell(15,$nAlt,"Data Nota"                                             ,1,0,"C",1);
	      $pdf->Cell(15,$nAlt,"Cod. Forne."                                           ,1,0,"C",1);
	      $pdf->Cell(80,$nAlt,"Fornecedor"                                            ,1,0,"C",1);
	      $pdf->Cell(19,$nAlt,"Ordem de Compra"                                       ,1,0,"C",1);
	      $pdf->Cell(15,$nAlt,"Quantidade"                                            ,1,0,"C",1);
	      $pdf->Cell(15,$nAlt,"Vlr. Unitário"                                         ,1,0,"C",1);
	      $pdf->Cell(18,$nAlt,"Vlr. Total"                                            ,1,1,"C",1);

	    }

      $pdf->SetFont($sLetra,'',5);
      $pdf->Cell(15,$nAlt,$oDados->iNumero                                        ,1,0,"C",0);
	    $pdf->Cell(15,$nAlt,db_formatar($oDados->dtData,'d')                        ,1,0,"C",0);
      $pdf->Cell(15,$nAlt,$oDados->iCodForneced                                   ,"TRB",0,"C",0);
      $pdf->Cell(80,$nAlt,substr($oDados->sNomeForneced,0,60)                     ,1,0,"L",0);
      $pdf->Cell(19,$nAlt,$oDados->iCodOrdem                                        ,1,0,"C",0);
      $pdf->Cell(15,$nAlt,$oDados->iQuantidade                                      ,1,0,"C",0);
      $pdf->Cell(15,$nAlt,db_formatar($oDados->nValorUnit,'f')                      ,1,0,"C",0);
      $pdf->Cell(18,$nAlt,db_formatar($oDados->nVlrTotal,'f')                       ,"TLB",1,"C",0);

      $nTotalRegistros++;
    }

  // agrupar pelos outros casos
  } else {

  	 if ( $pdf->gety() > $pdf->h - 30  || $lImprime  ) {

      $lImprime   = false;

      $pdf->SetFont($sLetra,'B',6);
      $pdf->Cell(15,$nAlt,$aDados['nNumeroNota']                                    ,0,0,"C",0);
      $pdf->Cell(15,$nAlt,"Fornecedor: "                                            ,0,0,"L",0);
      $pdf->Cell(120,$nAlt,$aDados['sNomeFornecedor']                               ,0,0,"L",0);
      $pdf->Cell(20,$nAlt,"Data: "                                                  ,0,0,"R",0);
      $pdf->Cell(20,$nAlt,db_formatar($aDados['dtData'],'d')                        ,0,1,"C",0);

      $pdf->SetFont($sLetra,'B',6);
      $pdf->Cell(20,$nAlt,"Cod. Item"                                               ,1,0,"C",1);
      $pdf->Cell(82,$nAlt,"Descricao do material"                                   ,1,0,"C",1);
      $pdf->Cell(30,$nAlt,"Ordem de Compra"                                         ,1,0,"C",1);
      $pdf->Cell(20,$nAlt,"Quantidade"                                              ,1,0,"C",1);
      $pdf->Cell(20,$nAlt,"Vlr. Unitário"                                           ,1,0,"C",1);
      $pdf->Cell(20,$nAlt,"Vlr. Total"                                              ,1,1,"C",1);

    }

    foreach ( $aDados['aItens'] as $i => $oDados ) {

            if ( $pdf->gety() > $pdf->h - 30  ) {

              $pdf->AddPage();

              $pdf->SetFont($sLetra,'B',6);
              $pdf->Cell(15,$nAlt,$aDados['nNumeroNota']                                  ,0,0,"C",0);
              $pdf->Cell(15,$nAlt,"Fornecedor: "                                          ,0,0,"L",0);
              $pdf->Cell(120,$nAlt,$aDados['sNomeFornecedor']                             ,0,0,"L",0);
              $pdf->Cell(20,$nAlt,"Data: "                                                ,0,0,"R",0);
              $pdf->Cell(20,$nAlt,db_formatar($aDados['dtData'],'d')                      ,0,1,"C",0);

              $pdf->SetFont($sLetra,'B',6);
              $pdf->Cell(20,$nAlt,"Cod. Item"                                             ,1,0,"C",1);
              $pdf->Cell(82,$nAlt,"Descricao do material"                                 ,1,0,"C",1);
              $pdf->Cell(30,$nAlt,"Ordem de Compra"                                       ,1,0,"C",1);
              $pdf->Cell(20,$nAlt,"Quantidade"                                            ,1,0,"C",1);
              $pdf->Cell(20,$nAlt,"Vlr. Unitário"                                         ,1,0,"C",1);
              $pdf->Cell(20,$nAlt,"Vlr. Total"                                            ,1,1,"C",1);

            }

      $pdf->SetFont($sLetra,'',5);
      $pdf->Cell(20,$nAlt,$oDados->iCodMater                                        ,"TRB",0,"C",0);
      $pdf->Cell(82,$nAlt,substr($oDados->sDescMater,0,60)                          ,1,0,"C",0);
      $pdf->Cell(30,$nAlt,$oDados->iCodOrdem                                        ,1,0,"C",0);
      $pdf->Cell(20,$nAlt,$oDados->iQuantidade                                      ,1,0,"C",0);
      $pdf->Cell(20,$nAlt,db_formatar($oDados->nValorUnit,'f')                      ,1,0,"C",0);
      $pdf->Cell(20,$nAlt,db_formatar($oDados->nVlrTotal,'f')                       ,"TLB",1,"C",0);

      $nTotalRegistros++;
    }

  }

  $pdf->SetFont($sLetra,'B',6);
  $pdf->Cell(192,0,""                                                               ,"T",1,"C",0);
  $pdf->Cell(20,$nAlt,"Total Registros: "                                           ,0,0,"C",0);
  $pdf->Cell(82,$nAlt,$nTotalRegistros                                              ,0,0,"L",0);
  $pdf->Cell(30,$nAlt,"Total: "                                                     ,0,0,"R",0);
  $pdf->Cell(20,$nAlt,$aDados['iQuantTotal']                                        ,0,0,"C",0);
  $pdf->Cell(20,$nAlt,db_formatar($aDados['nValorTotalUnit'],'f')                   ,0,0,"C",0);
  $pdf->Cell(20,$nAlt,db_formatar($aDados['nValorSomaTotal'],'f')                   ,0,1,"C",0);
  $pdf->Cell(192,2,""                                                               ,0,1,"C",0);

  $lImprime        = true;
  $nTotalRegistros = 0;

  $nTotalGeralQuant  += $aDados['iQuantTotal'];
  $nTotalGeralVlrUnt += $aDados['nValorTotalUnit'];
  $nTotalGeralVlrTot += $aDados['nValorSomaTotal'];

  $nTotalGerlaReg++;
}

$pdf->SetFont($sLetra,'B',6);
$pdf->Cell(192,0,""                                                               ,0,1,"C",0);
$pdf->Cell(192,0,""                                                               ,"T",1,"C",0);
$pdf->Cell(28,$nAlt,"Total Geral de Registros: "                                  ,0,0,"L",0);
$pdf->Cell(74,$nAlt,$nTotalGerlaReg                                               ,0,0,"L",0);
$pdf->Cell(30,$nAlt,"Total Geral: "                                               ,0,0,"R",0);
$pdf->Cell(20,$nAlt,$nTotalGeralQuant                                             ,0,0,"C",0);
$pdf->Cell(20,$nAlt,db_formatar($nTotalGeralVlrUnt,'f')                           ,0,0,"C",0);
$pdf->Cell(20,$nAlt,db_formatar($nTotalGeralVlrTot,'f')                           ,0,1,"C",0);
$pdf->Cell(192,2,""                                                               ,0,1,"C",0);

$pdf->Output();
?>
