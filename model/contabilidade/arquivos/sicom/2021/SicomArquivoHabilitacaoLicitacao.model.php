<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_hablic102021_classe.php");
require_once ("classes/db_hablic112021_classe.php");
require_once ("classes/db_hablic202121_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarHABLIC.model.php");



/**
 * Habilitação Licitação Sicom Acompanhamento Mensal
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoHabilitacaoLicitacao extends SicomArquivoBase implements iPadArquivoBaseCSV {

	/**
	 *
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
	protected $iCodigoLayout = 156;

	/**
	 *
	 * Nome do arquivo a ser criado
	 * @var String
	 */
	protected $sNomeArquivo = 'HABLIC';

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
                          "nomRazaoSocial",
    											"objetoSocial",
    											"orgaoRespRegistro",
    											"dataRegistro",
    											"nroRegistro",
    											"dataRegistroCVM",
    											"nroRegistroCVM",
                          "nroInscricaoEstadual",
                          "ufInscricaoEstadual",
                          "nroCertidaoRegularidadeINSS",
                          "dtEmissaoCertidaoRegularidadeINSS",
                          "dtValidadeCertidaoRegularidadeINSS",
                          "nroCertidaoRegularidadeFGTS",
                          "dtEmissaoCertidaoRegularidadeFGTS",
                          "dtValidadeCertidaoRegularidadeFGTS",
    											"nroCNDT",
    											"dtEmissaoCNDT",
    											"dtValidadeCNDT",
                          "dtHabilitacao",
    											"PresencaLicitantes",
                          "renunciaRecurso"
                          );
                          $aElementos[11] = array(
                          "tipoRegistro",
                          "codOrgao",
                          "codUnidadeSub",
                          "exercicioLicitacao",
    										  "nroProcessoLicitatorio",
    											"tipoDocumentoCNPJEmpresaHablic",
                          "CNPJEmpresaHablic",
                          "tipoDocumentoSocio",
                          "nroDocumentoSocio",
                          "nomeSocio",
                          "tipoParticipacao"
                          );
                          $aElementos[20] = array(
                          "tipoRegistro",
                          "codOrgao",
                          "codUnidadeSub",
                          "exercicioLicitacao",
    										  "nroProcessoLicitatorio",
    											"tipoDocumento",
                          "nroDocumento",
                          "dataCredenciamento",
                          "nroLote",
                          "nroItem",
                          "nomeRazaoSocial",
                          "nroInscricaoEstadual",
                          "ufInscricaoEstadual",
                          "nroCertidaoRegularidadeINSS",
                          "dataEmissaoCertidaoRegularidadeINSS",
                          "dataValidadeCertidaoRegularidadeINSS",
                          "nroCertidaoRegularidadeFGTS",
                          "dataEmissaoCertidaoRegularidadeFGTS",
                          "dataValidadeCertidaoRegularidadeFGTS",
    											"nroCNDT",
    											"dtEmissaoCNDT",
    											"dtValidadeCNDT"
    											);
    											return $aElementos;
	}

	/**
	 * selecionar os dados dE Habilitação da licitação
	 * @see iPadArquivoBase::gerarDados()
	 */
	public function gerarDados() {

		/**
		 * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
		 */
		$clhablic102021 = new cl_hablic102021();
		$clhablic112021 = new cl_hablic112021();
		$clhablic202121 = new cl_hablic202121();
			

		/**
		 * excluir informacoes do mes selecioado
		 */
		db_inicio_transacao();
		$result = db_query($clhablic112021->sql_query(NULL,"*",NULL,"si58_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si58_instit=".db_getsession("DB_instit")));
		if (pg_num_rows($result) > 0) {
			$clhablic112021->excluir(NULL,"si58_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si58_instit=".db_getsession("DB_instit"));
			if ($clhablic112021->erro_status == 0) {
				throw new Exception($clhablic112021->erro_msg);
			}
		}

		$result = db_query($clhablic102021->sql_query(NULL,"*",NULL,"si57_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si57_instit=".db_getsession("DB_instit")));
		if (pg_num_rows($result) > 0) {
			$clhablic102021->excluir(NULL,"si57_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si57_instit=".db_getsession("DB_instit"));
			if ($clhablic102021->erro_status == 0) {
				throw new Exception($clhablic102021->erro_msg);
			}
		}

		$result = db_query($clhablic202121->sql_query(NULL,"*",NULL,"si59_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si59_instit=".db_getsession("DB_instit")));
		if (pg_num_rows($result) > 0) {
			$clhablic202121->excluir(NULL,"si59_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si59_instit=".db_getsession("DB_instit"));
			if ($clconsor212021->erro_status == 0) {
				throw new Exception($clhablic202121->erro_msg);
			}
		}
		/**
		 * Sob solicitação de Igor, o campo nroRegistro foi alterado para pegar o cnpj 04/03/2021
		 */
	$sSql = "select '10' as tipoRegistro,
	db_config.db21_tipoinstit as codOrgaoResp,
	(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
	liclicita.l20_numero as nroProcessoLicitatorio,
	(CASE length(cgm.z01_cgccpf) WHEN 11 THEN 1
		ELSE 2
	END) as tipoDocumento,
	cgm.z01_cgccpf as nroDocumento,
	pcforne.pc60_objsocial as  objetoSocial,
	pcforne.pc60_orgaoreg as orgaoRespRegistro,
	pcforne.pc60_dtreg as dataRegistro,
	cgm.z01_cgccpf as nroRegistro,
	pcforne.pc60_dtreg_cvm as dataRegistroCVM,
	pcforne.pc60_numerocvm as nroRegistroCVM,
	pcforne.pc60_inscriestadual as nroInscricaoEstadual,
	pcforne.pc60_uf as ufInscricaoEstadual,
	habilitacaoforn.l206_numcertidaoinss as nroCertidaoRegularidadeINSS,
	habilitacaoforn.l206_dataemissaoinss as dtEmissaoCertidaoRegularidadeINSS,
	habilitacaoforn.l206_datavalidadeinss as dtValidadeCertidaoRegularidadeINSS,
	habilitacaoforn.l206_numcertidaofgts as nroCertidaoRegularidadeFGTS,
	habilitacaoforn.l206_dataemissaofgts as dtEmissaoCertidaoRegularidadeFGTS,
	habilitacaoforn.l206_datavalidadefgts as dtValidadeCertidaoRegularidadeFGTS,
	habilitacaoforn.l206_numcertidaocndt as nroCNDT,
	habilitacaoforn.l206_dataemissaocndt as dtEmissaoCNDT,
	habilitacaoforn.l206_datavalidadecndt as dtValidadeCNDT,
	habilitacaoforn.l206_datahab as dtHabilitacao,
	pc31_regata as PresencaLicitantes,
	pc31_renunrecurso as renunciaRecurso,
	l20_codigo as codlicitacao 				
	FROM liclicita as liclicita 
	INNER JOIN homologacaoadjudica as homologacaoadjudica on (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
	INNER JOIN habilitacaoforn as habilitacaoforn on (liclicita.l20_codigo=habilitacaoforn.l206_licitacao)
	INNER JOIN compras.pcforne as pcforne on (habilitacaoforn.l206_fornecedor=pcforne.pc60_numcgm)
	INNER JOIN protocolo.cgm as cgm on (pcforne.pc60_numcgm=cgm.z01_numcgm)
	INNER JOIN configuracoes.db_config as db_config on (liclicita.l20_instit=db_config.codigo)
	LEFT  JOIN  pcorcamfornelic on liclicita.l20_codigo=pcorcamfornelic.pc31_liclicita
	WHERE db_config.codigo=  " .db_getsession("DB_instit")."
	AND DATE_PART('YEAR',homologacaoadjudica.l202_datahomologacao)= ".db_getsession("DB_anousu")."
	AND DATE_PART('MONTH',homologacaoadjudica.l202_datahomologacao)= ".$this->sDataFinal['5'].$this->sDataFinal['6'];

		$rsResult10 = db_query($sSql);

		for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

			$clhablic102021 = new cl_hablic102021();
			$oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

			$clhablic102021->si57_tiporegistro   									= 10;
			$clhablic102021->si57_codorgao											=$oDados10->codorgaoresp;
			$clhablic102021->si57_codunidadesub										=$oDados10->codunidadesubresp;
			$clhablic102021->si57_exerciciolicitacao								=$oDados10->exerciciolicitacao;
			$clhablic102021->si57_nroprocessolicitatorio							=$oDados10->nroprocessolicitatorio;
			$clhablic102021->si57_tipodocumento										=$oDados10->tipodocumento;
			$clhablic102021->si57_nrodocumento										=$oDados10->nrodocumento;
			$clhablic102021->si57_objetosocial										=$oDados10->objetosocial;
			$clhablic102021->si57_orgaorespregistro									=$oDados10->orgaorespregistro;
			$clhablic102021->si57_dataregistro										=$oDados10->dataregistro;
			$clhablic102021->si57_nroregistro										=$oDados10->nroregistro;
			$clhablic102021->si57_dataregistrocvm									=$oDados10->dataregistrocvm;
			$clhablic102021->si57_nroregistrocvm									=$oDados10->nroregistrocvm;
			$clhablic102021->si57_nroinscricaoestadual								=$oDados10->nroinscricaoestadual;
			$clhablic102021->si57_ufinscricaoestadual								=$oDados10->ufinscricaoestadual;
			$clhablic102021->si57_nrocertidaoregularidadeinss						=$oDados10->nrocertidaoregularidadeinss;
			$clhablic102021->si57_dtemissaocertidaoregularidadeinss					=$oDados10->dtemissaocertidaoregularidadeinss;
			$clhablic102021->si57_dtvalidadecertidaoregularidadeinss				=$oDados10->dtvalidadecertidaoregularidadeinss;
			$clhablic102021->si57_nrocertidaoregularidadefgts						=$oDados10->nrocertidaoregularidadefgts;
			$clhablic102021->si57_dtemissaocertidaoregularidadefgts					=$oDados10->dtemissaocertidaoregularidadefgts;
			$clhablic102021->si57_dtvalidadecertidaoregularidadefgts				=$oDados10->dtvalidadecertidaoregularidadefgts;
			$clhablic102021->si57_nrocndt											=$oDados10->nrocndt;
			$clhablic102021->si57_dtemissaocndt										=$oDados10->dtemissaocndt;
			$clhablic102021->si57_dtvalidadecndt									=$oDados10->dtvalidadecndt;
			$clhablic102021->si57_dthabilitacao										=$oDados10->dthabilitacao;
			$clhablic102021->si57_presencalicitantes								=$oDados10->presencalicitantes;
			$clhablic102021->si57_renunciarecurso									=$oDados10->renunciarecurso;
			$clhablic102021->si57_mes             									= $this->sDataFinal['5'].$this->sDataFinal['6'];


			$clhablic102021->incluir(null);
			if ($clhablic102021->erro_status == 0) {
				throw new Exception($clhablic102021->erro_msg);
			}

			/**
			 * selecionar informacoes registro 11
			 */

	$sSql = "select '11' as tipoRegistro,
	db_config.db21_tipoinstit as codOrgaoResp,
	(select lpad(db01_orgao,2,0) || lpad(db01_unidade,3,0) from db_departorg where db01_coddepto=l20_codepartamento and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
	liclicita.l20_anousu as exercicioLicitacao,
	liclicita.l20_numero as nroProcessoLicitatorio,
	'2' as tipoDocumentoCNPJEmpresaHablic,
	cgm.z01_cgccpf as CNPJEmpresaHablic,
	(CASE length(cgmrep.z01_cgccpf) WHEN 11 THEN 1
		ELSE 2
	END) as tipoDocumentoSocio,	
	cgmrep.z01_cgccpf as nroDocumentoSocio,
	pcfornereprlegal.pc81_tipopart as tipoParticipacao	
	FROM licitacao.liclicita as liclicita 
	INNER JOIN licitacao.homologacaoadjudica as homologacaoadjudica on (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
	INNER JOIN licitacao.habilitacaoforn as habilitacaoforn on (liclicita.l20_codigo=habilitacaoforn.l206_licitacao)
	INNER JOIN compras.pcforne as pcforne on (habilitacaoforn.l206_fornecedor=pcforne.pc60_numcgm)
	INNER JOIN protocolo.cgm as cgm on (pcforne.pc60_numcgm=cgm.z01_numcgm)
	INNER JOIN compras.pcfornereprlegal as pcfornereprlegal on (pcforne.pc60_numcgm=pcfornereprlegal.pc81_cgmforn)
	INNER JOIN protocolo.cgm as cgmrep on (pcfornereprlegal.pc81_cgmresp=cgmrep.z01_numcgm)
	INNER JOIN configuracoes.db_config as db_config on (liclicita.l20_instit=db_config.codigo)
	WHERE db_config.codigo= " .db_getsession("DB_instit")."
	AND length(cgm.z01_cgccpf)>11
	AND liclicita.l20_codigo=  {$oDados10->codlicitacao}";


			$rsResult11 = db_query($sSql);
			for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {

				$clhablic112021 = new cl_hablic112021();
				$oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);
				//l20_codigo as codlicitacao
				$clhablic112021->si58_tiporegistro 		 				=11;
				$clhablic112021->si58_reg10                 				= $clhablic102021->si57_sequencial;
				$clhablic112021->si58_codorgao 							=$oDados11->codorgaoresp ;
				$clhablic112021->si58_codunidadesub 						=$oDados11->codunidadesubresp ;
				$clhablic112021->si58_exerciciolicitacao 					=$oDados11->exerciciolicitacao;
				$clhablic112021->si58_nroprocessolicitatorio 				=$oDados11->nroprocessolicitatorio;
				$clhablic112021->si58_tipodocumentocnpjempresahablic 		=$oDados11->tipodocumentocnpjempresahablic;
				$clhablic112021->si58_cnpjempresahablic 					=$oDados11->cnpjempresahablic;
				$clhablic112021->si58_tipodocumentosocio 					=$oDados11->tipodocumentosocio;
				$clhablic112021->si58_nrodocumentosocio 					=$oDados11->nrodocumentosocio;
				$clhablic112021->si58_tipoparticipacao					 	=$oDados11->tipoparticipacao;
				$clhablic112021->si58_mes				                    = $this->sDataFinal['5'].$this->sDataFinal['6'];

				$clhablic112021->incluir(null);
				if ($clhablic112021->erro_status == 0) {
					throw new Exception($clhablic112021->erro_msg);
				}

			}

			/**
			 * selecionar informacoes registro 20
			 */

		$sSql="select '20' as tipoRegistro,
		db_config.db21_tipoinstit as codOrgaoResp,
		(select db01_unidade from db_departorg where db01_coddepto=l20_codepartamento  and db01_anousu=".db_getsession("DB_anousu").") as codUnidadeSubResp,
		liclicita.l20_anousu as exercicioLicitacao,
		liclicita.l20_numero as nroProcessoLicitatorio,
		(CASE length(cgm.z01_cgccpf) WHEN 11 THEN 1
			ELSE 2
		END) as tipoDocumento,
		cgm.z01_cgccpf as nroDocumento,
		l205_datacred as DataCredenciamento,
		liclicitemlote.l04_codigo as nroLote,
		pcmater.pc01_codmater as codItem,
		pcforne.pc60_inscriestadual as nroInscricaoEstadual,
		pcforne.pc60_uf as ufInscricaoEstadual,
		habilitacaoforn.l206_numcertidaoinss as nroCertidaoRegularidadeINSS,
		habilitacaoforn.l206_dataemissaoinss as dataEmissaoCertidaoRegularidadeINSS,
		habilitacaoforn.l206_datavalidadeinss as dataValidadeCertidaoRegularidadeINSS,
		habilitacaoforn.l206_numcertidaofgts as nroCertidaoRegularidadeFGTS,
		habilitacaoforn.l206_dataemissaofgts as dataEmissaoCertidaoRegularidadeFGTS,
		habilitacaoforn.l206_datavalidadefgts as dataValidadeCertidaoRegularidadeFGTS,
		habilitacaoforn.l206_numcertidaocndt as nroCNDT,
		habilitacaoforn.l206_dataemissaocndt as dtEmissaoCNDT,
		habilitacaoforn.l206_datavalidadecndt as dtValidadeCNDT			
		FROM liclicita as liclicita 
		INNER JOIN homologacaoadjudica as homologacaoadjudica on (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
		INNER JOIN habilitacaoforn as habilitacaoforn on (liclicita.l20_codigo=habilitacaoforn.l206_licitacao)
		INNER JOIN compras.pcforne as pcforne on (habilitacaoforn.l206_fornecedor=pcforne.pc60_numcgm)
		INNER JOIN protocolo.cgm as cgm on (pcforne.pc60_numcgm=cgm.z01_numcgm)
		INNER JOIN credenciamento as credenciamento on (liclicita.l20_codigo=credenciamento.l205_licitacao)
		INNER JOIN configuracoes.db_config as db_config on (liclicita.l20_instit=db_config.codigo)
		INNER JOIN liclicitem as liclicitem on (liclicita.l20_codigo=liclicitem.l21_codliclicita and  liclicitem.l21_codigo=credenciamento.l205_item)
		INNER JOIN compras.pcprocitem as pcprocitem  on (liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem)
		INNER JOIN compras.solicitem as solicitem on (pcprocitem.pc81_solicitem = solicitem.pc11_codigo)
		INNER JOIN compras.solicitempcmater as solicitempcmater on (solicitem.pc11_codigo = solicitempcmater.pc16_solicitem)
		INNER JOIN compras.pcmater as pcmater on (solicitempcmater.pc16_codmater = pcmater.pc01_codmater)
		INNER JOIN liclicitemlote as liclicitemlote on (liclicitem.l21_codigo=liclicitemlote.l04_liclicitem)
		WHERE db_config.codigo=" .db_getsession("DB_instit")."
		AND liclicita.l20_codigo= {$oDados10->codlicitacao}";

			$rsResult20 = db_query($sSql);

			for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {

				$clhablic202121 = new cl_hablic202121();
				$oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);

				$clhablic202121->si59_tiporegistro											='20' ;
				$clhablic202121->si59_codorgao												=$oDados20->codorgaoresp  ;
				$clhablic202121->si59_codunidadesub											=$oDados20->codunidadesubresp  ;
				$clhablic202121->si59_exerciciolicitacao									=$oDados20->exerciciolicitacao ;
				$clhablic202121->si59_nroprocessolicitatorio								=$oDados20->nroprocessolicitatorio;
				$clhablic202121->si59_tipodocumento											=$oDados20->tipodocumento ;
				$clhablic202121->si59_nrodocumento											=$oDados20->nrodocumento  ;
				$clhablic202121->si59_datacredenciamento									=$oDados20->datacredenciamento;
				$clhablic202121->si59_nrolote												=$oDados20->nrolote  ;
				$clhablic202121->si59_coditem												=$oDados20->coditem  ;
				$clhablic202121->si59_nroinscricaoestadual									=$oDados20->nroinscricaoestadual ;
				$clhablic202121->si59_ufinscricaoestadual									=$oDados20->ufinscricaoestadual  ;
				$clhablic202121->si59_nrocertidaoregularidadeinss							=$oDados20->nrocertidaoregularidadeinss  ;
				$clhablic202121->si59_dataemissaocertidaoregularidadeinss					=$oDados20->dataemissaocertidaoregularidadeinss  ;
				$clhablic202121->si59_dtvalidadecertidaoregularidadeinss					=$oDados20->datavalidadecertidaoregularidadeinss;
				$clhablic202121->si59_nrocertidaoregularidadefgts							=$oDados20->nrocertidaoregularidadefgts  ;
				$clhablic202121->si59_dtemissaocertidaoregularidadefgts						=$oDados20->dataemissaocertidaoregularidadefgts  ;
				$clhablic202121->si59_dtvalidadecertidaoregularidadefgts					=$oDados20->datavalidadecertidaoregularidadefgts;
				$clhablic202121->si59_nrocndt												=$oDados20->nrocndt  ;
				$clhablic202121->si59_dtemissaocndt 										=$oDados20->dtemissaocndt ;
				$clhablic202121->si59_dtvalidadecndt 										=$oDados20->dtvalidadecndt;
				$clhablic202121->si59_mes 											        = $this->sDataFinal['5'].$this->sDataFinal['6'];

				$clhablic202121->incluir(null);
				if ($clhablic202121->erro_status == 0) {
					throw new Exception($clhablic202121->erro_msg);
				}

			}




		}
		db_fim_transacao();

		$oGerarHABLIC = new GerarHABLIC();
		$oGerarHABLIC->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
		$oGerarHABLIC->gerarDados();

	}
}
