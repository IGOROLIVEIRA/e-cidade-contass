<?php

use Phinx\Migration\AbstractMigration;

class Oc14755remover extends AbstractMigration
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
        $sql = "
        ALTER TABLE procandamint DROP COLUMN p78_situacao;
        ALTER TABLE procandam DROP COLUMN p61_situacao;
        ALTER TABLE protprocesso DROP COLUMN p58_situacao;
        ";
        $this->execute($sql);
    }
}
