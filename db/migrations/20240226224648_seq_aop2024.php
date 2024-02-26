<?php

use Phinx\Migration\AbstractMigration;

class SeqAop2024 extends AbstractMigration
{
    public function up()
    {
        $sqlSequence = "DROP SEQUENCE IF EXISTS public.aop122024_si139_sequencial_seq CASCADE;
        
                        create sequence public.aop122024_si139_sequencial_seq
                        increment 1
                        minvalue 1
                        maxvalue 9223372036854775807
                        start 1
                        cache 1;
        
                        DROP SEQUENCE IF EXISTS public.aop132024_si140_sequencial_seq CASCADE;
                            
                        create sequence public.aop132024_si140_sequencial_seq
                        increment 1
                        minvalue 1
                        maxvalue 9223372036854775807
                        start 1
                        cache 1";

        $this->execute($sqlSequence);
    }
}
