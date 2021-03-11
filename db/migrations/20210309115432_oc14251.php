<?php

use Phinx\Migration\AbstractMigration;

class Oc14251 extends AbstractMigration
{
    public function change(){
        $sSql = "
            
            BEGIN;

            SELECT fc_startsession();
        
            DELETE FROM pccfeditalnum;
            
            ALTER TABLE pccfeditalnum ADD COLUMN l47_timestamp TIMESTAMP;
            
            CREATE TEMP TABLE dadosEdital(
                sequencial serial, nroedital integer NOT NULL,
                exercicio integer NOT NULL,
                instit integer NOT NULL,
                datacriacao timestamp
            );
            
            INSERT INTO dadosEdital(nroedital, exercicio, instit, datacriacao)
                (SELECT l20_nroedital,
                        l20_exercicioedital,
                        l20_instit,
                        to_timestamp(l20_datacria::varchar||' '||l20_horacria::varchar, 'YYYY-MM-DD HH24:MI') as data
                 FROM liclicita
                 WHERE l20_nroedital IS NOT NULL
                 ORDER BY l20_exercicioedital, l20_nroedital asc);
            
            CREATE OR REPLACE FUNCTION getAllDatas() RETURNS
            SETOF dadosEdital AS $$
                                            DECLARE
                                                r dadosEdital%rowtype;
                                            BEGIN
                                                FOR r IN SELECT * FROM dadosEdital
                                                LOOP
            
                                                    insert into pccfeditalnum(l47_numero, l47_anousu, l47_instit, l47_timestamp)
                                                        values(r.nroedital, r.exercicio, r.instit, r.datacriacao);
            
            
                                                    RETURN NEXT r;
            
                                                END LOOP;
                                                RETURN;
                                            END
                                            $$ LANGUAGE plpgsql;
            
            
            SELECT *
            FROM getAllDatas();
            
            DROP FUNCTION getAllDatas();
        
            COMMIT;
        ";

        $this->execute($sSql);
    }


}
