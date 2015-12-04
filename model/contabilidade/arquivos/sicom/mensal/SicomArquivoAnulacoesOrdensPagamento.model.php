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
	c70_codlan as anulacao,
	lpad(e50_codord,8,0) as numOrdem,e50_codord,c70_codlan,
	e50_codord as numLiquida,e50_codord as op,
	c70_valor as vlrordem,
	(select c71_data as dtpagamento from conlancamdoc where c71_codlan = 
				 (select max(c71_codlan) from conlancamdoc join conlancamord on c80_codlan = c71_codlan where c71_coddoc in (5,6,35,36,37,38)
				 and c80_codord = e50_codord 
				 and c71_coddoc in (5,35,37) and c71_codlan < c70_codlan)) as dtpag,
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
	join pagordem  on c80_codord = e50_codord 
	join pagordemele on e53_codord = e50_codord
	join pagordemnota on e71_codord = c80_codord 
	join empempenho on e50_numemp = e60_numemp
	join cgm on e60_numcgm = z01_numcgm
	join orcdotacao on e60_coddot = o58_coddot and e60_anousu = o58_anousu
	join orcelemento on e53_codele = o56_codele and e60_anousu = o56_anousu
	join orctiporec on o58_codigo  = o15_codigo
where c71_coddoc in (6,36,38) and c71_data between '".$this->sDataInicial."' and '".$this->sDataFinal."'";
	 
	 
	$rsAnulacao = db_query($sSql);
	 //echo $sSql; db_criatabela($rsAnulacao);exit;
	/**
     * percorrer registros retornados do sql acima
     */
    for ($iCont = 0;$iCont < pg_num_rows($rsAnulacao); $iCont++) {
      
      $oAnulacoes = db_utils::fieldsMemory($rsAnulacao,$iCont);
      
      
      
      $sqlPagamento =" select max(c71_codlan) as c71_codlan from conlancamdoc join conlancamord on c80_codlan = c71_codlan join conlancam on c80_codlan = c70_codlan 
 					    where c71_coddoc in (5,35,37) and c80_codord = {$oAnulacoes->e50_codord} 
                  	   and c71_codlan < {$oAnulacoes->c70_codlan} and c70_valor = {$oAnulacoes->vlrordem} ";
      $rsPagamento = db_query($sqlPagamento);
     // echo $sqlPagamento; db_criatabela($rsPagamento);exit;
      $nNumPagamento   = db_utils::fieldsMemory($rsPagamento, 0)->c71_codlan;
      
      
        /**
    	 * pegar quantidade de extornos de liquidacao
    	 */
    	$sSqlExtornos = "select c80_codord as quant  from conlancamdoc join conhistdoc on c53_coddoc = c71_coddoc 
    	join conlancamord on c71_codlan =  c80_codlan join pagordemele on c80_codord = e53_codord join conlancam on c70_codlan = c71_codlan
    	where c53_tipo = 21 and c80_codord = {$oAnulacoes->op} and e53_valor = c70_valor";
    	$rsQuantExtornos = db_query($sSqlExtornos);
    	$iQuantExtorno   = db_utils::fieldsMemory($rsQuantExtornos, 0)->quant;
    	
    	if ($iQuantExtorno == 0) {
    	  
		      $itipoOP = 0;
		      if ($oAnulacoes->c71_coddoc == 6 && $oAnulacoes->divida != 46) {
		   	  	$itipoOP = 1;
		   	  } else {
		
		   	    if ($oAnulacoes->c71_coddoc == 36) {
		   	  	  $itipoOP = 3;
		   	    } else {
		   	    	
		   	      if ($oAnulacoes->c71_coddoc == 38) {
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
			   	  $oDadosAnulacao->codReduzido      = $oAnulacoes->anulacao;
			   	  $oDadosAnulacao->codOrgao         = $sOrgao;
			   	  $oDadosAnulacao->codUnidadeSub    = $sCodUnidade;
				  $oDadosAnulacao->nroOP            = $nNumPagamento.$oAnulacoes->numordem;
				  $oDadosAnulacao->dtPagamento		= implode(array_reverse(explode("-", $oAnulacoes->dtpag))); 
				  $oDadosAnulacao->nroAnulacaoOP    = $oAnulacoes->anulacao;
				  $oDadosAnulacao->dtAnulacaoOP     = implode(array_reverse(explode("-", $oAnulacoes->dtanulacao)));
				  $oDadosAnulacao->vlAnulacaoOP     = number_format($oAnulacoes->vlrordem, 2, "", "");
				  
				  $this->aDados[] = $oDadosAnulacao;
				  
				  /**
				   * Registro 11 
				   */
				  $oDadosAnulacaoFonte = new stdClass();
				  
				  $oDadosAnulacaoFonte->tipoRegistro       = 11;
		   	      $oDadosAnulacaoFonte->detalhesessao      = 11;
		   	      $oDadosAnulacaoFonte->codReduzido        = $oAnulacoes->anulacao;
		   	      $oDadosAnulacaoFonte->tipoPagamento      = $itipoOP;
				  $oDadosAnulacaoFonte->nroEmpenho         = $oAnulacoes->e60_codemp;
				  $oDadosAnulacaoFonte->dtEmpenho	       = implode(array_reverse(explode("-", $oAnulacoes->dtempenho)));
				  $oDadosAnulacaoFonte->nroLiquidacao      = $oAnulacoes->e71_codnota;
				  $oDadosAnulacaoFonte->dtLiquidacao       = implode(array_reverse(explode("-", $oAnulacoes->dtliquida)));	
				  $oDadosAnulacaoFonte->codFontRecursos	   = str_pad($oAnulacoes->recurso, 3, "0", STR_PAD_LEFT);
				  $oDadosAnulacaoFonte->valorAnulacaoFonte = number_format($oAnulacoes->vlrordem, 2, "", "");
				  $oDadosAnulacaoFonte->codOrgaoEmpOP      = " ";
				  $oDadosAnulacaoFonte->codUnidadeEmpOP    = " ";
				  
			    
			    $this->aDados[] = $oDadosAnulacaoFonte;
		    	  
		    }
    }
    
 }
		
 }