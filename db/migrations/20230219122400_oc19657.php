<?php

use Phinx\Migration\AbstractMigration;

class Oc19657 extends AbstractMigration
{
    public function up()
    {
        $sql = "
            ALTER TABLE public.lqd112023 ADD COLUMN si119_codco varchar(4) DEFAULT '0000';
            ALTER TABLE public.alq112023 ADD COLUMN si122_codco varchar(4) DEFAULT '0000';
            ALTER TABLE public.ops112023 ADD COLUMN si133_codco varchar(4) DEFAULT '0000';
            ALTER TABLE public.arc212023 ADD COLUMN si32_codigocontroleorcamentario varchar(4) DEFAULT '0000';
        ";
        
        $this->execute($sql);
    }
}
