<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_parelic102021_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarPARELIC.model.php");

 /**
  * Parecer da Licitação Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoParecerLicitacao extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 159;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'PARELIC';
  
  /**
   * 
   * Construtor da classe
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
    
    $aElementos = array(
                        "codOrgao",
                        "codUnidadeSub",
                        "exercicioLicitacao",
                        "nroProcessoLicitatorio",
                        "dataParecer",
				    					  "tipoParecer",
				    					  "nroCpf",
				    					  "nomRespParecer",
				    					  "logradouro",
				    					  "bairroLogra",
				    					  "codCidadeLogra",
				    					  "ufCidadeLogra",
				    					  "cepLogra",
				    					  "telefone",
				    					  "email"					  
                        );			
    return $aElementos;
  }
  
  /**
   * Parecer da Licitação do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
  	
  /**
  	 * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo 
  	 */
  	$clparelic102021 = new cl_parelic102021();
  	
  	/**
     * excluir informacoes do mes selecioado
     */
    db_inicio_transacao(); 
    $result = db_query($clparelic102021->sql_query(NULL,"*",NULL,"si66_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si66_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clparelic102021->excluir(NULL,"si66_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si66_instit=".db_getsession("DB_instit"));
      if ($clparelic102021->erro_status == 0) {
    	  throw new Exception($clparelic102021->erro_msg);
      }
    }
    //
    
  	
		 $sSql=" 	SELECT '10' AS tipoRegistro,
         db_config.db21_tipoinstit AS codOrgaoResp,
         (select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
         liclicita.l20_anousu AS exercicioLicitacao,
         liclicita.l20_numero AS nroProcessoLicitatorio,
         parecerlicitacao.l200_data AS dataParecer,
         parecerlicitacao.l200_tipoparecer AS tipoParecer,
         cgm.z01_cgccpf AS nroCpf
		 FROM liclicita AS liclicita
		 INNER JOIN homologacaoadjudica AS homologacaoadjudica ON (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
		 INNER JOIN parecerlicitacao AS parecerlicitacao ON (liclicita.l20_codigo=parecerlicitacao.l200_licitacao)
		 INNER JOIN protocolo.cgm AS cgm ON (parecerlicitacao.l200_numcgm=cgm.z01_numcgm)
		 INNER JOIN configuracoes.db_config AS db_config ON (liclicita.l20_instit=db_config.codigo)
		 WHERE db_config.codigo= ".db_getsession("DB_instit")."
         AND DATE_PART('YEAR',homologacaoadjudica.l202_datahomologacao)= ".db_getsession("DB_anousu")."
         AND DATE_PART('MONTH',homologacaoadjudica.l202_datahomologacao)= ".$this->sDataFinal['5'].$this->sDataFinal['6'];

		 $rsResult10 = db_query($sSql);
    
    	for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
      
	    	$clparelic102021 = new cl_parelic102021();
	    	$oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
	   
		  $clparelic102021->si66_tiporegistro                 = 10;
		  $clparelic102021->si66_codorgao                     = $oDados10->codorgaoresp;
		  $clparelic102021->si66_codunidadesub                = $oDados10->codunidadesubresp;
		  $clparelic102021->si66_exerciciolicitacao           = $oDados10->exerciciolicitacao;
		  $clparelic102021->si66_nroprocessolicitatorio       = $oDados10->nroprocessolicitatorio;        
		  $clparelic102021->si66_dataparecer                  = $oDados10->dataparecer;
		  $clparelic102021->si66_tipoparecer                  = $oDados10->tipoparecer;
		  $clparelic102021->si66_nrocpf                       = $oDados10->nrocpf;
		  $clparelic102021->si66_instit		   		     	  = db_getsession("DB_instit");
		  $clparelic102021->si66_mes                          = $this->sDataFinal['5'].$this->sDataFinal['6'];
		  
		  $clparelic102021->incluir(null);
		  if ($clparelic102021->erro_status == 0) {
		  	throw new Exception($clparelic102021->erro_msg);
		  }
    
  	} 
 	  db_fim_transacao();
    
    $oGerarPARELIC = new GerarPARELIC();
    $oGerarPARELIC->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarPARELIC->gerarDados();		
  }		
}	
