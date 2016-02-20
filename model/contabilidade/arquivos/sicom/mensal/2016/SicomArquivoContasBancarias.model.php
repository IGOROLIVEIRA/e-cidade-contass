<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_ctb102016_classe.php");
require_once ("classes/db_ctb202016_classe.php");
require_once ("classes/db_ctb212016_classe.php");
require_once ("classes/db_ctb222016_classe.php");
require_once ("classes/db_ctb302016_classe.php");
require_once ("classes/db_ctb312016_classe.php");
require_once ("classes/db_ctb402016_classe.php");
require_once ("classes/db_ctb412016_classe.php");
require_once ("classes/db_ctb502016_classe.php");
require_once ("classes/db_ctb602016_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2016/GerarCTB.model.php");


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
  			
	
	      
  	
  	            
  	$cCtb10 = new cl_ctb102016();
	$cCtb20 = new cl_ctb202016();
	$cCtb21 = new cl_ctb212016();
	$cCtb22 = new cl_ctb222016();
	$cCtb30 = new cl_ctb302016();
	$cCtb31 = new cl_ctb312016();
	$cCtb40 = new cl_ctb402016();
	$cCtb41 = new cl_ctb412016();
	$cCtb50 = new cl_ctb502016();
	
      
   /**
  	 * selecionar arquivo xml com dados das receitas
  	 */
  	$sSql  = "SELECT * FROM db_config ";
		$sSql .= "	WHERE prefeitura = 't'";
    	
    $rsInst = db_query($sSql);
    $sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;
    $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomnaturezareceita.xml";
  
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oNaturezaReceita = $oDOMDocument->getElementsByTagName('receita');
   
	 /**
	  * excluir informacoes do mes caso ja tenha sido gerado anteriormente
	  */
		    
	 $result = $cCtb20->sql_record($cCtb20->sql_query(NULL,"*",NULL,"si96_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'] 
	 ." and si96_instit = ". db_getsession("DB_instit")));
	 
	 
     db_inicio_transacao();
	 if (pg_num_rows($result) > 0) {
	 	
	   $cCtb50->excluir(NULL,"si102_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si102_instit = ". db_getsession("DB_instit"));
	   if ($cCtb50->erro_status == 0) {
		   throw new Exception($cCtb50->erro_msg);
		 }

	 	 $cCtb22->excluir(NULL,"si98_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si98_instit = ". db_getsession("DB_instit"));
		 if ($cCtb22->erro_status == 0) {
		 	
		    	  throw new Exception($cCtb22->erro_msg);
		 }
	 	 $cCtb21->excluir(NULL,"si97_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si97_instit = ". db_getsession("DB_instit"));
	 	 if ($cCtb21->erro_status == 0) {
		 	
		    	  throw new Exception($cCtb21->erro_msg);
		 }
	 	 $cCtb20->excluir(NULL,"si96_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si96_instit = ". db_getsession("DB_instit"));
	 	if ($cCtb20->erro_status == 0) {
		 	
		    	  throw new Exception($cCtb20->erro_msg);
		 }
		 $cCtb10->excluir(NULL,"si95_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si95_instit = ". db_getsession("DB_instit"));
		 if ($cCtb10->erro_status == 0) {
		 	
		    	  throw new Exception($cCtb10->erro_msg);
		 }
	 }
	 db_fim_transacao();
   
    $sSqlGeral = "select  10 as tiporegistro,
					     k13_reduz as codctb,
					     c61_codtce as codtce, 
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
				             CASE WHEN (db83_convenio is null or db83_convenio = 2) then 2 else  1 end as contaconvenio,
				             case when db83_convenio = 1 then db83_numconvenio else null end as nroconvenio,
				             case when db83_convenio = 1 then db83_dataconvenio else null end as dataassinaturaconvenio,
				             o15_codtri as recurso
				       from saltes 
				       join conplanoreduz on k13_reduz = c61_reduz and c61_anousu = ".db_getsession("DB_anousu")."
				       join conplanoconta on c63_codcon = c61_codcon and c63_anousu = c61_anousu
				       join orctiporec on c61_codigo = o15_codigo
				  left join conplanocontabancaria on c56_codcon = c61_codcon and c56_anousu = c61_anousu
				  left join contabancaria on c56_contabancaria = db83_sequencial
				  left join infocomplementaresinstit on si09_instit = c61_instit
				    where (k13_limite is null 
				    or k13_limite >= '".$this->sDataFinal."')
    				  and c61_instit = ".db_getsession("DB_instit")." order by k13_reduz";
    //echo $sSqlGeral;
    $rsContas = db_query($sSqlGeral);//db_criatabela($rsContas);
    
    $aBancosAgrupados = array();
    /* RECEITAS QUE DEVEM SER SUBSTIUIDAS RUBRICA CADASTRADA ERRADA */
    $aRectce = array('111202','111208','172136','191138','191139','191140',
                 '191308','191311','191312','191313','193104','193111',
                 '193112','193113','172401','247199','247299');
    
    $sSqlContaJainformada ="select si95_codorgao||si95_banco||si95_agencia||si95_digitoverificadoragencia||si95_contabancaria
    								||si95_digitoverificadorcontabancaria||si95_tipoconta || si95_tipoaplicacao as conta 
          					 from ctb102016 where si95_mes < ".$this->sDataFinal['5'].$this->sDataFinal['6'];
    $rsContas = db_query($sSqlGeral);
    
    for ($iCont = 0;$iCont < pg_num_rows($rsContas); $iCont++) {

      $oRegistro10 = db_utils::fieldsMemory($rsContas,$iCont);
     
      
	  $aHash  = $oRegistro10->si09_codorgaotce;
	  $aHash .= intval($oRegistro10->c63_banco);
	  $aHash .= intval($oRegistro10->c63_agencia);
	  $aHash .= intval($oRegistro10->c63_dvagencia); 
	  $aHash .= intval($oRegistro10->c63_conta);
	  $aHash .= intval($oRegistro10->c63_dvconta);
	  $aHash .= $oRegistro10->tipoconta;
	  if ($oRegistro10->si09_codorgaotce == 5) {
	  	$aHash .= $oRegistro10->tipoaplicacao;
	  }
      
      if($oRegistro10->si09_tipoinstit != 5){
      	
      	if(!isset($aBancosAgrupados[$aHash])){
      		
      		$cCtb10    =  new cl_ctb102016();
      		
      		
      		$cCtb10->si95_tiporegistro 					  =	$oRegistro10->tiporegistro;
			$cCtb10->si95_codctb 						  =	$oRegistro10->codtce != 0 ? $oRegistro10->codtce : $oRegistro10->codctb;
			$cCtb10->si95_codorgao 						  =	$oRegistro10->si09_codorgaotce;
			$cCtb10->si95_banco 						  =	$oRegistro10->c63_banco; 
			$cCtb10->si95_agencia 						  =	$oRegistro10->c63_agencia;
			$cCtb10->si95_digitoverificadoragencia 		  =	$oRegistro10->c63_dvagencia; 
			$cCtb10->si95_contabancaria 				  =	$oRegistro10->c63_conta; 
			$cCtb10->si95_digitoverificadorcontabancaria  =	$oRegistro10->c63_dvconta;
			$cCtb10->si95_tipoconta   					  =	$oRegistro10->tipoconta;
			$cCtb10->si95_tipoaplicacao   				  =	$oRegistro10->tipoaplicacao;
			$cCtb10->si95_nroseqaplicacao   			  =	$oRegistro10->nroseqaplicacao;
			$cCtb10->si95_desccontabancaria   			  =	substr($oRegistro10->desccontabancaria, 0, 50);
			$cCtb10->si95_contaconvenio   				  =	$oRegistro10->contaconvenio;
			$cCtb10->si95_nroconvenio   				  =	$oRegistro10->nroconvenio;
			$cCtb10->si95_dataassinaturaconvenio   		  =	$oRegistro10->dataassinaturaconvenio;
			$cCtb10->si95_mes							  = $this->sDataFinal['5'].$this->sDataFinal['6'];
            $cCtb10->si95_instit						  = db_getsession("DB_instit");
            $cCtb10->recurso                  = $oRegistro10->recurso;
            $cCtb10->contas								  = array();

            
      	    $sSqlVerifica  = "SELECT * FROM ctb102016 WHERE si95_codorgao = '$oRegistro10->si09_codorgaotce' AND si95_banco = '$oRegistro10->c63_banco' 
          AND si95_agencia = '$oRegistro10->c63_agencia' AND si95_digitoverificadoragencia = '$oRegistro10->c63_dvagencia' AND si95_contabancaria = '$oRegistro10->c63_conta' 
          AND si95_digitoverificadorcontabancaria = '$oRegistro10->c63_dvconta' AND si95_tipoconta = '$oRegistro10->tipoconta'
          AND si95_mes < ".$this->sDataFinal['5'].$this->sDataFinal['6'];
        $sSqlVerifica  .= " UNION SELECT * FROM ctb102015 WHERE si95_codorgao = '$oRegistro10->si09_codorgaotce' AND si95_banco = '$oRegistro10->c63_banco'
          AND si95_agencia = '$oRegistro10->c63_agencia' AND si95_digitoverificadoragencia = '$oRegistro10->c63_dvagencia' AND si95_contabancaria = '$oRegistro10->c63_conta' 
          AND si95_digitoverificadorcontabancaria = '$oRegistro10->c63_dvconta' AND si95_tipoconta = '$oRegistro10->tipoconta'";
      	    $sSqlVerifica .= " UNION SELECT * FROM ctb102014 WHERE si95_codorgao = '$oRegistro10->si09_codorgaotce' AND si95_banco = '$oRegistro10->c63_banco' 
          AND si95_agencia = '$oRegistro10->c63_agencia' AND si95_digitoverificadoragencia = '$oRegistro10->c63_dvagencia' AND si95_contabancaria = '$oRegistro10->c63_conta' 
          AND si95_digitoverificadorcontabancaria = '$oRegistro10->c63_dvconta' AND si95_tipoconta = '$oRegistro10->tipoconta'";
          $rsResultVerifica = db_query($sSqlVerifica);//echo $sSqlVerifica;db_criatabela($rsResultVerifica);
          
          if (pg_num_rows($rsResultVerifica) == 0) {
      	  
          	$cCtb10->incluir(null);
			      if ($cCtb10->erro_status == 0) {
				      throw new Exception($cCtb10->erro_msg);
			      }
			      
          }
            $cCtb10->contas[]= $oRegistro10->codctb;
            $aBancosAgrupados[$aHash] = $cCtb10;
            
      	}else{
      		$aBancosAgrupados[$aHash]->contas[] = $oRegistro10->codctb;
      	}
      	
        
      }else{
      		/*
      		 * FALTA AGRUPA AS CONTAS QUANDO A INSTIUICAO FOR IGUAL A 5 RPPS
      		 */
      }
 
    } 
    //echo "<pre>";print_r($aBancosAgrupados);exit;
    foreach ($aBancosAgrupados as $oContaAgrupada) {
    	
    	
    	
    	$oCtb20    = new stdClass();
    	$oCtb20FontRec = new stdClass();
    	foreach ($oContaAgrupada->contas as $nConta){
    		
    		/* DADOS REGISTRO 20*/
    		//pega saldo alterior e final da conta
    		$nMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    		if($nMes == 1){
    			$sSqlSaldoAnt = "select round((case when c62_vlrcre = 0 and c62_vlrdeb != 0 then c62_vlrdeb
				                  when c62_vlrcre != 0 and c62_vlrdeb = 0 then c62_vlrcre * -1
				                  else c62_vlrdeb end)::numeric,2) as saldoinicial
				  				  from conplanoexe where c62_reduz = {$nConta} and c62_anousu =".db_getsession("DB_anousu");
    			
    		}else{
    			   				
    			$sSqlSaldoAnt = "select round(sum(valor)::numeric,2) as saldoinicial from (
								select round(sum(c69_valor)::numeric,2) as valor 
								      from conlancamval 
								     where c69_debito = {$nConta} 
								       AND  DATE_PART('YEAR',c69_data) = ".db_getsession("DB_anousu")."
			                           AND  DATE_PART('MONTH',c69_data) >= 1 AND  DATE_PART('MONTH',c69_data) < ".$nMes."
								union all
								select (round(sum(c69_valor)::numeric,2)) * -1 as valor 
								      from conlancamval 
								     where c69_credito = {$nConta} 
								       AND  DATE_PART('YEAR',c69_data) = ".db_getsession("DB_anousu")."
			                           AND  DATE_PART('MONTH',c69_data) >= 1 AND  DATE_PART('MONTH',c69_data) < ".$nMes."
								union all
								select round((case when c62_vlrcre = 0 and c62_vlrdeb != 0 then c62_vlrdeb
								                  when c62_vlrcre != 0 and c62_vlrdeb = 0 then c62_vlrcre * -1
								                  else c62_vlrdeb end)::numeric,2) as valor
								  from conplanoexe where c62_reduz = {$nConta} and c62_anousu = ".db_getsession("DB_anousu")."
								)as movimento";
    			 //echo $sSqlSaldoAnt;exit;
    		}
    		$nSaldoInicial = db_utils::fieldsMemory( db_query($sSqlSaldoAnt),0)->saldoinicial;
    		
    		
    		
    		$sSqlMov = "select round(sum(valor)::numeric,2) as totmov from (
						select round(sum(c69_valor)::numeric,2) as valor 
						      from conlancamval 
						     where c69_debito = {$nConta}
						       AND  DATE_PART('YEAR',c69_data) = ".db_getsession("DB_anousu")."
			                   AND  DATE_PART('MONTH',c69_data) = " .$this->sDataFinal['5'].$this->sDataFinal['6']." 
						union all
						select (round(sum(c69_valor)::numeric,2)) * -1 as valor 
						      from conlancamval 
						     where c69_credito = {$nConta} 
						       AND  DATE_PART('YEAR',c69_data) = ".db_getsession("DB_anousu")."
			                   AND  DATE_PART('MONTH',c69_data) = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
						       )as movimento";
    		$nTotalMov = db_utils::fieldsMemory( db_query($sSqlMov),0)->totmov;
    		$nSaldoInicialFontRec = $nSaldoInicial;
    		
    		/**
    		 * alteração para resolver o problema de contas que tiveram a fonte de recurso alterada de um ano para o outro.
    		 * o saldo do recurso anterior será transferido para a conta com novo recurso através de um registro criado.
    		 */
    		$sSqlRecursoAnterior = "select o15_codtri from conplanoreduz 
    		join orctiporec on c61_codigo = o15_codigo
    		where c61_anousu = ".(db_getsession("DB_anousu")-1)." and c61_reduz = {$nConta}";
    		$rsFonRecAnt = db_query($sSqlRecursoAnterior);
    		$iFonRecAnt = db_utils::fieldsMemory( $rsFonRecAnt,0)->o15_codtri;
    		if ($iFonRecAnt != $oContaAgrupada->recurso && $nMes == 1 && pg_num_rows($rsFonRecAnt) > 0 ) {
    			
    			$nSaldoInicial = 0;
    		  if( !isset($oCtb20Rec->si96_codctb) ){
	              		
			      $oCtb20FontRec->si96_tiporegistro 			= '20';
			      $oCtb20FontRec->si96_codorgao 				= $oContaAgrupada->si95_codorgao;
			      $oCtb20FontRec->si96_codctb 				= $oContaAgrupada->si95_codctb;
			      $oCtb20FontRec->si96_codfontrecursos 		= $iFonRecAnt;
			      $oCtb20FontRec->si96_vlsaldoinicialfonte 	= $nSaldoInicialFontRec;
			      $oCtb20FontRec->si96_vlsaldofinalfonte    	= 0;
			      $oCtb20FontRec->si96_mes 					= $this->sDataFinal['5'].$this->sDataFinal['6'];
			      $oCtb20FontRec->si96_instit			    = db_getsession("DB_instit");
			      $oCtb20FontRec->ext21						= array();
			      
			      /**
			       * registros 21 da fonte de recurso do ano anterior
			       */
			      $oDadosMovi21 = new stdClass();
				    		  
				    $oDadosMovi21->si97_tiporegistro         = 21;
				    $oDadosMovi21->si97_codctb               = $oContaAgrupada->si95_codctb;
				    $oDadosMovi21->si97_codfontrecursos      = $iFonRecAnt;
				    $oDadosMovi21->si97_codreduzidomov       = $oContaAgrupada->si95_codctb.$iFonRecAnt;
				    $oDadosMovi21->si97_tipomovimentacao     = 2;
				    $oDadosMovi21->si97_tipoentrsaida        ='99';
				    $oDadosMovi21->si97_valorentrsaida       = $nSaldoInicialFontRec;
				    $oDadosMovi21->si97_codctbtransf  	     = ' ';
				    $oDadosMovi21->si97_codfontectbtransf    = ' ';
				    $oDadosMovi21->si97_mes  			           = $this->sDataFinal['5'].$this->sDataFinal['6'];
				    $oDadosMovi21->si97_instit			         = db_getsession("DB_instit");
				    $oCtb20FontRec->ext21[2] = $oDadosMovi21;
				    
				    $oDadosMovi21 = new stdClass();
				    		  
				    $oDadosMovi21->si97_tiporegistro         = 21;
				    $oDadosMovi21->si97_codctb               = $oContaAgrupada->si95_codctb;
				    $oDadosMovi21->si97_codfontrecursos      = $oContaAgrupada->recurso;
				    $oDadosMovi21->si97_codreduzidomov       = $oContaAgrupada->si95_codctb.$oContaAgrupada->recurso;
				    $oDadosMovi21->si97_tipomovimentacao     = 1;
				    $oDadosMovi21->si97_tipoentrsaida        ='99';
				    $oDadosMovi21->si97_valorentrsaida       = $nSaldoInicialFontRec;
				    $oDadosMovi21->si97_codctbtransf  	     = ' ';
				    $oDadosMovi21->si97_codfontectbtransf    = ' ';
				    $oDadosMovi21->si97_mes  			           = $this->sDataFinal['5'].$this->sDataFinal['6'];
				    $oDadosMovi21->si97_instit			         = db_getsession("DB_instit");
				    $oCtb20FontRec->ext21[1] = $oDadosMovi21;
			    			    
	        }else{
	          $oCtb20FontRec->si96_vlsaldoinicialfonte 	+= $nSaldoInicialFontRec;
			      $oCtb20FontRec->si96_vlsaldofinalfonte    += 0;
			      $oCtb20FontRec->ext21[1]->si97_valorentrsaida += $nSaldoInicialFontRec;
			      $oCtb20FontRec->ext21[2]->si97_valorentrsaida += $nSaldoInicialFontRec;
	        }
    		}
    		
	      if( !isset($oCtb20->si96_codctb) ){
	              		
			    $oCtb20->si96_tiporegistro 			= '20';
			    $oCtb20->si96_codorgao 				= $oContaAgrupada->si95_codorgao;
			    $oCtb20->si96_codctb 				= $oContaAgrupada->si95_codctb;
			    $oCtb20->si96_codfontrecursos 		= $oContaAgrupada->recurso;
			    $oCtb20->si96_vlsaldoinicialfonte 	= $nSaldoInicial;
			    $oCtb20->si96_vlsaldofinalfonte    	= ($nSaldoInicialFontRec + $nTotalMov);
			    $oCtb20->si96_mes 					= $this->sDataFinal['5'].$this->sDataFinal['6'];
			    $oCtb20->si96_instit			    = db_getsession("DB_instit");
			    $oCtb20->ext21						= array();
			    			    
	      }else{
	      	$oCtb20->si96_vlsaldoinicialfonte 	+= $nSaldoInicial;
			    $oCtb20->si96_vlsaldofinalfonte    	+= ($nSaldoInicialFontRec + $nTotalMov);
	      }
	       
    		       
	       $sSqlReg21="select  21 as tiporegistro,
				        c69_codlan as codreduzido,
				        1 tipomovimentacao,
				        case when substr(o57_fonte,1,2) = '49' and c71_coddoc in (100) then 16
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
				        2 as tipomovimentacao,
				        case when c71_coddoc in (101) and substr(o57_fonte,1,2) = '49' then 2
				             when c71_coddoc in (101) and substr(o57_fonte,1,2) != '49' then 3
				             when c71_coddoc in (140) and 
				             (select count(c61_codcon) from conplano 
				             join conplanoreduz on c60_codcon = c61_codcon and c61_anousu = c60_anousu 
				             where c60_codsis = 5 and c60_anousu = ".db_getsession("DB_anousu")." and c61_reduz = c69_debito) = 0 then 6
				             when c71_coddoc in (140) and 
				             (select count(c61_codcon) from conplano 
				             join conplanoreduz on c60_codcon = c61_codcon and c61_anousu = c60_anousu 
				             where c60_codsis = 5 and c60_anousu = ".db_getsession("DB_anousu")." and c61_reduz = c69_debito) > 0 then 11 
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
    		
    		
    		//db_criatabela($rsMovi21);echo pg_last_error();
    		
    		if(pg_num_rows($rsMovi21) != 0){
    			
    			for ($iCont21 = 0; $iCont21 < pg_num_rows($rsMovi21); $iCont21++) {
    		
    		  		$oMovi  = db_utils::fieldsMemory($rsMovi21, $iCont21);
    		  		
    		  		$cCtb21 = new stdClass();
    		  			    
			    	/*
			    	 * Movimentação de Estorno de Arrecadação de Receita estava duplicando diminuição no Reg. 21, 
			    	 * ocasionando erro no saldo final da conta.
			    	 *   
			    	if($oMovi->c71_coddoc == 101 && $oMovi->dedu == '49'){
			    		  	$nValor = $oMovi->valorentrsaida * -1;
			    		  	
			    	}else{
			    		  	$nValor = $oMovi->valorentrsaida;
			    	}

					*/
					
			    	$nValor = $oMovi->valorentrsaida;

			    	if($oMovi->codctbtransf != 0 && $oMovi->codctbtransf != ''){ 
			    		$sqlcontatransf = "select  si09_codorgaotce||c63_banco||c63_agencia||c63_dvagencia||c63_conta|| 
										             c63_dvconta||case when db83_tipoconta in (2,3) then 2 else 1 end as contadebito,
										             o15_codtri
										       from saltes 
										       join conplanoreduz on k13_reduz = c61_reduz and c61_anousu = ".db_getsession("DB_anousu")."
										       join conplanoconta on c63_codcon = c61_codcon and c63_anousu = c61_anousu
										       join orctiporec on c61_codigo = o15_codigo
										  left join conplanocontabancaria on c56_codcon = c61_codcon and c56_anousu = c61_anousu
										  left join contabancaria on c56_contabancaria = db83_sequencial
										  left join infocomplementaresinstit on si09_instit = c61_instit
										    where k13_reduz = {$oMovi->codctbtransf}";
			    	
			    		$rsConta = db_query($sqlcontatransf);//echo $sqlcontatransf;db_criatabela($rsConta);
			    		if (pg_num_rows($rsConta) == 0) {
			    			$sSql = "select c60_codsis from saltes join conplanoreduz on k13_reduz = c61_reduz and c61_anousu = ".db_getsession("DB_anousu")." 
			    			join conplano on c60_codcon = c61_codcon and c60_anousu = c61_anousu where k13_reduz = {$oMovi->codctbtransf} ";
			    			$rsCodSis = db_query($sSql);
			    			/**
			    			 * se o c60_codsis for 5, essa é uma conta caixa
			    			 */
			    			$iCodSis  = db_utils::fieldsMemory($rsCodSis, 0)->c60_codsis;
			    		} else {
			    			
			    		  $contaTransf  = db_utils::fieldsMemory($rsConta, 0)->contadebito;
			    		  $conta   = $aBancosAgrupados[$contaTransf]->si95_codctb;
			    		  //$recurso = db_utils::fieldsMemory($rsConta, 0)->o15_codtri;
			    		  $recurso = $aBancosAgrupados[$contaTransf]->recurso;
			    		
			    		}
			    		
			    		
			    	}else{ 
			    		$conta   = 0;
			    		$recurso = 0;
			    	}
			    	
			    	
			    	$sHash  = $oMovi->tiporegistro;
			    	$sHash .= $oCtb20->si96_codctb;
			    	$sHash .= $oCtb20->si96_codfontrecursos;
			    	$sHash .= $oMovi->tipomovimentacao;
			    	/**
			    	 * quando o codctb for igual codctbtransf, será agrupado a movimentação no tipoentrsaida 99 
			    	 */
			    	$sHash .= (($iCodSis == 5) || ($oCtb20->si96_codctb == $conta) ? '99' : $oMovi->tipoentrsaida);
			    	$sHash .= ( (($oMovi->tipoentrsaida == 5 || $oMovi->tipoentrsaida == 6 || $oMovi->tipoentrsaida == 7 || $oMovi->tipoentrsaida == 9) 
			    	            && ($iCodSis != 5) && ($oCtb20->si96_codctb != $conta)) ? $conta : 0);
			    	$sHash .= ( (($oMovi->tipoentrsaida == 5 || $oMovi->tipoentrsaida == 6 || $oMovi->tipoentrsaida == 7 || $oMovi->tipoentrsaida == 9) 
			    	            && ($iCodSis != 5) && ($oCtb20->si96_codctb != $conta)) ? $recurso : 0);
			    	
			    	
			    	if (!isset($oCtb20->ext21[$sHash])) {
			    		  
				    		  $oDadosMovi21 = new stdClass();
				    		  
				    		  $oDadosMovi21->si97_tiporegistro         = $oMovi->tiporegistro;
				    		  $oDadosMovi21->si97_codctb               = $oCtb20->si96_codctb;
				    		  $oDadosMovi21->si97_codfontrecursos      = $oCtb20->si96_codfontrecursos;
				    		  $oDadosMovi21->si97_codreduzidomov       = $oMovi->codreduzido ."0". $oMovi->tipomovimentacao;
				    		  $oDadosMovi21->si97_tipomovimentacao     = $oMovi->tipomovimentacao;
				    		  $oDadosMovi21->si97_tipoentrsaida        = (($iCodSis == 5) || ($oCtb20->si96_codctb == $conta)) ? '99' : $oMovi->tipoentrsaida;
				    		  $oDadosMovi21->si97_valorentrsaida       = $nValor;
				    		  $oDadosMovi21->si97_codctbtransf  	     = (($oDadosMovi21->si97_tipoentrsaida == 5 || $oDadosMovi21->si97_tipoentrsaida == 6 || $oDadosMovi21->si97_tipoentrsaida == 7 || $oDadosMovi21->si97_tipoentrsaida == 9) 
				    		                                              && ($iCodSis != 5) && ($oCtb20->si96_codctb != $conta)) ? $conta : 0;
				    		  $oDadosMovi21->si97_codfontectbtransf    = (($oDadosMovi21->si97_tipoentrsaida == 5 || $oDadosMovi21->si97_tipoentrsaida == 6 || $oDadosMovi21->si97_tipoentrsaida == 7 || $oDadosMovi21->si97_tipoentrsaida == 9) 
				    		                                              && ($iCodSis != 5) && ($oCtb20->si96_codctb != $conta)) ? $recurso : 0;
				    		  $oDadosMovi21->si97_mes  			           = $this->sDataFinal['5'].$this->sDataFinal['6'];
				    		  $oDadosMovi21->si97_instit			         = db_getsession("DB_instit");
				    		  $oDadosMovi21->registro22                = array();
				    		  
				    		  $oCtb20->ext21[$sHash] =  $oDadosMovi21;
			    		  
			    	 } else {
			    		  	  $oCtb20->ext21[$sHash]->si97_valorentrsaida += $nValor;
			    	 } 
			    		$sSql ="select 22 as tiporegistro,
								       c74_codlan as codreduzdio,
								       case when substr(o57_fonte,1,2) = '49' then 1
								            else 2
								        end as ededucaodereceita,
								       case when substr(o57_fonte,1,2) = '49' then substr(o57_fonte,2,2)
								            else null
								        end as identificadordeducao,
								        case when substr(o57_fonte,1,2) = '49' then substr(o57_fonte,4,8) 
								        else substr(o57_fonte,2,8) end as naturezaReceita,
								       c70_valor as vlrreceitacont       
								     from conlancamrec
								     join conlancam on c70_codlan = c74_codlan and c70_anousu = c74_anousu 
								left join orcreceita on c74_codrec = o70_codrec and o70_anousu = ".db_getsession("DB_anousu")."     
								left join orcfontes on o70_codfon = o57_codfon and o70_anousu = o57_anousu
								left join orctiporec on o15_codigo = o70_codigo
								    where c74_codlan = {$oMovi->codreduzido}";
						    		
						$rsReceita = db_query($sSql);//echo $sSql;db_criatabela($rsReceita);
			    		  $aTipoEntSaida = array('1','2','3','15','16');  
					    	if(pg_num_rows($rsReceita) != 0 && (in_array($oCtb20->ext21[$sHash]->si97_tipoentrsaida, $aTipoEntSaida))) {
				    		/*
				    		 * SQL PARA PEGAR RECEITAS DOS TIPO ENTRA SAIDA 1 RECEITAS ARRECADADA NO MES
				    		 */

							    	  $oRecita  = db_utils::fieldsMemory($rsReceita,0);
						    		  
					   $sNaturezaReceita = $oRecita->naturezareceita;
	           foreach ($oNaturezaReceita as $oNatureza) {
      	
      	       if ($oNatureza->getAttribute('instituicao') == db_getsession("DB_instit") 
						   && $oNatureza->getAttribute('receitaEcidade') == $sNaturezaReceita) {
      	         $oRecita->naturezareceita = $oNatureza->getAttribute('receitaSicom');
      	         break; 	
      	  
      	       }
      	
             }
							    	  
							    	  
					    	      if( in_array(substr($oRecita->naturezareceita, 0, 6) ,$aRectce ) ) {
                        $oRecita->naturezareceita = substr($oRecita->naturezareceita, 0, 6)."00";
                      }
                      
                      $sHash22 = $oRecita->naturezareceita.$oCtb20->ext21[$sHash]->si97_codreduzidomov;
							    	  
							    	  if(!isset( $oCtb20->ext21[$sHash]->registro22[$sHash22] )){
								    	  $oDadosReceita = new stdClass();
								    		
								    	  $oDadosReceita->si98_tiporegistro                      = $oRecita->tiporegistro;
								    	  $oDadosReceita->si98_codreduzidomov                    = $oCtb20->ext21[$sHash]->si97_codreduzidomov;
								          $oDadosReceita->si98_ededucaodereceita                 = $oRecita->ededucaodereceita;
								    	  $oDadosReceita->si98_identificadordeducao = $oRecita->identificadordeducao;
								    	  $oDadosReceita->si98_naturezareceita      = $oRecita->naturezareceita;
								          $oDadosReceita->si98_vlrreceitacont                    = $oRecita->vlrreceitacont;
								    	  $oDadosReceita->si98_mes                               = $this->sDataFinal['5'].$this->sDataFinal['6'];
								    	  $oDadosReceita->si98_reg20							   = 0;
								    	  $oDadosReceita->si98_instit                            = db_getsession("DB_instit");
								    	  
								    		  		    		  
								    	  $oCtb20->ext21[$sHash]->registro22[$sHash22] = $oDadosReceita;
							    	  }else{
							    	  	 $oCtb20->ext21[$sHash]->registro22[$sHash22]->si98_vlrreceitacont += $oRecita->vlrreceitacont; 
							    	  }
						    		 
					    	}
			    }
			    			
			}
	       
    	}
    	//echo pg_last_error();
    	//echo "<pre>";print_r($oCtb20);
    	
    	/**
    	 * inclusão do registro 20 e 21 da fonte de recurso diferente
    	 */
    	if ($oCtb20FontRec->si96_codctb != '') {
    		
        $cCtb20 = new cl_ctb202016();
    	
    	  $cCtb20->si96_tiporegistro 			  = $oCtb20FontRec->si96_tiporegistro;
			  $cCtb20->si96_codorgao 				    = $oCtb20FontRec->si96_codorgao;
			  $cCtb20->si96_codctb 				      = $oCtb20FontRec->si96_codctb;
			  $cCtb20->si96_codfontrecursos 		= $oCtb20FontRec->si96_codfontrecursos;
			  $cCtb20->si96_vlsaldoinicialfonte = $oCtb20FontRec->si96_vlsaldoinicialfonte;
			  $cCtb20->si96_vlsaldofinalfonte   = $oCtb20FontRec->si96_vlsaldofinalfonte;
			  $cCtb20->si96_mes 					      = $oCtb20FontRec->si96_mes;
			  $cCtb20->si96_instit			        = $oCtb20FontRec->si96_instit;
			   
			  $cCtb20->incluir(null);
			  if ($cCtb20->erro_status == 0) {
			    throw new Exception($cCtb20->erro_msg);
				}
			  $cCtb21 = new cl_ctb212016();
			    	
			  $cCtb21->si97_tiporegistro         = $oCtb20FontRec->ext21[2]->si97_tiporegistro;
				$cCtb21->si97_codctb               = $oCtb20FontRec->ext21[2]->si97_codctb;
				$cCtb21->si97_codfontrecursos      = $oCtb20FontRec->ext21[2]->si97_codfontrecursos;
				$cCtb21->si97_codreduzidomov       = $oCtb20FontRec->ext21[2]->si97_codreduzidomov;
				$cCtb21->si97_tipomovimentacao     = $oCtb20FontRec->ext21[2]->si97_tipomovimentacao;
				$cCtb21->si97_tipoentrsaida        = $oCtb20FontRec->ext21[2]->si97_tipoentrsaida;
				$cCtb21->si97_valorentrsaida       = abs($oCtb20FontRec->ext21[2]->si97_valorentrsaida);
				$cCtb21->si97_codctbtransf  	 	   = 0;
				$cCtb21->si97_codfontectbtransf  	 = 0;
				$cCtb21->si97_mes  			           = $oCtb20FontRec->ext21[2]->si97_mes;
				$cCtb21->si97_reg20				         = $cCtb20->si96_sequencial;
				$cCtb21->si97_instit				       = $oCtb20FontRec->ext21[2]->si97_instit;
				     
				$cCtb21->incluir(null);
				if ($cCtb21->erro_status == 0) {
				  throw new Exception($cCtb21->erro_msg);
				}
    	}
    	
    	/**
    	 * inclusão do registro 20 e 21 do procedimento normal
    	 */
    	$cCtb20 = new cl_ctb202016();
    	
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
			/**
    	 * inclusão do registro 20 e 21 da fonte de recurso diferente
    	 */
    	if ($oCtb20FontRec->si96_codctb != '') {
    		
    	  $cCtb21 = new cl_ctb212016();
			    	
			  $cCtb21->si97_tiporegistro         = $oCtb20FontRec->ext21[1]->si97_tiporegistro;
				$cCtb21->si97_codctb               = $oCtb20FontRec->ext21[1]->si97_codctb;
				$cCtb21->si97_codfontrecursos      = $oCtb20FontRec->ext21[1]->si97_codfontrecursos;
				$cCtb21->si97_codreduzidomov       = $oCtb20FontRec->ext21[1]->si97_codreduzidomov;
				$cCtb21->si97_tipomovimentacao     = $oCtb20FontRec->ext21[1]->si97_tipomovimentacao;
				$cCtb21->si97_tipoentrsaida        = $oCtb20FontRec->ext21[1]->si97_tipoentrsaida;
				$cCtb21->si97_valorentrsaida       = abs($oCtb20FontRec->ext21[1]->si97_valorentrsaida);
				$cCtb21->si97_codctbtransf  	 	   = 0;
				$cCtb21->si97_codfontectbtransf  	 = 0;
				$cCtb21->si97_mes  			           = $oCtb20FontRec->ext21[1]->si97_mes;
				$cCtb21->si97_reg20				         = $cCtb20->si96_sequencial;
				$cCtb21->si97_instit				       = $oCtb20FontRec->ext21[1]->si97_instit;
				     
				$cCtb21->incluir(null);
				if ($cCtb21->erro_status == 0) {
				  throw new Exception($cCtb21->erro_msg);
				}
    	}
    	
			foreach ($oCtb20->ext21 as $oCtb21agrupado){
			   
			  $cCtb21 = new cl_ctb212016();
			    	
			  $cCtb21->si97_tiporegistro         = $oCtb21agrupado->si97_tiporegistro;
				$cCtb21->si97_codctb               = $oCtb21agrupado->si97_codctb;
				$cCtb21->si97_codfontrecursos      = $oCtb21agrupado->si97_codfontrecursos;
				$cCtb21->si97_codreduzidomov       = $oCtb21agrupado->si97_codreduzidomov;
				$cCtb21->si97_tipomovimentacao     = $oCtb21agrupado->si97_tipomovimentacao;
				$cCtb21->si97_tipoentrsaida        = $oCtb21agrupado->si97_tipoentrsaida;
				$cCtb21->si97_valorentrsaida       = abs($oCtb21agrupado->si97_valorentrsaida);
				$cCtb21->si97_codctbtransf  	 	= ($oCtb21agrupado->si97_tipoentrsaida == 5 || $oCtb21agrupado->si97_tipoentrsaida == 6 || $oCtb21agrupado->si97_tipoentrsaida == 7 || $oCtb21agrupado->si97_tipoentrsaida == 9) ? $oCtb21agrupado->si97_codctbtransf : 0;
				$cCtb21->si97_codfontectbtransf  	= ($oCtb21agrupado->si97_tipoentrsaida == 5 || $oCtb21agrupado->si97_tipoentrsaida == 6 || $oCtb21agrupado->si97_tipoentrsaida == 7 || $oCtb21agrupado->si97_tipoentrsaida == 9) ? $oCtb21agrupado->si97_codfontectbtransf : 0;
				$cCtb21->si97_mes  			    = $oCtb21agrupado->si97_mes;
				$cCtb21->si97_reg20				= $cCtb20->si96_sequencial;
				$cCtb21->si97_instit				= $oCtb21agrupado->si97_instit;
				     
				$cCtb21->incluir(null);
				if ($cCtb21->erro_status == 0) {
				    	
				  throw new Exception($cCtb21->erro_msg);
				}
				     
				     
				foreach($oCtb21agrupado->registro22 as $oCtb22Agrupado){
				     	
				  $cCtb22 = new cl_ctb222016();
				     				     	
				  $cCtb22->si98_tiporegistro                      = $oCtb22Agrupado->si98_tiporegistro;
					$cCtb22->si98_codreduzidomov                    = $oCtb22Agrupado->si98_codreduzidomov;
					$cCtb22->si98_ededucaodereceita                 = $oCtb22Agrupado->si98_ededucaodereceita;
					$cCtb22->si98_identificadordeducao              = $oCtb22Agrupado->si98_identificadordeducao;
					$cCtb22->si98_naturezareceita                   = $oCtb22Agrupado->si98_naturezareceita;
					$cCtb22->si98_vlrreceitacont                    = $oCtb22Agrupado->si98_vlrreceitacont;
					$cCtb22->si98_mes                               = $oCtb22Agrupado->si98_mes;
					$cCtb22->si98_reg21							    = $cCtb21->si97_sequencial;
					$cCtb22->si98_instit                            = $oCtb22Agrupado->si98_instit;
						
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
							     'E' as situacaoconta,
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
	    		
	    		$cCtb50 = new cl_ctb502016();
	    		
	    		$cCtb50->si102_tiporegistro		= $oMovi50->tiporegistro;
				$cCtb50->si102_codorgao			    = $oMovi50->si09_codorgaotce;
				$cCtb50->si102_codctb			      = $oMovi50->codctb;
				$cCtb50->si102_situacaoconta    = $oMovi50->situacaoconta;
				$cCtb50->si102_datasituacao	    = $oMovi50->dataencerramento;
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
