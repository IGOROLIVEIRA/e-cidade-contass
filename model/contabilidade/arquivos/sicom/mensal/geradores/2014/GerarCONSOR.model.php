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
  	
  	$sSql          = "select * from consor102014 where si16_mes = ". $this->iMes." and si16_instit = ".db_getsession("DB_instit");
  	$rsCONSOR10    = db_query($sSql);

  	$sSql2         = "select * from consor202014 where si17_mes = ". $this->iMes." and si17_instit = ".db_getsession("DB_instit");
  	$rsCONSOR20    = db_query($sSql2);

    $sSql3         = "select * from consor212014 where si18_mes = ". $this->iMes." and si18_instit = ".db_getsession("DB_instit");
    $rsCONSOR21    = db_query($sSql3);

    $sSql4         = "select * from consor222014 where si19_mes = ". $this->iMes." and si19_instit = ".db_getsession("DB_instit");
    $rsCONSOR22    = db_query($sSql4);

    $sSql5         = "select * from consor302014 where si20_mes = ". $this->iMes." and si20_instit = ".db_getsession("DB_instit");
    $rsCONSOR30    = db_query($sSql5);

  	if (pg_num_rows($rsCONSOR10) == 0 && pg_num_rows($rsCONSOR20) == 0 && pg_num_rows($rsCONSOR30) == 0) {

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
        $aCSVCONSOR10['si16_descareaatuacao']    =    $aCONSOR10['si16_descareaatuacao'] == '0' ? ' ' : substr($aCONSOR10['si16_descareaatuacao'], 0, 130);


		    $this->sLinha = $aCSVCONSOR10;
	      $this->adicionaLinha();

      }

      for ($iCont2 = 0;$iCont2 < pg_num_rows($rsCONSOR20); $iCont2++) {        

        $aCONSOR20  = pg_fetch_array($rsCONSOR20,$iCont2);

        $aCSVCONSOR20['si17_tiporegistro']         =    str_pad($aCONSOR20['si17_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVCONSOR20['si17_codorgao']             =    str_pad($aCONSOR20['si17_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVCONSOR20['si17_cnpjconsorcio']        =    str_pad($aCONSOR20['si17_cnpjconsorcio'], 14, "0", STR_PAD_LEFT);
        $aCSVCONSOR20['si17_vltransfrateio']       =    number_format($aCONSOR20['si17_vltransfrateio'], 2, ",", "");
        $aCSVCONSOR20['si17_prestcontas']          =    $aCONSOR20['si17_prestcontas'];

        $this->sLinha = $aCSVCONSOR20;
        $this->adicionaLinha();

        for ($iCont3 = 0;$iCont3 < pg_num_rows($rsCONSOR21); $iCont3++) {        

          $aCONSOR21  = pg_fetch_array($rsCONSOR21,$iCont3);

          $aCSVCONSOR21['si18_tiporegistro']                  =    str_pad($aCONSOR21['si18_tiporegistro'], 2, "0", STR_PAD_LEFT);
          $aCSVCONSOR21['si18_cnpjconsorcio']                 =    str_pad($aCONSOR21['si18_cnpjconsorcio'], 14, "0", STR_PAD_LEFT);
          $aCSVCONSOR21['si18_codfuncao']                     =    str_pad($aCONSOR21['si18_codfuncao'], 2, "0", STR_PAD_LEFT);
          $aCSVCONSOR21['si18_codsubfuncao']                  =    str_pad($aCONSOR21['si18_codsubfuncao'], 3, "0", STR_PAD_LEFT);
          $aCSVCONSOR21['si18_naturezadespesa']               =    str_pad($aCONSOR21['si18_naturezadespesa'], 6, "0", STR_PAD_LEFT);
          $aCSVCONSOR21['si18_subelemento']                   =    str_pad($aCONSOR21['si18_subelemento'], 2, "0", STR_PAD_LEFT);
          $aCSVCONSOR21['si18_vlempenhado']                   =    number_format($aCONSOR21['si18_vlempenhado'], 2, ",", "");
          $aCSVCONSOR21['si18_vlanulacaoempenho']             =    number_format($aCONSOR21['si18_vlanulacaoempenho'], 2, ",", "");
          $aCSVCONSOR21['si18_vlliquidado']                   =    number_format($aCONSOR21['si18_vlliquidado'], 2, ",", ""); 
          $aCSVCONSOR21['si18_vlanulacaoliquidacao']          =    number_format($aCONSOR21['si18_vlanulacaoliquidacao'], 2, ",", "");
          $aCSVCONSOR21['si18_vlpago']                        =    number_format($aCONSOR21['si18_vlpago'], 2, ",", "");
          $aCSVCONSOR21['si18_vlanulacaopagamento']           =    number_format($aCONSOR21['si18_vlanulacaopagamento'], 2, ",", "");

          $this->sLinha = $aCSVCONSOR21;
          $this->adicionaLinha();

        }

        for ($iCont4 = 0;$iCont4 < pg_num_rows($rsCONSOR22); $iCont4++) {        

          $aCONSOR22  = pg_fetch_array($rsCONSOR22,$iCont4);

          $aCSVCONSOR22['si19_tiporegistro']   =    str_pad($aCONSOR22['si19_tiporegistro'], 2, "0", STR_PAD_LEFT);
          $aCSVCONSOR22['si19_cnpjconsorcio']   =    str_pad($aCONSOR22['si19_cnpjconsorcio'], 14, "0", STR_PAD_LEFT);
          $aCSVCONSOR22['si19_vldispcaixa']    =    number_format($aCONSOR22['si19_vldispcaixa'], 2, ",", "");

          $this->sLinha = $aCSVCONSOR22;
          $this->adicionaLinha();

        }

      }

      for ($iCont5 = 0;$iCont5 < pg_num_rows($rsCONSOR30); $iCont5++) {        

        $aCONSOR30  = pg_fetch_array($rsCONSOR30,$iCont5);

        $aCSVCONSOR30['si20_tiporegistro']           =    str_pad($aCONSOR30['si20_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVCONSOR30['si20_codorgao']               =    str_pad($aCONSOR30['si20_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVCONSOR30['si20_cnpjconsorcio']          =    str_pad($aCONSOR30['si20_cnpjconsorcio'], 14, "0", STR_PAD_LEFT);
        $aCSVCONSOR30['si20_tipoencerramento']       =    str_pad($aCONSOR30['si20_tipoencerramento'], 1, "0", STR_PAD_LEFT);
        $aCSVCONSOR30['si20_dtencerramento']         =    implode("", array_reverse(explode("-", $aCONSOR30['si20_dtencerramento'])));
        
        $this->sLinha = $aCSVCONSOR30;
        $this->adicionaLinha();

      }

	}

	$this->fechaArquivo();

  } 

}