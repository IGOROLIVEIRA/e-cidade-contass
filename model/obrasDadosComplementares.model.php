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

  class obrasDadosComplementares {
    private $db150_codobra = null;
    private $db150_cep = null;
    private $db150_pais = null;
    private $db150_estado = null;
    private $db150_municipio = null;
    private $db150_distrito = '';
    private $db150_bairro = '';
    private $db150_numero = '';
    private $db150_logradouro = '';
    private $db150_grauslatitude = null;
    private $db150_minutolatitude = null;
    private $db150_segundolatitude = null;
    private $db150_grauslongitude = null;
    private $db150_minutolongitude = null;
    private $db150_segundolongitude = null;
    private $db150_classeobjeto = null;
    private $db150_atividadeobra = null;
    private $db150_atividadeservico = null;
    private $db150_descratividadeservico = null;
    private $db150_atividadeservicoesp = null;
    private $db150_descratividadeservicoesp = null;
    private $db150_grupobempublico = null;
    private $db150_subgrupobempublico = null;
    private $db150_bdi = null;


  /**
    *
    */
    function __construct($iCodigoObra=null) {

      if ($iCodigoObra != null) {
        $sWhere       = " db150_codobra = ".$iCodigoObra;

        $oDaoLocal    = db_utils::getDao('obrasdadoscomplementares');
        $sQueryLocal  = $oDaoLocal->sql_query(null, "*", null, $sWhere);
        $rsQueryLocal = $oDaoLocal->sql_record($sQueryLocal);

        if ($rsQueryLocal === false ){
          throw new Exception('Nenhum endereço da obra encontrado para o código informado('.$iCodigoObra.').');
        }

        $oDados = db_utils::fieldsMemory($rsQueryLocal,0);
//
        $this->setEstado($oDados->db150_estado);
        $this->setPais($oDados->db150_pais);
        $this->setMunicipio($oDados->db150_municipio);
        $this->setBairro($oDados->db150_bairro);
        $this->setNumero($oDados->db150_numero);
        $this->setCep($oDados->db150_cep);
        $this->setCodigoObra($oDados->db150_codobra);
        $this->setDistrito($oDados->db150_distrito);
        $this->setLogradouro($oDados->db150_logradouro);
        $this->setGrausLatitude($oDados->db150_grauslatitude);
        $this->setMinutoLatitude($oDados->db150_minutolatitude);
        $this->setSegundoLatitude($oDados->db150_segundolatitude);
        $this->setGrausLongitude($oDados->db150_grauslongitude);
        $this->setMinutoLongitude($oDados->db150_minutolongitude);
        $this->setSegundoLongitude($oDados->db150_segundolongitude);
        $this->setClasseObjeto($oDados->db150_classeobjeto);
        $this->setAtividadeObra($oDados->db150_atividadeObra);
        $this->setAtividadeServico($oDados->db150_atividadeservico);
        $this->setDescrAtividadeServico($oDados->db150_descrAtividadeServico);
        $this->setAtividadeServicoEsp($oDados->db150_atividadeservicoesp);
        $this->setDescrAtividadeServicoEsp($oDados->db150_descratividadeservicoesp);
        $this->setGrupoBemPublico($oDados->db150_grupobempublico);
        $this->setSubGrupoBemPublico($oDados->db150_subgrupobempublico);
        $this->setBdi($oDados->db150_bdi);
        $this->setLicita($oDados->db150_liclicita);
      }

  }

    /**
     * Metodo para setar a propriedade codigo obra
     * @param integer cep
     * @return void
     */
    public function setCodigoObra($iCodigoObra) {
      $this->db150_codobra = $iCodigoObra;
    }
    /**
     * Metodo para retornar a propriedade c?digo obra
     * @return integer codigoobra
     */
    public function getCodigoObra() {
      return $this->db150_codobra;
    }

    /**
     * Metodo para setar a propriedade descri??o do Distrito
     * @param string distrito
     * @return void
     */
    public function setDistrito($sDistrito) {
      $this->db150_distrito = $sDistrito;
    }
    /**
     * Metodo para retornar a propriedade descri??o do Distrito
     * @return string distrito
     */
    public function getDistrito() {
      return $this->db150_distrito;
    }

    /**
     * Metodo para setar a propriedade logradouro
     * @param string logradouro
     * @return void
     */
    public function setLogradouro($sLogradouro) {
      $this->db150_logradouro = $sLogradouro;
    }
    /**
     * Metodo para retornar a propriedade Logradouro
     * @return string logradouro
     */
    public function getLogradouro() {
      return $this->db150_logradouro;
    }

    /**
     * Metodo para setar a propriedade Graus Latitude
     * @param integer grauslatitude
     * @return void
     */
    public function setGrausLatitude($iGrausLatitude) {
      $this->db150_grauslatitude = $iGrausLatitude;
    }
    /**
     * Metodo para retornar a propriedade grauslatitude
     * @return integer grauslatitude
     */
    public function getGrausLatitude() {
      return $this->db150_grauslatitude;
    }

    /**
     * Metodo para setar a propriedade minutolatitude
     * @param integer minutolatitude
     * @return void
     */
    public function setMinutoLatitude($iMinutoLatitude) {
      $this->db150_minutolatitude = $iMinutoLatitude;
    }
    /**
     * Metodo para retornar a propriedade minutolatitude
     * @return integer minutolatitude
     */
    public function getMinutoLatitude() {
      return $this->db150_minutolatitude;
    }

    /**
     * Metodo para setar a propriedade segundolatitude
     * @param float segundolatitude
     * @return void
     */
    public function setSegundoLatitude($iSegundoLatitude) {
      $this->db150_segundolatitude = $iSegundoLatitude;
    }
    /**
     * Metodo para retornar a propriedade segundolatitude
     * @return float segundolatitude
     */
    public function getSegundoLatitude() {
      return $this->db150_segundolatitude;
    }

    /**
     * Metodo para setar a propriedade Graus Longitude
     * @param integer grauslongitude
     * @return void
     */
    public function setGrausLongitude($iGrausLongitude) {
      $this->db150_grauslongitude = $iGrausLongitude;
    }
    /**
     * Metodo para retornar a propriedade grauslongitude
     * @return integer grauslongitude
     */
    public function getGrausLongitude() {
      return $this->db150_grauslongitude;
    }

    /**
     * Metodo para setar a propriedade minutolongitude
     * @param integer minutolongitude
     * @return void
     */
    public function setMinutoLongitude($iMinutoLongitude) {
      $this->db150_minutolongitude = $iMinutoLongitude;
    }
    /**
     * Metodo para retornar a propriedade minutolongitude
     * @return integer minutolongitude
     */
    public function getMinutoLongitude() {
      return $this->db150_minutolongitude;
    }

    /**
     * Metodo para setar a propriedade segundolongitude
     * @param float segundolongitude
     * @return void
     */
    public function setSegundoLongitude($iSegundoLongitude) {
      $this->db150_segundolongitude = $iSegundoLongitude;
    }
    /**
     * Metodo para retornar a propriedade segundolongitude
     * @return float segundolongitude
     */
    public function getSegundoLongitude() {
      return $this->db150_segundolongitude;
    }

    /**
     * Metodo para setar a propriedade classeobjeto
     * @param integer classeobjeto
     * @return void
     */
    public function setClasseObjeto($iClasseObjeto) {
      $this->db150_classeobjeto = $iClasseObjeto;
    }
    /**
     * Metodo para retornar a propriedade classeobjeto
     * @return integer classeobjeto
     */
    public function getClasseObjeto() {
      return $this->db150_classeobjeto;
    }

    /**
     * Metodo para setar a propriedade atividadeobra
     * @param integer atividadeobra
     * @return void
     */
    public function setAtividadeObra($iAtividadeObra) {
      $this->db150_atividadeobra = $iAtividadeObra;
    }
    /**
     * Metodo para retornar a propriedade atividadeobra
     * @return integer atividadeobra
     */
    public function getAtividadeObra() {
      return $this->db150_atividadeobra;
    }

    /**
     * Metodo para setar a propriedade atividadeservico
     * @param integer atividadeservico
     * @return void
     */
    public function setAtividadeServico($iAtividadeServico) {
      $this->db150_atividadeservico = $iAtividadeServico;
    }
    /**
     * Metodo para retornar a propriedade atividadeservico
     * @return integer atividadeservico
     */
    public function getAtividadeServico() {
      return $this->db150_atividadeservico;
    }
    /**
     * Metodo para setar a descrição atividadeservico
     * @param string atividadeservico
     * @return void
     */
    public function setDescrAtividadeServico($sAtividadeServico) {
      $this->db150_descratividadeservico = $sAtividadeServico;
    }
    /**
     * Metodo para retornar a descrição atividadeservico
     * @return string satividadeservico
     */
    public function getDescrAtividadeServico() {
      return $this->db150_descratividadeservico;
    }
    /**
     * Metodo para setar a propriedade atividadeservicoesp
     * @param integer atividadeservicoesp
     * @return void
     */

    public function setAtividadeServicoEsp($iAtividadeServicoEsp) {
      $this->db150_atividadeservicoesp = $iAtividadeServicoEsp;
    }
    /**
     * Metodo para retornar a propriedade atividadeservicoesp
     * @return integer atividadeservicoesp
     */
    public function getAtividadeServicoEsp() {
      return $this->db150_atividadeservicoesp;
    }
    /**
     * Metodo para setar a descrição atividadeservicoesp
     * @param string atividadeservicoesp
     * @return void
     */
    public function setDescrAtividadeServicoEsp($sAtividadeServicoEsp) {
      $this->db150_descratividadeservicoesp = $sAtividadeServicoEsp;
    }
    /**
     * Metodo para retornar a descrição atividadeservicoesp
     * @return string satividadeservicoesp
     */
    public function getDescrAtividadeServicoEsp() {
      return $this->db150_descratividadeservicoesp;
    }

    /**
     * Metodo para setar a propriedade grupobempublico
     * @param integer grupobempublico
     * @return void
     */
    public function setGrupoBemPublico($iGrupoBemPublico) {
      $this->db150_grupobempublico = $iGrupoBemPublico;
    }
    /**
     * Metodo para retornar a propriedade grupobempublico
     * @return integer grupobempublico
     */
    public function getGrupoBemPublico() {
      return $this->db150_grupobempublico;
    }

    /**
     * Metodo para setar a propriedade subgrupobempublico
     * @param integer subgrupobempublico
     * @return void
     */
    public function setSubGrupoBemPublico($iSubGrupoBemPublico) {
      $this->db150_subgrupobempublico = $iSubGrupoBemPublico;
    }
    /**
     * Metodo para retornar a propriedade subgrupobempublico
     * @return integer subgrupobempublico
     */
    public function getSubGrupoBemPublico() {
      return $this->db150_subgrupobempublico;
    }

    /**
     * Metodo para setar a propriedade bdi
     * @param float bdi
     * @return void
     */
    public function setBdi($ibdi) {
      $this->db150_bdi = $ibdi;
    }
    /**
     * Metodo para retornar a propriedade bdi
     * @return float bdi
     */
    public function getBdi() {
      return $this->db150_bdi;
    }

    /**
     * Metodo para setar a propriedade cep do enderco
     * @param string cep
     * @return void
     */
    public function setCep($sCep) {

      $this->db150_cep = $sCep;
    }
    /**
     * Metodo para retornar a propriedade cep do enderco
     * @return string cep
     */
    public function getCep() {

      return $this->db150_cep;
    }

    /**
     * Metodo para setar a propriedade Estado
     * @param integer estado
     * @return void
     */
    public function setEstado($iEstado) {

      $this->db150_estado = $iEstado;
    }
    /**
     * Metodo para retornar a propriedade estado
     * @return integer estado
     */
    public function getEstado() {

      return $this->db150_estado;
    }

    /**
     * Metodo para setar a propriedade País
     * @param integer pais
     * @return void
     */
    public function setPais($iPais) {

      $this->db150_pais = $iPais;
    }
    /**
     * Metodo para retornar a propriedade País
     * @return integer pais
     */
    public function getPais() {

      return $this->db150_pais;
    }

    /**
     * Metodo para setar a propriedade Municipio
     * @param integer municipio
     * @return void
     */
    public function setMunicipio($iMunicipio) {
      $this->db150_municipio = $iMunicipio;
    }
    /**
     * Metodo para retornar a propriedade Municipio
     * @return integer municipio
     */
    public function getMunicipio() {
      return $this->db150_municipio;
    }

    /**
     * Metodo para setar a propriedade Bairro
     * @param string bairro
     * @return void
     */
    public function setBairro($sBairro) {
      $this->db150_bairro = $sBairro;
    }
    /**
     * Metodo para retornar a propriedade bairro
     * @return string bairro
     */
    public function getBairro() {
      return $this->db150_bairro;
    }

    /**
     * Metodo para setar a propriedade Numero
     * @param integer numero
     * @return void
     */
    public function setNumero($iNumero) {

      $this->db150_numero = $iNumero;
    }
    /**
     * Metodo para retornar a propriedade Numero
     * @return integer numero
     */
    public function getNumero() {

      return $this->db150_numero;
    }

    /**
     * Metodo para setar a propriedade Numero da Licitação
     * @param integer numero
     * @return void
     */
    public function setLicita($iLicita) {

      $this->db150_liclicita = $iLicita;
    }
    /**
     * Metodo para retornar a propriedade Numero da Licitação
     * @return integer numero
     */
    public function getLicita() {

      return $this->db150_liclicita;
    }
   /**
   * Método para salvar um endereço da obra
   * caso ele não esteja cadastrado
   */
  public function salvaDadosComplementares($incluir) {

    if (!db_utils::inTransaction()) {
      throw new Exception('Processamento Cancelado não existe transação ativa.');
    }
    $oDaoObras = db_utils::getDao('obrasdadoscomplementares');
    $sSqlQuery = $oDaoObras->sql_query('', '*', null, 'db150_codobra ='.$this->getCodigoObra());
    $rsQuery   = $oDaoObras->sql_record($sSqlQuery);

    if($oDaoObras->numrows && $incluir){
      throw new Exception('Código da Obra já cadastrado.');
    }

    $oDados = db_utils::fieldsMemory($rsQuery, 0);

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
    $oDaoObras->db150_bdi = $this->getBdi();
    $oDaoObras->db150_liclicita = $this->getLicita();
    $oDaoObras->db150_cep = $this->getCep();

    if(!$oDaoObras->numrows){

      $oDaoObras->incluir(null);
      if ($oDaoObras->erro_status == '0') {
        throw new Exception($oDaoObras->erro_sql);
      } else {
        $this->setCodigoObra($oDaoObras->db150_codobra);
      }
    }else{
      $oDaoObras->alterar($oDados->db150_sequencial);
      if ($oDaoObras->erro_status == '0') {
        throw new Exception($oDaoObras->erro_sql);
      }
    }

  }

    static function findObraByCodigo($iCodigoObra, $lEncode=true) {
      $aRetorno = false;

      if (trim($iCodigoObra) != "") {

        $oDaoObra  = db_utils::getDao('obrasdadoscomplementares');
        $sCampos   = " distinct db150_codobra as codigoobra, db150_pais as pais, db150_estado as estado, db150_municipio as municipio, db72_descricao as descrMunicipio, db150_distrito as distrito, ";
        $sCampos  .= " db150_bairro as bairro, db150_numero as numero, db150_logradouro as logradouro, db150_grauslatitude as grauslatitude, db150_minutolatitude as minutolatitude,";
        $sCampos  .= " db150_segundolatitude as segundolatitude, db150_grauslongitude as grauslongitude, db150_minutolongitude as minutolongitude, db150_segundolongitude as segundolongitude,";
        $sCampos  .= " db150_classeobjeto as classeobjeto, db150_grupobempublico as grupobempublico, db150_subgrupobempublico as subgrupobempublico, db150_atividadeobra as atividadeobra,";
        $sCampos  .= " db150_atividadeservico as atividadeservico, db150_atividadeservicoesp as atividadeservicoesp, db150_bdi as bdi, db150_descratividadeservico as descratividadeservico, 
        db150_descratividadeservicoesp as descratividadeservicoesp, db150_cep as cep";

        $sWhere   = " db150_codobra = ".$iCodigoObra;

        $sQueryObra  = $oDaoObra->sql_query_completo(null,$sCampos,null,$sWhere);
        $rsQueryObra = $oDaoObra->sql_record($sQueryObra);

        if( $rsQueryObra !== false) {
          $aRetorno = db_utils::getCollectionByRecord($rsQueryObra, false, false, $lEncode);
        }
      }
      return $aRetorno;
    }

    static function findObrasByLicitacao($iCodigoLicitacao, $lEncode=true) {
      $aRetorno = false;

      if (trim($iCodigoLicitacao) != "") {

        $oDaoObra  = db_utils::getDao('obrasdadoscomplementares');
        $sCampos   = " distinct db150_codobra as codigoobra, db150_pais as pais, db150_estado as estado, db150_municipio as municipio, db72_descricao as descrMunicipio, db150_distrito as distrito, ";
        $sCampos  .= " db150_bairro as bairro, db150_numero as numero, db150_logradouro as logradouro, db150_grauslatitude as grauslatitude, db150_minutolatitude as minutolatitude,";
        $sCampos  .= " db150_segundolatitude as segundolatitude, db150_grauslongitude as grauslongitude, db150_minutolongitude as minutolongitude, db150_segundolongitude as segundolongitude,";
        $sCampos  .= " db150_classeobjeto as classeobjeto, db150_grupobempublico as grupobempublico, db150_subgrupobempublico as subgrupobempublico, db150_atividadeobra as atividadeobra,";
        $sCampos  .= " db150_atividadeservico as atividadeservico, db150_atividadeservicoesp as atividadeservicoesp, db150_bdi as bdi, db150_descratividadeservico as descratividadeservico, db150_descratividadeservicoesp as descratividadeservicoesp, db150_cep as cep";

        $sWhere   = " db150_liclicita = ".$iCodigoLicitacao;

        $sQueryObra  = $oDaoObra->sql_query_completo(null,$sCampos,'db150_codobra',$sWhere);
        $rsQueryObra = $oDaoObra->sql_record($sQueryObra);

        if( $rsQueryObra !== false) {
          $aRetorno = db_utils::getCollectionByRecord($rsQueryObra, false, false, $lEncode);
        }
      }
      return $aRetorno;
    }
}


?>
