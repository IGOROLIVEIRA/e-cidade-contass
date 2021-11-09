<?php

require_once('model/CgmFactory.model.php');
require_once('model/cadastro/construcao.model.php');

/**
 * Classe para manipuação de imóveis
 *
 * @author   Rafael Serpa Nery  rafael.nery@dbseller.com.br
 * @author   Alberto Ferri Neto alberto@dbseller.com.br
 * @package  Cadastro
 * @revision $Author: dbrafael.nery $
 * @version  $Revision: 1.1 $
 */
class Imovel {
	
	/**
	 * Matricula de registro do imóvel
	 * @var integer
	 */
	private $iMatricula;
	
	/**
	 * Código do lote do imóvel 
	 * @var integer
	 */
	private $iCodigoLote;
	
	/**
	 * Data da baixa do imóvel
	 * @var date
	 */
	private $dtDataBaixa;
	
	/**
	 * Código de averbação do imóvel
	 * @var integer
	 */
	private $iCodigoAverbacao;
	
	/**
	 * Número da fração do imóvel 
	 * @var float
	 */
	private $nFracao;
	
	/**
	 * 
	 * Coleção com todos os proprietarios do imóvel
	 * @var array
	 */
	private $aProprietarios = array();
	
	/**
 	 *
	 * Coleção com todos os promitentes do imóvel
	 * @var array
	 */
	private $aPromitentes = array();
	
	/**
	 * Construtor da Classe
	 * @param integer $iMatricula - Matricula de registro do imóvel
	 */
	public function __construct( $iMatricula = null ) {
		
		/**
		 * Valida se a matricula informada é valida e define os atributos
		 */
		if ( !empty($iMatricula) ) {
		  
		  $oDaoIPTUBase = db_utils::getDao('iptubase');
		  
		  $sSqlImovel   = $oDaoIPTUBase->sql_query_file($iMatricula);
		  $rsImovel     = $oDaoIPTUBase->sql_record($sSqlImovel);
		  
		  if ( $oDaoIPTUBase->erro_status == "0" ) {
        throw new Exception("Erro ao selecionar dados da tabela issbase: \n".$oDaoIPTUBase->erro_msg);		  	
		  }
		  
		  $oImovel                = db_utils::fieldsMemory($rsImovel, 0);
		  $this->iMatricula       = $iMatricula;
		  $this->iCodigoLote      = $oImovel->j01_idbql;
		  $this->iCodigoLote      = $oImovel->j01_idbql;
		  $this->dtDataBaixa          = $oImovel->j01_baixa;
		  $this->iCodigoAverbacao = $oImovel->j01_codave;
		  $this->nFracao          = $oImovel->j01_fracao;
		  
		  /**
		   * Busca Proprietários do Imovel
		   */
		  $sSqlProprietarios      = $oDaoIPTUBase->sql_query_proprietarios($iMatricula);
		  $rsProprietarios        = $oDaoIPTUBase->sql_record($sSqlProprietarios);
		  
			if ( (int)$oDaoIPTUBase->erro_status == 0 && !empty($oDaoIPTUBase->erro_banco) ) {
        throw new Exception("Erro Construtor da Classe: \n".$oDaoIPTUBase->erro_msg);		  	
		  }
		  
		  $aProprietarios         = db_utils::getCollectionByRecord($rsProprietarios);
		  
		  foreach ($aProprietarios as $oProprietario) {
				$this->aProprietarios[$oProprietario->j01_numcgm] = CgmFactory::getInstanceByCgm($oProprietario->j01_numcgm);
		  }
		  /**
		   * Busca promitente do Imovel
		   */
		  $sSqlPromitentes       = $oDaoIPTUBase->sql_query_promitentes($iMatricula);
		  $rsPromitentes         = $oDaoIPTUBase->sql_record($sSqlPromitentes);
		  
			if ( (int)$oDaoIPTUBase->erro_status == 0 && !empty($oDaoIPTUBase->erro_banco) ) {
		    throw new Exception("Erro Construtor da Classe: \n".$oDaoIPTUBase->erro_msg);
		  }
		  
		  $aPromitentes          = db_utils::getCollectionByRecord($rsPromitentes);
		  
		  foreach ($aPromitentes as $oPromitente) {
		  	$this->aPromitentes[$oPromitente->j41_numcgm] = CgmFactory::getInstanceByCgm($oPromitente->j41_numcgm);
		  }
		}
	}

	/**
	 * Retorna Matricula do imóvel
	 * @return integer
	 */
	public function getMatricula()
	{
	    return $this->iMatricula;
	}

	/**
	 * Define matrícula do imóvel
	 * @param $iMatricula
	 */
	public function setMatricula($iMatricula) {
		$this->iMatricula = $iMatricula;
	}

	/**
	 * Retorna código do lote do imóvel
	 * @return integer
	 */
	public function getCodigoLote() {
		return $this->iCodigoLote;
	}

	/**
	 * Define código do lote do imóvel
	 * @param $iCodigoLote
	 */
	public function setCodigoLote($iCodigoLote)	{
		$this->iCodigoLote = $iCodigoLote;
	}

	/**
	 * Retorna data da baixa do imóvel
	 * @return date
	 */
	public function getDataBaixa()
	{
		return $this->dtDataBaixa;
	}

	/**
	 * Define data da baixa do imóvel
	 * @param $dtDataBaixa
	 */
	public function setDataBaixa($dtDataBaixa) {
		$this->dtDataBaixa = $dtDataBaixa;
	}

	/**
	 * Retorna código da averbação
	 * @return integer
	 */
	public function getCodigoAverbacao() {
		return $this->iCodigoAverbacao;
	}

	/**
	 * Define código da averbação
	 * @param $iCodigoAverbacao
	 */
	public function setCodigoAverbacao($iCodigoAverbacao) {
		$this->iCodigoAverbacao = $iCodigoAverbacao;
	}

	/**
	 * Retorna fração do imóvel
	 * @return float
	 */
	public function getFracao() {
		return $this->nFracao;
	}

	/**
	 * Define fração do imóvel
	 * @param $nFracao
	 */
	public function setFracao($nFracao) {
		$this->nFracao = $nFracao;
	}

	/**
	 * Salva registros na base de dados
	 */
	public function salvar() {

	}

	/**
	 * Retorna os proprietários do imóvel
	 * @return array
	 */
	public function getProprietarios() {
		return $this->aProprietarios;
	}

	/**
	 * Retorna os promitentes do imóvel
	 * @return array
	 */
	public function getPromitentes() {
		return $this->aPromitentes;
	}

	/**
	 * Retorna o proprietário principal do imóvel
	 * @return object
	 */
	public function getProprietarioPrincipal() {

		$oDaoIPTUBase          = db_utils::getDao('iptubase');
		$sSqlProprietarios     = $oDaoIPTUBase->sql_query_proprietarios($this->iMatricula, true);
		$rsProprietarios       = $oDaoIPTUBase->sql_record($sSqlProprietarios);

		if ( (int)$oDaoIPTUBase->erro_status == 0 && !empty($oDaoIPTUBase->erro_banco) ) {
			throw new Exception("Erro Construtor da Classe: \n".$oDaoIPTUBase->erro_msg);
		}

		$oProprietario = db_utils::fieldsMemory($rsProprietarios, 0);

		return CgmFactory::getInstanceByCgm($oProprietario->j01_numcgm);

	}

	/**
	 * Retorna uma instância do cgm do promitente principal do imóvel
	 * @return object
	 */
	public function getPromitentePrincipal() {

		$oDaoIPTUBase          = db_utils::getDao('iptubase');
		$sSqlPromitentes       = $oDaoIPTUBase->sql_query_promitentes($this->iMatricula, true);
		$rsPromitentes         = $oDaoIPTUBase->sql_record($sSqlPromitentes);

		if ( (int)$oDaoIPTUBase->erro_status == 0 && !empty($oDaoIPTUBase->erro_banco) ) {
			throw new Exception("Erro Construtor da Classe: \n".$oDaoIPTUBase->erro_msg);
		}

		$oPromitente = db_utils::fieldsMemory($rsPromitentes, 0);

		return CgmFactory::getInstanceByCgm($oPromitente->j41_numcgm);

	}

	/**
	 * Retorna responsável legal do imovel 
	 */
	public function getResponsavelLegal() {
			

	}

	/**
	 *
	 * Retorna todas as construções vinculadas a obra
	 * @return array com instancia da classe Construcao
	 */
	public function getConstrucoes() {

		$oDaoIPTUConstr  = db_utils::getDao('iptuconstr');

		$sSqlConstrucoes = $oDaoIPTUConstr->sql_query_file($this->iMatricula, null, 'j39_idcons');

		$rsConstrucoes   = $oDaoIPTUConstr->sql_record($sSqlConstrucoes);

		if (!$rsConstrucoes) {
			throw new Exception('Erro ao selecionar dados da tabela iptuconstr.');
		}

		$aIdConstrucoes = db_utils::getCollectionByRecord($rsConstrucoes);

		$aConstrucoes = array();

		/**
		 * Constroi um array com a instancia do objeto construções
		 */
		foreach ($aIdConstrucoes as $oConstrucao) {
				
			$aConstrucoes[$oConstrucao->j39_idcons] = new Construcao($this->iMatricula, $oConstrucao->j39_idcons);
		}

		return $aConstrucoes;


	}
}