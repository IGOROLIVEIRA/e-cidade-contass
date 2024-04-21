<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc10215 extends PostgresMigration
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

    public function up(){

      $arc21 = $this->table('arc212019');
      $arcMes = $arc21->hasColumn('si32_mes');

      if(!$arcMes){
        $arc21->addColumn('si32_mes', 'biginteger', array('null' => false))->save();
      }
      $this->execute('ALTER TABLE arc212019 ALTER COLUMN si32_tipodocumento SET DEFAULT NULL;');
      $this->execute('ALTER TABLE arc202019 ALTER COLUMN si31_identificadordeducao SET DEFAULT NULL;');

    }

    public function down(){

      $arc21 = $this->table('arc212019');
      $arcMes = $arc21->hasColumn('si32_mes');
      if($arcMes){
        $arc21->removeColumn('si32_mes')->save();
      }
      $this->execute('ALTER TABLE arc212019 ALTER COLUMN si32_tipodocumento SET DEFAULT NOT NULL;');
      $this->execute('ALTER TABLE arc202019 ALTER COLUMN si31_identificadordeducao SET DEFAULT NOT NULL;');

    }
}
