<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarCONV extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;

  public function gerarDados()
  {

    $this->sArquivo = "CONV";
    $this->abreArquivo();

    $sSql = "select * from conv102020 where si92_mes = " . $this->iMes . " and si92_instit = " . db_getsession("DB_instit");
    $rsCONV10 = db_query($sSql);

    $sSql2 = "select * from conv112020 where si93_mes = " . $this->iMes . " and si93_instit = " . db_getsession("DB_instit");
    $rsCONV11 = db_query($sSql2);

    $sSql3 = "select * from conv202020 where si94_mes = " . $this->iMes . " and si94_instit = " . db_getsession("DB_instit");
    $rsCONV20 = db_query($sSql3);

    $sSql4 = "select * from conv212020 where si232_mes = " . $this->iMes . " and si232_instint = " . db_getsession("DB_instit");
    $rsCONV21 = db_query($sSql4);

    $sSql5 = "select * from conv302020 where si203_mes = " . $this->iMes . " and si203_instit = " . db_getsession("DB_instit");
    $rsCONV30 = db_query($sSql5);

    $sSql6 = "select * from conv312020 where si204_mes = " . $this->iMes . " and si204_instit = " . db_getsession("DB_instit");
    $rsCONV31 = db_query($sSql6);

    //echo $sSql."-".$sSql3; exit;


    if (pg_num_rows($rsCONV10) == 0 && pg_num_rows($rsCONV20) == 0 && pg_num_rows($rsCONV30) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {

      /**
       *
       * Registros 10, 11
       */
      for ($iCont = 0; $iCont < pg_num_rows($rsCONV10); $iCont++) {

        $aCONV10 = pg_fetch_array($rsCONV10, $iCont);

        $aCSVCONV10['si92_tiporegistro']        = $this->padLeftZero($aCONV10['si92_tiporegistro'], 2);
        $aCSVCONV10['si92_codconvenio']         = substr($aCONV10['si92_codconvenio'], 0, 15);
        $aCSVCONV10['si92_codorgao']            = $this->padLeftZero($aCONV10['si92_codorgao'], 2);
        $aCSVCONV10['si92_nroconvenio']         = substr($aCONV10['si92_nroconvenio'], 0, 30);
        $aCSVCONV10['si92_dataassinatura']      = $this->sicomDate($aCONV10['si92_dataassinatura']);
        $aCSVCONV10['si92_objetoconvenio']      = substr($aCONV10['si92_objetoconvenio'], 0, 500);
        $aCSVCONV10['si92_datainiciovigencia']  = $this->sicomDate($aCONV10['si92_datainiciovigencia']);
        $aCSVCONV10['si92_datafinalvigencia']   = $this->sicomDate($aCONV10['si92_datafinalvigencia']);
        $aCSVCONV10['si92_codfontrecursos']     = $aCONV10['si92_codfontrecursos'];
        $aCSVCONV10['si92_vlconvenio']          = $this->sicomNumberReal($aCONV10['si92_vlconvenio'], 2);
        $aCSVCONV10['si92_vlcontrapartida']     = $this->sicomNumberReal($aCONV10['si92_vlcontrapartida'], 2);

        $this->sLinha = $aCSVCONV10;
        $this->adicionaLinha();

        for ($iCont2 = 0; $iCont2 < pg_num_rows($rsCONV11); $iCont2++) {

          $aCONV11 = pg_fetch_array($rsCONV11, $iCont2);

          if ($aCONV10['si92_sequencial'] == $aCONV11['si93_reg10']) {

            $aCSVCONV11['si93_tiporegistro']      = $this->padLeftZero($aCONV11['si93_tiporegistro'], 2);
            $aCSVCONV11['si93_codconvenio']       = substr($aCONV11['si93_codconvenio'], 0, 15);
            $aCSVCONV11['si93_tipodocumento']     = $aCONV11['si93_esferaconcedente'] == 4 && empty($aCONV11['si92_tiporegistro']) ? "" : $this->padLeftZero($aCONV11['si93_tipodocumento'], 1);
            $aCSVCONV11['si93_nrodocumento']      = $aCONV11['si93_esferaconcedente'] == 4 ? "" : $this->padLeftZero($aCONV11['si93_nrodocumento'], 14);
            $aCSVCONV11['si93_esferaconcedente']  = $this->padLeftZero($aCONV11['si93_esferaconcedente'], 1);
            $aCSVCONV11['si93_dscexterior']       = $aCONV11['si93_dscexterior'] != "null" ? $aCONV11['si93_dscexterior'] : '';
            $aCSVCONV11['si93_valorconcedido']    = $this->sicomNumberReal($aCONV11['si93_valorconcedido'], 2);

            $this->sLinha = $aCSVCONV11;
            $this->adicionaLinha();
          }

        }

      }

      /**
       *
       * Registros 20 e 21
       */
      for ($iCont3 = 0; $iCont3 < pg_num_rows($rsCONV20); $iCont3++) {

        $aCONV20 = pg_fetch_array($rsCONV20, $iCont3);

        $aCSVCONV20['si94_tiporegistro']                  = $this->padLeftZero($aCONV20['si94_tiporegistro'], 2);
        $aCSVCONV20['si94_codorgao']                      = $this->padLeftZero($aCONV20['si94_codorgao'], 2);
        $aCSVCONV20['si94_nroconvenio']                   = substr($aCONV20['si94_nroconvenio'], 0, 30);
        $aCSVCONV20['si94_dtassinaturaconvoriginal']      = $this->sicomDate($aCONV20['si94_dtassinaturaconvoriginal']);
        $aCSVCONV20['si94_nroseqtermoaditivo']            = $this->padLeftZero($aCONV20['si94_nroseqtermoaditivo'], 2);
        $aCSVCONV20['si94_codconvaditivo']                = $aCONV20['si94_codconvaditivo'];
        $aCSVCONV20['si94_dscalteracao']                  = substr($aCONV20['si94_dscalteracao'], 0, 500);
        $aCSVCONV20['si94_dtassinaturatermoaditivo']      = $this->sicomDate($aCONV20['si94_dtassinaturatermoaditivo']);
        $aCSVCONV20['si94_datafinalvigencia']             = $this->sicomDate($aCONV20['si94_datafinalvigencia']);
        $aCSVCONV20['si94_valoratualizadoconvenio']       = $this->sicomNumberReal($aCONV20['si94_valoratualizadoconvenio'], 2);
        $aCSVCONV20['si94_valoratualizadocontrapartida']  = $this->sicomNumberReal($aCONV20['si94_valoratualizadocontrapartida'], 2);

        $this->sLinha = $aCSVCONV20;
        $this->adicionaLinha();

        for ($iCont2 = 0; $iCont2 < pg_num_rows($rsCONV21); $iCont2++) {

          $aCONV21 = pg_fetch_array($rsCONV21, $iCont2);

          if ($aCONV20['si94_codconvaditivo'] == $aCONV21['si232_codconvaditivo']) {

            $aCSVCONV21['si232_tiporegistro']         = $this->padLeftZero($aCONV21['si232_tiporegistro'], 2);
            $aCSVCONV21['si232_codconvaditivo']       = $aCONV21['si232_codconvaditivo'];
            $aCSVCONV21['si232_tipotermoaditivo']     = $this->padLeftZero($aCONV21['si232_tipotermoaditivo'], 2);
            $aCSVCONV21['si232_dsctipotermoaditivo']  = substr($aCONV21['si232_dsctipotermoaditivo'], 0, 250);

            $this->sLinha = $aCSVCONV21;
            $this->adicionaLinha();

          }

        }

      }

        /**
         *
         * Registros 30
         */
        for ($iCont4 = 0; $iCont4 < pg_num_rows($rsCONV30); $iCont4++) {

            $aCONV30 = pg_fetch_array($rsCONV30, $iCont4);

            $aCSVCONV30['si203_tiporegistro']                 = $this->padLeftZero($aCONV30['si203_tiporegistro'], 2);
            $aCSVCONV30['si203_codreceita']                   = $aCONV30['si203_codreceita'];
            $aCSVCONV30['si203_codorgao']                     = $this->padLeftZero($aCONV30['si203_codorgao'], 2);
            $aCSVCONV30['si203_naturezareceita']              = substr($aCONV30['si203_naturezareceita'], 1, 8);
            $aCSVCONV30['si203_codfontrecursos']              = $this->padLeftZero($aCONV30['si203_codfontrecursos'], 3);
            $aCSVCONV30['si203_vlprevisao']                   = $this->sicomNumberReal($aCONV30['si203_vlprevisao'], 2);

            $this->sLinha = $aCSVCONV30;
            $this->adicionaLinha();

            /**
             *
             * Registros 31
             */
            for ($iCont5 = 0; $iCont5 < pg_num_rows($rsCONV31); $iCont5++) {

                $aCONV31 = pg_fetch_array($rsCONV31, $iCont5);

                if ($aCONV30['si203_codreceita'] == $aCONV31['si204_codreceita']) {

                    $aCSVCONV31['si204_tiporegistro']                 = $this->padLeftZero($aCONV31['si204_tiporegistro'], 2);
                    $aCSVCONV31['si204_codreceita'] = $aCONV31['si204_codreceita'];
                    $aCSVCONV31['si204_prevorcamentoassin'] = $aCONV31['si204_prevorcamentoassin'];
                    $aCSVCONV31['si204_nroconvenio'] = $aCONV31['si204_nroconvenio'];
                    $aCSVCONV31['si204_dataassinatura'] = $this->sicomDate($aCONV31['si204_dataassinatura']);
                    $aCSVCONV31['si204_vlprevisaoconvenio'] = $this->sicomNumberReal($aCONV31['si204_vlprevisaoconvenio'], 2);

                    $this->sLinha = $aCSVCONV31;
                    $this->adicionaLinha();

                }

            }

        }


      $this->fechaArquivo();

    }

  }

}
