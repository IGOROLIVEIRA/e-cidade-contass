<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarORGAO extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;
  
  public function gerarDados()
  {

    $this->sArquivo = "ORGAO";
    $this->abreArquivo();

    $sSql = "select * from orgao102020 where si14_mes = " . $this->iMes . " and si14_instit = " . db_getsession("DB_instit");
    $rsORGAO10 = db_query($sSql);

    $sSql2 = "select * from orgao112020 where si15_mes = " . $this->iMes . " and si15_instit = " . db_getsession("DB_instit");
    $rsORGAO11 = db_query($sSql2);

    if (pg_num_rows($rsORGAO10) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {

      for ($iCont = 0; $iCont < pg_num_rows($rsORGAO10); $iCont++) {

        $aORGAO10 = pg_fetch_array($rsORGAO10, $iCont, PGSQL_ASSOC);

        $aCSVORGAO10['si14_tiporegistro']               = $this->padLeftZero($aORGAO10['si14_tiporegistro'], 2);
        $aCSVORGAO10['si14_codorgao']                   = $this->padLeftZero($aORGAO10['si14_codorgao'], 2);
        $aCSVORGAO10['si14_tipoorgao']                  = $this->padLeftZero($aORGAO10['si14_tipoorgao'], 2);
        $aCSVORGAO10['si14_cnpjorgao']                  = $this->padLeftZero($aORGAO10['si14_cnpjorgao'], 14);
        $aCSVORGAO10['si14_tipodocumentofornsoftware']  = $this->padLeftZero($aORGAO10['si14_tipodocumentofornsoftware'], 1);
        $aCSVORGAO10['si14_nrodocumentofornsoftware']   = $this->padLeftZero($aORGAO10['si14_nrodocumentofornsoftware'], 14);
        $aCSVORGAO10['si14_versaosoftware']             = substr($aORGAO10['si14_versaosoftware'], 0, 50);
        $aCSVORGAO10['si14_assessoriacontabil']         = $this->padLeftZero($aORGAO10['si14_assessoriacontabil'], 1);
        $aCSVORGAO10['si14_tipodocumentoassessoria']    = $aORGAO10['si14_tipodocumentoassessoria'];
        $aCSVORGAO10['si14_nrodocumentoassessoria']     = substr($aORGAO10['si14_nrodocumentoassessoria'], 0, 14);

        $this->sLinha = $aCSVORGAO10;
        $this->adicionaLinha();

        for ($iCont2 = 0; $iCont2 < pg_num_rows($rsORGAO11); $iCont2++) {

          $aORGAO11 = pg_fetch_array($rsORGAO11, $iCont2);

          if ($aORGAO10['si14_sequencial'] == $aORGAO11['si15_reg10']) {

            $aCSVORGAO11['si15_tiporegistro']       = $this->padLeftZero($aORGAO11['si15_tiporegistro'], 2);
            $aCSVORGAO11['si15_tiporesponsavel']    = $this->padLeftZero($aORGAO11['si15_tiporesponsavel'], 2);
            $aCSVORGAO11['si15_cartident']          = substr($aORGAO11['si15_cartident'], 0, 10);
            $aCSVORGAO11['si15_orgemissorci']       = substr($aORGAO11['si15_orgemissorci'], 0, 10);
            $aCSVORGAO11['si15_cpf']                = substr($aORGAO11['si15_cpf'], 0, 11);
            $aCSVORGAO11['si15_crccontador']        = substr($aORGAO11['si15_crccontador'], 0, 11);
            $aCSVORGAO11['si15_ufcrccontador']      = substr($aORGAO11['si15_ufcrccontador'], 0, 2);
            $aCSVORGAO11['si15_cargoorddespdeleg']  = substr($aORGAO11['si15_cargoorddespdeleg'], 0, 50);
            $aCSVORGAO11['si15_dtinicio']           = $this->sicomDate($aORGAO11['si15_dtinicio']);
            $aCSVORGAO11['si15_dtfinal']            = $this->sicomDate($aORGAO11['si15_dtfinal']);
            $aCSVORGAO11['si15_email']              = substr($aORGAO11['si15_email'], 0, 50);

            $this->sLinha = $aCSVORGAO11;
            $this->adicionaLinha();

          }

        }
      }

      $this->fechaArquivo();

    }

  }

}
