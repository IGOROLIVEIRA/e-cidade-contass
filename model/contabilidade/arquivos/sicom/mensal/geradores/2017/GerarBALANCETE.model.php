<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author Gabriel
 * @package Contabilidade
 */
class GerarBALANCETE extends GerarAM
{

    /**
     *
     * Mes de referência
     * @var Integer
     */
    public $iMes;

    public function gerarDados()
    {

        $this->sArquivo = "BALANCETE";
        $this->abreArquivo();

        $sSql = "select * from balancete102017 where si177_mes = " . $this->iMes . " and si177_instit =" . db_getsession("DB_instit");
        $rsBALANCETE10 = db_query($sSql);
        $sSql1 = "select * from balancete112017 where si178_mes = " . $this->iMes . " and si178_instit =" . db_getsession("DB_instit");
        $rsBALANCETE11 = db_query($sSql1);
        $sSql2 = "select * from balancete122017 where si179_mes = " . $this->iMes . " and si179_instit =" . db_getsession("DB_instit");
        $rsBALANCETE12 = db_query($sSql2);
        $sSql3 = "select * from balancete132017 where si180_mes = " . $this->iMes . " and si180_instit =" . db_getsession("DB_instit");
        $rsBALANCETE13 = db_query($sSql3);
        $sSql4 = "select * from balancete142017 where si181_mes = " . $this->iMes . " and si181_instit =" . db_getsession("DB_instit");
        $rsBALANCETE14 = db_query($sSql4);
        $sSql5 = "select * from balancete152017 where si182_mes = " . $this->iMes . " and si182_instit =" . db_getsession("DB_instit");
        $rsBALANCETE15 = db_query($sSql5);
        $sSql6 = "select * from balancete162017 where si183_mes = " . $this->iMes . " and si183_instit =" . db_getsession("DB_instit");
        $rsBALANCETE16 = db_query($sSql6);
        $sSql7 = "select * from balancete172017 where si184_mes = " . $this->iMes . " and si184_instit =" . db_getsession("DB_instit");
        $rsBALANCETE17 = db_query($sSql7);
        $sSql8 = "select * from balancete182017 where si185_mes = " . $this->iMes . " and si185_instit =" . db_getsession("DB_instit");
        $rsBALANCETE18 = db_query($sSql8);
        $sSql9 = "select * from balancete192017 where si186_mes = " . $this->iMes . " and si186_instit =" . db_getsession("DB_instit");
        $rsBALANCETE19 = db_query($sSql9);
        $sSql20 = "select * from balancete202017 where si187_mes = " . $this->iMes . " and si187_instit =" . db_getsession("DB_instit");
        $rsBALANCETE20 = db_query($sSql20);
        $sSql21 = "select * from balancete212017 where si188_mes = " . $this->iMes . " and si188_instit =" . db_getsession("DB_instit");
        $rsBALANCETE21 = db_query($sSql21);
        $sSql22 = "select * from balancete222017 where si189_mes = " . $this->iMes . " and si189_instit =" . db_getsession("DB_instit");
        $rsBALANCETE22 = db_query($sSql22);
        $sSql23 = "select * from balancete232017 where si190_mes = " . $this->iMes . " and si190_instit =" . db_getsession("DB_instit");
        $rsBALANCETE23 = db_query($sSql23);
        $sSql24 = "select * from balancete242017 where si191_mes = " . $this->iMes . " and si191_instit =" . db_getsession("DB_instit");
        $rsBALANCETE24 = db_query($sSql24);

        if (pg_num_rows($rsBALANCETE10) == 0) {

            $aCSV['tiporegistro'] = '99';
            $this->sLinha = $aCSV;
            $this->adicionaLinha();

        } else {

            /**
             *
             * Registros
             */
            for ($iCont = 0; $iCont < pg_num_rows($rsBALANCETE10); $iCont++) {

                $aBALACETE10 = pg_fetch_array($rsBALANCETE10, $iCont);

                $aCSVBALANCETE10['si177_tiporegistro']          = $this->padLeftZero($aBALACETE10['si177_tiporegistro'], 2);
                $aCSVBALANCETE10['si177_contacontaabil']        = $this->padLeftZero($aBALACETE10['si177_contacontaabil'], 9);
                $aCSVBALANCETE10['si177_codfundo']              = "00000000";
                $aCSVBALANCETE10['si177_saldoinicial']          = $this->sicomNumberReal($aBALACETE10['si177_saldoinicial'], 2);
                $aCSVBALANCETE10['si177_naturezasaldoinicial']  = $this->padLeftZero($aBALACETE10['si177_naturezasaldoinicial'], 1);
                $aCSVBALANCETE10['si177_totaldebitos']          = $this->sicomNumberReal($aBALACETE10['si177_totaldebitos'], 2);
                $aCSVBALANCETE10['si177_totalcreditos']         = $this->sicomNumberReal($aBALACETE10['si177_totalcreditos'], 2);
                $aCSVBALANCETE10['si177_saldofinal']            = $this->sicomNumberReal($aBALACETE10['si177_saldofinal'], 2);
                $aCSVBALANCETE10['si177_naturezasaldofinal']    = $this->padLeftZero($aBALACETE10['si177_naturezasaldofinal'], 1);

                $this->sLinha = $aCSVBALANCETE10;
                $this->adicionaLinha();


                for ($iCont11 = 0; $iCont11 < pg_num_rows($rsBALANCETE11); $iCont11++) {

                    $aBALACETE11 = pg_fetch_array($rsBALANCETE11, $iCont11);

                    if ($aBALACETE11['si178_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE11['si178_tiporegistro']            = $this->padLeftZero($aBALACETE11['si178_tiporegistro'], 2);
                        $aCSVBALANCETE11['si178_contacontaabil']          = $this->padLeftZero($aBALACETE11['si178_contacontaabil'], 9);
                        $aCSVBALANCETE11['si178_codfundo']                = "00000000";
                        $aCSVBALANCETE11['si178_codorgao']                = $this->padLeftZero($aBALACETE11['si178_codorgao'], 2);
                        $aCSVBALANCETE11['si178_codunidadesub']           = $this->padLeftZero($aBALACETE11['si178_codunidadesub'], 5);
                        $aCSVBALANCETE11['si178_codfuncao']               = $this->padLeftZero($aBALACETE11['si178_codfuncao'], 2);
                        $aCSVBALANCETE11['si178_codsubfuncao']            = $this->padLeftZero($aBALACETE11['si178_codsubfuncao'], 3);
                        $aCSVBALANCETE11['si178_codprograma']             = $this->padLeftZero($aBALACETE11['si178_codprograma'], 4);
                        $aCSVBALANCETE11['si178_idacao']                  = $this->padLeftZero($aBALACETE11['si178_idacao'], 4);
                        $aCSVBALANCETE11['si178_idsubacao']               = ($aBALACETE11['si178_idsubacao'] == 0 ? ' ' : $this->padLeftZero($aBALACETE11['si178_idsubacao'], 4));
                        $aCSVBALANCETE11['si178_naturezadespesa']         = $this->padLeftZero($aBALACETE11['si178_naturezadespesa'], 6);
                        $aCSVBALANCETE11['si178_subelemento']             = $this->padLeftZero($aBALACETE11['si178_subelemento'], 2);
                        $aCSVBALANCETE11['si178_codfontrecursos']         = $this->padLeftZero($aBALACETE11['si178_codfontrecursos'], 3);
                        $aCSVBALANCETE11['si178_saldoinicialcd']          = $this->sicomNumberReal($aBALACETE11['si178_saldoinicialcd'], 2);
                        $aCSVBALANCETE11['si178_naturezasaldoinicialcd']  = $this->padLeftZero($aBALACETE11['si178_naturezasaldoinicialcd'], 1);
                        $aCSVBALANCETE11['si178_totaldebitoscd']          = $this->sicomNumberReal($aBALACETE11['si178_totaldebitoscd'], 2);
                        $aCSVBALANCETE11['si178_totalcreditoscd']         = $this->sicomNumberReal($aBALACETE11['si178_totalcreditoscd'], 2);
                        $aCSVBALANCETE11['si178_saldofinalcd']            = $this->sicomNumberReal($aBALACETE11['si178_saldofinalcd'], 2);
                        $aCSVBALANCETE11['si178_naturezasaldofinalcd']    = $this->padLeftZero($aBALACETE11['si178_naturezasaldofinalcd'], 1);

                        $this->sLinha = $aCSVBALANCETE11;
                        $this->adicionaLinha();
                    }
                }

                for ($iCont12 = 0; $iCont12 < pg_num_rows($rsBALANCETE12); $iCont12++) {

                    $aBALACETE12 = pg_fetch_array($rsBALANCETE12, $iCont12);

                    if ($aBALACETE12['si179_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE12['si179_tiporegistro']            = $this->padLeftZero($aBALACETE12['si179_tiporegistro'], 2);
                        $aCSVBALANCETE12['si179_contacontabil']           = $this->padLeftZero($aBALACETE12['si179_contacontabil'], 9);
                        $aCSVBALANCETE12['si179_codfundo']                = "00000000";
                        $aCSVBALANCETE12['si179_naturezareceita']         = $this->padLeftZero($aBALACETE12['si179_naturezareceita'], 6);
                        $aCSVBALANCETE12['si179_codfontrecursos']         = $this->padLeftZero($aBALACETE12['si179_codfontrecursos'], 3);
                        $aCSVBALANCETE12['si179_saldoinicialcr']          = $this->sicomNumberReal($aBALACETE12['si179_saldoinicialcr'], 2);
                        $aCSVBALANCETE12['si179_naturezasaldoinicialcr']  = $this->padLeftZero($aBALACETE12['si179_naturezasaldoinicialcr'], 1);
                        $aCSVBALANCETE12['si179_totaldebitoscr']          = $this->sicomNumberReal($aBALACETE12['si179_totaldebitoscr'], 2);
                        $aCSVBALANCETE12['si179_totalcreditoscr']         = $this->sicomNumberReal($aBALACETE12['si179_totalcreditoscr'], 2);
                        $aCSVBALANCETE12['si179_saldofinalcr']            = $this->sicomNumberReal($aBALACETE12['si179_saldofinalcr'], 2);
                        $aCSVBALANCETE12['si179_naturezasaldofinalcr']    = $this->padLeftZero($aBALACETE12['si179_naturezasaldofinalcr'], 1);

                        $this->sLinha = $aCSVBALANCETE12;
                        $this->adicionaLinha();
                    }
                }

                for ($iCont13 = 0; $iCont13 < pg_num_rows($rsBALANCETE13); $iCont13++) {

                    $aBALACETE13 = pg_fetch_array($rsBALANCETE13, $iCont13);

                    if ($aBALACETE13['si180_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE13['si180_tiporegistro']            = $this->padLeftZero($aBALACETE13['si180_tiporegistro'], 2);
                        $aCSVBALANCETE13['si180_contacontabil']           = $this->padLeftZero($aBALACETE13['si180_contacontabil'], 9);
                        $aCSVBALANCETE13['si180_codfundo']                = "00000000";
                        $aCSVBALANCETE13['si180_codprograma']             = $this->padLeftZero($aBALACETE13['si180_codprograma'], 4);
                        $aCSVBALANCETE13['si180_idacao']                  = $this->padLeftZero($aBALACETE13['si180_idacao'], 3);
                        $aCSVBALANCETE13['si180_idsubacao']               = $aBALACETE13['si180_idsubacao'] == 0 ? ' ' : $this->padLeftZero($aBALACETE13['si180_idacao'], 4);
                        $aCSVBALANCETE13['si180_saldoinicialpa']          = $this->sicomNumberReal($aBALACETE13['si180_saldoiniciaipa'], 2);
                        $aCSVBALANCETE13['si180_naturezasaldoinicialpa']  = $this->padLeftZero($aBALACETE13['si180_naturezasaldoiniciaipa'], 1);
                        $aCSVBALANCETE13['si180_totaldebitospa']          = $this->sicomNumberReal($aBALACETE13['si180_totaldebitospa'], 2);
                        $aCSVBALANCETE13['si180_totalcreditospa']         = $this->sicomNumberReal($aBALACETE13['si180_totalcreditospa'], 2);
                        $aCSVBALANCETE13['si180_saldofinalpa']            = $this->sicomNumberReal($aBALACETE13['si180_saldofinaipa'], 2);
                        $aCSVBALANCETE13['si180_naturezasaldofinalpa']    = $this->padLeftZero($aBALACETE13['si180_naturezasaldofinaipa'], 1);

                        $this->sLinha = $aCSVBALANCETE13;
                        $this->adicionaLinha();
                    }
                }

                for ($iCont14 = 0; $iCont14 < pg_num_rows($rsBALANCETE14); $iCont14++) {

                    $aBALACETE14 = pg_fetch_array($rsBALANCETE14, $iCont14);

                    if ($aBALACETE14['si181_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE14['si181_tiporegistro']            = $this->padLeftZero($aBALACETE14['si181_tiporegistro'], 2);
                        $aCSVBALANCETE14['si181_contacontabil']           = $this->padLeftZero($aBALACETE14['si181_contacontabil'], 9);
                        $aCSVBALANCETE14['si181_codfundo']                = "00000000";
                        $aCSVBALANCETE14['si181_codorgao']                = $this->padLeftZero($aBALACETE14['si181_codorgao'], 2);
                        $aCSVBALANCETE14['si181_codunidadesub']           = $this->padLeftZero($aBALACETE14['si181_codunidadesub'], (strlen($aBALACETE14['si181_codunidadesub']) <= 5 ? 5 : 8) );
                        $aCSVBALANCETE14['si181_codunidadesuborig']       = $this->padLeftZero($aBALACETE14['si181_codunidadesuborig'], (strlen($aBALACETE14['si181_codunidadesuborig']) <= 5 ? 5 : 8));
                        $aCSVBALANCETE14['si181_codfuncao']               = $this->padLeftZero($aBALACETE14['si181_codfuncao'], 2);
                        $aCSVBALANCETE14['si181_codsubfuncao']            = $this->padLeftZero($aBALACETE14['si181_codsubfuncao'], 3);
                        $aCSVBALANCETE14['si181_codprograma']             = $this->padLeftZero($aBALACETE14['si181_codprograma'], 4);
                        $aCSVBALANCETE14['si181_idacao']                  = $this->padLeftZero($aBALACETE14['si181_idacao'], 4);
                        $aCSVBALANCETE14['si181_idsubacao']               = ($aBALACETE14['si181_idsubacao'] == 0 ? ' ' : $this->padLeftZero($aBALACETE14['si181_idsubacao'], 4));
                        $aCSVBALANCETE14['si181_naturezadespesa']         = $this->padLeftZero($aBALACETE14['si181_naturezadespesa'], 6);
                        $aCSVBALANCETE14['si181_subelemento']             = $this->padLeftZero($aBALACETE14['si181_subelemento'], 2);
                        $aCSVBALANCETE14['si181_codfontrecursos']         = $this->padLeftZero($aBALACETE14['si181_codfontrecursos'], 3);
                        $aCSVBALANCETE14['si181_nroempenho']              = $aBALACETE14['si181_nroempenho'];
                        $aCSVBALANCETE14['si181_anoinscricao']            = $aBALACETE14['si181_anoinscricao'];
                        $aCSVBALANCETE14['si181_saldoinicialrsp']         = $this->sicomNumberReal($aBALACETE14['si181_saldoinicialrsp'], 2);
                        $aCSVBALANCETE14['si181_naturezasaldoinicialrsp'] = $this->padLeftZero($aBALACETE14['si181_naturezasaldoinicialrsp'], 1);
                        $aCSVBALANCETE14['si181_totaldebitosrsp']         = $this->sicomNumberReal($aBALACETE14['si181_totaldebitosrsp'], 2);
                        $aCSVBALANCETE14['si181_totalcreditosrsp']        = $this->sicomNumberReal($aBALACETE14['si181_totalcreditosrsp'], 2);
                        $aCSVBALANCETE14['si181_saldofinalrsp']           = $this->sicomNumberReal($aBALACETE14['si181_saldofinalrsp'], 2);
                        $aCSVBALANCETE14['si181_naturezasaldofinalrsp']   = $this->padLeftZero($aBALACETE14['si181_naturezasaldofinalrsp'], 1);

                        $this->sLinha = $aCSVBALANCETE14;
                        $this->adicionaLinha();
                    }
                }

                for ($iCont15 = 0; $iCont15 < pg_num_rows($rsBALANCETE15); $iCont15++) {

                    $aBALACETE15 = pg_fetch_array($rsBALANCETE15, $iCont15);

                    if ($aBALACETE15['si182_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE15['si182_tiporegistro']            = $this->padLeftZero($aBALACETE15['si182_tiporegistro'], 2);
                        $aCSVBALANCETE15['si182_contacontabil']           = $this->padLeftZero($aBALACETE15['si182_contacontabil'], 9);
                        $aCSVBALANCETE15['si182_codfundo']                = "00000000";
                        $aCSVBALANCETE15['si182_atributosf']              = trim($aBALACETE15['si182_atributosf']);
                        $aCSVBALANCETE15['si182_saldoinicialsf']          = $this->sicomNumberReal($aBALACETE15['si182_saldoinicialsf'], 2);
                        $aCSVBALANCETE15['si182_naturezasaldoinicialsf']  = $this->padLeftZero($aBALACETE15['si182_naturezasaldoinicialsf'], 1);
                        $aCSVBALANCETE15['si182_totaldebitossf']          = $this->sicomNumberReal($aBALACETE15['si182_totaldebitossf'], 2);
                        $aCSVBALANCETE15['si182_totalcreditossf']         = $this->sicomNumberReal($aBALACETE15['si182_totalcreditossf'], 2);
                        $aCSVBALANCETE15['si182_saldofinalsf']            = $this->sicomNumberReal($aBALACETE15['si182_saldofinalsf'], 2);
                        $aCSVBALANCETE15['si182_naturezasaldofinalsf']    = $this->padLeftZero($aBALACETE15['si182_naturezasaldofinalsf'], 1);

                        $this->sLinha = $aCSVBALANCETE15;
                        $this->adicionaLinha();
                    }
                }

                for ($iCont16 = 0; $iCont16 < pg_num_rows($rsBALANCETE16); $iCont16++) {

                    $aBALACETE16 = pg_fetch_array($rsBALANCETE16, $iCont16);

                    if ($aBALACETE16['si183_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE16['si183_tiporegistro']                = $this->padLeftZero($aBALACETE16['si183_tiporegistro'], 2);
                        $aCSVBALANCETE16['si183_contacontabil']               = $this->padLeftZero($aBALACETE16['si183_contacontabil'], 9);
                        $aCSVBALANCETE16['si183_codfundo']                    = "00000000";
                        $aCSVBALANCETE16['si183_atributosf']                  = trim($aBALACETE16['si183_atributosf']);
                        $aCSVBALANCETE16['si183_codfontrecursos']             = $this->padLeftZero($aBALACETE16['si183_codfontrecursos'], 3);
                        $aCSVBALANCETE16['si183_saldoinicialfontsf']          = $this->sicomNumberReal($aBALACETE16['si183_saldoinicialfontsf'], 2);
                        $aCSVBALANCETE16['si183_naturezasaldoinicialfontsf']  = $this->padLeftZero($aBALACETE16['si183_naturezasaldoinicialfontsf'], 1);
                        $aCSVBALANCETE16['si183_totaldebitosfontsf']          = $this->sicomNumberReal($aBALACETE16['si183_totaldebitosfontsf'], 2);
                        $aCSVBALANCETE16['si183_totalcreditosfontsf']         = $this->sicomNumberReal($aBALACETE16['si183_totalcreditosfontsf'], 2);
                        $aCSVBALANCETE16['si183_saldofinalfontsf']            = $this->sicomNumberReal($aBALACETE16['si183_saldofinalfontsf'], 2);
                        $aCSVBALANCETE16['si183_naturezasaldofinalfontsf']    = $this->padLeftZero($aBALACETE16['si183_naturezasaldofinalfontsf'], 1);

                        $this->sLinha = $aCSVBALANCETE16;
                        $this->adicionaLinha();
                    }
                }

                for ($iCont17 = 0; $iCont17 < pg_num_rows($rsBALANCETE17); $iCont17++) {

                    $aBALACETE17 = pg_fetch_array($rsBALANCETE17, $iCont17);

                    if ($aBALACETE17['si184_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE17['si184_tiporegistro']            = $this->padLeftZero($aBALACETE17['si184_tiporegistro'], 2);
                        $aCSVBALANCETE17['si184_contacontabil']           = $this->padLeftZero($aBALACETE17['si184_contacontabil'], 9);
                        $aCSVBALANCETE17['si184_codfundo']                = "00000000";
                        $aCSVBALANCETE17['si184_atributosf']              = trim($aBALACETE17['si184_atributosf']);
                        $aCSVBALANCETE17['si184_codctb']                  = trim($aBALACETE17['si184_codctb']);
                        $aCSVBALANCETE17['si184_codfontrecursos']         = $this->padLeftZero($aBALACETE17['si184_codfontrecursos'], 3);
                        $aCSVBALANCETE17['si184_saldoinicialctb']         = $this->sicomNumberReal($aBALACETE17['si184_saldoinicialctb'], 2);
                        $aCSVBALANCETE17['si184_naturezasaldoinicialctb'] = $this->padLeftZero($aBALACETE17['si184_naturezasaldoinicialctb'], 1);
                        $aCSVBALANCETE17['si184_totaldebitosctb']         = $this->sicomNumberReal($aBALACETE17['si184_totaldebitosctb'], 2);
                        $aCSVBALANCETE17['si184_totalcreditosctb']        = $this->sicomNumberReal($aBALACETE17['si184_totalcreditosctb'], 2);
                        $aCSVBALANCETE17['si184_saldofinalctb']           = $this->sicomNumberReal($aBALACETE17['si184_saldofinalctb'], 2);
                        $aCSVBALANCETE17['si184_naturezasaldofinalctb']   = $this->padLeftZero($aBALACETE17['si184_naturezasaldofinalctb'], 1);

                        $this->sLinha = $aCSVBALANCETE17;
                        $this->adicionaLinha();
                    }
                }

                for ($iCont18 = 0; $iCont18 < pg_num_rows($rsBALANCETE18); $iCont18++) {

                    $aBALACETE18 = pg_fetch_array($rsBALANCETE18, $iCont18);

                    if ($aBALACETE18['si185_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE18['si185_tiporegistro']            = $this->padLeftZero($aBALACETE18['si185_tiporegistro'], 2);
                        $aCSVBALANCETE18['si185_contacontabil']           = $this->padLeftZero($aBALACETE18['si185_contacontabil'], 9);
                        $aCSVBALANCETE18['si185_codfundo']                = "00000000";
                        $aCSVBALANCETE18['si185_codfontrecursos']         = $this->padLeftZero($aBALACETE18['si185_codfontrecursos'], 3);
                        $aCSVBALANCETE18['si185_saldoinicialfr']          = $this->sicomNumberReal($aBALACETE18['si185_saldoinicialfr'], 2);
                        $aCSVBALANCETE18['si185_naturezasaldoinicialfr']  = $this->padLeftZero($aBALACETE18['si185_naturezasaldoinicialfr'], 1);
                        $aCSVBALANCETE18['si185_totaldebitosfr']          = $this->sicomNumberReal($aBALACETE18['si185_totaldebitosfr'], 2);
                        $aCSVBALANCETE18['si185_totalcreditosfr']         = $this->sicomNumberReal($aBALACETE18['si185_totalcreditosfr'], 2);
                        $aCSVBALANCETE18['si185_saldofinalfr']            = $this->sicomNumberReal($aBALACETE18['si185_saldofinalfr'], 2);
                        $aCSVBALANCETE18['si185_naturezasaldofinalfr']    = $this->padLeftZero($aBALACETE18['si185_naturezasaldofinalfr'], 1);

                        $this->sLinha = $aCSVBALANCETE18;
                        $this->adicionaLinha();
                    }
                }
                
                for ($iCont23 = 0; $iCont23 < pg_num_rows($rsBALANCETE23); $iCont23++) {

                    $aBALACETE23 = pg_fetch_array($rsBALANCETE23, $iCont23);

                    if ($aBALACETE23['si190_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE23['si190_tiporegistro']                    = $this->padLeftZero($aBALACETE23['si190_tiporegistro'], 2);
                        $aCSVBALANCETE23['si190_contacontabil']                   = $this->padLeftZero($aBALACETE23['si190_contacontabil'], 9);
                        $aCSVBALANCETE23['si190_codfundo']                        = "00000000";
                        $aCSVBALANCETE23['si190_naturezareceita']                 = $this->padLeftZero($aBALACETE23['si190_naturezareceita'], 6);
                        $aCSVBALANCETE23['si190_saldoinicialnatreceita']          = $this->sicomNumberReal($aBALACETE23['si190_saldoinicialnatreceita'], 2);
                        $aCSVBALANCETE23['si190_naturezasaldoinicialnatreceita']  = $this->padLeftZero($aBALACETE23['si190_naturezasaldoinicialnatreceita'], 1);
                        $aCSVBALANCETE23['si190_totaldebitosnatreceita']          = $this->sicomNumberReal($aBALACETE23['si190_totaldebitosnatreceita'], 2);
                        $aCSVBALANCETE23['si190_totalcreditosnatreceita']         = $this->sicomNumberReal($aBALACETE23['si190_totalcreditosnatreceita'], 2);
                        $aCSVBALANCETE23['si190_saldofinalnatreceita']            = $this->sicomNumberReal($aBALACETE23['si190_saldofinalnatreceita'], 2);
                        $aCSVBALANCETE23['si190_naturezasaldofinalnatreceita']    = $this->padLeftZero($aBALACETE23['si190_naturezasaldofinalnatreceita'], 1);

                        $this->sLinha = $aCSVBALANCETE23;
                        $this->adicionaLinha();
                    }
                }
                
                for ($iCont24 = 0; $iCont24 < pg_num_rows($rsBALANCETE24); $iCont24++) {

                    $aBALACETE24 = pg_fetch_array($rsBALANCETE24, $iCont24);

                    if ($aBALACETE24['si191_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE24['si191_tiporegistro']              = $this->padLeftZero($aBALACETE24['si191_tiporegistro'], 2);
                        $aCSVBALANCETE24['si191_contacontabil']             = $this->padLeftZero($aBALACETE24['si191_contacontabil'], 9);
                        $aCSVBALANCETE24['si191_codfundo']                  = "00000000";
                        $aCSVBALANCETE24['si191_codorgao']                  = $this->padLeftZero($aBALACETE24['si191_codorgao'], 2);
                        $aCSVBALANCETE24['si191_codunidadesub']             = $this->padLeftZero($aBALACETE24['si191_codunidadesub'], (strlen($aBALACETE24['si191_codorgao']) <= 5 ? 5 : 8));
                        $aCSVBALANCETE24['si191_saldoinicialorgao']         = $this->sicomNumberReal($aBALACETE24['si191_saldoinicialorgao'], 2);
                        $aCSVBALANCETE24['si191_naturezasaldoinicialorgao'] = $this->padLeftZero($aBALACETE24['si191_naturezasaldoinicialorgao'], 1);
                        $aCSVBALANCETE24['si191_totaldebitosorgao']         = $this->sicomNumberReal($aBALACETE24['si191_totaldebitosorgao'], 2);
                        $aCSVBALANCETE24['si191_totalcreditosorgao']        = $this->sicomNumberReal($aBALACETE24['si191_totalcreditosorgao'], 2);
                        $aCSVBALANCETE24['si191_saldofinalorgao']           = $this->sicomNumberReal($aBALACETE24['si191_saldofinalorgao'], 2);
                        $aCSVBALANCETE24['si191_naturezasaldofinalorgao']   = $this->padLeftZero($aBALACETE24['si191_naturezasaldofinalorgao'], 1);

                        $this->sLinha = $aCSVBALANCETE24;
                        $this->adicionaLinha();
                    }
                }
            }


            $this->fechaArquivo();

        }

    }

}
