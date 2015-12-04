<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * Dados Cadastro de Veículos Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoCadastroVeiculos extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 175;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'CVC';
  
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
                          "codUnidadeSub",
                          "codVeiculo",
                          "tpVeiculo",
                          "subTipoVeiculo",
                          "descVeiculo",
                          "marca",
                          "modelo",
     				              "ano",
                          "placa",
                          "chassi",
                          "numeroRenavam",
                          "nroSerie",
                          "situacao"
                        );
    $aElementos[20] = array(
                          "tipoRegistro",
                          "codOrgao",
                          "codUnidadeSub",
                          "codVeiculo",
    											"origemGasto",
                          "codUnidadeEmpenho",
                          "nroEmpenho",
                          "dtEmpenho",
                          "tpDeslocamento",
                          "MarcacaoInicial",
                          "MarcacaoFinal",
                          "tipoGasto",
                          "qtdeUtilizada",
                          "vlGasto",
                          "dscPecasServicos",
                          "atestadoControle"
                        );
    $aElementos[30] = array(
                          "tipoRegistro",
                          "codOrgao",
                          "codUnidadeSub",
                          "codVeiculo",
                          "nomeEstabelecimento",
                          "localidade",
                          "distanciaEstabelecimento",
                          "numeroPassageiros",
    											"turnos"
                        );
    $aElementos[40] = array(
                          "tipoRegistro",
                          "codOrgao",
                          "codUnidadeSub",
                          "codVeiculo",
                          "tipoBaixa",
                          "descBaixa"
                        );
    return $aElementos;
  }
  
  /**
   * selecionar os dados do cadastro de veículos
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
      
    	if ($oOrgao->getAttribute('instituicao') == db_getsession("DB_instit")) {
    		
        $sOrgao           = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
        $sTrataCodUnidade = $oOrgao->getAttribute('trataCodUnidade');
        
    	}
    	
    }
  
    if (!isset($oOrgao)) {
      throw new Exception("Arquivo sem configuração de Orgãos.");
    }

    $sSql  = "SELECT v.*,dpo.* from veiculos v join veiccentral vc on v.ve01_codigo = vc.ve40_veiculos ";
    $sSql .= "join veiccadcentral vcc on vc.ve40_veiccadcentral = vcc.ve36_sequencial ";
    $sSql .= "join db_depart d on vcc.ve36_coddepto = d.coddepto ";
    $sSql .= "join db_departorg dpo on coddepto = db01_coddepto ";
    $sSql .= "where d.instit = ".db_getsession("DB_instit");
    $sSql .= " and dpo.db01_anousu = ".db_getsession("DB_anousu");
    
    $rsVeiculos = db_query($sSql);
    
    for ($iCont = 0;$iCont < pg_num_rows($rsVeiculos); $iCont++) {
    	
    	$oVeiculos  = db_utils::fieldsMemory($rsVeiculos,$iCont);
    	
      if ($sTrataCodUnidade == "01") {
      		
        $sCodUnidade  = str_pad($oVeiculos->db01_orgao, 2, "0", STR_PAD_LEFT);
	   		$sCodUnidade .= str_pad($oVeiculos->db01_unidade, 3, "0", STR_PAD_LEFT);
	   		  
      } else {
      		
        $sCodUnidade	= str_pad($oVeiculos->db01_orgao, 3, "0", STR_PAD_LEFT);
	   	  $sCodUnidade .= str_pad($oVeiculos->db01_unidade, 2, "0", STR_PAD_LEFT);
      		
      }
    	
    	$sSql    = "select ve21_descr from veiccadmarca where ve21_codigo = ".$oVeiculos->ve01_veiccadmarca;
    	$rsMarca = db_query($sSql);
    	$sMarca  = db_utils::fieldsMemory($rsMarca, 0)->ve21_descr;
    	
    	$sSql     = "select ve22_descr from veiccadmodelo where ve22_codigo = ".$oVeiculos->ve01_veiccadmodelo;
    	$rsModelo = db_query($sSql);
    	$sModelo  = db_utils::fieldsMemory($rsModelo, 0)->ve22_descr;
    	
    	if ($oVeiculos->ve01_veiccadtipo == 1 
    	    || $oVeiculos->ve01_veiccadtipo == 3 
    	    || $oVeiculos->ve01_veiccadtipo == 4
    	    || $oVeiculos->ve01_veiccadtipo == 5
    	    || $oVeiculos->ve01_veiccadtipo == 6
    	    || $oVeiculos->ve01_veiccadtipo == 7
    	    || $oVeiculos->ve01_veiccadtipo == 8
    	    || $oVeiculos->ve01_veiccadtipo == 11
    	    || $oVeiculos->ve01_veiccadtipo == 12
    	    || $oVeiculos->ve01_veiccadtipo == 13) {
    		$sTipo = "03"; 
    	} else {
    		
    		if ($oVeiculos->ve01_veiccadtipo == 2
    		    || $oVeiculos->ve01_veiccadtipo == 9
    		    || $oVeiculos->ve01_veiccadtipo == 10) {
    			$sTipo = "04";
    		}
    		
    	}
    	
    	if ($oVeiculos->ve01_veiccadtipo == 1) {
    		$sSubTipo = "03";
    	} else {
    		
    		if ($oVeiculos->ve01_veiccadtipo == 2 
    		    || $oVeiculos->ve01_veiccadtipo == 9 
    		    || $oVeiculos->ve01_veiccadtipo == 10) {
    			$sSubTipo = "10";
    		} else {
    			
    			if ($oVeiculos->ve01_veiccadtipo == 3 || $oVeiculos->ve01_veiccadtipo == 13) {
    				$sSubTipo = "07";
    			} else {
    				
    				if ($oVeiculos->ve01_veiccadtipo == 4 
    				    || $oVeiculos->ve01_veiccadtipo == 5
    				    || $oVeiculos->ve01_veiccadtipo == 12) {
    					$sSubTipo = "08";
    				} else {
    					
    					if ($oVeiculos->ve01_veiccadtipo == 6) {
    						$sSubTipo = "06";
    					} else {
    						
    						if ($oVeiculos->ve01_veiccadtipo == 7) {
    							$sSubTipo = "05";
    						} else {
    							
    							if ($oVeiculos->ve01_veiccadtipo == 8 || $oVeiculos->ve01_veiccadtipo == 11) {
    								$sSubTipo = "04";
    							}
    							
    						}
    						
    					}
    					
    				}
    				
    			}
    			
    		}
    		
    	}
    	
    	if (($oVeiculos->ve01_dtaquis >= $this->sDataInicial && $oVeiculos->ve01_dtaquis <= $this->sDataFinal)
    	    || ($this->sDataInicial == (db_getsession("DB_anousu").'-01-01') && $oVeiculos->ve01_dtaquis <=  $this->sDataFinal)) {
    	
	    	$oDadosVeiculos = new stdClass();
	    	
	    	$oDadosVeiculos->tipoRegistro   = 10;
	    	$oDadosVeiculos->detalhesessao  = 10;
	    	$oDadosVeiculos->codOrgao       = $sOrgao;
	    	$oDadosVeiculos->codUnidadeSub  = $sCodUnidade;
	    	$oDadosVeiculos->codVeiculo     = $oVeiculos->ve01_codigo;
	    	$oDadosVeiculos->tpVeiculo      = $sTipo;
	    	$oDadosVeiculos->subTipoVeiculo = $sSubTipo;
	    	$oDadosVeiculos->descVeiculo    = "$sMarca $sModelo";
	    	$oDadosVeiculos->marca          = substr($sMarca, 0, 50);
	    	$oDadosVeiculos->modelo         = substr($sModelo, 0, 50);
	    	$oDadosVeiculos->ano            = $oVeiculos->ve01_anofab;
	    	$oDadosVeiculos->placa          = substr($oVeiculos->ve01_placa, 0, 8);
	    	$oDadosVeiculos->chassi         = substr($oVeiculos->ve01_chassi, 0, 30);
	    	$oDadosVeiculos->numeroRenavam  = substr($oVeiculos->ve01_ranavam, 0, 9);
	    	$oDadosVeiculos->nroSerie       = " ";
	    	$oDadosVeiculos->situacao       = "01";
	    	
	    	$this->aDados[] = $oDadosVeiculos;
      
    	}
    	/**
    	 * encontrar quilometragem inicial e final do mês entre veicmanut e veicabast
    	 */
    	$sSql = "SELECT min(ve62_medida) as km_inicial, max(ve62_medida) as km_final 
               from veicmanut  
               where ve62_veiculos = $oVeiculos->ve01_codigo and ve62_dtmanut between '".$this->sDataInicial."' and '".$this->sDataFinal."'";
    	
    	$rsKmManut = db_query($sSql);
    	$oKmManut  = db_utils::fieldsMemory($rsKmManut, 0);

      $sSql = "SELECT min(ve70_medida) as km_inicial, max(ve70_medida) as km_final 
               from veicabast  
               where ve70_veiculos = $oVeiculos->ve01_codigo and ve70_dtabast between '".$this->sDataInicial."' and '".$this->sDataFinal."'";
      
      $rsKmCombust = db_query($sSql);
    	$oKmCombust  = db_utils::fieldsMemory($rsKmCombust, 0);
    	
    	if ($oKmManut->km_inicial < $oKmCombust->km_inicial && $oKmManut->km_inicial != "") {
    		$sMarcacaoInicial = $oKmManut->km_inicial;
    	} else {
    		
    		if ($oKmCombust->km_inicial != "") {
    		  $sMarcacaoInicial = $oKmCombust->km_inicial;
    		} else {
    		  $sMarcacaoInicial = $oKmManut->km_inicial;	
    		} 
    	}
    	
      if ($oKmManut->km_final > $oKmCombust->km_final) {
    		$sMarcacaoFinal = $oKmManut->km_final;
    	} else {
    		$sMarcacaoFinal = $oKmCombust->km_final;
    	}
    	
    	/*
    	 * Valores de serviços
    	 */
      $sSql     = "SELECT v.ve62_descr,v.ve62_veiculos,sum(v.ve62_vlrmobra) as servico, 
                  (SELECT sum(vmi.ve63_quant) as quantidade 
                  from veicmanut vm join veicmanutitem vmi 
                  on vm.ve62_codigo = vmi.ve63_veicmanut
                  join veicmanutitempcmater vmip 
                  on vmi.ve63_codigo = vmip.ve64_veicmanutitem
                  join pcmater pc
                  on vmip.ve64_pcmater = pc.pc01_codmater
                  where vm.ve62_veiculos = v.ve62_veiculos and pc01_servico = true) as quantidade
                  from veicmanut v
                  where v.ve62_veiculos = ".$oVeiculos->ve01_codigo." 
                  and v.ve62_dtmanut between '".$this->sDataInicial."' and '".$this->sDataFinal."' 
                  group by v.ve62_veiculos,v.ve62_descr";
    	
      $rsServico = db_query($sSql);
    	$oServico  = db_utils::fieldsMemory($rsServico, 0);
    	
    	if ($oServico->servico > 0) {
    		
    		$oDadosServico = new stdClass();
    		
    		$oDadosServico->tipoRegistro      = 20;
    		$oDadosServico->detalhesessao     = 20;
    		$oDadosServico->codOrgao          = $sOrgao;
    		$oDadosServico->codUnidadeSub     = $sCodUnidade;
    		$oDadosServico->codVeiculo        = $oVeiculos->ve01_codigo;
    		$oDadosServico->origemGasto       = "1";
    		$oDadosServico->codUnidadeEmpenho = " ";
    		$oDadosServico->nroEmpenho        = " ";
    		$oDadosServico->dtEmpenho         = " ";
    		$oDadosServico->tpDeslocamento    = "01";
    		$oDadosServico->MarcacaoInicial   = $sMarcacaoInicial;
    		$oDadosServico->MarcacaoFinal     = $sMarcacaoFinal;
    		$oDadosServico->tipoGasto         = "09";
    		if($oServico->quantidade== "" || $oServico->quantidade==0){
    			$oDadosServico->qtdeUtilizada     ="10000";
    		}else{
    			$oDadosServico->qtdeUtilizada     = number_format($oServico->quantidade, 2, "", "");
    		}
    		
    		$oDadosServico->vlGasto           = number_format($oServico->servico, 2, "", "");
    		$oDadosServico->dscPecasServicos  = substr($oServico->ve62_descr, 0, 50);
    		$oDadosServico->atestadoControle  = "1";
    		
    		$this->aDados[] = $oDadosServico;
    		
    	}
    	
    	/**
    	 * valores de peças
    	 */
      $sSql     = "SELECT v.ve62_veiculos,sum(v.ve62_vlrpecas) as pecas, pcmater.pc01_descrmater,
                   (SELECT sum(vmi.ve63_quant) as quantidade 
                   from veicmanut vm join veicmanutitem vmi 
                   on vm.ve62_codigo = vmi.ve63_veicmanut
                   join veicmanutitempcmater vmip 
                   on vmi.ve63_codigo = vmip.ve64_veicmanutitem
                   join pcmater pc
                   on vmip.ve64_pcmater = pc.pc01_codmater
                   where vm.ve62_veiculos = v.ve62_veiculos and pc01_servico = false) as quantidade
                   from veicmanut v
                   left join veicmanutitem 
                   on v.ve62_codigo = veicmanutitem.ve63_veicmanut
                  left  join veicmanutitempcmater 
                   on veicmanutitem.ve63_codigo = veicmanutitempcmater.ve64_veicmanutitem
                   left join pcmater
                   on veicmanutitempcmater.ve64_pcmater = pcmater.pc01_codmater
                   where v.ve62_veiculos = ".$oVeiculos->ve01_codigo."  
                   and v.ve62_dtmanut between '".$this->sDataInicial."' and '".$this->sDataFinal."'  
                   group by v.ve62_veiculos,pcmater.pc01_descrmater";
    	//echo $sSql;
      $rsPecas = db_query($sSql);//db_criatabela($rsPecas);
    	$oPecas  = db_utils::fieldsMemory($rsPecas, 0);
    	
    	if ($oPecas->pecas > 0) {
    		
    		$oDadosPecas = new stdClass();
    		
    		$oDadosPecas->tipoRegistro      = 20;
    		$oDadosPecas->detalhesessao     = 20;
    		$oDadosPecas->codOrgao          = $sOrgao;
    		$oDadosPecas->codUnidadeSub     = $sCodUnidade;
    		$oDadosPecas->codVeiculo        = $oVeiculos->ve01_codigo;
    		$oDadosPecas->origemGasto       = "1";
    		$oDadosPecas->codUnidadeEmpenho = " ";
    		$oDadosPecas->nroEmpenho        = " ";
    		$oDadosPecas->dtEmpenho         = " ";
    		$oDadosPecas->tpDeslocamento    = "01";
    		$oDadosPecas->MarcacaoInicial   = $sMarcacaoInicial;
    		$oDadosPecas->MarcacaoFinal     = $sMarcacaoFinal;
    		$oDadosPecas->tipoGasto         = "08";
    		$oDadosPecas->qtdeUtilizada     = number_format($oPecas->quantidade, 2, "", "");
    		$oDadosPecas->vlGasto           = number_format($oPecas->pecas, 2, "", "");
    		$oDadosPecas->dscPecasServicos  = " ";
    		$oDadosPecas->atestadoControle  = "1";
    		
    		$this->aDados[] = $oDadosPecas;
    		
    	}
    		/*
    		 * Valores de Combustível
    		 */
    		$sSql = "SELECT ve70_veiculoscomb, sum(ve70_valor) as vl_combustivel, sum(ve70_litros) as qtd_litros,e60_codemp,
    		si05_atestado,e60_emiss,o58_orgao,o58_unidade   
    						 from veicabast 
    						 left join empveiculos on ve70_codigo = si05_codabast 
    						 left join empempenho on si05_numemp = e60_numemp  
    						 join orcdotacao on e60_coddot = o58_coddot and e60_anousu = o58_anousu 
                 where ve70_veiculos = ".$oVeiculos->ve01_codigo."  
                 and ve70_dtabast between '".$this->sDataInicial."' and '".$this->sDataFinal."' 
                 group by ve70_veiculoscomb,e60_codemp,si05_atestado,e60_emiss,o58_orgao,o58_unidade";
    		
    		$rsCombustivel = db_query($sSql);
    		
    		/*
    		 * passar valores conforme os tipos de combustiveis do veiculo
    		 */
    		for ($iCont2 = 0;$iCont2 < pg_num_rows($rsCombustivel); $iCont2++) {
    			
    		 	$oCombustivel = db_utils::fieldsMemory($rsCombustivel, $iCont2);
    		 	
    		 	if ($oCombustivel->ve70_veiculoscomb == 1) {
    		 		$sTipoCombustivel = "02";
    		 	} else {
    		 		
    		 	  if ($oCombustivel->ve70_veiculoscomb == 2) {
    		 		  $sTipoCombustivel = "01";
    		 	  } else {
    		 	  	
    		 	    if ($oCombustivel->ve70_veiculoscomb == 3) {
    		 		    $sTipoCombustivel = "04";
    		 	    } else {
    		 	    	
    		 	      if ($oCombustivel->ve70_veiculoscomb == 4) {
    		 		      $sTipoCombustivel = "03";
    		 	      }
    		 	    	
    		 	    }
    		 	  	
    		 	  }
    		 		
    		 	}
    		 	
    		 	$oDadosCombustivel = new stdClass();
    		
    		  $oDadosCombustivel->tipoRegistro      = 20;
    		  $oDadosCombustivel->detalhesessao     = 20;
    		  $oDadosCombustivel->codOrgao          = $sOrgao;
    		  $oDadosCombustivel->codUnidadeSub     = $sCodUnidade;
    		  $oDadosCombustivel->codVeiculo        = $oVeiculos->ve01_codigo;
    		  $oDadosCombustivel->origemGasto       = "2";
    		  $oDadosCombustivel->codUnidadeEmpenho = str_pad($oCombustivel->o58_orgao, 2, "0", STR_PAD_LEFT).str_pad($oCombustivel->o58_unidade, 3, "0", STR_PAD_LEFT);
    		  $oDadosCombustivel->nroEmpenho        = substr($oCombustivel->e60_codemp, 0, 22);// verificar 
    		  $oDadosCombustivel->dtEmpenho         = implode("", array_reverse(explode("-",$oCombustivel->e60_emiss)));
    		  $oDadosCombustivel->tpDeslocamento    = "01";
    		  $oDadosCombustivel->MarcacaoInicial   = $sMarcacaoInicial;
    		  $oDadosCombustivel->MarcacaoFinal     = $sMarcacaoFinal;
    		  $oDadosCombustivel->tipoGasto         = $sTipoCombustivel;
    		  $oDadosCombustivel->qtdeUtilizada     = number_format($oCombustivel->qtd_litros, 2, "", "");
    		  $oDadosCombustivel->vlGasto           = number_format($oCombustivel->vl_combustivel, 2, "", "");
    		  $oDadosCombustivel->dscPecasServicos  = " ";
    		  $oDadosCombustivel->atestadoControle  = $oCombustivel->si05_atestado=='t'?'2':'1';
    		  
    		  $this->aDados[] = $oDadosCombustivel;
    			
    		}
    		
       /**
  	   * selecionar arquivo xml com dados tranporte escolar
  	   */


	     $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomcadveiculos.xml";
    
   
       if (!file_exists($sArquivo)) {
         throw new Exception("Arquivo de cadastro de transporte escolar inexistente!");
       }
       $sTextoXml    = file_get_contents($sArquivo);
       $oDOMDocument = new DOMDocument();
       $oDOMDocument->loadXML($sTextoXml);
       $oCadVeiculos = $oDOMDocument->getElementsByTagName('cadveiculo');
    
       /**
        * percorrer os dados retornados do xml para selecionar os reponsaveis da inst logada
        * para selecionar os dados da instit
        */
       foreach ($oCadVeiculos as $oCadVeiculo) {
      
    	  if ($oCadVeiculo->getAttribute('codVeiculo') == $oVeiculos->ve01_codigo) {
          
    	    $oDadosCadVeiculo = new stdClass();

    	    $oDadosCadVeiculo->tipoRegistro  					   = 30;
    	    $oDadosCadVeiculo->detalhesessao 					   = 30;
    	    $oDadosCadVeiculo->codOrgao              	   = $sOrgao;
    	    $oDadosCadVeiculo->codUnidadeSub   				   = $sCodUnidade;
	  	    $oDadosCadVeiculo->codVeiculo                = $oVeiculos->ve01_codigo;
	  	    $oDadosCadVeiculo->nomeEstabelecimento       = substr($oCadVeiculo->getAttribute("nomeEstabelecimento"), 0, 250);
	  	    $oDadosCadVeiculo->localidade         			 = substr($oCadVeiculo->getAttribute("localidade"), 0, 250);
	  	    $oDadosCadVeiculo->distanciaEstabelecimento  = number_format($oCadVeiculo->getAttribute("distanciaEstabelecimento"), 2, "", "");
	  	    $oDadosCadVeiculo->numeroPassageiros         = $oCadVeiculo->getAttribute("numeroPassageiros");
	  	    $oDadosCadVeiculo->turnos       					   = str_pad($oCadVeiculo->getAttribute("turnos"), 2, "0", STR_PAD_LEFT);
	      
	        $this->aDados[] = $oDadosCadVeiculo;
 
    	  }
    	
       }
    
       if (!isset($oCadVeiculo)) {
         throw new Exception("Arquivo sem dados cadastrados.");
       }
    	
    }
    
    $sSql     = "select * from veicbaixa vb join veiculos v on vb.ve04_veiculo = v.ve01_codigo ";
    $sSql 	 .=	"join veiccadtipobaixa vtb on vb.ve04_veiccadtipobaixa = vtb.ve12_sequencial ";
    $sSql		 .= "vb.ve04_data between '".$this->sDataInicial."' and '".$this->sDataFinal."' ";
    
    $rsBaixaVeiculos = db_query($sSql);
    
    for ($iCont = 0;$iCont < pg_num_rows($rsBaixaVeiculos); $iCont++) {
    
	    $oBaixaVeiculos =  db_utils::fieldsMemory($rsBaixaVeiculos, $iCont);
	    $oDadosPecas = new stdClass();
	    
	    $tipoBaixa = " ";
	    
	    if ($oBaixaVeiculos->ve12_descr == 'Alienacao' ) {
	    	$tipoBaixa = '01';
	    }
    	if ($oBaixaVeiculos->ve12_descr == 'Obsolescencia' ) {
	    	$tipoBaixa = '02';
	    }
    	if ($oBaixaVeiculos->ve12_descr == 'Sinistro' ) {
	    	$tipoBaixa = '03';
	    }
    	if ($oBaixaVeiculos->ve12_descr == 'Doacao' ) {
	    	$tipoBaixa = '04';
	    }
    	if ($oBaixaVeiculos->ve12_descr == 'Cessao' ) {
	    	$tipoBaixa = '05';
	    }
    	if ($oBaixaVeiculos->ve12_descr == 'Transferencia' ) {
	    	$tipoBaixa = '07';
	    }
    	if ($oBaixaVeiculos->ve12_descr == 'Outros' ) {
	    	$tipoBaixa = '99';
	    }
	    		
	    $oBaixaVeiculos->tipoRegistro      = 40;
	    $oBaixaVeiculos->detalhesessao     = 40;
	    $oBaixaVeiculos->codOrgao          = $sOrgao;
	    $oBaixaVeiculos->codUnidadeSub     = $sCodUnidade;
	    $oBaixaVeiculos->codVeiculo        = $oBaixaVeiculos->ve04_veiculo;
	    $oBaixaVeiculos->tipoBaixa         = $tipoBaixa;
	    $oBaixaVeiculos->descBaixa         = str_pad($oBaixaVeiculos->ve04_motivo, 2, "0", STR_PAD_LEFT);
	    		
	    $this->aDados[] = $oDadosPecas;

    }
    
  }
		
 }