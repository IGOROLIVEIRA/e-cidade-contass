<?php


/**
  * detalhamento das receitas do mês Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoSalvarSaldoRec {
	
	
	public $sCnpj;
	public $sMes;
	
	public function SalvarXml ($oDadosRec) {
		
	 $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$this->sCnpj}_sicomsaldorec.xml";
	 if (!file_exists($sArquivo)) {
		
     $oDOMDocument = new DOMDocument('1.0','ISO-8859-1');
     $oRoot  = $oDOMDocument->createElement('recs');
    
   }else{
  	
  	 $oDOMDocument = new DOMDocument();
  	 $sTextoXml    = file_get_contents($sArquivo);
     $oDOMDocument->loadXML($sTextoXml);
     $oRoot  = $oDOMDocument->documentElement;
    	
   }
    
   $oDOMDocument->formatOutput = true;
  
   $oDados      = $oDOMDocument->getElementsByTagName('rec');
  
   /**
    * caso o codigo já exista no xml irá atualizar o registro
    */
         
   foreach ($oDados as $oRow) {
  	
		 if ($oRow->getAttribute("codReceita") == $oDadosRec->codReceita
		     && $oRow->getAttribute("codFonte") == $oDadosRec->codFonte
		     && $oRow->getAttribute("instituicao") == db_getsession("DB_instit")
		     && $oRow->getAttribute("mes") == $this->sMes) {
			
			 $oDado = new stdClass();
			 $oDado = $oRow;
			 $oDado->setAttribute("vlAcumuladoFonteMesAnt", ($oDadosRec->vlArrecadadoFonte+$oDadosRec->vlAcumuladoFonteMesAnt));
			
		   $oDOMDocument->save($sArquivo);
		  
     }
    
   }
   if (!$oDado) {
  	
  	 $oDado  = $oDOMDocument->createElement('rec');
  	
  	 $oDado->setAttribute("instituicao", db_getsession("DB_instit"));
  	
  	 	
  	 /**
  	  * passar os valores para o objeto para ser salvo no xml
  	  */
  	 $oDado->setAttribute("codReceita", $oDadosRec->codReceita);
  	 $oDado->setAttribute("codFonte", $oDadosRec->codFonte);
  	 $oDado->setAttribute("mes", $this->sMes);
	   $oDado->setAttribute("vlAcumuladoFonteMesAnt", ($oDadosRec->vlArrecadadoFonte+$oDadosRec->vlAcumuladoFonteMesAnt));
	  
	   if (!file_exists($sArquivo)) {
	  	
	  	 $oRoot->appendChild($oDado);
	     $oDOMDocument->appendChild($oRoot);
	    	
	   } else {
	  	 $oDado = $oRoot->appendChild($oDado);
	   }
	  
	   $oDOMDocument->save($sArquivo);
	  
   }
  
		
	}
	
}