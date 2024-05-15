<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarARC extends GerarAM
{

    /**
     *
     * Mes de referência
     * @var Integer
     */
    public $iMes;

    public function gerarDados()
    {

        $this->sArquivo = "ARC";
        $this->abreArquivo();

        $sSql = "select * from arc102020 where si28_mes = " . $this->iMes . " and si28_instit = " . db_getsession("DB_instit");
        $rsARC10 = db_query($sSql);

        $sSql2 = "select * from arc112020 where si29_mes = " . $this->iMes . " and si29_instit = " . db_getsession("DB_instit");
        $rsARC11 = db_query($sSql2);

        $sSql3 = "select * from arc122020 where si30_mes = " . $this->iMes . " and si30_instit = " . db_getsession("DB_instit");
        $rsARC12 = db_query($sSql3);

        $sSql4 = "select * from arc202020 where si31_mes = " . $this->iMes . " and si31_instit = " . db_getsession("DB_instit");
        $rsARC20 = db_query($sSql4);

        $sSql5 = "select * from arc212020 where si32_mes = " . $this->iMes . " and si32_instit = " . db_getsession("DB_instit");
        $rsARC21 = db_query($sSql5);

        if (pg_num_rows($rsARC10) == 0 && pg_num_rows($rsARC20) == 0 ) {

            $aCSV['tiporegistro'] = '99';
            $this->sLinha = $aCSV;
            $this->adicionaLinha();

        } else {

            /**
             *
             * Registros 10, 11, 12
             */
            for ($iCont = 0; $iCont < pg_num_rows($rsARC10); $iCont++) {

                $aARC10 = pg_fetch_array($rsARC10, $iCont);

                $aCSVARC10['si28_tiporegistro']                     = $this->padLeftZero($aARC10['si28_tiporegistro'], 2);
                $aCSVARC10['si28_codcorrecao']                      = substr($aARC10['si28_codcorrecao'], 0, 15);
                $aCSVARC10['si28_codorgao']                         = $this->padLeftZero($aARC10['si28_codorgao'], 2);
                $aCSVARC10['si28_ededucaodereceita']                = $this->padLeftZero($aARC10['si28_ededucaodereceita'], 1);
                $aCSVARC10['si28_identificadordeducaorecreduzida']  = $this->padLeftZero($aARC10['si28_identificadordeducaorecreduzida'], 2);
                $aCSVARC10['si28_naturezareceitareduzida']          = $this->padLeftZero($aARC10['si28_naturezareceitareduzida'], 8);
                $aCSVARC10['si28_especificacaoreduzida']            = substr($aARC10['si28_especificacaoreduzida'], 0, 100);
                $aCSVARC10['si28_identificadordeducaorecacrescida'] = $this->padLeftZero($aARC10['si28_identificadordeducaorecacrescida'], 2);
                $aCSVARC10['si28_naturezareceitaacrescida']         = $this->padLeftZero($aARC10['si28_naturezareceitaacrescida'], 8);
                $aCSVARC10['si28_especificacaoacrescida']           = substr($aARC10['si28_especificacaoacrescida'], 0, 100);
                $aCSVARC10['si28_vlreduzidoacrescido']              = $this->sicomNumberReal($aARC10['si28_vlreduzidoacrescido'], 2);

                $this->sLinha = $aCSVARC10;
                $this->adicionaLinha();

                for ($iCont2 = 0; $iCont2 < pg_num_rows($rsARC11); $iCont2++) {

                    $aARC11 = pg_fetch_array($rsARC11, $iCont2);

                    if ($aARC10['si28_sequencial'] == $aARC11['si29_reg10']) {

                        $aCSVARC11['si29_tiporegistro']     = $this->padLeftZero($aARC11['si29_tiporegistro'], 2);
                        $aCSVARC11['si29_codcorrecao']      = substr($aARC11['si29_codcorrecao'], 0, 15);
                        $aCSVARC11['si29_codfontereduzida'] = $this->padLeftZero($aARC11['si29_codfontereduzida'], 2);
                        $aCSVARC11['si29_vlreduzidofonte']  = $this->sicomNumberReal($aARC11['si29_vlreduzidofonte'], 2);

                        $this->sLinha = $aCSVARC11;
                        $this->adicionaLinha();
                    }

                }

                for ($iCont3 = 0; $iCont3 < pg_num_rows($rsARC12); $iCont3++) {

                    $aARC12 = pg_fetch_array($rsARC12, $iCont3);

                    if ($aARC10['si28_sequencial'] == $aARC12['si30_reg10']) {

                        $aCSVARC12['si30_tiporegistro']       = $this->padLeftZero($aARC12['si30_tiporegistro'], 2);
                        $aCSVARC12['si30_codcorrecao']        = substr($aARC12['si30_codcorrecao'], 0, 15);
                        $aCSVARC12['si30_codfonteacrescida']  = $this->padLeftZero($aARC12['si30_codfonteacrescida'], 3);
                        $aCSVARC11['si30_vlreduzidofonte']    = $this->sicomNumberReal($aARC12['si30_vlacrescidofonte'], 2);

                        $this->sLinha = $aCSVARC12;
                        $this->adicionaLinha();
                    }

                }

            }

            /**
             *
             * Registros 20, 21
             */

            for ($iCont4 = 0; $iCont4 < pg_num_rows($rsARC20); $iCont4++) {

                $aARC20 = pg_fetch_array($rsARC20, $iCont4);

                $aCSVARC20['si31_tiporegistro']             = $this->padLeftZero($aARC20['si31_tiporegistro'], 2);
                $aCSVARC20['si31_codorgao']                  = $this->padLeftZero($aARC20['si31_codorgao'], 2);
                $aCSVARC20['si31_codestorno']               = substr($aARC20['si31_codestorno'], 0, 15);
                $aCSVARC20['si31_ededucaodereceita']        = $this->padLeftZero($aARC20['si31_ededucaodereceita'], 1);
                $aCSVARC20['si31_identificadordeducao']     = $aARC20['si31_identificadordeducao'] == '' || $aARC20['si31_identificadordeducao'] == '0' ? "" : $aARC20['si31_identificadordeducao'];
                $aCSVARC20['si31_naturezareceitaestornada'] = $this->padLeftZero($aARC20['si31_naturezareceitaestornada'], 8);
                $aCSVARC20['si31_vlestornado']              = $this->sicomNumberReal($aARC20['si31_vlestornado'], 2);

                $this->sLinha = $aCSVARC20;
                $this->adicionaLinha();

                for ($iCont5 = 0; $iCont5 < pg_num_rows($rsARC21); $iCont5++) {

                    $aARC21 = pg_fetch_array($rsARC21, $iCont5);

                    if ($aARC20['si31_sequencial'] == $aARC21['si32_reg20']) {

                        $aCSVARC21['si32_tiporegistro']       = $this->padLeftZero($aARC21['si32_tiporegistro'], 2);
                        $aCSVARC21['si32_codestorno']         = substr($aARC21['si32_codestorno'], 0, 15);
                        $aCSVARC21['si32_codfonteestornada']  = $this->padLeftZero($aARC21['si32_codfonteestornada'], 3);
                        $aCSVARC21['si32_tipodocumento']      = $aARC21['si32_tipodocumento'] == "" || $aARC21['si32_tipodocumento'] == '0' ? "" : $aARC21['si32_tipodocumento'];
                        $aCSVARC21['si32_nrodocumento']       = $aARC21['si32_nrodocumento'] == "" || $aARC21['si32_nrodocumento'] == '0' ? "" : $aARC21['si32_nrodocumento'];
                        $aCSVARC21['si32_nroconvenio']        = $aARC21['si32_nroconvenio'];
                        $aCSVARC21['si32_dataassinatura']     = $this->sicomDate($aARC21['si32_dataassinatura']);
                        $aCSVARC21['si32_vlrestornadofonte']  = $this->sicomNumberReal($aARC21['si32_vlestornadofonte'], 2);

                        $this->sLinha = $aCSVARC21;
                        $this->adicionaLinha();
                    }
                }
            }

            $this->fechaArquivo();
        }
    }
}
