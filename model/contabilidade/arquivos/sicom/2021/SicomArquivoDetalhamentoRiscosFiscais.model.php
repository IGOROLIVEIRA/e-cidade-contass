<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

class SicomArquivoDetalhamentoRiscosFiscais extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  
  protected $iCodigoLayout = 144;
  
  protected $sNomeArquivo = 'RFIS';
  
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
    
    $aElementos[10] = array(
      "tipoRegistro",
      "codRF",
      "codOrgao",
      "exercicio",
      "codRiscoFiscal",
      "dscRiscoFiscal",
      "vlRiscoFiscal"
    );
    
    $aElementos[11] = array(
      "tipoRegistro",
      "codRF",
      "codProvidencia",
      "dscProvidencia",
      "vlAssociadoProvidencia"
    );
    
    return $aElementos;
  }
  
  public function gerarDados()
  {
    
    $sqlRiscos = "select * from riscofiscal where si53_codigoppa = {$this->iCodigoPespectiva}";
    
    $rsRiscos = db_query($sqlRiscos);
    
    for ($iContador = 0; $iContador < pg_num_rows($rsRiscos); $iContador++) {
      
      $oRisco = db_utils::fieldsMemory($rsRiscos, $iContador);
      
      
      $oDadosRiscos = new stdClass();
      $oDadosRiscos->tipoRegistro   = 10;
      $oDadosRiscos->detalhesessao  = 10;
      $oDadosRiscos->codRF          = substr($oRisco->si53_sequencial, 0, 15);//verificar se vai pegar os numeros a partir da direita ou esquerda
      $oDadosRiscos->codOrgao       = " ";//str_pad($oInstit->si09_codorgaotce, 2, "0", STR_PAD_LEFT);
      $oDadosRiscos->exercicio      = str_pad($oRisco->si53_exercicio, 4, "0", STR_PAD_LEFT);
      $oDadosRiscos->codRiscoFiscal = str_pad($oRisco->si53_codriscofiscal, 2, "0", STR_PAD_LEFT);
      $oDadosRiscos->dscRiscoFiscal = substr($oRisco->si53_dscriscofiscal, 0, 500);
      $oDadosRiscos->vlRiscoFiscal  = number_format($oRisco->si53_valorisco, 2, "", "");
      
      $this->aDados[] = $oDadosRiscos;
      
      $sqlProvidencias = "select * from riscoprovidencia where si54_seqriscofiscal = " . $oRisco->si53_sequencial;
      
      $rsProvidencias = db_query($sqlProvidencias);
      
      for ($iContador = 0; $iContador < pg_num_rows($rsProvidencias); $iContador++) {
        
        $oProvidencia = db_utils::fieldsMemory($rsProvidencias, $iContador);
        
        $oDadosProvidencias = new stdClass();
        $oDadosProvidencias->tipoRegistro   = 11;
        $oDadosProvidencias->detalhesessao  = 11;
        $oDadosProvidencias->codRF          = substr($oProvidencia->si54_seqriscofiscal, 0, 15);
        $oDadosProvidencias->codProvidencia = substr($oProvidencia->si54_sequencial, 0, 6);
        $oDadosProvidencias->dscProvidencia = substr($oProvidencia->si54_dscprovidencia, 0, 50);
        $oDadosProvidencias->vlAssociadoProvidencia = number_format($oProvidencia->si54_valorassociado, 2, ",", "");
        
        $this->aDados[] = $oDadosProvidencias;
        
      }
      
    }
    
    if (empty($this->aDados)) {
      $oDadosRiscos = 99;
      $this->aDados[] = $oDadosRiscos;
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
