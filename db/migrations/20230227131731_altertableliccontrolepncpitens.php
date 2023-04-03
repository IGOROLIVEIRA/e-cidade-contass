<?php

use Phinx\Migration\AbstractMigration;

class Altertableliccontrolepncpitens extends AbstractMigration
{

    public function up()
    {
        $sql = "
        alter table liccontrolepncpitens add column l214_pcproc int8;
        alter table liccontrolepncpitens alter COLUMN l214_licitacao drop not null;
        ";
        $this->execute($sql);
    }
}
