<?php
/**
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
 * Classe representa os parâmetros do módulo Pessoal
 * 
 * @package Pessoal
 * @author $Author: dbrenan $
 * @version $Revision: 1.3 $
 */

class ParametrosPessoal {


  /**
   * 
   * 
   * @var mixed
   * @access private
   */
  private $oRubricaAbonoPermanencia;
  /**
   * Competência dos parâmetros
   * 
   * @var DBCompetencia
   */
  private $oCompetencia;
  
  /**
   * Instituição dos parâmetros
   * 
   * @var Instituicao
   */
  private $oInstituicao;
  
  /**
   * Parâmetro comparativo
   * 
   * @var Boolean 
   */
  private $lComparativo;
  
  /**
   * Nome da base de salário do comparativo
   * 
   * @var String 
   */
  private $sBaseSalarioComparativo;
  
  /**
   * Nome da base de férias do comparativo
   * 
   * @var String
   */
  private $sBaseFeriasComparativo;
  
  /**
   * Rubrica definida para utilização na substituição de 
   * função de exércicio Anterior
   *
   * @var  Rubrica
   */
  private $oRubricaExercicioAnteriorSubstituicao;

  /**
   * Rubrica definida para utilização na substituição de 
   * função de exércicio Atual
   *
   * @var  Rubrica
   */
  private $oRubricaExercicioAtualSubstituicao;

  
  /**
   * Construtor da classe
   * 
   * @param DBCompetencia $oCompetencia
   * @param Instituicao $oInstituicao
   */
  function __construct(DBCompetencia $oCompetencia, Instituicao $oInstituicao) {
    
    $this->setCompetencia($oCompetencia);
    $this->setInstituicao($oInstituicao);
  }
  
  /**
   * Retorna a competência dos parâmetros
   * 
   * @return DBCompetencia
   */
  public function getCompetencia() {
    return $this->oCompetencia;
  }

  /**
   * Retorna a instituição dos parâmetros
   * 
   * @access public
   * @return Instituicao
   */
  public function getInstituicao() {
    return $this->oInstituicao;
  }
  
  /**
   * Verifica se o comparativo esta setado
   * 
   * @access public
   * @return Boolean
   */
  public function isComparativo() {
    return $this->lComparativo;
  }

  /**
   * Retorna o nome da base de salário do comparativo
   * 
   * @access public
   * @return String
   */
  public function getBaseSalarioComparativo() {
    return $this->sBaseSalarioComparativo;
  }

  /**
   * Retorna o nome da base de férias do comparativo
   * 
   * @access public
   * @return String
   */
  public function getBaseFeriasComparativo() {
    return $this->sBaseFeriasComparativo;
  }

  /**
   * Seta a competência dos parâmetros
   *  
   * @access private
   * @param DBCompetencia $oCompetencia
   */
  private function setCompetencia(DBCompetencia $oCompetencia) {
    $this->oCompetencia = $oCompetencia;
  }
  
  /**
   * Seta a instituição dos parâmetros
   * 
   * @access private
   * @param Instituicao $oInstituicao
   */
  private function setInstituicao(Instituicao $oInstituicao) {
    $this->oInstituicao = $oInstituicao;
  }
  
  /**
   * Seta o parâmetro comparativo
   * 
   * @access public
   * @param Boolean $lComparativo
   */
  public function setComparativo($lComparativo) {
    $this->lComparativo = $lComparativo;
  }

  /**
   * Seta o nome da base de salário do comparativo
   * 
   * @access public
   * @param String $sBaseSalarioComparativo
   */
  public function setBaseSalarioComparativo($sBaseSalarioComparativo) {
    $this->sBaseSalarioComparativo = $sBaseSalarioComparativo;
  }

  /**
   * Seta o nome da base de férias do comparativo
   * 
   * @access public
   * @param String $sBaseFeriasComparativo
   */
  public function setBaseFeriasComparativo($sBaseFeriasComparativo) {
    $this->sBaseFeriasComparativo = $sBaseFeriasComparativo;
  }

  /**
   * Define a Rubrica utilizada no lancçamento de Abono Permanencia
   *
   * @param  Rubrica $oRubrica
   * @access public
   * @return void
   */
  public function setRubricaAbonoPermanencia( Rubrica $oRubrica = null) {

    $this->oRubricaAbonoPermanencia = $oRubrica;
    return;
  }

  /**
   * Define a rubrica utilizada para substiruiçãod e função do exercício Anterior
   *
   * @access public
   * @param  String  $oRubricaExercicioAnterior
   */
  public function setRubricaExercicioAnteriorSubstituicao($sRubricaExercicioAnterior) {

    $oRubrica = RubricaRepository::getInstanciaByCodigo($sRubricaExercicioAnterior);
    $this->oRubricaExercicioAnteriorSubstituicao = $oRubrica;
  }

  /**
   * Define a rubrica utilizada para substiruiçãod e função do exercício Atual
   *
   * @access public
   * @param  String  $oRubricaExercicioAtual
   */
  public function setRubricaExercicioAtualSubstituicao($sRubricaExercicioAtual) {

    $oRubrica = RubricaRepository::getInstanciaByCodigo($sRubricaExercicioAtual);
    $this->oRubricaExercicioAtualSubstituicao = $oRubrica;
  }

  /**
   * Rubrica AbonoPermanencia
   *
   * @access public
   * @return void
   */
  public function getRubricaAbonoPermanencia() {
    return $this->oRubricaAbonoPermanencia;
  }

  /**
   * Retorna a rubrica utilizada para substiruiçãod e função do exercício Anterior
   * 
   * @access public
   * @return  Rubrica
   */
  public function getRubricaExercicioAnteriorSubstituicao() {
    return $this->oRubricaExercicioAnteriorSubstituicao;
  }

  /**
   * Retorna a rubrica utilizada para substiruiçãod e função do exercício Atual
   * 
   * @access public
   * @return  Rubrica
   */
  public function getRubricaExercicioAtualSubstituicao() {
    return $this->oRubricaExercicioAtualSubstituicao;
  }
}
