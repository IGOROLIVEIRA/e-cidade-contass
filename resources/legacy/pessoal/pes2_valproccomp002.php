<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2013  DBselller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */

require_once("fpdf151/pdf.php");
require_once("libs/db_utils.php");

$oGet = db_utils::postMemory($_GET);
// ordenar por projativ
$order = '';
if($projeto == 's')
	$order = ' order by o58_projativ ';
if($fonte == 's')
	$order = ' order by o58_codigo ';	
if($fonte == 's' and $projeto == 's')
	$order = ' order by o58_codigo,  o58_projativ ';	

$sSqlDadosArquivo = "select distinct 
                            rh89_mesusu||' / '||rh89_anousu as competencia_liquidadcao,
														z01_numcgm        as numcgm,
														z01_nome          as nome,
														rh89_valorserv    as valor_servico,
														rh89_valorretinss as valor_inss,
														rh89_codord       as ordem_pgto,
														rh89_dataliq      as data_liquidacao,
														e60_codemp        as codigo_empenho,
														e60_anousu        as ano_usu,
															o58_codigo,
															o58_projativ,
															o55_descr,
															o15_descr,
														case
														  when rh90_sequencial is not null then 'SIM' else 'NÃO'
														end as enviado_sefip
 											 from rhautonomolanc
							inner join cgm                   on cgm.z01_numcgm                            = rhautonomolanc.rh89_numcgm
                            inner join pagordem              on rh89_codord                               = e50_codord
                            inner join empempenho            on e50_numemp                                = e60_numemp
							inner join orcdotacao on (o58_coddot,o58_anousu) 					= (e60_coddot,e60_anousu)	
							inner join orcprojativ on (o55_projativ,o55_anousu)					= (o58_projativ,o58_anousu)
							inner join orctiporec on o15_codigo 								= o58_codigo
														left  join rhsefiprhautonomolanc on rhsefiprhautonomolanc.rh92_rhautonomolanc = rhautonomolanc.rh89_sequencial
														left  join rhsefip               on rhsefip.rh90_sequencial                   = rhsefiprhautonomolanc.rh92_rhsefip
														                                and rhsefip.rh90_ativa is true
 										where rhautonomolanc.rh89_anousu = {$oGet->iAnoCompetencia}
											and rhautonomolanc.rh89_mesusu = {$oGet->iMesCompetencia}  
											$order";
// echo $sSqlDadosArquivo;exit;
$rsDadosArquivo = db_query($sSqlDadosArquivo);										  
$iLinhasArquivo = pg_num_rows($rsDadosArquivo);										  

if ($iLinhasArquivo == 0 ) {
	$sMsg = "Nenhum registro encontrado para a competência {$oGet->iAnoCompetencia}/{$oGet->iMesCompetencia}";
	db_redireciona("db_erros.php?fechar=true&db_erro={$sMsg}");
}

										  
$head2 = " Valores Processados por Competência ";										  
$head3 = " Competência : ".str_pad($oGet->iMesCompetencia,2,'0',STR_PAD_LEFT)."/{$oGet->iAnoCompetencia}";

$oPdf = new PDF();
$oPdf->Open();

$oPdf->AliasNbPages();
$oPdf->SetFillColor(235);

$iFonte    = 8;
$iAlt      = 5;
$iPreenche = 1;

imprimeCab($oPdf,$iAlt,$iFonte,true);
//ini_set('display_errors', 'On');

for ( $iInd=0; $iInd < $iLinhasArquivo; $iInd++ ) {
  
  $oDadosGerados = db_utils::fieldsMemory($rsDadosArquivo,$iInd);
  $oDadosGeradosProx = db_utils::fieldsMemory($rsDadosArquivo,$iInd+1);
    
	imprimeCab($oPdf,$iAlt,$iFonte);
	
	if ($iPreenche == 1 ) {
		$iPreenche = 0;
	} else {
		$iPreenche = 1;
	}
	//quebra por projeto e por fonte
	if($projeto=='s' and $fonte =='s'){
		if(!$aux){
			$contvalor = 0;
			$contpatronal = 0;
			$continss = 0;
			$aux =  $oDadosGerados->o58_projativ;
			$oPdf->ln();
			$oPdf->SetFont('Arial','b',$iFonte);
			$oPdf->Cell(18 ,$iAlt,$oDadosGerados->o58_projativ,0,0,'C',0);
			$oPdf->Cell(30 ,$iAlt, '   ' ,0,0,'C');
			$oPdf->Cell(59 ,$iAlt,$oDadosGerados->o55_descr,0,1,'C',0);
			$oPdf->Cell(18 ,$iAlt,$oDadosGerados->o58_codigo,0,0,'C',0);
			$oPdf->Cell(30 ,$iAlt, '   ' ,0,0,'C');
			$oPdf->Cell(59 ,$iAlt,$oDadosGerados->o15_descr,0,1,'C',0);
			$oPdf->ln();
		}else{
			if($aux != $oDadosGerados->o58_projativ) {
				// impimindo total
				$oPdf->ln();
				$oPdf->SetFont('Arial','b',$iFonte);
				$oPdf->Cell(30 ,$iAlt, ' Total ' ,0,0,'C');
				$oPdf->Cell(20 ,$iAlt, '' ,0,0,'C',0);
				$oPdf->Cell(65 ,$iAlt, '' ,0,0,'L',0);
				$oPdf->Cell(25 ,$iAlt,db_formatar($contvalor,'f'),0,0,'C',0);
				$oPdf->Cell(24 ,$iAlt,db_formatar($contpatronal,'f'),0,0,'C',0);
				$oPdf->Cell(25 ,$iAlt,db_formatar($continss,'f'),0,1,'C',0);
				$oPdf->ln();
				$oPdf->ln();
				$oPdf->SetFont('Arial','b',$iFonte);
				$oPdf->Cell(18 ,$iAlt,$oDadosGerados->o58_projativ,0,0,'C',0);
				$oPdf->Cell(30 ,$iAlt, '   ' ,0,0,'C');
				$oPdf->Cell(59 ,$iAlt,$oDadosGerados->o55_descr,0,1,'C',0);
				$oPdf->Cell(18 ,$iAlt,$oDadosGerados->o58_codigo,0,0,'C',0);
				$oPdf->Cell(30 ,$iAlt, '   ' ,0,0,'C');
				$oPdf->Cell(59 ,$iAlt,$oDadosGerados->o15_descr,0,1,'C',0);
									
				$aux =  $oDadosGerados->o58_projativ;
				$contvalor = 0;
				$contpatronal = 0;
				$continss = 0;
			}
			elseif($aux == $oDadosGerados->o58_projativ && $oDadosGerados->o58_codigo != $aux2){
				$oPdf->ln();
				$oPdf->SetFont('Arial','b',$iFonte);
				$oPdf->Cell(30 ,$iAlt, ' Total ' ,0,0,'C');
				$oPdf->Cell(20 ,$iAlt, '' ,0,0,'C',0);
				$oPdf->Cell(65 ,$iAlt, '' ,0,0,'L',0);
				$oPdf->Cell(25 ,$iAlt,db_formatar($contvalor,'f'),0,0,'C',0);
				$oPdf->Cell(24 ,$iAlt,db_formatar($contpatronal,'f'),0,0,'C',0);
				$oPdf->Cell(25 ,$iAlt,db_formatar($continss,'f'),0,1,'C',0);
				$oPdf->ln();
				$oPdf->ln();
				$oPdf->SetFont('Arial','b',$iFonte);
				$oPdf->Cell(18 ,$iAlt,$oDadosGerados->o58_codigo,0,0,'C',0);
				$oPdf->Cell(30 ,$iAlt, '   ' ,0,0,'C');
				$oPdf->Cell(59 ,$iAlt,$oDadosGerados->o15_descr,0,1,'C',0);
				$oPdf->ln();
				$contvalor = 0;
				$contpatronal = 0;
				$continss = 0;
			}
		}	
		$aux2 =  $oDadosGerados->o58_codigo;
		$contvalor += $oDadosGerados->valor_servico;
		$contpatronal += $oDadosGerados->valor_servico*20/100;
		$continss += $oDadosGerados->valor_inss;
	}	
	//quebra por projeto
	if($projeto=='s' and $fonte =='n'){
		if(!$aux){
			$contvalor = 0;
			$contpatronal = 0;
			$continss = 0;
			$aux =  $oDadosGerados->o58_projativ;
			$oPdf->ln();
			$oPdf->SetFont('Arial','b',$iFonte);
			$oPdf->Cell(18 ,$iAlt,$oDadosGerados->o58_projativ,0,0,'C',0);
			$oPdf->Cell(30 ,$iAlt, '   ' ,0,0,'C');
			$oPdf->Cell(59 ,$iAlt,$oDadosGerados->o55_descr,0,1,'C',0);
			$oPdf->ln();
		}else{
			if($aux != $oDadosGerados->o58_projativ){
				// impimindo total
				$oPdf->ln();
				$oPdf->SetFont('Arial','b',$iFonte);
				$oPdf->Cell(30 ,$iAlt, ' Total ' ,0,0,'C');
				$oPdf->Cell(20 ,$iAlt, '' ,0,0,'C',0);
				$oPdf->Cell(65 ,$iAlt, '' ,0,0,'L',0);
				$oPdf->Cell(25 ,$iAlt,db_formatar($contvalor,'f'),0,0,'C',0);
				$oPdf->Cell(24 ,$iAlt,db_formatar($contpatronal,'f'),0,0,'C',0);
				$oPdf->Cell(25 ,$iAlt,db_formatar($continss,'f'),0,1,'C',0);
				$oPdf->ln();
				$oPdf->ln();
				$oPdf->SetFont('Arial','b',$iFonte);
				$oPdf->Cell(18 ,$iAlt,$oDadosGerados->o58_projativ,0,0,'C',0);
				$oPdf->Cell(30 ,$iAlt, '   ' ,0,0,'C');
				$oPdf->Cell(59 ,$iAlt,$oDadosGerados->o55_descr,0,1,'C',0);
				$oPdf->ln();
				$aux =  $oDadosGerados->o58_projativ;
				$contvalor = 0;
				$contpatronal = 0;
				$continss = 0;
			}
		}	
		$contvalor += $oDadosGerados->valor_servico;
		$contpatronal += $oDadosGerados->valor_servico*20/100;
		$continss += $oDadosGerados->valor_inss;

	}
	//quebra por fonte
	if($fonte=='s' and $projeto == 'n'){
		if(!$aux){
			$contvalor = 0;
			$contpatronal = 0;
			$continss = 0;
			$aux =  $oDadosGerados->o58_codigo;
			$oPdf->ln();
			$oPdf->SetFont('Arial','b',$iFonte);
			$oPdf->Cell(18 ,$iAlt,$oDadosGerados->o58_codigo,0,0,'C',0);
			$oPdf->Cell(30 ,$iAlt, '   ' ,0,0,'C');
			$oPdf->Cell(59 ,$iAlt,$oDadosGerados->o15_descr,0,1,'C',0);
			$oPdf->ln();
		}else{
			if($aux != $oDadosGerados->o58_codigo){
				// impimindo total
				$oPdf->ln();
				$oPdf->SetFont('Arial','b',$iFonte);
				$oPdf->Cell(30 ,$iAlt, ' Total ' ,0,0,'C');
				$oPdf->Cell(20 ,$iAlt, '' ,0,0,'C',0);
				$oPdf->Cell(65 ,$iAlt, '' ,0,0,'L',0);
				$oPdf->Cell(25 ,$iAlt,db_formatar($contvalor,'f'),0,0,'C',0);
				$oPdf->Cell(24 ,$iAlt,db_formatar($contpatronal,'f'),0,0,'C',0);
				$oPdf->Cell(25 ,$iAlt,db_formatar($continss,'f'),0,1,'C',0);
				$oPdf->ln();
				$oPdf->ln();
				$oPdf->SetFont('Arial','b',$iFonte);
				$oPdf->Cell(18 ,$iAlt,$oDadosGerados->o58_codigo,0,0,'C',0);
				$oPdf->Cell(30 ,$iAlt, '   ' ,0,0,'C');
				$oPdf->Cell(59 ,$iAlt,$oDadosGerados->o15_descr,0,1,'C',0);
				$oPdf->ln();
				$aux =  $oDadosGerados->o58_codigo;
				$contvalor = 0;
				$contpatronal = 0;
				$continss = 0;
			}
		}	
		$contvalor += $oDadosGerados->valor_servico;
		$contpatronal += $oDadosGerados->valor_servico*20/100;
		$continss += $oDadosGerados->valor_inss;
	}
	$oPdf->SetFont('Arial','',$iFonte);
	$oPdf->Cell(20 ,$iAlt,$oDadosGerados->competencia_liquidadcao                    ,0,0,'C',$iPreenche);
	$oPdf->Cell(20 ,$iAlt,$oDadosGerados->numcgm                                     ,0,0,'C',$iPreenche);
	$oPdf->Cell(70 ,$iAlt,$oDadosGerados->nome                                       ,0,0,'L',$iPreenche);
	$oPdf->Cell(25 ,$iAlt,db_formatar($oDadosGerados->valor_servico,'f')             ,0,0,'R',$iPreenche);
	$oPdf->Cell(24 ,$iAlt,db_formatar(($oDadosGerados->valor_servico*20/100),'f')             ,0,0,'R',$iPreenche);
	$oPdf->Cell(25 ,$iAlt,db_formatar($oDadosGerados->valor_inss,'f')                ,0,0,'R',$iPreenche);
	$oPdf->Cell(27 ,$iAlt,$oDadosGerados->ordem_pgto                                 ,0,0,'C',$iPreenche);
	$oPdf->Cell(16 ,$iAlt,$oDadosGerados->codigo_empenho.'/'.$oDadosGerados->ano_usu ,0,0,'C',$iPreenche);
	$oPdf->Cell(28 ,$iAlt,db_formatar($oDadosGerados->data_liquidacao,'d')           ,0,0,'C',$iPreenche);
	$oPdf->Cell(25 ,$iAlt,$oDadosGerados->enviado_sefip                              ,0,1,'C',$iPreenche);
	
	$iTotalValorServico +=  $oDadosGerados->valor_servico;
	$iTotalValorInss    +=  $oDadosGerados->valor_inss;
}
if($fonte=='s' and $projeto == 'n'){
	if($iInd == $iLinhasArquivo ){
		// impimindo total
		$oPdf->ln();
		$oPdf->SetFont('Arial','b',$iFonte);
		$oPdf->Cell(30 ,$iAlt, ' Total ' ,0,0,'C');
		$oPdf->Cell(20 ,$iAlt, '' ,0,0,'C',0);
		$oPdf->Cell(65 ,$iAlt, '' ,0,0,'L',0);
		$oPdf->Cell(25 ,$iAlt,db_formatar($contvalor,'f'),0,0,'C',0);
		$oPdf->Cell(24 ,$iAlt,db_formatar($contpatronal,'f'),0,0,'C',0);
		$oPdf->Cell(25 ,$iAlt,db_formatar($continss,'f'),0,1,'C',0);
		$oPdf->ln();

		$oPdf->ln();
		$contvalor = 0;
		$contpatronal = 0;
		$continss = 0;
	}
}
if($fonte=='n' and $projeto == 's'){
	if($iInd == $iLinhasArquivo ){
		// impimindo total
		$oPdf->ln();
		$oPdf->SetFont('Arial','b',$iFonte);
		$oPdf->Cell(30 ,$iAlt, ' Total ' ,0,0,'C');
		$oPdf->Cell(20 ,$iAlt, '' ,0,0,'C',0);
		$oPdf->Cell(65 ,$iAlt, '' ,0,0,'L',0);
		$oPdf->Cell(25 ,$iAlt,db_formatar($contvalor,'f'),0,0,'C',0);
		$oPdf->Cell(24 ,$iAlt,db_formatar($contpatronal,'f'),0,0,'C',0);
		$oPdf->Cell(25 ,$iAlt,db_formatar($continss,'f'),0,1,'C',0);
		$oPdf->ln();

		$oPdf->ln();
		$contvalor = 0;
		$contpatronal = 0;
		$continss = 0;
	}
}
if($fonte=='s' and $projeto == 's'){
	if($iInd == $iLinhasArquivo ){
		// impimindo total
		$oPdf->ln();
		$oPdf->SetFont('Arial','b',$iFonte);
		$oPdf->Cell(30 ,$iAlt, ' Total ' ,0,0,'C');
		$oPdf->Cell(20 ,$iAlt, '' ,0,0,'C',0);
		$oPdf->Cell(65 ,$iAlt, '' ,0,0,'L',0);
		$oPdf->Cell(25 ,$iAlt,db_formatar($contvalor,'f'),0,0,'C',0);
		$oPdf->Cell(24 ,$iAlt,db_formatar($contpatronal,'f'),0,0,'C',0);
		$oPdf->Cell(25 ,$iAlt,db_formatar($continss,'f'),0,1,'C',0);
		$oPdf->ln();

		$oPdf->ln();
		$contvalor = 0;
		$contpatronal = 0;
		$continss = 0;
	}
}

$oPdf->Cell(30 ,$iAlt, '' ,0,1,'C');

$oPdf->Cell(20 ,$iAlt, 'Total' ,1,0,'C',$iPreenche);
$oPdf->Cell(20 ,$iAlt, '' ,1,0,'C',$iPreenche);
$oPdf->Cell(70 ,$iAlt, '' ,1,0,'L',$iPreenche);
$oPdf->Cell(25 ,$iAlt,db_formatar($iTotalValorServico,'f')             ,1,0,'R',$iPreenche);
$oPdf->Cell(24 ,$iAlt,db_formatar(($iTotalValorServico*20/100),'f')             ,1,0,'R',$iPreenche);
$oPdf->Cell(25 ,$iAlt,db_formatar($iTotalValorInss,'f')                ,1,0,'R',$iPreenche);
$oPdf->Cell(27 ,$iAlt, '' ,1,0,'C',$iPreenche);
$oPdf->Cell(16 ,$iAlt, '' ,1,0,'C',$iPreenche);
$oPdf->Cell(28 ,$iAlt, '' ,1,0,'C',$iPreenche);
$oPdf->Cell(25 ,$iAlt, '' ,1,1,'C',$iPreenche);

$oPdf->Output();

function imprimeCab($oPdf,$iAlt,$iFonte,$lImprime=false){

  if ($oPdf->gety() > $oPdf->h - 30 || $lImprime ){
  	
		$oPdf->AddPage("L");
		$oPdf->SetFont('Arial','b',$iFonte);

    $oPdf->Cell(20 ,$iAlt,"Competência"    ,1,0,'C',1);
	  $oPdf->Cell(20 ,$iAlt,"CGM"            ,1,0,'C',1);
	  $oPdf->Cell(70 ,$iAlt,"Nome"           ,1,0,'C',1);
	  $oPdf->Cell(25 ,$iAlt,"Valor Serviço"  ,1,0,'C',1);
	  $oPdf->Cell(24 ,$iAlt,"Patronal"  ,1,0,'C',1);
	  $oPdf->Cell(25 ,$iAlt,"Valor INSS"     ,1,0,'C',1);
	  $oPdf->Cell(27 ,$iAlt,"Ordem Pagamento",1,0,'C',1);
	  $oPdf->Cell(16 ,$iAlt,"Empenho"        ,1,0,'C',1);
	  $oPdf->Cell(28 ,$iAlt,"Data Liquidação",1,0,'C',1);
	  $oPdf->Cell(25 ,$iAlt,"Enviado SEFIP"  ,1,1,'C',1);
		
  	$oPdf->SetFont('Arial','',$iFonte);
			
  }
	
}
?>