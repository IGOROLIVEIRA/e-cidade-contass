<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarOBELAC.model.php");

 /**
  * Outras Baixas de Empenhos por Lançamento Contábil Sicom Acompanhamento Mensal
  * @author Marcelo
  * @package Contabilidade
  */
class SicomArquivoOutrasBaixasEmpenhos extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 192;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'OBELAC';
  
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
    
  }
  
  /**
   * selecionar os dados
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {

    $oGerarOBELAC = new GerarOBELAC();
    $oGerarOBELAC->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarOBELAC->gerarDados();
  
  }
		
 }
