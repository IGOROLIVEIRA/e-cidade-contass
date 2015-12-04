<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

/**
 * detalhamento dos empenhos do mês Sicom Acompanhamento Mensal
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoDetalhamentoEmpenhosMes extends SicomArquivoBase implements iPadArquivoBaseCSV {

	/**
	 *
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
	protected $iCodigoLayout = 166;

	/**
	 *
	 * Nome do arquivo a ser criado
	 * @var String
	 */
	protected $sNomeArquivo = 'EMP';

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
                          "codFuncao",
                          "codSubFuncao",
                          "codPrograma",
                          "idAcao",
													"idSubAcao",
                          "elementoDespesa",
    											"subElemento",
    											"nroEmpenho",
    											"dtEmpenho",
    											"modalidadeEmpenho",
    											"tpEmpenho",
    											"vlBruto",
    											"nomeCredor",
    											"tipoDocumento",
    											"nroDocumento",
    											"especificacaoEmpenho",
    											"despDecContrato",
													"codOrgaoResp",
    											"nroContrato",
    											"dataAssinaturaContrato",
    											"nroSequencialTermoAditivo",
    											"despDecLicitacao",
    											"nroProcessoLicitatorio",
    											"exercicioProcessoLicitatorio",
    											"nomeOrdenador",
    											"cpfOrdenador"
    											);
    $aElementos[11] = array(
                          "tipoRegistro",
                          "codUnidadeSub",
                          "nroEmpenho",
                          "codFontRecursos",
    											"valorFonte"
    											);
    $aElementos[20] = array(
                          "tipoRegistro",
                          "codUnidadeSub",
                          "nroEmpenho",
                          "tipoDocumento",
    											"nroDocumento",
    											"nomeCredor",
    											"vlAssociadoCredor"
    											);
     $aElementos[30] = array(
                          "tipoRegistro",
													"codOrgao",
                          "codUnidadeSub",
                          "nroEmpenho",
                          "dtEmpenho",
    											"nroReforco",
    											"dtReforco",
    											"vlReforco"
    											);
    											return $aElementos;
	}

	/**
	 * selecionar os dados dos empenhos do mes para gerar o arquivo
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

		/**
		 * selecionar arquivo xml com dados dos empenhos
		 */
		$sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomdotacao.xml";

		if (!file_exists($sArquivo)) {
			throw new Exception("Arquivo dos empenhos inexistente!");
		}
		$sTextoXml    = file_get_contents($sArquivo);
		$oDOMDocument = new DOMDocument();
		$oDOMDocument->loadXML($sTextoXml);
		$oDotacoes      = $oDOMDocument->getElementsByTagName('dotacao');
		
		/**
		 * selecionar arquivo xml com dados dos contratos
		 */
	  $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomcontratos.xml";

		if (!file_exists($sArquivo)) {
			throw new Exception("Arquivo dos contratos inexistente!");
		}
		$sTextoXml    = file_get_contents($sArquivo);
		$oDOMDocument = new DOMDocument();
		$oDOMDocument->loadXML($sTextoXml);
		$oContratos   = $oDOMDocument->getElementsByTagName('contrato');
		
		/**
		 * selecionar aquivo xml com dados dos adtivos
		 */
		$sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomaditivoscontratos.xml";
		
		if (!file_exists($sArquivo)) {
			throw new Exception("Arquivo dos aditivos inexistente!");
		}
		$sTextoXml    = file_get_contents($sArquivo);
		$oDOMDocument = new DOMDocument();
		$oDOMDocument->loadXML($sTextoXml);
		$oAditivos    = $oDOMDocument->getElementsByTagName('aditivoscontrato');
		
		/**
		 * selecionar aquivo xml com dados de identificação do responsável
		 */
		$sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomidentresponsavel.xml";
		
		if (!file_exists($sArquivo)) {
			throw new Exception("Arquivo dos responsáveis inexistente!");
		}
		$sTextoXml    = file_get_contents($sArquivo);
		$oDOMDocument = new DOMDocument();
		$oDOMDocument->loadXML($sTextoXml);
		$oIdentResponsaveis = $oDOMDocument->getElementsByTagName('identresp');
		
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

		$sSql = "SELECT	e60_codcom, e60_codtipo, e60_numemp,e60_codemp,e60_emiss,e60_vlremp,e41_descr,o58_orgao,o58_unidade,o58_funcao, 
	 	   o58_subfuncao,o58_projativ,o58_programa,o58_codigo,o56_elemento,z01_nome,z01_cgccpf, 
		   e60_resumo,o15_codtri,e60_numerol 
	       from empempenho 
   		   join orcdotacao on e60_coddot = o58_coddot 
		   join empelemento on e60_numemp = e64_numemp 
		   join orcelemento on e64_codele = o56_codele 
		   join orctiporec on o58_codigo = o15_codigo 
		   join emptipo on e60_codtipo = e41_codtipo   
		   join cgm on e60_numcgm = z01_numcgm 
		   where e60_anousu = ".db_getsession("DB_anousu")." and o56_anousu = ".db_getsession("DB_anousu")."
		 and o58_anousu = ".db_getsession("DB_anousu")." and  e60_instit = ".db_getsession("DB_instit")." 
		 and e60_emiss >= '".$this->sDataInicial."'
		 and e60_emiss <= '".$this->sDataFinal."'";

		$rsEmpenho = db_query($sSql);
    $aCaracteres = array("°",chr(13),chr(10));
		for ($iCont = 0; $iCont < pg_num_rows($rsEmpenho); $iCont++) {
			 
			$oEmpenho = db_utils::fieldsMemory($rsEmpenho, $iCont);
      
			if (strtoupper($oEmpenho->e41_descr) == "GLOBAL") {
				$iModalidadeEmpenho = 3;
			} else {
				 
				if (strtoupper($oEmpenho->e41_descr) == "ESTIMATIVO") {
					$iModalidadeEmpenho = 2;
				} else {
					$iModalidadeEmpenho = 1;
				}
				 
			}

			if (substr($oEmpenho->o56_elemento, 1, 2) == "46") {
				$stpEmpenho = "02";
			} else {
				$stpEmpenho = "01";
			}

			if (strlen($oEmpenho->z01_cgccpf) == 11) {
				$itipoDocumento = 1;
			} else {
				$itipoDocumento = 2;
			}

			$iDespDecContrato           = 2;
			$sNroContrato               = " ";
			$dDataAssinaturaContrato    = " ";
			$iNroSequencialTermoAditivo = " ";

			/**
			 * percorrer dados do xml de Dotações
			 */
			foreach ($oDotacoes as $oDotacao) {
      
				if ($oDotacao->getAttribute('instituicao') == db_getsession("DB_instit") 
				    && $oDotacao->getAttribute('codEmpenho') == $oEmpenho->e60_codemp) {
				
					$iDespDecContrato = 1;
					foreach ($oContratos as $oContrato) {
						
						if ($oContrato->getAttribute('instituicao') == db_getsession("DB_instit") 
						    && $oContrato->getAttribute('codigo') == $oDotacao->getAttribute('codContrato')) {
						    	
						  $sNroContrato            = $oContrato->getAttribute('nroContrato');		
						  $dDataAssinaturaContrato = $oContrato->getAttribute('dataAssinatura');
						  break;
						  					
						}
						
					}
					break;
					
				}
				 
			}
			
			$sNomeOrdenador = " ";
			$sCpfOrdenador  = " ";
			/**
			 * percorrer dados do xml de identificação dos responsáveis
			 */
			foreach ($oIdentResponsaveis as $oIdentResponsavel) {
				
				if ($oIdentResponsavel->getAttribute('instituicao') == db_getsession("DB_instit")
				    && $oIdentResponsavel->getAttribute('OrgaoResp') == $oEmpenho->o58_orgao) {
					
					$sSql  = "select z01_nome, z01_cgccpf from cgm where z01_numcgm = ".$oIdentResponsavel->getAttribute('numCgm');
					$rsCgm = db_query($sSql); 
					$sNomeOrdenador = db_utils::fieldsMemory($rsCgm, 0)->z01_nome;
					$sCpfOrdenador  = db_utils::fieldsMemory($rsCgm, 0)->z01_cgccpf;
					break; 
					
				} else {
					
					if ($oIdentResponsavel->getAttribute('instituicao') == db_getsession("DB_instit")
					    && $oIdentResponsavel->getAttribute('tipoResponsavel') == "01") {
						$iNumCgm = $oIdentResponsavel->getAttribute('numCgm');
					}
					
				}
				
			}
			if ($sNomeOrdenador == " " && isset($iNumCgm)) {
			
			  $sSql  = "select z01_nome, z01_cgccpf from cgm where z01_numcgm = $iNumCgm";
				$rsCgm = db_query($sSql); 
				$sNomeOrdenador = db_utils::fieldsMemory($rsCgm, 0)->z01_nome;
				$sCpfOrdenador  = db_utils::fieldsMemory($rsCgm, 0)->z01_cgccpf;
					
			}
			
			if ($iDespDecContrato == 1) {
				
				/**
				 * percorrer dados do xml de ativos
				 */
				foreach ($oAditivos as $oAditivo) {

				  if ($oAditivo->getAttribute('instituicao') == db_getsession("DB_instit") 
						    && $oAditivo->getAttribute('nroContrato') == $sNroContrato) {
						    	
            $iNroSequencialTermoAditivo  = str_pad($oAditivo->getAttribute('codAditivo'), 2, "0", STR_PAD_LEFT);
						  					
				  }
					
				}
				
			}

			$sSqlLicitacao1 = "SELECT  l20_codigo,l20_numero, l20_anousu FROM empempenho 
                        INNER JOIN empempaut ON e60_numemp = e61_numemp 
                        INNER JOIN empautoriza ON e54_autori = e61_autori 
                        INNER JOIN empautitem ON e54_autori = e55_autori 
                        INNER JOIN empautitempcprocitem ON e73_autori = e55_autori AND e73_sequen = e55_sequen 
                        INNER JOIN pcprocitem ON e73_pcprocitem = pc81_codprocitem 
                        INNER JOIN liclicitem ON pc81_codprocitem = l21_codpcprocitem 
                        INNER JOIN liclicita ON l21_codliclicita = l20_codigo 
               where e60_numemp = {$oEmpenho->e60_numemp} limit 1";
			
			$sSqlLicitacao2 = "SELECT l20_codigo,l20_numero, l20_anousu from empempenho join pctipocompra on e60_codcom = pc50_codcom 
			join cflicita on  l03_codcom = pc50_codcom 
			join liclicita on ((string_to_array(e60_numerol, '/'))[1])::int = l20_numero 
			and l20_anousu = ((string_to_array(e60_numerol, '/'))[2])::int and l03_codigo = l20_codtipocom where e60_numemp = {$oEmpenho->e60_numemp}";
			
			$rsLicitacao1 = db_query($sSqlLicitacao1);
			$rsLicitacao2 = db_query($sSqlLicitacao2);
			
			if (pg_num_rows($rsLicitacao1) > 0) {
				$oLicitacao  = db_utils::fieldsMemory($rsLicitacao1, 0);
			} else {
				$oLicitacao  = db_utils::fieldsMemory($rsLicitacao2, 0);
			}
			
			
			if ($oEmpenho->e60_codcom == 7 
			    || $oEmpenho->e60_codcom == 8
			    || $oEmpenho->e60_codcom == 9) {
				$iDespDecLicitacao = 1;
			} else {
				
				if ($oEmpenho->e60_codcom == 5) { 
				  $iDespDecLicitacao = 3;
				} else {
					$iDespDecLicitacao = 2;	
				}
				
			}
			
		  if ($sTrataCodUnidade == "01") {
      		
        $sCodUnidade  = str_pad($oEmpenho->o58_orgao, 2, "0", STR_PAD_LEFT);
	   		$sCodUnidade .= str_pad($oEmpenho->o58_unidade, 3, "0", STR_PAD_LEFT);
	   		  
      } else {
      		
        $sCodUnidade  = str_pad($oEmpenho->o58_orgao, 3, "0", STR_PAD_LEFT);
	   	  $sCodUnidade .= str_pad($oEmpenho->o58_unidade, 2, "0", STR_PAD_LEFT);
      		
      }
			
      $sElemento = substr($oEmpenho->o56_elemento, 1, 8);
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
      
      if ($iDespDecContrato == 3) {
      	$sOrgaoResp = $sOrgao;
      } else {
      	$sOrgaoResp = " ";
      }
      
			$oDadosEmpenho = new stdClass();
	
			$oDadosEmpenho->tipoRegistro                 = 10;
			$oDadosEmpenho->detalhesessao                = 10;
			$oDadosEmpenho->codOrgao                     = $sOrgao;
			$oDadosEmpenho->codUnidadeSub                = $sCodUnidade;
			$oDadosEmpenho->codFuncao                    = str_pad($oEmpenho->o58_funcao, 2, "0", STR_PAD_LEFT);
			$oDadosEmpenho->codSubFuncao                 = str_pad($oEmpenho->o58_subfuncao, 3, "0", STR_PAD_LEFT);
			$oDadosEmpenho->codPrograma                  = str_pad($oEmpenho->o58_programa, 4, "0", STR_PAD_LEFT);
			$oDadosEmpenho->idAcao                       = str_pad($oEmpenho->o58_projativ, 4, "0", STR_PAD_LEFT);
			$oDadosEmpenho->idSubAcao										 = " ";
			$oDadosEmpenho->elementoDespesa              = substr($sElemento, 0, 6);
			$oDadosEmpenho->subElemento                  = substr($sElemento, 6, 2);
			$oDadosEmpenho->nroEmpenho                   = substr($oEmpenho->e60_codemp, 0, 22);
			$oDadosEmpenho->dtEmpenho                    = implode(array_reverse(explode("-", $oEmpenho->e60_emiss)));
			$oDadosEmpenho->modalidadeEmpenho            = $iModalidadeEmpenho;
			$oDadosEmpenho->tpEmpenho                    = $stpEmpenho;
			$oDadosEmpenho->vlBruto                      = number_format($oEmpenho->e60_vlremp, 2, "", "");
			$oDadosEmpenho->nomeCredor                   = substr($oEmpenho->z01_nome, 0, 120);
			$oDadosEmpenho->tipoDocumento                = $itipoDocumento;
			$oDadosEmpenho->nroDocumento                 = substr($oEmpenho->z01_cgccpf, 0, 14);
			$oDadosEmpenho->especificacaoEmpenho         = substr(str_replace($aCaracteres, "", $oEmpenho->e60_resumo), 0, 200);
			$oDadosEmpenho->despDecContrato              = $iDespDecContrato;
			$oDadosEmpenho->codOrgaoResp								 = $sOrgaoResp;
			$oDadosEmpenho->nroContrato                  = str_replace("/", "", $sNroContrato);
			$oDadosEmpenho->dataAssinaturaContrato       = implode(explode("/", $dDataAssinaturaContrato));
			$oDadosEmpenho->nroSequencialTermoAditivo    = $iNroSequencialTermoAditivo;
			$oDadosEmpenho->despDecLicitacao             = $iDespDecLicitacao;
			$oDadosEmpenho->nroProcessoLicitatorio       = " ";
			$oDadosEmpenho->exercicioProcessoLicitatorio = " "; 
			$oDadosEmpenho->nomeOrdenador                = $sNomeOrdenador;
			$oDadosEmpenho->cpfOrdenador                 = $sCpfOrdenador;
			
			foreach ($oDadosComplLicitacoes as $oDadosComplLicitacao) {
			
			  if ($oDadosComplLicitacao->getAttribute('instituicao') == db_getsession("DB_instit")
				&& $oDadosComplLicitacao->getAttribute('nroProcessoLicitatorio') == $oLicitacao->l20_codigo
				&& $oLicitacao->l20_codigo != '') {
			
			    $oDadosEmpenho->nroProcessoLicitatorio       = substr($oDadosComplLicitacao->getAttribute('codigoProcesso'), 0, 12);
			    $oDadosEmpenho->exercicioProcessoLicitatorio = $oDadosComplLicitacao->getAttribute('ano'); 
				
			  }
				
			}
			if ($oDadosEmpenho->nroProcessoLicitatorio == " " ) {
				$oDadosEmpenho->despDecLicitacao = 1;
			}
			
			$this->aDados[] = $oDadosEmpenho;
			
			/**
			 * dados registro 11
			 */
			$oDadosEmpenhoFonte = new stdClass();
			
			$oDadosEmpenhoFonte->tipoRegistro    = 11;
			$oDadosEmpenhoFonte->detalhesessao   = 11;
			$oDadosEmpenhoFonte->codUnidadeSub   = $sCodUnidade;
			$oDadosEmpenhoFonte->nroEmpenho      = substr($oEmpenho->e60_codemp, 0, 22);
			$oDadosEmpenhoFonte->codFontRecursos = substr($oEmpenho->o15_codtri, 0, 3);
			$oDadosEmpenhoFonte->valorFonte      = number_format($oEmpenho->e60_vlremp, 2, "", "");
			
			$this->aDados[] = $oDadosEmpenhoFonte;
			
		}

	}

}