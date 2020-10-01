<?php

use Phinx\Migration\AbstractMigration;

class Oc13175 extends AbstractMigration
{
    public function up()
    {
        $this->alterDescription();
    }

    private function alterDescription(){

        $sql = <<<SQL

        BEGIN;


        CREATE TEMP TABLE altera_despesa ON COMMIT DROP AS
        SELECT c60_codcon, c60_anousu, c60_estrut, c60_descr, c60_finali FROM conplanoorcamento
        WHERE c60_anousu >= 2021
          AND (substr(c60_estrut,1,9) IN ('331900500', '331900501', '331900502', '331900503') OR substr(c60_estrut,1,7) IN('3339005', '3339009', '3339013'))
        ORDER BY c60_estrut;

        UPDATE conplanoorcamento
        SET c60_descr = (CASE
                            WHEN substr(c60_estrut,1,7) IN ('3339005', '3339009', '3339013') THEN 'DESATIVADO 2017'
                            ELSE 'DESATIVADO 2021'
                        END),
            c60_finali = (CASE
                            WHEN substr(c60_estrut,1,7) IN ('3339005',  '3339009',  '3339013') THEN 'DESATIVADO 2017'
                            ELSE 'DESATIVADO 2021'
                        END)
        WHERE c60_anousu >= 2021
          AND (substr(c60_estrut,1,9) IN ('331900500', '331900501', '331900502', '331900503') OR substr(c60_estrut,1,7) IN('3339005', '3339009', '3339013'));

        UPDATE orcelemento
        SET o56_descr = (CASE
                            WHEN substr(o56_elemento,1,7) IN ('3339005', '3339009', '3339013') THEN 'DESATIVADO 2017'
                            ELSE 'DESATIVADO 2021'
                        END),
            o56_finali = (CASE
                            WHEN substr(o56_elemento,1,7) IN ('3339005',  '3339009',  '3339013') THEN 'DESATIVADO 2017'
                            ELSE 'DESATIVADO 2021'
                        END)
        WHERE o56_anousu >= 2021
          AND o56_elemento IN (SELECT substr(c60_estrut,1,13) FROM altera_despesa);

        DELETE FROM conplanoconplanoorcamento
        WHERE c72_anousu >= 2021
          AND c72_conplanoorcamento IN (SELECT c60_codcon FROM altera_despesa);

        COMMIT;

SQL;

        $this->execute($sql);
    }
}
