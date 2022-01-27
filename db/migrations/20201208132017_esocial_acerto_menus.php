<?php

use Classes\PostgresMigration;

class EsocialAcertoMenus extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL

        UPDATE db_itensmenu SET descricao = 'Tabela de Rubricas - S1010' WHERE descricao = 'Tabela de Rubricas';

        UPDATE db_itensmenu SET descricao = 'Tabela de Lotação Tributária - S1020' WHERE descricao = 'Lotação Tributária';

        UPDATE db_menu SET menusequencia = 1 WHERE id_item_filho = (SELECT id_item FROM db_itensmenu WHERE descricao = 'Informações do Empregador');
        UPDATE db_itensmenu SET descricao = 'Informações do Empregador - S1000 e S1005' WHERE descricao = 'Informações do Empregador';

        INSERT INTO db_itensmenu
        VALUES ((SELECT MAX(id_item)+1 FROM db_itensmenu),
            'Tabelas',
            'Tabelas',
            '',
            1,
            1,
            'Tabelas',
            't');

        INSERT INTO db_menu 
        VALUES (10466,
            (SELECT MAX(id_item) FROM db_itensmenu),
            1,
            10216);

        UPDATE db_menu SET id_item = (SELECT MAX(id_item) FROM db_itensmenu) WHERE id_item = (SELECT id_item FROM db_itensmenu WHERE descricao = 'Preenchimento') AND id_item_filho != (SELECT id_item FROM db_itensmenu WHERE descricao = 'Conferência de Dados') AND id_item_filho != (SELECT MAX(id_item) FROM db_itensmenu);

        INSERT INTO db_itensmenu
        VALUES ((SELECT MAX(id_item)+1 FROM db_itensmenu),
            'Periódicos',
            'Periódicos',
            '',
            1,
            1,
            'Periódicos',
            't');

        INSERT INTO db_menu 
        VALUES (10466,
            (SELECT MAX(id_item) FROM db_itensmenu),
            2,
            10216);

        INSERT INTO db_itensmenu
        VALUES ((SELECT MAX(id_item)+1 FROM db_itensmenu),
            'Não Periódicos',
            'Não Periódicos',
            '',
            1,
            1,
            'Não Periódicos',
            't');

        INSERT INTO db_menu 
        VALUES (10466,
            (SELECT MAX(id_item) FROM db_itensmenu),
            3,
            10216);

        UPDATE db_menu SET id_item = (SELECT MAX(id_item) FROM db_itensmenu) WHERE id_item_filho = (SELECT id_item FROM db_itensmenu WHERE descricao = 'Conferência de Dados');

        UPDATE db_itensmenu SET descricao = 'Conferência de Dados - S2200' WHERE descricao = 'Conferência de Dados';

SQL;
        $this->execute($sql);
    }

    public function down() {

    }
 }
