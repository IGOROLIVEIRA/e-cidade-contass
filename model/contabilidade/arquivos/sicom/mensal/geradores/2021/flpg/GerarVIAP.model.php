<?php

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */

class GerarVIAP extends GerarAM {

    /**
     *
     * Mes de referencia
     * @var Integer
     */
    public $iMes;

    public function gerarDados() {

        $this->sArquivo = "VIAP";
        $this->abreArquivo();

        $sSql          = "select * from viap102021 where si198_mes = ". $this->iMes." and si198_instit = ".db_getsession("DB_instit");
        $rsVIAP10    = db_query($sSql);

        if (pg_num_rows($rsVIAP10) == 0) {

            $aCSV['tiporegistro']       =   '99';
            $this->sLinha = $aCSV;
            $this->adicionaLinha();

        } else {

            for ($iCont = 0;$iCont < pg_num_rows($rsVIAP10); $iCont++) {

                $aVIAP10  = pg_fetch_array($rsVIAP10,$iCont, PGSQL_ASSOC);

                unset($aVIAP10['si198_sequencial']);
                unset($aVIAP10['si198_mes']);
                unset($aVIAP10['si198_instit']);

                $aCSVVIAP10['si198_tiporegistro']             =  str_pad($aVIAP10['si198_tiporegistro'], 2, "0", STR_PAD_LEFT);
                $aCSVVIAP10['si198_nrocpfagentepublico']      =  substr($aVIAP10['si198_nrocpfagentepublico'], 0,11);
                $aCSVVIAP10['si198_codmatriculapessoa']       =  $aVIAP10['si198_codmatriculapessoa'];
                $aCSVVIAP10['si198_codvinculopessoa']       =  $aVIAP10['si198_codvinculopessoa'];


                $this->sLinha = $aCSVVIAP10;
                $this->adicionaLinha();

            }

        }
        $this->fechaArquivo();
    }

} 
