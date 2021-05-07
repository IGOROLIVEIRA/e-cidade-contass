<?php

use Phinx\Migration\AbstractMigration;

class Oc14395 extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $sql = <<<SQL
        
        BEGIN;

        SELECT fc_startsession();

            -- Table: licobras102021
            
            DROP TABLE licobras102021;
            
            CREATE TABLE licobras102021
            (
              si195_sequencial bigint,
              si195_tiporegistro bigint,
              si195_codorgaoresp character varying(3),
              si195_codunidadesubrespestadual character varying(4),
              si195_exerciciolicitacao bigint,
              si195_nroprocessolicitatorio character varying(12),
              si195_codobra bigint,
              si195_objeto text,
              si195_linkobra text,
              si195_nrolote bigint,
              si195_nrocontrato bigint,
              si195_exerciciocontrato bigint,
              si195_dataassinatura date,
              si195_vlcontrato numeric,
              si195_undmedidaprazoexecucao bigint,
              si195_prazoexecucao bigint,
              si195_mes bigint,
              si195_instit integer
            )
            WITH (
              OIDS=TRUE
            );
            ALTER TABLE licobras102021
              OWNER TO dbportal;
            
            
            -- Table: licobras202021
            
            DROP TABLE licobras202021;
            
            CREATE TABLE licobras202021
            (
              si196_sequencial bigint,
              si196_tiporegistro bigint,
              si196_codorgaoresp character varying(3),
              si196_codunidadesubrespestadual character varying(4),
              si196_exerciciolicitacao bigint,
              si196_nroprocessolicitatorio character varying(12),
              si196_tipoprocesso integer,
              si196_codobra bigint,
              si196_objeto text,
              si196_linkobra text,
              si196_nrocontrato bigint,
              si196_exerciciocontrato bigint,
              si196_dataassinatura date,
              si196_vlcontrato numeric,
              si196_undmedidaprazoexecucao bigint,
              si196_prazoexecucao bigint,
              si196_mes bigint,
              si196_instit integer
            )
            WITH (
              OIDS=TRUE
            );
            ALTER TABLE licobras202021
              OWNER TO dbportal;
            
            
            -- Table: licobras302021
            
            DROP TABLE if exists licobras302021;
            
            CREATE TABLE licobras302021
            (
              si203_sequencial bigint,
              si203_tiporegistro bigint,
              si203_codorgaoresp character varying(3),
              si203_codobra bigint,
              si203_codunidadesubrespestadual character varying(4),
              si203_nroseqtermoaditivo bigint,
              si203_dataassinaturatermoaditivo date,
              si203_tipoalteracaovalor integer,
              si203_tipotermoaditivo character varying(2),
              si203_dscalteracao text,
              si203_novadatatermino date,
              si203_tipodetalhamento bigint,
              si203_valoraditivo numeric,
              si203_mes bigint,
              si203_instit integer
            )
            WITH (
              OIDS=TRUE
            );
            ALTER TABLE licobras302021
              OWNER TO dbportal;
            
            -- cria sequencia da tabela
            
            CREATE SEQUENCE licobras302021_si203_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;
            
            
            -- Table: exeobras102020
            
            DROP TABLE if exists exeobras102021;
            
            CREATE TABLE exeobras102021
            (
              si197_sequencial bigint,
              si197_tiporegistro bigint,
              si197_codorgao character varying(3),
              si197_codunidadesub character varying(8),
              si197_nrocontrato bigint,
              si197_exerciciocontrato bigint,
              si197_exerciciolicitacao bigint,
              si197_nroprocessolicitatorio bigint,
              si197_nrolote bigint,
              si197_codobra bigint,
              si197_objeto text,
              si197_linkobra text,
              si197_mes bigint,
              si197_instit integer
            )
            WITH (
              OIDS=TRUE
            );
            ALTER TABLE exeobras102021
              OWNER TO dbportal;
            
            -- Table: exeobras202021
            
            DROP TABLE if exists exeobras202021;
            
            CREATE TABLE exeobras202021
            (
              si204_sequencial bigint,
              si204_tiporegistro bigint,
              si204_codorgao character varying(3),
              si204_codunidadesub character varying(8),
              si204_nrocontrato bigint,
              si204_exerciciocontrato bigint,
              si204_exercicioprocesso bigint,
              si204_nroprocesso character varying(12),
              si204_tipoprocesso bigint,
              si204_codobra bigint,
              si204_objeto text,
              si204_linkobra text,
              si204_mes bigint,
              si204_instit integer
            )
            WITH (
              OIDS=TRUE
            );
            ALTER TABLE exeobras202021
              OWNER TO dbportal;
            
            
            -- Table: cadobras102021
            
            DROP TABLE cadobras102021;
            
            CREATE TABLE cadobras102021
            (
              si198_sequencial bigint,
              si198_tiporegistro bigint,
              si198_codorgaoresp character varying(3),
              si198_codobra bigint,
              si198_tiporesponsavel bigint,
              si198_nrodocumento character varying(14),
              si198_tiporegistroconselho bigint,
              si198_dscoutroconselho character varying(40),
              si198_nroregistroconseprof character varying(10),
              si198_numrt bigint DEFAULT 0,
              si198_dtinicioatividadeseng date,
              si198_tipovinculo bigint,
              si198_mes bigint,
              si198_instit integer
            )
            WITH (
              OIDS=TRUE
            );
            ALTER TABLE cadobras102021
              OWNER TO dbportal;
              
            --ALTERA TABELA licobrasresponsaveis
            
            ALTER TABLE licobrasresponsaveis ADD COLUMN obr05_dscoutroconselho varchar(40);
  
        COMMIT;

SQL;
        $this->execute($sql);

    }
}
