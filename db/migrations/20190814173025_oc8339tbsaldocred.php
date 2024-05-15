<?php

use Phinx\Migration\AbstractMigration;

class Oc8339tbsaldocred extends AbstractMigration
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
        $sqltable = "
            CREATE TABLE licitacao.credenciamentosaldo
            (
              l213_sequencial integer NOT NULL DEFAULT 0,
              l213_licitacao integer NOT NULL DEFAULT 0,
              l213_item integer NOT NULL DEFAULT 0,
              l213_itemlicitacao integer NOT NULL DEFAULT 0,
              l213_qtdlicitada double precision DEFAULT 0,
              l213_qtdcontratada double precision DEFAULT 0,
              l213_contratado integer NOT NULL DEFAULT 0,
              l213_acordo integer NOT NULL DEFAULT 0,
              CONSTRAINT credenciamentosaldo_nume_pk PRIMARY KEY (l213_sequencial),
              CONSTRAINT credenciamentosaldo_lic_pk FOREIGN KEY (l213_licitacao)
                  REFERENCES licitacao.liclicita (l20_codigo)
            );

            CREATE SEQUENCE credenciamentosaldo_l213_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;
        ";
        $this->execute($sqltable);
    }

}
