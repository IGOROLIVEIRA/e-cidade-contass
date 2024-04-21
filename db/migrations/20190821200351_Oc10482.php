<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc10482 extends PostgresMigration
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
        $inssirf = $this->table('inssirf', array('schema' => 'pessoal'));
        $inssirf->addColumn('r33_tipoafastamentosicom', 'integer',array('default' => 0))
                ->update();

        $this->execute("UPDATE inssirf SET r33_tipoafastamentosicom = 8 WHERE r33_codtab = 3");
        $this->execute("UPDATE inssirf SET r33_tipoafastamentosicom = 7 WHERE r33_codtab != 3");

    }

}
