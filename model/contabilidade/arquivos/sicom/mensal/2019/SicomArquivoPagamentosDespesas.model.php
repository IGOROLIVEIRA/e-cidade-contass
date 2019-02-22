<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

require_once("classes/db_ops102019_classe.php");
require_once("classes/db_ops112019_classe.php");
require_once("classes/db_ops122019_classe.php");
require_once("classes/db_ops132019_classe.php");

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2019/GerarOPS.model.php");

/**
 * Pagamento das Despesas Sicom Acompanhamento Mensal
 * @author Marcelo
 * @package Contabilidade
 */
class SicomArquivoPagamentosDespesas extends SicomArquivoBase implements iPadArquivoBaseCSV
{

  /**
   *
   * Codigo do layout. (db_layouttxt.db50_codigo)
   * @var Integer
   */
  protected $iCodigoLayout = 172;

  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'OPS';

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

  }

  /**
   * selecionar os dados dos pagamentos de despesa do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {


    $clops10 = new cl_ops102019();
    $clops11 = new cl_ops112019();
    $clops12 = new cl_ops122019();
    $clops13 = new cl_ops132019();

      $sSqlUnidade = "SELECT * FROM infocomplementares
                      WHERE si08_anousu = " . db_getsession("DB_anousu") . "
                        AND si08_instit = " . db_getsession("DB_instit");

      $rsResultUnidade = db_query($sSqlUnidade);
      $sTrataCodUnidade = db_utils::fieldsMemory($rsResultUnidade, 0)->si08_tratacodunidade;

    db_inicio_transacao();
    /**
     * excluir informacoes do mes caso ja tenha sido gerado anteriormente
     */

    $result = $clops13->sql_record($clops13->sql_query(null, "*", null, "si135_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'])
      . " and si135_instit = " . db_getsession("DB_instit"));

    if (pg_num_rows($result) > 0) {
      $clops13->excluir(null, "si135_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
        . " and si135_instit = " . db_getsession("DB_instit"));
      if ($clops13->erro_status == 0) {
        throw new Exception($clops13->erro_msg);
      }
    }
    $result = $clops12->sql_record($clops12->sql_query(null, "*", null, "si134_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
      . " and si134_instit = " . db_getsession("DB_instit")));

    if (pg_num_rows($result) > 0) {
      $clops12->excluir(null, "si134_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
        . " and si134_instit = " . db_getsession("DB_instit"));
      if ($clops12->erro_status == 0) {
        throw new Exception($clops12->erro_msg);
      }
    }

    $result = $clops11->sql_record($clops11->sql_query(null, "*", null, "si133_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
      . " and si133_instit = " . db_getsession("DB_instit")));

    if (pg_num_rows($result) > 0) {
      $clops11->excluir(null, "si133_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
        . " and si133_instit = " . db_getsession("DB_instit"));
      if ($clops11->erro_status == 0) {
        throw new Exception("Erro registro 11:" . $clops11->erro_msg);
      }
    }

    $result = $clops10->sql_record($clops10->sql_query(null, "*", null, "si132_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
      . " and si132_instit = " . db_getsession("DB_instit")));

    if (pg_num_rows($result) > 0) {
      $clops10->excluir(null, "si132_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']
        . " and si132_instit = " . db_getsession("DB_instit"));
      if ($clops10->erro_status == 0) {
        throw new Exception("Erro registro 10:" . $clops10->erro_msg);
      }
    }


    $sSql = "SELECT 10 AS tiporesgistro,
                   si09_codorgaotce AS codorgao,
                   lpad((CASE
                             WHEN o40_codtri = '0'
                                  OR NULL THEN o40_orgao::varchar
                             ELSE o40_codtri
                         END),2,0)||lpad((CASE
                                              WHEN o41_codtri = '0'
                                                   OR NULL THEN o41_unidade::varchar
                                              ELSE o41_codtri
                                          END),3,0) AS codunidadesub,
                   c71_codlan||lpad(e50_codord,10,0) AS nroop,
                   c80_data AS dtpagamento,
                   c70_valor AS valor,
                   e50_obs AS especificacaoop,
                   o41_ordpagamento,
                   o41_orgao,
                   o41_unidade,
                   o41_anousu,
                   o.z01_cgccpf AS cpfresppgto,
                   e50_codord AS ordem,
                   e60_numemp,
                   o41_subunidade AS subunidade,
                   c71_codlan AS lancamento
            FROM pagordem
            JOIN pagordemele ON e53_codord = e50_codord
            JOIN empempenho ON e50_numemp = e60_numemp
            JOIN orcdotacao ON o58_anousu = e60_anousu AND e60_coddot = o58_coddot
            JOIN orcunidade ON o58_anousu = o41_anousu AND o58_orgao = o41_orgao AND o58_unidade =o41_unidade
            JOIN orcorgao ON o40_orgao = o41_orgao AND o40_anousu = o41_anousu
            JOIN conlancamord ON c80_codord = e50_codord
            JOIN conlancamdoc ON c71_codlan = c80_codlan
            JOIN conlancam ON c70_codlan = c71_codlan
            LEFT JOIN db_usuacgm ON id_usuario = e50_id_usuario
            LEFT JOIN infocomplementaresinstit ON si09_instit = e60_instit
            LEFT JOIN cgm o ON o.z01_numcgm = o41_ordpagamento
            WHERE c80_data BETWEEN '" . $this->sDataInicial . "' AND '" . $this->sDataFinal . "'
                AND c71_coddoc IN (5, 35, 37)
                AND e60_instit = " . db_getsession("DB_instit") . "
            ORDER BY e50_codord, c80_codlan";
    // $sSql;exit;
    $rsEmpenhosPagosGeral = db_query($sSql);

    //db_criatabela($rsEmpenhosPagosGeral);
    //$aCaracteres = array("°",chr(13),chr(10),"'",);
    // matriz de entrada
    $what = array("°", chr(13), chr(10), 'ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'Ã', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º');

    // matriz de saída
    $by = array('', '', '', 'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ');
    $aInformado = array();
    for ($iCont = 0; $iCont < pg_num_rows($rsEmpenhosPagosGeral); $iCont++) {

      $oEmpPago = db_utils::fieldsMemory($rsEmpenhosPagosGeral, $iCont);

      /**
       * pegar quantidade de extornos
       */
      $sSqlExtornos = "select sum(case when c53_tipo = 21 then -1 * c70_valor else c70_valor end) as valor from conlancamdoc join conhistdoc on c53_coddoc = c71_coddoc
            join conlancamord on c71_codlan =  c80_codlan join conlancam on c70_codlan = c71_codlan where c53_tipo in (21,20)
            and c70_data <= '" . $this->sDataFinal . "' and c80_codord = {$oEmpPago->ordem}";
      $rsQuantExtornos = db_query($sSqlExtornos);

      //db_criatabela($rsQuantExtornos);
      if (db_utils::fieldsMemory($rsQuantExtornos, 0)->valor == "" || db_utils::fieldsMemory($rsQuantExtornos, 0)->valor > 0) {
        $sHash = $oEmpPago->ordem;

        if (!isset($aInformado[$sHash])) {

          $clops10 = new cl_ops102019();

            if (($sTrataCodUnidade == 2) && ($oEmpPago->subunidade != '' && $oEmpPago->subunidade != 0)) {

                $sCodUnidade  = $oEmpPago->codunidadesub;
                $sCodUnidade .= str_pad($oEmpPago->subunidade, 3, "0", STR_PAD_LEFT);

            } else {

                $sCodUnidade  = $oEmpPago->codunidadesub;

            }
          /*
           * Verifica se o empenho existe na tabela dotacaorpsicom
           * Caso exista, busca os dados da dotação.
           * */
          $sSqlDotacaoRpSicom = "select * from dotacaorpsicom where si177_numemp = {$oEmpPago->e60_numemp}";
          $iFonteAlterada = '0';
          if (pg_num_rows(db_query($sSqlDotacaoRpSicom)) > 0) {
            $aDotacaoRpSicom = db_utils::getColectionByRecord(db_query($sSqlDotacaoRpSicom));
            $iFonteAlterada = str_pad($aDotacaoRpSicom[0]->si177_codfontrecursos, 3, "0", STR_PAD_LEFT);
            $clops10->si132_codorgao = str_pad($aDotacaoRpSicom[0]->si177_codorgaotce, 2, "0", STR_PAD_LEFT);
            $clops10->si132_codunidadesub = strlen($aDotacaoRpSicom[0]->si177_codunidadesub) != 5 && strlen($aDotacaoRpSicom[0]->si177_codunidadesub) != 8 ? "0" . $aDotacaoRpSicom[0]->si177_codunidadesub : $aDotacaoRpSicom[0]->si177_codunidadesub;
          } else {
            $clops10->si132_codorgao = $oEmpPago->codorgao;
            $clops10->si132_codunidadesub = $sCodUnidade;
          }
          $clops10->si132_tiporegistro = $oEmpPago->tiporesgistro;
          $clops10->si132_nroop = $oEmpPago->nroop;
          $clops10->si132_dtpagamento = $oEmpPago->dtpagamento;
          $clops10->si132_vlop = $oEmpPago->valor;
          $clops10->si132_especificacaoop = $oEmpPago->especificacaoop == '' ? 'SEM HISTORICO'
            : trim(preg_replace("/[^a-zA-Z0-9 ]/", "", substr(str_replace($what, $by, $oEmpPago->especificacaoop), 0, 500)));
          $clops10->si132_cpfresppgto = substr($oEmpPago->cpfresppgto, 0, 11);
          $clops10->si132_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
          $clops10->si132_instit = db_getsession("DB_instit");
          $clops10->retencao = 0;

          $clops10->incluir(null);
          if ($clops10->erro_status == 0) {


            throw new Exception($clops10->erro_msg);
          }
          $aInformado[$sHash] = $clops10;


          $sSql11 = "select tiporegistro,codreduzidoop,codunidadesub,nroop,tipopagamento,nroempenho,
                       dtempenho,nroliquidacao,dtliquidacao,codfontrecursos,sum(valorfonte) as valorfonte,
                       tipodocumentocredor,nrodocumento,codorgaoempop,codunidadeempop,subunidade
                  from (select 11 as tiporegistro,
                          c71_codlan||e50_codord as codreduzidoop,
                          lpad((CASE WHEN o40_codtri = '0'
         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
           OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0) as codunidadesub,
                          c71_codlan||lpad(e50_codord,10,0) as nroop,
                          case when c71_coddoc = 35 then 3
                           when c71_coddoc = 37 then 4
                           when substr(o56_elemento,2,2) = '46' then 2
                           else 1
                          end as tipopagamento,
                          e60_codemp as nroempenho,
                          e60_emiss as dtempenho,
                          case when date_part('year',e50_data) < 2015 then e71_codnota::varchar else /*nao alterar esse ano*/
                   (rpad(e71_codnota::varchar,9,'0') || lpad(e71_codord::varchar,9,'0')) end as nroliquidacao,
                          e50_data as dtliquidacao,
                          o15_codtri as codfontrecursos,
                          c70_valor  as valorfonte,
                          case when length(forn.z01_cgccpf) = 11 then 1 else 2 end as tipodocumentocredor,
                          forn.z01_cgccpf as nrodocumento,
                          ' '::char as codorgaoempop,
                          ' '::char as codunidadeempop,
                          e60_instit as instituicao,
                                        o41_subunidade as subunidade
                     from pagordem
                     join pagordemele on e53_codord = e50_codord
                     join empempenho on e50_numemp = e60_numemp
                     join orcdotacao on o58_anousu = e60_anousu and e60_coddot = o58_coddot
                     join orcunidade on o58_anousu = o41_anousu and o58_orgao = o41_orgao and o58_unidade =o41_unidade
                     JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                     join conlancamord on c80_codord = e50_codord
                     join conlancamdoc on c71_codlan = c80_codlan
                     join conlancam on c70_codlan = c71_codlan
                     join orcelemento on o58_codele = o56_codele and o58_anousu = o56_anousu
                     join orctiporec on o58_codigo  = o15_codigo
                     join cgm forn on e60_numcgm = forn.z01_numcgm
                     join pagordemnota on e71_codord = e50_codord
                left join infocomplementaresinstit on si09_instit = e60_instit
                    where c71_data between '" . $this->sDataInicial . "' AND '" . $this->sDataFinal . "'
                      and c71_coddoc in (5,35,37) and e50_codord = {$oEmpPago->ordem}
                      and c71_codlan = {$oEmpPago->lancamento}
                      order by c71_codlan ) as pagamentos
                group by tiporegistro,codreduzidoop,codunidadesub,nroop,tipopagamento,nroempenho,
                         dtempenho,nroliquidacao,dtliquidacao,codfontrecursos,tipodocumentocredor,
                         nrodocumento,codorgaoempop,codunidadeempop,subunidade ";

          $rsPagOrd11 = db_query($sSql11);
          //db_criatabela($rsPagOrd11);

          $reg11 = db_utils::fieldsMemory($rsPagOrd11, 0);

          if (pg_num_rows($rsPagOrd11) > 0) {
            $clops11 = new cl_ops112019();
            if ($reg11->subunidade != '' && $reg11->subunidade != 0) {
              $reg11->codunidadesub .= str_pad($reg11->subunidade, 3, "0", STR_PAD_LEFT);
            }
            $clops11->si133_tiporegistro = $reg11->tiporegistro;
            $clops11->si133_codreduzidoop = $reg11->codreduzidoop;
            $clops11->si133_codunidadesub = $clops10->si132_codunidadesub;
            //$clops11->si133_codunidadesub 		= $reg11->codunidadesub;
            $clops11->si133_nroop = $oEmpPago->nroop;
            $clops11->si133_dtpagamento = $oEmpPago->dtpagamento;
            $clops11->si133_tipopagamento = $reg11->tipopagamento;
            $clops11->si133_nroempenho = $reg11->nroempenho;
            $clops11->si133_dtempenho = $reg11->dtempenho;
            if($reg11->tipopagamento == 3){
                $clops11->si133_nroliquidacao = "";
                $clops11->si133_dtliquidacao = "";
            }else{
                $clops11->si133_nroliquidacao = $reg11->nroliquidacao;
                $clops11->si133_dtliquidacao = $reg11->dtliquidacao;
            }
            $clops11->si133_codfontrecursos = $iFonteAlterada != '0' ? $iFonteAlterada : $reg11->codfontrecursos;
            $clops11->si133_valorfonte = $oEmpPago->valor;
            $clops11->si133_tipodocumentocredor = $reg11->tipodocumentocredor;
            $clops11->si133_nrodocumento = $reg11->nrodocumento;
            $clops11->si133_codorgaoempop = $reg11->codorgaoempop;
            $clops11->si133_codunidadeempop = $reg11->codunidadeempop;
            $clops11->si133_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $clops11->si133_reg10 = $clops10->si132_sequencial;
            $clops11->si133_instit = db_getsession("DB_instit");


            $clops11->incluir(null);
            if ($clops11->erro_status == 0) {
              throw new Exception($clops11->erro_msg);
            }

          }

          $sSql12 = "select 12 as tiporegistro,
                   e82_codord as codreduzidoop,
                   case when e96_codigo = 1 then 5
                  when e96_codigo = 2 then 1
                  else 99
                   end as tipodocumentoop,
                   case when e96_codigo = 2 then e86_cheque
                  else null
                   end as nrodocumento,
                   c61_reduz as codctb,
                   o15_codtri as codfontectb,
                   e50_data as dtemissao,
                   k12_valor as vldocumento,
                   e96_descr as desctipodocumentoop,c23_conlancam as codlan
              from empagemov
              inner join empage on empage.e80_codage = empagemov.e81_codage
              inner join empord on empord.e82_codmov = empagemov.e81_codmov
              inner join empempenho on empempenho.e60_numemp = empagemov.e81_numemp
              left join empagemovforma on empagemovforma.e97_codmov = empagemov.e81_codmov
              left join empageforma on empageforma.e96_codigo = empagemovforma.e97_codforma
              left join empagepag on empagepag.e85_codmov = empagemov.e81_codmov
              left join empagetipo on empagetipo.e83_codtipo = empagepag.e85_codtipo
              left join empageconf on empageconf.e86_codmov = empagemov.e81_codmov
              left join empageconfgera on empageconfgera.e90_codmov = empagemov.e81_codmov and empageconfgera.e90_cancelado = 'f'
              left join saltes on saltes.k13_conta = empagetipo.e83_conta
              left join empagegera on empagegera.e87_codgera = empageconfgera.e90_codgera
              left join empagedadosret on empagedadosret.e75_codgera = empagegera.e87_codgera
              left join empagedadosretmov on empagedadosretmov.e76_codret = empagedadosret.e75_codret
              and empagedadosretmov.e76_codmov = empagemov.e81_codmov
              left join empagedadosretmovocorrencia on empagedadosretmovocorrencia.e02_empagedadosretmov = empagedadosretmov.e76_codmov
              and empagedadosretmovocorrencia.e02_empagedadosret = empagedadosretmov.e76_codret
              left join errobanco on errobanco.e92_sequencia = empagedadosretmovocorrencia.e02_errobanco
              left join empageconfche on empageconfche.e91_codmov = empagemov.e81_codmov and empageconfche.e91_ativo is true
              left join corconf on corconf.k12_codmov = empageconfche.e91_codcheque and corconf.k12_ativo is true
              left join corempagemov on corempagemov.k12_codmov = empagemov.e81_codmov
              left join pagordemele on e53_codord = empord.e82_codord
              left join empagenotasordem on e43_empagemov = e81_codmov
              left join coremp on coremp.k12_id = corempagemov.k12_id
              and coremp.k12_data = corempagemov.k12_data
              and coremp.k12_autent = corempagemov.k12_autent
                   join pagordem on e50_numemp = k12_empen and k12_codord  = e50_codord
                   join corrente on coremp.k12_autent = corrente.k12_autent
              and coremp.k12_data = corrente.k12_data
              and coremp.k12_id = corrente.k12_id
              and corrente.k12_estorn != true
                   join conplanoreduz on c61_reduz = k12_conta and c61_anousu = " . db_getsession("DB_anousu") . "
                   join conplano on c61_codcon = c60_codcon
                    and c61_anousu = c60_anousu
              left join conplanoconta on c63_codcon = c60_codcon
                    and c60_anousu = c63_anousu
                    join corgrupocorrente cg on cg.k105_autent = corrente.k12_autent
                    join orctiporec on c61_codigo = o15_codigo
                    and cg.k105_data = corrente.k12_data
                    and cg.k105_id = corrente.k12_id
              join conlancamcorgrupocorrente on c23_corgrupocorrente = cg.k105_sequencial and c23_conlancam = {$oEmpPago->lancamento}
              where e80_instit = " . db_getsession("DB_instit") . "
              and k12_codord = {$oEmpPago->ordem} and e81_cancelado is null";

          $rsPagOrd12 = db_query($sSql12);
          //db_criatabela($rsPagOrd12);
          //echo pg_last_error();echo $sSql12;
          $reg12 = db_utils::fieldsMemory($rsPagOrd12, 0);

          /**
           * VERIFICA SE HOUVE RETENCAO NA ORDEM. CASO TENHA O VALOR SERA SUBTRAIDO NO VALOR DO LANCAMENTO.
           * Enter description here ...
           * @var unknown_type
           */
          $sqlReten = "SELECT sum(e23_valorretencao) as descontar
                       from retencaopagordem
                       join retencaoreceitas on  e23_retencaopagordem = e20_sequencial
                       join retencaotiporec on e23_retencaotiporec = e21_sequencial
                        where e23_ativo = true and e20_pagordem = {$oEmpPago->ordem}";
          $rsReteIs = db_query($sqlReten);

          if (pg_num_rows($rsReteIs) > 0 && db_utils::fieldsMemory($rsReteIs, 0)->descontar > 0) {

            $nVolorOp = $oEmpPago->valor - db_utils::fieldsMemory($rsReteIs, 0)->descontar;
            if ($nVolorOp == 0) {
              $saldopag = db_utils::fieldsMemory($rsReteIs, 0)->descontar;
            } else {
              $saldopag = $nVolorOp;
            }
            $aInformado[$sHash]->retencao = 1;
            if ($nVolorOp < 0) {
              $nVolorOp = $oEmpPago->valor;
              $aInformado[$sHash]->retencao = 0;
            }

          } else {
            $nVolorOp = $oEmpPago->valor;
            $saldopag = $nVolorOp;
          }

          if (pg_num_rows($rsPagOrd12) > 0 && $reg12->codctb != '') {
            $clops12 = new cl_ops122019();

            $sSqlContaPagFont = "select * from ( select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102019 on
                      si95_banco   = c63_banco and
                      si95_agencia = c63_agencia and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202019 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu") . "
                              and si95_mes <=" . $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $sSqlContaPagFont .= " UNION select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102017 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202017 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where si95_instit =  " . db_getsession("DB_instit") . " and c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102016 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202016 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where si95_instit =  " . db_getsession("DB_instit") . " and c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu");
              $sSqlContaPagFont .= " UNION select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102015 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202015 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where si95_instit =  " . db_getsession("DB_instit") . " and c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102014 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202014 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu") . ") as x order by contapag desc";
            $rsResultContaPag = db_query($sSqlContaPagFont) or die($sSqlContaPagFont." teste1");
            //echo $sSqlContaPagFont;db_criatabela($rsResultContaPag);
            $ContaPag = db_utils::fieldsMemory($rsResultContaPag)->contapag;

            $FontContaPag = db_utils::fieldsMemory($rsResultContaPag)->fonte;

            $clops12->si134_tiporegistro = $reg12->tiporegistro;
            $clops12->si134_codreduzidoop = $reg11->codreduzidoop;
            $clops12->si134_tipodocumentoop = $reg12->tipodocumentoop;
            $clops12->si134_nrodocumento = $reg12->nrodocumento;
            $clops12->si134_codctb = $ContaPag;
            $clops12->si134_codfontectb = ($reg12->tipodocumentoop == '5' ? "100" : $FontContaPag);
            $clops12->si134_desctipodocumentoop = $reg12->tipodocumentoop == "99" ? "TED" : ' ';
            $clops12->si134_dtemissao = $reg12->dtemissao;
            $clops12->si134_vldocumento = $nVolorOp;
            $clops12->si134_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $clops12->si134_reg10 = $clops10->si132_sequencial;
            $clops12->si134_instit = db_getsession("DB_instit");
          } else {
            //pegar codlan
            //$codlan = substr($oEmpPago->nroop, 0, -10);
            $sSqlContaPagFont = "select * from (select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join conlancampag on  c82_reduz = c61_reduz and c82_anousu = c61_anousu
                      join ctb102019 on
                      si95_banco   = c63_banco and
                      si95_agencia = c63_agencia and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202019 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c82_codlan =  {$oEmpPago->lancamento} and c61_anousu = " . db_getsession("DB_anousu") . "
                              and si95_mes <=" . $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $sSqlContaPagFont .= " UNION  select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join conlancampag on  c82_reduz = c61_reduz and c82_anousu = c61_anousu
                      join ctb102017 on
                      si95_banco   = c63_banco and
                      si95_agencia = c63_agencia and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202017 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c82_codlan =  {$oEmpPago->lancamento} and c61_anousu = " . db_getsession("DB_anousu") . "
                              and si95_mes <=" . $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $sSqlContaPagFont .= " UNION  select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join conlancampag on  c82_reduz = c61_reduz and c82_anousu = c61_anousu
                      join ctb102016 on
                      si95_banco   = c63_banco and
                      si95_agencia = c63_agencia and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202016 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c82_codlan =  {$oEmpPago->lancamento} and c61_anousu = " . db_getsession("DB_anousu") . "
                              and si95_mes <=" . $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $sSqlContaPagFont .= " UNION select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join conlancampag on  c82_reduz = c61_reduz and c82_anousu = c61_anousu
                      join ctb102015 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202015 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where c82_codlan =  {$oEmpPago->lancamento} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join conlancampag on  c82_reduz = c61_reduz and c82_anousu = c61_anousu
                      join ctb102014 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202014 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c82_codlan =  {$oEmpPago->lancamento} and c61_anousu = " . db_getsession("DB_anousu") . ") as x order by contapag desc";
            $rsResultContaPag = db_query($sSqlContaPagFont) or die($sSqlContaPagFont." teste2");
            //echo $sSqlContaPagFont;db_criatabela($rsResultContaPag);
            $ContaPag2 = db_utils::fieldsMemory($rsResultContaPag)->contapag;

            $FontContaPag2 = db_utils::fieldsMemory($rsResultContaPag)->fonte;

            $clops12 = new cl_ops122019();

            $clops12->si134_tiporegistro = 12;
            $clops12->si134_codreduzidoop = $reg11->codreduzidoop;
            $clops12->si134_tipodocumentoop = 99;
            $clops12->si134_nrodocumento = 0;
            $clops12->si134_codctb = $ContaPag2;
            $clops12->si134_codfontectb = ($reg12->tipodocumentoop == '5' ? "100" : $FontContaPag2);
            $clops12->si134_desctipodocumentoop = "TED";
            $clops12->si134_dtemissao = $oEmpPago->dtpagamento;
            $clops12->si134_vldocumento = $nVolorOp;
            $clops12->si134_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $clops12->si134_reg10 = $clops10->si132_sequencial;
            $clops12->si134_instit = db_getsession("DB_instit");

          }

          $clops12->incluir(null);
          if ($clops12->erro_status == 0) {
            //echo "<pre>";
            //print_r($clops12);
            throw new Exception($clops12->erro_msg);
          }
          $nVolorOp = 0;
          if ($saldopag > 0 && $aInformado[$sHash]->retencao == 1) {
            $sSql13 = "select 13 as tiporegistro,
                               e20_pagordem as codreduzidoop,
                               case when e21_retencaotipocalc = 5 then 4
                        when e21_retencaotipocalc in (3,4,7) then 1
                        when e21_retencaotipocalc in (1,2) then 3
                        else lpad(k02_reduz,4,0)::integer
                               end as tiporetencao,
                               case when e21_retencaotipocalc not in (1,2,3,4,5,7) then e21_descricao
                                    else null end as descricaoretencao,
                               e23_valorretencao as vlrentencao
              from retencaopagordem
              join retencaoreceitas on  e23_retencaopagordem = e20_sequencial
              join retencaotiporec on e23_retencaotiporec = e21_sequencial
              left join tabrec tr on tr.k02_codigo = e21_receita
              left join tabplan tp on tp.k02_codigo = e21_receita and k02_anousu = " . db_getsession("DB_anousu") . "
                   where e23_ativo = true and e20_pagordem = {$oEmpPago->ordem}";

            $rsPagOrd13 = db_query($sSql13);//db_criatabela($rsPagOrd13);


            if (pg_num_rows($rsPagOrd13) > 0 && $aInformado[$sHash]->retencao == 1) {


              $aOps23 = array();
              for ($iCont13 = 0; $iCont13 < pg_num_rows($rsPagOrd13); $iCont13++) {

                $reg13 = db_utils::fieldsMemory($rsPagOrd13, $iCont13);
                $sHash = $reg13->tiporetencao;
                if (!isset($aOps23[$sHash])) {
                  $clops13 = new stdClass();

                  $clops13->si135_tiporegistro = $reg13->tiporegistro;
                  $clops13->si135_codreduzidoop = $reg11->codreduzidoop;
                  $clops13->si135_tiporetencao = $reg13->tiporetencao;
                  $clops13->si135_descricaoretencao = substr($reg13->descricaoretencao, 0, 50);
                  $clops13->si135_vlretencao = $reg13->vlrentencao;
                  $clops13->si135_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                  $clops13->si135_reg10 = $clops10->si132_sequencial;
                  $clops13->si135_instit = db_getsession("DB_instit");

                  $aOps23[$sHash] = $clops13;
                } else {
                  $aOps23[$sHash]->si135_vlretencao += $reg13->vlrentencao;
                }
              }

              foreach ($aOps23 as $oOps23ag) {

                $clops13 = new cl_ops132019();

                $clops13->si135_tiporegistro = $oOps23ag->si135_tiporegistro;
                $clops13->si135_codreduzidoop = $oOps23ag->si135_codreduzidoop;
                $clops13->si135_tiporetencao = $oOps23ag->si135_tiporetencao;
                $clops13->si135_descricaoretencao = substr($oOps23ag->si135_descricaoretencao, 0, 50);
                $clops13->si135_vlretencao = $oOps23ag->si135_vlretencao;
                $clops13->si135_mes = $oOps23ag->si135_mes;
                $clops13->si135_reg10 = $oOps23ag->si135_reg10;
                $clops13->si135_instit = $oOps23ag->si135_instit;

                $clops13->incluir(null);
                if ($clops13->erro_status == 0) {
                  echo "<pre>";
                  print_r($clops13);
                  throw new Exception($clops13->erro_msg);
                }
              }


            }
          }

        } else {

          /*
           * CASO JA EXISTE UMA ORDEM DE PAGAMENTO INFORMADA NO ARRAY O SISTEMA VERIFICARA NOVAMENTE O LANCAMENTO CONTABIL DE
           * PAGAMENTO PARA INFORMAR COMO UM NOVO PAGAMENTO
           */

          $clops10 = new cl_ops102019();
          if ($oEmpPago->subunidade != '' && $oEmpPago->subunidade != 0) {
            $oEmpPago->codunidadesub .= str_pad($oEmpPago->subunidade, 3, "0", STR_PAD_LEFT);
          }

          /*
          * Verifica se o empenho existe na tabela dotacaorpsicom
          * Caso exista, busca os dados da dotação.
          * */
          $sSqlDotacaoRpSicom = "select * from dotacaorpsicom where si177_numemp = {$oEmpPago->e60_numemp}";
          $iFonteAlterada = '0';
          if (pg_num_rows(db_query($sSqlDotacaoRpSicom)) > 0) {
            $aDotacaoRpSicom = db_utils::getColectionByRecord(db_query($sSqlDotacaoRpSicom));
            $iFonteAlterada = str_pad($aDotacaoRpSicom[0]->si177_codfontrecursos, 3, "0", STR_PAD_LEFT);
            $clops10->si132_codorgao = str_pad($aDotacaoRpSicom[0]->si177_codorgaotce, 2, "0", STR_PAD_LEFT);
            $clops10->si132_codunidadesub = strlen($aDotacaoRpSicom[0]->si177_codunidadesub) != 5 && strlen($aDotacaoRpSicom[0]->si177_codunidadesub) != 8 ? "0" . $aDotacaoRpSicom[0]->si177_codunidadesub : $aDotacaoRpSicom[0]->si177_codunidadesub;
          } else {
            $clops10->si132_codorgao = $oEmpPago->codorgao;
            $clops10->si132_codunidadesub = $oEmpPago->codunidadesub;
          }
          $clops10->si132_tiporegistro = $oEmpPago->tiporesgistro;
          $clops10->si132_nroop = $oEmpPago->nroop;
          $clops10->si132_dtpagamento = $oEmpPago->dtpagamento;
          $clops10->si132_vlop = $oEmpPago->valor;
          $clops10->si132_especificacaoop = $oEmpPago->especificacaoop == '' ? 'SEM HISTORICO'
            : trim(preg_replace("/[^a-zA-Z0-9 ]/", "", substr(str_replace($what, $by, $oEmpPago->especificacaoop), 0, 500)));
          $clops10->si132_cpfresppgto = substr($oEmpPago->cpfresppgto, 0, 11);
          $clops10->si132_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
          $clops10->si132_instit = db_getsession("DB_instit");
          $clops10->retencao = 0;

          $clops10->incluir(null);

          if ($clops10->erro_status == 0) {
            throw new Exception($clops10->erro_msg);
          }


          $sSql11 = "select tiporegistro,codreduzidoop,codunidadesub,nroop,tipopagamento,nroempenho,
                       dtempenho,nroliquidacao,dtliquidacao,codfontrecursos,sum(valorfonte) as valorfonte,
                       tipodocumentocredor,nrodocumento,codorgaoempop,codunidadeempop,subunidade
                  from (select 11 as tiporegistro,
                          c71_codlan||e50_codord as codreduzidoop,
                          lpad(o58_orgao,2,0)||lpad(o58_unidade,3,0) as codunidadesub,
                          c71_codlan||lpad(e50_codord,10,0) as nroop,
                          case when substr(o56_elemento,2,2) = '46' then 2
                           when c71_coddoc = 35 then 3
                           when c71_coddoc = 37 then 4
                           else 1
                          end as tipopagamento,
                          e60_codemp as nroempenho,
                          e60_emiss as dtempenho,
                          case when date_part('year',e50_data) < 2015 then e71_codnota::varchar else
                   (rpad(e71_codnota::varchar,9,'0') || lpad(e71_codord::varchar,9,'0')) end as nroliquidacao,
                          e50_data as dtliquidacao,
                          o15_codtri as codfontrecursos,
                          c70_valor  as valorfonte,
                          case when length(forn.z01_cgccpf) = 11 then 1 else 2 end as tipodocumentocredor,
                          forn.z01_cgccpf as nrodocumento,
                          ' '::char as codorgaoempop,
                          ' '::char as codunidadeempop,
                          e60_instit as instituicao,
                                        o41_subunidade as subunidade
                     from pagordem
                     join pagordemele on e53_codord = e50_codord
                     join empempenho on e50_numemp = e60_numemp
                     join orcdotacao on o58_anousu = e60_anousu and e60_coddot = o58_coddot
                     join orcunidade on o58_anousu = o41_anousu and o58_orgao = o41_orgao and o58_unidade =o41_unidade
                     join conlancamord on c80_codord = e50_codord
                     join conlancamdoc on c71_codlan = c80_codlan
                     join conlancam on c70_codlan = c71_codlan
                     join orcelemento on o58_codele = o56_codele and o58_anousu = o56_anousu
                     join orctiporec on o58_codigo  = o15_codigo
                     join cgm forn on e60_numcgm = forn.z01_numcgm
                     join pagordemnota on e71_codord = e50_codord
                left join infocomplementaresinstit on si09_instit = e60_instit
                    where c71_data between '" . $this->sDataInicial . "' AND '" . $this->sDataFinal . "'
                      and c71_coddoc in (5,35,37) and e50_codord = {$oEmpPago->ordem}
                      and c71_codlan = {$oEmpPago->lancamento}
                      order by c71_codlan ) as pagamentos
                group by tiporegistro,codreduzidoop,codunidadesub,nroop,tipopagamento,nroempenho,
                         dtempenho,nroliquidacao,dtliquidacao,codfontrecursos,tipodocumentocredor,
                         nrodocumento,codorgaoempop,codunidadeempop,subunidade ";

          $rsPagOrd11 = db_query($sSql11);


          $reg11 = db_utils::fieldsMemory($rsPagOrd11, 0);

          if (pg_num_rows($rsPagOrd11) > 0) {

            $clops11 = new cl_ops112019();
            if ($reg11->subunidade != '' && $reg11->subunidade != 0) {
              $reg11->codunidadesub .= str_pad($reg11->subunidade, 3, "0", STR_PAD_LEFT);
            }
            $clops11->si133_tiporegistro = $reg11->tiporegistro;
            $clops11->si133_codreduzidoop = $reg11->codreduzidoop;
            $clops11->si133_codunidadesub = $clops10->si132_codunidadesub;
            $clops11->si133_nroop = $oEmpPago->nroop;
            $clops11->si133_dtpagamento = $oEmpPago->dtpagamento;
            $clops11->si133_tipopagamento = $reg11->tipopagamento;
            $clops11->si133_nroempenho = $reg11->nroempenho;
            $clops11->si133_dtempenho = $reg11->dtempenho;
              if($reg11->tipopagamento == 3){
                  $clops11->si133_nroliquidacao = "";
                  $clops11->si133_dtliquidacao = "";
              }else{
                  $clops11->si133_nroliquidacao = $reg11->nroliquidacao;
                  $clops11->si133_dtliquidacao = $reg11->dtliquidacao;
              }
            $clops11->si133_codfontrecursos = $iFonteAlterada != '0' ? $iFonteAlterada : $reg11->codfontrecursos;
            $clops11->si133_valorfonte = $oEmpPago->valor;
            $clops11->si133_tipodocumentocredor = $reg11->tipodocumentocredor;
            $clops11->si133_nrodocumento = $reg11->nrodocumento;
            $clops11->si133_codorgaoempop = $reg11->codorgaoempop;
            $clops11->si133_codunidadeempop = $reg11->codunidadeempop;
            $clops11->si133_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $clops11->si133_reg10 = $clops10->si132_sequencial;
            $clops11->si133_instit = db_getsession("DB_instit");


            $clops11->incluir(null);
            if ($clops11->erro_status == 0) {

              throw new Exception($clops11->erro_msg . " 11 ");
            }

          }


          $sSql12 = "select 12 as tiporegistro,
                   e82_codord as codreduzidoop,
                   case when e96_codigo = 1 then 5
                  when e96_codigo = 2 then 1
                  else 99
                   end as tipodocumentoop,
                   case when e96_codigo = 2 then e86_cheque
                  else null
                   end as nrodocumento,
                   case when e96_codigo in (2,3,4) then  c61_reduz
                  else null
                   end as codctb,
                   case when e96_codigo in (2,3,4) then  o15_codtri
                  else null
                   end as codfontectb,
                   e50_data as dtemissao,
                   k12_valor as vldocumento,c23_conlancam as codlan
              from empagemov
              inner join empage on empage.e80_codage = empagemov.e81_codage
              inner join empord on empord.e82_codmov = empagemov.e81_codmov
              inner join empempenho on empempenho.e60_numemp = empagemov.e81_numemp
              left join empagemovforma on empagemovforma.e97_codmov = empagemov.e81_codmov
              left join empageforma on empageforma.e96_codigo = empagemovforma.e97_codforma
              left join empagepag on empagepag.e85_codmov = empagemov.e81_codmov
              left join empagetipo on empagetipo.e83_codtipo = empagepag.e85_codtipo
              left join empageconf on empageconf.e86_codmov = empagemov.e81_codmov
              left join empageconfgera on empageconfgera.e90_codmov = empagemov.e81_codmov and empageconfgera.e90_cancelado = 'f'
              left join saltes on saltes.k13_conta = empagetipo.e83_conta
              left join empagegera on empagegera.e87_codgera = empageconfgera.e90_codgera
              left join empagedadosret on empagedadosret.e75_codgera = empagegera.e87_codgera
              left join empagedadosretmov on empagedadosretmov.e76_codret = empagedadosret.e75_codret
              and empagedadosretmov.e76_codmov = empagemov.e81_codmov
              left join empagedadosretmovocorrencia on empagedadosretmovocorrencia.e02_empagedadosretmov = empagedadosretmov.e76_codmov
              and empagedadosretmovocorrencia.e02_empagedadosret = empagedadosretmov.e76_codret
              left join errobanco on errobanco.e92_sequencia = empagedadosretmovocorrencia.e02_errobanco
              left join empageconfche on empageconfche.e91_codmov = empagemov.e81_codmov and empageconfche.e91_ativo is true
              left join corconf on corconf.k12_codmov = empageconfche.e91_codcheque and corconf.k12_ativo is true
              left join corempagemov on corempagemov.k12_codmov = empagemov.e81_codmov
              left join pagordemele on e53_codord = empord.e82_codord
              left join empagenotasordem on e43_empagemov = e81_codmov
              left join coremp on coremp.k12_id = corempagemov.k12_id
              and coremp.k12_data = corempagemov.k12_data
              and coremp.k12_autent = corempagemov.k12_autent
                   join pagordem on e50_numemp = k12_empen and k12_codord  = e50_codord
                   join corrente on coremp.k12_autent = corrente.k12_autent
              and coremp.k12_data = corrente.k12_data
              and coremp.k12_id = corrente.k12_id
              and corrente.k12_estorn != true
                   join conplanoreduz on c61_reduz = k12_conta and c61_anousu = " . db_getsession("DB_anousu") . "
                   join conplano on c61_codcon = c60_codcon
                    and c61_anousu = c60_anousu
              left join conplanoconta on c63_codcon = c60_codcon
                    and c60_anousu = c63_anousu
                    join corgrupocorrente cg on cg.k105_autent = corrente.k12_autent
                    join orctiporec on c61_codigo = o15_codigo
                    and cg.k105_data = corrente.k12_data
                    and cg.k105_id = corrente.k12_id
                    join conlancamcorgrupocorrente on c23_corgrupocorrente = cg.k105_sequencial and c23_conlancam = {$oEmpPago->lancamento}
              where k105_corgrupotipo != 2 and e80_instit = " . db_getsession("DB_instit") . "
              and k12_codord = {$oEmpPago->ordem} and e81_cancelado is null";

          $rsPagOrd12 = db_query($sSql12) or die($sSql12);
          //db_criatabela($rsPagOrd12);
          //echo pg_last_error();
          $reg12 = db_utils::fieldsMemory($rsPagOrd12, 0);


          /**
           * VERIFICA SE HOUVE RETENCAO NA ORDEM. CASO TENHA O VALOR SERA SUBTRAIDO NO VALOR DO LANCAMENTO.
           * Enter description here ...
           * @var unknown_type
           */
          $sqlReten = "SELECT sum(e23_valorretencao) as descontar
                         from retencaopagordem
                         join retencaoreceitas on  e23_retencaopagordem = e20_sequencial
                         join retencaotiporec on e23_retencaotiporec = e21_sequencial
                          where e23_ativo = true and e20_pagordem = {$oEmpPago->ordem}";
          $rsReteIs = db_query($sqlReten);
          if ($aInformado[$sHash]->retencao == 0) {
            if (pg_num_rows($rsReteIs) > 0) {

              $retencao2 = $aInformado[$sHash]->retencao;


              $nVolorOp = $oEmpPago->valor - db_utils::fieldsMemory($rsReteIs, 0)->descontar;
              $saldopag = $nVolorOp;
              $aInformado[$sHash]->retencao = 1;
              if ($nVolorOp < 0) {
                $nVolorOp = $oEmpPago->valor;
                $aInformado[$sHash]->retencao = 0;
              }


            } else {
              $nVolorOp = $oEmpPago->valor;
              $saldopag = $nVolorOp;
            }
          } else {
            $retencao2 = 1;
            $aInformado[$sHash]->retencao = 0;
            $nVolorOp = $oEmpPago->valor;
          }


          if (pg_num_rows($rsPagOrd12) > 0 && $reg12->codctb != '') {

            $clops12 = new cl_ops122019();


            $sSqlContaPagFont = "select * from (select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102019 on
                      si95_banco   = c63_banco and
                      si95_agencia = c63_agencia and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202019 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu") . "
                              and si95_mes <=" . $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $sSqlContaPagFont .= " UNION  select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102017 on
                      si95_banco   = c63_banco and
                      si95_agencia = c63_agencia and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202017 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION  select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102016 on
                      si95_banco   = c63_banco and
                      si95_agencia = c63_agencia and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202016 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102015 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202015 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join ctb102014 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202014 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c61_reduz = {$reg12->codctb} and c61_anousu = " . db_getsession("DB_anousu") . ") as x order by contapag";
            $rsResultContaPag = db_query($sSqlContaPagFont) or die($sSqlContaPagFont." teste3"); 
            //echo $sSqlContaPagFont;db_criatabela($rsResultContaPag);
            $ContaPag = db_utils::fieldsMemory($rsResultContaPag)->contapag;

            $FontContaPag = db_utils::fieldsMemory($rsResultContaPag)->fonte;

            $clops12->si134_tiporegistro = $reg12->tiporegistro;
            $clops12->si134_codreduzidoop = $reg11->codreduzidoop;
            $clops12->si134_tipodocumentoop = $reg12->tipodocumentoop;
            $clops12->si134_nrodocumento = $reg12->nrodocumento;
            $clops12->si134_codctb = $ContaPag;
            $clops12->si134_codfontectb = $FontContaPag;
            $clops12->si134_desctipodocumentoop = $reg12->tipodocumentoop == "99" ? "TED" : ' ';
            $clops12->si134_dtemissao = $reg12->dtemissao;
            $clops12->si134_vldocumento = $nVolorOp;
            $clops12->si134_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $clops12->si134_reg10 = $clops10->si132_sequencial;
            $clops12->si134_instit = db_getsession("DB_instit");
          } else {

            $sSqlContaPagFont = "select * from (select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join conlancampag on  c82_reduz = c61_reduz and c82_anousu = c61_anousu
                      join ctb102014 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202014 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c82_codlan =  {$oEmpPago->lancamento} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= "UNION select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join conlancampag on  c82_reduz = c61_reduz and c82_anousu = c61_anousu
                      join ctb102015 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202015 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where c82_codlan =  {$oEmpPago->lancamento} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join conlancampag on  c82_reduz = c61_reduz and c82_anousu = c61_anousu
                      join ctb102016 on
                      si95_banco   = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202016 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where c82_codlan =  {$oEmpPago->lancamento} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join conlancampag on  c82_reduz = c61_reduz and c82_anousu = c61_anousu
                      join ctb102017 on
                      si95_banco = c63_banco
                      AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202017 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where c82_codlan =  {$oEmpPago->lancamento} and c61_anousu = " . db_getsession("DB_anousu");
            $sSqlContaPagFont .= " UNION select distinct si95_codctb  as contapag, o15_codtri as fonte from conplanoconta
                      join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                      join orctiporec on c61_codigo = o15_codigo
                      join conlancampag on  c82_reduz = c61_reduz and c82_anousu = c61_anousu
                      join ctb102019 on
                      si95_banco   = c63_banco and
                      si95_agencia = c63_agencia and
                      si95_digitoverificadoragencia = c63_dvagencia and
                      si95_contabancaria = c63_conta::int8 and
                      si95_digitoverificadorcontabancaria = c63_dvconta and
                      si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb202019 on si96_codctb = si95_codctb and si96_mes = si95_mes
                              where  si95_instit =  " . db_getsession("DB_instit") . " and c82_codlan =  {$oEmpPago->lancamento} and c61_anousu = " . db_getsession("DB_anousu") . " and si95_mes <=" . $this->sDataFinal['5'] . $this->sDataFinal['6'] . ") as x order by contapag desc";
            $rsResultContaPag = db_query($sSqlContaPagFont) or die($sSqlContaPagFont." teste4");
            //echo $sSqlContaPagFont;db_criatabela($rsResultContaPag);
            $ContaPag2 = db_utils::fieldsMemory($rsResultContaPag)->contapag;

            $FontContaPag2 = db_utils::fieldsMemory($rsResultContaPag)->fonte;

            $clops12 = new cl_ops122019();


            $clops12->si134_tiporegistro = 12;
            $clops12->si134_codreduzidoop = $reg11->codreduzidoop;
            $clops12->si134_tipodocumentoop = 99;
            $clops12->si134_nrodocumento = 0;
            $clops12->si134_codctb = $ContaPag2;
            $clops12->si134_codfontectb = $FontContaPag2;
            $clops12->si134_desctipodocumentoop = "TED";
            $clops12->si134_dtemissao = $oEmpPago->dtpagamento;
            $clops12->si134_vldocumento = $nVolorOp;
            $clops12->si134_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $clops12->si134_reg10 = $clops10->si132_sequencial;
            $clops12->si134_instit = db_getsession("DB_instit");

          }

          $clops12->incluir(null);
          if ($clops12->erro_status == 0) {
            //echo "<pre>";
            //print_r($clops12);
            throw new Exception($clops12->erro_msg);
          }

          if ($saldopag >= 0 && $retencao2 == 0) {
            $sSql13 = "select 13 as tiporegistro,
                               e20_pagordem as codreduzidoop,
                               case when e21_retencaotipocalc = 5 then 4
                        when e21_retencaotipocalc in (3,4,7) then 1
                        when e21_retencaotipocalc in (1,2) then 3
                        else lpad(k02_reduz,4,0)::integer
                               end as tiporetencao,
                               case when e21_retencaotipocalc not in (1,2,3,4,5,7) then e21_descricao else null end as descricaoretencao,
                               e23_valorretencao as vlrentencao
              from retencaopagordem
              join retencaoreceitas on  e23_retencaopagordem = e20_sequencial
              join retencaotiporec on e23_retencaotiporec = e21_sequencial
              left join tabrec tr on tr.k02_codigo = e21_receita
              left join tabplan tp on tp.k02_codigo = e21_receita and k02_anousu = " . db_getsession("DB_anousu") . "
                   where e23_ativo = true and e20_pagordem = {$oEmpPago->ordem}";

            $rsPagOrd13 = db_query($sSql13);//db_criatabela($rsPagOrd13);


            if (pg_num_rows($rsPagOrd13) > 0) {


              $aOps23 = array();
              for ($iCont13 = 0; $iCont13 < pg_num_rows($rsPagOrd13); $iCont13++) {

                $reg13 = db_utils::fieldsMemory($rsPagOrd13, $iCont13);
                $sHash = $reg13->tiporetencao;
                if (!isset($aOps23[$sHash])) {
                  $clops13 = new stdClass();

                  $clops13->si135_tiporegistro = $reg13->tiporegistro;
                  $clops13->si135_codreduzidoop = $reg11->codreduzidoop;
                  $clops13->si135_tiporetencao = $reg13->tiporetencao;
                  $clops13->si135_descricaoretencao = substr($reg13->descricaoretencao, 0, 50);
                  $clops13->si135_vlretencao = $reg13->vlrentencao;
                  $clops13->si135_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                  $clops13->si135_reg10 = $clops10->si132_sequencial;
                  $clops13->si135_instit = db_getsession("DB_instit");

                  $aOps23[$sHash] = $clops13;
                } else {
                  $aOps23[$sHash]->si135_vlretencao += $reg13->vlrentencao;
                }
              }

              foreach ($aOps23 as $oOps23ag) {

                $clops13 = new cl_ops132019();

                $clops13->si135_tiporegistro = $oOps23ag->si135_tiporegistro;
                $clops13->si135_codreduzidoop = $oOps23ag->si135_codreduzidoop;
                $clops13->si135_tiporetencao = $oOps23ag->si135_tiporetencao;
                $clops13->si135_descricaoretencao = substr($oOps23ag->si135_descricaoretencao, 0, 50);
                $clops13->si135_vlretencao = $oOps23ag->si135_vlretencao;
                $clops13->si135_mes = $oOps23ag->si135_mes;
                $clops13->si135_reg10 = $oOps23ag->si135_reg10;
                $clops13->si135_instit = $oOps23ag->si135_instit;

                $clops13->incluir(null);
                if ($clops13->erro_status == 0) {
                  echo "<pre>";
                  print_r($clops13);
                  throw new Exception($clops13->erro_msg);
                }
              }


            }
          }


        }

      }
    }
    db_fim_transacao();
    $oGerarOPS = new GerarOPS();
    $oGerarOPS->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];;
    $oGerarOPS->gerarDados();
  }

}
