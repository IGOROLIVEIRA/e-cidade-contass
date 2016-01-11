<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarNTF extends GerarAM {

   /**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "NTF";
    $this->abreArquivo();
    
    $sSql = "select * from ntf102016 where si143_mes = ". $this->iMes ." and si143_instit = ". db_getsession("DB_instit");
    $rsNTF10    = db_query($sSql);

    /*$sSql2 = "select * from ntf112016 where si144_mes = ". $this->iMes ." and si144_instit = ". db_getsession("DB_instit");
    $rsNTF11    = db_query($sSql2);*/

    $sSql3 = "select * from ntf202016 where si145_mes = ". $this->iMes ." and si145_instit = ". db_getsession("DB_instit");
    $rsNTF20    = db_query($sSql3);


  if (pg_num_rows($rsNTF10) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10, 11
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsNTF10); $iCont++) {

        $aNTF10  = pg_fetch_array($rsNTF10,$iCont);
        
        $aCSVNTF10['si143_tiporegistro']               =   str_pad($aNTF10['si143_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVNTF10['si143_codnotafiscal']              =   substr($aNTF10['si143_codnotafiscal'], 0, 15);
        $aCSVNTF10['si143_codorgao']                   =   str_pad($aNTF10['si143_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVNTF10['si143_nfnumero']                   =   substr($aNTF10['si143_nfnumero'], 0, 20);
        $aCSVNTF10['si143_nfserie']                    =   substr($aNTF10['si143_nfserie'], 0, 8);
        $aCSVNTF10['si143_tipodocumento']              =   str_pad($aNTF10['si143_tipodocumento'], 1, "0", STR_PAD_LEFT);
        $aCSVNTF10['si143_nrodocumento']               =   substr($aNTF10['si143_nrodocumento'], 0, 14);
        $aCSVNTF10['si143_nroinscestadual']            =   substr($aNTF10['si143_nroinscestadual'], 0, 30);
        $aCSVNTF10['si143_nroinscmunicipal']           =   substr($aNTF10['si143_nroinscmunicipal'], 0, 30);
        $aCSVNTF10['si143_nomemunicipio']              =   substr($aNTF10['si143_nomemunicipio'], 0, 120);
        $aCSVNTF10['si143_cepmunicipio']               =   str_pad($aNTF10['si143_cepmunicipio'], 8, "0", STR_PAD_LEFT);
        $aCSVNTF10['si143_ufcredor']                   =   str_pad($aNTF10['si143_ufcredor'], 2, "0", STR_PAD_LEFT);
        $aCSVNTF10['si143_notafiscaleletronica']       =   str_pad($aNTF10['si143_notafiscaleletronica'], 1, "0", STR_PAD_LEFT);
        $aCSVNTF10['si143_chaveacesso']                =   $aNTF10['si143_chaveacesso'] == 0 ? ' ' : $aNTF10['si143_chaveacesso'];
        $aCSVNTF10['si143_chaveacessomunicipal']       =   substr($aNTF10['si143_chaveacessomunicipal'], 0, 60);
        $aCSVNTF10['si143_nfaidf']                     =   substr($aNTF10['si143_nfaidf'], 0, 15);
        $aCSVNTF10['si143_dtemissaonf']                =   implode("", array_reverse(explode("-", $aNTF10['si143_dtemissaonf'])));
        $aCSVNTF10['si143_dtvencimentonf']             =   implode("", array_reverse(explode("-", $aNTF10['si143_dtvencimentonf'])));
        $aCSVNTF10['si143_nfvalortotal']               =   number_format($aNTF10['si143_nfvalortotal'], 2, ",", "");
        $aCSVNTF10['si143_nfvalordesconto']            =   number_format($aNTF10['si143_nfvalordesconto'], 2, ",", "");
        $aCSVNTF10['si143_nfvalorliquido']             =   number_format($aNTF10['si143_nfvalorliquido'], 2, ",", "");
        
        $this->sLinha = $aCSVNTF10;
        $this->adicionaLinha();

        /*for ($iCont2 = 0;$iCont2 < pg_num_rows($rsNTF11); $iCont2++) {        

          $aNTF11  = pg_fetch_array($rsNTF11,$iCont2);
          
          if ($aNTF10['si143_sequencial'] == $aNTF11['si144_reg10']) {

            $aCSVNTF11['si144_tiporegistro']             =    str_pad($aNTF11['si144_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVNTF11['si144_codnotafiscal']            =    substr($aNTF11['si144_codnotafiscal'], 0, 15);
            $aCSVNTF11['si144_coditem']                  =    substr($aNTF11['si144_coditem'], 0, 15);
            $aCSVNTF11['si144_quantidadeitem']           =    number_format($aNTF11['si144_quantidadeitem'], 4, ",", "");
            $aCSVNTF11['si144_valorunitarioitem']        =    number_format($aNTF11['si144_valorunitarioitem'], 4, ",", "");
            
            $this->sLinha = $aCSVNTF11;
            $this->adicionaLinha();
            
          }

        }*/

        for ($iCont3 = 0;$iCont3 < pg_num_rows($rsNTF20); $iCont3++) {        

          $aNTF20  = pg_fetch_array($rsNTF20,$iCont3);
          
          if ($aNTF10['si143_sequencial'] == $aNTF20['si145_reg10']) {

            $aCSVNTF20['si145_tiporegistro']             =    str_pad($aNTF20['si145_tiporegistro'], 2, "0", STR_PAD_LEFT);
            
            $aCSVNTF20['si145_nfnumero']                 =    substr($aNTF20['si145_nfnumero'], 0, 20);
            $aCSVNTF20['si145_nfserie']                  =    substr($aNTF20['si145_nfserie'], 0, 8);
            $aCSVNTF20['si145_tipodocumento']            =    $aNTF20['si145_tipodocumento'];
            $aCSVNTF20['si145_nrodocumento']             =   substr($aNTF20['si145_nrodocumento'], 0, 14);
            $aCSVNTF20['si145_chaveacesso']              =   $aNTF20['si145_chaveacesso'] == 0 ? ' ' : $aNTF10['si145_chaveacesso'];
            $aCSVNTF20['si145_dtemissaonf']              =   implode("", array_reverse(explode("-", $aNTF20['si145_dtemissaonf'])));
            
            $aCSVNTF20['si145_codunidadesub']            =    $aNTF20['si145_codunidadesub'];
            $aCSVNTF20['si145_dtempenho']                =    implode("", array_reverse(explode("-", $aNTF20['si145_dtempenho'])));
            $aCSVNTF20['si145_nroempenho']               =    substr($aNTF20['si145_nroempenho'], 0, 22);
            $aCSVNTF20['si145_dtliquidacao']             =    implode("", array_reverse(explode("-", $aNTF20['si145_dtliquidacao'])));
            $aCSVNTF20['si145_nroliquidacao']            =    substr($aNTF20['si145_nroliquidacao'], 0, 22);
            
            $this->sLinha = $aCSVNTF20;
            $this->adicionaLinha();
            
          }

        }

      }

      $this->fechaArquivo();

    }

  } 

}
