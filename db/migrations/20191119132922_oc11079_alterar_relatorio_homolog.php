<?php

use Phinx\Migration\AbstractMigration;

class Oc11079AlterarRelatorioHomolog extends AbstractMigration
{
    public function up()
    {   
        $sql = '
        UPDATE db_paragrafopadrao
        SET db61_texto = \'Homologa julgamento proferido pela Comissão de Licitação do processo licitatório Nº #$l20_edital#/#$l20_datacria# dando outras providências.\'
        WHERE db61_codparag = 349;

        UPDATE db_paragrafopadrao
        SET db61_texto = \'Fica homologado o julgamento proferido pela comissão de licitação, nomeada pela portaria Nº #$l30_portaria# sobre processo de licitação Nº #$l20_edital#/#$l20_datacria# que tem por objeto:\r
#$l20_objeto#\r                                                                                                                                                                                
        \r                                                                                                                                                                                             
        ITENS:\'
        WHERE db61_codparag = 350;'
        ;

        $this->execute($sql);

    }

    public function down()
    {

    }
}
