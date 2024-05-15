<?php

require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_conge102021_classe.php");
require_once ("classes/db_conge202021_classe.php");
require_once ("classes/db_conge302021_classe.php");
require_once ("classes/db_conge402021_classe.php");
require_once ("classes/db_conge502021_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2021/GerarCONGE.model.php");
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

  	$conge102021 = new cl_conge102021();
    $conge202021 = new cl_conge202021();
    $conge302021 = new cl_conge302021();
    $conge402021 = new cl_conge402021();
    $conge502021 = new cl_conge502021();

    db_inicio_transacao();

    /*
     * excluir informacoes do mes selecionado 
     */
    $result = $conge502021->sql_record($conge502021->sql_query(NULL,"*",NULL,"si186_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si186_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $conge502021->excluir(NULL,"si186_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si186_instit = ".db_getsession("DB_instit"));
      if ($conge502021->erro_status == 0) {
        throw new Exception($conge502021->erro_msg);
      }
    }
    $result = $conge402021->sql_record($conge402021->sql_query(NULL,"*",NULL,"si185_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si185_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $conge402021->excluir(NULL,"si185_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si185_instit = ".db_getsession("DB_instit"));
      if ($conge402021->erro_status == 0) {
        throw new Exception($conge402021->erro_msg);
      }
    }
    $result = $conge302021->sql_record($conge302021->sql_query(NULL,"*",NULL,"si184_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si184_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $conge302021->excluir(NULL,"si184_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si184_instit = ".db_getsession("DB_instit"));
      if ($conge302021->erro_status == 0) {
        throw new Exception($conge302021->erro_msg);
      }
    }
    $result = $conge202021->sql_record($conge202021->sql_query(NULL,"*",NULL,"si183_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si183_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $conge202021->excluir(NULL,"si183_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si183_instit = ".db_getsession("DB_instit"));
      if ($conge202021->erro_status == 0) {
        throw new Exception($conge202021->erro_msg);
      }
    }
    $result = $conge102021->sql_record($conge102021->sql_query(NULL,"*",NULL,"si182_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si182_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $conge102021->excluir(NULL,"si182_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si182_instit = ".db_getsession("DB_instit"));
      if ($conge102021->erro_status == 0) {
        throw new Exception($conge102021->erro_msg);
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

        $sSql       = "select * from conge102021 ";

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

    $oGerarCONGE = new GerarCONGE();
    $oGerarCONGE->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarCONGE->gerarDados();

  }

}
