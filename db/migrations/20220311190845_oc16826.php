<?php

use Phinx\Migration\AbstractMigration;

class Oc16826 extends AbstractMigration
{
    public function up()
    {

        $sql = <<<SQL

        BEGIN;

        SELECT fc_startsession();
       
        UPDATE db_itensmenu
				SET descricao = 'Anexo III (Fundeb) (até 2020)',
    				help = 'Anexo III (Fundeb) (até 2020)',
    				desctec = 'Anexo III (Fundeb) (até 2020)'
				WHERE id_item = (select id_item from db_itensmenu where descricao = 'ANEXO III (FUNDEB) ');
		
        UPDATE db_itensmenu
				SET descricao = 'Anexo I Educação (até 2021)',
    				help = 'Anexo I Educação (até 2021)',
    				desctec = 'Anexo I Educação (até 2021)'
				WHERE id_item = (select id_item from db_itensmenu where descricao = 'ANEXO I Educação');
			
        UPDATE db_itensmenu
				SET descricao = 'Anexo II Educação (até 2021)',
    				help = 'Anexo II Educação (até 2021)',
    				desctec = 'Anexo II Educação (até 2021)'
				WHERE id_item = (select id_item from db_itensmenu where descricao = 'ANEXO II Educação');
				
        UPDATE db_itensmenu
				SET descricao = 'Balanço Orçamentário'
				WHERE id_item = (select id_item from db_itensmenu where descricao = 'Exercício 2015' and help = 'Balanço Orçamentário do DCASP - Exercício 2015');


        COMMIT;

SQL;
        $this->execute($sql);
    } 
}

