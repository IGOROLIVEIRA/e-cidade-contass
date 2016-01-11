<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarIDE extends GerarAM {

 /**
  * 
  * Mes de refer�ncia
  * @var Integer
  */
  public $iMes;
	
  public function gerarDados() {

  	$this->sArquivo = "IDE";
  	$this->abreArquivo();
  	
  	$sSql     = "select * from ide2016 where si11_mes = {$this->iMes} and si11_instit = ".db_getsession("DB_instit");
  	$rsIDE    = db_query($sSql);

  	if (pg_num_rows($rsIDE) == 0) {

	     $aCSV['tiporegistro']       =   '99';
       $this->sLinha = $aCSV;
       $this->adicionaLinha();

	  } else {

  	  for ($iCont = 0;$iCont < pg_num_rows($rsIDE); $iCont++) {

   	    $aIDE     = pg_fetch_array($rsIDE,$iCont, PGSQL_ASSOC);

   	    unset($aIDE['si11_sequencial']);
   	    unset($aIDE['si11_mes']);
   	    unset($aIDE['si11_instit']);

   	    $aIDE['si11_codmunicipio']               =  str_pad($aIDE['si11_codmunicipio'], 5, "0", STR_PAD_LEFT);
  	    $aIDE['si11_cnpjmunicipio']              =  str_pad($aIDE['si11_cnpjmunicipio'], 14, "0", STR_PAD_LEFT);
  	    $aIDE['si11_codorgao']                   =  str_pad($aIDE['si11_codorgao'], 2, "0", STR_PAD_LEFT);
  	    $aIDE['si11_tipoorgao']                  =  str_pad($aIDE['si11_tipoorgao'], 2, "0", STR_PAD_LEFT);
  	    $aIDE['si11_exercicioreferencia']        =  str_pad($aIDE['si11_exercicioreferencia'], 4, "0", STR_PAD_LEFT);
  	    $aIDE['si11_mesreferencia']              =  str_pad($aIDE['si11_mesreferencia'], 2, "0", STR_PAD_LEFT);
  	    $aIDE['si11_datageracao']                =  implode("",array_reverse(explode("-", $aIDE['si11_datageracao'])));
  	 	$aIDE['si11_codcontroleremessa']         =  substr($aIDE['si11_codcontroleremessa'], 0,20);

		$this->sLinha = $aIDE;
	    $this->adicionaLinha();
			        
	  }

	  $this->fechaArquivo();

	}

  } 

}
