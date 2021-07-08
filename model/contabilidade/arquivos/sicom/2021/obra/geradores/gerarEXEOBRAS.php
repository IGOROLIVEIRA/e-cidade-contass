<?php
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");
/**
 * Sicom Acompanhamento Mensal
 * @author Mario Junior
 * @package Obras
 */

class gerarEXEOBRAS extends GerarAM
{
    /**
     *
     * Mes de referência
     * @var Integer
     */
    public $iMes;

    public function gerarDados()
    {

        $this->sArquivo = "EXEOBRAS";
        $this->abreArquivo();

        $sSql = "select * from exeobras102021 where si197_mes = " . $this->iMes . " and si197_instit=" . db_getsession("DB_instit");
        $rsexeobras102021 = db_query($sSql);

        $sSql = "select * from exeobras202021 where si204_mes = " . $this->iMes . " and si204_instit=" . db_getsession("DB_instit");
        $rsexeobras202021 = db_query($sSql);


        if (pg_num_rows($rsexeobras102021) == 0) {

//            $aCSV['tiporegistro'] = '99';
//            $this->sLinha = $aCSV;
//            $this->adicionaLinha();

        } else {

            /**
             *
             * Registros 10
             */
            for ($iCont = 0; $iCont < pg_num_rows($rsexeobras102021); $iCont++) {

                $aEXEOBRAS10 = pg_fetch_array($rsexeobras102021, $iCont);

                $aCSVEXEOBRAS10['si197_tiporegistro'] = $aEXEOBRAS10['si197_tiporegistro'];
                $aCSVEXEOBRAS10['si197_codorgao'] = str_pad($aEXEOBRAS10['si197_codorgao'], 3, "0", STR_PAD_LEFT);
                $aCSVEXEOBRAS10['si197_codunidadesub'] = substr($aEXEOBRAS10['si197_codunidadesub'], 0, 8);
                $aCSVEXEOBRAS10['si197_nrocontrato'] = $aEXEOBRAS10['si197_nrocontrato'];
                $aCSVEXEOBRAS10['si197_exerciciolicitacao'] = $aEXEOBRAS10['si197_exerciciolicitacao'];
                $aCSVEXEOBRAS10['si197_codobra'] = $aEXEOBRAS10['si197_codobra'];
                $aCSVEXEOBRAS10['si197_objeto'] = $aEXEOBRAS10['si197_objeto'];
                $aCSVEXEOBRAS10['si197_linkobra'] = $aEXEOBRAS10['si197_linkobra'];
                $this->sLinha = $aCSVEXEOBRAS10;
                $this->adicionaLinha();
            }
        }

        if (pg_num_rows($rsexeobras202021) == 0) {

//            $aCSV['tiporegistro'] = '99';
//            $this->sLinha = $aCSV;
//            $this->adicionaLinha();

        } else {

            /**
             *
             * Registros 20
             */
            for ($iCont = 0; $iCont < pg_num_rows($rsexeobras202021); $iCont++) {

                $aEXEOBRAS20 = pg_fetch_array($rsexeobras202021, $iCont);

                $aCSVEXEOBRAS20['si204_tiporegistro'] = $aEXEOBRAS20['si204_tiporegistro'];
                $aCSVEXEOBRAS20['si204_codorgao'] = str_pad($aEXEOBRAS20['si204_codorgao'], 3, "0", STR_PAD_LEFT);
                $aCSVEXEOBRAS20['si204_codunidadesub'] = substr($aEXEOBRAS20['si204_codunidadesub'], 0, 8);
                $aCSVEXEOBRAS20['si204_nrocontrato'] = $aEXEOBRAS20['si204_nrocontrato'];
                $aCSVEXEOBRAS20['si204_exerciciocontrato'] = $aEXEOBRAS20['si204_exerciciocontrato'];
                $aCSVEXEOBRAS20['si204_nroprocesso'] = $aEXEOBRAS20['si204_nroprocesso'];
                $aCSVEXEOBRAS20['si204_tipoprocesso'] = $aEXEOBRAS20['si204_tipoprocesso'];
                $aCSVEXEOBRAS20['si204_codobra'] = $aEXEOBRAS20['si204_codobra'];
                $aCSVEXEOBRAS20['si204_objeto'] = $aEXEOBRAS20['si204_objeto'];
                $aCSVEXEOBRAS20['si204_linkobra'] = $aEXEOBRAS20['si204_linkobra'];
                $this->sLinha = $aCSVEXEOBRAS20;
                $this->adicionaLinha();
            }
        }

        $this->fechaArquivo();
    }
}
