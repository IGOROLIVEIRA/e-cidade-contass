<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

class SicomArquivoAcoesMetasPPA extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
  protected $iCodigoLayout = 141;
  
  protected $sNomeArquivo = 'AMP';
  
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
                          "possuiSubAcao",
                          "codAcao",
                          "codOrgao",
                          "codUnidadeSub",
                          "codFuncao",
                          "codSubFuncao",
    											"codPrograma",
    											"idAcao",
    											"descAcao",
    											"finalidadeAcao",
    											"produto",
    											"unidadeMedida",
    											"metas1ano",
    											"metas2ano",
    											"metas3ano",
    											"metas4ano",
    											"recursos1Ano",
    											"recursos2Ano",
    											"recursos3Ano",
    											"recursos4Ano"
                        );
                        
    $aElementos[11]  = array(
                          "tipoRegistro",
                          "codAcao",
                          "codSubAcao",
                          "descSubAcao",
                          "finalidadeSubAcao",
                          "produtoSubAcao",
                          "unidadeMedida",
    											"metas1ano",
    											"metas2ano",
    											"metas3ano",
    											"metas4ano",
    											"recursos1Ano",
    											"recursos2Ano",
    											"recursos3Ano",
    											"recursos4Ano",
    );
    return $aElementos;
  }
  
  public function gerarDados(){
    require_once ("model/ppaVersao.model.php");
    require_once ("model/ppadespesa.model.php");
    
    $oPPAVersao  = new ppaVersao($this->getCodigoPespectiva());
    $oPPADespesa = new ppaDespesa($this->getCodigoPespectiva());
    
    $sSql  = "SELECT * FROM db_config ";
		$sSql .= "	WHERE prefeitura = 't'";
    	
    $rsInst = db_query($sSql);
    $sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;
    
  	$sArquivo = "config/sicom/{$sCnpj}sicomorgao.xml";
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
    	$sSqlInstit .= "WHERE o08_instit = {$oOrgao->getAttribute("instituicao")}";
    	$rsInstit    = db_query($sSqlInstit);
    	//$iInstit     = pg_num_rows($rsInstit);
     	//if ($rsInstit) {
     		$aOrgaosXml[] = $oOrgao;
    		$aOrgao[]     = $oOrgao->getAttribute("instituicao");
    	//}
    }
    //echo $aOrgaosXml['1']->getAttribute("instituicao");exit;
    		// Lista das instituições selecionadas
		$sListaInstit = implode(",",$aOrgao);
      
	    $sSqlMetasPPA  = "SELECT * FROM orcprojativ p ";
	    $sSqlMetasPPA .= "JOIN ppadotacao d ";
	    $sSqlMetasPPA .= "ON p.o55_anousu = d.o08_ano AND p.o55_projativ = d.o08_projativ ";
	    $sSqlMetasPPA .= "JOIN orcproduto pr ";
	    $sSqlMetasPPA .= "ON p.o55_orcproduto = pr.o22_codproduto ";
	    //$sSqlMetasPPA .= "WHERE p.o55_instit = {$oOrgao->getAttribute('instituicao')}";
	    //$sSqlMetasPPA .= "WHERE p.o55_anousu between {$oPPAVersao->getAnoinicio()} AND {$oPPAVersao->getAnofim()}";
	    $sSqlMetasPPA .= "WHERE p.o55_anousu = ".db_getsession('DB_anousu')." AND o08_ppaversao = {$this->iCodigoPespectiva}";
	    
	    $rsMetasPPA = db_query($sSqlMetasPPA);
	    //echo pg_num_rows($rsMetasPPA);exit;
	    //db_criatabela($rsMetasPPA);
	    
	    /**
	     * pegar estimativas por programa Acao/Projativ
	     */
	    $oPPADespesa->setInstituicoes($sListaInstit);
	    $aDespesa = $oPPADespesa->getQuadroEstimativas(null, 6);
	    //print_r($aDespesa);
	    
	    for ($iCont = 0; $iCont < pg_num_rows($rsMetasPPA); $iCont++) {
	      
	      $oMetasPPA =  db_utils::fieldsMemory($rsMetasPPA, $iCont);
	      
	      foreach ($aOrgaosXml as $oOrgaoXml){
	      	if($oOrgaoXml->getAttribute("instituicao") == $oMetasPPA->o08_instit){
	      		$sOrgao = $oOrgaoXml->getAttribute("codOrgao");
	      	}	
	      }
	      
	      $rsCodTri = db_query("select o41_codtri from orcunidade where o41_unidade =". $oMetasPPA->o08_unidade);
	    	
	    	$oCodTri = db_utils::fieldsMemory($rsCodTri, 0);
	    	
	      if($oCodTri == 0) {
				  $unidade = $oMetasPPA->o08_unidade;
			  }else {
				  $unidade = $oCodTri;
			  }
			  
			  
	    	$rsCodTriUnid = db_query("select o41_codtri from orcunidade where o41_unidade = ". $oMetasPPA->o08_unidade);
	    	$oCodTriUnid = db_utils::fieldsMemory($rsCodTriUnid, 0);
	    	
	      if($oCodTriUnid->o41_codtri == 0){
				   $unidade = $oMetasPPA->o08_unidade;
			  }else{
				   $unidade = $oCodTriUnid->o41_codtri;
			  }
			  
	    	$rsCodTriOrg = db_query("select o40_codtri from orcorgao where o40_orgao = ". $oMetasPPA->o08_orgao);
	    	$oCodTriOrg = db_utils::fieldsMemory($rsCodTriOrg, 0);
	    	
	      if($oCodTriOrg->o40_codtri == 0){
				   $org = $oMetasPPA->o08_orgao;
			  }else{
				   $org = $oCodTriOrg->o40_codtri;
			  }
	    
	    	$oDadosAMP = new stdClass();
	      
		    $oDadosAMP->tipoRegistro       = 10;
		    $oDadosAMP->detalhesessao      = 10;
		    $oDadosAMP->possuiSubAcao      = 2;
		    $oDadosAMP->codAcao            = substr($oMetasPPA->o55_projativ, 0, 15);
		    $oDadosAMP->codOrgao           = str_pad($sOrgao, 2, "0", STR_PAD_LEFT);
		    $oDadosAMP->codUnidadeSub      = str_pad($org, 2, "0", STR_PAD_LEFT);
		    $oDadosAMP->codUnidadeSub     .= str_pad($unidade, 3, "0", STR_PAD_LEFT);
		    $oDadosAMP->codFuncao          = str_pad($oMetasPPA->o08_funcao, 2, "0", STR_PAD_LEFT);
		    $oDadosAMP->codSubFuncao       = str_pad($oMetasPPA->o08_subfuncao, 3, "0", STR_PAD_LEFT);
		    $oDadosAMP->codPrograma        = str_pad($oMetasPPA->o08_programa, 4, "0", STR_PAD_LEFT);
		    $oDadosAMP->idAcao             = str_pad($oMetasPPA->o55_projativ, 4, "0", STR_PAD_LEFT);
		    $oDadosAMP->descAcao           = substr($oMetasPPA->o55_descr, 0, 100);
		    $oDadosAMP->finalidadeAcao     = substr($oMetasPPA->o55_finali, 0, 230);
		    $oDadosAMP->produto            = substr($oMetasPPA->o22_descrprod, 0, 50);
		    $oDadosAMP->unidadeMedida      = substr($oMetasPPA->o55_descrunidade , 0, 15);
		    $oDadosAMP->metas1ano          = number_format($oMetasPPA->o55_valorunidade, 2, "", "");
		    $oDadosAMP->metas2ano          = number_format($oMetasPPA->o55_valorunidade, 2, "", "");
		    $oDadosAMP->metas3ano          = number_format($oMetasPPA->o55_valorunidade, 2, "", "");
		    $oDadosAMP->metas4ano          = number_format($oMetasPPA->o55_valorunidade, 2, "", "");
		    
		    
		    foreach ($aDespesa as $sEstimativa) {
				    	//print_r($sEstimativa);
				    	if($sEstimativa->iCodigo == $oMetasPPA->o55_projativ){
				    		
				    		$iNum = 1;
				    		foreach ($sEstimativa->aEstimativas as $nValorAno){
				    			
				    			$sRecurso = "recursos".$iNum."Ano";
			    				$oDadosAMP->$sRecurso    = number_format($nValorAno,2,"","");
			    				$iNum++;
				    		}
				    	}
			    }
		
		    $this->aDados[] = $oDadosAMP;
	    }
	   
  }
  
  public function setCodigoPespectiva($iCodigoPespectiva) {
    $this->iCodigoPespectiva = $iCodigoPespectiva;
  }
  
  public function getCodigoPespectiva() {
    return $this->iCodigoPespectiva;
  }
}