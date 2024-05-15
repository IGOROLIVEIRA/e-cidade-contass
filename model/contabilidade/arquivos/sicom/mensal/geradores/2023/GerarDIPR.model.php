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

        $sSql = "select * from dipr102023 where si230_mes = " . $this->iMes . " and si230_instit = " . db_getsession("DB_instit");
        $rsDIPR10 = db_query($sSql);

        $sSql = "select * from dipr202023 where si231_mes = " . $this->iMes . " and si231_instit = " . db_getsession("DB_instit");
        $rsDIPR20 = db_query($sSql);

        $sSql = "select * from dipr302023 where si232_mes = " . $this->iMes . " and si232_instit = " . db_getsession("DB_instit");
        $rsDIPR30 = db_query($sSql);

        $sSql = "select * from dipr402023 where si233_mes = " . $this->iMes . " and si233_instit = " . db_getsession("DB_instit");
        $rsDIPR40 = db_query($sSql);

        $sSql = "select * from dipr502023 where si234_mes = " . $this->iMes . " and si234_instit = " . db_getsession("DB_instit");
        $rsDIPR50 = db_query($sSql);


        if (pg_num_rows($rsDIPR10) == 0 && pg_num_rows($rsDIPR20) == 0 && pg_num_rows($rsDIPR30) == 0 && pg_num_rows($rsDIPR40) == 0 && pg_num_rows($rsDIPR50) == 0) {
            $aCSV['tiporegistro'] = '99';
            $this->sLinha = $aCSV;
            $this->adicionaLinha();
        } else {
            /**
             *
             * Registros 10, 11
             */
            for ($iCont = 0; $iCont < pg_num_rows($rsDIPR10); $iCont++) {
                $aDIPR10 = pg_fetch_array($rsDIPR10, $iCont);

                $aCSVDIPR10['si230_tiporegistro']          = $this->padLeftZero($aDIPR10['si230_tiporegistro'], 2);
                $aCSVDIPR10['si230_tipocadastro']          = $aDIPR10['si230_tipocadastro'];
                $aCSVDIPR10['si230_segregacaomassa']       = $aDIPR10['si230_segregacaomassa'];
                $aCSVDIPR10['si230_benefcustesouro']       = $aDIPR10['si230_benefcustesouro'];
                $aCSVDIPR10['si230_atonormativo']          = substr($aDIPR10['si230_atonormativo'], 0, 6);
                $aCSVDIPR10['si230_dtatonormativo']        = $this->sicomDate($aDIPR10['si230_dtatonormativo']);
                $aCSVDIPR10['si230_nroatonormasegremassa'] = $aDIPR10['si230_nroatonormasegremassa'];
                $aCSVDIPR10['si230_dtatonormasegremassa']  = $this->sicomDate($aDIPR10['si230_dtatonormasegremassa']);
                $aCSVDIPR10['si230_planodefatuarial']      = $aDIPR10['si230_planodefatuarial'];
                $aCSVDIPR10['si230_atonormplanodefat']     = $aDIPR10['si230_atonormplanodefat'];
                $aCSVDIPR10['si230_dtatoplanodefat']       = $this->sicomDate($aDIPR10['si230_dtatoplanodefat']);

                $this->sLinha = $aCSVDIPR10;
                $this->adicionaLinha();
            }

            for ($iCont = 0; $iCont < pg_num_rows($rsDIPR20); $iCont++) {
                $aDIPR20 = pg_fetch_array($rsDIPR20, $iCont);

                $aCSVDIPR20['si231_tiporegistro']                    = $this->padLeftZero($aDIPR20['si231_tiporegistro'], 2);
                $aCSVDIPR20['si231_codorgao']                        = $this->padLeftZero($aDIPR20['si231_codorgao'], 2);
                $aCSVDIPR20['si231_tipobasecalculo']                 = $aDIPR20['si231_tipobasecalculo'];
                $aCSVDIPR20['si231_mescompetencia']                  = $this->padLeftZero($aDIPR20['si231_mescompetencia'], 2);
                $aCSVDIPR20['si231_exerciciocompetencia']            = $aDIPR20['si231_exerciciocompetencia'];
                $aCSVDIPR20['si231_tipofundo']                       = $aDIPR20['si231_tipofundo'];
                $aCSVDIPR20['si231_remuneracaobrutafolhapag']        = $this->sicomNumberReal($aDIPR20['si231_remuneracaobrutafolhapag'], 2);
                $aCSVDIPR20['si231_tipobasecalculocontrseg']         = $aDIPR20['si231_tipobasecalculocontrseg'] != "0" ? $aDIPR20['si231_tipobasecalculocontrseg'] : " ";
                $aCSVDIPR20['si231_tipobasecalculocontrprevidencia'] = $aDIPR20['si231_tipobasecalculocontrprevidencia'] != "0" ? $aDIPR20['si231_tipobasecalculocontrprevidencia'] : " ";
                $aCSVDIPR20['si231_valorbasecalculocontr']           = $this->sicomNumberReal($aDIPR20['si231_valorbasecalculocontr'], 2);
                $aCSVDIPR20['si231_tipocontribuicao']                = $aDIPR20['si231_tipocontribuicao'];
                $aCSVDIPR20['si231_aliquota']                        = $this->sicomNumberReal($aDIPR20['si231_aliquota'], 2);
                $aCSVDIPR20['si231_valorcontribdevida']              = $this->sicomNumberReal($aDIPR20['si231_valorcontribdevida'], 2);
          
                $this->sLinha = $aCSVDIPR20;
                $this->adicionaLinha();
            }

            for ($iCont = 0; $iCont < pg_num_rows($rsDIPR30); $iCont++) {
                $aDIPR30 = pg_fetch_array($rsDIPR30, $iCont);
   
                $aCSVDIPR30['si232_tiporegistro']           = $this->padLeftZero($aDIPR30['si232_tiporegistro'], 2);
                $aCSVDIPR30['si232_codorgao']               = $this->padLeftZero($aDIPR30['si232_codorgao'], 2);
                $aCSVDIPR30['si232_mescompetencia']         = $this->padLeftZero($aDIPR30['si232_mescompetencia'], 2);
                $aCSVDIPR30['si232_exerciciocompetencia']   = $aDIPR30['si232_exerciciocompetencia'];
                $aCSVDIPR30['si232_tipofundo']              = $aDIPR30['si232_tipofundo'];
                $aCSVDIPR30['si232_tiporepasse']            = $aDIPR30['si232_tiporepasse'];
                $aCSVDIPR30['si232_tipocontripatronal']     = $aDIPR30['si232_tipocontripatronal'] != "0" ? $aDIPR30['si232_tipocontripatronal'] : " ";
                $aCSVDIPR30['si232_tipocontrisegurado']     = $aDIPR30['si232_tipocontrisegurado'] != "0" ? $aDIPR30['si232_tipocontrisegurado'] : " ";
                $aCSVDIPR30['si232_tipocontribuicao']       = $aDIPR30['si232_tipocontribuicao'] != "0" ? $aDIPR30['si232_tipocontribuicao'] : " ";
                $aCSVDIPR30['si232_datarepasse']            = $this->sicomDate($aDIPR30['si232_datarepasse']);
                $aCSVDIPR30['si232_datavencirepasse']       = $this->sicomDate($aDIPR30['si232_datavencirepasse']);
                $aCSVDIPR30['si232_valororiginal']          = $this->sicomNumberReal($aDIPR30['si232_valororiginal'], 2);
                $aCSVDIPR30['si232_valorjuros']             = $this->sicomNumberReal($aDIPR30['si232_valorjuros'],2);
                $aCSVDIPR30['si232_valormulta']             = $this->sicomNumberReal($aDIPR30['si232_valormulta'],2);
                $aCSVDIPR30['si232_valoratualizacaomonetaria'] = $this->sicomNumberReal($aDIPR30['si232_valoratualizacaomonetaria'],2);
                $aCSVDIPR30['si232_valortotaldeducoes']     = $this->sicomNumberReal($aDIPR30['si232_valortotaldeducoes'],2);
                $aCSVDIPR30['si232_valororiginalrepassado'] = $this->sicomNumberReal($aDIPR30['si232_valororiginalrepassado'], 2);

                $this->sLinha = $aCSVDIPR30;
                $this->adicionaLinha();
            }
            // Foi Alterado número do registro de 40 para 31
            for ($iCont = 0; $iCont < pg_num_rows($rsDIPR40); $iCont++) {
                $aDIPR40 = pg_fetch_array($rsDIPR40, $iCont);
 
                $aCSVDIPR40['si233_tiporegistro']           = $this->padLeftZero($aDIPR40['si233_tiporegistro'], 2);
                $aCSVDIPR40['si233_codorgao']               = $this->padLeftZero($aDIPR40['si233_codorgao'], 2);
                $aCSVDIPR40['si233_mescompetencia']         = $this->padLeftZero($aDIPR40['si233_mescompetencia'], 2);
                $aCSVDIPR40['si233_exerciciocompetencia']   = $aDIPR40['si233_exerciciocompetencia'];
                $aCSVDIPR40['si233_tipofundo']              = $aDIPR40['si233_tipofundo'];
                $aCSVDIPR40['si233_tiporepasse']            = $aDIPR40['si233_tiporepasse'];
                $aCSVDIPR40['si233_tipocontripatronal']     = $aDIPR40['si233_tipocontripatronal'] != "0" ?  $aDIPR40['si233_tipocontripatronal'] : " ";
                $aCSVDIPR40['si233_tipocontrisegurado']     = $aDIPR40['si233_tipocontrisegurado'] != "0" ?  $aDIPR40['si233_tipocontrisegurado'] : " ";
                $aCSVDIPR40['si233_tipocontribuicao']       = $aDIPR40['si233_tipocontribuicao'] != "0" ?  $aDIPR40['si233_tipocontribuicao'] : " ";
                $aCSVDIPR40['si233_tipodeducao']            = $aDIPR40['si233_tipodeducao'] != "0" ?  $aDIPR40['si233_tipodeducao'] : " ";
                $aCSVDIPR40['si233_dsctiposdeducoes']       = $aDIPR40['si233_dsctiposdeducoes'];
                $aCSVDIPR40['si233_datarepasse']            = $this->sicomDate($aDIPR40['si233_datarepasse']);
                $aCSVDIPR40['si233_valordeducao']           = $this->sicomNumberReal($aDIPR40['si233_valordeducao'], 2);

                $this->sLinha = $aCSVDIPR40;
                $this->adicionaLinha();
            }
            // Foi Alterado número do registro de 50 para 40
            for ($iCont = 0; $iCont < pg_num_rows($rsDIPR50); $iCont++) {
                $aDIPR50 = pg_fetch_array($rsDIPR50, $iCont);

                $aCSVDIPR50['si234_tiporegistro']           = $this->padLeftZero($aDIPR50['si234_tiporegistro'], 2);
                $aCSVDIPR50['si234_codorgao']               = $this->padLeftZero($aDIPR50['si234_codorgao'], 2);
                $aCSVDIPR50['si234_mescompetencia']         = $this->padLeftZero($aDIPR50['si234_mescompetencia'], 2);
                $aCSVDIPR50['si234_exerciciocompetencia']   = $aDIPR50['si234_exerciciocompetencia'];
                $aCSVDIPR50['si234_tipofundo']              = $aDIPR50['si234_tipofundo'];
                $aCSVDIPR50['si234_tipoaportetransf']       = $aDIPR50['si234_tipoaportetransf'];
                $aCSVDIPR50['si234_datarepasse']            = $this->sicomDate($aDIPR50['si234_datarepasse']);
                $aCSVDIPR50['si234_dscoutrosaportestransf'] = $aDIPR50['si234_dscoutrosaportestransf'];
                $aCSVDIPR50['si234_valoraportetransf']      = $this->sicomNumberReal($aDIPR50['si234_valoraportetransf'], 2);

                $this->sLinha = $aCSVDIPR50;
                $this->adicionaLinha();
            }

            $this->fechaArquivo();
        }
    }
}
