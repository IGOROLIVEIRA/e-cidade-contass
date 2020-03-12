<?php

use Phinx\Migration\AbstractMigration;

class Oc11837 extends AbstractMigration
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

            --tabela acordos
            ALTER TABLE acordo ADD COLUMN ac16_tipocadastro int8;
            ALTER TABLE contratos102020 ADD COLUMN si83_tipocadastro int8;

            UPDATE acordo set ac16_tipocadastro = 1;

            --tabela contratos112020
            ALTER TABLE contratos112020 ADD COLUMN si84_tipomaterial int8;
            ALTER TABLE contratos112020 ADD COLUMN si84_coditemsinapi varchar(15);
            ALTER TABLE contratos112020 ADD COLUMN si84_coditemsimcro varchar(15);
            ALTER TABLE contratos112020 ADD COLUMN si84_descoutrosmateriais varchar(250);
            ALTER TABLE contratos112020 ADD COLUMN si84_itemplanilha int8;
            ALTER TABLE contratos112020 ALTER COLUMN si84_tipomaterial SET DEFAULT 0;
            ALTER TABLE contratos112020 ALTER COLUMN si84_itemplanilha SET DEFAULT 0;

            --tabela contratos212020

            ALTER TABLE contratos212020 ADD COLUMN si88_tipomaterial int8;
            ALTER TABLE contratos212020 ADD COLUMN si88_coditemsinapi varchar(15);
            ALTER TABLE contratos212020 ADD COLUMN si88_coditemsimcro varchar(15);
            ALTER TABLE contratos212020 ADD COLUMN si88_descoutrosmateriais varchar(250);
            ALTER TABLE contratos212020 ADD COLUMN si88_itemplanilha int8;
            ALTER TABLE contratos212020 ALTER COLUMN si88_tipomaterial SET DEFAULT 0;
            ALTER TABLE contratos212020 ALTER COLUMN si88_itemplanilha SET DEFAULT 0;

            COMMIT;
SQL;
     $this->execute($sql);
    }
}
