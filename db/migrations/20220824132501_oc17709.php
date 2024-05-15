<?php

use Phinx\Migration\AbstractMigration;

class Oc17709 extends AbstractMigration
{


    public function up()
    {
        $sql = "update db_itensmenu set descricao = 'Declaração de Frequência',
        help = 'Declaração de Frequência', desctec = 'Declaração de Frequência'
        where descricao = 'Atestado de Frequência';";
        $this->execute($sql);
    }
}
