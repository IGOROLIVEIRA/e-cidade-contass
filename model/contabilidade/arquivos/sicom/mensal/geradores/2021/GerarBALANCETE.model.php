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

        $sSql = "select * from balancete102021 where si177_mes = " . $this->iMes . " and si177_instit =" . db_getsession("DB_instit");
        $rsBALANCETE10 = db_query($sSql);
        $sSql1 = "select * from balancete112021 where si178_mes = " . $this->iMes . " and si178_instit =" . db_getsession("DB_instit");
        $rsBALANCETE11 = db_query($sSql1);
        $sSql2 = "select * from balancete122021 where si179_mes = " . $this->iMes . " and si179_instit =" . db_getsession("DB_instit");
        $rsBALANCETE12 = db_query($sSql2);
        $sSql3 = "select * from balancete132021 where si180_mes = " . $this->iMes . " and si180_instit =" . db_getsession("DB_instit");
        $rsBALANCETE13 = db_query($sSql3);

        $sSql4 = "SELECT DISTINCT
                  si181_sequencial,
                  si181_tiporegistro,
                  si181_contacontabil,
                  si181_codfundo,
                  si181_codorgao,
                  si181_codunidadesub,
                  si181_codunidadesuborig,
                  si181_codfuncao,
                  si181_codsubfuncao,
                  si181_codprograma,
                  si181_idacao,
                  si181_idsubacao,
                  si181_naturezadespesa,
                  si181_subelemento,
                  si181_codfontrecursos,
                  e60_codemp as si181_nroempenho,
                  si181_anoinscricao,
                  si181_saldoinicialrsp,
                  si181_naturezasaldoinicialrsp,
                  si181_totaldebitosrsp,
                  si181_totalcreditosrsp,
                  si181_saldofinalrsp,
                  si181_naturezasaldofinalrsp,
                  si181_mes,
                  si181_instit,
                  si181_reg10
                  FROM balancete142021
                  JOIN empempenho ON e60_codemp::int8 = si181_nroempenho::int8 AND e60_anousu = si181_anoinscricao
                  WHERE si181_mes = " . $this->iMes . "
                    AND si181_instit =" . db_getsession("DB_instit");
        $rsBALANCETE14 = db_query($sSql4);

        $sSql5 = "select * from balancete152021 where si182_mes = " . $this->iMes . " and si182_instit =" . db_getsession("DB_instit");
        $rsBALANCETE15 = db_query($sSql5);
        $sSql6 = "select * from balancete162021 where si183_mes = " . $this->iMes . " and si183_instit =" . db_getsession("DB_instit");
        $rsBALANCETE16 = db_query($sSql6);
        $sSql7 = "select * from balancete172021 where si184_mes = " . $this->iMes . " and si184_instit =" . db_getsession("DB_instit");
        $rsBALANCETE17 = db_query($sSql7);
        $sSql8 = "select * from balancete182021 where si185_mes = " . $this->iMes . " and si185_instit =" . db_getsession("DB_instit");
        $rsBALANCETE18 = db_query($sSql8);
        $sSql9 = "select * from balancete192021 where si186_mes = " . $this->iMes . " and si186_instit =" . db_getsession("DB_instit");
        $rsBALANCETE19 = db_query($sSql9);
        $sSql20 = "select * from balancete202021 where si187_mes = " . $this->iMes . " and si187_instit =" . db_getsession("DB_instit");
        $rsBALANCETE20 = db_query($sSql20);
        $sSql21 = "select * from balancete212021 where si188_mes = " . $this->iMes . " and si188_instit =" . db_getsession("DB_instit");
        $rsBALANCETE21 = db_query($sSql21);
        $sSql22 = "select * from balancete222021 where si189_mes = " . $this->iMes . " and si189_instit =" . db_getsession("DB_instit");
        $rsBALANCETE22 = db_query($sSql22);
        $sSql23 = "select * from balancete232021 where si190_mes = " . $this->iMes . " and si190_instit =" . db_getsession("DB_instit");
        $rsBALANCETE23 = db_query($sSql23);
        $sSql24 = "select * from balancete242021 where si191_mes = " . $this->iMes . " and si191_instit =" . db_getsession("DB_instit");
        $rsBALANCETE24 = db_query($sSql24);
        $sSql25 = "select * from balancete252021 where si195_mes = " . $this->iMes . " and si195_instit =" . db_getsession("DB_instit");
        $rsBALANCETE25 = db_query($sSql25);
        $sSql26 = "select * from balancete262021 where si196_mes = " . $this->iMes . " and si196_instit =" . db_getsession("DB_instit");
        $rsBALANCETE26 = db_query($sSql26);
        $sSql2 = "select * from balancete272021 where si197_mes = " . $this->iMes . " and si197_instit =" . db_getsession("DB_instit");
        $rsBALANCETE27 = db_query($sSql27);
        $sSql2 = "select * from balancete282021 where si198_mes = " . $this->iMes . " and si197_instit =" . db_getsession("DB_instit");
        $rsBALANCETE28 = db_query($sSql28);

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
                $aCSVBALANCETE10['si177_codfundo']              = $aBALACETE10['si177_codfundo'];
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
                        $aCSVBALANCETE11['si178_codfundo']                = $aBALACETE11['si178_codfundo'];
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
                        $aCSVBALANCETE12['si179_codfundo']                = $aBALACETE12['si179_codfundo'];
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
                        $aCSVBALANCETE13['si180_codfundo']                = $aBALACETE13['si180_codfundo'];
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
                        $aCSVBALANCETE14['si181_codfundo']                = $aBALACETE14['si181_codfundo'];
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
                        $aCSVBALANCETE15['si182_codfundo']                = $aBALACETE15['si182_codfundo'];
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
                        $aCSVBALANCETE16['si183_codfundo']                    = $aBALACETE16['si183_codfundo'];
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
                        $aCSVBALANCETE17['si184_codfundo']                = $aBALACETE17['si184_codfundo'];
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
                        $aCSVBALANCETE18['si185_codfundo']                = $aBALACETE18['si185_codfundo'];
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

                for ($iCont19 = 0; $iCont19 < pg_num_rows($rsBALANCETE19); $iCont19++) {

                    $aBALACETE19 = pg_fetch_array($rsBALANCETE19, $iCont19);

                    if ($aBALACETE19['si186_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE19['si186_tiporegistro']                = $this->padLeftZero($aBALACETE19['si186_tiporegistro'], 2);
                        $aCSVBALANCETE19['si186_contacontabil']               = $this->padLeftZero($aBALACETE19['si186_contacontabil'], 9);
                        $aCSVBALANCETE19['si186_codfundo']                    = $aBALACETE19['si186_codfundo'];
                        $aCSVBALANCETE19['si186_cnpjconsorcio']               = $this->padLeftZero($aBALACETE19['si186_cnpjconsorcio'], 3);
                        $aCSVBALANCETE19['si186_saldoinicialconsor']          = $this->sicomNumberReal($aBALACETE19['si186_saldoinicialconsor'], 2);
                        $aCSVBALANCETE19['si186_naturezasaldoinicialconsor']  = $this->padLeftZero($aBALACETE19['si186_naturezasaldoinicialconsor'], 1);
                        $aCSVBALANCETE19['si186_totaldebitosconsor']          = $this->sicomNumberReal($aBALACETE19['si186_totaldebitosconsor'], 2);
                        $aCSVBALANCETE19['si186_totalcreditosconsor']         = $this->sicomNumberReal($aBALACETE19['si186_totalcreditosconsor'], 2);
                        $aCSVBALANCETE19['si186_saldofinalconsor']            = $this->sicomNumberReal($aBALACETE19['si186_saldofinalconsor'], 2);
                        $aCSVBALANCETE19['si186_naturezasaldofinalconsor']    = $this->padLeftZero($aBALACETE19['si186_naturezasaldofinalconsor'], 1);

                        $this->sLinha = $aCSVBALANCETE19;
                        $this->adicionaLinha();
                    }
                }

                for ($iCont20 = 0; $iCont20 < pg_num_rows($rsBALANCETE20); $iCont20++) {

                    $aBALACETE20 = pg_fetch_array($rsBALANCETE20, $iCont20);

                    if ($aBALACETE20['si187_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE20['si187_tiporegistro']                = $this->padLeftZero($aBALACETE20['si187_tiporegistro'], 2);
                        $aCSVBALANCETE20['si187_contacontabil']               = $this->padLeftZero($aBALACETE20['si187_contacontabil'], 9);
                        $aCSVBALANCETE20['si187_codfundo']                    = $aBALACETE20['si187_codfundo'];
                        $aCSVBALANCETE20['si187_cnpjconsorcio']               = $this->padLeftZero($aBALACETE20['si187_cnpjconsorcio'], 3);
                        $aCSVBALANCETE20['si187_tiporecurso']                 = $this->padLeftZero($aBALACETE20['si187_tiporecurso'], 3);
                        $aCSVBALANCETE20['si187_codfuncao']                   = $this->padLeftZero($aBALACETE20['si187_codfuncao'], 3);
                        $aCSVBALANCETE20['si187_codsubfuncao']                = $this->padLeftZero($aBALACETE20['si187_codsubfuncao'], 3);
                        $aCSVBALANCETE20['si187_codsubfuncao']                = $this->padLeftZero($aBALACETE20['si187_codsubfuncao'], 3);
                        $aCSVBALANCETE20['si187_naturezadespesa']             = $this->padLeftZero($aBALACETE20['si187_naturezadespesa'], 3);
                        $aCSVBALANCETE20['si187_subelemento']                 = $this->padLeftZero($aBALACETE20['si178_subelemento'], 3);
                        $aCSVBALANCETE20['si187_codfontrecursos']             = $this->padLeftZero($aBALACETE20['si187_codfontrecursos'], 3);
                        $aCSVBALANCETE20['si187_saldoinicialcons']            = $this->sicomNumberReal($aBALACETE20['si187_saldoinicialcons'], 2);
                        $aCSVBALANCETE20['si187_naturezasaldoinicialcons']    = $this->padLeftZero($aBALACETE20['si187_naturezasaldoinicialcons'], 1);
                        $aCSVBALANCETE20['si187_totaldebitoscons']            = $this->sicomNumberReal($aBALACETE20['si187_totaldebitoscons'], 2);
                        $aCSVBALANCETE20['si187_totalcreditoscons']           = $this->sicomNumberReal($aBALACETE20['si187_totalcreditoscons'], 2);
                        $aCSVBALANCETE20['si187_saldofinalcons']              = $this->sicomNumberReal($aBALACETE20['si187_saldofinalcons'], 2);
                        $aCSVBALANCETE20['si187_naturezasaldofinalcons']      = $this->padLeftZero($aBALACETE20['si187_naturezasaldofinalcons'], 1);

                        $this->sLinha = $aCSVBALANCETE20;
                        $this->adicionaLinha();
                    }
                }
                for ($iCont21 = 0; $iCont21 < pg_num_rows($rsBALANCETE21); $iCont21++) {

                    $aBALACETE21 = pg_fetch_array($rsBALANCETE21, $iCont21);

                    if ($aBALACETE21['si188_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE21['si188_tiporegistro']                = $this->padLeftZero($aBALACETE21['si188_tiporegistro'], 2);
                        $aCSVBALANCETE21['si188_contacontabil']               = $this->padLeftZero($aBALACETE21['si188_contacontabil'], 9);
                        $aCSVBALANCETE21['si188_codfundo']                    = $aBALACETE21['si188_codfundo'];
                        $aCSVBALANCETE21['si188_cnpjconsorcio']               = $this->padLeftZero($aBALACETE21['si188_cnpjconsorcio'], 3);
                        $aCSVBALANCETE21['si188_codfontrecursos']               = $this->padLeftZero($aBALACETE21['si188_codfontrecursos'], 3);
                        $aCSVBALANCETE21['si188_saldoinicialconsorfr']          = $this->sicomNumberReal($aBALACETE21['si188_saldoinicialconsorfr'], 2);
                        $aCSVBALANCETE21['si188_naturezasaldoinicialconsorfr']  = $this->padLeftZero($aBALACETE21['si188_naturezasaldoinicialconsorfr'], 1);
                        $aCSVBALANCETE21['si188_totaldebitosconsorfr']          = $this->sicomNumberReal($aBALACETE21['si188_totaldebitosconsorfr'], 2);
                        $aCSVBALANCETE21['si188_totalcreditosconsorfr']         = $this->sicomNumberReal($aBALACETE21['si188_totalcreditosconsorfr'], 2);
                        $aCSVBALANCETE21['si188_saldofinalconsorfr']            = $this->sicomNumberReal($aBALACETE21['si188_saldofinalconsorfr'], 2);
                        $aCSVBALANCETE21['si188_naturezasaldofinalconsorfr']    = $this->padLeftZero($aBALACETE21['si188_naturezasaldofinalconsorfr'], 1);

                        $this->sLinha = $aCSVBALANCETE21;
                        $this->adicionaLinha();
                    }
                }

                for ($iCont22 = 0; $iCont22 < pg_num_rows($rsBALANCETE22); $iCont22++) {

                    $aBALACETE22 = pg_fetch_array($rsBALANCETE22, $iCont22);

                    if ($aBALACETE22['si189_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE22['si189_tiporegistro']                  = $this->padLeftZero($aBALACETE22['si189_tiporegistro'], 2);
                        $aCSVBALANCETE22['si189_contacontabil']                 = $this->padLeftZero($aBALACETE22['si189_contacontabil'], 9);
                        $aCSVBALANCETE22['si189_codfundo']                      = $aBALACETE22['si189_codfundo'];
                        $aCSVBALANCETE22['si189_cnpjconsorcio']                 = $this->padLeftZero($aBALACETE22['si189_cnpjconsorcio'], 3);
                        $aCSVBALANCETE22['si189_atributosf']                    = $this->padLeftZero($aBALACETE22['si189_atributosf'], 3);
                        $aCSVBALANCETE22['si189_codctb']                        = $this->padLeftZero($aBALACETE22['si189_codctb'], 3);
                        $aCSVBALANCETE22['si189_codfontrecursos']               = $this->padLeftZero($aBALACETE22['si189_codfontrecursos'], 3);
                        $aCSVBALANCETE22['si189_saldoinicialctbsf']             = $this->sicomNumberReal($aBALACETE22['si189_saldoinicialctbsf'], 2);
                        $aCSVBALANCETE22['si189_naturezasaldoinicialctbsf']     = $this->padLeftZero($aBALACETE22['si189_naturezasaldoinicialctbsf'], 1);
                        $aCSVBALANCETE22['si189_totaldebitosctbsf']             = $this->sicomNumberReal($aBALACETE22['si189_totaldebitosctbsf'], 2);
                        $aCSVBALANCETE22['si189_totalcreditosctbsf']            = $this->sicomNumberReal($aBALACETE22['si189_totalcreditosctbsf'], 2);
                        $aCSVBALANCETE22['si189_saldofinalctbsf']               = $this->sicomNumberReal($aBALACETE22['si189_saldofinalctbsf'], 2);
                        $aCSVBALANCETE22['si189_naturezasaldofinalctbsf']       = $this->padLeftZero($aBALACETE22['si189_naturezasaldofinalctbsf'], 1);

                        $this->sLinha = $aCSVBALANCETE22;
                        $this->adicionaLinha();
                    }
                }

                for ($iCont23 = 0; $iCont23 < pg_num_rows($rsBALANCETE23); $iCont23++) {

                    $aBALACETE23 = pg_fetch_array($rsBALANCETE23, $iCont23);

                    if ($aBALACETE23['si190_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE23['si190_tiporegistro']                    = $this->padLeftZero($aBALACETE23['si190_tiporegistro'], 2);
                        $aCSVBALANCETE23['si190_contacontabil']                   = $this->padLeftZero($aBALACETE23['si190_contacontabil'], 9);
                        $aCSVBALANCETE23['si190_codfundo']                        = $aBALACETE23['si190_codfundo'];
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
                        $aCSVBALANCETE24['si191_codfundo']                  = $aBALACETE24['si191_codfundo'];
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
                for ($iCont25 = 0; $iCont25 < pg_num_rows($rsBALANCETE25); $iCont25++) {

                    $aBALACETE25 = pg_fetch_array($rsBALANCETE25, $iCont25);

                    if ($aBALACETE25['si195_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE25['si195_tiporegistro']              = $this->padLeftZero($aBALACETE25['si195_tiporegistro'], 2);
                        $aCSVBALANCETE25['si195_contacontabil']             = $this->padLeftZero($aBALACETE25['si195_contacontabil'], 9);
                        $aCSVBALANCETE25['si195_codfundo']                  = $aBALACETE25['si195_codfundo'];
                        $aCSVBALANCETE25['si182_atributosf']                = $aBALACETE25['si195_atributosf'];
                        $aCSVBALANCETE25['si195_naturezareceita']           = $this->padLeftZero($aBALACETE25['si195_naturezareceita'], 2);
                        $aCSVBALANCETE25['si195_saldoinicialnrsf']            = $this->sicomNumberReal($aBALACETE25['si195_saldoinicialnrsf'], 2);
                        $aCSVBALANCETE25['si195_naturezasaldoinicialnrsf']    = $aBALACETE25['si195_naturezasaldoinicialnrsf'];
                        $aCSVBALANCETE25['si195_totaldebitosnrsf']            = $this->sicomNumberReal($aBALACETE25['si195_totaldebitosnrsf'], 2);
                        $aCSVBALANCETE25['si195_totalcreditosnrsf']           = $this->sicomNumberReal($aBALACETE25['si195_totalcreditosnrsf'], 2);
                        $aCSVBALANCETE25['si195_saldofinalnrsf']              = $this->sicomNumberReal($aBALACETE25['si195_saldofinalnrsf'], 2);
                        $aCSVBALANCETE25['si195_naturezasaldofinalnrsf']      = $aBALACETE25['si195_naturezasaldofinalnrsf'];

                        $this->sLinha = $aCSVBALANCETE25;
                        $this->adicionaLinha();
                    }
                }

                for ($iCont26 = 0; $iCont26 < pg_num_rows($rsBALANCETE26); $iCont26++) {

                    $aBALACETE26 = pg_fetch_array($rsBALANCETE26, $iCont26);

                    if ($aBALACETE26['si196_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE26['si196_tiporegistro']            = $this->padLeftZero($aBALACETE26['si196_tiporegistro'], 2);
                        $aCSVBALANCETE26['si196_contacontabil']           = $this->padLeftZero($aBALACETE26['si196_contacontabil'], 9);
                        $aCSVBALANCETE26['si196_codfundo']                = $aBALACETE26['si196_codfundo'];
                        $aCSVBALANCETE26['si196_tipodocumentopessoaatributosf'] = $aBALACETE26['si196_tipodocumentopessoaatributosf'];
                        $aCSVBALANCETE26['si196_nrodocumentopessoaatributosf'] = $aBALACETE26['si196_nrodocumentopessoaatributosf'];
                        $aCSVBALANCETE26['si196_atributosf']              = trim($aBALACETE26['si196_atributosf']);
                        $aCSVBALANCETE26['si196_saldoinicialpessoaatributosf']          = $this->sicomNumberReal($aBALACETE26['si196_saldoinicialpessoaatributosf'], 2);
                        $aCSVBALANCETE26['si196_naturezasaldoinicialpessoaatributosf']  = $this->padLeftZero($aBALACETE26['si196_naturezasaldoinicialpessoaatributosf'], 1);
                        $aCSVBALANCETE26['si196_totaldebitospessoaatributosf']          = $this->sicomNumberReal($aBALACETE26['si196_totaldebitospessoaatributosf'], 2);
                        $aCSVBALANCETE26['si196_totalcreditospessoaatributosf']         = $this->sicomNumberReal($aBALACETE26['si196_totalcreditospessoaatributosf'], 2);
                        $aCSVBALANCETE26['si196_saldofinalpessoaatributosf']            = $this->sicomNumberReal($aBALACETE26['si196_saldofinalpessoaatributosf'], 2);
                        $aCSVBALANCETE26['si196_naturezasaldofinalpessoaatributosf']    = $this->padLeftZero($aBALACETE26['si196_naturezasaldofinalpessoaatributosf'], 1);

                        $this->sLinha = $aCSVBALANCETE26;
                        $this->adicionaLinha();
                    }
                }

                for ($iCont27 = 0; $iCont27 < pg_num_rows($rsBALANCETE27); $iCont27++) {

                    $aBALACETE27 = pg_fetch_array($rsBALANCETE27, $iCont27);

                    if ($aBALACETE27['si197_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE27['si197_tiporegistro']                    = $this->padLeftZero($aBALACETE27['si197_tiporegistro'], 2);
                        $aCSVBALANCETE27['si197_contacontabil']                   = $this->padLeftZero($aBALACETE27['si197_contacontabil'], 9);
                        $aCSVBALANCETE27['si197_codfundo']                        = $aBALACETE27['si197_codfundo'];
                        $aCSVBALANCETE27['si197_codorgao']                        = $aBALACETE27['si197_codorgao'];
                        $aCSVBALANCETE27['si197_codunidadesub']                   = $aBALACETE27['si197_codunidadesub'];
                        $aCSVBALANCETE27['si197_codfontrecursos']                 = $aBALACETE27['si197_codfontrecursos'];
                        $aCSVBALANCETE27['si197_atributosf']                      = trim($aBALACETE27['si197_atributosf']);
                        $aCSVBALANCETE27['si197_saldoinicialoufontesf']           = $this->sicomNumberReal($aBALACETE27['si197_saldoinicialoufontesf'], 2);
                        $aCSVBALANCETE27['si197_naturezasaldoinicialoufontesf']   = $this->padLeftZero($aBALACETE27['si197_naturezasaldoinicialoufontesf'], 1);
                        $aCSVBALANCETE27['si197_totaldebitosoufontesf']           = $this->sicomNumberReal($aBALACETE27['si197_totaldebitosoufontesf'], 2);
                        $aCSVBALANCETE27['si197_totalcreditosoufontesf']          = $this->sicomNumberReal($aBALACETE27['si197_totalcreditosoufontesf'], 2);
                        $aCSVBALANCETE27['si197_saldofinaloufontesf']             = $this->sicomNumberReal($aBALACETE27['si197_saldofinaloufontesf'], 2);
                        $aCSVBALANCETE27['si197_naturezasaldofinaloufontesf']     = $this->padLeftZero($aBALACETE27['si197_naturezasaldofinaloufontesf'], 1);

                        $this->sLinha = $aCSVBALANCETE27;
                        $this->adicionaLinha();
                    }
                }

                for ($iCont28 = 0; $iCont28 < pg_num_rows($rsBALANCETE28); $iCont28++) {

                    $aBALACETE28 = pg_fetch_array($rsBALANCETE28, $iCont28);

                    if ($aBALACETE28['si197_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE28['si198_tiporegistro']                  = $this->padLeftZero($aBALACETE28['si198_tiporegistro'], 2);
                        $aCSVBALANCETE28['si198_contacontabil']                 = $this->padLeftZero($aBALACETE28['si198_contacontabil'], 9);
                        $aCSVBALANCETE28['si198_codfundo']                      = $aBALACETE28['si198_codfundo'];
                        $aCSVBALANCETE28['si198_codctb']                        = $aBALACETE28['si198_codctb'];
                        $aCSVBALANCETE28['si198_codfontrecursos']               = trim($aBALACETE28['si198_codfontrecursos']);
                        $aCSVBALANCETE28['si198_saldoinicialctbfonte']          = $this->sicomNumberReal($aBALACETE28['si198_saldoinicialctbfonte'], 2);
                        $aCSVBALANCETE28['si198_naturezasaldoinicialctbfonte']  = $this->padLeftZero($aBALACETE28['si198_naturezasaldoinicialctbfonte'], 1);
                        $aCSVBALANCETE28['si198_totaldebitosctbfonte']          = $this->sicomNumberReal($aBALACETE28['si198_totaldebitosctbfonte'], 2);
                        $aCSVBALANCETE28['si198_totalcreditosctbfonte']         = $this->sicomNumberReal($aBALACETE28['si198_totalcreditosctbfonte'], 2);
                        $aCSVBALANCETE28['si198_saldofinalctbfonte']            = $this->sicomNumberReal($aBALACETE28['si198_saldofinalctbfonte'], 2);
                        $aCSVBALANCETE28['si198_naturezasaldofinalctbfonte']    = $this->padLeftZero($aBALACETE28['si198_naturezasaldofinalctbfonte'], 1);

                        $this->sLinha = $aCSVBALANCETE28;
                        $this->adicionaLinha();
                    }
                }
            }


            $this->fechaArquivo();

        }

    }

}
