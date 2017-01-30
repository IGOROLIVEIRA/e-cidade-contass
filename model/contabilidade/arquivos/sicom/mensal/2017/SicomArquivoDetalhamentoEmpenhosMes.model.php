<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_emp102017_classe.php");
require_once("classes/db_emp112017_classe.php");
require_once("classes/db_emp122017_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2017/GerarEMP.model.php");

/**
 * detalhamento dos empenhos do mês Sicom Acompanhamento Mensal
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoDetalhamentoEmpenhosMes extends SicomArquivoBase implements iPadArquivoBaseCSV
{

  /**
   *
   * Codigo do layout. (db_layouttxt.db50_codigo)
   * @var Integer
   */
  protected $iCodigoLayout = 166;

  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'EMP';

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

  }

  /**
   * selecionar os dados dos empenhos do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {

    $cEmp10 = new cl_emp102017();
    $cEmp11 = new cl_emp112017();
    $cEmp12 = new cl_emp122017();

    $sSqlInstit = "select cgc from db_config where codigo = " . db_getsession("DB_instit");
    $rsResultCnpj = db_query($sSqlInstit);
    $sCnpj = db_utils::fieldsMemory($rsResultCnpj, 0)->cgc;


    $sSqlTrataUnidade = "select si08_tratacodunidade from infocomplementares where si08_instit = " . db_getsession("DB_instit");
    $rsResultTrataUnidade = db_query($sSqlTrataUnidade);
    $sTrataCodUnidade = db_utils::fieldsMemory($rsResultTrataUnidade, 0)->si08_tratacodunidade;


    db_inicio_transacao();
    /**
     * excluir informacoes do mes caso ja tenha sido gerado anteriormente
     */

    $result = $cEmp10->sql_record($cEmp10->sql_query(null, "*", null, "si106_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'])
      . " and si106_instit = " . db_getsession("DB_instit"));

    if (pg_num_rows($result) > 0) {
      $cEmp12->excluir(null, "si108_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
        . " and si108_instit = " . db_getsession("DB_instit"));
      $cEmp11->excluir(null, "si107_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
        . " and si107_instit = " . db_getsession("DB_instit"));
      $cEmp10->excluir(null, "si106_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
        . " and si106_instit = " . db_getsession("DB_instit"));
      if ($cEmp10->erro_status == 0) {
        throw new Exception($cEmp10->erro_msg);
      }
    }

    db_fim_transacao();

    /**
     * selecionar arquivo xml de dados elemento da despesa
     */
    $sArquivo = "config/sicom/" . db_getsession("DB_anousu") . "/{$sCnpj}_sicomelementodespesa.xml";
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de elemento da despesa inexistente!");
    }
    $sTextoXml = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oElementos = $oDOMDocument->getElementsByTagName('elemento');

    /**
     * selecionar arquivo xml de Dados Compl Licitação
     */
    $sArquivo = "config/sicom/" . (db_getsession("DB_anousu") - 1) . "/{$sCnpj}_sicomdadoscompllicitacao.xml";
    /*if (!file_exists($sArquivo)) {
        throw new Exception("Arquivo de dados compl licitacao inexistente!");
     }*/
    $sTextoXml = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oDadosComplLicitacoes = $oDOMDocument->getElementsByTagName('dadoscompllicitacao');

    $sSql = "SELECT DISTINCT 10 as tiporegistro,CASE WHEN orcorgao.o40_codtri = '0'
            OR NULL THEN orcorgao.o40_orgao::varchar ELSE orcorgao.o40_codtri END AS o58_orgao,CASE WHEN orcunidade.o41_codtri = '0'
              OR NULL THEN orcunidade.o41_unidade::varchar ELSE orcunidade.o41_codtri END AS o58_unidade,o15_codtri,
               si09_codorgaotce as codorgao,
               lpad((CASE WHEN orcorgao.o40_codtri = '0'
         OR NULL THEN orcorgao.o40_orgao::varchar ELSE orcorgao.o40_codtri END),2,0)||lpad((CASE WHEN orcunidade.o41_codtri = '0'
           OR NULL THEN orcunidade.o41_unidade::varchar ELSE orcunidade.o41_codtri END),3,0) as codunidadesub,
               o58_funcao as codfuncao,
               o58_subfuncao as codsubfuncao,
               o58_programa as codprograma,
               o58_projativ as idacao,
               o55_origemacao as idsubacao,
               substr(o56_elemento,2,8) as naturezadadespesa,
               substr(o56_elemento,7,2) as subelemento,
               e60_codemp as nroempenho,
               e60_emiss as dtempenho,
               case when e60_codtipo = 2 then 3
                    when e60_codtipo = 3 then 2
                    else 1 end as modalidadempenho,
               case when si09_tipoinstit = 5 then COALESCE(e54_tipodespesa,0)
                    else 0 end as tipodespesa,
               case when substr(o56_elemento,1,3) = '346' then 2 else 1 end as tpempenho,
               e60_vlremp as vlbruto,
               e60_resumo as especificaoempenho,
               case when si173_codcontrato is null then 2 else 1 end as despdeccontrato,
               ' '::char as codorgaorespcontrato,

               case when si173_codcontrato is null then null else lpad((CASE WHEN orgaodepart.o40_codtri = '0'
         OR NULL THEN orgaodepart.o40_orgao::varchar ELSE orgaodepart.o40_codtri END),2,0)||lpad((CASE WHEN unidadedepart.o41_codtri = '0'
           OR NULL THEN unidadedepart.o41_unidade::varchar ELSE unidadedepart.o41_codtri END),3,0) end as codunidadesubrespcontrato,

               case when si173_codcontrato is null then null else si172_nrocontrato end as nrocontrato,
               case when si173_codcontrato is null then null else si172_dataassinatura end as dataassinaturacontrato,
               case when si174_sequencial is null then null else si174_nroseqtermoaditivo end as nrosequencialtermoaditivo,
               case when e60_convenio = 1 then 1 else 2 end as despdecconvenio,
               case when e60_convenio = 2 then null else e60_numconvenio end as nroconvenio,
               case when e60_convenio = 2 then null else e60_dataconvenio end as dataassinaturaconvenio,
               case when l20_codigo is null then 1
                    when l03_pctipocompratribunal in (100,101,102) then 3 else 2 end as despDecLicitacao,
               ' ' as codorgaoresplicit,
               case when l20_codigo is null then null else (SELECT CASE
    WHEN o41_subunidade != 0
         OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
              OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
    ELSE lpad((CASE WHEN o40_codtri = '0'
         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
           OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
   END as unidadesub
                  from db_departorg
                  JOIN infocomplementares ON si08_anousu = db01_anousu
                  AND si08_instit = " . db_getsession("DB_instit") . "
                  JOIN orcunidade u ON db01_orgao=u.o41_orgao
                  AND db01_unidade=u.o41_unidade
                  AND db01_anousu = u.o41_anousu
                 JOIN orcorgao o on o.o40_orgao = u.o41_orgao and o.o40_anousu = u.o41_anousu
                 where db01_coddepto = l20_codepartamento
                 and db01_anousu = e60_anousu limit 1)
                 end as codunidadesubresplicit,
                 liclicita.l20_codigo,
               case when l20_codigo is null then null else l20_edital end nroprocessolicitatorio,
               case when l20_codigo is null then null else l20_anousu end exercicioprocessolicitatorio,
               case when l20_codigo is null then null
                    when l03_pctipocompratribunal not in (100,101,102) then null
                    when l03_pctipocompratribunal = 100 then 2
                    when l03_pctipocompratribunal = 101 then 1
                    else 3 end as tipoprocesso,
               o.z01_cgccpf as ordenador,
               e60_numemp as numemp,
               case when length(cgm.z01_cgccpf) = 11 then 1 else 2 end as tipodocumento,
               cgm.z01_cgccpf as nrodocumento,
               orcunidade.o41_subunidade as subunidade,
               homologacaoadjudica.l202_datahomologacao as datahomologacao
             FROM empempenho
             JOIN orcdotacao ON e60_coddot = o58_coddot
             JOIN empelemento ON e60_numemp = e64_numemp
             JOIN orcelemento ON e64_codele = o56_codele
             JOIN orctiporec ON o58_codigo = o15_codigo
             JOIN emptipo ON e60_codtipo = e41_codtipo
             JOIN cgm ON e60_numcgm = z01_numcgm
             JOIN orcprojativ on o58_anousu = o55_anousu and o58_projativ = o55_projativ
          LEFT JOIN pctipocompra on e60_codcom = pc50_codcom
          LEFT JOIN cflicita on  pc50_pctipocompratribunal = l03_pctipocompratribunal and l03_instit = " . db_getsession("DB_instit") . "
        LEFT JOIN infocomplementaresinstit on si09_instit = e60_instit
        LEFT JOIN empcontratos on e60_anousu = si173_anoempenho and e60_codemp = si173_empenho::varchar
        LEFT JOIN contratos on si173_codcontrato = si172_sequencial
        LEFT JOIN db_departorg ON si172_codunidadesubresp::int = db01_coddepto AND db01_anousu = e60_anousu

        LEFT JOIN orcunidade unidadedepart on db01_anousu = unidadedepart.o41_anousu and db01_orgao = unidadedepart.o41_orgao and db01_unidade = unidadedepart.o41_unidade
        LEFT JOIN orcorgao orgaodepart on orgaodepart.o40_orgao = unidadedepart.o41_orgao and orgaodepart.o40_anousu = unidadedepart.o41_anousu

        LEFT JOIN aditivoscontratos on si174_nrocontrato = si173_codcontrato
        LEFT JOIN rescisaocontrato on si176_nrocontrato = si173_codcontrato
        LEFT JOIN liclicita ON ltrim(((string_to_array(e60_numerol, '/'))[1])::varchar,'0') = l20_numero::varchar
              AND l20_anousu::varchar = ((string_to_array(e60_numerol, '/'))[2])::varchar
              AND l03_codigo = l20_codtipocom
        LEFT JOIN orcunidade on o58_anousu = orcunidade.o41_anousu and o58_orgao = orcunidade.o41_orgao and o58_unidade = orcunidade.o41_unidade
        LEFT JOIN orcorgao on orcorgao.o40_orgao = orcunidade.o41_orgao and orcorgao.o40_anousu = orcunidade.o41_anousu
        LEFT JOIN cgm o on o.z01_numcgm = orcunidade.o41_orddespesa
        LEFT JOIN homologacaoadjudica on l20_codigo = l202_licitacao

        LEFT JOIN empempaut on e61_numemp = e60_numemp
        LEFT JOIN empautoriza on e61_autori = e60_numemp
            WHERE e60_anousu = " . db_getsession("DB_anousu") . "
              AND o56_anousu = " . db_getsession("DB_anousu") . "
              AND o58_anousu = " . db_getsession("DB_anousu") . "
              AND e60_instit = " . db_getsession("DB_instit") . "
              AND e60_emiss between '" . $this->sDataInicial . "' AND '" . $this->sDataFinal . "'  order by e60_codemp";

    $rsEmpenho = db_query($sSql);
    //echo pg_last_error();
    //echo $sSql;db_criatabela($rsEmpenho);
    $aCaracteres = array("°", chr(13), chr(10), "'", ";");
    // matriz de entrada
    $what = array("°", chr(13), chr(10), 'ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'Ã', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º');

    // matriz de saída
    $by = array('', '', '', 'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ');

    /**
     * elementos de despesa utilizados para verificar se a despesa precisa ser identificada como sendo do poder executivo ou legislativo
     * par empenhos de orgaos RPPS
     */
    $aTipoDespEmpRPPS = array('31900101', '31900102', '31900301', '31900302', '31900501', '31900502', '31900503', '31909102', '31909103', '31909201',
      '31909202', '31909203', '31909403', '31919102', '31919103', '31919201', '31919202', '31919203', '31969102', '31969103', '31969201', '31969202', '31969203');

    for ($iCont = 0; $iCont < pg_num_rows($rsEmpenho); $iCont++) {

      $oEmpenho = db_utils::fieldsMemory($rsEmpenho, $iCont);

      if ($sTrataCodUnidade == 2) {

        $sCodUnidade = str_pad($oEmpenho->o58_orgao, 3, "0", STR_PAD_LEFT);
        $sCodUnidade .= str_pad($oEmpenho->o58_unidade, 2, "0", STR_PAD_LEFT);


      } else {

        $sCodUnidade = $oEmpenho->codunidadesub;

      }

      if ($oEmpenho->subunidade != '' && $oEmpenho->subunidade != 0) {
        $sCodUnidade .= str_pad($oEmpenho->subunidade, 3, "0", STR_PAD_LEFT);
        if ($oEmpenho->codunidadesubrespcontrato != '') {
          $oEmpenho->codunidadesubrespcontrato .= str_pad($oEmpenho->subunidade, 3, "0", STR_PAD_LEFT);
        }
      }
      $sElemento = substr($oEmpenho->naturezadadespesa, 0, 8);
      /**
       * percorrer xml elemento despesa
       */
      foreach ($oElementos as $oElemento) {

        if ($oElemento->getAttribute('instituicao') == db_getsession("DB_instit")
          && $oElemento->getAttribute('elementoEcidade') == $sElemento
        ) {

          $sElemento = $oElemento->getAttribute('elementoSicom');
          break;

        }

      }

      db_inicio_transacao();

      $oDadosEmpenho = new cl_emp102017();

      $oDadosEmpenho->si106_tiporegistro = $oEmpenho->tiporegistro;
      $oDadosEmpenho->si106_codorgao = $oEmpenho->codorgao;
      $oDadosEmpenho->si106_codunidadesub = $sCodUnidade;
      $oDadosEmpenho->si106_codfuncao = $oEmpenho->codfuncao;
      $oDadosEmpenho->si106_codsubfuncao = $oEmpenho->codsubfuncao;
      $oDadosEmpenho->si106_codprograma = $oEmpenho->codprograma;
      $oDadosEmpenho->si106_idacao = $oEmpenho->idacao;
      $oDadosEmpenho->si106_idsubacao = $oEmpenho->idsubacao;
      $oDadosEmpenho->si106_naturezadespesa = substr($sElemento, 0, 6);
      $oDadosEmpenho->si106_subelemento = substr($sElemento, 6, 2);
      $oDadosEmpenho->si106_nroempenho = $oEmpenho->nroempenho;
      $oDadosEmpenho->si106_dtempenho = $oEmpenho->dtempenho;
      $oDadosEmpenho->si106_modalidadeempenho = $oEmpenho->modalidadempenho;
      $oDadosEmpenho->si106_tpempenho = $oEmpenho->tpempenho;
      $oDadosEmpenho->si106_vlbruto = $oEmpenho->vlbruto;
      $oDadosEmpenho->si106_especificacaoempenho = $oEmpenho->especificaoempenho == '' ? 'SEM HISTORICO' :
        trim(preg_replace("/[^a-zA-Z0-9 ]/", "", substr(str_replace($what, $by, $oEmpenho->especificaoempenho), 0, 200)));
      $aAnoContrato = explode('-', $oEmpenho->dtassinaturacontrato);
      if ($oEmpenho->dtassinaturacontrato == null || $aAnoContrato[0] < 2014) {
        $oDadosEmpenho->si106_despdeccontrato = 2;
        $oDadosEmpenho->si106_codorgaorespcontrato = null;
        $oDadosEmpenho->si106_codunidadesubrespcontrato = null;
        $oDadosEmpenho->si106_nrocontrato = null;
        $oDadosEmpenho->si106_dtassinaturacontrato = null;
        $oDadosEmpenho->si106_nrosequencialtermoaditivo = null;
      } else {
        $oDadosEmpenho->si106_despdeccontrato = $oEmpenho->despdeccontrato;
        $oDadosEmpenho->si106_codorgaorespcontrato = $oEmpenho->codorgaorespcontrato;
        $oDadosEmpenho->si106_codunidadesubrespcontrato = $oEmpenho->codunidadesubrespcontrato;
        $oDadosEmpenho->si106_nrocontrato = $oEmpenho->nrocontrato;
        $oDadosEmpenho->si106_dtassinaturacontrato = $oEmpenho->dataassinaturacontrato;
        $oDadosEmpenho->si106_nrosequencialtermoaditivo = $oEmpenho->nrosequencialtermoaditivo;
      }

      $oDadosEmpenho->si106_despdecconvenio = $oEmpenho->despdecconvenio;
      $oDadosEmpenho->si106_nroconvenio = $oEmpenho->nroconvenio;
      $oDadosEmpenho->si106_dataassinaturaconvenio = $oEmpenho->dataassinaturaconvenio;
      $aHomologa = explode("-", $oEmpenho->datahomologacao);
      if (($oEmpenho->datahomologacao == null && $oDadosEmpenho->exercicioprocessolicitatorio < 2014) || $aHomologa[0] < 2014) {
        $oDadosEmpenho->si106_despdeclicitacao = 1;
        $oDadosEmpenho->si106_codunidadesubresplicit = null;
        $oDadosEmpenho->si106_nroprocessolicitatorio = null;
        $oDadosEmpenho->si106_exercicioprocessolicitatorio = null;
        $oDadosEmpenho->si106_tipoprocesso = null;
      } else {
        $oDadosEmpenho->si106_despdeclicitacao = $oEmpenho->despdeclicitacao;
        $oDadosEmpenho->si106_codunidadesubresplicit = $oEmpenho->codunidadesubresplicit;
        $oDadosEmpenho->si106_nroprocessolicitatorio = $oEmpenho->nroprocessolicitatorio;
        $oDadosEmpenho->si106_exercicioprocessolicitatorio = $oEmpenho->exercicioprocessolicitatorio;
        $oDadosEmpenho->si106_tipoprocesso = $oEmpenho->tipoprocesso;
      }
      $oDadosEmpenho->si106_cpfordenador = substr($oEmpenho->ordenador, 0, 11);

      /*
       * verificar se o tipo de despesa se enquadra nos elementos necessários para informar esse campo para RPPS
       */
      $oDadosEmpenho->si106_tipodespesaemprpps = in_array(substr($sElemento, 0, 6), $aTipoDespEmpRPPS) ? ($oEmpenho->tipodespesa == '0' ? 1 : $oEmpenho->tipodespesa) : '0';

      $oDadosEmpenho->si106_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $oDadosEmpenho->si106_instit = db_getsession("DB_instit");


      $oDadosEmpenho->incluir();
      if ($oDadosEmpenho->erro_status == 0) {
        throw new Exception($oDadosEmpenho->erro_msg);
      }

      /**
       * dados registro 11
       */
      $oDadosEmpenhoFonte = new cl_emp112017();

      $oDadosEmpenhoFonte->si107_tiporegistro = 11;
      $oDadosEmpenhoFonte->si107_codunidadesub = $sCodUnidade;
      $oDadosEmpenhoFonte->si107_nroempenho = $oEmpenho->nroempenho;
      $oDadosEmpenhoFonte->si107_codfontrecursos = $oEmpenho->o15_codtri;
      $oDadosEmpenhoFonte->si107_valorfonte = $oEmpenho->vlbruto;
      $oDadosEmpenhoFonte->si107_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $oDadosEmpenhoFonte->si107_reg10 = $oDadosEmpenho->si106_sequencial;
      $oDadosEmpenhoFonte->si107_instit = db_getsession("DB_instit");

      $oDadosEmpenhoFonte->incluir(null);
      if ($oDadosEmpenhoFonte->erro_status == 0) {
        throw new Exception($oDadosEmpenhoFonte->erro_msg);
      }


      $oEmp12 = new cl_emp122017();

      $oEmp12->si108_tiporegistro = '12';
      $oEmp12->si108_codunidadesub = $sCodUnidade;
      $oEmp12->si108_nroempenho = $oEmpenho->nroempenho;;
      $oEmp12->si108_tipodocumento = $oEmpenho->tipodocumento;;
      $oEmp12->si108_nrodocumento = $oEmpenho->nrodocumento;;
      $oEmp12->si108_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $oEmp12->si108_reg10 = $oDadosEmpenho->si106_sequencial;
      $oEmp12->si108_instit = db_getsession("DB_instit");


      $oEmp12->incluir(null);
      if ($oEmp12->erro_status == 0) {
        throw new Exception($oEmp12->erro_msg);
      }


      db_fim_transacao();
    }

    $oGerarEMP = new GerarEMP();
    $oGerarEMP->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarEMP->gerarDados();

  }

}
