<?php

use Classes\PostgresMigration;

class Oc12846 extends PostgresMigration
{

  public function up()
  {
    $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();
        
        UPDATE conhistdoc SET c53_tipo = 201 WHERE c53_coddoc = 215;

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu),'Despesa por Item/Desdobramento - PBH' ,'Despesa por Item/Desdobramento - PBH' ,'orc2_despitemdesdobramentopbh001.php' ,'1' ,'1' ,'' ,'true' );

        INSERT INTO db_menu VALUES (4189, (SELECT id_item FROM db_itensmenu WHERE descricao = 'Despesa por Item/Desdobramento - PBH' LIMIT 1), (SELECT max(menusequencia)+1 FROM db_menu WHERE id_item = 4189), 209);

        COMMIT;

SQL;
    $this->execute($sql);
  }

}    