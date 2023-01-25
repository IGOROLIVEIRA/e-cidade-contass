<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_partlic102023_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2023/GerarPARTLIC.model.php");

/**
 * Participantes Licitação Sicom Acompanhamento Mensal
 */
class SicomArquivoParticipantesLicitacao extends SicomArquivoBase implements iPadArquivoBaseCSV
{


        /**
     *
     * Codigo do layout. (db_layouttxt.db50_codigo)
     * @var Integer
     */
    protected $iCodigoLayout = 163;

        /**
     *
     * Nome do arquivo a ser criado
     * @var String
     */
    protected $sNomeArquivo = 'PARTLIC';



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
     *esse metodo sera implementado criando um array com os campos que serao necessarios
     *para o escritor gerar o arquivo CSV
     */
    public function getCampos()
    {
    }






    



    /**
     * Quando um contrato  de origem manual mas o tipo origem  adeso  ata de registro de preo,
     * busca-se os dados do processo licitatrio em: compras>>procedimentos>adeso de registro de preo
     * @param $param
     */
    public function getDadosLicitacaoAdesao($param)
    {
    }

    /**
     * selecionar os dados de Leis de Alterao
     *
     */
    public function gerarDados()
    {
        $clpartlic10 = new cl_partlic102023();
        

        db_inicio_transacao();

        /*
         * excluir informacoes do mes selecionado registro 10
        */
        $result = $clpartlic10->sql_record($clpartlic10->sql_query(NULL, "*", NULL, "si203_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si203_instit = " . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $clpartlic10->excluir(NULL, "si203_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si203_instit = " . db_getsession("DB_instit"));
            if ($clpartlic10->erro_status == 0) {
                throw new Exception($clpartlic10->erro_msg);
            }
        }



       
        /*
         * selecionar informacoes registro 10
         */

        $sSql = "select distinct '10' as tipoRegistro,
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
        liclicita.l20_anousu AS exercicioLicitacao,
        liclicita.l20_edital as nroProcessoLicitatorio,
        (CASE length(cgm.z01_cgccpf) WHEN 11 THEN 1
            ELSE 2
        END) as tipoDocumento,
        cgm.z01_cgccpf as nroDocumento,
        manutencaolicitacao.manutlic_codunidsubanterior AS codunidsubant
        FROM liclicita as liclicita
        INNER JOIN homologacaoadjudica on (liclicita.l20_codigo=homologacaoadjudica.l202_licitacao)
        INNER JOIN pcorcamfornelic on (liclicita.l20_codigo=pcorcamfornelic.pc31_liclicita)
        INNER JOIN pcorcamforne on (pcorcamfornelic.pc31_orcamforne=pcorcamforne.pc21_orcamforne)
        INNER JOIN pcforne on (pcorcamforne.pc21_numcgm=pcforne.pc60_numcgm)
        INNER JOIN cgm on (pcforne.pc60_numcgm=cgm.z01_numcgm)
        INNER JOIN db_config on (liclicita.l20_instit=db_config.codigo)
        LEFT JOIN infocomplementaresinstit on db_config.codigo = infocomplementaresinstit.si09_instit
        INNER JOIN cflicita ON (cflicita.l03_codigo = liclicita.l20_codtipocom)
        INNER JOIN pctipocompratribunal ON (cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial)
        LEFT JOIN manutencaolicitacao on (manutencaolicitacao.manutlic_licitacao = liclicita.l20_codigo)
        WHERE db_config.codigo= " . db_getsession("DB_instit") . "
        AND DATE_PART('YEAR',homologacaoadjudica.l202_datahomologacao)= " . db_getsession("DB_anousu") . "
        AND DATE_PART('MONTH',homologacaoadjudica.l202_datahomologacao)= " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
        AND cflicita.l03_pctipocompratribunal IN ('48','49','50','51','52','53','54')";
        $rsResult10 = db_query($sSql);
        



        for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
            $clpartlic10 = new cl_partlic102023();
            $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

            $clpartlic10->si203_tiporegistro = '10';
            $clpartlic10->si203_codorgao = $oDados10->codorgaoresp;
            if($oDados10->codunidsubant!= null || $oDados10->codunidsubant!=''){
                $clpartlic10->si203_codunidadesub = $oDados10->codunidsubant;    
            }else{
                $clpartlic10->si203_codunidadesub = $oDados10->codunidadesubresp;
            }
            $clpartlic10->si203_exerciciolicitacao = $oDados10->exerciciolicitacao;
            $clpartlic10->si203_nroprocessolicitatorio = $oDados10->nroprocessolicitatorio;
            $clpartlic10->si203_tipodocumento = $oDados10->tipodocumento;
            $clpartlic10->si203_nrodocumento = $oDados10->nrodocumento;
            $clpartlic10->incluir(null);

            if ($clpartlic10->erro_status == 0) {
                throw new Exception($clpartlic10->erro_msg);
            }
        }

        db_inicio_transacao();
        $oGerarPARTLIC = new GerarPARTLIC();
        $oGerarPARTLIC->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $oGerarPARTLIC->gerarDados();
        
    }
}
