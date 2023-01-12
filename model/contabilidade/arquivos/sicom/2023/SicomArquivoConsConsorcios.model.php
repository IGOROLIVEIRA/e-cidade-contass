<?php 
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_consor102023_classe.php");
require_once ("classes/db_consor202321_classe.php");
require_once ("classes/db_consor212023_classe.php");
require_once ("classes/db_consor222023_classe.php");
require_once ("classes/db_consor302023_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarCONSOR.model.php");

 /**
  * gerar arquivo de identificacao da Remessa Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoConsConsorcios extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
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
  protected $sNomeArquivo = 'CONSOR';
  
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
  	$clconsor102023 = new cl_consor102023();
  	$clconsor202321 = new cl_consor202321();
  	$clconsor212023 = new cl_consor212023();
  	$clconsor222023 = new cl_consor222023();
  	$clconsor302023 = new cl_consor302023();
    
    /**
     * excluir informacoes do mes selecioado
     */
    db_inicio_transacao();
        
    $result = db_query($clconsor212023->sql_query(NULL,"*",NULL,"si18_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si18_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clconsor212023->excluir(NULL,"si18_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si18_instit = ".db_getsession("DB_instit"));
      if ($clconsor212023->erro_status == 0) {
    	  throw new Exception($clconsor212023->erro_msg);
      }
    }
    
    $result = db_query($clconsor222023->sql_query(NULL,"*",NULL,"si19_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']));
    if (pg_num_rows($result) > 0) {
    	$clconsor222023->excluir(NULL,"si19_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
      if ($clconsor222023->erro_status == 0) {
    	  throw new Exception($clconsor222023->erro_msg);
      }
    }
    
    $result = db_query($clconsor302023->sql_query(NULL,"*",NULL,"si20_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si20_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clconsor302023->excluir(NULL,"si20_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si20_instit = ".db_getsession("DB_instit"));
      if ($clconsor302023->erro_status == 0) {
    	  throw new Exception($clconsor302023->erro_msg);
      }
    }
    
    $result = db_query($clconsor202321->sql_query(NULL,"*",NULL,"si17_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si17_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clconsor202321->excluir(NULL,"si17_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si17_instit = ".db_getsession("DB_instit"));
      if ($clconsor202321->erro_status == 0) {
    	  throw new Exception($clconsor202321->erro_msg);
      }
    }
    
    $result = db_query($clconsor102023->sql_query(NULL,"*",NULL,"si16_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'])." and si16_instit = ".db_getsession("DB_instit"));
    if (pg_num_rows($result) > 0) {
    	$clconsor102023->excluir(NULL,"si16_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si16_instit = ".db_getsession("DB_instit"));
      if ($clconsor102023->erro_status == 0) {
    	  throw new Exception($clconsor102023->erro_msg);
      }
    }
    
    if ($this->sDataFinal['5'].$this->sDataFinal['6'] == 01) {
      $sSql = "select si09_codorgaotce,z01_cgccpf,c200_areaatuacao,c200_descrarea from consconsorcios join cgm on z01_numcgm = c200_numcgm 
      join db_config on c200_instit = codigo join infocomplementaresinstit on codigo = si09_instit";
    } else {
    	$sSql = "select si09_codorgaotce,z01_cgccpf,c200_areaatuacao,c200_descrarea from consconsorcios join cgm on z01_numcgm = c200_numcgm 
      join db_config on c200_instit = codigo join infocomplementaresinstit on codigo = si09_instit 
      where c200_dataadesao >= '{$this->sDataInicial}' and c200_dataadesao <= '{$this->sDataFinal}'";
    }
    
    $rsResult10 = db_query($sSql);
    
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
      
    	$clconsor102023 = new cl_consor102023();
    	$oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
	   
		  $clconsor102023->si16_tiporegistro    = 10;
		  $clconsor102023->si16_codorgao        = $oDados10->si09_codorgaotce;
		  $clconsor102023->si16_cnpjconsorcio   = $oDados10->z01_cgccpf;
		  $clconsor102023->si16_areaatuacao     = $oDados10->c200_areaatuacao;
		  $clconsor102023->si16_descareaatuacao = $oDados10->c200_descrarea;
		  $clconsor102023->si16_mes             = $this->sDataFinal['5'].$this->sDataFinal['6'];
		  $clconsor102023->si16_instit          = db_getsession("DB_instit");
		  
		  $clconsor102023->incluir(null);
		  if ($clconsor102023->erro_status == 0) {
		  	throw new Exception($clconsor102023->erro_msg);
		  }
		  
    }
		  
		$sSql = "select si09_codorgaotce, z01_cgccpf,c201_valortransf,c201_enviourelatorios from consvalorestransf 
		join consconsorcios on c201_consconsorcios = c200_sequencial 
		join cgm on c200_numcgm = z01_numcgm 
		join db_config on c200_instit = codigo 
		join infocomplementaresinstit on codigo = si09_instit where c201_mescompetencia = ".$this->sDataFinal['5'].$this->sDataFinal['6']; 
		$rsResult20 = db_query($sSql);
		/**
		 * registro 20
		 */
		for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {
		  	
		  $clconsor202321 = new cl_consor202321();
			$oDados20       = db_utils::fieldsMemory($rsResult20, $iCont20);
		  	
			$clconsor202321->si17_tiporegistro   = 20;
		 	$clconsor202321->si17_codorgao       = $oDados20->si09_codorgaotce;
			$clconsor202321->si17_cnpjconsorcio  = $oDados20->z01_cgccpf;
		 	$clconsor202321->si17_vltransfrateio = $oDados20->c201_valortransf;
		  $clconsor202321->si17_prestcontas    = $oDados20->c201_enviourelatorios == 't' ? 1 : 2;
		  $clconsor202321->si17_mes            = $this->sDataFinal['5'].$this->sDataFinal['6'];
		  $clconsor202321->si17_instit         = db_getsession("DB_instit");
		  	
		  $clconsor202321->incluir(null);
		  if ($clconsor202321->erro_status == 0) {
		    throw new Exception($clconsor202321->erro_msg);
		  }
		  	
		}
		  
		$sSql = "select si09_codorgaotce, z01_cgccpf, consexecucaoorc.* from consexecucaoorc 
		join consconsorcios on c202_consconsorcios = c200_sequencial 
		join cgm on c200_numcgm = z01_numcgm join db_config on c200_instit = codigo 
		join infocomplementaresinstit on codigo = si09_instit 
		where c202_mescompetencia  = ".$this->sDataFinal['5'].$this->sDataFinal['6'];
		$rsResult21 = db_query($sSql);
		/**
		 * registro 21
		 */
		for ($iCont21 = 0; $iCont21 < pg_num_rows($rsResult21); $iCont21++) {
		  	
		  $clconsor212023 = new cl_consor212023();
		  $oDados21       = db_utils::fieldsMemory($rsResult21, $iCont21);
		  	
		  $clconsor212023->si18_tiporegistro         = 21;
		  $clconsor212023->si18_cnpjconsorcio        = $oDados21->z01_cgccpf;
		  $clconsor212023->si18_codfuncao            = $oDados21->c202_funcao;
		  $clconsor212023->si18_codsubfuncao         = $oDados21->c202_subfuncao;
		  $clconsor212023->si18_naturezadespesa      = substr($oDados21->c202_elemento,1,6);
		  $clconsor212023->si18_subelemento          = substr($oDados21->c202_elemento,7,8);
		  $clconsor212023->si18_vlempenhado          = $oDados21->c202_valorempenhado;
		  $clconsor212023->si18_vlanulacaoempenho    = $oDados21->c202_valorempenhadoanu;
		  $clconsor212023->si18_vlliquidado          = $oDados21->c202_valorliquidado;
		  $clconsor212023->si18_vlanulacaoliquidacao = $oDados21->c202_valorliquidadoanu;
		  $clconsor212023->si18_vlpago               = $oDados21->c202_valorpago;
		  $clconsor212023->si18_vlanulacaopagamento  = $oDados21->c202_valorpagoanu;
		  $clconsor212023->si18_mes                  = $this->sDataFinal['5'].$this->sDataFinal['6'];
		  $clconsor212023->si18_reg20                = $clconsor202321->si17_sequencial;
		  $clconsor212023->si18_instit               = db_getsession("DB_instit");
		  	
		  $clconsor212023->incluir(null);
		  if ($clconsor212023->erro_status == 0) {
		    throw new Exception($clconsor212023->erro_msg);
		  }
		  	
		}
		  
		/**
		 * registro gerado apenas no mes de dezembro
		 */
		if ($this->sDataFinal['5'].$this->sDataFinal['6'] == 12) {
		  	
		  $sSql = "select si09_codorgaotce, z01_cgccpf,c203_valor from consdispcaixaano join consconsorcios on c203_consconsorcios = c200_sequencial 
		  join cgm on c200_numcgm = z01_numcgm join db_config on c200_instit = codigo 
		  join infocomplementaresinstit on codigo = si09_instit where c203_anousu = ".db_getsession("DB_anousu");
		  $rsResult22 = db_query($sSql);
		  /**
		   * registro 22
		   */
		  for ($iCont22 = 0; $iCont22 < pg_num_rows($rsResult22); $iCont22++) {
		  	
		    $clconsor222023 = new cl_consor22023();
		  	$oDados22       =  db_utils::fieldsMemory($rsResult22, $iCont22);
		  	
		  	$clconsor222023->si19_tiporegistro = 22;
		  	$clconsor222023->si19_cnpjconsorcio = $oDados22->z01_cgccpf;
		  	$clconsor222023->si19_vldispcaixa   = $oDados22->c203_valor;
		  	$clconsor222023->si19_mes           = $this->sDataFinal['5'].$this->sDataFinal['6'];
		  	$clconsor222023->si19_reg20         = $clconsor202321->si17_sequencial;
		  	$clconsor222023->si19_instit        = db_getsession("DB_instit");
		  	
		    $clconsor222023->incluir(null);
		    if ($clconsor222023->erro_status == 0) {
		  	  throw new Exception($clconsor222023->erro_msg);
		    }
		  	
		  }
		  
		}
		  
		$sSql = "select si09_codorgaotce, z01_cgccpf,c204_tipoencerramento,c204_dataencerramento from consretiradaexclusao 
		join consconsorcios on c204_consconsorcios = c200_sequencial 
		join cgm on c200_numcgm = z01_numcgm join db_config on c200_instit = codigo 
		join infocomplementaresinstit on codigo = si09_instit 
		where c204_dataencerramento is not null 
		and c204_dataencerramento >= '{$this->sDataInicial}' and c204_dataencerramento <= '{$this->sDataFinal}'";
		$rsResult30 = db_query($sSql);
		
		for ($iCont30 = 0; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {
		  	
		  $clconsor302023 = new cl_consor302023();
			$oDados30       = db_utils::fieldsMemory($rsResult30, $iCont30);
		  	
		  $clconsor302023->si20_tiporegistro     = 30;
		  $clconsor302023->si20_codorgao         = $oDados30->si09_codorgaotce;
		  $clconsor302023->si20_cnpjconsorcio    = $oDados30->z01_cgccpf;
		  $clconsor302023->si20_tipoencerramento = $oDados30->c204_tipoencerramento;
		  $clconsor302023->si20_dtencerramento   = $oDados30->c204_dataencerramento;
		  $clconsor302023->si20_mes              = $this->sDataFinal['5'].$this->sDataFinal['6'];
		  $clconsor302023->si20_instit           = db_getsession("DB_instit");
		  	
		  $clconsor302023->incluir(null);
		  if ($clconsor302023->erro_status == 0) {
		    throw new Exception($clconsor302023->erro_msg);
		  }
		  	
		}
    
    db_fim_transacao();
    
    $oGerarCONSOR = new GerarCONSOR();
    $oGerarCONSOR->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarCONSOR->gerarDados();
    
  }
  
}
