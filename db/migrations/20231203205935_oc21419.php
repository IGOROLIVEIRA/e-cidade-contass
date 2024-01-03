<?php

use Phinx\Migration\AbstractMigration;

class Oc21419 extends AbstractMigration
{
    public function up()
    {
        $sql = "
        INSERT INTO db_itensmenu VALUES (
            (SELECT max(id_item)+1 FROM db_itensmenu),
            'Virada Anual de Dotações',
            'Virada Anual de Dotações',
            'ac04_alterardotacoescontratos001.php',
            1,
            1,
            'Virada Anual de Dotações',
            't');

        INSERT INTO db_menu VALUES(
            (SELECT id_item FROM db_menu WHERE id_item_filho = (SELECT id_item FROM db_itensmenu WHERE descricao LIKE'%Alterar%' AND funcao = 'ac04_alteradotacaocredenciamento001.php')),
            (SELECT max(id_item) from db_itensmenu),
            (SELECT MAX(menusequencia)+1 AS COUNT FROM db_menu WHERE id_item = (SELECT id_item FROM db_menu WHERE id_item_filho = (SELECT id_item FROM db_itensmenu WHERE descricao LIKE'%Alterar%' AND funcao = 'ac04_alteradotacaocredenciamento001.php'))),
            (SELECT modulo FROM db_menu WHERE id_item_filho = (SELECT id_item FROM db_itensmenu WHERE descricao LIKE'%Alterar%' AND funcao = 'ac04_alteradotacaocredenciamento001.php')));
        ";

        $this->execute($sql);
    }
}
