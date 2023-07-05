<?php

use Phinx\Migration\AbstractMigration;

class Oc19724 extends AbstractMigration
{
    public function up()
    {
        $sqlAddNewColumns = "ALTER TABLE public.rsp112023 ADD si113_codco varchar NOT NULL; 
                             ALTER TABLE public.rsp212023 ADD si116_codco varchar NOT NULL;
                             ALTER TABLE public.rsp212023 ADD si116_codidentificafr integer";
        
        $this->execute($sqlAddNewColumns);

    }
}
