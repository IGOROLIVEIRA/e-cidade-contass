<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarPESSOA extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;

  public function gerarDados()
  {

    $this->sArquivo = "PESSOA";
    $this->abreArquivo();

    $sSql = "select * from pessoa102020 where si12_mes = " . $this->iMes . " and si12_instit = " . db_getsession("DB_instit");
    $rsPESSOA10 = db_query($sSql);

    if (pg_num_rows($rsPESSOA10) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {

      for ($iCont = 0; $iCont < pg_num_rows($rsPESSOA10); $iCont++) {

        $aPESSOA10 = pg_fetch_array($rsPESSOA10, $iCont, PGSQL_ASSOC);

        unset($aPESSOA10['si12_sequencial']);
        unset($aPESSOA10['si12_mes']);
        unset($aPESSOA10['si12_instit']);

        $aPESSOA10['si12_tiporegistro']           = $this->padLeftZero($aPESSOA10['si12_tiporegistro'], 2);
        $aPESSOA10['si12_tipodocumento']          = $this->padLeftZero($aPESSOA10['si12_tipodocumento'], 1);
        $aPESSOA10['si12_nrodocumento']           = substr($aPESSOA10['si12_nrodocumento'], 0, 14);
        $aPESSOA10['si12_nomerazaosocial']        = substr($aPESSOA10['si12_nomerazaosocial'], 0, 120);
        $aPESSOA10['si12_tipocadastro']           = $this->padLeftZero($aPESSOA10['si12_tipocadastro'], 1);
        $aPESSOA10['si12_justificativaalteracao'] = substr($aPESSOA10['si12_justificativaalteracao'], 0, 100);

        $this->sLinha = $aPESSOA10;
        $this->adicionaLinha();

      }

    }
    $this->fechaArquivo();
  }

} 
