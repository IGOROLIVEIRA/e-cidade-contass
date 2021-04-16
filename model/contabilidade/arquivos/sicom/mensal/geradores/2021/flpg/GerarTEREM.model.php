<?php

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */

class GerarTEREM extends GerarAM {

	/**
	 *
	 * Mes de referência
	 * @var Integer
	 */
	public $iMes;

	public function gerarDados() {

		$this->sArquivo = "TEREM";
		$this->abreArquivo();

		$sSql         = "select * from terem102021 where si194_mes = ". $this->iMes." and si194_inst = ".db_getsession("DB_instit");
		$rsTEREM10    = db_query($sSql);

        $sSql2        = "select * from terem202021 where si196_mes = ". $this->iMes." and si196_inst = ".db_getsession("DB_instit");
        $rsTEREM20    = db_query($sSql2);



		if ((pg_num_rows($rsTEREM10) == 0) && (pg_num_rows($rsTEREM20) == 0)) {
			$aCSV['tiporegistro']       =   '99';
			$this->sLinha = $aCSV;
			$this->adicionaLinha();

		}else {

			for ($iCont = 0;$iCont < pg_num_rows($rsTEREM10); $iCont++) {

				$aTEREM10  = pg_fetch_array($rsTEREM10,$iCont, PGSQL_ASSOC);

				unset($aTEREM10['si194_sequencial']);
				unset($aTEREM10['si194_mes']);
				unset($aTEREM10['si194_inst']);

				$aCSVTEREM10['si194_tiporegistro']             =  str_pad($aTEREM10['si194_tiporegistro'], 2, "0", STR_PAD_LEFT);
				$aCSVTEREM10['si194_cnpj']                     =  $aTEREM10['si194_cnpj'];
                $aCSVTEREM10['si194_codteto']                  =  $aTEREM10['si194_codteto'];
				$aCSVTEREM10['si194_vlrparateto']              =  number_format($aTEREM10['si194_vlrparateto'], 2, ",", "");
				$aCSVTEREM10['si194_tipocadastro']             =  str_pad($aTEREM10['si194_tipocadastro'], 1, "0", STR_PAD_LEFT);
				$aCSVTEREM10['si194_dtinicial']                =  implode("", array_reverse(explode("-", $aTEREM10['si194_dtinicial'])));
                $aCSVTEREM10['si194_nrleiteto']                =  $aTEREM10['si194_nrleiteto'];
                $aCSVTEREM10['si194_dtpublicacaolei']          =  implode("", array_reverse(explode("-", $aTEREM10['si194_dtpublicacaolei'])));
				$aCSVTEREM10['si194_dtfinal']                  = implode("", array_reverse(explode("-", $aTEREM10['si194_dtfinal'])));
				$aCSVTEREM10['si194_justalteracao']            =  substr($aTEREM10['si194_justalteracao'], 0, 100);

				$this->sLinha = $aCSVTEREM10;
				$this->adicionaLinha();

			}

            for ($iCont = 0;$iCont < pg_num_rows($rsTEREM20); $iCont++) {

                $aTEREM20  = pg_fetch_array($rsTEREM20,$iCont, PGSQL_ASSOC);

                unset($aTEREM20['si196_sequencial']);
                unset($aTEREM20['si196_mes']);
                unset($aTEREM20['si196_inst']);

                $aCSVTEREM20['si196_tiporegistro']             =  str_pad($aTEREM20['si196_tiporegistro'], 2, "0", STR_PAD_LEFT);
                $aCSVTEREM20['si196_codteto']                  =  $aTEREM20['si196_codteto'];
                $aCSVTEREM20['si196_vlrparateto']              =  number_format($aTEREM20['si196_vlrparateto'], 2, ",", "");
                $aCSVTEREM20['si196_nrleiteto']                =  $aTEREM20['si196_nrleiteto'];
                $aCSVTEREM20['si196_dtpublicacaolei']          =  implode("", array_reverse(explode("-", $aTEREM20['si196_dtpublicacaolei'])));
                $aCSVTEREM20['si196_justalteracaoteto']            =  substr($aTEREM20['si196_justalteracaoteto'], 0, 100);

                $this->sLinha = $aCSVTEREM20;
                $this->adicionaLinha();

            }

		}
		$this->fechaArquivo();
	}

} 
