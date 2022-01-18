<?php

use Phinx\Migration\AbstractMigration;

class Oc16164 extends AbstractMigration
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
        $sql = utf8_encode('
            select fc_startsession();
            BEGIN;
                INSERT INTO db_itensmenu VALUES ((SELECT MAX(id_item) + 1 FROM db_itensmenu), \'Extratos Bancarios Sicom\', \'Extratos Bancarios Sicom\', 
                    \'cai4_extratobancariosicom001.php\', 1, 1, \'Extratos Bancarios Sicom\', \'t\');
             
                INSERT INTO db_menu VALUES (32, (SELECT MAX(id_item) FROM db_itensmenu), 465, 39);
                
                INSERT INTO db_itensmenu VALUES ((SELECT MAX(id_item) + 1 FROM db_itensmenu), \'Extratos Bancarios\', \'\', \'con4_gerarextratobancario.php\',
                    1, 1, \'\', \'t\');
             
                INSERT INTO db_menu VALUES (8987, (SELECT MAX(id_item) FROM db_itensmenu), 10, 2000018);            
            COMMIT; 
        ');

        $this->execute($sql);
    }

    public function down() {}
}
