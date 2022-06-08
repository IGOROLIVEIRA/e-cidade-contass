<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_licobras102022_classe.php");
require_once("classes/db_licobras202022_classe.php");
require_once("classes/db_licobras302022_classe.php");
require_once("model/contabilidade/arquivos/sicom/2022/obra/geradores/gerarLICOBRAS.php");

/**
 * Dados Cadastro de Reponsaveis Sicom Obras
 * @author Mario Junior
 * @package Obras
 */

class SicomArquivoLicobras extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'LICOBRAS';

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

    $aElementos[10] = array(
      "tipoRegistro",
      "codOrgaoResp",
      "codUnidadeSubRespEstadual",
      "exercicioLicitacao",
      "nroProcessoLicitatorio",
      "codObra",
      "Objeto",
      "linkObra"
    );

    $aElementos[20] = array(
      "tipoRegistro",
      "codOrgaoResp",
      "codUnidadeSubRespEstadual",
      "exercicioProcesso",
      "nroProcesso",
      "tipoProcesso",
      "codObra",
      "Objeto",
      "linkObra"
    );

    return $aElementos;
  }

  public function gerarDados()
  {
    //      ini_set('display_errors','on');

    /**
     * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
     */
    $licobras102022 = new cl_licobras102022();
    $licobras202022 = new cl_licobras202022();
    $licobras302022 = new cl_licobras302022();

    /**
     * excluir informacoes do mes selecioado para evitar duplicacao de registros
     */

    /**
     * registro 10 exclusão
     */
    $result = db_query($licobras102022->sql_query(null, "*", null, "si195_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si195_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $licobras102022->excluir(null, "si195_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si195_instit=" . db_getsession("DB_instit"));
      if ($licobras102022->erro_status == 0) {
        throw new Exception($licobras102022->erro_msg);
      }
    }

    /**
     * registro 20 exclusão
     */
    $result = db_query($licobras202022->sql_query(null, "*", null, "si196_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si196_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $licobras202022->excluir(null, "si196_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si196_instit=" . db_getsession("DB_instit"));
      if ($licobras202022->erro_status == 0) {
        throw new Exception($licobras202022->erro_msg);
      }
    }

    /**
     * registro 30 exclusão
     */
    $result = db_query($licobras302022->sql_query(null, "*", null, "si203_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si203_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $licobras302022->excluir(null, "si203_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si203_instit=" . db_getsession("DB_instit"));
      if ($licobras302022->erro_status == 0) {
        throw new Exception($licobras302022->erro_msg);
      }
    }

    /**
     * registro 10
     */

    $sql = "SELECT 10 AS si195_tiporegistro,
                   infocomplementaresinstit.si09_codorgaotce AS si195_codorgaoresp,
                   db_config.db21_codigomunicipoestado as si195_codunidadesubrespestadual,
                   l20_anousu AS si195_exerciciolicitacao,
                   l20_edital AS si195_nroprocessolicitatorio,
                   obr01_numeroobra AS si195_codobra,
                   l20_objeto AS si195_objeto,
                   obr01_linkobra AS si195_linkobra,
                   ac16_sequencial,
                   l20_tipojulg as si195_nrolote,
                   ac16_numeroacordo as si195_nrocontrato,
                   ac16_anousu as si195_exerciciocontrato,
                   ac16_dataassinatura as si195_dataassinatura,
                   ac16_valor as si195_vlcontrato,
                   ac16_tipounidtempoperiodo as si195_undmedidaprazoexecucao,
                   ac16_qtdperiodo as si195_prazoexecucao
            FROM licobras
            INNER JOIN liclicita ON l20_codigo = obr01_licitacao
            INNER  JOIN acordo on ac16_licitacao = l20_codigo
            INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
            INNER JOIN cflicita on l20_codtipocom = l03_codigo
            LEFT  JOIN infocomplementaresinstit ON db_config.codigo = infocomplementaresinstit.si09_instit
            WHERE l20_naturezaobjeto = 1
	            AND l03_pctipocompratribunal not in (100,101,102,103)
                AND si09_tipoinstit in (50,51,52,53,54,55,56,57,58)
                AND DATE_PART('YEAR',acordo.ac16_dataassinatura)  = " . db_getsession("DB_anousu") . "
                AND DATE_PART('MONTH',acordo.ac16_dataassinatura) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $rsResult10 = db_query($sql);

    $aObrasSemContratos = array();

    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
      $cllicobras102022 = new cl_licobras102022();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
      if ($oDados10->ac16_sequecial = "") {
        $aObrasSemContratos[] = $oDados10->si195_codobra;
      }

      if (empty($aObrasSemContratos)) {

        $cllicobras102022->si195_tiporegistro = 10;
        $cllicobras102022->si195_codorgaoresp = $oDados10->si195_codorgaoresp;
        $cllicobras102022->si195_codunidadesubrespestadual = substr($oDados10->si195_codunidadesubrespestadual, 0, 4);
        $cllicobras102022->si195_exerciciolicitacao = $oDados10->si195_exerciciolicitacao;
        $cllicobras102022->si195_nroprocessolicitatorio = $oDados10->si195_nroprocessolicitatorio;
        $cllicobras102022->si195_codobra = $oDados10->si195_codobra;
        $cllicobras102022->si195_objeto = $oDados10->si195_objeto;
        $cllicobras102022->si195_linkobra = $oDados10->si195_linkobra;
        $cllicobras102022->si195_nrolote = $oDados10->si195_nrolote;
        $cllicobras102022->si195_nrocontrato = $oDados10->si195_nrocontrato;
        $cllicobras102022->si195_exerciciocontrato = $oDados10->si195_exerciciocontrato;
        $cllicobras102022->si195_dataassinatura = $oDados10->si195_dataassinatura;
        $cllicobras102022->si195_vlcontrato = $oDados10->si195_vlcontrato;
        $cllicobras102022->si195_undmedidaprazoexecucao = $oDados10->si195_undmedidaprazoexecucao;
        $cllicobras102022->si195_prazoexecucao = $oDados10->si195_prazoexecucao;
        $cllicobras102022->si195_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $cllicobras102022->si195_instit = db_getsession("DB_instit");
        $cllicobras102022->incluir(null);

        if ($cllicobras102022->erro_status == 0) {
          throw new Exception($cllicobras102022->erro_msg);
        }
      } else {
        echo "Obra numero $aObrasSemContratos[0] - Contrato não localizado favor verificar!";
      }
    }

    /**
     * registro 20
     */

    $sql = "SELECT 20 AS si195_tiporegistro,
                   infocomplementaresinstit.si09_codorgaotce AS si195_codorgaoresp,
                   db_config.db21_codigomunicipoestado as si195_codunidadesubrespestadual,
                   l20_anousu AS si195_exerciciolicitacao,
                   l20_edital AS si195_nroprocessolicitatorio,
                   CASE
                       WHEN l03_pctipocompratribunal = 101 THEN '1'
                       WHEN l03_pctipocompratribunal = 100 THEN '2'
                       WHEN l03_pctipocompratribunal = 102 THEN '3'
                       WHEN l03_pctipocompratribunal = 103 THEN '4'
                   END AS si196_tipoprocesso,
                   obr01_numeroobra AS si195_codobra,
                   l20_objeto AS si195_objeto,
                   obr01_linkobra AS si195_linkobra,
                   ac16_numeroacordo as si196_nrocontrato,
                   ac16_anousu as si196_exerciciocontrato,
                   ac16_dataassinatura as si196_dataassinatura,
                   ac16_valor as si196_vlcontrato,
                   ac16_tipounidtempoperiodo as si196_undmedidaprazoexecucao,
                   ac16_qtdperiodo as si196_prazoexecucao
            FROM licobras
            INNER JOIN liclicita ON l20_codigo = obr01_licitacao
            LEFT  JOIN acordo on ac16_licitacao = l20_codigo
            INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
            INNER JOIN cflicita on l20_codtipocom = l03_codigo
            LEFT JOIN infocomplementaresinstit ON db_config.codigo = infocomplementaresinstit.si09_instit
            WHERE l20_naturezaobjeto = 1
	              AND l03_pctipocompratribunal in (100,101,102,103)
	              AND si09_tipoinstit in (50,51,52,53,54,55,56,57,58)
                AND DATE_PART('YEAR',licobras.obr01_dtlancamento)= " . db_getsession("DB_anousu") . "
                AND DATE_PART('MONTH',licobras.obr01_dtlancamento)= " . $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $rsResult20 = db_query($sql);

    if (pg_num_rows($rsResult20) > 0) {
      for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {
        $cllicobras202022 = new cl_licobras202022();
        $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);

        $cllicobras202022->si196_tiporegistro = 20;
        $cllicobras202022->si196_codorgaoresp = $oDados20->si195_codorgaoresp;
        $cllicobras202022->si196_codunidadesubrespestadual = substr($oDados20->si195_codunidadesubrespestadual, 0, 4);
        $cllicobras202022->si196_exerciciolicitacao = $oDados20->si195_exerciciolicitacao;
        $cllicobras202022->si196_nroprocessolicitatorio = $oDados20->si195_nroprocessolicitatorio;
        $cllicobras202022->si196_tipoprocesso = $oDados20->si196_tipoprocesso;
        $cllicobras202022->si196_codobra = $oDados20->si195_codobra;
        $cllicobras202022->si196_objeto = $oDados20->si195_objeto;
        $cllicobras202022->si196_linkobra = $oDados20->si195_linkobra;
        $cllicobras202022->si196_nrocontrato = $oDados20->si196_nrocontrato;
        $cllicobras202022->si196_exerciciocontrato = $oDados20->si196_exerciciocontrato;
        $cllicobras202022->si196_dataassinatura = $oDados20->si196_dataassinatura;
        $cllicobras202022->si196_vlcontrato = $oDados20->si196_vlcontrato;
        $cllicobras202022->si196_undmedidaprazoexecucao = $oDados20->si196_undmedidaprazoexecucao;
        $cllicobras202022->si196_prazoexecucao = $oDados20->si196_prazoexecucao;
        $cllicobras202022->si196_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $cllicobras202022->si196_instit = db_getsession("DB_instit");
        $cllicobras202022->incluir(null);

        if ($cllicobras202022->erro_status == 0) {
          throw new Exception($cllicobras202022->erro_msg);
        }
      }
    }
    /**
     * registro 30
     */

    $sql = "SELECT 30 AS si203_sequencial,
                   infocomplementaresinstit.si09_codorgaotce AS si203_codorgaoresp,
                   obr01_numeroobra AS si203_codobra,
                   db_config.db21_codigomunicipoestado as si203_codunidadesubrespestadual,
                   ac26_numeroaditamento as si203_nroseqtermoaditivo,
                   ac35_dataassinaturatermoaditivo as si203_dataassinaturatermoaditivo,
                   ac26_acordoposicaotipo as si203_tipoalteracaovalor,
                   ac26_acordoposicaotipo as si203_tipotermoaditivo,
                   ac35_descricaoalteracao as si203_dscalteracao,
                   ac26_data as si203_novadatatermino,
                   CASE
                       WHEN l03_pctipocompratribunal IN (100,101,102,103 ) THEN '2'
                       ELSE '1'
                   END as si203_tipodetalhamento,
                   ac20_valoraditado as si203_valoraditivo
            FROM licobras
            INNER JOIN liclicita ON l20_codigo = obr01_licitacao
            INNER JOIN acordo on ac16_licitacao = l20_codigo
            INNER JOIN acordoposicao on ac26_acordo = ac16_sequencial
            INNER JOIN acordoitem ON ac20_acordoposicao = ac26_sequencial
            inner join acordoposicaoaditamento on ac26_sequencial = ac35_acordoposicao
            INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
            INNER JOIN cflicita on l20_codtipocom = l03_codigo
            LEFT JOIN infocomplementaresinstit ON db_config.codigo = infocomplementaresinstit.si09_instit
            WHERE l20_naturezaobjeto = 1
	              AND l03_pctipocompratribunal not in (100,101)
	              AND si09_tipoinstit in (50,51,52,53,54,55,56,57,58)
                AND DATE_PART('YEAR',licobras.obr01_dtlancamento)= " . db_getsession("DB_anousu") . "
                AND DATE_PART('MONTH',licobras.obr01_dtlancamento)= " . $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $rsResult30 = db_query($sql);

    if (pg_num_rows($rsResult30) > 0) {
      for ($iCont30 = 0; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {
        $cllicobras302022 = new cl_licobras302022();
        $oDados30 = db_utils::fieldsMemory($rsResult30, $iCont30);

        $cllicobras302022->si203_tiporegistro = 30;
        $cllicobras302022->si203_codorgaoresp = $oDados30->si203_codorgaoresp;
        $cllicobras302022->si203_codobra = $oDados30->si203_codobra;
        $cllicobras302022->si203_codunidadesubrespestadual = substr($oDados30->si203_codunidadesubrespestadual, 0, 4);
        $cllicobras302022->si203_nroseqtermoaditivo = $oDados30->si203_nroseqtermoaditivo;
        $cllicobras302022->si203_dataassinaturatermoaditivo = $oDados30->si203_dataassinaturatermoaditivo;
        if ($oDados30->si203_valoraditivo > 0) {
          $iTipoAlteracaoValor = 1;
        } else if ($oDados30->si203_valoraditivo < 0) {
          $iTipoAlteracaoValor = 2;
        } else {
          $iTipoAlteracaoValor = 3;
        }
        $cllicobras302022->si203_tipoalteracaovalor = $iTipoAlteracaoValor;
        $cllicobras302022->si203_tipotermoaditivo = $oDados30->si203_tipotermoaditivo;
        $cllicobras302022->si203_dscalteracao = $oDados30->si203_dscalteracao;
        $cllicobras302022->si203_novadatatermino = $oDados30->si203_novadatatermino;
        $cllicobras302022->si203_tipodetalhamento = $oDados30->si203_tipodetalhamento;
        $cllicobras302022->si203_valoraditivo = abs($oDados30->si203_valoraditivo);
        $cllicobras302022->si203_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $cllicobras302022->si203_instit = db_getsession("DB_instit");
        $cllicobras302022->incluir(null);

        if ($cllicobras302022->erro_status == 0) {
          throw new Exception($cllicobras302022->erro_msg);
        }
      }
    }

    $oGerarLICOBRAS = new gerarLICOBRAS();
    $oGerarLICOBRAS->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarLICOBRAS->gerarDados();
  }
}
