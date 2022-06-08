<?php

use Phinx\Migration\AbstractMigration;

class Oc15877DadosExercicioAnterior extends AbstractMigration
{
    public function up()
    {
        $sql  ="INSERT INTO configuracoes.db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'dadosexercicioanterior', 'Dados Exercicio Anterior', 'c235', '2021-11-19', 'Dados Exercicio Anterior', 0, false, false, false, false);";
        $sql .="INSERT INTO configuracoes.db_sysarqmod (codmod, codarq) VALUES (32, (select max(codarq) from db_sysarquivo));";
        $sql .="INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c235_sequencial', 'int8', 'Sequencial', '0', 'Sequencial', 11, false, false, false, 1, 'text', 'Sequencial');";
        $sql .="INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c235_anousu', 'int8', 'Ano Referência', '0', 'Ano Referência', 4, false, false, false, 1, 'text', 'Ano Referência');";
        $sql .="INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c235_superavit_fundeb_permitido', 'float8', 'Valor do superávit do Fundeb permitido', '0', 'Valor do superávit do Fundeb permitido', 20, false, false, false, 4, 'text', 'Valor do superávit do Fundeb permitido');";
        $sql .="INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c235_naoaplicfundebimposttransf', 'float8', 'Valor não aplicado do Fundeb - Impostos e Transf. de Impostos', '0', 'Valor não Aplic. do Fundeb - Impost. e Transf. Imp', 20, false, false, false, 4, 'text', 'Valor Não Aplic. Fundeb - Impost/Transf');";
        $sql .="INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c235_naoaplicfundebcompl', 'float8', 'Valor não aplicado do Fundeb - Complementação da União - VAAT', '0', 'Valor não aplic. Fundeb - Comple VAAT', 20, false, false, false, 4, 'text', 'Valor não aplic. Fundeb - Comple VAAT');";
        $sql .="INSERT INTO configuracoes.db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'dadosexercicioanterior_c235_sequencial_seq', 1, 1, 9223372036854775807, 1, 1); ";
        $sql .="INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'dadosexercicioanterior'), (select codcam from db_syscampo where nomecam = 'c235_sequencial'), 1, (select codsequencia from db_syssequencia where nomesequencia = 'dadosexercicioanterior_c235_sequencial_seq') ); ";
        $sql .="INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'dadosexercicioanterior'), (select codcam from db_syscampo where nomecam = 'c235_anousu'), 2, 0);";
        $sql .="INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'dadosexercicioanterior'), (select codcam from db_syscampo where nomecam = 'c235_superavit_fundeb_permitido'), 4, 0);";
        $sql .="INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'dadosexercicioanterior'), (select codcam from db_syscampo where nomecam = 'c235_naoaplicfundebimposttransf'), 3, 0);";
        $sql .="INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'dadosexercicioanterior'), (select codcam from db_syscampo where nomecam = 'c235_naoaplicfundebcompl'), 5, 0);";
        $sql .="INSERT INTO configuracoes.db_sysprikey (codarq, codcam, sequen, referen, camiden) VALUES ((select codarq from db_sysarquivo where nomearq = 'dadosexercicioanterior'), (select codcam from db_syscampo where nomecam = 'c235_sequencial'), 1, (select codcam from db_syscampo where nomecam = 'c235_sequencial'), 0);";

        $sql .= " CREATE SEQUENCE dadosexercicioanterior_c235_sequencial_seq ;";
        $sql .= " CREATE TABLE dadosexercicioanterior( ";
        $sql .= " c235_sequencial		int8 NOT NULL default 0, ";
        $sql .= " c235_anousu		int8 NOT NULL default 0, ";
        $sql .= " c235_naoaplicfundebimposttransf		float8 NOT NULL default 0, ";
        $sql .= " c235_superavit_fundeb_permitido		float8 NOT NULL default 0, ";
        $sql .= " c235_naoaplicfundebcompl		float8 default 0, ";
        $sql .= " CONSTRAINT dadosexercicioanterior_sequ_pk PRIMARY KEY (c235_sequencial)); ";

        $this->execute($sql);
    }

    public function down()
    {
        $sql = "DROP TABLE IF EXISTS dadosexercicioanterior CASCADE;";
        $sql .= "DROP SEQUENCE IF EXISTS dadosexercicioanterior_c235_sequencial_seq;";
        $this->execute($sql);
    }
}
