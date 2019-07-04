<?php

use Phinx\Migration\AbstractMigration;

class NoTeskAddMenuCopiaOrcamento extends AbstractMigration
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
update configuracoes.db_itensmenu set libcliente=true where id_item=4706;
update configuracoes.db_itensmenu set libcliente=true where id_item=5605;
update configuracoes.db_itensmenu set libcliente=true where id_item=5608;
SQL;
        $this->execute($sql);
    }
    public function down(){
        $sql = <<<SQL

update configuracoes.db_itensmenu set libcliente=false where id_item=4706;
update configuracoes.db_itensmenu set libcliente=false where id_item=5605;
update configuracoes.db_itensmenu set libcliente=false where id_item=5608;
SQL;
        $this->execute($sql);
    }
}
