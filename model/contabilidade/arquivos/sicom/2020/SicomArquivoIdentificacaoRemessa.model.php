<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_ide2020_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarIDE.model.php");

/**
 * gerar arquivo de identificacao da Remessa Sicom Acompanhamento Mensal
 * @author Gabriel
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
    $aElementos = array("codMunicipio", "cnpjMunicipio", "codOrgao", "tipoOrgao", "exercicioReferenciaLOA",
		"exercicioInicialPPA", "exercicioFinalPPA", "opcaoSemestralidade", "contaUnicaTesouMunicipal", "nroLeiCute",
		"dataLeiCute", "dataGeracao", "codControleRemessa");

	//    "opcaoSemestralidade", "contaUnicaTesouMunicipal"
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
    $cl_ide2020 = new cl_ide2020();

    $sSql = "SELECT db21_codigomunicipoestado AS codmunicipio,
                cgc AS cnpjmunicipio,
                si09_tipoinstit AS tipoorgao,
                si09_codorgaotce AS codorgao,
                si09_opcaosemestralidade AS opcaosemestralidade,
                prefeitura
              FROM db_config
              LEFT JOIN infocomplementaresinstit ON si09_instit = codigo
              WHERE codigo = " . db_getsession("DB_instit");
    $rsResult = db_query($sSql);

    /**
     * inserir informacoes no banco de dados
     */
    db_inicio_transacao();
    $result = $cl_ide2020->sql_record($cl_ide2020->sql_query(null, "*", null, "si11_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si11_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $cl_ide2020->excluir(null, "si11_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si11_instit = " . db_getsession("DB_instit"));
      if ($cl_ide2020->erro_status == 0) {
        throw new Exception($cl_ide2020->erro_msg);
      }
    }

    for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

      $cl_ide2020 = new cl_ide2020();
      $oDadosIde = db_utils::fieldsMemory($rsResult, $iCont);

      $cl_ide2020->si11_codmunicipio = $oDadosIde->codmunicipio;
      $cl_ide2020->si11_cnpjmunicipio = $oDadosIde->cnpjmunicipio;
      $cl_ide2020->si11_codorgao = $oDadosIde->codorgao;
      $cl_ide2020->si11_tipoorgao = $oDadosIde->tipoorgao;
      $cl_ide2020->si11_exercicioReferenciaLOA = "";
	  $cl_ide2020->si11_exercicioInicialPPA = "";
	  $cl_ide2020->si11_exercicioFinalPPA = "";
	  $cl_ide2020->si11_opcaoSemestralidade = $oDadosIde->opcaosemestralidade;
	  $cl_ide2020->si11_contaUnicaTesouMunicipal = "";
	  $cl_ide2020->si11_nroLeiCute = "";
	  $cl_ide2020->si11_dataLeiCute = date("d-m-Y");
	  $cl_ide2020->si11_datageracao = date("d-m-Y");
	  $cl_ide2020->si11_codcontroleremessa = " ";
	  $cl_ide2020->si11_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
	  $cl_ide2020->si11_instit = db_getsession("DB_instit");

      $cl_ide2020->incluir(null);
      if ($cl_ide2020->erro_status == 0) {
        throw new Exception($cl_ide2020->erro_msg);
      }


    }

    db_fim_transacao();

    $oGerarIde = new GerarIDE();
    $oGerarIde->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarIde->gerarDados();

  }

}
