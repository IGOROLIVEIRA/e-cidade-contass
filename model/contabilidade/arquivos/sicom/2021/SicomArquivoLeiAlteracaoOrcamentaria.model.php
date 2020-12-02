<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_lao10$PROXIMO_ANO_classe.php");
require_once ("classes/db_lao11$PROXIMO_ANO_classe.php");
require_once ("classes/db_lao20$PROXIMO_ANO_classe.php");
require_once ("classes/db_lao21$PROXIMO_ANO_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarLAO.model.php");

 /**
  * selecionar dados de Leis de Alteração Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoLeiAlteracaoOrcamentaria extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
  /**
   * 
   * Codigo do layout
   * @var Integer
   */
  protected $iCodigoLayout = 151;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var unknown_type
   */
  protected $sNomeArquivo = 'LAO';
  
  /* 
   * Contrutor da classe
   */
  public function __construct() {
    
  }
  
  /**
   * retornar o codigo do layout
   * 
   *@return Integer
   */
  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   *@return Array 
   */
  public function getCampos(){
    
    $aElementos[10] = array(
                          "tipoRegistro",
                          "codOrgao",
                          "tipoLeiAlteracao",
                          "nroLeiAlteracao",
                          "dataLeiAlteracao",
                          "artigoLeiAlteracao",
                          "descricaoArtigo",
                          "vlAutorizadoAlteracao"
                        );
    $aElementos[20] = array(
                          "tipoRegistro",
                          "codOrgao",
                          "nroLeiAlterOrcam",
                          "dataLeiAlterOrcam",
    											"artigoLeiAlterOrcamento",
    											"descricaoArtigo",
    											"novoPercentual"
                        );
    $aElementos[30] = array(
                          "tipoRegistro",
                          "tipoDecretoAlteracao",
                          "nroDecreto",
                          "dataDecreto",
    											"nroLeiAlteracao",
    											"dataLeiAlteracao",
    											"valorAberto",
    											"origemRecAlteracao"
                       );
    return $aElementos;
  }
  
  /**
   * selecionar os dados de Leis de Alteração
   * 
   */
  public function gerarDados() {

  	
  	$cllao10$PROXIMO_ANO = new cl_lao10$PROXIMO_ANO();
  	$cllao11$PROXIMO_ANO = new cl_lao11$PROXIMO_ANO();
  	$cllao20$PROXIMO_ANO = new cl_lao20$PROXIMO_ANO();
  	$cllao21$PROXIMO_ANO = new cl_lao21$PROXIMO_ANO();
  	
  	db_inicio_transacao();
  	
    /*
     * excluir informacoes do mes selecionado registro 21
     */
    $result = $cllao21$PROXIMO_ANO->sql_record($cllao21$PROXIMO_ANO->sql_query(NULL,"*",NULL,"si37_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si37_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$cllao21$PROXIMO_ANO->excluir(NULL,"si37_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si37_instit = ".db_getsession("DB_instit"));
      if ($cllao21$PROXIMO_ANO->erro_status == 0) {
    	  throw new Exception($cllao21$PROXIMO_ANO->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 11
     */
    $result = $cllao11$PROXIMO_ANO->sql_record($cllao11$PROXIMO_ANO->sql_query(NULL,"*",NULL,"si35_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si35_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {	
    	$cllao11$PROXIMO_ANO->excluir(NULL,"si35_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si35_instit = ".db_getsession("DB_instit"));
      if ($cllao11$PROXIMO_ANO->erro_status == 0) {
    	  throw new Exception($cllao11$PROXIMO_ANO->erro_msg);
      }
    }
    
    /*
  	 * excluir informacoes do mes selecionado registro 10
  	 */
    $result = $cllao10$PROXIMO_ANO->sql_record($cllao10$PROXIMO_ANO->sql_query(NULL,"*",NULL,"si34_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si34_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$cllao10$PROXIMO_ANO->excluir(NULL,"si34_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si34_instit = ".db_getsession("DB_instit"));
      if ($cllao10$PROXIMO_ANO->erro_status == 0) {
    	  throw new Exception($cllao10$PROXIMO_ANO->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = $cllao20$PROXIMO_ANO->sql_record($cllao20$PROXIMO_ANO->sql_query(NULL,"*",NULL,"si36_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si36_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$cllao20$PROXIMO_ANO->excluir(NULL,"si36_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si36_instit = ".db_getsession("DB_instit"));
      if ($cllao20$PROXIMO_ANO->erro_status == 0) {
    	  throw new Exception($cllao20$PROXIMO_ANO->erro_msg);
      }
    }
  	
		$sSql  = "SELECT si09_codorgaotce AS codorgao
              FROM infocomplementaresinstit
              WHERE si09_instit = ".db_getsession("DB_instit");
    	
    $rsResult  = db_query($sSql);
    $sCodorgao = db_utils::fieldsMemory($rsResult, 0)->codorgao;
    
    /*
     * selecionar informacoes registro 10
     */
    $sSql     = "select * from orcprojetolei where o138_altpercsuplementacao = 2 and o138_data >= '{$this->sDataInicial}' and o138_data <= '{$this->sDataFinal}'";
    $rsResult10 = db_query($sSql);
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
    	
    	$cllao10$PROXIMO_ANO = new cl_lao10$PROXIMO_ANO();
    	$oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
    	
    	$cllao10$PROXIMO_ANO->si34_tiporegistro     = 10;
    	$cllao10$PROXIMO_ANO->si34_codorgao         = $sCodorgao;
    	$cllao10$PROXIMO_ANO->si34_nroleialteracao  = $oDados10->o138_numerolei;
    	$cllao10$PROXIMO_ANO->si34_dataleialteracao = $oDados10->o138_data;
    	$cllao10$PROXIMO_ANO->si34_mes              = $this->sDataFinal['5'].$this->sDataFinal['6'];
    	$cllao10$PROXIMO_ANO->si34_instit           = db_getsession("DB_instit");
    	
    	$cllao10$PROXIMO_ANO->incluir(null);
    	if ($cllao10$PROXIMO_ANO->erro_status == 0) {
    		throw new Exception($cllao10$PROXIMO_ANO->erro_msg);
    	}
    	
    	/*
    	 * selecionar informacoes registro 11
    	 */
    	$sSql = "select * from orcleialtorcamentaria where o200_orcprojetolei = {$oDados10->o138_sequencial}";
    	$rsResult11 = db_query($sSql);
    	for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {
    		
    		$cllao11$PROXIMO_ANO = new cl_lao11$PROXIMO_ANO();
    		$oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);
    		
    		$cllao11$PROXIMO_ANO->si35_tiporegistro          = 11;
    		$cllao11$PROXIMO_ANO->si35_reg10                 = $cllao10$PROXIMO_ANO->si34_sequencial;
    		$cllao11$PROXIMO_ANO->si35_nroleialteracao       = $oDados10->o138_numerolei;
    		$cllao11$PROXIMO_ANO->si35_tipoleialteracao      = $oDados11->o200_tipoleialteracao;
    		$cllao11$PROXIMO_ANO->si35_artigoleialteracao    = $oDados11->o200_artleialteracao;
    		$cllao11$PROXIMO_ANO->si35_descricaoartigo       = $oDados11->o200_descrartigo;
    		$cllao11$PROXIMO_ANO->si35_vlautorizadoalteracao = $oDados11->o200_vlautorizado;
    		$cllao11$PROXIMO_ANO->si35_mes                   = $this->sDataFinal['5'].$this->sDataFinal['6'];
    		$cllao11$PROXIMO_ANO->si35_instit                = db_getsession("DB_instit");
    		
    		$cllao11$PROXIMO_ANO->incluir(null);
    		if ($cllao11$PROXIMO_ANO->erro_status == 0) {
    			throw new Exception($cllao11$PROXIMO_ANO->erro_msg);
    		}
    		
    	}
    	
    }
		
    /*
     * selecionar informacoes registro 20
     */
    $sSql     = "select * from orcprojetolei where o138_altpercsuplementacao = 1 and o138_data >= '{$this->sDataInicial}' and o138_data <= '{$this->sDataFinal}'";
    $rsResult20 = db_query($sSql);
    
    for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {
    	
    	$cllao20$PROXIMO_ANO = new cl_lao20$PROXIMO_ANO();
    	$oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);
    	
    	$cllao20$PROXIMO_ANO->si36_tiporegistro      = 20;
    	$cllao20$PROXIMO_ANO->si36_codorgao          = $sCodorgao;
    	$cllao20$PROXIMO_ANO->si36_nroleialterorcam  = $oDados20->o138_numerolei;
    	$cllao20$PROXIMO_ANO->si36_dataleialterorcam = $oDados20->o138_data;
    	$cllao20$PROXIMO_ANO->si36_mes               = $this->sDataFinal['5'].$this->sDataFinal['6'];
    	$cllao20$PROXIMO_ANO->si36_instit            = db_getsession("DB_instit");
      
    	$cllao20$PROXIMO_ANO->incluir(null);
    	if ($cllao20$PROXIMO_ANO->erro_status == 0) {
    		throw new Exception($cllao20$PROXIMO_ANO->erro_msg);
    	}
    	
    	/*
    	 * selecionar informacoes registro 21
    	 */
    	$sSql = "select * from orcalteracaopercloa where o201_orcprojetolei = {$oDados20->o138_sequencial}";
    	$rsResult21 = db_query($sSql);
    	for ($iCont21 = 0; $iCont21 < pg_num_rows($rsResult21); $iCont21++) {
    		
    		$cllao21$PROXIMO_ANO = new cl_lao21$PROXIMO_ANO();
    		$oDados21 = db_utils::fieldsMemory($rsResult21, $iCont21);
    		
    		$cllao21$PROXIMO_ANO->si37_tiporegistro            = 21;
    		$cllao21$PROXIMO_ANO->si37_reg20                   = $cllao20$PROXIMO_ANO->si36_sequencial;
    		$cllao21$PROXIMO_ANO->si37_nroleialterorcam        = $oDados20->o138_numerolei;
    		$cllao21$PROXIMO_ANO->si37_tipoautorizacao         = $oDados21->o201_tipoleialteracao;
    		$cllao21$PROXIMO_ANO->si37_artigoleialterorcamento = $oDados21->o201_artleialteracao;
    		$cllao21$PROXIMO_ANO->si37_descricaoartigo         = $oDados21->o201_descrartigo;
    		$cllao21$PROXIMO_ANO->si37_novopercentual          = $oDados21->o201_percautorizado;
    		$cllao21$PROXIMO_ANO->si37_mes                     = $this->sDataFinal['5'].$this->sDataFinal['6'];
    		$cllao21$PROXIMO_ANO->si37_instit                  = db_getsession("DB_instit");
    		
    		$cllao21$PROXIMO_ANO->incluir(null);
    		if ($cllao21$PROXIMO_ANO->erro_status == 0) {
    			throw new Exception($cllao21$PROXIMO_ANO->erro_msg);
    		}
    		
    	}
    	
    }
    
    db_fim_transacao();
    
    $oGerarLAO = new GerarLAO();
    $oGerarLAO->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarLAO->gerarDados();
		
  }
  
}
