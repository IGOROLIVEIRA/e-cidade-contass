<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");


 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarEXT extends GerarAM {

   /**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "EXT";
    $this->abreArquivo();
    
    $sSql = "select * from ext102014 where si124_mes = ". $this->iMes . " and  si124_instit = ".db_getsession("DB_instit");
    $rsEXT10    = db_query($sSql);

    $sSql = "select * from ext202014 where si165_mes = ". $this->iMes . " and  si165_instit = ".db_getsession("DB_instit");
    $rsEXT20    = db_query($sSql);
    

    $sSql2 = "select * from ext212014 where si125_mes = ". $this->iMes . " and  si125_instit = ".db_getsession("DB_instit");
    $rsEXT21    = db_query($sSql2);

    $sSql3 = "select * from ext222014 where si126_mes = ". $this->iMes . " and  si126_instit = ".db_getsession("DB_instit");
    $rsEXT22    = db_query($sSql3);

    $sSql4 = "select * from ext232014 where si127_mes = ". $this->iMes . " and  si127_instit = ".db_getsession("DB_instit");
    $rsEXT23    = db_query($sSql4);

    $sSql5 = "select * from ext242014 where si128_mes = ". $this->iMes . " and  si128_instit = ".db_getsession("DB_instit");
    $rsEXT24    = db_query($sSql5);


  if (pg_num_rows($rsEXT10) == 0 && pg_num_rows($rsEXT20) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsEXT10); $iCont++) {

        $aEXT10  = pg_fetch_array($rsEXT10,$iCont);
        
        $aCSVEXT10['si124_tiporegistro']        =   str_pad($aEXT10['si124_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVEXT10['si124_codext']              =   substr($aEXT10['si124_codext'], 0, 15);
        $aCSVEXT10['si124_codorgao']            =   str_pad($aEXT10['si124_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVEXT10['si124_codunidadesub']       =   str_pad($aEXT10['si124_codunidadesub'], 5, "0", STR_PAD_LEFT);
        $aCSVEXT10['si124_tipolancamento']      =   str_pad($aEXT10['si124_tipolancamento'], 2, "0", STR_PAD_LEFT);
        $aCSVEXT10['si124_subtipo']             =   str_pad($aEXT10['si124_subtipo'], 4, "0", STR_PAD_LEFT);
        $aCSVEXT10['si124_desdobrasubtipo']     =   $aEXT10['si124_desdobrasubtipo'] == 0 ? ' ' : str_pad($aEXT10['si124_desdobrasubtipo'], 4, "0", STR_PAD_LEFT);
        $aCSVEXT10['si124_descextraorc']        =   substr($aEXT10['si124_descextraorc'], 0, 50);
        
        $this->sLinha = $aCSVEXT10;
        $this->adicionaLinha();

      }

      /**
      *
      * Registros 20, 21, 22, 23, 24
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsEXT20); $iCont++) {
      	

        $aEXT20  = pg_fetch_array($rsEXT20,$iCont);
        
        $aCSVEXT20['si165_tiporegistro']             =   str_pad($aEXT20['si165_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVEXT20['si165_codorgao']                 =   str_pad($aEXT20['si165_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVEXT20['si165_codext']                   =   substr($aEXT20['si165_codext'], 0, 15);
        $aCSVEXT20['si165_codfontrecursos']          =   str_pad($aEXT20['si165_codfontrecursos'], 3, "0", STR_PAD_LEFT);
        $aCSVEXT20['si165_vlsaldoanteriorfonte']     =   number_format($aEXT20['si165_vlsaldoanteriorfonte'], 2, ",", "");
        $aCSVEXT20['si165_vlsaldoatualfonte']        =   number_format($aEXT20['si165_vlsaldoatualfonte'], 2, ",", "");
        
       
        $this->sLinha = $aCSVEXT20;
        $this->adicionaLinha();
        
        for ($iCont2 = 0;$iCont2 < pg_num_rows($rsEXT21); $iCont2++) {        

          $aEXT21  = pg_fetch_array($rsEXT21,$iCont2);
          
          if ($aEXT20['si165_sequencial'] == $aEXT21['si125_reg20']) {

            $aCSVEXT21['si125_tiporegistro']             =    str_pad($aEXT21['si125_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVEXT21['si125_codreduzidomov']           =    substr($aEXT21['si125_codreduzidomov'], 0, 15);
            $aCSVEXT21['si125_codext']                   =    substr($aEXT21['si125_codext'], 0, 15);
            $aCSVEXT21['si125_codfontrecursos']          =    str_pad($aEXT21['si125_codfontrecursos'], 3, "0", STR_PAD_LEFT);
            $aCSVEXT21['si125_categoria']                =    str_pad($aEXT21['si125_categoria'], 1, "0", STR_PAD_LEFT);
            $aCSVEXT21['si125_dtlancamento']             =    implode("", array_reverse(explode("-", $aEXT21['si125_dtlancamento'])));
            $aCSVEXT21['si125_vllancamento']             =    number_format($aEXT21['si125_vllancamento'], 2, ",", "");
            
            $this->sLinha = $aCSVEXT21;
            $this->adicionaLinha();
          

        

	        for ($iCont3 = 0;$iCont3 < pg_num_rows($rsEXT22); $iCont3++) {        
	
	          $aEXT22  = pg_fetch_array($rsEXT22,$iCont3);
	          
	          if ($aEXT21['si125_sequencial'] == $aEXT22['si126_reg21']) {
	
	            $aCSVEXT22['si126_tiporegistro']             =    str_pad($aEXT22['si126_tiporegistro'], 2, "0", STR_PAD_LEFT);
	            $aCSVEXT22['si126_codreduzidoeo']           =    substr($aEXT22['si126_codreduzidoeo'], 0, 15);
	            $aCSVEXT22['si126_codreduzidoop']            =    substr($aEXT22['si126_codreduzidoop'], 0, 15);
	            $aCSVEXT22['si126_nroop']                    =    substr($aEXT22['si126_codreduzidoop'], 0, 22);
	            $aCSVEXT22['si126_dtpagamento']              =    implode("", array_reverse(explode("-", $aEXT22['si126_dtpagamento'])));
	            $aCSVEXT22['si126_tipodocumentocredor']      =    str_pad($aEXT22['si126_tipodocumentocredor'], 1, "0", STR_PAD_LEFT);
	            $aCSVEXT22['si126_nrodocumento']             =    substr($aEXT22['si126_nrodocumento'], 0, 24);
	            $aCSVEXT22['si126_vlop']                     =    number_format($aEXT22['si126_vlop'], 2, ",", "");
	            $aCSVEXT22['si126_especificacaoop']          =    substr($aEXT22['si126_especificacaoop'], 0, 200);
	            $aCSVEXT22['si126_cpfresppgto']              =    str_pad($aEXT22['si126_cpfresppgto'], 11, "0", STR_PAD_LEFT);
	            //echo "<pre>";print_r($aCSVEXT22);
	            $this->sLinha = $aCSVEXT22;
	            $this->adicionaLinha();
	
	          
		        for ($iCont4 = 0;$iCont4 < pg_num_rows($rsEXT23); $iCont4++) {        
		
		          $aEXT23  = pg_fetch_array($rsEXT23,$iCont4);
		          
		          if ($aEXT22['si126_sequencial'] == $aEXT23['si127_reg22']) {
		
		            $aCSVEXT23['si127_tiporegistro']             =    str_pad($aEXT23['si127_tiporegistro'], 2, "0", STR_PAD_LEFT);
		            $aCSVEXT23['si127_codreduzidoop']            =    substr($aEXT23['si127_codreduzidoop'], 0, 15);
		            $aCSVEXT23['si127_tipodocumentoop']          =    str_pad($aEXT23['si127_tipodocumentoop'], 2, "0", STR_PAD_LEFT);
		            $aCSVEXT23['si127_nrodocumento']             =    substr($aEXT23['si127_nrodocumento'], 0, 15);
		            $aCSVEXT23['si127_codctb']                   =    substr($aEXT23['si127_codctb'], 0, 20);
		            $aCSVEXT23['si127_codfontectb']              =    str_pad($aEXT23['si127_codfontectb'], 3, "0", STR_PAD_LEFT);
		            $aCSVEXT23['si127_dtemissao']                =    implode("", array_reverse(explode("-", $aEXT23['si127_dtemissao'])));
		            $aCSVEXT23['si127_vldocumento']              =    number_format($aEXT23['si127_vldocumento'], 2, ",", "");
		            
		            $this->sLinha = $aCSVEXT23;
		            $this->adicionaLinha();
		
		          }
		
		        }
		
		        for ($iCont5 = 0;$iCont5 < pg_num_rows($rsEXT24); $iCont5++) {        
		
		          $aEXT24  = pg_fetch_array($rsEXT24,$iCont5);
		          
		          if ($aEXT23['si127_sequencial'] == $aEXT24['si128_reg23']) {
		
		            $aCSVEXT24['si128_tiporegistro']             =    str_pad($aEXT23['si128_tiporegistro'], 2, "0", STR_PAD_LEFT);
		            $aCSVEXT24['si128_codreduzidoop']            =    substr($aEXT23['si128_codreduzidoop'], 0, 15);
		            $aCSVEXT24['si128_tiporetencao']             =    str_pad($aEXT23['si128_tiporetencao'], 4, "0", STR_PAD_LEFT);
		            $aCSVEXT24['si128_descricaoretencao']        =    substr($aEXT23['si128_descricaoretencao'], 0, 50);
		            $aCSVEXT24['si128_vlretencao']               =    number_format($aEXT23['si128_vlretencao'], 2, ",", "");
		            
		            $this->sLinha = $aCSVEXT24;
		            $this->adicionaLinha();
		
		          }
		
		        }
	          }
	        }
        }
        }

      }

      $this->fechaArquivo();

  } 
  }
}