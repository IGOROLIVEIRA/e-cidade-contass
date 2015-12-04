<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
/**
 * 
 * selecionar dados de Receita Orcamentaria Sicom Instrumento de Planejamento
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoReceitaOrcamentariaOrgao extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * Código do layout. (db_layouttxt.db50_codigo)
	 *
	 * @var Integer
	 */
  protected $iCodigoLayout = 142;

  /**
	 * Nome do arquivo a ser criado
	 *
	 * @var String
	 */
  protected $sNomeArquivo = 'REC';
  
  /**
	 * Código da Pespectiva. (ppaversao.o119_sequencial)
	 *
	 * @var Integer
	 */
  protected $iCodigoPespectiva;
  
  /**
   * 
   * Construtor da classe
   */
  public function __construct() {
    
  }
  
  /**
   * retornar o codio do layout
   * 
   *@return Integer
   */
  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV 
   *
   *@return Array
   */
  public function getCampos(){
    
    $aElementos[10] = array(
                          "tipoRegistro",
    											"codReceita",
                          "codOrgao",
    											"identificadorDeducao",
    											"rubrica",
    											"especificacao",
    											"vlPrevisto"
                        );
    $aElementos[11] = array(
                          "tipoRegistro",
    											"codReceita",
    											"codFonte",
    											"valorFonte"
                        );
    return $aElementos;
  }
  
  /**
   * Gerar os dados necessários para o arquivo
   *
   */
  public function gerarDados(){
  	
  $sArquivo = "config/sicom/sicomorgao.xml";
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuração dos orgãos do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oOrgaos      = $oDOMDocument->getElementsByTagName('orgao');
    
    /**
     * Realizar a seleção dos dados de receitas de cada orgao retornado
     */
    foreach ($oOrgaos as $oOrgao) {
      
      $sSqlReceita  = "SELECT * FROM orcfontes f ";
	    $sSqlReceita .= "JOIN orcreceita r ON f.o57_codfon = r.o70_codfon ";
	    $sSqlReceita .= "AND f.o57_anousu = o70_anousu "; 
	    $sSqlReceita .= "JOIN orctiporec t "; 
	    $sSqlReceita .= "ON r.o70_codigo = t.o15_codigo "; 
	    $sSqlReceita .= "WHERE f.o57_anousu = ".db_getsession("DB_anousu"); 
	    $sSqlReceita .= " AND r.o70_instit = {$oOrgao->getAttribute('instituicao')}";
	    
	    $rsReceita = db_query($sSqlReceita);
	    
	    $aDadosAgrupados = array();
	    
	   /**
  	  * selecionar arquivo xml com dados das receitas do TCE
  	  */
      $sArquivo = "config/sicom/".db_getsession("DB_anousu")."_codrecanosessao.xml";
      if (!file_exists($sArquivo)) {
        throw new Exception("Arquivo de configuração das receitas do sicom inexistente!");
      }
	    $sTextoXml    = file_get_contents($sArquivo);
	    $oDOMDocument = new DOMDocument();
	    $oDOMDocument->loadXML($sTextoXml);
	    $oCodReceitasTce = $oDOMDocument->getElementsByTagName('receita');
    
      /**
  	   * selecionar arquivo xml com dados das receitas para substituicao
  	   */
      $sArquivo = "config/sicom/{$sCnpj}_sicomnaturezareceita.xml";
      if (!file_exists($sArquivo)) {
        throw new Exception("Arquivo de configuração de natureza das receitas do sicom inexistente!");
      }
      $sTextoXml    = file_get_contents($sArquivo);
      $oDOMDocument = new DOMDocument();
      $oDOMDocument->loadXML($sTextoXml);
      $oCodReceitasSub = $oDOMDocument->getElementsByTagName('receita');
	    
	    /**
       * array para armazenar as receitas invalidas para o sicom
       */
      $aCodReceita = array();
	    /**
	     * passar dados para os objetos de dados dos registros 10 e 11 do arquivo
	     */
	    for ($iCont = 0; $iCont < pg_num_rows($rsReceita); $iCont++) {
	      
	      $oReceita =  db_utils::fieldsMemory($rsReceita, $iCont);
	      
	      $sVerificaReceita = 0;
	      $iCodRubrica = substr($oReceita->o57_fonte, 1, 8);
	      if ($oReceita->o70_codrec != 0) {
	    	
	    	/**
	    	 * percorrer xml de codreceitas do TCE/MG
	    	 */
	      foreach ($oCodReceitasTce as $oCodReceita) {
	      
	    	  if (str_replace(".","", $oCodReceita->getAttribute('codigo')) == substr($oReceita->o57_fonte, 1, 8)) {
	          
	    	  	if ($oCodReceita->getAttribute('tipo') == 1) {
	    	  		$sVerificaReceita = 1;
	    	  	} else {
	    	  		
	    	  		/**
	    	  		 * percorrer xml de codreceitas do e-cidade para o TCE/MG
	    	  		 */
	    	  		foreach ($oCodReceitasSub as $oCodReceitaSub) {
	    	  			
	    	  			if ($oCodReceitaSub->getAttribute('receitaEcidade') == substr($oReceita->o57_fonte, 1, 8)) {
	    	  				
	    	  				$iCodRubrica = $oCodReceitaSub->getAttribute('receitaSicom');
	                $sVerificaReceita = 1;
	    	  				break;
	                
	    	  			}
	    	  			
	    	  		}
	    	  		
	    	  	}
	    	  	break;
	          
	    	  }
	    	
	      }
	      
	      if ($sVerificaReceita == 0 && $oReceita->o70_codrec != 0) {
		     /**
		    	* percorrer xml de codreceitas do e-cidade para o TCE/MG
		    	*/
		      foreach ($oCodReceitasSub as $oCodReceitaSub) {
		    	  			
		    	  if ($oCodReceitaSub->getAttribute('receitaEcidade') == substr($oReceita->o57_fonte, 1, 8)) {
		    	  		
		    	  	$iCodRubrica = $oCodReceitaSub->getAttribute('receitaSicom');
		          $sVerificaReceita = 1;
		    	    break;
		                
		    	  }
		    	  			
		    	}
	    	
	      }
	      
	      }
        
      if ($sVerificaReceita == 0 && $oReceita->o70_codrec != 0) {
      	
      	if (!isset($aCodReceita[substr($oReceita->o57_fonte, 1, 8)])) {
      	  $aCodReceita[substr($oReceita->o57_fonte, 1, 8)] = substr($oReceita->o57_fonte, 1, 8);
      	}
      	
      }
      
      if (count($aCodReceita) == 10) {
      	throw new Exception("Códigos ".implode(",", $aCodReceita)." da receita inexistente no siscom. Deve ser incluído um codigo de receita correspondente.");
      }

      
      if ($oReceita->o70_codrec != 0 && $sVerificaReceita == 1) {
      	
	    	$iIdentDeducao = "";
	    	
	    	/**
	    	 * o primeiro digito 9 identifica o identificador deducao do sicom no campo especificado
	    	 */
	      if($oReceita->o70_concarpeculiar[1] == 9){
	      	$iIdentDeducao = $oReceita->o70_concarpeculiar[1].$oReceita->o70_concarpeculiar[2];	
	      }else{
	      	$iIdentDeducao = " ";
	      }
	      
	      if($oReceita->o57_fonte[1] == 5){
	      	$oReceita->o57_fonte[1] = 1; 
	      }
	    	
	      $sHash = "10".$oOrgao->getAttribute('codOrgao').$iIdentDeducao.$iCodRubrica;
	      
	      if (!isset($aDadosAgrupados[$sHash])) {
	      	
	       /**
	    	  * percorrer xml de codreceitas do TCE/MG
	    	  */
	        foreach ($oCodReceitasTce as $oCodReceita) {
	      
	    	    if (str_replace(".","", $oCodReceita->getAttribute('codigo')) == $iCodRubrica) {
	    	    	$sEspecificacaoRec = iconv('UTF-8','ISO-8859-1', substr($oCodReceita->getAttribute('descricao'), 0, 100));
	    	    	break;
	    	    }
	    	    
	        }
	      	
	      	$oDadosReceita = new stdClass();
	        $oDadosReceita->tipoRegistro          = 10;
	        $oDadosReceita->detalhesessao         = 10;
	        $oDadosReceita->codReceita            = substr($oReceita->o57_codfon, 0, 15);
	        $oDadosReceita->codOrgao              = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
	        $oDadosReceita->identificadorDeducao  = $iIdentDeducao;
	        $oDadosReceita->rubrica               = $iCodRubrica;
	        $oDadosReceita->especificacao         = $sEspecificacaoRec;
	        $oDadosReceita->vlPrevisto            = 0;
	        $oDadosReceita->FonteRecurso          = array();
	        
	        $aDadosAgrupados[$sHash] = $oDadosReceita;
	                
	      } else {
	      	$oDadosReceita = $aDadosAgrupados[$sHash];
	      }
	      
	      $oDadosFonteRecurso = new stdClass();
	      $oDadosFonteRecurso->tipoRegistro  = 11;
	      $oDadosFonteRecurso->detalhesessao = 11;
	    	$oDadosFonteRecurso->codReceita    = $oDadosReceita->codReceita;
	      $oDadosFonteRecurso->codFonte      = str_pad($oReceita->o15_codtri, 3, "0", STR_PAD_LEFT);
	    
	      $oDadosFonteRecurso->valorFonte    = number_format(abs($oReceita->o70_valor), 2, "", "");
	      
	      $oDadosReceita->vlPrevisto     += number_format($oReceita->o70_valor, 2, "", "");
	      $oDadosReceita->FonteRecurso[]  = $oDadosFonteRecurso;
	       
	      
	      }
	      
	    }
			
	    /**
	     * passar todos os dados registro 10 para o $this->aDados[]
	     */
	    foreach ($aDadosAgrupados as $oDado) {
	    	
	    	$oDadosReceita = clone $oDado;
	    	unset($oDadosReceita->FonteRecurso);
	    	$this->aDados[] = $oDadosReceita;
	    	
	    /**
	     * passar todos os dados registro 11 para o $this->aDados[]
	     */
	    	foreach ($oDado->FonteRecurso as $oFonteRecurso) {
	    		$this->aDados[] = $oFonteRecurso;
	    	}
	    	
	    }
	    
    }
  }
  
  /**
   * 
   * passar valor para o $this->iCodigoPespectiva
   * @param Integer $iCodigoPespectiva
   */
  public function setCodigoPespectiva($iCodigoPespectiva) {
    $this->iCodigoPespectiva = $iCodigoPespectiva;
  }
  
  /**
   * 
   * retornar o valor do $this->iCodigoPespectiva
   * @return Integer
   */
  public function getCodigoPespectiva() {
    return $this->iCodigoPespectiva;
  }
}