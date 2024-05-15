<?php

use Phinx\Migration\AbstractMigration;

class Hotfixs2400 extends AbstractMigration
{
    public function up()
    {
        $sql = "
            UPDATE db_itensmenu
            SET funcao = 'con4_manutencaoformulario001.php?esocial=48'
            WHERE descricao LIKE '%S-2400%';
        ";
        $this->execute($sql);
    }
}
