<?php
/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBseller Servicos de Informatica
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
 * Condicionante para Parecer Técnico
 *
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 * @package meioambiente
 */
class CondicionanteAtividadeImpacto {

  /**
   * Código sequencial
   * @var integer
   */
  private $iSequencial = null;

  /**
   * Descrição da Condicionante
   * @var string
   */
  private $oCondicionante = null;

  /**
   * Variável que define se esta condicionante é padrão
   * @var boolean
   */
  private $oAtividadeImpacto = null;


  public function __construct( $iSequencial = null ) {

    $oDaoCondicionanteAtividadeImpacto = db_utils::getDao('condicionanteatividadeimpacto');
    $rsCondicionanteAtividadeImpacto   = null;

    if (!is_null($iSequencial)) {

      $sSql                            = $oDaoCondicionanteAtividadeImpacto->sql_query($iSequencial);
      $rsCondicionanteAtividadeImpacto = $oDaoCondicionanteAtividadeImpacto->sql_record($sSql);
    }

    if (!is_null($rsCondicionanteAtividadeImpacto)) {

      $oDados = db_utils::fieldsMemory($rsCondicionanteAtividadeImpacto, 0);

      $this->iSequencial       = $oDados->am11_sequencial;
      $this->oCondicionante    = new Condicionante($oDados->am11_condicionante);
      $this->oAtividadeImpacto = new AtividadeImpacto($oDados->am11_atividadeimpacto);
    }
  }

  public function getSequencial() {
    return $this->iSequencial;
  }

  public function getCondicionante() {
    return $this->oCondicionante;
  }

  public function setCondicionante(Condicionante $oCondicionante) {
    $this->oCondicionante = $oCondicionante;
  }

  public function getAtividadeImpacto() {
    return $this->oAtividadeImpacto;
  }

  public function setAtividadeImpacto(AtividadeImpacto $oAtividadeImpacto) {
    $this->oAtividadeImpacto = $oAtividadeImpacto;
  }

  public function incluir() {

    try {

      if (empty($this->oAtividadeImpacto)) {
        throw new Exception( _M( MENSAGENS . 'atividade_obrigatorio') );
      }

      if (empty($this->oCondicionante)) {
        throw new Exception( _M( MENSAGENS . 'condicionante_obrigatorio') );
      }

      $oDaoCondicionanteAtividadeImpacto = db_utils::getDao('condicionanteatividadeimpacto');
      $oDaoCondicionanteAtividadeImpacto->am11_condicionante    = $this->oCondicionante->getSequencial();
      $oDaoCondicionanteAtividadeImpacto->am11_atividadeimpacto = $this->oAtividadeImpacto->getSequencial();
      $oDaoCondicionanteAtividadeImpacto->incluir();

      if ($oDaoCondicionanteAtividadeImpacto->erro_status == 0) {
        throw new Exception($oDaoCondicionanteAtividadeImpacto->erro_msg);
      }

      $this->iSequencial = $oDaoCondicionanteAtividadeImpacto->am11_sequencial;
    } catch (Exception $oError) {
      throw $oError;
    }
  }

  public function getAtividades($iCodigoCondicionante) {

    try {

      $oDaoCondicionanteAtividadeImpacto = db_utils::getDao("condicionanteatividadeimpacto");
      $sSql                              = $oDaoCondicionanteAtividadeImpacto->sql_query(null, "am11_atividadeimpacto", null, "am11_condicionante = $iCodigoCondicionante");
      $rsCondicionanteAtividadeImpacto   = $oDaoCondicionanteAtividadeImpacto->sql_record($sSql);
      $aIdAtividades                     = db_utils::getCollectionByRecord($rsCondicionanteAtividadeImpacto);

      $aAtividades = array();
      foreach ($aIdAtividades as $iChave => $iAtividade) {

        $oDaoAtividadeImpacto = db_utils::getDao("atividadeimpacto");
        $sSql                 = $oDaoAtividadeImpacto->sql_query($iAtividade->am11_atividadeimpacto, "am03_sequencial, am03_descricao");
        $rsAtividade          = $oDaoAtividadeImpacto->sql_record($sSql);

        $oDadosAtividade      = db_utils::fieldsMemory($rsAtividade,0);
        $aAtividades[$oDadosAtividade->am03_sequencial] = utf8_encode($oDadosAtividade->am03_descricao);
      }

      return $aAtividades;
    } catch (Exception $oError) {
      throw $oError;
    }
  }

  /**
   * Exclui o vínculo das atividades com a Condicionante
   *
   * @param  integer $iCodigoCondicionante
   * @access public
   */
  public static function excluir($iCodigoCondicionante) {

    $oDao   = db_utils::getDao('condicionanteatividadeimpacto');

    $sWhere = " am11_condicionante = {$iCodigoCondicionante} ";
    $oDao->excluir(null, $sWhere);
  }
}