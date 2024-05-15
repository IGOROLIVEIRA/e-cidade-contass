<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarOPS extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;

  public function gerarDados()
  {

    $this->sArquivo = "OPS";
    $this->abreArquivo();

    $sSql = "select * from ops102020 where si132_mes = " . $this->iMes . " and si132_instit = " . db_getsession("DB_instit");
    $rsOPS10 = db_query($sSql);

    $sSql2 = "SELECT DISTINCT si133_sequencial,
                     si133_tiporegistro,
                     si133_codreduzidoop,
                     si133_codunidadesub,
                     si133_nroop,
                     si133_dtpagamento,
                     si133_tipopagamento,
                     e60_codemp AS si133_nroempenho,
                     si133_dtempenho,
                     si133_nroliquidacao,
                     si133_dtliquidacao,
                     si133_codfontrecursos,
                     si133_valorfonte,
                     si133_tipodocumentocredor,
                     si133_nrodocumento,
                     si133_codorgaoempop,
                     si133_codunidadeempop,
                     si133_mes,
                     si133_reg10,
                     si133_instit
              FROM ops112020
              INNER JOIN empempenho ON e60_codemp::int8 = si133_nroempenho AND e60_emiss = si133_dtempenho
              WHERE si133_mes = " . $this->iMes . "
                AND si133_instit = " . db_getsession("DB_instit");
    $rsOPS11 = db_query($sSql2);

    $sSql3 = "select * from ops122020 where si134_mes = " . $this->iMes . " and si134_instit = " . db_getsession("DB_instit");
    $rsOPS12 = db_query($sSql3);

    $sSql4 = "select * from ops132020 where si135_mes = " . $this->iMes . " and si135_instit = " . db_getsession("DB_instit");
    $rsOPS13 = db_query($sSql4);

    $sSql5 = "select * from ops142020 where si136_mes = " . $this->iMes . " and si136_instit = " . db_getsession("DB_instit");
    $rsOPS14 = db_query($sSql5);

    if (pg_num_rows($rsOPS10) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {

      /**
       *
       * Registros 10, 11, 12 , 13, 14
       */
      for ($iCont = 0; $iCont < pg_num_rows($rsOPS10); $iCont++) {

        $aOPS10 = pg_fetch_array($rsOPS10, $iCont);

        $aCSVOPS10['si132_tiporegistro']    = $this->padLeftZero($aOPS10['si132_tiporegistro'], 2);
        $aCSVOPS10['si132_codorgao']        = $this->padLeftZero($aOPS10['si132_codorgao'], 2);
        $aCSVOPS10['si132_codunidadesub']   = $this->padLeftZero($aOPS10['si132_codunidadesub'], 5);
        $aCSVOPS10['si132_nroop']           = substr($aOPS10['si132_nroop'], 0, 22);
        $aCSVOPS10['si132_dtpagamento']     = $this->sicomDate($aOPS10['si132_dtpagamento']);
        $aCSVOPS10['si132_vlop']            = $this->sicomNumberReal($aOPS10['si132_vlop'], 2);
        $aCSVOPS10['si132_especificacaoop'] = substr($aOPS10['si132_especificacaoop'], 0, 500);
        $aCSVOPS10['si132_cpfresppgto']     = $this->padLeftZero($aOPS10['si132_cpfresppgto'], 11);

        $this->sLinha = $aCSVOPS10;
        $this->adicionaLinha();

        for ($iCont2 = 0; $iCont2 < pg_num_rows($rsOPS11); $iCont2++) {

          $aOPS11 = pg_fetch_array($rsOPS11, $iCont2);

          if ($aOPS10['si132_sequencial'] == $aOPS11['si133_reg10']) {

            $aCSVOPS11['si133_tiporegistro']        = $this->padLeftZero($aOPS11['si133_tiporegistro'], 2);
            $aCSVOPS11['si133_codreduzidoop']       = substr($aOPS11['si133_codreduzidoop'], 0, 15);
            $aCSVOPS11['si133_codunidadesub']       = $this->padLeftZero($aOPS11['si133_codunidadesub'], 5);
            $aCSVOPS11['si133_nroop']               = substr($aOPS11['si133_nroop'], 0, 22);
            $aCSVOPS11['si133_dtpagamento']         = $this->sicomDate($aOPS11['si133_dtpagamento']);
            $aCSVOPS11['si133_tipopagamento']       = $this->padLeftZero($aOPS11['si133_tipopagamento'], 1);
            $aCSVOPS11['si133_nroempenho']          = substr($aOPS11['si133_nroempenho'], 0, 22);
            $aCSVOPS11['si133_dtempenho']           = $this->sicomDate($aOPS11['si133_dtempenho']);
            $aCSVOPS11['si133_nroliquidacao']       = substr($aOPS11['si133_nroliquidacao'], 0, 22) == 0 ? "" : substr($aOPS11['si133_nroliquidacao'], 0, 22);
            $aCSVOPS11['si133_dtliquidacao']        = $this->sicomDate($aOPS11['si133_dtliquidacao']);
            $aCSVOPS11['si133_codfontrecursos']     = $this->padLeftZero($aOPS11['si133_codfontrecursos'], 3);
            $aCSVOPS11['si133_valorfonte']          = $this->sicomNumberReal($aOPS11['si133_valorfonte'], 2);
            $aCSVOPS11['si133_tipodocumentocredor'] = $this->padLeftZero($aOPS11['si133_tipodocumentocredor'], 1);
            $aCSVOPS11['si133_nrodocumento']        = substr($aOPS11['si133_nrodocumento'], 0, 14);
            $aCSVOPS11['si133_codorgaoempop']       = " ";
            $aCSVOPS11['si133_codunidadeempop']     = " ";

            $this->sLinha = $aCSVOPS11;
            $this->adicionaLinha();
          }

        }

        for ($iCont3 = 0; $iCont3 < pg_num_rows($rsOPS12); $iCont3++) {

          $aOPS12 = pg_fetch_array($rsOPS12, $iCont3);

          if ($aOPS10['si132_sequencial'] == $aOPS12['si134_reg10']) {

            $aCSVOPS12['si134_tiporegistro']        = $this->padLeftZero($aOPS12['si134_tiporegistro'], 2);
            $aCSVOPS12['si134_codreduzidoop']       = substr($aOPS12['si134_codreduzidoop'], 0, 15);
            $aCSVOPS12['si134_tipodocumentoop']     = $this->padLeftZero(substr($aOPS12['si134_tipodocumentoop'], 0, 2), 2);
            $aCSVOPS12['si134_nrodocumento']        = $aOPS12['si134_nrodocumento'] == '' ? " " : substr($aOPS12['si134_nrodocumento'], 0, 15);
            $aCSVOPS12['si134_codctb']              = substr($aOPS12['si134_codctb'], 0, 20) == 0 ? " " : substr($aOPS12['si134_codctb'], 0, 20);
            $aCSVOPS12['si134_codfontectb']         = $this->padLeftZero($aOPS12['si134_codfontectb'], 3) == 0 ? " " : $this->padLeftZero($aOPS12['si134_codfontectb'], 3);
            $aCSVOPS12['si134_desctipodocumentoop'] = substr($aOPS12['si134_desctipodocumentoop'], 0, 50);
            $aCSVOPS12['si134_dtemissao']           = $this->sicomDate($aOPS12['si134_dtemissao']);
            $aCSVOPS12['si134_vldocumento']         = $this->sicomNumberReal($aOPS12['si134_vldocumento'], 2);

            $this->sLinha = $aCSVOPS12;
            $this->adicionaLinha();

          }

        }

        for ($iCont4 = 0; $iCont4 < pg_num_rows($rsOPS13); $iCont4++) {

          $aOPS13 = pg_fetch_array($rsOPS13, $iCont4);

          if ($aOPS10['si132_sequencial'] == $aOPS13['si135_reg10']) {

            $aCSVOPS13['si135_tiporegistro']      = $this->padLeftZero($aOPS13['si135_tiporegistro'], 2);
            $aCSVOPS13['si135_codreduzidoop']     = substr($aOPS13['si135_codreduzidoop'], 0, 15);
            $aCSVOPS13['si135_tiporetencao']      = $this->padLeftZero($aOPS13['si135_tiporetencao'], 4);
            $aCSVOPS13['si135_descricaoretencao'] = substr($aOPS13['si135_descricaoretencao'], 0, 50);
            $aCSVOPS13['si135_vlretencao']        = $this->sicomNumberReal($aOPS13['si135_vlretencao'], 2);

            $this->sLinha = $aCSVOPS13;
            $this->adicionaLinha();

          }

        }

        for ($iCont5 = 0; $iCont5 < pg_num_rows($rsOPS14); $iCont5++) {

          $aOPS14 = pg_fetch_array($rsOPS14, $iCont5);

          if ($aOPS10['si132_sequencial'] == $aOPS14['si136_reg10']) {

            $aCSVOPS14['si136_tiporegistro']          = $this->padLeftZero($aOPS14['si136_tiporegistro'], 2);
            $aCSVOPS14['si136_codreduzidoop']         = substr($aOPS14['si136_codreduzidoop'], 0, 15);
            $aCSVOPS14['si136_tipovlantecipado']      = $this->padLeftZero($aOPS14['si136_tipovlantecipado'], 2);
            $aCSVOPS14['si136_descricaovlantecipado'] = substr($aOPS14['si136_descricaovlantecipado'], 0, 50);
            $aCSVOPS14['si136_vlantecipado']          = $this->sicomNumberReal($aOPS14['si136_vlantecipado'], 2);

            $this->sLinha = $aCSVOPS14;
            $this->adicionaLinha();
          }

        }

      }

      $this->fechaArquivo();

    }
  }

}
