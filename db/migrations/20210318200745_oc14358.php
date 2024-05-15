<?php

use Phinx\Migration\AbstractMigration;

class Oc14358 extends AbstractMigration
{
    
    public function up()
    {
        $sql = "
        UPDATE inssirf
        SET r33_tipoafastamentosicom = 8
        WHERE r33_nome ilike '%INSS%'
            AND r33_anousu = 2021
            AND r33_tipoafastamentosicom = 0
        ";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "
        UPDATE inssirf
        SET r33_tipoafastamentosicom = 0
        WHERE r33_nome ilike '%INSS%'
            AND r33_anousu = 2021
            AND r33_tipoafastamentosicom = 8
        ";
        $this->execute($sql);
    }
}
