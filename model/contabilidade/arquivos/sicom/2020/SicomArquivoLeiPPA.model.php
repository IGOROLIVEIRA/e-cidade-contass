<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

class SicomArquivoLeiPPA extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  
  protected $iCodigoLayout = 107;
  
  protected $sNomeArquivo = 'LPP';
  
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
      "nroLeiPPA",
      "dataLeiPPA",
      "dataPubLeiPPA",
      "nroLeiAlteracao",
      "dataLeiAlteracao",
      "dataPubLeiAlt"
    );
    
    return $aElementos;
  }
  
  public function gerarDados()
  {
    require_once("model/ppaVersao.model.php");
    
    $oPPAVersao = new ppaVersao($this->getCodigoPespectiva());
    
    $oDadosPPA = new stdClass();
    
    $sSqlPPA = "SELECT * ";
    $sSqlPPA .= "FROM ppaleidadocomplementar ";
    $sSqlPPA .= "	WHERE o142_ppalei = {$oPPAVersao->getCodigolei()}";
    $rsPPAlei = db_query($sSqlPPA);
    
    if (pg_num_rows($rsPPAlei) == 0) {
      throw new Exception("Não existe PPA lançado.", 4);
    }
    $oPPAlei = db_utils::fieldsMemory($rsPPAlei, 0);
    
    $oDadosPPA->nroLeiPPA         = substr($oPPAlei->o142_numeroleippa, 0, 6);
    $oDadosPPA->dataLeiPPA        = implode(array_reverse(explode("-", $oPPAlei->o142_dataleippa)));
    $oDadosPPA->dataPubLeiPPA     = implode(array_reverse(explode("-", $oPPAlei->o142_datapublicacaoppa)));
    $oDadosPPA->nroLeiAlteracao   = substr($oPPAlei->o142_leialteracaoppa, 0, 6);
    $oDadosPPA->dataLeiAlteracao  = implode(array_reverse(explode("-", $oPPAlei->o142_dataalteracaoppa)));
    $oDadosPPA->dataPubLeiAlt     = implode(array_reverse(explode("-", $oPPAlei->o142_datapubalteracao)));
    $this->aDados[] = $oDadosPPA;
    
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
