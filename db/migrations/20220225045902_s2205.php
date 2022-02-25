<?php

use Phinx\Migration\AbstractMigration;

class S2205 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
        UPDATE configuracoes.db_itensmenu SET funcao='con4_manutencaoformulario001.php?esocial=38' WHERE descricao ilike 'S-2205%';
        update avaliacaopergunta set db103_camposql = LOWER(db103_identificadorcampo);
SQL;
        $this->execute($sql);
    }
}
