<?php

use Phinx\Migration\AbstractMigration;

class CreateSeqProcessoLote extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE processocompraloteitem ADD pc69_seq int8 NULL");
        $this->execute("ALTER TABLE liclicitemlote ADD L04_seq int8 NULL");
        $this->execute("ALTER TABLE processocompralote ALTER COLUMN pc68_nome TYPE varchar(250) USING pc68_nome::varchar");
        $this->execute("ALTER TABLE liclicitemlote ALTER COLUMN l04_descricao TYPE varchar(250) USING l04_descricao::varchar");
    }
}
