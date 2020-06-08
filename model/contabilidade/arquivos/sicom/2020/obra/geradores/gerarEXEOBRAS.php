<?php
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");
/**
 * Sicom Acompanhamento Mensal
 * @author Mario Junior
 * @package Obras
 */

class gerarEXEOBRAS extends GerarAM
{
  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;

  public function gerarDados()
  {

    $this->sArquivo = "EXEOBRAS";
    $this->abreArquivo();

    $sSql = "select * from exeobras102020 where si197_mes = " . $this->iMes . " and si197_instit=" . db_getsession("DB_instit");
    $rsexeobras102020 = db_query($sSql);

    if (pg_num_rows($rsexeobras102020) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {

      /**
       *
       * Registros 10
       */
      for ($iCont = 0; $iCont < pg_num_rows($rsexeobras102020); $iCont++) {

        $aEXEOBRAS10 = pg_fetch_array($rsexeobras102020, $iCont);

        $aCSVEXEOBRAS10['si197_tiporegistro'] = str_pad($aEXEOBRAS10['si197_tiporegistro'], 3, "0", STR_PAD_LEFT);
        $aCSVEXEOBRAS10['si197_codorgao'] = str_pad($aEXEOBRAS10['si197_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVEXEOBRAS10['si197_codunidadesub'] = substr($aEXEOBRAS10['si197_codunidadesub'], 0, 8);
        $aCSVEXEOBRAS10['si197_nrocontrato'] = $aEXEOBRAS10['si197_nrocontrato'];
        $aCSVEXEOBRAS10['si197_exerciciolicitacao'] = $aEXEOBRAS10['si197_exerciciolicitacao'];
        $aCSVEXEOBRAS10['si197_codobra'] = $aEXEOBRAS10['si197_codobra'];
        $aCSVEXEOBRAS10['si197_objeto'] = $aEXEOBRAS10['si197_objeto'];
        $aCSVEXEOBRAS10['si197_linkobra'] = $aEXEOBRAS10['si197_linkobra'];
        $this->sLinha = $aCSVEXEOBRAS10;
        $this->adicionaLinha();
      }
    }
    $this->fechaArquivo();
  }
}
