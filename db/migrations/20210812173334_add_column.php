<?php

use Classes\PostgresMigration;

class AddColumn extends PostgresMigration
{
    /**
     * Change Method.
     */
    public function change()
    {
        $table = $this->table('ordembancariapagamento', array('schema' => 'caixa'));
        $column = $table->hasColumn('k00_dtvencpag');

        if (!$column) {

            $sqlInsert = "ALTER TABLE ordembancariapagamento ADD COLUMN k00_dtvencpag DATE";

            $this->execute($sqlInsert);
        }
    }
}
