<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

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
    
    $aElementos[10] = array(
                          "tipoRegistro",
                          "codReduzido",
                          "codOrgao",
                          "banco",
                          "agencia",
                          "digitoVerificadorAgencia",
                          "contaBancaria",
                          "digitoVerificadorContaBancaria",
                          "tipoConta",
                          "tipoRecurso",
     				              "descContaBancaria",
                          "vlSaldoInicial",
                          "vlSaldoFinal",
                          "dataEncerramento"
                        );
    $aElementos[11] = array(
                          "tipoRegistro",
                          "codReduzido",
                          "tipoMovimentacao",
                          "tipoEntrSaida",
    											"valorEntrSaida",
                          "contaTransf",
                          "digVerCtCorrenteTransf"
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
   * selecionar os dados das contas bancarias
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
    
  	/**
  	 * verificar se o boletim do caixa foi lançado na contabilidade
  	 */
  	$aMes=array('', 'janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro');
  	$aData = explode("-", $this->sDataFinal);
  	$sDiaFinal = $aData[2];
  	$aDiasRestantes = array();
  	
  	for ($iCont = 1; $iCont <= $sDiaFinal; $iCont++) {
  		
  		$sSql = "SELECT k11_lanca FROM boletim WHERE k11_data = '{$aData[0]}-{$aData[1]}-{$iCont}'";
  		$rsBoletim = db_query($sSql);
  		$sLancaBoletim = db_utils::fieldsMemory($rsBoletim)->k11_lanca;
  		if (pg_num_rows($rsBoletim) == 0 || $sLancaBoletim == 'f') {
  			throw new Exception("Boletins não processados no mês de {$aMes[(int) $aData[1]]}.
  			 Ver Relatório Contabilidade->Relatórios->Relatórios de Conferência->Boletins Lançados");
  		}
  		
  	}
  	
  	$sSql  = "SELECT * FROM db_config ";
		$sSql .= "	WHERE prefeitura = 't'";
    	
    $rsInst = db_query($sSql);
    $sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;
  	
  	/**
  	 * selecionar arquivo xml com dados dos orgão
  	 */
    $sArquivo = "config/sicom/{$sCnpj}_sicomorgao.xml";
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
      
    	if ($oOrgao->getAttribute('instituicao') == db_getsession("DB_instit")) {
        $sOrgao     = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
    	}
    	
    }
  
    if (!isset($oOrgao)) {
      throw new Exception("Arquivo sem configuração de Orgaos.");
    }
    
    $sSql  = "SELECT * from conplano join conplanoreduz on c60_codcon = c61_codcon join saltes on c61_reduz = k13_reduz 
    where c60_codsis = 6 and c60_anousu = ".db_getsession("DB_anousu")." and c61_anousu = ".db_getsession("DB_anousu")."
     and c61_instit = ".db_getsession("DB_instit")." and (k13_limite >= '".$this->sDataInicial."' or k13_limite is null) 
     and k13_dtimplantacao <= '".$this->sDataFinal."'";
    
    $rsContas = db_query($sSql);
   
    /**
     * percorrer registros de contas retornados do sql acima
     */
    for ($iCont = 0;$iCont < pg_num_rows($rsContas); $iCont++) {
    	
    	$oContas = db_utils::fieldsMemory($rsContas,$iCont);
    	
    	$where  = " c61_instit in (".db_getsession("DB_instit").") and c60_codsis in (5,6) and substr(c60_estrut,1,3) != '112' ";
    	$where .= "and c61_codcon = ".$oContas->c60_codcon;
      
      $rsPlanoContas = db_planocontassaldo(db_getsession("DB_anousu"),$this->sDataInicial,$this->sDataFinal,false,$where);      	
       
      for ($iContPlan = 0;$iCont < pg_num_rows($rsPlanoContas); $iContPlan++) {
      	
      	$oPlanoContas = db_utils::fieldsMemory($rsPlanoContas, $iContPlan);
      	if ($oPlanoContas->c61_codcon == $oContas->c60_codcon) {
      	  break;  	
      	}
    	  
      }
      
    	if ($oPlanoContas->c61_codcon == $oContas->c60_codcon) {
    		
    		$sSql  = "select * from conplanoconta ";
    		$sSql .= "where c63_codcon = ".$oPlanoContas->c61_codcon;
    		$sSql .= " and c63_anousu = ".db_getsession("DB_anousu");
    		
    		$rsConplan = db_query($sSql);
    		$oConplan  = db_utils::fieldsMemory($rsConplan, 0);
    		
    		$sSql  = "select * from saltes ";
    		$sSql .= "where k13_reduz = ".$oPlanoContas->c61_reduz;
    		
    		$rsSaltes = db_query($sSql);
    		$oSaltes  = db_utils::fieldsMemory($rsSaltes, 0);
    		
    	  $sSql  = "select o15_codtri from orctiporec ";
    		$sSql .= "where o15_codigo = ".$oPlanoContas->c61_codigo;
    		
    		$rsTipoRec = db_query($sSql);
    		$iTipoRec  = db_utils::fieldsMemory($rsTipoRec, 0)->o15_codtri;
    		if ($iTipoRec == 118 || $iTipoRec == 119) {
    			$iTipoRec = 3;
    		} else {
    			
    			if ($iTipoRec == 122 || $iTipoRec == 143 || $iTipoRec == 147) {
    			  $iTipoRec = 2;	
    			} else {
    				
    			  if ($iTipoRec == 123 || $iTipoRec == 148 || $iTipoRec == 155) {
    			    $iTipoRec = 4;	
    			  } else {
    			  	
    			    if ($iTipoRec == 124 || $iTipoRec == 142 || $iTipoRec == 156 || $iTipoRec == 157) {
    			      $iTipoRec = 5;	
    			    } else {
    			    	$iTipoRec = 1;
    			    }
    			    
    			  }
    			  
    			}
    			
    		}
    		
    		if ($oSaltes->k13_limite <= $this->sDataFinal) {
    			$sDataEncerramento = implode(array_reverse(explode("-", $oSaltes->k13_limite)));
    		} else {
    			$sDataEncerramento = " ";
    		}
    		
    		if ($oPlanoContas->sinal_anterior == "C") {
    			$nVlSaldoInicial = number_format($oPlanoContas->saldo_anterior, 2, "", "")*(-1);
    		} else {
    			$nVlSaldoInicial = number_format($oPlanoContas->saldo_anterior, 2, "", "");
    		}
    		
    	  if ($oPlanoContas->sinal_final == "C") {
    			$nVlSaldoFinal = number_format($oPlanoContas->saldo_final, 2, "", "")*(-1);
    		} else {
    			$nVlSaldoFinal = number_format($oPlanoContas->saldo_final, 2, "", "");
    		}
    		
    		$oDadosContas = new stdClass();
    		
    		$oDadosContas->tipoRegistro                    = 10;
    		$oDadosContas->detalhesessao                   = 10;
    		$oDadosContas->codReduzido                     = substr($oPlanoContas->c61_codcon, 0, 15);
    		$oDadosContas->codOrgao                        = $sOrgao;
    		$oDadosContas->banco                           = str_pad($oConplan->c63_banco, 2, "0", STR_PAD_LEFT);
    		$oDadosContas->agencia                         = substr($oConplan->c63_agencia, -6);
    		$oDadosContas->digitoVerificadorAgencia        = substr($oConplan->c63_dvagencia, -2);
    		$oDadosContas->contaBancaria                   = substr($oConplan->c63_conta, 0, 12);
    		$oDadosContas->digitoVerificadorContaBancaria  = substr($oConplan->c63_dvconta, -2);
    		$oDadosContas->tipoConta                       = str_pad($oConplan->c63_tipoconta, 2, "0", STR_PAD_LEFT);
    		$oDadosContas->tipoRecurso                     = $iTipoRec;
    		$oDadosContas->descContaBancaria               = substr($oSaltes->k13_descr, 0, 50);
    		$oDadosContas->vlSaldoInicial                  = $nVlSaldoInicial;
    		$oDadosContas->vlSaldoFinal                    = $nVlSaldoFinal;
    		$oDadosContas->dataEncerramento                = $sDataEncerramento;
    		$this->aDados[] = $oDadosContas;         
    		
    		
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
         and conplanoreduz.c61_reduz = {$oPlanoContas->c61_reduz}  and conplanoreduz.c61_instit =".db_getsession("DB_instit")." and
         c69_data between '{$this->sDataInicial}' and '{$this->sDataFinal}'  
         order by conplano.c60_estrut, c69_data,c69_codlan,c69_sequen";
    		
    		$rsMovi = db_query($sSql);
    		
    		/**
    		 * passar os dados do registro 11 para o array $this->aDados
    		 */
    		$aTipoMovimentacaoEntrSaida = array();
    		for ($iCont2 = 0; $iCont2 < pg_num_rows($rsMovi); $iCont2++) {
    		
    		  $oMovi  = db_utils::fieldsMemory($rsMovi, $iCont2);
    		
    		  /**
    		   * codições para passar o valor pra o tipo de movimentação
    		   */
    		  if ($oMovi->c69_debito == $oMovi->c61_reduz) {
    		    $iTipoMovimentacao = 1;	
    		  } else {
    			  $iTipoMovimentacao = 2;
    		  }
    		
    		  /**
    		   * condições para passar o valor para tipoEntrSaida, contaTrans e digVerCtCorrenteTransf
    		   */
    		  $iContaTransf            = " ";
          $iDigVerCtCorrenteTransf = " ";
    		  $iTipoEntrSaida          = '10';
    		  
    		  if ($oMovi->c53_coddoc == 5) {
    			  $iTipoEntrSaida = '06';
    		  } else {
    			
    			  if ($oMovi->c53_coddoc == 100) {
    			    $iTipoEntrSaida = '01';	
    			  } else {
    				
    			    if ($oMovi->c53_coddoc == 6 || $oMovi->c53_coddoc == 101) {
    			      $iTipoEntrSaida = '08';	
    			    } else {
    			  	
    			  	  $sSql  = "SELECT c61_codcon,c61_reduz, c60_codsis,c63_conta,c63_dvconta from ";
    			  	  $sSql .= "conplanoreduz join conplano on c61_codcon = c60_codcon join conplanoconta on c63_codcon = c61_codcon "; 
    			  	  $sSql .= "where c61_reduz = {$oMovi->c69_debito} and c61_anousu = ".db_getsession("DB_anousu");
    			  	  $sSql .= " and c60_anousu = ".db_getsession("DB_anousu")." and c63_anousu = ".db_getsession("DB_anousu");
                $rsTipoContaDebito = db_query($sSql);
                $oTipoContaDebito  = db_utils::fieldsMemory($rsTipoContaDebito, 0);
                
                $sSql  = "SELECT c61_codcon,c61_reduz, c60_codsis,c63_conta,c63_dvconta from ";
    			  	  $sSql .= "conplanoreduz join conplano on c61_codcon = c60_codcon join conplanoconta on c63_codcon = c61_codcon "; 
    			  	  $sSql .= "where c61_reduz = {$oMovi->c69_credito} and c61_anousu = ".db_getsession("DB_anousu");
    			  	  $sSql .= " and c60_anousu = ".db_getsession("DB_anousu")." and c63_anousu = ".db_getsession("DB_anousu");
                $rsTipoContaCredito = db_query($sSql);
                $oTipoContaCredito  = db_utils::fieldsMemory($rsTipoContaCredito, 0);
    			  	
    			  	  if ($oTipoContaDebito->c60_codsis == 6 && $oTipoContaCredito->c60_codsis == 6) {
    			  		
    			  		  if($oMovi->c69_debito == $oMovi->c61_reduz ){
    			  			
    			  			  $iTipoEntrSaida = '03';
    			  			  $iCodReduz = $oMovi->c69_credito;
    			  			
    			  		  } else {
    			  			
    			  			  $iTipoEntrSaida = '04';
    			  			  $iCodReduz      = $oMovi->c69_debito;
    			  			
    			  		  }
    			  		  $sSql  = "SELECT c63_conta, c63_dvconta FROM conplanoreduz join conplano on c61_codcon = c60_codcon 
    			  		  and c61_anousu = c60_anousu join conplanoconta on c63_codcon = c61_codcon and c63_anousu = c61_anousu
    			  		  where c61_reduz = $iCodReduz and c61_anousu = ".db_getsession("DB_anousu");
									    			  	  
                  $rsContaTransf           = db_query($sSql);
                  $iContaTransf            = substr(db_utils::fieldsMemory($rsContaTransf, 0)->c63_conta, -12);
                  
                  $iDigVerCtCorrenteTransf = substr(db_utils::fieldsMemory($rsContaTransf, 0)->c63_dvconta, -2);
    			  		
    			  	  } else {
    			  		
    			  		  if ($oTipoEntrSaida->c60_codsis == 5) {
    			  			  $iTipoEntrSaida = '09';
    			  		  } 
    			  		      			  		
    			  	  }
    			    }
    				
    			  }
    			
    		  }
    		
    		  if ($iTipoEntrSaida != '03'
    		      || $iTipoEntrSaida != '04'
    		      || $iTipoEntrSaida != '05'
    		      || $iTipoEntrSaida != '07') {
    		      	
    		      	$sHash = $iTipoMovimentacao.$iTipoEntrSaida;
    		      	if (!isset($aTipoMovimentacaoEntrSaida[$sHash])) {
    		      		    		  
    		      	  $oDadosMovi = new stdClass();
    		
				    		  $oDadosMovi->tipoRegistro            = 11;
				    		  $oDadosMovi->detalhesessao           = 11;
				    		  $oDadosMovi->codReduzido             = substr($oMovi->c61_codcon, 0, 15);
				    		  $oDadosMovi->tipoMovimentacao        = $iTipoMovimentacao;
				    		  $oDadosMovi->tipoEntrSaida           = $iTipoEntrSaida;
				    		  $oDadosMovi->valorEntrSaida          = number_format($oMovi->c69_valor, 2, "", "");
				    		  $oDadosMovi->contaTransf             = $iContaTransf;
				    		  $oDadosMovi->digVerCtCorrenteTransf  = $iDigVerCtCorrenteTransf;
				    		  $aTipoMovimentacaoEntrSaida[$sHash]  = $oDadosMovi;
				    		  
    		      	} else {
    		      		$aTipoMovimentacaoEntrSaida[$sHash]->valorEntrSaida += number_format($oMovi->c69_valor, 2, "", "");
    		      	}
    		      	
    		      	
    		      } else {
    		      	
			    		  $oDadosMovi = new stdClass();
			    		
			    		  $oDadosMovi->tipoRegistro            = 11;
			    		  $oDadosMovi->detalhesessao           = 11;
			    		  $oDadosMovi->codReduzido             = substr($oMovi->c61_codcon, 0, 15);
			    		  $oDadosMovi->tipoMovimentacao        = $iTipoMovimentacao;
			    		  $oDadosMovi->tipoEntrSaida           = $iTipoEntrSaida;
			    		  $oDadosMovi->valorEntrSaida          = number_format($oMovi->c69_valor, 2, "", "");
			    		  $oDadosMovi->contaTransf             = $iContaTransf;
			    		  $oDadosMovi->digVerCtCorrenteTransf  = $iDigVerCtCorrenteTransf;
			    		  $this->aDados[]                      = $oDadosMovi;
			    		  
    		      }
    		
    		}
    		
    		/**
    		 * passar os valores agrupados para o array de dados
    		 */
    		foreach ($aTipoMovimentacaoEntrSaida as $oTipoMovimentacaoEntrSaida) {
    			$this->aDados[] = $oTipoMovimentacaoEntrSaida;
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
    		echo $sSql;exit;
    		/**
    		 * passar os dados do registro 12 para o array $this->aDados
    		 */
    		for ($iCont3 = 0; $iCont3 < pg_num_rows($rsReceita); $iCont3++) {
    		  	
    		  $oReceita  = db_utils::fieldsMemory($rsReceita, $iCont3);
    		
    		  $sSql  = "select o57_fonte,o70_concarpeculiar from orcreceita join orcfontes on o70_codfon = o57_codfon and ";
    		  $sSql .= "o70_anousu = o57_anousu where o70_codrec = ".$oReceita->c74_codrec;
          $rsIdentDeducao = db_query($sSql);
          $iIdentDeducao  = str_pad(db_utils::fieldsMemory($rsIdentDeducao, $iCont3)->o70_concarpeculiar, 2, "0", STR_PAD_LEFT);
          $sRubrica       = substr(db_utils::fieldsMemory($rsIdentDeducao, $iCont3)->o57_fonte, 1, 8);
    		
    		  $oDadosReceita = new stdClass();
    		
    		  $oDadosReceita->tipoRegistro                      = 12;
    		  $oDadosReceita->detalhesessao                     = 12;
    		  $oDadosReceita->codReduzido                       = substr($oReceita->c61_codcon, 0, 15);
    		  $oDadosReceita->identificadorDeduca               = $iIdentDeducao;
    		  $oDadosReceita->rubrica                           = $sRubrica;
    		  $oDadosReceita->vlrReceitaCont                    = number_format($oReceita->c69_valor, 2, "", "");
    		 
    		  $this->aDados[] = $oDadosReceita;
    		
    		}
    		
    	}
    	
    }
    	    
  }
		
 }
