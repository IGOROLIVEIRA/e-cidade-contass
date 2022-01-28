<?php

use Phinx\Migration\AbstractMigration;

class SequenceMetareal extends AbstractMigration
{
    public function up()
    {
        $sql = "CREATE SEQUENCE public.metareal102021_si171_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1;";
        $this->execute($sql);
        $sql = "CREATE SEQUENCE public.metareal102022_si171_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1;";

        $this->execute($sql);
    }

    public function down()
    {
        $sql = "drop sequence public.metareal102021_si171_sequencial_seq;
                drop sequence public.metareal102022_si171_sequencial_seq;
               ";

        $this->execute($sql);
    }
}
