<?php

use Phinx\Migration\AbstractMigration;

class AlterarMatriculaEstagio extends AbstractMigration
{

    public function up()
    {
        $sql = "
        UPDATE db_syscampo SET conteudo = 'varchar(50)', tamanho = 50
        WHERE nomecam = 'h83_matricula';
        ALTER TABLE rhestagiocurricular ALTER COLUMN h83_matricula TYPE varchar(50);
        ";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "
        UPDATE db_syscampo SET conteudo = 'int8', tamanho = 11
        WHERE nomecam = 'h83_matricula';
        ALTER TABLE rhestagiocurricular ALTER COLUMN h83_matricula TYPE integer USING (h83_matricula::integer);
        ";
        $this->execute($sql);
    }
}
