<?
include ("fpdf151/pdf.php");
include ("libs/db_sql.php");
include ("libs/db_utils.php");
include ("classes/db_matestoque_classe.php");
include ("classes/db_matestoqueitem_classe.php");
include ("classes/db_transmater_classe.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$oGet = db_utils::postMemory($_GET,0);

//$clmatestoque     = new cl_matestoque;
//$clmatestoqueitem = new cl_matestoqueitem;
$cltransmater     = new cl_transmater;

$sLetra  = 'arial';
$sInfo   = "";
$sOrder  = null;
$sWhere  = "";
$sAnd    = "";
$iInstit = db_getsession('DB_instit');

if ( isset($iInstit) && !empty($iInstit) ) {
  $sWhere .= "{$sAnd} e60_instit = {$iInstit} ";
  $sAnd    = " and ";	
}

if ( isset($oGet->codmater) && $oGet->codmater != "" ) {
	$sWhere .= "{$sAnd} m70_codmatmater = {$oGet->codmater} ";
	$sAnd    = " and ";
}

if ( isset($oGet->listatipo) && $oGet->listatipo != "" ) {
	
	if ( isset ($oGet->vertipo) && $oGet->vertipo == "com" ) {
		
		$sWhere .= "{$sAnd} z01_numcgm in ({$oGet->listatipo})";
		$sAnd    = " and ";
	} else {
		
		$sWhere .= "{$sAnd} z01_numcgm not in ($oGet->listatipo)";
		$sAnd    = " and ";
	}
}

if ( isset($oGet->dtInicial) && isset($oGet->dtFinal) ) {
	
  $dtInicial = implode("-", array_reverse(explode("/", $oGet->dtInicial)));
  $dtFinal   = implode("-", array_reverse(explode("/", $oGet->dtFinal)));
	if ( !empty($dtInicial) && !empty($dtFinal) ) {
		
	  $sWhere .= "{$sAnd} c70_data between '{$dtInicial}' and '{$dtFinal}' ";
	  $sAnd    = " and ";
	  $sInfo = "De {$oGet->dtInicial} até {$oGet->dtFinal}";
	} else if ( !empty($dtInicial) ) {
		
	  $sWhere .= "{$sAnd} c70_data >= '{$dtInicial}' ";
	  $sAnd    = " and ";
	  $sInfo   = "Apartir de {$oGet->dtInicial}";
	} else  if ( !empty($dtFinal) ) {
		
	  $sWhere .= "{$sAnd} c70_data <= '{$dtFinal}' ";
	  $sAnd    = " and ";
	  $info    = "Até {$oGet->dtFinal}";
	}
}

if ( isset($oGet->ordenar) && $oGet->ordenar == 'ordfrn' ) {
	$sOrder = "z01_numcgm";
} else if ( isset($oGet->ordenar) && $oGet->ordenar == 'ordnt' ) {
  $sOrder = "e69_numero";
} else if ( isset($oGet->ordenar) && $oGet->ordenar == 'orddt' ) {
  $sOrder = "c70_data";
}

$head3 = "Relatório de Compras";
$head5 = "Exercício: ".db_getsession("DB_anousu");
if ( !empty($dtInicial) && !empty($dtFinal) ) {
  $head7 = "Período: {$oGet->dtInicial} à $oGet->dtFinal";
}
/*
$sCampos  = "matmater.m60_codmater, matmater.m60_descr, db_depart.instit,                                             ";
$sCampos .= "empnota.e69_codnota, empnota.e69_numero, empnota.e69_dtnota,                                             "; 
$sCampos .= "matordem.m51_numcgm, matordem.m51_codordem, cgm.z01_numcgm, cgm.z01_nome, cgm.z01_cgccpf,                 "; 
$sCampos .= "matestoqueitem.m71_quant, matestoqueitem.m71_valor, matestoqueitem.m71_data ,matunid.m61_descr           ";
*/
//$sSqlMatestoque = $clmatestoque->sql_query_ent(null, $sCampos, $sOrder, $sWhere);
//$rsMatestoque   = $clmatestoque->sql_record($sSqlMatestoque);

$sSqlMatestoque = "select distinct empempenho.e60_numemp,((e72_vlrliq-e72_vlranu)/e72_qtd) as e62_vlrun,(e72_vlrliq-e72_vlranu) as e62_vltot,
empnotaitem.e72_qtd as e62_quant,cgm.z01_numcgm, cgm.z01_nome, 
cgm.z01_cgccpf,pcmater.pc01_descrmater,pcmater.pc01_codmater,pc01_complmater,
case 
                    when matunid.m61_descr is null then mu2.m61_descr 
                    else matunid.m61_descr 
                    end as m61_descr
from empautitem  
inner  join empempaut            on empempaut.e61_autori               = empautitem.e55_autori                                                    
left join matunid on matunid.m61_codmatunid = empautitem.e55_unid 
inner join pcmater on pcmater.pc01_codmater = empautitem.e55_item
join empempenho on empempenho.e60_numemp              = empempaut.e61_numemp                
join empempitem on  pcmater.pc01_codmater = empempitem.e62_item and empempitem.e62_numemp = empempenho.e60_numemp
join empnotaitem on empnotaitem.e72_empempitem = empempitem.e62_sequencial 
join empnota on empnotaitem.e72_codnota = empnota.e69_codnota 
join pagordemnota on pagordemnota.e71_codnota = empnota.e69_codnota
join pagordem on pagordemnota.e71_codord = pagordem.e50_codord
join pagordemele on pagordemele.e53_codord = pagordem.e50_codord
join conlancamord on conlancamord.c80_codord = pagordem.e50_codord
join conlancamdoc on conlancamord.c80_codlan = conlancamdoc.c71_codlan and conlancamdoc.c71_coddoc in (5,35,37)
join conlancam on conlancamdoc.c71_codlan = conlancam.c70_codlan
join cgm on cgm.z01_numcgm = empempenho.e60_numcgm
join pcmaterele on pcmaterele.pc07_codmater = pcmater.pc01_codmater
join orcelemento on orcelemento.o56_codele = pcmaterele.pc07_codele
JOIN transmater ON m63_codpcmater = pc01_codmater
JOIN matmater ON m63_codmatmater = m60_codmater
JOIN matunid mu2 ON mu2.m61_codmatunid = m60_codmatunid
where substr(o56_elemento, 2, 6) in('339030','339032','449030','449052') and e71_anulado = 'f' and e53_vlrpag > 0  
and {$sWhere}  
order by z01_numcgm
";

$rsMatestoque = db_query($sSqlMatestoque);

if (pg_num_rows($rsMatestoque) == 0) {
	db_redireciona('db_erros.php?fechar=true&db_erro=Não existem registros  cadastrados.');
}

if ($oGet->TipoRel == 1) {

$pdf = new PDF();
$pdf->Open();
$pdf->addpage('L');
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


for ( $iInd = 0; $iInd  < pg_num_rows($rsMatestoque); $iInd++ ) {
          
  $oDados = db_utils::fieldsMemory($rsMatestoque,$iInd);
  //$rsDescItem = $cltransmater->sql_record($cltransmater->sql_query(null,"pcmater.pc01_descrmater","","matmater.m60_codmater = {$oDados->m60_codmater}"));

    $oDadosMatEstoque = new stdClass();
    $oDadosMatEstoque->iCodMater      = $oDados->pc01_codmater;
    $oDadosMatEstoque->sDescMater     = $oDados->pc01_descrmater.($oDados->pc01_complmater != '' ? ' - '.$oDados->pc01_complmater : '');
    $oDadosMatEstoque->iNumero        = $oDados->e69_numero;
    $oDadosMatEstoque->iNumCgm        = $oDados->z01_numcgm;
    //$oDadosMatEstoque->iCodOrdem      = $oDados->m51_codordem;
    $oDadosMatEstoque->sNomeForneced  = $oDados->z01_nome;
    $oDadosMatEstoque->sCnpj          = $oDados->z01_cgccpf;
    $oDadosMatEstoque->iQuantidade    = $oDados->e62_quant;
    $oDadosMatEstoque->sUnidade       = $oDados->m61_descr;
    $oDadosMatEstoque->nValorUnit     = $oDados->e62_vlrun;  	
    
    $oDadosMatEstoque->nVlrTotal      = $oDados->e62_vltot;
    
    $aDadosMatEstoque[$oDados->e69_codnota]['nNumeroNota']     = $oDadosMatEstoque->iNumero;
	  $aDadosMatEstoque[$oDados->e69_codnota]['sNomeFornecedor'] = $oDadosMatEstoque->sNomeForneced;
	  $aDadosMatEstoque[$oDados->e69_codnota]['sCnpj']           = $oDadosMatEstoque->sCnpj;
	  $aDadosMatEstoque[$oDados->e69_codnota]['aItens'][]        = $oDadosMatEstoque;
	  $aDadosMatEstoque[$oDados->e69_codnota]['iQuantTotal']     = $oDadosMatEstoque->iQuantidade;
	  $aDadosMatEstoque[$oDados->e69_codnota]['nValorTotalUnit'] = $oDadosMatEstoque->nValorUnit;
	  $aDadosMatEstoque[$oDados->e69_codnota]['nValorSomaTotal'] = $oDadosMatEstoque->nVlrTotal; 
	  $aDadosMatEstoque[$oDados->e69_codnota]['sUnidade']        = $oDadosMatEstoque->sUnidade;
	   	                                     
}
/**
 * titulo para o relatorio
 */
$pdf->SetFont($sLetra,'B',10);
$pdf->Cell(280,$nAlt,"Relatório de Compras",1,1,"C",1);

$pdf->SetFont($sLetra,'B',6);
$pdf->Cell(20,$nAlt,"Cnpj"                                                    ,1,0,"C",1);
$pdf->Cell(80,$nAlt,"Fornecedor"                                              ,1,0,"C",1);
$pdf->Cell(100,$nAlt,"Descrição do material"                                   ,1,0,"C",1);
$pdf->Cell(20,$nAlt,"Preço Unitário"                                          ,1,0,"C",1);
$pdf->Cell(20,$nAlt,"Quantidade"                                              ,1,0,"C",1);
$pdf->Cell(20,$nAlt,"Unidade"                                                 ,1,0,"C",1);
$pdf->Cell(20,$nAlt,"Vlr. Total"                                              ,1,1,"C",1);

foreach ( $aDadosMatEstoque as $iCodInd => $aDados ) {
  	
    /*if ( $pdf->gety() > $pdf->h - 30  || $lImprime  ) {
      
      $lImprime   = false;
      
      $pdf->SetFont($sLetra,'B',6);
      $pdf->Cell(20,$nAlt,"Cnpj"                                                    ,1,0,"C",1);
      $pdf->Cell(90,$nAlt,"Fornecedor"                                              ,1,0,"C",1);
      $pdf->Cell(90,$nAlt,"Descricao do material"                                   ,1,0,"C",1);
      $pdf->Cell(20,$nAlt,"Preço Unitário"                                          ,1,0,"C",1);
      $pdf->Cell(20,$nAlt,"Quantidade"                                              ,1,0,"C",1);
      $pdf->Cell(20,$nAlt,"Unidade"                                                 ,1,0,"C",1);
      $pdf->Cell(20,$nAlt,"Vlr. Total"                                              ,1,1,"C",1);
      
    }*/
    
    foreach ( $aDados['aItens'] as $i => $oDados ) {
    	
	    if ( $pdf->gety() > $pdf->h - 30  ) {
	      
	      $pdf->AddPage('L');
	    
	      /*$pdf->SetFont($sLetra,'B',6);
	      $pdf->Cell(15,$nAlt,$aDados['nNumeroNota']                                  ,0,0,"C",0);
	      $pdf->Cell(15,$nAlt,"Fornecedor: "                                          ,0,0,"L",0);
	      $pdf->Cell(120,$nAlt,$aDados['sNomeFornecedor']                             ,0,0,"L",0);
	      $pdf->Cell(20,$nAlt,"Data: "                                                ,0,0,"R",0);
	      $pdf->Cell(20,$nAlt,db_formatar($aDados['dtData'],'d')                      ,0,1,"C",0);*/
	      
	      /*$pdf->SetFont($sLetra,'B',6);
	      $pdf->Cell(20,$nAlt,"Cnpj"                                                    ,1,0,"C",1);
        $pdf->Cell(90,$nAlt,"Fornecedor"                                              ,1,0,"C",1);
        $pdf->Cell(90,$nAlt,"Descricao do material"                                   ,1,0,"C",1);
        $pdf->Cell(20,$nAlt,"Preço Unitário"                                          ,1,0,"C",1);
        $pdf->Cell(20,$nAlt,"Quantidade"                                              ,1,0,"C",1);
        $pdf->Cell(20,$nAlt,"Unidade"                                                 ,1,0,"C",1);
        $pdf->Cell(20,$nAlt,"Vlr. Total"                                              ,1,1,"C",1);*/
	      
	    }
	    
      /*$pdf->SetFont($sLetra,'',5);
      $pdf->Cell(20,$nAlt,$oDados->iCodMater                                        ,"TRB",0,"C",0);
      $pdf->Cell(82,$nAlt,substr($oDados->sDescMater,0,60)                          ,1,0,"C",0);
      $pdf->Cell(30,$nAlt,$oDados->iCodOrdem                                        ,1,0,"C",0);
      $pdf->Cell(20,$nAlt,$oDados->iQuantidade                                      ,1,0,"C",0);
      $pdf->Cell(20,$nAlt,db_formatar($oDados->nValorUnit,'f')                      ,1,0,"C",0);
      $pdf->Cell(20,$nAlt,db_formatar($oDados->nVlrTotal,'f')                       ,"TLB",1,"C",0);*/
      
      if (strlen($oDados->sDescMater) > 78 || strlen($oDados->sNomeForneced) > 60) {
		  
	  	  $aDescricaoItem = quebrar_texto($oDados->sDescMater,78);
	  	  $aNomeFornec    = quebrar_texto($oDados->sNomeForneced,60);
	  	  if (count($aDescricaoItem) > count($aNomeFornec)) {
	  	  	$alt_novo = count($aDescricaoItem);
	  	  } else {
	  	  	$alt_novo = count($aNomeFornec);
	  	  }
			
		  } else {
			  $alt_novo = 1;
		  }  
	    
      $pdf->SetFont($sLetra,'',6);
	    $pdf->Cell(20,$nAlt*$alt_novo,$oDados->sCnpj                                        ,1,0,"C",0);
      
      /**
       * imprimir nome fornecedor
       */
      if (strlen($oDados->sNomeForneced) > 60) {
	  
	      $pos_x = $pdf->x;
	      $pos_y = $pdf->y;
	      $pdf->Cell(80,$nAlt*$alt_novo,"",1,0,"L",0);
	      $pdf->x = $pos_x;
	      $pdf->y = $pos_y;
	      foreach ($aNomeFornec as $sNomeFornec) {
	        $pdf->cell(80,($nAlt),$sNomeFornec,0,1,"L",0); 
	  	    $pdf->x=$pos_x;	
	      }
	      $pdf->x = $pos_x+80;
	      $pdf->y=$pos_y;
	    
	    } else {
	      $pdf->Cell(80,$nAlt*$alt_novo,$oDados->sNomeForneced,1,0,"L",0);
	    }
      
      /**
       * imprimir descricao do item
       */
      if (strlen($oDados->sDescMater) > 78) {
	  
	      $pos_x = $pdf->x;
	      $pos_y = $pdf->y;
	      $pdf->Cell(100,$nAlt*$alt_novo,"",1,0,"L",0);
	      $pdf->x = $pos_x;
	      $pdf->y = $pos_y;
	      foreach ($aDescricaoItem as $sDescricaoItem) {
	        $pdf->cell(100,($nAlt),$sDescricaoItem,0,1,"L",0); 
	  	    $pdf->x=$pos_x;	
	      }
	      $pdf->x = $pos_x+100;
	      $pdf->y=$pos_y;
	    
	    } else {
	      $pdf->Cell(100,$nAlt*$alt_novo,$oDados->sDescMater,1,0,"L",0);
	    }
      
      $pdf->Cell(20,$nAlt*$alt_novo,db_formatar($oDados->nValorUnit,'f')                    ,1,0,"C",0);
      $pdf->Cell(20,$nAlt*$alt_novo,$oDados->iQuantidade                                    ,1,0,"C",0);
      $pdf->Cell(20,$nAlt*$alt_novo,$oDados->sUnidade                                     ,1,0,"C",0);
      $pdf->Cell(20,$nAlt*$alt_novo,db_formatar($oDados->nVlrTotal,'f')                     ,1,1,"C",0);
      
      $nTotalRegistros++;
      
      $nTotalGeralVlrTot += $oDados->nVlrTotal;
  
      $nTotalGerlaReg++;
      
    }
  
  /*$pdf->SetFont($sLetra,'B',6);
  $pdf->Cell(192,0,""                                                               ,"T",1,"C",0);
  $pdf->Cell(20,$nAlt,"Total Registros: "                                           ,0,0,"C",0);
  $pdf->Cell(90,$nAlt,$nTotalRegistros                                              ,0,0,"L",0);
  $pdf->Cell(30,$nAlt,"Total: "                                                     ,0,0,"R",0);
  $pdf->Cell(20,$nAlt,$aDados['iQuantTotal']                                        ,0,0,"C",0);
  $pdf->Cell(20,$nAlt,db_formatar($aDados['nValorTotalUnit'],'f')                   ,0,0,"C",0);
  $pdf->Cell(20,$nAlt,db_formatar($aDados['nValorSomaTotal'],'f')                   ,0,1,"C",0);
  $pdf->Cell(192,2,""                                                               ,0,1,"C",0);*/
  
  $lImprime        = true;
  $nTotalRegistros = 0;
  
}

$pdf->AddPage('L');
/*$pdf->SetFont($sLetra,'B',6);
$pdf->Cell(192,0,""                                                               ,0,1,"C",0);
$pdf->Cell(192,0,""                                                               ,"T",1,"C",0);

$pdf->Cell(20,$nAlt,""                                                            ,0,0,"C",0);
$pdf->Cell(28,$nAlt,"Total Geral de Registros: "                                  ,0,0,"L",0);
$pdf->Cell(74,$nAlt,$nTotalGerlaReg                                               ,0,0,"L",0);
$pdf->Cell(30,$nAlt,"Total Geral: "                                               ,0,0,"R",0);
$pdf->Cell(20,$nAlt,$nTotalGeralQuant                                             ,0,0,"C",0);
$pdf->Cell(20,$nAlt,db_formatar($nTotalGeralVlrUnt,'f')                           ,0,0,"C",0);
$pdf->Cell(20,$nAlt,db_formatar($nTotalGeralVlrTot,'f')                           ,0,1,"C",0);
$pdf->Cell(192,2,""                                                               ,0,1,"C",0);*/

$pdf->SetFont($sLetra,'B',6);
$pdf->Cell(140,$nAlt,"Total de Compras"                                         ,1,0,"C",1);
$pdf->Cell(140,$nAlt,"Valor Total"                                              ,1,1,"C",1);

$pdf->Cell(140,$nAlt,$nTotalGerlaReg                                            ,1,0,"C",0);
$pdf->Cell(140,$nAlt,db_formatar($nTotalGeralVlrTot,'f')                        ,1,1,"C",0);

$pdf->Output();

} else {
	/**
	 * $oGet->TipoRel == 2 exrpotar para excel
	 */
	
	$aDadosCsv = array();
	$aDadosAgrupadosCsv = array();
	
  $aDadosCsv['Titulo']   = "Relatório de Compras";
  $aDadosAgrupadosCsv[] = $aDadosCsv;
	
  $aDadosCsv = array();
	$aDadosCsv['sCnpj']         = "Cnpj";
  $aDadosCsv['sNomeForneced'] = "Fornecedor";
  $aDadosCsv['sDescMater']    = "Descrição do material";
  $aDadosCsv['nValorUnit']    = "Preço Unitário";
  $aDadosCsv['iQuantidade']   = "Quantidade";
  $aDadosCsv['sUnidade']      = "Unidade";
  $aDadosCsv['nVlrTotal']     = "Vlr. Total";
  
  $aDadosAgrupadosCsv[] = $aDadosCsv;
  
  for ( $iInd = 0; $iInd  < pg_num_rows($rsMatestoque); $iInd++ ) {

  	
    $oDados = db_utils::fieldsMemory($rsMatestoque,$iInd);
  //$rsDescItem = $cltransmater->sql_record($cltransmater->sql_query(null,"pcmater.pc01_descrmater","","matmater.m60_codmater = {$oDados->m60_codmater}"));

    $aDadosCsv = array();
    $aDadosCsv['sCnpj']          = $oDados->z01_cgccpf;
    $aDadosCsv['sNomeForneced']  = $oDados->z01_nome;
    $aDadosCsv['sDescMater']     = $oDados->pc01_complmater;
    $aDadosCsv['nValorUnit']     = $oDados->e62_vlrun;
    $aDadosCsv['iQuantidade']    = $oDados->e62_quant;
    $aDadosCsv['sUnidade']       = $oDados->m61_descr;
    $aDadosCsv['nVlrTotal']      = $oDados->e62_vltot;
	   	                                     
    $aDadosAgrupadosCsv[] = $aDadosCsv;
    
    $nTotalGeralVlrTot += $oDados->e62_vltot;
    $nTotalGerlaReg++;
    
  }
  
  $aDadosCsv = array();
  $aDadosCsv['Total']   = "Total de Compras";
  $aDadosCsv['VlTotal'] = "Valor Total";
  $aDadosAgrupadosCsv[] = $aDadosCsv;

  $aDadosCsv = array();
  $aDadosCsv['Total']   = $nTotalGerlaReg;
  $aDadosCsv['VlTotal'] = $nTotalGeralVlrTot;
  
  $aDadosAgrupadosCsv[] = $aDadosCsv;
  //echo "<pre>";
  //print_r($aDadosAgrupadosCsv);
  arrayTocsv($aDadosAgrupadosCsv);
  //echo "<a  href='db_download.php?arquivo=mat2_relcompra002.csv'>Arquivo</a><br>";
  download_arquivo("mat2_relcompra002.csv");
    echo "<script>
            $(window).ready(function() {
               window.close();
            });

        </script>";
	
}

function quebrar_texto($texto,$tamanho) {
	
	$aTexto = explode(" ", $texto);
	$string_atual = "";
	foreach ($aTexto as $word) {
		$string_ant = $string_atual;
		$string_atual .= " ".$word;
		if (strlen($string_atual) > $tamanho) {
		  $aTextoNovo[] = trim($string_ant);
		  $string_ant   = "";
		  $string_atual = $word;
		}
	}
	$aTextoNovo[] = trim($string_atual);
	return $aTextoNovo;
	
}

function arrayTocsv(array &$array)
{
   if (count($array) == 0) {
     return null;
   }
   $df = fopen("mat2_relcompra002.csv", 'w');
   //fputcsv($df, array_keys(reset($array)));
   foreach ($array as $row) {
   	 $sLinha = implode(";", $row); 
     fputs($df, $sLinha);
     fputs($df,"\r\n");
   }
   fclose($df);
}

function download_arquivo($filename) {
	
  header("Pragma: public");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Cache-Control: private",false);
  header("Content-Type: text/csv");
  header("Content-Disposition: attachment; filename=\"".basename($filename)."\";");
  header("Content-Transfer-Encoding: binary");
  header("Content-Length: ".@filesize($filename));
  set_time_limit(0);
  flush();
  @readfile($filename);
  
} 


?>
