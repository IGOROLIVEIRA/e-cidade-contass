<?php

use Classes\PostgresMigration;

class Oc15143 extends PostgresMigration
{
    public function up()
    {
        $sql = <<<SQL
  
        BEGIN;
        SELECT fc_startsession();

        UPDATE db_itensmenu
            SET libcliente = TRUE
            WHERE funcao = 'orc4_ppadespesamanual003.php';


        UPDATE db_itensmenu
            SET libcliente = TRUE
            WHERE funcao = 'orc4_ppadespesamanual003.php';

        UPDATE db_syscampo
            SET nulo = FALSE
            WHERE nomecam = 'o08_localizadorgastos';
        
                                
        COMMIT;

SQL;
    $this->execute($sql);
  }

}