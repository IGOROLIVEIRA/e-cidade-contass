<?php

use Phinx\Migration\AbstractMigration;

class Oc19890 extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE bpdcasp712022 ADD column si215_codfontrecursos23 int4 NOT NULL DEFAULT 0");
    }
}
