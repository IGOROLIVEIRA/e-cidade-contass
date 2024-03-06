<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * selecionar dados de Despesas do Orcamento Sicom Instrumento de Planejamento
  * @package Contabilidade
  */
class SicomArquivoDespesaOrcamento extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
  protected $iCodigoLayout = 108;
  
  protected $sNomeArquivo = 'DSP';
  
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
    
    $aElementos[10] = array(
                          "tipoRegistro",
                          "codDespesa",
                          "codOrgao",
                          "codUnidadeSub",
                          "codFuncao",
                          "codSubFuncao",
                          "codPrograma",
                          "idAcao",
    											"idSubAcao",
                          "elementoDespesa",
                          "vlTotalrecurso"
                        );
    $aElementos[11] = array(
                          "tipoRegistro",
                          "codDespesa",
                          "codFontRecursos",
                          "valorFonte"
                        );
    return $aElementos;
  }
  
  public function gerarDados(){
    
  	$sSql  = "SELECT * FROM db_config ";
		$sSql .= "	WHERE prefeitura = 't'";
    	
    $rsInst = db_query($sSql);
    $sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;
  	
  	/**
		 * selecionar arquivo xml de dados elemento da despesa
		 */
		$sArquivo = "config/sicom/{$sCnpj}_sicomelementodespesa.xml";
		if (!file_exists($sArquivo)) {
		  throw new Exception("Arquivo de elemento da despesa inexistente!");
	 	}
		$sTextoXml    = file_get_contents($sArquivo);
		$oDOMDocument = new DOMDocument();
		$oDOMDocument->loadXML($sTextoXml);
		$oElementos = $oDOMDocument->getElementsByTagName('elemento');
    
    $sArquivo = "config/sicom/{$sCnpj}_sicomorgao.xml";
  	if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuraçao dos orgãos do sicom inexistente!");
    }
    
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oOrgaos      = $oDOMDocument->getElementsByTagName('orgao');
		
    foreach ($oOrgaos as $oOrgao) {
    	
	    $iAnousu = db_getsession('DB_anousu');
	    $sWhere  = "o58_anousu = $iAnousu";
	    $sWhere .= " AND o58_instit = {$oOrgao->getAttribute('instituicao')}";
	    $rsDotacao = db_dotacaosaldo(8, 2, 3, false, $sWhere, $iAnousu, $this->sDataInicial, $this->sDataFinal);
	  
	    //echo pg_num_rows($rsDotacao);exit;
	    //db_criatabela($rsDotacao);
	    $aDadosAgrupados = array();
	    
	    for ($iCont = 0; $iCont < pg_num_rows($rsDotacao); $iCont++) {
	    	  
	      $oRegistro =  db_utils::fieldsMemory($rsDotacao, $iCont);
				//print_r($oRegistro);echo "<br>$iCont<br>";exit;
	    	$iTipoProjetoAtividade = $oRegistro->o58_projativ;
	      
	    	$rsCodTriUnid = db_query("select o41_codtri from orcunidade where o41_unidade = ". $oRegistro->o58_unidade);
	    	$oCodTriUnid = db_utils::fieldsMemory($rsCodTriUnid, 0);
	    	
	      if($oCodTriUnid->o41_codtri == 0){
				   $unidade = $oRegistro->o58_unidade;
			  }else{
				   $unidade = $oCodTriUnid->o41_codtri;
			  }
			  
	    	$rsCodTriOrg = db_query("select o40_codtri from orcorgao where o40_orgao = ". $oRegistro->o58_orgao);
	    	$oCodTriOrg = db_utils::fieldsMemory($rsCodTriOrg, 0);
	    	
	      if($oCodTriOrg->o40_codtri == 0){
				   $org = $oRegistro->o58_orgao;
			  }else{
				   $org = $oCodTriOrg->o40_codtri;
			  }
			  
	      /**
	       * segundo o manual do sicom, a natureza da acao deve ser descrita como 9 em vez do numeral 0 para indicar
	       * operacoes especiais
	      */
	      if ($iTipoProjetoAtividade[0] == "0") {
	        $iTipoProjetoAtividade[0] = 9;
	      }
	      
	      $sElemento = substr($oRegistro->o56_elemento, 1, 8);
	      /**
	       * percorrer xml elemento despesa
	       */
	      foreach ($oElementos as $oElemento) {
	      	
	        if ($oElemento->getAttribute('instituicao') == db_getsession("DB_instit") 
					  && $oElemento->getAttribute('elementoEcidade') == $sElemento) {
								
	      	  $sElemento = $oElemento->getAttribute('elementoSicom'); 
	      	  break;	
	      	    
	      	 }
	      	
	       }
	      
	      $sHash  = $oOrgao->getAttribute('codOrgao').$oRegistro->o58_unidade.$oRegistro->o58_funcao.$oRegistro->o58_subfuncao;
	      $sHash .= $oRegistro->o58_programa.$iTipoProjetoAtividade.$oRegistro->o58_elemento;
	      
	      if (!isset($aDadosAgrupados[$sHash])) {
	        
	        /**
	         * Caso nï¿½o exista o indice, um objeto novo serï¿½ criado
	         */
	        $oDadosAcao = new stdClass();
	        
	        $oDadosAcao->codDespesa      = $oRegistro->o58_coddot.$oRegistro->o58_anousu; 
	        $oDadosAcao->tipoRegistro    = 10;
	        $oDadosAcao->detalhesessao   = 10;
	        $oDadosAcao->codOrgao        = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
	        $oDadosAcao->codUnidadeSub   = str_pad($org, 2, "0", STR_PAD_LEFT);
	        $oDadosAcao->codUnidadeSub  .= str_pad($unidade, 3, "0", STR_PAD_LEFT);
	        $oDadosAcao->codFuncao       = str_pad($oRegistro->o58_funcao, 2, "0", STR_PAD_LEFT);
	        $oDadosAcao->codSubFuncao    = str_pad($oRegistro->o58_subfuncao, 3, "0", STR_PAD_LEFT);
	        $oDadosAcao->codPrograma     = str_pad($oRegistro->o58_programa, 4, "0", STR_PAD_LEFT);
	        $oDadosAcao->idAcao          = str_pad($iTipoProjetoAtividade, 4, "0", STR_PAD_LEFT);
	        $oDadosAcao->idSubAcao       = " ";
	        $oDadosAcao->elementoDespesa = substr($sElemento, 0, 6);;
	        $oDadosAcao->vlTotalrecurso  = 0;
	        $oDadosAcao->recursos        = array();
	        
	        $aDadosAgrupados[$sHash] = $oDadosAcao;
	        
	        
	      } else {
	        /**
					 *caso jï¿½ exista esse indice no array, ele serï¿½ passado para o objeto
	         */
	        $oDadosAcao = $aDadosAgrupados[$sHash];
	      }
	      $sSqlCodigoRecurso  = "SELECT o15_codtri ";
	      $sSqlCodigoRecurso .= "  FROM orctiporec ";
	      $sSqlCodigoRecurso .= " WHERE o15_codigo = $oRegistro->o58_codigo";
	      $rsCodigoRecurso    = db_query($sSqlCodigoRecurso);
	      $sCodigoRecurso     = db_utils::fieldsMemory($rsCodigoRecurso, 0)->o15_codtri;  
	      
	      $oDadosAcaoRecurso = new stdClass();
	      $oDadosAcaoRecurso->codFontRecursos = str_pad($sCodigoRecurso, 3, "0", STR_PAD_LEFT);
	      $oDadosAcaoRecurso->valorFonte      = number_format($oRegistro->dot_ini, 2, "", "");
				
	      /**
	       * realiza o somatorio dos recursos relacionados com o registro 10 em questï¿½o
	       */
	      $oDadosAcao->vlTotalrecurso  += number_format($oRegistro->dot_ini, 2, "", "");
	      
	      /**
	       * passa cada registro 11 relacionado com o registro 10 selecionado
	       */
	      $oDadosAcao->recursos[] = $oDadosAcaoRecurso;
	    }
	    
	    
	    /**
	     * o repeditï¿½ï¿½o ocorrerï¿½ para cada linha do array $aDadosAgrupados passando a linha do registro 10 a ser gerada
	     */
	    foreach ($aDadosAgrupados as $oDado) {
	
	      $oDadosAcao = clone $oDado;
	      unset($oDadosAcao->recursos); 
	      $this->aDados[] = $oDadosAcao;
	      /**
	       * a repetiï¿½ï¿½o adicionarï¿½ os registros tipo 11 abaixo do registro tipo 10 correspondente para serem gravados no arquivo
	       */
	      foreach ($oDado->recursos as $oRecurso) {
	        
	        $oRecurso->tipoRegistro  = 11;
	        $oRecurso->detalhesessao = 11;
	        $oRecurso->codDespesa    = $oDadosAcao->codDespesa;
	        $this->aDados[]          = $oRecurso;
	      }
	    }
	    /**
	     * excluir tabela temporaria para a criacao da mesma com os dados da proxima instituicao
	     */
	    pg_exec("DROP TABLE work_dotacao");
    }
  }
  
  public function setCodigoPespectiva($iCodigoPespectiva) {
    $this->iCodigoPespectiva = $iCodigoPespectiva;
  }
  
  public function getCodigoPespectiva() {
    return $this->iCodigoPespectiva;
  }
}