<?php

use Phinx\Migration\AbstractMigration;

class CorrigeCodAfastamento extends AbstractMigration
{

    public function up()
    {
        $sql = "
        UPDATE afasta SET r45_mesmadoenca = 'N' WHERE r45_codigoafasta IS NULL;
        
        UPDATE afasta SET r45_codigoafasta = (
            CASE WHEN r45_situac IN (2,4,7,9) THEN '05'
            WHEN r45_situac = 5 THEN '17'
            WHEN r45_situac IN (6,8,10) THEN '03'
            WHEN r45_situac = 11 THEN '13'
            WHEN r45_situac = 13 THEN '10'
            WHEN r45_situac = 3 THEN '01'
            END
            )
        WHERE r45_codigoafasta IS NULL
        ";

        $this->execute($sql);
    }

    public function down()
    {

    }
}
