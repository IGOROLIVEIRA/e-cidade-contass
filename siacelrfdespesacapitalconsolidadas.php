<?php

class siacelrfdespesacapitalconsolidadas {
	
	protected $sNomeArquivo = 'despesaCapital';
  //arquivo depesas correntes
  
	public function gerarDados($sDataInicial,$sDataFinal) {
  
		$nomeArquivo= $this->sNomeArquivo;
  
  $aDadosSubUnidades = array();
  //pegar o mês de referencia da siacelrf
  $aData = explode('-', $sDataInicial);
  $iMes = $aData[1];
  	
  $sql = "select o58_coddot, substr(o56_elemento,1,3) as elemento 
            from orcdotacao
            join orcelemento on o56_codele = o58_codele and o56_anousu = o58_anousu 
           where o58_anousu = ".db_getsession("DB_anousu");
 
  $rsResultDotacoes =  db_query($sql);
 
  $oDotacaoInicial = array();
  
  $oDotacaoInicial['mes'] = '';
  $oDotacaoInicial['despInvest'] = 0;
  $oDotacaoInicial['despInvFinan'] = 0;
  $oDotacaoInicial['despAmortDivInt'] = 0;
  $oDotacaoInicial['despAmortDivExt'] = 0;
  $oDotacaoInicial['despAmortDivMob'] = 0;
  $oDotacaoInicial['despOutDespCap'] = 0;
  $oDotacaoInicial['concEmprestimos'] = 0;
  $oDotacaoInicial['aquisicaoTitulos'] = 0;
  $oDotacaoInicial['incentContrib'] = 0;
  $oDotacaoInicial['incentInstFinan'] = 0;
  $oDotacaoInicial['codTipo'] = '';
  
  $oDotacaoAtualizada = array();
  
  $oDotacaoAtualizada['mes'] = '';
  $oDotacaoAtualizada['despInvest'] = 0;
  $oDotacaoAtualizada['despInvFinan'] = 0;
  $oDotacaoAtualizada['despAmortDivInt'] = 0;
  $oDotacaoAtualizada['despAmortDivExt'] = 0;
  $oDotacaoAtualizada['despAmortDivMob'] = 0;
  $oDotacaoAtualizada['despOutDespCap'] = 0;
  $oDotacaoAtualizada['concEmprestimos'] = 0;
  $oDotacaoAtualizada['aquisicaoTitulos'] = 0;
  $oDotacaoAtualizada['incentContrib'] = 0;
  $oDotacaoAtualizada['incentInstFinan'] = 0;
  $oDotacaoAtualizada['codTipo'] = '';
  
  $oDotacaomes = array();
  
  $oDotacaomes['mes'] = '';
  $oDotacaomes['despInvest'] = 0;
  $oDotacaomes['despInvFinan'] = 0;
  $oDotacaomes['despAmortDivInt'] = 0;
  $oDotacaomes['despAmortDivExt'] = 0;
  $oDotacaomes['despAmortDivMob'] = 0;
  $oDotacaomes['despOutDespCap'] = 0;
  $oDotacaomes['concEmprestimos'] = 0;
  $oDotacaomes['aquisicaoTitulos'] = 0;
  $oDotacaomes['incentContrib'] = 0;
  $oDotacaomes['incentInstFinan'] = 0;
  $oDotacaomes['codTipo'] = '';
  
  
  $oEmpenhado = array();
  
  $oEmpenhado['mes'] = '';
  $oEmpenhado['despInvest'] = 0;
  $oEmpenhado['despInvFinan'] = 0;
  $oEmpenhado['despAmortDivInt'] = 0;
  $oEmpenhado['despAmortDivExt'] = 0;
  $oEmpenhado['despAmortDivMob'] = 0;
  $oEmpenhado['despOutDespCap'] = 0;
  $oEmpenhado['concEmprestimos'] = 0;
  $oEmpenhado['aquisicaoTitulos'] = 0;
  $oEmpenhado['incentContrib'] = 0;
  $oEmpenhado['incentInstFinan'] = 0;
  $oEmpenhado['codTipo'] = '';
  
  $oLiquidado = array();
  
  $oLiquidado['mes'] = '';
  $oLiquidado['despInvest'] = 0;
  $oLiquidado['despInvFinan'] = 0;
  $oLiquidado['despAmortDivInt'] = 0;
  $oLiquidado['despAmortDivExt'] = 0;
  $oLiquidado['despAmortDivMob'] = 0;
  $oLiquidado['despOutDespCap'] = 0;
  $oLiquidado['concEmprestimos'] = 0;
  $oLiquidado['aquisicaoTitulos'] = 0;
  $oLiquidado['incentContrib'] = 0;
  $oLiquidado['incentInstFinan'] = 0;
  $oLiquidado['codTipo'] = '';
  
  $oAnulado = array();
  
  $oAnulado['mes'] = '';
  $oAnulado['despInvest'] = 0;
  $oAnulado['despInvFinan'] = 0;
  $oAnulado['despAmortDivInt'] = 0;
  $oAnulado['despAmortDivExt'] = 0;
  $oAnulado['despAmortDivMob'] = 0;
  $oAnulado['despOutDespCap'] = 0;
  $oAnulado['concEmprestimos'] = 0;
  $oAnulado['aquisicaoTitulos'] = 0;
  $oAnulado['incentContrib'] = 0;
  $oAnulado['incentInstFinan'] = 0;
  $oAnulado['codTipo'] = '';
  
  $aDadosAgrupados = array();
  
  for($y = 0; $y< pg_num_rows($rsResultDotacoes);$y++){
  		
  		$linha = pg_fetch_object($rsResultDotacoes,$y);
 
  		//select para pegar os saldos empenhodo, liquidado, anulado, inicial, atualizado
		$sql = "select 
		substr(fc_dotacaosaldo,3,12)::float8 as dotinicial,
        (substr(fc_dotacaosaldo,3,12)::float8) + 
        (substr(fc_dotacaosaldo,81,12)::float8) - 
        (substr(fc_dotacaosaldo,094,12)::float8) + 
        (substr(fc_dotacaosaldo,276,12)::float8) as dotinicialatualizada,
        substr(fc_dotacaosaldo,29,12)::float8  as empenhado,
        substr(fc_dotacaosaldo,42,12)::float8  as anulado,
        substr(fc_dotacaosaldo,55,12)::float8  as liquidado
  		from fc_dotacaosaldo(".db_getsession("DB_anousu").",{$linha->o58_coddot},4,'{$sDataInicial}','{$sDataFinal}')";
		
		$rsResultDespesasSaldo = db_query($sql);
		
		$linha2 = pg_fetch_object($rsResultDespesasSaldo,0);
		
	  
		//dotação anual inicial
		$oDotacaoInicial['mes'] = $iMes;
		if($linha->elemento == '344'){
			$oDotacaoInicial['despInvest'] += $linha2->dotinicial;
		}
		if($linha->elemento == '345'){
			$oDotacaoInicial['despInvFinan'] += $linha2->dotinicial;
		}
		if($linha->elemento == '346'){
			$oDotacaoInicial['despAmortDivInt'] += $linha2->dotinicial;
		}
		if($linha->elemento == 'xxx'){
			$oDotacaoInicial['despAmortDivExt'] += $linha2->dotinicial;
		}
  		if($linha->elemento == 'xxx'){
			$oDotacaoInicial['despAmortDivMob'] += $linha2->dotinicial;
		}
  		if($linha->elemento == 'xxx'){
			$oDotacaoInicial['despOutDespCap'] += $linha2->dotinicial;
		}
  		if($linha->elemento == 'xxx'){
			$oDotacaoInicial['concEmprestimos'] += $linha2->dotinicial;
		}
  		if($linha->elemento == 'xxx'){
			$oDotacaoInicial['aquisicaoTitulos'] += $linha2->dotinicial;
		}
  		if($linha->elemento == 'xxx'){
			$oDotacaoInicial['incentContrib'] += $linha2->dotinicial;
		}
  		if($linha->elemento == 'xxx'){
			$oDotacaoInicial['incentInstFinan'] += $linha2->dotinicial;
		}
		$oDotacaoInicial['codTipo'] = '01';
		
		
		//dotação anual atualizada
		$oDotacaoAtualizada['mes'] = $iMes;
		if($linha->elemento == '344'){
			$oDotacaoAtualizada['despInvest'] += $linha2->dotinicialatualizada;
		}
		if($linha->elemento == '345'){
			$oDotacaoAtualizada['despInvFinan'] += $linha2->dotinicialatualizada;
		}
		if($linha->elemento == '346'){
			$oDotacaoAtualizada['despAmortDivInt'] += $linha2->dotinicialatualizada;
		}
		if($linha->elemento == 'xxx'){
			$oDotacaoAtualizada['despAmortDivExt'] += $linha2->dotinicialatualizada;
		}
  		if($linha->elemento == 'xxx'){
			$oDotacaoAtualizada['despAmortDivMob'] += $linha2->dotinicialatualizada;
		}
  		if($linha->elemento == 'xxx'){
			$oDotacaoAtualizada['despOutDespCap'] += $linha2->dotinicialatualizada;
		}
  		if($linha->elemento == 'xxx'){
			$oDotacaoAtualizada['concEmprestimos'] += $linha2->dotinicialatualizada;
		}
  		if($linha->elemento == 'xxx'){
			$oDotacaoAtualizada['aquisicaoTitulos'] += $linha2->dotinicialatualizada;
		}
  		if($linha->elemento == 'xxx'){
			$oDotacaoAtualizada['incentContrib'] += $linha2->dotinicialatualizada;
		}
  		if($linha->elemento == 'xxx'){
			$oDotacaoAtualizada['incentInstFinan'] += $linha2->dotinicialatualizada;
		}
		$oDotacaoAtualizada['codTipo'] = '02';
		
		//dotação mes
		$oDotacaomes['mes'] = $iMes;
		if($linha->elemento == '344'){
			$oDotacaomes['despInvest'] += ($linha2->dotinicial / 12);
		}
		if($linha->elemento == '345'){
			$oDotacaomes['despInvFinan'] += ($linha2->dotinicial / 12);
		}
		if($linha->elemento == '346'){
			$oDotacaomes['despAmortDivInt'] += ($linha2->dotinicial / 12);
		}
		if($linha->elemento == 'xxx'){
			$oDotacaomes['despAmortDivExt'] += ($linha2->dotinicial / 12);
		}
  		if($linha->elemento == 'xxx'){
			$oDotacaomes['despAmortDivMob'] += ($linha2->dotinicial / 12);
		}
 		if($linha->elemento == 'xxx'){
			$oDotacaomes['despOutDespCap'] += ($linha2->dotinicial / 12);
		}
  		if($linha->elemento == 'xxx'){
			$oDotacaomes['concEmprestimos'] += ($linha2->dotinicial / 12);
		}
  		if($linha->elemento == 'xxx'){
			$oDotacaomes['aquisicaoTitulos'] += ($linha2->dotinicial / 12);
		}
  		if($linha->elemento == 'xxx'){
			$oDotacaomes['incentContrib'] += ($linha2->dotinicial / 12);
		}
  		if($linha->elemento == 'xxx'){
			$oDotacaomes['incentInstFinan'] += ($linha2->dotinicial / 12);
		}
		$oDotacaomes['codTipo'] = '03';
		
		
		//empenhado no mes
		$oEmpenhado['mes'] = $iMes;
		if($linha->elemento == '344'){
			$oEmpenhado['despInvest'] += $linha2->empenhado;
		}
		if($linha->elemento == '345'){
			$oEmpenhado['despInvFinan'] += $linha2->empenhado;
		}
		if($linha->elemento == '346'){
			$oEmpenhado['despAmortDivInt'] += $linha2->empenhado;
		}
		if($linha->elemento == 'xxx'){
			$oEmpenhado['despAmortDivExt'] += $linha2->empenhado;
		}
  		if($linha->elemento == 'xxx'){
			$oEmpenhado['despAmortDivMob'] += $linha2->empenhado;
		}
  		if($linha->elemento == 'xxx'){
			$oEmpenhado['despOutDespCap'] += $linha2->empenhado;
		}
  		if($linha->elemento == 'xxx'){
			$oEmpenhado['concEmprestimos'] += $linha2->empenhado;
		}
  		if($linha->elemento == 'xxx'){
			$oEmpenhado['aquisicaoTitulos'] += $linha2->empenhado;
		}
  		if($linha->elemento == 'xxx'){
			$oEmpenhado['incentContrib'] += $linha2->empenhado;
		}
  		if($linha->elemento == 'xxx'){
			$oEmpenhado['incentInstFinan'] += $linha2->empenhado;
		}
		$oEmpenhado['codTipo'] = '04';
		
		
		//liquidado no mes
		$oLiquidado['mes'] = $iMes;
		if($linha->elemento == '344'){
			$oLiquidado['despInvest'] += $linha2->liquidado;
		}
		if($linha->elemento == '345'){
			$oLiquidado['despInvFinan'] += $linha2->liquidado;
		}
		if($linha->elemento == '346'){
			$oLiquidado['despAmortDivInt'] += $linha2->liquidado;
		}
		if($linha->elemento == 'xxx'){
			$oLiquidado['despAmortDivExt'] += $linha2->liquidado;
		}
 		if($linha->elemento == 'xxx'){
			$oLiquidado['despAmortDivMob'] += $linha2->liquidado;
		}
  		if($linha->elemento == 'xxx'){
			$oLiquidado['despOutDespCap'] += $linha2->liquidado;
		}
  		if($linha->elemento == 'xxx'){
			$oLiquidado['concEmprestimos'] += $linha2->liquidado;
		}
  		if($linha->elemento == 'xxx'){
			$oLiquidado['aquisicaoTitulos'] += $linha2->liquidado;
		}
  		if($linha->elemento == 'xxx'){
			$oLiquidado['incentContrib'] += $linha2->liquidado;
		}
  		if($linha->elemento == 'xxx'){
			$oLiquidado['incentInstFinan'] += $linha2->liquidado;
		}
		$oLiquidado['codTipo'] = '05';
		
		
		
		//anulado no mes
		$oAnulado['mes'] = $iMes;
		if($linha->elemento == '344'){
			$oAnulado['despInvest'] += $linha2->anulado;
		}
		if($linha->elemento == '345'){
			$oAnulado['despInvFinan'] += $linha2->anulado;
		}
		if($linha->elemento == '346'){
			$oAnulado['despAmortDivInt'] += $linha2->anulado;
		}
		if($linha->elemento == 'xxx'){
			$oAnulado['despAmortDivExt'] += $linha2->anulado;
		}
  		if($linha->elemento == 'xxx'){
			$oAnulado['despAmortDivMob'] += $linha2->anulado;
		}
  		if($linha->elemento == 'xxx'){
			$oAnulado['despOutDespCap'] += $linha2->anulado;
		}
  		if($linha->elemento == 'xxx'){
			$oAnulado['concEmprestimos'] += $linha2->anulado;
		}
  		if($linha->elemento == 'xxx'){
			$oAnulado['aquisicaoTitulos'] += $linha2->anulado;
		}
  		if($linha->elemento == 'xxx'){
			$oAnulado['incentContrib'] += $linha2->anulado;
		}
  		if($linha->elemento == 'xxx'){
			$oAnulado['incentInstFinan'] += $linha2->anulado;
		}
		$oAnulado['codTipo'] = '06';
  	}
  	
  	if ($iMes == 1) {
  	  $aDadosAgrupados[]=$oDotacaoInicial;
  	}
  	$aDadosAgrupados[]=$oDotacaoAtualizada;
  	$aDadosAgrupados[]=$oDotacaomes;
  	$aDadosAgrupados[]=$oEmpenhado;
  	$aDadosAgrupados[]=$oLiquidado;
  	$aDadosAgrupados[]=$oAnulado;
  	
  	$aDadosFormatados = array();
  	foreach ($aDadosAgrupados as $obj){
  		  
  		$obj['despInvest']     = number_format($obj['despInvest'],2,"","");
		$obj['despInvFinan']   = number_format($obj['despInvFinan'],2,"","");
		$obj['despAmortDivInt']    = number_format($obj['despAmortDivInt'],2,"","");
		$obj['despAmortDivExt']    = number_format($obj['despAmortDivExt'],2,"","");
		$obj['despAmortDivMob']    = number_format($obj['despAmortDivMob'],2,"","");
		$obj['despOutDespCap']    = number_format($obj['despOutDespCap'],2,"","");
		$obj['concEmprestimos']    = number_format($obj['concEmprestimos'],2,"","");
		$obj['aquisicaoTitulos']    = number_format($obj['aquisicaoTitulos'],2,"","");
		$obj['incentContrib']    = number_format($obj['incentContrib'],2,"","");
		$obj['incentInstFinan']    = number_format($obj['incentInstFinan'],2,"","");
		$aDadosFormatados[] = $obj;
  	}
  	
  $this->gerarArquivo($aDadosFormatados, $nomeArquivo);
  
  return $this->retornaNome();
  
	}
	
  //funcao para crias ors aquivos
  public function gerarArquivo($aDados,$nomearquivo) {
		
  	    $delimitador = ';';
		$f = fopen($nomearquivo.'.txt', 'w');
		if ($f) { 
		        
		        foreach ($aDados as $linha2) {
		            fputcsv($f, $linha2, $delimitador);
		        }
		        fclose($f);
		        
		}
  }	

public function retornaNome(){
	return $this->sNomeArquivo;
}
  
}