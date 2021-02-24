<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarDDC extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;

  public function gerarDados()
  {

    $this->sArquivo = "DDC";
    $this->abreArquivo();

    $sSql = "select * from ddc102021 where si150_mes = " . $this->iMes . " and si150_instit = " . db_getsession("DB_instit");
    $rsDDC10 = db_query($sSql);

    $sSql2 = "select * from ddc202021 where si153_mes = " . $this->iMes . " and si153_instit = " . db_getsession("DB_instit");
    $rsDDC20 = db_query($sSql2);

    $sSql3 = "select * from ddc302021 where si154_mes = " . $this->iMes . " and si154_instit = " . db_getsession("DB_instit");
    $rsDDC30 = db_query($sSql3);

    $sSql4 = "select * from ddc402021 where si178_mes = " . $this->iMes . " and si178_instit = " . db_getsession("DB_instit");
    $rsDDC40 = db_query($sSql4);


    if (pg_num_rows($rsDDC10) == 0 && pg_num_rows($rsDDC20) == 0 && pg_num_rows($rsDDC30) == 0 && pg_num_rows($rsDDC40) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {

      /**
       *
       * Registros 10
       */
      for ($iCont = 0; $iCont < pg_num_rows($rsDDC10); $iCont++) {

        $aDDC10 = pg_fetch_array($rsDDC10, $iCont);

        $aCSVDDC10['si150_tiporegistro']                = $this->padLeftZero($aDDC10['si150_tiporegistro'], 2);
        $aCSVDDC10['si150_codorgao']                    = $this->padLeftZero($aDDC10['si150_codorgao'], 2);
        $aCSVDDC10['si150_nroleiautorizacao']           = substr($aDDC10['si150_nroleiautorizacao'], 0, 6);
        $aCSVDDC10['si150_dtleiautorizacao']            = $this->sicomDate($aDDC10['si150_dtleiautorizacao']);
        $aCSVDDC10['si150_dtpublicacaoleiautorizacao']  = $this->sicomDate($aDDC10['si150_dtleiautorizacao']);

        $this->sLinha = $aCSVDDC10;
        $this->adicionaLinha();

      }

      for ($iCont2 = 0; $iCont2 < pg_num_rows($rsDDC20); $iCont2++) {

        $aDDC20 = pg_fetch_array($rsDDC20, $iCont2);

        $aCSVDDC20['si153_tiporegistro']                = $this->padLeftZero($aDDC20['si153_tiporegistro'], 2);
        $aCSVDDC20['si153_codorgao']                    = $this->padLeftZero($aDDC20['si153_codorgao'], 2);
        $aCSVDDC20['si153_nrocontratodivida']           = substr($aDDC20['si153_nrocontratodivida'], 0, 30);
        $aCSVDDC20['si153_dtassinatura']                = $this->sicomDate($aDDC20['si153_dtassinatura']);
        $aCSVDDC20['si153_contratodeclei']              = $this->padLeftZero($aDDC20['si153_contratodeclei'], 1);
        $aCSVDDC20['si153_nroleiautorizacao']           = substr($aDDC20['si153_nroleiautorizacao'], 0, 6);
        $aCSVDDC20['si153_dtleiautorizacao']            = $this->sicomDate($aDDC20['si153_dtleiautorizacao']);
        $aCSVDDC20['si153_objetocontratodivida']        = substr($aDDC20['si153_objetocontratodivida'], 0, 1000);
        $aCSVDDC20['si153_especificacaocontratodivida'] = substr($aDDC20['si153_objetocontratodivida'], 0, 500);

        $this->sLinha = $aCSVDDC20;
        $this->adicionaLinha();

      }

      for ($iCont3 = 0; $iCont3 < pg_num_rows($rsDDC30); $iCont3++) {

        $aDDC30 = pg_fetch_array($rsDDC30, $iCont3);

        $aCSVDDC30['si154_tiporegistro']              = $this->padLeftZero($aDDC30['si154_tiporegistro'], 2);
        $aCSVDDC30['si154_codorgao']                  = $this->padLeftZero($aDDC30['si154_codorgao'], 2);
        $aCSVDDC30['si154_nrocontratodivida']         = substr($aDDC30['si154_nrocontratodivida'], 0, 30);
        $aCSVDDC30['si154_dtassinatura']              = $this->sicomDate($aDDC30['si154_dtassinatura']);
        $aCSVDDC30['si154_tipolancamento']            = $this->padLeftZero($aDDC30['si154_tipolancamento'], 2);
        $aCSVDDC30['si154_subtipo']                   = $this->padLeftZero($aDDC30['si154_subtipo'], 1);
        $aCSVDDC30['si154_tipodocumentocredor']       = $this->padLeftZero($aDDC30['si154_tipodocumentocredor'], 1);
        $aCSVDDC30['si154_nrodocumentocredor']        = substr($aDDC30['si154_nrodocumentocredor'], 0, 14);
        $aCSVDDC30['si154_justificativacancelamento'] = substr($aDDC30['si154_justificativacancelamento'], 0, 500);
        $aCSVDDC30['si154_vlsaldoanterior']           = $this->sicomNumberReal($aDDC30['si154_vlsaldoanterior'], 2);
        $aCSVDDC30['si154_vlcontratacao']             = $this->sicomNumberReal($aDDC30['si154_vlcontratacao'], 2);
        $aCSVDDC30['si154_vlamortizacao']             = $this->sicomNumberReal($aDDC30['si154_vlamortizacao'], 2);
        $aCSVDDC30['si154_vlcancelamento']            = $this->sicomNumberReal($aDDC30['si154_vlcancelamento'], 2);
        $aCSVDDC30['si154_vlencampacao']              = $this->sicomNumberReal($aDDC30['si154_vlencampacao'], 2);
        $aCSVDDC30['si154_vlatualizacao']             = $this->sicomNumberReal($aDDC30['si154_vlatualizacao'], 2);
        $aCSVDDC30['si154_vlsaldoatual']              = $this->sicomNumberReal($aDDC30['si154_vlsaldoatual'], 2);

        $this->sLinha = $aCSVDDC30;
        $this->adicionaLinha();

      }

      for ($iCont4 = 0; $iCont4 < pg_num_rows($rsDDC40); $iCont4++) {

        $aDDC40 = pg_fetch_array($rsDDC40, $iCont4);

        $aCSVDDC40['si178_tiporegistro']    = $this->padLeftZero($aDDC40['si178_tiporegistro'], 2);
        $aCSVDDC40['si178_codorgao']        = $this->padLeftZero($aDDC40['si178_codorgao'], 2);
        $aCSVDDC40['si178_passivoatuarial'] = $this->padLeftZero($aDDC40['si178_passivoatuarial'], 1);
        $aCSVDDC40['si178_vlsaldoanterior'] = $this->sicomNumberReal($aDDC40['si178_vlsaldoanterior'], 2);
        $aCSVDDC40['si178_vlsaldoatual']    = $this->sicomNumberReal($aDDC40['si178_vlsaldoatual'], 2);

        $this->sLinha = $aCSVDDC40;
        $this->adicionaLinha();

      }

      $this->fechaArquivo();

    }

  }

}
