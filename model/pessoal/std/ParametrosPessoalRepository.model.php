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
 * @version $Id: ParametrosPessoalRepository.model.php,v 1.7 2015/05/22 19:33:52 dbrenan Exp $
 */

class ParametrosPessoalRepository {
  
  const MENSAGEM = "recursoshumanos.pessoal.ParametrosPessoalRepository";
  
  /**
   *
   * @var ParametrosPessoalRepository
   */
  private static $oInstance;
  
  /**
   *
   * @var ParametrosPessoal[]
   */
  private $aParametros = array();
  
  /**
   * Construtor private evita que a classe seja instanciada publicamente
   */
  private function __construct() {}
    
  private function __clone() {}
  
  /**
   * Retorna instância do repository
   *
   * @static
   * @access public
   * @return ParametrosPessoalRepository
   */
  public static function getInstance() {
    
    if(ParametrosPessoalRepository::$oInstance == null) {
      ParametrosPessoalRepository::$oInstance = new ParametrosPessoalRepository();
    }

    return ParametrosPessoalRepository::$oInstance;
  }
  
  /**
   * Remove o objeto ParametrosPessoal no repository
   * 
   * @static
   * @access public
   * @param ParametrosPessoal $oParametros
   * @return Boolean
   */
  public static function removeParametros(ParametrosPessoal $oParametros) {
    
    $iAno         = $oParametros->getCompetencia()->getAno();
    $iMes         = $oParametros->getCompetencia()->getMes();
    $iInstituicao = $oParametros->getInstituicao()->getCodigo();
    $sChave       = "{$iAno}{$iMes}{$iInstituicao}";
    
    if(array_key_exists($sChave, ParametrosPessoalRepository::getInstance()->aParametros)) {
      unset(ParametrosPessoalRepository::getInstance()->aParametros[$sChave]);
    }
    
    return true;
  }
  
  /**
   * Adiciona o objeto ParametrosPessoal no repository
   * 
   * @static
   * @access public
   * @param ParametrosPessoal $oParametros
   * @return Boolean
   */
  public static function adicionarParametros(ParametrosPessoal $oParametros) {
    
    $iAno         = $oParametros->getCompetencia()->getAno();
    $iMes         = $oParametros->getCompetencia()->getMes();
    $iInstituicao =  $oParametros->getInstituicao()->getCodigo();
    $sChave       = "{$iAno}{$iMes}{$iInstituicao}";
    
    if(!array_key_exists($sChave, ParametrosPessoalRepository::getInstance()->aParametros)) {
      ParametrosPessoalRepository::getInstance()->aParametros[$sChave] = $oParametros;
    }
    
    return true;
  }
  
  /**
   * Retorna os parâmetros do módulo Pessoal
   * 
   * @static
   * @access public
   * @param DBCompetencia $oCompetencia
   * @param Instituicao $oInstituicao
   * @return ParametrosPessoal
   */
  public static function getParametros(DBCompetencia $oCompetencia, Instituicao $oInstituicao) {
    
    $iAno         = $oCompetencia->getAno();
    $iMes         = $oCompetencia->getMes();
    $iInstituicao = $oInstituicao->getCodigo();
    $sChave       = "{$iAno}{$iMes}{$iInstituicao}";
    
    if (array_key_exists($sChave, ParametrosPessoalRepository::getInstance()->aParametros)) {
      return ParametrosPessoalRepository::getInstance()->aParametros[$sChave];
    }
    
    $oParametros = new ParametrosPessoal($oCompetencia, $oInstituicao);
    $oParametros = ParametrosPessoalRepository::getInstance()->carregarParametros($oParametros);
    
    ParametrosPessoalRepository::adicionarParametros($oParametros);
    
    return $oParametros;   
  }

  /**
   * Carrega os parâmetros
   * 
   * @access private
   * @param ParametrosPessoal $oParametros
   * @return ParametrosPessoal
   * @throws DBException
   */
  private function carregarParametros(ParametrosPessoal $oParametros) {
    
    $sCampos        = "r11_compararferias::int,         ";
    $sCampos       .= "r11_basesalario,                 ";
    $sCampos       .= "r11_baseferias,                  ";
    $sCampos       .= "r11_abonoprevidencia,            ";
    $sCampos       .= "r11_rubricasubstituicaoanterior, ";
    $sCampos       .= "r11_rubricasubstituicaoatual     ";

    $oDaoParametros = new cl_cfpess();
    $sSqlParametros = $oDaoParametros->sql_query_file($oParametros->getCompetencia()->getAno(), 
                                                      $oParametros->getCompetencia()->getMes(), 
                                                      $oParametros->getInstituicao()->getCodigo(), 
                                                      $sCampos);
    $rsParametros   = db_query($sSqlParametros);
    
    if (!$rsParametros) {
      throw new DBException(_M(self::MENSAGEM . "erro_buscar_parametros_comparativo_cfpess"));
    }
    
    $oDadoParametros = db_utils::fieldsMemory($rsParametros, 0);

    $oParametros->setComparativo((bool)$oDadoParametros->r11_compararferias);
    $oParametros->setBaseSalarioComparativo($oDadoParametros->r11_basesalario);
    $oParametros->setBaseFeriasComparativo($oDadoParametros->r11_baseferias);
    
    if ( !empty($oDadoParametros->r11_rubricasubstituicaoanterior) ) {
      $oParametros->setRubricaExercicioAnteriorSubstituicao($oDadoParametros->r11_rubricasubstituicaoanterior);
    }

    if (!empty($oDadoParametros->r11_rubricasubstituicaoatual) ) {
      $oParametros->setRubricaExercicioAtualSubstituicao($oDadoParametros->r11_rubricasubstituicaoatual);
    }

    if ( !empty($oDadoParametros->r11_abonoprevidencia)) { 

      $oRubricaAbonoPermanencia = RubricaRepository::getInstanciaByCodigo($oDadoParametros->r11_abonoprevidencia);
      $oParametros->setRubricaAbonoPermanencia($oRubricaAbonoPermanencia);
    }
    
    return $oParametros; 
  }
  
}
