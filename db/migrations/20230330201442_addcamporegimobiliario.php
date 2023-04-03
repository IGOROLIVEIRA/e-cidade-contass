<?php

use Phinx\Migration\AbstractMigration;

class Addcamporegimobiliario extends AbstractMigration
{

    public function up()
    {
        $sql = "alter table pcmater add column pc01_regimobiliario text";
        $this->execute($sql);
    }
}
