<?php

use Phinx\Migration\AbstractMigration;

class Addcampopcmater extends AbstractMigration
{

    public function up()
    {
        $sql = "
            ALTER TABLE pcmater ADD COLUMN pc01_codmaterant int4;
        ";
        $this->execute($sql);
    }
}
