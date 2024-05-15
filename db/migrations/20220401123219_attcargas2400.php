<?php

use Phinx\Migration\AbstractMigration;

class Attcargas2400 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
        BEGIN;
        update avaliacao set db101_cargadados = 'SELECT DISTINCT z01_cgccpf AS cpfbenef,
                z01_nome AS nmbenefic,
                rh01_nasc AS dtnascto,
                CASE
                    WHEN rh01_admiss <= \'2021-11-22\' THEN \'2021-11-22\'
                    WHEN rh01_admiss > \'2021-11-22\' THEN rh01_admiss
                END AS dtinicio,
                CASE
                    WHEN rh01_sexo = \'F\' THEN 4002049
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
                END AS estciv,
                CASE
                    WHEN rh02_portadormolestia = \'t\' THEN 4002142
                    ELSE 4002143
                END AS incfismen,
                CASE
                    WHEN ruas.j14_tipo IS NULL THEN \'R\'
                    ELSE j88_sigla
                END AS tplograd,
                z01_ender AS dsclograd,
                z01_numero AS nrlograd,
                z01_compl AS complementolograd,
                z01_bairro AS bairro,
                rpad(z01_cep,8,\'0\') AS cep,

    (SELECT db125_codigosistema
     FROM cadendermunicipio
     INNER JOIN cadendermunicipiosistema ON cadendermunicipiosistema.db125_cadendermunicipio = cadendermunicipio.db72_sequencial
     AND cadendermunicipiosistema.db125_db_sistemaexterno = 4
     INNER JOIN cadenderestado ON cadendermunicipio.db72_cadenderestado = cadenderestado.db71_sequencial
     INNER JOIN cadenderpais ON cadenderestado.db71_cadenderpais = cadenderpais.db70_sequencial
     INNER JOIN cadenderpaissistema ON cadenderpais.db70_sequencial = cadenderpaissistema.db135_db_cadenderpais
     WHERE to_ascii(db72_descricao) = trim(cgm.z01_munic)
     ORDER BY db72_sequencial ASC
     LIMIT 1) AS codmunic,
                4002082 AS uf
FROM rhpessoal
INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
INNER JOIN db_config ON db_config.codigo = rhpessoal.rh01_instit
LEFT JOIN db_cgmbairro ON cgm.z01_numcgm = db_cgmbairro.z01_numcgm
LEFT JOIN bairro ON bairro.j13_codi = db_cgmbairro.j13_codi
LEFT JOIN db_cgmruas ON cgm.z01_numcgm = db_cgmruas.z01_numcgm
LEFT JOIN ruas ON ruas.j14_codigo = db_cgmruas.j14_codigo
LEFT JOIN ruastipo ON j88_codigo = j14_tipo
LEFT JOIN rhpessoalmov ON rh02_anousu = fc_getsession(\'DB_anousu\')::int
AND rh02_mesusu = date_part(\'month\',fc_getsession(\'DB_datausu\')::date)
AND rh02_regist = rh01_regist
AND rh02_instit = fc_getsession(\'DB_instit\')::int
LEFT JOIN rhdepend ON rhdepend.rh31_regist = rhpessoal.rh01_regist
LEFT JOIN rhregime ON rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
LEFT JOIN rhpesrescisao ON rh02_seqpes = rh05_seqpes
LEFT JOIN rescisao ON rescisao.r59_anousu = rhpessoalmov.rh02_anousu
AND rescisao.r59_mesusu = rhpessoalmov.rh02_mesusu
AND rescisao.r59_regime = rhregime.rh30_regime
AND rescisao.r59_causa = rhpesrescisao.rh05_causa
AND rescisao.r59_caub = rhpesrescisao.rh05_caub::char(2)
WHERE rh05_recis IS NULL
    AND ((rh02_mesusu = 11
          AND rh02_anousu = 2021
          AND rh05_recis IS NULL)
         OR (rh02_mesusu = 11
             AND rh02_anousu = 2021
             AND (rh05_recis IS NOT NULL
                  AND date_part(\'month\',rh01_admiss::date) <> 12
                  AND date_part(\'day\',rh05_recis::date) <= 21
                  AND date_part(\'month\',rh05_recis::date) = 11)
             OR (rh02_anousu > 2021
                 AND date_part(\'month\',rh01_admiss::date) = date_part(\'month\',fc_getsession(\'DB_datausu\')::date)
                 AND date_part(\'year\',rh01_admiss::date) = fc_getsession(\'DB_anousu\')::int)))' where db101_sequencial = 4000116;
        COMMIT;
SQL;
        $this->execute($sql);
    }
}
