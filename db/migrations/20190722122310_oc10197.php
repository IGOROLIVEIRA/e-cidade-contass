<?php

use Phinx\Migration\AbstractMigration;

class Oc10197 extends AbstractMigration
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
        $sql = "alter table orcparametro add column o50_controlafote1017 boolean;
                alter table orcparametro add column o50_controlafote10011006 boolean;";

     $this->execute($sql);

    }

    public function down()
    {
     $sql = "alter table orcparametro drop column o50_controlafote1017;
             alter table orcparametro drop column o50_controlafote10011006;";
     $this->execute($sql);
    }
}
