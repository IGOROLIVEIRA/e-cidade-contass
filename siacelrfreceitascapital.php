<?php

class siacelrfreceitascapital {
     
     protected $sNomeArquivo = 'receitacapital';
 
	 public function gerarDados($sDataInicial,$sDataFinal) {
		
		  $nomeArquivo= $this->sNomeArquivo;
		  
		    
		  //pegar o mês de referencia da siacelrf
		  $aData = explode('-', $sDataInicial);
		  $iMes = $aData[1];
		  $oReceitaPrevistaAnual = array();
		  $oReceitaPrevistaAnual['mes'] = $iMes;
		  $oReceitaPrevistaAnual['recAlienacao'] = 0;
		  $oReceitaPrevistaAnual['recAmort'] = 0;
		  $oReceitaPrevistaAnual['recTransfCapital'] = 0;
		  $oReceitaPrevistaAnual['recConvenios'] = 0;
		  $oReceitaPrevistaAnual['outRecCap'] = 0;
		  $oReceitaPrevistaAnual['recRetOpCred'] = 0;
		  $oReceitaPrevistaAnual['recPrivat'] = 0;
		  $oReceitaPrevistaAnual['recRefDivida'] = 0;
		  $oReceitaPrevistaAnual['recOutOpCred'] = 0;
		  $oReceitaPrevistaAnual['deducoes'] = 0;
		  $oReceitaPrevistaAnual['CodTipo'] = '01';
		  
		  
		  
		  $oReceitaAtualizada = array();
		  $oReceitaAtualizada['mes'] = $iMes;
		  $oReceitaAtualizada['recAlienacao'] = 0;
		  $oReceitaAtualizada['recAmort'] = 0;
		  $oReceitaAtualizada['recTransfCapital'] = 0;
		  $oReceitaAtualizada['recConvenios'] = 0;
		  $oReceitaAtualizada['outRecCap'] = 0;
		  $oReceitaAtualizada['recRetOpCred'] = 0;
		  $oReceitaAtualizada['recPrivat'] = 0;
		  $oReceitaAtualizada['recRefDivida'] = 0;
		  $oReceitaAtualizada['recOutOpCred'] = 0;
		  $oReceitaAtualizada['deducoes'] = 0;
		  $oReceitaAtualizada['CodTipo'] = '02';
		  
		  $oReceitaPrevistaMes = array();
		  $oReceitaPrevistaMes['mes'] = $iMes;
		  $oReceitaPrevistaMes['recAlienacao'] = 0;
		  $oReceitaPrevistaMes['recAmort'] = 0;
		  $oReceitaPrevistaMes['recTransfCapital'] = 0;
		  $oReceitaPrevistaMes['recConvenios'] = 0;
		  $oReceitaPrevistaMes['outRecCap'] = 0;
		  $oReceitaPrevistaMes['recRetOpCred'] = 0;
		  $oReceitaPrevistaMes['recPrivat'] = 0;
		  $oReceitaPrevistaMes['recRefDivida'] = 0;
		  $oReceitaPrevistaMes['recOutOpCred'] = 0;
		  $oReceitaPrevistaMes['deducoes'] = 0;
		  $oReceitaPrevistaMes['CodTipo'] = '03';
		  
		  
		  $oReceitaRealizada = array();
		  $oReceitaRealizada['mes'] = $iMes;
		  $oReceitaRealizada['recAlienacao'] = 0;
		  $oReceitaRealizada['recAmort'] = 0;
		  $oReceitaRealizada['recTransfCapital'] = 0;
		  $oReceitaRealizada['recConvenios'] = 0;
		  $oReceitaRealizada['outRecCap'] = 0;
		  $oReceitaRealizada['recRetOpCred'] = 0;
		  $oReceitaRealizada['recPrivat'] = 0;
		  $oReceitaRealizada['recRefDivida'] = 0;
		  $oReceitaRealizada['recOutOpCred'] = 0;
		  $oReceitaRealizada['deducoes'] = 0;
		  $oReceitaRealizada['CodTipo'] = '04';
		  
		  $aDados = array();
		  
		  $sql = "select o57_fonte as rubrica, 
					   o57_descr as descricao, 
					   o70_valor  as vlrorcado,
					   (select round(sum(case when c71_coddoc = 101 then c70_valor * -1 else c70_valor end)::numeric,2) 
							  from conlancamrec 
							  join conlancam on c70_codlan = c74_codlan
							  join conlancamdoc on c71_codlan = c74_codlan
							where c74_data between '{$sDataInicial}' and '{$sDataFinal}' and c74_codrec = o70_codrec) as vlrarrecadado
				      from orcreceita 
				inner join orcfontes on o70_codfon = o57_codfon and o70_anousu = o57_anousu
			       	      where o70_anousu = ".db_getsession("DB_anousu")." and  substr(o57_fonte,1,2) = '42'  order by o57_fonte  ";
		   
		  $rsResultReceitas =  db_query($sql);
		  
		  for($y = 0; $y< pg_num_rows($rsResultReceitas);$y++){
		  		
		  		 $linha = pg_fetch_object($rsResultReceitas,$y);
		  		
		  		 
		  		
		  		  //receitas previstas
		  		  if(substr($linha->rubrica,0,3) == '422'){
		  		  	 $oReceitaPrevistaAnual['recAlienacao'] += $linha->vlrorcado;
		  		  } else if (substr($linha->rubrica,0,3) == '423'){
		  		  	 $oReceitaPrevistaAnual['recAmort'] += $linha->vlrorcado;
		  		  }else if ( (substr($linha->rubrica,0,3) == '424') && (substr($linha->rubrica,0,4) != '4247') ){
		  		  	 $oReceitaPrevistaAnual['recTransfCapital'] += $linha->vlrorcado;
		  		  }else if (substr($linha->rubrica,0,3) == '4247'){
		  		  	 $oReceitaPrevistaAnual['recConvenios'] += $linha->vlrorcado;
		  		  }else if ((substr($linha->rubrica,0,2) == '421') && (substr($linha->rubrica,0,3) != '495') ){
		  		  	 $oReceitaPrevistaAnual['recRetOpCred'] += $linha->vlrorcado;
		  		  }else if (substr($linha->rubrica,0,4) == '492'){
		  		  	 $oReceitaPrevistaAnual['deducoes'] += $linha->vlrorcado;
		  		  }else {
		  		  	 $oReceitaPrevistaAnual['outRecCap'] += $linha->vlrorcado;
		  		  }

		  		  $oReceitaPrevistaAnual['recPrivat']     = '000';
		  		  $oReceitaPrevistaAnual['recRefDivida']  = '000';
		  		  $oReceitaPrevistaAnual['recOutOpCred']  = '000';
		  		  
		  		  
		  		  //receitas atualizada
		  		  		  		  
		  		  if(substr($linha->rubrica,0,3) == '422'){
		  		  	 $oReceitaAtualizada['recAlienacao'] += $linha->vlrorcado;
		  		  } else if (substr($linha->rubrica,0,3) == '423'){
		  		  	 $oReceitaAtualizada['recAmort'] += $linha->vlrorcado;
		  		  }else if ( (substr($linha->rubrica,0,3) == '424') && (substr($linha->rubrica,0,4) != '4247') ){
		  		  	 $oReceitaAtualizada['recTransfCapital'] += $linha->vlrorcado;
		  		  }else if (substr($linha->rubrica,0,3) == '4247'){
		  		  	 $oReceitaAtualizada['recConvenios'] += $linha->vlrorcado;
		  		  }else if ((substr($linha->rubrica,0,2) == '421') && (substr($linha->rubrica,0,3) != '495') ){
		  		  	 $oReceitaAtualizada['recRetOpCred'] += $linha->vlrorcado;
		  		  }else if (substr($linha->rubrica,0,4) == '492'){
		  		  	 $oReceitaAtualizada['deducoes'] += $linha->vlrorcado;
		  		  }else {
		  		  	 $oReceitaAtualizada['outRecCap'] += $linha->vlrorcado;
		  		  }
		  		  $oReceitaAtualizada['recPrivat']     = '000';
		  		  $oReceitaAtualizada['recRefDivida']  = '000';
		  		  $oReceitaAtualizada['recOutOpCred']  = '000';
		  		  
		          //receitas prevista no mes
		  		  		  		  
		  		  if(substr($linha->rubrica,0,3) == '422'){
		  		  	 $oReceitaPrevistaMes['recAlienacao'] += ($linha->vlrorcado /6);
		  		  } else if (substr($linha->rubrica,0,3) == '423'){
		  		  	 $oReceitaPrevistaMes['recAmort'] += ($linha->vlrorcado / 12);
		  		  }else if ( (substr($linha->rubrica,0,3) == '424') && (substr($linha->rubrica,0,4) != '4247') ){
		  		  	 $oReceitaPrevistaMes['recTransfCapital'] += ($linha->vlrorcado / 6);
		  		  }else if (substr($linha->rubrica,0,3) == '4247'){
		  		  	 $oReceitaPrevistaMes['recConvenios'] += ($linha->vlrorcado / 6);
		  		  }else if ((substr($linha->rubrica,0,2) == '421') && (substr($linha->rubrica,0,3) != '495') ){
		  		  	 $oReceitaPrevistaMes['recRetOpCred'] += ($linha->vlrorcado / 6);
		  		  }else if (substr($linha->rubrica,0,4) == '492'){
		  		  	 $oReceitaPrevistaMes['deducoes'] += ($linha->vlrorcado / 6);
		  		  }else {
		  		  	 $oReceitaPrevistaMes['outRecCap'] += ($linha->vlrorcado / 6);
		  		  }
		  		  $oReceitaPrevistaMes['recPrivat']     = '000';
		  		  $oReceitaPrevistaMes['recRefDivida']  = '000';
		  		  $oReceitaPrevistaMes['recOutOpCred']  = '000';
		  		  
		  		 //receitas realizada
		  		  
		  		  if(substr($linha->rubrica,0,3) == '422'){
		  		  	 $oReceitaRealizada['recAlienacao'] += $linha->vlrarrecadado;
		  		  } else if (substr($linha->rubrica,0,3) == '423'){
		  		  	 $oReceitaRealizada['recAmort'] += $linha->vlrarrecadado;
		  		  }else if ( (substr($linha->rubrica,0,3) == '424') && (substr($linha->rubrica,0,4) != '4247') ){
		  		  	 $oReceitaRealizada['recTransfCapital'] += $linha->vlrarrecadado;
		  		  }else if (substr($linha->rubrica,0,3) == '4247'){
		  		  	 $oReceitaRealizada['recConvenios'] += $linha->vlrarrecadado;
		  		  }else if ((substr($linha->rubrica,0,2) == '421') && (substr($linha->rubrica,0,3) != '495') ){
		  		  	 $oReceitaRealizada['recRetOpCred'] += $linha->vlrarrecadado;
		  		  }else if (substr($linha->rubrica,0,4) == '492'){
		  		  	 $oReceitaRealizada['deducoes'] += $linha->vlrarrecadado;
		  		  }else {
		  		  	 $oReceitaRealizada['outRecCap'] += $linha->vlrarrecadado;
		  		  }
		  		  $oReceitaRealizada['recPrivat']     = '000';
		  		  $oReceitaRealizada['recRefDivida']  = '000';
		  		  $oReceitaRealizada['recOutOpCred']  = '000';
		  		  
		 
		  }
		  if($iMes == '01'){
		  	$aDados[]=$oReceitaPrevistaAnual;
		  }
		  $aDados[]=$oReceitaAtualizada;
		  if( $iMes % 2 == 0){
		  	$aDados[]=$oReceitaPrevistaMes;
		  }
		  $aDados[]=$oReceitaRealizada;
		
		  $aDadosFormatados = array();
		  foreach ($aDados as $obj){
		  		
		  		$obj['recAlienacao']       = number_format($obj['recAlienacao'],2,"","");
				$obj['recAmort']    = number_format($obj['recAmort'],2,"","");
				$obj['recTransfCapital']    = number_format($obj['recTransfCapital'],2,"","");
				$obj['recConvenios']      = number_format($obj['recConvenios'],2,"","");
				$obj['outRecCap']      = number_format($obj['outRecCap'],2,"","");
				$obj['recRetOpCred']      = number_format($obj['recConvenios'],2,"","");
				$obj['recPrivat']      = number_format($obj['recConvenios'],2,"","");
				$obj['recRefDivida']      = number_format($obj['recConvenios'],2,"","");
				$obj['recOutOpCred']      = number_format($obj['recConvenios'],2,"","");
				$obj['deducoes']      = number_format($obj['recConvenios'],2,"","");
				
				$aDadosFormatados[] 		= $obj;
		  }
		  	 	
		  $this->gerarArquivo($aDadosFormatados, $nomeArquivo);
		  
		  return $this->retornaNome();
		  
		   //funcao para crias ors aquivos
		  
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