<?php

use Phinx\Migration\AbstractMigration;

class Oc21964 extends AbstractMigration
{

    public function up()
    {
        $sql = "
            update tipoanexo set l213_descricao='DFD' where l213_sequencial=10;

            insert into tipoanexo values (20,'Ato que autoriza a Contratação Direta');
            insert into tipoanexo values (18,'Relatório Final de Contrato');
            insert into tipoanexo values (19,'Minuta de Ata de Registro de Preços');

        ";
        $this->execute($sql);
    }
}
