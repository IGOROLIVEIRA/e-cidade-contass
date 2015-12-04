<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * detalhamento dos empenhos do mês Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoEmpenhosAnuladosMes extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 167;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'ANL';
  
  /**
   * 
   * Construtor da classe
   */
  public function __construct() {
    
  }
  
  /**
	 * Retorna o codigo do layout
	 *
	 * @return Integer
	 */
  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV 
   */
  public function getCampos(){
    
    $aElementos[10] = array(
                          "tipoRegistro",
                          "codOrgao",
                          "codUnidadeSub",
                          "nroEmpenho",
                          "dtEmpenho",
                          "dtAnulacao",
                          "nroAnulacao",
                          "tipoAnulacao",
    											"especAnulacaoEmpenho",
    											"vlAnulacao"
                        );
    $aElementos[11] = array(
                          "tipoRegistro",
                          "codUnidadeSub",
                          "nroEmpenho",
    											"nroAnulacao",
                          "codFontRecursos",
    											"vlAnulacaoFonte"
                        );                        
    $aElementos[20] = array(
                          "tipoRegistro",
                          "codUnidade",
                          "nroEmpenho",
    											"nroAnulacao",
                          "tipoDocumento",
    											"cpfCnpjCredor",
    											"nomeCredor",
    											"vlAssociadoCredor"
                        );
    return $aElementos;
  }
  
  /**
   * selecionar os dados dos empenhos do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
          
    $sSql  = "SELECT * FROM db_config ";
		$sSql .= "	WHERE prefeitura = 't'";
    	
    $rsInst = db_query($sSql);
    $sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;
      
  	/**
  	 * selecionar arquivo xml com dados dos orgão
  	 */
    $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomorgao.xml";
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuração dos orgãos do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oOrgaos      = $oDOMDocument->getElementsByTagName('orgao');
    
    /**
     * percorrer os orgaos retornados do xml para selecionar o orgao da inst logada
     * para selecionar os dados da instit
     */
    foreach ($oOrgaos as $oOrgao) {
      
    	if ($oOrgao->getAttribute('instituicao') == db_getsession("DB_instit")) {
    		
        $sOrgao           = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
        $sTrataCodUnidade = $oOrgao->getAttribute('trataCodUnidade');
        
    	}
    	
    }
  
    if (!isset($oOrgao)) {
      throw new Exception("Arquivo sem configuração de Orgãos.");
    }
    
    $sSql  = "SELECT e94_codanu, e94_data, e94_motivo, e94_empanuladotipo, e94_numemp, e94_valor, e60_codemp, e60_emiss, o58_orgao, o58_unidade,
o15_codtri
from empanulado 
	join empempenho on e94_numemp = e60_numemp 
	join orcdotacao on o58_coddot = e60_coddot
	join orctiporec on o58_codigo = o15_codigo 
	join emptipo on e60_codtipo = e41_codtipo 
where e94_data >= '".$this->sDataInicial."' and e94_data <= '".$this->sDataFinal."' and e60_anousu = ".db_getsession("DB_anousu")." 
and o58_anousu = ".db_getsession("DB_anousu")." 
and o58_instit = ".db_getsession("DB_instit"); 
    
    $rsEmpenho = db_query($sSql);
    /**
     * percorrer registros retornados do sql acima para passar os dados para o array dos registros a serem gerados
     */
    for ($iCont = 0; $iCont < pg_num_rows($rsEmpenho); $iCont++) {
    	
    	$oEmpenho = db_utils::fieldsMemory($rsEmpenho,$iCont);
    	
    	if ($oEmpenho->e94_empanuladotipo == 1) {
    		$sTipoAnulacao = 2;
    	} else {
    		$sTipoAnulacao = 1;
    	}
    	
      if ($sTrataCodUnidade == "01") {
      		
        $sCodUnidade					  = str_pad($oEmpenho->o58_orgao, 2, "0", STR_PAD_LEFT);
	   		$sCodUnidade					 .= str_pad($oEmpenho->o58_unidade, 3, "0", STR_PAD_LEFT);
	   		  
      } else {
      		
        $sCodUnidade					  = str_pad($oEmpenho->o58_orgao, 3, "0", STR_PAD_LEFT);
	   	  $sCodUnidade					 .= str_pad($oEmpenho->o58_unidade, 2, "0", STR_PAD_LEFT);
      		
      }
    	
    	$oDadosEmpenho = new stdClass();

    	$oDadosEmpenho->tipoRegistro         = 10;
    	$oDadosEmpenho->detalhesessao        = 10;
    	$oDadosEmpenho->codOrgao             = $sOrgao;
    	$oDadosEmpenho->codUnidadeSub        = $sCodUnidade;
	    $oDadosEmpenho->nroEmpenho           = substr($oEmpenho->e60_codemp, 0, 22);
	    $oDadosEmpenho->dtEmpenho            = implode(array_reverse(explode("-", $oEmpenho->e60_emiss)));
	    $oDadosEmpenho->dtAnulacao           = implode(array_reverse(explode("-", $oEmpenho->e94_data)));
	    $oDadosEmpenho->nroAnulacao          = substr($oEmpenho->e94_codanu, 0, 9);
	    $oDadosEmpenho->tipoAnulacao         = $sTipoAnulacao;
	    $oDadosEmpenho->especAnulacaoEmpenho = utf8_decode(substr($oEmpenho->e94_motivo, 0, 200));
	    $oDadosEmpenho->vlAnulacao      		 = number_format($oEmpenho->e94_valor, 2, "", "");
	    
	    $this->aDados[] = $oDadosEmpenho;
    	
	    /**
	     * dados registro 11
	     */
	    $oDadosEmpenhoFonte = new stdClass();
	    
	    $oDadosEmpenhoFonte->tipoRegistro    = 11;
	    $oDadosEmpenhoFonte->detalhesessao   = 11;
	    $oDadosEmpenhoFonte->codUnidadeSub   = $sCodUnidade;
	    $oDadosEmpenhoFonte->nroEmpenho      = substr($oEmpenho->e60_codemp, 0, 22);
	    $oDadosEmpenhoFonte->nroAnulacao     = substr($oEmpenho->e94_codanu, 0, 9);
	    $oDadosEmpenhoFonte->codFontRecursos = substr($oEmpenho->o15_codtri, 0, 3);
	    $oDadosEmpenhoFonte->vlAnulacaoFonte = number_format($oEmpenho->e94_valor, 2, "", "");
	    
	    $this->aDados[] = $oDadosEmpenhoFonte;
	    
    }
    
  }
  
  function trataString($sub){
    $acentos = array(
        'À','Á','Ã','Â', 'à','á','ã','â',
        'Ê', 'É',
        'Í', 'í', 
        'Ó','Õ','Ô', 'ó', 'õ', 'ô',
        'Ú','Ü',
        'Ç', 'ç',
        'é','ê', 
        'ú','ü',
        );
    $remove_acentos = array(
        'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
        'e', 'e',
        'i', 'i',
        'o', 'o','o', 'o', 'o','o',
        'u', 'u',
        'c', 'c',
        'e', 'e',
        'u', 'u',
        );
    return str_replace($acentos, $remove_acentos, urldecode($sub));
}
  
  
}