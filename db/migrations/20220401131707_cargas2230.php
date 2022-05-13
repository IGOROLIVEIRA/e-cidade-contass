<?php

use Phinx\Migration\AbstractMigration;

class Cargas2230 extends AbstractMigration
{

    public function up()
    {
        $sql = <<<SQL
        BEGIN;

            update avaliacao set db101_cargadados = ' SELECT cgm.z01_cgccpf AS cpftrab,
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
            LEFT JOIN rhpessoalmov ON rh02_anousu = fc_getsession(\'DB_instit\')::int
            AND rh02_mesusu = date_part(\'month\',fc_getsession(\'DB_datausu\')::date)
            AND rh02_regist = rh01_regist
            AND rh02_instit = fc_getsession(\'DB_instit\')::int
            INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
            INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
            WHERE date_part(\'month\',afasta.r45_dtafas::date) = date_part(\'month\',fc_getsession(\'DB_datausu\')::date)
                AND date_part(\'year\',afasta.r45_dtafas::date) = fc_getsession(\'DB_instit\')::int
            UNION
            SELECT cgm.z01_cgccpf AS cpftrab,
                rhpessoal.rh01_regist AS matricula,
                tpcontra.h13_categoria AS codcateg,
                NULL AS dtiniafast,
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
            LEFT JOIN rhpessoalmov ON rh02_anousu = fc_getsession(\'DB_instit\')::int
            AND rh02_mesusu = date_part(\'month\',fc_getsession(\'DB_datausu\')::date)
            AND rh02_regist = rh01_regist
            AND rh02_instit = fc_getsession(\'DB_instit\')::int
            INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
            INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
            WHERE date_part(\'month\',cadferia.r30_perai::date) = date_part(\'month\',fc_getsession(\'DB_datausu\')::date)
                AND date_part(\'year\',cadferia.r30_perai::date) = fc_getsession(\'DB_instit\')::int' where db101_sequencial = 4000108;

            UPDATE avaliacaopergunta
            SET db103_camposql = LOWER(db103_identificadorcampo)
            WHERE db103_avaliacaogrupopergunta = 4000259;

            UPDATE avaliacaopergunta
            SET db103_camposql = LOWER(db103_identificadorcampo)
            WHERE db103_avaliacaogrupopergunta = 4000260;

            UPDATE avaliacaopergunta
            SET db103_camposql = LOWER(db103_identificadorcampo)
            WHERE db103_avaliacaogrupopergunta = 4000261;

            UPDATE avaliacaopergunta
            SET db103_camposql = LOWER(db103_identificadorcampo)
            WHERE db103_avaliacaogrupopergunta = 4000262;

            UPDATE avaliacaopergunta
            SET db103_camposql = LOWER(db103_identificadorcampo)
            WHERE db103_avaliacaogrupopergunta = 4000264;

            UPDATE avaliacaopergunta
            SET db103_camposql = LOWER(db103_identificadorcampo)
            WHERE db103_avaliacaogrupopergunta = 4000266;

            
            UPDATE db_itensmenu
            SET funcao = 'con4_manutencaoformulario001.php?esocial=40'
            WHERE descricao LIKE '%S-2230%';

            UPDATE avaliacaopergunta
            SET db103_avaliacaotiporesposta = 2
            WHERE db103_sequencial = 4000849;

            DELETE
            FROM avaliacaoperguntaopcao
            WHERE db104_avaliacaopergunta = 4000849;

            UPDATE avaliacaopergunta
            SET db103_avaliacaotiporesposta = 2
            WHERE db103_sequencial = 4000847;
            
            DELETE
            FROM avaliacaoperguntaopcao
            WHERE db104_avaliacaopergunta = 4000847;
                                  
        COMMIT;
SQL;
        $this->execute($sql);
    }
}
