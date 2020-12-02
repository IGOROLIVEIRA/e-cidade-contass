<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_lao102021_classe.php");
require_once("classes/db_lao112021_classe.php");
require_once("classes/db_lao202021_classe.php");
require_once("classes/db_lao212021_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2021/GerarLAO.model.php");

/**
 * selecionar dados de Leis de Alteração Sicom Acompanhamento Mensal
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoLeiAlteracaoOrcamentaria extends SicomArquivoBase implements iPadArquivoBaseCSV
{

  /**
   *
   * Codigo do layout
   * @var Integer
   */
  protected $iCodigoLayout = 151;

  /**
   *
   * Nome do arquivo a ser criado
   * @var unknown_type
   */
  protected $sNomeArquivo = 'LAO';

  /*
   * Contrutor da classe
   */
  public function __construct()
  {

  }

  /**
   * retornar o codigo do layout
   *
   * @return Integer
   */
  public function getCodigoLayout()
  {
    return $this->iCodigoLayout;
  }

  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   * @return Array
   */
  public function getCampos()
  {

    $aElementos[10] = array(
      "tipoRegistro",
      "codOrgao",
      "tipoLeiAlteracao",
      "nroLeiAlteracao",
      "dataLeiAlteracao",
      "artigoLeiAlteracao",
      "descricaoArtigo",
      "vlAutorizadoAlteracao"
    );
    $aElementos[20] = array(
      "tipoRegistro",
      "codOrgao",
      "nroLeiAlterOrcam",
      "dataLeiAlterOrcam",
      "artigoLeiAlterOrcamento",
      "descricaoArtigo",
      "novoPercentual"
    );
    $aElementos[30] = array(
      "tipoRegistro",
      "tipoDecretoAlteracao",
      "nroDecreto",
      "dataDecreto",
      "nroLeiAlteracao",
      "dataLeiAlteracao",
      "valorAberto",
      "origemRecAlteracao"
    );

    return $aElementos;
  }

  /**
   * selecionar os dados de Leis de Alteração
   *
   */
  public function gerarDados()
  {


    $cllao10 = new cl_lao102021();
    $cllao11 = new cl_lao112021();
    $cllao20 = new cl_lao202021();
    $cllao21 = new cl_lao212021();

    db_inicio_transacao();

    /*
     * excluir informacoes do mes selecionado registro 21
     */
    $result = $cllao21->sql_record($cllao21->sql_query(null, "*", null, "si37_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si37_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $cllao21->excluir(null, "si37_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si37_instit = " . db_getsession("DB_instit"));
      if ($cllao21->erro_status == 0) {
        throw new Exception($cllao21->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 11
     */
    $result = $cllao11->sql_record($cllao11->sql_query(null, "*", null, "si35_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si35_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $cllao11->excluir(null, "si35_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si35_instit = " . db_getsession("DB_instit"));
      if ($cllao11->erro_status == 0) {
        throw new Exception($cllao11->erro_msg);
      }
    }

    /*
       * excluir informacoes do mes selecionado registro 10
       */
    $result = $cllao10->sql_record($cllao10->sql_query(null, "*", null, "si34_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si34_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $cllao10->excluir(null, "si34_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si34_instit = " . db_getsession("DB_instit"));
      if ($cllao10->erro_status == 0) {
        throw new Exception($cllao10->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = $cllao20->sql_record($cllao20->sql_query(null, "*", null, "si36_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si36_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $cllao20->excluir(null, "si36_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si36_instit = " . db_getsession("DB_instit"));
      if ($cllao20->erro_status == 0) {
        throw new Exception($cllao20->erro_msg);
      }
    }

    $sSql = "SELECT si09_codorgaotce as codorgao,si09_tipoinstit
              FROM infocomplementaresinstit
              WHERE si09_instit = " . db_getsession("DB_instit");

    $rsResult = db_query($sSql);

    $sCodorgao = db_utils::fieldsMemory($rsResult, 0)->codorgao;
    $iTipoInstit = db_utils::fieldsMemory($rsResult, 0)->si09_tipoinstit;
    /**
     * Este arquivo não gera para camaras.
     */
    if ($iTipoInstit == 2) {
      /*
       * selecionar informacoes registro 10
       */
      $sSql = "select distinct orcprojetolei.* from orcprojetolei
      inner join orcprojetoorcprojetolei on o138_sequencial=o139_orcprojetolei
      inner join orcprojeto on o139_orcprojeto=o39_codproj
      inner join orcsuplem on o46_codlei=o39_codproj
      inner join conlancamsup on c79_codsup=o46_codsup
      where o138_altpercsuplementacao = 2 and o138_data >= '{$this->sDataInicial}' and o138_data <= '{$this->sDataFinal}'";
      $rsResult10 = db_query($sSql);
      for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

        $cllao10 = new cl_lao102021();
        $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
        $sNroLei = str_pad(preg_replace("/[^0-9]/", "", $oDados10->o138_numerolei),1,"0",STR_PAD_LEFT);
        $cllao10->si34_tiporegistro = 10;
        $cllao10->si34_codorgao = $sCodorgao;
        $cllao10->si34_nroleialteracao = $sNroLei;
        $cllao10->si34_dataleialteracao = $oDados10->o138_data;
        $cllao10->si34_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $cllao10->si34_instit = db_getsession("DB_instit");

        $cllao10->incluir(null);
        if ($cllao10->erro_status == 0) {
          throw new Exception($cllao10->erro_msg);
        }

        /*
         * selecionar informacoes registro 11
         */
        $sSql = "select distinct orcleialtorcamentaria.* from orcleialtorcamentaria
        inner join orcprojetolei on o200_orcprojetolei=o138_sequencial
        inner join orcprojetoorcprojetolei on o138_sequencial=o139_orcprojetolei
        inner join orcprojeto on o139_orcprojeto=o39_codproj
        inner join orcsuplem on o46_codlei=o39_codproj
        inner join conlancamsup on c79_codsup=o46_codsup
        where o200_orcprojetolei = {$oDados10->o138_sequencial}";
        $rsResult11 = db_query($sSql);
        for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {

          $cllao11 = new cl_lao112021();
          $oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);

          $cllao11->si35_tiporegistro = 11;
          $cllao11->si35_reg10 = $cllao10->si34_sequencial;
          $cllao11->si35_nroleialteracao = $sNroLei;
          $cllao11->si35_tipoleialteracao = $oDados11->o200_tipoleialteracao;
          $cllao11->si35_artigoleialteracao = $oDados11->o200_artleialteracao;
          $cllao11->si35_descricaoartigo = $oDados11->o200_descrartigo;
          $cllao11->si35_vlautorizadoalteracao = $oDados11->o200_vlautorizado;
          $cllao11->si35_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
          $cllao11->si35_instit = db_getsession("DB_instit");

          $cllao11->incluir(null);
          if ($cllao11->erro_status == 0) {
            throw new Exception($cllao11->erro_msg);
          }

        }

      }

      /*
       * selecionar informacoes registro 20
       */
      $sSql = "select distinct orcprojetolei.* from orcprojetolei
      inner join orcprojetoorcprojetolei on o138_sequencial=o139_orcprojetolei
      inner join orcprojeto on o139_orcprojeto=o39_codproj
      left join orcsuplem on o46_codlei=o39_codproj
      left join conlancamsup on c79_codsup=o46_codsup
      where o138_altpercsuplementacao = 1 and o138_data >= '{$this->sDataInicial}' and o138_data <= '{$this->sDataFinal}'";
      $rsResult20 = db_query($sSql);

      for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {

        $cllao20 = new cl_lao202021();
        $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);
        $sNroLei = str_pad(preg_replace("/[^0-9]/", "", $oDados20->o138_numerolei),1,"0",STR_PAD_LEFT);
        $cllao20->si36_tiporegistro = 20;
        $cllao20->si36_codorgao = $sCodorgao;
        $cllao20->si36_nroleialterorcam = $sNroLei;
        $cllao20->si36_dataleialterorcam = $oDados20->o138_data;
        $cllao20->si36_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $cllao20->si36_instit = db_getsession("DB_instit");

        $cllao20->incluir(null);
        if ($cllao20->erro_status == 0) {
          throw new Exception($cllao20->erro_msg);
        }

        /*
         * selecionar informacoes registro 21
         */
        $sSql = "select distinct orcleialtorcamentaria.* from orcleialtorcamentaria
        inner join orcprojetolei on o200_orcprojetolei=o138_sequencial
        inner join orcprojetoorcprojetolei on o138_sequencial=o139_orcprojetolei
        inner join orcprojeto on o139_orcprojeto=o39_codproj
        left join orcsuplem on o46_codlei=o39_codproj
        left join conlancamsup on c79_codsup=o46_codsup
        where o200_orcprojetolei = {$oDados20->o138_sequencial}";
        $rsResult21 = db_query($sSql);
        for ($iCont21 = 0; $iCont21 < pg_num_rows($rsResult21); $iCont21++) {

          $cllao21 = new cl_lao212021();
          $oDados21 = db_utils::fieldsMemory($rsResult21, $iCont21);

          $cllao21->si37_tiporegistro = 21;
          $cllao21->si37_reg20 = $cllao20->si36_sequencial;
          $cllao21->si37_nroleialterorcam = $sNroLei;
          $cllao21->si37_tipoautorizacao = $oDados21->o200_tipoleialteracao;
          $cllao21->si37_artigoleialterorcamento = $oDados21->o200_artleialteracao;
          $cllao21->si37_descricaoartigo = $oDados21->o200_descrartigo;
          $cllao21->si37_novopercentual = $oDados21->o200_percautorizado;
          $cllao21->si37_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
          $cllao21->si37_instit = db_getsession("DB_instit");

          $cllao21->incluir(null);
          if ($cllao21->erro_status == 0) {
            throw new Exception($cllao21->erro_msg);
          }

        }

      }

      db_fim_transacao();
    }
    $oGerarLAO = new GerarLAO();
    $oGerarLAO->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarLAO->gerarDados();

  }

}
