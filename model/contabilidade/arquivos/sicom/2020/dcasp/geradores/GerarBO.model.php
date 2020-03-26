<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom DCASP - BO
 * @author gabriel
 * @package Contabilidade
 */
class GerarBO extends GerarAM
{

  public $iAno;
  public $iPeriodo;

  public function gerarDados()
  {

    $this->sArquivo = "BO";
    $this->abreArquivo();

    $sSql = "select * from bodcasp102019 where si201_ano = {$this->iAno} AND si201_periodo = {$this->iPeriodo} AND si201_institu = " . db_getsession("DB_instit");
    $rsBO10 = db_query($sSql);

    $sSql = "select * from bodcasp202019 where si202_anousu = {$this->iAno} AND si202_periodo = {$this->iPeriodo} AND si202_instit = " . db_getsession("DB_instit");
    $rsBO20 = db_query($sSql);

    $sSql = "select * from bodcasp302019 where si203_anousu = {$this->iAno} AND si203_periodo = {$this->iPeriodo} AND si203_instit = " . db_getsession("DB_instit");
    $rsBO30 = db_query($sSql);

    $sSql = "select * from bodcasp402019 where si204_ano = {$this->iAno} AND si204_periodo = {$this->iPeriodo} AND si204_institu = " . db_getsession("DB_instit");
    $rsBO40 = db_query($sSql);

    $sSql = "select * from bodcasp502019 where si205_ano = {$this->iAno} AND si205_periodo = {$this->iPeriodo} AND si205_institu = " . db_getsession("DB_instit");
    $rsBO50 = db_query($sSql);

    if (pg_num_rows($rsBO10) == 0
      && pg_num_rows($rsBO20) == 0
      && pg_num_rows($rsBO30) == 0
      && pg_num_rows($rsBO40) == 0
      && pg_num_rows($rsBO50) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {


      /** Registro 10 */
      for ($iCont = 0; $iCont < pg_num_rows($rsBO10); $iCont++) {

        $aBO10 = pg_fetch_array($rsBO10, $iCont, PGSQL_ASSOC);

        $aCSVBO10 = array();
        $aCSVBO10['si201_tiporegistro']          = $this->padLeftZero($aBO10['si201_tiporegistro'], 2);
        $aCSVBO10['si201_faserecorcamentaria']   = $this->padLeftZero($aBO10['si201_faserecorcamentaria'], 1);
        $aCSVBO10['si201_vlrectributaria']       = $this->sicomNumberReal($aBO10['si201_vlrectributaria'], 2);
        $aCSVBO10['si201_vlreccontribuicoes']    = $this->sicomNumberReal($aBO10['si201_vlreccontribuicoes'], 2);
        $aCSVBO10['si201_vlrecpatrimonial']      = $this->sicomNumberReal($aBO10['si201_vlrecpatrimonial'], 2);
        $aCSVBO10['si201_vlrecagropecuaria']     = $this->sicomNumberReal($aBO10['si201_vlrecagropecuaria'], 2);
        $aCSVBO10['si201_vlrecindustrial']       = $this->sicomNumberReal($aBO10['si201_vlrecindustrial'], 2);
        $aCSVBO10['si201_vlrecservicos']         = $this->sicomNumberReal($aBO10['si201_vlrecservicos'], 2);
        $aCSVBO10['si201_vltransfcorrentes']     = $this->sicomNumberReal($aBO10['si201_vltransfcorrentes'], 2);
        $aCSVBO10['si201_vloutrasreccorrentes']  = $this->sicomNumberReal($aBO10['si201_vloutrasreccorrentes'], 2);
        $aCSVBO10['si201_vloperacoescredito']    = $this->sicomNumberReal($aBO10['si201_vloperacoescredito'], 2);
        $aCSVBO10['si201_vlalienacaobens']       = $this->sicomNumberReal($aBO10['si201_vlalienacaobens'], 2);
        $aCSVBO10['si201_vlamortemprestimo']     = $this->sicomNumberReal($aBO10['si201_vlamortemprestimo'], 2);
        $aCSVBO10['si201_vltransfcapital']       = $this->sicomNumberReal($aBO10['si201_vltransfcapital'], 2);
        $aCSVBO10['si201_vloutrasreccapital']    = $this->sicomNumberReal($aBO10['si201_vloutrasreccapital'], 2);
        $aCSVBO10['si201_vlrecarrecadaxeant']    = $this->sicomNumberReal($aBO10['si201_vlrecarrecadaxeant'], 2);
        $aCSVBO10['si201_vlopcredrefintermob']   = $this->sicomNumberReal($aBO10['si201_vlopcredrefintermob'], 2);
        $aCSVBO10['si201_vlopcredrefintcontrat'] = $this->sicomNumberReal($aBO10['si201_vlopcredrefintcontrat'], 2);
        $aCSVBO10['si201_vlopcredrefextmob']     = $this->sicomNumberReal($aBO10['si201_vlopcredrefextmob'], 2);
        $aCSVBO10['si201_vlopcredrefextcontrat'] = $this->sicomNumberReal($aBO10['si201_vlopcredrefextcontrat'], 2);
        $aCSVBO10['si201_vldeficit']             = $this->sicomNumberReal($aBO10['si201_vldeficit'], 2);
        $aCSVBO10['si201_vltotalquadroreceita']  = $this->sicomNumberReal($aBO10['si201_vltotalquadroreceita'], 2);

        $this->sLinha = $aCSVBO10;
        $this->adicionaLinha();

      }


      /** Registro 20 */
      for ($iCont = 0; $iCont < pg_num_rows($rsBO20); $iCont++) {

        $aBO20 = pg_fetch_array($rsBO20, $iCont, PGSQL_ASSOC);

        $aCSVBO20 = array();
        $aCSVBO20['si202_tiporegistro']           = $this->padLeftZero($aBO20['si202_tiporegistro'], 2);
        $aCSVBO20['si202_faserecorcamentaria']    = $this->padLeftZero($aBO20['si202_faserecorcamentaria'], 1);
        $aCSVBO20['si202_vlsaldoexeantsupfin']    = $this->sicomNumberReal($aBO20['si202_vlsaldoexeantsupfin'], 2);
        $aCSVBO20['si202_vlsaldoexeantrecredad']  = $this->sicomNumberReal($aBO20['si202_vlsaldoexeantrecredad'], 2);
        $aCSVBO20['si202_vltotalsaldoexeant']     = $this->sicomNumberReal($aBO20['si202_vltotalsaldoexeant'], 2);

        $this->sLinha = $aCSVBO20;
        $this->adicionaLinha();

      }


      /** Registro 30 */
      for ($iCont = 0; $iCont < pg_num_rows($rsBO30); $iCont++) {

        $aBO30 = pg_fetch_array($rsBO30, $iCont, PGSQL_ASSOC);

        $aCSVBO30 = array();
        $aCSVBO30['si203_tiporegistro']             = $this->padLeftZero($aBO30['si203_tiporegistro'], 2);
        $aCSVBO30['si203_fasedespesaorca']          = $this->padLeftZero($aBO30['si203_fasedespesaorca'], 1);
        $aCSVBO30['si203_vlpessoalencarsoci']       = $this->sicomNumberReal($aBO30['si203_vlpessoalencarsoci'], 2);
        $aCSVBO30['si203_vljurosencardividas']      = $this->sicomNumberReal($aBO30['si203_vljurosencardividas'], 2);
        $aCSVBO30['si203_vloutrasdespcorren']       = $this->sicomNumberReal($aBO30['si203_vloutrasdespcorren'], 2);
        $aCSVBO30['si203_vlinvestimentos']          = $this->sicomNumberReal($aBO30['si203_vlinvestimentos'], 2);
        $aCSVBO30['si203_vlinverfinanceira']        = $this->sicomNumberReal($aBO30['si203_vlinverfinanceira'], 2);
        $aCSVBO30['si203_vlamortizadivida']         = $this->sicomNumberReal($aBO30['si203_vlamortizadivida'], 2);
        $aCSVBO30['si203_vlreservacontingen']       = $this->sicomNumberReal($aBO30['si203_vlreservacontingen'], 2);
        $aCSVBO30['si203_vlreservarpps']            = $this->sicomNumberReal($aBO30['si203_vlreservarpps'], 2);
        $aCSVBO30['si203_vlamortizadiviintermob']   = $this->sicomNumberReal($aBO30['si203_vlamortizadiviintermob'], 2);
        $aCSVBO30['si203_vlamortizaoutrasdivinter'] = $this->sicomNumberReal($aBO30['si203_vlamortizaoutrasdivinter'], 2);
        $aCSVBO30['si203_vlamortizadivextmob']      = $this->sicomNumberReal($aBO30['si203_vlamortizadivextmob'], 2);
        $aCSVBO30['si203_vlamortizaoutrasdivext']   = $this->sicomNumberReal($aBO30['si203_vlamortizaoutrasdivext'], 2);
        $aCSVBO30['si203_vlsuperavit']              = $this->sicomNumberReal($aBO30['si203_vlsuperavit'], 2);
        $aCSVBO30['si203_vltotalquadrodespesa']     = $this->sicomNumberReal($aBO30['si203_vltotalquadrodespesa'], 2);

        $this->sLinha = $aCSVBO30;
        $this->adicionaLinha();

      }


      /** Registro 40 */
      for ($iCont = 0; $iCont < pg_num_rows($rsBO40); $iCont++) {

        $aBO40 = pg_fetch_array($rsBO40, $iCont, PGSQL_ASSOC);

        $aCSVBO40 = array();
        $aCSVBO40['si204_tiporegistro']                     = $this->padLeftZero($aBO40['si204_tiporegistro'], 2);
        $aCSVBO40['si204_faserestospagarnaoproc']           = $this->padLeftZero($aBO40['si204_faserestospagarnaoproc'], 1);
        $aCSVBO40['si204_vlrspnaoprocpessoalencarsociais']  = ($this->sicomNumberReal($aBO40['si204_vlrspnaoprocpessoalencarsociais'], 2) == '0,00')? abs($this->sicomNumberReal($aBO40['si204_vlrspnaoprocpessoalencarsociais'], 2)) : $this->sicomNumberReal($aBO40['si204_vlrspnaoprocpessoalencarsociais'], 2);
        $aCSVBO40['si204_vlrspnaoprocjurosencardividas']    = $this->sicomNumberReal($aBO40['si204_vlrspnaoprocjurosencardividas'], 2);
        $aCSVBO40['si204_vlrspnaoprocoutrasdespcorrentes']  = $this->sicomNumberReal($aBO40['si204_vlrspnaoprocoutrasdespcorrentes'], 2);
        $aCSVBO40['si204_vlrspnaoprocinvestimentos']        = $this->sicomNumberReal($aBO40['si204_vlrspnaoprocinvestimentos'], 2);
        $aCSVBO40['si204_vlrspnaoprocinverfinanceira']      = $this->sicomNumberReal($aBO40['si204_vlrspnaoprocinverfinanceira'], 2);
        $aCSVBO40['si204_vlrspnaoprocamortizadivida']       = $this->sicomNumberReal($aBO40['si204_vlrspnaoprocamortizadivida'], 2);
        $aCSVBO40['si204_vltotalexecurspnaoprocessado']     = $this->sicomNumberReal($aBO40['si204_vltotalexecurspnaoprocessado'], 2);

        $this->sLinha = $aCSVBO40;
        $this->adicionaLinha();

      }


      /** Registro 50 */
      for ($iCont = 0; $iCont < pg_num_rows($rsBO50); $iCont++) {

        $aBO50 = pg_fetch_array($rsBO50, $iCont, PGSQL_ASSOC);

        $aCSVBO50 = array();
        $aCSVBO50['si205_tiporegistro']                     = $this->padLeftZero($aBO50['si205_tiporegistro'], 2);
        $aCSVBO50['si205_faserestospagarprocnaoliqui']      = $this->padLeftZero($aBO50['si205_faserestospagarprocnaoliqui'], 1);
        $aCSVBO50['si205_vlrspprocliqpessoalencarsoc']      = $this->sicomNumberReal($aBO50['si205_vlrspprocliqpessoalencarsoc'], 2);
        $aCSVBO50['si205_vlrspprocliqjurosencardiv']        = $this->sicomNumberReal($aBO50['si205_vlrspprocliqjurosencardiv'], 2);
        $aCSVBO50['si205_vlrspprocliqoutrasdespcorrentes']  = $this->sicomNumberReal($aBO50['si205_vlrspprocliqoutrasdespcorrentes'], 2);
        $aCSVBO50['si205_vlrspprocesliqinv']                = $this->sicomNumberReal($aBO50['si205_vlrspprocesliqinv'], 2);
        $aCSVBO50['si205_vlrspprocliqinverfinan']           = $this->sicomNumberReal($aBO50['si205_vlrspprocliqinverfinan'], 2);
        $aCSVBO50['si205_vlrspprocliqamortizadivida']       = $this->sicomNumberReal($aBO50['si205_vlrspprocliqamortizadivida'], 2);
        $aCSVBO50['si205_vltotalexecrspprocnaoproceli']     = $this->sicomNumberReal($aBO50['si205_vltotalexecrspprocnaoproceli'], 2);

        $this->sLinha = $aCSVBO50;
        $this->adicionaLinha();

      }

      $this->fechaArquivo();

    }

  }

}
