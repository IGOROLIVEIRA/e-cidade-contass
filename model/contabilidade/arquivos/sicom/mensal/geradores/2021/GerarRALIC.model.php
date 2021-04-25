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

        $sSql = "select * from ralic102021 where si180_mes = " . $this->iMes . " and si180_instit=" . db_getsession("DB_instit");
        $rsRALIC10 = db_query($sSql);

        $sSql2 = "select * from ralic112021 where si181_mes = " . $this->iMes . " and si181_instit=" . db_getsession("DB_instit");;
        $rsRALIC11 = db_query($sSql2);

        $sSql3 = "select * from ralic122021 where si182_mes = " . $this->iMes . " and si182_instit=" . db_getsession("DB_instit");;
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
                $aCSVRALIC10['si180_codorgaoresp']               = $this->padLeftZero($aRALIC10['si180_codorgaoresp'], 3);
                $aCSVRALIC10['si180_codunidadesubresp']          = $this->padLeftZero($aRALIC10['si180_codunidadesubresp'], 5);
                $aCSVRALIC10['si180_codunidadesubrespestadual']  = !$aRALIC10['si180_codunidadesubrespestadual'] ? ' ': $this->padLeftZero($aRALIC10['si180_codunidadesubrespestadual'], 4);
                $aCSVRALIC10['si180_exerciciolicitacao']         = $this->padLeftZero($aRALIC10['si180_exerciciolicitacao'], 4);
                $aCSVRALIC10['si180_nroprocessolicitatorio']     =  substr($aRALIC10['si180_nroprocessolicitatorio'], 0, 12);
                $aCSVRALIC10['si180_tipocadastradolicitacao']    = $this->padLeftZero($aRALIC10['si180_tipocadastradolicitacao'], 1);
                $aCSVRALIC10['si180_dsccadastrolicitatorio']     = substr($aRALIC10['si180_dsccadastrolicitatorio'], 0, 150);
                $aCSVRALIC10['si180_codmodalidadelicitacao']     = $this->padLeftZero($aRALIC10['si180_codmodalidadelicitacao'], 1);
                $aCSVRALIC10['si180_naturezaprocedimento']       = $this->padLeftZero($aRALIC10['si180_naturezaprocedimento'], 1);
                $aCSVRALIC10['si180_nroedital']                  = $aRALIC10['si180_nroedital'];
                $aCSVRALIC10['si180_exercicioedital']            = $aRALIC10['si180_exercicioedital'];
                $aCSVRALIC10['si180_dtpublicacaoeditaldo']       = $this->sicomDate($aRALIC10['si180_dtpublicacaoeditaldo']);
                $aCSVRALIC10['si180_link']                       = substr($aRALIC10['si180_link'], 0, 150);
                $aCSVRALIC10['si180_tipolicitacao']              = $this->padLeftZero($aRALIC10['si180_tipolicitacao'], 1);
                $aCSVRALIC10['si180_naturezaobjeto']             = $aRALIC10['si180_naturezaobjeto'] == 0 ? ' ' : $aRALIC10['si180_naturezaobjeto'];
                $aCSVRALIC10['si180_objeto']                     = substr($aRALIC10['si180_objeto'], 0, 500);
                $aCSVRALIC10['si180_regimeexecucaoobras']        = $aRALIC10['si180_regimeexecucaoobras'] == 0 ? '' : $aRALIC10['si180_regimeexecucaoobras'];
                $aCSVRALIC10['si180_vlcontratacao']              = $this->sicomNumberReal($aRALIC10['si180_vlcontratacao'], 2);
                $aCSVRALIC10['si180_bdi']                        = $aRALIC10['si180_naturezaobjeto'] == '7' ? '' : $this->sicomNumberReal($aRALIC10['si180_bdi'], 2);
                $aCSVRALIC10['si180_mesexercicioreforc']         = $this->padLeftZero($aRALIC10['si180_mesexercicioreforc'], 6);
                $aCSVRALIC10['si180_origemrecurso']              = $aRALIC10['si180_origemrecurso'];
                $aCSVRALIC10['si180_dscorigemrecurso']           = substr($aRALIC10['si180_dscorigemrecurso'], 0, 150);
                $aCSVRALIC10['si180_qtdlotes']                   = $aRALIC10['si180_qtdlotes'];

                $this->sLinha = $aCSVRALIC10;
                $this->adicionaLinha();
				for ($iCont2 = 0; $iCont2 < pg_num_rows($rsRALIC11); $iCont2++) {

                    $aRALIC11 = pg_fetch_array($rsRALIC11, $iCont2);

                    if ($aRALIC10['si180_sequencial'] == $aRALIC11['si181_reg10']) {
						$aCSVRALIC11['si181_tiporegistro']                    = $this->padLeftZero($aRALIC11['si181_tiporegistro'], 2);
                        $aCSVRALIC11['si181_codorgaoresp']                    = $this->padLeftZero(intval($aRALIC11['si181_codorgaoresp']), 3);
                        $aCSVRALIC11['si181_codunidadesubresp']               = $this->padLeftZero($aRALIC11['si181_codunidadesubresp'], 5);
                        $aCSVRALIC11['si181_codunidadesubrespestadual']       = !trim($aRALIC11['si181_codunidadesubrespestadual']) ? ' ': $this->padLeftZero(intval($aRALIC11['si181_codunidadesubrespestadual']), 4);
                        $aCSVRALIC11['si181_exerciciolicitacao']              = $this->padLeftZero($aRALIC11['si181_exerciciolicitacao'], 4);
                        $aCSVRALIC11['si181_nroprocessolicitatorio']          = $aRALIC11['si181_nroprocessolicitatorio'];
                        $aCSVRALIC11['si181_codobralocal']                    = $aRALIC11['si181_codobralocal'];
                        $aCSVRALIC11['si181_classeobjeto']                    = $aRALIC11['si181_classeobjeto'];
                        $aCSVRALIC11['si181_tipoatividadeobra']               = !trim($aRALIC11['si181_tipoatividadeobra']) ? '' : $this->padLeftZero($aRALIC11['si181_tipoatividadeobra'], 2);
                        $aCSVRALIC11['si181_tipoatividadeservico']            = !trim($aRALIC11['si181_tipoatividadeservico']) ? '' : $this->padLeftZero($aRALIC11['si181_tipoatividadeservico'], 2);
                        $aCSVRALIC11['si181_dscatividadeservico']             = utf8_decode($aRALIC11['si181_dscatividadeservico']);
                        $aCSVRALIC11['si181_tipoatividadeservespecializado']  = !trim($aRALIC11['si181_tipoatividadeservespecializado']) ? '' : $this->padLeftZero($aRALIC11['si181_tipoatividadeservespecializado'], 2);
                        $aCSVRALIC11['si181_dscatividadeservespecializado']   = utf8_decode($aRALIC11['si181_dscatividadeservespecializado']);
                        $aCSVRALIC11['si181_codfuncao']                       = $this->padLeftZero(intval($aRALIC11['si181_codfuncao']), 2);
                        $aCSVRALIC11['si181_codsubfuncao']                    = $this->padLeftZero(intval($aRALIC11['si181_codsubfuncao']), 3);
                        $aCSVRALIC11['si181_codbempublico']                   = $this->padLeftZero($aRALIC11['si181_codbempublico'], 4);
                        $aCSVRALIC11['si181_nrolote']                         = $aRALIC11['si181_nrolote'];

                        $this->sLinha = $aCSVRALIC11;
                        $this->adicionaLinha();
                    }

					for ($iCont3 = 0; $iCont3 < pg_num_rows($rsRALIC12); $iCont3++) {

						$aRALIC12 = pg_fetch_array($rsRALIC12, $iCont3);
						if ($aRALIC10['si180_sequencial'] == $aRALIC12['si182_reg10'] && $aRALIC11['si181_codobralocal'] == $aRALIC12['si182_codobralocal']) {
							$aCSVRALIC12['si182_tiporegistro']                = $this->padLeftZero($aRALIC12['si182_tiporegistro'], 2);
							$aCSVRALIC12['si182_codorgaoresp']                = $this->padLeftZero($aRALIC12['si182_codorgaoresp'], 3);
							$aCSVRALIC12['si182_codunidadesubresp']           = $this->padLeftZero($aRALIC12['si182_codunidadesubresp'], 5);
							$aCSVRALIC12['si182_codunidadesubrespestadual']   = !trim($aRALIC12['si182_codunidadesubrespestadual']) ? ' ': $this->padLeftZero(intval($aRALIC12['si182_codunidadesubrespestadual']), 4);
							$aCSVRALIC12['si182_exercicioprocesso']           = $this->padLeftZero($aRALIC12['si182_exercicioprocesso'], 4);
							$aCSVRALIC12['si182_nroprocessolicitatorio']      = $aRALIC12['si182_nroprocessolicitatorio'];
							$aCSVRALIC12['si182_codobralocal']                = $aRALIC12['si182_codobralocal'];
							$aCSVRALIC12['si182_logradouro']                  = utf8_decode($aRALIC12['si182_logradouro']);
							$aCSVRALIC12['si182_numero']                      = !$aRALIC12['si182_numero'] ? '' : $aRALIC12['si182_numero'];
							$aCSVRALIC12['si182_bairro']                      = utf8_decode($aRALIC12['si182_bairro']);
							$aCSVRALIC12['si182_distrito']                    = utf8_decode($aRALIC12['si182_distrito']);
							$aCSVRALIC12['si182_municipio']                   = utf8_decode($aRALIC12['si182_municipio']);
							$aCSVRALIC12['si182_cep']                         = $aRALIC12['si182_cep'];
							$aCSVRALIC12['si182_latitude']                    = $aRALIC12['si182_latitude'];
							$aCSVRALIC12['si182_longitude']                   = $aRALIC12['si182_longitude'];
                            $aCSVRALIC12['si182_codbempublico']               = $aRALIC12['si182_codbempublico'];
                            $aCSVRALIC12['si182_nrolote']                     = $aRALIC12['si182_nrolote'];

							$this->sLinha = $aCSVRALIC12;
							$this->adicionaLinha();

						}

					}

                }

            }

            $this->fechaArquivo();

        }

    }

}
