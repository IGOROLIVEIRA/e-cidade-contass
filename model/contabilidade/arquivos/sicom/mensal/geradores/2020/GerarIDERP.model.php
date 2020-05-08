<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author Mario Junior
 * @package Contabilidade
 */
class GerarIDERP extends GerarAM
{

    /**
     *
     * Mes de referência
     * @var Integer
     */
    public $iMes;

    public function gerarDados()
    {

        $this->sArquivo = "IDERP";
        $this->abreArquivo();

        $sSql = "select * from iderp102020 where si179_mes = " . $this->iMes . " and si179_instit = " . db_getsession("DB_instit");
        $rsiderp10 = db_query($sSql);

        $sSql2 = "select * from iderp112020 where si180_mes = " . $this->iMes . " and si180_instit = " . db_getsession("DB_instit");
        $rsiderp11 = db_query($sSql2);

        $sSql3 = "select * from iderp202020 where si181_mes = " . $this->iMes . " and si181_instit = " . db_getsession("DB_instit");
        $rsiderp20 = db_query($sSql3);

        if (pg_num_rows($rsiderp10) == 0 && pg_num_rows($rsiderp11) == 0 && pg_num_rows($rsiderp20) == 0 || $this->iMes != 12 ) {

            $aCSV['tiporegistro'] = '99';
            $this->sLinha = $aCSV;
            $this->adicionaLinha();

        } else {

            for ($iCont = 0; $iCont < pg_num_rows($rsiderp10); $iCont++) {

                $oiderp10 = pg_fetch_array($rsiderp10, $iCont);

                $aIDERP10['si179_tiporegistro'] = $this->padLeftZero($oiderp10['si179_tiporegistro'], 2);
                $aIDERP10['si179_codiderp'] = $oiderp10['si179_codiderp'];
                $aIDERP10['si179_codorgao'] = $this->padLeftZero($oiderp10['si179_codorgao'], 2);
                $aIDERP10['si179_codunidadesub'] = $this->padLeftZero($oiderp10['si179_codunidadesub'], 5);
                $aIDERP10['si179_nroempenho'] = $oiderp10['si179_nroempenho'];
                $aIDERP10['si179_tiporestospagar'] = $oiderp10['si179_tiporestospagar'];
                $aIDERP10['si179_disponibilidadecaixa'] = $oiderp10['si179_disponibilidadecaixa'];
                $aIDERP10['si179_vlinscricao'] = $this->sicomNumberReal($oiderp10['si179_vlinscricao'], 2);
                $this->sLinha = $aIDERP10;
                $this->adicionaLinha();


                for ($iCont2 = 0; $iCont2 < pg_num_rows($rsiderp11); $iCont2++) {

                    $oiderp11 = pg_fetch_array($rsiderp11, $iCont2);
                    if ($oiderp10['si179_sequencial'] == $oiderp11['si180_reg10']) {
                        $aIDERP11['si180_tiporegistro'] = $this->padLeftZero($oiderp11['si180_tiporegistro'], 2);
                        $aIDERP11['si180_codiderp'] = $oiderp11['si180_codiderp'];
                        $aIDERP11['si180_codfontrecursos'] = $oiderp11['si180_codfontrecursos'];
                        $aIDERP11['si180_vlinscricaofonte'] = $this->sicomNumberReal($oiderp11['si180_vlinscricaofonte'], 2);
                        $this->sLinha = $aIDERP11;
                        $this->adicionaLinha();
                    }
                }
            }
            for ($iCont3 = 0; $iCont3 < pg_num_rows($rsiderp20); $iCont3++) {

                $oiderp20 = pg_fetch_array($rsiderp20, $iCont3);

                $aIDERP20['si181_tiporegistro']             = $this->padLeftZero($oiderp20['si181_tiporegistro'], 2);
                $aIDERP20['si181_codorgao']                 = $this->padLeftZero($oiderp20['si181_codorgao'],2);
                $aIDERP20['si181_codfontrecursos']          = $oiderp20['si181_codfontrecursos'];
                $aIDERP20['si181_vlcaixabruta']             = $this->sicomNumberReal($oiderp20['si181_vlcaixabruta'], 2);
                $aIDERP20['si181_vlrspexerciciosanteriores']= $this->sicomNumberReal($oiderp20['si181_vlrspexerciciosanteriores'], 2);
                $aIDERP20['si181_vlrestituiveisrecolher']   = $this->sicomNumberReal($oiderp20['si181_vlrestituiveisrecolher'], 2);
                $aIDERP20['si181_vlrestituiveisativofinanceiro']= $this->sicomNumberReal($oiderp20['si181_vlrestituiveisativofinanceiro'], 2);
                $aIDERP20['si181_vlsaldodispcaixa']             = $this->sicomNumberReal($oiderp20['si181_vlsaldodispcaixa'], 2);
                $this->sLinha = $aIDERP20;
                $this->adicionaLinha();

            }

        }

        $this->fechaArquivo();

    }

}
