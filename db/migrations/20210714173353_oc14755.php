<?php

use Phinx\Migration\AbstractMigration;

class Oc14755 extends AbstractMigration
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
        $sSql = "
        ALTER TABLE procandamint ADD COLUMN p78_situacao integer;
        ALTER TABLE procandam ADD COLUMN p61_situacao integer;
        ALTER TABLE protprocesso ADD COLUMN p58_situacao integer;        
        ";
        $this->execute($sSql);
    }
}
