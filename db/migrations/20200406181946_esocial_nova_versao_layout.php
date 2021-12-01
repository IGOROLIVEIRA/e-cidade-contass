<?php

use Classes\PostgresMigration;

class EsocialNovaVersaoLayout extends PostgresMigration
{

    public function up()
    {
        $versao = $this->fetchRow("SELECT rh210_versao FROM recursoshumanos.esocialversao WHERE rh210_versao = '2.4'");
        if (empty($versao['rh210_versao'])) {
            $this->execute("INSERT INTO recursoshumanos.esocialversao (rh210_versao) VALUES ('2.4')");
        }
    }

    public function down()
    {
        $this->execute("DELETE FROM recursoshumanos.esocialversao WHERE rh210_versao = '2.4'");
    }
}
