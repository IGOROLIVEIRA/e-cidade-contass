<?php

class siacelrfdespesaconsolidadas {

	protected $sNomeArquivo = 'despesaCorrente';
	
public function gerarDados($sDataInicial,$sDataFinal){
  //arquivo depesas correntes
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
  $oDotacaoInicial['despPesEncSoc'] = 0;
  $oDotacaoInicial['despJurEncDivInt'] = 0;
  $oDotacaoInicial['despJurEncDivExt'] = 0;
  $oDotacaoInicial['despOutDespCor'] = 0;
  $oDotacaoInicial['codTipo'] = '';
  
  $oDotacaoAtualizada = array();
  
  $oDotacaoAtualizada['mes'] = '';
  $oDotacaoAtualizada['despPesEncSoc'] = 0;
  $oDotacaoAtualizada['despJurEncDivInt'] = 0;
  $oDotacaoAtualizada['despJurEncDivExt'] = 0;
  $oDotacaoAtualizada['despOutDespCor'] = 0;
  $oDotacaoAtualizada['codTipo'] = '';
  
  $oDotacaomes = array();
  
  $oDotacaomes['mes'] = '';
  $oDotacaomes['despPesEncSoc'] = 0;
  $oDotacaomes['despJurEncDivInt'] = 0;
  $oDotacaomes['despJurEncDivExt'] = 0;
  $oDotacaomes['despOutDespCor'] = 0;
  $oDotacaomes['codTipo'] = '';
  
  
  $oEmpenhado = array();
  
  $oEmpenhado['mes'] = '';
  $oEmpenhado['despPesEncSoc'] = 0;
  $oEmpenhado['despJurEncDivInt'] = 0;
  $oEmpenhado['despJurEncDivExt'] = 0;
  $oEmpenhado['despOutDespCor'] = 0;
  $oEmpenhado['codTipo'] = '';
  
  $oLiquidado = array();
  
  $oLiquidado['mes'] = '';
  $oLiquidado['despPesEncSoc'] = 0;
  $oLiquidado['despJurEncDivInt'] = 0;
  $oLiquidado['despJurEncDivExt'] = 0;
  $oLiquidado['despOutDespCor'] = 0;
  $oLiquidado['codTipo'] = '';
  
  $oAnulado = array();
  
  $oAnulado['mes'] = '';
  $oAnulado['despPesEncSoc'] = 0;
  $oAnulado['despJurEncDivInt'] = 0;
  $oAnulado['despJurEncDivExt'] = 0;
  $oAnulado['despOutDespCor'] = 0;
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
		if($linha->elemento == '331'){
			$oDotacaoInicial['despPesEncSoc'] += $linha2->dotinicial;
		}
		if($linha->elemento == '332'){
			$oDotacaoInicial['despJurEncDivInt'] += $linha2->dotinicial;
		}
		if($linha->elemento == 'xxx'){
			$oDotacaoInicial['despJurEncDivExt'] += $linha2->dotinicial;
		}
		if($linha->elemento == '333'){
			$oDotacaoInicial['despOutDespCor'] += $linha2->dotinicial;
		}
		$oDotacaoInicial['codTipo'] = '01';
		
		
		//dotação anual atualizada
		$oDotacaoAtualizada['mes'] = $iMes;
		if($linha->elemento == '331'){
			$oDotacaoAtualizada['despPesEncSoc'] += $linha2->dotinicialatualizada;
		}
		if($linha->elemento == '332'){
			$oDotacaoAtualizada['despJurEncDivInt'] += $linha2->dotinicialatualizada;
		}
		if($linha->elemento == 'xxx'){
			$oDotacaoAtualizada['despJurEncDivExt'] += $linha2->dotinicialatualizada;
		}
		if($linha->elemento == '333'){
			$oDotacaoAtualizada['despOutDespCor'] += $linha2->dotinicialatualizada;
		}
		$oDotacaoAtualizada['codTipo'] = '02';
		
		//dotação mes
		$oDotacaomes['mes'] = $iMes;
		if($linha->elemento == '331'){
			$oDotacaomes['despPesEncSoc'] += ($linha2->dotinicial / 12);
		}
		if($linha->elemento == '332'){
			$oDotacaomes['despJurEncDivInt'] += ($linha2->dotinicial / 12);
		}
		if($linha->elemento == 'xxx'){
			$oDotacaomes['despJurEncDivExt'] += ($linha2->dotinicial / 12);
		}
		if($linha->elemento == '333'){
			$oDotacaomes['despOutDespCor'] += ($linha2->dotinicial / 12);
		}
		$oDotacaomes['codTipo'] = '03';
		
		
		//empenhado no mes
		$oEmpenhado['mes'] = $iMes;
		if($linha->elemento == '331'){
			$oEmpenhado['despPesEncSoc'] += $linha2->empenhado;
		}
		if($linha->elemento == '332'){
			$oEmpenhado['despJurEncDivInt'] += $linha2->empenhado;
		}
		if($linha->elemento == 'xxx'){
			$oEmpenhado['despJurEncDivExt'] += $linha2->empenhado;
		}
		if($linha->elemento == '333'){
			$oEmpenhado['despOutDespCor'] += $linha2->empenhado;
		}
		$oEmpenhado['codTipo'] = '04';
		
		
		//liquidado no mes
		$oLiquidado['mes'] = $iMes;
		if($linha->elemento == '331'){
			$oLiquidado['despPesEncSoc'] += $linha2->liquidado;
		}
		if($linha->elemento == '332'){
			$oLiquidado['despJurEncDivInt'] += $linha2->liquidado;
		}
		if($linha->elemento == 'xxx'){
			$oLiquidado['despJurEncDivExt'] += $linha2->liquidado;
		}
		if($linha->elemento == '333'){
			$oLiquidado['despOutDespCor'] += $linha2->liquidado;
		}
		$oLiquidado['codTipo'] = '05';
		
		//anulado no mes
		$oAnulado['mes'] = $iMes;
		if($linha->elemento == '331'){
			$oAnulado['despPesEncSoc'] += $linha2->anulado;
		}
		if($linha->elemento == '332'){
			$oAnulado['despJurEncDivInt'] += $linha2->anulado;
		}
		if($linha->elemento == 'xxx'){
			$oAnulado['despJurEncDivExt'] += $linha2->anulado;
		}
		if($linha->elemento == '333'){
			$oAnulado['despOutDespCor'] += $linha2->anulado;
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
  		
  		$obj['despPesEncSoc']     = number_format($obj['despPesEncSoc'],2,"","");
		$obj['despJurEncDivInt']   = number_format($obj['despJurEncDivInt'],2,"","");
		$obj['despJurEncDivExt']    = number_format($obj['despJurEncDivExt'],2,"","");
		$obj['despOutDespCor']    = number_format($obj['despOutDespCor'],2,"","");
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