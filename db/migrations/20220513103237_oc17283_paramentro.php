<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc17283Paramentro extends PostgresMigration
{
   /**
     * Change Method.
     */
    public function change()
    {
        $table = $this->table('empparametro', array('schema' => 'empenho'));
        $column = $table->hasColumn('e30_empordemcron');

        if (!$column) {

            $sqlInsert = "ALTER TABLE empparametro ADD COLUMN e30_empordemcron boolean default true;";

            $this->execute($sqlInsert);
        }
    }
}
