<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarEMP extends GerarAM {

   /**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "EMP";
    $this->abreArquivo();
    
    $sSql = "select * from emp102014 where si106_mes = ". $this->iMes ." and si106_instit = ".db_getsession("DB_instit");
    $rsEMP10    = db_query($sSql);

    $sSql2 = "select * from emp112014 where si107_mes = ". $this->iMes ." and si107_instit = ".db_getsession("DB_instit");
    $rsEMP11    = db_query($sSql2);

    $sSql3 = "select * from emp122014 where si108_mes = ". $this->iMes ." and si108_instit = ".db_getsession("DB_instit");
    $rsEMP12    = db_query($sSql3);

    $sSql4 = "select * from emp202014 where si109_mes = ". $this->iMes ." and si109_instit = ".db_getsession("DB_instit");
    $rsEMP20    = db_query($sSql4);


  if (pg_num_rows($rsEMP10) == 0 && pg_num_rows($rsEMP20) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10, 11, 12
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsEMP10); $iCont++) {

        $aEMP10  = pg_fetch_array($rsEMP10,$iCont);
        
        $aCSVEMP10['si106_tiporegistro']                    =   str_pad($aEMP10['si106_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVEMP10['si106_codorgao']                        =   str_pad($aEMP10['si106_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVEMP10['si106_codunidadesub']                   =   str_pad($aEMP10['si106_codunidadesub'], 5, "0", STR_PAD_LEFT);
        $aCSVEMP10['si106_codfuncao']                       =   str_pad($aEMP10['si106_codfuncao'], 2, "0", STR_PAD_LEFT);
        $aCSVEMP10['si106_codsubfuncao']                    =   str_pad($aEMP10['si106_codsubfuncao'], 3, "0", STR_PAD_LEFT);
        $aCSVEMP10['si106_codprograma']                     =   str_pad($aEMP10['si106_codprograma'], 4, "0", STR_PAD_LEFT);
        $aCSVEMP10['si106_idacao']                          =   str_pad($aEMP10['si106_idacao'], 4, "0", STR_PAD_LEFT);
        $aCSVEMP10['si106_idsubacao']                       =   $aEMP10['si106_idsubacao'] == 0 ? ' ' : str_pad($aEMP10['si106_idsubacao'], 4, "0", STR_PAD_LEFT);
        $aCSVEMP10['si106_naturezadespesa']                 =   str_pad($aEMP10['si106_naturezadespesa'], 6, "0", STR_PAD_LEFT);
        $aCSVEMP10['si106_subelemento']                     =   str_pad($aEMP10['si106_subelemento'], 2, "0", STR_PAD_LEFT);
        $aCSVEMP10['si106_nroempenho']                      =   substr($aEMP10['si106_nroempenho'], 0, 22);
        $aCSVEMP10['si106_dtempenho']                       =   implode("", array_reverse(explode("-", $aEMP10['si106_dtempenho'])));
        $aCSVEMP10['si106_modalidadeempenho']               =   str_pad($aEMP10['si106_modalidadeempenho'], 1, "0", STR_PAD_LEFT);
        $aCSVEMP10['si106_tpempenho']                       =   str_pad($aEMP10['si106_tpempenho'], 2, "0", STR_PAD_LEFT);
        $aCSVEMP10['si106_vlbruto']                         =   number_format($aEMP10['si106_vlbruto'], 2, ",", "");
        $aCSVEMP10['si106_especificacaoempenho']            =   substr($aEMP10['si106_especificacaoempenho'], 0, 200);
        $aCSVEMP10['si106_despdeccontrato']                 =   str_pad($aEMP10['si106_despdeccontrato'], 1, "0", STR_PAD_LEFT);
        $aCSVEMP10['si106_codorgaorespcontrato']            =   $aEMP10['si106_codorgaorespcontrato'] == '' ? ' ' : str_pad($aEMP10['si106_codorgaorespcontrato'], 2, "0", STR_PAD_LEFT);
        $aCSVEMP10['si106_codunidadesubrespcontrato']       =   $aEMP10['si106_codunidadesubrespcontrato'] == '' ? ' ' : str_pad($aEMP10['si106_codunidadesubrespcontrato'], 5, "0", STR_PAD_LEFT);
        $aCSVEMP10['si106_nrocontrato']                     =   $aEMP10['si106_nrocontrato'] == 0 ? ' ' : substr($aEMP10['si106_nrocontrato'], 0, 14);
        $aCSVEMP10['si106_dtassinaturacontrato']            =   $aEMP10['si106_dtassinaturacontrato'] == '' ? ' ' : implode("", array_reverse(explode("-", $aEMP10['si106_dtassinaturacontrato'])));
        $aCSVEMP10['si106_nrosequencialtermoaditivo']       =   $aEMP10['si106_nrosequencialtermoaditivo'] == '' ? ' ' : str_pad($aEMP10['si106_nrosequencialtermoaditivo'], 2, "0", STR_PAD_LEFT);
        $aCSVEMP10['si106_despdecconvenio']                 =   str_pad($aEMP10['si106_despdecconvenio'], 1, "0", STR_PAD_LEFT);
        $aCSVEMP10['si106_nroconvenio']                     =   $aEMP10['si106_nroconvenio'] == 0 ? ' ' : substr($aEMP10['si106_nroconvenio'], 0, 30);
        $aCSVEMP10['si106_dataassinaturaconvenio']          =   $aEMP10['si106_dataassinaturaconvenio'] == '' ? ' ' : implode("", array_reverse(explode("-", $aEMP10['si106_dataassinaturaconvenio'])));
        $aCSVEMP10['si106_despdeclicitacao']                =   str_pad($aEMP10['si106_despdeclicitacao'], 1, "0", STR_PAD_LEFT);
        $aCSVEMP10['si106_codorgaoresplicit']               =   $aEMP10['si106_codorgaoresplicit'] == '' ? ' ' : str_pad($aEMP10['si106_codorgaoresplicit'], 2, "0", STR_PAD_LEFT);
        $aCSVEMP10['si106_codunidadesubresplicit']          =   $aEMP10['si106_codunidadesubresplicit'] == '' ? ' ' : str_pad($aEMP10['si106_codunidadesubresplicit'], 5, "0", STR_PAD_LEFT);
        $aCSVEMP10['si106_nroprocessolicitatorio']          =   $aEMP10['si106_nroprocessolicitatorio'] == '' ? ' ' : substr($aEMP10['si106_nroprocessolicitatorio'], 0, 12);
        $aCSVEMP10['si106_exercicioprocessolicitatorio']    =   $aEMP10['si106_exercicioprocessolicitatorio'] == 0 ? ' ' : str_pad($aEMP10['si106_exercicioprocessolicitatorio'], 4, "0", STR_PAD_LEFT);
        $aCSVEMP10['si106_tipoprocesso']                    =   $aEMP10['si106_tipoprocesso'] == 0 ? ' ' : str_pad($aEMP10['si106_tipoprocesso'], 1, "0", STR_PAD_LEFT);
        $aCSVEMP10['si106_cpfordenador']                    =   str_pad($aEMP10['si106_cpfordenador'], 11, "0", STR_PAD_LEFT);
        
        $this->sLinha = $aCSVEMP10;
        $this->adicionaLinha();

        for ($iCont2 = 0;$iCont2 < pg_num_rows($rsEMP11); $iCont2++) {        

          $aEMP11  = pg_fetch_array($rsEMP11,$iCont2);
          
          if ($aEMP10['si106_sequencial'] == $aEMP11['si107_reg10']) {

            $aCSVEMP11['si107_tiporegistro']             =    str_pad($aEMP11['si107_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVEMP11['si107_codunidadesub']            =    str_pad($aEMP11['si107_codunidadesub'], 5, "0", STR_PAD_LEFT);
            $aCSVEMP11['si107_nroempenho']               =    substr($aEMP11['si107_nroempenho'], 0, 22);
            $aCSVEMP11['si107_codfontrecursos']          =    str_pad($aEMP11['si107_codfontrecursos'], 3, "0", STR_PAD_LEFT);
            $aCSVEMP11['si107_valorfonte']               =    number_format($aEMP11['si107_valorfonte'], 2, ",", "");
            
            $this->sLinha = $aCSVEMP11;
            $this->adicionaLinha();
          }

        }

        for ($iCont3 = 0;$iCont3 < pg_num_rows($rsEMP12); $iCont3++) {        

          $aEMP12  = pg_fetch_array($rsEMP12,$iCont3);
          
          if ($aEMP10['si106_sequencial'] == $aEMP12['si108_reg10']) {

            $aCSVEMP12['si108_tiporegistro']             =    str_pad($aEMP12['si108_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVEMP12['si108_codunidadesub']            =    str_pad($aEMP12['si108_codunidadesub'], 5, "0", STR_PAD_LEFT);
            $aCSVEMP12['si108_nroempenho']               =    substr($aEMP12['si108_nroempenho'], 0, 22);
            $aCSVEMP12['si108_tipodocumento']            =    str_pad($aEMP12['si108_tipodocumento'], 1, "0", STR_PAD_LEFT);
            $aCSVEMP12['si108_nrodocumento']             =    substr($aEMP12['si108_nrodocumento'], 0, 14);
            
            $this->sLinha = $aCSVEMP12;
            $this->adicionaLinha();
          }

        }

      }

      /**
      *
      * Registros 20
      */
      for ($iCont4 = 0;$iCont4 < pg_num_rows($rsEMP20); $iCont4++) {

        $aEMP20  = pg_fetch_array($rsEMP20,$iCont4);
        
        $aCSVEMP20['si109_tiporegistro']             =    str_pad($aEMP20['si109_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVEMP20['si109_codorgao']                 =    str_pad($aEMP20['si109_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVEMP20['si109_codunidadesub']            =    str_pad($aEMP20['si109_tiporegistro'], 8, "0", STR_PAD_LEFT);
        $aCSVEMP20['si109_nroempenho']               =    substr($aEMP20['si109_descrmovimentacao'], 0, 22);
        $aCSVEMP20['si109_dtempenho']                =    implode("", array_reverse(explode("-", $aEMP20['si109_dtempenho'])));
        $aCSVEMP20['si109_nroreforco']               =    substr($aEMP20['si109_nroreforco'], 0, 22);
        $aCSVEMP20['si109_dtreforco']                =    implode("", array_reverse(explode("-", $aEMP20['si109_dtreforco'])));
        $aCSVEMP20['si109_codfontrecursos']          =    str_pad($aEMP20['si109_codfontrecursos'], 3, "0", STR_PAD_LEFT);
        $aCSVEMP20['si109_vlreforco']                =    number_format($aEMP20['si109_vlreforco'], 2, ",", "");

        $this->sLinha = $aCSVEMP20;
        $this->adicionaLinha();

      }

      $this->fechaArquivo();

  } 
  }
}