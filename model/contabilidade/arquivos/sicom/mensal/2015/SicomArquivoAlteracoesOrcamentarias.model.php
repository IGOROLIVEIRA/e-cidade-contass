<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_aoc102015_classe.php");
require_once ("classes/db_aoc112015_classe.php");
require_once ("classes/db_aoc122015_classe.php");
require_once ("classes/db_aoc132015_classe.php");
require_once ("classes/db_aoc142015_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2015/GerarAOC.model.php");

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

  	$claoc10 = new cl_aoc102015();
  	$claoc11 = new cl_aoc112015();
  	$claoc12 = new cl_aoc122015();
  	$claoc13 = new cl_aoc132015();
  	$claoc14 = new cl_aoc142015();
  	
  	/**
  	 * excluir informacoes do mes selecionado
  	 */
    db_inicio_transacao();
    $result = $claoc11->sql_record($claoc11->sql_query(NULL,"*",NULL,"si39_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si39_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$claoc11->excluir(NULL,"si39_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si39_instit = ".db_getsession("DB_instit"));
      if ($claoc11->erro_status == 0) {
    	  throw new Exception($claoc11->erro_msg);
      }
    }
    
    $result = $claoc12->sql_record($claoc12->sql_query(NULL,"*",NULL,"si40_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si40_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$claoc12->excluir(NULL,"si40_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si40_instit = ".db_getsession("DB_instit"));
      if ($claoc12->erro_status == 0) {
    	  throw new Exception($claoc12->erro_msg);
      }
    }
    
    $result = $claoc13->sql_record($claoc13->sql_query(NULL,"*",NULL,"si41_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si41_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$claoc13->excluir(NULL,"si41_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si41_instit = ".db_getsession("DB_instit"));
      if ($claoc13->erro_status == 0) {
    	  throw new Exception($claoc13->erro_msg);
      }
    }
    
    $result = $claoc14->sql_record($claoc14->sql_query(NULL,"*",NULL,"si42_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si42_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$claoc14->excluir(NULL,"si42_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si42_instit = ".db_getsession("DB_instit"));
      if ($claoc14->erro_status == 0) {
    	  throw new Exception($claoc14->erro_msg);
      }
    }
    
    $result = $claoc10->sql_record($claoc10->sql_query(NULL,"*",NULL,"si38_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si38_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$claoc10->excluir(NULL,"si38_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si38_instit = ".db_getsession("DB_instit"));
      if ($claoc10->erro_status == 0) {
    	  throw new Exception($claoc10->erro_msg);
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
	     o39_data as dataDecreto,o39_tipoproj as tipodecreto  
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
    $rsPrefeitura = db_query($sSqlPrefeitura);
    //db_criatabela($rsPrefeitura);
    //$sSql     = "select * from orcprojetolei where o138_altpercsuplementacao = 2 and o138_data >= '{$this->sDataInicial}' and o138_data <= '{$this->sDataFinal}'";
    //$rsResultLei = db_query($sSql);
    // && pg_num_rows($rsResultLei) > 0
    
    if(pg_num_rows($rsPrefeitura) > 0){
    	
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
    	
    	$oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
    	$claoc10 = new cl_aoc102015();
    	
    	$claoc10->si38_tiporegistro = 10;
    	$claoc10->si38_codorgao     = $oDados10->codorgao;
    	$claoc10->si38_nrodecreto   = preg_replace("/[^0-9\s]/", "", $oDados10->nrodecreto);
    	$claoc10->si38_datadecreto  = $oDados10->datadecreto;
    	$claoc10->si38_mes          = $this->sDataFinal['5'].$this->sDataFinal['6'];
    	$claoc10->si38_instit       = db_getsession("DB_instit");
    	
    	$claoc10->incluir(null);
      if ($claoc10->erro_status == 0) { 
    	  throw new Exception($claoc10->erro_msg);
      }
      
      /**
       * registro 11
       */
      $sSql = "select '11' as tiporegistro, 
       o46_codlei as codreduzidodecreto, 
       o39_numero as nrodecreto ,
       (case when o46_tiposup in (1002,1005,1006,1007,1008,1009,1010) then 2
	     when o46_tiposup in (1001,1003,1004) then 1
	     when o46_tiposup = 1012 then 6
	     when o46_tiposup = 1013 then 7
	     when o46_tiposup = 1016 then 8
	     when o46_tiposup = 1014 then 9
	     when o46_tiposup = 1015 then 10
       when o46_tiposup = 1017 then 5
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
      //db_criatabela($rsResult11);
      
      for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {
      	
      	$oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);
      	$claoc11 = new cl_aoc112015();
      	
      	$claoc11->si39_tiporegistro         = 11;
      	$claoc11->si39_codreduzidodecreto   = $oDados11->codreduzidodecreto;
      	$claoc11->si39_nrodecreto           = preg_replace("/[^0-9\s]/", "", $oDados11->nrodecreto);
      	$claoc11->si39_tipodecretoalteracao = $oDados11->tipodecretoalteracao;
      	$claoc11->si39_valoraberto          = $oDados11->valoraberto;
      	$claoc11->si39_mes                  = $this->sDataFinal['5'].$this->sDataFinal['6'];
      	$claoc11->si39_reg10                = $claoc10->si38_sequencial;
      	$claoc11->si39_instit               = db_getsession("DB_instit");
      	
        $claoc11->incluir(null);
        if ($claoc11->erro_status == 0) {
    	    throw new Exception($claoc11->erro_msg);
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
                  where o39_codproj in ({$oDados10->codigovinc}) ";
          
       }else{
    	 $sSql = "select '12' as tiporegistro,
                         o39_codproj as codReduzidoDecreto, 
                         o138_numerolei as nroLeiAlteracao ,
                         o138_data as dataLeiAlteracao, 
                         case when o138_altpercsuplementacao =1 then 'LAOP' else 'LAO' end o138_altpercsuplementacao, 2 as sql
                   from orcprojeto
                   join orcprojetoorcprojetolei on o39_codproj = o139_orcprojeto
                   join orcprojetolei on o139_orcprojetolei = o138_sequencial
                    where o39_codproj in ({$oDados10->codigovinc})";
       	
       }
        
    	
    	
    	$rsResult12 = db_query($sSql);
    	//db_criatabela($rsResult12);echo $sSql;
    	
    	for ($iCont12 = 0; $iCont12 < pg_num_rows($rsResult12); $iCont12++) {
    		
    		$oDados12 = db_utils::fieldsMemory($rsResult12, $iCont12);
    		$claoc12 = new cl_aoc122015();

        if($oDados11->tipodecretoalteracao == 1){
          $si40_tipoleialteracao = 1;
        }elseif($oDados11->tipodecretoalteracao == 2){
          $si40_tipoleialteracao = 2;
        }elseif($oDados11->tipodecretoalteracao == 8 || $oDados11->tipodecretoalteracao == 9 
          || $oDados11->tipodecretoalteracao == 10){
          $si40_tipoleialteracao = 3;
        }elseif($oDados11->tipodecretoalteracao == 5){
          $si40_tipoleialteracao = 4;
        }elseif($oDados11->tipodecretoalteracao == 11){
          $si40_tipoleialteracao = 5;
        }
    		
    		$claoc12->si40_tiporegistro       = 12;
    		$claoc12->si40_codreduzidodecreto = $oDados12->codreduzidodecreto;
    		$claoc12->si40_nroleialteracao    = substr($oDados12->nroleialteracao,0,6);
    		$claoc12->si40_dataleialteracao   = $oDados12->dataleialteracao;
            $claoc12->si40_tpleiorigdecreto   = $oDados12->o138_altpercsuplementacao;
            $claoc12->si40_tipoleialteracao   = $oDados12->o138_altpercsuplementacao == "LAO" ? $si40_tipoleialteracao : 0;
            $claoc12->si40_valorabertolei     = $oDados11->valoraberto;
    		$claoc12->si40_mes                = $this->sDataFinal['5'].$this->sDataFinal['6'];
    		$claoc12->si40_reg10              = $claoc10->si38_sequencial;
    		$claoc12->si40_instit             = db_getsession("DB_instit");
    		
    	    $claoc12->incluir(null);
    	    //echo pg_last_error();
        if ($claoc12->erro_status == 0) {
    	    throw new Exception($claoc12->erro_msg);
        }
    		
    	}
    	
    	/**
    	 * registro 13
    	 */
    	$sSql = "select '13'       as tiporegistro,
       o46_codlei as codreduzidodecreto, 
       (case when o46_tiposup in (1001,1006) then 3
	     when o46_tiposup = 1002 then 4
	     when o46_tiposup = 1003 then 1
             when o46_tiposup in (1004,1005,1007,1008,1009,1010) then 2
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
    	//db_criatabela($rsResult13);
    	
    	for ($iCont13 = 0; $iCont13 < pg_num_rows($rsResult13); $iCont13++) {
    		
    		$oDados13 = db_utils::fieldsMemory($rsResult13, $iCont13);
    		$claoc13 = new cl_aoc132015();
    		
    		$claoc13->si41_tiporegistro       = 13;
    		$claoc13->si41_codreduzidodecreto = $oDados13->codreduzidodecreto;
    		$claoc13->si41_origemrecalteracao = $oDados13->tipodecretoalteracao;
    		$claoc13->si41_valorabertoorigem  = $oDados13->valoraberto;
    		$claoc13->si41_mes                = $this->sDataFinal['5'].$this->sDataFinal['6'];
    		$claoc13->si41_reg10              = $claoc10->si38_sequencial;
    		$claoc13->si41_instit             = db_getsession("DB_instit");
    		
    		$claoc13->incluir(null);
    	  if ($claoc13->erro_status == 0) {
    	    throw new Exception($claoc13->erro_msg);
        }
    		
    	}
    	
    	/**
    	 * registro 14
    	 */
    	$sSql = "select '14' as tipoRegistro,
	o46_codlei as codReduzidoDecreto,
  (case when o46_tiposup in (1001,1006) then 3
       when o46_tiposup = 1002 then 4
       when o46_tiposup = 1003 then 1
             when o46_tiposup in (1004,1005,1007,1008,1009,1010) then 2
             else 98
         end 
       ) as tipoDecretoAlteracao,
	case when o47_valor > 0 then 1 else 2 end as tipoAlteracao,
	si09_codorgaotce as codOrgao,
	case when o41_subunidade != 0 or not null then
  lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0)||lpad(o41_subunidade::integer,3,0)
  else lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0) end as codunidadesub,
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
  join orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
  left join infocomplementaresinstit on codigo = si09_instit 
  where o46_codlei in ({$oDados10->codigovinc})";
    	$rsResult14 = db_query($sSql);
    	//db_criatabela($rsResult14);
    	
    	$aDadosAgrupados14 = array();
    	for ($iCont14 = 0; $iCont14 < pg_num_rows($rsResult14); $iCont14++) {
    		
    		$oDadosSql14 = db_utils::fieldsMemory($rsResult14, $iCont14);
    		$sHash  = $oDadosSql14->codreduzidodecreto.$oDadosSql14->tipoalteracao.$oDadosSql14->codorgao.$oDadosSql14->codunidadesub.$oDadosSql14->codfuncao;
    		$sHash .= $oDadosSql14->codprograma.$oDadosSql14->idacao.$oDadosSql14->naturezadespesa.$oDadosSql14->codfontrecursos;
    		
    		if (!isset($aDadosAgrupados14[$sHash])) {
    			
    		  $oDados14 = new stdClass();
    	      $oDados14->si42_tiporegistro       = 14;
    		  $oDados14->si42_codreduzidodecreto = $oDadosSql14->codreduzidodecreto;
    		  $oDados14->si42_origemrecalteracao = $oDadosSql14->tipodecretoalteracao;
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
    		  $oDados14->si42_reg10              = $claoc10->si38_sequencial;
    		  $oDados14->si42_instit             = db_getsession("DB_instit");
    		  $aDadosAgrupados14[$sHash] = $oDados14;
    			
    		} else {
    			
    			$aDadosAgrupados14[$sHash]->si42_vlacrescimoreducao += $oDadosSql14->vlacrescimoreducao;
    			
    		}
    		
    	}
    	
    	foreach ($aDadosAgrupados14 as $oDadosReg14) {
    		
    		$claoc14 = new cl_aoc142015();
    		
    		$claoc14->si42_tiporegistro       = $oDadosReg14->si42_tiporegistro;
    		$claoc14->si42_codreduzidodecreto = $oDadosReg14->si42_codreduzidodecreto;
    		$claoc14->si42_tipoalteracao      = $oDadosReg14->si42_tipoalteracao;
    		$claoc14->si42_codorgao           = $oDadosReg14->si42_codorgao;
    		$claoc14->si42_codunidadesub      = $oDadosReg14->si42_codunidadesub;
    		$claoc14->si42_codfuncao          = $oDadosReg14->si42_codfuncao;
    		$claoc14->si42_codsubfuncao       = $oDadosReg14->si42_codsubfuncao;
    		$claoc14->si42_codprograma        = $oDadosReg14->si42_codprograma;
    		$claoc14->si42_idacao             = $oDadosReg14->si42_idacao;
    		$claoc14->si42_idsubacao          = $oDadosReg14->si42_idsubacao;
    		$claoc14->si42_naturezadespesa    = $oDadosReg14->si42_naturezadespesa;
    		$claoc14->si42_codfontrecursos    = $oDadosReg14->si42_codfontrecursos;
    		$claoc14->si42_vlacrescimoreducao = $oDadosReg14->si42_vlacrescimoreducao;
    		$claoc14->si42_origemrecalteracao = $oDadosReg14->si42_origemrecalteracao;
    		$claoc14->si42_mes                = $oDadosReg14->si42_mes;
    		$claoc14->si42_reg10              = $oDadosReg14->si42_reg10;
    		$claoc14->si42_instit             = $oDadosReg14->si42_instit;
    		
    		$claoc14->incluir(null);
    	  if ($claoc14->erro_status == 0) {
    	    throw new Exception($claoc14->erro_msg);
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
