<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarANL extends GerarAM {

   /**
  * 
  * Mes de referÍncia
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "ANL";
    $this->abreArquivo();
    
    $sSql = "select * from anl102014 where si110_mes = ". $this->iMes ." and si110_instit = ".db_getsession("DB_instit");
    $rsANL10    = db_query($sSql);

    $sSql2 = "select * from anl112014 where si111_mes = ". $this->iMes ." and si111_instit = ".db_getsession("DB_instit");
    $rsANL11    = db_query($sSql2);


  if (pg_num_rows($rsANL10) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10, 11
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsANL10); $iCont++) {

        $aANL10  = pg_fetch_array($rsANL10,$iCont);
        
        $aCSVANL10['si110_tiporegistro']                    =   str_pad($aANL10['si110_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVANL10['si110_codorgao']                        =   str_pad($aANL10['si110_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVANL10['si110_codunidadesub']                   =   str_pad($aANL10['si110_codunidadesub'], 5, "0", STR_PAD_LEFT);
        $aCSVANL10['si110_nroempenho']                      =   substr($aANL10['si110_nroempenho'], 0, 22);
        $aCSVANL10['si110_dtempenho']                       =   implode("", array_reverse(explode("-", $aANL10['si110_dtempenho'])));
        $aCSVANL10['si110_dtanulacao']                      =   implode("", array_reverse(explode("-", $aANL10['si110_dtanulacao'])));
        $aCSVANL10['si110_nroanulacao']                     =   substr($aANL10['si110_nroanulacao'], 0, 22);
        $aCSVANL10['si110_tipoanulacao']                    =   str_pad($aANL10['si110_tipoanulacao'], 1, "0", STR_PAD_LEFT);
        $aCSVANL10['si110_especanulacaoempenho']            =   substr($aANL10['si110_especanulacaoempenho'], 0, 200);
        $aCSVANL10['si110_vlanulacao']                      =   number_format($aANL10['si110_vlanulacao'], 2, ",", "");
        
        $this->sLinha = $aCSVANL10;
        $this->adicionaLinha();

        for ($iCont2 = 0;$iCont2 < pg_num_rows($rsANL11); $iCont2++) {        

          $aANL11  = pg_fetch_array($rsANL11,$iCont2);
          
          if ($aANL10['si110_sequencial'] == $aANL11['si111_reg10']) {

            $aCSVANL11['si111_tiporegistro']                    =   str_pad($aANL11['si111_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVANL11['si111_codunidadesub']                   =   str_pad($aANL11['si111_codunidadesub'], 5, "0", STR_PAD_LEFT);
            $aCSVANL11['si111_nroempenho']                      =   substr($aANL11['si111_nroempenho'], 0, 22);
            $aCSVANL11['si111_nroanulacao']                     =   substr($aANL11['si111_nroanulacao'], 0, 22);
            $aCSVANL11['si111_codfontrecursos']                 =   str_pad($aANL11['si111_codfontrecursos'], 3, "0", STR_PAD_LEFT);
            $aCSVANL11['si111_vlanulacaofonte']                 =   number_format($aANL11['si111_vlanulacaofonte'], 2, ",", "");
            
            $this->sLinha = $aCSVANL11;
            $this->adicionaLinha();

          }

        }

      }

      $this->fechaArquivo();

  } 

 }
}