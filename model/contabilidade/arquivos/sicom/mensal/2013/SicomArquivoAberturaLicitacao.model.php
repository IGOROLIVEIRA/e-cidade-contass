<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

/**
 * Abertura da licitacao Sicom Acompanhamento Mensal
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoAberturaLicitacao extends SicomArquivoBase implements iPadArquivoBaseCSV {

	/**
	 *
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
	protected $iCodigoLayout = 154;

	/**
	 *
	 * Nome do arquivo a ser criado
	 * @var String
	 */
	protected $sNomeArquivo = 'ABERLIC';

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
                          "codOrgaoResp",
                          "codUnidadeSubResp",
                          "exercicioLicitacao",
                          "nroProcessoLicitatorio",
                          "codModalidadeLicitacao",
                          "nroModalidade",
                          "naturezaProcedimento",
                          "dtAbertura",
                          "dtEditalConvite",
											    "dtPublicacaoEditalDO",
											    "dtPublicacaoEditalVeiculo1",
											    "veiculo1Publicacao",
											    "dtPublicacaoEditalVeiculo2",
											    "veiculo2Publicacao",
											    "dtRecebimentoDoc",
											    "tipoLicitacao",
											    "naturezaObjeto",
											    "objeto",
											    "regimeExecucaoObras",
											    "nroConvidado",
											    "clausulaProrrogacao",
											    "unidadeMedidaPrazoExecucao",
											    "prazoExecucao",
											    "formaPagamento",
    											"criterioAceitabilidade",
    											"descontoTabela"
    											);
    $aElementos[11] = array(
											    "tipoRegistro",
											    "codOrgaoResp",
											    "codUnidadeSubResp",
											    "exercicioLicitacao",
    											"nroProcessoLicitatorio",
    											"nroLote",
    											"nroItem",
    											"dtCotacao",
    											"dscItem",
    											"vlCotPrecosUnitario",
    											"quantidade",
    											"unidade",
    											"vlMinAlienBens"
    											);
    $aElementos[12] = array(
                          "tipoRegistro",
                          "codOrgaoResp",
                          "codUnidadeSubResp",
                          "exercicioLicitacao",
    											"nroProcessoLicitatorio",
											    "nroLote",
											    "nroItem",
											    "dscItem",
											    "vlItem"
											    );
	  $aElementos[13] = array(
											    "tipoRegistro",
											    "codOrgaoResp",
											    "codUnidadeSubResp",
											    "exercicioLicitacao",
											    "nroProcessoLicitatorio",
    											"codOrgao",
    											"codUnidadeSub",
    											"codFuncao",
    											"codSubFuncao",
    											"codPrograma",
    											"idAcao",
	  											"idSubAcao",
    											"elementoDespesa",
    											"codFontRecursos",
    											"vlRecurso"
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
				$sTrataCodUnidade = $oOrgao->getAttribute('trataCodUnidade');
				
			}

		}

		/**
		 * selecionar arquivo xml de credenciamento
		 */
		$sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomcredenciamento.xml";
		if (!file_exists($sArquivo)) {
			throw new Exception("Arquivo de credenciamentos inexistente!");
		}
		$sTextoXml    = file_get_contents($sArquivo);
		$oDOMDocument = new DOMDocument();
		$oDOMDocument->loadXML($sTextoXml);
		$oCredenciamentos = $oDOMDocument->getElementsByTagName('credenciamento');

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
		 * selecionar arquivo xml de Preço Médio
		 */
		$sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomprecomedio.xml";
		if (!file_exists($sArquivo)) {
			throw new Exception("Arquivo de Preco medio inexistente!");
		}
		$sTextoXml    = file_get_contents($sArquivo);
		$oDOMDocument = new DOMDocument();
		$oDOMDocument->loadXML($sTextoXml);
		$oPrecosMedios = $oDOMDocument->getElementsByTagName('precomedio');

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
			&& $dDtHomologacao <= $this->sDataFinal){
				$aLicitacao[] = $oHomologacao->getAttribute('nroProcessoLicitatorio');
			}
				
		}
		$sLicitacao = implode(",", $aLicitacao);

		$sSql = "select l20_codigo,l44_codigotribunal,l20_anousu,l20_numero,l20_dataaber,l20_datacria,l20_dtpublic,l20_objeto,l03_pctipocompratribunal, l20_usaregistropreco
	from liclicita 
		inner join db_config on db_config.codigo = liclicita.l20_instit 
		inner join db_usuarios on db_usuarios.id_usuario = liclicita.l20_id_usucria 
		inner join cflicita on cflicita.l03_codigo = liclicita.l20_codtipocom 
		left join pctipocompratribunal on cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial
		inner join liclocal on liclocal.l26_codigo = liclicita.l20_liclocal 
		inner join liccomissao on liccomissao.l30_codigo = liclicita.l20_liccomissao 
		inner join licsituacao on licsituacao.l08_sequencial = liclicita.l20_licsituacao 
		inner join cgm on cgm.z01_numcgm = db_config.numcgm 
		inner join db_config as dbconfig on dbconfig.codigo = cflicita.l03_instit 
		inner join pctipocompra on pctipocompra.pc50_codcom = cflicita.l03_codcom 
		inner join bairro on bairro.j13_codi = liclocal.l26_bairro 
		inner join ruas on ruas.j14_codigo = liclocal.l26_lograd 
		left join liclicitaproc on liclicitaproc.l34_liclicita = liclicita.l20_codigo 
		left join protprocesso on protprocesso.p58_codproc = liclicitaproc.l34_protprocesso 
where l20_codigo in (".$sLicitacao.") and l20_licsituacao in (1) and l44_codigotribunal in ('1','2','3','4','5','6') and l44_sequencial < 100
 and l20_instit = ".db_getsession("DB_instit");

		$rsConvites = db_query($sSql);
		/**
		 * precorrer os dados retornados pelo sql
		 */
		for ($iCont = 0; $iCont < pg_num_rows($rsConvites); $iCont++) {

			$oConvites  = db_utils::fieldsMemory($rsConvites, $iCont);

			/**
			 * percorrer dados do xml de credenciamentos
			 */
			$sLicitaCred = 0;
				
			foreach ($oCredenciamentos as $oCredenciamento) {

				if ($oCredenciamento->getAttribute('instituicao') == db_getsession("DB_instit")
				&& $oCredenciamento->getAttribute('nroProcessoLicitatorio') == $oConvites->l20_codigo) {

					$sLicitaCred = 1;
					break;

				}
					
			}

			$iNaturezaProcedimento = 1;

			if ($oConvites->l20_usaregistropreco == "t") {
				$iNaturezaProcedimento = 2;
			} else {

				if ($sLicitaCred == 1) {
					$iNaturezaProcedimento = 3;
					$iControl = $iNaturezaProcedimento;
				}

			}

			foreach ($oDadosComplLicitacoes as $oDadosComplLicitacao) {
					
				if ($oDadosComplLicitacao->getAttribute('instituicao') == db_getsession("DB_instit")
				&& $oDadosComplLicitacao->getAttribute('nroProcessoLicitatorio') == $oConvites->l20_codigo) {

					$iVerifica = 1;

					$iNaturezaObj = substr($oDadosComplLicitacao->getAttribute('naturezaObjeto'), -1, 1);
					if ($iNaturezaObj == 1) {
						$iRegimeExecObras = $oDadosComplLicitacao->getAttribute('regimeExecucaoObras');
					} else {
						$iRegimeExecObras = " ";
					}
					
					$oDadosConvites = new stdClass();

					$oDadosConvites->tipoRegistro  				      = 10;
					$oDadosConvites->detalhesessao 				      = 10;
					$oDadosConvites->codOrgaoResp  				      = $sOrgao;
					$oDadosConvites->codUnidadeSubResp		      = " ";
					$oDadosConvites->exercicioLicitacao 		    = str_pad($oDadosComplLicitacao->getAttribute('ano'), 4, "0", STR_PAD_LEFT);
					$oDadosConvites->nroProcessoLicitatorio 	  = substr($oDadosComplLicitacao->getAttribute('codigoProcesso'), 0, 12);
					$oDadosConvites->codModalidadeLicitacao 	  = str_pad($oConvites->l44_codigotribunal, 1, "0", STR_PAD_LEFT);
					$oDadosConvites->nroModalidade          	  = substr($oConvites->l20_numero, 0, 10);
					$oDadosConvites->naturezaProcedimento   	  = $iNaturezaProcedimento;
					$oDadosConvites->dtAbertura					        = implode(array_reverse(explode("-", $oConvites->l20_datacria)));
					$oDadosConvites->dtEditalConvite			      = implode(array_reverse(explode("-", $oConvites->l20_dataaber)));
					$oDadosConvites->dtPublicacaoEditalDO	   	  = implode(array_reverse(explode("-", $oConvites->l20_dtpublic)));
					$oDadosConvites->dtPublicacaoEditalVeiculo1 = " ";
					$oDadosConvites->veiculo1Publicacao			    = " ";
					$oDadosConvites->dtPublicacaoEditalVeiculo2	= " ";
					$oDadosConvites->veiculo2Publicacao			    = " ";
					$oDadosConvites->dtRecebimentoDoc			      = implode(explode("/", $oDadosComplLicitacao->getAttribute('dtRecebimentoDoc')));
					$oDadosConvites->tipoLicitacao				      = substr($oDadosComplLicitacao->getAttribute('tipoLicitacao'), -1, 1);
					$oDadosConvites->naturezaObjeto			  	    = $iNaturezaObj;
					$oDadosConvites->objeto						          = substr($oConvites->l20_objeto, 0, 250);
					$oDadosConvites->regimeExecucaoObras		    = $iRegimeExecObras;
					$oDadosConvites->nroConvidado			  	      = substr($oDadosComplLicitacao->getAttribute('nroConvidado'), 0, 3);
					$oDadosConvites->clausulaProrrogacao		    = " ";
					$oDadosConvites->unidadeMedidaPrazoExecucao	= substr($oDadosComplLicitacao->getAttribute('unidadeMedidaPrazoExecucao'), -1, 1);
					$oDadosConvites->prazoExecucao	  			    = substr($oDadosComplLicitacao->getAttribute('prazoExecucao'), 0, 4);
					$oDadosConvites->formaPagamento	  			    = substr($oDadosComplLicitacao->getAttribute('formaPagamento'), 0, 80);
					$oDadosConvites->criterioAceitabilidade		  = " ";
					$oDadosConvites->descontoTabela		  		    = $oDadosComplLicitacao->getAttribute('descontoTabela');

					$this->aDados[] = $oDadosConvites;

				}
					
			}

			$sSql2 = "select m61_descr,pc01_codmater,pc01_descrmater, pc11_quant,pc81_codprocitem
		    from liclicitem
			join pcprocitem  on l21_codpcprocitem = pc81_codprocitem
			join solicitem on pc81_solicitem = pc11_codigo
			join solicitempcmater on pc16_solicitem = pc11_codigo
			join pcmater on pc16_codmater = pc01_codmater
			left join solicitemunid on pc17_codigo = pc11_codigo
			left join matunid on pc17_unid = m61_codmatunid
			where l21_codliclicita = ".$oConvites->l20_codigo." and l21_situacao = 0 ";
				
			$rsPesquisaP = db_query($sSql2);

			$aDadosAgrupados = array();
			for ($iCont2 = 0; $iCont2 < pg_num_rows($rsPesquisaP); $iCont2++) {

				$oPesquisaP  = db_utils::fieldsMemory($rsPesquisaP, $iCont2);
					
				foreach ($oPrecosMedios as $oPrecoMedio) {
						
					if ($oPrecoMedio->getAttribute('instituicao') == db_getsession("DB_instit")
					    && $oPrecoMedio->getAttribute('nroProcessoLicitatorio') == $oConvites->l20_codigo
					    && $oPrecoMedio->getAttribute('codigoitemprocesso') == $oPesquisaP->pc81_codprocitem) {

            $sHash = $sOrgao.$oDadosConvites->exercicioLicitacao.$oDadosConvites->nroProcessoLicitatorio.$oPesquisaP->pc01_codmater;
            
            if (!isset($aDadosAgrupados[$sHash])) {

              if ($oPesquisaP->m61_descr != '') {
     	          $sUnidade = substr($oPesquisaP->m61_descr, 0, 50);
     	        } else {
     	          $sUnidade = "SERVICO";
     	        }
            	
							$oDadosPesquisaPrecos = new stdClass();
	
							$oDadosPesquisaPrecos->tipoRegistro  				   = 11;
							$oDadosPesquisaPrecos->detalhesessao 				   = 11;
							$oDadosPesquisaPrecos->codOrgaoResp  				   = $sOrgao;
							$oDadosPesquisaPrecos->codUnidadeSubResp	     = " ";
							$oDadosPesquisaPrecos->exercicioLicitacao			 = str_pad($oDadosConvites->exercicioLicitacao, 4, "0", STR_PAD_LEFT);
							$oDadosPesquisaPrecos->nroProcessoLicitatorio	 = substr($oDadosConvites->nroProcessoLicitatorio, 0, 12);
							$oDadosPesquisaPrecos->nroLote					       = " ";
							$oDadosPesquisaPrecos->nroItem					       = substr($oPesquisaP->pc01_codmater, 0, 4);
							$oDadosPesquisaPrecos->dtCotacao					     = implode(explode("/", $oPrecoMedio->getAttribute('dtCotacao')));
							$oDadosPesquisaPrecos->dscItem					       = substr($oPesquisaP->pc01_descrmater, 0, 250);
							$oDadosPesquisaPrecos->vlCotPrecosUnitario		 = 0;
							$oDadosPesquisaPrecos->quantidade			  		   = 0;
							$oDadosPesquisaPrecos->unidade			  		     = $sUnidade;
							$oDadosPesquisaPrecos->vlMinAlienBens			  	 = '000';
	
							$aDadosAgrupados[$sHash] = $oDadosPesquisaPrecos;
            
            } else {
            	$oDadosPesquisaPrecos = $aDadosAgrupados[$sHash];
            }
							
            $oDadosPesquisaPrecos->vlCotPrecosUnitario += $oPrecoMedio->getAttribute('vlCotPrecosUnitario');
            $oDadosPesquisaPrecos->quantidade			  	 += $oPesquisaP->pc11_quant;
            
            $aDadosAgrupados[$sHash] = $oDadosPesquisaPrecos;
            
					}

				}

			}

			foreach ($aDadosAgrupados as $oDado) {
				
				$oDado->vlCotPrecosUnitario = number_format($oDado->vlCotPrecosUnitario, 4, "", "");
        $oDado->quantidade			  	= number_format($oDado->quantidade, 4, "", "");
        $this->aDados[]             = $oDado;
        
			}
			
			if ( $iControl == 3 ) {

				$aDadosAgrupadosReg12 = array();
				foreach ($oPrecosMedios as $oPrecoMedio) {
						
					if ($oPrecoMedio->getAttribute('instituicao') == db_getsession("DB_instit")
					&& $oPrecoMedio->getAttribute('nroProcessoLicitatorio') == $oConvites->l20_codigo) {
						 
						$sSql4 = "select pc01_codmater, pc01_descrmater
			    	     from liclicitem
					     join pcprocitem on l21_codpcprocitem = pc81_codprocitem
					     join solicitem on pc81_solicitem = pc11_codigo
					     join pcmater on pc11_numero = pc01_codmater
				  		 where l21_codpcprocitem = ".$oPrecoMedio->getAttribute('codigoitemprocesso');
							
						$rsRefPreco = db_query($sSql4);
							
						for ($iCont3 = 0; $iCont3 < pg_num_rows($rsRefPreco); $iCont3++) {

							$oRefPreco  = db_utils::fieldsMemory($rsRefPreco, $iCont3);

							$sHash = $sOrgao.$oDadosConvites->exercicioLicitacao.$oDadosConvites->nroProcessoLicitatorio.$oRefPreco->pc01_codmater;
							if (!isset($aDadosAgrupadosReg12[$sHash])) {
							
								$oDadosReferenciaPreco = new stdClass();

							  $oDadosReferenciaPreco->tipoRegistro  				 = 12;
							  $oDadosReferenciaPreco->detalhesessao 				 = 12;
							  $oDadosReferenciaPreco->codOrgaoResp   				 = $sOrgao;
							  $oDadosReferenciaPreco->codUnidadeSubResp		   = " ";
							  $oDadosReferenciaPreco->exercicioLicitacao		 = str_pad($oDadosConvites->exercicioLicitacao, 4, "0", STR_PAD_LEFT);
							  $oDadosReferenciaPreco->nroProcessoLicitatorio = substr($oDadosConvites->nroProcessoLicitatorio, 0, 12);
							  $oDadosReferenciaPreco->nroLote						     = " ";
							  $oDadosReferenciaPreco->nroItem					  	   = substr($oRefPreco->pc01_codmater, 0, 4);
							  $oDadosReferenciaPreco->dscItem						     = substr($oRefPreco->pc01_descrmater, 0, 250);
							  $oDadosReferenciaPreco->vlItem					  	   = $oPrecoMedio->getAttribute('vlCotPrecosUnitario');

							  $aDadosAgrupadosReg12[$sHash] = $oDadosReferenciaPreco;
							
							} else {
								$aDadosAgrupadosReg12[$sHash]->vlItem += $oPrecoMedio->getAttribute('vlCotPrecosUnitario');
							}

						}

					}

				}
				
			  foreach ($aDadosAgrupadosReg12 as $oDado) {
				
          $oDado->vlItem	= number_format($oDado->vlItem, 4, "", "");
          $this->aDados[] = $oDado;
        
			  }

			}

			/**
			 * caso não exista registro 11 de licicacao do xml de preco medio, pegar preco referencia do banco de dados
			 */
			if (count($aDadosAgrupados) == 0) {
				
				$sSqlPrecoRef = "select distinct si01_datacotacao,si02_itemproccompra,pc23_quant,si02_vlprecoreferencia,m61_descr
				l21_codigo,pc01_codmater,pc01_descrmater from pcproc 
				join pcprocitem on pc80_codproc = pc81_codproc
				join liclicitem on pc81_codprocitem = l21_codpcprocitem
				join liclicita on l21_codliclicita = l20_codigo
				join pcorcamitemproc on pc81_codprocitem = pc31_pcprocitem
				join pcorcamitem on pc31_orcamitem = pc22_orcamitem
				join pcorcamval on pc22_orcamitem = pc23_orcamitem
				join precoreferencia on pc80_codproc = si01_processocompra
				join itemprecoreferencia on si01_sequencial = si02_precoreferencia and pc23_orcamitem = si02_itemproccompra
				join solicitem on pc81_solicitem = pc11_codigo
				join solicitempcmater on pc11_codigo = pc16_solicitem
				join pcmater on pc16_codmater = pc01_codmater
				left join solicitemunid on pc17_codigo = pc11_codigo
        left join matunid on pc17_unid = m61_codmatunid
				where l20_codigo = {$oConvites->l20_codigo}";
				$rsPrecoRef = db_query($sSqlPrecoRef);

				$aDadosAgrupadosPrecoRef = array();
				for ($iContRef = 0;$iContRef < pg_num_rows($rsPrecoRef);$iContRef++) {
					
					$oPrecoRef = db_utils::fieldsMemory($rsPrecoRef, $iContRef);
					
				  if ($oPesquisaP->m61_descr != '') {
     	      $sUnidade = substr($oPrecoRef->m61_descr, 0, 50);
     	    } else {
     	      $sUnidade = "SERVICO";
     	    }
					
     	    $sHash = $sOrgao.$oDadosConvites->exercicioLicitacao.$oDadosConvites->nroProcessoLicitatorio.$oPrecoRef->pc01_codmater;
     	    
     	    if (!isset($aDadosAgrupadosPrecoRef[$sHash])) {
     	    	
					  $oDadosPesquisaPrecos = new stdClass();
	
					  $oDadosPesquisaPrecos->tipoRegistro  				   = 11;
					  $oDadosPesquisaPrecos->detalhesessao 				   = 11;
					  $oDadosPesquisaPrecos->codOrgaoResp  				   = $sOrgao;
					  $oDadosPesquisaPrecos->codUnidadeSubResp	     = " ";
					  $oDadosPesquisaPrecos->exercicioLicitacao			 = str_pad($oDadosConvites->exercicioLicitacao, 4, "0", STR_PAD_LEFT);
					  $oDadosPesquisaPrecos->nroProcessoLicitatorio	 = substr($oDadosConvites->nroProcessoLicitatorio, 0, 12);
					  $oDadosPesquisaPrecos->nroLote					       = " ";
					  $oDadosPesquisaPrecos->nroItem					       = substr($oPrecoRef->pc01_codmater, 0, 4);
					  $oDadosPesquisaPrecos->dtCotacao					     = implode(array_reverse(explode("-", $oPrecoRef->si01_datacotacao)));
					  $oDadosPesquisaPrecos->dscItem					       = substr($oPrecoRef->pc01_descrmater, 0, 250);
					  $oDadosPesquisaPrecos->vlCotPrecosUnitario		 = $oPrecoRef->si02_vlprecoreferencia;
					  $oDadosPesquisaPrecos->quantidade			  		   = $oPrecoRef->pc23_quant;
					  $oDadosPesquisaPrecos->unidade			  		     = $sUnidade;
					  $oDadosPesquisaPrecos->vlMinAlienBens			  	 = '000';
					  $oDadosPesquisaPrecos->Reg12			  	         = array();
					
					  $aDadosAgrupadosPrecoRef[$sHash] = $oDadosPesquisaPrecos;
					
     	    } else {
     	    	
     	    	$aDadosAgrupadosPrecoRef[$sHash]->vlCotPrecosUnitario += $oPrecoRef->si02_vlprecoreferencia;
     	    	$aDadosAgrupadosPrecoRef[$sHash]->quantidade          += $oPrecoRef->pc23_quant;
     	    	
     	    }
					
     	    if ( $iControl == 3 ) {
     	    	
     	      if (!isset($aDadosAgrupadosPrecoRef[$sHash]->Reg12[$sHash])) {
     	    	
					    $oDadosReferenciaPreco = new stdClass();

					    $oDadosReferenciaPreco->tipoRegistro  				 = 12;
					    $oDadosReferenciaPreco->detalhesessao 				 = 12;
					    $oDadosReferenciaPreco->codOrgaoResp   				 = $sOrgao;
					    $oDadosReferenciaPreco->codUnidadeSubResp		   = " ";
					    $oDadosReferenciaPreco->exercicioLicitacao		 = str_pad($oDadosConvites->exercicioLicitacao, 4, "0", STR_PAD_LEFT);
					    $oDadosReferenciaPreco->nroProcessoLicitatorio = substr($oDadosConvites->nroProcessoLicitatorio, 0, 12);
					    $oDadosReferenciaPreco->nroLote						     = " ";
					    $oDadosReferenciaPreco->nroItem					  	   = substr($oPrecoRef->l21_codigo, 0, 4);
					    $oDadosReferenciaPreco->dscItem						     = substr($oPrecoRef->pc01_descrmater, 0, 250);
					    $oDadosReferenciaPreco->vlItem					  	   = $oPrecoRef->si02_vlprecoreferencia;

					    $aDadosAgrupadosPrecoRef[$sHash]->Reg12[$sHash] = $oDadosReferenciaPreco;
					
     	      } else {
     	    	  $aDadosAgrupadosPrecoRef[$sHash]->Reg12[$sHash]->vlItem += $oPrecoRef->si02_vlprecoreferencia;
     	      }
					
     	    }
     	    
				}
				
				foreach ($aDadosAgrupadosPrecoRef as $oDadosAgrupadosPrecoRef) {
					
					$oDadosReg12 = $oDadosAgrupadosPrecoRef->Reg12;
					unset($oDadosAgrupadosPrecoRef->Reg12);
					$oDadosAgrupadosPrecoRef->vlCotPrecosUnitario = number_format($oDadosAgrupadosPrecoRef->vlCotPrecosUnitario,4,"","");
					$oDadosAgrupadosPrecoRef->quantidade          = number_format($oDadosAgrupadosPrecoRef->quantidade,4,"","");
					$oDadosReg12->vlItem = number_format($oDadosReg12->vlItem,4,"","");
					
					$this->aDados[] = $oDadosAgrupadosPrecoRef;
					$this->aDados[] = $oDadosReg12;
					
				}
				
			}
			
			$sSql3 = "select distinct  o58_valor,o58_orgao, o58_unidade, o58_funcao, o58_subfuncao, o58_programa, o58_projativ, o15_codtri,
			substr(o56_elemento,2,6) as elemento
			from liclicitem 
			inner join pcprocitem on liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem 
			inner join pcproc on pcproc.pc80_codproc = pcprocitem.pc81_codproc 
			inner join solicitem on solicitem.pc11_codigo = pcprocitem.pc81_solicitem 
			inner join solicita on solicita.pc10_numero = solicitem.pc11_numero 
			inner join db_depart on db_depart.coddepto = solicita.pc10_depto
			left join liclicita on liclicita.l20_codigo = liclicitem.l21_codliclicita 
			left join cflicita on cflicita.l03_codigo = liclicita.l20_codtipocom 
			left join pctipocompra on pctipocompra.pc50_codcom = cflicita.l03_codcom 
			left join solicitemunid on solicitemunid.pc17_codigo = solicitem.pc11_codigo 
			left join matunid on matunid.m61_codmatunid = solicitemunid.pc17_unid 
			left join pcorcamitemlic on l21_codigo = pc26_liclicitem 
			left join pcorcamval on pc26_orcamitem = pc23_orcamitem 
			left join db_usuarios on pcproc.pc80_usuario = db_usuarios.id_usuario 
			left join solicitempcmater on solicitempcmater.pc16_solicitem = solicitem.pc11_codigo 
			left join pcmater on pcmater.pc01_codmater = solicitempcmater.pc16_codmater 
			left join pcsubgrupo on pcsubgrupo.pc04_codsubgrupo = pcmater.pc01_codsubgrupo 
			left join pctipo on pctipo.pc05_codtipo = pcsubgrupo.pc04_codtipo 
			left join solicitemele on solicitemele.pc18_solicitem = solicitem.pc11_codigo 
			left join orcelemento on orcelemento.o56_codele = solicitemele.pc18_codele 
				and orcelemento.o56_anousu = ".db_getsession("DB_anousu")." 
			left join empautitempcprocitem on empautitempcprocitem.e73_pcprocitem = pcprocitem.pc81_codprocitem 
			left join empautitem on empautitem.e55_autori = empautitempcprocitem.e73_autori 
				and empautitem.e55_sequen = empautitempcprocitem.e73_sequen
			left join empautoriza on empautoriza.e54_autori = empautitem.e55_autori 
			left join empempaut on empempaut.e61_autori = empautitem.e55_autori 
			left join empempenho on empempenho.e60_numemp = empempaut.e61_numemp 
			left join pcdotac on solicitem.pc11_codigo = pcdotac.pc13_codigo
			join orcdotacao on pc13_anousu = o58_anousu 
				and pc13_coddot = o58_coddot
			join orctiporec on o58_codigo = o15_codigo
		
		    where l21_codliclicita = '".$oConvites->l20_codigo."' ";

			$rsPrevisao = db_query($sSql3);
			
			for ($iCont4 = 0; $iCont4 < pg_num_rows($rsPrevisao); $iCont4++) {

				$oPrevisao  = db_utils::fieldsMemory($rsPrevisao, $iCont4);

				$oDadosPrevisao = new stdClass();

				if ( $iVerifica == 1) {

					
				  if ($sTrataCodUnidade == "01") {
      		
      		  $sCodUnidade  = str_pad($oPrevisao->o58_orgao, 2, "0", STR_PAD_LEFT);
	   		    $sCodUnidade .= str_pad($oPrevisao->o58_unidade, 3, "0", STR_PAD_LEFT);
	   		  
      	  } else {
      		
      		  $sCodUnidade	= str_pad($oPrevisao->o58_orgao, 3, "0", STR_PAD_LEFT);
	   		    $sCodUnidade .= str_pad($oPrevisao->o58_unidade, 2, "0", STR_PAD_LEFT);
      		
      	  }
					
					$oDadosPrevisao->tipoRegistro   		 	  =  13;
					$oDadosPrevisao->detalhesessao  		 	  =  13;
					$oDadosPrevisao->codOrgaoResp  		 	    =  $sOrgao;
					$oDadosPrevisao->codUnidadeSubResp 	 	  =  " ";
					$oDadosPrevisao->exercicioLicitacao    	=  str_pad($oDadosConvites->exercicioLicitacao, 4, "0", STR_PAD_LEFT);
					$oDadosPrevisao->nroProcessoLicitatorio =  substr($oDadosConvites->nroProcessoLicitatorio, 0, 12);
					$oDadosPrevisao->codOrgao				        =  $sOrgao;
					$oDadosPrevisao->codUnidadeSub 			    =  $sCodUnidade;
					$oDadosPrevisao->codFuncao			        =  str_pad($oPrevisao->o58_funcao, 2, "0", STR_PAD_LEFT);
					$oDadosPrevisao->codSubFuncao   			  =  str_pad($oPrevisao->o58_subfuncao, 3, "0", STR_PAD_LEFT);
					$oDadosPrevisao->codPrograma   			    =  str_pad($oPrevisao->o58_programa, 4, "0", STR_PAD_LEFT);
					$oDadosPrevisao->idAcao   				      =  str_pad($oPrevisao->o58_projativ, 4, "0", STR_PAD_LEFT);
					$oDadosPrevisao->idSubAcao              =  " ";
					$oDadosPrevisao->elementoDespesa   		  =  str_pad($oPrevisao->elemento, 6, "0", STR_PAD_LEFT);
					$oDadosPrevisao->codFontRecursos   		  =  str_pad($oPrevisao->o15_codtri, 3, "0", STR_PAD_LEFT);
					$oDadosPrevisao->vlRecurso   				    =  number_format($oPrevisao->o58_valor, 2, "", "");

					$this->aDados[] = $oDadosPrevisao;

				}

			}

		}
			
	}

}