<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_resplic102021_classe.php");
require_once("classes/db_resplic202021_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2021/GerarRESPLIC.model.php");

/**
 * Responsáveis pela Licitação Sicom Acompanhamento Mensal
 * @author Msc Johnatan
 * @package Contabilidade
 */
class SicomArquivoResponsaveisLicitacao extends SicomArquivoBase implements iPadArquivoBaseCSV
{

    /**
     *
     * Codigo do layout. (db_layouttxt.db50_codigo)
     * @var Integer
     */
    protected $iCodigoLayout = 155;

    /**
     *
     * Nome do arquivo a ser criado
     * @var String
     */
    protected $sNomeArquivo = 'RESPLIC';

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
            "codOrgao",
            "codUnidadeSub",
            "exercicioLicitacao",
            "nroProcessoLicitatorio",
            "tipoResp",
            "nroCPFResp",
            "nomeResp",
            "logradouro",
            "bairroLogra",
            "codCidadeLogra",
            "ufCidadeLogra",
            "cepLogra",
            "telefone",
            "email"
        );
        $aElementos[20] = array(
            "tipoRegistro",
            "codOrgao",
            "codUnidadeSub",
            "exercicioLicitacao",
            "nroProcessoLicitatorio",
            "codTipoComissao",
            "descricaoAtoNomeacao",
            "nroAtoNomeacao",
            "dataAtoNomeacao",
            "inicioVigencia",
            "finalVigencia",
            "cpfMembroComissao",
            "nomMembroComLic",
            "codAtribuicao",
            "cargo",
            "naturezaCargo",
            "logradouro",
            "bairroLogra",
            "codCidadeLogra",
            "ufCidadeLogra",
            "cepLogra",
            "telefone",
            "email"
        );

        return $aElementos;
    }

    /**
     * selecionar os dados de Responsáveis pela Licitação do mes para gerar o arquivo
     * @see iPadArquivoBase::gerarDados()
     */
    public function gerarDados()
    {

        /**
         * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
         */
        $clresplic10 = new cl_resplic102021();
        $clresplic20 = new cl_resplic202021();


        /**
         * excluir informacoes do mes selecioado
         */
        db_inicio_transacao();

        $result = db_query($clresplic10->sql_query(null, "*", null, "si55_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si55_instit=" . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $clresplic10->excluir(null, "si55_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si55_instit=" . db_getsession("DB_instit"));
            if ($clresplic10->erro_status == 0) {
                throw new Exception($clresplic10->erro_msg);
            }
        }

        $result = db_query($clresplic20->sql_query(null, "*", null, "si56_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si56_instit=" . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $clresplic20->excluir(null, "si56_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si56_instit=" . db_getsession("DB_instit"));
            if ($clresplic20->erro_status == 0) {
                throw new Exception($clresplic20->erro_msg);
            }
        }
        /**
         *########################### registro 10 #####################
         */


        $sSql = " select distinct '10' as tipoRegistro, infocomplementaresinstit.si09_codorgaotce as codOrgaoResp,
	(SELECT CASE
    WHEN o41_subunidade != 0
         OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
              OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
    ELSE lpad((CASE WHEN o40_codtri = '0'
         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
           OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
   END AS codunidadesub
   FROM db_departorg
   JOIN infocomplementares ON si08_anousu = db01_anousu
   AND si08_instit = " . db_getsession("DB_instit") . "
   JOIN orcunidade ON db01_orgao=o41_orgao
   AND db01_unidade=o41_unidade
   AND db01_anousu = o41_anousu
   JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
   WHERE db01_coddepto=l20_codepartamento and db01_anousu=" . db_getsession("DB_anousu") . " LIMIT 1) as codUnidadeSubResp,
			liclicita.l20_anousu as exercicioLicitacao, liclicita.l20_edital as nroProcessoLicitatorio,
			liccomissaocgm.l31_tipo::int as tipoResp, l20_codigo as codigolicitacao, cgm.z01_cgccpf as nroCPFResp,
			liclicita.l20_codigo as codlicitacao,
			liclicita.l20_naturezaobjeto
			FROM liclicita as liclicita
			INNER JOIN homologacaoadjudica as homologacaoadjudica on (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
			INNER JOIN liccomissaocgm AS liccomissaocgm ON (liclicita.l20_codigo=liccomissaocgm.l31_licitacao)
			INNER JOIN protocolo.cgm as cgm on (liccomissaocgm.l31_numcgm=cgm.z01_numcgm)
			INNER JOIN configuracoes.db_config as db_config on (liclicita.l20_instit=db_config.codigo)
			INNER JOIN cflicita ON (cflicita.l03_codigo = liclicita.l20_codtipocom)
	    INNER JOIN pctipocompratribunal ON (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
			LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
			WHERE db_config.codigo= " . db_getsession("DB_instit") . " AND DATE_PART('YEAR',homologacaoadjudica.l202_datahomologacao)= " . db_getsession("DB_anousu") . "
			AND DATE_PART('MONTH',homologacaoadjudica.l202_datahomologacao)= " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
			AND pctipocompratribunal.l44_sequencial IN ('48',
		                                                  '49',
		                                                  '50',
		                                                  '51',
		                                                  '52',
		                                                  '53',
		                                                  '54') order by liclicita.l20_edital";
        $rsResult10 = db_query($sSql); //echo $sSql;exit;db_criatabela($rsResult10);

        $aLicitacoes = array();
        for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

            $clresplic10 = new cl_resplic102021();
            $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
            if ($oDados10->l20_naturezaobjeto != 6 && $oDados10->tiporesp == 9) {
                continue;
            }

            $clresplic10->si55_tiporegistro = 10;
            $clresplic10->si55_codorgao = $oDados10->codorgaoresp;
            $clresplic10->si55_codunidadesub = $oDados10->codunidadesubresp;
            $clresplic10->si55_exerciciolicitacao = $oDados10->exerciciolicitacao;
            $clresplic10->si55_nroprocessolicitatorio = $oDados10->nroprocessolicitatorio;
            $clresplic10->si55_tiporesp = $oDados10->tiporesp;
            $clresplic10->si55_nrocpfresp = $oDados10->nrocpfresp;
            $clresplic10->si55_instit = db_getsession("DB_instit");
            $clresplic10->si55_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

            $clresplic10->incluir(null);
            if ($clresplic10->erro_status == 0) {
                throw new Exception($clresplic10->erro_msg);
            }
            if (!in_array($oDados10->codlicitacao, $aLicitacoes)) {
                $aLicitacoes[] = $oDados10->codlicitacao;
            }
        }

        /**
         *########################### registro 20 #####################
         */
        $sSql = "select distinct '20' as tipoRegistro,
				infocomplementaresinstit.si09_codorgaotce as codOrgaoResp,
	(SELECT CASE
    WHEN o41_subunidade != 0
         OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
              OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
    ELSE lpad((CASE WHEN o40_codtri = '0'
         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
           OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
   END AS codunidadesub
   FROM db_departorg
   JOIN infocomplementares ON si08_anousu = db01_anousu
   AND si08_instit = " . db_getsession("DB_instit") . "
   JOIN orcunidade ON db01_orgao=o41_orgao
   AND db01_unidade=o41_unidade
   AND db01_anousu = o41_anousu
   JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
   WHERE db01_coddepto=l20_codepartamento and db01_anousu=" . db_getsession("DB_anousu") . " LIMIT 1) as codUnidadeSubResp,
				liclicita.l20_anousu as exercicioLicitacao,
				liclicita.l20_edital as nroProcessoLicitatorio,
				licpregao.l45_tipo as codTipoComissao,
				licpregao.l45_descrnomeacao as descricaoAtoNomeacao,
				licpregao.l45_numatonomeacao as nroAtoNomeacao,
				licpregao.l45_data as dataAtoNomeacao,
				licpregao.l45_data as inicioVigencia,
				licpregao.l45_validade as finalVigencia,
				cgm.z01_cgccpf as cpfMembroComissao,
				licpregaocgm.l46_tipo as codAtribuicao,
				case when l46_tipo = 1 then 'Leiloeiro' when l46_tipo = 2 then 'Membro/Equipe de Apoio'
	 when l46_tipo = 3 then 'Presidente' when l46_tipo = 4 then 'Secretário' when l46_tipo = 5 then 'Servidor Designado'
	 when l46_tipo = 6 then 'Pregoeiro' end as cargo,
				l46_naturezacargo as naturezaCargo
				FROM liclicita as liclicita
				INNER JOIN licpregao as licpregao on (liclicita.l20_equipepregao=licpregao.l45_sequencial)
				INNER JOIN licpregaocgm as licpregaocgm on (licpregao.l45_sequencial=licpregaocgm.l46_licpregao)
				INNER JOIN protocolo.cgm as cgm  on (licpregaocgm.l46_numcgm=cgm.z01_numcgm)
				INNER JOIN configuracoes.db_config as db_config on (liclicita.l20_instit=db_config.codigo)
				LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
				WHERE db_config.codigo=" . db_getsession("DB_instit") . "
				AND liclicita.l20_codigo in (" . implode(",", $aLicitacoes) . ")";

        $rsResult20 = db_query($sSql); //db_criatabela($rsResult20);

        for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {

            $clresplic20 = new cl_resplic202021();
            $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);

            $clresplic20->si56_tiporegistro = 20;
            $clresplic20->si56_codorgao = $oDados20->codorgaoresp;
            $clresplic20->si56_codunidadesub = $oDados20->codunidadesubresp;
            $clresplic20->si56_exerciciolicitacao = $oDados20->exerciciolicitacao;
            $clresplic20->si56_nroprocessolicitatorio = $oDados20->nroprocessolicitatorio;
            $clresplic20->si56_codtipocomissao = $oDados20->codtipocomissao;
            $clresplic20->si56_descricaoatonomeacao = $oDados20->descricaoatonomeacao;
            $clresplic20->si56_nroatonomeacao = $oDados20->nroatonomeacao;
            $clresplic20->si56_dataatonomeacao = $oDados20->dataatonomeacao;
            $clresplic20->si56_iniciovigencia = $oDados20->iniciovigencia;
            $clresplic20->si56_finalvigencia = $oDados20->finalvigencia;
            $clresplic20->si56_cpfmembrocomissao = $oDados20->cpfmembrocomissao;
            $clresplic20->si56_codatribuicao = $oDados20->codatribuicao;
            $clresplic20->si56_cargo = $oDados20->cargo;
            $clresplic20->si56_naturezacargo = $oDados20->naturezacargo;
            $clresplic20->si56_instit = db_getsession("DB_instit");
            $clresplic20->si56_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

            $clresplic20->incluir(null);
            if ($clresplic20->erro_status == 0) {
                throw new Exception($clresplic20->erro_msg);
            }
        }

        db_fim_transacao();

        $oGerarRESPLIC = new GerarRESPLIC();
        $oGerarRESPLIC->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $oGerarRESPLIC->gerarDados();
    }
}
