<?php
require_once ('interfaces/PadArquivoBase.interface.php');
interface iPadArquivoBaseCSV extends iPadArquivoBase {
  
  /**
   * Retorna o codigo do layout a ser usado
   * @return Integer
   */
  public function getCodigoLayout();
  
  /**
   * Retorna o nome do arquivo a ser gerado
   * @return String
   */
  public function getNomeARquivo();
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV 
   */
  public function getCampos();
  
}