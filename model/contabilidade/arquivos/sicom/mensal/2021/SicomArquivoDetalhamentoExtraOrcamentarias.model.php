<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_ext102021_classe.php");
require_once("classes/db_ext202021_classe.php");
//require_once("classes/db_ext302021_classe.php");
require_once("classes/db_ext312021_classe.php");

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2021/GerarEXT.model.php");

/**
 * Detalhamento Extra Ocamentarias Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class SicomArquivoDetalhamentoExtraOrcamentarias extends SicomArquivoBase implements iPadArquivoBaseCSV
{

	/**
	 *
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
	protected $iCodigoLayout = 171;

	/**
	 *
	 * Nome do arquivo a ser criado
	 * @var String
	 */
	protected $sNomeArquivo = 'EXT';

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
	 * selecionar os dados de //
	 * @see iPadArquivoBase::gerarDados()
	 */
	public function gerarDados()
	{

		$cExt10 = new cl_ext102021();
		$cExt20 = new cl_ext202021();
		$cExt30 = new cl_ext302021();
		$cExt31 = new cl_ext312021();
		/*
         * CASO JA TENHA SIDO GERADO ALTERIORMENTE PARA O MESMO PERIDO O SISTEMA IRA
         * EXCLUIR OS REGISTROS E GERAR NOVAMENTE
         *
         */
		//$aCaracteres = array("°",chr(13),chr(10),"'",";",".");

		db_inicio_transacao();


		$cExt31->excluir(null, "si127_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
	    								and si127_instit = " . db_getsession("DB_instit"));
		if ($cExt31->erro_status == 0) {
			throw new Exception($cExt31->erro_msg);
		}

		$cExt30->excluir(null, "si126_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si126_instit = " . db_getsession("DB_instit"));

		if ($cExt30->erro_status == 0) {
			throw new Exception($cExt30->erro_msg);
		}
		/*$cExt21->excluir(NULL,"si125_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']."
                                      and si125_instit = ".db_getsession("DB_instit"));
        if ($cExt21->erro_status == 0) {
            throw new Exception($cExt21->erro_msg);
        }*/
		$cExt20->excluir(null, "si165_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
	    								and si165_instit = " . db_getsession("DB_instit"));

		if ($cExt20->erro_status == 0) {
			throw new Exception($cExt20->erro_msg);
		}
		$cExt10->excluir(null, "si124_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
	    								and si124_instit = " . db_getsession("DB_instit"));
		if ($cExt10->erro_status == 0) {
			throw new Exception($cExt10->erro_msg);
		}


		db_fim_transacao();

		//exit;


		/*
         * SQL RETORNA TODAS AS CONTAS EXTRAS EXISTENTES NO SISTEMA
         *
         */
		$sSqlExt = "select 10 as tiporegistro,c61_codcon,
				       c61_reduz as codext, 
				       c61_codtce as codtce,
				       si09_codorgaotce as codorgao,
				       (select CASE
									    WHEN o41_subunidade != 0
									         OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
									            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
									              OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
									    ELSE lpad((CASE WHEN o40_codtri = '0'
									         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
									           OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)    
					             end as unidade 
					  from orcunidade 
					  join orcorgao on o41_anousu = o40_anousu and o41_orgao = o40_orgao 
					  where o41_instit = " . db_getsession("DB_instit") . " and o40_anousu = " . db_getsession("DB_anousu") . " order by o40_orgao limit 1) as codUnidadeSub,
				       substr(c60_tipolancamento::varchar,1,2) as tipolancamento,
				       c60_subtipolancamento as subtipo,
				       case when (c60_tipolancamento = 1 and c60_subtipolancamento in (1,2,3,4) ) or
				                 (c60_tipolancamento = 4 and c60_subtipolancamento in (1,2) ) or
				                 (c60_tipolancamento = 9999 and c60_desdobramneto is not null) then c60_desdobramneto
				            else 0
				       end as desdobrasubtipo,
				       substr(c60_descr,1,50) as descextraorc
				  from conplano 
				  join conplanoreduz on c60_codcon = c61_codcon and c60_anousu = c61_anousu 
				  left join infocomplementaresinstit on si09_instit = c61_instit 
				  where c60_anousu = " . db_getsession("DB_anousu") . " and c60_codsis = 7 and c61_instit = " . db_getsession("DB_instit") . "
  				order by c61_reduz  ";
		$rsContasExtra = db_query($sSqlExt);//echo pg_last_error();db_criatabela($rsContasExtra);

		// matriz de entrada
		$what = array("°", chr(13), chr(10), 'ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'Ã', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º');

		// matriz de saída
		$by = array('', '', '', 'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ');


		$aSaldosIniFim = array();
		for ($iContador = 0; $iContador < pg_num_rows($rsContasExtra); $iContador++) {

			$oContaExtraSaldo = db_utils::fieldsMemory($rsContasExtra, $iContador);


			/*
              * PEGA SALDO INICIAL E FINAL DAS CONTAS EXTRAS DE TODAS AS CONTAS E COLOCA EM UM ARRAY
              */

			$where = " c61_instit in (" . db_getsession("DB_instit") . ") ";
			$where .= " and c61_reduz = " . $oContaExtraSaldo->codext . " and c61_reduz != 0";

			/**
			 * Comando adicionado para excluir tabela temporária que, ao gerar o arquivo juntamente com outros que utilizam essa função, traz valores diferentes
			 */
			db_query("drop table if EXISTS work_pl");
			db_inicio_transacao();
			$rsPlanoContasSaldo = db_planocontassaldo_matriz(db_getsession("DB_anousu"), $this->sDataInicial, $this->sDataFinal, false, $where);
			//db_criatabela($rsPlanoContasSaldo);
			db_fim_transacao(true);

			//db_criatabela($rsPlanoContasSaldo);

			for ($iContPlano = 0; $iContPlano < pg_num_rows($rsPlanoContasSaldo); $iContPlano++) {

				if (db_utils::fieldsMemory($rsPlanoContasSaldo, $iContPlano)->c61_reduz != 0) {
					$oPlanoContas = db_utils::fieldsMemory($rsPlanoContasSaldo, $iContPlano);
					$oSaldoInicioFim = new stdClass();
					$oSaldoInicioFim->reduz = $oPlanoContas->c61_reduz;
					$oSaldoInicioFim->sinal_anterior = $oPlanoContas->sinal_anterior;
					$oSaldoInicioFim->sinal_final = $oPlanoContas->sinal_final;
					$oSaldoInicioFim->sdini = $oPlanoContas->saldo_anterior;
					$oSaldoInicioFim->sdfim = $oPlanoContas->saldo_final;
					$oSaldoInicioFim->saldo_debito = $oPlanoContas->saldo_anterior_debito;
					$oSaldoInicioFim->saldo_credito = $oPlanoContas->saldo_anterior_credito;


					$aSaldosIniFim[] = $oSaldoInicioFim;
				}
			}
		}


		/*
         * PERCORRE OS SQL NOVAMENTE PARA INSERIR NA BASE DE DADOS OS REGISTROS
         */
		db_inicio_transacao();


		$aExt10Agrupodo = array();
		for ($iCont10 = 0; $iCont10 < pg_num_rows($rsContasExtra); $iCont10++) {

			$oContaExtra = db_utils::fieldsMemory($rsContasExtra, $iCont10);


			/*
             * VERIFICA SE A CONTA EXTRA JA FOI INFORMADA EM  MES ANTERIOR
             * SE EXISTIR NAO INFORMAR NOVAMENTE
             *
           $result = $cExt10->sql_record($cExt10->sql_query(NULL,"*",NULL,"si124_mes < ".$this->sDataFinal['5'].$this->sDataFinal['6']."
                            and si124_codext =".$oContaExtra->codext)." and si124_instit = ".db_getsession("DB_instit"));
           if (pg_num_rows($result) == 0) {*/


			$aHash = $oContaExtra->codorgao;
			$aHash .= $oContaExtra->codunidadesub;
			$aHash .= $oContaExtra->tipolancamento;
			$aHash .= $oContaExtra->subtipo;
			$aHash .= $oContaExtra->desdobrasubtipo;

			if (!isset($aExt10Agrupodo[$aHash])) {
				$cExt10 = new cl_ext102021();

				$cExt10->si124_tiporegistro = $oContaExtra->tiporegistro;
				$cExt10->si124_codext = $oContaExtra->codtce != 0 ? $oContaExtra->codtce : $oContaExtra->codext;
				$cExt10->si124_codorgao = $oContaExtra->codorgao;
				$cExt10->si124_tipolancamento = substr(str_pad($oContaExtra->tipolancamento, 2, "0", STR_PAD_LEFT), 0, 2);
				$cExt10->si124_subtipo = substr(str_pad($oContaExtra->subtipo, 4, "0", STR_PAD_LEFT), 0, 4);
				$cExt10->si124_desdobrasubtipo = substr(str_pad($oContaExtra->desdobrasubtipo, 4, "0", STR_PAD_LEFT), 0, 4);
				$cExt10->si124_descextraorc = $oContaExtra->descextraorc;
				$cExt10->si124_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
				$cExt10->si124_instit = db_getsession("DB_instit");
				$cExt10->extras = array();

				$sSqlVerifica = "SELECT si124_sequencial
										FROM ext102021
										WHERE si124_codorgao = '$oContaExtra->codorgao'
		       							AND si124_tipolancamento = '$cExt10->si124_tipolancamento'
		       							AND si124_subtipo = '$cExt10->si124_subtipo'
		       							AND si124_desdobrasubtipo = '$cExt10->si124_desdobrasubtipo'
		       							AND si124_mes < " . $this->sDataFinal['5'] . $this->sDataFinal['6'];
				$sSqlVerifica .= " UNION
								 SELECT si124_sequencial
										FROM ext102020
										WHERE si124_codorgao = '$oContaExtra->codorgao'
		       							AND si124_tipolancamento = '$cExt10->si124_tipolancamento'
		       							AND si124_subtipo = '$cExt10->si124_subtipo'
										   AND si124_desdobrasubtipo = '$cExt10->si124_desdobrasubtipo'";
				$sSqlVerifica .= " UNION
										SELECT si124_sequencial
										FROM ext102019
										WHERE si124_codorgao = '$oContaExtra->codorgao'
										AND si124_tipolancamento = '$cExt10->si124_tipolancamento'
										AND si124_subtipo = '$cExt10->si124_subtipo'
										AND si124_desdobrasubtipo = '$cExt10->si124_desdobrasubtipo'";
				$sSqlVerifica .= " UNION
								 SELECT si124_sequencial
										FROM ext102018
										WHERE si124_codorgao = '$oContaExtra->codorgao'
		       							AND si124_tipolancamento = '$cExt10->si124_tipolancamento'
		       							AND si124_subtipo = '$cExt10->si124_subtipo'
		       							AND si124_desdobrasubtipo = '$cExt10->si124_desdobrasubtipo'";
				$sSqlVerifica .= " UNION
								 SELECT si124_sequencial
										FROM ext102017
										WHERE si124_codorgao = '$oContaExtra->codorgao'
		       							AND si124_tipolancamento = '$cExt10->si124_tipolancamento'
		       							AND si124_subtipo = '$cExt10->si124_subtipo'
		       							AND si124_desdobrasubtipo = '$cExt10->si124_desdobrasubtipo'";
				$sSqlVerifica .= " UNION
								 SELECT si124_sequencial
										FROM ext102016
										WHERE si124_codorgao = '$oContaExtra->codorgao'
		       							AND si124_tipolancamento = '$cExt10->si124_tipolancamento'
		       							AND si124_subtipo = '$cExt10->si124_subtipo'
		       							AND si124_desdobrasubtipo = '$cExt10->si124_desdobrasubtipo'";
				$sSqlVerifica .= " UNION
								 SELECT si124_sequencial
										FROM ext102015
										WHERE si124_codorgao = '$oContaExtra->codorgao'
		       							AND si124_tipolancamento = '$cExt10->si124_tipolancamento'
		       							AND si124_subtipo = '$cExt10->si124_subtipo'
		       							AND si124_desdobrasubtipo = '$cExt10->si124_desdobrasubtipo'";
                $sSqlVerifica .= " UNION
                				 SELECT si124_sequencial
                				 		FROM ext102014
                				 		WHERE si124_codorgao = '$oContaExtra->codorgao'
                				 		AND si124_codunidadesub = '$oContaExtra->codunidadesub'
                   						AND si124_tipolancamento = '$cExt10->si124_tipolancamento'
                   						AND si124_subtipo = '" . substr($oContaExtra->subtipo, 0, 4) . "'
                   						AND si124_desdobrasubtipo = '$cExt10->si124_desdobrasubtipo' ";
				$rsResulVerifica = db_query($sSqlVerifica);

				if (pg_num_rows($rsResulVerifica) == 0) {
					$cExt10->incluir(null);
					if ($cExt10->erro_status == 0) {
						throw new Exception($cExt10->erro_msg);
					}
				}

				$cExt10->extras[] = $oContaExtra->codext;
				$aExt10Agrupodo[$aHash] = $cExt10;
			} else {
				$aExt10Agrupodo[$aHash]->extras[] = $oContaExtra->codext;
			}
			//}

		}
		//echo "<pre>";print_r($aExt10Agrupodo); echo "<br>--------------------<br>";

		foreach ($aExt10Agrupodo as $oExt10Agrupado) {

			$cExt20 = new cl_ext202021();
			$aExt30 = array();
			foreach ($oExt10Agrupado->extras as $nExtras) {


				/*
                 * GRAVAR DADOS DO REGISTRO 20
                 */

				/* SQL RETORNA A FONTE DE RECURSO DA CONTA EXTRA */
				$sSqlExtRecurso = "select o15_codtri from conplanoreduz
	        join orctiporec on c61_codigo = o15_codigo where c61_anousu = " . db_getsession("DB_anousu") . " and c61_reduz = " . $nExtras;
				$rsExtRecurso = db_query($sSqlExtRecurso);

				$oExtRecurso = db_utils::fieldsMemory($rsExtRecurso, 0)->o15_codtri;
				/*
                 * PEGA SALDO ALTERIOR E FINAL
                 */
				foreach ($aSaldosIniFim as $nSaldoIniFim) {
					if ($nSaldoIniFim->reduz == $nExtras) {
						$saldoanterior = $nSaldoIniFim->sinal_anterior == 'C' ? ($nSaldoIniFim->sdini * -1) : $nSaldoIniFim->sdini;
						$saldofinal = $nSaldoIniFim->sinal_final == 'C' ? ($nSaldoIniFim->sdfim * -1) : $nSaldoIniFim->sdfim;
						$natsaldoanteriorfonte = $nSaldoIniFim->sinal_anterior;
						$natsaldoatualfonte = $nSaldoIniFim->sinal_final;
						$saldodebito = $nSaldoIniFim->saldo_debito;
						$saldocredito = $nSaldoIniFim->saldo_credito;
						break;
					}
				}

				if (empty($cExt20->si165_tiporegistro)) {

					$cExt20->si165_tiporegistro = '20';
					$cExt20->si165_codorgao = $oExt10Agrupado->si124_codorgao;
					$cExt20->si165_codext = $oExt10Agrupado->si124_codext;
					$cExt20->si165_codfontrecursos = $oExtRecurso;
					$cExt20->si165_vlsaldoanteriorfonte = $saldoanterior;
					$cExt20->si165_natsaldoanteriorfonte = $natsaldoanteriorfonte == '' ? 'C' : $natsaldoanteriorfonte;
					$cExt20->si165_vlsaldoatualfonte = $saldofinal;
					$cExt20->si165_natsaldoatualfonte = $natsaldoatualfonte == '' || $saldofinal == 0 ? 'C' : $natsaldoatualfonte;
					$cExt20->si165_totaldebitos = $saldodebito;
					$cExt20->si165_totalcreditos = $saldocredito;
					$cExt20->si165_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
					$cExt20->si165_instit = db_getsession("DB_instit");
					$cExt20->ext30 = array();

				} else {

					$cExt20->si165_vlsaldoanteriorfonte += $saldoanterior;
					$cExt20->si165_vlsaldoatualfonte += $saldofinal;
					$cExt20->si165_totaldebitos += $saldodebito;
					$cExt20->si165_totalcreditos += $saldocredito;

				}
				//echo "<pre>";print_r($cExt20);

				/*
                 * CARREGA OS DADOS DO REGISTRO 30
                 */
				$sSql30Geral = "select   '30' as tiporegitro,
						         k17_codigo as codigo,
						         k17_debito	 as codext,
						         c71_data as dtlancamento,
						         k17_valor as vllancamento, 
						         2 as tipo,
						         c71_coddoc
						     from slip 
						     join conlancamslip on k17_codigo = c84_slip
						     join conlancamdoc  on c71_codlan = c84_conlancam
						     join conplanoreduz on k17_debito = c61_reduz and c61_anousu = " . db_getsession("DB_anousu") . "
						     join orctiporec on o15_codigo  = c61_codigo
						left join infocomplementaresinstit on k17_instit = si09_instit
						 where c71_data between '" . $this->sDataInicial . "' AND '" . $this->sDataFinal . "'
						   and k17_debito = {$nExtras} and k17_situacao IN (2,4)
						   and c71_coddoc in (151,161,120);
						
						";

				$rsExt30Geral = db_query($sSql30Geral);//db_criatabela($rsExt30Geral);

				for ($linha = 0; $linha < pg_num_rows($rsExt30Geral); $linha++) {

					$oExt30Geral = db_utils::fieldsMemory($rsExt30Geral, $linha);

					$sSql30 = "select '30' as tiporegitro,
									         c71_codlan as codreduzidomov,
									         (slip.k17_codigo||slip.k17_debito) ::int8 as codreduzidoop,
									         (slip.k17_codigo||slip.K17_debito) ::int8 as nroop,
									         c71_data as dtpagamento,
									         case when length(cc.z01_cgccpf::char) = 11 then 1 else 2 end as tipodocumentocredor,
									         cc.z01_cgccpf as nrodocumentocredor,
									         k17_valor as vlop,
									         k17_texto as especificacaoop,
									         substr(c.z01_cgccpf,1,11) as cpfresppgto,2 as tipo,
									         o15_codtri::int as codfontrecursos,
									         (select CASE
															    WHEN o41_subunidade != 0
															         OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
															            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
															              OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
															    ELSE lpad((CASE WHEN o40_codtri = '0'
															         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
															           OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)    
					             end as unidade
					           from orcunidade
					           join orcorgao on o41_anousu = o40_anousu and o41_orgao = o40_orgao
					           where o41_instit = " . db_getsession("DB_instit") . " and o40_anousu = " . db_getsession("DB_anousu") . " order by o40_orgao limit 1) as codUnidadeSub
									     from slip
									     join slipnum on slipnum.k17_codigo = slip.k17_codigo 
									     join conlancamslip on slip.k17_codigo = c84_slip
									     join conlancamdoc  on c71_codlan = c84_conlancam
									     join conplanoreduz on k17_debito = c61_reduz and c61_anousu = " . db_getsession("DB_anousu") . "
									     join orctiporec on o15_codigo  = c61_codigo
									     join cgm cc on cc.z01_numcgm = slipnum.k17_numcgm
									left join infocomplementaresinstit on k17_instit = si09_instit
									left join cgm c on c.z01_numcgm = si09_gestor
									 where c71_data between '" . $this->sDataInicial . "' AND '" . $this->sDataFinal . "'
									   and slip.k17_codigo = {$oExt30Geral->codigo} and slip.k17_situacao IN (2,4)
									   and c71_coddoc in (120,151,161) ";


					$rsExt30 = db_query($sSql30);
					//db_criatabela($rsExt30);
					/*FOR PARA PEGAR O REGISTRO 31 E COLOCAR NO 30*/
					for ($linha30 = 0; $linha30 < pg_num_rows($rsExt30); $linha30++) {

						$oExt30 = db_utils::fieldsMemory($rsExt30, $linha30);

						$cExt30 = new stdClass();

						$cExt30->si126_tiporegistro = $oExt30->tiporegitro;
						$cExt30->si126_codext = $oExt10Agrupado->si124_codext;
						$cExt30->si126_codfontrecursos = $oExt30->codfontrecursos;
						$cExt30->si126_codreduzidoop = $oExt30->codreduzidoop;
						$cExt30->si126_nroop = $oExt30->nroop;
						$cExt30->si126_codunidadesub = $oExt30->codunidadesub;
						$cExt30->si126_dtpagamento = $oExt30->dtpagamento;
						$cExt30->si126_tipodocumentocredor = strlen($oExt30->nrodocumentocredor) == 11 ? 1 : 2;
						$cExt30->si126_nrodocumentocredor = $oExt30->nrodocumentocredor;
						$cExt30->si126_vlop = $oExt30->vlop;
						$cExt30->si126_especificacaoop = trim(preg_replace("/[^a-zA-Z0-9 ]/", "", substr(str_replace($what, $by, $oExt30->especificacaoop), 0, 200)));
						$cExt30->si126_cpfresppgto = $oExt30->cpfresppgto;
						$cExt30->si126_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
						$cExt30->si126_instit = db_getsession("DB_instit");
						$cExt30->ext31 = array();

						$sSql31 = "SELECT   31 AS tiporegistro,
											         (k17_codigo||K17_credito) AS codreduzidoop,
											         CASE WHEN e96_codigo = 1 OR c60_codsis = 5 THEN 5
											             WHEN e96_codigo = 2 THEN 1 
											             ELSE 99  
											         END AS tipodocumentoop,
											         CASE WHEN e96_codigo = 2 THEN e91_cheque 
											             ELSE NULL 
											         END AS nrodocumento,
											         K17_debito AS codctb,
											         o15_codtri AS codfontectb,
											         k17_data AS dtemissao,
											         k17_valor AS vldocumento,
													 e81_numdoc
											      FROM slip
											INNER JOIN conplanoreduz cr ON cr.c61_reduz  = k17_credito and cr.c61_anousu = EXTRACT(YEAR from k17_data)::int
											INNER JOIN conplano      ON c61_codcon = c60_codcon and c60_anousu = c61_anousu
											       AND c61_anousu = c60_anousu
											INNER JOIN orctiporec    ON c61_codigo = o15_codigo
											INNER JOIN conplanoreduz db ON db.c61_reduz  = k17_debito and db.c61_anousu = EXTRACT(YEAR from k17_data)::int
											LEFT JOIN conplanoconta ON c63_codcon = db.c61_codcon
											       AND db.c61_anousu = c63_anousu
											INNER JOIN empageslip ON e89_codigo = k17_codigo
											INNER JOIN empagemov  ON e81_codmov = e89_codmov
											       AND e81_cancelado IS NULL
											 LEFT JOIN empagemovforma ON e97_codmov   = e81_codmov
											 LEFT JOIN empageforma    ON e97_codforma = e96_codigo
											 LEFT JOIN empageconfche  ON e91_codmov   = e81_codmov
											       AND e91_ativo IS TRUE
											     WHERE k17_codigo = {$oExt30Geral->codigo}
											     AND (c63_codcon IS NOT NULL OR c60_codsis = 5) /*condicao adicionada para pegar apenas contas caixa e bancarias*/
											UNION ALL        
											SELECT   31 AS tiporegistro,
											         (k17_codigo||K17_debito) AS codreduzidoop,
											         CASE WHEN e96_codigo = 1 OR c60_codsis = 5 THEN 5
											             WHEN e96_codigo = 2 THEN 1 
											             ELSE 99 
											         END AS tipodocumentoop,
											         CASE WHEN e96_codigo = 2 THEN e91_cheque 
											             ELSE NULL 
											         END AS nrodocumento,
											         K17_credito AS codctb,
											         o15_codtri AS codfontectb,
											         k17_data AS dtemissao,
											         k17_valor AS vldocumento,
													 e81_numdoc
											      FROM slip
											INNER JOIN conplanoreduz cr ON cr.c61_reduz  = k17_debito and cr.c61_anousu = EXTRACT(YEAR from k17_data)::int
											INNER JOIN conplano      ON c61_codcon = c60_codcon and c60_anousu = c61_anousu
											       AND c61_anousu = c60_anousu
											INNER JOIN orctiporec    ON c61_codigo = o15_codigo
											INNER JOIN conplanoreduz db ON db.c61_reduz  = k17_credito and db.c61_anousu = EXTRACT(YEAR from k17_data)::int
											LEFT JOIN conplanoconta ON c63_codcon = db.c61_codcon
											       AND db.c61_anousu = c63_anousu
											INNER JOIN empageslip ON e89_codigo = k17_codigo
											INNER JOIN empagemov  ON e81_codmov = e89_codmov
											       AND e81_cancelado IS NULL
											 LEFT JOIN empagemovforma ON e97_codmov   = e81_codmov
											 LEFT JOIN empageforma    ON e97_codforma = e96_codigo
											 LEFT JOIN empageconfche  ON e91_codmov   = e81_codmov
											       AND e91_ativo IS TRUE
											     WHERE k17_codigo = {$oExt30Geral->codigo}
											     AND (c63_codcon IS NOT NULL OR c60_codsis = 5) /*condicao adicionada para pegar apenas contas caixa e bancarias*/";


						$rsExt31 = db_query($sSql31);//db_criatabela($rsExt31);
						if (pg_num_rows($rsExt31) == 0) {
							$cExt31 = new stdClass();

							$cExt31->si127_tiporegistro = 31;
							$cExt31->si127_codreduzidoop = $oExt30->codreduzidoop;
							$cExt31->si127_tipodocumentoop = 99;
							$cExt31->si127_nrodocumento = 0;
							$cExt31->si127_codctb = 0;
							$cExt31->si127_codfontectb = 0;
							$cExt31->si127_desctipodocumentoop = 'TED';
							$cExt31->si127_dtemissao = $oExt30->dtpagamento;
							$cExt31->si127_vldocumento = $oExt30->vlop;
							$cExt31->si127_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
							$cExt31->si127_reg21 = 0;
							$cExt31->si127_instit = db_getsession("DB_instit");

							$cExt30->ext31[] = $cExt31;
						} else {

							/*FOR PARA PEGAR O REGISTRO 31 E COLOCAR NO 30*/
							for ($linha31 = 0; $linha31 < pg_num_rows($rsExt31); $linha31++) {

								$oExt31 = db_utils::fieldsMemory($rsExt31, $linha31);

								$sSqlContaPagFont = "select distinct si95_codctb  as conta, o15_codtri as fonte from conplanoconta
											join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
											join orctiporec on c61_codigo = o15_codigo
											join ctb102021 on 
											si95_banco   = c63_banco and
											si95_agencia = c63_agencia and 
											si95_digitoverificadoragencia = c63_dvagencia and
											si95_contabancaria = c63_conta::int8 and
											si95_digitoverificadorcontabancaria = c63_dvconta and
											si95_tipoconta::int8 = c63_tipoconta join ctb202021 on si96_codctb = si95_codctb and si96_mes = si95_mes
											        where c61_reduz = {$oExt31->codctb} and c61_anousu = " . db_getsession("DB_anousu") . "
											        and si95_mes <=" . $this->sDataFinal['5'] . $this->sDataFinal['6'];
								$sSqlContaPagFont .= " UNION select distinct si95_codctb  as conta, o15_codtri as fonte from conplanoconta
											join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
											join orctiporec on c61_codigo = o15_codigo
											join ctb102020 on
											si95_banco   = c63_banco and
											si95_agencia = c63_agencia and
											si95_digitoverificadoragencia = c63_dvagencia and
											si95_contabancaria = c63_conta::int8 and
											si95_digitoverificadorcontabancaria = c63_dvconta and
											si95_tipoconta::int8 = c63_tipoconta join ctb202020 on si96_codctb = si95_codctb and si96_mes = si95_mes
													where c61_reduz = {$oExt31->codctb} and c61_anousu = " . db_getsession("DB_anousu");
								$sSqlContaPagFont .= " UNION select distinct si95_codctb  as conta, o15_codtri as fonte from conplanoconta
											join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
											join orctiporec on c61_codigo = o15_codigo
											join ctb102019 on
											si95_banco   = c63_banco and
											si95_agencia = c63_agencia and
											si95_digitoverificadoragencia = c63_dvagencia and
											si95_contabancaria = c63_conta::int8 and
											si95_digitoverificadorcontabancaria = c63_dvconta and
											si95_tipoconta::int8 = c63_tipoconta join ctb202019 on si96_codctb = si95_codctb and si96_mes = si95_mes
											        where c61_reduz = {$oExt31->codctb} and c61_anousu = " . db_getsession("DB_anousu");
								$sSqlContaPagFont .= " UNION select distinct si95_codctb  as conta, o15_codtri as fonte from conplanoconta
											join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
											join orctiporec on c61_codigo = o15_codigo
											join ctb102018 on
											si95_banco   = c63_banco and
											si95_agencia = c63_agencia and
											si95_digitoverificadoragencia = c63_dvagencia and
											si95_contabancaria = c63_conta::int8 and
											si95_digitoverificadorcontabancaria = c63_dvconta and
											si95_tipoconta::int8 = c63_tipoconta join ctb202018 on si96_codctb = si95_codctb and si96_mes = si95_mes
											        where c61_reduz = {$oExt31->codctb} and c61_anousu = " . db_getsession("DB_anousu");
								$sSqlContaPagFont .= " UNION select distinct si95_codctb  as conta, o15_codtri as fonte from conplanoconta
											join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
											join orctiporec on c61_codigo = o15_codigo
											join ctb102017 on
											si95_banco   = c63_banco and
											si95_agencia = c63_agencia and
											si95_digitoverificadoragencia = c63_dvagencia and
											si95_contabancaria = c63_conta::int8 and
											si95_digitoverificadorcontabancaria = c63_dvconta and
											si95_tipoconta::int8 = c63_tipoconta join ctb202017 on si96_codctb = si95_codctb and si96_mes = si95_mes
											        where c61_reduz = {$oExt31->codctb} and c61_anousu = " . db_getsession("DB_anousu");
								$sSqlContaPagFont .= " UNION select distinct si95_codctb  as conta, o15_codtri as fonte from conplanoconta
											join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
											join orctiporec on c61_codigo = o15_codigo
											join ctb102016 on
											si95_banco   = c63_banco and
											si95_agencia = c63_agencia and
											si95_digitoverificadoragencia = c63_dvagencia and
											si95_contabancaria = c63_conta::int8 and
											si95_digitoverificadorcontabancaria = c63_dvconta and
											si95_tipoconta::int8 = c63_tipoconta join ctb202016 on si96_codctb = si95_codctb and si96_mes = si95_mes
											        where c61_reduz = {$oExt31->codctb} and c61_anousu = " . db_getsession("DB_anousu");
								$sSqlContaPagFont .= " UNION select distinct si95_codctb  as conta, o15_codtri as fonte from conplanoconta
											join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
											join orctiporec on c61_codigo = o15_codigo
											join ctb102015 on
											si95_banco   = c63_banco and
											si95_agencia = c63_agencia and
											si95_digitoverificadoragencia = c63_dvagencia and
											si95_contabancaria = c63_conta::int8 and
											si95_digitoverificadorcontabancaria = c63_dvconta and
											si95_tipoconta::int8 = c63_tipoconta join ctb202015 on si96_codctb = si95_codctb and si96_mes = si95_mes
											        where c61_reduz = {$oExt31->codctb} and c61_anousu = " . db_getsession("DB_anousu");
								$sSqlContaPagFont .= " UNION select distinct si95_codctb  as conta, o15_codtri as fonte from conplanoconta
											join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
											join orctiporec on c61_codigo = o15_codigo
											join ctb102014 on 
											si95_banco   = c63_banco and
											si95_agencia = c63_agencia and 
											si95_digitoverificadoragencia = c63_dvagencia and
											si95_contabancaria = c63_conta::int8 and
											si95_digitoverificadorcontabancaria = c63_dvconta and
											si95_tipoconta::int8 = c63_tipoconta join ctb202014 on si96_codctb = si95_codctb and si96_mes = si95_mes
											        where c61_reduz = {$oExt31->codctb} and c61_anousu = " . db_getsession("DB_anousu");
								$rsResultContaPag = db_query($sSqlContaPagFont);
								$oConta = db_utils::fieldsMemory($rsResultContaPag, 0);

								$cExt31 = new stdClass();

								$cExt31->si127_tiporegistro = $oExt31->tiporegistro;
								$cExt31->si127_codreduzidoop = $oExt30->codreduzidoop;
								$cExt31->si127_tipodocumentoop = $oExt31->tipodocumentoop;
								$cExt31->si127_nrodocumento = ($oExt31->tipodocumentoop == '99' && $oExt31->e81_numdoc != '') ? ' ' : $oExt31->nrodocumento;
								$cExt31->si127_codctb = $oExt31->tipodocumentoop == 5 ? 0 : $oConta->conta;
								$cExt31->si127_codfontectb = $oExt31->tipodocumentoop == 5 ? 100 : $oConta->fonte;
								if ($oExt31->tipodocumentoop == '99' && $oExt31->e81_numdoc != '') {
									$cExt31->si127_desctipodocumentoop = $oExt31->e81_numdoc;
								} elseif ($oExt31->tipodocumentoop == '99') {
									$cExt31->si127_desctipodocumentoop = 'TED';
								} else {
									$cExt31->si127_desctipodocumentoop = ' ';
								}
								$cExt31->si127_dtemissao = $oExt30->dtpagamento;
								$cExt31->si127_vldocumento = $oExt31->vldocumento;
								$cExt31->si127_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
								$cExt31->si127_reg21 = 0;
								$cExt31->si127_instit = db_getsession("DB_instit");

								$cExt30->ext31[] = $cExt31;

							}//FIM FOR 31
						}
						$aExt30[] = $cExt30;

					}//FIM FOR 30


				}// FIM FOR 30 Geral

			}
			$cExt20->ext30[] = $aExt30;
			//echo "<br>--------------------<br>";
			//echo "<pre>";print_r($cExt20); echo "<br>--------------------<br>";
			echo pg_last_error();
			$cExt20->incluir(null);
			if ($cExt20->erro_status == 0) {
				throw new Exception($cExt20->erro_msg);
			}
			/*
             * desagrupar para salvar no bd
             */
			foreach ($cExt20->ext30 as $aExtAgrupado) {

				foreach ($aExtAgrupado as $oExt30agrupado) {

					//echo "<pre>";print_r($oExt30agrupado);exit;
					$cExt30 = new cl_ext302021();

					$cExt30->si126_tiporegistro = $oExt30agrupado->si126_tiporegistro;
					$cExt30->si126_codext = $oExt30agrupado->si126_codext;
					$cExt30->si126_codfontrecursos = $oExt30agrupado->si126_codfontrecursos;
					$cExt30->si126_codreduzidoop = $oExt30agrupado->si126_codreduzidoop;
					$cExt30->si126_nroop = $oExt30agrupado->si126_nroop;
					$cExt30->si126_codunidadesub = $oExt30agrupado->si126_codunidadesub;
					$cExt30->si126_dtpagamento = $oExt30agrupado->si126_dtpagamento;
					$cExt30->si126_tipodocumentocredor = $oExt30agrupado->si126_tipodocumentocredor;
					$cExt30->si126_nrodocumentocredor = $oExt30agrupado->si126_nrodocumentocredor;
					$cExt30->si126_vlop = $oExt30agrupado->si126_vlop;
					$cExt30->si126_especificacaoop = substr($this->removeCaracteres($oExt30agrupado->si126_especificacaoop), 0, 200);
					$cExt30->si126_cpfresppgto = $oExt30agrupado->si126_cpfresppgto;
					$cExt30->si126_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
					$cExt30->si126_instit = db_getsession("DB_instit");

					$cExt30->incluir(null);
					if ($cExt30->erro_status == 0) {
						throw new Exception($cExt30->erro_msg);
					}
					foreach ($oExt30agrupado->ext31 as $oExt31agrupado) {

						$cExt31 = new cl_ext312021();

						$cExt31->si127_tiporegistro = $oExt31agrupado->si127_tiporegistro;
						$cExt31->si127_codreduzidoop = $oExt31agrupado->si127_codreduzidoop;
						$cExt31->si127_tipodocumentoop = $oExt31agrupado->si127_tipodocumentoop;
						$cExt31->si127_nrodocumento = $oExt31agrupado->si127_nrodocumento;
						$cExt31->si127_codctb = $oExt31agrupado->si127_codctb;
						$cExt31->si127_codfontectb = $oExt31agrupado->si127_codfontectb;
						$cExt31->si127_dtemissao = $oExt31agrupado->si127_dtemissao;
						$cExt31->si127_vldocumento = $oExt31agrupado->si127_vldocumento;
						$cExt31->si127_desctipodocumentoop = $oExt31agrupado->si127_desctipodocumentoop;
						$cExt31->si127_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
						$cExt31->si127_reg30 = $cExt30->si126_sequencial;
						$cExt31->si127_instit = db_getsession("DB_instit");

						$cExt31->incluir(null);

						if ($cExt31->erro_status == 0) {
							throw new Exception($cExt31->erro_msg);
						}

					}//fim for 31

				}//fim for 30
			}

		}

		db_fim_transacao();
		$oGerarEXT = new GerarEXT();
		$oGerarEXT->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];;
		$oGerarEXT->gerarDados();

	}

}
