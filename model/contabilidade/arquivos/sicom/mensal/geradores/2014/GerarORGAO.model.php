<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarORGAO extends GerarAM {

/**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

  	$this->sArquivo = "ORGAO";
  	$this->abreArquivo();
  	
  	$sSql         = "select * from orgao102014 where si14_mes = ". $this->iMes ." and si14_instit = ".db_getsession("DB_instit") ;
  	$rsORGAO10    = db_query($sSql);

  	$sSql2        = "select * from orgao112014 where si15_mes = ". $this->iMes ." and si15_instit = ".db_getsession("DB_instit");
  	$rsORGAO11    = db_query($sSql2);

  	if (pg_num_rows($rsORGAO10) == 0) {

	    $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

	  } else {

  	  for ($iCont = 0;$iCont < pg_num_rows($rsORGAO10); $iCont++) {

   	    $aORGAO10  = pg_fetch_array($rsORGAO10,$iCont, PGSQL_ASSOC);
  	       
   	    $aCSVORGAO10['si14_tiporegistro']          =   str_pad($aORGAO10['si14_tiporegistro'], 2, "0", STR_PAD_LEFT);
   	    $aCSVORGAO10['si14_codorgao']              =   str_pad($aORGAO10['si14_codorgao'], 2, "0", STR_PAD_LEFT);
   	    $aCSVORGAO10['si14_tipoorgao']             =   str_pad($aORGAO10['si14_tipoorgao'], 2, "0", STR_PAD_LEFT);
   	    $aCSVORGAO10['si14_cnpjorgao']             =   str_pad($aORGAO10['si14_cnpjorgao'], 14, "0", STR_PAD_LEFT);
		
		$this->sLinha = $aCSVORGAO10;
	    $this->adicionaLinha();

        for ($iCont2 = 0;$iCont2 < pg_num_rows($rsORGAO11); $iCont2++) {    

          $aORGAO11  = pg_fetch_array($rsORGAO11,$iCont2);

	      if ($aORGAO10['si14_sequencial'] == $aORGAO11['si15_reg10']) {

	      	$aCSVORGAO11['si15_tiporegistro']          =  str_pad($aORGAO11['si15_tiporegistro'], 2, "0", STR_PAD_LEFT);
	      	$aCSVORGAO11['si15_tiporesponsavel']       =  str_pad($aORGAO11['si15_tiporesponsavel'], 2, "0", STR_PAD_LEFT);
	      	$aCSVORGAO11['si15_cartident']             =  substr($aORGAO11['si15_cartident'], 0,10);
	      	$aCSVORGAO11['si15_orgemissorci']          =  substr($aORGAO11['si15_orgemissorci'], 0,10);
	      	$aCSVORGAO11['si15_cpf']                   =  substr($aORGAO11['si15_cpf'], 0,11);
	      	$aCSVORGAO11['si15_crccontador']           =  substr($aORGAO11['si15_crccontador'], 0,11);
	      	$aCSVORGAO11['si15_ufcrccontador']         =  $aORGAO11['si15_ufcrccontador'];
			$aCSVORGAO11['si15_cargoorddespdeleg']     =  substr($aORGAO11['si15_cargoorddespdeleg'], 0,50);
			$aCSVORGAO11['si15_dtinicio']              =  implode("", array_reverse(explode("-", $aORGAO11['si15_dtinicio'])));
			$aCSVORGAO11['si15_dtfinal']               =  implode("", array_reverse(explode("-", $aORGAO11['si15_dtfinal'])));
			$aCSVORGAO11['si15_email']                 =  substr($aORGAO11['si15_email'], 0,50);

	        $this->sLinha = $aCSVORGAO11;
	        $this->adicionaLinha();
	        
	      }

		}
	}

	$this->fechaArquivo();

  } 

}

}