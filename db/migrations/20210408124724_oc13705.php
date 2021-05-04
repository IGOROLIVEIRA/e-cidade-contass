<?php

use Phinx\Migration\AbstractMigration;

class Oc13705 extends AbstractMigration
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
        
          UPDATE db_syscampo SET rotulo = 'Sequencial no processo' WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'pc81_codprocitem');
        
          DELETE FROM db_itensmenu WHERE id_item = (SELECT id_item FROM db_itensmenu WHERE funcao = 'obr1_licitemobra002.php');
        
          DELETE FROM db_itensmenu WHERE id_item = (SELECT id_item FROM db_itensmenu WHERE funcao = 'obr1_licitemobra003.php');
        
        COMMIT;
SQL;
        $this->execute($sql);

    }
}
