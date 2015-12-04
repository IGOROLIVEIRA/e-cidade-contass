<?php
require_once("fpdf151/pdf.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");

require_once("model/patrimonio/Bem.model.php");
require_once("model/patrimonio/BemCedente.model.php");
require_once("model/patrimonio/BemClassificacao.model.php");
require_once("model/patrimonio/PlacaBem.model.php");
require_once("model/patrimonio/BemHistoricoMovimentacao.model.php");
require_once("model/patrimonio/BemDadosMaterial.model.php");
require_once("model/patrimonio/BemDadosImovel.model.php");
require_once("model/patrimonio/BemTipoAquisicao.php");
require_once("model/patrimonio/BemTipoDepreciacao.php");
require_once("model/CgmFactory.model.php");

$oGet = db_utils::postMemory($_GET, false);

/**
 * identificamos departamento de origem e destino
 */
$sSql = "select nome,t93_data,dp1.coddepto as coddeptoorigem ,dp1.descrdepto as origem, dp2.coddepto,dp2.descrdepto as destino 
																	from benstransf as bt1 
																	inner join db_depart as dp1 on bt1.t93_depart = dp1.coddepto
																	inner join benstransfdes as btd1 on bt1.t93_codtran = btd1.t94_codtran
																	inner join db_depart as dp2 on dp2.coddepto = btd1.t94_depart 
																	inner join db_usuarios  on  db_usuarios.id_usuario = bt1.t93_id_usuario
																	where bt1.t93_codtran = {$oGet->t93_codtran}";

$rsResultDpOrigemDestino = db_query($sSql);
$oDpOrigemDestino = db_utils::fieldsMemory($rsResultDpOrigemDestino, 0);

$head1 = "Transferência Nº {$oGet->t93_codtran}";
$head3 = "Departamento de Origem: {$oDpOrigemDestino->origem}";
$head4 = "Departamento de Destino: {$oDpOrigemDestino->destino}";
$head5 = "Responsavel: {$oDpOrigemDestino->nome}";
//$head7 = "Nº: {$oResult0->k00_codigo}";
$head6 = "Data da Transferência: ".implode("/",array_reverse(explode("-", $oDpOrigemDestino->t93_data)));

$pdf = new PDF(); // abre a classe

$pdf->Open(); // abre o relatorio

$pdf->AddPage('L'); // adiciona uma pagina
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(235);
$tam = '04';

$pdf->SetFont("","B","");
		
$aCodBens = explode(",", $oGet->t52_bem);
foreach ($aCodBens as $t52_bem) {
		
  $oBem           = new Bem($t52_bem);
  $oClassificao   = $oBem->getClassificacao();
  $oFornecedor    = $oBem->getFornecedor();
  $oCedente       = $oBem->getCedente();
  $oTipoAquisicao = $oBem->getTipoAquisicao();
  $oPlaca         = $oBem->getPlaca();
  $oImovel        = $oBem->getDadosImovel();
  $oMaterial      = $oBem->getDadosCompra();
  $nValorUnitario = $oBem->getValorAquisicao();
  $iValorTotal    += $oBem->getValorAquisicao();

  /**
   * pegar divisao e situacao
   */
  $sSqlDivisao = "select distinct t52_bem, t52_descr, t64_class, t52_ident, divisaoorigem.t30_descr as divorigem, 
  divisaodestino.t30_descr as divdestino, situabens.t70_descr as situacao from benstransfcodigo inner 
  join bens on bens.t52_bem = benstransfcodigo.t95_codbem inner join clabens on clabens.t64_codcla = bens.t52_codcla 
  inner join benstransf on benstransf.t93_codtran = benstransfcodigo.t95_codtran 
  left join benstransfdiv on benstransfdiv.t31_bem = bens.t52_bem and benstransfdiv.t31_codtran = benstransf.t93_codtran 
  left join bensdiv on bensdiv.t33_bem = bens.t52_bem left join departdiv origem on origem.t30_codigo = bensdiv.t33_divisao 
  left join departdiv destino on destino.t30_codigo = benstransfdiv.t31_divisao 
  inner join situabens on situabens.t70_situac = benstransfcodigo.t95_situac 
  left join benstransforigemdestino on benstransfdiv.t31_codtran = benstransforigemdestino.t34_transferencia and benstransfdiv.t31_bem = benstransforigemdestino.t34_bem 
  left join departdiv divisaoorigem on divisaoorigem.t30_codigo = benstransforigemdestino.t34_divisaoorigem 
  left join departdiv divisaodestino on divisaodestino.t30_codigo = benstransforigemdestino.t34_divisaodestino 
  where t95_codtran = {$oGet->t93_codtran} and t52_bem = {$t52_bem} and t52_instit = ".db_getsession("DB_instit");
  
  $rsDivisaoSituacao = db_query($sSqlDivisao);
  $oDivisaoSituacao = db_utils::fieldsMemory($rsDivisaoSituacao, 0);
 // print_r($oDivisaoSituacao);exit;
  if (strlen($oBem->getDescricao()) > 76 || strlen($oDivisaoSituacao->divorigem) > 27 || strlen($oDivisaoSituacao->divdestino) > 27) {
		  
	  	$aDescricao  = quebrar_texto($oBem->getDescricao(),76);
	  	$aDivOrigem  = quebrar_texto($oDivisaoSituacao->divorigem,27);
	  	$aDivDestino = quebrar_texto($oDivisaoSituacao->divdestino,27);
	  	//$aDivOrigem  = $oDivisaoSituacao->divorigem;
	  	//$aDivDestino = $oDivisaoSituacao->divdestino;
	  if (count($aDescricao) > count($aDivOrigem) && count($aDescricao) > count($aDivDestino)) {
	    $alt_novo = count($aDescricao);
	  } else if (count($aDivOrigem) > count($aDescricao) && count($aDivOrigem) > count($aDivDestino)) {
	    $alt_novo = count($aDivOrigem);
	  } else {
	  	$alt_novo = count($aDivDestino);
	  }
			
	} else {
	  $alt_novo = 1;
	}
  
	$pdf->Cell(13,$tam,"BEM",1,0,"C",1);
  $pdf->Cell(15,$tam,"PLACA",1,0,"C",1);  
  $pdf->Cell(115,$tam,"DESCRICÃO",1,0,"L",1);
  $pdf->Cell(25,$tam,"CLASSIFICACÃO",1,0,"L",1);
  $pdf->Cell(40,$tam,"DIVISÃO DE ORIGEM",1,0,"L",1);
  $pdf->Cell(40,$tam,"DIVISÃO DE DESTINO",1,0,"L",1);
  $pdf->Cell(20,$tam,"SITUACAO",1,0,"L",1);
  $pdf->Cell(11,$tam,"VALOR",1,1,"L",1);
		
  $pdf->Cell(13,$tam*$alt_novo,$oBem->getCodigoBem(),1,0,"C",0);
  $pdf->Cell(15,$tam*$alt_novo,$oDivisaoSituacao->t52_ident,1,0,"C",0);  
  
  /**
   * imprimir descricao item
   */
  if (strlen($oBem->getDescricao()) > 89) {
	  
	  $pos_x = $pdf->x;
	  $pos_y = $pdf->y;
	  //$pdf->Cell(115,$tam*$alt_novo,"",1,0,"L",0);
	  $pdf->x = $pos_x;
	  $pdf->y = $pos_y;
	  foreach ($aDescricao as $oDescricao) {
	    $pdf->cell(115,($tam),$oDescricao,0,1,"L",0); 
	  	$pdf->x=$pos_x;	
	  }
	  $pdf->x = $pos_x+115;
	  $pdf->y=$pos_y;
	    
	} else {
	  $pdf->Cell(115,$tam*$alt_novo,$oBem->getDescricao(),1,0,"L",0);
	}
  
  $pdf->Cell(25,$tam*$alt_novo,$oClassificao->getCodigo(),1,0,"L",0);
  
  /**
   * imprimir divisao origem
   */
  if (strlen($oDivisaoSituacao->divorigem) > 27) {
	  
	  $pos_x = $pdf->x;
	  $pos_y = $pdf->y;
	  $pdf->Cell(40,$tam*$alt_novo,"",1,0,"L",0);
	  $pdf->x = $pos_x;
	  $pdf->y = $pos_y;
	  foreach ($aDivOrigem as $oDivOrigem) {
	    $pdf->cell(40,($tam),$oDivOrigem,0,1,"L",0); 
	  	$pdf->x=$pos_x;	
	  }
	  $pdf->x = $pos_x+40;
	  $pdf->y=$pos_y;
	    
	} else {
	  $pdf->Cell(40,$tam*$alt_novo,$oDivisaoSituacao->divorigem,1,0,"L",0);
	}
  
  /**
   * imprimir divisao destino
   */
  if (strlen($oDivisaoSituacao->divdestino) > 27) {
	  
	  $pos_x = $pdf->x;
	  $pos_y = $pdf->y;
	  $pdf->Cell(40,$tam*$alt_novo,"",1,0,"L",0);
	  $pdf->x = $pos_x;
	  $pdf->y = $pos_y;
	  foreach ($aDivDestino as $oDivDestino) {
	    $pdf->cell(40,($tam),$oDivDestino,0,1,"L",0); 
	  	$pdf->x=$pos_x;	
	  }
	  $pdf->x = $pos_x+40;
	  $pdf->y=$pos_y;
	    
	} else {
	  $pdf->Cell(40,$tam*$alt_novo,$oDivisaoSituacao->divdestino,1,0,"L",0);
	}
  
  $pdf->Cell(20,$tam*$alt_novo,$oDivisaoSituacao->situacao,1,0,"L",0);

  $pdf->Cell(11,$tam*$alt_novo,$nValorUnitario,1,1,"L",0);
  
  if (isset($oGet->lDadosMaterial) && $oMaterial != null) {
  
  	$pdf->Cell(26,$tam,"Nota Fiscal",1,0,"C",1);
    $pdf->Cell(30,$tam,"Ordem de Compra",1,0,"C",1);  
    $pdf->Cell(172,$tam,"Credor",1,0,"C",1);
    $pdf->Cell(20,$tam,"Empenho",1,0,"C",1);
    $pdf->Cell(30,$tam,"Data da Garantia",1,1,"C",1);
  
    $pdf->Cell(26,$tam,$oMaterial->getNotaFiscal(),1,0,"L",0);
    $pdf->Cell(30,$tam,$oMaterial->getOrdemCompra(),1,0,"C",0);  
    $pdf->Cell(172,$tam,$oMaterial->getCredor(),1,0,"L",0);
    $pdf->Cell(20,$tam,$oMaterial->getEmpenho(),1,0,"C",0);
    $pdf->Cell(30,$tam,$oMaterial->getDataGarantia(),1,1,"C",0);
    
   }
   
   if (isset($oGet->lDadosImovel) && $oImovel != null) {
  
     $pdf->Cell(78,$tam,"Lote",1,0,"C",1);
     $pdf->Cell(200,$tam,"Observação",1,1,"C",1);
     $pdf->Cell(78,$tam,$oImovel->getIdBql(),1,0,"C",0);
     $pdf->Cell(200,$tam,$oImovel->getObservacao(),1,1,"L",0);
      
   }
   
   $pdf->Cell(55,$tam*2,"","",1,"C",0);  
}

$pdf->Cell(18,$tam,"Total de Bens",1,0,"R",1);
$pdf->Cell(120,$tam,count($aCodBens),1,0,"C",0);

$pdf->Cell(16,$tam,"Valor Total",1,0,"R",1);
$pdf->Cell(125,$tam,db_formatar($iValorTotal,"f"),1,0,"R",0);

$pdf->output();

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



