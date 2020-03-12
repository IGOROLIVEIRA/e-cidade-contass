<?php

use Phinx\Migration\AbstractMigration;

class Oc11285 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
        
        BEGIN;
        
        ALTER TABLE dadoscomplementareslrf ADD column c218_vldotinicialincentivocontrib float8 NOT NULL default 0;
        ALTER TABLE dadoscomplementareslrf ADD column c218_vldotincentconcedinstfinanc float8 NOT NULL default 0;
        ALTER TABLE dadoscomplementareslrf ADD column c218_vlajustesrelativosrpps float8 NOT NULL default 0;
        
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c218_vldotinicialincentivocontrib', 'float8', 'Valor dot. inicial de incent. contrib.', false, 'Valor dot. inicial de incent. contrib.', 1, false, false, false, 5, 'text', 'c218_vldotinicialincentivocontrib');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c218_vldotinicialincentivocontrib'), 8, 0);         
        UPDATE db_syscampo SET descricao='Valor dot. inicial de incent. contrib.', rotulo='Valor dot. inicial de incent. contrib.', rotulorel= 'Valor dot. inicial de incent. contrib.' WHERE nomecam LIKE '%c218_vldotinicialincentivocontrib%';
        
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c218_vldotincentconcedinstfinanc', 'float8', 'Valor dot. incentivo conc. inst. financ', false, 'Valor dot. incentivo conc. inst. financ', 1, false, false, false, 5, 'text', 'c218_vldotincentconcedinstfinanc');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c218_vldotincentconcedinstfinanc'), 8, 0);
        UPDATE db_syscampo SET descricao='Valor dot. incentivo conc. inst. financ', rotulo='Valor dot. incentivo conc. inst. financ', rotulorel= 'Valor dot. incentivo conc. inst. financ' WHERE nomecam LIKE '%c218_vldotincentconcedinstfinanc%';
        
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c218_vlajustesrelativosrpps', 'float8', 'Valor de ajustes relativos ao rpps', false, 'Valor de ajustes relativos ao rpps', 1, false, false, false, 5, 'text', 'c218_vlajustesrelativosrpps');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c218_vlajustesrelativosrpps'), 8, 0);         
        UPDATE db_syscampo SET descricao='Valor de ajustes relativos ao rpps', rotulo='Valor de ajustes relativos ao rpps', rotulorel= 'Valor de ajustes relativos ao rpps' WHERE nomecam LIKE '%c218_vlajustesrelativosrpps%';
        
        DROP TABLE dclrf402020;
        DROP TABLE dclrf302020;
        DROP TABLE dclrf202020;
        DROP TABLE dclrf112020;
        DROP TABLE dclrf102020;
        
        CREATE TABLE dclrf102020 (
            si157_sequencial bigint DEFAULT 0 NOT NULL,
            si157_tiporegistro bigint DEFAULT 0 NOT NULL,
            si157_codorgao character varying(2) NOT NULL,
            si157_passivosreconhecidos double precision DEFAULT 0 NOT NULL,
            si157_vlsaldoatualconcgarantiainterna double precision DEFAULT 0 NOT NULL,
            si157_vlsaldoatualconcgarantia double precision DEFAULT 0 NOT NULL,
            si157_vlsaldoatualcontragarantiainterna double precision DEFAULT 0 NOT NULL,
            si157_vlsaldoatualcontragarantiaexterna double precision DEFAULT 0 NOT NULL,
            si157_medidascorretivas character varying(4000),
            si157_recalieninvpermanente double precision DEFAULT 0 NOT NULL,
            si157_vldotinicialincentcontrib double precision DEFAULT 0 NOT NULL,
            si157_vldotatualizadaincentcontrib double precision DEFAULT 0 NOT NULL,
            si157_vlempenhadoicentcontrib double precision DEFAULT 0 NOT NULL,
            si157_vldotinicialincentinstfinanc double precision DEFAULT 0 NOT NULL,
            si157_vldotatualizadaincentinstfinanc double precision DEFAULT 0 NOT NULL,
            si157_vlempenhadoincentinstfinanc double precision DEFAULT 0 NOT NULL,
            si157_vlliqincentcontrib double precision DEFAULT 0 NOT NULL,
            si157_vlliqincentinstfinanc double precision DEFAULT 0 NOT NULL,
            si157_vlirpnpincentcontrib double precision DEFAULT 0 NOT NULL,
            si157_vlirpnpincentinstfinanc double precision DEFAULT 0 NOT NULL,
            si157_vlapropiacaodepositosjudiciais double precision DEFAULT 0 NOT NULL,
            si157_vlajustesrelativosrpps double precision DEFAULT 0 NOT NULL,
            si157_vloutrosajustes double precision DEFAULT 0 NOT NULL,
            si157_metarrecada bigint DEFAULT 0 NOT NULL,
            si157_mes bigint DEFAULT 0 NOT NULL,
            si157_instit bigint DEFAULT 0
        );

        CREATE TABLE dclrf112020 (
            si205_sequencial bigint DEFAULT 0 NOT NULL,
            si205_tiporegistro bigint DEFAULT 0 NOT NULL,
            si205_medidasadotadas bigint DEFAULT 0 NOT NULL,
            si205_dscmedidasadotadas character varying(4000),
            si205_reg10 bigint DEFAULT 0 NOT NULL,
            si205_mes bigint DEFAULT 0 NOT NULL,
            si205_instit bigint DEFAULT 0 NOT NULL
        );

        CREATE TABLE dclrf202020 (
            si191_sequencial bigint DEFAULT 0 NOT NULL,
            si191_tiporegistro bigint DEFAULT 0 NOT NULL,
            si191_contopcredito bigint DEFAULT 0 NOT NULL,
            si191_dsccontopcredito character varying(1000) DEFAULT 0,
            si191_realizopcredito bigint DEFAULT 0 NOT NULL,
            si191_tiporealizopcreditocapta bigint DEFAULT 0,
            si191_tiporealizopcreditoreceb bigint DEFAULT 0,
            si191_tiporealizopcreditoassundir bigint DEFAULT 0,
            si191_tiporealizopcreditoassunobg bigint DEFAULT 0,
            si191_reg10 bigint DEFAULT 0 NOT NULL,
            si191_mes bigint DEFAULT 0 NOT NULL,
            si191_instit bigint DEFAULT 0 NOT NULL
        );

        CREATE TABLE dclrf302020 (
            si192_sequencial bigint NOT NULL,
            si192_tiporegistro integer NOT NULL,
            si192_publiclrf integer NOT NULL,
            si192_dtpublicacaorelatoriolrf date,
            si192_localpublicacao character varying(1000),
            si192_tpbimestre integer,
            si192_exerciciotpbimestre integer,
            si192_reg10 bigint DEFAULT 0 NOT NULL,
            si192_mes bigint DEFAULT 0 NOT NULL,
            si192_instit bigint DEFAULT 0 NOT NULL
        );

        CREATE TABLE dclrf402020 (
            si193_sequencial bigint NOT NULL,
            si193_tiporegistro integer NOT NULL,
            si193_publicrgf integer NOT NULL,
            si193_dtpublicacaorgf date,
            si193_localpublicacaorgf character varying(1000),
            si193_tpperiodo integer,
            si193_exerciciotpperiodo integer,
            si193_reg10 bigint DEFAULT 0 NOT NULL,
            si193_mes bigint DEFAULT 0 NOT NULL,
            si193_instit bigint DEFAULT 0 NOT NULL
        );
        
        COMMIT;
SQL;
        $this->execute($sql);
    }
}
