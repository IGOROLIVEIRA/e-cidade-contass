<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_ide2021_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2021/GerarIDE.model.php");

/**
 * gerar arquivo de identificacao da Remessa Sicom Acompanhamento Mensal
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoIdentificacaoRemessa extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  
  /**
   *
   * Codigo do layout. (db_layouttxt.db50_codigo)
   * @var Integer
   */
  protected $iCodigoLayout = 147;
  
  /**
   *
   * NOme do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'IDE';
  
  /**
   *
   * Contrutor da classe
   */
  public function __construct()
  {
    
  }
  
  /**
   * Retorna o codigo do layout
   *
   * @return Integer
   */
  public function getCodigoLayout()
  {
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   */
  public function getCampos()
  {

    $aElementos = array(
      "codMunicipio",
      "cnpjMunicipio",
      "codOrgao",
      "tipoOrgao",
      "exercicioReferencia",
      "mesReferencia",
      "dataGeracao",
      "codControleRemessa"
    );

    return $aElementos;
  }
  
  /**
   * selecionar os dados de indentificacao da remessa pra gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {

    /**
     * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
     */
    $clide = new cl_ide2021();

    $sSql = "SELECT db21_codigomunicipoestado AS codmunicipio,
                case when si09_tipoinstit::varchar = '2' then cgc::varchar else si09_cnpjprefeitura::varchar end AS cnpjmunicipio,
                si09_tipoinstit AS tipoorgao,
                si09_codorgaotce AS codorgao,
                prefeitura
              FROM db_config
              LEFT JOIN infocomplementaresinstit ON si09_instit = " . db_getsession("DB_instit") . "
              WHERE codigo = " . db_getsession("DB_instit");

    $rsResult = db_query($sSql);
    
    /**
     * inserir informacoes no banco de dados
     */
    db_inicio_transacao();
    $result = $clide->sql_record($clide->sql_query(null, "*", null, "si11_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si11_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clide->excluir(null, "si11_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si11_instit = " . db_getsession("DB_instit"));
      if ($clide->erro_status == 0) {
        throw new Exception($clide->erro_msg);
      }
    }
    
    for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {
      
      $clide = new cl_ide2021();
      $oDadosIde = db_utils::fieldsMemory($rsResult, $iCont);

      $clide->si11_codmunicipio = $oDadosIde->codmunicipio;
      $clide->si11_cnpjmunicipio = $oDadosIde->cnpjmunicipio;
      $clide->si11_codorgao = $oDadosIde->codorgao;
      $clide->si11_tipoorgao = $oDadosIde->tipoorgao;
      $clide->si11_exercicioreferencia = db_getsession("DB_anousu");
      $clide->si11_mesreferencia = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clide->si11_datageracao = date("d-m-Y");
      $clide->si11_codcontroleremessa = " ";
      $clide->si11_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clide->si11_instit = db_getsession("DB_instit");


      $clide->incluir(null);
      if ($clide->erro_status == 0) {
        throw new Exception($clide->erro_msg);
      }

    }
    
    db_fim_transacao();
    
    $oGerarIde = new GerarIDE();
    $oGerarIde->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarIde->gerarDados();
    
  }
  
}
