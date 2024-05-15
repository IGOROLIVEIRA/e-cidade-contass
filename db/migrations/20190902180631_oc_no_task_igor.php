<?php

use Phinx\Migration\AbstractMigration;

class OcNoTaskIgor extends AbstractMigration
{

    public function up()
    {
        $sql = "SELECT setval('orcparamrelperiodos_o113_sequencial_seq',
                  (SELECT max(o113_sequencial)
                   FROM orcparamrelperiodos));


                SELECT setval('orcparamseqorcparamseqcoluna_o116_sequencial_seq',
                  (SELECT max(o116_sequencial)
                   FROM orcparamseqorcparamseqcoluna));";
        $this->execute($sql);
    }

    public function down()
    {

    }
}
