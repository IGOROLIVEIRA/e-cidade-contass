<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

/**
 * selecionar dados de Orgaos Sicom Instrumento de Planejamento
 * @package Contabilidade
 */
class SicomArquivoOrgao extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  
  protected $iCodigoLayout = 106;
  
  protected $sNomeArquivo = 'ORGAO';
  
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
    
    $aElementos = array("codOrgao", "cpfGestor", "tipoOrgao");
    
    return $aElementos;
  }
  
  public function gerarDados()
  {
    
    $sSql = "SELECT db21_codigomunicipoestado,cgc,prefeitura,si09_codorgaotce,si09_opcaosemestralidade,si09_tipoinstit,z01_cgccpf  ";
    $sSql .= " FROM db_config left join infocomplementaresinstit on si09_instit = codigo left join cgm on si09_gestor = z01_numcgm ;";
    
    $rsInst = db_query($sSql);
    
    
    for ($iCont = 0; $iCont < pg_num_rows($rsInst); $iCont++) {
      
      $oOrgao = db_utils::fieldsMemory($rsInst, $iCont);
      
      $oDadosOrgao = new stdClass();
      $oDadosOrgao->codOrgao  = str_pad($oOrgao->si09_codorgaotce, 2, "0", STR_PAD_LEFT);
      $oDadosOrgao->cpfGestor = str_pad($oOrgao->z01_cgccpf, 11, "0", STR_PAD_LEFT);
      $oDadosOrgao->tipoOrgao = str_pad($oOrgao->si09_tipoinstit, 2, "0", STR_PAD_LEFT);
      $this->aDados[] = $oDadosOrgao;
      
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
