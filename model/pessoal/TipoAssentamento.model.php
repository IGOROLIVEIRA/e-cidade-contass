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
 * Model para Tipos de assentamentos
 *
 * @package pessoal
 * @author Renan Silva <renan.silva@dbseller.com.br>
 */
class TipoAssentamento {

	/**
	 * Código do tipo de assentamento
	 * 
	 * @var Integer
	 */
	private $iCodigo;

	public function __construct($iCodigo) {

		if ( empty($iCodigo) ) {
			return;
		}
		
		$this->setCodigo($iCodigo);
	}

	/**
	 * Retorna o código do tipo de assentamento
	 * @return Integer
	 */
	public function getCodigo() {
		return $this->iCodigo;
	}

	/**
	 * Define o código do tipo de assentamento
	 * @param Integer $iCodigo
	 */
	public function setCodigo($iCodigo) {
		$this->iCodigo = $iCodigo;
	}

	/**
	 * Persist na base o tipo de assentamento
	 * @return mixed true | String mensagem de erro
	 */
	public function persist() {
		return;
	}

	/**
	 * Transforma o objeto em um formato JSON
	 * @return JSON
	 */
  public function toJSON() {

    $aRetorno["codigo"]            = $this->getCodigo();

    return json_encode((object)$aRetorno);
  }

  /**
   * Retorna os dados financeiros do tipo de assentamento
   * 
   * @return false|String|StdClass   Retorna a linha da tabela cl_tipoassefinanceiro que 
   *                                 vincula um tipo de assentamento a uma rubrica e uma formula
   */
  private function getTipoAssentamentoFinanceiro() {

  	if(empty($this->iCodigo)) {
      return false;
    }

    $oDaoTipoassefinanceiro    = new cl_tipoassefinanceiro;
    $sWhereTipoassefinanceiro  = "     rh165_tipoasse = {$this->iCodigo}";
    $sWhereTipoassefinanceiro .= " and rh165_instit   = ". db_getsession('DB_instit');
    $sSqlTipoassefinanceiro    = $oDaoTipoassefinanceiro->sql_query(null, "*", null, $sWhereTipoassefinanceiro);
    
    try{

      $rsTipoassefinanceiro = db_query($sSqlTipoassefinanceiro);

      if(!$rsTipoassefinanceiro) {
        throw new DBException("Ocorreu um erro ao buscar o tipo de assentamento financeiro.");
      }

      if(pg_num_rows($rsTipoassefinanceiro) == 0) {
        return false;
      }

      return db_utils::fieldsMemory($rsTipoassefinanceiro, 0);

    } catch (Exception $oErro) {
      return $oErro->getMessage();
    }
  }

  /**
   * Retorna a rubrica configurada para o tipo de assentamento
   * 
   * @return false|Rubrica       Retorna false se não encontrar rubrica configurada a Rubrica
   */
  public function getRubricaTipoAssentamentoFinanceiro() {

  	$oStdTipoAssentamentoFinanceiro = $this->getTipoAssentamentoFinanceiro();

    if($oStdTipoAssentamentoFinanceiro instanceof stdClass) {
      return RubricaRepository::getInstanciaByCodigo($oStdTipoAssentamentoFinanceiro->rh165_rubric);
    }

    return false;
  }

  /**
   * Retorna a variável configuarada para o tipo de assentamento
   * 
   * @return false|String       Retorna false se não encontrar varíavel configurada ou a string da variável
   */
  public function getVariavelTipoAssentamentoFinanceiro() {

  	$oStdTipoAssentamentoFinanceiro = $this->getTipoAssentamentoFinanceiro();

    if($oStdTipoAssentamentoFinanceiro instanceof stdClass) {
      return  $oStdTipoAssentamentoFinanceiro->db148_nome;
    }

    return false;
  }

  /**
   * Retorna o tipo de lancamento configurado para o tipo de assentamento
   * 
   * @return false|Integer
   */
  public function getTipoLancamentoTipoAssentamentoFinanceiro() {

  	$oStdTipoAssentamentoFinanceiro = $this->getTipoAssentamentoFinanceiro();

    if(!empty($oStdTipoAssentamentoFinanceiro) ) {
      return  $oStdTipoAssentamentoFinanceiro->rh165_tipolancamento;
    }

  	return false;
  }
}
