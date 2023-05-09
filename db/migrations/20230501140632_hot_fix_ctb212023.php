<?php

use Phinx\Migration\AbstractMigration;

class HotFixCtb212023 extends AbstractMigration
{
    public function up()
    {

    $sql = <<<SQL

    BEGIN;

    SELECT fc_startsession();


    ALTER TABLE ctb212023  ALTER COLUMN si97_codctb TYPE VARCHAR(255);
    ALTER TABLE ctb212023  ALTER COLUMN si97_codreduzidomov TYPE VARCHAR(255);

    COMMIT;

SQL;
        $this->execute($sql);
    }
}
