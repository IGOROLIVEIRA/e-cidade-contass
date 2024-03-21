<?php

use Phinx\Migration\AbstractMigration;

class Oc22127 extends AbstractMigration
{

    public function up()
    {
        $sql = <<<SQL
        -- public.afast302024_si201_sequencial_seq definition

        DROP SEQUENCE IF EXISTS public.afast302024_si201_sequencial_seq CASCADE;

        CREATE SEQUENCE public.afast302024_si201_sequencial_seq
            INCREMENT BY 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1;
        
        SQL;

        $this->execute($sql);
    }
}
