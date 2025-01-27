<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarPARPPS extends GerarAM {

   /**
  * 
  * Mes de referÍncia
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "PARPPS";
    $this->abreArquivo();
    
    
    $sSql = "select * from parpps102014 where si156_mes = ". $this->iMes ." and si156_instit = ". db_getsession("DB_instit");
    $rsPARPPS10    = db_query($sSql);

    $sSql2 = "select * from parpps202014 where si155_mes = ". $this->iMes ." and si155_instit = ". db_getsession("DB_instit");
    $rsPARPPS20    = db_query($sSql2);


  if (pg_num_rows($rsPARPPS10) == 0 && pg_num_rows($rsPARPPS20) == 0 ) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsPARPPS10); $iCont++) {

        $aPARPPS10  = pg_fetch_array($rsPARPPS10,$iCont);
        
        $aCSVPARPPS10['si156_tiporegistro']                         =   str_pad($aPARPPS10['si156_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVPARPPS10['si156_codorgao']                             =   str_pad($aPARPPS10['si156_codorgao'], 2, "0", STR_PAD_LEFT);       
        $aCSVPARPPS10['si156_vlsaldofinanceiroexercicioanterior']   =   number_format($aPARPPS10['si156_vlsaldofinanceiroexercicioanterior'], 2, ",", "");
        
        $this->sLinha = $aCSVPARPPS10;
        $this->adicionaLinha();

      }

      for ($iCont2 = 0;$iCont2 < pg_num_rows($rsPARPPS20); $iCont2++) {

        $aPARPPS20  = pg_fetch_array($rsPARPPS20,$iCont2);
        
        $aCSVPARPPS20['si155_tiporegistro']                =   str_pad($aPARPPS20['si155_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVPARPPS20['si155_codorgao']                    =   str_pad($aPARPPS20['si155_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVPARPPS20['si155_exercicio']                   =   str_pad($aPARPPS20['si155_codorgao'], 4, "0", STR_PAD_LEFT);
        $aCSVPARPPS20['si155_vlreceitaprevidenciaria']     =   number_format($aPARPPS10['si155_vlreceitaprevidenciaria'], 2, ",", "");
        $aCSVPARPPS20['si155_vldespesaprevidenciaria']     =   number_format($aPARPPS10['si155_vldespesaprevidenciaria'], 2, ",", "");
        
        $this->sLinha = $aCSVPARPPS20;
        $this->adicionaLinha();

      }

      $this->fechaArquivo();

    }

  } 

}