<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_consid102021_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2021/flpg/GerarCONSID.model.php");

/**
 * Dados Complementares Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class SicomArquivoConsideracoes extends SicomArquivoBase implements iPadArquivoBaseCSV {

  /**
   *
   * Codigo do layout. (db_layouttxt.db50_codigo)
   * @var Integer
   */
  protected $iCodigoLayout;

  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'CONSID';

  /**
   *
   * Construtor da classe
   */
  public function __construct() {

  }

  /**
   * Retorna o codigo do layout
   *
   * @return Integer
   */
  public function getCodigoLayout(){

  }

  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   */
  public function getCampos(){

  }

  /**
   * selecionar os dados de Dados Complementares à LRF do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {

    $clconsid10 = new cl_consid102021();

    db_inicio_transacao();

    /*
     * excluir informacoes do mes selecionado registro 10
     */

    $result = $clconsid10->sql_query(NULL,"*",NULL,"si158_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
    $result = $clconsid10->sql_record($result);

    if($result != false)
      if (pg_num_rows($result) > 0) {
        $clconsid10->excluir(NULL,"si158_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
        if ($clconsid10->erro_status == 0) {
          throw new Exception($clconsid10->erro_msg);
        }
      }

    /*
     * selecionar informacoes registro 10
     */

    $sSql  = "select * from consideracoes where si171_mesreferencia = ".$this->sDataFinal['5'].$this->sDataFinal['6'];
    $sSql .= " and si171_anousu = ".db_getsession("DB_anousu");

    $rsResult10 = db_query($sSql);

    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $clconsid10 = new cl_consid102021();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $clconsid10->si158_tiporegistro          = 10;
      $clconsid10->si158_codarquivo            = $oDados10->si171_codarquivo;
      $clconsid10->si158_consideracoes         = $oDados10->si171_consideracoes;
      $clconsid10->si158_mesreferenciaconsid   = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clconsid10->si158_instit                = db_getsession("DB_instit");

      $clconsid10->incluir(null);
      if ($clconsid10->erro_status == 0) {
        throw new Exception($clconsid10->erro_msg);
      }

    }

    db_fim_transacao();

    $oGerarCONSID = new GerarCONSID();
    $oGerarCONSID->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarCONSID->gerarDados();

  }

}
