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
            ((select max(id_item) + 1 from db_itensmenu), 'DIPR - Dem. Inf. Previdenciárias e Repasses', 'DIPR - Dem. Inf. Previdenciárias e Repasses', ' ', 1, 1, 'DIPR - Dem. Inf. Previdenciárias e Repasses', 't');
    
            INSERT INTO db_menu VALUES
            (3332, (select max(id_item) from db_itensmenu), 300, 209);
                    
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Cadastro Informações Previdenciárias', 'Cadastro Informações Previdenciárias', ' ', 1, 1, 'Cadastro Informações Previdenciárias', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%DIPR - Dem. Inf. Previdenciárias e Repasses%'), (select max(id_item) from db_itensmenu), 1, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Inclusão', 'Inclusão', 'con1_diprcadastro001.php', 1, 1, 'Inclusão', 't');
                    
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Cadastro Informações Previdenciárias%'), (select max(id_item) from db_itensmenu), 1, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Alteração', 'Alteração', 'con1_diprcadastro002.php', 1, 1, 'Alteração', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Cadastro Informações Previdenciárias%'), (select max(id_item) from db_itensmenu), 2, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Exclusão', 'Exclusão', 'con1_diprcadastro003.php', 1, 1, 'Exclusão', 't');

            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Cadastro Informações Previdenciárias%'), (select max(id_item) from db_itensmenu), 2, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Base de Cálculo da Contribuição Previdenciária', 'Base de Cálculo da Contribuição Previdenciária', ' ', 1, 1, 'Base de Cálculo da Contribuição Previdenciária', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%DIPR - Dem. Inf. Previdenciárias e Repasses%'), (select max(id_item) from db_itensmenu), 2, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Inclusão', 'Inclusão', 'con1_diprbaseprevidencia001.php', 1, 1, 'Inclusão', 't');
                    
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Base de Cálculo da Contribuição Previdenciária%'), (select max(id_item) from db_itensmenu), 1, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Alteração', 'Alteração', 'con1_diprbaseprevidencia002.php', 1, 1, 'Alteração', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Base de Cálculo da Contribuição Previdenciária%'), (select max(id_item) from db_itensmenu), 2, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Exclusão', 'Exclusão', 'con1_diprbaseprevidencia003.php', 1, 1, 'Exclusão', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Base de Cálculo da Contribuição Previdenciária%'), (select max(id_item) from db_itensmenu), 2, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Contribuições Previdenciárias Repassadas', 'Contribuições Previdenciárias Repassadas', ' ', 1, 1, 'Contribuições Previdenciárias Repassadas', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%DIPR - Dem. Inf. Previdenciárias e Repasses%'), (select max(id_item) from db_itensmenu), 3, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Inclusão', 'Inclusão', 'con1_diprcontribuicao001.php', 1, 1, 'Inclusão', 't');
                    
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Contribuições Previdenciárias Repassadas%'), (select max(id_item) from db_itensmenu), 1, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Alteração', 'Alteração', 'con1_diprcontribuicao002.php', 1, 1, 'Alteração', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Contribuições Previdenciárias Repassadas%'), (select max(id_item) from db_itensmenu), 2, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Exclusão', 'Exclusão', 'con1_diprcontribuicao003.php', 1, 1, 'Exclusão', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Contribuições Previdenciárias Repassadas%'), (select max(id_item) from db_itensmenu), 2, 209);

            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Deduções', 'Deduções', ' ', 1, 1, 'Deduções', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%DIPR - Dem. Inf. Previdenciárias e Repasses%'), (select max(id_item) from db_itensmenu), 4, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Inclusão', 'Inclusão', 'con1_diprdeducoes001.php', 1, 1, 'Inclusão', 't');
                    
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Deduções%'), (select max(id_item) from db_itensmenu), 1, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Alteração', 'Alteração', 'con1_diprdeducoes002.php', 1, 1, 'Alteração', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Deduções%'), (select max(id_item) from db_itensmenu), 2, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Exclusão', 'Exclusão', 'con1_diprdeducoes003.php', 1, 1, 'Exclusão', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Deduções%'), (select max(id_item) from db_itensmenu), 2, 209);

            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Aportes e Transferências de Recursos', 'Aportes e Transferências de Recursos', ' ', 1, 1, 'Deduções', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%DIPR - Dem. Inf. Previdenciárias e Repasses%'), (select max(id_item) from db_itensmenu), 5, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Inclusão', 'Inclusão', 'con1_dipraportes001.php', 1, 1, 'Inclusão', 't');
                    
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Aportes e Transferências de Recursos%'), (select max(id_item) from db_itensmenu), 1, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Alteração', 'Alteração', 'con1_dipraportes002.php', 1, 1, 'Alteração', 't');
            
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Aportes e Transferências de Recursos%'), (select max(id_item) from db_itensmenu), 2, 209);
            
            INSERT INTO db_itensmenu VALUES 
            ((select max(id_item) + 1 from db_itensmenu), 'Exclusão', 'Exclusão', 'con1_dipraportes003.php', 1, 1, 'Exclusão', 't');
       
            INSERT INTO db_menu VALUES
            ((select id_item from db_itensmenu where descricao like '%Aportes e Transferências de Recursos%'), (select max(id_item) from db_itensmenu), 2, 209);
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
