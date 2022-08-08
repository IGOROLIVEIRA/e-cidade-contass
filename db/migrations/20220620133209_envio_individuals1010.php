<?php

use Phinx\Migration\AbstractMigration;

class EnvioIndividuals1010 extends AbstractMigration
{

    public function up()
    {
        $sql = "
            INSERT INTO db_itensmenu VALUES ((SELECT MAX(id_item)+1 FROM db_itensmenu), 'Tabela de Rubricas Individual', 'Tabela de Rubricas Individual', 'eso4_tabeladerubricasindividual001.php', 1, 1, 'Tabela de Rubricas Individual', 't');
            INSERT INTO db_menu VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao ilike '%(Envio)'),(SELECT MAX(id_item) FROM db_itensmenu),(SELECT coalesce(MAX(menusequencia)+1,0) FROM db_menu WHERE id_item = (SELECT id_item FROM db_itensmenu WHERE descricao ilike '%(Envio)') and modulo = 10216),10216);
        ";
        $this->execute($sql);
    }
}
