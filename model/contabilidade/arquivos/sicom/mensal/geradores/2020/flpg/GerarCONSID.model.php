<?php

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */

class GerarCONSID extends GerarAM {

    /**
     *
     * Mes de referÍncia
     * @var Integer
     */
    public $iMes;

    public function gerarDados() {

        $this->sArquivo = "CONSID";
        $this->abreArquivo();

        $sSql = "select * from consid102020 where si158_mes = ". $this->iMes;
        $rsCONSID10    = db_query($sSql);


        if (pg_num_rows($rsCONSID10) == 0 ) {

            $aCSV['tiporegistro']       =   '99';
            $this->sLinha = $aCSV;
            $this->adicionaLinha();

        } else {

            /**
             *
             * Registros 10
             */
            for ($iCont = 0;$iCont < pg_num_rows($rsCONSID10); $iCont++) {

                $aCONSID10  = pg_fetch_array($rsCONSID10,$iCont);

                $aCSVCONSID10['si158_tiporegistro']       =   str_pad($aCONSID10['si158_tiporegistro'], 2, "0", STR_PAD_LEFT);
                $aCSVCONSID10['si158_codarquivo']         =   str_pad($aCONSID10['si158_codarquivo'], 2, "0", STR_PAD_LEFT);
                $aCSVCONSID10['si158_consideracoes']      =   substr($aCONSID10['si158_consideracoes'], 0, 3000);


                $this->sLinha = $aCSVCONSID10;
                $this->adicionaLinha();

            }


            $this->fechaArquivo();

        }

    }

}
