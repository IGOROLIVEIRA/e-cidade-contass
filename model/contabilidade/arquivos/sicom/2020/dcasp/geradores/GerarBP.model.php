<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom DCASP - BP
 * @author gabriel
 * @package Contabilidade
 */
class GerarBP extends GerarAM
{
  public $iAno;
  public $iPeriodo;

  public function gerarDados()
  {

    $this->sArquivo = "BP";
    $this->abreArquivo();

    $sSql = "select * from bpdcasp102020 where si208_ano = {$this->iAno} AND si208_periodo = {$this->iPeriodo} AND si208_institu = " . db_getsession("DB_instit");
    $rsBP10 = db_query($sSql);

    $sSql = "select * from bpdcasp202020 where si209_ano = {$this->iAno} AND si209_periodo = {$this->iPeriodo} AND si209_institu = " . db_getsession("DB_instit");
    $rsBP20 = db_query($sSql);

    $sSql = "select * from bpdcasp302020 where si210_ano = {$this->iAno} AND si210_periodo = {$this->iPeriodo} AND si210_institu = " . db_getsession("DB_instit");
    $rsBP30 = db_query($sSql);

    $sSql = "select * from bpdcasp402020 where si211_ano = {$this->iAno} AND si211_periodo = {$this->iPeriodo} AND si211_institu = " . db_getsession("DB_instit");
    $rsBP40 = db_query($sSql);

    $sSql = "select * from bpdcasp502020 where si212_ano = {$this->iAno} AND si212_periodo = {$this->iPeriodo} AND si212_institu = " . db_getsession("DB_instit");
    $rsBP50 = db_query($sSql);

    $sSql = "select * from bpdcasp602020 where si213_ano = {$this->iAno} AND si213_periodo = {$this->iPeriodo} AND si213_institu = " . db_getsession("DB_instit");
    $rsBP60 = db_query($sSql);

    $sSql = "select * from bpdcasp702020 where si214_ano = {$this->iAno} AND si214_periodo = {$this->iPeriodo} AND si214_institu = " . db_getsession("DB_instit");
    $rsBP70 = db_query($sSql);

    $sSql = "select * from bpdcasp712020 where si215_ano = {$this->iAno} AND si215_periodo = {$this->iPeriodo} AND si215_institu = " . db_getsession("DB_instit");
    $rsBP71 = db_query($sSql);


    if (pg_num_rows($rsBP10) == 0
      && pg_num_rows($rsBP20) == 0
      && pg_num_rows($rsBP30) == 0
      && pg_num_rows($rsBP40) == 0
      && pg_num_rows($rsBP50) == 0
      && pg_num_rows($rsBP60) == 0
      && pg_num_rows($rsBP70) == 0
      && pg_num_rows($rsBP71) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {


      /** Registro 10 */
      for ($iCont = 0; $iCont < pg_num_rows($rsBP10); $iCont++) {

        $aBP10 = pg_fetch_array($rsBP10, $iCont, PGSQL_ASSOC);

        $aCSVBP10 = array();
        $aCSVBP10['si208_tiporegistro']                       = $this->padLeftZero($aBP10['si208_tiporegistro'], 2);
        $aCSVBP10['si208_vlativocircucaixaequicaixa']         = $this->sicomNumberReal($aBP10['si208_vlativocircucaixaequicaixa'], 2);
        $aCSVBP10['si208_vlativocircucredicurtoprazo']        = $this->sicomNumberReal($aBP10['si208_vlativocircucredicurtoprazo'], 2);
        $aCSVBP10['si208_vlativocircuinvestapliccurtoprazo']  = $this->sicomNumberReal($aBP10['si208_vlativocircuinvestapliccurtoprazo'], 2);
        $aCSVBP10['si208_vlativocircuestoques']               = $this->sicomNumberReal($aBP10['si208_vlativocircuestoques'], 2);
        $aCSVBP10['si208_vlativonaocircumantidovenda']        = $this->sicomNumberReal($aBP10['si208_vlativonaocircumantidovenda'], 2);
        $aCSVBP10['si208_vlativocircuvpdantecipada']          = $this->sicomNumberReal($aBP10['si208_vlativocircuvpdantecipada'], 2);
        $aCSVBP10['si208_vlativonaocircurlp']                 = $this->sicomNumberReal($aBP10['si208_vlativonaocircurlp'], 2);
        $aCSVBP10['si208_vlativonaocircuinvestimentos']       = $this->sicomNumberReal($aBP10['si208_vlativonaocircuinvestimentos'], 2);
        $aCSVBP10['si208_vlativonaocircuimobilizado']         = $this->sicomNumberReal($aBP10['si208_vlativonaocircuimobilizado'], 2);
        $aCSVBP10['si208_vlativonaocircuintagivel']           = $this->sicomNumberReal($aBP10['si208_vlativonaocircuintagivel'], 2);
        $aCSVBP10['si208_vltotalativo']                       = $this->sicomNumberReal($aBP10['si208_vltotalativo'], 2);

        $this->sLinha = $aCSVBP10;
        $this->adicionaLinha();

      }


      /** Registro 20 */
      for ($iCont = 0; $iCont < pg_num_rows($rsBP20); $iCont++) {

        $aBP20 = pg_fetch_array($rsBP20, $iCont, PGSQL_ASSOC);

        $aCSVBP20 = array();
        $aCSVBP20['si209_tiporegistro']                       = $this->padLeftZero($aBP20['si209_tiporegistro'], 2);
        $aCSVBP20['si209_vlpassivcircultrabprevicurtoprazo']  = $this->sicomNumberReal($aBP20['si209_vlpassivcircultrabprevicurtoprazo'], 2);
        $aCSVBP20['si209_vlpassivcirculemprefinancurtoprazo'] = $this->sicomNumberReal($aBP20['si209_vlpassivcirculemprefinancurtoprazo'], 2);
        $aCSVBP20['si209_vlpassivocirculafornecedcurtoprazo'] = $this->sicomNumberReal($aBP20['si209_vlpassivocirculafornecedcurtoprazo'], 2);
        $aCSVBP20['si209_vlpassicircuobrigfiscacurtoprazo']   = $this->sicomNumberReal($aBP20['si209_vlpassicircuobrigfiscacurtoprazo'], 2);
        $aCSVBP20['si209_vlpassivocirculaobrigacoutrosentes'] = $this->sicomNumberReal($aBP20['si209_vlpassivocirculaobrigacoutrosentes'], 2);
        $aCSVBP20['si209_vlpassivocirculaprovisoecurtoprazo'] = $this->sicomNumberReal($aBP20['si209_vlpassivocirculaprovisoecurtoprazo'], 2);
        $aCSVBP20['si209_vlpassicircudemaiobrigcurtoprazo']   = $this->sicomNumberReal($aBP20['si209_vlpassicircudemaiobrigcurtoprazo'], 2);
        $aCSVBP20['si209_vlpassinaocircutrabprevilongoprazo'] = $this->sicomNumberReal($aBP20['si209_vlpassinaocircutrabprevilongoprazo'], 2);
        $aCSVBP20['si209_vlpassnaocircemprfinalongpraz']      = $this->sicomNumberReal($aBP20['si209_vlpassnaocircemprfinalongpraz'], 2);
        $aCSVBP20['si209_vlpassivnaocirculforneclongoprazo']  = $this->sicomNumberReal($aBP20['si209_vlpassivnaocirculforneclongoprazo'], 2);
        $aCSVBP20['si209_vlpassnaocircobrifisclongpraz']      = $this->sicomNumberReal($aBP20['si209_vlpassnaocircobrifisclongpraz'], 2);
        $aCSVBP20['si209_vlpassivnaocirculprovislongoprazo']  = $this->sicomNumberReal($aBP20['si209_vlpassivnaocirculprovislongoprazo'], 2);
        $aCSVBP20['si209_vlpassnaocircdemaobrilongpraz']      = $this->sicomNumberReal($aBP20['si209_vlpassnaocircdemaobrilongpraz'], 2);
        $aCSVBP20['si209_vlpassivonaocircularesuldiferido']   = $this->sicomNumberReal($aBP20['si209_vlpassivonaocircularesuldiferido'], 2);
        $aCSVBP20['si209_vlpatriliquidocapitalsocial']        = $this->sicomNumberReal($aBP20['si209_vlpatriliquidocapitalsocial'], 2);
        $aCSVBP20['si209_vlpatriliquidoadianfuturocapital']   = $this->sicomNumberReal($aBP20['si209_vlpatriliquidoadianfuturocapital'], 2);
        $aCSVBP20['si209_vlpatriliquidoreservacapital']       = $this->sicomNumberReal($aBP20['si209_vlpatriliquidoreservacapital'], 2);
        $aCSVBP20['si209_vlpatriliquidoajustavaliacao']       = $this->sicomNumberReal($aBP20['si209_vlpatriliquidoajustavaliacao'], 2);
        $aCSVBP20['si209_vlpatriliquidoreservalucros']        = $this->sicomNumberReal($aBP20['si209_vlpatriliquidoreservalucros'], 2);
        $aCSVBP20['si209_vlpatriliquidodemaisreservas']       = $this->sicomNumberReal($aBP20['si209_vlpatriliquidodemaisreservas'], 2);
        $aCSVBP20['si209_vlpatriliquidoresultexercicio']      = $this->sicomNumberReal($aBP20['si209_vlpatriliquidoresultexercicio'], 2);
        $aCSVBP20['si209_vlpatriliquidresultacumexeranteri']  = $this->sicomNumberReal($aBP20['si209_vlpatriliquidresultacumexeranteri'], 2);
        $aCSVBP20['si209_vlpatriliquidoacoescotas']           = $this->sicomNumberReal($aBP20['si209_vlpatriliquidoacoescotas'], 2);
        $aCSVBP20['si209_vltotalpassivo']                     = $this->sicomNumberReal($aBP20['si209_vltotalpassivo'], 2);

        $this->sLinha = $aCSVBP20;
        $this->adicionaLinha();

      }


      /** Registro 30 */
      for ($iCont = 0; $iCont < pg_num_rows($rsBP30); $iCont++) {

        $aBP30 = pg_fetch_array($rsBP30, $iCont, PGSQL_ASSOC);

        $aCSVBP30 = array();
        $aCSVBP30['si210_tiporegistro']                     = $this->padLeftZero($aBP30['si210_tiporegistro'], 2);
        $aCSVBP30['si210_vlativofinanceiro']                = $this->sicomNumberReal($aBP30['si210_vlativofinanceiro'], 2);
        $aCSVBP30['si210_vlativopermanente']                = $this->sicomNumberReal($aBP30['si210_vlativopermanente'], 2);
        $aCSVBP30['si210_vltotalativofinanceiropermanente'] = $this->sicomNumberReal($aBP30['si210_vltotalativofinanceiropermanente'], 2);

        $this->sLinha = $aCSVBP30;
        $this->adicionaLinha();

      }


      /** Registro 40 */
      for ($iCont = 0; $iCont < pg_num_rows($rsBP40); $iCont++) {

        $aBP40 = pg_fetch_array($rsBP40, $iCont, PGSQL_ASSOC);

        $aCSVBP40 = array();
        $aCSVBP40['si211_tiporegistro']                       = $this->padLeftZero($aBP40['si211_tiporegistro'], 2);
        $aCSVBP40['si211_vlpassivofinanceiro']                = $this->sicomNumberReal($aBP40['si211_vlpassivofinanceiro'], 2);
        $aCSVBP40['si211_vlpassivopermanente']                = $this->sicomNumberReal($aBP40['si211_vlpassivopermanente'], 2);
        $aCSVBP40['si211_vltotalpassivofinanceiropermanente'] = $this->sicomNumberReal($aBP40['si211_vltotalpassivofinanceiropermanente'], 2);

        $this->sLinha = $aCSVBP40;
        $this->adicionaLinha();

      }


      /** Registro 50 */
      for ($iCont = 0; $iCont < pg_num_rows($rsBP50); $iCont++) {

        $aBP50 = pg_fetch_array($rsBP50, $iCont, PGSQL_ASSOC);

        $aCSVBP50 = array();
        $aCSVBP50['si212_tiporegistro']       = $this->padLeftZero($aBP50['si212_tiporegistro'], 2);
        $aCSVBP50['si212_vlsaldopatrimonial'] = $this->sicomNumberReal($aBP50['si212_vlsaldopatrimonial'], 2);

        $this->sLinha = $aCSVBP50;
        $this->adicionaLinha();

      }


      /** Registro 60 */
      for ($iCont = 0; $iCont < pg_num_rows($rsBP60); $iCont++) {

        $aBP60 = pg_fetch_array($rsBP60, $iCont, PGSQL_ASSOC);

        $aCSVBP60 = array();
        $aCSVBP60['si213_tiporegistro']                       = $this->padLeftZero($aBP60['si213_tiporegistro'], 2);
        $aCSVBP60['si213_vlatospotenativosgarancontrarecebi'] = $this->sicomNumberReal($aBP60['si213_vlatospotenativosgarancontrarecebi'], 2);
        $aCSVBP60['si213_vlatospotenativodirconveoutroinstr'] = $this->sicomNumberReal($aBP60['si213_vlatospotenativodirconveoutroinstr'], 2);
        $aCSVBP60['si213_vlatospotenativosdireitoscontratua'] = $this->sicomNumberReal($aBP60['si213_vlatospotenativosdireitoscontratua'], 2);
        $aCSVBP60['si213_vlatospotenativosoutrosatos']        = $this->sicomNumberReal($aBP60['si213_vlatospotenativosoutrosatos'], 2);
        $aCSVBP60['si213_vlatospotenpassivgarancontraconced'] = $this->sicomNumberReal($aBP60['si213_vlatospotenpassivgarancontraconced'], 2);
        $aCSVBP60['si213_vlatospotepassobriconvoutrinst']     = $this->sicomNumberReal($aBP60['si213_vlatospotepassobriconvoutrinst'], 2);
        $aCSVBP60['si213_vlatospotenpassivoobrigacocontratu'] = $this->sicomNumberReal($aBP60['si213_vlatospotenpassivoobrigacocontratu'], 2);
        $aCSVBP60['si213_vlatospotenpassivooutrosatos']       = $this->sicomNumberReal($aBP60['si213_vlatospotenpassivooutrosatos'], 2);

        $this->sLinha = $aCSVBP60;
        $this->adicionaLinha();

      }


      /** Registro 70 */
      for ($iCont = 0; $iCont < pg_num_rows($rsBP70); $iCont++) {

        $aBP70 = pg_fetch_array($rsBP70, $iCont, PGSQL_ASSOC);

        $aCSVBP70 = array();
        $aCSVBP70['si214_tiporegistro']   = $this->padLeftZero($aBP70['si214_tiporegistro'], 2);
        $aCSVBP70['si214_vltotalsupdef']  = $this->sicomNumberReal($aBP70['si214_vltotalsupdef'], 2);

        $this->sLinha = $aCSVBP70;
        $this->adicionaLinha();

      }


      /** Registro 71 */
      for ($iCont = 0; $iCont < pg_num_rows($rsBP71); $iCont++) {

        $aBP71 = pg_fetch_array($rsBP71, $iCont, PGSQL_ASSOC);

        $aCSVBP71 = array();
        $aCSVBP71['si215_tiporegistro']     = $this->padLeftZero($aBP71['si215_tiporegistro'], 2);
        $aCSVBP71['si215_codfontrecursos']  = $this->padLeftZero($aBP71['si215_codfontrecursos'], 3);
        $aCSVBP71['si215_vlsaldofonte']     = $this->isZeroNegativo($aBP71['si215_vlsaldofonte']) ? '0,00' : $this->sicomNumberReal($aBP71['si215_vlsaldofonte'], 2);

        $this->sLinha = $aCSVBP71;
        $this->adicionaLinha();

      }

      $this->fechaArquivo();

    }

  }

}
