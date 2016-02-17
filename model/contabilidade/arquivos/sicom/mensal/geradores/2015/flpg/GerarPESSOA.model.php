<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarPESSOA extends GerarAM {

/**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
	
  public function gerarDados() {

  	$this->sArquivo = "PESSOA";
  	$this->abreArquivo();
  	
  	$sSql          = "select * from pessoaflpg102015 where si193_mes = ". $this->iMes." and si193_instit = ".db_getsession("DB_instit");
  	$rsPESSOA10    = db_query($sSql);

  	if (pg_num_rows($rsPESSOA10) == 0) {

	    $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

	  } else {

  	  for ($iCont = 0;$iCont < pg_num_rows($rsPESSOA10); $iCont++) {

   	    $aPESSOA10  = pg_fetch_array($rsPESSOA10,$iCont, PGSQL_ASSOC);

   	    unset($aPESSOA10['si193_sequencial']);
   	    unset($aPESSOA10['si193_mes']);
   	    unset($aPESSOA10['si193_instit']);

   	    $aPESSOA10['si193_tiporegistro']             =  str_pad($aPESSOA10['si193_tiporegistro'], 2, "0", STR_PAD_LEFT);
   	    $aPESSOA10['si193_tipodocumento']            =  str_pad($aPESSOA10['si193_tipodocumento'], 1, "0", STR_PAD_LEFT);
   	    $aPESSOA10['si193_nrodocumento']             =  substr($aPESSOA10['si193_nrodocumento'], 0,14);
   	    $aPESSOA10['si193_nome']                     =  substr($aPESSOA10['si193_nome'], 0,120);
        $aPESSOA10['si193_indsexo']                  =  str_pad($aPESSOA10['si193_indsexo'], 1, "0", STR_PAD_LEFT);
        $aPESSOA10['si193_datanascimento']           =  substr($aPESSOA10['si193_justificativaalteracao'], 0,100);
		$aPESSOA10['si193_tipocadastro']             =  substr($aPESSOA10['si193_justificativaalteracao'], 0,100);
		$aPESSOA10['si193_justalteracao']            =  substr($aPESSOA10['si193_justificativaalteracao'], 0,100);

		    $this->sLinha = $aPESSOA10;
	      $this->adicionaLinha();

	    }
			        
	}
	  $this->fechaArquivo();
  }

} 
