<?php

use Classes\PostgresMigration;

class AddCaracteriscaPecuriar extends PostgresMigration
{
    public function up()
    {
        $sql = "INSERT INTO contabilidade.concarpeculiar (c58_sequencial,c58_descr,c58_tipo,c58_db_estruturavalor,c58_estrutural)
        VALUES ('095','DEVOLUCAO DOS RECURSOS DO FUNDEB', 2, 1, '095')";
        $this->execute($sql);
        $sql = "INSERT INTO contabilidade.concarpeculiar (c58_sequencial,c58_descr,c58_tipo,c58_db_estruturavalor,c58_estrutural)
        VALUES ('096','RECEBIMENTO DE DEVOLUCAO DOS RECURSOS DO FUNDEB', 2, 1, '096');";
        $this->execute($sql);
    }
}
