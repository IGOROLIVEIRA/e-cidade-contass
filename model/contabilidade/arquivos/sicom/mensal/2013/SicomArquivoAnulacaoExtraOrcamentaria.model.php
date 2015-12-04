<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * Anulacao Extra Orcamentaria Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoAnulacaoExtraOrcamentaria extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
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
    					  "justificativa",
    					  "vlAnulacao"
                        );
    $aElementos[11] = array(
                          "tipoRegistro",
                          "codReduzidoEO",
                          "codFontRecursos",
                          "valorAnulacaoFonte"
                        );
    $aElementos[12] = array(
                          "tipoRegistro",
                          "codReduzidoEO",
                          "nroOP",
                          "dtPagamento",
                          "nroAnulacaoOP",
						  "dtAnulacaoOP",
      					  "tipoDocumentoCredor",
      					  "nroDocumento",
      					  "nomeCredor",
      					  "vlAnulacaoOP"
                        );
    return $aElementos;
  }
  
  /**
   * selecionar os dados
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
          $cpfG			  = $oOrgao->getAttribute('cpfGestor');
          
    	}
    	
    }
    
    if (!isset($oOrgao)) {
      throw new Exception("Arquivo sem configuração de Orgãos.");
    }
    
    //Primeiro Reg 10
    
    $sSql = "select k17_codigo, k17_dtanu,k17_data, k17_valor, k18_motivo,c60_estrut,k153_slipoperacaotipo,k17_debito,k17_credito
			  from slipanul 
			  join slip on k17_codigo = k18_codigo 
			  join sliptipooperacaovinculo on k17_codigo = k153_slip and k153_slipoperacaotipo in (13,1)
			  join conplanoreduz on k17_debito = c61_reduz and c61_anousu = '". db_getsession("DB_anousu") ."'
			  join conplano on c61_codcon = c60_codcon and c60_anousu = c61_anousu
			 where k17_dtanu between '". $this->sDataInicial ."' and '". $this->sDataFinal."'";
    
	$rsAnulaExtra = db_query($sSql);
	
	$aDadosAgrupados = array();
	
	for ($iCont = 0;$iCont < pg_num_rows($rsAnulaExtra); $iCont++) {
		
		$oAnulaExtra = db_utils::fieldsMemory($rsAnulaExtra,$iCont);
	
   	  	$sTipoLancamento  = "99";
   	  	$sSubTipo         = $oAnulaExtra->k17_debito;
   	  	$sDesdobraSubTipo = " ";
   	  	
   	  	if ($oAnulaExtra->k153_slipoperacaotipo == "13") {
   	  		
   	  		$sTipoLancamento = "01";
   	  		/**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aINSS as $iINSS) {
   	  			
   	  			if ($oAnulaExtra->k17_debito == $iINSS) {
   	  				
   	  				$sSubTipo         = "0001";
   	  				$sDesdobraSubTipo = "0001";
   	  				break;
   	  				
   	  			}
   	  			
   	  		}
   	  	  /**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aRPPS as $iRPPS) {
   	  			
   	  			if ($oAnulaExtra->k17_debito == $iRPPS) {
   	  				
   	  				$sSubTipo         = "0002";
   	  				$sDesdobraSubTipo = "0002";
   	  				break;
   	  				
   	  			}
   	  			
   	  		}
   	  	  /**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aIRRF as $iIRRF) {
   	  			
   	  			if ($oAnulaExtra->k17_debito == $iIRRF) {
   	  				
   	  				$sSubTipo         = "0003";
   	  				$sDesdobraSubTipo = "0003";
   	  				break;
   	  				
   	  			}
   	  			
   	  		} 
   	  	  /**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aISSQN as $iISSQN) {
   	  			
   	  			if ($oAnulaExtra->k17_debito == $iISSQN) {
   	  				
   	  				$sSubTipo         = "0004";
   	  				$sDesdobraSubTipo = "0004";
   	  				break;
   	  				
   	  			}
   	  			
   	  		} 	
   	  		  		
   	  	} else {
   	  		
   	  	  if (substr($oAnulaExtra->c60_estrut, 0, 3) == "112") {
   	  		  
   	  	  	$sTipoLancamento = "03";
   	  		  $sSubTipo = $oAnulaExtra->k17_debito;
   	  		     	  		
   	  	  } else {
   	  	  	
   	  	    if (substr($oAnulaExtra->c60_estrut, 0, 7) == "3510201") {
   	  		    
   	  	    	$sTipoLancamento = "04";
   	  	    	/**
   	  		     * percorrer array de conta
   	  		     */
   	  		    foreach ($aRepasseCamara as $iRepasseCamara) {
   	  			
   	  			    if ($oAnulaExtra->k17_debito == $iRepasseCamara) {
   	  				
   	  				    $sSubTipo         = "0002";
   	  				    $sDesdobraSubTipo = "0002";
   	  				    break;
   	  				
   	  			   } else {
   	  			     $sDesdobraSubTipo = $oAnulaExtra->k17_debito;
   	  			   }
   	  			
   	  		    }   
   	  		    	  		
   	  	    } else {
   	  	  	
   	  	    if (substr($oAnulaExtra->k153_slipoperacaotipo,0,1) == "1") {
   	  		    
   	  	    	$sTipoLancamento = "04";
   	  	    	/**
   	  		     * percorrer array de conta
   	  		     */
   	  		    foreach ($aRepasseCamara as $iRepasseCamara) {
   	  			
   	  			    if ($oAnulaExtra->k17_debito == $iRepasseCamara) {
   	  				
   	  				    $sSubTipo         = "0002";
   	  				    $sDesdobraSubTipo = "0002";
   	  				    break;
   	  				
   	  			   } else {
   	  			     $sDesdobraSubTipo = $oAnulaExtra->k17_debito;
   	  			   }
   	  			
   	  		    }   
   	  		    	  		
   	  	    }
   	  	  	
   	  	  } 
   	  	  	
   	  	  } 
   	  		
   	  	}
		
   	//$sHash = $oAnulaExtra->k17_codigo.substr($oAnulaExtra->k17_data, 0, 4);
		$sHash  = $sOrgao."2".$sTipoLancamento.$sSubTipo.$desdobraSubTipo;
		$sHash .= implode(array_reverse(explode("-", $oAnulaExtra->k17_dtaut)));
		
		if (!isset($aDadosAgrupados[$sHash])) {
		
			$codUnidadeSub = " ";
		  $oDadosAnulaExtra = new stdClass();
		
		  $oDadosAnulaExtra->tipoRegistro                    = 10;
		  $oDadosAnulaExtra->detalhesessao                   = 10;
		  $oDadosAnulaExtra->codReduzidoEO                   = $oAnulaExtra->k17_codigo.substr($oAnulaExtra->k17_data, 0, 4);
   	  $oDadosAnulaExtra->codOrgao                        = $sOrgao;
   	  $oDadosAnulaExtra->codUnidadeSub                   = " ";
   	  $oDadosAnulaExtra->categoria                       = 2;
		  $oDadosAnulaExtra->tipoLancamento                  = $sTipoLancamento;
		  $oDadosAnulaExtra->subTipo		                     = $sSubTipo; 
		  $oDadosAnulaExtra->desdobraSubTipo                 = $sDesdobraSubTipo;
		  $oDadosAnulaExtra->dtLancamento                    = implode(array_reverse(explode("-", $oAnulaExtra->k17_dtanu)));
		  $oDadosAnulaExtra->justificativa                   = $oAnulaExtra->k18_motivo;
		  $oDadosAnulaExtra->vlAnulacao                      = $oAnulaExtra->k17_valor;
		  $oDadosAnulaExtra->Reg11 = array(); 
      $oDadosAnulaExtra->Reg12 = array();
		
    //  $aDadosAgrupados[$sHash] = $oDadosAnulaExtra; 
		
		}else {
   	 // 		$aDadosAgrupados[$sHash]->vlAnulacao += $oAnulaExtra->k17_valor;
   	  	}
   	
		// REG 11
   	  	
   	  	$sSql11 = "SELECT o15_codtri
                             from conplano 
	                      join conplanoreduz on c61_codcon = c60_codcon and c61_anousu = c60_anousu
                                  join orctiporec on c61_codigo = o15_codigo
	                 where c61_reduz = '".$oAnulaExtra->k17_credito."' and c60_anousu = '". db_getsession("DB_anousu") ."'";
    
	    $rsDetalhaFonte = db_query($sSql11);
	    
		for ($iCont2 = 0;$iCont2 < pg_num_rows($rsDetalhaFonte); $iCont2++) {
		
		  $oDetalhaFonte = db_utils::fieldsMemory($rsDetalhaFonte,$iCont2);
   	  	
		  	$codReduzidoEO = $oAnulaExtra->k17_codigo.substr($oAnulaExtra->k17_data, 0, 4);
		  
		  	//HASH REG 11
			$sHasReg11  = $sOrgao.$oDetalhaFonte->o15_codtri;
	   	  	
	   	  	if (!isset($aDadosAgrupados[$sHash]->Reg11[$sHasReg11])) {
	 	
		   	    $oDadosDetalhaFonte = new stdClass();
		   	  	
		   	    $oDadosDetalhaFonte->tipoRegistro                    = 11;
		   	    $oDadosDetalhaFonte->detalhesessao                   = 11;
		        $oDadosDetalhaFonte->codReduzidoEO                   = $aDadosAgrupados[$sHash]->codReduzidoEO;
		   	    $oDadosDetalhaFonte->codFontRecursos                 = $oDetalhaFonte->o15_codtri;
			    $oDadosDetalhaFonte->valorAnulacaoFonte              = $oAnulaExtra->k17_valor;
		    
			 //   $aDadosAgrupados[$sHash]->Reg11[$sHasReg11] = $oDadosDetalhaFonte;
	      
	   	  	} else {
	   	  //		$aDadosAgrupados[$sHash]->Reg11[$sHasReg11]->valorAnulacaoFonte += $oAnulaExtra->k17_valor;
	   	  	}
   	  	
	    }
	    
	    // REG 12
	    
	    $sSql12 = "select sp.k17_codigo, sp.k17_data , sp.k17_dtanu, sp.k17_valor, k18_motivo,c60_estrut,k153_slipoperacaotipo,sp.k17_debito,sp.k17_credito,sp.k17_dtaut ,z01_cgccpf,z01_nome
		  from slipanul 
		  join slip sp on sp.k17_codigo = k18_codigo 
		  join sliptipooperacaovinculo on sp.k17_codigo = k153_slip and k153_slipoperacaotipo in (13,1) 
		  join conplanoreduz on sp.k17_debito = c61_reduz and c61_anousu = 2013 
		  join conplano on c61_codcon = c60_codcon and c60_anousu = c61_anousu 
		  join slipnum s on s.k17_codigo = sp.k17_codigo join cgm on z01_numcgm = s.k17_numcgm 
		 where sp.k17_codigo = ". $oAnulaExtra->k17_codigo;
    
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
		  	$dtPagamento   = implode(array_reverse(explode("-", $oDetalhaPag->k17_data)));
		  	$nroAnulacaoOP = $oDetalhaPag->k17_codigo.substr($oDetalhaPag->k17_data, 0, 4);
		  	
		  	//HASH REG 12
			$sHasReg12  = 12;//$codReduzidoEO.$nroOP.$dtPagamento.$nroAnulacaoOP;
	   	  	
	   	  	if (!isset($aDadosAgrupados[$sHash]->Reg12[$sHasReg12])) {
	 	
		   	    $oDadosDetalhaPag = new stdClass();
		   	  	
		   	    $oDadosDetalhaPag->tipoRegistro                    = 12;
		   	    $oDadosDetalhaPag->detalhesessao                   = 12;
		        $oDadosDetalhaPag->codReduzidoEO                   = $aDadosAgrupados[$sHash]->codReduzidoEO;
		   	    $oDadosDetalhaPag->nroOP                           = $nroOP;
			    $oDadosDetalhaPag->dtPagamento                     = $dtPagamento;
			    $oDadosDetalhaPag->nroAnulacaoOP                   = $nroAnulacaoOP;
			    $oDadosDetalhaPag->dtAnulacaoOP                    = implode(array_reverse(explode("-", $oDetalhaPag->k17_dtanu)));
			    $oDadosDetalhaPag->tipoDocumentoCredor             = $tipoDocumentoCredor;
			    $oDadosDetalhaPag->nroDocumento                    = $oDetalhaPag->z01_cgccpf;
			    $oDadosDetalhaPag->nomeCredor                      = $oDetalhaPag->z01_nome;
			    $oDadosDetalhaPag->vlAnulacaoOP                    = $oDetalhaPag->k17_valor;
		    
			  //  $aDadosAgrupados[$sHash]->Reg12[$sHasReg12] = $oDadosDetalhaPag;
	      		
	   	  	} else {
	   	  //		$aDadosAgrupados[$sHash]->Reg12[$sHasReg12]->vlAnulacaoOP += $oAnulaExtra->k17_valor;
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
			and r.k12_instit = '". db_getsession("DB_instit") ."'  order by g.k02_tipo desc ,g.k02_codigo ) 
			as xxx 
	where 1=1 order by k02_tipo, k02_codigo ,k12_data";
	
	
	$rsAnulaExtra2 = db_query($sSql2);
	
	for ($iCont = 0;$iCont < pg_num_rows($rsAnulaExtra2); $iCont++) {
		
	  $oAnulaExtra2 = db_utils::fieldsMemory($rsAnulaExtra2,$iCont);
	  
	if ( $oAnulaExtra2->k02_tipo == 'E' ) {

        $sTipoLancamento  = "99";
        
        $sSqlSubTipo = "SELECT c61_reduz
                             from conplano 
	                      join conplanoreduz on c61_codcon = c60_codcon and c61_anousu = c60_anousu
	                 where c60_estrut = '".$oAnulaExtra2->estrutural."' and c60_anousu = '".db_getsession("DB_anousu")."'";
        
        
   	    $rsSubTipo = db_query($sSqlSubTipo);
   	    $oSubTipo = db_utils::fieldsMemory($rsSubTipo, 0);
   	    
   	    //$sSubTipo = $oSubTipo->c61_reduz;
   	    $sSubTipo = $oAnulaExtra2->codrec;
   	    $sDesdobraSubTipo = " ";
   	  	
   	  	if (substr($oAnulaExtra2->estrutural, 0, 5) == "21881") {
   	  		
   	  		$sTipoLancamento = "01";
   	  		/**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aINSS as $iINSS) {
   	  			
   	  			if ($oSubTipo->codrec == $iINSS) {
   	  				
   	  				$sSubTipo         = "0001";
   	  				$sDesdobraSubTipo = "0001";
   	  				break;
   	  				
   	  			}
   	  			
   	  		}
   	  	  /**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aRPPS as $iRPPS) {
   	  			
   	  			if ($oSubTipo->codrec == $iRPPS) {
   	  				
   	  				$sSubTipo         = "0002";
   	  				$sDesdobraSubTipo = "0002";
   	  				break;
   	  				
   	  			}
   	  			
   	  		}
   	  	  /**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aIRRF as $iIRRF) {
   	  			
   	  			if ($oSubTipo->codrec == $iIRRF) {
   	  				
   	  				$sSubTipo         = "0003";
   	  				$sDesdobraSubTipo = "0003";
   	  				break;
   	  				
   	  			}
   	  			
   	  		} 
   	  	  /**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aISSQN as $iISSQN) {
   	  			
   	  			if ($oSubTipo->codrec == $iISSQN) {
   	  				
   	  				$sSubTipo         = "0004";
   	  				$sDesdobraSubTipo = "0004";
   	  				break;
   	  				
   	  			}
   	  			
   	  		} 	
   	  		  		
   	  	} else {
   	  		
   	  	  if (substr($oAnulaExtra2->estrutural, 0, 3) == "112") {
   	  		  
   	  	  	$sTipoLancamento = "03";
   	  	  	
   	  	  	$sSubTipo = $oSubTipo->codrec;
   	  		     	  		
   	  	  } else {
   	  	  	
   	  	    if (substr($oAnulaExtra2->estrutural, 0, 4) == "45") {
   	  		    
   	  	    	$sTipoLancamento = "04";
   	  	    	/**
   	  		     * percorrer array de conta
   	  		     */
   	  		    foreach ($aRepasseCamara as $iRepasseCamara) {
   	  			
   	  			    if ($oSubTipo->codrec == $iRepasseCamara) {
   	  				
   	  				    $sSubTipo         = "0001";
   	  				    $sDesdobraSubTipo = "0001";
   	  				    break;
   	  				
   	  			   } else {
   	  			   	  $sSubTipo        = $oSubTipo->codrec;
   	  			     $sDesdobraSubTipo = $oSubTipo->codrec;
   	  			   }
   	  			
   	  		    }   
   	  		    	  		
   	  	    }
   	  	  	
   	  	  }
   	  		
   	  	}
      	
   	  	//$sHash = $oAnulaExtra2->codrec.$oAnulaExtra2->k02_codigo.$oAnulaExtra2->k12_numpre;
   	  	$sHash  = $sOrgao."1".$sTipoLancamento.$sSubTipo.$desdobraSubTipo;
				$sHash .= implode(array_reverse(explode("-", $oAnulaExtra2->k12_data)));
   	  	
   	  	if (!isset($aDadosAgrupados[$sHash])) {
 
   	  	 
   	  		
	   	    $oDadosAnulaExtra2 = new stdClass();
	   	  	
	   	    $oDadosAnulaExtra2->tipoRegistro                    = 10;
	   	    $oDadosAnulaExtra2->detalhesessao                   = 10;
	   	    $oDadosAnulaExtra2->codReduzidoEO					= $oAnulaExtra2->codrec.$oAnulaExtra2->k02_codigo.$oAnulaExtra2->k12_numpre;
	        $oDadosAnulaExtra2->codOrgao                        = $sOrgao;
	        $oDadosAnulaExtra2->codUnidadeSub                   = " ";
	   	    $oDadosAnulaExtra2->categoria                       = 1;
		      $oDadosAnulaExtra2->tipoLancamento                  = $sTipoLancamento;
		      $oDadosAnulaExtra2->subTipo		                    = $sSubTipo; 
		      $oDadosAnulaExtra2->desdobraSubTipo                 = $sDesdobraSubTipo;
		      $oDadosAnulaExtra2->dtLancamento                    = implode(array_reverse(explode("-", $oAnulaExtra2->k12_data)));
		      $oDadosAnulaExtra2->justificativa                   = substr($oAnulaExtra2->k02_drecei, 0, 50);
		      $oDadosAnulaExtra2->vlAnulacao                      = $oAnulaExtra2->valor;
	        $oDadosAnulaExtra2->Reg11 = array();
	        
            $aDadosAgrupados[$sHash] = $oDadosAnulaExtra2;
      
   	  	} else {
   	  		$aDadosAgrupados[$sHash]->vlAnulacao += $oAnulaExtra2->valor;
   	  	}
   	  
	   // REG 11
   	  	
   	  	$sSql11 = "SELECT o15_codtri
                             from conplano 
	                      join conplanoreduz on c61_codcon = c60_codcon and c61_anousu = c60_anousu
                                  join orctiporec on c61_codigo = o15_codigo
	                 where c61_reduz = '".$oAnulaExtra2->c61_reduz."' and c60_anousu = '". db_getsession("DB_anousu"). "'";
    
	    $rsDetalhaFonte2 = db_query($sSql11);
		
	    for ($iCont2 = 0;$iCont2 < pg_num_rows($rsDetalhaFonte2); $iCont2++) {
		
		  $oDetalhaFonte2 = db_utils::fieldsMemory($rsDetalhaFonte2,$iCont2);
   	  	
		  	$codReduzidoEO = $oAnulaExtra2->codrec.$oAnulaExtra2->k02_codigo.$oAnulaExtra2->k12_numpre;
		  
		  	//HASH REG 11
			$sHasReg11  = $sOrgao.$oDetalhaFonte->o15_codtri;
	   	  	
	   	  	if (!isset($aDadosAgrupados[$sHash]->Reg11[$sHasReg11])) {
	 	
		   	    $oDadosDetalhaFonte2 = new stdClass();
		   	  	
		   	    $oDadosDetalhaFonte2->tipoRegistro                    = 11;
		   	    $oDadosDetalhaFonte2->detalhesessao                   = 11;
		        $oDadosDetalhaFonte2->codReduzidoEO                   = $codReduzidoEO;
		   	    $oDadosDetalhaFonte2->codFontRecursos                 = $oDetalhaFonte2->o15_codtri;
			    $oDadosDetalhaFonte2->valorAnulacaoFonte              = $oAnulaExtra2->valor;
		    
			    $aDadosAgrupados[$sHash]->Reg11[$sHasReg11] = $oDadosDetalhaFonte2;
	      
	   	  	} else {
	   	  		$aDadosAgrupados[$sHash]->Reg11[$sHasReg11]->valorAnulacaoFonte += $oAnulaExtra2->valor;
	   	  	}
   	  	
	    }
	    
	  }
	    
    }
    
    //Terceiro Reg 10
    
  $sSql3 = "select k17_codigo, k17_dtanu, k17_valor, k18_motivo,c60_estrut,k153_slipoperacaotipo,k17_debito,
  from slipanul 
  join slip on k17_codigo = k18_codigo 
  join sliptipooperacaovinculo on k17_codigo = k153_slip and k153_slipoperacaotipo in (3,11)
  join conplanoreduz on k17_debito = c61_reduz and c61_anousu = '". db_getsession("DB_anousu") ."'
  join conplano on c61_codcon = c60_codcon and c60_anousu = c61_anousu
 where k17_dtanu between '". $this->sDataInicial ."' and '". $this->sDataFinal ."'";
	
	$rsReceitasDesp3 = db_query($sSql3);
	
	for ($iCont = 0;$iCont < pg_num_rows($rsReceitasDesp3); $iCont++) {
		
	    $oAnulaExtra3 = db_utils::fieldsMemory($rsReceitasDesp3,$iCont);
	
	  if ($oAnulaExtra3->k153_slipoperacaotipo == "13") {
   	  		
   	  		$sTipoLancamento = "01";
   	  		/**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aINSS as $iINSS) {
   	  			
   	  			if ($oAnulaExtra3->k17_debito == $iINSS) {
   	  				
   	  				$sSubTipo         = "0001";
   	  				$sDesdobraSubTipo = "0001";
   	  				break;
   	  				
   	  			}
   	  			
   	  		}
   	  	  /**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aRPPS as $iRPPS) {
   	  			
   	  			if ($oAnulaExtra3->k17_debito == $iRPPS) {
   	  				
   	  				$sSubTipo         = "0002";
   	  				$sDesdobraSubTipo = "0002";
   	  				break;
   	  				
   	  			}
   	  			
   	  		}
   	  	  /**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aIRRF as $iIRRF) {
   	  			
   	  			if ($oAnulaExtra3->k17_debito == $iIRRF) {
   	  				
   	  				$sSubTipo         = "0003";
   	  				$sDesdobraSubTipo = "0003";
   	  				break;
   	  				
   	  			}
   	  			
   	  		} 
   	  	  /**
   	  		 * percorrer array de conta
   	  		 */
   	  		foreach ($aISSQN as $iISSQN) {
   	  			
   	  			if ($oAnulaExtra3->k17_debito == $iISSQN) {
   	  				
   	  				$sSubTipo         = "0004";
   	  				$sDesdobraSubTipo = "0004";
   	  				break;
   	  				
   	  			}
   	  			
   	  		} 	
   	  		  		
   	  	} else {
   	  		
   	  	  if (substr($oAnulaExtra3->c60_estrut, 0, 3) == "112") {
   	  		  
   	  	  	$sTipoLancamento = "03";
   	  		  $sSubTipo = $oAnulaExtra3->k17_debito;
   	  		     	  		
   	  	  } else {
   	  	  	
   	  	    if (substr($oAnulaExtra3->c60_estrut, 0, 7) == "3510201") {
   	  		    
   	  	    	$sTipoLancamento = "04";
   	  	    	/**
   	  		     * percorrer array de conta
   	  		     */
   	  		    foreach ($aRepasseCamara as $iRepasseCamara) {
   	  			
   	  			    if ($oAnulaExtra3->k17_debito == $iRepasseCamara) {
   	  				
   	  				    $sSubTipo         = "0002";
   	  				    $sDesdobraSubTipo = "0002";
   	  				    break;
   	  				
   	  			   } else {
   	  			     $sDesdobraSubTipo = $oAnulaExtra3->k17_debito;
   	  			   }
   	  			
   	  		    }   
   	  		    	  		
   	  	    } else {
   	  	  	
   	  	    if (substr($oAnulaExtra3->k153_slipoperacaotipo,0,1) == "1") {
   	  		    
   	  	    	$sTipoLancamento = "04";
   	  	    	/**
   	  		     * percorrer array de conta
   	  		     */
   	  		    foreach ($aRepasseCamara as $iRepasseCamara) {
   	  			
   	  			    if ($oAnulaExtra3->k17_debito == $iRepasseCamara) {
   	  				
   	  				    $sSubTipo         = "0002";
   	  				    $sDesdobraSubTipo = "0002";
   	  				    break;
   	  				
   	  			   } else {
   	  			     $sDesdobraSubTipo = $oAnulaExtra3->k17_debito;
   	  			   }
   	  			
   	  		    }   
   	  		    	  		
   	  	    }
   	  	  	
   	  	  } 
   	  	  	
   	  	  } 
   	  		
   	  	}
      	
   	  	$sHash  = $sOrgao."1".$sTipoLancamento.$sSubTipo.$desdobraSubTipo;
		$sHash .= implode(array_reverse(explode("-", $oAnulaExtra3->k17_dtanu)));
   	  	
   	  	if (!isset($aDadosAgrupados[$sHash])) {
 
   	  	    if ($sTipoLancamento == "99") {
   	  			$sDescExtraOrc = "Diversos";
   	  		} else {
   	  			$sDescExtraOrc = substr($oAnulaExtra3->k18_motivo, 0, 50);
   	  		}
   	  		
	   	    $oDadosAnulaExtra3 = new stdClass();
	   	  	
	   	    $oDadosAnulaExtra3->tipoRegistro                    = 10;
	   	    $oDadosAnulaExtra3->detalhesessao                   = 10;
	   	    $oDadosAnulaExtra3->codReduzidoEO					= $oAnulaExtra3->k17_codigo.substr($oAnulaExtra3->k17_data, 0, 4);
	        $oDadosAnulaExtra3->codOrgao                        = $sOrgao;
	        $oDadosAnulaExtra3->codUnidadeSub                   = " ";
	   	    $oDadosAnulaExtra3->categoria                       = 1; //verificar se é mesmo sempre 2 como está na documentacao
		      $oDadosAnulaExtra3->tipoLancamento                = $sTipoLancamento;
		      $oDadosAnulaExtra3->subTipo		                      = $sSubTipo; 
		      $oDadosAnulaExtra3->desdobraSubTipo                 = $sDesdobraSubTipo;
		      $oDadosAnulaExtra3->dtLancamento                    = implode(array_reverse(explode("-", $oAnulaExtra3->k17_dtanu)));
		      $oDadosAnulaExtra3->descExtraOrc                    = $sDescExtraOrc;
		      $oDadosAnulaExtra3->vlAnulacao                      = $oAnulaExtra3->k17_valor;
	        $oDadosAnulaExtra3->Reg11 = array();
	        
            $aDadosAgrupados[$sHash] = $oDadosAnulaExtra3;
      
   	  	} else {
   	  		$aDadosAgrupados[$sHash]->vlAnulacao += $oAnulaExtra3->valor;
   	  	}
   	  	
		// REG 11
   	  	
   	  	$sSql11 = "SELECT o15_codtri
                             from conplano 
	                      join conplanoreduz on c61_codcon = c60_codcon and c61_anousu = c60_anousu
                                  join orctiporec on c61_codigo = o15_codigo
	                 where c61_reduz = 'k17_debito' and c60_anousu = ". db_getsession("DB_anousu");
    
	    $rsDetalhaFonte = db_query($sSql11);
	
	    for ($iCont2 = 0;$iCont2 < pg_num_rows($rsDetalhaFonte); $iCont2++) {
		
		  $oDetalhaFonte = db_utils::fieldsMemory($rsDetalhaFonte,$iCont2);
   	  	  
		  	$codReduzidoEO = $oAnulaExtra3->k17_codigo.substr($oAnulaExtra3->k17_data, 0, 4);
		  
		  	//HASH REG 11
			$sHasReg11  = $sOrgao.$codReduzidoEO.$oDetalhaFonte->o15_codtri;
	   	  	
	   	  	if (!isset($aDadosAgrupados[$sHash]->Reg11[$sHasReg11])) {
	 	
		   	    $oDadosDetalhaFonte3 = new stdClass();
		   	  	
		   	    $oDadosDetalhaFonte3->tipoRegistro                    = 11;
		   	    $oDadosDetalhaFonte3->detalhesessao                   = 11;
		        $oDadosDetalhaFonte3->codReduzidoEO                   = $codReduzidoEO;
		   	    $oDadosDetalhaFonte3->codFontRecursos                 = $oDetalhaFonte->o15_codtri;
			      $oDadosDetalhaFonte3->valorAnulacaoFonte              = $oAnulaExtra3->k17_valor;
		    
			    $aDadosAgrupados[$sHash]->Reg11[$sHasReg11] = $oDadosDetalhaFonte3;
	      
	   	  	} else {
	   	  		$aDadosAgrupados[$sHash]->Reg11[$sHasReg11]->valorAnulacaoFonte += $oAnulaExtra3->k17_valor;
	   	  	}
   	  	
	    }
   	  	
    }
    
    /**
     * passar os valores agrupados para o array de dados
     */
    foreach ($aDadosAgrupados as $oDadosAgrupados2) {

    	$oDadosClone = clone $oDadosAgrupados2;
    	unset($oDadosClone->Reg11);
    	unset($oDadosClone->Reg12);
    	
    	$oDadosClone->vlAnulacao = number_format(abs($oDadosClone->vlAnulacao), 2, "", "");
    	$oDadosClone->justificativa = utf8_decode($oDadosClone->justificativa); 
    	$this->aDados[] = $oDadosClone;
    	
    foreach ($oDadosAgrupados2->Reg11 as $oDados) {
    	 	
    	 	$oDados->valorAnulacaoFonte = number_format(abs($oDados->valorAnulacaoFonte), 2, "", "");
    	 	
    	 	$this->aDados[] = $oDados;
    	 	
    	}
    	foreach ($oDadosAgrupados2->Reg12 as $oDados2) {
    	 	
    	 	$oDados2->vlAnulacaoOP = number_format($oDados2->vlAnulacaoOP, 2, "", "");
    	 	
    	 	$this->aDados[] = $oDados2;
    	 	
    	}
    	
    }
	
 }
		
 }
