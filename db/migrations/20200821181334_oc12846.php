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

        COMMIT;

SQL;
    $this->execute($sql);
  }

}    