<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarAOC extends GerarAM
{

    /**
     *
     * Mes de referência
     * @var Integer
     */
    public $iMes;

    public function gerarDados()
    {

        $this->sArquivo = "AOC";
        $this->abreArquivo();

        $sSql = "select * from aoc102021 where si38_mes = " . $this->iMes . " and si38_instit = " . db_getsession("DB_instit");
        $rsAOC10 = db_query($sSql);

        $sSql2 = "select * from aoc112021 where si39_mes = " . $this->iMes . " and si39_instit = " . db_getsession("DB_instit");
        $rsAOC11 = db_query($sSql2);

        $sSql3 = "select * from aoc122021 where si40_mes = " . $this->iMes . " and si40_instit = " . db_getsession("DB_instit");
        $rsAOC12 = db_query($sSql3);

        $sSql4 = "select * from aoc132021 where si41_mes = " . $this->iMes . " and si41_instit = " . db_getsession("DB_instit");
        $rsAOC13 = db_query($sSql4);

        $sSql5 = "select * from aoc142021 where si42_mes = " . $this->iMes . " and si42_instit = " . db_getsession("DB_instit");
        $rsAOC14 = db_query($sSql5);

        $sSql6 = "select * from aoc152021 where si194_mes = " . $this->iMes . " and si194_instit = " . db_getsession("DB_instit");
        $rsAOC15 = db_query($sSql6);

        if (pg_num_rows($rsAOC10) == 0) {

            $aCSV['tiporegistro'] = '99';
            $this->sLinha = $aCSV;
            $this->adicionaLinha();

        } else {

            /**
             *
             * Registros 10, 11, 12
             */
            for ($iCont = 0; $iCont < pg_num_rows($rsAOC10); $iCont++) {

                $aAOC10 = pg_fetch_array($rsAOC10, $iCont);

                $aCSVAOC10['si38_tiporegistro'] = $this->padLeftZero($aAOC10['si38_tiporegistro'], 2);
                $aCSVAOC10['si38_codorgao']     = $this->padLeftZero($aAOC10['si38_codorgao'], 2);
                $aCSVAOC10['si38_nrodecreto']   = substr($aAOC10['si38_nrodecreto'], 0, 8);
                $aCSVAOC10['si38_datadecreto']  = $this->sicomDate($aAOC10['si38_datadecreto']);

                $this->sLinha = $aCSVAOC10;
                $this->adicionaLinha();

                for ($iCont2 = 0; $iCont2 < pg_num_rows($rsAOC11); $iCont2++) {

                    $aAOC11 = pg_fetch_array($rsAOC11, $iCont2);

                    if ($aAOC10['si38_sequencial'] == $aAOC11['si39_reg10']) {

                        $aCSVAOC11['si39_tiporegistro']         = $this->padLeftZero($aAOC11['si39_tiporegistro'], 2);
                        $aCSVAOC11['si39_codreduzidodecreto']   = substr($aAOC11['si39_codreduzidodecreto'], 0, 15);
                        $aCSVAOC11['si39_nrodecreto']           = substr($aAOC11['si39_nrodecreto'], 0, 8);
                        $aCSVAOC11['si39_tipodecretoalteracao'] = $this->padLeftZero($aAOC11['si39_tipodecretoalteracao'], 2);
                        $aCSVAOC11['si39_valoraberto']          = $this->sicomNumberReal($aAOC11['si39_valoraberto'], 2);

                        $this->sLinha = $aCSVAOC11;
                        $this->adicionaLinha();
                    }

                }

                for ($iCont3 = 0; $iCont3 < pg_num_rows($rsAOC12); $iCont3++) {

                    $aAOC12 = pg_fetch_array($rsAOC12, $iCont3);

                    if ($aAOC10['si38_sequencial'] == $aAOC12['si40_reg10']) {

                        $aCSVAOC12['si40_tiporegistro']       = $this->padLeftZero($aAOC12['si40_tiporegistro'], 2);
                        $aCSVAOC12['si40_codreduzidodecreto'] = substr($aAOC12['si40_codreduzidodecreto'], 0, 15);
                        $aCSVAOC12['si40_nroleialteracao']    = substr($aAOC12['si40_nroleialteracao'], 0, 6);
                        $aCSVAOC12['si40_dataleialteracao']   = $this->sicomDate($aAOC12['si40_dataleialteracao']);
                        $aCSVAOC12['si40_tpleiorigdecreto']   = substr($aAOC12['si40_tpleiorigdecreto'], 0, 4);
                        $aCSVAOC12['si40_tipoleialteracao']   = $aAOC12['si40_tipoleialteracao'] == 0 ? ' ' : $aAOC12['si40_tipoleialteracao'];
                        $aCSVAOC12['si40_valorabertolei']     = $aAOC12['si40_valorabertolei'] == '' ? ' ' : $this->sicomNumberReal($aAOC12['si40_valorabertolei'], 2);

                        $this->sLinha = $aCSVAOC12;
                        $this->adicionaLinha();
                    }

                }

                for ($iCont3 = 0; $iCont3 < pg_num_rows($rsAOC13); $iCont3++) {

                    $aAOC13 = pg_fetch_array($rsAOC13, $iCont3);

                    if ($aAOC10['si38_sequencial'] == $aAOC13['si41_reg10']) {

                        $aCSVAOC13['si41_tiporegistro']       = $this->padLeftZero($aAOC13['si41_tiporegistro'], 2);
                        $aCSVAOC13['si41_codreduzidodecreto'] = substr($aAOC13['si41_codreduzidodecreto'], 0, 15);
                        $aCSVAOC13['si41_origemrecalteracao'] = $this->padLeftZero($aAOC13['si41_origemrecalteracao'], 2);
                        $aCSVAOC13['si41_valorabertoorigem']  = $this->sicomNumberReal($aAOC13['si41_valorabertoorigem'], 2);

                        $this->sLinha = $aCSVAOC13;
                        $this->adicionaLinha();
                    }

                }

                for ($iCont4 = 0; $iCont4 < pg_num_rows($rsAOC14); $iCont4++) {

                    $aAOC14 = pg_fetch_array($rsAOC14, $iCont4);

                    if ($aAOC10['si38_sequencial'] == $aAOC14['si42_reg10']) {

                        $aCSVAOC14['si42_tiporegistro']       = $this->padLeftZero($aAOC14['si42_tiporegistro'], 2);
                        $aCSVAOC14['si42_codreduzidodecreto'] = substr($aAOC14['si42_codreduzidodecreto'], 0, 15);
                        $aCSVAOC14['si42_origemrecalteracao'] = $this->padLeftZero($aAOC14['si42_origemrecalteracao'], 2);
                        $aCSVAOC14['si42_codorigem']          = ($aAOC14['si42_codorigem'] == ' ' || $aAOC14['si42_codorigem'] == '0' ? ' ' : substr($aAOC14['si42_codorigem'], 0, 15));
                        $aCSVAOC14['si42_codorgao']           = $this->padLeftZero($aAOC14['si42_codorgao'], 2);
                        $aCSVAOC14['si42_codunidadesub']      = substr($aAOC14['si42_codunidadesub'], 0, strlen($aAOC14['si42_codunidadesub']) > 5 ? 8 : 5);
                        $aCSVAOC14['si42_codfuncao']          = $this->padLeftZero($aAOC14['si42_codfuncao'], 2);
                        $aCSVAOC14['si42_codsubfuncao']       = $this->padLeftZero($aAOC14['si42_codsubfuncao'], 3);
                        $aCSVAOC14['si42_codprograma']        = $this->padLeftZero($aAOC14['si42_codprograma'], 4);
                        $aCSVAOC14['si42_idacao']             = $aAOC14['si42_idacao'] == '' ? ' ' : $this->padLeftZero($aAOC14['si42_idacao'], 4);
                        $aCSVAOC14['si42_idsubacao']          = $aAOC14['si42_idsubacao'] == '' ? ' ' : $this->padLeftZero($aAOC14['si42_idsubacao'], 4);
                        $aCSVAOC14['si42_naturezadespesa']    = $this->padLeftZero($aAOC14['si42_naturezadespesa'], 6);
                        $aCSVAOC14['si42_codfontrecursos']    = $this->padLeftZero($aAOC14['si42_codfontrecursos'], 3);
                        $aCSVAOC14['si42_vlacrescimo']        = $this->sicomNumberReal($aAOC14['si42_vlacrescimo'], 2);

                        $this->sLinha = $aCSVAOC14;
                        $this->adicionaLinha();


                        for ($iCont5 = 0; $iCont5 < pg_num_rows($rsAOC15); $iCont5++) {

                            $aAOC15 = pg_fetch_array($rsAOC15, $iCont5);

                            if (($aAOC10['si38_sequencial'] == $aAOC15['si194_reg10']) && ($aAOC14['si42_codorigem'] == $aAOC15['si194_codorigem'])) {

                                $aCSVAOC15['si194_tiporegistro']       = $this->padLeftZero($aAOC15['si194_tiporegistro'], 2);
                                $aCSVAOC15['si194_codreduzidodecreto'] = substr($aAOC15['si194_codreduzidodecreto'], 0, 15);
                                $aCSVAOC15['si194_origemrecalteracao'] = $this->padLeftZero($aAOC15['si194_origemrecalteracao'], 2);
                                $aCSVAOC15['si194_codorigem']          = substr($aAOC15['si194_codorigem'], 0, 15);
                                $aCSVAOC15['si194_codorgao']           = $this->padLeftZero($aAOC15['si194_codorgao'], 2);
                                $aCSVAOC15['si194_codunidadesub']      = substr($aAOC15['si194_codunidadesub'], 0, strlen($aAOC15['si194_codunidadesub']) > 5 ? 8 : 5);
                                $aCSVAOC15['si194_codfuncao']          = $this->padLeftZero($aAOC15['si194_codfuncao'], 2);
                                $aCSVAOC15['si194_codsubfuncao']       = $this->padLeftZero($aAOC15['si194_codsubfuncao'], 3);
                                $aCSVAOC15['si194_codprograma']        = $this->padLeftZero($aAOC15['si194_codprograma'], 4);
                                $aCSVAOC15['si194_idacao']             = $aAOC15['si194_idacao'] == '' ? ' ' : $this->padLeftZero($aAOC15['si194_idacao'], 4);
                                $aCSVAOC15['si194_idsubacao']          = $aAOC15['si194_idsubacao'] == '' ? ' ' : $this->padLeftZero($aAOC15['si194_idsubacao'], 4);
                                $aCSVAOC15['si194_naturezadespesa']    = $this->padLeftZero($aAOC15['si194_naturezadespesa'], 6);
                                $aCSVAOC15['si194_codfontrecursos']    = $this->padLeftZero($aAOC15['si194_codfontrecursos'], 3);
                                $aCSVAOC15['si194_vlreducao']          = $this->sicomNumberReal($aAOC15['si194_vlreducao'], 2);

                                $this->sLinha = $aCSVAOC15;
                                $this->adicionaLinha();
                            }
                        }
                    }
                }

            }

            $this->fechaArquivo();

        }

    }

}
