<?php

use Phinx\Migration\AbstractMigration;

class Oc10179update extends AbstractMigration
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
        $sql = "update orcparametro set o50_controlafote1017 = 't' where o50_anousu = 2019;
                update orcparametro set o50_controlafote10011006 = 't' where o50_anousu = 2019;
                ";

        $this->execute($sql);

    }

}
