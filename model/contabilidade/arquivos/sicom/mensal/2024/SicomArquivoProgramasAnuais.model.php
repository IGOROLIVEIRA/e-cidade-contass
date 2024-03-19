<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * Programas Anuais Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoProgramasAnuais extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 180;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'INCPRO';
  
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
   *metodo para passar os dados dos programas pada o $this->aDados 
   */
  public function getCampos(){
    
    $aElementos = array(
                          "codPrograma",
                          "nomePrograma",
                          "objetivo",
                          "totRecursosAno",
                          "nroLei",
                          "dtLei",
                          "dtPublicacaoLei"
                        );

    return $aElementos;
  }
  
  /**
   * selecionar os dados dos programas para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
    
  	$sSql  = "SELECT * FROM db_config ";
    $sSql .= "	WHERE prefeitura = 't'";
    	
    $rsInst = db_query($sSql);
    $sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;

    $sSql = "SELECT  o58_programa as codPrograma,
	o54_descr as nomePrograma,
	o54_finali as objetivo,
	o47_valor as totRecursosAno,
	o138_numerolei as nroLei, 
	o138_data as dtLei,
	o138_data as dtPublicacaoLei	
	from orcprojetolei 
		join orcprojetoorcprojetolei on o139_orcprojetolei = o138_sequencial
		join orcsuplem on o46_codlei = o139_orcprojeto
		join orcsuplemval on o47_codsup = o46_codsup
		join orcdotacao on o47_coddot = o58_coddot 
			and o47_anousu = o58_anousu 
			and o58_valor = 0
		join orcprograma on o58_anousu = o54_anousu 
			and o58_programa = o54_programa
	where o138_data between '{$this->sDataInicial}' 
		and '$this->sDataFinal' and o47_valor > 0";
    $rsProgramas = db_query($sSql);
    
    /**
     * array para agrupar os dados pelo codigo do programa
     */
    $aDadosAgrupados = array();
    /**
     * percorrer registros retornados pelo Sql acima e passar para o array
     */
    for ($iCont = 0; $iCont < pg_num_rows($rsProgramas); $iCont++) {
    	
    	$oProgramas = db_utils::fieldsMemory($rsProgramas, $iCont);

    	$sHash = $oProgramas->codPrograma;
    	
    	if (!isset($aDadosAgrupados[$sHash])) {
    		
    		$aCaracteres = array(".","/","\");
	      $oDadosProgramas =  new stdClass();
	    	$oDadosProgramas->codPrograma     = str_pad($oProgramas->codprograma, 4, "0", STR_PAD_LEFT);
	    	$oDadosProgramas->nomePrograma    = substr($oProgramas->nomeprograma, 0, 100);
	    	$oDadosProgramas->objetivo        = substr($oProgramas->objetivo, 0, 230);
	    	$oDadosProgramas->totRecursosAno  = $oProgramas->totrecursosano;
	    	$oDadosProgramas->nroLei          = substr(str_replace($aCaracteres, "", $oProgramas->nrolei), 0, 6);
	    	$oDadosProgramas->dtLei           = implode("", array_reverse(explode("-", $oProgramas->dtlei)));
	    	$oDadosProgramas->dtPublicacaoLei = implode("", array_reverse(explode("-", $oProgramas->dtpublicacaolei)));
	    	
	    	$aDadosAgrupados[$sHash] = $oDadosProgramas;
    	
    	} else {
    		$aDadosAgrupados[$sHash]->totRecursosAno += $oProgramas->totrecursosano;
    	}
    	
    }
    /**
     * percorrer dados do array e passar para o array gerador do csv
     */
    foreach ($aDadosAgrupados as $oDados) {
    	
    	$oDados->totRecursosAno = number_format($oDados->totRecursosAno, 2, "", "");
    	$this->aDados[] = $oDados;
    	
    }
	    
  }
		
}
