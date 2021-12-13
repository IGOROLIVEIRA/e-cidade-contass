<?php

use Phinx\Migration\AbstractMigration;

class Oc14521 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
        BEGIN;
        SELECT fc_startsession();
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'exportação de Processos licitatórios', 'exportação de Processos licitatórios', 'con1_exportaprocessos.php', 1, 1, 'exportação de Processos licitatórios', 't');

        INSERT INTO db_menu VALUES (1797,
                        (SELECT max(id_item) FROM db_itensmenu),
                        (SELECT max(menusequencia)+1 as count FROM db_menu  WHERE id_item = 1797 and modulo = 381),
                        381);

        COMMIT;
SQL;
        $this->execute($sql);
    }
}
