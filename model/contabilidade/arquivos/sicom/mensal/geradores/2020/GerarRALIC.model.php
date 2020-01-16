<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author Victor Felipe
 * @package Contabilidade
 */
class GerarRALIC extends GerarAM
{

    /**
     *
     * Mes de referência
     * @var Integer
     */
    public $iMes;

    public function gerarDados()
    {

        $this->sArquivo = "RALIC";
        $this->abreArquivo();

        $sSql = "select * from ralic102020 where si180_mes = " . $this->iMes . " and si180_instit=" . db_getsession("DB_instit");
        $rsRALIC10 = db_query($sSql);


        $sSql2 = "select * from ralic112020 where si181_mes = " . $this->iMes . " and si181_instit=" . db_getsession("DB_instit");;
        $rsRALIC11 = db_query($sSql2);

        $sSql3 = "select * from ralic122020 where si182_mes = " . $this->iMes . " and si182_instit=" . db_getsession("DB_instit");;
        $rsRALIC12 = db_query($sSql3);

        if (pg_num_rows($rsRALIC10) == 0) {

            $aCSV['tiporegistro'] = '99';
            $this->sLinha = $aCSV;
            $this->adicionaLinha();

        } else {

            /**
             *
             * Registros 10, 11, 12
             */
            for ($iCont = 0; $iCont < pg_num_rows($rsRALIC10); $iCont++) {

                $aRALIC10 = pg_fetch_array($rsRALIC10, $iCont);

                $aCSVRALIC10['si180_tiporegistro']               = $this->padLeftZero($aRALIC10['si180_tiporegistro'], 2);
                $aCSVRALIC10['si180_codorgaoresp']               = $this->padLeftZero($aRALIC10['si180_codorgaoresp'], 2);
                $aCSVRALIC10['si180_codunidadesubresp']          = $this->padLeftZero($aRALIC10['si180_codunidadesubresp'], 5);
                $aCSVRALIC10['si180_codunidadesubrespestadual']  = $this->padLeftZero($aRALIC10['si180_codunidadesubrespestadual'], 5);
                $aCSVRALIC10['si180_exerciciolicitacao']         = $this->padLeftZero($aRALIC10['si180_exerciciolicitacao'], 4);
                $aCSVRALIC10['si180_tipocadastradolicitacao']    = substr($aRALIC10['si180_tipocadastradolicitacao'], 0, 12);
                $aCSVRALIC10['si180_dsccadastrolicitatorio']     = substr($aRALIC10['si180_dsccadastrolicitatorio'], 0, 12);
                $aCSVRALIC10['si180_codmodalidadelicitacao']     = $this->padLeftZero($aRALIC10['si180_codmodalidadelicitacao'], 1);
                $aCSVRALIC10['si180_naturezaprocedimento']       = $this->padLeftZero($aRALIC10['si180_naturezaprocedimento'], 1);
                $aCSVRALIC10['si180_nroedital']                  = $this->padLeftZero($aRALIC10['si180_nroedital'], 1);
                $aCSVRALIC10['si180_exercicioedital']            = $this->padLeftZero($aRALIC10['si180_exercicioedital'], 1);
                $aCSVRALIC10['si180_dtpublicacaoeditaldo']       = $this->sicomDate($aRALIC10['si180_dtpublicacaoeditaldo']);
                $aCSVRALIC10['si180_link']                       = $aRALIC10['si180_link'];
                $aCSVRALIC10['si180_tipolicitacao']              = $aRALIC10['si180_tipolicitacao'] == 0 ? ' ' : substr($aRALIC10['si180_tipolicitacao'], 0, 1);
                $aCSVRALIC10['si180_naturezaobjeto']             = $aRALIC10['si180_naturezaobjeto'] == 0 ? ' ' : substr($aRALIC10['si180_naturezaobjeto'], 0, 1);
                $aCSVRALIC10['si180_objeto']                     = substr($aRALIC10['si180_objeto'], 0, 500);
                $aCSVRALIC10['si180_regimeexecucaoobras']        = $aRALIC10['si180_regimeexecucaoobras'] == 0 ? ' ' : substr($aRALIC10['si180_regimeexecucaoobras'], 0, 1);
                $aCSVRALIC10['si180_vlcontratacao']              = $aRALIC10['si180_vlcontratacao'];
                $aCSVRALIC10['si180_bdi']                        = $aRALIC10['si180_bdi'];
                $aCSVRALIC10['si180_mesexercicioreforc']         = $aRALIC10['si180_mesexercicioreforc'];
                $aCSVRALIC10['si180_origemrecurso']              = $aRALIC10['si180_origemrecurso'];
                $aCSVRALIC10['si180_dscorigemrecurso']           = $aRALIC10['si180_dscorigemrecurso'];

                $this->sLinha = $aCSVRALIC10;
                $this->adicionaLinha();

                for ($iCont2 = 0; $iCont2 < pg_num_rows($rsRALIC11); $iCont2++) {

                    $aRALIC11 = pg_fetch_array($rsRALIC11, $iCont2);

                    if ($aRALIC10['si180_sequencial'] == $aRALIC11['si181_reg10']) {

                        $aCSVRALIC11['si181_tiporegistro']                    = $this->padLeftZero($aRALIC11['si181_tiporegistro'], 2);
                        $aCSVRALIC11['si181_codorgaoresp']                    = $this->padLeftZero($aRALIC11['si181_codorgaoresp'], 2);
                        $aCSVRALIC11['si181_codunidadesubresp']               = $this->padLeftZero($aRALIC11['si181_codunidadesubresp'], 5);
                        $aCSVRALIC11['si181_codunidadesubrespestadual']       = $this->padLeftZero($aRALIC11['si181_codunidadesubrespestadual'], 5);
                        $aCSVRALIC11['si181_exerciciolicitacao']              = $this->padLeftZero($aRALIC11['si181_exerciciolicitacao'], 4);
                        $aCSVRALIC11['si181_nroprocessolicitatorio']          = substr($aRALIC11['si181_nroprocessolicitatorio'], 0, 12);
                        $aCSVRALIC11['si181_codobralocal']                    = substr($aRALIC11['si181_codobralocal'], 0, 12);
                        $aCSVRALIC11['si181_classeobjeto']                    = substr($aRALIC11['si181_classeobjeto'], 0, 12);
                        $aCSVRALIC11['si181_tipoatividadeobra']               = substr($aRALIC11['si181_tipoatividadeobra'], 0, 12);
                        $aCSVRALIC11['si181_tipoatividadeservico']            = substr($aRALIC11['si181_tipoatividadeservico'], 0, 12);
                        $aCSVRALIC11['si181_dscatividadeservico']             = substr($aRALIC11['si181_dscatividadeservico'], 0, 12);
                        $aCSVRALIC11['si181_tipoatividadeservespecializado']  = substr($aRALIC11['si181_tipoatividadeservespecializado'], 0, 12);
                        $aCSVRALIC11['si181_dscatividadeservespecializado']   = substr($aRALIC11['si181_dscatividadeservespecializado'], 0, 12);
                        $aCSVRALIC11['si181_codfuncao']                       = substr($aRALIC11['si181_codfuncao'], 0, 12);
                        $aCSVRALIC11['si181_codsubfuncao']                    = substr($aRALIC11['si181_codsubfuncao'], 0, 12);
                        $aCSVRALIC11['si181_codbempublico']                   = substr($aRALIC11['si181_codbempublico'], 0, 12);
                        $aCSVRALIC11['si181_mes']                             = substr($aRALIC11['si181_mes'], 0, 12);
                        $aCSVRALIC11['si181_instit']                          = substr($aRALIC11['si181_instit'], 0, 12);


                        $this->sLinha = $aCSVRALIC11;
                        $this->adicionaLinha();
                    }

                }

                for ($iCont3 = 0; $iCont3 < pg_num_rows($rsRALIC12); $iCont3++) {

                    $aRALIC12 = pg_fetch_array($rsRALIC12, $iCont3);

                    if ($aRALIC10['si180_sequencial'] == $aRALIC12['si182_reg10']) {

                        $aCSVRALIC12['si182_tiporegistro']                = $this->padLeftZero($aRALIC12['si182_tiporegistro'], 2);
                        $aCSVRALIC12['si182_codorgaoresp']                = $this->padLeftZero($aRALIC12['si182_codorgaoresp'], 2);
                        $aCSVRALIC12['si182_codunidadesubresp']           = $this->padLeftZero($aRALIC12['si182_codunidadesubresp'], 5);
                        $aCSVRALIC12['si182_codunidadesubrespestadual']   = $this->padLeftZero($aRALIC12['si182_codunidadesubrespestadual'], 5);
                        $aCSVRALIC12['si182_exercicioprocesso']           = $this->padLeftZero($aRALIC12['si182_exercicioprocesso'], 5);
                        $aCSVRALIC12['si182_nroprocessolicitatorio']      = $this->padLeftZero($aRALIC12['si182_nroprocessolicitatorio'], 5);
                        $aCSVRALIC12['si182_codobralocal']                = $this->padLeftZero($aRALIC12['si182_codobralocal'], 5);
                        $aCSVRALIC12['si182_logradouro']                  = $aRALIC12['si182_logradouro'];
                        $aCSVRALIC12['si182_numero']                      = $this->padLeftZero($aRALIC12['si182_numero'], 5);
                        $aCSVRALIC12['si182_bairro']                      = $aRALIC12['si182_bairro'];
                        $aCSVRALIC12['si182_distrito']                    = $aRALIC12['si182_distrito'];
                        $aCSVRALIC12['si182_municipio']                   = $aRALIC12['si182_municipio'];
                        $aCSVRALIC12['si182_cep']                         = $aRALIC12['si182_cep'];
                        $aCSVRALIC12['si182_graulatitude']                = $aRALIC12['si182_graulatitude'];
                        $aCSVRALIC12['si182_minutolatitude']              = $aRALIC12['si182_minutolatitude'];
                        $aCSVRALIC12['si182_segundolatitude']             = $aRALIC12['si182_segundolatitude'];
                        $aCSVRALIC12['si182_graulongitude']               = $aRALIC12['si182_graulongitude'];
                        $aCSVRALIC12['si182_minutolongitude']             = $aRALIC12['si182_minutolongitude'];
                        $aCSVRALIC12['si182_segundolongitude']            = $aRALIC12['si182_segundolongitude'];
                        $aCSVRALIC12['si182_mes']                         = $aRALIC12['si182_mes'];
                        $aCSVRALIC12['si182_instit']                      = $aRALIC12['si182_instit'];


                        $this->sLinha = $aCSVRALIC12;
                        $this->adicionaLinha();

                    }

                }

            }

            $this->fechaArquivo();

        }

    }

}
