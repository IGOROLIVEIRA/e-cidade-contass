<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");


/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarEXT extends GerarAM
{

    /**
     *
     * Mes de referência
     * @var Integer
     */
    public $iMes;

    public function gerarDados()
    {

        $this->sArquivo = "EXT";
        $this->abreArquivo();

        $sSql = "select * from ext102016 where si124_mes = " . $this->iMes . " and  si124_instit = " . db_getsession("DB_instit");
        $rsEXT10 = db_query($sSql);

        $sSql = "select * from ext202016 where si165_mes = " . $this->iMes . " and  si165_instit = " . db_getsession("DB_instit");
        $rsEXT20 = db_query($sSql);

        $sSql3 = "select * from EXT302016 where si126_mes = " . $this->iMes . " and  si126_instit = " . db_getsession("DB_instit");
        $rsEXT30 = db_query($sSql3);

        $sSql4 = "select * from EXT312016 where si127_mes = " . $this->iMes . " and  si127_instit = " . db_getsession("DB_instit");
        $rsEXT31 = db_query($sSql4);

        $sSql5 = "select * from EXT322016 where si128_mes = " . $this->iMes . " and  si128_instit = " . db_getsession("DB_instit");
        $rsEXT32 = db_query($sSql5);


        if (pg_num_rows($rsEXT10) == 0 && pg_num_rows($rsEXT20) == 0) {

            $aCSV['tiporegistro'] = '99';
            $this->sLinha = $aCSV;
            $this->adicionaLinha();

        } else {

            /**
             *
             * Registros 10
             */
            for ($iCont = 0; $iCont < pg_num_rows($rsEXT10); $iCont++) {

                $aEXT10 = pg_fetch_array($rsEXT10, $iCont);

                $aCSVEXT10['si124_tiporegistro'] = str_pad($aEXT10['si124_tiporegistro'], 2, "0", STR_PAD_LEFT);
                $aCSVEXT10['si124_codext'] = substr($aEXT10['si124_codext'], 0, 15);
                $aCSVEXT10['si124_codorgao'] = str_pad($aEXT10['si124_codorgao'], 2, "0", STR_PAD_LEFT);
                $aCSVEXT10['si124_tipolancamento'] = str_pad($aEXT10['si124_tipolancamento'], 2, "0", STR_PAD_LEFT);
                $aCSVEXT10['si124_subtipo'] = str_pad($aEXT10['si124_subtipo'], 4, "0", STR_PAD_LEFT);
                $aCSVEXT10['si124_desdobrasubtipo'] = $aEXT10['si124_desdobrasubtipo'] == 0 ? ' ' : str_pad($aEXT10['si124_desdobrasubtipo'], 4, "0", STR_PAD_LEFT);
                $aCSVEXT10['si124_descextraorc'] = substr($aEXT10['si124_descextraorc'], 0, 50);

                $this->sLinha = $aCSVEXT10;
                $this->adicionaLinha();

            }

            /**
             *
             * Registros 20, 21, 22, 23, 24
             */
            for ($iCont = 0; $iCont < pg_num_rows($rsEXT20); $iCont++) {


                $aEXT20 = pg_fetch_array($rsEXT20, $iCont);

                $aCSVEXT20['si165_tiporegistro'] = str_pad($aEXT20['si165_tiporegistro'], 2, "0", STR_PAD_LEFT);
                $aCSVEXT20['si165_codorgao'] = str_pad($aEXT20['si165_codorgao'], 2, "0", STR_PAD_LEFT);
                $aCSVEXT20['si165_codext'] = substr($aEXT20['si165_codext'], 0, 15);
                $aCSVEXT20['si165_codfontrecursos'] = str_pad($aEXT20['si165_codfontrecursos'], 3, "0", STR_PAD_LEFT);
                $aCSVEXT20['si165_vlsaldoanteriorfonte'] = number_format(abs($aEXT20['si165_vlsaldoanteriorfonte']), 2, ",", "");
                $aCSVEXT20['si165_natsaldoanteriorfonte'] = $aEXT20['si165_natsaldoanteriorfonte'];
                $aCSVEXT20['si165_totaldebitos'] = number_format(abs($aEXT20['si165_totaldebitos']), 2, ",", "");
                $aCSVEXT20['si165_totalcreditos'] = number_format(abs($aEXT20['si165_totalcreditos']), 2, ",", "");
                $aCSVEXT20['si165_vlsaldoatualfonte'] = number_format(abs($aEXT20['si165_vlsaldoatualfonte']), 2, ",", "");
                $aCSVEXT20['si165_natsaldoatualfonte'] = $aEXT20['si165_natsaldoatualfonte'];


                $this->sLinha = $aCSVEXT20;
                $this->adicionaLinha();


            }

            for ($iCont3 = 0; $iCont3 < pg_num_rows($rsEXT30); $iCont3++) {
                $aEXT30 = pg_fetch_array($rsEXT30, $iCont3);


                $aCSVEXT30['si126_tiporegistro'] = str_pad($aEXT30['si126_tiporegistro'], 2, "0", STR_PAD_LEFT);
                $aCSVEXT30['si126_codext'] = substr($aEXT30['si126_codext'], 0, 15);
                $aCSVEXT30['si126_codfontrecursos'] = str_pad($aEXT30['si126_codfontrecursos'], 3, "0", STR_PAD_LEFT);
                $aCSVEXT30['si126_codreduzidoop'] = substr($aEXT30['si126_codreduzidoop'], 0, 15);
                $aCSVEXT30['si126_nroop'] = substr($aEXT30['si126_nroop'], 0, 22);
                $aCSVEXT30['si126_codunidadesub'] = str_pad($aEXT30['si126_codunidadesub'], (strlen($aEXT30['si126_codunidadesub']) <= 5 ? 5 : 8 ), "0", STR_PAD_LEFT);
                $aCSVEXT30['si126_dtpagamento'] = implode("", array_reverse(explode("-", $aEXT30['si126_dtpagamento'])));
                $aCSVEXT30['si126_tipodocumentocredor'] = str_pad($aEXT30['si126_tipodocumentocredor'], 1, "0", STR_PAD_LEFT);
                $aCSVEXT30['si126_nrodocumentocredor'] = substr($aEXT30['si126_nrodocumentocredor'], 0, 14);
                $aCSVEXT30['si126_vlop'] = number_format(abs($aEXT30['si126_vlop']), 2, ",", "");
                $aCSVEXT30['si126_especificacaoop'] = substr($aEXT30['si126_especificacaoop'], 0, 200);
                $aCSVEXT30['si126_cpfresppgto'] = substr($aEXT30['si126_cpfresppgto'], 0, 11);


                $this->sLinha = $aCSVEXT30;
                $this->adicionaLinha();


                for ($iCont4 = 0; $iCont4 < pg_num_rows($rsEXT31); $iCont4++) {

                    $aEXT31 = pg_fetch_array($rsEXT31, $iCont4);

                    if ($aEXT30['si126_sequencial'] == $aEXT31['si127_reg30']) {

                        $aCSVEXT31['si127_tiporegistro'] = str_pad($aEXT31['si127_tiporegistro'], 2, "0", STR_PAD_LEFT);
                        $aCSVEXT31['si127_codreduzidoop'] = substr($aEXT31['si127_codreduzidoop'], 0, 15);
                        $aCSVEXT31['si127_tipodocumentoop'] = str_pad($aEXT31['si127_tipodocumentoop'], 2, "0", STR_PAD_LEFT);
                        $aCSVEXT31['si127_nrodocumento'] = substr($aEXT31['si127_nrodocumento'], 0, 15);
                        $aCSVEXT31['si127_codctb'] = substr($aEXT31['si127_codctb'], 0, 20);
                        $aCSVEXT31['si127_codfontectb'] = str_pad($aEXT31['si127_codfontectb'], 3, "0", STR_PAD_LEFT);
                        $aCSVEXT31['si127_desctipodocumentoop'] = substr($aEXT31['si127_desctipodocumentoop'], 0, 50);
                        $aCSVEXT31['si127_dtemissao'] = implode("", array_reverse(explode("-", $aEXT31['si127_dtemissao'])));
                        $aCSVEXT31['si127_vldocumento'] = number_format($aEXT31['si127_vldocumento'], 2, ",", "");

                        $this->sLinha = $aCSVEXT31;
                        $this->adicionaLinha();

                    }

                }

                for ($iCont5 = 0; $iCont5 < pg_num_rows($rsEXT32); $iCont5++) {

                    $aEXT32 = pg_fetch_array($rsEXT32, $iCont5);

                    if ($aEXT31['si128_sequencial'] == $aEXT32['si128_reg30']) {

                        $aCSVEXT32['si128_tiporegistro'] = str_pad($aEXT32['si128_tiporegistro'], 2, "0", STR_PAD_LEFT);
                        $aCSVEXT32['si128_codreduzidoop'] = substr($aEXT32['si128_codreduzidoop'], 0, 15);
                        $aCSVEXT32['si128_tiporetencao'] = str_pad($aEXT32['si128_tiporetencao'], 4, "0", STR_PAD_LEFT);
                        $aCSVEXT32['si128_descricaoretencao'] = substr($aEXT32['si128_descricaoretencao'], 0, 50);
                        $aCSVEXT32['si128_vlretencao'] = number_format($aEXT32['si128_vlretencao'], 2, ",", "");

                        $this->sLinha = $aCSVEXT32;
                        $this->adicionaLinha();

                    }

                }

            }

        }

        $this->fechaArquivo();
    }
}
