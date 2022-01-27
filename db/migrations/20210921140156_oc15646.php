<?php

use Phinx\Migration\AbstractMigration;

class Oc15646 extends AbstractMigration
{
    
    public function up()
    {
        $this->execute("ALTER TABLE selecao ALTER COLUMN r44_where TYPE text");
    }

    public function down()
    {
        $this->execute("ALTER TABLE selecao ALTER COLUMN r44_where TYPE varchar(400)");
    }
}
