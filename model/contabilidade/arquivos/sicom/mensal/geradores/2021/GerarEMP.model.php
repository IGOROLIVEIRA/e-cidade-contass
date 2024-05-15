<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarEMP extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;

  public function gerarDados()
  {

    $this->sArquivo = "EMP";
    $this->abreArquivo();

    $sSql = "select * from emp102021 where si106_mes = " . $this->iMes . " and si106_instit = " . db_getsession("DB_instit");
    $rsEMP10 = db_query($sSql);

    $sSql2 = "select * from emp112021 where si107_mes = " . $this->iMes . " and si107_instit = " . db_getsession("DB_instit");
    $rsEMP11 = db_query($sSql2);

    $sSql3 = "select * from emp122021 where si108_mes = " . $this->iMes . " and si108_instit = " . db_getsession("DB_instit");
    $rsEMP12 = db_query($sSql3);

    $sSql4 = "select * from emp202021 where si109_mes = " . $this->iMes . " and si109_instit = " . db_getsession("DB_instit");
    $rsEMP20 = db_query($sSql4);

    $sSql5 = "select * from emp302021 where si206_mes = " . $this->iMes . " and si206_instit = " . db_getsession("DB_instit");
    $rsEMP30 = db_query($sSql5);

    if (pg_num_rows($rsEMP10) == 0 && pg_num_rows($rsEMP20) == 0 && pg_num_rows($rsEMP30) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();
    }

    /**
     *
     * Registros 10, 11, 12
     */
    if (pg_num_rows($rsEMP10) > 0) {
      for ($iCont = 0; $iCont < pg_num_rows($rsEMP10); $iCont++) {

        $aEMP10 = pg_fetch_array($rsEMP10, $iCont);

        $aCSVEMP10['si106_tiporegistro']                  = $this->padLeftZero($aEMP10['si106_tiporegistro'], 2);
        $aCSVEMP10['si106_codorgao']                      = $this->padLeftZero($aEMP10['si106_codorgao'], 2);
        $aCSVEMP10['si106_codunidadesub']                 = $this->padLeftZero($aEMP10['si106_codunidadesub'], 5, strlen($aEMP10['si106_codunidadesub']) > 5 ? 8 : 5);
        $aCSVEMP10['si106_codfuncao']                     = $this->padLeftZero($aEMP10['si106_codfuncao'], 2);
        $aCSVEMP10['si106_codsubfuncao']                  = $this->padLeftZero($aEMP10['si106_codsubfuncao'], 3);
        $aCSVEMP10['si106_codprograma']                   = $this->padLeftZero($aEMP10['si106_codprograma'], 4);
        $aCSVEMP10['si106_idacao']                        = $this->padLeftZero($aEMP10['si106_idacao'], 4);
        $aCSVEMP10['si106_idsubacao']                     = $aEMP10['si106_idsubacao'] == 0 ? ' ' : $this->padLeftZero($aEMP10['si106_idsubacao'], 4);
        $aCSVEMP10['si106_naturezadespesa']               = $this->padLeftZero($aEMP10['si106_naturezadespesa'], 6);
        $aCSVEMP10['si106_subelemento']                   = $this->padLeftZero($aEMP10['si106_subelemento'], 2);
        $aCSVEMP10['si106_nroempenho']                    = substr($aEMP10['si106_nroempenho'], 0, 22);
        $aCSVEMP10['si106_dtempenho']                     = $this->sicomDate($aEMP10['si106_dtempenho']);
        $aCSVEMP10['si106_modalidadeempenho']             = $this->padLeftZero($aEMP10['si106_modalidadeempenho'], 1);
        $aCSVEMP10['si106_tpempenho']                     = $this->padLeftZero($aEMP10['si106_tpempenho'], 2);
        $aCSVEMP10['si106_vlbruto']                       = $this->sicomNumberReal($aEMP10['si106_vlbruto'], 2);
        $aCSVEMP10['si106_especificacaoempenho']          = substr($aEMP10['si106_especificacaoempenho'], 0, 200);
        $aCSVEMP10['si106_despdeccontrato']               = $this->padLeftZero($aEMP10['si106_despdeccontrato'], 1);
        $aCSVEMP10['si106_codorgaorespcontrato']          = $aEMP10['si106_codorgaorespcontrato'] == '' ? ' ' : $this->padLeftZero($aEMP10['si106_codorgaorespcontrato'], 2); // campo 18

        if (strlen($aEMP10['si106_codunidadesubrespcontrato']) > 5) {
          $aCSVEMP10['si106_codunidadesubrespcontrato']     = $aEMP10['si106_codunidadesubrespcontrato'] == '' ? ' ' : $this->padLeftZero($aEMP10['si106_codunidadesubrespcontrato'], 8); // campo 19
        } else {
          $aCSVEMP10['si106_codunidadesubrespcontrato']     = $aEMP10['si106_codunidadesubrespcontrato'] == '' ? ' ' : $this->padLeftZero($aEMP10['si106_codunidadesubrespcontrato'], 5); // campo 19
        }
        $aCSVEMP10['si106_nrocontrato']                   = $aEMP10['si106_nrocontrato'] == 0 ? ' ' : substr($aEMP10['si106_nrocontrato'], 0, 14); // campo 20
        $aCSVEMP10['si106_dtassinaturacontrato']          = $aEMP10['si106_dtassinaturacontrato'] == '' ? ' ' : $this->sicomDate($aEMP10['si106_dtassinaturacontrato']); // campo 21
        $aCSVEMP10['si106_nrosequencialtermoaditivo']     = $aEMP10['si106_nrosequencialtermoaditivo'] == '' ? ' ' : $this->padLeftZero($aEMP10['si106_nrosequencialtermoaditivo'], 2);  // campo 22
        $aCSVEMP10['si106_despdecconvenio']               = $this->padLeftZero($aEMP10['si106_despdecconvenio'], 1);  // campo 23
        $aCSVEMP10['si106_nroconvenio']                   = $aEMP10['si106_nroconvenio'] == '' ? ' ' : substr($aEMP10['si106_nroconvenio'], 0, 30);  // campo 24
        $aCSVEMP10['si106_dataassinaturaconvenio']        = $aEMP10['si106_dataassinaturaconvenio'] == '' ? ' ' : $this->sicomDate($aEMP10['si106_dataassinaturaconvenio']);  // campo 25

        $aCSVEMP10['si106_despdecconvenioconge']          = $this->padLeftZero($aEMP10['si106_despdecconvenioconge'], 1); // campo 26
        $aCSVEMP10['si106_nroconvenioconge']              = $aEMP10['si106_nroconvenioconge'] == 0 ? ' ' : substr($aEMP10['si106_nroconvenioconge'], 0, 30); // campo 27
        $aCSVEMP10['si106_dataassinaturaconvenioconge']   = $aEMP10['si106_dataassinaturaconvenioconge'] == 0 ? ' ' : substr($aEMP10['si106_dataassinaturaconvenioconge'], 0, 30); // campo 28

        $aCSVEMP10['si106_despdeclicitacao']              = $this->padLeftZero($aEMP10['si106_despdeclicitacao'], 1);
        $aCSVEMP10['si106_codorgaoresplicit']             = $aEMP10['si106_codorgaoresplicit'] == '' ? ' ' : $this->padLeftZero($aEMP10['si106_codorgaoresplicit'], 2);

        if (strlen($aEMP10['si106_codunidadesubresplicit']) > 5) {
          $aCSVEMP10['si106_codunidadesubresplicit']        = $aEMP10['si106_codunidadesubresplicit'] == '' ? ' ' : $this->padLeftZero($aEMP10['si106_codunidadesubresplicit'], 8);
        } else {
          $aCSVEMP10['si106_codunidadesubresplicit']        = $aEMP10['si106_codunidadesubresplicit'] == '' ? ' ' : $this->padLeftZero($aEMP10['si106_codunidadesubresplicit'], 5);
        }
        $aCSVEMP10['si106_nroprocessolicitatorio']        = $aEMP10['si106_nroprocessolicitatorio'] == '' ? ' ' : substr($aEMP10['si106_nroprocessolicitatorio'], 0, 12);
        $aCSVEMP10['si106_exercicioprocessolicitatorio']  = $aEMP10['si106_exercicioprocessolicitatorio'] == 0 ? ' ' : $this->padLeftZero($aEMP10['si106_exercicioprocessolicitatorio'], 4);
        $aCSVEMP10['si106_tipoprocesso']                  = $aEMP10['si106_tipoprocesso'] == 0 ? ' ' : $this->padLeftZero($aEMP10['si106_tipoprocesso'], 1);
        $aCSVEMP10['si106_cpfordenador']                  = $this->padLeftZero($aEMP10['si106_cpfordenador'], 11);
        $aCSVEMP10['si106_tipodespesaemprpps']            = ($aEMP10['si106_tipodespesaemprpps'] == 0) ? '' : $this->padLeftZero($aEMP10['si106_tipodespesaemprpps'], 1);

        $this->sLinha = $aCSVEMP10;
        $this->adicionaLinha();

        for ($iCont2 = 0; $iCont2 < pg_num_rows($rsEMP11); $iCont2++) {

          $aEMP11 = pg_fetch_array($rsEMP11, $iCont2);

          if ($aEMP10['si106_sequencial'] == $aEMP11['si107_reg10']) {

            $aCSVEMP11['si107_tiporegistro']    = $this->padLeftZero($aEMP11['si107_tiporegistro'], 2);
            $aCSVEMP11['si107_codunidadesub']   = $this->padLeftZero($aEMP11['si107_codunidadesub'], 5, strlen($aEMP11['si107_codunidadesub']) > 5 ? 8 : 5);
            $aCSVEMP11['si107_nroempenho']      = substr($aEMP11['si107_nroempenho'], 0, 22);
            $aCSVEMP11['si107_codfontrecursos'] = $this->padLeftZero($aEMP11['si107_codfontrecursos'], 3);
            $aCSVEMP11['si107_valorfonte']      = $this->sicomNumberReal($aEMP11['si107_valorfonte'], 2);

            $this->sLinha = $aCSVEMP11;
            $this->adicionaLinha();
          }
        }

        for ($iCont3 = 0; $iCont3 < pg_num_rows($rsEMP12); $iCont3++) {

          $aEMP12 = pg_fetch_array($rsEMP12, $iCont3);

          if ($aEMP10['si106_sequencial'] == $aEMP12['si108_reg10']) {

            $aCSVEMP12['si108_tiporegistro']  = $this->padLeftZero($aEMP12['si108_tiporegistro'], 2);
            $aCSVEMP12['si108_codunidadesub'] = $this->padLeftZero($aEMP12['si108_codunidadesub'], 5, strlen($aEMP12['si108_codunidadesub']) > 5 ? 8 : 5);
            $aCSVEMP12['si108_nroempenho']    = substr($aEMP12['si108_nroempenho'], 0, 22);
            $aCSVEMP12['si108_tipodocumento'] = $this->padLeftZero($aEMP12['si108_tipodocumento'], 1);
            $aCSVEMP12['si108_nrodocumento']  = substr($aEMP12['si108_nrodocumento'], 0, 14);

            $this->sLinha = $aCSVEMP12;
            $this->adicionaLinha();
          }
        }
      }
    }

    /**
     * Registro 30
     */
    if (pg_num_rows($rsEMP30) > 0) {

      for ($iCont30 = 0; $iCont30 < pg_num_rows($rsEMP30); $iCont30++) {
        $aEMP30 = pg_fetch_array($rsEMP30, $iCont30);

        $aCSVEMP30['si206_tiporegistro']                  = $this->padLeftZero($aEMP30['si206_tiporegistro'], 2);
        $aCSVEMP30['si206_codorgao']                      = $this->padLeftZero($aEMP30['si206_codorgao'], 2);
        $aCSVEMP30['si206_codunidadesub']                 = $aEMP30['si206_codunidadesub'];
        $aCSVEMP30['si206_nroempenho']                    = substr($aEMP30['si206_nroempenho'], 0, 22);
        $aCSVEMP30['si206_dtempenho']                     = $this->sicomDate($aEMP30['si206_dtempenho']);
        $aCSVEMP30['si206_codorgaorespcontrato']          = $aEMP30['si206_codorgaorespcontrato'] == '' ? ' ' : $this->padLeftZero($aEMP30['si206_codorgaorespcontrato'], 2); // campo 18
        $aCSVEMP30['si206_codunidadesubrespcontrato']     = $aEMP30['si206_codunidadesubrespcontrato'] == '' ? ' ' : $this->padLeftZero($aEMP30['si206_codunidadesubrespcontrato'], 5); // campo 19
        $aCSVEMP30['si206_nrocontrato']                   = $aEMP30['si206_nrocontrato'] == 0 ? ' ' : substr($aEMP30['si206_nrocontrato'], 0, 14); // campo 20
        $aCSVEMP30['si206_dtassinaturacontrato']          = $aEMP30['si206_dtassinaturacontrato'] == '' ? ' ' : $this->sicomDate($aEMP30['si206_dtassinaturacontrato']); // campo 21
        $aCSVEMP30['si206_nrosequencialtermoaditivo']     = $aEMP30['si206_nrosequencialtermoaditivo'] == '' ? ' ' : $this->padLeftZero($aEMP30['si206_nrosequencialtermoaditivo'], 2);  // campo 22
        $aCSVEMP30['si206_nroconvenio']                   = $aEMP30['si206_nroconvenio'] == 0 ? ' ' : substr($aEMP30['si206_nroconvenio'], 0, 30);  // campo 24
        $aCSVEMP30['si206_dtassinaturaconvenio']          = $aEMP30['si206_dtassinaturaconvenio'] == '' ? ' ' : $this->sicomDate($aEMP30['si206_dtassinaturaconvenio']);  // campo 25
        $aCSVEMP30['si206_nroconvenioconge']              = $aEMP30['si206_nroconvenioconge'] == 0 ? ' ' : substr($aEMP30['si206_nroconvenioconge'], 0, 30); // campo 27
        $aCSVEMP30['si206_dtassinaturaconge']             = $aEMP30['si206_dtassinaturaconge'] == 0 ? ' ' : substr($aEMP30['si206_dtassinaturaconge'], 0, 30); // campo 28

        $this->sLinha = $aCSVEMP30;
        $this->adicionaLinha();
      }
    }

    if (pg_num_rows($rsEMP20) > 0) {
      /**
       * Ao que parece, não tá gerando
       * Registros 20
       */
      for ($iCont4 = 0; $iCont4 < pg_num_rows($rsEMP20); $iCont4++) {

        $aEMP20 = pg_fetch_array($rsEMP20, $iCont4);

        $aCSVEMP20['si109_tiporegistro']    = $this->padLeftZero($aEMP20['si109_tiporegistro'], 2);
        $aCSVEMP20['si109_codorgao']        = $this->padLeftZero($aEMP20['si109_codorgao'], 2);
        //        $aCSVEMP20['si109_codunidadesub'] = $this->padLeftZero($aEMP20['si109_tiporegistro'], 8);
        $aCSVEMP20['si109_codunidadesub']   = $this->padLeftZero($aEMP20['si109_codunidadesub'], 8, strlen($aEMP20['si109_codunidadesub']) > 5 ? 8 : 5);
        //        $aCSVEMP20['si109_nroempenho'] = substr($aEMP20['si109_descrmovimentacao'], 0, 22);
        $aCSVEMP20['si109_nroempenho']      = substr($aEMP20['si109_nroempenho'], 0, 22);
        $aCSVEMP20['si109_dtempenho']       = $this->sicomDate($aEMP20['si109_dtempenho']);
        $aCSVEMP20['si109_nroreforco']      = substr($aEMP20['si109_nroreforco'], 0, 22);
        $aCSVEMP20['si109_dtreforco']       = $this->sicomDate($aEMP20['si109_dtreforco']);
        $aCSVEMP20['si109_codfontrecursos'] = $this->padLeftZero($aEMP20['si109_codfontrecursos'], 3);
        $aCSVEMP20['si109_vlreforco']       = $this->sicomNumberReal($aEMP20['si109_vlreforco'], 2);

        $this->sLinha = $aCSVEMP20;
        $this->adicionaLinha();
      }
    }

    $this->fechaArquivo();
  }
}
