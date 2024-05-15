<?php
require_once('std/DBLargeObject.php');

/**
 * Caminho das mensagens json do documento 
 */
define('URL_MENSAGEM_PROCESSO_DOCUMENTO', 'patrimonial.licitacao.LicitacaoDocumento.');

/**
 * Model para documentos anexados ao processo do protocolo
 * 
 * @package Protocolo
 * @version $Revision: 1.17 $
 * @author Jeferson Belmiro <jeferson.belmiro@dbseller.com.br> 
 */
class ProcessoComprasDocumento
{

    /**
     * Codigo do documento
     * - campo p01_sequencial
     * 
     * @var int
     * @access private
     */
    private $iCodigo;

    /**
     * Processo do protocolo
     * - campo p01_protprocesso 
     * 
     * @var AnexoComprasPNCP
     * @access private
     */
    private $oAnexoComprasPNCP;


    /**
     * OID do documento anexado ao processo
     * - campo p01_documento
     * 
     * @var int
     * @access private
     */
    private $iOid;


    /**
     * Tamanho limite do arquivo em bytes
     * - Limite 30mb
     * 
     * @var int
     * @access private
     */
    private $iLimiteTamanho = 31457280;

    /**
     * Extensões não permitidas para os documentos
     * 
     * @var array
     * @access private
     */
    private $aExtensoesInvalidas = array('exe');

    /**
     * Caminho completo do arquivo
     * - Usado para salvar ou exportar do banco
     * 
     * @var string
     * @access private
     */
    private $sCaminhoArquivo;

    /**
     * Contrutor da classe, executa lazy load
     *
     * @param int $iCodigo
     * @access public
     * @return void
     */
    public function __construct($iCodigo = null)
    {

        /**
         * Documento nao inforamdo, contrutor nao fara nada 
         */
        if (empty($iCodigo)) {
            return false;
        }

        $oDaocomanexopncpdocumento = db_utils::getDao('comanexopncpdocumento');
        $dbwhere = "l217_sequencial = " . $iCodigo;
        $sSqlDocumento = $oDaocomanexopncpdocumento->sql_query_file(null, "*", null, $dbwhere);

        $rsDocumento   = $oDaocomanexopncpdocumento->sql_record($sSqlDocumento);

        if ($oDaocomanexopncpdocumento->erro_status  == "0") {

            $oStdMsgErro = (object)array("iDocumento" => "$iCodigo");
            throw new BusinessException('Erro no construtor');
        }

        $oDocumento = db_utils::fieldsMemory($rsDocumento, 0);
        $this->iCodigo            = $oDocumento->l217_sequencial;
        $this->oAnexoComprasPNCP    = $oDocumento->l217_licanexospncp;
        $this->iOid               = $oDocumento->l217_documento;
        $this->sNomeDocumento     = $oDocumento->l217_nomedocumento;
        $this->iTipoanexo         = $oDocumento->l217_tipoanexo;

        $oDaoTipoanexo = db_utils::getDao('tipoanexo');
        $sSqlTipo = $oDaoTipoanexo->sql_query_file($oDocumento->l217_tipoanexo);
        $rsTipo   = $oDaoTipoanexo->sql_record($sSqlTipo);


        if ($oDaoTipoanexo->erro_status  == "0") {

            $oStdMsgErro = (object)array("iDocumento" => "$iCodigo");
            throw new BusinessException('Erro no construtor');
        }

        $oTipo = db_utils::fieldsMemory($rsTipo, 0);
        $this->sDescricaoTipo            = $oTipo->l213_descricao;
    }

    /**
     * Retorna o codigo do documento
     *
     * @access public
     * @return int
     */
    public function getCodigo()
    {
        return $this->iCodigo;
    }

    /**
     * Define processo protocolo
     *
     * @param AnexoComprasPNCP $oAnexoComprasPNCP
     * @access public
     * @return void
     */
    public function setProcessoProtocolo(AnexoComprasPNCP $oAnexoComprasPNCP)
    {
        $this->oAnexoComprasPNCP = $oAnexoComprasPNCP;
    }

    /**
     * Retorno o processo do protocolo
     *
     * @access public
     * @return AnexoComprasPNCP
     */
    public function getProcessoProtocolo()
    {
        return $this->oAnexoComprasPNCP;
    }


    /**
     * Define o OID do documento
     *
     * @param int $iOid
     * @access public
     * @return void
     */
    public function setOID($iOid)
    {
        $this->iOid = $iOid;
    }

    /**
     * Retorna o OID do documento
     *
     * @access public
     * @return int
     */
    public function getOID()
    {
        return $this->iOid;
    }

    /**
     * Define o caminho do arquivo
     *
     * @access public
     * @return int
     */
    public function setCaminhoArquivo($sCaminhoArquivo)
    {
        $this->sCaminhoArquivo = $sCaminhoArquivo;
    }

    /**
     * Retorna o caminho do arquivo
     *
     * @access public
     * @return int
     */
    public function getCaminhoArquivo()
    {
        return $this->sCaminhoArquivo;
    }

    /** 
     * Retorna o nome do documento
     * @access public
     * @return string
     */
    public function getNomeDocumento()
    {
        return $this->sNomeDocumento;
    }

    public function getDescricaoTipo()
    {
        return $this->sDescricaoTipo;
    }


    /**
     * Define o caminho do arquivo
     *
     * @access public
     * @return int
     */
    public function setTipoanexo($iTipoanexo)
    {
        $this->iTipoanexo = $iTipoanexo;
    }


    /** 
     * Retorna o tipo do documento
     * @access public
     * @return string
     */
    public function getTipoanexo()
    {
        return $this->iTipoanexo;
    }

    /**
     * Validar arquivo
     * - tamanho limite
     * - extensão
     *
     * @access public
     * @return boolean
     */
    private function validarArquivo()
    {

        $oStdMensagemErro    = new stdClass();
        $oStdMensagemErro->sCaminhoArquivo = $this->sCaminhoArquivo;
        $oStdMensagemErro->iLimiteTamanho  = $this->iLimiteTamanho;

        /** filesize($this->sCaminhoArquivo) > $this->iLimiteTamanho 
         * Arquivo nao encontrado
         */
        if (!file_exists($this->sCaminhoArquivo)) {
            throw new BusinessException('Arquivo não existe');
        }

        $aInformacoesArquivo = pathinfo($this->sCaminhoArquivo);

        /**
         * Arquivo maior que o permitido 
         */
        if (filesize($this->sCaminhoArquivo) > $this->iLimiteTamanho) {
            throw new BusinessException('Tamanho maior que 30mb');
        }

        /**
         * Arquivo com extensao invalida
         */
        if (!empty($aInformacoesArquivo['extension']) && in_array($aInformacoesArquivo['extension'], $this->aExtensoesInvalidas)) {

            $oStdMensagemErro->sExtensao = $aInformacoesArquivo['extension'];
            throw new BusinessException('Extensão Invalida');
        }

        return true;
    }

    /**
     * Salvar
     *
     * @access public
     * @return boolean
     */
    public function salvar()
    {

        if (!db_utils::inTransaction()) {
            throw new DBException('Nenhuma transação de banco');
        }


        /**
         * Valida arquivo, tamanho e extensao 
         */
        $this->validarArquivo();

        return $this->incluir();
    }

    /**
     * Inclui documento para o processo do protocolo
     * - salva arquivo no banco
     *
     * @access private
     * @return boolean
     */
    private function incluir()
    {

        /**
         * Processo do protocolo nao informado
         */
        if (!($this->oAnexoComprasPNCP instanceof AnexoComprasPNCP) && $this->getProcessoProtocolo()->getSequencialAnexo() != '') {
            throw new Exception('Licitação não informada.');
        }

        // $this->iOi = $this->salvarArquivoBanco();
        $this->sNomeDocumento = basename($this->sCaminhoArquivo);
        $oDaocomanexopncpdocumento = db_utils::getDao('comanexopncpdocumento');
        $oDaocomanexopncpdocumento->l217_sequencial    = null;
        $oDaocomanexopncpdocumento->l217_licanexospncp  = $this->getProcessoProtocolo()->getSequencialAnexo();
        $oDaocomanexopncpdocumento->l217_documento     = $this->sNomeDocumento;
        $oDaocomanexopncpdocumento->l217_nomedocumento = $this->sNomeDocumento;
        $oDaocomanexopncpdocumento->l217_tipoanexo = $this->iTipoanexo;
        $oDaocomanexopncpdocumento->incluir(null);

        /**
         * Erro ao incluir documento
         */
        if ($oDaocomanexopncpdocumento->erro_status == "0") {
            throw new Exception('Erro ao incluir o documento');
        }

        $this->iCodigo = $oDaocomanexopncpdocumento->l217_sequencial;
        return  'Anexo salvo com sucesso!'; //true;
    }


    /**
     * Salva arquivo no banco
     * - gera OID
     *
     * @access private
     * @return int
     */
    private function salvarArquivoBanco()
    {

        $iOid = DBLargeObject::criaOID(true);
        $lEscreveuArquivo = DBLargeObject::escrita($this->sCaminhoArquivo, $iOid);

        if (!$lEscreveuArquivo) {
            throw new BusinessException('Erro ao escrever arquivo no banco.');
        }

        return $iOid;
    }

    /**
     * Download documento 
     * - retorna o caminho do arquivo para download
     *
     * @access public
     * @return string - caminho do arquivo extraido do banco
     */
    public function download()
    {

        $sCaracteres = "/[^a-z0-9\\_\.]/i";
        $sNomeArquivo = str_replace(" ", '_', $this->sNomeDocumento);
        $sNomeArquivo = preg_replace($sCaracteres, '', $sNomeArquivo);
        $sCaminhoArquivo  = '/tmp/' . $sNomeArquivo;

        if (!copy('model/licitacao/PNCP/anexoslicitacao/' . $this->iOid, $sCaminhoArquivo)) {
            throw new BusinessException("Erro ao copiar arquivo para tmp.");
        }

        return $sCaminhoArquivo;
    }

    /**
     * Exclui documento
     *
     * @access public
     * @return boolean
     */
    public function excluir()
    {

        if (empty($this->iCodigo)) {
            throw new Exception('Documento não especificado.');
        }
        $oDaocomanexopncpdocumento = db_utils::getDao('comanexopncpdocumento');
        $oDaocomanexopncpdocumento->excluir($this->iCodigo);

        if ($oDaocomanexopncpdocumento->erro_status  == "0") {
            throw new Exception('Erro ao excluir o Arquivo.');
        }

        return true;
    }

    public function buscartipo()
    {
        if (empty($this->iCodigo)) {
            throw new Exception('Documento não especificado.');
        }
        return $this->getTipoanexo();
    }

    public function alterartipo($idocumento, $itipoanexo)
    {
        if (empty($idocumento)) {
            throw new Exception('Documento não especificado.');
        }
        if (empty($itipoanexo)) {
            throw new Exception('Tipo não especificado.');
        }

        $oDaocomanexopncpdocumento = db_utils::getDao('comanexopncpdocumento');
        $oDaocomanexopncpdocumento->l217_tipoanexo = $itipoanexo;
        $oDaocomanexopncpdocumento->alterar($idocumento);

        if ($oDaocomanexopncpdocumento->erro_status  == "0") {
            throw new Exception('Erro ao alterar o Arquivo.');
        }

        return true;
    }

    public function verificavinculo($ilicitacao)
    {

        if (empty($ilicitacao)) {
            throw new Exception('Licitação não especificado.');
        }

        $oDaocomanexopncpdocumento = db_utils::getDao('comanexopncpdocumento');

        $oDaocomanexopncpdocumento->sql_record($oDaocomanexopncpdocumento->verificalic($ilicitacao));

        if ($oDaocomanexopncpdocumento->numrows  == 0) {
            throw new Exception('A Licitação selecionada é decorrente da Lei nº 14133/2021, sendo assim, é necessário anexar no mínimo um documento na rotina Anexos Envio PNCP.');
        }
        if ($oDaocomanexopncpdocumento->erro_status  == "0") {
            throw new Exception('Erro ao verificar vinculo com o PNCP');
        }
        return true;
    }
}
