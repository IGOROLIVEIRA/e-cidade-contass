<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarJULGLIC extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;
  
  public function gerarDados()
  {

    $this->sArquivo = "JULGLIC";
    $this->abreArquivo();
    
    $sSql = "select * from julglic102020 where si60_mes = " . $this->iMes . " and si60_instit=" . db_getsession("DB_instit");
    $rsJULGLIC10 = db_query($sSql);

    $sSql2 = "select * from julglic202020 where si61_mes = " . $this->iMes . " and si61_instit=" . db_getsession("DB_instit");
    $rsJULGLIC20 = db_query($sSql2);

  	$sSql3 = "select * from julglic302020 where si62_mes = " . $this->iMes . " and si62_instit=" . db_getsession("DB_instit");
	$rsJULGLIC30 = db_query($sSql3);

    $sSql4 = "select * from julglic402020 where si62_mes = " . $this->iMes . " and si62_instit=" . db_getsession("DB_instit");
    $rsJULGLIC40 = db_query($sSql4);

    if (pg_num_rows($rsJULGLIC10) == 0 && pg_num_rows($rsJULGLIC20) == 0 && pg_num_rows($rsJULGLIC40) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {

      /**
       *
       * Registros 10
       */
      for ($iCont = 0; $iCont < pg_num_rows($rsJULGLIC10); $iCont++) {

        $aJULGLIC10 = pg_fetch_array($rsJULGLIC10, $iCont);

        $aCSVJULGLIC10['si60_tiporegistro']           = $this->padLeftZero($aJULGLIC10['si60_tiporegistro'], 2);
        $aCSVJULGLIC10['si60_codorgao']               = $this->padLeftZero($aJULGLIC10['si60_codorgao'], 2);
        $aCSVJULGLIC10['si60_codunidadesub']          = $this->padLeftZero($aJULGLIC10['si60_codunidadesub'], 5);
        $aCSVJULGLIC10['si60_exerciciolicitacao']     = $this->padLeftZero($aJULGLIC10['si60_exerciciolicitacao'], 4);
        $aCSVJULGLIC10['si60_nroprocessolicitatorio'] = substr($aJULGLIC10['si60_nroprocessolicitatorio'], 0, 12);
        $aCSVJULGLIC10['si60_tipodocumento']          = $this->padLeftZero($aJULGLIC10['si60_tipodocumento'], 1);
        $aCSVJULGLIC10['si60_nrodocumento']           = substr($aJULGLIC10['si60_nrodocumento'], 0, 14);
        $aCSVJULGLIC10['si60_nrolote']                = $aJULGLIC10['si60_nrolote'] == 0 ? ' ' : substr($aJULGLIC10['si60_nrolote'], 0, 4);
        $aCSVJULGLIC10['si60_coditem']                = substr($aJULGLIC10['si60_coditem'], 0, 15);
        $aCSVJULGLIC10['si60_vlunitario']             = $this->sicomNumberReal($aJULGLIC10['si60_vlunitario'], 4);
        $aCSVJULGLIC10['si60_quantidade']             = $this->sicomNumberReal($aJULGLIC10['si60_quantidade'], 4);

        $this->sLinha = $aCSVJULGLIC10;
        $this->adicionaLinha();

      }

      /**
       *
       * Registros 20
       */
      for ($iCont2 = 0; $iCont2 < pg_num_rows($rsJULGLIC20); $iCont2++) {

        $aJULGLIC20 = pg_fetch_array($rsJULGLIC20, $iCont2);

        $aCSVJULGLIC20['si61_tiporegistro']           = $this->padLeftZero($aJULGLIC20['si61_tiporegistro'], 2);
        $aCSVJULGLIC20['si61_codorgao']               = $this->padLeftZero($aJULGLIC20['si61_codorgao'], 2);
        $aCSVJULGLIC20['si61_codunidadesub']          = $this->padLeftZero($aJULGLIC20['si61_codunidadesub'], 5);
        $aCSVJULGLIC20['si61_exerciciolicitacao']     = $this->padLeftZero($aJULGLIC20['si61_exerciciolicitacao'], 4);
        $aCSVJULGLIC20['si61_nroprocessolicitatorio'] = substr($aJULGLIC20['si61_nroprocessolicitatorio'], 0, 12);
        $aCSVJULGLIC20['si61_tipodocumento']          = $this->padLeftZero($aJULGLIC20['si61_tipodocumento'], 1);
        $aCSVJULGLIC20['si61_nrodocumento']           = substr($aJULGLIC20['si61_nrodocumento'], 0, 14);
        $aCSVJULGLIC20['si61_nrolote']                = !$aJULGLIC20['si61_nrolote'] ? '' : substr($aJULGLIC20['si61_nrolote'], 0, 4);
        $aCSVJULGLIC20['si61_coditem']                = substr($aJULGLIC20['si61_coditem'], 0, 15);
        $aCSVJULGLIC20['si61_percdesconto']           = $this->sicomNumberReal($aJULGLIC20['si61_percdesconto'], 2);
        
        $this->sLinha = $aCSVJULGLIC20;
        $this->adicionaLinha();

      }

		/**
		 *
		 * Registros 20
		 */
		for ($iCont3 = 0; $iCont3 < pg_num_rows($rsJULGLIC30); $iCont3++) {

			$aJULGLIC30 = pg_fetch_array($rsJULGLIC30, $iCont3);

			$aCSVJULGLIC30['si62_tiporegistro']           = $this->padLeftZero($aJULGLIC30['si62_tiporegistro'], 2);
			$aCSVJULGLIC30['si62_codorgao']               = $this->padLeftZero($aJULGLIC30['si62_codorgao'], 2);
			$aCSVJULGLIC30['si62_codunidadesub']          = $this->padLeftZero($aJULGLIC30['si62_codunidadesub'], 5);
			$aCSVJULGLIC30['si62_exerciciolicitacao']     = $this->padLeftZero($aJULGLIC30['si62_exerciciolicitacao'], 4);
			$aCSVJULGLIC30['si62_nroprocessolicitatorio'] = substr($aJULGLIC30['si62_nroprocessolicitatorio'], 0, 12);
			$aCSVJULGLIC30['si62_tipodocumento']          = $this->padLeftZero($aJULGLIC30['si62_tipodocumento'], 1);
			$aCSVJULGLIC30['si62_nrodocumento']           = substr($aJULGLIC30['si62_nrodocumento'], 0, 14);
			$aCSVJULGLIC30['si62_nrolote']                = !$aJULGLIC30['si62_nrolote'] ? '' : substr($aJULGLIC30['si62_nrolote'], 0, 4);
			$aCSVJULGLIC30['si62_coditem']                = substr($aJULGLIC30['si62_coditem'], 0, 15);
			$aCSVJULGLIC30['si62_perctaxaadm']           = $this->sicomNumberReal($aJULGLIC30['si62_perctaxaadm'], 2);

			$this->sLinha = $aCSVJULGLIC30;
			$this->adicionaLinha();

		}

      /**
       *
       * Registros 40
       */
      for ($iCont4 = 0; $iCont4 < pg_num_rows($rsJULGLIC40); $iCont4++) {

        $aJULGLIC40 = pg_fetch_array($rsJULGLIC40, $iCont4);

        $aCSVJULGLIC40['si62_tiporegistro']           = $this->padLeftZero($aJULGLIC40['si62_tiporegistro'], 2);
        $aCSVJULGLIC40['si62_codorgao']               = $this->padLeftZero($aJULGLIC40['si62_codorgao'], 2);
        $aCSVJULGLIC40['si62_codunidadesub']          = $this->padLeftZero($aJULGLIC40['si62_codunidadesub'], 5);
        $aCSVJULGLIC40['si62_exerciciolicitacao']     = $this->padLeftZero($aJULGLIC40['si62_exerciciolicitacao'], 4);
        $aCSVJULGLIC40['si62_nroprocessolicitatorio'] = substr($aJULGLIC40['si62_nroprocessolicitatorio'], 0, 12);
        $aCSVJULGLIC40['si62_dtjulgamento']           = $this->sicomDate($aJULGLIC40['si62_dtjulgamento']);
        $aCSVJULGLIC40['si62_presencalicitantes']     = $this->padLeftZero($aJULGLIC40['si62_presencalicitantes'], 1);
        $aCSVJULGLIC40['si62_renunciarecurso']        = $this->padLeftZero($aJULGLIC40['si62_renunciarecurso'], 1);
        
        $this->sLinha = $aCSVJULGLIC40;
        $this->adicionaLinha();

      }

      $this->fechaArquivo();

    }

  }
}
