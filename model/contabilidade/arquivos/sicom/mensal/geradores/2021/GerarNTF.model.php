<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarNTF extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;

  public function gerarDados()
  {

    $this->sArquivo = "NTF";
    $this->abreArquivo();

    $sSql = "select * from ntf102021 where si143_mes = " . $this->iMes . " and si143_instit = " . db_getsession("DB_instit");
    $rsNTF10 = db_query($sSql);

    /*$sSql2 = "select * from ntf112021 where si144_mes = ". $this->iMes ." and si144_instit = ". db_getsession("DB_instit");
    $rsNTF11    = db_query($sSql2);*/

    $sSql3 = "select * from ntf202021 where si145_mes = " . $this->iMes . " and si145_instit = " . db_getsession("DB_instit");
    $rsNTF20 = db_query($sSql3);


    if (pg_num_rows($rsNTF10) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {

      /**
       *
       * Registros 10, 11
       */
      for ($iCont = 0; $iCont < pg_num_rows($rsNTF10); $iCont++) {

        $aNTF10 = pg_fetch_array($rsNTF10, $iCont);

        $aCSVNTF10['si143_tiporegistro']          = $this->padLeftZero($aNTF10['si143_tiporegistro'], 2);
        $aCSVNTF10['si143_codnotafiscal']         = substr($aNTF10['si143_codnotafiscal'], 0, 15);
        $aCSVNTF10['si143_codorgao']              = $this->padLeftZero($aNTF10['si143_codorgao'], 2);
        $aCSVNTF10['si143_nfnumero']              = substr($aNTF10['si143_nfnumero'], 0, 20);
        $aCSVNTF10['si143_nfserie']               = $aNTF10['si143_nfserie'] == '' || $aNTF10['si143_nfserie'] == '0' ? ' ' : substr($aNTF10['si143_nfserie'], 0, 8);
        $aCSVNTF10['si143_tipodocumento']         = $this->padLeftZero($aNTF10['si143_tipodocumento'], 1);
        $aCSVNTF10['si143_nrodocumento']          = substr($aNTF10['si143_nrodocumento'], 0, 14);
        $aCSVNTF10['si143_nroinscestadual']       = substr($aNTF10['si143_nroinscestadual'], 0, 30);
        $aCSVNTF10['si143_nroinscmunicipal']      = substr($aNTF10['si143_nroinscmunicipal'], 0, 30);
        $aCSVNTF10['si143_nomemunicipio']         = substr($aNTF10['si143_nomemunicipio'], 0, 120);
        $aCSVNTF10['si143_cepmunicipio']          = $this->padLeftZero($aNTF10['si143_cepmunicipio'], 8);
        $aCSVNTF10['si143_ufcredor']              = $this->padLeftZero($aNTF10['si143_ufcredor'], 2);
        $aCSVNTF10['si143_notafiscaleletronica']  = $this->padLeftZero($aNTF10['si143_notafiscaleletronica'], 1);
        $aCSVNTF10['si143_chaveacesso']           = $aNTF10['si143_chaveacesso'] == 0 ? ' ' : $this->padLeftZero($aNTF10['si143_chaveacesso'], 44);
        $aCSVNTF10['si143_outraChaveAcesso']      = substr($aNTF10['si143_outrachaveacesso'], 0, 60);
        $aCSVNTF10['si143_nfaidf']                = substr($aNTF10['si143_nfaidf'], 0, 15);
        $aCSVNTF10['si143_dtemissaonf']           = $this->sicomDate($aNTF10['si143_dtemissaonf']);
        $aCSVNTF10['si143_dtvencimentonf']        = $this->sicomDate($aNTF10['si143_dtvencimentonf']);
        $aCSVNTF10['si143_nfvalortotal']          = $this->sicomNumberReal($aNTF10['si143_nfvalortotal'], 2);
        $aCSVNTF10['si143_nfvalordesconto']       = $this->sicomNumberReal($aNTF10['si143_nfvalordesconto'], 2);
        $aCSVNTF10['si143_nfvalorliquido']        = $this->sicomNumberReal($aNTF10['si143_nfvalorliquido'], 2);

        $this->sLinha = $aCSVNTF10;
        $this->adicionaLinha();

        /*for ($iCont2 = 0;$iCont2 < pg_num_rows($rsNTF11); $iCont2++) {

          $aNTF11  = pg_fetch_array($rsNTF11,$iCont2);

          if ($aNTF10['si143_sequencial'] == $aNTF11['si144_reg10']) {

            $aCSVNTF11['si144_tiporegistro']      = $this->padLeftZero($aNTF11['si144_tiporegistro'], 2);
            $aCSVNTF11['si144_codnotafiscal']     = substr($aNTF11['si144_codnotafiscal'], 0, 15);
            $aCSVNTF11['si144_coditem']           = substr($aNTF11['si144_coditem'], 0, 15);
            $aCSVNTF11['si144_quantidadeitem']    = $this->sicomNumberReal($aNTF11['si144_quantidadeitem'], 4);
            $aCSVNTF11['si144_valorunitarioitem'] = $this->sicomNumberReal($aNTF11['si144_valorunitarioitem'], 4);

            $this->sLinha = $aCSVNTF11;
            $this->adicionaLinha();

          }

        }*/

        for ($iCont3 = 0; $iCont3 < pg_num_rows($rsNTF20); $iCont3++) {

          $aNTF20 = pg_fetch_array($rsNTF20, $iCont3);

          if ($aNTF10['si143_sequencial'] == $aNTF20['si145_reg10']) {

            $aCSVNTF20['si145_tiporegistro']  = $this->padLeftZero($aNTF20['si145_tiporegistro'], 2);
            $aCSVNTF20['si145_nfnumero']      = substr($aNTF20['si145_nfnumero'], 0, 20);
            $aCSVNTF20['si145_nfserie']       = substr($aNTF20['si145_nfserie'], 0, 8) == '0' ? ' ' : substr($aNTF20['si145_nfserie'], 0, 8);
            $aCSVNTF20['si145_tipodocumento'] = $this->padLeftZero($aNTF20['si145_tipodocumento'], 1);
            $aCSVNTF20['si145_nrodocumento']  = substr($aNTF20['si145_nrodocumento'], 0, 14);
            $aCSVNTF20['si145_chaveacesso']   = $aNTF20['si145_chaveacesso'] == 0 ? ' ' : $this->padLeftZero($aNTF20['si145_chaveacesso'], 44);
            $aCSVNTF20['si145_dtemissaonf']   = $this->sicomDate($aNTF20['si145_dtemissaonf']);
            $aCSVNTF20['si145_codunidadesub'] = $this->padLeftZero($aNTF20['si145_codunidadesub'], 5);
            $aCSVNTF20['si145_dtempenho']     = $this->sicomDate($aNTF20['si145_dtempenho']);
            $aCSVNTF20['si145_nroempenho']    = substr($aNTF20['si145_nroempenho'], 0, 22);
            $aCSVNTF20['si145_dtliquidacao']  = $this->sicomDate($aNTF20['si145_dtliquidacao']);
            $aCSVNTF20['si145_nroliquidacao'] = substr($aNTF20['si145_nroliquidacao'], 0, 22);

            $this->sLinha = $aCSVNTF20;
            $this->adicionaLinha();

          }

        }

      }

      $this->fechaArquivo();

    }

  }

}
