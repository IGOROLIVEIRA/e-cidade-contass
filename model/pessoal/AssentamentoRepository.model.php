<?php
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2015  DBSeller Servicos de Informatica             
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
 * Repositório dos assentamentos do Sistema.
 *
 * @author Renan Melo <renan@dbseller.com.br>
 * @package Pessoal
 */
class AssentamentoRepository {
  

  const MENSAGEM = 'recursoshumanos.pessoal.AssentamentoRepository.';

  /**
   * Representa o collection com os assentamentos;
   *
   * @var Array Assentamentos
   */
  private $aAssentamentos = array();

  /**
   * Instancia da Classe
   *
   * @var Assentamento
   */
  private static $oInstance;

  private function __construct(){}

  private function __clone(){}

  /**
   * Retorna a instância do Repository
   *
   * @access protected
   * @return  AssentamentoRepository
   */
  protected static function getInstance() {

    if (self::$oInstance === null) {
      self::$oInstance  = new AssentamentoRepository();
    }

    return self::$oInstance;
  }

  /**
   * Monta o Objeto assentamento a partir do código informado por parâmetro.
   *
   * @access public
   * @param integer $iCodigoAssentamento
   * @return Assentamento $oAssentamento
   */
  public static function make($iCodigoAssentamento) {

    $oDaoAssenta = new cl_assenta();
    $sSqlAssenta = $oDaoAssenta->sql_query_file($iCodigoAssentamento);
    $rsAssenta = db_query($sSqlAssenta);

    if (!$rsAssenta) {
      throw new DBException(_M(self::MENSAGEM.'erro_buscar_assentamento'));
    }

    $oAssentamentoEncontrado = db_utils::FieldsMemory($rsAssenta, 0);

    $oAssentamento = AssentamentoFactory::getByCodigo($iCodigoAssentamento);
    
    $oAssentamento->setCodigo( $oAssentamentoEncontrado->h16_codigo );
    $oAssentamento->setMatricula( $oAssentamentoEncontrado->h16_regist );
    $oAssentamento->setTipoAssentamento( $oAssentamentoEncontrado->h16_assent );
    $oAssentamento->setHistorico( $oAssentamentoEncontrado->h16_histor );
    $oAssentamento->setCodigoPortaria( $oAssentamentoEncontrado->h16_nrport );
    $oAssentamento->setDescricaoAto( $oAssentamentoEncontrado->h16_atofic );
    $oAssentamento->setDias( $oAssentamentoEncontrado->h16_quant );
    $oAssentamento->setPercentual( $oAssentamentoEncontrado->h16_perc );
    $oAssentamento->setSegundoHistorico( $oAssentamentoEncontrado->h16_hist2 );
    $oAssentamento->setLoginUsuario( $oAssentamentoEncontrado->h16_login );
    $oAssentamento->setDataLancamento( $oAssentamentoEncontrado->h16_dtlanc );
    $oAssentamento->setConvertido( $oAssentamentoEncontrado->h16_conver );
    $oAssentamento->setAnoPortaria( $oAssentamentoEncontrado->h16_anoato );

    if (!empty($oAssentamentoEncontrado->h16_dtconc)) {

      $oDataConcessao = new DBDate($oAssentamentoEncontrado->h16_dtconc);
      $oAssentamento->setDataConcessao ($oDataConcessao);
    }

    if (!empty($oAssentamentoEncontrado->h16_dtterm)) {

      $oDataTermino = new DBDate($oAssentamentoEncontrado->h16_dtterm);
      $oAssentamento->setDataTermino   ($oDataTermino);
    }

    return $oAssentamento;
  }

  /**
   * Adiciona um objeto Assentamento ao collection de Assentamentos
   *
   * @access public
   * @param  Assentamento  $oAssentamento
   */
  public static function adicionar(Assentamento $oAssentamento) {
    self::getInstance()->aAssentamentos[$oAssentamento->getCodigo()] = $oAssentamento;
  }

  /**
   * Retorna a instância do Assentamento referente ao Código informado por parâmetro.
   *
   * @param  integer  $iCodigo
   * @return  Assentamento
   */
  public static function getInstanceByCodigo($iCodigo) {

    if (!isset(self::getInstance()->aAssentamentos[$iCodigo])) {
      self::adicionar(self::make($iCodigo));
    }
    
    return self::getInstance()->aAssentamentos[$iCodigo];
  }


  public static function persist(Assentamento $oAssentamento) {

    try {
       $oAssentamento->persist();
    } catch (DBException $oErro) {
       throw new BusinessException(_M(self::MENSAGEM."erro_persistir_assentamento\n".$oErro->getMessage()));
    }
  }

  public static function getServidoresAssentamentoSubstituicao() {

    $aListaServidores                  = array();
    $iNaturezaAssentamentoSubstituicao = AssentamentoSubstituicao::CODIGO_NATUREZA;
    $oCompetencia                      = DBPessoal::getCompetenciaFolha();
    $oDaoAssentamento                  = new cl_assenta();

    $sCamposAssentamentoSubstituicao   = " h16_regist as servidor ";

    $sWhereAssentamentoSubstituicao    = "    rh159_sequencial = {$iNaturezaAssentamentoSubstituicao}
                                          and rh155_ano = {$oCompetencia->getAno()}
                                          and rh155_mes = {$oCompetencia->getMes()}
                                           or rh160_assentamento is null";

    $sqlAssentamentoSubstituicao       = $oDaoAssentamento->sql_query_servidores_com_assentamento_substituicao(null, 
                                                                                                               $sCamposAssentamentoSubstituicao,
                                                                                                               "h16_regist",
                                                                                                               $sWhereAssentamentoSubstituicao);


    $rsAssentamentoSubstituicao        = db_query($sqlAssentamentoSubstituicao);

    if(!$rsAssentamentoSubstituicao){
      throw new BusinessException(_M("erro_buscar_servidores_assentamento_substituicao"));
    } else {
      if(pg_num_rows($rsAssentamentoSubstituicao) > 0){
        
        $aAssentamentos = db_utils::getCollectionByRecord($rsAssentamentoSubstituicao);

        foreach ($aAssentamentos as $oStdAssentamento) {
          
          $oServidor          = ServidorRepository::getInstanciaByCodigo($oStdAssentamento->servidor, DBPessoal::getAnoFolha(), DBPessoal::getMesFolha());
          $aListaServidores[] = $oServidor;
        }
      }
    }

    return $aListaServidores;
  }

  public static function getAssentamentosSubstituicaoServidor($iMatricula, $oCompetencia = null) {

    if (is_null($oCompetencia)) {
      $oCompetencia = DBPessoal::getCompetenciaFolha();
    }

    $oServidor      = ServidorRepository::getInstanciaByCodigo($iMatricula, $oCompetencia->getAno(), $oCompetencia->getMes());
    $aAssentamentos = $oServidor->getAssentamentosSubstituicao();
    $aAssentemaentosServidor = array();

    foreach ($aAssentamentos as $oAssentamento) {

      $oStdAssentamento = new stdClass();
      $oStdAssentamento->codigo              = $oAssentamento->getCodigo();
      $oStdAssentamento->dataConcessao       = ($oAssentamento->getDataConcessao() instanceof DBDate ? $oAssentamento->getDataConcessao()->getDate(DBDate::DATA_PTBR) : $oAssentamento->getDataConcessao());
      $oStdAssentamento->dataTermino         = ($oAssentamento->getDataTermino() instanceof DBDate ? $oAssentamento->getDataTermino()->getDate(DBDate::DATA_PTBR) : $oAssentamento->getDataTermino());
      $oStdAssentamento->dias                = $oAssentamento->getDias();
      $oStdAssentamento->valor_substituicao  = $oAssentamento->getValorCalculado();
      $oStdAssentamento->hasLote             = false;
      $oStdAssentamento->isLoteFolhaFechada  = false;

      if($oAssentamento->hasLote() === false){
        $aAssentemaentosServidor[] = $oStdAssentamento;
      } else {

        if(DBPessoal::getCompetenciaFolha()->comparar($oAssentamento->hasLote()->getCompetencia())){

          $oStdAssentamento->hasLote  = true;
          $oFolhaPagamento            = $oAssentamento->hasLote()->getFolhaPagamento();

          if($oFolhaPagamento === false) {
            throw new BusinessException(_M("erro_buscar_folha_pagamento_lote"));
          } else {
            if(!$oFolhaPagamento->isAberto()) {
              $oStdAssentamento->isLoteFolhaFechada = true;
            }
          }

          $aAssentemaentosServidor[] = $oStdAssentamento;
        }
      }
    }
    
    return $aAssentemaentosServidor;
  }

  public static function persistLancamento(Assentamento $oAssentamento) {

  }

  /**
   * Retorna todos os assentamentos do servidor
   *
   * @param Servidor $oServidor
   * @param Integer  $iTipoAssentamento
   */
  public static function getAssentamentosPorServidor(Servidor $oServidor, $iTipoAssentamento = null , DBDate $oDataMinima = null) {

    $sWhere           = "h16_regist = {$oServidor->getMatricula()}";

    if ( !empty($iTipoAssentamento) ) {
      $sWhere .= " and h16_assent = $iTipoAssentamento";  
    }
    if ( $oDataMinima ) {
      $sWhere .= " and h16_dtconc >= '{$oDataMinima->getDate()}' ";
    }
    $oDaoAssentamento = new cl_assenta();
    $sSqlBusca        = $oDaoAssentamento->sql_query_file(
      null, 
      "h16_codigo", 
      null, 
      $sWhere
    );

    $rsAssentamentos  = db_query($sSqlBusca);
    
    if (!$rsAssentamentos)  {
      throw new DBException(_M(self::MENSAGEM . "erro_buscar_assentamentos_servidor")); 
    }

    $aAssentemaentos = array();

    foreach (db_utils::getCollectionByRecord($rsAssentamentos) as $oDados) {
      $aAssentemaentos[] = AssentamentoFactory::getByCodigo($oDados->h16_codigo);
    }

    return $aAssentemaentos;
  }

}
