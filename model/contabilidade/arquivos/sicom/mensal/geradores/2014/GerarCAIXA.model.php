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
  * Mes de referÍncia
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "CAIXA";
    $this->abreArquivo();
    
    $sSql = "select * from caixa102014 where si103_mes = ". $this->iMes." and si103_instit = ".db_getsession("DB_instit");
    $rsCAIXA10    = db_query($sSql);

    $sSql2 = "select * from caixa112014 where si104_mes = ". $this->iMes." and si104_instit = ".db_getsession("DB_instit");
    $rsCAIXA11    = db_query($sSql2);

    $sSql3 = "select * from caixa122014 where si105_mes = ". $this->iMes." and si105_instit = ".db_getsession("DB_instit");
    $rsCAIXA12    = db_query($sSql3);

  if (pg_num_rows($rsCAIXA10) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10, 11, 12
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
          
          if ($aCAIXA10['si103_sequencial'] == $aCAIXA11['si104_reg10']) {

            $aCSVCAIXA11['si104_tiporegistro']             =    str_pad($aCAIXA11['si104_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVCAIXA11['si104_codreduzido']              =    substr($aCAIXA11['si104_codreduzido'], 0, 15);
            $aCSVCAIXA11['si104_tipomovimentacao']         =    str_pad($aCAIXA11['si104_tipomovimentacao'], 1, "0", STR_PAD_LEFT);
            $aCSVCAIXA11['si104_tipoentrsaida']            =    str_pad($aCAIXA11['si104_tipoentrsaida'], 2, "0", STR_PAD_LEFT);
            $aCSVCAIXA11['si104_descrmovimentacao']        =    ($aCAIXA11['si104_descrmovimentacao'] == 0)? ' ' : substr($aCAIXA11['si104_descrmovimentacao'], 0, 50);
            $aCSVCAIXA11['si104_valorentrsaida']           =    number_format($aCAIXA11['si104_valorentrsaida'], 2, ",", "");
            $aCSVCAIXA11['si104_codctbtransf']             =    ($aCAIXA11['si104_codctbtransf'] == 0)? ' ':$aCAIXA11['si104_codctbtransf'];
            $aCSVCAIXA11['si104_codfontectbtransf']        =    ($aCAIXA11['si104_codfontectbtransf']==0)?' ':$aCAIXA11['si104_codfontectbtransf'];
          
            $this->sLinha = $aCSVCAIXA11;
            $this->adicionaLinha();
          }

       

	        for ($iCont3 = 0;$iCont3 < pg_num_rows($rsCAIXA12); $iCont3++) {        
	
	          $aCAIXA12  = pg_fetch_array($rsCAIXA12,$iCont3);
	          
	          if ($aCAIXA11['si104_codreduzido'] == $aCAIXA12['si105_codreduzido']) {
	
	            $aCSVCAIXA12['si105_tiporegistro']           = str_pad($aCAIXA12['si105_tiporegistro'], 2, "0", STR_PAD_LEFT);
	            $aCSVCAIXA12['si105_codreduzido']            = substr($aCAIXA12['si105_codreduzido'], 0, 15);
	            $aCSVCAIXA12['si105_ededucaodereceita']      = str_pad($aCAIXA12['si105_ededucaodereceita'], 1, "0", STR_PAD_LEFT);
	            $aCSVCAIXA12['si105_identificadordeducao']   = $aCAIXA12['si105_identificadordeducao'] == '0' ? ' ' : str_pad($aCAIXA12['si105_identificadordeducao'], 2, "0", STR_PAD_LEFT);
	            $aCSVCAIXA12['si105_naturezareceita']        = str_pad($aCAIXA12['si105_naturezareceita'], 8, "0", STR_PAD_LEFT);
	            $aCSVCAIXA12['si105_vlrreceitacont']         = number_format($aCAIXA12['si105_vlrreceitacont'], 2, ",", "");
	            
	            $this->sLinha = $aCSVCAIXA12;
	            $this->adicionaLinha();
	          }
	
	        }
	        
         }

      }

      $this->fechaArquivo();

  } 
  }
}