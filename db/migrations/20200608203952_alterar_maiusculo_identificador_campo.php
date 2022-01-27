<?php

use Classes\PostgresMigration;

class AlterarMaiusculoIdentificadorCampo extends PostgresMigration
{

    public function up()
    {
        $sSql  = "UPDATE db_syscampo SET maiusculo = 'f'  WHERE nomecam = 'db102_identificadorcampo';";
        $sSql .= "UPDATE db_syscampo SET maiusculo = 'f'  WHERE nomecam = 'db103_identificadorcampo';";
        $sSql .= "UPDATE db_syscampo SET maiusculo = 'f'  WHERE nomecam = 'db104_identificadorcampo';";
        $this->execute($sSql);
    }

    public function down()
    {
        $sSql  = "UPDATE db_syscampo SET maiusculo = 't'  WHERE nomecam = 'db102_identitcadorcampo';";
        $sSql .= "UPDATE db_syscampo SET maiusculo = 't'  WHERE nomecam = 'db103_identiftcadorcampo';";
        $sSql .= "UPDATE db_syscampo SET maiusculo = 't'  WHERE nomecam = 'db104_identificadorcampo';";
        $this->execute($sSql);
    }
}
