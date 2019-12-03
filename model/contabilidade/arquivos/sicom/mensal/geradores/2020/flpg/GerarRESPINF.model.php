<?php

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom FLPGO
 * @author marcelo
 * @package Contabilidade
 */

class GerarRESPINF extends GerarAM {

	/**
	 *
	 * Mes de referência
	 * @var Integer
	 */
	public $iMes;

	public function gerarDados() {

		$this->sArquivo = "RESPINF";
		$this->abreArquivo();



		$sSql          = "select * from respinf2020 where si197_mes = ". $this->iMes." and si197_instit = ".db_getsession("DB_instit");
		$rsRESPINF10    = db_query($sSql);
    // db_criatabela($rsRESPINF10);die();

		if (pg_num_rows($rsRESPINF10) == 0) {

			$aCSV['tiporegistro']       =   '99';
			$this->sLinha = $aCSV;
			$this->adicionaLinha();

		} else {

			for ($iCont = 0;$iCont < pg_num_rows($rsRESPINF10); $iCont++) {

				$aRESPINF10  = pg_fetch_array($rsRESPINF10,$iCont, PGSQL_ASSOC);

				unset($aRESPINF10['si197_sequencial']);
				unset($aRESPINF10['si197_mes']);
				unset($aRESPINF10['si197_instit']);

				// $aCSVRESPINF10['si197_nomeresponsavel']          =  substr($aRESPINF10['si197_nomeresponsavel'], 0,120);
				// $aCSVRESPINF10['si197_cartident']                =  substr($aRESPINF10['si197_cartident'], 0,10);
				// $aCSVRESPINF10['si197_orgemissorci']             =  substr($aRESPINF10['si197_orgemissorci'], 0,10);
				$aCSVRESPINF10['si197_nrodocumento']             =  str_pad($aRESPINF10['si197_nrodocumento'], 11, "0", STR_PAD_LEFT);
				$aCSVRESPINF10['si197_dtinicio']                 =  implode("", array_reverse(explode("-", $aRESPINF10['si197_dtinicio'])));
				$aCSVRESPINF10['si197_dtfinal']                  =  implode("", array_reverse(explode("-", $aRESPINF10['si197_dtfinal'])));

				$this->sLinha = $aCSVRESPINF10;

				$this->adicionaLinha();

			}

		}
		$this->fechaArquivo();
	}

}
