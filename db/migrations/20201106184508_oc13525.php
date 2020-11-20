<?php

use Classes\PostgresMigration;

class Oc13525 extends PostgresMigration
{

    public function up()
    {
        $this->execute("UPDATE db_syscampo SET tamanho = 1 WHERE nomecam='db89_digito'");
    }

    public function down()
    {
        $this->execute("UPDATE db_syscampo SET tamanho = 2 WHERE nomecam='db89_digito'");
    }
}
