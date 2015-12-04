<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * Anulações de Outras Baixas de Empenhos por Lançamento Contábil Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoAnulacoesOutrasBaixasEmpenhos extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 193;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'AOB';
  
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
                          "codReduzido",
                          "codOrgao",
                          "codUnidadeSub",
                          "nroLancamento",
                          "dtLancamento",
    											"nroAnulacaoLancamento",
    											"dtAnulacaoLancamento",
                          "tipoLancamento",
                          "nroEmpenho",
    											"dtEmpenho",
                          "nroLiquidacao",
     				      				"dtLiquidacao",
                          "valorAnulacaoLancamento"
                        );
    $aElementos[11] = array(
                          "tipoRegistro",
                          "codReduzido",
                          "codFontRecursos",
                          "valorAnulacaoFonte"
                        );
    return $aElementos;
  }
  
  /**
   * selecionar os dados
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
  
  }
		
}
