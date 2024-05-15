<?php

use Phinx\Migration\AbstractMigration;

class Oc16572 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
  
        BEGIN;
        SELECT fc_startsession();

        ALTER TABLE ctb202022 ADD COLUMN si96_saldocec int8 NULL DEFAULT 0;

        ALTER TABLE ctb212022 ADD COLUMN si97_saldocec int8 NULL DEFAULT 0;
        ALTER TABLE ctb212022 ADD COLUMN si97_saldocectransf int8 NULL DEFAULT 0;

        ALTER TABLE ctb222022 ADD COLUMN si98_saldocec int8 NULL DEFAULT 0;

        COMMIT;

SQL;
    $this->execute($sql);
    }
}
