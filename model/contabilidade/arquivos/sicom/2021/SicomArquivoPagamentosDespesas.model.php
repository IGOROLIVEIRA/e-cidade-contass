<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

require_once ("classes/db_ops102021_classe.php");
require_once ("classes/db_ops112021_classe.php");
require_once ("classes/db_ops122021_classe.php");
require_once ("classes/db_ops132021_classe.php");

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarOPS.model.php");
 /**
  * Pagamento das Despesas Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoPagamentosDespesas extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 172;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'OPS';
  
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
   *metodo para passar os dados das Acoes e Metas pada o $this->aDados 
   */
  public function getCampos(){
    
  }
  
  /**
   * selecionar os dados dos pagamentos de despesa do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
    
  	
    
    $clops10 = new cl_ops102021();
    $clops11 = new cl_ops112021();
    $clops12 = new cl_ops122021();
    $clops13 = new cl_ops132021();
     
    db_inicio_transacao();
			/**
		  	 * excluir informacoes do mes caso ja tenha sido gerado anteriormente
		  	 */
    
  			$result = $clops13->sql_record($clops13->sql_query(NULL,"*",NULL,"si135_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'])
  			 . " and si135_instit = ".db_getsession("DB_instit"));
		    
		    if (pg_num_rows($result) > 0) {
		    	$clops13->excluir(NULL,"si135_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']
		    	. " and si135_instit = ".db_getsession("DB_instit"));
		      if ($clops13->erro_status == 0) {
		    	  throw new Exception($clops13->erro_msg);
		      }
		    }
  			$result = $clops12->sql_record($clops12->sql_query(NULL,"*",NULL,"si134_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']
  			. " and si134_instit = ".db_getsession("DB_instit")));
		    
		    if (pg_num_rows($result) > 0) {
		    	$clops12->excluir(NULL,"si134_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']
		    	. " and si134_instit = ".db_getsession("DB_instit"));
		      if ($clops12->erro_status == 0) {
		    	  throw new Exception($clops12->erro_msg);
		      }
		    }
    
  			$result = $clops11->sql_record($clops11->sql_query(NULL,"*",NULL,"si133_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'] 
  			. " and si133_instit = ".db_getsession("DB_instit")));
		    
		    if (pg_num_rows($result) > 0) {
		      $clops11->excluir(NULL,"si133_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'] 
		      . " and si133_instit = ".db_getsession("DB_instit"));
		      if ($clops11->erro_status == 0) {
		    	  throw new Exception("Erro registro 11:".$clops11->erro_msg);
		      }
		    }
		    
		    $result = $clops10->sql_record($clops10->sql_query(NULL,"*",NULL,"si132_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']
		    . " and si132_instit = ".db_getsession("DB_instit")));
		    
		    if (pg_num_rows($result) > 0) {
		    	$clops10->excluir(NULL,"si132_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']
		    	. " and si132_instit = ".db_getsession("DB_instit"));
		      if ($clops10->erro_status == 0) {
		    	  throw new Exception("Erro registro 10:".$clops10->erro_msg);
		      }
		    }
	
    
    $sSql ="      select  10 as tiporesgistro,
				          si09_codorgaotce as codorgao,
				          lpad(o58_orgao,2,0)||lpad(o58_unidade,3,0) as codunidadesub,
				          c71_codlan||lpad(e50_codord,10,0) as nroop,
				          c80_data as dtpagamento,
				          e53_vlrpag  as valor,
				          e50_obs as especificacaoop,
				          o.z01_cgccpf as cpfresppgto,e50_codord as ordem
				     from pagordem 
				     join pagordemele on e53_codord = e50_codord 
				     join empempenho on e50_numemp = e60_numemp
				     join orcdotacao on o58_anousu = e60_anousu and e60_coddot = o58_coddot
				     join orcunidade on o58_anousu = o41_anousu and o58_orgao = o41_orgao and o58_unidade =o41_unidade
				     join conlancamord on c80_codord = e50_codord
				     join conlancamdoc on c71_codlan = c80_codlan
				     join conlancam on c70_codlan = c71_codlan
				left join infocomplementaresinstit on si09_instit = e60_instit
				left join cgm o on o.z01_numcgm = o41_ordpagamento
	 			    where c80_data between '".$this->sDataInicial."' AND '".$this->sDataFinal."'
				      and c71_coddoc in (5,35,37)
				      and e60_instit = ".db_getsession("DB_instit")."
				      
				  order by e50_codord,c80_codlan";
        //echo $sSql;exit;
        $rsEmpenhosPagosGeral = db_query($sSql);
        
        //db_criatabela($rsEmpenhosPagosGeral);exit;
        $aCaracteres = array("°",chr(13),chr(10),"'",);
        $aInformado = array();
	    for ($iCont = 0; $iCont < pg_num_rows($rsEmpenhosPagosGeral); $iCont++) {
			 
			$oEmpPago = db_utils::fieldsMemory($rsEmpenhosPagosGeral, $iCont);
			/*
			$sSqlPagOrd = "select c80_data from conlancamord join conlancamdoc on c80_codlan = c71_codlan 
			                 where c71_coddoc in (5,35,37) and c80_codord = ".$oEmpPago->nroop." 
			                   and c80_data between '".$this->sDataInicial."' AND '".$this->sDataFinal."' 
			              order by c80_codlan desc limit 1 ";
		    	   
		    $rsPagOrd = db_query($sSqlPagOrd);
            
		    $dtPagamento = db_utils::fieldsMemory($rsPagOrd,0)->c80_data;*/
			$sHash = $oEmpPago->nroop.$oEmpPago->dtpagamento.$oEmpPago->valor;
			
			if(!isset($aInformado[$sHash])){	
				
				$clops10 = new cl_ops102021();
				
				$clops10->si132_tiporegistro 	= $oEmpPago->tiporesgistro;
				$clops10->si132_codorgao 		= $oEmpPago->codorgao;
				$clops10->si132_codunidadesub 	= $oEmpPago->codunidadesub;
				$clops10->si132_nroop 			= $oEmpPago->nroop;
				$clops10->si132_dtpagamento 	= $oEmpPago->dtpagamento;
				$clops10->si132_vlop 			= $oEmpPago->valor;
				$clops10->si132_especificacaoop = $oEmpPago->especificacaoop == '' ? 'SEM HISTORICO'  
													: substr(str_replace($aCaracteres, '', $oEmpPago->especificacaoop),0,200);
				$clops10->si132_cpfresppgto  	= substr($oEmpPago->cpfresppgto,0,11);
				$clops10->si132_mes			 	= $this->sDataFinal['5'].$this->sDataFinal['6'];
				$clops10->si132_instit 				= db_getsession("DB_instit");
				
				$clops10->incluir(null);
				if ($clops10->erro_status == 0) {
					
					
		    	  throw new Exception($clops10->erro_msg);
		        }
		        $aInformado[$sHash]=$clops10;
		        
		        
		        $sSql11 = "select tiporegistro,codreduzidoop,codunidadesub,nroop,tipopagamento,nroempenho,
							       dtempenho,nroliquidacao,dtliquidacao,codfontrecursos,sum(valorfonte) as valorfonte,
							       tipodocumentocredor,nrodocumento,codorgaoempop,codunidadeempop 
							  from (select 11 as tiporegistro,
							          c71_codlan||lpad(e50_codord,10,0) as codreduzidoop,
							          lpad(o58_orgao,2,0)||lpad(o58_unidade,3,0) as codunidadesub,
							          c71_codlan||lpad(e50_codord,10,0) as nroop,
							          case when substr(o56_elemento,2,2) = '46' then 2
								       when c71_coddoc = 35 then 3
								       when c71_coddoc = 37 then 4
								       else 1
							          end as tipopagamento,
							          e60_codemp as nroempenho,
							          e60_emiss as dtempenho,
							          e50_codord as nroliquidacao,
							          e50_data as dtliquidacao,
							          o15_codtri as codfontrecursos,
							          (case when c71_coddoc in (6,36,38) then c70_valor*-1 else c70_valor end)::numeric  as valorfonte,
							          case when length(forn.z01_cgccpf) = 11 then 1 else 2 end as tipodocumentocredor,
							          forn.z01_cgccpf as nrodocumento,
							          ' '::char as codorgaoempop,
							          ' '::char as codunidadeempop,
							          e60_instit as instituicao 
							     from pagordem 
							     join pagordemele on e53_codord = e50_codord 
							     join empempenho on e50_numemp = e60_numemp
							     join orcdotacao on o58_anousu = e60_anousu and e60_coddot = o58_coddot
							     join orcunidade on o58_anousu = o41_anousu and o58_orgao = o41_orgao and o58_unidade =o41_unidade
							     join conlancamord on c80_codord = e50_codord
							     join conlancamdoc on c71_codlan = c80_codlan
							     join conlancam on c70_codlan = c71_codlan
							     join orcelemento on e53_codele = o56_codele and e60_anousu = o56_anousu
							     join orctiporec on o58_codigo  = o15_codigo
							     join cgm forn on e60_numcgm = forn.z01_numcgm
							left join infocomplementaresinstit on si09_instit = e60_instit
							    where c71_data between '".$this->sDataInicial."' AND '".$this->sDataFinal."'
							      and c71_coddoc in (5,6,35,36,37,38) and e50_codord = {$oEmpPago->ordem}) as pagamentos
							group by tiporegistro,codreduzidoop,codunidadesub,nroop,tipopagamento,nroempenho,
							         dtempenho,nroliquidacao,dtliquidacao,codfontrecursos,tipodocumentocredor,
							         nrodocumento,codorgaoempop,codunidadeempop";
		       
		        $rsPagOrd11 = db_query($sSql11);
		        //db_criatabela($rsPagOrd11);exit;
                
		        $reg11 = db_utils::fieldsMemory($rsPagOrd11,0);
		        
		        $clops11 = new cl_ops112021();
		        		        
		        $clops11->si133_tiporegistro 		= $reg11->tiporegistro;
		        $clops11->si133_codreduzidoop 		= $reg11->codreduzidoop;
		        $clops11->si133_codunidadesub 		= $reg11->codunidadesub;
		        $clops11->si133_nroop				= $reg11->nroop;
		        $clops11->si133_dtpagamento 		= $oEmpPago->dtpagamento;
		        $clops11->si133_tipopagamento 		= $reg11->tipopagamento;
		        $clops11->si133_nroempenho 			= $reg11->nroempenho;
		        $clops11->si133_dtempenho 			= $reg11->dtempenho;
		        $clops11->si133_nroliquidacao 		= $reg11->nroliquidacao;
		        $clops11->si133_dtliquidacao 		= $reg11->dtliquidacao;
		        $clops11->si133_codfontrecursos 	= $reg11->codfontrecursos;
		        $clops11->si133_valorfonte 			= $reg11->valorfonte;
		        $clops11->si133_tipodocumentocredor = $reg11->tipodocumentocredor;
		        $clops11->si133_nrodocumento		= $reg11->nrodocumento;
		        $clops11->si133_codorgaoempop	 	= $reg11->codorgaoempop;
		        $clops11->si133_codunidadeempop	 	= $reg11->codunidadeempop;
		        $clops11->si133_mes				 	= $this->sDataFinal['5'].$this->sDataFinal['6'];
		        $clops11->si133_reg10			 	= $clops10->si132_sequencial;
		        $clops11->si133_instit 				= db_getsession("DB_instit");
		        
		        
		        $clops11->incluir(null);
				if ($clops11->erro_status == 0) {
					
		    	  throw new Exception($clops11->erro_msg);
		        }
		        
		        
		        $sSql12 = "select 12 as tiporegistro,
					       e82_codord as codreduzidoop,
					       case when e96_codigo = 1 then 5 
						    when e96_codigo = 2 then 1 
						    else 99
					       end as tipodocumentoop,
					       case when e96_codigo = 2 then e86_cheque
						    else null
					       end as nrodocumento,
					       case when e96_codigo in (2,3,4) then  c61_reduz
						    else null
					       end as codctb, 
					       case when e96_codigo in (2,3,4) then  o15_codtri
						    else null
					       end as codfontectb,
					       e50_data as dtemissao,
					       k12_valor as vldocumento
						from empagemov 
						inner join empage on empage.e80_codage = empagemov.e81_codage 
						inner join empord on empord.e82_codmov = empagemov.e81_codmov 
						inner join empempenho on empempenho.e60_numemp = empagemov.e81_numemp 
						left join empagemovforma on empagemovforma.e97_codmov = empagemov.e81_codmov 
						left join empageforma on empageforma.e96_codigo = empagemovforma.e97_codforma
						left join empagepag on empagepag.e85_codmov = empagemov.e81_codmov 
						left join empagetipo on empagetipo.e83_codtipo = empagepag.e85_codtipo 
						left join empageconf on empageconf.e86_codmov = empagemov.e81_codmov 
						left join empageconfgera on empageconfgera.e90_codmov = empagemov.e81_codmov and empageconfgera.e90_cancelado = 'f'
						left join saltes on saltes.k13_conta = empagetipo.e83_conta 
						left join empagegera on empagegera.e87_codgera = empageconfgera.e90_codgera 
						left join empagedadosret on empagedadosret.e75_codgera = empagegera.e87_codgera 
						left join empagedadosretmov on empagedadosretmov.e76_codret = empagedadosret.e75_codret 
						and empagedadosretmov.e76_codmov = empagemov.e81_codmov 
						left join empagedadosretmovocorrencia on empagedadosretmovocorrencia.e02_empagedadosretmov = empagedadosretmov.e76_codmov 
						and empagedadosretmovocorrencia.e02_empagedadosret = empagedadosretmov.e76_codret 
						left join errobanco on errobanco.e92_sequencia = empagedadosretmovocorrencia.e02_errobanco
						left join empageconfche on empageconfche.e91_codmov = empagemov.e81_codmov and empageconfche.e91_ativo is true
						left join corconf on corconf.k12_codmov = empageconfche.e91_codcheque and corconf.k12_ativo is true 
						left join corempagemov on corempagemov.k12_codmov = empagemov.e81_codmov 
						left join pagordemele on e53_codord = empord.e82_codord 
						left join empagenotasordem on e43_empagemov = e81_codmov
						left join coremp on coremp.k12_id = corempagemov.k12_id
						and coremp.k12_data = corempagemov.k12_data
						and coremp.k12_autent = corempagemov.k12_autent
						     join pagordem on e50_numemp = k12_empen and k12_codord  = e50_codord
						     join corrente on coremp.k12_autent = corrente.k12_autent 
						and coremp.k12_data = corrente.k12_data 
						and coremp.k12_id = corrente.k12_id 
						and corrente.k12_estorn != true
						     join conplanoreduz on c61_reduz = k12_conta and c61_anousu = ".db_getsession("DB_anousu")."
						     join conplano on c61_codcon = c60_codcon 
						      and c61_anousu = c60_anousu
						left join conplanoconta on c63_codcon = c60_codcon 
						      and c60_anousu = c63_anousu
						      join corgrupocorrente cg on cg.k105_autent = corrente.k12_autent 
						      join orctiporec on c61_codigo = o15_codigo
						      and cg.k105_data = corrente.k12_data 
						      and cg.k105_id = corrente.k12_id
						where k105_corgrupotipo != 2 and e80_instit = ".db_getsession("DB_instit")." 
						and k12_codord = {$oEmpPago->ordem} and e81_cancelado is null";
		        
		        
		        $rsPagOrd12 = db_query($sSql12);
                echo pg_last_error();
		        $reg12 = db_utils::fieldsMemory($rsPagOrd12,0);
		        
		        if(pg_num_rows($rsPagOrd12) > 0){
			        $clops12 = new cl_ops122021();
			        
			        $clops12->si134_tiporegistro    = $reg12->tiporegistro;
					$clops12->si134_codreduzidoop   = $reg11->codreduzidoop;
					$clops12->si134_tipodocumentoop = $reg12->tipodocumentoop;
					$clops12->si134_nrodocumento    = $reg12->nrodocumento;
					$clops12->si134_codctb 			= $reg12->codctb; 
					$clops12->si134_codfontectb 	= $reg12->codfontectb;
					$clops12->si134_dtemissao 		= $reg12->dtemissao;
					$clops12->si134_vldocumento 	= $reg12->vldocumento;
					$clops12->si134_mes 			= $this->sDataFinal['5'].$this->sDataFinal['6'];
			        $clops12->si134_reg10			= $clops10->si132_sequencial;
			        $clops12->si134_instit 			= db_getsession("DB_instit");
		        }else {
		        	$clops12 = new cl_ops122021();
			        
			        $clops12->si134_tiporegistro    = 12;
					$clops12->si134_codreduzidoop   = $reg11->codreduzidoop;
					$clops12->si134_tipodocumentoop = 99;
					$clops12->si134_nrodocumento    = 0;
					$clops12->si134_codctb 			= 0; 
					$clops12->si134_codfontectb 	= 0;
					$clops12->si134_dtemissao 		= $oEmpPago->dtpagamento;
					$clops12->si134_vldocumento 	= $oEmpPago->valor;
					$clops12->si134_mes 			= $this->sDataFinal['5'].$this->sDataFinal['6'];
			        $clops12->si134_reg10			= $clops10->si132_sequencial;
			        $clops12->si134_instit 				= db_getsession("DB_instit");
		        	
		        }  
			        
				    $clops12->incluir(null);
					if ($clops12->erro_status == 0) {
					   echo "<pre>";
					   print_r($clops12);
			           throw new Exception($clops12->erro_msg);
			        }
			        
			        
			   $sSql13 = "select 13 as tiporegistro,
			                     e20_pagordem as codreduzidoop, 
			                     case when e21_retencaotipocalc = 5 then 4
									  when e21_retencaotipocalc in (3,4,7) then 1
									  when e21_retencaotipocalc in (1,2) then 3
									  else k02_reduz
			                     end as tiporetencao,
			                     case when e21_retencaotipocalc not in (1,2,3,4,5,7) then e21_descricao else null end as descricaoretencao,
			                     e23_valorretencao as vlrentencao
					from retencaopagordem
					join retencaoreceitas on  e23_retencaopagordem = e20_sequencial 
					join retencaotiporec on e23_retencaotiporec = e21_sequencial
					join tabrec tr on tr.k02_codigo = e21_receita
					join tabplan tp on tp.k02_codigo = tr.k02_codigo and k02_anousu = ".db_getsession("DB_anousu")."
				       where e23_ativo = true and e20_pagordem = {$oEmpPago->ordem}";

			    $rsPagOrd13 = db_query($sSql13);
                
		       
		        
		        if(pg_num_rows($rsPagOrd13) > 0){
		        	
		        	for ($iCont13 = 0; $iCont13 < pg_num_rows($rsPagOrd13); $iCont13++) {
			 			
		        		$reg13 = db_utils::fieldsMemory($rsPagOrd13,$iCont13);
					
			        	$clops13 = new cl_ops132021();
			        	
			        	$clops13->si135_tiporegistro 		= $reg13->tiporegistro;
			        	$clops13->si135_codreduzidoop 		= $reg11->codreduzidoop;
			        	$clops13->si135_tiporetencao 		= $reg13->tiporetencao;
			        	$clops13->si135_descricaoretencao 	= $reg13->descricaoretencao;
			        	$clops13->si135_vlretencao 			= $reg13->vlrentencao;
			        	$clops13->si135_mes 				= $this->sDataFinal['5'].$this->sDataFinal['6'];
				        $clops13->si135_reg10				= $clops10->si132_sequencial;
			        	$clops13->si135_instit 				= db_getsession("DB_instit");
			        	
			            $clops13->incluir(null);
						if ($clops13->erro_status == 0) {
						   echo "<pre>";
						   print_r($clops13);
				           throw new Exception($clops13->erro_msg);
				        }
		        	}
     
		        }
		        
								
			}
	    	
	    }
	 db_fim_transacao();
	 $oGerarOPS = new GerarOPS();
	 $oGerarOPS->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];;
	 $oGerarOPS->gerarDados();
   }
		
}
