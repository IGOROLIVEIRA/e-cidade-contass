<?php

use Phinx\Migration\AbstractMigration;

class Updatecarga2230 extends AbstractMigration
{

    public function up()
    {
        $sql = <<<SQL
        BEGIN;
            update avaliacao set db101_cargadados = ' SELECT DISTINCT *
            FROM
                (SELECT cgm.z01_cgccpf AS cpftrab,
                        rhpessoal.rh01_regist AS matricula,
                        tpcontra.h13_categoria AS codcateg,
                        afasta.r45_dtafas AS dtiniafast,
                        afasta.r45_codigoafasta AS codmotafast,
                        afasta.r45_mesmadoenca AS infomesmomtv,
                        afasta.r45_dtreto dttermafast,
                        NULL AS dtiniafastferias,
                        NULL AS dtinicio,
                        NULL AS dtfim,
                        NULL AS dttermafastferias
                FROM afasta
                INNER JOIN rhpessoal ON rhpessoal.rh01_regist = afasta.r45_regist
                LEFT JOIN rhpessoalmov ON rh02_anousu = fc_getsession(\'DB_anousu\')::int
            AND rh02_mesusu = date_part(\'month\',fc_getsession(\'DB_datausu\')::date)
            AND rh02_regist = rh01_regist
            AND rh02_instit = fc_getsession(\'DB_instit\')::int
            INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
            INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
            WHERE date_part(\'month\',afasta.r45_dtafas::date) = date_part(\'month\',fc_getsession(\'DB_datausu\')::date)
                AND date_part(\'year\',afasta.r45_dtafas::date) = fc_getsession(\'DB_anousu\')::int
            UNION
            SELECT cgm.z01_cgccpf AS cpftrab,
                rhpessoal.rh01_regist AS matricula,
                tpcontra.h13_categoria AS codcateg,
                cadferia.r30_per1i AS dtiniafast,
                \'15\' AS codmotafast,
                \'\' AS infomesmomtv,
                NULL AS dttermafast,
                cadferia.r30_per1i AS dtiniafastferias,
                cadferia.r30_perai AS dtinicio,
                CASE
                    WHEN (cadferia.r30_peraf - cadferia.r30_perai) < 365 THEN cadferia.r30_peraf
                    WHEN (cadferia.r30_peraf - cadferia.r30_perai) > 365 THEN cadferia.r30_peraf
                    ELSE NULL
                END AS dtfim,
                r30_per1f AS dttermafastferias
            FROM cadferia
            INNER JOIN rhpessoal ON rhpessoal.rh01_regist = cadferia.r30_regist
            LEFT JOIN rhpessoalmov ON rh02_anousu = fc_getsession(\'DB_anousu\')::int
            AND rh02_mesusu = date_part(\'month\',fc_getsession(\'DB_datausu\')::date)
            AND rh02_regist = rh01_regist
            AND rh02_instit = fc_getsession(\'DB_instit\')::int
            INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
            INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
            WHERE date_part(\'month\',cadferia.r30_per1i::date) = date_part(\'month\',fc_getsession(\'DB_datausu\')::date)
                AND date_part(\'year\',cadferia.r30_per1i::date) = fc_getsession(\'DB_anousu\')::int) AS xxx' where db101_sequencial = 4000108;

        COMMIT;
SQL;
        $this->execute($sql);
    }
}
