<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarRPSD extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;
  
  public function gerarDados()
  {

    $this->sArquivo = "RPSD";
    $this->abreArquivo();

    $sSql = "select * from rpsd10$PROXIMO_ANO where si189_mes = " . $this->iMes . " and si189_instit = " . db_getsession("DB_instit");
    $rsRPSD10 = db_query($sSql);

    $sSql2 = "select * from rpsd11$PROXIMO_ANO where si190_mes = " . $this->iMes . " and si190_instit = " . db_getsession("DB_instit");
    $rsRPSD11 = db_query($sSql2);

    if (pg_num_rows($rsRPSD10) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {

      for ($iCont = 0; $iCont < pg_num_rows($rsRPSD10); $iCont++) {

        $aRPSD10 = pg_fetch_array($rsRPSD10, $iCont, PGSQL_ASSOC);

        $aCSVRPSD10['si189_tiporegistro']               = $this->padLeftZero($aRPSD10['si189_tiporegistro'], 2);
        $aCSVRPSD10['si189_codreduzidorsp']                   = substr($aRPSD10['si189_codreduzidorsp'], 0, 15);
        $aCSVRPSD10['si189_codorgao']                  = $this->padLeftZero($aRPSD10['si189_codorgao'], 2);
        $aCSVRPSD10['si189_codunidadesub']                  = $this->padLeftZero($aRPSD10['si189_codunidadesub'], strlen($aRPSD10['si189_codunidadesub']) > 5 ? 8 : 5);
        $aCSVRPSD10['si189_codunidadesuborig']  = $this->padLeftZero($aRPSD10['si189_codunidadesuborig'], strlen($aRPSD10['si189_codunidadesuborig']) > 5 ? 8 : 5);
        $aCSVRPSD10['si189_nroempenho']   = substr($aRPSD10['si189_nroempenho'], 0, 22);
        $aCSVRPSD10['si189_exercicioempenho']             = substr($aRPSD10['si189_exercicioempenho'], 0, 4);
        $aCSVRPSD10['si189_dtempenho']         = $this->sicomDate($aRPSD10['si189_dtempenho']);
        $aCSVRPSD10['si189_tipopagamentorsp']    = $aRPSD10['si189_tipopagamentorsp'];
        $aCSVRPSD10['si189_vlpagorsp']     = $this->sicomNumberReal($aRPSD10['si189_vlpagorsp'], 2);

        $this->sLinha = $aCSVRPSD10;
        $this->adicionaLinha();

        for ($iCont2 = 0; $iCont2 < pg_num_rows($rsRPSD11); $iCont2++) {

          $aRPSD11 = pg_fetch_array($rsRPSD11, $iCont2);

          if ($aRPSD10['si189_sequencial'] == $aRPSD11['si190_reg10']) {

            $aCSVRPSD11['si190_tiporegistro']    = $this->padLeftZero($aRPSD11['si190_tiporegistro'], 2);
            $aCSVRPSD11['si190_codreduzidorsp']  = substr($aRPSD11['si190_codreduzidorsp'], 0, 15);
            $aCSVRPSD11['si190_codfontrecursos'] = $this->padLeftZero($aRPSD11['si190_codfontrecursos'], 3);
            $aCSVRPSD11['si190_vlpagofontersp']  = $this->sicomNumberReal($aRPSD11['si190_vlpagofontersp'], 2);

            $this->sLinha = $aCSVRPSD11;
            $this->adicionaLinha();

          }

        }
      }

      $this->fechaArquivo();

    }

  }

}
