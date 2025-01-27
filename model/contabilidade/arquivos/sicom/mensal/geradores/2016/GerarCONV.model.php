<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarCONV extends GerarAM {

   /**
  * 
  * Mes de referÍncia
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "CONV";
    $this->abreArquivo();
    
    $sSql = "select * from conv102016 where si92_mes = ". $this->iMes ." and si92_instit = ". db_getsession("DB_instit");
    $rsCONV10    = db_query($sSql);

    $sSql2 = "select * from conv112016 where si93_mes = ". $this->iMes ." and si93_instit = ". db_getsession("DB_instit");
    $rsCONV11    = db_query($sSql2);

    $sSql3 = "select * from conv202016 where si94_mes = ". $this->iMes ." and si94_instit = ". db_getsession("DB_instit");
    $rsCONV20    = db_query($sSql3);


  if (pg_num_rows($rsCONV10) == 0 && pg_num_rows($rsCONV20) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10, 11
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsCONV10); $iCont++) {

        $aCONV10  = pg_fetch_array($rsCONV10,$iCont);
        
        $aCSVCONV10['si92_tiporegistro']             =   str_pad($aCONV10['si92_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVCONV10['si92_codconvenio']              =   substr($aCONV10['si92_codconvenio'], 0, 15);
        $aCSVCONV10['si92_codorgao']                 =   str_pad($aCONV10['si92_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVCONV10['si92_nroconvenio']              =   substr($aCONV10['si92_nroconvenio'], 0, 30);
        $aCSVCONV10['si92_dataassinatura']           =   implode("", array_reverse(explode("-", $aCONV10['si92_dataassinatura'])));
        $aCSVCONV10['si92_objetoconvenio']           =   substr($aCONV10['si92_objetoconvenio'], 0, 500);
        $aCSVCONV10['si92_datainiciovigencia']       =   implode("", array_reverse(explode("-", $aCONV10['si92_datainiciovigencia'])));
        $aCSVCONV10['si92_datafinalvigencia']        =   implode("", array_reverse(explode("-", $aCONV10['si92_datafinalvigencia'])));
        $aCSVCONV10['si92_vlconvenio']               =   number_format($aCONV10['si92_vlconvenio'], 2, ",", "");
        $aCSVCONV10['si92_vlcontrapartida']          =   number_format($aCONV10['si92_vlcontrapartida'], 2, ",", "");

        $this->sLinha = $aCSVCONV10;
        $this->adicionaLinha();

        for ($iCont2 = 0;$iCont2 < pg_num_rows($rsCONV11); $iCont2++) {        

          $aCONV11  = pg_fetch_array($rsCONV11,$iCont2);
          
          if ($aCONV10['si92_sequencial'] == $aCONV11['si93_reg10']) {

            $aCSVCONV11['si93_tiporegistro']          =   str_pad($aCONV11['si93_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVCONV11['si93_codconvenio']           =   substr($aCONV11['si93_codconvenio'], 0, 15);
            $aCSVCONV11['si93_tipodocumento']         =   str_pad($aCONV11['si92_tiporegistro'], 1, "0", STR_PAD_LEFT);
            $aCSVCONV11['si93_nrodocumento']          =   str_pad($aCONV11['si93_nrodocumento'], 14, "0", STR_PAD_LEFT);
            $aCSVCONV11['si93_esferaconcedente']      =   str_pad($aCONV11['si93_esferaconcedente'], 1, "0", STR_PAD_LEFT);
            $aCSVCONV11['si93_valorconcedido']        =   number_format($aCONV11['si93_valorconcedido'], 2, ",", "");

            $this->sLinha = $aCSVCONV11;
            $this->adicionaLinha();
          }

        }

      }

      /**
      *
      * Registros 20
      */
      for ($iCont3 = 0;$iCont3 < pg_num_rows($rsCONV20); $iCont3++) {

        $aCONV20  = pg_fetch_array($rsCONV20,$iCont3);
        
        $aCSVCONV20['si94_tiporegistro']                  =  str_pad($aCONV20['si94_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVCONV20['si94_codorgao']                      =  str_pad($aCONV20['si94_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVCONV20['si94_nroconvenio']                   =  substr($aCONV20['si94_nroconvenio'], 0, 30);
        $aCSVCONV20['si94_dtassinaturaconvoriginal']      =  implode("", array_reverse(explode("-", $aCONV20['si94_dtassinaturaconvoriginal'])));
        $aCSVCONV20['si94_nroseqtermoaditivo']            =  str_pad($aCONV20['si94_nroseqtermoaditivo'], 2, "0", STR_PAD_LEFT);
        $aCSVCONV20['si94_dscalteracao']                  =  substr($aCONV20['si94_dscalteracao'], 0, 500);
        $aCSVCONV20['si94_dtassinaturatermoaditivo']      =  implode("", array_reverse(explode("-", $aCONV20['si94_dtassinaturatermoaditivo'])));
        $aCSVCONV20['si94_datafinalvigencia']             =  implode("", array_reverse(explode("-", $aCONV20['si94_datafinalvigencia'])));
        $aCSVCONV20['si94_valoratualizadoconvenio']       =  number_format($aCONV20['si94_valoratualizadoconvenio'], 2, ",", "");
        $aCSVCONV20['si94_valoratualizadocontrapartida']  =  number_format($aCONV20['si94_valoratualizadocontrapartida'], 2, ",", "");

        $this->sLinha = $aCSVCONV20;
        $this->adicionaLinha();

      }


      $this->fechaArquivo();

    }
    
  }

}
