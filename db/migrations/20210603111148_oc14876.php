<?php

use Phinx\Migration\AbstractMigration;

class Oc14876 extends AbstractMigration
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
              INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Certidão de Tempo de Serviço','Certidão de Tempo de Serviço','pes2_gerarcertidaotempo001.php',1,1,'Certidão de Tempo de Serviço','t');
              INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Cadastrais 2%'),(select max(id_item) from db_itensmenu),5,952);
        ";
        $this->execute($sql);
    }
}
