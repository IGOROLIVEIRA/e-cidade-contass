<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * detalhamento das correcoes das receitas do mes Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoDetalhamentoCorrecoesReceitas extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 150;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'ARC';
  
  /**
   * 
   * Construtor da classe
   */
  public function __construct() {
    
  }
  
  /**
	 * Retorna o codigo do layout
	 *
	 * @return Integer
	 */
  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV 
   */
  public function getCampos(){
    
    $aElementos[10] = array(
	                          "tipoRegistro",
	                          "codOrgao",
	                          "identificadorDeducaoRecDeduzida",
	                          "rubricaDeduzida",
	                          "codFonteDeduzida",
	                          "especificacaoDeduzida",
	                          "identificadorDeducaoRecAcrescida",
	                          "rubricaAcrescida",
						    					  "codFonteAcrescida",
						    					  "especificacaoAcrescida",
						    					  "vlDeduzidoAcrescido"	
                        );
    $aElementos[20] = array(
	                          "tipoRegistro",
	                          "codOrgao",
	                          "identificadorDeducao",
	                          "rubricaEstornada",
							    					"codFonteEstornada",
							    					"especificacaoEstornada",
							    					"vlEstornado"
                        );
    return $aElementos;
  }
  
  /**
   * selecionar os dados de detalhamente das correcoes receitas do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
    
  	$sSql  = "SELECT * FROM db_config ";
	  $sSql .= "	WHERE prefeitura = 't'";
    	
	  $rsInst = db_query($sSql);
	  $sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;
	  
  	/**
  	 * selecionar arquivo xml com dados dos orgão
  	 */
    $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomorgao.xml";
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuração dos orgãos do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oOrgaos      = $oDOMDocument->getElementsByTagName('orgao');
    
    /**
     * percorrer os orgaos retornados do xml para selecionar o orgao da inst logada
     * para selecionar os dados da instit
     */
    foreach ($oOrgaos as $oOrgao) {
      
    	if($oOrgao->getAttribute('instituicao') == db_getsession("DB_instit")){
        $sOrgao     = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
    	}
    	
    }
    
    if (!isset($oOrgao)) {
      throw new Exception("Arquivo sem configuração de Orgãos.");
    }
    $sSql  = "SELECT c69_codlan, c69_valor, c69_data, c53_coddoc, o57_fonte,o57_descr, o15_codtri,c58_estrutural 
			 from conlancamval 
        	 join conlancamdoc on c69_codlan = c71_codlan
        	 join conhistdoc on c53_coddoc = c71_coddoc 
        	 join conlancamrec on c74_codlan = c69_codlan 
        	 join orcreceita on c74_anousu = o70_anousu and c74_codrec = o70_codrec 
        	 join orcfontes on o70_codfon = o57_codfon and o70_anousu = o57_anousu 
        	 join orctiporec on o70_codigo = o15_codigo 
        	 join concarpeculiar on o70_concarpeculiar = c58_sequencial 
	   	     where c53_coddoc = 101 and c69_data >= ".$this->sDataInicial." and c69_data <= ".$this->sDataFinal." 
			 group by c69_codlan , c69_valor, c69_data, c53_coddoc, c53_descr, c53_tipo, o57_fonte,o57_descr,o15_codtri,c58_estrutural 
	  	     order by c69_codlan";
    	
			 $rsDeta = db_query($sSql);
			 
			    /**
     		 * percorrer registros de detalhamento anulação retornados do sql acima
     		 */
			 
			 for ($iCont = 0;$iCont < pg_num_rows($rsDeta); $iCont++) {
		
		 	   $oDeta  = db_utils::fieldsMemory($rsDeta,$iCont);
    
    		   if (substr($oDeta->o57_fonte, 0, 0) != 9) {
		 	   
			       $oDadosDeta = new stdClass();
			 	   
	    		   $oDadosDeta->tipoRegistro  =    20;   
	    		   $oDadosDeta->detalhesessao =    20;
	           $oDadosDeta->codOrgao  =    $sOrgao;
	             
	           if ( substr($oDeta->c58_estrutural, 0, 0) == 9 ) {
	             $oDadosDeta->identificadorDeducao  =    substr($oDeta->c58_estrutural, -2);
	           }else{  	
	             $oDadosDeta->identificadorDeducao  =    " ";	
	           } 
	    		   $oDadosDeta->rubricaEstornada				=    substr($oDeta->o57_fonte, 1, 7);
	    		   $oDadosDeta->codFonteEstornada				=    str_pad($oDeta->o15_codtri, 3, "0", STR_PAD_LEFT);
	    		   $oDadosDeta->especificacaoEstornada	=    substr($oDeta->o57_descr, 0, 100);
	    		   $oDadosDeta->vlEstornado						  =    number_format($oDeta->c69_valor, 2, "", "");
	    			
	    		   $this->aDados[] = $oDadosDeta;
	    		   
    		   }
    		   
			 }
  
    }
		
  }