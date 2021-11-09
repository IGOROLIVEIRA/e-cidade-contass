<?php

use Classes\PostgresMigration;

class AlterarCampoAvaliacaoPergunta extends PostgresMigration
{
    public function up()
    {
        $sSql  = "UPDATE db_syscampo SET tamanho = 250, conteudo = 'varchar(250)'  WHERE nomecam = 'db103_descricao';
        UPDATE db_syscampo SET tamanho = 200, conteudo = 'varchar(200)'  WHERE nomecam = 'db102_descricao';

        ALTER TABLE avaliacaopergunta ALTER COLUMN db103_descricao TYPE varchar(250);
        ALTER TABLE avaliacaogrupopergunta ALTER COLUMN db102_descricao TYPE varchar(200);
        ";
        $this->execute($sSql);
    }

    public function down()
    {
        $sSql  = "UPDATE db_syscampo SET tamanho = 200, conteudo = 'varchar(200)'  WHERE nomecam = 'db103_descricao';
        UPDATE db_syscampo SET tamanho = 100, conteudo = 'varchar(100)'  WHERE nomecam = 'db102_descricao';

        ALTER TABLE avaliacaopergunta ALTER COLUMN db103_descricao TYPE varchar(200);
        ALTER TABLE avaliacaogrupopergunta ALTER COLUMN db102_descricao TYPE varchar(100);
        ";
        $this->execute($sSql);
    }
}
