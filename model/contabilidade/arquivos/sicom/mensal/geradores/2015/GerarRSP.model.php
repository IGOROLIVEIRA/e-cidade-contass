<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarRSP extends GerarAM {

   /**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "RSP";
    $this->abreArquivo();
    
    $sSql = "select * from rsp102015 where si112_mes = ". $this->iMes ." and si112_instit = ". db_getsession("DB_instit");
    $rsRSP10    = db_query($sSql);

    $sSql2 = "select * from rsp112015 where si113_mes = ". $this->iMes ." and si113_instit = ". db_getsession("DB_instit");
    $rsRSP11    = db_query($sSql2);

    $sSql3 = "select * from rsp122015 where si114_mes = ". $this->iMes ." and si114_instit = ". db_getsession("DB_instit");
    $rsRSP12    = db_query($sSql3);

    $sSql4 = "select * from rsp202015 where si115_mes = ". $this->iMes ." and si115_instit = ". db_getsession("DB_instit");
    $rsRSP20    = db_query($sSql4);

    $sSql5 = "select * from rsp212015 where si116_mes = ". $this->iMes ." and si116_instit = ". db_getsession("DB_instit");
    $rsRSP21    = db_query($sSql5);

    $sSql6 = "select * from rsp222015 where si117_mes = ". $this->iMes ." and si117_instit = ". db_getsession("DB_instit");
    $rsRSP22    = db_query($sSql6);

  if (pg_num_rows($rsRSP10) == 0 && pg_num_rows($rsRSP20) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10, 11, 12
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsRSP10); $iCont++) {

        $aRSP10  = pg_fetch_array($rsRSP10,$iCont);
        
        $aCSVRSP10['si112_tiporegistro']                    =   str_pad($aRSP10['si112_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVRSP10['si112_codreduzidorsp']                  =   substr($aRSP10['si112_codreduzidorsp'], 0, 15);
        $aCSVRSP10['si112_codorgao']                        =   str_pad($aRSP10['si112_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVRSP10['si112_codunidadesub']                   =   str_pad($aRSP10['si112_codunidadesub'], 5, "0", STR_PAD_LEFT);
        /**
        *Arquivo codunidadesuborig não está no banco de dados
        */
        $aCSVRSP10['si112_codunidadesuborig']               =   str_pad($aRSP10['si112_codunidadesuborig'], 5, "0", STR_PAD_LEFT);
        $aCSVRSP10['si112_nroempenho']                      =   substr($aRSP10['si112_nroempenho'], 0, 22);
        $aCSVRSP10['si112_exercicioempenho']                =   str_pad($aRSP10['si112_exercicioempenho'], 4, "0", STR_PAD_LEFT);
        $aCSVRSP10['si112_dtempenho']                       =   implode("", array_reverse(explode("-", $aRSP10['si112_dtempenho'])));
        $aCSVRSP10['si112_dotorig']                         =   $aRSP10['si112_dotorig'];
        $aCSVRSP10['si112_vloriginal']                      =   number_format($aRSP10['si112_vloriginal'], 2, ",", "");
        $aCSVRSP10['si112_vlsaldoantproce']                 =   number_format($aRSP10['si112_vlsaldoantproce'], 2, ",", "");
        $aCSVRSP10['si112_vlsaldoantnaoproc']               =   number_format($aRSP10['si112_vlsaldoantnaoproc'], 2, ",", "");
        
        $this->sLinha = $aCSVRSP10;
        $this->adicionaLinha();

        for ($iCont2 = 0;$iCont2 < pg_num_rows($rsRSP11); $iCont2++) {        

          $aRSP11  = pg_fetch_array($rsRSP11,$iCont2);
          
          if ($aRSP10['si112_sequencial'] == $aRSP11['si113_reg10']) {

            $aCSVRSP11['si113_tiporegistro']             =    str_pad($aRSP11['si113_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVRSP11['si113_codreduzidorsp']           =    substr($aRSP11['si113_codreduzidorsp'], 0, 15);
            $aCSVRSP11['si113_codfontrecursos']          =    str_pad($aRSP11['si113_codfontrecursos'], 3, "0", STR_PAD_LEFT);
            $aCSVRSP11['si113_vloriginalfonte']          =    number_format($aRSP11['si113_vloriginalfonte'], 2, ",", "");
            $aCSVRSP11['si113_vlsaldoantprocefonte']     =    number_format($aRSP11['si113_vlsaldoantprocefonte'], 2, ",", "");
            $aCSVRSP11['si113_vlsaldoantnaoprocfonte']   =    number_format($aRSP11['si113_vlsaldoantnaoprocfonte'], 2, ",", "");
            
            $this->sLinha = $aCSVRSP11;
            $this->adicionaLinha();
          }

        }

        for ($iCont3 = 0;$iCont3 < pg_num_rows($rsRSP12); $iCont3++) {        

          $aRSP12  = pg_fetch_array($rsRSP12,$iCont3);
          
          if ($aRSP10['si112_sequencial'] == $aRSP12['si114_reg10']) {

            $aCSVRSP12['si114_tiporegistro']             =    str_pad($aRSP12['si114_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVRSP12['si114_codreduzidorsp']           =    substr($aRSP12['si114_codreduzidorsp'], 0, 15);
            $aCSVRSP12['si114_tipodocumento']            =    str_pad($aRSP12['si114_tipodocumento'], 1, "0", STR_PAD_LEFT);
            $aCSVRSP12['si114_nrodocumento']             =    substr($aRSP12['si114_nrodocumento'], 0, 14);

            $this->sLinha = $aCSVRSP12;
            $this->adicionaLinha();
          }

        }

      }

      /**
      *
      * Registros 20, 21, 22
      */
      for ($iCont4 = 0;$iCont4 < pg_num_rows($rsRSP20); $iCont4++) {

        $aRSP20  = pg_fetch_array($rsRSP20,$iCont4);
        
        $aCSVRSP20['si115_tiporegistro']                    =    str_pad($aRSP20['si115_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVRSP20['si115_codreduzidomov']                  =    substr($aRSP20['si115_codreduzidomov'], 0, 15);
        $aCSVRSP20['si115_codorgao']                        =    str_pad($aRSP20['si115_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVRSP20['si115_codunidadesub']                   =    str_pad($aRSP20['si115_codunidadesub'], 5, "0", STR_PAD_LEFT);
        /**
        *Arquivo codunidadesuborig não está no banco de dados
        */
        $aCSVRSP20['si115_codunidadesuborig']               =    str_pad($aRSP20['si115_codunidadesub'], 5, "0", STR_PAD_LEFT);
        $aCSVRSP20['si115_nroempenho']                      =    substr($aRSP20['si115_nroempenho'], 0, 22);
        $aCSVRSP20['si115_exercicioempenho']                =    str_pad($aRSP20['si115_exercicioempenho'], 4, "0", STR_PAD_LEFT);
        $aCSVRSP20['si115_dtempenho']                       =    implode("", array_reverse(explode("-", $aRSP20['si115_dtempenho'])));
        $aCSVRSP20['si115_tiporestospagar']                 =    str_pad($aRSP20['si115_tiporestospagar'], 1, "0", STR_PAD_LEFT);
        $aCSVRSP20['si115_tipomovimento']                   =    str_pad($aRSP20['si115_tipomovimento'], 1, "0", STR_PAD_LEFT);
        $aCSVRSP20['si115_dtmovimentacao']                  =    implode("", array_reverse(explode("-", $aRSP20['si115_dtmovimentacao'])));
        $aCSVRSP20['si115_dotorig']                         =    $aRSP20['si115_dotorig'] == '' ? ' ' : $aRSP20['si115_dotorig'];
        $aCSVRSP20['si115_vlmovimentacao']                  =    number_format($aRSP20['si115_vlmovimentacao'], 2, ",", "");
        $aCSVRSP20['si115_codorgaoencampatribuic']          =    $aRSP20['si115_codorgaoencampatribuic'] == '' ? ' ' : str_pad($aRSP20['si115_codorgaoencampatribuic'], 2, "0", STR_PAD_LEFT);
        $aCSVRSP20['si115_codunidadesubencampatribuic']     =    $aRSP20['si115_codunidadesubencampatribuic'] == '' ? ' ' :  str_pad($aRSP20['si115_codunidadesubencampatribuic'], 8, "0", STR_PAD_LEFT);
        $aCSVRSP20['si115_justificativa']                   =    substr($aRSP20['si115_justificativa'], 0, 500);
        $aCSVRSP20['si115_atocancelamento']                 =    substr($aRSP20['si115_atocancelamento'], 0, 20);
        $aCSVRSP20['si115_dataatocancelamento']             =    implode("", array_reverse(explode("-", $aRSP20['si115_dataatocancelamento'])));
        
        $this->sLinha = $aCSVRSP20;
        $this->adicionaLinha();

        for ($iCont5 = 0;$iCont5 < pg_num_rows($rsRSP21); $iCont5++) {        

          $aRSP21  = pg_fetch_array($rsRSP21,$iCont5);

          if ($aRSP20['si115_sequencial'] == $aRSP21['si116_reg20']) {

            $aCSVRSP21['si116_tiporegistro']             =    str_pad($aRSP21['si116_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVRSP21['si116_codreduzidomov']           =    substr($aRSP21['si116_codreduzidomov'], 0, 15);
            $aCSVRSP21['si116_codfontrecursos']          =    str_pad($aRSP21['si116_codfontrecursos'], 3, "0", STR_PAD_LEFT);
            $aCSVRSP21['si116_vlmovimentacaofonte']      =    number_format($aRSP21['si116_vlmovimentacaofonte'], 2, ",", "");

            $this->sLinha = $aCSVRSP21;
            $this->adicionaLinha();
          }

        }

        for ($iCont6 = 0;$iCont6 < pg_num_rows($rsRSP22); $iCont6++) {        

          $aRSP22  = pg_fetch_array($rsRSP22,$iCont6);
          
          if ($aRSP20['si115_sequencial'] == $aRSP22['si117_reg10']) {

            $aCSVRSP22['si117_tiporegistro']             =    str_pad($aRSP22['si117_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVRSP22['si117_codreduzidomov']           =    substr($aRSP22['si117_codreduzidomov'], 0, 15);
            $aCSVRSP22['si117_tipodocumento']            =    str_pad($aRSP22['si117_tipodocumento'], 1, "0", STR_PAD_LEFT);
            $aCSVRSP22['si117_nrodocumento']             =    substr($aRSP22['si117_codreduzidomov'], 0, 14);
            
            $this->sLinha = $aCSVRSP21;
            $this->adicionaLinha();
          }

        }

      }

      $this->fechaArquivo();

    }

  } 

}
