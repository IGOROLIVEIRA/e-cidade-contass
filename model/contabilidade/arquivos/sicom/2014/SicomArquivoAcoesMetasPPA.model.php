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
    											"idAcao",
    											"descAcao",
    											"finalidadeAcao",
    											"produto",
    											"unidadeMedida",    											
                        );
                        
    $aElementos[11]  = array(
                          "tipoRegistro",
                          "idAcao",
                          "idSubAcao",
                          "descSubAcao",
                          "finalidadeSubAcao",
                          "produtoSubAcao",
                          "unidadeMedida",
    											
    );
    $aElementos[12]  = array(
                          "tipoRegistro",
                          "codOrgao",
                          "codUnidadeSub",
                          "codFuncao",
                          "codSubFuncao",
                          "codPrograma",
                          "idAcao",
                          "idSubAcao",
                          "metas1Ano",
                          "metas2Ano",
                          "metas3Ano",
                          "metas4Ano",
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
    
  	$sSqlInstit  = "SELECT codigo FROM db_config ";
    $rsInstit    = db_query($sSqlInstit);
    
    
    // Lista das institui��es 
    for ($iCont = 0; $iCont < pg_num_rows($rsInstit); $iCont++) {
        
        $oReceita =  db_utils::fieldsMemory($rsInstit, $iCont);
        $sListaInstit[] = $oReceita->codigo;
    }
    
    // Lista das institui��es selecionadas
		$sListaInstit = implode(",",$sListaInstit);

      
      $sSqlMetasPPA  = "SELECT d.o08_funcao,d.o08_subfuncao,d.o08_programa,p.o55_projativ,p.o55_descr,p.o55_finali, ";
      $sSqlMetasPPA .= " pr.o22_descrprod,p.o55_descrunidade,p.o55_valorunidade, d.o08_orgao, d.o08_unidade,si09_codorgaotce,p.o55_valorunidade ";
      $sSqlMetasPPA .= " FROM orcprojativ p ";
      $sSqlMetasPPA .= " JOIN ppadotacao d ON p.o55_anousu = d.o08_ano AND p.o55_projativ = d.o08_projativ ";
      $sSqlMetasPPA .= " JOIN orcproduto pr ON p.o55_orcproduto = pr.o22_codproduto ";
      $sSqlMetasPPA .= " left join db_config on o08_instit = codigo left join infocomplementaresinstit on codigo = si09_instit ";
      $sSqlMetasPPA .= "WHERE p.o55_anousu = ".db_getsession('DB_anousu')." AND o08_ppaversao = {$this->iCodigoPespectiva} ";
      $sSqlMetasPPA .= "GROUP BY d.o08_funcao,d.o08_subfuncao,d.o08_programa,p.o55_projativ,p.o55_descr,p.o55_finali,";
      $sSqlMetasPPA .= " pr.o22_descrprod,p.o55_descrunidade,p.o55_valorunidade,d.o08_orgao, d.o08_unidade,si09_codorgaotce,p.o55_valorunidade";
	    
        //echo $sSqlMetasPPA;exit;
	    $rsMetasPPA = db_query($sSqlMetasPPA);
	    //db_criatabela($rsMetasPPA);
	    
	    
	    
	    
	    $sSqlMetasFisica =" select * from orcprojativprogramfisica order by o28_orcprojativ, o28_anoref";
	    $rsMetasFisica = db_query($sSqlMetasFisica);
	    /**
	     * pegar estimativas por programa Acao/Projativ
	     */
	    $oPPADespesa->setInstituicoes($sListaInstit);
	    $aDespesa = $oPPADespesa->getQuadroEstimativas(null, 6);
	    
	    $aDadosAgrupados = array();
	    for ($iCont = 0; $iCont < pg_num_rows($rsMetasPPA); $iCont++) {
	      
	      $oMetasPPA =  db_utils::fieldsMemory($rsMetasPPA, $iCont);
	      
	      $sHash  = $oMetasPPA->o55_projativ;
	      
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
	    if (!isset($aDadosAgrupados[$sHash])) {
	        $oDadosAMP = new stdClass();
	        
	        $oDadosAMP->tipoRegistro       = 10;
	        $oDadosAMP->detalhesessao      = 10;
	        $oDadosAMP->possuiSubAcao      = 2;
	        $oDadosAMP->idAcao             = str_pad($oMetasPPA->o55_projativ, 4, "0", STR_PAD_LEFT);
	        $oDadosAMP->descAcao           = substr($oMetasPPA->o55_descr, 0, 100);
	        $oDadosAMP->finalidadeAcao     = substr($oMetasPPA->o55_finali, 0, 230);
	        $oDadosAMP->produto            = substr($oMetasPPA->o22_descrprod, 0, 50);
	        $oDadosAMP->unidadeMedida      = ($oMetasPPA->o55_descrunidade != '')?substr($oMetasPPA->o55_descrunidade , 0, 15):"unidade";
	        $oDadosAMP->Reg12             = array();
	        $aDadosAgrupados[$sHash] = $oDadosAMP;
	    }
        	
	    	$oDadosAMP12 = new stdClass();
	      
		    $oDadosAMP12->tipoRegistro       = 12;
		    $oDadosAMP12->detalhesessao      = 12;
		    $oDadosAMP12->codOrgao           = str_pad($oMetasPPA->si09_codorgaotce, 2, "0", STR_PAD_LEFT);
		    $oDadosAMP12->codUnidadeSub      = str_pad($org, 2, "0", STR_PAD_LEFT);
		    $oDadosAMP12->codUnidadeSub     .= str_pad($unidade, 3, "0", STR_PAD_LEFT);
		    $oDadosAMP12->codFuncao          = str_pad($oMetasPPA->o08_funcao, 2, "0", STR_PAD_LEFT);
		    $oDadosAMP12->codSubFuncao       = str_pad($oMetasPPA->o08_subfuncao, 3, "0", STR_PAD_LEFT);
		    $oDadosAMP12->codPrograma        = str_pad($oMetasPPA->o08_programa, 4, "0", STR_PAD_LEFT);
		    $oDadosAMP12->idAcao             = str_pad($oMetasPPA->o55_projativ, 4, "0", STR_PAD_LEFT);
            $oDadosAMP12->idSubAcao          = " ";
		    $oDadosAMP12->descAcao           = substr($oMetasPPA->o55_descr, 0, 100);
		    $oDadosAMP12->finalidadeAcao     = substr($oMetasPPA->o55_finali, 0, 230);
		    $oDadosAMP12->produto            = substr($oMetasPPA->o22_descrprod, 0, 50);
		    $oDadosAMP12->unidadeMedida      = substr($oMetasPPA->o55_descrunidade , 0, 15);
		    
		    
		    $oDadosAMP12->metas1Ano = "1,00";
		    $oDadosAMP12->metas2Ano = "1,00";
		    $oDadosAMP12->metas3Ano = "1,00";
		    $oDadosAMP12->metas4Ano = "1,00";
		  
		    for ($iConta = 0; $iConta < pg_num_rows($rsMetasFisica); $iConta++) {
	      
	            $oMetasFisica =  db_utils::fieldsMemory($rsMetasFisica, $iConta);
		    
		        if($oMetasPPA->o55_projativ == $oMetasFisica->o28_orcprojativ ){
		        
		        	if($oMetasFisica->o28_anoref == db_getsession("DB_anousu")){
		        		$oDadosAMP12->metas1Ano          = number_format($oMetasFisica->o28_valor, 2, ",", "");
		        		
		        		continue;
		        	}
			        if($oMetasFisica->o28_anoref == db_getsession("DB_anousu")+1){
			            $oDadosAMP12->metas2Ano          = number_format($oMetasFisica->o28_valor, 2, ",", "");
			            continue;
			        		
			        }
			        if($oMetasFisica->o28_anoref == db_getsession("DB_anousu")+2){
			        		$oDadosAMP12->metas3Ano          = number_format($oMetasFisica->o28_valor, 2, ",", "");
			        		continue;
			        	}
			        if($oMetasFisica->o28_anoref == db_getsession("DB_anousu")+3){
			        		$oDadosAMP12->metas4Ano          = number_format($oMetasFisica->o28_valor, 2, ",", "");
			        		continue;
			        		
			        }
		        	
		        }
		        
			    
		    }	 
		   /* echo "<pre>";
		    print_r($aDespesa);*/
		    foreach ($aDespesa as $sEstimativa) {
              			
				    	if($sEstimativa->iCodigo == $oMetasPPA->o55_projativ){
				    		
				    		$iNum = 1;
				    		foreach ($sEstimativa->aEstimativas as $nValorAno){
					    		if($nValorAno == ''){
				                  $nValorAno = 0;
				                }
				    			$sRecurso = "recursos".$iNum."Ano";
			    				$oDadosAMP12->$sRecurso    = number_format($nValorAno,2,",","");
			    				$iNum++;
				    		}
				    	}
			    }
			    
		    if( $oDadosAMP12->recursos1Ano > 0 
	            && $oDadosAMP12->recursos2Ano > 0 
	            && $oDadosAMP12->recursos3Ano > 0
	            && $oDadosAMP12->recursos4Ano > 0
	          ){
			      $aDadosAgrupados[$sHash]->Reg12[] = $oDadosAMP12;
	        }
		
		    
	    }
	    foreach ($aDadosAgrupados as $oDado){
	    	$oDados10 = clone $oDado;
	        unset($oDados10->Reg12); 
	    	$this->aDados[] = $oDados10;
	    	foreach ($oDado->Reg12 as $oDados12) {
	    		$this->aDados[] = $oDados12;
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