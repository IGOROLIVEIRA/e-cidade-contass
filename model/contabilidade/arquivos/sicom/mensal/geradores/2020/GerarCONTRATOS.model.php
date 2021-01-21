<?php

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarCONTRATOS extends GerarAM {

   /**
  *
  * Mes de referência
  * @var Integer
  */
  public $iMes;

  public function gerarDados() {

    $this->sArquivo = "CONTRATOS";
    $this->abreArquivo();

    $sSql = "select * from contratos102020 where si83_mes = ". $this->iMes ." and si83_instit = ". db_getsession("DB_instit");
    $rsCONTRATOS10    = db_query($sSql);

    $sSql2 = "select * from contratos112020 where si84_mes = ". $this->iMes ." and si84_instit = ". db_getsession("DB_instit");
    $rsCONTRATOS11    = db_query($sSql2);


    $sSql3 = "select * from contratos122020 where si85_mes = ". $this->iMes ." and si85_instit = ". db_getsession("DB_instit");
    $rsCONTRATOS12    = db_query($sSql3);

    $sSql4 = "select * from contratos132020 where si86_mes = ". $this->iMes ." and si86_instit = ". db_getsession("DB_instit");
    $rsCONTRATOS13    = db_query($sSql4);

    $sSql5 = "select * from contratos202020 where si87_mes = ". $this->iMes ." and si87_instit = ". db_getsession("DB_instit");
    $rsCONTRATOS20    = db_query($sSql5);

    $sSql6 = "select * from contratos212020 where si88_mes = ". $this->iMes ." and si88_instit = ". db_getsession("DB_instit");
    $rsCONTRATOS21    = db_query($sSql6);

    $sSql7 = "select * from contratos302020 where si89_mes = ". $this->iMes ." and si89_instit = ". db_getsession("DB_instit");
    $rsCONTRATOS30    = db_query($sSql7);

    $sSql8 = "select * from contratos402020 where si91_mes = ". $this->iMes ." and si91_instit = ". db_getsession("DB_instit");
    $rsCONTRATOS40    = db_query($sSql8);


  if (pg_num_rows($rsCONTRATOS10) == 0 && pg_num_rows($rsCONTRATOS20) == 0 && pg_num_rows($rsCONTRATOS30) == 0 && pg_num_rows($rsCONTRATOS40) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10, 11, 12, 13, 14, 15
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsCONTRATOS10); $iCont++) {

        $aCONTRATOS10  = pg_fetch_array($rsCONTRATOS10,$iCont);

        $aCSVCONTRATOS10['si83_tiporegistro']                 =   str_pad($aCONTRATOS10['si83_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVCONTRATOS10['si83_tipocadastro']                 =   $aCONTRATOS10['si83_tipocadastro'];
        $aCSVCONTRATOS10['si83_codcontrato']                  =   substr($aCONTRATOS10['si83_codcontrato'], 0, 15);
        $aCSVCONTRATOS10['si83_codorgao']                     =   str_pad($aCONTRATOS10['si83_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVCONTRATOS10['si83_codunidadesub']                =   $aCONTRATOS10['si83_codunidadesub'];
        $aCSVCONTRATOS10['si83_nrocontrato']                  =   substr($aCONTRATOS10['si83_nrocontrato'], 0, 14);
        $aCSVCONTRATOS10['si83_exerciciocontrato']            =   str_pad($aCONTRATOS10['si83_exerciciocontrato'], 4, "0", STR_PAD_LEFT);
        $aCSVCONTRATOS10['si83_dataassinatura']               =   implode("", array_reverse(explode("-", $aCONTRATOS10['si83_dataassinatura'])));
        $aCSVCONTRATOS10['si83_contdeclicitacao']             =   str_pad($aCONTRATOS10['si83_contdeclicitacao'], 1, "0", STR_PAD_LEFT);
        $aCSVCONTRATOS10['si83_codorgaoresp']                 =   $aCONTRATOS10['si83_codorgaoresp'] == 0 ? ' ' : str_pad($aCONTRATOS10['si83_codorgaoresp'], 2, '0', STR_PAD_LEFT);
        $aCSVCONTRATOS10['si83_codunidadesubresp']            =   in_array($aCONTRATOS10['si83_contdeclicitacao'], array(1, 8, 9)) ? '' : str_pad($aCONTRATOS10['si83_codunidadesubresp'], 5, '0', STR_PAD_LEFT);
        $aCSVCONTRATOS10['si83_nroprocesso']                  =   substr($aCONTRATOS10['si83_nroprocesso'], 0, 12);
        $aCSVCONTRATOS10['si83_exercicioprocesso']            =   $aCONTRATOS10['si83_exercicioprocesso'] == 0 ? ' ' : $aCONTRATOS10['si83_exercicioprocesso'];
        $aCSVCONTRATOS10['si83_tipoprocesso']                 =   $aCONTRATOS10['si83_tipoprocesso'] == 0 ? ' ' : $aCONTRATOS10['si83_tipoprocesso'];
        $aCSVCONTRATOS10['si83_naturezaobjeto']               =   str_pad($aCONTRATOS10['si83_naturezaobjeto'], 1, "0", STR_PAD_LEFT);
        $aCSVCONTRATOS10['si83_objetocontrato']               =   substr($aCONTRATOS10['si83_objetocontrato'], 0, 500);
        $aCSVCONTRATOS10['si83_tipoinstrumento']              =   str_pad($aCONTRATOS10['si83_tipoinstrumento'], 1, "0", STR_PAD_LEFT);
        $aCSVCONTRATOS10['si83_datainiciovigencia']           =   implode("", array_reverse(explode("-", $aCONTRATOS10['si83_datainiciovigencia'])));
        $aCSVCONTRATOS10['si83_datafinalvigencia']            =   implode("", array_reverse(explode("-", $aCONTRATOS10['si83_datafinalvigencia'])));
        $aCSVCONTRATOS10['si83_vlcontrato']                   =   number_format($aCONTRATOS10['si83_vlcontrato'], 2, ",", "");
        $aCSVCONTRATOS10['si83_formafornecimento']            =   substr($aCONTRATOS10['si83_formafornecimento'], 0, 50);
        $aCSVCONTRATOS10['si83_formapagamento']               =   substr($aCONTRATOS10['si83_formapagamento'], 0, 100);
        $aCSVCONTRATOS10['si83_unidadedemedidaprazoexex']     =   $aCONTRATOS10['si83_unidadedemedidaprazoexex'];
        $aCSVCONTRATOS10['si83_prazoexecucao']                =   $aCONTRATOS10['si83_prazoexecucao'];
        $aCSVCONTRATOS10['si83_multarescisoria']              =   substr($aCONTRATOS10['si83_multarescisoria'], 0, 100);
        $aCSVCONTRATOS10['si83_multainadimplemento']          =   substr($aCONTRATOS10['si83_multainadimplemento'], 0, 100);
        $aCSVCONTRATOS10['si83_garantia']                     =   str_pad($aCONTRATOS10['si83_garantia'], 1, "0", STR_PAD_LEFT);
        $aCSVCONTRATOS10['si83_cpfsignatariocontratante']     =   str_pad($aCONTRATOS10['si83_cpfsignatariocontratante'], 11, "0", STR_PAD_LEFT);
        $aCSVCONTRATOS10['si83_datapublicacao']               =   implode("", array_reverse(explode("-", $aCONTRATOS10['si83_datapublicacao'])));
        $aCSVCONTRATOS10['si83_veiculodivulgacao']            =   substr($aCONTRATOS10['si83_veiculodivulgacao'], 0, 50);

        $this->sLinha = $aCSVCONTRATOS10;
        $this->adicionaLinha();
        /**
         * OBRAS
         * OC11837
         */

        if($aCONTRATOS10['si83_naturezaobjeto'] == "7" || $aCONTRATOS10['si83_naturezaobjeto'] == "1"){
          for ($iCont2 = 0;$iCont2 < pg_num_rows($rsCONTRATOS11); $iCont2++) {

            $aCONTRATOS11  = pg_fetch_array($rsCONTRATOS11,$iCont2);

            if ($aCONTRATOS10['si83_sequencial'] == $aCONTRATOS11['si84_reg10']) {

              $aCSVCONTRATOS11 = array();
              $aCSVCONTRATOS11['si84_tiporegistro']          =   str_pad($aCONTRATOS11['si84_tiporegistro'], 2, "0", STR_PAD_LEFT);
              $aCSVCONTRATOS11['si84_codcontrato']           =   substr($aCONTRATOS11['si84_codcontrato'], 0, 15);
              $aCSVCONTRATOS11['si84_coditem']               =   substr($aCONTRATOS11['si84_coditem'], 0, 15) == 0 ? '' : substr($aCONTRATOS11['si84_coditem'], 0, 15);
              $aCSVCONTRATOS11['si84_tipomaterial']          =   $aCONTRATOS11['si84_tipomaterial'] == 0 ? ' ' : $aCONTRATOS11['si84_tipomaterial'];
              $aCSVCONTRATOS11['si84_coditemsinapi']         =   $aCONTRATOS11['si84_coditemsinapi'];
              $aCSVCONTRATOS11['si84_coditemsimcro']         =   $aCONTRATOS11['si84_coditemsimcro'];
              $aCSVCONTRATOS11['si84_descoutrosmateriais']   =   $aCONTRATOS11['si84_descoutrosmateriais'];
              $aCSVCONTRATOS11['si84_itemplanilha']          =   $aCONTRATOS11['si84_itemplanilha'] == 0 ? ' ' : $aCONTRATOS11['si84_itemplanilha'];
              $aCSVCONTRATOS11['si84_quantidadeitem']        =   number_format($aCONTRATOS11['si84_quantidadeitem'], 4, ",", "");
              $aCSVCONTRATOS11['si84_valorunitarioitem']     =   number_format($aCONTRATOS11['si84_valorunitarioitem'], 4, ",", "");

              $this->sLinha = $aCSVCONTRATOS11;
              $this->adicionaLinha();
            }

          }
        }else{
          for ($iCont2 = 0;$iCont2 < pg_num_rows($rsCONTRATOS11); $iCont2++) {

            $aCONTRATOS11  = pg_fetch_array($rsCONTRATOS11,$iCont2);

            if ($aCONTRATOS10['si83_sequencial'] == $aCONTRATOS11['si84_reg10']) {

              $aCSVCONTRATOS11 = array();
              $aCSVCONTRATOS11['si84_tiporegistro']          =   str_pad($aCONTRATOS11['si84_tiporegistro'], 2, "0", STR_PAD_LEFT);
              $aCSVCONTRATOS11['si84_codcontrato']           =   substr($aCONTRATOS11['si84_codcontrato'], 0, 15);
              $aCSVCONTRATOS11['si84_coditem']               =   substr($aCONTRATOS11['si84_coditem'], 0, 15);
              $aCSVCONTRATOS11['si84_tipomaterial']          =   $aCONTRATOS11['si84_tipomaterial'] == 0 ? ' ' : $aCONTRATOS11['si84_tipomaterial'];
              $aCSVCONTRATOS11['si84_coditemsinapi']         =   $aCONTRATOS11['si84_coditemsinapi'];
              $aCSVCONTRATOS11['si84_coditemsimcro']         =   $aCONTRATOS11['si84_coditemsimcro'];
              $aCSVCONTRATOS11['si84_descoutrosmateriais']   =   $aCONTRATOS11['si84_descoutrosmateriais'];
              $aCSVCONTRATOS11['si84_itemplanilha']          =   $aCONTRATOS11['si84_itemplanilha'] == 0 ? ' ' : $aCONTRATOS11['si84_itemplanilha'];
              $aCSVCONTRATOS11['si84_quantidadeitem']        =   number_format($aCONTRATOS11['si84_quantidadeitem'], 4, ",", "");
              $aCSVCONTRATOS11['si84_valorunitarioitem']     =   number_format($aCONTRATOS11['si84_valorunitarioitem'], 4, ",", "");

              $this->sLinha = $aCSVCONTRATOS11;
              $this->adicionaLinha();
            }

          }
        }

        for ($iCont3 = 0;$iCont3 < pg_num_rows($rsCONTRATOS12); $iCont3++) {

          $aCONTRATOS12  = pg_fetch_array($rsCONTRATOS12,$iCont3);

          if ($aCONTRATOS10['si83_sequencial'] == $aCONTRATOS12['si85_reg10']) {

          	$aCSVCONTRATOS12 = array();
            $aCSVCONTRATOS12['si85_tiporegistro']          =   str_pad($aCONTRATOS12['si85_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVCONTRATOS12['si85_codcontrato']           =   substr($aCONTRATOS12['si85_codcontrato'], 0, 15);
            $aCSVCONTRATOS12['si85_codorgao']              =   str_pad($aCONTRATOS12['si85_codorgao'], 2, "0", STR_PAD_LEFT);
            $aCSVCONTRATOS12['si85_codunidadesub']         =   str_pad($aCONTRATOS12['si85_codunidadesub'], 5, "0", STR_PAD_LEFT);
            $aCSVCONTRATOS12['si85_codfuncao']             =   str_pad($aCONTRATOS12['si85_codfuncao'], 2, "0", STR_PAD_LEFT);
            $aCSVCONTRATOS12['si85_codsubfuncao']          =   str_pad($aCONTRATOS12['si85_codsubfuncao'], 3, "0", STR_PAD_LEFT);
            $aCSVCONTRATOS12['si85_codprograma']           =   str_pad($aCONTRATOS12['si85_codprograma'], 4, "0", STR_PAD_LEFT);
            $aCSVCONTRATOS12['si85_idacao']                =   $aCONTRATOS12['si85_idacao'] == '' ? ' ' : str_pad($aCONTRATOS12['si85_idacao'], 4, "0", STR_PAD_LEFT);
            $aCSVCONTRATOS12['si85_idsubacao']             =   $aCONTRATOS12['si85_idsubacao'] == '' ? ' ' : str_pad($aCONTRATOS12['si85_idsubacao'], 4, "0", STR_PAD_LEFT);
            $aCSVCONTRATOS12['si85_naturezadespesa']       =   str_pad($aCONTRATOS12['si85_naturezadespesa'], 6, "0", STR_PAD_LEFT);
            $aCSVCONTRATOS12['si85_codfontrecursos']       =   str_pad($aCONTRATOS12['si85_codfontrecursos'], 3, "0", STR_PAD_LEFT);
            $aCSVCONTRATOS12['si85_vlrecurso']             =   number_format($aCONTRATOS12['si85_vlrecurso'], 2, ",", "");

            $this->sLinha = $aCSVCONTRATOS12;
            $this->adicionaLinha();
          }

        }

        for ($iCont4 = 0;$iCont4 < pg_num_rows($rsCONTRATOS13); $iCont4++) {

          $aCONTRATOS13  = pg_fetch_array($rsCONTRATOS13,$iCont4);

          if ($aCONTRATOS10['si83_sequencial'] == $aCONTRATOS13['si86_reg10']) {

            $aCSVCONTRATOS13['si86_tiporegistro']          =   str_pad($aCONTRATOS13['si86_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVCONTRATOS13['si86_codcontrato']           =   substr($aCONTRATOS13['si86_codcontrato'], 0, 15);
            $aCSVCONTRATOS13['si86_tipodocumento']         =   str_pad($aCONTRATOS13['si86_tipodocumento'], 1, "0", STR_PAD_LEFT);
            $aCSVCONTRATOS13['si86_nrodocumento']          =   substr($aCONTRATOS13['si86_nrodocumento'], 0, 14);
            $aCSVCONTRATOS13['si86_cpfrepresentantelegal'] =   str_pad($aCONTRATOS13['si86_cpfrepresentantelegal'], 11, "0", STR_PAD_LEFT);

            $this->sLinha = $aCSVCONTRATOS13;
            $this->adicionaLinha();
          }

        }

      }

      /**
      *
      * Registros 20, 21
      */
      for ($iCont5 = 0;$iCont5 < pg_num_rows($rsCONTRATOS20); $iCont5++) {

        $aCONTRATOS20  = pg_fetch_array($rsCONTRATOS20,$iCont5);

        $aCSVCONTRATOS20['si87_tiporegistro']                  =  str_pad($aCONTRATOS20['si87_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVCONTRATOS20['si87_codaditivo']                    =  substr($aCONTRATOS20['si87_codaditivo'], 0, 15);
        $aCSVCONTRATOS20['si87_codorgao']                      =  str_pad($aCONTRATOS20['si87_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVCONTRATOS20['si87_codunidadesub']                 =  str_pad($aCONTRATOS20['si87_codunidadesub'], 5, "0", STR_PAD_LEFT);
        $aCSVCONTRATOS20['si87_nrocontrato']                   =  substr($aCONTRATOS20['si87_nrocontrato'], 0, 14);
        $aCSVCONTRATOS20['si87_dtassinaturacontoriginal']      =  implode("", array_reverse(explode("-", $aCONTRATOS20['si87_dtassinaturacontoriginal'])));
        $aCSVCONTRATOS20['si87_nroseqtermoaditivo']            =  str_pad($aCONTRATOS20['si87_nroseqtermoaditivo'], 2, "0", STR_PAD_LEFT);
        $aCSVCONTRATOS20['si87_dtassinaturatermoaditivo']      =  implode("", array_reverse(explode("-", $aCONTRATOS20['si87_dtassinaturatermoaditivo'])));
        $aCSVCONTRATOS20['si87_tipoalteracaovalor']            =  str_pad($aCONTRATOS20['si87_tipoalteracaovalor'], 1, "0", STR_PAD_LEFT);
        $aCSVCONTRATOS20['si87_tipotermoaditivo']              =  str_pad($aCONTRATOS20['si87_tipotermoaditivo'], 2, "0", STR_PAD_LEFT);
        $aCSVCONTRATOS20['si87_dscalteracao']                  =  substr($aCONTRATOS20['si87_dscalteracao'], 0, 250);
        $aCSVCONTRATOS20['si87_novadatatermino']               =  implode("", array_reverse(explode("-", $aCONTRATOS20['si87_novadatatermino'])));
        $aCSVCONTRATOS20['si87_valoraditivo']                  =  number_format($aCONTRATOS20['si87_valoraditivo'], 2, ",", "");
        $aCSVCONTRATOS20['si87_datapublicacao']                =  implode("", array_reverse(explode("-", $aCONTRATOS20['si87_datapublicacao'])));
        $aCSVCONTRATOS20['si87_veiculodivulgacao']             =  substr($aCONTRATOS20['si87_veiculodivulgacao'], 0, 50);

        $this->sLinha = $aCSVCONTRATOS20;
        $this->adicionaLinha();

        for ($iCont6 = 0;$iCont6 < pg_num_rows($rsCONTRATOS21); $iCont6++) {

          $aCONTRATOS21  = pg_fetch_array($rsCONTRATOS21,$iCont6);
          /**
           * OBRAS
           * OC11837
           */
          if($aCONTRATOS21['si88_tipomaterial'] != "0" || $aCONTRATOS21['si88_tipomaterial'] != NULL ){

            if ($aCONTRATOS20['si87_sequencial'] == $aCONTRATOS21['si88_reg20']) {

              $aCSVCONTRATOS21['si88_tiporegistro']         =  str_pad($aCONTRATOS21['si88_tiporegistro'], 2, "0", STR_PAD_LEFT);
              $aCSVCONTRATOS21['si88_codaditivo']           =  substr($aCONTRATOS21['si88_codaditivo'], 0, 15);
              $aCSVCONTRATOS21['si88_coditem']              =  substr($aCONTRATOS21['si88_coditem'], 0, 15) == 0 ? '' : substr($aCONTRATOS21['si88_coditem'], 0, 15);
              $aCSVCONTRATOS21['si88_tipomaterial']          =  $aCONTRATOS21['si88_tipomaterial']          == "0" ? '' : $aCONTRATOS21['si88_tipomaterial'];
              $aCSVCONTRATOS21['si88_coditemsinapi']         =   $aCONTRATOS21['si88_coditemsinapi']        == "0" ? '' : $aCONTRATOS21['si88_coditemsinapi'];
              $aCSVCONTRATOS21['si88_coditemsimcro']         =   $aCONTRATOS21['si88_coditemsimcro']        == "0" ? '' : $aCONTRATOS21['si88_coditemsimcro'];
              $aCSVCONTRATOS21['si88_descoutrosmateriais']   =   $aCONTRATOS21['si88_descoutrosmateriais']  == "0" ? '' : $aCONTRATOS21['si88_descoutrosmateriais'];
              $aCSVCONTRATOS21['si88_itemplanilha']          =   $aCONTRATOS21['si88_itemplanilha']         == "0" ? '' : substr($aCONTRATOS21['si88_itemplanilha'],0,15);
              $aCSVCONTRATOS21['si88_tipoalteracaoitem']    =  str_pad($aCONTRATOS21['si88_tipoalteracaoitem'], 1, "0", STR_PAD_LEFT);
              $aCSVCONTRATOS21['si88_quantacrescdecresc']   =  number_format($aCONTRATOS21['si88_quantacrescdecresc'], 4, ",", "");
              $aCSVCONTRATOS21['si88_valorunitarioitem']    =  number_format($aCONTRATOS21['si88_valorunitarioitem'], 4, ",", "");

              $this->sLinha = $aCSVCONTRATOS21;
              $this->adicionaLinha();
            }

          }else{
            if ($aCONTRATOS20['si87_sequencial'] == $aCONTRATOS21['si88_reg20']) {

              $aCSVCONTRATOS21['si88_tiporegistro']         =  str_pad($aCONTRATOS21['si88_tiporegistro'], 2, "0", STR_PAD_LEFT);
              $aCSVCONTRATOS21['si88_codaditivo']           =  substr($aCONTRATOS21['si88_codaditivo'], 0, 15);
              $aCSVCONTRATOS21['si88_coditem']              =  substr($aCONTRATOS21['si88_coditem'], 0, 15);
              $aCSVCONTRATOS21['si88_tipoalteracaoitem']    =  str_pad($aCONTRATOS21['si88_tipoalteracaoitem'], 1, "0", STR_PAD_LEFT);
              $aCSVCONTRATOS21['si88_quantacrescdecresc']   =  number_format($aCONTRATOS21['si88_quantacrescdecresc'], 4, ",", "");
              $aCSVCONTRATOS21['si88_valorunitarioitem']    =  number_format($aCONTRATOS21['si88_valorunitarioitem'], 4, ",", "");


              $this->sLinha = $aCSVCONTRATOS21;
              $this->adicionaLinha();
            }
          }
        }

      }

      /**
      *
      * Registros 30
      */
      for ($iCont7 = 0;$iCont7 < pg_num_rows($rsCONTRATOS30); $iCont7++) {

        $aCONTRATOS30  = pg_fetch_array($rsCONTRATOS30,$iCont7);

        $aCSVCONTRATOS30['si89_tiporegistro']                  =  str_pad($aCONTRATOS30['si89_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVCONTRATOS30['si89_codorgao']                      =  str_pad($aCONTRATOS30['si89_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVCONTRATOS30['si89_codunidadesub']                 =  $aCONTRATOS30['si89_codunidadesub'];
        $aCSVCONTRATOS30['si89_nrocontrato']                   =  substr($aCONTRATOS30['si89_nrocontrato'], 0, 14);
        $aCSVCONTRATOS30['si89_dtassinaturacontoriginal']      =  implode("", array_reverse(explode("-", $aCONTRATOS30['si89_dtassinaturacontoriginal'])));
        $aCSVCONTRATOS30['si89_tipoapostila']                  =  str_pad($aCONTRATOS30['si89_tipoapostila'], 2, "0", STR_PAD_LEFT);
        $aCSVCONTRATOS30['si89_nroseqapostila']                =  substr($aCONTRATOS30['si89_nroseqapostila'], 0, 3);
        $aCSVCONTRATOS30['si89_dataapostila']                  =  implode("", array_reverse(explode("-", $aCONTRATOS30['si89_dataapostila'])));
        $aCSVCONTRATOS30['si89_tipoalteracaoapostila']         =  str_pad($aCONTRATOS30['si89_tipoalteracaoapostila'], 1, "0", STR_PAD_LEFT);
        $aCSVCONTRATOS30['si89_dscalteracao']                  =  substr($aCONTRATOS30['si89_dscalteracao'], 0, 250);
        $aCSVCONTRATOS30['si89_valorapostila']                 =  number_format($aCONTRATOS30['si89_valorapostila'], 2, ",", "");

        $this->sLinha = $aCSVCONTRATOS30;
        $this->adicionaLinha();

      }

      /**
      *
      * Registros 40
      */
      for ($iCont8 = 0;$iCont8 < pg_num_rows($rsCONTRATOS40); $iCont8++) {

        $aCONTRATOS40  = pg_fetch_array($rsCONTRATOS40,$iCont8);

        $aCSVCONTRATOS40['si91_tiporegistro']                  =  str_pad($aCONTRATOS40['si91_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVCONTRATOS40['si91_codorgao']                      =  str_pad($aCONTRATOS40['si91_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVCONTRATOS40['si91_codunidadesub']                 =  $aCONTRATOS40['si91_codunidadesub'] == ' ' ? ' ' : str_pad($aCONTRATOS40['si91_codunidadesub'], (strlen($aCONTRATOS40['si91_codunidadesub']) <= 5 ? 5 : 8), "0", STR_PAD_LEFT);
        $aCSVCONTRATOS40['si91_nrocontrato']                   =  substr($aCONTRATOS40['si91_nrocontrato'], 0, 14);
        $aCSVCONTRATOS40['si91_dtassinaturacontoriginal']      =  implode("", array_reverse(explode("-", $aCONTRATOS40['si91_dtassinaturacontoriginal'])));
        $aCSVCONTRATOS40['si91_datarescisao']                  =  implode("", array_reverse(explode("-", $aCONTRATOS40['si91_datarescisao'])));
        $aCSVCONTRATOS40['si91_valorcancelamentocontrato']     =  number_format($aCONTRATOS40['si91_valorcancelamentocontrato'], 2, ",", "");

        $this->sLinha = $aCSVCONTRATOS40;
        $this->adicionaLinha();

      }

      $this->fechaArquivo();

    }

  }

}
