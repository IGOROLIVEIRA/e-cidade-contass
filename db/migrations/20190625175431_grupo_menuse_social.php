<?php

use Phinx\Migration\AbstractMigration;

class GrupoMenuseSocial extends AbstractMigration
{

    public function up()
    {
        $sql = <<<SQL

        SELECT fc_startsession();

        INSERT INTO db_itensmenu
        VALUES ((SELECT MAX(id_item)+1 FROM db_itensmenu),
            'Tabelas',
            'Tabelas',
            '',
            1,
            1,
            'Tabelas para envio eSocial',
            't');

        INSERT INTO db_menu 
        VALUES (10466,
            (SELECT MAX(id_item) FROM db_itensmenu),
            2,
            10216);

        UPDATE db_menu SET menusequencia = 1 WHERE id_item_filho = 10244;

        UPDATE db_menu SET id_item = (SELECT MAX(id_item) FROM db_itensmenu) WHERE modulo = 10216 AND menusequencia >= 2 AND id_item = 10466 AND id_item_filho != (SELECT MAX(id_item) FROM db_itensmenu);

        UPDATE db_itensmenu SET descricao = 'Tabela de Rubricas - S1010' WHERE id_item = 10426; 

        UPDATE db_itensmenu SET descricao = 'Lotação Tributária - S1020' WHERE id_item = 10479; 

        INSERT INTO db_itensmenu
        VALUES ((SELECT MAX(id_item)+1 FROM db_itensmenu),
            'Eventos Periódicos',
            'Eventos Periódicos',
            '',
            1,
            1,
            'Eventos Periódicos',
            't');

        INSERT INTO db_menu 
        VALUES (10466,
            (SELECT MAX(id_item) FROM db_itensmenu),
            3,
            10216);

        INSERT INTO db_itensmenu
        VALUES ((SELECT MAX(id_item)+1 FROM db_itensmenu),
            'Eventos Não Periódicos',
            'Eventos Não Periódicos',
            '',
            1,
            1,
            'Eventos Não Periódicos',
            't');

        INSERT INTO db_menu 
        VALUES (10466,
            (SELECT MAX(id_item) FROM db_itensmenu),
            4,
            10216);

        UPDATE db_menu SET id_item = (SELECT MAX(id_item) FROM db_itensmenu) WHERE modulo = 10216 AND id_item_filho = 10220;

        UPDATE db_itensmenu SET descricao = 'Conferência de Dados - S2200' WHERE id_item = 10220;

SQL;
    }
}
