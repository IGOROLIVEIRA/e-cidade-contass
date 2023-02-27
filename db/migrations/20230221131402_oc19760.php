<?php

use Phinx\Migration\AbstractMigration;

class Oc19760 extends AbstractMigration
{
    public function up()
    {
        $sqlAddNewColumns = "ALTER TABLE public.ctb102023 DROP COLUMN IF EXISTS si95_tipoaplicacao;
                             ALTER TABLE public.ctb222023 ADD si98_codco varchar(4) DEFAULT '0000';
                             ALTER TABLE public.ctb212023 ADD si97_codidentificafr integer DEFAULT null";
        
        $this->execute($sqlAddNewColumns);
    }
}
