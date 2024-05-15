<?php

use Phinx\Migration\AbstractMigration;

class AddMenuAnexo8Fundeb extends AbstractMigration
{
    public function up()
    {
        $sql = "INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu),'Fundeb (Anexo VIII)', 'Fundeb (Anexo VIII)','con2_anexo8fundeb001.php',1,1,'','t');

        INSERT INTO db_menu VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao like 'Relat%rios de Acompanhamento'),
        (SELECT max(id_item) FROM db_itensmenu),
        (SELECT max(menusequencia)+1 FROM db_menu WHERE id_item = (SELECT id_item FROM db_itensmenu WHERE descricao like 'Relat%rios de Acompanhamento') AND modulo = 209),209);";

        $this->execute($sql);
    }

    public function down()
    {
        $sql = "DELETE FROM db_menu WHERE id_item_filho = (SELECT id_item FROM db_itensmenu WHERE descricao='Fundeb (Anexo VIII)');
        DELETE FROM db_itensmenu WHERE descricao='Fundeb (Anexo VIII)';
        ";

        $this->execute($sql);
    }
}
