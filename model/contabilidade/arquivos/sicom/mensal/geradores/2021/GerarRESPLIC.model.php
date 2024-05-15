<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarRESPLIC extends GerarAM
{
  
  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;
  
  public function gerarDados()
  {
    
    $this->sArquivo = "RESPLIC";
    $this->abreArquivo();
    
    $sSql = "select * from resplic102021 where si55_mes = " . $this->iMes . " and si55_instit=" . db_getsession("DB_instit");
    $rsRESPLIC10 = db_query($sSql);
    
    $sSql2 = "select * from resplic202021 where si56_mes = " . $this->iMes . " and si56_instit=" . db_getsession("DB_instit");
    $rsRESPLIC20 = db_query($sSql2);
    
    if (pg_num_rows($rsRESPLIC10) == 0 && pg_num_rows($rsRESPLIC20) == 0) {
      
      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();
      
    } else {
      
      /**
       *
       * Registros 10
       */
      for ($iCont = 0; $iCont < pg_num_rows($rsRESPLIC10); $iCont++) {
        
        $aRESPLIC10 = pg_fetch_array($rsRESPLIC10, $iCont);
        
        $aCSVRESPLIC10['si55_tiporegistro']           = $this->padLeftZero($aRESPLIC10['si55_tiporegistro'], 2);
        $aCSVRESPLIC10['si55_codorgao']               = $this->padLeftZero($aRESPLIC10['si55_codorgao'], 2);
        $aCSVRESPLIC10['si55_codunidadesub']          =   substr($aRESPLIC10['si55_codunidadesub'], 0, 8);
        $aCSVRESPLIC10['si55_exerciciolicitacao']     = $this->padLeftZero($aRESPLIC10['si55_exerciciolicitacao'], 4);
        $aCSVRESPLIC10['si55_nroprocessolicitatorio'] = substr($aRESPLIC10['si55_nroprocessolicitatorio'], 0, 12);
        $aCSVRESPLIC10['si55_tiporesp']               = $this->padLeftZero($aRESPLIC10['si55_tiporesp'], 2);
        $aCSVRESPLIC10['si55_nrocpfresp']             = $this->padLeftZero($aRESPLIC10['si55_nrocpfresp'], 11);
        
        $this->sLinha = $aCSVRESPLIC10;
        $this->adicionaLinha();
        
      }
      
      /**
       *
       * Registros 20
       */
      for ($iCont2 = 0; $iCont2 < pg_num_rows($rsRESPLIC20); $iCont2++) {
        
        $aRESPLIC20 = pg_fetch_array($rsRESPLIC20, $iCont2);
        
        $aCSVRESPLIC20['si56_tiporegistro']           = $this->padLeftZero($aRESPLIC20['si56_tiporegistro'], 2);
        $aCSVRESPLIC20['si56_codorgao']               = $this->padLeftZero($aRESPLIC20['si56_codorgao'], 2);
        $aCSVRESPLIC20['si56_codunidadesub']          = substr($aRESPLIC20['si56_codunidadesub'], 0, 8);
        $aCSVRESPLIC20['si56_exerciciolicitacao']     = $this->padLeftZero($aRESPLIC20['si56_exerciciolicitacao'], 4);
        $aCSVRESPLIC20['si56_nroprocessolicitatorio'] = substr($aRESPLIC20['si56_nroprocessolicitatorio'], 0, 12);
        $aCSVRESPLIC20['si56_codtipocomissao']        = $this->padLeftZero($aRESPLIC20['si56_codtipocomissao'], 1);
        $aCSVRESPLIC20['si56_descricaoatonomeacao']   = $this->padLeftZero($aRESPLIC20['si56_descricaoatonomeacao'], 1);
        $aCSVRESPLIC20['si56_nroatonomeacao']         = substr($aRESPLIC20['si56_nroatonomeacao'], 0, 7);
        $aCSVRESPLIC20['si56_dataatonomeacao']        = $this->sicomDate($aRESPLIC20['si56_dataatonomeacao']);
        $aCSVRESPLIC20['si56_iniciovigencia']         = $this->sicomDate($aRESPLIC20['si56_iniciovigencia']);
        $aCSVRESPLIC20['si56_finalvigencia']          = $this->sicomDate($aRESPLIC20['si56_finalvigencia']);
        $aCSVRESPLIC20['si56_cpfmembrocomissao']      = $this->padLeftZero($aRESPLIC20['si56_cpfmembrocomissao'], 11);
        $aCSVRESPLIC20['si56_codatribuicao']          = $this->padLeftZero($aRESPLIC20['si56_codatribuicao'], 1);
        $aCSVRESPLIC20['si56_cargo']                  = substr($aRESPLIC20['si56_cargo'], 0, 50);
        $aCSVRESPLIC20['si56_naturezacargo']          = $this->padLeftZero($aRESPLIC20['si56_naturezacargo'], 1);
        
        $this->sLinha = $aCSVRESPLIC20;
        $this->adicionaLinha();
        
      }
      
      $this->fechaArquivo();
      
    }
    
  }
}
