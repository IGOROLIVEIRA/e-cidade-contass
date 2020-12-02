<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_aoc10$PROXIMO_ANO_classe.php");
require_once ("classes/db_aoc11$PROXIMO_ANO_classe.php");
require_once ("classes/db_aoc12$PROXIMO_ANO_classe.php");
require_once ("classes/db_aoc13$PROXIMO_ANO_classe.php");
require_once ("classes/db_aoc14$PROXIMO_ANO_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAOC.model.php");

 /**
  * Alterações Orçamentárias Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoAlteracoesOrcamentarias extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 152;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'AOC';
  
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
					                  "codFuncao",
					                  "codSubFuncao",
					                  "codPrograma",
					                  "idAcao",
    												"idSubAcao",
					                  "elementoDespesa",
								    			  "codFontRecursos",
								    			  "nroDecreto",
								    		    "dataDecreto",	
								    			  "tipoAlteracao",
								        		"vlAlteracao"
                        );

    $aElementos[11] = array(
						    					  "tipoRegistro",
						    					  "codReduzido",
	                          "codFontRecursos",
	                          "valorAlteracaoFonte"
                        );
                        
    return $aElementos;
  }
  
  /**
   * selecionar os dados de alteracoes orcamentarias do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {

  	$claoc10$PROXIMO_ANO = new cl_aoc10$PROXIMO_ANO();
  	$claoc11$PROXIMO_ANO = new cl_aoc11$PROXIMO_ANO();
  	$claoc12$PROXIMO_ANO = new cl_aoc12$PROXIMO_ANO();
  	$claoc13$PROXIMO_ANO = new cl_aoc13$PROXIMO_ANO();
  	$claoc14$PROXIMO_ANO = new cl_aoc14$PROXIMO_ANO();
  	
  	/**
  	 * excluir informacoes do mes selecionado
  	 */
    db_inicio_transacao();
    $result = $claoc11$PROXIMO_ANO->sql_record($claoc11$PROXIMO_ANO->sql_query(NULL,"*",NULL,"si39_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si39_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$claoc11$PROXIMO_ANO->excluir(NULL,"si39_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si39_instit = ".db_getsession("DB_instit"));
      if ($claoc11$PROXIMO_ANO->erro_status == 0) {
    	  throw new Exception($claoc11$PROXIMO_ANO->erro_msg);
      }
    }
    
    $result = $claoc12$PROXIMO_ANO->sql_record($claoc12$PROXIMO_ANO->sql_query(NULL,"*",NULL,"si40_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si40_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$claoc12$PROXIMO_ANO->excluir(NULL,"si40_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si40_instit = ".db_getsession("DB_instit"));
      if ($claoc12$PROXIMO_ANO->erro_status == 0) {
    	  throw new Exception($claoc12$PROXIMO_ANO->erro_msg);
      }
    }
    
    $result = $claoc13$PROXIMO_ANO->sql_record($claoc13$PROXIMO_ANO->sql_query(NULL,"*",NULL,"si41_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si41_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$claoc13$PROXIMO_ANO->excluir(NULL,"si41_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si41_instit = ".db_getsession("DB_instit"));
      if ($claoc13$PROXIMO_ANO->erro_status == 0) {
    	  throw new Exception($claoc13$PROXIMO_ANO->erro_msg);
      }
    }
    
    $result = $claoc14$PROXIMO_ANO->sql_record($claoc14$PROXIMO_ANO->sql_query(NULL,"*",NULL,"si42_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si42_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$claoc14$PROXIMO_ANO->excluir(NULL,"si42_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si42_instit = ".db_getsession("DB_instit"));
      if ($claoc14$PROXIMO_ANO->erro_status == 0) {
    	  throw new Exception($claoc14$PROXIMO_ANO->erro_msg);
      }
    }
    
    $result = $claoc10$PROXIMO_ANO->sql_record($claoc10$PROXIMO_ANO->sql_query(NULL,"*",NULL,"si38_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si38_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$claoc10$PROXIMO_ANO->excluir(NULL,"si38_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si38_instit = ".db_getsession("DB_instit"));
      if ($claoc10$PROXIMO_ANO->erro_status == 0) {
    	  throw new Exception($claoc10$PROXIMO_ANO->erro_msg);
      }
    }
    /**
     * fim da exclusao dos registros do mes selecionado
     */
  	
    
    /**
     * selecionar as informacoes pertinentes ao AOC
     */
    
    $sSql = "select  o39_codproj as codigovinc,
       '10' as tiporegistro, 
	     si09_codorgaotce as codorgao, 
	     o39_numero as nroDecreto,
	     o39_data as dataDecreto  
       from orcprojeto 
       join db_config on prefeitura  = 't' 
       left join infocomplementaresinstit on si09_instit = ".db_getsession("DB_instit")."
     where o39_data between  '$this->sDataInicial' and '$this->sDataFinal'";
    $rsResult10 = db_query($sSql);
    
    for ($iCont10 = 0; $iCont10 < pg_num_fields($rsResult10); $iCont10++) {
    	
    	$oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
    	$claoc10$PROXIMO_ANO = new cl_aoc10$PROXIMO_ANO();
    	
    	$claoc10$PROXIMO_ANO->si38_tiporegistro = 10;
    	$claoc10$PROXIMO_ANO->si38_codorgao     = $oDados10->codorgao;
    	$claoc10$PROXIMO_ANO->si38_nrodecreto   = $oDados10->nrodecreto;
    	$claoc10$PROXIMO_ANO->si38_datadecreto  = $oDados10->datadecreto;
    	$claoc10$PROXIMO_ANO->si38_mes          = $this->sDataFinal['5'].$this->sDataFinal['6'];
    	$claoc10$PROXIMO_ANO->si38_instit       = db_getsession("DB_instit");
    	
    	$claoc10$PROXIMO_ANO->incluir(null);
      if ($claoc10$PROXIMO_ANO->erro_status == 0) {
    	  throw new Exception($claoc10$PROXIMO_ANO->erro_msg);
      }
      
      /**
       * registro 11
       */
      $sSql = "select '11' as tiporegistro, 
       o46_codlei as codreduzidodecreto, 
       o39_numero as nrodecreto ,
       (case when o46_tiposup in (1002,1003,1004,1005,1006,1007,1008,1009,1010) then 2 
	     when o46_tiposup = 1001 then 1
	     when o46_tiposup = 1012 then 6
	     when o46_tiposup = 1013 then 7
	     when o46_tiposup = 1016 then 8
	     when o46_tiposup = 1014 then 9
	     when o46_tiposup = 1015 then 10
             when o46_tiposup = 1011 then 4 end 
       ) as tipoDecretoAlteracao,
       sum(o47_valor) as valorAberto 
     from orcsuplem 
     join orcsuplemval  on o47_codsup = o46_codsup 
     join orcprojeto    on o46_codlei = o39_codproj
     join orcsuplemtipo on o46_tiposup =  o48_tiposup
    where o47_valor > 0 and o46_codlei in ({$oDados10->codigovinc})
    group by o46_codlei, o39_numero,o46_tiposup";
      $rsResult11 = db_query($sSql);
      
      for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {
      	
      	$oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);
      	$claoc11$PROXIMO_ANO = new cl_aoc11$PROXIMO_ANO();
      	
      	$claoc11$PROXIMO_ANO->si39_tiporegistro         = 11;
      	$claoc11$PROXIMO_ANO->si39_codreduzidodecreto   = $oDados11->codreduzidodecreto;
      	$claoc11$PROXIMO_ANO->si39_nrodecreto           = $oDados11->nrodecreto;
      	$claoc11$PROXIMO_ANO->si39_tipodecretoalteracao = $oDados11->tipodecretoalteracao;
      	$claoc11$PROXIMO_ANO->si39_valoraberto          = $oDados11->valoraberto;
      	$claoc11$PROXIMO_ANO->si39_mes                  = $this->sDataFinal['5'].$this->sDataFinal['6'];
      	$claoc11$PROXIMO_ANO->si39_reg10                = $claoc10$PROXIMO_ANO->si38_sequencial;
      	$claoc11$PROXIMO_ANO->si39_instit               = db_getsession("DB_instit");
      	
        $claoc11$PROXIMO_ANO->incluir(null);
        if ($claoc11$PROXIMO_ANO->erro_status == 0) {
    	    throw new Exception($claoc11$PROXIMO_ANO->erro_msg);
        }
      	
      }
      
      /**
       * registro 12
       */
    	$sSql = "select '12' as tiporegistro,
        o39_codproj as codReduzidoDecreto, 
       o45_numlei as nroLeiAlteracao ,
       '$PROXIMO_ANO-01-01' as dataLeiAlteracao
      from orcprojeto 
      join orclei on o39_codlei = o45_codlei
     where o39_codproj in ({$oDados10->codigovinc})";
    	$rsResult12 = db_query($sSql);
    	
    	for ($iCont12 = 0; $iCont12 < pg_num_rows($rsResult12); $iCont12++) {
    		
    		$oDados12 = db_utils::fieldsMemory($rsResult12, $iCont12);
    		$claoc12$PROXIMO_ANO = new cl_aoc12$PROXIMO_ANO();
    		
    		$claoc12$PROXIMO_ANO->si40_tiporegistro       = 12;
    		$claoc12$PROXIMO_ANO->si40_codreduzidodecreto = $oDados12->codreduzidodecreto;
    		$claoc12$PROXIMO_ANO->si40_nroleialteracao    = $oDados12->nroleialteracao;
    		$claoc12$PROXIMO_ANO->si40_dataleialteracao   = $oDados12->dataleialteracao;
    		$claoc12$PROXIMO_ANO->si40_mes                = $this->sDataFinal['5'].$this->sDataFinal['6'];
    		$claoc12$PROXIMO_ANO->si40_reg10              = $claoc10$PROXIMO_ANO->si38_sequencial;
    		$claoc12$PROXIMO_ANO->si40_instit             = db_getsession("DB_instit");
    		
    	  $claoc12$PROXIMO_ANO->incluir(null);
        if ($claoc12$PROXIMO_ANO->erro_status == 0) {
    	    throw new Exception($claoc12$PROXIMO_ANO->erro_msg);
        }
    		
    	}
    	
    	/**
    	 * registro 13
    	 */
    	$sSql = "select '13'       as tiporegistro, 
       o46_codlei as codreduzidodecreto, 
       (case when o46_tiposup = 1001 then 3
	     when o46_tiposup = 1002 then 4
	     when o46_tiposup = 1003 then 1
             when o46_tiposup in (1004,1005,1006,1007,1008,1009,1010) then 2 
             else 98
         end 
       ) as tipoDecretoAlteracao,
       sum(o47_valor) as valorAberto 
     from orcsuplem 
     join orcsuplemval  on o47_codsup = o46_codsup 
     join orcprojeto    on o46_codlei = o39_codproj
     join orcsuplemtipo on o46_tiposup =  o48_tiposup
    where o47_valor > 0 and o46_codlei in ({$oDados10->codigovinc})
    group by o46_codlei, o39_numero,o46_tiposup";
    	$rsResult13 = db_query($sSql);
    	
    	for ($iCont13 = 0; $iCont13 < pg_num_rows($rsResult13); $iCont13++) {
    		
    		$oDados13 = db_utils::fieldsMemory($rsResult13, $iCont13);
    		$claoc13$PROXIMO_ANO = new cl_aoc13$PROXIMO_ANO();
    		
    		$claoc13$PROXIMO_ANO->si41_tiporegistro       = 13;
    		$claoc13$PROXIMO_ANO->si41_codreduzidodecreto = $oDados13->codreduzidodecreto;
    		$claoc13$PROXIMO_ANO->si41_origemrecalteracao = $oDados13->tipodecretoalteracao;
    		$claoc13$PROXIMO_ANO->si41_valorabertoorigem  = $oDados13->valoraberto;
    		$claoc13$PROXIMO_ANO->si41_mes                = $this->sDataFinal['5'].$this->sDataFinal['6'];
    		$claoc13$PROXIMO_ANO->si41_reg10              = $claoc10$PROXIMO_ANO->si38_sequencial;
    		$claoc13$PROXIMO_ANO->si41_instit             = db_getsession("DB_instit");
    		
    		$claoc13$PROXIMO_ANO->incluir(null);
    	  if ($claoc13$PROXIMO_ANO->erro_status == 0) {
    	    throw new Exception($claoc13$PROXIMO_ANO->erro_msg);
        }
    		
    	}
    	
    	/**
    	 * registro 14
    	 */
    	$sSql = "select '14' as tipoRegistro,
	o46_codlei as codReduzidoDecreto,
	case when o47_valor > 0 then 1 else 2 end as tipoAlteracao,
	si09_codorgaotce as codOrgao,
	lpad(o58_orgao,2,0)||lpad(o58_unidade,3,0) as codUnidadeSub,
	o58_funcao as codFuncao,
	o58_subfuncao as codSubFuncao,
	o58_programa as codPrograma,
	o58_projativ as idAcao,
	' ' as idSubAcao,
	substr(o56_elemento,2,6) as naturezaDespesa,
	o15_codtri as codFontRecursos,
	abs(o47_valor) as vlAcrescimoReducao
  from orcsuplemval 
  join orcsuplem on o47_codsup = o46_codsup 
  join orcdotacao on  o47_anousu = o58_anousu and o47_coddot = o58_coddot
  join orcelemento on o58_codele = o56_codele and o58_anousu = o56_anousu
  join orctiporec on o58_codigo = o15_codigo
  join db_config on o58_instit = codigo
  left join infocomplementaresinstit on codigo = si09_instit 
  where o46_codlei in ({$oDados10->codigovinc})";
    	$rsResult14 = db_query($sSql);
    	
    	for ($iCont14 = 0; $iCont14 < pg_num_rows($rsResult14); $iCont14++) {
    		
    		$oDados14 = db_utils::fieldsMemory($rsResult14, $iCont14);
    		$claoc14$PROXIMO_ANO = new cl_aoc14$PROXIMO_ANO();
    		
    		$claoc14$PROXIMO_ANO->si42_tiporegistro       = 14;
    		$claoc14$PROXIMO_ANO->si42_codreduzidodecreto = $oDados14->codreduzidodecreto;
    		$claoc14$PROXIMO_ANO->si42_tipoalteracao      = $oDados14->tipoalteracao;
    		$claoc14$PROXIMO_ANO->si42_codorgao           = $oDados14->codorgao;
    		$claoc14$PROXIMO_ANO->si42_codunidadesub      = $oDados14->codunidadesub;
    		$claoc14$PROXIMO_ANO->si42_codfuncao          = $oDados14->codfuncao;
    		$claoc14$PROXIMO_ANO->si42_codsubfuncao       = $oDados14->codsubfuncao;
    		$claoc14$PROXIMO_ANO->si42_codprograma        = $oDados14->codprograma;
    		$claoc14$PROXIMO_ANO->si42_idacao             = $oDados14->idacao;
    		$claoc14$PROXIMO_ANO->si42_idsubacao          = $oDados14->idsubacao;
    		$claoc14$PROXIMO_ANO->si42_naturezadespesa    = $oDados14->naturezadespesa;
    		$claoc14$PROXIMO_ANO->si42_codfontrecursos    = $oDados14->codfontrecursos;
    		$claoc14$PROXIMO_ANO->si42_vlacrescimoreducao = $oDados14->vlacrescimoreducao;
    		$claoc14$PROXIMO_ANO->si42_mes                = $this->sDataFinal['5'].$this->sDataFinal['6'];
    		$claoc14$PROXIMO_ANO->si42_reg10              = $claoc10$PROXIMO_ANO->si38_sequencial;
    		$claoc14$PROXIMO_ANO->si42_instit             = db_getsession("DB_instit");
    		
    		$claoc14$PROXIMO_ANO->incluir(null);
    	  if ($claoc14$PROXIMO_ANO->erro_status == 0) {
    	    throw new Exception($claoc14$PROXIMO_ANO->erro_msg);
        }
    		
    	}
    	
    }
    
    db_fim_transacao();
    
    $oGerarAOC = new GerarAOC();
    $oGerarAOC->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];;
    $oGerarAOC->gerarDados();
  	
  }
		
}
