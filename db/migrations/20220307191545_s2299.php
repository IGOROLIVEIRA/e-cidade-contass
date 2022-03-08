<?php

use Phinx\Migration\AbstractMigration;

class S2299 extends AbstractMigration
{
    public function up()
    {
        $sql = "
        UPDATE configuracoes.db_itensmenu SET funcao='con4_manutencaoformulario001.php?esocial=43' WHERE descricao ilike 'S-2299%';
        ";
        $this->execute($sql);
    }
}
