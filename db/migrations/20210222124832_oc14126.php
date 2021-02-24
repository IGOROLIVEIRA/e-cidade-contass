<?php

use Phinx\Migration\AbstractMigration;

class Oc14126 extends AbstractMigration
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
        begin;

        select fc_startsession();

        update db_itensmenu set descricao = 'Documentos DCASP Consolidado' where id_item = 3000100;

        insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Documentos DCASP Isolado','Documentos DCASP Isolado','con4_gerarpcaiso.php',1,1,'','t');
        
        insert into db_menu values (8987,(select max(id_item) from db_itensmenu),5,2000018);
        
        commit;
SQL;

        $this->execute($sql);
    }
}
