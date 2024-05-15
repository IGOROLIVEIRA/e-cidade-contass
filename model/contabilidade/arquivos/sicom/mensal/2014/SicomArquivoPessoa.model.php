<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_pessoa102014_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2014/GerarPESSOA.model.php");

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
    $result = $clpessoa2014->sql_record($clpessoa2014->sql_query(NULL,"*",NULL,"si12_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si12_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clpessoa2014->excluir(NULL,"si12_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si12_instit = ".db_getsession("DB_instit"));
      if ($clpessoa2014->erro_status == 0) {
    	  throw new Exception($clpessoa2014->erro_msg);
      }
    }
  	
  	if ($this->sDataFinal['5'].$this->sDataFinal['6'] != 01) {
  	  
  		$sSql  = "select distinct case when length(z01_cgccpf) < 11 then lpad(z01_cgccpf, 11, '0') else z01_cgccpf end as z01_cgccpf, 
					       z01_nome, 
					       z01_ultalt, 
					       z01_obs,
					       z01_cadast 
					  from cgm 
					 where (z01_cgccpf != '00000000000' and z01_cgccpf != '00000000000000') 
					 and ( (z01_cadast between '{$this->sDataInicial}' and '{$this->sDataFinal}') 
					 or (z01_ultalt between '{$this->sDataInicial}' and '{$this->sDataFinal}') )
					 and (z01_cgccpf != '' and z01_cgccpf is not null)
					 and z01_cgccpf not in (select si12_nrodocumento from pessoa102014 where si12_mes < ".($this->sDataFinal['5'].$this->sDataFinal['6']).")";
 		
  	} else {
  		$sSql  = "select z01_cgccpf, 
		       z01_nome, 
		       z01_ultalt, 
		       z01_obs,
		       z01_cadast 
		      from cgm where (z01_cgccpf != '00000000000' and z01_cgccpf != '00000000000000')
		      and (z01_cgccpf != '' and z01_cgccpf is not null)";
  	}
    	
    $rsResult  = db_query($sSql);//db_criatabela($rsResult);exit;
    $aPessoas    =  array();
    $aCpfPessoas = array("00000000000","00000000000000","11111111111","11111111111111","22222222222","22222222222222","33333333333","33333333333333",
    "44444444444","44444444444444","55555555555","55555555555555","66666666666","66666666666666","77777777777","77777777777777","88888888888","88888888888888",
    "99999999999","99999999999999");
    $what = array("'","°",chr(13),chr(10), 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','Ã','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );

    // matriz de saída
    $by   = array('','','','', 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','A','E','I','O','U','n','n','c','C',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ' );
    for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {
    	
    	$clpessoa2014 = new cl_pessoa102014();
    	$oDados = db_utils::fieldsMemory($rsResult, $iCont);
    	
    
    	if (in_array($oDados->z01_cgccpf, $aCpfPessoas)) {
    		continue;
    	}
    	
    	if(($this->sDataFinal['5'].$this->sDataFinal['6']) != '01' && db_getsession("DB_anousu") != 2014){
	    	if ($oDados->z01_cadast >= $this->sDataInicial && $oDados->z01_cadast <= $this->sDataFinal) {
	    		$sTipoCadastro = 1;
	    		$sJustificativaalteracao = ' ';
	    	} else {
	    		$sTipoCadastro = 2;
	    		$sJustificativaalteracao = substr($oDados->z01_obs,0,100);
	    	}
    	}else{
    		if(($this->sDataFinal['5'].$this->sDataFinal['6']) != '01'){
	    		if ($oDados->z01_cadast >= $this->sDataInicial && $oDados->z01_cadast <= $this->sDataFinal) {
		    		$sTipoCadastro = 1;
		    		$sJustificativaalteracao = ' ';
		    	} else {
		    		$sTipoCadastro = 2;
		    		$sJustificativaalteracao = substr($oDados->z01_obs,0,100);
		    	}
    		}else{
    			$sTipoCadastro = 1;
    			$sJustificativaalteracao = ' ';
    		}
    	}
    	$aHash = $oDados->z01_cgccpf;
    	 
    	if(!isset($aPessoas[$aHash])) {
    		
    	$clpessoa2014->si12_tiporegistro           = 10;
    	$clpessoa2014->si12_tipodocumento          = strlen($oDados->z01_cgccpf) <= 11 ? 1 : 2;
    	$clpessoa2014->si12_nrodocumento           = $oDados->z01_cgccpf;
    	$clpessoa2014->si12_nomerazaosocial        = trim(preg_replace("/[^a-zA-Z0-9 ]/", "",substr(str_replace($what, $by, $oDados->z01_nome), 0, 200)));
    	$clpessoa2014->si12_tipocadastro           = $sTipoCadastro;
    	$clpessoa2014->si12_justificativaalteracao = $sJustificativaalteracao;
    	$clpessoa2014->si12_mes                    = $this->sDataFinal['5'].$this->sDataFinal['6'];
    	$clpessoa2014->si12_instit                 = db_getsession("DB_instit");
    	
	    	$clpessoa2014->incluir(null);
	    	if ($clpessoa2014->erro_status == 0) {
	    	  throw new Exception($clpessoa2014->erro_msg);
	        }
	        $aPessoas[$aHash] = $clpessoa2014;
    	}
      	
      
    }
    db_fim_transacao();
    
    $oGerarPESSOA       = new GerarPESSOA();
    $oGerarPESSOA->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarPESSOA->gerarDados();
    
  }
  
}
