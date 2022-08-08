<?php

use Phinx\Migration\AbstractMigration;

class Updatesistem extends AbstractMigration
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

---------------------------------------------------------------------------------------------------------------
------------------------------------------- INICIO CONFIGURACAO ------------------------------------------------------
---------------------------------------------------------------------------------------------------------------

  -- avaliacaoquestionarioiterno
    DROP TABLE IF EXISTS configuracoes.avaliacaoquestionariointerno CASCADE;
    DROP SEQUENCE IF EXISTS configuracoes.avaliacaoquestionariointerno_db170_sequencial_seq;
  --

  -- avaliacaoquestionariomenu
    DROP TABLE IF EXISTS configuracoes.avaliacaoquestionariointernomenu CASCADE;
    DROP SEQUENCE IF EXISTS configuracoes.avaliacaoquestionariointernomenu_db171_sequencial_seq;
  --
  select fc_executa_ddl('ALTER TABLE avaliacaopergunta ALTER COLUMN db103_descricao TYPE varchar(200);');
---------------------------------------------------------------------------------------------------------------
--------------------------------------------- FIM CONFIGURACAO -------------------------------------------------------
---------------------------------------------------------------------------------------------------------------

SQL;

    $this->execute($sql);

    }
}
