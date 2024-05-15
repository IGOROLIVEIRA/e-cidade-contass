<?php
require_once('std/DBLargeObject.php');

/**
 * Caminho das mensagens json do documento 
 */
define('URL_MENSAGEM_PROCESSO_DOCUMENTO', 'patrimonial.licitacao.AnexoComprasPNCP.');

/**
 * Model para documentos anexados ao processo do protocolo
 * 
 * @package Protocolo
 * @version $Revision: 1.17 $
 * @author Jeferson Belmiro <jeferson.belmiro@dbseller.com.br> 
 */
class AnexoComprasPNCP
{

    /**
     * Codigo do documento
     * - campo iCodigo
     * 
     * @var int
     * @access private
     */
    private $iCodproc;

    /**
     * Processo do protocolo
     * - campo l216_sequencial 
     * 
     * @var int
     * @access private
     */
    private $iSequencialAnexo;

    /**
     * Departamento do anexo
     * - campo l216_dataanexo
     * 
     * @var date
     * @access private
     */
    private $iDataanexo;

    /**
     * Departamento do anexo
     * - campo l216_id_usuario
     * 
     * @var int
     * @access private
     */
    private $iUsuario;

    /**
     * Departamento do anexo
     * - campo l216_hora
     * 
     * @var mixed
     * @access private
     */
    private $iHora;

    /**
     * Departamento do anexo
     * - campo l216_instit
     * 
     * @var int
     * @access private
     */
    private $iInstituicao;

    /**
     * Contrutor da classe, executa lazy load
     *
     * @param int $iCodproc
     * @access public
     * @return void
     */
    public function __construct($iCodproc = null)
    {

        /**
         * Documento nao inforamdo, contrutor nao fara nada 
         */
        if (empty($iCodproc)) {
            return false;
        }

        $this->iCodproc = $iCodproc;
        $oDaoComprasanexopncp = db_utils::getDao('anexocomprapncp');
        $sSqlDocumento = $oDaoComprasanexopncp->sql_query_file(null, "*", null, "l216_codproc = $iCodproc");
        $rsDocumento   = $oDaoComprasanexopncp->sql_record($sSqlDocumento);

        if ($oDaoComprasanexopncp->numrows > 0) {

            $oDocumento = db_utils::fieldsMemory($rsDocumento, 0);
            $this->setSequencialAnexo($oDocumento->l216_sequencial);
            $this->setPcproc($oDocumento->l216_codproc);
        }
    }

    /**
     * Retorna o codigo do documento
     *
     * @access public
     * @return int
     */
    public function getCodigo()
    {
        return $this->iCodproc;
    }

    /**
     * Define processo protocolo
     *
     * @param AnexoComprasPNCP $oProcessoCompras
     * @access public
     * @return void
     */
    public function setSequencialAnexo($iSequencialAnexo)
    {
        $this->iSequencialAnexo = $iSequencialAnexo;
    }

    /**
     * Retorno o processo do protocolo
     *
     * @access public
     * @return AnexoComprasPNCP
     */
    public function getSequencialAnexo()
    {
        return $this->iSequencialAnexo;
    }

    /**
     * Define a descricao do documento
     *
     * @param string $iCodproc
     * @access public
     * @return void
     */
    public function setPcproc($iCodproc)
    {
        $this->iCodproc = $iCodproc;
    }

    /**
     * Retorna a descricao do documento
     *
     * @access public
     * @return string
     */
    public function getPcproc()
    {
        return $this->iCodproc;
    }



    /**
     * Retorna os documentos anexados ao processo
     * @return ProcessoComprasDocumento[]
     */
    public function getDocumentos()
    {

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
    private function carregarDocumentosAnexados()
    {

        $oDaoProcessoDocumento = db_utils::getDao('anexocomprapncp');
        $sSqlBuscaDocumentos   = $oDaoProcessoDocumento->sql_query_file(
            null,
            "l217_sequencial",
            "l216_sequencial",
            "l216_codproc = {$this->iCodproc}"
        );

        $rsBuscaProcesso = $oDaoProcessoDocumento->sql_record($sSqlBuscaDocumentos);

        for ($iRowDocumento = 0; $iRowDocumento < $oDaoProcessoDocumento->numrows; $iRowDocumento++) {

            $iCodigoSequencial = db_utils::fieldsMemory($rsBuscaProcesso, $iRowDocumento)->l217_sequencial;
            $this->aDocumentosAnexados[] = new ProcessoComprasDocumento($iCodigoSequencial);
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
    public function salvar()
    {
        if ($this->getSequencialAnexo() == '') {
            $oDaoComprasanexopncp = db_utils::getDao('anexocomprapncp');

            $oDaoComprasanexopncp->l216_sequencial    = null;
            $oDaoComprasanexopncp->l216_codproc  = $this->getPcproc();
            $oDaoComprasanexopncp->l216_dataanexo     = date('Y-m-d', db_getsession('DB_datausu'));
            $oDaoComprasanexopncp->l216_id_usuario     = db_getsession('DB_id_usuario');
            $oDaoComprasanexopncp->l216_hora     = db_hora();
            $oDaoComprasanexopncp->l216_instit     = db_getsession('DB_instit');
            $oDaoComprasanexopncp->incluir();

            $this->setSequencialAnexo($oDaoComprasanexopncp->l216_sequencial);

            /**
             * Erro ao incluir documento
             */
            if ($oDaoComprasanexopncp->erro_status == "0") {
                throw new Exception($oDaoComprasanexopncp->erro_msg);
            }
            return true;
        }
    }
}
