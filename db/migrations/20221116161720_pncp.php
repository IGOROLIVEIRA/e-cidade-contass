<?php

use Phinx\Migration\AbstractMigration;

class Pncp extends AbstractMigration
{

    public function up()
    {
        $sql = "
        
                INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'PNCP', 'PNCP', ' ', 1, 1, 'PNCP', 't');
                INSERT INTO db_menu VALUES(1818,(select max(id_item) from db_itensmenu),16,381);
                INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Publicao de Aviso', 'Publicao de Aviso', 'lic1_pncpavisolicitacao001.php', 1, 1, 'Publicao de Aviso', 't');
                INSERT INTO db_menu VALUES((select id_item from db_itensmenu where desctec like'%PNCP' and funcao = ' '),(select max(id_item) from db_itensmenu),1,381);

                INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Publicacao Resultados', 'Publicacao Resultados', 'lic1_pncpresultadolicitacao001.php', 1, 1, 'Publicacao Resultados', 't');
                INSERT INTO db_menu VALUES((select id_item from db_itensmenu where desctec like'%PNCP' and funcao = ' '),(select max(id_item) from db_itensmenu),2,381);    
        ";
        $this->execute($sql);
    }
}
