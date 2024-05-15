<?php

use Phinx\Migration\AbstractMigration;

class CampoCargoTabelaFolha extends AbstractMigration
{

    public function up()
    {
        $sql = "
        ALTER TABLE folha ALTER COLUMN r38_funcao TYPE VARCHAR(100);
        UPDATE db_syscampo SET tamanho = 100 WHERE nomecam = 'r38_funcao';
        ";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "
        ALTER TABLE folha ALTER COLUMN r38_funcao TYPE VARCHAR(30);
        UPDATE db_syscampo SET tamanho = 30 WHERE nomecam = 'r38_funcao';
        ";
        $this->execute($sql);
    }
}
