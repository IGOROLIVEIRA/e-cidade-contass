<?php

use Phinx\Migration\AbstractMigration;

class Oc16418 extends AbstractMigration
{
    public function up()
    {
        $this->criarMenu();
        $this->criarTabelaDIPR();
    }

    public function criarMenu() {

        $sql = <<<SQL
        BEGIN;
            
            INSERT INTO db_itensmenu VALUES
            ((select max(id_item) + 1 from db_itensmenu), 'DIPR - Dem. Inf. Previdenci�rias e Repasses', 'DIPR - Dem. Inf. Previdenci�rias e Repasses', ' ', 1, 1, 'DIPR - Dem. Inf. Previdenci�rias e Repasses', 't');
    
            INSERT INTO db_menu VALUES
            (3332, (select max(id_item) from db_itensmenu), 300, 209);
                    
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Cadastro Informa��es Previdenci�rias', 'Cadastro Informa��es Previdenci�rias', ' ', 1, 1, 'Cadastro Informa��es Previdenci�rias', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%DIPR - Dem. Inf. Previdenci�rias e Repasses%'), (select max(id_item) from db_itensmenu), 1, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Inclus�o', 'Inclus�o', 'con1_diprcadastro001.php', 1, 1, 'Inclus�o', 't');
                    
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Cadastro Informa��es Previdenci�rias%'), (select max(id_item) from db_itensmenu), 1, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Altera��o', 'Altera��o', 'con1_diprcadastro002.php', 1, 1, 'Altera��o', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Cadastro Informa��es Previdenci�rias%'), (select max(id_item) from db_itensmenu), 2, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Exclus�o', 'Exclus�o', 'con1_diprcadastro003.php', 1, 1, 'Exclus�o', 't');

            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Cadastro Informa��es Previdenci�rias%'), (select max(id_item) from db_itensmenu), 2, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Base de C�lculo da Contribui��o Previdenci�ria', 'Base de C�lculo da Contribui��o Previdenci�ria', ' ', 1, 1, 'Base de C�lculo da Contribui��o Previdenci�ria', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%DIPR - Dem. Inf. Previdenci�rias e Repasses%'), (select max(id_item) from db_itensmenu), 2, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Inclus�o', 'Inclus�o', 'con1_diprbaseprevidencia001.php', 1, 1, 'Inclus�o', 't');
                    
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Base de C�lculo da Contribui��o Previdenci�ria%'), (select max(id_item) from db_itensmenu), 1, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Altera��o', 'Altera��o', 'con1_diprbaseprevidencia002.php', 1, 1, 'Altera��o', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Base de C�lculo da Contribui��o Previdenci�ria%'), (select max(id_item) from db_itensmenu), 2, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Exclus�o', 'Exclus�o', 'con1_diprbaseprevidencia003.php', 1, 1, 'Exclus�o', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Base de C�lculo da Contribui��o Previdenci�ria%'), (select max(id_item) from db_itensmenu), 2, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Contribui��es Previdenci�rias Repassadas', 'Contribui��es Previdenci�rias Repassadas', ' ', 1, 1, 'Contribui��es Previdenci�rias Repassadas', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%DIPR - Dem. Inf. Previdenci�rias e Repasses%'), (select max(id_item) from db_itensmenu), 3, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Inclus�o', 'Inclus�o', 'con1_diprcontribuicao001.php', 1, 1, 'Inclus�o', 't');
                    
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Contribui��es Previdenci�rias Repassadas%'), (select max(id_item) from db_itensmenu), 1, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Altera��o', 'Altera��o', 'con1_diprcontribuicao002.php', 1, 1, 'Altera��o', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Contribui��es Previdenci�rias Repassadas%'), (select max(id_item) from db_itensmenu), 2, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Exclus�o', 'Exclus�o', 'con1_diprcontribuicao003.php', 1, 1, 'Exclus�o', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Contribui��es Previdenci�rias Repassadas%'), (select max(id_item) from db_itensmenu), 2, 209);

            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Dedu��es', 'Dedu��es', ' ', 1, 1, 'Dedu��es', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%DIPR - Dem. Inf. Previdenci�rias e Repasses%'), (select max(id_item) from db_itensmenu), 4, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Inclus�o', 'Inclus�o', 'con1_diprdeducoes001.php', 1, 1, 'Inclus�o', 't');
                    
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Dedu��es%'), (select max(id_item) from db_itensmenu), 1, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Altera��o', 'Altera��o', 'con1_diprdeducoes002.php', 1, 1, 'Altera��o', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Dedu��es%'), (select max(id_item) from db_itensmenu), 2, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Exclus�o', 'Exclus�o', 'con1_diprdeducoes003.php', 1, 1, 'Exclus�o', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Dedu��es%'), (select max(id_item) from db_itensmenu), 2, 209);

            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Aportes e Transfer�ncias de Recursos', 'Aportes e Transfer�ncias de Recursos', ' ', 1, 1, 'Dedu��es', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%DIPR - Dem. Inf. Previdenci�rias e Repasses%'), (select max(id_item) from db_itensmenu), 5, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Inclus�o', 'Inclus�o', 'con1_dipraportes001.php', 1, 1, 'Inclus�o', 't');
                    
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Aportes e Transfer�ncias de Recursos%'), (select max(id_item) from db_itensmenu), 1, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Altera��o', 'Altera��o', 'con1_dipraportes002.php', 1, 1, 'Altera��o', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Aportes e Transfer�ncias de Recursos%'), (select max(id_item) from db_itensmenu), 2, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Exclus�o', 'Exclus�o', 'con1_dipraportes003.php', 1, 1, 'Exclus�o', 't');
       
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Aportes e Transfer�ncias de Recursos%'), (select max(id_item) from db_itensmenu), 2, 209);
        COMMIT;

SQL;
        $this->execute($sql);
    }

    public function criarTabelaDIPR() {
        $sql = <<<SQL
            BEGIN;
            CREATE TABLE "contabilidade"."dirp" (
                "c236_coddirp" serial,
                "c236_massainstituida" bool,
                "c236_beneficiotesouro" bool,
                "c236_atonormativo" int8,
                "c236_exercicionormativo" int4,
                "c236_numcgm" int8,
                "c236_tipoorgao" int4,
                CONSTRAINT "dirpcgm_numcgm_fk" FOREIGN KEY ("c236_numcgm") REFERENCES "protocolo"."cgm"("z01_numcgm"),
                PRIMARY KEY ("c236_coddirp")
            );
            COMMIT;
SQL;
        $this->execute($sql);
    }
}
