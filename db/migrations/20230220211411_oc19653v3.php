<?php

use Phinx\Migration\AbstractMigration;

class Oc19653v3 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
            begin;    

            ALTER TABLE public.orgao112023 ADD si15_numerotelefone int8 NULL;

            ALTER TABLE public.aoc142023 DROP COLUMN si42_nrocontratoop;

            ALTER TABLE public.aoc142023 DROP COLUMN si42_dataassinaturacontratoop;

            ALTER TABLE public.conv112023 DROP COLUMN si93_tipodocumento;

            commit;
SQL;
        $this->execute($sql);
    }
}
