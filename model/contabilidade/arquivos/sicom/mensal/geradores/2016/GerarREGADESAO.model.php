<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarREGADESAO extends GerarAM {

   /**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "REGADESAO";
    $this->abreArquivo();
    
    $sSql = "select * from regadesao102016 where si67_mes = ". $this->iMes;
    $rsREGADESAO10    = db_query($sSql);

    $sSql2 = "select * from regadesao112016 where si68_mes = ". $this->iMes;
    $rsREGADESAO11    = db_query($sSql2);

    $sSql3 = "select * from regadesao122016 where si69_mes = ". $this->iMes;
    $rsREGADESAO12    = db_query($sSql3);

    $sSql4 = "select * from regadesao132016 where si70_mes = ". $this->iMes;
    $rsREGADESAO13    = db_query($sSql4);

    $sSql5 = "select * from regadesao142016 where si71_mes = ". $this->iMes;
    $rsREGADESAO14    = db_query($sSql5);

    $sSql6 = "select * from regadesao152016 where si72_mes = ". $this->iMes;
    $rsREGADESAO15    = db_query($sSql6);

    $sSql7 = "select * from regadesao202016 where si73_mes = ". $this->iMes;
    $rsREGADESAO20    = db_query($sSql7);

  if (pg_num_rows($rsREGADESAO10) == 0 && pg_num_rows($rsREGADESAO20) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10, 11, 12, 13, 14, 15
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsREGADESAO10); $iCont++) {

        $aREGADESAO10  = pg_fetch_array($rsREGADESAO10,$iCont);
        
        $aCSVREGADESAO10['si67_tiporegistro']                =    str_pad($aREGADESAO10['si67_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVREGADESAO10['si67_codorgao']                    =    str_pad($aREGADESAO10['si67_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVREGADESAO10['si67_codunidadesub']               =    str_pad($aREGADESAO10['si67_codunidadesub'], (strlen($aREGADESAO10['si67_codunidadesub']) > 5 ? 8 : 5), "0", STR_PAD_LEFT);
        $aCSVREGADESAO10['si67_nroprocadesao']               =    substr($aREGADESAO10['si67_nroprocadesao'], 0, 12);
        $aCSVREGADESAO10['si67_exercicioadesao']             =    str_pad($aREGADESAO10['si63_exercicioadesao'], 4, "0", STR_PAD_LEFT);
        $aCSVREGADESAO10['si67_dtabertura']                  =    implode("", array_reverse(explode("-", $aREGADESAO10['si67_dtabertura'])));
        $aCSVREGADESAO10['si67_nomeorgaogerenciador']        =    substr($aREGADESAO10['si67_nomeorgaogerenciador'], 0, 100);
        $aCSVREGADESAO10['si67_exerciciolicitacao']          =    str_pad($aREGADESAO10['si67_exerciciolicitacao'], 4, "0", STR_PAD_LEFT);
        $aCSVREGADESAO10['si67_nroprocessolicitatorio']      =    substr($aREGADESAO10['si67_nroprocessolicitatorio'], 0, 20);
        $aCSVREGADESAO10['si67_codmodalidadelicitacao']      =    str_pad($aREGADESAO10['si67_codmodalidadelicitacao'], 1, "0", STR_PAD_LEFT);
        $aCSVREGADESAO10['si67_nromodalidade']               =    substr($aREGADESAO10['si67_nromodalidade'], 0, 10);
        $aCSVREGADESAO10['si67_dtataregpreco']               =    implode("", array_reverse(explode("-", $aREGADESAO10['si67_dtataregpreco'])));
        $aCSVREGADESAO10['si67_dtvalidade']                  =    implode("", array_reverse(explode("-", $aREGADESAO10['si67_dtvalidade'])));
        $aCSVREGADESAO10['si67_naturezaprocedimento']        =    str_pad($aREGADESAO10['si67_naturezaprocedimento'], 1, "0", STR_PAD_LEFT);
        $aCSVREGADESAO10['si67_dtpublicacaoavisointencao']   =    implode("", array_reverse(explode("-", $aREGADESAO10['si67_dtpublicacaoavisointencao'])));
        $aCSVREGADESAO10['si67_objetoadesao']                =    substr($aREGADESAO10['si67_objetoadesao'], 0, 500);
        $aCSVREGADESAO10['si67_cpfresponsavel']              =    str_pad($aREGADESAO10['si67_cpfresponsavel'], 11, "0", STR_PAD_LEFT);
        $aCSVREGADESAO10['si67_descontotabela']              =    str_pad($aREGADESAO10['si67_descontotabela'], 1, "0", STR_PAD_LEFT);
        $aCSVREGADESAO10['si67_processoporlote']             =    str_pad($aREGADESAO10['si67_processoporlote'], 1, "0", STR_PAD_LEFT);
        
        $this->sLinha = $aCSVREGADESAO10;
        $this->adicionaLinha();

        for ($iCont2 = 0;$iCont2 < pg_num_rows($rsREGADESAO11); $iCont2++) {        

          $aREGADESAO11  = pg_fetch_array($rsREGADESAO11,$iCont2);
          
          if ($aREGADESAO10['si67_sequencial'] == $aREGADESAO11['si68_reg10']) {

            $aCSVREGADESAO11['si68_tiporegistro']          =   str_pad($aREGADESAO11['si68_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVREGADESAO11['si68_codorgao']              =   str_pad($aREGADESAO11['si68_codorgao'], 2, "0", STR_PAD_LEFT);
            $aCSVREGADESAO11['si68_codunidadesub']         =   str_pad($aREGADESAO11['si68_codunidadesub'], (strlen($aREGADESAO11['si68_codunidadesub']) > 5 ? 8 : 5), "0", STR_PAD_LEFT);
            $aCSVREGADESAO11['si68_nroprocadesao']         =   substr($aREGADESAO11['si68_nroprocadesao'], 0, 12);
            $aCSVREGADESAO11['si68_exercicioadesao']       =   str_pad($aREGADESAO11['si68_exercicioadesao'], 4, "0", STR_PAD_LEFT);
            $aCSVREGADESAO11['si68_nrolote']               =   substr(($aREGADESAO11['si68_nrolote'] == 0 ? ' ' : $aREGADESAO11['si68_nrolote']), 0, 4);
            $aCSVREGADESAO11['si68_dsclote']               =   substr($aREGADESAO11['si68_dsclote'], 0, 250);


            $this->sLinha = $aCSVREGADESAO11;
            $this->adicionaLinha();
          }

        }

        for ($iCont3 = 0;$iCont3 < pg_num_rows($rsREGADESAO12); $iCont3++) {        

          $aREGADESAO12  = pg_fetch_array($rsREGADESAO12,$iCont3);
          
          if ($aREGADESAO10['si67_sequencial'] == $aREGADESAO12['si69_reg10']) {

            $aCSVREGADESAO12['si69_tiporegistro']          =   str_pad($aREGADESAO12['si69_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVREGADESAO12['si69_codorgao']              =   str_pad($aREGADESAO12['si69_codorgao'], 2, "0", STR_PAD_LEFT);
            $aCSVREGADESAO12['si69_codunidadesub']         =   str_pad($aREGADESAO12['si69_codunidadesub'], (strlen($aREGADESAO12['si69_codunidadesub']) > 5 ? 8 : 5), "0", STR_PAD_LEFT);
            $aCSVREGADESAO12['si69_nroprocadesao']         =   substr($aREGADESAO12['si69_nroprocadesao'], 0, 12);
            $aCSVREGADESAO12['si69_exercicioadesao']       =   str_pad($aREGADESAO12['si69_exercicioadesao'], 4, "0", STR_PAD_LEFT);
            $aCSVREGADESAO12['si69_coditem']               =   substr($aREGADESAO12['si69_coditem'], 0, 15);
            $aCSVREGADESAO12['si69_nroitem']               =   substr($aREGADESAO12['si69_nroitem'], 0, 4);

            $this->sLinha = $aCSVREGADESAO12;
            $this->adicionaLinha();
          }

        }

        for ($iCont3 = 0;$iCont3 < pg_num_rows($rsREGADESAO13); $iCont3++) {        

          $aREGADESAO13  = pg_fetch_array($rsREGADESAO13,$iCont3);
          
          if ($aREGADESAO10['si67_sequencial'] == $aREGADESAO13['si70_reg10']) {

            $aCSVREGADESAO13['si70_tiporegistro']          =   str_pad($aREGADESAO13['si70_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVREGADESAO13['si70_codorgao']              =   str_pad($aREGADESAO13['si70_codorgao'], 2, "0", STR_PAD_LEFT);
            $aCSVREGADESAO13['si70_codunidadesub']         =   str_pad($aREGADESAO13['si70_codunidadesub'], (strlen($aREGADESAO13['si70_codunidadesub']) > 5 ? 8 : 5), "0", STR_PAD_LEFT);
            $aCSVREGADESAO13['si70_nroprocadesao']         =   substr($aREGADESAO13['si70_nroprocadesao'], 0, 12);
            $aCSVREGADESAO13['si70_exercicioadesao']       =   str_pad($aREGADESAO13['si70_exercicioadesao'], 4, "0", STR_PAD_LEFT);
            $aCSVREGADESAO13['si70_nrolote']               =   substr(($aREGADESAO13['si70_nrolote'] == 0 ? ' ' : $aREGADESAO13['si70_nrolote']), 0, 15);
            $aCSVREGADESAO13['si70_coditem']               =   substr($aREGADESAO13['si70_coditem'], 0, 15);

            $this->sLinha = $aCSVREGADESAO13;
            $this->adicionaLinha();
          }

        }

        for ($iCont4 = 0;$iCont4 < pg_num_rows($rsREGADESAO14); $iCont4++) {        

          $aREGADESAO14  = pg_fetch_array($rsREGADESAO14,$iCont4);
          
          if ($aREGADESAO10['si67_sequencial'] == $aREGADESAO14['si71_reg10']) {

            $aCSVREGADESAO14['si71_tiporegistro']          =   str_pad($aREGADESAO14['si71_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVREGADESAO14['si71_codorgao']              =   str_pad($aREGADESAO14['si71_codorgao'], 2, "0", STR_PAD_LEFT);
            $aCSVREGADESAO14['si71_codunidadesub']         =   str_pad($aREGADESAO14['si71_codunidadesub'], (strlen($aREGADESAO14['si71_codunidadesub']) > 5 ? 8 : 5), "0", STR_PAD_LEFT);
            $aCSVREGADESAO14['si71_nroprocadesao']         =   substr($aREGADESAO14['si71_nroprocadesao'], 0, 12);
            $aCSVREGADESAO14['si71_exercicioadesao']       =   str_pad($aREGADESAO14['si71_exercicioadesao'], 4, "0", STR_PAD_LEFT);
            $aCSVREGADESAO14['si71_nrolote']               =   substr(($aREGADESAO14['si71_nrolote'] == 0 ? ' ' : $aREGADESAO14['si71_nrolote']), 0,4);
            $aCSVREGADESAO14['si71_coditem']               =   substr($aREGADESAO14['si71_coditem'], 0, 15);
            $aCSVREGADESAO14['si71_dtcotacao']             =   implode("", array_reverse(explode("-", $aREGADESAO14['si71_dtcotacao'])));
            $aCSVREGADESAO14['si71_vlcotprecosunitario']   =   number_format($aREGADESAO14['si71_vlcotprecosunitario'], 4, ",", "");
            $aCSVREGADESAO14['si71_quantidade']            =   number_format($aREGADESAO14['si71_quantidade'], 4, ",", "");

            $this->sLinha = $aCSVREGADESAO14;
            $this->adicionaLinha();
          }

        }

        for ($iCont5 = 0;$iCont5 < pg_num_rows($rsREGADESAO15); $iCont5++) {        

          $aREGADESAO15  = pg_fetch_array($rsREGADESAO15,$iCont5);
          
          if ($aREGADESAO10['si67_sequencial'] == $aREGADESAO15['si72_reg10']) {

            $aCSVREGADESAO15['si72_tiporegistro']          =   str_pad($aREGADESAO15['si72_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVREGADESAO15['si72_codorgao']              =   str_pad($aREGADESAO15['si72_codorgao'], 2, "0", STR_PAD_LEFT);
            $aCSVREGADESAO15['si72_codunidadesub']         =   str_pad($aREGADESAO15['si72_codunidadesub'], (strlen($aREGADESAO15['si72_codunidadesub']) > 5 ? 8 : 5), "0", STR_PAD_LEFT);
            $aCSVREGADESAO15['si72_nroprocadesao']         =   substr($aREGADESAO15['si72_nroprocadesao'], 0, 12);
            $aCSVREGADESAO15['si72_exercicioadesao']       =   str_pad($aREGADESAO15['si72_exercicioadesao'], 4, "0", STR_PAD_LEFT);
            $aCSVREGADESAO15['si72_nrolote']               =   substr(($aREGADESAO15['si72_nrolote'] == 0 ? ' ' : $aREGADESAO15['si72_nrolote']), 0,4);
            $aCSVREGADESAO15['si72_coditem']               =   substr($aREGADESAO15['si72_coditem'], 0, 15);
            $aCSVREGADESAO15['si72_precounitario']         =   number_format($aREGADESAO15['si72_precounitario'], 4, ",", "");
            $aCSVREGADESAO15['si72_quantidadelicitada']    =   number_format($aREGADESAO15['si72_quantidadelicitada'], 4, ",", "");
            $aCSVREGADESAO15['si72_quantidadeaderida']     =   number_format($aREGADESAO15['si72_quantidadeaderida'], 4, ",", "");
            $aCSVREGADESAO15['si72_tipodocumento']         =   str_pad($aREGADESAO15['si72_tipodocumento'], 1, "0", STR_PAD_LEFT);
            $aCSVREGADESAO15['si72_nrodocumento']          =   substr($aREGADESAO15['si72_nrodocumento'], 0, 14);

            $this->sLinha = $aCSVREGADESAO15;
            $this->adicionaLinha();
          }

        }

      }

       /**
      *
      * Registros 20
      */
      for ($iCont6 = 0;$iCont6 < pg_num_rows($rsREGADESAO20); $iCont6++) {

        $aREGADESAO20  = pg_fetch_array($rsREGADESAO20,$iCont6);
        
        $aCSVREGADESAO20['si73_tiporegistro']          =   str_pad($aREGADESAO20['si73_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVREGADESAO20['si73_codorgao']              =   str_pad($aREGADESAO20['si73_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVREGADESAO20['si73_codunidadesub']         =   str_pad($aREGADESAO20['si73_codunidadesub'], (strlen($aREGADESAO20['si73_codunidadesub']) > 5 ? 8 : 5), "0", STR_PAD_LEFT);
        $aCSVREGADESAO20['si73_nroprocadesao']         =   substr($aREGADESAO20['si73_nroprocadesao'], 0, 12);
        $aCSVREGADESAO20['si73_exercicioadesao']       =   str_pad($aREGADESAO20['si73_exercicioadesao'], 4, "0", STR_PAD_LEFT);
        $aCSVREGADESAO20['si73_nrolote']               =   substr(($aREGADESAO20['si73_nrolote'] == 0 ? ' ' : $aREGADESAO20['si73_nrolote']), 0,4);
        $aCSVREGADESAO20['si73_coditem']               =   substr($aREGADESAO20['si73_coditem'], 0, 15);
        $aCSVREGADESAO20['si73_percdesconto']          =   number_format($aREGADESAO20['si73_percdesconto'], 2, ",", "");
        $aCSVREGADESAO20['si73_tipodocumento']         =   str_pad($aREGADESAO20['si73_tipodocumento'], 1, "0", STR_PAD_LEFT);
        $aCSVREGADESAO20['si73_nrodocumento']          =   substr($aREGADESAO20['si73_nrodocumento'], 0, 14);

        $this->sLinha = $aCSVREGADESAO20;
        $this->adicionaLinha();

      }

      $this->fechaArquivo();

  }

}

}
