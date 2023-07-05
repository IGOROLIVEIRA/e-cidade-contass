<?php

use Phinx\Migration\AbstractMigration;

class Oc19785 extends AbstractMigration
{

    public function up()
    {
        /* $sql = "
        BEGIN

        INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),
        'Relatórios','Relatórios','',1,1,'Relatórios','t');
        
        INSERT INTO db_menu VALUES(4001223,(select max(id_item) from db_itensmenu),2,(select id_item from db_modulos where nome_modulo like '%Obras%'));
        
        INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'Obras','Obras','obr1_relatorioobras001.php',1,1,'Obras','t');

        INSERT INTO db_menu VALUES((select max(id_item)-1 from db_itensmenu),(select max(id_item) from db_itensmenu),1,4001223);

        update db_menu set menusequencia = 3 where id_item = 4001223 and modulo = 4001223 and id_item_filho  = 32;

        COMMIT";

        $this->execute($sql);*/
    }
}
