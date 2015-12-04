<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * Anulacao da Liquidacao Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoDetalhamentoAnulacao extends SicomArquivoBase implements iPadArquivoBaseCSV {
   
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 170;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'ALQ';
  
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
   *esse metodo sera implementado criando um array com os campos que serao necessarios 
   *para o escritor gerar o arquivo CSV 
   */
  public function getCampos(){
    
    $aElementos[10] = array(
						    					  "tipoRegistro",
						    					  "codReduzido",
						                "codOrgao",
						                "codUnidadeSub",
						    					  "nroEmpenho",
						    					  "dtEmpenho",
						    					  "dtLiquidacao",
						                "nroLiquidacao",
						    					  "dtAnulacaoLiq",
						    	  				"nroLiquidacaoANL",
						    					  "tpLiquidacao",
						    					  "vlAnulado"
                        );
     $aElementos[11] = array(
						    					  "tipoRegistro",
						    					  "codReduzido",
						                "codFontRecursos",
						                "valorAnuladoFonte"
                        );
     $aElementos[12] = array(
						    					  "tipoRegistro",
						    					  "codReduzido",
						                "mesCompetencia",
						                "exercicioCompetencia",
     												"vlAnuladoDspExerAnt"
                        );
    return $aElementos;
  }
  
  /**
   * Contratos mes para gerar o arquivo
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
      throw new Exception("Arquivo sem configuração de Orgaos.");
    }
    
   
    $sSql      =   "select e50_data,e71_codnota, c80_data, orctiporec.o15_codtri,e60_codemp, e60_emiss,  e60_anousu, 
    o58_orgao, o58_unidade, e60_codcom, sum(c70_valor) as c70_valor, c70_data, c53_tipo, c70_data
    from empempenho 
        inner join conlancamemp on c75_numemp = empempenho.e60_numemp 
        inner join conlancam on c70_codlan = c75_codlan
        inner join conlancamdoc on c71_codlan = c70_codlan
        inner join conhistdoc on c53_coddoc = c71_coddoc 
        inner join cgm on cgm.z01_numcgm = empempenho.e60_numcgm 
        inner join db_config on db_config.codigo = empempenho.e60_instit 
        inner join orcdotacao on orcdotacao.o58_anousu = empempenho.e60_anousu and orcdotacao.o58_coddot = empempenho.e60_coddot and orcdotacao.o58_instit = empempenho.e60_instit 
        inner join emptipo on emptipo.e41_codtipo = empempenho.e60_codtipo 
        inner join db_config as a on a.codigo = orcdotacao.o58_instit 
        inner join orctiporec on orctiporec.o15_codigo = orcdotacao.o58_codigo 
        inner join orcfuncao on orcfuncao.o52_funcao = orcdotacao.o58_funcao 
        inner join orcsubfuncao on orcsubfuncao.o53_subfuncao = orcdotacao.o58_subfuncao
        inner join orcprograma on orcprograma.o54_anousu = orcdotacao.o58_anousu and orcprograma.o54_programa = orcdotacao.o58_programa 
        inner join orcelemento on orcelemento.o56_codele = orcdotacao.o58_codele and orcdotacao.o58_anousu = orcelemento.o56_anousu 
        inner join orcprojativ on orcprojativ.o55_anousu = orcdotacao.o58_anousu and orcprojativ.o55_projativ = orcdotacao.o58_projativ
        inner join orcorgao on orcorgao.o40_anousu = orcdotacao.o58_anousu and orcorgao.o40_orgao = orcdotacao.o58_orgao 
        inner join orcunidade on orcunidade.o41_anousu = orcdotacao.o58_anousu and orcunidade.o41_orgao = orcdotacao.o58_orgao and orcunidade.o41_unidade =                        orcdotacao.o58_unidade
        left join empemphist on empemphist.e63_numemp = empempenho.e60_numemp 
        left join emphist on emphist.e40_codhist = empemphist.e63_codhist 
        inner join pctipocompra on pctipocompra.pc50_codcom = empempenho.e60_codcom 
        left join empresto on e60_numemp = e91_numemp and e60_anousu = e91_anousu 
        join conlancamord on c80_codlan = c75_codlan
        join pagordemnota on e71_codord = c80_codord 
        join pagordem on  e71_codord = e50_codord
		where c53_tipo in (21) and e60_numemp not in (select e91_numemp from empresto 
		where e91_anousu = ".db_getsession('DB_anousu').") and c53_coddoc in(4,24) and 
		c70_data between '".$this->sDataInicial."' and '".$this->sDataFinal."' and 1=1 and e60_instit = ".db_getsession('DB_instit')."
		group by e50_data,e60_numemp, e60_resumo, e60_destin, e60_codemp, e60_emiss, e60_numcgm, z01_nome, z01_cgccpf, z01_munic, 
		e60_vlremp, e60_vlranu, e60_vlrliq, e63_codhist, e40_descr, e60_vlrpag, e60_anousu, e60_coddot, o58_coddot, o58_orgao, 
		o40_orgao, o40_descr, o58_unidade, o41_descr, o15_codigo, o15_descr, e60_codcom, pc50_descr, c70_data, c53_tipo, 
		c53_descr, e91_numemp,orctiporec.o15_codtri, c80_data,e71_codnota";
    
    $rsDetalhamentos = db_query($sSql);
    //db_criatabela($rsDetalhamentos);
    /**
     * percorrer registros de detalhamento anulação retornados do sql acima
     */
    $aDadosAgrupados = array();
    for ($iCont = 0;$iCont < pg_num_rows($rsDetalhamentos); $iCont++) {
    	
      $oDetalhamento = db_utils::fieldsMemory($rsDetalhamentos,$iCont);
      
      if($oDetalhamento->e60_anousu == db_getsession("DB_anousu")){
      	$tpLiquidacao = 1;
      }else{
      	$tpLiquidacao = 2;
      }
      
      if ($sTrataCodUnidade == "01") {
      		
        $sCodUnidade					  = str_pad($oDetalhamento->o58_orgao, 2, "0", STR_PAD_LEFT);
	   		$sCodUnidade					 .= str_pad($oDetalhamento->o58_unidade, 3, "0", STR_PAD_LEFT);
	   		  
      } else {
      		
        $sCodUnidade					  = str_pad($oDetalhamento->o58_orgao, 3, "0", STR_PAD_LEFT);
	   	  $sCodUnidade					 .= str_pad($oDetalhamento->o58_unidade, 2, "0", STR_PAD_LEFT);
      		
      }
      
      $sHash = substr($oDetalhamento->e71_codnota, 0, 15);
      
      if (!isset($aDadosAgrupados[$sHash])) {
      
      	$oDadosDetalhamento = new stdClass();
      
        $oDadosDetalhamento->tipoRegistro       = 10;
        $oDadosDetalhamento->detalhesessao      = 10;
        $oDadosDetalhamento->codReduzido        = substr($oDetalhamento->e71_codnota, 0, 15);
        $oDadosDetalhamento->codOrgao           = $sOrgao;
        $oDadosDetalhamento->codUnidadeSub      = $sCodUnidade;
        $oDadosDetalhamento->nroEmpenho					= substr($oDetalhamento->e60_codemp, 0, 22);
        $oDadosDetalhamento->dtEmpenho					= implode(array_reverse(explode("-", $oDetalhamento->e60_emiss)));
        $oDadosDetalhamento->dtLiquidacao 			= implode(array_reverse(explode("-", $oDetalhamento->e50_data)));
        $oDadosDetalhamento->nroLiquidacao 			= substr($oDetalhamento->e71_codnota, 0, 9);
        $oDadosDetalhamento->dtAnulacaoLiq			= implode(array_reverse(explode("-", $oDetalhamento->c70_data)));
        $oDadosDetalhamento->nroLiquidacaoANL		= substr($oDetalhamento->e71_codnota, 0, 9);
        $oDadosDetalhamento->tpLiquidacao 			= $tpLiquidacao;
        $oDadosDetalhamento->vlAnulado					= $oDetalhamento->c70_valor;
        $oDadosDetalhamento->aReg11             = array();
      
        $oDadosDetalhamentoFonte = new stdClass();
      
        $oDadosDetalhamentoFonte->tipoRegistro       = 11;
        $oDadosDetalhamentoFonte->detalhesessao      = 11;
        $oDadosDetalhamentoFonte->codReduzido        = substr($oDetalhamento->e71_codnota, 0, 15);
        $oDadosDetalhamentoFonte->codFontRecursos    = str_pad($oDetalhamento->o15_codtri, 3, "0", STR_PAD_LEFT);
        $oDadosDetalhamentoFonte->valorAnuladoFonte  = $oDetalhamento->c70_valor;
      
        $oDadosDetalhamento->aReg11[$sHash] = $oDadosDetalhamentoFonte;
        $aDadosAgrupados[$sHash]            = $oDadosDetalhamento; 
      
      } else {
      	
      	$aDadosAgrupados[$sHash]->vlAnulado += $oDetalhamento->c70_valor;
      	$aDadosAgrupados[$sHash]->aReg11[$sHash]->valorAnuladoFonte += $oDetalhamento->c70_valor;
      	
      }
      
    }
    
    foreach ($aDadosAgrupados as $oDadosAgrupados) {
    	
    	$aDados11 = clone $oDadosAgrupados;
    	unset($oDadosAgrupados->aReg11);
    	$oDadosAgrupados->vlAnulado = number_format($oDadosAgrupados->vlAnulado, 2, "", "");
    	$this->aDados[] = $oDadosAgrupados;
    	foreach ($aDados11->aReg11 as $oDados11) {
    		
    		$oDados11->valorAnuladoFonte = number_format($oDados11->valorAnuladoFonte, 2, "", "");
    		$this->aDados[] = $oDados11;
    		    		
    	}
    	
    }
    
  }
  
}			