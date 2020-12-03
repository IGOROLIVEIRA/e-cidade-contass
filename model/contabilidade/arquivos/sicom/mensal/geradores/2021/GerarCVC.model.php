<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarCVC extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;
  
  public function gerarDados()
  {

    $this->sArquivo = "CVC";
    $this->abreArquivo();
    
    $sSql = "select * from cvc102020 where si146_mes = " . $this->iMes . " and si146_instit=" . db_getsession("DB_instit");
    $rsCVC10 = db_query($sSql);

    $sSql2 = "select * from cvc202020 where si147_mes = " . $this->iMes . " and si147_instit=" . db_getsession("DB_instit");
    $rsCVC20 = db_query($sSql2);
    
    $sSql3 = "select * from cvc302020 where si148_mes = " . $this->iMes . " and si148_instit=" . db_getsession("DB_instit");
    $rsCVC30 = db_query($sSql3);

    $sSql4 = "select * from cvc402020 where si149_mes = " . $this->iMes . " and si149_instit=" . db_getsession("DB_instit");
    $rsCVC40 = db_query($sSql4);


    if (pg_num_rows($rsCVC10) == 0 && pg_num_rows($rsCVC20) == 0 && pg_num_rows($rsCVC30) == 0 && pg_num_rows($rsCVC40) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {

      /**
       * Registros 10
       */
      for ($iCont = 0; $iCont < pg_num_rows($rsCVC10); $iCont++) {

        $aCVC10 = pg_fetch_array($rsCVC10, $iCont);

        $aCSVCVC10['si146_tiporegistro']    = $this->padLeftZero($aCVC10['si146_tiporegistro'], 2);
        $aCSVCVC10['si146_codorgao']        = $this->padLeftZero($aCVC10['si146_codorgao'], 2);
        $aCSVCVC10['si146_codunidadesub']   = $this->padLeftZero($aCVC10['si146_codunidadesub'], 5);
        $aCSVCVC10['si146_codveiculo']      = substr($aCVC10['si146_codveiculo'], 0, 10);
        $aCSVCVC10['si146_tpveiculo']       = $this->padLeftZero($aCVC10['si146_tpveiculo'], 2);
        $aCSVCVC10['si146_subtipoveiculo']  = $this->padLeftZero($aCVC10['si146_subtipoveiculo'], 2);
        $aCSVCVC10['si146_descveiculo']     = substr($aCVC10['si146_descveiculo'], 0, 100);
        $aCSVCVC10['si146_marca']           = substr($aCVC10['si146_marca'], 0, 50);
        $aCSVCVC10['si146_modelo']          = substr($aCVC10['si146_modelo'], 0, 50);
        $aCSVCVC10['si146_ano']             = $this->padLeftZero($aCVC10['si146_ano'], 4);
        $aCSVCVC10['si146_placa']           = substr($aCVC10['si146_placa'], 0, 8);
        $aCSVCVC10['si146_chassi']          = substr($aCVC10['si146_chassi'], 0, 30);
        $aCSVCVC10['si146_numerorenavam']   = substr($aCVC10['si146_numerorenavam'], 0, 14);
        $aCSVCVC10['si146_nroserie']        = substr($aCVC10['si146_nroserie'], 0, 20);
        $aCSVCVC10['si146_situacao']        = $this->padLeftZero($aCVC10['si146_situacao'], 2);
        $aCSVCVC10['si146_tipodocumento']   = $aCVC10['si146_tipodocumento'] == 0 ? ' ' : $this->padLeftZero($aCVC10['si146_tipodocumento'], 1);
        $aCSVCVC10['si146_nrodocumento']    = substr($aCVC10['si146_nrodocumento'], 0, 14);
        $aCSVCVC10['si146_tpdeslocamento']  = $this->padLeftZero($aCVC10['si146_tpdeslocamento'], 2);
        
        $this->sLinha = $aCSVCVC10;
        $this->adicionaLinha();

      }

      /**
       * Registros 20
       */
      for ($iCont2 = 0; $iCont2 < pg_num_rows($rsCVC20); $iCont2++) {

        $aCVC20 = pg_fetch_array($rsCVC20, $iCont2);

        $aCSVCVC20['si147_tiporegistro']          = $this->padLeftZero($aCVC20['si147_tiporegistro'], 2);
        $aCSVCVC20['si147_codorgao']              = $this->padLeftZero($aCVC20['si147_codorgao'], 2);
        $aCSVCVC20['si147_codunidadesub']         = $this->padLeftZero($aCVC20['si147_codunidadesub'], 5);
        $aCSVCVC20['si147_codveiculo']            = substr($aCVC20['si147_codveiculo'], 0, 10);
        $aCSVCVC20['si147_origemgasto']           = $this->padLeftZero($aCVC20['si147_origemgasto'], 1);
        $aCSVCVC20['si147_codunidadesubempenho']  = $aCVC20['si147_codunidadesubempenho'] == '' ? ' ' : $this->padLeftZero($aCVC20['si147_codunidadesubempenho'], 5);
        $aCSVCVC20['si147_nroempenho']            = $aCVC20['si147_nroempenho'] == '' || $aCVC20['si147_nroempenho'] == 0 ? ' ' : substr($aCVC20['si147_nroempenho'], 0, 22);
        $aCSVCVC20['si147_dtempenho']             = $this->sicomDate($aCVC20['si147_dtempenho']);
        $aCSVCVC20['si147_marcacaoinicial']       = substr($aCVC20['si147_marcacaoinicial'], 0, 6);
        $aCSVCVC20['si147_marcacaofinal']         = substr($aCVC20['si147_marcacaofinal'], 0, 6);
        $aCSVCVC20['si147_tipogasto']             = $this->padLeftZero($aCVC20['si147_tipogasto'], 2);
        $aCSVCVC20['si147_qtdeutilizada']         = $this->sicomNumberReal($aCVC20['si147_qtdeutilizada'], 4);
        $aCSVCVC20['si147_vlgasto']               = $this->sicomNumberReal($aCVC20['si147_vlgasto'], 2);
        $aCSVCVC20['si147_dscpecasservicos']      = substr($aCVC20['si147_dscpecasservicos'], 0, 50);
        $aCSVCVC20['si147_atestadocontrole']      = $this->padLeftZero($aCVC20['si147_atestadocontrole'], 1);
        
        $this->sLinha = $aCSVCVC20;
        $this->adicionaLinha();

      }


      /**
       * Registros 30
       */
      for ($iCont3 = 0; $iCont3 < pg_num_rows($rsCVC30); $iCont3++) {

        $aCVC30 = pg_fetch_array($rsCVC30, $iCont3);

        $aCSVCVC30['si148_tiporegistro']              = $this->padLeftZero($aCVC30['si148_tiporegistro'], 2);
        $aCSVCVC30['si148_codorgao']                  = $this->padLeftZero($aCVC30['si148_codorgao'], 2);
        $aCSVCVC30['si148_codunidadesub']             = $this->padLeftZero($aCVC30['si148_codunidadesub'], 5);
        $aCSVCVC30['si148_codveiculo']                = substr($aCVC30['si148_codveiculo'], 0, 10);
        $aCSVCVC30['si148_nomeestabelecimento']       = substr($aCVC30['si148_nomeestabelecimento'], 0, 250);
        $aCSVCVC30['si148_localidade']                = substr($aCVC30['si148_localidade'], 0, 250);
        $aCSVCVC30['si148_qtdediasrodados']           = substr($aCVC30['si148_qtdediasrodados'], 0, 2);
        $aCSVCVC30['si148_distanciaestabelecimento']  = substr($this->sicomNumberReal($aCVC30['si148_distanciaestabelecimento'], 2), 0, 11);
        $aCSVCVC30['si148_numeropassageiros']         = substr($aCVC30['si148_numeropassageiros'], 0, 5);
        $aCSVCVC30['si148_turnos']                    = $this->padLeftZero($aCVC30['si148_turnos'], 2);
        
        $this->sLinha = $aCSVCVC30;
        $this->adicionaLinha();

      }

      /**
       * Registros 40
       */
      for ($iCont4 = 0; $iCont4 < pg_num_rows($rsCVC40); $iCont4++) {

        $aCVC40 = pg_fetch_array($rsCVC40, $iCont4);

        $aCSVCVC40['si149_tiporegistro']  = $this->padLeftZero($aCVC40['si149_tiporegistro'], 2);
        $aCSVCVC40['si149_codorgao']      = $this->padLeftZero($aCVC40['si149_codorgao'], 2);
        $aCSVCVC40['si149_codunidadesub'] = $this->padLeftZero($aCVC40['si149_codunidadesub'], 5);
        $aCSVCVC40['si149_codveiculo']    = substr($aCVC40['si149_codveiculo'], 0, 10);
        $aCSVCVC40['si149_tipobaixa']     = $this->padLeftZero($aCVC40['si149_tipobaixa'], 2);
        $aCSVCVC40['si149_descbaixa']     = substr($aCVC40['si149_descbaixa'], 0, 50);
        $aCSVCVC40['si149_dtbaixa']       = $this->sicomDate($aCVC40['si149_dtbaixa']);
        
        $this->sLinha = $aCSVCVC40;
        $this->adicionaLinha();

      }

      $this->fechaArquivo();

    }

  }
}
