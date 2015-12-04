<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

class SicomArquivoProgramaPPA extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
  protected $iCodigoLayout = 137;
  
  protected $sNomeArquivo = 'PRO';
  
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
    
    $aElementos  = array(
                          "codPrograma",
                          "nomePrograma",
                          "objetivo",
                          "totRecursos1Ano",
                          "totRecursos2Ano",
                          "totRecursos3Ano",
    											"totRecursos4Ano"
                        );
    return $aElementos;
  }
  
  public function gerarDados(){
    require_once ("model/ppaVersao.model.php");
    require_once ("model/ppadespesa.model.php");
    
    $oPPAVersao  = new ppaVersao($this->getCodigoPespectiva());
    $oPPADespesa = new ppaDespesa($this->getCodigoPespectiva());
    
    
    $sArquivo = "config/sicom/sicomorgao.xml";
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuração dos orgãos do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oOrgaos      = $oDOMDocument->getElementsByTagName('orgao');
    $aOrgao       = array();
    foreach ($oOrgaos as $oOrgao) {
    	
    	$sSqlInstit  = "SELECT o08_instit FROM ppadotacao ";
    	$sSqlInstit .= "WHERE o08_instit = {$oOrgao->getAttribute('codOrgao')}";
    	$rsInstit    = db_query($sSqlInstit);
    	//$iInstit     = pg_num_rows($rsInstit);
     	if ($rsInstit) {
    		$aOrgao[] = $oOrgao->getAttribute('codOrgao');
    	}
    }
		// Lista das instituições selecionadas
		$sListaInstit = implode(",",$aOrgao);
	    /**
	     * pegar estimativas por programa
	     */
	    $oPPADespesa->setInstituicoes($sListaInstit);
	    $aDespesa = $oPPADespesa->getQuadroEstimativas(null, 5);
	    //print_r($aDespesa);
	
	    $sSqlPrograma  = "SELECT DISTINCT p.o54_programa, p.o54_descr, p.o54_finali ";
	    $sSqlPrograma .= "FROM orcprograma p ";
	    //$sSqlPrograma .= "JOIN ppadotacao d ";
	    //$sSqlPrograma .= "ON p.o54_programa = d.o08_programa AND p.o54_anousu = d.o08_ano ";
	    $sSqlPrograma .= "WHERE p.o54_anousu between {$oPPAVersao->getAnoinicio()} AND {$oPPAVersao->getAnofim()}";
	    //$sSqlPrograma .= " AND d.o58_instit = {$oOrgao->getAttribute('instituicao')}"; 
	    
	    $rsPrograma    = db_query($sSqlPrograma);
	    //db_criatabela($rsPrograma);
	    
	    for ($iCont = 0; $iCont < pg_num_rows($rsPrograma); $iCont++) {
	      
	      $oPrograma =  db_utils::fieldsMemory($rsPrograma, $iCont);
	      
	      $oDadosPRO = new stdClass();
	    
		    $oDadosPRO->codPrograma        = str_pad($oPrograma->o54_programa, 4, "0", STR_PAD_LEFT);
		    $oDadosPRO->nomePrograma       = substr($oPrograma->o54_descr,0 ,100);
		    $oDadosPRO->objetivo           = substr($oPrograma->o54_finali, 0, 230);
		    
		    foreach ($aDespesa as $sEstimativa) {
			    	//print_r($sEstimativa);
			    	if($sEstimativa->iCodigo == $oPrograma->o54_programa){
			    		
			    		$iNum = 1;
			    		foreach ($sEstimativa->aEstimativas as $nValorAno){
			    			
			    			$sRecurso = "totRecursos".$iNum."Ano";
		    				$oDadosPRO->$sRecurso    = number_format($nValorAno,2,"","");
		    				$iNum++;
			    		}
			    	}
		    }
		
		    $this->aDados[] = $oDadosPRO;
	    }
  }
  
  public function setCodigoPespectiva($iCodigoPespectiva) {
    $this->iCodigoPespectiva = $iCodigoPespectiva;
  }
  
  public function getCodigoPespectiva() {
    return $this->iCodigoPespectiva;
  }
}