<?php

use Phinx\Migration\AbstractMigration;

class Updatepcproc extends AbstractMigration
{

    public function up()
    {
        $sql = "
                    UPDATE pcproc
        SET pc80_dispvalor='f'
        WHERE pc80_codproc IN
                (SELECT pc80_codproc
                 FROM pcproc
                 WHERE pc80_dispvalor IS NULL);
        ";
        $this->execute($sql);
    }
}
