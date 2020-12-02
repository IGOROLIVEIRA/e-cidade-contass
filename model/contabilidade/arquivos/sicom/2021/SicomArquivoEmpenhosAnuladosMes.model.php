<?php

require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

require_once ("classes/db_anl102021_classe.php");
require_once ("classes/db_anl112021_classe.php");

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarANL.model.php");

 /**
  * detalhamento dos empenhos do mês Sicom Acompanhamento Mensal
  * @author igor
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
          
  	
  	$regitro10 = new cl_anl102021();
  	$regitro11 = new cl_anl112021();
    
  	$sSqlUnidade = "select * from infocomplementares where 
  	 si08_anousu = ".db_getsession("DB_anousu")." and si08_instit = ".db_getsession("DB_instit");
  	
    $rsResultUnidade = db_query($sSqlUnidade);
    $sTrataCodUnidade = db_utils::fieldsMemory($rsResultUnidade, 0)->si08_tratacodunidade;
   
    
    $sSql  = "SELECT e94_codanu, e94_data, e94_motivo, e94_empanuladotipo, e94_numemp, e94_valor, e60_codemp, e60_emiss, 
                case when o40_codtri::int = 0 then o40_orgao::int else o40_codtri::int end as o58_orgao , 
                case when o41_codtri::int = 0 then o41_unidade::int else o41_codtri::int end as o58_unidade,
				o15_codtri,si09_codorgaotce
				from empanulado 
					join empempenho on e94_numemp = e60_numemp 
					join orcdotacao on o58_coddot = e60_coddot
					join orcorgao on o58_anousu = o40_anousu and o40_orgao = o58_orgao
					join orcunidade on o58_anousu = o41_anousu and o58_orgao = o41_orgao and o58_unidade = o41_unidade
					join orctiporec on o58_codigo = o15_codigo 
					join emptipo on e60_codtipo = e41_codtipo
					left join  infocomplementaresinstit on o58_instit = si09_instit
				where e94_data >= '".$this->sDataInicial."' and e94_data <= '".$this->sDataFinal."' and e60_anousu = ".db_getsession("DB_anousu")." 
				and o58_anousu = ".db_getsession("DB_anousu")." 
				and o58_instit = ".db_getsession("DB_instit"); 
   // echo $sSql;exit;
    $rsEmpenhoAnulados = db_query($sSql);
    
    //db_criatabela($rsEmpenhoAnulados);exit;
    
    /**
     * inicio informacoes no banco de dados
     */
    db_inicio_transacao();
    $rsDeletar = $regitro10->sql_record($regitro10->sql_query(NULL,"*",NULL,"si110_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']
           ." and si110_instit = ".db_getsession("DB_instit")));
    /**
     * apagado dados caso ja tenha sido gerado arquivo para o mes
     */
    
    if (pg_num_rows($rsDeletar) > 0) {
    	$regitro11->excluir(NULL,"si111_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']
    	." and si111_instit = ".db_getsession("DB_instit"));
    	$regitro10->excluir(NULL,"si110_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']
    	." and si110_instit = ".db_getsession("DB_instit"));
    	
      if ($regitro10->erro_status == 0) {
    	  throw new Exception($regitro10->erro_msg);
      }
    }
    /**
     * percorrer registros retornados do sql acima para passar os dados para o array dos registros a serem salvos nas tabelas
     */
    for ($iCont = 0; $iCont < pg_num_rows($rsEmpenhoAnulados); $iCont++) {
    	
    	$oEmpenhoAnulado = new stdClass();
    	$oEmpenhoAnulado = db_utils::fieldsMemory($rsEmpenhoAnulados, $iCont);
    	
    	
    	
    	if ($oEmpenhoAnulado->e94_empanuladotipo == 1) {
    		$sTipoAnulacao = 2;
    	} else {
    		$sTipoAnulacao = 1;
    	}
    	
    	
      if ($sTrataCodUnidade == 1) {
      		
            $sCodUnidade					  = str_pad($oEmpenhoAnulado->o58_orgao, 2, "0", STR_PAD_LEFT);
	   		$sCodUnidade					 .= str_pad($oEmpenhoAnulado->o58_unidade, 3, "0", STR_PAD_LEFT);
	   		  
      } else {
      		
          $sCodUnidade					  = str_pad($oEmpenhoAnulado->o58_orgao, 3, "0", STR_PAD_LEFT);
	   	  $sCodUnidade					 .= str_pad($oEmpenhoAnulado->o58_unidade, 2, "0", STR_PAD_LEFT);
      		
      }
    	
    	$oDadosEmpenhoAnulado = new cl_anl102021();

    	$oDadosEmpenhoAnulado->si110_tiporegistro          = 10;
    	$oDadosEmpenhoAnulado->si110_codorgao              = str_pad($oEmpenhoAnulado->si09_codorgaotce, 2, "0", STR_PAD_LEFT);
    	$oDadosEmpenhoAnulado->si110_codunidadesub         = $sCodUnidade;
	    $oDadosEmpenhoAnulado->si110_nroempenho            = substr($oEmpenhoAnulado->e60_codemp, 0, 22);
	    $oDadosEmpenhoAnulado->si110_dtempenho             = $oEmpenhoAnulado->e60_emiss;
	    $oDadosEmpenhoAnulado->si110_dtanulacao	           = $oEmpenhoAnulado->e94_data;
	    $oDadosEmpenhoAnulado->si110_nroanulacao           = $oEmpenhoAnulado->e94_codanu;
	    $oDadosEmpenhoAnulado->si110_tipoanulacao          = $sTipoAnulacao;
	    $oDadosEmpenhoAnulado->si110_especanulacaoempenho  = utf8_decode(substr($oEmpenhoAnulado->e94_motivo, 0, 200));
	    $oDadosEmpenhoAnulado->si110_vlanulacao            = $oEmpenhoAnulado->e94_valor;
	    $oDadosEmpenhoAnulado->si110_mes      	           = $this->sDataFinal['5'].$this->sDataFinal['6'];
	    $oDadosEmpenhoAnulado->si110_instit 			   = db_getsession("DB_instit");
	    
	    
	    
	    $oDadosEmpenhoAnulado->incluir(NULL);
	    
        if ($oDadosEmpenhoAnulado->erro_status == 0) {
    	    throw new Exception($oDadosEmpenhoAnulado->erro_msg);
        }
        
        
         
	    $oDadosEmpenhoAnuladoFonte = new cl_anl112021();
	    
	    $oDadosEmpenhoAnuladoFonte->si111_tiporegistro     = 11;
	    $oDadosEmpenhoAnuladoFonte->si111_codunidadesub    = $sCodUnidade;
	    $oDadosEmpenhoAnuladoFonte->si111_nroempenho       = substr($oEmpenhoAnulado->e60_codemp, 0, 22);
	    $oDadosEmpenhoAnuladoFonte->si111_nroanulacao      = substr($oEmpenhoAnulado->e94_codanu, 0, 9);
	    $oDadosEmpenhoAnuladoFonte->si111_codfontrecursos  = substr($oEmpenhoAnulado->o15_codtri, 0, 3);
	    $oDadosEmpenhoAnuladoFonte->si111_vlanulacaofonte  = $oEmpenhoAnulado->e94_valor;
	    $oDadosEmpenhoAnuladoFonte->si111_mes      		   = $this->sDataFinal['5'].$this->sDataFinal['6'];
	    $oDadosEmpenhoAnuladoFonte->si111_reg10            = $oDadosEmpenhoAnulado->si110_sequencial;
	    $oDadosEmpenhoAnuladoFonte->si111_instit 			   = db_getsession("DB_instit");
	    
	    $oDadosEmpenhoAnuladoFonte->incluir(null);
	    
        if ($oDadosEmpenhoAnuladoFonte->erro_status == 0) {
    	    throw new Exception($oDadosEmpenhoAnuladoFonte->erro_msg);
        }
	    
	    db_fim_transacao();
    }
    
    
    
    $oGerarANL = new GerarANL();
    $oGerarANL->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarANL->gerarDados();
    
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
