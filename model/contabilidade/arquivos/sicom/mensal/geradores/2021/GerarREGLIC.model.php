<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarREGLIC extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;
  
  public function gerarDados()
  {

    $this->sArquivo = "REGLIC";
    $this->abreArquivo();
    
    $sSql = "select * from reglic102020 where si44_mes = " . $this->iMes . " and si44_instit=" . db_getsession("DB_instit");
    $rsREGLIC10 = db_query($sSql);

    $sSql2 = "select * from reglic202020 where si45_mes = " . $this->iMes . " and si45_instit=" . db_getsession("DB_instit");
    $rsREGLIC20 = db_query($sSql2);

    if (pg_num_rows($rsREGLIC10) == 0 && pg_num_rows($rsREGLIC20) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {

      /**
       *
       * Registros 10
       */
      for ($iCont = 0; $iCont < pg_num_rows($rsREGLIC10); $iCont++) {

        $aREGLIC10 = pg_fetch_array($rsREGLIC10, $iCont);

        $aCSVREGLIC10['si44_tiporegistro']                    = $this->padLeftZero($aREGLIC10['si44_tiporegistro'], 2);
        $aCSVREGLIC10['si44_codorgao']                        = $this->padLeftZero($aREGLIC10['si44_codorgao'], 2);
        $aCSVREGLIC10['si44_tipodecreto']                     = $this->padLeftZero($aREGLIC10['si44_tipodecreto'], 1);
        $aCSVREGLIC10['si44_nrodecretomunicipal']             = substr($aREGLIC10['si44_nrodecretomunicipal'], 0, 8);
        $aCSVREGLIC10['si44_datadecretomunicipal']            = $this->sicomDate($aREGLIC10['si44_datadecretomunicipal']);
        $aCSVREGLIC10['si44_datapublicacaodecretomunicipal']  = $this->sicomDate($aREGLIC10['si44_datapublicacaodecretomunicipal']);

        $this->sLinha = $aCSVREGLIC10;
        $this->adicionaLinha();

      }

      /**
       *
       * Registros 20
       */
      for ($iCont2 = 0; $iCont2 < pg_num_rows($rsREGLIC20); $iCont2++) {

        $aREGLIC20 = pg_fetch_array($rsREGLIC20, $iCont2);

        $aCSVREGLIC20['si45_tiporegistro']                = $this->padLeftZero($aREGLIC20['si45_tiporegistro'], 2);
        $aCSVREGLIC20['si45_codorgao']                    = $this->padLeftZero($aREGLIC20['si45_codorgao'], 2);
        $aCSVREGLIC20['si45_regulamentart47']             = $this->padLeftZero($aREGLIC20['si45_regulamentart47'], 1);
        $aCSVREGLIC20['si45_nronormareg']                 = substr($aREGLIC20['si45_nronormareg'], 0, 6);
        $aCSVREGLIC20['si45_dataleialterorcam']           = $this->sicomDate($aREGLIC20['si45_datanormareg']);
        $aCSVREGLIC20['si45_datapubnormareg']             = $this->sicomDate($aREGLIC20['si45_datanormareg']);
        $aCSVREGLIC20['si45_regexclusiva']                = $this->padLeftZero($aREGLIC20['si45_regexclusiva'], 1);
        $aCSVREGLIC20['si45_artigoregexclusiva']          = substr($aREGLIC20['si45_artigoregexclusiva'], 0, 6);
        $aCSVREGLIC20['si45_valorlimiteregexclusiva']     = $this->sicomNumberReal($aREGLIC20['si45_valorlimiteregexclusiva'], 2);
        $aCSVREGLIC20['si45_proccubcontratacao']          = $this->padLeftZero($aREGLIC20['si45_proccubcontratacao'], 1);
        $aCSVREGLIC20['si45_artigoprocsubcontratacao']    = substr($aREGLIC20['si45_artigoprocsubcontratacao'], 0, 6);
        $aCSVREGLIC20['si45_percentualsubcontratacao']    = $this->sicomNumberReal($aREGLIC20['si45_percentualsubcontratacao'], 2);
        $aCSVREGLIC20['si45_criteriosempenhopagamento']   = $this->padLeftZero($aREGLIC20['si45_criteriosempenhopagamento'], 1);
        $aCSVREGLIC20['si45_artigoempenhopagamento']      = substr($aREGLIC20['si45_artigoempenhopagamento'], 0, 6);
        $aCSVREGLIC20['si45_estabeleceuperccontratacao']  = $this->padLeftZero($aREGLIC20['si45_estabeleceuperccontratacao'], 1);
        $aCSVREGLIC20['si45_artigoperccontratacao']       = substr($aREGLIC20['si45_artigoperccontratacao'], 0, 6);
        $aCSVREGLIC20['si45_percentualcontratacao']       = $this->sicomNumberReal($aREGLIC20['si45_percentualcontratacao'], 2);
        

        $this->sLinha = $aCSVREGLIC20;
        $this->adicionaLinha();

      }

    }

    $this->fechaArquivo();

  }

}
