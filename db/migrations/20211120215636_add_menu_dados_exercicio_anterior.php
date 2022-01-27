<?php

use Phinx\Migration\AbstractMigration;

class AddMenuDadosExercicioAnterior extends AbstractMigration
{
    public function up()
    {

        $sql  = " INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Dados de Exercícios Anteriores', 'Dados de Exercícios Anteriores', '', 1, 1, 'Dados de Exercícios Anteriores', 't');";
        $sql .= " INSERT INTO db_menu VALUES (29, (select max(id_item) from db_itensmenu), 264, 209);";
        $sql .= " INSERT INTO db_itensmenu VALUES ((select max(id_item) +1 from db_itensmenu), 'Inclusão', 'Inclusão', 'con1_dadosexercicioanterior001.php', '1', '1', 'Inclusão', 't');";
        $sql .= " INSERT INTO db_menu VALUES ((select max(id_item) from db_itensmenu WHERE descricao = 'Dados de Exercícios Anteriores'), (select max(id_item) from db_itensmenu), 1, 209);";
        $sql .= " INSERT INTO db_itensmenu VALUES ((select max(id_item) +1 from db_itensmenu), 'Alteração', 'Alteração', 'con1_dadosexercicioanterior002.php', '1', '1', 'Alteração', 't');";
        $sql .= " INSERT INTO db_menu VALUES ((select max(id_item) from db_itensmenu WHERE descricao = 'Dados de Exercícios Anteriores'), (select max(id_item) from db_itensmenu), 2, 209);";
        $sql .= " INSERT INTO db_itensmenu VALUES ((select max(id_item) +1 from db_itensmenu), 'Exclusão', 'Exclusão', 'con1_dadosexercicioanterior003.php', '1', '1', 'Exclusão', 't');";
        $sql .= " INSERT INTO db_menu VALUES ((select max(id_item) from db_itensmenu WHERE descricao = 'Dados de Exercícios Anteriores'), (select max(id_item) from db_itensmenu), 3, 209);";

        $this->execute($sql);
    }

    public function down()
    {
    }
}
