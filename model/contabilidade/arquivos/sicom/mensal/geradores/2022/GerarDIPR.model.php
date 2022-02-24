<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarDIPR extends GerarAM
{

    /**
     *
     * Mes de referência
     * @var Integer
     */
    public $iMes;

    public function gerarDados()
    {

        $this->sArquivo = "DIPR";
        $this->abreArquivo();

        $sSql = "select * from dipr102022 where si230_mes = " . $this->iMes . " and si230_instit = " . db_getsession("DB_instit");
        $rsCONV10 = db_query($sSql);

        $sSql2 = "select * from conv112022 where si93_mes = " . $this->iMes . " and si93_instit = " . db_getsession("DB_instit");
        $rsCONV11 = db_query($sSql2);

        $sSql3 = "select * from conv202022 where si94_mes = " . $this->iMes . " and si94_instit = " . db_getsession("DB_instit");
        $rsCONV20 = db_query($sSql3);

        $sSql4 = "select * from conv212022 where si232_mes = " . $this->iMes . " and si232_instint = " . db_getsession("DB_instit");
        $rsCONV21 = db_query($sSql4);

        $sSql5 = "select * from conv302022 where si203_mes = " . $this->iMes . " and si203_instit = " . db_getsession("DB_instit");
        $rsCONV30 = db_query($sSql5);

        $sSql6 = "select * from conv312022 where si204_mes = " . $this->iMes . " and si204_instit = " . db_getsession("DB_instit");
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
                $aDIPR10 = pg_fetch_array($rsCONV10, $iCont);

                $aCSVDIPR10['si230_tiporegistro']    = $this->padLeftZero($aDIPR10['si230_tiporegistro'], 2);
                $aCSVDIPR10['si230_coddipr']         = substr($aDIPR10['si230_coddipr'], 0, 20);
                $aCSVDIPR10['si230_segregacaomassa'] = $aDIPR10['si230_segregacaomassa'];
                $aCSVDIPR10['si230_benefcustesouro'] = $aDIPR10['si230_benefcustesouro'];
                $aCSVDIPR10['si230_atonormativo']    = substr($aDIPR10['si230_atonormativo'], 0, 6);
                $aCSVDIPR10['si230_exercicioato']    = substr($aDIPR10['si230_exercicioato'], 0, 4);

                $this->sLinha = $aCSVDIPR10;
                $this->adicionaLinha();
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
