<?php

class siacelrfdeducaoreceita {
	
 protected $sNomeArquivo = 'deducaoReceita';
 
 
 public function gerarDados($sDataInicial,$sDataFinal) {
//arquivo depesas correntes

  $nomeArquivo= $this->sNomeArquivo;
  
  $aDadosFormatados = array();
  
 
  
  //pegar o mês de referencia da siacelrf
  $aData = explode('-', $sDataInicial);
  $iMes = $aData[1];
    
  
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
