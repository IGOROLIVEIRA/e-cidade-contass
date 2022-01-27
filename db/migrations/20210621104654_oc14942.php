<?php

use Phinx\Migration\AbstractMigration;

class Oc14942 extends AbstractMigration
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
            INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Notificação de Férias','Notificação de Férias','pes2_notficacaodeferias001.php',1,1,'Notificação de Férias','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Férias%' and desctec = '' and help= ''),(select max(id_item) from db_itensmenu),6,952);
        ";
        $this->execute($sql);
    }
}
