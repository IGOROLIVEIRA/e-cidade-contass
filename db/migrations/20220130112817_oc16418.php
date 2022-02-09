<?php

use Phinx\Migration\AbstractMigration;

class Oc16418 extends AbstractMigration
{
    public function up()
    {
        $this->criarMenu();
        $this->criarTabelaDIPR();
        $this->criarCampos();
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
                CREATE SEQUENCE dipr_c236_coddipr_seq;

                CREATE TABLE "contabilidade"."dipr" (
                    "c236_coddipr" int4 NOT NULL DEFAULT nextval('dipr_c236_coddipr_seq'::regclass),
                    "c236_massainstituida" bool,
                    "c236_beneficiotesouro" bool,
                    "c236_atonormativo" int8,
                    "c236_exercicionormativo" int4,
                    "c236_numcgmexecutivo" int8,
                    "c236_numcgmlegislativo" int8,
                    "c236_numcgmgestora" int8,
                    "c236_orgao" int4,
                    CONSTRAINT "diprcgmgestora_numcgm_fk" FOREIGN KEY ("c236_numcgmgestora") REFERENCES "protocolo"."cgm"("z01_numcgm"),
                    CONSTRAINT "diprcgmlegislativo_numcgm_fk" FOREIGN KEY ("c236_numcgmlegislativo") REFERENCES "protocolo"."cgm"("z01_numcgm"),
                    CONSTRAINT "diprcgmexecutivo_numcgm_fk" FOREIGN KEY ("c236_numcgmexecutivo") REFERENCES "protocolo"."cgm"("z01_numcgm"),
                    PRIMARY KEY ("c236_coddipr")
                );

                CREATE SEQUENCE diprbasecontribuicao_c237_sequencial_seq;

                CREATE TABLE "contabilidade"."diprbasecontribuicao" (
                    "c237_sequencial" int4 NOT NULL DEFAULT nextval('diprbasecontribuicao_c237_sequencial_seq'::regclass),
                    "c237_coddipr" int8,
                    "c237_datasicom" date,
                    "c237_basecalculocontribuinte" int4,
                    "c237_exerciciocompetencia" int4,
                    "c237_tipofundo" int4,
                    "c237_remuneracao" numeric,
                    "c237_basecalculoorgao" int4,
                    "c237_valorbasecalculo" numeric,
                    "c237_tipocontribuinte" int4,
                    "c237_aliquota" numeric,
                    "c237_valorcontribuicao" numeric,
                    CONSTRAINT "diprbasecontribuicao_dipr_fk" FOREIGN KEY ("c237_coddipr") REFERENCES "contabilidade"."dipr"("c236_coddipr"),
                    PRIMARY KEY ("c237_sequencial")
                );

                CREATE SEQUENCE diprbaseprevidencia_c238_sequencial_seq;

                CREATE TABLE "contabilidade"."diprbaseprevidencia" (
                    "c238_sequencial" int4 NOT NULL DEFAULT nextval('diprbaseprevidencia_c238_sequencial_seq'::regclass),
                    "c238_coddipr" int8,
                    "c238_datasicom" date,
                    "c238_mescompetencia" int4,
                    "c238_exerciciocompetencia" int4,
                    "c238_tipofundo" int4,
                    "c238_tiporepasse" int4,
                    "c238_tipocontribuicaopatronal" int4,
                    "c238_tipocontribuicaosegurados" int4,
                    "c238_tipocontribuicao" int4,
                    "c238_datarepasse" date,
                    "c238_datavencimentorepasse" date,
                    "c238_valororiginal" numeric,
                    "c238_valororiginalrepassado" numeric,
                    CONSTRAINT "diprbaseprevidencia_dipr_fk" FOREIGN KEY ("c238_coddipr") REFERENCES "contabilidade"."dipr"("c236_coddipr"),
                    PRIMARY KEY ("c238_sequencial")
                );

                CREATE SEQUENCE  diprdeducoes_c239_sequencial_seq;

                CREATE TABLE "contabilidade"."diprdeducoes" (
                    "c239_sequencial" int4 NOT NULL DEFAULT nextval('diprdeducoes_c239_sequencial_seq'::regclass),
                    "c239_coddipr" int8,
                    "c239_datasicom" date,
                    "c239_mescompetencia" int4,
                    "c239_exerciciocompetencia" int4,
                    "c239_tipofundo" int4,
                    "c239_tiporepasse" int4,
                    "c239_tipocontribuicaopatronal" int4,
                    "c239_tipocontribuicaosegurados" int4,
                    "c239_tipodeducao" int4,
                    "c239_descricao" text,
                    "c239_valordeducao" numeric,
                    CONSTRAINT "diprdeducoes_dipr_fk" FOREIGN KEY ("c239_coddipr") REFERENCES "contabilidade"."dipr"("c236_coddipr"),
                    PRIMARY KEY ("c239_sequencial")
                );

                CREATE SEQUENCE dipraportes_c240_sequencial_seq;

                CREATE TABLE "contabilidade"."dipraportes" (
                    "c240_sequencial" int4 NOT NULL DEFAULT nextval('dipraportes_c240_sequencial_seq'::regclass),
                    "c240_coddipr" int8,
                    "c240_datasicom" date,
                    "c240_mescompetencia" int4,
                    "c240_exerciciocompetencia" int4,
                    "c240_tipofundo" int4,
                    "c240_tipoaporte" int4,
                    "c240_tipocontribuicaopatronal" int4,
                    "c240_descricao" text,
                    "c240_atonormativo" int4,
                    "c240_exercicioatonormativo" int4,
                    "c240_valoraporte" numeric,
                    CONSTRAINT "dipraportes_dipr_fk" FOREIGN KEY ("c240_coddipr") REFERENCES "contabilidade"."dipr"("c236_coddipr"),
                    PRIMARY KEY ("c240_sequencial")
                );
            COMMIT;
SQL;
        $this->execute($sql);
    }

    public function criarCampos()
    {
        $sql = <<<SQL
                BEGIN;
                    INSERT INTO db_syscampo VALUES ((select max(codcam) + 1 from db_syscampo), 'c236_coddirp', 'int8', 'Código DIRP', '0', 'Código DIRP', 11, false, false, false, 5, 'text', 'Código DIRP');
                    
                    INSERT INTO db_syscampo VALUES ((select max(codcam) + 1 from db_syscampo), 'c236_massainstituida', 'bool', 'Massa instituída?', '0', 'Massa instituída?', 1, false, false, false, 5, 'text', 'Massa instituída?');

                    INSERT INTO db_syscampo VALUES ((select max(codcam) + 1 from db_syscampo), 'c236_beneficiotesouro', 'bool',
                    'Beneficiário tesouro?', '0', 'Beneficiário tesouro?', 1, false, false, false, 1, 'text', 'Beneficiário tesouro?');

                    INSERT INTO db_syscampo VALUES ((select max(codcam) + 1 from db_syscampo), 'c236_atonormativo', 'int8', 'Ato Normativo', '0', 'Ato Normativo', 6, false, false, false, 1, 'text', 'Ato Normativo');

                    INSERT INTO db_syscampo VALUES ((select max(codcam) + 1 from db_syscampo), 'c236_exercicionormativo','int4', 'Exercício Ato Normativo', '0', 'Exercício Ato Normativo', 4, false, false, false, 1, 'text', 'Exercício Ato Normativo');

                    INSERT INTO db_syscampo VALUES ((select max(codcam) + 1 from db_syscampo), 'c236_numcgmexecutivo', 'int8', 'Administração Direta Executivo', '0', 'Administração Direta Executivo', 11, false, false, false, 1, 'text', 'Administração Direta Executivo');

                    INSERT INTO db_syscampo VALUES ((select max(codcam) + 1 from db_syscampo), 'c236_numcgmlegislativo', 'int8', 'Administração Direta Legislativo', '0', 'Administração Direta Legislativo', 11, false, false, false, 1, 'text', 'Administração Direta Legislativo');

                    INSERT INTO db_syscampo VALUES ((select max(codcam) + 1 from db_syscampo), 'c236_numcgmgestora', 'int8', 'Unidade Gestora', '0', 'Unidade Gestora', 11, false, false, false, 1, 'text', 'Unidade Gestora');

                    INSERT INTO db_syscampo VALUES ((select max(codcam) + 1 from db_syscampo), 'c236_orgao', 'int', 'Orgão', '0', 'Orgão', 5, false, false, false, 1, 'text', 'Orgão');
                COMMIT;
SQL;
        $this->execute($sql);
    }
}
