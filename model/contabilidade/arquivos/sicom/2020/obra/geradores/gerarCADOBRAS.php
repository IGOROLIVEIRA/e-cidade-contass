<?php
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");
/**
 * Sicom Acompanhamento Mensal
 * @author Mario Junior
 * @package Obras
 */

class gerarCADOBRAS extends GerarAM
{
  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;

  public function gerarDados()
  {

    $this->sArquivo = "CADOBRAS";
    $this->abreArquivo();

    $sSql = "select * from cadobras102020 where si198_mes = " . $this->iMes . " and si198_instit=" . db_getsession("DB_instit");
    $rscadobras102020 = db_query($sSql);

    $sSql = "select * from cadobras202020 where si199_mes = " . $this->iMes . " and si199_instit=" . db_getsession("DB_instit") ." order by si199_codobra";
    $rscadobras202020 = db_query($sSql);

    $sSql = "select * from cadobras212020 where si200_mes = " . $this->iMes . " and si200_instit=" . db_getsession("DB_instit");
    $rscadobras212020 = db_query($sSql);

    $sSql = "select * from cadobras302020 where si201_mes = " . $this->iMes . " and si201_instit=" . db_getsession("DB_instit");
    $rscadobras302020 = db_query($sSql);

    /**
     *
     * Registros 10
     */
    if(pg_num_rows($rscadobras102020) == 0 && pg_num_rows($rscadobras202020) == 0 && pg_num_rows($rscadobras212020) == 0 && pg_num_rows($rscadobras302020) == 0 ){
      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();
    }else {
        for ($iCont = 0; $iCont < pg_num_rows($rscadobras102020); $iCont++) {

            $aCADORBRAS10 = pg_fetch_array($rscadobras102020, $iCont);

            $aCSVCADOBRAS10['si198_tiporegistro'] = $aCADORBRAS10['si198_tiporegistro'];
            $aCSVCADOBRAS10['si198_codorgaoresp'] = str_pad($aCADORBRAS10['si198_codorgaoresp'],3,"0",STR_PAD_LEFT);
            $aCSVCADOBRAS10['si198_codobra'] = $aCADORBRAS10['si198_codobra'];
            $aCSVCADOBRAS10['si198_tiporesponsavel'] = $aCADORBRAS10['si198_tiporesponsavel'];
            $aCSVCADOBRAS10['si198_nrodocumento'] = $aCADORBRAS10['si198_nrodocumento'];
            $aCSVCADOBRAS10['si198_tiporegistroconselho'] = $aCADORBRAS10['si198_tiporegistroconselho'];
            $aCSVCADOBRAS10['si198_nroregistroconseprof'] = $aCADORBRAS10['si198_nroregistroconseprof'];
            $aCSVCADOBRAS10['si198_numrt'] = $aCADORBRAS10['si198_numrt'] == "0" ? "" : $aCADORBRAS10['si198_numrt'];
            $aCSVCADOBRAS10['si198_dtinicioatividadeseng'] = $this->sicomDate($aCADORBRAS10['si198_dtinicioatividadeseng']);
            $aCSVCADOBRAS10['si198_tipovinculo'] = $aCADORBRAS10['si198_tipovinculo'];
            $this->sLinha = $aCSVCADOBRAS10;
            $this->adicionaLinha();
        }

        /**
         *
         * Registros 20
         */

        for ($iCont20 = 0; $iCont20 < pg_num_rows($rscadobras202020); $iCont20++) {

            $aCADORBRAS20 = pg_fetch_array($rscadobras202020, $iCont20);

            $aCSVCADOBRAS20['si199_tiporegistro'] = $aCADORBRAS20['si199_tiporegistro'];
            $aCSVCADOBRAS20['si199_codorgaoresp'] = str_pad($aCADORBRAS20['si199_codorgaoresp'], 3, "0", STR_PAD_LEFT);
            $aCSVCADOBRAS20['si199_codobra'] = $aCADORBRAS20['si199_codobra'];
            $aCSVCADOBRAS20['si199_situacaodaobra'] = $aCADORBRAS20['si199_situacaodaobra'];
            $aCSVCADOBRAS20['si199_dtsituacao'] = $this->sicomDate($aCADORBRAS20['si199_dtsituacao']);
            $aCSVCADOBRAS20['si199_veiculopublicacao'] = $aCADORBRAS20['si199_veiculopublicacao'];
            $aCSVCADOBRAS20['si199_dtpublicacao'] = $this->sicomDate($aCADORBRAS20['si199_dtpublicacao']);
            $aCSVCADOBRAS20['si199_descsituacao'] = $aCADORBRAS20['si199_descsituacao'];
            $this->sLinha = $aCSVCADOBRAS20;
            $this->adicionaLinha();


            /**
             *
             * Registros 21
             */
            if($aCADORBRAS20['si199_situacaodaobra'] == "4" || $aCADORBRAS20['si199_situacaodaobra'] == "3") {
                for ($iCont21 = 0; $iCont21 < pg_num_rows($rscadobras212020); $iCont21++) {

                    $aCADORBRAS21 = pg_fetch_array($rscadobras212020, $iCont21);

                    if ($aCADORBRAS21['si200_codobra'] == $aCADORBRAS20['si199_codobra']) {
                        if ($aCADORBRAS21['si200_codobra'] == $aCADORBRAS20['si199_codobra']) {
                            $aCSVCADOBRAS21['si200_tiporegistro'] = $aCADORBRAS21['si200_tiporegistro'];
                            $aCSVCADOBRAS21['si200_codorgaoresp'] = str_pad($aCADORBRAS21['si200_codorgaoresp'], 3, "0", STR_PAD_LEFT);
                            $aCSVCADOBRAS21['si200_codobra'] = $aCADORBRAS21['si200_codobra'];
                            $aCSVCADOBRAS21['si200_dtparalisacao'] = $this->sicomDate($aCADORBRAS21['si200_dtparalisacao']);
                            $aCSVCADOBRAS21['si200_motivoparalisacap'] = str_pad($aCADORBRAS21['si200_motivoparalisacap'], 2, "0", STR_PAD_LEFT);
                            $aCSVCADOBRAS21['si200_descoutrosparalisacao'] = $aCADORBRAS21['si200_descoutrosparalisacao'];
                            $aCSVCADOBRAS21['si200_dtretomada'] = $this->sicomDate($aCADORBRAS21['si200_dtretomada']) == "" ? " ;" : $this->sicomDate($aCADORBRAS21['si200_dtretomada']);
                            $this->sLinha = $aCSVCADOBRAS21;
                            $this->adicionaLinha();
                        }
                    }
                }
            }
        }

        /**
         *
         * Registros 30
         */

        for ($iCont = 0; $iCont < pg_num_rows($rscadobras302020); $iCont++) {

            $aCADORBRAS30 = pg_fetch_array($rscadobras302020, $iCont);

            $aCSVCADOBRAS30['si201_tiporegistro'] = str_pad($aCADORBRAS30['si201_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVCADOBRAS30['si201_codorgaoresp'] = str_pad($aCADORBRAS30['si201_codorgaoresp'], 3, "0",STR_PAD_LEFT);
            $aCSVCADOBRAS30['si201_codobra'] = $aCADORBRAS30['si201_codobra'];
            $aCSVCADOBRAS30['si201_tipomedicao'] = $aCADORBRAS30['si201_tipomedicao'];
            $aCSVCADOBRAS30['si201_descoutrostiposmed'] = $aCADORBRAS30['si201_descoutrostiposmed'];
            $aCSVCADOBRAS30['si201_nummedicao'] = $aCADORBRAS30['si201_nummedicao'];
            $aCSVCADOBRAS30['si201_descmedicao'] = $aCADORBRAS30['si201_descmedicao'];
            $aCSVCADOBRAS30['si201_dtiniciomedicao'] = $this->sicomDate($aCADORBRAS30['si201_dtiniciomedicao']);
            $aCSVCADOBRAS30['si201_dtfimmedicao'] = $this->sicomDate($aCADORBRAS30['si201_dtfimmedicao']);
            $aCSVCADOBRAS30['si201_dtmedicao'] = $this->sicomDate($aCADORBRAS30['si201_dtmedicao']);
            $aCSVCADOBRAS30['si201_valormedicao'] = number_format($aCADORBRAS30['si201_valormedicao'], 2, ",", "");
            $this->sLinha = $aCSVCADOBRAS30;
            $this->adicionaLinha();
        }
    }
    $this->fechaArquivo();
  }
}
