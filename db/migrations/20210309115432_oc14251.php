<?php

use Phinx\Migration\AbstractMigration;

class Oc14251 extends AbstractMigration
{
    public function change(){
        $sSql = "
            
            BEGIN;

            SELECT fc_startsession();
        
                DELETE from pccfeditalnum;
            
                CREATE TEMP TABLE dadosEdital( sequencial serial, 
                                            nroedital integer NOT NULL,
                                            exercicio integer NOT NULL,
                                            instit integer NOT NULL);
            
                INSERT INTO dadosEdital(nroedital, exercicio, instit)
                    (SELECT l20_nroedital,
                            l20_exercicioedital,
                            l20_instit
                    FROM liclicita
                    WHERE l20_nroedital IS NOT NULL
                    ORDER BY l20_exercicioedital);
            
            
                CREATE OR REPLACE FUNCTION getAllDatas() RETURNS
                SETOF dadosEdital AS $$
                                DECLARE
                                    r dadosEdital%rowtype;
                                BEGIN
                                    FOR r IN SELECT * FROM dadosEdital
                                    LOOP
                
                                        insert into pccfeditalnum(l47_numero, l47_anousu, l47_instit) 
                                            values(r.nroedital, r.exercicio, r.instit);
                                        
                
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
