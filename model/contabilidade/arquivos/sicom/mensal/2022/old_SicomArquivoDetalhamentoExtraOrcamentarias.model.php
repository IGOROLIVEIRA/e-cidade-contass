<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

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
    
    $aElementos[10] = array(
    						 "tipoRegistro",
			                 "codReduzidoEO",
    						 "codOrgao",
    			 			 "codUnidadeSub",
			                 "categoria",
			                 "tipoLancamento",
			                 "subTipo",
							 "desdobraSubTipo",
							 "dtLancamento",
							 "descExtraOrc",
							 "vlLancamento"
                        );
    $aElementos[11] = array(
    						 "tipoRegistro",
			                 "codReduzidoEO",
    						 "codFontRecursos",
    						 "valorFonte"
                        );
    $aElementos[12] = array(
    						 "tipoRegistro",
			                 "codReduzidoEO",
    						 "codReduzidoOP",
    						 "nroOP",
			                 "dtPagamento",
			                 "tipoDocumentoCredor",
			                 "nroDocumento",
							 "nomeCredor",
							 "vlOP",
							 "especificacaoOP",
							 "nomeRespPgto",
    						 "cpfRespPgto"
                        );
    $aElementos[13] = array(
    						 "tipoRegistro",
    						 "codReduzidoOP",
    						 "tipoDocumentoOP",
			                 "nroDocumento",
			                 "banco",
			                 "agencia",
							 "digitoVerificadorAgencia",
							 "contaCorrente",
							 "digitoVerificadorContaBancaria",
							 "dtEmissao",
    						 "vlDocumento"
                        );
    return $aElementos;
  }
  
  /**
   * selecionar os dados de //
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
    $sArquivo = "config/sicom/". db_getsession("DB_anousu")."/{$sCnpj}_sicomorgao.xml";
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
          
    	  $sOrgao         = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
          $aINSS          = explode(";", $oOrgao->getAttribute('ctINSS'));
          $aRPPS          = explode(";", $oOrgao->getAttribute('ctRPPS'));
          $aIRRF          = explode(";", $oOrgao->getAttribute('ctIRRF'));
          $aISSQN         = explode(";", $oOrgao->getAttribute('ctISSQN'));  
          $aRepasseCamara = explode(";", $oOrgao->getAttribute('ctRepasseCamara'));
          $cpfG			  = $oOrgao->getAttribute('cpfOrdPag');
          
    	}
    	
    }
    
    if (!isset($oOrgao)) {
      throw new Exception("Arquivo sem configuração de Orgãos.");
    }
    
    //Primeiro Reg 10
    
    $sSql = "select k17_codigo, k17_dtaut, k17_valor, c60_estrut,k153_slipoperacaotipo,k17_debito,k17_credito,k17_texto
  			  from  slip  
			  join sliptipooperacaovinculo on k17_codigo = k153_slip and k153_slipoperacaotipo in (13,1)
			  join conplanoreduz on k17_debito = c61_reduz and c61_anousu = '". db_getsession("DB_anousu")."'
			  join conplano on c61_codcon = c60_codcon and c60_anousu = c61_anousu
			  where k17_dtanu between '". $this->sDataInicial."' and '". $this->sDataFinal."' ";
    
	$rsReceitasDesp = db_query($sSql);
	
	$aDadosAgrupados = array();
	
	for ($iCont = 0;$iCont < pg_num_rows($rsReceitasDesp); $iCont++) {
		
		$oReceitasDesp = db_utils::fieldsMemory($rsReceitasDesp,$iCont);
	
   	  	$sTipoLancamento  = "99";
   	  	$sSubTipo         = $oReceitasDesp->k17_debito;
   	  	$sDesdobraSubTipo = " ";
   	  	
   	  	if ($oReceitasDesp->k153_slipoperacaotipo == "13") {
   	  		
   	  		$sTipoLancamento = "01";
   	  		/**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aINSS as $iINSS) {
   	  			
   	  			if ($oReceitasDesp->k17_debito == $iINSS) {
   	  				
   	  				$sSubTipo         = "0001";
   	  				$sDesdobraSubTipo = "0001";
   	  				break;
   	  				
   	  			}
   	  			
   	  		}
   	  	  /**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aRPPS as $iRPPS) {
   	  			
   	  			if ($oReceitasDesp->k17_debito == $iRPPS) {
   	  				
   	  				$sSubTipo         = "0002";
   	  				$sDesdobraSubTipo = "0002";
   	  				break;
   	  				
   	  			}
   	  			
   	  		}
   	  	  /**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aIRRF as $iIRRF) {
   	  			
   	  			if ($oReceitasDesp->k17_debito == $iIRRF) {
   	  				
   	  				$sSubTipo         = "0003";
   	  				$sDesdobraSubTipo = "0003";
   	  				break;
   	  				
   	  			}
   	  			
   	  		} 
   	  	  /**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aISSQN as $iISSQN) {
   	  			
   	  			if ($oReceitasDesp->k17_debito == $iISSQN) {
   	  				
   	  				$sSubTipo         = "0004";
   	  				$sDesdobraSubTipo = "0004";
   	  				break;
   	  				
   	  			}
   	  			
   	  		} 	
   	  		  		
   	  	} else {
   	  		
   	  	  if (substr($oReceitasDesp->c60_estrut, 0, 3) == "112") {
   	  		  
   	  	  	$sTipoLancamento = "03";
   	  		  $sSubTipo = $oReceitasDesp->k17_debito;
   	  		     	  		
   	  	  } else {
   	  	  	
   	  	    if (substr($oReceitasDesp->c60_estrut, 0, 7) == "3510201") {
   	  		    
   	  	    	$sTipoLancamento = "04";
   	  	    	/**
   	  		     * percorrer array de conta
   	  		     */
   	  		    foreach ($aRepasseCamara as $iRepasseCamara) {
   	  			
   	  			    if ($oReceitasDesp->k17_debito == $iRepasseCamara) {
   	  				
   	  				    $sSubTipo         = "0002";
   	  				    $sDesdobraSubTipo = "0002";
   	  				    break;
   	  				
   	  			   } else {
   	  			     $sDesdobraSubTipo = $oReceitasDesp->k17_debito;
   	  			   }
   	  			
   	  		    }   
   	  		    	  		
   	  	    } else {
   	  	  	
   	  	    if (substr($oReceitasDesp->k153_slipoperacaotipo,0,1) == "1") {
   	  		    
   	  	    	$sTipoLancamento = "04";
   	  	    	/**
   	  		     * percorrer array de conta
   	  		     */
   	  		    foreach ($aRepasseCamara as $iRepasseCamara) {
   	  			
   	  			    if ($oReceitasDesp->k17_debito == $iRepasseCamara) {
   	  				
   	  				    $sSubTipo         = "0002";
   	  				    $sDesdobraSubTipo = "0002";
   	  				    break;
   	  				
   	  			   } else {
   	  			     $sDesdobraSubTipo = $oReceitasDesp->k17_debito;
   	  			   }
   	  			
   	  		    }   
   	  		    	  		
   	  	    }
   	  	  	
   	  	  } 
   	  	  	
   	  	  } 
   	  		
   	  	}
		
		$sHash  = $sOrgao."2".$sTipoLancamento.$sSubTipo.$desdobraSubTipo;
		$sHash .= implode(array_reverse(explode("-", $oReceitasDesp->k17_dtaut)));
		
		if (!isset($aDadosAgrupados[$sHash])) {
		
		  $oDadosReceitasDesp = new stdClass();
		
		  $oDadosReceitasDesp->tipoRegistro                    = 10;
		  $oDadosReceitasDesp->detalhesessao                   = 10;
		  $oDadosReceitasDesp->codReduzidoEO                   = $oReceitasDesp->k17_codigo.substr($oReceitasDesp->k17_data, 0, 4);
   	      $oDadosReceitasDesp->codOrgao                        = $sOrgao;
   	      $oDadosReceitasDesp->codUnidadeSub                   = " ";
   	      $oDadosReceitasDesp->categoria                       = 2;
		  $oDadosReceitasDesp->tipoLancamento                  = $sTipoLancamento;
		  $oDadosReceitasDesp->subTipo		                   = $sSubTipo; 
		  $oDadosReceitasDesp->desdobraSubTipo                 = $sDesdobraSubTipo;
		  $oDadosReceitasDesp->dtLancamento                    = implode(array_reverse(explode("-", $oReceitasDesp->k17_dtaut)));
		  $oDadosReceitasDesp->descExtraOrc                    = $oReceitasDesp->k17_texto;
		  $oDadosReceitasDesp->vlLancamento                    = $oReceitasDesp->k17_valor;
		  $oDadosReceitasDesp->Reg11 = array(); 
          $oDadosReceitasDesp->Reg12 = array();
          $oDadosReceitasDesp->Reg13 = array();
		
          $aDadosAgrupados[$sHash] = $oDadosReceitasDesp; 
		
		}else {
   	  		$aDadosAgrupados[$sHash]->vlLancamento += $oReceitasDesp->k17_valor;
   	  	}
   	  	
		// REG 11
   	  	
   	  	$sSql11 = "SELECT o15_codtri
                             from conplano 
	                      join conplanoreduz on c61_codcon = c60_codcon and c61_anousu = c60_anousu
                                  join orctiporec on c61_codigo = o15_codigo
	                 where c61_reduz = '".$oReceitasDesp->k17_credito."' and c60_anousu = '". db_getsession("DB_anousu") ."' ";
      	
	    $rsDetalhaFonte = db_query($sSql11);
	    
	    for ($iCont2 = 0;$iCont2 < pg_num_rows($rsDetalhaFonte); $iCont2++) {
		
		  $oDetalhaFonte = db_utils::fieldsMemory($rsDetalhaFonte,$iCont2);
   	  	
		  	$codReduzidoEO = $oReceitasDesp->k17_codigo.substr($oReceitasDesp->k17_data, 0, 4);
		  
		  	//HASH REG 11
			$sHasReg11  = $sOrgao.$codReduzidoEO.$oDetalhaFonte->o15_codtri;
	   	  	
	   	  	if (!isset($aDadosAgrupados[$sHash]->Reg11[$sHasReg11])) {
	 	
		   	    $oDadosDetalhaFonte = new stdClass();
		   	  	
		   	    $oDadosDetalhaFonte->tipoRegistro                    = 11;
		   	    $oDadosDetalhaFonte->detalhesessao                   = 11;
		        $oDadosDetalhaFonte->codReduzidoEO                   = $codReduzidoEO;
		   	    $oDadosDetalhaFonte->codFontRecursos                 = $oDetalhaFonte->o15_codtri;
			    $oDadosDetalhaFonte->valorFonte                      = $oReceitasDesp->k17_valor;
		    
			    $aDadosAgrupados[$sHash]->Reg11[$sHasReg11] = $oDadosDetalhaFonte;
	      
	   	  	} else {
	   	  		$aDadosAgrupados[$sHash]->Reg11[$sHasReg11]->valorFonte += $oReceitasDesp->k17_valor;
	   	  	}
   	  	
	    }
	    
	    // REG 12
	    
	    $sSql12 = "select sp.k17_codigo, sp.k17_dtanu, sp.k17_valor, k18_motivo,c60_estrut,k153_slipoperacaotipo,sp.k17_debito,sp.k17_credito,sp.k17_dtaut ,z01_cgccpf,z01_nome
					  from slipanul 
					  join slip sp on sp.k17_codigo = k18_codigo 
					  join sliptipooperacaovinculo on sp.k17_codigo = k153_slip and k153_slipoperacaotipo in (13,1) 
					  join conplanoreduz on sp.k17_debito = c61_reduz and c61_anousu = 2013 
					  join conplano on c61_codcon = c60_codcon and c60_anousu = c61_anousu 
					  join slipnum s on s.k17_codigo = sp.k17_codigo join cgm on z01_numcgm = s.k17_numcgm 
					 where sp.k17_codigo = '". $oReceitasDesp->k17_codigo. "' ";
    
	    $rsDetalhaPag = db_query($sSql12);
	    
	    for ($iCont3 = 0;$iCont3 < pg_num_rows($rsDetalhaPag); $iCont3++) {
		
		  $oDetalhaPag = db_utils::fieldsMemory($rsDetalhaPag,$iCont3);
   	  	
		  
		  	if ( strlen($oDetalhaPag->z01_cgccpf) == '11' ) {
		  	  $tipoDocumentoCredor = 1;	
		  	}else{
		  	  $tipoDocumentoCredor = 2;
		  	}
		  
		  	$codReduzidoEO = $oDetalhaPag->k17_codigo.substr($oDetalhaPag->k17_data, 0, 4);
		  	$nroOP 		   = $oDetalhaPag->k17_codigo.substr($oDetalhaPag->k17_data, 0, 4);
		  	$dtPagamento   = implode(array_reverse(explode("-", $oDetalhaPag->k17_dtaut)));
		  	$nroAnulacaoOP = $oDetalhaPag->k17_codigo.substr($oDetalhaPag->k17_data, 0, 4);
		  	
		  	//HASH REG 12
			$sHasReg12  = $codReduzidoEO.$nroOP.$dtPagamento.$nroAnulacaoOP;
			
			$sSqlCgm = "select z01_nome from cgm where z01_cgccpf = '". $cpfG ."'";
			$rsNomeRespPgto = db_query($sSqlCgm);
	   	  	$oNomeRespPgto = db_utils::fieldsMemory($rsNomeRespPgto,0);
			
	   	  	if (!isset($aDadosAgrupados[$sHash]->Reg12[$sHasReg12])) {
	 	
		   	    $oDadosDetalhaPag = new stdClass();
		   	  	
		   	    $oDadosDetalhaPag->tipoRegistro                    = 12;
		   	    $oDadosDetalhaPag->detalhesessao                   = 12;
		        $oDadosDetalhaPag->codReduzidoEO                   = $codReduzidoEO;
		        $oDadosDetalhaPag->codReduzidoOP                   = " ";	
		   	    $oDadosDetalhaPag->nroOP                           = $nroOP;
			    $oDadosDetalhaPag->dtPagamento                     = $dtPagamento;
			    //$oDadosDetalhaPag->nroAnulacaoOP                   = $nroAnulacaoOP;
			    //$oDadosDetalhaPag->dtAnulacaoOP                    = implode(array_reverse(explode("-", $oDetalhaPag->k17_dtanu)));
			    $oDadosDetalhaPag->tipoDocumentoCredor             = $tipoDocumentoCredor;
			    $oDadosDetalhaPag->nroDocumento                    = $oDetalhaPag->z01_cgccpf;
			    $oDadosDetalhaPag->nomeCredor                      = $oDetalhaPag->z01_nome;
			    $oDadosDetalhaPag->vlOP                            = $oDetalhaPag->k17_valor;
			    $oDadosDetalhaPag->especificacaoOP                 = $oDetalhaPag->k17_texto;
			    $oDadosDetalhaPag->nomeRespPgto                    = $oNomeRespPgto->z01_nome;
			    $oDadosDetalhaPag->cpfRespPgto                     = $cpfG;
		    
			    $aDadosAgrupados[$sHash]->Reg12[$sHasReg12] = $oDadosDetalhaPag;
	      
	   	  	} else {
	   	  		$aDadosAgrupados[$sHash]->Reg12[$sHasReg12]->vlOP += $oReceitasDesp->k17_valor;
	   	  	}
   	  	
	    }
	    
	    // REG 13
	    
	    $sSql13 = "SELECT k17_codigo,k17_data,c63_banco,c63_agencia,c63_dvagencia,c63_conta,c63_dvconta,k12_id, e96_codigo
		from slip
		     join conplanoreduz on c61_reduz = k17_credito
		     join conplano on c61_codcon = c60_codcon and c61_anousu = c60_anousu
		     join conplanoconta on c63_codcon = c60_codcon and c60_anousu = c63_anousu
		     join corrente on k12_conta = k12_conta and slip.k17_dtaut = k12_data and slip.k17_autent = k12_autent and k12_valor = k17_valor
		     join empageslip on e89_codigo = k17_codigo
		     join empagemovforma on e97_codmov = e89_codmov
		     join empageforma on e97_codforma = e96_codigo
	where k17_codigo = '". $oReceitasDesp->k17_codigo ."' and c60_anousu = '".db_getsession("DB_anousu") . "' ";
        
	    $rsMovFinanceira = db_query($sSql13);
	    
	    for ($iCont4 = 0;$iCont4 < pg_num_rows($rsMovFinanceira); $iCont4++) {
		
		  $oMovFinanceira = db_utils::fieldsMemory($rsMovFinanceira,$iCont4);
   	  	
		  
		  	if ( $oMovFinanceira->e96_codigo == '2' ) {
		  	  $tipoDocumentoOP = 01;
		  	  $nroDocumento = $oMovFinanceira->k12_cheque;	
		  	}
	    	if ( $oMovFinanceira->e96_codigo == '1' ) {
		  	  $tipoDocumentoOP = 05;	
		  	}
		  
		  	if ( $oMovFinanceira->e96_codigo != '2' ) {
		      $nroDocumento = " ";
		  	}
		  	
		  	$codReduzidoEO = $oMovFinanceira->k17_codigo.substr($oMovFinanceira->k17_data, 0, 4);
		  	
		  	//HASH REG 13
			$sHasReg13  = $codReduzidoEO;
	   	  	
	   	  	if (!isset($aDadosAgrupados[$sHash]->Reg13[$sHasReg13])) {
	 	
		   	    $oDadosMovFinanceira = new stdClass();
		   	  	
		   	    $oDadosMovFinanceira->tipoRegistro                    = 13;
		   	    $oDadosMovFinanceira->detalhesessao                   = 13;
		        $oDadosMovFinanceira->codReduzidoEO                   = $codReduzidoEO;
		   	    $oDadosMovFinanceira->tipoDocumentoOP                 = $tipoDocumentoOP;
			    $oDadosMovFinanceira->nroDocumento                    = $nroDocumento;
			    $oDadosMovFinanceira->banco                   		  = $oMovFinanceira->c63_banco;
			    $oDadosMovFinanceira->agencia	                      = $oMovFinanceira->c63_agencia;
			    $oDadosMovFinanceira->digitoVerificadorAgencia        = $oMovFinanceira->c63_dvagencia;
			    $oDadosMovFinanceira->contaCorrente                   = $oMovFinanceira->c63_conta;
			    $oDadosMovFinanceira->digitoVerificadorContaBancaria  = $oMovFinanceira->c63_dvconta;
			    $oDadosMovFinanceira->dtEmissao                       = implode(array_reverse(explode("-", $oMovFinanceira->k17_data)));
			    $oDadosMovFinanceira->vlDocumento	                  = $oDetalhaPag->k17_valor;
		    
			    $aDadosAgrupados[$sHash]->Reg13[$sHasReg13] = $oDadosMovFinanceira;
	      
	   	  	} else {
	   	  		$aDadosAgrupados[$sHash]->Reg12[$sHasReg12]->valorFonte += $oReceitasDesp->k17_valor;
	   	  	}
   	  	
	    }
	 
	}
	
	
	//Segundo Reg 10
	
	$sSql2 = "select * from 
	(select g.k02_codigo, g.k02_tipo, g.k02_drecei, 
		case when o.k02_codrec is not null then o.k02_codrec 
			else p.k02_reduz end as codrec, 
		case when p.k02_codigo is null then o.k02_estorc 
			else p.k02_estpla end as estrutural, k12_histcor as k00_histtxt,
			 f.k12_data, f.k12_numpre, f.k12_numpar, c61_reduz, c60_descr, 
			 round(case when r.k12_estorn = 'f' then f.k12_valor else f.k12_valor end,2) as valor 
	from cornump f 
		inner join corrente r on r.k12_id = f.k12_id
			and r.k12_data = f.k12_data 
			and r.k12_autent = f.k12_autent 
                                    and r.k12_estorn = 't'
		inner join conplanoreduz c1 on r.k12_conta = c1.c61_reduz 
			and c1.c61_anousu = extract (year from r.k12_data) 
		inner join conplano on c1.c61_codcon = c60_codcon 
			and c60_anousu = extract (year from r.k12_data) 
		inner join tabrec g on g.k02_codigo = f.k12_receit 
		left outer join taborc o on o.k02_codigo = g.k02_codigo 
			and o.k02_anousu = extract (year from r.k12_data) 
		left outer join tabplan p on p.k02_codigo = g.k02_codigo 
			and p.k02_anousu = extract (year from r.k12_data) 
		left join corhist hist on hist.k12_id = f.k12_id 
			and hist.k12_data = f.k12_data 
			and hist.k12_autent = f.k12_autent 
		where f.k12_data between '". $this->sDataInicial ."' 
			and '". $this->sDataFinal ."'
			and r.k12_instit = '". db_getsession("DB_instit") ."' order by g.k02_tipo desc ,g.k02_codigo ) 
			as xxx 
	where 1=1 order by k02_tipo, k02_codigo ,k12_data";
	
	$rsReceitasDesp2 = db_query($sSql2);
	
	for ($iCont = 0;$iCont < pg_num_rows($rsReceitasDesp2); $iCont++) {
		
	  $oReceitasDesp2 = db_utils::fieldsMemory($rsReceitasDesp2,$iCont);
	  
	  
	if ( $oReceitasDesp2->k02_tipo == 'E' ) {

        $sTipoLancamento  = "99";
        
        $sSqlSubTipo = "SELECT c61_reduz
                             from conplano 
	                      join conplanoreduz on c61_codcon = c60_codcon and c61_anousu = c60_anousu
	                 where c60_estrut = '".$oReceitasDesp2->estrutural."' and c60_anousu = '".db_getsession("DB_anousu") ."' ";
        
        
   	    $rsSubTipo = db_query($sSqlSubTipo);
   	    $oSubTipo = db_utils::fieldsMemory($rsSubTipo, 0);
   	    
   	    $sSubTipo = $oSubTipo->c61_reduz;
   	    $sDesdobraSubTipo = " ";
   	  	
   	  	if (substr($oReceitasDesp2->estrutural, 0, 4) == "2188101") {
   	  		
   	  		$sTipoLancamento = "01";
   	  		/**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aINSS as $iINSS) {
   	  			
   	  			if ($oSubTipo->c61_reduz == $iINSS) {
   	  				
   	  				$sSubTipo         = "0001";
   	  				$sDesdobraSubTipo = "0001";
   	  				break;
   	  				
   	  			}
   	  			
   	  		}
   	  	  /**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aRPPS as $iRPPS) {
   	  			
   	  			if ($oSubTipo->c61_reduz == $iRPPS) {
   	  				
   	  				$sSubTipo         = "0002";
   	  				$sDesdobraSubTipo = "0002";
   	  				break;
   	  				
   	  			}
   	  			
   	  		}
   	  	  /**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aIRRF as $iIRRF) {
   	  			
   	  			if ($oSubTipo->c61_reduz == $iIRRF) {
   	  				
   	  				$sSubTipo         = "0003";
   	  				$sDesdobraSubTipo = "0003";
   	  				break;
   	  				
   	  			}
   	  			
   	  		} 
   	  	  /**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aISSQN as $iISSQN) {
   	  			
   	  			if ($oSubTipo->c61_reduz == $iISSQN) {
   	  				
   	  				$sSubTipo         = "0004";
   	  				$sDesdobraSubTipo = "0004";
   	  				break;
   	  				
   	  			}
   	  			
   	  		} 	
   	  		  		
   	  	} else {
   	  		
   	  	  if (substr($oReceitasDesp2->estrutural, 0, 3) == "112") {
   	  		  
   	  	  	$sTipoLancamento = "03";
   	  	  	
   	  	  	$sSubTipo = $oSubTipo->c61_reduz;
   	  		     	  		
   	  	  } else {
   	  	  	
   	  	    if (substr($oReceitasDesp2->estrutural, 0, 4) == "45") {
   	  		    
   	  	    	$sTipoLancamento = "04";
   	  	    	/**
   	  		     * percorrer array de conta
   	  		     */
   	  		    foreach ($aRepasseCamara as $iRepasseCamara) {
   	  			
   	  			    if ($oSubTipo->c61_reduz == $iRepasseCamara) {
   	  				
   	  				    $sSubTipo         = "0001";
   	  				    $sDesdobraSubTipo = "0001";
   	  				    break;
   	  				
   	  			   } else {
   	  			   	  $sSubTipo        = $oSubTipo->c61_reduz;
   	  			     $sDesdobraSubTipo = $oSubTipo->c61_reduz;
   	  			   }
   	  			
   	  		    }   
   	  		    	  		
   	  	    }
   	  	  	
   	  	  }
   	  		
   	  	}
      	
   	  	$sHash  = $sOrgao."1".$sTipoLancamento.$sSubTipo.$desdobraSubTipo;
		$sHash .= implode(array_reverse(explode("-", $oReceitasDesp2->k12_data)));
   	  	
   	  	if (!isset($aDadosAgrupados[$sHash])) {
 
   	  	    if ($sTipoLancamento == "99") {
   	  			$sDescExtraOrc = "Diversos";
   	  		} else {
   	  			$sDescExtraOrc = substr($oReceitasDesp2->k02_drecei, 0, 50);
   	  		}
   	  		
	   	    $oDadosReceitasDesp2 = new stdClass();
	   	  	
	   	    $oDadosReceitasDesp2->tipoRegistro                    = 10;
	   	    $oDadosReceitasDesp2->detalhesessao                   = 10;
	   	    $oDadosReceitasDesp2->codReduzidoEO					  = $oReceitasDesp2->codrec.$oReceitasDesp2->k02_codigo.$oReceitasDesp2->k12_numpre;
	        $oDadosReceitasDesp2->codOrgao                        = $sOrgao;
	   	    $oDadosReceitasDesp2->categoria                       = 1;
		    $oDadosReceitasDesp2->tipoLancamento                  = $sTipoLancamento;
		    $oDadosReceitasDesp2->subTipo		                  = $sSubTipo; 
		    $oDadosReceitasDesp2->desdobraSubTipo                 = $sDesdobraSubTipo;
		    $oDadosReceitasDesp2->dtLancamento                    = implode(array_reverse(explode("-", $oReceitasDesp2->k12_data)));
		    $oDadosReceitasDesp2->descExtraOrc                    = $sDescExtraOrc;
		    $oDadosReceitasDesp2->vlLancamento                    = $oReceitasDesp2->valor;
	        $oDadosReceitasDesp2->aReg11 = array();
	        
            $aDadosAgrupados[$sHash] = $oDadosReceitasDesp2;
      
   	  	} else {
   	  		$aDadosAgrupados[$sHash]->vlLancamento += $oReceitasDesp2->valor;
   	  	}
   	  
	   // REG 11
   	  	
   	  	$sSql11 = "SELECT o15_codtri
                             from conplano 
	                      join conplanoreduz on c61_codcon = c60_codcon and c61_anousu = c60_anousu
                                  join orctiporec on c61_codigo = o15_codigo
	                 where c61_reduz = '". $sSubTipo ."' and c60_anousu = '". db_getsession("DB_anousu") ."'";
    
	    $rsDetalhaFonte2 = db_query($sSql11);
	    
	    for ($iCont2 = 0;$iCont2 < pg_num_rows($rsDetalhaFonte2); $iCont2++) {
		
		  $oDetalhaFonte2 = db_utils::fieldsMemory($rsDetalhaFonte2,$iCont2);
   	  	
		  	$codReduzidoEO = $oReceitasDesp2->codrec.$oReceitasDesp2->k02_codigo.$oReceitasDesp2->k12_numpre;
		  
		  	//HASH REG 11
			$sHasReg11  = $sOrgao.$codReduzidoEO.$oDetalhaFonte->o15_codtri;
	   	  	
	   	  	if (!isset($aDadosAgrupados[$sHash]->Reg11[$sHasReg11])) {
	 	
		   	    $oDadosDetalhaFonte2 = new stdClass();
		   	  	
		   	    $oDadosDetalhaFonte2->tipoRegistro                    = 11;
		   	    $oDadosDetalhaFonte2->detalhesessao                   = 11;
		        $oDadosDetalhaFonte2->codReduzidoEO                   = $codReduzidoEO;
		   	    $oDadosDetalhaFonte2->codFontRecursos                 = $oDetalhaFonte2->o15_codtri;
			    $oDadosDetalhaFonte2->valorFonte                      = $oReceitasDesp2->valor;
		    
			    $aDadosAgrupados[$sHash]->Reg11[$sHasReg11] = $oDadosDetalhaFonte2;
	      
	   	  	} else {
	   	  		$aDadosAgrupados[$sHash]->Reg11[$sHasReg11]->valorFonte += $oReceitasDesp2->valor;
	   	  	}
   	  	
	    }
	    
	  }
        
    }
    
    //Terceiro Reg 10
    
  $sSql3 = "select k17_codigo, k17_dtanu, k17_valor,c60_estrut,k153_slipoperacaotipo,k17_debito
  from  slip 
  join sliptipooperacaovinculo on k17_codigo = k153_slip and k153_slipoperacaotipo in (3,11)
  join conplanoreduz on k17_debito = c61_reduz and c61_anousu = '". db_getsession("DB_anousu") ."'
  join conplano on c61_codcon = c60_codcon and c60_anousu = c61_anousu
 where k17_dtanu between '". $this->sDataInicial ."' and '".$this->sDataFinal. "'";
	
	
	$rsReceitasDesp3 = db_query($sSql3);
	
	for ($iCont = 0;$iCont < pg_num_rows($rsReceitasDesp3); $iCont++) {
		
	    $oReceitasDesp3 = db_utils::fieldsMemory($rsReceitasDesp3,$iCont);
	
	  if ($oReceitasDesp3->k153_slipoperacaotipo == "13") {
   	  		
   	  		$sTipoLancamento = "01";
   	  		/**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aINSS as $iINSS) {
   	  			
   	  			if ($oReceitasDesp3->k17_debito == $iINSS) {
   	  				
   	  				$sSubTipo         = "0001";
   	  				$sDesdobraSubTipo = "0001";
   	  				break;
   	  				
   	  			}
   	  			
   	  		}
   	  	  /**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aRPPS as $iRPPS) {
   	  			
   	  			if ($oReceitasDesp3->k17_debito == $iRPPS) {
   	  				
   	  				$sSubTipo         = "0002";
   	  				$sDesdobraSubTipo = "0002";
   	  				break;
   	  				
   	  			}
   	  			
   	  		}
   	  	  /**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aIRRF as $iIRRF) {
   	  			
   	  			if ($oReceitasDesp3->k17_debito == $iIRRF) {
   	  				
   	  				$sSubTipo         = "0003";
   	  				$sDesdobraSubTipo = "0003";
   	  				break;
   	  				
   	  			}
   	  			
   	  		} 
   	  	  /**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aISSQN as $iISSQN) {
   	  			
   	  			if ($oReceitasDesp3->k17_debito == $iISSQN) {
   	  				
   	  				$sSubTipo         = "0004";
   	  				$sDesdobraSubTipo = "0004";
   	  				break;
   	  				
   	  			}
   	  			
   	  		} 	
   	  		  		
   	  	} else {
   	  		
   	  	  if (substr($oReceitasDesp3->c60_estrut, 0, 3) == "112") {
   	  		  
   	  	  	$sTipoLancamento = "03";
   	  		  $sSubTipo = $oReceitasDesp3->k17_debito;
   	  		     	  		
   	  	  } else {
   	  	  	
   	  	    if (substr($oReceitasDesp3->c60_estrut, 0, 7) == "3510201") {
   	  		    
   	  	    	$sTipoLancamento = "04";
   	  	    	/**
   	  		     * percorrer array de conta
   	  		     */
   	  		    foreach ($aRepasseCamara as $iRepasseCamara) {
   	  			
   	  			    if ($oReceitasDesp3->k17_debito == $iRepasseCamara) {
   	  				
   	  				    $sSubTipo         = "0002";
   	  				    $sDesdobraSubTipo = "0002";
   	  				    break;
   	  				
   	  			   } else {
   	  			     $sDesdobraSubTipo = $oReceitasDesp3->k17_debito;
   	  			   }
   	  			
   	  		    }   
   	  		    	  		
   	  	    } else {
   	  	  	
   	  	    if (substr($oReceitasDesp3->k153_slipoperacaotipo,0,1) == "1") {
   	  		    
   	  	    	$sTipoLancamento = "04";
   	  	    	/**
   	  		     * percorrer array de conta
   	  		     */
   	  		    foreach ($aRepasseCamara as $iRepasseCamara) {
   	  			
   	  			    if ($oReceitasDesp3->k17_debito == $iRepasseCamara) {
   	  				
   	  				    $sSubTipo         = "0002";
   	  				    $sDesdobraSubTipo = "0002";
   	  				    break;
   	  				
   	  			   } else {
   	  			     $sDesdobraSubTipo = $oReceitasDesp3->k17_debito;
   	  			   }
   	  			
   	  		    }   
   	  		    	  		
   	  	    }
   	  	  	
   	  	  } 
   	  	  	
   	  	  } 
   	  		
   	  	}
      	
   	  	$sHash  = $sOrgao."1".$sTipoLancamento.$sSubTipo.$desdobraSubTipo;
		$sHash .= implode(array_reverse(explode("-", $oReceitasDesp3->k17_dtanu)));
   	  	
   	  	if (!isset($aDadosAgrupados[$sHash])) {
 
   	  	    if ($sTipoLancamento == "99") {
   	  			$sDescExtraOrc = "Diversos";
   	  		} else {
   	  			$sDescExtraOrc = substr($oReceitasDesp3->k18_motivo, 0, 50);
   	  		}
   	  		
	   	    $oDadosReceitasDesp3 = new stdClass();
	   	  	
	   	    $oDadosReceitasDesp3->tipoRegistro                    = 10;
	   	    $oDadosReceitasDesp3->detalhesessao                   = 10;
	   	    $oDadosReceitasDesp3->codReduzidoEO					  = $oReceitasDesp3->k17_codigo.substr($oReceitasDesp3->k17_data, 0, 4);
	        $oDadosReceitasDesp3->codOrgao                        = $sOrgao;
	   	    $oDadosReceitasDesp3->categoria                       = 1;
		    $oDadosReceitasDesp3->tipoLancamento                  = $sTipoLancamento;
		    $oDadosReceitasDesp3->subTipo		                  = $sSubTipo; 
		    $oDadosReceitasDesp3->desdobraSubTipo                 = $sDesdobraSubTipo;
		    $oDadosReceitasDesp3->dtLancamento                    = implode(array_reverse(explode("-", $oReceitasDesp3->k17_dtanu)));
		    $oDadosReceitasDesp3->descExtraOrc                    = $sDescExtraOrc;
		    $oDadosReceitasDesp3->vlLancamento                    = $oReceitasDesp3->k17_valor;
	        $oDadosReceitasDesp3->aReg11 = array();
	        
            $aDadosAgrupados[$sHash] = $oDadosReceitasDesp3;
      
   	  	} else {
   	  		$aDadosAgrupados[$sHash]->vlLancamento += $oReceitasDesp3->valor;
   	  	}
   	  	
		// REG 11
   	  	
   	  	$sSql11 = "SELECT o15_codtri
                             from conplano 
	                      join conplanoreduz on c61_codcon = c60_codcon and c61_anousu = c60_anousu
                                  join orctiporec on c61_codigo = o15_codigo
	                 where c61_reduz = '".$oReceitasDesp3->k17_debito."' and c60_anousu = '". db_getsession("DB_anousu")."'";
    	
	    $rsDetalhaFonte = db_query($sSql11);
	    
	    for ($iCont2 = 0;$iCont2 < pg_num_rows($rsDetalhaFonte); $iCont2++) {
		
		  $oDetalhaFonte = db_utils::fieldsMemory($rsDetalhaFonte,$iCont2);
   	  	
		  	$codReduzidoEO = $oReceitasDesp3->k17_codigo.substr($oReceitasDesp3->k17_data, 0, 4);
		  
		  	//HASH REG 11
			$sHasReg11  = $sOrgao.$codReduzidoEO.$oDetalhaFonte->o15_codtri;
	   	  	
	   	  	if (!isset($aDadosAgrupados[$sHash]->Reg11[$sHasReg11])) {
	 	
		   	    $oDadosDetalhaFonte3 = new stdClass();
		   	  	
		   	    $oDadosDetalhaFonte3->tipoRegistro                    = 11;
		   	    $oDadosDetalhaFonte3->detalhesessao                   = 11;
		        $oDadosDetalhaFonte3->codReduzidoEO                   = $codReduzidoEO;
		   	    $oDadosDetalhaFonte3->codFontRecursos                 = $oDetalhaFonte->o15_codtri;
			    $oDadosDetalhaFonte3->valorFonte                      = $oReceitasDesp3->k17_valor;
		    
			    $aDadosAgrupados[$sHash]->Reg11[$sHasReg11] = $oDadosDetalhaFonte3;
	      
	   	  	} else {
	   	  		$aDadosAgrupados[$sHash]->Reg11[$sHasReg11]->valorFonte += $oReceitasDesp3->k17_valor;
	   	  	}
   	  	
	    }
   	  	
    }
    
      /**
     * passar os valores agrupados para o array de dados
     */
    foreach ($aDadosAgrupados as $oDadosAgrupados2) {
    	
    	$aDadosClone = clone $oDadosAgrupados2;
    	unset($aDadosClone->Reg11);
    	unset($aDadosClone->Reg12);
    	unset($aDadosClone->Reg13);
    	
    	$aDadosClone->vlLancamento = number_format(abs($aDadosClone->vlLancamento), 2, "", "");
    	
    	$this->aDados[] = $aDadosClone;
    	
    	foreach ($oDadosAgrupados2->Reg11 as $oDados) {
    		
    	 	$oDados->valorFonte = number_format(abs($oDados->valorFonte), 2, "", "");
    	 	
    	 	$this->aDados[] = $oDados;
    	 	
    	}
    	
    	foreach ($oDadosAgrupados2->Reg12 as $oDados2) {
    	 	
    	 	$oDados2->vlOP = number_format($oDados2->vlOP, 2, "", "");
    	 	
    	 	$this->aDados[] = $oDados2;
    	 	
    	}
    	
    	foreach ($oDadosAgrupados2->Reg13 as $oDados3) {
    	 	
    	 	$oDados3->vlDocumento = number_format($oDados3->vlDocumento, 2, "", "");
    	 	
    	 	$this->aDados[] = $oDados3;
    	 	
    	}
    	
    	
    }
	
 }
		
}
