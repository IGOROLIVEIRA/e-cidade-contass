<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author igor
 * @package Contabilidade
 */
class GerarTCE extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;

  public function gerarDados()
  {

    $this->sArquivo = "TCE";
    $this->abreArquivo();

    $sSql = "select * from tce102021 where si187_mes = " . $this->iMes . " and si187_instit = " . db_getsession("DB_instit");
    $rstce10 = db_query($sSql);

    $sSql2 = "select * from tce112021 where si188_mes = " . $this->iMes . " and si188_instit = " . db_getsession("DB_instit");
    $rstce11 = db_query($sSql2);


    if (pg_num_rows($rstce10) == 0 && pg_num_rows($rstce11) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {
      /*
      for ($iCont = 0; $iCont < pg_num_rows($rstce10); $iCont++) {

        $aconge10 = pg_fetch_array($rsconge10, $iCont);

        $aCSVconge10['si187_tiporegistro']    = $this->padLeftZero($aconge10['si182_tiporegistro'], 2);
        $aCSVconge10['si182_codconvenioconge']        = $this->padLeftZero($aconge10['si182_codconvenioconge'], 2);
        $aCSVconge10['si182_codorgao']   = $this->padLeftZero($aconge10['si182_codorgao'], 2);
        $aCSVconge10['si182_codunidadesub']     = $this->padLeftZero($aconge10['si182_codunidadesub'], 5);
        $aCSVconge10['si182_nroconvenioconge'] = $aconge10['si182_nroconvenioconge'];
        $aCSVconge10['si182_dscinstrumento'] = $aconge10['si182_dscinstrumento'];
        $aCSVconge10['si182_dataassinaturaconge'] = $aconge10['si182_dataassinaturaconge'];
        $aCSVconge10['si182_datapublicconge'] = $aconge10['si182_datapublicconge'];
        $aCSVconge10['si182_nrocpfrespconge'] = $aconge10['si182_nrocpfrespconge'];
        $aCSVconge10['si182_dsccargorespconge'] = $aconge10['si182_dsccargorespconge'];
        $aCSVconge10['si182_objetoconvenioconge'] = $aconge10['si182_objetoconvenioconge'];
        $aCSVconge10['si182_datainiciovigenciaconge'] = $aconge10['si182_datainiciovigenciaconge'];
        $aCSVconge10['si182_datafinalvigenciaconge'] = $aconge10['si182_datafinalvigenciaconge'];
        $aCSVconge10['si182_formarepasse'] = $aconge10['si182_formarepasse'];
        $aCSVconge10['ai182_tipodocumentoincentivador'] = $aconge10['ai182_tipodocumentoincentivador'];
        $aCSVconge10['si182_nrodocumentoincentivador'] = $aconge10['si182_nrodocumentoincentivador'];
        $aCSVconge10['si182_quantparcelas'] = $aconge10['si182_quantparcelas'];
        $aCSVconge10['si182_vltotalconvenioconge'] = $aconge10['si182_vltotalconvenioconge'];
        $aCSVconge10['si182_vlcontrapartidaconge'] = $aconge10['si182_vlcontrapartidaconge'];
        $aCSVconge10['si182_tipodocumentobeneficiario'] = $aconge10['si182_tipodocumentobeneficiario'];
        $aCSVconge10['si182_nrodocumentobeneficiario'] = $aconge10['si182_nrodocumentobeneficiario'];


        $this->sLinha = $aCSVconge10;
        $this->adicionaLinha();

      }

      for ($iCont2 = 0; $iCont2 < pg_num_rows($rsconge20); $iCont2++) {

        $aconge20 = pg_fetch_array($rsconge20, $iCont2);

        $aCSVconge20['si17_tiporegistro']    = $this->padLeftZero($aconge20['si17_tiporegistro'], 2);
        $aCSVconge20['si17_codorgao']        = $this->padLeftZero($aconge20['si17_codorgao'], 2);
        $aCSVconge20['si17_cnpjcongecio']   = $this->padLeftZero($aconge20['si17_cnpjcongecio'], 14);
        $aCSVconge20['si17_codfontrecursos'] = $this->padLeftZero($aconge20['si17_codfontrecursos'], 3);
        $aCSVconge20['si17_vltransfrateio']  = $this->sicomNumberReal($aconge20['si17_vltransfrateio'], 2);
        $aCSVconge20['si17_prestcontas']     = $aconge20['si17_prestcontas'];

        $this->sLinha = $aCSVconge20;
        $this->adicionaLinha();
      }
      for ($iCont3 = 0; $iCont3 < pg_num_rows($rsconge30); $iCont3++) {

        $aconge30 = pg_fetch_array($rsconge30, $iCont3);

        $aCSVconge30['si18_tiporegistro']              = $this->padLeftZero($aconge30['si18_tiporegistro'], 2);
        $aCSVconge30['si18_cnpjcongecio']             = $this->padLeftZero($aconge30['si18_cnpjcongecio'], 14);
        $aCSVconge30['si18_mesreferencia']             = $this->padLeftZero($aconge30['si18_mes'], 2);
        $aCSVconge30['si18_codfuncao']                 = $this->padLeftZero($aconge30['si18_codfuncao'], 2);
        $aCSVconge30['si18_codsubfuncao']              = $this->padLeftZero($aconge30['si18_codsubfuncao'], 3);
        $aCSVconge30['si18_naturezadespesa']           = $this->padLeftZero($aconge30['si18_naturezadespesa'], 6);
        $aCSVconge30['si18_subelemento']               = $this->padLeftZero($aconge30['si18_subelemento'], 2);
        $aCSVconge30['si18_codfontrecursos']           = $this->padLeftZero($aconge30['si18_codfontrecursos'], 3);
        $aCSVconge30['si18_vlempenhadofonte']          = $this->sicomNumberReal($aconge30['si18_vlempenhadofonte'], 2);
        $aCSVconge30['si18_vlanulacaoempenhofonte']    = $this->sicomNumberReal($aconge30['si18_vlanulacaoempenhofonte'], 2);
        $aCSVconge30['si18_vlliquidadofonte']          = $this->sicomNumberReal($aconge30['si18_vlliquidadofonte'], 2);
        $aCSVconge30['si18_vlanulacaoliquidacaofonte'] = $this->sicomNumberReal($aconge30['si18_vlanulacaoliquidacaofonte'], 2);
        $aCSVconge30['si18_vlpagofonte']               = $this->sicomNumberReal($aconge30['si18_vlpagofonte'], 2);
        $aCSVconge30['si18_vlanulacaopagamentofonte']  = $this->sicomNumberReal($aconge30['si18_vlanulacaopagamentofonte'], 2);

        $this->sLinha = $aCSVconge30;
        $this->adicionaLinha();

      }

      for ($iCont4 = 0; $iCont4 < pg_num_rows($rsconge40); $iCont4++) {

        $aconge40 = pg_fetch_array($rsconge40, $iCont4);

        $aCSVconge40['si19_tiporegistro']    = $this->padLeftZero($aconge40['si19_tiporegistro'], 2);
        $aCSVconge40['si19_cnpjcongecio']   = $this->padLeftZero($aconge40['si19_cnpjcongecio'], 14);
        $aCSVconge40['si19_codfontrecursos'] = $this->padLeftZero($aconge40['si19_codfontrecursos'], 3);
        $aCSVconge40['si19_vldispcaixa']     = $this->sicomNumberReal($aconge40['si19_vldispcaixa'], 2);

        $this->sLinha = $aCSVconge40;
        $this->adicionaLinha();

      }


      for ($iCont5 = 0; $iCont5 < pg_num_rows($rsconge50); $iCont5++) {

        $aconge50 = pg_fetch_array($rsconge50, $iCont5);

        $aCSVconge50['si20_tiporegistro']      = $this->padLeftZero($aconge50['si20_tiporegistro'], 2);
        $aCSVconge50['si20_codorgao']          = $this->padLeftZero($aconge50['si20_codorgao'], 2);
        $aCSVconge50['si20_cnpjcongecio']     = $this->padLeftZero($aconge50['si20_cnpjcongecio'], 14);
        $aCSVconge50['si20_tipoencerramento']  = $this->padLeftZero($aconge50['si20_tipoencerramento'], 1);
        $aCSVconge50['si20_dtencerramento']    = $this->sicomDate($aconge50['si20_dtencerramento']);

        $this->sLinha = $aCSVconge50;
        $this->adicionaLinha();

      }*/

    }

    $this->fechaArquivo();

  }

}
