<?php

use Phinx\Migration\AbstractMigration;

class Oc21264v3 extends AbstractMigration
{
    public function up()
    {
        // Inserindo menu:
        // Mod Empenho - Relatórios - Relatórios de Conferência - EFD-Reinf R-4000
        $sqlCreateMenu = "SELECT fc_startsession();

                        INSERT INTO db_itensmenu
                        VALUES (
                                    (SELECT max(id_item)+1 FROM db_itensmenu),
                                    'EFD-Reinf R-4000',
                                    'EFD-Reinf R-4000',
                                    'emp2_r4000efdreinf001.php',
                                    1,
                                    1,
                                    '',
                                    't'
                                );
                        
                        
                        INSERT INTO db_menu
                        VALUES (
                                  (SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Relatorio de Conferencia'),
                            
                                  (SELECT max(id_item) FROM db_itensmenu),
                            
                                  (SELECT max(menusequencia)+1 FROM db_menu
                                   WHERE id_item = (SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Relatorio de Conferencia')
                                     AND modulo = 398),
                            
                                  398
                                )";

        $this->execute($sqlCreateMenu);
    }
}
