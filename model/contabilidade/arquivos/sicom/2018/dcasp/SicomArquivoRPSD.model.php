<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_rpsd102018_classe.php");
require_once("classes/db_rpsd112018_classe.php");
require_once("model/contabilidade/arquivos/sicom/2018/dcasp/geradores/GerarRPSD.model.php");



class SicomArquivoRPSD extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  protected $iCodigoLayout = 0;

  protected $sNomeArquivo = 'RPSD';

  protected $sTipoGeracao;

  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }

  public function getCampos(){
    return array();
  }

  public function getTipoGeracao() {
    return $this->sTipoGeracao;
  }

  public function setTipoGeracao($sTipoGeracao) {
    $this->sTipoGeracao = $sTipoGeracao;
  }

  public function __construct() { }

  public function gerarDados()
  {
    $iAnousu    = db_getsession("DB_anousu");
    $iCodInstit = db_getsession("DB_instit");

    $clrpsd10 = new cl_rpsd102018();
    $clrpsd11 = new cl_rpsd112018();

    db_inicio_transacao();
    /**
     * excluir informacoes do mes selecionado
     */
    $result = $clrpsd11->sql_record($clrpsd11->sql_query(NULL,"*",NULL,"si190_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si190_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clrpsd11->excluir(NULL,"si190_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si190_instit = ".db_getsession("DB_instit"));
      if ($clrpsd11->erro_status == 0) {
        throw new Exception($clrpsd11->erro_msg);
      }
    }

    $result = $clrpsd10->sql_record($clrpsd10->sql_query(NULL,"*",NULL,"si189_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si189_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clrpsd10->excluir(NULL,"si189_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si189_instit = ".db_getsession("DB_instit"));
      if ($clrpsd10->erro_status == 0) {
        throw new Exception($clrpsd10->erro_msg);
      }
    }
    

    $sSql  = "SELECT 1 WHERE 1!=1";

    $rsResult = db_query($sSql);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

      $clrpsd10 = new cl_rpsd102018();
      $oDadosRPSD = db_utils::fieldsMemory($rsResult, $iCont);

      $clrpsd10->si189_tiporegistro      = $oDadosRPSD->tiporegistro;
      $clrpsd10->si189_codreduzidorsp    = $oDadosRPSD->codreduzidorsp;
      $clrpsd10->si189_codorgao          = $oDadosRPSD->codorgao;
      $clrpsd10->si189_codunidadesub     = $oDadosRPSD->codunidadesub;
      $clrpsd10->si189_codunidadesuborig = $oDadosRPSD->codunidadesuborig;
      $clrpsd10->si189_nroempenho        = $oDadosRPSD->nroempenho;
      $clrpsd10->si189_exercicioempenho  = $oDadosRPSD->exercicioempenho;
      $clrpsd10->si189_dtempenho         = $oDadosRPSD->dtempenho;
      $clrpsd10->si189_tipopagamentorsp  = $oDadosRPSD->tipopagamentorsp;
      $clrpsd10->si189_vlpagorsp         = $oDadosRPSD->vlpagorsp;
      $clrpsd10->si189_mes               = $oDadosRPSD->$this->sDataFinal['5'].$this->sDataFinal['6'];
      $clrpsd10->si189_instit            = $iCodInstit;


      $clrpsd10->incluir(null);
      if ($clrpsd10->erro_status == 0) {
        throw new Exception($clrpsd10->erro_msg);
      }

    }

    for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

      $clrpsd11 = new cl_rpsd112018();
      $oDadosRPSD = db_utils::fieldsMemory($rsResult, $iCont);

      $clrpsd11->si190_tiporegistro      = $oDadosRPSD->tiporegistro;
      $clrpsd11->si190_codreduzidorsp    = $oDadosRPSD->codreduzidorsp;
      $clrpsd11->si190_codfontrecursos   = $oDadosRPSD->codfontrecursos;
      $clrpsd11->si190_vlpagofontersp    = $oDadosRPSD->vlpagofontersp;
      $clrpsd11->si190_reg10             = $oDadosRPSD->reg10;
      $clrpsd11->si190_mes               = $oDadosRPSD->$this->sDataFinal['5'].$this->sDataFinal['6'];
      $clrpsd11->si190_instit            = $iCodInstit;

      $clrpsd11->incluir(null);
      if ($clrpsd11->erro_status == 0) {
        throw new Exception($clrpsd11->erro_msg);
      }

    }

    db_fim_transacao();

    $oGerarRPSD = new GerarRPSD();
    $oGerarRPSD->iAnousu     = $iAnousu;
    $oGerarRPSD->iCodInstit  = $iCodInstit;
    $oGerarRPSD->gerarDados();

  }

}
