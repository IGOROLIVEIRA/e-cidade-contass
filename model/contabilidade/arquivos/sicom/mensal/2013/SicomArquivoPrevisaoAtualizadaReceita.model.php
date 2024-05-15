<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
/**
 * 
 * selecionar dados de Previsão Atualizada da Receita
 * @author Marcelo
 * @package Contabilidade
 */
class SicomArquivoPrevisaoAtualizadaReceita extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * Código do layout. (db_layouttxt.db50_codigo)
	 *
	 * @var Integer
	 */
  protected $iCodigoLayout = 194;

  /**
	 * Nome do arquivo a ser criado
	 *
	 * @var String
	 */
  protected $sNomeArquivo = 'PAREC';
  
  /**
	 * Código da Pespectiva. (ppaversao.o119_sequencial)
	 *
	 * @var Integer
	 */
  protected $iCodigoPespectiva;
  
  /**
   * 
   * Construtor da classe
   */
  public function __construct() {
    
  }
  
  /**
   * retornar o codio do layout
   * 
   *@return Integer
   */
  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV 
   *
   *@return Array
   */
  public function getCampos(){
    
    $aElementos[10] = array(
                          "tipoRegistro",
    											"codReceita",
                          "codOrgao",
    											"identificadorDeducao",
    											"rubrica",
    											"tipoAtualizacao",
    											"especificacao",
    											"vlPrevisto"
                        );
    $aElementos[11] = array(
                          "tipoRegistro",
    											"codReceita",
    											"codFonte",
    											"vlFonte"
                        );
    return $aElementos;
  }
  
  /**
   * Gerar os dados necessários para o arquivo
   *
   */
  public function gerarDados(){
  	
 
  }
  
  /**
   * 
   * passar valor para o $this->iCodigoPespectiva
   * @param Integer $iCodigoPespectiva
   */
  public function setCodigoPespectiva($iCodigoPespectiva) {
    $this->iCodigoPespectiva = $iCodigoPespectiva;
  }
  
  /**
   * 
   * retornar o valor do $this->iCodigoPespectiva
   * @return Integer
   */
  public function getCodigoPespectiva() {
    return $this->iCodigoPespectiva;
  }
}