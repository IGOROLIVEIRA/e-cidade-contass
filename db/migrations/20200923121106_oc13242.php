<?php

use Classes\PostgresMigration;

class Oc13242 extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        --Cria campo na tabela
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 FROM db_syscampo), 'e30_prazoentordcompra',  'int4', 'Dias de prazo para entrada da ordem de c', '0', 'Dias de prazo para entrada da ordem de compra', 2, 'f', 'f', 'f', 1, 'text', 'Dias de prazo paraprazoentrordcomp de c');

        INSERT INTO db_sysarqcamp VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empparametro'), (SELECT codcam FROM db_syscampo WHERE nomecam = 'e30_prazoentordcompra'), 23, 0);

        ALTER TABLE empparametro ADD COLUMN e30_prazoentordcompra integer DEFAULT 30;

        --Cria menu do relatorio do controle interno caso nao exista no cliente
        INSERT INTO db_itensmenu (id_item, descricao, help, funcao, itemativo, manutencao, desctec, libcliente)
            SELECT (SELECT max(id_item)+1 FROM db_itensmenu), 'Relatórios', 'Relatórios', '', 1, 1, 'Relatórios', 't'
            WHERE NOT EXISTS ( 
                SELECT 1 FROM 
                    db_menu 
                        INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item 
                    WHERE modulo = ( 
                        SELECT db_modulos.id_item 
                        FROM db_modulos 
                        WHERE nome_modulo = 'Controle Interno') 
                    AND descricao = 'Relatórios'
            );

        INSERT INTO db_menu (id_item, id_item_filho, menusequencia, modulo) 
            SELECT  (SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'), 
                    (SELECT max(id_item) FROM db_itensmenu), 
                    (SELECT CASE
                        WHEN (SELECT count(*) FROM db_menu WHERE id_item = (SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')) = 0 THEN 1 
                        ELSE (SELECT max(menusequencia)+1 as count FROM db_menu  WHERE id_item = (SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')) 
                    END), 
                    (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno')
            WHERE NOT EXISTS ( 
                SELECT 1 FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Relatórios'
            );

        --Cria menu do relatorio ordem de compra pendente de entrada
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Ordens de Compra Pendentes', 'Ordens de Compra Pendentes', 'com2_relordemcompend001.php', 1, 1, 'Ordens de Compra Pendentes', 't');

        INSERT INTO db_menu VALUES (
            (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Relatórios'), 
            (SELECT max(id_item) FROM db_itensmenu), 
            (SELECT CASE
                WHEN (SELECT count(*) FROM db_menu WHERE db_menu.id_item = (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Relatórios')) = 0 THEN 1 
                ELSE (SELECT max(menusequencia)+1 as count FROM db_menu WHERE id_item = (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Relatórios')) 
            END), 
            (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno')
        );

        COMMIT;

SQL;
        $this->execute($sql);
    }

}