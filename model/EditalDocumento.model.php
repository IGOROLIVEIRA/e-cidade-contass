<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2012  DBselller Servicos de Informatica
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
* controle de Documentos de um Edital
* @package Contratos
*/
class EditalDocumento {

  protected $iCodigo;
  protected $iCodigoEdital;
  protected $iTipo;
  protected $sArquivo;
  protected $sNomeArquivo;


  /**
   *
   * Construtor, se passado par?metro seta todas vari?veis
   * @param integer $iCodigo
   */
  public function __construct($iCodigo = null, $iSequencial = null) {

    $oDaoEditalDocumento = db_utils::getDao("editaldocumento");
    if (!empty($iCodigo)) {
       $sSQL                = $oDaoEditalDocumento->sql_query_file(null, '*', null, 'l48_edital='.$iCodigo);
    }else{
      $sSQL                = $oDaoEditalDocumento->sql_query_file($iSequencial);
    }
    $rsEditalDocumento   = $oDaoEditalDocumento->sql_record($sSQL);
    if ($oDaoEditalDocumento->numrows > 0) {

      $oEditalDocumento = db_utils::fieldsMemory($rsEditalDocumento, 0);

      $this->setCodigo($oEditalDocumento->l48_sequencial);
      $this->setArquivo($oEditalDocumento->l48_arquivo);
      $this->setNomeArquivo($oEditalDocumento->l48_nomearquivo);
      $this->setTipo($oEditalDocumento->l48_tipo);
      $this->setCodigoEdital($oEditalDocumento->l48_edital);
      unset($oEditalDocumento);
    }
  }

  /**
   * Chama persistirDados() se estiver setado o c?digo do documento
   */
  public function salvar() {

    if (empty($this->iCodigo)) {
     //Salva dados Novos
     $this->persistirDados();
    }
  }

  /**
   *
   * Pega os dados setados e persiste no BD
   * Salva o binario do Arquivo passado
   * @throws Exception
   */
  private function persistirDados() {

    global $conn;
    if (!file_exists($this->getArquivo())) {
      throw new Exception("Arquivo do Documento não Encontrado.");
    }

    db_inicio_transacao();
    try {

      /**
       * Abre um arquivo em formato binario somente leitura
       */
      $rDocumento      = fopen($this->getArquivo(), "rb");
      /**
			 * Pega todo o conte?do do arquivo e coloca no resource
       */
      $rDadosDocumento = fread($rDocumento, filesize($this->getArquivo()));
      $oOidBanco       = pg_lo_create();
      fclose($rDocumento);
      $oDaoEditalDocumento = db_utils::getDao("editaldocumento");

      $oDaoEditalDocumento->l48_arquivo     = $oOidBanco;
      $oDaoEditalDocumento->l48_tipo   = $this->getTipo();
      $oDaoEditalDocumento->l48_edital      = $this->getCodigoEdital();
      $oDaoEditalDocumento->l48_nomearquivo = $this->getNomeArquivo();
      $this->iCodigo = $oDaoEditalDocumento->l48_sequencial;
      $oDaoEditalDocumento->incluir(null);

      if ($oDaoEditalDocumento->erro_status == '0') {
        throw new Exception($oDaoEditalDocumento->erro_msg);
      }

      $oObjetoBanco = pg_lo_open($conn, $oOidBanco, "w");
      pg_lo_write($oObjetoBanco, $rDadosDocumento);
      pg_lo_close($oObjetoBanco);
      db_fim_transacao();

    } catch (Exception $oErro) {

      db_fim_transacao(true);
    }
  }

  /**
   *
   * Busca todos documentos de um Edital
   * @param integer
   * @return array
   */
  public function getDocumentos()
  {
    $sCampos = "l48_sequencial, l48_edital, l48_arquivo, l48_tipo ";
    $sWhere  = " l48_edital = {$this->getCodigoEdital()}";

    $oDaoEditalDocumento = db_utils::getDao("editaldocumento");
    $sSqlDocumentos      = $oDaoEditalDocumento->sql_query_file(null, $sCampos, 'l48_sequencial', $sWhere);

    $rsEditalDocumento   = $oDaoEditalDocumento->sql_record($sSqlDocumentos);

    if ($oDaoEditalDocumento->numrows > 0) {

      for ($i = 0; $i < $oDaoEditalDocumento->numrows; $i++) {

        $this->aDocumento[] = new EditalDocumento(null, db_utils::fieldsMemory($rsEditalDocumento, $i)->l48_sequencial);
      }
    }

    return $this->aDocumento;

  }


  /**
   *
   * Remove do Banco de Dados um documento de um determinado Edital
   * @throws Exception
   */
  public function remover() {

    $oDaoEditalDocumento = db_utils::getDao("editaldocumento");
    $oDaoEditalDocumento->excluir($this->getCodigo());

    if ($oDaoEditalDocumento->erro_status == "0") {
      throw new Exception($oDaoEditalDocumento->erro_msg);
    }
  }

  /**
   *
   * Retorna o c?digo do documento
   * @return integer
   */
  public function getCodigo() {
      return $this->iCodigo;
  }

  /**
  *
  * Seta o cdigo do documento
  */
  public function setCodigo($iCodigo) {
      $this->iCodigo = $iCodigo;
  }

  /**
  *
  * Retorna o código do edital
  * @return integer
  */
  public function getCodigoEdital() {
      return $this->iCodigoEdital;
  }

  /**
  *
  * Seta o código do edital
  */
  public function setCodigoEdital($iCodigoEdital) {
      $this->iCodigoEdital = $iCodigoEdital;
  }

  /**
  *
  * Retorna a descricao do documento
  * @return string
  */
  public function getTipo() {
      return $this->iTipo;
  }

  /**
  *
  * Seta a descricao do documento
  */
  public function setTipo($iTipo) {
      $this->iTipo = $iTipo;
  }

  /**
  *
  * Retorna o Oid do arquivo salvo
  * @return Oid
  */
  public function getArquivo() {
      return $this->sArquivo;
  }

  /**
  *
  * Seta uma String com caminho/nome do arquivo
  */
  public function setArquivo($sArquivo) {
      $this->sArquivo = $sArquivo;
  }

  /**
  *
  * Seta o Nome do arquivo com sua extens?o
  */
  public function setNomeArquivo($sNomeArquivo) {
    $this->sNomeArquivo = $sNomeArquivo;
  }

  /**
  *
  * Retorna o Nome do arquivo com sua extens?o
  * @return String
  */
  public function getNomeArquivo() {
    return $this->sNomeArquivo;
  }
}
