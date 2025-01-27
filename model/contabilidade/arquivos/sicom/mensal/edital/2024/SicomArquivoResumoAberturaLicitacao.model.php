<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_ralic102024_classe.php");
require_once("classes/db_ralic112024_classe.php");
require_once("classes/db_ralic122024_classe.php");

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2024/GerarRALIC.model.php");

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

    public function getTipoInstit(){

    }

    /**
     * metodo para passar os dados das Acoes e Metas pada o $this->aDados
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
        $clralic10 = new cl_ralic102024();
        $clralic11 = new cl_ralic112024();
        $clralic12 = new cl_ralic122024();

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


        $sSql = "SELECT distinct on (nroprocessolicitatorio) nroprocessolicitatorio, '10' AS tipoRegistro,
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
                case when tipoJulgamento = 1 THEN 1 else qtdLotes end as qtdLotes,
                l20_usaregistropreco,
                l20_leidalicitacao,
                l20_mododisputa,
                l20_recdocumentacao,
                l20_dataaberproposta,
                l20_orcsigiloso,
                si01_sequencial,
                (select sum (si02_vltotalprecoreferencia) from itemprecoreferencia where si02_precoreferencia = si01_sequencial) as valortotal, 
                si02_vltotalprecoreferencia,
                emailContato,
                codUnidadeSubRespEstadual
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
          AND si08_instit = " . db_getsession('DB_instit') . "
          JOIN orcunidade ON db01_orgao=o41_orgao
          AND db01_unidade=o41_unidade
          AND db01_anousu = o41_anousu
          JOIN orcorgao ON o40_orgao = o41_orgao
          AND o40_anousu = o41_anousu
          WHERE db01_coddepto=l20_codepartamento
              AND db01_anousu = " . db_getsession('DB_anousu') . "
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
                     liclicita.l20_usaregistropreco,
                     liclicita.l20_leidalicitacao,
                     liclicita.l20_mododisputa,
                     liclicita.l20_recdocumentacao,
                     liclicita.l20_dataaberproposta,
                     liclicita.l20_orcsigiloso,
                     si01_sequencial,
                     si02_vltotalprecoreferencia,
                     (SELECT count(*) FROM
                        (SELECT DISTINCT l04_descricao
                            FROM liclicitemlote
                            INNER JOIN liclicitem ON l21_codigo = l04_liclicitem
                            WHERE l21_codliclicita = l20_codigo) as countLotes) as qtdLotes,
                     CASE
                         WHEN liclicita.l20_naturezaobjeto in ('1', '7') THEN liclicita.l20_regimexecucao
                         ELSE 0
                     END AS regimeExecucaoObras,
                     obrasdadoscomplementareslote.db150_bdi AS bdi,
                     liclancedital.l47_origemrecurso AS origemRecurso,
                     liclancedital.l47_descrecurso AS dscOrigemRecurso,
                     liclancedital.l47_email as emailContato,
                     si09_codunidadesubunidade AS codUnidadeSubRespEstadual
     FROM liclicita
     INNER JOIN cflicita ON (cflicita.l03_codigo = liclicita.l20_codtipocom)
     INNER JOIN pctipocompratribunal ON (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
     INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
     LEFT JOIN infocomplementaresinstit ON db_config.codigo = infocomplementaresinstit.si09_instit
     INNER JOIN liclancedital ON liclancedital.l47_liclicita = liclicita.l20_codigo
     LEFT JOIN obrascodigos ON liclancedital.l47_liclicita = obrascodigos.db151_liclicita
     LEFT JOIN obrasdadoscomplementareslote ON obrasdadoscomplementareslote.db150_codobra = obrascodigos.db151_codigoobra
          AND obrasdadoscomplementareslote.db150_bdi = ( select max(db150_bdi) from obrasdadoscomplementareslote WHERE db150_codobra = obrascodigos.db151_codigoobra)
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
     WHERE db_config.codigo= " . db_getsession('DB_instit') . "
         AND pctipocompratribunal.l44_sequencial NOT IN ('100', '101', '102', '103', '106') and liclancedital.l47_dataenvio = '" . $this->sDataFinal . "'
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
              pc23_quant,
              l47_email,
              si09_codunidadesubunidade,
              si02_vltotalprecoreferencia,
              si01_sequencial
              ) AS query
GROUP BY si01_datacotacao, codorgaoresp, codunidadesubresp, mediapercentual, exerciciolicitacao, nroProcessoLicitatorio,
         tipoCadastradoLicitacao, codmodalidadelicitacao, naturezaprocedimento, nroedital,
         exercicioedital, dtpublicacaoeditaldo, LINK, tipolicitacao, naturezaobjeto, objeto, bdi, regimeexecucaoobras,
         origemrecurso, dscorigemrecurso, qtdLotes, tipoJulgamento, l20_usaregistropreco,l20_leidalicitacao,
         l20_mododisputa,l20_recdocumentacao,l20_dataaberproposta,l20_orcsigiloso,si01_sequencial,si02_vltotalprecoreferencia,emailContato,codUnidadeSubRespEstadual

ORDER BY nroprocessolicitatorio

                  ";
        $rsResult10 = db_query($sSql);

        /**
         * registro 10
         */
        for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

            $clralic10 = new cl_ralic102024();

            $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

            $clralic10->si180_tiporegistro = 10; //1
            $clralic10->si180_codorgaoresp = $oDados10->codorgaoresp; //2
            if (db_gettipoinstit(db_getsession('DB_instit')) == "51") {
                $clralic10->si180_codunidadesubresp = ''; //3
                $clralic10->si180_codunidadesubrespestadual = $oDados10->codunidadesubrespestadual; //4
            }else {
                $clralic10->si180_codunidadesubresp = $oDados10->codunidadesubresp; //3
                $clralic10->si180_codunidadesubrespestadual = ''; //4
            }
            $clralic10->si180_exerciciolicitacao = $oDados10->exerciciolicitacao; //5
            $clralic10->si180_nroprocessolicitatorio = $oDados10->nroprocessolicitatorio; //6
            $clralic10->si180_tipocadastradolicitacao = $oDados10->tipocadastradolicitacao; //7
            $clralic10->si180_dsccadastrolicitatorio = ''; //8
            $clralic10->si180_leidalicitacao = $oDados10->l20_leidalicitacao; //9
            $clralic10->si180_codmodalidadelicitacao = $oDados10->codmodalidadelicitacao; //10
            $clralic10->si180_naturezaprocedimento = $oDados10->naturezaprocedimento; //11
            $clralic10->si180_nroedital = $oDados10->nroedital; //12
            $clralic10->si180_exercicioedital = $oDados10->exercicioedital ? $oDados10->exercicioedital : intval($oDados10->exerciciolicitacao); //13
            $clralic10->si180_dtpublicacaoeditaldo = $oDados10->dtpublicacaoeditaldo; //14
            $clralic10->si180_dtaberturaenvelopes = $oDados10->l20_dataaberproposta; //15
            $clralic10->si180_link = preg_replace("/\r|\n/", "", $oDados10->link); //16
            $clralic10->si180_tipolicitacao = $oDados10->codmodalidadelicitacao == '4' ? '' : $oDados10->tipolicitacao; //17
            $clralic10->si180_mododisputa = $oDados10->l20_mododisputa; //18
            $clralic10->si180_naturezaobjeto = $oDados10->naturezaobjeto; //19
            $clralic10->si180_objeto = substr($this->removeCaracteres($oDados10->objeto), 0, 500); //20
            $clralic10->si180_regimeexecucaoobras = $oDados10->regimeexecucaoobras; //21
            if($oDados10->l20_orcsigiloso == '' || $oDados10->l20_orcsigiloso == 'f'){
                $clralic10->si180_tipoorcamento = 1; //22
            }else{
                $clralic10->si180_tipoorcamento = 2; //22
            }
            $clralic10->si180_vlcontratacao = $oDados10->valortotal; //23
            $clralic10->si180_bdi = $oDados10->bdi; //24
            $clralic10->si180_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];//25
            $clralic10->si180_origemrecurso = $oDados10->origemrecurso; //26
            $clralic10->si180_dscorigemrecurso = $oDados10->dscorigemrecurso; //27
            $clralic10->si180_qtdlotes = $oDados10->qtdlotes; //28
            $clralic10->si180_emailcontato = $oDados10->emailcontato; //29

            $clralic10->si180_mesexercicioreforc = 'null';//23

            if ((int)$clralic10->si180_naturezaobjeto === 1 || (int)$clralic10->si180_naturezaobjeto === 7) {

                $clralic10->si180_mesexercicioreforc = $oDados10->datacotacao; //23
            }

            $clralic10->si180_instit = db_getsession("DB_instit");

            $clralic10->incluir(null);

            if ($clralic10->erro_status == 0) {
                throw new Exception($clralic10->erro_msg);
            }

            if ($oDados10->naturezaobjeto == "1") {
                /**
                 *  Selecionar informa��es do registro 11
                 * @todo checar a obrigatoriedade do pcdotac
                 */
                $sSql11 = "
              SELECT DISTINCT '11' AS tipoRegistro,
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
                    AND si08_instit = " . db_getsession('DB_instit') . "
                    JOIN orcunidade ON db01_orgao=o41_orgao
                    AND db01_unidade = o41_unidade
                    AND db01_anousu = o41_anousu
                    JOIN orcorgao ON o40_orgao = o41_orgao
                    AND o40_anousu = o41_anousu
                    WHERE db01_coddepto=l20_codepartamento
                      AND db01_anousu = " . db_getsession('DB_anousu') . "
                    LIMIT 1) AS codUnidadeSubResp,
                    liclicita.l20_anousu AS exercicioLicitacao,
                    liclicita.l20_edital AS nroProcessoLicitatorio,
                    infocomplementaresinstit.si09_codorgaotce AS codOrgao,
                    orcdotacao.o58_orgao,
                    orcdotacao.o58_unidade,
                    orcdotacao.o58_funcao AS codFuncao,
                    orcdotacao.o58_subfuncao AS codSubFuncao,
                    obrasdadoscomplementareslote.db150_codobra AS codObraLocal,
                    obrasdadoscomplementareslote.db150_classeobjeto AS classeObjeto,
                    obrasdadoscomplementareslote.db150_atividadeobra AS tipoAtividadeObra,
                    obrasdadoscomplementareslote.db150_atividadeservico AS tipoAtividadeServico,
                    obrasdadoscomplementareslote.db150_descratividadeservico AS dscAtividadeServico,
                    obrasdadoscomplementareslote.db150_atividadeservicoesp AS tipoAtividadeServEspecializado,
                    obrasdadoscomplementareslote.db150_descratividadeservicoesp AS dscAtividadeServEspecializado,
                    obrasdadoscomplementareslote.db150_sequencial AS dscatividadeservespecializado,
                    CASE WHEN db150_grupobempublico <> 99 THEN db150_subgrupobempublico ELSE '9900' END AS codBemPublico,
                    l04_descricao as lote,
                    l20_tipojulg as julg,
                    obrasdadoscomplementareslote.db150_planilhatce AS planilhamodelo,
                    infocomplementaresinstit.si09_codunidadesubunidade AS codUnidadeSubRespEstadual
                FROM liclicita
                INNER JOIN liclicitem ON (liclicita.l20_codigo=liclicitem.l21_codliclicita)
                INNER JOIN pcprocitem ON (liclicitem.l21_codpcprocitem=pcprocitem.pc81_codprocitem)
                LEFT JOIN pcdotac ON (pcprocitem.pc81_solicitem=pcdotac.pc13_codigo)
                INNER JOIN orcdotacao ON (pcdotac.pc13_anousu=orcdotacao.o58_anousu
                AND pcdotac.pc13_coddot=orcdotacao.o58_coddot)
                INNER JOIN orcunidade ON o41_anousu = o58_anousu
                AND o41_orgao = o58_orgao
                AND o41_unidade = o58_unidade
                INNER JOIN orcorgao ON o40_orgao = o41_orgao
                AND o40_anousu = l20_anousu
                AND o40_instit = l20_instit
                INNER JOIN cflicita ON (cflicita.l03_codigo = liclicita.l20_codtipocom)
                INNER JOIN pctipocompratribunal ON (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
                INNER JOIN db_depart ON l20_codepartamento = coddepto
                INNER JOIN db_departorg ON db01_coddepto = coddepto AND db01_anousu = " . db_getsession('DB_anousu') . "
                INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
                LEFT JOIN infocomplementaresinstit ON db_config.codigo = infocomplementaresinstit.si09_instit
                INNER JOIN liclancedital ON liclancedital.l47_liclicita = liclicita.l20_codigo
                INNER JOIN obrascodigos ON obrascodigos.db151_liclicita = liclancedital.l47_liclicita
                INNER JOIN obrasdadoscomplementareslote ON db150_codobra = obrascodigos.db151_codigoobra
                LEFT JOIN liclicitemlote on l04_codigo = db150_lote
              WHERE db_config.codigo = " . db_getsession('DB_instit') . "
              AND l03_pctipocompratribunal NOT IN ('100','101','102','103','106')
              AND liclicita.l20_edital = $oDados10->nroprocessolicitatorio
              AND liclicita.l20_anousu = $oDados10->exerciciolicitacao
				    ORDER BY obrasdadoscomplementareslote.db150_codobra";

                $rsResult11 = db_query($sSql11);

                $aDadosAgrupados11 = array();

                /**
                 * @todo Ajustar o si181_nrolote para receber o contador de lote
                 *
                 */

                if (pg_numrows($rsResult11)) {

                    for ($iCont11 = 0; $iCont11 < pg_numrows($rsResult11); $iCont11++) {
                        $oResult11 = db_utils::fieldsMemory($rsResult11, $iCont11);

                        $sHash11 = '11' . $oResult11->codorgaoresp . $oResult11->codunidadesubresp . $oResult11->codunidadesubrespestadual .
                            $oResult11->exerciciolicitacao . $oResult11->nroprocessolicitatorio;

                        if ($oResult11->julg == 3) {
                            $sHash11 .= $oResult11->classeobjeto . $oResult11->tipoatividadeobra . $oResult11->tipoatividadeservico .
                                $oResult11->tipoatividadeservespecializado . $oResult11->codobralocal . $oResult11->dscatividadeservespecializado . $oResult11->codbempublico;
                        }

                        if (!isset($aDadosAgrupados11[$sHash11])) {

                            $clralic11 = new cl_ralic112024();

                            $clralic11->si181_tiporegistro = 11; //1
                            $clralic11->si181_codorgaoresp = $oResult11->codorgaoresp;//2
                            if (db_gettipoinstit(db_getsession('DB_instit')) == "51") {
                                $clralic11->si181_codunidadesubresp = '';//3
                                $clralic11->si181_codunidadesubrespestadual = $oResult11->codunidadesubrespestadual;//4
                            }else {
                                $clralic11->si181_codunidadesubresp = $oResult11->codunidadesubresp;//3
                                $clralic11->si181_codunidadesubrespestadual = ''; //4
                            }
                            $clralic11->si181_exerciciolicitacao = $oResult11->exerciciolicitacao;//5
                            $clralic11->si181_nroprocessolicitatorio = $oResult11->nroprocessolicitatorio;//6
                            $clralic11->si181_codobralocal = $oResult11->codobralocal;//7
                            $clralic11->si181_classeobjeto = $oResult11->classeobjeto;//8
                            $clralic11->si181_tipoatividadeobra = $oResult11->tipoatividadeobra;//9
                            $clralic11->si181_tipoatividadeservico = $oResult11->tipoatividadeservico == 0 ? '' : $oResult11->tipoatividadeservico;//10
                            $clralic11->si181_dscatividadeservico = $oResult11->dscatividadeservico;//11
                            $clralic11->si181_tipoatividadeservespecializado = $oResult11->tipoatividadeservespecializado;//12
                            $clralic11->si181_dscatividadeservespecializado = $oResult11->dscatividadeservespecializado;//13
                            $clralic11->si181_codfuncao = $oResult11->codfuncao;//14
                            $clralic11->si181_codsubfuncao = $oResult11->codsubfuncao;//15
                            $clralic11->si181_codbempublico = $oResult11->codbempublico ? $oResult11->codbempublico : 9900;//16
                            $clralic11->si181_nrolote = count($aDadosAgrupados11) + 1;//17
                            $clralic11->si181_utilizacaoplanilhamodelo = $oResult11->planilhamodelo; //18

                            $clralic11->si181_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                            $clralic11->si181_reg10 = $clralic10->si180_sequencial;
                            $clralic11->si181_instit = db_getsession("DB_instit");

                            $clralic11->incluir(null);

                            if ($clralic11->erro_status == 0) {
                                throw new Exception($clralic11->erro_msg);
                            }

                            $aDadosAgrupados11[$sHash11] = $clralic11;
                        }


                        /*
                        * Sele��o dos registros 12 do RALIC
                        *
                        * */
                    }
                }

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
                           AND si08_instit = " . db_getsession('DB_instit') . "
                           JOIN orcunidade ON db01_orgao=o41_orgao
                           AND db01_unidade = o41_unidade
                           AND db01_anousu = o41_anousu
                           JOIN orcorgao ON o40_orgao = o41_orgao
                           AND o40_anousu = o41_anousu
                           WHERE db01_coddepto=l20_codepartamento
                               AND db01_anousu = " . db_getsession('DB_anousu') . "
                           LIMIT 1) AS codUnidadeSubResp,
                             liclicita.l20_anousu AS exercicioProcesso,
                             liclicita.l20_edital AS nroProcessoLicitatorio,
                             obrasdadoscomplementareslote.db150_codobra as codObraLocal,
                             obrasdadoscomplementareslote.db150_logradouro as logradouro,
                             obrasdadoscomplementareslote.db150_numero as numero,
                             obrasdadoscomplementareslote.db150_bairro as bairro,
                             obrasdadoscomplementareslote.db150_distrito as distrito,
                             db125_codigosistema AS municipio,
                             obrasdadoscomplementareslote.db150_cep as cep,
                             obrasdadoscomplementareslote.db150_latitude as latitude,
                             obrasdadoscomplementareslote.db150_longitude as longitude,
                             CASE WHEN db150_grupobempublico <> 99 THEN db150_subgrupobempublico ELSE '9900' END AS codBemPublico,
                             infocomplementaresinstit.si09_codunidadesubunidade AS codUnidadeSubRespEstadual
                      FROM liclicita
                      INNER JOIN cflicita ON (cflicita.l03_codigo = liclicita.l20_codtipocom)
                      INNER JOIN pctipocompratribunal ON (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
                      INNER JOIN db_config ON (liclicita.l20_instit=db_config.codigo)
                      LEFT JOIN infocomplementaresinstit ON db_config.codigo = infocomplementaresinstit.si09_instit
                      INNER JOIN liclancedital ON liclancedital.l47_liclicita = liclicita.l20_codigo
                      INNER JOIN obrascodigos on obrascodigos.db151_liclicita = liclancedital.l47_liclicita
                      INNER JOIN obrasdadoscomplementareslote ON obrascodigos.db151_codigoobra = obrasdadoscomplementareslote.db150_codobra
                      INNER JOIN cadendermunicipio on db72_sequencial = db150_municipio
                      INNER JOIN cadendermunicipiosistema on db72_sequencial = db125_cadendermunicipio
                      WHERE db_config.codigo= " . db_getsession('DB_instit') . " and db125_db_sistemaexterno = 4
                          AND pctipocompratribunal.l44_sequencial NOT IN ('100','101','102', '103', '106') and liclicita.l20_edital = $oDados10->nroprocessolicitatorio
                      ORDER BY obrasdadoscomplementareslote.db150_codobra";

                $rsResult12 = db_query($sSql12);
                $aDadosAgrupados12 = array();
                for ($iCont12 = 0; $iCont12 < pg_num_rows($rsResult12); $iCont12++) {

                    $oResult12 = db_utils::fieldsMemory($rsResult12, $iCont12);
                    $sHash12 = '12' . $oResult12->codorgaoresp . $oResult12->codunidadesubresp . $oResult12->exercicioprocesso . $oResult12->nroprocessolicitatorio . $oResult12->codobralocal  . $oResult12->cep . $oResult12->latitude . $oResult12->longitude . $oResult12->codbempublico . $oResult12->nrolote;

                    if (!isset($aDadosAgrupados12[$sHash12])) {

                        $clralic12 = new cl_ralic122024();

                        $clralic12->si182_tiporegistro = 12;//1
                        $clralic12->si182_codorgaoresp = $oResult12->codorgaoresp;//2
                        if (db_gettipoinstit(db_getsession('DB_instit')) == "51") {
                            $clralic12->si182_codunidadesubresp = '';//3
                            $clralic12->si182_codunidadesubrespestadual = $oResult12->codunidadesubrespestadual;//4
                        }else {
                            $clralic12->si182_codunidadesubresp = $oResult12->codunidadesubresp;//3
                            $clralic12->si182_codunidadesubrespestadual = ''; //4
                        }
                        $clralic12->si182_exercicioprocesso = $oResult12->exercicioprocesso;//5
                        $clralic12->si182_nroprocessolicitatorio = $oResult12->nroprocessolicitatorio;//6
                        $clralic12->si182_codobralocal = $oResult12->codobralocal;//7
                        $clralic12->si182_logradouro = $this->removeCaracteres(utf8_decode($oResult12->logradouro));//8
                        $clralic12->si182_numero = $oResult12->numero;//9
                        $clralic12->si182_bairro = $oResult12->bairro;//10
                        $clralic12->si182_distrito = $oResult12->distrito;//11
                        $tipoInstituicao = db_gettipoinstit(db_getsession('DB_instit'));
                        $clralic12->si182_municipio = $tipoInstituicao == "51" ? $oResult12->municipio : "";//12
                        $clralic12->si182_cep = $oResult12->cep;//13
                        $clralic12->si182_latitude = $oResult12->latitude;//14
                        $clralic12->si182_longitude = $oResult12->longitude;//15
                        $clralic12->si182_codbempublico = $oResult12->codbempublico;//16
                        $clralic12->si182_nrolote = count($aDadosAgrupados12) + 1;//17
                        $clralic12->si182_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                        $clralic12->si182_reg10 = $clralic10->si180_sequencial; // chave estrangeira
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
