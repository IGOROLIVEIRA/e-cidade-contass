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
class EditalDocumento
{

	protected $iCodigo;
	protected $iTipo;
	protected $iEdital;
	protected $sArquivo;
	protected $sNomeArquivo;
	protected $sCaminho;
	protected $iLicLicita;


	/**
	 *
	 * Construtor, se passado parâmetro seta todas variáveis
	 * @param integer $iCodigo
	 */
	public function __construct($iCodigo = null)
	{
		$oDaoEditalDocumento = db_utils::getDao("editaldocumento");
		if(isset($iCodigo)) {
			$sSQL = $oDaoEditalDocumento->sql_query_file($iCodigo, 'l48_sequencial, l48_nomearquivo, l48_tipo, l20_nroedital, l48_liclicita, l48_caminho');
			$rsEditalDocumento = $oDaoEditalDocumento->sql_record($sSQL);

			if ($oDaoEditalDocumento->numrows > 0) {

				$oEditalDocumento = db_utils::fieldsMemory($rsEditalDocumento, 0);

				$this->setCodigo($oEditalDocumento->l48_sequencial);
				$this->setNomeArquivo($oEditalDocumento->l48_nomearquivo);
				$this->setTipo($oEditalDocumento->l48_tipo);
				$this->setEdital($oEditalDocumento->l20_nroedital);
				$this->setLiclicita($oEditalDocumento->l48_liclicita);
				$this->setCaminho($oEditalDocumento->l48_caminho);
				unset($oEditalDocumento);
			}
		}
	}

	/**
	 * Chama persistirDados() se estiver setado o c?digo do documento
	 */
	public function salvar()
	{

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
	private function persistirDados()
	{

		global $conn;
		if (!file_exists($this->getCaminho())) {
			throw new Exception("Arquivo do Documento não Encontrado.");
		}

		db_inicio_transacao();
		try {
			$oDaoEditalDocumento = db_utils::getDao("editaldocumento");
			$oDaoEditalDocumento->l48_tipo = $this->getTipo();
			$oDaoEditalDocumento->l48_nomearquivo = $this->getNomeArquivo();
			$oDaoEditalDocumento->l48_caminho = $this->getCaminho();
			$oDaoEditalDocumento->l48_liclicita = $this->getLiclicita();
			$oDaoEditalDocumento->incluir(null);

			if ($oDaoEditalDocumento->erro_status == '0') {
				throw new Exception($oDaoEditalDocumento->erro_msg);
			}

			db_fim_transacao();

		} catch (Exception $oErro) {
			db_fim_transacao(true);
		}
	}

	/**
	 *
	 * Busca todos documentos de uma licitação
	 * @param integer
	 * @return array
	 */
	public function getDocumentos($licitacao)
	{
		$sCampos = "l48_sequencial";

		$sWhere = " l48_liclicita = $licitacao";
		$oDaoEditalDocumento = db_utils::getDao("editaldocumento");
		$sSqlDocumentos = $oDaoEditalDocumento->sql_query_file(null, $sCampos, 'l48_sequencial', $sWhere);
		$rsEditalDocumento = $oDaoEditalDocumento->sql_record($sSqlDocumentos);

		if ($oDaoEditalDocumento->numrows > 0) {

			for ($i = 0; $i < $oDaoEditalDocumento->numrows; $i++) {
				$this->aDocumento[] = new EditalDocumento(db_utils::fieldsMemory($rsEditalDocumento, $i)->l48_sequencial);
			}
		}

		return $this->aDocumento;

	}


	/**
	 *
	 * Remove do Banco de Dados um documento de um determinado Edital
	 * @throws Exception
	 */
	public function remover()
	{

		$oDaoEditalDocumento = db_utils::getDao("editaldocumento");
		$oDaoEditalDocumento->excluir($this->getCodigo());

		if ($oDaoEditalDocumento->erro_status == "0") {
			throw new Exception($oDaoEditalDocumento->erro_msg);
		}
	}

	/**
	 *
	 * Retorna o código do documento
	 * @return integer
	 */
	public function getCodigo()
	{
		return $this->iCodigo;
	}

	/**
	 *
	 * Seta o cdigo do documento
	 */
	public function setCodigo($iCodigo)
	{
		$this->iCodigo = $iCodigo;
	}

	/**
	 *
	 * Retorna o código do edital
	 * @return integer
	 */
	public function getCodigoEdital()
	{
		return $this->iCodigoEdital;
	}

	/**
	 *
	 * Seta o código do edital
	 */
	public function setCodigoEdital($iCodigoEdital)
	{
		$this->iCodigoEdital = $iCodigoEdital;
	}

	/**
	 *
	 * Retorna a descricao do documento
	 * @return string
	 */
	public function getTipo()
	{
		return $this->iTipo;
	}

	/**
	 *
	 * Seta a descricao do documento
	 */
	public function setTipo($iTipo)
	{
		$this->iTipo = $iTipo;
	}

	/**
	 *
	 * Retorna o número do edital da licitação
	 * @return string
	 */
	public function getEdital()
	{
		return $this->iEdital;
	}

	/**
	 *
	 * Seta o numero do edital da licitação
	 */
	public function setEdital($iEdital)
	{
		$this->iEdital = $iEdital;
	}

	/**
	 *
	 * Retorna o caminho do arquivo salvo
	 * @return String
	 */
	public function getCaminho()
	{
		return $this->sCaminho;
	}
	/**
	 *
	 * Seta o numero da licitação
	 */
	public function setLicLicita($iLicLicita)
	{
		$this->iLicLicita = $iLicLicita;
	}

	/**
	 *
	 * Retorna o numero da licitação
	 * @return String
	 */
	public function getLicLicita()
	{
		return $this->iLicLicita;
	}

	/**
	 *
	 * Seta uma String com caminho/nome do arquivo
	 */
	public function setCaminho($sCaminho)
	{
		$this->sCaminho = $sCaminho;
	}

	/**
	 *
	 * Seta o Nome do arquivo com sua extensão
	 */
	public function setNomeArquivo($sNomeArquivo)
	{
		$this->sNomeArquivo = $sNomeArquivo;
	}

	/**
	 *
	 * Retorna o Nome do arquivo com sua extensão
	 * @return String
	 */
	public function getNomeArquivo()
	{
		return $this->sNomeArquivo;
	}
}
