<?php

use Classes\PostgresMigration;

class Oc14223 extends PostgresMigration
{
    public function up()
    {
        $sql = <<<SQL
  
        BEGIN;
        SELECT fc_startsession();

        INSERT INTO db_itensmenu
        VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Emite Recibo de Pagamento', 'Emite Recibo de Pagamento', 'emp2_emiterecibpag001.php', 1, 1, 'Emite Recibo de Pagamento', 't');

        INSERT INTO db_menu VALUES (
                    (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item 
                    WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Empenho') AND descricao = 'Documentos'),
                    (SELECT max(id_item) FROM db_itensmenu),
                    (SELECT 
                        CASE 
                            WHEN (SELECT count(*) FROM db_menu 
                            WHERE db_menu.id_item = (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item 
                                WHERE modulo = (SELECT id_item FROM db_modulos 
                                WHERE nome_modulo = 'Empenho') AND descricao = 'Documentos')) = 0 THEN 1
                            ELSE (SELECT max(menusequencia)+1 AS COUNT FROM db_menu 
                            WHERE id_item = (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item 
                                WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Empenho') AND descricao = 'Documentos'))
                        END),
                    (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Empenho') );

        INSERT INTO db_menu VALUES (
                    (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item 
                    WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Caixa') AND descricao = 'Relatórios'),
                    (SELECT max(id_item) FROM db_itensmenu),
                    (SELECT 
                        CASE 
                            WHEN (SELECT count(*) FROM db_menu 
                            WHERE db_menu.id_item = (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item 
                                WHERE modulo = (SELECT id_item FROM db_modulos 
                                WHERE nome_modulo = 'Caixa') AND descricao = 'Relatórios')) = 0 THEN 1
                            ELSE (SELECT max(menusequencia)+1 AS COUNT FROM db_menu 
                            WHERE id_item = (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item 
                                WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Caixa') AND descricao = 'Relatórios'))
                        END),
                    (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Caixa') );

        COMMIT;

SQL;
    $this->execute($sql);
  }

}