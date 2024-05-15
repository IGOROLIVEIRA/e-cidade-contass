<?php

require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_conge102019_classe.php");
require_once ("classes/db_conge202019_classe.php");
require_once ("classes/db_conge302019_classe.php");
require_once ("classes/db_conge402019_classe.php");
require_once ("classes/db_conge502019_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2019/GerarCONGE.model.php");
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

  	$conge102019 = new cl_conge102019();
    $conge202019 = new cl_conge202019();
    $conge302019 = new cl_conge302019();
    $conge402019 = new cl_conge402019();
    $conge502019 = new cl_conge502019();

    db_inicio_transacao();

    /*
     * excluir informacoes do mes selecionado 
     */
    $result = $conge502019->sql_record($conge502019->sql_query(NULL,"*",NULL,"si186_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si186_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $conge502019->excluir(NULL,"si186_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si186_instit = ".db_getsession("DB_instit"));
      if ($conge502019->erro_status == 0) {
        throw new Exception($conge502019->erro_msg);
      }
    }
    $result = $conge402019->sql_record($conge402019->sql_query(NULL,"*",NULL,"si185_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si185_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $conge402019->excluir(NULL,"si185_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si185_instit = ".db_getsession("DB_instit"));
      if ($conge402019->erro_status == 0) {
        throw new Exception($conge402019->erro_msg);
      }
    }
    $result = $conge302019->sql_record($conge302019->sql_query(NULL,"*",NULL,"si184_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si184_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $conge302019->excluir(NULL,"si184_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si184_instit = ".db_getsession("DB_instit"));
      if ($conge302019->erro_status == 0) {
        throw new Exception($conge302019->erro_msg);
      }
    }
    $result = $conge202019->sql_record($conge202019->sql_query(NULL,"*",NULL,"si183_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si183_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $conge202019->excluir(NULL,"si183_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si183_instit = ".db_getsession("DB_instit"));
      if ($conge202019->erro_status == 0) {
        throw new Exception($conge202019->erro_msg);
      }
    }
    $result = $conge102019->sql_record($conge102019->sql_query(NULL,"*",NULL,"si182_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si182_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $conge102019->excluir(NULL,"si182_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si182_instit = ".db_getsession("DB_instit"));
      if ($conge102019->erro_status == 0) {
        throw new Exception($conge102019->erro_msg);
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

        $sSql       = "select * from conge102019 ";

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

    $oGerarCONGE = new GerarCONGE();
    $oGerarCONGE->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarCONGE->gerarDados();

  }

}
