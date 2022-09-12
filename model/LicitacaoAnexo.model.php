<?php
/*
 *     E-cidade Software Público para Gestão Municipal                
 *  Copyright (C) 2014  DBseller Serviços de Informática             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa é software livre; você pode redistribuí-lo e/ou     
 *  modificá-lo sob os termos da Licença Pública Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versão 2 da      
 *  Licença como (a seu critério) qualquer versão mais nova.          
 *                                                                    
 *  Este programa e distribuído na expectativa de ser útil, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implícita de              
 *  COMERCIALIZAÇÃO ou de ADEQUAÇÃO A QUALQUER PROPÓSITO EM           
 *  PARTICULAR. Consulte a Licença Pública Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Você deve ter recebido uma cópia da Licença Pública Geral GNU     
 *  junto com este programa; se não, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Cópia da licença no diretório licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */


require_once ('std/DBLargeObject.php');

/**
 * Caminho das mensagens json do documento 
 */
define('URL_MENSAGEM_PROCESSO_DOCUMENTO', 'patrimonial.licitacao.LicitacaoAnexo.');

/**
 * Model para documentos anexados ao processo do protocolo
 * 
 * @package Protocolo
 * @version $Revision: 1.17 $
 * @author Jeferson Belmiro <jeferson.belmiro@dbseller.com.br> 
 */
class LicitacaoAnexo {

  /**
   * Codigo do documento
   * - campo l215_liclicita
   * 
   * @var int
   * @access private
   */
  private $iCodigo; 

  /**
   * Processo do protocolo
   * - campo l215_sequencial 
   * 
   * @var int
   * @access private
   */
  private $oProcessoLicitacao; 

  /**
   * Descricao do documento
   * - campo l215_liclicita 
   * 
   * @var int
   * @access private
   */
  private $iLicitacao; 



  /**
   * Departamento do anexo
   * - campo l215_dataanexo
   * 
   * @var date
   * @access private
   */
  private $iDataanexo;
  
    /**
   * Departamento do anexo
   * - campo l215_id_usuario
   * 
   * @var int
   * @access private
   */
  private $iUsuario;

    /**
   * Departamento do anexo
   * - campo l215_hora
   * 
   * @var mixed
   * @access private
   */
  private $iHora;

    /**
   * Departamento do anexo
   * - campo l215_instit
   * 
   * @var int
   * @access private
   */
  private $iInstituicao;

  /**
   * Contrutor da classe, executa lazy load
   *
   * @param int $iCodigo
   * @access public
   * @return void
   */
  public function __construct($iCodigo = null) {

    /**
     * Documento nao inforamdo, contrutor nao fara nada 
     */
    if ( empty($iCodigo) ) {
      return false;
    }

    $this->iCodigo = $iCodigo;
    $oDaoLicanexopncp = db_utils::getDao('licanexopncp');
    $sSqlDocumento = $oDaoLicanexopncp->sql_query_file(null,"*",null,"l215_liclicita = $iCodigo");
    $rsDocumento   = $oDaoLicanexopncp->sql_record($sSqlDocumento);

    if ($oDaoLicanexopncp->numrows > 0) {

      $oDocumento = db_utils::fieldsMemory($rsDocumento, 0);
      $this->setProcessoLicitacao ($oDocumento->l215_sequencial); 
      $this->setLicitacao          ($oDocumento->l215_liclicita);
    }      
  }

  /**
   * Retorna o codigo do documento
   *
   * @access public
   * @return int
   */
  public function getCodigo() {
    return $this->iCodigo;
  }

  /**
   * Define processo protocolo
   *
   * @param LicitacaoAnexo $oProcessoLicitacao
   * @access public
   * @return void
   */
  public function setProcessoLicitacao($oProcessoLicitacao) {
    $this->oProcessoLicitacao = $oProcessoLicitacao;
  }

  /**
   * Retorno o processo do protocolo
   *
   * @access public
   * @return LicitacaoAnexo
   */
  public function getProcessoLicitacao() {
    return $this->oProcessoLicitacao;
  }

  /**
   * Define a descricao do documento
   *
   * @param string $iLicitacao
   * @access public
   * @return void
   */
  public function setLicitacao($iLicitacao) {
    $this->iLicitacao = $iLicitacao;
  } 

  /**
   * Retorna a descricao do documento
   *
   * @access public
   * @return string
   */
  public function getLicitacao() {
    return $this->iLicitacao;
  } 

 

    /**
   * Retorna os documentos anexados ao processo
   * @return LicitacaoDocumento[]
   */
  public function getDocumentos() {

    if (count($this->aDocumentosAnexados) == 0) {
      $this->carregarDocumentosAnexados();
    }
    return $this->aDocumentosAnexados;
  }

  /**
   * Método responsável por carregar os documentos anexados a um processo.
   * - No método getDocumentos é validado se a propriedade aDocumentosAnexados está vazia,
   * caso esteja é chamado este método para carregar os documentos.
   * @return boolean true
   */
  private function carregarDocumentosAnexados() {

    $oDaoProcessoDocumento = db_utils::getDao('licanexopncpdocumento');
    $sSqlBuscaDocumentos   = $oDaoProcessoDocumento->sql_query_file(null,
                                                                    "l216_sequencial",
                                                                    "l216_sequencial",
                                                                    "l216_licanexospncp = {$this->oProcessoLicitacao}");
    $rsBuscaProcesso = $oDaoProcessoDocumento->sql_record($sSqlBuscaDocumentos);

    for ($iRowDocumento = 0; $iRowDocumento < $oDaoProcessoDocumento->numrows; $iRowDocumento++) {

      $iCodigoSequencial = db_utils::fieldsMemory($rsBuscaProcesso, $iRowDocumento)->l216_sequencial;
      $this->aDocumentosAnexados[] = new LicitacaoDocumento($iCodigoSequencial);
    }
    return true;
  }

  
  /**
   * Inclui documento para o processo do protocolo
   * - salva arquivo no banco
   *
   * @access private
   * @return boolean
   */
  public function salvar() {

    if($this->getProcessoLicitacao()==''){

      $oDaoLicanexopncp = db_utils::getDao('licanexopncp');
      
      $oDaoLicanexopncp->l215_sequencial    = null;   
      $oDaoLicanexopncp->l215_liclicita  = $this->getLicitacao();   
      $oDaoLicanexopncp->l215_dataanexo     = date('Y-m-d',db_getsession('DB_datausu'));
      $oDaoLicanexopncp->l215_id_usuario     = db_getsession('DB_id_usuario');
      $oDaoLicanexopncp->l215_hora     = db_hora();
      $oDaoLicanexopncp->l215_instit     = db_getsession('DB_instit');
      $oDaoLicanexopncp->incluir();
      
      $this->setProcessoLicitacao($oDaoLicanexopncp->l215_sequencial);

      /**
       * Erro ao incluir documento
       */
      if ( $oDaoLicanexopncp->erro_status == "0" ) {
        throw new Exception($oDaoLicanexopncp->erro_msg);
      }
    }
    return true;

  }


}