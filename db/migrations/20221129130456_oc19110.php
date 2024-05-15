<?php

use Phinx\Migration\AbstractMigration;

class Oc19110 extends AbstractMigration
{
    public function up()
    {

        $sql = <<<SQL

        BEGIN;

        SELECT fc_startsession();

        UPDATE
          orcsuplementacaoparametro
        SET
          o134_orcamentoaprovado = 't'
        WHERE
          o134_anousu = 2022;
  
        COMMIT;

SQL;
        $this->execute($sql);
    } 
}
 