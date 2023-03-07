<?php

use Phinx\Migration\AbstractMigration;

class FixOc19785 extends AbstractMigration
{
    public function up()
    {
        $sql = "update db_itensmenu set descricao = 'Relatórios', help = 'Relatórios',desctec = 'Relatórios'
        where descricao = 'Relatrios';";
        $this->execute($sql);
    }
}
