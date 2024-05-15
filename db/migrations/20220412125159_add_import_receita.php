<?php

use Phinx\Migration\AbstractMigration;

class AddImportReceita extends AbstractMigration
{

    public function up()
    {
        $sql = "INSERT INTO db_itensmenu
        VALUES ((SELECT MAX(id_item)+1 FROM db_itensmenu),
            'Importar Nomes Receita',
            'Importar Nomes Receita',
            'pes1_importarnomereceita001.php',
            1,
            1,
            'Importar Nomes Receita',
            't');

        INSERT INTO db_menu 
        VALUES (4354,
            (SELECT MAX(id_item) FROM db_itensmenu),
            6,
            952);";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "
        DELETE FROM db_menu WHERE db_item_filho = (SELECT id_item FROM db_itensmenu WHERE funcao = 'pes1_importarnomereceita001.php');
        DELETE FROM db_itensmenu WHERE funcao = 'pes1_importarnomereceita001.php';
        ";
        $this->execute($sql);
    }
}
