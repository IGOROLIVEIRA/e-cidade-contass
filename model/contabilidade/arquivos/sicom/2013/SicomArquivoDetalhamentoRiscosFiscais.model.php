<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

class SicomArquivoDetalhamentoRiscosFiscais extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
  protected $iCodigoLayout = 144;
  
  protected $sNomeArquivo = 'RFIS';
  
  protected $iCodigoPespectiva;
  
  public function __construct() {
    
  }
  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV 
   */
  public function getCampos(){
    
    $aElementos[10]  = array(
                          "tipoRegistro",
                          "codRF",
                          "codOrgao",
                          "exercicio",
                          "codRiscoFiscal",
    											"dscRiscoFiscal",
                          "vlRiscoFiscal"
                        );

    $aElementos[11]  = array(
                          "tipoRegistro",
                          "codRF",
                          "codProvidencia",
                          "dscProvidencia",
                          "vlAssociadoProvidencia"
                        );
                        
    return $aElementos;
  }
  
  public function gerarDados(){
  	
  	/*
  	 * pegar configurações dos orgãos
  	 */
  	$sArquivo = "config/sicom/sicomorgao.xml";
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuração dos orgãos do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oOrgaos      = $oDOMDocument->getElementsByTagName('orgao');
    foreach ($oOrgaos as $oOrgao) {
    
	    /*
	  	 * pegar configurações dos riscos fiscais
	  	 */
	  	$sArquivo = "config/sicom/sicomriscos.xml";
	    if (!file_exists($sArquivo)) {
	      throw new Exception("Arquivo riscos fiscais inexistente!");
	    }
	    $sTextoXml    = file_get_contents($sArquivo);
	    $oDOMDocument = new DOMDocument();
	    $oDOMDocument->loadXML($sTextoXml);
	    $oRiscos      = $oDOMDocument->getElementsByTagName('risco');
	   
			if (!isset($oRiscos)) {
	      throw new Exception("Não existem Riscos Fiscais Lançadas.");
	    } 
	    
	    /*
	  	 * pegar configurações das providências
	  	 */
	    $sArquivo = "config/sicom/sicomprovidenciasriscos.xml";
			if (!file_exists($sArquivo)) {
				
			  throw new Exception("Arquivo providencias dos riscos fiscais inexistente!");
			} 
	    
			$sTextoXml    = file_get_contents($sArquivo);
			$oDOMDocument = new DOMDocument();
			$oDOMDocument->loadXML($sTextoXml);
			$oProvidencias  = $oDOMDocument->getElementsByTagName('providencia');
			if (!isset($oProvidencias)) {
	      throw new Exception("Não existem Proviências Lançadas.");
	    }  
			
	    foreach ($oRiscos as $oRisco) {
	      //echo($oRisco->getAttribute('exercicio'));//exit;
	      if ($oRisco->getAttribute("codPerspectiva") == $this->getCodigoPespectiva() AND 
	      		$oRisco->getAttribute("instituicao") == $oOrgao->getAttribute('instituicao')) {
					
	      	$oDadosRiscos = new stdClass();
	        $oDadosRiscos->tipoRegistro    = 10;
	        $oDadosRiscos->detalhesessao   = 10;
	        $oDadosRiscos->codRF           = substr($oRisco->getAttribute("codRisco"),0,15);//verificar se vai pegar os numeros a partir da direita ou esquerda
	        $oDadosRiscos->codOrgao        = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
	        $oDadosRiscos->exercicio       = str_pad($oRisco->getAttribute("exercicio"), 4, "0", STR_PAD_LEFT);
	        $oDadosRiscos->codRiscoFiscal  = str_pad($oRisco->getAttribute("codRiscoFiscal"), 2, "0", STR_PAD_LEFT);
	        $oDadosRiscos->dscRiscoFiscal  = str_pad($oRisco->getAttribute("dscRiscoFiscal"), 500, "0", STR_PAD_LEFT);
	        $oDadosRiscos->vlRiscoFiscal   = number_format($oRisco->getAttribute("vlRiscoFiscal"),2,"","");
	        //print_r($oDadosRiscos);echo "<br>";
	        $this->aDados[] = $oDadosRiscos;
	        
			    foreach ($oProvidencias as $oProvidencia){
			    	if($oProvidencia->getAttribute("codRisco") == $oRisco->getAttribute("codRisco")){
			    		$oDadosProvidencias = new stdClass();
			    		$oDadosProvidencias->tipoRegistro           = 11;
			    		$oDadosProvidencias->detalhesessao          = 11;
			    		$oDadosProvidencias->codRF                  = substr($oProvidencia->getAttribute("codRisco"), 0, 15);
			    		$oDadosProvidencias->codProvidencia         = substr($oProvidencia->getAttribute("codProvidencia"), 0, 6);
			    		$oDadosProvidencias->dscProvidencia         = substr($oProvidencia->getAttribute("dscProvidencia"), 0, 50);
			    		$oDadosProvidencias->vlAssociadoProvidencia = number_format($oProvidencia->getAttribute("vlAssociadoProvidencia"), 2, "", "");
			    		//print_r($oDadosProvidencias);echo "<br>";
			    		$this->aDados[] = $oDadosProvidencias;
			    	}
			    		
			    }
	      }
			 }
    }     
  }
  
  public function setCodigoPespectiva($iCodigoPespectiva) {
    $this->iCodigoPespectiva = $iCodigoPespectiva;
  }
  
  public function getCodigoPespectiva() {
    return $this->iCodigoPespectiva;
  }
}