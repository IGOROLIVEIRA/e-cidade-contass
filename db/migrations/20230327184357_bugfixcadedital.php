<?php

use Phinx\Migration\AbstractMigration;

class Bugfixcadedital extends AbstractMigration
{
    
    public function up()
    {
        $sql = "BEGIN;
            UPDATE db_itensmenu SET funcao = 'func_edital.php?notifica=true' WHERE funcao LIKE '%func_edital%';
            COMMIT;";

        $this->execute($sql);

    }
}
