<?php

use Phinx\Migration\AbstractMigration;

class Oc21264relatoriodesc extends AbstractMigration
{
    public function up()
    {
        $sqlChangeName = "  SELECT fc_startsession();

                            UPDATE db_itensmenu
                            SET descricao = 'Relatórios de Conferência',
                                help = 'Relatório de Conferência do EFD-Reinf',
                                desctec = 'Relatório de Conferência do EFD-Reinf'
                            WHERE desctec = 'Reltatórios de Conferência do EFD-Reinf'";

        $this->execute($sqlChangeName);
    }
}
