<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * Julgamento da Licitação Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoJulgamentoLicitacao extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 157;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'JULGLIC';
  
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
						                "exercicioLicitacao",
						                "nroProcessoLicitatorio",
						                "tipoDocumento",
						    					  "nroDocumento",
						    					  "nroLote",
						    					  "nroItem",
						    					  "dscProdutoServico",
						    					  "vlUnitario",
						    					  "quantidade",
						    					  "unidade"   					  
                        );
    $aElementos[20] = array(
						    					  "tipoRegistro",
						                "codOrgao",
						                "codUnidadeSub",
						                "exercicioLicitacao",
						                "nroProcessoLicitatorio",
						    					  "tipoDocumento",
						    					  "nroDocumento",
												    "nroLote",
    												"nroItem",
												    "dscLote",
    												"dscItem",
												    "percDesconto"
    					);
    $aElementos[30] = array(
						    					  "tipoRegistro",
						                "codOrgao",
						                "codUnidadeSub",
						                "exercicioLicitacao",
						                "nroProcessoLicitatorio",
						    					  "dtJulgamento",
    												"PresencaLicitantes",
						    					  "renunciaRecurso"
    					);					
    return $aElementos;
  }
  
  /**
   * Julgamento da Licitação do mes para gerar o arquivo
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
    
    /**
	* selecionar arquivo xml de Dados Compl Licitação
	*/
	$sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomdadoscompllicitacao.xml";
	if (!file_exists($sArquivo)) {
		throw new Exception("Arquivo de dados compl licitacao inexistente!");
	}
	$sTextoXml    = file_get_contents($sArquivo);
	$oDOMDocument = new DOMDocument();
	$oDOMDocument->loadXML($sTextoXml);
	$oDadosComplLicitacoes = $oDOMDocument->getElementsByTagName('dadoscompllicitacao');
	
	/**
	 * selecionar arquivo xml de Homologacao
		*/
	$sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomhomologalict.xml";
	if (!file_exists($sArquivo)) {
		throw new Exception("Arquivo de Homologação inexistente!");
	}
	$sTextoXml    = file_get_contents($sArquivo);
	$oDOMDocument = new DOMDocument();
	$oDOMDocument->loadXML($sTextoXml);
	$oHomologacoes = $oDOMDocument->getElementsByTagName('homologalict');
	$aLicitacao = array();
	foreach ($oHomologacoes as $oHomologacao) {

		$dDtHomologacao = implode("-", array_reverse(explode("/",$oHomologacao->getAttribute('dtHomologacao'))));
		if ($oHomologacao->getAttribute('instituicao') == db_getsession("DB_instit")
		    && $dDtHomologacao >= $this->sDataInicial
		    && $dDtHomologacao <= $this->sDataFinal) {
		    	
		  $sSqlLicitacao = "select * from liclicita 
      inner join db_config on db_config.codigo = liclicita.l20_instit 
      inner join db_usuarios on db_usuarios.id_usuario = liclicita.l20_id_usucria 
      inner join cflicita on cflicita.l03_codigo = liclicita.l20_codtipocom 
      left join pctipocompratribunal on cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial 
      where l20_codigo = ".$oHomologacao->getAttribute('nroProcessoLicitatorio')." and l20_licsituacao in (1) 
      and l44_codigotribunal in ('1','2','3','4','5','6') and l44_sequencial < 100 and l20_instit = 1";
			$rsLicitacao = db_query($sSqlLicitacao);
			if (pg_num_rows($rsLicitacao) > 0) {
			  $aLicitacao[] = $oHomologacao->getAttribute('nroProcessoLicitatorio');	
			}
				
		}
			
	}
	$sLicitacao = implode(",", $aLicitacao);

	/**
	 * selecionar arquivo xml de desconto tabela
		*/
	$sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomdescontotabela.xml";
	/*if (!file_exists($sArquivo)) {
		throw new Exception("Arquivo de Desconto inexistente!");
	}*/
	$sTextoXml    = file_get_contents($sArquivo);
	$oDOMDocument = new DOMDocument();
	$oDOMDocument->loadXML($sTextoXml);
	$oDescontos = $oDOMDocument->getElementsByTagName('descontotabela');
    
  $sSql  = "SELECT  l20_codigo,l20_anousu,l21_codigo,pc01_descrmater,pc23_quant,pc23_vlrun,m61_descr, z01_cgccpf, pc01_codmater,pc81_codprocitem,
	(select l11_licsituacao  from liclicitasituacao where l11_liclicita = l20_codigo and l11_licsituacao = 1 order by l11_sequencial limit 1) as l11_licsituacao,
	(select l11_hora  from liclicitasituacao where l11_liclicita = l20_codigo and l11_licsituacao = 1 order by l11_sequencial limit 1) as l11_hora
			  FROM   liclicitem 
			  INNER JOIN pcorcamitemlic 
				ON l21_codigo = pc26_liclicitem 
			  INNER JOIN pcorcamitem 
				ON pc22_orcamitem = pc26_orcamitem 
			  INNER JOIN pcorcamjulg 
				ON pc22_orcamitem = pc24_orcamitem 
		   	  INNER JOIN pcprocitem 
			 	ON pc81_codprocitem = l21_codpcprocitem 
			  INNER JOIN solicitem 
				ON pc81_solicitem = pc11_codigo 
			  INNER JOIN solicitempcmater 
				ON pc11_codigo=pc16_solicitem 
			  INNER JOIN pcmater 
				ON pc16_codmater = pc01_codmater
			  INNER JOIN liclicita
				ON l21_codliclicita = l20_codigo 
			  INNER JOIN pcorcamval 
				ON pc22_orcamitem = pc23_orcamitem
			  LEFT JOIN solicitemunid 
				ON pc11_codigo = pc17_codigo
			  LEFT JOIN matunid
				ON m61_codmatunid = pc17_unid
			  INNER JOIN pcorcamforne
				ON pc24_orcamforne = pc21_orcamforne
			  INNER JOIN cgm
				ON pc21_numcgm = z01_numcgm					
			  WHERE l20_codigo in (".$sLicitacao.") and l20_instit = ".db_getsession("DB_instit")."
			  order by l21_codigo";   
		  
    $rsJulgLic = db_query($sSql);
    
    /**
     * percorrer registros de contas retornados do sql acima
     */
    $aDadosAgrupados = array();
    for ($iCont = 0;$iCont < pg_num_rows($rsJulgLic); $iCont++) {
    	
      $oJulgLic = db_utils::fieldsMemory($rsJulgLic,$iCont);
      
      foreach ($oDadosComplLicitacoes as $oDadosComplLicitacao) {
			  
		    if ($oDadosComplLicitacao->getAttribute('instituicao') == db_getsession("DB_instit")
		        && $oDadosComplLicitacao->getAttribute('nroProcessoLicitatorio') == $oJulgLic->l20_codigo) {
	      
		      if (strlen($oJulgLic->z01_cgccpf) == 11) {
	          $sTipoDocumento = 1;  
	      	} else {
	      	  $sTipoDocumento = 2;                
	        }  	

	        $sHash  = $sOrgao.$oDadosComplLicitacao->getAttribute('ano').$oDadosComplLicitacao->getAttribute('codigoProcesso');
	        $sHash .= $sTipoDocumento.$oJulgLic->z01_cgccpf.$oJulgLic->pc01_codmater;
	        
	        if (!isset($aDadosAgrupados[$sHash])) {
	        	
	          if ($oJulgLic->m61_descr != '') {
     	        $sUnidade = substr($oJulgLic->m61_descr, 0, 50);
     	      } else {
     	        $sUnidade = "Serviço";
     	      }
	        	
		        $oDadosJulgLic = new stdClass();
		
		      	$oDadosJulgLic->tipoRegistro  		     = 10;
		      	$oDadosJulgLic->detalhesessao 		     = 10;
		      	$oDadosJulgLic->codOrgao               = $sOrgao;
		      	$oDadosJulgLic->codUnidadeSub          = " ";
		      	$oDadosJulgLic->exercicioLicitacao     = str_pad($oDadosComplLicitacao->getAttribute('ano'), 4, "0", STR_PAD_LEFT);
		      	$oDadosJulgLic->nroProcessoLicitatorio = substr($oDadosComplLicitacao->getAttribute('codigoProcesso'), 0, 12);
		        $oDadosJulgLic->tipoDocumento				   = $sTipoDocumento;
		        $oDadosJulgLic->nroDocumento           = substr($oJulgLic->z01_cgccpf, 0, 14);
		        $oDadosJulgLic->nroLote                = " ";
		        $oDadosJulgLic->nroItem                = substr($oJulgLic->pc01_codmater, -4);
		        $oDadosJulgLic->dscProdutoServico      = substr($oJulgLic->pc01_descrmater, 0, 250);
		        $oDadosJulgLic->vlUnitario             = $oJulgLic->pc23_vlrun;
		        $oDadosJulgLic->quantidade             = $oJulgLic->pc23_quant;
		        $oDadosJulgLic->unidade                = $sUnidade;
		        $oDadosJulgLic->Reg20                  = array();
		      
			      $aDadosAgrupados[$sHash] = $oDadosJulgLic;
			      
	          foreach ($oDescontos as $oDesconto) {
      
    	        if ($oDesconto->getAttribute('nroProcessoLicitatorio') == $oJulgLic->l20_codigo) {
    	        	
    	        	$oDadosPercDesconto = new stdClass();
    	        	
    	        	$oDadosPercDesconto->tipoRegistro  		      = 20;
		      	    $oDadosPercDesconto->detalhesessao 		      = 20;
		      	    $oDadosPercDesconto->codOrgao               = $sOrgao;
		      	    $oDadosPercDesconto->codUnidadeSub          = " ";
		      	    $oDadosPercDesconto->exercicioLicitacao     = str_pad($oDadosComplLicitacao->getAttribute('ano'), 4, "0", STR_PAD_LEFT);
		      	    $oDadosPercDesconto->nroProcessoLicitatorio = substr($oDadosComplLicitacao->getAttribute('codigoProcesso'), 0, 12);
		            $oDadosPercDesconto->tipoDocumento				  = $sTipoDocumento;
		            $oDadosPercDesconto->nroDocumento           = substr($oJulgLic->z01_cgccpf, 0, 14);
		            $oDadosPercDesconto->nroLote                = " ";
		            $oDadosPercDesconto->nroItem                = substr($oJulgLic->pc01_codmater, -4);
		            $oDadosPercDesconto->dscLote                = " ";
		            $oDadosPercDesconto->dscItem                = 0;
		            $oDadosPercDesconto->percDesconto           = $oDesconto->getAttribute('vldesconto');
		            $aDadosAgrupados[$sHash]->Reg20[]           = $oDadosPercDesconto;
    	 	
    	        }
    	
            }
		      
	        } else {
	        	
	        	$aDadosAgrupados[$sHash]->vlUnitario += $oJulgLic->pc23_vlrun;
	          $aDadosAgrupados[$sHash]->quantidade += $oJulgLic->pc23_quant;
	          
	        }
	        
	      
	        
		    }
      
      }
	  
    }
    foreach ($aDadosAgrupados as $oDado) {
    	
    	$oDado->vlUnitario = number_format($oDado->vlUnitario, 4, "", "");
    	$oDado->quantidade = number_format($oDado->quantidade, 4, "", "");
    	$aDado20 = $oDado->Reg20;
    	unset($oDado->Reg20);
    	$this->aDados[]      = $oDado;
    	foreach ($aDado20 as $oDado20) {
        $this->aDados[]      = $oDado20;		
    	}
    
    	
    }
    
    $sSql = "SELECT l20_codigo,l20_anousu,l11_data 
     		 from liclicita join liclicitasituacao on l20_codigo = l11_liclicita 
     		 inner join cflicita on cflicita.l03_codigo = liclicita.l20_codtipocom 
				left  join pctipocompratribunal on cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial 
			 WHERE l20_codigo in (".$sLicitacao.") and l20_instit = ".db_getsession("DB_instit")." 
			 and l11_sequencial = (SELECT max(l11_sequencial) from liclicitasituacao 
			 where l11_liclicita = l20_codigo and l44_codigotribunal in ('1','2','3','4','5','6') and l44_sequencial < 100  and l11_licsituacao = 1 group by l11_liclicita)";
    
    $rsDataJulg = db_query($sSql);
    
    for ($iCont = 0; $iCont < pg_num_rows($rsDataJulg); $iCont++) {
    
      $oDataJulg = db_utils::fieldsMemory($rsDataJulg, $iCont);
      
      foreach ($oDadosComplLicitacoes as $oDadosComplLicitacao) {
			
		    if ($oDadosComplLicitacao->getAttribute('instituicao') == db_getsession("DB_instit")
		        && $oDadosComplLicitacao->getAttribute('nroProcessoLicitatorio') == $oDataJulg->l20_codigo) {
	      
	        $oDadosDataJulg = new stdClass();
	      
	        $oDadosDataJulg->tipoRegistro            = 30;
	        $oDadosDataJulg->detalhesessao 		       = 30;
	        $oDadosDataJulg->codOrgao                = $sOrgao;
	        $oDadosDataJulg->codUnidade              = " ";
	        $oDadosDataJulg->exercicioLicitacao      = str_pad($oDadosComplLicitacao->getAttribute('ano'), 4, "0", STR_PAD_LEFT);
	        $oDadosDataJulg->nroProcessoLicitatorio  = substr($oDadosComplLicitacao->getAttribute('codigoProcesso'), 0, 12);
	        $oDadosDataJulg->dtJulgamento            = implode(array_reverse(explode("-",$oDataJulg->l11_data)));
	        $oDadosDataJulg->PresencaLicitantes      = $oDadosComplLicitacao->getAttribute('PresencaLicitantes');
	        $oDadosDataJulg->renunciaRecurso         = 1;
	      
	        $this->aDados[] = $oDadosDataJulg;
	    
		    }
	      
      }
      
    } 
    
  }
		
  }			