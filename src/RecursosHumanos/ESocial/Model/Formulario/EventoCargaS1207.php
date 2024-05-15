<?php

namespace ECidade\RecursosHumanos\ESocial\Model\Formulario;

use ECidade\RecursosHumanos\ESocial\Model\Formulario\EventoCargaInterface;

/**
 * Classe responsável por retornar dados da carga
 * do evento 1207
 * @package ECidade\RecursosHumanos\ESocial\Model\Formulario
 */
class EventoCargaS1207 implements EventoCargaInterface
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
		rh01_regist as matricula,
		--infoDeslig
		rhmotivorescisao.rh173_codigo as mtvDeslig,
		rh05_recis as dtdeslig,
		rh01_admiss as dtadmiss,
		rh05_aviso as dtavprv,
		CASE WHEN rh05_taviso = 2 THEN 'S' ELSE 'N' END AS indPagtoAPI,
		0 as pensAlim
		FROM rhpessoal
		JOIN rhpessoalmov ON rhpessoal.rh01_regist = rhpessoalmov.rh02_regist
		JOIN cgm ON rhpessoal.rh01_numcgm = cgm.z01_numcgm
		JOIN rhpesrescisao ON rhpessoalmov.rh02_seqpes = rhpesrescisao.rh05_seqpes
		JOIN rhmotivorescisao ON rhpesrescisao.rh05_motivo = rhmotivorescisao.rh173_sequencial
		WHERE (rh02_anousu,rh02_mesusu) = ({$this->ano},{$this->mes})
		AND DATE_PART('YEAR',rh05_recis) = {$this->ano}
		AND DATE_PART('MONTH',rh05_recis) = {$this->mes}
		AND rhpessoal.rh01_instit = {$this->instit}";

        if (!empty($matricula)) {
            $sql .= " AND rhpessoal.rh01_regist = {$matricula} ";
        }

        $rsResult = \db_query($sql);

        if (!$rsResult) {
            throw new \Exception("Erro ao buscar preenchimentos do S2299");
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
				--dmDev
				CASE
					WHEN gerfsal.r14_regist IS NOT NULL THEN 1
					WHEN gerfres.r20_regist IS NOT NULL THEN 2
					WHEN gerfcom.r48_regist IS NOT NULL THEN 3
					WHEN gerfs13.r35_regist IS NOT NULL THEN 4
				END AS ideDmDev,
				--ideEstabLot
				1 as tpInsc,
				cgminstit.z01_cgccpf as nrInsc,
				eso08_codempregadorlotacao as codLotacao,
				--detVerbas
				COALESCE(r14_rubric,r20_rubric,r48_rubric,r35_rubric) as codRubr,
				'TABRUB1' as ideTabRubr,
				COALESCE(r14_quant,r20_quant,r48_quant,r35_quant) as qtdRubr,
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
				rhinssoutros.rh51_basefo as vlrRemunOE
				FROM rhpessoal
				JOIN rhpessoalmov ON rhpessoal.rh01_regist = rhpessoalmov.rh02_regist
				JOIN db_config ON rhpessoal.rh01_instit = db_config.codigo
				JOIN cgm as cgminstit ON db_config.numcgm = cgminstit.z01_numcgm
				LEFT JOIN rhinssoutros ON rhpessoalmov.rh02_seqpes = rhinssoutros.rh51_seqpes
				LEFT JOIN eventos1020 ON eventos1020.eso08_instit = {$this->instit}
				LEFT JOIN gerfsal ON (rh02_anousu,rh02_mesusu,rh02_regist) = (r14_anousu,r14_mesusu,r14_regist)
				LEFT JOIN gerfres ON (rh02_anousu,rh02_mesusu,rh02_regist) = (r20_anousu,r20_mesusu,r20_regist)
				LEFT JOIN gerfcom ON (rh02_anousu,rh02_mesusu,rh02_regist) = (r48_anousu,r48_mesusu,r48_regist)
				LEFT JOIN gerfs13 ON (rh02_anousu,rh02_mesusu,rh02_regist) = (r35_anousu,r35_mesusu,r35_regist)
				WHERE (rh02_instit,rh02_anousu,rh02_mesusu,rh02_regist) = ({$this->instit},{$this->ano},{$this->mes},{$this->matricula})";

        $rsResult = \db_query($sql);

        if (!$rsResult) {
            throw new \Exception("Erro ao buscar Verbas Rescisórias.");
        }
        return $rsResult;
    }
}
