<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_rsp102020_classe.php");
require_once("classes/db_rsp112020_classe.php");
require_once("classes/db_rsp122020_classe.php");
require_once("classes/db_rsp202020_classe.php");
require_once("classes/db_rsp212020_classe.php");
require_once("classes/db_rsp222020_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2020/GerarRSP.model.php");

/**
 * selecionar dados de Leis de Altera��o Sicom Acompanhamento Mensal
 * @author Marcelo
 * @package Contabilidade
 */
class SicomArquivoRestosPagar extends SicomArquivoBase implements iPadArquivoBaseCSV
{

  /**
   *
   * Codigo do layout
   * @var Integer
   */
  protected $iCodigoLayout;

  /**
   *
   * Nome do arquivo a ser criado
   * @var unknown_type
   */
  protected $sNomeArquivo = 'RSP';

  const JUSTIFICATIVA_CANCELAMENTO = 'Cancelamento de resto a pagar para restabelecimento na fonte correta conforme orientacao TCE';

  const JUSTIFICATIVA_RESTABELECIMENTO = 'Restabelecimento de resto a pagar na fonte correta conforme orientacao TCE';

  /**
   * @var array Fontes encerradas em 2020
   */
  protected $aFontesEncerradas = array('148', '149', '150', '151', '152', '248', '249', '250', '251', '252');

  /*
   * Contrutor da classe
   */
  public function __construct()
  {

  }

  /**
   * retornar o codigo do layout
   *
   * @return Integer
   */
  public function getCodigoLayout()
  {
    return $this->iCodigoLayout;
  }

  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   * @return Array
   */
  public function getCampos()
  {

  }

  /**
   * selecionar os dados de Leis de Altera��o
   *
   */
  public function gerarDados()
  {


    $clrsp10 = new cl_rsp102020();
    $clrsp11 = new cl_rsp112020();
    $clrsp12 = new cl_rsp122020();
    $clrsp20 = new cl_rsp202020();
    $clrsp21 = new cl_rsp212020();
    $clrsp22 = new cl_rsp222020();

    db_inicio_transacao();

    /*
      * excluir informacoes do mes selecionado registro 12
      */
    $result = $clrsp12->sql_record($clrsp12->sql_query(null, "*", null, "si114_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si114_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {

      $clrsp12->excluir(null, "si114_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si114_instit = " . db_getsession("DB_instit"));
      if ($clrsp12->erro_status == 0) {
        throw new Exception($clrsp12->erro_msg);
      }
    }

    /*
 * excluir informacoes do mes selecionado registro 11
 */
    $result = $clrsp11->sql_record($clrsp11->sql_query(null, "*", null, "si113_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si113_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {

      $clrsp11->excluir(null, "si113_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si113_instit = " . db_getsession("DB_instit"));
      if ($clrsp11->erro_status == 0) {
        throw new Exception($clrsp11->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = $clrsp10->sql_record($clrsp10->sql_query(null, "*", null, "si112_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si112_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clrsp10->excluir(null, "si112_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si112_instit = " . db_getsession("DB_instit"));
      if ($clrsp10->erro_status == 0) {
        throw new Exception($clrsp10->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 21
     *
     */

    $result = $clrsp21->sql_record($clrsp21->sql_query(null, "*", null, "si116_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si116_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clrsp21->excluir(null, "si116_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si116_instit = " . db_getsession("DB_instit"));
      if ($clrsp21->erro_status == 0) {
        throw new Exception($clrsp21->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 22
     */
    $result = $clrsp22->sql_record($clrsp22->sql_query(null, "*", null, "si117_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si117_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clrsp22->excluir(null, "si117_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si117_instit = " . db_getsession("DB_instit"));
      if ($clrsp22->erro_status == 0) {
        throw new Exception($clrsp22->erro_msg);
      }
    }

    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = $clrsp20->sql_record($clrsp20->sql_query(null, "*", null, "si115_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si115_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clrsp20->excluir(null, "si115_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si115_instit = " . db_getsession("DB_instit"));
      if ($clrsp20->erro_status == 0) {
        throw new Exception($clrsp20->erro_msg);
      }
    }
    db_fim_transacao();
    db_inicio_transacao();

    if ($this->sDataFinal['5'] . $this->sDataFinal['6'] == '01') {
      /*
       * selecionar informacoes registro 10
       */
      $sSql = "select tiporegistro,
       codreduzidorsp,
       codorgao,
       codunidadesub,
       subunidade,
       nroempenho,
       exercicioempenho,
       dtempenho,
       dotorig,
       vlremp as vloriginal,
       (vlremp - vlranu - vlrliq) as vlsaldoantnaoproc,
       (vlrliq - vlrpag) as vlsaldoantproce,
       codfontrecursos,vlremp , vlranu , vlrliq,vlrpag,tipodoccredor,documentocreddor,e60_anousu,pessoal,dototigres
 from (select '10' as tiporegistro,
  e60_numemp as codreduzidorsp,
  si09_codorgaotce as codorgao,
        lpad((CASE WHEN o40_codtri = '0'
         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
           OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0) as codunidadesub,
        o41_subunidade as subunidade,
        e60_codemp as nroempenho,
        e60_anousu as exercicioempenho,
  e60_emiss as dtempenho,
  case when e60_anousu >= 2013 then ' ' else
  lpad(o58_funcao,2,0)||lpad(o58_subfuncao,3,0)||lpad(o58_programa,4,0)||lpad(o58_projativ,4,0)||
  substr(orcelemento.o56_elemento,2,6)||'00' end as dotorig,
                sum(case when c71_coddoc IN (select c53_coddoc from conhistdoc where c53_tipo = 10)          then round(c70_valor,2) else 0 end) as vlremp,
                sum(case when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo = 11) then round(c70_valor,2) else 0 end) as vlranu,
                sum(case when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo = 20) then round(c70_valor,2)
                         when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo = 21) then round(c70_valor,2) *-1
                         else 0 end) as vlrliq,
                sum(case when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo = 30) then round(c70_valor,2)
                         when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo = 31) then round(c70_valor,2) *-1
                         else 0 end) as vlrpag,
                         o15_codtri as codfontrecursos,
                         case when length(z01_cgccpf) = 11 then 1 else 2 end as tipodoccredor,
                         z01_cgccpf as documentocreddor,e60_anousu,
                         substr(orcelemento.o56_elemento,2,6) as pessoal,
                            lpad(o58_funcao,2,0)||lpad(o58_subfuncao,3,0)||lpad(o58_programa,4,0)||lpad(o58_projativ,4,0)||substr(orcelemento.o56_elemento,2,6)||substr(t1.o56_elemento, 8, 2) as dototigres
       from     empempenho
                inner join empresto     on e60_numemp = e91_numemp and e91_anousu = " . db_getsession("DB_anousu") . "
                inner join conlancamemp on e60_numemp = c75_numemp
                inner join empelemento  on e64_numemp = e60_numemp
                inner join cgm          on e60_numcgm = z01_numcgm
                inner join conlancamdoc on c75_codlan = c71_codlan
                inner join conlancam    on c75_codlan = c70_codlan
                inner join orcdotacao   on e60_coddot = o58_coddot
                                       and e60_anousu = o58_anousu
                inner join orcelemento  on o58_codele = orcelemento.o56_codele
                                       and o58_anousu = orcelemento.o56_anousu
                inner join orcelemento t1 on (t1.o56_anousu, t1.o56_codele) =(o58_anousu, e64_codele)
                join orctiporec on o58_codigo = o15_codigo
                join db_config on codigo = e60_instit
                left join infocomplementaresinstit on codigo = si09_instit
                inner join orcunidade on o58_orgao = o41_orgao and o58_unidade = o41_unidade and o41_anousu = o58_anousu
                JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
       where    e60_anousu < " . db_getsession("DB_anousu") . " and e60_instit = " . db_getsession("DB_instit") . "
            and c70_data <=  '" . (db_getsession("DB_anousu") - 1) . "-12-31'
     group by   e60_anousu,
                e60_codemp,
                e60_emiss,
                z01_numcgm,
                z01_cgccpf,
                z01_nome,
                e60_numemp,
                o58_codigo,
                o58_orgao,
                o58_unidade,
                o41_subunidade,
                o58_funcao,
                o58_subfuncao,
                o58_programa,
                o58_projativ,
                orcelemento.o56_elemento,
                t1.o56_elemento,
                o15_codtri,
                si09_codorgaotce,
                o40_codtri,orcorgao.o40_orgao,orcunidade.o41_codtri,orcunidade.o41_unidade) as restos
    where (vlremp - vlranu - vlrliq) > 0 or (vlrliq - vlrpag) > 0";

      $rsResult10 = db_query($sSql);//db_criatabela($rsResult10);die($sSql);

      for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

        $clrsp10 = new cl_rsp102020();
        $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
        if ($oDados10->subunidade  > 0) {
          $oDados10->codunidadesub .= str_pad($oDados10->subunidade, 3, "0", STR_PAD_LEFT);
        }

        $clrsp10->si112_tiporegistro = 10;
        $clrsp10->si112_codreduzidorsp = $oDados10->codreduzidorsp;

        /*
        * Verifica se o empenho existe na tabela dotacaorpsicom
        * Caso exista, busca os dados da dota��o.
        * */
        $sSqlDotacaoRpSicom = "select * from dotacaorpsicom where si177_numemp = {$oDados10->codreduzidorsp}";
        $iFonteAlterada = '0';
        //db_criatabela(db_query($sSqlDotacaoRpSicom));
        if (pg_num_rows(db_query($sSqlDotacaoRpSicom)) > 0) {

          $aDotacaoRpSicom = db_utils::getColectionByRecord(db_query($sSqlDotacaoRpSicom));

          $clrsp10->si112_codorgao = $aDotacaoRpSicom[0]->si177_codorgaotce;
          $clrsp10->si112_codunidadesub = strlen($aDotacaoRpSicom[0]->si177_codunidadesub) != 5 && strlen($aDotacaoRpSicom[0]->si177_codunidadesub) != 8 ? "0" . $aDotacaoRpSicom[0]->si177_codunidadesub : $aDotacaoRpSicom[0]->si177_codunidadesub;
          $clrsp10->si112_codunidadesuborig = strlen($aDotacaoRpSicom[0]->si177_codunidadesuborig) != 5 && strlen($aDotacaoRpSicom[0]->si177_codunidadesuborig) != 8 ? "0" . $aDotacaoRpSicom[0]->si177_codunidadesuborig : $aDotacaoRpSicom[0]->si177_codunidadesuborig;
          $iFonteAlterada = str_pad($aDotacaoRpSicom[0]->si177_codfontrecursos, 3, "0", STR_PAD_LEFT);
          if ($oDados10->exercicioempenho < 2013) {
            $sDotacaoOrig = str_pad($aDotacaoRpSicom[0]->si177_codfuncao, 2, "0", STR_PAD_LEFT);
            $sDotacaoOrig .= str_pad($aDotacaoRpSicom[0]->si177_codsubfuncao, 3, "0", STR_PAD_LEFT);
            $sDotacaoOrig .= str_pad(trim($aDotacaoRpSicom[0]->si177_codprograma), 4, "0", STR_PAD_LEFT);
            $sDotacaoOrig .= str_pad($aDotacaoRpSicom[0]->si177_idacao, 4, "0", STR_PAD_LEFT);
            $sDotacaoOrig .= substr($aDotacaoRpSicom[0]->si177_naturezadespesa,0,6);
            $sDotacaoOrig .= str_pad($aDotacaoRpSicom[0]->si177_subelemento, 2, "0", STR_PAD_LEFT);
            $clrsp10->si112_dotorig = $sDotacaoOrig;
          } else {
            $clrsp10->si112_dotorig = $oDados10->dotorig;
          }
          $teste = 1;
        } else {

          $clrsp10->si112_codunidadesub = $oDados10->codunidadesub;
          $clrsp10->si112_dotorig = $oDados10->dotorig;
          $clrsp10->si112_codunidadesuborig = $oDados10->codunidadesub;
        }
        $clrsp10->si112_codorgao = $oDados10->codorgao;
        $clrsp10->si112_nroempenho = $oDados10->nroempenho;
        $clrsp10->si112_exercicioempenho = $oDados10->exercicioempenho;
        $clrsp10->si112_dtempenho = $oDados10->dtempenho;
        $clrsp10->si112_vloriginal = $oDados10->vloriginal;
        $clrsp10->si112_vlsaldoantproce = $oDados10->vlsaldoantproce;
        $clrsp10->si112_vlsaldoantnaoproc = $oDados10->vlsaldoantnaoproc;
        $clrsp10->si112_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $clrsp10->si112_instit = db_getsession("DB_instit");

        if ($teste == 3) {
          echo "<pre>";
          print_r($clrsp10);
        }

        $clrsp10->incluir(null);

        if ($clrsp10->erro_status == 0) {
          echo "<pre>";
          print_r($clrsp10);
          throw new Exception($clrsp10->erro_msg);
        }

        $clrsp11->si113_tiporegistro = 11;
        $clrsp11->si113_reg10 = $clrsp10->si112_sequencial;
        $clrsp11->si113_codreduzidorsp = $oDados10->codreduzidorsp;

        $clrsp11->si113_codfontrecursos = $iFonteAlterada != '0' && $iFonteAlterada != '' ? $iFonteAlterada : $oDados10->codfontrecursos;
        if (db_getsession("DB_anousu") > 2020 && in_array($oDados10->codfontrecursos, $this->aFontesEncerradas)) {
          $clrsp11->si113_codfontrecursos = substr($clrsp11->si113_codfontrecursos, 0, 1).'59';
        }
        $clrsp11->si113_vloriginalfonte = $oDados10->vloriginal;
        $clrsp11->si113_vlsaldoantprocefonte = $oDados10->vlsaldoantproce;
        $clrsp11->si113_vlsaldoantnaoprocfonte = $oDados10->vlsaldoantnaoproc;
        $clrsp11->si113_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $clrsp11->si113_instit = db_getsession("DB_instit");

        $clrsp11->incluir(null);

        if ($clrsp11->erro_status == 0) {
          throw new Exception($clrsp11->erro_msg);
        }

        if ($oDados10->e60_anousu < 2013) {
          if ($oDados10->pessoal != '319011' || $oDados10->pessoal != '319004') {
            $clrsp12->si114_tiporegistro = 12;
            $clrsp12->si114_reg10 = $clrsp10->si112_sequencial;
            $clrsp12->si114_codreduzidorsp = $oDados10->codreduzidorsp;
            $clrsp12->si114_tipodocumento = $oDados10->tipodoccredor;
            $clrsp12->si114_nrodocumento = $oDados10->documentocreddor;
            $clrsp12->si114_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $clrsp12->si114_instit = db_getsession("DB_instit");

            $clrsp12->incluir(null);

            if ($clrsp12->erro_status == 0) {
              throw new Exception($clrsp12->erro_msg);
            }
          }
        }

        /**
         * Alteracoes nas validacoes do SICOM sera necessario inscrever e cancelar todos os restos a pagar
         * das fontes 148,149,150,151,152,248,249,250,251 e 252 e restabelece-los nas fontes 159 e 259
         */
        if (db_getsession("DB_anousu") == 2020) {

          if(in_array($oDados10->codfontrecursos, $this->aFontesEncerradas)) {

            if ($oDados10->vlsaldoantproce > 0) {

              $this->gerarReg202122($oDados10, $clrsp10,1, 1, $oDados10->vlsaldoantproce, $this::JUSTIFICATIVA_CANCELAMENTO, false);
              $this->gerarReg202122($oDados10, $clrsp10,1, 4, $oDados10->vlsaldoantproce, $this::JUSTIFICATIVA_RESTABELECIMENTO, true);

            }

            if ($oDados10->vlsaldoantnaoproc > 0) {

              $this->gerarReg202122($oDados10, $clrsp10,2, 1, $oDados10->vlsaldoantnaoproc, $this::JUSTIFICATIVA_CANCELAMENTO, false);
              $this->gerarReg202122($oDados10, $clrsp10,2, 4, $oDados10->vlsaldoantnaoproc, $this::JUSTIFICATIVA_RESTABELECIMENTO, true);


            }

          }

        }

      }
    }
    /*
     * selecionar informacoes registro 20
     */
    $sSql = "select '20' as  tiporegistro,
					       c70_codlan as codreduzidomov,
					       si09_codorgaotce as codorgao,
					       CASE
    WHEN o41_subunidade != 0
         OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
              OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
    ELSE lpad((CASE WHEN o40_codtri = '0'
         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
           OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0) end as codunidadesub,
					       e60_codemp as nroempenho,
					       e60_anousu as exercicioempenho,
					       e60_emiss as dtempenho,
					       case when c71_coddoc = 32 then 2 else 1 end as tiporestospagar,
					       '1' as tipomovimento,
					       c71_data as dtmovimentacao,
					       ' ' as dotorig,
					       c70_valor as vlmovimentacao,
					       ' ' as codorgaoencampatribuic,
					       ' ' as codunidadesubencampatribuic,
					       e94_motivo as justificativa,
					       e60_codemp,
					       e94_ato as atocancelamento,
                 e94_dataato as dataatocancelamento,o15_codtri as codfontrecursos,
                 e60_numemp
        from conlancamdoc
        join conlancamemp on c71_codlan = c75_codlan
        join empempenho on c75_numemp = e60_numemp
        join conlancam on c70_codlan = c71_codlan
        join orcdotacao on e60_coddot = o58_coddot and e60_anousu = o58_anousu
        join orcelemento  on o58_codele = o56_codele and o58_anousu = o56_anousu
        join orctiporec on o58_codigo = o15_codigo
        join db_config on codigo = e60_instit
        join empanulado on e94_numemp = e60_numemp and c71_data = e94_data and c70_valor = e94_valor
        left join infocomplementaresinstit on codigo = si09_instit
        JOIN orcunidade ON o58_orgao=o41_orgao
        AND o58_unidade=o41_unidade
       AND o58_anousu = o41_anousu
       JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
        where e60_instit = " . db_getsession("DB_instit") . " and c71_coddoc in (31,32) and c71_data between '{$this->sDataInicial}' and '{$this->sDataFinal}' ";

    $rsResult20 = db_query($sSql);//db_criatabela($rsResult20);die($sSql);


    $aDadosAgrupados = array();
    for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {

      $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);
      $sHash = $oDados20->nroempenho . $oDados20->exercicioempenho . $oDados20->dtmovimentacao;
      if (!$aDadosAgrupados[$sHash]) {

        $clrsp20 = new stdClass();
        $clrsp20->si115_tiporegistro = 20;
        $clrsp20->si115_codreduzidomov = $oDados20->codreduzidomov;

        /*
        * Verifica se o empenho existe na tabela dotacaorpsicom
        * Caso exista, busca os dados da dota��o.
        * */
        $sSqlDotacaoRpSicom = "select * from dotacaorpsicom where si177_numemp = {$oDados20->e60_numemp}";
        if (pg_num_rows(db_query($sSqlDotacaoRpSicom)) > 0) {

          $aDotacaoRpSicom = db_utils::getColectionByRecord(db_query($sSqlDotacaoRpSicom));

          $clrsp20->si115_codorgao = $aDotacaoRpSicom[0]->si177_codorgaotce;
          $clrsp20->si115_codunidadesub = strlen($aDotacaoRpSicom[0]->si177_codunidadesub) != 5 && strlen($aDotacaoRpSicom[0]->si177_codunidadesub) != 8 ? "0" . $aDotacaoRpSicom[0]->si177_codunidadesub : $aDotacaoRpSicom[0]->si177_codunidadesub;
          $clrsp20->si115_codunidadesuborig = strlen($aDotacaoRpSicom[0]->si177_codunidadesuborig) != 5 && strlen($aDotacaoRpSicom[0]->si177_codunidadesuborig) != 8 ? "0" . $aDotacaoRpSicom[0]->si177_codunidadesuborig : $aDotacaoRpSicom[0]->si177_codunidadesuborig;
        } else {
          $clrsp20->si115_codorgao = $oDados20->codorgao;
          $clrsp20->si115_codunidadesub = $oDados20->codunidadesub;
          $clrsp20->si115_codunidadesuborig = $oDados20->codunidadesub;
        }

        $clrsp20->si115_nroempenho = $oDados20->nroempenho;
        $clrsp20->si115_exercicioempenho = $oDados20->exercicioempenho;
        $clrsp20->si115_dtempenho = $oDados20->dtempenho;
        $clrsp20->si115_tiporestospagar = $oDados20->tiporestospagar;
        $clrsp20->si115_tipomovimento = $oDados20->tipomovimento;
        $clrsp20->si115_dtmovimentacao = $oDados20->dtmovimentacao;
        $clrsp20->si115_dotorig = $oDados20->dotorig;
        $clrsp20->si115_vlmovimentacao = $oDados20->vlmovimentacao;
        $clrsp20->si115_codorgaoencampatribuic = $oDados20->codorgaoencampatribuic;
        $clrsp20->si115_codunidadesubencampatribuic = $oDados20->codunidadesubencampatribuic;
        $clrsp20->si115_justificativa = $this->removeCaracteres($oDados20->justificativa);
        $clrsp20->si115_atocancelamento = $oDados20->atocancelamento;
        $clrsp20->si115_dataatocancelamento = $oDados20->dataatocancelamento;
        $clrsp20->si115_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $clrsp20->si115_instit = db_getsession("DB_instit");

        $aDadosAgrupados[$sHash] = $clrsp20;


        $clrsp21 = new stdClass();

        $clrsp21->si116_tiporegistro = 21;
        $clrsp21->si116_codreduzidomov = $oDados20->codreduzidomov;
        if (in_array($oDados20->codfontrecursos, $this->aFontesEncerradas) && $oDados20->tipomovimento == 1) {
          $clrsp21->si116_codfontrecursos = substr($oDados20->codfontrecursos, 0, 1).'59';
        } else {
          $clrsp21->si116_codfontrecursos = $oDados20->codfontrecursos;
        }
        $clrsp21->si116_vlmovimentacaofonte = $oDados20->vlmovimentacao;
        $clrsp21->si116_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $clrsp21->si116_instit = db_getsession("DB_instit");

        $aDadosAgrupados[$sHash]->reg21 = $clrsp21;

      } else {
        $aDadosAgrupados[$sHash]->si115_vlmovimentacao += $oDados20->vlmovimentacao;
        $aDadosAgrupados[$sHash]->reg21->si116_vlmovimentacaofonte += $oDados20->vlmovimentacao;
      }

    }

    foreach ($aDadosAgrupados as $oDados) {

      $clrsp20 = new cl_rsp202020();

      $clrsp20->si115_tiporegistro = 20;
      $clrsp20->si115_codreduzidomov = $oDados->si115_codreduzidomov;
      $clrsp20->si115_codorgao = $oDados->si115_codorgao;
      $clrsp20->si115_codunidadesub = $oDados->si115_codunidadesub;
      $clrsp20->si115_codunidadesuborig = $oDados->si115_codunidadesuborig;
      $clrsp20->si115_nroempenho = $oDados->si115_nroempenho;
      $clrsp20->si115_exercicioempenho = $oDados->si115_exercicioempenho;
      $clrsp20->si115_dtempenho = $oDados->si115_dtempenho;
      $clrsp20->si115_tiporestospagar = $oDados->si115_tiporestospagar;
      $clrsp20->si115_tipomovimento = $oDados->si115_tipomovimento;
      $clrsp20->si115_dtmovimentacao = $oDados->si115_dtmovimentacao;
      $clrsp20->si115_dotorig = $oDados->si115_dotorig;
      $clrsp20->si115_vlmovimentacao = $oDados->si115_vlmovimentacao;
      $clrsp20->si115_codorgaoencampatribuic = $oDados->si115_codorgaoencampatribuic;
      $clrsp20->si115_codunidadesubencampatribuic = $oDados->si115_codunidadesubencampatribuic;
      $clrsp20->si115_justificativa = $oDados->si115_justificativa;
      $clrsp20->si115_atocancelamento = $oDados->si115_atocancelamento;
      $clrsp20->si115_dataatocancelamento = $oDados->si115_dataatocancelamento;
      $clrsp20->si115_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clrsp20->si115_instit = db_getsession("DB_instit");

      $clrsp20->incluir(null);
      if ($clrsp20->erro_status == 0) {
        throw new Exception($clrsp20->erro_msg);
      }


      $clrsp21 = new cl_rsp212020();


      $clrsp21->si116_tiporegistro = 21;
      $clrsp21->si116_reg20 = $clrsp20->si115_sequencial;
      $clrsp21->si116_codreduzidomov = $oDados->reg21->si116_codreduzidomov;
      $clrsp21->si116_codfontrecursos = $oDados->reg21->si116_codfontrecursos;
      $clrsp21->si116_vlmovimentacaofonte = $oDados->reg21->si116_vlmovimentacaofonte;
      $clrsp21->si116_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clrsp21->si116_instit = db_getsession("DB_instit");

      $clrsp21->incluir(null);
      if ($clrsp21->erro_status == 0) {
        throw new Exception($clrsp21->erro_msg);
      }

    }

    db_fim_transacao();

    $oGerarRSP = new GerarRSP();
    $oGerarRSP->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarRSP->gerarDados();

  }

  public function gerarReg202122($oDados10, $clrsp10, $iTiporestospagar, $iTipoMovimento, $vlSaldoproce, $sJustificativa, $bRestabelecimento) {

    $clrsp20 = new cl_rsp202020();
    $clrsp20->si115_tiporegistro = 20;
    $clrsp20->si115_codreduzidomov = $iTipoMovimento == 1 ? $oDados10->codreduzidorsp . $oDados10->codfontrecursos . $iTiporestospagar : $oDados10->codreduzidorsp . '159' . $iTiporestospagar;
    $clrsp20->si115_codorgao = $oDados10->codorgao;
    $clrsp20->si115_codunidadesub = $clrsp10->si112_codunidadesub;
    $clrsp20->si115_codunidadesuborig = $clrsp10->si112_codunidadesuborig;
    $clrsp20->si115_nroempenho = $oDados10->nroempenho;
    $clrsp20->si115_exercicioempenho = $oDados10->exercicioempenho;
    $clrsp20->si115_dtempenho = $oDados10->dtempenho;
    $clrsp20->si115_tiporestospagar = $iTiporestospagar;
    $clrsp20->si115_tipomovimento = $iTipoMovimento;
    $clrsp20->si115_dtmovimentacao = '2020-01-01';
    $clrsp20->si115_dotorig = $bRestabelecimento ? $oDados10->dototigres : '';
    $clrsp20->si115_vlmovimentacao = $vlSaldoproce;
    $clrsp20->si115_codorgaoencampatribuic = '';
    $clrsp20->si115_codunidadesubencampatribuic = '';
    $clrsp20->si115_justificativa = $sJustificativa;
    $clrsp20->si115_atocancelamento = '';
    $clrsp20->si115_dataatocancelamento = '';
    $clrsp20->si115_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $clrsp20->si115_instit = db_getsession("DB_instit");

    $clrsp20->incluir(null);
    if ($clrsp20->erro_status == 0) {
      throw new Exception($clrsp20->erro_msg);
    }

    $clrsp21 = new cl_rsp212020();

    $clrsp21->si116_tiporegistro = 21;
    $clrsp21->si116_reg20 = $clrsp20->si115_sequencial;
    $clrsp21->si116_codreduzidomov = $iTipoMovimento == 1 ? $oDados10->codreduzidorsp . $oDados10->codfontrecursos . $iTiporestospagar : $oDados10->codreduzidorsp . '159' . $iTiporestospagar;
    $clrsp21->si116_codfontrecursos = $iTipoMovimento == 1 ? $oDados10->codfontrecursos : substr($oDados10->codfontrecursos, 0, 1).'59';
    $clrsp21->si116_vlmovimentacaofonte = $vlSaldoproce;
    $clrsp21->si116_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $clrsp21->si116_instit = db_getsession("DB_instit");

    $clrsp21->incluir(null);
    if ($clrsp21->erro_status == 0) {
      throw new Exception($clrsp21->erro_msg);
    }

    if ($iTipoMovimento == 4) {

      $clrsp22 = new cl_rsp222020();

      $clrsp22->si117_tiporegistro = 22;
      $clrsp22->si117_codreduzidomov = $iTipoMovimento == 1 ? $oDados10->codreduzidorsp . $oDados10->codfontrecursos . $iTiporestospagar : $oDados10->codreduzidorsp . '159' . $iTiporestospagar;
      $clrsp22->si117_tipodocumento = strlen($oDados10->documentocreddor) == 11 ? 1 : 2;
      $clrsp22->si117_nrodocumento = $oDados10->documentocreddor;
      $clrsp22->si117_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
      $clrsp22->si117_reg20 = $clrsp20->si115_sequencial;
      $clrsp22->si117_instit = db_getsession("DB_instit");

      $clrsp22->incluir(null);
      if ($clrsp22->erro_status == 0) {
        throw new Exception($clrsp22->erro_msg);
      }

    }

  }

}
