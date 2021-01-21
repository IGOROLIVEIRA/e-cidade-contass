<?php

use Phinx\Migration\AbstractMigration;

class Oc13602 extends AbstractMigration
{
  public function up()
  {
    $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu),'Metas Fiscais', 'Metas Fiscais','con4_metasfiscais.php',1,1,'Metas Fiscais','true');

        INSERT INTO db_menu VALUES (32, (select max(id_item) from db_itensmenu), (select max(menusequencia) from db_menu where id_item = 32 and modulo = 116)+1, 116);


        --DROP TABLE:
        DROP TABLE IF EXISTS mtfis_anexo CASCADE;
        DROP TABLE IF EXISTS mtfis_ldo CASCADE;
        --Criando drop sequences
        DROP SEQUENCE IF EXISTS mtfis_ldo_mtfis_sequencial_seq;
        DROP SEQUENCE IF EXISTS mtfis_anexo_mtfisanexo_sequencial_seq;


        -- Criando  sequences
        CREATE SEQUENCE mtfis_ldo_mtfis_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;

        CREATE SEQUENCE mtfis_anexo_mtfisanexo_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;


        -- TABELAS E ESTRUTURA

        -- Módulo: orcamento
        CREATE TABLE mtfis_anexo(
        mtfisanexo_sequencial		int4 NOT NULL default 0,
        mtfisanexo_especificacao		varchar(255) NOT NULL ,
        mtfisanexo_valorcorrente1		float4 default 0,
        mtfisanexo_valorcorrente2		float4 default 0,
        mtfisanexo_valorcorrente3		float4  default 0,
        mtfisanexo_valorconstante1		float4 default 0,
        mtfisanexo_valorconstante2		float4 default 0,
        mtfisanexo_valorconstante3		float4 default 0,
        mtfisanexo_ldo		int4 default 0,
        CONSTRAINT mtfis_anexo_sequ_pk PRIMARY KEY (mtfisanexo_sequencial));


        -- Módulo: orcamento
        CREATE TABLE mtfis_ldo(
        mtfis_sequencial		int4 default 0,
        mtfis_anoinicialldo		int4 default 0,
        mtfis_pibano1		float4 default 0,
        mtfis_pibano2		float4 default 0,
        mtfis_pibano3		float4 default 0,
        mtfis_rclano1		float4 default 0,
        mtfis_rclano2		float4 default 0,
        mtfis_rclano3		float4 default 0,
        mtfis_instit		int4 default 0,
        CONSTRAINT mtfis_ldo_sequ_pk PRIMARY KEY (mtfis_sequencial));




        -- CHAVE ESTRANGEIRA


        ALTER TABLE mtfis_anexo
        ADD CONSTRAINT mtfis_anexo_ldo_fk FOREIGN KEY (mtfisanexo_ldo)
        REFERENCES mtfis_ldo;




        -- INDICES


        CREATE  INDEX mtfisanexo_ldo_indice ON mtfis_anexo(mtfisanexo_ldo);


        COMMIT;

SQL;
    $this->execute($sql);

  }
}
