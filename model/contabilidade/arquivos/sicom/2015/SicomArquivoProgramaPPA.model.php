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
    

   	$sSqlInstit  = "SELECT codigo FROM db_config ";
   	$rsInstit    = db_query($sSqlInstit);
    
    
		// Lista das instituições 
    for ($iCont = 0; $iCont < pg_num_rows($rsInstit); $iCont++) {
        
        $oReceita =  db_utils::fieldsMemory($rsInstit, $iCont);
		    $sListaInstit[] = $oReceita->codigo;
    }
        
        
    $sListaInstit = implode(",",$sListaInstit);

	    /**
	     * pegar estimativas por programa
	     */
	    $oPPADespesa->setInstituicoes($sListaInstit);
	    $aDespesa = $oPPADespesa->getQuadroEstimativas(null, 5);
	    
	
	    $sSqlPrograma  = "SELECT DISTINCT p.o54_programa, p.o54_descr, p.o54_finali ";
	    $sSqlPrograma .= "FROM orcprograma p ";
	    $sSqlPrograma .= "WHERE p.o54_anousu between {$oPPAVersao->getAnoinicio()} AND {$oPPAVersao->getAnofim()}";
	   	    
	    $rsPrograma    = db_query($sSqlPrograma);
	   	$aCaracteres = array("°",chr(13),chr(10),"\r","\n");  
	   	
	    for ($iCont = 0; $iCont < pg_num_rows($rsPrograma); $iCont++) {
	      
	      $oPrograma =  db_utils::fieldsMemory($rsPrograma, $iCont);
	      
	      $oDadosPRO = new stdClass();
	    
		    $oDadosPRO->codPrograma        = str_pad($oPrograma->o54_programa, 4, "0", STR_PAD_LEFT);
		    $oDadosPRO->nomePrograma       = substr($oPrograma->o54_descr,0 ,100);
		    $sDescricao                    = str_replace($aCaracteres, "", substr($oPrograma->o54_finali, 0, 230));
		    
		    $oDadosPRO->objetivo           = $sDescricao;
		    
		    foreach ($aDespesa as $sEstimativa) {
			    	
			    	if($sEstimativa->iCodigo ==  $oPrograma->o54_programa){
			    		
				    		$iNum = 1;
				    		foreach ($sEstimativa->aEstimativas as $iAno =>  $nValorAno){
				    			
				    			if ($iAno == db_getsession("DB_anousu")){
				    				
									$sqlValorProg  = "select sum(o58_valor) as valor ";
									$sqlValorProg .="  from orcdotacao where o58_anousu = ".db_getsession("DB_anousu")." 
									                     and o58_programa = ".$oPrograma->o54_programa;
									$rsValorPrograma    = db_query($sqlValorProg);	
									$nValorAno = db_utils::fieldsMemory($rsValorPrograma, 0)->valor;
									
				    			}
				    				
				    			if($nValorAno == ''){
				                  	$nValorAno = 0;
				                }
				    			$sRecurso = "totRecursos".$iNum."Ano";
			    				$oDadosPRO->$sRecurso    = number_format($nValorAno,2,",","");
			    				$iNum++;
				    		}
			    	}
		    }
	        if(    $oDadosPRO->totRecursos1Ano > 0 
	            || $oDadosPRO->totRecursos2Ano > 0 
	            || $oDadosPRO->totRecursos3Ano > 0
	            || $oDadosPRO->totRecursos4Ano > 0
	          ){
			      $this->aDados[] = $oDadosPRO;
	        }  
	    }
	   //echo "<pre>";
	   //print_r($this->aDados);
  }
  
  public function setCodigoPespectiva($iCodigoPespectiva) {
    $this->iCodigoPespectiva = $iCodigoPespectiva;
  }
  
  public function getCodigoPespectiva() {
    return $this->iCodigoPespectiva;
  }
}