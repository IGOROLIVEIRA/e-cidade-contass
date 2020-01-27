<?php

use Phinx\Migration\AbstractMigration;

class Oc11547 extends AbstractMigration
{
    
    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        UPDATE conplanoreduz t1
        SET c61_codigo = 159
        FROM conplanoreduz t2
        JOIN conaberturaexe ON (c91_instit, c91_anousudestino) = (t2.c61_instit, t2.c61_anousu)
        WHERE c91_anousudestino >= 2020
          AND t1.c61_codigo IN (148, 149, 150, 151, 152)
          AND (t1.c61_reduz, t1.c61_anousu) = (t2.c61_reduz, t2.c61_anousu);

        COMMIT;
        
SQL;
    
        $this->execute($sql);

    }
}
