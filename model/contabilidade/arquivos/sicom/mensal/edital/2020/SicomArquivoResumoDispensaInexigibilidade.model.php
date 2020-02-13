<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_redispi102020_classe.php");
require_once("classes/db_redispi112020_classe.php");
require_once("classes/db_redispi122020_classe.php");

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2020/GerarREDISPI.model.php");


/**
 * Resumo da Dsipensa ou Inexigibilidade
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
     *metodo para passar os dados das Acoes e Metas para o $this->aDados
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
            "bdi"
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
            "grauLatitude",
            "minutoLatitude",
            "segundoLatitude",
            "grauLongitude",
            "minutoLongitude",
            "segundoLongitude"
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
        $clredispi10 = new cl_redispi102020();
        $clredispi11 = new cl_redispi112020();
        $clredispi12 = new cl_redispi122020();


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

        $sSql = "SELECT DISTINCT '10' AS tipoRegistro,
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
                     AND si08_instit = ".db_getsession('DB_instit')."
                     JOIN orcunidade ON db01_orgao=o41_orgao
                     AND db01_unidade = o41_unidade
                     AND db01_anousu = o41_anousu
                     JOIN orcorgao ON o40_orgao = o41_orgao
                     AND o40_anousu = o41_anousu
                     WHERE db01_coddepto=l20_codepartamento AND db01_anousu=".db_getsession('DB_anousu')."
                     LIMIT 1) AS codUnidadeSubResp,
                                '0' AS codUnidadeSubRespEstadual,
                                liclicita.l20_anousu AS exercicioProcesso,
                                liclicita.l20_edital AS nroProcesso,
                                pctipocompratribunal.l44_codigotribunal AS tipoProcesso,
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
                                obrasdadoscomplementares.db150_bdi AS bdi,
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
                LEFT JOIN obrasdadoscomplementares ON obrasdadoscomplementares.db150_liclicita = liclicita.l20_codigo
                INNER JOIN liclancedital on liclancedital.l47_liclicita = liclicita.l20_codigo and liclancedital.l47_dataenvio = '".$this->sDataFinal."'
                WHERE db_config.codigo = ".db_getsession('DB_instit')."
                    AND pctipocompratribunal.l44_sequencial IN (100, 101, 102, 103)
    
";
    $rsResult10 = db_query($sSql);

    /**
     * registro 10
     */
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

        $clredispi10 = new cl_redispi102020();

        $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

        $clredispi10->si183_tiporegistro = 10;
        $clredispi10->si183_codorgaoresp          = $oDados10->codorgaoresp;
        $clredispi10->si183_codunidadesubresp = $oDados10->codunidadesubresp;
        $clredispi10->si183_codunidadesubrespestadual = $oDados10->codunidadesubrespestadual;
        $clredispi10->si183_exercicioprocesso = $oDados10->exercicioprocesso;
        $clredispi10->si183_nroprocesso = $oDados10->nroprocesso;
        $clredispi10->si183_tipoprocesso = $oDados10->tipoprocesso;
        $clredispi10->si183_tipocadastradodispensainexigibilidade = $oDados10->tipocadastradodispensainexigibilidade;
        $clredispi10->si183_dsccadastrolicitatorio = $oDados10->dsccadastrolicitatorio;
        $clredispi10->si183_dtabertura = $oDados10->dtabertura;
        $clredispi10->si183_naturezaobjeto = $oDados10->naturezaobjeto;
        $clredispi10->si183_objeto = $oDados10->objeto;
        $clredispi10->si183_justificativa = $oDados10->justificativa;
        $clredispi10->si183_razao = $oDados10->razao;
        $clredispi10->si183_vlrecurso = $oDados10->vlrecurso == null ? 0 : $oDados10->vlrecurso;
        $clredispi10->si183_bdi = $oDados10->bdi;
        $clredispi10->si183_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $clredispi10->si183_instit = db_getsession("DB_instit");

        $clredispi10->incluir(null);
        if ($clredispi10->erro_status == 0) {
          throw new Exception($clredispi10->erro_msg);
        }

        // Consertar validação para só entrar na condicional quando a natureza do objeto for igual a 1,
        if($oDados10->naturezaobjeto == 1){
            /**
            * Selecionar informações do registro 11
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
                     AND si08_instit = " .db_getsession('DB_instit'). "
                     JOIN orcunidade ON db01_orgao=o41_orgao
                     AND db01_unidade = o41_unidade
                     AND db01_anousu = o41_anousu
                     JOIN orcorgao ON o40_orgao = o41_orgao
                     AND o40_anousu = o41_anousu
                     WHERE db01_coddepto=l20_codepartamento
                         AND db01_anousu = " .db_getsession('DB_anousu'). "
                     LIMIT 1) AS codUnidadeSubResp,
                       pctipocompratribunal.l44_codigotribunal AS tipoProcesso,
                       liclicita.l20_anousu AS exercicioProcesso,
                       liclicita.l20_edital AS nroProcesso,
                       obrasdadoscomplementares.db150_codobra as codObraLocal,
                       obrasdadoscomplementares.db150_classeobjeto as classeObjeto,
                       obrasdadoscomplementares.db150_atividadeobra as tipoAtividadeObra,
                       obrasdadoscomplementares.db150_atividadeservico as tipoAtividadeServico,
                       obrasdadoscomplementares.db150_descratividadeservico as dscAtividadeServico,
                       obrasdadoscomplementares.db150_atividadeservicoesp as tipoAtividadeServEspecializado,
                       obrasdadoscomplementares.db150_descratividadeservicoesp as dscAtividadeServEspecializado,
                       orcdotacao.o58_funcao AS codFuncao,
       				   orcdotacao.o58_subfuncao AS codSubFuncao,
                       obrasdadoscomplementares.db150_subgrupobempublico as codBemPublico
                FROM liclicita
                INNER JOIN liclicitem ON (liclicita.l20_codigo=liclicitem.l21_codliclicita)
				INNER JOIN pcprocitem ON (liclicitem.l21_codpcprocitem=pcprocitem.pc81_codprocitem)
				INNER JOIN pcdotac ON (pcprocitem.pc81_solicitem=pcdotac.pc13_codigo)
				INNER JOIN orcdotacao ON (pcdotac.pc13_anousu=orcdotacao.o58_anousu AND pcdotac.pc13_coddot=orcdotacao.o58_coddot)
                INNER JOIN cflicita ON (cflicita.l03_codigo = liclicita.l20_codtipocom)
                INNER JOIN pctipocompratribunal ON (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
                INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
                LEFT JOIN infocomplementaresinstit ON db_config.codigo = infocomplementaresinstit.si09_instit
                INNER JOIN liclancedital ON liclancedital.l47_liclicita = liclicita.l20_codigo and liclancedital.l47_dataenvio = '".$this->sDataFinal."'
                INNER JOIN obrasdadoscomplementares ON obrasdadoscomplementares.db150_liclicita = liclicita.l20_codigo
                WHERE db_config.codigo= ".db_getsession('DB_instit')."
                    AND pctipocompratribunal.l44_sequencial IN (100, 101, 102, 103)";
            $rsResult11 = db_query($sSql);
            $aDadosAgrupados11 = array();
            for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {

                $oResult11 = db_utils::fieldsMemory($rsResult11, $iCont11);
                $sHash11 = $oResult11->tiporegistro . $oResult11->codorgaoresp . $oResult11->codunidadesubresp . $oResult11->exercicioprocesso .
                $oResult11->nroprocesso . $oResult11->tipoprocesso . $oResult11->classeobjeto . $oResult11->tipoatividadeobra . $oResult11->tipoatividadeservico .
                $oResult11->tipoatividadeservespecializado . $oResult11->codfuncao . $oResult11->codsubfuncao;

                if (!isset($aDadosAgrupados11[$sHash11])) {

                    $clredispi11 = new cl_redispi112020();

                    $clredispi11->si184_tiporegistro = 11;
                    $clredispi11->si184_codorgaoresp = $oResult11->codorgaoresp;
                    $clredispi11->si184_codunidadesubresp = $oResult11->codunidadesubresp;
                    $clredispi11->si184_codunidadesubrespestadual = $oResult11->codunidadesubrespestadual;
                    $clredispi11->si184_exercicioprocesso = $oResult11->exercicioprocesso;
                    $clredispi11->si184_nroprocesso = $oResult11->nroprocesso;
                    $clredispi11->si184_codobralocal = $oResult11->codobralocal;
                    $clredispi11->si184_tipoprocesso = $oResult11->tipoprocesso;
                    $clredispi11->si184_classeobjeto = intval($oResult11->classeobjeto);
                    $clredispi11->si184_tipoatividadeobra = $oResult11->tipoatividadeobra;
                    $clredispi11->si184_tipoatividadeservico = $oResult11->tipoatividadeservico;
                    $clredispi11->si184_dscatividadeservico = $oResult11->dscatividadeservico;
                    $clredispi11->si184_tipoatividadeservespecializado = $oResult11->tipoatividadeservespecializado;
                    $clredispi11->si184_dscatividadeservespecializado = $oResult11->dscatividadeservespecializado;
                    $clredispi11->si184_codfuncao = $oResult11->codfuncao;
                    $clredispi11->si184_codsubfuncao = $oResult11->codsubfuncao;
                    $clredispi11->si184_codbempublico = $oResult11->codbempublico;
                    $clredispi11->si184_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                    $clredispi11->si184_reg10 = $clredispi10->si183_sequencial;// chave estrangeira
                    $clredispi11->si184_instit = db_getsession("DB_instit");

                    $clredispi11->incluir(null);
                    if ($clredispi11->erro_status == 0) {
                        throw new Exception($clredispi11->erro_msg);
                    }
                    $aDadosAgrupados11[$sHash11] = $clredispi11;

                }

            }

            /*
            * Seleção dos registros 12 do RALIC
            *
            * */

            $sSql = "
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
                     AND si08_instit = ".db_getsession('DB_instit')."
                     JOIN orcunidade ON db01_orgao=o41_orgao
                     AND db01_unidade = o41_unidade
                     AND db01_anousu = o41_anousu
                     JOIN orcorgao ON o40_orgao = o41_orgao
                     AND o40_anousu = o41_anousu
                     WHERE db01_coddepto=l20_codepartamento
                         AND db01_anousu = ".db_getsession('DB_anousu')."
                     LIMIT 1) AS codUnidadeSubResp,
                       '' AS codUnidadeSubRespEstadual,
                       liclicita.l20_anousu AS exercicioProcesso,
                       liclicita.l20_edital AS nroProcesso,
                       obrasdadoscomplementares.db150_codobra AS codObraLocal,
                       obrasdadoscomplementares.db150_logradouro AS logradouro,
                       obrasdadoscomplementares.db150_numero AS numero,
                       obrasdadoscomplementares.db150_bairro AS bairro,
                       cadendermunicipio.db72_descricao AS cidade,
                       obrasdadoscomplementares.db150_cep AS cep,
                       obrasdadoscomplementares.db150_grauslatitude AS grauslatitude,
                       obrasdadoscomplementares.db150_minutolatitude AS minutolatitude,
                       obrasdadoscomplementares.db150_segundolatitude AS segundolatitude,
                       obrasdadoscomplementares.db150_grauslongitude AS grauslongitude,
                       obrasdadoscomplementares.db150_minutolongitude AS minutolongitude,
                       obrasdadoscomplementares.db150_segundolongitude AS segundolongitude
                FROM liclicita
                INNER JOIN cflicita ON (cflicita.l03_codigo = liclicita.l20_codtipocom)
                INNER JOIN pctipocompratribunal ON (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
                INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
                LEFT JOIN infocomplementaresinstit ON db_config.codigo = infocomplementaresinstit.si09_instit
                INNER JOIN liclancedital ON liclancedital.l47_liclicita = liclicita.l20_codigo and liclancedital.l47_dataenvio = '".$this->sDataFinal."'
                INNER JOIN obrasdadoscomplementares ON obrasdadoscomplementares.db150_liclicita = liclicita.l20_codigo
                INNER JOIN cadendermunicipio on obrasdadoscomplementares.db150_municipio = db72_sequencial
                WHERE db_config.codigo= ".db_getsession('DB_instit')."
                    AND pctipocompratribunal.l44_sequencial IN (100, 101, 102, 103);
    ";
            $rsResult12 = db_query($sSql);

            $aDadosAgrupados12 = array();
            for ($iCont12 = 0; $iCont12 < pg_num_rows($rsResult12); $iCont12++) {

                $oResult12 = db_utils::fieldsMemory($rsResult12, $iCont12);
                $sHash12 = $oResult12->tiporegistro . $oResult12->codorgaoresp . $oResult12->codunidadesubresp . $oResult12->codunidadesubrespestadual .
                $oResult12->exercicioprocesso . $oResult12->nroprocesso . $oResult12->codobralocal . $oResult12->cep;

                if (!isset($aDadosAgrupados12[$sHash12])) {

                    $clredispi12 = new cl_redispi122020();

                    $clredispi12->si185_tiporegistro = 12;
                    $clredispi12->si185_codorgaoresp = $oResult12->codorgaoresp;
                    $clredispi12->si185_codunidadesubresp = $oResult12->codunidadesubresp;
                    $clredispi12->si185_codunidadesubrespestadual = $oResult12->codunidadesubrespestadual;
                    $clredispi12->si185_exercicioprocesso = $oResult12->exercicioprocesso;
                    $clredispi12->si185_nroprocesso = $oResult12->nroprocesso;
                    $clredispi12->si185_codobralocal = $oResult12->codobralocal;
                    $clredispi12->si185_logradouro = $oResult12->logradouro;
                    $clredispi12->si185_numero = $oResult12->numero;
                    $clredispi12->si185_bairro = $oResult12->bairro;
                    $clredispi12->si185_cidade = $oResult12->cidade;
                    $clredispi12->si185_cep = $oResult12->cep;
                    $clredispi12->si185_graulatitude = $oResult12->grauslatitude;
                    $clredispi12->si185_minutolatitude = $oResult12->minutolatitude;
                    $clredispi12->si185_segundolatitude = $oResult12->segundolatitude;
                    $clredispi12->si185_graulongitude = $oResult12->grauslongitude;
                    $clredispi12->si185_minutolongitude = $oResult12->minutolongitude;
                    $clredispi12->si185_segundolongitude = $oResult12->segundolongitude;
                    $clredispi12->si185_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                    $clredispi12->si185_reg10 = $clredispi10->si183_sequencial;// chave estrangeira
                    $clredispi12->si185_instit = db_getsession("DB_instit");

                    $clredispi12->incluir(null);
                    if ($clredispi12->erro_status == 0) {
                        throw new Exception($clredispi12->erro_msg);
                    }
                    $aDadosAgrupados12[$sHash12] = $clredispi12;

                }

            }

        }
    }


    db_fim_transacao();

    $oGerarREDISPI = new GerarREDISPI();
    $oGerarREDISPI->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarREDISPI->gerarDados();


  }

}
