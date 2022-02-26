<?php

use Phinx\Migration\AbstractMigration;

class S2206 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
        UPDATE configuracoes.db_itensmenu SET funcao='con4_manutencaoformulario001.php?esocial=39' WHERE descricao ilike 'S-2206%';

        UPDATE habitacao.avaliacaopergunta
        SET db103_camposql='tpinscestab'
        WHERE db103_sequencial=4000757;


        UPDATE habitacao.avaliacaopergunta
            SET db103_camposql='nrinscestab'
            WHERE db103_sequencial=4000758;

SQL;
        $this->execute($sql);
    }
}
