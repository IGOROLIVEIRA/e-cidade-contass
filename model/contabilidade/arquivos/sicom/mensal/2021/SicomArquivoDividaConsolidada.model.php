<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_ddc102021_classe.php");
require_once("classes/db_ddc202021_classe.php");
require_once("classes/db_ddc302021_classe.php");
require_once("classes/db_ddc402021_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2021/GerarDDC.model.php");

/**
 * Divida Consolidada Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class SicomArquivoDividaConsolidada extends SicomArquivoBase implements iPadArquivoBaseCSV
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
  protected $sNomeArquivo = 'DDC';

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
   * Parecer da Licitação do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {

    $clddc10 = new cl_ddc102021();
    $clddc20 = new cl_ddc202021();
    $clddc30 = new cl_ddc302021();
    $clddc40 = new cl_ddc402021();

    db_inicio_transacao();
    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = db_query($clddc10->sql_query(null, "*", null, "si150_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si150_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clddc10->excluir(null, "si150_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si150_instit = " . db_getsession("DB_instit"));
      if ($clddc10->erro_status == 0) {
        throw new Exception($clddc10->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = db_query($clddc20->sql_query(null, "*", null, "si153_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si153_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clddc20->excluir(null, "si153_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si153_instit = " . db_getsession("DB_instit"));
      if ($clddc20->erro_status == 0) {
        throw new Exception($clddc20->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 30
     */
    $result = db_query($clddc30->sql_query(null, "*", null, "si154_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si154_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clddc30->excluir(null, "si154_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si154_instit = " . db_getsession("DB_instit"));
      if ($clddc30->erro_status == 0) {
        throw new Exception($clddc30->erro_msg);
      }
    }

    /*
    * excluir informacoes do mes selecionado registro 40
    */
    $result = db_query($clddc40->sql_query(null, "*", null, "si178_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si178_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clddc40->excluir(null, "si178_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si178_instit = " . db_getsession("DB_instit"));
      if ($clddc40->erro_status == 0) {
        throw new Exception($clddc40->erro_msg);
      }
    }

    db_fim_transacao();
    db_inicio_transacao();

    $sSql = "SELECT si09_codorgaotce AS codorgao
              FROM infocomplementaresinstit
              WHERE si09_instit = " . db_getsession("DB_instit");

    $rsResult = db_query($sSql);
    $sCodorgao = db_utils::fieldsMemory($rsResult, 0)->codorgao;

    /*
     * selecionar informacoes registro 10
     */
    $sSql = "select * from dividaconsolidada where si167_mesreferencia = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
             and si167_anoreferencia = " . db_getsession("DB_anousu") . " and si167_instit = " . db_getsession("DB_instit") . " and not exists
             (select 1 from ddc102021  where si150_mes < " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "  and si150_instit = " . db_getsession("DB_instit") . "
             and si150_nroleiautorizacao = si167_nroleiautorizacao and si150_dtleiautorizacao = si167_dtleiautorizacao
              union select 1 from ddc102021  where si150_nroleiautorizacao = si167_nroleiautorizacao and si150_dtleiautorizacao = si167_dtleiautorizacao
              and si150_instit = " . db_getsession("DB_instit") . "
              union select 1 from ddc102021  where si150_nroleiautorizacao = si167_nroleiautorizacao and si150_dtleiautorizacao = si167_dtleiautorizacao
              and si150_instit = " . db_getsession("DB_instit") . ")";

    $rsResult10 = db_query($sSql);
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $clddc10 = new cl_ddc102021();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $clddc10->si150_tiporegistro = 10;
      $clddc10->si150_codorgao = $sCodorgao;
      $clddc10->si150_nroleiautorizacao = $oDados10->si167_nroleiautorizacao;
      $clddc10->si150_dtleiautorizacao = $oDados10->si167_dtleiautorizacao;
      $clddc10->si150_dtpublicacaoleiautorizacao = $oDados10->si167_dtpublicacaoleiautorizacao;
      $clddc10->si150_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clddc10->si150_instit = db_getsession("DB_instit");

      $clddc10->incluir(null);
      if ($clddc10->erro_status == 0) {
        throw new Exception($clddc10->erro_msg);
      }

    }

    /*
     * selecionar informacoes registro 20
     */
    $sSql = "select * from dividaconsolidada where si167_mesreferencia = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
             and si167_anoreferencia = " . db_getsession("DB_anousu") . " and si167_instit = " . db_getsession("DB_instit") . " and not exists
             (select 1 from ddc202021  where si153_mes < " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "  and si153_instit = " . db_getsession("DB_instit") . "
             and si153_nrocontratodivida = si167_nrocontratodivida and si153_dtassinatura = si167_dtassinatura
              union select 1 from ddc202121  where si153_nrocontratodivida = si167_nrocontratodivida and si153_dtassinatura = si167_dtassinatura
              and si153_instit = " . db_getsession("DB_instit") . "
              union select 1 from ddc202121  where si153_nrocontratodivida = si167_nrocontratodivida and si153_dtassinatura = si167_dtassinatura
              and si153_instit = " . db_getsession("DB_instit") . "
              union select 1 from ddc202121  where si153_nrocontratodivida = si167_nrocontratodivida and si153_dtassinatura = si167_dtassinatura
              and si153_instit = " . db_getsession("DB_instit") . "
              union select 1 from ddc202121  where si153_nrocontratodivida = si167_nrocontratodivida and si153_dtassinatura = si167_dtassinatura
              and si153_instit = " . db_getsession("DB_instit") . "
              union select 1 from ddc202121  where si153_nrocontratodivida = si167_nrocontratodivida and si153_dtassinatura = si167_dtassinatura
              and si153_instit = " . db_getsession("DB_instit") . ")";
    $rsResult20 = db_query($sSql);

    for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {

      $clddc20 = new cl_ddc202021();
      $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);

      $clddc20->si153_tiporegistro = 20;
      $clddc20->si153_codorgao = $sCodorgao;
      $clddc20->si153_nrocontratodivida = $oDados20->si167_nrocontratodivida;
      $clddc20->si153_dtassinatura = $oDados20->si167_dtassinatura;
      $clddc20->si153_contratodeclei = $oDados20->si167_contratodeclei;
      $clddc20->si153_nroleiautorizacao = $oDados20->si167_nroleiautorizacao;
      $clddc20->si153_dtleiautorizacao = $oDados20->si167_dtleiautorizacao;
      $clddc20->si153_objetocontratodivida = $this->removeCaracteres($oDados20->si167_objetocontratodivida);
      $clddc20->si153_especificacaocontratodivida = $this->removeCaracteres($oDados20->si167_especificacaocontratodivida);
      $clddc20->si153_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clddc20->si153_instit = db_getsession("DB_instit");

      $clddc20->incluir(null);
      if ($clddc20->erro_status == 0) {
        throw new Exception($clddc20->erro_msg);
      }

    }

    /*
    * selecionar informacoes registro 30
    */
    $sSql = "select * from dividaconsolidada
             inner join cgm on z01_numcgm = si167_numcgm
             where si167_mesreferencia = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
             and si167_anoreferencia = " . db_getsession("DB_anousu") . " and si167_instit = " . db_getsession("DB_instit");
    $rsResult30 = db_query($sSql);
    for ($iCont30 = 0; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {

      $clddc30 = new cl_ddc302021();
      $oDados30 = db_utils::fieldsMemory($rsResult30, $iCont30);

      $clddc30->si154_tiporegistro = 30;
      $clddc30->si154_codorgao = $sCodorgao;
      $clddc30->si154_nrocontratodivida = $oDados30->si167_nrocontratodivida;
      $clddc30->si154_dtassinatura = $oDados30->si167_dtassinatura;
      $clddc30->si154_tipolancamento = $oDados30->si167_tipolancamento;
      $clddc30->si154_subtipo = empty($oDados30->si167_subtipo) ? ' ' : $oDados30->si167_subtipo;
      $clddc30->si154_tipodocumentocredor = (strlen($oDados30->z01_cgccpf) == 11) ? 1 : 2;
      $clddc30->si154_nrodocumentocredor = $oDados30->z01_cgccpf;
      $clddc30->si154_justificativacancelamento = ($oDados30->si167_justificativacancelamento == null || $oDados30->si167_justificativacancelamento == "") ? "" : $oDados30->si167_vlcancelamento > 0 ? $oDados30->si167_justificativacancelamento : "";
      $clddc30->si154_vlsaldoanterior = $oDados30->si167_vlsaldoanterior;
      $clddc30->si154_vlcontratacao = $oDados30->si167_vlcontratacao;
      $clddc30->si154_vlamortizacao = $oDados30->si167_vlamortizacao;
      $clddc30->si154_vlcancelamento = $oDados30->si167_vlcancelamento;
      $clddc30->si154_vlencampacao = $oDados30->si167_vlencampacao;
      $clddc30->si154_vlatualizacao = $oDados30->si167_vlatualizacao;
      $clddc30->si154_vlsaldoatual = $oDados30->si167_vlsaldoatual;
      $clddc30->si154_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clddc30->si154_instit = db_getsession("DB_instit");

      $clddc30->incluir(null);
      if ($clddc30->erro_status == 0) {
        throw new Exception($clddc30->erro_msg);
      }

    }

    /**
     * selecionar informações do registro 40
     */
    $sSql = "select * from (select
             sum(round(substr(fc_planosaldonovo(" . db_getsession("DB_anousu") . ",c61_reduz,'{$this->sDataInicial}','{$this->sDataFinal}',FALSE),3,14)::float8,2)::float8) AS saldoinicial,
             sum(round(substr(fc_planosaldonovo(" . db_getsession("DB_anousu") . ",c61_reduz,'{$this->sDataInicial}','{$this->sDataFinal}',FALSE),45,14)::float8,2)::float8) AS saldo_final
        from conplano
        inner join conplanoreduz on c60_codcon = c61_codcon and c60_anousu = c61_anousu
        where c60_estrut like '22721%' and c61_instit = " . db_getsession("DB_instit") . " and c60_anousu = " . db_getsession("DB_anousu") . "
        and (select si09_tipoinstit from infocomplementaresinstit where si09_instit=" . db_getsession("DB_instit") . ") = 5) as x where saldoinicial is not null or saldo_final is not null";
    $rsResult40 = db_query($sSql);
    for ($iCont40 = 0; $iCont40 < pg_num_rows($rsResult40); $iCont40++) {
      $oDados40 = db_utils::fieldsMemory($rsResult40, $iCont40);
      $clddc40 = new cl_ddc402021();

      $clddc40->si178_tiporegistro = 40;
      $clddc40->si178_codorgao = $sCodorgao;
      $clddc40->si178_passivoatuarial = $oDados40->saldoinicial > 0 || $oDados40->saldo_final > 0 ? '1' : '2';
      $clddc40->si178_vlsaldoanterior = $oDados40->saldoinicial;
      $clddc40->si178_vlsaldoatual = $oDados40->saldo_final;
      $clddc40->si178_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clddc40->si178_instit = db_getsession("DB_instit");
      $clddc40->incluir(null);
      if ($clddc40->erro_status == 0) {
        throw new Exception($clddc40->erro_msg);
      }

    }


    db_fim_transacao();

    $oGerarDDC = new GerarDDC();
    $oGerarDDC->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarDDC->gerarDados();

  }

}
