<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * Pagamento das Despesas Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoPagamentosDespesas extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 172;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'OPS';
  
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
   *metodo para passar os dados das Acoes e Metas pada o $this->aDados 
   */
  public function getCampos(){
    
    $aElementos[10] = array(
                          "tipoRegistro",
                          "codOrgao",
                          "codUnidadeSub",
                          "nroOP",
                          "dtPagamento",
											    "vlOP",
											    "especificacaoOP",
											    "nomeRespPgto",
											    "cpfRespPgto"
                        );
    $aElementos[11] = array(
											    "tipoRegistro",
											    "codReduzidoOP",
    											"codUnidadeSub",
    											"nroOP",
    											"dtPagamento",
    											"tipoPagamento",
    											"nroEmpenho",
    											"dtEmpenho",
    											"nroLiquidacao",
    											"dtLiquidacao",
											    "codFontRecursos",
											    "valorFonte",
											    "tipoDocumentoCredor",
    											"nroDocumento",
    											"nomeCredor",
    											"codOrgaoEmpOP",
    											"codUnidadeEmpOP"
                        );
    $aElementos[12] = array(
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
    $aElementos[13] = array(
											    "tipoRegistro",
											    "codReduzidoOP",
											    "tipoRetencao",
											    "descricaoRetencao",
											    "vlRetencao"
                        );
    $aElementos[14] = array(
											    "tipoRegistro",
											    "codReduzidoOP",
											    "tipoVlAntecipado",
											    "descricaoVlAntecipado",
											    "vlAntecipado"
                        );
    return $aElementos;
  }
  
  /**
   * selecionar os dados dos pagamentos de despesa do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
    
  	$sSql  = "SELECT * FROM db_config ";
    $sSql .= "	WHERE prefeitura = 't'";
    	
    $rsInst = db_query($sSql);
    $sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;
  	/**
  	 * selecionar arquivo xml com dados dos orgao
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
     */
    foreach ($oOrgaos as $oOrgao) {
      
    	if ($oOrgao->getAttribute('instituicao') == db_getsession("DB_instit")) {
    		
        $sOrgao           = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
        $aINSS            = explode(";", $oOrgao->getAttribute('ctINSS'));
        $aRPPS            = explode(";", $oOrgao->getAttribute('ctRPPS'));
        $aIRRF            = explode(";", $oOrgao->getAttribute('ctIRRF'));
        $aISSQN           = explode(";", $oOrgao->getAttribute('ctISSQN'));  
        $aRepasseCamara   = explode(";", $oOrgao->getAttribute('ctRepasseCamara'));
        $sTrataCodUnidade = $oOrgao->getAttribute('trataCodUnidade');
        $sCpfOrdPag       = $oOrgao->getAttribute('cpfOrdPag');
        
    	}
    	
    }
    
    /**
  	 * selecionar arquivo xml com dados dos responsaveis
  	 */
    $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomidentresponsavel.xml";
    
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuração dos responsáveis inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oResponsaveis  = $oDOMDocument->getElementsByTagName('identresp');
    
    /**
		 * selecionar arquivo xml de dados elemento da despesa
		 */
		$sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomelementodespesa.xml";
		if (!file_exists($sArquivo)) {
		  throw new Exception("Arquivo de elemento da despesa inexistente!");
	 	}
		$sTextoXml    = file_get_contents($sArquivo);
		$oDOMDocument = new DOMDocument();
		$oDOMDocument->loadXML($sTextoXml);
		$oElementos = $oDOMDocument->getElementsByTagName('elemento');

    $sSql = "
    SELECT  c70_valor,c71_coddoc,
	c70_data as dtpagamento,
	e50_data as dtordem,
	e50_data as dtliquida,
	e50_codord as numordem,
	e50_codord as numliquida,
	e53_vlrpag as vlrordem,
	e60_codemp,
	e60_emiss as dtempenho,
	z01_nome,
	z01_cgccpf,
	o58_orgao,
	o58_unidade,
	o58_funcao,
	o58_subfuncao,
	o58_programa,
	o58_projativ,
	o56_elemento,
	substr(o56_elemento,2,2) as divida,
	o15_codtri as recurso,
	e50_obs,
	e71_codnota
from conlancam 
	join conlancamdoc on c71_codlan=c70_codlan 
	join conlancamord on c80_codlan = c71_codlan 
	join pagordem on c80_codord = e50_codord 
	join pagordemele on e53_codord = e50_codord
	join pagordemnota on e71_codord = c80_codord and e71_anulado = false
	join empempenho on e50_numemp = e60_numemp
	join cgm on e60_numcgm = z01_numcgm
	join orcdotacao on e60_coddot = o58_coddot and e60_anousu = o58_anousu
	join orcelemento on e53_codele = o56_codele and e60_anousu = o56_anousu
	join orctiporec on o58_codigo  = o15_codigo
where c71_coddoc in (5,35,37) and c71_data >= '".$this->sDataInicial."' and  c71_data <= '".$this->sDataFinal."'
    order by c70_data";
	//echo $sSql;exit;
    $rsPagamento = db_query($sSql);
   
    /*
     * passar valores de pagamentos registro 10 layout sicom
     */
    $aDadosAgrupados = array();
    $aCaracteres = array("°",chr(13),chr(10));
    for ($iCont = 0;$iCont < pg_num_rows($rsPagamento); $iCont++) {
    	
    	$oPagamento = db_utils::fieldsMemory($rsPagamento, $iCont);
    	
    	/**
    	 * pegar quantidade de extornos
    	 */
    	$sSqlExtornos = "SELECT count(*) as quant from conlancamord join conlancamdoc on c71_codlan = c80_codlan and c71_coddoc in (6,36,38) 
    	where c80_codord = {$oPagamento->numordem}";
    	$rsQuantExtornos = db_query($sSqlExtornos);
    	$iQuantExtorno   = db_utils::fieldsMemory($rsQuantExtornos, 0)->quant;
    	
    	/**
    	 * pegar quantidade de pagamentos
    	 */
    	$sSqlPagamentos = "SELECT count(*) as quant from conlancamord join conlancamdoc on c71_codlan = c80_codlan and c71_coddoc in (5,35,37) 
    	where c80_codord = {$oPagamento->numordem}";
    	$rsQuantPagamentos = db_query($sSqlPagamentos);
    	$iQuantPagamento = db_utils::fieldsMemory($rsQuantPagamentos, 0)->quant;
    	
    	if ($iQuantPagamento > $iQuantExtorno) {
	      

	    	    
        $sSql          = "SELECT z01_nome FROM cgm WHERE z01_cgccpf = '{$sCpfOrdPag}'";
        $rsResponsavel = db_query($sSql);
        $sNomeResp     = db_utils::fieldsMemory($rsResponsavel, 0)->z01_nome;
	    	
	    	$iTipoOp = " ";
	    	if ($oPagamento->c71_coddoc == 35) {
	    		$iTipoOp = 4;
	    	} else {
	    		if ($oPagamento->c71_coddoc == 37) {
	    			$iTipoOp = 5;
	    		} else {
	    		  if ($oPagamento->c71_coddoc == 5 && $oPagamento->divida == 46) {
	    			  $iTipoOp = 2;
	    		  } else {
	    		    if ($oPagamento->c71_coddoc == 5 && $oPagamento->divida != 46) {
	    			    $iTipoOp = 1;
	    		    }
	    		  }
	    		}
	    	}
	    	
	    	$iDotOrig = " ";
	    	if ($iTipoOp == 4 || $iTipoOp == 5) {
	    		
	    	  $iDotOrig  = str_pad($oPagamento->o58_orgao, 2, "0", STR_PAD_LEFT);
		    	$iDotOrig .= str_pad($oPagamento->o58_unidade, 3, "0", STR_PAD_LEFT);
		    	$iDotOrig .= str_pad($oPagamento->o58_funcao, 2, "0", STR_PAD_LEFT);
		    	$iDotOrig .= str_pad($oPagamento->o58_subfuncao, 3, "0", STR_PAD_LEFT);
		    	$iDotOrig .= str_pad($oPagamento->o58_programa, 4, "0", STR_PAD_LEFT);
		    	$iDotOrig .= substr($oPagamento->o58_projativ, 0, 1);
		    	$iDotOrig .= substr($oPagamento->o58_projativ, 1, 3);
		    	$iDotOrig .= substr($oPagamento->o56_elemento, 1, 6);
		    	$iDotOrig .= "00";	
		    	
	    	}
	    	
	    	$sHash  = "10".$iTipoOp.substr($oPagamento->numordem, 0, 9).$sOrgao.str_pad($oPagamento->o58_orgao, 2, "0", STR_PAD_LEFT);
	    	$sHash .= str_pad($oPagamento->o58_unidade, 3, "0", STR_PAD_LEFT);
	    	
	    	if (!isset($aDadosAgrupados[$sHash])) {
	    	
	    	  if ($sTrataCodUnidade == "01") {
	      		
	          $sCodUnidade  = str_pad($oPagamento->o58_orgao, 2, "0", STR_PAD_LEFT);
		   		  $sCodUnidade .= str_pad($oPagamento->o58_unidade, 3, "0", STR_PAD_LEFT);
		   		  
	        } else {
	      		
	          $sCodUnidade	= str_pad($oPagamento->o58_orgao, 3, "0", STR_PAD_LEFT);
		   	    $sCodUnidade .= str_pad($oPagamento->o58_unidade, 2, "0", STR_PAD_LEFT);
	      		
	        }
	        
	    	  $sElemento = substr($oPagamento->o56_elemento, 1, 8);
	        /**
	         * percorrer xml elemento despesa
	         */
	        foreach ($oElementos as $oElemento) {
	      	
	          if ($oElemento->getAttribute('instituicao') == db_getsession("DB_instit") 
							&& $oElemento->getAttribute('elementoEcidade') == $sElemento) {
								
	      	    $sElemento = $oElemento->getAttribute('elementoSicom'); 
	      	    break;	
	      	    
	      	  }
	      	
	        }
	        
	        if (!$oPagamento->e50_obs) { 
	        	$sEspecificacaoOp = "S/H";
	        } else {
	          $sEspecificacaoOp = substr(str_replace($aCaracteres, "", $oPagamento->e50_obs), 0, 200);
	        }
	    		
	    		$oDadosPagamento = new stdClass();
	    	
		    	$oDadosPagamento->tipoRegistro        = 10;
		    	$oDadosPagamento->detalhesessao       = 10;
		    	$oDadosPagamento->codOrgao            = $sOrgao;
		    	$oDadosPagamento->codUnidadeSub       = $sCodUnidade;
		    	$oDadosPagamento->nroOP               = substr($oPagamento->numordem, 0, 9);
		    	$oDadosPagamento->dtPagamento         = implode(array_reverse(explode("-", $oPagamento->dtpagamento)));
		    	$oDadosPagamento->vlOP                = number_format($oPagamento->vlrordem, 2, "", "");
		    	$oDadosPagamento->especificacaoOP     = $sEspecificacaoOp;
		    	$oDadosPagamento->nomeRespPgto        = substr($sNomeResp, 0, 50);
		    	$oDadosPagamento->cpfRespPgto         = $sCpfOrdPag;
		    	$oDadosPagamento->Reg11               = array();
		    	$oDadosPagamento->Reg12               = array();
		    	$oDadosPagamento->Reg13               = array();
		    	
		    	/**
	    	   *registro 11
	    	   */
		    	$iTipoPagamento = 0;
		    	if ($oPagamento->c71_coddoc == 5 && $oPagamento->divida != 46) { 
		    		$iTipoPagamento = 1;
		    	} else {//1 se não recebe 2;
		    		
		    		if ($oPagamento->c71_coddoc == 35) {
		    			$iTipoPagamento = 3;
		    		} else {
		    			
		    			if ($oPagamento->c71_coddoc == 37) {
		    				$iTipoPagamento = 4;
		    			} else {
		    			  $iTipoPagamento = 2;
		    		  }
		    			
		    		} 
		    		
		    	} 
		    	
	    	  $oDadosPagamentoFonte = new stdClass();
	    	
		    	$oDadosPagamentoFonte->tipoRegistro    		 = 11;
		    	$oDadosPagamentoFonte->detalhesessao   		 = 11;
		    	$oDadosPagamentoFonte->codReduzidoOP   		 = substr($oPagamento->numordem, 0, 15);
		    	$oDadosPagamentoFonte->codUnidadeSub   		 = $sCodUnidade;
		    	$oDadosPagamentoFonte->nroOP           		 = substr($oPagamento->numordem, 0, 9);
		    	$oDadosPagamentoFonte->dtPagamento     		 = implode(array_reverse(explode("-", $oPagamento->dtpagamento)));
		    	$oDadosPagamentoFonte->tipoPagamento   		 = $iTipoPagamento;
		    	$oDadosPagamentoFonte->nroEmpenho      		 = substr($oPagamento->e60_codemp, 0, 22);
		    	$oDadosPagamentoFonte->dtEmpenho       	   	 = implode(array_reverse(explode("-", $oPagamento->dtempenho)));
		    	$oDadosPagamentoFonte->nroLiquidacao   		 = substr($oPagamento->e71_codnota, 0, 9);
		    	$oDadosPagamentoFonte->dtLiquidacao    		 = implode(array_reverse(explode("-", $oPagamento->dtliquida)));
		    	$oDadosPagamentoFonte->codFontRecursos       = substr($oPagamento->recurso, 0, 3);
		    	$oDadosPagamentoFonte->valorFonte            = number_format($oPagamento->c70_valor, 2, "", "");
		    	$oDadosPagamentoFonte->tipoDocumentoCredor   = strlen($oPagamento->z01_cgccpf) == 11 ? 1 : 2;
		    	$oDadosPagamentoFonte->nroDocumento          = $oPagamento->z01_cgccpf;
		    	$oDadosPagamentoFonte->nomeCredor            = utf8_decode(substr($oPagamento->z01_nome, 0, 120)); 
		    	$oDadosPagamentoFonte->codOrgaoEmpOP       	 = " ";
		    	$oDadosPagamentoFonte->codUnidadeEmpOP       = " ";	
		    	
		    	$oDadosPagamento->Reg11[] = $oDadosPagamentoFonte;
		    	
	    	/**
	    	 *registro 12
	    	 */
	    	$sSql = "select e91_ativo,e50_codord,e50_data,c63_banco,c63_agencia,c63_dvagencia,c63_conta,c63_dvconta,k12_valor,k12_cheque, e96_codigo, e96_descr
	from empagemov 
	inner join empage on empage.e80_codage = empagemov.e81_codage 
	inner join empord on empord.e82_codmov = empagemov.e81_codmov 
	inner join empempenho on empempenho.e60_numemp = empagemov.e81_numemp 
	left join empagemovforma on empagemovforma.e97_codmov = empagemov.e81_codmov 
	left join empageforma on empageforma.e96_codigo = empagemovforma.e97_codforma
	left join empagepag on empagepag.e85_codmov = empagemov.e81_codmov 
	left join empagetipo on empagetipo.e83_codtipo = empagepag.e85_codtipo 
	left join empageconf on empageconf.e86_codmov = empagemov.e81_codmov 
	left join empageconfgera on empageconfgera.e90_codmov = empagemov.e81_codmov and empageconfgera.e90_cancelado = 'f'
	left join saltes on saltes.k13_conta = empagetipo.e83_conta 
	left join empagegera on empagegera.e87_codgera = empageconfgera.e90_codgera 
	left join empagedadosret on empagedadosret.e75_codgera = empagegera.e87_codgera 
	left join empagedadosretmov on empagedadosretmov.e76_codret = empagedadosret.e75_codret 
	and empagedadosretmov.e76_codmov = empagemov.e81_codmov 
	left join empagedadosretmovocorrencia on empagedadosretmovocorrencia.e02_empagedadosretmov = empagedadosretmov.e76_codmov 
	and empagedadosretmovocorrencia.e02_empagedadosret = empagedadosretmov.e76_codret 
	left join errobanco on errobanco.e92_sequencia = empagedadosretmovocorrencia.e02_errobanco
	left join empageconfche on empageconfche.e91_codmov = empagemov.e81_codmov and empageconfche.e91_ativo is true
	left join corconf on corconf.k12_codmov = empageconfche.e91_codcheque and corconf.k12_ativo is true 
	left join corempagemov on corempagemov.k12_codmov = empagemov.e81_codmov 
	left join pagordemele on e53_codord = empord.e82_codord 
	left join empagenotasordem on e43_empagemov = e81_codmov
	left join coremp on coremp.k12_id = corempagemov.k12_id
	and coremp.k12_data = corempagemov.k12_data
	and coremp.k12_autent = corempagemov.k12_autent
	join pagordem on e50_numemp = k12_empen and k12_codord  = e50_codord
	    join corrente on coremp.k12_autent = corrente.k12_autent 
	and coremp.k12_data = corrente.k12_data 
	and coremp.k12_id = corrente.k12_id 
	and corrente.k12_estorn != true
	      join conplanoreduz on c61_reduz = k12_conta and c61_anousu = ".db_getsession("DB_anousu")."
	      join conplano on c61_codcon = c60_codcon 
	and c61_anousu = c60_anousu
	      left join conplanoconta on c63_codcon = c60_codcon 
	and c60_anousu = c63_anousu
	      join corgrupocorrente cg on cg.k105_autent = corrente.k12_autent 
	and cg.k105_data = corrente.k12_data 
	and cg.k105_id = corrente.k12_id
	where k105_corgrupotipo != 2 and e80_instit = ".db_getsession("DB_instit")." and k12_codord = {$oPagamento->numordem} and e81_cancelado is null";
	    	
	    	
	    	$rsMovimentacao = db_query($sSql);
	    	/**
	       * passar valores de movimentações registro 12 layout sicom
	       */
	      for ($iCont2 = 0; $iCont2 < pg_num_rows($rsMovimentacao); $iCont2++) {
	      	
	      	$oMovimentacao = db_utils::fieldsMemory($rsMovimentacao, $iCont2);
	      	
	      	$sTipoDocumentoOP = " ";
	      	$sNroDocumento    = " ";
	      	$sBanco           = str_pad($oMovimentacao->c63_banco, 3, "0", STR_PAD_LEFT);
	      	if ($oMovimentacao->e96_codigo == 2) {
	      		$sTipoDocumentoOP = "01";
	      		$sNroDocumento    = $oMovimentacao->k12_cheque;
	      	} else {
	      		
	      	  if ($oMovimentacao->e96_codigo == 1) {
	      	  	
	      		  $sTipoDocumentoOP = "05";
	      		  $sBanco           = " ";
	      		  
	      	  }	else {
	      	  	$sTipoDocumentoOP = "99";
	      	  }
	      	  
	      	}
	      	
	      	$oDadosMovimentacao = new stdClass();
	      	
	      	$oDadosMovimentacao->tipoRegistro                   = 12;
	      	$oDadosMovimentacao->detalhesessao                  = 12;
	      	$oDadosMovimentacao->codReduzidoOP                  = substr($oMovimentacao->e50_codord, 0, 15);
	      	$oDadosMovimentacao->tipoDocumentoOP                = $sTipoDocumentoOP;
	      	$oDadosMovimentacao->nroDocumento                   = $sNroDocumento;
	      	$oDadosMovimentacao->banco                          = $sBanco;
	      	$oDadosMovimentacao->agencia                        = substr($oMovimentacao->c63_agencia, 0, 6);
	      	$oDadosMovimentacao->digitoVerificadorAgencia       = substr($oMovimentacao->c63_dvagencia, 0, 2);
	      	$oDadosMovimentacao->contaCorrente                  = substr($oMovimentacao->c63_conta, 0, 12);
	      	$oDadosMovimentacao->digitoVerificadorContaBancaria = substr($oMovimentacao->c63_dvconta, 0, 2);
	      	$oDadosMovimentacao->dtEmissao                      = implode(array_reverse(explode("-", $oMovimentacao->e50_data)));
	      	$oDadosMovimentacao->vlDocumento                    = number_format($oMovimentacao->k12_valor, 2, "", "");
	      	
	      	$oDadosPagamento->Reg12[] = $oDadosMovimentacao;
	      	
	      }
	      
	      $sSql = "SELECT e21_receita, e20_pagordem, e23_valorretencao, e21_descricao, e21_retencaotipocalc
		from retencaopagordem
		join retencaoreceitas on  e23_retencaopagordem = e20_sequencial 
		join retencaotiporec on e23_retencaotiporec = e21_sequencial
	where e23_ativo = true and e20_pagordem = ".$oPagamento->numordem;
	      
	      $rsRetencao = db_query($sSql);
	      
	      /*
	       * passar valores de retenções registro 13 layout sicom
	       */
	      $aDadosAgrupadosReg13 = array();
	      for ($iCont3 = 0; $iCont3 < pg_num_rows($rsRetencao); $iCont3++) {
	      	
	      	$oRetencao = db_utils::fieldsMemory($rsRetencao, $iCont3);
	      	
	      	$sSqlCodReduzido = "SELECT tp.k02_reduz,t.k02_codigo from tabrec t
	        left join tabplan tp on t.k02_codigo = tp.k02_codigo where tp.k02_codigo = ".$oRetencao->e21_receita."
	        and tp.k02_anousu = ".db_getsession("DB_anousu");
	      	
	      	
	      	$rsCodReduzido = db_query($sSqlCodReduzido);
	      	$oCodReduzido  = db_utils::fieldsMemory($rsCodReduzido, 0);
	      	
	      	$sTipoRetencao = str_pad($oCodReduzido->k02_codigo, 4, "0", STR_PAD_LEFT);
	      	$sDescricaoRetencao = substr($oRetencao->e21_descricao, 0, 50);
	      	
	      	if ($oRetencao->e21_retencaotipocalc == 1 || $oRetencao->e21_retencaotipocalc == 2 ) {
	      		
	      		$sTipoRetencao = "0003";
	      		$sDescricaoRetencao = " ";
	      		
	      	} else {
	      		
	      		if ($oRetencao->e21_retencaotipocalc == 3 
	      		    || $oRetencao->e21_retencaotipocalc == 4 
	      		    || $oRetencao->e21_retencaotipocalc == 7) {
	      		    	
	      		      $sTipoRetencao = "0001";
	      		      $sDescricaoRetencao = " ";
	      		      
	      		    } else {
	      		    	
	      		      if ($oRetencao->e21_retencaotipocalc == 5) {
	      		        
	      		      	$sTipoRetencao = "0004";
	      		        $sDescricaoRetencao = " ";
	      		        
	      	        } else {
	      	
						      	/**
						   	  	 * percorrer array de conta
						   	  	 */
						   	  	foreach ($aINSS as $iINSS) {
						   	  			
						   	  		if ($oCodReduzido->k02_reduz == $iINSS) {
						   	  				
						   	  			$sTipoRetencao = "0001";
						   	  			$sDescricaoRetencao = " ";
						   	  			break;
						   	  				
						   	  		}
						   	  			
						   	  	}
						   	  	/**
						   	  	 * percorrer array de conta
						   	  	 */
						   	  	foreach ($aRPPS as $iRPPS) {
						   	  			
						   	  		if ($oCodReduzido->k02_reduz == $iRPPS) {
						   	  				
						   	  			$sTipoRetencao = "0002";
						   	  			$sDescricaoRetencao = " ";
						   	  			break;
						   	  				
						   	  		}
						   	  			
						   	  	}
						   	  	/**
						   	  	 * percorrer array de conta
						   	  	 */
						   	  	foreach ($aIRRF as $iIRRF) {
						   	  		
						   	  		if ($oCodReduzido->k02_reduz == $iIRRF) {
						   	  				
						   	  			$sTipoRetencao = "0003";
						   	  			$sDescricaoRetencao = " ";
						   	  			break;
						   	  				
						   	  		}
						   	  			
						   	  	} 
						   	  	/**
						   	  	 * percorrer array de conta
						   	  	 */
						   	  	foreach ($aISSQN as $iISSQN) {
						   	  			
						   	  		if ($oCodReduzido->k02_reduz == $iISSQN) {
						   	  				
						   	  			$sTipoRetencao = "0004";
						   	  			$sDescricaoRetencao = " ";
						   	  			break;
						   	  				
						   	  		}
						   	  			
						   	  	} 	
					      	
					      	}
	      		    	
	      		    }
	      		
	      	} 
	
	      	$sHashReg13 = "13".substr($oRetencao->e20_pagordem, 0, 15).$sTipoRetencao;
	      	
	      	if (!isset($aDadosAgrupadosReg13[$sHashReg13])) {
	      		
		        $oDadosRetencao = new stdClass();
		      	
		      	$oDadosRetencao->tipoRegistro      = 13;
		      	$oDadosRetencao->detalhesessao     = 13;
		      	$oDadosRetencao->codReduzidoOP     = substr($oRetencao->e20_pagordem, 0, 15);
		      	$oDadosRetencao->tipoRetencao      = $sTipoRetencao;
		      	$oDadosRetencao->descricaoRetencao = $sDescricaoRetencao;
		      	$oDadosRetencao->vlRetencao        = number_format($oRetencao->e23_valorretencao, 2, "", ""); 
		
		      	$aDadosAgrupadosReg13[$sHashReg13] = $oDadosRetencao;
	      	
	      	} else {
	      		$aDadosAgrupadosReg13[$sHashReg13]->vlRetencao += number_format($oRetencao->e23_valorretencao, 2, "", "");
	      	}
	      	
	      }
	      	
	      foreach ($aDadosAgrupadosReg13 as $oDadosAgrupadosReg13) {
	      	$oDadosPagamento->Reg13[] = $oDadosAgrupadosReg13;
	      }
		    	
		    $aDadosAgrupados[$sHash] = $oDadosPagamento;
		    	
	    	} else {
	    		
	    		$dData  = substr($aDadosAgrupados[$sHash]->dtpagamento, 0, 2);
	    		$dData .= "/";
	    		$dData .= substr($aDadosAgrupados[$sHash]->dtpagamento, 2, 2);
	    		$dData .= "/";
	    		$dData .= substr($aDadosAgrupados[$sHash]->dtpagamento, 4, 4);
	    		
	    		$dData = implode("-", array_reverse(explode("/", $dData)));
	    		
	    		if ($oPagamento->dtpagamento > $dData) {
	    			$aDadosAgrupados[$sHash]->dtpagament = implode(array_reverse(explode("-", $oPagamento->dtpagamento)));
	    		}
	    		//$aDadosAgrupados[$sHash]->vlOP                += number_format($oPagamento->c70_valor, 2, "", "");
	    	}
    	
      }
    	
    }
    
  	/**
	   * o repeditção ocorrerá para cada linha do array $aDadosAgrupados passando a linha do registro 10 a ser gerada
	   */
	  foreach ($aDadosAgrupados as $oDado) {
	
	    $oDadosPagamentos = clone $oDado;
	    unset($oDadosPagamentos->Reg11);
	    unset($oDadosPagamentos->Reg12);
	    unset($oDadosPagamentos->Reg13);
	    if ($oDadosPagamentos->tipoOP == 4 || $oDadosPagamentos->tipoOP == 5) {

		    $oDadosPagamentos->codFuncao           = " ";
		    $oDadosPagamentos->codSubFuncao        = " ";
		    $oDadosPagamentos->codPrograma         = " ";
		    $oDadosPagamentos->idAcao              = " ";
		    $oDadosPagamentos->elementoDespesa     = " ";
		    $oDadosPagamentos->subElemento         = " ";

	    }
	    $this->aDados[] = $oDadosPagamentos;
	    /**
	     * a repetição adicionará os registros tipo 11 abaixo do registro tipo 10 correspondente para serem gravados no arquivo
	     */
	    foreach ($oDado->Reg11 as $oRegistro) {
	    	
    		$oRegistro->valorFonte = $oDadosPagamentos->vlOP;
	      $this->aDados[] = $oRegistro;
	      
	    }
	  	/**
	     * a repetição adicionará os registros tipo 12 abaixo do registro tipo 10 correspondente para serem gravados no arquivo
	     */
	    foreach ($oDado->Reg12 as $oRegistro) {
	      $this->aDados[] = $oRegistro;
	    }
	  	/**
	     * a repetição adicionará os registros tipo 13 abaixo do registro tipo 10 correspondente para serem gravados no arquivo
	     */
	    foreach ($oDado->Reg13 as $oRegistro) {
	      $this->aDados[] = $oRegistro;
	    }
	    
	  }
	    
  }
		
}