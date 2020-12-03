<?php

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */

class GerarFLPGO extends GerarAM {

    /**
     *
     * Mes de refer?cia
     * @var Integer
     */
    public $iMes;

    public function gerarDados() {

        $this->sArquivo = "FLPGO";
        $this->abreArquivo();

        $sSql = "select * from flpgo102020 where si195_mes = ". $this->iMes ." and si195_inst = ". db_getsession("DB_instit");
        $rsFLPGO10    = db_query($sSql);

        $sSql2 = "select * from flpgo112020 where si196_mes = ". $this->iMes ." and si196_inst = ". db_getsession("DB_instit");
        $rsFLPGO11    = db_query($sSql2);

        $sSql3 = "select * from flpgo122020 where si197_mes = ". $this->iMes ." and si197_inst = ". db_getsession("DB_instit");
        $rsFLPGO12    = db_query($sSql3);


        if (pg_num_rows($rsFLPGO10) == 0) {

            $aCSV['tiporegistro']       =   '99';
            $this->sLinha = $aCSV;
            $this->adicionaLinha();

        } else {

            /**
             *
             * Registros 10, 11
             */

            for ($iCont = 0;$iCont < pg_num_rows($rsFLPGO10); $iCont++) {

                // db_criatabela($rsFLPGO10, $iCont);die();
                $aFLPGO10  = pg_fetch_array($rsFLPGO10,$iCont);
                $aCSVFLPGO10['si195_tiporegistro']                        =   str_pad($aFLPGO10['si195_tiporegistro'], 2, "0", STR_PAD_LEFT);
                $aCSVFLPGO10['si195_codvinculopessoa']                    =   $aFLPGO10['si195_codvinculopessoa'];
                $aCSVFLPGO10['si195_regime']                              =   str_pad($aFLPGO10['si195_regime'], 1, "0", STR_PAD_LEFT);
                $aCSVFLPGO10['si195_indtipopagamento']                    =   str_pad($aFLPGO10['si195_indtipopagamento'], 1, "0", STR_PAD_LEFT);
                $aCSVFLPGO10['si195_dsctipopagextra']                     =   substr($aFLPGO10['si195_dsctipopagextra'], 0, 150);
                $aCSVFLPGO10['si195_indsituacaoservidorpensionista']      =   str_pad($aFLPGO10['si195_indsituacaoservidorpensionista'], 1, "0", STR_PAD_LEFT);
                $aCSVFLPGO10['si195_dscsituacao']                         =   substr($aFLPGO10['si195_dscsituacao'], 0, 150);
                $aCSVFLPGO10['si195_indpensionistaprevidenciario']                         =   empty($aFLPGO10['si195_indpensionistaprevidenciario']) ? ' ' : $aFLPGO10['si195_indpensionistaprevidenciario'];
                $aCSVFLPGO10['si195_nrocpfinstituidor']                   =   (!empty($aFLPGO10['si195_nrocpfinstituidor']))? $aFLPGO10['si195_nrocpfinstituidor']   : '';
                $aCSVFLPGO10['si195_datobitoinstituidor']                 =   implode("", array_reverse(explode("-", $aFLPGO10['si195_datobitoinstituidor'])));
                $aCSVFLPGO10['si195_tipodependencia']                     =   str_pad($aFLPGO10['si195_tipodependencia'], 1, "", STR_PAD_LEFT);
                if($aCSVFLPGO10['si195_tipodependencia'] == 0){
                  $aCSVFLPGO10['si195_tipodependencia'] = '';
                }
                $aCSVFLPGO10['si195_dscdependencia']                         =   substr($aFLPGO10['si195_dscdependencia'], 0, 150);
                $aCSVFLPGO10['si195_datafastpreliminar']                     =   empty($aFLPGO10['si195_datafastpreliminar']) ? ' ' : $aFLPGO10['si195_datafastpreliminar']; 

                if($aFLPGO10['si195_indsituacaoservidorpensionista'] == 'P'){

                    $aCSVFLPGO10['si195_datconcessaoaposentadoriapensao'] =  implode("", array_reverse(explode("-", $aFLPGO10['si195_datconcessaoaposentadoriapensao'])));

                    if($aFLPGO10['si195_indsituacaoservidorpensionista'] == 'I') {
                        $aCSVFLPGO10['si195_dsccargo']           = substr($aFLPGO10['si195_dsccargo'], 0, 120);
                        $aCSVFLPGO10['si195_codcargo']           = ($aFLPGO10['si195_codcargo']==0)?' ':$aFLPGO10['si195_codcargo'];
                        $aCSVFLPGO10['si195_sglcargo']           = str_pad($aFLPGO10['si195_sglcargo'], 3, "0", STR_PAD_LEFT);
                    }else{
                        $aCSVFLPGO10['si195_dsccargo']           = ' ';
                        $aCSVFLPGO10['si195_codcargo']           = ($aFLPGO10['si195_codcargo']==0)?' ':$aFLPGO10['si195_codcargo'];
                        $aCSVFLPGO10['si195_sglcargo']           = ' ';
                    }

                    $aCSVFLPGO10['si195_dscsiglacargo']          =   ' ';
                    $aCSVFLPGO10['si195_dscapo'] = substr($aFLPGO10['si195_dscapo'],0, 3);

                    if($aFLPGO10['si195_indsituacaoservidorpensionista'] == 'I')
                        $aCSVFLPGO10['si195_natcargo']           = str_pad($aFLPGO10['si195_natcargo'], 1, "0", STR_PAD_LEFT);
                    else
                        $aCSVFLPGO10['si195_natcargo']           = ' ';

                    $aCSVFLPGO10['si195_dscnatcargo']            =   $aFLPGO10['si195_dscnatcargo'];
                    $aCSVFLPGO10['si195_indcessao']              =   $aFLPGO10['si195_indcessao'];

                    if($aFLPGO10['si195_indsituacaoservidorpensionista'] == 'I') {
                        $aCSVFLPGO10['si195_dsclotacao']         = ' ';
                        $aCSVFLPGO10['si195_indsalaaula']            =   $aFLPGO10['si195_indsalaaula'];
                        $aCSVFLPGO10['si195_vlrcargahorariasemanal'] = number_format(str_pad($aFLPGO10['si195_vlrcargahorariasemanal'], 2, "0", STR_PAD_LEFT),2,',', '');
                    }else{
                        $aCSVFLPGO10['si195_dsclotacao']         = ' ';
                        $aCSVFLPGO10['si195_indsalaaula']            =   $aFLPGO10['si195_indsalaaula'];
                        $aCSVFLPGO10['si195_vlrcargahorariasemanal'] = ' ';
                    }
                    

                }else {

                    if($aFLPGO10['si195_indsituacaoservidorpensionista'] == 'I') {
                        $aCSVFLPGO10['si195_datconcessaoaposentadoriapensao'] = implode("", array_reverse(explode("-", $aFLPGO10['si195_datconcessaoaposentadoriapensao'])));
                    }else{
                        $aCSVFLPGO10['si195_datconcessaoaposentadoriapensao'] = ' ';
                    }

                    $aCSVFLPGO10['si195_dsccargo']               = substr($aFLPGO10['si195_dsccargo'], 0, 120);
                    $aCSVFLPGO10['si195_codcargo']               = ($aFLPGO10['si195_codcargo']==0)?' ':$aFLPGO10['si195_codcargo'];
                    $aCSVFLPGO10['si195_sglcargo']               = str_pad($aFLPGO10['si195_sglcargo'], 3, "0", STR_PAD_LEFT);

                    if($aCSVFLPGO10['si195_sglcargo'] == 'OTC')
                        $aCSVFLPGO10['si195_dscsiglacargo']      = substr($aFLPGO10['si195_dsccargo'], 0, 150);
                    else
                        $aCSVFLPGO10['si195_dscsiglacargo']      = ' ';

                    $aCSVFLPGO10['si195_dscapo']                 = substr($aFLPGO10['si195_dscapo'],0, 3);
                    $aCSVFLPGO10['si195_natcargo']               = str_pad($aFLPGO10['si195_natcargo'], 1, "0", STR_PAD_LEFT);
                    $aCSVFLPGO10['si195_dscnatcargo']            = $aFLPGO10['si195_dscnatcargo'];
                    $aCSVFLPGO10['si195_indcessao']              = str_pad($aFLPGO10['si195_indcessao'], 1, " ", STR_PAD_LEFT);
                    $aCSVFLPGO10['si195_dsclotacao']             = substr($aFLPGO10['si195_dsclotacao'], 0, 22);
                    $aCSVFLPGO10['si195_indsalaaula']            =   $aFLPGO10['si195_indsalaaula'];
                    $aCSVFLPGO10['si195_vlrcargahorariasemanal'] = (!empty($aFLPGO10['si195_vlrcargahorariasemanal'])) ? number_format(str_pad($aFLPGO10['si195_vlrcargahorariasemanal'], 2, "0", STR_PAD_LEFT),2,',', '') : '';
                }
                if($aFLPGO10['si195_indsituacaoservidorpensionista'] == 'I' || $aFLPGO10['si195_indsituacaoservidorpensionista'] == 'A' || $aFLPGO10['si195_indsituacaoservidorpensionista'] == 'O') {
                    $aCSVFLPGO10['si195_datefetexercicio']       = implode("", array_reverse(explode("-", $aFLPGO10['si195_datefetexercicio'])));
                }else{
                    $aCSVFLPGO10['si195_datefetexercicio']       = ' ';
                }
                $aCSVFLPGO10['si195_datcomissionado']            = ($aCSVFLPGO10['si195_sglcargo'] == 'CRR'||$aCSVFLPGO10['si195_sglcargo'] == 'CRA')?implode("", array_reverse(explode("-", $aFLPGO10['si195_datcomissionado']))):' ';
                $aCSVFLPGO10['si195_datexclusao']                =   implode("", array_reverse(explode("-", $aFLPGO10['si195_datexclusao'])));
                $aCSVFLPGO10['si195_datcomissionadoexclusao']    =   ($aCSVFLPGO10['si195_sglcargo'] == 'CRR'||$aCSVFLPGO10['si195_sglcargo'] == 'CRA')?implode("", array_reverse(explode("-", $aFLPGO10['si195_datcomissionadoexclusao']))):' ';
                $aCSVFLPGO10['si195_vlrremuneracaobruta']        =   number_format($aFLPGO10['si195_vlrremuneracaobruta'], 2, ",", "");
                $aCSVFLPGO10['si195_vlrdescontos']               =   number_format($aFLPGO10['si195_vlrdescontos'], 2, ",", "");
                $aCSVFLPGO10['si195_vlrremuneracaoliquida']      =   number_format($aFLPGO10['si195_vlrremuneracaoliquida'], 2, ",", "");
                $aCSVFLPGO10['si195_natsaldoliquido']            =   str_pad($aFLPGO10['si195_natsaldoliquido'], 1, "0", STR_PAD_LEFT);

                $this->sLinha = $aCSVFLPGO10;
                // var_dump($aCSVFLPGO10);die();
                $this->adicionaLinha();


                for ($iCont2 = 0;$iCont2 < pg_num_rows($rsFLPGO11); $iCont2++) {

                    $aFLPGO11  = pg_fetch_array($rsFLPGO11,$iCont2);

                    if ($aFLPGO10['si195_sequencial'] == $aFLPGO11['si196_reg10']) {

                        $aCSVFLPGO11['si196_tiporegistro']             =    str_pad($aFLPGO11['si196_tiporegistro'], 2, "0", STR_PAD_LEFT);
                        $aCSVFLPGO11['si196_indtipopagamento']         =    $aFLPGO11['si196_indtipopagamento'];
                        $aCSVFLPGO11['si196_codvinculopessoa']         =    substr($aFLPGO11['si196_codvinculopessoa'],0,15);
                        $aCSVFLPGO11['si196_codrubricaremuneracao']    =    substr($aFLPGO11['si196_codrubricaremuneracao'],0,4);
                        if($aCSVFLPGO11['si196_codrubricaremuneracao'] == '1099' ||
                            $aCSVFLPGO11['si196_codrubricaremuneracao'] == '1299' ||
                            $aCSVFLPGO11['si196_codrubricaremuneracao'] == '1403' ||
                            $aCSVFLPGO11['si196_codrubricaremuneracao'] == '6129' ||
                            $aCSVFLPGO11['si196_codrubricaremuneracao'] == '9299'){
                            $aCSVFLPGO11['si196_desctiporubrica']          =    substr($aFLPGO11['si196_desctiporubrica'],0,150);
                        }else{
                            $aCSVFLPGO11['si196_desctiporubrica']          =    ' ';
                        }
                        $aCSVFLPGO11['si196_vlrremuneracaodetalhada']  =    number_format($aFLPGO11['si196_vlrremuneracaodetalhada'], 2, ",", "");

                        $this->sLinha = $aCSVFLPGO11;
                        $this->adicionaLinha();

                    }

                }

                for ($iCont3 = 0;$iCont3 < pg_num_rows($rsFLPGO12); $iCont3++) {

                    $aFLPGO12  = pg_fetch_array($rsFLPGO12,$iCont3);

                    if ($aFLPGO10['si195_sequencial'] == $aFLPGO12['si197_reg10']) {

                        $aCSVFLPGO12['si197_tiporegistro']             =    str_pad($aFLPGO12['si197_tiporegistro'], 2, "0", STR_PAD_LEFT);
                        $aCSVFLPGO12['si197_indtipopagamento']         =    $aFLPGO12['si197_indtipopagamento'];
                        $aCSVFLPGO12['si197_codvinculopessoa']         =    $aFLPGO12['si197_codvinculopessoa'];
                        $aCSVFLPGO12['si197_codrubricadesconto']       =    $aFLPGO12['si197_codrubricadesconto'];
                        if($aCSVFLPGO12['si197_codrubricadesconto'] == '9222' || $aCSVFLPGO12['si197_codrubricadesconto'] == '9299'){
                            $aCSVFLPGO12['si197_desctiporubricadesconto']          =    substr($aFLPGO12['si197_desctiporubricadesconto'],0,150);
                        }else{
                            $aCSVFLPGO12['si197_desctiporubricadesconto']          =    ' ';
                        }
                        $aCSVFLPGO12['si197_vlrremuneracaodetalhada']  =    number_format($aFLPGO12['si197_vlrdescontodetalhado'], 2, ",", "");

                        $this->sLinha = $aCSVFLPGO12;
                        $this->adicionaLinha();

                    }

                }

            }

            $this->fechaArquivo();

        }

    }

}
