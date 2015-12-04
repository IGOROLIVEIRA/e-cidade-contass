<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * Anulações das Ordens de Pagamento Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoAnulacoesOrdensPagamento extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 173;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'AOP';
  
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
			                  "nroOP",
						    			  "dtPagamento",
						    			  "nroAnulacaoOP",
						    			  "dtAnulacaoOP",
						    			  "vlAnulacaoOP"
                        );
    $aElementos[11] = array(
			                  "tipoRegistro",
			                  "codReduzido",
			                  "tipoPagamento",
			                  "nroEmpenho",
			                  "dtEmpenho",
						    			  "nroLiquidacao",
						    			  "dtLiquidacao",
						    			  "codFontRecursos",
						    			  "valorAnulacaoFonte",
    										"codOrgaoEmpOP",
    										"codUnidadeEmpOP"
                        );
    return $aElementos;
  }
  
  /**
   * selecionar os dados de Decreto Municipal Regulamentador do Pregão / Registro de Preços do mes para gerar o arquivo
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
    		
          $sOrgao     = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
          $sTrataCodUnidade = $oOrgao->getAttribute('trataCodUnidade');
          
    	}
    	
    }
    
    if (!isset($oOrgao)) {
      throw new Exception("Arquivo sem configuração de Orgãos.");
    }
    
	 $sSql    = "SELECT  c71_coddoc,
	c70_data as dtanulacao,
	e50_data as dtordem,
	e50_data as dtliquida,
	e50_codord as numOrdem,
	e50_codord as numLiquida,
	e53_valor as vlrordem,
	(SELECT c71_data from conlancamord join conlancamdoc on c80_codlan = c71_codlan and c80_codord = e50_codord where c71_coddoc in (5,35,37) limit 1) as dtpag,
	e60_codemp,
	e60_emiss as dtempenho,
	z01_nome,
	z01_cgccpf,
	o58_orgao,
	o58_unidade,
	o58_funcao,
	o58_subfuncao,
	o58_programa,
	o58_projativ,
	substr(o56_elemento,2,6) as elemento,
	substr(o56_elemento,8,2) as subelemento,
	substr(o56_elemento,2,2) as divida,
	o15_codtri as recurso,
	e50_obs,
	e71_codnota
from conlancam 
	join conlancamdoc on c71_codlan = c70_codlan 
	join conlancamord on c80_codlan = c71_codlan 
	join pagordem on c80_codord = e50_codord 
	join pagordemele on e53_codord = e50_codord
	join pagordemnota on e71_codord = c80_codord and e71_anulado = false
	join empempenho on e50_numemp = e60_numemp
	join cgm on e60_numcgm = z01_numcgm
	join orcdotacao on e60_coddot = o58_coddot and e60_anousu = o58_anousu
	join orcelemento on e53_codele = o56_codele and e60_anousu = o56_anousu
	join orctiporec on o58_codigo  = o15_codigo
where c71_coddoc in (6,36) and c71_data >= '".$this->sDataInicial."' and  c71_data <= '".$this->sDataInicial."'; ";
  
	$rsAnulacao = db_query($sSql);
	//db_criatabela($rsAnulacao);
	/**
     * percorrer registros retornados do sql acima
     */
    for ($iCont = 0;$iCont < pg_num_rows($rsAnulacao); $iCont++) {
      
      $oAnulacoes = db_utils::fieldsMemory($rsAnulacao,$iCont);
    	  
      $itipoOP = 0;
      if ($oAnulacoes->c71_coddoc == 5 && $oAnulacoes->divida != 46) {
   	  	$itipoOP = 1;
   	  } else {

   	    if ($oAnulacoes->c71_coddoc == 35) {
   	  	  $itipoOP = 3;
   	    } else {
   	    	
   	      if ($oAnulacoes->c71_coddoc == 37) {
   	  	    $itipoOP = 4;
   	      } else {
   	      	$itipoOP = 2;
   	      }
   	    	
   	    }
   	  	
   	  }

      if ($sTrataCodUnidade == "01") {
      		
        $sCodUnidade  = str_pad($oAnulacoes->o58_orgao, 2, "0", STR_PAD_LEFT);
	   		$sCodUnidade .= str_pad($oAnulacoes->o58_unidade, 3, "0", STR_PAD_LEFT);
	   		  
      } else {
      		
        $sCodUnidade  = str_pad($oAnulacoes->o58_orgao, 3, "0", STR_PAD_LEFT);
	   	  $sCodUnidade .= str_pad($oAnulacoes->o58_unidade, 2, "0", STR_PAD_LEFT);
      		
      }
   	  
      /**
		   * Registro 10 
		   */
   	  $oDadosAnulacao = new stdClass();
   	  
   	  $oDadosAnulacao->tipoRegistro     = 10;
   	  $oDadosAnulacao->detalhesessao    = 10;
   	  $oDadosAnulacao->codReduzido      = $oAnulacoes->numordem;
   	  $oDadosAnulacao->codOrgao         = $sOrgao;
   	  $oDadosAnulacao->codUnidadeSub    = $sCodUnidade;
		  $oDadosAnulacao->nroOP            = $oAnulacoes->numordem;
		  $oDadosAnulacao->dtPagamento		  = implode(array_reverse(explode("-", $oAnulacoes->dtpag))); 
		  $oDadosAnulacao->nroAnulacaoOP    = $oAnulacoes->numordem;
		  $oDadosAnulacao->dtAnulacaoOP     = implode(array_reverse(explode("-", $oAnulacoes->dtanulacao)));
		  $oDadosAnulacao->vlAnulacaoOP     = number_format($oAnulacoes->vlrordem, 2, "", "");
		  
		  $this->aDados[] = $oDadosAnulacao;
		  
		  /**
		   * Registro 11 
		   */
		  $oDadosAnulacaoFonte = new stdClass();
		  
		  $oDadosAnulacaoFonte->tipoRegistro       = 11;
   	  $oDadosAnulacaoFonte->detalhesessao      = 11;
   	  $oDadosAnulacaoFonte->codReduzido        = $oAnulacoes->numordem;
   	  $oDadosAnulacaoFonte->tipoPagamento      = $$itipoOP;
		  $oDadosAnulacaoFonte->nroEmpenho         = $oAnulacoes->e60_codemp;
		  $oDadosAnulacaoFonte->dtEmpenho	         = implode(array_reverse(explode("-", $oAnulacoes->dtempenho)));
		  $oDadosAnulacaoFonte->nroLiquidacao      = $oAnulacoes->numliquida;
		  $oDadosAnulacaoFonte->dtLiquidacao       = implode(array_reverse(explode("-", $oAnulacoes->dtliquida)));	
		  $oDadosAnulacaoFonte->codFontRecursos	   = str_pad($oAnulacoes->recurso, 3, "0", STR_PAD_LEFT);
		  $oDadosAnulacaoFonte->valorAnulacaoFonte = number_format($oAnulacoes->vlrordem, 2, "", "");
		  $oDadosAnulacaoFonte->codOrgaoEmpOP      = " ";
		  $oDadosAnulacaoFonte->codUnidadeEmpOP    = " ";
		  
	    
	    $this->aDados[] = $oDadosAnulacaoFonte;
    	  
    }
    
 }
		
 }