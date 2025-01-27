<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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
 * Representa os dados do profissional da escola
 * @package    Educacao
 * @subpackage recursohumano
 * @author     Andrio Costa - andrio.costa@dbseller.com.br
 * @version    $Revision: 1.9 $
 */
class ProfissionalEscola {


  const MSG_PROFISSIONALESCOLA = 'educacao.escola.ProfissionalEscola.';

  /**
   * C�digo de vincula do rechumano com a escola
   * Tabela : rechumanoescola   campo : ed75_i_codigo
   * @var integer
   */
  protected $iCodigo;

  /**
   * Escola vinculada
   * @var Escola
   */
  protected $oEscola;

  /**
   * C�digo do profissional
   * Tabela: rechumanoescola    campo : ed75_i_rechumano  fk -> rechumano
   * @var integer
   */
  protected $iCodigoProfissional;
  protected $lAtendeSimultaneo;

  /**
   * Data de ingresso
   * @var DBDate
   */
  protected $oDataIngresso = null;

  /**
   * Data de saida
   * @var DBDate
   */
  protected $oDataSaida = null;


  /**
   * @var AtividadeProfissionalEscola[]
   */
  protected $aAtividades = array();

  /**
   * Rela��es de trabalho que o profissional da escola possui
   * @var RelacaoTrabalho[]
   */
  protected $aRelacoesTrabalho = array();

  public function __construct($iCodigo = null) {

    if (is_null($iCodigo)) {
      return true;
    }

    $oDaoRecHumanoEscola = new cl_rechumanoescola();
    $sSqlProfissional    = $oDaoRecHumanoEscola->sql_query_file($iCodigo);
    $rsProfissional      = db_query($sSqlProfissional);

    $oMsgErro = new stdClass();
    if (!$rsProfissional) {

      $oMsgErro->sErro = pg_last_error();
      throw new DBException( _M(self::MSG_PROFISSIONALESCOLA . "erro_buscar_profissional", $oMsgErro) );
    }

    if (pg_num_rows($rsProfissional) == 0) {
      throw new DBException( _M(self::MSG_PROFISSIONALESCOLA . "nenhum_profissional_escola") );
    }

    $oDados                    = db_utils::fieldsMemory($rsProfissional, 0);
    $this->iCodigo             = $oDados->ed75_i_codigo;
    $this->oEscola             = EscolaRepository::getEscolaByCodigo( $oDados->ed75_i_escola );
    $this->iCodigoProfissional = $oDados->ed75_i_rechumano;
    $this->lAtendeSimultaneo   = $oDados->ed75_c_simultaneo == 'S';
    $this->oDataIngresso       = null;
    $this->oDataSaida          = null;

    if ( !empty($oDados->ed75_d_ingresso) ) {
      $this->oDataIngresso = new DBDate($oDados->ed75_d_ingresso);
    }
    if ( !empty($oDados->ed75_i_saidaescola) ) {
      $this->oDataSaida = new DBDate($oDados->ed75_i_saidaescola);
    }
  }



  /**
   * Getter codigo de vinculo do rechumano com a escola
   * @param integer
   */
  public function getCodigo() {
    return $this->iCodigo;
  }


  /**
   * Setter c�digo do profissional
   * @param integer
   */
  public function setCodigoProfissional ($iCodigoProfissional) {
    $this->iCodigoProfissional = $iCodigoProfissional;
  }

  /**
   * Getter c�digo do profissional
   * @param integer
   */
  public function getCodigoProfissional () {
    return $this->iCodigoProfissional;
  }


  /**
   * Setter escola
   * @param Escola
   */
  public function setEscola (Escola $oEscola) {
    $this->oEscola = $oEscola;
  }

  /**
   * Getter escola
   * @param Escola
   */
  public function getEscola () {
    return $this->oEscola;
  }

  /**
   * Setter atende simultaneamente
   * @param booleam
   */
  public function setAtendeSimultaneamente ($lAtende) {
    $this->lAtendeSimultaneo = $lAtende;
  }

  /**
   * Getter atende simultaneamente
   * @param booleam
   */
  public function atendeSimultaneamente () {
    return $this->lAtendeSimultaneo;
  }

  /**
   * Setter data ingresso
   * @param DBDate
   */
  public function setDataIngresso ( DBDate $oData) {
    $this->oDataIngresso = $oData;
  }

  /**
   * Getter data ingresso
   * @param DBDate
   */
  public function getDataIngresso () {
    return $this->oDataIngresso;
  }

  /**
   * Setter data de sa�da
   * @param DBDate
   */
  public function setDataSaida ($oData) {
    $this->oDataSaida = $oData;
  }

  /**
   * Getter data de sa�da
   * @param DBDate|null
   */
  public function getDataSaida() {
    return $this->oDataSaida;
  }

  /**
   * Atividades do profissional
   * @return AtividadeProfissionalEscola[]
   */
  public function getAtividades() {

    if ( count($this->aAtividades) == 0 ) {
      $this->aAtividades = AtividadeProfissionalEscolaRepository::getByProfissional( $this ) ;
    }

    return $this->aAtividades;
  }

  /**
   * Rela��es de trabalho que o profissional da escola possui
   * @return RelacaoTrabalho[]
   */
  public function getRelacoesTrabalho() {

    if ( count($this->aRelacoesTrabalho) == 0) {
      $this->aRelacoesTrabalho = RelacaoTrabalhoRepository::getRelacaoTrabalhoByProfissionalEscola( $this );
    }
    return $this->aRelacoesTrabalho;
  }


  /**
   * Adiciona ou atualiza os dados de uma atividade
   * @param AtividadeProfissionalEscola $oAtividade
   */
  public function addAtividade(AtividadeProfissionalEscola $oAtividade) {

    $lAtualizou = false;

    if ($oAtividade->getCodigo() != '') {

      foreach ($this->aAtividades as $iKey => $oAtividadeExistente) {

        if ( $oAtividadeExistente->getCodigo() == $oAtividade->getCodigo() ) {

          $this->aAtividades[$iKey] = $oAtividade;
          $lAtualizou = true;
          break;
        }
      }
    }

    if ( !$lAtualizou ) {
      $this->aAtividades[] = $oAtividade;
    }
    return true;
  }

  /**
   * @todo ainda n�o se faz necess�rio dar manuten��o nos dados do profissional por esse model.
   * Salva os dados das atividades do profissional...
   * @return boolean
   */
  public function salvar() {

    if (!db_utils::inTransaction()) {
      throw new DBException( _M(self::MSG_PROFISSIONALESCOLA . "sem_transacao", $oErro) );
    }

    /**
     * Atualiza as atividades
     */
    foreach ($this->aAtividades as $oAtividade) {

      $oAtividade->setProfissionalEscola($this);
      $oAtividade->salvar();

    }

    return true;
  }


  /**
   * Retorna os hor�rios de reg�ncia do docente ordenados pelo dia da semana e turno
   * @return array
   */
  public function getHorariosRegencia() {

    $sOrdem  = "ed33_i_diasemana, ed17_i_turno";
    $sWhere  = " ed33_rechumanoescola = {$this->iCodigo} ";
    $sWhere .= " and ed33_ativo is true ";

    $aHorariosRegencia     = array();
    $oDaoRecHumanoHoraDisp = new cl_rechumanohoradisp();
    $sSqlHorarioRegencia   = $oDaoRecHumanoHoraDisp->sql_query_disponivel_periodo(null, "*", $sOrdem, $sWhere);
    $rsHorariosRegencia    = db_query( $sSqlHorarioRegencia );

    if ( !$rsHorariosRegencia ) {
      throw new Exception(  _M(self::MSG_PROFISSIONALESCOLA . "erro_buscar_horarios_regencia" ) );
    }

    $iHorarios = pg_num_rows( $rsHorariosRegencia );

    for ( $iContador = 0; $iContador < $iHorarios; $iContador++ ) {

      $oDadosHorarios     = db_utils::fieldsMemory( $rsHorariosRegencia, $iContador );
      $oTipoHoraTrabalho  = new TipoHoraTrabalho( $oDadosHorarios->ed33_tipohoratrabalho );
      $oHorariosRegencia  = new stdClass();
      $oPeriodoEscola     = new PeriodoEscola( $oDadosHorarios->ed33_i_periodo );

      $oHorariosRegencia->sPeriodo              = $oPeriodoEscola->getDescricao();
      $oHorariosRegencia->sHorarioInicial       = $oPeriodoEscola->getHoraInicio();
      $oHorariosRegencia->sHorarioFinal         = $oPeriodoEscola->getHoraFim();
      $oHorariosRegencia->sTipoHora             = $oTipoHoraTrabalho->getDescricao();
      $oHorariosRegencia->sTipoHoraAbreviatura  = $oTipoHoraTrabalho->getAbreviatura();
      $oHorariosRegencia->sHoraAtividade        = $oDadosHorarios->ed33_horaatividade === 't' ? 'SIM' : 'N�O';

      $aHorariosRegencia[ $oDadosHorarios->ed33_i_diasemana ][ $oPeriodoEscola->getTurno()->getDescricao() ][ $oPeriodoEscola->getOrdem() ] = $oHorariosRegencia;
    }

    return $aHorariosRegencia;
  }

}

