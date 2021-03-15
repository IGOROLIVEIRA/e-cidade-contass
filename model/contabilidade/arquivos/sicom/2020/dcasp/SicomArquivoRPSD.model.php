<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_rpsd102020_classe.php");
require_once("classes/db_rpsd112020_classe.php");
require_once("model/contabilidade/arquivos/sicom/2020/dcasp/geradores/GerarRPSD.model.php");



class SicomArquivoRPSD extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  protected $iCodigoLayout = 0;

  protected $sNomeArquivo = 'RPSD';

  protected $sTipoGeracao;

  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }

  public function getCampos(){
    return array();
  }

  public function getTipoGeracao() {
    return $this->sTipoGeracao;
  }

  public function setTipoGeracao($sTipoGeracao) {
    $this->sTipoGeracao = $sTipoGeracao;
  }

  public function __construct() { }

  public function gerarDados()
  {
    $iAnousu    = db_getsession("DB_anousu");
    $iCodInstit = db_getsession("DB_instit");

    $clrpsd10 = new cl_rpsd102020();
    $clrpsd11 = new cl_rpsd112020();

    db_inicio_transacao();
    /**
     * excluir informacoes do mes selecionado
     */
    $result = $clrpsd11->sql_record($clrpsd11->sql_query(NULL,"*",NULL,"si190_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si190_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clrpsd11->excluir(NULL,"si190_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si190_instit = ".db_getsession("DB_instit"));
      if ($clrpsd11->erro_status == 0) {
        throw new Exception($clrpsd11->erro_msg);
      }
    }

    $result = $clrpsd10->sql_record($clrpsd10->sql_query(NULL,"*",NULL,"si189_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si189_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clrpsd10->excluir(NULL,"si189_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si189_instit = ".db_getsession("DB_instit"));
      if ($clrpsd10->erro_status == 0) {
        throw new Exception($clrpsd10->erro_msg);
      }
    }

      $sSqlGeral = "select codigo from db_config ";
      $rsInstit = db_query($sSqlGeral);

      for ($iCont = 0;$iCont < pg_num_rows($rsInstit); $iCont++) {

          if($this->getTipoGeracao() == 'ISOLADO'){
              break;
          }

          $oInstit = db_utils::fieldsMemory($rsInstit,$iCont);

          $aFontes = array('101','102','118','119');
          foreach ($aFontes as $iFonte) {

              $rsSaldoFontes = db_query($this->sql_query_saldoInicialContaCorrente($iFonte, $oInstit->codigo, db_getsession("DB_anousu")));
              $oSaldoFontes = db_utils::fieldsMemory($rsSaldoFontes, 0);
              $nSaldoFinal = ($oSaldoFontes->saldoanterior);

              $sSqlRP = "SELECT  10 AS tiporegistro,
                      e60_numemp AS codreduzidorsp,
                    CASE WHEN orcorgao.o40_codtri = '0'
                    OR NULL THEN orcorgao.o40_orgao :: VARCHAR ELSE orcorgao.o40_codtri END AS o58_orgao,
                    CASE WHEN orcunidade.o41_codtri = '0'
                    OR NULL THEN orcunidade.o41_unidade :: VARCHAR ELSE orcunidade.o41_codtri END AS o58_unidade,
                    si09_codorgaotce AS codorgao,
                    lpad((
                            CASE WHEN orcorgao.o40_codtri = '0'
                            OR NULL THEN orcorgao.o40_orgao :: VARCHAR ELSE orcorgao.o40_codtri END ),2,0) 
                            || lpad((
                            CASE WHEN orcunidade.o41_codtri = '0'
                            OR NULL THEN orcunidade.o41_unidade :: VARCHAR ELSE orcunidade.o41_codtri END
                        ),3,0) AS codunidadesub,
                    e60_codemp AS nroempenho,
                    e60_anousu AS exercicioempenho,
                    e60_emiss AS dtEmpenho,   
                    o15_codtri AS codfontrecursos,
                    CASE WHEN c53_coddoc = 35 THEN 1 ELSE 2 END AS tipopagamentorsp,
                    sum(CASE WHEN c53_tipo = 31 then c70_valor * -1 else c70_valor end)  as vlpagofontersp
                FROM empempenho 
                    INNER JOIN orcdotacao ON e60_coddot = o58_coddot
                           AND e60_anousu = o58_anousu
                    INNER JOIN orcprojativ ON o58_anousu = o55_anousu
                           AND o58_projativ = o55_projativ
                    INNER JOIN orctiporec ON o58_codigo = o15_codigo
                    INNER JOIN conlancamemp ON c75_numemp=e60_numemp
                    INNER JOIN conlancam ON c75_codlan=c70_codlan
                    INNER JOIN conlancamdoc ON c75_codlan = c71_codlan
                    INNER JOIN conhistdoc ON c71_coddoc = c53_coddoc
                     LEFT JOIN infocomplementaresinstit ON si09_instit = e60_instit
                     LEFT JOIN orcunidade ON o58_anousu = orcunidade.o41_anousu
                           AND o58_orgao = orcunidade.o41_orgao
                           AND o58_unidade = orcunidade.o41_unidade
                     LEFT JOIN orcorgao ON orcorgao.o40_orgao = orcunidade.o41_orgao
                           AND orcorgao.o40_anousu = orcunidade.o41_anousu                   
                WHERE c53_tipo in (30,31) and e60_instit = ".$oInstit->codigo." and o15_codtri = '" . $iFonte . "' 
                and DATE_PART('YEAR',c70_data) = ".db_getsession("DB_anousu") ."
                and e60_anousu < ".db_getsession("DB_anousu") ."
                      group by 1,2,3,4,5,6,7,8,9,10,11
                      order by e60_emiss";
              $rsRPPago = db_query($sSqlRP);


              $nTotalRPPago = 0;
              for ($iContRP = 0; $iContRP < pg_num_rows($rsRPPago); $iContRP++) {

                  $clrpsd10 = new cl_rpsd102020();

                  $oDadosRPSD = db_utils::fieldsMemory($rsRPPago, $iContRP);

                  if (($nSaldoFinal >= $nTotalRPPago) || $oDadosRPSD->vlpagofontersp == 0) {
                      $nTotalRPPago += $oDadosRPSD->vlpagofontersp;
                  }
                  /**
                   * Verifica se o empenho existe na tabela dotacaorpsicom
                   * Caso exista, busca os dados da dotação.
                   **/
                  $sSqlDotacaoRpSicom = "select * from dotacaorpsicom where si177_numemp = {$oDadosRPSD->codreduzidorsp}";
                  $iFonteAlterada = 0;
                  if (pg_num_rows(db_query($sSqlDotacaoRpSicom)) > 0) {

                      $aDotacaoRpSicom = db_utils::getColectionByRecord(db_query($sSqlDotacaoRpSicom));
                      $clrpsd10->si189_codunidadesub = strlen($aDotacaoRpSicom[0]->si177_codunidadesub) != 5 && strlen($aDotacaoRpSicom[0]->si177_codunidadesub) != 8 ? "0" . $aDotacaoRpSicom[0]->si177_codunidadesub : $aDotacaoRpSicom[0]->si177_codunidadesub;
                      $clrpsd10->si189_codunidadesuborig = strlen($aDotacaoRpSicom[0]->si177_codunidadesuborig) != 5 && strlen($aDotacaoRpSicom[0]->si177_codunidadesuborig) != 8 ? "0" . $aDotacaoRpSicom[0]->si177_codunidadesuborig : $aDotacaoRpSicom[0]->si177_codunidadesuborig;
                      $iFonteAlterada = str_pad($aDotacaoRpSicom[0]->si177_codfontrecursos, 3, "0", STR_PAD_LEFT);

                  } else {
                      $clrpsd10->si189_codunidadesub = $oDadosRPSD->codunidadesub;
                      $clrpsd10->si189_codunidadesuborig = $oDadosRPSD->codunidadesub;
                      $iFonteAlterada = $oDadosRPSD->codfontrecursos;
                  }
                  $clrpsd10->si189_tiporegistro = $oDadosRPSD->tiporegistro;
                  $clrpsd10->si189_codreduzidorsp = $oDadosRPSD->codreduzidorsp;
                  $clrpsd10->si189_codorgao = $oDadosRPSD->codorgao;
                  $clrpsd10->si189_nroempenho = $oDadosRPSD->nroempenho;
                  $clrpsd10->si189_exercicioempenho = $oDadosRPSD->exercicioempenho;
                  $clrpsd10->si189_dtempenho = $oDadosRPSD->dtempenho;
                  $clrpsd10->si189_tipopagamentorsp = $oDadosRPSD->tipopagamentorsp;
                  $clrpsd10->si189_vlpagorsp = $oDadosRPSD->vlpagofontersp;
                  $clrpsd10->si189_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                  $clrpsd10->si189_instit = $iCodInstit;

                  $clrpsd10->incluir(null);

                  if ($clrpsd10->erro_status == 0) {
                      throw new Exception($clrpsd10->erro_msg);
                  }
                  $clrpsd11 = new cl_rpsd112020();
                  $clrpsd11->si190_tiporegistro = 11;
                  $clrpsd11->si190_codreduzidorsp = $oDadosRPSD->codreduzidorsp;
                  $clrpsd11->si190_codfontrecursos = $iFonteAlterada;
                  $clrpsd11->si190_vlpagofontersp = $oDadosRPSD->vlpagofontersp;
                  $clrpsd11->si190_reg10 = $clrpsd10->si189_sequencial;
                  $clrpsd11->si190_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                  $clrpsd11->si190_instit = $iCodInstit;

                  $clrpsd11->incluir(null);
                  if ($clrpsd11->erro_status == 0) {
                      throw new Exception($clrpsd11->erro_msg);
                  }
              }
          }
      }

      db_fim_transacao();

      $oGerarRPSD = new GerarRPSD();
      $oGerarRPSD->iAnousu     = $iAnousu;
      $oGerarRPSD->iCodInstit  = $iCodInstit;
      $oGerarRPSD->iMes =  $this->sDataFinal['5'].$this->sDataFinal['6'];
      $oGerarRPSD->gerarDados();

  }
    function sql_query_saldoInicialContaCorrente ($iFonte=null, $sIntituicoes, $iAno=null){

        $sSqlReduzSuperavit = "select c61_reduz from conplano inner join conplanoreduz on c60_codcon=c61_codcon and c61_anousu=c60_anousu 
                             where substr(c60_estrut,1,5)='82111' and c60_anousu=" . $iAno ." and c61_anousu=" . $iAno;
        $sWhere =  " AND conhistdoc.c53_tipo not in (1000) ";

        if($iAno==2018){
            $iAno = 2020;
            $sSqlReduzSuperavit = "select c61_reduz from conplano inner join conplanoreduz on c60_codcon=c61_codcon and c61_anousu=c60_anousu 
                             where substr(c60_estrut,1,5)='82910' and c60_anousu=2020 and c61_anousu=2020";
            $sWhere =  " AND conhistdoc.c53_tipo in (2023) ";
        }


        $sSqlReduzSuperavit = $sSqlReduzSuperavit." and c61_instit in (".$sIntituicoes.")";


        $sSqlSaldos = " SELECT saldoanterior , debito , credito
                                        FROM
                                          (select coalesce((SELECT SUM(saldoanterior) AS saldoanterior FROM
                                                    (SELECT CASE WHEN c29_debito > 0 THEN c29_debito WHEN c29_credito > 0 THEN -1 * c29_credito ELSE 0 END AS saldoanterior
                                                     FROM contacorrente
                                                     INNER JOIN contacorrentedetalhe ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                                                     INNER JOIN contacorrentesaldo ON contacorrentesaldo.c29_contacorrentedetalhe = contacorrentedetalhe.c19_sequencial
                                                     AND contacorrentesaldo.c29_mesusu = 0 and contacorrentesaldo.c29_anousu = c19_conplanoreduzanousu
                                                     WHERE c19_reduz IN ( $sSqlReduzSuperavit )
                                                       AND c19_conplanoreduzanousu = " . $iAno . "
                                                       AND c17_sequencial = 103
                                                       AND c19_orctiporec = {$iFonte}) as x),0) saldoanterior) AS saldoanteriores,

                                            (select coalesce((SELECT sum(c69_valor) as credito
                                             FROM conlancamval
                                             INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                             AND conlancam.c70_anousu = conlancamval.c69_anousu
                                             INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                             INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                             INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                             INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                             INNER JOIN contacorrente ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                                             WHERE c28_tipo = 'C'
                                               AND DATE_PART('YEAR',c69_data) = " . $iAno . "
                                               AND c17_sequencial = 103
                                               AND c19_reduz IN (  $sSqlReduzSuperavit  )
                                               AND c19_conplanoreduzanousu = " . $iAno . "
                                               AND c19_orctiporec = {$iFonte}
                                              ".$sWhere."
                                             GROUP BY c28_tipo),0) as credito) AS creditos,

                                            (select coalesce((SELECT sum(c69_valor) as debito
                                             FROM conlancamval
                                             INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                             AND conlancam.c70_anousu = conlancamval.c69_anousu
                                             INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                             INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                             INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                             INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                             INNER JOIN contacorrente  ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                                             WHERE c28_tipo = 'D'
                                               AND DATE_PART('YEAR',c69_data) = " . $iAno . "
                                               AND c17_sequencial = 103
                                               AND c19_reduz IN ( $sSqlReduzSuperavit )
                                               AND c19_conplanoreduzanousu = " . $iAno . "
                                               AND c19_orctiporec = {$iFonte} 
                                               ".$sWhere."                                              
                                             GROUP BY c28_tipo),0) as debito) AS debitos";

        return $sSqlSaldos;


    }

}