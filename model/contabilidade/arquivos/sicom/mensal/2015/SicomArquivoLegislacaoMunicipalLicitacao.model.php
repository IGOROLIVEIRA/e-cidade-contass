<?php
 
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_reglic102015_classe.php");
require_once ("classes/db_reglic202015_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2015/GerarREGLIC.model.php");

 /**
  * gerar arquivo de identificacao da Remessa Sicom Acompanhamento Mensal
  * @author johnatan
  * @package Contabilidade
  */

class SicomArquivoLegislacaoMunicipalLicitacao extends SicomArquivoBase implements iPadArquivoBaseCSV {

  
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
  protected $sNomeArquivo = 'REGLIC';
  
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
  	
	$clreglic10 = new cl_reglic102015();
  	$clreglic20 = new cl_reglic202015();
  	
    
    /**
     * excluir informacoes do mes selecioado
     */
    db_inicio_transacao();
    $result = db_query($clreglic10->sql_query(NULL,"*",NULL,"si44_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si44_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clreglic10->excluir(NULL,"si44_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si44_instit=".db_getsession("DB_instit"));
      if ($clreglic10->erro_status == 0) {
    	  throw new Exception($clreglic10->erro_msg);
      }
    }
    
    $result = db_query($clreglic20->sql_query(NULL,"*",NULL,"si45_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si45_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clreglic20->excluir(NULL,"si45_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si45_instit=".db_getsession("DB_instit"));
      if ($clreglic20->erro_status == 0) {
    	  throw new Exception($clreglic20->erro_msg);
      }
    }
    
    $sSql= "SELECT   '10' as tipoRegistro,
	2 as codOrgao,
	decretopregao.l201_tipodecreto as tipoDecreto,
	decretopregao.l201_numdecreto as nroDecretoMunicipal,
	decretopregao.l201_datadecreto as dataDecretoMunicipal,
	decretopregao.l201_datapublicacao as dataPublicacaoDecretoMunicipal	
	FROM licitacao.decretopregao as decretopregao 
	WHERE decretopregao.l201_numdecreto not in 
	(select si44_nrodecretomunicipal from reglic102014 
	UNION select si44_nrodecretomunicipal from reglic102015 where si44_mes <= ".$this->sDataFinal['5'].$this->sDataFinal['6'].") ";
    
    
    $rsResult10 = db_query($sSql);
    
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
      
    	$clreglic10 = new cl_reglic102015();
    	$oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
	   
		  $clreglic10->si44_tiporegistro         			= 10;
		  $clreglic10->si44_codorgao        	 			= $oDados10->codorgao;
		  $clreglic10->si44_tipodecreto    		 			= $oDados10->tipodecreto;
		  $clreglic10->si44_nrodecretomunicipal  			= $oDados10->nrodecretomunicipal;
		  $clreglic10->si44_datadecretomunicipal 			= $oDados10->datadecretomunicipal;
		  $clreglic10->si44_datapublicacaodecretomunicipal  = $oDados10->datapublicacaodecretomunicipal;
		  $clreglic10->si44_instit		   				    = db_getsession("DB_instit");
		  $clreglic10->si44_mes			                    = $this->sDataFinal['5'].$this->sDataFinal['6'];
		   		  
		  
		  $clreglic10->incluir(null);
		  if ($clreglic10->erro_status == 0) {
		  	throw new Exception($clreglic10->erro_msg);
		  }
		  
    }
    /**
     * campos faltantes  na especificação de AGNALDO. VERIFICAR ###########  SQL  ############ 
     */
    
  	/*	$sSql = "SELECT   '20' as tipoRegistro,
				db_config.db21_tipoinstit as codOrgao,
				'regulamentArt47 indefinido' as regulamentArt47,
				'nroNormaReg indefinido' as nroNormaReg,
				'dataNormaReg indefinido' as dataNormaReg,
				'dataPubNormaReg indefinido' as dataPubNormaReg,
				'regExclusiva indefinido' as regExclusiva,
				'artigoRegExclusiva indefinido' as artigoRegExclusiva,
				'valorLimiteRegExclusiva indefinido' as valorLimiteRegExclusiva	,
				'procSubContratacao indefinido' as procSubContratacao,
				'artigoProcSubContratacao indefinido' as artigoProcSubContratacao,
				'percentualSubContratacao indefinido' as percentualSubContratacao,
				'criteriosEmpenhoPagamento indefinido' as criteriosEmpenhoPagamento,
				'artigoEmpenhoPagamento indefinido' as artigoEmpenhoPagamento,
				'estabeleceuPercContratacao indefinido' as estabeleceuPercContratacao,
				'artigoPercContratacao indefinido' as artigoPercContratacao,
				'percentualContratacao indefinido' as percentualContratacao
				FROM licitacao.decretopregao as decretopregao,  configuracoes.db_config as db_config
				WHERE db_config.codigo= ".db_getsession("DB_instit")."";
	 
		$rsResult20 = db_query($sSql);
		/**
		 * registro 20
		 */
		/*for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {
		  	
		   $clreglic20 = new cl_reglic202015();
		  
			$oDados20       = db_utils::fieldsMemory($rsResult20, $iCont20);
		  	
		 	$clreglic20->si45_tiporegistro   			 = 20;
			$clreglic20->si45_codorgao					 =$oDados20->codorgao;
			$clreglic20->si45_regulamentart47			 =$oDados20->regulamentart47;	
			$clreglic20->si45_nronormareg				 =$oDados20->nronormareg;
			$clreglic20->si45_datanormareg               =$oDados20->datanormareg;
			$clreglic20->si45_datapubnormareg			 =$oDados20->datapubnormareg;
			$clreglic20->si45_regexclusiva				 =$oDados20->regexclusiva;
			$clreglic20->si45_artigoregexclusiva		 =$oDados20->artigoregexclusiva;
			$clreglic20->si45_valorlimiteregexclusiva	 =$oDados20->valorlimiteregexclusiva;
			$clreglic20->si45_procsubcontratacao		 =$oDados20->procsubcontratacao	;
			$clreglic20->si45_artigoprocsubcontratacao	 =$oDados20->vartigoprocsubcontratacao;
			$clreglic20->si45_percentualsubcontratacao	 =$oDados20->percentualsubcontratacao;
			$clreglic20->si45_criteriosempenhopagamento	 =$oDados20->criteriosempenhopagamento;
			$clreglic20->si45_artigoempenhopagamento     =$oDados20->artigoempenhopagamento;
			$clreglic20->si45_estabeleceuperccontratacao =$oDados20->estabeleceuperccontratacao;
			$clreglic20->si45_artigoperccontratacao 	 =$oDados20->vartigoperccontratacao;
			$clreglic20->si45_percentualcontratacao		 =$oDados20->percentualcontratacao;
		 	
		 	
		  $clreglic20->incluir(null);
		  if ($clreglic20->erro_status == 0) {
		    throw new Exception($clreglic20->erro_msg);
		  }
		  	
		}*/
    
    
	
    
    db_fim_transacao();
    
    $oGerarREGLIC = new GerarREGLIC();
    $oGerarREGLIC->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarREGLIC->gerarDados();
    
  }
  
}
