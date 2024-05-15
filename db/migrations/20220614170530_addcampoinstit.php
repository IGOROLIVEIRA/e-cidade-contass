<?php

use Phinx\Migration\AbstractMigration;

class Addcampoinstit extends AbstractMigration
{
    public function up()
    {
        $sql = "
            ALTER TABLE pcgrupo ADD COLUMN pc03_instit int4;
            ALTER TABLE pctipo ADD COLUMN pc05_instit int4;
            ALTER TABLE pcsubgrupo ADD COLUMN pc04_instit int4;

            UPDATE pcgrupo SET pc03_instit = 0;
            UPDATE pctipo SET pc05_instit = 0;
            UPDATE pcsubgrupo SET pc04_instit = 0;
        ";
        $this->execute($sql);
    }
}
