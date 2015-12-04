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

$head3 = "Transferência por Período";
$head4 = "Período da Transferência: ".implode("/",array_reverse(explode("-", $oGet->dataINI)))." - ". implode("/",array_reverse(explode("-", $oGet->dataFIM)));

$pdf = new PDF(); // abre a classe

$pdf->Open(); // abre o relatorio

$pdf->AddPage('L'); // adiciona uma pagina
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(235);
$tam = '04';

$pdf->SetFont("","B","");	

/**
   * pegar divisao e situacao
   */
  $sSqlDivisao = "select distinct dp1.descrdepto as origem, dp2.descrdepto as destino, nome, t52_bem, t52_descr, t64_class, t52_ident, divisaoorigem.t30_descr as divorigem, 
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
  inner join db_usuarios  on  db_usuarios.id_usuario = benstransf.t93_id_usuario
  inner join db_depart as dp1 on benstransf.t93_depart = dp1.coddepto
  inner join benstransfdes as btd1 on benstransf.t93_codtran = btd1.t94_codtran
  inner join db_depart as dp2 on dp2.coddepto = btd1.t94_depart 
  where benstransf.t93_data BETWEEN '{$oGet->dataINI}' and '{$oGet->dataFIM}'";
  
  $rsDivisaoSituacao = db_query($sSqlDivisao);

$pdf->Cell(15,$tam,"PLACA",1,0,"C",1);    
$pdf->Cell(70,$tam,"DESCRICÃO",1,0,"L",1);
$pdf->Cell(40,$tam,"ORIGEM",1,0,"L",1);
$pdf->Cell(40,$tam,"DESTINO",1,0,"L",1);
$pdf->Cell(40,$tam,"DIVISÃO DE ORIGEM",1,0,"L",1);
$pdf->Cell(40,$tam,"DIVISÃO DE DESTINO",1,0,"L",1);
$pdf->Cell(35,$tam,"USUÁRIO",1,1,"C",1);

for ($iCont=0;$iCont < pg_num_rows($rsDivisaoSituacao);$iCont++) {

  $oDivisaoSituacao = db_utils::fieldsMemory($rsDivisaoSituacao, $iCont);
    
  $oBem           = new Bem($oDivisaoSituacao->t52_bem);
  $oClassificao   = $oBem->getClassificacao();
  $oFornecedor    = $oBem->getFornecedor();
  $oCedente       = $oBem->getCedente();
  $oTipoAquisicao = $oBem->getTipoAquisicao();
  $oPlaca         = $oBem->getPlaca();
  $oImovel        = $oBem->getDadosImovel();
  $oMaterial      = $oBem->getDadosCompra();
  $nValorUnitario = $oBem->getValorAquisicao();
  $iValorTotal    += $oBem->getValorAquisicao();
  
  if (strlen($oBem->getDescricao()) > 45 || strlen($oDivisaoSituacao->divorigem) > 27 || strlen($oDivisaoSituacao->divdestino) > 27) {
		  
	  	$aDescricao  = quebrar_texto($oBem->getDescricao(),45);
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
  	
  
  $pdf->Cell(15,$tam*$alt_novo,$oDivisaoSituacao->t52_ident,1,0,"C",0);   
  
  /**
   * imprimir descricao item
   */
  if (strlen($oBem->getDescricao()) > 45) {
	    	  
	  $pos_x = $pdf->x;
	  $pos_y = $pdf->y;
	  $pdf->Cell(70,$tam*$alt_novo,"",1,0,"L",0);
	  $pdf->x = $pos_x;
	  $pdf->y = $pos_y;
	  foreach ($aDescricao as $oDescricao) {
	    $pdf->cell(70,($tam),$oDescricao,0,1,"L",0); 
	  	$pdf->x=$pos_x;	
	  }
	  $pdf->x = $pos_x+70;
	  $pdf->y=$pos_y;
	    
	} else {
	  $pdf->Cell(70,$tam*$alt_novo,$oBem->getDescricao(),1,0,"L",0);
	}
  
  
  /**
   * imprimir  origem
   */
  if (strlen($oDivisaoSituacao->origem) > 27) {
	  
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
	  $pdf->Cell(40,$tam*$alt_novo,$oDivisaoSituacao->origem,1,0,"L",0);
	}
  
  /**
   * imprimir  destino
   */
  if (strlen($oDivisaoSituacao->destino) > 27) {
	  
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
	  $pdf->Cell(40,$tam*$alt_novo,$oDivisaoSituacao->destino,1,0,"L",0);
	}

	/**
   * imprimir  divorigem
   */
  if (strlen($oDivisaoSituacao->divorigem) > 27) {
	  
	  $pos_x = $pdf->x;
	  $pos_y = $pdf->y;
	  $pdf->Cell(40,$tam*$alt_novo,"",1,0,"L",0);
	  $pdf->x = $pos_x;
	  $pdf->y = $pos_y;
	  foreach ($aDivdivorigem as $oDivdivorigem) {
	    $pdf->cell(40,($tam),$oDivdivorigem,0,1,"L",0); 
	  	$pdf->x=$pos_x;	
	  }
	  $pdf->x = $pos_x+40;
	  $pdf->y=$pos_y;
	    
	} else {
	  $pdf->Cell(40,$tam*$alt_novo,$oDivisaoSituacao->divorigem,1,0,"L",0);
	}
  
  /**
   * imprimir  destino
   */
  if (strlen($oDivisaoSituacao->destino) > 27) {
	  
	  $pos_x = $pdf->x;
	  $pos_y = $pdf->y;
	  $pdf->Cell(40,$tam*$alt_novo,"",1,1,"L",0);
	  $pdf->x = $pos_x;
	  $pdf->y = $pos_y;
	  foreach ($aDivDestino as $oDivDestino) {
	    $pdf->cell(40,($tam),$oDivDestino,0,1,"L",0); 
	  	$pdf->x=$pos_x;	
	  }
	  $pdf->x = $pos_x+40;
	  $pdf->y=$pos_y;
	    
	} else {
	  $pdf->Cell(40,$tam*$alt_novo,$oDivisaoSituacao->destino,1,0,"L",0);
	}
  
  	$pdf->Cell(35,$tam*$alt_novo,$oDivisaoSituacao->nome,1,1,"C",0); 

}

$pdf->Cell(18,$tam,"Total de Bens",1,0,"R",1);
$pdf->Cell(121,$tam,pg_num_rows($rsDivisaoSituacao),1,0,"C",0);

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



