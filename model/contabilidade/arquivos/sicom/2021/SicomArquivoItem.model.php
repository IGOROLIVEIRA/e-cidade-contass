<?php  
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_item102021_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarITEM.model.php");

 /**
  * gerar arquivo de identificacao da Remessa Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoItem extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
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
  protected $sNomeArquivo = 'ITEM';
  
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
  	$clitem102021 = new cl_item102021();
  	
  	/**
     * excluir informacoes do mes selecioado
     */
    db_inicio_transacao(); 
    $result = db_query($clitem102021->sql_query(NULL,"*",NULL,"si43_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si43_instit=".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clitem102021->excluir(NULL,"si43_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si43_instit=".db_getsession("DB_instit"));
      if ($clitem102021->erro_status == 0) {
    	  throw new Exception($clitem102021->erro_msg);
      }
    }
    
  	
	   $sSql="SELECT  '10'  AS  tipoRegistro , 
       pcmater.pc01_codmater  AS  codItem , 
       pcmater.pc01_descrmater  AS  dscItem , 
       matunid.m61_abrev  AS  unidadeMedida , 
       '1'  AS  tipoCadastro , 
       ''   AS  justificativaAlteracao 
		FROM  itenshomologacao  AS  item 
		INNER  JOIN  homologacaoadjudica  AS  homologacao  ON  ( item . l203_homologaadjudicacao = homologacao . l202_sequencial ) 
		INNER  JOIN  liclicita  AS  licitacao  ON  ( homologacao . l202_licitacao = l20_codigo ) 
		INNER  JOIN  compras . pcmater  AS  pcmater  ON  ( item . l203_item = pcmater . pc01_codmater ) 
		INNER  JOIN  compras . solicitempcmater  AS  solicitempcmater  ON  ( pcmater . pc01_codmater = solicitempcmater . pc16_codmater ) 
		INNER  JOIN  compras . solicitem  AS  solicitem  ON  ( solicitempcmater . pc16_solicitem = solicitem . pc11_codigo ) 
		INNER  JOIN  compras . solicitemunid  AS  solicitemunid  ON  ( solicitem . pc11_codigo = solicitemunid . pc17_codigo ) 
		INNER  JOIN  material . matunid  AS  matunid  ON  ( solicitemunid . pc17_unid = matunid . m61_codmatunid ) 
		WHERE  DATE_PART ( 'YEAR' , homologacao . l202_dataadjudicacao ) =".db_getsession("DB_anousu")."	
		  AND  DATE_PART ( 'MONTH' , homologacao . l202_dataadjudicacao ) = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
		UNION 
		SELECT  '10'  AS  tipoRegistro , 
		       pcmater . pc01_codmater  AS  codItem , 
		       pcmater . pc01_descrmater  AS  dscItem , 
		       matunid . m61_abrev  AS  unidadeMedida , 
		       '1'  AS  tipoCadastro , 
		       ''  AS  justificativaAlteracao 
		FROM  acordos . acordo  AS  acordo 
		INNER  JOIN  acordos . acordoitem  AS  acordoitem  ON  ( acordo . ac16_sequencial = acordoitem . ac20_acordoposicao ) 
		INNER  JOIN  material . matunid  AS  matunid  ON  ( acordoitem . ac20_matunid = matunid . m61_codmatunid ) 
		INNER  JOIN  compras . pcmater  AS  pcmater  ON  ( pcmater . pc01_codmater = acordoitem . ac20_pcmater ) 
		WHERE  DATE_PART ( 'YEAR' , acordo . ac16_dataassinatura ) =".db_getsession("DB_anousu")."
		  AND  DATE_PART ( 'MONTH' , acordo . ac16_dataassinatura ) = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
		UNION 
		SELECT  '10'  AS  tipoRegistro , 
		       pcmater . pc01_codmater  AS  codItem , 
		       pcmater . pc01_descrmater  AS  dscItem , 
		       matunid . m61_abrev  AS  unidadeMedida , 
		       '1'  AS  tipoCadastro , 
		       ''  AS  justificativaAlteracao 
		FROM  empenho . empempenho  AS  empempenho 
		INNER  JOIN  empenho . empempitem  AS  empempitem  ON  ( empempenho . e60_numemp = empempitem . e62_numemp ) 
		INNER  JOIN  compras . pcmater  AS  pcmater  ON  ( pcmater . pc01_codmater = empempitem . e62_item ) 
		INNER  JOIN  empenho . empempaut  AS  empempaut  ON  ( empempenho . e60_numemp = empempaut . e61_numemp ) 
		INNER  JOIN  empenho . empautoriza  AS  empautoriza  ON  ( empempaut . e61_autori = empautoriza . e54_autori ) 
		INNER  JOIN  empenho . empautitem  AS  empautitem  ON  ( empautoriza . e54_autori = empautitem . e55_autori ) 
		INNER  JOIN  empenho . empautitempcprocitem  AS  empautitempcprocitem  ON  ( empautitem . e55_autori = empautitempcprocitem . e73_autori 
		                                                                    AND  empautitem . e55_sequen = empautitempcprocitem . e73_sequen ) 
		INNER  JOIN  compras . pcprocitem  AS  pcprocitem  ON  ( empautitempcprocitem . e73_pcprocitem = pcprocitem . pc81_codprocitem ) 
		INNER  JOIN  compras . solicitem  AS  solicitem  ON  ( pcprocitem . pc81_solicitem = solicitem . pc11_codigo ) 
		INNER  JOIN  compras . solicitemunid  AS  solicitemunid  ON  ( solicitem . pc11_codigo = solicitemunid . pc17_codigo ) 
		INNER  JOIN  material . matunid  AS  matunid  ON  ( solicitemunid . pc17_unid = matunid . m61_codmatunid ) 
		WHERE  DATE_PART ( 'YEAR' , empempenho . e60_emiss ) =".db_getsession("DB_anousu")."
		AND  DATE_PART ( 'MONTH' , empempenho . e60_emiss ) =" .$this->sDataFinal['5'].$this->sDataFinal['6']."";

		 $rsResult10 = db_query($sSql);
    
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
      
    	$clitem102021 = new cl_item102021();
    	$oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
    	
    	$sSqlitem="select si43_coditem,si43_unidademedida from item102021  where si43_coditem=".$oDados10->coditem." and si43_unidademedida='{$oDados10->unidademedida}'";
    	$rsResultitem = db_query($sSqlitem);
    	/**
    	 * verifica se já nao existe o registro  na base de dados do sicom
    	 */
        	 if(pg_num_rows($rsResultitem) == 0 ){
        	 	
		          $clitem102021->si43_tiporegistro           = 10;
				  $clitem102021->si43_coditem                = $oDados10->coditem;
				  $clitem102021->si43_dscItem                = addslashes($oDados10->dscitem);
				  $clitem102021->si43_unidademedida          = $oDados10->unidademedida;
				  $clitem102021->si43_tipocadastro           = $oDados10->tipocadastro;        
				  $clitem102021->si43_justificativaalteracao = $oDados10->justificativaalteracao;
				  $clitem102021->si43_instit		   				   = db_getsession("DB_instit");
				  $clitem102021->si43_mes                    = $this->sDataFinal['5'].$this->sDataFinal['6'];
				  
				  $clitem102021->incluir(null);
				  if ($clitem102021->erro_status == 0) {
				  	throw new Exception($clitem102021->erro_msg);
				  }
        	 }
    }
		
     db_fim_transacao();
    
    $oGerarItem = new GerarITEM();
    $oGerarItem->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarItem->gerarDados();
    
  }
  
}
