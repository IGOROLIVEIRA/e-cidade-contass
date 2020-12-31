<?php

use Classes\PostgresMigration;

class Oc13243 extends PostgresMigration
{
    public function up()
    {
        $sql = <<<SQL
  
        BEGIN;
        SELECT fc_startsession();
        
        INSERT INTO db_itensmenu (id_item, descricao, help, funcao, itemativo, manutencao, desctec, libcliente) VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Exclusão', 'Exclusão Projeto de Lei', 'orc1_orcprojetolei003.php', 1, 1, 'Exclusão Projeto de Lei', 'true');

        INSERT INTO db_menu VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao = 'Projeto de Lei' LIMIT 1), (SELECT id_item FROM db_itensmenu WHERE descricao = 'Exclusão' AND help = 'Exclusão Projeto de Lei' LIMIT 1), 3, 116);

        INSERT INTO db_menu VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao = 'Decreto' LIMIT 1), (SELECT id_item FROM db_itensmenu WHERE descricao = 'Exclusão' AND help = 'Exclusão de Orcprojeto' LIMIT 1), 3, 116);
        
        COMMIT;

SQL;
    $this->execute($sql);
  }

}