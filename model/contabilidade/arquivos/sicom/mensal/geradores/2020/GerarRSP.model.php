<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarRSP extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;

  public function gerarDados()
  {

    $this->sArquivo = "RSP";
    $this->abreArquivo();

    $sSql = "SELECT DISTINCT si112_sequencial,
                     si112_tiporegistro,
                     si112_codreduzidorsp,
                     si112_codorgao,
                     si112_codunidadesub,
                     si112_codunidadesuborig,
                     e60_codemp AS si112_nroempenho,
                     si112_exercicioempenho,
                     si112_dtempenho,
                     si112_dotorig,
                     si112_vloriginal,
                     si112_vlsaldoantproce,
                     si112_vlsaldoantnaoproc,
                     si112_mes,
                     si112_instit
             FROM rsp102020
             INNER JOIN empempenho ON e60_codemp::int8 = si112_nroempenho AND e60_anousu = si112_exercicioempenho
             WHERE si112_mes = " . $this->iMes . "
               AND si112_instit = " . db_getsession("DB_instit");
    $rsRSP10 = db_query($sSql);

    $sSql2 = "select * from rsp112020 where si113_mes = " . $this->iMes . " and si113_instit = " . db_getsession("DB_instit");
    $rsRSP11 = db_query($sSql2);

    $sSql3 = "select * from rsp122020 where si114_mes = " . $this->iMes . " and si114_instit = " . db_getsession("DB_instit");
    $rsRSP12 = db_query($sSql3);

    $sSql4 = "SELECT DISTINCT si115_sequencial,
                     si115_tiporegistro,
                     si115_codreduzidomov,
                     si115_codorgao,
                     si115_codunidadesub,
                     si115_codunidadesuborig,
                     e60_codemp AS si115_nroempenho,
                     si115_exercicioempenho,
                     si115_dtempenho,
                     si115_tiporestospagar,
                     si115_tipomovimento,
                     si115_dtmovimentacao,
                     si115_dotorig,
                     si115_vlmovimentacao,
                     si115_codorgaoencampatribuic,
                     si115_codunidadesubencampatribuic,
                     si115_justificativa,
                     si115_atocancelamento,
                     si115_dataatocancelamento,
                     si115_mes,
                     si115_instit
              FROM rsp202020
              INNER JOIN empempenho ON e60_codemp::int8 = si115_nroempenho AND e60_anousu = si115_exercicioempenho
              WHERE si115_mes = " . $this->iMes . "
                AND si115_instit = " . db_getsession("DB_instit");
    $rsRSP20 = db_query($sSql4);

    $sSql5 = "select * from rsp212020 where si116_mes = " . $this->iMes . " and si116_instit = " . db_getsession("DB_instit");
    $rsRSP21 = db_query($sSql5);

    $sSql6 = "select * from rsp222020 where si117_mes = " . $this->iMes . " and si117_instit = " . db_getsession("DB_instit");
    $rsRSP22 = db_query($sSql6);

    if (pg_num_rows($rsRSP10) == 0 && pg_num_rows($rsRSP20) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {

      /**
       *
       * Registros 10, 11, 12
       */
      for ($iCont = 0; $iCont < pg_num_rows($rsRSP10); $iCont++) {

        $aRSP10 = pg_fetch_array($rsRSP10, $iCont);

        $aCSVRSP10['si112_tiporegistro']      = $this->padLeftZero($aRSP10['si112_tiporegistro'], 2);
        $aCSVRSP10['si112_codreduzidorsp']    = substr($aRSP10['si112_codreduzidorsp'], 0, 15);
        $aCSVRSP10['si112_codorgao']          = $this->padLeftZero($aRSP10['si112_codorgao'], 2);
        $aCSVRSP10['si112_codunidadesub']     = $this->padLeftZero($aRSP10['si112_codunidadesub'], 5);
        if($aRSP10['si112_exercicioempenho'] < 2013){
          $aCSVRSP10['si112_codunidadesuborig'] = $this->padLeftZero( substr($aRSP10['si112_codunidadesuborig'], 0, 5), 5);
        }else{
          $aCSVRSP10['si112_codunidadesuborig'] = strcasecmp($aRSP10['si112_codunidadesuborig']) <= 5 ? $this->padLeftZero($aRSP10['si112_codunidadesuborig'], 5)
        :$this->padLeftZero($aRSP10['si112_codunidadesuborig'], 8);
        }
        $aCSVRSP10['si112_nroempenho']        = substr($aRSP10['si112_nroempenho'], 0, 22);
        $aCSVRSP10['si112_exercicioempenho']  = $this->padLeftZero($aRSP10['si112_exercicioempenho'], 4);
        $aCSVRSP10['si112_dtempenho']         = $this->sicomDate($aRSP10['si112_dtempenho']);
        $aCSVRSP10['si112_dotorig']           = $aRSP10['si112_dotorig'] == '' ? ' ' : $this->padLeftZero($aRSP10['si112_dotorig'], (strlen($aRSP10['si112_dotorig']) <= 17) ? 17 : 21);
        $aCSVRSP10['si112_vloriginal']        = $this->sicomNumberReal($aRSP10['si112_vloriginal'], 2);
        $aCSVRSP10['si112_vlsaldoantproce']   = $this->sicomNumberReal($aRSP10['si112_vlsaldoantproce'], 2);
        $aCSVRSP10['si112_vlsaldoantnaoproc'] = $this->sicomNumberReal($aRSP10['si112_vlsaldoantnaoproc'], 2);

        $this->sLinha = $aCSVRSP10;
        $this->adicionaLinha();

        for ($iCont2 = 0; $iCont2 < pg_num_rows($rsRSP11); $iCont2++) {

          $aRSP11 = pg_fetch_array($rsRSP11, $iCont2);

          if ($aRSP10['si112_sequencial'] == $aRSP11['si113_reg10']) {

            $aCSVRSP11['si113_tiporegistro']            = $this->padLeftZero($aRSP11['si113_tiporegistro'], 2);
            $aCSVRSP11['si113_codreduzidorsp']          = substr($aRSP11['si113_codreduzidorsp'], 0, 15);
            $aCSVRSP11['si113_codfontrecursos']         = $this->padLeftZero($aRSP11['si113_codfontrecursos'], 3);
            $aCSVRSP11['si113_vloriginalfonte']         = $this->sicomNumberReal($aRSP11['si113_vloriginalfonte'], 2);
            $aCSVRSP11['si113_vlsaldoantprocefonte']    = $this->sicomNumberReal($aRSP11['si113_vlsaldoantprocefonte'], 2);
            $aCSVRSP11['si113_vlsaldoantnaoprocfonte']  = $this->sicomNumberReal($aRSP11['si113_vlsaldoantnaoprocfonte'], 2);

            $this->sLinha = $aCSVRSP11;
            $this->adicionaLinha();
          }

        }

        for ($iCont3 = 0; $iCont3 < pg_num_rows($rsRSP12); $iCont3++) {

          $aRSP12 = pg_fetch_array($rsRSP12, $iCont3);

          if ($aRSP10['si112_sequencial'] == $aRSP12['si114_reg10']) {

            $aCSVRSP12['si114_tiporegistro']    = $this->padLeftZero($aRSP12['si114_tiporegistro'], 2);
            $aCSVRSP12['si114_codreduzidorsp']  = substr($aRSP12['si114_codreduzidorsp'], 0, 15);
            $aCSVRSP12['si114_tipodocumento']   = $this->padLeftZero($aRSP12['si114_tipodocumento'], 1);
            $aCSVRSP12['si114_nrodocumento']    = substr($aRSP12['si114_nrodocumento'], 0, 14);

            $this->sLinha = $aCSVRSP12;
            $this->adicionaLinha();
          }

        }

      }

      /**
       *
       * Registros 20, 21, 22
       */
      for ($iCont4 = 0; $iCont4 < pg_num_rows($rsRSP20); $iCont4++) {

        $aRSP20 = pg_fetch_array($rsRSP20, $iCont4);

        $aCSVRSP20['si115_tiporegistro']                = $this->padLeftZero($aRSP20['si115_tiporegistro'], 2);
        $aCSVRSP20['si115_codreduzidomov']              = substr($aRSP20['si115_codreduzidomov'], 0, 15);
        $aCSVRSP20['si115_codorgao']                    = $this->padLeftZero($aRSP20['si115_codorgao'], 2);
        $aCSVRSP20['si115_codunidadesub']               = $this->padLeftZero($aRSP20['si115_codunidadesub'], 5);
        if($aRSP20['si115_exercicioempenho'] < 2013){
            $aCSVRSP20['si115_codunidadesuborig'] = $this->padLeftZero( substr($aRSP20['si115_codunidadesuborig'], 0, 5), 5);
        }else{
            $aCSVRSP20['si115_codunidadesuborig'] = strcasecmp($aRSP20['si115_codunidadesuborig']) <= 5 ? $this->padLeftZero($aRSP20['si115_codunidadesuborig'], 5)
                :$this->padLeftZero($aRSP20['si115_codunidadesuborig'], 8);
        }
        $aCSVRSP20['si115_nroempenho']                  = substr($aRSP20['si115_nroempenho'], 0, 22);
        $aCSVRSP20['si115_exercicioempenho']            = $this->padLeftZero($aRSP20['si115_exercicioempenho'], 4);
        $aCSVRSP20['si115_dtempenho']                   = $this->sicomDate($aRSP20['si115_dtempenho']);
        $aCSVRSP20['si115_tiporestospagar']             = $this->padLeftZero($aRSP20['si115_tiporestospagar'], 1);
        $aCSVRSP20['si115_tipomovimento']               = $this->padLeftZero($aRSP20['si115_tipomovimento'], 1);
        $aCSVRSP20['si115_dtmovimentacao']              = $this->sicomDate($aRSP20['si115_dtmovimentacao']);
        $aCSVRSP20['si115_dotorig']                     = $aRSP20['si115_dotorig'] == '' ? ' ' : $this->padLeftZero($aRSP20['si115_dotorig'], (strlen($aRSP20['si115_dotorig']) <= 17 ? 17 : 21));
        $aCSVRSP20['si115_vlmovimentacao']              = $this->sicomNumberReal($aRSP20['si115_vlmovimentacao'], 2);
        $aCSVRSP20['si115_codorgaoencampatribuic']      = $aRSP20['si115_codorgaoencampatribuic'] == '' ? ' ' : $this->padLeftZero($aRSP20['si115_codorgaoencampatribuic'], 2);
        $aCSVRSP20['si115_codunidadesubencampatribuic'] = $aRSP20['si115_codunidadesubencampatribuic'] == '' ? ' ' : $this->padLeftZero($aRSP20['si115_codunidadesubencampatribuic'], (strlen($aRSP20['si115_codunidadesubencampatribuic'] <= 5 ? 5 : 8)));
        $aCSVRSP20['si115_justificativa']               = substr($aRSP20['si115_justificativa'], 0, 500);
        $aCSVRSP20['si115_atocancelamento']             = substr($aRSP20['si115_atocancelamento'], 0, 20);
        $aCSVRSP20['si115_dataatocancelamento']         = $this->sicomDate($aRSP20['si115_dataatocancelamento']);

        $this->sLinha = $aCSVRSP20;
        $this->adicionaLinha();

        for ($iCont5 = 0; $iCont5 < pg_num_rows($rsRSP21); $iCont5++) {

          $aRSP21 = pg_fetch_array($rsRSP21, $iCont5);

          if ($aRSP20['si115_sequencial'] == $aRSP21['si116_reg20']) {

            $aCSVRSP21['si116_tiporegistro']        = $this->padLeftZero($aRSP21['si116_tiporegistro'], 2);
            $aCSVRSP21['si116_codreduzidomov']      = substr($aRSP21['si116_codreduzidomov'], 0, 15);
            $aCSVRSP21['si116_codfontrecursos']     = $this->padLeftZero($aRSP21['si116_codfontrecursos'], 3);
            $aCSVRSP21['si116_vlmovimentacaofonte'] = $this->sicomNumberReal($aRSP21['si116_vlmovimentacaofonte'], 2);

            $this->sLinha = $aCSVRSP21;
            $this->adicionaLinha();
          }

        }

        for ($iCont6 = 0; $iCont6 < pg_num_rows($rsRSP22); $iCont6++) {

          $aRSP22 = pg_fetch_array($rsRSP22, $iCont6);

          if ($aRSP20['si115_sequencial'] == $aRSP22['si117_reg20']) {

            $aCSVRSP22['si117_tiporegistro']    = $this->padLeftZero($aRSP22['si117_tiporegistro'], 2);
            $aCSVRSP22['si117_codreduzidomov']  = substr($aRSP22['si117_codreduzidomov'], 0, 15);
            $aCSVRSP22['si117_tipodocumento']   = $this->padLeftZero($aRSP22['si117_tipodocumento'], 1);
            $aCSVRSP22['si117_nrodocumento']    = substr($aRSP22['si117_nrodocumento'], 0, 14);

            $this->sLinha = $aCSVRSP22;
            $this->adicionaLinha();
          }

        }

      }

      $this->fechaArquivo();

    }

  }

}
