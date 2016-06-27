<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author igor
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

        $sSql = "select * from balancete102016 where si177_mes = " . $this->iMes . " and si177_instit =" . db_getsession("DB_instit");
        $rsBALANCETE10 = db_query($sSql);
        $sSql1 = "select * from balancete112016 where si178_mes = " . $this->iMes . " and si178_instit =" . db_getsession("DB_instit");
        $rsBALANCETE11 = db_query($sSql1);
        $sSql2 = "select * from balancete122016 where si179_mes = " . $this->iMes . " and si179_instit =" . db_getsession("DB_instit");
        $rsBALANCETE12 = db_query($sSql2);
        $sSql3 = "select * from balancete132016 where si180_mes = " . $this->iMes . " and si180_instit =" . db_getsession("DB_instit");
        $rsBALANCETE13 = db_query($sSql3);
        $sSql4 = "select * from balancete142016 where si181_mes = " . $this->iMes . " and si181_instit =" . db_getsession("DB_instit");
        $rsBALANCETE14 = db_query($sSql4);
        $sSql5 = "select * from balancete152016 where si182_mes = " . $this->iMes . " and si182_instit =" . db_getsession("DB_instit");
        $rsBALANCETE15 = db_query($sSql5);
        $sSql6 = "select * from balancete162016 where si183_mes = " . $this->iMes . " and si183_instit =" . db_getsession("DB_instit");
        $rsBALANCETE16 = db_query($sSql6);
        $sSql7 = "select * from balancete172016 where si184_mes = " . $this->iMes . " and si184_instit =" . db_getsession("DB_instit");
        $rsBALANCETE17 = db_query($sSql7);
        $sSql8 = "select * from balancete182016 where si185_mes = " . $this->iMes . " and si185_instit =" . db_getsession("DB_instit");
        $rsBALANCETE18 = db_query($sSql8);
        $sSql9 = "select * from balancete192016 where si186_mes = " . $this->iMes . " and si186_instit =" . db_getsession("DB_instit");
        $rsBALANCETE19 = db_query($sSql9);
        $sSql20 = "select * from balancete202016 where si187_mes = " . $this->iMes . " and si187_instit =" . db_getsession("DB_instit");
        $rsBALANCETE20 = db_query($sSql20);
        $sSql21 = "select * from balancete212016 where si188_mes = " . $this->iMes . " and si188_instit =" . db_getsession("DB_instit");
        $rsBALANCETE21 = db_query($sSql21);
        $sSql22 = "select * from balancete222016 where si189_mes = " . $this->iMes . " and si189_instit =" . db_getsession("DB_instit");
        $rsBALANCETE22 = db_query($sSql22);
        $sSql23 = "select * from balancete232016 where si190_mes = " . $this->iMes . " and si190_instit =" . db_getsession("DB_instit");
        $rsBALANCETE23 = db_query($sSql23);
        $sSql24 = "select * from balancete242016 where si191_mes = " . $this->iMes . " and si191_instit =" . db_getsession("DB_instit");
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

                $aCSVBALANCETE10['si177_tiporegistro'] = str_pad($aBALACETE10['si177_tiporegistro'], 2, "0", STR_PAD_LEFT);
                $aCSVBALANCETE10['si177_contacontaabil'] = str_pad($aBALACETE10['si177_contacontaabil'], 9, "0", STR_PAD_LEFT);
                $aCSVBALANCETE10['si177_saldoinicial'] = number_format($aBALACETE10['si177_saldoinicial'], 2, ",", "");
                $aCSVBALANCETE10['si177_naturezasaldoinicial'] = str_pad($aBALACETE10['si177_naturezasaldoinicial'], 1, "0", STR_PAD_LEFT);
                $aCSVBALANCETE10['si177_totaldebitos'] = number_format($aBALACETE10['si177_totaldebitos'], 2, ",", "");
                $aCSVBALANCETE10['si177_totalcreditos'] = number_format($aBALACETE10['si177_totalcreditos'], 2, ",", "");
                $aCSVBALANCETE10['si177_saldofinal'] = number_format($aBALACETE10['si177_saldofinal'], 2, ",", "");
                $aCSVBALANCETE10['si177_naturezasaldofinal'] = str_pad($aBALACETE10['si177_naturezasaldofinal'], 1, "0", STR_PAD_LEFT);

                $this->sLinha = $aCSVBALANCETE10;
                $this->adicionaLinha();


                for ($iCont11 = 0; $iCont11 < pg_num_rows($rsBALANCETE11); $iCont11++) {

                    $aBALACETE11 = pg_fetch_array($rsBALANCETE11, $iCont11);

                    if ($aBALACETE11['si178_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE11['si178_tiporegistro'] = str_pad($aBALACETE11['si178_tiporegistro'], 2, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE11['si178_contacontaabil'] = str_pad($aBALACETE11['si178_contacontaabil'], 9, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE11['si178_codorgao'] = str_pad($aBALACETE11['si178_codorgao'], 2, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE11['si178_codunidadesub'] = str_pad($aBALACETE11['si178_codunidadesub'], 5, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE11['si178_codfuncao'] = str_pad($aBALACETE11['si178_codfuncao'], 2, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE11['si178_codsubfuncao'] = str_pad($aBALACETE11['si178_codsubfuncao'], 3, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE11['si178_codprograma'] = str_pad($aBALACETE11['si178_codprograma'], 4, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE11['si178_idacao'] = str_pad($aBALACETE11['si178_idacao'], 4, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE11['si178_idsubacao'] = ($aBALACETE11['si178_idsubacao'] == 0 ? ' ' : str_pad($aBALACETE11['si178_idsubacao'], 4, "0", STR_PAD_LEFT));
                        $aCSVBALANCETE11['si178_naturezadespesa'] = str_pad($aBALACETE11['si178_naturezadespesa'], 6, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE11['si178_subelemento'] = str_pad($aBALACETE11['si178_subelemento'], 2, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE11['si178_codfontrecursos'] = str_pad($aBALACETE11['si178_codfontrecursos'], 3, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE11['si178_saldoinicialcd'] = number_format($aBALACETE11['si178_saldoinicialcd'], 2, ",", "");
                        $aCSVBALANCETE11['si178_naturezasaldoinicialcd'] = str_pad($aBALACETE11['si178_naturezasaldoinicialcd'], 1, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE11['si178_totaldebitoscd'] = number_format($aBALACETE11['si178_totaldebitoscd'], 2, ",", "");
                        $aCSVBALANCETE11['si178_totalcreditoscd'] = number_format($aBALACETE11['si178_totalcreditoscd'], 2, ",", "");
                        $aCSVBALANCETE11['si178_saldofinalcd'] = number_format($aBALACETE11['si178_saldofinalcd'], 2, ",", "");
                        $aCSVBALANCETE11['si178_naturezasaldofinalcd'] = str_pad($aBALACETE11['si178_naturezasaldofinalcd'], 1, "0", STR_PAD_LEFT);

                        $this->sLinha = $aCSVBALANCETE11;
                        $this->adicionaLinha();
                    }
                }

                for ($iCont12 = 0; $iCont12 < pg_num_rows($rsBALANCETE12); $iCont12++) {

                    $aBALACETE12 = pg_fetch_array($rsBALANCETE12, $iCont12);

                    if ($aBALACETE12['si179_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE12['si179_tiporegistro'] = str_pad($aBALACETE12['si179_tiporegistro'], 2, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE12['si179_contacontabil'] = str_pad($aBALACETE12['si179_contacontabil'], 9, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE12['si179_naturezareceita'] = str_pad($aBALACETE12['si179_naturezareceita'], 6, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE12['si179_codfontrecursos'] = str_pad($aBALACETE12['si179_codfontrecursos'], 3, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE12['si179_saldoinicialcr'] = number_format($aBALACETE12['si179_saldoinicialcr'], 2, ",", "");
                        $aCSVBALANCETE12['si179_naturezasaldoinicialcr'] = str_pad($aBALACETE12['si179_naturezasaldoinicialcr'], 1, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE12['si179_totaldebitoscr'] = number_format($aBALACETE12['si179_totaldebitoscr'], 2, ",", "");
                        $aCSVBALANCETE12['si179_totalcreditoscr'] = number_format($aBALACETE12['si179_totalcreditoscr'], 2, ",", "");
                        $aCSVBALANCETE12['si179_saldofinalcr'] = number_format($aBALACETE12['si179_saldofinalcr'], 2, ",", "");
                        $aCSVBALANCETE12['si179_naturezasaldofinalcr'] = str_pad($aBALACETE12['si179_naturezasaldofinalcr'], 1, "0", STR_PAD_LEFT);

                        $this->sLinha = $aCSVBALANCETE12;
                        $this->adicionaLinha();
                    }
                }

                for ($iCont13 = 0; $iCont13 < pg_num_rows($rsBALANCETE13); $iCont13++) {

                    $aBALACETE13 = pg_fetch_array($rsBALANCETE13, $iCont13);

                    if ($aBALACETE13['si180_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE13['si180_tiporegistro'] = str_pad($aBALACETE13['si180_tiporegistro'], 2, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE13['si180_contacontabil'] = str_pad($aBALACETE13['si180_contacontabil'], 9, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE13['si180_codprograma'] = str_pad($aBALACETE13['si180_codprograma'], 6, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE13['si180_idacao'] = str_pad($aBALACETE13['si180_idacao'], 3, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE13['si180_idsubacao'] = $aBALACETE13['si180_idsubacao'] == 0 ? ' ' : str_pad($aBALACETE13['si180_idacao'], 4, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE13['si180_saldoinicialpa'] = number_format($aBALACETE13['si180_saldoiniciaipa'], 2, ",", "");
                        $aCSVBALANCETE13['si180_naturezasaldoinicialpa'] = str_pad($aBALACETE13['si180_naturezasaldoiniciaipa'], 1, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE13['si180_totaldebitospa'] = number_format($aBALACETE13['si180_totaldebitospa'], 2, ",", "");
                        $aCSVBALANCETE13['si180_totalcreditospa'] = number_format($aBALACETE13['si180_totalcreditospa'], 2, ",", "");
                        $aCSVBALANCETE13['si180_saldofinalpa'] = number_format($aBALACETE13['si180_saldofinaipa'], 2, ",", "");
                        $aCSVBALANCETE13['si180_naturezasaldofinalpa'] = str_pad($aBALACETE13['si180_naturezasaldofinaipa'], 1, "0", STR_PAD_LEFT);

                        $this->sLinha = $aCSVBALANCETE13;
                        $this->adicionaLinha();
                    }
                }

                for ($iCont14 = 0; $iCont14 < pg_num_rows($rsBALANCETE14); $iCont14++) {

                    $aBALACETE14 = pg_fetch_array($rsBALANCETE14, $iCont14);

                    if ($aBALACETE14['si181_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE14['si181_tiporegistro'] = str_pad($aBALACETE14['si181_tiporegistro'], 2, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE14['si181_contacontabil'] = str_pad($aBALACETE14['si181_contacontabil'], 9, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE14['si181_codorgao'] = str_pad($aBALACETE14['si181_codorgao'], 2, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE14['si181_codunidadesub'] = str_pad($aBALACETE14['si181_codunidadesub'], (strlen($aBALACETE14['si181_codunidadesub']) <= 5 ? 5 : 8) , "0", STR_PAD_LEFT);
                        $aCSVBALANCETE14['si181_codunidadesuborig'] = str_pad($aBALACETE14['si181_codunidadesuborig'], (strlen($aBALACETE14['si181_codunidadesuborig']) <= 5 ? 5 : 8), "0", STR_PAD_LEFT);
                        $aCSVBALANCETE14['si181_codfuncao'] = str_pad($aBALACETE14['si181_codfuncao'], 2, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE14['si181_codsubfuncao'] = str_pad($aBALACETE14['si181_codsubfuncao'], 3, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE14['si181_codprograma'] = str_pad($aBALACETE14['si181_codprograma'], 4, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE14['si181_idacao'] = str_pad($aBALACETE14['si181_idacao'], 4, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE14['si181_idsubacao'] = ($aBALACETE14['si181_idsubacao'] == 0 ? ' ' : str_pad($aBALACETE14['si181_idsubacao'], 4, "0", STR_PAD_LEFT));
                        $aCSVBALANCETE14['si181_naturezadespesa'] = str_pad($aBALACETE14['si181_naturezadespesa'], 6, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE14['si181_subelemento'] = str_pad($aBALACETE14['si181_subelemento'], 2, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE14['si181_codfontrecursos'] = str_pad($aBALACETE14['si181_codfontrecursos'], 3, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE14['si181_nroempenho'] = $aBALACETE14['si181_nroempenho'];
                        $aCSVBALANCETE14['si181_anoinscricao'] = $aBALACETE14['si181_anoinscricao'];
                        $aCSVBALANCETE14['si181_saldoinicialrsp'] = number_format($aBALACETE14['si181_saldoinicialrsp'], 2, ",", "");
                        $aCSVBALANCETE14['si181_naturezasaldoinicialrsp'] = str_pad($aBALACETE14['si181_naturezasaldoinicialrsp'], 1, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE14['si181_totaldebitosrsp'] = number_format($aBALACETE14['si181_totaldebitosrsp'], 2, ",", "");
                        $aCSVBALANCETE14['si181_totalcreditosrsp'] = number_format($aBALACETE14['si181_totalcreditosrsp'], 2, ",", "");
                        $aCSVBALANCETE14['si181_saldofinalrsp'] = number_format($aBALACETE14['si181_saldofinalrsp'], 2, ",", "");
                        $aCSVBALANCETE14['si181_naturezasaldofinalrsp'] = str_pad($aBALACETE14['si181_naturezasaldofinalrsp'], 1, "0", STR_PAD_LEFT);

                        $this->sLinha = $aCSVBALANCETE14;
                        $this->adicionaLinha();
                    }
                }

                for ($iCont15 = 0; $iCont15 < pg_num_rows($rsBALANCETE15); $iCont15++) {

                    $aBALACETE15 = pg_fetch_array($rsBALANCETE15, $iCont15);

                    if ($aBALACETE15['si182_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE15['si182_tiporegistro'] = str_pad($aBALACETE15['si182_tiporegistro'], 2, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE15['si182_contacontabil'] = str_pad($aBALACETE15['si182_contacontabil'], 9, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE15['si182_atributosf'] = trim($aBALACETE15['si182_atributosf']);
                        $aCSVBALANCETE15['si182_saldoinicialsf'] = number_format($aBALACETE15['si182_saldoinicialsf'], 2, ",", "");
                        $aCSVBALANCETE15['si182_naturezasaldoinicialsf'] = str_pad($aBALACETE15['si182_naturezasaldoinicialsf'], 1, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE15['si182_totaldebitossf'] = number_format($aBALACETE15['si182_totaldebitossf'], 2, ",", "");
                        $aCSVBALANCETE15['si182_totalcreditossf'] = number_format($aBALACETE15['si182_totalcreditossf'], 2, ",", "");
                        $aCSVBALANCETE15['si182_saldofinalsf'] = number_format($aBALACETE15['si182_saldofinalsf'], 2, ",", "");
                        $aCSVBALANCETE15['si182_naturezasaldofinalsf'] = str_pad($aBALACETE15['si182_naturezasaldofinalsf'], 1, "0", STR_PAD_LEFT);

                        $this->sLinha = $aCSVBALANCETE15;
                        $this->adicionaLinha();
                    }
                }

                for ($iCont16 = 0; $iCont16 < pg_num_rows($rsBALANCETE16); $iCont16++) {

                    $aBALACETE16 = pg_fetch_array($rsBALANCETE16, $iCont16);

                    if ($aBALACETE16['si183_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE16['si183_tiporegistro'] = str_pad($aBALACETE16['si183_tiporegistro'], 2, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE16['si183_contacontabil'] = str_pad($aBALACETE16['si183_contacontabil'], 9, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE16['si183_atributosf'] = trim($aBALACETE16['si183_atributosf']);
                        $aCSVBALANCETE16['si183_codfontrecursos'] = str_pad($aBALACETE16['si183_codfontrecursos'], 3, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE16['si183_saldoinicialfontsf'] = number_format($aBALACETE16['si183_saldoinicialfontsf'], 2, ",", "");
                        $aCSVBALANCETE16['si183_naturezasaldoinicialfontsf'] = str_pad($aBALACETE16['si183_naturezasaldoinicialfontsf'], 1, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE16['si183_totaldebitosfontsf'] = number_format($aBALACETE16['si183_totaldebitosfontsf'], 2, ",", "");
                        $aCSVBALANCETE16['si183_totalcreditosfontsf'] = number_format($aBALACETE16['si183_totalcreditosfontsf'], 2, ",", "");
                        $aCSVBALANCETE16['si183_saldofinalfontsf'] = number_format($aBALACETE16['si183_saldofinalfontsf'], 2, ",", "");
                        $aCSVBALANCETE16['si183_naturezasaldofinalfontsf'] = str_pad($aBALACETE16['si183_naturezasaldofinalfontsf'], 1, "0", STR_PAD_LEFT);

                        $this->sLinha = $aCSVBALANCETE16;
                        $this->adicionaLinha();
                    }
                }

                for ($iCont17 = 0; $iCont17 < pg_num_rows($rsBALANCETE17); $iCont17++) {

                    $aBALACETE17 = pg_fetch_array($rsBALANCETE17, $iCont17);

                    if ($aBALACETE17['si184_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE17['si184_tiporegistro'] = str_pad($aBALACETE17['si184_tiporegistro'], 2, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE17['si184_contacontabil'] = str_pad($aBALACETE17['si184_contacontabil'], 9, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE17['si184_atributosf'] = trim($aBALACETE17['si184_atributosf']);
                        $aCSVBALANCETE17['si184_codctb'] = trim($aBALACETE17['si184_codctb']);
                        $aCSVBALANCETE17['si184_codfontrecursos'] = str_pad($aBALACETE17['si184_codfontrecursos'], 3, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE17['si184_saldoinicialctb'] = number_format($aBALACETE17['si184_saldoinicialctb'], 2, ",", "");
                        $aCSVBALANCETE17['si184_naturezasaldoinicialctb'] = str_pad($aBALACETE17['si184_naturezasaldoinicialctb'], 1, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE17['si184_totaldebitosctb'] = number_format($aBALACETE17['si184_totaldebitosctb'], 2, ",", "");
                        $aCSVBALANCETE17['si184_totalcreditosctb'] = number_format($aBALACETE17['si184_totalcreditosctb'], 2, ",", "");
                        $aCSVBALANCETE17['si184_saldofinalctb'] = number_format($aBALACETE17['si184_saldofinalctb'], 2, ",", "");
                        $aCSVBALANCETE17['si184_naturezasaldofinalctb'] = str_pad($aBALACETE17['si184_naturezasaldofinalctb'], 1, "0", STR_PAD_LEFT);

                        $this->sLinha = $aCSVBALANCETE17;
                        $this->adicionaLinha();
                    }
                }

                for ($iCont18 = 0; $iCont18 < pg_num_rows($rsBALANCETE18); $iCont18++) {

                    $aBALACETE18 = pg_fetch_array($rsBALANCETE18, $iCont18);

                    if ($aBALACETE18['si185_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE18['si185_tiporegistro'] = str_pad($aBALACETE18['si185_tiporegistro'], 2, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE18['si185_contacontabil'] = str_pad($aBALACETE18['si185_contacontabil'], 9, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE18['si185_codfontrecursos'] = str_pad($aBALACETE18['si185_codfontrecursos'], 3, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE18['si185_saldoinicialfr'] = number_format($aBALACETE18['si185_saldoinicialfr'], 2, ",", "");
                        $aCSVBALANCETE18['si185_naturezasaldoinicialfr'] = str_pad($aBALACETE18['si185_naturezasaldoinicialfr'], 1, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE18['si185_totaldebitosfr'] = number_format($aBALACETE18['si185_totaldebitosfr'], 2, ",", "");
                        $aCSVBALANCETE18['si185_totalcreditosfr'] = number_format($aBALACETE18['si185_totalcreditosfr'], 2, ",", "");
                        $aCSVBALANCETE18['si185_saldofinalfr'] = number_format($aBALACETE18['si185_saldofinalfr'], 2, ",", "");
                        $aCSVBALANCETE18['si185_naturezasaldofinalfr'] = str_pad($aBALACETE18['si185_naturezasaldofinalfr'], 1, "0", STR_PAD_LEFT);

                        $this->sLinha = $aCSVBALANCETE18;
                        $this->adicionaLinha();
                    }
                }
                
                for ($iCont23 = 0; $iCont23 < pg_num_rows($rsBALANCETE23); $iCont23++) {

                    $aBALACETE23 = pg_fetch_array($rsBALANCETE23, $iCont23);

                    if ($aBALACETE23['si190_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE23['si190_tiporegistro'] = str_pad($aBALACETE23['si190_tiporegistro'], 2, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE23['si190_contacontabil'] = str_pad($aBALACETE23['si190_contacontabil'], 9, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE23['si190_naturezareceita'] = str_pad($aBALACETE23['si190_naturezareceita'], 6, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE23['si190_saldoinicialnatreceita'] = number_format($aBALACETE23['si190_saldoinicialnatreceita'], 2, ",", "");
                        $aCSVBALANCETE23['si190_naturezasaldoinicialnatreceita'] = str_pad($aBALACETE23['si190_naturezasaldoinicialnatreceita'], 1, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE23['si190_totaldebitosnatreceita'] = number_format($aBALACETE23['si190_totaldebitosnatreceita'], 2, ",", "");
                        $aCSVBALANCETE23['si190_totalcreditosnatreceita'] = number_format($aBALACETE23['si190_totalcreditosnatreceita'], 2, ",", "");
                        $aCSVBALANCETE23['si190_saldofinalnatreceita'] = number_format($aBALACETE23['si190_saldofinalnatreceita'], 2, ",", "");
                        $aCSVBALANCETE23['si190_naturezasaldofinalnatreceita'] = str_pad($aBALACETE23['si190_naturezasaldofinalnatreceita'], 1, "0", STR_PAD_LEFT);

                        $this->sLinha = $aCSVBALANCETE23;
                        $this->adicionaLinha();
                    }
                }
                
                for ($iCont24 = 0; $iCont24 < pg_num_rows($rsBALANCETE24); $iCont24++) {

                    $aBALACETE24 = pg_fetch_array($rsBALANCETE24, $iCont24);

                    if ($aBALACETE24['si191_reg10'] == $aBALACETE10['si177_sequencial']) {

                        $aCSVBALANCETE24['si191_tiporegistro'] = str_pad($aBALACETE24['si191_tiporegistro'], 2, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE24['si191_contacontabil'] = str_pad($aBALACETE24['si191_contacontabil'], 9, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE24['si191_codorgao'] = str_pad($aBALACETE24['si191_codorgao'], 2, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE24['si191_saldoinicialorgao'] = number_format($aBALACETE24['si191_saldoinicialorgao'], 2, ",", "");
                        $aCSVBALANCETE24['si191_naturezasaldoinicialorgao'] = str_pad($aBALACETE24['si191_naturezasaldoinicialorgao'], 1, "0", STR_PAD_LEFT);
                        $aCSVBALANCETE24['si191_totaldebitosorgao'] = number_format($aBALACETE24['si191_totaldebitosorgao'], 2, ",", "");
                        $aCSVBALANCETE24['si191_totalcreditosorgao'] = number_format($aBALACETE24['si191_totalcreditosorgao'], 2, ",", "");
                        $aCSVBALANCETE24['si191_saldofinalorgao'] = number_format($aBALACETE24['si191_saldofinalorgao'], 2, ",", "");
                        $aCSVBALANCETE24['si191_naturezasaldofinalorgao'] = str_pad($aBALACETE24['si191_naturezasaldofinalorgao'], 1, "0", STR_PAD_LEFT);

                        $this->sLinha = $aCSVBALANCETE24;
                        $this->adicionaLinha();
                    }
                }
            }


            $this->fechaArquivo();

        }

    }

}
