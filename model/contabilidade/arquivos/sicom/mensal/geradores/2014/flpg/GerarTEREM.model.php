<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarTEREM extends GerarAM {

/**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
	
  public function gerarDados() {

  	$this->sArquivo = "TEREM";
  	$this->abreArquivo();
  	
  	$sSql         = "select * from terem102014 where si194_mes = ". $this->iMes." and si194_inst = ".db_getsession("DB_instit");
  	$rsTEREM10    = db_query($sSql);

  	if (pg_num_rows($rsTEREM10) == 0) {

	    $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

	  } else {

  	  for ($iCont = 0;$iCont < pg_num_rows($rsTEREM10); $iCont++) {

   	    $aTEREM10  = pg_fetch_array($rsTEREM10,$iCont, PGSQL_ASSOC);

   	    unset($aTEREM10['si194_sequencial']);
   	    unset($aTEREM10['si194_mes']);
   	    unset($aTEREM10['si194_inst']);

   	      $aCSVTEREM10['si194_tiporegistro']             =  str_pad($aTEREM10['si194_tiporegistro'], 2, "0", STR_PAD_LEFT);
		  $aCSVTEREM10['si194_vlrparateto']              =  number_format($aTEREM10['si194_vlrparateto'], 2, ",", "");
		  $aCSVTEREM10['si194_tipocadastro']             =  str_pad($aTEREM10['si194_tipocadastro'], 1, "0", STR_PAD_LEFT);
		  $aCSVTEREM10['si194_justalteracao']            =  substr($aTEREM10['si194_justalteracao'], 0, 100);

		  $this->sLinha = $aCSVTEREM10;
	      $this->adicionaLinha();

	    }
			        
	}
	  $this->fechaArquivo();
  }

} 
