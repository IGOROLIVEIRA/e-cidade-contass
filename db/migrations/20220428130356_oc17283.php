<?php

use Phinx\Migration\AbstractMigration;

class Oc17283 extends AbstractMigration
{
    public function up()
    {
        $sql = "begin;
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu),'Empenhos vagos' ,'Empenhos vagos' ,'emp2_empvagos001.php' ,'1' ,'1' ,'' ,'true' );
        INSERT INTO db_menu VALUES (5603, (SELECT id_item FROM db_itensmenu WHERE descricao = 'Empenhos vagos' LIMIT 1), (SELECT max(menusequencia)+1 FROM db_menu WHERE id_item = 5603), 398);
        commit;
        ";

        $this->execute($sql);
    }
}
