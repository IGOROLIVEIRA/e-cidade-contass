<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Editais
 * @author Victor Felipe
 * @package Contabilidade
 */
class GerarREDISPI extends GerarAM
{

    /**
     *
     * Mes de referência
     * @var Integer
     */
    public $iMes;

    public function gerarDados()
    {

        $this->sArquivo = "REDISPI";
        $this->abreArquivo();

        $sSql = "select * from redispi102020 where si183_mes = " . $this->iMes . " and si183_instit=" . db_getsession("DB_instit");
        $rsREDISPI10 = db_query($sSql);


        $sSql2 = "select * from redispi112020 where si184_mes = " . $this->iMes . " and si184_instit=" . db_getsession("DB_instit");;
        $rsREDISPI11 = db_query($sSql2);

        $sSql3 = "select * from redispi122020 where si185_mes = " . $this->iMes . " and si185_instit=" . db_getsession("DB_instit");;
        $rsREDISPI12 = db_query($sSql3);


        if (pg_num_rows($rsREDISPI10) == 0) {

            $aCSV['tiporegistro'] = '99';
            $this->sLinha = $aCSV;
            $this->adicionaLinha();

        } else {

            /**
             *
             * Registros 10, 11, 12
             */
            for ($iCont = 0; $iCont < pg_num_rows($rsREDISPI10); $iCont++) {

                $aREDISPI10 = pg_fetch_array($rsREDISPI10, $iCont);

                $aCSVREDISPI10['si183_tiporegistro']                          = $this->padLeftZero($aREDISPI10['si183_tiporegistro'], 2);
                $aCSVREDISPI10['si183_codorgaoresp']                          = $this->padLeftZero($aREDISPI10['si183_codorgaoresp'], 2);
                $aCSVREDISPI10['si183_codunidadesubresp']                     = $this->padLeftZero($aREDISPI10['si183_codunidadesubresp'], 5);
                $aCSVREDISPI10['si183_codunidadesubrespestadual']             = !intval($aREDISPI10['si183_codunidadesubrespestadual']) ? '' : $this->padLeftZero($aREDISPI10['si183_codunidadesubrespestadual'], 5);
                $aCSVREDISPI10['si183_exercicioprocesso']                     = $this->padLeftZero($aREDISPI10['si183_exercicioprocesso'], 4);
                $aCSVREDISPI10['si183_nroprocesso']                           = $aREDISPI10['si183_nroprocesso'];
                $aCSVREDISPI10['si183_tipoprocesso']                          = substr($aREDISPI10['si183_tipoprocesso'], 0, 12);
                $aCSVREDISPI10['si183_tipocadastradodispensainexigibilidade'] = substr($aREDISPI10['si183_tipocadastradodispensainexigibilidade'], 0, 12);
                $aCSVREDISPI10['si183_dsccadastrolicitatorio']                = substr($aREDISPI10['si183_dsccadastrolicitatorio'], 0, 12);
                $aCSVREDISPI10['si183_dsccadastrolicitatorio']                = substr($aREDISPI10['si183_dsccadastrolicitatorio'], 0, 12);
                $aCSVREDISPI10['si183_dtabertura']                            = $this->sicomDate($aREDISPI10['si183_dtabertura']);
                $aCSVREDISPI10['si183_naturezaobjeto']                        = $aREDISPI10['si183_naturezaobjeto'] == 0 ? ' ' : substr($aREDISPI10['si183_naturezaobjeto'], 0, 1);
                $aCSVREDISPI10['si183_objeto']                                = substr($aREDISPI10['si183_objeto'], 0, 500);
                $aCSVREDISPI10['si183_justificativa']                         = substr($aREDISPI10['si183_justificativa'], 0, 250);
                $aCSVREDISPI10['si183_razao']                                 = substr($aREDISPI10['si183_razao'], 0, 250);
                $aCSVREDISPI10['si183_vlrecurso']                             = $this->sicomNumberReal($aREDISPI10['si183_vlrecurso'], 2);
                $aCSVREDISPI10['si183_bdi']                                   = $this->sicomNumberReal($aREDISPI10['si183_bdi'], 2);

                $this->sLinha = $aCSVREDISPI10;
                $this->adicionaLinha();

                for ($iCont2 = 0; $iCont2 < pg_num_rows($rsREDISPI11); $iCont2++) {

                    $aREDISPI11 = pg_fetch_array($rsREDISPI11, $iCont2);

                    if ($aREDISPI10['si183_sequencial'] == $aREDISPI11['si184_reg10']) {

                        $aCSVREDISPI11['si184_tiporegistro']                    = $this->padLeftZero($aREDISPI11['si184_tiporegistro'], 2);
                        $aCSVREDISPI11['si184_codorgaoresp']                    = $this->padLeftZero($aREDISPI11['si184_codorgaoresp'], 2);
                        $aCSVREDISPI11['si184_codunidadesubresp']               = $this->padLeftZero($aREDISPI11['si184_codunidadesubresp'], 5);
                        $aCSVREDISPI11['si184_codunidadesubrespestadual']       = !$aREDISPI11['si184_codunidadesubrespestadual'] ? '' : $this->padLeftZero($aREDISPI11['si184_codunidadesubrespestadual'], 5);
                        $aCSVREDISPI11['si184_exercicioprocesso']               = $this->padLeftZero($aREDISPI11['si184_exercicioprocesso'], 4);
                        $aCSVREDISPI11['si184_nroprocesso']          			= $aREDISPI11['si184_nroprocesso'];
                        $aCSVREDISPI11['si184_codobralocal']                    = substr($aREDISPI11['si184_codobralocal'], 0, 12);
                        $aCSVREDISPI11['si184_tipoprocesso']                    = substr($aREDISPI11['si184_tipoprocesso'], 0, 12);
                        $aCSVREDISPI11['si184_classeobjeto']                    = substr($aREDISPI11['si184_classeobjeto'], 0, 12);
                        $aCSVREDISPI11['si184_tipoatividadeobra']               = $aREDISPI11['si184_tipoatividadeobra'] == 0 ? '' : substr($aREDISPI11['si184_tipoatividadeobra'], 0, 12);
                        $aCSVREDISPI11['si184_tipoatividadeservico']            = !$aREDISPI11['si184_tipoatividadeservico'] ? '' : $aREDISPI11['si184_tipoatividadeservico'];
                        $aCSVREDISPI11['si184_dscatividadeservico']             = substr($aREDISPI11['si184_dscatividadeservico'], 0, 12);
                        $aCSVREDISPI11['si184_tipoatividadeservespecializado']  = !$aREDISPI11['si184_tipoatividadeservespecializado'] ? '' : $this->padLeftZero($aREDISPI11['si184_tipoatividadeservespecializado'], 2);
                        $aCSVREDISPI11['si184_dscatividadeservespecializado']   = substr($aREDISPI11['si184_dscatividadeservespecializado'], 0, 12);
                        $aCSVREDISPI11['si184_codfuncao']                       = $this->padLeftZero(intval($aREDISPI11['si184_codfuncao']), 2);
                        $aCSVREDISPI11['si184_codsubfuncao']                    = $this->padLeftZero(intval($aREDISPI11['si184_codsubfuncao']),3);
                        $aCSVREDISPI11['si184_codbempublico']                   = $this->padLeftZero($aREDISPI11['si184_codbempublico'], 4);

                        $this->sLinha = $aCSVREDISPI11;
                        $this->adicionaLinha();
                    }

                }

                for ($iCont3 = 0; $iCont3 < pg_num_rows($rsREDISPI12); $iCont3++) {

                    $aREDISPI12 = pg_fetch_array($rsREDISPI12, $iCont3);

                    if ($aREDISPI10['si183_sequencial'] == $aREDISPI12['si185_reg10']) {

                        $aCSVREDISPI12['si185_tiporegistro']                = $this->padLeftZero($aREDISPI12['si185_tiporegistro'], 2);
                        $aCSVREDISPI12['si185_codorgaoresp']                = $this->padLeftZero(intval($aREDISPI12['si185_codorgaoresp']), 2);
                        $aCSVREDISPI12['si185_codunidadesubresp']           = $this->padLeftZero($aREDISPI12['si185_codunidadesubresp'], 5);
                        $aCSVREDISPI12['si185_codunidadesubrespestadual']   = !$aREDISPI12['si185_codunidadesubrespestadual'] ? '' : $this->padLeftZero($aREDISPI12['si185_codunidadesubrespestadual'], 5);
                        $aCSVREDISPI12['si185_exercicioprocesso']           = $this->padLeftZero($aREDISPI12['si185_exercicioprocesso'], 4);
                        $aCSVREDISPI12['si185_nroprocesso']                 = trim($aREDISPI12['si185_nroprocesso']);
                        $aCSVREDISPI12['si185_codobralocal']                = $aREDISPI12['si185_codobralocal'];
                        $aCSVREDISPI12['si185_logradouro']                  = $aREDISPI12['si185_logradouro'];
                        $aCSVREDISPI12['si185_numero']                      = $aREDISPI12['si185_numero'];
                        $aCSVREDISPI12['si185_bairro']                      = $aREDISPI12['si185_bairro'];
                        $aCSVREDISPI12['si185_cidade']                      = $aREDISPI12['si185_cidade'];
                        $aCSVREDISPI12['si185_cep']                         = $aREDISPI12['si185_cep'];
                        $aCSVREDISPI12['si185_graulatitude']                = $aREDISPI12['si185_graulatitude'];
                        $aCSVREDISPI12['si185_minutolatitude']              = $aREDISPI12['si185_minutolatitude'];
                        $aCSVREDISPI12['si185_segundolatitude']             = $aREDISPI12['si185_segundolatitude'];
                        $aCSVREDISPI12['si185_graulongitude']               = $aREDISPI12['si185_graulongitude'];
                        $aCSVREDISPI12['si185_minutolongitude']             = $aREDISPI12['si185_minutolongitude'];
                        $aCSVREDISPI12['si185_segundolongitude']            = $aREDISPI12['si185_segundolongitude'];


                        $this->sLinha = $aCSVREDISPI12;
                        $this->adicionaLinha();

                    }

                }

            }

            $this->fechaArquivo();

        }

    }

}
