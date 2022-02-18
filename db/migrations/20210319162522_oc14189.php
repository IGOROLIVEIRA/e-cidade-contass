<?php

use Phinx\Migration\AbstractMigration;

class Oc14189 extends AbstractMigration
{
    public function up(){
        $sql = "
            BEGIN;

            SELECT fc_startsession();
            
            ALTER TABLE solicitem ADD COLUMN pc11_reservado BOOLEAN DEFAULT NULL;
            ALTER TABLE liclicitem add column l21_reservado BOOLEAN DEFAULT NULL;
            
            COMMIT;
        ";
        $this->execute($sql);
    }

    public function down(){
        $sql = "
            BEGIN;

            SELECT fc_startsession();
            
            ALTER TABLE solicitem DROP COLUMN pc11_reservado;
            ALTER TABLE liclicitem DROP COLUMN l21_reservado;
            
            COMMIT;
        ";
        $this->execute($sql);
    }
}
