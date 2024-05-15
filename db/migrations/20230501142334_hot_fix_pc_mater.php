<?php

use Phinx\Migration\AbstractMigration;

class HotFixPcMater extends AbstractMigration
{
    public function up()
    {
        $this->execute("update pcmater set pc01_codmaterant=null where pc01_codmaterant = 0");
    }
}
