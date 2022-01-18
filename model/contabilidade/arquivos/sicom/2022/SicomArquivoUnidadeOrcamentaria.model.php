<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

/**
 * selecionar dados Unidade Orcamentaria Sicom Instrumento de Planejamento
 * @package Contabilidade
 */
class SicomArquivoUnidadeOrcamentaria extends SicomArquivoBase implements iPadArquivoBaseCSV
{

  protected $iCodigoLayout = 140;

  protected $sNomeArquivo = 'UOC';

  protected $iCodigoPespectiva;

  public function __construct()
  {

  }

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
      "codOrgao",
      "codUnidadeSub",
      "idFundo",
      "descUnidadeSub",
      "eSubUnidade"
    );

    return $aElementos;
  }

  public function gerarDados()
  {


    $sSqlUnidade = "select distinct o41_unidade,o41_ident,o41_orgao,o41_codtri,o41_descr,si09_codorgaotce from orcunidade ";
    $sSqlUnidade .= " inner join db_config on codigo = o41_instit inner join infocomplementaresinstit on si09_instit = codigo ";
    $sSqlUnidade .= "WHERE o41_anousu = " . db_getsession("DB_anousu") . " and db21_ativo = 1 ";

    $rsUnidade = db_query($sSqlUnidade);

    for ($iCont = 0; $iCont < pg_num_rows($rsUnidade); $iCont++) {

      $oUnidade = db_utils::fieldsMemory($rsUnidade, $iCont);
      $oDadosUOC = new stdClass();

      $iTipoUnidade = " ";
      if ($oUnidade->o41_ident[0] == '9') {
        $iTipoUnidade = $oUnidade->o41_ident[1] . $oUnidade->o41_ident[2];
      } else {
        $iTipoUnidade = " ";
      }

      $rsCodTriUnid = db_query("select o41_codtri from orcunidade
		    		where o41_unidade = " . $oUnidade->o41_unidade . "
		    		  and o41_orgao = " . $oUnidade->o41_orgao . "
		    	      and o41_anousu = " . db_getsession("DB_anousu"));
      $oCodTriUnid = db_utils::fieldsMemory($rsCodTriUnid, 0);

      if ($oCodTriUnid->o41_codtri == 0) {
        $unidade = $oUnidade->o41_unidade;
      } else {
        $unidade = $oCodTriUnid->o41_codtri;
      }

      $rsCodTriOrg = db_query("select o40_codtri from orcorgao where o40_orgao = " . $oUnidade->o41_orgao . "
		    	and o40_anousu = " . db_getsession("DB_anousu"));
      $oCodTriOrg = db_utils::fieldsMemory($rsCodTriOrg, 0);

      if ($oCodTriOrg->o40_codtri == 0) {
        $org = $oUnidade->o41_orgao;
      } else {
        $org = $oCodTriOrg->o40_codtri;
      }

      $oDadosUOC->codOrgao        = str_pad($oUnidade->si09_codorgaotce, 2, "0", STR_PAD_LEFT);
      $oDadosUOC->codUnidadeSub   = str_pad($org, 2, "0", STR_PAD_LEFT);
      $oDadosUOC->codUnidadeSub   .= str_pad($unidade, 3, "0", STR_PAD_LEFT);
      $oDadosUOC->idFundo         = $iTipoUnidade;
      $oDadosUOC->descUnidadeSub  = substr($oUnidade->o41_descr, 0, 50);
      $oDadosUOC->eSubUnidade = 2;

      $this->aDados[] = $oDadosUOC;
    }


  }

  public function setCodigoPespectiva($iCodigoPespectiva)
  {
    $this->iCodigoPespectiva = $iCodigoPespectiva;
  }

  public function getCodigoPespectiva()
  {
    return $this->iCodigoPespectiva;
  }
}
