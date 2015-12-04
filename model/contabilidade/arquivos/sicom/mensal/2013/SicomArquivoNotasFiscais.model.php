<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * selecionar dados de Notas Fiscais Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoNotasFiscais extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
  /**
   * 
   * Codigo do layout
   * @var Integer
   */
  protected $iCodigoLayout = 174;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'NTF';
  
  /**
   * 
   * Contrutor da classe
   */
  public function __construct() {
    
  }
  
  /**
   * retornar o codio do layout
   * 
   *@return Integer
   */
  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   *@return Array 
   */
  public function getCampos(){
    
    $aElementos[10] = array(
                          "tipoRegistro",
                          "codNotaFiscal",
                          "codOrgao",
                          "nfNumero",
                          "nfSerie",
                          "tipoDocumento",
                          "nroDocumento",
                          "nomeCredor",
                          "nroInscEstadual",
                          "nroInscMunicipal",
                          "nomeMunicipio",
                          "cepMunicipio",
                          "ufCredor",
                          "notaFiscalEletronica",
											    "chaveAcesso",
                          "chaveAcessoMunicipal",
											    "nfAIDF",
											    "dtEmissaoNF",
											    "dtVencimentoNF",
											    "nfValorTotal",
											    "nfValorDesconto",
											    "nfValorLiquido"
                        );
    $aElementos[11] = array(
                          "tipoRegistro",
                          "codNotaFiscal",
                          "descricaoItem",
                          "quantidadeItem",
    											"valorUnitarioItem",
    											"unidade"
                        );
    $aElementos[12] = array(
                          "tipoRegistro",
											    "codNotaFiscal",
											    "codUnidadeSub",
											    "dtEmpenho",
											    "nroEmpenho",
											    "dtLiquidacao",
											    "nroLiquidacao"
    );
    return $aElementos;
  }
  
  /**
   * selecionar os dados de Notas Fiscais referentes a instituicao logada
   * 
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
    		
        $sOrgao           = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
        $sTrataCodUnidade = $oOrgao->getAttribute('trataCodUnidade');
        
    	}
    	
    }
  
    if (!isset($oOrgao)) {
      throw new Exception("Arquivo sem configuração de Orgãos.");
    }
    
    $sSql  = "SELECT e69_codnota, e69_numero, e69_dtnota,z01_numcgm, z01_nome,z01_cgccpf, z01_incest, z01_munic, z01_cep, z01_uf, "; 
    $sSql .= "(SELECT sum(e72_vlrliq) from empnotaitem where e72_codnota = e69_codnota) as valortotal, e50_data from empnota ";
    $sSql .= "join empempenho on e69_numemp = e60_numemp join cgm on e60_numcgm = z01_numcgm ";
    $sSql .= "join pagordemnota on e71_codnota = e69_codnota and e71_anulado = false ";
    $sSql .= "join pagordem on e50_codord = e71_codord ";
    $sSql .= "where e69_dtnota >= '".$this->sDataInicial."' and e69_dtnota <= '".$this->sDataFinal."' ";
    $sSql .= "and e50_data between '".$this->sDataInicial."' and '".$this->sDataFinal."' ";
    $sSql .= "and e60_instit = ".db_getsession("DB_instit")." and e60_anousu = ".db_getsession("DB_anousu");
    $sSql .= " order by e69_numero";
    
    $rsNota = db_query($sSql);
    
    /**
     * passar os dados da das notas para o arquivo
     */
    $aDadosAgrupados = array();
    for ($iCont = 0; $iCont < pg_num_rows($rsNota); $iCont++) {
    	
    	$oNota  = db_utils::fieldsMemory($rsNota, $iCont);
    	
    	if (is_numeric($oNota->e69_numero) && $oNota->valortotal > 0) {
    	
	    	if (strlen($oNota->z01_cgccpf) == 11) {
	    		$iTipoDocumento = 1;
	    	} else {
	    		$iTipoDocumento = 2;
	    	}
	    	
	    	/**
	    	 * Colocando a data de um ano após lançamento na
	    	 * data de vencimento da nota
	    	 */
	    	$dData    = explode("-", $oNota->e69_dtnota);
	    	$dData[0] = $dData[0]+1;
	    	
	    	$sResp = checkdate($dData[1],$dData[2],$dData[0]);
	    	
	    	if ($sResp == 1) {
	    		$dDtVencimentoNF = implode(array_reverse($dData));
	    	} else {
	    		
	    		$dData[1] = $dData[1]+1;
	    		$dData[2] = "01";
	    		$dDtVencimentoNF = implode(array_reverse($dData));
	    		
	    	}
	    	
	    	$sHashReg10 = substr($oNota->e69_numero, 0, 20).substr($oNota->z01_cgccpf, 0, 14);
	    	
	    	if (!$aDadosAgrupados[$sHashReg10]) {
	    	    	
	    	  $iInscEstadual = str_replace($aCaracteres, "", substr($oNota->z01_incest, 0, 15));
	    	  
	    	  $sSqlEnder = "select  z07_sequencial as icgmendereco, db74_descricao as sRua, db75_numero as sNumero, 
	    	  db73_descricao as sbairro  ,db76_sequencial as iendereco , z07_tipo as stipo, db71_sigla as ssigla, 
	    	  db72_descricao as smunicipio  ,db76_complemento as scomplemento from cadenderlocal       
	    	  inner join cadenderbairrocadenderrua  on cadenderbairrocadenderrua.db87_sequencial = cadenderlocal.db75_cadenderbairrocadenderrua  
	    	  inner join cadenderbairro  on  cadenderbairro.db73_sequencial = cadenderbairrocadenderrua.db87_cadenderbairro 
	    	  inner join cadenderrua     on  cadenderrua.db74_sequencial = cadenderbairrocadenderrua.db87_cadenderrua 
	    	  inner join endereco        on  endereco.db76_cadenderlocal = cadenderlocal.db75_sequencial 
	    	  inner join cadenderruaruastipo on cadenderruaruastipo.db85_cadenderrua = cadenderrua.db74_sequencial 
	    	  inner join cgmendereco     on cgmendereco.z07_endereco = endereco.db76_sequencial inner join cadendermunicipio 
	    	  on cadendermunicipio.db72_sequencial = cadenderrua.db74_cadendermunicipio 
	    	  inner join cadenderestado on cadenderestado.db71_sequencial = cadendermunicipio.db72_cadenderestado  
	    	  where  z07_numcgm = {$oNota->z01_numcgm} order by z07_tipo";
	    	  
	    	  $rsResultEnder = db_query($sSqlEnder);
	    	  $oEnder = db_utils::fieldsMemory($rsResultEnder, 0);

		    	$oDadosNota = new stdClass();
		    	
		    	$aCaracteres = array(".","-","/");
		    	$oDadosNota->tipoRegistro         = 10;
		    	$oDadosNota->detalhesessao        = 10;
		    	$oDadosNota->codNotaFiscal        = substr($oNota->e69_codnota, 0, 15);
		    	$oDadosNota->codOrgao             = $sOrgao;
		    	$oDadosNota->nfNumero             = substr($oNota->e69_numero, 0, 20);
		    	$oDadosNota->nfSerie              = "A";
		    	$oDadosNota->tipoDocumento        = $iTipoDocumento;
		    	$oDadosNota->nroDocumento         = substr($oNota->z01_cgccpf, 0, 14);
		    	$oDadosNota->nomeCredor           = substr($oNota->z01_nome, 0, 120);
		    	$oDadosNota->nroInscEstadual      = is_int($iInscEstadual)==true?$iInscEstadual:" ";
		    	$oDadosNota->nroInscMunicipal     = " ";
		    	$oDadosNota->nomeMunicipio        = substr($oNota->z01_munic==''?$oEnder->smunicipio:$oNota->z01_munic, 0, 120);
		    	$oDadosNota->cepMunicipio         = substr($oNota->z01_cep, 0, 8);
		    	$oDadosNota->ufCredor             = substr($oNota->z01_uf, 0, 2);
		    	$oDadosNota->notaFiscalEletronica = "3";
		    	$oDadosNota->chaveAcesso          = " ";
		    	$oDadosNota->chaveAcessoMunicipal = " ";
		    	$oDadosNota->nfAIDF               = " ";
		    	$oDadosNota->dtEmissaoNF          = implode(array_reverse(explode("-", $oNota->e69_dtnota)));
		    	$oDadosNota->dtVencimentoNF       = $dDtVencimentoNF;
		    	$oDadosNota->nfValorTotal         = $oNota->valortotal;
		    	$oDadosNota->nfValorDesconto      = "000";
		    	$oDadosNota->nfValorLiquido       = $oNota->valortotal;
		    	$oDadosNota->aDadosReg11          = array();
		    	$oDadosNota->aDadosReg12          = array();
		    	
		    	$aDadosAgrupados[$sHashReg10] = $oDadosNota;
	    	   	
	    	} else {

	    	  $aDadosAgrupados[$sHashReg10]->nfValorTotal         += $oNota->valortotal;
		      //$this->aDados[$iPosicaoArray]->nfValorDesconto      += number_format(0, 2, "", "");
		      $aDadosAgrupados[$sHashReg10]->nfValorLiquido       += $oNota->valortotal;
		    
	    	}
	    	
	      $sSql  = "SELECT e69_codnota,pc01_descrmater,e72_qtd,e72_vlrliq,pc01_codmater ";  
		    $sSql .= "from empnota join empnotaitem on e69_codnota = e72_codnota ";
		    $sSql .= "join  empempitem on e72_empempitem = e62_sequencial ";
		    $sSql .= "join pcmater on e62_item = pc01_codmater ";
		    $sSql .= "join empempenho on e69_numemp = e60_numemp ";
		    $sSql .= "join pagordemnota on e71_codnota = e69_codnota and e71_anulado = false "; 
		    $sSql .= "where e69_dtnota >= '".$this->sDataInicial."' and e69_dtnota <= '".$this->sDataFinal."' "; 
		    $sSql .= "and e60_instit = ".db_getsession("DB_instit")." and e60_anousu = ".db_getsession("DB_anousu");
		    $sSql .= " and e69_codnota = ".$oNota->e69_codnota;
	    	
		    $rsItensNota = db_query($sSql);
		
		    /*
		     * passar os dados dos itens das notas para o arquivo
		     */
		    for ($iCont2 = 0; $iCont2 < pg_num_rows($rsItensNota); $iCont2++) {
		    		
		      $oItensNota = db_utils::fieldsMemory($rsItensNota, $iCont2);

		      $sHashReg11 = $oItensNota->pc01_descrmater;
		      if (!$aDadosAgrupados[$sHashReg10]->aDadosReg11[$sHashReg11]) {
		    	
		      	$oDadosItens = new stdClass();
		
			    	$oDadosItens->tipoRegistro      = 11;
			    	$oDadosItens->detalhesessao     = 11;
			    	$oDadosItens->codNotaFiscal     = $aDadosAgrupados[$sHashReg10]->codNotaFiscal;
			    	$oDadosItens->descricaoItem     = substr($oItensNota->pc01_descrmater, 0, 50);
			    	$oDadosItens->quantidadeItem    = $oItensNota->e72_qtd;
			    	$oDadosItens->valorUnitarioItem = $oItensNota->e72_vlrliq;
			    	$oDadosItens->unidade           = "UNIDADE";
			    	
			    	$aDadosAgrupados[$sHashReg10]->aDadosReg11[$sHashReg11] = $oDadosItens;
		    	
		      } else {
		      	
		      	$aDadosAgrupados[$sHashReg10]->aDadosReg11[$sHashReg11]->quantidadeItem    += $oItensNota->e72_qtd;
		      	$aDadosAgrupados[$sHashReg10]->aDadosReg11[$sHashReg11]->valorUnitarioItem += $oItensNota->e72_vlrliq;
		      	
		      }
		    	
		    }
		    
	      $sSql  = "SELECT e71_codnota,e69_codnota,o58_orgao,o58_unidade,e60_codemp,e60_numemp, e60_emiss, e71_codord, e50_data, e50_codord  "; 
		    $sSql .= "from empnota join empempenho on e60_numemp = e69_numemp ";
		    $sSql .= "join orcdotacao on e60_coddot = o58_coddot and o58_anousu = ".db_getsession("DB_anousu");
		    $sSql .= " join pagordemnota on e71_codnota = e69_codnota and e71_anulado = false ";
		    $sSql .= "join pagordem on e50_codord = e71_codord ";
		    $sSql .= "where e69_anousu = ".db_getsession("DB_anousu")." and e60_anousu = ".db_getsession("DB_anousu");
		    $sSql .= " and e69_dtnota >= '".$this->sDataInicial."' and e69_dtnota <= '".$this->sDataFinal."' ";
		    $sSql .= " and e69_codnota = ".$oNota->e69_codnota;
		    $sSql .= " and e50_data between '".$this->sDataInicial."' and '".$this->sDataFinal."'";
		    $sSql .= " order by e69_codnota";
		   
		    $rsLiqNota = db_query($sSql);
			
		    /*
		     * passar os dados de liquidação da nota para o arquivo
		     */
		    for ($iCont3 = 0; $iCont3 < pg_num_rows($rsLiqNota); $iCont3++) {
		    	
		      $oLiqNota = db_utils::fieldsMemory($rsLiqNota, $iCont3);

		      $oDadosLiqNota = new stdClass();
		      
		      if ($sTrataCodUnidade == "01") {
      		
            $sCodUnidade  = str_pad($oLiqNota->o58_orgao, 2, "0", STR_PAD_LEFT);
	   		    $sCodUnidade .= str_pad($oLiqNota->o58_unidade, 3, "0", STR_PAD_LEFT);
	   		  
          } else {
      		
            $sCodUnidade	= str_pad($oLiqNota->o58_orgao, 3, "0", STR_PAD_LEFT);
	   	      $sCodUnidade .= str_pad($oLiqNota->o58_unidade, 2, "0", STR_PAD_LEFT);
      		
          }
		      
		      $oDadosLiqNota->tipoRegistro    = 12;
		    	$oDadosLiqNota->detalhesessao   = 12;
		    	$oDadosLiqNota->codNotaFiscal   = $aDadosAgrupados[$sHashReg10]->codNotaFiscal;
		    	$oDadosLiqNota->codUnidadeSub   = $sCodUnidade;
		    	$oDadosLiqNota->dtEmpenho       = implode(array_reverse(explode("-", $oLiqNota->e60_emiss)));
		    	$oDadosLiqNota->nroEmpenho      = substr($oLiqNota->e60_codemp, 0, 22);
		    	$oDadosLiqNota->dtLiquidacao    = implode(array_reverse(explode("-", $oLiqNota->e50_data)));
		    	$oDadosLiqNota->nroLiquidacao   = $oLiqNota->e71_codnota;
		    	
		    	$aDadosAgrupados[$sHashReg10]->aDadosReg12[] = $oDadosLiqNota;;
		    	
		    }
	    	
	    }
    } 
    
    
    foreach ($aDadosAgrupados as $oDados) {
    			
      $aDadosReg11 = $oDados->aDadosReg11;
      $aDadosReg12 = $oDados->aDadosReg12;
      unset($oDados->aDadosReg11);
      unset($oDados->aDadosReg12);
      
      $oDados->nfValorTotal    = number_format($oDados->nfValorTotal, 2, "", "");
		  $oDados->nfValorLiquido  = number_format($oDados->nfValorLiquido, 2, "", "");
      $this->aDados[] = $oDados;
      
      foreach ($aDadosReg11 as $oDadosReg11) {
      	
      	$oDadosReg11->quantidadeItem    = number_format($oDadosReg11->quantidadeItem, 4, "", "");
			  $oDadosReg11->valorUnitarioItem = number_format($oDadosReg11->valorUnitarioItem, 4, "", "");
      	$this->aDados[] = $oDadosReg11;
      	
      }
      
      foreach ($aDadosReg12 as $oDadosReg12) {
      	
      	$this->aDados[] = $oDadosReg12;
      	
      }
    			
    }
    
  }
}