<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_arc10$PROXIMO_ANO_classe.php");
require_once ("classes/db_arc11$PROXIMO_ANO_classe.php");
require_once ("classes/db_arc12$PROXIMO_ANO_classe.php");
require_once ("classes/db_arc20$PROXIMO_ANO_classe.php");
require_once ("classes/db_arc21$PROXIMO_ANO_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarARC.model.php");

 /**
  * detalhamento das correcoes das receitas do mes Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoDetalhamentoCorrecoesReceitas extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 150;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'ARC';
  
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
    
    $aElementos[10] = array(
	                          "tipoRegistro",
	                          "codOrgao",
	                          "identificadorDeducaoRecDeduzida",
	                          "rubricaDeduzida",
	                          "codFonteDeduzida",
	                          "especificacaoDeduzida",
	                          "identificadorDeducaoRecAcrescida",
	                          "rubricaAcrescida",
						    					  "codFonteAcrescida",
						    					  "especificacaoAcrescida",
						    					  "vlDeduzidoAcrescido"	
                        );
    $aElementos[20] = array(
	                          "tipoRegistro",
	                          "codOrgao",
	                          "identificadorDeducao",
	                          "rubricaEstornada",
							    					"codFonteEstornada",
							    					"especificacaoEstornada",
							    					"vlEstornado"
                        );
    return $aElementos;
  }
  
  /**
   * selecionar os dados de detalhamente das correcoes receitas do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
    
  	$oGerarARC = new GerarARC();
  	$oGerarARC->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
  	$oGerarARC->gerarDados();
  
  }
		
}
