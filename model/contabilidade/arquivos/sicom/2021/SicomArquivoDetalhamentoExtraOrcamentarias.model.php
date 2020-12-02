<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_ext10$PROXIMO_ANO_classe.php");
require_once ("classes/db_ext20$PROXIMO_ANO_classe.php");
require_once ("classes/db_ext21$PROXIMO_ANO_classe.php");
require_once ("classes/db_ext22$PROXIMO_ANO_classe.php");
require_once ("classes/db_ext23$PROXIMO_ANO_classe.php");

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarEXT.model.php");

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
  	
  	$cExt10 = new cl_ext10$PROXIMO_ANO();
  	$cExt20 = new cl_ext20$PROXIMO_ANO();
  	$cExt21 = new cl_ext21$PROXIMO_ANO();
  	$cExt22 = new cl_ext22$PROXIMO_ANO();
  	$cExt23 = new cl_ext23$PROXIMO_ANO();
  	/*
  	 * CASO JA TENHA SIDO GERADO ALTERIORMENTE PARA O MESMO PERIDO O SISTEMA IRA 
  	 * EXCLUIR OS REGISTROS E GERAR NOVAMENTE
  	 * 
  	 */
  	 db_inicio_transacao();
	    $result = $cExt10->sql_record($cExt10->sql_query(NULL,"*",NULL,"si124_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'])." 
	    								 and si124_instit = ".db_getsession("DB_instit"));
	     
	    if (pg_num_rows($result) > 0) {
	    		   
	      $cExt23->excluir(NULL,"si127_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." 
	    								and si127_instit = ".db_getsession("DB_instit"));
	      if ($cExt23->erro_status == 0) {
	    	  throw new Exception($cExt23->erro_msg);
	      }
	      $cExt22->excluir(NULL,"si126_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'])." 
	    								and si126_instit = ".db_getsession("DB_instit");
	    
	      if ($cExt22->erro_status == 0) {
	    	  throw new Exception($cExt22->erro_msg);
	      }
	      $cExt21->excluir(NULL,"si125_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'])." 
	    								and si125_instit = ".db_getsession("DB_instit");
	      if ($cExt21->erro_status == 0) {
	    	  throw new Exception($cExt21->erro_msg);
	      }
	      $cExt20->excluir(NULL,"si165_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'])." 
	    								and si165_instit = ".db_getsession("DB_instit");
	    
	      if ($cExt20->erro_status == 0) {
	    	  throw new Exception($cExt20->erro_msg);
	      }
	      $cExt10->excluir(NULL,"si124_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'])." 
	    								and si124_instit = ".db_getsession("DB_instit");
		  if ($cExt10->erro_status == 0) {
		    	  throw new Exception($cExt10->erro_msg);
		  }
	   
	    }
	   db_fim_transacao(); 
	  
	 
  	
  	
  	
  	    /*
  	     * SQL RETORNA TODAS AS CONTAS EXTRAS EXISTENTES NO SISTEMA
  	     * 
  	     */
  	    $sSqlExt = "select 10 as tiporegistro,c61_codcon, 
				       c61_reduz as codext, 
				       si09_codorgaotce as codorgao,
				       (select case when o40_codtri::int != 0 and o41_codtri::int != 0 then lpad(o40_codtri,2,0) || lpad(o41_codtri,3,0)
					            when o40_codtri::int != 0 and o41_codtri::int = 0 then lpad(o40_codtri,2,0) || lpad(o41_unidade,3,0)
					            when o40_codtri::int = 0 and o41_codtri::int != 0 then lpad(o40_orgao,2,0) || lpad(o41_codtri,3,0)   
					            else lpad(o40_orgao,2,0) || lpad(o41_unidade,3,0)    
					             end as unidade 
					  from orcunidade 
					  join orcorgao on o41_anousu = o40_anousu and o41_orgao = o40_orgao 
					  where o41_instit = ".db_getsession("DB_instit")." limit 1) as codUnidadeSub,
				       c60_tipolancamento as tipolancamento,
				       case when c60_tipolancamento = 1 and c60_subtipolancamento not in (1,2,3,4) then c61_reduz
				            when c60_tipolancamento = 2 then 1 
				            when c60_tipolancamento = 3 and c60_subtipolancamento not in (1,2,3) then c61_reduz 
				            when c60_tipolancamento = 4 and c60_subtipolancamento not in (1,2,3,4,5,6,7) then c61_reduz
				            else c60_subtipolancamento
				       end as subtipo,
				       case when c60_tipolancamento = 1 and c60_subtipolancamento not in (1,2,3,4) then c61_reduz
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
  				  ";
  	    $rsContasExtra = db_query($sSqlExt);
  	    //db_criatabela($rsContasExtra);
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
	       	    	
	        for ($iContPlano = 0; $iContPlano < pg_num_rows($rsPlanoContasSaldo);$iContPlano++) {
	    	  
		      	if (db_utils::fieldsMemory($rsPlanoContasSaldo, $iContPlano)->c61_reduz != 0) {
		      	  $oPlanoContas = db_utils::fieldsMemory($rsPlanoContasSaldo, $iContPlano);
		      	  $oSaldoInicioFim = new stdClass();
		      	  $oSaldoInicioFim->reduz = $oPlanoContas->c61_reduz;
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
	    
	    $aExt20 = array();
	    for ($iCont20 = 0;$iCont20 < pg_num_rows($rsContasExtra); $iCont20++) {
	        
	    	$oContaExtra = db_utils::fieldsMemory($rsContasExtra,$iCont20);
               
	  	           
	        /*
	         * VERIFICA SE A CONTA EXTRA JA FOI INFORMADA EM  MES ANTERIOR 
	         * SE EXITIR NAO INFORMAR NOVAMENTE
	         */
	       $result = $cExt10->sql_record($cExt10->sql_query(NULL,"*",NULL,"si124_mes < ".$this->sDataFinal['5'].$this->sDataFinal['6']."
	       				 and si124_codext =".$oContaExtra->codext)." and si124_instit = ".db_getsession("DB_instit"));
	       if (pg_num_rows($result) == 0) {
	       	
	       		$cExt10 = new cl_ext10$PROXIMO_ANO();
	       		
	       		$cExt10->si124_tiporegistro     = $oContaExtra->tiporegistro;
	       		$cExt10->si124_codext  			= $oContaExtra->codext;
	       		$cExt10->si124_codorgao 		= $oContaExtra->codorgao;
	       		$cExt10->si124_codunidadesub 	= $oContaExtra->codunidadesub;
	       		$cExt10->si124_tipolancamento 	= $oContaExtra->tipolancamento;
	       		$cExt10->si124_subtipo 			= $oContaExtra->subtipo;
	       		$cExt10->si124_desdobrasubtipo 	= $oContaExtra->desdobrasubtipo;
	       		$cExt10->si124_descextraorc 	= $oContaExtra->descextraorc;
	       		$cExt10->si124_mes				= $this->sDataFinal['5'].$this->sDataFinal['6'];
	       		$cExt10->si124_instit			= db_getsession("DB_instit");
	       		
	       	    $cExt10->incluir(null);
		       
	       	   if ($cExt10->erro_status == 0) {
		    	  throw new Exception($cExt10->erro_msg);
		       }
	       }
	       
	       
	        /*
	         * GRAVAR DADOS DO REGISTRO 20
	         */
	       /* SQL RETORNA A FONTE DE RECURSO DA CONTA EXTRA */
	        $sSqlExtRecurso = "select o15_codtri from conplanoreduz 
	        join orctiporec on c61_codigo = o15_codigo where c61_anousu = ".db_getsession("DB_anousu")." and c61_reduz = ".$oContaExtra->codext;
			$rsExtRecurso = db_query($sSqlExtRecurso);
			
			$oExtRecurso = db_utils::fieldsMemory($rsExtRecurso, 0)->o15_codtri;
					/*
					 * PEGA SALDO ALTERIOR E FINAL 
					 */
			        foreach ($aSaldosIniFim as $nSaldoIniFim){
			        	if($nSaldoIniFim->reduz == $oContaExtra->codext ){
			        		$saldoanterior = $nSaldoIniFim->sdini;
			        		$saldofinal    = $nSaldoIniFim->sdfim;
			        		break;
			        	}
			        }
			
	                $cExt20   = new stdClass();
			        
			        $cExt20->si165_tiporegistro 		= '20';
			        $cExt20->si165_codorgao 			= $oContaExtra->codorgao;
			        $cExt20->si165_codext 				= $oContaExtra->codext;
			        $cExt20->si165_codfontrecursos 		= $oExtRecurso;
			        $cExt20->si165_vlsaldoanteriorfonte = $saldoanterior;
			        $cExt20->si165_vlsaldoatualfonte    = $saldofinal;
			        $cExt20->si165_mes 					= $this->sDataFinal['5'].$this->sDataFinal['6'];
			        $cExt20->si165_instit			    = db_getsession("DB_instit");
			        $cExt20->ext21						= array();
					
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
						         k17_valor as vllancamento, 2 as tipo
						     from slip 
						     join conlancamslip on k17_codigo = c84_slip
						     join conlancamdoc  on c71_codlan = c84_conlancam
						     join conplanoreduz on k17_credito = c61_reduz and c61_anousu = ".db_getsession("DB_anousu")."
						     join orctiporec on o15_codigo  = c61_codigo
						left join infocomplementaresinstit on k17_instit = si09_instit
						 where c71_data between '".$this->sDataInicial."' AND '".$this->sDataFinal."' 
						   and k17_credito = {$oContaExtra->codext} and k17_situacao = 2
						   and c71_coddoc in (120,151,161,130,160)
						  
						union all 
						
						select   '21' as tiporegitro,
						         c84_conlancam as codreduzidomov,
						         k17_codigo as codigo,
						         k17_debito	 as codext, 
						         o15_codtri::int as codfontrecursos,
						         case when c71_coddoc in (130,150,160) then 1 else 2 end as categoria,
						         c71_data as dtlancamento,
						         k17_valor as vllancamento, 2 as tipo
						     from slip 
						     join conlancamslip on k17_codigo = c84_slip
						     join conlancamdoc  on c71_codlan = c84_conlancam
						     join conplanoreduz on k17_debito = c61_reduz and c61_anousu = ".db_getsession("DB_anousu")."
						     join orctiporec on o15_codigo  = c61_codigo
						left join infocomplementaresinstit on k17_instit = si09_instit
						 where c71_data between '".$this->sDataInicial."' AND '".$this->sDataFinal."' 
						   and k17_debito = {$oContaExtra->codext} and k17_situacao = 2
						   and c71_coddoc in (120,151,161,130,160) 
						 
						
						union all
						
						select   '21' as tiporegitro,
						         c70_codlan as codreduzidomov,
						         e50_codord as codigo,
						         k02_reduz as codext, 
						         o15_codtri::int as codfontrecursos,
						         case when c71_coddoc in (130,150,160) then 1 else 2 end as categoria,
						         c86_data as dtlancamento,
						         c70_valor as vllancamento, 1 as tipo
						     from retencaoreceitas 
						     join retencaocorgrupocorrente on e47_retencaoreceita = e23_sequencial 
						     join corgrupocorrente on e47_corgrupocorrente = k105_sequencial 
						     join conlancamcorrente on k105_data = c86_data and k105_autent = c86_autent and k105_id = c86_id
						     join conlancamdoc  on c71_codlan = c86_conlancam
						     join conlancam on  c70_codlan = c71_codlan and c70_anousu = ".db_getsession("DB_anousu")."
						     join retencaotiporec on e23_retencaotiporec = e21_sequencial
						     join tabrec tc  on  tc.k02_codigo = e21_receita
						     join tabplan tp on tp.k02_codigo = tc.k02_codigo and tp.k02_anousu = ".db_getsession("DB_anousu")."
						     join retencaopagordem on e23_retencaopagordem = e20_sequencial
						     join pagordem on e50_codord = e20_pagordem
						     join empempenho on e60_numemp = e50_numemp
						     join pagordemele on e53_codord = e50_codord
						     join conplanoreduz on k02_reduz = c61_reduz and c61_anousu = ".db_getsession("DB_anousu")."
						     join orctiporec on o15_codigo  = c61_codigo
						left join infocomplementaresinstit on e60_instit = si09_instit
						    where c71_coddoc in (120,151,161,130,160) 
						      and c86_data between '".$this->sDataInicial."' AND '".$this->sDataFinal."' and e23_recolhido = 't' and e53_vlrpag != 0
						      and k02_reduz = {$oContaExtra->codext}";
			
					$rsExt21 = db_query($sSql21);
					
					//db_criatabela($rsExt21);
					//echo pg_num_rows($rsExt21);exit;
					$aExt21 = array();
					/*FOR PARA PEGAR O REGISTRO 21 E COLOCAR NO 20*/
					for($linha = 0; $linha < pg_num_rows($rsExt21); $linha++){
						 
						 $oExt21 = db_utils::fieldsMemory($rsExt21,$linha);
		       			 
						 $Hash = $oExt21->codext.$oExt21->codfontrecursos.$oExt21->categoria.$oExt21->dtlancamento;
						 //ECHO $Hash."<BR>";
						 if(!isset($aExt21[$Hash])){
						 
							 $cExt21   = new stdClass();
			       			
			       			 $cExt21->si125_tiporegistro 		= $oExt21->tiporegitro;
							 $cExt21->si125_codreduzidomov 		= $oExt21->codreduzidomov;
							 $cExt21->si125_codext 				= $oExt21->codext;
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
						 if($oExt21->tipo == 2){
						    $sSql22 = "select '22' as tiporegitro,
									         c71_codlan as codreduzidomov,
									         (slip.k17_codigo||slip.k17_debito) ::int as codreduzidoop,
									         (slip.k17_codigo||slip.K17_debito) ::int as nroop,
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
									   and c71_coddoc in (120,151,161,130,160)";
									 
					    }else{
									
						$sSql22 = "select    '22' as tiporegitro,
									         c71_codlan as codreduzidomov,
									         e20_pagordem as codreduzidoop,
									         e20_pagordem as nroop,
									         c86_data as dtpagamento,
									         case when length(cc.z01_cgccpf::char) = 11 then 1 else 2 end as tipodocumentocredor,
									         cc.z01_cgccpf as nrodocumentocredor,
									         c70_valor as vlop,
									         e50_obs as especificacaoop,
									         substr(c.z01_cgccpf,1,11) as cpfresppgto, 1 as tipo
									     from retencaoreceitas 
									     join retencaocorgrupocorrente on e47_retencaoreceita = e23_sequencial 
									     join corgrupocorrente on e47_corgrupocorrente = k105_sequencial 
									     join conlancamcorrente on k105_data = c86_data and k105_autent = c86_autent and k105_id = c86_id
									     join conlancamdoc  on c71_codlan = c86_conlancam
									     join conlancam on  c70_codlan = c71_codlan and c70_anousu = ".db_getsession("DB_anousu")."
									     join retencaotiporec on e23_retencaotiporec = e21_sequencial
									     join tabrec tc  on  tc.k02_codigo = e21_receita
									     join tabplan tp on tp.k02_codigo = tc.k02_codigo and tp.k02_anousu = ".db_getsession("DB_anousu")."
									     join retencaopagordem on e23_retencaopagordem = e20_sequencial
									     join pagordem on e50_codord = e20_pagordem
									     join empempenho on e60_numemp = e50_numemp
									     join conplanoreduz on k02_reduz = c61_reduz and c61_anousu = ".db_getsession("DB_anousu")."
									     join orctiporec on o15_codigo  = c61_codigo
									     join retencaotiporeccgm on e48_retencaotiporec = e21_sequencial
									     join cgm cc on e48_cgm = cc.z01_numcgm
									left join infocomplementaresinstit on e60_instit = si09_instit
									left join cgm c on c.z01_numcgm = si09_gestor
									    where c71_coddoc in (120,151,161,130,160) 
									      and c86_data between '".$this->sDataInicial."' AND '".$this->sDataFinal."'
									      and e20_pagordem = {$oExt21->codigo}";
						 }
						 
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
						 	$cExt22->si126_tipodocumentocredor 	=  $oExt22->tipodocumentocredor;
						 	$cExt22->si126_nrodocumento 		=  $oExt22->nrodocumentocredor;
						 	$cExt22->si126_vlop 				=  $oExt22->vlop;
						 	$cExt22->si126_especificacaoop 		=  $oExt22->especificacaoop;
						 	$cExt22->si126_cpfresppgto 			=  $oExt22->cpfresppgto;
						 	$cExt22->si126_mes 					=  $this->sDataFinal['5'].$this->sDataFinal['6'];
			       			$cExt22->si126_reg21				=  0;
				            $cExt22->si126_instit			    =  db_getsession("DB_instit");
				            $cExt22->ext23						=  array();
				            
				            
				            if($oExt21->tipo == 1){
				                    $sSql23 = "
											SELECT  23 AS tiporegistro, 
												e82_codord AS codreduzidoop, 
												CASE WHEN e96_codigo = 1 THEN 5
											             WHEN e96_codigo = 2 THEN 1 
											             ELSE 99 
											         END AS tipodocumentoop, 
											        CASE WHEN e96_codigo = 2 THEN e86_cheque 
											             ELSE NULL 
											        END AS nrodocumento, 
											        CASE WHEN e96_codigo IN (2, 3, 4) THEN c61_reduz 
											             ELSE NULL 
											         END AS codctb, 
											        CASE WHEN e96_codigo IN (2, 3, 4) THEN o15_codtri 
											             ELSE NULL 
											         END AS codfontectb, 
											         e50_DATA AS dtemissao,
											         k12_valor AS vldocumento
											      FROM empagemov
											INNER JOIN empage ON empage.e80_codage = empagemov.e81_codage
											INNER JOIN empord ON empord.e82_codmov = empagemov.e81_codmov
											INNER JOIN empempenho ON empempenho.e60_numemp = empagemov.e81_numemp
											 LEFT JOIN empagemovforma ON empagemovforma.e97_codmov = empagemov.e81_codmov
											 LEFT JOIN empageforma ON empageforma.e96_codigo = empagemovforma.e97_codforma
											 LEFT JOIN empagepag ON empagepag.e85_codmov = empagemov.e81_codmov
											 LEFT JOIN empagetipo ON empagetipo.e83_codtipo = empagepag.e85_codtipo
											 LEFT JOIN empageconf ON empageconf.e86_codmov = empagemov.e81_codmov
											 LEFT JOIN empageconfgera ON empageconfgera.e90_codmov = empagemov.e81_codmov
											       AND empageconfgera.e90_cancelado = 'f'
											 LEFT JOIN saltes ON saltes.k13_conta = empagetipo.e83_conta
											 LEFT JOIN empagegera ON empagegera.e87_codgera = empageconfgera.e90_codgera
											 LEFT JOIN empagedadosret ON empagedadosret.e75_codgera = empagegera.e87_codgera
											 LEFT JOIN empagedadosretmov ON empagedadosretmov.e76_codret = empagedadosret.e75_codret
											       AND empagedadosretmov.e76_codmov = empagemov.e81_codmov
											 LEFT JOIN empagedadosretmovocorrencia ON empagedadosretmovocorrencia.e02_empagedadosretmov = empagedadosretmov.e76_codmov
											       AND empagedadosretmovocorrencia.e02_empagedadosret = empagedadosretmov.e76_codret
											 LEFT JOIN errobanco ON errobanco.e92_sequencia = empagedadosretmovocorrencia.e02_errobanco
											 LEFT JOIN empageconfche ON empageconfche.e91_codmov = empagemov.e81_codmov
											       AND empageconfche.e91_ativo IS TRUE
											 LEFT JOIN corconf ON corconf.k12_codmov = empageconfche.e91_codcheque
											       AND corconf.k12_ativo IS TRUE
											 LEFT JOIN corempagemov ON corempagemov.k12_codmov = empagemov.e81_codmov
											 LEFT JOIN pagordemele ON e53_codord = empord.e82_codord
											 LEFT JOIN empagenotasordem ON e43_empagemov = e81_codmov
											 LEFT JOIN coremp ON coremp.k12_id = corempagemov.k12_id
											       AND coremp.k12_data = corempagemov.k12_data
											       AND coremp.k12_autent = corempagemov.k12_autent
											INNER JOIN pagordem ON e50_numemp = k12_empen
											       AND k12_codord = e50_codord
											INNER JOIN corrente ON coremp.k12_autent = corrente.k12_autent
											       AND coremp.k12_data = corrente.k12_data
											       AND coremp.k12_id = corrente.k12_id
											       AND corrente.k12_estorn != TRUE
											INNER JOIN conplanoreduz ON c61_reduz = k12_conta
											       AND c61_anousu = ".db_getsession("DB_anousu")."
											INNER JOIN conplano ON c61_codcon = c60_codcon
											       AND c61_anousu = c60_anousu
											 LEFT JOIN conplanoconta ON c63_codcon = c60_codcon
											       AND c60_anousu = c63_anousu
											INNER JOIN corgrupocorrente cg ON cg.k105_autent = corrente.k12_autent
											INNER JOIN orctiporec ON c61_codigo = o15_codigo
											       AND cg.k105_data = corrente.k12_data
											       AND cg.k105_id = corrente.k12_id
											     WHERE k105_corgrupotipo != 2
											       AND e80_instit = ".db_getsession("DB_instit")."
											       AND k12_codord = {$oExt21->codigo}
											       AND e81_cancelado IS NULL";
								}else{       
								    $sSql23 ="SELECT   23 AS tiporegistro,
											         (k17_codigo||K17_credito) :: INT AS codreduzidoop,
											         CASE WHEN e96_codigo = 1 THEN 5
											             WHEN e96_codigo = 2 THEN 1 
											             ELSE 99 
											         END AS tipodocumentoop,
											         CASE WHEN e96_codigo = 2 THEN e91_cheque 
											             ELSE NULL 
											         END AS nrodocumento,
											         CASE WHEN e97_codforma IN (2, 3, 4) THEN K17_debito 
											             ELSE NULL 
											         END AS codctb,
											         CASE WHEN e97_codforma IN (2, 3, 4) THEN o15_codtri 
											             ELSE NULL 
											         END AS codfontectb,
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
											         (k17_codigo||K17_debito) :: INT AS codreduzidoop,
											         CASE WHEN e96_codigo = 1 THEN 5
											             WHEN e96_codigo = 2 THEN 1 
											             ELSE 99 
											         END AS tipodocumentoop,
											         CASE WHEN e96_codigo = 2 THEN e91_cheque 
											             ELSE NULL 
											         END AS nrodocumento,
											         CASE WHEN e97_codforma IN (2, 3, 4) THEN K17_credito 
											             ELSE NULL 
											         END AS codctb,
											         CASE WHEN e97_codforma IN (2, 3, 4) THEN o15_codtri 
											             ELSE NULL 
											         END AS codfontectb,
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
							}
											            
				             $rsExt23 = db_query($sSql23);
				             if( pg_num_rows($rsExt23) == 0){
				             	     $cExt23 = new stdClass();
								 	 
								 	 $cExt23->si127_tiporegistro    =  23; 
									 $cExt23->si127_codreduzidoop   =  $oExt23->codreduzidoop; 
									 $cExt23->si127_tipodocumentoop =  99; 
									 $cExt23->si127_nrodocumento    =  0; 
									 $cExt23->si127_codctb          =  0; 
									 $cExt23->si127_codfontectb     =  0; 
									 $cExt23->si127_dtemissao       =  $oExt22->dtpagamento;
									 $cExt23->si127_vldocumento     =  $oExt22->vlop;
									 $cExt23->si126_mes 			=  $this->sDataFinal['5'].$this->sDataFinal['6'];
				       			     $cExt23->si126_reg21			=  0;
					                 $cExt23->si126_instit			=  db_getsession("DB_instit");
					                 
					                 $cExt22->ext23[] = $cExt23;
				             }else{
				             //db_criatabela($rsExt23);
						     /*FOR PARA PEGAR O REGISTRO 23 E COLOCAR NO 22*/
								 for($linha23 = 0; $linha23 < pg_num_rows($rsExt23); $linha23++){
								 
								 	 $oExt23 = db_utils::fieldsMemory($rsExt23,$linha23);
								 	 
								 	 $cExt23 = new stdClass();
								 	 
								 	 $cExt23->si127_tiporegistro    =  $oExt23->tiporegistro; 
									 $cExt23->si127_codreduzidoop   =  $oExt23->codreduzidoop; 
									 $cExt23->si127_tipodocumentoop =  $oExt23->tipodocumentoop; 
									 $cExt23->si127_nrodocumento    =  $oExt23->nrodocumento; 
									 $cExt23->si127_codctb          =  $oExt23->codctb; 
									 $cExt23->si127_codfontectb     =  $oExt23->codfontectb; 
									 $cExt23->si127_dtemissao       =  $oExt23->dtemissao;
									 $cExt23->si127_vldocumento     =  $oExt23->vldocumento;
									 $cExt23->si126_mes 			=  $this->sDataFinal['5'].$this->sDataFinal['6'];
				       			     $cExt23->si126_reg21			=  0;
					                 $cExt23->si126_instit			=  db_getsession("DB_instit");
					                 
					                 $cExt22->ext23[] = $cExt23;
					                  
								 }//FIM FOR 23
				             }
						 	$aExt21[$Hash]->ext22[] = $cExt22; 
						 	
						 }//FIM FOR 22 
						   
						  
						  
					}// FIM FOR 21
					$cExt20->ext21[] = $aExt21;
					
					
			$aExt20[] = $cExt20;		
	    }
	    		 
					
					//echo "<pre>";print_r($aExt20);exit;
					
					
					/*
					 * desagrupar para salvar no bd
					 */
					
					$aCaracteres = array("°",chr(13),chr(10),"'",);
					
					foreach($aExt20 as $oExt20Agrupado){
						//echo "<pre>";print_r($oExt20Agrupado);exit;
						
						
						$cExt20 = new cl_ext20$PROXIMO_ANO();
						
						$cExt20->si165_tiporegistro 		= $oExt20Agrupado->si165_tiporegistro;
			            $cExt20->si165_codorgao 			= $oExt20Agrupado->si165_codorgao;
			            $cExt20->si165_codext 				= $oExt20Agrupado->si165_codext;
			            $cExt20->si165_codfontrecursos 		= $oExt20Agrupado->si165_codfontrecursos;
			            $cExt20->si165_vlsaldoanteriorfonte = $oExt20Agrupado->si165_vlsaldoanteriorfonte;
			            $cExt20->si165_vlsaldoatualfonte    = $oExt20Agrupado->si165_vlsaldoatualfonte;
			            $cExt20->si165_mes 					= $oExt20Agrupado->si165_mes;
			            $cExt20->si165_instit			    = $oExt20Agrupado->si165_instit;
			           
					    $cExt20->incluir(null);
						if ($cExt20->erro_status == 0) {
							    	  throw new Exception($cExt20->erro_msg);
						}
						
						foreach($oExt20Agrupado->ext21 as $aExtAgrupado){
							
							foreach($aExtAgrupado as $oExtAgrupado){
									 
									 $cExt21 = new cl_ext21$PROXIMO_ANO();
									 
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
									 	$cExt22 = new cl_ext22$PROXIMO_ANO();
									 	
									 	$cExt22->si126_tiporegistro 		=  $oext22agrupado->si126_tiporegistro;
									 	$cExt22->si126_codreduzidoeo 		=  $oext22agrupado->si126_codreduzidoeo;
									 	$cExt22->si126_codreduzidoop 		=  $oext22agrupado->si126_codreduzidoop;
									 	$cExt22->si126_nroop 				=  $oext22agrupado->si126_nroop;
									 	$cExt22->si126_dtpagamento 			=  $oext22agrupado->si126_dtpagamento;
									 	$cExt22->si126_tipodocumentocredor 	=  $oext22agrupado->si126_dtpagamento;
									 	$cExt22->si126_nrodocumento 		=  $oext22agrupado->si126_nrodocumento;
									 	$cExt22->si126_vlop 				=  $oext22agrupado->si126_vlop;
									 	$cExt22->si126_especificacaoop 		=  substr(str_replace($aCaracteres, '', $oext22agrupado->si126_especificacaoop),0,200);
									 	$cExt22->si126_cpfresppgto 			=  $oext22agrupado->si126_cpfresppgto;
									 	$cExt22->si126_mes 					=  $this->sDataFinal['5'].$this->sDataFinal['6'];
						       			$cExt22->si126_reg21				=  $cExt21->si125_sequencial;
							            $cExt22->si126_instit			    =  db_getsession("DB_instit");
							            
										 $cExt22->incluir(null);
										 if ($cExt22->erro_status == 0) {
										 	
										    	  throw new Exception($cExt22->erro_msg);
										 }
										 foreach ($oext22agrupado->ext23 as $oext23agrupado){
										 	
										 	
										 	
										 	 $cExt23 = new cl_ext23$PROXIMO_ANO();
										 	
										 	 $cExt23->si127_tiporegistro    =  $oext23agrupado->si127_tiporegistro; 
											 $cExt23->si127_codreduzidoop   =  $oext23agrupado->si127_codreduzidoop; 
											 $cExt23->si127_tipodocumentoop =  $oext23agrupado->si127_tipodocumentoop; 
											 $cExt23->si127_nrodocumento    =  $oext23agrupado->si127_nrodocumento; 
											 $cExt23->si127_codctb          =  $oext23agrupado->si127_codctb; 
											 $cExt23->si127_codfontectb     =  $oext23agrupado->si127_codfontectb; 
											 $cExt23->si127_dtemissao       =  $oext23agrupado->si127_dtemissao;
											 $cExt23->si127_vldocumento     =  $oext23agrupado->si127_vldocumento;
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
