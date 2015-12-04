<?php
require_once('libs/exceptions/DBException.php');

/**
 * Classe utilizada para salvar e verificar as regras 
 * referende ao Lanзamento no ponto
 *
 * @package  Pessoal
 * @author   Renan Melo <renan@dbseller.com.br>
 */
class RegraLancamento {

	/**
	 * Codigo da Regra
	 * @var integer
	 * @access private
	 */
	private $iRegraCodigo;

	/**
	 * Descriзгo da Regra
	 * @var string $sDescricao
	 * @access public
	 */
	public $sDescricao;

  /**
   * Selecao que a regra pertence.
   * @var integer $iSelecao
   * @access public
   */
	public $iSelecao;

  /**
   * Comportamento que a regra deve obedecer
   * - 1 -> Aviso
   * - 2 -> Bloqueio
   * @var integer $iComportamento
   * @access public
   */
	public $iComportamento;

	/**
	 * Rubbricas selecionadas para a regra
	 * @var Array
	 * @access public
	 */
	public $aRubricas;


	function __construct ( $iCodigoRegra = null ) {
		
		if ( $iCodigoRegra ) {
			
		}
	}

	/**
	 * Seta a descriзгo da Regra
	 * 
	 * @param String $sDescricao.
	 * @access public
	 * @return void.
	 */
	public function setDescricao ($sDescricao) {
		$this->sDescricao = $sDescricao;	
	}

	/**
	 * Seta a seleзгo da regra
	 * 
	 * @param integer $iSelecao.
	 * @access public
	 * @return void.
	 */
	public function setSelecao ($iSelecao) {
		$this->iSelecao = $iSelecao;
	}

	/**
	 * Seta o comportamento da Regra
	 * - 1 -> Aviso
   * - 2 -> Bloqueio
   * 
	 * @param integer $iComportamento.
	 * @access public
	 * @return void.
	 */
	public function setComportamento ($iComportamento) {
		$this->iComportamento = $iComportamento;		
	}

	/**
	 * Seta as Rubricas selecionadas para a Regra
	 * 
	 * @param array $aRubricas.
	 * @access public
	 * @return void.
	 */
	public function setRubricas($aRubricas) {
		$this->aRubricas = $aRubricas;
	}

	/**
	 * Salvar os dados referente a regra na tabela regraPonto
	 * Salva tambйm as Rubricas que sгo vinculadas a esta Regra.
	 * 
	 * @access public
	 * @return bollean.
	 */
	public function salvar() {
		
		$oDaoRegraPonto = db_utils::getDao('regraponto');

		$oDaoRegraPonto->rh123_descricao 		 = $this->sDescricao;
		$oDaoRegraPonto->rh123_selecao 			 = $this->iSelecao;
		$oDaoRegraPonto->rh123_comportamento = $this->iComportamento;
		$oDaoRegraPonto->incluir(null);

		$this->iRegraCodigo = $oDaoRegraPonto->rh123_sequencial;

		if ( $oDaoRegraPonto->erro_status == "0" ) {
			throw new DBException("Nгo foi possнvel cadastrar a Regra para o Ponto. {$oDaoRegraPonto->erro_msg}");
		}

		/**
		 * realliza chamada da funзгo salvarRubricasRegra.
		 */
		$this->salvarRubricasRegra();		

		return true;
	}

	/**
	 * Salva as rubricas referente a regra cadastrada
	 * 
	 * @access private
	 * @return bollean.
	 */
	private function salvarRubricasRegra() {
	
		db_utils::getDao('regrapontorubrica', false);
		$oDaoRegraPontoRubrica = new cl_regrapontorubrica();
		$oDaoRegraPontoRubrica->rh124_regraponto  = $this->iRegraCodigo; 
		$oDaoRegraPontoRubrica->rh124_instituicao = db_getsession('DB_instit');

		/**
		 * Percorre todas as rubricas selecionadas inserindo na tabela regrapontorubricas
		 */
		foreach ($this->aRubricas as $iRubricas) {

			$oDaoRegraPontoRubrica->rh124_rubrica = $iRubricas;
			$oDaoRegraPontoRubrica->incluir(null);

			if ( $oDaoRegraPontoRubrica->erro_status == "0" ) {
				throw new DBException("Nгo foi possнvel cadastrar a Rubrica: $iRubricas para a regra. {$oDaoRegraPontoRubrica->erro_msg}");
			}
		}

		return true;
	}


	public function testarRegistroPonto() {
	
	}

}


?>