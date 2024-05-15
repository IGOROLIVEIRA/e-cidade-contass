<?php

use Phinx\Migration\AbstractMigration;

class CreateSeqProcessoLote extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE processocompraloteitem ADD pc69_seq int8 NULL");
        $this->execute("ALTER TABLE liclicitemlote ADD L04_seq int8 NULL");
    }
}
