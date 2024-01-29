<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_licobras102024_classe.php");
require_once("classes/db_licobras202024_classe.php");
require_once("classes/db_licobras302024_classe.php");
require_once("model/contabilidade/arquivos/sicom/2024/obra/geradores/gerarLICOBRAS.php");

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
    $licobras102024 = new cl_licobras102024();
    $licobras202024 = new cl_licobras202024();
    $licobras302024 = new cl_licobras302024();

    /**
     * excluir informacoes do mes selecioado para evitar duplicacao de registros
     */

    /**
     * registro 10 exclus�o
     */
    $result = db_query($licobras102024->sql_query(null, "*", null, "si195_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si195_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $licobras102024->excluir(null, "si195_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si195_instit=" . db_getsession("DB_instit"));
      if ($licobras102024->erro_status == 0) {
        throw new Exception($licobras102024->erro_msg);
      }
    }

    /**
     * registro 20 exclus�o
     */
    $result = db_query($licobras202024->sql_query(null, "*", null, "si196_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si196_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $licobras202024->excluir(null, "si196_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si196_instit=" . db_getsession("DB_instit"));
      if ($licobras202024->erro_status == 0) {
        throw new Exception($licobras202024->erro_msg);
      }
    }

    /**
     * registro 30 exclus�o
     */
    $result = db_query($licobras302024->sql_query(null, "*", null, "si203_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si203_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $licobras302024->excluir(null, "si203_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si203_instit=" . db_getsession("DB_instit"));
      if ($licobras302024->erro_status == 0) {
        throw new Exception($licobras302024->erro_msg);
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
                   ac16_qtdperiodo as si195_prazoexecucao,
                   ac16_tipoorigem,
                   z01_cgccpf as si195_numdocumentocontratado,
                   CASE
                        WHEN LENGTH(z01_cgccpf) = 11 THEN 1
                        ELSE 2
                   END AS si195_tipodocumento,
                   si09_codunidadesubunidade as si195_codunidadesubsicom
            FROM licobras
            INNER JOIN liclicita ON l20_codigo = obr01_licitacao
            INNER  JOIN acordo on ac16_licitacao = l20_codigo
            INNER JOIN cgm on z01_numcgm = ac16_contratado
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
      $cllicobras102024 = new cl_licobras102024();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
      if ($oDados10->ac16_sequecial = "") {
        $aObrasSemContratos[] = $oDados10->si195_codobra;
      }

      if (empty($aObrasSemContratos)) {

        $cllicobras102024->si195_tiporegistro = 10;
        $cllicobras102024->si195_codorgaoresp = $oDados10->si195_codorgaoresp;
        $cllicobras102024->si195_codunidadesubrespestadual = "";
        $cllicobras102024->si195_exerciciolicitacao = $oDados10->si195_exerciciolicitacao;
        $cllicobras102024->si195_nroprocessolicitatorio = $oDados10->si195_nroprocessolicitatorio;
        $cllicobras102024->si195_nrolote = $oDados10->si195_nrolote;
        if($oDados10->ac16_tipoorigem){
          $cllicobras102024->si195_contdeclicitacao = $oDados10->ac16_tipoorigem;
        }else{
          $cllicobras102024->si195_contdeclicitacao = null;
        }
        $cllicobras102024->si195_codobra = $oDados10->si195_codobra;
        $cllicobras102024->si195_objeto = $this->removeCaracteres($oDados10->si195_objeto);
        $cllicobras102024->si195_linkobra = $oDados10->si195_linkobra;
        $cllicobras102024->si195_codorgaorespsicom = 3;
        $cllicobras102024->si195_codunidadesubsicom = $oDados10->si195_codunidadesubsicom;
        $cllicobras102024->si195_nrocontrato = $oDados10->si195_nrocontrato;
        $cllicobras102024->si195_exerciciocontrato = $oDados10->si195_exerciciocontrato;
        $cllicobras102024->si195_dataassinatura = $oDados10->si195_dataassinatura;
        $cllicobras102024->si195_vlcontrato = $oDados10->si195_vlcontrato;
        $cllicobras102024->si195_tipodocumento = $oDados10->si195_tipodocumento;
        $cllicobras102024->si195_numdocumentocontratado = $oDados10->si195_numdocumentocontratado;
        $cllicobras102024->si195_undmedidaprazoexecucao = $oDados10->si195_undmedidaprazoexecucao;
        $cllicobras102024->si195_prazoexecucao = $oDados10->si195_prazoexecucao;
        $cllicobras102024->si195_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $cllicobras102024->si195_instit = db_getsession("DB_instit");
        $cllicobras102024->incluir(null);

        if ($cllicobras102024->erro_status == 0) {
          throw new Exception($cllicobras102024->erro_msg);
        }
      } else {
        echo "Obra numero $aObrasSemContratos[0] - Contrato n�o localizado favor verificar!";
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
                   ac16_qtdperiodo as si196_prazoexecucao,
                   ac16_tipoorigem,
                   si09_codunidadesubunidade as si196_codunidadesubsicom
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
        $cllicobras202024 = new cl_licobras202024();
        $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);

        $cllicobras202024->si196_tiporegistro = 20;
        $cllicobras202024->si196_codorgaoresp = $oDados20->si195_codorgaoresp;
        $cllicobras202024->si196_codunidadesubrespestadual = "";
        $cllicobras202024->si196_exerciciolicitacao = $oDados20->si195_exerciciolicitacao;
        $cllicobras202024->si196_nroprocessolicitatorio = $oDados20->si195_nroprocessolicitatorio;
        $cllicobras202024->si196_tipoprocesso = $oDados20->si196_tipoprocesso;
        if($oDados20->ac16_tipoorigem){
          $cllicobras202024->si196_contdeclicitacao = $oDados20->ac16_tipoorigem;
        }else{
          $cllicobras202024->si196_contdeclicitacao = null;
        }
        $cllicobras202024->si196_codobra = $oDados20->si195_codobra;
        $cllicobras202024->si196_objeto = $this->removeCaracteres($oDados20->si195_objeto);
        $cllicobras202024->si196_linkobra = $oDados20->si195_linkobra;
        $cllicobras202024->si196_codorgaorespsicom = 3;
        $cllicobras202024->si196_codunidadesubsicom = $oDados20->si196_codunidadesubsicom;
        $cllicobras202024->si196_nrocontrato = $oDados20->si196_nrocontrato;
        $cllicobras202024->si196_exerciciocontrato = $oDados20->si196_exerciciocontrato;
        $cllicobras202024->si196_dataassinatura = $oDados20->si196_dataassinatura;
        $cllicobras202024->si196_vlcontrato = $oDados20->si196_vlcontrato;
        $cllicobras202024->si196_undmedidaprazoexecucao = $oDados20->si196_undmedidaprazoexecucao;
        $cllicobras202024->si196_prazoexecucao = $oDados20->si196_prazoexecucao;
        $cllicobras202024->si196_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $cllicobras202024->si196_instit = db_getsession("DB_instit");
        $cllicobras202024->incluir(null);

        if ($cllicobras202024->erro_status == 0) {
          throw new Exception($cllicobras202024->erro_msg);
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
                   ac20_valoraditado as si203_valoraditivo,
                   si09_codunidadesubunidade as si203_codunidadesubrespestadual
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
        $cllicobras302024 = new cl_licobras302024();
        $oDados30 = db_utils::fieldsMemory($rsResult30, $iCont30);

        $cllicobras302024->si203_tiporegistro = 30;
        $cllicobras302024->si203_codorgaoresp = $oDados30->si203_codorgaoresp;
        $cllicobras302024->si203_codobra = $oDados30->si203_codobra;
        $cllicobras302024->si203_codunidadesubrespestadual = $oDados30->si203_codunidadesubrespestadual;
        $cllicobras302024->si203_nroseqtermoaditivo = $oDados30->si203_nroseqtermoaditivo;
        $cllicobras302024->si203_dataassinaturatermoaditivo = $oDados30->si203_dataassinaturatermoaditivo;
        if ($oDados30->si203_valoraditivo > 0) {
          $iTipoAlteracaoValor = 1;
        } else if ($oDados30->si203_valoraditivo < 0) {
          $iTipoAlteracaoValor = 2;
        } else {
          $iTipoAlteracaoValor = 3;
        }
        $cllicobras302024->si203_tipoalteracaovalor = $iTipoAlteracaoValor;
        $cllicobras302024->si203_tipotermoaditivo = $oDados30->si203_tipotermoaditivo;
        $cllicobras302024->si203_dscalteracao = $this->removeCaracteres($oDados30->si203_dscalteracao);
        $cllicobras302024->si203_novadatatermino = $oDados30->si203_novadatatermino;
        $cllicobras302024->si203_tipodetalhamento = $oDados30->si203_tipodetalhamento;
        $cllicobras302024->si203_valoraditivo = abs($oDados30->si203_valoraditivo);
        $cllicobras302024->si203_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $cllicobras302024->si203_instit = db_getsession("DB_instit");
        $cllicobras302024->incluir(null);

        if ($cllicobras302024->erro_status == 0) {
          throw new Exception($cllicobras302024->erro_msg);
        }
      }
    }

    $oGerarLICOBRAS = new gerarLICOBRAS();
    $oGerarLICOBRAS->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarLICOBRAS->gerarDados();
  }
}
