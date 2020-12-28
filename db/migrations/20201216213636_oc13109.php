<?php

use Classes\PostgresMigration;

class Oc13109 extends PostgresMigration
{
    public function up()
    {
        $sql = <<<SQL
  
        BEGIN;
        SELECT fc_startsession();

        INSERT INTO conlancamord (c80_codlan, c80_codord, c80_data)
            SELECT c71_codlan, e50_codord, c71_data FROM
                (SELECT DISTINCT ON (c70_valor, c71_codlan) c71_codlan, e50_codord, c71_data, c70_valor, e60_numemp 
                    FROM empempenho
                        JOIN pagordem ON e50_numemp = e60_numemp
                        JOIN conlancamemp ON c75_numemp = e60_numemp
                        JOIN conlancamdoc ON c71_codlan = c75_codlan
                        JOIN conlancam ON c70_codlan = c71_codlan
                    WHERE c71_coddoc IN (206, 207)
                        AND c71_codlan NOT IN (SELECT c80_codlan FROM conlancamord)
                        AND e60_anousu = 2020) AS x;

        COMMIT;

SQL;
    $this->execute($sql);
  }

}