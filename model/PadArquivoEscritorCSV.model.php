<?php
require_once ('model/PadArquivoEscritor.model.php');

class padArquivoEscritorCSV extends PadArquivoEscritor {
  
  /**
   * 
   */
  function __construct() {

  }
  
  /**
   * Transforma os dados passados para CSV 
   * @param iPadArquivoBase $oArquivo
   * @return caminho do Arquivo 
   */
  public function criarArquivo(iPadArquivoBaseCSV $oArquivo) {
    
    require_once ("dbforms/db_layouttxt.php");
    $sCaminhoArquivo = "".$oArquivo->getNomeArquivo().".csv";
    $aDetalhesGerar  = array();
    foreach ($oArquivo->getCampos() as $key => $aCampo) {
      
      if ($key > 0) {
        $aDetalhesGerar[] = $key;
      }
    }
    $sDetalhes = implode(" ", $aDetalhesGerar);
    $oLayout   = new db_layouttxt($oArquivo->getCodigoLayout(), $sCaminhoArquivo, $sDetalhes);
    $aDados = $oArquivo->getDados();
    foreach ($aDados as $oDados) {
      
      $oCampos = $oArquivo->getCampos();
      $oLayout->setCampoTipoLinha(3);
      if (isset($oDados->detalhesessao)) {
        
        $oCampos = $oCampos[$oDados->detalhesessao];
        $oLayout->setCampoIdentLinha($oDados->detalhesessao);
      }
      foreach ($oCampos as $sCampo) {
        
      	if ($oDados->$sCampo == "") {
      		$oDados->$sCampo = " ";
      	}
        $oLayout->setCampo($sCampo, $oDados->$sCampo);
      }
      $oLayout->geraDadosLinha();
    }
    $sNomeArquivo = "{$oArquivo->getNomeArquivo()}.{$oArquivo->getOutput()}";
    return $sNomeArquivo;  
  }
}