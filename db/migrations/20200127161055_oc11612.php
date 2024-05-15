<?php

use Phinx\Migration\AbstractMigration;

class Oc11612 extends AbstractMigration
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
        $sql = <<<SQL
        
        BEGIN;
        SELECT fc_startsession();
        
        alter table projecaoatuarial10 alter column si168_vlreceitaprevidenciaria type DOUBLE PRECISION;
        alter table projecaoatuarial10 alter column si168_vldespesaprevidenciaria type DOUBLE PRECISION;
        
        COMMIT;
        
SQL;
        $this->execute($sql);
    }
}
