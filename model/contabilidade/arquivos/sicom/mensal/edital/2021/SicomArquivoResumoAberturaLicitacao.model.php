<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_ralic102021_classe.php");
require_once("classes/db_ralic112021_classe.php");
require_once("classes/db_ralic122021_classe.php");

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2021/GerarRALIC.model.php");

/**
 * Resumo da Abertura da licitacao Sicom Acompanhamento Mensal
 * @author Victor Felipe
 * @package Patrimonial
 */
class SicomArquivoResumoAberturaLicitacao extends SicomArquivoBase implements iPadArquivoBaseCSV
{

  /**
   *
   * Codigo do layout. (db_layouttxt.db50_codigo)
   * @var Integer
   */
  protected $iCodigoLayout = 0;

  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'RALIC';

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
   *metodo para passar os dados das Acoes e Metas pada o $this->aDados
   */
  public function getCampos()
  {

    $aElementos[10] = array(
      "tipoRegistro",
      "codOrgaoResp",
      "codUnidadeSubResp",
      "codUnidadeSubRespEstadual",
      "exercicioLicitacao",
      "nroProcessoLicitatorio",
      "tipoCadastradoLicitacao",
      "dscCadastroLicitatorio",
      "codModalidadeLicitacao",
      "naturezaProcedimento",
      "nroEdital",
      "exercicioEdital",
      "dtPublicacaoEditalDO",
      "link",
      "tipoLicitacao",
      "naturezaObjeto",
      "objeto",
      "regimeExecucaoObras",
      "vlContratacao",
      "bdi",
      "mesExercicioRefOrc",
      "origemRecurso",
      "dscOrigemRecurso",
      "qtdLotes"
    );
    $aElementos[11] = array(
      "tipoRegistro",
      "codOrgaoResp",
      "codUnidadeSubResp",
      "codUnidadeSubRespEstadual",
      "exercicioLicitacao",
      "nroProcessoLicitatorio",
      "codObraLocal",
      "classeObjeto",
      "tipoAtividadeObra",
      "tipoAtividadeServico",
      "dscAtividadeServico",
      "tipoAtividadeServEspecializado",
      "dscAtividadeServEspecializado",
      "codFuncao",
      "codSubFuncao",
      "codBemPublico",
      "nrolote"
    );
    $aElementos[12] = array(
      "tipoRegistro",
      "codOrgaoResp",
      "codUnidadeSubResp",
      "codUnidadeSubRespEstadual",
      "exercicioProcesso",
      "nroProcessoLicitatorio",
      "codObraLocal",
      "logradouro",
      "numero",
      "bairro",
      "distrito",
      "municipio",
      "cep",
      "latitude",
      "longitude"
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
    $clralic10 = new cl_ralic102021();
    $clralic11 = new cl_ralic112021();
    $clralic12 = new cl_ralic122021();

    /**
     * excluir informacoes do mes selecioado para evitar duplicacao de registros
     */
    db_inicio_transacao();

    /**
     * registro 12
     */
    $result = db_query($clralic12->sql_query(null, "*", null, "si182_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si182_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clralic12->excluir(null, "si182_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si182_instit=" . db_getsession("DB_instit"));
      if ($clralic12->erro_status == 0) {
        throw new Exception($clralic12->erro_msg);
      }
    }

    /**
     * registro 11
     */
    $result = db_query($clralic11->sql_query(null, "*", null, "si181_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si181_instit=" . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clralic11->excluir(null, "si181_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si181_instit=" . db_getsession("DB_instit"));
      if ($clralic11->erro_status == 0) {
        throw new Exception($clralic11->erro_msg);
      }
    }

    /**
     * registro 10
     */
    $result = db_query($clralic10->sql_query(null, "*", null, "si180_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si180_instit=" . db_getsession("DB_instit")));

    if (pg_num_rows($result) > 0) {
      $clralic10->excluir(null, "si180_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si180_instit=" . db_getsession("DB_instit"));
      if ($clralic10->erro_status == 0) {
        throw new Exception($clralic10->erro_msg);
      }
    }


    $sSql = "SELECT DISTINCT '10' AS tipoRegistro,
                substr(si01_datacotacao, 6, 2)||substr(si01_datacotacao, 1, 4) as dataCotacao,
                codorgaoresp,
                codunidadesubresp,
                mediapercentual,
                exerciciolicitacao,
                nroProcessoLicitatorio,
                tipoCadastradoLicitacao,
                codmodalidadelicitacao,
                naturezaprocedimento,
                nroedital,
                exercicioedital,
                dtpublicacaoeditaldo,
                link,
                tipolicitacao,
                naturezaobjeto,
                objeto,
                regimeexecucaoobras,
                bdi,
                origemrecurso,
                dscorigemrecurso,
                sum(vlcontratacao) as vlContratacao,
                case when tipoJulgamento = 1 THEN 1 else qtdLotes end as qtdLotes
FROM
    (SELECT infocomplementaresinstit.si09_codorgaotce AS codOrgaoResp,
                     (CASE
                          WHEN pc80_criterioadjudicacao = 1 THEN round((sum(pc23_perctaxadesctabela)/count(pc23_orcamforne)),2)
                          WHEN pc80_criterioadjudicacao = 2 THEN round((sum(pc23_percentualdesconto)/count(pc23_orcamforne)),2)
                      END) AS mediapercentual,
                     ((sum(pc23_vlrun)/count(pc23_orcamforne)) * pc23_quant) AS vlContratacao,
                     si01_datacotacao,

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
          AND si08_instit = ".db_getsession('DB_instit')."
          JOIN orcunidade ON db01_orgao=o41_orgao
          AND db01_unidade=o41_unidade
          AND db01_anousu = o41_anousu
          JOIN orcorgao ON o40_orgao = o41_orgao
          AND o40_anousu = o41_anousu
          WHERE db01_coddepto=l20_codepartamento
              AND db01_anousu = ".db_getsession('DB_anousu')."
          LIMIT 1) AS codUnidadeSubResp,
                     liclicita.l20_anousu AS exercicioLicitacao,
                     liclicita.l20_edital AS nroProcessoLicitatorio,
                     1 AS tipoCadastradoLicitacao,
                     pctipocompratribunal.l44_codigotribunal AS codModalidadeLicitacao,
                     liclicita.l20_tipnaturezaproced AS naturezaProcedimento,
                     liclicita.l20_nroedital AS nroEdital,
                     liclicita.l20_exercicioedital AS exercicioEdital,
                     liclicita.l20_dtpublic AS dtPublicacaoEditalDO,
                     liclancedital.l47_linkpub AS LINK,
                     liclicita.l20_tipliticacao AS tipoLicitacao,
                     liclicita.l20_naturezaobjeto AS naturezaObjeto,
                     liclicita.l20_objeto AS Objeto,
                     liclicita.l20_tipojulg AS tipoJulgamento,
                     (SELECT count(*) FROM
                        (SELECT DISTINCT l04_descricao
                            FROM liclicitemlote
                            INNER JOIN liclicitem ON l21_codigo = l04_liclicitem
                            WHERE l21_codliclicita = l20_codigo) as countLotes) as qtdLotes,
                     CASE
                         WHEN liclicita.l20_naturezaobjeto in ('1', '7') THEN liclicita.l20_regimexecucao
                         ELSE 0
                     END AS regimeExecucaoObras,
                     obrasdadoscomplementares.db150_bdi AS bdi,
                     liclancedital.l47_origemrecurso AS origemRecurso,
                     liclancedital.l47_descrecurso AS dscOrigemRecurso
     FROM liclicita
     INNER JOIN cflicita ON (cflicita.l03_codigo = liclicita.l20_codtipocom)
     INNER JOIN pctipocompratribunal ON (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
     INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
     LEFT JOIN infocomplementaresinstit ON db_config.codigo = infocomplementaresinstit.si09_instit
     INNER JOIN liclancedital ON liclancedital.l47_liclicita = liclicita.l20_codigo
     INNER JOIN obrascodigos ON liclancedital.l47_liclicita = obrascodigos.db151_liclicita
     LEFT JOIN obrasdadoscomplementares ON obrasdadoscomplementares.db150_codobra = obrascodigos.db151_codigoobra
     JOIN liclicitem ON l21_codliclicita = l20_codigo
     JOIN pcprocitem ON pc81_codprocitem = l21_codpcprocitem
     JOIN pcproc ON pc80_codproc = pc81_codproc
     JOIN solicitem ON pc81_solicitem = pc11_codigo
     JOIN solicitempcmater ON pc11_codigo = pc16_solicitem
     JOIN pcmater ON pc16_codmater = pc01_codmater
     JOIN pcorcamitemproc ON pc81_codprocitem = pc31_pcprocitem
     JOIN pcorcamitem ON pc31_orcamitem = pc22_orcamitem
     JOIN pcorcamval ON pc22_orcamitem = pc23_orcamitem
     JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
     JOIN itemprecoreferencia ON pc23_orcamitem = si02_itemproccompra
     JOIN precoreferencia ON itemprecoreferencia.si02_precoreferencia = precoreferencia.si01_sequencial
     WHERE db_config.codigo= ".db_getsession('DB_instit')."
         AND pctipocompratribunal.l44_sequencial NOT IN ('100', '101', '102', '103', '106') and liclancedital.l47_dataenvio = '".$this->sDataFinal."'
         AND pc81_codproc IN (SELECT DISTINCT pc80_codproc
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
								   WHERE lic2.l20_nroedital = liclicita.l20_nroedital)
     GROUP BY si09_codorgaotce,
              pc80_criterioadjudicacao,
              l20_codepartamento,
              l20_codigo,
              l20_anousu,
              l20_edital,
              l44_codigotribunal,
              l20_tipnaturezaproced,
              l20_nroedital,
              l20_exercicioedital,
              l20_dtpublic,
              l47_linkpub,
              l20_tipliticacao,
              l20_naturezaobjeto,
              l20_objeto,
              l20_regimexecucao,
              bdi,
              pc01_codmater,
              l47_origemrecurso,
              l47_descrecurso,
              si01_datacotacao,
              pc23_quant) AS query
GROUP BY si01_datacotacao, codorgaoresp, codunidadesubresp, mediapercentual, exerciciolicitacao, nroProcessoLicitatorio,
         tipoCadastradoLicitacao, codmodalidadelicitacao, naturezaprocedimento, nroedital,
         exercicioedital, dtpublicacaoeditaldo, LINK, tipolicitacao, naturezaobjeto, objeto, bdi, regimeexecucaoobras,
         origemrecurso, dscorigemrecurso, qtdLotes, tipoJulgamento
         
ORDER BY nroprocessolicitatorio

                  ";
    $rsResult10 = db_query($sSql);

    /**
     * registro 10
     */ 
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $clralic10 = new cl_ralic102021();

      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $clralic10->si180_tiporegistro = 10;
      $clralic10->si180_codorgaoresp = $oDados10->codorgaoresp;
      $clralic10->si180_codunidadesubresp = $oDados10->codunidadesubresp;
      $clralic10->si180_codunidadesubrespestadual = $oDados10->codunidadesubrespestadual;
      $clralic10->si180_exerciciolicitacao = $oDados10->exerciciolicitacao;
      $clralic10->si180_nroprocessolicitatorio = $oDados10->nroprocessolicitatorio;
      $clralic10->si180_tipocadastradolicitacao = $oDados10->tipocadastradolicitacao;
      $clralic10->si180_dsccadastrolicitatorio = '';
      $clralic10->si180_codmodalidadelicitacao = $oDados10->codmodalidadelicitacao;
      $clralic10->si180_naturezaprocedimento = $oDados10->naturezaprocedimento;
      $clralic10->si180_nroedital = $oDados10->nroedital;
      $clralic10->si180_exercicioedital = $oDados10->exercicioedital ? $oDados10->exercicioedital: intval($oDados10->exerciciolicitacao);
      $clralic10->si180_dtpublicacaoeditaldo = $oDados10->dtpublicacaoeditaldo;
      $clralic10->si180_link = preg_replace("/\r|\n/", "", $oDados10->link);
      $clralic10->si180_tipolicitacao = $oDados10->codmodalidadelicitacao == '4' ? '' : $oDados10->tipolicitacao;
      $clralic10->si180_naturezaobjeto = $oDados10->naturezaobjeto;
      $clralic10->si180_objeto = substr($this->removeCaracteres($oDados10->objeto), 0, 500);
      $clralic10->si180_regimeexecucaoobras = $oDados10->regimeexecucaoobras;
      $clralic10->si180_vlcontratacao = $oDados10->vlcontratacao;
      $clralic10->si180_bdi = $oDados10->bdi;
      $clralic10->si180_mesexercicioreforc = $oDados10->datacotacao;
      $clralic10->si180_origemrecurso = $oDados10->origemrecurso;
      $clralic10->si180_dscorigemrecurso = $oDados10->dscorigemrecurso;
      $clralic10->si180_qtdlotes = $oDados10->qtdlotes;
      $clralic10->si180_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clralic10->si180_instit = db_getsession("DB_instit");

      $clralic10->incluir(null);

      if ($clralic10->erro_status == 0) {
        throw new Exception($clralic10->erro_msg);
      }

      if($oDados10->naturezaobjeto == 1){
           /**
           * Selecionar informações do registro 11
           * @todo checar a obrigatoriedade do pcdotac
           */
		  $sSql11 = "
              SELECT (CASE
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
                    END) AS codunidadesubresp,
                  liclicita.l20_anousu AS exercicioLicitacao,
                  liclicita.l20_edital AS nroProcessoLicitatorio,
                  obrasdadoscomplementareslote.db150_codobra AS codObraLocal,
                  obrasdadoscomplementareslote.db150_classeobjeto AS classeObjeto,
                  obrasdadoscomplementareslote.db150_atividadeobra AS tipoAtividadeObra,
                  obrasdadoscomplementareslote.db150_atividadeservico AS tipoAtividadeServico,
                  obrasdadoscomplementareslote.db150_descratividadeservico AS dscAtividadeServico,
                  obrasdadoscomplementareslote.db150_atividadeservicoesp AS tipoAtividadeServEspecializado,
                  obrasdadoscomplementareslote.db150_descratividadeservicoesp AS dscAtividadeServEspecializado,
                  obrasdadoscomplementareslote.db150_sequencial AS dscAtividadeServEspecializado,
                  orcdotacao.o58_funcao AS codFuncao,
                  orcdotacao.o58_subfuncao AS codSubFuncao,
                  obrasdadoscomplementareslote.db150_subgrupobempublico AS codBemPublico
                FROM liclicita
                INNER JOIN liclicitem ON (liclicita.l20_codigo=liclicitem.l21_codliclicita)
                INNER JOIN pcprocitem ON (liclicitem.l21_codpcprocitem=pcprocitem.pc81_codprocitem)
                INNER JOIN pcdotac ON (pcprocitem.pc81_solicitem=pcdotac.pc13_codigo)
                INNER JOIN orcdotacao ON (pcdotac.pc13_anousu=orcdotacao.o58_anousu
                                          AND pcdotac.pc13_coddot=orcdotacao.o58_coddot)
                INNER JOIN cflicita ON (cflicita.l03_codigo = liclicita.l20_codtipocom)
                INNER JOIN pctipocompratribunal ON (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
                INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
                INNER JOIN db_depart ON codigo = instit
                INNER JOIN db_departorg ON db01_coddepto = coddepto AND db01_anousu = ".db_getsession('DB_anousu')." AND db01_coddepto=l20_codepartamento
                INNER JOIN orcunidade ON db01_orgao=o41_orgao AND db01_unidade = o41_unidade AND db01_anousu = o41_anousu
                INNER JOIN orcorgao ON o40_orgao = o41_orgao AND o40_anousu = o41_anousu
                LEFT JOIN infocomplementaresinstit ON db_config.codigo = infocomplementaresinstit.si09_instit
                INNER JOIN liclancedital ON liclancedital.l47_liclicita = liclicita.l20_codigo
                INNER JOIN obrascodigos ON obrascodigos.db151_liclicita = liclancedital.l47_liclicita
                INNER JOIN obrasdadoscomplementareslote ON db150_codobra = obrascodigos.db151_codigoobra
              WHERE db_config.codigo = ".db_getsession('DB_instit')."
              AND l03_pctipocompratribunal NOT IN ('100',
                                                    '101',
                                                    '102',
                                                    '103',
                                                    '106')
              AND liclicita.l20_edital = $oDados10->nroprocessolicitatorio 
				    ORDER BY obrasdadoscomplementareslote.db150_codobra"; 

      $rsResult11 = db_query($sSql11);

		      $aDadosAgrupados11 = array();

          if(pg_numrows($rsResult11)){

              for ($iCont11 = 0; $iCont11 < intval($oDados10->qtdlotes); $iCont11++) {

                  $oResult11 = db_utils::fieldsMemory($rsResult11, 0);
                  $sHash11 = '11' . $oResult11->codorgaoresp . $oResult11->codunidadesubresp . $oResult11->codunidadesubrespestadual .
                  $oResult11->exerciciolicitacao . $oResult11->nroprocessolicitatorio . $oResult11->classeobjeto . $oResult11->tipoatividadeobra . $oResult11->tipoatividadeservico .
                  $oResult11->tipoatividadeservespecializado . $oResult11->codfuncao . $oResult11->codsubfuncao . $oResult11->codobralocal; // Foi adicionado a chave codobralocal

                  if (!isset($aDadosAgrupados11[$sHash11])) {

                      $clralic11 = new cl_ralic112021();

                      $clralic11->si181_tiporegistro = 11;
                      $clralic11->si181_codorgaoresp = $oResult11->codorgaoresp;
                      $clralic11->si181_codunidadesubresp = $oResult11->codunidadesubresp;
                      $clralic11->si181_codunidadesubrespestadual = $oResult11->codunidadesubrespestadual;
                      $clralic11->si181_exerciciolicitacao = $oResult11->exerciciolicitacao;
                      $clralic11->si181_nroprocessolicitatorio = $oResult11->nroprocessolicitatorio;
                      $clralic11->si181_codobralocal = $oResult11->codobralocal;
                      $clralic11->si181_classeobjeto = $oResult11->classeobjeto;
                      $clralic11->si181_tipoatividadeobra = $oResult11->tipoatividadeobra;
                      $clralic11->si181_tipoatividadeservico = $oResult11->tipoatividadeservico == 0 ? '' : $oResult11->tipoatividadeservico;
                      $clralic11->si181_dscatividadeservico = $oResult11->dscatividadeservico;
                      $clralic11->si181_tipoatividadeservespecializado = $oResult11->tipoatividadeservespecializado;
                      $clralic11->si181_dscatividadeservespecializado = $oResult11->dscatividadeservespecializado;
                      $clralic11->si181_codfuncao = $oResult11->codfuncao;
                      $clralic11->si181_codsubfuncao = $oResult11->codsubfuncao;
                      $clralic11->si181_codbempublico = $oResult11->codbempublico ? $oResult11->codbempublico : 9900;
                      $clralic11->si181_nrolote = $oDados10->qtdlotes == '1' ? '' : $iCont11 + 1; 
                      $clralic11->si181_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                      $clralic11->si181_reg10 = $clralic10->si180_sequencial;
                      $clralic11->si181_instit = db_getsession("DB_instit");

                      $clralic11->incluir(null);
                      
                      if ($clralic11->erro_status == 0) {
                          throw new Exception($clralic11->erro_msg);
                      }
                  
                      $aDadosAgrupados11[$sHash11] = $clralic11;

                  }

              }
          }
          /*
           * Seleção dos registros 12 do RALIC
           *
           * */

        $sSql12 = "
                SELECT DISTINCT '12' AS tipoRegistro,
                       infocomplementaresinstit.si09_codorgaotce AS codOrgaoResp,
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
                     AND si08_instit = ".db_getsession('DB_instit')."
                     JOIN orcunidade ON db01_orgao=o41_orgao
                     AND db01_unidade = o41_unidade
                     AND db01_anousu = o41_anousu
                     JOIN orcorgao ON o40_orgao = o41_orgao
                     AND o40_anousu = o41_anousu
                     WHERE db01_coddepto=l20_codepartamento
                         AND db01_anousu = ".db_getsession('DB_anousu')."
                     LIMIT 1) AS codUnidadeSubResp,
                       liclicita.l20_anousu AS exercicioProcesso,
                       liclicita.l20_edital AS nroProcessoLicitatorio,
                       obrasdadoscomplementareslote.db150_codobra as codObraLocal,
                       obrasdadoscomplementareslote.db150_logradouro as logradouro,
                       obrasdadoscomplementareslote.db150_numero as numero,
                       obrasdadoscomplementareslote.db150_bairro as bairro,
                       obrasdadoscomplementareslote.db150_distrito as distrito,
                       db72_descricao AS municipio,
                       obrasdadoscomplementareslote.db150_cep as cep,
                       obrasdadoscomplementareslote.db150_latitude as latitude,
                       obrasdadoscomplementareslote.db150_longitude as longitude,
                       obrasdadoscomplementareslote.db150_subgrupobempublico AS codBemPublico
                FROM liclicita
                INNER JOIN cflicita ON (cflicita.l03_codigo = liclicita.l20_codtipocom)
                INNER JOIN pctipocompratribunal ON (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
                INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
                LEFT JOIN infocomplementaresinstit ON db_config.codigo = infocomplementaresinstit.si09_instit
                INNER JOIN liclancedital ON liclancedital.l47_liclicita = liclicita.l20_codigo
                INNER JOIN obrascodigos on obrascodigos.db151_liclicita = liclancedital.l47_liclicita
				        INNER JOIN obrasdadoscomplementareslote ON obrascodigos.db151_codigoobra = obrasdadoscomplementareslote.db150_codobra
                INNER JOIN cadendermunicipio on db72_sequencial = db150_municipio
                WHERE db_config.codigo= ".db_getsession('DB_instit')."
                    AND pctipocompratribunal.l44_sequencial NOT IN ('100',
                                                                    '101',
                                                                    '102', '103', '106') and liclicita.l20_edital = $oDados10->nroprocessolicitatorio
    ";

        	$rsResult12 = db_query($sSql12);

            $aDadosAgrupados12 = array();
            for ($iCont12 = 0; $iCont12 < pg_num_rows($rsResult12); $iCont12++) {

                $oResult12 = db_utils::fieldsMemory($rsResult12, $iCont12);
                $sHash12 = '12' . $oResult12->codorgaoresp . $oResult12->codunidadesubresp . $oResult12->codunidadesubrespestadual .
                $oResult12->exercicioprocesso . $oResult12->nroprocessolicitatorio . $oResult12->codobralocal . $oResult12->cep;

                if (!isset($aDadosAgrupados12[$sHash12])) {

                    $clralic12 = new cl_ralic122021();

                    $clralic12->si182_tiporegistro = 12;
                    $clralic12->si182_codorgaoresp = $oResult12->codorgaoresp;
                    $clralic12->si182_codunidadesubresp = $oResult12->codunidadesubresp;
                    $clralic12->si182_codunidadesubrespestadual = $oResult12->codunidadesubrespestadual != '' ? $oResult12->codunidadesubrespestadual : '0';
                    $clralic12->si182_exercicioprocesso = $oResult12->exercicioprocesso;
                    $clralic12->si182_nroprocessolicitatorio = $oResult12->nroprocessolicitatorio;
                    $clralic12->si182_codobralocal = $oResult12->codobralocal;
                    $clralic12->si182_logradouro = $oResult12->logradouro;
                    $clralic12->si182_numero = $oResult12->numero;
                    $clralic12->si182_bairro = $oResult12->bairro;
                    $clralic12->si182_distrito = $oResult12->distrito;
                    $clralic12->si182_municipio = $oResult12->municipio;
                    $clralic12->si182_cep = $oResult12->cep;
                    $clralic12->si182_latitude = $oResult12->latitude;
                    $clralic12->si182_longitude = $oResult12->longitude;
                    $clralic12->si182_codbempublico = $oResult12->codbempublico;
                    $clralic12->si182_nrolote = $oDados10->qtdlotes == '1' ? '' : $iCont11 + 1; 
                    $clralic12->si182_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                    $clralic12->si182_reg10 = $clralic10->si180_sequencial;// chave estrangeira
                    $clralic12->si182_instit = db_getsession("DB_instit");

                    $clralic12->incluir(null);

                    if ($clralic12->erro_status == 0) {
                        throw new Exception($clralic12->erro_msg);
                    }

                    $aDadosAgrupados12[$sHash12] = $clralic12;

                }
            }
        }
    }

    db_fim_transacao();

    $oGerarRALIC = new GerarRALIC();
    $oGerarRALIC->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarRALIC->gerarDados();

  }

}
