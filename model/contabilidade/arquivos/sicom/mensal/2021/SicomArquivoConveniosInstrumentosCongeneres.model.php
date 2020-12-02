<?php

require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_conge102020_classe.php");
require_once ("classes/db_conge202020_classe.php");
require_once ("classes/db_conge302020_classe.php");
require_once ("classes/db_conge402020_classe.php");
require_once ("classes/db_conge502020_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2020/GerarCONGE.model.php");
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

  	$conge102020 = new cl_conge102020();
    $conge202020 = new cl_conge202020();
    $conge302020 = new cl_conge302020();
    $conge402020 = new cl_conge402020();
    $conge502020 = new cl_conge502020();

    db_inicio_transacao();

    /*
     * excluir informacoes do mes selecionado 
     */
    $result = $conge502020->sql_record($conge502020->sql_query(NULL,"*",NULL,"si186_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si186_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $conge502020->excluir(NULL,"si186_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si186_instit = ".db_getsession("DB_instit"));
      if ($conge502020->erro_status == 0) {
        throw new Exception($conge502020->erro_msg);
      }
    }
    $result = $conge402020->sql_record($conge402020->sql_query(NULL,"*",NULL,"si185_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si185_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $conge402020->excluir(NULL,"si185_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si185_instit = ".db_getsession("DB_instit"));
      if ($conge402020->erro_status == 0) {
        throw new Exception($conge402020->erro_msg);
      }
    }
    $result = $conge302020->sql_record($conge302020->sql_query(NULL,"*",NULL,"si184_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si184_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $conge302020->excluir(NULL,"si184_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si184_instit = ".db_getsession("DB_instit"));
      if ($conge302020->erro_status == 0) {
        throw new Exception($conge302020->erro_msg);
      }
    }
    $result = $conge202020->sql_record($conge202020->sql_query(NULL,"*",NULL,"si183_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si183_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $conge202020->excluir(NULL,"si183_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si183_instit = ".db_getsession("DB_instit"));
      if ($conge202020->erro_status == 0) {
        throw new Exception($conge202020->erro_msg);
      }
    }
    $result = $conge102020->sql_record($conge102020->sql_query(NULL,"*",NULL,"si182_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si182_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $conge102020->excluir(NULL,"si182_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si182_instit = ".db_getsession("DB_instit"));
      if ($conge102020->erro_status == 0) {
        throw new Exception($conge102020->erro_msg);
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

        $sSql       = "select * from conge102020 ";

        $rsResult10 = db_query($sSql);

        for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

          // $cldclrf10$PROXIMO_ANO = new cl_dclrf10$PROXIMO_ANO();
          // $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

          // $cldclrf10$PROXIMO_ANO->si157_tiporegistro                        = 10;
          // $cldclrf10$PROXIMO_ANO->si157_codorgao                            = $sCodorgao;
          // $cldclrf10$PROXIMO_ANO->si157_vlsaldoatualconcgarantia            = $oDados10->si170_vlsaldoatualconcgarantia;
          // $cldclrf10$PROXIMO_ANO->si157_recprivatizacao                     = $oDados10->si170_recprivatizacao;
          // $cldclrf10$PROXIMO_ANO->si157_vlliqincentcontrib                  = $oDados10->si170_vlliqincentcontrib;
          // $cldclrf10$PROXIMO_ANO->si157_vlliqincentinstfinanc               = $oDados10->si170_vlliqincentInstfinanc;
          // $cldclrf10$PROXIMO_ANO->si157_vlirpnpincentcontrib                = $oDados10->si170_vlIrpnpincentcontrib;
          // $cldclrf10$PROXIMO_ANO->si157_vlirpnpincentinstfinanc             = $oDados10->si170_vllrpnpincentinstfinanc;
          // $cldclrf10$PROXIMO_ANO->si157_vlcompromissado                     = $oDados10->si170_vlcompromissado;
          // $cldclrf10$PROXIMO_ANO->si157_vlrecursosnaoaplicados              = $oDados10->si170_vlrecursosnaoaplicados;
          // $cldclrf10$PROXIMO_ANO->si157_mes                                 = $this->sDataFinal['5'].$this->sDataFinal['6'];
          // $cldclrf10$PROXIMO_ANO->si157_instit                              = db_getsession("DB_instit");

          // $cldclrf10$PROXIMO_ANO->incluir(null);
          // if ($cldclrf10$PROXIMO_ANO->erro_status == 0) {
          //   throw new Exception($cldclrf10$PROXIMO_ANO->erro_msg);
          // }

        }

    db_fim_transacao();

    $oGerarCONGE = new GerarCONGE();
    $oGerarCONGE->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarCONGE->gerarDados();

  }

}
