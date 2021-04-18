<?php

use Phinx\Migration\AbstractMigration;

class Oc14439 extends AbstractMigration
{
  public function up()
  {

    $sql = "
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Manutenção de Lançamentos (Patrimonial)', 'Manutenção de Lançamentos (Patrimonial)', '', 1, 1, 'Manutenção de Lançamentos (Patrimonial)', 't');

        INSERT INTO db_menu VALUES (
            (SELECT id_item from db_itensmenu where descricao = 'Manutenção de dados'),
            (SELECT max(id_item) FROM db_itensmenu),
            (SELECT max(menusequencia)+1 as count FROM db_menu  WHERE id_item = 32),
            (1));

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Configurar Numeração', 'Configurar Numeração', 'm4_confignumeracao.php', 1, 1, 'Configurar Numeração', 't');

        INSERT INTO db_menu VALUES (
            (SELECT id_item from db_itensmenu where descricao = 'Manutenção de Lançamentos (Patrimonial)'),
            (SELECT max(id_item) FROM db_itensmenu),
            (SELECT max(menusequencia)+1 as count FROM db_menu  WHERE id_item = 32),
            (1));

        ";



    $this->execute($sql);
  }
}
