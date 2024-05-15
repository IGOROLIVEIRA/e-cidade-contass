<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarAEX extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;

  public function gerarDados()
  {

    $this->sArquivo = "AEX";
    $this->abreArquivo();

//    $sSql = "select * from aex102021 where si129_mes = " . $this->iMes;
//    $rsAEX10 = db_query($sSql);

    $sSql2 = "select * from aex102021 where si130_mes = " . $this->iMes;
    $rsAEX10 = db_query($sSql2);


    if (pg_num_rows($rsAEX10) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {

      for ($iCont2 = 0; $iCont2 < pg_num_rows($rsAEX10); $iCont2++) {

        $aAEX10 = pg_fetch_array($rsAEX10, $iCont2);

        $aCSVAEX10['si130_tiporegistro']    = $this->padLeftZero($aAEX10['si130_tiporegistro'], 2);
        $aCSVAEX10['si130_codext']          = substr($aAEX10['si130_codext'], 0, 15);
        $aCSVAEX10['si130_codfontrecursos'] = $this->padLeftZero($aAEX10['si130_codfontrecursos'], 3);
        $aCSVAEX10['si130_nroop']           = substr($aAEX10['si130_nroop'], 0, 22);
        $aCSVAEX10['si130_codunidadesub']   = $this->padLeftZero($aAEX10['si130_codunidadesub'], (strlen($aAEX10['si130_codunidadesub']) <= 5 ? 5 : 8));
        $aCSVAEX10['si130_dtpagamento']     = $this->sicomDate($aAEX10['si130_dtpagamento']);
        $aCSVAEX10['si130_nroanulacaoop']   = substr($aAEX10['si130_nroanulacaoop'], 0, 22);
        $aCSVAEX10['si130_dtanulacaoop']    = $this->sicomDate($aAEX10['si130_dtanulacaoop']);
        $aCSVAEX10['si130_vlanulacaoop']    = $this->sicomNumberReal(abs($aAEX10['si130_vlanulacaoop']), 2);

        $this->sLinha = $aCSVAEX10;
        $this->adicionaLinha();

      }

      $this->fechaArquivo();
    }
  }
}
