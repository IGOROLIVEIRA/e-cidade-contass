<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_aex10$PROXIMO_ANO_classe.php");
//require_once ("classes/db_aex11$PROXIMO_ANO_classe.php");

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/$PROXIMO_ANO/GerarAEX.model.php");

 /**
  * Anulacao Extra Orcamentaria Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoAnulacaoExtraOrcamentariaPorFonte extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 196;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'AEX';
  
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
   * selecionar os dados
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
  	
    $cAex10 = new cl_aex102020();
  	
    //$cAex11 = new cl_aex11$PROXIMO_ANO();
  	
  	/*
  	 * CASO JA TENHA SIDO GERADO ALTERIORMENTE PARA O MESMO PERIDO O SISTEMA IRA 
  	 * EXCLUIR OS REGISTROS E GERAR NOVAMENTE
  	 * 
  	 */
  	 db_inicio_transacao();
	    $result = $cAex10->sql_record($cAex10->sql_query(NULL,"*",NULL,"si129_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']));
	     
	    if (pg_num_rows($result) > 0) {
	    		   
	      /*$cAex11->excluir(NULL,"si130_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
	      if ($cAex11->erro_status == 0) {
	    	  throw new Exception($cAex11->erro_msg);
	      }*/
	      $cAex10->excluir(NULL,"si129_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
	    
	      if ($cAex10->erro_status == 0) {
	    	  throw new Exception($cExt22->erro_msg);
	      }
	      	   
	    }
  	
	    $sSqlExt = "select 10 as tiporegistro,c61_codcon, 
				       c61_reduz as codext, 
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
  	              and c60_tipolancamento != 0  ";
	    
  	
  	    $rsContasExtra = db_query($sSqlExt);
  	    //db_criatabela($rsContasExtra);exit;	
	    /**
	     * percorrer registros de contas retornados do sql acima para pega saldo anterior
	     */
  	    /*
	    $aAex10Agrupa = array();
	    for ($iCont = 0;$iCont < pg_num_rows($rsContasExtra); $iCont++) {
	        
	    	$oContaExtra = db_utils::fieldsMemory($rsContasExtra,$iCont);
	    	 
	    	$sSqlMov10 = "select   '10' as tiporegitro,2 as tipo,k17_codigo as id,
						         k17_codigo as codreduzidoaex,
						         si09_codorgaotce as codorgao,
						         k17_credito as codext, 
						         o15_codtri::int as fonte,
						         case when c71_coddoc in (131,152,162) then 1 else 2 end as categoria,
						         k17_data as dtlancamento,
						         k17_dtanu as dtanulacaoextra,
						         k17_motivoestorno as justificativaanulacao,
						         k17_valor as valor
						     from slip 
						     join conlancamslip on k17_codigo = c84_slip
						     join conlancamdoc  on c71_codlan = c84_conlancam
						     join conplanoreduz on k17_credito = c61_reduz and c61_anousu = ".db_getsession("DB_anousu")."
						     join orctiporec on o15_codigo  = c61_codigo
						left join infocomplementaresinstit on k17_instit = si09_instit
						 where k17_dtestorno between '".$this->sDataInicial."' AND '".$this->sDataFinal."' 
						   and k17_credito = {$oContaExtra->codext} 
						   and c71_coddoc in (163,162,152,153,121,131)
						   and k17_instit = ".db_getsession("DB_instit")."
						union all
						select   '10' as tiporegitro,2 as tipo,k17_codigo as id,
						         k17_codigo as codreduzidoaex,
						         si09_codorgaotce as codorgao,
						         k17_debito as codext, 
						         o15_codtri::int as fonte,
						         case when c71_coddoc in (131,152,162) then 1 else 2 end as categoria,
						         k17_data as dtlancamento,
						         k17_dtanu as dtanulacaoextra,
						         k17_motivoestorno as justificativaanulacao,
						         k17_valor as valor
						     from slip 
						     join conlancamslip on k17_codigo = c84_slip
						     join conlancamdoc  on c71_codlan = c84_conlancam
						     join conplanoreduz on k17_debito = c61_reduz and c61_anousu = ".db_getsession("DB_anousu")."
						     join orctiporec on o15_codigo  = c61_codigo
						left join infocomplementaresinstit on k17_instit = si09_instit
						 where k17_dtestorno between '".$this->sDataInicial."' AND '".$this->sDataFinal."'
						   and k17_debito = {$oContaExtra->codext} 
						   and c71_coddoc in (163,162,152,153,121,131)
						   and k17_instit = ".db_getsession("DB_instit")."
						union all
						select   '10' as tiporegitro,1 as tipo,e50_codord as id,
						         e20_pagordem as codreduzidoaex,
						         si09_codorgaotce as codorgao,
						         c69_debito as codext, 
						         o15_codtri::int as fonte,
						         case when c71_coddoc in (131,152,162) then 1 else 2 end as categoria,
						         e50_data as dtlancamento,
						         c86_data as dtanulacaoextra,
						         'Estorno de Renteção' as justificativaanulacao,
						         c69_valor as valor
						     from retencaoreceitas 
						     join retencaocorgrupocorrente on e47_retencaoreceita = e23_sequencial 
						     join corgrupocorrente on e47_corgrupocorrente = k105_sequencial 
						     join conlancamcorrente on k105_data = c86_data and k105_autent = c86_autent and k105_id = c86_id
						     join conlancamdoc  on c71_codlan = c86_conlancam
						     join conlancamval on c69_codlan = c71_codlan
						     join retencaopagordem on e23_retencaopagordem = e20_sequencial
						     join pagordem on e50_codord = e20_pagordem
						     join empempenho on e60_numemp = e50_numemp
						     join conplanoreduz on c69_debito = c61_reduz and c61_anousu = ".db_getsession("DB_anousu")."
						     join orctiporec on o15_codigo  = c61_codigo
						left join infocomplementaresinstit on e60_instit = si09_instit
						    where c71_coddoc in (131,152,153,162,163) 
						      and c86_data between '".$this->sDataInicial."' AND '".$this->sDataFinal."'
						      and c69_debito = {$oContaExtra->codext}
						      and e60_instit = ".db_getsession("DB_instit")."
						union all
						select   '10' as tiporegitro, 1 as tipo,e50_codord as id,
						         e20_pagordem as codreduzidoaex,
						         si09_codorgaotce as codorgao,
						         c69_credito as codext, 
						         o15_codtri::int as fonte,
						         case when c71_coddoc in (131,152,162) then 1 else 2 end as categoria,
						         e50_data as dtlancamento,
						         c86_data as dtanulacaoextra,
						         'Estorno de Renteção' as justificativaanulacao,
						         c69_valor as valor
						     from retencaoreceitas 
						     join retencaocorgrupocorrente on e47_retencaoreceita = e23_sequencial 
						     join corgrupocorrente on e47_corgrupocorrente = k105_sequencial 
						     join conlancamcorrente on k105_data = c86_data and k105_autent = c86_autent and k105_id = c86_id
						     join conlancamdoc  on c71_codlan = c86_conlancam
						     join conlancamval on c69_codlan = c71_codlan
						     join retencaopagordem on e23_retencaopagordem = e20_sequencial
						     join pagordem on e50_codord = e20_pagordem
						     join empempenho on e60_numemp = e50_numemp
						     join conplanoreduz on c69_credito = c61_reduz and c61_anousu = ".db_getsession("DB_anousu")."
						     join orctiporec on o15_codigo  = c61_codigo
						left join infocomplementaresinstit on e60_instit = si09_instit
						    where c71_coddoc in (131,152,153,162,163) 
						      and c86_data between '".$this->sDataInicial."' AND '".$this->sDataFinal."'
						      and c69_credito = {$oContaExtra->codext}
						      and e60_instit = ".db_getsession("DB_instit");
	    	
	    	$rsAex10 = db_query($sSqlMov10);
	    	
	    	
	    	for ($iContAex10 = 0; $iContAex10 < pg_num_rows($rsAex10); $iContAex10++){
	    		
	    		$oAex10 = db_utils::fieldsMemory($rsAex10,$iContAex10);
	    		
	    		$sHash  = $oAex10->tiporegitro.$oAex10->codorgao.$oAex10->codext.$oAex10->fonte;
	    		$sHash .= $oAex10->categoria.$oAex10->dtlancamento.$oAex10->dtanulacaoextra;
	    		
	    		if(!isset($aAex10Agrupa[$sHash])){
	    		    
	    			$cAex10 = new stdClass();
	    		
		    		$cAex10->si129_tiporegistro 		 = $oAex10->tiporegitro;
		    		$cAex10->si129_codreduzidoaex 		 = $oAex10->codreduzidoaex;
		    		$cAex10->si129_codorgao 			 = $oAex10->codorgao;
		    		$cAex10->si129_codext 				 = $oAex10->codext;
		    		$cAex10->si129_codfontrecursos 		 = $oAex10->fonte;
		    		$cAex10->si129_categoria 			 = $oAex10->categoria;
		    		$cAex10->si129_dtlancamento 		 = $oAex10->dtlancamento;
		    		$cAex10->si129_dtanulacaoextra 		 = $oAex10->dtanulacaoextra;
		    		$cAex10->si129_justificativaanulacao = $oAex10->justificativaanulacao;
		    		$cAex10->si129_vlanulacao 			 = $oAex10->valor;
		    		$cAex10->si129_mes 					 = $this->sDataFinal['5'].$this->sDataFinal['6'];
		    		$cAex10->aex11						 = array();
		    		
		    		$aAex10Agrupa[$sHash] = $cAex10;
		    		
		    		if($oAex10->tipo == 1){
		    		       $sSqlPagExtra = "select c80_data from conlancamord 
		    		                                  join conlancamdoc on c80_codlan = c71_codlan 
		    		                                  where c71_coddoc = 5 and c80_codord = ".$oAex10->id." limit 1";
						   
		    		       $rsPagExtra = db_query($sSqlPagExtra);
		    		       
		    		       $dtPagamento = db_utils::fieldsMemory($rsPagExtra,0)->c80_data;
		    		}else{
		    			   $sSqlPagExtra = "select c71_data from conlancamslip 
		    			   									join conlancamdoc on c71_codlan = c84_conlancam 
		    			   									where c71_coddoc = 160 and c84_slip =".$oAex10->id;
		    			   
		    		       $rsPagExtra = db_query($sSqlPagExtra);
		    		       $dtPagamento = db_utils::fieldsMemory($rsPagExtra,0)->c71_data;
		    		}
		    		
		    		
		    		
		    		$oAex11 = new stdClass();
	    		    
		    		$oAex11->si130_tiporegistro     = '11';
		    		$oAex11->si130_codreduzidoaex   = $oAex10->codreduzidoaex;
		    		$oAex11->si130_nroop  		    = $oAex10->codext;
		    		$oAex11->si130_dtpagamento 	    = $dtPagamento;
		    		$oAex11->si130_nroanulacaoop    = $oAex10->codext;
		    		$oAex11->si130_dtanulacaoop 	= $oAex10->dtanulacaoextra;
		    		$oAex11->si130_vlanulacaoop 	= $oAex10->valor;
		    		$oAex11->si130_mes 			    = $this->sDataFinal['5'].$this->sDataFinal['6'];
		    		$oAex11->si130_reg10		    = 0;
		    		
		    		
		    		$aAex10Agrupa[$sHash]->aex11[$sHash] 		  = $oAex11;
		    		
	    		}else{
	    			
	    			$aAex10Agrupa[$sHash]->si129_vlanulacao                  +=$oAex10->valor;
	    			$aAex10Agrupa[$sHash]->aex11[$sHash]->si130_vlanulacaoop +=$oAex10->valor;
	    			
	    		}
	    		
    		
	    	}
	    	
    	
	    }
	    
	     
	     foreach ($aAex10Agrupa as $oDados10) {
	    			
			    	    $claex   = new cl_aex10$PROXIMO_ANO();
			    	  
					    $claex->si129_tiporegistro 		     = $oDados10->si129_tiporegistro;
			    		$claex->si129_codreduzidoaex 		 = $oDados10->si129_codreduzidoaex;
			    		$claex->si129_codorgao 			     = $oDados10->si129_codorgao;
			    		$claex->si129_codext 				 = $oDados10->si129_codext;
			    		$claex->si129_codfontrecursos 		 = $oDados10->si129_codfontrecursos;
			    		$claex->si129_categoria 			 = $oDados10->si129_categoria;
			    		$claex->si129_dtlancamento 		     = $oDados10->si129_dtlancamento;
			    		$claex->si129_dtanulacaoextra 		 = $oDados10->si129_dtanulacaoextra;
			    		$claex->si129_justificativaanulacao  = $oDados10->si129_justificativaanulacao;
			    		$claex->si129_vlanulacao 			 = $oDados10->si129_vlanulacao;
			    		$claex->si129_mes 					 = $this->sDataFinal['5'].$this->sDataFinal['6'];
					    
					    $claex->incluir(null);
			    	if ($claex->erro_status == 0) {
			    	  throw new Exception($claex->erro_msg);
			        }
	      foreach ($oDados10->aex11 as $oDados11) {
	      	    
	            $aex11 = new cl_aex11$PROXIMO_ANO();
	            
	    		    $aex11->si130_tiporegistro      = $oDados11->si130_tiporegistro;
		    		$aex11->si130_codreduzidoaex    = $oDados11->si130_codreduzidoaex;
		    		$aex11->si130_nroop  		    = $oDados11->si130_nroop;
		    		$aex11->si130_dtpagamento 	    = $oDados11->si130_dtpagamento;
		    		$aex11->si130_nroanulacaoop     = $oDados11->si130_nroanulacaoop;
		    		$aex11->si130_dtanulacaoop 	    = $oDados11->si130_dtanulacaoop;
		    		$aex11->si130_vlanulacaoop      = $oDados11->si130_vlanulacaoop;
		    		$aex11->si130_mes 			    = $oDados11->si130_mes;
		    		$aex11->si130_reg10		        = $claex->si129_sequencial;
	    		
	            $aex11->incluir(null);
	    	  if ($aex11->erro_status == 0) {
	    	    throw new Exception($aex11->erro_msg);
	          }
	      	
	      }
	      
			  
	    }
	    
	    
	    
	    
	    $cAex10->incluir(null);
		    	    if ($cAex10->erro_status == 0) {
			    	  throw new Exception($cAex10->erro_msg);
			        }*/
	    db_fim_transacao();
	    $oGerarAEX = new GerarAEX();
        $oGerarAEX->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];;
		$oGerarAEX->gerarDados(); 
	
  }
		
}
