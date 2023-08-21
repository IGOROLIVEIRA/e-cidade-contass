<?php

use Phinx\Migration\AbstractMigration;

class Oc20631 extends AbstractMigration
{
    public function up()
    {
        $sql = "update acordoposicaotipo set ac27_descricao='Acréscimo/Decréscimo de item(ns) conjugado' where ac27_sequencial=14";
        $this->execute($sql);
    }
}
