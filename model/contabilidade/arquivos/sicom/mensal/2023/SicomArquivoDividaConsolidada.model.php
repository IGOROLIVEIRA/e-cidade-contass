<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_ddc102023_classe.php");
require_once("classes/db_ddc202023_classe.php");
require_once("classes/db_ddc302023_classe.php");
require_once("classes/db_ddc402023_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2023/GerarDDC.model.php");

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

    $clddc10 = new cl_ddc102023();
    $clddc20 = new cl_ddc202023();
    $clddc30 = new cl_ddc302023();
    $clddc40 = new cl_ddc402023();

    db_inicio_transacao();
    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = db_query($clddc10->sql_query(null, "*", null, "si153_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si153_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clddc10->excluir(null, "si153_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si153_instit = " . db_getsession("DB_instit"));
      if ($clddc10->erro_status == 0) {
        throw new Exception($clddc10->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = db_query($clddc20->sql_query(null, "*", null, "si154_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si154_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clddc20->excluir(null, "si154_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si154_instit = " . db_getsession("DB_instit"));
      if ($clddc20->erro_status == 0) {
        throw new Exception($clddc20->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 30
     */
    $result = db_query($clddc30->sql_query(null, "*", null, "si178_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si178_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clddc30->excluir(null, "si178_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si178_instit = " . db_getsession("DB_instit"));
      if ($clddc30->erro_status == 0) {
        throw new Exception($clddc30->erro_msg);
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
     * selecionar informacoes registro 20
     */
    $sSql = "select * from dividaconsolidada where si167_mesreferencia = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
             and si167_anoreferencia = " . db_getsession("DB_anousu") . " and si167_instit = " . db_getsession("DB_instit") . " and not exists
             (select 1 from ddc202023  where si154_mes < " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "  and si154_instit = " . db_getsession("DB_instit") . "
             and si154_nrocontratodivida = si167_nrocontratodivida and si154_dtassinatura = si167_dtassinatura
              union select 1 from ddc202022  where si153_nrocontratodivida = si167_nrocontratodivida and si153_dtassinatura = si167_dtassinatura
              and si153_instit = " . db_getsession("DB_instit") . "
              union select 1 from ddc202021  where si153_nrocontratodivida = si167_nrocontratodivida and si153_dtassinatura = si167_dtassinatura
              and si153_instit = " . db_getsession("DB_instit") . "
              union select 1 from ddc202020  where si153_nrocontratodivida = si167_nrocontratodivida and si153_dtassinatura = si167_dtassinatura
              and si153_instit = " . db_getsession("DB_instit") . "
              union select 1 from ddc202019  where si153_nrocontratodivida = si167_nrocontratodivida and si153_dtassinatura = si167_dtassinatura
              and si153_instit = " . db_getsession("DB_instit") . "
              union select 1 from ddc202018  where si153_nrocontratodivida = si167_nrocontratodivida and si153_dtassinatura = si167_dtassinatura
              and si153_instit = " . db_getsession("DB_instit") . "
              union select 1 from ddc202017  where si153_nrocontratodivida = si167_nrocontratodivida and si153_dtassinatura = si167_dtassinatura
              and si153_instit = " . db_getsession("DB_instit") . "
              union select 1 from ddc202016  where si153_nrocontratodivida = si167_nrocontratodivida and si153_dtassinatura = si167_dtassinatura
              and si153_instit = " . db_getsession("DB_instit") . "
              union select 1 from ddc202015  where si153_nrocontratodivida = si167_nrocontratodivida and si153_dtassinatura = si167_dtassinatura
              and si153_instit = " . db_getsession("DB_instit") . "
              union select 1 from ddc202014  where si153_nrocontratodivida = si167_nrocontratodivida and si153_dtassinatura = si167_dtassinatura
              and si153_instit = " . db_getsession("DB_instit") . ")";

    $rsResult10 = db_query($sSql);

    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $clddc10 = new cl_ddc102023();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $clddc10->si153_tiporegistro = 10;
      $clddc10->si153_codorgao = $sCodorgao;
      $clddc10->si153_nrocontratodivida = $oDados10->si167_nrocontratodivida;
      $clddc10->si153_dtassinatura = $oDados10->si167_dtassinatura;
      $clddc10->si153_nroleiautorizacao = $oDados10->si167_nroleiautorizacao;
      $clddc10->si153_dtleiautorizacao = $oDados10->si167_dtleiautorizacao;
      $clddc10->si153_objetocontratodivida = $this->removeCaracteres($oDados10->si167_objetocontratodivida);
      $clddc10->si153_especificacaocontratodivida = $this->removeCaracteres($oDados10->si167_especificacaocontratodivida);
      $clddc10->si153_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clddc10->si153_instit = db_getsession("DB_instit");

      $clddc10->incluir(null);
      if ($clddc10->erro_status == 0) {
        throw new Exception($clddc10->erro_msg);
      }

    }

    /*
    * selecionar informacoes registro 20
    */
    $sSql = "select * from dividaconsolidada
             inner join cgm on z01_numcgm = si167_numcgm
             where si167_mesreferencia = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
             and si167_anoreferencia = " . db_getsession("DB_anousu") . " and si167_instit = " . db_getsession("DB_instit");
    $rsResult20 = db_query($sSql);
    for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {

      $clddc20 = new cl_ddc202023();
      $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);

      $clddc20->si154_tiporegistro = 20;
      $clddc20->si154_codorgao = $sCodorgao;
      $clddc20->si154_nrocontratodivida = $oDados20->si167_nrocontratodivida;
      $clddc20->si154_dtassinatura = $oDados20->si167_dtassinatura;
      $clddc20->si154_tipolancamento = $oDados20->si167_tipolancamento;
      $clddc20->si154_subtipo = empty($oDados20->si167_subtipo) ? ' ' : $oDados20->si167_subtipo;
      $clddc20->si154_tipodocumentocredor = (strlen($oDados20->z01_cgccpf) == 11) ? 1 : 2;
      $clddc20->si154_nrodocumentocredor = $oDados20->z01_cgccpf;
      $clddc20->si154_justificativacancelamento = ($oDados20->si167_justificativacancelamento == null || $oDados20->si167_justificativacancelamento == "") ? "" : $oDados20->si167_vlcancelamento > 0 ? $oDados20->si167_justificativacancelamento : "";
      $clddc20->si154_vlsaldoanterior = $oDados20->si167_vlsaldoanterior;
      $clddc20->si154_vlcontratacao = $oDados20->si167_vlcontratacao;
      $clddc20->si154_vlamortizacao = $oDados20->si167_vlamortizacao;
      $clddc20->si154_vlcancelamento = $oDados20->si167_vlcancelamento;
      $clddc20->si154_vlencampacao = $oDados20->si167_vlencampacao;
      $clddc20->si154_vlatualizacao = $oDados20->si167_vlatualizacao;
      $clddc20->si154_vlsaldoatual = $oDados20->si167_vlsaldoatual;
      $clddc20->si154_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clddc20->si154_instit = db_getsession("DB_instit");

      $clddc20->incluir(null);
      if ($clddc20->erro_status == 0) {
        throw new Exception($clddc20->erro_msg);
      }

    }

    /**
     * selecionar informações do registro 30
     */
    $sSql = "select * from (select
             sum(round(substr(fc_planosaldonovo(" . db_getsession("DB_anousu") . ",c61_reduz,'{$this->sDataInicial}','{$this->sDataFinal}',FALSE),3,14)::float8,2)::float8) AS saldoinicial,
             sum(round(substr(fc_planosaldonovo(" . db_getsession("DB_anousu") . ",c61_reduz,'{$this->sDataInicial}','{$this->sDataFinal}',FALSE),45,14)::float8,2)::float8) AS saldo_final
        from conplano
        inner join conplanoreduz on c60_codcon = c61_codcon and c60_anousu = c61_anousu
        where c60_estrut like '22721%' and c61_instit = " . db_getsession("DB_instit") . " and c60_anousu = " . db_getsession("DB_anousu") . "
        and (select si09_tipoinstit from infocomplementaresinstit where si09_instit=" . db_getsession("DB_instit") . ") = 5) as x where saldoinicial is not null or saldo_final is not null";
    $rsResult30 = db_query($sSql);
    for ($iCont30 = 0; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {
      $oDados30 = db_utils::fieldsMemory($rsResult30, $iCont30);
      $clddc30 = new cl_ddc302023();

      $clddc30->si178_tiporegistro = 30;
      $clddc30->si178_codorgao = $sCodorgao;
      $clddc30->si178_passivoatuarial = $oDados30->saldoinicial > 0 || $oDados30->saldo_final > 0 ? '1' : '2';
      $clddc30->si178_vlsaldoanterior = $oDados30->saldoinicial;
      $clddc30->si178_vlsaldoatual = $oDados30->saldo_final;
      $clddc30->si178_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clddc30->si178_instit = db_getsession("DB_instit");
      $clddc30->incluir(null);
      if ($clddc30->erro_status == 0) {
        throw new Exception($clddc30->erro_msg);
      }

    }


    db_fim_transacao();

    $oGerarDDC = new GerarDDC();
    $oGerarDDC->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarDDC->gerarDados();

  }

}
