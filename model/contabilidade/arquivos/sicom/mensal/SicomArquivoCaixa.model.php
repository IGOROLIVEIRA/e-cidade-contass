<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

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
    
    $aElementos[10] = array(
                          "tipoRegistro",
                          "codOrgao",
                          "vlSaldoInicial",
                          "vlSaldoFinal"
                        );
    $aElementos[11] = array(
                          "tipoRegistro",
                          "codReduzido",
                          "tipoMovimentacao",
                          "tipoEntrSaida",
    										  "descrMovimentacao",
    											"valorEntrSaida",
                          "contaTransf",
                          "digitoVerificadorContaCorrente"
                        );
    $aElementos[12] = array(
                          "tipoRegistro",
                          "codReduzido",
                          "identificadorDeducao",
                          "rubrica",
    											"vlrReceitaCont"
                        );
    return $aElementos;
  }
  
  /**
   * selecionar os dados das contas Caixa
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
    
  	$sSql  = "SELECT * FROM db_config ";
		$sSql .= "	WHERE prefeitura = 't'";
    	
    $rsInst = db_query($sSql);
    $sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;
      
  	/**
  	 * selecionar arquivo xml com dados dos orgão
  	 */
    $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomorgao.xml";
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuração dos orgãos do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oOrgaos      = $oDOMDocument->getElementsByTagName('orgao');
    
    /**
     * percorrer os orgaos retornados do xml para selecionar o orgao da inst logada
     * para selecionar os dados da instit
     */
    foreach ($oOrgaos as $oOrgao) {
      
    	if($oOrgao->getAttribute('instituicao') == db_getsession("DB_instit")){
        $sOrgao     = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
    	}
    	
    }
  
    if (!isset($oOrgao)) {
      throw new Exception("Arquivo sem configuração de Orgãos.");
    }
    
    $sSql  = "SELECT c60_codcon,c61_reduz,c60_descr from ";
    $sSql .= "conplano join conplanoreduz on c60_codcon = c61_codcon ";
    $sSql .= "where c60_codsis = 5 and c60_anousu = ".db_getsession("DB_anousu");
    $sSql .= " and c61_anousu = ".db_getsession("DB_anousu")." and c61_instit = ".db_getsession("DB_instit");
    
    $rsContas = db_query($sSql);
    
    /**
     * percorrer registros de contas retornados do sql acima
     */
    
    for ($iCont = 0;$iCont < pg_num_rows($rsContas); $iCont++) {
      	    	
    	$oContas = db_utils::fieldsMemory($rsContas,$iCont);
    	
    	$where  = " c61_instit in (".db_getsession("DB_instit").") and c60_codsis in (5) and substr(c60_estrut,1,3) != '112' ";
    	$where .= "and c61_codcon = ".$oContas->c60_codcon;
 
      $rsPlanoContas = db_planocontassaldo(db_getsession("DB_anousu"),$this->sDataInicial,$this->sDataFinal,false,$where);
    	
      for ($iContPlano = 0; $iContPlano < pg_num_rows($rsPlanoContas);$iContPlano++) {
    	  
      	if (db_utils::fieldsMemory($rsPlanoContas, $iContPlano)->c61_reduz != 0) {
      	  $oPlanoContas = db_utils::fieldsMemory($rsPlanoContas, $iContPlano);
      	}
      	
      }
    	
         
      
    	if (!isset($this->aDados[10])) {
    	
    		$oDadosCaixa = new stdClass();
    	
    	  $oDadosCaixa->tipoRegistro    = 10;
    	  $oDadosCaixa->detalhesessao   = 10;
    	  $oDadosCaixa->codOrgao        = $sOrgao;
    	  $oDadosCaixa->vlSaldoInicial  = number_format($oPlanoContas->saldo_anterior, 2, "", "");
    	  $oDadosCaixa->vlSaldoFinal    = number_format($oPlanoContas->saldo_final, 2, "", "");
    	
    	  $this->aDados[10] = $oDadosCaixa;
    	  
    	} else {
    		
    		if ($oPlanoContas->saldo_anterior > 0) {
    			$this->aDados[10]->vlSaldoInicial += number_format($oPlanoContas->saldo_anterior, 2, "", "");
    		}
    	  if ($oPlanoContas->saldo_final > 0) {
    	    $this->aDados[10]->vlSaldoFinal   += number_format($oPlanoContas->saldo_final, 2, "", "");
    		}
    	  	
    	}
    	
    	$sSql = "select
                        conplanoreduz.c61_codcon,
                        conplanoreduz.c61_reduz, 
		        conplano.c60_estrut,
                        conplano.c60_descr as conta_descr,
	                c69_codlan,
                        c69_sequen,
                        c69_data, 
                        c69_codhist, 
                        c53_coddoc,
                        c53_descr, 
                        c69_debito,
			debplano.c60_descr as debito_descr,
                        c69_credito,
			credplano.c60_descr as credito_descr,
                        c69_valor,
                        case when c69_debito = conplanoreduz.c61_reduz then 
                        'D' 
                        else 'C' end  as tipo,                      
						c50_codhist,
						c50_descr,
						c74_codrec,
						c79_codsup,
						c75_numemp,
						e60_codemp,
                        e60_resumo,        
						e60_anousu,
						c73_coddot,
						c76_numcgm,
						c78_chave,
						c72_complem ,
						z01_numcgm,
						z01_nome
                from conplanoreduz 
                     inner join conlancamval on  c69_anousu=conplanoreduz.c61_anousu and ( c69_debito=conplanoreduz.c61_reduz or c69_credito = conplanoreduz.c61_reduz)
                     inner join conplano     on c60_codcon = conplanoreduz.c61_codcon and c60_anousu=conplanoreduz.c61_anousu

                     inner join conplanoreduz debval on debval.c61_anousu = conlancamval.c69_anousu and
                                                        debval.c61_reduz  = conlancamval.c69_debito
                     inner join conplano  debplano  on debplano.c60_anousu = debval.c61_anousu and
                                                        debplano.c60_codcon = debval.c61_codcon
   
                     inner join conplanoreduz credval on credval.c61_anousu = conlancamval.c69_anousu and
                                                         credval.c61_reduz  = conlancamval.c69_credito
                     inner join conplano  credplano  on credplano.c60_anousu = credval.c61_anousu and
                                                        credplano.c60_codcon = credval.c61_codcon		     
		     
		     left join conhist          on c50_codhist = c69_codhist

                     left outer join conlancamdoc on c71_codlan  = c69_codlan 
                     left outer join conhistdoc   on c53_coddoc  = conlancamdoc.c71_coddoc 
                     left outer join conlancamrec on c74_codlan = c69_codlan 
                                                 and c74_anousu = c69_anousu
                     left outer join conlancamsup on c79_codlan = c69_codlan

		     left outer join conlancamemp on c75_codlan = c69_codlan
		     left outer join empempenho   on  e60_numemp = conlancamemp.c75_numemp

		     left outer join conlancamdot on c73_codlan = c69_codlan
                                                 and c73_anousu = c69_anousu
		     left join conlancamcgm on c76_codlan = c69_codlan
		     left join  cgm on z01_numcgm = c76_numcgm
		     left outer join conlancamdig on c78_codlan = c69_codlan
		     left outer join conlancamcompl on c72_codlan = c69_codlan
         where conplanoreduz.c61_anousu = " . db_getsession("DB_anousu") . " 
         and conplanoreduz.c61_reduz = {$oPlanoContas->c61_reduz}  and conplanoreduz.c61_instit =" . db_getsession("DB_instit")." and
         c69_data between '{$this->sDataInicial}' and '{$this->sDataFinal}'  
         order by conplano.c60_estrut, c69_data,c69_codlan,c69_sequen";
    		
    		$rsMovi = db_query($sSql);
    		$aDadosAgrupados = array();
    		/**
    		 * passar os dados do registro 11 para o array $this->aDados
    		 */
    		for ($iCont2 = 0; $iCont2 < pg_num_rows($rsMovi); $iCont2++) {
    		
    		  $oMovi  = db_utils::fieldsMemory($rsMovi, $iCont2);
    		  
    		  /**
    		   * codições para passar o valor pra o tipo de movimentação
    		   */
    		  if ($oMovi->c69_debito == $oMovi->c61_reduz) {
    		    $iTipoMovimentacao = "1";	
    		  } else {
    			  $iTipoMovimentacao = "2";
    		  }
    		
    		  /**
    		   * condições para passar o valor para tipoEntrSaida, contaTrans e digVerCtCorrenteTransf
    		   */
    		  $iContaTransf            = " ";
          $iDigVerCtCorrenteTransf = " ";
    		
    		  if ($oMovi->c53_coddoc == 5) {
    			  $iTipoEntrSaida = "06";
    		  } else {
    			
    			  if ($oMovi->c53_coddoc == 100) {
    			    $iTipoEntrSaida = "01";	
    			  } else {
    				
    			    if ($oMovi->c53_coddoc == 6 || $oMovi->c53_coddoc == 101) {
    			      $iTipoEntrSaida = "08";	
    			    } else {
    			  	
    			  	  $sSql  = "SELECT c61_codcon,c61_reduz, c60_codsis,c63_conta,c63_dvconta from ";
    			  	  $sSql .= "conplanoreduz join conplano on c61_codcon = c60_codcon join conplanoconta on c63_codcon = c61_codcon "; 
    			  	  $sSql .= "where c61_reduz = {$oMovi->c61_reduz} and c61_anousu = ".db_getsession("DB_anousu");
    			  	  $sSql .= " and c60_anousu = ".db_getsession("DB_anousu")." and c63_anousu = ".db_getsession("DB_anousu");
                $rsTipoEntrSaida = db_query($sSql);
                $oTipoEntrSaida  = db_utils::fieldsMemory($rsTipoEntrSaida, 0);
    			  	
    			  	  if ($oTipoEntrSaida->c60_codsis == 5) {
    			  		
    			  		  if($oMovi->c69_debito == $oMovi->c61_reduz){
    			  			
    			  			  $iTipoEntrSaida = "03";
    			  			  $iCodReduz = $oMovi->c69_credito;
    			  			
    			  		  } else {
    			  			
    			  			  $iTipoEntrSaida = "04";
    			  			  $iCodReduz      = $oMovi->c69_debito;
    			  			
    			  		  }
    			  		  $sSql  = "select c63_conta, c63_dvconta from conplanoconta";
    			  	    $sSql .= " where c63_codcon = $iCodReduz";
                  $rsContaTransf           = db_query($sSql);
                  $iContaTransf            = substr(db_utils::fieldsMemory($rsContaTransf, 0)->c63_conta, -12);
                  $iDigVerCtCorrenteTransf = str_pad(db_utils::fieldsMemory($rsContaTransf, 0)->c63_dvconta, 2, "0", STR_PAD_LEFT);
    			  		
    			  	  } else {
    			  		
    			  		  if ($oTipoEntrSaida->c60_codsis == 6) {
    			  			  $iTipoEntrSaida = "09";
    			  		  } else {
    			  		    $iTipoEntrSaida = "10";	
    			  		  }
    			  		
    			  	  }
    			    }
    				
    			  }
    			
    		  }
    		  
    		  $sHash  = "11";
    		  $sHash .= substr($oMovi->c61_codcon, 0, 15);
    		  $sHash .= $iTipoEntrSaida;
    		  
    		  if (!isset($aDadosAgrupados[$sHash])) {
    		  
	    		  $oDadosMovi = new stdClass();
	    		
	    		  $oDadosMovi->tipoRegistro            = 11;
	    		  $oDadosMovi->detalhesessao           = 11;
	    		  $oDadosMovi->codReduzido             = substr($oMovi->c61_codcon, 0, 15);
	    		  $oDadosMovi->tipoMovimentacao        = $iTipoMovimentacao;
	    		  $oDadosMovi->tipoEntrSaida           = $iTipoEntrSaida;
	    		  $oDadosMovi->descrMovimentacao       = substr($oMovi->c50_descr, 0, 50);
	    		  $oDadosMovi->valorEntrSaida          = $oMovi->c69_valor;
	    		  $oDadosMovi->contaTransf             = $iContaTransf;
	    		  $oDadosMovi->digVerCtCorrenteTransf  = $iDigVerCtCorrenteTransf;
	    		  //$this->aDados[]                    =   oDadosMovi;
	    		  $aDadosAgrupados[$sHash] =  $oDadosMovi;
    		  
    		  } else {
    		  	$aDadosAgrupados[$sHash]->valorEntrSaida += $oMovi->c69_valor;
    		  }
    		  
    		}
    		
            foreach ($oDadosAgrupados as $oDados) {
    	 	  $oDados->valorEntrSaida = number_format($oDados->c69_valor, 2, "", "");
    	 	  $this->aDados[] = $oDados;
    	    }
    		
    		$sSql = "select
                        conplanoreduz.c61_codcon,
                        conplanoreduz.c61_reduz, 
		        conplano.c60_estrut,
                        conplano.c60_descr as conta_descr,
	                c69_codlan,
                        c69_sequen,
                        c69_data, 
                        c69_codhist, 
                        c53_coddoc,
                        c53_descr, 
                        c69_debito,
			debplano.c60_descr as debito_descr,
                        c69_credito,
			credplano.c60_descr as credito_descr,
                        c69_valor,
                        case when c69_debito = conplanoreduz.c61_reduz then 
                        'D' 
                        else 'C' end  as tipo,                      
						c50_codhist,
						c50_descr,
						c74_codrec,
						c79_codsup,
						c75_numemp,
						e60_codemp,
                        e60_resumo,        
						e60_anousu,
						c73_coddot,
						c76_numcgm,
						c78_chave,
						c72_complem ,
						z01_numcgm,
						z01_nome
                from conplanoreduz 
                     inner join conlancamval on  c69_anousu=conplanoreduz.c61_anousu and ( c69_debito=conplanoreduz.c61_reduz or c69_credito = conplanoreduz.c61_reduz)
                     inner join conplano     on c60_codcon = conplanoreduz.c61_codcon and c60_anousu=conplanoreduz.c61_anousu

                     inner join conplanoreduz debval on debval.c61_anousu = conlancamval.c69_anousu and
                                                        debval.c61_reduz  = conlancamval.c69_debito
                     inner join conplano  debplano  on debplano.c60_anousu = debval.c61_anousu and
                                                        debplano.c60_codcon = debval.c61_codcon
   
                     inner join conplanoreduz credval on credval.c61_anousu = conlancamval.c69_anousu and
                                                         credval.c61_reduz  = conlancamval.c69_credito
                     inner join conplano  credplano  on credplano.c60_anousu = credval.c61_anousu and
                                                        credplano.c60_codcon = credval.c61_codcon		     
		     
		     left join conhist          on c50_codhist = c69_codhist

                     left outer join conlancamdoc on c71_codlan  = c69_codlan 
                     left outer join conhistdoc   on c53_coddoc  = conlancamdoc.c71_coddoc 
                     left outer join conlancamrec on c74_codlan = c69_codlan 
                                                 and c74_anousu = c69_anousu
                     left outer join conlancamsup on c79_codlan = c69_codlan

		     left outer join conlancamemp on c75_codlan = c69_codlan
		     left outer join empempenho   on  e60_numemp = conlancamemp.c75_numemp

		     left outer join conlancamdot on c73_codlan = c69_codlan
                                                 and c73_anousu = c69_anousu
		     left join conlancamcgm on c76_codlan = c69_codlan
		     left join  cgm on z01_numcgm = c76_numcgm
		     left outer join conlancamdig on c78_codlan = c69_codlan
		     left outer join conlancamcompl on c72_codlan = c69_codlan
         where conplanoreduz.c61_anousu = " . db_getsession("DB_anousu") . " 
         and conplanoreduz.c61_reduz = {$oPlanoContas->c61_reduz}  and conplanoreduz.c61_instit =" . db_getsession("DB_instit")." and
         c69_data between '{$this->sDataInicial}' and '{$this->sDataFinal}' and c53_coddoc = 100
         order by conplano.c60_estrut, c69_data,c69_codlan,c69_sequen";
    		
    		$rsReceita = db_query($sSql);
    		
    		$aDadosAgrupados = array();
        /**
    		 * passar os dados do registro 12 para o array $this->aDados
    		 */
    		for ($iCont3 = 0; $iCont3 < pg_num_rows($rsReceita); $iCont3++) {
    		  	
    		  $oReceita  = db_utils::fieldsMemory($rsReceita, $iCont3);
    		
    		  $sSql  = "select o70_concarpeculiar from orcreceita";
    		  $sSql .= " where o70_codfon = ".$oReceita->c61_codcon;
          $rsIdentDeducao           = db_query($sSql);
          $iIdentDeducao            = str_pad(db_utils::fieldsMemory($rsIdentDeducao, 0)->o70_concarpeculiar, 2, "0", STR_PAD_LEFT);
    		
          	  $sHash  = "12";
    		  $sHash .= substr($oReceita->c61_codcon, 0, 15);
    		  $sHash .= $iIdentDeducao;
    		  $sHash .= substr($oReceita->c60_estrut, 1, 8);
    		  
    		  if (!isset($aDadosAgrupados[$sHash])) {
          	
	    		  $oDadosReceita = new stdClass();
	    		
	    		  $oDadosReceita->tipoRegistro                      = 12;
	    		  $oDadosReceita->detalhesessao                     = 12;
	    		  $oDadosReceita->codReduzido                       = substr($oReceita->c61_codcon, 0, 15);
	    		  $oDadosReceita->identificadorDeduca               = $iIdentDeducao;
	    		  $oDadosReceita->rubrica                           = substr($oReceita->c60_estrut, 1, 8);
	    		  $oDadosReceita->vlrReceitaCont                    = $oReceita->c69_valor;
	    		 
	    		  //$this->aDados[] = $oDadosReceita;
	    		  $aDadosAgrupados[$sHash] =  $oDadosMovi;
	    		  
    		  } else {
    		  	
    		  	$aDadosAgrupados[$sHash]->vlrReceitaCont += $oReceita->c69_valor;
    		  	
    		  }
    		  
    		}

            foreach ($oDadosAgrupados as $oDados) {
    	 	  $oDados->vlrReceitaCont = number_format($oDados->c69_valor, 2, "", "");
    	 	  $this->aDados[] = $oDados;
    	    }
    		
    	
    }
    	    
  }
		
 }