<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarCAIXA extends GerarAM {

   /**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "CAIXA";
    $this->abreArquivo();
    
    $sSql = "select * from caixa102015 where si103_mes = ". $this->iMes." and si103_instit = ".db_getsession("DB_instit");
    $rsCAIXA10    = db_query($sSql);

    $sSql2 = "select * from caixa112015 where si166_mes = ". $this->iMes." and si166_instit = ".db_getsession("DB_instit");
    $rsCAIXA11    = db_query($sSql2);

    $sSql3 = "select * from caixa122015 where si104_mes = ". $this->iMes." and si104_instit = ".db_getsession("DB_instit");
    $rsCAIXA12    = db_query($sSql3);

    $sSql4 = "select * from caixa132015 where si105_mes = ". $this->iMes." and si105_instit = ".db_getsession("DB_instit");
    $rsCAIXA13    = db_query($sSql4);

  if (pg_num_rows($rsCAIXA10) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10, 11, 12, 13
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsCAIXA10); $iCont++) {

        $aCAIXA10  = pg_fetch_array($rsCAIXA10,$iCont);
        
        $aCSVCAIXA10['si103_tiporegistro']               =   str_pad($aCAIXA10['si103_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVCAIXA10['si103_codorgao']                   =   str_pad($aCAIXA10['si103_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVCAIXA10['si103_vlsaldoinicial']             =   number_format($aCAIXA10['si103_vlsaldoinicial'], 2, ",", "");
        $aCSVCAIXA10['si103_vlsaldofinal']               =   number_format($aCAIXA10['si103_vlsaldofinal'], 2, ",", "");
        
        $this->sLinha = $aCSVCAIXA10;
        $this->adicionaLinha();

        for ($iCont2 = 0;$iCont2 < pg_num_rows($rsCAIXA11); $iCont2++) {        

          $aCAIXA11  = pg_fetch_array($rsCAIXA11,$iCont2);
          
          if ($aCAIXA10['si103_sequencial'] == $aCAIXA11['si166_reg10']) {

            $aCSVCAIXA11['si166_tiporegistro']             =    str_pad($aCAIXA11['si166_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVCAIXA11['si166_codfontecaixa']            =    str_pad($aCAIXA11['si166_codfontecaixa'], 3, "0", STR_PAD_LEFT);
            $aCSVCAIXA11['si166_vlsaldoinicialfonte']      =    number_format($aCAIXA11['si166_vlsaldoinicialfonte'], 2, ",", "");
            $aCSVCAIXA11['si166_vlsaldofinalfonte']        =    number_format($aCAIXA11['si166_vlsaldofinalfonte'], 2, ",", "");
        
            $this->sLinha = $aCSVCAIXA11;
            $this->adicionaLinha();
          }

          for ($iCont3 = 0;$iCont3 < pg_num_rows($rsCAIXA12); $iCont3++) {        

            $aCAIXA12  = pg_fetch_array($rsCAIXA12,$iCont3);
            
            if ($aCAIXA10['si103_sequencial'] == $aCAIXA12['si104_reg10']) {

              $aCSVCAIXA12['si104_tiporegistro']             =    str_pad($aCAIXA12['si104_tiporegistro'], 2, "0", STR_PAD_LEFT);
              $aCSVCAIXA12['si104_codreduzido']              =    substr($aCAIXA12['si104_codreduzido'], 0, 15);
              $aCSVCAIXA12['si104_codfontecaixa']            =    substr($aCAIXA12['si104_codfontecaixa'], 0, 3);
              $aCSVCAIXA12['si104_tipomovimentacao']         =    str_pad($aCAIXA12['si104_tipomovimentacao'], 1, "0", STR_PAD_LEFT);
              $aCSVCAIXA12['si104_tipoentrsaida']            =    str_pad($aCAIXA12['si104_tipoentrsaida'], 2, "0", STR_PAD_LEFT);
              $aCSVCAIXA12['si104_descrmovimentacao']        =    ($aCAIXA12['si104_descrmovimentacao'] == 0)? ' ' : substr($aCAIXA12['si166_descrmovimentacao'], 0, 50);
              $aCSVCAIXA12['si104_valorentrsaida']           =    number_format($aCAIXA12['si104_valorentrsaida'], 2, ",", "");
              $aCSVCAIXA12['si104_codctbtransf']             =    ($aCAIXA12['si104_codctbtransf'] == 0)? ' ':$aCAIXA12['si104_codctbtransf'];
              $aCSVCAIXA12['si104_codfontectbtransf']        =    ($aCAIXA12['si104_codfontectbtransf']==0)?' ':$aCAIXA12['si104_codfontectbtransf'];
            
              $this->sLinha = $aCSVCAIXA12;
              $this->adicionaLinha();
            }

       
  	        for ($iCont4 = 0;$iCont4 < pg_num_rows($rsCAIXA13); $iCont4++) {
  	
  	          $aCAIXA13  = pg_fetch_array($rsCAIXA13,$iCont4);
  	          
  	          if ($aCAIXA12['si104_codreduzido'] == $aCAIXA13['si105_codreduzido']) {
  	
  	            $aCSVCAIXA13['si105_tiporegistro']           = str_pad($aCAIXA13['si105_tiporegistro'], 2, "0", STR_PAD_LEFT);
  	            $aCSVCAIXA13['si105_codreduzido']            = substr($aCAIXA13['si105_codreduzido'], 0, 15);
  	            $aCSVCAIXA13['si105_ededucaodereceita']      = str_pad($aCAIXA13['si105_ededucaodereceita'], 1, "0", STR_PAD_LEFT);
  	            $aCSVCAIXA13['si105_identificadordeducao']   = $aCAIXA13['si105_identificadordeducao'] == '0' ? ' ' : str_pad($aCAIXA13['si105_identificadordeducao'], 2, "0", STR_PAD_LEFT);
  	            $aCSVCAIXA13['si105_naturezareceita']        = str_pad($aCAIXA13['si105_naturezareceita'], 8, "0", STR_PAD_LEFT);
  	            $aCSVCAIXA13['si105_vlrreceitacont']         = number_format($aCAIXA13['si105_vlrreceitacont'], 2, ",", "");
  	            
  	            $this->sLinha = $aCSVCAIXA13;
  	            $this->adicionaLinha();
  	          }
	
	          }
	        
          }

        } 

      }

      $this->fechaArquivo();

  } 
  }
}