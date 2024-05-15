<?php

use Phinx\Migration\AbstractMigration;

class Oc12764 extends AbstractMigration
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
            BEGIN;
                
                ALTER TABLE db_manut_log ADD COLUMN manut_tabela int8;
                ALTER TABLE db_manut_log ADD COLUMN manut_tipo int8;
                
                INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Consulta Logs (novo)','Consulta Logs (novo)','db_manutlogs.php',1,1,'Consulta Logs (novo)','t');
                INSERT INTO db_menu VALUES(31,(select id_item from db_itensmenu where desctec like'%Consulta Logs (novo)'),9,1);
                
            COMMIT;
        ";
        $this->execute($sql);
    }
}
