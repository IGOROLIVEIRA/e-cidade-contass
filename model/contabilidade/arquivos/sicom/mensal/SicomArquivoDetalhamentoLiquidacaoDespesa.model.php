<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * Detalhamento da liquidação da despesa Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoDetalhamentoLiquidacaoDespesa extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 169;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'LQD';
  
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
    											"codReduzido",
                          "codOrgao",
                          "codUnidadeSub",
                          "tpLiquidacao",
                          "nroEmpenho",
                          "dtEmpenho",
                          "dtLiquidacao",
                          "nroLiquidacao",
    											"vlLiquidado",
    											"nomeLiquidante",
    											"cpfLiquidante"
                        );
    $aElementos[11] = array(
                          "tipoRegistro",
                          "codReduzido",
                          "codFontRecursos",
    											"valorFonte"
                        );
    $aElementos[12] = array(
                          "tipoRegistro",
                          "codReduzido",
                          "mesCompetencia",
    											"exercicioCompetencia",
                          "vlDspExerAnt"
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
        $sTipoLiquidante  = $oOrgao->getAttribute('tipoLiquidante');
        
    	}
    	
    }
  
    if (!isset($oOrgao)) {
      throw new Exception("Arquivo sem configuração de Orgaos.");
    }   
    
    $sSql  = "SELECT e50_id_usuario,e71_codnota,e50_codord, e50_data, e60_anousu, e60_codemp, e60_emiss, o58_orgao, 
              o58_unidade, z01_nome, z01_cgccpf, e53_valor,e53_vlranu,o15_codtri  
          from pagordem 
               join empempenho on e50_numemp = e60_numemp 
               join orcdotacao on e60_coddot = o58_coddot and o58_anousu = e60_anousu
               join cgm on e60_numcgm = z01_numcgm 
               join pagordemele on e53_codord = e50_codord 
               join pagordemnota on e71_codord = e50_codord
               join orctiporec on o58_codigo = o15_codigo 
          where e50_data >= '".$this->sDataInicial."' and e50_data <= '".$this->sDataFinal."' and o58_anousu = e60_anousu and e60_instit = ".db_getsession("DB_instit"); 
    
    $rsLiquidacao = db_query($sSql);
    //db_criatabela($rsLiquidacao);
    /**
     * percorrer registros retornados do sql acima para passar os dados para o array dos registros a serem gerados
     */
    $aDadosAgrupados = array();
    for ($iCont = 0; $iCont < pg_num_rows($rsLiquidacao); $iCont++) {
    	
    	$oLiquidacao = db_utils::fieldsMemory($rsLiquidacao,$iCont);
    	$sHash = substr($oLiquidacao->e71_codnota, 0, 15);
    	
    	if (!isset($aDadosAgrupados[$sHash])) {  
	    	
    		if ($sTipoLiquidante == '02') {
    			$sSql = "select z01_nome,z01_cgccpf from db_usuarios usu join db_usuacgm usucgm on usu.id_usuario = usucgm.id_usuario
                   join cgm on usucgm.cgmlogin = cgm.z01_numcgm 
                   join db_userinst usuinst on usu.id_usuario = usuinst.id_usuario
                   where usu.id_usuario = {$oLiquidacao->e50_id_usuario} and usuinst.id_instit = ".db_getsession("DB_instit");
    		} else {
    			$sSql  = "select z01_nome,z01_cgccpf from cgm where z01_numcgm = ";
	    	  $sSql .= "(select o41_indent from orcunidade where o41_unidade = ".$oLiquidacao->o58_unidade;
	    	  $sSql .= " and o41_orgao = ".$oLiquidacao->o58_orgao;
	    	  $sSql .= " and o41_anousu = ".db_getsession("DB_anousu").")";
    		}
	    	$rsLiquidante = db_query($sSql);
	    	$oLiquidante = db_utils::fieldsMemory($rsLiquidante, 0);
	    	
	    	if ($oLiquidacao->e60_anousu == db_getsession("DB_anousu")) {
	    		$stpLiquidacao = 1;
	    	} else {
	    		$stpLiquidacao = 2;
	    	}
	    	
	      if ($sTrataCodUnidade == "01") {
	      		
	        $sCodUnidade					  = str_pad($oLiquidacao->o58_orgao, 2, "0", STR_PAD_LEFT);
		   		$sCodUnidade					 .= str_pad($oLiquidacao->o58_unidade, 3, "0", STR_PAD_LEFT);
		   		  
	      } else {
	      		
	        $sCodUnidade					  = str_pad($oLiquidacao->o58_orgao, 3, "0", STR_PAD_LEFT);
		   	  $sCodUnidade					 .= str_pad($oLiquidacao->o58_unidade, 2, "0", STR_PAD_LEFT);
	      		
	      }
	    	
	    	$oDadosLiquidacao = new stdClass();
	
	    	$oDadosLiquidacao->tipoRegistro    = 10;
	    	$oDadosLiquidacao->detalhesessao   = 10;
	    	$oDadosLiquidacao->codReduzido     = substr($oLiquidacao->e71_codnota, 0, 15);
	    	$oDadosLiquidacao->codOrgao        = $sOrgao;
	    	$oDadosLiquidacao->codUnidadeSub   = $sCodUnidade;
		    $oDadosLiquidacao->tpLiquidacao    = $stpLiquidacao;
		    $oDadosLiquidacao->nroEmpenho      = substr($oLiquidacao->e60_codemp, 0, 22);
		    $oDadosLiquidacao->dtEmpenho       = implode(array_reverse(explode("-", $oLiquidacao->e60_emiss)));
		    $oDadosLiquidacao->dtLiquidacao    = implode(array_reverse(explode("-", $oLiquidacao->e50_data)));
		    $oDadosLiquidacao->nroLiquidacao   = substr($oLiquidacao->e71_codnota, 0, 9);
		    $oDadosLiquidacao->vlLiquidado     = $oLiquidacao->e53_valor;
		    $oDadosLiquidacao->nomeLiquidante  = substr($oLiquidante->z01_nome, 0, 50);
		    $oDadosLiquidacao->cpfLiquidante   = str_pad($oLiquidante->z01_cgccpf, 11, "0", STR_PAD_LEFT);
		    
		    $aDadosAgrupados[$sHash] = $oDadosLiquidacao;
	    	
		    /**
		     * registro 11
		     */
		    
		    $oDadosLiquidacaoFonte = new stdClass();
		    
		    $oDadosLiquidacaoFonte->tipoRegistro    = 11;
		    $oDadosLiquidacaoFonte->detalhesessao   = 11;
		    $oDadosLiquidacaoFonte->codReduzido     = substr($oLiquidacao->e71_codnota, 0, 15);
		    $oDadosLiquidacaoFonte->codFontRecursos = substr($oLiquidacao->o15_codtri, 0, 3);
		    $oDadosLiquidacaoFonte->valorFonte      = $oLiquidacao->e53_valor;
		    
		    $aDadosAgrupados[$sHash]->Reg11 = $oDadosLiquidacaoFonte;
	    
      } else {
      	
      	$aDadosAgrupados[$sHash]->vlLiquidado       += $oLiquidacao->e53_valor;
      	$aDadosAgrupados[$sHash]->Reg11->valorFonte += $oLiquidacao->e53_valor;
      	
      }
	    
    }
    
    foreach ($aDadosAgrupados as $oDados) {
    	
    	$oDadosReg11 = clone $oDados->Reg11;
    	unset($oDados->Reg11);
    	$oDados->vlLiquidado     = number_format($oDados->vlLiquidado, 2, "", "");
    	$oDadosReg11->valorFonte = number_format($oDadosReg11->valorFonte, 2, "", "");
    	$this->aDados[] = $oDados;
    	$this->aDados[] = $oDadosReg11;
    	
    }
    
  }
  
}