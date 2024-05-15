<?php

use Phinx\Migration\AbstractMigration;

class Oc12852 extends AbstractMigration
{

    public function up()
    {
        $sql = <<<SQL
          SELECT fc_startsession();
            BEGIN;
            
            SELECT fc_startsession();
            ALTER TABLE historicocgm ADD column z09_tipo int;
            
            CREATE TEMP TABLE historicodoscgm( sequencial SERIAL, seqhistoricocgm bigint, cgm bigint);
            
            INSERT INTO historicodoscgm(seqhistoricocgm,cgm)
                (SELECT MAX (z09_sequencial), z09_numcgm
                 FROM historicocgm
                 GROUP BY z09_numcgm);
            
            CREATE OR REPLACE FUNCTION setArquivo() RETURNS
            SETOF historicodoscgm AS $$
            DECLARE
                r historicodoscgm%rowtype;
            BEGIN
                FOR r IN SELECT * FROM historicodoscgm
                LOOP
            
                    UPDATE historicocgm SET z09_tipo = 1 WHERE z09_sequencial = r.seqhistoricocgm;
            
                    RETURN NEXT r;
            
                END LOOP;
                RETURN;
            END
            $$ LANGUAGE plpgsql;
            
            SELECT *
            FROM setArquivo();
            DROP FUNCTION setArquivo();
            ROLLBACK;
            
            COMMIT;
SQL;
        $this->execute($sql);
    }
}
