<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("model/contabilidade/arquivos/sicom/2020/obra/geradores/gerarCADOBRAS.php");
require_once("classes/db_cadobras102020_classe.php");
require_once("classes/db_cadobras202020_classe.php");
require_once("classes/db_cadobras212020_classe.php");
require_once("classes/db_cadobras302020_classe.php");
require_once('model/relatorios/Relatorio.php');
require_once('vendor/mpdf/mpdf/mpdf.php');
require('fpdf151/fpdf.php');

/**
 * Dados Cadastro de Reponsaveis Sicom Obras
 * @author Mario Junior
 * @package Obras
 */

class SicomArquivoDetalhamentodeObras extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'CADOBRAS';

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
  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }

  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   */
  public function getCampos()
  {
    $aElementos[10] = array(
      "tipoRegistro",
      "codOrgao",
      "codUnidadeSub",
      "nroContrato",
      "exercicioContrato",
      "codObra",
      "Objeto",
      "linkObra"
    );
    return $aElementos;
  }

  public function gerarPDFobra($iCodMedicao)
  {
      db_inicio_transacao();
      global $conn;
      $sql = "select *,infocomplementaresinstit.si09_codorgaotce AS si197_codorgao from licobrasmedicao
            inner join licobras on obr03_seqobra = obr01_sequencial
            inner join liclicita on l20_codigo = obr01_licitacao
            INNER JOIN licobrasanexo on obr04_licobrasmedicao = obr03_sequencial
            INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
            LEFT JOIN infocomplementaresinstit ON db_config.codigo = infocomplementaresinstit.si09_instit
            where obr03_sequencial = $iCodMedicao";
      $rsMedicao = db_query($sql);

      for ($iContMed = 0; $iContMed < pg_numrows($rsMedicao); $iContMed++) {
        $aMedicao = db_utils::fieldsMemory($rsMedicao, $iContMed);
        $sOrgao  = str_pad($aMedicao->si197_codorgao, 2,"0",STR_PAD_LEFT);

        $nomearq = 'FOTO_MEDICAO' ."_" . $sOrgao . "_" . $aMedicao->obr01_numeroobra . "_" . $aMedicao->obr03_tipomedicao . "_" . $aMedicao->obr03_nummedicao . ".pdf";
        $arq_origem = "tmp/".$nomearq;
        $arq_destino = $nomearq;

        pg_lo_export($conn, $aMedicao->obr04_anexo, $arq_origem);
        copy($arq_origem,$arq_destino);

      }
      db_fim_transacao();

  }

  public function gerarDados()
  {
    /**
     * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
     */

    $clcadobras102020 = new cl_cadobras102020();
    $clcadobras202020 = new cl_cadobras202020();
    $clcadobras212020 = new cl_cadobras212020();
    $clcadobras302020 = new cl_cadobras302020();

    /**
     * excluir informacoes do mes selecioado para evitar duplicacao de registros
     */

    /**
     * registro 30 exclusão
     */
    $result = db_query($clcadobras302020->sql_query(null, "*", null, "si201_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si201_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clcadobras302020->excluir(null, "si201_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si201_instit=" . db_getsession("DB_instit"));
      if ($clcadobras302020->erro_status == 0) {
        throw new Exception($clcadobras302020->erro_msg);
      }
    }

    /**
     * registro 21 exclusão
     */
    $result = db_query($clcadobras212020->sql_query(null, "*", null, "si200_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si200_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clcadobras212020->excluir(null, "si200_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si200_instit=" . db_getsession("DB_instit"));
      if ($clcadobras212020->erro_status == 0) {
        throw new Exception($clcadobras212020->erro_msg);
      }
    }

    /**
     * registro 20 exclusão
     */
    $result = db_query($clcadobras202020->sql_query(null, "*", null, "si199_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si199_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clcadobras202020->excluir(null, "si199_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si199_instit=" . db_getsession("DB_instit"));
      if ($clcadobras202020->erro_status == 0) {
        throw new Exception($clcadobras202020->erro_msg);
      }
    }

    /**
     * registro 10 exclusão
     */
    $result = db_query($clcadobras102020->sql_query(null, "*", null, "si198_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si198_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clcadobras102020->excluir(null, "si198_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si198_instit=" . db_getsession("DB_instit"));
      if ($clcadobras102020->erro_status == 0) {
        throw new Exception($clcadobras102020->erro_msg);
      }
    }

    /**
     * Registro 10
     */
    $sql = "SELECT *
            FROM licobras
            INNER JOIN licobrasresponsaveis ON obr05_seqobra = obr01_sequencial
            INNER JOIN liclicita ON l20_codigo = obr01_licitacao
            INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
            LEFT JOIN infocomplementaresinstit ON db_config.codigo = infocomplementaresinstit.si09_instit
            INNER JOIN cgm on z01_numcgm = obr05_responsavel
            WHERE DATE_PART('YEAR',licobrasresponsaveis.obr05_dtcadastrores)= " . db_getsession("DB_anousu") . "
                AND DATE_PART('MONTH',licobrasresponsaveis.obr05_dtcadastrores)= " . $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $rsResult10 = db_query($sql);

    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
      $clcadobras102020 = new cl_cadobras102020();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $clcadobras102020->si198_tiporegistro = 10;
      $clcadobras102020->si198_codorgaoresp = $oDados10->si09_codorgaotce;
      $clcadobras102020->si198_codobra = $oDados10->obr01_numeroobra;
      $clcadobras102020->si198_tiporesponsavel = $oDados10->obr05_tiporesponsavel;
      $clcadobras102020->si198_nrodocumento = $oDados10->z01_cgccpf;
      $clcadobras102020->si198_tiporegistroconselho = $oDados10->obr05_tiporegistro;
      $clcadobras102020->si198_nroregistroconseprof = $oDados10->obr05_numregistro;
      $clcadobras102020->si198_numrt = $oDados10->obr05_numartourrt;
      $clcadobras102020->si198_dtinicioatividadeseng = $oDados10->obr05_dtcadastrores;
      $clcadobras102020->si198_tipovinculo = $oDados10->obr05_vinculoprofissional;
      $clcadobras102020->si198_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clcadobras102020->si198_instit = db_getsession("DB_instit");
      $clcadobras102020->incluir(null);

      if ($clcadobras102020->erro_status == 0) {
        throw new Exception($clcadobras102020->erro_msg);
      }
    }

    /**
     * Registro 20
     */

    $sql = "SELECT DISTINCT *
              FROM licobras
              INNER JOIN licobrasituacao ON obr02_seqobra = obr01_sequencial
              INNER JOIN liclicita ON l20_codigo = obr01_licitacao
              INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
              LEFT JOIN infocomplementaresinstit ON db_config.codigo = infocomplementaresinstit.si09_instit
              WHERE DATE_PART('YEAR',licobrasituacao.obr02_dtsituacao)=  " . db_getsession("DB_anousu") . "
              AND DATE_PART('MONTH',licobrasituacao.obr02_dtsituacao)= " . $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $rsResult20 = db_query($sql);

    for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {
      $clcadobras202020 = new cl_cadobras202020();
      $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);

      $clcadobras202020->si199_tiporegistro = 20;
      $clcadobras202020->si199_codorgaoresp = $oDados20->si09_codorgaotce;
      $clcadobras202020->si199_codobra = $oDados20->obr01_numeroobra;
      $clcadobras202020->si199_situacaodaobra = $oDados20->obr02_situacao;
      $clcadobras202020->si199_dtsituacao = $oDados20->obr02_dtsituacao;
      $clcadobras202020->si199_veiculopublicacao = $oDados20->obr02_veiculopublicacao;
      $clcadobras202020->si199_dtpublicacao = $oDados20->obr02_dtpublicacao;
      $clcadobras202020->si199_descsituacao = $oDados20->obr02_descrisituacao;
      $clcadobras202020->si199_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clcadobras202020->si199_instit = db_getsession("DB_instit");
      $clcadobras202020->incluir(null);

      if ($clcadobras202020->erro_status == 0) {
        throw new Exception($clcadobras202020->erro_msg);
      }
    }

    /**
     * Registro 21
     */

    $sql = "SELECT *
              FROM licobras
              INNER JOIN licobrasituacao ON obr02_seqobra = obr01_sequencial
              WHERE obr02_situacao IN (3,4)
                  AND DATE_PART('YEAR',licobrasituacao.obr02_dtsituacao)=  " . db_getsession("DB_anousu") . "
                  AND DATE_PART('MONTH',licobrasituacao.obr02_dtsituacao)= " . $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $rsResult21 = db_query($sql);

    for ($iCont21 = 0; $iCont21 < pg_num_rows($rsResult21); $iCont21++) {
      $clcadobras212020 = new cl_cadobras212020();
      $oDados21 = db_utils::fieldsMemory($rsResult21, $iCont21);

      $clcadobras212020->si200_tiporegistro = 21;
      $clcadobras212020->si200_codorgaoresp = $oDados21->si09_codorgaotce;
      $clcadobras212020->si200_codobra = $oDados21->obr01_numeroobra;
      $clcadobras212020->si200_dtparalisacao = $oDados21->obr02_dtparalisacao;
      $clcadobras212020->si200_motivoparalisacap = $oDados21->obr02_motivoparalisacao;
      $clcadobras212020->si200_descoutrosparalisacao = $oDados21->obr02_outrosmotivos;
      $clcadobras212020->si200_dtretomada = $oDados21->obr02_dtretomada;
      $clcadobras212020->si200_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clcadobras212020->si200_instit = db_getsession("DB_instit");
      $clcadobras212020->incluir(null);

      if ($clcadobras212020->erro_status == 0) {
        throw new Exception($clcadobras212020->erro_msg);
      }
    }

    /**
     * Registro 30
     */

    $sql = "SELECT *
              FROM licobras
              INNER JOIN licobrasmedicao on obr03_seqobra = obr01_sequencial
              inner join liclicita on l20_codigo = obr01_licitacao
              INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
              LEFT JOIN infocomplementaresinstit ON db_config.codigo = infocomplementaresinstit.si09_instit
              WHERE DATE_PART('YEAR',licobrasmedicao.obr03_dtentregamedicao)=  " . db_getsession("DB_anousu") . "
                  AND DATE_PART('MONTH',licobrasmedicao.obr03_dtentregamedicao)= " . $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $rsResult30 = db_query($sql);//echo $sql; db_criatabela($rsResult30);die();

    for ($iCont30 = 0; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {
      $clcadobras302020 = new cl_cadobras302020();
      $oDados30 = db_utils::fieldsMemory($rsResult30, $iCont30);

      /**
       * Aqui e gerado os relatorios pdf com as fotos da medicao.
       */
      if($oDados30->obr03_tipomedicao != "2" || $oDados30->obr03_tipomedicao != "9"){
        $this->gerarPDFobra($oDados30->obr03_sequencial);
      }

      $clcadobras302020->si201_tiporegistro = 30;
      $clcadobras302020->si201_codorgaoresp = $oDados30->si09_codorgaotce;
      $clcadobras302020->si201_codobra = $oDados30->obr01_numeroobra;
      $clcadobras302020->si201_tipomedicao = $oDados30->obr03_tipomedicao;
      $clcadobras302020->si201_descoutrostiposmed = $oDados30->obr03_outrostiposmedicao;
      $clcadobras302020->si201_nummedicao = $oDados30->obr03_nummedicao;
      $clcadobras302020->si201_descmedicao = $oDados30->obr03_descmedicao;
      $clcadobras302020->si201_dtiniciomedicao = $oDados30->obr03_dtiniciomedicao;
      $clcadobras302020->si201_dtfimmedicao = $oDados30->obr03_dtfimmedicao;
      $clcadobras302020->si201_dtmedicao = $oDados30->obr03_dtentregamedicao;
      $clcadobras302020->si201_valormedicao = $oDados30->obr03_vlrmedicao;
      $clcadobras302020->si201_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
//      $clcadobras302020->si201_pdf = 'FOTO_MEDICAO' . $oDados30->si197_codorgao . "_" . $oDados30->obr03_seqobra . "_" . $oDados30->obr03_tipomedicao . "_" . $oDados30->obr03_nummedicao . ".pdf";
      $clcadobras302020->si201_instit = db_getsession("DB_instit");
      $clcadobras302020->incluir(null);

      if ($clcadobras302020->erro_status == 0) {
        throw new Exception($clcadobras302020->erro_msg);
      }
    }

    $oGerarCADOBRAS = new gerarCADOBRAS();
    $oGerarCADOBRAS->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarCADOBRAS->gerarDados();
  }
}
