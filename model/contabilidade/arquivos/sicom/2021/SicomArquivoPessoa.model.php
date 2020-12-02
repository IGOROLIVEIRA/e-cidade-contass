<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_pessoa10$PROXIMO_ANO_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarPESSOA.model.php");

 /**
  * gerar arquivo pessoal Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoPessoa extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 0;
  
  /**
   * 
   * NOme do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'PESSOA';
  
  /**
   * 
   * Contrutor da classe
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
    
  }
  
  /**
   * selecionar os dados de indentificacao da remessa pra gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados(){
 		
  	/**
  	 * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo 
  	 */
  	$clpessoa = new cl_pessoa10$PROXIMO_ANO();
  	
  	/**
  	 * excluir informacoes do mes selecionado
  	 */
    db_inicio_transacao();
    $result = $clpessoa->sql_record($clpessoa->sql_query(NULL,"*",NULL,"si12_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si12_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clpessoa->excluir(NULL,"si12_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si12_instit = ".db_getsession("DB_instit"));
      if ($clpessoa->erro_status == 0) {
    	  throw new Exception($clpessoa->erro_msg);
      }
    }
  	
  	if ($this->sDataFinal['5'].$this->sDataFinal['6'] != 01) {
  	  
  		$sSql  = "select z01_cgccpf, 
       z01_nome, 
       z01_ultalt, 
       z01_obs,
       z01_cadast 
  from cgm 
 where (z01_cgccpf != '00000000000' and z01_cgccpf != '00000000000000') 
 and ( (z01_cadast between '{$this->sDataInicial}' and '{$this->sDataFinal}') 
 or (z01_ultalt between '{$this->sDataInicial}' and '{$this->sDataFinal}') )";
 		
  	} else {
  		$sSql  = "select z01_cgccpf, 
       z01_nome, 
       z01_ultalt, 
       z01_obs,
       z01_cadast 
      from cgm where (z01_cgccpf != '00000000000' and z01_cgccpf != '00000000000000')";
  	}
    	
    $rsResult  = db_query($sSql);
    
    for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {
    	
    	$clpessoa = new cl_pessoa10$PROXIMO_ANO();
    	$oDados = db_utils::fieldsMemory($rsResult, $iCont);
    	
    	if ($oDados->z01_cadast >= $this->sDataInicial && $oDados->z01_cadast <= $this->sDataFinal) {
    		$sTipoCadastro = 1;
    	} else {
    		$sTipoCadastro = 2;
    	}
    	
    	$clpessoa->si12_tiporegistro           = 10;
    	$clpessoa->si12_tipodocumento          = strlen($oDados->z01_cgccpf) == 11 ? 1 : 2;
    	$clpessoa->si12_nrodocumento           = $oDados->z01_cgccpf;
    	$clpessoa->si12_nomerazaosocial        = str_replace("'", "", $oDados->z01_nome);
    	$clpessoa->si12_tipocadastro           = $sTipoCadastro;
    	$clpessoa->si12_justificativaalteracao = substr($oDados->z01_obs,0,100);
    	$clpessoa->si12_mes                    = $this->sDataFinal['5'].$this->sDataFinal['6'];
    	$clpessoa->si12_instit                 = db_getsession("DB_instit");
    	
    	$clpessoa->incluir(null);
    	if ($clpessoa->erro_status == 0) {
    	  throw new Exception($clpessoa->erro_msg);
      }
      
    }
    db_fim_transacao();
    
    $oGerarPESSOA       = new GerarPESSOA();
    $oGerarPESSOA->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarPESSOA->gerarDados();
    
  }
  
}
