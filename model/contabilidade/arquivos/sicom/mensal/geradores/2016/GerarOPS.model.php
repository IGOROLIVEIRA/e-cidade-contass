<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarOPS extends GerarAM {

   /**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "OPS";
    $this->abreArquivo();
    
    $sSql = "select * from ops102016 where si132_mes = ". $this->iMes . " and si132_instit = ".db_getsession("DB_instit");
    $rsOPS10    = db_query($sSql);

    $sSql2 = "select * from ops112016 where si133_mes = ". $this->iMes . " and si133_instit = ".db_getsession("DB_instit");
    $rsOPS11    = db_query($sSql2);

    $sSql3 = "select * from ops122016 where si134_mes = ". $this->iMes . " and si134_instit = ".db_getsession("DB_instit");
    $rsOPS12    = db_query($sSql3);

    $sSql4 = "select * from ops132016 where si135_mes = ". $this->iMes . " and si135_instit = ".db_getsession("DB_instit");
    $rsOPS13    = db_query($sSql4);

    $sSql5 = "select * from ops142016 where si136_mes = ". $this->iMes . " and si136_instit = ".db_getsession("DB_instit");
    $rsOPS14    = db_query($sSql5);

  if (pg_num_rows($rsOPS10) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10, 11, 12 , 13, 14
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsOPS10); $iCont++) {

        $aOPS10  = pg_fetch_array($rsOPS10,$iCont);
        
        $aCSVOPS10['si132_tiporegistro']               =   str_pad($aOPS10['si132_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVOPS10['si132_codorgao']                   =   str_pad($aOPS10['si132_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVOPS10['si132_codunidadesub']              =   str_pad($aOPS10['si132_codunidadesub'], 5, "0", STR_PAD_LEFT);
        $aCSVOPS10['si132_nroop']                      =   substr($aOPS10['si132_nroop'], 0, 22);
        $aCSVOPS10['si132_dtpagamento']                =   implode("", array_reverse(explode("-", $aOPS10['si132_dtpagamento'])));
        $aCSVOPS10['si132_vlop']                       =   number_format($aOPS10['si132_vlop'], 2, ",", "");
        $aCSVOPS10['si132_especificacaoop']            =   substr($aOPS10['si132_especificacaoop'], 0, 200);
        $aCSVOPS10['si132_cpfresppgto']                =   str_pad($aOPS10['si132_cpfresppgto'], 11, "0", STR_PAD_LEFT);
        
        $this->sLinha = $aCSVOPS10;
        $this->adicionaLinha();

        for ($iCont2 = 0;$iCont2 < pg_num_rows($rsOPS11); $iCont2++) {        

          $aOPS11  = pg_fetch_array($rsOPS11,$iCont2);
          
          if ($aOPS10['si132_sequencial'] == $aOPS11['si133_reg10']) {

            $aCSVOPS11['si133_tiporegistro']             =    str_pad($aOPS11['si133_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVOPS11['si133_codreduzidoop']            =    substr($aOPS11['si133_codreduzidoop'], 0, 15);
            $aCSVOPS11['si133_codunidadesub']            =    str_pad($aOPS11['si133_codunidadesub'], 5, "0", STR_PAD_LEFT);
            $aCSVOPS11['si133_nroop']                    =    substr($aOPS11['si133_nroop'], 0, 22);
            $aCSVOPS11['si133_dtpagamento']              =    implode("", array_reverse(explode("-", $aOPS11['si133_dtpagamento'])));
            $aCSVOPS11['si133_tipopagamento']            =    str_pad($aOPS11['si133_tipopagamento'], 1, "0", STR_PAD_LEFT);
            $aCSVOPS11['si133_nroempenho']               =    substr($aOPS11['si133_nroempenho'], 0, 22);
            $aCSVOPS11['si133_dtempenho']                =    implode("", array_reverse(explode("-", $aOPS11['si133_dtempenho'])));
            $aCSVOPS11['si133_nroliquidacao']            =    substr($aOPS11['si133_nroliquidacao'], 0, 22);
            $aCSVOPS11['si133_dtliquidacao']             =    implode("", array_reverse(explode("-", $aOPS11['si133_dtliquidacao'])));
            $aCSVOPS11['si133_codfontrecursos']          =    str_pad($aOPS11['si133_codfontrecursos'], 3, "0", STR_PAD_LEFT);
            $aCSVOPS11['si133_valorfonte']               =    number_format($aOPS11['si133_valorfonte'], 2, ",", "");
            $aCSVOPS11['si133_tipodocumentocredor']      =    str_pad($aOPS11['si133_tipodocumentocredor'], 1, "0", STR_PAD_LEFT);
            $aCSVOPS11['si133_nrodocumento']             =    substr($aOPS11['si133_nrodocumento'], 0, 14);
            $aCSVOPS11['si133_codorgaoempop']            =    " ";
            $aCSVOPS11['si133_codunidadeempop']          =    " ";

            $this->sLinha = $aCSVOPS11;
            $this->adicionaLinha();
          }

        }

        for ($iCont3 = 0;$iCont3 < pg_num_rows($rsOPS12); $iCont3++) {

          $aOPS12  = pg_fetch_array($rsOPS12,$iCont3);
          
          if ($aOPS10['si132_sequencial'] == $aOPS12['si134_reg10']) {

            $aCSVOPS12['si134_tiporegistro']      = str_pad($aOPS12['si134_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVOPS12['si134_codreduzidoop']     = substr($aOPS12['si134_codreduzidoop'], 0, 15);
            $aCSVOPS12['si134_tipodocumentoop']   = substr($aOPS12['si134_tipodocumentoop'], 0, 2);
            $aCSVOPS12['si134_nrodocumento']      = $aOPS12['si134_nrodocumento'] == '' ? " " : $aOPS12['si134_nrodocumento'];
            $aCSVOPS12['si134_codctb']            = substr($aOPS12['si134_codctb'], 0, 20) == 0 ? " " : substr($aOPS12['si134_codctb'], 0, 20);
            $aCSVOPS12['si134_codfontectb']       = str_pad($aOPS12['si134_codfontectb'], 3, "0", STR_PAD_LEFT)  == 0 ? " " : str_pad($aOPS12['si134_codfontectb'], 3, "0", STR_PAD_LEFT);
            $aCSVOPS12['si134_desctipodocumentoop']      =    substr($aOPS12['si134_desctipodocumentoop'], 0, 50);           
            $aCSVOPS12['si134_dtemissao']         = implode("", array_reverse(explode("-", $aOPS12['si134_dtemissao'])));
            $aCSVOPS12['si134_vldocumento']       = number_format($aOPS12['si134_vldocumento'], 2, ",", "");
            
            $this->sLinha = $aCSVOPS12;
            $this->adicionaLinha();

          }

        }

        for ($iCont4 = 0;$iCont4 < pg_num_rows($rsOPS13); $iCont4++) {

          $aOPS13  = pg_fetch_array($rsOPS13,$iCont4);
          
          if ($aOPS10['si132_sequencial'] == $aOPS13['si135_reg10']) {

            $aCSVOPS13['si135_tiporegistro']                = str_pad($aOPS13['si135_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVOPS13['si135_codreduzidoop']               = substr($aOPS13['si135_codreduzidoop'], 0, 15);
            $aCSVOPS13['si135_tiporetencao']                = str_pad($aOPS13['si135_tiporetencao'], 4, "0", STR_PAD_LEFT);
            $aCSVOPS13['si135_descricaoretencao']           = substr($aOPS13['si135_descricaoretencao'], 0, 50);
            $aCSVOPS13['si135_vlretencao']                  = number_format($aOPS13['si135_vlretencao'], 2, ",", "");

            $this->sLinha = $aCSVOPS13;
            $this->adicionaLinha();

          }

        }

        for ($iCont5 = 0;$iCont5 < pg_num_rows($rsOPS14); $iCont5++) {        

          $aOPS14  = pg_fetch_array($rsOPS14,$iCont5);
          
          if ($aOPS10['si132_sequencial'] == $aOPS14['si136_reg10']) {

            $aCSVOPS14['si136_tiporegistro']                 = str_pad($aOPS14['si136_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVOPS14['si136_codreduzidoop']                = substr($aOPS14['si136_codreduzidoop'], 0, 15);
            $aCSVOPS14['si136_tipovlantecipado']             = str_pad($aOPS14['si136_tipovlantecipado'], 2, "0", STR_PAD_LEFT);
            $aCSVOPS14['si136_descricaovlantecipado']        = substr($aOPS14['si136_descricaovlantecipado'], 0, 50);
            $aCSVOPS14['si136_vlantecipado']                 = number_format($aOPS14['si136_vlantecipado'], 2, ",", "");
            
            $this->sLinha = $aCSVOPS14;
            $this->adicionaLinha();
          }

        }

      }

      $this->fechaArquivo();

  } 
  }

}
