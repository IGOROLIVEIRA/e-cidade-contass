<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_aop102021_classe.php");
require_once ("classes/db_aop112021_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAOP.model.php");

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
  	
  	
  	$claop102021 = new cl_aop102021();
  	$claop112021 = new cl_aop112021();
    
    $sSqlUnidade = "select * from infocomplementares where 
  	si08_anousu = ".db_getsession("DB_anousu")." and si08_instit = ".db_getsession("DB_instit");
  	
    $rsResultUnidade = db_query($sSqlUnidade);
    $sTipoLiquidante = db_utils::fieldsMemory($rsResultUnidade, 0)->si08_tipoliquidante;
    
    
    $sSqlUnidade = "select * from infocomplementares where 
  	 si08_anousu = ".db_getsession("DB_anousu")." and si08_instit = ".db_getsession("DB_instit");
  	
    $rsResultUnidade = db_query($sSqlUnidade);
    $sTrataCodUnidade = db_utils::fieldsMemory($rsResultUnidade, 0)->si08_tratacodunidade;
    
    
    /*
     * SE JA FOI GERADO ESTA ROTINA UMA VEZ O SISTEMA APAGA OS DADOS DO BANCO E GERA NOVAMENTE
     */
    db_inicio_transacao();
    $result = $claop102021->sql_record($claop102021->sql_query(NULL,"*",NULL,"si137_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'] 
    . " and si137_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	
    	$claop112021->excluir(NULL,"si138_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'] . " and si138_instit = ".db_getsession("DB_instit"));
        if ($claop112021->erro_status == 0) {
	    	  throw new Exception($claop112021->erro_msg);
	      }
    	$claop102021->excluir(NULL,"si137_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'] . " and si137_instit = ".db_getsession("DB_instit"));
	    if ($claop102021->erro_status == 0) {
	    	  throw new Exception($claop102021->erro_msg);
	      }
	}
	
	 $sSql    = "SELECT  c71_coddoc,e50_codord,
				c70_data as dtanulacao,
				e50_data as dtordem,
				e50_data as dtliquida,
				(select c71_codlan as dtpagamento from conlancamdoc where c71_codlan = 
				(select max(c71_codlan) from conlancamdoc join conlancamord on c80_codlan = c71_codlan 
				where c71_coddoc in (5,6,35,36,37,38) and c80_codord = e50_codord 
				and c71_coddoc in (5,35,37) and c71_codlan < c70_codlan))||lpad(e50_codord,10,0) as numordem,
				e50_codord as numLiquida,
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
				e71_codnota,
				si09_codorgaotce
			from conlancam 
				join conlancamdoc on c71_codlan = c70_codlan 
				join conlancamord on c80_codlan = c71_codlan 
				join pagordem on c80_codord = e50_codord 
				join pagordemele on e53_codord = e50_codord
				join pagordemnota on e71_codord = c80_codord 
				join empempenho on e50_numemp = e60_numemp
				join cgm on e60_numcgm = z01_numcgm
				join orcdotacao on e60_coddot = o58_coddot and e60_anousu = o58_anousu
				join orcelemento on e53_codele = o56_codele and e60_anousu = o56_anousu
				join orctiporec on o58_codigo  = o15_codigo
				left join  infocomplementaresinstit on e60_instit = si09_instit
			where c71_coddoc in (6,36,38) 
			and c71_data between '".$this->sDataInicial."' and  '".$this->sDataFinal."'";
  	//echo $sSql;
  	$rsAnulacao = db_query($sSql);
	//db_criatabela($rsAnulacao);
	/**
     * percorrer registros retornados do sql acima
     */
  	
  	$aAnulacoes =  array();
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
		   **/
          $Hash = $oAnulacoes->numordem;
          if(!isset($aAnulacoes[$Hash])){
			   	  $oDadosAnulacao = new stdClass();
			   	  
			   	  $oDadosAnulacao->si137_tiporegistro    			= 10;
			   	  $oDadosAnulacao->si137_codreduzido    			= $oAnulacoes->numordem;
			   	  $oDadosAnulacao->si137_codorgao       			= $oAnulacoes->si09_codorgaotce;
			   	  $oDadosAnulacao->si137_codunidadesub   			= $sCodUnidade;
				  $oDadosAnulacao->si137_nroop           			= $oAnulacoes->numordem;
				  $oDadosAnulacao->si137_dtpagamento				= $oAnulacoes->dtpag; 
				  $oDadosAnulacao->si137_nroanulacaoop    			= $oAnulacoes->numordem;
				  $oDadosAnulacao->si137_dtanulacaoop     			= $oAnulacoes->dtanulacao;
				  $oDadosAnulacao->si137_justificativaanulacao      = "ESTORNO DE PAGAMENTO";
				  $oDadosAnulacao->si137_vlanulacaoop           	= $oAnulacoes->vlrordem;
				  $oDadosAnulacao->si137_mes            		  	= $this->sDataFinal['5'].$this->sDataFinal['6'];
				  $oDadosAnulacao->si137_instit 				    = db_getsession("DB_instit");
				  $oDadosAnulacao->reg11							= array();
          
          		  
				  /**
				   * Registro 11 
				   */
				  $oDadosAnulacaoFonte = new stdClass();
				  
				  $oDadosAnulacaoFonte->si138_tiporegistro       = 11;
			   	  $oDadosAnulacaoFonte->si138_codreduzido        = $oAnulacoes->numordem;
			   	  $oDadosAnulacaoFonte->si138_tipopagamento      = $itipoOP;
				  $oDadosAnulacaoFonte->si138_nroempenho         = $oAnulacoes->e60_codemp;
				  $oDadosAnulacaoFonte->si138_dtempenho	         = $oAnulacoes->dtempenho;
				  $oDadosAnulacaoFonte->si138_nroliquidacao      = $oAnulacoes->numliquida;
				  $oDadosAnulacaoFonte->si138_dtliquidacao       = $oAnulacoes->dtliquida;	
				  $oDadosAnulacaoFonte->si138_codfontrecursos	 = str_pad($oAnulacoes->recurso, 3, "0", STR_PAD_LEFT);
				  $oDadosAnulacaoFonte->si138_valoranulacaofonte = $oAnulacoes->vlrordem;
				  $oDadosAnulacaoFonte->si138_codorgaoempop      = ' ';
				  $oDadosAnulacaoFonte->si138_codunidadeempop    = ' ';
				  $oDadosAnulacaoFonte->si138_mes    			 = $this->sDataFinal['5'].$this->sDataFinal['6'];
				  $oDadosAnulacaoFonte->si138_reg10              = 0;
				  $oDadosAnulacaoFonte->si138_instit 		     = db_getsession("DB_instit");
				  
				  $oDadosAnulacao->reg11[$Hash] = $oDadosAnulacaoFonte;
				  $aAnulacoes[$Hash] = $oDadosAnulacao;
		  
		  
          }else{
          	      $aAnulacoes[$Hash]->si137_vlanulacaoop +=  $oAnulacoes->vlrordem;
          	      $aAnulacoes[$Hash]->reg11[$Hash]->si138_valoranulacaofonte +=  $oAnulacoes->vlrordem;
          }
    	  
    }
    foreach ($aAnulacoes as $anulacao) {
    	  
    	  $oDadosAnulacao = new cl_aop102021();
    	
    	  $oDadosAnulacao->si137_tiporegistro    			= $anulacao->si137_tiporegistro;
		  $oDadosAnulacao->si137_codreduzido    			= $anulacao->si137_codreduzido;
		  $oDadosAnulacao->si137_codorgao       			= $anulacao->si137_codorgao;
		  $oDadosAnulacao->si137_codunidadesub   			= $anulacao->si137_codunidadesub;
		  $oDadosAnulacao->si137_nroop           			= $anulacao->si137_nroop;
		  $oDadosAnulacao->si137_dtpagamento				= $anulacao->si137_dtpagamento; 
		  $oDadosAnulacao->si137_nroanulacaoop    			= $anulacao->si137_nroanulacaoop;
		  $oDadosAnulacao->si137_dtanulacaoop     			= $anulacao->si137_dtanulacaoop;
		  $oDadosAnulacao->si137_justificativaanulacao      = $anulacao->si137_justificativaanulacao;
		  $oDadosAnulacao->si137_vlanulacaoop           	= $anulacao->si137_vlanulacaoop;
		  $oDadosAnulacao->si137_mes            		  	= $anulacao->si137_mes;
		  $oDadosAnulacao->si137_instit 				    = $anulacao->si137_instit;
		  							
  		  $oDadosAnulacao->incluir(null);
    	  if ($oDadosAnulacao->erro_status == 0) {
		    	  throw new Exception($oDadosAnulacao->erro_msg);
		  }
		  
		  foreach($anulacao->reg11 as $reg11){
		  	      
		  		  $oDadosAnulacaoFonte = new cl_aop112021();
				  
				  $oDadosAnulacaoFonte->si138_tiporegistro       = $reg11->si138_tiporegistro;
			   	  $oDadosAnulacaoFonte->si138_codreduzido        = $reg11->si138_codreduzido;
			   	  $oDadosAnulacaoFonte->si138_tipopagamento      = $reg11->si138_tipopagamento;
				  $oDadosAnulacaoFonte->si138_nroempenho         = $reg11->si138_nroempenho;
				  $oDadosAnulacaoFonte->si138_dtempenho	         = $reg11->si138_dtempenho;
				  $oDadosAnulacaoFonte->si138_nroliquidacao      = $reg11->si138_nroliquidacao;
				  $oDadosAnulacaoFonte->si138_dtliquidacao       = $reg11->si138_dtliquidacao;	
				  $oDadosAnulacaoFonte->si138_codfontrecursos	 = $reg11->si138_codfontrecursos;
				  $oDadosAnulacaoFonte->si138_valoranulacaofonte = $reg11->si138_valoranulacaofonte;
				  $oDadosAnulacaoFonte->si138_codorgaoempop      = $reg11->si138_codorgaoempop;
				  $oDadosAnulacaoFonte->si138_codunidadeempop    = $reg11->si138_codunidadeempop;
				  $oDadosAnulacaoFonte->si138_mes    			 = $reg11->si138_mes;
				  $oDadosAnulacaoFonte->si138_reg10              = $oDadosAnulacao->si137_sequencial;
				  $oDadosAnulacaoFonte->si138_instit 		     = $reg11->si138_instit;
				  
			      $oDadosAnulacaoFonte->incluir(null);
		    	  if ($oDadosAnulacaoFonte->erro_status == 0) {
				    	  throw new Exception($oDadosAnulacaoFonte->erro_msg);
				  }
		  }
    }
    db_fim_transacao();
	    
	$oGerarAOP = new GerarAOP();
	$oGerarAOP->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
	$oGerarAOP->gerarDados();
 }
		
 }
