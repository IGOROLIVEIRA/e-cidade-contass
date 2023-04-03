<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarAOP extends GerarAM
{

    /**
     *
     * Mes de referência
     * @var Integer
     */
    public $iMes;

    public function gerarDados()
    {
        $this->sArquivo = "AOP";
        $this->abreArquivo();

        $sSql = "select * from aop102023 where si137_mes = " . $this->iMes . " and si137_instit = " . db_getsession("DB_instit");
        $rsAOP10 = db_query($sSql);

        $sSql2 = "SELECT DISTINCT si138_sequencial,
                     si138_tiporegistro,
                     si138_codreduzido,
                     si138_tipopagamento,
                     e60_codemp AS si138_nroempenho,
                     si138_dtempenho,
                     si138_nroliquidacao,
                     si138_dtliquidacao,
                     si138_codfontrecursos,
                     si138_codco,
                     si138_valoranulacaofonte,
                     si138_mes,
                     si138_reg10,
                     si138_instit
              FROM aop112023
              INNER JOIN empempenho ON e60_codemp::int8 = si138_nroempenho AND e60_emiss = si138_dtempenho
              WHERE si138_mes = " . $this->iMes . "
                AND si138_instit = " . db_getsession("DB_instit");
        $rsAOP11 = db_query($sSql2);

        $sSql3 = "SELECT *
        FROM aop122023
        WHERE si139_mes = " . $this->iMes . "
        AND si139_instit = " . db_getsession("DB_instit");
        $rsAOP12 = db_query($sSql3);

        if (pg_num_rows($rsAOP10) == 0) {

            $aCSV['tiporegistro'] = '99';
            $this->sLinha = $aCSV;
            $this->adicionaLinha();
        } else {

            /**
             *
             * Registros 10, 11
             */
            for ($iCont = 0; $iCont < pg_num_rows($rsAOP10); $iCont++) {

                $aAOP10 = pg_fetch_array($rsAOP10, $iCont);

                $aCSVAOP10['si137_tiporegistro']          = $this->padLeftZero($aAOP10['si137_tiporegistro'], 2);
                $aCSVAOP10['si137_codorgao']              = $this->padLeftZero($aAOP10['si137_codorgao'], 2);
                $aCSVAOP10['si137_codunidadesub']         = $this->padLeftZero($aAOP10['si137_codunidadesub'], 5);
                $aCSVAOP10['si137_nroop']                 = substr($aAOP10['si137_nroop'], 0, 22);
                $aCSVAOP10['si137_dtpagamento']           = $this->sicomDate($aAOP10['si137_dtpagamento']);
                $aCSVAOP10['si137_nroanulacaoop']         = substr($aAOP10['si137_nroanulacaoop'], 0, 22);
                $aCSVAOP10['si137_dtanulacaoop']          = $this->sicomDate($aAOP10['si137_dtanulacaoop']);
                $aCSVAOP10['si137_justificativaanulacao'] = substr($aAOP10['si137_justificativaanulacao'], 0, 500);
                $aCSVAOP10['si137_vlanulacaoop']          = $this->sicomNumberReal($aAOP10['si137_vlanulacaoop'], 2);

                $this->sLinha = $aCSVAOP10;
                $this->adicionaLinha();

                for ($iCont2 = 0; $iCont2 < pg_num_rows($rsAOP11); $iCont2++) {

                    $aAOP11 = pg_fetch_array($rsAOP11, $iCont2);

                    if ($aAOP10['si137_sequencial'] == $aAOP11['si138_reg10']) {

                        $aCSVAOP11['si138_tiporegistro']        = $this->padLeftZero($aAOP11['si138_tiporegistro'], 2);
                        $aCSVAOP11['si138_codreduzido']         = substr($aAOP11['si138_codreduzido'], 0, 15);
                        $aCSVAOP11['si138_codorgao']            = $this->padLeftZero($aAOP10['si137_codorgao'], 2);
                        $aCSVAOP11['si138_codunidadesub']       = $this->padLeftZero($aAOP10['si137_codunidadesub'], 5);
                        $aCSVAOP11['si138_nroop']               = substr($aAOP10['si137_nroop'], 0, 22);
                        $aCSVAOP11['si138_dtpagamento']         = $this->sicomDate($aAOP10['si137_dtpagamento']);
                        $aCSVAOP11['si138_nroanulacaoop']       = substr($aAOP10['si137_nroanulacaoop'], 0, 22);
                        $aCSVAOP11['si138_dtanulacaoop']        = $this->sicomDate($aAOP10['si137_dtanulacaoop']);
                        $aCSVAOP11['si138_tipopagamento']       = $this->padLeftZero($aAOP11['si138_tipopagamento'], 1);
                        $aCSVAOP11['si138_nroempenho']          = substr($aAOP11['si138_nroempenho'], 0, 22);
                        $aCSVAOP11['si138_dtempenho']           = $this->sicomDate($aAOP11['si138_dtempenho']);
                        $aCSVAOP11['si138_nroliquidacao']       = substr($aAOP11['si138_nroliquidacao'], 0, 22) == 0 ? "" : substr($aAOP11['si138_nroliquidacao'], 0, 22);
                        $aCSVAOP11['si138_dtliquidacao']        = $this->sicomDate($aAOP11['si138_dtliquidacao']);
                        $aCSVAOP11['si138_codfontrecursos']     = $this->padLeftZero($aAOP11['si138_codfontrecursos'], 3);
                        $aCSVAOP11['si138_codco']               = $this->padLeftZero($aAOP11['si138_codco'], 4);
                        $aCSVAOP11['si138_valoranulacaofonte']  = $this->sicomNumberReal($aAOP11['si138_valoranulacaofonte'], 2);

                        $this->sLinha = $aCSVAOP11;
                        $this->adicionaLinha();
                    }
                }

                for ($iCont3 = 0; $iCont3 < pg_num_rows($rsAOP12); $iCont3++) {

                    $aAOP12 = pg_fetch_array($rsAOP12, $iCont3);

                    if ($aAOP10['si137_sequencial'] == $aAOP12['si139_reg10']) {
                        $aCSVAOP12['si139_tiporegistro']        = $this->padLeftZero($aAOP12['si139_tiporegistro'], 2);
                        $aCSVAOP12['si139_codreduzidoop']       = substr($aAOP12['si139_codreduzido'], 0, 15);
                        $aCSVAOP12['si139_tipodocumentoop']     = $this->padLeftZero(substr($aAOP12['si139_tipodocumento'], 0, 2), 2);
                        $aCSVAOP12['si139_nrodocumento']        = $aAOP12['si139_nrodocumento'] == '' ? " " : substr($aAOP12['si139_nrodocumento'], 0, 15);
                        $aCSVAOP12['si139_codctb']              = substr($aAOP12['si139_codctb'], 0, 20) == 0 ? " " : substr($aAOP12['si139_codctb'], 0, 20);
                        $aCSVAOP12['si139_codfontectb']         = substr($this->padLeftZero($aAOP12['si139_codfontectb'], 3) == 0 ? " " : $this->padLeftZero($aAOP12['si139_codfontectb'], 3), 0, 7);
                        $aCSVAOP12['si139_desctipodocumentoop'] = substr($aAOP12['si139_desctipodocumentoop'], 0, 50);
                        $aCSVAOP12['si139_dtemissao']           = $this->sicomDate($aAOP12['si139_dtemissao']);
                        $aCSVAOP12['si139_vldocumento']         = $this->sicomNumberReal($aAOP12['si139_vldocumento'], 2);

                        $this->sLinha = $aCSVAOP12;
                        $this->adicionaLinha();
                    }
                }
            }

            $this->fechaArquivo();
        }
    }
}
