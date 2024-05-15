<?php

use Phinx\Migration\AbstractMigration;

class AlterarRhmotivorescisao2 extends AbstractMigration
{
    public function up()
    {
        $sql = "

        UPDATE rhpesrescisao SET rh05_motivo = 6 WHERE rh05_motivo IN (35);

        DELETE FROM rhmotivorescisao WHERE rh173_codigo IN ('35');
        ";
        $this->execute($sql);
    }

    public function down()
    {

    }
}
