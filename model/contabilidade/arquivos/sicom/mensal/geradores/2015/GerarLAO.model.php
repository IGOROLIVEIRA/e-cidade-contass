<?php

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");


 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarLAO extends GerarAM {

   /**
  * 
  * Mes de refer�ncia
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "LAO";
    $this->abreArquivo();
    
    $sSql = "select * from lao102015 where si34_mes = ". $this->iMes." and si34_instit = ".db_getsession("DB_instit");
    $rsLAO10    = db_query($sSql);

    $sSql2 = "select * from lao112015 where si35_mes = ". $this->iMes." and si35_instit = ".db_getsession("DB_instit");
    $rsLAO11    = db_query($sSql2);

    $sSql3 = "select * from lao202015 where si36_mes = ". $this->iMes." and si36_instit = ".db_getsession("DB_instit");
    $rsLAO20    = db_query($sSql3);

    $sSql4 = "select * from lao212015 where si37_mes = ". $this->iMes." and si37_instit = ".db_getsession("DB_instit");
    $rsLAO21    = db_query($sSql4);

  if (pg_num_rows($rsLAO10) == 0 && pg_num_rows($rsLAO20) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10, 11, 12
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsLAO10); $iCont++) {

        $aLAO10  = pg_fetch_array($rsLAO10,$iCont);
        
        $aCSVLAO10['si34_tiporegistro']               =   str_pad($aLAO10['si34_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVLAO10['si34_codorgao']                   =   str_pad($aLAO10['si34_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVLAO10['si34_nroleialteracao']            =   substr($aLAO10['si34_nroleialteracao'], 0, 6  );
        $aCSVLAO10['si34_dataleialteracao']           =   implode("", array_reverse(explode("-", $aLAO10['si34_dataleialteracao'])));
        
        $this->sLinha = $aCSVLAO10;
        $this->adicionaLinha();

        for ($iCont2 = 0;$iCont2 < pg_num_rows($rsLAO11); $iCont2++) {        

          $aLAO11  = pg_fetch_array($rsLAO11,$iCont2);
          
          if ($aLAO10['si34_sequencial'] == $aLAO11['si35_reg10']) {

            $aCSVLAO11['si35_tiporegistro']             =    str_pad($aLAO11['si35_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVLAO11['si35_nroleialteracao']          =    substr($aLAO11['si35_nroleialteracao'], 0, 6);
            $aCSVLAO11['si35_tipoleialteracao']         =    str_pad($aLAO11['si35_tipoleialteracao'], 1, "0", STR_PAD_LEFT);
            $aCSVLAO11['si35_artigoleialteracao']       =    substr($aLAO11['si35_artigoleialteracao'], 0, 6);
            $aCSVLAO11['si35_descricaoartigo']          =    substr($aLAO11['si35_descricaoartigo'], 0, 512);
            $aCSVLAO11['si35_vlautorizadoalteracao']    =    number_format($aLAO11['si35_vlautorizadoalteracao'], 2, ",", "");
            
            $this->sLinha = $aCSVLAO11;
            $this->adicionaLinha();
          }

        }

      }

      /**
      *
      * Registros 20, 21
      */
      for ($iCont3 = 0;$iCont3 < pg_num_rows($rsLAO20); $iCont3++) {

        $aLAO20  = pg_fetch_array($rsLAO20,$iCont3);
        
        $aCSVLAO20['si36_tiporegistro']             =  str_pad($aLAO20['si36_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVLAO20['si36_codorgao']                 =  str_pad($aLAO20['si36_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVLAO20['si36_nroleialterorcam']         =  substr($aLAO20['si36_nroleialterorcam'], 0, 6);
        $aCSVLAO20['si36_dataleialterorcam']        =  implode("", array_reverse(explode("-", $aLAO10['si36_dataleialterorcam'])));

        $this->sLinha = $aCSVLAO20;
        $this->adicionaLinha();

        for ($iCont4 = 0;$iCont4 < pg_num_rows($rsLAO21); $iCont4++) {        

          $aLAO21  = pg_fetch_array($rsLAO21,$iCont4);
          
          if ($aLAO20['si36_sequencial'] == $aLAO21['si37_reg20']) {

            $aCSVLAO21['si37_tiporegistro']                =  str_pad($aLAO21['si37_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVLAO21['si37_nroleialterorcam']            =  substr($aLAO21['si37_nroleialterorcam'], 0, 6);
            $aCSVLAO21['si37_tipoautorizacao']             =  str_pad($aLAO21['si37_tipoautorizacao'], 1, "0", STR_PAD_LEFT);
            $aCSVLAO21['si37_artigoleialterorcamento']     =  substr($aLAO21['si37_artigoleialterorcamento'], 0, 6);
            $aCSVLAO21['si37_descricaoartigo']             =  substr($aLAO21['si37_descricaoartigo'], 0, 512);
            $aCSVLAO21['si37_novopercentual']              =  number_format($aLAO21['si37_novopercentual'], 2, ",", "");

            $this->sLinha = $aCSVLAO21;
            $this->adicionaLinha();
          }

        }

      }

      $this->fechaArquivo();

  } 

}

}