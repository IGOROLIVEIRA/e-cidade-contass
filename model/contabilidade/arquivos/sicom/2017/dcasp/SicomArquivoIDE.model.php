<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_idedcasp2017_classe.php");
require_once("model/contabilidade/arquivos/sicom/2017/dcasp/geradores/GerarIDE.model.php");

/**
 * gerar arquivo de identificacao da Remessa Sicom Acompanhamento Mensal
 * @author gabriel
 * @package Contabilidade
 */
class SicomArquivoIdentificacaoRemessa extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  
  /**
   * Contrutor da classe
   */
  public function __construct() { }
  
  /**
   * selecionar os dados de indentificacao da remessa pra gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {
    
    /**
     * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
     */
    $clidedcasp = new cl_idedcasp2017();
    
    $sSql = " SELECT * "
          . " FROM db_config "
          . " WHERE codigo = " . db_getsession("DB_instit");
    
    $rsResult = db_query($sSql);
    
    /**
     * inserir informacoes no banco de dados
     */
    db_inicio_transacao();
    
    // passar o parâmetro correto para o sql_record()
    $result = $clidedcasp->sql_record();
    if (pg_num_rows($result) > 0) {
      
      // configurar o segundo parâmetro (o WHERE do DELETE)
      $clidedcasp->excluir(null, "");
      if ($clidedcasp->erro_status == 0) {
        throw new Exception($clidedcasp->erro_msg);
      }
      
    }
    
    for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {
      
      $clidedcasp = new cl_idedcasp2017();
      $oDadosIde = db_utils::fieldsMemory($rsResult, $iCont);
      
      $clidedcasp->si200_sequencial          = $oDadosIde->__algumAtributo;
      $clidedcasp->si200_codmunicipio        = $oDadosIde->__algumAtributo;
      $clidedcasp->si200_cnpjorgao           = $oDadosIde->__algumAtributo;
      $clidedcasp->si200_codorgao            = $oDadosIde->__algumAtributo;
      $clidedcasp->si200_tipoorgao           = $oDadosIde->__algumAtributo;
      $clidedcasp->si200_tipodemcontabil     = $oDadosIde->__algumAtributo;
      $clidedcasp->si200_exercicioreferencia = $oDadosIde->__algumAtributo;
      $clidedcasp->si200_datageracao         = $oDadosIde->__algumAtributo;
      $clidedcasp->si200_codcontroleremessa  = $oDadosIde->__algumAtributo;
  
  
      $clidedcasp->incluir(null);
      if ($clidedcasp->erro_status == 0) {
        throw new Exception($clidedcasp->erro_msg);
      }
      
    }
    
    db_fim_transacao();
    
    $oGerarIde = new GerarIDE();
    $oGerarIde->gerarDados();
    
  }
  
}
