<?php

namespace ECidade\RecursosHumanos\ESocial\Model\Formulario;

use ECidade\RecursosHumanos\ESocial\Model\Formulario\EventoCargaInterface;

/**
 * Classe responsável por retornar dados da carga
 * do evento 2299
 * @package ECidade\RecursosHumanos\ESocial\Model\Formulario
 */
class EventoCargaS2400 implements EventoCargaInterface
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
        $sql = "SELECT DISTINCT z01_cgccpf AS cpfbenef,
        z01_nome AS nmbenefic,
        rh01_nasc AS dtnascto,
        CASE
            WHEN rh01_admiss <= '2021-11-22' THEN '2021-11-22'
            WHEN rh01_admiss > '2021-11-22' THEN rh01_admiss
        END AS dtinicio,
        CASE
            WHEN rh01_sexo = 'F' THEN 4002049
            ELSE 4002048
        END AS sexo,
        CASE
            WHEN rh01_raca = 1 THEN 4002054
            WHEN rh01_raca = 2 THEN 4002050
            WHEN rh01_raca = 4 THEN 4002051
            WHEN rh01_raca = 6 THEN 4002053
            WHEN rh01_raca = 8 THEN 4002052
            WHEN rh01_raca = 9 THEN 4002055
        END AS racacor,
        CASE
            WHEN rh01_estciv = 1 THEN 4002056
            WHEN rh01_estciv = 2 THEN 4002057
            WHEN rh01_estciv = 3 THEN 4002060
            WHEN rh01_estciv = 4 THEN 4002059
            WHEN rh01_estciv = 5 THEN 4002058
            ELSE 4002056
        END AS estciv,
        CASE
            WHEN rh02_portadormolestia = 't' THEN 4002061
            ELSE 4002062
        END AS incfismen,
        CASE
            WHEN ruas.j14_tipo IS NULL THEN 'R'
            ELSE j88_sigla
        END AS tplograd,
        z01_ender AS dsclograd,
        z01_numero AS nrlograd,
        z01_compl AS complementolograd,
        z01_bairro AS bairro,
        rpad(z01_cep,8,'0') AS cep,
        (coalesce((select
            db125_codigosistema
        from
            cadendermunicipio
        inner join cadendermunicipiosistema on
            cadendermunicipiosistema.db125_cadendermunicipio = cadendermunicipio.db72_sequencial
            and cadendermunicipiosistema.db125_db_sistemaexterno = 4
        where to_ascii(db72_descricao) = to_ascii(trim(cgm.z01_munic)) limit 1), (select
            db125_codigosistema
        from
            cadendermunicipio
        inner join cadendermunicipiosistema on
            cadendermunicipiosistema.db125_cadendermunicipio = cadendermunicipio.db72_sequencial
            and cadendermunicipiosistema.db125_db_sistemaexterno = 4
        where to_ascii(db72_descricao) = to_ascii(trim((SELECT z01_munic FROM cgm join db_config ON z01_numcgm = numcgm WHERE codigo = fc_getsession('DB_instit')::int))) limit 1))
        ) AS codMunic,
                    4002082 AS uf
    FROM rhpessoal
    INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
    INNER JOIN db_config ON db_config.codigo = rhpessoal.rh01_instit
    LEFT JOIN db_cgmbairro ON cgm.z01_numcgm = db_cgmbairro.z01_numcgm
    LEFT JOIN bairro ON bairro.j13_codi = db_cgmbairro.j13_codi
    LEFT JOIN db_cgmruas ON cgm.z01_numcgm = db_cgmruas.z01_numcgm
    LEFT JOIN ruas ON ruas.j14_codigo = db_cgmruas.j14_codigo
    LEFT JOIN ruastipo ON j88_codigo = j14_tipo
    LEFT JOIN rhpessoalmov ON rh02_anousu = (select r11_anousu from cfpess where r11_instit = fc_getsession('DB_instit')::int order by r11_anousu desc, r11_mesusu desc limit 1)
    AND rh02_mesusu = (select r11_mesusu from cfpess where r11_instit = fc_getsession('DB_instit')::int order by r11_anousu desc, r11_mesusu desc limit 1)
    AND rh02_regist = rh01_regist
    AND rh02_instit = fc_getsession('DB_instit')::int
    LEFT JOIN rhdepend ON rhdepend.rh31_regist = rhpessoal.rh01_regist
    LEFT JOIN rhregime ON rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
    LEFT JOIN rhpesrescisao ON rh02_seqpes = rh05_seqpes
    LEFT JOIN rescisao ON rescisao.r59_anousu = rhpessoalmov.rh02_anousu
    AND rescisao.r59_mesusu = rhpessoalmov.rh02_mesusu
    AND rescisao.r59_regime = rhregime.rh30_regime
    AND rescisao.r59_causa = rhpesrescisao.rh05_causa
    AND rescisao.r59_caub = rhpesrescisao.rh05_caub::char(2)
    where rh30_vinculo in ('I','P')
    AND (
    (
    (date_part('year',rhpessoal.rh01_admiss)::varchar || lpad(date_part('month',rhpessoal.rh01_admiss)::varchar,2,'0'))::integer <= 202207
    and (date_part('year',fc_getsession('DB_datausu')::date)::varchar || lpad(date_part('month',fc_getsession('DB_datausu')::date)::varchar,2,'0'))::integer <= 202207
    and (rh05_recis is null or (date_part('year',rh05_recis)::varchar || lpad(date_part('month',rh05_recis)::varchar,2,'0'))::integer > 202207)
    ) or (
    date_part('month',rhpessoal.rh01_admiss) = date_part('month',fc_getsession('DB_datausu')::date)
    and date_part('year',rhpessoal.rh01_admiss) = date_part('year',fc_getsession('DB_datausu')::date)
    and (date_part('year',fc_getsession('DB_datausu')::date)::varchar || lpad(date_part('month',fc_getsession('DB_datausu')::date)::varchar,2,'0'))::integer > 202207
    )
    )";

        if (!empty($matricula)) {
            $sql .= " AND rhpessoal.rh01_regist = {$matricula} ";
        }
        // echo $sql;
        // exit;
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
				rhinssoutros.rh51_basefo as vlrRemunOE
				FROM rhpessoal
				JOIN rhpessoalmov ON rhpessoal.rh01_regist = rhpessoalmov.rh02_regist
				JOIN db_config ON rhpessoal.rh01_instit = db_config.codigo
				JOIN cgm as cgminstit ON db_config.numcgm = cgminstit.z01_numcgm
				LEFT JOIN rhinssoutros ON rhpessoalmov.rh02_seqpes = rhinssoutros.rh51_seqpes
				LEFT JOIN gerfsal ON (rh02_anousu,rh02_mesusu,rh02_regist) = (r14_anousu,r14_mesusu,r14_regist)
				LEFT JOIN gerfres ON (rh02_anousu,rh02_mesusu,rh02_regist) = (r20_anousu,r20_mesusu,r20_regist)
				LEFT JOIN gerfcom ON (rh02_anousu,rh02_mesusu,rh02_regist) = (r48_anousu,r48_mesusu,r48_regist)
				LEFT JOIN gerfs13 ON (rh02_anousu,rh02_mesusu,rh02_regist) = (r35_anousu,r35_mesusu,r35_regist)
				WHERE (rh02_instit,rh02_anousu,rh02_mesusu,rh02_regist) = ({$this->instit},{$this->ano},{$this->mes},{$matricula})";

        $rsResult = \db_query($sql);

        if (!$rsResult) {
            throw new \Exception("Erro ao buscar Verbas Rescisórias.");
        }
        return $rsResult;
    }
}
