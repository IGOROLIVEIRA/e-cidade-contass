<?php

require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_redispi102024_classe.php");
require_once("classes/db_redispi112024_classe.php");
require_once("classes/db_redispi122024_classe.php");

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2024/GerarREDISPI.model.php");


/**
 * Resumo da Dispensa ou Inexigibilidade
 * @author Victor Felipe
 * @package Contabilidade
 */
class SicomArquivoResumoDispensaInexigibilidade extends SicomArquivoBase implements iPadArquivoBaseCSV
{

  /**
   *
   * Codigo do layout. (db_layouttxt.db50_codigo)
   * @var Integer
   */
  protected $iCodigoLayout = 154;

  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'REDISPI';

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
   *  metodo para passar os dados das Acoes e Metas para o $this->aDados
   */
  public function getCampos()
  {

    $aElementos[10] = array(
      "tipoRegistro",
      "codOrgaoResp",
      "codUnidadeSubResp",
      "codUnidadeSubRespEstadual",
      "exercicioProcesso",
      "nroProcesso",
      "tipoProcesso",
      "tipoCadastradoDispensaInexigibilidade",
      "dtAbertura",
      "naturezaObjeto",
      "objeto",
      "justificativa",
      "razao",
      "vlRecurso",
      "bdi",
      "link"
    );
    $aElementos[11] = array(
      "tipoRegistro",
      "codOrgaoResp",
      "codUnidadeSubResp",
      "codUnidadeSubRespEstadual",
      "exercicioProcesso",
      "nroProcesso",
      "codObraLocal",
      "tipoProcesso",
      "classeObjeto",
      "tipoAtividadeObra",
      "tipoAtividadeServico",
      "dscAtividadeServico",
      "tipoAtividadeServEspecializado",
      "dscAtividadeServEspecializado",
      "codFuncao",
      "codSubFuncao",
      "codBemPublico"
    );
    $aElementos[12] = array(
      "tipoRegistro",
      "codOrgaoResp",
      "codUnidadeSubResp",
      "codUnidadeSubRespEstadual",
      "exercicioProcesso",
      "nroProcesso",
      "codObraLocal",
      "logradouro",
      "numero",
      "bairro",
      "cidade",
      "cep",
      "latitude",
      "longitude",
      "codBemPublico"
    );

    return $aElementos;
  }

  /**
   * selecionar os dados dos pagamentos de despesa do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {

    /**
     * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
     */
    $clredispi10 = new cl_redispi102024();
    $clredispi11 = new cl_redispi112024();
    $clredispi12 = new cl_redispi122024();


    /**
     * excluir informacoes do mes selecioado para evitar duplicacao de registros
     */
    db_inicio_transacao();

    /**
     * registro 12
     */
    $result = db_query($clredispi12->sql_query(null, "*", null, "si185_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si185_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clredispi12->excluir(null, "si185_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si185_instit=" . db_getsession("DB_instit"));
      if ($clredispi12->erro_status == 0) {
        throw new Exception($clredispi12->erro_msg);
      }
    }

    /**
     * registro 11
     */
    $result = db_query($clredispi11->sql_query(null, "*", null, "si184_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si184_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clredispi11->excluir(null, "si184_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si184_instit=" . db_getsession("DB_instit"));
      if ($clredispi11->erro_status == 0) {
        throw new Exception($clredispi11->erro_msg);
      }
    }

    /**
     * registro 10
     */
    $result = db_query($clredispi10->sql_query(null, "*", null, "si183_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si183_instit=" . db_getsession("DB_instit")));

    if (pg_num_rows($result) > 0) {
      $clredispi10->excluir(null, "si183_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si183_instit=" . db_getsession("DB_instit"));
      if ($clredispi10->erro_status == 0) {
        throw new Exception($clredispi10->erro_msg);
      }
    }

    $sSql = "SELECT DISTINCT '10' AS tipoRegistro,l20_leidalicitacao,
                     infocomplementaresinstit.si09_codorgaotce AS codOrgaoResp,
                     (SELECT CASE
                                WHEN o41_subunidade != 0 OR NOT NULL
                                    THEN lpad((CASE
                                                WHEN o40_codtri = '0' OR NULL
                                                    THEN o40_orgao::varchar
                                                    ELSE o40_codtri
                                                END),2,0)||lpad((CASE
                                                                    WHEN o41_codtri = '0' OR NULL
                                                                        THEN o41_unidade::varchar
                                                                        ELSE o41_codtri
                                                                    END),3,0)||lpad(o41_subunidade::integer,3,0)
                                    ELSE lpad((CASE
                                                WHEN o40_codtri = '0' OR NULL
                                                    THEN o40_orgao::varchar
                                                    ELSE o40_codtri
                                                END),2,0)||lpad((CASE
                                                                    WHEN o41_codtri = '0' OR NULL
                                                                        THEN o41_unidade::varchar
                                                                        ELSE o41_codtri
                                                                    END),3,0)
                                END AS codunidadesub
                     FROM db_departorg
                     JOIN infocomplementares ON si08_anousu = db01_anousu
                     AND si08_instit = " . db_getsession('DB_instit') . "
                     JOIN orcunidade ON db01_orgao=o41_orgao
                     AND db01_unidade = o41_unidade
                     AND db01_anousu = o41_anousu
                     JOIN orcorgao ON o40_orgao = o41_orgao
                     AND o40_anousu = o41_anousu
                     WHERE db01_coddepto=l20_codepartamento AND db01_anousu=" . db_getsession('DB_anousu') . "
                     LIMIT 1) AS codUnidadeSubResp,
                                '0' AS codUnidadeSubRespEstadual,
                                liclicita.l20_anousu AS exercicioProcesso,
                                liclicita.l20_edital AS nroProcesso,
                                liclicita.l20_tipoprocesso AS tipoProcesso,
                                '1' AS tipocadastradodispensainexigibilidade,
                                '' AS dscCadastroLicitatorio,
                                CASE
                                    WHEN liclicita.l20_dataaber IS NULL THEN liclicita.l20_datacria
                                    ELSE liclicita.l20_dataaber
                                END AS dtAbertura,
                                liclicita.l20_naturezaobjeto AS naturezaObjeto,
                                liclicita.l20_objeto AS objeto,
                                liclicita.l20_justificativa AS justificativa,
                                liclicita.l20_razao AS razao,
                                liclicita.l20_tipojulg,
                                liclicita.l20_usaregistropreco,
                                case when liclicita.l20_naturezaobjeto = '1' or liclicita.l20_naturezaobjeto = '7' then liclicita.l20_regimexecucao else 0 end AS regimeExecucaoObras,
                                obrasdadoscomplementareslote.db150_bdi AS bdi,
                                liclancedital.l47_linkpub AS linkpub,
                                liclancedital.l47_email AS emailContato,
                                (SELECT SUM(si02_vlprecoreferencia * pc11_quant)
                                 FROM
                                     (SELECT DISTINCT pc11_seq,
                                                      (sum(pc23_vlrun)/count(pc23_orcamforne)) AS si02_vlprecoreferencia,
                                                      CASE
                                                          WHEN pc80_criterioadjudicacao = 1 THEN round((sum(pc23_perctaxadesctabela)/count(pc23_orcamforne)),2)
                                                          WHEN pc80_criterioadjudicacao = 2 THEN round((sum(pc23_percentualdesconto)/count(pc23_orcamforne)),2)
                                                      END AS mediapercentual,
                                                      pc11_quant,
                                                      pc01_codmater
                                      FROM pcproc
                                      JOIN pcprocitem ON pc80_codproc = pc81_codproc
                                      JOIN pcorcamitemproc ON pc81_codprocitem = pc31_pcprocitem
                                      JOIN pcorcamitem ON pc31_orcamitem = pc22_orcamitem
                                      JOIN pcorcamval ON pc22_orcamitem = pc23_orcamitem
                                      JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
                                      JOIN solicitem ON pc81_solicitem = pc11_codigo
                                      JOIN solicitempcmater ON pc11_codigo = pc16_solicitem
                                      JOIN pcmater ON pc16_codmater = pc01_codmater
                                      JOIN itemprecoreferencia ON pc23_orcamitem = si02_itemproccompra
                                      JOIN precoreferencia ON itemprecoreferencia.si02_precoreferencia = precoreferencia.si01_sequencial
                                      WHERE pc80_codproc IN
                                              (SELECT DISTINCT pc80_codproc
                                               FROM liclicitem
                                               INNER JOIN pcprocitem ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
                                               INNER JOIN liclicita lic2 ON lic2.l20_codigo = liclicitem.l21_codliclicita
                                               INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
                                               INNER JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
                                               INNER JOIN db_usuarios ON db_usuarios.id_usuario = lic2.l20_id_usucria
                                               INNER JOIN cflicita ON cflicita.l03_codigo = lic2.l20_codtipocom
                                               INNER JOIN liclocal ON liclocal.l26_codigo = lic2.l20_liclocal
                                               INNER JOIN liccomissao ON liccomissao.l30_codigo = lic2.l20_liccomissao
                                               LEFT JOIN solicitatipo ON solicitatipo.pc12_numero = solicitem.pc11_numero
                                               LEFT JOIN pctipocompra ON pctipocompra.pc50_codcom = solicitatipo.pc12_tipo
                                               WHERE lic2.l20_codigo = liclicita.l20_codigo)
                                          AND pc23_valor <> 0
                                          AND pc23_vlrun <> 0
                                      GROUP BY pc11_seq,
                                               pc01_codmater,
                                               pc80_criterioadjudicacao,
                                               pc01_tabela,
                                               pc11_quant
                                      ORDER BY pc11_seq) AS valor_global) AS vlRecurso
                FROM liclicita
                INNER JOIN cflicita ON (liclicita.l20_codtipocom = cflicita.l03_codigo)
                INNER JOIN pctipocompratribunal ON (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
                INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
                LEFT JOIN infocomplementaresinstit ON db_config.codigo = infocomplementaresinstit.si09_instit
                INNER JOIN liclicitasituacao ON liclicitasituacao.l11_liclicita = liclicita.l20_codigo
                INNER JOIN liclancedital ON liclancedital.l47_liclicita = liclicita.l20_codigo
                LEFT JOIN obrascodigos on obrascodigos.db151_liclicita = liclancedital.l47_liclicita
				        LEFT JOIN obrasdadoscomplementareslote ON obrascodigos.db151_codigoobra = db150_codobra
                WHERE db_config.codigo = " . db_getsession('DB_instit') . " AND liclancedital.l47_dataenvio = '" . $this->sDataFinal . "'
                    AND pctipocompratribunal.l44_sequencial IN (100, 101, 102, 103, 106)
";
    $rsResult10 = db_query($sSql);//db_criatabela($rsResult10);die($sSql);

    /**
     * registro 10
     */
    $aDadosAgrupados10 = array();
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $clredispi10 = new cl_redispi102024();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $chave = $oDados10->nroprocesso;
      if (!in_array($chave, $aDadosAgrupados10)) {
        $aDadosAgrupados10[] = $chave;
        $clredispi10->si183_tiporegistro = 10;//1
        $clredispi10->si183_codorgaoresp         = $oDados10->codorgaoresp;//2
        if (db_gettipoinstit(db_getsession('DB_instit')) == "51") {
            $clredispi10->si183_codunidadesubresp = '';//3
            $clredispi10->si183_codunidadesubrespestadual = $oDados10->codunidadesubrespestadual;//4
        }else {
            $clredispi10->si183_codunidadesubresp = $oDados10->codunidadesubresp;//3
            $clredispi10->si183_codunidadesubrespestadual = ''; //4
        }
        $clredispi10->si183_exercicioprocesso = $oDados10->exercicioprocesso;//5
        $clredispi10->si183_nroprocesso = $oDados10->nroprocesso;//6
        $clredispi10->si183_tipoprocesso = $oDados10->tipoprocesso;//7
        $clredispi10->si183_tipocadastradodispensainexigibilidade = $oDados10->tipocadastradodispensainexigibilidade;//8
        $clredispi10->si183_dsccadastrolicitatorio = $oDados10->dsccadastrolicitatorio;//9
        $clredispi10->si183_dtabertura = $oDados10->dtabertura;//10
        $clredispi10->si183_naturezaobjeto = $oDados10->naturezaobjeto;//11
        $clredispi10->si183_objeto = $oDados10->objeto;//12
        $clredispi10->si183_justificativa = $oDados10->justificativa;//13
        $clredispi10->si183_razao = $oDados10->razao;//14
        $clredispi10->si183_vlrecurso = $oDados10->vlrecurso == null ? 0 : $oDados10->vlrecurso;//15
        $clredispi10->si183_bdi = $oDados10->bdi;//16
        $clredispi10->si183_link = $oDados10->linkpub;//17
        $clredispi10->si183_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];//18
        $clredispi10->si183_leidalicitacao = $oDados10->l20_leidalicitacao;//19
        $clredispi10->si183_regimeexecucaoobras = $oDados10->regimeexecucaoobras;//20
        $clredispi10->si183_emailcontato = $oDados10->emailcontato; //21
        $clredispi10->si183_instit = db_getsession("DB_instit");

        $clredispi10->incluir(null);

        if ($clredispi10->erro_status == 0) {
          throw new Exception($clredispi10->erro_msg);
        }

        // Consertar valida��o para s� entrar na condicional quando a natureza do objeto for igual a 1,
        if ($oDados10->naturezaobjeto == 1) {
          /**
           * Selecionar informa��es do registro 11
           */

          $sSql = "SELECT DISTINCT infocomplementaresinstit.si09_codorgaotce AS codOrgaoResp,
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
								END AS codunidadesubresp
						 FROM db_departorg
						 JOIN infocomplementares ON si08_anousu = db01_anousu
						 AND si08_instit = " . db_getsession('DB_instit') . "
						 JOIN orcunidade ON db01_orgao=o41_orgao
						 AND db01_unidade = o41_unidade
						 AND db01_anousu = o41_anousu
						 JOIN orcorgao ON o40_orgao = o41_orgao
						 AND o40_anousu = o41_anousu
						 WHERE db01_coddepto=l20_codepartamento
							 AND db01_anousu = " . db_getsession('DB_anousu') . "
						 LIMIT 1) AS codUnidadeSubResp,
						   pctipocompratribunal.l44_codigotribunal AS tipoProcesso,
						   liclicita.l20_anousu AS exercicioProcesso,
						   liclicita.l20_edital AS nroProcesso,
						   obrasdadoscomplementareslote.db150_sequencial as sequencial,
						   obrasdadoscomplementareslote.db150_codobra as codObraLocal,
						   obrasdadoscomplementareslote.db150_classeobjeto as classeObjeto,
						   obrasdadoscomplementareslote.db150_atividadeobra as tipoAtividadeObra,
						   case when obrasdadoscomplementareslote.db150_atividadeservico is null then 0
                    else obrasdadoscomplementareslote.db150_atividadeservico end as tipoAtividadeServico,
						   obrasdadoscomplementareslote.db150_descratividadeservico as dscAtividadeServico,
						   obrasdadoscomplementareslote.db150_atividadeservicoesp as tipoAtividadeServEspecializado,
						   obrasdadoscomplementareslote.db150_descratividadeservicoesp as dscAtividadeServEspecializado,
						   orcdotacao.o58_funcao AS codFuncao,
						   orcdotacao.o58_subfuncao AS codSubFuncao,
						   CASE WHEN db150_grupobempublico <> 99 THEN db150_subgrupobempublico ELSE '9900' END AS codBemPublico,
						   obrasdadoscomplementareslote.db150_planilhatce
                        FROM liclicita
                        INNER JOIN liclicitem ON (liclicita.l20_codigo=liclicitem.l21_codliclicita)
                        INNER JOIN pcprocitem ON (liclicitem.l21_codpcprocitem=pcprocitem.pc81_codprocitem)
                        LEFT JOIN pcdotac ON (pcprocitem.pc81_solicitem=pcdotac.pc13_codigo)
                        INNER JOIN cflicita ON (cflicita.l03_codigo = liclicita.l20_codtipocom)
                        INNER JOIN pctipocompratribunal ON (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
                        INNER JOIN db_depart ON l20_codepartamento = coddepto
                        INNER JOIN db_departorg ON db01_coddepto = coddepto AND db01_anousu = " . db_getsession('DB_anousu') . "
                        INNER JOIN db_config ON (instit=codigo)
                        INNER JOIN orcorgao ON o40_instit = codigo
                        INNER JOIN orcdotacao on (o58_anousu, o58_orgao)=(o40_anousu, o40_orgao) and o58_anousu=l20_anousu
                        INNER JOIN orcunidade ON db01_orgao=o41_orgao AND db01_unidade = o41_unidade AND db01_anousu = o41_anousu
                        LEFT JOIN infocomplementaresinstit ON db_config.codigo = infocomplementaresinstit.si09_instit
                        INNER JOIN liclancedital ON liclancedital.l47_liclicita = liclicita.l20_codigo
                        INNER JOIN obrascodigos on obrascodigos.db151_liclicita = liclancedital.l47_liclicita
                        INNER JOIN obrasdadoscomplementareslote ON db151_codigoobra = db150_codobra
					WHERE db_config.codigo= " . db_getsession('DB_instit') . " AND liclicita.l20_edital = " . $oDados10->nroprocesso . "
						AND pctipocompratribunal.l44_sequencial IN (100, 101, 102, 103, 106)
                        ORDER BY obrasdadoscomplementareslote.db150_sequencial";

          $rsResult11 = db_query($sSql);
          $aDadosAgrupados11 = array();
          // echo $sSql;
          // db_criatabela($rsResult11);
          // $iNumRows = $oDados10->l20_usaregistropreco == 'f' ? 1 : pg_num_rows($rsResult11);

          for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {

            $oResult11 = db_utils::fieldsMemory($rsResult11, $iCont11);
            $sHash11 = $oResult11->tiporegistro . $oResult11->codorgaoresp . $oResult11->codunidadesubresp . $oResult11->exercicioprocesso .
              $oResult11->nroprocesso . $oResult11->tipoprocesso . $oResult11->classeobjeto . $oResult11->tipoatividadeobra . $oResult11->tipoatividadeservico .
              $oResult11->tipoatividadeservespecializado . $oResult11->codbempublico;

            if ($oDados10->l20_usaregistropreco == 't') {
              $sHash11 .= $oResult11->codfuncao . $oResult11->codsubfuncao;
            }

            /**
             * @todo Corrigir busca pela fun��o e subfun��o
             */

            if (!isset($aDadosAgrupados11[$sHash11])) {

              $clredispi11 = new cl_redispi112024();
              $clredispi11->si184_tiporegistro = 11;//1
              $clredispi11->si184_codorgaoresp = $oResult11->codorgaoresp;//2
              if (db_gettipoinstit(db_getsession('DB_instit')) == "51") {
                  $clredispi11->si184_codunidadesubresp = '';//3
                  $clredispi11->si184_codunidadesubrespestadual = $oResult11->codunidadesubrespestadual;//4
              }else {
                  $clredispi11->si184_codunidadesubresp = $oResult11->codunidadesubresp;//3
                  $clredispi11->si184_codunidadesubrespestadual = ""; //4
              }
              $clredispi11->si184_exercicioprocesso = $oResult11->exercicioprocesso;//5
              $clredispi11->si184_nroprocesso = $oResult11->nroprocesso;//6
              $clredispi11->si184_codobralocal = $oResult11->codobralocal;//7
              $clredispi11->si184_tipoprocesso = $oResult11->tipoprocesso;//8
              $clredispi11->si184_classeobjeto = intval($oResult11->classeobjeto);//9
              $clredispi11->si184_tipoatividadeobra = $oResult11->tipoatividadeobra;//10
              $clredispi11->si184_tipoatividadeservico = $oResult11->tipoatividadeservico;//11
              $clredispi11->si184_dscatividadeservico = $oResult11->dscatividadeservico;//12
              $clredispi11->si184_tipoatividadeservespecializado = $oResult11->tipoatividadeservespecializado;//13
              $clredispi11->si184_dscatividadeservespecializado = $oResult11->dscatividadeservespecializado;//14
              $clredispi11->si184_codfuncao = $oResult11->codfuncao;//15
              $clredispi11->si184_codsubfuncao = $oResult11->codsubfuncao;//16
              $clredispi11->si184_codbempublico = $oResult11->codbempublico;//17
              $clredispi11->si184_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];//18
              $clredispi11->si184_reg10 = $clredispi10->si183_sequencial; // chave estrangeira
              $clredispi11->si184_instit = db_getsession("DB_instit");
              $clredispi11->si184_utilizacaoplanilhamodelo = $oResult11->db150_planilhatce;
              $clredispi11->incluir(null);
              if ($clredispi11->erro_status == 0) {
                throw new Exception($clredispi11->erro_msg);
              }
              $aDadosAgrupados11[$sHash11] = $clredispi11;
            }
          }

          /*
				* Sele��o dos registros 12 do RALIC
				*
				* */

          $sSql12 = "
					SELECT DISTINCT infocomplementaresinstit.si09_codorgaotce AS codOrgaoResp,
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
								END AS codunidadesubresp
						 FROM db_departorg
						 JOIN infocomplementares ON si08_anousu = db01_anousu
						 AND si08_instit = " . db_getsession('DB_instit') . "
						 JOIN orcunidade ON db01_orgao=o41_orgao
						 AND db01_unidade = o41_unidade
						 AND db01_anousu = o41_anousu
						 JOIN orcorgao ON o40_orgao = o41_orgao
						 AND o40_anousu = o41_anousu
						 WHERE db01_coddepto=l20_codepartamento
							 AND db01_anousu = " . db_getsession('DB_anousu') . "
						 LIMIT 1) AS codUnidadeSubResp,
						   '' AS codUnidadeSubRespEstadual,
						   liclicita.l20_anousu AS exercicioProcesso,
						   liclicita.l20_edital AS nroProcesso,
						   obrasdadoscomplementareslote.db150_codobra AS codObraLocal,
						   obrasdadoscomplementareslote.db150_logradouro AS logradouro,
						   obrasdadoscomplementareslote.db150_numero AS numero,
						   obrasdadoscomplementareslote.db150_bairro AS bairro,
						   cadendermunicipio.db72_descricao AS cidade,
						   obrasdadoscomplementareslote.db150_distrito AS distrito,
						   obrasdadoscomplementareslote.db150_cep AS cep,
						   obrasdadoscomplementareslote.db150_latitude AS latitude,
						   obrasdadoscomplementareslote.db150_longitude AS longitude,
               CASE WHEN db150_grupobempublico <> 99 THEN db150_subgrupobempublico ELSE '9900' END AS codBemPublico
					FROM liclicita
					INNER JOIN cflicita ON (cflicita.l03_codigo = liclicita.l20_codtipocom)
					INNER JOIN pctipocompratribunal ON (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
					INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
					LEFT JOIN infocomplementaresinstit ON db_config.codigo = infocomplementaresinstit.si09_instit
					INNER JOIN liclancedital ON liclancedital.l47_liclicita = liclicita.l20_codigo
					INNER JOIN obrascodigos on obrascodigos.db151_liclicita = liclancedital.l47_liclicita
					INNER JOIN obrasdadoscomplementareslote ON obrascodigos.db151_codigoobra = obrasdadoscomplementareslote.db150_codobra
					INNER JOIN cadendermunicipio on obrasdadoscomplementareslote.db150_municipio = db72_sequencial
					WHERE db_config.codigo= " . db_getsession('DB_instit') . " AND liclicita.l20_edital = " . $oDados10->nroprocesso . "
						AND pctipocompratribunal.l44_sequencial IN (100, 101, 102, 103, 106)
				";
          $rsResult12 = db_query($sSql12);

          $aDadosAgrupados12 = array();
          for ($iCont12 = 0; $iCont12 < pg_num_rows($rsResult12); $iCont12++) {

            $oResult12 = db_utils::fieldsMemory($rsResult12, $iCont12);
            $sHash12 = $oResult12->tiporegistro . $oResult12->codorgaoresp . $oResult12->codunidadesubresp . $oResult12->codunidadesubrespestadual .
              $oResult12->exercicioprocesso . $oResult12->nroprocesso . $oResult12->codobralocal . $oResult12->cep;

            //if (!isset($aDadosAgrupados12[$sHash12])) {

            $clredispi12 = new cl_redispi122024();
            $clredispi12->si185_tiporegistro = 12;
            $clredispi12->si185_codorgaoresp = $oResult12->codorgaoresp;
            if (db_gettipoinstit(db_getsession('DB_instit')) == "51") {
              $clredispi12->si185_codunidadesubresp = '';
              $clredispi12->si185_codunidadesubrespestadual = $oResult12->codunidadesubrespestadual;
            }else {
              $clredispi12->si185_codunidadesubresp = $oResult12->codunidadesubresp;
              $clredispi12->si185_codunidadesubrespestadual = "";
            }
            $clredispi12->si185_exercicioprocesso = $oResult12->exercicioprocesso;
            $clredispi12->si185_nroprocesso = $oResult12->nroprocesso;
            $clredispi12->si185_codobralocal = $oResult12->codobralocal;
            $clredispi12->si185_logradouro = $oResult12->logradouro;
            $clredispi12->si185_numero = !$oResult12->numero ? 0 : $oResult12->numero;
            $clredispi12->si185_bairro = $oResult12->bairro;
            $clredispi12->si185_cidade = $oResult12->cidade;
            $clredispi12->si185_distrito = $oResult12->distrito;
            $clredispi12->si185_cep = $oResult12->cep;
            $clredispi12->si185_latitude = $oResult12->latitude;
            $clredispi12->si185_longitude = $oResult12->longitude;
            $clredispi12->si185_codbempublico = $oResult12->codbempublico;
            $clredispi12->si185_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $clredispi12->si185_reg10 = $clredispi10->si183_sequencial; // chave estrangeira
            $clredispi12->si185_instit = db_getsession("DB_instit");
            $clredispi12->incluir(null);
            if ($clredispi12->erro_status == 0) {
              throw new Exception($clredispi12->erro_msg);
            }
            $aDadosAgrupados12[$sHash12] = $clredispi12;
            //}
          }
        }
        //exit;
      }
    }

    db_fim_transacao();
    $oGerarREDISPI = new GerarREDISPI();
    $oGerarREDISPI->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarREDISPI->gerarDados();
  }
}
