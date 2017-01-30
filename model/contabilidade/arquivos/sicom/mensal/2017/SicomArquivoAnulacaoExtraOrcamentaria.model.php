<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_aex102017_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2017/GerarAEX.model.php");

/**
 * Anulacao Extra Orcamentaria Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class SicomArquivoAnulacaoExtraOrcamentaria extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  
  /**
   *
   * Codigo do layout. (db_layouttxt.db50_codigo)
   * @var Integer
   */
  protected $iCodigoLayout = 196;
  
  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'AEX';
  
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
   * selecionar os dados
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {

    $cAex10 = new cl_aex102017();

    //$cAex11 = new cl_aex112017();

    /*
     * CASO JA TENHA SIDO GERADO ALTERIORMENTE PARA O MESMO PERIDO O SISTEMA IRA
     * EXCLUIR OS REGISTROS E GERAR NOVAMENTE
     *
     */
    db_inicio_transacao();
    $result = $cAex10->sql_record($cAex10->sql_query(null, "*", null, "si129_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']));

    if (pg_num_rows($result) > 0) {

      $cAex11->excluir(null, "si130_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']);
      if ($cAex11->erro_status == 0) {
        throw new Exception($cAex11->erro_msg);
      }
      $cAex10->excluir(null, "si129_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']);

      if ($cAex10->erro_status == 0) {
        throw new Exception($cAex10->erro_msg);
      }

    }
    /**
     * SQL RETORNA TODAS AS CONTAS EXTRAS EXISTENTES NO SISTEMA
     *
     */
    $sSqlExt = "select 10 as tiporegistro,c61_codcon,
               c61_reduz as codext,
               c61_codtce as codtce,
               si09_codorgaotce as codorgao,
               (select CASE
                      WHEN o41_subunidade != 0
                           OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
                              OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
                                OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
                      ELSE lpad((CASE WHEN o40_codtri = '0'
                           OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
                             OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
                       end as unidade
            from orcunidade
            join orcorgao on o41_anousu = o40_anousu and o41_orgao = o40_orgao
            where o41_instit = " . db_getsession("DB_instit") . " and o40_anousu = " . db_getsession("DB_anousu") . " order by o40_orgao limit 1) as codUnidadeSub,
               substr(c60_tipolancamento::varchar,1,2) as tipolancamento,
               case when c60_tipolancamento = 1 and c60_subtipolancamento not in (1,2,3,4) then c61_reduz
                    when c60_tipolancamento = 2 then 1
                    when c60_tipolancamento = 3 and c60_subtipolancamento not in (1,2,3) then c61_reduz
                    when c60_tipolancamento = 4 and c60_subtipolancamento not in (1,2,3,4,5,6,7) then c61_reduz
                    when (c60_tipolancamento = 99 OR c60_tipolancamento = 9999) and c60_subtipolancamento = 9999 then c61_reduz
                    else c60_subtipolancamento
               end as subtipo,
               case when c60_tipolancamento = 1 and c60_subtipolancamento not in (1,2,3,4) then 0
                    when c60_tipolancamento = 2 then 0
                    when c60_tipolancamento = 3 then 0
                    when c60_tipolancamento = 4 and c60_subtipolancamento not in (1,2,3,4,5,6,7) then c61_reduz
                    else c60_desdobramneto
               end as desdobrasubtipo,
               substr(c60_descr,1,50) as descextraorc
          from conplano
          join conplanoreduz on c60_codcon = c61_codcon and c60_anousu = c61_anousu
          left join infocomplementaresinstit on si09_instit = c61_instit
          where c60_anousu = " . db_getsession("DB_anousu") . " and c60_codsis = 7 and c61_instit = " . db_getsession("DB_instit") . "
          order by c61_reduz  ";
    $rsContasExtra = db_query($sSqlExt);// or die($sSqlExt);
    //c61_reduz in (4656,4657,4658) and
    $aExt10Agrupodo = array();
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsContasExtra); $iCont10++) {

      $oContaExtra = db_utils::fieldsMemory($rsContasExtra, $iCont10);

      $aHash = $oContaExtra->codorgao;
      $aHash .= $oContaExtra->codunidadesub;
      $aHash .= $oContaExtra->tipolancamento;
      $aHash .= $oContaExtra->subtipo;
      $aHash .= $oContaExtra->desdobrasubtipo;

      if (!isset($aExt10Agrupodo[$aHash])) {
        $cExt10 = new cl_ext102017();

        $cExt10->si124_tiporegistro = $oContaExtra->tiporegistro;
        $cExt10->si124_codext = $oContaExtra->codtce != 0 ? $oContaExtra->codtce : $oContaExtra->codext;
        $cExt10->si124_codorgao = $oContaExtra->codorgao;
        $cExt10->si124_codunidadesub = $oContaExtra->codunidadesub;
        $cExt10->si124_tipolancamento = $oContaExtra->tipolancamento;
        $cExt10->si124_subtipo = substr($oContaExtra->subtipo, 0, 3) . substr($oContaExtra->subtipo, -1);
        $cExt10->si124_desdobrasubtipo = substr($oContaExtra->desdobrasubtipo, 0, 4);
        $cExt10->si124_descextraorc = $oContaExtra->descextraorc;
        $cExt10->si124_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $cExt10->si124_instit = db_getsession("DB_instit");
        $cExt10->extras = array();

        $cExt10->extras[] = $oContaExtra->codext;
        $aExt10Agrupodo[$aHash] = $cExt10;
      } else {
        $aExt10Agrupodo[$aHash]->extras[] = $oContaExtra->codext;
      }

    }

    foreach ($aExt10Agrupodo as $oExt10Agrupado) {

      foreach ($oExt10Agrupado->extras as $nExtras) {
        /**
         * SQL RETORNA TODAS AS FONTES DAS CONTAS EXTRAS.
         */
        $sSqlExt20Fonte = " SELECT DISTINCT codext,fonte  from (
                     select ces01_reduz as codext, ces01_reduz as contrapart,ces01_fonte as fonte
                       from conextsaldo
                      where conextsaldo.ces01_reduz  in ({$nExtras})
                      and conextsaldo.ces01_anousu = " . db_getsession("DB_anousu") . "
                  union all
                     SELECT conlancamval.c69_credito AS codext,
                            conlancamval.c69_debito as contrapart,
                        orctiporec.o15_codigo AS fonte
                       FROM conlancamdoc
                 INNER JOIN conlancamval ON conlancamval.c69_codlan = conlancamdoc.c71_codlan
                 INNER JOIN conplanoreduz ON conlancamval.c69_credito = conplanoreduz.c61_reduz
                      AND conlancamval.c69_anousu = conplanoreduz.c61_anousu
                 INNER JOIN orctiporec ON orctiporec.o15_codigo = conplanoreduz.c61_codigo
                 INNER JOIN conlancaminstit ON conlancaminstit.c02_codlan = conlancamval.c69_codlan
                 INNER JOIN conlancamcorrente ON conlancamcorrente.c86_conlancam = conlancamval.c69_codlan
                  LEFT JOIN infocomplementaresinstit ON infocomplementaresinstit.si09_instit = conlancaminstit.c02_instit
                      WHERE conlancamdoc.c71_coddoc IN (120,121,130,131,150,151,152,153,160,161,162,163)
                      and conlancamval.c69_credito in ({$nExtras})
                      and DATE_PART('YEAR',conlancamdoc.c71_data) = " . db_getsession("DB_anousu") . "
                    and DATE_PART('MONTH',conlancamdoc.c71_data) <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
                    and conlancaminstit.c02_instit = " . db_getsession("DB_instit") . "
                    union all
                     SELECT conlancamval.c69_debito AS codext,
                          conlancamval.c69_credito as contrapart,
                          orctiporec.o15_codigo AS fonte
                         FROM conlancamdoc
                     INNER JOIN conlancamval ON conlancamval.c69_codlan = conlancamdoc.c71_codlan
                     INNER JOIN conplanoreduz ON conlancamval.c69_debito = conplanoreduz.c61_reduz
                        AND conlancamval.c69_anousu = conplanoreduz.c61_anousu
                     INNER JOIN orctiporec ON orctiporec.o15_codigo = conplanoreduz.c61_codigo
                     INNER JOIN conlancaminstit ON conlancaminstit.c02_codlan = conlancamval.c69_codlan
                     INNER JOIN conlancamcorrente ON conlancamcorrente.c86_conlancam = conlancamval.c69_codlan
                      LEFT JOIN infocomplementaresinstit ON infocomplementaresinstit.si09_instit = conlancaminstit.c02_instit
                        WHERE conlancamdoc.c71_coddoc IN (120,121,130,131,150,151,152,153,160,161,162,163)
                        and conlancamval.c69_debito in ({$nExtras})
                        and DATE_PART('YEAR',conlancamdoc.c71_data) = " . db_getsession("DB_anousu") . "
                    and DATE_PART('MONTH',conlancamdoc.c71_data) <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
                    and conlancaminstit.c02_instit = " . db_getsession("DB_instit") . "
                    ) as extfonte ";

        $rsExt20FonteRecurso = db_query($sSqlExt20Fonte);// or die($sSqlExt20Fonte);;
        //db_criatabela($rsExt20FonteRecurso);

        for ($iCont10 = 0; $iCont10 < pg_num_rows($rsExt20FonteRecurso); $iCont10++) {

          $oContaExtraFonte = db_utils::fieldsMemory($rsExt20FonteRecurso, $iCont10);

          $oExtRecurso = $oContaExtraFonte->fonte;
          $sSqlExtRecurso = "select o15_codtri
                                          from orctiporec
                           where o15_codigo = " . $oExtRecurso;
          $rsExtRecurso = db_query($sSqlExtRecurso);
          $oExtRecursoTCE = db_utils::fieldsMemory($rsExtRecurso, 0)->o15_codtri;

          $sSqlAex10 = " select '10' as tiporegistro,
                                 conlancamdoc.c71_codlan as codreduzidoaex,
                         case when conplanoreduz.c61_codtce != 0 then conplanoreduz.c61_codtce else conlancamval.c69_debito end as codext,
                         orctiporec.o15_codtri as codfontrecursos,
                         '1' as categoria,
                         conlancamval.c69_data as dtlancamento,
                         conlancamval.c69_data as dtanulacaoextra,
                         c69_valor as vlanulacao,
                         'Anulação de Extra' as justificativaanulacao,
                         si09_codorgaotce as codorgao,
                         conlancamcorrente.c86_id as id,
                         conlancamcorrente.c86_data as data,
                         conlancamcorrente.c86_autent as autent
                      from conlancamval
                    inner join conlancamdoc on conlancamdoc.c71_codlan = conlancamval.c69_codlan
                    inner join conlancamcorrente on  conlancamval.c69_codlan = conlancamcorrente.c86_conlancam
                    inner join conplanoreduz on conplanoreduz.c61_reduz = conlancamval.c69_debito
                    inner join orctiporec on  orctiporec.o15_codigo = conplanoreduz.c61_codigo
                           and conplanoreduz.c61_anousu = conlancamval.c69_anousu
                     left join infocomplementaresinstit on si09_instit = conplanoreduz.c61_instit
                       where conlancamdoc.c71_coddoc in (131,152,162)
                         and conlancamval.c69_debito = {$nExtras}
                       and DATE_PART('YEAR',conlancamval.c69_data) = " . db_getsession("DB_anousu") . "
                       and DATE_PART('MONTH',conlancamval.c69_data) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "  ";

          $rsAex10 = db_query($sSqlAex10) or die($sSqlAex10);
          //echo $sSqlAex10;
          //db_criatabela($rsAex10);

          for ($iContAex10 = 0; $iContAex10 < pg_num_rows($rsAex10); $iContAex10++) {

            $oAex10 = db_utils::fieldsMemory($rsAex10, $iContAex10);

            $sHash = $oAex10->tiporegitro . $oAex10->codorgao . $oAex10->codext . $oAex10->codfontrecursos;
            $sHash .= $oAex10->categoria . $oAex10->dtlancamento . $oAex10->dtanulacaoextra;
            //echo $sHash."<br>";
            if (!isset($aAex10Agrupa[$sHash])) {

              $cAex10 = new cl_aex102017();

              $cAex10->si129_tiporegistro = '10';
              $cAex10->si129_codreduzidoaex = $oAex10->codreduzidoaex;
              $cAex10->si129_codorgao = $oExt10Agrupado->si124_codorgao;
              $cAex10->si129_codext = $oExt10Agrupado->si124_codext;
              $cAex10->si129_codfontrecursos = $oExtRecursoTCE;
              $cAex10->si129_categoria = $oAex10->categoria;
              $cAex10->si129_dtlancamento = $oAex10->dtlancamento;
              $cAex10->si129_dtanulacaoextra = $oAex10->dtanulacaoextra;
              $cAex10->si129_justificativaanulacao = $oAex10->justificativaanulacao;
              $cAex10->si129_vlanulacao = $oAex10->vlanulacao;
              $cAex10->si129_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
              $cAex10->si129_instit = db_getsession("DB_instit");
              $cAex10->aex11 = array();

              $aAex10Agrupa[$sHash] = $cAex10;

              if ($oAex10->categoria == 2) {

                $sSql11 = "SELECT '11' as tiporegitro,
                            c86_data as dtanulacao,
                            (SELECT coalesce(c86_conlancam, 0)
                                 FROM conlancamcorrente
                                WHERE c86_id = corrente.k12_id
                                  AND c86_data = corrente.k12_data
                                  AND c86_autent = corrente.k12_autent) as codreduzidomov,
                            (slip.k17_codigo||slip.k17_debito)::int8 as codreduzidoop,
                            (slip.k17_codigo||slip.K17_debito)::int8 as nroop,
                            case when length(cc.z01_cgccpf::char) = 11 then 1 else 2 end as tipodocumentocredor,
                            cc.z01_cgccpf as nrodocumentocredor,
                            k17_valor as vlop,
                            k17_texto as especificacaoop,
                            substr(cc.z01_cgccpf,1,11) as cpfresppgto
                           FROM corlanc
                       INNER JOIN corrente ON corlanc.k12_id = corrente.k12_id
                            AND corlanc.k12_data = corrente.k12_data
                          AND corlanc.k12_autent = corrente.k12_autent
                       inner join slip on slip.k17_codigo = corlanc.k12_codigo
                       inner join slipnum on slipnum.k17_codigo = slip.k17_codigo
                       inner join cgm cc on cc.z01_numcgm = slipnum.k17_numcgm
                        LEFT JOIN corconf ON corlanc.k12_id = corconf.k12_id
                            AND corlanc.k12_data = corconf.k12_data
                          AND corlanc.k12_autent = corconf.k12_autent
                      LEFT JOIN empageconfche ON k12_codmov = e91_codcheque
                      LEFT JOIN empagemovforma ON e91_codmov = e97_codmov
                      LEFT JOIN empageforma ON e97_codforma = e96_codigo
                      LEFT JOIN conlancamcorrente ON conlancamcorrente.c86_id = corrente.k12_id
                            AND conlancamcorrente.c86_data = corrente.k12_data
                          AND conlancamcorrente.c86_autent = corrente.k12_autent
                        WHERE c86_id     = {$oAex10->id}
                          AND c86_data   = '{$oAex10->data}'
                          AND c86_autent = {$oAex10->autent} ";

                $rsAex11 = db_query($sSql11);// or die($sSql11);

                if (pg_num_rows($rsAex11) > 0) {

                  for ($linha22 = 0; $linha22 < pg_num_rows($rsAex11); $linha22++) {

                    $oOpAex11 = db_utils::fieldsMemory($rsAex11, $linha22);

                    $oAex11 = new cl_aex112017();

                    $oAex11->si130_tiporegistro = '11';
                    $oAex11->si130_codreduzidoaex = $oAex10->codreduzidoaex;
                    $oAex11->si130_nroop = $oOpAex11->nroop;
                    $oAex11->si130_dtpagamento = $oOpAex11->dtanulacao;
                    $oAex11->si130_nroanulacaoop = $oOpAex11->nroop;
                    $oAex11->si130_dtanulacaoop = $oOpAex11->dtanulacao;
                    $oAex11->si130_vlanulacaoop = $oOpAex11->vlop;
                    $oAex11->si130_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                    $oAex11->si130_instit = db_getsession("DB_instit");
                    $oAex11->si130_reg10 = 0;

                    $aAex10Agrupa[$sHash]->aex11[$sHash] = $oAex11;

                  }

                }

              }

            } else {
              if ($oAex10->categoria == 2) {

                $sSql11 = "SELECT '11' as tiporegitro,
                              c86_data as dtanulacao,
                              (SELECT coalesce(c86_conlancam, 0)
                                 FROM conlancamcorrente
                                WHERE c86_id = corrente.k12_id
                                  AND c86_data = corrente.k12_data
                                  AND c86_autent = corrente.k12_autent) as codreduzidomov,
                               (slip.k17_codigo||slip.k17_debito)::int8 as codreduzidoop,
                            (slip.k17_codigo||slip.K17_debito)::int8 as nroop,
                               case when length(cc.z01_cgccpf::char) = 11 then 1 else 2 end as tipodocumentocredor,
                               cc.z01_cgccpf as nrodocumentocredor,
                               k17_valor as vlop,
                               k17_texto as especificacaoop,
                               substr(cc.z01_cgccpf,1,11) as cpfresppgto
                         FROM corlanc
                       INNER JOIN corrente ON corlanc.k12_id = corrente.k12_id
                          AND corlanc.k12_data = corrente.k12_data
                          AND corlanc.k12_autent = corrente.k12_autent
                       inner join slip on slip.k17_codigo = corlanc.k12_codigo
                       inner join slipnum on slipnum.k17_codigo = slip.k17_codigo
                       inner join cgm cc on cc.z01_numcgm = slipnum.k17_numcgm
                        LEFT JOIN corconf ON corlanc.k12_id = corconf.k12_id
                          AND corlanc.k12_data = corconf.k12_data
                          AND corlanc.k12_autent = corconf.k12_autent
                        LEFT JOIN empageconfche ON k12_codmov = e91_codcheque
                      LEFT JOIN empagemovforma ON e91_codmov = e97_codmov
                      LEFT JOIN empageforma ON e97_codforma = e96_codigo
                      LEFT JOIN conlancamcorrente ON conlancamcorrente.c86_id = corrente.k12_id
                          AND conlancamcorrente.c86_data = corrente.k12_data
                          AND conlancamcorrente.c86_autent = corrente.k12_autent
                        WHERE c86_id     = {$oAex10->id}
                          AND c86_data   = '{$oAex10->data}'
                          AND c86_autent = {$oAex10->autent} ";

                $rsAex11 = db_query($sSql11);// or die($sSql11);
                if (pg_num_rows($rsAex11) > 0) {

                  for ($linha22 = 0; $linha22 < pg_num_rows($rsAex11); $linha22++) {

                    $oOpAex11 = db_utils::fieldsMemory($rsAex11, $linha22);

                    $oAex11 = new cl_aex112017();

                    $oAex11->si130_tiporegistro = '11';
                    $oAex11->si130_codreduzidoaex = $oAex10->codreduzidoaex;
                    $oAex11->si130_nroop = $oOpAex11->nroop;
                    $oAex11->si130_dtpagamento = $oOpAex11->dtanulacao;
                    $oAex11->si130_nroanulacaoop = $oOpAex11->nroop;
                    $oAex11->si130_dtanulacaoop = $oOpAex11->dtanulacao;
                    $oAex11->si130_vlanulacaoop = $oOpAex11->vlop;
                    $oAex11->si130_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                    $oAex11->si130_instit = db_getsession("DB_instit");
                    $oAex11->si130_reg10 = 0;
                    $aAex10Agrupa[$sHash]->aex11[$sHash]->si130_vlanulacaoop += $oOpAex11->vlop;


                  }

                }
              }
              $aAex10Agrupa[$sHash]->si129_vlanulacao += $oAex10->vlanulacao;
            }

          }

        }

      }

    }
    //echo "<pre>";print_r($aAex10Agrupa);

    foreach ($aAex10Agrupa as $oDados10) {

      $claex = new cl_aex102017();

      $claex->si129_tiporegistro = $oDados10->si129_tiporegistro;
      $claex->si129_codreduzidoaex = $oDados10->si129_codreduzidoaex;
      $claex->si129_codorgao = $oDados10->si129_codorgao;
      $claex->si129_codext = $oDados10->si129_codext;
      $claex->si129_codfontrecursos = $oDados10->si129_codfontrecursos;
      $claex->si129_categoria = $oDados10->si129_categoria;
      $claex->si129_dtlancamento = $oDados10->si129_dtlancamento;
      $claex->si129_dtanulacaoextra = $oDados10->si129_dtanulacaoextra;
      $claex->si129_justificativaanulacao = $oDados10->si129_justificativaanulacao;
      $claex->si129_vlanulacao = $oDados10->si129_vlanulacao;
      $claex->si129_instit = $oDados10->si129_instit;
      $claex->si129_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

      $claex->incluir(null);

      if ($claex->erro_status == 0) {
        throw new Exception($claex->erro_msg);
      }
      if ($oDados10->si129_categoria == 2) {
        foreach ($oDados10->aex11 as $oDados11) {

          $aex11 = new cl_aex112017();

          $aex11->si130_tiporegistro = $oDados11->si130_tiporegistro;
          $aex11->si130_codreduzidoaex = $oDados11->si130_codreduzidoaex;
          $aex11->si130_nroop = $oDados11->si130_nroop;
          $aex11->si130_dtpagamento = $oDados11->si130_dtpagamento;
          $aex11->si130_nroanulacaoop = $oDados11->si130_nroanulacaoop;
          $aex11->si130_dtanulacaoop = $oDados11->si130_dtanulacaoop;
          $aex11->si130_vlanulacaoop = $oDados11->si130_vlanulacaoop;
          $aex11->si130_mes = $oDados11->si130_mes;
          $aex11->si130_instit = $oDados10->si129_instit;
          $aex11->si130_reg10 = $claex->si129_sequencial;

          $aex11->incluir(null);
          if ($aex11->erro_status == 0) {
            throw new Exception($aex11->erro_msg);
          }

        }
      }


    }
    db_fim_transacao();
    $oGerarAEX = new GerarAEX();
    $oGerarAEX->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];;
    $oGerarAEX->gerarDados();

  }

}
