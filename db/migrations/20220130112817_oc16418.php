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
                    INSERT INTO db_syscampo VALUES ((select max(codcam) + 1 from db_syscampo), 'c236_coddirp', 'int8', 'C�digo DIRP', '0', 'C�digo DIRP', 11, false, false, false, 5, 'text', 'C�digo DIRP');
                    
                    INSERT INTO db_syscampo VALUES ((select max(codcam) + 1 from db_syscampo), 'c236_massainstituida', 'bool', 'Massa institu�da?', '0', 'Massa institu�da?', 1, false, false, false, 5, 'text', 'Massa institu�da?');

                    INSERT INTO db_syscampo VALUES ((select max(codcam) + 1 from db_syscampo), 'c236_beneficiotesouro', 'bool',
                    'Benefici�rio tesouro?', '0', 'Benefici�rio tesouro?', 1, false, false, false, 1, 'text', 'Benefici�rio tesouro?');

                    INSERT INTO db_syscampo VALUES ((select max(codcam) + 1 from db_syscampo), 'c236_atonormativo', 'int8', 'Ato Normativo', '0', 'Ato Normativo', 6, false, false, false, 1, 'text', 'Ato Normativo');

                    INSERT INTO db_syscampo VALUES ((select max(codcam) + 1 from db_syscampo), 'c236_exercicionormativo','int4', 'Exerc�cio Ato Normativo', '0', 'Exerc�cio Ato Normativo', 4, false, false, false, 1, 'text', 'Exerc�cio Ato Normativo');

                    INSERT INTO db_syscampo VALUES ((select max(codcam) + 1 from db_syscampo), 'c236_numcgmexecutivo', 'int8', 'Administra��o Direta Executivo', '0', 'Administra��o Direta Executivo', 11, false, false, false, 1, 'text', 'Administra��o Direta Executivo');

                    INSERT INTO db_syscampo VALUES ((select max(codcam) + 1 from db_syscampo), 'c236_numcgmlegislativo', 'int8', 'Administra��o Direta Legislativo', '0', 'Administra��o Direta Legislativo', 11, false, false, false, 1, 'text', 'Administra��o Direta Legislativo');

                    INSERT INTO db_syscampo VALUES ((select max(codcam) + 1 from db_syscampo), 'c236_numcgmgestora', 'int8', 'Unidade Gestora', '0', 'Unidade Gestora', 11, false, false, false, 1, 'text', 'Unidade Gestora');

                    INSERT INTO db_syscampo VALUES ((select max(codcam) + 1 from db_syscampo), 'c236_orgao', 'int', 'Org�o', '0', 'Org�o', 5, false, false, false, 1, 'text', 'Org�o');
                COMMIT;
SQL;
        $this->execute($sql);
    }
}
