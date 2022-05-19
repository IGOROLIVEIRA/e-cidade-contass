<?php

use Phinx\Migration\AbstractMigration;

class Oc17280Hotfix extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
            --inserindo menu cadastro de quadro de superavit e deficit financeiro
            INSERT INTO db_itensmenu VALUES((select max(id_item) + 1 from db_itensmenu), 'Quadro do Superávit / Déficit Financeiro', 'Quadro do Superávit / Déficit Financeiro', 'con1_quadrosuperavitdeficit001.php', 1, 1, 'Quadro do Superávit / Déficit Financeiro', 't');
            INSERT INTO db_menu VALUES(29, (select max(id_item) from db_itensmenu), 266, 209);
SQL;

        $this->execute($sql);
    }

    public function down()
    {

    }
}
