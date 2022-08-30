<?php

use Phinx\Migration\AbstractMigration;

class Oc18200 extends AbstractMigration
{
    public function up()
    {
        $sql = "INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Importação de Receitas', 'Importação de Receitas', 'cai1_planilhaimportacaoreceita001.php', 1, 1, 'Importação de Receitas', 't');
        INSERT INTO db_menu VALUES(9419, (select max(id_item) from db_itensmenu), 6, 39);
        
        INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Agentes Arrecadadores', 'Agentes Arrecadadores', '', 1, 1, 'Agentes Arrecadadores', 't');
        INSERT INTO db_menu VALUES(29, (select max(id_item) from db_itensmenu), 227, 39);
        
        INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Inclusão', 'Inclusão', 'con1_agentearrecadador001.php', 1, 1, 'Inclusão', 't');
        INSERT INTO db_menu VALUES ((select id_item from db_itensmenu WHERE descricao = 'Agentes Arrecadadores'), (select max(id_item) from db_itensmenu), 1, 39);
        
        INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Alteração', 'Alteração', 'con1_agentearrecadador002.php', 1, 1, 'Alteração', 't');
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu WHERE descricao = 'Agentes Arrecadadores'), (select max(id_item) from db_itensmenu), 2, 39);
        
        INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Exclusão', 'Exclusão', 'con1_agentearrecadador003.php', 1, 1, 'Exclusão', 't');
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu WHERE descricao = 'Agentes Arrecadadores'), (select max(id_item) from db_itensmenu), 3, 39);
        
        -- Criacao de sequenciais e tabela
        CREATE SEQUENCE agentearrecadador_k174_sequencial_seq;
        -- TABELAS E ESTRUTURA
        -- Módulo: caixa
        CREATE TABLE agentearrecadador(
            k174_sequencial int4 NOT NULL DEFAULT nextval('agentearrecadador_k174_sequencial_seq'::regclass),
            k174_codigobanco int4 NOT NULL default 0,
            k174_descricao text NOT NULL,
            k174_idcontabancaria int8 NOT NULL default 0,
            k174_numcgm int8 NOT NULL default 0,
            k174_instit int8 NOT NULL,
            CONSTRAINT uc_codigobanco UNIQUE (k174_codigobanco, k174_instit));

        -- Aumentando tamanho do campo para receber descricao do arquivo de importacao
        ALTER TABLE public.placaixaprocesso ALTER COLUMN k144_numeroprocesso SET DATA TYPE varchar(100);
        ALTER TABLE slipprocesso ALTER COLUMN k145_numeroprocesso SET DATA TYPE varchar(100);
        ";

        $this->execute($sql);
    } 

    public function down()
    {
        $sql = "DELETE FROM db_menu WHERE id_item_filho = (SELECT id_item FROM db_itensmenu WHERE funcao = 'cai1_planilhaimportacaoreceita001.php');
        DELETE FROM db_itensmenu WHERE funcao = 'cai1_planilhaimportacaoreceita001.php';

        DELETE FROM db_menu WHERE id_item_filho = (SELECT id_item FROM db_itensmenu WHERE funcao = 'con1_agentearrecadador001.php');
        DELETE FROM db_itensmenu WHERE funcao = 'con1_agentearrecadador001.php';

        DELETE FROM db_menu WHERE id_item_filho = (SELECT id_item FROM db_itensmenu WHERE funcao = 'con1_agentearrecadador002.php');
        DELETE FROM db_itensmenu WHERE funcao = 'con1_agentearrecadador002.php';

        DELETE FROM db_menu WHERE id_item_filho = (SELECT id_item FROM db_itensmenu WHERE funcao = 'con1_agentearrecadador003.php');
        DELETE FROM db_itensmenu WHERE funcao = 'con1_agentearrecadador003.php';

        DELETE FROM db_menu WHERE id_item_filho = (select id_item from db_itensmenu WHERE descricao = 'Agentes Arrecadadores');
        DELETE FROM db_itensmenu WHERE descricao = 'Agentes Arrecadadores';

        --DROP TABLE:
        DROP SEQUENCE IF EXISTS agentearrecadador_k174_sequencial_seq CASCADE;
        DROP TABLE IF EXISTS agentearrecadador CASCADE;
        ";

        $this->execute($sql);
    }
}
