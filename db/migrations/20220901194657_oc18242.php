<?php

use Phinx\Migration\AbstractMigration;

class Oc18242 extends AbstractMigration
{
    public function up()
    {

        $sql = <<<SQL

        BEGIN;

        SELECT fc_startsession();

       -- Inserindo menu Relatorio de Autonomos
       INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu),'Autônomos', 'Autônomos','emp2_autonomos001.php',1,1,'','t');
      
        INSERT INTO db_menu VALUES
        ((SELECT id_item FROM db_itensmenu
        WHERE descricao LIKE 'Relatorio de Conferencia'),

        (SELECT max(id_item) FROM db_itensmenu),

        (SELECT max(menusequencia)+1 FROM db_menu
        WHERE id_item =
            (SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Relatorio de Conferencia')
        AND modulo = 398),

        398);

        COMMIT;

SQL;
        $this->execute($sql);
    } 
}
