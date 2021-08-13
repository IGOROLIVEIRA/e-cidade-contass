<?php

use Phinx\Migration\AbstractMigration;

class AddColumn extends AbstractMigration
{
    /**
     * Change Method.
     */
    public function change()
    {
        $table = $this->table('ordembancariapagamento');
        $column = $table->hasColumn('k00_dtvencpag');

        if (!$column) {

            $sqlInsert = "ALTER TABLE ordembancariapagamento ADD COLUMN k00_dtvencpag DATE";

            $this->execute($sqlInsert);
        }
    }
}
