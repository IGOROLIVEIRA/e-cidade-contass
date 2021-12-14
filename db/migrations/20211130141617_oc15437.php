<?php

use Phinx\Migration\AbstractMigration;

class Oc15437 extends AbstractMigration
{

    public function up()
    {
        $sql = " DELETE
        FROM db_menu
        WHERE id_item_filho =
                (SELECT id_item
                 FROM db_itensmenu
                 WHERE funcao = 'm4_confignumeracao.php');

         DELETE
        FROM db_itensmenu
        WHERE funcao = 'm4_confignumeracao.php';

         INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'Licitacao','Manutencao de licitacao','m4_licitacao.php',1,1,'Manutencao de acordo','t');
        INSERT INTO db_menu VALUES(select id_item from db_itensmenu where descricao like '%(Patrimonial)%'
        ,(select max(id_item) from db_itensmenu),3,1);
        INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'Acordo','Manutencao de acordo','m4_confignumeracao.php',1,1,'Manutencao de acordo','t');
        INSERT INTO db_menu VALUES(select id_item from db_itensmenu where descricao like '%(Patrimonial)%'
        ,(select max(id_item) from db_itensmenu),4,1);
        INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'Protocolo','Manutencao de protocolo','m4_protocolo.php',1,1,'Manutencao de protocolo','t');
        INSERT INTO db_menu VALUES(select id_item from db_itensmenu where descricao like '%(Patrimonial)%'
        ,(select max(id_item) from db_itensmenu),5,1);";

        $this->execute($sql);
    }
}
