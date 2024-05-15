<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
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
 * Model extends metodos e propriedades do model AcordoMovimentacao
 * Model para tratar a recisão dos contratos
 *
 * @package Contratos
 */
require_once("model/AcordoMovimentacao.model.php");
class AcordoRescisao extends AcordoMovimentacao
{

  /**
   * Tipo da Movimentação
   *
   * @var integer
   */
  protected $iTipo               = 6;

  /**
   * Data do Movimento
   *
   * @var string
   */
  protected $dtMovimento         = '';



  /**
   * Código do Movimento de Cancelamento
   *
   * @var integer
   */
  protected $iCodigoCancelamento = 7;

  /**
   * Valor da Rescisão
   * @var integer
   */
  protected $nValorRescisao = 0;


  /**
   * Método construtor
   *
   * @param integer $iCodigo
   */
  public function __construct($iCodigo = null)
  {

    parent::__construct($iCodigo);
  }

  /**
   * Seta o tipo de acordo para a recisão, alterado para protected para nao poder atribuir um novo valor
   *
   * @return integer $iTipo
   */
  public function setTipo($iTipo)
  {

    $this->iTipo = 6;
  }

  /**
   * Seta a data da movimentação
   *
   * @param string $dtMovimento
   */
  public function setDataMovimento($dtMovimento = '')
  {

    $this->dtMovimento = $dtMovimento;
  }


  /**
   * @param float $nValorRescisao
   */
  public function setValorRescisao($nValorRescisao = 0)
  {
    $this->nValorRescisao = floatval($nValorRescisao);
  }

  /**
   * @return string $nValorRescisao
   */
  public function getValorRescisao()
  {
    return $this->nValorRescisao;
  }


  /**
   * Persiste os dados da Acordo Movimentacao na base de dados
   *
   * @return AcordoRescisao
   */
  public function save()
  {

    parent::save();
    $iCodigoAcordo = $this->getAcordo();

    $oDaoAcordo                      = db_utils::getDao("acordo");
    $oDaoAcordo->ac16_sequencial     = $iCodigoAcordo;
    $oDaoAcordo->ac16_datarescisao   = $this->dtMovimento;
    $oDaoAcordo->ac16_valorrescisao  = $this->nValorRescisao;
    $oDaoAcordo->ac16_acordosituacao = 2;
    $oDaoAcordo->alterar($oDaoAcordo->ac16_sequencial);
    if ($oDaoAcordo->erro_status == 0) {
      throw new Exception($oDaoAcordo->erro_msg);
    }

    return $this;
  }

  /**
   * Cancela o movimento
   *
   * @return AcordoRescisao
   */
  public function cancelar()
  {

    $iCodigoAcordo = $this->getAcordo();
    $oDaoAcordo                      = db_utils::getDao("acordo");
    $oDaoAcordo->ac16_sequencial     = $iCodigoAcordo;
    $oDaoAcordo->ac16_datarescisao   = $this->dtMovimento;
    $oDaoAcordo->ac16_valorrescisao  = $this->nValorRescisao;
    $oDaoAcordo->alterar($oDaoAcordo->ac16_sequencial);
    if ($oDaoAcordo->erro_status == 0) {
      throw new Exception($oDaoAcordo->erro_msg);
    }

    parent::cancelar();

    return $this;
  }

  /**
   * Cancela o cancelamento da recisão
   *
   * @return AcordoRescisao
   */
  public function desfazerCancelamento()
  {


    if (!db_utils::inTransaction()) {
      throw new Exception("Não existe Transação Ativa.");
    }

    $iCodigo = $this->iCodigo;
    if (empty($iCodigo)) {
      throw new Exception("Código para o cancelamento não informado!\nCancelamento não efetuado.");
    }

    $iTipo = $this->getTipo();
    if (empty($iTipo)) {
      throw new Exception("Tipo de movimentação não informado!\nCancelamento não efetuado.");
    }

    $iAcordo = $this->getAcordo();
    if (empty($iAcordo)) {
      throw new Exception("Acordo da movimentação não informado!\nCancelamento não efetuado.");
    }

    $oDaoAcordo                        = db_utils::getDao("acordo");
    $oDaoAcordoMovimentacao            = db_utils::getDao("acordomovimentacao");
    $oDaoAcordoMovimentacaoCancela     = db_utils::getDao("acordomovimentacaocancela");

    /**
     * Verifica se já possui movimentação cancelada
     */
    $sWhere                            = "ac25_acordomovimentacao = {$this->iCodigo}";
    $sSqlAcordoMovimentacaoCancela     = $oDaoAcordoMovimentacaoCancela->sql_query(null, "*", null, $sWhere);
    $rsSqlAcordoMovimentacaoCancela    = $oDaoAcordoMovimentacaoCancela->sql_record($sSqlAcordoMovimentacaoCancela);
    $iNumRowsAcordoMovimentacaoCancela = $oDaoAcordoMovimentacaoCancela->numrows;
    if ($iNumRowsAcordoMovimentacaoCancela == 0) {
      throw new Exception("Não existe cancelamento dessa rescisão!\nProcessamento cancelado.");
    }

    $oMovimentoCancelado = db_utils::fieldsMemory($rsSqlAcordoMovimentacaoCancela, 0);

    /**
     * Inclui uma nova movimentação
     */
    $oDaoAcordoMovimentacao->ac10_acordomovimentacaotipo = 14;
    $oDaoAcordoMovimentacao->ac10_acordo                 = $this->getAcordo();
    $oDaoAcordoMovimentacao->ac10_obs                    = $this->getObservacao();
    $oDaoAcordoMovimentacao->ac10_id_usuario             = db_getsession('DB_id_usuario');
    $oDaoAcordoMovimentacao->ac10_datamovimento          = date("Y-m-d", db_getsession("DB_datausu"));
    $oDaoAcordoMovimentacao->ac10_hora                   = db_hora();
    $oDaoAcordoMovimentacao->incluir(null);
    if ($oDaoAcordoMovimentacao->erro_status == 0) {
      throw new Exception($oDaoAcordoMovimentacao->erro_msg);
    }

    /**
     * Inclui um novo cancelamento cancelado de recisão
     */
    $oDaoAcordoMovimentacaoCancela->ac25_acordomovimentacao        = $oDaoAcordoMovimentacao->ac10_sequencial;
    $oDaoAcordoMovimentacaoCancela->ac25_acordomovimentacaocancela = $oMovimentoCancelado->ac25_acordomovimentacao;
    $oDaoAcordoMovimentacaoCancela->incluir(null);
    if ($oDaoAcordoMovimentacaoCancela->erro_status == 0) {
      throw new Exception($oDaoAcordoMovimentacaoCancela->erro_msg);
    }

    /**
     * Altera situacao do movimento
     */
    $oDaoAcordo->ac16_sequencial     = $this->getAcordo();
    $oDaoAcordo->ac16_acordosituacao = 2;
    $oDaoAcordo->alterar($oDaoAcordo->ac16_sequencial);
    if ($oDaoAcordo->erro_status == 0) {
      throw new Exception($oDaoAcordo->erro_msg);
    }
    $this->corrigeReservas();
    return $this;
  }

  /**
   * @return Boolean
   */
  public function verificaPeriodoPatrimonial()
  {
    return parent::verificaPeriodoPatrimonial();
  }

  /**
   * @return Boolean
   */
  public function verificaPeriodoContabil($sData = null)
  {
    return parent::verificaPeriodoContabil($sData);
  }
}
