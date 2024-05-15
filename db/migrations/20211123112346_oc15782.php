<?php

use Phinx\Migration\AbstractMigration;

class Oc15782 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
            BEGIN;

                update db_itensmenu set libcliente = 'f' where id_item = (select id_item from db_itensmenu where descricao like '%Credenciamento%' and help = 'Credenciamento');
                update db_itensmenu set libcliente = 'f' where id_item = (select id_item from db_itensmenu where funcao = 'lic1_precomedio001.php');
                update db_itensmenu set libcliente = 'f' where id_item = (select id_item from db_itensmenu where descricao like '%Desconto Tabela%' and id_item not in (select id_item from db_itensmenu where funcao = 'con4_sicomdescontotabela.php'));

                UPDATE db_menu
                SET menusequencia = menusequencia +30
                WHERE id_item_filho IN
                        (SELECT db_menu.id_item_filho
                        FROM db_menu
                        INNER JOIN db_itensmenu ON db_itensmenu.id_item = db_menu.id_item_filho
                        WHERE db_menu.id_item = 1818
                            AND db_menu.modulo = 381
                        ORDER BY db_menu.menusequencia);

                UPDATE db_menu
                SET menusequencia = 1
                WHERE id_item_filho =
                        (SELECT id_item
                        FROM db_itensmenu
                        WHERE help LIKE '%Cadastro de Licita%');

                UPDATE db_menu
                SET menusequencia = 2
                WHERE id_item_filho =
                        (SELECT id_item
                        FROM db_itensmenu
                        WHERE help LIKE '%Cadastro de Fornecedores da Licita%');

                UPDATE db_menu
                SET menusequencia = 3
                WHERE id_item_filho =
                        (SELECT id_item
                        FROM db_itensmenu
                        WHERE funcao LIKE '%lic1_lancavallic001.php%');

                UPDATE db_menu
                SET menusequencia = 4
                WHERE id_item_filho =
                        (SELECT id_item
                        FROM db_itensmenu
                        WHERE help LIKE '%Cancela julgamento de licita%');

                UPDATE db_menu
                SET menusequencia = 5
                WHERE id_item_filho =
                        (SELECT id_item
                        FROM db_itensmenu
                        WHERE help LIKE '%Cadastro de Parecer%');

                UPDATE db_menu
                SET menusequencia = 6
                WHERE id_item_filho =
                        (SELECT id_item
                        FROM db_itensmenu
                        WHERE help LIKE '%Adjudica%'
                            AND descricao LIKE '%Adjudica%'
                            AND funcao = ' ');

                UPDATE db_menu
                SET menusequencia = 7
                WHERE id_item_filho =
                        (SELECT id_item
                        FROM db_itensmenu
                        WHERE help LIKE '%Homologa%'
                            AND descricao LIKE '%Homologa%'
                            AND funcao = '');

                UPDATE db_menu
                SET menusequencia = 8
                WHERE id_item_filho =
                        (SELECT id_item
                        FROM db_itensmenu
                        WHERE descricao LIKE '%Termo de Ratifica%');

                UPDATE db_menu
                SET menusequencia = 9
                WHERE id_item_filho =
                        (SELECT id_item
                        FROM db_itensmenu
                        WHERE funcao = 'lic1_pccflicitanum002.php');

                UPDATE db_menu
                SET menusequencia = 10
                WHERE id_item_filho =
                        (SELECT id_item
                        FROM db_itensmenu
                        WHERE funcao = 'lic4_geraaut001.php');

                UPDATE db_menu
                SET menusequencia = 11
                WHERE id_item_filho =
                        (SELECT id_item
                        FROM db_itensmenu
                        WHERE funcao = 'lic4_anulaaut001.php');

                UPDATE db_menu
                SET menusequencia = 12
                WHERE id_item_filho =
                        (SELECT id_item
                        FROM db_itensmenu
                        WHERE descricao LIKE '%Registro de Pre%'
                            AND id_item IN
                                (SELECT db_menu.id_item_filho
                                FROM db_menu
                                INNER JOIN db_itensmenu ON db_itensmenu.id_item = db_menu.id_item_filho
                                WHERE db_menu.id_item = 1818
                                    AND db_menu.modulo = 381
                                ORDER BY db_menu.menusequencia));

                UPDATE db_menu
                SET menusequencia = 13
                WHERE id_item_filho =
                        (SELECT id_item
                        FROM db_itensmenu
                        WHERE descricao LIKE '%Trocar Fornecedor%');

                UPDATE db_menu
                SET menusequencia = 14
                WHERE id_item_filho =
                        (SELECT id_item
                        FROM db_itensmenu
                        WHERE descricao LIKE '%Edital%'
                            AND desctec = 'Edital'
                            AND id_item IN
                                (SELECT db_menu.id_item_filho
                                FROM db_menu
                                INNER JOIN db_itensmenu ON db_itensmenu.id_item = db_menu.id_item_filho
                                WHERE db_menu.id_item = 1818
                                    AND db_menu.modulo = 381
                                ORDER BY db_menu.menusequencia));

                UPDATE db_menu
                SET menusequencia = 15
                WHERE id_item_filho =
                        (SELECT id_item
                        FROM db_itensmenu
                        WHERE descricao LIKE '%Ata%'
                            AND desctec = 'Ata'
                            AND id_item IN
                                (SELECT db_menu.id_item_filho
                                FROM db_menu
                                INNER JOIN db_itensmenu ON db_itensmenu.id_item = db_menu.id_item_filho
                                WHERE db_menu.id_item = 1818
                                    AND db_menu.modulo = 381
                                ORDER BY db_menu.menusequencia));

                UPDATE db_menu
                SET menusequencia = 16
                WHERE id_item_filho =
                        (SELECT id_item
                        FROM db_itensmenu
                        WHERE funcao = 'lic1_licitaparam002.php');

                UPDATE db_menu
                SET menusequencia = 17
                WHERE id_item_filho =
                        (SELECT id_item
                        FROM db_itensmenu
                        WHERE descricao LIKE '%Cadastro de Edital%');

                COMMIT;
SQL;

    $this->execute($sql);
    
    }
}
