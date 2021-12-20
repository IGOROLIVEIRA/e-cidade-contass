<?php

use Phinx\Migration\AbstractMigration;

class TributarioVinculoItbiArrecad extends AbstractMigration
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
    public function change()
    {

        $sSQL = <<<SQL

        SELECT fc_startsession();

        CREATE TABLE IF NOT EXISTS caixa.arrecad_itbi
        (
            k00_numpre integer NOT NULL,
            it01_guia bigint NOT NULL,
            CONSTRAINT fk_arrecaditbi_it01_guia FOREIGN KEY (it01_guia)
                REFERENCES itbi.itbi (it01_guia)
        );

SQL;

        $this->execute($sSQL);

    }
}
