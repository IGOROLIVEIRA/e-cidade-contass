<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

require_once ("classes/db_lqd102021_classe.php");
require_once ("classes/db_lqd112021_classe.php");
require_once ("classes/db_lqd122021_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarLQD.model.php");
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
    
  	$cllqd102021 = new cl_lqd102021();
  	$cllqd112021 = new cl_lqd112021();
  	$cllqd122021 = new cl_lqd122021();
  	
  	$sSqlUnidade = "select * from infocomplementares where 
  	si08_anousu = ".db_getsession("DB_anousu")." and si08_instit = ".db_getsession("DB_instit");
  	
    $rsResultUnidade = db_query($sSqlUnidade);
    $sTipoLiquidante = db_utils::fieldsMemory($rsResultUnidade, 0)->si08_tipoliquidante;
    
    
    $sSqlUnidade = "select * from infocomplementares where 
  	 si08_anousu = ".db_getsession("DB_anousu")." and si08_instit = ".db_getsession("DB_instit");
  	
    $rsResultUnidade = db_query($sSqlUnidade);
    $sTrataCodUnidade = db_utils::fieldsMemory($rsResultUnidade, 0)->si08_tratacodunidade;
    
    $sSql  = "SELECT e50_id_usuario,e71_codnota,e50_codord, e50_data, e60_anousu, e60_codemp, e60_emiss, 
                 case when o40_codtri::int = 0 then o40_orgao::int else o40_codtri::int end as o58_orgao , 
                 case when o41_codtri::int = 0 then o41_unidade::int else o41_codtri::int end as o58_unidade,
                 z01_nome, z01_cgccpf, e53_valor,e53_vlranu,o15_codtri,si09_codorgaotce  
          from pagordem 
               join empempenho on e50_numemp = e60_numemp 
               join orcdotacao on e60_coddot = o58_coddot and o58_anousu = e60_anousu
               join orcorgao on o58_anousu = o40_anousu and o40_orgao = o58_orgao
			   join orcunidade on o58_anousu = o41_anousu and o58_orgao = o41_orgao and o58_unidade = o41_unidade
               join cgm on e60_numcgm = z01_numcgm 
               join pagordemele on e53_codord = e50_codord 
               join pagordemnota on e71_codord = e50_codord
               join orctiporec on o58_codigo = o15_codigo 
               left join  infocomplementaresinstit on o58_instit = si09_instit
          where e50_data >= '".$this->sDataInicial."' and e50_data <= '".$this->sDataFinal."' 
          and o58_anousu = e60_anousu and e60_instit = ".db_getsession("DB_instit"); 
    
    $rsLiquidacao = db_query($sSql);
    //db_criatabela($rsLiquidacao);
    
    
    /*
     * SE JA FOI GERADO ESTA ROTINA UMA VEZ O SISTEMA APAGA OS DADOS DO BANCO E GERA NOVAMENTE
     */
    db_inicio_transacao();
    $result = $cllqd102021->sql_record($cllqd102021->sql_query(NULL,"*",NULL,"si118_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']
        ." and si118_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	
    	$cllqd112021->excluir(NULL,"si119_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']
    		." and si119_instit = ".db_getsession("DB_instit"));
    	$cllqd122021->excluir(NULL,"si120_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']
    		." and si120_instit = ".db_getsession("DB_instit"));
    	$cllqd102021->excluir(NULL,"si118_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']
    		." and si118_instit = ".db_getsession("DB_instit"));
      if ($cllqd102021->erro_status == 0) {
    	  throw new Exception($cllqd102021->erro_msg);
      }
    }
    
    /**
     * salavando os dados novamente nas tabelas
     */
    $aDadosAgrupados = array();
    for ($iCont = 0; $iCont < pg_num_rows($rsLiquidacao); $iCont++) {
    	
    	$oLiquidacao = db_utils::fieldsMemory($rsLiquidacao,$iCont);
    	$sHash = substr($oLiquidacao->e71_codnota, 0, 15);
    	
    	if (!isset($aDadosAgrupados[$sHash])) {  
	    	
    		if ($sTipoLiquidante == '2') {
    			$sSql = "select z01_nome,substr(z01_cgccpf,1,11) as z01_cgccpf from db_usuarios usu join db_usuacgm usucgm on usu.id_usuario = usucgm.id_usuario
                   join cgm on usucgm.cgmlogin = cgm.z01_numcgm 
                   join db_userinst usuinst on usu.id_usuario = usuinst.id_usuario
                   where usu.id_usuario = {$oLiquidacao->e50_id_usuario} and usuinst.id_instit = ".db_getsession("DB_instit");
    		} else {
    			$sSql  = "select z01_nome,substr(z01_cgccpf,1,11) as z01_cgccpf from cgm where z01_numcgm = ";
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
	    	
	      if ($sTrataCodUnidade == "1") {
	      		
	            $sCodUnidade					  = str_pad($oLiquidacao->o58_orgao, 2, "0", STR_PAD_LEFT);
		   		$sCodUnidade					 .= str_pad($oLiquidacao->o58_unidade, 3, "0", STR_PAD_LEFT);
		   		  
	      } else {
	      		
	            $sCodUnidade					  = str_pad($oLiquidacao->o58_orgao, 3, "0", STR_PAD_LEFT);
		   	    $sCodUnidade					 .= str_pad($oLiquidacao->o58_unidade, 2, "0", STR_PAD_LEFT);
	      		
	      }
	    	
	    	$oDadosLiquidacao = new stdClass();
	
	    	$oDadosLiquidacao->si118_tiporegistro    = '10';
	    	$oDadosLiquidacao->si118_codreduzido     = substr($oLiquidacao->e71_codnota, 0, 15);
	    	$oDadosLiquidacao->si118_codorgao        = $oLiquidacao->si09_codorgaotce;
	    	$oDadosLiquidacao->si118_codunidadesub   = $sCodUnidade;
		    $oDadosLiquidacao->si118_tpliquidacao    = $stpLiquidacao;
		    $oDadosLiquidacao->si118_nroempenho      = substr($oLiquidacao->e60_codemp, 0, 22);
		    $oDadosLiquidacao->si118_dtempenho       = $oLiquidacao->e60_emiss;
		    $oDadosLiquidacao->si118_dtliquidacao    = $oLiquidacao->e50_data;
		    $oDadosLiquidacao->si118_nroliquidacao   = substr($oLiquidacao->e71_codnota, 0, 9);
		    $oDadosLiquidacao->si118_vlliquidado     = $oLiquidacao->e53_valor;
		    $oDadosLiquidacao->si118_cpfliquidante   = str_pad($oLiquidante->z01_cgccpf, 11, "0", STR_PAD_LEFT);
		    $oDadosLiquidacao->si118_mes             = $this->sDataFinal['5'].$this->sDataFinal['6'];
		    $oDadosLiquidacao->Reg11                     = array();
		    
		    
		    $aDadosAgrupados[$sHash] = $oDadosLiquidacao;
	    	
		    /**
		     * registro 11
		     */
		    
		    $oDadosLiquidacaoFonte = new stdClass();
		    
		    $oDadosLiquidacaoFonte->si119_tiporegistro    = '11';
		    $oDadosLiquidacaoFonte->si119_codreduzido     = substr($oLiquidacao->e71_codnota, 0, 15);
		    $oDadosLiquidacaoFonte->si119_codfontrecursos = substr($oLiquidacao->o15_codtri, 0, 3);
		    $oDadosLiquidacaoFonte->si119_valorfonte      = $oLiquidacao->e53_valor;
		    $oDadosLiquidacaoFonte->si119_mes   		  = $this->sDataFinal['5'].$this->sDataFinal['6'];
		    
		    $aDadosAgrupados[$sHash]->Reg11[] = $oDadosLiquidacaoFonte;
	    
      } else {
      	
      	$aDadosAgrupados[$sHash]->si118_vlliquidado       += $oLiquidacao->e53_valor;
      	$aDadosAgrupados[$sHash]->Reg11->si119_valorfonte += $oLiquidacao->e53_valor;
      	
      }
	    
    }
    foreach ($aDadosAgrupados as $oDados10) {
    			
		    	  $cllqd102021 = new cl_lqd102021();
				  $cllqd102021->si118_tiporegistro          = $oDados10->si118_tiporegistro;
				  $cllqd102021->si118_codreduzido           = $oDados10->si118_codreduzido;
				  $cllqd102021->si118_codorgao              = $oDados10->si118_codorgao;
				  $cllqd102021->si118_codunidadesub         = $oDados10->si118_codunidadesub;
				  $cllqd102021->si118_tpliquidacao          = $oDados10->si118_tpliquidacao;
				  $cllqd102021->si118_nroempenho            = $oDados10->si118_nroempenho;
				  $cllqd102021->si118_dtempenho             = $oDados10->si118_dtempenho;
				  $cllqd102021->si118_dtliquidacao          = $oDados10->si118_dtliquidacao;
				  $cllqd102021->si118_nroliquidacao         = $oDados10->si118_nroliquidacao;
				  $cllqd102021->si118_vlliquidado           = $oDados10->si118_vlliquidado;
				  $cllqd102021->si118_cpfliquidante         = $oDados10->si118_cpfliquidante;
				  $cllqd102021->si118_mes                   = $oDados10->si118_mes;
				  $cllqd102021->si118_instit 				= db_getsession("DB_instit");
				  
				  $cllqd102021->incluir(null);
		    	if ($cllqd102021->erro_status == 0) {
		    		echo "<pre>";print_r($cllqd102021);
		    	  throw new Exception($cllqd102021->erro_msg);
		      }
      foreach ($oDados10->Reg11 as $oDados11) {
      	    
            $cllqd112021 = new cl_lqd112021();
            
    		$cllqd112021->si119_tiporegistro     = $oDados11->si119_tiporegistro;
    		$cllqd112021->si119_codreduzido      = $oDados11->si119_codreduzido;
    		$cllqd112021->si119_codfontrecursos  = $oDados11->si119_codfontrecursos;
    		$cllqd112021->si119_valorfonte       = $oDados11->si119_valorfonte;
    		$cllqd112021->si119_mes              = $oDados11->si119_mes;
    		$cllqd112021->si119_reg10            = $cllqd102021->si118_sequencial;
    		$cllqd112021->si119_instit 			 = db_getsession("DB_instit");
    		
          $cllqd112021->incluir(null);
    	  if ($cllqd112021->erro_status == 0) {
    	    throw new Exception($cllqd112021->erro_msg);
        }
      	
      }
      
		  
    }
    
    db_fim_transacao();
	    
	$oGerarLQD = new GerarLQD();
	$oGerarLQD->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
	$oGerarLQD->gerarDados();
	    
	    
    }
    
   
    
  
  
}
