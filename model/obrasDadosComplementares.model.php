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

class obrasDadosComplementares
{
	private $codobra = null;
	private $cep = null;
	private $pais = null;
	private $estado = null;
	private $municipio = null;
	private $distrito = '';
	private $bairro = '';
	private $numero = '';
	private $logradouro = '';

	/**
	 * Usados apenas se não existir lote para a licitação
	 */
	private $grauslatitude = null;
	private $minutolatitude = null;
	private $segundolatitude = null;
	private $grauslongitude = null;
	private $minutolongitude = null;
	private $segundolongitude = null;

	/**
	 * Usados quando existir lote para a licitação
	 */
	private $latitude = null;
	private $longitude = null;

	private $classeobjeto = null;
	private $atividadeobra = null;
	private $atividadeservico = null;
	private $descratividadeservico = null;
	private $atividadeservicoesp = null;
	private $descratividadeservicoesp = null;
	private $grupobempublico = null;
	private $subgrupobempublico = null;
	private $bdi = null;
	private $sequencial = null;
	private $sLote = null;
	private $lLote = false;


	/**
	 *
	 */
	function __construct($iCodigoObra = null, $sLote)
	{

		if ($iCodigoObra != null) {
			$sWhere = " db150_codobra = " . $iCodigoObra;

			if(!$sLote){
				$oDaoLocal = db_utils::getDao('obrasdadoscomplementares');
			}else{
				$oDaoLocal = db_utils::getDao('obrasdadoscomplementareslote');
			}
			$sQueryLocal = $oDaoLocal->sql_query(null, "*", null, $sWhere);
			$rsQueryLocal = $oDaoLocal->sql_record($sQueryLocal);

			if ($rsQueryLocal === false) {
				throw new Exception('Nenhum endereço da obra encontrado para o código informado(' . $iCodigoObra . ').');
			}

			$oDados = db_utils::fieldsMemory($rsQueryLocal, 0);

			$this->setEstado($oDados->db150_estado);
			$this->setPais($oDados->db150_pais);
			$this->setMunicipio($oDados->db150_municipio);
			$this->setBairro($oDados->db150_bairro);
			$this->setNumero($oDados->db150_numero);
			$this->setCep($oDados->db150_cep);
			$this->setCodigoObra($oDados->db150_codobra);
			$this->setDistrito($oDados->db150_distrito);
			$this->setLogradouro($oDados->db150_logradouro);

			if(!$sLote){

				$this->setGrausLatitude($oDados->db150_grauslatitude);
				$this->setMinutoLatitude($oDados->db150_minutolatitude);
				$this->setSegundoLatitude($oDados->db150_segundolatitude);
				$this->setGrausLongitude($oDados->db150_grauslongitude);
				$this->setMinutoLongitude($oDados->db150_minutolongitude);
				$this->setSegundoLongitude($oDados->db150_segundolongitude);

			}else{
				$this->setLatitude($oDados->db150_latitude);
				$this->setLongitude($oDados->db150_longitude);
			}

			$this->setClasseObjeto($oDados->db150_classeobjeto);
			$this->setAtividadeObra($oDados->db150_atividadeObra);
			$this->setAtividadeServico($oDados->db150_atividadeservico);
			$this->setDescrAtividadeServico($oDados->db150_descrAtividadeServico);
			$this->setAtividadeServicoEsp($oDados->db150_atividadeservicoesp);
			$this->setDescrAtividadeServicoEsp($oDados->db150_descratividadeservicoesp);
			$this->setGrupoBemPublico($oDados->db150_grupobempublico);
			$this->setSubGrupoBemPublico($oDados->db150_subgrupobempublico);
			$this->setBdi($oDados->db150_bdi);
			$this->setLicita($oDados->db151_liclicita);
			$this->setSequencial($oDados->db150_sequencial);
		}

	}

	/**
	 * Metodo para setar a propriedade codigo obra
	 * @param integer cep
	 * @return void
	 */
	public function setCodigoObra($iCodigoObra){
		$this->codobra = $iCodigoObra;
	}

	/**
	 * Metodo para retornar a propriedade código obra
	 * @return integer codigoobra
	 */
	public function getCodigoObra()	{
		return $this->codobra;
	}

	/**
	 * Metodo para setar a propriedade descrição do Distrito
	 * @param string distrito
	 * @return void
	 */
	public function setDistrito($sDistrito)	{
		$this->distrito = $sDistrito;
	}

	/**
	 * Metodo para retornar a propriedade descrição do Distrito
	 * @return string distrito
	 */
	public function getDistrito(){
		return $this->distrito;
	}

	/**
	 * Metodo para setar a propriedade logradouro
	 * @param string logradouro
	 * @return void
	 */
	public function setLogradouro($sLogradouro){
		$this->logradouro = $sLogradouro;
	}

	/**
	 * Metodo para retornar a propriedade Logradouro
	 * @return string logradouro
	 */
	public function getLogradouro()	{
		return $this->logradouro;
	}

	/**
	 * Metodo para setar a propriedade Graus Latitude
	 * Usado apenas quando não existir lote
	 * @param integer grauslatitude
	 * @return void
	 */
	public function setGrausLatitude($iGrausLatitude)	{
		$this->grauslatitude = $iGrausLatitude;
	}

	/**
	 * Metodo para retornar a propriedade grauslatitude
	 * Usado apenas quando não existir lote
	 * @return integer grauslatitude
	 */
	public function getGrausLatitude()	{
		return $this->grauslatitude;
	}

	/**
	 * Metodo para setar a propriedade minutolatitude
	 * Usado apenas quando não existir lote
	 * @param integer minutolatitude
	 * @return void
	 */
	public function setMinutoLatitude($iMinutoLatitude)	{
		$this->minutolatitude = $iMinutoLatitude;
	}

	/**
	 * Metodo para retornar a propriedade minutolatitude
	 * Usado apenas quando não existir lote
	 * @return integer minutolatitude
	 */
	public function getMinutoLatitude()	{
		return $this->minutolatitude;
	}

	/**
	 * Metodo para setar a propriedade segundolatitude
	 * Usado apenas quando não existir lote
	 * @param float segundolatitude
	 * @return void
	 */
	public function setSegundoLatitude($iSegundoLatitude)	{
		$this->segundolatitude = $iSegundoLatitude;
	}

	/**
	 * Metodo para retornar a propriedade segundolatitude
	 * Usado apenas quando não existir lote
	 * @return float segundolatitude
	 */
	public function getSegundoLatitude(){
		return $this->segundolatitude;
	}

	/**
	 * Metodo para setar a propriedade Graus Longitude
	 * Usado apenas quando não existir lote
	 * @param integer grauslongitude
	 * @return void
	 */
	public function setGrausLongitude($iGrausLongitude){
		$this->grauslongitude = $iGrausLongitude;
	}

	/**
	 * Metodo para retornar a propriedade grauslongitude
	 * Usado apenas quando não existir lote
	 * @return integer grauslongitude
	 */
	public function getGrausLongitude(){
		return $this->grauslongitude;
	}

	/**
	 * Metodo para setar a propriedade minutolongitude
	 * Usado apenas quando não existir lote
	 * @param integer minutolongitude
	 * @return void
	 */
	public function setMinutoLongitude($iMinutoLongitude){
		$this->minutolongitude = $iMinutoLongitude;
	}

	/**
	 * Metodo para retornar a propriedade minutolongitude
	 * Usado apenas quando não existir lote
	 * @return integer minutolongitude
	 */
	public function getMinutoLongitude(){
		return $this->minutolongitude;
	}

	/**
	 * Metodo para setar a propriedade segundolongitude
	 * Usado apenas quando não existir lote
	 * @param float segundolongitude
	 * @return void
	 */
	public function setSegundoLongitude($iSegundoLongitude)	{
		$this->segundolongitude = $iSegundoLongitude;
	}

	/**
	 * Metodo para retornar a propriedade segundolongitude
	 * Usado apenas quando não existir lote
	 * @return float segundolongitude
	 */
	public function getSegundoLongitude(){
		return $this->segundolongitude;
	}

	/**
	 * Metodo para setar a propriedade longitude
	 * Usado apenas quando existir lote
	 * @param float longitude
	 * @return void
	 */
	public function setLongitude($iLongitude)	{
		$this->longitude = $iLongitude;
	}

	/**
	 * Metodo para retornar a propriedade longitude
	 * Usado apenas quando existir lote
	 * @return float longitude
	 */
	public function getLongitude(){
		return $this->longitude;
	}

	/**
	 * Metodo para setar a propriedade latitude
	 * Usado apenas quando existir lote
	 * @param float latitude
	 * @return void
	 */
	public function setLatitude($iLatitude)	{
		$this->latitude = $iLatitude;
	}

	/**
	 * Metodo para retornar a propriedade latitude
	 * Usado apenas quando existir lote
	 * @return float latitude
	 */
	public function getLatitude(){
		return $this->latitude;
	}

	/**
	 * Metodo para setar a propriedade classeobjeto
	 * @param integer classeobjeto
	 * @return void
	 */
	public function setClasseObjeto($iClasseObjeto)	{
		$this->classeobjeto = $iClasseObjeto;
	}

	/**
	 * Metodo para retornar a propriedade classeobjeto
	 * @return integer classeobjeto
	 */
	public function getClasseObjeto(){
		return $this->classeobjeto;
	}

	/**
	 * Metodo para setar a propriedade atividadeobra
	 * @param integer atividadeobra
	 * @return void
	 */
	public function setAtividadeObra($iAtividadeObra){
		$this->atividadeobra = $iAtividadeObra;
	}

	/**
	 * Metodo para retornar a propriedade atividadeobra
	 * @return integer atividadeobra
	 */
	public function getAtividadeObra(){
		return $this->atividadeobra;
	}

	/**
	 * Metodo para setar a propriedade atividadeservico
	 * @param integer atividadeservico
	 * @return void
	 */
	public function setAtividadeServico($iAtividadeServico)	{
		$this->atividadeservico = $iAtividadeServico;
	}

	/**
	 * Metodo para retornar a propriedade atividadeservico
	 * @return integer atividadeservico
	 */
	public function getAtividadeServico(){
		return $this->atividadeservico;
	}

	/**
	 * Metodo para setar a descrição atividadeservico
	 * @param string atividadeservico
	 * @return void
	 */
	public function setDescrAtividadeServico($sAtividadeServico){
		$this->descratividadeservico = $sAtividadeServico;
	}

	/**
	 * Metodo para retornar a descrição atividadeservico
	 * @return string satividadeservico
	 */
	public function getDescrAtividadeServico(){
		return $this->descratividadeservico;
	}

	/**
	 * Metodo para setar a propriedade atividadeservicoesp
	 * @param integer atividadeservicoesp
	 * @return void
	 */

	public function setAtividadeServicoEsp($iAtividadeServicoEsp){
		$this->atividadeservicoesp = $iAtividadeServicoEsp;
	}

	/**
	 * Metodo para retornar a propriedade atividadeservicoesp
	 * @return integer atividadeservicoesp
	 */
	public function getAtividadeServicoEsp(){
		return $this->atividadeservicoesp;
	}

	/**
	 * Metodo para setar a descrição atividadeservicoesp
	 * @param string atividadeservicoesp
	 * @return void
	 */
	public function setDescrAtividadeServicoEsp($sAtividadeServicoEsp){
		$this->descratividadeservicoesp = $sAtividadeServicoEsp;
	}

	/**
	 * Metodo para retornar a descrição atividadeservicoesp
	 * @return string satividadeservicoesp
	 */
	public function getDescrAtividadeServicoEsp(){
		return $this->descratividadeservicoesp;
	}

	/**
	 * Metodo para setar a propriedade grupobempublico
	 * @param integer grupobempublico
	 * @return void
	 */
	public function setGrupoBemPublico($iGrupoBemPublico){
		$this->grupobempublico = $iGrupoBemPublico;
	}

	/**
	 * Metodo para retornar a propriedade grupobempublico
	 * @return integer grupobempublico
	 */
	public function getGrupoBemPublico(){
		return $this->grupobempublico;
	}

	/**
	 * Metodo para setar a propriedade subgrupobempublico
	 * @param integer subgrupobempublico
	 * @return void
	 */
	public function setSubGrupoBemPublico($iSubGrupoBemPublico){
		$this->subgrupobempublico = $iSubGrupoBemPublico;
	}

	/**
	 * Metodo para retornar a propriedade subgrupobempublico
	 * @return integer subgrupobempublico
	 */
	public function getSubGrupoBemPublico()	{
		return $this->subgrupobempublico;
	}

	/**
	 * Metodo para setar a propriedade bdi
	 * @param float bdi
	 * @return void
	 */
	public function setBdi($ibdi){
		$this->bdi = $ibdi;
	}

	/**
	 * Metodo para retornar a propriedade bdi
	 * @return float bdi
	 */
	public function getBdi(){
		return $this->bdi;
	}

	/**
	 * Metodo para setar a propriedade cep do enderco
	 * @param string cep
	 * @return void
	 */
	public function setCep($sCep){
		$this->cep = $sCep;
	}

	/**
	 * Metodo para retornar a propriedade cep do enderco
	 * @return string cep
	 */
	public function getCep(){
		return $this->cep;
	}

	/**
	 * Metodo para setar a propriedade Estado
	 * @param integer estado
	 * @return void
	 */
	public function setEstado($iEstado){
		$this->estado = $iEstado;
	}

	/**
	 * Metodo para retornar a propriedade estado
	 * @return integer estado
	 */
	public function getEstado()	{
		return $this->estado;
	}

	/**
	 * Metodo para setar a propriedade País
	 * @param integer pais
	 * @return void
	 */
	public function setPais($iPais)	{
		$this->pais = $iPais;
	}

	/**
	 * Metodo para retornar a propriedade País
	 * @return integer pais
	 */
	public function getPais(){
		return $this->pais;
	}

	/**
	 * Metodo para setar a propriedade Municipio
	 * @param integer municipio
	 * @return void
	 */
	public function setMunicipio($iMunicipio){
		$this->municipio = $iMunicipio;
	}

	/**
	 * Metodo para retornar a propriedade Municipio
	 * @return integer municipio
	 */
	public function getMunicipio(){
		return $this->municipio;
	}

	/**
	 * Metodo para setar a propriedade Bairro
	 * @param string bairro
	 * @return void
	 */
	public function setBairro($sBairro){
		$this->bairro = $sBairro;
	}

	/**
	 * Metodo para retornar a propriedade bairro
	 * @return string bairro
	 */
	public function getBairro()	{
		return $this->bairro;
	}

	/**
	 * Metodo para setar a propriedade Numero
	 * @param integer numero
	 * @return void
	 */
	public function setNumero($iNumero)	{
		$this->numero = $iNumero;
	}

	/**
	 * Metodo para retornar a propriedade Numero
	 * @return integer numero
	 */
	public function getNumero(){
		return $this->numero;
	}

	/**
	 * Metodo para setar a propriedade Numero da Licitação
	 * @param integer numero
	 * @return void
	 */
	public function setLicita($iLicita){
		$this->liclicita = $iLicita;
	}

	/**
	 * Metodo para retornar a propriedade Numero da Licitação
	 * @return integer numero
	 */
	public function getLicita(){
		return $this->liclicita;
	}
	/**
	 * Metodo para setar a propriedade Sequencial da Obra
	 * @param integer numero
	 * @return void
	 */
	public function setSequencial($iSequencial){
		$this->sequencial = $iSequencial;
	}

	/**
	 * Metodo para retornar a propriedade Sequencial da Obra
	 * @return integer numero
	 */
	public function getSequencial(){
		return $this->sequencial;
	}

	/**
	 * Método para setar a string com o numero dos lote
	 * @param string
	 * @return void
	 */
	public function setLote($sLote){
		$this->lote = $sLote;
	}

	/**
	 * Método para retornar a string do lote
	 * @return string
	 */

	 public function getLote(){
		 return $this->lote;
	 }
	
	/**
	 * Método para setar true ou false para saber se os dados vão ser cadastrados na tabela obrasdadoscomplementareslote
	 * @param boolean
	 * @return void
	 */
	public function setFlagLote($lLote){
		$this->lLote = $lLote;
	}

	/**
	 * Método para retornar o boolean do lote
	 * @return boolean
	 */

	 public function getFlagLote(){
		 return $this->lLote;
	 }

	/**
	 * Método para salvar um endereço da obra
	 * caso ele não esteja cadastrado
	 */
	public function salvaDadosComplementares($incluir){

		if (!db_utils::inTransaction()) {
			throw new Exception('Processamento Cancelado não existe transação ativa.');
		}

		$tabela_base = !$this->getFlagLote() ? 'obrasdadoscomplementares' : 'obrasdadoscomplementareslote';
		$oDaoObras = db_utils::getDao($tabela_base);
		$oDaoObrasCodigo = db_utils::getDao('obrascodigos');

		$sSqlCodigo = $oDaoObrasCodigo->sql_query($this->getCodigoObra(), 'db151_codigoobra, db151_liclicita','','db151_liclicita = '.$this->getLicita());
		$rsCodigo = $oDaoObrasCodigo->sql_record($sSqlCodigo);

		if($incluir){

			if(!$oDaoObrasCodigo->numrows){

				$oDaoObrasCodigo->db151_codigoobra = $this->getCodigoObra();
				$oDaoObrasCodigo->db151_liclicita = $this->getLicita();
				$oDaoObrasCodigo->incluir();

				if($oDaoObrasCodigo->erro_status == '0'){
					throw new Exception($oDaoObrasCodigo->erro_msg);
				}

			}

			!$this->getFlagLote() ? $this->preencheObjetoItem($incluir) : $this->preencheObjetoLote($incluir);

		}else{

			$sSqlCodigo = $oDaoObrasCodigo->sql_query('', 'db151_liclicita', '', 'db151_codigoobra = '.$this->getCodigoObra());
			$rsCodigo = $oDaoObrasCodigo->sql_record($sSqlCodigo);
			$iLicitacao = db_utils::fieldsMemory($rsCodigo, 0)->db151_liclicita;

			if(pg_num_rows($rsCodigo) && $iLicitacao != $this->getLicita()){
				throw new Exception('Código da Obra já cadastrado.');
			}

			if(!pg_num_rows($rsCodigo)){
				$oDaoObrasCodigo->db151_codigoobra = $this->getCodigoObra();
				$oDaoObrasCodigo->db151_liclicita = $this->getLicita();
				$oDaoObrasCodigo->incluir();

				$updateRegisters = $oDaoObras->sql_query_completo('','db150_sequencial','','db151_liclicita = '.$this->getLicita());
				$rsRegisters = $oDaoObras->sql_record($updateRegisters);
				
				for($count=0;$count<pg_num_rows($rsRegisters);$count++) {
					$iSequencial = db_utils::fieldsMemory($rsRegisters, $count)->db150_sequencial;
					$oDaoObras->db150_codobra = $this->getCodigoObra();
					$oDaoObras->alterar($iSequencial);

					if($oDaoObras->erro_status == '0'){
						throw new Exception($oDaoObrasCodigo->erro_msg);
					}
				}

				$sSqlMinimo = $oDaoObrasCodigo->sql_query('', 'min(db151_sequencial) as minimo', '', 'db151_liclicita = '.$this->getLicita());
				$rsMinimo = $oDaoObrasCodigo->sql_record($sSqlMinimo);
				$iMinimo = db_utils::fieldsMemory($rsMinimo, 0)->minimo;

				$oDaoObrasCodigo->excluir('', 'db151_sequencial ='.$iMinimo);
				if($oDaoObrasCodigo->status == '0'){
					throw new Exception($oDaoObrasCodigo->erro_msg);
				}
			}

			if(!$this->getFlagLote()){
				$this->preencheObjetoItem($incluir);
			}else{
				$this->preencheObjetoLote($incluir);
			}
			
		}

		return $oRetorno;
	}

	/**
	 * @todo renomear todos os metodos para preencheObjetoItem
	 */
	public function preencheObjetoItem($inclusao){

		$sSqlNatureza = db_query('SELECT l20_naturezaobjeto as natureza from liclicita where l20_codigo = '.$this->getLicita());
		$iNatureza = db_utils::fieldsMemory($sSqlNatureza, 0)->natureza;

		$oDaoObras = db_utils::getDao('obrasdadoscomplementares');
		$oDaoObras->db150_codobra = $this->getCodigoObra();
		$oDaoObras->db150_pais = $this->getPais();
		$oDaoObras->db150_estado = $this->getEstado();
		$oDaoObras->db150_municipio = $this->getMunicipio();
		$oDaoObras->db150_distrito = $this->getDistrito();
		$oDaoObras->db150_bairro = $this->getBairro();
		$oDaoObras->db150_numero = $this->getNumero();
		$oDaoObras->db150_logradouro = $this->getLogradouro();
		$oDaoObras->db150_grauslatitude = $this->getGrausLatitude();
		$oDaoObras->db150_minutolatitude = $this->getMinutoLatitude();
		$oDaoObras->db150_segundolatitude = $this->getSegundoLatitude();
		$oDaoObras->db150_grauslongitude = $this->getGrausLongitude();
		$oDaoObras->db150_minutolongitude = $this->getMinutoLongitude();
		$oDaoObras->db150_segundolongitude = $this->getSegundoLongitude();
		$oDaoObras->db150_classeobjeto = $this->getClasseObjeto();
		$oDaoObras->db150_grupobempublico = $this->getGrupoBemPublico();
		$oDaoObras->db150_subgrupobempublico = $this->getSubGrupoBemPublico();
		$oDaoObras->db150_atividadeobra = $this->getAtividadeObra();
		$oDaoObras->db150_atividadeservico = $this->getAtividadeServico();
		$oDaoObras->db150_descratividadeservico = $this->getDescrAtividadeServico();
		$oDaoObras->db150_atividadeservicoesp = $this->getAtividadeServicoEsp();
		$oDaoObras->db150_descratividadeservicoesp = $this->getDescrAtividadeServicoEsp();

		if(!$this->getBdi() && $iNatureza == '1'){
			throw new Exception('Campo BDI não informado!');
		}

		$oDaoObras->db150_bdi = $this->getBdi();
		$oDaoObras->db150_cep = $this->getCep();

		if(!$inclusao){
			$oDaoObras->alterar($this->getSequencial());
		}else{
			$oDaoObras->incluir();
		}

		if($oDaoObras->erro_status == '0'){
			throw new Exception($oDaoObras->erro_msg);
		}
	}

	public function preencheObjetoLote($inclusao){
		
		$sSqlNatureza = db_query('SELECT l20_naturezaobjeto as natureza from liclicita where l20_codigo = '.$this->getLicita());
		$iNatureza = db_utils::fieldsMemory($sSqlNatureza, 0)->natureza;

		$aLotes = explode(',', $this->getLote());

		for($count = 0; $count < count($aLotes); $count++){

			$oDaoObras = db_utils::getDao('obrasdadoscomplementareslote');

			$oDaoObras->db150_codobra = $this->getCodigoObra();
			$oDaoObras->db150_pais = $this->getPais();
			$oDaoObras->db150_estado = $this->getEstado();
			$oDaoObras->db150_municipio = $this->getMunicipio();
			$oDaoObras->db150_distrito = $this->getDistrito();
			$oDaoObras->db150_bairro = $this->getBairro();
			$oDaoObras->db150_numero = $this->getNumero();
			$oDaoObras->db150_logradouro = $this->getLogradouro();
			$oDaoObras->db150_latitude = $this->getLatitude();
			$oDaoObras->db150_longitude = $this->getLongitude();
			$oDaoObras->db150_lote = $aLotes[$count];
			$oDaoObras->db150_classeobjeto = $this->getClasseObjeto();
			$oDaoObras->db150_grupobempublico = $this->getGrupoBemPublico();
			$oDaoObras->db150_subgrupobempublico = $this->getSubGrupoBemPublico();
			$oDaoObras->db150_atividadeobra = $this->getAtividadeObra();
			$oDaoObras->db150_atividadeservico = $this->getAtividadeServico();
			$oDaoObras->db150_descratividadeservico = $this->getDescrAtividadeServico();
			$oDaoObras->db150_atividadeservicoesp = $this->getAtividadeServicoEsp();
			$oDaoObras->db150_descratividadeservicoesp = $this->getDescrAtividadeServicoEsp();

			if(!$this->getBdi() && $iNatureza == '1'){
				throw new Exception('Campo BDI não informado!');
			}

			$oDaoObras->db150_bdi = $this->getBdi();
			$oDaoObras->db150_cep = $this->getCep();
			
			if(!$inclusao){
				$sWhere = '';
				if($aLotes[$count]){
				    $sWhere = ' db150_lote = ' . $aLotes[$count];
				}else{
					$sWhere = ' db150_codobra = ' . $this->getCodigoObra();
				}
				$oDaoObras->alterar('', $sWhere);
			}else{
				$oDaoObras->incluir();
			}

			if($oDaoObras->erro_status == '0'){
				throw new Exception($oDaoObras->erro_msg);
			}

		}

		
	}

	/**
	 * Retorna mais de um item se a licitação tiver o tipo de julgamento por lote,
	 * caso contrário retorna apenas um item
	 * @return array
	 */
	static function findObraByCodigo($iSequencial, $iLicitacao, $lEncode = true)
	{
		$aRetorno = false;

		$tabela_base = self::checkTable($iLicitacao);

		$sCampos = "distinct $tabela_base.*, db72_descricao as descrMunicipio";
		$sCampos .= $tabela_base === 'obrasdadoscomplementareslote' ? ',l04_descricao' : '';

		$oDaoObra = db_utils::getDao($tabela_base);

		if (trim($iSequencial) != "") {
			$sWhere = " db150_sequencial = " . $iSequencial;
		}else{
			$sWhere = " db150_codobra = (select max(db150_codobra) from $tabela_base join obrascodigos on db151_codigoobra = db150_codobra where db151_liclicita =".$iLicitacao.")";
		}

		$sSqlObra = $oDaoObra->sql_query_completo(null, $sCampos, 'db150_sequencial', $sWhere);
		
		$rsQueryObra = $oDaoObra->sql_record($sSqlObra);

		if($tabela_base === 'obrasdadoscomplementareslote'){
			$aRetorno = self::retorno($rsQueryObra);
		}else{

			if ($rsQueryObra !== false) {
				$aRetorno = db_utils::getCollectionByRecord($rsQueryObra, false, false, $lEncode);
			}

		}

		return $aRetorno;

	}

	/**
	 * Método que retorna as obras cadastradas. E se tiver mais de um item para o mesmo lote,
	 * os códigos dos lotes são concatenados na propriedade db150_lote
	 * @return array
	 */
	static function retorno($rs){

		if(pg_numrows($rs)){

			$aObras = array();

			$aPesquisa = db_utils::getCollectionByRecord($rs, false, false, true);
			
			for($count = 0; $count < count($aPesquisa); $count++){

				$indice = $aPesquisa[$count]->l04_descricao;
				
				if(!$aObras[$indice]){
					$aObras[$indice] = $aPesquisa[$count];
				}else{
					$aObras[$indice]->db150_lote .= ', ' . $aPesquisa[$count]->db150_lote;
				}
			
			}

			$aAuxiliar = array();

			foreach ($aObras as $key => $obra) {
				$aAuxiliar[] = $aObras[$key];
			}

		}

		return $aAuxiliar;

	}

	static function findObrasByLicitacao($iCodigoLicitacao, $lEncode = true)
	{

		$aRetorno = false;
		$tabela_base = '';

		if (trim($iCodigoLicitacao) != "") {

			$tabela_base = self::checkTable($iCodigoLicitacao);
			
			$oDaoObra = db_utils::getDao($tabela_base);
			$sCampos  = 'distinct db72_descricao as descrMunicipio, ';
			$sCampos .= "$tabela_base.*";
			$sCampos .= $tabela_base === 'obrasdadoscomplementareslote' ? ',l04_descricao, l04_codigo' : '';
			
			$sWhere = " db151_liclicita = " . $iCodigoLicitacao;

			$sSqlObra = $oDaoObra->sql_query_completo(null, $sCampos, 'db150_sequencial', $sWhere);
			$rsQueryObra = $oDaoObra->sql_record($sSqlObra);
			
			if($tabela_base === 'obrasdadoscomplementareslote'){
				$aRetorno = self::retorno($rsQueryObra);
			}else{
				if ($rsQueryObra !== false) {
					$aRetorno = db_utils::getCollectionByRecord($rsQueryObra, false, false, $lEncode);
				}
			}

		}

		return $aRetorno;

	}

	/**
	 * Checa se o endereço cadastrado é o último existente da obra.
	 * Caso encontre lote para os itens da licitação e o tipo do julgamento for lote retornará false
	 * @return boolean
	 */
	static function isManyRegisters($iSequencial, $iLicitacao){

		$table_base = self::checkTable($iLicitacao);
		$oDaoObra = db_utils::getDao($table_base);
		$sCampos = " min(db150_sequencial) as seq_minimo, count(db150_sequencial) as registersCount";
		$sSql = $oDaoObra->sql_query_completo('', $sCampos, 'db150_codobra', 'db151_liclicita = '.$iLicitacao.' group by db150_codobra');

		$rsSql = $oDaoObra->sql_record($sSql);
		$oObras = db_utils::fieldsMemory($rsSql, 0);
		
		if($table_base == 'obrasdadoscomplementares'){
			if($oObras->seq_minimo == $iSequencial && intval($oObras->registerscount) > 1){
				return true;
			}
		}else{
			$sCampos = " DISTINCT liclicitemlote.l04_descricao ";
			$sSql = $oDaoObra->sql_query_completo('', $sCampos, '', 'db151_liclicita = '.$iLicitacao);
			$rsSql = $oDaoObra->sql_record($sSql);

			if($oObras->seq_minimo == $iSequencial && pg_numrows($rsSql) > 1){
				return true;
			}
			
		}

		return false;
	}

	/**
	 * Checa se o tipo de julgamento da licitação foi por item ou por lote.
	 * Caso for item retorna a tabela obrasdadoscomplementareslote,
	 * senão retorna a obrasdadoscomplementares
	 * @return string
	 */

	static function checkTable($iLicitacao){

		$sSql = " SELECT distinct l20_anousu, l20_tipojulg
					FROM liclicitemlote
					INNER JOIN liclicitem ON l04_liclicitem = l21_codigo
					INNER JOIN liclicita ON l20_codigo = l21_codliclicita
					WHERE l20_codigo = $iLicitacao ";

		$rsSql = db_query($sSql);
		$oLicitacao = db_utils::fieldsMemory($rsSql, 0);

		$table_base = $oLicitacao->l20_anousu >= 2021 ? 'obrasdadoscomplementareslote' : 'obrasdadoscomplementares';
		return $table_base; 

	}

}


?>
