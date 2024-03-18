<?php
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2014  DBSeller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */

/**
 * Model dos Afastamentos de Servidor
 *
 * @package pessoal
 * @author Alberto <alberto@dbseller.com.br>
 */
class Afastamento
{

	const AFASTADO_DOENCA_MAIS_30_DIAS = 6;
	const AFASTADO_DOENCA_MAIS_15_DIAS = 6;
	const AFASTADO_SEM_REMUNERACAO = 7;
	const LICENCA_SEM_VENCIMENTO = 7;
	const AFASTADO_ACIDENTE_TRABALHO_MAIS_15_DIAS = 3;
	const AFASTADO_SERVICO_MILITAR = 3;
	const AFASTADO_LICENCA_GESTANTE = 3;


	/**
	 * Código Afastamento r69_codigo
	 * @var integer 
	 */
	private $iCodigo;

	/**
	 * Matrícula servidor r69_regist
	 * @var integer
	 */
	private $iMatricula;

	/**
	 * Código do tipo de Afastamento -- Campo n�o utilizado
	 * @var integer
	 *
	 * private $iTipoAfastamento;
	 */

	/**
	 * Instância do objeto DBDate com a data do afastamento ou Afastamento r69_dtafast
	 * @var DBDate
	 */
	private $oDataAfasta;

	/**
	 * Instância do objeto DBDate com a data do retorno afastamento/Afastamento r69_dtretorno
	 * @var DBDate
	 */
	private $oDataRetorno;

	/**
	 * Histórico do Afastamento
	 * @var string
	 *private $sHistorico;
	 */

	/**
	 * Código da portaria emitida
	 * @var string
	 *private $sCodigoPortaria;
	 */
	/**
	 * Descrição do ato oficial
	 * @var string
	 *private $sDescricaoAto;
	 */
	/**
	 * Mês do afastamento r69_mesusu
	 * @var integer	 
	 */
	private $iMesAfasta;

	/**
	 * Percentual concedido
	 * @var number
	 *private $nPercentual;
	 */
	/**
	 * Segundo Histórico do Afastamento
	 * @var string
	 *private $sSegundoHistorico;
	 */
	/**
	 * Login do usu�rio que registrou o asssentamento/afastamento r69_login
	 * @var string
	 */
	private $sLoginUsuario;


	/**
	 * Instância do objeto DBDate com a data de lançamento do afastamento ou Afastamento r69_dtlanc
	 * @var DBDate
	 */
	private $oDataLancamento;

	/**
	 * Se registro foi convertido
	 * @var boolean
	 *private $lConvertido;
	 */
	/**
	 * Ano do afastamento r69_anousu
	 * @var integer
	 */
	private $iAnoAfasta;

	/**
	 * Obejeto contendo o valor e a quantidade para ser lancado na rubrica para pagamento
	 * @var stdClass
	 *private $oValorQuantidade;
	 */
	/**
	 * Guarda mensagem de erro na execução de métodos
	 * @var String
	 */
	private $sErro;

	/**
	 * Construtor da classe
	 * 
	 * @param Integer $iCodigo
	 */
	public function __construct($iCodigo = null)
	{

		/*if ( empty($iCodigo) ) {
			return;
		}

		$oDaoAfastamento = db_utils::getDao('afastamento');
		$sSqlAfastamento = $oDaoAfastamento->sql_query_file($iCodigo);
		$rsAfastamento   = $oDaoAfastamento->sql_record($sSqlAfastamento);

		if ($oDaoAfastamento->numrows == 0) {
			throw new BusinessException('Nenhum Afastamento encontrado.');
		}

		$oAfastamento = db_utils::fieldsMemory($rsAfastamento, 0);

		$this->setCodigo          ($oAfastamento->h16_codigo);
		$this->setMatricula       ($oAfastamento->h16_regist);
		$this->setTipoAfastamento($oAfastamento->h16_assent);
		$this->setHistorico       ($oAfastamento->h16_histor);
		$this->setCodigoPortaria  ($oAfastamento->h16_nrport);
		$this->setDescricaoAto    ($oAfastamento->h16_atofic);
		$this->setDias            ($oAfastamento->h16_quant);
		$this->setPercentual      ($oAfastamento->h16_perc);
		$this->setSegundoHistorico($oAfastamento->h16_hist2);
		$this->setLoginUsuario    ($oAfastamento->h16_login);
		$this->setDataLancamento  ($oAfastamento->h16_dtlanc);
		$this->setConvertido      ($oAfastamento->h16_conver);
		$this->setAnoPortaria     ($oAfastamento->h16_anoato);

		if( !empty($oAfastamento->h16_dtconc) ){
			$oDataAfasta = new DBDate($oAfastamento->h16_dtconc);
		  $this->setDataConcessao ($oDataAfasta);
		}

		if( !empty($oAfastamento->h16_dtterm) ){
			$oDataRetorno = new DBDate($oAfastamento->h16_dtterm);
		  $this->setDataTermino   ($oDataRetorno);
		}*/
	}

	/**
	 * Retorna o código do Afastamento
	 * @return number
	 */
	public function getCodigo()
	{
		return $this->iCodigo;
	}

	/**
	 * Define o código do Afastamento
	 * @param integer $iCodigo
	 */
	public function setCodigo($iCodigo)
	{
		$this->iCodigo = $iCodigo;
	}

	/**
	 * Retorna a matrícula do servidor do Afastamento
	 * @return integer
	 */
	public function getMatricula()
	{
		return $this->iMatricula;
	}

	/**
	 * Define a matrícula do servidor do Afastamento
	 * @param unknown $iMatricula
	 */
	public function setMatricula($iMatricula)
	{
		$this->iMatricula = $iMatricula;
	}

	/**
	 * Define o tipo de Afastamento
	 * @return integer
	 */
	public function getTipoAfastamento()
	{
		return $this->iTipoAfastamento;
	}

	/**
	 * Define o tipo de assentamneto
	 * @param integer $iTipoAfastamento
	 */
	public function setTipoAfastamento($iTipoAfastamento)
	{
		$this->iTipoAfastamento = $iTipoAfastamento;
	}

	/**
	 * Retorna a data de concessão do afastamento
	 * @return DBDate
	 */
	public function getDataConcessao()
	{
		return $this->oDataAfasta;
	}

	/**
	 * Define a data de concessão do afastamento
	 * @param DBDate $oDataAfasta
	 */
	public function setDataConcessao(DBDate $oDataAfasta)
	{
		$this->oDataAfasta = $oDataAfasta;
	}

	/**
	 * Define o histórico do afastamento
	 * @return string
	 */
	public function getHistorico()
	{
		return $this->sHistorico;
	}

	/**
	 * Define o histório do afastamento
	 * @param unknown $sHistorico
	 */
	public function setHistorico($sHistorico)
	{
		$this->sHistorico = $sHistorico;
	}

	/**
	 * Retorna o código da portaria
	 * @return string
	 */
	public function getCodigoPortaria()
	{
		return $this->sCodigoPortaria;
	}

	/**
	 * Define o código da portaria
	 * @param unknown $sCodigoPortaria
	 */
	public function setCodigoPortaria($sCodigoPortaria)
	{
		$this->sCodigoPortaria = $sCodigoPortaria;
	}

	/**
	 * Retorna a descrição do ato
	 * @return string
	 */
	public function getDescricaoAto()
	{
		return $this->sDescricaoAto;
	}

	/**
	 * Define a descrição do ato
	 * @param string $sDescricaoAto
	 */
	public function setDescricaoAto($sDescricaoAto)
	{
		$this->sDescricaoAto = $sDescricaoAto;
	}

	/**
	 * Retorna o n�mero de dias do afastametno
	 * @return number
	 */
	public function getDias()
	{
		return $this->iMesAfasta;
	}

	/**
	 * Define o n�mero de dias do afastamento
	 * @param integer $iMesAfasta
	 */
	public function setDias($iMesAfasta)
	{
		$this->iMesAfasta = $iMesAfasta;
	}

	/**
	 * Retorna o percentual do afastamento
	 * @return number
	 */
	public function getPercentual()
	{
		return $this->nPercentual;
	}

	/**
	 * Define o percentual do afastamento
	 * @param number $nPercentual
	 */
	public function setPercentual($nPercentual)
	{
		$this->nPercentual = $nPercentual;
	}

	/**
	 * Retorna uma instância do objeto DBDate com a data do afastamento
	 * @return DBDate
	 */
	public function getDataTermino()
	{
		return $this->oDataRetorno;
	}

	/**
	 * Define uma instância do objeto DBDate com a  data de termino do afastamento/Afastamento
	 * @paramDBDate $oDataRetorno
	 */
	public function setDataTermino(DBDate $oDataRetorno)
	{
		$this->oDataRetorno = $oDataRetorno;
	}

	/**
	 * Retorna o segundo histórico do afastamento
	 * @return string
	 */
	public function getSegundoHistorico()
	{
		return $this->sSegundoHistorico;
	}

	/**
	 * Define o segundo histórico do afastamento
	 * @param string $sSegundoHistorico
	 */
	public function setSegundoHistorico($sSegundoHistorico)
	{
		$this->sSegundoHistorico = $sSegundoHistorico;
	}

	/**
	 * Retorna o login do usu�rio
	 * @return string
	 */
	public function getLoginUsuario()
	{
		return $this->sLoginUsuario;
	}

	/**
	 * Define o login do usu�rio
	 * @param string $sLoginUsuario
	 */
	public function setLoginUsuario($sLoginUsuario)
	{
		$this->sLoginUsuario = $sLoginUsuario;
	}

	/**
	 * Retorna uma instância do objeto DBDate com a data de lançamento do afastamento / Afastamento
	 * @return DBDate
	 */
	public function getDataLancamento()
	{
		return $this->oDataLancamento;
	}

	/**
	 * Define uma instância do objeto DBDate com a data de lançamento do afastamento / Afastamento
	 * @param unknown $oDataLancamento
	 */
	public function setDataLancamento($oDataLancamento)
	{
		$this->oDataLancamento = $oDataLancamento;
	}

	/**
	 * Retorna se o afastamento foi convertido
	 * @return boolean
	 */
	public function isConvertido()
	{
		return $this->lConvertido;
	}

	/**
	 * Define se o registro foi convertido
	 * @param boolean $lConvertido
	 */
	public function setConvertido($lConvertido)
	{
		$this->lConvertido = $lConvertido;
	}

	/**
	 * Retorna o ano da portaria
	 * @return number
	 */
	public function getAnoPortaria()
	{
		return $this->iAnoAfasta;
	}

	/**
	 * Define o ano da portaria
	 * @param integer $iAnoAfasta
	 */
	public function setAnoPortaria($iAnoAfasta)
	{
		$this->iAnoAfasta = $iAnoAfasta;
	}

	/**
	 * Retorna a mensagem de erro
	 * @return String
	 */
	public function getErro()
	{
		return $this->sErro;
	}

	/**
	 * Persist na base um Afastamento
	 * @return mixed true | String mensagem de erro
	 */
	public function persist()
	{

		$classenta       = new cl_assenta();
		$clafasta        = new cl_afasta();
		$clAfastaAssenta = new cl_afastaassenta();

		$classenta->h16_regist  = $this->getMatricula();
		$classenta->h16_assent  = $this->getTipoAfastamento();
		$classenta->h16_dtconc  = ($this->getDataConcessao() instanceof DBDate ? $this->getDataConcessao()->getDate() : $this->getDataConcessao());
		$classenta->h16_histor  = $this->getHistorico();
		$classenta->h16_nrport  = $this->getCodigoPortaria();
		$classenta->h16_atofic  = $this->getDescricaoAto();
		$classenta->h16_quant   = $this->getDias();
		$classenta->h16_perc    = $this->getPercentual();
		$classenta->h16_dtterm  = ($this->getDataTermino() instanceof DBDate ? $this->getDataTermino()->getDate() : $this->getDataTermino());
		$classenta->h16_hist2   = $this->getSegundoHistorico();
		$classenta->h16_login   = $this->getLoginUsuario();
		$classenta->h16_dtlanc  = ($this->getDataLancamento() instanceof DBDate ? $this->getDataLancamento()->getDate() : $this->getDataLancamento());
		$classenta->h16_conver  = $this->isConvertido();
		$classenta->h16_anoato  = $this->getAnoPortaria();

		if (empty($this->iCodigo)) {

			if (!$classenta->incluir(null)) {
				return $classenta->erro_msg;
			}
			$this->setCodigo($classenta->h16_codigo);
		} else {

			$classenta->h16_codigo = $this->getCodigo();
			if (!$classenta->alterar($this->getCodigo())) {
				return $classenta->erro_msg;
			}
		}

		/**
		 * Incluimos na tabela assenta e criamos uma relação entre os Afastamentos do pessoal e do rh
		 * incluendo as chaves na tabela afastaassenta
		 */
		$oInformacoesExternas = InformacoesExternasTipoAfastamento::getInstance(TipoAfastamentoRepository::getInstanciaPorCodigo($this->getTipoAfastamento()));

		if (!$oInformacoesExternas->getSefip()) {
			return true;
		}

		/**
		 * Verificamos se é alteração
		 */
		if (!empty($this->iCodigo)) {

			$sSqlAfastaAssenta = $clAfastaAssenta->sql_query_file(null, "h81_afasta", null, "h81_assenta = {$this->iCodigo}");
			$rsAfastaAssenta   = db_query($sSqlAfastaAssenta);

			if (!$rsAfastaAssenta) {
				throw new DBException($rsAfastaAssenta->erro_msg);
			}

			if (pg_num_rows($rsAfastaAssenta) > 0) {
				$iCodigoAfastamento = db_utils::fieldsMemory($rsAfastaAssenta, 0)->h81_afasta;
			}
		}


		$clafasta->r45_anousu = $oInformacoesExternas->getCompetencia()->getAno();
		$clafasta->r45_mesusu = $oInformacoesExternas->getCompetencia()->getMes();
		$clafasta->r45_regist = $this->getMatricula();
		$clafasta->r45_dtafas = ($this->getDataConcessao() instanceof DBDate ? $this->getDataConcessao()->getDate() : $this->getDataConcessao());
		$clafasta->r45_dtreto = ($this->getDataTermino() instanceof DBDate ? $this->getDataTermino()->getDate() : $this->getDataTermino());
		$clafasta->r45_situac = $oInformacoesExternas->getSituacaoAfastamento();
		$clafasta->r45_dtlanc = ($this->getDataLancamento() instanceof DBDate ? $this->getDataLancamento()->getDate() : $this->getDataLancamento());
		$clafasta->r45_codafa = $oInformacoesExternas->getSefip();
		$clafasta->r45_codret = $oInformacoesExternas->getCodigoRetorno();
		$clafasta->r45_obs    = $this->getHistorico();

		if (isset($iCodigoAfastamento)) {

			$clafasta->r45_codigo = $iCodigoAfastamento;
			$clafasta->alterar($iCodigoAfastamento);
		} else {
			$clafasta->incluir(null);
		}

		if ($clafasta->erro_status == "0") {
			throw new DBException($clafasta->erro_msg);
		}

		if (!isset($iCodigoAfastamento)) {

			$clAfastaAssenta->h81_assenta = $classenta->h16_codigo;
			$clAfastaAssenta->h81_afasta  = $clafasta->r45_codigo;
			$clAfastaAssenta->incluir();

			if ($clAfastaAssenta->erro_status == "0") {
				throw new DBException($clAfastaAssenta->erro_msg);
			}
		}

		/**
		 * Realiza a proporcionalização no ponto
		 */
		$oCompetencia = DBPessoal::getCompetenciaFolha();
		$oServidor    = ServidorRepository::getInstanciaByCodigo($this->getMatricula(), $oCompetencia->getAno(), $oCompetencia->getMes());
		$oProporcionalizacaoPontoSalario = new ProporcionalizacaoPontoSalario($oServidor->getPonto(Ponto::SALARIO), $oInformacoesExternas->getSituacaoAfastamento(), $this->getDataTermino());
		$oProporcionalizacaoPontoSalario->processar();

		return true;
	}

	/**
	 * Transforma o objeto em um formato JSON
	 * @return JSON
	 */
	public function toJSON()
	{

		$oServidor             = ServidorRepository::getInstanciaByCodigo(
			$this->getMatricula(),
			DBPessoal::getAnoFolha(),
			DBPessoal::getMesFolha()
		);
		$aRetorno["codigo"]            = $this->getCodigo();
		$aRetorno["tipo"]              = $this->getTipoAfastamento();
		$aRetorno["natureza"]          = "padrao";
		$aRetorno["cgm_servidor"]      = $oServidor->getCgm()->getCodigo();
		$aRetorno["nome_servidor"]     = $oServidor->getCgm()->getNome();

		$aRetorno["matricula"]         = $this->getMatricula();
		$aRetorno["dataConcessao"]     = ($this->getDataConcessao() instanceof DBDate ? $this->getDataConcessao()->getDate(DBDate::DATA_PTBR) : $this->getDataConcessao());
		$aRetorno["historico"]         = $this->getHistorico();
		$aRetorno["codigoPortaria"]    = $this->getCodigoPortaria();
		$aRetorno["descricaoAto"]      = $this->getDescricaoAto();
		$aRetorno["dias"]              = $this->getDias();
		$aRetorno["percentual"]        = $this->getPercentual();
		$aRetorno["dataTermino"]       = ($this->getDataTermino() instanceof DBDate ? $this->getDataTermino()->getDate(DBDate::DATA_PTBR) : $this->getDataTermino());
		$aRetorno["segundoHistorico"]  = $this->getSegundoHistorico();
		$aRetorno["loginUsuario"]      = $this->getLoginUsuario();
		$aRetorno["dataLancamento"]    = ($this->getDataLancamento() instanceof DBDate ? $this->getDataLancamento()->getDate(DBDate::DATA_PTBR) : $this->getDataLancamento());
		$aRetorno["convertido"]        = (int)$this->isConvertido();
		$aRetorno["anoPortaria"]       = $this->getAnoPortaria();

		return json_encode((object)$aRetorno);
	}

	/**
	 * Seta o valor/quantidae para a formula executada
	 * 
	 * @param  String $sFormula
	 * 
	 * @return  void
	 */
	private function setValorQuantidadePorFormula($sFormula = null)
	{

		$oTipoAfastamento = TipoAfastamentoRepository::getInstanciaPorCodigo($this->getTipoAfastamento());
		$oDbformula        = new DBFormulaAfastamento($this);

		if (empty($sFormula)) {
			$sFormula        = $oTipoAfastamento->getVariavelTipoAfastamentoFinanceiro();
		}

		$oStdValorQtde               = new stdClass();
		$oStdValorQtde->valor        = 0;
		$oStdValorQtde->quantidade   = 0;
		$this->oValorQuantidade      = $oStdValorQtde;

		try {

			if ($sFormula === false) {
				throw new BusinessException("N�o foi possível recuperar a fórmula.");
			}

			$sSqlValorQuantidade = $oDbformula->parse("SELECT [" . $sFormula . "]");
			$rsValorQuantidade   = db_query($sSqlValorQuantidade);

			if (!$rsValorQuantidade) {
				throw new DBException("Ocorreu um erro ao recuperar o valor/quantidade da formula.");
			}

			if (pg_num_rows($rsValorQuantidade) > 0) {
				$sFieldName       = pg_field_name($rsValorQuantidade, 0);
				$nValorQuantidade = pg_result($rsValorQuantidade, 0, $sFieldName);
			}

			if ($oTipoAfastamento->getTipoLancamentoTipoAfastamentoFinanceiro() != 1 && $oTipoAfastamento->getTipoLancamentoTipoAfastamentoFinanceiro() != 2) {
				throw new BusinessException("N�o foi possível obter o tipo de lancamento da rubrica configurada para o Afastamento.");
			}

			if ($oTipoAfastamento->getTipoLancamentoTipoAfastamentoFinanceiro() == 1) {
				$oStdValorQtde->valor      = $nValorQuantidade;
			}

			if ($oTipoAfastamento->getTipoLancamentoTipoAfastamentoFinanceiro() == 2) {
				$oStdValorQtde->quantidade = $nValorQuantidade;
			}

			$this->oValorQuantidade      = $oStdValorQtde;
		} catch (Exception $oErro) {
			$this->sErro = $oErro->getMessage();
		}
	}

	/**
	 * Retorna o valor para formula executada a ser lançado no ponto do servidor
	 * 
	 * @return Number
	 */
	public function getValorPorFormula()
	{

		if (empty($this->oValorQuantidade)) {
			$this->setValorQuantidadePorFormula();
		}

		return $this->oValorQuantidade->valor;
	}

	/**
	 * Retorna a quantidade para formula executada a ser lançada no ponto do servidor
	 * 
	 * @return Number
	 */
	public function getQuantidadePorFormula()
	{

		if (empty($this->oValorQuantidade)) {
			$this->setValorQuantidadePorFormula();
		}

		return $this->oValorQuantidade->quantidade;
	}

	/**
	 * Retorna uma intância de LoteRegistroPonto caso o Afastamento esteja vinculado a um Lote.
	 *
	 * @return LoteRegistroPonto Lote no qual o Afastamento esta vinculado
	 */
	public function getLote()
	{

		$oDaoAssentaloteregistroponto = new cl_assentaloteregistroponto();
		$sSqlAssentaloteregistroponto = $oDaoAssentaloteregistroponto->sql_query_file(null, "rh160_loteregistroponto", null, "rh160_Afastamento = {$this->getCodigo()}");
		$rsAssentaloteregistroponto   = db_query($sSqlAssentaloteregistroponto);

		if (!$rsAssentaloteregistroponto) {
			throw new DBException("Erro ao verificar se o Afastamento possui lote");
		}

		if (pg_num_rows($rsAssentaloteregistroponto) > 0) {

			$iLoteRegistroPonto = db_utils::fieldsMemory($rsAssentaloteregistroponto, 0)->rh160_loteregistroponto;
			return LoteRegistrosPontoRepository::getInstanceByCodigo($iLoteRegistroPonto);
		}

		return false;
	}
}
