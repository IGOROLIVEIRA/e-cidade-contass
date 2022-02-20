<?php

use Phinx\Migration\AbstractMigration;

class Hotfix2200 extends AbstractMigration
{
    public function up()
    {
        $sql = "
        BEGIN;
        UPDATE configuracoes.db_itensmenu SET funcao='con4_manutencaoformulario001.php?esocial=37' WHERE descricao ilike 'S-2200%';
        COMMIT;
        ";
        $this->execute($sql);
    }
}
