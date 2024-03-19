<?php

use Phinx\Migration\AbstractMigration;

class Oc212398Menu extends AbstractMigration
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

            INSERT INTO db_itensmenu
            VALUES (
                        (SELECT max(id_item)+1
                         FROM db_itensmenu),'Fornecedores',
                                            'Fornecedores',
                                            'com2_pcfornecedores001.php',
                                            1,
                                            1,
                                            'Fornecedores',
                                            't');


            INSERT INTO db_menu
            VALUES(9646,
                       (SELECT max(id_item)
                        FROM db_itensmenu),5,
                                           28);


        COMMIT;
        ";
        $this->execute($sql);
    }
}
