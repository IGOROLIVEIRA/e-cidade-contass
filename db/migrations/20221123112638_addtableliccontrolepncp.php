<?php

use Phinx\Migration\AbstractMigration;

class Addtableliccontrolepncp extends AbstractMigration
{

    public function up()
    {
        $sql = " 
        BEGIN;
            CREATE TABLE liccontrolepncp(
                l213_sequencial           int8 NOT NULL,
                l213_licitacao            int8 NOT NULL,
                l213_usuario			  int8 NOT NULL,
                l213_dtlancamento         date NOT NULL,
                l213_numerocontrolepncp   text NOT NULL,
                l213_situacao			  int8 NOT NULL,
                l213_instit               int8 NOT NULL
            );
        COMMIT;
        ";
        $this->execute($sql);
    }
}
