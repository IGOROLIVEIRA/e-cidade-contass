<?php

use Phinx\Migration\AbstractMigration;

class Oc13567 extends AbstractMigration
{
    public function up()
    {
      $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        CREATE OR REPLACE FUNCTION public.fc_acerta_tipo_rp(integer)
        RETURNS boolean
        LANGUAGE plpgsql
        AS $$
        DECLARE

          rp_anousu alias for $1;

            BEGIN

            CREATE TEMP TABLE acerto_rp ON COMMIT DROP AS
            SELECT DISTINCT ON (e60_numemp) e60_numemp,
                   c60_estrut
            FROM empresto
            LEFT JOIN empempenho ON e91_numemp = e60_numemp
            LEFT JOIN empelemento ON e64_numemp = e60_numemp
            JOIN orcelemento ON o56_codele = e64_codele
            JOIN conplanoorcamento ON substr(c60_estrut,1,7)= substr(o56_elemento,1,7)
            LEFT JOIN cgm ON e60_numcgm = z01_numcgm
            WHERE e91_anousu = rp_anousu
            GROUP BY e60_anousu, empempenho.e60_numemp, cgm.z01_nome, conplanoorcamento.c60_estrut,
                     empresto.e91_elemento, empresto.e91_codtipo, o56_elemento
            ORDER BY e60_numemp, c60_estrut;

            UPDATE empresto
            SET e91_elemento = 213110101,
                e91_codtipo = 1
            WHERE e91_numemp IN
                    (SELECT e60_numemp FROM acerto_rp
                     WHERE substr(c60_estrut,1,5) IN ('33290', '33390', '34490'))
              AND e91_anousu = rp_anousu;

            UPDATE empresto
            SET e91_elemento = 211110101,
                e91_codtipo = 2
            WHERE e91_numemp IN
                    (SELECT e60_numemp FROM acerto_rp
                     WHERE substr(c60_estrut,1,7) IN ('3319092', '3319004', '3319011', '3319091', '3319003', '3319001'))
              AND e91_anousu = rp_anousu;

            UPDATE empresto
            SET e91_elemento = 211430101,
                e91_codtipo = 3
            WHERE e91_numemp IN
                    (SELECT e60_numemp FROM acerto_rp
                     WHERE substr(c60_estrut,1,7) = '3319013')
              AND e91_anousu = rp_anousu;

            UPDATE empresto
            SET e91_elemento = 211420101,
                e91_codtipo = 4
            WHERE e91_numemp IN
                    (SELECT e60_numemp FROM acerto_rp
                     WHERE substr(c60_estrut,1,7) = '3319113')
              AND e91_anousu = rp_anousu;

            UPDATE empresto
            SET e91_elemento = 218911400,
                e91_codtipo = 7
            WHERE e91_numemp IN
                    (SELECT e60_numemp FROM acerto_rp
                     WHERE substr(c60_estrut,1,7) IN ('3317170', '3327170', '3317170', '3447170', '3467170'))
              AND e91_anousu = rp_anousu;

            return true;

            END;

          $$;

        COMMIT;

SQL;
      $this->execute($sql);
    }
}
