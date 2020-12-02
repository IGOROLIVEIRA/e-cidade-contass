<?php

require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_tce102021_classe.php");
require_once ("classes/db_tce112021_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2021/GerarTCE.model.php");
 /**
  * TomadasContasEspeciais Sicom Acompanhamento Mensal
  * @author igor
  * @package Contabilidade
  */
class SicomArquivoTomadasContasEspeciais extends SicomArquivoBase implements iPadArquivoBaseCSV {

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
  protected $sNomeArquivo = 'TCE';

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
   * selecionar os dados de Dados
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {

    $tce102021 = new cl_tce102021();
    $tce112021 = new cl_tce112021();


    db_inicio_transacao();

    /*
     * excluir informacoes do mes selecionado 
     */

    $result = $tce112021->sql_record($tce112021->sql_query(NULL,"*",NULL,"si188_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si188_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $tce112021->excluir(NULL,"si188_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si188_instit = ".db_getsession("DB_instit"));
      if ($tce112021->erro_status == 0) {
        throw new Exception($tce112021->erro_msg);
      }
    }
    $result = $tce102021->sql_record($tce102021->sql_query(NULL,"*",NULL,"si187_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si187_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $tce102021->excluir(NULL,"si187_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si187_instit = ".db_getsession("DB_instit"));
      if ($tce102021->erro_status == 0) {
        throw new Exception($tce102021->erro_msg);
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

        $sSql       = "select * from tce102021 ";

        $rsResult10 = db_query($sSql);

        for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

          // $cldclrf102021 = new cl_dclrf102021();
          // $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

          // $cldclrf102021->si157_tiporegistro                        = 10;
          // $cldclrf102021->si157_codorgao                            = $sCodorgao;
          // $cldclrf102021->si157_vlsaldoatualconcgarantia            = $oDados10->si170_vlsaldoatualconcgarantia;
          // $cldclrf102021->si157_recprivatizacao                     = $oDados10->si170_recprivatizacao;
          // $cldclrf102021->si157_vlliqincentcontrib                  = $oDados10->si170_vlliqincentcontrib;
          // $cldclrf102021->si157_vlliqincentinstfinanc               = $oDados10->si170_vlliqincentInstfinanc;
          // $cldclrf102021->si157_vlirpnpincentcontrib                = $oDados10->si170_vlIrpnpincentcontrib;
          // $cldclrf102021->si157_vlirpnpincentinstfinanc             = $oDados10->si170_vllrpnpincentinstfinanc;
          // $cldclrf102021->si157_vlcompromissado                     = $oDados10->si170_vlcompromissado;
          // $cldclrf102021->si157_vlrecursosnaoaplicados              = $oDados10->si170_vlrecursosnaoaplicados;
          // $cldclrf102021->si157_mes                                 = $this->sDataFinal['5'].$this->sDataFinal['6'];
          // $cldclrf102021->si157_instit                              = db_getsession("DB_instit");

          // $cldclrf102021->incluir(null);
          // if ($cldclrf102021->erro_status == 0) {
          //   throw new Exception($cldclrf102021->erro_msg);
          // }

        }

    db_fim_transacao();

    $oGerarTCE = new GerarTCE();
    $oGerarTCE->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarTCE->gerarDados();

  }

}
