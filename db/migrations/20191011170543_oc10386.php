<?php

use Phinx\Migration\AbstractMigration;

class Oc10386 extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $sql = "update acordonatureza set ac01_descricao = 'Obras e Serviços de Engenharia' where ac01_sequencial = 1;
                update acordonatureza set ac01_descricao = 'Compras e serviços' where ac01_sequencial = 2;
                update acordonatureza set ac01_descricao = 'Locação' where ac01_sequencial = 3;
                update acordonatureza set ac01_descricao = 'Concessão' where ac01_sequencial = 4;
                update acordonatureza set ac01_descricao = 'Permissão' where ac01_sequencial = 5;
                
                update acordogrupo set ac02_acordonatureza = 4 where ac02_descricao like '%CONCESS%';
                update acordogrupo set ac02_acordonatureza = 3 where ac02_descricao like '%ALUGUEL/LOCA%';
                update acordogrupo set ac02_acordonatureza = 2 where ac02_acordonatureza in(1,2);
                update acordogrupo set ac02_acordonatureza = 1 where ac02_acordonatureza = 6;
                
                delete from acordogruponumeracao where ac03_acordogrupo in(select ac02_sequencial from acordogrupo where ac02_descricao like '%EMPRESTIMO%');
                delete from acordogrupo where ac02_descricao like '%EMPRESTIMO%';
                
                delete from acordogruponumeracao where ac03_acordogrupo in(select ac02_sequencial from acordogrupo where ac02_descricao like '%DESAPROPRIA%');
                delete from acordogrupo where ac02_descricao like '%DESAPROPRIA%';";

        $this->execute($sql);
    }
}
