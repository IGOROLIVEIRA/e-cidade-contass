<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_ext102015_classe.php");
require_once ("classes/db_ext202015_classe.php");
require_once ("classes/db_ext212015_classe.php");
require_once ("classes/db_ext222015_classe.php");
require_once ("classes/db_ext232015_classe.php");

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2015/GerarEXT.model.php");

 /**
  * Detalhamento Extra Ocamentarias Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoDetalhamentoExtraOrcamentarias extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 171;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'EXT';
  
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
    
  }
  
  /**
   * selecionar os dados de //
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
  	
  	$cExt10 = new cl_ext102015();
  	$cExt20 = new cl_ext202015();
  	$cExt21 = new cl_ext212015();
  	$cExt22 = new cl_ext222015();
  	$cExt23 = new cl_ext232015();
  	/*
  	 * CASO JA TENHA SIDO GERADO ALTERIORMENTE PARA O MESMO PERIDO O SISTEMA IRA 
  	 * EXCLUIR OS REGISTROS E GERAR NOVAMENTE
  	 * 
  	 */
  	//$aCaracteres = array("°",chr(13),chr(10),"'",";",".");
  	     
  	    db_inicio_transacao();
  	     
	    
	      $cExt23->excluir(NULL,"si127_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." 
	    								and si127_instit = ".db_getsession("DB_instit"));
	      if ($cExt23->erro_status == 0) {
	    	  throw new Exception($cExt23->erro_msg);
	      }
	      
	      $cExt22->excluir(NULL,"si126_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si126_instit = ".db_getsession("DB_instit"));
	    
	      if ($cExt22->erro_status == 0) {
	    	  throw new Exception($cExt22->erro_msg);
	      }
	      $cExt21->excluir(NULL,"si125_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." 
	    								and si125_instit = ".db_getsession("DB_instit"));
	      if ($cExt21->erro_status == 0) {
	    	  throw new Exception($cExt21->erro_msg);
	      }
	      $cExt20->excluir(NULL,"si165_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." 
	    								and si165_instit = ".db_getsession("DB_instit"));
	    
	      if ($cExt20->erro_status == 0) {
	    	  throw new Exception($cExt20->erro_msg);
	      }
	      $cExt10->excluir(NULL,"si124_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." 
	    								and si124_instit = ".db_getsession("DB_instit"));
		  if ($cExt10->erro_status == 0) {
		    	  throw new Exception($cExt10->erro_msg);
		  }
	   
	    
	   db_fim_transacao(); 
	  
	 	//exit;
  	
  	
  	
  	    /*
  	     * SQL RETORNA TODAS AS CONTAS EXTRAS EXISTENTES NO SISTEMA
  	     * 
  	     */
  	    $sSqlExt = "select 10 as tiporegistro,c61_codcon, 
				       c61_reduz as codext, 
				       c61_codtce as codtce,
				       si09_codorgaotce as codorgao,
				       (select CASE
									    WHEN o41_subunidade != 0
									         OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
									            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
									              OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
									    ELSE lpad((CASE WHEN o40_codtri = '0'
									         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
									           OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)    
					             end as unidade 
					  from orcunidade 
					  join orcorgao on o41_anousu = o40_anousu and o41_orgao = o40_orgao 
					  where o41_instit = ".db_getsession("DB_instit")." and o40_anousu = ".db_getsession("DB_anousu")." order by o40_orgao limit 1) as codUnidadeSub,
				       substr(c60_tipolancamento::varchar,1,2) as tipolancamento,
				       case when c60_tipolancamento = 1 and c60_subtipolancamento not in (1,2,3,4) then c61_reduz
				            when c60_tipolancamento = 2 then 1 
				            when c60_tipolancamento = 3 and c60_subtipolancamento not in (1,2,3) then c61_reduz 
				            when c60_tipolancamento = 4 and c60_subtipolancamento not in (1,2,3,4,5,6,7) then c61_reduz
				            when (c60_tipolancamento = 99 OR c60_tipolancamento = 9999) and c60_subtipolancamento = 9999 then c61_reduz
				            else c60_subtipolancamento
				       end as subtipo,
				       case when c60_tipolancamento = 1 and c60_subtipolancamento not in (1,2,3,4) then 0
				            when c60_tipolancamento = 2 then 0
				            when c60_tipolancamento = 3 then 0 
				            when c60_tipolancamento = 4 and c60_subtipolancamento not in (1,2,3,4,5,6,7) then c61_reduz
				            else c60_desdobramneto
				       end as desdobrasubtipo,
				       substr(c60_descr,1,50) as descextraorc
				  from conplano 
				  join conplanoreduz on c60_codcon = c61_codcon and c60_anousu = c61_anousu 
				  left join infocomplementaresinstit on si09_instit = c61_instit 
				  where c60_anousu = ".db_getsession("DB_anousu")." and c60_codsis = 7 and c61_instit = ".db_getsession("DB_instit")."
  				order by c61_reduz  ";
  	    $rsContasExtra = db_query($sSqlExt);//echo pg_last_error();db_criatabela($rsContasExtra);
  	    
		      // matriz de entrada
    $what = array("°",chr(13),chr(10), 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','Ã','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );

    // matriz de saída
    $by   = array('','','', 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','A','E','I','O','U','n','n','c','C',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ' );
  	    
  	    
  	    $aSaldosIniFim = array();
	    for ($iContador = 0;$iContador < pg_num_rows($rsContasExtra); $iContador++) {
	        
	    	$oContaExtraSaldo = db_utils::fieldsMemory($rsContasExtra,$iContador); 
  	    
  	    
             /*
	  	     * PEGA SALDO INICIAL E FINAL DAS CONTAS EXTRAS DE TODAS AS CONTAS E COLOCA EM UM ARRAY
	  	     */
	    	
	    	$where  = " c61_instit in (".db_getsession("DB_instit").") ";
	    	$where .= " and c61_reduz = ".$oContaExtraSaldo->codext . " and c61_reduz != 0";
	 
	 		
	    	db_inicio_transacao();
	        $rsPlanoContasSaldo = db_planocontassaldo_matriz(db_getsession("DB_anousu"), $this->sDataInicial, $this->sDataFinal, false, $where);
	        
	        db_fim_transacao(true);
	        
	       	//db_criatabela($rsPlanoContasSaldo);	
	       	
	        for ($iContPlano = 0; $iContPlano < pg_num_rows($rsPlanoContasSaldo);$iContPlano++) {
	    	  
		      	if (db_utils::fieldsMemory($rsPlanoContasSaldo, $iContPlano)->c61_reduz != 0) {
		      	  $oPlanoContas = db_utils::fieldsMemory($rsPlanoContasSaldo, $iContPlano);
		      	  $oSaldoInicioFim = new stdClass();
		      	  $oSaldoInicioFim->reduz = $oPlanoContas->c61_reduz;
		      	  $oSaldoInicioFim->sinal_anterior = $oPlanoContas->sinal_anterior;
		      	  $oSaldoInicioFim->sinal_final    = $oPlanoContas->sinal_final;
		      	  $oSaldoInicioFim->sdini = $oPlanoContas->saldo_anterior;
		      	  $oSaldoInicioFim->sdfim = $oPlanoContas->saldo_final;
		      	  
		      	  
		      	  $aSaldosIniFim[] = $oSaldoInicioFim;
		      	}     	
	        }
	    }
	    
	 	    
	    /*
	     * PERCORRE OS SQL NOVAMENTE PARA INSERIR NA BASE DE DADOS OS REGISTROS 
	     */
	    db_inicio_transacao();
	    
	   
	    $aExt10Agrupodo = array();
	    for ($iCont10 = 0;$iCont10 < pg_num_rows($rsContasExtra); $iCont10++) {
	        
	    	$oContaExtra = db_utils::fieldsMemory($rsContasExtra,$iCont10);
               
	  	           
	        /*
	         * VERIFICA SE A CONTA EXTRA JA FOI INFORMADA EM  MES ANTERIOR 
	         * SE EXITIR NAO INFORMAR NOVAMENTE
	         *
	       $result = $cExt10->sql_record($cExt10->sql_query(NULL,"*",NULL,"si124_mes < ".$this->sDataFinal['5'].$this->sDataFinal['6']."
	       				 and si124_codext =".$oContaExtra->codext)." and si124_instit = ".db_getsession("DB_instit"));
	       if (pg_num_rows($result) == 0) {*/
	       	
	       		
	       		$aHash  = $oContaExtra->codorgao;
	       		$aHash .= $oContaExtra->codunidadesub;
	       		$aHash .= $oContaExtra->tipolancamento;
	       		$aHash .= $oContaExtra->subtipo;
	       		$aHash .= $oContaExtra->desdobrasubtipo; 
	       		
	       		if(!isset($aExt10Agrupodo[$aHash])){
		       		$cExt10 = new cl_ext102015();
		       		
		       		$cExt10->si124_tiporegistro     = $oContaExtra->tiporegistro;
		       		$cExt10->si124_codext  			= $oContaExtra->codtce != 0 ? $oContaExtra->codtce : $oContaExtra->codext;
		       		$cExt10->si124_codorgao 		= $oContaExtra->codorgao;
		       		$cExt10->si124_codunidadesub 	= $oContaExtra->codunidadesub;
		       		$cExt10->si124_tipolancamento 	= $oContaExtra->tipolancamento;
		       		$cExt10->si124_subtipo 			= substr($oContaExtra->subtipo,0,3).substr($oContaExtra->subtipo,-1);
		       		$cExt10->si124_desdobrasubtipo 	= substr($oContaExtra->desdobrasubtipo,0,4);
		       		$cExt10->si124_descextraorc 	= $oContaExtra->descextraorc;
		       		$cExt10->si124_mes				= $this->sDataFinal['5'].$this->sDataFinal['6'];
		       		$cExt10->si124_instit			= db_getsession("DB_instit");
		       		$cExt10->extras					= array();
		       		
		       		$sSqlVerifica  = "SELECT * FROM ext102015 WHERE si124_codorgao = '$oContaExtra->codorgao' AND si124_codunidadesub = '$oContaExtra->codunidadesub'
		       		AND si124_tipolancamento = '$oContaExtra->tipolancamento' AND si124_subtipo = '".substr($oContaExtra->subtipo,0,3).substr($oContaExtra->subtipo,-1)."' 
		       		AND si124_desdobrasubtipo = '".substr($oContaExtra->desdobrasubtipo,0,4)."' and si124_mes < ".$this->sDataFinal['5'].$this->sDataFinal['6'];
		       		$sSqlVerifica .= " UNION SELECT * FROM ext102014 WHERE si124_codorgao = '$oContaExtra->codorgao' AND si124_codunidadesub = '$oContaExtra->codunidadesub'
		       		AND si124_tipolancamento = '$oContaExtra->tipolancamento' AND si124_subtipo = '".substr($oContaExtra->subtipo,0,4)."' 
		       		AND si124_desdobrasubtipo = '$oContaExtra->desdobrasubtipo' ";
		       		$rsResulVerifica = db_query($sSqlVerifica);//db_criatabela($rsResulVerifica);
		       		
		       		if (pg_num_rows($rsResulVerifica) == 0) {
		       	    
		       			$cExt10->incluir(null);
			       
			       	    if ($cExt10->erro_status == 0) {
				    	      throw new Exception($cExt10->erro_msg);
				          }
			          
		       		}
		       		
				    $cExt10->extras[]= $oContaExtra->codext;
		            $aExt10Agrupodo[$aHash] = $cExt10;
	       		}else{
	       		   $aExt10Agrupodo[$aHash]->extras[] = $oContaExtra->codext;
	       		}
	       //}
	       
	    }
	    //echo "<pre>";print_r($aExt10Agrupodo); echo "<br>--------------------<br>";
	    
	    foreach ($aExt10Agrupodo as $oExt10Agrupado) {
	    		    	
	    	$cExt20   = new cl_ext202015();
	    	$aExt21 = array();
	    	foreach ($oExt10Agrupado->extras as $nExtras) {
	    		
	    	
	        /*
	         * GRAVAR DADOS DO REGISTRO 20
	         */
	    	
	        /* SQL RETORNA A FONTE DE RECURSO DA CONTA EXTRA */
	        $sSqlExtRecurso = "select o15_codtri from conplanoreduz 
	        join orctiporec on c61_codigo = o15_codigo where c61_anousu = ".db_getsession("DB_anousu")." and c61_reduz = ". $nExtras;
			$rsExtRecurso = db_query($sSqlExtRecurso);
			
			$oExtRecurso = db_utils::fieldsMemory($rsExtRecurso, 0)->o15_codtri;
					/*
					 * PEGA SALDO ALTERIOR E FINAL 	
					 */
			        foreach ($aSaldosIniFim as $nSaldoIniFim){
			        	if($nSaldoIniFim->reduz == $nExtras ){
			        		$saldoanterior = $nSaldoIniFim->sinal_anterior == 'C' ? ($nSaldoIniFim->sdini*-1) : $nSaldoIniFim->sdini;
			        		$saldofinal    = $nSaldoIniFim->sinal_final == 'C' ? ($nSaldoIniFim->sdfim*-1) : $nSaldoIniFim->sdfim;
			        		$natsaldoanteriorfonte = $nSaldoIniFim->sinal_anterior;
			        		$natsaldoatualfonte    = $nSaldoIniFim->sinal_final;
			        		break;
			        	}
			        }			        
			
			        if(empty($cExt20->si165_tiporegistro)){
			        	
				        $cExt20->si165_tiporegistro 		   = '20';
				        $cExt20->si165_codorgao 			   = $oExt10Agrupado->si124_codorgao;
				        $cExt20->si165_codext 				   = $oExt10Agrupado->si124_codext;
				        $cExt20->si165_codfontrecursos 		   = $oExtRecurso;
				        $cExt20->si165_vlsaldoanteriorfonte    = $saldoanterior;
				        $cExt20->si165_natsaldoanteriorfonte   = $natsaldoanteriorfonte == '' ? 'D' : $natsaldoanteriorfonte;
				        $cExt20->si165_vlsaldoatualfonte       = $saldofinal;
				        $cExt20->si165_natsaldoatualfonte      = $natsaldoatualfonte == '' ? 'D' : $natsaldoatualfonte;
				        $cExt20->si165_mes 					   = $this->sDataFinal['5'].$this->sDataFinal['6'];
				        $cExt20->si165_instit			       = db_getsession("DB_instit");
				        $cExt20->ext21						   = array();
				        
			        }else{
			        	
			        	$cExt20->si165_vlsaldoanteriorfonte += $saldoanterior;
				        $cExt20->si165_vlsaldoatualfonte    += $saldofinal;
				        
			        }
			        //echo "<pre>";print_r($cExt20);
			        
		    /*
	         * CARREGA OS DADOS DO REGISTRO 21 
	         */
			$sSql21 = "select   '21' as tiporegitro,
						         c84_conlancam as codreduzidomov,
						         k17_codigo as codigo,
						         k17_credito	 as codext, 
						         o15_codtri::int as codfontrecursos,
						         case when c71_coddoc in (130,150,160) then 1 else 2 end as categoria,
						         c71_data as dtlancamento,
						         k17_valor as vllancamento, 
						         2 as tipo,c71_coddoc
						     from slip 
						     join conlancamslip on k17_codigo = c84_slip
						     join conlancamdoc  on c71_codlan = c84_conlancam
						     join conplanoreduz on k17_credito = c61_reduz and c61_anousu = ".db_getsession("DB_anousu")."
						     join orctiporec on o15_codigo  = c61_codigo
						left join infocomplementaresinstit on k17_instit = si09_instit
						    where c71_data between '".$this->sDataInicial."' and '".$this->sDataFinal."' 
						      and k17_credito = {$nExtras} and k17_situacao = 2
						      and c71_coddoc in (120,151,161,130,160)
						  
						union all 
						
						select   '21' as tiporegitro,
						         c84_conlancam as codreduzidomov,
						         k17_codigo as codigo,
						         k17_debito	 as codext, 
						         o15_codtri::int as codfontrecursos,
						         case when c71_coddoc in (130,150,160) then 1 else 2 end as categoria,
						         c71_data as dtlancamento,
						         k17_valor as vllancamento, 
						         2 as tipo,c71_coddoc
						     from slip 
						     join conlancamslip on k17_codigo = c84_slip
						     join conlancamdoc  on c71_codlan = c84_conlancam
						     join conplanoreduz on k17_debito = c61_reduz and c61_anousu = ".db_getsession("DB_anousu")."
						     join orctiporec on o15_codigo  = c61_codigo
						left join infocomplementaresinstit on k17_instit = si09_instit
						 where c71_data between '".$this->sDataInicial."' AND '".$this->sDataFinal."' 
						   and k17_debito = {$nExtras} and k17_situacao = 2
						   and c71_coddoc in (120,151,161,130,160) 
						   
						union all
						
						select '21' as tiporegitro,
							     c69_codlan as codreduzidomov,
							     0 as codigo,
							     c69_credito	 as codext, 
							     o15_codtri::int as codfontrecursos,
							     1 as categoria,
							     c69_data as dtlancamento,
							     c69_valor as vllancamento, 
						         0 as tipo, 1 as c71_coddoc
						  	from conlancamval 
						  inner join conlancamcompl on c72_codlan = c69_codlan
						  inner join conplanoreduz on c69_credito = c61_reduz and c61_anousu = ".db_getsession("DB_anousu")."
						  inner join orctiporec on o15_codigo  = c61_codigo
						  inner join conlancamcorrente on c69_codlan = c86_conlancam
						  inner join corrente on c86_id =k12_id and c86_data=k12_data and c86_autent = k12_autent
						  inner join corgrupocorrente on c86_id =k105_id and c86_data=k105_data and c86_autent = k105_autent
						  inner join retencaocorgrupocorrente on k105_sequencial = e47_corgrupocorrente
						  inner join retencaoreceitas on e47_retencaoreceita = e23_sequencial and e23_ativo = 't'
						   left join infocomplementaresinstit on c61_instit = si09_instit 
						       where c69_credito = {$nExtras} 
							 and c69_data between '".$this->sDataInicial."' AND '".$this->sDataFinal."' 
							 and (c72_complem like '%planilha%' or c72_complem like '%recibo%');
						
						";
			
					$rsExt21 = db_query($sSql21);
					//if ($oExt10Agrupado->si124_codext == 4218) db_criatabela($rsExt21);
					
					/*FOR PARA PEGAR O REGISTRO 21 E COLOCAR NO 20*/
					for($linha = 0; $linha < pg_num_rows($rsExt21); $linha++){
						 
						 $oExt21 = db_utils::fieldsMemory($rsExt21,$linha);
		       			 
						 $Hash = $oExt10Agrupado->si124_codext.$oExt21->codfontrecursos.$oExt21->categoria.$oExt21->dtlancamento;
						 //ECHO $oExt21->codext." - ".$oExt21->codreduzidomov." - ".$Hash."<BR>";
						 if(!isset($aExt21[$Hash])){
						 
							 $cExt21   = new stdClass();
			       			
			       			 $cExt21->si125_tiporegistro 		= $oExt21->tiporegitro;
							 $cExt21->si125_codreduzidomov 		= $oExt21->codreduzidomov;
							 $cExt21->si125_codext 				= $oExt10Agrupado->si124_codext;
							 $cExt21->si125_codfontrecursos 	= $oExt21->codfontrecursos;
							 $cExt21->si125_categoria 			= $oExt21->categoria;
							 $cExt21->si125_dtlancamento 		= $oExt21->dtlancamento;
							 $cExt21->si125_vllancamento 		= $oExt21->vllancamento;
			       			 $cExt21->si125_mes 				= $this->sDataFinal['5'].$this->sDataFinal['6'];
			       			 $cExt21->si125_reg20				= $cExt20->si165_sequencial;
				             $cExt21->si125_instit			    = db_getsession("DB_instit");
				             $cExt21->ext22						= array();
				             
				             $aExt21[$Hash] = $cExt21;
		       			
						 }else{
						 	$aExt21[$Hash]->si125_vllancamento += $oExt21->vllancamento;
						 }
						
						    $sSql22 = "select '22' as tiporegitro,
									         c71_codlan as codreduzidomov,
									         (slip.k17_codigo||slip.k17_debito) ::int8 as codreduzidoop,
									         (slip.k17_codigo||slip.K17_debito) ::int8 as nroop,
									         c71_data as dtpagamento,
									         case when length(cc.z01_cgccpf::char) = 11 then 1 else 2 end as tipodocumentocredor,
									         cc.z01_cgccpf as nrodocumentocredor,
									         k17_valor as vlop,
									         k17_texto as especificacaoop,
									         substr(c.z01_cgccpf,1,11) as cpfresppgto,2 as tipo
									     from slip
									     join slipnum on slipnum.k17_codigo = slip.k17_codigo 
									     join conlancamslip on slip.k17_codigo = c84_slip
									     join conlancamdoc  on c71_codlan = c84_conlancam
									     join conplanoreduz on k17_debito = c61_reduz and c61_anousu = ".db_getsession("DB_anousu")."
									     join orctiporec on o15_codigo  = c61_codigo
									     join cgm cc on cc.z01_numcgm = slipnum.k17_numcgm
									left join infocomplementaresinstit on k17_instit = si09_instit
									left join cgm c on c.z01_numcgm = si09_gestor
									 where c71_data between '".$this->sDataInicial."' AND '".$this->sDataFinal."'
									   and slip.k17_codigo = {$oExt21->codigo} and slip.k17_situacao = 2
									   and c71_coddoc in (120,151,161,130,160) ";
									 
					 if ($oExt21->categoria == 2) {					 
						 $rsExt22 = db_query($sSql22);
						 //db_criatabela($rsExt22);
						 /*FOR PARA PEGAR O REGISTRO 22 E COLOCAR NO 21*/
						 for($linha22 = 0; $linha22 < pg_num_rows($rsExt22); $linha22++){
						 
						 	$oExt22 = db_utils::fieldsMemory($rsExt22,$linha22);
						 						 	
						 	$cExt22 =  new stdClass();
						 						 	
						 	$cExt22->si126_tiporegistro 		=  $oExt22->tiporegitro;
						 	$cExt22->si126_codreduzidoeo 		=  $aExt21[$Hash]->si125_codreduzidomov;
						 	$cExt22->si126_codreduzidoop 		=  $oExt22->codreduzidoop;
						 	$cExt22->si126_nroop 				=  $oExt22->nroop;
						 	$cExt22->si126_dtpagamento 			=  $oExt22->dtpagamento;
						 	$cExt22->si126_tipodocumentocredor 	=  strlen($oExt22->nrodocumentocredor) == 11 ? 1 : 2;
						 	$cExt22->si126_nrodocumento 		=  $oExt22->nrodocumentocredor;
						 	$cExt22->si126_vlop 				=  $oExt22->vlop;
						 	$cExt22->si126_especificacaoop 		= trim(preg_replace("/[^a-zA-Z0-9 ]/", "",substr(str_replace($what, $by, $oExt22->especificacaoop), 0, 200)));
						 	$cExt22->si126_cpfresppgto 			=  $oExt22->cpfresppgto;
						 	$cExt22->si126_mes 					=  $this->sDataFinal['5'].$this->sDataFinal['6'];
			       			$cExt22->si126_reg21				=  0;
				            $cExt22->si126_instit			    =  db_getsession("DB_instit");
				            $cExt22->ext23						=  array();
				            
				            $sSql23 ="SELECT   23 AS tiporegistro,
											         (k17_codigo||K17_credito) AS codreduzidoop,
											         CASE WHEN e96_codigo = 1 THEN 5
											             WHEN e96_codigo = 2 THEN 1 
											             ELSE 99  
											         END AS tipodocumentoop,
											         CASE WHEN e96_codigo = 2 THEN e91_cheque 
											             ELSE NULL 
											         END AS nrodocumento,
											         K17_debito AS codctb,
											         o15_codtri AS codfontectb,
											         k17_data AS dtemissao,
											         k17_valor AS vldocumento
											      FROM slip
											INNER JOIN conplanoreduz cr ON cr.c61_reduz  = k17_credito and cr.c61_anousu = EXTRACT(YEAR from k17_data)::int
											INNER JOIN conplano      ON c61_codcon = c60_codcon and c60_anousu = c61_anousu
											       AND c61_anousu = c60_anousu
											INNER JOIN orctiporec    ON c61_codigo = o15_codigo
											INNER JOIN conplanoreduz db ON db.c61_reduz  = k17_debito and db.c61_anousu = EXTRACT(YEAR from k17_data)::int
											INNER JOIN conplanoconta ON c63_codcon = db.c61_codcon
											       AND db.c61_anousu = c63_anousu
											INNER JOIN empageslip ON e89_codigo = k17_codigo
											INNER JOIN empagemov  ON e81_codmov = e89_codmov
											       AND e81_cancelado IS NULL
											 LEFT JOIN empagemovforma ON e97_codmov   = e81_codmov
											 LEFT JOIN empageforma    ON e97_codforma = e96_codigo
											 LEFT JOIN empageconfche  ON e91_codmov   = e81_codmov
											       AND e91_ativo IS TRUE
											     WHERE k17_codigo = {$oExt21->codigo}
											UNION ALL        
											SELECT   23 AS tiporegistro,
											         (k17_codigo||K17_debito) AS codreduzidoop,
											         CASE WHEN e96_codigo = 1 THEN 5
											             WHEN e96_codigo = 2 THEN 1 
											             ELSE 99 
											         END AS tipodocumentoop,
											         CASE WHEN e96_codigo = 2 THEN e91_cheque 
											             ELSE NULL 
											         END AS nrodocumento,
											         K17_credito AS codctb,
											         o15_codtri AS codfontectb,
											         k17_data AS dtemissao,
											         k17_valor AS vldocumento
											      FROM slip
											INNER JOIN conplanoreduz cr ON cr.c61_reduz  = k17_debito and cr.c61_anousu = EXTRACT(YEAR from k17_data)::int
											INNER JOIN conplano      ON c61_codcon = c60_codcon and c60_anousu = c61_anousu
											       AND c61_anousu = c60_anousu
											INNER JOIN orctiporec    ON c61_codigo = o15_codigo
											INNER JOIN conplanoreduz db ON db.c61_reduz  = k17_credito and db.c61_anousu = EXTRACT(YEAR from k17_data)::int
											INNER JOIN conplanoconta ON c63_codcon = db.c61_codcon
											       AND db.c61_anousu = c63_anousu
											INNER JOIN empageslip ON e89_codigo = k17_codigo
											INNER JOIN empagemov  ON e81_codmov = e89_codmov
											       AND e81_cancelado IS NULL
											 LEFT JOIN empagemovforma ON e97_codmov   = e81_codmov
											 LEFT JOIN empageforma    ON e97_codforma = e96_codigo
											 LEFT JOIN empageconfche  ON e91_codmov   = e81_codmov
											       AND e91_ativo IS TRUE
											     WHERE k17_codigo = {$oExt21->codigo}";
							
											            
				             $rsExt23 = db_query($sSql23);
				             if( pg_num_rows($rsExt23) == 0){
				             	     $cExt23 = new stdClass();
								 	 
								 	 $cExt23->si127_tiporegistro    =  23; 
									 $cExt23->si127_codreduzidoop   =  $oExt22->codreduzidoop; 
									 $cExt23->si127_tipodocumentoop =  99; 
									 $cExt23->si127_nrodocumento    =  0; 
									 $cExt23->si127_codctb          =  0; 
									 $cExt23->si127_codfontectb     =  0; 
									 $cExt23->si127_desctipodocumentoop =  'TED';
									 $cExt23->si127_dtemissao       =  $oExt22->dtpagamento;
									 $cExt23->si127_vldocumento     =  $oExt22->vlop;
									 $cExt23->si127_mes 			=  $this->sDataFinal['5'].$this->sDataFinal['6'];
				       			     $cExt23->si127_reg21			=  0;
					                 $cExt23->si127_instit			=  db_getsession("DB_instit");
					                 
					                 $cExt22->ext23[] = $cExt23;
				             }else{
				             
						     /*FOR PARA PEGAR O REGISTRO 23 E COLOCAR NO 22*/
								 for($linha23 = 0; $linha23 < pg_num_rows($rsExt23); $linha23++){
								 
								 	 $oExt23 = db_utils::fieldsMemory($rsExt23,$linha23);
								 	 
								 	 $sSqlContaPagFont = "select distinct si95_codctb  as conta, si96_codfontrecursos as fonte from conplanoconta 
											join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu 
											join ctb102015 on 
											si95_banco   = c63_banco and
											si95_agencia = c63_agencia and 
											si95_digitoverificadoragencia = c63_dvagencia and
											si95_contabancaria = c63_conta::int8 and
											si95_digitoverificadorcontabancaria = c63_dvconta and
											si95_tipoconta::int8 = c63_tipoconta join ctb202015 on si96_codctb = si95_codctb and si96_mes = si95_mes
											        where c61_reduz = {$oExt23->codctb} and c61_anousu = ".db_getsession("DB_anousu")." 
											        and si95_mes <=".$this->sDataFinal['5'].$this->sDataFinal['6'];
				             $sSqlContaPagFont .= " UNION select distinct si95_codctb  as conta, si96_codfontrecursos as fonte from conplanoconta 
											join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu 
											join ctb102014 on 
											si95_banco   = c63_banco and
											si95_agencia = c63_agencia and 
											si95_digitoverificadoragencia = c63_dvagencia and
											si95_contabancaria = c63_conta::int8 and
											si95_digitoverificadorcontabancaria = c63_dvconta and
											si95_tipoconta::int8 = c63_tipoconta join ctb202014 on si96_codctb = si95_codctb and si96_mes = si95_mes
											        where c61_reduz = {$oExt23->codctb} and c61_anousu = ".db_getsession("DB_anousu");
				           $rsResultContaPag = db_query($sSqlContaPagFont);
				           $oConta = db_utils::fieldsMemory($rsResultContaPag, 0);
								 	  
								 	 $cExt23 = new stdClass();
								 	 
								 	 $cExt23->si127_tiporegistro    	=  $oExt23->tiporegistro; 
									 $cExt23->si127_codreduzidoop  		=  $oExt22->codreduzidoop; 
									 $cExt23->si127_tipodocumentoop 	=  $oExt23->tipodocumentoop; 
									 $cExt23->si127_nrodocumento    	=  $oExt23->nrodocumento; 
									 $cExt23->si127_codctb          	=  $oConta->conta; 
									 $cExt23->si127_codfontectb     	=  $oConta->fonte; 
									 $cExt23->si127_desctipodocumentoop = $oExt23->tipodocumentoop == "99" ? 'TED' : ' ';
									 $cExt23->si127_dtemissao       	=  $oExt22->dtpagamento;
									 $cExt23->si127_vldocumento     	=  $oExt23->vldocumento;
									 $cExt23->si127_mes 				=  $this->sDataFinal['5'].$this->sDataFinal['6'];
				       			     $cExt23->si127_reg21				=  0;
					                 $cExt23->si127_instit				=  db_getsession("DB_instit");
					                 
					                 $cExt22->ext23[] = $cExt23;
					                  
								 }//FIM FOR 23
				             }
						 	$aExt21[$Hash]->ext22[] = $cExt22; 
						 	
						 }//FIM FOR 22 
					 }
						   
						
					}// FIM FOR 21
				
	    }
	    $cExt20->ext21[] = $aExt21;
	    //echo "<br>--------------------<br>";
	   	//echo "<pre>";print_r($cExt20); echo "<br>--------------------<br>";
	   	
	   	

						/*
						 * desagrupar para salvar no bd
						 */
						
						//$aCaracteres = array("°",chr(13),chr(10),"'",);
					
								           
					    $cExt20->incluir(null);
						if ($cExt20->erro_status == 0) {
							    	  throw new Exception($cExt20->erro_msg);
						}
						
						foreach($cExt20->ext21 as $aExtAgrupado){
							
							foreach($aExtAgrupado as $oExtAgrupado){
									 
									 $cExt21 = new cl_ext212015();
									 
									 $cExt21->si125_tiporegistro 		= $oExtAgrupado->si125_tiporegistro;
									 $cExt21->si125_codreduzidomov 		= $oExtAgrupado->si125_codreduzidomov;
									 $cExt21->si125_codext 				= $oExtAgrupado->si125_codext;
									 $cExt21->si125_codfontrecursos 	= $oExtAgrupado->si125_codfontrecursos;
									 $cExt21->si125_categoria 			= $oExtAgrupado->si125_categoria;
									 $cExt21->si125_dtlancamento 		= $oExtAgrupado->si125_dtlancamento;
									 $cExt21->si125_vllancamento 		= $oExtAgrupado->si125_vllancamento;
						       		 $cExt21->si125_mes 				= $this->sDataFinal['5'].$this->sDataFinal['6'];
						       		 $cExt21->si125_reg20				= $cExt20->si165_sequencial;
							         $cExt21->si125_instit			    = db_getsession("DB_instit");
									 
							         $cExt21->incluir(null);
									 if ($cExt21->erro_status == 0) {
									    	  throw new Exception($cExt21->erro_msg);
									 }
									 foreach ($oExtAgrupado->ext22 as $oext22agrupado){
									 	
									 	//echo "<pre>";print_r($oext22agrupado);exit;
									 	$cExt22 = new cl_ext222015();
									 	
									 	$cExt22->si126_tiporegistro 		=  $oext22agrupado->si126_tiporegistro;
									 	$cExt22->si126_codreduzidoeo 		=  $oext22agrupado->si126_codreduzidoeo;
									 	$cExt22->si126_codreduzidoop 		=  $oext22agrupado->si126_codreduzidoop;
									 	$cExt22->si126_nroop 				=  $oext22agrupado->si126_nroop;
									 	$cExt22->si126_dtpagamento 			=  $oext22agrupado->si126_dtpagamento;
									 	$cExt22->si126_tipodocumentocredor 	=  $oext22agrupado->si126_tipodocumentocredor;
									 	$cExt22->si126_nrodocumento 		=  $oext22agrupado->si126_nrodocumento;
									 	$cExt22->si126_vlop 				=  $oext22agrupado->si126_vlop;
									 	$cExt22->si126_especificacaoop 		=  substr($this->removeCaracteres($oext22agrupado->si126_especificacaoop),0,200);
									 	$cExt22->si126_cpfresppgto 			=  $oext22agrupado->si126_cpfresppgto;
									 	$cExt22->si126_mes 					=  $this->sDataFinal['5'].$this->sDataFinal['6'];
						       			$cExt22->si126_reg21				=  $cExt21->si125_sequencial;
							            $cExt22->si126_instit			    =  db_getsession("DB_instit");
							            
										 $cExt22->incluir(null);
										 if ($cExt22->erro_status == 0) {
										 	
										    	  throw new Exception($cExt22->erro_msg);
										 }
										 foreach ($oext22agrupado->ext23 as $oext23agrupado){
										 	
										 	
										 	
										 	 $cExt23 = new cl_ext232015();
										 	
										 	 $cExt23->si127_tiporegistro    =  $oext23agrupado->si127_tiporegistro; 
											 $cExt23->si127_codreduzidoop   =  $oext23agrupado->si127_codreduzidoop; 
											 $cExt23->si127_tipodocumentoop =  $oext23agrupado->si127_tipodocumentoop; 
											 $cExt23->si127_nrodocumento    =  $oext23agrupado->si127_nrodocumento; 
											 $cExt23->si127_codctb          =  $oext23agrupado->si127_codctb; 
											 $cExt23->si127_codfontectb     =  $oext23agrupado->si127_codfontectb; 
											 $cExt23->si127_dtemissao       =  $oext23agrupado->si127_dtemissao;
											 $cExt23->si127_vldocumento     =  $oext23agrupado->si127_vldocumento;
											 $cExt23->si127_desctipodocumentoop =  $oext23agrupado->si127_desctipodocumentoop;
											 $cExt23->si127_mes 			=  $this->sDataFinal['5'].$this->sDataFinal['6'];
						       			     $cExt23->si127_reg22			=  $cExt22->si126_sequencial;
							                 $cExt23->si127_instit			=  db_getsession("DB_instit");
			    
											 $cExt23->incluir(null);
											 
											 if ($cExt23->erro_status == 0) {
											    	  throw new Exception($cExt23->erro_msg);
											 }
										 	
										 }//fim for 23
									 	
									 }//fim for 22
							 }//fim for 21
						   }
					
	    }
	    
	    db_fim_transacao();	
	    $oGerarEXT = new GerarEXT();
        $oGerarEXT->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];;
		$oGerarEXT->gerarDados(); 
  	
  }
		
}
