<?php

/**
 * Class ContaCorrenteDetalhe
 */
class ContaCorrenteDetalhe {

  private $iCodigo;

  /**
   * @var Recurso
   */
  private $oRecurso;

  /**
   * @var string
   */
  private $sEstrutural;

  /**
   * @var Dotacao
   */
  private $oDotacao;

  /**
   * @var EmpenhoFinanceiro
   */
  private $oEmpenho;

  /**
   * @var ContaBancaria
   */
  private $oContaBancaria;

  /**
   * @var Acordo
   */
  private $oAcordo;

  /**
   * @var CgmBase
   */
  private $oCredor;

  /**
   * @var int
   */
  private $iContaCorrente;

  /**
   * @var object Instituicao
   */
  private $oInstituicao;

  /**
   * @var int
   */
  private $iEmParlamentar;

  /**
   * @var object ContaPlano
   */
  private $oContaPlano;

  public function __construct($iCodigoContaCorrenteDetalhe = null) {

    if (!empty($iCodigoContaCorrenteDetalhe)) {

      $oDaoContaCorrenteDetalhe = db_utils::getDao("contacorrentedetalhe");
      $sSqlContaCorrenteDetalhe = $oDaoContaCorrenteDetalhe->sql_query_file($iCodigoContaCorrenteDetalhe);
      $rsContaCorrenteDetalhe   = $oDaoContaCorrenteDetalhe->sql_record($sSqlContaCorrenteDetalhe);

      if ($oDaoContaCorrenteDetalhe->numrows != 0) {

        $oContaCorrenteDetalhe = db_utils::fieldsMemory($rsContaCorrenteDetalhe, 0);
        $this->setCodigo(null);
        $oRecurso = new Recurso($oContaCorrenteDetalhe->c19_orctiporec);
        $this->setRecurso($oRecurso);
        $oEmpenho = new EmpenhoFinanceiro($oContaCorrenteDetalhe->c19_numemp);
        $this->setEmpenho($oEmpenho);
        $oContaBancaria = new ContaBancaria($oContaCorrenteDetalhe->c19_contabancaria);
        $this->setContaBancaria($oContaBancaria);
        $this->setEstrutural($oContaCorrenteDetalhe->c19_estrutural);
        $oAcordo = new Acordo($oContaCorrenteDetalhe->c19_acordo);
        $this->setAcordo($oAcordo);

        if(!empty($oContaCorrenteDetalhe->c19_numcgm)) {

          if ($this->getTipoCredor($oContaCorrenteDetalhe->c19_numcgm) == "F") {

            $oCredor = new CgmFisico($oContaCorrenteDetalhe->c19_numcgm);
            $this->setCredor($oCredor);

          } else {

            $oCredor = new CgmJuridico($oContaCorrenteDetalhe->c19_numcgm);
            $this->setCredor($oCredor);

          }

        }
        if(!empty($oContaCorrenteDetalhe->c19_orcdotacao)) {

          $oDotacao = new Dotacao($oContaCorrenteDetalhe->c19_orcdotacao, db_getsession('DB_anousu'));
          $this->setDotacao($oDotacao);
        }

      }
    }
  }

  /**
   * Retorna o código sequencial da conta corrente
   * @return integer
   */
  public function getCodigo() {
    return $this->iCodigo;
  }

  /**
   * Seta o código sequencial
   * @param integer $iCodigo
   */
  public function setCodigo($iCodigo) {
    $this->iCodigo = $iCodigo;
  }
  /**
   * @param ContaBancaria $oContaBancaria
   */
  public function setContaBancaria(ContaBancaria $oContaBancaria = null) {
    $this->oContaBancaria = $oContaBancaria;
  }

  /**
   * @param Recurso $oRecurso
   */
  public function setRecurso(Recurso $oRecurso = null) {
    $this->oRecurso = $oRecurso;
  }

  /**
   * @return Recurso
   */
  public function getRecurso() {
    return $this->oRecurso;
  }

  /**
   * @param string $sEstrutural
   */
  public function setEstrutural($sEstrutural = null) {
    $this->sEstrutural = $sEstrutural;
  }

  /**
   * @return string
   */
  public function getEstrutural() {
    return $this->sEstrutural;
  }

  /**
   * @param Dotacao $oDotacao
   */
  public function setDotacao(Dotacao $oDotacao = null) {
    $this->oDotacao = $oDotacao;
  }

  /**
   * @return ContaBancaria
   */
  public function getContaBancaria() {
    return $this->oContaBancaria;
  }

  /**
   * @return Dotacao
   */
  public function getDotacao() {
    return $this->oDotacao;
  }

  /**
   * @param EmpenhoFinanceiro $oEmpenho
   */
  public function setEmpenho(EmpenhoFinanceiro $oEmpenho = null) {
    $this->oEmpenho = $oEmpenho;
  }

  /**
   * @return EmpenhoFinanceiro
   */
  public function getEmpenho() {
    return $this->oEmpenho;
  }

  /**
   * @param Acordo $oAcordo
   */
  public function setAcordo(Acordo $oAcordo = null) {
    $this->oAcordo = $oAcordo;
  }

  /**
   * @return Acordo
   */
  public function getAcordo() {
    return $this->oAcordo;
  }

  /**
   * @param CgmBase $oCredor
   */
  public function setCredor(CgmBase $oCredor = null) {
    $this->oCredor = $oCredor;
  }

  /**
   * @return CgmBase
   */
  public function getCredor() {
    return $this->oCredor;
  }

  /**
   * @param $iCgm
   * @return string
   */

  public function getTipoCredor($iCgm){
    $sSql = "select z01_cgccpf from cgm where z01_numcgm = {$iCgm}";
    $iCgcCpf = db_utils::fieldsMemory(db_query($sSql), 0)->z01_cgccpf;
    if(strlen($iCgcCpf) > 11){
      return "J";
    } else {
      return "F";
    }
  }

  /**
   * Seta o tipo da arrecadação da receita
   * 1 = Emenda Parlamentar Individual
   * 2 = Emenda Parlamentar de Bancada
   * 3 = Não se aplica
   * @param integer $iEmParlamentar
   */
  public function setEmendaParlamentar($iEmParlamentar) {
    $this->iEmParlamentar = $iEmParlamentar;
  }

  /**
   * Retorna o tipo da arrecadação da receita
   * @return integer
   */
  public function getEmendaParlamentar() {
    return $this->iEmParlamentar;
  }
}
