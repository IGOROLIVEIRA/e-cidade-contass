<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_iderp102019_classe.php");
require_once ("classes/db_iderp112019_classe.php");
require_once ("classes/db_iderp202019_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2019/GerarIDERP.model.php");
 /**
  * TomadasContasEspeciais Sicom Acompanhamento Mensal
  * @author igor
  * @package Contabilidade
  */
class SicomArquivoInscDespesasExercicioRestoAPagar extends SicomArquivoBase implements iPadArquivoBaseCSV {

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
  protected $sNomeArquivo = 'IDERP';

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

  	$iderp102019 = new cl_iderp102019();
    $iderp202019 = new cl_iderp202019();
    $iderp112019 = new cl_iderp112019();


    db_inicio_transacao();

    /*
     * excluir informacoes do mes selecionado 
     */
    $result = $iderp202019->sql_record($iderp202019->sql_query(NULL,"*",NULL,"si181_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si181_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $iderp202019->excluir(NULL,"si181_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si181_instit = ".db_getsession("DB_instit"));
      if ($iderp202019->erro_status == 0) {
        throw new Exception($iderp202019->erro_msg);
      }
    }
    $result = $iderp112019->sql_record($iderp112019->sql_query(NULL,"*",NULL,"si180_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si180_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $iderp112019->excluir(NULL,"si180_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si180_instit = ".db_getsession("DB_instit"));
      if ($iderp112019->erro_status == 0) {
        throw new Exception($iderp112019->erro_msg);
      }
    }
    $result = $iderp102019->sql_record($iderp102019->sql_query(NULL,"*",NULL,"si179_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si179_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $iderp102019->excluir(NULL,"si179_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si179_instit = ".db_getsession("DB_instit"));
      if ($iderp102019->erro_status == 0) {
        throw new Exception($iderp102019->erro_msg);
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

        $sSql       = "select * from iderp102019 ";

        $rsResult10 = db_query($sSql);

        for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

          // $cldclrf102014 = new cl_dclrf102014();
          // $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

          // $cldclrf102014->si157_tiporegistro                        = 10;
          // $cldclrf102014->si157_codorgao                            = $sCodorgao;
          // $cldclrf102014->si157_vlsaldoatualconcgarantia            = $oDados10->si170_vlsaldoatualconcgarantia;
          // $cldclrf102014->si157_recprivatizacao                     = $oDados10->si170_recprivatizacao;
          // $cldclrf102014->si157_vlliqincentcontrib                  = $oDados10->si170_vlliqincentcontrib;
          // $cldclrf102014->si157_vlliqincentinstfinanc               = $oDados10->si170_vlliqincentInstfinanc;
          // $cldclrf102014->si157_vlirpnpincentcontrib                = $oDados10->si170_vlIrpnpincentcontrib;
          // $cldclrf102014->si157_vlirpnpincentinstfinanc             = $oDados10->si170_vllrpnpincentinstfinanc;
          // $cldclrf102014->si157_vlcompromissado                     = $oDados10->si170_vlcompromissado;
          // $cldclrf102014->si157_vlrecursosnaoaplicados              = $oDados10->si170_vlrecursosnaoaplicados;
          // $cldclrf102014->si157_mes                                 = $this->sDataFinal['5'].$this->sDataFinal['6'];
          // $cldclrf102014->si157_instit                              = db_getsession("DB_instit");

          // $cldclrf102014->incluir(null);
          // if ($cldclrf102014->erro_status == 0) {
          //   throw new Exception($cldclrf102014->erro_msg);
          // }

        }

    db_fim_transacao();

    $oGerarIDERP = new GerarIDERP();
    $oGerarIDERP->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarIDERP->gerarDados();

  }

}
