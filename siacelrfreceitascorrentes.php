<?php

class siacelrfreceitascorrentes {
	
 protected $sNomeArquivo = 'receitaCorrente';
 
 public function gerarDados($sDataInicial,$sDataFinal) {
//arquivo depesas correntes
  $nomeArquivo= $this->sNomeArquivo;
  
  $aDadosSubUnidades = array();
  
  //pegar o mês de referencia da siacelrf
  $aData = explode('-', $sDataInicial);
  $iMes = $aData[1];
    
  $oReceitaPrevistaAnual = array();
  $oReceitaPrevistaAnual['mes'] = $iMes;
  $oReceitaPrevistaAnual['recContrib'] = 0;
  $oReceitaPrevistaAnual['recIndust'] = 0;
  $oReceitaPrevistaAnual['recAgropec'] = 0;
  $oReceitaPrevistaAnual['recServ'] = 0;
  $oReceitaPrevistaAnual['outrasRecCor'] = 0;
  $oReceitaPrevistaAnual['tribTaxas'] = 0;
  $oReceitaPrevistaAnual['tribContMelhoria'] = 0;
  $oReceitaPrevistaAnual['recAplic'] = 0;
  $oReceitaPrevistaAnual['outrasRec'] = 0;
  $oReceitaPrevistaAnual['recIPTU'] = 0;
  $oReceitaPrevistaAnual['recISSQN'] = 0;
  $oReceitaPrevistaAnual['recITBI'] = 0;
  $oReceitaPrevistaAnual['cotaParteFPM'] = 0;
  $oReceitaPrevistaAnual['transfIRRF'] = 0;
  $oReceitaPrevistaAnual['cotaParteICMS'] = 0;
  $oReceitaPrevistaAnual['cotaParteIPVA'] = 0;
  $oReceitaPrevistaAnual['cotaParteIPI'] = 0;
  $oReceitaPrevistaAnual['transfFUNDEB'] = 0;
  $oReceitaPrevistaAnual['Convenios'] = 0;
  $oReceitaPrevistaAnual['outrasTransf'] = 0;
  $oReceitaPrevistaAnual['deducoesExcFundeb'] = 0;
  $oReceitaPrevistaAnual['CodTipo'] = '01';
  
  
  $oReceitaAtualizada = array();
  $oReceitaAtualizada['mes'] = $iMes;
  $oReceitaAtualizada['recContrib'] = 0;
  $oReceitaAtualizada['recIndust'] = 0;
  $oReceitaAtualizada['recAgropec'] = 0;
  $oReceitaAtualizada['recServ'] = 0;
  $oReceitaAtualizada['outrasRecCor'] = 0;
  $oReceitaAtualizada['tribTaxas'] = 0;
  $oReceitaAtualizada['tribContMelhoria'] = 0;
  $oReceitaAtualizada['recAplic'] = 0;
  $oReceitaAtualizada['outrasRec'] = 0;
  $oReceitaAtualizada['recIPTU'] = 0;
  $oReceitaAtualizada['recISSQN'] = 0;
  $oReceitaAtualizada['recITBI'] = 0;
  $oReceitaAtualizada['cotaParteFPM'] = 0;
  $oReceitaAtualizada['transfIRRF'] = 0;
  $oReceitaAtualizada['cotaParteICMS'] = 0;
  $oReceitaAtualizada['cotaParteIPVA'] = 0;
  $oReceitaAtualizada['cotaParteIPI'] = 0;
  $oReceitaAtualizada['transfFUNDEB'] = 0;
  $oReceitaAtualizada['Convenios'] = 0;
  $oReceitaAtualizada['outrasTransf'] = 0;
  $oReceitaAtualizada['deducoesExcFundeb'] = 0;
  $oReceitaAtualizada['CodTipo'] = '02';
  
  
  $oReceitaPrevistaMes = array();
  $oReceitaPrevistaMes['mes'] = $iMes;
  $oReceitaPrevistaMes['recContrib'] = 0;
  $oReceitaPrevistaMes['recIndust'] = 0;
  $oReceitaPrevistaMes['recAgropec'] = 0;
  $oReceitaPrevistaMes['recServ'] = 0;
  $oReceitaPrevistaMes['outrasRecCor'] = 0;
  $oReceitaPrevistaMes['tribTaxas'] = 0;
  $oReceitaPrevistaMes['tribContMelhoria'] = 0;
  $oReceitaPrevistaMes['recAplic'] = 0;
  $oReceitaPrevistaMes['outrasRec'] = 0;
  $oReceitaPrevistaMes['recIPTU'] = 0;
  $oReceitaPrevistaMes['recISSQN'] = 0;
  $oReceitaPrevistaMes['recITBI'] = 0;
  $oReceitaPrevistaMes['cotaParteFPM'] = 0;
  $oReceitaPrevistaMes['transfIRRF'] = 0;
  $oReceitaPrevistaMes['cotaParteICMS'] = 0;
  $oReceitaPrevistaMes['cotaParteIPVA'] = 0;
  $oReceitaPrevistaMes['cotaParteIPI'] = 0;
  $oReceitaPrevistaMes['transfFUNDEB'] = 0;
  $oReceitaPrevistaMes['Convenios'] = 0;
  $oReceitaPrevistaMes['outrasTransf'] = 0;
  $oReceitaPrevistaMes['deducoesExcFundeb'] = 0;
  $oReceitaPrevistaMes['CodTipo'] = '03';
  
  
  $oReceitaRealizada = array();
  $oReceitaRealizada['mes'] = $iMes;
  $oReceitaRealizada['recContrib'] = 0;
  $oReceitaRealizada['recIndust'] = 0;
  $oReceitaRealizada['recAgropec'] = 0;
  $oReceitaRealizada['recServ'] = 0;
  $oReceitaRealizada['outrasRecCor'] = 0;
  $oReceitaRealizada['tribTaxas'] = 0;
  $oReceitaRealizada['tribContMelhoria'] = 0;
  $oReceitaRealizada['recAplic'] = 0;
  $oReceitaRealizada['outrasRec'] = 0;
  $oReceitaRealizada['recIPTU'] = 0;
  $oReceitaRealizada['recISSQN'] = 0;
  $oReceitaRealizada['recITBI'] = 0;
  $oReceitaRealizada['cotaParteFPM'] = 0;
  $oReceitaRealizada['transfIRRF'] = 0;
  $oReceitaRealizada['cotaParteICMS'] = 0;
  $oReceitaRealizada['cotaParteIPVA'] = 0;
  $oReceitaRealizada['cotaParteIPI'] = 0;
  $oReceitaRealizada['transfFUNDEB'] = 0;
  $oReceitaRealizada['Convenios'] = 0;
  $oReceitaRealizada['outrasTransf'] = 0;
  $oReceitaRealizada['deducoesExcFundeb'] = 0;
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
       	      where o70_anousu = ".db_getsession("DB_anousu")." and  substr(o57_fonte,1,2) = '41' order by o57_fonte ";
   
  $rsResultReceitas =  db_query($sql);
  
  for($y = 0; $y< pg_num_rows($rsResultReceitas);$y++){
  		
  		 $linha = pg_fetch_object($rsResultReceitas,$y);
  		
  		 
  		
  		  //receitas previstas
  		  
	  		  if(substr($linha->rubrica,0,3) == '412'){
	  		  	 $oReceitaPrevistaAnual['recContrib'] += $linha->vlrorcado;
	  		  } else if (substr($linha->rubrica,0,3) == '415'){
	  		  	 $oReceitaPrevistaAnual['recIndust'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,3) == '414'){
	  		  	 $oReceitaPrevistaAnual['recAgropec'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,3) == '416'){
	  		  	 $oReceitaPrevistaAnual['recServ'] += $linha->vlrorcado;
	  		  }else if ((substr($linha->rubrica,0,2) == '491') && (substr($linha->rubrica,0,3) != '495') ){
	  		  	 $oReceitaPrevistaAnual['deducoesExcFundeb'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,4) == '4112'){
	  		  	 $oReceitaPrevistaAnual['tribTaxas'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,4) == '4113'){
	  		  	 $oReceitaPrevistaAnual['tribContMelhoria'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,7) == '4111202'){
	  		  	 $oReceitaPrevistaAnual['recIPTU'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,7) == '4111305'){
	  		  	 $oReceitaPrevistaAnual['recISSQN'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,7) == '4111208'){
	  		  	 $oReceitaPrevistaAnual['recITBI'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,9) == '411120431'){
	  		  	 $oReceitaPrevistaAnual['transfIRRF'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,5) == '41325'){
	  		  	 $oReceitaPrevistaAnual['recAplic'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,3) == '413' && $linha->rubrica !=  '41325'){
	  		  	 $oReceitaPrevistaAnual['outrasRec'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,9) == '417210102'){
	  		  	 $oReceitaPrevistaAnual['cotaParteFPM'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,9) == '417220101'){
	  		  	 $oReceitaPrevistaAnual['cotaParteICMS'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,9) == '417220102'){
	  		  	 $oReceitaPrevistaAnual['cotaParteIPVA'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,9) == '417220104'){
	  		  	 $oReceitaPrevistaAnual['cotaParteIPI'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,7) == '4172401'){
	  		  	 $oReceitaPrevistaAnual['transfFUNDEB'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,4) == '4176'){
	  		  	 $oReceitaPrevistaAnual['Convenios'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,3) == '417'){
	  		  	 $oReceitaPrevistaAnual['outrasTransf'] += $linha->vlrorcado;
	  		  }else {
	  		  	 $oReceitaPrevistaAnual['outrasRecCor'] += $linha->vlrorcado;
	  		  }
	  		  
	  		  //receitas atualizada
	  		  if(substr($linha->rubrica,0,3) == '412'){
	  		  	 $oReceitaAtualizada['recContrib'] += $linha->vlrorcado;
	  		  } else if (substr($linha->rubrica,0,3) == '415'){
	  		  	 $oReceitaAtualizada['recIndust'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,3) == '414'){
	  		  	 $oReceitaAtualizada['recAgropec'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,3) == '416'){
	  		  	 $oReceitaAtualizada['recServ'] += $linha->vlrorcado;
	  		  }else if ((substr($linha->rubrica,0,2) == '491') && (substr($linha->rubrica,0,3) != '495') ){
	  		  	 $oReceitaAtualizada['deducoesExcFundeb'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,4) == '4112'){
	  		  	 $oReceitaAtualizada['tribTaxas'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,4) == '4113'){
	  		  	 $oReceitaAtualizada['tribContMelhoria'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,7) == '4111202'){
	  		  	 $oReceitaAtualizada['recIPTU'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,7) == '4111305'){
	  		  	 $oReceitaAtualizada['recISSQN'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,7) == '4111208'){
	  		  	 $oReceitaAtualizada['recITBI'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,9) == '411120431'){
	  		  	 $oReceitaAtualizada['transfIRRF'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,5) == '41325'){
	  		  	 $oReceitaAtualizada['recAplic'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,3) == '413' && $linha->rubrica !=  '41325'){
	  		  	 $oReceitaAtualizada['outrasRec'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,9) == '417210102'){
	  		  	 $oReceitaAtualizada['cotaParteFPM'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,9) == '417220101'){
	  		  	 $oReceitaAtualizada['cotaParteICMS'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,9) == '417220102'){
	  		  	 $oReceitaAtualizada['cotaParteIPVA'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,9) == '417220104'){
	  		  	 $oReceitaAtualizada['cotaParteIPI'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,7) == '4172401'){
	  		  	 $oReceitaAtualizada['transfFUNDEB'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,4) == '4176'){
	  		  	 $oReceitaAtualizada['Convenios'] += $linha->vlrorcado;
	  		  }else if (substr($linha->rubrica,0,3) == '417'){
	  		  	 $oReceitaAtualizada['outrasTransf'] += $linha->vlrorcado;
	  		  }else {
	  		  	 $oReceitaAtualizada['outrasRecCor'] += $linha->vlrorcado;
	  		  }
	  		  
	          //receitas prevista no mes
	  		  if(substr($linha->rubrica,0,3) == '412'){
	  		  	 $oReceitaPrevistaMes['recContrib'] += ($linha->vlrorcado / 6);
	  		  } else if (substr($linha->rubrica,0,3) == '415'){
	  		  	 $oReceitaPrevistaMes['recIndust'] += ($linha->vlrorcado / 6);
	  		  }else if (substr($linha->rubrica,0,3) == '414'){
	  		  	 $oReceitaPrevistaMes['recAgropec'] += ($linha->vlrorcado / 6);
	  		  }else if (substr($linha->rubrica,0,3) == '416'){
	  		  	 $oReceitaPrevistaMes['recServ'] += ($linha->vlrorcado / 6);
	  		  }else if ((substr($linha->rubrica,0,2) == '491') && (substr($linha->rubrica,0,3) != '495') ){
	  		  	 $oReceitaPrevistaMes['deducoesExcFundeb'] += ($linha->vlrorcado / 6);
	  		  }else if (substr($linha->rubrica,0,4) == '4112'){
	  		  	 $oReceitaPrevistaMes['tribTaxas'] += ($linha->vlrorcado / 6);
	  		  }else if (substr($linha->rubrica,0,4) == '4113'){
	  		  	 $oReceitaPrevistaMes['tribContMelhoria'] += ($linha->vlrorcado / 6);
	  		  }else if (substr($linha->rubrica,0,7) == '4111202'){
	  		  	 $oReceitaPrevistaMes['recIPTU'] += ($linha->vlrorcado / 6);
	  		  }else if (substr($linha->rubrica,0,7) == '4111305'){
	  		  	 $oReceitaPrevistaMes['recISSQN'] += ($linha->vlrorcado / 6);
	  		  }else if (substr($linha->rubrica,0,7) == '4111208'){
	  		  	 $oReceitaPrevistaMes['recITBI'] += ($linha->vlrorcado / 6);
	  		  }else if (substr($linha->rubrica,0,9) == '411120431'){
	  		  	 $oReceitaPrevistaMes['transfIRRF'] += ($linha->vlrorcado / 6);
	  		  }else if (substr($linha->rubrica,0,5) == '41325'){
	  		  	 $oReceitaPrevistaMes['recAplic'] += ($linha->vlrorcado / 6);
	  		  }else if (substr($linha->rubrica,0,3) == '413' && $linha->rubrica !=  '41325'){
	  		  	 $oReceitaPrevistaMes['outrasRec'] += ($linha->vlrorcado / 6);
	  		  }else if (substr($linha->rubrica,0,9) == '417210102'){
	  		  	 $oReceitaPrevistaMes['cotaParteFPM'] += ($linha->vlrorcado / 6);
	  		  }else if (substr($linha->rubrica,0,9) == '417220101'){
	  		  	 $oReceitaPrevistaMes['cotaParteICMS'] += ($linha->vlrorcado / 6);
	  		  }else if (substr($linha->rubrica,0,9) == '417220102'){
	  		  	 $oReceitaPrevistaMes['cotaParteIPVA'] += ($linha->vlrorcado / 6);
	  		  }else if (substr($linha->rubrica,0,9) == '417220104'){
	  		  	 $oReceitaPrevistaMes['cotaParteIPI'] += ($linha->vlrorcado / 6);
	  		  }else if (substr($linha->rubrica,0,7) == '4172401'){
	  		  	 $oReceitaPrevistaMes['transfFUNDEB'] += ($linha->vlrorcado / 6);
	  		  }else if (substr($linha->rubrica,0,4) == '4176'){
	  		  	 $oReceitaPrevistaMes['Convenios'] += ( $linha->vlrorcado / 6);
	  		  }else if (substr($linha->rubrica,0,3) == '417'){
	  		  	 $oReceitaAtualizada['outrasTransf'] += ($linha->vlrorcado / 6);
	  		  }else {
	  		  	 $oReceitaPrevistaMes['outrasRecCor'] += ($linha->vlrorcado / 6);
	  		  }
	  		  
	  		 //receitas realizada
	  		  if(substr($linha->rubrica,0,3) == '412'){
	  		  	 $oReceitaRealizada['recContrib'] += $linha->vlrarrecadado;
	  		  } else if (substr($linha->rubrica,0,3) == '415'){
	  		  	 $oReceitaRealizada['recIndust'] += $linha->vlrarrecadado;
	  		  }else if (substr($linha->rubrica,0,3) == '414'){
	  		  	 $oReceitaRealizada['recAgropec'] += $linha->vlrarrecadado;
	  		  }else if (substr($linha->rubrica,0,3) == '416'){
	  		  	 $oReceitaRealizada['recServ'] += $linha->vlrarrecadado;
	  		  }else if ((substr($linha->rubrica,0,2) == '491') && (substr($linha->rubrica,0,3) != '495') ){
	  		  	 $oReceitaRealizada['deducoesExcFundeb'] += $linha->vlrarrecadado;
	  		  }else if (substr($linha->rubrica,0,4) == '4112'){
	  		  	 $oReceitaRealizada['tribTaxas'] += $linha->vlrarrecadado;
	  		  }else if (substr($linha->rubrica,0,4) == '4113'){
	  		  	 $oReceitaRealizada['tribContMelhoria'] += $linha->vlrarrecadado;
	  		  }else if (substr($linha->rubrica,0,7) == '4111202'){
	  		  	 $oReceitaRealizada['recIPTU'] += $linha->vlrarrecadado;
	  		  }else if (substr($linha->rubrica,0,7) == '4111305'){
	  		  	 $oReceitaRealizada['recISSQN'] += $linha->vlrarrecadado;
	  		  }else if (substr($linha->rubrica,0,7) == '4111208'){
	  		  	 $oReceitaRealizada['recITBI'] += $linha->vlrarrecadado;
	  		  }else if (substr($linha->rubrica,0,9) == '411120431'){
	  		  	 $oReceitaRealizada['transfIRRF'] += $linha->vlrarrecadado;
	  		  }else if (substr($linha->rubrica,0,5) == '41325'){
	  		  	 $oReceitaRealizada['recAplic'] += $linha->vlrarrecadado;
	  		  }else if (substr($linha->rubrica,0,3) == '413' && $linha->rubrica !=  '41325'){
	  		  	 $oReceitaRealizada['outrasRec'] += $linha->vlrarrecadado;
	  		  }else if (substr($linha->rubrica,0,9) == '417210102'){
	  		  	 $oReceitaRealizada['cotaParteFPM'] += $linha->vlrarrecadado;
	  		  }else if (substr($linha->rubrica,0,9) == '417220101'){
	  		  	 $oReceitaRealizada['cotaParteICMS'] += $linha->vlrarrecadado;
	  		  }else if (substr($linha->rubrica,0,9) == '417220102'){
	  		  	 $oReceitaRealizada['cotaParteIPVA'] += $linha->vlrarrecadado;
	  		  }else if (substr($linha->rubrica,0,9) == '417220104'){
	  		  	 $oReceitaRealizada['cotaParteIPI'] += $linha->vlrarrecadado;
	  		  }else if (substr($linha->rubrica,0,7) == '4172401'){
	  		  	 $oReceitaRealizada['transfFUNDEB'] += $linha->vlrarrecadado;
	  		  }else if (substr($linha->rubrica,0,4) == '4176'){
	  		  	 $oReceitaRealizada['Convenios'] += $linha->vlrarrecadado;
	  		  }else if (substr($linha->rubrica,0,3) == '417'){
	  		  	 $oReceitaRealizada['outrasTransf'] += $linha->vlrarrecadado;
	  		  }else {
	  		  	 $oReceitaRealizada['outrasRecCor'] += $linha->vlrarrecadado;
	  		  }
  		  
 
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
		  		
		  		$obj['recContrib']        = number_format($obj['recContrib'],2,"","");
				$obj['recIndust']         = number_format($obj['recIndust'],2,"","");
				$obj['recAgropec']        = number_format($obj['recAgropec'],2,"","");
				$obj['recServ']           = number_format($obj['recServ'],2,"","");
				$obj['outrasRecCor']      = number_format($obj['outrasRecCor'],2,"","");
				$obj['tribTaxas']         = number_format($obj['tribTaxas'],2,"","");
				$obj['tribContMelhoria']  = number_format($obj['tribContMelhoria'],2,"","");
				$obj['recAplic']          = number_format($obj['recAplic'],2,"","");
				$obj['outrasRec']         = number_format($obj['outrasRec'],2,"","");
				$obj['recIPTU']           = number_format($obj['recIPTU'],2,"","");
				$obj['recISSQN']          = number_format($obj['recISSQN'],2,"","");
				$obj['recITBI']           = number_format($obj['recITBI'],2,"","");
				$obj['cotaParteFPM']      = number_format($obj['cotaParteFPM'],2,"","");
				$obj['transfIRRF']        = number_format($obj['transfIRRF'],2,"","");
				$obj['cotaParteICMS']     = number_format($obj['cotaParteICMS'],2,"","");
				$obj['cotaParteIPVA']     = number_format($obj['cotaParteIPVA'],2,"","");
				$obj['cotaParteIPI']      = number_format($obj['cotaParteIPI'],2,"","");
				$obj['transfFUNDEB']      = number_format($obj['transfFUNDEB'],2,"","");
				$obj['Convenios']         = number_format($obj['Convenios'],2,"","");
				$obj['outrasTransf']      = number_format($obj['outrasTransf'],2,"","");
				$obj['deducoesExcFundeb'] = number_format($obj['deducoesExcFundeb'],2,"","");
				
				$aDadosFormatados[] 		= $obj;
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