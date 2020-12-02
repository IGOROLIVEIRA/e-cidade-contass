<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_ctb10$PROXIMO_ANO_classe.php");
require_once ("classes/db_ctb20$PROXIMO_ANO_classe.php");
require_once ("classes/db_ctb21$PROXIMO_ANO_classe.php");
require_once ("classes/db_ctb22$PROXIMO_ANO_classe.php");
require_once ("classes/db_ctb30$PROXIMO_ANO_classe.php");
require_once ("classes/db_ctb31$PROXIMO_ANO_classe.php");
require_once ("classes/db_ctb40$PROXIMO_ANO_classe.php");
require_once ("classes/db_ctb41$PROXIMO_ANO_classe.php");
require_once ("classes/db_ctb50$PROXIMO_ANO_classe.php");
require_once ("classes/db_ctb60$PROXIMO_ANO_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarCTB.model.php");


 /**
  * Contas bancarias Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoContasBancarias extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 164;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'CTB';
  
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
   * selecionar os dados das contas bancarias
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
  			
	
	      
  	
  	            
  	$cCtb10 = new cl_ctb10$PROXIMO_ANO();
	$cCtb20 = new cl_ctb20$PROXIMO_ANO();
	$cCtb21 = new cl_ctb21$PROXIMO_ANO();
	$cCtb22 = new cl_ctb22$PROXIMO_ANO();
	$cCtb30 = new cl_ctb30$PROXIMO_ANO();
	$cCtb31 = new cl_ctb31$PROXIMO_ANO();
	$cCtb40 = new cl_ctb40$PROXIMO_ANO();
	$cCtb41 = new cl_ctb41$PROXIMO_ANO();
	$cCtb50 = new cl_ctb50$PROXIMO_ANO();
	
      
    /**
  	 * selecionar arquivo xml com dados das receitas para substituicao
  	 *
    $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomnaturezareceita.xml";
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuração de natureza das receitas do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oCodReceitasSub = $oDOMDocument->getElementsByTagName('receita');
    
    */
   
	 /**
	  * excluir informacoes do mes caso ja tenha sido gerado anteriormente
	  */
		    
	 $result = $cCtb20->sql_record($cCtb20->sql_query(NULL,"*",NULL,"si96_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'] 
	 ." and si96_instit = ". db_getsession("DB_instit")));
		    
	 if (pg_num_rows($result) > 0) {

	 	 $cCtb22->excluir(NULL,"si98_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si98_instit = ". db_getsession("DB_instit"));
	 	 $cCtb21->excluir(NULL,"si97_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si97_instit = ". db_getsession("DB_instit"));
	 	 $cCtb20->excluir(NULL,"si96_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si96_instit = ". db_getsession("DB_instit"));
		 $cCtb10->excluir(NULL,"si95_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si95_instit = ". db_getsession("DB_instit"));
		 if ($cCtb10->erro_status == 0) {
		 	
		    	  throw new Exception($cCtb10->erro_msg);
		 }
	 }
    
    $sSqlGeral  = "select  10 as tiporegistro,
					     k13_reduz as codctb,
					     si09_codorgaotce,
				             c63_banco, 
				             c63_agencia, 
				             c63_conta, 
				             c63_dvconta, 
				             c63_dvagencia,
				             case when db83_tipoconta in (2,3) then 2 else 1 end as tipoconta,
				             ' ' as tipoaplicacao,
				             ' ' as nroseqaplicacao,
				             db83_descricao as desccontabancaria,
				             db83_convenio as contaconvenio,
				             case when db83_convenio = 1 then db83_numconvenio else null end as nroconvenio,
				             case when db83_convenio = 1 then db83_dataconvenio else null end as dataassinaturaconvenio 
				       from saltes 
				       join conplanoreduz on k13_reduz = c61_reduz and c61_anousu = ".db_getsession("DB_anousu")."
				       join conplanoconta on c63_codcon = c61_codcon and c63_anousu = c61_anousu
				  left join conplanocontabancaria on c56_codcon = c61_codcon and c56_anousu = c61_anousu
				  left join contabancaria on c56_contabancaria = db83_sequencial
				  left join infocomplementaresinstit on si09_instit = c61_instit
				    where k13_limite is null 
					   or k13_limite between '".$this->sDataInicial."' and '".$this->sDataFinal."'
					  and c61_instit = ".db_getsession("DB_instit");
    
    $rsContas = db_query($sSqlGeral);
    
    $aBancosAgrupodos = array();
    
    for ($iCont = 0;$iCont < pg_num_rows($rsContas); $iCont++) {

      $oRegistro10 = db_utils::fieldsMemory($rsContas,$iCont);
      $aDadosAgrupadosRegistro10[$oRegistro10->c61_reduz] = $oRegistro10;
      
	  $aHash  = $oRegistro10->si09_codorgaotce;
	  $aHash .= $oRegistro10->c63_banco;
	  $aHash .= $oRegistro10->c63_agencia; 
	  $aHash .= $oRegistro10->c63_conta;
	  $aHash .= $oRegistro10->c63_dvconta;
	  
      
      if($oRegistro10->si09_tipoinstit != 5){
      	
      	if(!isset($aBancosAgrupodos[$aHash])){
      		
      		$cCtb10    =  new cl_ctb10$PROXIMO_ANO();
      		
      		
      		$cCtb10->si95_tiporegistro 					  =	$oRegistro10->tiporegistro;
			$cCtb10->si95_codctb 						  =	$oRegistro10->codctb;
			$cCtb10->si95_codorgao 						  =	$oRegistro10->si09_codorgaotce;
			$cCtb10->si95_banco 						  =	$oRegistro10->c63_banco; 
			$cCtb10->si95_agencia 						  =	$oRegistro10->c63_agencia;
			$cCtb10->si95_digitoverificadoragencia 		  =	$oRegistro10->c63_dvagencia; 
			$cCtb10->si95_contabancaria 				  =	$oRegistro10->c63_conta; 
			$cCtb10->si95_digitoverificadorcontabancaria  =	$oRegistro10->c63_dvconta;
			$cCtb10->si95_tipoconta   					  =	$oRegistro10->tipoconta;
			$cCtb10->si95_tipoaplicacao   				  =	$oRegistro10->tipoaplicacao;
			$cCtb10->si95_nroseqaplicacao   			  =	$oRegistro10->nroseqaplicacao;
			$cCtb10->si95_desccontabancaria   			  =	$oRegistro10->desccontabancaria;
			$cCtb10->si95_contaconvenio   				  =	$oRegistro10->contaconvenio;
			$cCtb10->si95_nroconvenio   				  =	$oRegistro10->nroconvenio;
			$cCtb10->si95_dataassinaturaconvenio   		  =	$oRegistro10->dataassinaturaconvenio;
			$cCtb10->si95_mes							  = $this->sDataFinal['5'].$this->sDataFinal['6'];
            $cCtb10->si95_instit						  = db_getsession("DB_instit");
            $cCtb10->contas								  = array();

            
      	    $cCtb10->incluir(null);
			if ($cCtb10->erro_status == 0) {
				 throw new Exception($cCtb10->erro_msg);
			}
            $cCtb10->contas[]= $cCtb10->si95_codctb;
            $aBancosAgrupodos[$aHash] = $cCtb10;
            
      	}else{
      		$aBancosAgrupodos[$aHash]->contas[] = $oRegistro10->codctb;
      	}
      	
        
      }else{
      		/*
      		 * FALTA AGRUPA AS CONTAS QUANDO A INSTIUICAO FOR IGUAL A 5 RPPS
      		 */
      }
 
    } 
    
    foreach ($aBancosAgrupodos as $oContaAgrupada) {
    	
    	$oCtb20 = new stdClass();
    	foreach ($oContaAgrupada->contas as $nConta){
    		
    		/* DADOS REGISTRO 20*/
    		//pega saldo alterior e final da conta
    		$sSql = "select c61_codcon,o15_codtri 
    		           from conplanoreduz 
    		           join orctiporec on c61_codigo = o15_codigo 
    		           where c61_reduz = {$nConta} and c61_anousu = ".db_getsession("DB_anousu");
    		$rsContaCon = db_query($sSql);
    		
    		$nCodCon 	 = db_utils::fieldsMemory($rsContaCon, 0)->c61_codcon;
    		$nCodRecurso = db_utils::fieldsMemory($rsContaCon, 0)->o15_codtri;
    		db_inicio_transacao();	    
            $rs_anterior = db_planocontassaldo_matriz(db_getsession("DB_anousu"), $this->sDataInicial,$this->sDataFinal, true, "c61_reduz = {$nConta} and c61_instit= ".db_getsession("DB_instit"));
		   db_fim_transacao();
		   //echo pg_last_error();
	        for ($iContPlano = 0; $iContPlano < pg_num_rows($rs_anterior);$iContPlano++) {
	    	  
		      	if (db_utils::fieldsMemory($rs_anterior, $iContPlano)->c61_reduz != 0) {
		      	  $oPlanoContas = db_utils::fieldsMemory($rs_anterior, $iContPlano);
		      	  break;
		      	}
	        }
	        
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
	       
	       if(!empty($oCtb20)){
	       			       		
			    $oCtb20->si96_tiporegistro 			= '20';
			    $oCtb20->si96_codorgao 				= $oContaAgrupada->si95_codorgao;
			    $oCtb20->si96_codctb 				= $oContaAgrupada->si95_codctb;
			    $oCtb20->si96_codfontrecursos 		= $nCodRecurso;
			    $oCtb20->si96_vlsaldoinicialfonte 	= $nSaldoInicial;
			    $oCtb20->si96_vlsaldofinalfonte    	= $nSaldoFinal;
			    $oCtb20->si96_mes 					= $this->sDataFinal['5'].$this->sDataFinal['6'];
			    $oCtb20->si96_instit			    = db_getsession("DB_instit");
			    $oCtb20->ext21						= array();
			    
	       }else{
	       		$oCtb20->si96_vlsaldoinicialfonte 	+= $nSaldoInicial;
			    $oCtb20->si96_vlsaldofinalfonte    	+= $nSaldoFinal;
	       }
	       
	       $sSqlReg21="select  21 as tiporegistro,
				        c69_codlan as codreduzido ,
				        1 as tipomovimentacao,
				        case when substr(o57_fonte,1,2) = '49' and c71_coddoc in (100) then 8
				             when c71_coddoc in (100) then 1
				             when c71_coddoc in (140) then 5
				             when c71_coddoc in (121,131,141,152,153,162,163,6,36,38,101) then 10
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
				       where c69_debito = {$nConta}
				         and c69_data between '".$this->sDataInicial."' AND '".$this->sDataFinal."'
				
				union all 
				
				select  21 as tiporegistro,
				        c69_codlan as codreduzido ,
				        case when c71_coddoc in (101) and substr(o57_fonte,1,2) = '49' then 1 else 2 end as tipomovimentacao,
				        case when c71_coddoc in (100) and substr(o57_fonte,1,2) = '49' then 16
				             when c71_coddoc in (101) and substr(o57_fonte,1,2) = '49' then 2
				             when c71_coddoc in (140) then 6
				             when c71_coddoc in (121,131,141,152,153,162,163,6,36,38,101) then 8
				             when c71_coddoc in (5,35,37) then 8 
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
				       where c69_credito = {$nConta}
				         and c69_data between '".$this->sDataInicial."' AND '".$this->sDataFinal."'";
		   
    		$rsMovi21 = db_query($sSqlReg21);
    		
    		
    		//db_criatabela($rsMovi21);exit;
    		
    		if(pg_num_rows($rsMovi21) != 0){
    			
    			for ($iCont21 = 0; $iCont21 < pg_num_rows($rsMovi21); $iCont21++) {
    		
    		  		$oMovi  = db_utils::fieldsMemory($rsMovi21, $iCont21);
    		  		
    		  		$cCtb21 = new stdClass();
    		  			    
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
			    		      		  
			    	if (!isset($oCtb20->ext21[$sHash])) {
			    		  
				    		  $oDadosMovi21 = new stdClass();
				    		  
				    		  $oDadosMovi21->si97_tiporegistro         = $oMovi->tiporegistro;
				    		  $oDadosMovi21->si97_codctb               = $oCtb20->si96_codctb;
				    		  $oDadosMovi21->si97_codfontrecursos      = $oCtb20->si96_codfontrecursos;
				    		  $oDadosMovi21->si97_codreduzidomov       = $oMovi->codreduzido;
				    		  $oDadosMovi21->si97_tipomovimentacao     = $oMovi->tipomovimentacao;
				    		  $oDadosMovi21->si97_tipoentrsaida        = $oMovi->tipoentrsaida;
				    		  $oDadosMovi21->si97_valorentrsaida       = $nValor;
				    		  $oDadosMovi21->si97_codctbtransf  	 	 = $oMovi->codctbtransf;
				    		  $oDadosMovi21->si97_codfontectbtransf  	 = $oMovi->codfontectbtransf;
				    		  $oDadosMovi21->si97_mes  			     = $this->sDataFinal['5'].$this->sDataFinal['6'];
				    		  $oDadosMovi21->si97_instit				 = db_getsession("DB_instit");
				    		  $oDadosMovi21->registro22                = array();
				    		  
				    		  $oCtb20->ext21[$sHash] =  $oDadosMovi21;
			    		  
			    	 } else {
			    		  	  $oCtb20->ext21[$sHash]->si104_valorentrsaida += $nValor;
			    	 }
			    		  
			    		$sSql ="select 22 as tiporegistro,
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
							    		
							    	  $oDadosReceita->si98_tiporegistro                      = $oRecita->tiporegistro;
							    	  $oDadosReceita->si98_codreduzidomov                    = $oCtb20->ext21[$sHash]->si104_codreduzido;
							          $oDadosReceita->si98_ededucaodereceita                 = $oRecita->ededucaodereceita;
							    	  $oDadosReceita->si98_identificadordeducao              = $oRecita->identificadordeducao;
							    	  $oDadosReceita->si98_naturezareceita                   = $oRecita->naturezareceita;
							          $oDadosReceita->si98_vlrreceitacont                    = $oRecita->vlrreceitacont;
							    	  $oDadosReceita->si98_mes                               = $this->sDataFinal['5'].$this->sDataFinal['6'];
							    	  $oDadosReceita->si98_reg20							 = 0;
							    	  $oDadosReceita->si98_instit                            = $oDadosCaixa->si103_sequencial;
							    	  
							    		  		    		  
							    	  $oCtb20->ext21[$sHash]->registro22[] = $oDadosReceita;
						    		  
				
					    	}
			    }
			    			
			}
	       
    	}
    	//echo pg_last_error();
    	//echo "<pre>";print_r($oCtb20);
    	
    			$cCtb20 = new cl_ctb20$PROXIMO_ANO();
    	
    	        $cCtb20->si96_tiporegistro 			= $oCtb20->si96_tiporegistro;
			    $cCtb20->si96_codorgao 				= $oCtb20->si96_codorgao;
			    $cCtb20->si96_codctb 				= $oCtb20->si96_codctb;
			    $cCtb20->si96_codfontrecursos 		= $oCtb20->si96_codfontrecursos;
			    $cCtb20->si96_vlsaldoinicialfonte 	= $oCtb20->si96_vlsaldoinicialfonte;
			    $cCtb20->si96_vlsaldofinalfonte    	= $oCtb20->si96_vlsaldofinalfonte;
			    $cCtb20->si96_mes 					= $oCtb20->si96_mes;
			    $cCtb20->si96_instit			    = $oCtb20->si96_instit;
			   
			    $cCtb20->incluir(null);
			    if ($cCtb20->erro_status == 0) {
			    	
					 throw new Exception($cCtb20->erro_msg);
				}
			    foreach ($oCtb20->ext21 as $oCtb21agrupado){
			    	
			    	 $cCtb21 = new cl_ctb21$PROXIMO_ANO();
			    	
			    	 $cCtb21->si97_tiporegistro         = $oCtb21agrupado->si97_tiporegistro;
				     $cCtb21->si97_codctb               = $oCtb21agrupado->si97_codctb;
				     $cCtb21->si97_codfontrecursos      = $oCtb21agrupado->si97_codfontrecursos;
				     $cCtb21->si97_codreduzidomov       = $oCtb21agrupado->si97_codreduzidomov;
				     $cCtb21->si97_tipomovimentacao     = $oCtb21agrupado->si97_tipomovimentacao;
				     $cCtb21->si97_tipoentrsaida        = $oCtb21agrupado->si97_tipoentrsaida;
				     $cCtb21->si97_valorentrsaida       = $oCtb21agrupado->si97_valorentrsaida;
				     $cCtb21->si97_codctbtransf  	 	= $oCtb21agrupado->si97_codctbtransf;
				     $cCtb21->si97_codfontectbtransf  	= $oCtb21agrupado->si97_codfontectbtransf;
				     $cCtb21->si97_mes  			    = $oCtb21agrupado->si97_mes;
				     $cCtb21->si97_reg20				= $cCtb20->si96_sequencial;
				     $cCtb21->si97_instit				= $oCtb21agrupado->si97_instit;
				     
				    $cCtb21->incluir(null);
				    if ($cCtb21->erro_status == 0) {
				    	
						 throw new Exception($cCtb21->erro_msg);
					}
				     
				     
				     foreach($cCtb21->registro22 as $oCtb22Agrupado){
				     	
				     	$cCtb22 = new cl_ctb22$PROXIMO_ANO();
				     	
				     	$cCtb22->si98_tiporegistro                      = $oCtb22Agrupado->si98_tiporegistro;
						$cCtb22->si98_codreduzidomov                    = $oCtb22Agrupado->si98_codreduzidomov;
						$cCtb22->si98_ededucaodereceita                 = $oCtb22Agrupado->si98_ededucaodereceita;
						$cCtb22->si98_identificadordeducao              = $oCtb22Agrupado->si98_identificadordeducao;
						$cCtb22->si98_naturezareceita                   = $oCtb22Agrupado->si98_naturezareceita;
						$cCtb22->si98_vlrreceitacont                    = $oCtb22Agrupado->si98_vlrreceitacont;
						$cCtb22->si98_mes                               = $oCtb22Agrupado->si98_mes;
						$cCtb22->si98_reg21							    = $cCtb21->si97_sequencial;
						$cCtb22->si98_instit                            = $oCtb22Agrupado->si103_sequencial;
						
					    $cCtb22->incluir(null);
					    if ($cCtb22->erro_status == 0) {
					    	
							 throw new Exception($cCtb22->erro_msg);
						}
				     }
			    	
			    	
			    }
    	
    }
    
    
    
    /*
     * REGISTRO 50 CONTAS ENCERRADAS
     */
    
    $sSqlCtbEncerradas = "select 50 as tiporegistro,
							     si09_codorgaotce,
							     k13_reduz as codctb,
							     k13_limite as dataencerramento
						       from saltes 
						       join conplanoreduz on k13_reduz = c61_reduz and c61_anousu = ".db_getsession("DB_anousu")."
						       join conplanoconta on c63_codcon = c61_codcon and c63_anousu = c61_anousu
						  left join conplanocontabancaria on c56_codcon = c61_codcon and c56_anousu = c61_anousu
						  left join contabancaria on c56_contabancaria = db83_sequencial
						  left join infocomplementaresinstit on si09_instit = c61_instit
						    where k13_limite between '".$this->sDataInicial."' and '".$this->sDataFinal."'
							  and c61_instit = ".db_getsession("DB_instit");
    $rsCtbEncerradas = db_query($sSqlCtbEncerradas);
    if(pg_num_rows($rsCtbEncerradas)!=0){
    	
	    for ($iCont50 = 0; $iCont50 < pg_num_rows($rsCtbEncerradas); $iCont50++) {
	    		
	    		$oMovi50  = db_utils::fieldsMemory($rsCtbEncerradas, $iCont50);
	    		
	    		$cCtb50 = new cl_ctb50$PROXIMO_ANO();
	    		
	    		$cCtb50->si102_tiporegistro		= $oMovi50->tiporegistro;
				$cCtb50->si102_codorgao			= $oMovi50->si09_codorgaotce;
				$cCtb50->si102_codctb			= $oMovi50->codctb;
				$cCtb50->si102_dataencerramento	= $oMovi50->dataencerramento;
				$cCtb50->si102_mes              = $this->sDataFinal['5'].$this->sDataFinal['6'];
				$cCtb50->si102_instit           = db_getsession("DB_instit");
				
		    	$cCtb50->incluir(null);
				if ($cCtb50->erro_status == 0) {
					 throw new Exception($cCtb50->erro_msg);
				}
	    		
	    }
	    
    }
    
    
    
   
   $oGerarCTB = new GerarCTB();
   $oGerarCTB->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];;
   $oGerarCTB->gerarDados(); 
  }
		
 }
