<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarAOC extends GerarAM {

   /**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "AOC";
    $this->abreArquivo();
    
    $sSql = "select * from aoc102014 where si38_mes = ". $this->iMes." and si38_instit = ".db_getsession("DB_instit");
    $rsAOC10    = db_query($sSql);

    $sSql2 = "select * from aoc112014 where si39_mes = ". $this->iMes." and si39_instit = ".db_getsession("DB_instit");
    $rsAOC11    = db_query($sSql2);

    $sSql3 = "select * from aoc122014 where si40_mes = ". $this->iMes." and si40_instit = ".db_getsession("DB_instit");
    $rsAOC12    = db_query($sSql3);

    $sSql4 = "select * from aoc132014 where si41_mes = ". $this->iMes." and si41_instit = ".db_getsession("DB_instit");
    $rsAOC13    = db_query($sSql4);

    $sSql5 = "select * from aoc142014 where si42_mes = ". $this->iMes." and si42_instit = ".db_getsession("DB_instit");
    $rsAOC14    = db_query($sSql5);

  if (pg_num_rows($rsAOC10) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10, 11, 12
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsAOC10); $iCont++) {

        $aAOC10  = pg_fetch_array($rsAOC10,$iCont);
        
        $aCSVAOC10['si38_tiporegistro']               =   str_pad($aAOC10['si38_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVAOC10['si38_codorgao']                   =   str_pad($aAOC10['si38_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVAOC10['si38_nrodecreto']            =   substr($aAOC10['si38_nrodecreto'], 0, 8  );
        $aCSVAOC10['si38_datadecreto']           =   implode("", array_reverse(explode("-", $aAOC10['si38_datadecreto'])));
        
        $this->sLinha = $aCSVAOC10;
        $this->adicionaLinha();

        for ($iCont2 = 0;$iCont2 < pg_num_rows($rsAOC11); $iCont2++) {        

          $aAOC11  = pg_fetch_array($rsAOC11,$iCont2);
          
          if ($aAOC10['si38_sequencial'] == $aAOC11['si39_reg10']) {

            $aCSVAOC11['si39_tiporegistro']             =    str_pad($aAOC11['si39_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVAOC11['si39_codreduzidodecreto']       =    substr($aAOC11['si39_codreduzidodecreto'], 0, 15);
            $aCSVAOC11['si39_nrodecreto']               =    substr($aAOC11['si39_nrodecreto'], 0, 8);
            $aCSVAOC11['si39_tipodecretoalteracao']     =    str_pad($aAOC11['si39_tipodecretoalteracao'], 2, "0", STR_PAD_LEFT);
            $aCSVAOC11['si39_valoraberto']              =    number_format($aAOC11['si39_valoraberto'], 2, ",", "");
            
            $this->sLinha = $aCSVAOC11;
            $this->adicionaLinha();
          }

        }

        for ($iCont3 = 0;$iCont3 < pg_num_rows($rsAOC12); $iCont3++) {        

          $aAOC12  = pg_fetch_array($rsAOC12,$iCont3);
          
          if ($aAOC10['si38_sequencial'] == $aAOC12['si40_reg10']) {

            $aCSVAOC12['si40_tiporegistro']       = str_pad($aAOC12['si40_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVAOC12['si40_codreduzidodecreto'] = substr($aAOC12['si40_codreduzidodecreto'], 0, 15);
            $aCSVAOC12['si40_nroleialteracao']    = substr($aAOC12['si40_nroleialteracao'], 0, 6);
            $aCSVAOC12['si40_dataleialteracao']   = implode("", array_reverse(explode("-", $aAOC12['si40_dataleialteracao'])));
            
            $this->sLinha = $aCSVAOC12;
            $this->adicionaLinha();
          }

        }

        for ($iCont3 = 0;$iCont3 < pg_num_rows($rsAOC13); $iCont3++) {        

          $aAOC13  = pg_fetch_array($rsAOC13,$iCont3);
          
          if ($aAOC10['si38_sequencial'] == $aAOC13['si41_reg10']) {

            $aCSVAOC13['si41_tiporegistro']       = str_pad($aAOC13['si41_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVAOC13['si41_codreduzidodecreto'] = substr($aAOC13['si41_codreduzidodecreto'], 0, 15);
            $aCSVAOC13['si41_origemrecalteracao'] = str_pad($aAOC13['si41_origemrecalteracao'], 2, "0", STR_PAD_LEFT);
            $aCSVAOC13['si41_valorabertoorigem']  = number_format($aAOC13['si41_valorabertoorigem'], 2, ",", "");
            
            $this->sLinha = $aCSVAOC13;
            $this->adicionaLinha();
          }

        }

        for ($iCont4 = 0;$iCont4 < pg_num_rows($rsAOC14); $iCont4++) {        

          $aAOC14  = pg_fetch_array($rsAOC14,$iCont4);
          
          if ($aAOC10['si38_sequencial'] == $aAOC14['si42_reg10']) {

            $aCSVAOC14['si42_tiporegistro']        = str_pad($aAOC14['si42_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVAOC14['si42_codreduzidodecreto']  = substr($aAOC14['si42_codreduzidodecreto'], 0, 15);  
            $aCSVAOC14['si42_tipoalteracao']       = substr($aAOC14['si42_tipoalteracao'], 0, 1);  
            $aCSVAOC14['si42_codorgao']            = str_pad($aAOC14['si42_codorgao'], 2, "0", STR_PAD_LEFT);
            $aCSVAOC14['si42_codunidadesub']       = substr($aAOC14['si42_codunidadesub'], 0, 8);
            $aCSVAOC14['si42_codfuncao']           = str_pad($aAOC14['si42_codfuncao'], 2, "0", STR_PAD_LEFT);
            $aCSVAOC14['si42_codsubfuncao']        = str_pad($aAOC14['si42_codsubfuncao'], 3, "0", STR_PAD_LEFT);
            $aCSVAOC14['si42_codprograma']         = str_pad($aAOC14['si42_codprograma'], 4, "0", STR_PAD_LEFT);            
            $aCSVAOC14['si42_idacao']              = $aAOC14['si42_idacao'] == '' ? ' ' : str_pad($aAOC14['si42_idacao'], 4, "0", STR_PAD_LEFT);            
            $aCSVAOC14['si42_idsubacao']           = $aAOC14['si42_idsubacao'] == '' ? ' ' : str_pad($aAOC14['si42_idsubacao'], 4, "0", STR_PAD_LEFT);   
            $aCSVAOC14['si42_naturezadespesa']     = str_pad($aAOC14['si42_naturezadespesa'], 6, "0", STR_PAD_LEFT);   
            $aCSVAOC14['si42_codfontrecursos']     = str_pad($aAOC14['si42_codfontrecursos'], 3, "0", STR_PAD_LEFT);   
            $aCSVAOC14['si42_vlacrescimoreducao']  = number_format($aAOC14['si42_vlacrescimoreducao'], 2, ",", "");
            
            $this->sLinha = $aCSVAOC14;
            $this->adicionaLinha();
          }

        }

      }

      $this->fechaArquivo();

  } 

}

}