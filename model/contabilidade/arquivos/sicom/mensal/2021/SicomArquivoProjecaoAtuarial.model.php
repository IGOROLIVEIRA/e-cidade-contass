<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_parpps102021_classe.php");
require_once("classes/db_parpps202021_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2021/GerarPARPPS.model.php");

/**
 * Projeção Atuarial Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class SicomArquivoProjecaoAtuarial extends SicomArquivoBase implements iPadArquivoBaseCSV
{

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
  protected $sNomeArquivo = 'PARPPS';

  /**
   *
   * Construtor da classe
   */
  public function __construct()
  {

  }

  /**
   * Retorna o codigo do layout
   *
   * @return Integer
   */
  public function getCodigoLayout()
  {
    return $this->iCodigoLayout;
  }

  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   */
  public function getCampos()
  {


  }

  /**
   * selecionar os dados de Projeção Atuarial do RPPS do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {

    $clparpps10 = new cl_parpps102021();
    $clparpps20 = new cl_parpps202021();

    db_inicio_transacao();
    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = $clparpps10->sql_record($clparpps10->sql_query(null, "*", null, "si156_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si156_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clparpps10->excluir(null, "si156_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si156_instit = " . db_getsession("DB_instit"));
      if ($clparpps10->erro_status == 0) {
        throw new Exception($clparpps10->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = $clparpps20->sql_record($clparpps20->sql_query(null, "*", null, "si155_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si155_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clparpps20->excluir(null, "si155_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si155_instit = " . db_getsession("DB_instit"));
      if ($clparpps20->erro_status == 0) {
        throw new Exception($clparpps20->erro_msg);
      }
    }
    db_fim_transacao();
    db_inicio_transacao();

    $sSql = "SELECT si09_codorgaotce AS codorgao,si09_tipoinstit AS tipoinstit
              FROM infocomplementaresinstit
              WHERE si09_instit = " . db_getsession("DB_instit");

    $rsResult = db_query($sSql);//db_criatabela($rsResult);exit;
    $sCodorgao = db_utils::fieldsMemory($rsResult, 0)->codorgao;
    $sTipoinstit = db_utils::fieldsMemory($rsResult, 0)->tipoinstit;

    if ($this->sDataFinal['5'] . $this->sDataFinal['6'] == 12 && $sTipoinstit == 5) {

      /*
       * selecionar informacoes registro 10
       */
      $sSql = "select * from projecaoatuarial10 where si168_exercicio = " . (db_getsession("DB_anousu") - 1) . " and si168_instit = " . db_getsession("DB_instit");

      $rsResult10 = db_query($sSql);//db_criatabela($rsResult10);die($sSql);

      for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

        $clparpps10 = new cl_parpps102021();
        $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

        $clparpps10->si156_tiporegistro = 10;
        $clparpps10->si156_codorgao = $sCodorgao;
        $clparpps10->si156_tipoplano = $oDados10->si168_tipoplano;
        $clparpps10->si156_exercicio = $oDados10->si168_exercicio;
        $clparpps10->si156_vlsaldofinanceiroexercicioanterior = $oDados10->si168_vlsaldofinanceiroexercicioanterior;
        $clparpps10->si156_vlreceitaprevidenciariaanterior = $oDados10->si168_vlreceitaprevidenciaria;
        $clparpps10->si156_vldespesaprevidenciariaanterior = $oDados10->si168_vldespesaprevidenciaria;
        $clparpps10->si156_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $clparpps10->si156_instit = db_getsession("DB_instit");
//echo "<pre>";print_r($clparpps10);die();
        $clparpps10->incluir(null);
        if ($clparpps10->erro_status == 0) {
          throw new Exception($clparpps10->erro_msg);
        }

      }

      /*
       * selecionar informacoes registro 20
       */
      $sSql = "select * from projecaoatuarial20 where si169_exercicio >= " . (db_getsession("DB_anousu") - 1) . "
	                   and si169_instit = " . db_getsession("DB_instit") . " limit 75";
      $rsResult20 = db_query($sSql);//db_criatabela($rsResult20);die($sSql);

      for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {

        $clparpps20 = new cl_parpps202021();
        $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);

        $clparpps20->si155_tiporegistro = 20;
        $clparpps20->si155_codorgao = $sCodorgao;
        $clparpps20->si155_tipoplano = $oDados10->si168_tipoplano;
        $clparpps20->si155_exercicio = $oDados20->si169_exercicio;
        $clparpps20->si155_dtavaliacao = $oDados20->si169_data;
        $clparpps20->si155_vlreceitaprevidenciaria = $oDados20->si169_vlreceitaprevidenciaria;
        $clparpps20->si155_vldespesaprevidenciaria = $oDados20->si169_vldespesaprevidenciaria;
        $clparpps20->si155_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $clparpps20->si155_instit = db_getsession("DB_instit");

        $clparpps20->incluir(null);
        if ($clparpps20->erro_status == 0) {
          throw new Exception($clparpps20->erro_msg);
        }

      }
    }
    db_fim_transacao();

    $oGerarPARPPS = new GerarPARPPS();
    $oGerarPARPPS->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarPARPPS->gerarDados();

  }

}
