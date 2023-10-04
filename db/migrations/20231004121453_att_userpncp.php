<?php

use Phinx\Migration\AbstractMigration;

class AttUserpncp extends AbstractMigration
{
    public function up()
    {
        $sql = "
            update licitaparam set l12_loginpncp='80eecdba-9ba5-4a88-aa64-5cade9718f0c',l12_passwordpncp='VXA0x9G4JfgGva1I';
        ";
        $this->execute($sql);
    }
}
