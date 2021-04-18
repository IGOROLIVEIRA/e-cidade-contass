<?php

use Phinx\Migration\AbstractMigration;

class Oc14439 extends AbstractMigration
{
  public function up()
  {

    $sql = "
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Manuten��o de Lan�amentos (Patrimonial)', 'Manuten��o de Lan�amentos (Patrimonial)', '', 1, 1, 'Manuten��o de Lan�amentos (Patrimonial)', 't');

        INSERT INTO db_menu VALUES (
            (SELECT id_item from db_itensmenu where descricao = 'Manuten��o de dados'),
            (SELECT max(id_item) FROM db_itensmenu),
            (SELECT max(menusequencia)+1 as count FROM db_menu  WHERE id_item = 32),
            (1));

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Configurar Numera��o', 'Configurar Numera��o', 'm4_confignumeracao.php', 1, 1, 'Configurar Numera��o', 't');

        INSERT INTO db_menu VALUES (
            (SELECT id_item from db_itensmenu where descricao = 'Manuten��o de Lan�amentos (Patrimonial)'),
            (SELECT max(id_item) FROM db_itensmenu),
            (SELECT max(menusequencia)+1 as count FROM db_menu  WHERE id_item = 32),
            (1));

        ";



    $this->execute($sql);
  }
}
