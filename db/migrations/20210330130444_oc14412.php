<?php

use Classes\PostgresMigration;

class Oc14412 extends PostgresMigration
{
    public function up()
    {
        $sql = <<<SQL
  
        BEGIN;
        SELECT fc_startsession();

        ALTER TABLE empagemov ADD COLUMN e81_numdoc varchar(15); 

        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'e81_numdoc', 'varchar(15)', 'Nº Documento', null, 'Nº Documento', '15', false, false, false, 0, 'text', 'Nº Documento');

        INSERT INTO db_sysarqcamp VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empagemov' LIMIT 1), (SELECT max(codcam) FROM db_syscampo), 6, 0);

        COMMIT;

SQL;
    $this->execute($sql);
  }

}