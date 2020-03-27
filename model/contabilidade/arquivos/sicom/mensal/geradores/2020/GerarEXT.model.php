<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");
require_once ("classes/db_conplano_classe.php");


/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarEXT extends GerarAM
{
  
  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;
  
  public function gerarDados()
  {

    $clconplano       = new cl_conplano();
    $this->sArquivo = "EXT";
    $this->abreArquivo();
    
    $sSql = "select * from ext102020 where si124_mes = " . $this->iMes . " and  si124_instit = " . db_getsession("DB_instit");
    $rsEXT10 = db_query($sSql);
    
    $sSql = "select * from ext202020 where si165_mes = " . $this->iMes . " and  si165_instit = " . db_getsession("DB_instit");
    $rsEXT20 = db_query($sSql);
    
    $sSql3 = "select * from EXT302020 where si126_mes = " . $this->iMes . " and  si126_instit = " . db_getsession("DB_instit");
    $rsEXT30 = db_query($sSql3);
    
    $sSql4 = "select * from EXT312020 where si127_mes = " . $this->iMes . " and  si127_instit = " . db_getsession("DB_instit");
    $rsEXT31 = db_query($sSql4);
    
    $sSql5 = "select * from EXT322020 where si128_mes = " . $this->iMes . " and  si128_instit = " . db_getsession("DB_instit");
    $rsEXT32 = db_query($sSql5);
    
    
    if (pg_num_rows($rsEXT10) == 0 && pg_num_rows($rsEXT20) == 0) {
      
      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();
      
    } else {
      
      /**
       *
       * Registros 10
       */
      for ($iCont = 0; $iCont < pg_num_rows($rsEXT10); $iCont++) {
        
        $aEXT10 = pg_fetch_array($rsEXT10, $iCont);
        
        $aCSVEXT10['si124_tiporegistro']    = $this->padLeftZero($aEXT10['si124_tiporegistro'], 2);
        $aCSVEXT10['si124_codext']          = substr($aEXT10['si124_codext'], 0, 15);
        $aCSVEXT10['si124_codorgao']        = $this->padLeftZero($aEXT10['si124_codorgao'], 2);
        $aCSVEXT10['si124_tipolancamento']  = $this->padLeftZero($aEXT10['si124_tipolancamento'], 2);
        $aCSVEXT10['si124_subtipo']         = $this->padLeftZero($aEXT10['si124_subtipo'], 4);
        $aCSVEXT10['si124_desdobrasubtipo'] = $aEXT10['si124_desdobrasubtipo'] == 0 ? ' ' : $this->padLeftZero($aEXT10['si124_desdobrasubtipo'], 4);
        $aCSVEXT10['si124_descextraorc']    = substr($aEXT10['si124_descextraorc'], 0, 50);

        $this->sLinha = $aCSVEXT10;
        $this->adicionaLinha();
        
      }
      
      /**
       *
       * Registros 20
       */
      for ($iCont = 0; $iCont < pg_num_rows($rsEXT20); $iCont++) {
        
        $aEXT20 = pg_fetch_array($rsEXT20, $iCont);

        //OC11537
        $aFontes  = array('148', '149', '150', '151', '152', '248', '249', '250', '251', '252', '159');
        $bFonteEncerrada    = in_array($aEXT20['si165_codfontrecursos'], $aFontes);
        $bCorrecaoFonte     = ($bFonteEncerrada && $aEXT20['si165_mes'] == '01' && db_getsession("DB_anousu") == 2020);

        $aCSVEXT20['si165_tiporegistro']          = $this->padLeftZero($aEXT20['si165_tiporegistro'], 2);
        $aCSVEXT20['si165_codorgao']              = $this->padLeftZero($aEXT20['si165_codorgao'], 2);
        $aCSVEXT20['si165_codext']                = substr($aEXT20['si165_codext'], 0, 15);
        $aCSVEXT20['si165_codfontrecursos']       = $this->padLeftZero($aEXT20['si165_codfontrecursos'], 3);
        $aCSVEXT20['si165_vlsaldoanteriorfonte']  = $this->sicomNumberReal(abs($aEXT20['si165_vlsaldoanteriorfonte']), 2);

        if($aEXT20['si165_vlsaldoanteriorfonte'] == 0 && !$bFonteEncerrada && !$bCorrecaoFonte){
          //$aCSVEXT20['si165_natsaldoanteriorfonte'] 

          $clconplano->sql_record($clconplano->sql_query(null, null, "*", "", "c61_codtce = ". $aEXT20['si165_codext'] ." " ));

          if($clconplano->numrows > 0) {

            $result = $clconplano->sql_record($clconplano->sql_query(null, null, "case when c60_naturezasaldo = 1 then 'D' when c60_naturezasaldo = 2 then 'C' end as c60_naturezasaldo ", "", "c61_codtce = ".$aEXT20['si165_codext'] ."" ));

            // echo 'c61_codtce';
            // echo $aEXT20['si165_codext'];
            // echo substr(db_utils::fieldsMemory($result, 0)->c60_naturezasaldo, 0, 1);

             $aCSVEXT20['si165_natsaldoanteriorfonte'] = substr(db_utils::fieldsMemory($result, 0)->c60_naturezasaldo, 0, 1);

          }else{

            $result = $clconplano->sql_record($clconplano->sql_query(null, null, "case when c60_naturezasaldo = 1 then 'D' when c60_naturezasaldo = 2 then 'C' end as c60_naturezasaldo ", "", "c61_reduz = ". $aEXT20['si165_codext'] .""));
            // echo 'c61_reduz';
            // echo $aEXT20['si165_codext'];
            // echo substr(db_utils::fieldsMemory($result, 0)->c60_naturezasaldo, 0, 1);

            $aCSVEXT20['si165_natsaldoanteriorfonte'] = substr(db_utils::fieldsMemory($result, 0)->c60_naturezasaldo, 0, 1);

          }
        }else{
          //echo substr($aEXT20['si165_natsaldoanteriorfonte'], 0, 1);
          $aCSVEXT20['si165_natsaldoanteriorfonte'] = substr($aEXT20['si165_natsaldoanteriorfonte'], 0, 1);
        }

        $aCSVEXT20['si165_totaldebitos']          = $this->sicomNumberReal(abs($aEXT20['si165_totaldebitos']), 2);
        $aCSVEXT20['si165_totalcreditos']         = $this->sicomNumberReal(abs($aEXT20['si165_totalcreditos']), 2);
        $aCSVEXT20['si165_vlsaldoatualfonte']     = $this->sicomNumberReal(abs($aEXT20['si165_vlsaldoatualfonte']), 2);


        if($aEXT20['si165_vlsaldoatualfonte'] == 0 && !$bFonteEncerrada && !$bCorrecaoFonte){
          //$aCSVEXT20['si165_natsaldoanteriorfonte']  
          
          $clconplano->sql_record($clconplano->sql_query(null, null, "*", "", "c61_codtce = ". $aEXT20['si165_codext'] ." " ));

          if($clconplano->numrows > 0) {

          $result = $clconplano->sql_record($clconplano->sql_query(null, null, "case when c60_naturezasaldo = 1 then 'D' when c60_naturezasaldo = 2 then 'C' when c60_naturezasaldo = 3 then 'N' end as c60_naturezasaldo ", "", " c61_anousu = 2020 and c61_codtce = ".$aEXT20['si165_codext'].""));  

          // echo 'c61_codtce';
          //   echo $aEXT20['si165_codext'];
          //   echo substr(db_utils::fieldsMemory($result, 0)->c60_naturezasaldo, 0, 1);

            $aCSVEXT20['si165_natsaldoatualfonte'] = substr(db_utils::fieldsMemory($result, 0)->c60_naturezasaldo, 0, 1);

          }else{

            $result = $clconplano->sql_record($clconplano->sql_query(null, null, "case when c60_naturezasaldo = 1 then 'D' when c60_naturezasaldo = 2 then 'C' when c60_naturezasaldo = 3 then 'N' end as c60_naturezasaldo ", "", "c61_reduz = ".$aEXT20['si165_codext'].""));

            // echo 'c61_reduz';
            // echo $aEXT20['si165_codext'];
            // echo substr(db_utils::fieldsMemory($result, 0)->c60_naturezasaldo, 0, 1);

            $aCSVEXT20['si165_natsaldoatualfonte'] = substr(db_utils::fieldsMemory($result, 0)->c60_naturezasaldo, 0, 1);

          }
        }else{

          //echo substr($aEXT20['si165_natsaldoatualfonte'], 0, 1);

          $aCSVEXT20['si165_natsaldoatualfonte']    = substr($aEXT20['si165_natsaldoatualfonte'], 0, 1);
        }

        $this->sLinha = $aCSVEXT20;
        $this->adicionaLinha();
        
      }
  
      /**
       *
       * Registros 30, 31, 32
       */
      for ($iCont3 = 0; $iCont3 < pg_num_rows($rsEXT30); $iCont3++) {
        $aEXT30 = pg_fetch_array($rsEXT30, $iCont3);
  
        $aCSVEXT30['si126_tiporegistro']        = $this->padLeftZero($aEXT30['si126_tiporegistro'], 2);
        $aCSVEXT30['si126_codext']              = substr($aEXT30['si126_codext'], 0, 15);
        $aCSVEXT30['si126_codfontrecursos']     = $this->padLeftZero($aEXT30['si126_codfontrecursos'], 3);
        $aCSVEXT30['si126_codreduzidoop']       = substr($aEXT30['si126_codreduzidoop'], 0, 15);
        $aCSVEXT30['si126_nroop']               = substr($aEXT30['si126_nroop'], 0, 22);
        $aCSVEXT30['si126_codunidadesub']       = $this->padLeftZero($aEXT30['si126_codunidadesub'], (strlen($aEXT30['si126_codunidadesub']) <= 5 ? 5 : 8));
        $aCSVEXT30['si126_dtpagamento']         = $this->sicomDate($aEXT30['si126_dtpagamento']);
        $aCSVEXT30['si126_tipodocumentocredor'] = $this->padLeftZero($aEXT30['si126_tipodocumentocredor'], 1);
        $aCSVEXT30['si126_nrodocumentocredor']  = substr($aEXT30['si126_nrodocumentocredor'], 0, 14);
        $aCSVEXT30['si126_vlop']                = $this->sicomNumberReal(abs($aEXT30['si126_vlop']), 2);
        $aCSVEXT30['si126_especificacaoop']     = substr($aEXT30['si126_especificacaoop'], 0, 200);
        $aCSVEXT30['si126_cpfresppgto']         = substr($aEXT30['si126_cpfresppgto'], 0, 11);

        $this->sLinha = $aCSVEXT30;
        $this->adicionaLinha();
        
        
        for ($iCont4 = 0; $iCont4 < pg_num_rows($rsEXT31); $iCont4++) {
          
          $aEXT31 = pg_fetch_array($rsEXT31, $iCont4);
          
          if ($aEXT30['si126_sequencial'] == $aEXT31['si127_reg30']) {
            
            $aCSVEXT31['si127_tiporegistro']        = $this->padLeftZero($aEXT31['si127_tiporegistro'], 2);
            $aCSVEXT31['si127_codreduzidoop']       = substr($aEXT31['si127_codreduzidoop'], 0, 15);
            $aCSVEXT31['si127_tipodocumentoop']     = $this->padLeftZero($aEXT31['si127_tipodocumentoop'], 2);
            $aCSVEXT31['si127_nrodocumento']        = substr($aEXT31['si127_nrodocumento'], 0, 15);
            $aCSVEXT31['si127_codctb']              = substr(($aEXT31['si127_codctb'] == 0 ? ' ' : $aEXT31['si127_codctb']), 0, 20);
            $aCSVEXT31['si127_codfontectb']         = $aEXT31['si127_codfontectb'] == 0 ? ' ' : $this->padLeftZero($aEXT31['si127_codfontectb'], 3);
            $aCSVEXT31['si127_desctipodocumentoop'] = substr($aEXT31['si127_desctipodocumentoop'], 0, 50);
            $aCSVEXT31['si127_dtemissao']           = $this->sicomDate($aEXT31['si127_dtemissao']);
            $aCSVEXT31['si127_vldocumento']         = $this->sicomNumberReal($aEXT31['si127_vldocumento'], 2);

            $this->sLinha = $aCSVEXT31;
            $this->adicionaLinha();
            
          }
          
        }
        
        for ($iCont5 = 0; $iCont5 < pg_num_rows($rsEXT32); $iCont5++) {
          
          $aEXT32 = pg_fetch_array($rsEXT32, $iCont5);
          
          if ($aEXT31['si128_sequencial'] == $aEXT32['si128_reg30']) {
            
            $aCSVEXT32['si128_tiporegistro']      = $this->padLeftZero($aEXT32['si128_tiporegistro'], 2);
            $aCSVEXT32['si128_codreduzidoop']     = substr($aEXT32['si128_codreduzidoop'], 0, 15);
            $aCSVEXT32['si128_tiporetencao']      = $this->padLeftZero($aEXT32['si128_tiporetencao'], 4);
            $aCSVEXT32['si128_descricaoretencao'] = substr($aEXT32['si128_descricaoretencao'], 0, 50);
            $aCSVEXT32['si128_vlretencao']        = $this->sicomNumberReal($aEXT32['si128_vlretencao'], 2);
            
            $this->sLinha = $aCSVEXT32;
            $this->adicionaLinha();
            
          }
          
        }
        
      }
      
    }
    
    $this->fechaArquivo();
  }
}