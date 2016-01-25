<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_metareal102016_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2016/GerarMETAREAL.model.php");

/**
 * Dados Complementares Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class SicomArquivoCronogramaExecucao extends SicomArquivoBase implements iPadArquivoBaseCSV {

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
  protected $sNomeArquivo = 'METAREAL';

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
    return $this->iCodigoLayout;
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

    $clmetareal10 = new cl_metareal102016();

    db_inicio_transacao();

    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = $clmetareal10->sql_record($clmetareal10->sql_query(NULL,"*",NULL,"si171_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si171_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $clmetareal10->excluir(NULL,"si171_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si171_instit = ".db_getsession("DB_instit"));
      if ($clmetareal10->erro_status == 0) {
        throw new Exception($clmetareal10->erro_msg);
      }
    }


    $sSql  = "SELECT si09_codorgaotce AS codorgao, si09_tipoinstit AS tipoinstit
              FROM infocomplementaresinstit
              WHERE si09_instit = ".db_getsession("DB_instit");

    $rsResult    = db_query($sSql);
    $sCodorgao   = db_utils::fieldsMemory($rsResult, 0)->codorgao;

    /*
     * selecionar informacoes registro 10
     */

    $sSql       = "select * from dadoscomplementareslrf where si171_mesreferencia = '{$this->sDataFinal['6']}' and si171_instit = ". db_getsession("DB_instit") . 'limit 0';

    $rsResult10 = db_query($sSql);

    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $clmetareal10 = new cl_metareal102016();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $clmetareal10->si171_tiporegistro                        = 10;
      $clmetareal10->si171_codorgao                            = $sCodorgao;
      $clmetareal10->si171_codunidadesub                       = $oDados10->si171_codunidadesub;
      $clmetareal10->si171_codfuncao                           = $oDados10->si171_codfuncao;
      $clmetareal10->si171_codsubfuncao                        = $oDados10->si171_codsubfuncao;
      $clmetareal10->si171_codprograma                         = $oDados10->si171_codprograma;
      $clmetareal10->si171_idacao                              = $oDados10->si171_idacao;
      $clmetareal10->si171_idsubacao                           = $oDados10->si171_idsubacao;
      $clmetareal10->si171_metarealizada                       = $oDados10->si171_metarealizada;
      $clmetareal10->si171_justificativa                       = $oDados10->si171_justificativa;
      $clmetareal10->si171_mes                                 = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clmetareal10->si171_instit                              = db_getsession("DB_instit");

      $clmetareal10->incluir(null);
      if ($clmetareal10->erro_status == 0) {
        throw new Exception($clmetareal10->erro_msg);
      }

    }

    db_fim_transacao();

    $oGerarMETAREAL = new GerarMETAREAL();
    $oGerarMETAREAL->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarMETAREAL->gerarDados();

  }

}
