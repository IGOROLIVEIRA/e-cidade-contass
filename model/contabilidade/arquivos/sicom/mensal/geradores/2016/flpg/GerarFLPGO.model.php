<?php

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */

class GerarFLPGO extends GerarAM {

	/**
	 *
	 * Mes de referência
	 * @var Integer
	 */
	public $iMes;

	public function gerarDados() {

		$this->sArquivo = "FLPGO";
		$this->abreArquivo();

		$sSql = "select * from flpgo102016 where si195_mes = ". $this->iMes;
		$rsFLPGO10    = db_query($sSql);

		$sSql2 = "select * from flpgo112016 where si196_mes = ". $this->iMes;
		$rsFLPGO11    = db_query($sSql2);


		if (pg_num_rows($rsFLPGO10) == 0) {

			$aCSV['tiporegistro']       =   '99';
			$this->sLinha = $aCSV;
			$this->adicionaLinha();

		} else {

			/**
			 *
			 * Registros 10, 11
			 */
			for ($iCont = 0;$iCont < pg_num_rows($rsFLPGO10); $iCont++) {

				$aFLPGO10  = pg_fetch_array($rsFLPGO10,$iCont);

				$aFLPGO10['si195_tiporegistro']               =   str_pad($aFLPGO10['si195_tiporegistro'], 2, "0", STR_PAD_LEFT);
				$aFLPGO10['si195_codreduzido']                =   substr($aFLPGO10['si195_nroop'], 0, 15);
				$aFLPGO10['si195_codorgao']                   =   str_pad($aFLPGO10['si195_codunidadesubresp'], 2, "0", STR_PAD_LEFT);
				$aFLPGO10['si195_codunidadesub']              =   str_pad($aFLPGO10['si195_codunidadesub'], 8, "0", STR_PAD_LEFT);
				$aFLPGO10['si195_nroLancamento']              =   substr($aFLPGO10['si195_nroLancamento'], 0, 22);
				$aFLPGO10['si195_dtlancamento']               =   implode("", array_reverse(explode("-", $aFLPGO10['si195_dtlancamento'])));
				$aFLPGO10['si195_nroanulacaolancamento']      =   substr($aFLPGO10['si195_nroanulacaolancamento'], 0, 22);
				$aFLPGO10['si195_dtanulacaolancamento']       =   implode("", array_reverse(explode("-", $aFLPGO10['si195_dtanulacaolancamento'])));
				$aFLPGO10['si195_nroempenho']                 =   substr($aFLPGO10['si195_nroempenho'], 0, 22);
				$aFLPGO10['si195_dtempenho']                  =   implode("", array_reverse(explode("-", $aFLPGO10['si195_dtempenho'])));
				$aFLPGO10['si195_nroliquidacao']              =   substr($aFLPGO10['si195_nroliquidacao'], 0, 22);
				$aFLPGO10['si195_dtliquidacao']               =   implode("", array_reverse(explode("-", $aFLPGO10['si195_dtliquidacao'])));
				$aFLPGO10['si195_valoranulacaolancamento']    =   number_format($aFLPGO10['si195_valoranulacaolancamento'], 2, ",", "");

				$this->sLinha = $aFLPGO10;
				$this->adicionaLinha();

				for ($iCont2 = 0;$iCont2 < pg_num_rows($rsFLPGO11); $iCont2++) {

					$aFLPGO11  = pg_fetch_array($rsFLPGO11,$iCont2);

					if ($aFLPGO10['si195_sequencial'] == $aFLPGO11['si196_reg10']) {

						$aFLPGO11['si196_tiporegistro']             =    str_pad($aFLPGO11['si196_tiporegistro'], 2, "0", STR_PAD_LEFT);
						$aFLPGO11['si196_codreduzido']              =    substr($aFLPGO11['si196_codreduzido'], 0, 15);
						$aFLPGO11['si196_codfontrecursos']          =    str_pad($aFLPGO11['si196_codfontrecursos'], 3, "0", STR_PAD_LEFT);
						$aFLPGO11['si196_valoranulacaofonte']       =    number_format($aFLPGO11['si196_valoranulacaofonte'], 2, ",", "");

						$this->sLinha = $aFLPGO11;
						$this->adicionaLinha();

					}

				}

			}

			$this->fechaArquivo();

		}

	}

}
