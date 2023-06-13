<?php

use Phinx\Migration\AbstractMigration;

class Oc19966 extends AbstractMigration
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
        $sql = "BEGIN;
        
        alter table liclicitemlote add l04_numerolote INT; 

        alter table licobras add obr01_licitacaolote INT;

        CREATE SEQUENCE liclicitemlote_l04_numerolote_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;

        CREATE TABLE acordoobra(
        obr08_sequencial         int8  default 0,
        obr08_licobras           int8  default 0,
        obr08_acordo             int8  default 0,
        obr08_acordoitem         int8  default 0,
        obr08_liclicitemlote     int8  default 0);


        CREATE SEQUENCE acordoobra_obr08_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;

        ALTER TABLE acordoobra ADD CONSTRAINT acordoobra_licobras_fk
        FOREIGN KEY (obr08_licobras) REFERENCES licobras (obr01_sequencial);

        ALTER TABLE acordoobra ADD CONSTRAINT acordoobra_acordo_fk
        FOREIGN KEY (obr08_acordo) REFERENCES acordo (ac16_sequencial);

        ALTER TABLE acordoobra ADD CONSTRAINT acordoobra_acordoitem_fk
        FOREIGN KEY (obr08_acordoitem) REFERENCES acordoitem (ac20_sequencial);
        
        COMMIT;";

        $this->execute($sql);

    }
}
