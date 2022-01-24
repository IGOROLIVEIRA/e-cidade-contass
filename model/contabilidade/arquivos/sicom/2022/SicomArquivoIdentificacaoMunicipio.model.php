<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

/**
 * selecionar dados de Idetificacao do Municipio Sicom Instrumento de Planejamento
 * @author gabriel
 * @package Contabilidade
 */
class SicomArquivoIdentificacaoMunicipio extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  
  /**
   *
   * Codigo do layout
   * @var Integer
   */
  protected $iCodigoLayout = 105;
  
  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'IDE';
  
  /**
   * Código da Pespectiva. (ppaversao.o119_sequencial)
   *
   * @var Integer
   */
  protected $iCodigoPespectiva;
  
  /**
   *
   * Contrutor da classe
   */
  public function __construct()
  {
    
  }
  
  /**
   * retornar o codio do layout
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
      "exercicioReferenciaLOA",
      "exercicioInicialPPA",
      "exercicioFinalPPA",
      "opcaoSemestralidade",
      "contaUnicaTesouMunicipal",
	  "nroLeiCute",
	  "dataLeiCute",
      "dataGeracao",
      "codControleRemessa"

    );

    return $aElementos;
  }
  
  /**
   * selecionar os dados do municipio para serem gravados no arquivo a ser gerado
   * no sicom anual somente envia neste arquivo o orgao prefeitura por definicao do tce-mg
   */
  public function gerarDados()
  {
    require_once("model/ppaVersao.model.php");
    
    $oPPAVersao = new ppaVersao($this->getCodigoPespectiva());
    
    
    /**
     * Realizar a seleção dos dados de cada orgao retornado
     **/
    $sSql = "SELECT db21_codigomunicipoestado,cgc,prefeitura,si09_codorgaotce,si09_opcaosemestralidade,si09_tipoinstit, 
			 si09_nroleicute, si09_dataleicute, si09_contaunicatesoumunicipal FROM db_config join infocomplementaresinstit on si09_instit = codigo ";
    $sSql .= "	WHERE prefeitura = 't'";

	$rsInst = db_query($sSql);
	$oInst = db_utils::fieldsMemory($rsInst, 0);

    $oDadosMunicipio = new stdClass();
    
    $oDadosMunicipio->codMunicipio            = str_pad($oInst->db21_codigomunicipoestado, 5, "0", STR_PAD_LEFT);
    $oDadosMunicipio->cnpjMunicipio           = str_pad($oInst->cgc, 14, "0", STR_PAD_LEFT);
    $oDadosMunicipio->codOrgao                = str_pad($oInst->si09_codorgaotce, 2, "0", STR_PAD_LEFT);
    $oDadosMunicipio->tipoOrgao               = str_pad($oInst->si09_tipoinstit, 2, "0", STR_PAD_LEFT);
    $oDadosMunicipio->exercicioReferenciaLOA  = db_getsession("DB_anousu");
    $oDadosMunicipio->exercicioInicialPPA     = $oPPAVersao->getAnoinicio();
    $oDadosMunicipio->exercicioFinalPPA       = $oPPAVersao->getAnofim();
    $oDadosMunicipio->opcaoSemestralidade     = str_pad($oInst->si09_opcaosemestralidade, 1, "0", STR_PAD_LEFT);

    if($oInst->si09_nroleicute != null){
		$oDadosMunicipio->nroLeiCute		  = $oInst->si09_nroleicute;
	}else $oDadosMunicipio->nroLeiCute		  = "";

    if($oInst->si09_dataleicute != null){
		$oDadosMunicipio->dataLeiCute		  = str_pad(str_replace('-', '', date('d-m-Y', strtotime($oInst->si09_dataleicute))), 8, "0", STR_PAD_LEFT);//implode(explode("-", date("d-m-Y", strtotime($oInst->si09_dataleicute))));
	}else $oDadosMunicipio->dataLeiCute		  = "";

	if($oInst->si09_nroleicute != null && $oInst->si09_dataleicute != null){
	  $oDadosMunicipio->contaUnicaTesouMunicipal = '1';
	}else $oDadosMunicipio->contaUnicaTesouMunicipal = '2';
	$oDadosMunicipio->dataGeracao             = implode(explode("-", date("d-m-Y")));
	$oDadosMunicipio->codControleRemessa      = "";
    $this->aDados[] = $oDadosMunicipio;

  }
  
  /**
   *
   * passar valor para o $this->iCodigoPespectiva
   * @param Integer $iCodigoPespectiva
   */
  public function setCodigoPespectiva($iCodigoPespectiva)
  {
    $this->iCodigoPespectiva = $iCodigoPespectiva;
  }
  
  /**
   *
   * retornar o valor do $this->iCodigoPespectiva
   * @return Integer
   */
  public function getCodigoPespectiva()
  {
    return $this->iCodigoPespectiva;
  }
}
