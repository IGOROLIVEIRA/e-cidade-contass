<?php

namespace ECidade\RecursosHumanos\ESocial\Model\Formulario;

use ECidade\RecursosHumanos\ESocial\Model\Formulario\EventoCargaInterface;

/**
 * Classe respons�vel por retornar dados da carga
 * do evento 2299
 * @package ECidade\RecursosHumanos\ESocial\Model\Formulario
 */
class EventoCargaS2299 implements EventoCargaInterface
{

	/**
	 * @var Integer
	 */
	private $instit;

	/**
	 * @var Integer
	 */
	private $ano;

	/**
	 * @var Integer
	 */
	private $mes;

	public function __construct() 
	{
		$this->ano = db_getsession("DB_anousu");
		$this->mes = date("m", db_getsession("DB_datausu"));
		$this->instit = db_getsession("DB_instit");
	}

	/**
	 * Executa o sql da carga
	 * @param integer|null $matricula
	 * @return resource
	 */
	public function execute($matricula = null) 
	{
		$sql = "SELECT DISTINCT
		--ideVinculo
		z01_cgccpf as cpftrab,
		rh01_esocial as matricula,
		rh01_regist as matricula_sistema,
		--infoDeslig
		rhmotivorescisao.rh173_codigo as mtvDeslig,
		rh05_recis as dtdeslig,
		rh01_admiss as dtadmiss,
		rh05_aviso as dtavprv,
		CASE WHEN rh05_taviso = 2 THEN 'S' ELSE 'N' END AS indPagtoAPI,
		0 as pensAlim,
		rh30_regime
		FROM rhpessoal 
		JOIN rhpessoalmov ON rhpessoal.rh01_regist = rhpessoalmov.rh02_regist
		JOIN cgm ON rhpessoal.rh01_numcgm = cgm.z01_numcgm
		JOIN rhpesrescisao ON rhpessoalmov.rh02_seqpes = rhpesrescisao.rh05_seqpes
		JOIN rhmotivorescisao ON lpad(rhpesrescisao.rh05_motivo::varchar, 2, '0') = rhmotivorescisao.rh173_codigo
		JOIN rhregime ON rhpessoalmov.rh02_codreg = rhregime.rh30_codreg
		WHERE (rh02_anousu,rh02_mesusu) = ({$this->ano},{$this->mes})
		AND DATE_PART('YEAR',rh05_recis) = {$this->ano}
		AND DATE_PART('MONTH',rh05_recis) = {$this->mes}
		AND rhpessoal.rh01_instit = {$this->instit}";

		if (!empty($matricula)) {
			$sql .= " AND rhpessoal.rh01_regist in ({$matricula}) ";
		}

		$rsResult = \db_query($sql);

        if (!$rsResult) {
            throw new \Exception("Erro ao buscar preenchimentos do S2299. ".pg_last_error());
        }
        return $rsResult;
	}

	/**
	 * Executa o sql das verbas rescisorias
	 * @param integer $matricula
	 * @return resource
	 */
	public function getVerbasResc($matricula)
	{
		$sql = "SELECT DISTINCT 
		verbas.*, 
		CASE 
		WHEN e990_sequencial = '1000' THEN '9000'
		WHEN e990_sequencial = '5001' THEN '9001'
		WHEN e990_sequencial = '1020' AND verbas.r20_tpp = 'P' THEN '9002'
		WHEN e990_sequencial = '1020' AND verbas.r20_tpp = 'V' THEN '9003'
		ELSE NULL END AS codrubresocial
		FROM (
		SELECT DISTINCT
				--dmDev
				CASE 
					WHEN gerfsal.r14_regist IS NOT NULL THEN 'gerfsal'
					WHEN gerfres.r20_regist IS NOT NULL THEN 'gerfres'
					WHEN gerfcom.r48_regist IS NOT NULL THEN 'gerfcom'
					WHEN gerfs13.r35_regist IS NOT NULL THEN 'gerfs13'
				END AS ideDmDev,
				--ideEstabLot
				1 as tpInsc,
				cgminstit.z01_cgccpf as nrInsc,
				'LOTA1' as codLotacao,
				--detVerbas
				COALESCE(r14_rubric,r20_rubric,r48_rubric,r35_rubric) as codRubr,
				'TABRUB1' as ideTabRubr,
				NULL as qtdRubr,
				COALESCE(r14_valor,r20_valor,r48_valor,r35_valor) as vrRubr,
				0 as indApurIR,
				--infoAgNocivo
				CASE
				WHEN rh02_ocorre IN ('2','6') THEN 2
				WHEN rh02_ocorre IN ('3','7') THEN 3
				WHEN rh02_ocorre IN ('4','8') THEN 4
				ELSE 1 END AS grauExp,
				--infoMV
				rhinssoutros.rh51_indicadesconto as indMV,
				--remunOutrEmpr
				1 as tpInscremunOutrEmpr,
				rhinssoutros.rh51_cgcvinculo as nrInscremunOutrEmpr,
				rhinssoutros.rh51_categoria as codCateg,
				rhinssoutros.rh51_basefo as vlrRemunOE,
				gerfres.r20_tpp
				FROM rhpessoal 
				JOIN rhpessoalmov ON rhpessoal.rh01_regist = rhpessoalmov.rh02_regist
				JOIN db_config ON rhpessoal.rh01_instit = db_config.codigo
				JOIN cgm as cgminstit ON db_config.numcgm = cgminstit.z01_numcgm
				LEFT JOIN rhinssoutros ON rhpessoalmov.rh02_seqpes = rhinssoutros.rh51_seqpes
				LEFT JOIN gerfsal ON (rh02_anousu,rh02_mesusu,rh02_regist) = (r14_anousu,r14_mesusu,r14_regist) AND r14_pd != 3
				LEFT JOIN gerfres ON (rh02_anousu,rh02_mesusu,rh02_regist) = (r20_anousu,r20_mesusu,r20_regist) AND r20_pd != 3
				LEFT JOIN gerfcom ON (rh02_anousu,rh02_mesusu,rh02_regist) = (r48_anousu,r48_mesusu,r48_regist) AND r48_pd != 3
				LEFT JOIN gerfs13 ON (rh02_anousu,rh02_mesusu,rh02_regist) = (r35_anousu,r35_mesusu,r35_regist) AND r35_pd != 3
				WHERE (rh02_instit,rh02_anousu,rh02_mesusu,rh02_regist) = ({$this->instit},{$this->ano},{$this->mes},{$matricula}) 
			) AS verbas 
		LEFT JOIN baserubricasesocial ON baserubricasesocial.e991_rubricas = verbas.codrubr AND e991_instit = {$this->instit}
		LEFT JOIN rubricasesocial ON baserubricasesocial.e991_rubricasesocial = rubricasesocial.e990_sequencial AND e990_sequencial IN ('1000','5001','1020') ";

		$rsResult = \db_query($sql);

        if (!$rsResult) {
            throw new \Exception("Erro ao buscar Verbas Rescis�rias. ".pg_last_error());
        }
        return $rsResult;

	}
}