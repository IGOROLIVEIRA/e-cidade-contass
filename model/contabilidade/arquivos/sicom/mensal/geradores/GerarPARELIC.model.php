<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarPARELIC extends GerarAM {

/**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "PARELIC";
    $this->abreArquivo();
    
    $sSql          = "select * from parelic102014 where si66_mes = ". $this->iMes." and si66_instit=".db_getsession("DB_instit");
    $rsPARELIC10    = db_query($sSql);

    if (pg_num_rows($rsPARELIC10) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();
      
    } else {

      for ($iCont = 0;$iCont < pg_num_rows($rsPARELIC10); $iCont++) {

        $aPARELIC10  = pg_fetch_array($rsPARELIC10,$iCont);

        $aCSVPARELIC10['si66_tiporegistro']             =   str_pad($aPARELIC10['si66_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVPARELIC10['si66_codorgao']                 =   str_pad($aPARELIC10['si66_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVPARELIC10['si66_codunidadesub']            =   str_pad($aPARELIC10['si66_codunidadesub'], 5, "0", STR_PAD_LEFT);
        $aCSVPARELIC10['si66_exerciciolicitacao']       =   str_pad($aPARELIC10['si66_exerciciolicitacao'], 4, "0", STR_PAD_LEFT);
        $aCSVPARELIC10['si66_nroprocessolicitatorio']   =   substr($aPARELIC10['si66_nroprocessolicitatorio'], 0, 12);
        $aCSVPARELIC10['si66_dataparecer']              =   implode("", array_reverse(explode("-", $aPARELIC10['si66_dataparecer'])));
        $aCSVPARELIC10['si66_tipoparecer']              =   str_pad($aPARELIC10['si66_tipoparecer'], 1, "0", STR_PAD_LEFT);
        $aCSVPARELIC10['si66_nrocpf']                   =   str_pad($aPARELIC10['si66_nrocpf'], 11, "0", STR_PAD_LEFT);

        $this->sLinha = $aCSVPARELIC10;
        $this->adicionaLinha();

    }
              
  }
    $this->fechaArquivo();
  }

} 