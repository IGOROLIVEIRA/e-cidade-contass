<?php

class siacelrfdespesasfuncaosubfuncao {
	
	protected $sNomeArquivo = "despFuncaoSubfuncao";

	
	public function gerarDados($sDataInicial,$sDataFinal) {
  //arquivo depesas correntes
  $nomeArquivo= $this->sNomeArquivo;
  
  $aDadosSubUnidades = array();
  
  //pegar o mês de referencia da siacelrf
  $aData = explode('-', $sDataInicial);
  $iMes = $aData[1];
  
   $sql = "select (SELECT distinct case when db21_tipoinstit = 2 then '03' 
									    when db21_tipoinstit = 1 then '01' 
								    else '02' end as orgao
					 from db_config
					where codigo = o58_instit) as orgao,
		          o58_coddot,
		          lpad(o58_funcao,2,0) as o58_funcao,
		          (SELECT cgc
					 from db_config
					where codigo = o58_instit) as entidade,
		          lpad(o58_subfuncao,3,0) as o58_subfuncao 
            from orcdotacao
            join orcelemento on o56_codele = o58_codele and o56_anousu = o58_anousu 
           where o58_anousu = ".db_getsession("DB_anousu");
   
   $rsResultDotacoes =  db_query($sql);
   
   
   
   $oDespFuncSub = array();
  
   $oDespFuncSub['mes'] = '';
   $oDespFuncSub['codVinc'] = 0;
   $oDespFuncSub['dotInicial'] = 0;
   $oDespFuncSub['dotAtual'] = 0;
   $oDespFuncSub['despEmp'] = 0;
   $oDespFuncSub['despLiq'] = 0;
   $oDespFuncSub['despAnulada'] = 0;
   $oDespFuncSub['codFuncao'] = 0;
   $oDespFuncSub['codSubFuncao'] = 0;
   $oDespFuncSub['codEntidade'] = ' ';
   
   
  
  $aDadosDespesas = array();
   
   for($y = 0; $y< pg_num_rows($rsResultDotacoes);$y++){
   		
   	    $linha = pg_fetch_object($rsResultDotacoes,$y);
   	 		
   		if($linha->o58_funcao != 99){
	   		
	 
	  		//select para pegar os saldos empenhodo, liquidado, anulado, inicial, atualizado
			$sql = "select 
			substr(fc_dotacaosaldo,3,12)::float8 as dotinicial,
	        (substr(fc_dotacaosaldo,3,12)::float8) + 
	        (substr(fc_dotacaosaldo,81,12)::float8) - 
	        (substr(fc_dotacaosaldo,094,12)::float8) + 
	        (substr(fc_dotacaosaldo,276,12)::float8) as dotinicialatualizada,
	        substr(fc_dotacaosaldo,29,12)::float8  as empenhado,
	        substr(fc_dotacaosaldo,55,12)::float8  as anulado,
	        substr(fc_dotacaosaldo,42,12)::float8  as liquidado
	  		from fc_dotacaosaldo(".db_getsession("DB_anousu").",{$linha->o58_coddot},4,'{$sDataInicial}','{$sDataFinal}')";
			
			$rsResultDespesasSaldo = db_query($sql);
				
			$linha2 = pg_fetch_object($rsResultDespesasSaldo,0);
			
			
			//dotação anual inicial
			$oDespFuncSub['mes'] 			= $iMes;
			$oDespFuncSub['codVinc'] 		= $linha->orgao;
			$oDespFuncSub['codFuncao'] 		= $linha->o58_funcao;
	   		$oDespFuncSub['codSubFuncao'] 	= $linha->o58_subfuncao;
	   		if($linha->orgao != '03'){
	   			$oDespFuncSub['codEntidade'] 	= $linha->entidade.'E';	
	   		}else {
	   			$oDespFuncSub['codEntidade'] 	= " ";
	   		}
	   		$oDespFuncSub['dotInicial'] 	= $linha2->dotinicial;
	   		$oDespFuncSub['dotAtual'] 		= $linha2->dotinicialatualizada;
	   		$oDespFuncSub['despEmp'] 		= $linha2->empenhado;
	   		$oDespFuncSub['despLiq'] 		= $linha2->anulado;
	   		$oDespFuncSub['despAnulada'] 	= $linha2->liquidado;
	   		
	   		
	   		
			
	   		$aDadosDespesas[] = $oDespFuncSub;
   		}
   	
   }
   
   $aDadosDespesasAgrupados = array();
  	
  	foreach ($aDadosDespesas as $oDespesa){
  		
  		$sHash  = $oDespesa['codVinc'];
   		$sHash .= $oDespesa['codFuncao'];
   		$sHash .= $oDespesa['codSubFuncao'];
		
			if(!$aDadosDespesasAgrupados[$sHash]){
				$aDadosDespesasAgrupados[$sHash] = $oDespesa;
			}else{
				$aDadosDespesasAgrupados[$sHash]['dotInicial'] += $oDespesa['dotInicial'];
				$aDadosDespesasAgrupados[$sHash]['dotAtual'] += $oDespesa['dotAtual'];
				$aDadosDespesasAgrupados[$sHash]['despEmp'] += $oDespesa['despEmp'];
				$aDadosDespesasAgrupados[$sHash]['despLiq'] += $oDespesa['despLiq'];
				$aDadosDespesasAgrupados[$sHash]['despAnulada'] += $oDespesa['despAnulada'];
			}
		
		
  	}
  	
  	$aDadosFormatados = array();
  	foreach ($aDadosDespesasAgrupados as $obj){
  		  
  	  if ($iMes == 1) {	
  		  $obj['dotInicial'] = number_format($obj['dotInicial'],2,"","");
  	  } else {
  	  	$obj['dotInicial'] = '000';
  	  }
		  $obj['dotAtual']   = number_format($obj['dotAtual'],2,"","");
		  $obj['despEmp']    = number_format($obj['despEmp'],2,"","");
		  $obj['despLiq']    = number_format($obj['despLiq'],2,"","");
		  $obj['despAnulada']    = number_format($obj['despAnulada'],2,"","");

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