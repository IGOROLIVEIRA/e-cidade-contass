<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarCONSOR extends GerarAM {

   /**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

  	$this->sArquivo = "CONSOR";
  	$this->abreArquivo();
  	
  	$sSql          = "select * from consor102016 where si16_mes = ". $this->iMes." and si16_instit = ".db_getsession("DB_instit");
  	$rsCONSOR10    = db_query($sSql);

  	$sSql2         = "select * from consor202016 where si17_mes = ". $this->iMes." and si17_instit = ".db_getsession("DB_instit");
  	$rsCONSOR20    = db_query($sSql2);

    $sSql3         = "select * from consor302016 where si18_mes = ". $this->iMes." and si18_instit = ".db_getsession("DB_instit");
    $rsCONSOR30    = db_query($sSql3);

    $sSql4         = "select * from consor402016 where si19_mes = ". $this->iMes." and si19_instit = ".db_getsession("DB_instit");
    $rsCONSOR40    = db_query($sSql4);

    $sSql5         = "select * from consor502016 where si20_mes = ". $this->iMes." and si20_instit = ".db_getsession("DB_instit");
    $rsCONSOR50    = db_query($sSql5);

  	if (pg_num_rows($rsCONSOR10) == 0 && pg_num_rows($rsCONSOR20) == 0 && pg_num_rows($rsCONSOR50) == 0) {

	    $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

	  } else {

  	  for ($iCont = 0;$iCont < pg_num_rows($rsCONSOR10); $iCont++) {

   	    $aCONSOR10  = pg_fetch_array($rsCONSOR10,$iCont);
  	       
        $aCSVCONSOR10['si16_tiporegistro']       =    str_pad($aCONSOR10['si16_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVCONSOR10['si16_codorgao']           =    str_pad($aCONSOR10['si16_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVCONSOR10['si16_cnpjconsorcio']      =    str_pad($aCONSOR10['si16_cnpjconsorcio'], 14, "0", STR_PAD_LEFT);
        $aCSVCONSOR10['si16_areaatuacao']        =    str_pad($aCONSOR10['si16_areaatuacao'], 2, "0", STR_PAD_LEFT);
        $aCSVCONSOR10['si16_descareaatuacao']    =    $aCONSOR10['si16_descareaatuacao'] == '0' ? ' ' : substr($aCONSOR10['si16_descareaatuacao'], 0, 150);


		    $this->sLinha = $aCSVCONSOR10;
	      $this->adicionaLinha();

      }

      for ($iCont2 = 0;$iCont2 < pg_num_rows($rsCONSOR20); $iCont2++) {        

        $aCONSOR20  = pg_fetch_array($rsCONSOR20,$iCont2);

        $aCSVCONSOR20['si17_tiporegistro']         =    str_pad($aCONSOR20['si17_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVCONSOR20['si17_codorgao']             =    str_pad($aCONSOR20['si17_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVCONSOR20['si17_cnpjconsorcio']        =    str_pad($aCONSOR20['si17_cnpjconsorcio'], 14, "0", STR_PAD_LEFT);
        $aCSVCONSOR20['si17_codfontrecursos']      =    str_pad($aCONSOR20['si17_codfontrecursos'], 3, "0", STR_PAD_LEFT);
        $aCSVCONSOR20['si17_vltransfrateio']       =    number_format($aCONSOR20['si17_vltransfrateio'], 2, ",", "");
        $aCSVCONSOR20['si17_prestcontas']          =    $aCONSOR20['si17_prestcontas'];

        $this->sLinha = $aCSVCONSOR20;
        $this->adicionaLinha();

        for ($iCont3 = 0;$iCont3 < pg_num_rows($rsCONSOR30); $iCont3++) {        

          $aCONSOR30  = pg_fetch_array($rsCONSOR30,$iCont3);

          $aCSVCONSOR30['si18_tiporegistro']                  =    str_pad($aCONSOR30['si18_tiporegistro'], 2, "0", STR_PAD_LEFT);
          $aCSVCONSOR30['si18_cnpjconsorcio']                 =    str_pad($aCONSOR30['si18_cnpjconsorcio'], 14, "0", STR_PAD_LEFT);
          $aCSVCONSOR30['si18_mesreferencia']                 =    str_pad($aCONSOR30['si18_mes'], 2, "0", STR_PAD_LEFT);
          $aCSVCONSOR30['si18_codfuncao']                     =    str_pad($aCONSOR30['si18_codfuncao'], 2, "0", STR_PAD_LEFT);
          $aCSVCONSOR30['si18_codsubfuncao']                  =    str_pad($aCONSOR30['si18_codsubfuncao'], 3, "0", STR_PAD_LEFT);
          $aCSVCONSOR30['si18_naturezadespesa']               =    str_pad($aCONSOR30['si18_naturezadespesa'], 6, "0", STR_PAD_LEFT);
          $aCSVCONSOR30['si18_subelemento']                   =    str_pad($aCONSOR30['si18_subelemento'], 2, "0", STR_PAD_LEFT);
          $aCSVCONSOR30['si18_codfontrecursos']               =    str_pad($aCONSOR30['si18_codfontrecursos'], 3, "0", STR_PAD_LEFT);
          $aCSVCONSOR30['si18_vlempenhadofonte']              =    number_format($aCONSOR30['si18_vlempenhadofonte'], 2, ",", "");
          $aCSVCONSOR30['si18_vlanulacaoempenhofonte']        =    number_format($aCONSOR30['si18_vlanulacaoempenhofonte'], 2, ",", "");
          $aCSVCONSOR30['si18_vlliquidadofonte']              =    number_format($aCONSOR30['si18_vlliquidadofonte'], 2, ",", ""); 
          $aCSVCONSOR30['si18_vlanulacaoliquidacaofonte']     =    number_format($aCONSOR30['si18_vlanulacaoliquidacaofonte'], 2, ",", "");
          $aCSVCONSOR30['si18_vlpagofonte']                   =    number_format($aCONSOR30['si18_vlpagofonte'], 2, ",", "");
          $aCSVCONSOR30['si18_vlanulacaopagamentofonte']      =    number_format($aCONSOR30['si18_vlanulacaopagamentofonte'], 2, ",", "");

          $this->sLinha = $aCSVCONSOR30;
          $this->adicionaLinha();

        }

        for ($iCont4 = 0;$iCont4 < pg_num_rows($rsCONSOR40); $iCont4++) {        

          $aCONSOR40  = pg_fetch_array($rsCONSOR40,$iCont4);

          $aCSVCONSOR40['si19_tiporegistro']      =    str_pad($aCONSOR40['si19_tiporegistro'], 2, "0", STR_PAD_LEFT);
          $aCSVCONSOR40['si19_cnpjconsorcio']     =    str_pad($aCONSOR40['si19_cnpjconsorcio'], 14, "0", STR_PAD_LEFT);
          $aCSVCONSOR40['si19_codfontrecursos']   =    str_pad($aCONSOR40['si19_codfontrecursos'], 3, "0", STR_PAD_LEFT);
          $aCSVCONSOR40['si19_vldispcaixa']       =    number_format($aCONSOR40['si19_vldispcaixa'], 2, ",", "");

          $this->sLinha = $aCSVCONSOR40;
          $this->adicionaLinha();

        }

      }

      for ($iCont5 = 0;$iCont5 < pg_num_rows($rsCONSOR50); $iCont5++) {        

        $aCONSOR50  = pg_fetch_array($rsCONSOR50,$iCont5);

        $aCSVCONSOR50['si20_tiporegistro']           =    str_pad($aCONSOR50['si20_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVCONSOR50['si20_codorgao']               =    str_pad($aCONSOR50['si20_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVCONSOR50['si20_cnpjconsorcio']          =    str_pad($aCONSOR50['si20_cnpjconsorcio'], 14, "0", STR_PAD_LEFT);
        $aCSVCONSOR50['si20_tipoencerramento']       =    str_pad($aCONSOR50['si20_tipoencerramento'], 1, "0", STR_PAD_LEFT);
        $aCSVCONSOR50['si20_dtencerramento']         =    implode("", array_reverse(explode("-", $aCONSOR50['si20_dtencerramento'])));
        
        $this->sLinha = $aCSVCONSOR50;
        $this->adicionaLinha();

      }

	}

	$this->fechaArquivo();

  } 

}
