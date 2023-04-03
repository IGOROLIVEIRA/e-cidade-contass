<?php

use Phinx\Migration\AbstractMigration;

class Oc19723 extends AbstractMigration
{
    public function up()
    {
        $sqlFontes = "UPDATE orctiporec
                      SET o15_datalimite = '2023-01-02'
                      WHERE length(o15_codigo::varchar) < 5
                        AND o15_datalimite = '2023-01-01'";

        $this->execute($sqlFontes);

    }
}
