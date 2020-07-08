<?php

use Phinx\Migration\AbstractMigration;

class Oc12615 extends AbstractMigration
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
        $sql = "BEGIN;

                UPDATE db_syscampo
                SET descricao = 'Codigo da Licitação'
                WHERE codcam IN
                        (SELECT codcam
                         FROM db_syscampo
                         WHERE descricao LIKE 'Processo Licitatório%'
                             AND nomecam LIKE '%obr01_licitacao%');
                COMMIT;";

        $this->execute($sql);
    }
}
