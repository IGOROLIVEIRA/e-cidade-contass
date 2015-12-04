<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_aoc102014_classe.php");
require_once ("classes/db_aoc112014_classe.php");
require_once ("classes/db_aoc122014_classe.php");
require_once ("classes/db_aoc132014_classe.php");
require_once ("classes/db_aoc142014_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2014/GerarAOC.model.php");

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

  	$claoc102014 = new cl_aoc102014();
  	$claoc112014 = new cl_aoc112014();
  	$claoc122014 = new cl_aoc122014();
  	$claoc132014 = new cl_aoc132014();
  	$claoc142014 = new cl_aoc142014();
  	
  	/**
  	 * excluir informacoes do mes selecionado
  	 */
    db_inicio_transacao();
    $result = $claoc112014->sql_record($claoc112014->sql_query(NULL,"*",NULL,"si39_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si39_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$claoc112014->excluir(NULL,"si39_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si39_instit = ".db_getsession("DB_instit"));
      if ($claoc112014->erro_status == 0) {
    	  throw new Exception($claoc112014->erro_msg);
      }
    }
    
    $result = $claoc122014->sql_record($claoc122014->sql_query(NULL,"*",NULL,"si40_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si40_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$claoc122014->excluir(NULL,"si40_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si40_instit = ".db_getsession("DB_instit"));
      if ($claoc122014->erro_status == 0) {
    	  throw new Exception($claoc122014->erro_msg);
      }
    }
    
    $result = $claoc132014->sql_record($claoc132014->sql_query(NULL,"*",NULL,"si41_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si41_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$claoc132014->excluir(NULL,"si41_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si41_instit = ".db_getsession("DB_instit"));
      if ($claoc132014->erro_status == 0) {
    	  throw new Exception($claoc132014->erro_msg);
      }
    }
    
    $result = $claoc142014->sql_record($claoc142014->sql_query(NULL,"*",NULL,"si42_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si42_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$claoc142014->excluir(NULL,"si42_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si42_instit = ".db_getsession("DB_instit"));
      if ($claoc142014->erro_status == 0) {
    	  throw new Exception($claoc142014->erro_msg);
      }
    }
    
    $result = $claoc102014->sql_record($claoc102014->sql_query(NULL,"*",NULL,"si38_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si38_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$claoc102014->excluir(NULL,"si38_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si38_instit = ".db_getsession("DB_instit"));
      if ($claoc102014->erro_status == 0) {
    	  throw new Exception($claoc102014->erro_msg);
      }
    }
    /**
     * fim da exclusao dos registros do mes selecionado
     */
  	
    
    /**
     * selecionar as informacoes pertinentes ao AOC
     */
    
    $sSql = "select  distinct o39_codproj as codigovinc,
       '10' as tiporegistro, 
	     si09_codorgaotce as codorgao, 
	     o39_numero as nroDecreto,
	     o39_data as dataDecreto, o39_tipoproj as tipodecreto  
       from
       orcsuplem 
       join orcsuplemval  on o47_codsup = o46_codsup 
       join orcprojeto    on o46_codlei = o39_codproj
       join db_config on prefeitura  = 't' 
       left join infocomplementaresinstit on si09_instit = ".db_getsession("DB_instit")."
     where o39_data between  '$this->sDataInicial' and '$this->sDataFinal'";
    $rsResult10 = db_query($sSql);
    //db_criatabela($rsResult10);
    $sSqlPrefeitura = "select * from infocomplementaresinstit where  si09_instit =".db_getsession("DB_instit")." and si09_tipoinstit = 2";
    $rsPrefeitura = db_query($sSqlPrefeitura);//db_criatabela($rsPrefeitura);
    
    /*$sSql     = "select * from orcprojetolei where o138_altpercsuplementacao = 2 and o138_data >= '{$this->sDataInicial}' and o138_data <= '{$this->sDataFinal}'";
    $rsResultLei = db_query($sSql);
    && pg_num_rows($rsResultLei) > 0*/
    
    if(pg_num_rows($rsPrefeitura) > 0 ){
    	
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
    	
    	$oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
    	$claoc102014 = new cl_aoc102014();
    	
    	$claoc102014->si38_tiporegistro = 10;
    	$claoc102014->si38_codorgao     = $oDados10->codorgao;
    	$claoc102014->si38_nrodecreto   = str_replace("/", "", $oDados10->nrodecreto);
    	$claoc102014->si38_datadecreto  = $oDados10->datadecreto;
    	$claoc102014->si38_mes          = $this->sDataFinal['5'].$this->sDataFinal['6'];
    	$claoc102014->si38_instit       = db_getsession("DB_instit");
    	
    	$claoc102014->incluir(null);
      if ($claoc102014->erro_status == 0) {
    	  throw new Exception($claoc102014->erro_msg);
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
      $rsResult11 = db_query($sSql);//db_criatabela($rsResult11);
      
      for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {
      	
      	$oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);
      	$claoc112014 = new cl_aoc112014();
      	
      	$claoc112014->si39_tiporegistro         = 11;
      	$claoc112014->si39_codreduzidodecreto   = $oDados11->codreduzidodecreto;
      	$claoc112014->si39_nrodecreto           = str_replace("/", "", $oDados11->nrodecreto);
      	$claoc112014->si39_tipodecretoalteracao = $oDados11->tipodecretoalteracao;
      	$claoc112014->si39_valoraberto          = $oDados11->valoraberto;
      	$claoc112014->si39_mes                  = $this->sDataFinal['5'].$this->sDataFinal['6'];
      	$claoc112014->si39_reg10                = $claoc102014->si38_sequencial;
      	$claoc112014->si39_instit               = db_getsession("DB_instit");
      	
        $claoc112014->incluir(null);
        if ($claoc112014->erro_status == 0) {
    	    throw new Exception($claoc112014->erro_msg);
        }
      	
      }
      
      /**
       * registro 12
       */
    	
       if($oDados10->tipodecreto == 1){
          $sSql = "select '12' as tiporegistro,
                         o39_codproj as codReduzidoDecreto, 
                         o45_numlei as nroLeiAlteracao ,
                         o45_datalei as dataLeiAlteracao, 'LOA' as o138_altpercsuplementacao, 1 as sql 
                   from orcprojeto 
                   join orclei on o39_codlei = o45_codlei
                  where o39_codproj in ({$oDados10->codigovinc})";
          
       }else{
    	 $sSql = "select '12' as tiporegistro, 
					       o39_codproj as codReduzidoDecreto, 
					       o138_numerolei as nroLeiAlteracao , 
					       o138_data as dataLeiAlteracao, 
					       case when o138_altpercsuplementacao =1 then 'LAOP' else 'LAO' end o138_altpercsuplementacao, 2 as sql 
					  from orcprojeto 
					  join orcprojetoorcprojetolei on o139_orcprojeto = o39_codproj 
					  join orcprojetolei on o139_orcprojetolei = o138_sequencial
                    where o39_codproj in ({$oDados10->codigovinc})";
       	
       }
        
    	$rsResult12 = db_query($sSql);//db_criatabela($rsResult12);
    	
    	for ($iCont12 = 0; $iCont12 < pg_num_rows($rsResult12); $iCont12++) {
    		
    		$oDados12 = db_utils::fieldsMemory($rsResult12, $iCont12);
    		$claoc122014 = new cl_aoc122014();
    		
    		$claoc122014->si40_tiporegistro       = 12;
    		$claoc122014->si40_codreduzidodecreto = $oDados12->codreduzidodecreto;
    		$claoc122014->si40_nroleialteracao    = substr($oDados12->nroleialteracao,0,6);
    		$claoc122014->si40_dataleialteracao   = $oDados12->dataleialteracao;
    		$claoc122014->si40_mes                = $this->sDataFinal['5'].$this->sDataFinal['6'];
    		$claoc122014->si40_reg10              = $claoc102014->si38_sequencial;
    		$claoc122014->si40_instit             = db_getsession("DB_instit");
    		
    	  $claoc122014->incluir(null);
        if ($claoc122014->erro_status == 0) {
    	    throw new Exception($claoc122014->erro_msg);
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
    	$rsResult13 = db_query($sSql);//db_criatabela($rsResult13);
    	
    	for ($iCont13 = 0; $iCont13 < pg_num_rows($rsResult13); $iCont13++) {
    		
    		$oDados13 = db_utils::fieldsMemory($rsResult13, $iCont13);
    		$claoc132014 = new cl_aoc132014();
    		
    		$claoc132014->si41_tiporegistro       = 13;
    		$claoc132014->si41_codreduzidodecreto = $oDados13->codreduzidodecreto;
    		$claoc132014->si41_origemrecalteracao = $oDados13->tipodecretoalteracao;
    		$claoc132014->si41_valorabertoorigem  = $oDados13->valoraberto;
    		$claoc132014->si41_mes                = $this->sDataFinal['5'].$this->sDataFinal['6'];
    		$claoc132014->si41_reg10              = $claoc102014->si38_sequencial;
    		$claoc132014->si41_instit             = db_getsession("DB_instit");
    		
    		$claoc132014->incluir(null);
    	  if ($claoc132014->erro_status == 0) {
    	    throw new Exception($claoc132014->erro_msg);
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
	abs(o47_valor) as vlAcrescimoReducao,
	o41_subunidade as subunidade
  from orcsuplemval 
  join orcsuplem on o47_codsup = o46_codsup 
  join orcdotacao on  o47_anousu = o58_anousu and o47_coddot = o58_coddot
  join orcelemento on o58_codele = o56_codele and o58_anousu = o56_anousu
  join orctiporec on o58_codigo = o15_codigo
  join db_config on o58_instit = codigo
  join orcunidade on orcdotacao.o58_orgao = orcunidade.o41_orgao and orcdotacao.o58_unidade = orcunidade.o41_unidade 
  and orcdotacao.o58_anousu = orcunidade.o41_anousu  
  left join infocomplementaresinstit on codigo = si09_instit 
  where o46_codlei in ({$oDados10->codigovinc})";
    	$rsResult14 = db_query($sSql);//db_criatabela($rsResult14);
    	
    	$aDadosAgrupados14 = array();
    	for ($iCont14 = 0; $iCont14 < pg_num_rows($rsResult14); $iCont14++) {
    		
    		$oDadosSql14 = db_utils::fieldsMemory($rsResult14, $iCont14);
    		$sHash  = $oDadosSql14->codreduzidodecreto.$oDadosSql14->tipoalteracao.$oDadosSql14->codorgao.$oDadosSql14->codunidadesub.$oDadosSql14->codfuncao;
    		$sHash .= $oDadosSql14->codprograma.$oDadosSql14->idacao.$oDadosSql14->naturezadespesa.$oDadosSql14->codfontrecursos;
    		
    		if (!isset($aDadosAgrupados14[$sHash])) {
    			
    			$oDados14 = new stdClass();
    	    $oDados14->si42_tiporegistro       = 14;
    		  $oDados14->si42_codreduzidodecreto = $oDadosSql14->codreduzidodecreto;
    		  $oDados14->si42_tipoalteracao      = $oDadosSql14->tipoalteracao;
    		  $oDados14->si42_codorgao           = $oDadosSql14->codorgao;
    		  $oDados14->si42_codunidadesub      = $oDadosSql14->codunidadesub;
    		  $oDados14->si42_codfuncao          = $oDadosSql14->codfuncao;
    		  $oDados14->si42_codsubfuncao       = $oDadosSql14->codsubfuncao;
    		  $oDados14->si42_codprograma        = $oDadosSql14->codprograma;
    		  $oDados14->si42_idacao             = $oDadosSql14->idacao;
    		  $oDados14->si42_idsubacao          = $oDadosSql14->idsubacao;
    		  $oDados14->si42_naturezadespesa    = $oDadosSql14->naturezadespesa;
    		  $oDados14->si42_codfontrecursos    = $oDadosSql14->codfontrecursos;
    		  $oDados14->si42_vlacrescimoreducao = $oDadosSql14->vlacrescimoreducao;
    		  $oDados14->si42_mes                = $this->sDataFinal['5'].$this->sDataFinal['6'];
    		  $oDados14->si42_reg10              = $claoc102014->si38_sequencial;
    		  $oDados14->si42_instit             = db_getsession("DB_instit");
    		  $aDadosAgrupados14[$sHash] = $oDados14;
    			
    		} else {
    			
    			$aDadosAgrupados14[$sHash]->si42_vlacrescimoreducao += $oDadosSql14->vlacrescimoreducao;
    			
    		}
    		
    	}
    	
    	foreach ($aDadosAgrupados14 as $oDadosReg14) {
    		
    		$claoc142014 = new cl_aoc142014();
    		
    		$claoc142014->si42_tiporegistro       = $oDadosReg14->si42_tiporegistro;
    		$claoc142014->si42_codreduzidodecreto = $oDadosReg14->si42_codreduzidodecreto;
    		$claoc142014->si42_tipoalteracao      = $oDadosReg14->si42_tipoalteracao;
    		$claoc142014->si42_codorgao           = $oDadosReg14->si42_codorgao;
    		$claoc142014->si42_codunidadesub      = $oDadosReg14->si42_codunidadesub;
    		$claoc142014->si42_codfuncao          = $oDadosReg14->si42_codfuncao;
    		$claoc142014->si42_codsubfuncao       = $oDadosReg14->si42_codsubfuncao;
    		$claoc142014->si42_codprograma        = $oDadosReg14->si42_codprograma;
    		$claoc142014->si42_idacao             = $oDadosReg14->si42_idacao;
    		$claoc142014->si42_idsubacao          = $oDadosReg14->si42_idsubacao;
    		$claoc142014->si42_naturezadespesa    = $oDadosReg14->si42_naturezadespesa;
    		$claoc142014->si42_codfontrecursos    = $oDadosReg14->si42_codfontrecursos;
    		$claoc142014->si42_vlacrescimoreducao = $oDadosReg14->si42_vlacrescimoreducao;
    		$claoc142014->si42_mes                = $oDadosReg14->si42_mes;
    		$claoc142014->si42_reg10              = $oDadosReg14->si42_reg10;
    		$claoc142014->si42_instit             = $oDadosReg14->si42_instit;
    		
    		$claoc142014->incluir(null);
    	  if ($claoc142014->erro_status == 0) {
    	    throw new Exception($claoc142014->erro_msg);
        }
    		
    	}
    	
    }
    }
    db_fim_transacao();
    
    $oGerarAOC = new GerarAOC();
    $oGerarAOC->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];;
    $oGerarAOC->gerarDados();
  	
  }
		
}
