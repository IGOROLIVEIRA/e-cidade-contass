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

		$sSql = "select * from flpgo102013 where si195_mes = ". $this->iMes;
		$rsFLPGO10    = db_query($sSql);

		$sSql2 = "select * from flpgo112013 where si196_mes = ". $this->iMes;
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

				$aCSVFLPGO10['si195_tiporegistro']                        =   str_pad($aFLPGO10['si195_tiporegistro'], 2, "0", STR_PAD_LEFT);
				$aCSVFLPGO10['si195_numcpf']                              =   str_pad($aFLPGO10['si195_numcpf'], 11, "0", STR_PAD_LEFT);
				$aCSVFLPGO10['si195_codreduzidopessoa']                   =   $aFLPGO10['si195_codreduzidopessoa'];
				$aCSVFLPGO10['si195_regime']                              =   str_pad($aFLPGO10['si195_regime'], 1, "0", STR_PAD_LEFT);
				$aCSVFLPGO10['si195_indtipopagamento']                    =   str_pad($aFLPGO10['si195_indtipopagamento'], 1, "0", STR_PAD_LEFT);
				$aCSVFLPGO10['si195_indsituacaoservidorpensionista']      =   str_pad($aFLPGO10['si195_indsituacaoservidorpensionista'], 1, "0", STR_PAD_LEFT);
				$aCSVFLPGO10['si195_datconcessaoaposentadoriapensao']     =   implode("", array_reverse(explode("-", $aFLPGO10['si195_datconcessaoaposentadoriapensao'])));

				if($aFLPGO10['si195_indsituacaoservidorpensionista'] == 'I' || $aFLPGO10['si195_indsituacaoservidorpensionista'] == 'P'){

					$aCSVFLPGO10['si195_dsccargo']                            =   ' ';
					$aCSVFLPGO10['si195_sglcargo']                            =   ' ';
					$aCSVFLPGO10['si195_reqcargo']                            =   ' ';
					$aCSVFLPGO10['si195_indcessao']                           =   ' ';
					$aCSVFLPGO10['si195_dsclotacao']                          =   ' ';
					$aCSVFLPGO10['si195_vlrcargahorariasemanal']              =   ' ';

				}else {

					$aCSVFLPGO10['si195_dsccargo'] = substr($aFLPGO10['si195_dsccargo'], 0, 120);
					$aCSVFLPGO10['si195_sglcargo'] = ' ';//str_pad($aFLPGO10['si195_sglcargo'], 3, "0", STR_PAD_LEFT);
					$aCSVFLPGO10['si195_reqcargo'] = str_pad($aFLPGO10['si195_reqcargo'], 1, "0", STR_PAD_LEFT);
					$aCSVFLPGO10['si195_indcessao'] = str_pad($aFLPGO10['si195_indcessao'], 1, " ", STR_PAD_LEFT);
					$aCSVFLPGO10['si195_dsclotacao'] = substr($aFLPGO10['si195_dsclotacao'], 0, 22);
					$aCSVFLPGO10['si195_vlrcargahorariasemanal'] = str_pad($aFLPGO10['si195_vlrcargahorariasemanal'], 2, "0", STR_PAD_LEFT);

				}
				$aCSVFLPGO10['si195_datefetexercicio']                    =   implode("", array_reverse(explode("-", $aFLPGO10['si195_datefetexercicio'])));
				$aCSVFLPGO10['si195_datexclusao']                         =   implode("", array_reverse(explode("-", $aFLPGO10['si195_datexclusao'])));
				$aCSVFLPGO10['si195_natsaldobruto']                       =   str_pad($aFLPGO10['si195_natsaldobruto'], 1, "0", STR_PAD_LEFT);
				$aCSVFLPGO10['si195_vlrremuneracaobruta']                 =   number_format($aFLPGO10['si195_vlrremuneracaobruta'], 2, ",", "");
				$aCSVFLPGO10['si195_natsaldoliquido']                     =   str_pad($aFLPGO10['si195_natsaldoliquido'], 1, "0", STR_PAD_LEFT);
				$aCSVFLPGO10['si195_vlrremuneracaoliquida']               =   number_format($aFLPGO10['si195_vlrremuneracaoliquida'], 2, ",", "");
				$aCSVFLPGO10['si195_vlrdeducoesobrigatorias']             =   number_format($aFLPGO10['si195_vlrdeducoesobrigatorias'], 2, ",", "");
				$aCSVFLPGO10['si195_vlrabateteto']                        =   number_format($aFLPGO10['si195_vlrabateteto'], 2, ",", "");

				$this->sLinha = $aCSVFLPGO10;
				$this->adicionaLinha();

				for ($iCont2 = 0;$iCont2 < pg_num_rows($rsFLPGO11); $iCont2++) {

					$aFLPGO11  = pg_fetch_array($rsFLPGO11,$iCont2);

					if ($aFLPGO10['si195_sequencial'] == $aFLPGO11['si196_reg10']) {

						$aCSVFLPGO11['si196_tiporegistro']             =    str_pad($aFLPGO11['si196_tiporegistro'], 2, "0", STR_PAD_LEFT);
						$aCSVFLPGO11['si196_numcpf']                   =    str_pad($aFLPGO11['si196_numcpf'], 11, "0", STR_PAD_LEFT);
						$aCSVFLPGO11['si196_codreduzidopessoa']        =    $aFLPGO11['si196_codreduzidopessoa'];
						$aCSVFLPGO11['si196_tiporemuneracao']          =    str_pad($aFLPGO11['si196_tiporemuneracao'], 2, "0", STR_PAD_LEFT);
						$aCSVFLPGO11['si196_descoutros']               =    substr($aFLPGO11['si196_descoutros'], 0, 150);
						$aCSVFLPGO11['si196_natsaldodetalhe']          =    str_pad($aFLPGO11['si196_natsaldodetalhe'], 1, "0", STR_PAD_LEFT);
						$aCSVFLPGO11['si196_vlrremuneracaodetalhada']  =    number_format($aFLPGO11['si196_vlrremuneracaodetalhada'], 2, ",", "");

						$this->sLinha = $aCSVFLPGO11;
						$this->adicionaLinha();

					}

				}

			}

			$this->fechaArquivo();

		}

	}

}
