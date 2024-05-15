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

  define("ARQUIVO_MENSAGEM_CGS", "saude.ambulatorial.Cgs.");

/**
 * Classe para controle geral dos pacientes da
 * area DB:Saude
 * @package Ambulatorial
 * @version $Revision: 1.11 $
 */
class Cgs {
  
  /**
   * Codigo do cgs
   * @var integer
   */  
  protected $iCodigo;
  
  /**
   * Nome do CGS
   * @var string
   */
  protected $sNome;

  /**
   * Sexo do paciente
   * @var string
   */
  protected $sSexo;

  /**
   * Data de Nascimento
   * @var DBDate
   */
  protected $oDataNascimento;

  /**
   * Nome da Mãe do paciente
   * @var string
   */
  protected $sNomeMae;

  /**
   * Endereço do paciente
   * @var string
   */
  protected $sEndereco;

  /**
   * Número do endereço do paciente
   * @var integer
   */
  protected $iNumero;

  /**
   * Complemento do endereço do paciente
   * @var string
   */
  protected $sComplemento;

  /**
   * Bairro do paciente
   * @var string
   */
  protected $sBairro;

  /**
   * CEP do paciente
   * @var string
   */
  protected $sCep;

  /**
   * Município do paciente
   * @var string
   */
  protected $sMunicipio;

  /**
   * UF do paciente
   * @var string
   */
  protected $sUF;

  /**
   * Código referente ao estado civil do paciente
   * @var integer
   */
  protected $iEstadoCivil;

  /**
   * Estados civis indexados pelo seu código
   * @var array
   */
  protected $aEstadosCivis = array( 1 => "SOLTEIRO",
                                    2 => "CASADO",
                                    3 => "VIÚVO",
                                    4 => "SEPARADO",
                                    5 => "UNIÃO C.",
                                    9 => "IGNORADO"
                                  );

  /**
   * Identidade do paciente
   * @var string
   */
  protected $sIdentidade = '';

  /**
   * CPF do paciente
   * @var string
   */
  protected $sCpf = '';

  /**
   * Número de Telefone do paciente
   * @var string
   */
  protected $sTelefone;

  /**
   * Número de Celular do paciente
   * @var string
   */
  protected $sCelular;

  /**
   * Instancia um novo CGs
   */
  function __construct($iCgs = null) {

    if (!empty($iCgs)) {
      
      $oDaoCgs      = db_utils::getDao("cgs_und");
      $sSqlDadosCGS = $oDaoCgs->sql_query_file($iCgs);
      $rsDadosCGS   = $oDaoCgs->sql_record($sSqlDadosCGS);

      if ($oDaoCgs->numrows > 0) {

        $oDadosCGS = db_utils::fieldsMemory($rsDadosCGS, 0);
        $this->setCodigo($iCgs);
        $this->setNome($oDadosCGS->z01_v_nome);
        $this->setSexo($oDadosCGS->z01_v_sexo);

        if (!empty($oDadosCGS->z01_d_nasc)) {
          $this->setDataNascimento(new DBDate($oDadosCGS->z01_d_nasc));
        }

        $this->setNomeMae($oDadosCGS->z01_v_mae);
        $this->setEndereco($oDadosCGS->z01_v_ender);
        $this->setNumero($oDadosCGS->z01_i_numero);
        $this->setComplemento($oDadosCGS->z01_v_compl);
        $this->setBairro($oDadosCGS->z01_v_bairro);
        $this->setCep($oDadosCGS->z01_v_cep);
        $this->setMunicipio($oDadosCGS->z01_v_munic);
        $this->setUF($oDadosCGS->z01_v_uf);
        $this->setEstadoCivil($oDadosCGS->z01_i_estciv);
        $this->setIdentidade( $oDadosCGS->z01_v_ident);
        $this->setCpf( $oDadosCGS->z01_v_cgccpf );
        $this->setTelefone( $oDadosCGS->z01_v_telef );
        $this->setCelular( $oDadosCGS->z01_v_telcel );

      }
    }  
  }
  /**
   * Retorna o codigo de cadastro do paciente
   * @return integer
   */
  public function getCodigo() {
    return $this->iCodigo;
  }
  
  /**
   * Código do paciente
   * @param integer $iCodigo
   */
  protected function setCodigo($iCodigo) {
    $this->iCodigo = $iCodigo;
  }
  
  /**
   * Retorna o nome do paciente
   * @return string
   */
  public function getNome() {
    return $this->sNome;
  }
  
  
  /**
   * seta o nome do paciente
   * @param string $sNome define o nome do paciente
   */
  public function setNome($sNome) {
    $this->sNome = $sNome;
  }

  /**
   * Retorna o sexo do paciente
   * @return string
   */
  public function getSexo() {
    return $this->sSexo;
  }

  /**
   * Define o sexo do paciente
   * @param $sSexo sexo do paciente
   */
  public function setSexo($sSexo) {
    $this->sSexo = $sSexo;
  }

  /**
   * Define a Data de nascimento
   * @param DBDate $oDataNascimento
   */
  public function setDataNascimento( DBDate $oDataNascimento) {
    $this->oDataNascimento = $oDataNascimento;
  }

  /**
   * Retorna a data de nascimento do paciente
   * @return DBDate
   */
  public function getDataNascimento() {
    return $this->oDataNascimento;
  }

  /**
   * Retorna todos os cartões sus do CGS
   * @return array
   * @throws DBException
   */
  public function getCartaoSus() {

    $sWhereCartaoSus   = "     s115_i_cgs = {$this->iCodigo}";
    $oDaoCgsCartaoSus  = new cl_cgs_cartaosus();
    $sSqlCartaoSus     = $oDaoCgsCartaoSus->sql_query_file(null, "s115_c_cartaosus, s115_c_tipo", null, $sWhereCartaoSus);
    $rsCartaoSus       = db_query( $sSqlCartaoSus );

    if ( !$rsCartaoSus ) {

      $oErro        = new stdClass();
      $oErro->sErro = $oDaoCgsCartaoSus->erro_msg;
      throw new DBException( _M(ARQUIVO_MENSAGEM_CGS . "erro_buscar_cns", $oErro) );
    }

    $iLinhasCartaoSus = pg_num_rows( $rsCartaoSus );
    $aCartaoSus       = array();

    if ( $iLinhasCartaoSus > 0 ) {

      for( $iContador = 0; $iContador < $iLinhasCartaoSus; $iContador++ ) {

        $oDadosCartaoSus = db_utils::fieldsMemory( $rsCartaoSus, $iContador );

        $oCartaoSus                 = new stdClass();
        $oCartaoSus->sCartaoSus     = $oDadosCartaoSus->s115_c_cartaosus;
        $oCartaoSus->sTipoCartaoSus = $oDadosCartaoSus->s115_c_tipo;

        $aCartaoSus[] = $oCartaoSus;
      }
    }

    return $aCartaoSus;
  }

  /**
   * Retorna o cartão SUS Definitivo, ou o último Provisório do CGS
   * @return string
   */
  public function getCartaoSusAtivo() {

    $sCartaoSus = '';

    foreach( $this->getCartaoSus() as $oCartaoSus ) {

      $sCartaoSus = $oCartaoSus->sCartaoSus;
      if( $oCartaoSus->sTipoCartaoSus == 'D' ) {
        break;
      }
    }

    return $sCartaoSus;
  }

  /**
   * Retorna o nome da mãe do paciente
   * @return string
   */
  public function getNomeMae() {
    return $this->sNomeMae;
  }

  /**
   * Define o nome da mãe do paciente
   * @param string $sNomeMae
   */
  public function setNomeMae( $sNomeMae ) {
    $this->sNomeMae = $sNomeMae;
  }

  /**
   * Define o enderço do paciente
   * @param string $sEndereco
   */
  public function setEndereco( $sEndereco ) {
    $this->sEndereco = $sEndereco;
  }

  /**
   * Retorna o endereço do paciente
   * @return string
   */
  public function getEndereco() {
    return $this->sEndereco;
  }

  /**
   * Define o número do endereço do paciente
   * @param integer $iNumero
   */
  public function setNumero( $iNumero ) {
    $this->iNumero = $iNumero;
  }

  /**
   * Retorna o número do endereço do paciente
   * @return integer
   */
  public function getNumero() {
    return $this->iNumero;
  }

  /**
   * Define o complemento do endereço do paciente
   * @param string $sComplemento
   */
  public function setComplemento( $sComplemento ) {
    $this->sComplemento = $sComplemento;
  }

  /**
   * Retorna o complemento do endereço do paciente
   * @return string
   */
  public function getComplemento() {
    return $this->sComplemento;
  }

  /**
   * Define o bairro do paciente
   * @param string $sBairro
   */
  public function setBairro( $sBairro ) {
    $this->sBairro = $sBairro;
  }

  /**
   * Retorna o bairro do paciente
   * @return string
   */
  public function getBairro() {
    return $this->sBairro;
  }

  /**
   * Define o CEP do paciente
   * @param string $sCep
   */
  public function setCep( $sCep ) {
    $this->sCep = $sCep;
  }

  /**
   * Retorna o CEP do paciente
   * @return string
   */
  public function getCep() {
    return $this->sCep;
  }

  /**
   * Define o município do paciente
   * @param string $sMunicipio
   */
  public function setMunicipio( $sMunicipio ) {
    $this->sMunicipio = $sMunicipio;
  }

  /**
   * Retorna o município do paciente
   * @return string
   */
  public function getMunicipio() {
    return $this->sMunicipio;
  }

  /**
   * Define a UF do paciente
   * @param string $sUF
   */
  public function setUF( $sUF ) {
    $this->sUF = $sUF;
  }

  /**
   * Retorna a UF do paciente
   * @return string
   */
  public function getUF() {
    return $this->sUF;
  }

  /**
   * Retorna o estado cívil do paciente
   * @return string
   */
  public function getEstadoCivil() {
    return $this->aEstadosCivis[$this->iEstadoCivil];
  }

  /**
   * Define o estado civil do paciente
   * @param integer $iEstadoCivil
   */
  public function setEstadoCivil( $iEstadoCivil ) {
    $this->iEstadoCivil = $iEstadoCivil;
  }

  /**
   * Retorna o número de identidade do paciente
   * @return string
   */
  public function getIdentidade() {
    return $this->sIdentidade;
  }

  /**
   * Define o número de identidade do paciente
   * @param string $sIdentidade 
   */
  public function setIdentidade( $sIdentidade ) {
    $this->sIdentidade = $sIdentidade;
  }

  /**
   * Retorna o CPF do paciente
   * @return string
   */
  public function getCpf() {
    return $this->sCpf;
  }

  /**
   * Define o CPF do paciente
   * @param string $sCpf
   */
  public function setCpf( $sCpf ) {
    $this->sCpf = $sCpf;
  }

  /**
   * Retorna o telefone do paciente
   * @return string
   */
  public function getTelefone() {
    return $this->sTelefone;
  }

  /**
   * Define o telefone do paciente
   * @param string $sTelefone
   */
  public function setTelefone ( $sTelefone ) {
    $this->sTelefone = $sTelefone;
  }

  /**
   * Retorna o celular do paciente
   * @return string
   */
  public function getCelular() {
    return $this->sCelular;
  }

  /**
   * Define o celular do paciente
   * @param string $sCelular
   */
  public function setCelular ( $sCelular ) {
    $this->sCelular = $sCelular;
  }
}
