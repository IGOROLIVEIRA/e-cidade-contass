<?php

use Classes\PostgresMigration;

class Oc13538 extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL
        
        BEGIN;
        SELECT fc_startsession();

        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c229_arrecadado', 'bool', 'Convênio possui valor arrecadado', '', 'Convênio possui valor arrecadado', 1, false, false, false, null, '', 'Convênio possui valor arrecadado');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c229_arrecadado'), 5, 0);

        ALTER TABLE prevconvenioreceita ADD COLUMN c229_arrecadado bool default false; 

        COMMIT;        
SQL;
        $this->execute($sql);
    }
}
