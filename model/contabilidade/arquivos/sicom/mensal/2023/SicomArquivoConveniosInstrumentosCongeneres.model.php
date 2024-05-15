<?php

require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_conge102023_classe.php");
require_once ("classes/db_conge202023_classe.php");
require_once ("classes/db_conge302023_classe.php");
require_once ("classes/db_conge402023_classe.php");
require_once ("classes/db_conge502023_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2023/GerarCONGE.model.php");
 /**
  * ConveniosInstrumentosCongeneres Sicom Acompanhamento Mensal
  * @author igor
  * @package Contabilidade
  */
class SicomArquivoConveniosInstrumentosCongeneres extends SicomArquivoBase implements iPadArquivoBaseCSV {

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
  protected $sNomeArquivo = 'CONGE';

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

  	$conge102023 = new cl_conge102023();
    $conge202023 = new cl_conge202023();
    $conge302023 = new cl_conge302023();
    $conge402023 = new cl_conge402023();
    $conge502023 = new cl_conge502023();

    db_inicio_transacao();

    /*
     * excluir informacoes do mes selecionado 
     */
    $result = $conge502023->sql_record($conge502023->sql_query(NULL,"*",NULL,"si186_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si186_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $conge502023->excluir(NULL,"si186_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si186_instit = ".db_getsession("DB_instit"));
      if ($conge502023->erro_status == 0) {
        throw new Exception($conge502023->erro_msg);
      }
    }
    $result = $conge402023->sql_record($conge402023->sql_query(NULL,"*",NULL,"si185_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si185_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $conge402023->excluir(NULL,"si185_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si185_instit = ".db_getsession("DB_instit"));
      if ($conge402023->erro_status == 0) {
        throw new Exception($conge402023->erro_msg);
      }
    }
    $result = $conge302023->sql_record($conge302023->sql_query(NULL,"*",NULL,"si184_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si184_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $conge302023->excluir(NULL,"si184_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si184_instit = ".db_getsession("DB_instit"));
      if ($conge302023->erro_status == 0) {
        throw new Exception($conge302023->erro_msg);
      }
    }
    $result = $conge202023->sql_record($conge202023->sql_query(NULL,"*",NULL,"si183_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si183_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $conge202023->excluir(NULL,"si183_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si183_instit = ".db_getsession("DB_instit"));
      if ($conge202023->erro_status == 0) {
        throw new Exception($conge202023->erro_msg);
      }
    }
    $result = $conge102023->sql_record($conge102023->sql_query(NULL,"*",NULL,"si182_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si182_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $conge102023->excluir(NULL,"si182_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si182_instit = ".db_getsession("DB_instit"));
      if ($conge102023->erro_status == 0) {
        throw new Exception($conge102023->erro_msg);
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

        $sSql       = "select * from conge102023 ";

        $rsResult10 = db_query($sSql);

        for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

          // $cldclrf102023 = new cl_dclrf102023();
          // $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

          // $cldclrf102023->si157_tiporegistro                        = 10;
          // $cldclrf102023->si157_codorgao                            = $sCodorgao;
          // $cldclrf102023->si157_vlsaldoatualconcgarantia            = $oDados10->si170_vlsaldoatualconcgarantia;
          // $cldclrf102023->si157_recprivatizacao                     = $oDados10->si170_recprivatizacao;
          // $cldclrf102023->si157_vlliqincentcontrib                  = $oDados10->si170_vlliqincentcontrib;
          // $cldclrf102023->si157_vlliqincentinstfinanc               = $oDados10->si170_vlliqincentInstfinanc;
          // $cldclrf102023->si157_vlirpnpincentcontrib                = $oDados10->si170_vlIrpnpincentcontrib;
          // $cldclrf102023->si157_vlirpnpincentinstfinanc             = $oDados10->si170_vllrpnpincentinstfinanc;
          // $cldclrf102023->si157_vlcompromissado                     = $oDados10->si170_vlcompromissado;
          // $cldclrf102023->si157_vlrecursosnaoaplicados              = $oDados10->si170_vlrecursosnaoaplicados;
          // $cldclrf102023->si157_mes                                 = $this->sDataFinal['5'].$this->sDataFinal['6'];
          // $cldclrf102023->si157_instit                              = db_getsession("DB_instit");

          // $cldclrf102023->incluir(null);
          // if ($cldclrf102023->erro_status == 0) {
          //   throw new Exception($cldclrf102023->erro_msg);
          // }

        }

    db_fim_transacao();

    $oGerarCONGE = new GerarCONGE();
    $oGerarCONGE->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarCONGE->gerarDados();

  }

}
