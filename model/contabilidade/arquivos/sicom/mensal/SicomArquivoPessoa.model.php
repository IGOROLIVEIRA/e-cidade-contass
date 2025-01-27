<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_pessoa102014_classe.php");
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
  	$clpessoa2014 = new cl_pessoa102014();
  	
  	/**
  	 * excluir informacoes do mes selecionado
  	 */
    db_inicio_transacao();
    $result = $clpessoa2014->sql_record($clpessoa2014->sql_query(NULL,"*",NULL,"si12_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']));
    if (pg_num_rows($result) > 0) {
    	$clpessoa2014->excluir(NULL,"si12_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
      if ($clpessoa2014->erro_status == 0) {
    	  throw new Exception($clpessoa2014->erro_msg);
      }
    }
  	
  	if ($this->sDataFinal['5'].$this->sDataFinal['6'] != 01) {
  	  
  		$sSql  = "select z01_cgccpf, 
       z01_nome, 
       z01_ultalt, 
       z01_obs,
       z01_cadast 
  from cgm 
 where (z01_cgccpf != '00000000000' and z01_cgccpf != '00000000000000') and ((z01_cadast between '{$this->sDataInicial}' and '{$this->sDataFinal}') or (z01_ultalt between '{$this->sDataInicial}' and '{$this->sDataFinal}'))";
 		
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
    	
    	$clpessoa2014 = new cl_pessoa102014();
    	$oDados = db_utils::fieldsMemory($rsResult, $iCont);
    	
    	if ($oDados->z01_cadast >= $this->sDataInicial && $oDados->z01_cadast <= $this->sDataFinal) {
    		$sTipoCadastro = 1;
    	} else {
    		$sTipoCadastro = 2;
    	}
    	
    	$clpessoa2014->si12_tiporegistro           = 10;
    	$clpessoa2014->si12_tipodocumento          = strlen($oDados->z01_cgccpf) == 11 ? 1 : 2;
    	$clpessoa2014->si12_nrodocumento           = $oDados->z01_cgccpf;
    	$clpessoa2014->si12_nomerazaosocial        = $oDados->z01_nome;
    	$clpessoa2014->si12_tipocadastro           = $sTipoCadastro;
    	$clpessoa2014->si12_justificativaalteracao = $oDados->z01_obs;
    	$clpessoa2014->si12_mes                    = $this->sDataFinal['5'].$this->sDataFinal['6'];
    	
    	$clpessoa2014->incluir(null);
    	if ($clpessoa2014->erro_status == 0) {
    	  throw new Exception($clpessoa2014->erro_msg);
      }
      break;
    }
    db_fim_transacao();
    
    $oGerarPESSOA       = new GerarPESSOA();
    $oGerarPESSOA->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarPESSOA->gerarDados();
    
  }
  
}
