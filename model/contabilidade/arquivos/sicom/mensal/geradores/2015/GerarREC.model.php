<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarREC extends GerarAM {

   /**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "REC";
    $this->abreArquivo();
    
    $sSql = "select * from rec102015 where si25_mes = ". $this->iMes." and si25_instit = ".db_getsession("DB_instit");
    $rsREC10    = db_query($sSql);

    $sSql2 = "select * from rec112015 where si26_mes = ". $this->iMes." and si26_instit = ".db_getsession("DB_instit");
    $rsREC11    = db_query($sSql2);

    if (pg_num_rows($rsREC10) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {

      for ($iCont = 0;$iCont < pg_num_rows($rsREC10); $iCont++) {

        $aREC10  = pg_fetch_array($rsREC10,$iCont);
           
        $aCSVREC10['si25_tiporegistro']            =   str_pad($aREC10['si25_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVREC10['si25_codreceita']              =   substr($aREC10['si25_codreceita'], 0, 15);
        $aCSVREC10['si25_codorgao']                =   str_pad($aREC10['si25_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVREC10['si25_ededucaodereceita']       =   str_pad($aREC10['si25_ededucaodereceita'], 1, "0", STR_PAD_LEFT);
        $aCSVREC10['si25_identificadordeducao']    =   $aREC10['si25_identificadordeducao'] == '' || $aREC10['si25_identificadordeducao'] == '0' ? ' ' : str_pad($aREC10['si25_identificadordeducao'], 2, "0", STR_PAD_LEFT);
        $aCSVREC10['si25_naturezareceita']         =   str_pad($aREC10['si25_naturezareceita'], 8, "0", STR_PAD_LEFT);
        $aCSVREC10['si25_especificacao']           =   substr($aREC10['si25_especificacao'], 0, 100);
        $aCSVREC10['si25_vlarrecadado']            =   number_format(abs($aREC10['si25_vlarrecadado']), 2, ",", "");

        $this->sLinha = $aCSVREC10;
        $this->adicionaLinha();

        for ($iCont2 = 0;$iCont2 < pg_num_rows($rsREC11); $iCont2++) {        

          $aREC11  = pg_fetch_array($rsREC11,$iCont2);
          if ($aREC10['si25_sequencial'] == $aREC11['si26_reg10']) {
              
            $aCSVREC11['si26_tiporegistro']          =  str_pad($aREC11['si26_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVREC11['si26_codreceita']            =  substr($aREC11['si26_codreceita'], 0, 15);
            $aCSVREC11['si26_codfontrecursos']       =  str_pad($aREC11['si26_codfontrecursos'], 3, "0", STR_PAD_LEFT);
            $aCSVREC11['si26_vlarrecadadofonte']     =  number_format(abs($aREC11['si26_vlarrecadadofonte']), 2, ",", "");
            

            $this->sLinha = $aCSVREC11;

            $this->adicionaLinha();
          }

    }
  }

  $this->fechaArquivo();

  } 

  }

}