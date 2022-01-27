<?php

use Phinx\Migration\AbstractMigration;

class Oc16493 extends AbstractMigration
{

    public function up()
    {
        $sql = "
        BEGIN;
        
        SELECT fc_startsession();

        ALTER TABLE ralic102022
            ADD COLUMN si180_qtdlotes INTEGER DEFAULT NULL;
        
        ALTER TABLE ralic112022
            ADD COLUMN si181_nrolote INTEGER DEFAULT NULL;

        ALTER TABLE ralic122022
            DROP COLUMN si182_graulatitude,
            DROP COLUMN si182_minutolatitude,
            DROP COLUMN si182_segundolatitude,
            DROP COLUMN si182_graulongitude,
            DROP COLUMN si182_minutolongitude,
            DROP COLUMN si182_segundolongitude;
          
        ALTER TABLE ralic122022 
            ADD COLUMN si182_latitude numeric,
            ADD COLUMN si182_longitude numeric,
            ADD COLUMN si182_nrolote integer,
            ADD COLUMN si182_codbempublico smallint;

        ALTER TABLE redispi102022
            ADD COLUMN si183_link varchar(200);

        ALTER TABLE redispi122022
            DROP COLUMN si185_graulatitude,
            DROP COLUMN si185_minutolatitude,
            DROP COLUMN si185_segundolatitude,
            DROP COLUMN si185_graulongitude,
            DROP COLUMN si185_minutolongitude,
            DROP COLUMN si185_segundolongitude;
                
        ALTER TABLE redispi122022
            ADD COLUMN si185_latitude numeric, 
            ADD COLUMN si185_longitude numeric,
            ADD COLUMN si185_codbempublico integer;


            COMMIT;
        ";

        $this->execute($sql);
    }

    public function down()
    {
        $sql = "
            BEGIN;

            SELECT fc_startsession();

            ALTER TABLE ralic102022
                DROP COLUMN si180_qtdlotes;

            ALTER TABLE ralic112022
                DROP COLUMN si181_nrolote;

            COMMIT;
        ";
        $this->execute($sql);
    }
}
