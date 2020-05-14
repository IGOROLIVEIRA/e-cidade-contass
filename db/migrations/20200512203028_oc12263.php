<?php

use Phinx\Migration\AbstractMigration;

class Oc12263 extends AbstractMigration
{
    
    public function up()
    {
        $sql = "alter table aoc122020 alter column si40_dataleialteracao drop not null;
        alter table aoc122020 alter column si40_tipoleialteracao drop not null;
        alter table aoc122020 alter column si40_valorabertolei drop not null;";
        $this->execute($sql);

    }
}
