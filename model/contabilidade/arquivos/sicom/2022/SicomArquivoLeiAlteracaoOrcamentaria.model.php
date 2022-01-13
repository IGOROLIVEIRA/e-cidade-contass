<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_lao102022_classe.php");
require_once ("classes/db_lao112022_classe.php");
require_once ("classes/db_lao202221_classe.php");
require_once ("classes/db_lao212022_classe.php");
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

  	
  	$cllao102022 = new cl_lao102022();
  	$cllao112022 = new cl_lao112022();
  	$cllao202221 = new cl_lao202221();
  	$cllao212022 = new cl_lao212022();
  	
  	db_inicio_transacao();
  	
    /*
     * excluir informacoes do mes selecionado registro 21
     */
    $result = $cllao212022->sql_record($cllao212022->sql_query(NULL,"*",NULL,"si37_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si37_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$cllao212022->excluir(NULL,"si37_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si37_instit = ".db_getsession("DB_instit"));
      if ($cllao212022->erro_status == 0) {
    	  throw new Exception($cllao212022->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 11
     */
    $result = $cllao112022->sql_record($cllao112022->sql_query(NULL,"*",NULL,"si35_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si35_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {	
    	$cllao112022->excluir(NULL,"si35_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si35_instit = ".db_getsession("DB_instit"));
      if ($cllao112022->erro_status == 0) {
    	  throw new Exception($cllao112022->erro_msg);
      }
    }
    
    /*
  	 * excluir informacoes do mes selecionado registro 10
  	 */
    $result = $cllao102022->sql_record($cllao102022->sql_query(NULL,"*",NULL,"si34_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si34_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$cllao102022->excluir(NULL,"si34_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si34_instit = ".db_getsession("DB_instit"));
      if ($cllao102022->erro_status == 0) {
    	  throw new Exception($cllao102022->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = $cllao202221->sql_record($cllao202221->sql_query(NULL,"*",NULL,"si36_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si36_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$cllao202221->excluir(NULL,"si36_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si36_instit = ".db_getsession("DB_instit"));
      if ($cllao202221->erro_status == 0) {
    	  throw new Exception($cllao202221->erro_msg);
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
    	
    	$cllao102022 = new cl_lao102022();
    	$oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
    	
    	$cllao102022->si34_tiporegistro     = 10;
    	$cllao102022->si34_codorgao         = $sCodorgao;
    	$cllao102022->si34_nroleialteracao  = $oDados10->o138_numerolei;
    	$cllao102022->si34_dataleialteracao = $oDados10->o138_data;
    	$cllao102022->si34_mes              = $this->sDataFinal['5'].$this->sDataFinal['6'];
    	$cllao102022->si34_instit           = db_getsession("DB_instit");
    	
    	$cllao102022->incluir(null);
    	if ($cllao102022->erro_status == 0) {
    		throw new Exception($cllao102022->erro_msg);
    	}
    	
    	/*
    	 * selecionar informacoes registro 11
    	 */
    	$sSql = "select * from orcleialtorcamentaria where o200_orcprojetolei = {$oDados10->o138_sequencial}";
    	$rsResult11 = db_query($sSql);
    	for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {
    		
    		$cllao112022 = new cl_lao112022();
    		$oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);
    		
    		$cllao112022->si35_tiporegistro          = 11;
    		$cllao112022->si35_reg10                 = $cllao102022->si34_sequencial;
    		$cllao112022->si35_nroleialteracao       = $oDados10->o138_numerolei;
    		$cllao112022->si35_tipoleialteracao      = $oDados11->o200_tipoleialteracao;
    		$cllao112022->si35_artigoleialteracao    = $oDados11->o200_artleialteracao;
    		$cllao112022->si35_descricaoartigo       = $oDados11->o200_descrartigo;
    		$cllao112022->si35_vlautorizadoalteracao = $oDados11->o200_vlautorizado;
    		$cllao112022->si35_mes                   = $this->sDataFinal['5'].$this->sDataFinal['6'];
    		$cllao112022->si35_instit                = db_getsession("DB_instit");
    		
    		$cllao112022->incluir(null);
    		if ($cllao112022->erro_status == 0) {
    			throw new Exception($cllao112022->erro_msg);
    		}
    		
    	}
    	
    }
		
    /*
     * selecionar informacoes registro 20
     */
    $sSql     = "select * from orcprojetolei where o138_altpercsuplementacao = 1 and o138_data >= '{$this->sDataInicial}' and o138_data <= '{$this->sDataFinal}'";
    $rsResult20 = db_query($sSql);
    
    for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {
    	
    	$cllao202221 = new cl_lao202221();
    	$oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);
    	
    	$cllao202221->si36_tiporegistro      = 20;
    	$cllao202221->si36_codorgao          = $sCodorgao;
    	$cllao202221->si36_nroleialterorcam  = $oDados20->o138_numerolei;
    	$cllao202221->si36_dataleialterorcam = $oDados20->o138_data;
    	$cllao202221->si36_mes               = $this->sDataFinal['5'].$this->sDataFinal['6'];
    	$cllao202221->si36_instit            = db_getsession("DB_instit");
      
    	$cllao202221->incluir(null);
    	if ($cllao202221->erro_status == 0) {
    		throw new Exception($cllao202221->erro_msg);
    	}
    	
    	/*
    	 * selecionar informacoes registro 21
    	 */
    	$sSql = "select * from orcalteracaopercloa where o201_orcprojetolei = {$oDados20->o138_sequencial}";
    	$rsResult21 = db_query($sSql);
    	for ($iCont21 = 0; $iCont21 < pg_num_rows($rsResult21); $iCont21++) {
    		
    		$cllao212022 = new cl_lao212022();
    		$oDados21 = db_utils::fieldsMemory($rsResult21, $iCont21);
    		
    		$cllao212022->si37_tiporegistro            = 21;
    		$cllao212022->si37_reg20                   = $cllao202221->si36_sequencial;
    		$cllao212022->si37_nroleialterorcam        = $oDados20->o138_numerolei;
    		$cllao212022->si37_tipoautorizacao         = $oDados21->o201_tipoleialteracao;
    		$cllao212022->si37_artigoleialterorcamento = $oDados21->o201_artleialteracao;
    		$cllao212022->si37_descricaoartigo         = $oDados21->o201_descrartigo;
    		$cllao212022->si37_novopercentual          = $oDados21->o201_percautorizado;
    		$cllao212022->si37_mes                     = $this->sDataFinal['5'].$this->sDataFinal['6'];
    		$cllao212022->si37_instit                  = db_getsession("DB_instit");
    		
    		$cllao212022->incluir(null);
    		if ($cllao212022->erro_status == 0) {
    			throw new Exception($cllao212022->erro_msg);
    		}
    		
    	}
    	
    }
    
    db_fim_transacao();
    
    $oGerarLAO = new GerarLAO();
    $oGerarLAO->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarLAO->gerarDados();
		
  }
  
}
