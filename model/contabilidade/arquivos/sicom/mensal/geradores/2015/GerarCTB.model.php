<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarCTB extends GerarAM {

   /**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "CTB";
    $this->abreArquivo();
    
    $sSql = "select * from ctb102015 where si95_mes = ". $this->iMes ." and si95_instit = ". db_getsession("DB_instit");
    $rsCTB10    = db_query($sSql);

    $sSql2 = "select * from ctb202015 where si96_mes = ". $this->iMes ." and si96_instit = ". db_getsession("DB_instit");
    $rsCTB20    = db_query($sSql2);

    $sSql3 = "select * from ctb212015 where si97_mes = ". $this->iMes ." and si97_instit = ". db_getsession("DB_instit");
    $rsCTB21    = db_query($sSql3);

    $sSql4 = "select * from ctb222015 where si98_mes = ". $this->iMes ." and si98_instit = ". db_getsession("DB_instit");
    $rsCTB22    = db_query($sSql4);

    $sSql5 = "select * from ctb302015 where si99_mes = ". $this->iMes ." and si99_instit = ". db_getsession("DB_instit");
    $rsCTB30    = db_query($sSql5);

    $sSql6 = "select * from ctb312015 where si100_mes = ". $this->iMes ." and si100_instit = ". db_getsession("DB_instit");
    $rsCTB31    = db_query($sSql6);

    $sSql7 = "select * from ctb402015 where si101_mes = ". $this->iMes ." and si101_instit = ". db_getsession("DB_instit");
    $rsCTB40    = db_query($sSql7);

    $sSql8 = "select * from ctb502015 where si102_mes = ". $this->iMes ." and si102_instit = ". db_getsession("DB_instit");
    $rsCTB50    = db_query($sSql8);

  if (pg_num_rows($rsCTB10) == 0 && pg_num_rows($rsCTB20) == 0 && pg_num_rows($rsCTB30) == 0 && pg_num_rows($rsCTB40) == 0 && pg_num_rows($rsCTB50) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsCTB10); $iCont++) {

        $aCTB10  = pg_fetch_array($rsCTB10,$iCont);
        
        $aCSVCTB10['si95_tiporegistro']                       =   str_pad($aCTB10['si95_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVCTB10['si95_codctb']                             =   substr($aCTB10['si95_codctb'], 0, 20);
        $aCSVCTB10['si95_codorgao']                           =   str_pad($aCTB10['si95_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVCTB10['si95_banco']                              =   str_pad($aCTB10['si95_banco'], 2, "0", STR_PAD_LEFT);
        $aCSVCTB10['si95_agencia']                            =   substr($aCTB10['si95_agencia'], 0, 6);
        $aCSVCTB10['si95_digitoverificadoragencia']           =   substr($aCTB10['si95_digitoverificadoragencia'], 0, 2);
        $aCSVCTB10['si95_contabancaria']                      =   substr($aCTB10['si95_contabancaria'], 0, 12);
        $aCSVCTB10['si95_digitoverificadorcontabancaria']     =   substr($aCTB10['si95_digitoverificadorcontabancaria'], 0, 2);
        $aCSVCTB10['si95_tipoconta']                          =   str_pad($aCTB10['si95_tipoconta'], 2, "0", STR_PAD_LEFT);
        $aCSVCTB10['si95_tipoaplicacao']                      =   str_pad($aCTB10['si95_tipoaplicacao'], 2, "0", STR_PAD_LEFT) == 0 ? " " : str_pad($aCTB10['si95_tipoaplicacao'], 2, "0", STR_PAD_LEFT);
        $aCSVCTB10['si95_nroseqaplicacao']                    =   substr($aCTB10['si95_nroseqaplicacao'], 0, 2) == 0 ? " " : substr($aCTB10['si95_nroseqaplicacao'], 0, 2);
        $aCSVCTB10['si95_desccontabancaria']                  =   substr($aCTB10['si95_desccontabancaria'], 0, 40) == "" ? " " : substr($aCTB10['si95_desccontabancaria'], 0, 40);
        $aCSVCTB10['si95_contaconvenio']                      =   str_pad($aCTB10['si95_contaconvenio'], 1, "0", STR_PAD_LEFT)  == 0 ? " " : str_pad($aCTB10['si95_contaconvenio'], 1, "0", STR_PAD_LEFT)  ;
        $aCSVCTB10['si95_nroconvenio']                        =   $aCTB10['si95_nroconvenio'] == 0 ? " " : $aCTB10['si95_nroconvenio'];
        $aCSVCTB10['si95_dataassinaturaconvenio']             =   implode("", array_reverse(explode("-", $aCTB10['si95_dataassinaturaconvenio']))) ==  null ? " " 
        															: implode("", array_reverse(explode("-", $aCTB10['si95_dataassinaturaconvenio'])));

        $this->sLinha = $aCSVCTB10;
        $this->adicionaLinha();

      }

      /**
      *
      * Registros 20
      */
      for ($iCont2 = 0;$iCont2 < pg_num_rows($rsCTB20); $iCont2++) {

        $aCTB20  = pg_fetch_array($rsCTB20,$iCont2);
        
        $aCSVCTB20['si96_tiporegistro']                  =  str_pad($aCTB20['si96_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVCTB20['si96_codorgao']                      =  str_pad($aCTB20['si96_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVCTB20['si96_codctb']                        =  substr($aCTB20['si96_codctb'], 0, 21);
        $aCSVCTB20['si96_codfontrecursos']               =  str_pad($aCTB20['si96_codfontrecursos'], 3, "0", STR_PAD_LEFT);
        $aCSVCTB20['si96_vlsaldoinicialfonte']           =  number_format($aCTB20['si96_vlsaldoinicialfonte'], 2, ",", "");
        $aCSVCTB20['si96_vlsaldofinalfonte']             =  number_format($aCTB20['si96_vlsaldofinalfonte'], 2, ",", "");

        $this->sLinha = $aCSVCTB20;
        $this->adicionaLinha();

        /**
      *
      * Registros 21 , 22
      */
        for ($iCont3 = 0;$iCont3 < pg_num_rows($rsCTB21); $iCont3++) {

          $aCTB21  = pg_fetch_array($rsCTB21,$iCont3);

          if ($aCTB20['si96_sequencial'] == $aCTB21['si97_reg20']) {
        
            $aCSVCTB21['si97_tiporegistro']                  =  str_pad($aCTB21['si97_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVCTB21['si97_codctb']                        =  substr($aCTB21['si97_codctb'], 0, 21);
            $aCSVCTB21['si97_codfontrecursos']               =  str_pad($aCTB21['si97_codfontrecursos'], 3, "0", STR_PAD_LEFT);
            $aCSVCTB21['si97_codreduzidomov']                =  substr($aCTB21['si97_codreduzidomov'], 0, 15);
            $aCSVCTB21['si97_tipomovimentacao']              =  str_pad($aCTB21['si97_tipomovimentacao'], 1, "0", STR_PAD_LEFT);
            $aCSVCTB21['si97_tipoentrsaida']                 =  str_pad($aCTB21['si97_tipoentrsaida'], 2, "0", STR_PAD_LEFT);
            $aCSVCTB21['si97_valorentrsaida']                =  number_format($aCTB21['si97_valorentrsaida'], 2, ",", "");
            $aCSVCTB21['si97_codctbtransf']                  =  $aCTB21['si97_codctbtransf'] != 0 ? $aCTB21['si97_codctbtransf'] : ' ' ;
            $aCSVCTB21['si97_codfontectbtransf']             =  $aCTB21['si97_codfontectbtransf']  != 0 ?$aCTB21['si97_codfontectbtransf'] : ' ' ;
        
            $this->sLinha = $aCSVCTB21;
            $this->adicionaLinha();

	        for ($iCont4 = 0;$iCont4 < pg_num_rows($rsCTB22); $iCont4++) {        
	
	          $aCTB22  = pg_fetch_array($rsCTB22,$iCont4);
	          
	          if ($aCTB21['si97_sequencial'] == $aCTB22['si98_reg21']) {
	
	            $aCSVCTB22['si98_tiporegistro']          =   str_pad($aCTB22['si98_tiporegistro'], 2, "0", STR_PAD_LEFT);
	            $aCSVCTB22['si98_codreduzidomov']        =   substr($aCTB22['si98_codreduzidomov'], 0, 15);
	            $aCSVCTB22['si98_ededucaodereceita']     =   str_pad($aCTB22['si98_ededucaodereceita'], 1, "0", STR_PAD_LEFT);
	            $aCSVCTB22['si98_identificadordeducao']  =   $aCTB22['si98_identificadordeducao'] == '0' ? ' ' : str_pad($aCTB22['si98_identificadordeducao'], 2, "0", STR_PAD_LEFT);
	            $aCSVCTB22['si98_naturezareceita']       =   str_pad($aCTB22['si98_naturezareceita'], 8, "0", STR_PAD_LEFT);
	            $aCSVCTB22['si98_vlrreceitacont']        =   number_format($aCTB22['si98_vlrreceitacont'], 2, ",", "");
	
	            $this->sLinha = $aCSVCTB22;
	            $this->adicionaLinha();
	
	          }
	
	        }
          }
        }

      }

       /**
      *
      * Registros 30 , 31
      */
      for ($iCont5 = 0;$iCont5 < pg_num_rows($rsCTB30); $iCont5++) {

        $aCTB30  = pg_fetch_array($rsCTB30,$iCont5);
        
        $aCSVCTB30['si99_tiporegistro']                  =  str_pad($aCTB30['si99_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVCTB30['si99_codorgao']                      =  str_pad($aCTB30['si99_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVCTB30['si99_codagentearrecadador']          =  substr($aCTB30['si99_codagentearrecadador'], 0, 15);
        $aCSVCTB30['si99_dscagentearrecadador']          =  substr($aCTB30['si99_dscagentearrecadador'], 0, 40);
        $aCSVCTB30['si99_vlsaldoinicial']                =  number_format($aCTB30['si99_vlsaldoinicial'], 2, ",", "");
        $aCSVCTB30['si99_vlsaldofinal']                  =  number_format($aCTB30['si99_vlsaldofinal'], 2, ",", "");
        
        $this->sLinha = $aCSVCTB30;
        $this->adicionaLinha();

        for ($iCont6 = 0;$iCont6 < pg_num_rows($rsCTB31); $iCont6++) {        

          $aCTB31  = pg_fetch_array($rsCTB31,$iCont6);
          
          if ($aCTB30['si99_sequencial'] == $aCTB31['si100_reg30']) {

            $aCSVCTB31['si100_tiporegistro']              =   str_pad($aCTB31['si100_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVCTB31['si100_codagentearrecadador']      =   substr($aCTB31['si100_codagentearrecadador'], 0, 15);
            $aCSVCTB31['si100_codfontrecursos']           =   str_pad($aCTB31['si100_codfontrecursos'], 3, "0", STR_PAD_LEFT);
            $aCSVCTB31['si100_vlsaldoinicialagfonte']     =   number_format($aCTB31['si100_vlsaldoinicialagfonte'], 2, ",", "");
            $aCSVCTB31['si100_vlentradafonte']            =   number_format($aCTB31['si100_vlentradafonte'], 2, ",", "");
            $aCSVCTB31['si100_vlsaidafonte']              =   number_format($aCTB31['si100_vlsaidafonte'], 2, ",", "");
            $aCSVCTB31['si100_vlsaldofinalagfonte']       =   number_format($aCTB31['si100_vlsaldofinalagfonte'], 2, ",", "");

            $this->sLinha = $aCSVCTB31;
            $this->adicionaLinha();

          }

        }

      }

       /**
      *
      * Registros 40      */
      for ($iCont7 = 0;$iCont7 < pg_num_rows($rsCTB40); $iCont7++) {

        $aCTB40  = pg_fetch_array($rsCTB40,$iCont7);
        
        $aCSVCTB40['si101_tiporegistro']                =  str_pad($aCTB40['si101_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVCTB40['si101_codorgao']                    =  str_pad($aCTB40['si101_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVCTB40['si101_codctb']                      =  substr($aCTB40['si101_codctb'], 0, 20);
        $aCSVCTB40['si101_desccontabancaria']           =  substr($aCTB40['si101_desccontabancaria'], 0, 50);

        $this->sLinha = $aCSVCTB40;
        $this->adicionaLinha();

      }

       /**
      *
      * Registros 50      */
      for ($iCont8 = 0;$iCont8 < pg_num_rows($rsCTB50); $iCont8++) {

        $aCTB50  = pg_fetch_array($rsCTB50,$iCont8);
        
        $aCSVCTB50['si102_tiporegistro']  = str_pad($aCTB50['si102_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVCTB50['si102_codorgao']      = str_pad($aCTB50['si102_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVCTB50['si102_codctb']        = substr($aCTB50['si102_codctb'], 0, 20);
        $aCSVCTB50['si102_situacaoconta'] = $aCTB50['si102_situacaoconta'];
        $aCSVCTB50['si102_datasituacao']  = implode("", array_reverse(explode("-", $aCTB50['si102_datasituacao'])));

        $this->sLinha = $aCSVCTB50;
        $this->adicionaLinha();

      }

      $this->fechaArquivo();

  }
  }
}