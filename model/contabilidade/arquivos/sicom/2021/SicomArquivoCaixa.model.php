<?php


require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_caixa10$PROXIMO_ANO_classe.php");
require_once ("classes/db_caixa11$PROXIMO_ANO_classe.php");
require_once ("classes/db_caixa12$PROXIMO_ANO_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarCAIXA.model.php");

 /**
  * Contas de Caixa Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoCaixa extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 165;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'CAIXA';
  
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
   * selecionar os dados das contas Caixa
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
  	
  	
    $clcaixa12$PROXIMO_ANO = new cl_caixa12$PROXIMO_ANO();
    $clcaixa11$PROXIMO_ANO = new cl_caixa11$PROXIMO_ANO();
    $clcaixa10$PROXIMO_ANO = new cl_caixa10$PROXIMO_ANO();
  	
    
         /*
         * SE JA FOI GERADO ESTA ROTINA UMA VEZ O SISTEMA APAGA OS DADOS DO BANCO E GERA NOVAMENTE
         */
	    db_inicio_transacao();
	    $result = $clcaixa10$PROXIMO_ANO->sql_record($clcaixa10$PROXIMO_ANO->sql_query(NULL,"*",NULL,"si103_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." 
	     and si103_instit = ".db_getsession("DB_instit")));
	    if (pg_num_rows($result) > 0) {
	    	
	    	$clcaixa12$PROXIMO_ANO->excluir(NULL,"si105_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." 
	    	and si105_instit = ".db_getsession("DB_instit"));
	    	$clcaixa11$PROXIMO_ANO->excluir(NULL,"si104_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." 
	    	and si104_instit = ".db_getsession("DB_instit"));
	    	$clcaixa10$PROXIMO_ANO->excluir(NULL,"si103_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." 
	    	and si103_instit = ".db_getsession("DB_instit"));
	   
	      if ($clcaixa10$PROXIMO_ANO->erro_status == 0) {
	    	  throw new Exception($clcaixa10$PROXIMO_ANO->erro_msg);
	      }
	    }
	    db_fim_transacao();
	   
    /*
     * PEGA TODAS AS CONTAS CAIXA DA INSTIUICAO
     */
    $sSqlContasCaixa  = "SELECT c60_codcon,c61_reduz,c60_descr,si09_codorgaotce from ";
    $sSqlContasCaixa .= "conplano join conplanoreduz on c60_codcon = c61_codcon left join  infocomplementaresinstit on c61_instit = si09_instit ";
    $sSqlContasCaixa .= "where c60_codsis = 5 and c60_anousu = ".db_getsession("DB_anousu");
    $sSqlContasCaixa .= " and c61_anousu = ".db_getsession("DB_anousu")." and c61_instit = ".db_getsession("DB_instit");
    
    $rsContasCaixa = db_query($sSqlContasCaixa);
    
    /**
     * percorrer registros de contas retornados do sql acima para pega saldo anterior
     */
    
    for ($iCont = 0;$iCont < pg_num_rows($rsContasCaixa); $iCont++) {
      	    	
    	$oContas = db_utils::fieldsMemory($rsContasCaixa,$iCont);
    	
    	$where  = " c61_instit in (".db_getsession("DB_instit").") and c60_codsis in (5) ";
    	$where .= "and c61_codcon = ".$oContas->c60_codcon;
 
        $rsPlanoContas = db_planocontassaldo(db_getsession("DB_anousu"),$this->sDataInicial,$this->sDataFinal,false,$where);
    	//db_criatabela($rsPlanoContas);
        for ($iContPlano = 0; $iContPlano < pg_num_rows($rsPlanoContas);$iContPlano++) {
    	  
	      	if (db_utils::fieldsMemory($rsPlanoContas, $iContPlano)->c61_reduz != 0) {
	      	  $oPlanoContas = db_utils::fieldsMemory($rsPlanoContas, $iContPlano);
	      	}
      	
        }

             
        db_inicio_transacao();
    	
         
	       if($oPlanoContas->sinal_final == 'C'){
	       	$nSaldoFinal = $oPlanoContas->saldo_final * -1;
	       }else{
	       	$nSaldoFinal = $oPlanoContas->saldo_final;
	       }
	       
           if($oPlanoContas->sinal_anterior == 'C'){
	       	$nSaldoInicial = $oPlanoContas->saldo_anterior * -1;
	       }else{
	       	$nSaldoInicial = $oPlanoContas->saldo_anterior;
	       }
    	
    	  $oDadosCaixa = new cl_caixa10$PROXIMO_ANO();
    	
    	  $oDadosCaixa->si103_tiporegistro    = 10;
    	  $oDadosCaixa->si103_codorgao        = $oContas->si09_codorgaotce;
    	  $oDadosCaixa->si103_vlsaldoinicial  = $nSaldoInicial;
    	  $oDadosCaixa->si103_vlsaldofinal    = $nSaldoFinal;
    	  $oDadosCaixa->si103_mes   	      = $this->sDataFinal['5'].$this->sDataFinal['6'];
    	  $oDadosCaixa->si103_instit          = db_getsession("DB_instit");
    	  
    	  $oDadosCaixa->incluir(null);
    	  
    	    	
    	
    	$sSql = "select  11 as tiporegistro,
				        c69_codlan as codreduzido ,
				        1 as tipomovimentacao,
				        case when substr(o57_fonte,1,2) = '49' and c71_coddoc in (100) then 8
				             when c71_coddoc in (100) then 1
				             when c71_coddoc in (140) then 3
				             when c71_coddoc in (121,131,141,152,153,162,163,6,36,38,101) then 8
				             else 10 
				         end as tipoentrsaida,
				        case when c71_coddoc not in (100,101,140,121,131,152,153,162,163,6,36,38,5,35,37) then substr(c72_complem,1,50) 
				             else ' '
				        end as descrmovimentacao,
				        c69_valor as valorEntrsaida,
				        case when c71_coddoc = 140 then c69_credito else null end as codctbtransf,
				        case when c71_coddoc = 140 then o15_codtri else null end as codfontectbtransf,c71_coddoc,substr(o57_fonte,1,2) as dedu
				        from conlancamval
				        join conlancamdoc on c71_codlan = c69_codlan
				   left join conlancamrec on c74_codlan = c69_codlan
				   left join orcreceita on c74_codrec = o70_codrec and o70_anousu = ".db_getsession("DB_anousu")."     
				   left join conplanoreduz on c61_reduz = c69_credito and c61_anousu = ".db_getsession("DB_anousu")."
				   left join orcfontes on o70_codfon = o57_codfon and o70_anousu = o57_anousu
				   left join orctiporec on o15_codigo = c61_codigo
				   left join conlancamcompl on c72_codlan = c71_codlan
				       where c69_debito = {$oContas->c61_reduz}
				         and c69_data between '".$this->sDataInicial."' AND '".$this->sDataFinal."'
				
				union all 
				
				select  11 as tiporegistro,
				        c69_codlan as codreduzido ,
				        case when c71_coddoc in (101) and substr(o57_fonte,1,2) = '49' then 1 else 2 end as tipomovimentacao,
				        case when c71_coddoc in (100) and substr(o57_fonte,1,2) = '49' then 8
				             when c71_coddoc in (101) and substr(o57_fonte,1,2) = '49' then 1
				             when c71_coddoc in (140) then 3
				             when c71_coddoc in (121,131,141,152,153,162,163,6,36,38,101) then 8
				             when c71_coddoc in (5,35,37) then 6 
				             else 10 
				         end as tipoentrsaida,
				        case when c71_coddoc not in (100,101,140,121,131,152,153,162,163,6,36,38,5,35,37) then substr(c72_complem,1,50) 
				             else ' '
				        end as descrmovimentacao,
				        c69_valor as valorEntrsaida,
				        case when c71_coddoc = 140 then c69_debito else null end as codctbtransf,
				        case when c71_coddoc = 140 then o15_codtri else null end as codfontectbtransf,c71_coddoc,substr(o57_fonte,1,2) as dedu
				        from conlancamval
				        join conlancamdoc on c71_codlan = c69_codlan
				   left join conlancamrec on c74_codlan = c69_codlan
				   left join orcreceita on c74_codrec = o70_codrec and o70_anousu = ".db_getsession("DB_anousu")."     
				   left join conplanoreduz on c61_reduz = c69_debito and c61_anousu = ".db_getsession("DB_anousu")."
				   left join orcfontes on o70_codfon = o57_codfon and o70_anousu = o57_anousu
				   left join orctiporec on o15_codigo = c61_codigo
				   left join conlancamcompl on c72_codlan = c71_codlan
				       where c69_credito = {$oContas->c61_reduz}
				         and c69_data between '".$this->sDataInicial."' AND '".$this->sDataFinal."'";
		     
		    // echo $sSql;exit;
		   		
    		$rsMovi = db_query($sSql);
    		
    		echo pg_last_error();
    		//db_criatabela($rsMovi);exit;
    		$aDadosAgrupados = array();
    		/**
    		 * passar os dados do registro 11 para o array $this->aDados
    		 */
    		for ($iCont2 = 0; $iCont2 < pg_num_rows($rsMovi); $iCont2++) {
    		
    		  $oMovi  = db_utils::fieldsMemory($rsMovi, $iCont2);
    		  
    		    
    		  $sHash  = $oMovi->tiporegistro;
    		  $sHash .= $oMovi->tipomovimentacao;
    		  $sHash .= $oMovi->tipoentrsaida;
    		  $sHash .= $oMovi->codctbtransf;
    		  $sHash .= $oMovi->codfontectbtransf;
    		  
    		  if($oMovi->c71_coddoc == 101 && $oMovi->dedu == '49'){
    		  	$nValor = $oMovi->valorentrsaida * -1;
    		  	
    		  }else{
    		  	$nValor = $oMovi->valorentrsaida;
    		  }
    		      		  
    		  if (!isset($aDadosAgrupados[$sHash])) {
    		  
	    		  $oDadosMovi = new stdClass();
	    		
	    		  $oDadosMovi->si104_tiporegistro            = $oMovi->tiporegistro;
	    		  $oDadosMovi->si104_codreduzido             = $oMovi->codreduzido;
	    		  $oDadosMovi->si104_tipomovimentacao        = $oMovi->tipomovimentacao;
	    		  $oDadosMovi->si104_tipoentrsaida           = $oMovi->tipoentrsaida;
	    		  $oDadosMovi->si104_descrmovimentacao       = $oMovi->descrmovimentacao;
	    		  $oDadosMovi->si104_valorentrsaida          = $nValor;
	    		  $oDadosMovi->si104_codctbtransf            = $oMovi->codctbtransf;
	    		  $oDadosMovi->si104_codfontectbtransf  	 = $oMovi->codfontectbtransf;
	    		  $oDadosMovi->si104_mes  				     = $this->sDataFinal['5'].$this->sDataFinal['6'];
	    		  $oDadosMovi->si104_reg10  			     = $oDadosCaixa->si103_sequencial;
	    		  $oDadosMovi->registro12                    = array();
	    		  
	    		  $aDadosAgrupados[$sHash] =  $oDadosMovi;
    		  
    		  } else {
    		  	  $aDadosAgrupados[$sHash]->si104_valorentrsaida += $nValor;
    		  }
    		  
    		$sSql ="select 12 as tiporegistro,
					       c74_codlan as codreduzdio,
					       case when substr(o57_fonte,1,2) = '49' then 1
					            else 2
					        end as ededucaodereceita,
					       case when substr(o57_fonte,1,2) = '49' then substr(o57_fonte,2,2)
					            else null
					        end as ededucaodereceita,
					       substr(o57_fonte,2,8) as naturezaReceita,
					       c70_valor as vlrreceitacont       
					     from conlancamrec
					     join conlancam on c70_codlan = c74_codlan and c70_anousu = c74_anousu 
					left join orcreceita on c74_codrec = o70_codrec and o70_anousu = $PROXIMO_ANO     
					left join orcfontes on o70_codfon = o57_codfon and o70_anousu = o57_anousu
					left join orctiporec on o15_codigo = o70_codigo
					    where c74_codlan = {$oMovi->codreduzido}";
			    		
			$rsReceita = db_query($sSql);
    		  
	    	if(pg_num_rows($rsReceita) != 0 ){
    		/*
    		 * SQL PARA PEGAR RECEITAS DOS TIPO ENTRA SAIDA 1 RECEITAS ARRECADADA NO MES
    		 */
    		
			    		
			    	  $oRecita  = db_utils::fieldsMemory($rsReceita,0);
		    		  
			    	 
			    	  $oDadosReceita = new stdClass();
			    		
			    	  $oDadosReceita->si105_tiporegistro                      = $oRecita->tiporegistro;
			    	  $oDadosReceita->si105_codreduzido                       = $aDadosAgrupados[$sHash]->si104_codreduzido;
			          $oDadosReceita->si105_ededucaodereceita                 = $oRecita->ededucaodereceita;
			    	  $oDadosReceita->si105_identificadordeducao              = $oRecita->identificadordeducao;
			    	  $oDadosReceita->si105_naturezareceita                   = $oRecita->naturezareceita;
			          $oDadosReceita->si105_vlrreceitacont                    = $oRecita->vlrreceitacont;
			    	  $oDadosReceita->si105_mes                               = $this->sDataFinal['5'].$this->sDataFinal['6'];
			    	  $oDadosReceita->si105_reg10                             = $oDadosCaixa->si103_sequencial;
			    	  
			    		  		    		  
			    	  $aDadosAgrupados[$sHash]->registro12[] = $oDadosReceita;
		    		  

	    		}
	    	    
    		}//fim
    		//echo "<pre>";
    		//	print_r($aDadosAgrupados);
    		foreach ($aDadosAgrupados as $mov) {
     			
    			
    			$clcaixa11$PROXIMO_ANO = new cl_caixa11$PROXIMO_ANO();
    			
    			$clcaixa11$PROXIMO_ANO->si104_tiporegistro            = $mov->si104_tiporegistro;
	    		$clcaixa11$PROXIMO_ANO->si104_codreduzido             = $mov->si104_codreduzido;
	    		$clcaixa11$PROXIMO_ANO->si104_tipomovimentacao        = $mov->si104_tipomovimentacao;
	    		$clcaixa11$PROXIMO_ANO->si104_tipoentrsaida           = $mov->si104_tipoentrsaida;
	    		$clcaixa11$PROXIMO_ANO->si104_descrmovimentacao       = $mov->si104_descrmovimentacao;
	    		$clcaixa11$PROXIMO_ANO->si104_valorentrsaida          = abs($mov->si104_valorentrsaida);
	    		$clcaixa11$PROXIMO_ANO->si104_codctbtransf            = $mov->si104_codctbtransf;
	    		$clcaixa11$PROXIMO_ANO->si104_codfontectbtransf  	  = $mov->si104_codfontectbtransf;
	    		$clcaixa11$PROXIMO_ANO->si104_mes  				      = $mov->si104_mes;
	    		$clcaixa11$PROXIMO_ANO->si104_reg10  			      = $mov->si104_reg10;
	    		$clcaixa11$PROXIMO_ANO->si104_instit                  = db_getsession("DB_instit");
	    		    			
    			$clcaixa11$PROXIMO_ANO->incluir(null);
    			
    		    if ($clcaixa11$PROXIMO_ANO->erro_status == 0) {
					throw new Exception($clcaixa11$PROXIMO_ANO->erro_msg);
				}
    			
    			
                
    		    if($mov->si104_tipoentrsaida == 1){
    		    	
    		    	
    		    	
    				foreach ($mov->registro12 as $reg12){
    					 
    					$clcaixa12$PROXIMO_ANO = new cl_caixa12$PROXIMO_ANO();
    					
    					$clcaixa12$PROXIMO_ANO->si105_tiporegistro                      = $reg12->si105_tiporegistro;
				    	$clcaixa12$PROXIMO_ANO->si105_codreduzido                       = $reg12->si105_codreduzido;
				    	$clcaixa12$PROXIMO_ANO->si105_ededucaodereceita                 = $reg12->si105_ededucaodereceita;
				    	$clcaixa12$PROXIMO_ANO->si105_identificadordeducao              = $reg12->si105_identificadordeducao;
				    	$clcaixa12$PROXIMO_ANO->si105_naturezareceita                   = $reg12->si105_naturezareceita;
				    	$clcaixa12$PROXIMO_ANO->si105_vlrreceitacont                    = $reg12->si105_vlrreceitacont;
				    	$clcaixa12$PROXIMO_ANO->si105_mes                               = $reg12->si105_mes;
				    	$clcaixa12$PROXIMO_ANO->si105_reg10                             = $oDadosCaixa->si103_sequencial;
				    	$clcaixa12$PROXIMO_ANO->si105_instit                            = db_getsession("DB_instit");
				    		
				    	$clcaixa12$PROXIMO_ANO->incluir(null);
	    				
    				}
    			}
    			echo pg_last_error();
    			
            }   
    		db_fim_transacao();	
            $oGerarCAIXA = new GerarCAIXA();
		    $oGerarCAIXA->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];;
		    $oGerarCAIXA->gerarDados();  		
    	
    }
    	    
  }
		
 }
