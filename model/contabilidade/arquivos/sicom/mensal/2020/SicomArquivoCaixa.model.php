<?php


require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_caixa102020_classe.php");
require_once("classes/db_caixa112020_classe.php");
require_once("classes/db_caixa122020_classe.php");
require_once("classes/db_caixa132020_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2020/GerarCAIXA.model.php");

/**
 * Contas de Caixa Sicom Acompanhamento Mensal
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoCaixa extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  
	/**
	 *
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
	protected $iCodigoLayout = 165;
	
	/**
	 *
	 * Nome do arquivo a ser criado
	 * @var String
	 */
	protected $sNomeArquivo = 'CAIXA';
	
	/**
	 *
	 * Construtor da classe
	 */
	public function __construct()
	{
		
	}
	
	/**
	 * Retorna o codigo do layout
	 *
	 * @return Integer
	 */
	public function getCodigoLayout()
	{
		return $this->iCodigoLayout;
	}
	
	/**
	 *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
	*/
	public function getCampos()
	{
		

	}
	
	/**
	 * selecionar os dados das contas Caixa
	 * @see iPadArquivoBase::gerarDados()
	 */
	public function gerarDados()
	{

		$clcaixa13 = new cl_caixa132020();
		$clcaixa12 = new cl_caixa122020();
		$clcaixa11 = new cl_caixa112020();
		$clcaixa10 = new cl_caixa102020();

		/*
		* SE JA FOI GERADO ESTA ROTINA UMA VEZ O SISTEMA APAGA OS DADOS DO BANCO E GERA NOVAMENTE
		*/
		db_inicio_transacao();
		$result = $clcaixa10->sql_record($clcaixa10->sql_query(null, "*", null, "si103_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
			and si103_instit = " . db_getsession("DB_instit")));
		
		if (pg_num_rows($result) > 0) {

			$clcaixa13->excluir(null, "si105_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
					and si105_instit = " . db_getsession("DB_instit"));
			$clcaixa12->excluir(null, "si104_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
					and si104_instit = " . db_getsession("DB_instit"));
			$clcaixa11->excluir(null, "si166_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
					and si166_instit = " . db_getsession("DB_instit"));
			$clcaixa10->excluir(null, "si103_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
					and si103_instit = " . db_getsession("DB_instit"));

			if ($clcaixa10->erro_status == 0) {
				throw new Exception($clcaixa10->erro_msg);
			}

		}
		
		$result = $clcaixa10->sql_record($clcaixa10->sql_query(null, "*", null, "si103_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
			and si103_instit = " . db_getsession("DB_instit")));

		db_fim_transacao();

		/*
		* PEGA TODAS AS CONTAS CAIXA DA INSTIUICAO
		*/
		$sSqlContasCaixa = "SELECT c60_codcon,c61_reduz,c60_descr,si09_codorgaotce,o15_codtri from ";
		$sSqlContasCaixa .= "conplano join conplanoreduz on c60_codcon = c61_codcon 
							left join  infocomplementaresinstit on c61_instit = si09_instit 
							join orctiporec on o15_codigo = c61_codigo ";
		$sSqlContasCaixa .= "where c60_codsis = 5 and c60_anousu = " . db_getsession("DB_anousu");
		$sSqlContasCaixa .= " and c61_anousu = " . db_getsession("DB_anousu") . " and c61_instit = " . db_getsession("DB_instit");
		
		$rsContasCaixa = db_query($sSqlContasCaixa);

		/**
		 * percorrer registros de contas retornados do sql acima para pega saldo anterior
		 */
		$aDadosAgrupados = array();

		for ($iCont = 0; $iCont < pg_num_rows($rsContasCaixa); $iCont++) {

			$oContas = db_utils::fieldsMemory($rsContasCaixa, $iCont);

			$where = " c61_instit in (" . db_getsession("DB_instit") . ") and c60_codsis in (5) ";
			$where .= "and c61_codcon = " . $oContas->c60_codcon;

			/**
			 * Comando adicionado para excluir tabela temporária que, ao gerar o arquivo juntamente com outros que utilizam essa função, traz valores diferentes
			 */
			db_query("drop table if EXISTS work_pl");
			$rsPlanoContas = db_planocontassaldo(db_getsession("DB_anousu"), $this->sDataInicial, $this->sDataFinal, false, $where);

			for ($iContPlano = 0; $iContPlano < pg_num_rows($rsPlanoContas); $iContPlano++) {

				if (db_utils::fieldsMemory($rsPlanoContas, $iContPlano)->c61_reduz != 0) {
				$oPlanoContas = db_utils::fieldsMemory($rsPlanoContas, $iContPlano);
				}

			}

			if ($oPlanoContas->sinal_final == 'C') {
				$nSaldoFinal = $oPlanoContas->saldo_final * -1;
			} else {
				$nSaldoFinal = $oPlanoContas->saldo_final;
			}

			if ($oPlanoContas->sinal_anterior == 'C') {
				$nSaldoInicial = $oPlanoContas->saldo_anterior * -1;
			} else {
				$nSaldoInicial = $oPlanoContas->saldo_anterior;
			}

			$sHash10 = $oContas->si09_codorgaotce;

			if (!isset($aDadosAgrupados[$sHash10])) {

				$oDados10 = new stdClass();

				$oDados10->si103_tiporegistro 	= 10;
				$oDados10->si103_codorgao 		= $oContas->si09_codorgaotce;
				$oDados10->si103_vlsaldoinicial	= $nSaldoInicial;
				$oDados10->si103_vlsaldofinal 	= $nSaldoFinal;

				$aDadosAgrupados[$sHash10] = $oDados10;

			} else {

				$aDadosAgrupados[$sHash10]->si103_vlsaldoinicial 	+= $nSaldoInicial;
				$aDadosAgrupados[$sHash10]->si103_vlsaldofinal 		+= $nSaldoFinal;

			}

			$sHash11 = $oContas->o15_codtri;

			if (!isset($aDadosAgrupados[$sHash10]->registro11[$sHash11])) {

				$oDados11 = new stdClass();

				$oDados11->si166_tiporegistro 			= 11;
				$oDados11->si166_codfontecaixa 			= $oContas->o15_codtri;
				$oDados11->si166_vlsaldoinicialfonte 	= $nSaldoInicial;
				$oDados11->si166_vlsaldofinalfonte 		= $nSaldoFinal;

				$aDadosAgrupados[$sHash10]->registro11[$sHash11] = $oDados11;

			} else {

				$aDadosAgrupados[$sHash10]->registro11[$sHash11]->si166_vlsaldoinicialfonte += $nSaldoInicial;
				$aDadosAgrupados[$sHash10]->registro11[$sHash11]->si166_vlsaldofinalfonte 	+= $nSaldoFinal;

			}

			$sSql = "select  12 as tiporegistro,
								c69_codlan as codreduzido ,
								1 as tipomovimentacao,
								case when substr(o57_fonte,1,2) = '49' and c71_coddoc in (100) then 8
									when c71_coddoc in (100) then 1
									when c71_coddoc in (140) then 3
									when c71_coddoc in (121,131,141,152,153,162,163,6,36,38,101) then 8
									else 10 
								end as tipoentrsaida,
								case when c71_coddoc not in (100,101,140,121,131,152,153,162,163,6,36,38,5,35,37) then substr(c72_complem,1,50) 
									else ' '
								end as descrmovimentacao,
								c69_valor as valorEntrsaida,
								case 
									when c71_coddoc = 140 then
										case 
											when c61_codtce is not null then c61_codtce
											else c69_credito
										end 
									else null 
								end as codctbtransf,
								case when c71_coddoc = 140 then o15_codtri else null end as codfontectbtransf,c71_coddoc,substr(o57_fonte,1,2) as dedu
								from conlancamval
								join conlancamdoc on c71_codlan = c69_codlan
						left join conlancamrec on c74_codlan = c69_codlan
						left join orcreceita on c74_codrec = o70_codrec and o70_anousu = " . db_getsession("DB_anousu") . "
						left join conplanoreduz on c61_reduz = c69_credito and c61_anousu = " . db_getsession("DB_anousu") . "
						left join orcfontes on o70_codfon = o57_codfon and o70_anousu = o57_anousu
						left join orctiporec on o15_codigo = c61_codigo
						left join conlancamcompl on c72_codlan = c71_codlan
							where c69_debito = {$oContas->c61_reduz}
								and c69_data between '" . $this->sDataInicial . "' AND '" . $this->sDataFinal . "'
						
						union all 
						
						select  12 as tiporegistro,
								c69_codlan as codreduzido ,
								case when c71_coddoc in (101) and substr(o57_fonte,1,2) = '49' then 1 else 2 end as tipomovimentacao,
								case when c71_coddoc in (100) and substr(o57_fonte,1,2) = '49' then 8
									when c71_coddoc in (101) and substr(o57_fonte,1,2) = '49' then 1
									when c71_coddoc in (140) then 4
									when c71_coddoc in (121,131,141,152,153,162,163,6,36,38,101) then 8
									when c71_coddoc in (5,35,37,161) then 6
									else 10 
								end as tipoentrsaida,
								case when c71_coddoc not in (100,101,140,121,131,152,153,162,163,6,36,38,5,35,37) then substr(c72_complem,1,50) 
									else ' '
								end as descrmovimentacao,
								c69_valor as valorEntrsaida,
								case 
									when c71_coddoc = 140 then
										case 
											when c61_codtce is not null then c61_codtce
											else c69_debito 
										end
									else null
								end as codctbtransf,
								case when c71_coddoc = 140 then o15_codtri else null end as codfontectbtransf,c71_coddoc,substr(o57_fonte,1,2) as dedu
								from conlancamval
								join conlancamdoc on c71_codlan = c69_codlan
						left join conlancamrec on c74_codlan = c69_codlan
						left join orcreceita on c74_codrec = o70_codrec and o70_anousu = " . db_getsession("DB_anousu") . "
						left join conplanoreduz on c61_reduz = c69_debito and c61_anousu = " . db_getsession("DB_anousu") . "
						left join orcfontes on o70_codfon = o57_codfon and o70_anousu = o57_anousu
						left join orctiporec on o15_codigo = c61_codigo
						left join conlancamcompl on c72_codlan = c71_codlan
							where c69_credito = {$oContas->c61_reduz}
								and c69_data between '" . $this->sDataInicial . "' AND '" . $this->sDataFinal . "'";

			$rsMovi = db_query($sSql);

			for ($iCont2 = 0; $iCont2 < pg_num_rows($rsMovi); $iCont2++) {

				$oMovi = db_utils::fieldsMemory($rsMovi, $iCont2);

				$sHash12 = $oMovi->tiporegistro;
				$sHash12 .= $oMovi->tipomovimentacao;
				$sHash12 .= $oMovi->tipoentrsaida;
				$sHash12 .= $oMovi->codctbtransf;
				$sHash12 .= $oMovi->codfontectbtransf;

				if ($oMovi->c71_coddoc == 101 && $oMovi->dedu == '49') {
					$nValor = $oMovi->valorentrsaida * -1;
				} else {
					$nValor = $oMovi->valorentrsaida;
				}

				if (!isset($aDadosAgrupados[$sHash10]->registro12[$sHash12])) {

					$oDados12 = new stdClass();

					$oDados12->si104_tiporegistro 		= $oMovi->tiporegistro;
					$oDados12->si104_codreduzido 		= $oMovi->codreduzido;
					$oDados12->si104_codfontecaixa 		= $oContas->o15_codtri;
					$oDados12->si104_tipomovimentacao 	= $oMovi->tipomovimentacao;
					$oDados12->si104_tipoentrsaida 		= $oMovi->tipoentrsaida;
					$oDados12->si104_descrmovimentacao 	= $oMovi->tipoentrsaida != 10 ? '' : $oMovi->descrmovimentacao;
					$oDados12->si104_valorentrsaida 	= $nValor;
					$oDados12->si104_codctbtransf 		= $oMovi->codctbtransf;
					$oDados12->si104_codfontectbtransf 	= $oMovi->codfontectbtransf;

					$aDadosAgrupados[$sHash10]->registro12[$sHash12] = $oDados12;

				} else {
					$aDadosAgrupados[$sHash10]->registro12[$sHash12]->si104_valorentrsaida += $nValor;
				}

				$sSql = "SELECT 13 AS tiporegistro,
								c74_codlan AS codreduzdio,
								CASE
									WHEN substr(o57_fonte,1,2) = '49' THEN 1
									ELSE 2
								END AS ededucaodereceita,
								CASE
									WHEN substr(o57_fonte,1,2) = '49' THEN substr(o57_fonte,2,2)
									ELSE NULL
								END AS ededucaodereceita,
								substr(o57_fonte,2,8) AS naturezaReceita,
								c70_valor AS vlrreceitacont,
								o15_codtri::integer
							FROM conlancamrec
							JOIN conlancam ON c70_codlan = c74_codlan AND c70_anousu = c74_anousu
							LEFT JOIN orcreceita ON c74_codrec = o70_codrec AND o70_anousu = 2020
							LEFT JOIN orcfontes ON o70_codfon = o57_codfon AND o70_anousu = o57_anousu
							LEFT JOIN orctiporec ON o15_codigo = o70_codigo
							WHERE c74_codlan = {$oMovi->codreduzido}";

				$rsReceita = db_query($sSql);

				if (pg_num_rows($rsReceita) != 0) {

					$oReceita = db_utils::fieldsMemory($rsReceita, 0);
					$sHash13 = $oReceita->ededucaodereceita . $oReceita->identificadordeducao . $oReceita->naturezareceita . $oReceita->o15_codtri;
			
					if (!isset($aDadosAgrupados[$sHash10]->registro13[$sHash13])) {

						$oDados13 = new stdClass();

						$oDados13->si105_tiporegistro 			= $oReceita->tiporegistro;
						$oDados13->si105_codreduzido 			= $oMovi->codreduzido;
						$oDados13->si105_ededucaodereceita 		= $oReceita->ededucaodereceita;
						$oDados13->si105_identificadordeducao 	= $oReceita->identificadordeducao;
						$oDados13->si105_naturezareceita 		= $oReceita->naturezareceita;
						$oDados13->si105_vlrreceitacont 		= $oReceita->vlrreceitacont;
						$oDados13->si105_codfontcaixa 			= $oReceita->o15_codtri;

						$aDadosAgrupados[$sHash10]->registro13[$sHash13] = $oDados13;

					} else {
						$aDadosAgrupados[$sHash10]->registro13[$sHash13]->si105_vlrreceitacont += $oReceita->vlrreceitacont;
					}

				}

			}

		}		

		foreach ($aDadosAgrupados as $oDados10) {

			$clcaixa10 = new cl_caixa102020();

			$clcaixa10->si103_tiporegistro 		= $oDados10->si103_tiporegistro;
			$clcaixa10->si103_codorgao 			= $oDados10->si103_codorgao;
			$clcaixa10->si103_vlsaldoinicial	= $oDados10->si103_vlsaldoinicial;
			$clcaixa10->si103_vlsaldofinal 		= $oDados10->si103_vlsaldofinal;
			$clcaixa10->si103_mes 				= $this->sDataFinal['5'] . $this->sDataFinal['6'];
			$clcaixa10->si103_instit 			= db_getsession("DB_instit");			

			$clcaixa10->incluir(null);

        	if ($clcaixa10->erro_status == 0) {
          		throw new Exception($clcaixa10->erro_msg);
        	}

			foreach($oDados10->registro11 as $oDados11) {

				$clcaixa11 = new cl_caixa112020();
				$clcaixa11->si166_tiporegistro 			= $oDados11->si166_tiporegistro;
				$clcaixa11->si166_codfontecaixa 		= $oDados11->si166_codfontecaixa;
				$clcaixa11->si166_vlsaldoinicialfonte 	= $oDados11->si166_vlsaldoinicialfonte;
				$clcaixa11->si166_vlsaldofinalfonte 	= $oDados11->si166_vlsaldofinalfonte;
				$clcaixa11->si166_mes 					= $this->sDataFinal['5'] . $this->sDataFinal['6'];
				$clcaixa11->si166_instit 				= db_getsession("DB_instit");
				$clcaixa11->si166_reg10 				= $clcaixa10->si103_sequencial;
				
				$clcaixa11->incluir(null);
				
				if ($clcaixa11->erro_status == 0) {
					throw new Exception($clcaixa11->erro_msg);
			  	}

			}

			foreach($oDados10->registro12 as $oDados12) {

				$clcaixa12 = new cl_caixa122020();

				$clcaixa12->si104_tiporegistro 		= $oDados12->si104_tiporegistro;
				$clcaixa12->si104_codreduzido 		= $oDados12->si104_codreduzido;
				$clcaixa12->si104_codfontecaixa 	= $oDados12->si104_codfontecaixa;
				$clcaixa12->si104_tipomovimentacao 	= $oDados12->si104_tipomovimentacao;
				$clcaixa12->si104_tipoentrsaida 	= $oDados12->si104_tipoentrsaida;
				$clcaixa12->si104_descrmovimentacao = $oDados12->si104_descrmovimentacao;
				$clcaixa12->si104_valorentrsaida 	= abs($oDados12->si104_valorentrsaida);
				$clcaixa12->si104_codctbtransf 		= $oDados12->si104_codctbtransf;
				$clcaixa12->si104_codfontectbtransf = $oDados12->si104_codfontectbtransf;
				$clcaixa12->si104_mes 				= $this->sDataFinal['5'] . $this->sDataFinal['6'];
				$clcaixa12->si104_instit 			= db_getsession("DB_instit");
				$clcaixa12->si104_reg10 			= $clcaixa10->si103_sequencial;

				$clcaixa12->incluir(null);

				if ($clcaixa12->erro_status == 0) {
					throw new Exception($clcaixa12->erro_msg);
				}

			}

			foreach ($oDados10->registro13 as $oDados13) {

				$clcaixa13 = new cl_caixa132020();

				$clcaixa13->si105_tiporegistro 			= $oDados13->si105_tiporegistro;
				$clcaixa13->si105_codreduzido 			= $oDados13->si105_codreduzido;
				$clcaixa13->si105_ededucaodereceita 	= $oDados13->si105_ededucaodereceita;
				$clcaixa13->si105_identificadordeducao 	= $oDados13->si105_identificadordeducao;
				$clcaixa13->si105_naturezareceita 		= $oDados13->si105_naturezareceita;
				$clcaixa13->si105_codfontcaixa 			= $oDados13->si105_codfontcaixa;
				$clcaixa13->si105_vlrreceitacont 		= $oDados13->si105_vlrreceitacont;
				$clcaixa13->si105_mes 					= $this->sDataFinal['5'] . $this->sDataFinal['6'];
				$clcaixa13->si105_instit 				= db_getsession("DB_instit");
				$clcaixa13->si105_reg10 				= $clcaixa10->si103_sequencial;

				$clcaixa13->incluir(null);

				if ($clcaixa13->erro_status == 0) {
					throw new Exception($clcaixa13->erro_msg);
				}

			}

		}

		$oGerarCAIXA = new GerarCAIXA();
		$oGerarCAIXA->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
		$oGerarCAIXA->gerarDados();
		
  	}

}
