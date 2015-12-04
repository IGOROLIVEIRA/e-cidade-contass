<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarARC extends GerarAM {

   /**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "ARC";
    $this->abreArquivo();
    
    $sSql = "select * from arc102015 where si28_mes = ". $this->iMes." and si28_instit = ".db_getsession("DB_instit");
    $rsARC10    = db_query($sSql);

    $sSql2 = "select * from arc112015 where si29_mes = ". $this->iMes." and si29_instit = ".db_getsession("DB_instit");
    $rsARC11    = db_query($sSql2);

    $sSql3 = "select * from arc122015 where si30_mes = ". $this->iMes." and si30_instit = ".db_getsession("DB_instit");
    $rsARC12    = db_query($sSql3);

    $sSql4 = "select * from arc202015 where si31_mes = ". $this->iMes." and si31_instit = ".db_getsession("DB_instit");
    $rsARC20    = db_query($sSql4);

    $sSql5 = "select * from arc212015 where si32_mes = ". $this->iMes." and si32_instit = ".db_getsession("DB_instit");
    $rsARC21    = db_query($sSql5);

  if (pg_num_rows($rsARC10) == 0 && pg_num_rows($rsARC20) == 0 ) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10, 11, 12
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsARC10); $iCont++) {

        $aARC10  = pg_fetch_array($rsARC10,$iCont);
        
        $aCSVARC10['si28_tiporegistro']                      =   str_pad($aARC10['si28_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVARC10['si28_codcorrecao']                       =   substr($aARC10['si28_codcorrecao'], 0, 15);
        $aCSVARC10['si28_codorgao']                          =   str_pad($aARC10['si28_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVARC10['si28_ededucaodereceita']                 =   str_pad($aARC10['si28_ededucaodereceita'], 1, "0", STR_PAD_LEFT);
        $aCSVARC10['si28_identificadordeducaorecreduzida']   =   str_pad($aARC10['si28_identificadordeducaorecreduzida'], 2, "0", STR_PAD_LEFT);
        $aCSVARC10['si28_naturezareceitareduzida']           =   str_pad($aARC10['si28_naturezareceitareduzida'], 8, "0", STR_PAD_LEFT);
        $aCSVARC10['si28_especificacaoreduzida']             =   substr($aARC10['si28_especificacaoreduzida'], 0, 100);
        $aCSVARC10['si28_identificadordeducaorecacrescida']  =   str_pad($aARC10['si28_identificadordeducaorecacrescida'], 2, "0", STR_PAD_LEFT);
        $aCSVARC10['si28_naturezareceitaacrescida']          =   str_pad($aARC10['si28_naturezareceitaacrescida'], 8, "0", STR_PAD_LEFT);
        $aCSVARC10['si28_especificacaoacrescida']            =   substr($aARC10['si28_especificacaoacrescida'], 0, 100);
        $aCSVARC10['si28_vlreduzidoacrescido']               =   number_format($aARC10['si28_vlreduzidoacrescido'], 2, ",", "");
        
        $this->sLinha = $aCSVARC10;
        $this->adicionaLinha();

        for ($iCont2 = 0;$iCont2 < pg_num_rows($rsARC11); $iCont2++) {        

          $aARC11  = pg_fetch_array($rsARC11,$iCont2);
          
          if ($aARC10['si28_sequencial'] == $aARC11['si29_reg10']) {

            $aCSVARC11['si29_tiporegistro']        =    str_pad($aARC11['si29_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVARC11['si29_codcorrecao']         =    substr($aARC11['si29_codcorrecao'], 0, 15);
            $aCSVARC11['si29_codfontereduzida']    =    str_pad($aARC11['si29_codfontereduzida'], 2, "0", STR_PAD_LEFT);
            $aCSVARC11['si29_vlreduzidofonte']     =    number_format($aARC11['si29_vlreduzidofonte'], 2, ",", "");

            $this->sLinha = $aCSVARC11;
            $this->adicionaLinha();
          }

        }

        for ($iCont3 = 0;$iCont3 < pg_num_rows($rsARC12); $iCont3++) {        

          $aARC12  = pg_fetch_array($rsARC12,$iCont3);
          
          if ($aARC10['si28_sequencial'] == $aARC12['si30_reg10']) {

            $aCSVARC12['si30_tiporegistro']         =  str_pad($aARC12['si30_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVARC12['si30_codcorrecao']          =  substr($aARC12['si30_codcorrecao'], 0, 15);
            $aCSVARC12['si30_codfonteacrescida']    =  str_pad($aARC12['si30_codfonteacrescida'], 3, "0", STR_PAD_LEFT);
            $aCSVARC11['si30_vlreduzidofonte']      =  number_format($aARC12['si30_vlacrescidofonte'], 2, ",", "");

            $this->sLinha = $aCSVARC12;
            $this->adicionaLinha();
          }

        }

      }

      /**
      *
      * Registros 20, 21
      */
      for ($iCont4 = 0;$iCont4 < pg_num_rows($rsARC20); $iCont4++) {

        $aARC20  = pg_fetch_array($rsARC20,$iCont4);
        
        $aCSVARC20['si31_tiporegistro']             =  str_pad($aARC20['si31_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVARC20['si31_codorgao']                 =  str_pad($aARC20['si31_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVARC20['si31_codestorno']               =  substr($aARC20['si31_codestorno'], 0, 15);
        $aCSVARC20['si31_ededucaodereceita']        =  str_pad($aARC20['si31_ededucaodereceita'], 1, "0", STR_PAD_LEFT);
        $aCSVARC20['si31_identificadordeducao']     =  str_pad($aARC20['si31_identificadordeducao'], 2, "0", STR_PAD_LEFT);
        $aCSVARC20['si31_naturezareceitaestornada'] =  str_pad($aARC20['si31_naturezareceitaestornada'], 8, "0", STR_PAD_LEFT);
        $aCSVARC20['si31_especificacaoestornada']   =  substr($aARC20['si31_especificacaoestornada'], 0, 100);
        $aCSVARC20['si31_vlestornado']              =  number_format($aARC20['si31_vlestornado'], 2, ",", "");

        $this->sLinha = $aCSVARC20;
        $this->adicionaLinha();

        for ($iCont5 = 0;$iCont5 < pg_num_rows($rsARC21); $iCont5++) {        

          $aARC21  = pg_fetch_array($rsARC21,$iCont5);
          
          if ($aARC20['si31_sequencial'] == $aARC21['si32_reg20']) {

            $aCSVARC21['si32_tiporegistro']         =  str_pad($aARC21['si32_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVARC21['si32_codestorno']           =  substr($aARC21['si32_codcorrecao'], 0, 15);
            $aCSVARC21['si32_codfonteestornada']    =  str_pad($aARC21['si32_codfonteestornada'], 3, "0", STR_PAD_LEFT);
            $aCSVARC21['si32_vlestor2nadofonte']    =  number_format($aARC21['si32_vlestornadofonte'], 2, ",", "");            

            $this->sLinha = $aCSVARC21;
            $this->adicionaLinha();
          }

        }

      }

      $this->fechaArquivo();

  } 

}

}