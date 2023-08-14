<?php

use Phinx\Migration\AbstractMigration;

class Oc15627v3 extends AbstractMigration
{
    public function up()
    {

    $sql = <<<SQL

    BEGIN;

    SELECT fc_startsession();
    
        INSERT INTO db_itensmenu 
            VALUES 
            ((select max(id_item)+1 from db_itensmenu), 'Transferências de Retenções Orçamentárias', 'Transferências de Retenções Orçamentárias', 'cai2_transfretorc001.php', 1, 1, 'Transferências de Retenções Orçamentárias', 't');

        INSERT INTO db_menu 
            VALUES
            (3951,(select max(id_item) from db_itensmenu),(select max(menusequencia) + 1 from db_menu where id_item = 30 and modulo = 39),39);
       
    COMMIT;

SQL;
        $this->execute($sql);
    } 
}