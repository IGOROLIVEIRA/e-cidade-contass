<?php
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");
/**
 * Sicom Acompanhamento Mensal
 * @author Mario Junior
 * @package Obras
 */

class gerarLICOBRAS extends GerarAM
{
  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;

  public function gerarDados()
  {

    $this->sArquivo = "LICOBRAS";
    $this->abreArquivo();

    $sSql = "select * from licobras102020 where si195_mes = " . $this->iMes . " and si195_instit=" . db_getsession("DB_instit");
    $rslicobras102020 = db_query($sSql);
//db_criatabela($rslicobras102020);exit;
    $sSql = "select * from licobras202020 where si196_mes = " . $this->iMes . " and si196_instit=" . db_getsession("DB_instit");
    $rslicobras202020 = db_query($sSql);

    if (pg_num_rows($rslicobras102020) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {

      /**
       *
       * Registros 10
       */
      for ($iCont = 0; $iCont < pg_num_rows($rslicobras102020); $iCont++) {

        $alICOBRAS10 = pg_fetch_array($rslicobras102020, $iCont);

        $aCSVLICOBRAS10['si195_tiporegistro'] = str_pad($alICOBRAS10['si195_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVLICOBRAS10['si195_codorgaoresp'] = substr($alICOBRAS10['si195_codorgaoresp'], 0, 2);
        $aCSVLICOBRAS10['si195_codunidadesubrespestadual'] = $alICOBRAS10['si195_codunidadesubrespestadual'];
        $aCSVLICOBRAS10['si195_exerciciolicitacao'] = $alICOBRAS10['si195_exerciciolicitacao'];
        $aCSVLICOBRAS10['si195_nroprocessolicitatorio'] = $alICOBRAS10['si195_nroprocessolicitatorio'];
        $aCSVLICOBRAS10['si195_codobra'] = $alICOBRAS10['si195_codobra'];
        $aCSVLICOBRAS10['si195_objeto'] = $alICOBRAS10['si195_objeto'];
        $aCSVLICOBRAS10['si195_linkobra'] = $alICOBRAS10['si195_linkobra'];
        $this->sLinha = $aCSVLICOBRAS10;
        $this->adicionaLinha();
      }
    }

    if (pg_num_rows($rslicobras202020) == 0) {

//      $aCSV['tiporegistro'] = '99';
//      $this->sLinha = $aCSV;
//      $this->adicionaLinha();

    } else {

      /**
       *
       * Registros 20
       */
      for ($iCont = 0; $iCont < pg_num_rows($rslicobras202020); $iCont++) {

        $aLICOBRAS20 = pg_fetch_array($rslicobras202020, $iCont);

        $aCSVLICOBRAS20['si196_tiporegistro'] = str_pad($aLICOBRAS20['si196_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVLICOBRAS20['si196_codorgaoresp'] = substr($aLICOBRAS20['si196_codorgaoresp'], 0, 2);
        $aCSVLICOBRAS20['si196_codunidadesubrespestadual'] = $aLICOBRAS20['si196_codunidadesubrespestadual'];
        $aCSVLICOBRAS20['si196_codunidadesubrespestadual'] = $aLICOBRAS20['si196_codunidadesubrespestadual'];
        $aCSVLICOBRAS20['si196_exerciciolicitacao'] = $aLICOBRAS20['si196_exerciciolicitacao'];
        $aCSVLICOBRAS20['si196_nroprocessolicitatorio'] = $aLICOBRAS20['si196_nroprocessolicitatorio'];
        $aCSVLICOBRAS20['si196_codobra'] = $aLICOBRAS20['si196_codobra'];
        $aCSVLICOBRAS20['si196_objeto'] = $aLICOBRAS20['si196_objeto'];
        $aCSVLICOBRAS20['si196_linkobra'] = $aLICOBRAS20['si196_linkobra'];
        $this->sLinha = $aCSVLICOBRAS20;
        $this->adicionaLinha();
      }
    }
    $this->fechaArquivo();
  }
}
