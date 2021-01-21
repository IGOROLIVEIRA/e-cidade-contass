<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarDISPENSA extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;

  public function gerarDados()
  {

    $this->sArquivo = "DISPENSA";
    $this->abreArquivo();

    $sSql = "select * from dispensa102021 where si74_mes = " . $this->iMes . " and si74_instit=" . db_getsession("DB_instit");
    $rsDISPENSA10 = db_query($sSql);

    $sSql2 = "select * from dispensa112021 where si75_mes = " . $this->iMes . " and si75_instit=" . db_getsession("DB_instit");
    $rsDISPENSA11 = db_query($sSql2);

    $sSql3 = "select * from dispensa122021 where si76_mes = " . $this->iMes . " and si76_instit=" . db_getsession("DB_instit");
    $rsDISPENSA12 = db_query($sSql3);

    $sSql4 = "select * from dispensa132021 where si77_mes = " . $this->iMes . " and si77_instit=" . db_getsession("DB_instit");
    $rsDISPENSA13 = db_query($sSql4);

    $sSql5 = "select * from dispensa142021 where si78_mes = " . $this->iMes . " and si78_instit=" . db_getsession("DB_instit");
    $rsDISPENSA14 = db_query($sSql5);

    $sSql6 = "select * from dispensa152021 where si79_mes = " . $this->iMes . " and si79_instit=" . db_getsession("DB_instit");
    $rsDISPENSA15 = db_query($sSql6);

    $sSql7 = "select * from dispensa162021 where si80_mes = " . $this->iMes . " and si80_instit=" . db_getsession("DB_instit");
    $rsDISPENSA16 = db_query($sSql7);

    $sSql8 = "select * from dispensa172021 where si81_mes = " . $this->iMes . " and si81_instit=" . db_getsession("DB_instit");
    $rsDISPENSA17 = db_query($sSql8);

    $sSql9 = "select * from dispensa182021 where si82_mes = " . $this->iMes . " and si82_instit=" . db_getsession("DB_instit");
    $rsDISPENSA18 = db_query($sSql9);

    if (pg_num_rows($rsDISPENSA10) == 0 && pg_num_rows($rsDISPENSA18) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {

      /**
       *
       * Registros 10, 11, 12, 13, 14, 15
       */
      for ($iCont = 0; $iCont < pg_num_rows($rsDISPENSA10); $iCont++) {

        $aDISPENSA10 = pg_fetch_array($rsDISPENSA10, $iCont);

        $aCSVDISPENSA10['si74_tiporegistro'] = $this->padLeftZero($aDISPENSA10['si74_tiporegistro'], 2);
        $aCSVDISPENSA10['si74_tipocadastro'] = $this->padLeftZero($aDISPENSA10['si74_tipocadastro'], 1);
        $aCSVDISPENSA10['si74_codorgaoresp'] = $this->padLeftZero($aDISPENSA10['si74_codorgaoresp'], 2);
        $aCSVDISPENSA10['si74_codunidadesubresp'] = $this->padLeftZero($aDISPENSA10['si74_codunidadesubresp'], 5);
        $aCSVDISPENSA10['si74_exercicioprocesso'] = $this->padLeftZero($aDISPENSA10['si74_exercicioprocesso'], 4);
        $aCSVDISPENSA10['si74_nroprocesso'] = substr($aDISPENSA10['si74_nroprocesso'], 0, 12);
        $aCSVDISPENSA10['si74_tipoprocesso'] = $this->padLeftZero($aDISPENSA10['si74_tipoprocesso'], 1);
        $aCSVDISPENSA10['si74_dtabertura'] = $this->sicomDate($aDISPENSA10['si74_dtabertura']);
        $aCSVDISPENSA10['si74_naturezaobjeto'] = $this->padLeftZero($aDISPENSA10['si74_naturezaobjeto'], 1);
        $aCSVDISPENSA10['si74_objeto'] = substr($aDISPENSA10['si74_objeto'], 0, 500);
        $aCSVDISPENSA10['si74_justificativa'] = substr($aDISPENSA10['si74_justificativa'], 0, 250);
        $aCSVDISPENSA10['si74_razao'] = substr($aDISPENSA10['si74_razao'], 0, 250);
        $aCSVDISPENSA10['si74_dtpublicacaotermoratificacao'] = $this->sicomDate($aDISPENSA10['si74_dtpublicacaotermoratificacao']);
        $aCSVDISPENSA10['si74_veiculopublicacao'] = substr($aDISPENSA10['si74_veiculopublicacao'], 0, 50);
        $aCSVDISPENSA10['si74_processoporlote'] = $this->padLeftZero($aDISPENSA10['si74_processoporlote'], 1);

        $this->sLinha = $aCSVDISPENSA10;
        $this->adicionaLinha();

        for ($iCont2 = 0; $iCont2 < pg_num_rows($rsDISPENSA11); $iCont2++) {

          $aDISPENSA11 = pg_fetch_array($rsDISPENSA11, $iCont2);

          if ($aDISPENSA10['si74_sequencial'] == $aDISPENSA11['si75_reg10']) {

            $aCSVDISPENSA11['si75_tiporegistro'] = $this->padLeftZero($aDISPENSA11['si75_tiporegistro'], 2);
            $aCSVDISPENSA11['si75_codorgaoresp'] = $this->padLeftZero($aDISPENSA11['si75_codorgaoresp'], 2);
            $aCSVDISPENSA11['si75_codunidadesubresp'] = $this->padLeftZero($aDISPENSA11['si75_codunidadesubresp'], 5);
            $aCSVDISPENSA11['si75_exercicioprocesso'] = $this->padLeftZero($aDISPENSA11['si75_exercicioprocesso'], 4);
            $aCSVDISPENSA11['si75_nroprocesso'] = substr($aDISPENSA11['si75_nroprocesso'], 0, 12);
            $aCSVDISPENSA11['si75_tipoprocesso'] = $this->padLeftZero($aDISPENSA11['si75_tipoprocesso'], 1);
            $aCSVDISPENSA11['si75_nrolote'] = substr($aDISPENSA11['si75_nrolote'], 0, 4);
            $aCSVDISPENSA11['si75_dsclote'] = substr($aDISPENSA11['si75_dsclote'], 0, 250);

            $this->sLinha = $aCSVDISPENSA11;
            $this->adicionaLinha();
          }

        }

        for ($iCont3 = 0; $iCont3 < pg_num_rows($rsDISPENSA12); $iCont3++) {

          $aDISPENSA12 = pg_fetch_array($rsDISPENSA12, $iCont3);

          if ($aDISPENSA10['si74_sequencial'] == $aDISPENSA12['si76_reg10']) {

            $aCSVDISPENSA12['si76_tiporegistro'] = $this->padLeftZero($aDISPENSA12['si76_tiporegistro'], 2);
            $aCSVDISPENSA12['si76_codorgaoresp'] = $this->padLeftZero($aDISPENSA12['si76_codorgaoresp'], 2);
            $aCSVDISPENSA12['si76_codunidadesubresp'] = $this->padLeftZero($aDISPENSA12['si76_codunidadesubresp'], 5);
            $aCSVDISPENSA12['si76_exercicioprocesso'] = $this->padLeftZero($aDISPENSA12['si76_exercicioprocesso'], 4);
            $aCSVDISPENSA12['si76_nroprocesso'] = substr($aDISPENSA12['si76_nroprocesso'], 0, 12);
            $aCSVDISPENSA12['si76_tipoprocesso'] = $this->padLeftZero($aDISPENSA12['si76_tipoprocesso'], 1);
            $aCSVDISPENSA12['si76_coditem'] = substr($aDISPENSA12['si76_coditem'], 0, 15);
            $aCSVDISPENSA12['si76_nroitem'] = substr($aDISPENSA12['si76_nroitem'], 0, 5);


            $this->sLinha = $aCSVDISPENSA12;
            $this->adicionaLinha();
          }

        }

        for ($iCont3 = 0; $iCont3 < pg_num_rows($rsDISPENSA13); $iCont3++) {

          $aDISPENSA13 = pg_fetch_array($rsDISPENSA13, $iCont3);

          if ($aDISPENSA10['si74_sequencial'] == $aDISPENSA13['si77_reg10']) {

            $aCSVDISPENSA13['si77_tiporegistro'] = $this->padLeftZero($aDISPENSA13['si77_tiporegistro'], 2);
            $aCSVDISPENSA13['si77_codorgaoresp'] = $this->padLeftZero($aDISPENSA13['si77_codorgaoresp'], 2);
            $aCSVDISPENSA13['si77_codunidadesubresp'] = $this->padLeftZero($aDISPENSA13['si77_codunidadesubresp'], 5);
            $aCSVDISPENSA13['si77_exercicioprocesso'] = $this->padLeftZero($aDISPENSA13['si77_exercicioprocesso'], 4);
            $aCSVDISPENSA13['si77_nroprocesso'] = substr($aDISPENSA13['si77_nroprocesso'], 0, 12);
            $aCSVDISPENSA13['si77_tipoprocesso'] = $this->padLeftZero($aDISPENSA13['si77_tipoprocesso'], 1);
            $aCSVDISPENSA13['si77_nrolote'] = substr($aDISPENSA13['si77_nrolote'], 0, 4);
            $aCSVDISPENSA13['si77_coditem'] = substr($aDISPENSA13['si77_coditem'], 0, 15);

            $this->sLinha = $aCSVDISPENSA13;
            $this->adicionaLinha();
          }

        }

        for ($iCont4 = 0; $iCont4 < pg_num_rows($rsDISPENSA14); $iCont4++) {

          $aDISPENSA14 = pg_fetch_array($rsDISPENSA14, $iCont4);

          if ($aDISPENSA10['si74_sequencial'] == $aDISPENSA14['si78_reg10']) {

            $aCSVDISPENSA14['si78_tiporegistro'] = $this->padLeftZero($aDISPENSA14['si78_tiporegistro'], 2);
            $aCSVDISPENSA14['si78_codorgaoresp'] = $this->padLeftZero($aDISPENSA14['si78_codorgaoresp'], 2);
            $aCSVDISPENSA14['si78_codunidadesubres'] = $this->padLeftZero($aDISPENSA14['si78_codunidadesubres'], 5);
            $aCSVDISPENSA14['si78_exercicioprocesso'] = $this->padLeftZero($aDISPENSA14['si78_exercicioprocesso'], 4);
            $aCSVDISPENSA14['si78_nroprocesso'] = substr($aDISPENSA14['si78_nroprocesso'], 0, 12);
            $aCSVDISPENSA14['si78_tipoprocesso'] = $this->padLeftZero($aDISPENSA14['si78_tipoprocesso'], 1);
            $aCSVDISPENSA14['si78_tiporesp'] = $this->padLeftZero($aDISPENSA14['si78_tiporesp'], 1);
            $aCSVDISPENSA14['si78_nrocpfresp'] = $this->padLeftZero($aDISPENSA14['si78_nrocpfresp'], 11);

            $this->sLinha = $aCSVDISPENSA14;
            $this->adicionaLinha();
          }

        }

        for ($iCont5 = 0; $iCont5 < pg_num_rows($rsDISPENSA15); $iCont5++) {

          $aDISPENSA15 = pg_fetch_array($rsDISPENSA15, $iCont5);

          if ($aDISPENSA10['si74_sequencial'] == $aDISPENSA15['si79_reg10']) {

            $aCSVDISPENSA15['si79_tiporegistro'] = $this->padLeftZero($aDISPENSA15['si79_tiporegistro'], 2);
            $aCSVDISPENSA15['si79_codorgaoresp'] = $this->padLeftZero($aDISPENSA15['si79_codorgaoresp'], 2);
            $aCSVDISPENSA15['si79_codunidadesubresp'] = $this->padLeftZero($aDISPENSA15['si79_codunidadesubresp'], 5);
            $aCSVDISPENSA15['si79_exercicioprocesso'] = $this->padLeftZero($aDISPENSA15['si79_exercicioprocesso'], 4);
            $aCSVDISPENSA15['si79_nroprocesso'] = substr($aDISPENSA15['si79_nroprocesso'], 0, 12);
            $aCSVDISPENSA15['si79_tipoprocesso'] = $this->padLeftZero($aDISPENSA15['si79_tipoprocesso'], 1);
            $aCSVDISPENSA15['si79_nrolote'] = $aDISPENSA15['si79_nrolote'] == 0 ? ' ' : substr($aDISPENSA15['si79_nrolote'], 0, 4);
            $aCSVDISPENSA15['si79_coditem'] = substr($aDISPENSA15['si79_coditem'], 0, 15);
            $aCSVDISPENSA15['si79_vlcotprecosunitario'] = $this->sicomNumberReal($aDISPENSA15['si79_vlcotprecosunitario'], 4);
            $aCSVDISPENSA15['si79_quantidade'] = $this->sicomNumberReal($aDISPENSA15['si79_quantidade'], 4);

            $this->sLinha = $aCSVDISPENSA15;
            $this->adicionaLinha();
          }

        }

        for ($iCont6 = 0; $iCont6 < pg_num_rows($rsDISPENSA16); $iCont6++) {

          $aDISPENSA16 = pg_fetch_array($rsDISPENSA16, $iCont6);

          if ($aDISPENSA10['si74_sequencial'] == $aDISPENSA16['si80_reg10']) {

            $aCSVDISPENSA16['si80_tiporegistro'] = $this->padLeftZero($aDISPENSA16['si80_tiporegistro'], 2);
            $aCSVDISPENSA16['si80_codorgaoresp'] = $this->padLeftZero($aDISPENSA16['si80_codorgaoresp'], 2);
            $aCSVDISPENSA16['si80_codunidadesubresp'] = $this->padLeftZero($aDISPENSA16['si80_codunidadesubresp'], 5);
            $aCSVDISPENSA16['si80_exercicioprocesso'] = $this->padLeftZero($aDISPENSA16['si80_exercicioprocesso'], 4);
            $aCSVDISPENSA16['si80_nroprocesso'] = substr($aDISPENSA16['si80_nroprocesso'], 0, 12);
            $aCSVDISPENSA16['si80_tipoprocesso'] = $this->padLeftZero($aDISPENSA16['si80_tipoprocesso'], 1);
            $aCSVDISPENSA16['si80_codorgao'] = $this->padLeftZero($aDISPENSA16['si80_codorgao'], 2);
            $aCSVDISPENSA16['si80_codunidadesub'] = $this->padLeftZero($aDISPENSA16['si80_codunidadesub'], 5);
            $aCSVDISPENSA16['si80_codfuncao'] = $this->padLeftZero($aDISPENSA16['si80_codfuncao'], 2);
            $aCSVDISPENSA16['si80_codsubfuncao'] = $this->padLeftZero($aDISPENSA16['si80_codsubfuncao'], 3);
            $aCSVDISPENSA16['si80_codprograma'] = $this->padLeftZero($aDISPENSA16['si80_codprograma'], 4);
            $aCSVDISPENSA16['si80_idacao'] = $this->padLeftZero($aDISPENSA16['si80_idacao'], 4);
            $aCSVDISPENSA16['si80_idsubacao'] = $aDISPENSA16['si80_idsubacao'] == 0 ? ' ' : $this->padLeftZero($aDISPENSA16['si80_idsubacao'], 4);
            $aCSVDISPENSA16['si80_naturezadespesa'] = $this->padLeftZero($aDISPENSA16['si80_naturezadespesa'], 6);
            $aCSVDISPENSA16['si80_codfontrecursos'] = $this->padLeftZero($aDISPENSA16['si80_codfontrecursos'], 3);
            $aCSVDISPENSA16['si80_vlrecurso'] = $this->sicomNumberReal($aDISPENSA16['si80_vlrecurso'], 2);

            $this->sLinha = $aCSVDISPENSA16;
            $this->adicionaLinha();
          }

        }

        for ($iCont7 = 0; $iCont7 < pg_num_rows($rsDISPENSA17); $iCont7++) {

          $aDISPENSA17 = pg_fetch_array($rsDISPENSA17, $iCont7);

          if ($aDISPENSA10['si74_sequencial'] == $aDISPENSA17['si81_reg10']) {

            $aCSVDISPENSA17['si81_tiporegistro'] = $this->padLeftZero($aDISPENSA17['si81_tiporegistro'], 2);
            $aCSVDISPENSA17['si81_codorgaoresp'] = $this->padLeftZero($aDISPENSA17['si81_codorgaoresp'], 2);
            $aCSVDISPENSA17['si81_codunidadesubresp'] = $this->padLeftZero($aDISPENSA17['si81_codunidadesubresp'], 5);
            $aCSVDISPENSA17['si81_exercicioprocesso'] = $this->padLeftZero($aDISPENSA17['si81_exercicioprocesso'], 4);
            $aCSVDISPENSA17['si81_nroprocesso'] = substr($aDISPENSA17['si81_nroprocesso'], 0, 12);
            $aCSVDISPENSA17['si81_tipoprocesso'] = $this->padLeftZero($aDISPENSA17['si81_tipoprocesso'], 1);
            $aCSVDISPENSA17['si81_tipodocumento'] = $this->padLeftZero($aDISPENSA17['si81_tipodocumento'], 1);
            $aCSVDISPENSA17['si81_nrodocumento'] = substr($aDISPENSA17['si81_nrodocumento'], 0, 14);
            $aCSVDISPENSA17['si81_nroinscricaoestadual'] = substr($aDISPENSA17['si81_nroinscricaoestadual'], 0, 30);
            $aCSVDISPENSA17['si81_ufinscricaoestadual'] = strlen($aDISPENSA17['si81_ufinscricaoestadual']) < 2 ? ' ' : substr($aDISPENSA17['si81_ufinscricaoestadual'], 0, 2);
            $aCSVDISPENSA17['si81_nrocertidaoregularidadeinss'] = substr($aDISPENSA17['si81_nrocertidaoregularidadeinss'], 0, 30);
            $aCSVDISPENSA17['si81_dtemissaocertidaoregularidadeinss'] = $this->sicomDate($aDISPENSA17['si81_dtemissaocertidaoregularidadeinss']);
            $aCSVDISPENSA17['si81_dtvalidadecertidaoregularidadeinss'] = $this->sicomDate($aDISPENSA17['si81_dtvalidadecertidaoregularidadeinss']);
            $aCSVDISPENSA17['si81_nrocertidaoregularidadefgts'] = substr($aDISPENSA17['si81_nrocertidaoregularidadefgts'], 0, 30);
            $aCSVDISPENSA17['si81_dtemissaocertidaoregularidadefgts'] = $this->sicomDate($aDISPENSA17['si81_dtemissaocertidaoregularidadefgts']);
            $aCSVDISPENSA17['si81_dtvalidadecertidaoregularidadefgts'] = $this->sicomDate($aDISPENSA17['si81_dtvalidadecertidaoregularidadefgts']);
            $aCSVDISPENSA17['si81_nrocndt'] = substr($aDISPENSA17['si81_nrocndt'], 0, 30);
            $aCSVDISPENSA17['si81_dtemissaocndt'] = $this->sicomDate($aDISPENSA17['si81_dtemissaocndt']);
            $aCSVDISPENSA17['si81_dtvalidadecndt'] = $this->sicomDate($aDISPENSA17['si81_dtvalidadecndt']);
            $aCSVDISPENSA17['si81_nrolote'] = $aDISPENSA17['si81_nrolote'] == 0 ? ' ' : substr($aDISPENSA17['si81_nrolote'], 0, 4);
            $aCSVDISPENSA17['si81_coditem'] = substr($aDISPENSA17['si81_coditem'], 0, 15);
            $aCSVDISPENSA17['si81_quantidade'] = $this->sicomNumberReal($aDISPENSA17['si81_quantidade'], 4);
            $aCSVDISPENSA17['si81_vlitem'] = $this->sicomNumberReal($aDISPENSA17['si81_vlitem'], 4);

            $this->sLinha = $aCSVDISPENSA17;
            $this->adicionaLinha();

          }

        }
      }

      for ($iCont8 = 0; $iCont8 < pg_num_rows($rsDISPENSA18); $iCont8++) {

        $aDISPENSA18 = pg_fetch_array($rsDISPENSA18, $iCont8);


          $aCSVDISPENSA18['si82_tiporegistro']                        = $this->padLeftZero($aDISPENSA18['si82_tiporegistro'], 2);
          $aCSVDISPENSA18['si82_codorgaoresp']                        = $this->padLeftZero($aDISPENSA18['si82_codorgaoresp'], 2);
          $aCSVDISPENSA18['si82_codunidadesubresp']                   = $this->padLeftZero($aDISPENSA18['si82_codunidadesubresp'], 5);
          $aCSVDISPENSA18['si82_exercicioprocesso']                   = $this->padLeftZero($aDISPENSA18['si82_exercicioprocesso'], 4);
          $aCSVDISPENSA18['si82_nroprocesso']                         = substr($aDISPENSA18['si82_nroprocesso'], 0, 12);
          $aCSVDISPENSA18['si82_tipoprocesso']                        = $this->padLeftZero($aDISPENSA18['si82_tipoprocesso'], 1);
          $aCSVDISPENSA18['si82_tipodocumento']                       = $this->padLeftZero($aDISPENSA18['si82_tipodocumento'], 1);
          $aCSVDISPENSA18['si82_nrodocumento']                        = substr($aDISPENSA18['si82_nrodocumento'], 0, 14);
          $aCSVDISPENSA18['si82_datacredenciamento']                  = $this->sicomDate($aDISPENSA18['si82_datacredenciamento']);
          $aCSVDISPENSA18['si82_nrolote']                             = $aDISPENSA18['si82_nrolote'] == '0' ? ' ' : substr($aDISPENSA18['si82_nrolote'], 0, 4);
          $aCSVDISPENSA18['si82_coditem']                             = substr($aDISPENSA18['si82_coditem'], 0, 15);
          $aCSVDISPENSA18['si82_nroinscricaoestadual']                = substr($aDISPENSA18['si82_nroinscricaoestadual'], 0, 30);
          $aCSVDISPENSA18['si82_ufinscricaoestadual']                 = strlen($aDISPENSA18['si82_ufinscricaoestadual']) < 2 ? ' ' : substr($aDISPENSA18['si82_ufinscricaoestadual'], 0, 2);
          $aCSVDISPENSA18['si82_nrocertidaoregularidadeinss']         = substr($aDISPENSA18['si82_nrocertidaoregularidadeinss'], 0, 30);
          $aCSVDISPENSA18['si82_dataemissaocertidaoregularidadeinss'] = $this->sicomDate($aDISPENSA18['dataemissaocertidaoregularidadeinss']);
          $aCSVDISPENSA18['si82_dtvalidadecertidaoregularidadeinss']  = $this->sicomDate($aDISPENSA18['si82_dtvalidadecertidaoregularidadeinss']);
          $aCSVDISPENSA18['si82_nrocertidaoregularidadefgts']         = substr($aDISPENSA18['si82_nrocertidaoregularidadefgts'], 0, 30);
          $aCSVDISPENSA18['si82_dtemissaocertidaoregularidadefgts']   = $this->sicomDate($aDISPENSA18['si82_dtemissaocertidaoregularidadefgts']);
          $aCSVDISPENSA18['si82_dtvalidadecertidaoregularidadefgts']  = $this->sicomDate($aDISPENSA18['si82_dtvalidadecertidaoregularidadefgts']);
          $aCSVDISPENSA18['si82_nrocndt']                             = substr($aDISPENSA18['si82_nrocndt'], 0, 30);
          $aCSVDISPENSA18['si82_dtemissaocndt']                       = $this->sicomDate($aDISPENSA18['si82_dtemissaocndt']);
          $aCSVDISPENSA18['si82_dtvalidadecndt']                      = $this->sicomDate($aDISPENSA18['si82_dtvalidadecndt']);


          $this->sLinha = $aCSVDISPENSA18;
          $this->adicionaLinha();


      }

      $this->fechaArquivo();

    }

  }
}
