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
 * Repositório para Tipos de assentamentos
 *
 * @package pessoal
 * @author Renan Silva <renan.silva@dbseller.com.br>
 */
class TipoAssentamentoRepository {

 /**
   * Array com instancias de tipos de assentamentos
   *
   * @static
   * @var Array
   * @access private
   */
  static private $aColecao = array();

  /**
   * Representa a instancia a classe
   * 
   * @var TipoAssentamentoRepository
   * @access private
   */
  private static   $oInstance;

  /**
   * Previne a criação do objeto externamente
   *
   * @return void
   */
  private function __construct() {
    return;
  }

  /**
   * Previne o clone
   * 
   * @return void
   */
  private function __clone() {
    return;
  }

  /**
   * Retorna a instancia do repositório
   * 
   * @return TipoAssentamentoRepository
   */
  public static function getInstance() {

    if (empty(self::$oInstance)) {

      $sClasse  = get_class();
      self::$oInstance = new TipoAssentamentoRepository();
    }

    return self::$oInstance;
  }

  /**
   * Adiciona a coleção um tipo de assentamento
   * 
   * @param TipoAssentamento $oTipoAssentamento
   */
  public function add(TipoAssentamento $oTipoAssentamento) {

    $oRepository = self::getInstance();
    $oRepository->aColecao[$oTipoAssentamento->getCodigo()] = $oTipoAssentamento;
  }

  /**
   * Monta um objeto TipoAssentamento
   * 
   * @param  Integer $iCodigo
   * 
   * @return TipoAssentamento
   */
  public function make($iCodigo) {

    $oTipoAssentamento = new TipoAssentamento($iCodigo);

    if(!empty($iCodigo)) {

      try {

        $oDaoTipoasse  = new cl_tipoasse;
        $sSqlTipoasse  = $oDaoTipoasse->sql_query($iCodigo);
        $rsTipoasse    = db_query($sSqlTipoasse);

        if(!$rsTipoasse) {
          throw new DBException("Ocorreu um erro ao buscar o tipo de assentamento");
        }

        if(pg_num_rows($rsTipoasse) > 0) {

          $oStdTipoasse = db_utils::fieldsMemory($rsTipoasse, 0);

          // = $oStdTipoasse->h12_codigo;
          // = $oStdTipoasse->h12_assent;
          // = $oStdTipoasse->h12_descr;
          // = $oStdTipoasse->h12_dias;
          // = $oStdTipoasse->h12_relvan;
          // = $oStdTipoasse->h12_relass;
          // = $oStdTipoasse->h12_reltot;
          // = $oStdTipoasse->h12_relgra;
          // = $oStdTipoasse->h12_tipo;
          // = $oStdTipoasse->h12_graefe;
          // = $oStdTipoasse->h12_efetiv;
          // = $oStdTipoasse->h12_tipefe;
          // = $oStdTipoasse->h12_regenc;
          // = $oStdTipoasse->h12_vinculaperiodoaquisitivo;
          // = $oStdTipoasse->h12_tiporeajuste;
          // = $oStdTipoasse->h12_natureza;
        }
        
      } catch (Exception $e) {
        $sErro = $e->getMessage();
      }
    }

    return $oTipoAssentamento;
  }

  /**
   * Retorna uma instancia da classe TipoAssentamento
   * 
   * @param  Integer $iCodigo
   * 
   * @return TipoAssentamento
   */
  public function getInstanciaPorCodigo($iCodigo) {

    $oRepository = self::getInstance();

    if(!isset($oRepository->aColecao[$iCodigo])) {
      self::add($oRepository->make($iCodigo));
    }

    return $oRepository->aColecao[$iCodigo];
  }
}