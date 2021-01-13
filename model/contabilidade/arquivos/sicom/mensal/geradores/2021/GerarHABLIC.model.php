<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarHABLIC extends GerarAM
{
  
  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;
  
  public function gerarDados()
  {
    
    $this->sArquivo = "HABLIC";
    $this->abreArquivo();
    
    $sSql = "select * from hablic102021 where si57_mes = " . $this->iMes . " and si57_instit=" . db_getsession("DB_instit");
    $rsHABLIC10 = db_query($sSql);
    
    $sSql2 = "select * from hablic112021 where si58_mes = " . $this->iMes . " and si58_instit=" . db_getsession("DB_instit");
    $rsHABLIC11 = db_query($sSql2);
    
    $sSql3 = "select * from hablic202021 where si59_mes = " . $this->iMes . " and si59_instit=" . db_getsession("DB_instit");
    $rsHABLIC20 = db_query($sSql3);
    
    if (pg_num_rows($rsHABLIC10) == 0 && pg_num_rows($rsHABLIC20) == 0) {
      
      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();
      
    } else {
      
      /**
       *
       * Registros 10 e 11
       */
      for ($iCont = 0; $iCont < pg_num_rows($rsHABLIC10); $iCont++) {
        
        $aHABLIC10 = pg_fetch_array($rsHABLIC10, $iCont);
        
        $aCSVHABLIC10['si57_tiporegistro']                        = $this->padLeftZero($aHABLIC10['si57_tiporegistro'], 2);
        $aCSVHABLIC10['si57_codorgao']                            = $this->padLeftZero($aHABLIC10['si57_codorgao'], 2);
        $aCSVHABLIC10['si57_codunidadesub']                       = $this->padLeftZero($aHABLIC10['si57_codunidadesub'], 5);
        $aCSVHABLIC10['si57_exerciciolicitacao']                  = $this->padLeftZero($aHABLIC10['si57_exerciciolicitacao'], 4);
        $aCSVHABLIC10['si57_nroprocessolicitatorio']              = substr($aHABLIC10['si57_nroprocessolicitatorio'], 0, 12);
        $aCSVHABLIC10['si57_tipodocumento']                       = $this->padLeftZero($aHABLIC10['si57_tipodocumento'], 1);
        $aCSVHABLIC10['si57_nrodocumento']                        = substr($aHABLIC10['si57_nrodocumento'], 0, 14);
        $aCSVHABLIC10['si57_objetosocial']                        = substr($aHABLIC10['si57_objetosocial'], 0, 2000);
        $aCSVHABLIC10['si57_orgaorespregistro']                   = $aHABLIC10['si57_orgaorespregistro'] == 0 ? '' : substr($aHABLIC10['si57_orgaorespregistro'], 0, 1);
        $aCSVHABLIC10['si57_dataregistro']                        = $this->sicomDate($aHABLIC10['si57_dataregistro']);
        $aCSVHABLIC10['si57_nroregistro']                         = substr($aHABLIC10['si57_nroregistro'], 0, 20);
        $aCSVHABLIC10['si57_dataregistrocvm']                     = $this->sicomDate($aHABLIC10['si57_dataregistrocvm']);
        $aCSVHABLIC10['si57_nroregistrocvm']                      = substr($aHABLIC10['si57_nroregistrocvm'], 0, 20);
        $aCSVHABLIC10['si57_nroinscricaoestadual']                = substr($aHABLIC10['si57_nroinscricaoestadual'], 0, 30);
        $aCSVHABLIC10['si57_ufinscricaoestadual']                 = $aHABLIC10['si57_ufinscricaoestadual'] == 0 ? '' : substr($aHABLIC10['si57_ufinscricaoestadual'], 0, 2);
        $aCSVHABLIC10['si57_nrocertidaoregularidadeinss']         = substr($aHABLIC10['si57_nrocertidaoregularidadeinss'], 0, 30);
        $aCSVHABLIC10['si57_dtemissaocertidaoregularidadeinss']   = $this->sicomDate($aHABLIC10['si57_dtemissaocertidaoregularidadeinss']);
        $aCSVHABLIC10['si57_dtvalidadecertidaoregularidadeinss']  = $this->sicomDate($aHABLIC10['si57_dtvalidadecertidaoregularidadeinss']);
        $aCSVHABLIC10['si57_nrocertidaoregularidadefgts']         = substr($aHABLIC10['si57_nrocertidaoregularidadefgts'], 0, 30);
        $aCSVHABLIC10['si57_dtemissaocertidaoregularidadefgts']   = $this->sicomDate($aHABLIC10['si57_dtemissaocertidaoregularidadefgts']);
        $aCSVHABLIC10['si57_dtvalidadecertidaoregularidadefgts']  = $this->sicomDate($aHABLIC10['si57_dtvalidadecertidaoregularidadefgts']);
        $aCSVHABLIC10['si57_nrocndt']                             = substr($aHABLIC10['si57_nrocndt'], 0, 30);
        $aCSVHABLIC10['si57_dtemissaocndt']                       = $this->sicomDate($aHABLIC10['si57_dtemissaocndt']);
        $aCSVHABLIC10['si57_dtvalidadecndt']                      = $this->sicomDate($aHABLIC10['si57_dtvalidadecndt']);
        $aCSVHABLIC10['si57_dthabilitacao']                       = $this->sicomDate($aHABLIC10['si57_dthabilitacao']);
        $aCSVHABLIC10['si57_presencalicitantes']                  = $this->padLeftZero($aHABLIC10['si57_presencalicitantes'], 1);
        $aCSVHABLIC10['si57_renunciarecurso']                     = $this->padLeftZero($aHABLIC10['si57_renunciarecurso'], 1);
        
        $this->sLinha = $aCSVHABLIC10;
        $this->adicionaLinha();
        
        for ($iCont2 = 0; $iCont2 < pg_num_rows($rsHABLIC11); $iCont2++) {
          
          $aHABLIC11 = pg_fetch_array($rsHABLIC11, $iCont2);
          
          if ($aHABLIC10['si57_sequencial'] == $aHABLIC11['si58_reg10']) {

            $aCSVHABLIC11['si58_tiporegistro']                    = $this->padLeftZero($aHABLIC11['si58_tiporegistro'], 2);
            $aCSVHABLIC11['si58_codorgao']                        = $this->padLeftZero($aHABLIC11['si58_codorgao'], 2);
            $aCSVHABLIC11['si58_codunidadesub']                   = $this->padLeftZero($aHABLIC11['si58_codunidadesub'], 5);
            $aCSVHABLIC11['si58_exerciciolicitacao']              = $this->padLeftZero($aHABLIC11['si58_exerciciolicitacao'], 4);
            $aCSVHABLIC11['si58_nroprocessolicitatorio']          = substr($aHABLIC11['si58_nroprocessolicitatorio'], 0, 12);
            $aCSVHABLIC11['si58_tipodocumentocnpjempresahablic']  = $this->padLeftZero($aHABLIC11['si58_tipodocumentocnpjempresahablic'], 1);
            $aCSVHABLIC11['si58_cnpjempresahablic']               = substr($aHABLIC11['si58_cnpjempresahablic'], 0, 14);
            $aCSVHABLIC11['si58_tipodocumentosocio']              = substr($aHABLIC11['si58_tipodocumentosocio'], 0, 1);
            $aCSVHABLIC11['si58_nrodocumentosocio']               = substr($aHABLIC11['si58_nrodocumentosocio'], 0, 14);
            $aCSVHABLIC11['si58_tipoparticipacao']                = $this->padLeftZero($aHABLIC11['si58_tipoparticipacao'], 1);
            
            $this->sLinha = $aCSVHABLIC11;
            $this->adicionaLinha();
          }
          
        }
        
      }
      
      /**
       *
       * Registros 20
       */
      for ($iCont3 = 0; $iCont3 < pg_num_rows($rsHABLIC20); $iCont3++) {
        
        $aHABLIC20 = pg_fetch_array($rsHABLIC20, $iCont3);

        $aCSVHABLIC20['si59_tiporegistro']                        = $this->padLeftZero($aHABLIC20['si59_tiporegistro'], 2);
        $aCSVHABLIC20['si59_codorgao']                            = $this->padLeftZero($aHABLIC20['si59_codorgao'], 2);
        $aCSVHABLIC20['si59_codunidadesub']                       = $this->padLeftZero($aHABLIC20['si59_codunidadesub'], 5);
        $aCSVHABLIC20['si59_exerciciolicitacao']                  = $this->padLeftZero($aHABLIC20['si59_exerciciolicitacao'], 4);
        $aCSVHABLIC20['si59_nroprocessolicitatorio']              = substr($aHABLIC20['si59_nroprocessolicitatorio'], 0, 12);
        $aCSVHABLIC20['si59_tipodocumento']                       = $this->padLeftZero($aHABLIC20['si59_tipodocumento'], 1);
        $aCSVHABLIC20['si59_nrodocumento']                        = substr($aHABLIC20['si59_nrodocumento'], 0, 14);
        $aCSVHABLIC10['si59_datacredenciamento']                  = $this->sicomDate($aHABLIC20['si59_datacredenciamento']);
        $aCSVHABLIC20['si59_nrolote']                             = substr($aHABLIC20['si59_nrolote'], 0, 4);
        $aCSVHABLIC20['si59_coditem']                             = substr($aHABLIC20['si59_coditem'], 0, 15);
        $aCSVHABLIC20['si59_nroinscricaoestadual']                = substr($aHABLIC20['si59_nroinscricaoestadual'], 0, 30);
        $aCSVHABLIC20['si59_ufinscricaoestadual']                 = $this->padLeftZero($aHABLIC20['si59_ufinscricaoestadual'], 2);
        $aCSVHABLIC20['si59_nrocertidaoregularidadeinss']         = substr($aHABLIC20['si59_nrocertidaoregularidadeinss'], 0, 30);
        $aCSVHABLIC20['si59_dataemissaocertidaoregularidadeinss'] = $this->sicomDate($aHABLIC20['si59_dataemissaocertidaoregularidadeinss']);
        $aCSVHABLIC20['si59_dtvalidadecertidaoregularidadeinss']  = $this->sicomDate($aHABLIC20['si59_dtvalidadecertidaoregularidadeinss']);
        $aCSVHABLIC20['si59_nrocertidaoregularidadefgts']         = substr($aHABLIC20['si59_nrocertidaoregularidadefgts'], 0, 30);
        $aCSVHABLIC20['si59_dtemissaocertidaoregularidadefgts']   = $this->sicomDate($aHABLIC20['si59_dtemissaocertidaoregularidadefgts']);
        $aCSVHABLIC20['si59_dtvalidadecertidaoregularidadefgts']  = $this->sicomDate($aHABLIC20['si59_dtvalidadecertidaoregularidadefgts']);
        $aCSVHABLIC20['si59_nrocndt']                             = substr($aHABLIC20['si59_nrocndt'], 0, 30);
        $aCSVHABLIC20['si59_dtemissaocndt']                       = $this->sicomDate($aHABLIC20['si59_dtemissaocndt']);
        $aCSVHABLIC20['si59_dtvalidadecndt']                      = $this->sicomDate($aHABLIC20['si59_dtvalidadecndt']);
        
        $this->sLinha = $aCSVHABLIC20;
        $this->adicionaLinha();
        
      }
      
      $this->fechaArquivo();
      
    }
    
  }
}
