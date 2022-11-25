<?php

use Phinx\Migration\AbstractMigration;

class Oc18994 extends AbstractMigration
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
                INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'pc30_liboccontrato', 'bool', 'Liberar', '0', 'Liberar', 1, false, false, true, 1, 'bool', 'Liberar');
                ALTER TABLE pcparam ADD COLUMN pc30_liboccontrato bool DEFAULT FALSE;
                UPDATE pcparam SET pc30_liboccontrato=FALSE;
            COMMIT;
      ";
        $this->execute($sql);
    }
}
