<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_licobras102020_classe.php");
require_once("classes/db_licobras202020_classe.php");
require_once("model/contabilidade/arquivos/sicom/2020/obra/geradores/gerarLICOBRAS.php");


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
    /**
     * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
     */
    $licobras102020 = new cl_licobras102020();
    $licobras202020 = new cl_licobras202020();

    /**
     * excluir informacoes do mes selecioado para evitar duplicacao de registros
     */
    db_inicio_transacao();

    /**
     * registro 10 exclusão
     */
    $result = db_query($licobras102020->sql_query(null, "*", null, "si195_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si195_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $licobras102020->excluir(null, "si195_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si195_instit=" . db_getsession("DB_instit"));
      if ($licobras102020->erro_status == 0) {
        throw new Exception($licobras102020->erro_msg);
      }
    }

    /**
     * registro 20 exclusão
     */
    $result = db_query($licobras202020->sql_query(null, "*", null, "si196_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si196_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $licobras202020->excluir(null, "si196_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si196_instit=" . db_getsession("DB_instit"));
      if ($licobras202020->erro_status == 0) {
        throw new Exception($licobras202020->erro_msg);
      }
    }


    /**
     * registro 10
     */

    $sql = "SELECT 10 AS si195_tiporegistro,
                   infocomplementaresinstit.si09_codorgaotce AS si195_codorgaoresp,
                (SELECT CASE
                            WHEN o41_subunidade != 0
                                 OR NOT NULL THEN lpad((CASE
                                                            WHEN o40_codtri = '0'
                                                                 OR NULL THEN o40_orgao::varchar
                                                            ELSE o40_codtri
                                                        END),2,0)||lpad((CASE
                                                                             WHEN o41_codtri = '0'
                                                                                  OR NULL THEN o41_unidade::varchar
                                                                             ELSE o41_codtri
                                                                         END),3,0)||lpad(o41_subunidade::integer,3,0)
                            ELSE lpad((CASE
                                           WHEN o40_codtri = '0'
                                                OR NULL THEN o40_orgao::varchar
                                           ELSE o40_codtri
                                       END),2,0)||lpad((CASE
                                                            WHEN o41_codtri = '0'
                                                                 OR NULL THEN o41_unidade::varchar
                                                            ELSE o41_codtri
                                                        END),3,0)
                        END AS codunidadesub
                 FROM db_departorg
                 JOIN infocomplementares ON si08_anousu = db01_anousu
                 AND si08_instit = " . db_getsession("DB_instit") . "
                 JOIN orcunidade ON db01_orgao=o41_orgao
                 AND db01_unidade=o41_unidade
                 AND db01_anousu = o41_anousu
                 JOIN orcorgao ON o40_orgao = o41_orgao
                 AND o40_anousu = o41_anousu
                 WHERE db01_coddepto=l20_codepartamento
                     AND db01_anousu=" . db_getsession("DB_anousu") . "
                 LIMIT 1)AS si195_codunidadesubrespestadual,
                   l20_anousu AS si195_exerciciolicitacao,
                   l20_edital AS si195_nroprocessolicitatorio,
                   obr01_numeroobra AS si195_codobra,
                   l20_objeto AS si195_objeto,
                   obr01_linkobra AS si195_linkobra
            FROM licobras
            INNER JOIN liclicita ON l20_codigo = obr01_licitacao
            INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
            INNER JOIN cflicita on l20_codtipocom = l03_codigo
            LEFT JOIN infocomplementaresinstit ON db_config.codigo = infocomplementaresinstit.si09_instit
            WHERE l20_naturezaobjeto = 1
	              AND l03_pctipocompratribunal not in (100,101)
                AND DATE_PART('YEAR',licobras.obr01_dtinicioatividades)= " . db_getsession("DB_anousu") . "
                AND DATE_PART('MONTH',licobras.obr01_dtinicioatividades)=" . $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $rsResult10 = db_query($sql);

    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
      $cllicobras102020 = new cl_licobras102020();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $cllicobras102020->si195_tiporegistro = 10;
      $cllicobras102020->si195_codorgaoresp = $oDados10->si195_codorgaoresp;
      $cllicobras102020->si195_codunidadesubrespestadual = substr($oDados10->si195_codunidadesubrespestadual, 0, 4);
      $cllicobras102020->si195_exerciciolicitacao = $oDados10->si195_exerciciolicitacao;
      $cllicobras102020->si195_nroprocessolicitatorio = $oDados10->si195_nroprocessolicitatorio;
      $cllicobras102020->si195_codobra = $oDados10->si195_codobra;
      $cllicobras102020->si195_objeto = $oDados10->si195_objeto;
      $cllicobras102020->si195_linkobra = $oDados10->si195_linkobra;
      $cllicobras102020->si195_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $cllicobras102020->si195_instit = db_getsession("DB_instit");
      $cllicobras102020->incluir(null);

      if ($cllicobras102020->erro_status == 0) {
        throw new Exception($cllicobras102020->erro_msg);
      }
    }

    /**
     * registro 20
     */

    $sql = "SELECT 20 AS si195_tiporegistro,
                   infocomplementaresinstit.si09_codorgaotce AS si195_codorgaoresp,
                (SELECT CASE
                            WHEN o41_subunidade != 0
                                 OR NOT NULL THEN lpad((CASE
                                                            WHEN o40_codtri = '0'
                                                                 OR NULL THEN o40_orgao::varchar
                                                            ELSE o40_codtri
                                                        END),2,0)||lpad((CASE
                                                                             WHEN o41_codtri = '0'
                                                                                  OR NULL THEN o41_unidade::varchar
                                                                             ELSE o41_codtri
                                                                         END),3,0)||lpad(o41_subunidade::integer,3,0)
                            ELSE lpad((CASE
                                           WHEN o40_codtri = '0'
                                                OR NULL THEN o40_orgao::varchar
                                           ELSE o40_codtri
                                       END),2,0)||lpad((CASE
                                                            WHEN o41_codtri = '0'
                                                                 OR NULL THEN o41_unidade::varchar
                                                            ELSE o41_codtri
                                                        END),3,0)
                        END AS codunidadesub
                 FROM db_departorg
                 JOIN infocomplementares ON si08_anousu = db01_anousu
                 AND si08_instit = " . db_getsession("DB_instit") . "
                 JOIN orcunidade ON db01_orgao=o41_orgao
                 AND db01_unidade=o41_unidade
                 AND db01_anousu = o41_anousu
                 JOIN orcorgao ON o40_orgao = o41_orgao
                 AND o40_anousu = o41_anousu
                 WHERE db01_coddepto=l20_codepartamento
                     AND db01_anousu=" . db_getsession("DB_anousu") . "
                 LIMIT 1)AS si195_codunidadesubrespestadual,
                   l20_anousu AS si195_exerciciolicitacao,
                   l20_edital AS si195_nroprocessolicitatorio,
                   obr01_numeroobra AS si195_codobra,
                   l20_objeto AS si195_objeto,
                   obr01_linkobra AS si195_linkobra
            FROM licobras
            INNER JOIN liclicita ON l20_codigo = obr01_licitacao
            INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
            INNER JOIN cflicita on l20_codtipocom = l03_codigo
            LEFT JOIN infocomplementaresinstit ON db_config.codigo = infocomplementaresinstit.si09_instit
            WHERE l20_naturezaobjeto = 1
	              AND l03_pctipocompratribunal in (100,101)
                AND DATE_PART('YEAR',licobras.obr01_dtinicioatividades)= " . db_getsession("DB_anousu") . "
                AND DATE_PART('MONTH',licobras.obr01_dtinicioatividades)=" . $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $rsResult20 = db_query($sql);

    if(pg_num_rows($rsResult20) > 0) {
      for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult10); $iCont20++) {
        $cllicobras202020 = new cl_licobras202020();
        $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);

        $cllicobras202020->si196_tiporegistro = 20;
        $cllicobras202020->si196_codorgaoresp = $oDados20->si196_codorgaoresp;
        $cllicobras202020->si196_codunidadesubrespestadual = substr($oDados20->si196_codunidadesubrespestadual, 0, 4);
        $cllicobras202020->si196_exerciciolicitacao = $oDados20->si196_exerciciolicitacao;
        $cllicobras202020->si196_nroprocessolicitatorio = $oDados20->si196_nroprocessolicitatorio;
        $cllicobras202020->si196_codobra = $oDados20->si196_codobra;
        $cllicobras202020->si196_objeto = $oDados20->si196_objeto;
        $cllicobras202020->si196_linkobra = $oDados20->si196_linkobra;
        $cllicobras202020->si196_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $cllicobras202020->si196_instit = db_getsession("DB_instit");
        $cllicobras202020->incluir(null);

        if ($cllicobras202020->erro_status == 0) {
          throw new Exception($cllicobras202020->erro_msg);
        }
      }
    }

    $oGerarLICOBRAS = new gerarLICOBRAS();
    $oGerarLICOBRAS->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarLICOBRAS->gerarDados();
  }
}
