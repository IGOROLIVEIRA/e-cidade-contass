<?php

use Phinx\Migration\AbstractMigration;

class Notask extends AbstractMigration
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
            -- Table: contratos102020

            DROP TABLE contratos102020 CASCADE;

            CREATE TABLE contratos102020
            (
              si83_sequencial bigint NOT NULL DEFAULT 0,
              si83_tiporegistro bigint NOT NULL DEFAULT 0,
              si83_tipocadastro bigint,
              si83_codcontrato bigint NOT NULL DEFAULT 0,
              si83_codorgao character varying(2) NOT NULL,
              si83_codunidadesub character varying(8) NOT NULL,
              si83_nrocontrato bigint NOT NULL DEFAULT 0,
              si83_exerciciocontrato bigint NOT NULL DEFAULT 0,
              si83_dataassinatura date NOT NULL,
              si83_contdeclicitacao bigint NOT NULL DEFAULT 0,
              si83_codorgaoresp character varying(2),
              si83_codunidadesubresp character varying(8),
              si83_nroprocesso character varying(12),
              si83_exercicioprocesso bigint DEFAULT 0,
              si83_tipoprocesso bigint DEFAULT 0,
              si83_naturezaobjeto bigint NOT NULL DEFAULT 0,
              si83_objetocontrato character varying(500) NOT NULL,
              si83_tipoinstrumento bigint NOT NULL DEFAULT 0,
              si83_datainiciovigencia date NOT NULL,
              si83_datafinalvigencia date NOT NULL,
              si83_vlcontrato double precision NOT NULL DEFAULT 0,
              si83_formafornecimento character varying(50),
              si83_formapagamento character varying(100),
              si83_unidadedemedidaprazoexex bigint,
              si83_prazoexecucao int8,
              si83_multarescisoria character varying(100),
              si83_multainadimplemento character varying(100),
              si83_garantia bigint DEFAULT 0,
              si83_cpfsignatariocontratante character varying(11) NOT NULL,
              si83_datapublicacao date NOT NULL,
              si83_veiculodivulgacao character varying(50) NOT NULL,
              si83_mes bigint NOT NULL DEFAULT 0,
              si83_instit bigint DEFAULT 0,
              CONSTRAINT contratos102020_sequ_pk PRIMARY KEY (si83_sequencial)
            )
            WITH (
              OIDS=TRUE
            );
            ALTER TABLE contratos102020
              OWNER TO dbportal;


            -- Table: contratos112020

            DROP TABLE contratos112020;

            CREATE TABLE contratos112020
            (
              si84_sequencial bigint NOT NULL DEFAULT 0,
              si84_tiporegistro bigint NOT NULL DEFAULT 0,
              si84_codcontrato bigint NOT NULL DEFAULT 0,
              si84_coditem bigint NOT NULL DEFAULT 0,
              si84_tipomaterial bigint DEFAULT 0,
              si84_coditemsinapi character varying(15),
              si84_coditemsimcro character varying(15),
              si84_descoutrosmateriais character varying(250),
              si84_itemplanilha bigint DEFAULT 0,
              si84_quantidadeitem double precision NOT NULL DEFAULT 0,
              si84_valorunitarioitem double precision NOT NULL DEFAULT 0,
              si84_mes bigint NOT NULL DEFAULT 0,
              si84_reg10 bigint NOT NULL DEFAULT 0,
              si84_instit bigint DEFAULT 0,
              CONSTRAINT contratos112020_sequ_pk PRIMARY KEY (si84_sequencial),
              CONSTRAINT contratos112020_reg10_fk FOREIGN KEY (si84_reg10)
                  REFERENCES contratos102020 (si83_sequencial) MATCH SIMPLE
                  ON UPDATE NO ACTION ON DELETE NO ACTION
            )
            WITH (
              OIDS=TRUE
            );
            ALTER TABLE contratos112020
              OWNER TO dbportal;


            -- Table: contratos212020

            DROP TABLE contratos212020;

            CREATE TABLE contratos212020
            (
              si88_sequencial bigint NOT NULL DEFAULT 0,
              si88_tiporegistro bigint NOT NULL DEFAULT 0,
              si88_codaditivo bigint NOT NULL DEFAULT 0,
              si88_coditem bigint NOT NULL DEFAULT 0,
              si88_tipomaterial bigint DEFAULT 0,
              si88_coditemsinapi character varying(15),
              si88_coditemsimcro character varying(15),
              si88_descoutrosmateriais character varying(250),
              si88_itemplanilha bigint DEFAULT 0,
              si88_tipoalteracaoitem bigint NOT NULL DEFAULT 0,
              si88_quantacrescdecresc double precision NOT NULL DEFAULT 0,
              si88_valorunitarioitem double precision NOT NULL DEFAULT 0,
              si88_mes bigint NOT NULL DEFAULT 0,
              si88_reg20 bigint NOT NULL DEFAULT 0,
              si88_instit bigint DEFAULT 0,
              CONSTRAINT contratos212020_sequ_pk PRIMARY KEY (si88_sequencial),
              CONSTRAINT contratos212020_reg20_fk FOREIGN KEY (si88_reg20)
                  REFERENCES contratos202020 (si87_sequencial) MATCH SIMPLE
                  ON UPDATE NO ACTION ON DELETE NO ACTION
            )
            WITH (
              OIDS=TRUE
            );
            ALTER TABLE contratos212020
              OWNER TO dbportal;

            --coloca default 0 nos campos
              ALTER TABLE contratos112020 ALTER COLUMN si84_tipomaterial SET DEFAULT 0;
              ALTER TABLE contratos112020 ALTER COLUMN si84_itemplanilha SET DEFAULT 0;
              ALTER TABLE contratos212020 ALTER COLUMN si88_tipomaterial SET DEFAULT 0;
              ALTER TABLE contratos212020 ALTER COLUMN si88_itemplanilha SET DEFAULT 0;
              ALTER TABLE contratos102020 ALTER COLUMN si83_unidadedemedidaprazoexex SET DEFAULT 0;

            COMMIT;


SQL;

      $this->execute($sql);

    }
}
