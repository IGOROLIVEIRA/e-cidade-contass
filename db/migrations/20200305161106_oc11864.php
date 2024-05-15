<?php

use Phinx\Migration\AbstractMigration;

class Oc11864 extends AbstractMigration
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
        ALTER TABLE cadobras102020 ALTER COLUMN si198_numrt SET DEFAULT 0;
        UPDATE acordo
            SET ac16_qtdperiodo =
            (SELECT abs((ac18_datainicio - ac18_datafim) / 30)
             FROM acordoposicao
             INNER JOIN acordovigencia ON ac18_acordoposicao = ac26_sequencial
             WHERE ac26_acordo = ac16_sequencial AND ac26_acordoposicaotipo = 1)
        FROM acordoposicao
        WHERE ac16_qtdperiodo IS NULL
            AND ac26_acordoposicaotipo = 1;
        COMMIT;

SQL;

    $this->execute($sql);
    }
}
