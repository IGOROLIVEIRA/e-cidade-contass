<?php

use Phinx\Migration\AbstractMigration;

class Oc15807 extends AbstractMigration
{
    public function up()
    {

        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        CREATE TEMP TABLE exclui_reduz ON COMMIT DROP AS
        SELECT codigo_conta,
            estrut_total,
            nivel_estrut,
            upper(tipo) AS tipo,
            c61_reduz AS reduzido,
            c61_anousu AS anousu,
            ppa,
            CASE
                WHEN tipo = 'SINTETICA'
                        AND c61_reduz IS NOT NULL THEN 'Verificar essa conta'
                ELSE ''
            END AS status_conta
        FROM
            (SELECT c60_codcon AS codigo_conta,
                    t1.c60_estrut AS estrut_total,
                    rtrim(t1.c60_estrut,'0') AS nivel_estrut,
                    CASE
                        WHEN
                            (SELECT count(*) FROM conplanoorcamento t2
                            WHERE substr(t1.c60_estrut,1,length(rtrim(t1.c60_estrut,'0'))) = substr(t2.c60_estrut,1,length(rtrim(t1.c60_estrut,'0')))
                                AND t2.c60_anousu = 2022) > 1 THEN 'SINTETICA'
                        ELSE 'ANALITICA'
                    END AS tipo,
                    CASE
                        WHEN o06_sequencial IS NULL THEN 'NAO'
                        ELSE 'SIM'
                    END ppa,
                    c61_reduz,
                    c61_anousu
             FROM conplanoorcamento t1
             LEFT JOIN conplanoorcamentoanalitica ON (c61_codcon, c61_anousu) = (c60_codcon, c60_anousu)
             LEFT JOIN orcfontes ON (o57_fonte, o57_anousu) = (c60_estrut, c60_anousu)
             LEFT JOIN ppaestimativareceita ON (o06_codrec, o06_anousu) = (o57_codfon, o57_anousu)
             WHERE t1.c60_anousu >= 2022
               AND substr(t1.c60_estrut,1,1) = '4'
             ORDER BY t1.c60_estrut, t1.c60_anousu) AS x;

        DELETE FROM conplanoorcamentoanalitica
        USING exclui_reduz
        WHERE c61_reduz = reduzido
          AND c61_anousu = anousu
          AND status_conta = 'Verificar essa conta'
          AND ppa = 'NAO';

        DELETE FROM orcfontes
        USING exclui_reduz
        WHERE o57_fonte = estrut_total
          AND o57_anousu = anousu
          AND status_conta = 'Verificar essa conta'
          AND ppa = 'NAO';

        COMMIT;

SQL;
        $this->execute($sql);

    }
}
