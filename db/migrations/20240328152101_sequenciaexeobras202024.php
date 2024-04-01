<?php

use Phinx\Migration\AbstractMigration;

class Sequenciaexeobras202024 extends AbstractMigration
{

    public function up()
    {
        $sql = "
            DROP SEQUENCE IF EXISTS exeobras202024_si204_sequencial_seq;

            CREATE SEQUENCE exeobras202024_si204_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;
        ";
        $this->execute($sql);
    }
}
