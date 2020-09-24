<?php

use Phinx\Migration\AbstractMigration;

class Oc13285 extends AbstractMigration
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
    $sql = "ALTER TABLE public.aoc102020 ALTER COLUMN si38_nrodecreto TYPE varchar(8) USING si38_nrodecreto::varchar;
            ALTER TABLE public.aoc112020 ALTER COLUMN si39_nrodecreto TYPE varchar(8) USING si39_nrodecreto::varchar;";

    $this->execute($sql);

  }

  public function down()
  {
    $sql = "ALTER TABLE public.aoc102020 ALTER COLUMN si38_nrodecreto TYPE varchar(8) USING si38_nrodecreto::varchar;
            ALTER TABLE public.aoc112020 ALTER COLUMN si39_nrodecreto TYPE varchar(8) USING si39_nrodecreto::varchar;";
    $this->execute($sql);
  }
}
