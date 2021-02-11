<?php

use Phinx\Migration\AbstractMigration;

class UpdateField extends AbstractMigration
{
    public function change()
    {
        $sql = <<<SQL
  
        BEGIN;
        SELECT fc_startsession();

        ALTER TABLE public.empenhosexcluidos ALTER COLUMN e290_z01_nome TYPE varchar(100) USING e290_z01_nome::varchar;        

        COMMIT;

SQL;
    $this->execute($sql);
    }
}