<?php

use Phinx\Migration\AbstractMigration;

class AlterarRhmotivorescisao extends AbstractMigration
{

    public function up()
    {
        $sql = "
        INSERT INTO rhmotivorescisao VALUES (NEXTVAL('rhmotivorescisao_rh173_sequencial_seq'),
        '38',
        'Aposentadoria, exceto por invalidez');

        UPDATE rhpesrescisao SET rh05_motivo = 38 WHERE rh05_motivo IN (18,19,20);

        DELETE FROM rhmotivorescisao WHERE rh173_codigo IN ('18','19','20');
        ";
        $this->execute($sql);
    }

    public function down()
    {

    }
}
