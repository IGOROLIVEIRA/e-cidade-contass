<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarPARTLIC extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;

  public function gerarDados()
  {

    $this->sArquivo = "PARTLIC";
    $this->abreArquivo();

    $sSql = "select * from PARTLIC102023 where si203_mes = " . $this->iMes . " and si203_instit=" . db_getsession("DB_instit");
    $rsPARTLIC10 = db_query($sSql);

  
    if (pg_num_rows($rsPARTLIC10) == 0 && pg_num_rows($rsPARTLIC10) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();
    } else {

      /**
       *
       * Registros 10 e 11
       */
      for ($iCont = 0; $iCont < pg_num_rows($rsPARTLIC10); $iCont++) {

        $aPARTLIC10 = pg_fetch_array($rsPARTLIC10, $iCont);

        $aCSVPARTLIC10['si203_tiporegistro']                        = $this->padLeftZero($aPARTLIC10['si203_tiporegistro'], 2);
        $aCSVPARTLIC10['si203_codorgao']                            = $this->padLeftZero($aPARTLIC10['si203_codorgao'], 2);
        $aCSVPARTLIC10['si203_codunidadesub']                       = $this->padLeftZero($aPARTLIC10['si203_codunidadesub'], 5);
        $aCSVPARTLIC10['si203_exerciciolicitacao']                  = $this->padLeftZero($aPARTLIC10['si203_exerciciolicitacao'], 4);
        $aCSVPARTLIC10['si203_nroprocessolicitatorio']              = substr($aPARTLIC10['si203_nroprocessolicitatorio'], 0, 12);
        $aCSVPARTLIC10['si203_tipodocumento']                       = $this->padLeftZero($aPARTLIC10['si203_tipodocumento'], 1);
        $aCSVPARTLIC10['si203_nrodocumento']                        = substr($aPARTLIC10['si203_nrodocumento'], 0, 14);

        $this->sLinha = $aCSVPARTLIC10;
        $this->adicionaLinha();

        
      }

      $this->fechaArquivo();
    }
  }
}
