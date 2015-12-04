<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");
 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarABERLIC extends GerarAM {

   /**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "ABERLIC";
    $this->abreArquivo();
    
    $sSql = "select * from aberlic102015 where si46_mes = ". $this->iMes." and si46_instit=".db_getsession("DB_instit"); 
    $rsABERLIC10    = db_query($sSql); 

    $sSql2 = "select * from aberlic112015 where si47_mes = ". $this->iMes." and si47_instit=".db_getsession("DB_instit");;
    $rsABERLIC11    = db_query($sSql2);

    $sSql3 = "select * from aberlic122015 where si48_mes = ". $this->iMes." and si48_instit=".db_getsession("DB_instit");;
    $rsABERLIC12    = db_query($sSql3);

    $sSql4 = "select * from aberlic132015 where si49_mes = ". $this->iMes." and si49_instit=".db_getsession("DB_instit");;
    $rsABERLIC13    = db_query($sSql4);

    $sSql5 = "select * from aberlic142015 where si50_mes = ". $this->iMes." and si50_instit=".db_getsession("DB_instit");;
    $rsABERLIC14    = db_query($sSql5);

    $sSql6 = "select * from aberlic152015 where si51_mes = ". $this->iMes." and si51_instit=".db_getsession("DB_instit");;
    $rsABERLIC15    = db_query($sSql6);

    $sSql7 = "select * from aberlic162015 where si52_mes = ". $this->iMes." and si52_instit=".db_getsession("DB_instit");;
    $rsABERLIC16    = db_query($sSql7);

  if (pg_num_rows($rsABERLIC10) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10, 11, 12
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsABERLIC10); $iCont++) {

        $aABERLIC10  = pg_fetch_array($rsABERLIC10,$iCont);
        
        $aCSVABERLIC10['si46_tiporegistro']               =   str_pad($aABERLIC10['si46_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVABERLIC10['si46_codorgaoresp']               =   str_pad($aABERLIC10['si46_codorgaoresp'], 2, "0", STR_PAD_LEFT);
        $aCSVABERLIC10['si46_codunidadesubresp']          =   str_pad($aABERLIC10['si46_codunidadesubresp'], 5, "0", STR_PAD_LEFT);// capo alterado de 8 para 5
        $aCSVABERLIC10['si46_exerciciolicitacao']         =   str_pad($aABERLIC10['si46_exerciciolicitacao'], 4, "0", STR_PAD_LEFT);
        $aCSVABERLIC10['si46_nroprocessolicitatorio']     =   substr($aABERLIC10['si46_nroprocessolicitatorio'], 0, 12);
        $aCSVABERLIC10['si46_codmodalidadelicitacao']     =   str_pad($aABERLIC10['si46_codmodalidadelicitacao'], 1, "0", STR_PAD_LEFT);
        $aCSVABERLIC10['si46_nromodalidade']              =   substr($aABERLIC10['si46_nromodalidade'], 0, 10);
        $aCSVABERLIC10['si46_naturezaprocedimento']       =   str_pad($aABERLIC10['si46_naturezaprocedimento'], 1, "0", STR_PAD_LEFT);
        $aCSVABERLIC10['si46_dtabertura']                 =   implode("", array_reverse(explode("-", $aABERLIC10['si46_dtabertura'])));
        $aCSVABERLIC10['si46_dteditalconvite']            =   implode("", array_reverse(explode("-", $aABERLIC10['si46_dteditalconvite'])));
        $aCSVABERLIC10['si46_dtpublicacaoeditaldo']       =   implode("", array_reverse(explode("-", $aABERLIC10['si46_dtpublicacaoeditaldo'])));
        $aCSVABERLIC10['si46_dtpublicacaoeditalveiculo1'] =   implode("", array_reverse(explode("-", $aABERLIC10['si46_dtpublicacaoeditalveiculo1'])));
        $aCSVABERLIC10['si46_veiculo1publicacao']         =   substr($aABERLIC10['si46_veiculo1publicacao'], 0, 50);
        $aCSVABERLIC10['si46_dtpublicacaoeditalveiculo2'] =   implode("", array_reverse(explode("-", $aABERLIC10['si46_dtpublicacaoeditalveiculo2'])));
        $aCSVABERLIC10['si46_veiculo2publicacao']         =   substr($aABERLIC10['si46_veiculo2publicacao'], 0, 50);
        $aCSVABERLIC10['si46_dtrecebimentodoc']           =   implode("", array_reverse(explode("-", $aABERLIC10['si46_dtrecebimentodoc'])));
        $aCSVABERLIC10['si46_tipolicitacao']              =   $aABERLIC10['si46_tipolicitacao'] == 0 ? ' ' : $aABERLIC10['si46_tipolicitacao'];
        $aCSVABERLIC10['si46_naturezaobjeto']             =   $aABERLIC10['si46_naturezaobjeto'] == 0 ? ' ' : $aABERLIC10['si46_naturezaobjeto'];
        $aCSVABERLIC10['si46_objeto']                     =   substr($aABERLIC10['si46_objeto'], 0, 500);
        $aCSVABERLIC10['si46_regimeexecucaoobras']        =   $aABERLIC10['si46_regimeexecucaoobras'] == 0 ? ' ' : $aABERLIC10['si46_regimeexecucaoobras'];
        $aCSVABERLIC10['si46_nroconvidado']               =   $aABERLIC10['si46_nroconvidado'] == 0 ? ' ' : $aABERLIC10['si46_nroconvidado'];
        $aCSVABERLIC10['si46_clausulaprorrogacao']        =   substr($aABERLIC10['si46_clausulaprorrogacao'], 0, 250);
        $aCSVABERLIC10['si46_unidademedidaprazoexecucao'] =   str_pad($aABERLIC10['si46_unidademedidaprazoexecucao'], 1, "0", STR_PAD_LEFT);
        $aCSVABERLIC10['si46_prazoexecucao']              =   substr($aABERLIC10['si46_prazoexecucao'], 0, 4);
        $aCSVABERLIC10['si46_formapagamento']             =   substr($aABERLIC10['si46_formapagamento'], 0, 80);
        $aCSVABERLIC10['si46_criterioaceitabilidade']     =   substr($aABERLIC10['si46_criterioaceitabilidade'], 0, 80);
        $aCSVABERLIC10['si46_descontotabela']             =   str_pad($aABERLIC10['si46_descontotabela'], 1, "0", STR_PAD_LEFT);
        $aCSVABERLIC10['si46_processoporlote']            =   str_pad($aABERLIC10['si46_processoporlote'], 1, "0", STR_PAD_LEFT);
        $aCSVABERLIC10['si46_criteriodesempate']          =   str_pad($aABERLIC10['si46_criteriodesempate'], 1, "0", STR_PAD_LEFT);
        $aCSVABERLIC10['si46_destinacaoexclusiva']        =   str_pad($aABERLIC10['si46_destinacaoexclusiva'], 1, "0", STR_PAD_LEFT);
        $aCSVABERLIC10['si46_subcontratacao']             =   str_pad($aABERLIC10['si46_subcontratacao'], 1, "0", STR_PAD_LEFT);
        $aCSVABERLIC10['si46_limitecontratacao']          =   str_pad($aABERLIC10['si46_limitecontratacao'], 1, "0", STR_PAD_LEFT);
        
        $this->sLinha = $aCSVABERLIC10;
        $this->adicionaLinha();

        for ($iCont2 = 0;$iCont2 < pg_num_rows($rsABERLIC11); $iCont2++) {        

          $aABERLIC11  = pg_fetch_array($rsABERLIC11,$iCont2);
          
          if ($aABERLIC10['si46_sequencial'] == $aABERLIC11['si47_reg10']) {

            $aCSVABERLIC11['si47_tiporegistro']             =    str_pad($aABERLIC11['si47_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVABERLIC11['si47_codorgaoresp']             =    str_pad($aABERLIC11['si47_codorgaoresp'], 2, "0", STR_PAD_LEFT);
            $aCSVABERLIC11['si47_codunidadesubresp']        =    str_pad($aABERLIC11['si47_codunidadesubresp'], 5, "0", STR_PAD_LEFT);
            $aCSVABERLIC11['si47_exerciciolicitacao']       =    str_pad($aABERLIC11['si47_exerciciolicitacao'], 4, "0", STR_PAD_LEFT);
            $aCSVABERLIC11['si47_nroprocessolicitatorio']   =    substr($aABERLIC11['si47_nroprocessolicitatorio'], 0, 12);
            $aCSVABERLIC11['si47_nrolote']                  =    substr($aABERLIC11['si47_nrolote'], 0, 4);
            $aCSVABERLIC11['si47_dsclote']                  =    substr($aABERLIC11['si47_dsclote'], 0, 250);

            $this->sLinha = $aCSVABERLIC11;
            $this->adicionaLinha();
          }

        }

        for ($iCont3 = 0;$iCont3 < pg_num_rows($rsABERLIC12); $iCont3++) {

          $aABERLIC12  = pg_fetch_array($rsABERLIC12,$iCont3);
          
          if ($aABERLIC10['si46_sequencial'] == $aABERLIC12['si48_reg10']) {

            $aCSVABERLIC12['si48_tiporegistro']           = str_pad($aABERLIC12['si48_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVABERLIC12['si48_codorgaoresp']           = str_pad($aABERLIC12['si48_codorgaoresp'], 2, "0", STR_PAD_LEFT);
            $aCSVABERLIC12['si48_codunidadesubresp']      = str_pad($aABERLIC12['si48_codunidadesubresp'], 5, "0", STR_PAD_LEFT);
            $aCSVABERLIC12['si48_exerciciolicitacao']     = str_pad($aABERLIC12['si48_exerciciolicitacao'], 4, "0", STR_PAD_LEFT);
            $aCSVABERLIC12['si48_nroprocessolicitatorio'] = substr($aABERLIC12['si48_nroprocessolicitatorio'], 0, 12);
            $aCSVABERLIC12['si48_coditem']                = substr($aABERLIC12['si48_coditem'], 0, 15);
            $aCSVABERLIC12['si48_nroitem']                = substr($aABERLIC12['si48_nroitem'], -5);
            
            $this->sLinha = $aCSVABERLIC12;
            $this->adicionaLinha();

          }

        }

        for ($iCont4 = 0;$iCont4 < pg_num_rows($rsABERLIC13); $iCont4++) {

          $aABERLIC13  = pg_fetch_array($rsABERLIC13,$iCont4);
          
          if ($aABERLIC10['si46_sequencial'] == $aABERLIC13['si49_reg10']) {

            $aCSVABERLIC13['si49_tiporegistro']                = str_pad($aABERLIC13['si49_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVABERLIC13['si49_codorgaoresp']                = str_pad($aABERLIC13['si49_codorgaoresp'], 2, "0", STR_PAD_LEFT);
            $aCSVABERLIC13['si49_codunidadesubresp']           = str_pad($aABERLIC13['si49_codunidadesubresp'], 5, "0", STR_PAD_LEFT);
            $aCSVABERLIC13['si49_exerciciolicitacao']          = str_pad($aABERLIC13['si49_exerciciolicitacao'], 4, "0", STR_PAD_LEFT);
            $aCSVABERLIC13['si49_nroprocessolicitatorio']      = substr($aABERLIC13['si49_nroprocessolicitatorio'], 0, 12);
            $aCSVABERLIC13['si49_nrolote']                     = substr($aABERLIC13['si49_nrolote'], 0, 4);
            $aCSVABERLIC13['si49_coditem']                     = substr($aABERLIC13['si49_coditem'], 0, 15);
            
            $this->sLinha = $aCSVABERLIC13;
            $this->adicionaLinha();

          }

        }

        for ($iCont5 = 0;$iCont5 < pg_num_rows($rsABERLIC14); $iCont5++) {	        

          $aABERLIC14  = pg_fetch_array($rsABERLIC14,$iCont5);
          
          if ($aABERLIC10['si46_sequencial'] == $aABERLIC14['si50_reg10']) {

            $aCSVABERLIC14['si50_tiporegistro']                 = str_pad($aABERLIC14['si50_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVABERLIC14['si50_codorgaoresp']                 = str_pad($aABERLIC14['si50_codorgaoresp'], 2, "0", STR_PAD_LEFT);
            $aCSVABERLIC14['si50_codunidadesubresp']            = str_pad($aABERLIC14['si50_codunidadesubresp'], 5, "0", STR_PAD_LEFT);
            $aCSVABERLIC14['si50_exerciciolicitacao']           = str_pad($aABERLIC14['si50_exerciciolicitacao'], 4, "0", STR_PAD_LEFT);
            $aCSVABERLIC14['si50_nroprocessolicitatorio']       = substr($aABERLIC14['si50_nroprocessolicitatorio'], 0, 12);
            $aCSVABERLIC14['si50_nrolote']                      = $aABERLIC14['si50_nrolote'] == 0 ? ' ' : substr($aABERLIC14['si50_nrolote'], 0, 4);
            $aCSVABERLIC14['si50_coditem']                      = substr($aABERLIC14['si50_coditem'], 0, 15); 
            $aCSVABERLIC14['si50_dtcotacao']                    = implode("", array_reverse(explode("-", $aABERLIC14['si50_dtcotacao'])));
            $aCSVABERLIC14['si50_vlcotprecosunitario']          = number_format($aABERLIC14['si50_vlcotprecosunitario'], 4, ",", "");
            $aCSVABERLIC14['si50_quantidade']                   = number_format($aABERLIC14['si50_quantidade'], 4, ",", "");
            $aCSVABERLIC14['si50_vlminalienbens']               = number_format($aABERLIC14['si50_vlminalienbens'], 2, ",", "");
           
            
            $this->sLinha = $aCSVABERLIC14;
            $this->adicionaLinha();
          }

        }

        for ($iCont6 = 0;$iCont6 < pg_num_rows($rsABERLIC15); $iCont6++) {        

          $aABERLIC15  = pg_fetch_array($rsABERLIC15,$iCont6);
          
          if ($aABERLIC10['si46_sequencial'] == $aABERLIC15['si51_reg10']) {

            $aCSVABERLIC15['si51_tiporegistro']                 = str_pad($aABERLIC15['si51_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVABERLIC15['si51_codorgaoresp']                 = str_pad($aABERLIC15['si51_codorgaoresp'], 2, "0", STR_PAD_LEFT);
            $aCSVABERLIC15['si51_codunidadesubresp']            = str_pad($aABERLIC15['si51_codunidadesubresp'], 5, "0", STR_PAD_LEFT);
            $aCSVABERLIC15['si51_exerciciolicitacao']           = str_pad($aABERLIC15['si51_exerciciolicitacao'], 4, "0", STR_PAD_LEFT);
            $aCSVABERLIC15['si51_nroprocessolicitatorio']       = substr($aABERLIC15['si51_nroprocessolicitatorio'], 0, 12);
            $aCSVABERLIC15['si51_nrolote']                      = substr($aABERLIC15['si51_nrolote'], 0, 4);
            $aCSVABERLIC15['si51_coditem']                      = substr($aABERLIC15['si51_coditem'], 0, 15);
            $aCSVABERLIC15['si51_vlitem']                       = number_format($aABERLIC15['si51_vlitem'], 4, ",", "");
            
            $this->sLinha = $aCSVABERLIC15;
            $this->adicionaLinha();
          }

        }

        for ($iCont7 = 0;$iCont7 < pg_num_rows($rsABERLIC16); $iCont7++) {        

          $aABERLIC16  = pg_fetch_array($rsABERLIC16,$iCont7);
          
          if ($aABERLIC10['si46_sequencial'] == $aABERLIC16['si52_reg10']) {

            $aCSVABERLIC16['si52_tiporegistro']             = str_pad($aABERLIC16['si52_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVABERLIC16['si52_codorgaoresp']             = str_pad($aABERLIC16['si52_codorgaoresp'], 2, "0", STR_PAD_LEFT);
            $aCSVABERLIC16['si52_codunidadesubresp']        = str_pad($aABERLIC16['si52_codunidadesubresp'], 5, "0", STR_PAD_LEFT);
            $aCSVABERLIC16['si52_exerciciolicitacao']       = str_pad($aABERLIC16['si52_exerciciolicitacao'], 4, "0", STR_PAD_LEFT);
            $aCSVABERLIC16['si52_nroprocessolicitatorio']   = substr($aABERLIC16['si52_nroprocessolicitatorio'], 0, 12);
            $aCSVABERLIC16['si52_codorgao']                 = str_pad($aABERLIC16['si52_codorgao'], 2, "0", STR_PAD_LEFT);
            $aCSVABERLIC16['si52_codunidadesub']            = str_pad($aABERLIC16['si52_codunidadesub'], 5, "0", STR_PAD_LEFT);
            $aCSVABERLIC16['si52_codfuncao']                = str_pad($aABERLIC16['si52_codfuncao'], 2, "0", STR_PAD_LEFT);
            $aCSVABERLIC16['si52_codsubfuncao']             = str_pad($aABERLIC16['si52_codsubfuncao'], 3, "0", STR_PAD_LEFT);
            $aCSVABERLIC16['si52_codprograma']              = str_pad($aABERLIC16['si52_codprograma'], 4, "0", STR_PAD_LEFT);
            $aCSVABERLIC16['si52_idacao']                   = str_pad($aABERLIC16['si52_idacao'], 4, "0", STR_PAD_LEFT);
            $aCSVABERLIC16['si52_idsubacao']                = $aABERLIC16['si52_idsubacao'] == '' ? ' ' : str_pad($aABERLIC16['si52_idsubacao'], 4, "0", STR_PAD_LEFT);
            $aCSVABERLIC16['si52_naturezadespesa']          = str_pad($aABERLIC16['si52_naturezadespesa'], 6, "0", STR_PAD_LEFT);
            $aCSVABERLIC16['si52_codfontrecursos']          = str_pad($aABERLIC16['si52_codfontrecursos'], 3, "0", STR_PAD_LEFT);
            $aCSVABERLIC16['si52_vlrecurso']                = number_format($aABERLIC16['si52_vlrecurso'], 2, ",", "");
        
            $this->sLinha = $aCSVABERLIC16;
            $this->adicionaLinha();
          }

        }

      }

      $this->fechaArquivo();

  } 

	}

}