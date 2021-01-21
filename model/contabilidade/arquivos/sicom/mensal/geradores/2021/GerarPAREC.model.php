<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarPAREC extends GerarAM
{
  
  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;
  
  public function gerarDados()
  {
    
    $this->sArquivo = "PAREC";
    $this->abreArquivo();
    
    $sSql = "select * from parec102021  where  si22_mes  =  " . $this->iMes . " and si22_instit = " . db_getsession("DB_instit");
    $rsPAREC10 = db_query($sSql);
    
    $sSql2 = "select * from parec112021 where  si23_mes  =  " . $this->iMes . " and si23_instit = " . db_getsession("DB_instit");
    $rsPAREC11 = db_query($sSql2);
    
    if (pg_num_rows($rsPAREC10) == 0) {
      
      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();
      
    } else {
      
      for ($iCont = 0; $iCont < pg_num_rows($rsPAREC10); $iCont++) {
        
        $aPAREC10 = pg_fetch_array($rsPAREC10, $iCont);

        $aCSVPAREC10['si22_tiporegistro']         = $this->padLeftZero($aPAREC10['si22_tiporegistro'], 2);
        $aCSVPAREC10['si22_codreduzido']          = substr($aPAREC10['si22_codreduzido'], 0, 15);
        $aCSVPAREC10['si22_codorgao']             = $this->padLeftZero($aPAREC10['si22_codorgao'], 2);
        $aCSVPAREC10['si22_ededucaodereceita']    = $this->padLeftZero($aPAREC10['si22_ededucaodereceita'], 1);
        $aCSVPAREC10['si22_identificadordeducao'] = $aPAREC10['si22_identificadordeducao'] == 0 ? ' ' : $this->padLeftZero($aPAREC10['si22_identificadordeducao'], 2);
        $aCSVPAREC10['si22_naturezareceita']      = $this->padLeftZero($aPAREC10['si22_naturezareceita'], 8);
        $aCSVPAREC10['si22_tipoatualizacao']      = $aPAREC10['si22_tipoatualizacao'];
        $aCSVPAREC10['si22_vlacrescidoreduzido']  = $this->sicomNumberReal($aPAREC10['si22_vlacrescidoreduzido'], 2);
        
        
        $this->sLinha = $aCSVPAREC10;
        $this->adicionaLinha();
        
        for ($iCont2 = 0; $iCont2 < pg_num_rows($rsPAREC11); $iCont2++) {
          
          $aPAREC11 = pg_fetch_array($rsPAREC11, $iCont2);
          if ($aPAREC10['si22_sequencial'] == $aPAREC11['si23_reg10']) {

            $aCSVPAREC11['si23_tiporegistro']     = $this->padLeftZero($aPAREC11['si23_tiporegistro'], 2);
            $aCSVPAREC11['si23_codreduzido']      = substr($aPAREC11['si23_codreduzido'], 0, 15);
            $aCSVPAREC11['si23_codFontrecursos']  = $this->padLeftZero($aPAREC11['si23_codfontrecursos'], 3);
            $aCSVPAREC11['si23_vlfonte']          = $this->sicomNumberReal($aPAREC11['si23_vlfonte'], 2);
            
            $this->sLinha = $aCSVPAREC11;
            $this->adicionaLinha();
          }
          
        }
        
      }
      
      $this->fechaArquivo();
      
    }
    
  }
  
}
