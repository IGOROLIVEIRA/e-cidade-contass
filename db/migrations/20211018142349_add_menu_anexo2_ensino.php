<?php

use Phinx\Migration\AbstractMigration;

class AddMenuAnexo2Ensino extends AbstractMigration
{
    public function up()
    {
        $sql = "INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu),'Receita Ensino (Anexo II)', 'Receita Ensino (Anexo II)','con2_anexo2ensino001.php',1,1,'','t');

        INSERT INTO db_menu VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao like 'Relat%rios de Acompanhamento'),
        (SELECT max(id_item) FROM db_itensmenu),
        (SELECT max(menusequencia)+1 FROM db_menu WHERE id_item = (SELECT id_item FROM db_itensmenu WHERE descricao like 'Relat%rios de Acompanhamento') AND modulo = 209),209);";

        $this->execute($sql);
    }

    public function down()
    {
        $sql = "DELETE FROM db_menu WHERE id_item_filho = (SELECT id_item FROM db_itensmenu WHERE descricao='Receita Ensino (Anexo II)');
        DELETE FROM db_itensmenu WHERE descricao='Receita Ensino (Anexo II)';
        ";

        $this->execute($sql);
    }
}
