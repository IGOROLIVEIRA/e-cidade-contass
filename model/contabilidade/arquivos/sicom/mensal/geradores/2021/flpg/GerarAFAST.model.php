<?php

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */

class GerarAFAST extends GerarAM {

	/**
	 *
	 * Mes de referência
	 * @var Integer
	 */
	public $iMes;

	public function gerarDados() {

		$this->sArquivo = "AFAST";
		$this->abreArquivo();

        $sSql     = "select * from afast102021 where si199_mes = {$this->iMes} and si199_inst = ".db_getsession("DB_instit");
        $rsAFAST    = db_query($sSql); //db_criatabela($rsAFAST);

        $sSql2     = "select * from afast202021 where si200_mes = {$this->iMes} and si200_inst = ".db_getsession("DB_instit");
        $rsAFAST2    = db_query($sSql2);

//        $sSql3delete = "delete from afast302021 where si201_mes = {$this->iMes}";
//        db_query($sSql3delete);

        $sSql3 = "select * from afast302021 where si201_mes = {$this->iMes} and si201_inst = ".db_getsession("DB_instit");
        $rsAFAST3 = db_query($sSql3);

		if (pg_num_rows($rsAFAST) == 0 && pg_num_rows($rsAFAST2) == 0 && pg_num_rows($rsAFAST3) == 0 ) {

			$aCSV['tiporegistro']       =   '99';
			$this->sLinha = $aCSV;
			$this->adicionaLinha();

		} else {

			for ($iCont = 0;$iCont < pg_num_rows($rsAFAST); $iCont++) {

				$aAFAST     = pg_fetch_array($rsAFAST,$iCont, PGSQL_ASSOC);

				unset($aAFAST['si199_sequencial']);
				unset($aAFAST['si199_mes']);
				unset($aAFAST['si199_inst']);

				$aAFAST['si199_tiporegistro']              =  str_pad($aAFAST['si199_tiporegistro'], 2, "0", STR_PAD_LEFT);
				$aAFAST['si199_codvinculopessoa']          =  substr($aAFAST['si199_codvinculopessoa'], 0,15);
				$aAFAST['si199_codafastamento']            =  substr($aAFAST['si199_codafastamento'], 0,15);
				$aAFAST['si199_dtinicioafastamento']       =  implode("",array_reverse(explode("-", $aAFAST['si199_dtinicioafastamento'])));

				$inicioAfastamento = date( 'm/Y', strtotime(substr($aAFAST['si199_dtinicioafastamento'],2)) );
                $fimAfastamento = date( 'm/Y', strtotime($aAFAST['si199_dtretornoafastamento'] ));
                $mesdegeracaosicom = $this->iMes."/".db_getsession("DB_anousu");

                if($inicioAfastamento && $fimAfastamento == $mesdegeracaosicom){
                        $aAFAST['si199_dtretornoafastamento'] = implode("", array_reverse(explode("-", $aAFAST['si199_dtretornoafastamento'])));
                }else{
                    $tipos = array(7,8,99);
                    if(in_array($aAFAST['si199_tipoafastamento'],$tipos)) {
                        $aAFAST['si199_dtretornoafastamento'] = '';
                    }else{
                        $aAFAST['si199_dtretornoafastamento'] = implode("", array_reverse(explode("-", $aAFAST['si199_dtretornoafastamento'])));
                    }
                }
				$aAFAST['si199_tipoafastamento']           =  substr($aAFAST['si199_tipoafastamento'], 0,2);
				$aAFAST['si199_dscoutrosafastamentos']     =  substr($aAFAST['si199_dscoutrosafastamentos'], 0,500);

				$this->sLinha = $aAFAST;
				$this->adicionaLinha();

			}

            for ($iCont2 = 0;$iCont2 < pg_num_rows($rsAFAST2); $iCont2++) {

                $aAFAST2     = pg_fetch_array($rsAFAST2,$iCont2, PGSQL_ASSOC);

                unset($aAFAST2['si200_sequencial']);
                unset($aAFAST2['si200_mes']);
                unset($aAFAST2['si200_inst']);

                $aAFAST2['si200_tiporegistro']              =  str_pad($aAFAST2['si200_tiporegistro'], 2, "0", STR_PAD_LEFT);
                $aAFAST2['si200_codvinculopessoa']          =  substr($aAFAST2['si200_codvinculopessoa'], 0,15);
                $aAFAST2['si200_codafastamento']            =  substr($aAFAST2['si200_codafastamento'], 0,15);
                $aAFAST2['si200_dtterminoafastamento']       =  implode("",array_reverse(explode("-", $aAFAST2['si200_dtterminoafastamento'])));

                $this->sLinha = $aAFAST2;
                $this->adicionaLinha();

            }

            for ($iCont3 = 0;$iCont3 < pg_num_rows($rsAFAST3); $iCont3++) {

                $aAFAST3     = pg_fetch_array($rsAFAST3,$iCont3, PGSQL_ASSOC);

                unset($aAFAST3['si201_sequencial']);
                unset($aAFAST3['si201_mes']);
                unset($aAFAST3['si201_inst']);

                $aAFAST3['si201_tiporegistro']              =  str_pad($aAFAST3['si201_tiporegistro'], 2, "0", STR_PAD_LEFT);
                $aAFAST3['si201_codvinculopessoa']          =  substr($aAFAST3['si201_codvinculopessoa'], 0,15);
                $aAFAST3['si201_codafastamento']            =  substr($aAFAST3['si201_codafastamento'], 0,15);
                $aAFAST3['si201_dtretornoafastamento']       =  implode("",array_reverse(explode("-", $aAFAST3['si201_dtretornoafastamento'])));

                $this->sLinha = $aAFAST3;
                $this->adicionaLinha();

            }

			$this->fechaArquivo();

		}

	}

}
